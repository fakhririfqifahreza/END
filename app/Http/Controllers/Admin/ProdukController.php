<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Barang::orderBy('nama_barang', 'asc')->get();
        return view('admin.produk', compact('produk'));
    }
}
