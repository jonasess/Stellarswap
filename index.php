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
		<title>StellarSwap</title>
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
								<p>Your global exchange for all Stellar token. Easy sign up, easy trading.</p>
										
								
								<b>You can now trade all stellar issued tokens against BTC, LTC and DOGE.</b>
								<h2><a href="stellarSwap-aboutswaccount.php" >Learn more</a></h2>
								<h4 >Make sure to save your secret key and not to share it with anyone . public key is save to use for the exchange.</h4>
								 <header class="main">
									<h1>Generate new wallet:</h1>
								</header>
								<b>public key : </b><b id="publickey"></b><br>
								<b>Secret key : </b><b style="color:red;" id="secretkey"></b><br><br>

							  <button class="button special" onclick="location.href = 'stellarSwap-login.php';" id="myButton" >log in</button>
							  <button class="button" onclick="generatenewAccount()">Generate new account</button>								
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
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script >
	function generatenewAccount() {
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		var pair = StellarSdk.Keypair.random();
		pair.secret();
		// S...
		pair.publicKey();
		// G...
		document.getElementById("publickey").innerHTML = pair.publicKey();
		document.getElementById("secretkey").innerHTML = pair.secret();

	}
</script>

	
	</body>
</html>