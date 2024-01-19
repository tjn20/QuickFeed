<div class="toast-container position-fixed top-0 end-0 p-3" id="toast">
    <div id="liveToast" class="toast align-items-center bg-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body d-flex align-items-center"  style="font-size: 20px;">
            <i class='bx bx-check-circle me-3' ></i><span></span>

          </div>
          <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function () {
	Livewire.on('showAlert', function (data) {
		console.log(12)
		const toast=document.getElementById('toast');
		toast.querySelector('span').textContent=data.message+' on '+data.feedId;
		var bootstrapToast = new bootstrap.Toast(toast);
		bootstrapToast.show();
	});
});
    </script> 