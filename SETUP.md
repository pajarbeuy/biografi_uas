# Setup Guide - Biografi Matematikawan

Panduan lengkap instalasi dependency dari awal untuk sistem informasi biografi matematikawan berbasis web.

---

## 📋 Daftar Isi

1. [Instalasi Prerequisite Software](#1-instalasi-prerequisite-software)
2. [Clone Repository](#2-clone-repository)
3. [Instalasi Dependencies PHP](#3-instalasi-dependencies-php)
4. [Instalasi Dependencies JavaScript](#4-instalasi-dependencies-javascript)
5. [Konfigurasi Environment](#5-konfigurasi-environment)
6. [Setup Database](#6-setup-database)
7. [Generate Application Key](#7-generate-application-key)
8. [Setup Storage](#8-setup-storage)
9. [Menjalankan Migrations dan Seeders](#9-menjalankan-migrations-dan-seeders)
10. [Build Frontend Assets](#10-build-frontend-assets)
11. [Menjalankan Aplikasi](#11-menjalankan-aplikasi)
12. [Akun Default](#akun-default)
13. [Troubleshooting](#troubleshooting)

---

## 1. Instalasi Prerequisite Software

Sebelum memulai, pastikan Anda sudah menginstall software-software berikut:

### A. Laragon (Rekomendasi untuk Windows)

**Laragon** adalah environment yang sudah include PHP, MySQL, dan Apache/Nginx.

1. **Download Laragon**
   - Kunjungi: https://laragon.org/download/
   - Download versi **Laragon Full** (sudah include PHP, MySQL, Node.js)

2. **Install Laragon**
   - Jalankan installer yang sudah didownload
   - Ikuti wizard instalasi (default setting sudah cukup)
   - Laragon akan terinstall di `C:\laragon` secara default

3. **Start Laragon**
   - Buka aplikasi Laragon
   - Klik tombol **"Start All"** untuk menjalankan Apache dan MySQL

4. **Cek Versi PHP**
   - Buka **Terminal** di Laragon (klik kanan > Terminal)
   - Jalankan:
     ```bash
     php -v
     ```
   - Pastikan versi PHP 8.2 atau lebih tinggi

### B. Composer (PHP Package Manager)

Jika belum terinstall (biasanya sudah include di Laragon Full):

1. **Download Composer**
   - Kunjungi: https://getcomposer.org/download/
   - Download **Composer-Setup.exe**

2. **Install Composer**
   - Jalankan installer
   - Pilih PHP yang ada di Laragon: `C:\laragon\bin\php\php-8.x.x\php.exe`
   - Selesaikan instalasi

3. **Cek Instalasi Composer**
   ```bash
   composer --version
   ```

### C. Node.js & NPM (JavaScript Package Manager)

Jika belum terinstall:

1. **Download Node.js**
   - Kunjungi: https://nodejs.org/
   - Download versi **LTS** (Long Term Support)

2. **Install Node.js**
   - Jalankan installer
   - Ikuti wizard instalasi (default setting sudah cukup)
   - NPM akan terinstall otomatis bersama Node.js

3. **Cek Instalasi**
   ```bash
   node --version
   npm --version
   ```

### D. Git (Version Control)

Jika belum terinstall:

1. **Download Git**
   - Kunjungi: https://git-scm.com/downloads
   - Download untuk Windows

2. **Install Git**
   - Jalankan installer
   - Ikuti wizard instalasi (default setting sudah cukup)

3. **Cek Instalasi**
   ```bash
   git --version
   ```

---

## 2. Clone Repository

1. **Buat Folder Project di Laragon**
   - Project Laravel di Laragon sebaiknya di: `C:\laragon\www\`
   - Buka Terminal/Command Prompt
   - Masuk ke folder `www`:
     ```bash
     cd C:\laragon\www
     ```

2. **Clone Repository**
   ```bash
   git clone <URL_REPOSITORY> biografi_uas
   ```
   Ganti `<URL_REPOSITORY>` dengan URL repository Anda.

3. **Masuk ke Folder Project**
   ```bash
   cd biografi_uas
   ```

---

## 3. Instalasi Dependencies PHP

Setelah clone repository, install semua package PHP yang dibutuhkan:

```bash
composer install
```

**Penjelasan:**
- Perintah ini akan membaca file `composer.json` dan menginstall semua dependencies Laravel dan package PHP lainnya
- Semua package akan didownload ke folder `vendor/`
- Proses ini mungkin butuh beberapa menit tergantung koneksi internet

**Jika ada error:**
```bash
composer install --ignore-platform-reqs
```

---

## 4. Instalasi Dependencies JavaScript

Install semua package JavaScript yang dibutuhkan (untuk frontend):

```bash
npm install
```

**Penjelasan:**
- Perintah ini akan membaca file `package.json` dan menginstall dependencies seperti Vite, TailwindCSS, dll
- Semua package akan didownload ke folder `node_modules/`
- Proses ini mungkin butuh beberapa menit

**Alternatif (jika npm lambat):**
```bash
npm install --legacy-peer-deps
```

---

## 5. Konfigurasi Environment

Laravel menggunakan file `.env` untuk konfigurasi environment seperti database, app key, dll.

### A. Copy File Environment

```bash
copy .env.example .env
```

Atau di Linux/Mac:
```bash
cp .env.example .env
```

### B. Edit File `.env`

Buka file `.env` dengan text editor (Notepad++, VS Code, dll) dan sesuaikan konfigurasi berikut:

```env
# Nama Aplikasi
APP_NAME="Biografi Matematikawan"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biografi
DB_USERNAME=root
DB_PASSWORD=
```

**Penjelasan:**
- `APP_NAME`: Nama aplikasi Anda
- `APP_ENV`: Environment (local untuk development)
- `APP_DEBUG`: Set `true` untuk development agar error detail muncul
- `DB_DATABASE`: Nama database (akan kita buat di langkah berikutnya)
- `DB_USERNAME`: Username MySQL (default: `root`)
- `DB_PASSWORD`: Password MySQL (default kosong di Laragon)

---

## 6. Setup Database

### A. Buat Database Baru

**Metode 1: Lewat phpMyAdmin**
1. Buka browser dan akses: http://localhost/phpmyadmin
2. Klik tab **"Databases"**
3. Masukkan nama database: `biografi`
4. Pilih **Collation**: `utf8mb4_unicode_ci`
5. Klik **"Create"**

**Metode 2: Lewat Laragon Terminal**
1. Buka Terminal di Laragon
2. Login ke MySQL:
   ```bash
   mysql -u root
   ```
3. Buat database:
   ```sql
   CREATE DATABASE biografi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   EXIT;
   ```

### B. Verifikasi Koneksi Database

Cek apakah Laravel bisa connect ke database:

```bash
php artisan migrate:status
```

Jika muncul pesan tanpa error, berarti koneksi berhasil.

---

## 7. Generate Application Key

Laravel membutuhkan application key untuk enkripsi. Generate key dengan:

```bash
php artisan key:generate
```

**Penjelasan:**
- Perintah ini akan generate key random dan menyimpannya di `APP_KEY` di file `.env`
- Key ini digunakan untuk enkripsi session, cookies, dan data sensitif lainnya
- **PENTING:** Jangan share key ini ke orang lain!

---

## 8. Setup Storage

Laravel menyimpan file upload di folder `storage/`. Untuk bisa diakses publik, kita perlu buat symbolic link:

```bash
php artisan storage:link
```

**Penjelasan:**
- Perintah ini membuat symbolic link dari `public/storage` ke `storage/app/public`
- Setelah ini, foto tokoh yang diupload bisa diakses lewat URL
- Jika error, lihat bagian [Troubleshooting](#troubleshooting)

---

## 9. Menjalankan Migrations dan Seeders

### A. Jalankan Migrations

Migrations akan membuat struktur tabel database:

```bash
php artisan migrate:fresh --seed
```

**Penjelasan:**
- `migrate:fresh`: Drop semua tabel dan buat ulang dari awal
- `--seed`: Jalankan seeder untuk mengisi data awal
- Perintah ini akan membuat tabel:
  - `users` - Data pengguna
  - `categories` - Kategori/cabang matematika
  - `biografis` - Data biografi matematikawan
  - Dan tabel sistem lainnya (migrations, password_resets, sessions, dll)

### B. Data yang Dibuat oleh Seeder

Seeder akan mengisi:
1. **Tabel Categories** dengan 7 cabang matematika:
   - Aljabar
   - Geometri
   - Kalkulus
   - Statistika
   - Teori Bilangan
   - Analisis
   - Matematika Diskrit

2. **Tabel Users** dengan 3 akun default (lihat bagian [Akun Default](#akun-default))

---

## 10. Build Frontend Assets

Laravel menggunakan Vite untuk compile CSS dan JavaScript.

### Untuk Development (Recommended)

Jalankan Vite dev server (akan auto-reload saat ada perubahan):

```bash
npm run dev
```

**Catatan:** Biarkan terminal ini tetap running selama development.

### Untuk Production

Build assets untuk production (minified dan optimized):

```bash
npm run build
```

---

## 11. Menjalankan Aplikasi

### A. Start Laravel Development Server

Buka terminal baru (jangan tutup terminal `npm run dev` jika masih running) dan jalankan:

```bash
php artisan serve
```

**Penjelasan:**
- Aplikasi akan berjalan di: http://127.0.0.1:8000
- Buka URL tersebut di browser

### B. Alternatif: Menggunakan Apache (Laragon)

Jika ingin menggunakan Apache:

1. Pastikan project di `C:\laragon\www\biografi_uas`
2. Di Laragon, klik kanan > **Apache** > **Virtual Hosts** > **Auto Create**
3. Akses lewat: http://biografi_uas.test

---

## Akun Default

Setelah seeding, gunakan akun berikut untuk login:

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| Super Admin | superadmin@example.com | password | Full access + Filament Panel |
| Admin | admin@example.com | password | Manage biografi |
| User | user@example.com | password | View biografi |

**Login Page:**
- Admin Panel (Filament): http://127.0.0.1:8000/admin
- User Login: http://127.0.0.1:8000/login

---

## Struktur Database

### Tabel: `categories`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | Primary key |
| name | varchar | Nama cabang matematika |
| slug | varchar | URL-friendly (auto-generated) |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### Tabel: `biografis`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | Primary key |
| name | varchar | Nama matematikawan |
| slug | varchar | URL-friendly (auto-generated) |
| birth_place | varchar | Tempat lahir |
| birth_date | date | Tanggal lahir |
| death_date | date (nullable) | Tanggal meninggal |
| achievements | text | Prestasi/kontribusi |
| life_story | longtext | Kisah hidup (Rich Text) |
| category_id | bigint | Foreign key ke `categories` |
| user_id | bigint | Foreign key ke `users` (pembuat) |
| status | enum | draft / published |
| image_path | varchar (nullable) | Path foto tokoh |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

### Tabel: `users`

| Column | Type | Keterangan |
|--------|------|------------|
| id | bigint | Primary key |
| name | varchar | Nama user |
| email | varchar | Email (unique) |
| password | varchar | Password (hashed) |
| role | enum | super_admin / admin / user |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

---

## Troubleshooting

### ❌ Error: "Base table or view not found"

**Penyebab:** Database belum di-migrate atau tabel belum dibuat.

**Solusi:**
```bash
php artisan migrate:fresh --seed
```

---

### ❌ Error: "Class not found" / "Class 'X' not found"

**Penyebab:** Autoload belum di-update setelah install dependencies.

**Solusi:**
```bash
composer install
composer dump-autoload
```

---

### ❌ Error: "The stream or file could not be opened"

**Penyebab:** Laravel tidak bisa write ke folder `storage/` atau `bootstrap/cache/`.

**Solusi:**

**Windows:**
- Pastikan folder tidak read-only
- Klik kanan folder `storage` dan `bootstrap/cache` > Properties > uncheck "Read-only"

**Linux/Mac:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

### ❌ Error: "No application encryption key has been specified"

**Penyebab:** `APP_KEY` di file `.env` kosong.

**Solusi:**
```bash
php artisan key:generate
```

---

### ❌ Error: "The storage link could not be created"

**Penyebab:** Symbolic link sudah ada atau permission error.

**Solusi:**

1. Hapus link lama:
   ```bash
   # Windows
   rmdir public\storage
   
   # Linux/Mac
   rm public/storage
   ```

2. Buat ulang:
   ```bash
   php artisan storage:link
   ```

---

### ❌ Error: "Connection refused" saat akses database

**Penyebab:** MySQL belum running atau konfigurasi `.env` salah.

**Solusi:**

1. Pastikan MySQL running di Laragon (Start All)
2. Cek konfigurasi di `.env`:
   ```env
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Test koneksi:
   ```bash
   php artisan migrate:status
   ```

---

### ❌ Error: "npm install" gagal

**Penyebab:** Conflict dependencies atau versi Node.js terlalu lama.

**Solusi:**

1. Update Node.js ke versi LTS terbaru
2. Clear cache NPM:
   ```bash
   npm cache clean --force
   ```
3. Install ulang:
   ```bash
   npm install --legacy-peer-deps
   ```

---

### ❌ Error: "Vite manifest not found"

**Penyebab:** Frontend assets belum di-build.

**Solusi:**
```bash
npm run dev
```
Atau untuk production:
```bash
npm run build
```

---

### ❌ Error: "Too many redirects" setelah login

**Penyebab:** Masalah routing atau middleware.

**Solusi:**

1. Clear cache aplikasi:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

2. Restart server:
   ```bash
   # Ctrl+C untuk stop server
   php artisan serve
   ```

---

## Catatan Penting untuk Development

### ✅ Best Practices

1. **Jangan commit file `.env`**
   - File ini berisi konfigurasi sensitif (password, key)
   - Sudah ada di `.gitignore`

2. **Selalu pull terbaru sebelum coding**
   ```bash
   git pull origin main
   ```

3. **Update autoload setelah buat class/model baru**
   ```bash
   composer dump-autoload
   ```

4. **Jalankan migration setelah pull (jika ada migration baru)**
   ```bash
   php artisan migrate
   ```

5. **Rebuild assets setelah pull (jika ada perubahan frontend)**
   ```bash
   npm install
   npm run dev
   ```

### 🔄 Workflow Development

1. Pull terbaru dari repository
2. Cek apakah ada migration baru (jalankan `php artisan migrate`)
3. Cek apakah ada dependencies baru (jalankan `composer install` dan `npm install`)
4. Mulai development server (`npm run dev` dan `php artisan serve`)
5. Coding
6. Test fitur
7. Commit dan push

---

## Perintah Berguna

```bash
# Clear all cache
php artisan optimize:clear

# Generate autoload files
composer dump-autoload

# Recreate database (HATI-HATI: Hapus semua data!)
php artisan migrate:fresh --seed

# Cek routes yang tersedia
php artisan route:list

# Cek status migrations
php artisan migrate:status

# Rollback migration terakhir
php artisan migrate:rollback

# Create new migration
php artisan make:migration create_table_name

# Create new model
php artisan make:model ModelName

# Create new controller
php artisan make:controller ControllerName
```

---

## Support

Jika ada pertanyaan atau masalah, silakan:
- Buat issue di repository
- Hubungi maintainer project
- Check dokumentasi Laravel: https://laravel.com/docs

---

**Selamat Coding! 🚀**
