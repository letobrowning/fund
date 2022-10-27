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
          <p><?php echo($_SESSION['email']); ?></p>
		  <p><b><?php echo(t_get_val('user Balance')); ?>:</b><span class="fw300 pl10"><?php echo(sprintf('%.8f',user_get_balance($_SESSION['uid']))); ?> btc</span></p>
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
								<a href="/?<?php echo(updateGET($query,['lang'=>$sidebar_lang])); ?>" class="w100 text-uppercase "><b><?php echo($sidebar_lang); ?></b></a>
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
		<li><a href="http://95.179.236.117/?action=cabinet"><?php echo(t_get_val('Cabinet')); ?></a></li>
		<li><a href="http://95.179.236.117/?action=plans"><?php echo(t_get_val('Plans')); ?></a></li>
		 <li><a href="/?logout=1" class="btn btn-primary logout_btn w100 text-uppercase"><?php echo(t_get_val('Exit')); ?></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>