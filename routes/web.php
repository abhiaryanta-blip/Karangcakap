<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\UserController;

// Public Routes
// Redirect root to login so users (including admins) land on the login page first
Route::get('/', function () {
    return redirect()->route('login');
});

// Preserve the original home page under /home so `route('home')` still works
Route::get('/home', function () {
    $latestNews = \App\Models\News::where('status', 'published')
        ->latest('published_at')
        ->take(3)
        ->get();
    
    // Get real statistics
    $stats = [
        'articles' => \App\Models\News::where('status', 'published')->count(),
        'species' => 500, // Placeholder - can be updated with actual data source
        'activeUsers' => \App\Models\User::count(),
        'answeredQuestions' => 50000, // Placeholder - can be updated from chat logs if implemented
    ];
    
    return view('home', compact('latestNews', 'stats'));
})->name('home');

Route::get('/berita', function () {
    $news = \App\Models\News::where('status', 'published')
        ->latest('published_at')
        ->get();
    return view('news', compact('news'));
})->name('news');

Route::get('/berita/{slug}', function ($slug) {
    $article = \App\Models\News::where('slug', $slug)
        ->where('status', 'published')
        ->firstOrFail();
    
    // Increment views
    $article->increment('views');
    
    return view('news-detail', compact('article'));
})->name('news.detail');

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

// Chat API Routes - with CSRF protection
Route::post('/api/chat', [ChatController::class, 'sendMessage'])
    ->name('chat.send')
    ->middleware('web');

// Debug: Simple test endpoint
Route::post('/api/chat-test', function (Request $request) {
    $message = $request->input('message', 'test');
    return response()->json([
        'success' => true,
        'response' => 'Echo: ' . $message,
    ]);
})->name('chat.test');

// Debug route to test Gemini API
Route::get('/test-gemini', function () {
    $apiKey = config('services.gemini.api_key');
    $userMessage = 'Apa itu terumbu karang?';
    
    $systemPrompt = "Anda adalah AI Assistant yang ahli tentang biota laut, terumbu karang, dan ekosistem laut. Jawab pertanyaan dalam Bahasa Indonesia dengan informasi yang akurat dan mudah dipahami.";
    $fullMessage = $systemPrompt . "\n\nPertanyaan pengguna: " . $userMessage;
    
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . $apiKey;
    
    try {
        $response = \Illuminate\Support\Facades\Http::timeout(30)->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $fullMessage]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1024,
            ],
        ]);
        
        return response()->json([
            'status' => $response->status(),
            'successful' => $response->successful(),
            'body' => $response->json(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
        ], 500);
    }
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Debug Routes (temporary - remove in production)
Route::get('/debug-admin', function () {
    return view('debug-admin');
})->middleware('auth')->name('debug.admin');
Route::middleware('auth')->group(function () {
    Route::get('/debug/admin', [\App\Http\Controllers\DebugController::class, 'checkAdmin'])->name('debug.admin.api');
    Route::post('/debug/fix-admin', [\App\Http\Controllers\DebugController::class, 'fixAdmin'])->name('debug.fix-admin');
});

// Test Route - untuk debug
Route::get('/test-admin', function () {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not logged in'], 401);
    }
    $user = auth()->user();
    $dbUser = \App\Models\User::find($user->id);
    
    return response()->json([
        'logged_in' => true,
        'user_id' => $user->id,
        'user_email' => $user->email,
        'user_name' => $user->name,
        'user_role_session' => $user->role ?? 'null',
        'user_role_db' => $dbUser->role ?? 'null',
        'has_role_column' => isset($dbUser->role),
        'is_admin' => ($user->role === 'admin' || $dbUser->role === 'admin'),
        'can_access_admin_dashboard' => ($user->role === 'admin' || $dbUser->role === 'admin'),
        'admin_dashboard_url' => route('admin.dashboard'),
    ]);
})->middleware('auth');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // News Management
    Route::resource('news', AdminNewsController::class);
    
    // User Management
    Route::resource('users', UserController::class);
});
