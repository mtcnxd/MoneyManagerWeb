<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

session_start();
$wallet = new myWallet();
$balance_array = $wallet->getWalletBalances(); 
$ticker = $wallet->getFullTicker();

if($_POST){
	$wallet->insert('wallet_saving', [
		'concept' => $_POST['concept'],
		'amount'  => $_POST['amount'],
	]);
}
?>

<html>
	<head>
		<title>My Wallet</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">		
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" 
				rel="stylesheet" 
				integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" 
				crossorigin="anonymous">
		<link href="css/custom.css" rel="stylesheet"/>				
				
		<!-- JavaScript Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" 
				integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" 
				crossorigin="anonymous">
		</script>		
	</head>

	<body>
		<header class="p-3 mb-3 border-bottom border-custom bg-custom-menu shadow-sm">
			<div class="container">
				<?php include ('includes/main_menu.php'); ?>
			</div>
		</header>		
		
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Balances</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body p-0">
							<table class="table table-hover">
								<thead>
									<tr class="table-custom text-uppercase fs-7">
										<th>#</th>
										<th>Moneda</th>
										<th class="text-end">Cantidad</th>
										<th class="text-end">Valor</th>
									</tr>
								</thead>
							<?php
							$totalBalance = 0;
							$chartData = array();
							foreach ($balance_array as $row => $balance){
								$chartData[$balance['currency']] = $balance['value'];
								$totalBalance += $balance['value'];

								echo "<tr>";
								echo "	<td> ". ($row + 1) ."</td>";
								echo "	<td><div class='text-uppercase badge bg-success text-wrap'> ". $balance['currency'] ."</div></td>";
								echo "	<td class='text-end'> ". $balance['amount'] ."</td>";
								echo "	<td class='text-end'> $". number_format($balance['value'],2) ."</td>";
								echo "</tr>";
							}
							?>
							</table>
						</div>	
					</div>
				</div>

				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Distribucion</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>
						<div class="card-body p-0">
							<canvas class="p-3" id="myChart" width="250" height="100"></canvas>
						</div>	
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col">
					<div class="col-md-5">
						<div class="card border-custom shadow-sm">
							<div class="card-body">
								<div class="align-items-center row">
									<div class="col">
										<h6 class="card-title text-muted text-uppercase fs-7">
											Balance total
										</h6>
										<h5 class="card-subtitle mb-2 fs-6">
										<?php
										echo '$'. number_format($totalBalance, 2);
										?>
										</h5>
									</div>
									<div class="col-auto">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#32a852" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col">
					<table class="table table-hover">
						<thead>
							<tr>
								<th scope="col">Paridad</th scope="col">
								<th scope="col" class="text-end">Precio Compra</th scope="col">
								<th scope="col" class="text-end">Porcentaje G/P</th scope="col">
							</tr>
						</thead>
						<tbody>
							<?php
							$ShoppingList = array(57000, 56840, 53240);
							$crypto_price = $ticker['btc_usdt']['last'];

							foreach ($ShoppingList as $price) {
								$diff = $crypto_price - $price;
								$percentage = $diff/$crypto_price * 100;

								echo "<tr>";
								echo "<td>BTC_USDT</td>";
								echo "<td class='text-end'>". '$'.number_format($price,2) ."</td>";
								echo "<td class='text-end'>";
								if ($percentage < 0) {
									echo "<span class='badge bg-danger'>". number_format($percentage, 2).'%' ."</span>";
								} else {
									echo "<span class='badge bg-success'>". number_format($percentage, 2).'%' ."</span>";
								}
								echo "</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
const distributionChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['<?=implode("','", array_keys($chartData));?>'],
        datasets: [{
            label: 'Wallet Balance',
            data: [<?=implode(",", array_values($chartData));?>],
            backgroundColor: [
                'rgba(235, 52, 95, 0.7)',
                'rgba(129, 247, 166, 0.7)',
                'rgba(252, 232, 96, 0.7)',
                'rgba(235, 52, 192, 0.7)',
                'rgba(78, 189, 245, 0.7)',
                'rgba(59, 176, 40, 0.7)',
                'rgba(52, 235, 122, 0.7)'
            ],
            borderColor: [
                'rgba(235, 52, 95, 1)',
                'rgba(129, 247, 166, 1)',
                'rgba(252, 232, 96, 1)',
                'rgba(235, 52, 192, 1)',
                'rgba(78, 189, 245, 1)',
                'rgba(59, 176, 40, 1)',
                'rgba(52, 235, 122, 1)'
            ],
            borderWidth: 1,
            hoverOffset: 5
       }]
    },
    options: {
		responsive: true,
    	plugins: {
      	legend: {
        	position: 'none',
        	align:'center',
        	labels:{
        		padding:25,
        		boxWidth: 18,
        		boxHeight: 17
        	}
      	}
      }
    }
});
</script>