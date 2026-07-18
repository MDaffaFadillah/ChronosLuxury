<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access your boutique cart.');
        }

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to add timepieces to your cart.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Jika stock habis atau kurang
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', "Not enough stock available. Remaining stock: {$product->stock}");
        }

        // Cek jika sudah ada di cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->stock < $newQuantity) {
                return redirect()->back()->with('error', "Cannot add more. Remaining stock limit reached.");
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('cart.index')->with('success', "{$product->name} has been added to your cart.");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'quantity' => 'required|integer|min:grow'
        ]);

        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $product = $cartItem->product;

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', "Insufficient stock. Only {$product->stock} items available.");
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', "Cart updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItem = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $productName = $cartItem->product->name;
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', "{$productName} removed from cart.");
    }
}
