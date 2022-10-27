<?php

### Синхронизация транзакций (crontab -e) ###
$basedir = '/var/www/html'; 
include ($basedir . '/backend/backend.php'); 

# Проверка на необходимые опции (дорабатывается)
$tx_fee_user_topup = db_option_get ('tx_fee_user_topup');
if ($tx_fee_user_topup === null) critical_error ([
	'function' => 'in sync.php',
	'cause' => 'tx_fee_user_topup is not set'
]);
if (null === user_calc_fee ('flat', $tx_fee_user_topup, 1)) critical_error ([
	'function' => 'in sync.php',
	'cause' => 'tx_fee_user_topup is incorrect'
]);

# Добавляем индекс по мере необходимости
$client->main->transactions->createIndex (['time_ts' => 1], ['unique' => false]);

$page_num = 0;
# к сожалению, цикл придется проработать до конца, потому что сортировать в обратном порядке bitcoind не умеет
while (true) {
	$new_txs = btc_listtransactions ($page_num ++);
	if (!count ($new_txs)) break ;  # если транзакции закончились - выходим 
	foreach ($new_txs as $new_tx) {
		$old_tx = $client->main->transactions->findOne (['tx_id' => $new_tx->txid]);
		if (!$old_tx) {
			# Это новая транзакция
			if ($new_tx->category == 'receive') {
				# - определение назначения транзакции
				$user = $client->main->users->findOne (['wallet' => $new_tx->address]);
				if ($user) {
					# это транзакция на пополнение депозита
					$client->main->transactions->insertOne ([
						'tx_id' => $new_tx->txid,
						'time_ts' => $new_tx->timereceived,
						'to_address' => $new_tx->address,
						'tx_type' => TX_TYPE_DEPOSIT_TOPUP,
						'amount' => $new_tx->amount,
						'confirmations' => $new_tx->confirmations,
						'tx_fee_user_out' => 0,
						'tx_fee_real' => 0,
						'tx_fee_user_in' => user_calc_fee ('flat', $tx_fee_user_topup, $new_tx->amount),
					]);
				} else {
					# Возможно, это админ пополнил свой кошелек для того, чтобы выполнить требования инвесторов на вывод или компенсировать tx fee real
					if ($new_tx->address == admin_get_wallet () || $new_tx->address == admin_get_profit_wallet ()) {
						$client->main->transactions->insertOne ([
							'tx_id' => $new_tx->txid,
							'time_ts' => $new_tx->timereceived,
							'to_address' => $new_tx->address,
							'tx_type' => TX_TYPE_ADMIN_WALLET_TOPUP,
							'amount' => $new_tx->amount,
							'confirmations' => $new_tx->confirmations,
							'tx_fee_user_out' => 0,
							'tx_fee_real' => 0,
							'tx_fee_user_in' => 0
						]);
					}
				}
			}
		} else {
			# Если старая, то в любом случае обновляем количество подтверждений, если оно менее 6
			if ($old_tx->confirmations < 6) {
				$client->main->transactions->updateOne (['_id' => $old_tx->_id], ['$set' => [
					'confirmations' => $new_tx->confirmations
				]]);
			}
		}
	}
}