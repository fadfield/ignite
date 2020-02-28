<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_authenticated();
	}
	public function index()
	{
		$data['title']	= 'Daftar Grup';
		$data['rows']	= $this->auth_user_model->get_auth_groups();
		$data['page']	= 'backend/group/list';
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
		
			$this->form_validation->set_rules('name','name','trim|required|xss_clean');
			
			if($this->form_validation->run() === TRUE) {
				$post = $this->input->post();

				if($this->auth_user_model->is_group_exist($post)){
					$data['result'] = array(
						'success'=>FALSE,
						'message'=>'Grup sudah ada'
					);
				}else{
					if($create = $this->auth_user_model->create_auth_group($post)){
						$this->auth_user_model->get_auth_group_row($create);

						$data['result'] = array(
							'success'=>TRUE,
							'message'=>'Data berhasil disimpan'
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
	public function show($id)
	{
		$data['row']	= $this->auth_user_model->get_auth_group_row($id);
		$data['permission'] = $this->auth_user_model->get_active_auth_permissions();
		$group_permissions = array();
		foreach($data['row']['permissions'] as $result){
			$group_permissions[] = $result['description'];
		}
		$data['group_permissions'] = $group_permissions;
		$this->load->vars($data);
		$this->load->view('backend/group/show_view');
	}

	public function update($id)
	{
		$data['title'] = 'Edit Grup';
		$data['row'] = $this->auth_user_model->get_auth_group_row($id);
		$data['permission'] = $this->auth_user_model->get_active_auth_permissions();
		$group_permissions = array();
		foreach($data['row']['permissions'] as $result){
			$group_permissions[] = $result['name'];
		}
		$data['group_permissions'] = $group_permissions;
						
		if($this->input->post()){
			$data['result'] = array(
				'success'=>FALSE,
				'message'=>'Terjadi kesalahan ketika menyimpan data, mohon coba lagi'
			);
			
			$this->form_validation->set_rules('name', 'name', 'trim|required|xss_clean');
			
			if($this->form_validation->run() === TRUE) {
				$post = $this->input->post();
				
				if($this->auth_user_model->is_group_exist($post)){
					$data['result'] = array(
						'success'=>FALSE,
						'message'=>'Grup sudah ada'
					);
				}else{
					
					if($update = $this->auth_user_model->update_auth_group($id, $post)){
						$this->auth_user_model->get_auth_group_row($id);
						
						$data['result'] = array(
							'success'=>TRUE,
							'message'=>'Data berhasil diedit'
						);
						
						$this->session->set_flashdata('result', $data['result']);
						
						redirect(backend_url().'group/update/'.$id);
						
					}
					
				}
			}
		}
		
		
		$data['page'] = 'backend/group/update';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
	}

	public function delete($id)
	{	
		if($this->auth_user_model->delete_auth_group($id)){
			$this->auth_user_model->get_auth_group_row($id);

			$data['result'] = array(
				'success'=>TRUE,
				'message'=>'Data berhasil dihapus'
			);
			$this->session->set_flashdata('result', $data['result']);
			redirect(backend_url().'group');

		}else{
			$data['result'] = array(
				'success'=>FALSE,
				'message'=>'Gagal hapus data'
			);
		}
	}
}