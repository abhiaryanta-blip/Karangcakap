<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        // Basic Stats
        $stats = [
            'total_news' => News::count(),
            'published_news' => News::where('status', 'published')->count(),
            'draft_news' => News::where('status', 'draft')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_views' => News::sum('views'),
            'avg_views' => News::where('status', 'published')->avg('views') ?? 0,
        ];

        // News by Category
        $news_by_category = News::select('category', DB::raw('count(*) as total'))
            ->groupBy('category')
            ->get()
            ->pluck('total', 'category');

        // News by Status
        $news_by_status = News::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status');

        // News Created in Last 7 Days (for chart)
        $news_last_7_days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = News::whereDate('created_at', $date->format('Y-m-d'))->count();
            $news_last_7_days[] = [
                'date' => $date->format('d M'),
                'count' => $count
            ];
        }

        // Top 5 Most Viewed News
        $top_news = News::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Latest News
        $latest_news = News::with('author')
            ->latest('created_at')
            ->take(5)
            ->get();

        // Latest Users
        $latest_users = User::where('role', 'user')
            ->latest('created_at')
            ->take(5)
            ->get();

        // Recent Activity (News created/updated in last 7 days)
        $recent_activity = News::with('author')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orWhere('updated_at', '>=', Carbon::now()->subDays(7))
            ->latest('updated_at')
            ->take(10)
            ->get();

        // Users Growth (Last 30 days)
        $users_last_30_days = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $users_before_30_days = User::where('created_at', '<', Carbon::now()->subDays(30))->count();
        $users_growth = $users_before_30_days > 0 
            ? round(($users_last_30_days / $users_before_30_days) * 100, 1) 
            : 0;

        // News Growth (Last 30 days)
        $news_last_30_days = News::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $news_before_30_days = News::where('created_at', '<', Carbon::now()->subDays(30))->count();
        $news_growth = $news_before_30_days > 0 
            ? round(($news_last_30_days / $news_before_30_days) * 100, 1) 
            : 0;

        return view('admin.dashboard', compact(
            'stats',
            'news_by_category',
            'news_by_status',
            'news_last_7_days',
            'top_news',
            'latest_news',
            'latest_users',
            'recent_activity',
            'users_growth',
            'news_growth'
        ));
    }
}

