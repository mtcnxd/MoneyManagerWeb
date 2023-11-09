<?php

require_once ("../classes/QueryBuilder.php");
require_once ("../classes/categories.php");
require_once ("../classes/bills.php");

use classes\QueryBuilder;
use classes\categories;
use classes\bills;

$object = $_POST['object'];
$status = isset($_POST['status']) ? $_POST['status'] : '';

switch ($_POST['action'])
{
    case 'updateCheckboxStatus':
        $sql = new QueryBuilder();
        ($status == 'true') ? $status = 1 : $status = 0; 
        $sql->table('wallet_categories');
        $result = $sql->update([
            'visible' => $status
        ], [
            'id' => $object
        ]);

        $maxid = $sql->first("SELECT MAX(id) as id FROM `wallet_invest` WHERE category_id = '$object'");

        $sql->table('wallet_invest');
        $sql->update([
            'include' => $status
        ], [
            'id' => $maxid->id
        ]);

        $message = array(
            "message" => "Los cambios se guardaron con exito",
            "data"    => $result
        );
    break;

    case 'updateConfiguration':
        $sql = new QueryBuilder();
        $sql->table('wallet_configuration');
        $result = $sql->update([
            'value' => $status
        ], [
            'id' => $object
        ]);

        $message = array(
            "message" => "Los cambios se guardaron con exito",
            "data"    => $result
        );
    break;

    case 'deleteCategory':
        $sql = new QueryBuilder();
        $sql->table('wallet_categories');
        $result = $sql->delete(
            ['id' => $object]
        );

        $message = array(
            "message" => "La categoria se elimino exitosamente",
            "data"    => $result
        );
    break;

    case 'loadCategory':
        $categories = new categories();
		$data = $categories->load($_POST['object']);
		foreach ($data as $category){
			$result[] = $category->category;
		}
        $message = array(
            "message" => "Categorias cargadas correctamente",
            "data"    => $result
        );
    break;

    case 'loadBillDetails':
        $bills = new bills();
        $result = $bills->find($_POST['object']);

        $message = array(
            "message" => "Informacion cargada con exito",
            "data"    => $result
          );
    break;

    default:
        $message = array(
          "message" => "Action not implemented",
          "data"    => $_POST
        );
    break;
}

echo json_encode($message);