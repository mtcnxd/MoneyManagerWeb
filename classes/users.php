<?php
namespace classes;

class users 
{
	protected $table = "wallet_users";

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
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->insert($data);
	}

	public function login($username, $password) : bool
	{
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'username' => $username,
			'password' => $password
		]);
		
		//var_dump($mysql->first());

		if ($mysql->first()){
			return true;
		}
		return false;
	}

}
