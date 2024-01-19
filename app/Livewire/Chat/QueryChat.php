<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QueryChat extends Component
{
    public $userId;
    public $chosenConversation;

    public function mount()
    {

        $authUserId=Auth::id();
       if( $authUserId==$this->userId)
       return redirect(route('home'));

        $this->chosenConversation=Conversation::where(function($query) use ($authUserId){
            $query->where('sender_id',$this->userId)
                    ->Where('receiver_id',$authUserId);
        })
        ->orWhere(function($query)use ($authUserId){
            $query->where('sender_id',$authUserId)
                ->Where('receiver_id',$this->userId);
        })->first();
        
        if(!$this->chosenConversation)
        return redirect(route('chat'));
    }
    public function render()
    {
        $user=User::find($this->userId);

        return view('livewire.chat.query-chat')->layout('components.layouts.app-layout',[
            'title'=>$user->username.'/ QuickFeed',
        ]);
    }
}
