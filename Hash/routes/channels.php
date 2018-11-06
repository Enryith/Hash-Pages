<?php

use App\Entities\Chat;
use Doctrine\ORM\EntityManagerInterface;
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

Broadcast::channel('chat.{id}', function (App\Entities\User $user, $id) {
	/** @var EntityManagerInterface $em */
	$em = $this->app['em'];

	/** @var Chat $chat */
	$chat = $em->find(Chat::class, $id);
	return $chat && $chat->getUsers()->contains($user);
});
