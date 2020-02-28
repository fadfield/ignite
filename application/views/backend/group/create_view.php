<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2>Tambah Grup Baru</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="<?php echo backend_url()?>dashboard"> Dashboard</a>
			</li>
			<li class="breadcrumb-item">Daftar Pengguna</li>
			<li class="breadcrumb-item">
				<a href="<?php echo backend_url()?>group">Grup</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Tambah Baru</strong>
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
					<?php $this->load->view('backend/group/form_view', $row)?>
				</div>
			</div>
		</div>
	</div>
</div>
