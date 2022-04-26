<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'cpf', 'password','whatsapp',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }
}
