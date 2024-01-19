<div class="feeds d-flex flex-column w-100 {{ ($role && $role!='replies' && $role!='home')?'p-0':'gap-4 align-items-center' }} {{ $role=='child'?'childFeeds':($role=='parent'?'parentFeeds':'') }}" >
    @foreach ($feeds as $feed)
    <livewire:feed :feed="$feed" :status="$status" :user="$user" :role="$role" :exists="$user" wire:key="feed-{{ $feed->id }}"/>
   @endforeach
    
 </div>
