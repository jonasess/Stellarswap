<!DOCTYPE HTML>
<html>
	<head>
		<title>Terms</title>
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
							<h2>Terms:</h2>

									  <fieldset>
										<legend ></legend>
									  
									  <h2>Cryptocurrency risks:</h2>
								 
									<h5 >Cryptocurrency assets are subject to high market risks and volatility. Past performance is not indicative of future results. Investments in blockchain assets may result in loss of part or all of your investment. Please do your own research and use caution. You are solely responsible for your actions on the Stellar network. Stellarswap is not responsible for your investment losses.

									Cryptocurrency assets and the Stellar "decentralized exchange" are unregulated and does not have governmental oversight. The SEC has recently issued a "Statement on Cryptocurrencies and Initial Coin Offerings" that may be of interest to you.</h5>

									<h2>The Stellar network (separate from Stellarswap)</h2>
									<h5 >Stellarswap is not an exchange. Stellarswap is only a user interface to Stellar and does not operate the Stellar network. Stellarswap is unable to control the actions of others on the Stellar network. When using Stellarswap, you are directly communicating with the Horizon Stellar API operated by Stellar Development Foundation. Transactions on the Stellar network are irreversible.
									</h5>
									<h2>Privacy</h2>
									<h5 >Your privacy is important to us. Please read the privacy policy for more information.
									</h5>
									<h2>Stellarswap does not endorse anything</h2>
									<h5>Stellarswap does NOT endorse ANY asset on the Stellar network. Asset "listings" on Stellarswap are NOT endorsements. Prices shown on Stellarswap are for informational purposes and do not imply that they can actually be redeemed for a certain price.
									</h5>
									<h2>Your own responsibilities</h2>
									<h5>You, the user, are solely responsible for ensuring your own compliance with laws and taxes in your jurisdiction. Cryptocurrencies may be illegal in your area. You, are solely responsible for your own security including keeping your account secret keys safe and backed up.
									</h5>
									<h2>Disclaimer of warranty</h2>
									<h5>Stellarswap is open source software.
									 </h5>
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

