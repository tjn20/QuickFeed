<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LikeFeed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

class Feed extends Component
{
    public $feed;

    public $newComments;

    public $likedByUser;

    public $status;

    public $removed = false;

    public $user;

    public $feedfor;

    public $role;

    public $exists;
    protected $listeners=['updateComments'];

    public function mount($feed,$status=null,$user=null,$feedfor=null,$role=null,$exists=null)
    {
        $this->feed=$feed;
        $this->likedByUser=$feed->likedBy->contains(Auth::id());
        $this->status = $status;
        $this->user = $user;
        $this->feedfor = $feedfor;
        $this->role=$role;
        $this->exists=$exists;
    }

    public function sendFeed()
    {
        $this->dispatch('recieveFeed', $this->feed);

    }

    public function updateComments($comments)
    {
        $this->render();
    }

    public function likeOrUnlikeFeed()
    {
       if(!$this->feed->likedBy->contains(Auth::id()))
       {
      
        $this->likedByUser=true;
            LikeFeed::create([
            'user_id'=>Auth::id(),
            'feed_id'=>$this->feed->id
        ]);

            $this->feed->update([
                'likes'=>($this->feed->likes)+1
            ]);
          
            $this->dispatch('showAlert',
            ['message'=>"Post Liked",
            'icon'=>"<i class='bx bx-check-circle me-2' style='color:#03f35a; font-size:21px; margin-top:1px;' ></i>"
            ]);
       }

       else{
        $this->likedByUser=false;
        Auth::user()->likedFeeds()->detach($this->feed);
        $this->feed->update([
            'likes'=>($this->feed->likes)-1
        ]);
       }

       if($this->status=='likes' && Auth::id()==$this->user)
       {
        $this->dispatch('removeFeed',$this->feed->id);
        $this->removed = true;

       }
       $this->skipRender();
      
    }

    public function deleteFeed()
    {
        if($this->feed->image)
        unlink('storage/'.Auth::user()->image->image_path);

        $this->dispatch('removeFeed',$this->feed->id);
        $this->feed->delete();

       $this->dispatch('showAlert',
       ['message'=>"Feed Deleted",
       'icon'=>"<i class='bx bx-check-circle me-2' style='color:#03f35a; font-size:21px; margin-top:1px;' ></i>"
       ]);


    }

    public function render()
    {
       return view('livewire.feed');
    }
}
