<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;

$wallet = new myWallet();
$userData = $wallet->selectTableWithID('wallet_users', 1)[0];
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
				<div class="col">
					<div class="card rounded border border-custom shadow-sm">
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
									<input type="text" name="username" id="username" class="form-control">
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
									<input type="button" id="confirm" value="Save" class="btn btn-primary" >
								</div>
							</form>
						</div>
					</div>	
				</div>	<!-- Col -->

				<div class="col">
					<div class="card rounded border border-custom shadow-sm">
						<div class="card-header">
							<h6 class="card-header-title">Configuracion</h6>
							<svg class="card-header-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
						</div>

						<div class="p-4">
							<form action="" method="post" name="configuration">
								<div class="mb-3 form-check">
									<input type="checkbox" class="form-check-input" id="sendnotify1">
								    <label class="form-check-label" for="sendnotify">Notify when balance goes down 3% in last hour</label>
								</div>
								<div class="mb-3 form-check">
									<input type="checkbox" class="form-check-input" id="sendnotify2">
								    <label class="form-check-label" for="sendnotify">Notify when balance goes up 3% in last hour</label>
								</div>								
								<div class="mb-3">
									<input type="button" id="confirm" value="Save" class="btn btn-primary" >
								</div>
							</form>
						</div>

					</div>	<!-- Card -->
					
				</div>	<!-- Col -->

			</div>	<!-- row -->

		</div>	<!-- Container -->
		
	</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		crossorigin="anonymous">
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js">
</script>
