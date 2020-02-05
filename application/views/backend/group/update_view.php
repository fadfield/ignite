
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-12">
		<h2><?php echo translate('crud_update')?> <?php echo translate('group')?></h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo backend_url()?>dashboard"><?php echo translate('dashboard')?></a>
			</li>
			<li><?php echo translate('user')?></li>
			<li>
				<a href="<?php echo backend_url()?>group"><?php echo translate('group')?></a>
			</li>
			<li class="active">
				<strong><?php echo translate('crud_update')?></strong>
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
