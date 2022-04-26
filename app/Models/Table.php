<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'unity_id',
        'code',
        'name',
        'status',
    ];

    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }
}
