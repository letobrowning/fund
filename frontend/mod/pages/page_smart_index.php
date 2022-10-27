<?php 
$page_id = new MongoDB\BSON\ObjectId ('5cc21822e58faa0fad4841d4');
$current_page = page_list(['_id'=>$page_id]);
$current_page = $current_page[0];
$content = $current_page['block_content'][$_SESSION['lang']];
$current_plans_for_type = plans_list_by(['plan_typev2'=>PLAN_TYPE_INDEX]);
?>

<section class="main_page_section" style="padding-top: 70px;">
	<div class="container">
		<div class="col-sm-12 pb15">
			<div class="row">
				<div class="col-sm-8 pb15">
					<h1>SMART INDEX</h1>
				</div>

			</div>
		</div>
	</div> <!-- /container -->
</section>	
<section class="main_page_section odd" style="padding-top: 70px;">
	<div class="container">
		<?php echo($content['info']); ?>
	</div>
</section>
<section class="main_page_section" style="padding-top: 70px;">
	<div class="container">
		<div class="col-sm-12 pb15">
			<h1>SMART INDEX PLANS</h1>
		</div>
		<?php 
		//Выведем планы для данного типа
		foreach($current_plans_for_type as $plan){
			?>
			<div class="col-sm-4">
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
					</div>
					<div class="box-footer box-profile">
						<a href="/?action=plans" class="btn btn-info pull-right">Инвестировать</a>
					</div>
				</div>
			
			</div>
			<?php
		}
		?>
	</div> <!-- /container -->
</section>	
<script src="/frontend/js/chart.js/Chart.js"></script>
<!-- jQuery Knob -->
<script src="/frontend/js/jquery-knob/js/jquery.knob.js"></script>
<!-- Sparkline -->
<script src="/frontend/js/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script>
$( document ).ready(function() {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
	
	$(".sparkline").each(function () {
      var $this = $(this);
      $this.sparkline('html', $this.data());
    });

    /* SPARKLINE DOCUMENTATION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
    drawDocSparklines();
    drawMouseSpeedDemo();
  })
</script>