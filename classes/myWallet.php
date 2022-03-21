<?php

namespace classes;

use classes\mySQL;

class myWallet 
{
	public function insertData($table, $data)
	{
		$mysql = new MySQL();
		$mysql->mySQLinsert($table, $data);
	}

	public function selectCategory($type)
	{
		$mysql  = new MySQL();
		$query  = "SELECT * FROM wallet_category WHERE type = '$type'";
		$result = $mysql->mySQLquery($query);
		return $result;
	}

	public function selectMovementsRange($start, $end)
	{
		$mysql  = new MySQL();
		$query  = "SELECT * FROM `wallet_movements` a JOIN `wallet_category` b 
				   ON a.category = b.id WHERE date between '$start' and '$end'
				   ORDER by a.date ASC, a.type";
		$result = $mysql->mySQLquery($query);
		return $result;
	}

	public function selectFixedPayments()
	{
		$mysql  = new MySQL();
		$query  = "SELECT * FROM `wallet_fixed_payments`";
		$result = $mysql->mySQLquery($query);
		return $result;
	}

	public function getBalanceTotal($type = 'ingreso')
	{
		$mysql  = new MySQL();
		$query  = "SELECT SUM(amount) as total FROM `wallet_movements` WHERE type = '$type'; ";
		$result = $mysql->mySQLquery($query);
		$result = $result[0]->total;
		
		return number_format($result, 2);
	}

	public function getBalanceFrom($from = 'wallet_saving')
	{
		$mysql  = new MySQL();
		$query  = "SELECT SUM(amount) as total FROM `$from`";
		$result = $mysql->mySQLquery($query);
		$result = $result[0]->total;
		
		return $result;
	}	

	public function selectTable($table = 'wallet_saving')
	{
		$mysql  = new MySQL();
		$query  = "SELECT * FROM `$table` ORDER BY amount";
		$result = $mysql->mySQLquery($query);
		
		return $result;
	}		
}