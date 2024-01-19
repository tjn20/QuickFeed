<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('feeds', function ($user) {
    // Logic to determine if the user is allowed to listen to the 'tweets' channel
    return $user !== null;
});
Broadcast::channel('chat.{receiver}',function(User $user,$reciever){
return (int) $user->id===(int) $reciever;
});

