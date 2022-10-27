<?php 
$page_id = new MongoDB\BSON\ObjectId ('5cc33280e58faa68ea067872');
$current_page = page_list(['_id'=>$page_id]);
$current_page = $current_page[0];
$content = $current_page['block_content'][$_SESSION['lang']];
$title = $current_page['title'][$_SESSION['lang']];
$articles = article_list(['category'=>'5cb3a243e58faa59bd7cb022']);
?>
<section id="sm0" class="main_page_section faq_page_top">
	<img src="/img/bg_main2.jpg" class="base_img">
	<div class="text_under">
		<div class="container">		
				<div class="big_title"><?php echo($title); ?></div>			
		</div>
	</div>
</section>
<section id="faq_section" class="main_page_section">
	<div class="container faq">
		<div class="faqs_articles">
		<div class="faq_descr">
			<?php echo($content['info']); ?>
		</div>
		<?php 
		foreach($articles as $article){
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
</section>