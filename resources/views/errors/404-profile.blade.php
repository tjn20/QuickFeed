<x-layouts.app-layout title="Profile / QuickFeed">
    <div class="container-fluid profile-page">
        <div class="profile-container d-flex flex-column  rounded-4 pb-0 overflow-hidden" >
            <div class="profile-page-header   py-3 bg-white pb-0">
                <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                     <div class="profile-pic" style="background-color: #f7f9f9;"></div> 
    
                </div>
                <div class="d-flex align-items-start flex-column ps-4 mb-4 position-relative">
                     <h6 class="text-black fs-5 fw-bolder notFound-username">{{ '@'.$username }}</h6>
    
                </div>
               
            </div>
            <div class="bg-white" style="height: 100dvh;">
                <p class="ps-4 fw-bolder mt-4 fs-2 justify-content-center d-flex flex-column align-items-center">
                    This account doesn't exist
                    <span class="fw-lighter fs-6">Try searching for another.</span>
                </p> 
            </div>
        </div>
    </div>
</x-layouts.app-layout>


