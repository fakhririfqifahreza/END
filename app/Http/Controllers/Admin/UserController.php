<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        // 1. Kasir dilarang menambah akun baru
        if (!Auth::user()->isOwner()) {
            return back()->with('error', 'Hanya Owner yang memiliki hak akses untuk menambahkan akun baru.');
        }

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:owner,kasir,pemilik_warung,admin',
            'is_active' => 'required|in:0,1',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => (bool)$request->is_active,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        // 1. Kasir dilarang mengedit akun milik orang lain
        if (!$currentUser->isOwner() && $currentUser->id !== $user->id) {
            return back()->with('error', 'Anda tidak memiliki hak akses untuk mengedit akun pengguna lain.');
        }

        // 2. Validasi: is_active dibuka untuk kasir (shift sendiri) dan owner
        $rules = [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $id,
            'password'  => 'nullable|string|min:6',
            'is_active' => 'required|in:0,1',
        ];

        // 3. Validasi role HANYA jika yang mengedit adalah Owner
        if ($currentUser->isOwner()) {
            $rules['role'] = 'required|in:owner,kasir,pemilik_warung,admin';
        }

        $request->validate($rules);

        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'is_active' => (bool)$request->is_active, // Kasir & Owner dapat memperbarui status ini
        ];

        // 4. Role hanya diubah jika akun yang mengedit adalah Owner
        if ($currentUser->isOwner()) {
            $data['role'] = $request->role;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data akun dan status shift berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // 4. Kasir dilarang menghapus akun siapa pun
        if (!Auth::user()->isOwner()) {
            return back()->with('error', 'Hanya Owner yang memiliki wewenang untuk menghapus akun.');
        }

        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
