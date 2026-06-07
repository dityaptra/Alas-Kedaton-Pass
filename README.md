# AlasKedatonPass

Sistem penjualan e-ticket berbasis web untuk Wisata Alas Kedaton, Tabanan, Bali. Dibangun menggunakan Laravel 13 sebagai bagian dari kegiatan pengabdian masyarakat untuk membantu digitalisasi operasional wisata.

## Fitur

- Pemesanan tiket online tanpa perlu membuat akun
- Generate nomor order otomatis sebagai referensi transaksi
- Konfirmasi pembayaran manual via WhatsApp
- Pengecekan status pesanan oleh pengunjung
- Panel administrasi untuk mengelola order, tiket, dan konten berita
- Halaman berita dan informasi seputar wisata
- SEO-friendly dengan meta tags dan sitemap otomatis

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13 (PHP 8.4) |
| Styling | TailwindCSS v4 |
| Interaktivitas | Alpine.js |
| Template | Blade |
| Database | MySQL 8 |
| SEO | artesaos/seotools + spatie/laravel-sitemap |
| Build Tool | Vite |

## Persyaratan

Pastikan lingkungan pengembangan sudah memiliki:

- PHP 8.2 atau lebih baru
- Composer 2.x
- Node.js 18+ dan npm
- MySQL 8.0 atau lebih baru

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/dityaptra/Alas-Kedaton-Pass.git
cd alaskedatonpass
```

### 2. Install Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME="AlasKedatonPass"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alaskedatonpass
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Setup Database

Buat database baru di MySQL dengan nama yang sama seperti nilai `DB_DATABASE` di `.env`, kemudian jalankan migration dan seeder:

```bash
php artisan migrate
php artisan db:seed
```

Seeder akan membuat dua akun default dan lima jenis tiket awal:

| Email | Password | Role |
|---|---|---|
| admin@alaskedaton.com | password | Admin |
| editor@alaskedaton.com | password | Editor |

> **Penting:** Segera ganti password kedua akun ini setelah pertama kali login.

### 5. Storage Link

```bash
php artisan storage:link
```

### 6. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi dapat diakses di:
- **Halaman publik:** http://localhost:8000
- **Panel admin:** http://localhost:8000/admin/login

## Struktur Role

| Role | Akses |
|---|---|
| **Admin** | Akses penuh: kelola order, konfirmasi pembayaran, CRUD tiket, CRUD artikel, CRUD pengguna |
| **Editor** | Terbatas: hanya CRUD artikel dan melihat dashboard |

## Alur Pemesanan Tiket

1. Pengunjung memilih tiket dan mengisi form pemesanan
2. Sistem menyimpan order dan membuat nomor order (format: `AK-YYYYMMDD-XXXX`)
3. Pengunjung melakukan transfer dan mengirim bukti ke WhatsApp pengelola
4. Admin mengkonfirmasi pembayaran melalui panel admin
5. Pengunjung mengecek status pesanan di halaman `/cek-pesanan`

## Jenis Tiket

| Jenis | Harga |
|---|---|
| Asing Dewasa | Rp 30.000/pax |
| Asing Anak | Rp 20.000/pax |
| Domestik Dewasa | Rp 20.000/pax |
| Domestik Anak | Rp 15.000/pax |
| Lokal/Bali | Rp 10.000/pax |

## Fitur yang Masih Dikembangkan

- **Metode pemesanan via hubungi Whatsapp**
- **Pengiriman e-ticket via email** — placeholder kode sudah tersedia di `AdminOrderController`, tinggal mengisi konfigurasi SMTP dan mengaktifkan baris `Mail::to()` di method `confirm()`

## Lisensi

Proyek ini dikembangkan untuk keperluan pengabdian masyarakat.
