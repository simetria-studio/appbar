<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComandaPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'comanda_id',
        'order_id',
        'payment_method',
        'url_qr',
    ];
}
