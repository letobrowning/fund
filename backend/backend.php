<?php

### Функции для фронтенда ###
$basedir = '/var/www/html'; 
include ($basedir . '/backend/init.php'); 

#Функции владимира для работы с контентом

#Работа со страницами
function page_create($data) {
	global $client;
	if(!is_array($data)) return ERROR_INCORRECT_PARAMETERS;
	$result = $client->content->pages->insertOne($data);
	return [
		'_id' => (string) $result->getInsertedId ()
	];
}

function page_modify ($filter, $update = []) {
	global $client;
	if (!$filter || !is_array ($filter)) return ERROR_INCORRECT_PARAMETERS;
	$update['updated_ts'] = time ();
	$client->content->pages->updateMany ($filter, ['$set' => $update]);
	return true;
}
function page_list ($filter = [], $sort = []) {
	global $client;
	$pages = [];
	$iterator = $client->content->pages->find ($filter, $sort);
	foreach ($iterator as $it) {
		$u = [];
		foreach ($it as $n => $v) {
			if ($n == '_id') $v = (string) $v;
			$u[$n] = $v;
		}
		$pages[] = $u;
	}
	return $pages;
}

#Работа с меню
function menu_create($data) {
	global $client;
	if(!is_array($data)) return ERROR_INCORRECT_PARAMETERS;
	$result = $client->content->menu->insertOne($data);
	return [
		'_id' => (string) $result->getInsertedId ()
	];
}

function menu_modify ($filter, $update = []) {
	global $client;
	if (!$filter || !is_array ($filter)) return ERROR_INCORRECT_PARAMETERS;
	$update['updated_ts'] = time ();
	$client->content->menu->updateMany ($filter, ['$set' => $update]);
	return true;
}
function menu_list ($filter = [], $sort = []) {
	global $client;
	$menus = [];
	$iterator = $client->content->menu->find ($filter, $sort);
	foreach ($iterator as $it) {
		$u = [];
		foreach ($it as $n => $v) {
			if ($n == '_id') $v = (string) $v;
			$u[$n] = $v;
		}
		$menus[] = $u;
	}
	return $menus;
}


#Работа с категориями
function category_create($data) {
	global $client;
	if(!is_array($data)) return ERROR_INCORRECT_PARAMETERS;
	$result = $client->content->categorys->insertOne($data);
	return [
		'_id' => (string) $result->getInsertedId ()
	];
}

function category_modify ($filter, $update = []) {
	global $client;
	if (!$filter || !is_array ($filter)) return ERROR_INCORRECT_PARAMETERS;
	$update['updated_ts'] = time ();
	$client->content->categorys->updateMany ($filter, ['$set' => $update]);
	return true;
}
function category_list ($filter = [], $sort = []) {
	global $client;
	$menus = [];
	$iterator = $client->content->categorys->find ($filter, $sort);
	foreach ($iterator as $it) {
		$u = [];
		foreach ($it as $n => $v) {
			if ($n == '_id') $v = (string) $v;
			$u[$n] = $v;
		}
		$menus[] = $u;
	}
	return $menus;
}

#Работа с записями
function article_create($data) {
	global $client;
	if(!is_array($data)) return ERROR_INCORRECT_PARAMETERS;
	$result = $client->content->articles->insertOne($data);
	return [
		'_id' => (string) $result->getInsertedId ()
	];
}

function article_modify ($filter, $update = []) {
	global $client;
	if (!$filter || !is_array ($filter)) return ERROR_INCORRECT_PARAMETERS;
	$update['updated_ts'] = time ();
	$client->content->articles->updateMany ($filter, ['$set' => $update]);
	return true;
}
function article_list ($filter = [], $sort = []) {
	global $client;
	$menus = [];
	$iterator = $client->content->articles->find ($filter, $sort);
	foreach ($iterator as $it) {
		$u = [];
		foreach ($it as $n => $v) {
			if ($n == '_id') $v = (string) $v;
			$u[$n] = $v;
		}
		$menus[] = $u;
	}
	return $menus;
}

# Работа с пользователями
# email, password (без дублирования) и еще любая другая не-сенситив информация
function user_register ($user) {
	global $client;
	if (!isset ($user['email']) || !isset ($user['password'])) return ERROR_INCORRECT_PARAMETERS;
	$user['email'] = trim ($user['email']);
	$user['email'] = strtolower ($user['email']);
	if ($client->main->users->count (['email' => $user['email']])) return ERROR_ALREADY_EXISTS;
	$user['password'] = security_encrypt ($user['password']);
	# + создание кошелька для пользователя
	$user['wallet'] = btc_getnewaddress ();
	if ($user['wallet'] === null) critical_error (['function' => __FUNCTION__, 'cause' => 'btc_getnewaddress']);
	$user['created_ts'] = time (); 
	# добавляем индексы по мере необходимости
	$client->main->users->createIndex (['wallet' => 1], ['unique' => true]); 		
	$client->main->users->createIndex (['email' => 1], ['unique' => true]); 		
	$client->main->users->createIndex (['password' => 1], ['unique' => false]); 	
	$result = $client->main->users->insertOne ($user);
	return [
		'_id' => (string) $result->getInsertedId (),
		'wallet' => $user['wallet']
	];
}
//$bd = 'content';
//$result = $client->$bd->$table->insertOne ($data);
//$client->$bd->$table->updateMany ($filter, ['$set' => $data]);
function users_list ($filter = [], $sort = []) {
	global $client;
	$users = [];
	$iterator = $client->main->users->find ($filter, $sort);
	foreach ($iterator as $it) {
		$u = [];
		foreach ($it as $n => $v) {
			if ($n == '_id') $v = (string) $v;
			if ($n == 'password') continue;
			$u[$n] = $v;
		}
		$users[] = $u;
	}
	return $users;
}

function user_find_by_credentials ($email, $password) {
	global $client;
	return $client->main->users->findOne (['email' => $email, 'password' => security_encrypt ($password)]);
}

function admin_find_by_credentials ($user, $pass) {
	global $config;
	return $config['admin']['user'] === $user && $config['admin']['pass'] === $pass;
}

function users_modify ($filter, $update = []) {
	global $client;
	if (!$filter || !is_array ($filter)) return ERROR_INCORRECT_PARAMETERS;
	$update['updated_ts'] = time ();
	$client->main->users->updateMany ($filter, ['$set' => $update]);
	return true;
}

# Получение внутреннего баланса
function user_get_balance ($user_id) {
	global $client;
	if (!$user_id || !is_string ($user_id)) return ERROR_INCORRECT_PARAMETERS;
	$user = $client->main->users->findOne (['_id' => new MongoDB\BSON\ObjectId ($user_id)]);
	if (!$user) return ERROR_DOES_NOT_EXIST;
	$topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['to_address' => $user->wallet],
				['tx_type' => TX_TYPE_DEPOSIT_TOPUP],
				['confirmations' => ['$gte' => 6]]	# для пополнений необходимо подождать подтверждение перед пополнением баланса
			]
		]], ['$group' => [
			'_id' => 'to_address',
			'total_amount' => ['$sum' => '$amount'],
			'total_fee_amount' => ['$sum' => '$tx_fee_user_in.fee_amount'],
		]]]));
	$withdrawals = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['from_address' => $user->wallet],
				['tx_type' => TX_TYPE_DEPOSIT_WITHDRAW]
			]
		]], ['$group' => [
			'_id' => 'from_address',
			'total_amount' => ['$sum' => '$amount'],
			'total_tx_fee_real' => ['$sum' => '$tx_fee_real'],
			'total_fee_amount' => ['$sum' => '$tx_fee_user_out.fee_amount'],
		]]]));
	$plan_topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['from_address' => $user->wallet],
				['tx_type' => TX_TYPE_PLAN_TOPUP]
			]
		]], ['$group' => [
			'_id' => 'from_address',
			'total_amount' => ['$sum' => '$amount'],
			'total_fee_amount' => ['$sum' => '$tx_fee_user_out.fee_amount'],
		]]]));
	$plan_withdrawals = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['to_address' => $user->wallet],
				['tx_type' => TX_TYPE_PLAN_WITHDRAW],
				['confirmations' => ['$gte' => 6]]	# аналогично
			]
		]], ['$group' => [
			'_id' => 'to_address',
			'total_amount' => ['$sum' => '$amount'],
			'total_fee_amount' => ['$sum' => '$tx_fee_user_in.fee_amount'],
		]]]));
	$balance = 0;  
	if (count ($topups)) 			$balance += $topups[0]->total_amount - $topups[0]->total_fee_amount;
	if (count ($withdrawals)) 		$balance -= $withdrawals[0]->total_amount + $withdrawals[0]->total_fee_amount + $withdrawals[0]->total_tx_fee_real;
	if (count ($plan_topups))		$balance -= $plan_topups[0]->total_amount + $plan_topups[0]->total_fee_amount;
	if (count ($plan_withdrawals)) 	$balance += $plan_withdrawals[0]->total_amount - $plan_withdrawals[0]->total_fee_amount;
	return $balance;
}

# Получение планов пользователей и отчета по доходности на них
# + для срочных планов - время, когда он закончится
# + редактирование данных по необходимости
function user_get_plans ($user_id) {
	global $client;
	if (!$user_id || !is_string ($user_id)) return ERROR_INCORRECT_PARAMETERS;
	$user = $client->main->users->findOne (['_id' => new MongoDB\BSON\ObjectId ($user_id)]);
	if (!$user) return ERROR_DOES_NOT_EXIST;

	# 1. Хистори по планам (за основу по каждому плану берутся его транзакции пополнения, от них считается все остальное, потом суммируется в эквити)
	$plans_history = iterator_to_array ($client->main->transactions->find ([
		'$and' => [
			['$or' => [
				['from_address' => $user->wallet],
				['to_address' => $user->wallet]
			]],
			['$or' => [
				['tx_type' => TX_TYPE_PLAN_TOPUP],
				['tx_type' => TX_TYPE_PLAN_REINVEST],
				['tx_type' => TX_TYPE_PLAN_INCOME],
				['tx_type' => TX_TYPE_PLAN_WITHDRAW]
			]]
		]
	], ['sort' => ['time_ts' => 1], 'allowDiskUse' => true]));

	$plans = [];
	foreach ($plans_history as $tx) {
		$plan_id = (string) $tx->plan_id;
		
		# 1.1 Пополнения
		if ($tx->tx_type == TX_TYPE_PLAN_TOPUP) {
			if ($tx->plan_tx_status == STATUS_APPROVED) {
				# Начисление в тело плана
				$tx->__initial_amount = $tx->amount;		# сохраняем изначальное количество инвестированного для конкретной транзакции пополнения
				$tx->__income_start_time = $tx->plan_topup_approve_time;	# по умолчанию дата начала начисления дохода - это дата аппрува пополнения
				$tx_id = (string) $tx->_id;
				@$plans[$plan_id][$tx_id] = $tx;
			}
		} else {

			### Реинвестирование и выводы ###
			# На этом этапе необходимо заблокировать последующие функции, чтобы не было путаницы с функционалом дальнейшего начисления процентов
			# Это делается с помощью __income_start_time = null

			$tx_id = (string) $tx->topup_tx_id;				# все это применяется к изначальной транзакции пополнения

			if (!isset ($plans[$plan_id][$tx_id])) critical_error ([
				'function' => __FUNCTION__,
				'cause' => 'error in db'
			]);

			# 1.2 Реинвестирование
			if ($tx->tx_type == TX_TYPE_PLAN_REINVEST) {
				if ($tx->plan_tx_status == STATUS_APPROVED) {
					# Переводим прибыль в тело с учетом комиссий за это
					$plans[$plan_id][$tx_id]->amount += $tx->amount - $tx->tx_fee_user_in->fee_amount;
					# + так как мы уже посчитали (и вывели) доход, то новый доход мы считаем уже с этого времени
					$plans[$plan_id][$tx_id]->__income_start_time = $tx->time_ts;
				} else if ($tx->plan_tx_status == STATUS_PENDING) {
					$plans[$plan_id][$tx_id]->__income_start_time = null ;
				} # если rejected - притворимся, что этой транзакции не было
			}
			# 1.3 Вывод дохода в тело
			if ($tx->tx_type == TX_TYPE_PLAN_INCOME) {
				if ($tx->plan_tx_status == STATUS_APPROVED) {
					# То же самое, но без комиссии, так как следующей пойдет транзакция вывода тела
					$plans[$plan_id][$tx_id]->amount += $tx->amount;
					# + и тут то же самое
					$plans[$plan_id][$tx_id]->__income_start_time = $tx->time_ts;
				} else if ($tx->plan_tx_status == STATUS_PENDING) {
					$plans[$plan_id][$tx_id]->__income_start_time = null ;
				} # если rejected - притворимся, что этой транзакции не было
			}
			# 1.4 Выводы
			if ($tx->tx_type == TX_TYPE_PLAN_WITHDRAW) {
				if ($tx->plan_tx_status != STATUS_REJECTED) { # хотя тогда amount = fee = 0
					# Отнимаем сумму плюс комиссии и пенальти
					$plans[$plan_id][$tx_id]->amount -= $tx->amount + $tx->tx_fee_user_in->fee_amount;	# тут пенальти и все fee в куче
					# технически для пользовательского кошелька это входящая транзакция
				} 
			}
		}
	}

	# 2. Начисляем проценты на body согласно времени пополнения по каждой транзакции
	$result = [];
	foreach ($plans as $plan_id => $plan_txs) {
		$plan__id = new MongoDB\BSON\ObjectId ($plan_id);
		$plan = $client->main->plans->findOne (['_id' => $plan__id]);
		if (!$plan) critical_error ([
			'function' => __FUNCTION__,
			'cause' => 'can not find plan ' . $plan_id
		]);
		foreach ($plan_txs as $tx_id => $tx) {
			if ($tx->__income_start_time !== null) {
				# Определяемся со временем завершения плана во всех случаях
				$need_to_decide = false;
				if ($plan->plan_type == PLAN_TYPE_ON_TIME) {
					$plan_time_end_ts = $tx->__income_start_time + $plan->plan_time_days * 3600 * 24;
					if (time () >= $plan_time_end_ts) {
						$til_time_ts = $plan_time_end_ts;
						# + необходимо принять решение о выводе
						$need_to_decide = true;
					} else $til_time_ts = time ();
				} else $til_time_ts = time ();
				# Далее смотрим изменения доходности в БД
				# 1) Доходность, которая была установлена на момент очередного возобновления действия плана (по сути, игронируем plan_yield поле)
				#    Если план не редактировался, это та дохоность, что была при его создании
				#    Если редактировался, то это последнее значение редактирования непосредственно перед началом действия плана для данного клиента
				$init_yield = $client->main->plan_yield_mod_history->findOne ([
					'plan_id' => $plan__id,  
					'time_ts' => ['$lte' => $tx->__income_start_time] 
				], ['sort' => ['time_ts' => -1]]); 
				if (!$init_yield) critical_error (['function' => __FUNCTION__, 'cause' => "init_yield not found for plan #$plan_id / tx #$tx_id"]);
				$init_yield = (float) $init_yield->plan_yield;
				$yield_changes[] = [
					't' => $tx->__income_start_time,
					'y' => $init_yield	# доходность, установленная на момент возобновления плана __income_start_time
				];
				# 2) Изменения доходности после
				$changes = iterator_to_array ($client->main->plan_yield_mod_history->find (['$and' => [
					['plan_id' => $plan__id],
					['$and' => [
						['time_ts' => ['$gt' => $tx->__income_start_time]],
						['time_ts' => ['$lt' => $til_time_ts]],
					]],
				]], ['sort' => ['time_ts' => 1]]));
				foreach ($changes as $change) {
					$yield_changes[] = [
						't' => $change->time_ts,
						'y' => $change->plan_yield
					];
				}
				# Рассчитываем доходность согласно ее изменениям по времени
				$yield_equity_timeline = [];
				for ($i = 1; $i < count ($yield_changes); $i ++) {
					$yield_equity_timeline[] = [
						'til_time_ts' => $yield_changes[$i]['t'],
						'percents' => ($p = __calc_plan_yield_in_percents ($plan, $yield_changes[$i]['y'], $yield_changes[$i]['t'] - $yield_changes[$i - 1]['t'])),
						'income' => $p * $tx->amount / 100,
						'yield_prev' => $yield_changes[$i - 1]['y'],
						'yield_next' => $yield_changes[$i]['y'],
	 				];
				}
				# + добиваем до текущего момента, либо до момента завершения плана
				$last = count ($yield_changes) - 1;
				
				$yield_equity_timeline[] = [
					'til_time_ts' => $til_time_ts,
					'percents' => ($p = __calc_plan_yield_in_percents ($plan, $yield_changes[$last]['y'], $til_time_ts - $yield_changes[$last]['t'])),
					'income' => $p * $tx->amount / 100,
					'yield_prev' =>  $yield_changes[$last]['y']
				];
				# Суммируем данные по транзакции
				$sum_percents = 0;
				
				foreach ($yield_equity_timeline as $yt) $sum_percents += $yt['percents'];
				
				# Составляем общую структуру
				@$result[$plan->plan_type][$plan_id][$tx_id] = [
					'tx' => $tx,
					'body' => $tx->amount,
					'sum_percents' => $sum_percents,
					'sum_income' => $sum_percents * $tx->amount / 100,
					'yield_equity_timeline' => $yield_equity_timeline,
					'need_to_decide' => $need_to_decide
				];
			} else {
				@$result[$plan->plan_type][$plan_id][$tx_id] = [
					'tx' => $tx,
					'body' => $tx->amount,
					'have_pending_withdrawals' => true # пока не можем посчитать, так как админ обрабатывает выводы
				];
			}
		}
	}

	return $result;
}

# Внутренняя функция расчета доходности для отрезка времени, за который данная доходность в настройках не изменялась
function __calc_plan_yield_in_percents ($plan, $plan_yield, $time_period_in_seconds) {
	$plan_yield = (float) str_replace ('%', '', $plan_yield);
	if ($plan->plan_type == PLAN_TYPE_ON_TIME) {
		# Расчет доходности, исходя из того, что план срочный, то есть полная доходность считается за полный период плана
		$period_in_seconds = $plan->plan_time_days * 24 * 3600;
	} else {
		# Полная доходность считается за месяц
		$period_in_seconds = 30 * 24 * 3600;
	}
	$yield_in_second = $plan_yield / $period_in_seconds;
	return $time_period_in_seconds * $yield_in_second;
}

# Получение кошелька админа для профита
function admin_get_profit_wallet () {
	$wallet = db_option_get ('admin_profit_wallet');
	if ($wallet === null) {
		$wallet = btc_getnewaddress ();
		if (!$wallet) critical_error (['function' => __FUNCTION__, 'cause' => 'btc_getnewaddress']);
		db_option_set ('admin_profit_wallet', $wallet);
	}
	return $wallet;
}

# Для этого кошелька мы считаем пополнения и выводы в депозиты пользователям
function admin_get_profit_wallet_balance () {
	global $client;
	# Это выводы прибыли из соответствующих кошельков клиентов
	$topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_type' => TX_TYPE_ADMIN_WALLET_TOPUP],
			['to_address' => admin_get_profit_wallet ()]
		]
	]], ['$group' => [
		'_id' => 'admin_address',
		'total_amount' => ['$sum' => '$amount']
	]]]));
	# Это выводы прибыли админа
	$withdrawals = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_type' => TX_TYPE_ADMIN_WALLET_WITHDRAW],
			['from_address' => admin_get_profit_wallet ()]
		]
	]], ['$group' => [
		'_id' => 'admin_address',
		'total_amount' => ['$sum' => '$amount'],
		'total_tx_fee_real' => ['$sum' => '$tx_fee_real']
	]]]));
	$balance = 0;
	if (count ($topups)) 		$balance += $topups->total_amount;
	if (count ($withdrawals)) 	$balance -= $withdrawals->total_amount + $withdrawals->total_tx_fee_real;
	return $balance;
}
	
# Агрегирование пользователей, их финансовой статистики и дохода для админа
function admin_get_stat () {
	global $client;
	$user_topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_type' => TX_TYPE_DEPOSIT_TOPUP],
			['confirmations' => ['$gte' => 6]]
		]
	]], ['$group' => [
		'_id' => '$to_address'
	]]]));
	$stat = [];
	foreach ($user_topups as $user) {
		$user_wallet = (string) $user->_id;
		$user = $client->main->users->findOne (['wallet' => $user_wallet]);
		$user_plans = user_get_plans ((string) $user->_id);
		$plan_stat = [
			'all_count' => 0,
			'pending_count' => 0,
			'need_to_decide_count' => 0,
			'sum_income' => 0,
			'sum_body' => 0
		];
		foreach ($user_plans as $plan_type => $plans_by_type) {
			foreach ($plans_by_type as $plan_id => $txs_topup) {
				foreach ($txs_topup as $topup_tx_id => $tx) {
					$plan_stat['all_count'] ++ ;
					if (isset ($tx['have_pending_withdrawals'])) {
						$plan_stat['pending_count'] ++ ;
					} else 
					if ($tx['need_to_decide']) {
						$plan_stat['need_to_decide_count'] ++ ;
					} 
					$plan_stat['sum_income'] += $tx['sum_income'];
					$plan_stat['sum_body'] += $tx['body'];
				}
			}
		}
		# + доход админа
		$admin_income = [
			'generated' => 0,
			'from_deposit_topups' => 0,
			'from_deposit_withdrawals' => 0,
			'from_plan_topups' => 0,
			'from_plan_withdrawals' => [
				'fees' => 0,
				'penalties' => 0,
			],
			'from_plan_reinvestments' => 0
		];
		# с пополнений депо
		$from_deposit_topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['tx_type' => TX_TYPE_DEPOSIT_TOPUP],
				['to_address' => $user_wallet],
				['confirmations' => ['$gte' => 6]]
			]
		]], ['$group' => [
			'_id' => '___',
			'total_fee_amount' => ['$sum' => '$tx_fee_user_in.fee_amount']
		]]]));
		if (count ($from_deposit_topups)) {
			$from_deposit_topups = $from_deposit_topups[0];
			$admin_income['generated'] += $from_deposit_topups->total_fee_amount;
			$admin_income['from_deposit_topups'] = $from_deposit_topups->total_fee_amount;
		}
		# с выводов из депо
		$from_deposit_withdrawals = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['tx_type' => TX_TYPE_DEPOSIT_WITHDRAW],
				['from_address' => $user_wallet],
				['confirmations' => ['$gte' => 0]],	# потом будет что-то вроде plan_tx_status
			]
		]], ['$group' => [
			'_id' => '___',
			'total_fee_amount' => ['$sum' => '$tx_fee_user_out.fee_amount']
		]]]));
		if (count ($from_deposit_withdrawals)) {
			$from_deposit_withdrawals = $from_deposit_withdrawals[0];
			$admin_income['generated'] += $from_deposit_withdrawals->total_fee_amount;
			$admin_income['from_deposit_withdrawals'] = $from_deposit_withdrawals->total_fee_amount;
		}
		# пополнений планов
		$from_plan_topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['tx_type' => TX_TYPE_PLAN_TOPUP],
				['from_address' => $user_wallet],
				['plan_tx_status' => STATUS_APPROVED],
			]
		]], ['$group' => [
			'_id' => '___',
			'total_fee_amount' => ['$sum' => '$tx_fee_user_out.fee_amount']
		]]]));
		if (count ($from_plan_topups)) {
			$from_plan_topups = $from_plan_topups[0];
			$admin_income['generated'] += $from_plan_topups->total_fee_amount;
			$admin_income['from_plan_topups'] = $from_plan_topups->total_fee_amount;
		}
		# выводов из планов
		$from_plan_withdrawals_fees = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['tx_type' => TX_TYPE_PLAN_WITHDRAW],
				['to_address' => $user_wallet],
				['plan_tx_status' => STATUS_APPROVED],
			]
		]], ['$group' => [
			'_id' => '___',
			'total_fee_amount' => ['$sum' => '$tx_fee_user_in.complex.tx_fee_plan_withdraw.fee_amount']
		]]]));
		if (count ($from_plan_withdrawals_fees)) {
			$from_plan_withdrawals_fees = $from_plan_withdrawals_fees[0];
			$admin_income['generated'] += $from_plan_withdrawals_fees->total_fee_amount;
			$admin_income['from_plan_withdrawals']['fees'] = $from_plan_withdrawals_fees->total_fee_amount;
		}
		$from_plan_withdrawals_penalties = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['tx_type' => TX_TYPE_PLAN_WITHDRAW],
				['to_address' => $user_wallet],
				['plan_tx_status' => STATUS_APPROVED],
			]
		]], ['$group' => [
			'_id' => '___',
			'total_fee_amount' => ['$sum' => '$tx_fee_user_in.complex.tx_fee_plan_penalty.fee_amount']
		]]]));
		if (count ($from_plan_withdrawals_penalties)) {
			$from_plan_withdrawals_penalties = $from_plan_withdrawals_penalties[0];
			$admin_income['generated'] += $from_plan_withdrawals_penalties->total_fee_amount;
			$admin_income['from_plan_withdrawals']['penalties'] = $from_plan_withdrawals_penalties->total_fee_amount;
		}
		# реинвестирований
		$from_plan_reinvestments = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
			'$and' => [
				['tx_type' => TX_TYPE_PLAN_REINVEST],
				['to_address' => $user_wallet],
				['plan_tx_status' => STATUS_APPROVED]
			]
		]], ['$group' => [
			'_id' => '___',
			'total_fee_amount' => ['$sum' => '$tx_fee_user_in.fee_amount']
		]]]));
		if (count ($from_plan_reinvestments)) {
			$from_plan_reinvestments = $from_plan_reinvestments[0];
			$admin_income['generated'] += $from_plan_reinvestments->total_fee_amount;
			$admin_income['from_plan_reinvestments'] = $from_plan_reinvestments->total_fee_amount;
		}
		$stat[] = [
			'user' => [
				'wallet' => $user_wallet,
				'email' => $user->email,
				'created_ts' => $user->created_ts,
			],
			'balance' => user_get_balance ((string) $user->_id),
			'plan_stat' => $plan_stat,
			'admin_income' => $admin_income
		];
	}
	$sorted_stat = [
		'sum_profit' => 0,
		'sum_withdrawn' => 0,
		'sum_em_topped_up' => 0,
		'sum_available' => 0,
		'total_tx_fee_real' => 0,
		'stat' => []
	];
	foreach ($stat as $s) {
		$key = str_pad (floor ($s['admin_income']['generated'] * TO_SATOSHI), 15, '0', STR_PAD_LEFT) . '__' . $s['user']['created_ts'] . '__' . $s['user']['email'];
		$sorted_stat['sum_profit'] += $s['admin_income']['generated'];
		$sorted_stat['stat'][$key] = $s;
	}
	ksort ($sorted_stat['stat']);
	$sorted_stat['stat'] = array_values ($sorted_stat['stat']);
	$sorted_stat['sum_available'] = $sorted_stat['sum_profit'];
	
	# + считаем вводы админа на профит-кошелек (типа emergency topup)
	$admin_em_topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_type' => TX_TYPE_ADMIN_WALLET_TOPUP],
			['to_address' => admin_get_profit_wallet ()]
		]
	]], ['$group' => [
		'_id' => '___',
		'total_amount' => ['$sum' => '$amount']
	]]]));
	if (count ($admin_em_topups)) {
		$admin_em_topups = $admin_em_topups[0];
		$sorted_stat['sum_em_topped_up'] = $admin_em_topups->total_amount;
		$sorted_stat['sum_available'] += $sorted_stat['sum_em_topped_up'];
	}

	# + считаем выводы админа
	$admin_withdrawals = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_type' => TX_TYPE_ADMIN_WALLET_WITHDRAW],
			['from_address' => admin_get_profit_wallet ()]
		]
	]], ['$group' => [
		'_id' => '___',
		'total_amount' => ['$sum' => '$amount']
	]]]));
	if (count ($admin_withdrawals)) {
		$admin_withdrawals = $admin_withdrawals[0];
		$sorted_stat['sum_withdrawn'] = $admin_withdrawals->total_amount;
		$sorted_stat['sum_available'] -= $sorted_stat['sum_withdrawn'];
	}
	
	# + админ платит все tx fee real
	$tx_fees_real = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_fee_real' => ['$gt' => 0]],
		]
	]], ['$group' => [
		'_id' => '___',
		'total_tx_fee_real' => ['$sum' => '$tx_fee_real']
	]]]));
	if (count ($tx_fees_real)) {
		$tx_fees_real = $tx_fees_real[0];
		$sorted_stat['total_tx_fee_real'] = $tx_fees_real->total_tx_fee_real;
		$sorted_stat['sum_available'] -= $tx_fees_real->total_tx_fee_real;
	}
	return $sorted_stat;
}

function admin_withdraw_profit ($to_external_wallet, $amount) {
	if (!is_string ($to_external_wallet) || !is_numeric ($amount) || $amount < 0) return ERROR_INCORRECT_PARAMETERS;
	$admin_withdrawal_magic_fee = db_option_get ('admin_withdrawal_magic_fee');
	if (!$admin_withdrawal_magic_fee || $admin_withdrawal_magic_fee < 0) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'admin_withdrawal_magic_fee is not set'
	]); 
	global $client;
	$stat = admin_get_stat ();
	if ($amount >= $stat['sum_available'] + $admin_withdrawal_magic_fee) return ERROR_UNSUFFICIENT_FUNDS;
	$tx_info = send_to_address ($to_external_wallet, $amount);
	if ($tx_info == null) return ERROR_SYSTEM; else {
		$client->main->transactions->insertOne ($tx = [
			'time_ts' => time (),
			'created_ts' => time (),
			'updated_ts' => time (),
			'from_address' => admin_get_profit_wallet (),
			'to_address' => $to_external_wallet,
			'tx_id' => $tx_info['tx_id'],
			'amount' => $amount,
			'tx_type' => TX_TYPE_ADMIN_WALLET_WITHDRAW,
			'tx_fee_user_in' => 0,
			'tx_fee_user_out' => 0,
			'tx_fee_real' => $tx_info['fee'],
			'confirmations' => 0
		]);
		# echo 'tx = ';
		# print_r ($tx);
		/*
		tx = Array
		(
		    [time_ts] => 1554845884
		    [created_ts] => 1554845884
		    [updated_ts] => 1554845884
		    [from_address] => 3G2EJdp35PDWJojjisswkQxtbW2bTWNAsa
		    [to_address] => 3HitTiCEDbAoNmeLNPC34GvUCQFggj4oMz
		    [tx_id] => f1d8cd269502e097842cbdc419b60bd43c28db72af31fcb3d1f67730aa46eccd
		    [amount] => 0.000285
		    [tx_type] => 512
		    [tx_fee_user_in] => 0
		    [tx_fee_user_out] => 0
		    [tx_fee_real] => 0.0001966
		    [confirmations] => 0
		)
		*/
		return true;
	}
}

# Агрегирование внешних адресов инвестирования (суммарная статистика оборота + стандартно можно раскидать по транзакциям)
function admin_get_external_topup_stat () { 
	global $client;
	# Мультитранзакции TX_TYPE_ADMIN_PLAN_OUT
	$stat = [];
	$txs = $client->main->transactions->find (['tx_type' => TX_TYPE_ADMIN_PLAN_OUT]);
	foreach ($txs as $tx) {
		@$stat[$tx->plan_id]['sum'] += $tx->amount;
		foreach ($tx->mtx_distribution as $d) {
			@$stat[$tx->plan_id]['by_addresses'][(string) $d->_id]['amount'] += (float) $d->amount;
		} 
	}
	foreach ($stat as $plan_id => $plan_stat) {
		foreach ($plan_stat['by_addresses'] as $address => $address_stat) {
			$user = $client->main->users->findOne (['wallet' => $address]);
			$stat[$plan_id]['by_addresses'][$address]['user'] = [
				'_id' => $user->_id,
				'email' => $user->email
			];
		}
	}
	return $stat;
}
 
/*
plan_create ([
	'name' => 'Тестовый срочный',
	'plan_type' => PLAN_TYPE_ON_TIME,
	'plan_yield' => 30,
	'plan_min_amount' => 0.000001,
	'plan_time_days' => 15,
	'tx_fee_plan_topup' => '5%/0.0005',
	'tx_fee_plan_withdraw' => '6%/0.0006',
	'tx_fee_plan_penalty' => [
		[10, '5%/0.0005'],
		[50, '2%/0.0005'],
	]
])
*/

function plan_create ($params) {
	global $client;
	if (
		!isset ($params['name']) || !$params['name'] || 
		!isset ($params['plan_type']) || !$params['plan_type'] || 
		!isset ($params['plan_yield']) || !$params['plan_yield'] || !is_numeric ($params['plan_yield']) ||
		!isset ($params['plan_min_amount']) || !$params['plan_min_amount'] || !is_numeric ($params['plan_min_amount'])
	) return ERROR_INCORRECT_PARAMETERS;
	if ($client->main->plans->count (['name' => $params['name']])) return ERROR_ALREADY_EXISTS;
	if ($params['plan_type'] == PLAN_TYPE_ON_TIME && (!isset ($params['plan_time_days']) || !$params['plan_time_days'] || !is_numeric ($params['plan_time_days']))) return ERROR_INCORRECT_PARAMETERS;
	if (!isset ($params['tx_fee_plan_topup']) || null === user_calc_fee ('flat', $params['tx_fee_plan_topup'], 1)) return ERROR_INCORRECT_PARAMETERS;
	if (!isset ($params['tx_fee_plan_withdraw']) || null === user_calc_fee ('flat', $params['tx_fee_plan_withdraw'], 1)) return ERROR_INCORRECT_PARAMETERS;
	if (!isset ($params['tx_fee_plan_penalty']) || null === user_calc_fee ('complex', $params['tx_fee_plan_penalty'], 1)) return ERROR_INCORRECT_PARAMETERS;
	$params['plan_yield'] = (float) $params['plan_yield'];
	$params['plan_min_amount'] = (float) $params['plan_min_amount'];
	if (isset ($params['plan_time_days'])) $params['plan_time_days'] = (int) $params['plan_time_days'];
	$result = $client->main->plans->insertOne ($params);
	$plan_id = $result->getInsertedId ();
	# + для истории изменения настроек доходности плана, используется для подсчета при многократном использовании
	$params['time_ts'] = time ();
	$params['plan_id'] = $plan_id;
	$client->main->plan_yield_mod_history->insertOne ($params); 
	return (string) $plan_id;
}

# Суммы, ожидающие инвестирования (по планам, каждый план сабмитим отдельно)
function plan_get_pending ($plan_id) {
	if (!$plan_id) return ERROR_INCORRECT_PARAMETERS;
	if (is_object ($plan_id)) $plan_id = (string) $plan_id;
	global $client;
	$plan_pending = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['plan_id' => $plan_id],
			['tx_type' => TX_TYPE_PLAN_TOPUP],
			['plan_tx_status' => STATUS_PENDING],
		]
	]], ['$group' => [
		'_id' => '$plan_id',
		'total_amount' => ['$sum' => '$amount']
	]]]));
	if (count ($plan_pending)) return $plan_pending[0]->total_amount; else return 0;
}

# То же самое с распределением по пользователям (точнее, по их кошелькам, возможно, это не совсем удобно, если да - то #TBD) (выводить список по кошелям в подробнее)
function plan_get_pending_as_user_wallets ($plan_id) {
	if (!$plan_id) return ERROR_INCORRECT_PARAMETERS;
	if (is_object ($plan_id)) $plan_id = (string) $plan_id;
	global $client;
	return iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['plan_id' => $plan_id],
			['tx_type' => TX_TYPE_PLAN_TOPUP],
			['plan_tx_status' => STATUS_PENDING],
		]
	]], ['$group' => [
		'_id' => '$from_address',
		'amount' => ['$sum' => '$amount']
	]]]));
}

# То же самое с распределением по транзакциям, (подробнее после пользователя)
function plan_get_pending_as_txs ($plan_id) {
	if (!$plan_id) return ERROR_INCORRECT_PARAMETERS;
	if (is_object ($plan_id)) $plan_id = (string) $plan_id;
	global $client;
	return iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['plan_id' => $plan_id],
			['tx_type' => TX_TYPE_PLAN_TOPUP],
			['plan_tx_status' => STATUS_PENDING],
		]
	]], ['$group' => [
		'_id' => '$_id',
		'amount' => ['$sum' => '$amount']
	]]]));
}

# Подтверждаем и инвестируем суммы - с этого момента начинается начисление процентов и срок для срочных планов
function plan_approve_pending ($plan_id, $wallet_to_send) {
	global $client;
	if (!$plan_id || !$wallet_to_send || !is_string ($wallet_to_send)) return ERROR_INCORRECT_PARAMETERS;
	if (is_object ($plan_id)) $plan_id = (string) $plan_id;
	$pending_amount = plan_get_pending ($plan_id);
	if (!$pending_amount || $pending_amount <= 0) return ERROR_INCORRECT_PARAMETERS;
	$mtx_distribution = plan_get_pending_as_user_wallets ($plan_id); 
	# 1. Отправляем транзакцию (одну) 
	$tx_info = send_to_address ($wallet_to_send, $pending_amount);
	if (is_array ($tx_info)) {
		# Сохраняем как мультитранзакцию для пользователей
		/*
		 * То есть: у каждого по факту пользователя будет по транзакции пополнения плана (то есть списания с баланса)
		 * Плюс будет будет мультитранзакция TX_TYPE_ADMIN_PLAN_OUT, которая собирает в себе конкретные транзакции пользователей с их объемами
		 */
		$tx = [
			'tx_id' => $tx_info['tx_id'],
			'amount' => $pending_amount,
			'tx_fee_real' => $tx_info['fee'],
			'mtx_distribution' => $mtx_distribution,
			'confirmations' => 0,
			'plan_id' => $plan_id,
			'to_address' => $wallet_to_send,
			'tx_type' => TX_TYPE_ADMIN_PLAN_OUT,
		];
		create_tx ($tx);
		
		# 2. Проставляем статусы STATUS_APPROVED у соответствующих транзакций на пополнение
		$tx_dist = plan_get_pending_as_txs ($plan_id);
		foreach ($tx_dist as $d) {
			$client->main->transactions->updateOne (['_id' => $d->_id], ['$set' => [
				'plan_tx_status' => STATUS_APPROVED,
				'plan_topup_approve_time' => time (),
				'updated_ts' => time ()
			]]); 
		}

		return true;

	} else return null;
}

# Возвращаем (редактированием транзакции)
function plan_reject_pending ($plan_id, $cause = '') {
	global $client;
	if (!$plan_id) return ERROR_INCORRECT_PARAMETERS;
	if (is_object ($plan_id)) $plan_id = (string) $plan_id;
	$tx_dist = plan_get_pending_as_txs ($plan_id);
	foreach ($tx_dist as $d) {
		$tx = $client->main->transactions->findOne (['_id' => $d->_id]);
		if ($tx) {
			# Reject & Revert
			$client->main->transactions->updateOne (['_id' => $tx->_id], ['$set' => [
				'plan_tx_status' => STATUS_REJECTED,
				'amount' => 0,
				'tx_fee_user_in' => 0,
				'tx_fee_user_out' => 0,
				'cause' => $cause,
				'updated_ts' => time ()
			]]);
		}
	}
	return true;
}

# Статистика для админа по плану и его текущее состояние
# + еще общая функция по профиту и как его вывести
function plan_get_stat ($plan_id) {
	global $client;	
	if (!$plan_id || !is_string ($plan_id)) return ERROR_INCORRECT_PARAMETERS;
	$plan = $client->main->plans->findOne (['_id' => new MongoDB\BSON\ObjectId ($plan_id)]);
	if (!$plan) return ERROR_DOES_NOT_EXIST;
	return $plan; # TBD	
}

# @vnoskov необходимо рассылать подтверждения при изменении доходности плана, если там есть балансы по функции выше
function plan_modify ($plan_id, $update) {
	global $client;
	if (!$plan_id || !is_string ($plan_id) || !is_array ($update) || count ($update) == 0) return ERROR_INCORRECT_PARAMETERS;
	$plan_id = new MongoDB\BSON\ObjectId ($plan_id);
	$plan = $client->main->plans->findOne (['_id' => $plan_id]);
	if (!$plan) return ERROR_DOES_NOT_EXIST;
	$update['updated_ts'] = time ();
	$client->main->plans->updateOne (['_id' => $plan_id], ['$set' => $update]);
	# + история изменений доходности и, возможно, сроков
	if (isset ($update['plan_yield']) && $plan->plan_yield != $update['plan_yield']) {
		$update['time_ts'] = time ();
		$update['plan_id'] = $plan_id;
		$client->main->plan_yield_mod_history->insertOne ($update);
	}
}

function plans_list_by ($filter = [], $sort = []) {
	global $client; 
	return iterator_to_array ($client->main->plans->find ($filter, $sort));
}

function user_plan_topup ($user_id, $plan_id, $amount) {
	global $client;
	$amount = (float) $amount;
	$tx = __plan_tx_template ($user_id, $plan_id, $amount, 'from_address');
	if (!is_array ($tx)) return $tx;
	$tx['tx_type'] = TX_TYPE_PLAN_TOPUP;
	$plan = $client->main->plans->findOne (['_id' => new MongoDB\BSON\ObjectId ($plan_id)]);
	# + расчет комиссий на пополнение
	if (!isset ($plan->tx_fee_plan_topup)) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'tx_fee_plan_topup is not set'
	]);
	if (!isset ($plan->plan_yield)) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'plan_yield is not set'
	]);
	$tx_fee_plan_topup_value = user_calc_fee ('flat', $plan->tx_fee_plan_topup, $amount);
	if ($tx_fee_plan_topup_value == null) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'tx_fee_plan_topup is incorrect'
	]);
	$tx['tx_fee_user_out'] = $tx_fee_plan_topup_value;
	$tx['tx_fee_user_in'] = 0; 
	$tx['tx_fee_real'] = 0;
	$tx['confirmations'] = 6;
	$tx['plan_tx_status'] = STATUS_PENDING;		# пока не одобрит админ, средства считаются списанными, но на план не идут
	$tx['plan_yield'] = $plan->plan_yield;
	$tx['plan_topup_approve_time'] = 0;			# отсюда считается доходность
	# + проверяем минималку
	if ($amount < $plan->plan_min_amount) return ERROR_AMOUNT_IS_TOO_SMALL;
	# + проверяем баланс пользователя
	$balance = user_get_balance ($user_id);
	if ($amount + $tx_fee_plan_topup_value['fee_amount'] > $balance) return ERROR_UNSUFFICIENT_FUNDS;
	return create_tx ($tx);
}

# Перевод прибыли в тело депозита с дополнительным процентом
# По факту - это специализированная транзакция пополнения плана 
# Плюс эта функция также работает, как функция создания начисления процентов сразу же с их непосредственным выводом 
# withdrawal_mode:
#  - force: вывести с пенальти
#  - std: вывести без пенальти
#  - void: просто зарегистрировать транзакцию для сброса счетчика доходности

function user_plan_income_to_body ($user_id, $plan_type, $plan_id, $topup_tx_id, $withdrawal_mode = 'force') {
	$tx_fee_user_i2b_t = db_option_get ('tx_fee_user_i2b_t');
	$tx_fee_user_i2b_d = db_option_get ('tx_fee_user_i2b_d');
	if ($tx_fee_user_i2b_t === null) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'tx_fee_user_i2b_t is not set'
	]);
	if ($tx_fee_user_i2b_d === null) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'tx_fee_user_i2b_d is not set'
	]);
	$plans = @user_get_plans ($user_id);
	if (!isset ($plans[$plan_type][$plan_id][$topup_tx_id])) return ERROR_DOES_NOT_EXIST;
	$p_info = $plans[$plan_type][$plan_id][$topup_tx_id];
	if ($withdrawal_mode == 'force') {
		# + fee  
		$tx_fee_user_in = user_calc_fee ('flat', $plan_type == PLAN_TYPE_ON_TIME ? $tx_fee_user_i2b_t : $tx_fee_user_i2b_d, $p_info['sum_income']);
		if (!is_array ($tx_fee_user_in)) critical_error ([
			'function' => __FUNCTION__,
			'cause' => 'fee error'
		]);
		# + проверка, не уйдет ли операция в минус
		if ($p_info['sum_income'] < $tx_fee_user_in['fee_amount']) return ERROR_UNSUFFICIENT_FUNDS;
		$tx_type = TX_TYPE_PLAN_REINVEST;
		$tx_amount = $p_info['sum_income'];	# суммарный доход = сумма транзакции (операции) по этому доходу
	} else {
		$tx_fee_user_in = 0;
		$tx_type = TX_TYPE_PLAN_INCOME;
		if ($withdrawal_mode == 'std') {
			$tx_amount = $p_info['sum_income'];	# то же самое
		} else if ($withdrawal_mode == 'void') {
			$tx_amount = 0;
		} else return ERROR_INCORRECT_PARAMETERS;
	}
	# Создание транзакции
	$tx = __plan_tx_template ($user_id, $plan_id, $p_info['sum_income'], 'to_address');	# тут некоторая формальность - на адрес по факту это пока не идет и в подсчете баланса эти типы транзакций не учитываются
	if (!is_array ($tx)) return $tx;
	$tx['tx_type'] = $tx_type;
	# + расчет комиссий на снятие с плана
	$tx['tx_fee_user_in'] = $tx_fee_user_in;
	$tx['amount'] = $tx_amount;
	$tx['tx_fee_user_out'] = 0;
	$tx['tx_fee_real'] = 0;
	$tx['confirmations'] = 6;
	$tx['topup_tx_id'] = $p_info['tx']->_id;
	$tx['plan_tx_status'] = STATUS_PENDING;	# пока pending, баланс плана уменьшается, но эквити не считается вообще, новый доход не начисляется
	return create_tx ($tx);
}

# Вывод (withdraw_income пока всегда должно быть true)
function user_plan_withdrawal_inquiry ($user_id, $plan_type, $plan_id, $topup_tx_id, $body_amount, $withdraw_income = true) {
	# Проверка параметров и настроек
	if (!is_numeric ($body_amount) || $body_amount < 0) return ERROR_INCORRECT_PARAMETERS;
	
	global $client;

	# 1. Получаем текущие проценты (аналогично предыдущей функции)
	$plans = @user_get_plans ($user_id);
	if (!isset ($plans[$plan_type][$plan_id][$topup_tx_id])) return ERROR_DOES_NOT_EXIST;
	$p_info = $plans[$plan_type][$plan_id][$topup_tx_id];

	# + проверка для расчета комиссий на снятие с плана
	$plan__id = new MongoDB\BSON\ObjectId ($plan_id);
	$plan = $client->main->plans->findOne (['_id' => $plan__id]);
		
	if (!isset ($plan->tx_fee_plan_withdraw) || $plan->tx_fee_plan_withdraw === null) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'tx_fee_user_plan_withdraw is not set'
	]);

	# сначала считаем, сколько в целом есть средств, доступных для вывода, с учетом комиссии
	$max_withdrawal_amount = $p_info['body'];
	if ($withdraw_income) $max_withdrawal_amount += $p_info['sum_income'];
	$__max_fee_value = user_calc_fee ('flat', $plan->tx_fee_plan_withdraw, $max_withdrawal_amount);
	if ($__max_fee_value == null) critical_error ([
		'function' => __FUNCTION__,
		'cause' => 'tx_fee_user_plan_withdraw is incorrect'
	]);

	# + пенальти для максимума
	$fee_penalty_days = null; # на будущее
	$__max_fee_penalty_value = 0;
	if (isset ($plan->tx_fee_plan_penalty) && $plan->tx_fee_plan_penalty) {
		$__max_fee_penalty_values = user_calc_fee ('complex', (array) $plan->tx_fee_plan_penalty, $max_withdrawal_amount);
		$days_passed = (time () - $p_info['tx']->time_ts) / (3600 * 24);
		foreach ($__max_fee_penalty_values as $days => $fee) {
			if ($days_passed < $days) {
				$__max_fee_penalty_value = $fee;
				$fee_penalty_days = $days;
			}
		}
		if ($__max_fee_penalty_value) $__max_fee_penalty_value = $__max_fee_penalty_value['fee_amount'];
	}
 
	$max_withdrawal_amount_available = $max_withdrawal_amount - $__max_fee_value['fee_amount'] - $__max_fee_penalty_value;
	
	# затем считаем, сколько выводится, с учетом указанной суммы тела, по тому же принципу
	$withdrawal_amount = $body_amount;
	if ($withdraw_income) $withdrawal_amount += $p_info['sum_income'];
	$tx_fee_plan_withdraw_value = user_calc_fee ('flat', $plan->tx_fee_plan_withdraw, $withdrawal_amount);
	
	# проверка на достаточность средств (оба без учета fee в данном условии)
	if ($withdrawal_amount >= $max_withdrawal_amount_available) return ERROR_UNSUFFICIENT_FUNDS;
	
	$tx = __plan_tx_template ($user_id, $plan_id, $withdrawal_amount, 'to_address');
	if (!is_array ($tx)) return $tx;

	# составляем fee из withdrawal и пенальти
	$tx_fee_plan_penalty_value = 0;
	if ($fee_penalty_days !== null) $tx_fee_plan_penalty_value = user_calc_fee ('complex', (array) $plan->tx_fee_plan_penalty, $withdrawal_amount)[$fee_penalty_days];
	
	$__complex_in_fee = [
		'complex' => [
			'tx_fee_plan_withdraw' => $tx_fee_plan_withdraw_value,
			'tx_fee_plan_penalty' => $tx_fee_plan_penalty_value,
		],
		'tx_fee_plan_penalty_days' => $fee_penalty_days,
		'fee_amount' => 	
			(is_array ($tx_fee_plan_withdraw_value) ? $tx_fee_plan_withdraw_value['fee_amount'] : 0) + 
			(is_array ($tx_fee_plan_penalty_value) ? $tx_fee_plan_penalty_value['fee_amount'] : 0)
	];

	# 3. Создаем запросы - проценты фиксируются на данном времени с помощью транзакции и далее процент считается уже после времени одобрения транзакции начисления процентов. Соответственно, данную транзакцию надо создать, даже если income_amount = 0
	# Тут надо записать все нужные транзакции со статусами PENDING и __income_start_time в функции выше может быть null (то есть останавливаем расчет профита, пока не разберемся, а потом будет временной разрыв между начислением предыдущего профита и стартом отсчета нового профита, равный времени одобрения или отклонения; если было отклонено - то редактируем транзакции с сохранением информации, что, как и почему)
	
	# 3.1 Создание транзакции для вывода дохода
	$i2b_tx_id = user_plan_income_to_body ($user_id, $plan_type, $plan_id, $topup_tx_id, $withdraw_income ? 'std' : 'void');
	if (!is_string ($i2b_tx_id)) return $i2b_tx_id;

	# 3.2 Создание транзакции для вывода тела
	$tx['tx_type'] = TX_TYPE_PLAN_WITHDRAW;
	$tx['tx_fee_user_in'] = $__complex_in_fee;
	$tx['tx_fee_user_out'] = 0;
	$tx['tx_fee_real'] = 0;
	$tx['topup_tx_id'] = $p_info['tx']->_id;	# = topup_tx_id
	$tx['i2b_tx_id'] = new MongoDB\BSON\ObjectId ($i2b_tx_id);
	$tx['plan_tx_status'] = STATUS_PENDING;	 	# пока pending, баланс плана уменьшается, но эквити не считается вообще, новый доход не начисляется
	
	return create_tx ($tx);
}

# Отображение запросов на вывод
function admin_plans_withdrawal_inquiries () {
	return [
		'withdrawal_txs' => txs_list_by ([
			'$and' => [
				['tx_type' => TX_TYPE_PLAN_WITHDRAW],
				['plan_tx_status' => STATUS_PENDING]
			]
		]),
		'reinvest_txs' => txs_list_by ([
			'$and' => [
				['tx_type' => TX_TYPE_PLAN_REINVEST],
				['plan_tx_status' => STATUS_PENDING]
			]
		])
	];
}

# Кошелек админа для пополнений и выплат пользователям
function admin_get_wallet () {
	$wallet = db_option_get ('admin_wallet');
	if ($wallet === null) {
		$wallet = btc_getnewaddress ();
		if (!$wallet) critical_error (['function' => __FUNCTION__, 'cause' => 'btc_getnewaddress']);
		db_option_set ('admin_wallet', $wallet);
	}
	return $wallet;
}

# Для этого кошелька мы считаем пополнения и выводы в депозиты пользователям
function admin_get_wallet_balance () {
	global $client;
	$topups = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_type' => TX_TYPE_ADMIN_WALLET_TOPUP],
			['to_address' => admin_get_wallet ()],
			['confirmations' => ['$gte' => 6]]	
		]
	]], ['$group' => [
		'_id' => 'admin_address',
		'total_amount' => ['$sum' => '$amount']
	]]]));
	$plan_withdrawals = iterator_to_array ($client->main->transactions->aggregate ([['$match' => [
		'$and' => [
			['tx_type' => TX_TYPE_PLAN_WITHDRAW],
			['from_address' => admin_get_wallet ()]
		]
	]], ['$group' => [
		'_id' => 'admin_address',
		'total_amount' => ['$sum' => '$amount']
	]]]));
	$balance = 0;
	if (count ($topups)) 			$balance += $topups->total_amount;
	if (count ($plan_withdrawals)) 	$balance -= $plan_withdrawals->total_amount;
	return $balance;
}

# Одобрение запроса на вывод
function admin_plan_withdrawal_inquiry_apply ($tx_id) {
	global $client;
	if (!$tx_id) return ERROR_INCORRECT_PARAMETERS;
	if (is_string ($tx_id)) $tx_id = new MongoDB\BSON\ObjectId ($tx_id);
	# Определение типа транзакции
	$tx = $client->main->transactions->findOne (['_id' => $tx_id]);
	if (!$tx) return ERROR_DOES_NOT_EXIST;
	if ($tx->tx_type == TX_TYPE_PLAN_REINVEST) {
		# Одобрение транзакции реинвестирования
		# Все это происходит на стороне инвестсчета, поэтому тело увеличиваем, но реально деньги пока вне системы
		$client->main->transactions->updateOne (['_id' => $tx_id], ['$set' => [
			'plan_tx_status' => STATUS_APPROVED
		]]);
		return true;
	}
	if ($tx->tx_type == TX_TYPE_PLAN_WITHDRAW) {
		# Тут уже интереснее - админ должен перекинуть средства со своего кошелька на кошелек пользователя
		# То есть админ что-то ввел на кошелек, эти средства - в общем доступе, и есть расчет, что они принадлежат админу
		# То есть транзакция вывода модифицируется с from_address = admin address и в дальнейшем пользователь сможет вывести средства из общего счета
		if (admin_get_wallet_balance () < $tx->amount) return ERROR_UNSUFFICIENT_FUNDS;	# упс, у админа не хватает средств
		$client->main->transactions->updateOne (['_id' => $tx_id], ['$set' => [
			'from_address' => admin_get_wallet (),
			'plan_tx_status' => STATUS_APPROVED
		]]);
		$client->main->transactions->updateOne (['_id' => new MongoDB\BSON\ObjectId ($tx->i2b_tx_id)], ['$set' => [
			'plan_tx_status' => STATUS_APPROVED
		]]);
		return true;
	}
	return ERROR_INCORRECT_PARAMETERS;
}

# Отклонение запроса на вывод с указанием причины
function admin_plan_withdrawal_inquiry_reject ($tx_id, $cause = '') {
	global $client; 
	if (!$tx_id) return ERROR_INCORRECT_PARAMETERS;
	if (is_string ($tx_id)) $tx_id = new MongoDB\BSON\ObjectId ($tx_id);
	$tx = $client->main->transactions->findOne (['_id' => $tx_id]);
	if (!$tx) return ERROR_DOES_NOT_EXIST;
	$client->main->transactions->updateOne (['_id' => $tx->_id], ['$set' => [
		'plan_tx_status' => STATUS_REJECTED,
		'cause' => $cause
	]]);
	if ($tx->tx_type == TX_TYPE_PLAN_WITHDRAW) {
		$client->main->transactions->updateOne (['_id' => new MongoDB\BSON\ObjectId ($tx->i2b_tx_id)], ['$set' => [
			'plan_tx_status' => STATUS_REJECTED,
			'cause' => $cause
		]]);
	}
	return true;
}

# (темплейт для создания транзакций, связанных с планами)
function __plan_tx_template ($user_id, $plan_id, $amount, $address_field) {
	global $client;
	if (!$amount || $amount < 0 || !is_numeric ($amount)) return ERROR_INCORRECT_PARAMETERS;
	
	if (!$user_id || !is_string ($user_id)) return ERROR_INCORRECT_PARAMETERS;
	$user = $client->main->users->findOne (['_id' => new MongoDB\BSON\ObjectId ($user_id)]);
	if (!$user) return ERROR_DOES_NOT_EXIST;
	
	if (!$plan_id || !is_string ($plan_id)) return ERROR_INCORRECT_PARAMETERS;
	if (!$client->main->plans->count (['_id' => new MongoDB\BSON\ObjectId ($plan_id)])) return ERROR_DOES_NOT_EXIST;
	
	$tx[$address_field] = $user->wallet;
	$tx['plan_id'] = $plan_id;
	$tx['amount'] = (float) $amount;

	return $tx;
}

# (используется почти везде в этом файле, как небольшой темплейт)
function create_tx ($params) {
	global $client;
	$tx = $params;
	$tx['time_ts'] = time ();
	$tx['updated_ts'] = time ();
	$result = $client->main->transactions->insertOne ($tx);
	return (string) $result->getInsertedId ();
}
 
# Опции в БД
# tx_fee_user_topup + tx_fee_user_withdraw
function db_option_get ($name) {
	global $client;
	$opt = $client->main->options->findOne (['name' => $name]);
	if ($opt) return $opt->value; else return null;
}

function db_option_set ($name, $value) {
	global $client;
	$opt = $client->main->options->findOne (['name' => $name]);
	if ($opt) {
		$client->main->options->updateOne (['_id' => $opt->_id], ['$set' => [
			'value' => $value,
			'updated_ts' => time ()
		]]);
	} else {
		$client->main->options->createIndex (['name' => 1], ['unique' => true]); 
		$client->main->options->insertOne ([
			'name' => $name,
			'value' => $value,
			'updated_ts' => time ()
		]);
	}
}

# Расчет комиссий модульный
function user_calc_fee ($class, $fee_value, $amount) {
	if ($class == 'flat') {
		return __user_calc_fee ($fee_value, $amount);
	}
	if ($class = 'complex') {
		if (is_string ($fee_value)) $fee_value = @json_decode ($fee_value);
		if (!is_array ($fee_value)) return null ;
		$complex_fee = [];
		foreach ($fee_value as $fee_v) {
			$complex_fee[(int) $fee_v[0]] = __user_calc_fee ($fee_v[1], $amount);
		}
		krsort ($complex_fee);
		return $complex_fee;
	}
	return null;
}

function __user_calc_fee ($fee_value, $amount) {
	$fee_value_e = explode ('/', $fee_value);
	$fee = $fee_amount = 0;
	if (count ($fee_value_e) == 2) {
		if (!is_numeric ($fee_value_e[1])) return null;
		if (!preg_match ("/^[0-9\.]+%$/", $fee_value_e[0])) return null;
		__calc_fee ($fee_value_e[0], $amount, $fee, $fee_amount);
		$min_fee_amount = (float) $fee_value_e[1];
		return [
			'fee_value' => $fee_value,
			'fee' => $fee,
			'fee_amount' => max ($fee_amount, $min_fee_amount)
		];
	} else if (count ($fee_value_e) == 1) {
		if (!preg_match ("/^[0-9\.]+[%]*$/", $fee_value_e[0])) return null;
		__calc_fee ($fee_value_e[0], $amount, $fee, $fee_amount);
		return [
			'fee_value' => $fee_value,
			'fee' => $fee,
			'fee_amount' => $fee_amount
		];
	} else return null;
}

function __calc_fee ($fee_value, $amount, &$fee, &$fee_amount) {
	if (strpos ($fee_value, '%') !== false) {
		$fee = (float) str_replace ('%', '', $fee_value);
		$fee /= 100;
		$fee_amount = $amount * $fee;
	} else {
		$fee = $fee_amount = (float) $fee_value;
	}
}

# Листинги транзакций
function txs_list_by ($filter = [], $sort = []) {
	global $client;
	return iterator_to_array ($client->main->transactions->find ($filter, $sort));
}

# Отправка транзакции на адрес
function send_to_address ($wallet, $amount) {
	if (!$wallet || !is_string ($wallet) || !$amount || $amount <= 0) return ERROR_INCORRECT_PARAMETERS;
	$tx_id = btc_sendtoaddress ($wallet, $amount);
	if ($tx_id !== null) {
		# + получаем real fee
		$info = btc_gettransaction ($tx_id);
		$fee = null;
		if (is_object ($info) && isset ($info->fee)) $fee = abs ($info->fee);
		return [
			'tx_id' => $tx_id,
			'fee' => $fee
		];
	} else return null;
}
