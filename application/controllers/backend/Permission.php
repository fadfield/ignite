<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission extends CI_Controller {

	public function index()
	{
		//$data['session'] = $this->session->userdata();
		$data['title'] = 'Daftar Akses';
		$data['rows'] = $this->auth_user_model->get_auth_permissions();
		$data['page'] = 'backend/permission/list';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
	}

	public function create()
	{
		$this->load->view('welcome_message');
	}

	public function update()
	{
		$this->load->view('welcome_message');
	}

	public function show()
	{
		$this->load->view('welcome_message');
	}

	public function delete()
	{
		$this->load->view('welcome_message');
	}
}