<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar akun kasir & admin
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan akun terbaru
        $users = $query->orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menyimpan akun kasir baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:owner,kasir',
            'is_active' => 'required|in:0,1',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => (bool)$request->is_active,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun kasir berhasil dibuat.');
    }

    /**
     * Memperbarui data akun kasir
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $id,
            'password'  => 'nullable|string|min:6',
            'role'      => 'required|in:owner,kasir',
            'is_active' => 'required|in:0,1',
        ]);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => (bool)$request->is_active,
        ];

        // Hanya ubah kata sandi jika input diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data akun kasir berhasil diperbarui.');
    }

    /**
     * Menghapus akun kasir
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah owner menghapus akun miliknya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun kasir berhasil dihapus.');
    }
}
