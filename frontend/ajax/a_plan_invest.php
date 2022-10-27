<?php 
$result = array();
$result['POST'] = $_POST;

$nid = $_POST['nid']; //id плана
$uid = $_POST['uid']; //id юзверя
$amount = $_POST['amount']; //Сумма на пополнение

$result['user_plan_topup'] = user_plan_topup($uid,$nid,$amount);
$result_action = $result['user_plan_topup'];
if($result_action > 0){
//Если успешно
$result['action_class'] = 'btn-success';
$result['action_result'] = '<i class="icon fa fa-check margin-r-5"></i>Success';

			$result['action_descr'] = '
			<div class="alert alert-success alert-dismissible mt10 col-sm-12 pull-left">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4 style="text-align:left;"><i class="icon fa fa-check"></i>'.t_get_val('Success').'!</h4>
				
              </div>';

}else{		  
//Если не успешно
$result['action_class'] = 'btn-danger';
$result['action_result'] = '<i class="icon fa fa-ban margin-r-5"></i> Error!';
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