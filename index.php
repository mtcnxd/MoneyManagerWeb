<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;
use classes\savings;
use classes\investments;

$savings = new savings();
$investments = new investments();
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
			<nav class="navbar bg-body-tertiary">
				<div class="container-fluid">
					<h2>Dashboard</h2>
				</div>
			</nav>
			
			<div class="row mb-4">
				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<div class="align-items-center row">
								<div class="col">
									<h6 class="card-title mb-3 text-muted text-uppercase fs-7">
										Cartera
									</h6>
									<h5 class="card-subtitle mb-2 fs-4">
									<?php
									echo "$".number_format(0, 2);
									?>
									</h5>
								</div>
							</div>
						</div>													
					</div>
				</div>				

				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<div class="align-items-center row">
								<div class="col">
									<h6 class="card-title mb-3 text-muted text-uppercase fs-7">
										Ahorros
									</h6>
									<h5 class="card-subtitle mb-2 fs-4">
									<?php
									echo "$".number_format($savings->getTotal(),2);
									?>
									</h5>
								</div>
							</div>
						</div>													
					</div>
				</div>	

				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<div class="align-items-center row">
								<div class="col">
									<h6 class="card-title mb-3 text-muted text-uppercase fs-7">
										Inversiones
									</h6>
									<h5 class="card-subtitle mb-2 fs-4">
									<?php
									echo '$'. number_format($investments->getTotal(), 2);
									?>
									</h5>
								</div>
							</div>
						</div>													
					</div>
				</div>				

				<div class="col">
					<div class="card border-custom shadow-sm">
						<div class="card-body">
							<div class="align-items-center row">
								<div class="col">
									<h6 class="card-title mb-3 text-muted text-uppercase fs-7">
										Egresos vs Ingresos
									</h6>
									<h5 class="card-subtitle mb-2 fs-4">
										<?php
										echo '24%';
										?>
									</h5>
								</div>
							</div>
						</div>													
					</div>
				</div>					

			</div>

		</div> 	<!-- Container -->	

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
		        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" 
		        crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "i84qwphpao");
        </script>
	</body>
</html>