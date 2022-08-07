<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'phone',
        'location',
        'email',
        'password',
        'province',
        'district',
        'city',
        'streetNumber',
        'pobox',
        'iscollector',
        'isapproved',
        'isadmin',
        'ismanufacture',
        'manufactureName',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'pivot',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function materials(){
        return $this->belongsToMany(RecyclableMaterial::class, 'user_materials');
    }
    
    public function sendPasswordResetNotification($token){
        $url='https://frontendUrl?token'.$token;
        $this->notify(new ResetPasswordNotification($url));
    }

}
