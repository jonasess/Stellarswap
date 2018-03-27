<?php
// Start the session
session_start();
if($_SESSION["SessionOnOrOff"]!=1){
header('Location: stellarSwap-login.php'); 	
}
?>
