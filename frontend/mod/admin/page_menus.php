<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: http://95.179.236.117/?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');
/*
//Создание меню

$data = array();
$data['menu_id'] = 1;
$data['menu_title'] = 'Menu for all';
menu_create($data);
$data = array();
$data['menu_id'] = 2;
$data['menu_title'] = 'Menu for logged in';
menu_create($data);
*/
//menu_create


?>
 <div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('Admin panel')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i><?php echo(t_get_val('Home')); ?></a></li>
			<li class="active"><?php echo(t_get_val('Admin panel')); ?></li>
		  </ol>
		</section>
		    <!-- Main content -->
    <section class="content">
        <div class="row menu_row">
			<pre2>
				<?php //print_r(menu_list()); ?>
			</pre2>
			<div class="col-lg-12 col-md-12 col-sm-12">
			  <!-- Profile Image -->
				<div class="row">
					<?php
					$pages = page_list();
					?>
					<div class="col-sm-4">
						<div class="box box-primary">
							<div class="box-header with-border">
							  <h3 class="box-title"><?php echo(t_get_val('Pages')); ?></h3>
							</div>
							<div class="box-body box-profile">
								<ul id="sortable1" class="connectedSortable">
									<?php 
									foreach($pages as $page){
										?>
										 <li class="ui-state-default" data-type="page" data-item_id="<?php echo($page['slug']); ?>"><?php echo($page['title'][$_SESSION['lang']]); ?></li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>
						<div class="box box-primary">
							<div class="box-header with-border">
							  <h3 class="box-title"><?php echo(t_get_val('categorys')); ?></h3>
							</div>
							<div class="box-body box-profile">
								<ul id="sortable11" class="connectedSortable">
									<?php 
									$categorys = category_list();
									foreach($categorys as $category){
										?>
										 <li class="ui-state-default" data-type="category" data-item_id="<?php echo($category['slug']); ?>"><?php echo($category['title'][$_SESSION['lang']]); ?></li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>
					</div> 
					
					<div class="col-sm-4">
						<div class="box box-primary" data-menu_type="1">
							<div class="box-header with-border">
							  <h3 class="box-title"><?php echo(t_get_val('Menu for all')); ?></h3>
							</div>
							<div class="box-body box-profile">
								<ul id="sortable2" class="connectedSortable">
									<?php 
									//5cb0c287e58faa73ab087602
									$current_menu = menu_list(['menu_id' => 1]);
									$current_menu = $current_menu[0];
									//print_r($current_menu);
									foreach($current_menu['items'] as $item_slug=>$item_text){
										//print_r($item_text);
										if($item_text['type'] == 'page'){
											$current_page = page_list(['slug' => $item_slug]);
											$current = $current_page[0];
										}else{
											$current_category = category_list(['slug' => $item_slug]);
											$current = $current_category[0];
										}
										?>
										<li class="ui-state-default" data-type="<?php echo($item_text['type']); ?>" data-item_id="<?php echo($current['slug']); ?>"><?php echo($current['title'][$_SESSION['lang']]); ?></li>
										<?php
									}
									?>

								</ul>
							</div>
							<div class="box-footer action_wrapper">
								<button class="btn btn-info pull-right menu_save"><?php echo(t_get_val('Update')); ?></button>
							</div>
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="box box-primary" data-menu_type="2">
							<div class="box-header with-border">
							  <h3 class="box-title"><?php echo(t_get_val('Menu for logged in')); ?></h3>
							</div>
							<div class="box-body box-profile">
								<ul id="sortable3" class="connectedSortable">
									<?php 
									//5cb0c287e58faa73ab087603
									$current_menu = menu_list(['menu_id' => 2]);
									$current_menu = $current_menu[0];
									//print_r($current_menu);
									foreach($current_menu['items'] as $item_slug=>$item_text){
										if($item_text['type'] == 'page'){
											$current_page = page_list(['slug' => $item_slug]);
											$current = $current_page[0];
										}else{
											$current_category = category_list(['slug' => $item_slug]);
											$current = $current_category[0];
										}
										?>
										<li class="ui-state-default" data-item_id="<?php echo($current['slug']); ?>"><?php echo($current['title'][$_SESSION['lang']]); ?></li>
										<?php
									}
									?>
								</ul>
							</div>
							<div class="box-footer action_wrapper">
								<button class="btn btn-info pull-right menu_save"><?php echo(t_get_val('Update')); ?></button>
							</div>
						</div>
					</div>
				</div>

			  <!-- /.box -->
			</div>
		</div>
	</section>
</div>
<script>
 $( function() {
	$( "#sortable1" ).sortable({
		connectWith: ".connectedSortable",
		placeholder: "ui-state-highlight",
		remove: function(event, ui) {
			//ui.item.next().css("border","3px solid red");
			console.log(ui.item.data('item_id'));
			if(ui.item.data('item_id')){	
				ui.item.clone().appendTo('#sortable1');
			}else{
				$(this).sortable('cancel');
			}
			//$(this).sortable('cancel');
		}
	}).disableSelection();
	$( "#sortable11" ).sortable({
		connectWith: ".connectedSortable",
		placeholder: "ui-state-highlight",
		remove: function(event, ui) {
			//ui.item.next().css("border","3px solid red");
			console.log(ui.item.data('item_id'));
			if(ui.item.data('item_id')){	
				ui.item.clone().appendTo('#sortable11');
			}else{
				$(this).sortable('cancel');
			}
			//$(this).sortable('cancel');
		}
	}).disableSelection();
	$( "#sortable2" ).sortable({
		connectWith: ".connectedSortable",
		placeholder: "ui-state-highlight",
		containment: "#sortable2"
	}).disableSelection();
	$( "#sortable3" ).sortable({
		connectWith: ".connectedSortable",
		placeholder: "ui-state-highlight",
		containment: "#sortable3"
	}).disableSelection();
 });
</script>