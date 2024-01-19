<div class="modal fade" id="makeComment" tabindex="-1" aria-labelledby="makeComment" aria-hidden="true" wire:ignore>
    <div class="modal-dialog border-0">
      <div class="modal-content bg-white rounded-4 border-0">
        <div class="modal-header border-0">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Comment</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body d-flex flex-column">
          <span class="ms-2 form-label mb-3 fs-6">Replying to <a href="" id="feed" class="text-primary"></a></span>
          <div class="d-flex">
            <livewire:profile-picture  src="{{ asset('storage/' . (optional(Auth::user()->image)->image_path ?? 'noProfile.jpg')) }}"  classes="profile-pic"/>
            <textarea name="" class="form-control bg-transparent border-0" placeholder="Write a reply" maxlength="160" wire:model='comment'></textarea>
          </div>
          <div class="imgPreviewCont align-self-center position-relative mt-2">
            <img src="" alt="" class="card-img previewImg">
            <i class="bx bx-x position-absolute closeImg d-flex align-items-center justify-content-center shadow"></i>
        </div>
        </div>
        <div class="modal-footer border-0 d-flex justify-content-between align-items-center">
            <label  style="
            cursor: pointer;">
            <i class="fa-solid fa-image fs-5"></i>
            <input type="file" class="inputImg" wire:model='image' accept="image/*">

          </label>
          <div>
          <button type="button" class="btn main-btn btn-sm rounded-5 p-2 px-3 border-0 d-flex align-items-center submitBtn" disabled id="submit" onclick="loadingMode(this)" wire:click="makeComment">
            <span class="spinner-grow spinner-grow-sm me-1 fs-6" aria-hidden="true" ></span><span class="loading">Replying</span><span class="initial">Reply</span>
          </button>
          </div>
        </div>
      </div>
    </div>
  </div>
