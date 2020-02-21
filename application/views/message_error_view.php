<?php if(validation_errors() || (isset($result) && !$result['success']) ):?>
<?php echo validation_errors(); ?>
	<script>
    $(document).ready(function() {
	    setTimeout(function() {
	        toastr.options = {
	            closeButton: true,
	            progressBar: true,
	            timeOut: 4000,
				preventDuplicates: false,
				positionClass: 'toast-bottom-right',
				showDuration: 100,
				hideDuration: 100,
				showEasing: 'swing',
				hideEasing: 'linear',
				showMethod: 'fadeIn',
				hideMethod: 'fadeOut'
	        };
	        toastr.error('<?php echo isset($result['message']) ? $result['message'] : ''; ?>', '<b><i class="fa fa-warning"></i> ERROR</b>');

	    }, 1300);
    });
    </script>
<!-- <div class="alert alert-danger alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<b><i class="fa fa-warning"></i> ERROR</b>
	<?php echo validation_errors(); ?>
	<?php echo isset($result['message']) ? $result['message'] : ''; ?>
</div> -->
<?php endif; ?>