<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatList extends Component
{
    public $chosenConversation;
    public $userId;
    protected $listeners=['refresh'=>'$refresh'];
    public $numofItemsToFetch;

    public function mount($numofItemsToFetch=null)
    {
        $this->numofItemsToFetch=$numofItemsToFetch;
    }



    public function render()
    {
        return view('livewire.chat.chat-list',[
            'conversations'=>$this->numofItemsToFetch?Auth::user()->conversations()->latest('last_message')->take($this->numofItemsToFetch)->get():Auth::user()->conversations()->latest('last_message')->get()
        ]);
    }
}
