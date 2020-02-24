<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2>Edit Pengguna</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?php echo backend_url()?>dashboard"> Dashboard</a>
			</li>
			<li class="breadcrumb-item">Pengguna</li>
			<li class="breadcrumb-item">
				<a href="<?php echo backend_url()?>group">Daftar Pengguna</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Edit</strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-lg-12">
        	<?php $this->load->view('message_error_view')?>
			<?php $this->load->view('message_success_view')?>
			<div class="ibox">
				<div class="ibox-content">
					<?php $this->load->view('backend/user/form_view', $row)?>
				</div>
			</div>
		</div>
	</div>
</div>