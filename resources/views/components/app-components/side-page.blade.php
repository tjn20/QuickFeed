<div class="side-page {{ $role?($role=='chat'?'d-none':''):'' }}">
    @if(!Auth::user()->bio || !Auth::user()->image)
    <div class="alert alert-light alert-dismissible fade show border-0 rounded-4" role="alert" style="max-width: 350px;">
     <h4 class="alert-heading">Set up Your Profile!</h4>
     <p>Unlock a personalized experience! Set up your profile today to tailor content, connect with like-minded individuals, and make the most of your online journey. Your profile, your world!</p>
     <button type="button" class="btn main-btn">Take me there</button>
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   @endif
     <div class="card overflow-hidden bg-white mb-4 rounded-4 border-0" style="max-width: 350px;">
         <div class="card-header fw-bolder bg-white">
             Who to follow
           </div>
         <ul class="list-group list-group-flush mt-3">
          @foreach ($users as $user)
          <li class="list-group-item border-0 d-flex align-items-center justify-content-between users-to-follow bg-white">
             <a class="inner-details d-flex align-items-center w-100" wire:navigate href="{{ route('profile',['user'=>$user]) }}">
             @if ($user->image)
             <img src="{{ asset('storage/'.$user->image->image_path) }}" alt="profile picture" class="profile-pic">
             @else
             <img src="{{ asset('storage/noProfile.jpg') }}" alt="profile picture" class="profile-pic">

             @endif
              <div class="user-details d-flex flex-column ms-3 position-relative">
                  <span class="user-info">{{ $user->trimText(10) }}</span>
                  <span class="username position-absolute">{{ '@'.$user->trimText(7,'username')}}</span>
              </div>
          </a>
              <button class="btn btn-sm rounded-5">Follow</button>
          </li>
          @endforeach
         </ul>
       </div>
       <div class="card border-0 overflow-hidden bg-white mb-4 rounded-4" style="max-width: 350px;">
         <div class="card-header fw-bolder bg-white">
             Subscribe to Communities
           </div>
           <div class="card-body">
             <p class="card-text" style="font-size: 15px;">Join, engage, and stay updated – subscribe to communities for a vibrant and connected experience!</p>
             <button class="btn main-btn rounded-5 btn-sm shadow">Subscribe</button>
           </div>
       </div>
 </div>