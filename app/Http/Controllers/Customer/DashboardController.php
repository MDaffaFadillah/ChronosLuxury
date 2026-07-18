<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show customer area statistical summary.
     */
    public function index()
    {
        $userId = Auth::id();

        $totalOrders = Order::where('user_id', $userId)->count();
        $pendingOrders = Order::where('user_id', $userId)->where('status', 'pending')->count();
        $processingOrders = Order::where('user_id', $userId)->where('status', 'processing')->count();
        $completedOrders = Order::where('user_id', $userId)->where('status', 'completed')->count();

        $totalSpend = Order::where('user_id', $userId)
            ->whereIn('status', ['processing', 'shipped', 'completed'])
            ->sum('total_price');

        // Mengambil pesanan terbaru
        $recentOrders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalSpend',
            'recentOrders'
        ));
    }
}
