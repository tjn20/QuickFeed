<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Follows;
use App\Models\FeedView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\CustomProfileNotFoundException;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $feeds=Feed::join('users','users.id','=','feeds.user_id')
            ->join('follows','follows.following_id','=','users.id')
            ->where('follows.follower_id',Auth::id())
            ->select('feeds.*')
            ->orderBy('feeds.created_at','desc')
            ->take(5)
           ->get();
    
            return view('home',[
                'feeds'=>$feeds
            ]);
       
            
    }
 

  
  
    /**
     * Display the specified resource.
     */
    public function show(User $user,Feed $feed,Request $request)
    {
        $authUser=Auth::user();
        $authUser->load('viewedFeeds');
        if(!$authUser->viewedFeeds->contains($feed->id))
        {
            FeedView::create([
                'ip_address'=>$request->ip(),
                'user_agent'=>$request->userAgent(),
                'feed_id'=>$feed->id,
                'user_id'=>$authUser->id
            ]);

            $feed->views++;
            $feed->save();
        }
        
        return view('feed',compact('user','feed'));
    }

   
    public function showProfile(User $user)
    {
       
        return view('profile',[
            'user'=>$user
        ]);
    }


}
