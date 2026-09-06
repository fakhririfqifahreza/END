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
    // Tampilkan halaman login
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->isAdminOrOwner()) {
            return redirect()->route('admin.kasir');
        }

        return view('admin.auth.login');
    }

    // Proses login
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

        // Kredensial login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            // 1. Cek apakah status akun sedang dinonaktifkan oleh Owner
            if (isset(Auth::user()->is_active) && !Auth::user()->is_active) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['email' => 'Akun Anda sedang dinonaktifkan oleh Owner. Silakan hubungi pemilik warung.'])
                    ->withInput();
            }

            // 2. Cek apakah role akun memiliki hak akses kasir / admin / owner
            if (Auth::user()->isAdminOrOwner()) {
                $request->session()->regenerate();
                return redirect()->route('admin.kasir')->with('success', 'Selamat datang!');
            }

            Auth::logout();
            return redirect()->back()
                ->withErrors(['email' => 'Akun Anda bukan akun admin, kasir, atau pemilik warung'])
                ->withInput();
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput();
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        if (Auth::check() && Auth::user()->isAdminOrOwner()) {
            return redirect()->route('admin.kasir');
        }

        return view('admin.auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,pemilik_warung,kasir,owner',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role yang dipilih tidak valid',
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
            'role' => $request->role,
            'is_active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('admin.kasir')->with('success', 'Selamat datang!');
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
