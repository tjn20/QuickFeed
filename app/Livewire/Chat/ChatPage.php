<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatPage extends Component
{
    public function getListeners()
    {
        $authId=Auth::id();
        return [
            "echo-private:chat.{$authId},MessageSent"=>'broadcastedMessageReceived',
            
        ];
    }


    public function broadcastedMessageReceived($event)
    {
        $this->dispatch('refresh')->to('chat.chat-list');

    }


    

    public function render()
    {
        return view('livewire.chat.chat-page')->layout('components.layouts.app-layout',[
            'title'=>'Messages / QuickFeed'
        ]);
    }
}
