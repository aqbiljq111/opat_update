# OpatUpdate - Sistem Manajemen Forum & Pengumuman

OpatUpdate adalah aplikasi berbasis Laravel yang dirancang untuk manajemen pengumuman dan forum interaktif antara Admin, Guru, dan Siswa.

## Prasyarat (Requirements)

Sebelum menginstal, pastikan Anda telah menginstal software berikut di komputer Anda:
- **PHP** >= 8.2 (Sangat disarankan menggunakan versi terbaru)
- **Composer** (Dependency manager untuk PHP)
- **Node.js & NPM** (Untuk kompilasi asset frontend/Vite)
- **XAMPP / Laragon** (Untuk MySQL dan Apache/Nginx server)

## Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan project ini di komputer lokal Anda:

### 1. Clone Repository
Buka terminal/command prompt, lalu jalankan:
```bash
git clone https://github.com/aqbiljq111/opat_update.git
cd opat_update
```

### 2. Instal Dependency PHP
Jalankan perintah berikut untuk menginstal package yang dibutuhkan oleh Laravel:
```bash
composer install
```

### 3. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Buka file `.env` dan sesuaikan pengaturan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=opat_update
DB_USERNAME=root
DB_PASSWORD=
```
*Catatan: Pastikan Anda sudah membuat database kosong dengan nama `opat_update` di phpMyAdmin.*

### 4. Generate App Key
```bash
php artisan key:generate
```

### 5. Migrasi Database & Seeding
Jalankan migrasi untuk membuat tabel dan masukkan data awal (admin):
```bash
php artisan migrate --seed
```
*Atau jika Anda ingin menjalankan seeder spesifik untuk admin:*
```bash
php artisan db:seed --class=AdminSeeder
```

### 6. Instal Dependency Frontend
Kompilasi asset menggunakan Vite:
```bash
npm install
npm run dev
```

## Akun Login Default (Admin)

Gunakan akun berikut untuk login pertama kali sebagai Admin:
- **Username:** `admin_utama`
- **Password:** `rahasia123`

## Menjalankan Aplikasi

Jalankan perintah berikut untuk memulai server lokal:
```bash
php artisan serve
```
Aplikasi akan tersedia di [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Fitur Utama
- **Role System:** Admin, Guru, dan Siswa.
- **Forum Diskusi:** Siswa dapat bertanya dan berdiskusi di thread forum.
- **Pengumuman:** Admin dan Guru dapat memposting pengumuman penting.
- **Responsive Design:** Desain yang dioptimalkan untuk berbagai perangkat.

---
Dikembangkan oleh **aqbiljq111**.
