# AlasKedatonPass

Sistem pemesanan tiket berbasis web untuk Wisata Alas Kedaton, Tabanan, Bali.

## Fitur

**Publik:**
- Pemesanan tiket online tanpa perlu membuat akun
- Nomor order otomatis dengan format `AK-YYYYMMDD-XXXX`
- Konfirmasi pembayaran via WhatsApp dengan pesan otomatis
- Pengecekan status pesanan menggunakan nomor order dan nomor WhatsApp
- Halaman berita dengan pencarian, filter urutan, dan pagination
- Komentar pada artikel berita tanpa perlu akun
- Saran artikel terkait di halaman detail berita
- SEO-friendly dengan meta tags dan sitemap otomatis

**Admin:**
- Kelola order: konfirmasi, batalkan, upload bukti pembayaran
- Kelola jenis tiket: CRUD dengan status aktif/nonaktif
- Kelola artikel: CRUD dengan text editor TinyMCE
- Kelola komentar: lihat dan hapus komentar
- Kelola pengguna: CRUD akun Admin dan Editor
- Halaman Dashboard

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 13, PHP 8.4 |
| Frontend | Blade, TailwindCSS v4, Vanilla JavaScript |
| Rich Text Editor | TinyMCE 6 via CDN |
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

WHATSAPP_NUMBER=6281234567890

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

1. Pengunjung mengisi form pemesanan (nama, WhatsApp, email, tanggal kunjungan, jumlah tiket)
2. Sistem menyimpan order dan membuat nomor order unik
3. Pengunjung transfer sesuai total, lalu klik tombol WhatsApp di halaman sukses untuk mengirim bukti pembayaran ke pengelola
4. Admin membuka panel, cek bukti pembayaran, lalu klik Konfirmasi Pembayaran
5. Pengunjung datang ke lokasi dan menunjukkan nomor order atau screenshot halaman sukses ke petugas
6. Petugas memberikan tiket fisik kepada pengunjung
7. Pengunjung bisa cek status pesanan kapan saja di `/cek-pesanan`

## Jenis Tiket

| Jenis | Kategori | Harga |
|---|---|---|
| Asing Dewasa | Wisatawan Mancanegara | Rp 30.000/pax |
| Asing Anak | Wisatawan Mancanegara | Rp 20.000/pax |
| Domestik Dewasa | Wisatawan Nusantara | Rp 20.000/pax |
| Domestik Anak | Wisatawan Nusantara | Rp 15.000/pax |
| Lokal/Bali | Warga Bali | Rp 10.000/pax |

## Perintah Berguna

```bash
php artisan optimize:clear   # clear semua cache
php artisan migrate          # jalankan migration
php artisan db:seed          # isi data awal
php artisan storage:link     # symlink storage
npm run dev                  # development assets
npm run build                # production assets
```

## Fitur Pending

**Pengiriman e-ticket via email:** placeholder sudah tersedia di `app/Http/Controllers/Admin/OrderController.php` pada method `confirm()`. Untuk mengaktifkan, isi konfigurasi `MAIL_*` di `.env`, buat Mailable dengan `php artisan make:mail ETicketMail`, lalu uncomment baris `Mail::to()` di method tersebut.
