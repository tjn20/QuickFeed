<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feed extends Model
{
    use HasFactory;

    protected $connection = "mysql";

    protected $fillable=[
        'user_id','content','parent_id','likes','comments','views'
    ];


    public function image():MorphOne
    {
        return $this->morphOne(Image::class,'imageable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedBy()
    {
        return $this->belongsToMany(User::class,'like_feeds');
    }

    public function formatDate()
    {
        return $this->created_at->diffForHumans();
    }

    public function parentFeed()
    {
        return $this->belongsTo(Feed::class,'parent_id');
    }


    public function feedComments()
    {
        return $this->hasMany(Feed::class,'parent_id');
    }

    public function views()
   {
    return $this->belongsToMany(FeedView::class,'feed_views');
   }

    public function parentFeeds($count)
    {
       
        $ancestors = collect();
        $currentFeed = $this;
        while ($currentFeed->parentFeed && $ancestors->count() < $count) {
            $ancestors->push($currentFeed->parentFeed);
            $currentFeed = $currentFeed->parentFeed;
        }

        return $ancestors;
    }

 
    public function trimText($words=30)
    {
        return Str::words($this->content,$words);
    }
    

    
   
}
