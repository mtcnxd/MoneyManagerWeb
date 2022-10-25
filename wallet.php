<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$startDate = date('Y-m-01'); 
$endDate   = date('Y-m-t');
$wallet = new myWallet();

if($_POST){
	$wallet->insert('wallet_movements', [
		'type'        => $_POST['type'],
		'category'    => $_POST['category'],
		'description' => $_POST['description'],
		'date'        => date('Y-m-d'),
		'amount'      => $_POST['amount'],
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
					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Agregar movimiento</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body">
							<form action="wallet.php" method="post">
								<div class="mb-3">
							    	<label for="" class="form-label">Tipo</label>
							    	<select class="form-select" name="type" id="type" onchange="loadCategories(this.value);">
							    		<option value="">Seleccionar tipo</option>
								  		<option value="Ingreso">Ingreso</option>
								  		<option value="Egreso">Egreso</option>
									</select>
							  	</div>
								<div class="mb-3">
							    	<label for="" class="form-label">Categoria</label>
							    	<select class="form-select" name="category" id="category">
								  		<?php
										$data = $wallet->selectCategory('Ingreso');
										foreach ($data as $value) {
											echo "<option value=".$value->category.">".$value->category."</option>";
										}
										?>
									</select>
								</div>
								<div class="mb-3">
							    	<label for="" class="form-label">Descripcion</label>
							    	<input type="text" class="form-control" name="description" id="description">
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
				</div>	<!-- Col -->

				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
								<li class="nav-item">
							    	<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Egresos</button>
							  	</li>
							  	<li class="nav-item">
							    	<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Ingresos</button>
							  	</li>
							</ul>
						</div>
						<div class="card-body">
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
									<p class="fs-7 fw-bolder text-uppercase text-muted">
										Listado de egresos del mes
									</p>
									<table class="table">
										<tr>
											<td>#</td>
											<td>Concepto</td>
											<td>Fecha</td>
											<td class="text-end">Importe</td>
										</tr>
										<?php  
										$data = $wallet->getCashFlow('Egreso', $startDate, $endDate);

										foreach ($data as $row => $value) {
											echo "<tr>";
											echo "	<td>".($row + 1)."</td>";
											echo "	<td>".$value->description."</td>";
											echo "	<td>".$value->date."</td>";
											echo "	<td class='text-end'>$".number_format($value->amount,2)."</td>";
											echo "</tr>";
										}										
										?>										
									</table>
								</div>
							  	<div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
								  	<p class="fs-7 fw-bolder text-uppercase text-muted">
										Listado de ingresos del mes
									</p>
							  		<table class="table">
										<tr>
											<td>#</td>
											<td>Descripcion</td>
											<td>Fecha</td>
											<td class="text-end">Importe</td>
										</tr>
										<?php  
										$data = $wallet->getCashFlow('Ingreso', $startDate, $endDate);

										foreach ($data as $row => $value) {
											echo "<tr>";
											echo "	<td>".($row + 1)."</td>";
											echo "	<td>".$value->description."</td>";
											echo "	<td>".$value->date."</td>";
											echo "	<td class='text-end'>$".number_format($value->amount,2)."</td>";
											echo "</tr>";
										}										
										?>
									</table>
							  	</div>
							</div>
						</div>
					</div> <!-- Card -->

				</div>	<!-- Col -->

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
<script src="js/functions.js">
</script>