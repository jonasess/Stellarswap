<?php
function initconnectionrpc($coincode){
if($coincode=="BTC"){ 
	//bitcoin
	$coinrpcuser='rpcuser';
	$coinrpcpassword='rpcpassworf';
	$coinrpcip='ip address where daemon is running';
	$coinrpcport='rpcport';
}else{
	//galaxycash
	if($coincode=="GCH"){
	$coinrpcuser='rpcuser';
	$coinrpcpassword='rpcpassworf';
	$coinrpcip='ip address where daemon is running';
	$coinrpcport='rpcport';
	}
	}
	$coinconnectionrpc = new Bitcoin($coinrpcuser,$coinrpcpassword,$coinrpcip,$coinrpcport);
	return $coinconnectionrpc;
}
function getpassphrase($coincode){
	if($coincode=="BTC"){ 
	//bitcoin
	$passphrase='your passphrase';
}else{
	//galaxycash
	if($coincode=="GCH"){
	$passphrase='your passphrase';
	}
	}
	return $passphrase;
}
?>