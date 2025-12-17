# 🎯 ADMIN PANEL - Karang Cakap

Panduan lengkap untuk menggunakan Admin Panel Karang Cakap yang telah dibuat.

---

## 📋 **Fitur yang Tersedia**

### ✅ **Authentication System**
- Login untuk Admin dan User
- Logout
- Session Management
- Role-based Access Control

### ✅ **Admin Dashboard**
- Statistik total berita (total, published, draft)
- Statistik total users
- Daftar berita terbaru
- Daftar user terbaru

### ✅ **Kelola Berita (CRUD)**
- ✏️ **Create**: Tambah berita baru dengan editor lengkap
- 📖 **Read**: Lihat daftar semua berita dengan pagination
- ✨ **Update**: Edit berita yang sudah ada
- 🗑️ **Delete**: Hapus berita
- 📁 Upload gambar berita
- 🏷️ Kategori berita (Terumbu Karang, Ikan & Biota, Konservasi, dll)
- 📊 Status berita (Draft/Published)
- 👁️ View counter

### ✅ **Kelola User (CRUD)**
- ✏️ **Create**: Tambah user baru (Admin/User biasa)
- 📖 **Read**: Lihat daftar semua user dengan pagination
- ✨ **Update**: Edit data user dan ubah role
- 🗑️ **Delete**: Hapus user (kecuali akun sendiri)
- 🔐 Password management

---

## 🚀 **Setup & Instalasi**

### 1. **Setup Database**

Pastikan Anda sudah menjalankan file SQL sebelumnya untuk membuat tabel users:
```bash
# Import file: setup_database.sql
```

Kemudian tambahkan tabel news:
```bash
# Import file: add_news_table.sql
```

**Atau manual di phpMyAdmin:**
1. Buka phpMyAdmin
2. Pilih database `chatbox`
3. Import file `add_news_table.sql`

### 2. **Create Storage Link**

Untuk upload gambar, jalankan:
```bash
php artisan storage:link
```

### 3. **Set Permissions** (jika di Linux/Mac)

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

## 🔐 **Login Credentials**

### **Admin Account:**
- **Email:** `admin@karangcakap.com`
- **Password:** `admin123`
- **Role:** Admin
- **Akses:** Full access ke semua fitur admin

### **User Accounts:**
| Nama    | Email                      | Password   | Role |
|---------|----------------------------|------------|------|
| Abhi    | abhi@karangcakap.com       | abhi123    | User |
| Dita    | dita@karangcakap.com       | dita123    | User |
| Wibhu   | wibhu@karangcakap.com      | wibhu123   | User |
| Purnama | purnama@karangcakap.com    | purnama123 | User |
| Sugiri  | sugiri@karangcakap.com     | sugiri123  | User |

---

## 📱 **Cara Menggunakan Admin Panel**

### **A. Login**

1. Buka browser dan akses: `http://localhost:8000/login`
2. Masukkan email dan password admin
3. Klik "Login"
4. Anda akan diarahkan ke Dashboard Admin

### **B. Dashboard Admin**

Setelah login, Anda akan melihat:
- **Statistik** di bagian atas (Total Berita, Published, Draft, Users)
- **Berita Terbaru** - 5 berita terakhir
- **User Terbaru** - 5 user terakhir

### **C. Kelola Berita**

#### **Tambah Berita Baru:**
1. Klik menu "Kelola Berita" di sidebar
2. Klik tombol "Tambah Berita"
3. Isi form:
   - **Judul Berita** (wajib)
   - **Ringkasan** (opsional)
   - **Konten Berita** (wajib)
   - **Kategori** (pilih dari dropdown)
   - **Status** (Draft/Published)
   - **Gambar** (opsional, max 2MB)
4. Klik "Simpan Berita"

#### **Edit Berita:**
1. Di halaman "Kelola Berita", klik tombol edit (ikon pensil) pada berita yang ingin diedit
2. Ubah data yang diperlukan
3. Klik "Update Berita"

#### **Hapus Berita:**
1. Di halaman "Kelola Berita", klik tombol hapus (ikon tempat sampah)
2. Konfirmasi penghapusan
3. Berita akan dihapus permanent

### **D. Kelola User**

#### **Tambah User Baru:**
1. Klik menu "Kelola User" di sidebar
2. Klik tombol "Tambah User"
3. Isi form:
   - **Nama Lengkap** (wajib)
   - **Email** (wajib, unique)
   - **Role** (Admin/User)
   - **Password** (wajib, min 6 karakter)
   - **Konfirmasi Password** (wajib)
4. Klik "Simpan User"

#### **Edit User:**
1. Di halaman "Kelola User", klik tombol edit (ikon pensil) pada user yang ingin diedit
2. Ubah data yang diperlukan
3. Kosongkan password jika tidak ingin mengubah password
4. Klik "Update User"

#### **Hapus User:**
1. Di halaman "Kelola User", klik tombol hapus (ikon tempat sampah)
2. Konfirmasi penghapusan
3. User akan dihapus permanent
4. **Note:** Anda tidak bisa menghapus akun sendiri

### **E. Logout**

Klik tombol "Logout" di pojok kanan atas dashboard.

---

## 🗂️ **Struktur File yang Dibuat**

### **Models:**
```
app/Models/
├── User.php (updated - tambah role)
└── News.php (baru)
```

### **Controllers:**
```
app/Http/Controllers/
├── AuthController.php (baru)
└── Admin/
    ├── DashboardController.php (baru)
    ├── NewsController.php (baru)
    └── UserController.php (baru)
```

### **Middleware:**
```
app/Http/Middleware/
└── AdminMiddleware.php (baru)
```

### **Migrations:**
```
database/migrations/
├── 0001_01_01_000000_create_users_table.php (updated)
└── 2025_12_18_000001_create_news_table.php (baru)
```

### **Seeders:**
```
database/seeders/
├── UserSeeder.php (baru)
└── DatabaseSeeder.php (updated)
```

### **Views:**
```
resources/views/
├── layouts/
│   └── admin.blade.php (baru)
├── auth/
│   └── login.blade.php (baru)
├── admin/
│   ├── dashboard.blade.php (baru)
│   ├── news/
│   │   ├── index.blade.php (baru)
│   │   ├── create.blade.php (baru)
│   │   └── edit.blade.php (baru)
│   └── users/
│       ├── index.blade.php (baru)
│       ├── create.blade.php (baru)
│       └── edit.blade.php (baru)
```

### **Routes:**
```
routes/
└── web.php (updated)
```

### **Config:**
```
bootstrap/
└── app.php (updated - register middleware)
```

---

## 🎨 **Fitur UI/UX**

### **Desain Modern:**
- ✨ Gradient colors (Purple-Blue theme)
- 🎯 Responsive design
- 📱 Mobile-friendly
- 🌈 Clean & professional interface
- 💫 Smooth transitions & hover effects

### **Komponen:**
- **Sidebar** - Fixed navigation dengan active state
- **Topbar** - User info & logout button
- **Cards** - Modern card design untuk konten
- **Tables** - Clean table dengan hover effects
- **Forms** - User-friendly form dengan validation
- **Alerts** - Success & error notifications
- **Badges** - Status indicators (Draft, Published, Admin, User)
- **Buttons** - Consistent button styles dengan icons

---

## 🔒 **Keamanan**

### **Fitur Keamanan yang Sudah Diimplementasikan:**

1. **Authentication:**
   - Login required untuk akses admin
   - Session management
   - CSRF protection

2. **Authorization:**
   - Role-based access (Admin only untuk admin panel)
   - Middleware `admin` untuk protect admin routes
   - Prevent user from deleting own account

3. **Password:**
   - Password hashing dengan bcrypt
   - Password confirmation untuk register/create user
   - Minimum 6 characters

4. **Validation:**
   - Server-side validation untuk semua forms
   - Unique email validation
   - File upload validation (size & type)

---

## 📊 **Database Schema**

### **Tabel: users**
```sql
- id
- name
- email (unique)
- password (hashed)
- role (enum: admin, user)
- email_verified_at
- remember_token
- created_at
- updated_at
```

### **Tabel: news**
```sql
- id
- title
- slug (unique, auto-generated)
- excerpt
- content
- image
- category (coral, fish, conservation, research, climate, general)
- author_id (FK to users)
- status (enum: draft, published)
- views
- published_at
- created_at
- updated_at
```

---

## 🐛 **Troubleshooting**

### **Problem: Tidak bisa login**
**Solution:**
- Pastikan database sudah di-import
- Cek kredensial login (email & password)
- Pastikan user memiliki role 'admin'

### **Problem: Error saat upload gambar**
**Solution:**
```bash
# Jalankan storage link
php artisan storage:link

# Set permissions (Linux/Mac)
chmod -R 775 storage/app/public
```

### **Problem: Halaman admin tidak bisa diakses**
**Solution:**
- Pastikan sudah login
- Pastikan user memiliki role 'admin'
- Clear browser cache & cookies

### **Problem: Error "Class not found"**
**Solution:**
```bash
composer dump-autoload
```

---

## 📝 **Notes**

1. **Password Default:** Semua password default menggunakan format `{nama}123` (contoh: admin123, abhi123)
2. **Upload Directory:** Gambar berita disimpan di `storage/app/public/news/`
3. **Public Access:** Untuk mengakses gambar, pastikan sudah menjalankan `php artisan storage:link`
4. **Slug:** Slug untuk berita auto-generated dari judul
5. **Pagination:** Default 10 items per page

---

## 🎉 **Selesai!**

Admin panel Karang Cakap sudah siap digunakan! 

**Fitur Utama:**
- ✅ Login/Logout System
- ✅ Admin Dashboard dengan statistik
- ✅ CRUD Berita lengkap
- ✅ CRUD User lengkap
- ✅ Upload gambar
- ✅ Role-based access control
- ✅ Modern & responsive UI

**Untuk memulai:**
1. Import database (`add_news_table.sql`)
2. Login dengan admin account
3. Mulai mengelola berita dan user!

---

**💡 Tips:**
- Gunakan status "Draft" untuk berita yang belum siap dipublish
- Upload gambar dengan ukuran optimal (max 2MB)
- Backup database secara berkala
- Jangan share kredensial admin!

**Happy Managing! 🚀**




