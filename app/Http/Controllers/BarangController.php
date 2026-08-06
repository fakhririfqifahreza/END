<?php

namespace App\Http\Controllers;


use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Tampilkan semua data barang
    public function index()
    {
        $barang = Barang::all();
        return view('barang.index', compact('barang'));
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok_barang' => 'required|string',
            'harga_barang' => 'required|numeric',
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload gambar kalau ada
        $namaFile = null;
        if ($request->hasFile('gambar_barang')) {
            $file = $request->file('gambar_barang');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/gambar', $namaFile);
        }

        \App\Models\Barang::create([
            'nama_barang' => $request->nama_barang,
            'stok_barang' => $request->stok_barang,
            'harga_barang' => $request->harga_barang,
            'gambar_barang' => $namaFile,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }



    public function search(Request $request)
    {
        $query = $request->input('query');

        // Jika ada kata yang diketik
        if (!empty($query)) {
            $barang = \App\Models\Barang::where('nama_barang', 'LIKE', "%{$query}%")
                ->orderBy('id_barang', 'desc')
                ->get();
        } else {
            // Kalau input kosong, tampilkan semua
            $barang = \App\Models\Barang::orderBy('id_barang', 'desc')->get();
        }

        return response()->json($barang);
    }

    // Update stok barang
    public function updateStok(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok_barang' => 'required',
            'harga_barang' => 'required|numeric',
            'gambar_barang' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $barang = Barang::findOrFail($id);
        
        // Cek apa yang berubah
        $namaBerubah = $barang->nama_barang != $request->nama_barang;
        $stokBerubah = $barang->stok_barang != $request->stok_barang;
        $hargaBerubah = $barang->harga_barang != $request->harga_barang;
        $gambarBerubah = false;
        
        // Handle upload gambar baru
        if ($request->hasFile('gambar_barang')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar_barang) {
                $filePathLama = storage_path('app/public/gambar/' . $barang->gambar_barang);
                if (file_exists($filePathLama)) {
                    unlink($filePathLama);
                }
            }
            
            // Upload gambar baru
            $file = $request->file('gambar_barang');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/gambar', $namaFile);
            $barang->gambar_barang = $namaFile;
            $gambarBerubah = true;
        }
        
        // Update data
        $barang->nama_barang = $request->nama_barang;
        $barang->stok_barang = $request->stok_barang;
        $barang->harga_barang = $request->harga_barang;
        $barang->save();
        
        // Tentukan pesan notifikasi berdasarkan perubahan
        $perubahanArr = [];
        if ($namaBerubah) $perubahanArr[] = 'nama';
        if ($stokBerubah) $perubahanArr[] = 'stok';
        if ($hargaBerubah) $perubahanArr[] = 'harga';
        if ($gambarBerubah) $perubahanArr[] = 'gambar';
        
        if (count($perubahanArr) > 0) {
            $message = ucfirst(implode(', ', $perubahanArr)) . ' produk berhasil disimpan!';
        } else {
            $message = 'Data produk berhasil disimpan!';
        }

        return redirect()->back()->with('success', $message);
    }

    // Hapus barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($barang->gambar_barang) {
            $filePath = storage_path('app/public/gambar/' . $barang->gambar_barang);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $barang->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}
