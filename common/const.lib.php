<?php

### Общеиспользуемые константы ###
define ('TX_TYPE_DEPOSIT_TOPUP', 2);
define ('TX_TYPE_DEPOSIT_WITHDRAW', 4);
define ('TX_TYPE_PLAN_TOPUP', 8);
define ('TX_TYPE_PLAN_WITHDRAW', 16);
define ('TX_TYPE_PLAN_REINVEST', 32);			# перевод начисленного дохода в тело депозита как реинвестирование
define ('TX_TYPE_PLAN_INCOME', 64);				# перевод начисленного дохода в тело депозита для вывода (сразу же)
define ('TX_TYPE_ADMIN_PLAN_OUT', 128);			# зачисление на внешний сервис (также сделать статистику)
define ('TX_TYPE_ADMIN_WALLET_TOPUP', 256);		# пополнение системного кошелька админа
define ('TX_TYPE_ADMIN_WALLET_WITHDRAW', 512);	# вывод из системного кошелька админа

define ('ERROR_INCORRECT_PARAMETERS', -1);
define ('ERROR_ALREADY_EXISTS', -2);
define ('ERROR_DOES_NOT_EXIST', -3);
define ('ERROR_AMOUNT_IS_TOO_SMALL', -4);
define ('ERROR_UNSUFFICIENT_FUNDS', -5);
define ('ERROR_SYSTEM', -6);
define ('ERROR_SECURITY_ERROR', -11);

define ('PLAN_TYPE_ON_TIME', 2);				# кривое значение слова "срочный"
define ('PLAN_TYPE_ON_DEMAND', 4);				# не менее кривое значение слова "бессрочный"

define ('STATUS_PENDING', 1);
define ('STATUS_APPROVED', 2);
define ('STATUS_REJECTED', 3);

define ('TO_SATOSHI', 100000000);