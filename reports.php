<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$startDate = date('Y-m-01'); 
$endDate   = date('Y-m-t');
$wallet = new myWallet();
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
				<div class="col-md-3">
					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Menu reportes</h6>
                            <svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
						</div>

                        <div class="list-group p-1">
                            <a href="#" class="list-group-item list-group-item-action active">Categorias</a>
                            <a href="#" class="list-group-item list-group-item-action">Mes anterior</a>
                            <a href="#" class="list-group-item list-group-item-action">Historico</a>
                        </div>
					</div>	
				</div>	<!-- Col -->

				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-3">
						<div class="card-header">
							<h6 class="card-header-title">Grafico</h6>
                            <svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
						</div>

						<div class="p-4">
                            <?php
							$chartData = $wallet->dataChartReport();

							foreach ($chartData as $key => $value) {
		 						$labels[] = $value->concept;
		 						$values[] = $value->amount;
							}
                            ?>                        
                            <canvas class="p-3" id="currentChart" width="250" height="100"></canvas>
						</div>
					</div>	<!-- Card -->

					<div class="row">
						<div class="col-md-3">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">
												Ganancia mes en curso
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">							
											<?php
											echo "$".number_format($wallet->getMonthlyReturn(), 2);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">
												Tasa Promedio Ponderada
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">							
											<?php
											$datePast = strtotime('-22 day', strtotime(date('Y-m-d')));
											$datePast = date('Y-m-d', $datePast);									
											echo number_format($wallet->getExchangeRate($datePast),2) ."%";
											?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">
												Capital invertido
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">							
											<?php
											$capital = 0;
											$data = $wallet->getCurrentBalances();
											foreach ($data as $value) {
												$capital += $value->amount;
											}

											echo "$ ". number_format($capital ,2);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">
												Retorno aprox. seis meses
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">							
											<?php
											$exchangeRate = $wallet->getExchangeRate($datePast)/100;
											echo number_format($capital * pow((1 + $exchangeRate),12), 2);
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>	<!-- Col -->

			</div>	<!-- row -->

		</div>	<!-- Container -->
		
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		        crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
        <script>
        const currentChart = document.getElementById('currentChart').getContext('2d');
        const myChart = new Chart(currentChart, {
            type: 'bar',
            data: {
                labels: <?=json_encode( $labels );?>,
                datasets: [{
                    label: 'Wallet Balance',
                    data: <?=json_encode( $values );?>,
                    borderColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 205, 86, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(201, 203, 207, 0.7)'                
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.4)',
                        'rgba(255, 159, 64, 0.4)',
                        'rgba(75, 192, 192, 0.4)',
                        'rgba(255, 205, 86, 0.4)',
                        'rgba(54, 162, 235, 0.4)',
                        'rgba(153, 102, 255, 0.4)',
                        'rgba(201, 203, 207, 0.4)'
                    ],
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

