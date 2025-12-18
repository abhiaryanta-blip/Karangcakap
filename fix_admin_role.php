<?php

/**
 * Fix Admin Role Script
 * Script ini akan memastikan user admin memiliki role 'admin'
 */

require __DIR__.'/vendor/autoload.php';

// Bootstrap Laravel Application
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

echo "==================================================\n";
echo "   FIX ADMIN ROLE - KARANG CAKAP\n";
echo "==================================================\n\n";

try {
    // Test database connection
    echo "🔍 Testing database connection...\n";
    DB::connection()->getPdo();
    echo "✅ Database connected successfully!\n\n";

    // Check if role column exists
    echo "🔍 Checking if 'role' column exists...\n";
    $columns = DB::select("SHOW COLUMNS FROM users LIKE 'role'");
    
    if (empty($columns)) {
        echo "⚠️  Column 'role' tidak ditemukan. Menambahkan kolom...\n";
        DB::statement("ALTER TABLE users ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user' AFTER password");
        echo "✅ Column 'role' berhasil ditambahkan!\n\n";
    } else {
        echo "✅ Column 'role' sudah ada.\n\n";
    }

    // Find admin user
    echo "🔍 Mencari user admin...\n";
    $admin = User::where('email', 'admin@karangcakap.com')->first();

    if (!$admin) {
        echo "⚠️  User admin tidak ditemukan. Membuat user admin baru...\n";
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@karangcakap.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        echo "✅ User admin berhasil dibuat!\n\n";
    } else {
        echo "✅ User admin ditemukan: {$admin->name} ({$admin->email})\n";
        echo "   Current role: {$admin->role}\n\n";
        
        // Update role to admin if not already
        if ($admin->role !== 'admin') {
            echo "⚠️  Role user bukan 'admin'. Mengupdate role...\n";
            $admin->role = 'admin';
            $admin->save();
            echo "✅ Role berhasil diupdate menjadi 'admin'!\n\n";
        } else {
            echo "✅ Role sudah benar (admin).\n\n";
        }
    }

    // Verify all admin users
    echo "📊 Verifikasi semua admin users:\n";
    $admins = User::where('role', 'admin')->get();
    foreach ($admins as $adminUser) {
        echo "   - {$adminUser->name} ({$adminUser->email}) - Role: {$adminUser->role}\n";
    }
    echo "\n";

    // Test login credentials
    echo "🔐 Test Login Credentials:\n";
    echo "   Email: admin@karangcakap.com\n";
    echo "   Password: admin123\n";
    echo "   Role: admin\n\n";

    echo "==================================================\n";
    echo "✅ ADMIN ROLE FIX COMPLETED!\n";
    echo "==================================================\n\n";

    echo "💡 Langkah selanjutnya:\n";
    echo "   1. Login dengan: admin@karangcakap.com / admin123\n";
    echo "   2. Akses: http://localhost:8000/admin/dashboard\n";
    echo "   3. Fitur admin seharusnya sudah tersedia!\n\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📋 File: " . $e->getFile() . "\n";
    echo "📍 Line: " . $e->getLine() . "\n\n";
    exit(1);
}






