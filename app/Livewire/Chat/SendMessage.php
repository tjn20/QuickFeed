<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class SendMessage extends Component
{

    
    protected $listeners=['updateSendMessage','resetChatArea'];


    public Conversation $chosenConversation;
    public $receiver;
    public $message;
    
public function resetChatArea()
{
    $this->chosenConversation=null;
    $this->receiver=null;

}

public function updateSendMessage(Conversation $conversation,User $user)
{
   
        $this->chosenConversation=$conversation;
        $this->receiver=$user;
}

public function sendMessage()
{
    if($this->message==null)
    return null;
      $createdMessage=Message::create([
        'conversation_id'=>$this->chosenConversation->id,
        'receiver_id'=>$this->receiver->id,
        'sender_id'=>Auth::id(),
        'content'=>$this->message
      ]);  
      
      
      $this->chosenConversation->last_message=now();
      $this->chosenConversation->save();

      $this->dispatch('addMessage',$createdMessage->id)->to('Chat.ChatArea');
      $this->dispatch('refresh')->to('chat.chat-list');

      $this->reset('message');

      broadcast(new MessageSent(Auth::user(),$this->receiver,$createdMessage,$this->chosenConversation));
}

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
