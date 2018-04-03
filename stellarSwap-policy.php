<!DOCTYPE HTML>
<html>
	<head>
		<title>Privacy Policy</title>
		<link rel="icon" href="images/Stellarswap.png"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>

		<!-- Wrapper -->
			<div id="wrapper">
			
				<!-- Main -->
					<div id="main">
						<div class="inner">

							<!-- Header -->
								<?php 
									include("include/socialmediaheader.php");
								?>

							<!-- Content -->
							<section>
								<header class="main">
									<h1>StellarSwap</h1>
								</header
							<!-- Content -->
							<h2>Privacy Policy:</h2>

									  <fieldset>
										<legend ></legend>
									  
								
								 <h4>This policy may be updated or revised without notice. It is the responsibility of the user to stay informed about privacy policy changes.</h4>

								<h5>Stellarswap does track your actions.</h5>

								<h5>Stellarswap does not store cookies and the website does not contain any analytics scripts.</h5>

								<h5>Stellarswap developers never see your private keys.</h5>

								<h5>However, Stellarswap.space host providers where it's hosted They may and do have their own tracking systems on their servers. Those services have their own privacy policies and they are not covered by this privacy policy.
								</h5>
								<h5>While Stellarswap does not track you, this does not mean your actions are private. Take note of other privacy issues that may affect you:</h5>

								<h3>Stellar is a public ledger. Anyone can see anything that happens on the network.</h3>
								<h5>Your inflation vote is publicly visible.</h5>
								<h5>Your computer might be compromised.</h5>
								<h5>The Stellarswap website might be compromised.</h5>
									
									 </fieldset>				
						</div>
					</div>
				<?php 
					session_start();
						if(!empty($_SESSION["SessionOnOrOff"])){
							if($_SESSION["SessionOnOrOff"]==1){
								include("include/navbar.php");
						}else{
							include("include/navbarindexlogin.php");
						}
					}else{
						include("include/navbarindexlogin.php");
					}
					
				?>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
<!-- javascript -->
</body>
</html>

