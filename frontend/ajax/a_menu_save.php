<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//$basedir = '/var/www/html';
//include ($_POST['basedir'].'/frontend/lib/language.php'); 
$result = array();
$result['POST'] = $_POST;
$filter = ['menu_id'=>$_POST['menu_type']];
$all_menu = menu_list();
foreach($all_menu as $menu){
	if($menu['menu_id'] == $_POST['menu_type']){
		 $current_menu = $menu['_id'];
	}
}
//echo(json_encode($all_menu));
//die();
$menu_id = new MongoDB\BSON\ObjectId ($current_menu);
$current_menu = menu_list(['_id'=>$menu_id]);
$result['current_menu'] = $current_menu;
/*
$current_menu = menu_list($filter);
$result['current_menu'] = $current_menu;
$result['filter'] = $filter;
*/
$data = array();
$data['items'] = $_POST['items'];
$result_action = menu_modify(['_id'=>$menu_id],$data);
if($result_action > 0){
//Если успешно
$result['action_class'] = 'btn-success';
$result['action_result'] = '<i class="icon fa fa-check margin-r-5"></i>'.t_get_val('Success').'';

			$result['action_descr'] = '
			<div class="alert alert-success alert-dismissible mt10 col-sm-12" style="text-align:left;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="text-align:left;"><i class="icon fa fa-check"></i>'.t_get_val('Success').'!</h4>
				
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
                <h4 style="text-align:left;"><i class="icon fa fa-ban"></i>'.t_get_val('Error').'!</h4>
				'.$result_action.'
              </div>';
$result['form_class'] = 'has-error';
//$result['form_text'] = t_get_val('Error');
}
echo(json_encode($result));
die();
?>