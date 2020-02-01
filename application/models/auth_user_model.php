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
			//$this->db->join('user_profile_i18n', 'user_profile.user_id = user_profile_i18n.row_id', 'left');
			//$this->db->where('user_profile_i18n.culture', get_lang());
			
			$this->db->from($this->table_name);
			$this->db->order_by('id', 'ASC');
			$query = $this->db->get();
			$items = $query->result_array();
	
			return $items;
		}
}