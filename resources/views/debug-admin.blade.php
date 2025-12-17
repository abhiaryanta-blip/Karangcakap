<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Debug Admin Access</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #667eea;
            margin-bottom: 20px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }

        .info-box h3 {
            margin-bottom: 10px;
            color: #333;
        }

        .info-box p {
            color: #666;
            margin: 5px 0;
        }

        .status {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
            font-weight: bold;
        }

        .status.success {
            background: #d4edda;
            color: #155724;
        }

        .status.error {
            background: #f8d7da;
            color: #721c24;
        }

        .status.warning {
            background: #fff3cd;
            color: #856404;
        }

        .btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            width: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .links {
            margin-top: 20px;
            text-align: center;
        }

        .links a {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Debug Admin Access</h1>

        <div class="info-box">
            <h3>Status Login</h3>
            <div id="status-container">
                <p>Memuat informasi...</p>
            </div>
        </div>

        <div class="info-box">
            <h3>Informasi User</h3>
            <div id="user-info">
                <p>Memuat...</p>
            </div>
        </div>

        <div id="fix-section" style="display: none;">
            <div class="status warning">
                ⚠️ Role Anda bukan 'admin'. Klik tombol di bawah untuk memperbaikinya.
            </div>
            <button class="btn btn-danger" onclick="fixAdmin()">
                🔧 Fix Admin Role
            </button>
        </div>

        <div id="success-section" style="display: none;">
            <div class="status success">
                ✅ Role Anda sudah 'admin'! Anda bisa mengakses dashboard admin.
            </div>
            <a href="/admin/dashboard" class="btn">
                🚀 Buka Dashboard Admin
            </a>
        </div>

        <div class="links">
            <a href="/">← Kembali ke Beranda</a>
            <a href="/login">Login</a>
        </div>
    </div>

    <script>
        // Check admin status
        async function checkAdmin() {
            try {
                const response = await fetch('/debug/admin');
                const data = await response.json();

                const statusContainer = document.getElementById('status-container');
                const userInfo = document.getElementById('user-info');
                const fixSection = document.getElementById('fix-section');
                const successSection = document.getElementById('success-section');

                if (data.status === 'not_logged_in') {
                    statusContainer.innerHTML = '<div class="status error">❌ Anda belum login</div>';
                    userInfo.innerHTML = '<p>Silakan <a href="/login">login</a> terlebih dahulu.</p>';
                    return;
                }

                // Show user info
                userInfo.innerHTML = `
                    <p><strong>Nama:</strong> ${data.user.name}</p>
                    <p><strong>Email:</strong> ${data.user.email}</p>
                    <p><strong>Role (Session):</strong> <code>${data.user.role_from_session || 'null'}</code></p>
                    <p><strong>Role (Database):</strong> <code>${data.user.role_from_db || 'null'}</code></p>
                    <p><strong>Kolom Role Ada:</strong> ${data.user.has_role_column ? '✅ Ya' : '❌ Tidak'}</p>
                `;

                // Check if admin
                if (data.is_admin) {
                    statusContainer.innerHTML = '<div class="status success">✅ Anda adalah Admin</div>';
                    successSection.style.display = 'block';
                    fixSection.style.display = 'none';
                } else {
                    statusContainer.innerHTML = '<div class="status error">❌ Anda BUKAN Admin</div>';
                    successSection.style.display = 'none';
                    fixSection.style.display = 'block';
                }
            } catch (error) {
                document.getElementById('status-container').innerHTML = 
                    '<div class="status error">❌ Error: ' + error.message + '</div>';
            }
        }

        // Fix admin role
        async function fixAdmin() {
            if (!confirm('Yakin ingin mengupdate role menjadi admin?')) {
                return;
            }

            try {
                const response = await fetch('/debug/fix-admin', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    alert('✅ Role berhasil diupdate! Halaman akan di-refresh.');
                    location.reload();
                } else {
                    alert('❌ Error: ' + data.message);
                }
            } catch (error) {
                alert('❌ Error: ' + error.message);
            }
        }

        // Run on load
        checkAdmin();
    </script>
</body>
</html>

