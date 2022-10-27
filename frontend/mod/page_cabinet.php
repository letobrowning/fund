<?php
if(!isset($_SESSION['email']) OR strlen($_SESSION['email']) == 0){
	header('Location: http://95.179.236.117/?action=login');
}
$user_id_to_edit = new MongoDB\BSON\ObjectId ($_SESSION['uid']);
if($_POST){
	$result_update = users_modify(['_id'=>$user_id_to_edit],$_POST);
	if($result_update < 0){
		//print_r($result);
		$error = '';
		switch ($result) {
			case -1:
				$error = t_get_val('Wrong data');
				break;
			default:
				$error = t_get_val('Error');
				break;
		}
		$errorF = true;
	}else{
		$errorF = false;
		$error = t_get_val('Update success');
	}
}

$current_user = users_list(['_id'=>$user_id_to_edit]);
$current_user = $current_user[0];
//print_r($_COOKIE);
?>
<?php include($basedir . '/frontend/sidebar.php'); ?>
    <div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('User Profile')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i><?php echo(t_get_val('Home')); ?></a></li>
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

              <h3 class="profile-username text-center"><?php echo($_SESSION['email']); ?></h3>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('user BTC Wallet')); ?></b></p>
					<p class="text-center"><?php echo($_SESSION['wallet']); ?></p>
                </li> 
				<li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('user Balance')); ?></b></p>
					<p class="text-center"><?php 
					echo(sprintf('%.8f',user_get_balance($_SESSION['uid'])));
					//echo($_SESSION['wallet']); 
					?> btc</p>
                </li>
              </ul>
			 <!-- (контакты с указанием типа (телега, телефон, ...), имя, город (необяз)) -->
			  <div class="col-xs-12">
				
				<form class="form" method="POST" role="form">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('Name')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<?php echo(lang_input('text', 'name', 'form-control',false,true,'Name',false,false,$current_user['name'])); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('City')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
								<?php echo(lang_input('text', 'city', 'form-control',false,false,'City',false,false,$current_user['city'])); ?>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('Phone')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-phone"></i></span>
								<?php echo(lang_input('text', 'phone', 'form-control',false,true,'Phone',false,false,$current_user['phone'])); ?>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<label for="inputEmail3" class="col-sm-4 control-label npl"><?php echo(t_get_val('Telegram')); ?></label>
						<div class="col-xs-12 npl npr mb15">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa  fa-location-arrow"></i></span>
								<?php echo(lang_input('text', 'telegram', 'form-control',false,true,'Telegram',false,false,$current_user['telegram'])); ?>
							</div>
						</div>
					</div>
					<div class="col-xs-12 npl npr">
					<?php 
						if($_POST){
						  if($errorF){
							  ?>
							  <div class="alert alert-danger alert-dismissible">
								<?php echo($error); ?>
							  </div>
							  <?php
						  }else{
							  
							  ?>
							  <div class="alert alert-success alert-dismissible">
								<?php echo($error); ?>
							  </div>
							  <?php
						  }
						}
					?>
					</div>
					<button type="submit" class="btn btn-info pull-right"><?php echo(t_get_val('Update')); ?></button>
				</form>
			  </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
		<div class="col-lg-8 col-md-7 col-sm-7">
		<?php 
		$last_trans = txs_list_by(['$or' => [['from_address' => $_SESSION['wallet']], ['to_address' => $_SESSION['wallet']]]], ['sort' => ['time_ts' => -1]]);
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
	<script>
	  $(function () {
		$('#example2').DataTable({
			'ordering'    : false,
			'lengthChange': false,
			'searching'   : false,
		});
	  });
	</script>