<?php 
	error_reporting(E_ERROR | E_PARSE);
	include("stellarSwap-session.php");
	include("stellarSwap-assetTokens.php");
	
	
	
	if(isset($_SESSION["walletaccount"])){
		if($_SESSION["walletaccount"]=="walletaccount"){
			include("block_io-php-master/coinoperation.php");
			if(isset($_POST["walletdesidcoin"])&&isset($_POST["thecoinn"])&&isset($_POST["amountsendcoin"])){
			
			$indexofcoin=$_POST["thecoinn"];
			$results=sendpayment($_SESSION["allcoins"][$indexofcoin]["swbtcapi"],$_SESSION["swpin"],$_SESSION["allcoins"][$indexofcoin]["swcoinkey"],$_POST["walletdesidcoin"],$_POST["amountsendcoin"]);
			if(substr ( $results , 0 , 6)=="Failed"){
				$mymessagecoin=$results;
			}else{
				$mymessagecoin="payment has been sent successfully";
				//$mymessagecoin=$results;
			}
			}
		}else{
			$mymessagecoin="Fill up all fields";
		}
	}
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Send payments</title>
		<link rel="icon" href="images/Stellarswap.png"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/loader.css">
		<link rel="stylesheet" type="text/css" href="css/tooltip.css">
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
							<h2>Send payments:</h2>
							<div>
							<?php if(isset($_SESSION["walletaccount"])){
								if($_SESSION["walletaccount"]=="walletaccount"){?>
							<div class="select-wrapper">
								<select id="choosepaymenttype" onchange="choosepaymenttype()">
								<option>none</option>
								<option>Send tokens</option>
								<option>Send coins</option>
								</select>
							</div>	
								<br>
								<div id="paymentwithcoin" hidden>
								<form method="post" action="stellarSwap-sendpayments.php">
									<h4>Wallet address: </h4><input type="text" id="walletdesidcoin"  name="walletdesidcoin" placeholder="ex: GKEZMO6YDZ6 ...." required>
									<br>
									<div class="select-wrapper">
									<select id="coinoption" onchange="getcoinamount()" required>
								
										<option id="<?php echo "thecoin0" ?>" name="<?php echo "thecoin0" ?>"><?php echo $_SESSION["allcoins"][0]["code"]; ?></option>
										<?php
										for($allmycoin=1;$allmycoin<sizeof($_SESSION["allcoins"]);$allmycoin++){
										?>
											<option id="<?php echo "thecoin".$allmycoin; ?>" name="<?php echo "thecoin".$allmycoin; ?>"><?php echo $_SESSION["allcoins"][$allmycoin]["code"]; ?></option>
										
									<?php } ?>
									</select>
									<br>
									</div>
									<h4><p id="<?php echo "coinamount0"?>"><?php getbalancefromapi($_SESSION["allcoins"][0]["swbtcapi"],$_SESSION["swpin"],$_SESSION["allcoins"][0]["swcoinkey"],1)?></p></h4>
									<input id="thecoinn" type="hidden" name="thecoinn" value="0">
									<?php
										for($allmycoin=1;$allmycoin<sizeof($_SESSION["allcoins"]);$allmycoin++){
										?>
									<h4><p id="<?php echo "coinamount".$allmycoin?>" hidden><?php getbalancefromapi($_SESSION["allcoins"][$allmycoin]["swbtcapi"],$_SESSION["swpin"],$_SESSION["allcoins"][$allmycoin]["swcoinkey"],1)?></p></h4>
									<?php } ?>
									<h4>Amount: </h4><input type="text" id="amountsendcoin" name="amountsendcoin" required>
									<br>
									
									<input type="submit" id="submitsellcoin" value="send payment">
									</form>
							</div>
							<h4><p id="messagecoinerror"><?php echo $mymessagecoin; ?></p></h4>
							
							<?php }}?>
							
							<div id="paymentwithtoken" <?php if(isset($_SESSION["walletaccount"])){
										if($_SESSION["walletaccount"]=="walletaccount"){
							?> hidden <?php }}?>>
							
								<h4>Wallet id: </h4><input type="text" id="walletdesid"  name="walletdesid" placeholder="ex: GKEZMO6YDZ6 ...." required>
								<br>
								
								<div class="select-wrapper">
									<select id="assetoption" onchange="getassetamount()" required>
									</select>
								</div>
								<br>
								<h4><p id="assetamount"></p></h4>
								<input id="assetnametosend" type="hidden" name="assetnametosend">
								<input id="issuernametosend" type="hidden" name="issuernametosend">
								<h4>Amount: </h4><input type="text" id="amountsend" name="amountsend" required>
								<br>
								
								<div class="select-wrapper">
									<select id="memotyp" onchange="showmemo()">
									<option>none</option>
									<option>MEMO_ID</option>
									<option>MEMO_TEXT</option>
									<option>MEMO_HASH</option>
									<option>MEMO_RETURN</option>
									</select>
								</div><br>
								<input id="momoinput" type="hidden" name="memoinput">
								<h4><p id="hashproblem"></p></h4>
								<h4><p id="messageeroor"></p></h4>
								<input type="submit" id="submitsell" onclick="sendpayments()" value="send payment">
							</div>
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
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script>

////////////////////////

			 var publickeypair= "<?php echo $_SESSION['publickey']; ?>";
		 
			 var server = new StellarSdk.Server('https://horizon.stellar.org');
		// the JS SDK uses promises for most actions, such as retrieving an account		 
		 var pair = StellarSdk.Keypair.fromPublicKey(publickeypair);
		server.loadAccount(pair.publicKey()).then(function(account) {
			
		  //console.log('Balances for account: ' + pair.publicKey());
		  var countl=0;
		  account.balances.forEach(function(balance) {
		  if(balance.asset_type == 'native' && balance.balance <= 1){
			  //.........
		  }else{
			  console.log('asset code:', balance.asset_code, ', Balance:', balance.balance);
			  
			  var the_asset_code=balance.asset_code;
			  the_asset_issuer=balance.asset_issuer;
			  if(the_asset_code == null && balance.asset_issuer== null){
				  the_asset_code="XLM";
				  the_asset_issuer="native";
			  }
			  var selective = document.getElementById("assetoption");
				var opt = document.createElement("option");
				opt.text = ""+the_asset_code;
				opt.id=""+countl;
				opt.value = ""+the_asset_issuer;
				selective.appendChild(opt);
				if(countl==0){
					document.getElementById('assetamount').innerHTML=balance.balance;
				 document.getElementById('assetnametosend').value=the_asset_code;
				 document.getElementById('issuernametosend').value=the_asset_issuer;
				}
				countl++;
		  }
			
		  });
		
		}).catch(function (error) {
            // oops, mom don't buy it
			document.getElementById("assetamount").innerHTML  = "There is a connection problem or your account is not activated yet . check your connection or activate your account by putting 5 XLM in it.";
         // output: 'mom is not happy'
        });

		
		
		
		
/////////////////////for coins		
		
function choosepaymenttype(){
       // $(".").hide();
	var index=document.getElementById("choosepaymenttype").selectedIndex;
	$("#messagecoinerror").hide();
	if(index==1){
        $("#paymentwithtoken").show();
		$("#paymentwithcoin").hide();
	}else{
		if(index==2){
			$("#paymentwithcoin").show();
			$("#paymentwithtoken").hide();
		}else{
			if(index==0){
				$("#paymentwithcoin").hide();
				$("#paymentwithtoken").hide();
			}
		}
	}

}		

function getcoinamount(){
	var index=document.getElementById("coinoption").selectedIndex;
	var numberofindex=document.getElementById("coinoption").length;
	for(i=0;i<numberofindex;i++){
		if(i==index){
			document.getElementById("thecoin"+i).setAttribute("name", "thecoin"+i);
			//document.getElementById("thecoinn"+i).setAttribute("name", "thecoinn"+i);
			document.getElementById("thecoinn").setAttribute("value", i);
			 $("#coinamount"+i).show();
			 //document.getElementById("coinamount"+i).setAttribute("name", "coinamount"+i);
		}else{
			document.getElementById("thecoin"+i).removeAttribute("name");
			//document.getElementById("thecoinn"+i).removeAttribute("name");
			$("#coinamount"+i).hide();
			//document.getElementById("coinamount"+i).removeAttribute("name");
		}
	}
}
		
////////////////////////////////////////		
		
		
		
/////////////////////
function showmemo(){
	var index=document.getElementById("memotyp").selectedIndex;
	document.getElementById("momoinput").value="";
	if(index==0){
		document.getElementById("momoinput").setAttribute("type", "text");
		document.getElementById("momoinput").setAttribute("placeholder", "write somthing");
	}
	if(index==1){
		document.getElementById("momoinput").setAttribute("type", "text");
		document.getElementById("momoinput").setAttribute("placeholder", "write MEMO_ID");
	}
	if(index==2){
		document.getElementById("momoinput").setAttribute("type", "text");
		document.getElementById("momoinput").setAttribute("placeholder", "write MEMO_TEXT");
	}
	if(index==3){
		document.getElementById("momoinput").setAttribute("type", "text");
		document.getElementById("momoinput").setAttribute("placeholder", "write MEMO_HASH");
	}
	if(index==4){
		document.getElementById("momoinput").setAttribute("type", "text");
		document.getElementById("momoinput").setAttribute("placeholder", "write MEMO_RETURN");
	}
	
}
function getassetamount(){
	
	//alert(""+);
	
			 
			 var index=document.getElementById("assetoption").selectedIndex;
			
			 var server = new StellarSdk.Server('https://horizon.stellar.org');
		// the JS SDK uses promises for most actions, such as retrieving an account
		 var publickeypair = "<?php echo $_SESSION['publickey']; ?>";
		 
		 var pair = StellarSdk.Keypair.fromPublicKey(publickeypair);
		server.loadAccount(pair.publicKey()).then(function(account) {
			
		  //console.log('Balances for account: ' + pair.publicKey());
		  account.balances.forEach(function(balance) {
		  if(balance.asset_type == 'native' && balance.balance <= 1){
			  //.........
		  }else{
			  console.log('asset code:', balance.asset_code, ', Balance:', balance.balance);
			  
			 
			 var assetcode=document.getElementById(""+index).text;
			  var asstissuer=document.getElementById(""+index).value;
			  //console.log(" ana "+assetcode+" lala "+asstissuer);
			  var the_asset_code=balance.asset_code;
			  var the_asset_issuer=balance.asset_issuer;
			  if(the_asset_code == assetcode && the_asset_issuer== asstissuer){
				 document.getElementById('assetamount').innerHTML=balance.balance;
				 document.getElementById('assetnametosend').value=the_asset_code;
				 document.getElementById('issuernametosend').value=the_asset_issuer;
			  }else{
				  if(assetcode=="XLM" && asstissuer=="native"){
					  
					  document.getElementById('assetamount').innerHTML=balance.balance;
					  document.getElementById('assetnametosend').value=assetcode;
				 document.getElementById('issuernametosend').value=asstissuer;
				  }
			  }
				
		  }
			
		  });
		
		}).catch(function (error) {
            // oops, mom don't buy it
			document.getElementById("assetamount").innerHTML  = "There is a connection problem or your account is not activated yet . check your connection or activate your account by putting 5 XLM in it.";
         // output: 'mom is not happy'
        });
}



function sendpayments(){
				document.getElementById("hashproblem").textContent ="";
				document.getElementById("messageeroor").textContent ="";
	if(document.getElementById('walletdesid').validity.valid==false ||
	 document.getElementById('amountsend').validity.valid==false ||
	 document.getElementById('assetnametosend').validity.valid==false ||
	 document.getElementById('issuernametosend').validity.valid==false ){
		alert("Please fill in the fields");
	 }else{	
	 document.getElementById("submitsell").setAttribute("class", "loadercancel");
	document.getElementById("submitsell").textContent="load";
	document.getElementById("submitsell").disabled = true;
	 
StellarSdk.Network.usePublicNetwork();
var server = new StellarSdk.Server('https://horizon.stellar.org');
var myseckeypkey = "<?php echo $_SESSION['secretkey']; ?>";
var sourceKeys = StellarSdk.Keypair
  .fromSecret(myseckeypkey);
var destinationId = document.getElementById('walletdesid').value;
var amountsend = document.getElementById('amountsend').value;
var assetcode=document.getElementById('assetnametosend').value;
var assetissuer=document.getElementById('issuernametosend').value;
//memo
//var eselect = document.getElementById("memotyp");
//var eoption = e.options[eselect.selectedIndex].value;
var index=document.getElementById("memotyp").selectedIndex;
var finalmemo=StellarSdk.Memo.none();
var ismemookay=true;
	if(index==0){
		var finalmemo=StellarSdk.Memo.none();
		//document.getElementById("momoinput").setAttribute("type", "text");
		//document.getElementById("momoinput").setAttribute("placeholder", "write somthing");
	}
	if(index==1){
		try{
		
		var finalmemo=StellarSdk.Memo.id(""+document.getElementById("momoinput").value);
		
		}catch(error) {
			ismemookay=false;
			document.getElementById("submitsell").setAttribute("class", "link-style");
			document.getElementById("submitsell").textContent="send payment";
			document.getElementById("submitsell").disabled = false;
			document.getElementById("hashproblem").textContent = "please check your memo_id ."+error.message;
	//location.reload();
		}
	}
	if(index==2){
		try{
		var finalmemo=StellarSdk.Memo.text(""+document.getElementById("momoinput").value);
		}catch(error) {
			ismemookay=false;
			document.getElementById("submitsell").setAttribute("class", "link-style");
			document.getElementById("submitsell").textContent="send payment";
			document.getElementById("submitsell").disabled = false;
			document.getElementById("hashproblem").textContent = "please check your memo_text ."+error.message;
	//location.reload();
		}
	}
	if(index==3){
		try{
		var finalmemo=StellarSdk.Memo.hash(""+document.getElementById("momoinput").value);}
	catch(error) {
		ismemookay=false;
			document.getElementById("submitsell").setAttribute("class", "link-style");
			document.getElementById("submitsell").textContent="send payment";
			document.getElementById("submitsell").disabled = false;
			document.getElementById("hashproblem").textContent = "please check your memo_hash ."+error.message;
	//location.reload();
		}
	}
	if(index==4){
		try{
		var finalmemo=StellarSdk.Memo.return(""+document.getElementById("momoinput").value);
		}catch(error) {
			ismemookay=false;
			document.getElementById("submitsell").setAttribute("class", "link-style");
			document.getElementById("submitsell").textContent="send payment";
			document.getElementById("submitsell").disabled = false;
			document.getElementById("hashproblem").textContent = "please check your memo_return ."+error.message;
	//location.reload();
		}
	}
//


if(assetissuer=="native" && assetcode=="XLM"){
	var sendasset =StellarSdk.Asset.native();
}else{
	var sendasset =new StellarSdk.Asset(assetcode, assetissuer);
}
// Transaction will hold a built transaction we can resubmit if the result is unknown.
var transaction;

// First, check to make sure that the destination account exists.
// You could skip this, but if the account does not exist, you will be charged
// the transaction fee when the transaction fails.
if(ismemookay==true){
server.loadAccount(destinationId)
  // If the account is not found, surface a nicer error message for logging.
  .catch(StellarSdk.NotFoundError, function (error) {
    throw new Error('check wallet id');
	document.getElementById("submitsell").setAttribute("class", "link-style");
	document.getElementById("submitsell").textContent="send payment";
	document.getElementById("submitsell").disabled = false;
	document.getElementById("messageeroor").textContent = "trasaction failed please check wallet id";
  })
  // If there was no error, load up-to-date information on your account.
  .then(function() {
    return server.loadAccount(sourceKeys.publicKey());
  })
  .then(function(sourceAccount) {
    // Start building the transaction.
    transaction = new StellarSdk.TransactionBuilder(sourceAccount)
      .addOperation(StellarSdk.Operation.payment({
        destination: destinationId,
        // Because Stellar allows transaction in many currencies, you must
        // specify the asset type. The special "native" asset represents Lumens.
		
        asset: sendasset,
        amount: ""+amountsend
      }))
      // A memo allows you to add your own metadata to a transaction. It's
      // optional and does not affect how Stellar treats the transaction.
      .addMemo(finalmemo)
      .build();
    // Sign the transaction to prove you are actually the person sending it.
    transaction.sign(sourceKeys);
    // And finally, send it off to Stellar!
    return server.submitTransaction(transaction);
  })
  .then(function(result) {
    console.log('Success! ');
	document.getElementById("submitsell").setAttribute("class", "link-style");
	document.getElementById("submitsell").textContent="send payment";
	document.getElementById("submitsell").disabled = false;
	document.getElementById("messageeroor").textContent = "payment has been sent successfully";
	//location.reload();
	//return true;
  })
  .catch(function(error) {
	  document.getElementById("submitsell").setAttribute("class", "link-style");
	document.getElementById("submitsell").textContent="send payment";
	document.getElementById("submitsell").disabled = false;
	document.getElementById("messageeroor").textContent = "trasaction failed please try again. "+error.message;
	
	
//location.reload();
   // console.error('Something went wrong!', error.message);
    // If the result is unknown (no response body, timeout etc.) we simply resubmit
    // already built transaction:
    // server.submitTransaction(transaction);
  });
	 }
}
}
	
</script>
</body>
</html>
