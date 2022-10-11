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
			<div class="col-md-12 shadow-sm mb-4 bg-white">
				<div class="card border-custom">
					<div class="card-header">
						<h6 class="card-header-title">Movimientos del mes</h6>
						<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
					</div>				
					
					<div class="table-responsive">
						<table class="table table-borderless table-hover fs-6">
							<thead>
								<tr class="table-custom text-uppercase fs-7">
									<th scope="col">#</td>
									<th scope="col">Nombre</td>
									<th scope="col">Categoria</td>
									<th scope="col">Descripcion</td>
									<th scope="col" class='text-end'>Cantidad</td>
									<th scope="col" class='text-end'>Fecha</td>
								</tr>
							</thead>
							<?php
							$fixedPayments = $wallet->selectThisMonth($startDate, $endDate);

							foreach ($fixedPayments as $key => $value) {
								$datef = new DateTime($value->date);
								
								if ($value->type == 'Ingreso'){
									echo "<tr class='table-success'>";
								} else {
									echo "<tr>";
								}
								echo "	<td>". ($key+1) ."</td>";
								echo "	<td>". $value->type ."</td>";
								echo "	<td>". $value->category ."</td>";
								echo "	<td>". $value->description ."</td>";
								echo "	<td class='text-end'> $". number_format($value->amount, 2)."</td>";
								echo "	<td class='text-end'>". $datef->format('d-m-Y') ."</td>";
								echo "</tr>";
							}						

							?>
						</table>
					</div>		<!-- Table-responsive -->
				</div>		<!-- Card -->
			</div>		<!-- Col-12 -->
			
			<div class="row mb-4">
				<div class="col">
					<div class="col-md-12">
						<div class="card rounded border border-custom shadow-sm">
							<div class="card-header">
								<h6 class="card-header-title">Ingresos</h6>
								<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
							</div>
							<div class="card-body">
								<?php
								$ingresos = $wallet->getTotalThisMonth('Ingreso', $startDate, $endDate);
								echo '$'. number_format($ingresos->amount, 2);
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="col">
					<div class="col-md-12">
						<div class="card rounded border border-custom shadow-sm">
							<div class="card-header">
								<h6 class="card-header-title">Egresos</h6>
								<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
							</div>
							<div class="card-body">
								<?php
								$egresos = $wallet->getTotalThisMonth('Egreso',$startDate, $endDate);
								echo '$'. number_format($egresos->amount, 2);
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="col">
					<div class="col-md-12">
						<div class="card rounded border border-custom shadow-sm">
							<div class="card-header">
								<h6 class="card-header-title">Inversiones</h6>
								<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
							</div>
							<div class="card-body">
								<?php
								$invest = $wallet->getTotalInvest();
								echo '$'. number_format($invest, 2);
								?>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="row mb-4">
				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<div class="align-items-center row">
								<div class="col">
									<h6 class="card-title text-muted text-uppercase fs-7">
										Egresos vs Ingresos
									</h6>
									<h5 class="card-subtitle mb-2 fs-6">
										<?php
										if ($ingresos->amount > 0){
											$versus = ($egresos->amount/$ingresos->amount) *100;
										} else {
											$versus = 0.0;
										}
										echo number_format($versus, 2) .'%';
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
				
				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<div class="align-items-center row">
								<div class="col">
									<h6 class="card-title text-muted text-uppercase fs-7">
										Total Egresos
									</h6>
									<h5 class="card-subtitle mb-2 fs-6">
										<?php
										echo '$'. number_format(100, 2);
										?>
									</h5>
								</div>
								<div class="col-auto">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d60f0f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
								</div>							    	
							</div>
						</div>													
					</div>
				</div>	<!-- Col-6 -->

				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<div class="align-items-center row">
								<div class="col">
									<h6 class="card-title text-muted text-uppercase fs-7">
										Ingresos vs Egresos
									</h6>
									<h5 class="card-subtitle mb-2 fs-6">
										<?php 
										echo '$'. number_format(100, 2);
										?>
									</h5>
								</div>
								<div class="col-auto">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d60f0f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-down"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline><polyline points="17 18 23 18 23 12"></polyline></svg>
								</div>							    	
							</div>
						</div>													
					</div>
				</div>	<!-- Col-6 -->				

			</div>	<!-- Row -->
		</div> 	<!-- Container -->	
		
	</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
