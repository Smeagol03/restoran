# PRD — Website Restoran (Laravel 12)
**Version:** 1.2  
**Stack:** Laravel 12 · PHP 8.4 · MySQL 8 · Tailwind CSS · Alpine.js · Livewire 3 · Reverb  
**Scope:** Dari user mengunjungi website sampai transaksi selesai  
**Format:** AI-readable · Scalable · Extendable  

---

## METADATA

```yaml
project:    Restaurant Website
framework:  Laravel 12
php:        ">=8.4"
database:   MySQL 8.0 / PostgreSQL 15
cache:      Redis 7
realtime:   Laravel Reverb (self-hosted WebSocket)
payment:    Midtrans Snap API
auth:       Laravel Breeze + Socialite (Google OAuth)
roles:      [customer, kasir, admin, superadmin]
deployment: Ubuntu 22.04 + Nginx + PHP-FPM + Supervisor
```

---

## DAFTAR ISI

1. [Visi & Tujuan](#1-visi--tujuan)
2. [Aktor & Role](#2-aktor--role)
3. [User Journey — End to End](#3-user-journey--end-to-end)
4. [Tech Stack Detail](#4-tech-stack-detail)
5. [Arsitektur Folder](#5-arsitektur-folder)
6. [Database Schema](#6-database-schema)
7. [Spesifikasi Fitur](#7-spesifikasi-fitur)
8. [Flow Diagram (Teks)](#8-flow-diagram-teks)
9. [Keamanan](#9-keamanan)
10. [API & Route Map](#10-api--route-map)
11. [Event & Queue System](#11-event--queue-system)
12. [Panduan Extend Fitur Baru](#12-panduan-extend-fitur-baru)
13. [Estimasi Timeline](#13-estimasi-timeline)

---

## 1. VISI & TUJUAN

### Pernyataan Produk
> Website restoran full-stack yang memungkinkan pelanggan menemukan menu, memesan makanan (dine-in/delivery), melakukan reservasi meja, dan menyelesaikan pembayaran — semuanya dalam satu platform.

### Tujuan Bisnis
| # | Tujuan | Metrik Sukses |
|---|--------|---------------|
| 1 | Digitalisasi proses pemesanan | > 60% order via website dalam 3 bulan |
| 2 | Kurangi kesalahan order manual | Error rate < 1% |
| 3 | Percepat proses pembayaran | Checkout < 3 menit |
| 4 | Tingkatkan rata-rata nilai order | AOV naik 20% via upsell |
| 5 | Sediakan data penjualan real-time | Dashboard admin live update |

### Batasan MVP
- ✅ Website publik + menu interaktif
- ✅ Cart + checkout + payment gateway
- ✅ Reservasi meja
- ✅ Order tracking real-time
- ✅ Dashboard admin & kasir
- ❌ Aplikasi mobile native (fase 2)
- ❌ Loyalty points / membership (fase 2)
- ❌ Multi-branch (fase 3)

---

## 2. AKTOR & ROLE

```
ROLE HIERARCHY:
superadmin
  └── admin
        └── kasir
              └── customer (authenticated)
                    └── guest (unauthenticated)
```

| Role | Akses Utama | Dapat Diakses Via |
|------|-------------|-------------------|
| `guest` | Browse menu, lihat promo, halaman publik | Web (tanpa login) |
| `customer` | Semua guest + order, payment, reservasi, riwayat | Web (login) |
| `kasir` | Customer + kelola pesanan masuk, update status | Dashboard /kasir |
| `admin` | Kasir + kelola menu, promo, laporan, reservasi | Dashboard /admin |
| `superadmin` | Admin + kelola user, role, setting sistem | Dashboard /admin |

**Package:** `spatie/laravel-permission` — role & permission disimpan di database, bukan hardcode.

---

## 3. USER JOURNEY — END TO END

### 3.1 Customer Journey (Happy Path)

```
[STEP 1] KUNJUNGI WEBSITE
Guest membuka URL restoran
→ Tampil: Landing Page (hero, menu unggulan, promo, lokasi)
→ Aksi tersedia: Lihat Menu, Pesan Sekarang, Buat Reservasi

[STEP 2] JELAJAHI MENU
Guest klik "Lihat Menu"
→ Tampil: Daftar menu dengan filter kategori + search
→ Aksi: Klik item untuk lihat detail, Tambah ke Cart

[STEP 3] CART
Guest menambah item ke cart
→ Cart disimpan di: SESSION (jika guest) / DATABASE (jika login)
→ Aksi: Update qty, hapus item, input catatan, lihat subtotal

[STEP 4] LOGIN / REGISTER
Guest klik "Checkout"
→ Jika belum login: redirect ke halaman login
→ Setelah login: cart session di-MERGE ke database
→ Opsi: Login biasa (email+password) atau Google OAuth

[STEP 5] CHECKOUT
Customer mengisi form checkout:
  - Tipe pesanan: DINE-IN (pilih meja) atau DELIVERY (isi alamat)
  - Catatan per item (opsional)
  - Kode promo (opsional)
→ Sistem kalkulasi: subtotal + ongkir (delivery) - diskon = TOTAL

[STEP 6] PEMBAYARAN
Customer memilih metode bayar:
  - QRIS, GoPay, OVO, DANA (via Midtrans Snap)
  - Transfer Bank (BCA VA, Mandiri VA, BNI VA)
  - COD — khusus delivery, bayar di tempat
→ Sistem membuat Order (status: PENDING)
→ Midtrans mengembalikan snap_token
→ Pop-up Midtrans terbuka di halaman yang sama

[STEP 7] KONFIRMASI PEMBAYARAN
Midtrans memproses pembayaran:
  - BERHASIL → webhook diterima → Order status: CONFIRMED
  - GAGAL    → Order status: FAILED, customer bisa coba lagi
  - TIMEOUT  → Order di-cancel otomatis setelah 30 menit (scheduler)

[STEP 8] NOTIFIKASI
Setelah pembayaran berhasil:
→ Email konfirmasi dikirim (queue job)
→ Admin/kasir menerima notifikasi pesanan baru (Reverb/WebSocket)
→ Customer melihat halaman sukses + link tracking

[STEP 9] TRACKING PESANAN
Customer membuka halaman tracking:
→ Status real-time via WebSocket (Laravel Reverb)
→ PENDING → CONFIRMED → PREPARING → READY → DELIVERED/DONE
→ Update otomatis tanpa refresh halaman

[STEP 10] SELESAI
Pesanan selesai:
→ Customer diminta memberikan rating & ulasan
→ Data tersimpan di tabel reviews
→ Order masuk ke riwayat pesanan
```

### 3.2 Admin / Kasir Journey

```
[STEP 1] LOGIN DASHBOARD
Admin/kasir login ke /admin atau /kasir
→ Redirect sesuai role ke dashboard masing-masing

[STEP 2] KELOLA PESANAN MASUK
Dashboard menampilkan pesanan baru secara real-time
→ Aksi: Konfirmasi pesanan, update status, cetak struk
→ Kasir mengubah status: CONFIRMED → PREPARING → READY

[STEP 3] KONFIRMASI PEMBAYARAN MANUAL (jika transfer manual)
Admin upload bukti transfer → verifikasi → update status payment

[STEP 4] KELOLA MENU (admin only)
CRUD menu item: nama, harga, foto, kategori, ketersediaan (toggle)

[STEP 5] KELOLA RESERVASI
Lihat kalender reservasi → approve/reject → sistem kirim email ke customer

[STEP 6] LAPORAN
Laporan penjualan: harian/mingguan/bulanan
→ Export ke Excel atau PDF
```

---

## 4. TECH STACK DETAIL

### 4.1 Backend

| Layer | Teknologi | Versi | Fungsi |
|-------|-----------|-------|--------|
| Framework | Laravel | 12.x | Core aplikasi |
| Runtime | PHP | 8.4+ | Bahasa pemrograman |
| Auth | Laravel Breeze | 2.x | Scaffolding autentikasi |
| OAuth | Laravel Socialite | 5.x | Login Google/Facebook |
| Authorization | Spatie Permission | 6.x | Role & permission |
| ORM | Eloquent | (built-in) | Database abstraction |
| Queue | Laravel Queue | (built-in) | Async jobs (email, notif) |
| Scheduler | Laravel Scheduler | (built-in) | Cron jobs otomatis |
| Realtime | Laravel Reverb | 1.x | WebSocket server (self-hosted) |
| Broadcast | Laravel Echo | (built-in) | WebSocket client |
| Payment | midtrans/midtrans-php | 2.x | Payment gateway SDK |
| File Upload | Spatie Media Library | 11.x | Manajemen foto menu |
| Image | Intervention Image | 3.x | Resize & optimasi gambar |
| Search | Laravel Scout + Meilisearch | 10.x | Full-text search menu |
| PDF | barryvdh/laravel-dompdf | 3.x | Generate struk & laporan |
| Excel | maatwebsite/excel | 3.x | Export laporan Excel |
| Backup | Spatie Laravel Backup | 9.x | Backup DB & storage |
| Testing | Pest PHP | 3.x | Unit & feature testing |
| Debug | Laravel Telescope | 5.x | Debug (dev only) |
| Monitoring | Laravel Pulse | 1.x | Monitoring production |
| AI Dev | Laravel Boost | 1.x | Context AI untuk dev tools |

### 4.2 Frontend

> ⚠️ **Keputusan Stack:** Project ini **tidak menggunakan Flux**. Flux adalah UI library berbayar milik Livewire yang dokumentasinya terbatas sehingga AI model sering menghasilkan kode error. Sebagai gantinya digunakan **Blade Components buatan sendiri + Tailwind CSS** yang jauh lebih AI-friendly, mudah di-debug, dan tidak ada biaya lisensi tambahan.

| Layer | Teknologi | Versi | Fungsi |
|-------|-----------|-------|--------|
| Template | Laravel Blade | (built-in) | Server-side rendering |
| UI Components | Blade Components (custom) | — | Komponen reusable tanpa dependency eksternal |
| CSS | Tailwind CSS | 3.x | Utility-first styling |
| CSS Plugin | @tailwindcss/forms | 0.5.x | Reset style form default |
| Interactivity | Alpine.js | 3.x | Dropdown, modal, counter, toggle |
| State Persist | @alpinejs/persist | 3.x | Simpan state Alpine ke localStorage |
| Reactive UI | Livewire 3 | 3.x | Komponen dinamis: cart, search, tracking |
| Build Tool | Vite | 5.x | Asset bundling (JS + CSS) |
| Icons | Heroicons | 2.x | SVG icon set (via Blade) |
| Date Picker | Flatpickr | 4.x | Input tanggal & jam reservasi |
| Alert/Dialog | SweetAlert2 | 11.x | Konfirmasi aksi, notif sukses/gagal |
| Charts | Chart.js | 4.x | Grafik penjualan di dashboard admin |

**Panduan Blade Component:**
```
resources/views/components/
├── button.blade.php         → <x-button variant="primary">
├── input.blade.php          → <x-input type="text" name="..." />
├── card.blade.php           → <x-card>...</x-card>
├── badge.blade.php          → <x-badge color="green">Tersedia</x-badge>
├── modal.blade.php          → <x-modal id="..." title="...">
├── alert.blade.php          → <x-alert type="success">
├── menu-card.blade.php      → Kartu item menu
├── order-status.blade.php   → Badge status pesanan
└── form/
    ├── label.blade.php
    ├── error.blade.php
    └── select.blade.php
```

### 4.3 Infrastructure

| Layer | Teknologi | Fungsi |
|-------|-----------|--------|
| Web Server | Nginx | Reverse proxy + static files |
| PHP Handler | PHP-FPM | Process manager untuk PHP |
| Database | MySQL 8.0 | Penyimpanan data utama |
| Cache & Queue | Redis 7 | Cache, session, queue driver |
| WebSocket | Laravel Reverb | Realtime order tracking |
| Process Manager | Supervisor | Jaga queue worker & Reverb tetap jalan |
| SSL | Let's Encrypt (Certbot) | HTTPS gratis |
| Storage | Local / AWS S3 | Upload foto menu |
| CI/CD | GitHub Actions | Auto deploy ke server |
| Monitoring | Sentry | Error tracking production |

### 4.4 Install Command

```bash
# Buat project Laravel 12
laravel new restaurant-app

# Package PHP (composer)
composer require \
  laravel/socialite \
  spatie/laravel-permission \
  spatie/laravel-medialibrary \
  spatie/laravel-backup \
  midtrans/midtrans-php \
  intervention/image \
  laravel/scout \
  maatwebsite/excel \
  barryvdh/laravel-dompdf \
  livewire/livewire

composer require --dev \
  pestphp/pest \
  laravel/telescope \
  laravel/boost

# Package JS (npm)
npm install \
  alpinejs \
  @alpinejs/persist \
  flatpickr \
  sweetalert2 \
  chart.js \
  laravel-echo \
  @tailwindcss/forms

# Publish Livewire assets
php artisan livewire:publish --config

# Jalankan Reverb (WebSocket, sudah bundled di Laravel 12)
php artisan install:broadcasting
```

---

## 5. ARSITEKTUR FOLDER

> Prinsip: **Feature-based grouping** di dalam layer MVC. Setiap fitur baru cukup menambah file di folder yang sudah ada tanpa mengubah struktur.

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                        # Login, register, verify email
│   │   ├── Public/                      # Controller halaman publik
│   │   │   ├── HomeController.php
│   │   │   ├── MenuController.php
│   │   │   └── ReservationController.php
│   │   ├── Order/                       # Semua flow order
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── OrderController.php
│   │   │   └── TrackingController.php
│   │   ├── Payment/
│   │   │   └── PaymentController.php    # Midtrans snap + webhook
│   │   └── Admin/                       # Controller khusus admin
│   │       ├── DashboardController.php
│   │       ├── MenuItemController.php
│   │       ├── OrderManagementController.php
│   │       ├── ReservationManagementController.php
│   │       ├── PromoController.php
│   │       └── ReportController.php
│   ├── Middleware/
│   │   ├── RoleMiddleware.php           # Cek role (admin/kasir)
│   │   ├── EnsureRestaurantOpen.php     # Cek jam operasional
│   │   └── VerifyMidtransSignature.php  # Validasi webhook
│   └── Requests/                        # Form validation per fitur
│       ├── StoreOrderRequest.php
│       ├── StoreReservationRequest.php
│       └── UpdateMenuItemRequest.php
│
├── Models/
│   ├── User.php
│   ├── MenuItem.php
│   ├── Category.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Payment.php
│   ├── Reservation.php
│   ├── Table.php
│   ├── Address.php
│   ├── Promo.php
│   └── Review.php
│
├── Services/                            # Business logic (bukan di controller)
│   ├── CartService.php                  # Logika cart (merge, update, clear)
│   ├── OrderService.php                 # Buat order, kalkulasi total
│   ├── PaymentService.php               # Snap token, verifikasi webhook
│   ├── ReservationService.php           # Cek ketersediaan meja
│   └── PromoService.php                 # Kalkulasi diskon
│
├── Jobs/                                # Async queue jobs
│   ├── SendOrderConfirmationEmail.php
│   ├── SendReservationConfirmationEmail.php
│   ├── SendReservationReminderEmail.php
│   ├── CancelExpiredOrders.php
│   └── ProcessPaymentWebhook.php
│
├── Events/                              # Event untuk Reverb/WebSocket
│   ├── OrderStatusUpdated.php
│   ├── NewOrderReceived.php
│   └── PaymentStatusUpdated.php
│
├── Listeners/
│   ├── NotifyAdminNewOrder.php
│   └── UpdateOrderStatus.php
│
├── Notifications/
│   ├── OrderConfirmed.php               # Email + database notif
│   ├── PaymentReceived.php
│   └── ReservationApproved.php
│
└── Policies/                            # Authorization per model
    ├── OrderPolicy.php                  # Hanya pemilik order yang bisa lihat
    └── ReviewPolicy.php

resources/
├── views/
│   ├── layouts/
│   │   ├── app.blade.php                # Layout halaman publik
│   │   ├── auth.blade.php               # Layout halaman auth
│   │   └── admin.blade.php              # Layout dashboard admin
│   ├── components/                      # Blade components reusable
│   │   ├── menu-card.blade.php
│   │   ├── cart-item.blade.php
│   │   ├── order-status-badge.blade.php
│   │   └── alert.blade.php
│   ├── livewire/                        # Livewire components
│   │   ├── cart.blade.php
│   │   ├── menu-search.blade.php
│   │   └── order-tracker.blade.php
│   ├── public/                          # Halaman publik
│   │   ├── home.blade.php
│   │   ├── menu/index.blade.php
│   │   ├── menu/show.blade.php
│   │   ├── reservations/create.blade.php
│   │   └── about.blade.php
│   ├── order/                           # Alur order
│   │   ├── cart.blade.php
│   │   ├── checkout.blade.php
│   │   ├── success.blade.php
│   │   └── tracking.blade.php
│   └── admin/                           # Halaman admin
│       ├── dashboard.blade.php
│       ├── orders/
│       ├── menu/
│       ├── reservations/
│       └── reports/
│
routes/
├── web.php                              # Route halaman publik
├── auth.php                             # Route autentikasi
├── admin.php                            # Route admin (prefix: /admin, middleware: admin)
├── kasir.php                            # Route kasir (prefix: /kasir, middleware: kasir)
└── api.php                              # REST API (untuk mobile app fase 2)
```

---

## 6. DATABASE SCHEMA

> Konvensi: semua tabel pakai `id` bigint auto-increment, `created_at`, `updated_at`. Soft delete diaktifkan di tabel kritis.

### 6.1 Ringkasan Relasi Antar Model

```
users ─────────────────┬── orders        (hasMany)
                       ├── reservations  (hasMany)
                       ├── addresses     (hasMany)
                       ├── reviews       (hasMany)
                       └── roles         (belongsToMany via Spatie)

categories ────────────── menu_items     (hasMany)

menu_items ─────────────┬── order_items  (hasMany)
                        └── reviews      (hasMany)

orders ─────────────────┬── order_items  (hasMany)
                        ├── payment      (hasOne)
                        ├── review       (hasOne)
                        ├── table        (belongsTo, nullable)
                        ├── address      (belongsTo, nullable)
                        └── promo        (belongsTo, nullable)

tables ─────────────────── reservations  (hasMany)
```

### 6.2 Definisi Tabel

```sql
-- USERS
users: id, name, email, phone, password, google_id,
       email_verified_at, remember_token, created_at, updated_at

-- ROLES (Spatie)
roles: id, name, guard_name
model_has_roles: role_id, model_type, model_id

-- CATEGORIES
categories: id, name, slug, description, icon, sort_order,
            is_active (bool), created_at, updated_at

-- MENU ITEMS
menu_items: id, category_id (FK), name, slug, description,
            price (decimal 10,2), is_available (bool),
            is_featured (bool), preparation_time (int, menit),
            deleted_at, created_at, updated_at
-- media (foto) dikelola oleh Spatie Media Library

-- ORDERS
orders:
  id, user_id (FK), order_number (unique, e.g. ORD-20241201-0001),
  type (enum: dine_in, delivery),
  status (enum: pending, confirmed, preparing, ready, delivered, done, cancelled, failed),
  table_id (FK nullable, untuk dine_in),
  delivery_address_id (FK nullable, untuk delivery),
  notes (text),
  subtotal (decimal), discount_amount (decimal), delivery_fee (decimal),
  total (decimal), promo_id (FK nullable),
  created_at, updated_at, deleted_at

-- ORDER ITEMS
order_items: id, order_id (FK), menu_item_id (FK),
             quantity (int), unit_price (decimal), subtotal (decimal),
             notes (text nullable), created_at, updated_at

-- PAYMENTS
payments:
  id, order_id (FK unique), method (enum: qris, gopay, ovo, dana,
  bca_va, mandiri_va, bni_va, cod, manual_transfer),
  amount (decimal), status (enum: pending, paid, failed, expired, refunded),
  midtrans_transaction_id (string nullable),
  midtrans_snap_token (string nullable),
  payment_proof (string nullable, untuk transfer manual),
  paid_at (timestamp nullable), expired_at (timestamp nullable),
  created_at, updated_at

-- TABLES (meja restoran)
tables: id, number (string), capacity (int),
        status (enum: available, occupied, reserved),
        created_at, updated_at

-- RESERVATIONS
reservations:
  id, user_id (FK), table_id (FK nullable),
  name, phone, email,
  reservation_date (date), reservation_time (time),
  guest_count (int), notes (text nullable),
  status (enum: pending, confirmed, rejected, completed, cancelled),
  reminder_sent_at (timestamp nullable),
  created_at, updated_at

-- ADDRESSES
addresses: id, user_id (FK), label (rumah/kantor/dll), recipient_name,
           phone, address, district, city, province, postal_code,
           latitude (decimal nullable), longitude (decimal nullable),
           is_default (bool), created_at, updated_at

-- PROMOS
promos: id, name, code (unique), type (enum: percentage, fixed),
        value (decimal), min_order_amount (decimal),
        max_discount_amount (decimal nullable),
        usage_limit (int nullable), used_count (int default 0),
        is_active (bool), starts_at, expires_at, created_at, updated_at

-- REVIEWS
reviews: id, order_id (FK), user_id (FK), menu_item_id (FK nullable),
         rating (tinyint 1-5), comment (text nullable),
         is_published (bool), created_at, updated_at
```

---

## 7. SPESIFIKASI FITUR

### F01 — Landing Page

**Tujuan:** Konversi pengunjung baru menjadi pelanggan.

**Komponen UI:**
- Hero section: foto makanan + CTA ("Pesan Sekarang" → /menu, "Reservasi" → /reservasi)
- Menu unggulan: 6 item `is_featured=true`, ditampilkan dengan foto, nama, harga
- Banner promo aktif: query dari tabel `promos` yang `is_active=true AND now() BETWEEN starts_at AND expires_at`
- Galeri foto: dari Spatie Media Library, collection `gallery`
- Tentang kami: teks statis (atau dari tabel `settings`)
- Google Maps embed: koordinat dari config/setting
- Jam operasional: dari tabel `settings`

**Catatan implementasi:**
```php
// HomeController@index
$featuredItems = MenuItem::where('is_featured', true)
    ->where('is_available', true)
    ->with('category', 'media')
    ->limit(6)->get();

$activePromos = Promo::active()->limit(3)->get(); // scope: active()
```

---

### F02 — Halaman Menu

**Tujuan:** Memudahkan pelanggan menemukan dan memilih makanan.

**Fitur:**
- Filter per kategori (tab atau sidebar) — query `Category::with('menuItems')`
- Search real-time via **Livewire** (`MenuSearch` component) + Laravel Scout
- Kartu menu: foto, nama, harga, tombol "+ Tambah"
- Badge "Habis" jika `is_available = false` (tombol disabled)
- Modal detail menu: foto besar, deskripsi lengkap, opsi tambahan (future)
- Infinite scroll atau pagination (12 item per halaman)

---

### F03 — Sistem Cart

**Tujuan:** Menyimpan pilihan menu sebelum checkout.

**Implementasi:**
```
GUEST  → Cart disimpan di Laravel SESSION (key: 'cart', format: array)
USER   → Cart disimpan di tabel cart_items (database)
MERGE  → Saat guest login, CartService::mergeGuestCart() dipanggil
```

**CartService method:**
- `add(menuItemId, qty, notes)` — tambah item
- `update(cartItemId, qty)` — ubah jumlah
- `remove(cartItemId)` — hapus item
- `clear()` — kosongkan cart
- `getTotal()` — hitung subtotal
- `mergeGuestCart(userId)` — merge session → database
- `getItems()` — return collection item

---

### F04 — Checkout

**Tujuan:** Mengumpulkan semua informasi yang diperlukan untuk memproses pesanan.

**Validasi Form:**
```
type: required, in:dine_in,delivery
table_id: required_if:type,dine_in | exists:tables,id
address_id: required_if:type,delivery | exists:addresses,id
promo_code: nullable | exists:promos,code | scope:active
notes: nullable | string | max:500
payment_method: required | in:[list metode yang tersedia]
```

**Kalkulasi Order:**
```php
subtotal        = sum(item.unit_price * item.quantity)
delivery_fee    = type == 'delivery' ? config('app.delivery_fee') : 0
discount_amount = PromoService::calculate(promo, subtotal)
total           = subtotal + delivery_fee - discount_amount
```

---

### F05 — Payment Gateway (Midtrans)

**Tujuan:** Memproses pembayaran secara aman dan otomatis.

**Flow Teknis:**
```
1. Customer submit checkout
2. OrderService::create() → simpan order (status: pending)
3. PaymentService::createSnapToken(order) → hit Midtrans API
4. Frontend terima snap_token, buka Midtrans Snap pop-up
5. Customer bayar via Midtrans
6. Midtrans kirim webhook ke /payment/webhook
7. VerifyMidtransSignature middleware memvalidasi signature
8. PaymentController::webhook() update status order & payment
9. Event OrderStatusUpdated di-dispatch → Reverb broadcast ke customer
10. Job SendOrderConfirmationEmail di-dispatch → kirim email
```

**Konfigurasi .env:**
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_SNAP_URL=https://app.sandbox.midtrans.com/snap/snap.js
```

**Webhook Route (harus exempt dari CSRF):**
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->validateCsrfTokens(except: [
        'payment/webhook',
    ]);
})
```

---

### F06 — Order Tracking Real-time

**Tujuan:** Customer dapat memantau status pesanan tanpa refresh halaman.

**Implementasi Reverb:**
```javascript
// resources/js/echo.js
window.Echo.private(`order.${orderId}`)
    .listen('OrderStatusUpdated', (e) => {
        // Update UI status badge
        document.getElementById('status').textContent = e.status;
    });
```

```php
// Event: OrderStatusUpdated
class OrderStatusUpdated implements ShouldBroadcast {
    public function broadcastOn(): array {
        return [new PrivateChannel("order.{$this->order->id}")];
    }
    public function broadcastWith(): array {
        return ['status' => $this->order->status, 'updated_at' => now()];
    }
}
```

**Status yang di-broadcast:**
`pending → confirmed → preparing → ready → delivered/done → cancelled`

---

### F07 — Reservasi Meja

**Tujuan:** Customer dapat memesan meja di muka tanpa antre.

**Flow:**
1. Customer isi form: nama, tanggal, jam, jumlah tamu
2. `ReservationService::checkAvailability(date, time, guestCount)` — cek tabel yang tersedia
3. Jika tersedia: simpan reservasi (status: `pending`)
4. Admin approve/reject dari dashboard
5. Email konfirmasi dikirim via queue
6. Scheduler mengirim email reminder 1 jam sebelum waktu reservasi

**Scheduler (app/Console/Kernel.php):**
```php
Schedule::job(new SendReservationReminderEmail)->hourly();
Schedule::job(new CancelExpiredOrders)->everyFifteenMinutes();
```

---

### F08 — Dashboard Admin

**Tujuan:** Pengelolaan restoran dari satu tempat.

**Widget Dashboard:**
```
- Total pesanan hari ini + perubahan vs kemarin (%)
- Revenue hari ini
- Pesanan pending (perlu aksi)
- Reservasi hari ini
- Menu yang sudah habis (is_available = false)
- Grafik penjualan 7 hari terakhir (Chart.js)
```

**Fitur Admin:**

| Modul | Aksi |
|-------|------|
| Menu Items | CRUD + upload foto + toggle ketersediaan |
| Kategori | CRUD + atur urutan |
| Pesanan | List + filter status + update status + cetak struk |
| Reservasi | Kalender view + approve/reject |
| Promo | CRUD + toggle aktif/nonaktif |
| Laporan | Filter tanggal + export Excel/PDF |
| Pengaturan | Jam operasional, ongkir, info restoran |

---

## 8. FLOW DIAGRAM (TEKS)

### 8.1 Order Flow Lengkap

```
Guest/User
    │
    ▼
[Buka Website] ──→ [Browse Menu] ──→ [Tambah ke Cart]
                                              │
                                     [Login/Register] ←── (jika belum login)
                                              │
                                        [Checkout]
                                              │
                              ┌───────────────┴────────────────┐
                              ▼                                 ▼
                         [Dine-In]                        [Delivery]
                     Pilih Meja + Meja                Isi/Pilih Alamat
                              └───────────────┬────────────────┘
                                              ▼
                                    [Pilih Metode Bayar]
                                              │
                              ┌───────────────┴────────────────┐
                              ▼                                 ▼
                     [Midtrans Snap]                     [COD / Manual]
                       Pop-up Bayar                   Lanjut tanpa bayar
                              │
                    ┌─────────┴─────────┐
                    ▼                   ▼
               [BERHASIL]           [GAGAL/TIMEOUT]
                    │                   │
             Order: CONFIRMED    Order: FAILED/CANCELLED
                    │
         ┌──────────┴──────────┐
         ▼                     ▼
  [Email Konfirmasi]    [Notif Admin (Reverb)]
         │
         ▼
  [Tracking Page]
  CONFIRMED → PREPARING → READY → DONE
```

### 8.2 Payment Webhook Flow

```
Midtrans Server
    │
    ▼
POST /payment/webhook
    │
    ▼
[VerifyMidtransSignature Middleware]
    │
    ├── INVALID → 403 Forbidden, log warning
    │
    ▼
[PaymentController::webhook()]
    │
    ├── transaction_status == 'settlement' atau 'capture'
    │       → Payment: PAID, Order: CONFIRMED
    │       → Dispatch: OrderStatusUpdated event
    │       → Dispatch: SendOrderConfirmationEmail job
    │
    ├── transaction_status == 'deny' atau 'cancel' atau 'expire'
    │       → Payment: FAILED/EXPIRED, Order: FAILED
    │       → Dispatch: OrderStatusUpdated event
    │
    └── transaction_status == 'pending'
            → Payment: PENDING (no change)
```

---

## 9. KEAMANAN

> Setiap endpoint dan data harus diasumsikan berpotensi diserang.

### 9.1 Authentication & Authorization

```php
// Middleware stack per route group
Route::middleware(['auth', 'verified'])->group(...)       // customer
Route::middleware(['auth', 'role:kasir|admin'])->group(...) // kasir
Route::middleware(['auth', 'role:admin'])->group(...)      // admin only

// Policy: pastikan user hanya bisa akses order miliknya sendiri
class OrderPolicy {
    public function view(User $user, Order $order): bool {
        return $user->id === $order->user_id;
    }
}
```

### 9.2 Input Validation

```
PRINSIP: Semua input divalidasi via Form Request SEBELUM masuk controller.
- Gunakan request()->validated() bukan request()->all()
- Whitelist field yang boleh masuk, bukan blacklist
- Cast tipe data: integer, decimal, boolean
```

### 9.3 Proteksi Database

```
✅ Selalu gunakan Eloquent atau Query Builder (parameterized)
❌ JANGAN pernah: DB::statement("SELECT * WHERE id = $id")
✅ Mass assignment: isi $fillable di setiap Model (bukan $guarded = [])
```

### 9.4 CSRF & XSS

```
✅ CSRF token otomatis di semua form Blade (@csrf)
✅ Output pakai {{ $var }} bukan {!! $var !!} kecuali HTML yang sudah disanitasi
✅ Webhook Midtrans dikecualikan dari CSRF (tapi divalidasi dengan signature)
✅ Sanitasi input HTML dengan HTMLPurifier jika ada rich text
```

### 9.5 File Upload

```php
// Validasi ketat file upload
'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'

// Simpan di storage/app/private (bukan public langsung)
// Akses via signed URL atau route yang dikontrol
$media = $menuItem->addMediaFromRequest('photo')
    ->usingFileName(Str::uuid() . '.webp')
    ->toMediaCollection('menu_images');
```

### 9.6 Rate Limiting

```php
// routes/web.php
Route::middleware('throttle:login')->group(function () {
    Route::post('/login', ...);              // 5 req/menit per IP
});

Route::middleware('throttle:checkout')->group(function () {
    Route::post('/checkout', ...);           // 3 req/menit per user
});

Route::middleware('throttle:api')->group(function () {
    Route::post('/payment/webhook', ...);    // 60 req/menit
});
```

### 9.7 Midtrans Webhook Validation

```php
// Middleware: VerifyMidtransSignature
class VerifyMidtransSignature {
    public function handle(Request $request, Closure $next) {
        $hash = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            config('midtrans.server_key')
        );

        if ($hash !== $request->signature_key) {
            Log::warning('Invalid Midtrans signature', $request->all());
            abort(403, 'Invalid signature');
        }

        return $next($request);
    }
}
```

### 9.8 Secrets & Environment

```
✅ Semua secret di .env (JANGAN hardcode di kode)
✅ .env tidak pernah di-commit ke Git (.gitignore)
✅ Production gunakan: APP_DEBUG=false, APP_ENV=production
✅ Database: gunakan user MySQL dengan privilege minimal (bukan root)
✅ Redis: pasang password di production
✅ HTTPS enforce di AppServiceProvider:
```
```php
// app/Providers/AppServiceProvider.php
public function boot(): void {
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }
}
```

### 9.9 Security Headers

```nginx
# nginx config
add_header X-Frame-Options "SAMEORIGIN";
add_header X-Content-Type-Options "nosniff";
add_header X-XSS-Protection "1; mode=block";
add_header Referrer-Policy "strict-origin-when-cross-origin";
add_header Permissions-Policy "geolocation=(), microphone=()";
```

### 9.10 Audit & Logging

```php
// Log setiap transaksi payment
Log::channel('payment')->info('Payment webhook received', [
    'order_id'   => $request->order_id,
    'status'     => $request->transaction_status,
    'amount'     => $request->gross_amount,
    'ip'         => $request->ip(),
    'timestamp'  => now(),
]);
```

---

## 10. API & ROUTE MAP

### 10.1 Halaman Publik (`routes/web.php`)

| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| GET | `/` | HomeController@index | — |
| GET | `/menu` | MenuController@index | — |
| GET | `/menu/{slug}` | MenuController@show | — |
| GET | `/about` | HomeController@about | — |
| GET | `/reservations/create` | ReservationController@create | — |
| POST | `/reservations` | ReservationController@store | auth,verified |

### 10.2 Cart & Order (`routes/web.php`)

| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| POST | `/cart/add` | CartController@add | — |
| GET | `/cart` | CartController@index | — |
| PATCH | `/cart/{item}` | CartController@update | — |
| DELETE | `/cart/{item}` | CartController@remove | — |
| GET | `/checkout` | CheckoutController@index | auth,verified |
| POST | `/checkout` | CheckoutController@store | auth,verified,throttle:checkout |
| GET | `/orders/{order}/tracking` | TrackingController@show | auth |
| GET | `/orders/{order}/success` | OrderController@success | auth |
| GET | `/orders/history` | OrderController@history | auth |

### 10.3 Payment

| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| POST | `/payment/snap-token` | PaymentController@snapToken | auth,throttle |
| POST | `/payment/webhook` | PaymentController@webhook | VerifyMidtransSignature |
| POST | `/payment/{order}/upload-proof` | PaymentController@uploadProof | auth |

### 10.4 Admin (`routes/admin.php`, prefix: `/admin`)

| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| GET | `/dashboard` | DashboardController@index | auth,role:admin |
| RESOURCE | `/menu-items` | MenuItemController | auth,role:admin |
| RESOURCE | `/categories` | CategoryController | auth,role:admin |
| RESOURCE | `/orders` | OrderManagementController | auth,role:admin\|kasir |
| PATCH | `/orders/{order}/status` | OrderManagementController@updateStatus | auth,role:admin\|kasir |
| RESOURCE | `/reservations` | ReservationController | auth,role:admin |
| PATCH | `/reservations/{res}/approve` | ReservationController@approve | auth,role:admin |
| RESOURCE | `/promos` | PromoController | auth,role:admin |
| GET | `/reports` | ReportController@index | auth,role:admin |
| GET | `/reports/export` | ReportController@export | auth,role:admin |

---

## 11. EVENT & QUEUE SYSTEM

### 11.1 Queue Jobs

| Job | Trigger | Queue | Delay |
|-----|---------|-------|-------|
| `SendOrderConfirmationEmail` | Payment webhook berhasil | `emails` | 0 |
| `SendReservationConfirmationEmail` | Reservasi dibuat/diapprove | `emails` | 0 |
| `SendReservationReminderEmail` | Scheduler tiap jam | `emails` | — |
| `CancelExpiredOrders` | Scheduler tiap 15 menit | `orders` | — |
| `ProcessPaymentWebhook` | Webhook diterima | `payments` | 0 |

### 11.2 Broadcast Events (Reverb)

| Event | Channel | Data |
|-------|---------|------|
| `OrderStatusUpdated` | `private-order.{id}` | status, updated_at |
| `NewOrderReceived` | `private-admin.orders` | order_id, order_number, total |
| `PaymentStatusUpdated` | `private-order.{id}` | payment_status |

### 11.3 Supervisor Config

```ini
; /etc/supervisor/conf.d/laravel.conf

[program:laravel-queue-emails]
command=php /var/www/artisan queue:work redis --queue=emails --tries=3
numprocs=2
autostart=true
autorestart=true

[program:laravel-queue-orders]
command=php /var/www/artisan queue:work redis --queue=orders,payments,default
numprocs=1
autostart=true
autorestart=true

[program:laravel-reverb]
command=php /var/www/artisan reverb:start --port=8080
numprocs=1
autostart=true
autorestart=true

[program:laravel-scheduler]
command=php /var/www/artisan schedule:work
numprocs=1
autostart=true
autorestart=true
```

---

## 12. PANDUAN EXTEND FITUR BARU

> Dokumen ini dirancang agar AI agent atau developer dapat menambah fitur baru dengan pola yang konsisten.

### Pola Baku Menambah Fitur Baru

```
CHECKLIST FITUR BARU:
□ 1. Buat Migration (php artisan make:migration)
□ 2. Buat Model + $fillable + relasi (php artisan make:model)
□ 3. Buat Service class di app/Services/ (logic bisnis)
□ 4. Buat Form Request untuk validasi (php artisan make:request)
□ 5. Buat Controller (php artisan make:controller --resource)
□ 6. Daftarkan Route di file route yang sesuai
□ 7. Buat Views di folder yang sesuai (public/admin)
□ 8. Buat Policy jika ada otorisasi (php artisan make:policy)
□ 9. Buat Test (php artisan make:test)
□ 10. Update Seeder jika perlu data dummy
```

### Contoh: Menambah Fitur "Loyalty Points"

```
Migration: create_loyalty_points_table
  - user_id, points, type (earn/redeem), order_id, description

Model: LoyaltyPoint (app/Models/LoyaltyPoint.php)
  - belongsTo User, Order

Service: LoyalityService (app/Services/LoyaltyService.php)
  - earn(userId, orderId): hitung & tambah poin
  - redeem(userId, points): kurangi poin
  - getBalance(userId): total poin aktif

Job: AwardLoyaltyPoints (dipanggil setelah order DONE)

Controller: LoyaltyController (untuk halaman riwayat poin user)

Route: GET /account/loyalty → LoyaltyController@index

View: resources/views/account/loyalty.blade.php
```

### Prinsip Scalability

```
1. THIN CONTROLLER  → Logic di Service, bukan di Controller
2. QUEUE EVERYTHING → Email, notif, kalkulasi berat → pakai Job
3. CACHE AGRESIF    → Menu, kategori, setting → cache dengan tag
4. EVENT-DRIVEN     → Gunakan Event + Listener untuk decouple fitur
5. POLICY FIRST     → Setiap akses resource → cek Policy
6. TEST SETIAP FITUR→ Minimal 1 feature test per endpoint baru
```

---

## 13. ESTIMASI TIMELINE

| Sprint | Minggu | Deliverable |
|--------|--------|-------------|
| 1 | 1 | Setup project Laravel 12, auth, role, CI/CD pipeline |
| 2 | 2 | Database schema, migrations, seeders, model & relasi |
| 3 | 3 | Landing page, halaman menu, filter kategori, search |
| 4 | 4 | Cart system (session + database + merge), halaman cart |
| 5 | 5 | Checkout flow, kalkulasi order, form validasi |
| 6 | 6 | Integrasi Midtrans Snap, webhook, konfirmasi email |
| 7 | 7 | Reservasi meja, cek ketersediaan, email konfirmasi |
| 8 | 8 | Dashboard admin: kelola menu, order, reservasi |
| 9 | 9 | Realtime tracking (Reverb), laporan, export Excel/PDF |
| 10 | 10 | Testing (Pest), security audit, responsive polish |
| 11 | 11 | UAT (User Acceptance Testing), bug fixing |
| 12 | 12 | Deploy ke production, monitoring setup, go-live |

**Total: ~3 bulan untuk MVP production-ready**

---

## CATATAN UNTUK AI AGENT

> Bagian ini khusus untuk AI model yang membaca dokumen ini sebagai context.

```
KEPUTUSAN STACK FRONTEND (PENTING):
- TIDAK menggunakan Flux (UI library Livewire berbayar)
- TIDAK menggunakan komponen UI pihak ketiga (shadcn port, Flowbite, dll)
- GUNAKAN Blade Components custom di resources/views/components/
- GUNAKAN Tailwind CSS utility classes langsung di template
- GUNAKAN Alpine.js untuk interaktivitas ringan (x-data, x-show, x-on)
- GUNAKAN Livewire 3 hanya untuk komponen yang butuh reaktivitas server-side
  (contoh: CartComponent, MenuSearchComponent, OrderTrackerComponent)

ALASAN: Blade Components + Tailwind adalah kombinasi yang paling banyak
terdokumentasi dan paling konsisten dihasilkan oleh AI model.

KONVENSI KODE:
- Bahasa: PHP 8.4 dengan fitur modern (readonly, enums, fiber)
- Enum: gunakan PHP native enum untuk status (OrderStatus, PaymentMethod, dst)
- Service: inject via constructor DI, bukan static call
- Repository Pattern: TIDAK dipakai (Eloquent sudah cukup untuk skala ini)
- API Response: gunakan Laravel API Resource jika ada endpoint API
- Event Naming: past tense (OrderCreated, PaymentReceived)
- Job Naming: imperative (SendEmail, ProcessPayment)

NAMING CONVENTION:
- Controller: PascalCase + "Controller" (CartController)
- Model: PascalCase singular (MenuItem, bukan MenuItems)
- Migration: snake_case (create_menu_items_table)
- Event: PascalCase past tense (OrderStatusUpdated)
- Job: PascalCase imperative (SendOrderConfirmationEmail)
- Service: PascalCase + "Service" (CartService)
- Route name: kebab-case (menu-items.index, orders.tracking)

ENUM CONTOH:
enum OrderStatus: string {
    case Pending    = 'pending';
    case Confirmed  = 'confirmed';
    case Preparing  = 'preparing';
    case Ready      = 'ready';
    case Delivered  = 'delivered';
    case Done       = 'done';
    case Cancelled  = 'cancelled';
    case Failed     = 'failed';
}

SAAT MEMBUAT FITUR BARU:
1. Cek apakah ada Service yang bisa di-reuse
2. Tambahkan route di file yang benar (web.php / admin.php / api.php)
3. Semua logic keuangan (harga, diskon, total) taruh di Service, bukan Controller
4. Semua akses file lewat Storage facade, bukan path langsung
5. Semua email/notif dikirim via Queue Job, bukan synchronous
```

---

*PRD ini mencakup keseluruhan sistem website restoran dari kunjungan pertama user hingga transaksi selesai. Setiap bagian dirancang untuk dapat dikembangkan secara independen tanpa mempengaruhi bagian lain.*
