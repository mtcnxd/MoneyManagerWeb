<?php
require_once ("../classes/myWallet.php");
require_once ("../classes/QueryBuilder.php");

use classes\myWallet;

$wallet = new myWallet();
$balances = $wallet->getCurrentBalances();

foreach ($balances as $row) {
	$wallet->insert('wallet_cron_balances', [
		"concept" => $row->concept,
		"amount"  => $row->amount,
		"date" 	  => date("Y-m-d"),
	]);
}

echo "success";