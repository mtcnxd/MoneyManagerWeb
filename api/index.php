<?php

require_once ('../classes/investments.php'); 
require_once ('../classes/QueryBuilder.php');

use classes\investments;

$investment = new investments();

$currentBalance = $investment->getTotal();


$data = [
    "day"     => date('d'),
    "month"   => date('m'),
    "savings" => number_format($currentBalance, 0)
];


# Create response and sending headers

header('Content-Type: application/json');
echo json_encode($data);