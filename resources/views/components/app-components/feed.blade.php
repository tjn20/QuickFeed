<div class="card feed border-0">
    <div class="card-header d-flex p-4 bg-white align-items-center justify-content-between border-0 pb-0">
        <div class="card-part d-flex bg-white align-items-center">
            <img src="{{ $feed->user->image->image_path }}" alt="profile picture" class="profile-pic">
        <div class="user-details d-flex flex-column ms-3">
                <span class="username">{{ $feed->user->first_name.' '.$feed->user->last_name }}</span>
                <span class="post-date">{{ $feed->formatDate() }}</span>
        </div>
        </div>
        <button class="remove-arrow dropdown-toggle bg-white border-0" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class='bx bx-dots-horizontal-rounded open-options'></i>
        </button>
     @if ($feed->user->id==Auth::id())
     <ul class="dropdown-menu border-0 shadow p-0 ">
        <li><a class="dropdown-item d-flex align-items-center text-danger"  href="" ><i class='bx bx-trash-alt me-1' ></i></i>Delete Post</a></li>
    </ul>
     @endif
    </div>
    <div class="card-body px-4">
        <p class="card-text feed-text">{{ $feed->content }}</p>
        
    @if ($feed->image)
    <div class="img-cont">
        <img src="{{ $feed->image->image_path }}" alt="">
    </div>
    @endif
    <div class="card-text feed-details mt-2"><span class="likes me-1">{{ $feed->likes }} Likes</span> • <span class="comments ms-1">{{ $feed->comments }} Comments</span></div>
    <hr>
    <div class="d-flex align-items-center justify-content-between feed-interactions">
                <div class="d-flex align-items-center justify-content-between">
                    <button class="x border-0 d-flex align-items-center justify-content-center me-2 rounded-5 bg-transparent" type="button"  data-feed-id="{{ $feed->id }}" {{-- onclick="triggerCustomEvent()" --}}>
                        <i class="fa-regular fa-heart" id="liveToastBtn"></i>
                    </button>
                    <button class="border-0 d-flex align-items-center justify-content-center rounded-5 bg-transparent comment" type="button" data-bs-toggle="modal" data-bs-target="#makeComment" data-feed-id="{{ $feed->id }}" data-feed-user="{{ $feed->user->username }}">
                        <i class="fa-regular fa-comment "></i>
                    </button>
                </div>    
                <button class="border-0 d-flex align-items-center justify-content-center rounded-5 bg-transparent" type="button">
                    <i class="fa-solid fa-share"></i>
                </button>
           
       
    </div>
    <div class="add-comment mt-1 collapse" id="n{{ $feed->id }}">
        <form action="" class=" d-flex p-3 bg-white ">
                <img src="images/profie.png" alt="" class="profile-pic me-2 d-none d-sm-flex">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Write a comment">
                    <button class="btn main-btn shadow">Post</button>
                </div>
            </form>
    </div>
    </div>
  </div>
