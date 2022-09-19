<?php

namespace classes;

use classes\QueryBuilder;

class myWallet 
{
	public function insertData($table, $data)
	{
		$query = new QueryBuilder();
		$query->table($table);
		$query->insert($data);
		$query->execute();
	}

	public function selectCategory($type)
	{
		$query = new QueryBuilder();
        $query->table('wallet_category');
        $query->where(['type' => $type]);
        return $query->get();
	}

	public function selectMovementsRange($start, $end)
	{
		$mysql  = new QueryBuilder();
		$query  = "select * from `wallet_movements` a JOIN `wallet_category` b 
				   ON a.category = b.id WHERE date between '$start' and '$end'
				   ORDER by a.date ASC, a.type";
		$result = $mysql->get($query);
		return $result;
	}

	public function selectFixedPayments()
	{
        $query = new QueryBuilder();
        return $query->get("select * from `wallet_fixed_payments`");
	}

	public function getBalanceTotal($type = 'ingreso')
	{
		$query = new QueryBuilder();
        return $query->get("select SUM(amount) as total from wallet_movements where type = '$type'");
	}

	public function getBalanceFrom($from = 'wallet_saving')
	{
		$mysql  = new QueryBuilder();
		$query  = "select SUM(amount) as total from wallet_invest where date in (select max(date) max_date 
			from wallet_invest group by concept) order by concept";
		$result = $mysql->get($query);
		return $result[0]->total;
	}

	public function selectTable($table = 'wallet_saving')
	{
		$mysql  = new QueryBuilder();
		$query  = "select * from $table";		
		return $mysql->get($query);
	}

	public function loadCurrentInvestments()
	{
		$mysql = new QueryBuilder();
		$query = "select * from wallet_invest where date in (select max(date) max_date 
			from wallet_invest where concept not in ('Bitso') group by concept) order by concept";

		return $mysql->get($query);
	}

	public function loadListbyItem($concept)
	{
		$mysql  = new QueryBuilder();
		$query  = "select * from wallet_invest where concept = '$concept' ORDER BY date DESC LIMIT 7";
		return $mysql->get($query);
	}

	public function dataChart()
	{
		$mysql  = new QueryBuilder();
		$query  = "select date, sum(amount) as amount from wallet_cron_balances where concept not in ('Bitso') group by date";
		return $mysql->get($query);
	}

}