<?php 
$result = array();
if($_POST){
	$post = $_POST;
	if(isset($post['new_page']) && isset($post['news_per_page']) && count($post) == 2){
		if(is_numeric($post['new_page']) && is_numeric($post['news_per_page'])){
			$result['html'] = '';
			$news_per_page = 6;
			$articles = article_list(['category'=>'5cb3a234e58faa13270d2fc2'],['limit' => (int)$post['news_per_page'],"skip" => (int)$post['news_per_page']*((int)$post['new_page'] - 1),'sort' => ['time' => -1]]);
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
				$result['html'] .= '
				<div class="col-sm-4">
					<div class="news_block" >
						<img src="'.$news_img.'" class="news_img">
						<div class="news_content" style="background:'.$news_block_colors[$color_num].'">
							<div class="news_date">
								'.date('d.m.Y',$time).'
							</div>
							<div class="news_title">
								<span>'.$atitle.'</span>
								<i class="fa fa-fw fa-angle-right"></i>
							</div>
						</div>	
					</div>
				</div>';
				$i++;
				//echo();
				if($i == $news_per_row){
					$i = 0;
					$j++; //Смещение по цвету, что бы создать эффект несеммитричности
					if($j == 3){
						$j = 0;
					}
					$result['html'] .= '<div class="col-sm-12 pt15 pb15"></div>';
				}
				
			}
		}else{
			$result['msg'] = 'False variables type';
		}
	}else{
		$result['msg'] = 'False variables';
	}
}
echo(json_encode($result));
die();
?>