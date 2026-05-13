# OpatUpdate - Sistem Manajemen Forum & Pengumuman

## 📝 Deskripsi Proyek
OpatUpdate adalah aplikasi berbasis Laravel yang dirancang untuk memfasilitasi manajemen pengumuman dan forum interaktif dalam lingkungan pendidikan. Aplikasi ini memungkinkan komunikasi yang terstruktur antara Admin, Guru, dan Siswa, memastikan informasi penting tersampaikan dengan cepat dan diskusi akademik dapat berjalan dengan baik.

## ✨ Fitur Utama
- **Sistem Role & Autentikasi:** Hak akses yang berbeda untuk Admin, Guru, dan Siswa.
- **Forum Diskusi:** Siswa dapat membuat pertanyaan dan berdiskusi dalam thread yang terorganisir.
- **Manajemen Pengumuman:** Fitur bagi Admin dan Guru untuk memposting informasi penting ke seluruh pengguna.
- **Desain Responsif:** Antarmuka modern yang optimal diakses melalui berbagai perangkat (Desktop & Mobile).
- **Keamanan Data:** Implementasi middleware dan proteksi Laravel untuk keamanan akun.

## 🛠️ Tech Stack we use
- **Backend:** [Laravel 11](https://laravel.com/)
- **Frontend:** Blade Templates, Vanilla CSS (Custom Styling)
- **Asset Manager:** Vite
- **Database:** MySQL
- **Server:** Apache (XAMPP)

## 🎥 Video Demo

[![Video Demo](https://img.shields.io/badge/Video-Demo-red?style=for-the-badge&logo=youtube)](https://link-video-anda.com)


## 📸 Screenshot Website

| Login Page | Dashboard |
| :---: | :---: |
| ![Login Page](https://via.placeholder.com/400x250?text=Screenshot+Login) | ![Dashboard](https://via.placeholder.com/400x250?text=Screenshot+Dashboard) |

| Forum Diskusi | Detail Pengumuman |
| :---: | :---: |
| ![Forum](https://via.placeholder.com/400x250?text=Screenshot+Forum) | ![Pengumuman](https://via.placeholder.com/400x250?text=Screenshot+Pengumuman) |

## 👥 Kelompok & Anggota
**Nama Kelompok:** [Kelompok 6]

- **Anggota 1:** [Aqbil Rashif Anshari]
- **Anggota 2:** [Krysa Putri Hidayah]
- **Anggota 3:** [Yaser Alfonso]

---

## 🚀 Panduan Instalasi

### 1. Prasyarat (Requirements)
- **PHP** >= 8.2
- **Composer**
- **Node.js & NPM**
- **MySQL (XAMPP / Laragon)**

### 2. Langkah Instalasi
1. **Clone Repository**
   ```bash
   git clone https://github.com/aqbiljq111/opat_update.git
   cd opat_update
   ```
2. **Instal Dependency**
   ```bash
   composer install
   npm install
   ```
3. **Konfigurasi .env**
   - Salin `.env.example` ke `.env`
   - Sesuaikan pengaturan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.
4. **Generate Key & Migrasi**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```
5. **Jalankan Aplikasi**
   ```bash
   npm run dev
   php artisan serve
   ```

## 🔐 Akun Default (Admin)
- **Username:** `admin_utama`
- **Password:** `rahasia123`

---
*Dikembangkan untuk keperluan manajemen informasi dan forum sekolah.*
