<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeRedirectController
{
    public function __invoke(Request $request)
    {
        // Always redirect to login (force login first)
        return redirect()->route('login');
    }
}
