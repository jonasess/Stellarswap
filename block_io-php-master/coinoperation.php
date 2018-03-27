<?php 
function getbalancefromapi($api,$codepin,$myaddress,$availableORpending) {
			require_once 'lib/block_io.php';
		 $apiKey = $api;
		 $pin = $codepin;
		 $version = 2; // the API version to use
		 $block_io = new BlockIo($apiKey, $pin, $version);
			////get balances of wallet
		$myarrayofbalance=$block_io->get_address_balance(array('addresses' => $myaddress));
		//echo $block_io;
		//echo " ".$arrayofblock["data"]->address;
		//print_r($block_io->get_address_balance(array('addresses' => '2N3kPhkBTp6NTB2sUmHBo3KhRmxZBAkG8ea')));

		//$block_io->get_address_by_label(array('label' => 'LABEL'));

		if($myarrayofbalance->status=="success"){
			if($availableORpending==1){
				echo " ".$myarrayofbalance->data->balances[0]->available_balance;
			}else{
				if($availableORpending==0){
					echo " ".$myarrayofbalance->data->balances[0]->pending_received_balance;
				}
			}
			//echo " ".$myarrayofbalance->data->balances[0]->address;
			//echo " ".$myarrayofbalance["data"]->label;
		}else{
			echo " :' ";
		}
}


function sendpayment($api,$codepin,$myaddress,$destinationaddress,$amount) {
			/*require_once 'lib/block_io.php';
			echo $api;
			echo '<br>';
			echo $codepin;
			echo '<br>';
			echo $myaddress;
			echo '<br>';
			echo $destinationaddress;
			echo '<br>';
			echo $amount;*/
		require_once 'lib/block_io.php';
		 $apiKey = $api;
		 $pin = $codepin;
		 $version = 2; // the API version to use
		 $block_io = new BlockIo($apiKey, $pin, $version);
		 
		//error_reporting(E_ERROR | E_PARSE);
		//better to do test that amount is not 0;
		//withdrow
		try{
		$block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' => $myaddress, 'to_addresses' => $destinationaddress, 'pin' => $pin));
		}catch(Exception $error){
			//echo $error->getMessage();
			return $error->getMessage();
		//echo "<pre>";
		//print_r($error);
			//echo $error;
		}
}

?>