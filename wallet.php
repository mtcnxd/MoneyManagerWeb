<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$wallet = new myWallet();

if($_POST){
	$wallet->insert('wallet_movements', [
		'type'     => $_POST['type'],
		'category' => $_POST['category'],
		'concept'  => $_POST['concept'],
		'amount'   => $_POST['amount'],
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
										$data = $wallet->selectCategory('ingreso');

										foreach ($data as $key => $value) {
											echo "<option>".$value->category."</option>";
										}
										?>
									</select>
							  	</div>							  	
							  	<div class="mb-3">
							    	<label for="" class="form-label">Concepto</label>
							    	<input type="text" class="form-control" name="concept" id="concept">
							  	</div>
							  	<div class="mb-3">
							    	<label for="" class="form-label">Importe</label>
							    	<input type="text" class="form-control" name="amount" id="amount">
							  	</div>

							  <button type="submit" class="btn btn-primary">Guardar</button>
							</form>	
						</div>	
					</div> 	<!-- Card -->
				</div>	<!-- Col -->

				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<ul class="nav nav-tabs card-header-tabs">
								<li class="nav-item">
									<a class="nav-link active" aria-current="true" href="#">Egresos</a>
								</li>
								<li class="nav-item">
									<a class="nav-link">Ingresos</a>
								</li>
							</ul>
						</div>
						<div class="card-body">
							<h6 class="card-title">Lista de movimientos del dia</h6>
							<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
							<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
								<button type="button" class="btn btn-outline-secondary hstack gap-2">
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
									Notificaciones
								</button>
								<button type="button" class="btn btn-outline-secondary hstack gap-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
									Agregar nuevo
								</button>
							</div>
						</div>
					</div> <!-- Card -->

					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Movimientos del dia</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body">
							<table class="table table-hover">
								<?php
								$start = date('Y-m-d 00:00:00');
								$end   = date('Y-m-d 23:59:59');
								$data  = $wallet->selectMovementsRange($start, $end);

								foreach ($data as $key => $value) {
									echo "<tr>";
									echo "	<td>".$value->name."</td>";
									echo "	<td>".$value->concept."</td>";
									echo "	<td class='text-end'> $". number_format($value->amount, 2)."</td>";
									echo "</tr>";
								}
								?>
								<small class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-success bg-success bg-opacity-10 border border-success border-opacity-10 rounded-2">Added in v5.2.0</small>
							</table>
						</div>	
					</div> 	<!-- Card -->
					
					<div class="alert alert-warning alert-custom" role="alert">
						<h6>Titulo del alert</h6>
						A simple warning alert—check it out!
					</div>

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