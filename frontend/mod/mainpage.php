<?php
$page_id = new MongoDB\BSON\ObjectId ('5cb09608e58faa4df30f5cd2');
$current_page = page_list(['_id'=>$page_id]);
$current_page = $current_page[0];
$content = $current_page['block_content'][$_SESSION['lang']];

?>

	<script src="/frontend/js/chart.js/Chart.js"></script>
	<section id="sm0" class="main_page_section">
		<img src="/img/bg_main2.jpg" class="base_img">
		<div class="text_under">
			<div class="container">		
					<div class="big_title">Фонд ICI</div>
					<div class="small_title">Начни зарабатывать прямо сейчас!</div>	
					<a href="/?action=register" class="btn btn-primary ">Присоединиться</a>					
			</div>
		</div>
	</section>
	<section id="sm1" class="main_page_section first_main_section">
		<div class="container smart_blocks">
			<div class="col-sm-4">
				<img src="/img/smart_example.png">
				<div class="text_under smart_trading">
					<div class="col-sm-12 pb15">
						<h1 class="text-center"><?php 
						echo($content['main_page_t_m_1']); 
						?></h1> <!-- main_page_t_m_1 -->
					</div>
					<div class="col-sm-12 pb15">
						<div class="row">
							<div class="col-sm-6 text_block">
								<?php echo($content['main_page_d_m_1']); ?> <!-- main_page_d_m_1 -->
							</div>
							<div class="col-sm-6">
								<span class="text flex alignitemscenter">		
									<span id="linecustom3">8,4,1,2,4,10,4,6,-13,9,7,8,2,3,5,11,20</span>
								</span>
							</div>
						</div>
					</div>
					<div class="col-sm-12 main_page_main_s_action text-center">
						<a href="/page/smart_trading/" class="btn btn-primary "><?php echo(t_get_val('Show more')); ?></a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<img src="/img/smart_example.png">
				<div class="text_under smart_mining">
					<div class="col-sm-12 pb15">
						<h1 class="text-center"><?php 
						echo($content['main_page_t_m_2']); 
						?></h1> <!-- main_page_t_m_2 -->
					</div>
					<div class="col-sm-12 main_page_main_s_action text-center">
						<a href="/page/smart_mining/" class="btn btn-primary "><?php echo(t_get_val('Show more')); ?></a>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<img src="/img/smart_example.png">
				<div class="text_under smart_index">
					<div class="col-sm-12 pb15">
						<h1 class="text-center"><?php 
						echo($content['main_page_t_m_3']); 
						?></h1> <!-- main_page_t_m_3 -->
					</div>
					<div class="col-sm-12 pb15">
						<div class="row chart_row">
							<div class="col-sm-4">
								<canvas id="pieChartm1" style="height:150px"></canvas>
							</div>
							<div class="col-sm-4">
								<canvas id="pieChartm2" style="height:150px"></canvas>
							</div>
							<div class="col-sm-4">
								<canvas id="pieChartm3" style="height:150px"></canvas>
							</div>
						</div>
					</div>
					<div class="col-sm-12 main_page_main_s_action text-center">
						<a href="/page/smart_index/" class="btn btn-primary "><?php echo(t_get_val('Show more')); ?></a>
					</div>
				</div>
			</div>
		</div> <!-- /container -->
	</section>	
	
	<section id="sm2" class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center block_header"><?php 
				echo($content['main_page_t1']); 
				//echo(t_get_val('main_page_t1')); 
				?></h1>
			</div>
			<div class="col-sm-12 pt15 pb15 block_content">
				<div class="row flex alignitemscenter">
					<div class="col-sm-6">
					<!-- Надписи поверх блоков -->
						  <canvas id="pieChart" style="height:250px"></canvas>
					</div>
					<div class="col-sm-6">
						<div class="coin_box">
							<span>B</span><span>L</span><span>E</span><span>D</span><span>Z</span><span>R</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-12 pt15 pb15">
				<div class="row">
					<div class="col-sm-12 block_decr">
						 <?php 
						 echo($content['main_page1']); 
						 //echo(t_get_val('main_page1',false,['textarea','tinymce']));
						 
						 ?>
					</div>

				</div>
			</div>
		</div> <!-- /container -->
	</section>	

	<section id="sm3" class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center"><?php 
				echo($content['main_page_t2']); 
				//echo(t_get_val('main_page_t2')); 
				?></h1>
			</div>
			<div class="col-sm-12 pt15 pb15">
				<div class="row flex alignitemscenter justifycontentcenter how_work_wrapper">
					<div class="how_work_block ">
						<div class="how_work_number">1</div>
						<span class="text-center">
						<?php echo($content['main_page_t2st1']); ?>  <!-- main_page_t2st1 -->
						</span>
					</div>
					<div class="arr_blox flex alignitemscenter justifycontentcenter">
						
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
					<div class="how_work_block text-center">
						<div class="how_work_number">2</div>
						<?php echo($content['main_page_t2st2']); ?> <!-- main_page_t2st2 -->
					</div>
					<div class="arr_blox flex alignitemscenter justifycontentcenter">
						
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
					<div class="how_work_block ">
						<div class="how_work_number">3</div>
						<span class="text-center">
						<?php echo($content['main_page_t2st3']); ?><br> <!-- main_page_t2st3 -->
						 <span id="linecustom">8,4,1,4,4,10,4,6,5,9,10,10,4,6,5,9,10</span>
						</span>
					</div>
				</div>
			</div>
		</div> <!-- /container -->
	</section>
	<section id="sm4" class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center block_header"><?php 
				echo($content['main_page_t3']);
				//echo(t_get_val('main_page_t3')); 
				
				?></h1>
			</div>
			<div class="col-sm-12 pt15 pb15">
				<div class="row">
					<div class="col-sm-12 block_decr">
						 <?php 
						 echo($content['main_page_text3']);
						// echo(t_get_val('main_page_text3',false,['textarea','tinymce'])); 
						 
						 ?>
					</div>

				</div>
			</div>
		</div> <!-- /container -->
	</section>	
	<section id="sm5" class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center"><?php 
				echo($content['main_page_t4']);
				//echo(t_get_val('main_page_t4')); 
				?></h1>
			</div>
			<div class="col-sm-12 pt15 pb15">
				<div class="row">
					<div class="col-sm-6 flex alignitemscenter">
						 <h3 class="text-center nm mr15">INDEX 1</h3>
						 <span id="normalline">-8,4,-1,4,4,10,-10,10,-10,4,6,5,9,10</span>
					</div>					
					<div class="col-sm-6 flex alignitemscenter">
						 <h3 class="text-center nm mr15">INDEX 2</h3>
						 <span id="normalline2">-6,2,-1,4,4,5,-5,6,-6,4,6,5,9,8</span>
					</div>

				</div>
			</div>
		</div> <!-- /container -->
	</section>		
	
	<section id="sm6" class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center block_header"><?php 
				echo($content['main_page_t5']);
				//echo(t_get_val('main_page_t5')); 
				?></h1>
			</div>
			<div class="col-sm-12 pt15 pb30">
				<div class="row why_block_wrapper">
					<div class="col-sm-4 flex alignitemscenter justifycontentcenter">
						<div class="why_block">
							<div class="why_block_number">1</div>
							<div class="why_block_content">
								<span class="text flex alignitemscenter block_decr">
									<?php echo($content['main_page_t5st1']); ?><!-- main_page_t5st1 -->
								</span>
							</div>
						</div>
					</div>					
					<div class="col-sm-4 flex alignitemscenter justifycontentcenter">
						<div class="why_block">
							<div class="why_block_number">2</div>
							<div class="why_block_content block_decr">
								<span><?php echo($content['main_page_t5st2']); ?></span><!-- main_page_t5st2 -->
							<span id="linecustom2">8,4,1,4,4,10,4,6,5,9,10,10,4,6,5,9,10</span>
							</div>
						</div>
					</div>					
					<div class="col-sm-4 flex alignitemscenter justifycontentcenter">
						<div class="why_block">
							<div class="why_block_number">3</div>
							<div class="why_block_content block_decr">
								<span><?php echo($content['main_page_t5st3']); ?></span><!-- main_page_t5st3 -->
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-sm-12 pt30 pb15 flex justifycontentcenter">
					<div class="col-sm-8 text-center">
						<a href="/?action=register" class="btn btn-info btn-lg">Регистрация</a>
					</div>
				</div>
		</div> <!-- /container -->
	</section>	
	
	
	<section id="sm7" class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center block_header">Наши новости</h1>
			</div>
			<div class="col-sm-12 pt15 pb30">
				<div class="row news_row">
					<?php 
					$articles = article_list(['category'=>'5cb3a234e58faa13270d2fc2'],['limit'=>3]);
					//print_r($articles);
					foreach($articles as $article){
						$atitle = $article['title'][$_SESSION['lang']];
						$time = $article['time'];
						if(isset($article['img']) && strlen(trim($article['img'])) > 0){
							$news_img = str_replace($basedir,'',$article['img']);
						}else{
							$news_img = '/img/news_example.jpg';
						}
						?>
						<div class="col-sm-4">
							<div class="news_block">
								<img src="<?php echo($news_img); ?>" class="news_img">
								<div class="news_content">
									<div class="news_date">
										<?php echo(date('d.m.Y',$time)); ?>
									</div>
									<div class="news_title">
										<span><?php echo($atitle); ?></span>
										<i class="fa fa-fw fa-angle-right"></i>
									</div>
								</div>	
							</div>
						</div>
						<?php
						
					}
					
					?>
				</div>
				
			</div>
			<div class="col-sm-12 pt30 pb15 flex justifycontentcenter">
				<div class="col-sm-8 text-center">
					<a href="/category/news" class="btn btn-info btn-lg">Все новости</a>
				</div>
			</div>
		</div> <!-- /container -->
	</section>		
	
	
	<section id="sm8" class="main_page_section">
		<div class="container">
			<div class="col-sm-6 testim">
				<div class="row">
					<div class="col-sm-12">
						<div class="block_title">Отзывы</div>
						<div class="test_block">
							<div class="single_test">
								<div class="test_content">
									<p>Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание Большое описание</p>
								</div>
								<div class="single_test_author">
									<div class="name">
										<i class="fa fa-fw fa-quote-right"></i>
										<span>Иванов Иван Иванович</span>
										<span class="small">Главный директо компании</span>
									</div>
									<div class="t_img">
										<img src="/img/test_example.jpg">
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 faq">
				<div class="col-sm-12">
					<div class="block_title">FAQ</div>
					<?php 
					$faq_articles = article_list(['category'=>'5cb3a243e58faa59bd7cb022']);

					foreach($faq_articles as $article){
						$atitle = $article['title'][$_SESSION['lang']];
						$acontent = $article['content'][$_SESSION['lang']];
						?>
						<div class="box box-info collapsed-box">
							<div class="box-header with-border" data-widget="collapse">
								<div class="box-tools">
									<button type="button" class="btn btn-box-tool" ><i class="fa fa-plus"></i>
									</button>
								</div>
								<h3 class="box-title"><?php echo($atitle ); ?></h3>
							</div>
							<div class="box-body" style="display:none;">
								<?php echo($acontent); ?>
							</div>
						</div>
						<?php
					}
					
					?>
				</div>
			</div>
		</div> <!-- /container -->
	</section>	

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





    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      {
        value    : 700,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Btc'
      },
      {
        value    : 500,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'L'
      },
      {
        value    : 400,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Eth'
      },
      {
        value    : 600,
        color    : '#00c0ef',
        highlight: '#00c0ef',
        label    : 'D'
      },
      {
        value    : 300,
        color    : '#3c8dbc',
        highlight: '#3c8dbc',
        label    : 'Z'
      },
      {
        value    : 100,
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'R'
      }
    ]
    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
	
	//section 1 chart 1
	var pieChartCanvas = $('#pieChartm1').get(0).getContext('2d');
    var pieChart       = new Chart(pieChartCanvas);
	pieChart.Doughnut(PieData, pieOptions);
	
	//section 1 chart 2
	var PieData        = [
      {
        value    : 300,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Btc'
      },
      {
        value    : 500,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'L'
      },
      {
        value    : 400,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Eth'
      },
      {
        value    : 150,
        color    : '#d2d6de',
        highlight: '#d2d6de',
        label    : 'R'
      }
    ]
	var pieChartCanvas = $('#pieChartm2').get(0).getContext('2d');
    var pieChart       = new Chart(pieChartCanvas);
	pieChart.Doughnut(PieData, pieOptions);
	
	//section 1 chart 3
	var PieData        = [
      {
        value    : 700,
        color    : '#f56954',
        highlight: '#f56954',
        label    : 'Btc'
      },
      {
        value    : 500,
        color    : '#00a65a',
        highlight: '#00a65a',
        label    : 'L'
      },
      {
        value    : 400,
        color    : '#f39c12',
        highlight: '#f39c12',
        label    : 'Eth'
      }
    ]
	var pieChartCanvas = $('#pieChartm3').get(0).getContext('2d');
    var pieChart       = new Chart(pieChartCanvas);
	pieChart.Doughnut(PieData, pieOptions);
	
	$(".sparkline").each(function () {
      var $this = $(this);
      $this.sparkline('html', $this.data());
    });

    /* SPARKLINE DOCUMENTATION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
    drawDocSparklines();
    drawMouseSpeedDemo();
  })
</script>