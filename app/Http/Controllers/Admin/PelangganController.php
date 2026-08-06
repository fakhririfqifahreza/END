<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = User::where('role', 'pelanggan')->orderBy('name', 'asc')->get();
        return view('admin.pelanggan', compact('pelanggan'));
    }
}
