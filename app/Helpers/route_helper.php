<?php
/**
 * Route Helper
 */

if(!function_exists('generate_routes')){

    function generate_routes($name = '',$controller = '',$options = []){  

        
        $routes = \Config\Services::routes();


        $routes->group($name, $options, function($routes) use ($controller)
        {
            $methods = ['get', 'post', 'put', 'delete', 'patch'];
            // Controller index
            $routes->match($methods,'/', $controller.'::index');

            $request = \Config\Services::request();
            $total_segments = $request->uri->getTotalSegments();

            if($total_segments > 1){

                $from = $request->uri->getSegment(2);
                $to = $controller.'::'.$request->uri->getSegment(2);
    
                // Function only
                $routes->match($methods,$from, $to);
    
                // Function with arguments
                for($i = 3 ; $i <= $total_segments ; $i++){
                    $from .= "/(:any)";
                    $to .= "/$".($i - 2);
                    
                    $routes->match($methods,$from, $to);
                }
            }
           
           
        });
        
    }
}



?>