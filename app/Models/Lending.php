<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'borrower_role',
        'class',
        'item_id',
        'total',
        'date',
        'due_date',
        'notes',
        'user_id',
        'staff_signature',
        'borrower_signature',
        'returned_at'
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
