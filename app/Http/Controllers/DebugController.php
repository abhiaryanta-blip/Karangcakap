<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DebugController extends Controller
{
    /**
     * Debug user role and admin access
     */
    public function checkAdmin()
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'not_logged_in',
                'message' => 'Anda belum login'
            ]);
        }

        $user = Auth::user();
        
        // Check from database directly
        $dbUser = User::where('email', $user->email)->first();
        
        return response()->json([
            'status' => 'logged_in',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_from_session' => $user->role ?? 'null',
                'role_from_db' => $dbUser->role ?? 'null',
                'has_role_column' => isset($dbUser->role),
            ],
            'is_admin' => ($user->role === 'admin' || $dbUser->role === 'admin'),
            'can_access_admin' => ($user->role === 'admin' || $dbUser->role === 'admin'),
        ]);
    }

    /**
     * Fix admin role directly
     */
    public function fixAdmin(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Not logged in'], 401);
        }

        $user = Auth::user();
        
        try {
            // Check if role column exists, if not add it
            $columns = DB::select("SHOW COLUMNS FROM users LIKE 'role'");
            if (empty($columns)) {
                DB::statement("ALTER TABLE users ADD COLUMN role ENUM('admin', 'user') DEFAULT 'user' AFTER password");
            }

            // Update role in database
            DB::table('users')
                ->where('email', $user->email)
                ->update(['role' => 'admin']);
            
            // Refresh user model
            $user->refresh();
            
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diupdate menjadi admin!',
                'user' => [
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}

