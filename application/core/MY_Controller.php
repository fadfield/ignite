<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/** 
* My Controller Class 
* 
* Class to extend CI controller for each controller
*
* @category	Libraries
* @subpackage Extend Controller
* @package Ignite
* @author Kholiq Fadlli
*/
class MY_Controller extends CI_Controller{

	var $data=array();
	var $CI;

    function MY_Controller()
	{        
		parent::__construct();
		$this->CI =& get_instance();
	}
	
	public function is_authenticated()
	{
		$directory = $this->router->fetch_directory();
		$class = $this->router->fetch_class();
		$method = $this->router->fetch_method();
		$module = str_replace('/','_',$directory.$class);//$this->_get_module_name();
			
		if(!$this->auth->is_authenticated()){
			if($class!=='user' && $method!=='login'){
				if($directory=='backend/'){
					redirect(backend_url().'login');
				}else{
					redirect(backend_url().'login');
				}
			}
		}
		
		if(!$this->auth->has_permission($module)){
			redirect(base_url().'error/unauthorized?module='.$module);
		}
	}
	
	public function _sa_authenticated(){
		if(!$this->auth->is_super_admin()){
			redirect(base_url().'error/unauthorized');	
		}
	}
	
	public function _get_module_name(){
		$class = $this->router->fetch_class();
		$method = $this->router->fetch_method();
		$module = $class.'_'.$method;
		return $module;
	}
}
/* End of file MY_Controller.php */ 
/* Location: ./system/application/libraries/MY_Controller.php */ 