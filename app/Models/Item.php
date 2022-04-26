<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'pedido_id',
        'produto_id',
        'title',
        'unit_price',
        'quantity',
        'user_id',
    ];

    

    public function produto()
    {
        return $this->belongsTo(Product::class, 'produto_id');
    }
}
