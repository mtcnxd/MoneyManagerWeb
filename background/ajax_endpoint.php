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
        $sql->update(['visible' => $status], ['id' => $object]);
        $sql->execute();

        $message = array(
            "Result" => "Success",
        );
    break;

    case 'deleteCategory':
        $sql = new QueryBuilder();
        $sql->table('wallet_category');
        $sql->delete([
            'id' => $object
        ]);
        $sql->execute();

        $message = array(
            "Result" => "Deleted",
        );
    break;
}

echo json_encode($message);