<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of all boutique orders.
     */
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     */
    public function show($id)
    {
        $order = Order::with('items.product.category', 'user')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status in storage with safety rules.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Aturan Keamanan 1: Jika sudah selesai (completed) atau dibatalkan (cancelled), status tidak dapat dikembalikan
        if (in_array($oldStatus, ['completed', 'cancelled']) && $newStatus !== $oldStatus) {
            return redirect()->back()->with('error', "Cannot change status once an order is '{$oldStatus}'.");
        }

        try {
            DB::beginTransaction();

            $order->update(['status' => $newStatus]);

            // Aturan Keamanan 2: Jika dibatalkan (cancelled), kembalikan stok jam tangan ke database (Safety restore stock!)
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                foreach ($order->items as $item) {
                    $product = Product::findOrFail($item->product_id);
                    $product->increment('stock', $item->quantity);
                }
            }

            DB::commit();
            return redirect()->back()->with('success', "Order status successfully updated to '{$newStatus}'.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Status update failed: ' . $e->getMessage());
        }
    }
}
