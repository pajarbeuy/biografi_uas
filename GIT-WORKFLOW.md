# Git Workflow - Biografi Matematikawan

## Untuk Yang Push ke Main Branch

### 1. Pastikan Semua File Migration & Seeder Sudah Benar
Sebelum push, pastikan:
- ✅ Tidak ada migration yang conflict
- ✅ Migration sudah ditest dengan `php artisan migrate:fresh --seed`
- ✅ File `.env` JANGAN di-commit

### 2. Cek Status Git
```bash
git status
```

### 3. Add & Commit
```bash
git add .
git commit -m "Fix: Update database schema untuk mathematician biographies"
```

### 4. Push ke Main
```bash
git push origin main
```

---

## Untuk Yang Pull dari Main Branch

### Langkah-Langkah Aman Pull Tanpa Error

#### 1. **Stash Perubahan Lokal (Jika Ada)**
```bash
git stash
```

#### 2. **Pull dari Remote**
```bash
git pull origin main
```

#### 3. **Install/Update Dependencies**
Setelah pull, jalankan:
```bash
composer install
npm install
```

#### 4. **Update .env File**
Pastikan file `.env` kamu punya konfigurasi yang benar:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=biografi
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. **PENTING: Rebuild Database**
Karena ada perubahan besar di struktur database, jalankan:
```bash
php artisan migrate:fresh --seed
```

**PERINGATAN:** Perintah ini akan **MENGHAPUS SEMUA DATA** dan membuat ulang tabel!

#### 6. **Clear Cache Laravel**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### 7. **Generate Application Key (Jika Belum)**
```bash
php artisan key:generate
```

#### 8. **Storage Link (Jika Belum)**
```bash
php artisan storage:link
```

#### 9. **Jalankan Server**
```bash
php artisan serve
```

---

## Catatan PENTING untuk Tim

### ⚠️ Jangan Commit File Ini:
- `.env` (sudah ada di .gitignore)
- `/vendor/` (sudah ada di .gitignore)
- `/node_modules/` (sudah ada di .gitignore)
- File temporary atau cache

### 🔄 Setiap Kali Pull & Ada Update Migration:
```bash
# Set semua perintah ini dalam 1 script
composer install
php artisan config:clear
php artisan migrate:fresh --seed
php artisan storage:link
```

### 📝 Migration Terbaru (29 Desember 2025):
- ✅ `create_categories_table` - Tabel untuk cabang matematika
- ✅ `create_biografis_table` - Tabel untuk data matematikawan

### 🗃️ Data yang Akan Di-seed:
1. **Categories:** 7 cabang matematika (Aljabar, Geometri, Kalkulus, Statistika, Teori Bilangan, Analisis, Matematika Diskrit)
2. **Users:** User default untuk testing (cek UserSeeder.php)

---

## Quick Reference Commands

### Untuk Member yang Baru Join
```bash
# Clone repository
git clone <repository-url>
cd biografi_uas

# Setup lengkap
composer install
npm install
cp .env.example .env
# Edit .env sesuaikan DB
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

### Untuk Member yang Sudah Join
```bash
# Setiap kali pull
git pull origin main
composer install
php artisan migrate:fresh --seed
php artisan config:clear
```

---

## Troubleshooting

**Q: Error "Table biografis doesn't exist"**  
A: Jalankan `php artisan migrate:fresh --seed`

**Q: Error "Unknown column 'name'"**  
A: Database schema lama. Jalankan `php artisan migrate:fresh --seed`

**Q: Error "SQLSTATE[HY000] [1045] Access denied"**  
A: Cek konfigurasi database di file `.env`

**Q: Kehilangan data setelah migrate:fresh**  
A: `migrate:fresh` memang menghapus semua data. Untuk production, gunakan `php artisan migrate` saja.
