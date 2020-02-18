<?php $result = $this->session->flashdata('result');?>
<?php if(isset($result) && $result['success']):?>
<div class="alert alert-primary alert-dismissable bg-primary widget-primary">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h2><i class="fa fa-check-square"></i> SUKSES</h2>
	<?php echo isset($result['message']) ? $result['message'] : ''; ?>
</div>
<?php endif; ?>