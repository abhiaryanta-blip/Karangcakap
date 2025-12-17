<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karang Cakap - Berita Biota Laut</title>
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
                <a href="{{ route('home') }}" class="nav-link active">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <a href="{{ route('news') }}" class="nav-link">
                    <i class="fas fa-newspaper"></i> Berita
                </a>
                <a href="{{ route('chat') }}" class="nav-link">
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

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di Karang Cakap</h1>
            <p class="hero-subtitle">Portal Berita Terdepan untuk Kehidupan Biota Laut</p>
            <div class="hero-buttons">
                <a href="{{ route('news') }}" class="btn btn-primary">
                    <i class="fas fa-newspaper"></i> Jelajahi Berita
                </a>
                <a href="{{ route('chat') }}" class="btn btn-secondary">
                    <i class="fas fa-robot"></i> Tanya AI
                </a>
            </div>
        </div>
        <div class="hero-scroll">
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Fitur Unggulan</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3>Berita Terkini</h3>
                    <p>Update berita terbaru seputar biota laut, terumbu karang, dan ekosistem laut dari seluruh dunia</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>AI Assistant</h3>
                    <p>Chatbot AI yang siap menjawab pertanyaan seputar terumbu karang dan kehidupan biota laut</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-fish"></i>
                    </div>
                    <h3>Database Lengkap</h3>
                    <p>Informasi komprehensif tentang berbagai jenis biota laut dan habitatnya</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <h3>Galeri Visual</h3>
                    <p>Koleksi foto dan video berkualitas tinggi dari keindahan bawah laut</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest News Preview -->
    <section class="news-preview">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Berita Terbaru</h2>
                <a href="{{ route('news') }}" class="btn-link">Lihat Semua <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="news-grid">
                @forelse($latestNews as $index => $article)
                    <div class="news-card {{ $index === 0 ? 'featured' : '' }}">
                        @if($index === 0)
                            <span class="news-badge">Trending</span>
                        @endif
                        <div class="news-image" style="background-image: url('{{ $article->image ? asset('storage/' . $article->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800' }}');"></div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i class="fas fa-calendar"></i> {{ $article->published_at->format('d M Y') }}</span>
                                <span><i class="fas fa-tag"></i> 
                                    @switch($article->category)
                                        @case('coral')
                                            Terumbu Karang
                                        @break
                                        @case('fish')
                                            Ikan & Biota
                                        @break
                                        @case('conservation')
                                            Konservasi
                                        @break
                                        @case('research')
                                            Penelitian
                                        @break
                                        @case('climate')
                                            Iklim
                                        @break
                                        @default
                                            Berita
                                    @endswitch
                                </span>
                            </div>
                            <h3>{{ $article->title }}</h3>
                            <p>{{ $article->excerpt ? substr($article->excerpt, 0, 120) : substr($article->content, 0, 120) }}...</p>
                            <a href="{{ route('news.detail', $article->slug) }}" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @empty
                    <div class="news-card featured">
                        <div class="news-image" style="background-image: url('https://images.unsplash.com/photo-1582967788606-a171c1080cb0?w=800');">
                            <span class="news-badge">Trending</span>
                        </div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i class="fas fa-calendar"></i> 18 Des 2025</span>
                                <span><i class="fas fa-tag"></i> Terumbu Karang</span>
                            </div>
                            <h3>Penemuan Spesies Karang Baru di Laut Dalam Indonesia</h3>
                            <p>Para peneliti menemukan spesies karang baru yang belum pernah teridentifikasi sebelumnya di perairan dalam Indonesia...</p>
                            <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="news-card">
                        <div class="news-image" style="background-image: url('https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800');"></div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i class="fas fa-calendar"></i> 17 Des 2025</span>
                                <span><i class="fas fa-tag"></i> Konservasi</span>
                            </div>
                            <h3>Program Restorasi Terumbu Karang Berhasil di Kepulauan Raja Ampat</h3>
                            <p>Upaya konservasi menunjukkan hasil positif dengan peningkatan populasi karang hingga 45%...</p>
                            <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="news-card">
                        <div class="news-image" style="background-image: url('https://images.unsplash.com/photo-1583212292454-1fe6229603b7?w=800');"></div>
                        <div class="news-content">
                            <div class="news-meta">
                                <span><i class="fas fa-calendar"></i> 16 Des 2025</span>
                                <span><i class="fas fa-tag"></i> Penelitian</span>
                            </div>
                            <h3>Dampak Perubahan Iklim Terhadap Ekosistem Laut Tropis</h3>
                            <p>Studi terbaru mengungkap bagaimana pemanasan global mempengaruhi kehidupan biota laut...</p>
                            <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="stat-number" data-target="{{ $stats['articles'] ?? 1250 }}">0</div>
                    <div class="stat-label">Artikel Berita</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-fish"></i>
                    </div>
                    <div class="stat-number" data-target="{{ $stats['species'] ?? 500 }}">0</div>
                    <div class="stat-label">Spesies Terdokumentasi</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number" data-target="{{ $stats['activeUsers'] ?? 10000 }}">0</div>
                    <div class="stat-label">Pengguna Aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <div class="stat-number" data-target="{{ $stats['answeredQuestions'] ?? 50000 }}">0</div>
                    <div class="stat-label">Pertanyaan Dijawab</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <i class="fas fa-water"></i>
                        <span>KARANG CAKAP</span>
                    </div>
                    <p>Platform informasi terdepan untuk berita dan pengetahuan seputar biota laut dan terumbu karang.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('news') }}">Berita</a></li>
                        <li><a href="{{ route('chat') }}">AI Chat</a></li>
                        <li><a href="#">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kategori</h4>
                    <ul>
                        <li><a href="#">Terumbu Karang</a></li>
                        <li><a href="#">Ikan Tropis</a></li>
                        <li><a href="#">Konservasi</a></li>
                        <li><a href="#">Penelitian</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kontak</h4>
                    <ul>
                        <li><i class="fas fa-envelope"></i> info@karangcakap.com</li>
                        <li><i class="fas fa-phone"></i> +62 21 1234 5678</li>
                        <li><i class="fas fa-map-marker-alt"></i> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Karang Cakap. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
