<?php
namespace classes;

class investments {

	public function find($id = null)
	{
		$mysql  = new QueryBuilder();
		$mysql->table('wallet_invest');
		$mysql->where([
			'id' => $id
		]);
		return $mysql->first();
	}

	public function insert($data)
	{
		$query = new QueryBuilder();
		$query->table('wallet_invest');
		$query->insert($data);
	}

	public function updateBalances($data)
	{
		$query = new QueryBuilder();
		$query->table('wallet_cron_balances');
		$query->insert($data);
	}

	public function loadLastMonth($concept)
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT * FROM wallet_invest 
			WHERE concept = '$concept' AND date > NOW() - INTERVAL 1 MONTH 
			ORDER BY date DESC";

		return $mysql->get($query);
	}

	public function getTotal()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT SUM(amount) as total FROM wallet_invest WHERE date IN (
				SELECT max(date) max_date FROM wallet_invest GROUP BY concept) 
			AND include = true ORDER BY concept";

		$result = $mysql->first($query);
		return $result->total;
	}	
}
