<?php

require_once ("../classes/QueryBuilder.php");
require_once ("../classes/investments.php");
require_once ("../classes/categories.php");
require_once ("../classes/savings.php");
require_once ("../classes/bills.php");

use classes\QueryBuilder;
use classes\categories;
use classes\savings;
use classes\bills;

$object = isset($_POST['object']) ? $_POST['object'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : '';

switch ($_POST['action'])
{
    case 'updateCheckboxStatus':
        $sql = new QueryBuilder();
        ($status == 'true') ? $status = 1 : $status = 0; 
        $sql->table('wallet_categories');
        $result = $sql->update(
            ['visible' => $status], 
            ['id' => $object]
        );

        $maxid = $sql->first("SELECT MAX(id) as id FROM `wallet_invest` WHERE category_id = '$object'");

        $sql->table('wallet_invest');
        $sql->update(
            ['include' => $status], 
            ['id' => $maxid->id]
        );

        $message = array(
            "message" => "Los cambios se guardaron con exito",
            "data"    => $result
        );
    break;

    case 'updateConfiguration':
        $sql = new QueryBuilder();
        $sql->table('wallet_configuration');
        $result = $sql->update(
            ['value' => $status], 
            ['id' => $object]
        );

        $message = array(
            "message" => "Los cambios se guardaron con exito",
            "data"    => $result
        );
    break;

    case 'deleteCategory':
        $sql = new QueryBuilder();
        $sql->table('wallet_categories');
        $result = $sql->delete([
            'id' => $object
        ]);

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

    case 'deleteInvest':
        $investment = new investments();
        $message = array(
            "message" => "Esta es una prueba",
            "invest"  => $investment->delete($_POST['object'])
        );
    break;

    case 'deleteSaving':
        $saving  = new savings();
        $saving->delete($_POST['object']);
        $result  = $saving->getAll();

        $message = array(
            "message" => "Se elimino correctamente",
            "data"    => $result
          );
    break;

    case 'deleteCriptyInvest':
        $sql = new QueryBuilder();
        $sql->table('wallet_crypto');
        $result = $sql->delete([
            'id' => $object
        ]);

        $message = array(
            "message" => "Se elimino exitosamente",
            "data"    => $result
        );
    break;

    case 'insertCriptyInvest':
        $sql = new QueryBuilder();
        $sql->table('wallet_crypto');
        $result = $sql->insert([
            'parity' => $_POST['parity'],
            'amount' => $_POST['amount'],
            'price'  => $_POST['price'],
            'status' => true
        ]);

        $message = array(
            "message" => "Guardado correctamente",
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