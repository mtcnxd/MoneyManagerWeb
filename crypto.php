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
			<div class="row mb-4">
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
							<h6 class="card-header-title">Distribución</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>
						<div class="card-body p-0">
							<canvas class="p-3" id="myChart" width="250" height="100"></canvas>
						</div>	
					</div>

					<div class="row">
						<div class="col-md-6">
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
						<div class="col-md-6">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">
												Precio actual BTC/USDT
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											echo '$'. number_format($ticker['btc_usdt']['last'], 2);
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

				</div>
			</div>

			<div class="row">
				<h5>Shopping list
					<a href="#" style="padding-left: 3px;" data-bs-toggle="modal" data-bs-target="#addShopping">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle" style="margin-bottom: 2px;">
						<circle cx="12" cy="12" r="10"></circle>
						<line x1="12" y1="8" x2="12" y2="16"></line>
						<line x1="8" y1="12" x2="16" y2="12"></line></svg>
					</a>
				</h5>
				<hr>
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Paridad</th scope="col">
							<th scope="col">Cantidad</th>
							<th scope="col" class="text-end">Precio Compra</th>
							<th scope="col" class="text-end">Valor Compra</th>
							<th scope="col" class="text-end">Valor Actual</th>
							<th scope="col" class="text-end">G/P</th>
							<th scope="col" style="width: 30px;"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						
						$ShoppingList = $wallet->getCriptoInvest();

						var_dump($ShoppingList);

						foreach($ShoppingList as $currency){
							$crypto_price = $ticker[$currency->parity]['last'];
							$diff = $crypto_price - $currency->price;
							$percentage = $diff/$crypto_price * 100;

							$sumValorCompra = $sumValorCompra + ($currency->amount * $currency->price);
							$sumValorActual = $sumValorActual + ($currency->amount * $crypto_price);

							echo "<tr>";
							echo "<td>". $currency->parity ."</td>";
							echo "<td>". $currency->amount ."</td>";
							echo "<td class='text-end'>". '$'.number_format($currency->price, 2) ."</td>";
							echo "<td class='text-end'>". '$'.number_format($currency->amount * $currency->price, 2) ."</td>";
							echo "<td class='text-end'>". '$'.number_format($currency->amount * $crypto_price, 2) ."</td>";
							echo "<td class='text-end'>";
							if ($percentage < 0) {
								echo "<span class='badge bg-danger'>". number_format($percentage, 2).'%' ."</span>";
							} else {
								echo "<span class='badge bg-success'>". number_format($percentage, 2).'%' ."</span>";
							}
							echo '<td class="text-end">
									<a href="#" class="delete" id="'.$currency->id.'">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
									</a>
								  </td>';
							echo "</td>";
							echo "</tr>";
						}

						?>
					</tbody>
					<tfoot>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td class="text-end">
								<?php
								if (isset($sumValorCompra)){
									echo '$'.number_format($sumValorCompra, 2);
								}
								?>
							</td>
							<td class="text-end">
								<?php
								if (isset($sumValorActual)){
									echo '$'.number_format($sumValorActual, 2);
								}
								?>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

		<div class="modal fade" id="addShopping" tabindex="-1">
			<div class="modal-dialog">
		    	<div class="modal-content">
		      		<div class="modal-header">
		        		<h5 class="modal-title">Modal title</h5>
		        		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		      		</div>
			      	<div class="modal-body">
			        	<div class="row">
			        		<div class="col-md-12">
			        			<label class="mb-2">Paridad</label>
			        			<input type="text" id="parity" class="form-control">
			        		</div>
			        		<div class="col-md-12 mt-3">
			        			<label class="mb-2">Cantidad</label>
			        			<input type="text" id="amount" class="form-control">
			        		</div>
			        		<div class="col-md-12 mt-3">
			        			<label class="mb-2">Precio de compra</label>
			        			<input type="text" id="price" class="form-control">
			        		</div>
			        	</div>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			        	<button type="button" class="btn btn-primary" id="insertData">Save changes</button>
			      	</div>
		    	</div>
		  	</div>
		</div>
	</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

function showMessageAlert(message){
	Swal.fire({
	  text: message,
	  icon: "success"
	}).then(() => {
		location.reload();
	});
}

$("#insertData").on('click', function(){
	var parity = $("#parity").val();
	var amount = $("#amount").val();
	var price  = $("#price").val();

	$.ajax ({
		url: 'background/ajax_endpoint.php',
		method: 'POST',
		data: {
			action:'insertCriptyInvest',
			parity:parity,
			amount:amount,
			price:price,
		}, 
		success: function(result){
			const response = JSON.parse(result);
			showMessageAlert(response.message);
		}
	});
});

const buttonsArray = document.getElementsByClassName("delete");
$(buttonsArray).on('click', function(event){
	event.preventDefault();	

	$.ajax({
		url: 'background/ajax_endpoint.php',
		method: 'POST',
		data: {
			action:'deleteCriptyInvest',
			object:this.id
		},
		success: function(result){
			const response = JSON.parse(result);
			showMessageAlert(response.message);
		}
	});

});

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