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

}
