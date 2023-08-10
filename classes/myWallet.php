<?php

namespace classes;
require_once('Bitso.php');

use classes\QueryBuilder;
use classes\Bitso;

class myWallet extends Bitso
{
	protected $bitsoKey;
	protected $bitsoSecret;

	public function __construct($user = null)
	{

		$this->bitsoKey 	= 'TMJEPCYmIv';
		$this->bitsoSecret  = 'd181cda5b0f939ee1b42e7b45ebd93e5';
	}

	public function getWalletBalances()
	{
		$balances = $this->getBalance();
		$ticker   = $this->getTicker();

		$balanceValue = array();
		foreach ($balances as $value) {

			$book = $value->currency.'_mxn';

			if ($value->currency == 'mxn'){
				$balanceValue[] = [
					'currency' => $value->currency,
					'amount'   => $value->total,
					'value'    => $value->total,
				];
			} else if ($value->total > 0.0002){
				if( array_key_exists($book, $ticker) ){
					$balanceValue[] = [
						'currency' => $value->currency,
						'amount'   => $value->total,
						'value'    => $value->total * $ticker[$book],
					];
				} else {
					$book = $value->currency.'_usd';
					if (array_key_exists($book, $ticker)){
						$balanceValue[] = [
							'currency' => $value->currency,
							'amount'   => $value->total,
							'value'    => $value->total * $ticker[$book] * $ticker['usd_mxn'],
						];
					}
				}
			}
		}

		return $balanceValue;

	}

	static function thisMonth()
	{
		$thisMonth = date('n');
		$months = ['enero', 'febrero', 'marzo', 'abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
		return $months[$thisMonth-1];
	}

	static function amountDiff($date)
	{
		$mysql  = new QueryBuilder();
		$query  = "select SUM(amount) amount from wallet_cron_balances 
			where concept not in ('Bitso','BingX') and date = '$date'";
        $result = $mysql->get($query);
        return $result[0]->amount;
	}

	public function dataChart()
	{
		$mysql  = new QueryBuilder();
		$query  = "select date, sum(amount) as amount from wallet_cron_balances 
			where concept not in ('Bitso','BingX') group by date desc limit 30";
		return $mysql->get($query);
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
		$query->order('category');
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
		$sql = "select a.*, b.icon from wallet_movements a left join wallet_category b on a.category = b.category 
			where a.date between '$startDate' and '$endDate' order by a.date";
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
			and include = true order by concept";

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
			from wallet_invest where concept not in ('Bitso','BingX','Rentas','Kubo') group by concept) order by concept";

		return $mysql->get($query);
	}

	public function loadListbyItem($concept)
	{
		$mysql  = new QueryBuilder();
		$query  = "select * from wallet_invest where concept = '$concept' ORDER BY date DESC LIMIT 15";
		return $mysql->get($query);
	}

	public function dataChartReport()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT concept, amount FROM `wallet_cron_balances` WHERE date = '".date('Y-m-d')."'";
		return $mysql->get($query);
	}	

	public function loadUserData($id)
	{
		$mysql  = new QueryBuilder();
		$query  = "select * from wallet_users where id = $id";
		return $mysql->get($query);
	}	

	public function getMonthlyReturn()
	{
		$mysql = new QueryBuilder();
		$query = "select SUM(amount) amount from `wallet_cron_balances` where date = '".date('Y-m-01')."'";
		$lastAmount = $mysql->get($query)[0];
		
		$query = "select SUM(amount) amount from `wallet_cron_balances` where date = '".date('Y-m-d')."'";
		$currentAmount = $mysql->get($query)[0];
		
		return ($currentAmount->amount - $lastAmount->amount);
	}

	public function getExchangeRate($datePast)
	{
		$currentBalance = 0.0;
		$results = $this->loadCurrentInvestments();
		foreach ($results as $value){
			$currentBalance += $value->amount;
		}
		
		$lastBalance = self::amountDiff($datePast);
		$diff = $currentBalance - $lastBalance;
		return ($diff/$currentBalance) *100;
	}

}