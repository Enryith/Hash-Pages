<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class Post extends Controller
{
	public function index()
	{
		$users = DB::table('users')->paginate();

		return view('post.index')->with(['users' => $users]);
	}
}
