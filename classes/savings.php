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

	public function delete($id){
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);
		return $mysql->delete([
			'id' => $id
		]);
	}

	public function load()
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);
		return $mysql->all();
	}

	public function insert($data)
	{
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->insert($data);
	}

	public function getAll()
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);		
		return $mysql->all();
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
