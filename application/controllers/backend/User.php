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

	public function show($id)
	{
		$data['row'] = $this->auth_user_model->get_row($id);
		$this->load->vars($data);
		$this->load->view('backend/user/show_view');
	}

	public function delete($id)
	{	
		if($delete = $this->auth_user_model->delete($id)){
			if($delete_profile = $this->user_profile_model->delete($id)){
				$data['result'] = array(
					'success'=>TRUE,
					'message'=>'Data berhasil dihapus'
				);
				$this->session->set_flashdata('result', $data['result']);
				redirect(backend_url().'user');

			}else{
				$data['result'] = array(
					'success'=>FALSE,
					'message'=>'Gagal hapus data'
				);
			}
		}
	}
}