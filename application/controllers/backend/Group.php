<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {

	public function index()
	{
		//$data['session'] = $this->session->userdata();
		$data['title'] = 'Daftar Grup';
		$data['rows'] = $this->auth_user_model->get_auth_groups();
		$data['page'] = 'backend/group/list';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
	}

	public function create()
	{
		$data['title'] = 'Tambah Grup Baru';
		$data['row'] = array();
		$data['permission'] = $this->auth_user_model->get_active_auth_permissions();
		$data['group_permissions'] = array();		
				
		if($this->input->post()){
			
			$data['result'] = array(
				'success'=>FALSE,
				'message'=>'Terjadi kesalahan ketika menyimpan data, mohon coba lagi'
			);
			
			$this->form_validation->set_rules('name', 'trim|required|xss_clean');
			
			if($this->form_validation->run() === TRUE) {
				$post = $this->input->post();

				if($this->auth_user_model->is_group_exist($post)){
					$data['result'] = array(
						'success'=>FALSE,
						'message'=>translate('group_exists')
					);
				}else{
					if($create = $this->auth_user_model->create_auth_group($post)){
						$new_value =  $this->auth_user_model->get_auth_group_row($create);
						do_log(array('new_value'=>$new_value, 'old_value'=>array()));
					
						$data['result'] = array(
							'success'=>TRUE,
							'message'=>translate('crud_create_success')
						);
						
						$this->session->set_flashdata('result', $data['result']);
						redirect(backend_url().'group/create');
						
					}
				}
				
			}
		}
		
		$data['page'] = 'backend/group/create';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
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