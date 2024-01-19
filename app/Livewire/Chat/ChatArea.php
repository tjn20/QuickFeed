<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Events\MessageRead;
use App\Models\User;
use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
class ChatArea extends Component
{

    public $chosenConversation;
    public $sentMessage;
    public $userId;
    public $messages;
    public $paginate=10;
    public $alreadyRead=false;
    public function getListeners()
    {
        $authId=Auth::id();
        return [
            "echo-private:chat.{$authId},MessageSent"=>'broadcastedMessageReceived',
            'loadMoreMessages',
            "echo-private:chat.{$authId},MessageRead"=>'broadcastedMessageRead',
        ];
    }

    public function mount()
    {
        $this->loadMessages();

    }

    public function loadMessages()
    {
        $this->messages=Message::where('conversation_id',$this->chosenConversation->id)->skip(count($this->chosenConversation->messages) - $this->paginate)->take($this->paginate)->get();
       if(!$this->messages->isEmpty())
       {
        Message::where('conversation_id',$this->chosenConversation->id)->where('receiver_id',Auth::id())->update(['read'=>1]);
        $userId=$this->messages[0]->sender_id==Auth::id()?$this->messages[0]->receiver_id:$this->messages[0]->sender_id;
        broadcast(new MessageRead($userId,$this->chosenConversation->id,Auth::user()->receivedMessages->where('read',false)->count())); 
        $this->dispatch('refresh')->to('chat.chat-list');

       }

    }

    public function loadMoreMessages()
    {
        $this->paginate+=10;
        $this->loadMessages();
        $this->dispatch('update-chat-height');

    }
   
    public function broadcastedMessageReceived($event)
    {
        $this->dispatch('refresh')->to('chat.chat-list');

            if($this->chosenConversation)
            {
                if((int) $this->chosenConversation->id===(int)$event['conversation_id'])
                {
                    $this->dispatch('scroll-bottom');

                    $receivedMessage=Message::find($event['message']['id']);

                       $receivedMessage->read=1;
                       $receivedMessage->save();

                       $this->messages->push($receivedMessage);
                       broadcast(new MessageRead($receivedMessage->sender->id,$this->chosenConversation->id,Auth::user()->receivedMessages->where('read',false)->count())); 

                       
                }
                
                

            }
           
          
            
    }

  

    public function broadcastedMessageRead($event)
    {
        $this->dispatch('refresh')->to('chat.chat-list');

        if($this->chosenConversation){
        if((int)$this->chosenConversation->id===(int)$event['conversation_id'])
        $this->dispatch('update-messages-status');
        }
        
       

    }


public function sendMessage()
{
   
    if($this->sentMessage==null)
    return;

      $createdMessage=Message::create([
        'conversation_id'=>$this->chosenConversation->id,
        'receiver_id'=>$this->userId,
        'sender_id'=>Auth::id(),
        'content'=>$this->sentMessage
      ]);
      $this->reset('sentMessage');
      $this->chosenConversation->last_message=now();
      $this->chosenConversation->save();
      $this->dispatch('scroll-bottom');
      $this->messages->push($createdMessage);

      $this->dispatch('refresh')->to('chat.chat-list');

      broadcast(new MessageSent(Auth::user(),$createdMessage->receiver,$createdMessage,$this->chosenConversation)); 

}

   
    public function render()
    {

        return view('livewire.chat.chat-area');

    }
}
