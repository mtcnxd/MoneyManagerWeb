<?php
namespace classes;

class users
{
	protected $table  = "wallet_users";
	protected $userid = 0;

	public function __construct($userid)
	{
		$this->userid = $userid;
	}

	public function find()
	{
		$mysql = new QueryBuilder();
		$mysql->table($this->table);
		$mysql->where([
			'id' => $this->userid
		]);
		return $mysql->first();
	}

	public function loadConfiguration()
	{
		$mysql = new QueryBuilder();
		$mysql->table('wallet_configuration');
		$mysql->where([
			'userid' => $this->userid
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

}
