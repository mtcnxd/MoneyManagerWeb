<?php

require_once ('classes/autoload.php'); 

use classes\investments;

$investment = new investments();

$currentBalance = $investment->getTotal();
echo json_encode(
    "amount" => '$'. number_format($currentBalance, 2)
)