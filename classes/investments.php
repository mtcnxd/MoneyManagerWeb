<?php
namespace classes;

class investments 
{
	protected $table = "wallet_invest";

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
		$query = new QueryBuilder();
		$query->table($this->table);
		$query->insert($data);
	}

	public function updateBalances($data)
	{
		$query = new QueryBuilder();
		$query->table('wallet_cron_balances');
		$query->insert($data);
	}

	public function loadLastMonth($id)
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT * FROM wallet_invest
			WHERE category_id = '$id' AND date > NOW() - INTERVAL 1 MONTH 
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
