<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$result = array();
$result['POST'] = $_POST;

$nid = $_POST['nid']; //id плана
$wto = $_POST['wto']; //id плана

/*
$result['user_plan_topup'] = user_plan_topup($uid,$nid,$amount);
*/
$result['nid'] = $nid;
$result['wto'] = $wto;
$result['plan_approve_pending'] = plan_approve_pending($nid, $wto);
$result_action = $result['plan_approve_pending'];
if($result_action > 0){
//Если успешно
$result['action_class'] = 'btn-success';
$result['action_result'] = '<i class="icon fa fa-check margin-r-5"></i>'.t_get_val('Success').'';

			$result['action_descr'] = '
			<div class="alert alert-success alert-dismissible mt10 col-sm-12 pull-left">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="text-align:left;"><i class="icon fa fa-check"></i>'.t_get_val('Success').'!</h4>
				
              </div>';

}else{		  
//Если не успешно
$result['action_class'] = 'btn-danger';
$result['action_result'] = '<i class="icon fa fa-ban margin-r-5"></i> '.t_get_val('Error').'!';
$result['action_descr'] = '
			<div class="alert alert-danger alert-dismissible mt10 col-sm-12 pull-left" style="text-align:left;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="text-align:left;"><i class="icon fa fa-ban"></i> '.t_get_val('Error').'!</h4>
				'.$errortext[$result_action].'
              </div>';
}
echo(json_encode($result));
die();
?>