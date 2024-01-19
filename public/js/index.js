
document.addEventListener('livewire:navigated',()=>{
	const menu=document.querySelector('.menu');
	
	menu.addEventListener('click',()=>{
		document.querySelector('.side-navbar').classList.toggle('hidden');
	})
	
	window.addEventListener('resize',()=>{
	if(window.innerWidth<=768)
	document.querySelector('.side-navbar').classList.add('hidden');
	
	});
	
	window.addEventListener('load',()=>{
		if(window.innerWidth<=768)
		document.querySelector('.side-navbar').classList.add('hidden');
	});


	 /*
 	MAKING THE COMMENTS LOGIC
 */
const commentTextInput=document.querySelector('#makeComment textarea');
const commentImgInput=document.querySelector('#makeComment input');
const commentSubmitButton=document.querySelector('#makeComment #submit');
const closeImgInputButton=document.querySelector('#makeComment .closeImg');
	  commentTextInput.addEventListener('input',handeInput);
      commentImgInput.addEventListener('input',handeInput);
      closeImgInputButton.addEventListener('click',closePreviewImg);

const insertFeedTextInput=document.querySelector('.insertFeed textarea');	  
const insertFeedImgInput=document.querySelector('.insertFeed #inputImg');	  	  
const insertFeedSubmitButton=document.querySelector('.insertFeed .postFeedBtn');
const insertFeedCloseImgInputButton=document.querySelector('.insertFeed .closeImg');
	  if(insertFeedTextInput && insertFeedImgInput && insertFeedSubmitButton && insertFeedCloseImgInputButton){
	  insertFeedTextInput.addEventListener('input',handeInput);
      insertFeedImgInput.addEventListener('input',handeInput);
      insertFeedCloseImgInputButton.addEventListener('click',closePreviewImg);
	  }


	  const editProfileTextInput=document.querySelector('#profileModal textarea');	  
	  const editProfileImgInput=document.querySelector('#profileModal input');	  	  
	  const editProfileSubmitButton=document.querySelector('#profileModal .submitBtn');
			if(editProfileTextInput && editProfileImgInput && editProfileSubmitButton)
			{
				editProfileTextInput.addEventListener('input',handeInput);
				editProfileImgInput.addEventListener('input',handeInput);
			}


function handeInput(event) {

	if(event.currentTarget.closest('.profile'))
	{
		editProfileSubmitButton.disabled = !(editProfileTextInput.value || editProfileImgInput.value);
	}
	if(event.currentTarget.closest('.modal')){
		commentSubmitButton.disabled = !(commentTextInput.value || commentImgInput.value);
	if(commentImgInput.value){
		showImg=document.querySelector('#makeComment .imgPreviewCont img');
		showImg.parentElement.classList.add('show');
    	showImg.src=URL.createObjectURL(commentImgInput.files[0]);
	}
	}
	else{
		insertFeedSubmitButton.disabled = !(insertFeedTextInput.value || insertFeedImgInput.value);
		if(insertFeedImgInput.value){
			showImg=document.querySelector('.insertFeed .imgPreviewCont img');
			showImg.parentElement.classList.add('show');
			showImg.src=URL.createObjectURL(insertFeedImgInput.files[0]);
		}
	}
}

	function closePreviewImg(event)
	{
		if(event.currentTarget.closest('.modal')){
		showImg.parentElement.classList.remove('show');
    	showImg.src='';
		commentImgInput.value='';
		}
		else{
		showImg.parentElement.classList.remove('show');
    	showImg.src='';
		insertFeedImgInput.value='';
		}
		handeCommentInput();
		
	}




var modal = new bootstrap.Modal('#makeComment');
var profileModal=new bootstrap.Modal('#profileModal');
const toast = bootstrap.Toast.getOrCreateInstance(document.getElementById('liveToast'))
    window.addEventListener('showAlert', (data) => {
	commentSubmitButton.disabled=true;
		commentSubmitButton.classList.remove('submitting');
		if(insertFeedSubmitButton)
		insertFeedSubmitButton.classList.remove('submitting');
		if(editProfileSubmitButton)
		{
		editProfileSubmitButton.classList.remove('submitting');
		const profileBio=document.querySelector('.profile-container .profile-bio');	
		const updateBio=document.querySelector('.profile textarea');
		if(profileBio && updateBio)
		{
			profileBio.textContent=updateBio.value;
			
		}
		}
		if(profileModal && profileModal._element.classList.contains('show'))
		profileModal.hide();
		
		else
        modal.hide();
	
		if(data.detail[0])
		document.querySelector('#toast .toast-body').innerHTML=data.detail[0].icon+data.detail[0].message;
		else
		document.querySelector('#toast .toast-body').innerHTML=data.detail.icon+data.detail.message;
		toast.show();
    });

	
});


function loadingMode(btn){
	if(btn.classList.contains("postFeedBtn")){
		btn.closest('.insertFeed').querySelector('textarea').value='';
		btn.closest('.insertFeed').querySelector('input').value='';
		showImg=btn.closest('.insertFeed').querySelector('.imgPreviewCont img');
		showImg.parentElement.classList.remove('show');
		showImg.src='';
	}
	else if(btn.classList.contains('editProfileBtn'))
	{
		btn.closest('.profile').querySelector('input').value='';
	}

	btn.classList.add('submitting');
	btn.disabled=true;
}

async function copyFeed(username,feedId,url)
{

try {
	
	await navigator.clipboard.writeText(url+'/'+username+'/feeds/'+feedId);
	const showAlertEvent = new CustomEvent('showAlert', {
		detail:{
		  message:"Feed Link Copied",
		  icon: "<i class='bx bx-check-circle me-2' style='color:#03f35a; font-size:21px; margin-top:1px;' ></i>"
		}
	  });
	  	  window.dispatchEvent(showAlertEvent);
	
} catch (err) {
	console.log(err);
}
}

function updateLikes(feed)
{
	const likes=feed.closest('.feed').querySelector('.likes');
	const likesIcon=feed.querySelector('i');
	if(feed.dataset.feedIsliked=="false"){
		likesIcon.className="fa-solid fa-heart";	
	likes.textContent++;
	feed.dataset.feedIsliked=true;
	likesIcon.style.color="#986fe9";
	}
	else{
		likesIcon.className="fa-regular fa-heart";
		likes.textContent--;
		feed.dataset.feedIsliked=false;
		likesIcon.style.color="black";
	}
}

function makeComment(feed)
{
	document.getElementById('feed').innerHTML=feed.getAttribute('data-feed-user');
	document.querySelector('#makeComment textarea').value='';
	document.querySelector('#makeComment input').value='';
	document.querySelector('#makeComment #submit').disabled=true;
	showImg=document.querySelector('#makeComment .imgPreviewCont img');
	showImg.parentElement.classList.remove('show');
	showImg.src='';
}


function debounce(func, delay) {
	let timerId;

	return function (...args) {
		clearTimeout(timerId);

		timerId = setTimeout(() => {

			func.apply(this, args);
		}, delay);
	};
}

const debouncedClick = debounce((feed) => {
	updateLikes(feed);
}, 500);





