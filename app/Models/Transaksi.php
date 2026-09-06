<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $guarded = [];

    /**
     * Relasi ke TransaksiDetail
     */
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id');
    }

    /**
     * Relasi ke User / Pelanggan
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Helper untuk mengambil daftar item barang dalam bentuk Array
     */
    public function getItemsArray()
    {
        // 1. Cek dari tabel transaksi_detail
        if ($this->transaksiDetail && $this->transaksiDetail->count() > 0) {
            return $this->transaksiDetail->map(function ($detail) {
                return [
                    'id'          => $detail->barang_id,
                    'nama_barang' => $detail->nama_barang ?? ($detail->barang->nama_barang ?? 'Produk'),
                    'nama_produk' => $detail->nama_barang ?? ($detail->barang->nama_barang ?? 'Produk'),
                    'harga'       => $detail->harga ?? 0,
                    'qty'         => $detail->qty ?? 1,
                    'jumlah'      => $detail->qty ?? 1,
                    'subtotal'    => $detail->subtotal ?? (($detail->harga ?? 0) * ($detail->qty ?? 1)),
                ];
            })->toArray();
        }

        // 2. Fallback jika ada data lama yang tersimpan dalam format JSON di kolom 'items'
        if (!empty($this->items)) {
            if (is_string($this->items)) {
                $decoded = json_decode($this->items, true);
                return is_array($decoded) ? $decoded : [];
            }
            if (is_array($this->items)) {
                return $this->items;
            }
        }

        return [];
    }

    /**
     * Helper untuk menghitung total kuantitas item
     */
    public function getTotalItemsCount()
    {
        $items = $this->getItemsArray();
        $total = 0;
        foreach ($items as $item) {
            $total += floatval($item['qty'] ?? ($item['jumlah'] ?? 1));
        }
        return $total;
    }
}
