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
        $sql->table('wallet_categories');
        $result = $sql->update([
            'visible' => $status
        ], [
            'id' => $object
        ]);

        $maxid = $sql->first("SELECT MAX(id) as id FROM `wallet_invest` where category_id = '$object'");

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
}

echo json_encode($message);