<?php
namespace classes;

class savings 
{
    public function find($id = null)
	{
		$mysql  = new QueryBuilder();
        $mysql->table('wallet_saving');
        $mysql->where([
            'id' => $id
        ]);
		return $mysql->first();
	}

    public function load()
	{
		$mysql  = new QueryBuilder();
        $mysql->table('wallet_saving');
		return $mysql->all();
	}

	public function insert($data)
	{
		$query = new QueryBuilder();
		$query->table('wallet_saving');
		$query->insert($data);
	}    

    public function getTotal()
    {
		$mysql  = new QueryBuilder();
        $mysql->table('wallet_saving');

        $total = 0;
        foreach ($mysql->all() as $sum) {
            $total += $sum->amount;
        }
        return $total;
    }
}
