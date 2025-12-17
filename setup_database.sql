-- ============================================
-- KARANG CAKAP - DATABASE SETUP
-- ============================================
-- 
-- Cara menggunakan:
-- 1. Buka phpMyAdmin atau MySQL Command Line
-- 2. Pilih database 'chatbox' (atau sesuai nama database Anda)
-- 3. Import file ini atau copy-paste query di bawah
-- 
-- Atau gunakan command line:
-- mysql -u root -p chatbox < setup_database.sql
-- ============================================

-- Drop existing tables
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- Create users table
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user',
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create password_reset_tokens table
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) PRIMARY KEY,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create sessions table
CREATE TABLE `sessions` (
    `id` VARCHAR(255) PRIMARY KEY,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERT DATA USERS
-- ============================================

-- Insert Admin User
-- Email: admin@karangcakap.com
-- Password: admin123
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) 
VALUES (
    'Admin', 
    'admin@karangcakap.com', 
    '$2y$12$LQv3c1yycAZaPIuY.XE3iej8bHKKZ8m9K9dX2v6XxV.8XJcFxyDOa', 
    'admin', 
    NOW(), 
    NOW(), 
    NOW()
);

-- Insert Regular Users
-- Email: abhi@karangcakap.com - Password: abhi123
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) 
VALUES (
    'Abhi', 
    'abhi@karangcakap.com', 
    '$2y$12$LQv3c1yycAZaPIuY.XE3iej8bHKKZ8m9K9dX2v6XxV.8XJcFxyDOa', 
    'user', 
    NOW(), 
    NOW(), 
    NOW()
);

-- Email: dita@karangcakap.com - Password: dita123
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) 
VALUES (
    'Dita', 
    'dita@karangcakap.com', 
    '$2y$12$LQv3c1yycAZaPIuY.XE3iej8bHKKZ8m9K9dX2v6XxV.8XJcFxyDOa', 
    'user', 
    NOW(), 
    NOW(), 
    NOW()
);

-- Email: wibhu@karangcakap.com - Password: wibhu123
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) 
VALUES (
    'Wibhu', 
    'wibhu@karangcakap.com', 
    '$2y$12$LQv3c1yycAZaPIuY.XE3iej8bHKKZ8m9K9dX2v6XxV.8XJcFxyDOa', 
    'user', 
    NOW(), 
    NOW(), 
    NOW()
);

-- Email: purnama@karangcakap.com - Password: purnama123
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) 
VALUES (
    'Purnama', 
    'purnama@karangcakap.com', 
    '$2y$12$LQv3c1yycAZaPIuY.XE3iej8bHKKZ8m9K9dX2v6XxV.8XJcFxyDOa', 
    'user', 
    NOW(), 
    NOW(), 
    NOW()
);

-- Email: sugiri@karangcakap.com - Password: sugiri123
INSERT INTO `users` (`name`, `email`, `password`, `role`, `email_verified_at`, `created_at`, `updated_at`) 
VALUES (
    'Sugiri', 
    'sugiri@karangcakap.com', 
    '$2y$12$LQv3c1yycAZaPIuY.XE3iej8bHKKZ8m9K9dX2v6XxV.8XJcFxyDOa', 
    'user', 
    NOW(), 
    NOW(), 
    NOW()
);

-- ============================================
-- VERIFICATION
-- ============================================

-- Show all users
SELECT 
    id, 
    name, 
    email, 
    role, 
    created_at 
FROM users 
ORDER BY role DESC, id ASC;

-- Show summary
SELECT 
    role, 
    COUNT(*) as total 
FROM users 
GROUP BY role;

-- ============================================
-- SELESAI!
-- ============================================
-- 
-- LOGIN CREDENTIALS:
-- 
-- Admin:
--   Email: admin@karangcakap.com
--   Password: admin123
-- 
-- Users:
--   Email: abhi@karangcakap.com    | Password: abhi123
--   Email: dita@karangcakap.com    | Password: dita123
--   Email: wibhu@karangcakap.com   | Password: wibhu123
--   Email: purnama@karangcakap.com | Password: purnama123
--   Email: sugiri@karangcakap.com  | Password: sugiri123
-- 
-- ============================================




