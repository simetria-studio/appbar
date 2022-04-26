<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comanda extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'waiter_id',
        'waiter_status',
        'table_code',
        'total_value',
        'replace',
        'payment_method',
        'installments',
        'troco',
        'status',
    ];

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_code', 'code');
    }

    public function client()
    {
        return $this->belongsTo(Cliente::class, 'client_id');
    }

    public function products()
    {
        return $this->hasMany(ComandaProduct::class);
    }
}
