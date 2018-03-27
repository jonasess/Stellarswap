<script src="stellar-sdk/stellar-sdk.js" ></script>
<script src="block_io-php-master/sendpaymentsbacktocoin.js" ></script>
<?php 
error_reporting(E_ERROR | E_PARSE);
	include("stellarSwap-session.php");
	include("stellarSwap-assetTokens.php");
	include("include/dbconnection.php");
	include("block_io-php-master/coinoperation.php");
	if(isset($_SESSION["walletaccount"])){
		if($_SESSION["walletaccount"]=="walletaccount"){
			$transactionstatus="";
?>


<!-- do transaction -->
<?php 
//transaction for ask table
	if(isset($_POST["pricecoin"])&&isset($_POST["TokenAmoint"])&&isset($_POST["coinamount"])){
		if(!empty($_POST["pricecoin"])&&!empty($_POST["TokenAmoint"])&&!empty($_POST["coinamount"])){
					/////////////////
					$coinnum= $_POST["mychosencoin"];
					$assetcode =$_POST["inputcode"];
					$assetissuer=$_POST["inputissuer"];
					
					//$assetlogo=$_POST["inputlogo"];
					$stseckeyseller=$_SESSION["secretkey"];
					$stpubkeyseller=$_SESSION["publickey"];
					$sellcoincode=$_SESSION["allcoins"][$coinnum]["code"];
					$buytokencode=$assetcode;
					$coinkeyseller=$_SESSION["allcoins"][$coinnum]["swcoinkey"];
					$coinapi=$_SESSION["allcoins"][$coinnum]["swbtcapi"];
					$coinpin=$_SESSION["swpin"];
					$sellcoinamount=$_POST["coinamount"];
					$buytokenamoun=$_POST["TokenAmoint"];
					$pricewithcoin=$_POST["pricecoin"];
					if(($pricewithcoin*$buytokenamoun)!=$sellcoinamount){
						$sellcoinamount=$pricewithcoin*$buytokenamoun;
					}
					//unset($_POST["pricecoin"]);
					//unset($_POST["TokenAmoint"]);
					//unset($_POST["coinamount"]);

					
					
					if ($stmt = $conn->prepare("SELECT * FROM swcoinvstokenbidstable WHERE selltokencode=? and selltokenissuer=? and buycoincode=? and pricewithcoin=? and stpubkeyseller!=? and coinkeybuyer!=?")) {
					 
						// Bind a variable to the parameter as a string. 
						$stmt->bind_param("ssssss", $buytokencode,$assetissuer,$sellcoincode,$pricewithcoin,$stpubkeyseller,$coinkeyseller);
					 
						// Execute the statement.
						$result=$stmt->execute();
					    $result = $stmt->get_result();

					   /* Get the number of rows */
					   $num_of_rows = $result->num_rows;
					   $getout=false;
					   $stillneeded==false;
						if($num_of_rows>0){
							
							while (($row = $result->fetch_assoc()) && $getout==false) {
								$bidtswidbids=$row['swidbids'];
								$bidtstseckeyseller=$row['stseckeyseller'];
								$bidtstpubkeyseller=$row['stpubkeyseller'];
								$bidtselltokencode=$row['selltokencode'];
								$bidtselltokenissuer=$row['selltokenissuer'];
								$bidtbuycoincode=$row['buycoincode'];
								$bidtcoinkeybuyer=$row['coinkeybuyer'];
								$bidtcoinapi=$row['coinapi'];
								$bidtcoinpin=$row['coinpin'];
								$bidtselltokenamount=$row['selltokenamount'];
								$bidtbuycoinmoun=$row['buycoinmoun'];
								$bidtpricewithcoin=$row['pricewithcoin'];
								
								if($sellcoinamount>=$bidtbuycoinmoun){
									
									/*$coinnum= $_POST["mychosencoin"];
									$assetcode =$_POST["inputcode"];
									$assetissuer=$_POST["inputissuer"];
									//$assetlogo=$_POST["inputlogo"];
									$stseckeyseller=$_SESSION["secretkey"];
									$stpubkeyseller=$_SESSION["publickey"];
									$sellcoincode=$_SESSION["allcoins"][$coinnum]["code"];
									$buytokencode=$assetcode;
									$coinkeyseller=$_SESSION["allcoins"][$coinnum]["swcoinkey"];
									$coinapi=$_SESSION["allcoins"][$coinnum]["swbtcapi"];
									$coinpin=$_SESSION["swpin"];
									$sellcoinamount=$_POST["coinamount"];
									$buytokenamoun=$_POST["TokenAmoint"];
									$pricewithcoin=$_POST["pricecoin"];*/
									
									$sellcoinamount=$sellcoinamount-$bidtbuycoinmoun;
									$buytokenamoun=$buytokenamoun-$bidtselltokenamount;
									//echo $buytokenamoun;									echo "<br>";
									//do transaction 
									
										/////send lumens
								$results=sendpayment($coinapi,$coinpin,$coinkeyseller,$bidtcoinkeybuyer,$bidtbuycoinmoun);
									if(substr ( $results , 0 , 6)=="Failed"){
										$transactionstatus= $results;
										$getout=true;
										$stillneeded=true;
										
										/// leave it under test we don't know if fail is only coince
									
										
									}else{
									
									
									?>
									
									<script>
									
									var seckey="<?php echo $bidtstseckeyseller;?>";
									var pbkeydistination="<?php echo $stpubkeyseller;?>";
									var amount="<?php echo $bidtselltokenamount;?>";
									var assetcode="<?php echo $buytokencode;?>";
									var assetissuer="<?php echo $assetissuer;?>";
									sendpayments(seckey,pbkeydistination,amount,assetcode,assetissuer);
									</script>
									
									<?php
									
									
									$transactionstatus="transaction has been proceeded successfully.";
									//update database bid table by deleting row
									
									if ($stmtdelete = $conn->prepare("DELETE FROM swcoinvstokenbidstable WHERE swidbids = ?")) {
									 
										// Bind the variable to the parameter as a string. 
										$stmtdelete->bind_param("s", $bidtswidbids);
									 
										// Execute the statement.
										$stmtdelete->execute();
									 
										// Close the prepared statement.
										$stmtdelete->close();
										
										//tbale of history
										if ($stmthistory = $conn->prepare("INSERT INTO swtradedhestory (swsctkeystellseller,swsctkeystellbuyer,swcodesell,
												swcodebuy,swtokenamount,swcoinamount,swpriceincoin,date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
										 
											// Bind the variables to the parameter as strings. 
											//s means string ss means two string .. etc .... protected from sql injection
											$todaydate=date("Y-m-d");
											$stmthistory->bind_param("ssssssss", $stseckeyseller, $bidtstseckeyseller, $sellcoincode, $buytokencode, $bidtselltokenamount, $bidtbuycoinmoun, $pricewithcoin,$todaydate);//
										 
											// Execute the statement.
											if($stmthistory->execute()){
												
												$stmthistory->close();
												//header('Location: stellarSwap-login-account.php');
												
											}else{
												
												$stmthistory->close();
											}
										
									 
									}
									
										
									 
									}
									if($sellcoinamount==$bidtbuycoinmoun){
										$getout=true;
										$stillneeded=true;
									}
								}
									
								
								}else{
									$getout=true;
									$stillneeded=true;
									//my amount is less
									//echo $buytokenamoun;
									//echo "<br>";
									//echo $bidtselltokenamount;
									//print_r($results);
									$bidtbuycoinmoun=$bidtbuycoinmoun-$sellcoinamount;
									$bidtselltokenamount=$bidtselltokenamount-$buytokenamoun;
									$results=sendpayment($coinapi,$coinpin,$coinkeyseller,$bidtcoinkeybuyer,$sellcoinamount);
									if(substr ( $results , 0 , 6)=="Failed"){
										$transactionstatus= $results;
										$getout=true;
										$stillneeded=true;
									}else{
									//send lumens
									
									
									?>
									
									<script>
									
									var seckey="<?php echo $bidtstseckeyseller;?>";
									var pbkeydistination="<?php echo $stpubkeyseller;?>";
									var amount="<?php echo $buytokenamoun;?>";
									var assetcode="<?php echo $buytokencode;?>";
									var assetissuer="<?php echo $assetissuer;?>";
									sendpayments(seckey,pbkeydistination,amount,assetcode,assetissuer);
									</script>
									
									<?php
									
									
									
									 $transactionstatus="transaction has been proceeded successfully.";
									//update bid table by just update price if it's less
								
									if ($stmtupdate = $conn->prepare("UPDATE swcoinvstokenbidstable SET selltokenamount = ? , buycoinmoun = ? WHERE swidbids = ?")) {
									 
										// Bind the variables to the parameter as strings. 
										$stmtupdate->bind_param("sss", $bidtselltokenamount, $bidtbuycoinmoun,$bidtswidbids);
									 
										// Execute the statement.
										$stmtupdate->execute();
									 
										// Close the prepared statement.
										$stmtupdate->close();
										
										//tbale of history
																		
										if ($stmthistoryfinal = $conn->prepare("INSERT INTO swtradedhestory (swsctkeystellseller,swsctkeystellbuyer,swcodesell,
												swcodebuy,swtokenamount,swcoinamount,swpriceincoin,date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
										 
											// Bind the variables to the parameter as strings. 
											//s means string ss means two string .. etc .... protected from sql injection
											$todaydate=date("Y-m-d");
											$stmthistoryfinal->bind_param("ssssssss", $stseckeyseller, $bidtstseckeyseller, $sellcoincode, $buytokencode, $buytokenamoun, $sellcoinamount, $pricewithcoin,$todaydate);//
										 
											// Execute the statement.
											if($stmthistoryfinal->execute()){
												$errormessage="Great has been created";
												$stmthistoryfinal->close();
												//header('Location: stellarSwap-login-account.php');
												
											}else{
												$errormessage="done.";
												$stmthistoryfinal->close();
											}
												}
									 
									}
									}
								}
							 }
						}

						if($stillneeded==false){
																	
							if ($stmtinsertend = $conn->prepare("INSERT INTO swcoinvstokenaskstable (stseckeyseller,stpubkeyseller,sellcoincode,
								buytokencode,buytokenissuer,coinkeyseller,coinapi,coinpin,sellcoinamount,buytokenamoun,pricewithcoin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
						 
							// Bind the variables to the parameter as strings. 
							//s means string ss means two string .. etc .... protected from sql injection
							$stmtinsertend->bind_param("sssssssssss", $stseckeyseller, $stpubkeyseller, $sellcoincode, $buytokencode, $assetissuer, $coinkeyseller, $coinapi, $coinpin,$sellcoinamount,$buytokenamoun,$pricewithcoin);//
						 
							// Execute the statement.
							if($stmtinsertend->execute()){
								$transactionstatus="offer has been added to the board successfully";
								$stmtinsertend->close();
								//header('Location: stellarSwap-login-account.php');
								
							}else{
								$transactionstatus="Error try again";
								$stmtinsertend->close();
							}
						 
						}
						}
					   

					   /* free results */
					   $stmt->free_result();

					   /* close statement */
					   $stmt->close();
					 
					
					}
					
		}
}
					

//////////////////////////////// transaction for bid table
if(isset($_POST["pricecoinb"])&&isset($_POST["TokenAmointb"])&&isset($_POST["coinamountb"])){
		if(!empty($_POST["pricecoinb"])&&!empty($_POST["TokenAmointb"])&&!empty($_POST["coinamountb"])){
					/////////////////
					$coinnum= $_POST["mychosencoin"];
					$assetcode =$_POST["inputcode"];
					$assetissuer=$_POST["inputissuer"];
					//$assetlogo=$_POST["inputlogo"];
					$stseckeyseller=$_SESSION["secretkey"];
					$stpubkeyseller=$_SESSION["publickey"];
					$buycoincode=$_SESSION["allcoins"][$coinnum]["code"];
					$selltokencode=$assetcode;
					$coinkeybuyer=$_SESSION["allcoins"][$coinnum]["swcoinkey"];
					$coinapi=$_SESSION["allcoins"][$coinnum]["swbtcapi"];
					$coinpin=$_SESSION["swpin"];
					$buycoinamount=$_POST["coinamountb"];
					$selltokenamoun=$_POST["TokenAmointb"];
					$pricewithcoin=$_POST["pricecoinb"];
					if(($pricewithcoin*$selltokenamoun)!=$buycoinamount){
						$buycoinamount=$pricewithcoin*$selltokenamoun;
					}
					//$_POST["pricecoinb"]="";
					//$_POST["TokenAmointb"]="";
					//$_POST["coinamountb"]="";
					/*unset($_POST["pricecoinb"]);
					unset($_POST["TokenAmointb"]);
					unset($_POST["coinamountb"]);*/
					//echo "free".$_POST["coinamountb"];
					
					
					/*echo  $_POST["mychosencoin"];
					echo '<br>';
					echo $_POST["inputcode"];
					echo '<br>';
					echo $_POST["inputissuer"];
					echo '<br>';
					//$assetlogo=$_POST["inputlogo"];
					echo $_SESSION["secretkey"];
					echo '<br>';
					echo $_SESSION["publickey"];
					echo '<br>';
					echo $_SESSION["allcoins"][$coinnum]["code"];
					echo '<br>';
					echo $assetcode;
					echo '<br>';
					echo $_SESSION["allcoins"][$coinnum]["swcoinkey"];
					echo '<br>';
					echo $_SESSION["allcoins"][$coinnum]["swbtcapi"];
					echo '<br>';
					echo $_SESSION["swpin"];
					echo '<br>';
					echo $_POST["coinamountb"];
					echo '<br>';
					echo $_POST["TokenAmointb"];
					echo '<br>';
					echo $_POST["pricecoinb"];*/
					

					if($stmt = $conn->prepare("SELECT * FROM swcoinvstokenaskstable WHERE stpubkeyseller!=? and sellcoincode=? and buytokencode=? and buytokenissuer=? and coinkeyseller!=? and pricewithcoin=? ")) {

						// Bind a variable to the parameter as a string. 
						$stmt->bind_param("ssssss", $stpubkeyseller,$buycoincode,$selltokencode,$assetissuer,$coinkeybuyer,$pricewithcoin);
					 
						// Execute the statement.
						$result=$stmt->execute();
						
					    $result = $stmt->get_result();
						

					   /* Get the number of rows */
					   $num_of_rows = $result->num_rows;
					   $getout=false;
					   $stillneeded==false;
						if($num_of_rows>0){
							//$row = $result->fetch_assoc();
																
							while (($row = $result->fetch_assoc()) && $getout==false) {
								//print_r($row);		
								$asktswidasks=$row['swidasks'];
								//echo "cw".$row['swidasks'];
								$asktstseckeyseller=$row['stseckeyseller'];
								//echo "csw".$row['buytokenamoun'];
								$asktstpubkeyseller=$row['stpubkeyseller'];
								$asktsellcoincode=$row['sellcoincode'];
								$asktbuytokencode=$row['buytokencode'];
								$asktbuytokenissuer=$row['buytokenissuer'];
								$asktcoinkeyseller=$row['coinkeyseller'];
								$asktcoinapi=$row['coinapi'];
								$asktcoinpin=$row['coinpin'];
								$asktsellcoinamount=$row['sellcoinamount'];
								$asktbuytokenamoun=$row['buytokenamoun'];
								$asktpricewithcoin=$row['pricewithcoin'];
								
								if($buycoinamount>=$asktsellcoinamount){
									/*$coinnum= $_POST["mychosencoin"];
									$assetcode =$_POST["inputcode"];
									$assetissuer=$_POST["inputissuer"];
									//$assetlogo=$_POST["inputlogo"];
									$stseckeyseller=$_SESSION["secretkey"];
									$stpubkeyseller=$_SESSION["publickey"];
									$buycoincode=$_SESSION["allcoins"][$coinnum]["code"];
									$selltokencode=$assetcode;
									$coinkeybuyer=$_SESSION["allcoins"][$coinnum]["swcoinkey"];
									$coinapi=$_SESSION["allcoins"][$coinnum]["swbtcapi"];
									$coinpin=$_SESSION["swpin"];
									$buycoinamount=$_POST["coinamount"];
									$selltokenamoun=$_POST["TokenAmoint"];
									$pricewithcoin=$_POST["pricecoin"];*/
													
									
									$buycoinamount=$buycoinamount-$asktsellcoinamount;
									$selltokenamoun=$selltokenamoun-$asktbuytokenamoun;
									$results=sendpayment($asktcoinapi,$asktcoinpin,$asktcoinkeyseller,$coinkeybuyer,$asktsellcoinamount);
									if(substr ( $results , 0 , 6)=="Failed"){
										$transactionstatusb= $results;
										$getout=true;
										$stillneeded=true;
									
										/// leave it under test we don't know if fail is only coince
										
									}else{
									//do transaction 
										?>
									
									<script>
									
									var seckey="<?php echo $stseckeyseller;?>";
									var pbkeydistination="<?php echo $asktstpubkeyseller;?>";
									var amount="<?php echo $asktbuytokenamoun;?>";
									var assetcode="<?php echo $selltokencode;?>";
									var assetissuer="<?php echo $assetissuer;?>";
									sendpayments(seckey,pbkeydistination,amount,assetcode,assetissuer);
									</script>
									
									<?php
									$transactionstatusb="transaction has been proceeded successfully.";
									//update database bid table by deleting row
									
									if ($stmtdelete = $conn->prepare("DELETE FROM swcoinvstokenaskstable WHERE swidasks = ?")) {
									 
										// Bind the variable to the parameter as a string. 
										$stmtdelete->bind_param("s", $asktswidasks);
									 
										// Execute the statement.
										$stmtdelete->execute();
									 
										// Close the prepared statement.
										$stmtdelete->close();
										
										if ($stmthistoryfinal = $conn->prepare("INSERT INTO swtradedhestory (swsctkeystellseller,swsctkeystellbuyer,swcodesell,
												swcodebuy,swtokenamount,swcoinamount,swpriceincoin,date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
										 
											// Bind the variables to the parameter as strings. 
											//s means string ss means two string .. etc .... protected from sql injection
											$todaydate=date("Y-m-d");

											$stmthistoryfinal->bind_param("ssssssss", $stseckeyseller, $asktstseckeyseller, $buycoincode, $selltokencode, $asktbuytokenamoun, $asktsellcoinamount, $pricewithcoin,$todaydate);//
										 
											// Execute the statement.
											if($stmthistoryfinal->execute()){
												$errormessage="Great has been created";
												$stmthistoryfinal->close();
												//header('Location: stellarSwap-login-account.php');
												
											}else{
												$errormessage="done.";
												$stmthistoryfinal->close();
											}
												}
									 
									}
									
									
									
									if($buycoinamount==$asktsellcoinamount){
										$getout=true;
										$stillneeded=true;
									}
								}
									
								}else{
									$getout=true;
									$stillneeded=true;
									//my amount is less
									$asktsellcoinamount=$asktsellcoinamount-$buycoinamount;
									$asktbuytokenamoun=$asktbuytokenamoun-$selltokenamoun;
									//do transation
									$results=sendpayment($asktcoinapi,$asktcoinpin,$asktcoinkeyseller,$coinkeybuyer,$buycoinamount);
									if(substr ( $results , 0 , 6)=="Failed"){
										$transactionstatus= $results;
										$getout=true;
										$stillneeded=true;
									
										/// leave it under test we don't know if fail is only coince
									
										
									}else{
									//do transaction 
											?>
									
									<script>
									
									var seckey="<?php echo $stseckeyseller;?>";
									var pbkeydistination="<?php echo $asktstpubkeyseller;?>";
									var amount="<?php echo $selltokenamoun;?>";
									var assetcode="<?php echo $selltokencode;?>";
									var assetissuer="<?php echo $assetissuer;?>";
									sendpayments(seckey,pbkeydistination,amount,assetcode,assetissuer);
									</script>
									
									<?php
									$transactionstatusb="transaction has been proceeded successfully.";
									//update bid table by just update price if it's less
								//echo $asktswidasks;
								//echo "<br>";
								//echo $asktsellcoinamount;
								//echo "<br>";
								//echo $asktbuytokenamoun;
									if ($stmtupdate = $conn->prepare("UPDATE swcoinvstokenaskstable SET sellcoinamount = ? , buytokenamoun = ? WHERE swidasks = ?")) {
									 
										// Bind the variables to the parameter as strings. 
										$stmtupdate->bind_param("sss", $asktsellcoinamount, $asktbuytokenamoun,$asktswidasks);
									 
										// Execute the statement.
										$stmtupdate->execute();
									 
										// Close the prepared statement.
										$stmtupdate->close();
										
										if ($stmthistoryfinals = $conn->prepare("INSERT INTO swtradedhestory (swsctkeystellseller,swsctkeystellbuyer,swcodesell,
												swcodebuy,swtokenamount,swcoinamount,swpriceincoin,date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
										 
											// Bind the variables to the parameter as strings. 
											//s means string ss means two string .. etc .... protected from sql injection
											$todaydate=date("Y-m-d");

											$stmthistoryfinals->bind_param("ssssssss", $stseckeyseller, $asktstseckeyseller, $buycoincode, $selltokencode, $selltokenamoun, $buycoinamount, $pricewithcoin,$todaydate);//
										 
											// Execute the statement.
											if($stmthistoryfinals->execute()){
												$errormessage="Great has been created";
												$stmthistoryfinals->close();
												//header('Location: stellarSwap-login-account.php');
												
											}else{
												$errormessage="done.";
												$stmthistoryfinals->close();
											}
												}
									 
									}
								}
								}
							 }
						}

						if($stillneeded==false){
							if ($stmtinsertend = $conn->prepare("INSERT INTO swcoinvstokenbidstable (stseckeyseller,stpubkeyseller,selltokencode,
								selltokenissuer,buycoincode,coinkeybuyer,coinapi,coinpin,selltokenamount,buycoinmoun,pricewithcoin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {
						
							// Bind the variables to the parameter as strings. 
							//s means string ss means two string .. etc .... protected from sql injection
							$stmtinsertend->bind_param("sssssssssss", $stseckeyseller, $stpubkeyseller,$selltokencode,$assetissuer,$buycoincode,$coinkeybuyer,$coinapi,$coinpin,$selltokenamoun,$buycoinamount,$pricewithcoin );//

							// Execute the statement.
							if($stmtinsertend->execute()){
								$transactionstatusb="offer has been added to the board successfully";
								$stmtinsertend->close();
								//header('Location: stellarSwap-login-account.php');
								
								
							}else{
								$transactionstatusb="error try again";
								$stmtinsertend->close();
							}
						 
						}
						}
					   

					   /* free results */
					   $stmt->free_result();

					   /* close statement */
					   $stmt->close();
					   
					 
					}
		}
}

if(isset($_POST["myofferidasks"])){
	//myofferid
		if ($stmtdelete = $conn->prepare("DELETE FROM swcoinvstokenaskstable WHERE swidasks = ?")) {
				$deleteofferask=$_POST["myofferidasks"];					 
				// Bind the variable to the parameter as a string. 
				$stmtdelete->bind_param("s", $deleteofferask);
			 
				// Execute the statement.
				$stmtdelete->execute();
			 
				// Close the prepared statement.
				$stmtdelete->close();
		}
}	
if(isset($_POST["myofferidabids"])){
	//myofferid
		if ($stmtdelete = $conn->prepare("DELETE FROM swcoinvstokenbidstable WHERE swidbids = ?")) {
				$deleteofferbid=$_POST["myofferidabids"];					 
				// Bind the variable to the parameter as a string. 
				$stmtdelete->bind_param("s", $deleteofferbid);
			 
				// Execute the statement.
				$stmtdelete->execute();
			 
				// Close the prepared statement.
				$stmtdelete->close();
		}
}	
		
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Trade</title>
		<link rel="icon" href="images/Stellarswap.png"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/loader.css">
		<link rel="stylesheet" type="text/css" href="css/tooltip.css">

		 <!--  chart include -->
		<link rel="stylesheet" type="text/css" href="css/cssforChart.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>
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
								<?php 

							if(isset($_POST["mychosencoin"])&&isset($_POST["inputissuer"])&&isset($_POST["inputcode"])&&isset($_POST["inputlogo"])){
								$coinnum= $_POST["mychosencoin"];
								$assetcode =$_POST["inputcode"];
								$assetissuer=$_POST["inputissuer"];
								$assetlogo=$_POST["inputlogo"];
								//if($assetcode!="" && $assetissuer!=""){
						?>

						  <table >
						  
							<tr>
							<td><img src="<?php echo $_SESSION["allcoins"][$coinnum]["logo"];?>" alt="Stellar Swap" width="70" height="70"></td>
							<td><h3 name="coincode" id="code"><?php echo $_SESSION["allcoins"][$coinnum]["code"]; ?></h3>
							</td>
							<td><h5 name="coinissuer" id="coinissuer">issuer: by mining</h5>
							</td>
							<td><h5 id="<?php echo "asks" . $num?>"> =></h5></td>
							
							<td><img src="<?php echo $assetlogo?>" alt="Stellar Swap" width="70" height="70"></td>
							<td><h3 name="assetcode" id="assetcode"><?php echo $assetcode; ?></h3>
							</td>
							<td><h5 name="assetissuer" id="assetissuer"><?php echo "issuer: ". substr($assetissuer, 0, 4); ?></h5></td>
							</tr>
						</table>
						
						<br>

						<div class='wrapper'>
						  <canvas height='300' id='canvas' width='900'></canvas>
						</div>
						 <div class="posts" style="color:black;">
						 <article>
							 <form method="post" action="stellarSwap-tradecoinvstoken.php">
								<h3>Sell:</h3>
								Price(in <?php echo $_SESSION["allcoins"][$coinnum]["code"];?>): <input type="text" id="pricecoin" onkeydown="calculatesells(1)" name="pricecoin" placeholder="<?php echo "Price in ".$_SESSION["allcoins"][$coinnum]["code"]; ?>" required>
								<br>
								<br>
								<?php echo $assetcode;?> Amount: <input type="text" id="TokenAmoint" onkeydown="calculatesells(2)" name="TokenAmoint" placeholder="<?php echo $assetcode." Amount. available :"; ?>" required>
								<br>
								<br>
								 <?php echo $_SESSION["allcoins"][$coinnum]["code"];?> amount: <input type="text" id="coinamount" onkeydown="calculatesells(3)" name="coinamount" placeholder="<?php echo $_SESSION["allcoins"][$coinnum]["code"]." Amount. available :"; ?>" required>
								<br><br>
								
								<div style="display:none;" id="loader" class="loader"></div>
								<p style="display:hidden;" id="msgofload"></p>
								<p><?php echo $transactionstatus;?></p>
								
								<input type="hidden" name="mychosencoin" value="<?php echo $coinnum; ?>">
								<input type="hidden" name="inputcode" value="<?php echo $assetcode; ?>">
								<input type="hidden" name="inputissuer" value="<?php echo $assetissuer; ?>">
								<input type="hidden" name="inputlogo" value="<?php echo $assetlogo; ?>">
								
								<input type="submit" id="submitsell" onclick="addtheofferTokenNative()" value="Submit">
							  </form>
							  </article>
							 <article>  
							  <form method="post" action="stellarSwap-tradecoinvstoken.php">
								<h3>buy:</h3>
								Price(in <?php echo $_SESSION["allcoins"][$coinnum]["code"];?>): <input type="text" id="pricecoinb" onkeydown="calculatesbuy(1)" name="pricecoinb" placeholder="<?php echo "Price in ".$_SESSION["allcoins"][$coinnum]["code"]; ?>" required>
								<br>
								<br>
								<?php echo $assetcode;?> Amount: <input type="text" id="TokenAmointb" onkeydown="calculatesbuy(2)" name="TokenAmointb" placeholder="<?php echo $assetcode." Amount. available :"; ?>" required>
								<br>
								<br>
								<?php echo $_SESSION["allcoins"][$coinnum]["code"];?> amount: <input type="text" style="color:black;width: 200px;" class="input-field" id="coinamountb" onkeydown="calculatesbuy(3)" name="coinamountb" placeholder="<?php echo $_SESSION["allcoins"][$coinnum]["code"]." Amount. available :"; ?>" required>
								<br><br>
								<div style="display:none;" id="loader2" class="loader"></div>
								<p style="display:hidden;" id="msgofload2"></p>
								<p><?php echo $transactionstatusb;?></p>
								
								<input type="hidden" name="mychosencoin" value="<?php echo $coinnum; ?>">
								<input type="hidden" name="inputcode" value="<?php echo $assetcode; ?>">
								<input type="hidden" name="inputissuer" value="<?php echo $assetissuer; ?>">
								<input type="hidden" name="inputlogo" value="<?php echo $assetlogo; ?>">
								
								<input type="submit" class="link-style" id="submitbuy" onclick="addtheofferNativeToken()" value="Submit">
								</form>
							 </article>
						 </div> 
						  
						  <!-- tables -->
						 <div class="posts" style="color:black;">
						 <article>
						  <h3>Buy offers:</h3>
						  <table id="bidstab" bgcolor="40ff00" style="color:black; cursor: pointer;background:#32CD32;" >
							<tr>
								<td><?php echo $_SESSION["allcoins"][$coinnum]["code"];?> amount</td>
								<td><?php echo $assetcode. " amount";?></td>
								<td>Price</td>
							</tr>
							
							
							<?php 
							if ($stmt = $conn->prepare("SELECT selltokencode,buycoincode,selltokenamount,buycoinmoun,pricewithcoin FROM swcoinvstokenbidstable WHERE selltokencode=? and buycoincode=? and selltokenissuer=? ORDER BY pricewithcoin ASC")) {
									// Bind a variable to the parameter as a string. 
									
									$coincode=$_SESSION["allcoins"][$coinnum]["code"];
									
									$stmt->bind_param("sss", $assetcode,$coincode,$assetissuer);
									$result=$stmt->execute();
								  $result = $stmt->get_result();
								   $num_of_rows = $result->num_rows;
								   $counting=0;
									if($num_of_rows>0){
										while ($row = $result->fetch_assoc()) {
									
							?>
							<tr>
								<td><?php echo $row["buycoinmoun"];?></td>
								<td><?php echo $row["selltokenamount"];?></td>
								<td><?php echo $row["pricewithcoin"];?></td>
							</tr>
							<?php $counting++;}
									}
									/* free results */
								   $stmt->free_result();

								   /* close statement */
								   $stmt->close();
								   }?>
						  </table>
						 </article>
						 <article>
						<h3>Sell offers:</h3>
						  <table id="askstab" bgcolor="#ff8080" style="color:black; cursor: pointer;background:#FF0000;">
							<tr>
							  <td>Price</td>
							<td><?php echo $assetcode. " amount";?></td>
							<td><?php echo $_SESSION["allcoins"][$coinnum]["code"];?> amount</td>
							</tr>
							
							
							<?php 
							if ($stmt = $conn->prepare("SELECT sellcoincode,buytokencode,sellcoinamount,buytokenamoun,pricewithcoin FROM swcoinvstokenaskstable WHERE sellcoincode=? and buytokencode=? and buytokenissuer=? ORDER BY pricewithcoin ASC")) {
									// Bind a variable to the parameter as a string. 
									
									$coincode=$_SESSION["allcoins"][$coinnum]["code"];
									
									$stmt->bind_param("sss", $coincode,$assetcode,$assetissuer);
									$result=$stmt->execute();
								  $result = $stmt->get_result();
								   $num_of_rows = $result->num_rows;
									if($num_of_rows>0){
										while ($row = $result->fetch_assoc()) {
											
							?>
							<tr>
							  <td><?php echo $row["sellcoinamount"];?></td>
								<td><?php echo $row["buytokenamoun"];?></td>
								<td><?php echo $row["pricewithcoin"];?></td>
							</tr>
							<?php }
									}
									/* free results */
								   $stmt->free_result();

								   /* close statement */
								   $stmt->close();
								   }?>
							
						  </table>
						 </article>
						</div>
					<div class="posts" style="color:black;">
					<article>	  
						<h3>My sell(asks) offers:</h3>
						  <table id="youroffertab" style="color:black; background:#FF0000;" >
							<tr>
							<td><?php echo $_SESSION["allcoins"][$coinnum]["code"];?> amount</td>
							<td><?php echo $assetcode. " amount";?></td>
							<td>Price</td>
							<td>Cancel offer</td>
							</tr>
							<?php 
							if ($stmt = $conn->prepare("SELECT swidasks,sellcoincode,buytokencode,sellcoinamount,buytokenamoun,pricewithcoin FROM swcoinvstokenaskstable WHERE stpubkeyseller=? and sellcoincode=? and buytokencode=? and buytokenissuer=?")) {
									// Bind a variable to the parameter as a string. 
									
									//$coincode=$_SESSION["allcoins"][$coinnum]["code"];
									$coincode=$_SESSION["allcoins"][$coinnum]["code"];
									$stmt->bind_param("ssss", $_SESSION['publickey'],$coincode,$assetcode,$assetissuer);
									$result=$stmt->execute();
								  $result = $stmt->get_result();
								   $num_of_rows = $result->num_rows;
									if($num_of_rows>0){
										while ($row = $result->fetch_assoc()) {
											
							?>
							<tr>
							<td><?php echo $row["sellcoinamount"];?></td>
								<td><?php echo $row["buytokenamoun"];?></td>
								<td><?php echo $row["pricewithcoin"];?></td>
							<form method="post" action="stellarSwap-tradecoinvstoken.php">	
							<input type="hidden" name="myofferidasks" value="<?php echo $row["swidasks"]; ?>">
							<input type="hidden" name="mychosencoin" value="<?php echo $coinnum; ?>">
							<input type="hidden" name="inputcode" value="<?php echo $assetcode; ?>">
							<input type="hidden" name="inputissuer" value="<?php echo $assetissuer; ?>">
							<input type="hidden" name="inputlogo" value="<?php echo $assetlogo; ?>">
							<td><input class="button special" type="submit" value="Cancel offer"></td>
							 </form>
							</tr>
							<?php }
									}
									/* free results */
								   $stmt->free_result();

								   /* close statement */
								   $stmt->close();
								   }?>
						  </table>
						 </article>
						 <article>
						 <h3>My buy(bids) offers:</h3>
						  <table id="youroffertabbids" style="color:black; background:#32CD32;" >
							<tr>
							<td><?php echo $_SESSION["allcoins"][$coinnum]["code"];?> amount</td>
							<td><?php echo $assetcode. " amount";?></td>
							<td>Price</td>
							<td>Cancel offer</td>
							
							<?php 
							if ($stmt = $conn->prepare("SELECT swidbids,selltokencode,buycoincode,selltokenamount,buycoinmoun,pricewithcoin FROM swcoinvstokenbidstable WHERE stpubkeyseller=? and selltokencode=? and buycoincode=? and selltokenissuer=?")) {
									// Bind a variable to the parameter as a string. 
									
									//$coincode=$_SESSION["allcoins"][$coinnum]["code"];
									$stmt->bind_param("ssss",$_SESSION['publickey'],$assetcode,$coincode,$assetissuer);
									$result=$stmt->execute();
								  $result = $stmt->get_result();
								   $num_of_rows = $result->num_rows;
									if($num_of_rows>0){
										
										while ($row = $result->fetch_assoc()) {
											
									?>
							<tr>
								<td><?php echo $row["buycoinmoun"];?></td>
								<td><?php echo $row["selltokenamount"];?></td>
								<td><?php echo $row["pricewithcoin"];?></td>
								<form method="post" action="stellarSwap-tradecoinvstoken.php">	
								<input type="hidden" name="myofferidabids" value="<?php echo $row["swidbids"]; ?>">
								<input type="hidden" name="mychosencoin" value="<?php echo $coinnum; ?>">
								<input type="hidden" name="inputcode" value="<?php echo $assetcode; ?>">
								<input type="hidden" name="inputissuer" value="<?php echo $assetissuer; ?>">
								<input type="hidden" name="inputlogo" value="<?php echo $assetlogo; ?>">
								<td><input class="button special" type="submit" value="Cancel offer"></td>
								 </form>
							</tr>
							<?php }
									}
									/* free results */
								   $stmt->free_result();

								   /* close statement */
								   $stmt->close();
								   }?>
							
							</tr>
						  </table>
						 </article> 
						 </div>
						 <div style="color:black;">
						 <h3>Recent trades:</h3>
						  <table id="alltrads" style="color:black;" >
							<tr>
								 <td><?php echo $_SESSION["allcoins"][$coinnum]["code"];?> amount</td>
								 <td><?php echo $assetcode . " amount";?></td>
								 <td>Price</td>
								 <td>Date</td>
								 
								<?php 
						  
						  //error_reporting(E_ERROR | E_PARSE);

							if ($stmt = $conn->prepare("SELECT 	swcodesell,swcodebuy,swtokenamount,swcoinamount,swpriceincoin,date FROM swtradedhestory WHERE swcodesell=? and swcodebuy=? " )) {
									// Bind a variable to the parameter as a string. 
									
									//$coincode=$_SESSION["allcoins"][$coinnum]["code"];
									
									$coincode=$_SESSION["allcoins"][$coinnum]["code"];
									
									$stmt->bind_param("ss", $coincode,$assetcode);
									$result=$stmt->execute();
								  $result = $stmt->get_result();
								   $num_of_rows = $result->num_rows;
									if($num_of_rows>0){
										$countrowhistory=0;
										while ($row = $result->fetch_assoc()) {
										$datahistory[$countrowhistory]=$row["swpriceincoin"];
										$countrowhistory++;
						  ?>
							<tr>
						  <td><?php echo $row["swcoinamount"]; ?></td>
							<td><?php echo $row["swtokenamount"]?></td>
							 <td><?php echo $row["swpriceincoin"]; ?></td>
							 <td><?php echo $row["date"];?></td>
							 
							</tr>
							<?php }
									}
									/* free results */
								   $stmt->free_result();

								   /* close statement */
								   $stmt->close();
								   }?>
					
							</tr>
						  </table>			
						</div>
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
<!-- javascript -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--  <script src='http://cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js'></script> -->
 <script src='js/chart.js'></script>
<script>

var datahistory=[];
<?php for($i=0;$i<sizeof($datahistory);$i++){ ?>
datahistory[<?php echo $i;?>]=<?php echo $datahistory[$i];?>;
<?php }?>

var myData = {
		  labels : ["","","","","","","","","","",""],
		  //labels :datalabs,
		  datasets : [
			{
			  fillColor : "rgba(0,0,220,.5)",
			  strokeColor : "rgba(0,0,220,1)",
			  pointColor : "rgba(0,0,220,1)",
			  pointStrokeColor : "#fff",
			  //data : [1,0.6,0.5,0.4,0.1,0.4,1]
			  data :datahistory.reverse()
			  //data : [resp["bids"][1]["price"],resp["bids"][2]["price"],resp["bids"][4]["price"]]
			},
		  ]
		}
		new Chart(document.getElementById("canvas").getContext("2d")).Line(myData)


/////////////////////// calculate the seel and buy input amount

function calculatesells(clicked_id){
	//alert(clicked_id);
	if(clicked_id==1){
		var pricexlm=document.getElementById("pricecoin").value;
		var amountofToken=document.getElementById("TokenAmoint").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("coinamount").value=xmlamountres;
	}
	 
	if(clicked_id==2){
		var pricexlm=document.getElementById("pricecoin").value;
		var amountofToken=document.getElementById("TokenAmoint").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("coinamount").value=xmlamountres;
	}
	if(clicked_id==3){
		var pricexlm=document.getElementById("pricecoin").value;
		var amountofxlm=document.getElementById("coinamount").value
		var tokenamountres=amountofxlm/pricexlm;
		document.getElementById("TokenAmoint").value=tokenamountres;
	}
}
function calculatesbuy(clicked_id){
	//alert(clicked_id);
	if(clicked_id==1){
		var pricexlm=document.getElementById("pricecoinb").value;
		var amountofToken=document.getElementById("TokenAmointb").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("coinamountb").value=xmlamountres;
	}
	 
	if(clicked_id==2){
		var pricexlm=document.getElementById("pricecoinb").value;
		var amountofToken=document.getElementById("TokenAmointb").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("coinamountb").value=xmlamountres;
	}
	if(clicked_id==3){
		var pricexlm=document.getElementById("pricecoinb").value;
		var amountofxlm=document.getElementById("coinamountb").value
		var tokenamountres=amountofxlm/pricexlm;
		document.getElementById("TokenAmointb").value=tokenamountres;
	}
}




/////////////////////////////
</script>
<?php 
	}else{
		header('Location: stellarSwap-market.php');
	}
			}else{
				header('Location: stellarSwap-market.php');
			}
		}else{
			header('Location: stellarSwap-market.php');
		}
?>
</body>
</html>
