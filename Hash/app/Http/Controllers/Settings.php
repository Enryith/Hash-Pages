<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class Settings extends Controller
{
	public function index()
	{
		$user = Auth::user();

		return view('settings.index')->with(['user' => $user]);
	}
}