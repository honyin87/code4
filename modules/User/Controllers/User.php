<?php

namespace Modules\User\Controllers;
use App\Controllers\BaseController;

class User extends BaseController
{
	protected $user_m;

	public function index()
	{
		
	}

	public function init()
	{
		validate_login();

		// Init Models
		$this->user_m = model('Modules\User\Models\User_m');

		
	}

	function listing($page = 1, $is_search = false){


		$data = $this->user_m->get_user_list($page,$is_search);

		$data['roles'] = $this->user_m->get_roles();
		
		return view(module_view(get_class($this)).'list_v',$data);
	}

	function search($page = 1){

		return $this->listing($page,true);

	}

	function form($id = ''){

		$data = [];

		$id = unwrap_data($id);
		
		// Verify ID structure
		if(is_object($id)){

			$id = $id->user_id;

		}else{
			set_msg('Invalid ID');
			return redirect()->to(base_url('user/listing') ); 
		}

		
		$request = service('request');

		if(!empty($request->getPost())){
			
			$result = $this->user_m->set_user($id);
			$data = $result;
		}

		$data['roles'] = $this->user_m->get_roles();
		
		return view(module_view(get_class($this)).'form_v',$data);

	}

	
}
