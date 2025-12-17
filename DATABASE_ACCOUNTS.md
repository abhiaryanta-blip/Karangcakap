# Database Accounts - Karang Cakap

## Informasi Login

Berikut adalah daftar akun yang telah dibuat untuk sistem Karang Cakap:

### 👨‍💼 Admin Account
| No | Nama  | Email                    | Password  | Role  |
|----|-------|--------------------------|-----------|-------|
| 1  | Admin | admin@karangcakap.com    | admin123  | admin |

### 👥 User Accounts
| No | Nama    | Email                    | Password     | Role |
|----|---------|--------------------------|--------------|------|
| 1  | Abhi    | abhi@karangcakap.com     | abhi123      | user |
| 2  | Dita    | dita@karangcakap.com     | dita123      | user |
| 3  | Wibhu   | wibhu@karangcakap.com    | wibhu123     | user |
| 4  | Purnama | purnama@karangcakap.com  | purnama123   | user |
| 5  | Sugiri  | sugiri@karangcakap.com   | sugiri123    | user |

---

## Struktur Database

### Tabel: `users`
```sql
- id (bigint, auto_increment, primary key)
- name (varchar)
- email (varchar, unique)
- email_verified_at (timestamp, nullable)
- password (varchar, hashed)
- role (enum: 'admin', 'user', default: 'user')
- remember_token (varchar, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

---

## Cara Menjalankan Database Seeder

### Opsi 1: Menggunakan Artisan Command (Recommended)
```bash
# Jalankan migration dan seeder
php artisan migrate:fresh --seed

# Atau jalankan seeder saja (jika migration sudah dijalankan)
php artisan db:seed --class=UserSeeder
```

### Opsi 2: Manual SQL Insert
Jika artisan command tidak berhasil, gunakan SQL query di bawah ini:

```sql
-- Insert Admin
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES (
    'Admin', 
    'admin@karangcakap.com', 
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
    'admin', 
    NOW(), 
    NOW(), 
    NOW()
);

-- Insert Users
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) VALUES
('Abhi', 'abhi@karangcakap.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW(), NOW()),
('Dita', 'dita@karangcakap.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW(), NOW()),
('Wibhu', 'wibhu@karangcakap.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW(), NOW()),
('Purnama', 'purnama@karangcakap.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW(), NOW()),
('Sugiri', 'sugiri@karangcakap.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', NOW(), NOW(), NOW());
```

**Note:** Hash password di atas adalah untuk password "password". Untuk password yang sebenarnya, jalankan seeder dengan Artisan command.

---

## Testing Login

### Menggunakan Laravel Tinker
```bash
php artisan tinker

# Cek admin
User::where('role', 'admin')->first();

# Cek semua users
User::where('role', 'user')->get();

# Cek total users
User::count();
```

---

## Troubleshooting

### Jika migration gagal karena cache:
```bash
# Berikan permission ke direktori cache
icacls "bootstrap\cache" /grant Everyone:F /T

# Clear cache
php artisan cache:clear
php artisan config:clear

# Dump autoload
composer dump-autoload

# Coba lagi
php artisan migrate:fresh --seed
```

### Jika masih error:
1. Pastikan database sudah dibuat
2. Cek konfigurasi `.env` untuk database connection
3. Pastikan PHP dan MySQL/PostgreSQL sudah terinstall
4. Coba jalankan migration manual atau gunakan SQL insert di atas

---

## File-file yang Sudah Dibuat

1. **Migration**: `database/migrations/0001_01_01_000000_create_users_table.php` ✅
2. **Model**: `app/Models/User.php` ✅
3. **Seeder**: `database/seeders/UserSeeder.php` ✅
4. **Database Seeder**: `database/seeders/DatabaseSeeder.php` ✅

Semua file sudah siap dan dapat dijalankan kapan saja!




