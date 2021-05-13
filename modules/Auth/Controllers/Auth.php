<?php

namespace Modules\Auth\Controllers;
use App\Controllers\BaseController;

class Auth extends BaseController
{
	protected $auth_m;

	public function init()
	{
		// Init Models
		$this->auth_m = model('Modules\Auth\Models\Auth_m');
	}

	public function index()
	{
		
		return redirect()->to(base_url('auth/login') ); 
	}

	public function login(){
		
		//return redirect()->to(base_url('auth/test') ); 
		$request = service('request');
		
		if($request->getMethod() == 'post'){
			
			$errors = $this->auth_m->validate_login();

			// /array_debug($errors);exit;

			if(!empty($errors)){
				// set error sessions

				return redirect()->to(base_url('auth/login') ); 
			}
			$session = session();
			
			//array_debug($session->get('user'));exit;
			return redirect()->to(base_url() ); 
		}
		
		
		return view(module_view(get_class($this)).'login_v');
	}

	function logout(){

		$session = session();

		if($session->has('user')){

			$session->destroy();

			
		}
		url_redirect('auth');
	}

	public function test(){
		array_debug(get_auto_id('tbl_users'));
	}
	
}
