<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: /?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');
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
        <div class="row">
			        <div class="col-lg-4 col-md-5 col-sm-5">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('BTC Wallet')); ?></b></p>
					<p class="text-center"><?php echo(admin_get_wallet()); ?></p>
                </li> 
				<li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('Balance')); ?></b></p>
					<p class="text-center"> 
					<?php echo(sprintf('%.8f',$admin_balabce)); ?> btc </p>
                </li>  
				<li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('BTC Profit Wallet')); ?></b></p>
					<p class="text-center"><?php echo(admin_get_profit_wallet()); ?></p>
                </li> 
				<li class="list-group-item">
					<p class="text-muted text-center"><b><?php echo(t_get_val('Profit Balance')); ?></b></p>
					<p class="text-center"> 
					<?php echo(sprintf('%.8f',admin_get_profit_wallet_balance())); ?> btc </p>
                </li>
              </ul>
			  <?php 
			  if(isset($_SESSION['translate_mod'])){
				$query = $_GET;
				$edit_url = ['translate_mod'=>-1];
				  
				?>
				<div class="col-sm-12 pt15">
					<a href="/?<?php echo(updateGET($query,$edit_url)); ?>" class="btn btn-danger pull-right"><?php echo(t_get_val('End traslate')); ?></a>
				</div>
				  
				  <?php
			  }else{
			  
			  $query = $_GET;
			  $edit_url = ['translate_mod'=>'translate_mod'];
			  
			  ?>
			  <div class="col-sm-12 pt15">
				<a href="/?<?php echo(updateGET($query,$edit_url)); ?>" class="btn btn-info pull-right"><?php echo(t_get_val('Start traslate')); ?></a>
			  </div>
			  <?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
		</div>
	</section>
</div>