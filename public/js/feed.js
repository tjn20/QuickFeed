document.addEventListener('livewire:navigated',()=>{
    const feedPage=document.getElementById('feedPage');
    if(feedPage){
     let loading=false;
     const csrfToken=document.querySelector('meta[name="csrf-token"]').content;
     const childLoader=feedPage.querySelector('.childLoader');
     const childFeedsCont=feedPage.querySelector('.childFeeds');
     const childFeeds=childFeedsCont.querySelectorAll('.feed');
    
     let parentsloading=false;
     const parentLoader=feedPage.querySelector('.parentLoader');
     const parentFeedsCont=feedPage.querySelector('.parentFeeds');
     const parentFeeds=parentFeedsCont.querySelectorAll('.feed');
    const lastChildFeedObserver= new IntersectionObserver(entries=>{
    entries.forEach(entry=>{
        if(!entry.isIntersecting) return;
    
        if(entry.target.closest('.childFeeds')){
            showLoading();
    lastChildFeedObserver.unobserve(entry.target)
    lastChildFeedObserver.observe(childFeedsCont.querySelector('.feed:last-child'))
        }
        else{
            showParentsLoading();
            lastChildFeedObserver.unobserve(entry.target)
            lastChildFeedObserver.observe(parentFeedsCont.querySelector('.feed:first-child'))
        }
    })
    
     },{
        rootMargin:"70px"
    });
    if(childFeeds.length>0)
    lastChildFeedObserver.observe(childFeedsCont.querySelector('.feed:last-child'));
    
    if(parentFeeds.length>0)
    lastChildFeedObserver.observe(parentFeedsCont.querySelector('.feed:first-child'));
    
    
    
     const containerObserver= new MutationObserver(entries=>{
        entries.forEach(entry=>{
            if(entry.type=='childList')
            {
                 loading=false;
                 childLoader.classList.remove('show');
     
            }
        })
    }); 
    if(childFeeds.length>0)
     containerObserver.observe(childFeedsCont,{ childList:true });
     
    function showLoading(){
        if (loading) { 
            return; 
        }
        loading = true;
        childLoader.classList.add('show');
        setTimeout(()=>{
            loadMoreChildFeeds();
        },1000);
    
    
     }
    
     function loadMoreChildFeeds()
     {
    
        window.dispatchEvent(new CustomEvent('getChildFeeds'));
    
     }
    
    
    
    
     function showParentsLoading(){
        if (parentsloading) { 
            return; 
        }
        parentsloading = true;
        setTimeout(()=>{
            loadMoreParentFeeds();
        },1000);
    
    
     }
    
    
     function loadMoreParentFeeds()
     {
    
        window.dispatchEvent(new CustomEvent('getParentFeeds'));
    
     }
    
    
    
    
     window.addEventListener('stopScroll',(data)=>{
    if(data.detail[0]=='child'){    
    lastChildFeedObserver.unobserve(childFeedsCont.querySelector('.feed:last-child'));
    containerObserver.disconnect();
    loading=false;
    childLoader.classList.remove('show');
    }
    else{
        lastChildFeedObserver.unobserve(parentFeedsCont.querySelector('.feed:first-child'));
        parentsloading=false;
    }
     })
    
    }
});