<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products with optional category, brand, and search filters.
     */
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'category']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->input('category'))
                  ->orWhere('id', $request->input('category'));
            });
        }

        if ($request->filled('brand')) {
            $query->whereHas('brand', function ($q) use ($request) {
                $q->where('slug', $request->input('brand'))
                  ->orWhere('id', $request->input('brand'));
            });
        }

        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $products,
            ]);
        }

        return view('pages.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Display the specified product details.
     */
    public function show(Request $request, $slug)
    {
        $product = Product::with(['brand', 'category'])->where('slug', $slug)->orWhere('id', $slug)->firstOrFail();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'product' => $product,
                    'related_products' => $relatedProducts,
                ],
            ]);
        }

        return view('pages.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Browse products filtered by category.
     */
    public function byCategory(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with(['brand', 'category'])
            ->where('category_id', $category->id)
            ->paginate(12);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'category' => $category,
                'data' => $products,
            ]);
        }

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'currentCategory' => $category,
        ]);
    }

    /**
     * Browse products filtered by brand.
     */
    public function byBrand(Request $request, $slug)
    {
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $products = Product::with(['brand', 'category'])
            ->where('brand_id', $brand->id)
            ->paginate(12);

        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'brand' => $brand,
                'data' => $products,
            ]);
        }

        return view('pages.products.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'currentBrand' => $brand,
        ]);
    }
}
