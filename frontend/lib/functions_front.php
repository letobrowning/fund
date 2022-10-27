<?php 
function updateGET($query,$param){
	//$query = $_GET;
	foreach($param as $k=>$v){
		// replace parameter(s)
		$query[$k] = $v;
	}
	// rebuild url
	$query_result = http_build_query($query);
	return $query_result;
}
/*
	Получаем url на выходе массив
	1 - тип страницы (должна быть созданна папка с этим именем)
	2 - тип подраздел страницы (может не быть)

*/
function get_page_type (){
	$request = $_SERVER['REQUEST_URI'];
	//print_r($_SERVER['REQUEST_URI']);
	$request = substr($request, 1);
	$get_pos = strpos($request,'?');
	if($get_pos === false){
		
	}else{
		$request = substr($request, 0, $get_pos);
	}
	$pagetype = explode('/',$request);
	return $pagetype;
}
function get_ip(){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
//Уведомление об изменении доходности
function send_yield_msg($pid){
	
}
//Проверка гугл капчи
function validateCapcha($capcha){
	return true;
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$params = [
		'secret' => '6LdouJgUAAAAAOMGl_oGi9n7daFUlL2RfqfcdC0P',
		'response' => $capcha,
	];
	 
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 
	$response = curl_exec($ch);
	if(!empty($response)) $decoded_response = json_decode($response);
	
	//$success = false;
	 
	if ($decoded_response && $decoded_response->success && $decoded_response->action == 'register' && $decoded_response->score > 0) {
		$success = $decoded_response->success;
		//return false; //Временно для тестов
		return true;
	}else{
		return false; //Ошибка капчи
	}
}
//Функция для вывода теста о комиссии
function get_fee_text($fee){
	if(strpos($fee,'/') > 0){
		$temp = explode('/',$fee);
		if(count($temp) > 1){
			$tx_fee = '<div class="plan_info_row"><b>'.t_get_val('Percents').'</b><span class="percents">'.$temp[0].'</span> <br><b>'.t_get_val('Min').':</b> <span class="min">'.$temp[1].'</span> <span class="current_coin">btc</span></div>';
		}else{
			$tx_fee = '<b>'.t_get_val('Percents').'</b>'.$temp[0];
		}
		//print_r($tx_fee_plan_topup);
	}else{
		if(strpos($fee,'%') > 0){
			$tx_fee = '<b>'.t_get_val('Percents').'</b><span class="percents">'.$fee.'</span>';
		}else{
			$tx_fee = '<span class="min">'.$fee.'</span><span class="current_coin">btc</span>';
		}
	}
	return $tx_fee;
}

//вывод транзакций по плану (с профитами, графиками и обычными транзакциями)
function show_plans_tx($txs,$plan = false,$k,$letter_fee,$sum_income,$body){
	global $plan_tx_status_name;
	global $trans_types_name;
	if(isset($txs['tx'])){
		
		?>
		<div class="col-sm-12 tx_row">
			<div class="row">
				<?php 
				if($txs['tx']->plan_tx_status){
					?>
					<div class="col-sm-12 pb5">
						<span class="label <?php echo($plan_tx_status_name[$txs['tx']->plan_tx_status][1]); ?>"><?php echo($plan_tx_status_name[$txs['tx']->plan_tx_status][0]); ?></span>
					</div>
					<?php
				}
				
				?>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Type')); ?></b></div>
						<div class="col-sm-7">
							<?php echo($trans_types_name[$txs['tx']->tx_type]); ?>								
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Amount')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs['tx']->amount)); ?></div>
					</div>
					
				</div>
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Time send')); ?></b></div>
						<div class="col-sm-7"><?php 
						
						//echo(date('m.d.Y H:i',$txs['tx']->__income_start_time)); 
						echo(date('d.m.Y H:i',$txs['tx']->time_ts)); 
						
						
						?></div>
					</div>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Time aprove')); ?></b></div>
						<div class="col-sm-7"><?php echo(date('d.m.Y H:i',$txs['tx']->plan_topup_approve_time)); ?></div>
					</div>
					
				</div>
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Tx body')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs['body'])); ?></div>
					</div>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Sum Income')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs['sum_income'])); ?></div>
					</div>
					
				</div>
			</div>
			<?php 
			//Если есть инком для реинвестирования то выводим кнопку
			if($txs['sum_income'] > 0){ ?>
			<div class="row">
				<?php
					//db_option_set('tx_fee_user_i2b_'.$letter_fee,'1%');
					//db_option_set ('tx_fee_user_i2b_t', '15%/0.005');
					$current_fee = db_option_get('tx_fee_user_i2b_'.$letter_fee);
					//print_r($current_fee);
					if(strpos($current_fee,'/') > 0){
						$temp = explode('/',$current_fee);
						if(count($temp) > 1){
							$current_fee = $temp[0].', <b class="pr5">min</b>'.$temp[1];
							$temp_p = $txs['sum_income'] * ((float)$temp[0]) /100;
							if($temp_p > $temp[1]){
								$current_u_fee = $temp_p;
							}else{
								$current_u_fee = $temp[1];
							}
						}else{
							//$current_fee = $current_fee;
						}
					}else{
						if(strpos($current_fee,'%') > 0){
							//$current_fee = $current_fee;
							$current_u_fee = $txs['sum_income'] * ((float)$current_fee) /100;
						}else{
							$current_u_fee = sprintf('%.8f',$current_fee);
						}
						//echo(sprintf('%.8f',$txs['sum_income']/100));
					}
				?>
				<div class="col-sm-12 pb15 pt15 action_wrapper">
					<div class="row">
						<div class="col-sm-12 pb10">
							<div class="pull-right plan_income_to_body"><b class="pr5"><?php echo(t_get_val('Comission to withdrawal')); ?>:</b><?php echo($current_fee); ?> </div>
						</div>
						<div class="col-sm-12 pb10">
							<div class="pull-right plan_income_to_body"><b class="pr5"><?php echo(t_get_val('Current comission')); ?>:</b><?php echo(sprintf('%.8f',$current_u_fee)); ?> </div>
						</div>
					</div>
					
					<div  class="btn btn-info pull-right plan_income_to_body" data-uid="<?php echo($_SESSION['uid']); ?>" data-nid="<?php echo((string)$plan->_id); ?>" data-pt="<?php echo($plan->plan_type); ?>" data-tid="<?php echo((string)$txs['tx']->_id); ?>" ><?php echo(t_get_val('Reinvest income to body')); ?></div>
					
				</div>
			</div>
			<?php } ?>
			
			<?php if($body > 0 AND (!isset($txs['have_pending_withdrawals']) OR $txs['have_pending_withdrawals'] != 1 )){ 
			
			//Тут формируем форму и кнопку запроса на вывод в депозит
			?>
			<div class="row">
				<div class="col-md-4 pull-right">
					<a  class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-withdrawal<?php echo($k); ?>"><?php echo(t_get_val('Withdraw')); ?></a>
				</div>
			</div>
			
			
			<div class="modal fade" id="modal-withdrawal<?php echo($k); ?>">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><?php echo(t_get_val('Withdrawal From')); ?> <?php echo($plan->name); ?></h4>
				  </div>
				  <div class="modal-body">
					<div class="plan_info">
						<?php 
						//print_r($plan);
						if(strpos($plan->tx_fee_plan_withdraw,'/') > 0){
							$temp = explode('/',$plan->tx_fee_plan_withdraw);
							if(count($temp) > 1){
								$tx_fee_plan_withdraw = '<div class="plan_info_row"><b>'.t_get_val('Percents').'</b><span class="percents">'.$temp[0].'</span> <br><b>'.t_get_val('Min').':</b> <span class="min">'.$temp[1].'</span> <span class="current_coin">btc</span></div>';
							}else{
								$tx_fee_plan_withdraw = '<b>'.t_get_val('Percents').'</b>'.$temp[0];
							}
							//print_r($tx_fee_plan_topup);
						}else{
							if(strpos($plan->tx_fee_plan_withdraw,'%') > 0){
								$tx_fee_plan_withdraw = '<b>'.t_get_val('Percents').'</b><span class="percents">'.$plan->tx_fee_plan_withdraw.'</span>';
							}else{
								$tx_fee_plan_withdraw = '<span class="min">'.$plan->tx_fee_plan_withdraw.'</span><span class="current_coin">btc</span>';
							}
						}
						
						?>
						<div><b class="plan_info_title"><?php echo(t_get_val('Comission to withdrawal')); ?></b><?php echo($tx_fee_plan_withdraw); ?></div>
						<div class="current_com pb15 pt15"><b><?php echo(t_get_val('Current comission')); ?></b><span class="current_com_result"></span></div>
					</div>
					<div class="row">
						<div class="form-group">
						  <div class="col-sm-10">
							<input type="numeric" name="p_Amount" class="form-control p_Amount min_max" placeholder="Amount to invest" required data-max="<?php echo(sprintf('%.8f',$body)); ?>" >
							<span class="help-block" style="display:none;"><?php echo(t_get_val('Unsufficient funds')); ?></span>
						  </div>
						</div>
					</div>
				  </div>
				  <div class="modal-footer action_wrapper">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo(t_get_val('Close')); ?></button>
					<button data-uid="<?php echo($_SESSION['uid']); ?>" data-nid="<?php echo((string)$plan->_id); ?>" data-pt="<?php echo($plan->plan_type); ?>" data-tid="<?php echo((string)$txs['tx']->_id); ?>" type="button" class="btn btn-primary withdrawal_do"><?php echo(t_get_val('Withdrawal')); ?></button>
				  </div>
				</div>
				<!-- /.modal-content -->
			  </div>
			  <!-- /.modal-dialog -->
		</div>
			
			<?php } ?>
			<?php if($sum_income > 0){ ?>
			<div class="row">
				<div class="chart col-sm-12 pt15">
					<div id="lineChart<?php echo((string)$txs['tx']->_id); ?>" ></div>
				</div>
			</div>
			<?php 
				$xaxis = "'".date('d.m.Y H:i',$txs['tx']->__income_start_time)."'";
				$yaxis1 = round(0,2);
				$yaxis2 = sprintf('%.8f',0);
				foreach($txs['yield_equity_timeline'] as $yet){
					$xaxis .= ",'".date('d.m.Y H:i',$yet['til_time_ts'])."'";
					$yaxis1 .= ",".round($yet['percents'],2);
					$yaxis2 .= ",".sprintf('%.8f',$yet['income']);
				}
			
			?>
			  <script>
				Highcharts.chart('lineChart<?php echo((string)$txs['tx']->_id); ?>', {
					chart: {
						zoomType: 'xy',
						height: 200,
						backgroundColor: 'rgba(0,0,0,0)',
					},
					title: {
						text: ''
					},
					subtitle: {
						text: ''
					},
					xAxis: [{
						categories: [<?php echo($xaxis); ?>],
						crosshair: true
					}],
					yAxis: [{ // Primary yAxis
						labels: {
							format: '{value} btc',
							style: {
								color: '#000000'
							}
						},
						title: {
							text: '<?php echo(t_get_val('Income')); ?>',
							style: {
								color: '#000000'
							}
						},
						opposite: true

					}, { // Secondary yAxis
						gridLineWidth: 0,
						title: {
							text: '<?php echo(t_get_val('Percents')); ?>',
							style: {
								color: '#000000'
							}
						},
						labels: {
							format: '{value} %',
							style: {
								color:'#000000'
							}
						}

					}],
					tooltip: {
						shared: true
					},
					legend: {
						layout: 'vertical',
						align: 'left',
						x: 80,
						verticalAlign: 'top',
						y: 55,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255,255,255,0.25)'
					},
					series: [{
						name: '<?php echo(t_get_val('Percents')); ?>',
						type: 'spline',
						yAxis: 1,
						data: [<?php echo($yaxis1); ?>],
						marker: {
							enabled: false
						},
						dashStyle: 'shortdot',
						tooltip: {
							valueSuffix: ' %'
						}

					}, {
						name: '<?php echo(t_get_val('Income')); ?>',
						type: 'spline',
						data: [<?php echo($yaxis2); ?>],
						tooltip: {
							valueSuffix: ' btc'
						}
					}]
				});
			  
			  </script>
			<?php } ?>
		</div>
		<?php
	}else{ //Тут реджет и вывод
		?>
		
		<div class="col-sm-12 tx_row">
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
						<div class="col-sm-5"><b><?php echo(t_get_val('Tx Type')); ?></b></div>
						<div class="col-sm-7">
							<?php echo($trans_types_name[$txs->tx_type]); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Tx Time')); ?></b></div>
						<div class="col-sm-7"><?php echo(date('d.m.Y H:i',$txs->time_ts)); ?></div>
					</div>
				</div>
				<?php if($txs->amount > 0){ ?>
				<div class="col-sm-4">
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Amount')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->amount)); ?></div>
					</div>
					<?php if($txs->tx_type == TX_TYPE_DEPOSIT_TOPUP){ ?>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_in->fee_amount)); ?></div>
					</div>
					<?php } ?>
					<?php if($txs->tx_type == TX_TYPE_PLAN_TOPUP){ ?>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_out->fee_amount)); ?></div>
					</div>
					<?php } ?>
					<?php if($txs->tx_type == TX_TYPE_PLAN_REVERT OR $txs->tx_type == TX_TYPE_DEPOSIT_WITHDRAW){ 
					//print_r($txs);
					?>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_out)); ?></div>
					</div>
					<?php } ?>
					<?php if($txs->tx_type == TX_TYPE_PLAN_WITHDRAW OR ($txs->plan_tx_status AND $txs->plan_tx_status == STATUS_APPROVED)){ 
					//print_r($txs);
					?>
					<div class="row">
						<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
						<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_in->fee_amount)); ?></div>
					</div>
					<?php } ?>
				</div>
					<?php if($txs->plan_tx_status AND $txs->plan_tx_status == STATUS_REJECTED){ ?>
					<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-12"><b><?php echo(t_get_val('Reject cause')); ?></b></div>
								<div class="col-sm-12"><?php echo($txs->cause); ?></div>
							</div>
						</div>
					<?php } ?>
				<?php }else{ 
						if($txs->plan_tx_status AND $txs->plan_tx_status == STATUS_REJECTED){
				?>
						<div class="col-sm-4">
							<div class="row">
								<div class="col-sm-12"><b><?php echo(t_get_val('Reject cause')); ?></b></div>
								<div class="col-sm-12"><?php echo($txs->cause); ?></div>
							</div>
						</div>
				
					<?php 	}
				
						} ?>
				<?php if($txs->tx_type == TX_TYPE_PLAN_REVERT){ ?>
						<div class="col-sm-12 pt15">
							<div class="alert alert-danger alert-dismissible">
								 <b><?php echo(t_get_val('TX ID')); ?></b><?php echo((string)$txs->to_tx__id); ?><br>
								 <div><b><?php echo(t_get_val('Reject cause')); ?></b></div>
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
		<?php
	}
}

//Вывод tx в юзер кабинете
function show_cabinet_tx($txs){
	global $plan_tx_status_name;
	global $trans_types_name;
	?>
	<div class="col-sm-12 tx_row" >
		<pre2>
		<?php //print_r($txs); ?>
		</pre2>
		<div class="row">
			<?php 
			if($txs->plan_tx_status){
				?>
				<div class="col-sm-12 pb5">
					<span class="label <?php echo($plan_tx_status_name[$txs->plan_tx_status][1]); ?>"><?php echo($plan_tx_status_name[$txs->plan_tx_status][0]); ?></span>
				</div>
				<?php
			}
			if(($txs->tx_type == TX_TYPE_DEPOSIT_TOPUP || $txs->tx_type == TX_TYPE_PLAN_TOPUP ||  $txs->tx_type == TX_TYPE_DEPOSIT_WITHDRAW ||  $txs->tx_type == TX_TYPE_PLAN_WITHDRAW) && $txs->confirmations < 6){
				?>
				<div class="col-sm-12 pb5">
					<span class="label <?php echo($plan_tx_status_name[STATUS_BLOCKCHAIN_PENDING][1]); ?>"><?php echo($plan_tx_status_name[STATUS_BLOCKCHAIN_PENDING][0]); ?></span>
				</div>
				<?php
			}
			
			?>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Tx Type')); ?></b></div>
					<div class="col-sm-7">
						<?php echo($trans_types_name[$txs->tx_type]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Tx Time')); ?></b></div>
					<div class="col-sm-7"><?php echo(date('d.m.Y H:i',$txs->time_ts)); ?></div>
				</div>
			</div>
			<?php if($txs->amount > 0){ ?>
			<div class="col-sm-4">
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Amount')); ?></b></div>
					<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->amount)); ?></div>
				</div>
				<?php if($txs->tx_type == TX_TYPE_DEPOSIT_TOPUP){ ?>
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
					<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_in->fee_amount)); ?></div>
				</div>
				<?php } ?>
				<?php if($txs->tx_type == TX_TYPE_PLAN_TOPUP){ ?>
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
					<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_out->fee_amount)); ?></div>
				</div>
				<?php } ?>
				<?php if($txs->tx_type == TX_TYPE_PLAN_REVERT OR $txs->tx_type == TX_TYPE_DEPOSIT_WITHDRAW){ 
				//print_r($txs);
				?>
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
					<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_out)); ?></div>
				</div>
				<?php } ?>
				<?php if($txs->tx_type == TX_TYPE_PLAN_WITHDRAW){ 
				//print_r($txs);
				?>
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
					<div class="col-sm-7"><?php echo(sprintf('%.8f',$txs->tx_fee_user_in->fee_amount)); ?></div>
				</div>
				<?php } ?>
			</div>
			<?php }else{ 
					if($txs->plan_tx_status AND $txs->plan_tx_status == STATUS_REJECTED){
			?>
					<div class="col-sm-4">
						<div class="row">
							<div class="col-sm-12"><b><?php echo(t_get_val('Reject cause')); ?></b></div>
							<div class="col-sm-12"><?php echo($txs->cause); ?></div>
						</div>
					</div>
			
				<?php 	}
			
					} ?>
			<div class="col-sm-4">
				<?php if(isset($txs->confirmations)){ ?>
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Confirmations')); ?></b></div>
					<div class="col-sm-7"><?php echo($txs->confirmations); ?></div>
				</div>
				<?php } ?>
				<?php if($txs->tx_id){ ?>
				<div class="row">
					<div class="col-sm-7 pull-right"><a target="blank_" class="label label-info" href="https://www.blockchain.com/ru/btc/tx/<?php echo($txs->tx_id); ?>"><?php echo(t_get_val('More info')); ?></a></div>
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
					<div class="col-sm-5"><b><?php echo(t_get_val('Plan')); ?></b></div>
					<div class="col-sm-7"><?php echo($current_plan->name); ?></div>
				</div>
				<?php } ?>
				
			</div>
			<?php if($txs->tx_type == TX_TYPE_PLAN_REVERT){ ?>
					<div class="col-sm-12 pt15">
						<div class="alert alert-danger alert-dismissible">
							 <b><?php echo(t_get_val('TX ID')); ?> </b><?php echo((string)$txs->to_tx__id); ?><br>
							 <div><b><?php echo(t_get_val('Reject cause')); ?></b></div>
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
	
	<?php
}
//Вывод транзакций для подтверждения админом
function show_tx_to_apply($wtx,$k){
	global $trans_types_name;
	?>
	<div class="col-sm-12 tx_row">
		<div class="row">
			<div class="col-sm-3">
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Tx Type')); ?></b></div>
					<div class="col-sm-7">
						<?php echo($trans_types_name[$wtx->tx_type]); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-5"><b><?php echo(t_get_val('Tx Time')); ?></b></div>
					<div class="col-sm-7"><?php echo(date('d.m.Y H:i',$wtx->time_ts)); ?></div>
				</div>
			</div>
		
		<?php if($wtx->amount > 0){ ?>
		<div class="col-sm-3">
			<div class="row">
				<div class="col-sm-5"><b><?php echo(t_get_val('Amount')); ?></b></div>
				<div class="col-sm-7 tx_amount"><?php echo(sprintf('%.8f',$wtx->amount)); ?></div>
			</div>
			<?php if($wtx->tx_type == TX_TYPE_PLAN_REVERT OR $wtx->tx_type == TX_TYPE_DEPOSIT_WITHDRAW){ 
			//print_r($txs);
			?>
			<div class="row">
				<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
				<div class="col-sm-7"><?php echo(sprintf('%.8f',$wtx->tx_fee_user_out)); ?></div>
			</div>
			<?php } ?>
			<?php if($wtx->tx_type == TX_TYPE_PLAN_WITHDRAW OR $wtx->tx_type == TX_TYPE_PLAN_REINVEST){ 
			//print_r($txs);
			?>
			<div class="row">
				<div class="col-sm-5"><b><?php echo(t_get_val('Fee')); ?></b></div>
				<div class="col-sm-7"><?php echo(sprintf('%.8f',$wtx->tx_fee_user_in->fee_amount)); ?></div>
			</div>
			<?php } ?>
		</div>
		<div class="col-sm-3">
			<?php if($wtx->tx_type == TX_TYPE_PLAN_REINVEST OR $wtx->tx_type == TX_TYPE_PLAN_WITHDRAW){ ?>
			
			<?php 
			//Получим название плана
			$plan_id = new MongoDB\BSON\ObjectId ($wtx->plan_id);
			$current_plan = plans_list_by(['_id'=>$plan_id]);
			$current_plan = $current_plan[0];
			
			$uemail = users_list(['wallet'=>$wtx->to_address])[0]['email'];
			$edit_url['email'] = $uemail;
			$edit_url['subaction'] = 'user_show';
			?>
			
			<div class="row">
				<div class="col-sm-5"><b><?php echo(t_get_val('Plan')); ?></b></div>
				<div class="col-sm-7"><?php echo($current_plan->name); ?></div>
			</div>
			<div class="row">
				<div class="col-sm-5"><b><?php echo(t_get_val('User')); ?></b></div>
				<div class="col-sm-7"><a target="_blank" href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo($uemail); ?></a></div>
			</div>
			<?php } ?>
		</div>
		<div class="col-sm-3">
			<div class="row">
				<div class="col-sm-5"><b><?php echo(t_get_val('To Apply')); ?></b></div>
				<div class="col-sm-7"><input type="checkbox" class="to_apply" data-tid="<?php echo((string)$wtx->_id); ?>"></div>
			</div>
			<div class="row pt15">
				<div class="col-sm-6 pull-right">
					<button type="button" class="btn btn-block btn-danger" data-toggle="modal" data-target="#modal-reject<?php echo($k); ?>"><?php echo(t_get_val('Reject')); ?></button>
					<div class="modal fade" id="modal-reject<?php echo($k); ?>">
				  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><?php echo(t_get_val('Reject to')); ?> <?php echo((string)$wtx->_id); ?></h4>
						  </div>
						  <div class="modal-body">
							<div class="row">
								<div class="form-group">
								  <div class="col-sm-12">
									<input type="text" name="reason" class="form-control reason" placeholder="Reason" required>
								  </div>
								</div>
							</div>
						  </div>
						  <div class="modal-footer action_wrapper">
							<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo(t_get_val('Close')); ?></button>
							<button data-tid="<?php echo((string)$wtx->_id); ?>" type="button" class="btn btn-danger reject_do_usertx"><?php echo(t_get_val('Reject')); ?></button>
						  </div>
						</div>
						<!-- /.modal-content -->
					  </div>
					  <!-- /.modal-dialog -->
				</div>
				</div>
				
			</div>
		</div>
		
		<?php } ?>
		</div>
	</div>
	
	<?php
}
?>