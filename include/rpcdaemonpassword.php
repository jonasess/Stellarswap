<?php
function initconnectionrpc($coincode){
if($coincode=="BTC"){ 
	//bitcoin
	$coinrpcuser='shamim';
	$coinrpcpassword='shamimbitcoin$$';
	$coinrpcip='195.201.158.189';
	$coinrpcport='8332';
}else{
	//galaxycash
	if($coincode=="GCH"){
	$coinrpcuser='galaxycashcrypto';
	$coinrpcpassword='galaxycashcrypto22ptoexchange$$';
	$coinrpcip='195.201.158.189';
	$coinrpcport='7676';
	}
	}
	$coinconnectionrpc = new Bitcoin($coinrpcuser,$coinrpcpassword,$coinrpcip,$coinrpcport);
	return $coinconnectionrpc;
}
function getpassphrase($coincode){
	if($coincode=="BTC"){ 
	//bitcoin
	$passphrase='...';
}else{
	//galaxycash
	if($coincode=="GCH"){
	$passphrase='test test';
	}
	}
	return $passphrase;
}
?>