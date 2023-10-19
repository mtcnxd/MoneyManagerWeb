<?php

require_once ("../classes/QueryBuilder.php");

use classes\QueryBuilder;

$object = $_POST['object'];
$status = $_POST['status'];

switch ($_POST['action'])
{
    case 'updateCheckboxStatus':
        $sql = new QueryBuilder();
        ($status == 'true') ? $status = 1 : $status = 0; 
        $sql->table('wallet_category');
        $result = $sql->update(
            ['visible' => $status], 
            ['id' => $object]
        );

        $message = array(
            "Result" => "Success",
            "Response" => $result
        );
    break;

    case 'deleteCategory':
        $sql = new QueryBuilder();
        $sql->table('wallet_category');
        $result = $sql->delete(
            ['id' => $object]
        );

        $message = array(
            "Result" => "Deleted",
            "Response" => $result
        );
    break;
}

echo json_encode($message);