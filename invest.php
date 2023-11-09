<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;
use classes\categories;
use classes\investments;

session_start();
$wallet		= new myWallet();
$categories = new categories();
$investment = new investments();

if($_POST){
	$investment->insert([
		'category_id' => $_POST['category'],
		'amount'   	  => $_POST['amount'],
	]);
}
?>

<html>
	<head>
		<?php include ('includes/meta_head.php'); ?>
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
							    	<label class="form-label">Instrumento</label>
							    	<select type="text" class="form-select" name="category">
										<?php
										$list = $categories->load('inversion');
										foreach ($list as $category) {
											if ($category->visible == true){
												echo "<option value=".$category->id.">".$category->category."</option>";
											}
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
												Capital invertido
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											$currentBalance = $investment->getTotal();
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
											<h6 class="card-title text-muted text-uppercase fs-7">Incremento a 30 dias</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											$datePast = strtotime('-30 day', strtotime(date('Y-m-d')));
											$datePast = date('Y-m-d', $datePast);
											$lastBalance = myWallet::getAmountLastMonth();
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
											<h6 class="card-title text-muted text-uppercase fs-7">Incremento ponderado</h6>
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

					<div class="row">
						<canvas class="p-3" id="barChart" width="250" height="100"></canvas>
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
										<th scope="col" class="text-center">Ultimo cambio</td>
										<th scope="col" class="text-end">Porcentaje</td>
										<th scope="col" class="text-end">Saldo</td>
									</tr>
								</thead>								
								<?php
								$data = $investment->getCurrentBalances();
								foreach ($data as $row => $balance) {
									$percentage = ($balance->amount/$currentBalance) * 100;
									$parseDate = new dateTime($balance->date);
									
									echo "<tr>";
									echo "	<td>".($row +1)."</td>";
									echo "	<td><a href='details.php?q=".$balance->category_id."' class='table-link-item link-primary'>".$balance->category."</a></td>";
									echo "	<td class='text-center'>  ". $parseDate->format('d-m-Y') ."</td>";
									echo "	<td class='text-end'>  ". number_format($percentage, 2)."%</td>";
									echo "	<td class='text-end'> $". number_format($balance->amount, 2)."</td>";
									echo "</tr>";
								}								
								?>
							</table>

							<div class="container px-4 text-center mb-3">
								<div class="row gx-5">
									<div class="col-md-4">
										<button type="button" class="btn btn-sm btn-outline-success">Actualizar Inversion</button>
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
		        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
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
	                	position:'none'
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

