<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    public $timestamps = false;

    protected $fillable = [
    'nama_barang',
    'harga_barang',
    'stok_barang',
    'stok_awal',
    'is_tukar_wadah',
    'stok_kosong',
    'harga_wadah',
    'gambar_barang',
];
}
