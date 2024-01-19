<div class="card feed bg-white position-relative border-0 {{ ($role=='parent')?'rounded-0':(($role=='child' || $feed->id==$feedfor)?'rounded-0 border-bottom border-secondary-subtle':'') }}" {{ $feed->id==$feedfor?"data-selected-feed=$feed->id":'' }} {{ $feed->id==$feedfor?"id=feed-$feed->id":'' }} {{ ($feed->id==$feedfor && $feed->parentFeed)?"data-has-parent=true":"data-has-parent=false" }} >

    @if ($role=='replies')
    <span class="mb-3 text-secondary-subtle position-absolute" style="font-size:13px; left:10%; top:10px;">Replying to <a href=""class="text-primary">{{ '@'.$feed->parentFeed->user->username }}</a></span>
    @endif
    <div class="card-header d-flex p-4 bg-white align-items-center justify-content-between border-0 pb-0 {{ ($role=='replies')?'mt-3':'' }}">
        <a class="card-part d-flex bg-white align-items-center position-relative z-2" href="{{ route('profile',['user'=>$feed->user]) }}" wire:navigate>
            @if ($feed->user->image)
            <img src="{{ asset('storage/'.$feed->user->image->image_path) }}" alt="profile picture" class="profile-pic">
            @else
            <img src="{{ asset('storage/noProfile.jpg') }}" alt="profile picture" class="profile-pic">
            @endif
        <div class="user-details d-flex flex-column ms-3">
                <span class="username">{{ $feed->user->first_name.' '.$feed->user->last_name }}</span>
                <span class="post-date">{{ $feed->formatDate() }}</span>
        </div>
    </a>
        <button class="remove-arrow dropdown-toggle bg-white border-0" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-horizontal-rounded open-options'></i>
        </button>
     @if ($feed->user->id==Auth::id())
     <ul class="dropdown-menu border-0 shadow p-0 bg-white">
        <li><button class="dropdown-item d-flex align-items-center text-danger border-0 bg-transparent" wire:click.debounce.1000ms="deleteFeed"><i class='bx bx-trash-alt me-1' ></i></i>Delete Post</button></li>
    </ul>
     @endif
    </div>
   @if ($role=='parent')
   <div class="d-flex align-items-stretch position-absolute z-1" style="left: 42px; top: 65px; height: calc(100% - 65px); width: 3px; background-color: rgba(207,217,222,1.00);"></div>
   @endif

   @if (($role=='parent' || $feed->id==$feedfor || $role=='replies') && $feed->parentFeed)
   <div class="d-flex align-items-stretch position-absolute z-1" style="left: 42px; top: 0; height: {{ ($role=='replies')?'37px':'23px' }}; width: 3px; background-color: rgba(207,217,222,1.00);"></div>

   @endif
    <div class="card-body {{ $role!='parent'?'px-4':'' }} bg-white" style="{{ $role=='parent'?'padding-left:4rem':'' }}">
      <a href="{{ route('feed',['feed'=>$feed,'user'=>$feed->user]) }}" wire:navigate>
        <p class="card-text feed-text">{{ $feed->content }}</p>
        
        @if ($feed->image)
        <div class="img-cont">
            <img src="{{ asset('storage/'.$feed->image->image_path) }}" alt="" class="rounded-4">
        </div>
        @endif
        <div class="card-text feed-data d-flex align-items-center justify-content-between">
            <div class="card-text feed-details mt-2"><span class="likes me-1">{{ $feed->likes?$feed->likes:'0' }}</span>Likes • <span class="comments ms-1">{{ $feed->comments?$feed->comments:'0' }} </span>Comments</div>
            <div class="card-text feed-details mt-2 d-flex align-items-center"><i class='bx bx-bar-chart'></i> <span class="views me-1">{{ $feed->views?$feed->views:'0' }}</span></div>
        </div>
      </a>
    <hr>
    <div class="d-flex align-items-center justify-content-between feed-interactions">
                <div class="d-flex align-items-center justify-content-between">
                    <button class="border-0 d-flex align-items-center justify-content-center me-2 rounded-5 bg-transparent" type="button"  data-feed-id="{{ $feed->id }}" wire:click.debounce.500ms="likeOrUnlikeFeed"  onclick="debouncedClick(this)" data-feed-isliked={{ $feed->likedBy->contains(Auth::id())?'true':'false' }}>
                        <i class="{{ $feed->likedBy->contains(Auth::id())?'fa-solid fa-heart':'fa-regular fa-heart' }}" style="color:{{ $feed->likedBy->contains(Auth::id())?'#986fe9;':'' }}"></i>
                    </button>
                    <button class="border-0 d-flex align-items-center justify-content-center rounded-5 bg-transparent comment" type="button" data-bs-toggle="modal" data-bs-target="#makeComment" data-feed-id="{{ $feed->id }}" data-feed-user="{{ $feed->user->username }}" wire:click="sendFeed" onclick="makeComment(this)">
                        <i class="fa-regular fa-comment "></i>
                    </button>
                </div>    
                <button class="border-0 d-flex align-items-center justify-content-center rounded-5 bg-transparent" type="button" onclick="copyFeed('{{ $feed->user->username }}','{{ $feed->id }}','{{ url()->to('/') }}')">
                    <i class="fa-solid fa-share"></i>
                </button>
       
    </div>
</div>
    @if ($feed->id==$feedfor)
    <livewire:make-feed placeholder="Write your reply" type="reply" :commentforfeed="$feed"/>
    @if (!$feed->comments)
    <div class="bg-white border-top" style="height: 60dvh;"></div>    
    @endif
    @endif
  </div>
