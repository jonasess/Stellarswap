<?php 
	error_reporting(E_ERROR | E_PARSE);
	include("stellarSwap-session.php");
	include("stellarSwap-assetTokens.php");
	//echo $_SESSION["secretkey"];
	
	/*	//$json_string = 'https://horizon.stellar.org/accounts/GBRPTWEZTUKYM6VJXLHXBFI23M2GSY3TCVIQSZKFQLMOJXH7VPDGKBDP';
			$json_string ='https://horizon.stellar.org/order_book?selling_asset_type=native&buying_asset_type=credit_alphanum4&buying_asset_code=CHRC&buying_asset_issuer=GBRPTWEZTUKYM6VJXLHXBFI23M2GSY3TCVIQSZKFQLMOJXH7VPDGKBDP&limit=1';
			$jsondata = file_get_contents($json_string);
			$obj = json_decode($jsondata,true);
			//echo "<pre>";
			//print_r($obj);
			//$rraybalances=$obj['bids'][1];
			$assetamount=$obj['bids'][0]["amount"];
			$priceinXLM=$obj['bids'][0]["price"];
			$XLManount=$assetamount/$priceinXLM;
			$finalpriceBID=$XLManount/$assetamount;
	echo $finalpriceBID;
	$assetamount=$obj['asks'][0]["amount"];
			$priceinXLM=$obj['asks'][0]["price"];
			$XLManount=$assetamount/$priceinXLM;
			$finalpriceASK=$XLManount/$assetamount;
	//echo $finalpriceASK;*/
	
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Market</title>
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
								<?php if(isset($_SESSION["walletaccount"])){
								if($_SESSION["walletaccount"]=="walletaccount"){?>
								<h2>Coin vs Token market:</h2>
								<form method="post" action="stellarSwap-tradecoinvstoken.php">
								  <table>
								  <tr>
									<td><h4>Coin</h4></td>
									<td><h4>Chosen coin</h4></td>
									<td><h4>Asset/Token</h4></td>
									<td><h4>Chosen token</h4></td>
									<td><h4>Trade</h4></td>
									</tr>
									
									
									<td><div class="select-wrapper">
									<select id="coinoption" onchange="choosecointotrade()" required>
								
										
										<?php
										for($allmycoin=0;$allmycoin<sizeof($_SESSION["allcoins"]);$allmycoin++){
										?>
											<option id="<?php echo "coinselectoption".$allmycoin; ?>" ><?php echo $_SESSION["allcoins"][$allmycoin]["code"]; ?></option>
										
									<?php } ?>
									</select>
									</div></td>
									
									<td id="chosencoin">
											<img id="coinimg0" src="<?php echo $_SESSION["allcoins"][0]["logo"]; ?>" width="80" height="80">
											<input id="mychosencoin" type="hidden" name="mychosencoin" value="0">
									<?php
										for($allmycoin=1;$allmycoin<sizeof($_SESSION["allcoins"]);$allmycoin++){
										?>
											<img hidden id="<?php echo "coinimg".$allmycoin; ?>" src="<?php echo $_SESSION["allcoins"][$allmycoin]["logo"]; ?>" width="80" height="80">
									<?php } ?>
									
									</td>
									
									<td>
									<div class="select-wrapper"><select id="listoftokens" onchange="choosetokentotrade()"></select></div>
									</td>
									<td id="chosentoken" align="center"></td>
	
									<td><input id="tradecoinwithtoken" type="submit" value="Trade"></td>
									


								</table>
								  
								  </form>
								<?php }}?>
								
								
								<!-- asset trade table-->
								<h2>Token vs XLM market:</h2>
								<form method="post" id="myForm" action="stellarSwap-trade.php">
								  <table class="alt">
								  <tr>
									<td><h4>Asset logo</h4></td>
									<td><h4>Asset code</h4></td>
									<td><h4>Asset issuer</h4></td>
									<td><h4>Price (XLM) Bids</h4></td>
									<td><h4>Price (XLM) Asks</h4></td>
									<td><h4>Trade</h4></td>
									</tr>
									<input id="whopressonbtn" type="hidden" name="whopressonbtn">
									<?php for($i=0;$i<sizeof($asset_tokes);$i++){ ?>
									<tr>
									
									<td><img src="<?php echo $asset_tokes[$i]["logo"];?>" alt="Stellar Swap" width="70" height="70"><h5 style="color:#000"><?php echo $asset_tokes[$i]["domain"]; ?></h5></td>
									<td><h3 name="<?php echo "assetcode" . $i?>" id="<?php echo "code" . $i?>"><?php echo $asset_tokes[$i]["code"]; ?></h3>
									<input name="<?php echo "assetcode" . $i?>" id="<?php echo "codee" . $i?>" type="hidden" value="<?php echo $asset_tokes[$i]["code"]; ?>">
									</td>
									<td><h5 tooltip="<?php echo $asset_tokes[$i]["issuer"]; ?>" name="<?php echo "assetissuer" . $i?>" id="<?php echo "issuer" . $i?>"><?php echo substr($asset_tokes[$i]["issuer"],0,4); ?></h5>
									<input name="<?php echo "assetissuer" . $i?>" id="<?php echo "issuerr" . $i?>" type="hidden" value="<?php echo $asset_tokes[$i]["issuer"]; ?>">
									</td>
									<td><h5 id="<?php echo "asks" . $i?>">
									</h5></td>
									<td><h5 id="<?php echo "bids" . $i?>">	</h5></td>
									<td><input id="<?php echo "" . $i?>" type="button" onclick="starttrade(this.id)" value="Trade"></td>
									</tr>
										<?php } ?>
								</table>
								  
								  </form>
							
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
<script src="stellarSwap-assetTokens.js"></script>
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script>
$('form').submit(function () {
  if ($(document.activeElement).attr('type') == 'submit')
     return true;
  else return false;
});
function starttrade(clicked_id) {
	document.getElementById("whopressonbtn").value=clicked_id;
	document.getElementById("myForm").submit();

}


///////////////////////// check if asset alredy accepted
		var server = new StellarSdk.Server('https://horizon.stellar.org');
	/*	var iVariable=0;
		
	for (i = 0; i < "<?php echo sizeof($asset_tokes) ?>"; i++) {
		
		console.log("hhhhh" +i);
		  var assetcode = document.getElementById("code"+i).textContent;
		  var assetissuer = document.getElementById("issuer"+i).textContent;

		  var resp=server.orderbook(new StellarSdk.Asset.native(), new StellarSdk.Asset(assetcode, assetissuer))//.limit(1).order("asc")
		  .call()
		  .then(function(resp) {
		  //bids
		   var priceinXLM=resp["bids"][0]["price"];
		  var assetamount=resp["bids"][0]["amount"];
		  var XLManount=assetamount/priceinXLM;
		 var finalpriceASK=XLManount/assetamount;
			 console.log("bids"+finalpriceASK+" XLM");
			 var finalpriceASKstr=finalpriceASK+"";
			 document.getElementById("bids"+iVariable).textContent=finalpriceASKstr.substring(0,6)+" XLM";
			 //asks
			  var priceinXLM2=resp["asks"][0]["price"];
		  var assetamount2=resp["asks"][0]["amount"];
		  var XLManount2=assetamount2/priceinXLM2;
		 var finalpriceASK2=XLManount2/assetamount2;
		 var finalpriceASKstr2=finalpriceASK2+"";
		 document.getElementById("asks"+iVariable).textContent=finalpriceASKstr2.substring(0,6)+" XLM";
			 console.log("asks"+finalpriceASK2+" XLM");
			  console.log("hello tage "+i+" XLM");
		   iVariable=iVariable+1;
		  
		  //console.log(resp["bids"][0]["price"]);
		  })
	
	}
	*/
	
	
	
	
	
	var iVariable=0;
async function loadpricesoftoken()	{
	var server = new StellarSdk.Server('https://horizon.stellar.org');
	for (let i = 0; i < "<?php echo sizeof($asset_tokes) ?>"; i++) {
		
		//console.log("hhhhh" +i);
		 // var assetcode = document.getElementById("code"+i).textContent;
		 // var assetissuer = document.getElementById("issuer"+i).textContent; if you want to use this one remove substr from php
			var assetcode = document.getElementById("code"+i).textContent;
			var assetissuer = document.getElementById("issuerr"+i).value;
		 await server.orderbook(new StellarSdk.Asset.native(), new StellarSdk.Asset(assetcode, assetissuer)).limit(1).order("desc")
		  .call()
		  .then(function(resp) {
		  //bids
		   var priceinXLM=resp["bids"][0]["price"];
		  var assetamount=resp["bids"][0]["amount"];
		  var XLManount=assetamount/priceinXLM;
		 var finalpriceASK=XLManount/assetamount;
			 //console.log("bids"+finalpriceASK+" XLM");
			 var finalpriceASKstr=finalpriceASK+"";
			 document.getElementById("bids"+i).textContent= Number(finalpriceASKstr).toFixed(6)+" XLM";
			 //asks
			  var priceinXLM2=resp["asks"][0]["price"];
		  var assetamount2=resp["asks"][0]["amount"];
		  var XLManount2=assetamount2/priceinXLM2;
		 var finalpriceASK2=XLManount2/assetamount2;
		 var finalpriceASKstr2=finalpriceASK2+"";
		 document.getElementById("asks"+i).textContent=Number(finalpriceASKstr2).toFixed(6)+" XLM";
			 //console.log("asks"+finalpriceASK2+" XLM");
			  //console.log("hello tage "+i+" XLM");
		   return resp;
		  
		  //console.log(resp["bids"][0]["price"]);
		  })
	
	}
}
	
	loadpricesoftoken();

	
	
	
	
////////////////////////////////////load asset images for trade with coin



		// the JS SDK uses promises for most actions, such as retrieving an account
		 var publickeypair = "<?php echo $_SESSION['publickey']; ?>";
		 var onlyfirstone=false;
		 var pair = StellarSdk.Keypair.fromPublicKey(publickeypair);
		server.loadAccount(pair.publicKey()).then(function(account) {
			var forindisofselectoption=0;
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
						
						var tokencolumn = document.getElementById("chosentoken");
						for(i=0;i<allassets.length;i++){
							if(the_asset_code==allassets[i][2] && the_asset_issuer==allassets[i][3]){
											var logoimg = document.createElement("IMG");
											logoimg.setAttribute("src", ""+allassets[i][1]);
											logoimg.setAttribute("id", "tokenimg"+forindisofselectoption);
											var inputissuer = document.createElement("input");
											var inputcode = document.createElement("input");
											var inputlogo = document.createElement("input");
											inputissuer.setAttribute("id", "inputissuer"+forindisofselectoption);
											inputissuer.setAttribute("type", "hidden");
											inputissuer.setAttribute("value", allassets[i][3]);
											inputcode.setAttribute("id", "inputcode"+forindisofselectoption);
											inputcode.setAttribute("type", "hidden");
											inputcode.setAttribute("value", allassets[i][2]);
											inputlogo.setAttribute("id", "inputlogo"+forindisofselectoption);
											inputlogo.setAttribute("type", "hidden");
											inputlogo.setAttribute("value", allassets[i][1]);
											if(onlyfirstone==false){
												logoimg.style.display = "block";
											//	tokencode.style.display = "block";
											inputissuer.setAttribute("name", "inputissuer");
											inputcode.setAttribute("name", "inputcode");
											inputlogo.setAttribute("name", "inputlogo");
												onlyfirstone=true;
											}else{
												logoimg.style.display = "none";
											//	tokencode.style.display = "none";
											}
											//logoimg.setAttribute("width", "304");
											//logoimg.setAttribute("height", "228");
											tokencolumn.appendChild(inputissuer);
											tokencolumn.appendChild(inputcode);
											tokencolumn.appendChild(inputlogo);
											tokencolumn.appendChild(logoimg);
											
											//tokencolumn.appendChild(tokencode);
											assetexist=true;
											
											
											var selective = document.getElementById("listoftokens");
											var opt = document.createElement("option");
											opt.text = ""+allassets[i][2];
											opt.id="tokennbr"+i;
											//opt.value = ""+the_asset_issuer;
											selective.appendChild(opt);
											
											
											
								}			
						}
						if(assetexist==false){
						if(the_asset_code=="XLM" && the_asset_issuer=="native"){
									var logoimg = document.createElement("IMG");
									logoimg.setAttribute("src", "logo/stellar.png");
									logoimg.setAttribute("id", "tokenimg"+forindisofselectoption);
									var inputissuer = document.createElement("input");
									var inputcode = document.createElement("input");
									var inputlogo = document.createElement("input");
									inputissuer.setAttribute("id", "inputissuer"+forindisofselectoption);
									inputissuer.setAttribute("type", "hidden");
									inputissuer.setAttribute("value", the_asset_issuer);
									inputcode.setAttribute("id", "inputcode"+forindisofselectoption);
									inputcode.setAttribute("type", "hidden");
									inputcode.setAttribute("value", the_asset_code);
									inputlogo.setAttribute("id", "inputlogo"+forindisofselectoption);
									inputlogo.setAttribute("type", "hidden");
									inputlogo.setAttribute("value", "logo/stellar.png");
									if(onlyfirstone==false){
												logoimg.style.display = "block";
												inputissuer.setAttribute("name", "inputissuer");
												inputcode.setAttribute("name", "inputcode");
												inputlogo.setAttribute("name", "inputlogo");
												onlyfirstone=true;
											}else{
												logoimg.style.display = "none";
												
											}
									//logoimg.setAttribute("width", "304");
									//logoimg.setAttribute("height", "228");
									tokencolumn.appendChild(inputissuer);
									tokencolumn.appendChild(inputcode);
									tokencolumn.appendChild(inputlogo);
									
									tokencolumn.appendChild(logoimg);
									
									//tokencolumn.appendChild(tokencode);
									
									var selective = document.getElementById("listoftokens");
									var opt = document.createElement("option");
									opt.text = "XLM";
									opt.id="tokennbr"+i;
									//opt.value = ""+the_asset_issuer;
									selective.appendChild(opt);
						
								}else{
									var logoimg = document.createElement("IMG");
									logoimg.setAttribute("src", "logo/unknown.png");
									logoimg.setAttribute("id", "tokenimg"+forindisofselectoption);
									var inputissuer = document.createElement("input");
									var inputcode = document.createElement("input");
									var inputlogo = document.createElement("input");
									inputissuer.setAttribute("id", "inputissuer"+forindisofselectoption);
									inputissuer.setAttribute("type", "hidden");
									inputissuer.setAttribute("value", the_asset_issuer);
									inputcode.setAttribute("id", "inputcode"+forindisofselectoption);
									inputcode.setAttribute("type", "hidden");
									inputcode.setAttribute("value", the_asset_code);
									inputlogo.setAttribute("id", "inputlogo"+forindisofselectoption);
									inputlogo.setAttribute("type", "hidden");
									inputlogo.setAttribute("value", "logo/unknown.png");
									/*var tokencode = document.createElement("h4");
									tokencode.setAttribute("id", "tokenhtag"+forindisofselectoption);
									tokencode.innerHTML=the_asset_code;*/
									if(onlyfirstone==false){
												logoimg.style.display = "block";
												inputissuer.setAttribute("name", "inputissuer");
												inputcode.setAttribute("name", "inputcode");
												inputlogo.setAttribute("name", "inputlogo");
												onlyfirstone=true;
											}else{
												logoimg.style.display = "none";
												//tokencode.style.display = "none";
											}
									//logoimg.setAttribute("width", "304");
									//logoimg.setAttribute("height", "228");
									tokencolumn.appendChild(inputissuer);
									tokencolumn.appendChild(inputcode);
									tokencolumn.appendChild(inputlogo);
									tokencolumn.appendChild(logoimg);
									//tokencolumn.appendChild(tokencode);
									var selective = document.getElementById("listoftokens");
									var opt = document.createElement("option");
									opt.text = ""+the_asset_code;
									opt.id="tokennbr"+i;
									//opt.value = ""+the_asset_issuer;
									selective.appendChild(opt);
									
								}
						}
						forindisofselectoption++;
				
		  }
			
		  });
		
		}).catch(function (error) {
            // oops, mom don't buy it
			//document.getElementById("errormessage").innerHTML  = "There is a connection problem or your account is not activated yet . check your connection or activate your account by putting 5 XLM in it.";
         // output: 'mom is not happy'
        });
		



function choosetokentotrade(){
       // $(".").hide();
	var index=document.getElementById("listoftokens").selectedIndex;
	var numberofindex=document.getElementById("listoftokens").length;
	for(i=0;i<numberofindex;i++){
		if(i==index){
			document.getElementById("tokenimg"+i).style.display = "block";
			//document.getElementById("tokenhtag"+i).style.display = "block";
			
			document.getElementById("inputissuer"+i).setAttribute("name", "inputissuer");
			document.getElementById("inputcode"+i).setAttribute("name", "inputcode");
			document.getElementById("inputlogo"+i).setAttribute("name", "inputlogo");
			
		}else{
			document.getElementById("tokenimg"+i).style.display = "none";
			//document.getElementById("tokenhtag"+i).style.display = "none;
			document.getElementById("inputissuer"+i).removeAttribute("name");
			document.getElementById("inputcode"+i).removeAttribute("name");
			document.getElementById("inputlogo"+i).removeAttribute("name");
		}
	}

}	
function choosecointotrade(){
       // $(".").hide();
	var index=document.getElementById("coinoption").selectedIndex;
	var numberofindex=document.getElementById("coinoption").length;
	for(i=0;i<numberofindex;i++){
		if(i==index){
			document.getElementById("mychosencoin").setAttribute("value",i);
			//document.getElementById("coinhtage"+i).style.display = "block";
			document.getElementById("coinimg"+i).style.display = "block";
		}else{
			//document.getElementById("coinhtage"+i).style.display = "none";
			document.getElementById("coinimg"+i).style.display = "none";
		}
	}

}	
</script>
</body>
</html>