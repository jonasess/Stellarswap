<?php
error_reporting(E_ERROR | E_PARSE);
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
		<title>Reset SW wallet password</title>
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
							<h4>Reset your password</h4>
							<h4 style="color:red;"><?php echo $checkemailmessage;?></h4>
									  <form method="post" id="myForm" action="stellarSwap-confresetpassword.php">
										<label for="field1"><span>Your email: <span class="required">*</span></span>
											<input id="email" type="email"  placeholder="Email (example: example@example.com)" name="email"  required>
											<br>
											<input id="authorisation" name="authorisation" value="1" type="hidden"/>
										<label><h4 style="color:red" id="errormessage"><?php echo $errormessage;?></h4></label>
										<input type="button" onclick="myFunction()" value="Submit">
										<input type="button" onclick="login()" value="Log in SW">
										
									 </form>							
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script>
$('form').submit(function () {
  if ($(document.activeElement).attr('type') == 'submit')
     return true;
  else return false;
});
function myFunction() {
	
		var email=document.getElementById("email") ;
			var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(filter.test(email.value)){
				document.getElementById("myForm").submit();
			}else{
				document.getElementById("errormessage").innerHTML="Please provide a valid email address";
				email.focus;
			}
		
}
function login(){
	window.location.replace("stellarSwap-login-account.php");
}
</script>	
</body>
</html>