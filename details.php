<?php
require_once ('classes/autoload.php'); 

use classes\investments;

session_start();
$investments = new investments();
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
				<div class="col-md-6">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Rendimientos</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body p-0" style="max-height:450px; overflow-y: scroll;">
							<table class="table table-hover">
								<thead>
									<tr class="table-custom text-uppercase fs-7">
										<th scope="col">#</td>
										<th scope="col">Instrumento</td>
										<th scope="col">Fecha</td>
										<th scope="col" class="text-end">Saldo</td>
										<th scope="col" class="text-end"></td>
									</tr>
								</thead>
								<?php
								$data  = $investments->loadLastMonth($_REQUEST['q']);
								foreach ($data as $key => $invest) {
                                    $dateTime = new DateTime($invest->date);
									$values[$key]  = $invest->amount;
									$labels[$key]  = $dateTime->format('d-m-Y');
									
									$chartData[$dateTime->format('d-m-Y')] = $invest->amount;

									echo "<tr>";
									echo "	<td>". ($key +1) ."</td>";
									echo "	<td>". $invest->category ."</td>";
                                    echo "	<td>". $dateTime->format('d-m-Y') ."</td>";
									echo "	<td class='text-end'> $". number_format($invest->amount, 2) ."</td>";
									echo '  <td>
												<a href="#" id='.$invest->id.' class="btn-delete">
												<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
												</a>
											</td>';
									echo "</tr>";
								}

								krsort($chartData);
								?>
							</table>
						</div>	
					</div> 	<!-- Card -->
				</div>	<!-- Col -->

				<div class="col">
					<div class="card border-custom shadow-sm mb-4">
						<div class="card-body">
							<canvas class="p-3" id="currentChart" width="250" height="100"></canvas>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="card border-custom shadow-sm">
								<div class="card-body">
									<div class="align-items-center row">
										<div class="col">
											<h6 class="card-title text-muted text-uppercase fs-7">Incremento del ultimo mes</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											$result = $values[0] - end($values);
											echo '$'. number_format($result, 2);
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
											<h6 class="card-title text-muted text-uppercase fs-7">Incremento ponderado</h6>
											<h5 class="card-subtitle mb-2 fs-6">
											<?php
											$percentage = ($result/$values[0]) * 100;
											echo number_format($percentage, 2) .'%';
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script>
$(".btn-delete").on('click', function(btn){
	console.log(this.id);

	$.ajax({
		url: "background/ajax_endpoint.php",
		method: 'post',
		data: {
			action:'deleteInvest',
			object: this.id
		},
		success: function(response) {
			console.log(response);
		}
	});

	Swal.fire({
  		title: 'Message',
  		text: 'Data: '+ this.id +' was success deleted',
  		icon: 'success',
  		confirmButtonText: 'Accept'
	})
});

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