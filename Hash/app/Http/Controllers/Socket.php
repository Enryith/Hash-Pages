<?php

namespace App\Http\Controllers;

use App\Events\Message;
use Illuminate\Routing\Controller;

class Socket extends Controller
{
	public function send($message)
	{
		event(new Message($message));
		return view('socket.send')->with(compact('message'));
	}

	public function listen()
	{
		return view('socket.listen');
	}
}
