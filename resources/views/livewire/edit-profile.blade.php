<div class="modal fade profile" id="profileModal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" wire:ignore>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 align-self-start" id="profileModalLabel">Edit Your Profile</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
                                <form action="" class="d-flex flex-column">
                                    <div class="position-relative d-flex align-items-center justify-content-center">
                                       <livewire:profile-picture  src="{{ asset('storage/' . (optional(Auth::user()->image)->image_path ?? 'noProfile.jpg')) }}"  classes="profile-pic-lg"/>
                                        <label for="inputPImg" class="position-absolute bg-black rounded-5 d-flex align-items-center justify-content-center p-2 text-white" style="
                                    cursor: pointer;">
                                    <i class='bx bxs-camera-plus'></i>
                                    <input type="file" id="inputPImg" class="inputImg" accept=".png, .svg,.jpeg, .jpg" wire:model='profileImg'>
        
                                  </label>

                                    </div>
                                    <div class="d-flex flex-column mt-2 position-relative">
                                        <label class="form-label">Bio</label>
                                        <textarea name="" cols="20" class="form-control p-3 h-auto overflow-y-scroll border-secondary" id="bio" maxlength="160" wire:model="bio"></textarea>
                                        {{-- <span class="position-absolute text-secondary small" style="top: 35px; right: 5px; font-size: 12px;"><span class="counter" >0</span> / 160</span> --}}
                                    </div>
                                </form>
                                <div class="tryout"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn main-btn rounded-5 border-0 submitBtn editProfileBtn d-flex align-items-center" disabled onclick="loadingMode(this)" wire:click="saveChanges"><span class="spinner-grow spinner-grow-sm me-1 fs-6" aria-hidden="true" ></span><span class="loading">Saving</span><span class="initial">Save Changes</span></button>
        </button>
        </div>
      </div>
    </div>
</div>