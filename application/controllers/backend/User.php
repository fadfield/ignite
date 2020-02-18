<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function login()
	{
		$this->load->view('backend/user/login_view');
	}
	public function index()
	{
		$data['title'] = 'Daftar Pengguna';
		$data['rows'] = $this->auth_user_model->get_rows(array('relation'=>'profile_group', 'crud'=>1));
		$data['page'] = 'backend/user/list';
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