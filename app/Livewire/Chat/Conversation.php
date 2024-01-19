<?php

namespace App\Livewire\Chat;

use Livewire\Component;

class Conversation extends Component
{
    public $conversation;
    public $user;
    public function mount($conversation,$user)
    {
        $this->user=$user;
        $this->conversation=$conversation;
    }

    public function selectUserToChat($conversation,$user)
    {
        $this->dispatch('selectUserToChat',$conversation,$user);
        $this->skipRender();
    }
    public function render()
    {
        return view('livewire.chat.conversation');
    }
}
