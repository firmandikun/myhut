<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OperationCategory;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'category_id',
        'cost',
        'date',
    ];

    protected $casts = [
        'cost' => 'integer',
        'date' => 'date',
    ];

    public function category()
    {
        return $this->belongsTo(OperationCategory::class, 'category_id');
    }
}
