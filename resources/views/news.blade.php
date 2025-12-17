<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - Karang Cakap</title>
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
                <a href="{{ route('news') }}" class="nav-link active">
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1><i class="fas fa-newspaper"></i> Berita Biota Laut</h1>
            <p>Update terkini seputar kehidupan laut dan konservasi terumbu karang</p>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-section">
        <div class="container">
            <div class="news-layout">
                <!-- Sidebar -->
                <aside class="news-sidebar">
                    <div class="sidebar-card">
                        <h3><i class="fas fa-filter"></i> Filter Kategori</h3>
                        <div class="category-filters">
                            <button class="filter-btn active" data-category="all">
                                <i class="fas fa-th"></i> Semua Berita
                            </button>
                            <button class="filter-btn" data-category="coral">
                                <i class="fas fa-water"></i> Terumbu Karang
                            </button>
                            <button class="filter-btn" data-category="fish">
                                <i class="fas fa-fish"></i> Ikan & Biota
                            </button>
                            <button class="filter-btn" data-category="conservation">
                                <i class="fas fa-leaf"></i> Konservasi
                            </button>
                            <button class="filter-btn" data-category="research">
                                <i class="fas fa-flask"></i> Penelitian
                            </button>
                            <button class="filter-btn" data-category="climate">
                                <i class="fas fa-temperature-high"></i> Iklim
                            </button>
                        </div>
                    </div>

                    <div class="sidebar-card">
                        <h3><i class="fas fa-fire"></i> Berita Populer</h3>
                        <div class="popular-news">
                            <a href="#" class="popular-item">
                                <span class="popular-number">1</span>
                                <div>
                                    <h4>Terumbu Karang di Raja Ampat Pulih</h4>
                                    <span class="popular-views"><i class="fas fa-eye"></i> 15.2K</span>
                                </div>
                            </a>
                            <a href="#" class="popular-item">
                                <span class="popular-number">2</span>
                                <div>
                                    <h4>Spesies Baru Ikan Langka Ditemukan</h4>
                                    <span class="popular-views"><i class="fas fa-eye"></i> 12.8K</span>
                                </div>
                            </a>
                            <a href="#" class="popular-item">
                                <span class="popular-number">3</span>
                                <div>
                                    <h4>Teknologi AI untuk Konservasi Laut</h4>
                                    <span class="popular-views"><i class="fas fa-eye"></i> 11.5K</span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="sidebar-card newsletter">
                        <i class="fas fa-envelope-open-text newsletter-icon"></i>
                        <h3>Newsletter</h3>
                        <p>Dapatkan berita terbaru langsung di email Anda</p>
                        <form class="newsletter-form">
                            <input type="email" placeholder="Email Anda" required>
                            <button type="submit" class="btn-subscribe">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="news-main">
                    <div class="news-controls">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchNews" placeholder="Cari berita...">
                        </div>
                        <select class="sort-select">
                            <option value="latest">Terbaru</option>
                            <option value="popular">Terpopuler</option>
                            <option value="oldest">Terlama</option>
                        </select>
                    </div>

                    <div class="news-list" id="newsList">
                        @forelse($news as $article)
                        <a href="{{ route('news.detail', $article->slug) }}" style="text-decoration: none; color: inherit;">
                        <article class="news-item" data-category="{{ $article->category }}" style="cursor: pointer;">
                            <div class="news-item-image" style="background-image: url('{{ $article->image ? asset('storage/' . $article->image) : 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=800' }}');"></div>
                            <div class="news-item-content">
                                <div class="news-item-header">
                                    <span class="news-category {{ $article->category }}">{{ ucfirst(str_replace('_', ' ', $article->category)) }}</span>
                                    <span class="news-date"><i class="fas fa-calendar"></i> {{ $article->published_at->format('d M Y') }}</span>
                                </div>
                                <h2>{{ $article->title }}</h2>
                                <p>{{ $article->excerpt ?? Str::limit($article->content, 150, '...') }}</p>
                                <div class="news-item-footer">
                                    <div class="news-author">
                                        <img src="https://i.pravatar.cc/150?u={{ $article->author->email }}" alt="Author">
                                        <span>{{ $article->author->name }}</span>
                                    </div>
                                    <div class="news-stats">
                                        <span><i class="fas fa-eye"></i> {{ number_format($article->views) }}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                        </a>
                        @empty
                        <div style="text-align: center; padding: 40px; color: #999;">
                            <i class="fas fa-newspaper" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                            <p>Belum ada berita yang dipublikasikan</p>
                        </div>
                        @endforelse
                    </div>
                </main>
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
                </div>
                <div class="footer-section">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('news') }}">Berita</a></li>
                        <li><a href="{{ route('chat') }}">AI Chat</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kategori</h4>
                    <ul>
                        <li><a href="#">Terumbu Karang</a></li>
                        <li><a href="#">Ikan Tropis</a></li>
                        <li><a href="#">Konservasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Karang Cakap. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="{{ asset('news.js') }}"></script>
    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
