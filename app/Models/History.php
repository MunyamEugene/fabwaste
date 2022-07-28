<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable=[
        'oldNumber',
        'newNumber',
        'remainNumber',
        'item_id'
    ];
    protected $hidden = [
        'pivot'
    ];
}
