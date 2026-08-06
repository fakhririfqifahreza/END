<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    // Tampilkan halaman login admin
    public function showLogin()
    {
        // Jika sudah login sebagai admin/pemilik warung, redirect ke dashboard
        if (Auth::check() && Auth::user()->isAdminOrOwner()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }

    // Proses login admin
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            // Pastikan user adalah admin/pemilik warung
            if (Auth::user()->isAdminOrOwner()) {
                $request->session()->regenerate();
                if (Auth::user()->isOwner()) {
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Pemilik Warung!');
                }
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
            }
 
            // Jika bukan admin/pemilik warung, logout dan redirect
            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => 'Akun Anda bukan akun admin atau pemilik warung'])
                ->withInput();
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput();
    }

    // Tampilkan halaman register admin
    public function showRegister()
    {
        // Jika sudah login sebagai admin/pemilik warung, redirect ke dashboard
        if (Auth::check() && Auth::user()->isAdminOrOwner()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.register');
    }

    // Proses register admin
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set role sebagai admin
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Registrasi admin berhasil! Selamat datang!');
    }

    // Proses logout admin
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Berhasil logout');
    }
}
