<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
if(!empty($_SESSION["SessionOnOrOff"])){
if($_SESSION["SessionOnOrOff"]==1){
header('Location: stellarSwap-wallet.php'); 	
}
}
if(isset($_POST["authorisation"]) && isset($_POST["email"])){
	if($_POST["authorisation"]=="1"){
		$_POST["authorisation"]=0;
			unset($_POST["authorisation"]);
			include("include/dbconnection.php");
					$email=$_POST["email"];
					$exist=false;
					if ($stmt = $conn->prepare("SELECT swemail FROM stellarswapusers WHERE swemail=?")) {
					 
						// Bind a variable to the parameter as a string. 
						$stmt->bind_param("s", $email);
						$result=$stmt->execute();
					  $result = $stmt->get_result();

					   $num_of_rows = $result->num_rows;
						if($num_of_rows>0){
							$exist=true;
						}
					   $stmt->free_result();
					   $stmt->close();
					}
		
		
		if($exist==false){
			$checkemailmessage="email doesn't exist";
		}else{
			
			require_once "Mail-1.4.1/Mail-1.4.1/Mail.php";
			//generate code
			$code=rand(100000,100000000);
			$codeconf=$code;
			$hashed_password=password_hash($code, PASSWORD_DEFAULT);
			$from = "Stellarswap new password <Your email>";
			$to = "Ramona Recipient <".$_POST["email"].">";
			$subject = "Verification code";
			$body = "Hi,\n\nThis is your verification code: ".$hashed_password;
			$host = "smtp host";
			$username = "Your email";
			$password = "Your password";
			$headers = array ('From' => $from,
			  'To' => $to,
			  'Subject' => $subject);
			$smtp = Mail::factory('smtp',
			  array ('host' => $host,
				'auth' => "PLAIN",
			'socket_options' => array('ssl' => array('verify_peer_name' => false)),
				'username' => $username,
				'password' => $password));
			$mail = $smtp->send($to, $headers, $body);
			if (PEAR::isError($mail)) {
			  $checkemailmessage="Something went error please refresh the page again";
			 } else {
			  //echo("<p>Message successfully sent!</p>");
			  $checkemailmessage="We sent a verification code to your email. please check your in-box or spam emails";
			 }
		}
	}else{
		header('Location: index.php');
	}
}

if(isset($_POST["sendcode"]) && isset($_POST["email"])&&isset($_POST["password"])&&isset($_POST["origincode"])){
	if(!empty($_POST["sendcode"])&&!empty($_POST["email"])&&!empty($_POST["password"])){
		
		if (password_verify($_POST["origincode"], $_POST["sendcode"])) {
		
					include("include/dbconnection.php");
					if ($stmtupdate = $conn->prepare("UPDATE stellarswapusers SET swpassword = ? WHERE swemail=?")) {
									 
										// Bind the variables to the parameter as strings. 
										$stmtupdate->bind_param("ss", $_POST["password"],$_POST["email"]);
									 
										// Execute the statement.
							if($stmtupdate->execute()){
								$errormessage="password has been updated";
								$stmtupdate->close();								
								$_POST["sendcode"]="mdmdù";
								$_POST["origincode"]="fdsf";
								unset($_POST["origincode"]);
								unset($_POST["sendcode"]);
								//header('Location: stellarSwap-login-account.php');
							}else{
								$errormessage="There was a problem try again.";
								$stmtupdate->close();
							}
									 
					}
					
		} else {
			$_POST["sendcode"]="mdmdù";
			$_POST["origincode"]="fdsf";
			unset($_POST["origincode"]);
			unset($_POST["sendcode"]);
			$checkemailmessage="wrong code";
		}
		
	}else{
		$errormessage="something went wrong !!!!";
	}
}else{
	$errormessage="Don't leave the fields empty";
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
										<input id="email" name="email" type="hidden" value="<?php echo $_POST["email"];?>"/>
										
										<?php if($checkemailmessage=="wrong code" || $checkemailmessage=="email doesn't exist"){//do somthing
										}else{ ?>
										<input id="origincode" name="origincode" type="hidden" value="<?php echo $codeconf;?>"/>
											<label for="field1"><span>code: <span class="required">*</span></span>
											<input id="sendcode" type="text"  placeholder="code" name="sendcode"  required>
											<br>
										<label for="field1"><span>new password: <span class="required">*</span></span>
											<input id="password" type="password"  placeholder="password" name="password"  required>
										</label>
										<label><h4 style="color:red" id="errormessage"><?php echo $errormessage;?></h4></label>
										<input type="submit" value="Submit">
										<?php }?>
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
function login(){
	window.location.replace("stellarSwap-login-account.php");
}
</script>	
</body>
</html>