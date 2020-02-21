<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/** 
* User_profile_model Class 
* 
* Class to extend CI controller for each controller
*
* @category	Models
* @package Ignite
* @author Kholiq Fadlli
*/

class User_profile_model extends CI_Model {

	public $table_name = 'user_profile';

	public function __construct()
	{
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function create($params = array()){
		if($this->db->insert($this->table_name, $params)){
			$row = $this->get_row($params['user_id']);
			return $row;
		}else{
			return null;
		}
	}
	
	public function get_row($id, $params = array()){
		$this->db->where('user_id', $id);
		
		if(isset($params['i18n'])){
			$this->db->join($this->table_name.'_i18n', $this->table_name.'.user_id = '.$this->table_name.'_i18n.row_id', 'left');
			$this->db->where($this->table_name.'_i18n.culture', get_lang());
		}
		$this->db->join('auth_user', $this->table_name.'.user_id = auth_user.id', 'left');
		$query = $this->db->get($this->table_name);
		$item = $query->row_array();
		return $item;
	}

	public function get_row_group($id = ''){
		$this->db->where('id', $id);
		
		$this->db->join('auth_user_group', 'auth_user.id = auth_user_group.user_id', 'left');
		$query = $this->db->get('auth_user');
		$item = $query->row_array();
		return $item;
	}
	
	public function get_active_rows()
	{
		$this->db->where('state', 'A');
		$this->db->order_by('id', 'ASC');
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	
	public function get_max_id(){
		$this->db->select('MAX(id) AS max_id');
		$this->db->from($this->table_name);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		$item = $query->row_array();
		return ($item) ? $item['max_id']: 0;
	}

	public function get_rows($params = array()){
		$this->db->select('*');
		
		if(isset($params['crud'])){
			$this->db->where('state!=', 'D');
		}else{
			$this->db->where('state', 'A');
		}
		
		if(isset($params['user_id'])) $this->db->where('user_id', $params['user_id']);

		$this->db->join($this->table_name.'_i18n', $this->table_name.'.id = '.$this->table_name.'_i18n.row_id');
		$this->db->where($this->table_name.'_i18n.culture', get_lang());
		
		$this->db->from($this->table_name);
		$this->db->order_by('id', 'DESC');
		$query = $this->db->get();
		$items = $query->result_array();
		return $items;
	}
	
	public function update($id, $params){
		$this->db->trans_start();
		$this->db->where('user_id', $id);
		$this->db->update($this->table_name, $params); 
		$this->db->trans_complete();
		$success = ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
		if($success){
			return $this->get_row($id);
		}else{
			return null;
		}
	}

	public function update_group($id, $params){
		$this->db->trans_start();
		$this->db->where('user_id', $id);
		$this->db->update('auth_user_group', $params); 
		$this->db->trans_complete();
		$success = ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
		if($success){
			return $this->get_row($id);
		}else{
			return null;
		}
	}
	
	public function delete($id){
		$this->db->trans_start();
		$this->db->delete($this->table_name, array('user_id' => $id));
		$this->db->trans_complete();
		
		return ($this->db->trans_status() === FALSE) ? FALSE : TRUE; 
	}
	
	public function filter($params)
	{		
		$this->db->join('user_profile', 'user_profile.user_id = auth_user.id');
		$this->db->join('user_profile_i18n', 'user_profile.user_id = user_profile_i18n.row_id');
		$this->db->where('user_profile_i18n.culture', get_lang());
				
		if (isset($params['state'])) $this->db->where('state', isset($params['state'])); 
		
		if (isset($params['keyword']) && $params['keyword']){
			$this->db->where("(username LIKE '%".$params['keyword']."%' || user_profile.fullname LIKE '%".$params['keyword']."%')");
		}
		
		// $this->db->where($this->table_name.'_i18n.culture', get_lang());
		
		$this->db->order_by('username', 'ASC');
		$this->db->from('auth_user');
		
		$query = $this->db->get();
		
		$items = $query->result_array();
		return $items;
		// die(pretty_print($items));
	}

	// public function filter($params)
	// {		
	// 	if (isset($params['state'])) $this->db->where('state', isset($params['state'])); 
		
	// 	if (isset($params['keyword']) && $params['keyword']){
	// 		$this->db->where("(fullname LIKE '%".$params['keyword']."%' || fullname LIKE '%".$params['keyword']."%')");
	// 	}
		
	// 	$this->db->order_by('title', 'ASC');
	// 	$this->db->from($this->table_name);
	// 	$query = $this->db->get();
	// 	$items = $query->result_array();
	// 	return $items;
	// }
}
/* End of file User_profile_model.php */
/* Location: /application/models/User_profile_model.php */