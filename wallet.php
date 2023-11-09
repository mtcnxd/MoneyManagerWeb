<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;
use classes\categories;
use classes\bills;

session_start();
$bills  = new bills();
$wallet = new myWallet();
$categories = new categories();

if($_POST){
	$bills->insert([
		'type'        => $_POST['type'],
		'category'    => $_POST['category'],
		'description' => $_POST['description'],
		'date'        => $_POST['date'],
		'amount'      => $_POST['amount'],
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
					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Agregar movimiento</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body">
							<form action="wallet.php" method="post">
								<div class="mb-3">
							    	<label for="" class="form-label">Fecha</label>
									<input type="date" class="form-control" name="date" id="date" value="<?=date('Y-m-d')?>">
							  	</div>
								<div class="mb-3">
							    	<label for="" class="form-label">Tipo</label>
							    	<select class="form-select" name="type" id="type">
							    		<option value="">Seleccionar tipo</option>
								  		<option value="Ingreso">Ingreso</option>
								  		<option value="Egreso">Egreso</option>
									</select>
							  	</div>
								<div class="mb-3">
							    	<label for="" class="form-label">Categoria</label>
							    	<select class="form-select" name="category" id="category">
								  		<?php
										$list = $categories->load('Ingreso');
										foreach ($list as $value) {
											echo "<option>".$value->category."</option>";
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
											<td>Descripción</td>
											<td>Fecha</td>
											<td class="text-end">Importe</td>
											<td class="text-end"></td>
										</tr>
										<?php 
										$data = $bills->getDataBetween('Egreso', date('Y-m-01'), date('Y-m-t'));
										foreach ($data as $row => $bill){
											$parseDate = new dateTime($bill->date);
											echo "<tr>";
											echo "	<td>".($row + 1)."</td>";
											echo "	<td>".$bill->description."</td>";
											echo "	<td>".$parseDate->format('d-m-Y')."</td>";
											echo "	<td class='text-end'>$".number_format($bill->amount,2)."</td>";
											echo '	<td>
														<a href="#" id='.$bill->id.' class="btn-delete">
														<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
														</a>
													</td>';
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
											<td>Descripción</td>
											<td>Fecha</td>
											<td class="text-end">Importe</td>
											<td class="text-end"></td>
										</tr>
										<?php
										$data = $bills->getDataBetween('Ingreso', date('Y-m-01'), date('Y-m-t'));
										foreach ($data as $row => $value) {
											echo "<tr>";
											echo "	<td>".($row + 1)."</td>";
											echo "	<td>".$value->description."</td>";
											echo "	<td>".$value->date."</td>";
											echo "	<td class='text-end'>$".number_format($value->amount,2)."</td>";
											echo '	<td>
														<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
													</td>';
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
<script>
$(".btn-delete").on('click', function(e){
	e.preventDefault();
	const object = $(this).attr('id');
	console.log(object);
});

$("#type").on('change', function(){
	const object = $(this).val();
	$.ajax({
		url: "background/ajax_endpoint.php",
		method: 'post',
		data: {
			action:'loadCategory',
			object: object
		},
		success: function(response) {
			const json = JSON.parse(response);
			// console.log(json.data);
			
			$("#category").empty();
			json.data.forEach(function (row){
				$("#category").append('<option>' + row + '</option>');
			});
		}
	});
});
</script>