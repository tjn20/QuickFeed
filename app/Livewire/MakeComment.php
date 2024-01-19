<?php

namespace App\Livewire;

use App\Models\Feed;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class MakeComment extends Component
{
    use WithFileUploads;
    
    public $comment;

    public $image;

    protected $listeners = ['recieveFeed','makeComment'];

    public $commentForFeed;
    public function recieveFeed($feed)
    {
        $this->commentForFeed=$feed; 
        $this->skipRender();
    }

    public function makeComment($data=null)
    {   
        
        if($data)
        if($data['commentForFeed'])
        {
            $this->image=$data['image'];
            $this->comment=$data['comment'];
            $this->commentForFeed=$data['commentForFeed'];
        }
    
        $Newcomments=($this->commentForFeed['comments'])+1;
       
        $feed=Feed::create([
            'user_id'=>Auth::id(),
            'parent_id'=>$this->commentForFeed['id'],
            'content'=>$this->comment??null
        ]);

        if($feed)
        {
            Feed::where('id',$this->commentForFeed['id'])
            ->update([
                'comments'=>$Newcomments
            ]);
            if($this->image)
            {
                $imgName = time() . '_' . $this->image->getClientOriginalName();

                $this->image->storeAs('public',$imgName);
                $feed->image()->create([
                    'image_path'=>$imgName
                ]);
            }


             $message="Comment Posted";
             $icon="<i class='bx bx-check-circle me-2' style='color:#03f35a; font-size:21px; margin-top:1px;' ></i>";

             $this->dispatch('updateComments',$Newcomments);
             if($data)
             $this->dispatch('addComment',
                $feed->id);

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
  
 
    public function render()
    {
        return view('livewire.make-comment');
    }
}
