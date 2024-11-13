<?php

require_once ('../classes/investments.php'); 
require_once ('../classes/QueryBuilder.php');

use classes\investments;

$investment = new investments();

$currentBalance = $investment->getTotal();


$data = [
    "savings" => number_format($currentBalance, 2)
];

echo json_encode($data);