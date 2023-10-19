<?php
namespace classes;

class categories {

    public function find($id = null)
	{
		$mysql  = new QueryBuilder();
        $mysql->table('wallet_category');
        $mysql->where([
            'id' => $id
        ]);
		return $mysql->first();
	}

    public function load($type)
	{
		$mysql  = new QueryBuilder();
        $mysql->table('wallet_category');
        $mysql->where([
            'type' => $type
        ]);
        $mysql->order('category');
		return $mysql->get();
	}

	public function insert($data)
	{
		$query = new QueryBuilder();
		$query->table('wallet_category');
		$query->insert($data);
		$query->execute();
	}

	public function delete($id)
	{
		$query = new QueryBuilder();
		$query->table('wallet_category');
		$query->delete([
			"id" => $id
		]);
	}

}