<div class="d-flex message-page">
    
    <div class="chat-list-container d-flex align-items-center flex-column bg-white border-end">
        <div class="header border-bottom p-3  pt-4 d-flex justify-content-between align-items-center w-100 position-sticky top-0 z-3 bg-white">
            <h4>Messages</h4><button type="button" data-bs-toggle="modal" data-bs-target="#createConversation" class="border-0 rounded-5 d-flex align-items-center justify-content-center"><i class="far fa-envelope message fs-5"></i></button>
        </div>
        @livewire('chat.chat-list')
    </div>
    <div class="chat-area-container bg-white d-none d-md-flex flex-column">

        <div class="d-flex pt-5 justify-content-center fs-4 align-self-center align-items-center flex-column h-100 w-100">
            Choose from your existing conversations or start a new one.
            <button type="button" class="main-btn p-2 rounded-5 border-0 fs-6 px-4" data-bs-toggle="modal" data-bs-target="#createConversation">Message</button>
            </div>
        
    </div>

    @livewire('chat.create-conversation-container')
</div>
