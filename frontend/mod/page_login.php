<pre2>
<?php 
//$value = '123';


$errorF = false;
/*
$list = array (
    array('Password', 'Пароль'), 
	array('Name', 'Имя'),
);
t_file_update('ru',$list);
*/
//print_r($_SESSION);
//t_file_update('ru',t_file_update_val($lang,array('Name','Имя2')));



//print_r($lang);
//echo(t_get_val('Name'));
/*
echo('<br>Обновим</br>');
print_r(t_file_update_val($lang,array('Wallet','Кошелек')));
t_file_update('ru',t_file_update_val($lang,array('Wallet','Кошелек')));

$lang['Password'][1] = 'Пароль';
t_file_update('ru',$lang);

$lang = t_file_get('ru');
print_r($lang);
*/

if(isset($_SESSION['uid']) AND isset($_SESSION['email']) AND isset($_SESSION['wallet']) ){
	header('Location: /?action=cabinet');
}
if($_POST){
	//print_r($_POST);
	$result = users_list(['email' => $_POST['email']]);
	//$result = users_list(['error' => 1]);
	//print_r($result);
	
	//print_r($_POST);
	//$user = $_POST;
	//$result = user_register($user);
	if(validateCapcha($_POST['only_test'])){
		if(!is_array($result)){
			print_r($result);
			$error = '';
			switch ($result) {
				case -2:
					$error = t_get_val('User exist');
					break;
				case -1:
					$error = t_get_val('Wrong data');
					break;
			}
			$errorF = true;
		}else{
			$pwd_check = user_find_by_credentials($_POST['email'],$_POST['password']);
			//print_r($pwd_check);
			//echo('!');
			//$pwd_check = admin_find_by_credentials($result[0]['_id'],$_POST['password']);
			//echo('!');
			//print_r($pwd_check);
			if(is_object($pwd_check)){
				$_SESSION['uid'] = $result[0]['_id'];
				$_SESSION['email'] = $result[0]['email'];
				$_SESSION['wallet'] = $result[0]['wallet'];
				setcookie("uid", $result[0]['_id'], time()+3600*24);  /* срок действия 24 часа */
				setcookie("email", $result[0]['email'], time()+3600*24);  /* срок действия 24 часа*/
				setcookie("wallet", $result[0]['wallet'], time()+3600*24);  /* срок действия 24 часа*/
				header('Location: /?action=cabinet');
			}else{
				$errorF = true;
				$error = t_get_val('Email or password error');;
			}
		}
	}else{
		$errorF = true;
		$error = t_get_val('Wrong rekapcha');//'Неверные данные';
	}
}
//print_r($_SESSION);

?>
</pre2>
<div class="register_form_wrapper">
	<div class="col-sm-6">
		<div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title"><?php echo(t_get_val('Login Form')); ?></h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<form class="form-horizontal" method="POST">
				<input type="hidden" name="only_test" id="only_test">
				<div class="box-body">
					<div class="form-group">
					  <label for="inputEmail3" class="col-sm-2 control-label"><?php echo(t_get_val('Email')); ?></label>
					  <div class="col-sm-10">
						<!-- <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" required> -->
						<?php echo(lang_input('email', 'email', 'form-control','inputEmail3',true,'Email')); ?>
					  </div>
					</div>
					<div class="form-group">
					  <label for="inputPassword3" class="col-sm-2 control-label"><?php echo(t_get_val('Password')); ?></label>

					  <div class="col-sm-10">
						<!-- <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required> -->
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
				<a href="/?action=register" class="btn btn-warning"><?php echo(t_get_val('Register')); ?></a>
				<button type="submit" class="btn btn-info pull-right"><?php echo(t_get_val('Sign In')); ?></button>
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
</script>