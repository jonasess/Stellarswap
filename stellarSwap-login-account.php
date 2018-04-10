<?php 
error_reporting(E_ERROR | E_PARSE);
session_start();
if(!empty($_SESSION["SessionOnOrOff"])){
if($_SESSION["SessionOnOrOff"]==1){
header('Location: stellarSwap-wallet.php'); 	
}
}
//echo $_POST["error"];
?>


<!DOCTYPE HTML>

<html>
	<head>
		<title>log in SW</title>
		<link rel="icon" href="images/Stellarswap.png"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
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

							<!-- Banner -->
								<section id="banner">
									<div class="content">
										<header>
											<h1>StellarSwap</h1>
											<p>Log in to your stellarswap wallet.</p>
										</header>
										
										<form method="post" id="myForm" action="stellarSwap-checking.php">
										<label for="field1"><span>Email: <span class="required">*</span></span>
											<input id="email" type="email"  placeholder="Email (example: example@example.com)" name="email"  required>
											<br>
										<label><span>Password: <span class="required">*</span></span>
											<input id="secretkey" type="password"  placeholder="password" name="password"  required>
										</label>
										<input id="walletaccount" type="hidden" name="walletaccount" value="walletaccount">
										<label><b id="errormessage"></b></label>
										
										<input type="submit" value="Log in WS"><br>
										<input type="button" onclick="gotonewwallet()" value="Create new SW wallet"><br>
										<input type="button" onclick="forgotpassword()" value="Forgot password?"><br>
									 </form>
									 
									</div>
									<span class="image object">
										<?php //include("boaranimation/thebear.php")?>
									</span>
								</section>

							
						</div>
					</div>

				<!-- Sidebar -->
					<?php 
						include("include/navbarindexlogin.php");
					?>

			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>
<!-- javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script>

function gotonewwallet(){
	window.location.replace("stellarSwap-signin-account.php");
}
function forgotpassword(){
	window.location.replace("stellarSwap-resetpassword.php");
	//alert("under maintenance . it will be available soon...")
}

</script>

</body>
</html>