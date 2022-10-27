<?php 
$cat_id = new MongoDB\BSON\ObjectId ('5cb3a234e58faa13270d2fc2');
$category = category_list(['_id'=>$cat_id]);
$current_category = $category[0];
$title = $current_category['title'][$_SESSION['lang']];
$articles = article_list(['category'=>'5cb3a234e58faa13270d2fc2']);
?>

<section class="main_page_section" style="padding-top: 80px;">
	<div class="container">
		<div class="col-sm-12 pt15">
			<div class="row">
				<div class="col-sm-12 pb15">
					<h1 class="text-center"><?php echo($title); ?></h1>
				</div>
			</div>
		</div>
	</div> <!-- /container -->
</section>
<section class="main_page_section odd">
	<div class="container">
		<div class="col-sm-12 pt15">
			<div class="row">
				
					<?php 
					foreach($articles as $article){
						$atitle = $article['title'][$_SESSION['lang']];
						$acontent = $article['content'][$_SESSION['lang']];
						if(isset($article['img']) && strlen(trim($article['img'])) > 0){
							$news_img = str_replace($basedir,'',$article['img']);
						}else{
							$news_img = '/img/news_example.jpg';
						}
						?>
						<div class="col-sm-4">
							<div class="box box-primary">
								<div class="box-header with-border">
									<h3 class="box-title"><?php echo($atitle); ?></h3>
								</div>
								<div class="box-body box-profile">
								<?php 
									$cut = 150;
									if(strlen($acontent) > $cut){
										echo(substr(strip_tags($acontent), 0, $cut).'...');
									}else{
										echo($acontent);
									}
								
								?>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				
			</div>
		</div>
	</div> <!-- /container -->
</section>	
<!-- Добавить описание категорий в админке, и перенести в faq
<section class="main_page_section odd">
	<div class="container">
		
	</div>
</section>
-->