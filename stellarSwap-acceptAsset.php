<?php 
	
	include("stellarSwap-session.php");
	include("stellarSwap-assetTokens.php");
	//echo $_SESSION["secretkey"];
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Accept asset</title>
		<link rel="icon" href="images/Stellarswap.png"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/loader.css">
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
								<h2 class="title">Add trust line:</h2>
								<h4>tips : "to delete a trust line write the asset code and the asset issuer and set the Alount 0"</h4> <br>
								<div>
								<h4>Asset code :</h4><input id="assetcode" type="text"  placeholder="(example: BTC)" name="assetcode"  required>
								<h4>Asset issuer :</h4><input id="assetissuer" type="text"  placeholder="Secret key (example: GLKKJSL3HDB7N4EI3QKBKI4D5ZDSSDF7TMPB.....)" name="assetissuer"  required>
								<h4>Amount :</h4><input id="amount" type="number"  name="amount"  required></br>
								<p id="message"></p>
								<input type="button" id="acceptasset" onclick="trustasset()" value="Accept">
								<input type="button" id="dalaettrust" onclick="removetrustasset()" value="Remove trust line">
								<p id="infoasset"></p>
								</div>
								
								
								<h2>Listed Assets:</h2>
								<div class="table-wrapper">
								<table>
								<?php for($i=0;$i<sizeof($asset_tokes);$i++){ ?>
								<tr>
								<td><img src="<?php echo $asset_tokes[$i]["logo"];?>" alt="Stellar Swap" width="70" height="70"><h5 style="color:#000"><?php echo $asset_tokes[$i]["domain"]; ?></h5></td>
								<td><h3 id="<?php echo "code" . $i?>"><?php echo $asset_tokes[$i]["code"]; ?></h3></td>
								<td><h6 id="<?php echo "issuer" . $i?>"><?php echo $asset_tokes[$i]["issuer"]; ?></h6></td>
								
								<?php 
								for($j=0;$j<sizeof($asset_alreadyaccepted);$j++){
									if($asset_alreadyaccepted[$j]["code"]==$asset_tokes[$i]["code"] &&$asset_alreadyaccepted[$j]["issuer"]==$asset_tokes[$i]["issuer"]){
										
										$exsistens=true;
										$j=sizeof($asset_alreadyaccepted)+2;
									}else{
										$exsistens=false;
									}
								}
								if($exsistens==false){?>
								<td><input id="<?php echo "" . $i?>" type="button" onclick="trustassetbtn(this.id)" value="Accept"><td>
								<?php }else{?>
								<td><input id="<?php echo "" . $i?>" disabled type="button" value="Accepted"><td>
								<?php }?>
								</tr>
								<?php } ?>
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
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script >

function trustasset() {  
	///////////////////use id best for securty ********************************************************************************
if(document.getElementById('assetcode').validity.valid==false ||
	 document.getElementById('assetissuer').validity.valid==false ||
	 document.getElementById('amount').validity.valid==false){
		alert("Please fill in the fields");
	 }else{	
	
	document.getElementById("acceptasset").setAttribute("class", "loadercancel");
	document.getElementById("acceptasset").textContent="load";
	document.getElementById("acceptasset").disabled = true;
	
	
		StellarSdk.Network.usePublicNetwork();
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		// the JS SDK uses promises for most actions, such as retrieving an account
		 var seckeypair = "<?php echo $_SESSION['secretkey']; ?>";
		 
		
		
		 var assetcode = document.getElementById("assetcode").value;
		  var assetissuer = document.getElementById("assetissuer").value;
		   var amount = document.getElementById("amount").value;
		   
	
		   var receivingKeys = StellarSdk.Keypair.fromSecret(seckeypair);

		// Create an object to represent the new asset
		var assettrust = new StellarSdk.Asset(assetcode, assetissuer);
	try{
		 server.loadAccount(receivingKeys.publicKey())
		  .then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			  // The `changeTrust` operation creates (or alters) a trustline
			  // The `limit` parameter below is optional
			  .addOperation(StellarSdk.Operation.changeTrust({
				asset: assettrust,
				limit: amount
			  }))
			  .build();
			transaction.sign(receivingKeys);
			
			var result= server.submitTransaction(transaction);
	
			//document.getElementById("message").innerHTML = ""+result;
			result.then(function (fulfilled) {
			document.getElementById("message").innerHTML = "trust line has been created";
			document.getElementById("acceptasset").setAttribute("class", "link-style");
			document.getElementById("acceptasset").textContent="accept";
			document.getElementById("acceptasset").disabled = false;
			}).catch(function (error) {
            // oops, mom don't buy it
			document.getElementById("acceptasset").setAttribute("class", "link-style");
			document.getElementById("acceptasset").textContent="accept";
			document.getElementById("acceptasset").disabled = false;
			document.getElementById("message").innerHTML = ""+error.message;
         // output: 'mom is not happy'
        });
			//console.log('Balances jdks account: ' + result.resolve().catch("ff"));
			return result;
		  })
		  
		 
	}catch(err){
		console.log('cannot: ' + err);
		document.getElementById("acceptasset").setAttribute("class", "link-style");
			document.getElementById("acceptasset").textContent="accept";
			document.getElementById("acceptasset").disabled = false;
			document.getElementById("message").innerHTML = ""+error.message;
	}
}	
}	

		
		
function removetrustasset() {
if(document.getElementById('assetcode').validity.valid==false ||
	 document.getElementById('assetissuer').validity.valid==false){
		alert("Please fill in the fields");
	 }else{	
	 document.getElementById("dalaettrust").setAttribute("class", "loadercancel");
	document.getElementById("dalaettrust").textContent="load";
	document.getElementById("dalaettrust").disabled = true;
	 
	StellarSdk.Network.usePublicNetwork();
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		// the JS SDK uses promises for most actions, such as retrieving an account
		 var seckeypair = "<?php echo $_SESSION['secretkey']; ?>";
		 
		
		
		 var assetcode = document.getElementById("assetcode").value;
		  var assetissuer = document.getElementById("assetissuer").value;
		   //var amount = document.getElementById("amount").value;
		   var amount="0";
	
		   var receivingKeys = StellarSdk.Keypair.fromSecret(seckeypair);

		// Create an object to represent the new asset
		
		
	try{
		var assettrust = new StellarSdk.Asset(assetcode, assetissuer);
		 server.loadAccount(receivingKeys.publicKey())
		  .then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			  // The `changeTrust` operation creates (or alters) a trustline
			  // The `limit` parameter below is optional
			  .addOperation(StellarSdk.Operation.changeTrust({
			  asset: assettrust,
			  limit: amount,
			  }))
			  .build();
			transaction.sign(receivingKeys);
			
			var result= server.submitTransaction(transaction);
	
			//document.getElementById("message").innerHTML = ""+result;
			result.then(function (fulfilled) {
			document.getElementById("message").innerHTML = "trust line has been deleted";
			document.getElementById("dalaettrust").setAttribute("class", "link-style");
			document.getElementById("dalaettrust").textContent="accept";
			document.getElementById("dalaettrust").disabled = false;
			}).catch(function (error) {
            // oops, mom don't buy it
			document.getElementById("message").innerHTML = "Transaction faild (some tips: check that you have 0 amount of the token to delete the trust line) "+error.message;
			document.getElementById("dalaettrust").setAttribute("class", "link-style");
			document.getElementById("dalaettrust").textContent="accept";
			document.getElementById("dalaettrust").disabled = false;
         // output: 'mom is not happy'
        });
			//console.log('Balances jdks account: ' + result.resolve().catch("ff"));
			return result;
		  })
		  
		 
	}catch(err){
		console.log('cannot: ' + err);
		document.getElementById("message").innerHTML = "Transaction faild (some tips: check that you have 0 amount of the token to delete the trust line) "+error.message;
			document.getElementById("dalaettrust").setAttribute("class", "link-style");
			document.getElementById("dalaettrust").textContent="accept";
			document.getElementById("dalaettrust").disabled = false;
	}

	}
}



/*


///////////////////////// get balance
var server = new StellarSdk.Server('https://horizon.stellar.org');
		// the JS SDK uses promises for most actions, such as retrieving an account
		 var publickeypair = "<?php echo $_SESSION['publickey']; ?>";
		 
		 var pair = StellarSdk.Keypair.fromPublicKey(publickeypair);
		server.loadAccount(pair.publicKey()).then(function(account) {
			
		  console.log('Balances for account: ' + pair.publicKey());
		  account.balances.forEach(function(balance) {
			  console.log('asset code:', balance.asset_code, ', Balance:', balance.balance);
			  var tagP = document.createElement("h4");
			  var the_asset_code=balance.asset_code;
			  the_asset_issuer=balance.asset_issuer;
			  if(the_asset_code == null && balance.asset_issuer== null){
				  the_asset_code="XLM";
				  the_asset_issuer="native";
			  }
				var txt = document.createTextNode(the_asset_code +" : "+balance.balance +"  issuer : "+the_asset_issuer.substring(0, 6));
				tagP.appendChild(txt);
				document.body.appendChild(tagP);
				document.getElementById('info').appendChild(tagP);
		  
		  });
		
		}).catch(function (error) {
            // oops, mom don't buy it
			document.getElementById("errormessage").innerHTML  = "Your account is not activated yet . activate your account by putting 5 XLM in it.";
         // output: 'mom is not happy'
        });
		


//////////////////////////////



*/















function trustassetbtn(clicked_id) {
	///////////////////use id best for securty ********************************************************************************
	document.getElementById(clicked_id).setAttribute("class", "loadercancel");
	document.getElementById(clicked_id).value="load";
	document.getElementById(clicked_id).disabled = true;
		StellarSdk.Network.usePublicNetwork();
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		// the JS SDK uses promises for most actions, such as retrieving an account
		 var seckeypair = "<?php echo $_SESSION['secretkey']; ?>";
		 
		
		 var assetcode = document.getElementById("code"+clicked_id).textContent;
		  var assetissuer = document.getElementById("issuer"+clicked_id).textContent;
		   var amount = "9000000";
		   //alert(clicked_id);
		   //alert(assetcode);
		   //alert(assetissuer);
	
		  var receivingKeys = StellarSdk.Keypair.fromSecret(seckeypair);

		// Create an object to represent the new asset
		var assettrust = new StellarSdk.Asset(assetcode, assetissuer);
	try{
		 server.loadAccount(receivingKeys.publicKey())
		  .then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			  // The `changeTrust` operation creates (or alters) a trustline
			  // The `limit` parameter below is optional
			  .addOperation(StellarSdk.Operation.changeTrust({
				asset: assettrust,
				limit: amount
			  }))
			  .build();
			transaction.sign(receivingKeys);
			
			var result= server.submitTransaction(transaction);
	
			//document.getElementById("message").innerHTML = ""+result;
			result.then(function (fulfilled) {
			document.getElementById("message").innerHTML = "trust line has been created";
			document.getElementById(clicked_id).setAttribute("class", "link-style");
			document.getElementById(clicked_id).value="Accepted";
			}).catch(function (error) {
            // oops, mom don't buy it
			
			document.getElementById(clicked_id).setAttribute("class", "link-style");
			document.getElementById(clicked_id).value="Accept";
			document.getElementById(clicked_id).disabled = false;
			document.getElementById("message").innerHTML = ""+error.message;
			alert(""+error.message);
			
         // output: 'mom is not happy'
        });
			//console.log('Balances jdks account: ' + result.resolve().catch("ff"));
			return result;
		  })
		  
		 
	}catch(err){
		console.log('error: ' + err);
	}
	
}	

</script>
</body>
</html>