<div class="position-sticky bottom-0 z-3 bg-white border-top w-100">
    @if ($chosenConversation)
    <div class="d-flex align-items-center p-2">
        <input type="text" placeholder="Type a message.." class="p-2 border-0 rounded-3 me-2" wire:model="message" >
        <button type="submit" class="main-btn rounded-5 border-0 d-flex align-items-center justify-content-center p-3" wire:click="sendMessage"><i class='bx bxs-send'></i></button>
    </div>
    @endif
</div>
