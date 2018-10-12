<?php


namespace App\Http\Controllers;

use App\Repositories\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory as Validation;
use App\Entities;


class Tag extends Controller
{
	/*public function __construct(EntityManagerInterface $em, Name $name){

		$tag = new Entities\Tag($name);

		$em->persist($tag);
		$em->flush();
	}*/

	public function form(){
		return view('tag.form');
	}

	/**
	 * @param Request $request
	 * @param EntityManagerInterface $em
	 * @param Validation $validator
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request, EntityManagerInterface $em, Validation $validator){

		$valid = $validator->make($request->all(), [
			'tag' => "required|max:20|unique:App\Entities\Tag,tag|alpha_num"
		]);

		$valid->validate();
		$data = $valid->getData();

		$tag = new Entities\Tag($data['tag']);
		$em->persist($tag);
		$em->flush();
		return redirect('/all');
	}
}