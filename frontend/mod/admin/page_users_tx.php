<?php include($basedir . '/frontend/sidebar_admin.php'); ?>
<div class="content-wrapper h100vh">
	<section class="content">
      <div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo(t_get_val("Users tx's withdrawal")); ?></h3>
				</div>
				<div class="box-body admin_txs">
					<?php 
					$txs = admin_plans_withdrawal_inquiries();
					?>
					
					<div class="row plans_wrapper">
						<?php if(count($txs['withdrawal_txs']) > 0){ ?>
							<?php $k = 0; ?>
							<?php foreach($txs['withdrawal_txs'] as $wtx){ 
									show_tx_to_apply($wtx,$k);
									$k++;
								} ?>

							<div class="col-sm-12 pb15 pt15 action_wrapper">
								<div class="row">
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-3 pr10"><b><?php echo(t_get_val('Amount to withdrawal')); ?></b></div>
											<div class="col-sm-9 withdrawal_amount">0</div>
										</div>
										<div class="row pt15">
											<div class="col-sm-12">
												<div class="alert alert-danger alert-dismissible withdrawal_alert" style="display:none;">
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
													<h4><i class="icon fa fa-ban"></i><?php echo(t_get_val('Unsufficient funds')); ?></h4>
													<?php echo(t_get_val('Topup wallet')); ?><b><?php echo(admin_get_wallet()); ?></b><?php echo(t_get_val('to amount')); ?><span class="nedd_topopup"></span>,<?php echo(t_get_val('dfsrg43tgdh')); ?> 
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<button type="button" class="btn btn-block btn-success withdrawal_apply"><?php echo(t_get_val('Apply checked')); ?></button>
									</div>
								</div>
								
							</div>
						<?php }else{ ?>
						<div class="col-sm-12 tx_row">
							<div class="row">
								<div class="col-sm-12">
								<?php echo(t_get_val('No data')); ?>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					
					<pre2>
					<?php //print_r($txs); ?>
					</pre2>
				</div>
			</div>			
			
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title"><?php echo(t_get_val("Users tx's reinvest")); ?></h3>
				</div>
				<div class="box-body admin_txs">
					<?php 
					$txs = admin_plans_withdrawal_inquiries();
					?>
					
					<div class="row plans_wrapper">
						<?php if(count($txs['reinvest_txs']) > 0){ ?>
							<?php $k = 0; ?>
							<?php foreach($txs['reinvest_txs'] as $wtx){ 
									show_tx_to_apply($wtx,$k);
									$k++;
								} ?>

							<div class="col-sm-12 pb15 pt15 action_wrapper">
								<div class="row">
									<div class="col-sm-9">
										<div class="row">
											<div class="col-sm-3 pr10"><b><?php echo(t_get_val('Amount to reinvest')); ?></b></div>
											<div class="col-sm-9 withdrawal_amount">0</div>
										</div>
									</div>
									<div class="col-sm-4">
										<button type="button" class="btn btn-block btn-success withdrawal_apply"><?php echo(t_get_val('Apply checked')); ?></button>
									</div>
								</div>
								
							</div>
						<?php }else{ ?>
						<div class="col-sm-12 tx_row">
							<div class="row">
								<div class="col-sm-12">
								<?php echo(t_get_val('No data')); ?>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					
					<pre2>
					<?php //print_r($txs); ?>
					</pre2>
				</div>
			</div>
		</div>
	</section>
</div>