<?php

header('Content-Type: application/json');
$json = file_get_contents("php://input");
$data = json_decode($json, true);


$response = [
    "name": "marcos",
    "message":"hola mundo"
];

# Create response and sending headers
echo json_encode($response);