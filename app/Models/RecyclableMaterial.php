<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecyclableMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id'
    ];

    protected $hidden = [
        'pivot',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function users(){
        return $this->belongsToMany(User::class, 'user_materials');
    }
    
    public function itemNumber(){
        return $this->hasOne(Store::class);
    }
}
