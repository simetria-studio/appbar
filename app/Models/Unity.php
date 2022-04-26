<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'zip_code',
        'address',
        'number',
        'address2',
        'city',
        'state',
        'status',
    ];
}
