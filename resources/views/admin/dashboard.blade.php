@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Quick Actions -->
<div class="card" style="margin-bottom: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div style="padding: 20px;">
        <h3 style="margin-bottom: 15px; color: white;">⚡ Quick Actions</h3>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="{{ route('admin.news.create') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                <i class="fas fa-plus"></i> Tambah Berita
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                <i class="fas fa-user-plus"></i> Tambah User
            </a>
            <a href="{{ route('admin.news.index') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                <i class="fas fa-newspaper"></i> Kelola Berita
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                <i class="fas fa-users"></i> Kelola User
            </a>
            <a href="{{ route('home') }}" target="_blank" class="btn" style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                <i class="fas fa-external-link-alt"></i> Lihat Website
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <!-- Total Berita -->
    <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 10px; font-size: 14px;">Total Berita</p>
                <h2 style="font-size: 36px; margin: 0;">{{ $stats['total_news'] }}</h2>
                @if($news_growth > 0)
                    <p style="font-size: 12px; margin-top: 5px; opacity: 0.8;">
                        <i class="fas fa-arrow-up"></i> +{{ $news_growth }}% (30 hari)
                    </p>
                @endif
            </div>
            <i class="fas fa-newspaper" style="font-size: 64px; opacity: 0.2; position: absolute; right: -10px; top: -10px;"></i>
        </div>
    </div>

    <!-- Berita Published -->
    <div class="card" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 10px; font-size: 14px;">Berita Published</p>
                <h2 style="font-size: 36px; margin: 0;">{{ $stats['published_news'] }}</h2>
                <p style="font-size: 12px; margin-top: 5px; opacity: 0.8;">
                    {{ $stats['total_news'] > 0 ? round(($stats['published_news'] / $stats['total_news']) * 100, 1) : 0 }}% dari total
                </p>
            </div>
            <i class="fas fa-check-circle" style="font-size: 64px; opacity: 0.2; position: absolute; right: -10px; top: -10px;"></i>
        </div>
    </div>

    <!-- Draft Berita -->
    <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 10px; font-size: 14px;">Draft Berita</p>
                <h2 style="font-size: 36px; margin: 0;">{{ $stats['draft_news'] }}</h2>
                <p style="font-size: 12px; margin-top: 5px; opacity: 0.8;">
                    Perlu review
                </p>
            </div>
            <i class="fas fa-edit" style="font-size: 64px; opacity: 0.2; position: absolute; right: -10px; top: -10px;"></i>
        </div>
    </div>

    <!-- Total Views -->
    <div class="card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 10px; font-size: 14px;">Total Views</p>
                <h2 style="font-size: 36px; margin: 0;">{{ number_format($stats['total_views']) }}</h2>
                <p style="font-size: 12px; margin-top: 5px; opacity: 0.8;">
                    Avg: {{ number_format($stats['avg_views'], 0) }} per berita
                </p>
            </div>
            <i class="fas fa-eye" style="font-size: 64px; opacity: 0.2; position: absolute; right: -10px; top: -10px;"></i>
        </div>
    </div>

    <!-- Total Users -->
    <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
            <div>
                <p style="opacity: 0.9; margin-bottom: 10px; font-size: 14px;">Total Users</p>
                <h2 style="font-size: 36px; margin: 0;">{{ $stats['total_users'] }}</h2>
                @if($users_growth > 0)
                    <p style="font-size: 12px; margin-top: 5px; opacity: 0.8;">
                        <i class="fas fa-arrow-up"></i> +{{ $users_growth }}% (30 hari)
                    </p>
                @endif
            </div>
            <i class="fas fa-users" style="font-size: 64px; opacity: 0.2; position: absolute; right: -10px; top: -10px;"></i>
        </div>
    </div>

    <!-- Total Admins -->
    <div class="card" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); color: #333; position: relative; overflow: hidden;">
        <div style="display: flex; justify-content: space-between; align-items: center; position: relative; z-index: 1;">
            <div>
                <p style="opacity: 0.7; margin-bottom: 10px; font-size: 14px;">Total Admins</p>
                <h2 style="font-size: 36px; margin: 0; color: #333;">{{ $stats['total_admins'] }}</h2>
                <p style="font-size: 12px; margin-top: 5px; opacity: 0.6;">
                    Admin aktif
                </p>
            </div>
            <i class="fas fa-user-shield" style="font-size: 64px; opacity: 0.2; position: absolute; right: -10px; top: -10px; color: #333;"></i>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 30px;">
    <!-- News Chart -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-chart-line"></i> Berita 7 Hari Terakhir</h3>
        </div>
        <canvas id="newsChart" style="max-height: 300px;"></canvas>
    </div>

    <!-- News by Category -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-chart-pie"></i> Berita per Kategori</h3>
        </div>
        <canvas id="categoryChart" style="max-height: 300px;"></canvas>
    </div>
</div>

<!-- Main Content Row -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
    <!-- Top 5 Most Viewed News -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3><i class="fas fa-fire"></i> Berita Terpopuler</h3>
            <span class="badge badge-danger">Top 5</span>
        </div>
        <div style="max-height: 400px; overflow-y: auto;">
            @forelse($top_news as $index => $news)
            <div style="padding: 15px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                        <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold;">
                            {{ $index + 1 }}
                        </span>
                        <strong style="font-size: 14px;">{{ Str::limit($news->title, 50) }}</strong>
                    </div>
                    <div style="display: flex; gap: 15px; font-size: 12px; color: #666; margin-left: 34px;">
                        <span><i class="fas fa-eye"></i> {{ number_format($news->views) }} views</span>
                        <span><i class="fas fa-calendar"></i> {{ $news->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
            @empty
            <div style="text-align: center; padding: 40px; color: #999;">
                <i class="fas fa-newspaper" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                Belum ada berita yang populer
            </div>
            @endforelse
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-history"></i> Aktivitas Terkini</h3>
        </div>
        <div style="max-height: 400px; overflow-y: auto;">
            @forelse($recent_activity as $activity)
            <div style="padding: 15px; border-bottom: 1px solid #f0f0f0;">
                <div style="display: flex; gap: 10px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; flex-shrink: 0;">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-size: 14px; font-weight: 500;">
                            {{ $activity->created_at == $activity->updated_at ? 'Berita baru' : 'Berita diupdate' }}: 
                            <strong>{{ Str::limit($activity->title, 40) }}</strong>
                        </p>
                        <div style="display: flex; gap: 15px; font-size: 12px; color: #666; margin-top: 5px;">
                            <span><i class="fas fa-user"></i> {{ $activity->author->name }}</span>
                            <span><i class="fas fa-clock"></i> {{ $activity->updated_at->diffForHumans() }}</span>
                            @if($activity->status === 'published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 40px; color: #999;">
                <i class="fas fa-history" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                Belum ada aktivitas
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Latest News & Users Row -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    <!-- Latest News -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3><i class="fas fa-newspaper"></i> Berita Terbaru</h3>
            <a href="{{ route('admin.news.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest_news as $news)
                <tr>
                    <td>
                        <a href="{{ route('admin.news.edit', $news) }}" style="color: #667eea; text-decoration: none;">
                            {{ Str::limit($news->title, 40) }}
                        </a>
                    </td>
                    <td>
                        @if($news->status === 'published')
                            <span class="badge badge-success">Published</span>
                        @else
                            <span class="badge badge-warning">Draft</span>
                        @endif
                    </td>
                    <td>{{ $news->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #999; padding: 40px;">
                        <i class="fas fa-newspaper" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                        Belum ada berita
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Latest Users -->
    <div class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3><i class="fas fa-users"></i> User Terbaru</h3>
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">Lihat Semua</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latest_users as $user)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            {{ $user->name }}
                        </div>
                    </td>
                    <td>{{ Str::limit($user->email, 25) }}</td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #999; padding: 40px;">
                        <i class="fas fa-users" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                        Belum ada user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Wait for Chart.js to load
    document.addEventListener('DOMContentLoaded', function() {
    // News Chart (Line Chart)
    const newsCtx = document.getElementById('newsChart').getContext('2d');
    const newsChart = new Chart(newsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($news_last_7_days, 'date')) !!},
            datasets: [{
                label: 'Berita Dibuat',
                data: {!! json_encode(array_column($news_last_7_days, 'count')) !!},
                borderColor: 'rgb(102, 126, 234)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Category Chart (Doughnut Chart)
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryLabels = {!! json_encode(array_keys($news_by_category->toArray())) !!};
    const categoryData = {!! json_encode(array_values($news_by_category->toArray())) !!};
    
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: categoryLabels.map(cat => {
                const categories = {
                    'coral': 'Terumbu Karang',
                    'fish': 'Ikan & Biota',
                    'conservation': 'Konservasi',
                    'research': 'Penelitian',
                    'climate': 'Iklim',
                    'general': 'Umum'
                };
                return categories[cat] || cat;
            }),
            datasets: [{
                data: categoryData,
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(17, 153, 142, 0.8)',
                    'rgba(240, 147, 251, 0.8)',
                    'rgba(250, 112, 154, 0.8)',
                    'rgba(79, 172, 254, 0.8)',
                    'rgba(168, 237, 234, 0.8)'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    }); // End DOMContentLoaded
</script>
@endpush
@endsection
