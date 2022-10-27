<?php
if(!isset($_SESSION['email'])){
	header('Location: http://95.179.236.117/?action=login');
}
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
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
					<p class="text-muted text-center"><b><?php echo(t_get_val('BTC Wallet')); ?></b></p>
					<p class="text-center"><?php echo($_SESSION['wallet']); ?></p>
                </li> 
				<li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('Balance')); ?></b></p>
					<p class="text-center"><?php 
					print_r(user_get_balance($_SESSION['uid']));
					//echo($_SESSION['wallet']); 
					?></p>
                </li>
              </ul>
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
					<div class="col-sm-12 tx_row" >
						
						<div class="row">
							<?php 
							if($txs->plan_tx_status){
								?>
								<div class="col-sm-12 pb5">
									<span class="label <?php echo($plan_tx_status_name[$txs->plan_tx_status][1]); ?>"><?php echo($plan_tx_status_name[$txs->plan_tx_status][0]); ?></span>
								</div>
								<?php
							}
							
							?>
						</div>
						<div class="row">
							<div class="col-sm-4">
								<div class="row">
									<div class="col-sm-5"><b>Type</b></div>
									<div class="col-sm-7">
										<?php echo($trans_types_name[$txs->tx_type]); ?>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-5"><b>Time</b></div>
									<div class="col-sm-7"><?php echo(date('d.m.Y H:i',$txs->time_ts)); ?></div>
								</div>
							</div>
							<?php if($txs->amount > 0){ ?>
							<div class="col-sm-4">
								<div class="row">
									<div class="col-sm-5"><b>Amount</b></div>
									<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->amount)); ?></div>
								</div>
								<?php if($txs->tx_type == TX_TYPE_DEPOSIT_TOPUP){ ?>
								<div class="row">
									<div class="col-sm-5"><b>Fee</b></div>
									<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_in->fee_amount)); ?></div>
								</div>
								<?php } ?>
								<?php if($txs->tx_type == TX_TYPE_PLAN_TOPUP){ ?>
								<div class="row">
									<div class="col-sm-5"><b>Fee</b></div>
									<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_out->fee_amount)); ?></div>
								</div>
								<?php } ?>
								<?php if($txs->tx_type == TX_TYPE_PLAN_REVERT OR $txs->tx_type == TX_TYPE_DEPOSIT_WITHDRAW){ 
								//print_r($txs);
								?>
								<div class="row">
									<div class="col-sm-5"><b>Fee</b></div>
									<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_out)); ?></div>
								</div>
								<?php } ?>
								<?php if($txs->tx_type == TX_TYPE_PLAN_WITHDRAW){ 
								//print_r($txs);
								?>
								<div class="row">
									<div class="col-sm-5"><b>Fee</b></div>
									<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_in->fee_amount)); ?></div>
								</div>
								<?php } ?>
							</div>
							<?php }else{ 
									if($txs->plan_tx_status AND $txs->plan_tx_status == STATUS_REJECTED){
							?>
									<div class="col-sm-4">
										<div class="row">
											<div class="col-sm-12"><b>Причина отказа</b></div>
											<div class="col-sm-12"><?php echo($txs->cause); ?></div>
										</div>
									</div>
							
								<?php 	}
							
									} ?>
							<div class="col-sm-4">
								
								<div class="row">
									<div class="col-sm-5"><b>Confirmations</b></div>
									<div class="col-sm-7"><?php echo($txs->confirmations); ?></div>
								</div>
								<?php if($txs->tx_id){ ?>
								<div class="row">
									<div class="col-sm-7 pull-right"><a target="blank_" class="label label-info" href="https://www.blockchain.com/ru/btc/tx/<?php echo($txs->tx_id); ?>">More info</a></div>
								</div>
								<?php } ?>
								<?php if($txs->tx_type == TX_TYPE_PLAN_REVERT OR $txs->tx_type == TX_TYPE_PLAN_WITHDRAW OR $txs->tx_type == TX_TYPE_PLAN_TOPUP){ ?>
								
								<?php 
								//Получим название плана
								$plan_id = new MongoDB\BSON\ObjectId ($txs->plan_id);
								$current_plan = plans_list_by(['_id'=>$plan_id]);
								$current_plan = $current_plan[0];
								?>
								
								<div class="row">
									<div class="col-sm-5"><b>Plan</b></div>
									<div class="col-sm-7"><?php echo($current_plan->name); ?></div>
								</div>
								<?php } ?>
								
							</div>
							<?php if($txs->tx_type == TX_TYPE_PLAN_REVERT){ ?>
									<div class="col-sm-12 pt15">
										<div class="alert alert-danger alert-dismissible">
											 <b>TX ID </b><?php echo((string)$txs->to_tx__id); ?><br>
											 <div><b>Причина отказа</b></div>
											 <?php echo($txs->cause); ?>
										</div>
									</div>
							<?php } ?>
							<?php if($txs->tx_type == TX_TYPE_PLAN_TOPUP){ ?>
								<!--	<div class="col-sm-12 pt15">
										<div class="alert alert-info  alert-dismissible">
											 <b>TX ID </b><?php echo((string)$txs->_id); ?><br>
										</div>
									</div> -->
							<?php } ?>
						</div>
						
					</div>
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