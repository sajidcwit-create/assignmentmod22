<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Demo Users
        $demoUser = User::create([
            'name' => 'John Doe',
            'email' => 'user@example.com',
            'phone' => '+8801712345678',
            'address' => 'House 42, Road 11, Banani',
            'city' => 'Dhaka',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Demo Customer',
            'email' => 'customer@example.com',
            'phone' => '+8801812345678',
            'address' => 'GEC Circle, Nasirabad',
            'city' => 'Chittagong',
            'password' => Hash::make('password123'),
        ]);

        // 2. Sliders
        $sliders = [
            [
                'title' => 'Mega Electronics Bonanza',
                'short_description' => 'Up to 40% discount on flagship smartphones, laptops, and smart gadgets.',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=1200&auto=format&fit=crop&q=80',
                'link' => '/products',
            ],
            [
                'title' => 'Summer Fashion Trends 2026',
                'short_description' => 'Discover the finest summer apparel, shoes, and timeless lifestyle accessories.',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1200&auto=format&fit=crop&q=80',
                'link' => '/category/fashion',
            ],
            [
                'title' => 'Smart Living & Audio Gear',
                'short_description' => 'Premium noise-canceling headphones, smart watches, and home studio sound.',
                'image' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=1200&auto=format&fit=crop&q=80',
                'link' => '/category/electronics',
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }

        // 3. Brands
        $brandsData = [
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'image' => 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Sony',
                'slug' => 'sony',
                'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Dell',
                'slug' => 'dell',
                'image' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Logitech',
                'slug' => 'logitech',
                'image' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=300&auto=format&fit=crop&q=80',
            ],
        ];

        $brandMap = [];
        foreach ($brandsData as $b) {
            $brandMap[$b['slug']] = Brand::create($b);
        }

        // 4. Categories
        $categoriesData = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'image' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Computers & Laptops',
                'slug' => 'computers-laptops',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Audio & Sound',
                'slug' => 'audio-sound',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Fashion & Footwear',
                'slug' => 'fashion',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=300&auto=format&fit=crop&q=80',
            ],
            [
                'name' => 'Wearables',
                'slug' => 'wearables',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300&auto=format&fit=crop&q=80',
            ],
        ];

        $categoryMap = [];
        foreach ($categoriesData as $c) {
            $categoryMap[$c['slug']] = Category::create($c);
        }

        // 5. Products
        $productsData = [
            [
                'brand_id' => $brandMap['apple']->id,
                'category_id' => $categoryMap['smartphones']->id,
                'name' => 'Apple iPhone 16 Pro Max',
                'slug' => 'apple-iphone-16-pro-max',
                'image' => 'https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&auto=format&fit=crop&q=80',
                'price' => 1199.00,
                'discount_price' => 1099.00,
                'short_description' => 'Titanium design with A18 Pro chip, 48MP Fusion camera system, and all-day battery life.',
                'description' => 'The iPhone 16 Pro Max features a strong and light titanium design with smooth contoured edges, a new Action button, and a powerful camera system that delivers next-generation portraits and cinematic video recording.',
                'is_featured' => true,
                'stock' => 50,
            ],
            [
                'brand_id' => $brandMap['apple']->id,
                'category_id' => $categoryMap['computers-laptops']->id,
                'name' => 'MacBook Pro 16" M3 Max',
                'slug' => 'macbook-pro-16-m3-max',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=600&auto=format&fit=crop&q=80',
                'price' => 2499.00,
                'discount_price' => 2349.00,
                'short_description' => 'Unprecedented power with Liquid Retina XDR display, up to 128GB unified memory.',
                'description' => 'Built for extreme workflows, MacBook Pro with M3 Max blazes through 3D rendering, machine learning modeling, and 8K video processing without breaking a sweat.',
                'is_featured' => true,
                'stock' => 25,
            ],
            [
                'brand_id' => $brandMap['sony']->id,
                'category_id' => $categoryMap['audio-sound']->id,
                'name' => 'Sony WH-1000XM5 Wireless Headphones',
                'slug' => 'sony-wh-1000xm5-wireless-headphones',
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
                'price' => 399.00,
                'discount_price' => 349.00,
                'short_description' => 'Industry-leading noise cancellation with two processors and 8 microphones.',
                'description' => 'Magnificent sound engineered to perfection. The Integrated Processor V1 unlocks the full potential of Sony’s HD Noise Cancelling Processor QN1 for pristine audio immersion.',
                'is_featured' => true,
                'stock' => 75,
            ],
            [
                'brand_id' => $brandMap['samsung']->id,
                'category_id' => $categoryMap['smartphones']->id,
                'name' => 'Samsung Galaxy S24 Ultra',
                'slug' => 'samsung-galaxy-s24-ultra',
                'image' => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&auto=format&fit=crop&q=80',
                'price' => 1299.00,
                'discount_price' => 1149.00,
                'short_description' => 'Galaxy AI is here. 200MP camera, built-in S Pen, and titanium frame.',
                'description' => 'Meet Galaxy S24 Ultra with durable titanium exterior, flat 6.8-inch Dynamic AMOLED 2X display, generative AI photo assistance, and incredible zoom capabilities.',
                'is_featured' => true,
                'stock' => 40,
            ],
            [
                'brand_id' => $brandMap['nike']->id,
                'category_id' => $categoryMap['fashion']->id,
                'name' => 'Nike Air Max 270 React',
                'slug' => 'nike-air-max-270-react',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&auto=format&fit=crop&q=80',
                'price' => 160.00,
                'discount_price' => 135.00,
                'short_description' => 'Max Air 270 unit delivers all-day comfort with bold contemporary styling.',
                'description' => 'Nike’s first lifestyle Air Max shoe brings you style, comfort and big attitude in the Nike Air Max 270. The design draws inspiration from Air Max icons with lightweight, layered materials.',
                'is_featured' => false,
                'stock' => 80,
            ],
            [
                'brand_id' => $brandMap['dell']->id,
                'category_id' => $categoryMap['computers-laptops']->id,
                'name' => 'Dell XPS 15 InfinityEdge Laptop',
                'slug' => 'dell-xps-15-infinityedge-laptop',
                'image' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=600&auto=format&fit=crop&q=80',
                'price' => 1899.00,
                'discount_price' => 1749.00,
                'short_description' => 'High-performance 13th Gen Intel Core i7 with stunning OLED 3.5K display.',
                'description' => 'The Dell XPS 15 is meticulously crafted with CNC machined aluminum and aerospace-inspired carbon fiber, packing serious desktop-grade performance into an ultra-thin chassis.',
                'is_featured' => false,
                'stock' => 30,
            ],
            [
                'brand_id' => $brandMap['logitech']->id,
                'category_id' => $categoryMap['electronics']->id,
                'name' => 'Logitech MX Master 3S Wireless Mouse',
                'slug' => 'logitech-mx-master-3s',
                'image' => 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=600&auto=format&fit=crop&q=80',
                'price' => 99.00,
                'discount_price' => null,
                'short_description' => 'Quiet clicks, 8K DPI track-on-glass sensor, and ergonomic electromagnetic scroll wheel.',
                'description' => 'Feel every single moment of your workflow with even more precision, tactility, and performance, thanks to Quiet Clicks and an 8,000 DPI track-on-glass optical sensor.',
                'is_featured' => false,
                'stock' => 120,
            ],
            [
                'brand_id' => $brandMap['apple']->id,
                'category_id' => $categoryMap['wearables']->id,
                'name' => 'Apple Watch Ultra 2 GPS + Cellular',
                'slug' => 'apple-watch-ultra-2',
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&auto=format&fit=crop&q=80',
                'price' => 799.00,
                'discount_price' => 749.00,
                'short_description' => 'Rugged 49mm titanium case, precision dual-frequency GPS, 3000 nits display.',
                'description' => 'The most rugged and capable Apple Watch pushes the limits again. Featuring the all-new S9 SiP, a magical new double tap gesture, and a brighter display for outdoor adventures.',
                'is_featured' => true,
                'stock' => 35,
            ],
        ];

        foreach ($productsData as $prod) {
            Product::create($prod);
        }
    }
}
