<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Kolom yang bisa diisi
    protected $fillable = ['name', 'description'];

    // Relasi dengan produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
