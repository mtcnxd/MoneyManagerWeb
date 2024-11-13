<?php

require_once ('../classes/investments.php'); 
require_once ('../classes/QueryBuilder.php');

use classes\investments;

$investment = new investments();

$currentBalance = $investment->getTotal();

echo number_format($currentBalance, 2);