<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$wallet = new myWallet();

if($_POST){
	$values = [
		'type'     => "'".$_POST['type']."'",
		'category' => "'".$_POST['category']."'",
		'concept'  => "'".$_POST['concept']."'",
		'amount'   => "'".$_POST['amount']."'",
	];

	$wallet->insertData('wallet_movements', $values);
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
								  		<option value="ingreso">Ingreso</option>
								  		<option value="egreso">Egreso</option>
									</select>
							  	</div>
								<div class="mb-3">
							    	<label for="" class="form-label">Categoria</label>
							    	<select class="form-select" name="category" id="category">
								  		<?php
										$data = $wallet->selectCategory('ingreso');

										foreach ($data as $key => $value) {
											echo "<option>".$value->name."</option>";
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
							</table>
						</div>	
					</div> 	<!-- Card -->

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