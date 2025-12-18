<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeRedirectController
{
    public function __invoke(Request $request)
    {
        // If user is authenticated, send to home/dashboard depending on role
        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }

        // Otherwise redirect to login (guest)
        return redirect()->route('login');
    }
}
