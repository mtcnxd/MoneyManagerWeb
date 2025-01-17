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
		
		return $query->get();
	}

	public function getDataBetween($type, $startDate, $endDate)
	{
		$mysql = new QueryBuilder();
		$query = "SELECT * FROM $this->table
			WHERE type = '$type' AND date BETWEEN '$startDate' AND '$endDate'
			ORDER by date ASC";

		return $mysql->get($query);
	}

	public function spendsByCategory($startDate, $endDate)
	{
		$mysql = new QueryBuilder();
		$sql = "SELECT category, sum(amount) FROM wallet_bills where date between ".$startDate." and ".$endDate." group by category";
		return $mysql->get($sql);
	}
}
