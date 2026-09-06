<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }

        $produks = $query->orderBy('nama_barang', 'asc')->paginate(10);

        return view('admin.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'    => 'required|string|max:255',
            'harga_barang'   => 'required|numeric|min:0',
            'jumlah_stok'    => 'required|numeric|min:0',
            'satuan'         => 'required|string|max:50',
            'gambar_barang'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_tukar_wadah' => 'nullable|boolean',
            'harga_wadah'    => 'nullable|numeric|min:0',
            'stok_kosong'    => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['nama_barang', 'harga_barang']);

        // Gabungkan angka stok dan satuan (misal: "15 tabung (3kg)")
        $stokLengkap = $request->jumlah_stok . ' ' . $request->satuan;
        $data['stok_barang'] = $stokLengkap;
        $data['stok_awal']   = $stokLengkap;

        // Logika produk tukar wadah (gas / galon)
        $isWadah = $request->has('is_tukar_wadah') ? 1 : 0;
        $data['is_tukar_wadah'] = $isWadah;
        $data['harga_wadah']    = $isWadah ? ($request->harga_wadah ?? 0) : 0;
        $data['stok_kosong']    = $isWadah ? ($request->stok_kosong ?? 0) : 0;

        if ($request->hasFile('gambar_barang')) {
            $data['gambar_barang'] = $request->file('gambar_barang')->store('produk', 'public');
        }

        Barang::create($data);

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);

        // Ekstrak angka stok dan satuannya agar terisi otomatis di form edit
        preg_match('/^(\d+(?:\.\d+)?)\s*(.*)$/', trim($barang->stok_barang), $matches);
        $jumlahStok = isset($matches[1]) ? $matches[1] : $barang->stok_barang;
        $satuan = isset($matches[2]) ? trim($matches[2]) : '';

        return view('admin.produk.edit', compact('barang', 'jumlahStok', 'satuan'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang'    => 'required|string|max:255',
            'harga_barang'   => 'required|numeric|min:0',
            'jumlah_stok'    => 'required|numeric|min:0',
            'satuan'         => 'required|string|max:50',
            'gambar_barang'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_tukar_wadah' => 'nullable|boolean',
            'harga_wadah'    => 'nullable|numeric|min:0',
            'stok_kosong'    => 'nullable|integer|min:0',
        ]);

        $data = $request->only(['nama_barang', 'harga_barang']);

        $stokLengkap = $request->jumlah_stok . ' ' . $request->satuan;
        $data['stok_barang'] = $stokLengkap;

        // Update stok_awal jika stok bertambah saat restock
        if ($stokLengkap !== $barang->stok_barang) {
            $data['stok_awal'] = $stokLengkap;
        }

        $isWadah = $request->has('is_tukar_wadah') ? 1 : 0;
        $data['is_tukar_wadah'] = $isWadah;
        $data['harga_wadah']    = $isWadah ? ($request->harga_wadah ?? 0) : 0;
        $data['stok_kosong']    = $isWadah ? ($request->stok_kosong ?? 0) : 0;

        if ($request->hasFile('gambar_barang')) {
            if ($barang->gambar_barang && Storage::disk('public')->exists($barang->gambar_barang)) {
                Storage::disk('public')->delete($barang->gambar_barang);
            }
            $data['gambar_barang'] = $request->file('gambar_barang')->store('produk', 'public');
        }

        $barang->update($data);

        return redirect()->route('admin.produk')->with('success', 'Data produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->gambar_barang && Storage::disk('public')->exists($barang->gambar_barang)) {
            Storage::disk('public')->delete($barang->gambar_barang);
        }

        $barang->delete();

        return redirect()->route('admin.produk')->with('success', 'Produk berhasil dihapus.');
    }
}
