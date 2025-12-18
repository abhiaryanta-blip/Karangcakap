-- ============================================
-- QUICK FIX ADMIN ROLE
-- ============================================
-- Copy-paste query ini di phpMyAdmin → SQL tab
-- ============================================

-- Step 1: Tambahkan kolom role jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `role` ENUM('admin', 'user') DEFAULT 'user' 
AFTER `password`;

-- Step 2: Update user admin
UPDATE `users` 
SET `role` = 'admin' 
WHERE `email` = 'admin@karangcakap.com';

-- Step 3: Verifikasi (cek hasil)
SELECT id, name, email, role, created_at 
FROM `users` 
WHERE `email` = 'admin@karangcakap.com';

-- ============================================
-- SELESAI!
-- ============================================
-- Setelah ini:
-- 1. Logout dari akun saat ini
-- 2. Login dengan: admin@karangcakap.com / admin123
-- 3. Akses: http://localhost:8000/admin/dashboard
-- ============================================






