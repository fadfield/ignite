<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends MY_Controller {

	function Error()
	{
		parent::MY_Controller();
	}
	
	public function unauthorized()
	{		
		$this->load->view('errors/unauthorized_view');
	}
}
