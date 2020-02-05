<?php if(validation_errors() || (isset($result) && !$result['success']) ):?>
<div class="alert alert-danger alert-dismissable bg-danger widget-error">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<h2><i class="fa fa-warning"></i> ERROR</h2>
	<?php echo validation_errors(); ?>
	<?php echo isset($result['message']) ? $result['message'] : ''; ?>
</div>
<?php endif; ?>