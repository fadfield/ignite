<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Auth_user_model Class 
* 
* Class to extend CI controller for each controller
*
* @category	Models
* @package Ignite
* @author Kholiq Fadlli
*/

class Auth_user_model extends CI_Model {

	public $table_name = 'auth_user';

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
    public function login($params, $is_authorize = FALSE)
    {
		$username = trim($params['username']);
		$password = trim($params['password']);
		$success = FALSE;
		
		$this->db->where('username', $params['username']);
		$query = $this->db->get($this->table_name);
		$user = $query->row_array();
		
		if($user){
			if(md5($password) === $user['password']){
				$success = TRUE;
				if(!$is_authorize) $this->set_last_login($user);
			}
		};
		
		return ($success) ? $user : NULL;
    }
	public function get_user_permissions($user)
	{
		$permissions = array();
		$this->db->select('auth_permission.`name`');
		$this->db->where('user_id', $user['id']);
		$this->db->from('auth_user_group');
		$this->db->join('auth_group', 'auth_group.id = auth_user_group.group_id');
		$this->db->join('auth_group_permission', 'auth_group_permission.group_id = auth_group.id');
		$this->db->join('auth_permission', 'auth_permission.id = auth_group_permission.permission_id');
		$query = $this->db->get();
		$group_permissions = array();
		foreach($query->result_array() as $result){
			$group_permissions[] = $result['name'];
		}
		
		$this->db->select('auth_permission.`name`');
		$this->db->where('user_id', $user['id']);
		$this->db->from('auth_permission');
		$this->db->join('auth_user_permission', 'auth_permission.id = auth_user_permission.permission_id');
		$query = $this->db->get();
		$user_permissions = array();
		foreach($query->result_array() as $result){
			$user_permissions[] = $result['name'];
		}
		
		$permissions = array_unique(array_merge($group_permissions, $user_permissions), SORT_REGULAR);
		return $permissions;
	}
	public function get_user_groups($user)
	{		
		$this->db->select('auth_group.`name`');
		$this->db->where('user_id', $user['id']);
		$this->db->from('auth_user_group');
		$this->db->join('auth_group', 'auth_group.id = auth_user_group.group_id');
		$query = $this->db->get();
		$groups = array();
		foreach($query->result_array() as $result){
			$groups[] = $result['name'];
		}
		return $groups;
	}
    public function set_last_login($user)
    {
		$data = array('last_login' => date('Y-m-d H:i:s'));
		$this->db->where('id', $user['id']);
		$this->db->update($this->table_name, $data); 
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	}


	
	public function get_active_rows()
	{
		$this->db->where('state', 'A');
		$this->db->where('is_super_admin', 0);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}

	public function get_rows($params = array()){
		
		if(isset($params['relation'])){
			switch($params['relation']){
				case 'profile_group':
					$this->db->select($this->table_name.'.*, 
						user_profile.fullname AS profile_fullname,
						auth_group.name AS group_name
					');
					$this->db->join('auth_user_group', 'auth_user_group.user_id = '.$this->table_name.'.id', 'left');
					$this->db->join('auth_group', 'auth_group.id = auth_user_group.group_id', 'left');
				break;
			}
		}else{
			$this->db->select('*');	
		}
		
		if(isset($params['crud'])){
			$this->db->where($this->table_name.'.state!=', 'D');
		}else{
			$this->db->where($this->table_name.'.state', 'A');
		}
		$this->db->join('user_profile', 'user_profile.user_id = '.$this->table_name.'.id');
		$this->db->from($this->table_name);
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get();
		$items = $query->result_array();
		return $items;
	}
	public function get_row($id, $params = array()){
		$this->db->where('auth_user.id', $id);
		if(isset($params['fetch_profile'])){
			$this->db->select($this->table_name.'.*, 
				user_profile.phone AS phone,
				user_profile.fullname AS fullname,
				user_profile.email AS email,
				auth_group.name AS group_name,
				user_profile.image_path AS image_path
			');
			$this->db->join('user_profile', 'user_profile.user_id = '.$this->table_name.'.id');
			$this->db->join('auth_user_group', 'auth_user_group.user_id = '.$this->table_name.'.id', 'left');
			$this->db->join('auth_group', 'auth_group.id = auth_user_group.group_id', 'left');
		}
		$query = $this->db->get($this->table_name);
		$item = $query->row_array();
		return $item;
	}
	public function create($params){
		$this->db->insert($this->table_name, $params); 
		if($id = $this->db->insert_id()){
			return $this->get_row($id);
		}else{
			return null;
		}
	}
	public function set_user_groups($user_id, $groups){
		$this->db->trans_start();
		$this->db->delete('auth_user_group', array('user_id'=>$user_id));
		foreach($groups as $group){
			$this->db->insert('auth_user_group', array('user_id'=>$user_id, 'group_id'=>$group)); 
		}
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
	}
	public function get_user_group_rows($user)
	{		
		$this->db->select('auth_group.*');
		$this->db->where('user_id', $user['id']);
		$this->db->from('auth_user_group');
		$this->db->join('auth_group', 'auth_group.id = auth_user_group.group_id');
		$query = $this->db->get();
		return $query->result_array();;
	}
	public function auth_user_update($id, $params){
		$this->db->trans_start();
		$this->db->where('id', $id);
		$this->db->update($this->table_name, $params); 
		$this->db->trans_complete();
		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
	}
	public function update($id, $post){
		if($this->auth_user_update($id, $post)){
			return $this->get_row($id);
		}else{
			return null;
		}	
	}
	public function is_group_exist($params){
		$this->db->select('name');
		$this->db->from('auth_group');
		if(isset($params['id']) && $params['id'])
			$this->db->where('id !=', $params['id']);
		$this->db->where('name', $params['name']);
		return ($this->db->count_all_results() > 0) ? TRUE : FALSE; 
	}
	public function get_auth_groups()
	{		
		$this->db->select('*');
		//$this->db->where_in('state', array('A', 'I'));
		$this->db->from('auth_group');
		$this->db->order_by('id', 'desc');
		$query = $this->db->get();
		$items = $query->result_array();
		return $items;
	}

	public function get_auth_permissions()
	{		
		$this->db->select('*');
		$this->db->where_in('state', array('A', 'I'));
		$this->db->from('auth_permission');
		$this->db->order_by('description', 'ASC');
		$query = $this->db->get();
		$items = $query->result_array();
		return $items;

	}
	public function get_active_auth_permissions()
	{		
		$this->db->select('*');
		$this->db->where('state', 'A');
		$this->db->from('auth_permission');
		$this->db->order_by('description', 'ASC');
		$query = $this->db->get();
		$items = $query->result_array();
		return $items;

	}
	public function create_auth_group($post){
		$params = array(
			'name' => $post['name'],
			'description' => $post['description']
		);
		
		$success = FALSE;
		
		$this->db->insert('auth_group', $params); 
		$id = $this->db->insert_id(); 

		$permissions = (isset($post['permissions'])) ? $post['permissions'] : array();
		
		if($id){
			if($this->set_group_permissions($id, $permissions)){
				$success = TRUE;
			}
			
		}
		//echo $this->db->last_query();
		return $id;
	}
	public function set_group_permissions($group_id, $permissions){
		$this->db->trans_start();
		$this->db->delete('auth_group_permission', array('group_id'=>$group_id));
		foreach($permissions as $permission){
			$this->db->insert('auth_group_permission', array('group_id'=>$group_id, 'permission_id'=>$permission)); 
		}
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
	}
	public function get_auth_group_row($id)
	{		
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('auth_group');
		$this->db->order_by('description', 'ASC');
		$query = $this->db->get();
		$item = $query->row_array();
		$item['permissions'] = $this->get_group_permissions($item);
		return $item;
	}
	public function get_group_permissions($group)
	{		
		$this->db->select('auth_permission.`name`, auth_permission.`description`');
		$this->db->where('group_id', $group['id']);
		$this->db->from('auth_group_permission');
		$this->db->join('auth_permission', 'auth_permission.id = auth_group_permission.permission_id');
		$this->db->order_by('auth_permission.description', 'ASC');
		$query = $this->db->get();

		return $query->result_array();
	}
	public function delete_auth_group($id){
		$this->db->trans_start();
		$this->db->delete('auth_group', array('id' => $id));
		$this->db->delete('auth_group_permission', array('group_id' => $id));
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
	}
	public function update_auth_group($id, $post){
		$params = array(
			'state' => $post['state'],
			'name' => $post['name'],
			'description' => $post['description']
		);
		
		$id = $post['id'];
		$permissions = $post['permissions'];
		
		$success = FALSE;
		
		$this->db->where('id', $id);
		$this->db->update('auth_group', $params); 
		
		if($this->set_group_permissions($id, $permissions)){
			$success = TRUE;
		}
					
		return $success;
	}
	public function delete($id){
		$this->db->trans_start();
		$this->db->delete('auth_user', array('id' => $id));
		$this->db->delete('auth_user_group', array('user_id' => $id));
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
	}
}
/* End of file Auth_user_model.php */
/* Location: /application/models/Auth_user_model.php */