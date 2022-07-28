<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectedItem extends Model
{
    use HasFactory;
    protected $fillable=[
        'collected_items_name',
        'quantity',
        'category_id',
        'user_id'
    ];
    
    protected $hidden = [
        'pivot'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function history(){
        return $this->hasMany(History::class);
    }

}
