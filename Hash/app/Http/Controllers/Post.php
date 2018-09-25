<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Database\Connection;

class Post extends Controller
{
	public function index(Connection $db)
	{
		$users = $db->table('users');

		$pag = $users->paginate();

		return view('post.index')->with(compact('users', 'pag'));
	}
}
