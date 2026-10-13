<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Show Checkout page.
     */
    public function showCheckout(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to proceed to checkout.');
        }

        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add products before checkout.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $tax = $subtotal * 0.05;
        $shipping = $subtotal > 1000 ? 0 : 50;
        $total = $subtotal + $tax + $shipping;

        return view('pages.checkout.index', compact('user', 'cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Process Checkout & Initiate SSLCommerz Demo Payment Gateway.
     */
    public function initiatePayment(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
        ]);

        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Cart is empty.'], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        $tax = $subtotal * 0.05;
        $shipping = $subtotal > 1000 ? 0 : 50;
        $total = $subtotal + $tax + $shipping;

        $orderNumber = 'ORD-' . strtoupper(Str::random(10));
        $transactionId = 'SSLCZ_TXN_' . strtoupper(Str::random(12));

        // Create pending order inside database transaction
        $order = DB::transaction(function () use ($user, $request, $orderNumber, $transactionId, $total, $cartItems) {
            $newOrder = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'total_amount' => $total,
                'payment_method' => 'SSLCOMMERZ (Sandbox Demo)',
                'payment_status' => 'Pending',
                'order_status' => 'Processing',
                'transaction_id' => $transactionId,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'city' => $request->city,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'unit_price' => $item->price,
                    'quantity' => $item->quantity,
                    'line_total' => $item->price * $item->quantity,
                ]);
            }

            return $newOrder;
        });

        // SSLCommerz payment gateway simulation page
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Order initiated successfully. Redirecting to SSLCommerz gateway.',
                'order' => $order,
                'payment_gateway_url' => route('checkout.sslcommerz', ['transaction_id' => $transactionId]),
            ]);
        }

        return redirect()->route('checkout.sslcommerz', ['transaction_id' => $transactionId]);
    }

    /**
     * Display SSLCommerz Demo Payment Gateway Gateway Portal.
     */
    public function sslcommerzGateway(Request $request, $transactionId)
    {
        $order = Order::with('items')->where('transaction_id', $transactionId)->firstOrFail();
        return view('pages.checkout.sslcommerz', compact('order'));
    }

    /**
     * SSLCommerz Demo Payment Gateway Callback (Success).
     */
    public function paymentSuccess(Request $request)
    {
        $tranId = $request->input('tran_id');
        $order = Order::where('transaction_id', $tranId)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'Completed',
                'order_status' => 'Processing',
            ]);

            // Clear User's Cart
            CartItem::where('user_id', $order->user_id)->delete();

            return redirect()->route('orders.show', $order->id)
                ->with('status', 'Payment successful via SSLCommerz! Order #' . $order->order_number . ' placed.');
        }

        return redirect()->route('home')->with('error', 'Payment transaction not found.');
    }

    /**
     * SSLCommerz Demo Payment Gateway Callback (Fail).
     */
    public function paymentFail(Request $request)
    {
        $tranId = $request->input('tran_id');
        $order = Order::where('transaction_id', $tranId)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'Failed',
                'order_status' => 'Cancelled',
            ]);

            return redirect()->route('cart.index')
                ->with('error', 'Payment failed for order #' . $order->order_number . '. Please try again.');
        }

        return redirect()->route('cart.index')->with('error', 'Payment failed.');
    }

    /**
     * SSLCommerz Demo Payment Gateway Callback (Cancel).
     */
    public function paymentCancel(Request $request)
    {
        $tranId = $request->input('tran_id');
        $order = Order::where('transaction_id', $tranId)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'Cancelled',
                'order_status' => 'Cancelled',
            ]);

            return redirect()->route('cart.index')
                ->with('info', 'Payment was cancelled for order #' . $order->order_number . '.');
        }

        return redirect()->route('cart.index')->with('info', 'Payment was cancelled.');
    }
}
