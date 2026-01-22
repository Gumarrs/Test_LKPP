# Sistem Akreditasi LPPBJ

![Laravel](https://img.shields.io/badge/Laravel-9.52-red) ![PHP](https://img.shields.io/badge/PHP-8.0-blue) ![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple)

Sistem informasi berbasis web untuk pengelolaan data akreditasi LPPBJ (Lembaga Kebijakan Pengadaan Barang/Jasa Pemerintah). Aplikasi ini dirancang untuk mempermudah monitoring status akreditasi, manajemen data instansi, serta pengelolaan pengguna dengan keamanan yang terjamin.

## 🚀 Fitur Utama

- **Dashboard Interaktif**: Visualisasi grafik statistik (Chart.js) untuk memantau status akreditasi & komposisi kategori instansi secara real-time.
- **CRUD Data LPPBJ**: Manajemen data instansi lengkap dengan logika status otomatis (Berlaku, Kurang dari 6 Bulan, Expired).
- **Export Excel**: Fitur unduh laporan data LPPBJ dalam format `.xlsx` menggunakan library `maatwebsite/excel`.
- **Manajemen Akun**: Modul khusus Admin untuk mengelola pengguna (Admin, Asesor, Sekretariat).
- **Keamanan Login**: Halaman login dilengkapi dengan **Captcha Gambar** (mews/captcha) untuk mencegah bot, serta hashing password.
- **Role-Based Access Control (RBAC)**: Pembatasan hak akses menu dan fitur berdasarkan level pengguna (Admin/Asesor/Sekretariat).

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel Framework 9.52.21
- **Language**: PHP 8.0.28
- **Frontend**: Bootstrap 5, Blade Template
- **Database**: MySQL
- **Library Pendukung**:
    - `maatwebsite/excel`: Untuk export data ke Excel.
    - `mews/captcha`: Untuk keamanan form login.
    - `chart.js`: Untuk visualisasi data di dashboard.

## 📦 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal Anda:

### 1. Clone Repository

git clone [https://github.com/Gumarrs/Test_LKPP.git](https://github.com/Gumarrs/Test_LKPP.git)
cd Test_LKPP
### 2. Install Dependencies
Pastikan Composer sudah terinstall, lalu jalankan perintah berikut:
composer install

### 3. Konfigurasi Environment

Buka file .env dengan text editor dan atur koneksi database Anda:

Cuplikan kode

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=

### 4. Generate Key & Setup Database

Generate Application Key:

Bash

php artisan key:generate
Lakukan migrasi database dan seeding data default (User Admin, dll):

Bash

php artisan migrate --seed
Catatan: Jika migrasi gagal, Anda bisa import manual file .sql (jika tersedia di folder database/sql/) melalui phpMyAdmin.

### 5. Jalankan Server
Aktifkan local server Laravel:

Bash

php artisan serve


## 🔑 Akun Demo (Default Seeder)
Gunakan akun berikut untuk masuk ke dalam sistem:

Role	    Email	Password	Akses
Admin	    admin@lkpp.go.id	password	Full Akses (Manajemen User & Data)
Asesor	    asesor@lkpp.go.id	password	Read & Edit Data LPPBJ
Sekretariat	user@lkpp.go.id	    password	Read Only / Input Terbatas