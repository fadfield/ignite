<form class="form-horizontal" method="post">
    <div class="form-group<?php echo (form_error('name')) ? ' has-error' : ''?> row">
        <label class="col-sm-2 control-label">Nama<br><small class="text-navy">Harus Diisi</small></label>
        <div class="col-sm-4"><input type="text" name="name" value="<?php echo set_value('name', @$row['name']); ?>" class="form-control" required="required"></div>
    	<?php echo form_error('name'); ?>
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group<?php echo (form_error('description')) ? ' has-error' : ''?> row">
        <label class="col-sm-2 control-label">Deskripsi</label>
        <div class="col-sm-6">
            <textarea name="description" class="form-control">
<?php echo set_value('description', @$row['description']); ?></textarea>
        </div>
<!--         <div class="col-sm-8"><input type="text" name="description" value="<?php echo set_value('description', @$row['description']); ?>" class="form-control"></div>
    	<?php echo form_error('description'); ?> -->
    </div>
    <div class="hr-line-dashed"></div>
    <div class="form-group row">
        <label class="col-sm-2 control-label">Akses</label>
<?php $i=1;$x=1;?>
<?php foreach($permission as $item):?>
<?php if($i==1):?>
        <div class="col-sm-4">
<?php endif;?>        
            <div class="i-checks"><label> <input type="checkbox" value="<?php echo $item['id']?>" name="permissions[]" <?php if(in_array($item['name'], $group_permissions)) echo 'checked'?>> <i></i> <?php echo $item['description']?> </label></div>
<?php if($i>=8 || $x == count($permission)):?>        
        </div>
<?php $i=1; else: $i++; endif; $x++; ?>        
<?php endforeach;?>
        
       
    </div>						
    <div class="hr-line-dashed"></div>
    <div class="form-group">
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
		window.location.href='<?php echo backend_url()?>group';
	});
});
</script>