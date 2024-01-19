<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Events\FeedPosted;

class FeedContainer extends Component
{
    public $feeds;
    public $status;
    public $user;
    public $role;
    public $page;
    public $feed;
    public $skipCount;
    public $receivedData = '';
    

    
    public function getListeners()
    {
        return [
            "echo:feeds,FeedPosted"=>'addPostedFeed',
            'removeFeed','addComment','getMoreFeeds','getChildFeeds','getParentFeeds',
            'loadMoreProfileFeeds','loadMoreProfileReplies','loadMoreProfileLikes',
            'loadMoreMediaFeeds','changeContent'
        ];
    }

    public function mount($feeds,$status=null,$user=null,$role=null,$feed=null)
    {
        $this->feeds=$feeds;
        $this->status=$status;
        $this->user=$user;
        $this->role=$role;
        $this->page=1;
        $this->feed=$feed;
        $this->skipCount=5;

    }
    

    public function removeFeed($feedId)
    {
      
        $this->feeds=$this->feeds->reject(function($feed) use ($feedId) {
            return $feed->id==$feedId;
        });
     

    }

    public function addComment($feedId)
    {
        if($this->role == 'child')
        {

        $feed=Feed::find($feedId);
            $this->feeds->prepend($feed);
            $this->feeds=$this->feeds->sortByDesc('created_at'); 
        }
    }
    // GET CHILD FEEDS
    public function getChildFeeds()
    {
        $perPage=10;

        if($this->role == 'child' && $this->page!=0){
        $feeds=Feed::where('parent_id',$this->feed->id)
        ->orderBy('created_at','desc')
        ->skip($this->page *$perPage)->take($perPage)->get();
        if($feeds->isEmpty())
        {
            $this->dispatch('stopScroll','child');
            $this->page=0;
            $this->feeds=$this->feeds->sortByDesc('created_at');
        }
        else{
        $this->page+=1;
        $this->feeds=$this->feeds->merge($feeds)->sortByDesc('created_at');
        }
    }
    }
    //GET MORE PARENT FEEDS
    public function getParentFeeds()
    {
        if($this->role == 'parent')
        {
            $ancestors = collect();
            $currentFeed = $this->feed;
            $takeCount = 5;
            $count=0;
            while ($currentFeed->parentFeed && $ancestors->count() < ($this->skipCount + $takeCount)) {
                if ($this->skipCount > $count) {
                    $count++;
                } else {
                    $ancestors->push($currentFeed->parentFeed);
                }

                $currentFeed = $currentFeed->parentFeed;
            }
            if($ancestors->isEmpty()){
                $this->dispatch('stopScroll','parent');
                $this->feeds=$this->feeds->sortBy('created_at');
            }
             else
            $this->feeds=$this->feeds->merge($ancestors)->sortBy('created_at');        

            }
    }

    // GET MORE HOME PAGE FEEDS
    public function getMoreFeeds()
    {
        $perPage=5;
        $feeds=Feed::join('users','users.id','=','feeds.user_id')
        ->join('follows','follows.following_id','=','users.id')
        ->where('follows.follower_id',Auth::id())
        ->select('feeds.*')
        ->orderBy('feeds.created_at','desc')
        ->skip($this->page *$perPage)
        ->take($perPage)
       ->get();

        if($feeds->isEmpty())
        {
            $this->dispatch('stopScroll','child');
            $this->page=0;
            $this->feeds=$this->feeds->sortBy('created_at');
        }
        else{
        $this->page+=1;
        $this->feeds=$this->feeds->merge($feeds)->sortByDesc('created_at');
        }

    }

    //GET MORE PROFILE PAGE FEEDS (HOME PAGE)
    public function loadMoreProfileFeeds()
    {
        $perPage=2;
        $feeds=Feed::where('user_id',$this->user)
        ->where('parent_id',null)
        ->orderBy('created_at','desc')
        ->skip($this->page *$perPage)->take($perPage)->get();
        if($feeds->isEmpty())
        {
            $this->dispatch('stopScroll','profile');
            $this->page=0;
            $this->feeds=$this->feeds->sortByDesc('created_at');

        }
        else{
        $this->page+=1;
        $this->feeds=$this->feeds->merge($feeds)->sortByDesc('created_at');
        }
    }
    //GET MORE PROFILE PAGE FEEDS (REPLIES PAGE)
    public function loadMoreProfileReplies()
    {
        $perPage=2;
        $feeds=Feed::where('user_id',$this->user)
        ->where('parent_id','!=',null)
        ->orderBy('created_at','desc')
        ->skip($this->page *$perPage)->take($perPage)->get();
        if($feeds->isEmpty())
        {
            $this->dispatch('stopScroll','profile');
            $this->page=0;
            $this->feeds=$this->feeds->sortByDesc('created_at');

        }
        else{
        $this->page+=1;
        $this->feeds=$this->feeds->merge($feeds)->sortByDesc('created_at');
        }
    }
    // GET MORE PROFILE PAGE LIKED FEEDS
    public function loadMoreProfileLikes()
    {
        $perPage=2;
        $feeds=Feed::join('like_feeds','feeds.id','=','like_feeds.feed_id')
        ->where('like_feeds.user_id',$this->user)
        ->select('feeds.*')
        ->orderBy('feeds.created_at','desc')
        ->skip($this->page *$perPage)->take($perPage)->get();

        if($feeds->isEmpty())
        {
            $this->dispatch('stopScroll','profile');
            $this->page=0;
            $this->feeds=$this->feeds->sortByDesc('created_at');

        }
        else{
        $this->page+=1;
        $this->feeds=$this->feeds->merge($feeds)->sortByDesc('created_at');
        }
    }
        // GET MORE PROFILE PAGE MEDIA FEEDS

    public function loadMoreMediaFeeds()
    {
        $perPage=2;
        $feeds=Feed::where('user_id',$this->user)
        ->whereHas('image', function ($query) {
            $query->where('imageable_type', 'App\Models\Feed');
        })->orderBy('feeds.created_at','desc')
        ->skip($this->page *$perPage)->take($perPage)->get();

        if($feeds->isEmpty())
        {
            $this->dispatch('stopScroll','profile');
            $this->page=0;
            $this->feeds=$this->feeds->sortByDesc('created_at');

        }
        else{
        $this->page+=1;
        $this->feeds=$this->feeds->merge($feeds)->sortByDesc('created_at');
        }
    }


    public function addPostedFeed($event)
    {
        if($this->role == 'home')
        {
            if(Auth::user()->followings->contains($event['user_id']))
            {
                $feed=Feed::find($event['feed_id']);

                $this->feeds->prepend($feed);
                $this->feeds=$this->feeds->sortByDesc('created_at');
            }
        }
    }

    public function render()
    {
        return view('livewire.feed-container');
    }
}
