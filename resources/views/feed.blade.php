<x-layouts.app-layout :title="$feed->user->first_name . ' ' . $feed->user->last_name . ' on QuickFeed: \'' . $feed->trimtext() . '\''">
    <div class="feed-page d-flex flex-column" id="feedPage">
        <div class="d-flex align-items-center  p-2 fs-5 justify-content-start text-black previous border-bottom position-sticky z-3" style="top:-20px; max-width:600px; backdrop-filter:blur(15px); background: rgba(255, 255, 255, 0.7);">
            <a href="{{ url()->previous() }}" wire:navigate class="me-2">
             <i class='bx bx-left-arrow-alt d-flex align-items-center justify-content-center rounded-5 p-2'></i>
            </a>
             Feed
         </div>
            <livewire:feed-container :feeds="$feed->parentFeeds(5)->sortBy('created_at')" role='parent' :feed="$feed" wire:key="parents-container">
            <livewire:feed :feed="$feed" :feedfor="$feed->id"/>
            <livewire:feed-container :feeds="$feed->feedComments->sortByDesc('created_at')->slice(0,10)" role='child' :feed="$feed"  wire:key="children-container">
                <div class="d-flex justify-content-center loader childLoader mt-4">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
    
    <script>
        document.addEventListener('livewire:navigated',()=>{
        	const selectedFeedId = document.querySelector('[data-selected-feed]');

	    if(selectedFeedId.dataset.selectedFeed)
	    {
		var feedElement = document.getElementById('feed-' + selectedFeedId.dataset.selectedFeed);
        if (feedElement && selectedFeedId.dataset.hasParent=="true") 
        document.querySelector('.feed-page').scrollTo({
            top: (feedElement.offsetTop)-120
        });

       
	    }
        
        });

    </script>
        </div>
</x-layouts.app-layout>

