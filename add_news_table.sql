-- ============================================
-- KARANG CAKAP - ADD NEWS TABLE
-- ============================================

-- Create news table
CREATE TABLE `news` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `excerpt` TEXT NULL,
    `content` LONGTEXT NOT NULL,
    `image` VARCHAR(255) NULL,
    `category` VARCHAR(50) DEFAULT 'general',
    `author_id` BIGINT UNSIGNED NOT NULL,
    `status` ENUM('draft', 'published') DEFAULT 'draft',
    `views` INT DEFAULT 0,
    `published_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample news
INSERT INTO `news` (`title`, `slug`, `excerpt`, `content`, `category`, `author_id`, `status`, `published_at`) VALUES
('Penemuan Spesies Karang Baru di Laut Dalam Indonesia', 'penemuan-spesies-karang-baru-di-laut-dalam-indonesia', 'Tim peneliti menemukan spesies karang yang belum pernah teridentifikasi di kedalaman 500 meter perairan Indonesia.', 'Tim peneliti dari berbagai universitas terkemuka menemukan spesies karang yang belum pernah teridentifikasi sebelumnya di kedalaman 500 meter perairan Indonesia. Penemuan ini membuka wawasan baru tentang keanekaragaman hayati laut dalam yang masih banyak belum terjamah.', 'coral', 1, 'published', NOW()),
('Program Restorasi Terumbu Karang Raja Ampat Capai Target 150%', 'program-restorasi-terumbu-karang-raja-ampat-capai-target', 'Program konservasi yang dimulai tiga tahun lalu menunjukkan hasil melampaui ekspektasi.', 'Program konservasi yang dimulai tiga tahun lalu menunjukkan hasil melampaui ekspektasi. Tingkat pemulihan terumbu karang mencapai 45%, jauh melebihi target awal 30%. Metode transplantasi karang dan monitoring berkelanjutan terbukti efektif.', 'conservation', 1, 'published', NOW()),
('Studi: Dampak Perubahan Iklim Terhadap Ekosistem Laut Tropis', 'studi-dampak-perubahan-iklim-terhadap-ekosistem-laut', 'Penelitian terbaru mengungkap hubungan kompleks antara pemanasan global dan kesehatan ekosistem laut.', 'Penelitian terbaru mengungkap hubungan kompleks antara pemanasan global dan kesehatan ekosistem laut. Data satelit dan pengamatan langsung menunjukkan perubahan signifikan dalam pola migrasi biota laut dan komposisi spesies.', 'research', 1, 'published', NOW());

-- Verify
SELECT * FROM news;




