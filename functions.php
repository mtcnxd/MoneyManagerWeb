<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$wallet = new myWallet();

switch($_POST['option'])
{
	case 'loadCategories':
		$data = $wallet->selectCategory($_POST['category']);
		foreach ($data as $category){
			echo "<option value='".$category->name."'>". $category->name ."</option>";
		}
		break;

	case 'default':

	break;
}