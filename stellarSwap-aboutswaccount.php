<?php 
session_start();
if(!empty($_SESSION["SessionOnOrOff"])){
if($_SESSION["SessionOnOrOff"]==1){
header('Location: stellarSwap-wallet.php'); 	
}
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>What's SW wallet?</title>
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
							<h2>What's The differents between Stellarswap wallet and normal wallet?.</h2>

									  <fieldset>
										<legend ></legend>
									   <label id="info">
									   <h3>Normal wallet (stellar wallet):</h3>
									   <h4>* Allows you only to trade lumens(XLM) against tokens.</h4>
										<h4>* Allows you to send and receive payments using lumens(XLM) or tokens.</h4>
									   <legend ></legend>
									   <h3>Stellarswap :</h3>
									   <h4 >* Allows you to trade lumens(XLM) with tokens or cryptocurrency(coins) (or the opposite).</h4>
									   <h4 >* Allows you to trade cryptocurrency(coins) with tokens(or the opposite).</h4>
									   <h4 >* Allows you to send and receive payments using lumens(XLM) or tokens.</h4>
									   <h4 >* Allows you to send and receive payments using cryptocurrency(coins).</h4>
									 <h2 style="color:blue"><a  href="stellarSwap-signin-account.php" >Create stellarswap wallet</a></h2> 
									 </fieldset>				
						</div>
					</div>
				<?php 
					include("include/navbarindexlogin.php");
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

