
<?php 

//Прячем длительность на бессроках
//Пенальти может не быть
if($_POST){
	//print_r($_POST);
	$errorF = false;
	$plan_arr = array();
	$plan_arr['name'] = $_POST['name'];
	$plan_arr['plan_type'] = $_POST['plan_type'];
	$plan_arr['plan_typev2'] = (int)$_POST['plan_typev2'];
	$plan_arr['plan_yield'] = (float)$_POST['plan_yield'];
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
	

	$result = plan_create($plan_arr);
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
		$error = 'Успешно сохранили';
	}
}

?>



<?php include($basedir . '/frontend/sidebar_admin.php'); ?>

<div class="content-wrapper h100vh">
	<section class="content">

      <div class="row">
        <div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo(t_get_val('Create Plan')); ?></h3>
				</div>
			<!-- /.box-header -->
			<!-- form start -->
					<form class="form-horizontal" method="POST" role="form">
					  <div class="box-body ">
						<div class="col-sm-4 plan_options">
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label"><?php echo(t_get_val('Name')); ?></label>
							  <div class="col-sm-8">
								<input type="text" name="name" class="form-control" placeholder="name" required>
							  </div>
							</div>				
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label"><?php echo(t_get_val('Plan Type')); ?></label>
							  <div class="col-sm-8">
								 <select class="form-control" name="plan_type" id="plan_type">
									<option value="2">Срочный</option>
									<option value="4">Бессрочный</option>
								  </select>
							  </div>
							 
							</div>
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label"><?php echo(t_get_val('Plan Type v2')); ?></label>
							  <div class="col-sm-8">
								 <select class="form-control" name="plan_typev2" id="plan_typev2">
									<?php 
									
									foreach($plan_v2_texts as $v2_key=>$v2_text){
										?>
										<option value="<?php echo($v2_key); ?>"><?php echo($v2_text); ?></option>
										<?php
									}
									
									?>
								  </select>
							  </div>
							</div>				
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label"><?php echo(t_get_val('Plan Yield')); ?></label>
							  <div class="col-sm-8">
								<input type="text" name="plan_yield" class="form-control" placeholder="Plan Yield" required>
							  </div>
							</div>				
							<div class="form-group">
							  <label for="inputEmail3" class="col-sm-4 control-label"><?php echo(t_get_val('Plan Min Amount')); ?></label>
							  <div class="col-sm-8">
								<input type="text" name="plan_min_amount" class="form-control" placeholder="Plan Min Amount" required>
							  </div>
							</div>
							<div class="form-group plan_time_days">
							  <label for="inputEmail3" class="col-sm-4 control-label"><?php echo(t_get_val('Plan Time Days')); ?></label>
							  <div class="col-sm-8">
								<input type="text" name="plan_time_days" class="form-control" placeholder="Plan Time Days" required>
							  </div>
							</div>
						</div>
						<div class="col-sm-8 plan_fee">
							<div class="form-group row">
							  <div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('Plan Fee Topup')); ?></label>
								<input type="text" name="tx_fee_plan_topup" class="form-control percent_min" placeholder="Plan Fee Topup" required>
							  </div>
							  <div class="col-sm-6 min_input_div" style="display:none;">
								<label for="inputEmail3"><?php echo(t_get_val('Plan Fee Topup Min')); ?></label>
								<input type="text" name="tx_fee_plan_topup_min" class="form-control" placeholder="Plan Fee Topup Min" >
							  </div>
							</div>
							<div class="form-group row">
							  <div class="col-sm-6">
								<label for="inputEmail3"><?php echo(t_get_val('Plan Fee Withdraw')); ?></label>
								<input type="text" name="tx_fee_plan_withdraw" class="form-control percent_min" placeholder="Plan Fee Withdraw" required>
							  </div>
							  <div class="col-sm-6 min_input_div" style="display:none;">
								<label for="inputEmail3"><?php echo(t_get_val('Plan Fee Withdraw Min')); ?></label>
								<input type="text" name="tx_fee_plan_withdraw_min" class="form-control" placeholder="Plan Fee Withdraw Min" >
							  </div>
							</div>
							
							<div class="row repeater_field">
								<div class="repeat_field col-sm-12 form-group">
								  <div class="col-sm-3">
									<label for="inputEmail3"><?php echo(t_get_val('Penalty Period')); ?></label>
									<input type="text" name="tx_fee_plan_penalty_period[]" class="form-control percent_min" placeholder="<?php echo(t_get_val('Penalty Period')); ?>" >
								  </div>
								  <div class="col-sm-3">
									<label for="inputEmail3"><?php echo(t_get_val('Penalty Fee')); ?></label>
									<input type="text" name="tx_fee_plan_penalty[]" class="form-control percent_min" placeholder="<?php echo(t_get_val('Penalty Fee')); ?>">
								  </div>
								  <div class="col-sm-3 min_input_div" style="display:none;">
									<label for="inputEmail3"><?php echo(t_get_val('Penalty Fee Min')); ?></label>
									<input type="text" name="tx_fee_plan_penalty_min[]" class="form-control" placeholder="<?php echo(t_get_val('Penalty Fee Min')); ?>" >
								  </div>
								</div>
								<div class="col-sm-12 add_new_field_col">
									<div class="row">
										<div class="col-md-4 pull-right">
											<button type="button" class="btn btn-block btn-primary add_new_field"><?php echo(t_get_val('Add New')); ?></button>
										</div>
									</div>
								</div>
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
						<button type="submit" class="btn btn-info pull-right"><?php echo(t_get_val('Create')); ?></button>
					  </div>
					  <!-- /.box-footer -->
					</form>
				</div>
			</div>
		</div>
	</section>
</div>