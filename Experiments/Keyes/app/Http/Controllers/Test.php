<?php

namespace App\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Factory;
use App\Entities;



class Test extends Controller
{
	protected $em;

	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	public function test(Request $request)
	{

		$data = $request->all();
		var_dump($data);

		$test = new Entities\Test();
		$test->setVar1($data['name']);
		$test->setVar2($data['age']);

		$this->em->persist($test);
		$this->em->flush();

		return view('test/test');
	}
}