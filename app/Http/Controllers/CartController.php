<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart items and totals.
     */
    public function index(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Please login to view cart.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to view your shopping cart.');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', $user->id)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $tax = $subtotal * 0.05; // 5% VAT/Tax
        $shipping = $subtotal > 0 ? ($subtotal > 1000 ? 0 : 50) : 0;
        $total = $subtotal + $tax + $shipping;

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'items' => $cartItems,
                    'subtotal' => round($subtotal, 2),
                    'tax' => round($tax, 2),
                    'shipping' => round($shipping, 2),
                    'total' => round($total, 2),
                ],
            ]);
        }

        return view('pages.cart.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Please login to add products to cart.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to add products to your cart.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->input('quantity', 1);

        $price = $product->discount_price && $product->discount_price > 0 
            ? $product->discount_price 
            : $product->price;

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $qty;
            $cartItem->price = $price;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $price,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully.',
                'cart_item' => $cartItem,
            ]);
        }

        return back()->with('status', '“' . $product->name . '” added to cart successfully!');
    }

    /**
     * Update quantity of a cart item.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:50',
        ]);

        $cartItem = CartItem::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully.',
                'cart_item' => $cartItem,
            ]);
        }

        return back()->with('status', 'Cart quantity updated.');
    }

    /**
     * Remove product from cart.
     */
    public function remove(Request $request, $id)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $cartItem = CartItem::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $cartItem->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Item removed from cart.',
            ]);
        }

        return back()->with('status', 'Item removed from cart.');
    }
}
