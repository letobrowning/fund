<?php 

if(!isset($_SESSION['email'])){
	header('Location: http://95.179.236.117/?action=login');
}
include($basedir . '/frontend/sidebar.php');
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
    <div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('Plans')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i><?php echo(t_get_val('Home')); ?></a></li>
			<li class="active"><?php echo(t_get_val('Plans')); ?></li>
		  </ol>
		</section>
		    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
			<div class="plans_wrapper col-md-12">
				<div class="row">
					<pre2>
					<?php 
					//print_r($_SESSION);
					$last_user_trans = txs_list_by(['$or' => [['from_address' => $_SESSION['wallet']], ['to_address' => $_SESSION['wallet']]]], ['time_ts' => -1]);
					//print_r($last_trans);
					//print_r(plans_list_by());
					$all_plans = plans_list_by();
					//print_r($all_plans);
					//$user_plans = user_get_plans($_SESSION['uid']);
					$user_plans = user_get_plans($_SESSION['uid']);
					//print_r($user_plans);
					$result = array(); // Тут будем хранить инфу по планам, что бы можно было обращаться по _id
					foreach($last_user_trans as $user_tx){
						if($user_tx->plan_tx_status == STATUS_REJECTED OR $user_tx->plan_tx_status == STATUS_PENDING OR $user_tx->plan_tx_status == STATUS_APPROVED){
							//if isset $all_plans $user_tx->plan_type $user_tx->plan_id (string)$user_tx->_id
							$result[$user_tx->plan_id][(string)$user_tx->_id] = $user_tx;
							
						}
					}
					//5c83ca99e58faa655f1e3982
					//print_r(user_get_plans($_SESSION['uid']));
					//print_r($result);
					//print_r(user_get_plans($_SESSION['uid']));
					?>
					</pre2>
					<div class="col-sm-12">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
							<?php 
							$i = 1;
							foreach($plan_v2_texts as $plan_v2_key=>$plan_v2_text){
								if($i == 1){
									$i++;
									$class = 'active';
								}else{
									$class = '';
								}
								?>
								<li class="<?php echo($class); ?>"><a href="#tab_<?php echo($plan_v2_key); ?>" data-toggle="tab" aria-expanded="false"><b><?php echo($plan_v2_text); ?></b></a></li>
								<?php
							}
							
							?>
							</ul>
						</div>
						<div class="tab-content">
							
					<?php 
					$i = 1;
					$modal_num = 0;
					$all_modals = array();
					foreach($plan_v2_texts as $plan_v2_key=>$plan_v2_text){
						$temp_plans = array();
						if($i == 1){
							$i++;
							$class = 'active';
						}else{
							$class = '';
						}
						$temp_plans = plans_list_by(['plan_typev2'=>$plan_v2_key]);
						//echo($_SERVER['PHP_SELF']);
						//$i = 0;
						?>
							<div class="tab-pane <?php echo($class); ?>" id="tab_<?php echo($plan_v2_key); ?>">
							<?php
							foreach($temp_plans as $k=>$plan){
								//print_r($plan);
								
								if($plan->plan_type == PLAN_TYPE_ON_TIME){
									$letter_fee = 't';
								}
								if($plan->plan_type == PLAN_TYPE_ON_DEMAND){
									$letter_fee = 'd';
								}
								
								?>
								<div class="col-md-12">
									<div class="box box-primary">
										<div class="box-header">
										  <h3 class="box-title"><?php echo($plan->name); ?> (<?php echo($plan_types_name[$plan->plan_type]); ?>)</h3>
										</div>
										<div class="box-body box-profile">
											<b> <?php echo(t_get_val('Yield')); ?></b> <?php echo($plan->plan_yield); ?> %<br>
											<?php if($plan->plan_time_days){ ?>
											<b> <?php echo(t_get_val('Days')); ?></b> <?php echo($plan->plan_time_days); ?><br>
											<?php } ?>
											<?php 
											if(isset($result[(string)$plan->_id])){
												
												
												
												
												$body = 0;
												$sum_percents = 0;
												$sum_income = 0;
												//Посчитаем суммы прибыле и на плане по транзакциям
												foreach($result[(string)$plan->_id] as $txcalc){
													//echo('<pre>');
													//print_r($txcalc);
													//echo('</pre>');
													
													if(isset($user_plans[$plan->plan_type][(string)$plan->_id][(string)$txcalc->_id])){
														//echo('<pre>');
														//print_r($user_plans[$plan->plan_type][(string)$plan->_id][(string)$txcalc->_id]);
														//echo('</pre>');
														foreach($user_plans[$plan->plan_type][(string)$plan->_id][(string)$txcalc->_id] as $key=>$arrTx){
															$result[(string)$plan->_id][(string)$txcalc->_id][$key] = $arrTx;
														}
													}
													
													
													
													if(isset($txcalc['body'])){
														$body = $body + $txcalc['body'];
													}
													if(isset($txcalc['sum_percents'])){
														$sum_percents = $sum_percents + $txcalc['sum_percents'];
													}
													if(isset($txcalc['sum_income'])){
														$sum_income = $sum_income + $txcalc['sum_income'];
														//echo('<pre>');
														//print_r($txcalc);
														//echo('</pre>');
													}
												}
												if($body > 0){
												?>
												<b><?php echo(t_get_val('body')); ?></b> <?php echo(sprintf('%.8f',$body)); ?><br>
												<?php } ?> 
												
												<?php if($sum_percents > 0){?>
												<b><?php echo(t_get_val('sum_percents')); ?></b> <?php echo(round($sum_percents,2)); ?> %<br
												<?php } ?> 
												
												<?php if($sum_income > 0){ ?>
												
												<b>    <b><?php echo(t_get_val('sum_income')); ?></b> <?php echo(sprintf('%.8f',$sum_income)); ?>
												
												<?php } ?> 
												
												<div class="row">
													<div class="col-md-12 pt15">
														<div class="box box-default collapsed-box">
															<div class="box-header with-border">
															  <h3 class="box-title"><?php echo(t_get_val('See tranz')); ?></h3>

															  <div class="box-tools pull-right">
																<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
																</button>
															  </div>
															  <!-- /.box-tools -->
															</div>
															<!-- /.box-header -->
															<div class="box-body">
																<div class="row tx_wrapper">
																	<?php 
																	foreach($result[(string)$plan->_id] as $txs){
																		show_plans_tx($txs,$plan,$k,$letter_fee,$sum_income,$body);
																	}
																	
																	?>
																</div>
															</div>
														</div>
													</div>
												</div>
												<?php
												  
											}
											  
											?>
											<div class="row">
												<div class="col-md-4 pull-right">
													<a  class="btn btn-info pull-right" data-toggle="modal" data-target="#modal-default<?php echo($modal_num); ?>"><?php echo(t_get_val('Invest')); ?></a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php
								$all_modals[] = '
								<div class="modal fade" id="modal-default'.$modal_num.'">
									  <div class="modal-dialog">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title">'.$plan->name.'</h4>
										  </div>
										  <div class="modal-body">
											<div class="plan_info">
												<div><b class="plan_info_title">'.t_get_val('Comission to popup').'</b>  
												'.get_fee_text($plan->tx_fee_plan_topup).'
												</div>
												<div class="current_com pb15 pt15"><b>'.t_get_val('Current comission').'</b><span class="current_com_result"></span></div>
											</div>
											<div class="row">
												<div class="form-group">
												  <div class="col-sm-10">
													
													'.lang_input('text', 'p_Amount', 'form-control p_Amount min_max','',true,'Amount to invest','data-min="0.000001" data-max="'.sprintf('%.8f',user_get_balance($_SESSION['uid'])).'" ',t_get_val('Unsufficient funds')).'
												  </div>
												</div>
											</div>
										  </div>
										  <div class="modal-footer action_wrapper">
											<button type="button" class="btn btn-default pull-left" data-dismiss="modal">'.t_get_val('Close').'</button>
											<button data-userid="'.$_SESSION['uid'].'" data-nid="'.(string)$plan->_id.'" type="button" class="btn btn-primary invest_do">'.t_get_val('Invest').'</button>
										  </div>
										</div>
										<!-- /.modal-content -->
									  </div>
									  <!-- /.modal-dialog -->
								</div>
								';
								?>
								<?php
								$modal_num++;
							}//plan foreach end
							?>
							</div>
							<?php
							
					}
					?>
						</div> <!-- /.tab-content -->
					</div>
				</div>
			</div>
        </div>
	</div>
	</section>
</div>
<?php 
//Выведем все модалки тут (инача в табах не определяет высоту
echo(implode('',$all_modals));

?>
