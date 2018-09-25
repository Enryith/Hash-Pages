<?php
namespace App\Http\Controllers;

use App\Repositories\User;
use Illuminate\Routing\Controller;

class Post extends Controller
{
	public function index(User $users)
	{
		$pag = $users->paginateUsers();

		return view('post.index')->with(compact('pag'));
	}
}
