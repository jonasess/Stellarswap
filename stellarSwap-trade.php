<?php 
	include("stellarSwap-session.php");
	include("stellarSwap-assetTokens.php");
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

							if(isset($_POST["whopressonbtn"])){
							$num= $_POST["whopressonbtn"];
							$assetcode =$_POST["assetcode".$num];
							$assetissuer= $_POST["assetissuer".$num];
								//if($assetcode!="" && $assetissuer!=""){
						
						?>

						  <table >
						  
							<tr>
							<td><img src="<?php echo $asset_tokes[$num]["logo"];?>" alt="Stellar Swap" width="70" height="70"><h5><?php echo $asset_tokes[$num]["domain"]; ?></h5></td>
							<td><h3 name="<?php echo "assetcode" . $num?>" id="<?php echo "code" . $num?>"><?php echo $asset_tokes[$num]["code"]; ?></h3>
							</td>
							<td><h5 name="<?php echo "assetissuer" . $num?>" id="<?php echo "issuer" . $num?>"><?php echo "issuer: ". substr($asset_tokes[$num]["issuer"], 0, 4); ?></h5>
							</td>
							<td><h5 id="<?php echo "asks" . $num?>"> =></h5></td>
							
							<td><img src="<?php echo "logo/stellar.png"?>" alt="Stellar Swap" width="70" height="70"><h5><?php echo "stellar.org"?></h5></td>
							<td><h3 name="XLM" id="XLM"><?php echo "XLM"; ?></h3>
							</td>
							<td><h5 name="nativeasset" id="nativeasset"><?php echo "stellar"; ?></h5></td>
							
							</tr>
						</table>
						
						<br>

						<div class='wrapper'>
						  <canvas height='300' id='canvas' width='900'></canvas>
						</div>
						
						 <div class="posts" style="color:black;">
							 <article>
								<h3>Sell:</h3>
								Price(in XLM): <input type="text" id="pricexlm" onkeydown="calculatesells(1)" name="pricexlm" placeholder="Price in xlm" required>
								<br>
								<br>
								Token Amount: <input type="text" id="TokenAmoint" onkeydown="calculatesells(2)" name="tokenpriceav" placeholder="<?php echo $assetcode." Amount. available :"; ?>" required>
								<br>
								<br>
								XLM amount: <input type="text" id="XLMamount" onkeydown="calculatesells(3)" name="xlmpriceav" placeholder="<?php echo " Amount. available :"; ?>" required>
								<br><br>
								
								<div style="display:none;" id="loader" class="loader"></div>
								<p style="display:hidden;" id="msgofload"></p>
								
								<input type="submit" id="submitsell" onclick="addtheofferTokenNative()" value="Submit">
							</article>
							
							<article>
							 
								<h3>buy:</h3>
								Price(in XLM): <input type="text" id="pricexlmb" onkeydown="calculatesbuy(1)" name="pricexlmb" placeholder="Price in xlm" required>
								<br>
								<br>
								Token Amount: <input type="text" id="TokenAmointb" onkeydown="calculatesbuy(2)" name="tokenpriceavb" placeholder="<?php echo $assetcode." Amount. available :"; ?>" required>
								<br>
								<br>
								XLM amount: <input type="text" id="XLMamountb" onkeydown="calculatesbuy(3)" name="xlmpriceavb" placeholder="<?php echo " Amount. available :"; ?>" required>
								<br><br>
								<div style="display:none;" id="loader2" class="loader"></div>
								<p style="display:hidden;" id="msgofload2"></p>
								<input type="submit" id="submitbuy" onclick="addtheofferNativeToken()" value="Submit">
							</article>
						</div>
						
						  <!-- tables -->
						 <div class="posts" style="color:black;">
						 <article> 
						  <h3>Buy offers:</h3>
						  <table id="bidstab" bgcolor="40ff00" style="cursor: pointer;background:#32CD32;" >
							<tr>
						  <td>XLM amount</td>
							<td><?php echo $assetcode. " amount";?></td>
							 <td>Price</td>
							</tr>
						  </table>
						</article>
						<article>
							<h3>Sell offers:</h3>
						  <table id="askstab" bgcolor="#ff8080" style="cursor: pointer;background:#FF0000;">
							<tr>
							  <td>Price</td>
							<td><?php echo $assetcode. " amount";?></td>
							<td>XLM amount</td>
							</tr>
						  </table>
						 </article>
						</div>
						  
						<div class="posts" style="color:black;">
						 <article> 
							<h3>My sell(asks) offers:</h3>
						  <table id="youroffertab" style="background:#FF0000;" >
							<tr>
							<td>XLM amount</td>
							<td><?php echo $assetcode. " amount";?></td>
							<td>Price</td>
							<td>Cancel offer</td>
							</tr>
						  </table>
						</article> 
						<article> 
						<h3>My buy(bids) offers:</h3>
						  <table id="youroffertabbids" style="background:#32CD32;" >
							<tr>
							<td>XLM amount</td>
							<td><?php echo $assetcode. " amount";?></td>
							<td>Price</td>
							<td>Cancel offer</td>
							</tr>
						  </table>
						 </article> 
						</div>
						<div style="color:black;">
						
							<h3>Recent trades:</h3>
						  <table id="alltrads" >
							<tr>
								 <td>XLM amount</td>
								 <td><?php echo $assetcode . " amount";?></td>
								 <td>Price</td>
								 <td>Date</td>
								 
								<?php 
						  
						  error_reporting(E_ERROR | E_PARSE);

							$json_string ='https://horizon.stellar.org/trades?base_asset_type=credit_alphanum4&base_asset_code='.$assetcode.'&base_asset_issuer='.$assetissuer.'&counter_asset_type=native&limit=200&order=desc';
							$jsondata = file_get_contents($json_string);
							$obj = json_decode($jsondata,true);
						
							//echo "<pre>";
							//print_r($obj);
							for($size=0;$size<sizeof($obj["_embedded"]["records"]);$size++){
						  ?>
							<tr>
						  <td><?php echo $obj["_embedded"]["records"][$size]["counter_amount"]; ?></td>
							<td><?php echo $obj["_embedded"]["records"][$size]["base_amount"]; ?></td>
							 <td><?php echo $obj["_embedded"]["records"][$size]["counter_amount"]/$obj["_embedded"]["records"][$size]["base_amount"]; ?></td>
							 <td><?php echo $obj["_embedded"]["records"][$size]["ledger_close_time"]; ?></td>
							 
							</tr>
							<?php 
							}
							?>
					
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
<!-- javascript -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--  <script src='http://cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js'></script> -->
 <script src='js/chart.js'></script>
<script src="stellar-sdk/stellar-sdk.js" ></script>
<script>

/////////////start adding table
	
var server = new StellarSdk.Server('https://horizon.stellar.org');
		  var assetcode = "<?php echo $assetcode ; ?>";
		  var assetissuer =  "<?php echo $assetissuer ; ?>";
//////////////////////////: table of all bids and asks

		  server.orderbook( new StellarSdk.Asset(assetcode, assetissuer),new StellarSdk.Asset.native())
		  .call()
		  .then(function(resp) {
		  //bids
		  
		 
		 
		   //console.log("younes "+resp["bids"]);
		  for(i=0;i<resp["bids"].length ; i++){
			  //
		var priceinXLM=resp["bids"][i]["price"];
		  var assetamount=resp["bids"][i]["amount"];
		  var XLManount=assetamount/priceinXLM;
		 var finalpriceASK=assetamount/priceinXLM;
			  //
			  
		  /* var priceinXLM=resp["bids"][i]["price"];
		  var assetamount=resp["bids"][i]["amount"];
		  var XLManount=assetamount/priceinXLM;
		 var finalpriceASK=priceinXLM*assetamount;*/
			 //var finalpriceASKstr=finalpriceASK+"";
			 //document.getElementById("bids"+iVariable).textContent=finalpriceASKstr.substring(0,6)+" XLM";
			  var table = document.getElementById("bidstab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				////////test aria
				
					row.setAttribute('onclick','setpricetoboardbuy();'); // for FF
					row.onclick = function() {setpricetoboardbuy();};
					row.setAttribute('id','b'+i);
					
					//hiden element contain the price 
					var xhideprice = document.createElement("INPUT");
						xhideprice.setAttribute("type", "hidden");
						xhideprice.setAttribute("id", "inp"+i);
						xhideprice.setAttribute("value", ""+priceinXLM);
						document.body.appendChild(xhideprice);
				
					//////////////:
				cell1.innerHTML = Number(assetamount).toFixed(7);//substring(0,15);//XLManount.toFixed(7);
				cell2.innerHTML = finalpriceASK.toFixed(7);
				cell3.innerHTML = priceinXLM;
		  } 
			 //asks
			 for(i=0;i<resp["asks"].length ; i++){
				 
			 		var priceinXLM=resp["asks"][i]["price"];
				  var assetamount=resp["asks"][i]["amount"];
				  var XLManount=assetamount/priceinXLM;
				 var finalpriceASK=assetamount*priceinXLM;
		// document.getElementById("asks"+iVariable).textContent=finalpriceASKstr2.substring(0,6)+" XLM";
			// console.log("asks"+finalpriceASK2+" XLM");
			  //console.log("hello tage "+i+" XLM");
			   var table = document.getElementById("askstab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				var cell3 = row.insertCell(2);
				
				////////test aria
				
					row.setAttribute('onclick','setpricetoboardsell();'); // for FF
					row.onclick = function() {setpricetoboardsell();};
					row.setAttribute('id','s'+i);
					
					//hiden element contain the price 
					var xhideprices = document.createElement("INPUT");
						xhideprices.setAttribute("type", "hidden");
						xhideprices.setAttribute("id", "inps"+i);
						xhideprices.setAttribute("value", ""+priceinXLM);
						document.body.appendChild(xhideprices);
				
					//////////////:
				cell1.innerHTML = priceinXLM;
				cell2.innerHTML = Number(assetamount).toFixed(7);//substring(0,20);//XLManount.toFixed(7);
				cell3.innerHTML = finalpriceASK.toFixed(7);
		  }
		  //console.log(resp["bids"][0]["price"]);
	

		  })
	///////////////////////////////////////////////////:

	
	
	
	
	  var databids=[];
  var datalabs=[];
  //datalabs[0]="";//to remove undifined
var table = document.getElementById('alltrads');
    for (var r = 0; r<15 ; r++) {
        //for (var c = 0, m = table.rows[r].cells.length; c < m; c++) {
            if(r<table.rows.length){
				databids[r]=table.rows[r+1].cells[2].innerHTML;
				datalabs[r]="";
			}
        //}
    }

//var myData;
myData = {
		  //labels : ["Mo","Di","Mi","Do","Fr","Sa","So","Mo","Di","Mi","Do","Fr","Sa","So"],
		  labels :datalabs,
		  datasets : [
			{
			  fillColor : "rgba(0,0,220,.5)",
			  strokeColor : "rgba(0,0,220,1)",
			  pointColor : "rgba(0,0,220,1)",
			  pointStrokeColor : "#fff",
			  //data : [1,0.6,0.5,0.4,0.1,0.4,1]
			  data :databids.reverse()
			  //data : [resp["bids"][1]["price"],resp["bids"][2]["price"],resp["bids"][4]["price"]]
			},
			/*{
			  fillColor : "rgba(220,0,0,.5)",
			  strokeColor : "rgba(220,0,0,1)",
			  pointColor : "rgba(220,0,0,1)",
			  pointStrokeColor : "#fff",
			  data : [1,1,1,1,1,1,1]
			  
			  //data : [resp["asks"][1]["price"],resp["asks"][2]["price"],resp["asks"][4]["price"]]
			  //data :dataasks.reverse()
			}*/
			
			  
		  ]
		}
		new Chart(document.getElementById("canvas").getContext("2d")).Line(myData)

////////////////////////////////////////////	
		  
		  //table of my bids and asks
		  var publickeypair = "<?php echo $_SESSION['publickey']; ?>";
		  server.offers('accounts', publickeypair).call()
			 .then(function(offers) {
			 //console.log("zolago"+offers["records"][0]["amount"]);
			 
			 for(i=0;i<offers["records"].length;i++){
				if((offers["records"][i]["selling"]["asset_code"]=="<?php echo $assetcode; ?>" && offers["records"][i]["buying"]["asset_type"]=="native") ||
					(offers["records"][i]["selling"]["asset_type"]=="native" && offers["records"][i]["buying"]["asset_code"]=="<?php echo $assetcode; ?>")){
			
				if(offers["records"][i]["selling"]["asset_code"]=="<?php echo $assetcode; ?>" && offers["records"][i]["buying"]["asset_type"]=="native"){
						var tableoffer = document.getElementById("youroffertab");
					var rowCount = tableoffer.rows.length;
					var row = tableoffer.insertRow(rowCount);
					var cell1 = row.insertCell(0);
					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					
					cell1.innerHTML = offers["records"][i]["amount"]*offers["records"][i]["price"];
					cell2.innerHTML = offers["records"][i]["amount"];
					cell3.innerHTML = offers["records"][i]["price"];
					cell4.setAttribute("id", "cancel"+i);
					
					
					//this hiden input conatins the info if it's bid or ask
						var input = document.createElement("input");
						input.setAttribute("type", "hidden");
						input.setAttribute("name", "offerinputcancel"+i);
						input.setAttribute("id", "itsbidorask"+i);
						input.setAttribute("value", "itsask");
						document.getElementById("cancel"+i).appendChild(input);
						//g.setAttribute("id", "Div1");
					
				}else{
					if(offers["records"][i]["selling"]["asset_type"]=="native" && offers["records"][i]["buying"]["asset_code"]=="<?php echo $assetcode; ?>"){
							
						var tableofferb = document.getElementById("youroffertabbids");
						var rowCountb = tableofferb.rows.length;
						
						var rowb = tableofferb.insertRow(rowCountb);
						//rowb.setAttribute("onclick", "bidsrowprice(),0");
						//rowb.setAttribute('onclick','bidsrowprice()');
						//document.getElementById("youroffertabbids").rows[rowCountb].setAttribute('onclick',bidsrowprice());
						
						var cell1b = rowb.insertCell(0);
						var cell2b = rowb.insertCell(1);
						var cell3b = rowb.insertCell(2);
						var cell4b = rowb.insertCell(3);
						cell1b.innerHTML = Number(offers["records"][i]["amount"]).toFixed(6);
						cell2b.innerHTML = Number(offers["records"][i]["amount"]*offers["records"][i]["price"]).toFixed(6);
						cell3b.innerHTML = ((offers["records"][i]["amount"]/offers["records"][i]["price"])/offers["records"][i]["amount"]).toFixed(6);
						cell4b.setAttribute("id", "cancel"+i) ;
						
								//this hiden input conatins the info if it's bid or ask
						var input = document.createElement("input");
						input.setAttribute("type", "hidden");
						input.setAttribute("name", "offerinputcancel"+i);
						input.setAttribute("id", "itsbidorask"+i);
						input.setAttribute("value", "itsbid");
						document.getElementById("cancel"+i).appendChild(input);
						//g.setAttribute("id", "Div1");

					}
				}
				var btn = document.createElement("BUTTON");
				btn.setAttribute("id", "btncancel"+i);
				btn.setAttribute("class", "button special");
				btn.setAttribute("onclick", "canceltheoffer("+i+")");
				var t = document.createTextNode("Cancel offer");
				btn.appendChild(t);
				document.getElementById("cancel"+i).appendChild(btn);
				
				
				//this hiden input conatins the offer id
				var input = document.createElement("input");
				input.setAttribute("type", "hidden");
				input.setAttribute("name", "offerinputcancel"+i);
				input.setAttribute("id", "offerinputcancel"+i);
				input.setAttribute("value", ""+offers["records"][i]["id"]);
				document.getElementById("cancel"+i).appendChild(input);
				//g.setAttribute("id", "Div1");
				}
			 }
			 
			   console.log(offers);
			 }).catch(function (err) {
					console.error("there's no offers");
				  })
		
		
	
////////////////////////////////////////


/////////////////////// calculate the seel and buy input amount

function calculatesells(clicked_id){
	//alert(clicked_id);
	if(clicked_id==1){
		var pricexlm=document.getElementById("pricexlm").value;
		var amountofToken=document.getElementById("TokenAmoint").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("XLMamount").value=xmlamountres;
	}
	 
	if(clicked_id==2){
		var pricexlm=document.getElementById("pricexlm").value;
		var amountofToken=document.getElementById("TokenAmoint").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("XLMamount").value=xmlamountres;
	}
	if(clicked_id==3){
		var pricexlm=document.getElementById("pricexlm").value;
		var amountofxlm=document.getElementById("XLMamount").value
		var tokenamountres=amountofxlm/pricexlm;
		document.getElementById("TokenAmoint").value=tokenamountres;
	}
}
function calculatesbuy(clicked_id){
	//alert(clicked_id);
	if(clicked_id==1){
		var pricexlm=document.getElementById("pricexlmb").value;
		var amountofToken=document.getElementById("TokenAmointb").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("XLMamountb").value=xmlamountres;
	}
	 
	if(clicked_id==2){
		var pricexlm=document.getElementById("pricexlmb").value;
		var amountofToken=document.getElementById("TokenAmointb").value;
		var xmlamountres=amountofToken*pricexlm;
		document.getElementById("XLMamountb").value=xmlamountres;
	}
	if(clicked_id==3){
		var pricexlm=document.getElementById("pricexlmb").value;
		var amountofxlm=document.getElementById("XLMamountb").value
		var tokenamountres=amountofxlm/pricexlm;
		document.getElementById("TokenAmointb").value=tokenamountres;
	}
}

/////////////////////////////

/////////////////add offer
function addtheofferTokenNative(){
	
	if(document.getElementById('pricexlm').validity.valid==false ||
	 document.getElementById('TokenAmoint').validity.valid==false ||
	 document.getElementById('XLMamount').validity.valid==false){
		alert("Please set the prices");
	 }else{		
	document.getElementById("loader").style.display = "block";	
	document.getElementById("submitsell").disabled = true;
	//alert(clicked_id);
	
	StellarSdk.Network.usePublicNetwork();
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		var assetcode = "<?php echo $assetcode; ?>";
		  var assetissuer = "<?php echo $assetissuer; ?>";
		  var seckeypair = "<?php echo $_SESSION['secretkey']; ?>";
		  var receivingKeys = StellarSdk.Keypair.fromSecret(seckeypair);
		  //var seckeypair = "<?php echo $_SESSION['publickey']; ?>";
		  //var receivingKeys = StellarSdk.Keypair.fromPublicKey(seckeypair);
		 // alert(myofferid);
		 // alert(itsbidorask);
		 
		 //XLMamount TokenAmoint pricexlm
		 var pricexlm=document.getElementById("pricexlm").value;
		 var amountofToken=document.getElementById("TokenAmoint").value;
		 var XLMamount=Number(amountofToken*pricexlm).toFixed(7);
		 var sellprice=(XLMamount/amountofToken).toFixed(14);
	var assettrust = new StellarSdk.Asset(assetcode, assetissuer);
	var assetXLM = StellarSdk.Asset.native();
	 server.loadAccount(receivingKeys.publicKey())
		  .then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			  // The `changeTrust` operation creates (or alters) a trustline
			  // The `limit` parameter below is optional
			  .addOperation(StellarSdk.Operation.manageOffer({
				selling: assettrust,
				buying: assetXLM,
				amount: amountofToken,
				price:sellprice,
				offerId:0,
				//source:""
			  }))
			  .build();
			transaction.sign(receivingKeys);
			
			var result= server.submitTransaction(transaction);
	
			result.then(function (fulfilled) {
			//alert("sucess");
			document.getElementById("loader").style.display = "none";
		document.getElementById("msgofload").style.display = "visible";
		document.getElementById("msgofload").innerHTML = "transaction submited successfully";
		document.getElementById("submitsell").disabled = false;
				location.reload();//
				
			
			}).catch(function (error) {
            // oops, mom don't buy it
			alert("there is an error"+error.message);
			document.getElementById("loader").style.display = "none";
		document.getElementById("msgofload").style.display = "visible";
		document.getElementById("msgofload").innerHTML = "transaction failed";
		document.getElementById("submitsell").disabled = false;
			console.log('failded ' + +error.message);
			//document.getElementById("message").innerHTML = ""+error.message;
         // output: 'mom is not happy'
        });
			//console.log('Balances jdks account: ' + result.resolve().catch("ff"));
			return result;
		  })
	
}	
}

function addtheofferNativeToken(){

	//alert(clicked_id);
	if(document.getElementById('pricexlmb').validity.valid==false ||
	 document.getElementById('TokenAmointb').validity.valid==false ||
	 document.getElementById('XLMamountb').validity.valid==false){
		alert("Please set the prices");
	 }else{	
	document.getElementById("loader2").style.display = "block";	
	document.getElementById("submitbuy").disabled = true;
	
	StellarSdk.Network.usePublicNetwork();
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		var assetcode = "<?php echo $assetcode; ?>";
		  var assetissuer = "<?php echo $assetissuer; ?>";
		  var seckeypair = "<?php echo $_SESSION['secretkey']; ?>";
		  var receivingKeys = StellarSdk.Keypair.fromSecret(seckeypair);
		  //var seckeypair = "<?php echo $_SESSION['publickey']; ?>";
		  //var receivingKeys = StellarSdk.Keypair.fromPublicKey(seckeypair);
		 // alert(myofferid);
		 // alert(itsbidorask);
		  var pricexlm=document.getElementById("pricexlmb").value;
		 var amountofToken=document.getElementById("TokenAmointb").value;
		 var XLMamount=Number(amountofToken*pricexlm).toFixed(7);
		 var sellprice=(amountofToken/XLMamount).toFixed(14);
		// alert("xlm price"+pricexlm);
		 //alert("chrc amont"+amountofToken);
		 //alert("xlm amoyut"+XLMamount);
		 //alert("amount"+XLMamount);
		 //alert("price"+sellprice);
		 
		 
	var assettrust = new StellarSdk.Asset(assetcode, assetissuer);
	var assetXLM = StellarSdk.Asset.native();
			server.loadAccount(receivingKeys.publicKey())
		  .then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			  // The `changeTrust` operation creates (or alters) a trustline
			  // The `limit` parameter below is optional
			  .addOperation(StellarSdk.Operation.manageOffer({
				selling: assetXLM,
				buying: assettrust,
				amount: ""+XLMamount,
				price:sellprice,
				offerId:0,
				//source:""
			  }))
			  .build();
			transaction.sign(receivingKeys);
			
			var result= server.submitTransaction(transaction);
	
			result.then(function (fulfilled) {
				
				document.getElementById("loader2").style.display = "none";
				document.getElementById("msgofload2").style.display = "visible";
				document.getElementById("msgofload2").innerHTML = "transaction submited successfully";
				document.getElementById("submitbuy").disabled = false;
				location.reload();
			//alert("sucess");
			//location.reload();
			}).catch(function (error) {
            // oops, mom don't buy it
			alert("there is an error"+error.message);
			console.log('failded ' +error.message);
				document.getElementById("loader2").style.display = "none";
				document.getElementById("msgofload2").style.display = "visible";
				document.getElementById("msgofload2").innerHTML = "transaction failed";
				document.getElementById("submitbuy").disabled = false;
			//document.getElementById("message").innerHTML = ""+error.message;
         // output: 'mom is not happy'
        });
			//console.log('Balances jdks account: ' + result.resolve().catch("ff"));
			return result;
		  })
	 }
		
	}	

////////////////////////cancel offer 	
function canceltheoffer(clicked_id){
	
	//alert(clicked_id);
	
	document.getElementById("cancel"+clicked_id).setAttribute("class", "loadercancel");
	document.getElementById("btncancel"+clicked_id).textContent="load";
	document.getElementById("btncancel"+clicked_id).disabled = true;
	
	
	StellarSdk.Network.usePublicNetwork();
		var server = new StellarSdk.Server('https://horizon.stellar.org');
		var assetcode = "<?php echo $assetcode; ?>";
		  var assetissuer = "<?php echo $assetissuer; ?>";
		  var myofferid =document.getElementById("offerinputcancel"+clicked_id).value;
		  var itsbidorask =document.getElementById("itsbidorask"+clicked_id).value;
		  var seckeypair = "<?php echo $_SESSION['secretkey']; ?>";
		  var receivingKeys = StellarSdk.Keypair.fromSecret(seckeypair);
		  //var seckeypair = "<?php echo $_SESSION['publickey']; ?>";
		  //var receivingKeys = StellarSdk.Keypair.fromPublicKey(seckeypair);
		 // alert(myofferid);
		 // alert(itsbidorask);
	var assettrust = new StellarSdk.Asset(assetcode, assetissuer);
	var assetXLM = StellarSdk.Asset.native();
	if(itsbidorask=="itsask"){
	 server.loadAccount(receivingKeys.publicKey())
		  .then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			  // The `changeTrust` operation creates (or alters) a trustline
			  // The `limit` parameter below is optional
			  .addOperation(StellarSdk.Operation.manageOffer({
				selling: assettrust,
				buying: assetXLM,
				amount: "0",
				price:1,
				offerId:myofferid,
				//source:""
			  }))
			  .build();
			transaction.sign(receivingKeys);
			
			var result= server.submitTransaction(transaction);
	
			result.then(function (fulfilled) {
			//alert("sucess");
			location.reload();
			}).catch(function (error) {
            // oops, mom don't buy it
			alert("there is an error"+error.message);
			console.log('failded ' + +error.message);
			document.getElementById("cancel"+clicked_id).setAttribute("class", "link-style");
			document.getElementById("btncancel"+clicked_id).textContent="Cancel offer";
			document.getElementById("btncancel"+clicked_id).disabled = false;
			//document.getElementById("message").innerHTML = ""+error.message;
         // output: 'mom is not happy'
        });
			//console.log('Balances jdks account: ' + result.resolve().catch("ff"));
			return result;
		  })
	
	}else{
		if(itsbidorask=="itsbid"){
			server.loadAccount(receivingKeys.publicKey())
		  .then(function(receiver) {
			var transaction = new StellarSdk.TransactionBuilder(receiver)
			  // The `changeTrust` operation creates (or alters) a trustline
			  // The `limit` parameter below is optional
			  .addOperation(StellarSdk.Operation.manageOffer({
				selling: assetXLM,
				buying: assettrust,
				amount: "0",
				price:1,
				offerId:myofferid,
				//source:""
			  }))
			  .build();
			transaction.sign(receivingKeys);
			
			var result= server.submitTransaction(transaction);
	
			result.then(function (fulfilled) {
			//alert("sucess");
			location.reload();
			}).catch(function (error) {
            // oops, mom don't buy it
			alert("there is an error"+error.message);
			console.log('failed ' +error.message);
			document.getElementById("cancel"+clicked_id).setAttribute("class", "link-style");
			document.getElementById("btncancel"+clicked_id).textContent="Cancel offer";
			document.getElementById("btncancel"+clicked_id).disabled = false;
			//document.getElementById("message").innerHTML = ""+error.message;
         // output: 'mom is not happy'
        });
			//console.log('Balances jdks account: ' + result.resolve().catch("ff"));
			return result;
		  })
	
		}
	}
}
function setpricetoboardbuy(){
	
	var idRow=event.currentTarget.id;
	
	var getindex=idRow.charAt(1);
	//alert(""+document.getElementById("inp"+getindex).value);
	document.getElementById("pricexlm").value=document.getElementById("inp"+getindex).value;
	document.getElementById("pricexlmb").value=document.getElementById("inp"+getindex).value;

}	
function setpricetoboardsell(){
	
	var idRow=event.currentTarget.id;
	
	var getindex=idRow.charAt(1);
	//alert(""+document.getElementById("inp"+getindex).value);
	document.getElementById("pricexlm").value=document.getElementById("inps"+getindex).value;
	document.getElementById("pricexlmb").value=document.getElementById("inps"+getindex).value;
	
//alert("dslkdm");
//salert('dsq'+idRow.cells(0).textContent);
//console.log(idRow.cells["1"]);

}

</script>


<?php 
	}else{
		header('Location: stellarSwap-market.php');
	}
?>
</body>
</html>
