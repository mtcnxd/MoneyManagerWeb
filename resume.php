<?php
require_once ('classes/autoload.php'); 

use classes\myWallet;
use classes\savings;
use classes\investments;

session_start();
$savings = new savings();
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
									$savings = $savings->getTotal();
									echo "$".number_format($savings, 2);
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
									$investments = $investments->getTotal();
									echo '$'.number_format($investments, 2);
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
										Ahorros + Inversion
									</h6>
									<h5 class="card-subtitle mb-2 fs-4">
										<?php
										echo '$'.number_format(($savings + $investments), 2);
										?>
									</h5>
								</div>
							</div>
						</div>													
					</div>
				</div>					

			</div> <!-- row -->	
		</div> 	<!-- container -->

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