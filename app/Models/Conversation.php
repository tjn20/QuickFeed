<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable=[
        'sender_id',
        'receiver_id',
        'last_message'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    public function getChatUserInstance()
    {
        
    
        if(Auth::id()==$this->sender_id)
            return User::firstWhere('id',$this->receiver_id);
        else
            return User::firstWhere('id',$this->sender_id);
        
    }
}
