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

	static function getAmountLastMonth()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT SUM(amount) amount FROM wallet_cron_balances 
			WHERE concept NOT IN ('Bitso','BingX') AND date = CURRENT_DATE - INTERVAL 1 MONTH";
        $result = $mysql->get($query);
        return $result[0]->amount;
	}

	public function selectCategory($type)
	{
		$query = new QueryBuilder();
        $query->table('wallet_category');
        $query->where(['type' => $type]);
		$query->order('category');
        return $query->get();
	}

	public function selectTable($table = 'wallet_saving', $where = null)
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT * FROM $table";
		if ($where){
			$query .= " WHERE id = $where";
		}
		var_dump($query);

		return $mysql->get($query);
	}

	public function selectMovementsRange($start, $end)
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT * FROM wallet_saving WHERE date BETWEEN '$start' AND '$end' ORDER BY date ASC";
		$result = $mysql->get($query);
		return $result;
	}

	public function dataChart()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT date, sum(amount) AS amount FROM wallet_cron_balances 
			WHERE concept NOT IN ('Bitso','BingX') GROUP BY date DESC LIMIT 30";
		return $mysql->get($query);
	}

	public function insert($table, $data)
	{
		$query = new QueryBuilder();
		$query->table($table);
		$query->insert($data);
		$query->execute();
	}

	public function selectThisMonth($startDate, $endDate)
	{
        $query = new QueryBuilder();
		$sql = "SELECT a.*, b.icon FROM wallet_movements a LEFT JOIN wallet_category b ON a.category = b.category 
			WHERE a.date BETWEEN '$startDate' AND '$endDate' ORDER BY a.date";
		return $query->get($sql);
	}

	public function getBalanceTotal($type = 'ingreso')
	{
		$query = new QueryBuilder();
        return $query->get("SELECT SUM(amount) AS total FROM wallet_movements WHERE type = '$type'");
	}

	public function getTotalThisMonth($type, $startDate, $endDate)
	{
		$query = new QueryBuilder();
		$sql = "SELECT SUM(amount) amount FROM wallet_movements WHERE type = '$type' 
			AND date BETWEEN '$startDate' AND '$endDate'";
        return $query->get($sql)[0];
	}

	public function getCashFlow($type, $startDate, $endDate)
	{
		$query = new QueryBuilder();
        $sql = "SELECT * FROM wallet_movements WHERE type = '$type' AND date BETWEEN '$startDate' AND '$endDate'";
        return $query->get($sql);
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
		$query  = "SELECT concept, amount FROM `wallet_cron_balances` WHERE date = CURRENT_DATE - INTERVAL 1 DAY";
		return $mysql->get($query);
	}

	public function getCurrentBalances()
	{
		$mysql = new QueryBuilder();
		$query = "SELECT * FROM wallet_invest WHERE date IN (SELECT MAX(date) max_date 
			FROM wallet_invest WHERE concept NOT IN ('Bitso','BingX','Rentas','Kubo') GROUP BY concept) 
			ORDER BY concept";

		return $mysql->get($query);
	}
	
	public function getFullInvest()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT SUM(amount) as total FROM wallet_invest 
			WHERE date IN (SELECT max(date) max_date FROM wallet_invest GROUP BY concept) 
			AND include = true ORDER BY concept";

		$result = $mysql->get($query);
		return $result[0]->total;
	}

	public function getMonthlyReturn()
	{
		$mysql = new QueryBuilder();
		$query = "SELECT SUM(amount) amount FROM `wallet_cron_balances` WHERE date = '".date('Y-m-01')."'";
		$lastAmount = $mysql->get($query)[0];
		
		$query = "SELECT SUM(amount) amount FROM `wallet_cron_balances` WHERE date = '".date('Y-m-d')."'";
		$currentAmount = $mysql->get($query)[0];
		
		return ($currentAmount->amount - $lastAmount->amount);
	}

	public function getExchangeRate($datePast)
	{
		$currentBalance = $this->getFullInvest();
		$lastBalance = self::getAmountLastMonth($datePast);
		$diff = $currentBalance - $lastBalance;
		return ($diff/$currentBalance) *100;
	}

}