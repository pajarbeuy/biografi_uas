# 📢 PESAN UNTUK TIM - WAJIB BACA!

## ⚠️ PERUBAHAN BESAR - Database Schema Update

**Tanggal:** 29 Desember 2025  
**Oleh:** [Your Name]

### 🔴 SANGAT PENTING!

Setelah pull commit ini, **WAJIB** jalankan perintah berikut agar tidak error:

```bash
composer install
php artisan migrate:fresh --seed
php artisan config:clear
```

### ❗ Apa yang Berubah?

1. **Struktur tabel `biografis` diupdate total**
   - Field `title` → `name` (Nama tokoh)
   - Field `content` → `life_story` (Kisah hidup)
   - Ditambahkan: `birth_place`, `birth_date`, `death_date`, `achievements`

2. **Tabel `categories` sudah di-seed**
   - 7 cabang matematika (Aljabar, Geometri, Kalkulus, dll.)

3. **Migration files dibersihkan**
   - Migration lama yang conflict sudah dihapus
   - Migration baru sudah disesuaikan urut

### 📚 File Dokumentasi Baru

Setelah pull, baca file-file ini:

1. **[README.md](README.md)** - Overview project & quick start
2. **[SETUP.md](SETUP.md)** - Detail lengkap instalasi & setup
3. **[GIT-WORKFLOW.md](GIT-WORKFLOW.md)** - Cara pull/push yang benar
4. **File ini (TEAM-NOTICE.md)** - Pesan penting untuk tim

### ✅ Checklist Setelah Pull

- [ ] Git pull dari main
- [ ] `composer install`
- [ ] Pastikan file `.env` ada (copy dari `.env.example` jika belum)
- [ ] Edit `.env` sesuaikan database kamu
- [ ] `php artisan migrate:fresh --seed`
- [ ] `php artisan storage:link`
- [ ] `php artisan config:clear`
- [ ] Test akses http://127.0.0.1:8000

### 🔑 Akun Login Default

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@example.com | password |
| Admin | admin@example.com | password |
| User | user@example.com | password |

### ❓ Kalau Error?

**Error: "Table biografis doesn't exist"**
```bash
php artisan migrate:fresh --seed
```

**Error: "Unknown column 'name'"**
```bash
php artisan migrate:fresh --seed
```

**Error: "Access denied for user"**
- Cek file `.env` bagian `DB_USERNAME` dan `DB_PASSWORD`

**Masih error?**
- Baca [GIT-WORKFLOW.md](GIT-WORKFLOW.md) bagian Troubleshooting
- Atau hubungi saya

### 🚨 PERINGATAN

`php artisan migrate:fresh --seed` akan **MENGHAPUS SEMUA DATA** di database!

Jika kamu punya data penting, backup dulu sebelum jalankan perintah ini.

---

**Jika ada pertanyaan, tanya di grup!** 👋
