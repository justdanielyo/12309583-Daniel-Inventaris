<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'category_id', 
        'total', 
        'repair', 
        'lending'
    ];

    // TAMBAHKAN KODE INI
    public function lendings()
    {
        // Satu Item bisa memiliki banyak data peminjaman (Lending)
        return $this->hasMany(Lending::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}