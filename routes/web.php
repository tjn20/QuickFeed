<?php

use App\Http\Controllers\FallBackController;
use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\Chat\ChatPage;
use App\Livewire\Chat\CreateConversation;
use App\Livewire\Chat\QueryChat;
use App\Livewire\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Auth::routes();




//LIVEWIRE ROUTES
    Route::get('/chat', ChatPage::class)->middleware('auth')
    ->name('chat');
    
    
    Route::get('/chat/{userId}', QueryChat::class)->middleware('auth')
    ->whereNumber('userId')
    ->name('user-chat');



//Feed Routes
Route::middleware('auth')->prefix('/')->group(function(){
    Route::get('/',[FeedController::class,'index'])->name('home');
    Route::get('{user:username}',[FeedController::class,'showProfile'])->name('profile');
    Route::get('{user:username}/replies',[FeedController::class,'showProfile'])->name('profile-replies');
    Route::get('{user:username}/media',[FeedController::class,'showProfile'])->name('profile-media');
    Route::get('{user:username}/likes',[FeedController::class,'showProfile'])->name('profile-likes');
    Route::get('{user:username}/feeds/{feed:id}',[FeedController::class,'show'])->name('feed');
});

Route::fallback(FallBackController::class);