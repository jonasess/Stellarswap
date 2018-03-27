<?php 
				
	include("stellarSwap-session.php");
?>
<!DOCTYPE HTML>
<html>
	<head>
		 <title>History</title>
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
								<input id="1" type="button" onclick="gethistorypayments(1)" value="Payments">
								<input id="6" type="button" onclick="gethistorywithtype(this.id)" value="Trustline">
								<input id="3" disabled type="button" onclick="gethistorywithtype(this.id)" value="Trades(under maintenance)">
			
								<h2>History:</h2>
								<table id="historytab">
								</table>
								<div id="load" class="loader"></div>
								<div id="loadtxt" >loading</div>							
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
  var accountId = "<?php echo $_SESSION['publickey']; ?>";
var server = new StellarSdk.Server('https://horizon.stellar.org');
gethistorypayments(1);
function gethistorypayments(btnid){	
	document.getElementById(btnid).setAttribute("class", "loadercancel");
	document.getElementById(btnid).value="load";
	document.getElementById(btnid).disabled = true;
	//release other buttons
			document.getElementById(6).setAttribute("class", "link-style");
			document.getElementById(6).value="Trustline";
			document.getElementById(6).disabled = false;
			
		/*	document.getElementById(3).setAttribute("class", "link-style");
			document.getElementById(3).value="Trades";
			document.getElementById(3).disabled = false;*/
	//
	var node = document.getElementById("historytab");
	while (node.hasChildNodes()) {
		node.removeChild(node.lastChild);
		}
	
server.payments().forAccount(accountId).limit(200).order("desc")
  .call()
  .then(function (paymentResultsPage) {
   // console.log(paymentResultsPage.records);
  
  for(i=0;i<paymentResultsPage.records.length;i++){
	  //var sss=paymentResultsPage.records[i]["type"];
	  //console.log("llll "+sss);
	  
	  // sss=paymentResultsPage.records[i]["type"];
	  if(paymentResultsPage.records[i]["type_i"]==0){//created account
		
		    var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				
				var node = document.createElement("h2");
				var textnode = document.createTextNode(""+paymentResultsPage.records[i]["type"]);
				node.appendChild(textnode);
				cell1.appendChild(node);
				var node1 = document.createElement("h4");
				var textnode1 = document.createTextNode("STARTING BALANCE: "+paymentResultsPage.records[i]["starting_balance"] +" XLM-native");
				node1.appendChild(textnode1);
				cell1.appendChild(node1);
				var node2 = document.createElement("h4");
				//node2.setAttribute("s", "inps"+i);
				var textnode2 = document.createTextNode("FUNDED BY: "+paymentResultsPage.records[i]["funder"]);
				node2.appendChild(textnode2);
				cell1.appendChild(node2);
				var node3 = document.createElement("h4");
				var textnode3 = document.createTextNode("CREATED ACCOUNT: "+paymentResultsPage.records[i]["account"]);
				node3.appendChild(textnode3);
				cell1.appendChild(node3);
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION HASH: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
				
		
	  }else{
		  if(paymentResultsPage.records[i]["type_i"]==1){//send and receive payments
			  if(paymentResultsPage.records[i]["asset_type"]!='native'){
				  var asset_code=paymentResultsPage.records[i]["asset_code"]
				  var asset_issuer=paymentResultsPage.records[i]["asset_issuer"];
			  }else{
				 var asset_code="XLX";
				 var asset_issuer="native";
			  }  
				  var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				var node = document.createElement("h2");
				if(paymentResultsPage.records[i]["source_account"]==accountId){
					var textnode = document.createTextNode("SENT");
					node.appendChild(textnode);
					cell1.appendChild(node);
				}else{
					var textnode = document.createTextNode("Received");
					node.appendChild(textnode);
					cell1.appendChild(node);
					
				}
				var node1 = document.createElement("h4");
				var textnode1 = document.createTextNode("AMOUNT: "+paymentResultsPage.records[i]["amount"] +" "+asset_code+" "+paymentResultsPage.records[i]["asset_type"]);
				node1.appendChild(textnode1);
				cell1.appendChild(node1);
				var node2 = document.createElement("h5");
				var textnode2 = document.createTextNode("ASSET ISSUER: "+asset_issuer);
				node2.appendChild(textnode2);
				cell1.appendChild(node2);
				var node3 = document.createElement("h4");
				if(paymentResultsPage.records[i]["source_account"]==accountId){
					var textnode3 = document.createTextNode("TO: "+paymentResultsPage.records[i]["to"]);
					node3.appendChild(textnode3);
					cell1.appendChild(node3);
				}else{
					var textnode3 = document.createTextNode("FROM: "+paymentResultsPage.records[i]["source_account"]);
					node3.appendChild(textnode3);
					cell1.appendChild(node3);					
				}
				
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION HASH: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
		  }
	  }
	  
	  }
  if(paymentResultsPage.records.length=="200"){
	  rec(paymentResultsPage.next(),btnid);
  }else{
	  document.getElementById(btnid).setAttribute("class", "link-style");
			document.getElementById(btnid).value="Payments";
			document.getElementById(btnid).disabled = false;
	  var loadmycercol = document.getElementById("load").style.visibility="hidden";
	var loadtext = document.getElementById("loadtxt").style.visibility="hidden";
  }
	  
	})
  .catch(function (err) {
			document.getElementById(clicked_id).setAttribute("class", "link-style");
			document.getElementById(clicked_id).value="Payments";
			document.getElementById(clicked_id).disabled = false;
	  var loadmycercol = document.getElementById("load").style.visibility="hidden";
	var loadtext = document.getElementById("loadtxt").style.visibility="hidden";
    console.log(err)
  });


}  
  //loadmycercol.style.visibility = 'hidden';
  
  function rec(paymentResultsPage,btnid){
	paymentResultsPage.then(function (paymentResultsPage) {
	for(i=0;i<paymentResultsPage.records.length;i++){
	  //var sss=paymentResultsPage.records[i]["type"];
	  //console.log("llll "+sss);
	  
	  // sss=paymentResultsPage.records[i]["type"];
	  if(paymentResultsPage.records[i]["type_i"]==0){//created account
		
		    var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				
				var node = document.createElement("h2");
				var textnode = document.createTextNode(""+paymentResultsPage.records[i]["type"]);
				node.appendChild(textnode);
				cell1.appendChild(node);
				var node1 = document.createElement("h4");
				var textnode1 = document.createTextNode("STARTING BALANCE: "+paymentResultsPage.records[i]["starting_balance"] +" XLM-native");
				node1.appendChild(textnode1);
				cell1.appendChild(node1);
				var node2 = document.createElement("h4");
				var textnode2 = document.createTextNode("FUNDED BY: "+paymentResultsPage.records[i]["funder"]);
				node2.appendChild(textnode2);
				cell1.appendChild(node2);
				var node3 = document.createElement("h4");
				var textnode3 = document.createTextNode("CREATED ACCOUNT: "+paymentResultsPage.records[i]["account"]);
				node3.appendChild(textnode3);
				cell1.appendChild(node3);
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION HASH: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
				
		
	  }else{
		  if(paymentResultsPage.records[i]["type_i"]==1){//send and receive payments
			  if(paymentResultsPage.records[i]["asset_type"]!='native'){
				  var asset_code=paymentResultsPage.records[i]["asset_code"]
				  var asset_issuer=paymentResultsPage.records[i]["asset_issuer"];
			  }else{
				 var asset_code="XLX";
				 var asset_issuer="native";
			  }  
				  var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				
				var node = document.createElement("h2");
				if(paymentResultsPage.records[i]["source_account"]==accountId){
					var textnode = document.createTextNode("SENT");
					node.appendChild(textnode);
					cell1.appendChild(node);
				}else{
					var textnode = document.createTextNode("Received");
					node.appendChild(textnode);
					cell1.appendChild(node);
					
				}
				var node1 = document.createElement("h4");
				var textnode1 = document.createTextNode("AMOUNT: "+paymentResultsPage.records[i]["amount"] +" "+asset_code+" "+paymentResultsPage.records[i]["asset_type"]);
				node1.appendChild(textnode1);
				cell1.appendChild(node1);
				var node2 = document.createElement("h5");
				var textnode2 = document.createTextNode("ASSET ISSUER: "+asset_issuer);
				node2.appendChild(textnode2);
				cell1.appendChild(node2);
				var node3 = document.createElement("h4");
				if(paymentResultsPage.records[i]["source_account"]==accountId){
					var textnode3 = document.createTextNode("TO: "+paymentResultsPage.records[i]["to"]);
					node3.appendChild(textnode3);
					cell1.appendChild(node3);
				}else{
					var textnode3 = document.createTextNode("FROM: "+paymentResultsPage.records[i]["source_account"]);
					node3.appendChild(textnode3);
					cell1.appendChild(node3);					
				}
				
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION HASH: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
		  }
	  }
	  
	  }
  if(paymentResultsPage.records.length=="200"){
	  rec(paymentResultsPage.next(),btnid);
  }else{
	  document.getElementById(btnid).setAttribute("class", "link-style");
			document.getElementById(btnid).value="Payments";
			document.getElementById(btnid).disabled = false;
	  var loadmycercol = document.getElementById("load").style.visibility="hidden";
	var loadtext = document.getElementById("loadtxt").style.visibility="hidden";
  }
	})
  .catch(function (err) {
	  document.getElementById(btnid).setAttribute("class", "link-style");
			document.getElementById(btnid).value="Payments";
			document.getElementById(btnid).disabled = false;
	  var loadmycercol = document.getElementById("load").style.visibility="hidden";
	var loadtext = document.getElementById("loadtxt").style.visibility="hidden";
    console.log(err)
  });
}
  
  
  
function gethistorywithtype(clicked_id){
	
	document.getElementById(clicked_id).setAttribute("class", "loadercancel");
	document.getElementById(clicked_id).value="load";
	document.getElementById(clicked_id).disabled = true;
	
	if(clicked_id==6){
		//release other buttons
			document.getElementById(1).setAttribute("class", "link-style");
			document.getElementById(1).value="Payments";
			document.getElementById(1).disabled = false;
			
			/*document.getElementById(3).setAttribute("class", "link-style");
			document.getElementById(3).value="Trades";
			document.getElementById(3).disabled = false;*/
	//
	}else{
		if(clicked_id==3){
			//release other buttons
			document.getElementById(1).setAttribute("class", "link-style");
			document.getElementById(1).value="Payments";
			document.getElementById(1).disabled = false;
			
			document.getElementById(6).setAttribute("class", "link-style");
			document.getElementById(6).value="Trustline";
			document.getElementById(6).disabled = false;
	//
		}
	}
	
	var node = document.getElementById("historytab");
	while (node.hasChildNodes()) {
		node.removeChild(node.lastChild);
		}	
server.operations()
    .forAccount(accountId).limit(200).order("desc")
    .call()
    .then(function (paymentResultsPage) {
        console.log('Page 1: ');
        console.log(paymentResultsPage.records);
		
        //return page.next();
	
	
		
		
		  
  for(i=0;i<paymentResultsPage.records.length;i++){
	  //var sss=paymentResultsPage.records[i]["type"];
	  //console.log("llll "+sss);
	  
	  // sss=paymentResultsPage.records[i]["type"];
	  if(paymentResultsPage.records[i]["type_i"]==6 && clicked_id==6){//type 6 for trust lines 
		//alert("s");
		    var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				
				var node = document.createElement("h2");
				if(paymentResultsPage.records[i]["limit"]==0){
					var textnode = document.createTextNode("Trustline removed");
				}else{
					var textnode = document.createTextNode("Trustline created");
				}
				node.appendChild(textnode);
				cell1.appendChild(node);
				var node1 = document.createElement("h4");
				var textnode1 = document.createTextNode("ASSET: "+paymentResultsPage.records[i]["asset_code"]);
				node1.appendChild(textnode1);
				cell1.appendChild(node1);
				var node2 = document.createElement("h4");
				//node2.setAttribute("s", "inps"+i);
				var textnode2 = document.createTextNode("ASSET ISSUER: "+paymentResultsPage.records[i]["asset_issuer"]);
				node2.appendChild(textnode2);
				cell1.appendChild(node2);
				var node3 = document.createElement("h4");
				var textnode3 = document.createTextNode("LIMIT: "+paymentResultsPage.records[i]["limit"]);
				node3.appendChild(textnode3);
				cell1.appendChild(node3);
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION ID: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
				
		
	  }else{
		  //alert("s"+paymentResultsPage.records[i]["type_i"]);
		 /* if(paymentResultsPage.records[i]["type_i"]==3 && clicked_id==3){//send and receive payments
			  if(paymentResultsPage.records[i]["asset_type"]!='native'){
				  var asset_code=paymentResultsPage.records[i]["asset_code"]
				  var asset_issuer=paymentResultsPage.records[i]["asset_issuer"];
			  }else{
				 var asset_code="XLX";
				 var asset_issuer="native";
			  }  
				  var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				var node = document.createElement("h2");
				var textnode = document.createTextNode("Traded:");
				node.appendChild(textnode);
				cell1.appendChild(node);
				
				
				if(paymentResultsPage.records[i]["buying_asset_type"]=="native"){
					var node1 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode1 = document.createTextNode("SOLD: 0.000 "+paymentResultsPage.records[i]["selling_asset_code"]);
					}else{
						var textnode1 = document.createTextNode("SOLD: "+paymentResultsPage.records[i]["amount"] +" "+paymentResultsPage.records[i]["selling_asset_code"]);
					}
					node1.appendChild(textnode1);
					cell1.appendChild(node1);
					var node2 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode2 = document.createTextNode("BOUGHT: 0.000 XLM");
					}else{
						var textnode2 = document.createTextNode("BOUGHT: "+paymentResultsPage.records[i]["amount"]*paymentResultsPage.records[i]["price"] +" XLM");
					}
					node2.appendChild(textnode2);
					cell1.appendChild(node2);
				}else{
					var node1 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode1 = document.createTextNode("BOUGHT: 0.000 XLM");
					}else{
						var textnode1 = document.createTextNode("SOLD: "+paymentResultsPage.records[i]["amount"] +" XLM");
					}
					node1.appendChild(textnode1);
					cell1.appendChild(node1);
					var node2 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode2 = document.createTextNode("SOLD: 0.000 "+paymentResultsPage.records[i]["selling_asset_code"]);
					}else{
						var textnode2 = document.createTextNode("BOUGHT: "+paymentResultsPage.records[i]["amount"]*paymentResultsPage.records[i]["price"] +" "+paymentResultsPage.records[i]["selling_asset_code"]);
					}
					node2.appendChild(textnode2);
					cell1.appendChild(node2);
				}
				
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION HASH: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
		  }*/
	  }
	  
	  }
  if(paymentResultsPage.records.length=="200"){
	  recforhistorywithtype(paymentResultsPage.next(),clicked_id);
  }else{
	  
	  if(clicked_id==6){
			document.getElementById(6).setAttribute("class", "link-style");
			document.getElementById(6).value="Trustline";
			document.getElementById(6).disabled = false;
	//
	}else{
		if(clicked_id==3){
			document.getElementById(3).setAttribute("class", "link-style");
			document.getElementById(3).value="Trades";
			document.getElementById(3).disabled = false;
			
			
		}
	}
			
  }
		
		
    })
    .catch(function (err) {
		
		if(clicked_id==6){
				document.getElementById(6).setAttribute("class", "link-style");
				document.getElementById(6).value="Trustline";
				document.getElementById(6).disabled = false;
		//
		}else{
			if(clicked_id==3){
				document.getElementById(3).setAttribute("class", "link-style");
				document.getElementById(3).value="Trades";
				document.getElementById(3).disabled = false;
				
				
			}
		}
        console.log(err);
    });
}

 function recforhistorywithtype(paymentResultsPage,btnid){
	paymentResultsPage.then(function (paymentResultsPage) {
	for(i=0;i<paymentResultsPage.records.length;i++){
	  //var sss=paymentResultsPage.records[i]["type"];
	  //console.log("llll "+sss);
	  
	  // sss=paymentResultsPage.records[i]["type"];
	  if(paymentResultsPage.records[i]["type_i"]==6 && btnid==6){//type 6 for trust lines 
		
		    var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				
				var node = document.createElement("h2");
				if(paymentResultsPage.records[i]["limit"]==0){
					var textnode = document.createTextNode("Trustline created");
				}else{
					var textnode = document.createTextNode("Trustline removed");
				}
				node.appendChild(textnode);
				cell1.appendChild(node);
				var node1 = document.createElement("h4");
				var textnode1 = document.createTextNode("ASSET: "+paymentResultsPage.records[i]["asset_code"]);
				node1.appendChild(textnode1);
				cell1.appendChild(node1);
				var node2 = document.createElement("h4");
				//node2.setAttribute("s", "inps"+i);
				var textnode2 = document.createTextNode("ASSET ISSUER: "+paymentResultsPage.records[i]["asset_issuer"]);
				node2.appendChild(textnode2);
				cell1.appendChild(node2);
				var node3 = document.createElement("h4");
				var textnode3 = document.createTextNode("LIMIT: "+paymentResultsPage.records[i]["limit"]);
				node3.appendChild(textnode3);
				cell1.appendChild(node3);
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION ID: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
	  }else{
		  /* if(paymentResultsPage.records[i]["type_i"]==3 && btnid==3){//send and receive payments
			  if(paymentResultsPage.records[i]["asset_type"]!='native'){
				  var asset_code=paymentResultsPage.records[i]["asset_code"]
				  var asset_issuer=paymentResultsPage.records[i]["asset_issuer"];
			  }else{
				 var asset_code="XLX";
				 var asset_issuer="native";
			  }  
				  var table = document.getElementById("historytab");
			  var rowCount = table.rows.length;
				var row = table.insertRow(rowCount);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				cell2.style.color = "#000";
				cell1.style.color = "#000";
				var node = document.createElement("h2");
				var textnode = document.createTextNode("Traded:");
				node.appendChild(textnode);
				cell1.appendChild(node);
				
				
				if(paymentResultsPage.records[i]["buying_asset_type"]=="native"){
					var node1 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode1 = document.createTextNode("SOLD: 0.000 "+paymentResultsPage.records[i]["selling_asset_code"]);
					}else{
						var textnode1 = document.createTextNode("SOLD: "+paymentResultsPage.records[i]["amount"] +" "+paymentResultsPage.records[i]["selling_asset_code"]);
					}
					node1.appendChild(textnode1);
					cell1.appendChild(node1);
					var node2 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode2 = document.createTextNode("BOUGHT: 0.000 XLM");
					}else{
						var textnode2 = document.createTextNode("BOUGHT: "+paymentResultsPage.records[i]["amount"]*paymentResultsPage.records[i]["price"] +" XLM");
					}
					node2.appendChild(textnode2);
					cell1.appendChild(node2);
				}else{
					var node1 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode1 = document.createTextNode("BOUGHT: 0.000 XLM");
					}else{
						var textnode1 = document.createTextNode("SOLD: "+paymentResultsPage.records[i]["amount"] +" XLM");
					}
					node1.appendChild(textnode1);
					cell1.appendChild(node1);
					var node2 = document.createElement("h4");
					if(paymentResultsPage.records[i]["selling_asset_code"]=="REMOVE"){
						var textnode2 = document.createTextNode("SOLD: 0.000 "+paymentResultsPage.records[i]["selling_asset_code"]);
					}else{
						var textnode2 = document.createTextNode("BOUGHT: "+paymentResultsPage.records[i]["amount"]*paymentResultsPage.records[i]["price"] +" "+paymentResultsPage.records[i]["selling_asset_code"]);
					}
					node2.appendChild(textnode2);
					cell1.appendChild(node2);
				}
				
				var node4 = document.createElement("h6");
				var textnode4 = document.createTextNode("TRANSACTION HASH: "+paymentResultsPage.records[i]["transaction_hash"]);
				node4.appendChild(textnode4);
				cell1.appendChild(node4);
				var node5 = document.createElement("h3");
				var textnode5 = document.createTextNode(""+paymentResultsPage.records[i]["created_at"]);
				node5.appendChild(textnode5);
				cell2.appendChild(node5);
		  }*/
	  }
	  
	  }
  if(paymentResultsPage.records.length=="200"){
	  recforhistorywithtype(paymentResultsPage.next(),btnid);
  }else{

	if(btnid==6){
			document.getElementById(6).setAttribute("class", "link-style");
			document.getElementById(6).value="Trustline";
			document.getElementById(6).disabled = false;
	//
	}else{
		if(btnid==3){
			document.getElementById(3).setAttribute("class", "link-style");
			document.getElementById(3).value="Trades";
			document.getElementById(3).disabled = false;
			
		}
	}
  }
	})
  .catch(function (err) {
	  if(btnid==6){
			document.getElementById(6).setAttribute("class", "link-style");
			document.getElementById(6).value="Trustline";
			document.getElementById(6).disabled = false;
	//
	}else{
		if(btnid==3){
			document.getElementById(3).setAttribute("class", "link-style");
			document.getElementById(3).value="Trades";
			document.getElementById(3).disabled = false;
			
		}
	}
    console.log(err)
  });
}
 



	/*
server.transactions()
    .forAccount(accountId)
    .call()
    .then(function (page) {
        console.log('Page 1: ');
        console.log(page.records);
        return page.next();
    })
    .then(function (page) {
        console.log('Page 2: ');
        console.log(page.records);
    })
    .catch(function (err) {
        console.log(err);
    });
  */
</script>
</body>
</html>