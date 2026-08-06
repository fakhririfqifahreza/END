<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'total_harga',
        'metode_pembayaran',
        'items',
        'status',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get items as array
    public function getItemsArray()
    {
        return json_decode($this->items, true) ?? [];
    }
}
