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
		
		if(!empty($id)){

			$id = unwrap_data($id);
			
			// Verify ID structure
			if(is_object($id)){
	
				$id = $id->user_id;
	
			}else{
				set_msg('Invalid ID');
				return redirect()->to(base_url('user/listing') ); 
			}

			// Get User's details
			$result = $this->user_m->get_user($id);
			
			if($result == false){
				
				return redirect()->to(base_url('user/listing') ); 
			}

			// Display No change Password instead
			$result->password = NO_CHG_PASSWORD;

			$data['enterred'] = json_decode(json_encode($result), true);
		}
		
		
		$request = service('request');

		if($request->getPost()){
			
			$result = $this->user_m->set_user($id);
			$data = $result;
			
			if($data === true){
				return redirect()->to(base_url('user/listing') ); 
			}else{

				$request = service('request');
				$data['enterred'] = $request->getPost();

			}
		}
		
		$data['roles'] = $this->user_m->get_roles();
		
		return view(module_view(get_class($this)).'form_v',$data);

	}

	
}
