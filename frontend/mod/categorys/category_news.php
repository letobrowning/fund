<?php 
$cat_id = new MongoDB\BSON\ObjectId ('5cb3a234e58faa13270d2fc2');
$category = category_list(['_id'=>$cat_id]);
$current_category = $category[0];
$title = $current_category['title'][$_SESSION['lang']];
$articles = article_list(['category'=>'5cb3a234e58faa13270d2fc2']);
?>
<section id="sm0" class="main_page_section">
	<img src="/img/bg_main2.jpg" class="base_img">
	<div class="text_under">
		<div class="container">		
				<div class="big_title"><?php echo($title); ?></div>			
		</div>
	</div>
</section>
<section id="ns1" class="main_page_section">
	<div class="container">
		<div class="col-sm-12 pt15">
			<div id="news_list" class="row">
				<div class="col-sm-12 pt15 pb30">
					<div class="news_row row">
						<?php 
						$news_per_page = 9;
						$all_articles = article_list(['category'=>'5cb3a234e58faa13270d2fc2']);
						$page_count = round(count($all_articles)/$news_per_page,0);
						if($page_count < count($all_articles)/$news_per_page){
							$page_count++;
						}
						
						$articles = article_list(['category'=>'5cb3a234e58faa13270d2fc2'],['limit' => $news_per_page,"skip" => 0,'sort' => ['time' => -1]]);
						//print_r($articles);
						$i = 0;
						$news_per_row = 3;
						//Будем делать перебор цветов из этого массива со смещением
						$j = 0;
						
						$news_block_colors = ['rgba(245,105,84,0.9)','rgba(243,156,18,0.9)','rgba(0,192,239,0.9)'];
						foreach($articles as $article){
							
							$atitle = $article['title'][$_SESSION['lang']];
							$time = $article['time'];
							if(isset($article['img']) && strlen(trim($article['img'])) > 0){
								$news_img = str_replace($basedir,'',$article['img']);
							}else{
								$news_img = '/img/news_example.jpg';
							}
							$color_num = $i+$j;
							if($color_num == $news_per_row || $color_num > $news_per_row ){
								$color_num = $color_num - $news_per_row;
							}
							?>
							<div class="col-sm-4">
								<div class="news_block" >
									<img src="<?php echo($news_img); ?>" class="news_img">
									<div class="news_content" style="background:<?php echo($news_block_colors[$color_num]); ?>">
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
							$i++;
							//echo();
							if($i == $news_per_row){
								$i = 0;
								$j++; //Смещение по цвету, что бы создать эффект несеммитричности
								if($j == 3){
									$j = 0;
								}
								?>
								<div class="col-sm-12 pt15 pb15"></div>
								<?php
							}
							
						}
						
						?>
					</div>
					<div class="news_pagination mt15">
						<?php 
						if(count($all_articles) > $news_per_page){
							?>
							<ul>
							<?php
							$pa = 1;
							while($page_count > 0){
								if($pa == 1){
								?>
								<li data-page="<?php echo($pa); ?>" class="current_page"><span ><?php echo($pa); ?></span></li>
								<?php
								}else{
									?>
									<li data-page="<?php echo($pa); ?>" class="page"><span ><?php echo($pa); ?></span></li>
									<?php
								}
								$pa++;
								$page_count = $page_count -1;
							}
							
							?>
							</ul>
							<?php
						}
						
						?>
						
					</div>
				</div>
				
			</div>
		</div>
	</div> <!-- /container -->
</section>	
<script>
$(function () {
	jQuery('.news_pagination').on('click', '.page',function (){
		jQuery('li.current_page').removeClass('current_page').addClass('page');
		jQuery(this).removeClass('page').addClass('current_page');
		var new_page = jQuery(this).data('page');
		var data = {};
		data['new_page'] = new_page;
		data['news_per_page'] = <?php echo($news_per_page); ?>;
		console.log(data);
		var url = '/?ajax_action=news_change_page';
		__post(url, data, function (res) {
			//console.log('Пришло');
			if (res) {		
					console.log('Пришло');
					console.log(res);
					if(res.html){
						jQuery('.news_row').html(res.html);
					}
			}	
		});
	});
})
</script>



<!-- Добавить описание категорий в админке, и перенести в faq
<section class="main_page_section odd">
	<div class="container">
		
	</div>
</section>
-->