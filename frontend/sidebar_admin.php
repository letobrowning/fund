 <?php 
$query = $_GET;
if(!isset($_SESSION['lang'])){
	$_SESSION['lang'] = 'en';
}
?> 

 <aside class="main-sidebar npt">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel visible">
		<div class="info">
			<?php 
			$admin_balabce = admin_get_wallet_balance();
			
			?>

		  	<div class="row">
				<div class="col-xs-12 sidebar_lang_change">
					<a href="#" class="dropdown-toggle text-uppercase btn btn-primary w100" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo($_SESSION['lang']); ?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<!--  <li><a href="#">Ru</a></li>
						<li><a href="#">En</a></li>-->
						<?Php 
						$all_lang = get_all_lang_name();
						foreach($all_lang as $sidebar_lang){
							if($_SESSION['lang'] != $sidebar_lang){
								?>
								<li>
									<a href="/?<?php echo(updateGET($query,['lang'=>$sidebar_lang])); ?>" class="w100 text-uppercase"><b><?php echo($sidebar_lang); ?></b></a>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
			</div>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"><?php echo(t_get_val('MAIN NAVIGATION')); ?></li>
		<li><a href="/?action=admin"><?php echo(t_get_val('Admin cabinet')); ?></a></li>
		<li><a href="/?action=admin&subaction=plans"><?php echo(t_get_val('Plans')); ?></a></li>
		<li><a href="/?action=admin&subaction=plans_invest"><?php echo(t_get_val('Plans invest')); ?></a></li>
		<li><a href="/?action=admin&subaction=systemfee"><?php echo(t_get_val('System fee')); ?></a></li>
		<li><a href="/?action=admin&subaction=clients"><?php echo(t_get_val('Clients')); ?></a></li>
		<li><a href="/?action=admin&subaction=users_tx"><?php echo(t_get_val('Clients tranz')); ?></a></li>
		<li><a href="/?action=admin&subaction=admin_stat"><?php echo(t_get_val('Admin stat')); ?></a></li>
		<li><a href="/?action=admin&subaction=translate"><?php echo(t_get_val('Translate')); ?></a></li>
		<li><a href="/?action=admin&subaction=mainsms"><?php echo(t_get_val('SMS')); ?></a></li>
		 <li class="header"><?php echo(t_get_val('Front')); ?></li>
		<li><a href="/?action=admin&subaction=menus"><?php echo(t_get_val('menus')); ?></a></li>
		<li><a href="/?action=admin&subaction=pages"><?php echo(t_get_val('pages')); ?></a></li>
		<li><a href="/?action=admin&subaction=category"><?php echo(t_get_val('categorys')); ?></a></li>
		<li><a href="/?action=admin&subaction=article"><?php echo(t_get_val('articles')); ?></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>