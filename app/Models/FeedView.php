<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedView extends Model
{
    use HasFactory;
    protected $fillable=[
        'ip_address',
        'user_agent',
        'feed_id',
        'user_id',
     ];

     
}
