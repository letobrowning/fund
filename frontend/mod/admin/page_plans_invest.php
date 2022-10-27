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
			<?php echo(t_get_val('Plans')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> <?php echo(t_get_val('Home')); ?></a></li>
			<li class="active"><?php echo(t_get_val('Plans')); ?></li>
		  </ol>
		</section>
		    <!-- Main content -->
    <section class="content">
        <div class="row">

			<div class="plans_wrapper col-md-12">
				<div class="row">
					<pre2>
					<?php 
					//print_r(plans_list_by());
					$all_plans = plans_list_by();
					//print_r(txs_list_by());
					?>
					</pre2>
					<?php 
					//echo($_SERVER['PHP_SELF']);
					$plan_types_name = [2=>'Срочный',4=>'Бессрочный'];
					$edit_url = ['subaction'=>'plan_edit'];
					$i = 0;
					foreach($all_plans as $k=>$plan){
						$plan_pending = plan_get_pending((string)$plan->_id);
						?>
						<div class="col-md-6">
							<div class="box box-primary">
								<div class="box-header">
								  <h3 class="box-title"><?php echo($plan->name); ?> (<?php echo($plan_types_name[$plan->plan_type]); ?>)</h3>
								</div>
								<div class="box-body box-profile">
									<b><?php echo(t_get_val('Yield')); ?> </b> <?php echo($plan->plan_yield); ?> %<br>
									<?php if($plan->plan_time_days){ ?>
									<b> <?php echo(t_get_val('Days')); ?></b> <?php echo($plan->plan_time_days); ?><br>
									<?php } ?>
									<b><?php echo(t_get_val('Plan Type v2')); ?> </b> <?php echo($plan_v2_texts[$plan->plan_typev2]); ?><br>
									<?php 
									$edit_url['plan_id'] = (string)$plan->_id;
									//print_r($edit_url);
									//echo(updateGET($query,$edit_url));
									?>
									<div class="row">
										<div class="col-md-12 pb15">
											<b><?php echo(t_get_val('Invest tranz')); ?></b> <?php echo(sprintf('%-010f',$plan_pending)); ?>
											<?php 
											
											
											?>
										</div>
										<?php if($plan_pending > 0){ 
										
										$pending_as_user_wallets = plan_get_pending_as_user_wallets((string)$plan->_id);
										//print_r($pending_as_user_wallets);
										
										?>
										<div class="col-md-12">
											<div class="box box-default collapsed-box">
												<div class="box-header with-border">
												  <h3 class="box-title"><?php echo(t_get_val('See tranz by users')); ?></h3>

												  <div class="box-tools pull-right">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
													</button>
												  </div>
												  <!-- /.box-tools -->
												</div>
												<!-- /.box-header -->
												<div class="box-body">
													<div class="row">
													<?php 
													
													
													//print_r($pending_as_txs);
													foreach($pending_as_user_wallets as $pending_wallet){
														//print_r($pending_wallet);
														$wallet = (string)$pending_wallet->_id;
														//echo($wallet);
														$uemail = users_list(['wallet'=>$wallet])[0]['email'];
														$edit_url['email'] = $uemail;
														$edit_url['subaction'] = 'user_show';
												  
													  ?>
														
														<div class="col-sm-4"><a target="_blank" href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo($uemail); ?></a></div>
														<div class="col-sm-4"><?php echo(sprintf('%-010f',$pending_wallet->amount)); ?></div>
													<?php } ?>
													</div>
												</div>
										    </div>
										</div>
										
										<div class="col-md-12">
											<div class="box box-default collapsed-box">
												<div class="box-header with-border">
												  <h3 class="box-title"><?php echo(t_get_val('See tranz by tx')); ?></h3>

												  <div class="box-tools pull-right">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
													</button>
												  </div>
												  <!-- /.box-tools -->
												</div>
												<!-- /.box-header -->
												<div class="box-body">
													
													<?php 
													
													$pending_as_txs = plan_get_pending_as_txs((string)$plan->_id);
													//print_r($pending_as_txs);
													foreach($pending_as_txs as $pending_tx){
														//print_r($pending_tx);
														$tid = (string)$pending_tx->_id;
														$tid2 = new MongoDB\BSON\ObjectId ($tid);
														//print_r($tid);
														$tx_list = txs_list_by(['_id'=>$tid2]);
														//$wallet = (string)$pending_wallet->_id;
														//echo($wallet);
														//$uemail = users_list(['wallet'=>$wallet])[0]['email'];
														?>
														<div class="row pb10">
														<?php
															foreach($tx_list as $tx){
																//print_r($tx);
																//echo($tx->from_address);
																//$uemail = users_list(['wallet'=>$tx->from_address])[0]['email'];
																//echo($uemail);
																$edit_url['email'] = $uemail;
																$edit_url['subaction'] = 'user_show';
																?>
																<div class="col-sm-4">
																	<?php echo(date('d.m.Y H:i:s',$tx->time_ts)); ?>
																</div>
																<div class="col-sm-4">
																	<?php echo(sprintf('%-010f',$tx->amount)); ?>
																</div>
																<div class="col-sm-4">
																	<a target="_blank" href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo($uemail); ?></a>
																</div>
																
																<?php
															}
														?>
														</div>
														<?php
													} ?>
													
												</div>
										    </div>
										</div>
										<?php } ?>
									</div>
								</div>
								<?php if($plan_pending > 0){ ?>
								<div class="box-footer">
									<div class="row">
										<div class="col-md-3">
											<button type="button" data-toggle="modal" data-target="#modal-reject<?php echo($k); ?>" class="btn btn-block btn-danger"><?php echo(t_get_val('Reject')); ?></button>
										</div>
										<div class="modal fade" id="modal-reject<?php echo($k); ?>">
										  <div class="modal-dialog">
												<div class="modal-content">
												  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title"><?php echo(t_get_val('Reject to')); ?> <?php echo($plan->name); ?></h4>
												  </div>
												  <div class="modal-body">
													<div class="row">
														<div class="form-group">
														  <div class="col-sm-12">
															<?php echo(lang_input('text', 'reason', 'form-control reason','',true,'Reason')); ?>
														  </div>
														</div>
														<div class="col-sm-12 pt15">
															<div class="alert alert-danger alert-dismissible modal_error" style="display:none;">
																<?php echo(t_get_val('Set reason')); ?>
															</div>
														</div>
													</div>
												  </div>
												  <div class="modal-footer action_wrapper">
													<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo(t_get_val('Close')); ?></button>
													<button data-nid="<?php echo((string)$plan->_id); ?>" type="button" class="btn btn-danger reject_do"><?php echo(t_get_val('Reject')); ?></button>
												  </div>
												</div>
												<!-- /.modal-content -->
											  </div>
											  <!-- /.modal-dialog -->
										</div>
										<div class="col-md-4 pull-right">
											<button type="button" data-toggle="modal" data-target="#modal-submit<?php echo($k); ?>" class="btn btn-block btn-info "><?php echo(t_get_val('Sumbit')); ?></button>
										</div>
										<div class="modal fade" id="modal-submit<?php echo($k); ?>">
										  <div class="modal-dialog">
												<div class="modal-content">
												  <div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													  <span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title"> <?php echo(t_get_val('Submit to')); ?> <?php echo($plan->name); ?></h4>
												  </div>
												  <div class="modal-body">
													<div class="row">
														<div class="form-group">
														  <div class="col-sm-12">
															<?php echo(lang_input('text', 'addr_to', 'form-control addr_to','',true,'Wallet')); ?>
														  </div>
														</div>
														<div class="col-sm-12 pt15">
															<div class="alert alert-danger alert-dismissible modal_error" style="display:none;">
																<?php echo(t_get_val('Set wallet')); ?>
															</div>
														</div>
													</div>
												  </div>
												  <div class="modal-footer">
													<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo(t_get_val('Close')); ?></button>
													<button data-nid="<?php echo((string)$plan->_id); ?>" type="button" class="btn btn-info submit_do"><?php echo(t_get_val('Submit')); ?></button>
												  </div>
												</div>
												<!-- /.modal-content -->
											  </div>
											  <!-- /.modal-dialog -->
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php
						$i++;
						if($i == 2){
							$i = 0;
							?>
							<div class="col-md-12"></div>
							<?php
						}
					}
					
					?>
				</div>
			</div>
		</div>
	</section>
</div>