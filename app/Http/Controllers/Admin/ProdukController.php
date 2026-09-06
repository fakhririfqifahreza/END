<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        // Proteksi hanya untuk Pemilik Warung
        if (!Auth::user()->isOwner()) {
            return redirect()->route('admin.kasir')->with('error', 'Hanya Pemilik Warung yang dapat mengelola produk.');
        }

        $query = Barang::query();
        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $produks = $query->orderBy('nama_barang', 'asc')->paginate(15);
        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        if (!Auth::user()->isOwner()) {
            return redirect()->route('admin.kasir')->with('error', 'Akses ditolak.');
        }

        $satuanList = ['kg', 'gram', 'liter', 'ml', 'pcs', 'bungkus', 'butir', 'ikat', 'dus', 'karung', 'renceng', 'botol', 'kaleng'];
        return view('admin.produk.create', compact('satuanList'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isOwner()) {
            return redirect()->route('admin.kasir');
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_barang' => 'required|numeric|min:0',
            'jumlah_stok' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar_barang')) {
            $gambarPath = $request->file('gambar_barang')->store('produk', 'public');
        }

        // Gabungkan angka stok dan satuan, contoh: "50 kg" atau "100 pcs"
        $stokGabung = $request->jumlah_stok . ' ' . $request->satuan;

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'harga_barang' => $request->harga_barang,
            'stok_barang' => $stokGabung,
            'gambar_barang' => $gambarPath,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!Auth::user()->isOwner()) {
            return redirect()->route('admin.kasir');
        }

        $produk = Barang::findOrFail($id);

        // Pisahkan angka stok dan satuannya
        preg_match('/^(\d+(?:\.\d+)?)\s*(.*)$/', trim($produk->stok_barang), $m);
        $stokAngka = isset($m[1]) ? floatval($m[1]) : 0;
        $stokSatuan = isset($m[2]) && !empty($m[2]) ? trim($m[2]) : 'pcs';

        $satuanList = ['kg', 'gram', 'liter', 'ml', 'pcs', 'bungkus', 'butir', 'ikat', 'dus', 'karung', 'renceng', 'botol', 'kaleng'];

        return view('admin.produk.edit', compact('produk', 'stokAngka', 'stokSatuan', 'satuanList'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->isOwner()) {
            return redirect()->route('admin.kasir');
        }

        $produk = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'harga_barang' => 'required|numeric|min:0',
            'jumlah_stok' => 'required|numeric|min:0',
            'satuan' => 'required|string',
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $gambarPath = $produk->gambar_barang;
        if ($request->hasFile('gambar_barang')) {
            if ($produk->gambar_barang && Storage::disk('public')->exists($produk->gambar_barang)) {
                Storage::disk('public')->delete($produk->gambar_barang);
            }
            $gambarPath = $request->file('gambar_barang')->store('produk', 'public');
        }

        $stokGabung = $request->jumlah_stok . ' ' . $request->satuan;

        $produk->update([
            'nama_barang' => $request->nama_barang,
            'harga_barang' => $request->harga_barang,
            'stok_barang' => $stokGabung,
            'gambar_barang' => $gambarPath,
        ]);

        return redirect()->route('admin.produk')->with('success', 'Data produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!Auth::user()->isOwner()) {
            return redirect()->route('admin.kasir');
        }

        $produk = Barang::findOrFail($id);
        if ($produk->gambar_barang && Storage::disk('public')->exists($produk->gambar_barang)) {
            Storage::disk('public')->delete($produk->gambar_barang);
        }
        $produk->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus!');
    }
}
