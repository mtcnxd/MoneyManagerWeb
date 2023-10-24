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

	public function dataChart()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT date, sum(amount) AS amount 
			FROM wallet_cron_balances 
			WHERE concept NOT IN ('Bitso','BingX') AND date >= CURRENT_DATE - INTERVAL 1 MONTH 
			GROUP BY date DESC";

		return $mysql->get($query);
	}

	public function dataChartReport()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT concept, amount FROM `wallet_cron_balances` WHERE date = CURRENT_DATE - INTERVAL 1 DAY";
		return $mysql->get($query);
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

	// Pendiente por borrar
	public function getFullInvest()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT SUM(amount) as total FROM wallet_invest WHERE date IN (
				SELECT max(date) max_date FROM wallet_invest GROUP BY category_id) 
			AND include = true";

		$result = $mysql->get($query);
		return $result[0]->total;
	}	

	static function getAmountLastMonth()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT SUM(amount) amount FROM wallet_cron_balances 
			WHERE concept NOT IN ('Bitso','BingX') AND date = CURRENT_DATE - INTERVAL 1 MONTH";
        $result = $mysql->get($query);
        return $result[0]->amount;
	}	

	public function getExchangeRate($datePast)
	{
		$currentBalance = $this->getFullInvest();
		$lastBalance 	= self::getAmountLastMonth($datePast);
		$diff = $currentBalance - $lastBalance;
		return ($diff/$currentBalance) *100;
	}
}