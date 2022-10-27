<pre2>
<?php 
$errorF = false;
if($_POST){
	//print_r($_POST);
	
	if(admin_find_by_credentials($_POST['aid'],$_POST['apassword'])){
		//$errorF = true;
		//$error = 'Подошло';
		//page_admin.php
		$_SESSION['admin_login'] = 1;
		//Название - md5 от логин-пароль, значение - md5 от пароль-логин
		setcookie("admin_login", 1, time()+3600*24);  /* срок действия 24 часа */
		header('Location: /?action=admin');
	}else{
		$errorF = true;
		$error = 'Неверные логин-пароль';
	}
	
	//$result = users_list(['email' => $_POST['email']]);
	//print_r($result);
	
	//print_r($_POST);
	//$user = $_POST;
	//$result = user_register($user);
	
	
	
	/*
	if(!is_array($result)){
		//print_r($result);
		$error = '';
		switch ($result) {
			case -2:
				$error = 'Пользователь с таким E-mail уже существует';
				break;
			case -1:
				$error = 'Неверные данные';
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
			header('Location: http://95.179.236.117/?action=cabinet');
		}else{
			$errorF = true;
			$error = 'Логин или пароль неверные';
		}
	}
	if(!$errorF){
		
	}*/
}
//print_r($_SESSION);
?>
</pre2>
<div class="register_form_wrapper">
	<div class="col-sm-6">
		<div class="box box-info">
			<div class="box-header with-border">
			  <h3 class="box-title">Admin Login Form</h3>
			</div>
			<!-- /.box-header -->
			<!-- form start -->
			<form class="form-horizontal" method="POST">
			  <div class="box-body">
				<div class="form-group">
				  <label for="inputEmail3" class="col-sm-2 control-label">Admin id</label>
				  <div class="col-sm-10">
					<input type="password" name="aid" class="form-control" id="inputEmail3" placeholder="Admin id" required>
				  </div>
				</div>
				<div class="form-group">
				  <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

				  <div class="col-sm-10">
					<input type="password" name="apassword" class="form-control" id="inputPassword3" placeholder="Password" required>
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
				<button type="submit" class="btn btn-info pull-right">Sign In</button>
			  </div>
			  <!-- /.box-footer -->
			</form>
		</div>
	</div>
</div>