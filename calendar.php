<?php
require_once('classes/autoload.php'); 

use classes\myWallet;
use classes\calendar;
use classes\bills;

session_start();
$startDate = date('Y-m-01'); 
$endDate   = date('Y-m-t');
$wallet    = new myWallet();
$calendar  = new calendar();
$bills     = new bills();
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
			<div class="row">
				<div class="col-md-3 mb-4">
					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Menu reportes</h6>
                            <svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#555555" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
						</div>

                        <div class="list-group p-1">
                            <a href="reports.php" class="list-group-item list-group-item-action">Mes actual</a>
                            <a href="calendar.php" class="list-group-item list-group-item-action active">Calendario</a>
                        </div>
					</div>	
				</div>	<!-- col-md-3 -->

				<div class="col">
					<div class="calendar">
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<h4 class="mb-3">
										<?=ucfirst($calendar->getCurrentMonth());?>
									</h4>
								</div>
								<div class="col text-end">									
									<a id="" class="btn btn-primary" href="?month=<?=date('m')-1;?>" role="button"> << </a>
									<a id="" class="btn btn-primary" href="?month=<?=date('m')+1;?>" role="button"> >> </a>
								</div>
							</div>

							<?php
							foreach($calendar->getWeekDays() as $day) { 
								echo "<div class='name'>". $day ."</div>";
							}

							$dayOfWeek = $calendar->getFirstDayOfMonth(true);
							for ($i=0; $i<$dayOfWeek; $i++) { 
								echo "<div class='day'> &nbsp; </div>";
							}

							$daysOfMonth = date('t');
							$currentDay  = date('d');

							for($i=1; $i<=$daysOfMonth; $i++){
								echo "<div class='day'>";
								if ( $currentDay == $i ){
									echo "<span class='date active'>". $i ."</span>";
								} else {
									echo "<span class='date'>". $i ."</span>";
								}

								if ($bill = $bills->getBillByDate(date('Y-m-').$i)){
									echo "<div>";
									echo "  <a href='#' id=".$bill->id." class='btn-bill'>
												<span class='badge bg-danger'>".'$'. number_format($bill->amount) ."</span>
											</a>";
									echo "</div>";
								}							
								echo "</div>";
							}
							?>
						</div>
					</div>
				</div>				
			</div>
		</div>	<!-- Container -->

		<div class="modal fade" tabindex="-1" id="billDetails">
			<div class="modal-dialog modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body">
						<div class="row border-bottom p-2">
							<div class="col-md-6 fw-semibold">
								Categoria:
							</div>
							<div class="col text-end">
								<span id="category"></span>
							</div>
						</div>
						<div class="row border-bottom p-2">
							<div class="col-md-6">
								Descripción:
							</div>
							<div class="col text-end">
								<span id="description"></span>
							</div>
						</div>
						<div class="row border-bottom p-2">
							<div class="col-md-6">
								Importe:
							</div>
							<div class="col text-end">
								<span id="amount"></span>
							</div>
						</div>
					</div>
					<div class="modal-footer border-0">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>		
		
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		        crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>
			$(".btn-bill").on('click', function(btn){
				btn.preventDefault();
				const id = $(this).attr('id');
				
				$.ajax({
					url:'background/ajax_endpoint.php',
					method:'post',
					data: {
						action: 'loadBillDetails',
						object: id
					},
					success: function(response){
						const json = JSON.parse(response);
						const numberOptions = { style: 'currency', currency: 'USD' };
						const numberFormat = new Intl.NumberFormat('en-US', numberOptions);

						$("#category").text(json.data.category);
						$("#description").text(json.data.description);
						$("#amount").text(numberFormat.format(json.data.amount));
						
						const modal = new bootstrap.Modal(document.getElementById('billDetails'));
						modal.show();
					}
				});

			});
		</script>
	</body>
</html>

