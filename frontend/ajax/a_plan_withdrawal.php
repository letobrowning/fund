<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$result = array();
$result['POST'] = $_POST;
$result['_SESSION'] = $_SESSION;


$plan_id = $_POST['nid']; //id плана
$user_id = $_POST['uid']; //id юзверя
$plan_type = $_POST['pt']; //Тип плана
$topup_tx_id = $_POST['tid']; //id транзакции
$body_amount = $_POST['amount']; //сумма на вывод
//$result_action = user_plan_income_to_body($user_id, $plan_type, $plan_id, $topup_tx_id);
$result_action = user_plan_withdrawal_inquiry ($user_id, $plan_type, $plan_id, $topup_tx_id, $body_amount);
//$result_action = -1;
$result['result_action'] = $result_action;
//$result_action = 1;
if($result_action > 0){
//Если успешно
$result['action_class'] = 'btn-success';
$result['action_result'] = '<i class="icon fa fa-check margin-r-5"></i>'.t_get_val('Success').'';

			$result['action_descr'] = '
			<div class="alert alert-success alert-dismissible mt10 col-sm-12 pull-left">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="text-align:left;"><i class="icon fa fa-check"></i> '.t_get_val('Success').'!</h4>
				
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