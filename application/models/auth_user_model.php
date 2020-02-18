<?php
	class Auth_user_model extends CI_Model {
	
		public $table_name = 'auth_user';

        public function __construct()
        {
			// Call the CI_Model constructor
			parent::__construct();
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
			echo $this->db->last_query();
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
}