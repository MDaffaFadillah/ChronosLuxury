<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display checkout confirmation page.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to complete your purchase.');
        }

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your boutique cart is empty. Please add items before checking out.');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Submit checkout booking inside a secure database transaction.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_address' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:500'
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        // Jalankan Database Transaction untuk menjaga integritas data stock
        try {
            DB::beginTransaction();

            $totalPrice = 0;
            $itemsToCreate = [];

            foreach ($cartItems as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}. We only have {$product->stock} left.");
                }

                // Kurangi stok produk
                $product->decrement('stock', $item->quantity);

                // Hitung subtotal
                $subtotal = $product->price * $item->quantity;
                $totalPrice += $subtotal;

                $itemsToCreate[] = [
                    'product_id' => $product->id,
                    'quantity' => $item->quantity,
                    'price' => $product->price
                ];
            }

            // Buat record Order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes
            ]);

            // Buat record detail OrderItem
            foreach ($itemsToCreate as $itemData) {
                $order->items()->create($itemData);
            }

            // Kosongkan keranjang belanja
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // Simpan ID Order di session untuk halaman success
            return redirect()->route('checkout.success')->with('success_order_id', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Purchase execution failed: ' . $e->getMessage());
        }
    }

    /**
     * Show ordering transaction success summary.
     */
    public function success()
    {
        $orderId = session('success_order_id');

        if (!$orderId) {
            return redirect()->route('products.index');
        }

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('checkout.success', compact('order'));
    }
}
