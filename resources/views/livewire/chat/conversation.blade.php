<li class="list-group-item border-0 d-flex align-items-center justify-content-between users-to-message bg-white border-bottom" style="height: 80px;" wire:click="selectUserToChat({{ $conversation }},{{ $user }})" wire:key="{{ $conversation->id }}">
    <div class="inner-details d-flex align-items-center w-100">
     <img src="images/profie.png" alt="" class="profile-pic d-none d-sm-flex">
     <div class="user-details d-flex flex-column ms-1 position-relative w-100">
         <div class="message-title d-flex align-items-center justify-content-between">
            <span class="user-info">{{ $user->username }}</span>
            <span class="time">{{ $conversation->messages->last()?->created_at->shortAbsoluteDiffForHumans() }}</span>
         </div>
         <div class="message-info ms-1 d-flex align-items-center justify-content-between  w-100">
            <span class="message">{{ $conversation->messages->last()->content }}</span>
            @if ($conversation->messages->last()->sender_id==Auth::id())
            <i class='bx bx-check{{ $conversation->messages->last()->read?'-double read':''  }}' ></i>
            @endif
         </div>
         @if (count($conversation->messages->where('read',0)->where('receiver_id',Auth::id())))
         <span class="bg-danger text-white  border-0 position-absolute rounded-5  d-flex align-items-center justify-content-center unreadMessages">
            {{ $conversation->messages->where('read',0)->where('receiver_id',Auth::id())->count() }}
        </span>
         @endif
     </div>
    </div>
 </li>