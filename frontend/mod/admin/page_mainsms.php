<?php 
if(!isset($_SESSION['admin_login'])){
	header('Location: /?action=admin_login');
}
include($basedir . '/frontend/sidebar_admin.php');

/* Получим данные по api mainsms */
$MainSMS_balance = $MainSMS_api->getBalance ()


?>
 <div class="content-wrapper h100vh">
		<!-- Content Header (Page header) -->
		<section class="content-header">
		  <h1>
			<?php echo(t_get_val('SMS panel')); ?>
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i><?php echo(t_get_val('Home')); ?></a></li>
			<li class="active"><?php echo(t_get_val('SMS panel')); ?></li>
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
					<p class="text-muted text-center"><b><?php echo(t_get_val('sms Balance')); ?></b></p>
					<p class="text-center"> 
					<?php echo($MainSMS_balance); ?> ₽<br>	
					</p>
					<p>
					
					</p>
                </li>
              </ul>
			  <div>
				<?php 
					//Тест отправки смс
					/*
					echo($phone_to_test);
					echo ('отправка СМС/а смс: ');
					echo($MainSMS_api->sendSMS ( $phone_to_test , 'api test' , 'serg_text'));
					$response = $MainSMS_api->getResponse ();
					$result = $MainSMS_api->checkStatus ();
					*/
				?>
			  </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
		</div>
	</section>
</div>