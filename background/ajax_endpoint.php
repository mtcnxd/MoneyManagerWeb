<?php

require_once ("../classes/QueryBuilder.php");
require_once ("../classes/categories.php");

use classes\QueryBuilder;
use classes\categories;

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
            "result" => "Success",
            "data" => $result
        );
    break;

    case 'deleteCategory':
        $sql = new QueryBuilder();
        $sql->table('wallet_category');
        $result = $sql->delete(
            ['id' => $object]
        );

        $message = array(
            "result" => "Deleted",
            "data" => $result
        );
    break;

    case 'loadCategory':
        $categories = new categories();
		$data = $categories->load($_POST['object']);
		foreach ($data as $category){
			$result[] = $category->category;
		}
        $message = array(
            "result" => true,
            "data"   => $result
        );

	break;
}

echo json_encode($message);