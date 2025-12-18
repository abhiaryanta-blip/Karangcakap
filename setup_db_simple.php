<?php

/**
 * Simple Database Setup Script
 * Menggunakan PDO langsung tanpa Laravel bootstrap
 */

echo "==================================================\n";
echo "   KARANG CAKAP - DATABASE SETUP\n";
echo "==================================================\n\n";

// Konfigurasi Database (sesuaikan dengan .env Anda)
$host = 'localhost';
$database = 'chatbox';  // Sesuaikan dengan nama database Anda
$username = 'root';     // Sesuaikan dengan username database Anda
$password = '';         // Sesuaikan dengan password database Anda

try {
    echo "🔍 Connecting to database...\n";
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected successfully!\n\n";

    // Drop existing tables
    echo "🗑️  Dropping existing tables...\n";
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $pdo->exec('DROP TABLE IF EXISTS sessions');
    $pdo->exec('DROP TABLE IF EXISTS password_reset_tokens');
    $pdo->exec('DROP TABLE IF EXISTS users');
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    echo "✅ Tables dropped!\n\n";

    // Create users table
    echo "📦 Creating users table...\n";
    $pdo->exec("
        CREATE TABLE users (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            email_verified_at TIMESTAMP NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') DEFAULT 'user',
            remember_token VARCHAR(100) NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Users table created!\n\n";

    // Create password reset tokens table
    echo "📦 Creating password_reset_tokens table...\n";
    $pdo->exec("
        CREATE TABLE password_reset_tokens (
            email VARCHAR(255) PRIMARY KEY,
            token VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Password reset tokens table created!\n\n";

    // Create sessions table
    echo "📦 Creating sessions table...\n";
    $pdo->exec("
        CREATE TABLE sessions (
            id VARCHAR(255) PRIMARY KEY,
            user_id BIGINT UNSIGNED NULL,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            payload LONGTEXT NOT NULL,
            last_activity INT NOT NULL,
            INDEX sessions_user_id_index (user_id),
            INDEX sessions_last_activity_index (last_activity)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "✅ Sessions table created!\n\n";

    // Insert Admin User
    echo "👨‍💼 Creating Admin account...\n";
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
        VALUES (?, ?, ?, ?, NOW(), NOW(), NOW())
    ");
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt->execute(['Admin', 'admin@karangcakap.com', $adminPassword, 'admin']);
    echo "✅ Admin created: admin@karangcakap.com (password: admin123)\n\n";

    // Insert Regular Users
    echo "👥 Creating regular users...\n";
    $users = [
        ['name' => 'Abhi', 'email' => 'abhi@karangcakap.com', 'password' => 'abhi123'],
        ['name' => 'Dita', 'email' => 'dita@karangcakap.com', 'password' => 'dita123'],
        ['name' => 'Wibhu', 'email' => 'wibhu@karangcakap.com', 'password' => 'wibhu123'],
        ['name' => 'Purnama', 'email' => 'purnama@karangcakap.com', 'password' => 'purnama123'],
        ['name' => 'Sugiri', 'email' => 'sugiri@karangcakap.com', 'password' => 'sugiri123'],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
        VALUES (?, ?, ?, 'user', NOW(), NOW(), NOW())
    ");

    foreach ($users as $user) {
        $hashedPassword = password_hash($user['password'], PASSWORD_BCRYPT);
        $stmt->execute([$user['name'], $user['email'], $hashedPassword]);
        echo "✅ User created: {$user['name']} ({$user['email']}) - Password: {$user['password']}\n";
    }

    // Get statistics
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $adminCount = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();
    $userCount = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn();

    echo "\n==================================================\n";
    echo "✅ DATABASE SETUP COMPLETED SUCCESSFULLY!\n";
    echo "==================================================\n\n";

    echo "📊 Summary:\n";
    echo "   - Total users created: $totalUsers\n";
    echo "   - Admin accounts: $adminCount\n";
    echo "   - Regular users: $userCount\n\n";

    echo "🔐 Login Credentials:\n";
    echo "   Admin: admin@karangcakap.com / admin123\n";
    echo "   Abhi: abhi@karangcakap.com / abhi123\n";
    echo "   Dita: dita@karangcakap.com / dita123\n";
    echo "   Wibhu: wibhu@karangcakap.com / wibhu123\n";
    echo "   Purnama: purnama@karangcakap.com / purnama123\n";
    echo "   Sugiri: sugiri@karangcakap.com / sugiri123\n\n";

    echo "💡 Tip: Jika database connection error, edit file ini dan sesuaikan:\n";
    echo "   - \$host = '$host'\n";
    echo "   - \$database = '$database'\n";
    echo "   - \$username = '$username'\n";
    echo "   - \$password = (kosong/sesuaikan)\n\n";

} catch (PDOException $e) {
    echo "❌ DATABASE ERROR: " . $e->getMessage() . "\n\n";
    echo "💡 Pastikan:\n";
    echo "   1. MySQL/MariaDB sudah berjalan\n";
    echo "   2. Database '$database' sudah dibuat\n";
    echo "   3. Username dan password database benar\n";
    echo "   4. Edit variabel di baris 12-15 jika perlu\n\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}






