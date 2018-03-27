<?php 
error_reporting(E_ERROR | E_PARSE);
session_start();
if(!empty($_SESSION["SessionOnOrOff"])){
if($_SESSION["SessionOnOrOff"]==1){
header('Location: stellarSwap-wallet.php'); 	
}
}
if(isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["password2"])){
	//$errormessage=$_POST["publickey"];
	if($_POST["password"]==$_POST["password2"]){
		
		
				if(!empty($_POST["secretkey"])&&!empty($_POST["publickey"])&&!empty($_POST["email"])&&!empty($_POST["password"])){
					/// hahahah
					include("include/dbconnection.php");
							/////////////////::
					
					$email=$_POST["email"];
					$password=$_POST["password"];
					$sek=$_POST["secretkey"];
					$pbk=$_POST["publickey"];
					
					/*$emailcoin=$_POST["emailcoin"];
					$codepin=$_POST["codepin"];
					$apicode=$_POST["apicode"];
					$btcoinkey=$_POST["btcoinkey"];
					$dogecoinkey=$_POST["dogecoinkey"];
					$litecoinkey=$_POST["litecoinkey"];*/
					
					$exist=false;
 
					if ($stmt = $conn->prepare("SELECT swemail FROM stellarswapusers WHERE swemail=?")) {
					 
						// Bind a variable to the parameter as a string. 
						$stmt->bind_param("s", $email);
					 
						// Execute the statement.
						$result=$stmt->execute();
					 
						// Get the variables from the query.
						//$stmt->bind_result($pass);
					 
					 
					  $result = $stmt->get_result();

					   /* Get the number of rows */
					   $num_of_rows = $result->num_rows;
						if($num_of_rows>0){
							$exist=true;
						}


					   /*while ($row = $result->fetch_assoc()) {
							echo $row['id'];
							echo $row['swemail'];
							$exist=true;
					   }*/

					   /* free results */
					   $stmt->free_result();

					   /* close statement */
					   $stmt->close();
					 
					}

			/////////////////////////////////////
				if($exist==false){
					
					include("block_io-php-master/apiinfo.php");
					if($btcarrayofblock->status=="success" && $dogearrayofblock->status=="success" && $litearrayofblock->status=="success"){
						$btcoinkey=$btcarrayofblock->data->address;
						$dogecoinkey=$dogearrayofblock->data->address;
						$litecoinkey=$litearrayofblock->data->address;
						
						//sql injection and also try catch of  data
						
						
						//echo " ".$arrayofblock->data->label;

						if ($stmt = $conn->prepare("INSERT INTO stellarswapusers (swemail,swpassword,swsecretkey,
								swpublickey,swemailcoin,swbtccoinkey,swdogecoinkey,swlitecoinkey,swbtcapi,swdogeapi,swliteapi,swpin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
						 
							// Bind the variables to the parameter as strings. 
							//s means string ss means two string .. etc .... protected from sql injection
							$stmt->bind_param("ssssssssssss", $email, $password, $sek, $pbk, $emailcoin, $btcoinkey, $dogecoinkey, $litecoinkey,$btcapiKey,$dogeapiKey,$liteapiKey,$pin);//
						 
							// Execute the statement.
							if($stmt->execute()){
								$errormessage="Great has been created";
								$stmt->close();
								header('Location: stellarSwap-login-account.php');
								
							}else{
								$errormessage="There was a connection problem try again.";
								$stmt->close();
							}
						 
						}
						
					}else{
						$errormessage="Cannot create btc,lite and doge wallet";
					}
					
				}else{
					$errormessage="The email is already used";
					
				}
					
					
					/////	
				}
		

		
		
	}else{
		$errormessage="These passwords don't match. Try again";
	}
}else{
	$errormessage="Don't leave the fields empty";
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Create SW wallet</title>
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
							<h4>Create new stellarswap wallet.</h4>

									  <form method="post" id="myForm" action="stellarSwap-signin-account.php">
										<label for="field1"><span>Email: <span class="required">*</span></span>
											<input id="email" type="email"  placeholder="Email (example: example@example.com)" name="email"  required>
											<br>
										<label for="field1"><span>password: <span class="required">*</span></span>
											<input id="password" type="password"  placeholder="password" name="password"  required>
											<br>
										<label for="field1"><span>confirm password: <span class="required">*</span></span>
											<input id="password2" type="password"  placeholder="password" name="password2"  required>
										</label>
										<input id="publickey" type="hidden" name="publickey">
										<input id="secretkey" type="hidden" name="secretkey">
										<label><h4 style="color:red" id="errormessage"><?php echo $errormessage;?></h4></label>
										
										<input type="button" onclick="myFunction()" value="Create new SW wallet">
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
		var password=document.getElementById("password") ;
		var password2=document.getElementById("password2");
		if(password.value==password2.value){
			var filter = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(filter.test(email.value)){
				var server = new StellarSdk.Server('https://horizon.stellar.org');
				var pair = StellarSdk.Keypair.random();
				pair.secret();
				// S...
				pair.publicKey();
				// G...
				document.getElementById("publickey").value = pair.publicKey();
				document.getElementById("secretkey").value = pair.secret();

				document.getElementById("myForm").submit();
			}else{
				document.getElementById("errormessage").innerHTML="Please provide a valid email address";
				email.focus;
			}
		}else{
			document.getElementById("errormessage").innerHTML="These passwords don't match. Try again";
			password.focus;
			password2.focus;
		}
}
function login(){
	window.location.replace("stellarSwap-login-account.php");
}
</script>	
</body>
</html>