<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable=[
        'sender_id',
        'receiver_id',
        'conversation_id',
        'read',
        'type',
        'content'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function trimText($chars=15)
    {
        return Str::limit($this->content,$chars);
    }
}
