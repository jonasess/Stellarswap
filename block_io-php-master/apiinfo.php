<?php
	require_once 'lib/block_io.php';
	try{
		////////////////////////////////////////////////first email
		$emailcoin="youremail from block.io";
		//bitcoin address
		$btcapiKey = "btc api";
		 $pin = "your pin";
		 $version = 2; // the API version to use
		 $btcblock_io = new BlockIo($btcapiKey, $pin, $version);
		  //create wallet
		$btcarrayofblock=$btcblock_io->get_new_address();
		
		//dogecoin address
		$dogeapiKey = "doge api";
		 $pin = "your pin";
		 $version = 2; // the API version to use
		 $dogeblock_io = new BlockIo($dogeapiKey, $pin, $version);
		  //create wallet
		$dogearrayofblock=$dogeblock_io->get_new_address();
		
		//litecoin address
		$liteapiKey = "ltc api";
		 $pin = "your pin";
		 $version = 2; // the API version to use
		 $liteblock_io = new BlockIo($liteapiKey, $pin, $version);
		  //create wallet
		$litearrayofblock=$liteblock_io->get_new_address();
		
		/////////////////////////////////////////////////
	}catch(Excepton $errorw){
		$errorw="there was an error creating wallet";
	}
	
?>