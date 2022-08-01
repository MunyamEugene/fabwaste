<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'counting_id',
        'description'
    ];

    protected $hidden=[
        'pivot'
    ];


    public function users(){
        return $this->belongsToMany(User::class,'category_users');
    }

    public function items(){
        return $this->hasMany(CollectedItem::class);
    }
}
