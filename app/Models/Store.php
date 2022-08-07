<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'how_many',
        'material_id'
    ];

    protected $hidden = [
        'material_id'
    ];

    public function material(){
        return $this->belongsTo(RecyclableMaterial::class);
    }

    public function history(){
        return $this->hasMany(StoreHistory::class);
    }

}
