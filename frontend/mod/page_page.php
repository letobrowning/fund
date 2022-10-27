<?php

if(isset($page_type[1]) && strlen($page_type[1]) > 0){
	
	//Проверка на логин
	if(!isset($_SESSION['email']) OR strlen($_SESSION['email']) == 0){
		$only_for_logged = 0;
	}else{
		$only_for_logged = 1;
	}
	
	$current_page = page_list(['slug' => $page_type[1]]);
	if(count($current_page) > 0){
		$current_page = $current_page[0];
		if($current_page['only_for_logged'] != $only_for_logged){
			//Если идет нарушение прав
		}
		$title = $current_page['title'][$_SESSION['lang']];
		?>
		<section class="main_page_section" style="padding-top: 70px;">
			<div class="container">
				<div class="col-sm-12 pb15">
					<h1 class="text-center"><?php 
					echo($title); 
					?></h1> <!-- main_page_t_m_1 -->
				</div>
				<?php echo($current_page['content'][$_SESSION['lang']]); ?>
			</div> <!-- /container -->
		</section>
		<?php
	}
	//$content = $current_page['block_content'][$_SESSION['lang']];
}else{
	
}

?>
	
	
	
