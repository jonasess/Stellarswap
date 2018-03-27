<?php 
	error_reporting(E_ERROR | E_PARSE);
	include("stellarSwap-session.php");
	//echo $_SESSION["secretkey"];
	
	//echo $_SESSION["publickey"];
	//session_start();
	//echo $_SESSION["SessionOnOrOff"];
	//echo $_SESSION["secretkey"];
	//echo $_POST["data"];
	
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Wallet</title>
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
								<h2>Your public key :</h2><h5> "<?php echo $_SESSION['publickey']; ?>"</h5>
					
					<?php if(isset($_SESSION["walletaccount"])){
						if($_SESSION["walletaccount"]=="walletaccount"){
						for($allmycoin=0;$allmycoin<sizeof($_SESSION["allcoins"]);$allmycoin++){
						?>
							<h4>Your <?php echo $_SESSION["allcoins"][$allmycoin]["code"];?> wallet :</h4><h5> "<?php echo $_SESSION["allcoins"][$allmycoin]["swcoinkey"]; ?>"</h5>
					<?php }
						}
						}?>
								
						<h2>Your balance:</h2>
								 <label id="info"></label>
								 <p id="errormessage"></p>
								 <!-- coin balance -->
							 <?php if(isset($_SESSION["walletaccount"])){ ?>
								<table id="tableofcoins">
								<tr>
								<td><h4>coin logo</h4></td>
								<td><h4>coin code</h4></td>
								<td><h4>available balance</h4></td>
								<td><h4>bending balance</h4></td>
								</tr>
								<?php if($_SESSION["walletaccount"]=="walletaccount"){
									include("block_io-php-master/coinoperation.php");
									for($allmycoin=0;$allmycoin<sizeof($_SESSION["allcoins"]);$allmycoin++){
									?>
									<tr>
									<td><img src="<?php echo $_SESSION["allcoins"][$allmycoin]["logo"];?>"width="70" height="70"></td>
									<td><h4><?php echo $_SESSION["allcoins"][$allmycoin]["code"];?></h4></td>
									<td><h4><?php getbalancefromapi($_SESSION["allcoins"][$allmycoin]["swbtcapi"],$_SESSION["swpin"],$_SESSION["allcoins"][$allmycoin]["swcoinkey"],1);?></h4></td>
									<td><h4><?php getbalancefromapi($_SESSION["allcoins"][$allmycoin]["swbtcapi"],$_SESSION["swpin"],$_SESSION["allcoins"][$allmycoin]["swcoinkey"],0);?></h4></td>
									</tr>
								<?php }
									}
									?>
								</table>
						<br>
						<?php }?>
								<!-- stellar and token balance -->
								 
								 <table id="allassetstab">
								<tr>
								<td><h4>asset logo</h4></td>
								<td><h4>asset code</h4></td>
								<td><h4>issuer</h4></td>
								<td><h4>balance</h4></td>
								</tr>
								</table>							
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
<script src="stellarSwap-assetTokens.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script >

	///////////////////use id best for securty ********************************************************************************
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		// the JS SDK uses promises for most actions, such as retrieving an account
		 var publickeypair = "<?php echo $_SESSION['publickey']; ?>";
		 
		 var pair = StellarSdk.Keypair.fromPublicKey(publickeypair);
		server.loadAccount(pair.publicKey()).then(function(account) {
			
		  console.log('Balances for account: ' + pair.publicKey());
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
				/*var txt = document.createTextNode(the_asset_code +" : "+balance.balance +"  issuer : "+the_asset_issuer.substring(0, 6));
				var tagP = document.createElement("h4");
				tagP.appendChild(txt);
				document.body.appendChild(tagP);
				document.getElementById('info').appendChild(tagP);*/
				
						var assetexist=false;
						for(i=0;i<allassets.length;i++){
							if(the_asset_code==allassets[i][2] && the_asset_issuer==allassets[i][3]){
									var table = document.getElementById("allassetstab");
										  var rowCount = table.rows.length;
											var row = table.insertRow(rowCount);
											var cell1 = row.insertCell(0);
											var cell2 = row.insertCell(1);
											var cell3 = row.insertCell(2);
											var cell4 = row.insertCell(3);
											////////test aria
											
												//row.setAttribute('onclick','setpricetoboardbuy();'); // for FF
											//	row.onclick = function() {setpricetoboardbuy();};
											//	row.setAttribute('id','b'+i);
												
												//hiden element contain the price 
											/*	var xhideprice = document.createElement("INPUT");
													xhideprice.setAttribute("type", "hidden");
													xhideprice.setAttribute("id", "inp"+i);
													xhideprice.setAttribute("value", ""+priceinXLM);
													document.body.appendChild(xhideprice);*/
											
												//////////////:
											var logoimg = document.createElement("IMG");
											logoimg.setAttribute("src", ""+allassets[i][1]);
											//logoimg.setAttribute("src", ""+allassets["asset"+i][1]);
											//logoimg.setAttribute("width", "304");
											//logoimg.setAttribute("height", "228");
											//logoimg.setAttribute("alt", "The Pulpit Rock");
											cell1.appendChild(logoimg);
											//cell1.value = ""+allassets[i][2];
											//cell1.setAttribute("id", "logo"+i) ;
											cell2.style.color="#000";
											cell2.innerHTML = ""+allassets[i][2];
											cell3.style.color="#000";
											cell3.setAttribute("tooltip", ""+allassets[i][3]);
											cell3.innerHTML = ""+allassets[i][3].substring(0, 6);
											cell4.style.color="#000";
											cell4.innerHTML = ""+balance.balance;
											assetexist=true;
								}			
						}
						if(assetexist==false){
						if(the_asset_code=="XLM" && the_asset_issuer=="native"){
									var table = document.getElementById("allassetstab");
									  var rowCount = table.rows.length;
										var row = table.insertRow(rowCount);
										var cell1 = row.insertCell(0);
										var cell2 = row.insertCell(1);
										var cell3 = row.insertCell(2);
										var cell4 = row.insertCell(3);
									
											//////////////:
										var logoimg = document.createElement("IMG");
										logoimg.setAttribute("src", "logo/stellar.png");
										//logoimg.setAttribute("alt", "The Pulpit Rock");
										cell1.appendChild(logoimg);
										//cell1.value = ""+allassets[i][2];
										cell2.style.color="#000";
										cell2.innerHTML = "XLM";
										cell3.setAttribute("tooltip", "Stellar.org");
										cell3.style.color="#000";
										cell3.innerHTML = "native";
										cell4.style.color="#000";
										cell4.innerHTML = ""+balance.balance;
								}else{
									var table = document.getElementById("allassetstab");
									  var rowCount = table.rows.length;
										var row = table.insertRow(rowCount);
										var cell1 = row.insertCell(0);
										var cell2 = row.insertCell(1);
										var cell3 = row.insertCell(2);
										var cell4 = row.insertCell(3);
									
											//////////////:
										var logoimg = document.createElement("IMG");
										logoimg.setAttribute("src", "logo/unknown.png");
										//logoimg.setAttribute("alt", "The Pulpit Rock");
										cell1.appendChild(logoimg);
										//cell1.value = ""+allassets[i][2];
										cell2.style.color="#000";
										cell2.innerHTML = ""+the_asset_code;
										cell3.style.color="#000";
										cell3.setAttribute("tooltip", ""+the_asset_issuer);
										cell3.innerHTML = ""+the_asset_issuer.substring(0, 6);
										cell4.style.color="#000";
										cell4.innerHTML = ""+balance.balance;
									
								}
						}
				/*var txt2 = document.createTextNode( "issuer : "+the_asset_issuer.substring(0, 4));
				var tagP2 = document.createElement("h4");
				tagP2.appendChild(txt2);
				document.body.appendChild(tagP2);
				document.getElementById('info').appendChild(tagP2);*/
				///////using ajax to send it 
				/*$.ajax({
					//data: 'the_asset_code=' + the_asset_code,
					data: { 
						'the_asset_code': the_asset_code, 
						'the_asset_issuer': the_asset_issuer // <-- the $ sign in the parameter name seems unusual, I would avoid it
					},
					url: 'stellarSwap-assetTokens.php',
					method: 'POST', // or GET
					success: function(msg) {
						alert(msg);
					}
				});*/
				
				
		  }
			
		  });
		
		}).catch(function (error) {
            // oops, mom don't buy it
			document.getElementById("errormessage").innerHTML  = "There is a connection problem or your account is not activated yet . check your connection or activate your account by putting 5 XLM in it.";
         // output: 'mom is not happy'
        });
		 

</script>
</body>
</html>