<?php 
$phone_to_test = '89535332833';


define ('STATUS_BLOCKCHAIN_PENDING', 10);

#Текста для типов транзакций
$trans_types_name = [TX_TYPE_DEPOSIT_TOPUP=>'Пополнение депозита',TX_TYPE_DEPOSIT_WITHDRAW=>'Вывод с депозита',TX_TYPE_PLAN_TOPUP=>'Внесение на план',TX_TYPE_PLAN_WITHDRAW=>'Вывод с плана',TX_TYPE_PLAN_REVERT=>'Возврат с плана',TX_TYPE_PLAN_REINVEST=>'Реинвестирование', TX_TYPE_PLAN_INCOME=>'Вывод в депозит'];



#Текста для типов транзакций в плане и стили для плашки
$plan_tx_status_name = [STATUS_PENDING=>['Pendins','label-info'],STATUS_BLOCKCHAIN_PENDING=>['Blockchain Pendins','label-info'],STATUS_APPROVED=>['Approved','label-success'],STATUS_REJECTED=>['Rejected','label-danger']];


?>