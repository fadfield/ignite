<?php $result = $this->session->flashdata('result');?>
<?php if(isset($result) && $result['success']):?>
<div class="alert alert-success alert-dismissable bg-success widget-success">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h2><i class="fa fa-check-square"></i> <?php echo $this->lang->line('success_title')?></h2>
	<?php echo isset($result['message']) ? $result['message'] : ''; ?>
</div>
<?php endif; ?>