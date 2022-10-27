<pre2>
<?php 

//Прячем длительность на бессроках
//Пенальти может не быть
if($_POST){
	//print_r($_POST);
	
	$plan_id2 = new MongoDB\BSON\ObjectId ($_POST['pid']);
	$current_plan2 = plans_list_by(['_id'=>$plan_id2]);
	$current_plan2 = $current_plan2[0];
	
	if($current_plan2->plan_yield != $_POST['plan_yield']){	
		$error = 'Меняем доходность';		
		send_yield_msg($_POST['pid']);
	}
	
	$errorF = false;
	$plan_arr = array();
	$plan_arr['name'] = $_POST['name'];
	$plan_arr['plan_yield'] = (float)$_POST['plan_yield'];
	//$plan_arr['plan_typev2'] = (int)$_POST['plan_typev2'];
	$plan_arr['plan_min_amount'] = $_POST['plan_min_amount'];
	$plan_arr['plan_time_days'] = $_POST['plan_time_days'];
	if(strpos($_POST['tx_fee_plan_topup'],'%') > 0){
		if(strlen($_POST['tx_fee_plan_topup_min']) > 0){
			$plan_arr['tx_fee_plan_topup'] = $_POST['tx_fee_plan_topup'].'/'.$_POST['tx_fee_plan_topup_min'];
		}else{
			$plan_arr['tx_fee_plan_topup'] = $_POST['tx_fee_plan_topup'];
		}
	}else{
		$plan_arr['tx_fee_plan_topup'] = $_POST['tx_fee_plan_topup'];
	}
	if(strpos($_POST['tx_fee_plan_withdraw'],'%') > 0){
		if(strlen($_POST['tx_fee_plan_withdraw_min']) > 0){
			$plan_arr['tx_fee_plan_withdraw'] = $_POST['tx_fee_plan_withdraw'].'/'.$_POST['tx_fee_plan_withdraw_min'];
		}else{
			$plan_arr['tx_fee_plan_withdraw'] = $_POST['tx_fee_plan_withdraw'];
		}
	}else{
		$plan_arr['tx_fee_plan_withdraw'] = $_POST['tx_fee_plan_withdraw'];
	}
	$penaltys = array();
	foreach($_POST['tx_fee_plan_penalty_period'] as $k=>$v){
		$temp = array();
		$temp[] = $v;
		if(strpos($_POST['tx_fee_plan_penalty'][$k],'%') > 0){
			if(strlen($_POST['tx_fee_plan_penalty_min'][$k]) > 0){
				$temp[] = $_POST['tx_fee_plan_penalty'][$k].'/'.$_POST['tx_fee_plan_penalty_min'][$k];
			}else{
				$temp[] = $_POST['tx_fee_plan_penalty'][$k];
			}
		}else{
			$temp[] = $_POST['tx_fee_plan_penalty'][$k];
		}
		$penaltys[] = $temp;
	}
	if(count($penaltys) > 0){
		$plan_arr['tx_fee_plan_penalty'] = $penaltys;
	}
	
	//print_r($plan_arr);
	
	$result = plan_modify($_POST['pid'],$plan_arr);
	if($result < 0){
		//print_r($result);
		$error = '';
		switch ($result) {
			case -2:
				$error = 'Такой план уже существует';
				break;
			case -1:
				$error = 'Неверные данные';
				break;
		}
		$errorF = true;
	}else{
		$errorF = false;
		$error = 'Успешно изменили';
	}
}

?>
</pre2>


<?php include($basedir . '/frontend/sidebar_admin.php'); ?>

<div class="content-wrapper h100vh">
	<section class="content">
		<pre2>
		<?php 
		$plan_id = new MongoDB\BSON\ObjectId ($_GET['plan_id']);
		$current_plan = plans_list_by(['_id'=>$plan_id]);
		$current_plan = $current_plan[0];
		//print_r($current_plan); 
		//print_r($plan_arr);
		?>
		</pre2>
		<?php 
		$plan_types_name = [2=>'Срочный',4=>'Бессрочный'];
		?>
      <div class="row">
        <div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Update Plan</h3>
				</div>
			<!-- /.box-header -->
			<!-- form start -->
					<form class="form-horizontal" method="POST" role="form">
					  <div class="box-body ">
						<div class="col-sm-4 plan_options">
							<input type="hidden" name="pid" value="<?php echo((string)$current_plan->_id); ?>">
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label">Name</label>
							  <div class="col-sm-8">
								<input type="text" name="name" class="form-control" placeholder="name" required value="<?php echo($current_plan->name); ?>">
							  </div>
							</div>				
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label">Plan Type</label>
							  <div class="col-sm-8">
								 <select class="form-control" name="plan_type" id="plan_type" disabled>
									<?php 
									foreach($plan_types_name as $k=>$v){
										$selected = '';
										if($k == $current_plan->plan_type){
											$selected = 'selected';
										}
										?>
										<option value="<?php echo($k); ?>" <?php echo($selected); ?>><?php echo($v); ?></option>
										<?php
									}
									?>
								  </select>
							  </div>
							</div>
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label"><?php echo(t_get_val('Plan Type v2')); ?></label>
							  <div class="col-sm-8">
								 <select class="form-control" name="plan_typev2" id="plan_typev2" disabled>
									<?php 
									foreach($plan_v2_texts as $v2_key=>$v2_text){
										$selected = '';
										if($v2_key == $current_plan->plan_typev2){
											$selected = 'selected';
										}
										?>
										<option value="<?php echo($v2_key); ?>" <?php echo($selected); ?>><?php echo($v2_text); ?></option>
										<?php
									}
									?>
								  </select>
							  </div>
							</div>				
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label">Plan Yield</label>
							  <div class="col-sm-8">
								<input type="text" name="plan_yield" class="form-control" placeholder="Plan Yield" required value="<?php echo($current_plan->plan_yield); ?>">
							  </div>
							</div>				
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label">Plan Min Amount</label>
							  <div class="col-sm-8">
								<input type="text" name="plan_min_amount" class="form-control" placeholder="Plan Min Amount" required value="<?php echo(sprintf('%-010f',$current_plan->plan_min_amount)); ?>">
							  </div>
							</div>
							<?php if($current_plan->plan_type == 2){ ?>
							<div class="form-group plan_time_days">
							  <label for="inputEmail3" class="col-sm-4 control-label">Plan Time Days</label>
							  <div class="col-sm-8">
								<input type="text" name="plan_time_days" class="form-control" placeholder="Plan Time Days" required value="<?php echo($current_plan->plan_time_days); ?>">
							  </div>
							</div>
							<?php } ?>
						</div>
						<div class="col-sm-8 plan_fee">
							<div class="form-group row">
								<?php 
								//echo(strpos('%',$current_plan->tx_fee_plan_topup));
								if(strpos($current_plan->tx_fee_plan_topup,'%') > 0){
									$temp = explode('/',$current_plan->tx_fee_plan_topup);
									if(count($temp) > 1){
								?>
								  <div class="col-sm-6">
									<label for="inputEmail3">Plan Fee Topup</label>
									<input type="text" name="tx_fee_plan_topup" class="form-control percent_min" placeholder="Plan Fee Topup" required value="<?php echo($temp[0]); ?>">
								  </div>
								  <div class="col-sm-6 min_input_div" =>
									<label for="inputEmail3">Plan Fee Topup Min</label>
									<input type="text" name="tx_fee_plan_topup_min" class="form-control" placeholder="Plan Fee Topup Min"value="<?php echo(sprintf('%-010f',$temp[1])); ?>">
								  </div>
								<?php 
									}else{
										?>
										<div class="col-sm-6">
											<label for="inputEmail3">Plan Fee Topup</label>
											<input type="text" name="tx_fee_plan_topup" class="form-control percent_min" placeholder="Plan Fee Topup" required value="<?php echo($current_plan->tx_fee_plan_topup); ?>">
										 </div>
										<div class="col-sm-6 min_input_div">
											<label for="inputEmail3">Plan Fee Topup Min</label>
											<input type="text" name="tx_fee_plan_topup_min" class="form-control" placeholder="Plan Fee Topup Min">
										 </div>
										<?php
									}
								
								
								}else{ ?>
								  <div class="col-sm-6">
									<label for="inputEmail3">Plan Fee Topup</label>
									<input type="text" name="tx_fee_plan_topup" class="form-control percent_min" placeholder="Plan Fee Topup" required value="<?php echo($current_plan->tx_fee_plan_topup); ?>">
								  </div>
								  <div class="col-sm-6 min_input_div" style="display:none;">
									<label for="inputEmail3">Plan Fee Topup Min</label>
									<input type="text" name="tx_fee_plan_topup_min" class="form-control" placeholder="Plan Fee Topup Min" >
								  </div>								
								<?php } ?>
							</div>
							<div class="form-group row">
								<?php 
								//echo(strpos('%',$current_plan->tx_fee_plan_topup));
								if(strpos($current_plan->tx_fee_plan_withdraw,'%') > 0){
									$temp = explode('/',$current_plan->tx_fee_plan_withdraw);
									if(count($temp) > 1){
								?>
								  <div class="col-sm-6">
									<label for="inputEmail3">Plan Fee Withdraw</label>
									<input type="text" name="tx_fee_plan_withdraw" class="form-control percent_min" placeholder="Plan Fee Topup" required value="<?php echo($temp[0]); ?>">
								  </div>
								  <div class="col-sm-6 min_input_div">
									<label for="inputEmail3">Plan Fee Withdraw Min</label>
									<input type="text" name="tx_fee_plan_withdraw_min" class="form-control" placeholder="Plan Fee Topup Min"value="<?php echo(sprintf('%-010f',$temp[1])); ?>">
								  </div>
								<?php 
									}else{
								?>
									  <div class="col-sm-6">
										<label for="inputEmail3">Plan Fee Withdraw</label>
										<input type="text" name="tx_fee_plan_withdraw" class="form-control percent_min" placeholder="Plan Fee Topup" required value="<?php echo($current_plan->tx_fee_plan_withdraw); ?>">
									  </div>
									  <div class="col-sm-6 min_input_div">
										<label for="inputEmail3">Plan Fee Withdraw Min</label>
										<input type="text" name="tx_fee_plan_withdraw_min" class="form-control" placeholder="Plan Fee Topup Min">
									  </div>
									<?php
										
									}
								
								}else{ ?>
								  <div class="col-sm-6">
									<label for="inputEmail3">Plan Fee Withdraw</label>
									<input type="text" name="tx_fee_plan_withdraw" class="form-control percent_min" placeholder="Plan Fee Topup" required value="<?php echo($current_plan->tx_fee_plan_withdraw); ?>">
								  </div>
								  <div class="col-sm-6 min_input_div" style="display:none;">
									<label for="inputEmail3">Plan Fee Withdraw Min</label>
									<input type="text" name="tx_fee_plan_withdraw_min" class="form-control" placeholder="Plan Fee Topup Min" >
								  </div>								
								<?php } ?>
							</div>
							
							<div class="row repeater_field">
								<?php 
								//print_r((array)$current_plan->tx_fee_plan_penalty);
								$i = 1;
								$plan_renalte = (array)$current_plan->tx_fee_plan_penalty;
								if(count($plan_renalte) > 1){
									foreach($plan_renalte as $p_pen){
										//echo('<br>!<br>');
										//print_r($p_pen);
										if($i == 1){
											$i = 2;
											$del_btn ='';
											$class = 'repeat_field';
										}else{
											$class = '';
											$del_btn = '<div class="col-sm-3 delete_row"><button type="button" class="btn btn-block btn-danger btn-flat">Delete</button></div>';
										}
										?>
										<div class="<?php echo($class); ?> col-sm-12 form-group">
										  <div class="col-sm-3">
											<label for="inputEmail3">Penalty Period</label>
											<input type="text" name="tx_fee_plan_penalty_period[]" class="form-control percent_min" placeholder="Plan Fee Withdraw" value="<?php echo($p_pen[0]); ?>">
										  </div>
										  
										<?php 
										if(strpos($p_pen[1],'%') > 0){
											$temp = explode('/',$p_pen[1]);
											if(count($temp) > 1){
												?>
												<div class="col-sm-3">
													<label for="inputEmail3">Penalty Fee</label>
													<input type="text" name="tx_fee_plan_penalty[]" class="form-control percent_min" placeholder="Penalty Fee"  value="<?php echo($temp[0]); ?>">
												</div>
												<div class="col-sm-3 min_input_div">
													<label for="inputEmail3">Penalty Fee Min</label>
													<input type="text" name="tx_fee_plan_penalty_min[]" class="form-control" placeholder="Penalty Fee Min"value="<?php echo(sprintf('%-010f',$temp[1])); ?>">
												</div>
												<?php
											}else{
												?>
												<div class="col-sm-3">
													<label for="inputEmail3">Penalty Fee</label>
													<input type="text" name="tx_fee_plan_penalty[]" class="form-control percent_min" placeholder="Penalty Fee"  value="<?php echo($p_pen[1]); ?>">
												</div>
												<div class="col-sm-3 min_input_div">
													<label for="inputEmail3">Penalty Fee Min</label>
													<input type="text" name="tx_fee_plan_penalty_min[]" class="form-control" placeholder="Penalty Fee Min">
												</div>
												<?php
											}
										}else{
											?>
											<div class="col-sm-3">
													<label for="inputEmail3">Penalty Fee</label>
													<input type="text" name="tx_fee_plan_penalty[]" class="form-control percent_min" placeholder="Penalty Fee" required value="<?php echo(sprintf('%-010f',$p_pen[1])); ?>">
												</div>
												<div class="col-sm-3 min_input_div" style="display:none;">
													<label for="inputEmail3">Penalty Fee Min</label>
													<input type="text" name="tx_fee_plan_penalty_min[]" class="form-control" placeholder="Penalty Fee Min">
												</div>
											<?php
										}
										?>
										<?php echo($del_btn); ?>
										</div>
										<?php
									}
									?>
								<?php 								
								}else{									
								?>
								<div class="repeat_field col-sm-12 form-group">
										<div class="col-sm-3">
											<label for="inputEmail3">Penalty Period</label>
											<input type="text" name="tx_fee_plan_penalty_period[]" class="form-control percent_min" placeholder="Plan Fee Withdraw" >
										</div>
										  
										<div class="col-sm-3">
											<label for="inputEmail3">Penalty Fee</label>
											<input type="text" name="tx_fee_plan_penalty[]" class="form-control percent_min" placeholder="Penalty Fee"  >
										</div>
										<div class="col-sm-3 min_input_div" style="display:none;">
											<label for="inputEmail3">Penalty Fee Min</label>
											<input type="text" name="tx_fee_plan_penalty_min[]" class="form-control" placeholder="Penalty Fee Min" >
										</div>																						
								</div>
								<?php } ?>
								<div class="col-sm-12 add_new_field_col">
									<div class="row">
										<div class="col-md-4 pull-right">
											<button type="button" class="btn btn-block btn-primary add_new_field">Add New</button>
										</div>
									</div>
								</div>
							</div>
						
						</div>
						<div class="col-sm-12 pt15">
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
					  </div>
					  
					  <!-- /.box-body -->
					  <div class="box-footer">
						<button type="submit" class="btn btn-info pull-right"><?php echo(t_get_val('Update')); ?></button>
					  </div>
					  <!-- /.box-footer -->
					</form>
				</div>
			</div>
		</div>
	</section>
</div>