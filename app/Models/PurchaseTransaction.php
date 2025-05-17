<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseTransaction extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'price_per_unit',
        'total_price',
        'purchase_date',
        'notes'
    ];

    // ✅ Tambahkan ini
    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
