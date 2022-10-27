<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: http://95.179.236.117/?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');
$query = $_GET;
?>
<div class="content-wrapper h100vh">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		<?php echo(t_get_val('Clients')); ?>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?php echo(t_get_val('Home')); ?></a></li>
		<li class="active"><?php echo(t_get_val('Clients')); ?></li>
	  </ol>
	</section>
	<!-- Main content -->
    <section class="content">
<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
			
				<pre2>
				<?php 
					//print_r(users_list());
					?>
				</pre2>
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                <thead>
                <tr role="row">
					<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('E-mail')); ?></th>
					<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Wallet')); ?></th>
					<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"><?php echo(t_get_val('Reg. date')); ?></th>
				</tr>
                </thead>
                <tbody>
					<?php 
					$all_users = users_list();
					$i = 'odd';
					$edit_url = ['subaction'=>'user_show'];
					
					foreach($all_users as $user){
						//print_r($user);
						$edit_url['uid'] = $user['_id'];
						?>
						<tr role="row" class="<?php echo($i); ?>">
						  <td class=""><a href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo($user['email']); ?></a></td>
						  <td class=""><?php echo($user['wallet']); ?></td>
						  <td><?php echo(date('m.d.Y H:i',$user['created_ts'])); ?></td>
						 
						</tr>
						<?php
						if($i == 'odd'){
							$i = 'even';
						}else{
							$i = 'odd';
						}
						$time = $user['created_ts'];
					}
					
					?>
					
				</tbody>
                <tfoot>
                <tr>
					<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('E-mail')); ?></th>
					<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('Wallet')); ?></th>
					<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"><?php echo(t_get_val('Reg. date')); ?></th>
				</tr>
                </tfoot>
              </table></div></div>
			  
			 </div>
            </div>
            <!-- /.box-body -->
          </div>
	</section>
</div>
<script>
  $(function () {
    $('#example2').DataTable()
    $('#example1').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>