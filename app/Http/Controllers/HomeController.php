<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with hero sliders, brands, categories, latest and featured products.
     */
    public function index(Request $request)
    {
        $sliders = Slider::latest()->take(5)->get();
        $brands = Brand::withCount('products')->get();
        $categories = Category::withCount('products')->get();
        $latestProducts = Product::with(['brand', 'category'])->latest()->take(8)->get();
        $featuredProducts = Product::with(['brand', 'category'])->where('is_featured', true)->take(8)->get();

        if ($request->is('api/*') || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'sliders' => $sliders,
                    'brands' => $brands,
                    'categories' => $categories,
                    'latest_products' => $latestProducts,
                    'featured_products' => $featuredProducts,
                ],
            ]);
        }

        return view('pages.home', compact('sliders', 'brands', 'categories', 'latestProducts', 'featuredProducts'));
    }
}
