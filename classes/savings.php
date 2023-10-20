<?php
namespace classes;

class savings 
{
	protected $table = "wallet_saving";

	public function find($id = null)
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'id' => $id
		]);
		return $mysql->first();
	}

	public function load()
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);
		return $mysql->all();
	}

	public function insert($data)
	{
		$query = new QueryBuilder();
		$query->table($this->table);
		$query->insert($data);
	}

	public function getTotal()
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);

		$total = 0;
		foreach ($mysql->all() as $sum) {
			$total += $sum->amount;
		}
		return $total;
	}
}
