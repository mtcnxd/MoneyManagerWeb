<?php
namespace classes;

class categories
{
	protected $table = "wallet_categories";

    public function find($id = null)
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'id' => $id
		]);
		return $mysql->first();
	}

    public function load($type)
	{
		$mysql  = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'type' => $type
		]);
		$mysql->order('category');
		return $mysql->get();
	}

	public function insert($data)
	{
		$query = new QueryBuilder();
		$query->table($this->table);
		$query->insert($data);
	}

	public function delete($id)
	{
		$query = new QueryBuilder();
		$query->table($this->table);
		$query->delete([
			"id" => $id
		]);
	}

}
