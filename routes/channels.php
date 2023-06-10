<?php

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('chats', function ($user) {
    return $user;
});

Broadcast::channel('group', function ($user) {
    return auth()->check();
});

Broadcast::channel('newguest.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('newReturnTeam.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('newMessage.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('newPosition.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
