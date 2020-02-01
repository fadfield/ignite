<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Daftar Pengguna</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?php echo backend_url()?>">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a>Pengguna</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Daftar Pengguna</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
    <div class="row">
        <div class="col-lg-12">
            <?php $this->load->view('message_error_view')?>
            <?php $this->load->view('message_success_view')?>
            <div class="ibox">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover datatable" >
                            <thead>
                                <tr>
                                    <th class="fit">ID</th>
                                    <!-- <th>Status</th> -->
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Grup</th>
                                    <th width="48">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
<?php foreach($rows as $row):?>
                                <tr>
                                    <td class="text-right"><?php echo $row['id']?></td>
                                    <!-- <td><?php //echo get_label_status(get_state($row['state']))?></td> -->
                                    <td><?php echo $row['username']?></td>
                                    <td><?php echo $row['profile_fullname']?></td>
                                    <td><?php echo $row['group_name']?></td>
                                    <td class="center">
                                        <div class="btn-group">
                                            <a href="<?php echo backend_url()?>user/show/<?php echo $row['id']?>" title="<?php echo $this->lang->line('crud_view')?>" class="btn-white btn btn-xs"><i class="fa fa-eye"></i></a>
                                            <a href="<?php echo backend_url()?>user/update/<?php echo $row['id']?>" title="<?php echo $this->lang->line('crud_update')?>" class="btn-white btn btn-xs"><i class="fa fa-edit"></i></a>
                                            <a href="<?php echo backend_url()?>user/delete/<?php echo $row['id']?>" title="<?php echo $this->lang->line('crud_delete')?>" class="btn-white btn btn-xs delete"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
<?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="fit">ID</th>
                                    <!-- <th>Status</th> -->
                                    <th>Username</th>
                                    <th>Nama</th>
                                    <th>Grup</th>
                                    <th width="48">Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
    
    $('.datatable').DataTable({
        pageLength: 25,
        responsive: true,
        initComplete: function(){
            $('div.toolbar').html('<button class="btn btn-sm btn-primary pull-left" id="button-add" type="button"><strong><i class="fa fa-plus"></i> Tambah Baru</strong></button>');
            $('#button-add').click(function(){
                window.location.href = '<?php echo backend_url()?>category/create';
            });
        },
        dom: '<"toolbar"><"html5buttons"B>fgtlpi',
        buttons: [
            {extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'Category List'},
            {extend: 'pdf', title: 'Category List'},
            {extend: 'print',
                 customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                }
            }
        ]
    });
});



</script>