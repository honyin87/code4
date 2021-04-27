<?php 

namespace App\Controllers;

class Sys extends BaseController
{
	protected $sys_m;

	public function init()
	{
		// Init Models
		$this->sys_m = model('App\Models\Sys_m');
	}

	public function index()
	{
		
		//echo TEST_PREFIX;
	}

	function update(){
		
        //$this->sys_m->sys_update();

		// Loop thru available Sys_m in all modules
		if(is_dir(ROOTPATH . 'modules')){
	
			$modules = array_filter(glob(ROOTPATH . 'modules' . DIRECTORY_SEPARATOR .'*'), 'is_dir');
			
			foreach($modules as $path){
				$segment = explode(DIRECTORY_SEPARATOR,$path);
				$module_name = end($segment);
				
				$sys_class =  MODULE_NAMESPACE."\\".$module_name."\\Models\\Sys_m" ;

				if(class_exists($sys_class)){
					$sys_m = new $sys_class();
					
					$sys_m->sys_update();
				}
				
				
			}
		
		}

		echo "Done.";
    }
}
