<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'number',
        'email',
        'password',
        'nid_number',
        'date_of_birth',
        'profile_image',
        'nid_front_image',
        'nid_back_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    public function members()
    {
        return $this->hasMany(Member::class, 'user_id');
    }
}
