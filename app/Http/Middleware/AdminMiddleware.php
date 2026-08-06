<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan merupakan admin
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu');
        }

        if (!Auth::user()->isAdminOrOwner()) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman admin');
        }

        return $next($request);
    }
}
