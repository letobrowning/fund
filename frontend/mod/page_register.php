<pre2>
<?php 
if(isset($_SESSION['email'])){
	header('Location: http://95.179.236.117/?action=login');
}
$errorF = false;
if($_POST){
	//print_r($_POST);
	//Проверяем капчу
	if(validateCapcha($_POST['only_test'])){
			// обрабатываем данные формы, которая защищена капчей
			
			$user = $_POST;
			unset($user['only_test']);
			$result = user_register($user);
			if(!is_array($result)){
				print_r($result);
				$error = '';
				switch ($result) {
					case -2:
						$error = t_get_val('User exist'); //'Пользователь с таким E-mail уже существует';
						break;
					case -1:
						$error = t_get_val('Wrong data');//'Неверные данные';
						break;
				}
				$errorF = true;
			}else{
				header('Location: http://95.179.236.117/?action=login');
			}
	}else{
		$errorF = true;
		$error = t_get_val('Wrong rekapcha');//'Неверные данные';
	}
	//echo json_encode($success);

	///echo('!');
	//print_r($result);
	//echo('!');
}

//$all_lang = get_all_lang_name();

?>
</pre2>
<div class="register_form_wrapper">
	<div class="col-sm-6">
		<div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title"><?php echo(t_get_val('Register Form')); ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<form class="form-horizontal" method="POST">
				<input type="hidden" name="only_test" id="only_test">
			  <div class="box-body">
				<div class="form-group">
				  <label for="inputEmail3" class="col-sm-2 control-label"><?php echo(t_get_val('Email')); ?></label>
				  <div class="col-sm-10">
					<?php echo(lang_input('email', 'email', 'form-control','inputEmail3',true,'Email')); ?>
				  </div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label npl"><?php echo(t_get_val('Name')); ?></label>
					<div class="col-sm-10 mb15">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<?php echo(lang_input('text', 'name', 'form-control',false,true,'Name',false,false,$current_user['name'])); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label npl"><?php echo(t_get_val('City')); ?></label>
					<div class="col-sm-10 mb15">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-map-pin"></i></span>
							<?php echo(lang_input('text', 'city', 'form-control',false,false,'City',false,false)); ?>
						</div>
					</div>
				</div>
				<div class="form-group ">
					<label for="inputEmail3" class="col-sm-2 control-label npl"><?php echo(t_get_val('Phone')); ?></label>
					<div class="col-sm-10 mb15">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-phone"></i></span>
							<?php echo(lang_input('text', 'phone', 'form-control',false,true,'Phone',false,false)); ?>
						</div>
					</div>
				</div>
				<div class="form-group ">
					<label for="inputEmail3" class="col-sm-2 control-label npl"><?php echo(t_get_val('Telegram')); ?></label>
					<div class="col-sm-10 mb15">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa  fa-location-arrow"></i></span>
							<?php echo(lang_input('text', 'telegram', 'form-control',false,true,'Telegram',false,false)); ?>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label"><?php echo(t_get_val('Password')); ?></label>
					<div class="col-sm-10">
						<?php echo(lang_input('password', 'password', 'form-control','inputPassword3',true,'Password')); ?>
					</div>
				</div>
				<?php 
				  if($errorF){
					  ?>
					  <div class="alert alert-danger alert-dismissible">
						<?php echo($error); ?>
					  </div>
					  <?php
				  }
				  
				  ?>
			  </div>
			  
			  <!-- /.box-body -->
			  <div class="box-footer">
				<a href="/?action=login" class="btn btn-warning"><?php echo(t_get_val('Sign In')); ?></a>
				<button type="submit" class="btn btn-info pull-right"><?php echo(t_get_val('Register')); ?></button>
			  </div>
			  <!-- /.box-footer -->
			</form>
		</div>
	</div>
</div>
<script src="https://www.google.com/recaptcha/api.js?render=6LdouJgUAAAAAH36APyjM80NupYAusJlfBHkEdML"></script>
<script>
grecaptcha.ready(function() {
      grecaptcha.execute('6LdouJgUAAAAAH36APyjM80NupYAusJlfBHkEdML', {action: 'register'}).then(function(token) {
         console.log(token);
		 jQuery('#only_test').val(token);
      });
  });

/*
grecaptcha.ready(function() {
  grecaptcha.execute('6LdouJgUAAAAAH36APyjM80NupYAusJlfBHkEdML', {action: 'homepage'}).then(function(token) {
                var data = new FormData();
                data.append("action", 'register');
                data.append("token", token);
 
                fetch('/verify_captcha.php', {
                    method: 'POST',
                    body: data
                }).then(function(response) {
                    response.json().then(function(data) {
                        if (!data) document.getElementById('comment-form').style.display = 'none';
                    });
                });
            });
  });*/
</script>