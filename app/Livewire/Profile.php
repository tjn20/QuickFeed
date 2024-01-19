<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
  
    public $user;
    
    public $isFollowing;

    public $followers;

    public $following;

    public function mount($user)
    {
        $this->user=$user;
        $this->isFollowing=Auth::user()->followings->contains($user->id);
        $this->followers=$user->formatNumber($user->followers);
        $this->following=$user->formatNumber($user->following);
    }

    public function followUnfollow($userId)
    {
        $authUser=Auth::user();
        if(!$authUser->followings->contains($userId))
        {
            $authUser->followings()->attach($userId);
            $this->user->followers+=1;
            $this->user->save();
            $authUser->following+=1;
            $authUser->save();
            $this->followers=$this->user->formatNumber($this->user->followers);
            $this->isFollowing=true;

            $this->dispatch('showAlert',
        ['message'=>"User Followed",
        'icon'=>"<i class='bx bx-check-circle me-2' style='color:#03f35a; font-size:21px; margin-top:1px;' ></i>"
        ]);
        }
        else{
        $authUser->followings()->detach($userId);
            $this->user->followers-=1;
            $this->user->save();
            $authUser->following-=1;
            $authUser->save();
            $this->followers=$this->user->formatNumber($this->user->followers);
            $this->isFollowing=false;  

        }

    }
    public function render()
    {
        return view('livewire.profile');
    }
}
