# 🚀 Panduan Setup Website Laravel Karang Cakap

## ✅ Status Terkini (18 Desember 2025)

### Website Sudah Aktif
- ✅ Server Laravel berjalan di `http://127.0.0.1:8000`
- ✅ Website baru (Laravel) sudah menggantikan website lama
- ✅ Database SQLite sudah disetup
- ✅ Semua route sudah terintegrasi

---

## 📍 Akses Website

### URL Utama
- **Beranda:** http://127.0.0.1:8000
- **Berita:** http://127.0.0.1:8000/berita
- **AI Chat:** http://127.0.0.1:8000/chat
- **Login:** http://127.0.0.1:8000/login
- **Register:** http://127.0.0.1:8000/register

---

## 🛠️ Struktur Folder

```
c:\chatbox\
├── app/                          # Logic aplikasi Laravel
├── bootstrap/                    # Bootstrap Laravel
├── config/                       # Konfigurasi
├── database/                     # Database & migrations
│   └── database.sqlite          # File database
├── public/                       # File publik (CSS, JS, images)
│   ├── index.php               # Entry point Laravel
│   ├── styles.css              # CSS utama
│   ├── script.js               # JavaScript umum
│   └── chatbox.js              # JavaScript chat
├── resources/                    # Resource (views, css, js)
│   └── views/
│       ├── home.blade.php      # Halaman beranda
│       ├── news.blade.php      # Halaman berita
│       ├── chat.blade.php      # Halaman chat
│       └── auth/               # Login/register views
├── routes/
│   └── web.php                 # Route definition
├── storage/                     # Storage laravel
├── vendor/                      # Dependencies
└── .env                        # Environment configuration
```

---

## 🔄 Perbedaan Website Lama vs Baru

### Website LAMA (SUDAH DIHAPUS)
- ❌ `index.html` - File HTML statis
- ❌ `news.html` - File HTML statis
- ❌ `chatbox.html` - File HTML statis
- ❌ `login.html` - File HTML statis
- 🔗 Tidak ada routing
- 🗄️ Tidak ada database

### Website BARU (AKTIF SEKARANG)
- ✅ `home.blade.php` - Template dinamis Laravel
- ✅ `news.blade.php` - Template dinamis Laravel
- ✅ `chat.blade.php` - Template dinamis Laravel
- ✅ `routes/web.php` - Routing lengkap
- ✅ Database SQLite terintegrasi
- ✅ Authentication system
- ✅ Admin panel

---

## 🚀 Cara Menjalankan Server

### 1. Buka Terminal di folder `c:\chatbox`

### 2. Jalankan server Laravel
```bash
php artisan serve
```

### 3. Server akan aktif di
```
http://127.0.0.1:8000
```

### 4. Stop server
```
Tekan Ctrl + C
```

---

## 📊 Fitur Website

### 🏠 Beranda
- Hero section dengan background menarik
- Fitur unggulan
- Berita terbaru preview
- Statistik website
- Footer dengan info

### 📰 Berita
- Daftar berita dengan kategori
- Filter berdasarkan kategori
- Search berita
- Berita populer sidebar
- Newsletter subscription

### 💬 AI Chat
- Chat interface dengan AI
- Riwayat percakapan
- Suggested questions
- Real-time messaging
- User info panel

### 🔐 Authentication
- Login page
- Register page
- Admin dashboard

---

## ⚙️ Konfigurasi Penting

### `.env` File
```
APP_NAME=Karang Cakap
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=sqlite
```

### Database
- Jenis: SQLite
- File: `c:\chatbox\database\database.sqlite`
- Migrations: Sudah setup

---

## 📝 Catatan Penting

✅ **Website lama (HTML statis) sudah dihapus sepenuhnya**
✅ **Website Laravel sudah aktif dan menggantikan yang lama**
✅ **Design tetap sama, hanya struktur yang berbeda**
✅ **Semua fitur berfungsi normal**

---

## 🆘 Troubleshooting

### Server tidak berjalan?
```bash
cd c:\chatbox
php artisan serve
```

### Cache masalah?
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Database error?
```bash
php artisan migrate --force
```

---

**Status:** ✅ Production Ready
**Last Updated:** 18 December 2025
**Version:** 2.0 (Laravel Framework)
