<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'bio',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function image():MorphOne
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class);
    }

    public function likedFeeds()
    {
        return $this->belongsToMany(Feed::class,'like_feeds');
    }

   public function userFollowers()
   {
    return $this->belongsToMany(User::class,'follows','following_id','follower_id');
   }

   public function followings()
   {
    return $this->belongsToMany(User::class,'follows','follower_id','following_id');

   }

   public function conversations()
   {
       return $this->hasMany(Conversation::class,'sender_id')->orWhere('receiver_id',$this->id);
   }
   public function sentMessages()
   {
       return $this->hasMany(Message::class, 'sender_id');
   }

   public function receivedMessages()
   {
       return $this->hasMany(Message::class, 'receiver_id');
   }

   public function viewedFeeds()
   {
    return $this->belongsToMany(Feed::class,'feed_views');
   }

    public function FormatDate()
    {
        return $this->created_at->format('F Y');
    }

    public function formatNumber($number) {
        if ($number < 1000) 
            return $number;
         elseif ($number < 1000000) 
            return round($number / 1000, 1) . 'K';
         elseif ($number < 1000000000) 
            return round($number / 1000000, 1) . 'M';
         else 
            return round($number / 1000000000, 1) . 'B';
        
    }

  
    public function trimText($chars=10,$required=null)
    {
        
        if($required)
        return Str::limit($this->username,$chars);
        else
        return Str::limit($this->first_name.' '.$this->last_name,$chars);


    }
    
}
