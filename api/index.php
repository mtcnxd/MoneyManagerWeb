<?php

require_once ('../classes/investments.php'); 
require_once ('../classes/QueryBuilder.php');

use classes\investments;

$investment = new investments();

$currentBalance = $investment->getTotal();


$data = [
    "savings" => number_format($currentBalance, 2)
];


# Create response and sending headers

header('Content-Type: application/json');
echo json_encode($data);