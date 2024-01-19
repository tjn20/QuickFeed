<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use App\Events\FeedPosted;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class MakeFeed extends Component
{
    use WithFileUploads;
    
    public $content;

    public $feedImage;

    public $placeholder;

    public $type;

    public $commentforfeed;
    public function mount($placeholder,$type="feed",$commentforfeed=null)
    {
        $this->$placeholder=$placeholder;
        $this->type=$type;
        $this->commentforfeed=$commentforfeed;
    }

    public function makeFeed()
    {

              
        $feed=Feed::create([
            'user_id'=>Auth::id(),
            'content'=>$this->content??null
        ]);


        if($feed)
        {
        
            if($this->feedImage)
            {
                $imgName = time() . '_' . $this->feedImage->getClientOriginalName();

                $this->feedImage->storeAs('public',$imgName);
                $feed->image()->create([
                    'image_path'=>$imgName
                ]);

            }

            $message="Feed Posted";
             $icon="<i class='bx bx-check-circle me-2' style='color:#03f35a; font-size:21px; margin-top:1px;' ></i>";
             broadcast(new FeedPosted(Auth::user(),$feed))->toOthers();

        }
        else{
            $message="An Error Occured";
            $icon="<i class='bx bxs-error-circle me-2' style='color:#f30307; font-size:21px; margin-top:1px;' ></i>";

        }
        $this->dispatch('showAlert',
        ['message'=>$message,
        'icon'=>$icon
        ]);

        $this->skipRender();
        
                
    }

    public function makeComment(){
      
        $this->dispatch('makeComment',
        ['comment'=>$this->content,
         'image'=>$this->feedImage,
         'commentForFeed'=>$this->commentforfeed
        ]);
        
        
    }
    public function render()
    {
        return view('livewire.make-feed');
    }
}
