<?php

/**
 * Setup Database Script
 * Script ini akan membuat tabel dan mengisi data user tanpa artisan command
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

// Bootstrap Laravel Application
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "==================================================\n";
echo "   KARANG CAKAP - DATABASE SETUP\n";
echo "==================================================\n\n";

try {
    // Test database connection
    echo "🔍 Testing database connection...\n";
    DB::connection()->getPdo();
    echo "✅ Database connected successfully!\n\n";

    // Drop existing tables
    echo "🗑️  Dropping existing tables...\n";
    DB::statement('DROP TABLE IF EXISTS sessions');
    DB::statement('DROP TABLE IF EXISTS password_reset_tokens');
    DB::statement('DROP TABLE IF EXISTS cache');
    DB::statement('DROP TABLE IF EXISTS cache_locks');
    DB::statement('DROP TABLE IF EXISTS jobs');
    DB::statement('DROP TABLE IF EXISTS job_batches');
    DB::statement('DROP TABLE IF EXISTS failed_jobs');
    DB::statement('DROP TABLE IF EXISTS users');
    echo "✅ Tables dropped!\n\n";

    // Create users table
    echo "📦 Creating users table...\n";
    DB::statement("
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
        )
    ");
    echo "✅ Users table created!\n\n";

    // Create password reset tokens table
    echo "📦 Creating password_reset_tokens table...\n";
    DB::statement("
        CREATE TABLE password_reset_tokens (
            email VARCHAR(255) PRIMARY KEY,
            token VARCHAR(255) NOT NULL,
            created_at TIMESTAMP NULL
        )
    ");
    echo "✅ Password reset tokens table created!\n\n";

    // Create sessions table
    echo "📦 Creating sessions table...\n";
    DB::statement("
        CREATE TABLE sessions (
            id VARCHAR(255) PRIMARY KEY,
            user_id BIGINT UNSIGNED NULL,
            ip_address VARCHAR(45) NULL,
            user_agent TEXT NULL,
            payload LONGTEXT NOT NULL,
            last_activity INT NOT NULL,
            INDEX sessions_user_id_index (user_id),
            INDEX sessions_last_activity_index (last_activity)
        )
    ");
    echo "✅ Sessions table created!\n\n";

    // Insert Admin User
    echo "👨‍💼 Creating Admin account...\n";
    DB::table('users')->insert([
        'name' => 'Admin',
        'email' => 'admin@karangcakap.com',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
        'email_verified_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);
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

    foreach ($users as $user) {
        DB::table('users')->insert([
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
            'role' => 'user',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✅ User created: {$user['name']} ({$user['email']}) - Password: {$user['password']}\n";
    }

    echo "\n==================================================\n";
    echo "✅ DATABASE SETUP COMPLETED SUCCESSFULLY!\n";
    echo "==================================================\n\n";

    echo "📊 Summary:\n";
    echo "   - Total users created: " . DB::table('users')->count() . "\n";
    echo "   - Admin accounts: " . DB::table('users')->where('role', 'admin')->count() . "\n";
    echo "   - Regular users: " . DB::table('users')->where('role', 'user')->count() . "\n\n";

    echo "🔐 Login Credentials:\n";
    echo "   Admin: admin@karangcakap.com / admin123\n";
    echo "   Abhi: abhi@karangcakap.com / abhi123\n";
    echo "   Dita: dita@karangcakap.com / dita123\n";
    echo "   Wibhu: wibhu@karangcakap.com / wibhu123\n";
    echo "   Purnama: purnama@karangcakap.com / purnama123\n";
    echo "   Sugiri: sugiri@karangcakap.com / sugiri123\n\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📋 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n\n";
    exit(1);
}






