<?php
namespace classes;

class users {

    public function find($id = null)
	{
		$mysql  = new QueryBuilder();
        $mysql->table('wallet_users');
        $mysql->where([
            'id' => $id
        ]);
		return $mysql->first();
	}

	public function insert($data)
	{
		$query = new QueryBuilder();
		$query->table('wallet_users');
		$query->insert($data);
		$query->execute();
	}       

}
