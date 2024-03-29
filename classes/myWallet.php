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
			if ($value->total < 0.0002){
				continue;
			}

			if ($value->currency == 'mxn'){
				$balanceValue[] = [
					'currency' => $value->currency,
					'amount'   => $value->total,
					'value'    => $value->total,
				];
			}
			
			$book = $value->currency.'_mxn';
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
		return $balanceValue;
	}

	public function dataChartReport()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT b.color, CONCAT(b.color,'44') as border, b.category, a.amount 
			FROM wallet_cron_balances a
			JOIN wallet_categories b ON a.category_id = b.id
			WHERE date = CURRENT_DATE - INTERVAL 1 DAY;";
			
		return $mysql->get($query);
	}

	public function dataChart()
	{
		$mysql  = new QueryBuilder();
		$query  = "SELECT date, sum(amount) AS amount FROM wallet_cron_balances 
			WHERE category_id NOT IN (8, 22) AND date >= CURRENT_DATE - INTERVAL 1 MONTH 
			GROUP BY date DESC;";

		return $mysql->get($query);
	}	

	public function getMonthlyReturn()
	{
		$mysql = new QueryBuilder();
		$query = "SELECT SUM(amount) amount FROM wallet_cron_balances WHERE date = '".date('Y-m-01')."'";
		$lastAmount = $mysql->first($query);

		$query = "SELECT SUM(amount) amount FROM wallet_cron_balances WHERE date = CURRENT_DATE";
		$currentAmount = $mysql->first($query);

		return ($currentAmount->amount - $lastAmount->amount);
	}

	public function getCriptoInvest(){
		$mysql = new QueryBuilder();
		$result = $mysql->get("SELECT * FROM wallet_crypto WHERE status = TRUE ");
		return $result;
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
			WHERE category_id NOT IN (8, 22) AND date = CURRENT_DATE - INTERVAL 1 MONTH;";
		
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
