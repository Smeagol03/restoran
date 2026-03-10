# MVP Scope — Restaurant Website (WhatsApp Edition)

**Version:** 1.0  
**Focus:** Speed to Market · Zero Transaction Fee · High Scalability  
**Primary Action:** Checkout to WhatsApp

---

## 1. TUJUAN MVP

Membangun fondasi website restoran yang fungsional bagi pelanggan untuk melihat menu dan memesan tanpa kompleksitas integrasi payment gateway di tahap awal.

---

## 2. FITUR UTAMA (IN-SCOPE)

### 2.1 Manajemen Menu (Admin)

- **Categories:** Pengelompokan menu (Makanan, Minuman, Dessert, dll).
- **Menu Items:** Kelola nama, deskripsi, harga, dan status ketersediaan.
- **Tables:** Manajemen nomor meja untuk pesanan dine-in.

### 2.2 Pengalaman Pelanggan (Frontend)

- **Landing Page:** Hero section, menu unggulan, dan informasi lokasi.
- **Digital Menu:** Daftar menu interaktif dengan filter kategori dan pencarian.
- **Shopping Cart:** Keranjang belanja berbasis Livewire (menyimpan sementara pilihan user).
- **Simple Checkout:** Form pengisian Nama, No. Meja (Dine-in), atau Alamat (Delivery).

### 2.3 Integrasi WhatsApp

- **Auto-Format Message:** Sistem menyusun pesan teks otomatis berisi:
    - Daftar pesanan (Item x Qty)
    - Subtotal & Total Harga
    - Identitas Pelanggan (Nama, Meja/Alamat)
    - Link balik ke pesanan di website (optional).
- **Redirect:** Membuka aplikasi WhatsApp dengan pesan tersebut mengarah ke nomor admin restoran.

---

## 3. FITUR YANG DITUNDA (OUT-OF-SCOPE)

_Fitur ini sudah ada di ERD/PRD utama tapi tidak diaktifkan di tahap MVP:_

- **Midtrans Payment:** Pembayaran otomatis (diganti manual via WA).
- **Real-time Tracking:** Broadcast status via Reverb (status dipantau via chat WA).
- **Reservasi Meja:** Sistem booking kalender (fase selanjutnya).
- **Email Notifications:** Diganti dengan notifikasi WhatsApp.

---

## 4. STRATEGI SKALABILITAS (THE "BRIDGE")

Agar website ini tidak perlu dibongkar ulang saat upgrade, kita akan:

1.  **Database Integrity:** Tetap menggunakan tabel `orders` dan `order_items`. Meskipun data dikirim ke WA, setiap klik "Pesan" akan tetap menyimpan record ke database dengan status `pending`.
2.  **Order Numbering:** Tetap mengenerate `order_number` unik agar admin bisa mencocokkan pesan WA dengan data di database.
3.  **Modular Service:** Logika pengiriman pesan diletakkan di `app/Services/OrderSenderService.php`. Saat beralih ke Midtrans, kita hanya perlu menambah Service baru tanpa mengubah logic Controller utama.

---

## 5. TECH STACK (STRICT TO GEMINI.MD)

- **Framework:** Laravel 12 (LTS ready)
- **UI Components:** Custom Blade Components + Tailwind CSS
- **Reactivity:** Livewire 4
- **Database:** SQLite (dev) / MySQL (prod)

---

## 6. NEXT STEPS (ACTION PLAN)

1.  **Phase 1:** Migrasi & Model (Category, MenuItem, Table, Order).
2.  **Phase 2:** Seeder data dummy & Setup Dashboard Admin sederhana.
3.  **Phase 3:** Halaman publik, Katalog Menu, & Logic Keranjang Belanja.
4.  **Phase 4:** Integrasi tombol WhatsApp Redirect.
