<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$wallet = new myWallet();
$balances = $wallet->loadCurrentInvestments();

echo json_encode($balances);