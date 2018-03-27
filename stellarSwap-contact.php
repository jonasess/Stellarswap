<?php 
				
	include("stellarSwap-session.php");
	//echo $_SESSION["secretkey"];
	
	//echo $_SESSION["publickey"];
	//session_start();
	//echo $_SESSION["SessionOnOrOff"];
	//echo $_SESSION["secretkey"];
	//echo $_POST["data"];
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Contact us</title>
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
									<h1>Stellarswap</h1>
								</header
							<!-- Content -->
								<h2>Contact Us:</h2>						
								<fieldset>
								<legend ></legend>
							   <label id="info"><h4>
							   My email address: jonasess@gmail.com .</h4> <br>
							   <legend ></legend>
							   <h2>Notes:</h2>
							   <h4>* You are facing any troubles on StellarSwap? &#9755 Please let us know.</h4>
							   <h4>* You have any opinion or idea? &#9755 We would love to hear it.</h4>
							   <h4>* You want to list your tokens/assets? &#9755 Email us.</h4>
							   <h2>You want to support StellarSwap? &#9755 Donate. </h2>
							   <h4> My wallets: </h4>
							   <h4>Stellar wallet: GDI4HFEIZIPUGMXL7MM5BXRAJKC76XU2EDSS6GML2PL7MBTG6GICUYS3 </h4>
							   <h4>BTC wallet: 1PD1UBxTajiHEa4oDZex6QN6UT4aRxCDsM </h4>
							   <h4>ETH wallet: 0x083c01b98810e17b0b6cce27cb1cb37a6a40e4eb </h4>
							   <h4>LTC wallet: LQ3fQoLJkW7hwuPdWtcPa5YYtAvmsp7UCs </h4>
							   </label></br>
							   
							 </fieldset>					
						</div>
					</div>
				<?php 
					include("include/navbar.php");
				?>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
</body>
</html>