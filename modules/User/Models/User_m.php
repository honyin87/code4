<?php 

namespace Modules\Auth\Models;

use CodeIgniter\Model;


class Auth_m extends Model
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

        $sql = "SELECT a.*,c.role_name FROM `".DB_PREFIX."users` a
                LEFT JOIN `".DB_PREFIX."user_role` b ON b.user_id = a.id
                LEFT JOIN `".DB_PREFIX."roles` c ON c.id = b.role_id
                ".$where ;
        
        $query = $this->db->query($sql);
        
        
        if($query->getNumRows() > 0){
            
            $data['total_rows'] = $query->getNumRows();

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
            if($user->role_id == 1){
                $exclude[] = $user->role_id;
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


    // Create User
    if($id == ''){

    }else{
    // Edit User

    }

    $data["errors"] = $errors;
    return $data;

   }

    
}

?>