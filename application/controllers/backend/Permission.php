<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->is_authenticated();
	}

	public function index()
	{
		$data['title'] = 'Daftar Akses';
		$data['rows'] = $this->auth_user_model->get_auth_permissions();
		$data['page'] = 'backend/permission/list';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
	}

	public function create()
	{
		$this->load->view('comingsoon_view');
	}

	public function update()
	{
		$this->load->view('comingsoon_view');
	}

	public function show()
	{
		$this->load->view('comingsoon_view');
	}

	public function delete()
	{
		$this->load->view('comingsoon_view');
	}
}