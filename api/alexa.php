<?php
require_once ('../classes/QueryBuilder.php');

use classes\QueryBuilder;

header('Content-Type: application/json');

$json = file_get_contents("php://input");
$data = json_decode($json, true);

$query = "SELECT MAX(AMOUNT) amount FROM wallet_invest a ".
"JOIN wallet_categories b on a.category_id = b.id ".
"WHERE b.category = '".$data['category']."'";

$mysql   = new QueryBuilder();
$results = $mysql->get($query);

$response = [
    "category" => $data['category'],
    "data"     => $results
];

# Create response and sending headers
echo json_encode($response);