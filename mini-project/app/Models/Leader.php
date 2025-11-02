<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Leader extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function units()
    {
        return $this->hasMany(Unit::class, 'leader_id');
    }
}
