<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function login()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$params = array('username'=>$username, 'password'=>$password);
			
			$success = FALSE;
			$message = '';
			
			if ($this->form_validation->run() === TRUE) {
				$user = $this->auth_user_model->login($params);
				if($user){
					$user['permissions'] = $this->auth_user_model->get_user_permissions($user);
					$user['groups'] = $this->auth_user_model->get_user_groups($user);
					$this->auth->set_user($user);
					$success = TRUE;
					redirect(backend_url());
				}else{
					$this->auth->unset_user();
					$this->session->sess_destroy();
					$data['result'] = array(
							'success'=>FALSE,
							'message'=>'Username atau Password salah'
						);
						
					//set flash data 
					$this->session->set_flashdata('result', $data['result']);

					//redirect
					redirect(base_url().'login');

				}
			} else {
				$message = validation_errors();	
			}
			/*$json = array('success'=>$success, 'message'=>$message);
			$this->output->set_content_type('application/json')->set_output(json_encode($user));*/

		}
		$this->load->view('backend/user/login_view');
	}
	public function logout()
	{		
		$this->auth->unset_user();
		$this->session->sess_destroy();
		redirect(base_url().'login');
	}
	public function index()
	{
		$this->is_authenticated();
		$data['title'] = 'Daftar Pengguna';
		$data['rows'] = $this->auth_user_model->get_rows(array('relation'=>'profile_group', 'crud'=>1));
		$data['page'] = 'backend/user/list';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
	}

	public function create()
	{
		$this->is_authenticated();
		$data['title'] = 'Tambah Pengguna';
		//set form mode
		$data['mode'] = 'create';	
		
		//set empty row for creating record
		$data['row'] = array();	
		
		if($this->input->post()){
			
			//setup rules
			$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
			$this->form_validation->set_rules('confirm_password', 'confirm_password', 'trim|required|xss_clean|matches[password]');
			$this->form_validation->set_rules('profile[fullname]', 'fullname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('group_id', 'group', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() === TRUE) {
				
				//store post variable
				$post = $this->input->post();
				
				//setup params for table auth_user
				$params = array(
					'username'=>$post['username'],
					'password'=>md5($post['password']),
					'created_date'=>date('Y-m-d H:i:s')
				);
				
				//default result
				$data['result'] = array(
					'success'=>FALSE,
					'message'=>'Terjadi kesalahan ketika menyimpan data, mohon coba lagi'
				);

				if($user = $this->auth_user_model->create($params)){
					
					//set user to group
					if($post['group_id'] > 0){
						$groups = array($post['group_id']);
						$this->auth_user_model->set_user_groups($user['id'], $groups);
					}
					
					//get post variable
					$profile = $post['profile'];
					
					//upload picture
					if ($data['row']['image_path'] == $post['attachment_path1']) {
						$image_path = $post['attachment_path1'];
					}
					elseif (!empty($_FILES['image_file']['name'])){
						$hash_name = md5($_FILES['image_file']['name'].time());
						$config['file_name'] = $hash_name;
						$config['upload_path'] = './assets/uploads/users/';
						$config['allowed_types'] = 'png|gif|jpg|jpeg'; //png|gif|jpg|avi|mp4|zip|doc
						$config['max_size']	= '4000'; //in kb
						$config['max_width']  = '4000'; //in pixel
						$config['max_height']  = '4000'; //in pixel
						$this->upload->initialize($config);

						if ( ! $this->upload->do_upload('image_file')){
							$image_path = '';
							$data['result'] = array(
								'success'=>FALSE,
								'message'=>$this->upload->display_errors()
							);
							//set flash data 
							$this->session->set_flashdata('error', $data['result']);

							//redirect
							redirect(backend_url().'user/update/'.$user['id']);
						}else{
							$image_path = $this->upload->data('file_name');
							//resize picture
							//--------------------------------------------------------
							//param crop square
							$config['image_library'] = 'gd2';
					        $config['source_image'] = $config['upload_path'].$this->upload->data('file_name');
					        $config['create_thumb'] = FALSE;
					        $config['new_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
					 
					        $config['maintain_ratio'] = FALSE;
				        	if ($this->upload->data('image_width') < $this->upload->data('image_height')) {
						        $config['height'] = $this->upload->data('image_width');
					        	$config['width'] = $this->upload->data('image_width');
				        		$config['y_axis'] = (($this->upload->data('image_height') / 2) - ($config['height'] / 2));
				        	}else{
				        		$config['height'] = $this->upload->data('image_height');
					        	$config['width'] = $this->upload->data('image_height');
					        	$config['x_axis'] = (($this->upload->data('image_width') / 2) - ($config['width'] / 2));
				        		
				        	}

					        $this->image_lib->initialize($config);
					        
					        if (!$this->image_lib->crop())
					        {
					        	$data['result'] = array(
									'success'=>FALSE,
									'message'=>$this->upload->display_errors()
								);
					        }
					        else{
					        	//resize ori to maks 600x600
					        	$this->image_lib->clear();
					        	$config['image_library'] = 'gd2';
						        $config['source_image'] = $config['upload_path'].$this->upload->data('file_name');
						        $config['create_thumb'] = FALSE;
						        $config['new_image'] = $config['upload_path'].$this->upload->data('file_name');
						        $config['maintain_ratio'] = TRUE;
					        	$config['width'] = 600;
					        	$config['height'] = 600;

						        $this->image_lib->initialize($config);
						        if(!$this->image_lib->resize())
						        {
						        	$data['result'] = array(
										'success'=>FALSE,
										'message'=>$this->upload->display_errors()
									);
						        }
						        else{
						        	//resize medium to 200x200
						        	$this->image_lib->clear();
						        	$config['image_library'] = 'gd2';
							        $config['source_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
							        $config['create_thumb'] = FALSE;
							        $config['new_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
							        $config['maintain_ratio'] = TRUE;
							        $config['width'] = 200;
							        $config['height'] = 200;

							        $this->image_lib->initialize($config);
							        if(!$this->image_lib->resize())
							        {
							        	$data['result'] = array(
											'success'=>FALSE,
											'message'=>$this->upload->display_errors()
										);
							        }
							        else{
							        	//resize small to 50x50
							        	$this->image_lib->clear();
							        	$config['image_library'] = 'gd2';
								        $config['source_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
								        $config['create_thumb'] = FALSE;
								        $config['new_image'] = $config['upload_path'].'small_'.$this->upload->data('file_name');
								        $config['maintain_ratio'] = TRUE;
								        $config['width'] = 50;
								        $config['height'] = 50;

								        $this->image_lib->initialize($config);
								        $this->image_lib->resize();
							        }
						        }
					        }
						}
					}
					
					//setup params for table user_profile
					$params = array(
						'user_id'=>$user['id'],
						'fullname'=>$profile['fullname'],
						'email'=>$post['email'],
						'phone'=>$profile['phone'],
						'image_path'=>$image_path
					);
					
					if($this->user_profile_model->create($params)){
						
						//done
						$data['result'] = array(
							'success'=>TRUE,
							'message'=>'Data berhasil disimpan'
						);
						
						//set flash data 
						$this->session->set_flashdata('result', $data['result']);

						//redirect
						redirect(backend_url().'user/create');

					}
				}
			}
		}
			
		$data['groups'] = $this->auth_user_model->get_auth_groups();
		$data['row']['group'] = array();
		
		$data['page'] = 'backend/user/create';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
	}

	public function update($id='')
	{		
		$this->is_authenticated();
		//$this->is_authenticated();
		$data['title'] = 'Ubah Pengguna';
		//set form mode
		$data['mode'] = 'update';	
		
		//set row for updating record
		$data['row'] = $this->auth_user_model->get_row($id, array('fetch_profile'=>TRUE));
		
		//redirect if no record found
		if(!$data['row']) redirect('404');
		
		if($this->input->post()){
			
			//setup rules, takeout password
			$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email|xss_clean');
			$this->form_validation->set_rules('profile[fullname]', 'fullname', 'trim|required|xss_clean');
			$this->form_validation->set_rules('group_id', 'group', 'trim|required|xss_clean');
			$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->form_validation->run() === TRUE) {
				
				//store post variable
				$post = $this->input->post();
				
				//setup params for table auth_user
				$params = array(
					'id'=>$post['id'], 
					'username'=>$post['username'],
					'updated_date'=>date('Y-m-d H:i:s')
				);
				
				//default result
				$data['result'] = array(
					'success'=>FALSE,
					'message'=>'Terjadi kesalahan ketika menyimpan data, mohon coba lagi'
				);
				
				if($user = $this->auth_user_model->update($post['id'], $params)){
					
					//set user to group
					if($post['group_id'] > 0){
						$groups = array($post['group_id']);
						$this->auth_user_model->set_user_groups($user['id'], $groups);
					}
					
					//get post variable
					$profile = $post['profile'];
					
					//upload picture
					if ($data['row']['image_path'] == $post['attachment_path1']) {
						$image_path = $post['attachment_path1'];
					}
					elseif (!empty($_FILES['image_file']['name'])){
						$hash_name = md5($_FILES['image_file']['name'].time());
						$config['file_name'] = $hash_name;
						$config['upload_path'] = './assets/uploads/users/';
						$config['allowed_types'] = 'png|gif|jpg|jpeg'; //png|gif|jpg|avi|mp4|zip|doc
						$config['max_size']	= '4000'; //in kb
						$config['max_width']  = '4000'; //in pixel
						$config['max_height']  = '4000'; //in pixel
						$this->upload->initialize($config);

						if ( ! $this->upload->do_upload('image_file')){
							$image_path = '';
							$data['result'] = array(
								'success'=>FALSE,
								'message'=>$this->upload->display_errors()
							);
							//set flash data 
							$this->session->set_flashdata('error', $data['result']);

							//redirect
							redirect(backend_url().'user/update/'.$user['id']);
						}else{
							$image_path = $this->upload->data('file_name');
							//resize picture
							//--------------------------------------------------------
							//param crop square
							$config['image_library'] = 'gd2';
					        $config['source_image'] = $config['upload_path'].$this->upload->data('file_name');
					        $config['create_thumb'] = FALSE;
					        $config['new_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
					 
					        $config['maintain_ratio'] = FALSE;
				        	if ($this->upload->data('image_width') < $this->upload->data('image_height')) {
						        $config['height'] = $this->upload->data('image_width');
					        	$config['width'] = $this->upload->data('image_width');
				        		$config['y_axis'] = (($this->upload->data('image_height') / 2) - ($config['height'] / 2));
				        	}else{
				        		$config['height'] = $this->upload->data('image_height');
					        	$config['width'] = $this->upload->data('image_height');
					        	$config['x_axis'] = (($this->upload->data('image_width') / 2) - ($config['width'] / 2));
				        		
				        	}

					        $this->image_lib->initialize($config);
					        
					        if (!$this->image_lib->crop())
					        {
					        	$data['result'] = array(
									'success'=>FALSE,
									'message'=>$this->upload->display_errors()
								);
					        }
					        else{
					        	//resize ori to maks 600x600
					        	$this->image_lib->clear();
					        	$config['image_library'] = 'gd2';
						        $config['source_image'] = $config['upload_path'].$this->upload->data('file_name');
						        $config['create_thumb'] = FALSE;
						        $config['new_image'] = $config['upload_path'].$this->upload->data('file_name');
						        $config['maintain_ratio'] = TRUE;
					        	$config['width'] = 600;
					        	$config['height'] = 600;

						        $this->image_lib->initialize($config);
						        if(!$this->image_lib->resize())
						        {
						        	$data['result'] = array(
										'success'=>FALSE,
										'message'=>$this->upload->display_errors()
									);
						        }
						        else{
						        	//resize medium to 200x200
						        	$this->image_lib->clear();
						        	$config['image_library'] = 'gd2';
							        $config['source_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
							        $config['create_thumb'] = FALSE;
							        $config['new_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
							        $config['maintain_ratio'] = TRUE;
							        $config['width'] = 200;
							        $config['height'] = 200;

							        $this->image_lib->initialize($config);
							        if(!$this->image_lib->resize())
							        {
							        	$data['result'] = array(
											'success'=>FALSE,
											'message'=>$this->upload->display_errors()
										);
							        }
							        else{
							        	//resize small to 50x50
							        	$this->image_lib->clear();
							        	$config['image_library'] = 'gd2';
								        $config['source_image'] = $config['upload_path'].'medium_'.$this->upload->data('file_name');
								        $config['create_thumb'] = FALSE;
								        $config['new_image'] = $config['upload_path'].'small_'.$this->upload->data('file_name');
								        $config['maintain_ratio'] = TRUE;
								        $config['width'] = 50;
								        $config['height'] = 50;

								        $this->image_lib->initialize($config);
								        $this->image_lib->resize();
							        }
						        }
					        }
						}
					}
					
					//setup params for table user_profile
					$params = array(
						'user_id'=>$user['id'],
						'fullname'=>$profile['fullname'],
						'email'=>$post['email'],
						'phone'=>$profile['phone'],
						'image_path'=>$image_path,
					);
					
					if($this->user_profile_model->update($user['id'], $params)){
						//done
						$data['result'] = array(
							'success'=>TRUE,
							'message'=>'Data berhasil diedit'
						);
						
						//set flash data 
						$this->session->set_flashdata('result', $data['result']);

						//redirect
						redirect(backend_url().'user');
					}
				}
			}
		}
		$data['groups'] = $this->auth_user_model->get_auth_groups();
		$user_groups = $this->auth_user_model->get_user_group_rows($data['row']);
		$data['row']['group'] = isset($user_groups[0]) ? $user_groups[0] : array();
		$data['page'] = 'backend/user/update';
		$this->load->vars($data);
		$this->load->view('backend/layout/template_view');
	}

	public function show($id)
	{
		$this->is_authenticated();
		$data['row'] = $this->auth_user_model->get_row($id, array('fetch_profile'=>TRUE));
		$this->load->vars($data);
		$this->load->view('backend/user/show_view');
	}

	public function delete($id)
	{	
		$this->is_authenticated();
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
	public function profile()
    {
    	$this->is_authenticated();
    	//get user id active
		$user_id = $this->auth->get_user_id();
    	//get data
    	$data['row'] = $this->user_profile_model->get_row($user_id);
    	$data['group_user'] = $this->user_profile_model->get_row_group($user_id);
    	$data['group_active'] = $this->auth_user_model->get_auth_groups();

    	//get param show
    	$param = htmlspecialchars($_GET["param"]);

    	//return show to template_view
    	if ($param == 'picture') {
    		if (!empty($data['row']['image_path'])) {
    			echo base_url().'assets/uploads/users/small_'.$data['row']['image_path'];
    		}
    		else{
    			echo asset_url().'backend/img/profile_small.jpg';
    		}

    	}
    	if ($param == 'fullname') {
    		echo $data['row']['fullname'];
    	}
    	if ($param == 'group') {
    		foreach ($data['group_active'] as $group_active) {
    			if ($group_active['id'] == $data['group_user']['group_id']) {
    				echo $group_active['name']." <b class='caret'></b>";
    			}
    		}
    	}
    }
}