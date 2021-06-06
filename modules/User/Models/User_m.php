<?php 

namespace Modules\User\Models;

use CodeIgniter\Model;


class User_m extends Model
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = db_connect();
        $this->session = session();
        
            
    }


    public function get_user_list($page = 1, $is_search = false){

        $where = '';
        $data = [];
        $search_keys = [];
        $tmp_where = [];

        if($is_search){
            
            $request = service('request');

            if( !empty($request->getPost('search_name')) ||
                !empty($request->getPost('search_email')) ||
                !empty($request->getPost('search_role')) 
            ){
                $search_keys = array(
                    'search_name' => trim($request->getPost('search_name')),
                    'search_email' => trim($request->getPost('search_email')),
                    'search_role' => trim($request->getPost('search_role')),
                );
            }

            if(!empty($search_keys['search_name'])){
                $tmp_where[] = "( a.firstname LIKE '%".$this->db->escapeString($search_keys['search_name'])."%' 
                                OR a.lastname LIKE '%".$this->db->escapeString($search_keys['search_name'])."%' 
                                )";
            }

            if(!empty($search_keys['search_email'])){
                $tmp_where[] = "a.email =".$this->db->escape($search_keys['search_email']);
            }

            if(!empty($search_keys['search_role'])){
                $tmp_where[] = "b.role_id =".$this->db->escape($search_keys['search_role']);
            }

            if(!empty($tmp_where)){
                $where = " WHERE ". implode(" AND ",$tmp_where);
            }
            
            // Save Search Session
            if(!empty($search_keys)){
                
                $this->session->set('search_keys', $search_keys);
            }else{
                // Remove Search Session

                if($this->session->has('search_keys')){
                    $this->session->remove('search_keys');
                }
            }
        }else{

            // Remove Search Session
            
            if($this->session->has('search_keys')){
                $this->session->remove('search_keys');
            }
        }

        $session = session();

        if($session->has('user') ){
            $user = $session->get('user');
            if($user->role_id != 1){
                $exclude[] = 1;
            }
        }

        $tmp_where = '';
        if(!empty($exclude)){
            $tmp_where = " b.`role_id` NOT IN('".implode("','",$exclude)."')";
        }
        if(!empty($tmp_where)){
            if(empty($where)){
                
                $where = " WHERE ".$tmp_where;
            }else{
                $where .= " AND ".$tmp_where;
            }
        }

        $sql = "SELECT a.*,c.role_name FROM `".DB_PREFIX."users` a
                LEFT JOIN `".DB_PREFIX."user_role` b ON b.user_id = a.id
                LEFT JOIN `".DB_PREFIX."roles` c ON c.id = b.role_id
                ".$where ;
        
        $query = $this->db->query($sql);
        
        $data['total_rows']  = $query->getNumRows();

        if($query->getNumRows() > 0){
            
            $sql.= " LIMIT ".PER_PAGE. " OFFSET ".($page-1)*PER_PAGE;
            $query = $this->db->query($sql);

            $data['results'] = $query->getResult();
            
           //array_debug($sql);exit;
        }

        $pagination = service('pager');
        $data['pagination'] = $pagination->makeLinks($page, PER_PAGE, $data['total_rows'], 'default_full', 3) ;

        //Retrive Search Session
        if($this->session->has('search_keys')){
            $data['search_keys'] = $this->session->get('search_keys');
        }

        return $data;

    }

    function get_roles($exclude = array()){

        $where = '';
        $session = session();
        
        if($session->has('user') ){
            $user = $session->get('user');
            if($user->role_id != 1){
                $exclude[] = 1;
            }
        }

        if(!empty($exclude)){
            $where = " WHERE id NOT IN('".implode("','",$exclude)."')";
        }

        $sql = "SELECT a.* FROM `".DB_PREFIX."roles` a
                ".$where. " ORDER BY a.role_name" ;

        $query = $this->db->query($sql);
       
        
       if($query->getNumRows() > 0){
           return $query->getResult();
       }

       return [];

    }

   function set_user($id = ''){

    $request = service('request');
    $data = [];

    // Validate Input
    $errors = array();
    $required = array(
        'username'  => "User Name",
        'password'  => "Password",
        'firstname' => "First Name",
        'lastname'  => "Last Name",
        'role'      => "Role",
    );

    foreach($required as $k => $item){

        if(empty($request->getPost($k))){
            $errors[$k] = $item. " is required.";
        }
    }

    if(!empty($errors)){
        $data["errors"] = $errors;
        return $data;
    }

    $data = array(
        'firstname'     => $request->getPost('firstname'),
        'lastname'      => $request->getPost('lastname'),
        'email'         => $request->getPost('email'),
        'contact_no'    => $request->getPost('contact_no'),
        'verified'      => 1,
        'status'        => 1,
        'update_by'     => user_info()->username,
        'update_date'   => date('Y-m-d H:m:s'),
    );

     

    // Create User
    if($id == ''){

        // Validate username
        $user = $this->get_user_by_username($request->getPost('username'));
        
        if($user !== false){
            $data["errors"]['username'] = "Username `".$request->getPost('username').'` already exists.';
            
            return $data;
        }

        $insert_data = array(
            'username'      => $request->getPost('username'),
            'password'      => md5($request->getPost('password')),
            'create_by'     => $data['update_by'],
            'create_date'   => $data['update_date'],
        );

        $insert_data = array_merge($data,$insert_data);
        

        $to_insert = array();

        foreach($insert_data as $k => $v){
            $to_insert["`".$k."`"]  = $this->db->escape($v);
        }
        $queries[] = "INSERT INTO `".DB_PREFIX."users`(".implode(",",array_keys($to_insert)).") VALUES(".implode(",",$to_insert).")";

        // array_debug($queries);exit;

        // User's Role
        $username = $this->db->escape($insert_data["username"]);

        $insert_data = array(
            'role_id'       => $request->getPost('role'),
            'status'        => 1,
            'update_by'     => user_info()->username,
            'update_date'   => date('Y-m-d H:m:s'),
            'create_by'     => user_info()->username,
            'create_date'   => date('Y-m-d H:m:s'),
        );

        $to_insert = array();

        foreach($insert_data as $k => $v){
            $to_insert["`".$k."`"]  = $this->db->escape($v);
        }

        $to_insert["`user_id`"] = "(SELECT a.`id` FROM `".DB_PREFIX."users` a WHERE a.`username` = ".$username.")";

        $queries[] = "INSERT INTO `".DB_PREFIX."user_role`(".implode(",",array_keys($to_insert)).") VALUES(".implode(",",$to_insert).")";


        //array_debug($queries);exit;

        // DB Transactions
        if(!empty($queries)){

            // Transaction - Start
            $this->db->transBegin();

            foreach($queries as $query){

                $this->db->query($query);
            }

            if ($this->db->transStatus() === FALSE)
            {
                $this->db->transRollback();
                set_msg("Error when creating user. Please try again later.");

                return false;
            }
            else
            {
                $this->db->transCommit();
                set_msg("New User created.",'success');

                return true;
            }

        }
        
    }else{
        
        // Edit User
        $password = $request->getPost('password');
        
        // If password changed
        if($password != NO_CHG_PASSWORD){

            $data['password'] = md5($request->getPost('password'));
        }

        $user_data = $this->get_user($id);

        

        $to_update = array();

        foreach($data as $k => $v){

            if($user_data->{$k} != $v){
                $to_update[$k] = " `". $k. "` = " . $this->db->escape($v);
            }
            
        }

        // check any changes
        $tmp_data = $to_update;

        $queries[] = "UPDATE `".DB_PREFIX."users` SET ".implode(", ",$to_update). " WHERE `id` = ".$this->db->escape($id).";";

        $role_data = array(
            'role_id'       => $request->getPost('role'),
            'update_by'     => user_info()->username,
            'update_date'   => date('Y-m-d H:m:s'),
        );

        $role_update = array();

        if($user_data->role != $role_data['role_id']){
            $role_update[] = " `role_id` = " . $this->db->escape($role_data['role_id']);
            $role_update[] = " `update_by` = " . $this->db->escape($role_data['update_by']);
            $role_update[] = " `update_date` = " . $this->db->escape($role_data['update_date']);

            $queries[] = "UPDATE `".DB_PREFIX."user_role` SET ".implode(", ",$role_update). " WHERE `user_id` = ".$this->db->escape($id).";";
        }

        unset($tmp_data['update_date']);
        unset($tmp_data['update_by']);

        if(sizeof($tmp_data) == 0 && empty($role_update)){

            set_msg("Warning: No data updated since last edit.",'warning');
            return false;

        }

        //  array_debug($queries);exit;

        // DB Transactions
        if(!empty($queries)){
            
            // Transaction - Start
            $this->db->transBegin();

            foreach($queries as $query){

                $this->db->query($query);
            }

            if ($this->db->transStatus() === FALSE)
            {
                $this->db->transRollback();
                set_msg("Error when updating user. Please try again later.");

                return false;
            }
            else
            {
                $this->db->transCommit();
                set_msg("User info updated.",'success');

                return true;
            }

        }
        

    }

    

   }

   function get_user($id = ''){

        if(empty($id)){

            set_msg('Invalid ID');
            return false;
        }



        $sql = "SELECT a.*,c.id as `role` FROM `".DB_PREFIX."users` a
                LEFT JOIN `".DB_PREFIX."user_role` b ON b.`user_id` = a.`id`
                LEFT JOIN `".DB_PREFIX."roles` c ON c.`id` = b.`role_id`
                WHERE a.`id` = ".$this->db->escape($id);

        $query = $this->db->query($sql);


        if($query->getNumRows() > 0){
            return $query->getRow();
        }

        return false;


   }

   function get_user_by_username($username = ''){

    if(empty($username)){

        set_msg('Invalid Username');
        return false;
    }



    $sql = "SELECT a.*,c.id as `role` FROM `".DB_PREFIX."users` a
            LEFT JOIN `".DB_PREFIX."user_role` b ON b.`user_id` = a.`id`
            LEFT JOIN `".DB_PREFIX."roles` c ON c.`id` = b.`role_id`
            WHERE a.`username` = ".$this->db->escape($username);

    $query = $this->db->query($sql);


    if($query->getNumRows() > 0){
        return $query->getRow();
    }

    return false;


}

    
}

?>