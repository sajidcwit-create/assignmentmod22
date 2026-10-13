<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display listing of previous orders for current authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to view order history.');
        }

        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $orders,
            ]);
        }

        return view('pages.orders.index', compact('orders'));
    }

    /**
     * Display details of a specific order.
     */
    public function show(Request $request, $id)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $order = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $order,
            ]);
        }

        return view('pages.orders.show', compact('order'));
    }
}
