 <?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: http://95.179.236.117/?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');
$query = $_GET;
if(isset($_GET['uid'])){
	$uid = new MongoDB\BSON\ObjectId ($_GET['uid']);
	$current_user = users_list(['_id'=>$uid]);
}
if(isset($_GET['uwallet'])){
	$uwallet = $_GET['uwallet'];
	$current_user = users_list(['wallet'=>$uwallet]);
}
if(isset($_GET['email'])){
	$uemail = $_GET['email'];
	$current_user = users_list(['email'=>$uemail]);
}
$current_user = $current_user[0];
?>  
	
<div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('User Profile')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> <?php echo(t_get_val('Home')); ?></a></li>
			<li class="active"><?php echo(t_get_val('User Profile')); ?></li>
		  </ol>
		</section>
		    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-lg-4 col-md-5 col-sm-5">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <h3 class="profile-username text-center"><?php echo($current_user['email']); ?></h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('BTC Wallet')); ?></b></p>
					<p class="text-center"><?php echo($current_user['wallet']); ?></p>
                </li> 
				<li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('Balance')); ?></b></p>
					<p class="text-center"><?php 
					print_r(user_get_balance($current_user['_id']));
					//echo($_SESSION['wallet']); 
					?></p>
                </li>
              </ul>
			  <div class="col-xs-12">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('Name')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<?php echo(lang_input('text', 'name', 'form-control',false,true,'Name',false,false,$current_user['name'],true)); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('City')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
								<?php echo(lang_input('text', 'city', 'form-control',false,false,'City',false,false,$current_user['city'],true)); ?>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('Phone')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-phone"></i></span>
								<?php echo(lang_input('text', 'phone', 'form-control',false,true,'Phone',false,false,$current_user['phone'],true)); ?>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('Telegram')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa  fa-location-arrow"></i></span>
								<?php echo(lang_input('text', 'telegram', 'form-control',false,true,'Telegram',false,false,$current_user['telegram'],true)); ?>
							</div>
						</div>
					</div>
			  </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
		<div class="col-lg-8 col-md-7 col-sm-7">
		<?php 
		$last_trans = txs_list_by(['$or' => [['from_address' => $current_user['wallet']], ['to_address' => $current_user['wallet']]]], ['time_ts' => -1]);
		//print_r(txs_list_by());
		//print_r (txs_list_by (['$or' => [['from_address' => $_SESSION['wallet']], ['to_address' => $_SESSION['wallet']]]], ['time_ts' => -1]))
		?>
		<pre2>
		<?php //print_r($last_trans); ?>
		</pre2>
		<div class="box box-primary">
			 <div class="box-header">
              <h3 class="box-title"><?php echo(t_get_val('Transactions history')); ?></h3>
            </div>
			<div class="box-body box-profile">
				<div class="tx_wrapper tx_wrapper_table" id="user_tranz_wrapper">
					<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
						<thead>
							<tr role="row">
								<th class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ></th>
							</tr>
						</thead>
						<tbody>
				<?php 
				//Выводим транзакции
				
				foreach($last_trans as $txs){
					?>
					<tr role="row" class="<?php echo($i); ?>">
						<td style="padding:0;">
							<?php show_cabinet_tx($txs); ?>
						</td>
					</tr>
					<?php
					
				}
				
				?>
						</tbody>
					</table>
				</div>

			</div>
		<!-- /.box-body -->
	  </div>
		</div>
	</div>
	</section>
</div>
	<script>
	  $(function () {
		$('#example2').DataTable({
			'ordering'    : false,
			'lengthChange': false,
			'searching'   : false,
		});
	  });
	</script>