<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$wallet = new myWallet();

if($_POST){
	$values = [
		'concept' => "'".$_POST['concept']."'",
		'amount'  => "'".$_POST['amount']."'",
	];

	$wallet->insertData('wallet_invest', $values);
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
		<header class="p-3 mb-3 border-bottom border-custom bg-white shadow-sm">
			<div class="container">
		    	<div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
			        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
			        	<li><a href="index.php" class="nav-link px-3 link-dark">Balance</a></li>
			        	<li><a href="wallet.php" class="nav-link px-3 link-dark">Cartera</a></li>
						<li><a href="saving.php" class="nav-link px-3 link-dark">Ahorros</a></li>
						<li><a href="invest.php" class="nav-link px-3 link-dark">Inversiones</a></li>			        	
			          	<li><a href="categories.php" class="nav-link px-3 link-dark">Categorias</a></li>
			          	<li><a href="profile.php" class="nav-link px-3 link-dark">Profile</a></li>
			        </ul>
		      	</div>
			</div>
		</header>		
		
		<div class="container">

			<div class="row mb-4">
				<div class="col-md-5">
					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Saldo al dia de hoy</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body">
							<form action="invest.php" method="post">
							  	<div class="mb-3">
							    	<label for="" class="form-label">Concepto</label>
							    	<select type="text" class="form-control" name="concept">
									<?php
										$data = $wallet->selectCategory('inversion');

										foreach ($data as $key => $value) {
											echo "<option>".$value->name."</option>";
										}
										?>
									</select>
							  	</div>								
							  	<div class="mb-3">
							    	<label for="" class="form-label">Cantidad</label>
							    	<input type="text" class="form-control" name="amount">
							  	</div>

							  <button type="submit" class="btn btn-primary">Guardar</button>
							</form>	
						</div>	
					</div> 	<!-- Card -->
				</div>	<!-- Col -->

				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Inversiones</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
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
								$count = 0;
								$balance = 0;
								$data = $wallet->loadCurrentInvestments();

								foreach ($data as $key => $value) {
									$balance += $value;
								}
								
								foreach ($data as $key => $value) {
									$count++;
									$percentage = ($value/$balance) * 100;
									
									echo "<tr>";
									echo "	<td>".$count."</td>";
									echo "	<td><a href='details.php?q=$key' class='table-link-item link-primary'>".$key."</a></td>";
									echo "	<td class='text-end'>  ". number_format($percentage, 2)."%</td>";
									echo "	<td class='text-end'> $". number_format($value, 2)."</td>";
									echo "</tr>";
								}								
								?>
							</table>
						</div>	
					</div> 	<!-- Card -->
						
					<div class="row">
						<div class="col-md-6">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">
												Total invertido
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">
												<?php
												echo '$'. number_format($balance, 2);
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
												Total ahorros
											</h6>
											<h5 class="card-subtitle mb-2 fs-6">
												<?php
												echo '$'. number_format($wallet->getBalanceFrom('wallet_saving'), 2);
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
