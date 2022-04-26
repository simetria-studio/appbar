<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderFlow extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'key_id',
        'reason',
        'user',
        'user_id',
        'status',
    ];
}
