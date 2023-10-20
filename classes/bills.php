<?php
namespace classes;

class bills 
{
	public function find($id = null)
	{
		$mysql  = new QueryBuilder();
		$mysql->table('wallet_bills');
		$mysql->where([
			'id' => $id
		]);
		return $mysql->first();
	}

	public function insert($data)
	{
		$mysql = new QueryBuilder();
		$mysql->table('wallet_bills');
		$mysql->insert($data);
	}

	public function getDataBetween($type, $startDate, $endDate)
	{
		$mysql = new QueryBuilder();
		$query = "SELECT * FROM wallet_bills WHERE type = '$type' AND date BETWEEN '$startDate' AND '$endDate'";
		return $mysql->get($query);
	}
}
