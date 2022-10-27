<?php 

#Текста для типов транзакций
$trans_types_name = [TX_TYPE_DEPOSIT_TOPUP=>t_get_val('Пополнение депозита'),TX_TYPE_DEPOSIT_WITHDRAW=>t_get_val('TX_TYPE_DEPOSIT_WITHDRAW'),TX_TYPE_PLAN_TOPUP=>t_get_val('TX_TYPE_PLAN_TOPUP'),TX_TYPE_PLAN_WITHDRAW=>t_get_val('TX_TYPE_PLAN_WITHDRAW'),/*TX_TYPE_PLAN_REVERT=>t_get_val('TX_TYPE_PLAN_REVERT'),*/TX_TYPE_PLAN_REINVEST=>t_get_val('TX_TYPE_PLAN_REINVEST'),TX_TYPE_PLAN_INCOME=>t_get_val('TX_TYPE_PLAN_INCOME')];

#Текста для типов транзакций
$errortext = [ERROR_UNSUFFICIENT_FUNDS=>t_get_val('Unsufficient funds'),ERROR_INCORRECT_PARAMETERS=>t_get_val('ERROR_INCORRECT_PARAMETERS'),ERROR_ALREADY_EXISTS=>t_get_val('ERROR_ALREADY_EXISTS'),ERROR_DOES_NOT_EXIST=>t_get_val('ERROR_DOES_NOT_EXIST'),ERROR_AMOUNT_IS_TOO_SMALL=>t_get_val('ERROR_AMOUNT_IS_TOO_SMALL'),ERROR_SYSTEM=>t_get_val('ERROR_SYSTEM'),ERROR_SECURITY_ERROR=>t_get_val('ERROR_SECURITY_ERROR')];

#Константы типов планов по срокам
$plan_types_name = [2=>'Срочный',4=>'Бессрочный'];

#Константы типов планов
define ('PLAN_TYPE_TRADING', 101);
define ('PLAN_TYPE_MINING', 201);
define ('PLAN_TYPE_INDEX', 301);
#Текста для типов планов v2
$plan_v2_texts = [PLAN_TYPE_TRADING=>t_get_val('PLAN_TYPE_TRADING'),PLAN_TYPE_MINING=>t_get_val('PLAN_TYPE_MINING'),PLAN_TYPE_INDEX=>t_get_val('PLAN_TYPE_INDEX')];

#Текста для типов транзакций в плане и стили для плашки
$plan_tx_status_name = [STATUS_PENDING=>[t_get_val('STATUS_PENDING'),'label-info'],STATUS_APPROVED=>[t_get_val('STATUS_APPROVED'),'label-success'],STATUS_REJECTED=>[t_get_val('STATUS_REJECTED'),'label-danger']];


?>