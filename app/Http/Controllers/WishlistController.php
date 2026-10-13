<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display the wishlist items for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Please login to view wishlist.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to view your wishlist.');
        }

        $wishlists = Wishlist::with(['product.brand', 'product.category'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $wishlists,
            ]);
        }

        return view('pages.wishlist.index', compact('wishlists'));
    }

    /**
     * Add product to wishlist.
     */
    public function add(Request $request)
    {
        $user = Auth::user() ?? $request->user();
        if (!$user) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json(['status' => 'error', 'message' => 'Please login to add to wishlist.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please login to add items to your wishlist.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->product_id;
        $product = Product::findOrFail($productId);

        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($exists) {
            if ($request->is('api/*') || $request->wantsJson()) {
                return response()->json([
                    'status' => 'info',
                    'message' => 'Product is already in your wishlist.',
                ]);
            }
            return back()->with('info', 'This product is already in your wishlist.');
        }

        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to wishlist.',
                'data' => $wishlist,
            ]);
        }

        return back()->with('status', '“' . $product->name . '” added to your wishlist!');
    }

    /**
     * Remove product from wishlist.
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

        $wishlist = Wishlist::where('user_id', $user->id)
            ->where(function ($q) use ($id) {
                $q->where('id', $id)->orWhere('product_id', $id);
            })
            ->firstOrFail();

        $wishlist->delete();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from wishlist.',
            ]);
        }

        return back()->with('status', 'Product removed from your wishlist.');
    }
}
