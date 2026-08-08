# AlasKedatonPass

Sistem pemesanan tiket berbasis web untuk Wisata Alas Kedaton, Tabanan, Bali.

## Fitur

**Publik:**
- Pemesanan tiket online tanpa perlu membuat akun
- Nomor order otomatis dengan format `AK-YYYYMMDD-XXXX`
- Upload bukti pembayaran langsung dari halaman sukses atau halaman cek pesanan
- Pengecekan status pesanan menggunakan nomor order dan nomor WhatsApp
- Halaman berita dengan pencarian, filter urutan, dan pagination
- Komentar pada artikel berita tanpa perlu akun
- Saran artikel terkait di halaman detail berita
- SEO-friendly dengan meta tags dan sitemap otomatis

**Admin:**
- Kelola order: verifikasi bukti pembayaran, konfirmasi, dan batalkan order
- Kelola jenis tiket: CRUD dengan status aktif/nonaktif
- Kelola artikel: CRUD dengan text editor TinyMCE
- Kelola komentar: lihat dan hapus komentar
- Kelola pengguna: CRUD akun Admin dan Editor
- Dashboard penjualan

**Editor:**
- Kelola artikel: CRUD dengan text editor TinyMCE
- Kelola komentar: lihat dan hapus komentar
- Dashboard artikel & komentar

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13, PHP 8.4 |
| Frontend | Blade, TailwindCSS v4, Vanilla JavaScript |
| Text Editor | TinyMCE 6 via CDN |
| Database | MySQL 8 |
| SEO | artesaos/seotools, spatie/laravel-sitemap |
| Build Tool | Vite |

## Persyaratan

- PHP 8.2 atau lebih baru
- Composer 2.x
- Node.js 18+ dan npm
- MySQL 8.0 atau lebih baru

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/dityaptra/Alas-Kedaton-Pass.git
cd Alas-Kedaton-Pass
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

Sesuaikan konfigurasi berikut di `.env`:

```env
APP_NAME="AlasKedatonPass"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alaskedatonpass
DB_USERNAME=root
DB_PASSWORD=

WHATSAPP_NUMBER=6281234567890   # menyesuaikan (opsional)

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="AlasKedatonPass"
```

### 4. Setup Database

Buat database MySQL dengan nama sesuai nilai `DB_DATABASE` di `.env`, lalu jalankan:

```bash
php artisan migrate
php artisan db:seed
```

Seeder membuat dua akun default:

| Email | Password | Role |
|---|---|---|
| admin@alaskedaton.com | password | Admin |
| editor@alaskedaton.com | password | Editor |

> **Penting:** Ganti password kedua akun ini sebelum digunakan di production.

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

- **Halaman publik:** http://localhost:8000
- **Panel admin:** http://localhost:8000/admin/login

## Role dan Akses

| Role | Akses |
|---|---|
| Admin | Akses penuh ke semua fitur |
| Editor | Hanya artikel, komentar, dan dashboard |

## Alur Pemesanan

1. Pelanggan mengisi form pemesanan (nama, WhatsApp, email, tanggal kunjungan, jumlah tiket)
2. Sistem menyimpan order dan membuat nomor order unik
3. Pelanggan transfer sesuai total ke rekening pengelola
4. Pelanggan upload foto bukti transfer di halaman sukses atau lewat menu Cek Pesanan
5. Admin membuka panel, melihat bukti pembayaran, lalu klik Konfirmasi jika valid
6. Pelanggan datang ke lokasi dan menunjukkan nomor order ke petugas
7. Petugas memberikan tiket fisik kepada pelanggan

> **Catatan:** Pelanggan disarankan menyimpan atau screenshot nomor order sebelum menutup halaman sukses, karena nomor order diperlukan untuk mengecek status pesanan dan mengupload bukti pembayaran jika halaman sukses sudah ditutup.

## Jenis Tiket

| Jenis | Kategori | Harga |
|---|---|---|
| Asing Dewasa | Wisatawan Mancanegara | Rp 30.000/pax |
| Asing Anak | Wisatawan Mancanegara | Rp 20.000/pax |
| Domestik Dewasa | Wisatawan Nusantara | Rp 20.000/pax |
| Domestik Anak | Wisatawan Nusantara | Rp 15.000/pax |
| Lokal/Bali | Warga Bali | Rp 10.000/pax |

## Keterbatasan Sistem

Beberapa hal yang belum diimplementasikan pada sistem:

- **Manajemen kuota tiket harian**: sistem saat ini tidak membatasi jumlah tiket yang bisa dipesan per hari. Solusi sementara adalah admin memantau jumlah order per tanggal dan menonaktifkan tiket secara manual jika kapasitas sudah terpenuhi
- **Pengiriman e-ticket via email**: placeholder sudah tersedia di `app/Http/Controllers/Admin/OrderController.php` pada method `confirm()`. Untuk mengaktifkan, isi konfigurasi `MAIL_*` di `.env`, buat Mailable dengan `php artisan make:mail ETicketMail`, lalu uncomment baris `Mail::to()` di method tersebut
- **Login pelanggan**: sistem saat ini tidak menyediakan akun untuk pelanggan. Pelanggan mengakses pesanan lewat nomor order dan nomor WhatsApp di halaman Cek Pesanan

## Perintah Berguna

```bash
php artisan optimize:clear   # clear semua cache
php artisan migrate          # jalankan migration
php artisan db:seed          # isi data awal
php artisan storage:link     # symlink storage
npm run dev                  # development assets
npm run build                # production assets
```

