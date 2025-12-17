<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        
        // Debug: Check role from database directly
        $dbUser = \App\Models\User::find($user->id);
        
        if (!$dbUser || ($dbUser->role !== 'admin' && $user->role !== 'admin')) {
            return redirect('/')
                ->with('error', 'Anda tidak memiliki akses ke halaman admin. Role Anda: ' . ($dbUser->role ?? $user->role ?? 'tidak ada'));
        }

        return $next($request);
    }
}

