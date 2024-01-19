<div class="d-flex message-page">
    
    <div class="chat-list-container d-none d-lg-flex align-items-center flex-column bg-white border-end">
        <div class="header border-bottom p-3  pt-4 d-flex justify-content-between align-items-center w-100 position-sticky top-0 z-3 bg-white">
            <h4>Messages</h4><button type="button" data-bs-toggle="modal" data-bs-target="#createConversation" class="border-0 rounded-5 d-flex align-items-center justify-content-center"><i class="far fa-envelope message fs-5"></i></button>
        </div>
        @livewire('chat.chat-list',[
            'chosenConversation'=>$chosenConversation,
            'userId'=>$userId
        ])
    </div>
    <div class="chat-area-container bg-white">
        @livewire('chat.chat-area',[
            'chosenConversation'=>$chosenConversation,
            'userId'=>$userId
        ])
        
    </div>

    @livewire('chat.create-conversation-container')
</div>
