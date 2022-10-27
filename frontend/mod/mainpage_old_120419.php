
	<script src="/frontend/js/chart.js/Chart.js"></script>
	<section class="main_page_section" style="padding-top: 70px;">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center"><?php echo(t_get_val('main_page_t1')); ?></h1>
			</div>
			<div class="col-sm-12 pt15 pb15">
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
					<div class="col-sm-12">
						 <?php echo(t_get_val('main_page1',false,['textarea','tinymce'])); ?>
					</div>

				</div>
			</div>
		</div> <!-- /container -->
	</section>	

	<section class="main_page_section odd">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center"><?php echo(t_get_val('main_page_t2')); ?></h1>
			</div>
			<div class="col-sm-12 pt15 pb15">
				<div class="row flex alignitemscenter justifycontentcenter how_work_wrapper">
					<div class="how_work_block ">
						<span class="text-center">
						Купите <i class="fa fa-fw fa-bitcoin"></i><br> и пополните счет <!-- main_page_t2st1 -->
						</span>
					</div>
					<div class="arr_blox flex alignitemscenter justifycontentcenter">
						
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
					<div class="how_work_block text-center">
						Выберите лучший INDEX <!-- main_page_t2st2 -->
					</div>
					<div class="arr_blox flex alignitemscenter justifycontentcenter">
						
						<span class="glyphicon glyphicon-chevron-right"></span>
					</div>
					<div class="how_work_block ">
						<span class="text-center">
						Следите за статистикой<br> <!-- main_page_t2st3 -->
						 <span id="linecustom">8,4,1,4,4,10,4,6,5,9,10,10,4,6,5,9,10</span>
						</span>
					</div>
				</div>
			</div>
		</div> <!-- /container -->
	</section>
	<section class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center"><?php echo(t_get_val('main_page_t3')); ?></h1>
			</div>
			<div class="col-sm-12 pt15 pb15">
				<div class="row">
					<div class="col-sm-12">
						 <?php echo(t_get_val('main_page_text3',false,['textarea','tinymce'])); ?>
					</div>

				</div>
			</div>
		</div> <!-- /container -->
	</section>	
	<section class="main_page_section odd">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center"><?php echo(t_get_val('main_page_t4')); ?></h1>
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
	
	<section class="main_page_section">
		<div class="container">
			<div class="col-sm-12 pb15">
				<h1 class="text-center"><?php echo(t_get_val('main_page_t5')); ?></h1>
			</div>
			<div class="col-sm-12 pt15 pb30">
				<div class="row">
					<div class="col-sm-4 flex alignitemscenter justifycontentcenter">
						<span class="text flex alignitemscenter">
							<h3 class="line_right"></h3><h3 class="ddotted">Покупка</h3><h3 class="nm mt4 ml5"> в один клик</h3><!-- main_page_t5st1 -->
							<h3 class="nm mt4 ml5 roundedborder">1</h3>
						</span>
					</div>					
					<div class="col-sm-5 flex alignitemscenter justifycontentcenter">
						<span class="text flex alignitemscenter">
							<h3 class="line_right"></h3><h3 class="ddotted">Учет финансов</h3><!-- main_page_t5st2 -->
							<span id="linecustom2">8,4,1,4,4,10,4,6,5,9,10,10,4,6,5,9,10</span>
						</span>
					</div>					
					<div class="col-sm-3 flex alignitemscenter justifycontentcenter">
						<span class="text flex alignitemscenter">
							<h3 class="line_right"></h3><h3 class="ddotted">Стратегия</h3><!-- main_page_t5st3 -->
						</span>
					</div>
				</div>
				
			</div>
			<div class="col-sm-12 pt30 pb15 flex justifycontentcenter">
					<div class="col-sm-8">
						<a href="/?action=register" class="btn btn-block btn-info btn-lg">Регистрация</a>
					</div>
				</div>
		</div> <!-- /container -->
	</section>	
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ICI</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Инвестиции</a></li>
            <li><a href="#">Крипто</a></li>
            <li><a href="#">Индекс</a></li>

          </ul>
          <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Ru <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">Ru</a></li>
                <li><a href="#">En</a></li>
              </ul>
            </li>
            <li><a href="/?action=login">Login</a></li>
            <li><a href="/?action=register">Reg</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
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
	
	
	$(".sparkline").each(function () {
      var $this = $(this);
      $this.sparkline('html', $this.data());
    });

    /* SPARKLINE DOCUMENTATION EXAMPLES http://omnipotent.net/jquery.sparkline/#s-about */
    drawDocSparklines();
    drawMouseSpeedDemo();
  })
</script>