<?php 
error_reporting(E_ERROR | E_PARSE);
if(isset($_POST["walletaccount"])){
	if($_POST["walletaccount"]=="walletaccount"){
		include("include/dbconnection.php");
		$email=$_POST["email"];
		$password=$_POST["password"];
		/*$emailcoin=$_POST["emailcoin"];
		$codepin=$_POST["codepin"];
		$apicode=$_POST["apicode"];
		$btcoinkey=$_POST["btcoinkey"];
		$dogecoinkey=$_POST["dogecoinkey"];
		$litecoinkey=$_POST["litecoinkey"];*/
		
		
		if ($stmt = $conn->prepare("SELECT * FROM stellarswapusers WHERE swemail=? and swpassword=?")) {
		 
			// Bind a variable to the parameter as a string. 
			$stmt->bind_param("ss", $email,$password);
		 
			// Execute the statement.
			$result=$stmt->execute();
		 
			// Get the variables from the query.
			//$stmt->bind_result($pass);
		 
		 
		  $result = $stmt->get_result();

		   /* Get the number of rows */
		   $num_of_rows = $result->num_rows;
			if($num_of_rows>0){
			
				while ($row = $result->fetch_assoc()) {
					session_start();
					$_SESSION["secretkey"] = $row["swsecretkey"];
					$_SESSION["publickey"] = $row["swpublickey"];
					$_SESSION["SessionOnOrOff"]=1; 
					$_SESSION["walletaccount"] = $_POST["walletaccount"];
					$_SESSION["swemailcoin"] = $row["swemailcoin"];
					$_SESSION["swpin"] = $row["swpin"];

					$asset_tokes = array
					  (
					  array("logo"=>"logo/Bitcoin.png","code"=>"BTC","swcoinkey"=>$row["swbtccoinkey"],"swbtcapi"=>$row["swbtcapi"]),
					   array("logo"=>"logo/dogecoin.png","code"=>"DOGE","swcoinkey"=>$row["swdogecoinkey"],"swbtcapi"=>$row["swdogeapi"]),
					    array("logo"=>"logo/litecoin.jpg","code"=>"LTC","swcoinkey"=>$row["swlitecoinkey"],"swbtcapi"=>$row["swliteapi"])
					  );
					$_SESSION["allcoins"]=$asset_tokes;
					/*$_SESSION["swbtccoinkey"] = $row["swbtccoinkey"];
					$_SESSION["swdogecoinkey"] = $row["swdogecoinkey"];
					$_SESSION["swlitecoinkey"] = $row["swlitecoinkey"];*/
					header('Location: stellarSwap-wallet.php'); 
				}
			}else{
			
				//$_POST["error"]="Your email or password is wrong";
				header('Location: stellarSwap-login-account.php'); 
			}

		   /* free results */
		   $stmt->free_result();

		   /* close statement */
		   $stmt->close();
		 
		}

		
	}
}else{
	if(!empty($_POST["secretkey"])){
		session_start();
		$_SESSION["secretkey"] = $_POST["secretkey"];
		$_SESSION["publickey"] = $_POST["publickey"];
		$_SESSION["SessionOnOrOff"]=1; 
		
		header('Location: stellarSwap-wallet.php'); 	
	}else{
		//echo "hello".$_POST["secretkey"];
		header('Location: index.php'); 

	}	
}	
?>
