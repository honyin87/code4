<?php 

namespace Modules\Auth\Models;

use CodeIgniter\Model;


class Auth_m extends Model
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
            
    }


    public function validate_login(){

        $request = service('request');

        $errors = [];
        if(empty($request->getPost('username'))){
            $errors['username'] = 'Username is required';
        }

        if(empty($request->getPost('password'))){
            $errors['password'] = 'Password is required';
        }

        

        $username = trim($request->getPost('username'));
        $password = $request->getPost('password');

        $sql = "SELECT a.`id`,a.`email`,a.`username`,a.`firstname`,a.`lastname`,a.`contact_no`,a.`verified` ,b.`role_id`
                FROM `".DB_PREFIX."users` a
                LEFT JOIN `".DB_PREFIX."user_role` b ON b.`user_id` = a.`id`
                WHERE a.`username` = ".$this->db->escape($username)." AND a.`password` = md5(".$this->db->escape($password).");";

        $query = $this->db->query($sql);
       
        // Username or Password not match
        if($query->getNumRows() == 0){
            set_msg('Incorrect Username or Password.');
            $errors[] = 'Incorrect Username or Password.';
        }

        if(!empty($errors)){
            return $errors;
        }

        // User Credential Verified
        // Save user info into current session
        $user_info = $query->getRow();

        $session = session();

        $session->set('user', $user_info);

        // Get User's roles
        $roles = $this->get_roles($user_info->id);

        $session->set('roles', $roles);

        return [];

    }

    public function get_roles($user_id = ''){
        $sql = "SELECT a.`role_id`,b.`role_name` FROM `".DB_PREFIX."user_role` a ".
                "LEFT JOIN `".DB_PREFIX."roles` b ON b.`id` = a.`role_id` ".
                "WHERE a.`user_id` = ".$this->db->escape($user_id)." AND a.`status` = 1;";

        $query = $this->db->query($sql);
       
        if($query->getNumRows() > 0){
            $user_roles = $query->getResult();
            $result = [];

            foreach($user_roles as $role){
                $result['roles'][] = $role->role_id;
            }
            $result['desc'] = $query->getResult();
           
            return $result;
        }else{
            return [];
        }
    }

    
}

?>