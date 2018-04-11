<?php 
// error_reporting(E_ERROR | E_PARSE);

		include("../include/dbconnection.php");
		include("../include/rpcdaemonpassword.php");
		require_once('../include/easybitcoin.php');
		if ($stmt = $conn->prepare("SELECT * FROM stellarswapusers")) {
		 
			// Bind a variable to the parameter as a string. 
			// $stmt->bind_param("");
		 
			// Execute the statement.
			$result=$stmt->execute();
			$result = $stmt->get_result();

		   /* Get the number of rows */
		   $num_of_rows = $result->num_rows;
			if($num_of_rows>0){
			
				while ($row = $result->fetch_assoc()) {
					$id = $row["id"];
					if(empty($row["Row of your new coin"])){
						
						$coinconnectionrpc=initconnectionrpc("Your coin code example(BCA,BTC or BCH ... etc)");
						$coinkey=$coinconnectionrpc->getnewaddress("youcoinname".$row["swemail"]);
						//update every row
						if ($stmtupdate = $conn->prepare("UPDATE stellarswapusers SET (Row of your new coin) = ? WHERE id = ?")) {
										 
							// Bind the variables to the parameter as strings. 
							$stmtupdate->bind_param("ss", $coinkey,$id);
						 
							// Execute the statement.
							$stmtupdate->execute();
						 
							// Close the prepared statement.
							$stmtupdate->close();
							echo "success";
						}
					}
				}
			}else{
				echo "there's nothing error";
			}

		   /* free results */
		   $stmt->free_result();

		   /* close statement */
		   $stmt->close();
		 
		}


?>
