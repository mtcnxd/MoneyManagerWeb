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

	public function selectCategory($type)
	{
		$query = new QueryBuilder();
        $query->table('wallet_category');
        $query->where([
			'type' 	  => $type,
		]);
		$query->order('category');
        return $query->get();
	}

	public function find($table = 'wallet_saving', $id = null)
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT * FROM $table";
		if ($id){
			$query .= " WHERE id = $id";
		}
		return $mysql->get($query);
	}

	public function insert($table, $data)
	{
		$query = new QueryBuilder();
		$query->table($table);
		$query->insert($data);
		$query->execute();
	}

	static function getAmountLastMonth()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT SUM(amount) amount FROM wallet_cron_balances 
			WHERE concept NOT IN ('Bitso','BingX') AND date = CURRENT_DATE - INTERVAL 1 MONTH";
        $result = $mysql->get($query);
        return $result[0]->amount;
	}

	public function dataChart()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT date, sum(amount) AS amount FROM wallet_cron_balances 
			WHERE concept NOT IN ('Bitso','BingX') AND date >= CURRENT_DATE - INTERVAL 1 MONTH 
			GROUP BY date DESC;";

		return $mysql->get($query);
	}

	public function selectMovementsRange($start, $end)
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT * FROM wallet_saving WHERE date BETWEEN '$start' AND '$end' ORDER BY date ASC";
		$result = $mysql->get($query);
		return $result;
	}

	public function selectThisMonth($startDate, $endDate)
	{
        $query = new QueryBuilder();
		$sql = "SELECT a.*, b.icon FROM wallet_movements a LEFT JOIN wallet_category b ON a.category = b.category 
			WHERE a.date BETWEEN '$startDate' AND '$endDate' ORDER BY a.date";
		return $query->get($sql);
	}

	public function getFlowByDates($type, $startDate, $endDate)
	{
		$query = new QueryBuilder();
        $sql = "SELECT * FROM wallet_movements WHERE type = '$type' AND date BETWEEN '$startDate' AND '$endDate'";
        return $query->get($sql);
	}	

	# Muestra los detalles de cada inversion
	public function loadListbyItem($concept)
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT * FROM wallet_invest WHERE concept = '$concept' AND date > NOW() - INTERVAL 1 MONTH ORDER BY date DESC";
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
			FROM wallet_invest WHERE concept NOT IN (
				SELECT category FROM wallet_category WHERE type = 'Inversion' AND visible = false
			) GROUP BY concept) 
			ORDER BY concept";

		return $mysql->get($query);
	}
	
	public function getFullInvest()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT SUM(amount) as total FROM wallet_invest WHERE date IN (
				SELECT max(date) max_date FROM wallet_invest GROUP BY concept) 
			AND include = true ORDER BY concept";

		$result = $mysql->get($query);
		return $result[0]->total;
	}

	public function getMonthlyReturn()
	{
		$mysql = new QueryBuilder();
		$query = "SELECT SUM(amount) amount FROM wallet_cron_balances WHERE date = '".date('Y-m-01')."'";
		$lastAmount = $mysql->get($query)[0];
		
		$query = "SELECT SUM(amount) amount FROM wallet_cron_balances WHERE date = CURRENT_DATE";
		$currentAmount = $mysql->get($query)[0];
		
		return ($currentAmount->amount - $lastAmount->amount);
	}

	public function getExchangeRate($datePast)
	{
		$currentBalance = $this->getFullInvest();
		$lastBalance 	= self::getAmountLastMonth($datePast);
		$diff = $currentBalance - $lastBalance;
		return ($diff/$currentBalance) *100;
	}

	public function getExpenses($date)
	{
		$mysql = new QueryBuilder();
		$query = "SELECT * FROM `wallet_movements` WHERE date = '$date'";
		return $mysql->get($query)[0];
	}

	public function loadInstruments()
	{
		$mysql = new QueryBuilder();
		$query = "SELECT * FROM `wallet_category` WHERE type = 'Inversion' ORDER BY category";
		return $mysql->get($query);
	}

}