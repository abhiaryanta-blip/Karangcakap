<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article->title }} - Karang Cakap</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .article-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        .article-header {
            margin-bottom: 40px;
            text-align: center;
        }
        
        .article-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #1a1a1a;
            line-height: 1.2;
        }
        
        .article-meta {
            display: flex;
            justify-content: center;
            gap: 30px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
            color: #666;
            font-size: 0.95rem;
        }
        
        .article-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .article-author img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }
        
        .article-category {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .article-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }
        
        .article-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }
        
        .article-content p {
            margin-bottom: 20px;
        }
        
        .article-stats {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid #667eea;
        }
        
        .stat {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
        }
        
        .stat i {
            color: #667eea;
            font-size: 1.2rem;
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            margin-bottom: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .back-button:hover {
            gap: 12px;
            color: #764ba2;
        }
        
        .related-news {
            margin-top: 80px;
            padding-top: 60px;
            border-top: 2px solid #e0e0e0;
        }
        
        .related-news-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            color: #1a1a1a;
        }
        
        .related-news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        
        .related-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        
        .related-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .related-card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #f0f0f0;
        }
        
        .related-card-content {
            padding: 20px;
        }
        
        .related-card-title {
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 1.1rem;
            color: #1a1a1a;
        }
        
        .related-card-excerpt {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }
    </style>
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

    <!-- Main Content -->
    <section class="news-section" style="padding-top: 60px;">
        <div class="container">
            <div class="article-container">
                <a href="{{ route('news') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i> Kembali ke Berita
                </a>

                <div class="article-header">
                    <div class="article-category">{{ ucfirst(str_replace('_', ' ', $article->category)) }}</div>
                    <h1 class="article-title">{{ $article->title }}</h1>
                    
                    <div class="article-meta">
                        <div class="article-author">
                            <img src="https://i.pravatar.cc/150?u={{ $article->author->email }}" alt="Author">
                            <div>
                                <div style="font-weight: 600; color: #1a1a1a;">{{ $article->author->name }}</div>
                                <div style="font-size: 0.9rem; color: #999;">{{ $article->published_at->format('d M Y') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="article-stats">
                        <div class="stat">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($article->views) }} kali dilihat</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-clock"></i>
                            <span>{{ ceil(str_word_count($article->content) / 200) }} menit baca</span>
                        </div>
                    </div>
                </div>

                @if($article->image)
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="article-image">
                @endif

                <div class="article-content">
                    {!! nl2br(e($article->content)) !!}
                </div>
            </div>

            <!-- Related News -->
            @php
                $relatedNews = \App\Models\News::where('status', 'published')
                    ->where('id', '!=', $article->id)
                    ->latest('published_at')
                    ->limit(3)
                    ->get();
            @endphp

            @if($relatedNews->count() > 0)
            <div class="article-container related-news">
                <h2 class="related-news-title">Berita Terkait</h2>
                <div class="related-news-grid">
                    @foreach($relatedNews as $related)
                    <a href="{{ route('news.detail', $related->slug) }}" class="related-card">
                        @if($related->image)
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="related-card-image">
                        @else
                            <div class="related-card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                        @endif
                        <div class="related-card-content">
                            <div class="related-card-title">{{ Str::limit($related->title, 60) }}</div>
                            <div class="related-card-excerpt">{{ Str::limit($related->excerpt ?? $related->content, 80) }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
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

    <script src="{{ asset('script.js') }}"></script>
</body>
</html>
