<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
<?php if($mode=='update'):?>
<input name="id" type="hidden" value="<?php echo set_value('id', @$row['id']); ?>" />
<?php endif; ?>
	<div class="form-group<?php echo (form_error('username')) ? ' has-error' : ''?> row">
		<label class="col-sm-2 control-label">Username<br><small class="text-navy">Harus diisi</small></label>
		<div class="col-sm-4">
			<input type="text" name="username" value="<?php echo set_value('username', @$row['username']); ?>" class="form-control">
			<?php echo form_error('username'); ?>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group<?php echo (form_error('username')) ? ' has-error' : ''?> row">
		<label class="col-sm-2 control-label">Email<br><small class="text-navy">Harus diisi</small></label>
		<div class="col-sm-4">
			<input type="email" name="email" value="<?php echo set_value('email', @$row['email']); ?>" class="form-control">
			<?php echo form_error('username'); ?>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
<?php if($mode=='create'):?>
	<div class="form-group<?php echo (form_error('password')) ? ' has-error' : ''?> row">
		<label class="col-sm-2 control-label">Password<br><small class="text-navy">Harus diisi</small></label>
		<div class="col-sm-4">
			<input type="password" name="password" value="<?php echo set_value('password'); ?>" class="form-control">
			<?php echo form_error('password'); ?>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group<?php echo (form_error('confirm_password')) ? ' has-error' : ''?> row">
		<label class="col-sm-2 control-label">Konfrim Password<br><small class="text-navy">Harus diisi</small></label>
		<div class="col-sm-4">
			<input type="password" name="confirm_password" value="<?php echo set_value('confirm_password'); ?>" class="form-control">
			<?php echo form_error('confirm_password'); ?>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
<?php endif; ?>
<?php if($mode=='update'):?>
	<div class="form-group row">
		<label class="col-sm-2 control-label">Password</label>
		<div class="col-sm-4">
			<a type="button" class="btn btn-warning" href="<?php echo backend_url()?>user/update-password/<?php echo $row['id']?>">Ubah Password</a>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
<?php endif; ?>
	<div class="form-group<?php echo (form_error('profile[fullname]')) ? ' has-error' : ''?> row">
		<label class="col-sm-2 control-label">Nama Lengkap<br><small class="text-navy">Harus diisi</small></label>
		<div class="col-sm-6">
			<input type="text" name="profile[fullname]" value="<?php echo set_value('profile[fullname]', @$row['fullname']); ?>" class="form-control">
			<?php echo form_error('profile[fullname]'); ?>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group<?php echo (form_error('group_id')) ? ' has-error' : ''?> row">
		<label class="col-sm-2 control-label">Grup<br><small class="text-navy">Harus diisi</small></label>
		<div class="col-sm-4">
		<select name="group_id" class="chosen-select">
			<option value="" selected disabled>Pilih Grup</option>
<?php foreach($groups as $group):?>
			<option value="<?php echo $group['id']?>" 
<?php if(set_value('group_id', @$row['group']['id']) == $group['id']) echo' selected'?>>
	<?php echo $group['name']?>
			</option>
<?php endforeach; ?>
		</select>
		<?php echo form_error('group_id'); ?>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group row">
		<label class="col-sm-2 control-label">No. HP</label>
		<div class="col-sm-4"><input type="text" name="profile[phone]" value="<?php echo set_value('profile[phone]', @$row['phone']); ?>" class="form-control"></div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group row">
		<label class="col-sm-2 control-label">Foto</label>
		<div class="col-sm-6">
		<input id="image_file_id" name="image_file" type="file" style="display: none;">
		<div class="input-group m-b">
			<span class="input-group-btn">
			<button id="button-remove1" type="button" class="btn btn-danger" style="display:none;"><i class="fa fa-trash-o fa-lg"></i></button></span>
			<input readonly name="attachment_path1" type="text" value="<?php echo str_replace('assets/uploads/', '', set_value('attachment_path1', @$row['image_path'])); ?>" class="form-control">
			<span class="input-group-btn">
			<button id="button-upload1" type="button" class="btn btn-default">Pilih gambar</button></span>
		</div>
		</div>
	</div>
<?php if($mode=='update'):?>
	<div class="form-group row">
		<div class="col-sm-2 control-label"></div>
		<div id="image-preview" class="col-sm-6">
			<?php if(!empty($row['image_path'])): ?>
			<a data-toggle="modal" data-target="#myModal5">
			<img style="height: 150px; border-radius: 1%;" src="<?php echo assets_url().'uploads/users/medium_'.$row['image_path']?>" zoom="<?php echo assets_url().'uploads/users/'.$row['image_path']?>" class="getSrc">
			</a>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>
	<div class="hr-line-dashed"></div>
	<div class="form-group row">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-6">
			<div class="btn-group">
            	<input name="id" id="id" type="hidden" value="<?php echo @$row['id']?>" />
                <button id="cancel" type="button" class="btn btn-default">Kembali Ke Daftar</button>
                <button id="submit" type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</div>
	</div>
</form>
<script>		
$(document).ready(function(){
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
	
	$('.chosen-select').chosen({width: "100%"});
	
	$('#cancel').click(function(){
		window.location.href='<?php echo backend_url()?>user';
	});
	//upload handler
	$('#button-upload1').click(function(){$('#image_file_id').click();});
	$('input[name=image_file]').change(function() {
	var filename1 = $('#image_file_id').val().replace(/C:\\fakepath\\/i, '')
	$file1.val( filename1 );
	});

	var $file1 = $('input[name=attachment_path1]');
 	var file1 = $('input[name=attachment_path1]').val();
	    if (file1)
	        $('#button-remove1').show();
	    else
	        $('#button-remove1').hide();

	$('input[name=image_file]').on('change', function(evt) {
	    var file1 = evt.target.files[0];
	    if (file1)
	        $('#button-remove1').show(),
	    	$('#file-attachment1').hide();
	    else
	        $('#button-remove1').hide();
	});

	$('#button-remove1').click(function(){
		$('input[name=attachment_path1]').val('');
		$('input[name=image_file]').val('');
		$('#file-attachment1').hide();
		$('#button-remove1').hide();
		$('#image-preview').hide();
	});
});
</script>