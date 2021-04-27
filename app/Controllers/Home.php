<?php

namespace App\Controllers;

class Home extends BaseController
{
	function init(){
		validate_login();
	}
	public function index()
	{
		return redirect()->to(base_url('home/dashboard') );
	}

	public function dashboard(){

		return view('dashboard_v');
	}
}
