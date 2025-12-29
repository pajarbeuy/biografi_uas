# Biografi Matematikawan - Web Application

Sistem informasi biografi matematikawan berbasis web menggunakan Laravel 11 dan Filament Admin Panel.

## 📋 Deskripsi

Aplikasi ini digunakan untuk mengelola dan menampilkan informasi biografi para matematikawan terkenal, dikategorikan berdasarkan 7 cabang matematika utama.

## ✨ Fitur

- 🔐 **Authentication & Authorization** - Login/Register dengan role-based access (Super Admin, Admin, User)
- 📝 **CRUD Biografi** - Kelola data matematikawan lengkap dengan:
  - Nama, tempat & tanggal lahir/meninggal
  - Kisah hidup (Rich Text Editor)
  - Prestasi dan kontribusi
  - Foto tokoh
  - Kategori cabang matematika
  - Status publikasi (Draft/Published)
- 🗂️ **Kategori** - 7 cabang matematika (Aljabar, Geometri, Kalkulus, Statistika, Teori Bilangan, Analisis, Matematika Diskrit)
- 🎨 **Filament Admin Panel** - Interface admin yang modern dan user-friendly
- 🌐 **Public Pages** - Halaman publik untuk menampilkan profil tokoh

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **Admin Panel:** Filament 3
- **Database:** MySQL
- **Frontend:** Blade Templates, TailwindCSS
- **Authentication:** Laravel Breeze

## 📦 Instalasi

### Quick Start

```bash
# Clone repository
git clone <repository-url>
cd biografi_uas

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
# Edit .env, sesuaikan DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Generate key & setup database
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link

# Run server
php artisan serve
```

**Untuk dokumentasi lengkap, lihat [SETUP.md](SETUP.md)**

## 👥 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@example.com | password |
| Admin | admin@example.com | password |
| User | user@example.com | password |

## 🔄 Git Workflow

Untuk instruksi lengkap push/pull dan kolaborasi tim, lihat [GIT-WORKFLOW.md](GIT-WORKFLOW.md)

**TL;DR untuk yang pull:**
```bash
git pull origin main
composer install
php artisan migrate:fresh --seed
php artisan config:clear
```

## 📁 Struktur Database

### Tabel: `categories`
Cabang-cabang matematika:
- Aljabar
- Geometri
- Kalkulus
- Statistika
- Teori Bilangan
- Analisis
- Matematika Diskrit

### Tabel: `biografis`
Data matematikawan dengan fields:
- `name` - Nama tokoh
- `slug` - URL identifier
- `birth_place`, `birth_date`, `death_date` - Info kelahiran/kematian
- `achievements` - Prestasi & kontribusi
- `life_story` - Kisah hidup lengkap
- `category_id` - Cabang matematika
- `status` - draft/published
- `image_path` - Foto tokoh

## 🚀 Development

### Run Development Server
```bash
php artisan serve
```

### Access Points
- **Public Site:** http://127.0.0.1:8000
- **Admin Panel:** http://127.0.0.1:8000/admin

### Compile Assets (Development)
```bash
npm run dev
```

### Compile Assets (Production)
```bash
npm run build
```

## 📝 Catatan Penting

- ⚠️ Jangan commit file `.env` ke repository
- ⚠️ Gunakan `php artisan migrate:fresh --seed` untuk reset database (akan hapus semua data!)
- ⚠️ Untuk production, gunakan `php artisan migrate` saja tanpa `--fresh`

## 🐛 Troubleshooting

Lihat file [SETUP.md](SETUP.md) atau [GIT-WORKFLOW.md](GIT-WORKFLOW.md) untuk solusi error umum.

## 👨‍💻 Tim Pengembang

UAS - Sistem Informasi Biografi Matematikawan

---

**Last Updated:** 29 Desember 2025
