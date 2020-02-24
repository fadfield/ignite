<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">
    	<span aria-hidden="true">×</span><span class="sr-only">Close</span>
    </button>
</div>
<div class="modal-body">
	<table class="table" style="border-top: 0px;">
	    <tbody>
	    	<tr>
	        <td><strong>Foto</strong></td>
	        <td><p>
		        <?php if(!empty($row['image_path'])): ?>
		            <a data-toggle="modal" data-target="#myModal5">
		                <img style="height: 150px; border-radius: 100%;" src="<?php echo assets_url().'uploads/users/medium_'.$row['image_path']?>" zoom="<?php echo assets_url().'uploads/users/'.$row['image_path']?>" class="getSrc">
		            </a>
		        <?php endif; ?>
		        <?php if(empty($row['image_path'])): ?>
		            <button class="btn btn-warning btn-xs" type="button"><i class="fa fa-file-text"></i> Tidak ada Foto</button>
		        <?php endif; ?>
	        	</p>
	        </td>
	    </tr>
	    <tr>
	        <td><strong>Username</strong></td>
	        <td><p><?php echo $row['username']; ?></p></td>
	    </tr>
	    <tr>
	        <td><strong>Email</strong></td>
	        <td><p><?php echo $row['email']; ?></p></td>
	    </tr>
	    <tr>
	        <td><strong>Grup</strong></td>
	        <td><p><?php echo $row['group_name']; ?></p></td>
	    </tr>
	    <tr>
	        <td><strong>Nama</strong></td>
	        <td><p><?php echo $row['fullname']; ?></p></td>
	    </tr>
	    <tr>
	        <td><strong>No. HP</strong></td>
	        <td><p><?php echo $row['phone']; ?></p></td>
	    </tr>
	    </tbody>
	</table>
</div>

<div class="modal-footer">
    <a href="<?php echo backend_url()?>user/update/<?php echo $row['id']?>" title="Edit" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
    <button type="button" class="btn btn-outline btn-danger" data-dismiss="modal">Close</button>
</div>