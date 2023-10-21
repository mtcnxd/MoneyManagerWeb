<?php
namespace classes;

class bills 
{
	protected $table = "wallet_bills";

	public function find($id = null)
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'id' => $id
		]);
		return $mysql->first();
	}

	public function insert($data)
	{
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->insert($data);
	}

	public function getBillByDate($date)
	{
		$query = new QueryBuilder();
		$query->table($this->table);
		$query->where([
			'date' => $date,
		]);
		return $query->first();
	}		

	public function getDataBetween($type, $startDate, $endDate)
	{
		$mysql = new QueryBuilder();
		$query = "SELECT * FROM $this->table 
			WHERE type = '$type' AND date BETWEEN '$startDate' AND '$endDate'";
			
		return $mysql->get($query);
	}
}
