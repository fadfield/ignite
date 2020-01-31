<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		/*$data['session'] = $this->session->userdata();
		$data['menu'] = 'backend/menu';*/
		$data['title'] = 'Dashboard';
		$data['page'] = 'backend/dashboard/main';
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
