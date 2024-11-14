<?php

$json = file_get_contents("php://input");
$data = json_decode($json, true);


# Create response and sending headers

header('Content-Type: application/json');
echo json_encode($data);