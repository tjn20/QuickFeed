<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeFeed extends Model
{
    protected $fillable=[
        'user_id','feed_id'
    ];
    use HasFactory;

    
}
