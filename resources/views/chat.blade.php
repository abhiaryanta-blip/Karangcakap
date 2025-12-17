<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Chat - Karang Cakap</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-container">
                <i class="fas fa-water coral-icon"></i>
                <span class="logo-text">KARANG CAKAP</span>
            </div>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="{{ route('news') }}" class="nav-link">
                    <i class="fas fa-newspaper"></i> Berita
                </a>
                <a href="{{ route('chat') }}" class="nav-link active">
                    <i class="fas fa-comments"></i> AI Chat
                </a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="fas fa-cog"></i> Admin
                        </a>
                    @endif
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </a>
                @endauth
            </div>
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Chat Container -->
    <div class="chat-container">
        <!-- Sidebar -->
        <aside class="chat-sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-comments"></i> Riwayat Chat</h3>
                <button class="btn-new-chat" onclick="newChat()">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            
            <div class="chat-history">
                <div class="history-item active">
                    <i class="fas fa-message"></i>
                    <div class="history-content">
                        <h4>Pertanyaan tentang Terumbu Karang</h4>
                        <p>Apa itu terumbu karang?</p>
                        <span class="history-time">Hari ini, 14:30</span>
                    </div>
                </div>
                <div class="history-item">
                    <i class="fas fa-message"></i>
                    <div class="history-content">
                        <h4>Ikan Clownfish</h4>
                        <p>Bagaimana cara hidup ikan badut?</p>
                        <span class="history-time">Kemarin, 09:15</span>
                    </div>
                </div>
                <div class="history-item">
                    <i class="fas fa-message"></i>
                    <div class="history-content">
                        <h4>Konservasi Laut</h4>
                        <p>Cara melindungi ekosistem laut</p>
                        <span class="history-time">2 hari lalu</span>
                    </div>
                </div>
            </div>

            <div class="sidebar-footer">
                <div class="user-info">
                    <img src="https://i.pravatar.cc/150?img=10" alt="User">
                    <div>
                        <h4 id="userName">{{ auth()->user()->name ?? 'Pengguna' }}</h4>
                        <p>Online</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Chat -->
        <main class="chat-main">
            <div class="chat-header">
                <div class="chat-header-info">
                    <div class="ai-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div>
                        <h3>AI Assistant Karang Cakap</h3>
                        <p class="ai-status">
                            <span class="status-dot"></span>
                            Online - Siap membantu Anda
                        </p>
                    </div>
                </div>
                <div class="chat-header-actions">
                    <button class="btn-icon" title="Info">
                        <i class="fas fa-info-circle"></i>
                    </button>
                    <button class="btn-icon" title="Pengaturan">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </div>

            <div class="chat-messages" id="chatMessages">
                <!-- Welcome Message -->
                <div class="message-group ai">
                    <div class="message-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <p>Selamat datang di <strong>Karang Cakap AI Assistant</strong>! 🌊</p>
                            <p>Saya di sini untuk membantu Anda menjawab pertanyaan seputar:</p>
                            <ul>
                                <li>🪸 Terumbu karang dan ekosistemnya</li>
                                <li>🐠 Berbagai jenis biota laut</li>
                                <li>🌏 Konservasi dan pelestarian laut</li>
                                <li>🔬 Penelitian dan fakta menarik</li>
                            </ul>
                            <p>Silakan ajukan pertanyaan Anda!</p>
                        </div>
                        <span class="message-time">14:25</span>
                    </div>
                </div>

                <!-- Suggested Questions -->
                <div class="suggested-questions">
                    <h4><i class="fas fa-lightbulb"></i> Pertanyaan Populer:</h4>
                    <div class="suggestions-grid">
                        <button class="suggestion-btn" onclick="askQuestion('Apa itu terumbu karang?')">
                            <i class="fas fa-water"></i>
                            Apa itu terumbu karang?
                        </button>
                        <button class="suggestion-btn" onclick="askQuestion('Bagaimana cara melindungi terumbu karang?')">
                            <i class="fas fa-shield-alt"></i>
                            Cara melindungi terumbu karang?
                        </button>
                        <button class="suggestion-btn" onclick="askQuestion('Apa saja jenis ikan yang hidup di terumbu karang?')">
                            <i class="fas fa-fish"></i>
                            Jenis ikan di terumbu karang?
                        </button>
                        <button class="suggestion-btn" onclick="askQuestion('Apa dampak perubahan iklim terhadap biota laut?')">
                            <i class="fas fa-temperature-high"></i>
                            Dampak perubahan iklim?
                        </button>
                    </div>
                </div>
            </div>

            <!-- Typing Indicator -->
            <div class="typing-indicator" id="typingIndicator" style="display: none;">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <!-- Chat Input -->
            <div class="chat-input-container">
                <div class="chat-input-wrapper">
                    <button class="btn-attach" title="Lampiran">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <textarea 
                        id="messageInput" 
                        placeholder="Ketik pertanyaan Anda tentang biota laut..."
                        rows="1"
                    ></textarea>
                    <button class="btn-emoji" title="Emoji">
                        <i class="fas fa-smile"></i>
                    </button>
                    <button class="btn-send" id="sendButton" onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <div class="input-hint">
                    <i class="fas fa-info-circle"></i>
                    Tekan Enter untuk mengirim, Shift + Enter untuk baris baru
                </div>
            </div>
        </main>

        <!-- Info Panel (Optional) -->
        <aside class="chat-info" id="chatInfo">
            <div class="info-header">
                <h3>Informasi</h3>
                <button class="btn-close" onclick="toggleInfo()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="info-content">
                <div class="info-section">
                    <h4><i class="fas fa-robot"></i> Tentang AI</h4>
                    <p>AI Assistant kami dilatih dengan database komprehensif tentang biota laut, terumbu karang, dan ekosistem laut.</p>
                </div>
                <div class="info-section">
                    <h4><i class="fas fa-chart-line"></i> Statistik</h4>
                    <div class="stat-item">
                        <span>Total Pertanyaan</span>
                        <strong>1,234</strong>
                    </div>
                    <div class="stat-item">
                        <span>Akurasi Jawaban</span>
                        <strong>98.5%</strong>
                    </div>
                    <div class="stat-item">
                        <span>Waktu Respons Rata-rata</span>
                        <strong>2.3 detik</strong>
                    </div>
                </div>
                <div class="info-section">
                    <h4><i class="fas fa-book"></i> Sumber Data</h4>
                    <ul class="source-list">
                        <li><i class="fas fa-check"></i> Jurnal Ilmiah Internasional</li>
                        <li><i class="fas fa-check"></i> Database Spesies Laut</li>
                        <li><i class="fas fa-check"></i> Laporan Konservasi</li>
                        <li><i class="fas fa-check"></i> Penelitian Terkini</li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>

    <script src="{{ asset('script.js') }}"></script>
    <script src="{{ asset('chatbox.js') }}"></script>
</body>
</html>
