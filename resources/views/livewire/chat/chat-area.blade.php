<div class="d-flex flex-column w-100 h-100"
x-data="{height:0,chatAreaElement:document.getElementById('chatArea')}"
x-init="
        height=chatAreaElement.scrollHeight;
        $nextTick(()=>chatAreaElement.scrollTop=height);"

       @scroll-bottom.window="
       $nextTick(()=>chatAreaElement.scrollTop=chatAreaElement.scrollHeight);"
>
    <div class="w-100 h-100 bg-white d-flex flex-column chatAreaPage">
        <div class="header border-bottom p-3 pt-4 d-flex align-items-center w-100 position-sticky top-0 z-2 bg-white" >
            <a href="{{ route('chat') }}" wire:navigate><i class='bx bx-left-arrow-alt me-3 fs-2  d-flex align-items-center justify-content-center rounded-5 backBtn p-1' ></i></a>
            @php
            $receiver= $chosenConversation->getChatUserInstance();
            @endphp
                        <img src="{{ asset('storage/' . (optional($receiver->image)->image_path ?? 'noProfile.jpg')) }}" alt="profile picture" class="profile-pic me-2"><h5 class="pt-1">{{ $receiver->username }}</h5>

    
        </div>
        <div class="d-flex flex-column px-3 pt-3 messages-area h-100 overflow-y-scroll chatArea" id="chatArea"
        @scroll="
        scrollTop=$el.scrollTop;

        if(scrollTop <= 0)
        window.dispatchEvent(new CustomEvent('loadMoreMessages'));"

        @update-chat-height.window="
        let newHeight = $el.scrollHeight;

        if (newHeight > height) {
            $el.scrollTop = newHeight - height;
            height = newHeight;
        }
        "
        @update-messages-status.window="
        messages = document.querySelectorAll('.bx-check');

        messages.forEach(message => {
            message.classList.remove('bx-check-double');
        });
        "
        >

        @if(!$messages->isEmpty())
            @foreach ($messages as $message)
            <div class="message d-flex flex-column {{ $message->sender_id==Auth::id()?'sender':'receiver' }}" wire:key="{{ $message->id }}">
                <div class="message-body mb-0">
                 {{ $message->content }}
                </div>
                <div class="details d-flex align-items-center justify-content-center"><span class="date">{{ $message->created_at->format('g:i a') }}</span><span class="read-status d-flex align-items-center">
                    @if ( $message->sender_id==Auth::id())
                    <i class='bx bx-check{{ $message->read?'-double read':''  }}' ></i>
                    @endif
         
                </span></div>
             </div>    
             
            @endforeach

        </div>
        @else
        <div class="d-flex pt-5 justify-content-center fs-4 align-self-center align-items-center flex-column h-100 w-100">
        Start a new one.
        </div>
       @endif
    </div>
    <div class="position-sticky bottom-0 z-3 bg-white border-top w-100">
                <div class="d-flex align-items-center p-2" x-data="{sentMessage:''}">
                    <input type="text" placeholder="Type a message.." class="p-2 border-0 rounded-3 me-2" wire:model="sentMessage" x-model="sentMessage" maxlength="100">
                    <button type="submit" class="main-btn rounded-5 border-0 d-flex align-items-center justify-content-center p-3" wire:click="sendMessage" @click="sentMessage=''"><i class='bx bxs-send'></i></button>
                </div>
    </div>
</div>