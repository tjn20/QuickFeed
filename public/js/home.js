document.addEventListener('livewire:navigated',()=>{

    const homePage=document.getElementById('homePage');
    if(homePage){
     let loading=false;
     const csrfToken=document.querySelector('meta[name="csrf-token"]').content;
     const loader=homePage.querySelector('.loader');
     const homePageFeedsCont=homePage.querySelector('.feeds');
     const feeds=homePage.querySelectorAll('.feed');
    const lastFeedObserver= new IntersectionObserver(entries=>{
    const lastFeed=entries[0];
    if(!lastFeed.isIntersecting) return;
    showLoading();
    lastFeedObserver.unobserve(lastFeed.target)
    lastFeedObserver.observe(homePageFeedsCont.querySelector('.feed:last-child'))
    
     },{
        rootMargin:"150px"
    });
    

    
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
        lastFeedObserver.observe(homePageFeedsCont.querySelector('.feed:last-child'));
        containerObserver.observe(homePageFeedsCont,{ childList:true });
    
        }
             
    function showLoading(){
        if (loading) { 
            return; 
        }
        loading = true;
        loader.classList.add('show');
        setTimeout(()=>{
            loadMoreFeeds();
        },1000);
    
    
     }
    
     function loadMoreFeeds()
     {
    
        window.dispatchEvent(new CustomEvent('getMoreFeeds'));
    
     }
    
     window.addEventListener('stopScroll',()=>{
        lastFeedObserver.unobserve(homePageFeedsCont.querySelector('.feed:last-child'));
        containerObserver.disconnect();
        loading=false;
        loader.classList.remove('show');
     })
    
    }
});