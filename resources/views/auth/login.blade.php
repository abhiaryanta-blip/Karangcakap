<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Karang Cakap</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
            position: relative;
        }

        /* Animated background overlay */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(26, 138, 138, 0.5) 0%, rgba(8, 131, 149, 0.5) 50%, rgba(58, 134, 170, 0.5) 100%);
            z-index: 1;
            animation: float 15s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(30px); }
        }

        /* Floating particles */
        .bubble {
            position: fixed;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            pointer-events: none;
            animation: rise 10s infinite ease-in;
            z-index: 0;
        }

        @keyframes rise {
            0% {
                opacity: 0;
                transform: translateY(0) translateX(0);
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) translateX(100px);
            }
        }

        .container-wrapper {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1200px;
            display: flex;
            gap: 40px;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Left side - Illustration */
        .illustration-section {
            flex: 1;
            min-width: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        @media (min-width: 1024px) {
            .illustration-section {
                display: flex;
            }
        }

        /* Login Form Container */
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Tabs for Login/Register */
        .auth-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            background: #f0f4f8;
            padding: 5px;
            border-radius: 12px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            background: transparent;
            color: #666;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .tab-btn.active {
            background: white;
            color: #1a8a8a;
            box-shadow: 0 4px 12px rgba(26, 138, 138, 0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            font-size: 50px;
            margin-bottom: 10px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .logo h1 {
            color: #1a8a8a;
            font-size: 32px;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .logo p {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        /* Logo showcase section */
        .logo-showcase {
            text-align: center;
            margin-bottom: 60px;
        }

        .logo-showcase h1 {
            font-size: 56px;
            font-weight: 800;
            color: white;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 15px;
            letter-spacing: 2px;
            animation: slideDown 0.8s ease-out;
        }

        .logo-showcase p {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.9);
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            font-weight: 500;
            letter-spacing: 1px;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: 600;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8fbff;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #1a8a8a;
            background: white;
            box-shadow: 0 0 0 3px rgba(26, 138, 138, 0.1);
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        .error {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
            animation: slideIn 0.3s ease-out;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #1a8a8a;
        }

        .remember-me label {
            margin: 0;
            cursor: pointer;
            color: #666;
            font-weight: 500;
            font-size: 14px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1a8a8a 0%, #088395 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: left 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(26, 138, 138, 0.3);
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e8f0;
        }

        .divider span {
            padding: 0 12px;
            font-size: 13px;
            font-weight: 500;
        }

        .links {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }

        .links a {
            color: #1a8a8a;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .links a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #1a8a8a;
            transition: width 0.3s ease;
        }

        .links a:hover {
            color: #088395;
        }

        .links a:hover::after {
            width: 100%;
        }

        .home-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 20px;
            padding: 10px 16px;
            background: #f0f4f8;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .home-link:hover {
            background: #e0ebf0;
            transform: translateX(-4px);
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        /* Password strength indicator */
        .password-strength {
            height: 4px;
            background: #e0e8f0;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: all 0.3s ease;
            background: #e74c3c;
        }

        .password-strength-bar.weak {
            width: 33%;
            background: #e74c3c;
        }

        .password-strength-bar.medium {
            width: 66%;
            background: #f39c12;
        }

        .password-strength-bar.strong {
            width: 100%;
            background: #28a745;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                padding: 40px 25px;
            }

            .logo h1 {
                font-size: 28px;
            }

            .container-wrapper {
                gap: 20px;
            }
        }

        /* Show/Hide password button */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            font-size: 18px;
            padding: 5px;
        }

        .form-group.password-group {
            position: relative;
        }

        .password-toggle:hover {
            color: #1a8a8a;
        }
    </style>
</head>
<body>
    <!-- Floating bubbles will be created by script at bottom -->

    <div class="container-wrapper">
        <!-- Left Logo Showcase -->
        <div class="illustration-section">
            <div class="logo-showcase">
                <h1>KARANG CAKAP</h1>
                <p>Portal Berita Terdepan untuk Kehidupan Biota Laut</p>
            </div>
        </div>

        <!-- Right Form Container -->
        <div class="login-container">
            <div class="logo">
                <h1>Masuk</h1>
                <p>Akses Akun Anda</p>
            </div>

            <!-- Auth Tabs -->
            <div class="auth-tabs">
                <button type="button" class="tab-btn active" data-tab="login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </button>
                <button type="button" class="tab-btn" data-tab="register">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            </div>

            @if(session('success'))
                <div class="success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <!-- LOGIN FORM -->
            <div id="login" class="form-section active">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email_login">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" id="email_login" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group password-group">
                        <label for="password_login">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" id="password_login" name="password" placeholder="Masukkan password Anda" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_login')">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password')
                            <div class="error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Ingat Saya</label>
                    </div>

                    <button type="submit" class="btn">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </button>
                </form>

                <div class="links">
                    <p style="margin-bottom: 10px;">Belum punya akun? <a href="javascript:void(0);" onclick="switchTab('register')">Daftar sekarang</a></p>
                    <a href="{{ route('home') }}" class="home-link">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- REGISTER FORM -->
            <div id="register" class="form-section">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name_register">
                            <i class="fas fa-user"></i> Nama Lengkap
                        </label>
                        <input type="text" id="name_register" name="name" placeholder="Masukkan nama Anda" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email_register">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" id="email_register" name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group password-group">
                        <label for="password_register">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <input type="password" id="password_register" name="password" placeholder="Min. 6 karakter" required onInput="checkPasswordStrength(this.value)">
                        <button type="button" class="password-toggle" onclick="togglePassword('password_register')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <div class="password-strength">
                            <div id="strength-bar" class="password-strength-bar"></div>
                        </div>
                        @error('password')
                            <div class="error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group password-group">
                        <label for="password_confirm">
                            <i class="fas fa-lock"></i> Konfirmasi Password
                        </label>
                        <input type="password" id="password_confirm" name="password_confirmation" placeholder="Ulangi password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirm')">
                            <i class="fas fa-eye"></i>
                        </button>
                        @error('password_confirmation')
                            <div class="error">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn">
                        <i class="fas fa-user-plus"></i> Daftar
                    </button>
                </form>

                <div class="links">
                    <p style="margin-bottom: 10px;">Sudah punya akun? <a href="javascript:void(0);" onclick="switchTab('login')">Masuk di sini</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(tabName) {
            document.querySelectorAll('.form-section').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            
            document.getElementById(tabName).classList.add('active');
            event.target.closest('.tab-btn') || document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');
        }

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                switchTab(this.dataset.tab);
                document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.target.closest('.password-toggle');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                input.type = 'password';
                icon.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }

        // Password strength checker
        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strength-bar');
            let strength = 0;

            if (password.length >= 6) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[^a-zA-Z\d]/.test(password)) strength++;

            strengthBar.classList.remove('weak', 'medium', 'strong');
            
            if (strength <= 1) {
                strengthBar.classList.add('weak');
            } else if (strength <= 2) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
        }

        // Create floating bubbles on page load
        document.addEventListener('DOMContentLoaded', function() {
            for(let i = 0; i < 5; i++) {
                let bubble = document.createElement('div');
                bubble.classList.add('bubble');
                let size = Math.random() * 100 + 50;
                bubble.style.width = size + 'px';
                bubble.style.height = size + 'px';
                bubble.style.left = Math.random() * 100 + '%';
                bubble.style.top = Math.random() * 100 + '%';
                bubble.style.animationDuration = (Math.random() * 8 + 10) + 's';
                document.body.appendChild(bubble);
            }
        });
    </script>
</body>
</html>






