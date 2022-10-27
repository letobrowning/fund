<?php include($basedir . '/frontend/sidebar_admin.php'); ?>
<?php
if($_POST){
	print_r($_POST);
	$plan_arr = array();
	if(strpos($_POST['tx_fee_user_topup'],'%') > 0){
		if(strlen($_POST['tx_fee_user_topup_min']) > 0){
			$plan_arr['tx_fee_user_topup'] = $_POST['tx_fee_user_topup'].'/'.$_POST['tx_fee_user_topup_min'];
		}else{
			$plan_arr['tx_fee_user_topup'] = $_POST['tx_fee_user_topup'];
		}
	}else{
		$plan_arr['tx_fee_user_topup'] = (float)$_POST['tx_fee_user_topup'];
	}
	
	if(strpos($_POST['tx_fee_user_withdraw'],'%') > 0){
		if(strlen($_POST['tx_fee_user_withdraw_min']) > 0){
			$plan_arr['tx_fee_user_withdraw'] = $_POST['tx_fee_user_withdraw'].'/'.$_POST['tx_fee_user_withdraw_min'];
		}else{
			$plan_arr['tx_fee_user_withdraw'] = $_POST['tx_fee_user_withdraw'];
		}
	}else{
		$plan_arr['tx_fee_user_withdraw'] = (float)$_POST['tx_fee_user_withdraw'];
	}
	db_option_set('tx_fee_user_topup',$plan_arr['tx_fee_user_topup']);
	db_option_set('tx_fee_user_withdraw',$plan_arr['tx_fee_user_withdraw']);
	db_option_set('btc_settxfee',(float)$_POST['btc_settxfee']);
	db_option_set('admin_withdrawal_magic_fee',(float)$_POST['withdrawal_magic_fee']);
	btc_settxfee((float)$_POST['btc_settxfee']);
}
?>
<div class="content-wrapper h100vh">
	<section class="content">
      <div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo(t_get_val('System fee')); ?></h3>
				</div>
				<div class="box-body ">
					<form class="form-horizontal" method="POST" role="form">
						<div class="form-group row">
							<?php 
							$current_fee = db_option_get('tx_fee_user_topup');
							//echo(strpos('%',$current_plan->tx_fee_plan_topup));
							//echo();
							if(strpos($current_fee,'%') > 0){
								$temp = explode('/',$current_fee);
								if(count($temp) > 1){
							?>
							  <div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Topup')); ?></label>
								<input type="text" name="tx_fee_user_topup" class="form-control percent_min" placeholder="Fee User Topup" required value="<?php echo($temp[0]); ?>">
							  </div>
							  <div class="col-sm-6 min_input_div" =>
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Topup Min')); ?></label>
								<input type="text" name="tx_fee_user_topup_min" class="form-control" placeholder="Fee User Topup Min" value="<?php echo(sprintf('%.8f',$temp[1])); ?>">
							  </div>
							<?php 
								}else{
									?>
									<div class="col-sm-6">
										<label for="inputEmail3"><?php echo(t_get_val('Fee User Topup')); ?></label>
										<input type="text" name="tx_fee_user_topup" class="form-control percent_min" placeholder="Fee User Topup" required value="<?php echo($current_fee); ?>">
									 </div>
									<div class="col-sm-6 min_input_div">
										<label for="inputEmail3"><?php echo(t_get_val('Fee User Topup Min')); ?></label>
										<input type="text" name="tx_fee_user_topup_min" class="form-control" placeholder="Fee User Topup Min">
									 </div>
									<?php
								}
							
							
							}else{ ?>
							  <div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Topup')); ?></label>
								<input type="text" name="tx_fee_user_topup" class="form-control percent_min" placeholder="Fee User Topup" required value="<?php echo(sprintf('%.8f',$current_fee)); ?>">
							  </div>
							  <div class="col-sm-6 min_input_div" style="display:none;">
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Topup Min')); ?></label>
								<input type="text" name="tx_fee_user_topup_min" class="form-control" placeholder="Fee User Topup Min" >
							  </div>								
							<?php } ?>
						</div>
						
						
						<div class="form-group row">
							<?php 
							$current_fee = db_option_get('tx_fee_user_withdraw');
							//echo(strpos('%',$current_plan->tx_fee_plan_topup));
							//echo();
							if(strpos($current_fee,'%') > 0){
								$temp = explode('/',$current_fee);
								if(count($temp) > 1){
							?>
							  <div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Withdraw')); ?></label>
								<input type="text" name="tx_fee_user_withdraw" class="form-control percent_min" placeholder="Fee User Withdraw" required value="<?php echo($temp[0]); ?>">
							  </div>
							  <div class="col-sm-6 min_input_div" =>
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Withdraw Min')); ?></label>
								<input type="text" name="tx_fee_user_withdraw_min" class="form-control" placeholder="Fee User Withdraw Min" value="<?php echo(sprintf('%.8f',$temp[1])); ?>">
							  </div>
							<?php 
								}else{
									?>
									<div class="col-sm-6">
										<label for="inputEmail3"><?php echo(t_get_val('Fee User Withdraw')); ?></label>
										<input type="text" name="tx_fee_user_withdraw" class="form-control percent_min" placeholder="Fee User Withdraw" required value="<?php echo($current_fee); ?>">
									 </div>
									<div class="col-sm-6 min_input_div">
										<label for="inputEmail3"><?php echo(t_get_val('Fee User Withdraw Min')); ?></label>
										<input type="text" name="tx_fee_user_withdraw_min" class="form-control" placeholder="Fee User Withdraw Min">
									 </div>
									<?php
								}
							
							
							}else{ ?>
							  <div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Withdraw')); ?></label>
								<input type="text" name="tx_fee_user_withdraw" class="form-control percent_min" placeholder="Fee User Withdraw" required value="<?php echo(sprintf('%.8f',$current_fee)); ?>">
							  </div>
							  <div class="col-sm-6 min_input_div" style="display:none;">
								<label for="inputEmail3"><?php echo(t_get_val('Fee User Withdraw Min')); ?></label>
								<input type="text" name="tx_fee_user_withdraw_min" class="form-control" placeholder="Fee User Withdraw Min" >
							  </div>								
							<?php } ?>
						</div>
						
						
						<div class="form-group row">
							<?php 
							$current_fee = db_option_get('btc_settxfee');
							//echo(strpos('%',$current_plan->tx_fee_plan_topup));
							//echo();
							?>
							<div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('BTC Fee Tx')); ?></label>
								<input type="text" name="btc_settxfee" class="form-control percent_min" placeholder="BTC Fee Tx" required value="<?php echo(sprintf('%.8f',$current_fee)); ?>">
							</div>
							<?php 
							$current_fee2 = db_option_get('admin_withdrawal_magic_fee');
							//echo(strpos('%',$current_plan->tx_fee_plan_topup));
							//echo();
							?>
							<div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('Admin Withdrawal Magic Fee')); ?></label>
								<input type="text" name="withdrawal_magic_fee" class="form-control percent_min" placeholder="BTC Fee Tx" required value="<?php echo(sprintf('%.8f',$current_fee2)); ?>">
							</div>
							
							
						</div>
						
						
						
						
						<div class="col-sm-12">
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
									<?php echo(t_get_val('Сохранили')); ?>
								  </div>
								  <?php
							  }
							}
						  ?>
						</div>
					
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-info pull-right"><?php echo(t_get_val('Update')); ?></button>
				</div>
				</form>
			</div>
		</div>
	  </div>
	</section>
</div>