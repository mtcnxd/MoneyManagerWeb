<?php
require_once ("wallet.fortech.mx/classes/myWallet.php");
require_once ("wallet.fortech.mx/classes/QueryBuilder.php");
require_once ("wallet.fortech.mx/classes/investments.php");

use classes\investments;

$investments = new investments();

$balances = $investments->getCurrentBalances();

foreach ($balances as $balance) {
	$investments->updateBalances([
		"category"    => $balance->category,
		"category_id" => $balance->category_id,
		"amount"	  => $balance->amount,
		"date"		  => date("Y-m-d"),
	]);
}