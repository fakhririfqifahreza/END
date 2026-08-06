<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AutoLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, otomatis login sebagai user pertama (atau buat user default)
        if (!Auth::check()) {
            $user = User::first();
            
            // Jika belum ada user, buat user default
            if (!$user) {
                $user = User::create([
                    'name' => 'Admin ',
                    'email' => 'admin@localhost.com',
                    'password' => bcrypt('password'),
                    'role' => 'admin',
                ]);
            }
            
            Auth::login($user);
        }
        
        return $next($request);
    }
}
