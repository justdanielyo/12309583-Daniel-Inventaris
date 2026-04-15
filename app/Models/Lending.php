<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',        // Nama peminjam
        'item_id',     // ID Barang
        'user_id',     // ID Staff yang menginput
        'total',       // Jumlah pinjam
        'notes',       // Catatan
        'date',        // Tanggal pinjam
        'returned_at'  // Tanggal kembali
    ];

    // Relasi ke Item (Barang yang dipinjam)
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke User (Staff yang mencatat)
    // INI YANG TADI HILANG / BELUM ADA
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}