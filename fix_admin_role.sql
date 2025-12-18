-- ============================================
-- FIX ADMIN ROLE - KARANG CAKAP
-- ============================================
-- Script ini akan memperbaiki role admin di database
-- ============================================

-- 1. Tambahkan kolom 'role' jika belum ada
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `role` ENUM('admin', 'user') DEFAULT 'user' 
AFTER `password`;

-- 2. Update user admin untuk memastikan role-nya 'admin'
UPDATE `users` 
SET `role` = 'admin' 
WHERE `email` = 'admin@karangcakap.com';

-- 3. Verifikasi (cek hasil)
SELECT 
    id, 
    name, 
    email, 
    role, 
    created_at 
FROM `users` 
WHERE `email` = 'admin@karangcakap.com';

-- 4. Tampilkan semua admin
SELECT 
    id, 
    name, 
    email, 
    role 
FROM `users` 
WHERE `role` = 'admin';

-- ============================================
-- SELESAI!
-- ============================================
-- 
-- Setelah menjalankan script ini:
-- 1. Login dengan: admin@karangcakap.com / admin123
-- 2. Akses: http://localhost:8000/admin/dashboard
-- 3. Fitur admin seharusnya sudah tersedia!
-- 
-- ============================================






