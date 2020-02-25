<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/** 
* Auth Class 
* 
* Class to extend CI controller for each controller
*
* @category	Libraries
* @package Ignite
* @author Kholiq Fadlli
*/

class Auth {

    // init vars
    var $CI, $user, $permissions;
	
    function Auth()
    {
        $this->CI =& get_instance();
        $this->user = ($this->CI->session->userdata('user')) ? $this->CI->session->userdata('user') : array();
    }
	
	public function is_authenticated(){
		return ($this->user) ? TRUE : FALSE;
	}
	
	public function get_user()
	{
		return $this->user;
	}
	
	public function set_user($user)
	{
		$this->CI->session->set_userdata('user', $user);
	}
	
	public function unset_user()
	{
		$this->CI->session->unset_userdata('user');
	}
	
	public function get_permissions()
	{
		return (isset($this->user['permissions'])) ? $this->user['permissions'] : array();
	}
	
	public function set_permissions($permissions)
	{
		$this->user['permissions'] = $permissions;
		$this->CI->session->set_userdata('user', $this->user);
	}
	
	public function get_groups()
	{
		return (isset($this->user['groups'])) ? $this->user['groups'] : array();
	}
	
	public function set_groups($groups)
	{
		$this->user['groups'] = $groups;
		$this->CI->session->set_userdata('user', $this->user);
	}
	
	public function has_permission($permission)
	{
		return in_array($permission, $this->get_permissions());
	}
	
	public function has_group($group)
	{
		return in_array($group, $this->get_groups());
	}
	
	public function get_user_id()
	{
		return $this->user['id'];
	}
	
	public function get_username()
	{
		return (isset($this->user['username'])) ? $this->user['username'] : 'guest';
	}
	
	public function get_name()
	{
		return (isset($this->user['name'])) ? $this->user['name'] : 'Guest';
	}
	
	public function get_nickname()
	{
		return (isset($this->user['nickname'])) ? $this->user['nickname'] : 'Guest';
	}
	
	public function is_super_admin()
	{
		return (isset($this->user['is_super_admin'])) ? $this->user['is_super_admin'] : 0;
	}

}

/* End of file Auth.php */ 
/* Location: ./system/application/libraries/Auth.php */ 