<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//$this->is_authenticated();
	}
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['page'] = 'backend/dashboard/main';
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
