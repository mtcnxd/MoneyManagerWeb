<?php
namespace classes;

use classes\users;

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

}
