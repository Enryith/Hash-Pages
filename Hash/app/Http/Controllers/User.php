<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\Controller;

class User extends Controller
{
	public function view(Guard $auth,EntityManagerInterface $em, $user = null)
	{
		if($user){
			dd($user);
		}
		else if($auth->check()){
			$user = $auth->user();

			return view('user.view')->with(compact('user'));
		}
		else{
			dd('Not authenticated, no user.');
		}
	}
}
