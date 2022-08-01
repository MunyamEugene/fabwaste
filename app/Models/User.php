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
        'fname',
        'lname',
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
        'manufactureEmail',
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_users');
    }

    public function items()
    {
        return $this->hasMany(CollectedItem::class);
    }

    public function collectors(){
        return $this->belongsToMany(User::class,'collect_manufact', 'manu_id','coll_id');
    }
    public function manufactures(){
        return $this->belongsToMany(User::class, 'collect_manufact', 'coll_id', 'manu_id');
    }
    
    public function sendPasswordResetNotification($token){
        $url='https://frontendUrl?token'.$token;
        $this->notify(new ResetPasswordNotification($url));
    }

}
