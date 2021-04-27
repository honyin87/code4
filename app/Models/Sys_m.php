<?php 

namespace App\Models;

use CodeIgniter\Model;

class Sys_m extends Model
{
    protected $db;
    protected $base;

    public function __construct()
    {
        $this->base = new \App\Libraries\BaseSys();
        $this->db = $this->base->get_db();
            
    }

    public function sys_update(){

        //Tables Creation
        $this->create_tables();

        //Patches
        $this->patch();

    }

    public function create_tables(){

        

    }

    function patch(){

      
    }

    

    
}

?>