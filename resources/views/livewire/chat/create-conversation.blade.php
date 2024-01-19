<div class="modal-body d-flex flex-column">
   <form class="d-flex align-items-center bg-white w-100" style="height: 50px;" role="search">
     <i class='bx bx-search'></i><input type="text" class="form-control border-0 border-bottom bg-transparent rounded-0 w-100" placeholder="Search people" wire:model.live.debounce.500ms="search">
   </form>
   <ul class="list-group list-group-flush w-100 overflow-y-auto" style="height: 300px;">
    @foreach ($users as $user)
    <li class="list-group-item border-0 d-flex align-items-center justify-content-between users-to-message bg-white border-bottom" style="height: 80px;" wire:click="message({{ $user->id }})"  >
     <div class="inner-details d-flex align-items-center w-100">
      <img src="{{ asset('storage/' . (optional($user->image)->image_path ?? 'noProfile.jpg')) }}" alt="profile picture" class="profile-pic">
        <div class="d-flex flex-column">
           <span class="user-info ms-2 fw-bolder">{{ $user->first_name.' '.$user->last_name }}</span>
           <span class="user-info ms-2 fw-bolder text-secondary">{{ '@'.$user->username }}</span>   
        </div> 
       </div>
  </li>
    @endforeach
     
   </ul>
   </div>