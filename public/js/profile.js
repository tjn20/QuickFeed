document.addEventListener('livewire:navigated',()=>{
    const profilePage=document.getElementById('profilePage');
if(profilePage)
{
    let loading=false;
    const loader=profilePage.querySelector('.loader');
   let page=document.querySelector('.profileSections.active');
    const feedsCont=document.querySelector('.feeds');
    const feeds=feedsCont.querySelectorAll('.feed');    
    const sections=profilePage.querySelectorAll('.profileSections');
    const username=profilePage.querySelector('#user');
    sections.forEach(section=>{
        section.addEventListener('click',()=>{
            sections.forEach(element=>{
                element.classList.remove('active');
            })
           section.classList.add('active');
        

        });
    });

    const lastFeedObserver= new IntersectionObserver(entries=>{
        const lastFeed=entries[0];
        if(!lastFeed.isIntersecting) return;
        showLoading();
        lastFeedObserver.unobserve(lastFeed.target)
        lastFeedObserver.observe(feedsCont.querySelector('.feed:last-child'))
         },{
            rootMargin:"150px"
        });
        if(feeds.length>0)
        lastFeedObserver.observe(feedsCont.querySelector('.feed:last-child'));   
   
        const containerObserver= new MutationObserver(entries=>{
            entries.forEach(entry=>{
                if(entry.type=='childList')
                {
                     loading=false;
                     loader.classList.remove('show');
         
                }
            })
        }); 
  if(feeds.length>0){
    lastFeedObserver.observe(feedsCont.querySelector('.feed:last-child'));          
    containerObserver.observe(feedsCont,{ childList:true });
  }


        function showLoading(){
            if (loading) { 
                return; 
            }
            loading = true;
            if(!loader.classList.contains('show'))
            loader.classList.add('show');
            setTimeout(()=>{
                loadMoreFeeds();
            },1000);
        
        
         }

   function loadMoreFeeds()
   {
    if(page.dataset.profileSection=='feeds')
        window.dispatchEvent(new CustomEvent('loadMoreProfileFeeds'));
    else if(page.dataset.profileSection=='replies')
        window.dispatchEvent(new CustomEvent('loadMoreProfileReplies'));

    else if(page.dataset.profileSection=='likes')
    window.dispatchEvent(new CustomEvent('loadMoreProfileLikes'));  
    else
    window.dispatchEvent(new CustomEvent('loadMoreMediaFeeds'));  

   }      



   window.addEventListener('stopScroll',(data)=>{
    lastFeedObserver.unobserve(feedsCont.querySelector('.feed:last-child'));
    containerObserver.disconnect();
    loading=false;
    loader.classList.remove('show');
     })

        
}
})