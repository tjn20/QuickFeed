<x-layouts.app-layout :title="'(@' . $user->username . ') / QuickFeed'">
<div class="container-fluid profile-page" id="profilePage">
    <div class="profile-container d-flex flex-column  rounded-4 pb-0 overflow-hidden" >
        <div class="profile-page-header border-bottom  py-3 bg-white pb-0">
          
            <livewire:profile :user="$user"/>
            <div class="d-flex align-items-center mt-3 overflow-x-scroll  sectionsCont">
                <span style="display: none;" data-username="{{ $user->username }}" id="user"></span>
                <a class="d-flex align-items-center justify-content-center text-secondary profileSections p-3 px-4 {{ (Route::currentRouteName()=='profile')?'active':'' }}" data-profile-section="feeds"  href="{{ route('profile',['user'=>$user]) }}" wire:navigate>Feeds <span></span></a>
                <a class="d-flex align-items-center justify-content-center text-secondary profileSections p-3 px-4 {{ (Route::currentRouteName()=='profile-replies')?'active':'' }}" data-profile-section="replies"  href="{{ route('profile-replies',['user'=>$user]) }}" wire:navigate>Replies<span></span></a>
                <a class="d-flex align-items-center justify-content-center text-secondary profileSections p-3 px-4 {{ (Route::currentRouteName()=='profile-media')?'active':'' }}" data-profile-section="media"  href="{{ route('profile-media',['user'=>$user]) }}" wire:navigate>Media<span></span></a>
                <div class="d-flex align-items-center justify-content-center text-secondary profileSections p-3 px-4">Community<span></span></div>
                <a class="d-flex align-items-center justify-content-center text-secondary profileSections p-3 px-4 {{ (Route::currentRouteName()=='profile-likes')?'active':'' }}" data-profile-section="likes"  href="{{ route('profile-likes',['user'=>$user]) }}" wire:navigate>Likes<span></span></a>
                <div class="d-flex align-items-center justify-content-center text-secondary profileSections p-3 px-4">Affiliates<span></span></div>
            </div>
        </div>
        @livewire('feed-container', [
                'feeds' => (Route::currentRouteName()=='profile-replies')? $user->feeds->where('parent_id','!=',null)->sortByDesc('created_at')->slice(0,2) : ((Route::currentRouteName()=='profile-media') ?$user->feeds()->has('image')->orderByDesc('created_at')->get()->slice(0,2):((Route::currentRouteName()=='profile-likes')?$user->likedFeeds->sortByDesc('created_at')->slice(0,2):$user->feeds->where('parent_id',null)->sortByDesc('created_at'))->slice(0,2)),
                'status'=>(Route::currentRouteName()=='profile-likes')? 'likes':null,
                'user'=>$user->id,
                'role'=>(Route::currentRouteName()=='profile-replies')?'replies':''
                ])

            
                <div class="d-flex justify-content-center loader mt-3 loader2">
                    <div class="spinner-border spinner-border-sm text-secondary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                              
       </div>
    </div>
</x-layouts.app-layout>

