<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
    	<span aria-hidden="true">×</span><span class="sr-only">Close</span>
    </button>
</div>
<div class="modal-body">
	<table class="table" style="border-top: 0px;">
	    <tbody>
	    <tr>
	        <td><strong>Judul</strong></td>
	        <td><p><?php echo $row['name']; ?></p></td>

	    </tr>
	    <tr>
	        <td><strong>Deskripsi</strong></td>
	        <td><p><?php echo $row['description']; ?></p></td>
	    </tr>
	    <tr>
	        <td><strong>Akses</strong></td>
	        <td>								
<?php foreach($group_permissions as $item):?>
				<span class="tag label label-primary"><?php echo $item ?></span>
<?php endforeach;?>
			</td>
	    </tr>
	    </tbody>
	</table>
</div>

<div class="modal-footer">
    <a href="<?php echo backend_url()?>group/update/<?php echo $row['id']?>" title="Edit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
    <button type="button" class="btn btn-outline btn-danger" data-dismiss="modal">Close</button>
</div>
