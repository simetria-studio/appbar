<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'data',
        'horario',
        'tipo',
    ];
}
