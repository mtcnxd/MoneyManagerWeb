<?php
namespace classes;

class users
{
	protected $table  = "wallet_users";

	public function find($sesion)
	{
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'id' => $sesion['userData']->id
		]);
		return $mysql->first();
	}

	public function loadConfiguration($sesion)
	{
		$mysql = new QueryBuilder();
		$mysql->table('wallet_configuration');
		$mysql->where([
			'userid' => $sesion['userData']->id
		]);
		return $mysql->get();
	}

	public function insert($data)
	{
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->insert($data);
	}

	public function login($username, $password)
	{
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'username' => $username,
			'password' => md5($password)
		]);

		$result = $mysql->first();
		if($result){
			return $result;
		}

		return null;
	}

	public function logout()
	{
        $sql = new QueryBuilder();
        $sql->table($this->table);
        $result = $sql->update([
            'created_at' => date('d-m-y H:m:s')
        ], [
            'id' => $sesion['userData']->id
        ]);		
	}

}
