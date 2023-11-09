<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;
use classes\users;
use classes\categories;

session_start();
$users  = new users();
$wallet = new myWallet();

$userData = $users->find($_SESSION);
$userConf = $users->loadConfiguration($_SESSION);
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
				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-3">
						<div class="card-header">
							<h6 class="card-header-title">Perfil</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
						</div>

						<div class="p-4">
							<form action="" method="post" name="profile">
								<div class="mb-3">
									<label for="name" class="form-label">Full name</label>
									<input type="text" name="name" id="name" class="form-control" value="<?=$userData->name;?>">
								</div>
								<div class="mb-3">
									<label for="username" class="form-label">Username</label>
									<input type="text" name="username" id="username" class="form-control" value="<?=$userData->username;?>">
								</div>
								<div class="mb-3">
									<label for="email" class="form-label">Email</label>
									<input type="text" name="email" id="email" class="form-control" value="<?=$userData->email;?>">
								</div>
								<div class="mb-3">
									<label for="password" class="form-label">New password</label>
									<input type="text" name="password" id="password" class="form-control">
								</div>
								<div class="mb-3">
									<input type="button" value="Save" class="btn btn-primary" >
								</div>
							</form>
						</div>
					</div>
					
					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Extrapolación</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
						</div>						
						<div class="p-4">
							<form>
								<p>Extrapolación de rendimientos en base a interes compuesto</p>
								<div class="mb-3">
									<label for="months" class="form-label"><?=$userConf[0]->description; ?></label>
									<input type="text" id="months" class="form-control" value="<?=$userConf[0]->value; ?>">
								</div>
								<div class="mb-3">
									<input type="button" id="confirm" value="Save" class="btn btn-primary">
								</div>
							</form>
						</div>
					</div>
					
				</div>	<!-- Col -->

				<div class="col">
					<div class="card rounded border border-custom shadow-sm mb-3">
						<div class="card-header">
							<h6 class="card-header-title">Alertas</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
						</div>

						<div class="p-4">
							<form action="" method="post" name="configuration">
								<div class="mb-3 form-check">
									<input type="checkbox" class="form-check-input" id="sendnotify1">
								    <label class="form-check-label" for="sendnotify">Notify when balance goes down 3% in last hour</label>
								</div>
								<div class="mb-3 form-check">
									<input type="checkbox" class="form-check-input" id="sendnotify2" checked="true">
								    <label class="form-check-label" for="sendnotify">Notify when balance goes up 3% in last hour</label>
								</div>								
								<div class="mb-3">
									<input type="button" value="Save" class="btn btn-primary" >
								</div>
							</form>
						</div>
					</div>

					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Instrumentos de inversion</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
						</div>

						<div class="p-4">
							<form action="" method="post" name="configuration">
								<?php

								$categories = new categories();
								$instruments = $categories->load('Inversion');
								
								foreach ($instruments as $instrument){
									echo '<div class="mb-3 form-check">';
									if ($instrument->visible == true){
										echo '	<input type="checkbox" id='.$instrument->id.' class="form-check-input checkbox" checked>';
									} else {
										echo '	<input type="checkbox" id='.$instrument->id.' class="form-check-input checkbox">';
									}
								    echo '	<label class="form-check-label" for="sendnotify">'.$instrument->category.'</label>';
									echo '</div>';
								}
								?>
							</form>
						</div>
					</div>
				
				</div>	<!-- Col -->
			</div>	<!-- row -->
		</div>	<!-- Container -->

		<div class="toast-container position-fixed bottom-0 end-0 p-3">
  			<div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000" data-bs-animation="true">
    			<div class="toast-header">
					<img src="images/celular.png" class="rounded me-2" width="20">
      				<strong class="me-auto">Notificación</strong>
					  <small class="text-body-secondary">Ahora mismo</small>
      				<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    			</div>
    			<div class="toast-body">
      				<span id="message"></span>
    			</div>
			</div>
  		</div>

	</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	$(".checkbox").on('click', function(){
		var object = $(this).attr("id");
		var status = $(this).prop("checked");

		$.ajax({
			url: '/background/ajax_endpoint.php',
			method: 'post',
			data: {
				action:'updateCheckboxStatus',
				object:object,
				status:status
			},
			success: function(response){
				const json = JSON.parse(response);
				const notify = document.getElementById('liveToast');

				$("#message").text(json.message);
				bootstrap.Toast.getOrCreateInstance(notify).show();
			}
		})

	});

	$("#confirm").on('click', function(){
		const object = 1;
		const months = $("#months").val();
		$.ajax({
			url: '/background/ajax_endpoint.php',
			method: 'post',
			data: {
				action: 'updateConfiguration',
				object: object,
				status: months
			},
			success: function(response){
				const json = JSON.parse(response)
				const notify = document.getElementById('liveToast');

				$("#message").text(json.message);
				bootstrap.Toast.getOrCreateInstance(notify).show();
			}

		})
	});
</script>