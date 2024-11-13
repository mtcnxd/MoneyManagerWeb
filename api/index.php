<?php

require_once ('../classes/investments.php'); 
require_once ('../classes/QueryBuilder.php');

use classes\investments;

$investment = new investments();

$currentBalance = $investment->getTotal();

$months = [
    "enero", "febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"
];

$data = [
    "day"     => date('d'),
    "month"   => $months[date('m') - 1],
    "savings" => number_format($currentBalance, 0)
];

# Create response and sending headers

header('Content-Type: application/json');
echo json_encode($data);