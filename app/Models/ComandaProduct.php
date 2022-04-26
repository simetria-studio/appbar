<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComandaProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'comanda_id',
        'product_id',
        'quantity',
        'total_value',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
