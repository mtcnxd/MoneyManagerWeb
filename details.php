<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

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
				<div class="col-md-6">
					<div class="card rounded border border-custom shadow-sm mb-4">
						<div class="card-header">
							<h6 class="card-header-title">Rendimientos</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
						</div>				
						<div class="card-body p-0">
							<table class="table table-hover">
								<thead>
									<tr class="table-custom text-uppercase fs-7">
										<th scope="col">#</td>
										<th scope="col">Instrumento</td>
										<th scope="col">Fecha</td>
										<th scope="col" class="text-end">Saldo</td>
									</tr>
								</thead>
								<?php
								$count = 0;
								$data  = $wallet->loadListbyItem($_REQUEST['q']);

								foreach ($data as $key => $value) {
									$count++;
                                    $dateTime = new DateTime($value->date);
									$values[$key]  = $value->amount;
									$labels[$key]  = $dateTime->format('d-m-Y');

									echo "<tr>";
									echo "	<td>". $count ."</td>";
									echo "	<td>". $value->concept ."</td>";
                                    echo "	<td>". $dateTime->format('d-m-Y') ."</td>";
									echo "	<td class='text-end'> $". number_format($value->amount, 2) ."</td>";
									echo "</tr>";
								}

								?>
							</table>
						</div>	
					</div> 	<!-- Card -->
				</div>	<!-- Col -->

				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<canvas class="p-3" id="currentChart" width="250" height="100"></canvas>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script>
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