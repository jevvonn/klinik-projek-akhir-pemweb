# 🏥 Setup Guide - Sistem Manajemen RS (Klinik-Farmasi-Gudang)

## 📋 Persyaratan Sistem

### Software yang Dibutuhkan:

-   **PHP**: Versi 8.2 atau lebih tinggi
-   **Composer**: Untuk dependency management PHP
-   **Node.js**: Versi 18+ (untuk Vite dan Tailwind CSS)
-   **Database**: SQLite (default) atau MySQL/PostgreSQL
-   **Web Server**:
    -   XAMPP/WAMPP (Windows)
    -   MAMP (macOS)
    -   LAMP (Linux)
    -   Atau Laravel built-in server

---

## 🚀 Langkah-langkah Setup

### 1. Clone/Download Project

```bash
# Jika menggunakan Git
git clone [repository-url]

# Atau download ZIP dan extract ke folder htdocs XAMPP
# Lokasi: C:\xampp\htdocs\projek-akhir-pemweb
```

### 2. Install Dependencies PHP

```bash
# Masuk ke direktori project
cd projek-akhir-pemweb

# Install dependencies dengan Composer
composer install
```

### 3. Install Dependencies Frontend

```bash
# Install Node.js dependencies
npm install

# Atau jika menggunakan yarn
yarn install
```

### 4. Setup Environment

```bash
# Copy file environment example
copy .env.example .env
# Atau di Linux/macOS: cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Konfigurasi Database

#### Opsi A: SQLite (Recommended - Mudah)

```bash
# Buat file database SQLite
touch database/database.sqlite
# Atau di Windows: type nul > database\database.sqlite
```

File `.env` sudah dikonfigurasi untuk SQLite:

```dotenv
DB_CONNECTION=sqlite
# DB_HOST, DB_PORT, dll dikomen untuk SQLite
```

#### Opsi B: MySQL (Jika ingin menggunakan MySQL)

Edit file `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rs_management
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian buat database `rs_management` di phpMyAdmin.

### 6. Setup Database Schema

```bash
# Jalankan migration untuk membuat tabel
php artisan migrate

# Jalankan seeder untuk data dummy (opsional)
php artisan db:seed
```

### 7. Compile Assets Frontend

```bash
# Untuk development (dengan hot reload)
npm run dev

# Atau untuk production (compile sekali)
npm run build
```

### 8. Jalankan Server

```bash
# Menggunakan Laravel built-in server
php artisan serve

# Atau jika ingin custom port
php artisan serve --port=8006
```

---

## 🔑 Login Credentials

### Default Users (Setelah Seeding):

-   **Admin Klinik**:

    -   Email: `admin.klinik@rs.com`
    -   Password: `password123`
    -   Role: `ADMIN_KLINIK`

-   **Admin Farmasi**:

    -   Email: `admin.farmasi@rs.com`
    -   Password: `password123`
    -   Role: `ADMIN_FARMASI`

-   **Admin Gudang**:
    -   Email: `admin.gudang@rs.com`
    -   Password: `password123`
    -   Role: `ADMIN_GUDANG`

---

## 📁 Struktur Project

```
projek-akhir-pemweb/
├── app/
│   ├── Http/Controllers/     # Controllers untuk semua modul
│   │   ├── AuthController.php
│   │   ├── ClinicController.php
│   │   ├── StokFarmasiController.php
│   │   ├── GudangController.php
│   │   └── SupplierController.php
│   └── Models/              # Model database
│       ├── User.php
│       ├── ClinicRequest.php
│       ├── Obat.php
│       └── StokFarmasi.php
├── resources/
│   └── views/
│       ├── auth/           # Halaman login
│       └── dashboard/      # Dashboard modules
│           ├── klinik/
│           ├── farmasi/
│           └── gudang/
├── routes/
│   └── web.php            # Route definitions
└── database/
    └── migrations/        # Database schema
```

---

## 🌐 URL Access

Setelah server berjalan, akses melalui:

-   **Base URL**: `http://localhost:8000` (atau port yang dipilih)
-   **Login**: `http://localhost:8000/login`
-   **Dashboard**: `http://localhost:8000/dashboard`

### Module URLs:

-   **Klinik**: `/dashboard/klinik`
-   **Farmasi**: `/dashboard/farmasi`
-   **Gudang**: `/dashboard/gudang`
-   **Suppliers**: `/dashboard/suppliers`

---

## 🔧 Troubleshooting

### Error: "Class not found"

```bash
composer dump-autoload
```

### Error: "SQLSTATE connection refused"

-   Pastikan database service berjalan
-   Cek konfigurasi `.env` file
-   Untuk SQLite: pastikan file `database/database.sqlite` ada

### Error: "Vite manifest not found"

```bash
npm run build
```

### Error: "Permission denied" (Linux/macOS)

```bash
sudo chown -R $USER:$USER storage bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

### Clear Cache (Jika ada masalah view/route)

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 📱 Fitur Sistem

### 🏥 Modul Klinik

-   Registrasi pasien baru
-   Input diagnosa dan resep
-   Request obat ke farmasi

### 💊 Modul Farmasi

-   Manajemen stok obat
-   Validasi resep dari klinik
-   CRUD data obat
-   Request obat ke gudang

### 📦 Modul Gudang

-   Manajemen stok gudang
-   Kelola supplier
-   Proses request dari farmasi
-   History transaksi

---

## ⚡ Quick Commands

```bash
# Start development
php artisan serve & npm run dev

# Reset database
php artisan migrate:fresh --seed

# Check system status
php artisan about

# View routes
php artisan route:list
```

---

## 👥 Tim Development

Pastikan setiap anggota tim:

1. ✅ Install semua software requirements
2. ✅ Follow setup steps sampai selesai
3. ✅ Test login dengan credentials yang disediakan
4. ✅ Verifikasi semua modul dapat diakses
5. ✅ Koordinasi sebelum melakukan perubahan code

---

## 📞 Support

Jika ada masalah durante setup:

1. Check troubleshooting section dulu
2. Pastikan mengikuti langkah setup secara berurutan
3. Koordinasi dengan tim jika ada error yang tidak terdaftar

**Happy Coding!** 🎉
