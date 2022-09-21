<?php
require_once ("wallet.fortech.mx/classes/myWallet.php");
require_once ("wallet.fortech.mx/classes/QueryBuilder.php");

use classes\myWallet;

$wallet = new myWallet();
$balances = $wallet->loadCurrentInvestments();
$total = 0;

foreach ($balances as $row) {
	$wallet->insert('wallet_cron_balances', [
		"concept" => $row->concept,
		"amount"  => $row->amount,
		"date" 	  => date("Y-m-d"),
	]);
	
}