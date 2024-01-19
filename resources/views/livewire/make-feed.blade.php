<div class="insertFeed bg-white  p-0 card border-0 {{ $type=='reply'?'border-top':'' }}" style="border-radius: 10px;" wire:ignore>
    <div class="bg-white" style="border-radius: 10px; border-color: white;">
        <div class="card-header d-flex p-3 bg-white ">
            <livewire:profile-picture  src="{{ asset('storage/' . (optional(Auth::user()->image)->image_path ?? 'noProfile.jpg')) }}" classes="profile-pic me-2"/>
            <textarea name="" class="form-control border-0 {{ $type=='reply'?'bg-transparent':'' }}" placeholder="{{ $placeholder }}" maxlength="160" wire:model='content' style="{{ $type == 'reply' ? '' : 'background-color:#f5f4f6; height:50px; font-size:15px !important;' }}"></textarea>
        </div>
        <div class="card-body text-primary d-flex flex-column">
            <div class="imgPreviewCont align-self-center position-relative mb-2">
                <img src="" alt="" class="card-img previewImg">
                <i class="bx bx-x position-absolute closeImg d-flex align-items-center justify-content-center shadow"></i>
            </div>
          <p class="card-text d-flex align-items-center justify-content-between card-controls"><label for="inputImg"  style="
            cursor: pointer;">
            <i class='bx bx-photo-album'></i> Photo
            <input type="file" class="inputImg" id="inputImg" accept="image/*" wire:model="feedImage">

          </label>
        <button type="submit" class="btn main-btn postFeedBtn d-flex align-items-center submitBtn border-0" disabled onclick="loadingMode(this)"  @if($type == 'reply') 
            wire:click='makeComment'
            @else 
            wire:click='makeFeed' 
            @endif>
            <span class="spinner-grow spinner-grow-sm me-1 fs-6" aria-hidden="true" ></span><span class="loading">Posting</span><span class="initial">Post</span></button>
        </p>
        
        </div>
      </div>
</div>
