# ChronosLuxury — Implementation Plan

Platform e-commerce jam tangan mewah berbasis Laravel sesuai PRD. Project berada di `d:\laragon\www\CHRONOSLUXURY`.

> [!TIP]
> **Panduan sesi berikutnya**: Jika ada perintah `php artisan` yang perlu dijalankan, saya akan meminta Anda membuka **Laragon Terminal** (bukan PowerShell biasa) karena PHP hanya tersedia di environment Laragon. Pastikan **MySQL Laragon aktif** sebelum menjalankan perintah database.

## User Review Required

> [!IMPORTANT]
> **Database**: PRD menyebut PostgreSQL. Namun Anda menggunakan **Laragon** yang biasanya sudah menyertakan **MySQL/MariaDB**. Apakah Anda mau pakai:
> - **MySQL/MariaDB** (bawaan Laragon, lebih mudah setup lokal) → ubah `DB_CONNECTION=mysql`
> - **PostgreSQL** (sesuai PRD, perlu install PostgreSQL di Laragon) → ubah `DB_CONNECTION=pgsql`
>
> **Rekomendasi untuk development lokal**: MySQL Laragon, lalu ganti ke PostgreSQL saat deploy ke Railway. Saya akan lanjutkan dengan **MySQL** jika tidak ada instruksi lain.

> [!NOTE]
> Cart akan disimpan di **database** (tabel `carts`), bukan session, agar lebih rapi dan persistif.

---

## Proposed Changes

### 1. Konfigurasi & Environment

#### [MODIFY] [.env](file:///d:/laragon/www/CHRONOSLUXURY/.env)
- Ubah `APP_NAME=ChronosLuxury`
- Ubah `DB_CONNECTION=mysql`, tambahkan `DB_HOST`, `DB_PORT=3306`, `DB_DATABASE=chronosluxury`, `DB_USERNAME=root`, `DB_PASSWORD=`
- Ubah `SESSION_DRIVER=file`
- Ubah `FILESYSTEM_DISK=public`

---

### 2. Migrations

#### [MODIFY] `0001_01_01_000000_create_users_table.php`
Tambahkan kolom `role ENUM('admin','customer') DEFAULT 'customer'` pada tabel `users`.

#### [NEW] `create_categories_table`
Kolom: `id`, `name` VARCHAR(100), `slug` VARCHAR(120) UNIQUE, `timestamps`

#### [NEW] `create_products_table`
Kolom: `id`, `category_id` FK, `name`, `slug` UNIQUE, `description` TEXT, `price` DECIMAL(15,2), `stock` INT DEFAULT 0, `image` VARCHAR(255) NULLABLE, `featured` BOOLEAN DEFAULT false, plus spec columns: `reference_number`, `movement`, `case_material`, `dial_color`, `bracelet`, `power_reserve`, `water_resistance`, `case_diameter`, `condition`, `timestamps`

#### [NEW] `create_carts_table`
Kolom: `id`, `user_id` FK, `product_id` FK, `quantity` INT, `timestamps`

#### [NEW] `create_orders_table`
Kolom: `id`, `user_id` FK, `total_price` DECIMAL(15,2), `status` ENUM('pending','processing','shipped','completed','cancelled') DEFAULT 'pending', `shipping_name`, `shipping_address` TEXT, `notes` TEXT NULLABLE, `timestamps`

#### [NEW] `create_order_items_table`
Kolom: `id`, `order_id` FK, `product_id` FK, `quantity` INT, `price` DECIMAL(15,2) (harga saat beli), `timestamps`

---

### 3. Models

#### [MODIFY] [User.php](file:///d:/laragon/www/CHRONOSLUXURY/app/Models/User.php)
Tambahkan `role` ke `$fillable`, relasi `hasMany` ke `Order` dan `Cart`, helper method `isAdmin()`.

#### [NEW] `Category.php` — fillable, hasMany products, auto-slug
#### [NEW] `Product.php` — fillable, belongsTo category, hasMany cartItems/orderItems, scope `featured()`
#### [NEW] `Cart.php` — fillable, belongsTo user/product
#### [NEW] `Order.php` — fillable, belongsTo user, hasMany orderItems, status transitions
#### [NEW] `OrderItem.php` — fillable, belongsTo order/product

---

### 4. Middleware & Auth

#### Install Laravel Breeze (Blade stack, tanpa dark mode)
```
composer require laravel/breeze --dev
php artisan breeze:install blade
```
Hasilnya: views login/register, AuthenticatedSessionController, route auth.

#### [NEW] `app/Http/Middleware/AdminMiddleware.php`
Cek `auth()->user()->role === 'admin'`, jika tidak → abort(403).

#### [MODIFY] `bootstrap/app.php`
Register alias `admin` untuk `AdminMiddleware`.

#### [MODIFY] `AuthenticatedSessionController.php`
Override redirect setelah login: admin → `/admin/dashboard`, customer → `/dashboard`.

---

### 5. Seeders

#### [NEW] `DatabaseSeeder.php` (memanggil sub-seeder)
#### [NEW] `AdminSeeder` — user admin: `admin@chronosluxury.com` / `password`
#### [NEW] `CategorySeeder` — Diver, Dress, Chronograph, Classic (+ slug)
#### [NEW] `ProductSeeder` — 12+ produk jam tangan mewah dengan data spek lengkap & `featured=true` untuk beberapa produk

---

### 6. Controllers (Customer / Public)

#### [NEW] `HomeController` — `index()`: featured products + best seller (top 4 by order count)
#### [NEW] `ProductController` — `index()` (search, filter by category/price/stock, sort, paginate 12), `show()` (detail + related products 4)
#### [NEW] `CartController` — `index()`, `store()`, `update()`, `destroy()`
#### [NEW] `CheckoutController` — `index()` (form konfirmasi), `store()` (buat order, kurangi stok, bersihkan cart)
#### [NEW] `Customer\OrderController` — `index()` (my orders), `show()`
#### [NEW] `Customer\DashboardController` — statistik ringkas (total, pending, completed orders)
#### [NEW] `ProfileController` — `edit()`, `update()` (nama, email, password)

---

### 7. Controllers (Admin)

#### ✅ [DONE] `Admin\DashboardController` — stats: total products, customers, orders, revenue (completed orders)
#### ✅ [DONE] `Admin\CategoryController` — CRUD lengkap + validasi kategori tidak bisa dihapus jika masih ada produk
#### ✅ [DONE] `Admin\ProductController` — CRUD + file upload gambar langsung ke `public/assets/images`
#### ✅ [DONE] `Admin\OrderController` — list all orders, filter by status, show detail, update status + rollback stok jika cancelled

---

### 8. Routes (`routes/web.php`)

```
// Public
GET /                   → HomeController@index
GET /products           → ProductController@index
GET /products/{slug}    → ProductController@show

// Auth (Breeze routes)
GET/POST /login, /register, /logout

// Customer (auth middleware)
GET /dashboard          → Customer\DashboardController@index
GET /cart               → CartController@index
POST /cart              → CartController@store
PATCH /cart/{id}        → CartController@update
DELETE /cart/{id}       → CartController@destroy
GET /checkout           → CheckoutController@index
POST /checkout          → CheckoutController@store
GET /orders             → Customer\OrderController@index
GET /orders/{id}        → Customer\OrderController@show
GET /profile            → ProfileController@edit
PATCH /profile          → ProfileController@update

// Admin (auth + admin middleware) — prefix admin
GET/... /admin/dashboard
GET/... /admin/categories CRUD
GET/... /admin/products CRUD
GET/... /admin/orders, /admin/orders/{id}, PATCH /admin/orders/{id}/status
```

---

### 9. Views (Blade)

#### Layout
- `layouts/app.blade.php` — navbar (logo ChronosLuxury, menu publik, cart badge, login/logout), footer
- `layouts/admin.blade.php` — sidebar admin, topbar

#### Public Views
- ✅ `home.blade.php` — Hero + **Background.webm video** + GSAP timeline entry + ScrollTrigger parallax + IntersectionObserver scroll reveals + animated counter + marquee ticker + micro-interactions
- ✅ `products/index.blade.php` — Grid katalog, sidebar filter, sort, pagination
- ✅ `products/show.blade.php` — Detail + spesifikasi + Add to Cart + Related Products
- ✅ `about.blade.php` — Brand story, stats grid, core values cards, milestone timeline (hover animated), CTA strip
- ✅ `contact.blade.php` — Inquiry form (validated), info cards, business hours, privacy note, map placeholder

#### Customer Views
- `cart/index.blade.php` — daftar item, qty control, hapus, total, tombol Checkout
- `checkout/index.blade.php` — ringkasan order, form pengiriman, tombol konfirmasi
- `checkout/success.blade.php` — order success page
- `dashboard/index.blade.php` — welcome, statistik 3 kartu
- `orders/index.blade.php` — tabel riwayat pesanan + badge status
- `orders/show.blade.php` — detail order + order items
- `profile/edit.blade.php` — form update profil

#### Admin Views
- ✅ `admin/dashboard.blade.php` — 4 stat card + recent orders + quick actions (List Timepiece, Add Category)
- ✅ `admin/categories/index.blade.php` — tabel kategori + count produk + edit/delete
- ✅ `admin/categories/create.blade.php` — form tambah kategori
- ✅ `admin/categories/edit.blade.php` — form edit kategori (prefilled)
- ✅ `admin/products/index.blade.php` — tabel produk + search + filter + pagination + gambar preview
- ✅ `admin/products/create.blade.php` — form 3 section: ID & Price, Specs, Description + image upload
- ✅ `admin/products/edit.blade.php` — sama seperti create tapi prefilled + image preview aktif
- ✅ `admin/orders/index.blade.php` — quick filter by status (pending/processing/shipped/...) + pagination
- ✅ `admin/orders/show.blade.php` — invoice detail + status update form + rollback stok jika cancel

---

### 10. Design System (Luxury Theme)

**Warna** (CSS variables / Tailwind config):
- `--bg-primary: #121212` (gelap)
- `--gold: #D4AF37`
- `--ivory: #F5F5F5`
- `--gray: #8C8C8C`
- `--card-border: rgba(212,175,55,0.3)`

**Typography** (Google Fonts via Blade layout):
- Heading: `Playfair Display` (serif, elegan)
- Body: `Poppins` (clean, modern)

**Komponen**:
- Product card dengan hover scale + golden border
- Status badge berwarna per status order
- Sidebar admin dengan gold accent
- Flash message (success/error) dengan desain premium

---

## Status Progress Sesi Ini (18 Juli 2026)

| Modul | Status | Catatan |
|-------|--------|----------|
| Database Migration | ✅ Done | Semua tabel terdefinisi |
| Models | ✅ Done | User, Category, Product, Cart, Order, OrderItem |
| Seeders (Admin, Category, Product) | ✅ Done | Siap dijalankan |
| Auth (Login Redirect) | ✅ Done | Admin → `/admin/dashboard`, Customer → `/dashboard` |
| AdminMiddleware | ✅ Done | Role check + 403 abort |
| Routes (Public + Customer + Admin) | ✅ Done | Resource + manual routes terdaftar |
| HomeController | ✅ Done | Featured + Best Seller products |
| ProductController | ✅ Done | Index filter, show + related |
| CartController | ✅ Done | CRUD + stock validation |
| CheckoutController | ✅ Done | DB Transaction + lockForUpdate |
| Customer DashboardController | ✅ Done | Stats cards + recent orders |
| Customer OrderController | ✅ Done | Index + show invoice |
| Admin DashboardController | ✅ Done | Revenue + product/customer/order stats |
| Admin CategoryController | ✅ Done | CRUD + protect delete if has products |
| Admin ProductController | ✅ Done | CRUD + image upload ke public/assets/images |
| Admin OrderController | ✅ Done | Status update + rollback stok saat cancel |
| Views (Public) | ✅ Done | home, products/index, products/show |
| Views (Customer) | ✅ Done | cart, checkout, dashboard, orders |
| Views (Admin) | ✅ Done | dashboard, categories, products, orders |
| `php artisan migrate:fresh --seed` | ✅ Done | Sukses — semua tabel + seeder terbuat |
| Auth views (login, register) | ✅ Done | Rebrand ke tema luxury, hapus `@vite` dependency |
| Guest layout (Breeze) | ✅ Done | Diganti dengan luxury dark layout ChronosLuxury |
| Homepage — Background.webm Video | ✅ Done | Video hero fullscreen + overlay gradient |
| Homepage — GSAP + ScrollTrigger | ✅ Done | Hero timeline, parallax video, deco circle parallax |
| Homepage — IntersectionObserver | ✅ Done | Reveal, reveal-left, reveal-right + stagger delays |
| Homepage — Animated Counter | ✅ Done | Counter animasi di section Heritage |
| Homepage — Marquee Ticker | ✅ Done | Gold ticker strip antara hero dan katolog |
| About Page | ✅ Done | Brand story, stats, values, timeline, CTA |
| Contact Page | ✅ Done | Form inquiry + validasi + info cards + map placeholder |
| AboutController | ✅ Done | Returns `about` view |
| ContactController | ✅ Done | index + send (validate + log + flash redirect) |
| Routes `/about`, `/contact` | ✅ Done | Terdaftar sebagai public routes |
| Premium Hero (Sweep/Breathe/Parallax) | ✅ Done | Shine sweep di CTA, breathing pada crown lambat, & 3-layer GSAP text parallax |
| Ticker & Marquee Icons | ✅ Done | Gunakan icon (shield, certificate, crown, truck, dll) pendukung disamping bullet |
| Slider Horizontal Featured | ✅ Done | Carousel horizontal mini-nav dengan variasi background card & custom NEW/LIMITED badges |
| Quick Eye View Hover | ✅ Done | Hover eye button (quick view) menggantikan floating "+" statis |
| Heritage Gear & Stats Icons | ✅ Done | Rotating clock gears (dashed circles) + icon statistics (hourglass, tags, globe) |
| Footer Clean (Newsletter & Social) | ✅ Done | Hapus debug badge, icon newsletter input, send button arrow, & IG/WA/YT gold hover |
| Catalog 3D Angle & AJAX Filter | ✅ Done | 3D look-profile rotation hover, query chips, & skeleton shimmer loader AJAX dynamic |

---

## ⚡ Langkah Berikutnya (User Action Required)

> [!IMPORTANT]
> **AKSI USER DIPERLUKAN — VIDEO ASSET**: Pastikan file `Background.webm` ditempatkan di:
> ```
> d:\laragon\www\CHRONOSLUXURY\public\assets\videos\Background.webm
> ```
> Folder `videos` sudah tersedia. Tanpa file ini, hero section akan menampilkan background hitam solid (tetap berfungsi, tidak error).

> [!NOTE]
> **Cart icon di navbar**: Ini sudah terhubung ke route `/cart` yang memerlukan login. Kalau belum login → redirect ke halaman login (perilaku benar). Kalau sudah login → cart terbuka normal.

---

## Verification Plan (Setelah Migrate)

**1. Test Authentication**
- Buka `http://chronosluxury.test/login`
- Login `admin@chronosluxury.com` / `password` → harus redirect ke `/admin/dashboard`
- Login sebagai customer biasa → harus redirect ke `/dashboard`
- Coba akses `/admin/dashboard` sebagai customer → harus 403

**2. Test Katalog Publik**
- Buka `/products` → produk tampil dalam grid luxury
- Search nama jam → filter berjalan
- Klik produk → detail + specs + related products

**3. Test Cart & Checkout**
- Login customer → Add to Cart → buka `/cart`
- Ubah quantity → total berubah
- Checkout → isi form → submit
- Stok produk berkurang, cart kosong, muncul halaman sukses

**4. Test Admin Panel**
- Login admin → `/admin/categories/create` → tambah kategori
- `/admin/products/create` → tambah produk + upload foto
- Coba hapus kategori yang punya produk → harus ditolak dengan error
- Buka `/admin/orders` → update status order
- Cancel order → verifikasi stok produk dikembalikan
