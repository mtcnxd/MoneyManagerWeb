<?php
require_once ("wallet.fortech.mx/classes/myWallet.php");
require_once ("wallet.fortech.mx/classes/QueryBuilder.php");
require_once ("wallet.fortech.mx/classes/investments.php");

use classes\myWallet;
use classes\investments;

$wallet = new myWallet();
$investments = new investments();

$balances = $wallet->getCurrentBalances();

foreach ($balances as $balance) {
	$investments->updateBalances([
		"concept" => $balance->concept,
		"amount"  => $balance->amount,
		"date" 	  => date("Y-m-d"),
	]);
}