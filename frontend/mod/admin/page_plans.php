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
			<div class="col-md-12 mb30">
				<div class="row">
					<div class="col-md-4">
						<a href="/?action=admin&subaction=plan_create" class="btn btn-info"><?php echo(t_get_val('Create')); ?></a>
					</div>
				</div>
			</div>
			<div class="plans_wrapper plans_tab_admin col-md-12">
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
					$edit_url = ['subaction'=>'plan_edit'];
					foreach($plan_v2_texts as $plan_v2_key=>$plan_v2_text){
						$temp_plans = array();
						if($i == 1){
							$i++;
							$class = 'active';
						}else{
							$class = '';
						}
						$temp_plans = plans_list_by(['plan_typev2'=>$plan_v2_key]);
						?>
						<div class="tab-pane <?php echo($class); ?>" id="tab_<?php echo($plan_v2_key); ?>">
							<?php 
							if(count($temp_plans) > 0){
								foreach($temp_plans as $k=>$plan){
									?>
									<div class="col-md-6">
										<div class="box box-primary">
											<div class="box-header">
											  <h3 class="box-title"><?php echo($plan->name); ?> (<?php echo($plan_types_name[$plan->plan_type]); ?>)</h3>
											</div>
											<div class="box-body box-profile">
												<b><?php echo(t_get_val('Yield')); ?> </b> <?php echo($plan->plan_yield); ?> %<br>
												<?php if($plan->plan_time_days){ ?>
												<b><?php echo(t_get_val('Days')); ?> </b> <?php echo($plan->plan_time_days); ?><br>
												<?php } ?>
												<b><?php echo(t_get_val('Plan Type v2')); ?> </b> <?php echo($plan_v2_texts[$plan->plan_typev2]); ?><br>
												<?php 
												$edit_url['plan_id'] = (string)$plan->_id;
												//print_r($edit_url);
												//echo(updateGET($query,$edit_url));
												?>
												<div class="row">
													<div class="col-md-4 pull-right">
														<a href="/?<?php echo(updateGET($query,$edit_url)); ?>" class="btn btn-info pull-right"><?php echo(t_get_val('Update')); ?></a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<?php
									
								}
							}else{
								
							}
							
							?>
						</div>
						<?php
					}
					
					?>
				</div>
			</div>
		</div>
	</section>
</div>