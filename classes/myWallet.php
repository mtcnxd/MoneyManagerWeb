<?php

namespace classes;

use classes\QueryBuilder;

class myWallet 
{
	static function thisMonth()
	{
		$thisMonth = date('n');
		$months = ['enero', 'febrero', 'marzo', 'abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
		return $months[$thisMonth-1];
	}

	static function amountDiff($date)
	{
		$mysql  = new QueryBuilder();
		$query  = "select SUM(amount) amount from wallet_cron_balances where concept not in ('Bitso') and date = '$date'";
        $result = $mysql->get($query);
        return $result[0]->amount;
	}

	public function insert($table, $data)
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

	public function selectThisMonth($startDate, $endDate)
	{
        $query = new QueryBuilder();
		$sql = "select * from wallet_movements where date between '$startDate' and '$endDate'";
		return $query->get($sql);
	}

	public function getBalanceTotal($type = 'ingreso')
	{
		$query = new QueryBuilder();
        return $query->get("select SUM(amount) as total from wallet_movements where type = '$type'");
	}

	public function getTotalThisMonth($type, $startDate, $endDate)
	{
		$query = new QueryBuilder();
		$sql = "select SUM(amount) amount from wallet_movements where type = '$type' 
			and date between '$startDate' and '$endDate'";
        return $query->get($sql)[0];
	}

	public function getCashFlow($type, $startDate, $endDate)
	{
		$query = new QueryBuilder();
        $sql = "select * from wallet_movements where type = '$type' and date between '$startDate' and '$endDate'";
        return $query->get($sql);
	}	

	public function getTotalInvest()
	{
		$mysql  = new QueryBuilder();
		$query  = "select SUM(amount) as total from wallet_invest 
			where date in (select max(date) max_date from wallet_invest group by concept) 
			and include = true
			order by concept";

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
		$query  = "select * from wallet_invest where concept = '$concept' ORDER BY date DESC LIMIT 15";
		return $mysql->get($query);
	}

	public function dataChart()
	{
		$mysql  = new QueryBuilder();
		$query  = "select date, sum(amount) as amount from wallet_cron_balances 
			where concept not in ('Bitso') group by date desc limit 30";
		return $mysql->get($query);
	}

	public function dataChartReport($startDate)
	{
		$mysql  = new QueryBuilder();
		$query  = "select category, sum(amount) amount from wallet_movements 
			where type = 'Egreso' and date between '$startDate' and now() group by category";
		return $mysql->get($query);
	}	

	public function loadUserData($id)
	{
		$mysql  = new QueryBuilder();
		$query  = "select * from wallet_users where id = $id";
		return $mysql->get($query);
	}

}