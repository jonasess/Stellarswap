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
		<title>Log in</title>
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
											<p>Your secret key will be deleted immediately from browser cash after pressing Log out or closing the browser .
									 so please make sure to not forget to press on Log out once you done .</p>
										</header>
				
									  <form method="post" id="myForm" action="stellarSwap-checking.php">
										<label><span>Secret key: <span class="required">*</span></span>
											<input id="secretkey" type="password"  placeholder="Secret key (example: SBSMVCIWBL3HDB7N4EI3QKBKI4D5ZDSSDF7TMPB.....)" name="secretkey"  required>
										</label>
										<input id="publickey" type="hidden" name="publickey">
										<label><b id="errormessage"></b></label>
										
										<input type="button" onclick="myFunction()" value="Log in">
										<input type="button" onclick="gotonewwallet()" value="Create new wallet">
									 </form>
									</div>
									<span class="image object">
										<img src="images/Stellarswap.png" alt="" />
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
$('form').submit(function () {
  if ($(document.activeElement).attr('type') == 'submit')
     return true;
  else return false;
});
function myFunction() {

	var server = new StellarSdk.Server('https://horizon.stellar.org');
	 var secretkeypair = document.getElementById("secretkey").value;
		
			
				  try {
						var pair = StellarSdk.Keypair.fromSecret(secretkeypair);
						//alert(pair.publicKey());
						document.getElementById("publickey").value=pair.publicKey();
						//if(sss.charAt(0)="G"){
						document.getElementById("myForm").submit();
						//}
						//window.location.replace("stellarSwap-wallet.php");
					}
					catch(err) {
						document.getElementById("errormessage").innerHTML="Invalid secret key. Hint: it starts with the letter S and is all uppercase";
					}
}
function gotonewwallet(){
	window.location.replace("index.php");
}
</script>

</body>
</html>
