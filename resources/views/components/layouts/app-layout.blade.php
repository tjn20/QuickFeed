<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="storage/Eo_circle_deep-purple_letter-q.svg.png">
    <title>{{ $title }}</title>

    @livewireStyles

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script>
    window.user={{ Auth::id() }}
</script>
</head>
<body>
   <!-- SideBar-->
   <div class="side-navbar bg-white">
    <a href="" class="navbar-brand app-logo fw-bold d-flex align-items-center pt-1 ps-3 position-sticky top-0 z-3 bg-white"
    ><img src="{{ asset('storage//Eo_circle_deep-purple_letter-q.svg.png') }}" alt="app logo"><span>QuickFeed</span>
    </a>
    <div class="profile-cont d-md-flex align-items-center  mx-4 mt-4 rounded-4 p-3 d-none ps-4">
        <livewire:profile-picture  src="{{ asset('storage/' . (optional(Auth::user()->image)->image_path ?? 'noProfile.jpg')) }}"  classes="profile-pic me-2"/>
        <div class="profile-info d-flex align-items-center justify-content-center flex-column">
            <span class="profile-info-name">{{ Auth::user()->trimText(15)}}</span>
            <span class="profile-info-user">{{ '@'.Auth::user()->trimText(10,'username')}}</span>
        </div>
    </div>
    <ul class="side-menu">
        <li class="{{ Route::currentRouteName()=='home'?'active':'' }}">
            <a href="{{ route('home') }}" wire:navigate class="w-100 h-100 bg-white d-flex align-items-center">
                <i class='bx bxs-dashboard d-flex justify-content-center'></i>
                <span class="title">Feed</span>
            </a>
        </li>
        <li class="{{ (Route::currentRouteName()=='profile' || Route::currentRouteName()=='profile-replies' || Route::currentRouteName()=='profile-likes' || Route::currentRouteName()=='profile-media')?'active':'' }}">
            <a  href="{{ route('profile',['user'=>Auth::user()]) }}" wire:navigate class="w-100 h-100 bg-white d-flex align-items-center">
                <i class='bx bx-user d-flex justify-content-center'></i>
                <span class="title">Profile</span>
            </a>
        </li>
        <li class="{{ Route::currentRouteName()=='chat' || Route::currentRouteName()=='user-chat' ?'active':'' }}">
            <a  href="{{ route('chat') }}" wire:navigate  class="w-100 h-100 bg-white d-flex align-items-center">
                <i class='bx bx-envelope d-flex justify-content-center'></i>
                <span class="title">Messages</span>
            </a>
        </li>
        <li>
            <a  href="#"  class="w-100 h-100 bg-white d-flex align-items-center">
                <i class='bx bx-bookmarks d-flex justify-content-center'></i>
                <span class="title">Bookmarks</span>
            </a>
        </li>
        <li>
            <a  href="#"  class="w-100 h-100 bg-white d-flex align-items-center">
                <i class='bx bx-group d-flex justify-content-center '></i>
                <span class="title">Communities</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a  href="{{ route('logout') }}"  class="w-100 h-100 bg-white d-flex align-items-center text-danger" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class='bx bx-log-out d-flex justify-content-center'></i>
                <span class="title">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
   </div>
  <div class="content position-relative {{ Route::currentRouteName()=='chat' || Route::currentRouteName()=='user-chat'?'hide':'' }}">
    <nav class="navbar navbar-expand-md bg-white top-navbar position-fixed z-3">
        <div class="container-fluid">
            <button class="menu fs-2 main-btn rounded-3 border-0 shadow"><i class='bx bx-menu d-flex align-items-center justify-content-center'></i></button>
                <div class="search-container d-md-block d-none  w-50">
                    <i class='bx bx-search' ></i>
                    <input type="text" class="form-control w-100 rounded-4 p-2 ps-3" id="searchFeed" placeholder="search anything">
                </div>
          <div class="justify-content-end ps-5">
            <ul class="navbar-nav align-items-center justify-content-between w-100 d-flex flex-row">
                <li class="nav-item dropdown me-3 d-md-flex d-none">
                    <button class="nav-link dropdown-toggle bg-white" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <livewire:profile-picture  src="{{ asset('storage/' . (optional(Auth::user()->image)->image_path ?? 'noProfile.jpg')) }}"  classes="profile-pic"/>
                    </button>
                    <ul class="dropdown-menu border-0 shadow p-0 ">
                        <li><a class="dropdown-item d-flex align-items-center justify-content-center border-bottom"  href="{{ route('profile',['user'=>Auth::user()]) }}" wire:navigate ><i class='bx bx-user me-1'></i>{{ Auth::user()->trimText(10)}}</a></li>
                      <li><a class="dropdown-item d-flex align-items-center" href="#"><i class='bx bx-cog me-1'></i>Settings</a></li>
                      <li><a class="dropdown-item d-flex align-items-center text-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class='bx bx-log-out-circle me-2 mt-1'></i>Logout</a></li>
                    </ul>
                  </li>
              <li class="nav-item me-3 item-noti">
                <span class="notification  d-flex align-items-center justify-content-center" id="messagesNotifications" style="padding: 8px;">{{ 
                    count(Auth::user()->receivedMessages->where('read',false))}}</span>
                <i class='bx bx-message-square nav-link'></i>
              </li>
              <li class="nav-item me-3 item-noti">
                <span class="notification">0</span>
                <i class='bx bx-bell nav-link'></i>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    <div class="page-content d-flex {{ Route::currentRouteName()=='chat' || Route::currentRouteName()=='user-chat'?'pe-0':'' }}">
        <div class="app-pages {{ Route::currentRouteName()=='chat' || Route::currentRouteName()=='user-chat'?'w-100 pe-0':'' }}">

            @if ($slot??null)
            {{ $slot }}
            @endif
        </div>
        
        @if ($slot??null)
        <x-app-components.side-page role="{{ (Route::currentRouteName()=='chat' || Route::currentRouteName()=='user-chat')?'chat':'' }}"/>
            
        @endif

    </div>
  </div> 

  <div class="right-navbar bg-white {{ Route::currentRouteName()=='chat' || Route::currentRouteName()=='user-chat'?'d-none':'' }}" >
    <div class="card overflow-hidden bg-white mb-4 border-0 w-100 mt-4">
        <div class="card-header fw-bolder bg-white d-flex align-items-center justify-content-between">
            Messages <a href="{{ route('chat') }}" class="showMoreBtn" wire:navigate>See All</a>
          </div>
        @livewire('chat.chat-list',[
            'numofItemsToFetch'=>3
        ])
    </div>

    <div class="card overflow-hidden bg-white mb-4 border-0 w-100 d-flex flex-column">
        <div class="card-header fw-bolder bg-white d-flex align-items-center justify-content-between">
            Groups <a class="showMoreBtn">See All</a>
          </div>
        <div class="d-flex align-items-center justify-content-center mt-4">Coming Soon</div>
    </div>

  
   </div>
   <div class="modal fade bg-dark" id="loader" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog border-0 d-flex align-items-center justify-content-center h-100">
       <span class="pageLoader"></span>
    </div>     
  </div>
<livewire:edit-profile/>
<livewire:make-comment/>
<livewire:toast/>

@livewireScripts
  <script src="https://kit.fontawesome.com/b730aa2724.js" crossorigin="anonymous" module></script>
    <script src="{{ asset('js/index.js') }}" data-navigate-once></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('js/feed.js') }}"></script>
    <script src="{{ asset('js/profile.js') }}"></script>

</body>
</html>