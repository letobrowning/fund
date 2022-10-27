
	<?php 
		//Тест отправки письма
		//send_mail('icifund@yandex.ru','Register success','Register success');
	
	
		//Выбираем меню для пользователя
		if(!isset($_SESSION['email']) OR strlen($_SESSION['email']) == 0){
			$current_menu = menu_list(['menu_id' => 1]);
		}else{
			$current_menu = menu_list(['menu_id' => 2]);
		}
		$current_menu = $current_menu[0];
		//print_r($current_menu); 
	
	?>

			    <!-- Fixed navbar -->
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
			<?php 
			$query = $_GET;
			$query_temp = $query;
			unset($query_temp['lang']);
			if(count($query_temp) == 0){
				$_GET['slug'] = 'main';
			}
			//echo('<pre>');
			//print_r($current_menu['items']);
			//echo('</pre>');
			foreach($current_menu['items'] as $item_slug=>$item_text){
				if($item_text['type'] == 'page'){
					$current_page = page_list(['slug' => $item_slug]);
					$current_page = $current_page[0];
				}
				if($item_text['type'] == 'category'){
					$current_page = category_list(['slug' => $item_slug]);
					$current_page = $current_page[0];
				}
				$item_type = $item_text['type'];
				if(isset($page_type[0]) && strlen($page_type[0]) > 0){
					if($page_type[0] == $item_slug || $page_type[0] == $item_type){
						if(isset($page_type[1]) && strlen($page_type[1]) > 0){
							if($page_type[1] == $item_slug){
								$class = 'class="active"';
							}else{
								$class = '';
							}
						}else{
							$class = 'class="active"';
						}
					}else{
						$class = '';
					}
				}
				if($item_slug != 'main'){
					$href = '/'.$item_type.'/'.$item_slug;
				}else{
					$href = '/';
				}
				?>
					<li <?php echo($class); ?>><a href="<?php echo($href); ?>"><?php echo($current_page['title'][$_SESSION['lang']]); ?></a></li>
				<?php
			}
			
			
			?>
           <!-- <li class="active"><a href="#">Инвестиции</a></li>
            <li><a href="#">Крипто</a></li>
            <li><a href="#">Индекс</a></li> -->

          </ul>
          <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo($_SESSION['lang']); ?><span class="caret"></span></a>
              <ul class="dropdown-menu">
				<?Php 
					$all_lang = get_all_lang_name();
					$request = $_SERVER['REQUEST_URI'];
					$request = substr($request, 1);
					$get_pos = strpos($request,'?');
					if($get_pos === false){
						
					}else{
						$request = substr($request, 0, $get_pos);
					}
					foreach($all_lang as $sidebar_lang){
						if($_SESSION['lang'] != $sidebar_lang){
							$get_q = updateGET($query,['lang'=>$sidebar_lang]);
							?>
							<li>
								<a href="/<?php echo($request.'?'.$get_q); ?>" class="w100 text-uppercase"><b><?php echo($sidebar_lang); ?></b></a>
							</li>
							<?php
						}
					}
				?>
                <!-- <li><a href="#">Ru</a></li>
                <li><a href="#">En</a></li> -->
              </ul>
            </li>
            <li><a href="/?action=login">Login</a></li>
            <li><a href="/?action=register">Reg</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<div class="front_content">