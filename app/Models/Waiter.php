<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Waiter extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'user',
        'password',
        'unity_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function unity()
    {
        return $this->belongsTo(Unity::class, 'unity_id');
    }
}
