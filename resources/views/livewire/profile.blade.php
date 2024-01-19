<div>
    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
        @if ($user->image)
        @if ($user->id==Auth::id())
        <livewire:profile-picture  src="{{ asset('storage/'.Auth::user()->image->image_path) }}"  classes="profile-pic"/>
        @else
        <img src="{{ asset('storage/'.$user->image->image_path) }}" alt="profile picture" class="profile-pic">
        @endif
        @else
        <img src="{{ asset('storage/noProfile.jpg') }}" alt="profile picture" class="profile-pic">

        @endif
<div class="profile-controls d-flex align-items-center justify-content-between">
    <button class="me-2 rounded-5 border-0 bg-white"><i class="bx bx-dots-horizontal-rounded d-flex align-items-center justify-content-center rounded-5 p-2 profileBtns"></i></button>
    @if (Auth::id()!=$user->id)
    <a href="{{ route('user-chat',['userId'=>$user->id]) }}"><i class="bx bx-envelope d-flex align-items-center justify-content-center rounded-5 p-2 profileBtns me-2"></i></a> 
    <button class="btn border rounded-5 {{ $isFollowing?'':'main-btn' }}" wire:click.debounce.500ms="followUnfollow({{ $user->id }})">{{ $isFollowing?'Following':'Follow' }}</button>
    @else
    <button class="btn main-btn rounded-5 profileSettingsBtn" type="button" data-bs-toggle="modal" data-bs-target="#profileModal">Edit Profile</button>
    @endif
</div>
</div>
<div class="d-flex align-items-start flex-column ps-4 mb-4 position-relative">
<h5 class="user-name fw-bold">{{ $user->first_name.' '.$user->last_name }}</h5>
<h6 class="text-secondary fw-lighter position-absolute username">{{'@'.$user->username}}</h6>
</div>
<p class="ps-4 fw-lighter profile-bio">
{{ $user->bio }}
</p>
<p class="d-flex align-items-center text-secondary fw-lighter ps-4" style="font-size: 14px;"><i class='bx bx-calendar me-1'></i>Joined {{ $user->FormatDate() }}</p>
<div class="d-flex align-items-center ps-4 text-secondary" style="font-size: 14px;">
<span class="me-3"><b class="text-black me-1">{{ $following }}</b> Following</span><span><b class="text-black me-1">{{ $followers }}</b> Followers</span>
</div>
</div>