<?php
// array debug
if(!function_exists("array_debug")) {
	function array_debug($data, $var_dump=false) {
		echo '<pre>';
		if($var_dump === false) {
			print_r($data);
		} else {
			var_dump($data);
		}
		echo '</pre>';
	}
}

// array debug
if(!function_exists("url_redirect")) {
	function url_redirect($url) {
		header('Location: '.base_url().'/'.$url);
		exit;
	}
}

//Set Message
if(!function_exists("set_msg")) {

	function set_msg($msg = '', $type='danger',$icon = '') {

		$session = session();
		

		if($session->has('sys_msg')){

			$data = $session->get('sys_msg');

		}else{
			$data = array();
			
		}

		$data[] = array(
			'msg'	=>	$msg,
			'type'	=>	$type,
			'icon'	=>	$icon
		);

		$session->set('sys_msg',$data);

	}
}

//Get Message
if(!function_exists("get_msg")) {

	function get_msg() {

		$session = session();
		

		if($session->has('sys_msg')){

			$data = $session->get('sys_msg');

			$session->remove('sys_msg');

			

			foreach($data as $item){



				$msg = "<div class='alert alert-".$item['type']." dismissible-alert' role='alert'>".$item['msg']."<i class='alert-close mdi mdi-close'></i></div>";

				  
				echo $msg;
			}

			

		}

		
	}
}


// Validate Login
if(!function_exists("validate_login")) {
	function validate_login() {

		$session = session();
		
		if(!$session->has('user')){

			url_redirect('auth');
		}
		
		return;
	}
}

// entered
if(!function_exists("entered")) {
	function entered($data = array() ,$field = '',$default = '') {

		if(isset($data)){
			
			$entered = $data;
			
			if(isset($entered[$field])){
				return $entered[$field];
			}
		}

		return $default;
	}
}

// Input Error
if(!function_exists("input_error")) {
	function input_error($data = array() ,$field = '') {

		if(isset($data)){
			
			$errors = $data;
			
			if(isset($errors[$field])){
				
				return '<label id="'.$field.'-error" class="error" for="'.$field.'">'.$errors[$field].'</label>';
			}
		}

		return ;
	}
}


if(!function_exists("module_view")) {
	function module_view($class = '') {
		
		if(!empty($class)){
			$tmp = explode('\\',$class);
			$class_name = strtolower(end($tmp));
			$path = ['..','..','modules'];
			$path[] = $class_name;
			$path[] = 'views';
			$path[] = '';
			return implode("\\", $path);
		}
		
	}
}

if(!function_exists("user_info")) {
	function user_info() {
		
		$session = session();

        return $session->get('user');
		
	}
}

/**
 * Require Module 
 */
if(!function_exists("is_module_exist")) {
	function is_module_exist($module = '',	$version = '') {
		
		if(is_dir(ROOTPATH . 'modules')){
	
			$modules = array_filter(glob(ROOTPATH . 'modules' . DIRECTORY_SEPARATOR .'*'), 'is_dir');
			
			foreach($modules as $path){
				$segment = explode("\\",$path);
				$last_segment = end($segment);
				
				if($last_segment == $module){
					
					return true;
				}
			}

			throw new Exception("Module `".$module."` does not exist.");
		
		}
		
	}
}



if(!function_exists("get_config_value")) {
	function get_config_value($code = '') {
		
		if(is_module_exist('Config')){

			$config_m = new \Modules\Config\Models\Config_m;
			
			return $config_m->get_config_value($code);

		}
		
	}
}

if(!function_exists("get_config_value_item")) {
	function get_config_value_item($code = '') {
		
		if(is_module_exist('Config')){

			$config_m = new \Modules\Config\Models\Config_m;
			
			return $config_m->get_config_value_item($code);

		}
		
	}
}

?>