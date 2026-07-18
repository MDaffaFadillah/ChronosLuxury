# ChronosLuxury

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-%5E8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

*The Boutique of Exceptional Timepieces — Platform e-commerce premium untuk jam tangan mewah.*

## 📖 Tentang Aplikasi

ChronosLuxury adalah platform e-commerce yang dirancang secara khusus untuk memenuhi kebutuhan pasar kolektor dan pecinta jam tangan kelas atas. Platform ini memberikan pengalaman berbelanja premium secara digital, lengkap dengan fitur pencarian yang spesifik (berdasarkan spesifikasi movement, material, dll.), manajemen keranjang belanja, proses checkout terintegrasi dengan validasi ketersediaan riil (*stock lock*), dan panel manajemen butik untuk administrator.

Bagi mereka yang menginginkan pengalaman mewah selayaknya mengunjungi butik jam eksklusif, ChronosLuxury menawarkan etalase digital yang elegan dan detail.

---

## ✨ Fitur Utama

### Pengunjung (Publik)
- **Katalog Eksklusif**: Menelusuri seluruh koleksi jam tangan premium.
- **Pencarian & Filter Canggih**: Mencari berdasarkan nama, nomor referensi, mengurutkan berdasarkan harga/terbaru, dan menyaring berdasarkan kategori atau status ketersediaan stok.
- **Detail Teknis Lengkap**: Menyajikan spesifikasi seperti *case material*, dial, movement, power reserve, dll.
- **Halaman Statis & Interaktif**: Beranda (menampilkan *featured items*), halaman Tentang Kami, dan form Kontak.

### Pelanggan (Customer)
- **Otentikasi Aman**: Registrasi, login, lupa kata sandi (*reset password*).
- **Manajemen Keranjang (Cart)**: Menambah jam tangan ke keranjang belanja, memperbarui jumlah, atau menghapus item.
- **Checkout Aman**: Pemrosesan checkout dengan penguncian database (*stock lock* via database transaction) untuk mencegah overselling.
- **Riwayat Pesanan**: Pelanggan dapat memantau pesanan yang *pending*, diproses, dikirim, atau telah selesai secara terpusat di Dashboard.
- **Manajemen Profil**: Pengaturan nama, email, penggantian password, dan penghapusan akun mandiri.

### Administrator
- **Dashboard Analitik**: Ringkasan total pendapatan dari pesanan yang sukses, jumlah koleksi, jumlah pelanggan, dan daftar pesanan terbaru.
- **Manajemen Pesanan (*Order Management*)**: Memperbarui status pesanan. Mendukung auto-restore stok apabila pesanan dibatalkan (*cancelled*).
- **Katalog Administrator**: Mengelola data Produk dan Kategori (CRUD), lengkap dengan manajemen upload foto.

---

## 🛠️ Tech Stack

| Kategori | Teknologi | Versi |
|---|---|---|
| **Backend** | Laravel | ^12.0 |
| **Language** | PHP | ^8.2 |
| **Frontend** | Blade, Alpine.js | ^3.4.2 |
| **Styling** | Tailwind CSS | ^3.1.0 |
| **Build Tool** | Vite | ^7.0.7 |
| **HTTP Client** | Axios | ^1.11.0 |
| **Database** | SQLite (Default Dev) | Bawaan PHP |
| **Auth** | Laravel Breeze | ^2.4 |
| **Testing** | PHPUnit | ^11.5 |

---

## 📋 Prasyarat

Sebelum memulai, pastikan perangkat lunak berikut telah terinstal pada sistem Anda:
- **PHP** (Versi 8.2 atau yang lebih tinggi)
- **Composer** (Dependency manager untuk PHP)
- **Node.js** dan **npm** (Versi LTS terbaru)
- Ekstensi PHP yang dibutuhkan Laravel standar (seperti PDO, SQLite3/MySQL, OpenSSL, Mbstring, dsb).

---

## 🚀 Instalasi & Setup

Ikuti panduan berikut untuk melakukan instalasi dari nol:

1. **Clone Repository ini**
   ```bash
   git clone [URL_REPO]
   cd ChronosLuxury
   ```

2. **Install Dependensi Backend & Frontend**
   ```bash
   composer install
   npm install
   ```

3. **Pengaturan Environment**
   Salin file environtment *example* bawaan:
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

## 🗄️ Database Setup

Aplikasi ini menggunakan SQLite secara bawaan (tersentralisasi pada file `database/database.sqlite`). Untuk mengatur struktur basis data awal beserta dummy datanya:

```bash
php artisan migrate --seed
```

**Kredensial Default (Dari Seeder):**
Gunakan akun ini untuk keperluan login pada masa pengembangan/testing:
- **Admin:** `admin@chronosluxury.com` | Password: `password`
- **Customer:** `customer@chronosluxury.com` | Password: `password`

---

## ⚙️ Konfigurasi Environment (`.env`)

Sebagian besar pengaturan default di `.env` telah disesuaikan agar aplikasi langsung berjalan lancar menggunakan `SQLite`. Berikut beberapa variabel krusial yang bisa Anda rubah:
- `APP_URL`: Pastikan disetel ke URL host (contoh: `http://localhost:8000`).
- `DB_CONNECTION`: Ubah ke `mysql` atau `pgsql` jika Anda ingin mengintegrasikan DBMS eksternal (jangan lupa isi `DB_DATABASE`, `DB_USERNAME`, dll).
- `MAIL_*`: Konfigurasikan SMTP kredensial seperti Mailtrap, Mailgun, dll jika Anda berniat menggunakan fitur "Forgot Password" (Kirim Email Reset).

---

## ▶️ Menjalankan Aplikasi

Anda wajib menjalankan **dua terminal terpisah** di dalam direktori project untuk mem-build *frontend UI* dan menjalankan server PHP secara simultan.

**Terminal 1 (Backend - PHP Development Server):**
```bash
php artisan serve
```

**Terminal 2 (Frontend - Vite Dev Server):**
```bash
npm run dev
```

Aplikasi siap diakses di: [http://localhost:8000](http://localhost:8000)

---

## 🧪 Testing

Aplikasi ini dilengkapi dengan sekumpulan testing menggunakan **PHPUnit** (Berada pada direktori `tests/Feature` dan `tests/Unit`). Proses uji coba menggunakan basis data sementara (`:memory:` SQLite).

Untuk menjalankan testing suite:
```bash
php artisan test
```

---

## 📁 Struktur Folder Utama

```html
ChronosLuxury/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/         # Logic untuk panel administrator
│   │   │   ├── Auth/          # Pengaturan Autentikasi (Breeze)
│   │   │   ├── Customer/      # Dasbor khusus pengguna terdaftar
│   │   │   └── ...            # Controller area publik (Home, Product, Cart)
│   │   └── Middleware/        # AdminMiddleware (Proteksi Akses)
│   └── Models/                # Kelas Entitas: Product, Category, Order, Cart, User
├── database/
│   ├── migrations/            # Skema basis data
│   └── seeders/               # Contoh data utama & akun dummy (AdminSeeder, ProductSeeder)
├── public/                    
│   └── assets/images/         # Folder tempat unggahan foto jam berlangsung
├── resources/
│   └── views/                 # Kumpulan kerangka tampilan Blade + Tailwind classes
└── routes/
    ├── web.php                # Routing front-facing aplikasi & proteksi Admin
    └── auth.php               # Routing spesifik Autentikasi
```

---

## 👥 Role & Akses

Aplikasi ini menggunakan lapisan Middleware laravel untuk mengelola otorisasi:
- **`auth` middleware**: Digunakan pada jalur yang membutuhkan *login* seperti pengaksesan keranjang (`/cart`), checkout (`/checkout`), pesanan (`/orders`), dan profil pengguan (`/profile`). Akses paksa akan diarahkan kembali ke layar Login.
- **`admin` middleware**: (*Custom*) Mengamankan seluruh rute panel (`/admin/*`). Middleware ini melakukan cek fungsi `.isAdmin()` pada akun bersangkutan. Hanya `Role` Admin yang diijinkan lewat, yang lain akan mendapat halaman Error `403 (Unauthorized)`.

---

## 🤝 Kontribusi

Kami dengan lapang hati menerima seluruh dukungan kontribusi, ide-ide *issue tracking* dan tentu saja *pull request* guna memperhalus aplikasi ini.
1. *Fork* repositori ini.
2. Buat *Branch* khusus untuk penyesuaian Anda (`git checkout -b feature/AmazingUpdate`).
3. Komit perubahan Anda (`git commit -m 'Menambahkan Fitur ABC'`).
4. Lempar *Push* ke repositori *Branch* Anda (`git push origin feature/AmazingUpdate`).
5. Buka **Pull Request** (*PR*) di GitHub.

## 📄 Lisensi

Proyek aplikasi perangkat lunak (*software*) ini didistribusikan & dirilis ke publik secara sumber terbuka *(open-source)* dengan berlisensi penuh di bawah pengawasan [MIT license](https://opensource.org/licenses/MIT).

## 👤 Penulis

**[Muhammad Daffa Fadillah]**

*(Dokumentasi teknis dibuat bersandingan dengan rilis PRD - Juli 2026).*
