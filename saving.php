<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;
use classes\savings;

session_start();
$wallet  = new myWallet();
$savings = new savings();

if($_POST){
	$savings->insert([
		'date'   => $_POST['date'],
		'name'   => $_POST['name'],
		'amount' => $_POST['amount'],
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
							<h6 class="card-header-title">Agregar aporte</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body">
							<form action="saving.php" method="post">
								<div class="mb-3">
									<label class="form-label">Fecha</label>
									<input type="date" class="form-control" name="date" value="<?=date('Y-m-d')?>">
								</div>

								<div class="mb-3">
									<label class="form-label">Proposito</label>
									<select class="form-select" name="name">
										<option>Spotify Premium</option>
									</select>
								</div>

							  	<div class="mb-3">
							    	<label class="form-label">Importe</label>
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
					<div class="alert alert-warning alert-custom" role="alert">
						<h6>Spotify Premium con interes compuesto</h6>
						Ahorro requerido: $6,000.00
					</div>

					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Lista de aportaciones</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body" id="cardbody">
							<table class="table table-hover" id="tblsavings">
								<?php
								$data = $savings->load();
								foreach ($data as $value) {
									$date = new DateTime($value->date);
									echo "<tr>";
									echo "	<td>".$value->name ." ". $value->id."</td>";
									echo "	<td>".$date->format('d-m-Y')."</td>";									
									echo "	<td class='text-end'> $". number_format($value->amount, 2)."</td>";
									echo '	<td class="text-end">
												<a href="#" id='.$value->id.' class="btn-delete">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
												</a>
											</td>';
									echo "</tr>";
								}
								?>
							</table>

							<div class="p-2">
								<?php
								$total    = 6000;
								$saving   = $savings->getTotal();
								$faltante = $total - $saving;
								$percentage = number_format(($saving/$total) * 100, 0);
								?>
								<div class="progress" aria-valuenow="<?=$percentage?>" aria-valuemin="0" aria-valuemax="100">
  									<div class="progress-bar" style="width:<?=$percentage?>%"><?=$percentage?>%</div>
								</div>								
							</div>

							<div class="row p-2">
								<div class="col-md-6 text-center">
									<div class="card pt-2 bg-blanchedalmond">
										<h6>
											AHORRO TOTAL: 
											<?php 
											echo "$".number_format($saving, 2);
											?>
										</h6>
									</div>
								</div>
								<div class="col-md-6 text-center">
									<div class="card pt-2 bg-blanchedalmond">
										<h6>
											FALTANTE: 
											<?php 
											echo "$".number_format($faltante, 2);
											?>
										</h6>
									</div>
								</div>
							</div>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(".btn-delete").on('click', function(e){
	e.preventDefault();
	const id = $(this).attr('id');

	$.ajax({
		url:'background/ajax_endpoint.php',
		method: 'POST',
		data: {
			action:'deleteSaving',
			object:id
		}, 
		success: function(response){
			const jsonResponse = JSON.parse(response);

			Swal.fire({
			  title: 'Eliminado!',
			  text: jsonResponse.message,
			  confirmButtonText: 'Aceptar',
			}).then((confirm) => {
				if (confirm.isConfirmed) {
					location.replace('saving.php');
				}
			});
		}
	});
});
</script>