<?php if(validation_errors() || (isset($result) && !$result['success']) ):?>
<div class="alert alert-danger alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<b><i class="fa fa-warning"></i> ERROR</b>
	<?php echo validation_errors(); ?>
	<?php echo isset($result['message']) ? $result['message'] : ''; ?>
</div>
<?php endif; ?>