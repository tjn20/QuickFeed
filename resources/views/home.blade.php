<x-layouts.app-layout title="Home / QuickFeed">
    <div class="home-page container-fluid d-flex flex-column align-items-center gap-4" id="homePage">
        
      <livewire:make-feed placeholder="Write A Feed" />
    
      @if (!$feeds->isEmpty())
      <livewire:feed-container :feeds="$feeds" role="home"/>
      @else
      <div class="card no-feeds border-0 d-flex align-items-center justify-content-center flex-column p-4 bg-white">
        <div class="card-title fw-bold" style="font-size: 20px;">Welcome to QuickFeed!</div>
        <div class="card-text px-5 text-secondary">
            Unlock fresh perspectives! Follow profiles for a personalized feed filled with inspiration and diverse content.
        </div>
    </div> 
      @endif
<div class="d-flex justify-content-center loader">
    <div class="spinner-border spinner-border-sm text-secondary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
</div>
</x-layouts.app-layout>
       