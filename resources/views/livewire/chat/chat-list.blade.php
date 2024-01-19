<ul class="list-group list-group-flush w-100 chatlist-group d-flex flex-column">
@if (!$conversations->isEmpty())
@foreach ($conversations as $conversation)
@php
      $user= $conversation->getChatUserInstance();
   @endphp
<li class=" border-0 {{ $user->id==$userId?'bg-secondary-subtle':'bg-white'  }} border-bottom" style="height: 80px;" >
    <a wire:navigate  href="{{ route('user-chat',['userId'=>$user->id]) }}" class="bg-transparent users-to-message border-0 d-flex align-items-center justify-content-between list-group-item h-100">
      <div class="inner-details d-flex align-items-center w-100">
         @if ($user->image)
         <img src="{{ asset('storage/'.$user->image->image_path) }}" alt="profile picture" class="profile-pic d-none d-sm-flex">
         @else
         <img src="{{ asset('storage/noProfile.jpg') }}" alt="profile picture" class="profile-pic d-none d-sm-flex">
         @endif
         <div class="user-details d-flex flex-column ms-1 position-relative w-100">
             <div class="message-title d-flex align-items-center justify-content-between">
                <span class="user-info">{{ $numofItemsToFetch?$user->trimText(15):$user->trimText(25)}}</span>
               
                <span class="time">{{ !$conversation->messages->isEmpty()?$conversation->messages->last()->created_at->shortAbsoluteDiffForHumans():'' }}</span>
               </div>
                  
             <div class="message-info ms-1 d-flex align-items-center justify-content-between  w-100">
                <span class="message">{{optional($conversation->messages->last())->trimText()}}</span>
                @if (optional($conversation->messages->last())->sender_id==Auth::id())
                <i class='bx bx-check{{ $conversation->messages->last()->read?'-double read':''  }}' ></i>
                @endif
             </div>
             @if (count($conversation->messages->where('read',0)->where('receiver_id',Auth::id())))
             <span class="bg-danger text-white  border-0 position-absolute rounded-5  d-flex align-items-center justify-content-center unreadMessages {{ $numofItemsToFetch?'changePosition':'' }}">
                {{ $conversation->messages->where('read',0)->where('receiver_id',Auth::id())->count() }}
            </span>
             @endif
         </div>
        </div>
    </a>
 </li>

@endforeach
 @else
 <p class="align-self-center mt-2">You have No Converstions</p>
@endif

</ul>
