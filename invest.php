<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$wallet = new myWallet();

if($_POST){
	$wallet->insert('wallet_invest', [
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
				<div class="col-md-5">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Ingresar saldo de cuenta</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body">
							<form action="invest.php" method="post">
							  	<div class="mb-3">
							    	<label for="" class="form-label">Concepto</label>
							    	<select type="text" class="form-select" name="concept">
										<?php
										$data = $wallet->selectCategory('inversion');
										foreach ($data as $key => $value) {
											echo "<option>".$value->category."</option>";
										}
										?>
									</select>
							  	</div>								
							  	<div class="mb-3">
							    	<label for="" class="form-label">Importe</label>
									<div class="input-group">
										<div class="input-group-text">$</div>
										<input type="text" class="form-control" name="amount" placeholder="0.00">
									</div>
							  	</div>

							  <button type="submit" class="btn btn-primary">Guardar</button>
							</form>	
						</div>	
					</div> 	<!-- Card -->

					<p class="fs-7 fw-bolder text-uppercase text-muted">
						Indicadores de rendimiento basado en los ultimos 30 dias
					</p>

					<div class="row mb-4">
						<div class="col-md-6">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">
												Inversion total
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											$currentBalance = 0;
											$data = $wallet->loadCurrentInvestments();
											foreach ($data as $value) {
												$currentBalance += $value->amount;
											}
											echo '$'. number_format($currentBalance, 2);
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
											<h6 class="card-title text-muted text-uppercase fs-7">Incremento</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											$datePast = strtotime('-30 day', strtotime(date('Y-m-d')));
											$datePast = date('Y-m-d', $datePast);
											$lastBalance = myWallet::amountDiff($datePast);
											$diff = $currentBalance - $lastBalance;

											echo '$'. number_format($diff, 2);
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
					</div> <!-- row -->

					<div class="row mb-4">
						<div class="col-md-6">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">Incremento</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											$percentage = $wallet->getExchangeRate($datePast);
											echo number_format($percentage, 2) ."%";
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

				</div>	<!-- Col -->

				<div class="col">
					<div class="card border-custom shadow-sm mb-4">
						<div class="card-body">
							<p class="fs-7 fw-bolder text-uppercase text-muted">Grafica Rendimiento</p>
							<?php
							$chartData = $wallet->dataChart();
							foreach ($chartData as $key => $value) {
		 						$labels[] = $value->date;
		 						$values[] = $value->amount;
							}
							?>
							<canvas class="p-3" id="currentChart" width="250" height="100"></canvas>
						</div>
					</div>	

					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Saldos de inversiones</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
						</div>				
						<div class="card-body p-0">
							<table class="table table-hover">
								<thead>
									<tr class="table-custom text-uppercase fs-7">
										<th scope="col">#</td>
										<th scope="col">Intrumento</td>
										<th scope="col" class="text-end">Porcentaje</td>
										<th scope="col" class="text-end">Saldo</td>
									</tr>
								</thead>								
								<?php
								foreach ($data as $row => $value) {
									$percentage = ($value->amount/$currentBalance) * 100;
									
									echo "<tr>";
									echo "	<td>".($row +1)."</td>";
									echo "	<td><a href='details.php?q=".$value->concept."' class='table-link-item link-primary'>".$value->concept."</a></td>";
									echo "	<td class='text-end'>  ". number_format($percentage, 2)."%</td>";
									echo "	<td class='text-end'> $". number_format($value->amount, 2)."</td>";
									echo "</tr>";
								}								
								?>
							</table>

							<div class="container px-4 text-center mb-3">
								<div class="row gx-5">
									<div class="col-md-4">
										<button type="button" id="updateTable" class="btn btn-sm btn-outline-success">Actualizar Inversion</button>
									</div>
								</div>
							</div>

						</div>	
					</div> 	<!-- Card -->

				</div> <!-- Col -->

			</div>	<!-- Row -->

		</div> 	<!-- Container -->
		
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		        crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
        <script>
        $("#updateTable").on('click', function(){
	        $.ajax ({
		        url: 'background/ajax_request.php',
		        method: 'post',
		        success: function(response){
			        console.log('Response:' + response)
		        }
	        })
        })
        </script>
        <script>
        const currentChart = document.getElementById('currentChart').getContext('2d');
        const myChart = new Chart(currentChart, {
            type: 'line',
            data: {
                labels: <?=json_encode( $labels );?>,
                datasets: [{
                    label: 'Wallet Balance',
                    data: <?=json_encode( $values );?>,
                    borderColor: 'rgba(0, 153, 204, 1)',
                    backgroundColor: 'rgba(0, 172, 230, 0.2)',
                    borderWidth:1,
                    pointRadius:2,
                    hoverOffset:5,
                    fill: true
               }]
            },
            options: {
		        responsive: true,
            	plugins: {
	              	legend: {
	                	position:'none',
	                	align:'center',
	                	labels:{
	                		padding:25,
	                		boxWidth:18,
	                		boxHeight:17
	                	}
	              	}
              }
            }
        });
        </script>
        <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "i84qwphpao");
        </script>
	</body>
</html>

