<?php

namespace Modules\Test\Controllers;
use App\Controllers\BaseController;

class Test extends BaseController
{
	public function index()
	{
		//return view('welcome_message');
		echo "From Test Index";
	}

	public function print(){
		echo "Hahaha..From Test Print";
	}

	
}
