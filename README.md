# E-Commerce Web Application (Laravel & MySQL / SQLite)

A modern, full-featured E-Commerce Web Application developed with **Laravel 12**, **MySQL / SQLite**, **Blade Components & Tailwind CSS**, **OTP-based Authentication (Laravel Sanctum)**, and a **Demo SSLCommerz Payment Gateway**.

---

## 🎥 Project Presentation Video (Max 3–3.5 Mins)
- **Video Link (Google Drive / YouTube):** `[INSERT YOUR VIDEO LINK HERE]`
  *(Replace this link with your recorded video walkthrough link explaining all features and modules)*

---

## 🌟 Assignment Features & Modules

### 1. Database Architecture & Relationships (10 Tables)
The database schema is fully relational and normalized with foreign key constraints and cascade rules:
- **`users`**: Customer accounts, profiles, phone numbers, and addresses.
- **`otp_verifications`**: OTP authentication store with expiry time and usage state tracking.
- **`brands`**: Manufacturer / brand listings (`Apple`, `Samsung`, `Sony`, `Nike`, `Dell`, `Logitech`).
- **`categories`**: Product classifications (`Electronics`, `Smartphones`, `Computers & Laptops`, `Audio & Sound`, `Fashion`, `Wearables`).
- **`sliders`**: Hero banner promotions on the home page.
- **`products`**: Products with prices, discount pricing, stock levels, brand & category relations.
- **`wishlists`**: User-saved favorite items (`user_id`, `product_id`).
- **`cart_items`**: Shopping cart records with quantity, product pricing, and subtotal calculation.
- **`orders`**: Customer invoices, delivery destinations, and SSLCommerz transaction logs.
- **`order_items`**: Line items of each order with snapshot price, quantity, and product details.

---

### 2. Functional Modules Implemented

#### 🏠 Home Page
- **Hero Slider**: Dynamic promotional banners with responsive call-to-action buttons.
- **Category List**: Browse categories with live item counters.
- **Brand Showcase**: Global brand partners with direct product filtering.
- **Featured Products**: Highlighted curated products with quick cart/wishlist actions.
- **Latest Products**: Fresh arrivals automatically ordered by newest release.

#### 🛍️ Product Module
- **Product Catalog (`/products`)**: Filter by category, brand, search keyword, and sort by price (Low/High) or newest.
- **Product Details (`/products/{slug}`)**: Full specification details, stock indicators, quantity selector, and related category products.
- **Brand Filtering (`/brand/{slug}`)**: Dedicated brand-specific landing views.
- **Category Filtering (`/category/{slug}`)**: Dedicated category-specific product views.

#### 🔐 User Authentication (OTP-Based & Sanctum)
- **OTP Generation & Verification**: Passwordless login sending a 6-digit verification code.
- **Laravel Sanctum Token Support**: Issues secure API Bearer tokens upon successful OTP verification.
- **Profile Management (`/profile`)**: Manage personal details, phone numbers, delivery addresses, and view customer order metrics.
- **Logout**: Invalidate web sessions and revoke Sanctum tokens.

#### 🛒 Shopping Cart
- **Add to Cart**: Add items with custom quantities and discount calculation.
- **Update Quantity**: Dynamic quantity increment/decrement.
- **Remove Items**: Instant removal with recalculation of subtotals.
- **Cart Totals**: Transparent computation of subtotal, 5% estimated VAT, and shipping (Free shipping on orders over $1,000).

#### ❤️ Wishlist
- **Add to Wishlist**: Save favorite items without cluttering the cart.
- **Remove from Wishlist**: Delete items from wishlist.
- **Move to Cart**: 1-click transfer from wishlist directly to cart.

#### 💳 Checkout & Demo SSLCommerz Payment Gateway
- **Checkout Page (`/checkout`)**: Shipping address confirmation and invoice breakdown.
- **SSLCommerz Hosted Simulator (`/checkout/sslcommerz/{transaction_id}`)**:
  - Simulates payment gateway redirection with real transaction references.
  - Interactive callbacks for **Success** (instant order confirmation & cart clear), **Failure**, and **Cancellation**.
- **Order Creation**: Atomic DB transactions ensuring data integrity.

#### 📦 Order History
- **Order History Listing (`/orders`)**: Paginated list of past orders with timestamps, order numbers, and live payment status badges (`Paid`, `Pending`, `Failed`).
- **Order Invoice Details (`/orders/{id}`)**: Full invoice breakdown with line items, delivery details, and printable invoice support.

---

## 🚀 Installation & Local Setup

### Prerequisites
- PHP >= 8.2 (with `pdo`, `pdo_mysql` or `pdo_sqlite`, `curl`, `mbstring`)
- Composer
- Git

### Step-by-Step Setup

1. **Clone the repository:**
   ```bash
   git clone <YOUR_GITHUB_REPO_URL>
   cd Assignment
   ```

2. **Install Composer dependencies:**
   ```bash
   composer install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration:**
   - For **MySQL**, update `.env` with your MySQL database credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=ecommerce_db
     DB_USERNAME=root
     DB_PASSWORD=
     ```
   - For **SQLite** (plug-and-play without MySQL server):
     ```env
     DB_CONNECTION=sqlite
     ```

5. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```
   *This creates all 10 tables and populates sample brands, categories, sliders, products, and demo accounts.*

6. **Start the Development Server:**
   ```bash
   php artisan serve
   ```
   Open your browser and navigate to: `http://127.0.0.1:8000`

---

## 🔑 Demo Login Accounts

| Email | OTP Passcode | Role |
|---|---|---|
| `user@example.com` | Generated automatically on screen / logs | Demo Customer |
| `customer@example.com` | Generated automatically on screen / logs | Demo Customer |

> **Note:** Any valid email address can be entered on the login page; the system will generate a fresh 6-digit OTP code and display it directly on the verification screen for seamless testing.

---

## 📡 RESTful API Endpoints (Sanctum)

| Method | Endpoint | Description | Auth Required |
|---|---|---|---|
| `GET` | `/api/home` | Sliders, categories, brands, latest & featured products | No |
| `GET` | `/api/products` | Paginated product list with search/filter | No |
| `GET` | `/api/products/{slug}` | Product details and related products | No |
| `POST` | `/api/auth/send-otp` | Request OTP code (`email`) | No |
| `POST` | `/api/auth/verify-otp` | Verify OTP code & obtain Sanctum Bearer Token | No |
| `GET` | `/api/auth/profile` | View profile and user statistics | Yes (Bearer) |
| `GET` | `/api/cart` | View cart items and cost totals | Yes (Bearer) |
| `POST` | `/api/cart/add` | Add product to cart | Yes (Bearer) |
| `PUT` | `/api/cart/{id}` | Update item quantity | Yes (Bearer) |
| `DELETE` | `/api/cart/{id}` | Remove item from cart | Yes (Bearer) |
| `GET` | `/api/wishlist` | View user's wishlist | Yes (Bearer) |
| `POST` | `/api/wishlist/add` | Add product to wishlist | Yes (Bearer) |
| `DELETE` | `/api/wishlist/{id}` | Remove product from wishlist | Yes (Bearer) |
| `POST` | `/api/checkout/initiate` | Create order & get SSLCommerz transaction URL | Yes (Bearer) |
| `GET` | `/api/orders` | Order history list | Yes (Bearer) |
| `GET` | `/api/orders/{id}` | Specific order invoice details | Yes (Bearer) |

---

## 📁 Repository Standards
- Clean Laravel MVC structure following official PSR coding guidelines.
- Unnecessary directories (`node_modules`, `vendor`, `.vscode`, etc.) are ignored via `.gitignore`.
- Only production-ready source code is included.
