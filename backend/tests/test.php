<?php

include ('../backend.php');

# print_r (admin_withdraw_profit ('3HitTiCEDbAoNmeLNPC34GvUCQFggj4oMz', 0.00028500));

# exit ;

print_r (admin_get_stat ());
exit ;

print_r (user_get_plans ('5ca4e36de58faa6726583072')); # plan id5c77043de58faa2179523cb2

exit; 

print_r (user_get_balance ('5c830a21e58faa45510e8082'));

exit ;

print_r (send_to_address ('3AdVuEMR11tarfGxpW6zuWFxX1LEh2X4av', 0.0045));

exit ;

print_r (admin_get_external_topup_stat ());

exit ;

# db_option_set ('admin_withdrawal_magic_fee', '0.001');
print_r (admin_get_stat ());

exit ;

print_r (user_get_plans ('5c830a21e58faa45510e8082'));
print_r (txs_list_by(['$or' => [['from_address' => '3JGBHqmp9ihTVQZ2yRcewVEWmKZp7phE5r'], ['to_address' => '3JGBHqmp9ihTVQZ2yRcewVEWmKZp7phE5r']]], ['time_ts' => -1]));

exit ;

print_r (admin_plans_withdrawal_inquiries ());

exit ;

print_r (user_get_plans ('5c830a21e58faa45510e8082'));

exit ;

print_r (user_plan_withdrawal_inquiry ('5c830a21e58faa45510e8082', 2, '5c77043de58faa2179523cb2', '5c83ca99e58faa655f1e3982', 0.002, true));

exit ;
/*
exit ;

print_r (send_to_address ('34zhGv1DHGpdMtGf7NaxtMS4z95HkQv9eA', 0.0058));

exit;

db_option_set ('tx_fee_user_i2b_d', '5%/0.001');
db_option_set ('tx_fee_user_i2b_t', '15%/0.005');

print_r (user_plan_income_to_body ('5c80865de58faa6d904e6073', 4, '5c77fcb0e58faa102171d572', '5c814e30e58faa3b4e69a252'));

exit ;
*/

print_r (user_get_plans ('5c830a21e58faa45510e8082'));

exit ;

print_r (plan_get_pending_as_txs ('5c77fcb0e58faa102171d572'));

exit ;

print_r (send_to_address ('34zhGv1DHGpdMtGf7NaxtMS4z95HkQv9eA', 0.0015));

exit ;

print_r (plan_get_pending_as_txs ('5c75dac7e58faa380153d0b2'));

exit ;

print_r (plan_approve_pending ('5c75dac7e58faa380153d0b2', '34zhGv1DHGpdMtGf7NaxtMS4z95HkQv9eA'));

exit ;

print_r (plan_get_pending_as_user_wallets ('5c77fcb0e58faa102171d572'));

exit ;

print_r (txs_list_by (['$and' => [['tx_type' => TX_TYPE_PLAN_TOPUP], ['plan_id' => '5c77fcb0e58faa102171d572'], ['from_address' => '3PGip6PzYX1WGA6pk9trk5DirYaxLBSMs4']]], ['time_ts' => -1]));

exit ;

print_r (plan_get_pending_as_user_wallets ('5c77fcb0e58faa102171d572'));

exit;

print_r (plan_approve_pending ('5c77fcb0e58faa102171d572', '3DHFSJMZXW8bH7Gqo9sXpJaTUQ14Wyp9o2'));

exit ;

print_r (plan_get_pending_as_txs ('5c77fcb0e58faa102171d572'));

exit ;

print_r (btc_sendtoaddress ('3DHFSJMZXW8bH7Gqo9sXpJaTUQ14Wyp9o2', 0.00025));

exit ;

btc_settxfee (15);
print_r (plan_get_pending ('5c77fcb0e58faa102171d572'));

exit ;

db_option_set ('tx_fee_user_topup', '5%/0.001');
print_r (user_get_balance ('5c75ae09e58faa7b4f393822')); 
echo "\n";
print_r (user_plan_topup ('5c75ae09e58faa7b4f393822', '5c77fcb0e58faa102171d572', 0.001));
echo "\n"; 
print_r (user_get_balance ('5c75ae09e58faa7b4f393822')); 
