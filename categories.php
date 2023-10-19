<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;
use classes\categories;

$wallet = new myWallet();
$categories = new categories();

if($_POST){
	$categories->insert([
		'type'     => $_POST['type'],
		'category' => $_POST['category'],
		'color'    => $_POST['color'],
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
							<h6 class="card-header-title">Agregar Categoria</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body">
							<form action="categories.php" method="post">
								<div class="mb-3">
							    	<label for="" class="form-label">Tipo</label>
							    	<select class="form-select" name="type">
								  		<option value="Ingreso">Ingreso</option>
								  		<option value="Egreso">Egreso</option>
										<option value="Inversion">Inversion</option>
									</select>
							  	</div>
							  	<div class="mb-3">
							    	<label for="" class="form-label">Categoria</label>
							    	<input type="text" class="form-control" name="category">
							  	</div>
							  	<div class="mb-3">
							    	<label for="" class="form-label">Color</label>
							    	<input type="color" class="form-control form-control-color" name="color" value="#563d7c" title="Choose your color">
							  	</div>
							    <div class="mb-3">
							    	<label for="" class="form-label">Icono</label>
							    	<input class="form-control" type="file" name="icon">
							  	</div>

							  <button type="submit" class="btn btn-primary">Guardar</button>
							</form>	
						</div>	
					</div> 	<!-- Card -->
				</div>	<!-- Col -->

				<div class="col">
					<div class="row">
						<div class="col-md-6">
							<div class="card rounded border border-custom shadow-sm mb-4">
								<div class="card-header">
									<h6 class="card-header-title">Egresos</h6>
									<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
								</div>
								<div class="card-body">
									<div class="list-group">
										<?php
										$data = $categories->load('egreso');
										foreach ($data as $key => $value) {
											echo '<a href="#" class="list-group-item list-group-item-action">
											<div class="row">
												<div class="col-md-8">
												'.$value->category.'
												</div>
												<div class="col text-end">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
												</div>
											</div>
											</a>';
										}
										?>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-6">
							<div class="card rounded border border-custom shadow-sm mb-4">
								<div class="card-header">
									<h6 class="card-header-title">Ingresos</h6>
									<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
								</div>				
								<div class="card-body">
									<div class="list-group">
										<?php
										$data = $categories->load('ingreso');
										foreach ($data as $key => $value) {
											echo '<a href="#" class="list-group-item list-group-item-action">
											<div class="row">
												<div class="col">
												'.$value->category.'
												</div>
												<div class="col text-end">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
												</div>
											</div>
											</a>';
										}
										?>
									</div>
								</div>	
							</div>						
						</div>						
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="card rounded border border-custom shadow-sm mb-4">
								<div class="card-header">
									<h6 class="card-header-title">Inversiones</h6>
									<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
								</div>
								<div class="card-body">
									<div class="list-group">
										<?php
										$data = $categories->load('inversion');
										foreach ($data as $key => $value) {
											echo '<a href="#" class="list-group-item list-group-item-action">
											<div class="row">
												<div class="col-md-8">
													'.$value->category.'
												</div>
												<div class="col text-end">
													<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
												</div>
											</div>
											</a>';
										}
										?>
									</div>
								</div>
							</div>
						</div>
					
					</div> <!-- Row -->
				
				</div> <!-- Col -->

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
