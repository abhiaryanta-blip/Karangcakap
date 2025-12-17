# Struktur Website Karang Cakap - Versi Laravel

## Daftar Perubahan

### ✅ Migrasi ke Laravel Framework
- Website lama (HTML statis) telah dimigrasi ke Laravel
- Semua route sudah terintegrasi dengan server Laravel
- Asset (CSS, JS) dipindahkan ke folder `public/`

### 📁 Struktur File Baru

```
resources/views/
├── home.blade.php      → Halaman beranda (dari index.html)
├── news.blade.php      → Halaman berita (dari news.html)
├── chat.blade.php      → Halaman AI chat (dari chatbox.html)
├── layouts/
│   ├── app.blade.php   → Layout utama
│   └── ... (layout lainnya)
└── auth/
    └── ... (login/register views)

public/
├── styles.css          → CSS utama
├── script.js           → JavaScript umum
├── chatbox.js          → JavaScript khusus chat
└── ... (asset lainnya)

routes/
└── web.php             → Route definition
```

### 🔗 Route URL Terbaru

| URL | Deskripsi |
|-----|-----------|
| `/` | Beranda |
| `/berita` | Halaman Berita |
| `/chat` | AI Chat |
| `/login` | Login |
| `/register` | Registrasi |
| `/admin/dashboard` | Admin Panel |

### 📝 Catatan Penting

**File HTML Lama (Sudah Tidak Digunakan):**
- `index.html` → Gunakan route `/` atau `home.blade.php`
- `news.html` → Gunakan route `/berita` atau `news.blade.php`
- `chatbox.html` → Gunakan route `/chat` atau `chat.blade.php`

**Akses File CSS/JS:**
- CSS: `{{ asset('styles.css') }}`
- JS: `{{ asset('script.js') }}`
- Chatbox JS: `{{ asset('chatbox.js') }}`

### 🚀 Cara Menjalankan

1. Pastikan server Laravel sudah berjalan:
   ```bash
   php artisan serve
   ```

2. Akses website di browser:
   ```
   http://127.0.0.1:8000
   ```

3. Login dengan akun Anda untuk mengakses fitur chat dan berita

### ⚙️ Konfigurasi Penting

- Database: Sudah tersinkronisasi dengan migrations
- Authentication: Menggunakan Laravel Auth
- Admin Role: User dengan role 'admin' mendapat akses ke dashboard admin

### 📌 File yang Telah Dihapus

- `index.html` ❌ (Diganti: `/` route)
- `news.html` ❌ (Diganti: `/berita` route)
- `chatbox.html` ❌ (Diganti: `/chat` route)
- `login.html` ❌ (Diganti: `/login` route)

### ✨ Fitur yang Tersedia

✅ Beranda dengan hero section
✅ Halaman berita dengan filter dan search
✅ AI Chat dengan riwayat percakapan
✅ Sistem autentikasi (login/register)
✅ Admin dashboard
✅ Responsive design

---

**Catatan:** Website sekarang menggunakan Laravel framework untuk manajemen yang lebih baik. Semua fitur HTML lama tetap berfungsi sama namun dengan struktur yang lebih profesional.
