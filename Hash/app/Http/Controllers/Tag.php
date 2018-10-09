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
	public function __construct(EntityManagerInterface $em, Name $name){

		$tag = new Entities\Tag($name);

		$em->persist($tag);
		$em->flush();
	}
}