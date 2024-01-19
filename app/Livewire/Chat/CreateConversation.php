<?php

namespace App\Livewire\Chat;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Conversation;

class CreateConversation extends Component
{   
    public $search;

    public function message($userId)
    {

        $authUserId=Auth::id();

        $conversationExists=Conversation::where(function($query) use ($userId,$authUserId){
            $query->where('sender_id',$userId)
                    ->Where('receiver_id',$authUserId);
        })
        ->orWhere(function($query)use ($userId,$authUserId){
            $query->where('sender_id',$authUserId)
                ->Where('receiver_id',$userId);
        })->first();

        if(!$conversationExists)
        Conversation::create([
            'sender_id'=>$authUserId,
            'receiver_id'=>$userId
        ]);

         return redirect(route('user-chat',['userId'=>$userId]));



    }






    public function render()
    {
        $users=[];

        if(strlen($this->search)>=1)
        $users=User::where(function($query){
            $query->where('username', 'like', '%' . $this->search . '%')
            ->orWhere('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%');  
        })
        ->where('id','!=',Auth::id())
        ->get();
        return view('livewire.chat.create-conversation',compact('users'));
        
    }
}


