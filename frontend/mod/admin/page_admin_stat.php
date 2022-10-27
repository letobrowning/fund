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
		<?php echo(t_get_val('Admin panel')); ?>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> <?php echo(t_get_val('Home')); ?></a></li>
		<li class="active"><?php echo(t_get_val('Admin panel')); ?></li>
	  </ol>
	</section>
		    <!-- Main content -->
    <section class="content">
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
			<?php 
			$current_stat = admin_get_stat();
			
			?>
			  <!-- Profile Image -->
			  <div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo(t_get_val('Generatl stat')); ?></h3>
					</div>
					<div class="box-body box-profile">
							<div class="row">
								<div class="col-md-12 mb30">
									<div class="row">
										<div class="col-md-4">
											<a class="btn btn-info" data-toggle="modal" data-target="#modal-admin_wthdraw"> <?php echo(t_get_val('Wthdraw profit')); ?></a>
											<div class="modal fade" id="modal-admin_wthdraw">
												<div class="modal-dialog">
													<div class="modal-content">
													  <div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														  <span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title"><?php echo(t_get_val('Wthdraw')); ?></h4>
													  </div>
													  <div class="modal-body">
														<div class="row">
															<div class="form-group col-sm-12">
																	<input id="admin_profit_wallet" type="text" name="wallet_to" class="form-control" placeholder="To wallet" required>
																	<span class="help-block" style="display:none;"><?php echo(t_get_val('Set wallet!')); ?></span>
															</div>
															<div class="form-group col-sm-12">
																<input id="admin_profit_amount" type="numeric" name="amount" class="min_max form-control" value="<?php echo(sprintf('%.8f',$current_stat['sum_profit'])); ?>" data-min="0.00001" data-max="<?php echo(sprintf('%.8f',$current_stat['sum_profit'])); ?>" required>
																<span class="help-block" style="display:none;"><?php echo(t_get_val('You have not so mutch btc in profit')); ?></span>
															</div>
														</div>
													  </div>
													  <div class="modal-footer action_wrapper">
														<button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo(t_get_val('Close')); ?></button>
														<button type="button" class="btn btn-info admin_wthdraw_do"><?php echo(t_get_val('Wthdraw')); ?></button>
													  </div>
													</div>
													<!-- /.modal-content -->
												</div>
											  <!-- /.modal-dialog -->
										</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-2">
									<div class="row">
										<div class="col-sm-12 pb10"><b><?php echo(t_get_val('sum_profit')); ?></b></div>
										<div class="col-sm-12"><?php echo(sprintf('%.8f',$current_stat['sum_profit'])); ?></div>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="row">
										<div class="col-sm-12 pb10"><b><?php echo(t_get_val('sum_withdrawn')); ?></b></div>
										<div class="col-sm-12"><?php echo(sprintf('%.8f',$current_stat['sum_withdrawn'])); ?></div>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="row">
										<div class="col-sm-12 pb10"><b><?php echo(t_get_val('sum_em_topped_up')); ?></b></div>
										<div class="col-sm-12"><?php echo(sprintf('%.8f',$current_stat['sum_em_topped_up'])); ?></div>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="row">
										<div class="col-sm-12 pb10"><b><?php echo(t_get_val('sum_available')); ?></b></div>
										<div class="col-sm-12"><?php echo(sprintf('%.8f',$current_stat['sum_available'])); ?></div>
									</div>
								</div>
								<div class="col-sm-2">
									<div class="row">
										<div class="col-sm-12 pb10"><b><?php echo(t_get_val('total_tx_fee_real')); ?></b></div>
										<div class="col-sm-12"><?php echo(sprintf('%.8f',$current_stat['total_tx_fee_real'])); ?></div>
									</div>
								</div>

							</div>
					</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			  <!-- /.box -->
			</div>
		</div>        
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12">
			<?php 
			$current_stat = admin_get_stat();
			
			?>
			  <!-- Profile Image -->
			  <div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo(t_get_val('Stat by user')); ?></h3>
					</div>
					<div class="box-body box-profile">
							<div class="row">
								<div class="col-sm-12">
									<div class="box box-default collapsed-box">
										<div class="box-header with-border">
										  <h3 class="box-title"><?php echo(t_get_val('Show tranz')); ?></h3>

										  <div class="box-tools pull-right">
											<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
											</button>
										  </div>
										  <!-- /.box-tools -->
										</div>
										<!-- /.box-header -->
										<div class="box-body">
											<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">  
												<div class="row">
													<div class="col-sm-12 overfolwxscroll_table">
														<table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
													<thead>
													<tr role="row">
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('user')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('balance')); ?></th>
														<th class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-all_count')); ?><?php echo(lang_tooltip('plan-all_count_t')); ?></th>
														<th class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-pending_count')); ?><?php echo(lang_tooltip('plan-pending_count_t')); ?></th>
														<th class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-need_to_decide_count')); ?><?php echo(lang_tooltip('plan-need_to_decide_count_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-sum_income')); ?><?php echo(lang_tooltip('plan-sum_income_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-sum_body')); ?><?php echo(lang_tooltip('plan-sum_body_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-generated')); ?><?php echo(lang_tooltip('admin_income-generated_t')); ?></th>
														
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_deposit_topups')); ?><?php echo(lang_tooltip('admin_income-from_deposit_topups_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_deposit_withdrawals')); ?><?php echo(lang_tooltip('admin_income-from_deposit_withdrawals_t')); ?></th>
														
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_plan_topups')); ?><?php echo(lang_tooltip('admin_income-from_plan_topups_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_plan_withdrawals')); ?><?php echo(lang_tooltip('admin_income-from_plan_withdrawals_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-penalties')); ?><?php echo(lang_tooltip('admin_income-penalties_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_plan_reinvestments')); ?><?php echo(lang_tooltip('admin_income-from_plan_reinvestments_t')); ?></th>
													</tr>
													</thead>
													<tbody>
														<?php 
														$i = 'odd';
														$edit_url = ['subaction'=>'user_show'];
														foreach($current_stat['stat'] as $stat){
															//print_r($user);
															$edit_url['uwallet'] = $stat['user']['wallet'];
															?>
															<tr role="row" class="<?php echo($i); ?>">
																<td class=""><a  target="_blank" href="/?<?php echo(updateGET($query,$edit_url)); ?>"><?php echo( $stat['user']['email']); ?></a></td>
																<td class=""><?php echo(sprintf('%.8f',$stat['balance'])); ?></td>
																<td class="">
																	<span class="text-green"><?php echo($stat['plan_stat']['all_count']); ?></span>
																</td>
																<td class="">
																	<span class="text-aqua"><?php echo($stat['plan_stat']['pending_count']); ?></span>
																</td>
																<td class="">
																	<span class="text-red"><?php echo($stat['plan_stat']['need_to_decide_count']); ?></span>
																</td>
																<td class=""><?php  echo(sprintf('%.8f',$stat['plan_stat']['sum_income'])) ?></td>
																<td class=""><?php  echo(sprintf('%.8f',$stat['plan_stat']['sum_body'])) ?></td>
																<td class=""><?php echo(sprintf('%.8f',$stat['admin_income']['generated'])); ?></td>
																
																<td class="">
																	<span class="text-green"><?php echo(sprintf('%.8f',$stat['admin_income']['from_deposit_topups'])); ?></span>
																</td>
																<td class="">
																	<span class="text-red"><?php echo(sprintf('%.8f',$stat['admin_income']['from_deposit_withdrawals'])); ?></span>
																</td>
																
																<td class=""><?php echo(sprintf('%.8f',$stat['admin_income']['from_plan_topups'])); ?></td>
																<td class="">	
																	<span class="text-aqua"><?php echo(sprintf('%.8f',$stat['admin_income']['from_plan_withdrawals']['fees'])); ?></span>
																</td>
																<td class="">	
																	<span class="text-red"><?php echo(sprintf('%.8f',$stat['admin_income']['from_plan_withdrawals']['penalties'])); ?></span>
																</td>
																<td class=""><?php echo(sprintf('%.8f',$stat['admin_income']['from_plan_reinvestments'])); ?></td>
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
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('user')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('balance')); ?></th>
														<th class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-all_count')); ?><?php echo(lang_tooltip('plan-all_count_t')); ?></th>
														<th class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-pending_count')); ?><?php echo(lang_tooltip('plan-pending_count_t')); ?></th>
														<th class="" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-need_to_decide_count')); ?><?php echo(lang_tooltip('plan-need_to_decide_count_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-sum_income')); ?><?php echo(lang_tooltip('plan-sum_income_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('plan-sum_body')); ?><?php echo(lang_tooltip('plan-sum_body_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-generated')); ?><?php echo(lang_tooltip('admin_income-generated_t')); ?></th>
														
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_deposit_topups')); ?><?php echo(lang_tooltip('admin_income-from_deposit_topups_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_deposit_withdrawals')); ?><?php echo(lang_tooltip('admin_income-from_deposit_withdrawals_t')); ?></th>
														
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_plan_topups')); ?><?php echo(lang_tooltip('admin_income-from_plan_topups_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_plan_withdrawals')); ?><?php echo(lang_tooltip('admin_income-from_plan_withdrawals_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-penalties')); ?><?php echo(lang_tooltip('admin_income-penalties_t')); ?></th>
														<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" ><?php echo(t_get_val('admin_income-from_plan_reinvestments')); ?><?php echo(lang_tooltip('admin_income-from_plan_reinvestments_t')); ?></th>
													</tr>
													</tfoot>
														</table>
													</div>
												</div>
												  
											</div>
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
			<pre>
				<?php

				//print_r($current_stat); 
				print_r(admin_get_external_topup_stat());
				
				?>
			</pre>
		</div>
	</section>
</div>
<script>
  $(function () {
    $('#example2').DataTable()
  })
</script>