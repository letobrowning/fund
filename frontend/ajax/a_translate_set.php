<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//$basedir = '/var/www/html';
//include ($_POST['basedir'].'/frontend/lib/language.php'); 
$result = array();
$result['POST'] = $_POST;
$current_lang = t_file_get($_POST['lang']);
$result['current_lang'] = $current_lang;
$updated_lang = t_file_update_val($current_lang,array($_POST['lid'],$_POST['new_value']));
$result['updated_lang'] = $updated_lang;
$result_action = t_file_update($_POST['lang'],$updated_lang);
if($result_action === true){
//Если успешно
$result['action_class'] = 'btn-success';
$result['action_result'] = '<i class="icon fa fa-check margin-r-5"></i>'.t_get_val('Success').'';

			$result['action_descr'] = '
			<div class="alert alert-success alert-dismissible mt10 col-sm-12" style="text-align:left;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="text-align:left;"><i class="icon fa fa-check"></i><b>'.$_POST['lang'].'</b> '.t_get_val('Success').'!</h4>
				
              </div>';
//$result['form_text'] = t_get_val('Success');
$result['form_class'] = 'has-success';
}else{		  
//Если не успешно
$result['action_class'] = 'btn-danger';
$result['action_result'] = '<i class="icon fa fa-ban margin-r-5"></i> '.t_get_val('Error').'!';
$result['action_descr'] = '
			<div class="alert alert-danger alert-dismissible mt10 col-sm-12" style="text-align:left;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="text-align:left;"><i class="icon fa fa-ban"></i><b>'.$_POST['lang'].'</b> '.t_get_val('Error').'!</h4>
				'.$result_action.'
              </div>';
$result['form_class'] = 'has-error';
//$result['form_text'] = t_get_val('Error');
}
echo(json_encode($result));
die();
?>