<?php 
$page_id = new MongoDB\BSON\ObjectId ('5cc33280e58faa68ea067872');
$current_page = page_list(['_id'=>$page_id]);
$current_page = $current_page[0];
$content = $current_page['block_content'][$_SESSION['lang']];
$title = $current_page['title'][$_SESSION['lang']];
$articles = article_list(['category'=>'5cb3a243e58faa59bd7cb022']);
?>
<section id="sm0" class="main_page_section">
	<img src="/img/bg_main2.jpg" class="base_img">
	<div class="text_under">
		<div class="container">		
				<div class="big_title"><?php echo($title); ?></div>			
		</div>
	</div>
</section>
<section class="main_page_section odd">
	<div class="container">
		<?php echo($content['info']); ?>
	</div>
</section>
<section class="main_page_section">
	<div class="container">
		<div class="faqs_articles">
		<?php 
		foreach($articles as $article){
			$atitle = $article['title'][$_SESSION['lang']];
			$acontent = $article['content'][$_SESSION['lang']];
			?>
			<div class="box box-info collapsed-box">
				<div class="box-header with-border" data-widget="collapse">
				  <h3 class="box-title"><?php echo($atitle ); ?></h3>

				  <div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" ><i class="fa fa-plus"></i>
					</button>
				  </div>
				  <!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<?php echo($acontent); ?>
				</div>
			</div>
			<?php
		}
		
		?>
		</div>
	</div>
</section>