<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'previousData',
        'changes',
        'newData',
        'store_id'
    ];

    protected $hidden = [
        'store_id'
    ];

    public function store(){
        return $this->belongsTo(Store::class);
    }
}
