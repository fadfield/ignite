<?php $result = $this->session->flashdata('result');?>
<?php if(isset($result) && $result['success']):?>
<!-- 	<script>
    $(document).ready(function() {
	    setTimeout(function() {
	        toastr.options = {
	            closeButton: true,
	            progressBar: false,
	            timeOut: 3000,
				preventDuplicates: false,
				positionClass: 'toast-bottom-right',
				showDuration: 100,
				hideDuration: 100,
				showEasing: 'swing',
				hideEasing: 'linear',
				showMethod: 'fadeIn',
				hideMethod: 'fadeOut'
	        };
	        toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

	    }, 1300);
    });
    </script> -->
<div class="alert alert-success alert-dismissable">
	<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
	<b><i class="fa fa-check-square"></i> SUKSES</b> <?php echo isset($result['message']) ? $result['message'] : ''; ?>
</div>
<?php endif; ?>