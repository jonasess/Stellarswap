# StellarSwap 
Stellarswap is a global exchange board for all Stellar token and cryptocurrencies (coins). Easy sign up, easy trading.
developed by Graichi Younes.

### Requirements (if you are using linux)

*This library requires the cURL extensions for PHP. To enable this extension, see:

   [cURL Installation Guide](http://php.net/manual/en/curl.installation.php)

### Installation

Clone the project or download it and copy it to your main direction ```(Example: /var/www/html/).```
* ``` git clone https://github.com/jonasess/Stellarswap ```

### Configuration:

Set up the configuration of your email server (to enable users reset password) in this file ``` stellarSwap-confresetpassword.php ```
* Check the link
* ``` https://github.com/jonasess/Stellarswap/blob/master/stellarSwap-confresetpassword.php#L41 ```

### Usage:

Sent up the data base tables [Stellarswapdbtables](https://github.com/jonasess/Stellarswap/blob/master/stellardbswap.sql)

Set up your database connection configuration in this directory ``` include/dbconnection.php ```

Run ..
### Add new Stellar token:
1. Add the logo of the asset in the direction ``` logo/... ```

2. Add the information of your asset in the file stellarSwap-assetTokens.js
* Example:
```
[
  'Asset-website',
  'Asset-logo-direction example: logo/myaaset.png',
  'Asset code',
  'Asset issuer'
],
```

3. Do the same step in the file stellarSwap-assetTokens.php , add your asset information in the $asset_tokes array .
* Example
```
array("domain"=>"your-domain-name","logo"=>"Asset-logo-direction","code"=>"Asset code","issuer"=>"Asset issuer id"),
```

And congratulations your asset has been added to the board for the trading.

### Add new cryptocurrency (coin):
To add new coin like (BTC,LTC ... etc) follow the following steps:
1. Go to logo folder and add your coin logo.png there.
2. Add new row in your database (stellarswapbdtables) [stellardbswap.sql](https://github.com/jonasess/Stellarswap/blob/master/stellardbswap.sql#L40)
Fro example you want to add litcoin . add new row named stlitcoinkey in the table stellarswapusers.
3. Go to this file [stellarSwap-checking.php](https://github.com/jonasess/Stellarswap/blob/master/stellarSwap-checking.php#L44)
 and add the information of your coin, as an example:
``` array("logo"=>"logo/litcoin.png","code"=>"LTC","swcoinkey"=>$row["stlitcoinkey"]) ```
4. Go to this file [include/rpcdaemonpassword.php](https://github.com/jonasess/Stellarswap/blob/master/include/rpcdaemonpassword.php#L16) add these lines of your new coin(it's really required to connect your website to your coin daemon via rpc).as example for litcoin
```
else{
if($coincode=="LTC"){
	$coinrpcuser='rpcuser';
	$coinrpcpassword='rpcpassword';
	$coinrpcip='ip address where litcoin daemon is running';
	$coinrpcport='rpcport';
	}
}
```
Also add in the same file here [include/rpcdaemonpassword.php](https://github.com/jonasess/Stellarswap/blob/master/include/rpcdaemonpassword.php#L29) these lines which is related to the passphrase (it's really required for the permissions later on in transactions). As an example for litcoin:
```
else{
if($coincode=="LTC"){
	$passphrase='your passphrase';
	}
}
```
5. Go to this file [stellarSwap-signin-account.php](https://github.com/jonasess/Stellarswap/blob/master/stellarSwap-signin-account.php#L88) and add these lines to allow the new users to get new address for your new added coin. let's take LTC as an example here:
```
$litcoinconnectionrpc=initconnectionrpc("GCH");
$litcoinkey=$litcoinconnectionrpc->getnewaddress("litcoin".$_POST["email"]);
```
then add it to data base
```
if ($stmt = $conn->prepare("INSERT INTO stellarswapusers (swemail,swpassword,swsecretkey,
         swpublickey,swbtccoinkey,swgalaxycashcoinkey,stlitcoinkey) VALUES (?, ?, ?, ?, ?, ?,?)")) 
$stmt->bind_param("sssssss", $email, $password, $sek, $pbk, $btcoinkey, $galaxycashkey,$litcoinkey);
```

6. Finally go to this file [updateusertable/updateoncoinadd.php](https://github.com/jonasess/Stellarswap/blob/master/updateusertable/updateoncoinadd.php)
And add your new coin configuration (litcoin as an example) and run it.
It's really important to do this last step because it will add automatically new litcoin address for example to your users who are already registered in your website befor adding the new coin .

### Note:
Stellarswap uses the rpc to connect to daemon to support any coin (BTC, GCH ...etc).
Giving the ability to create wallet, send and receive payments, exchange vs coins or tokens (stellar tokens) ... etc .

### Goals:
1. Support more coins and tokens.
2. Add more security to the board.

### Warning:
1. History of Stellar trades is under maintenance.
2. There's no History exchanges of coins yet, i will add it soon.
3. One file is missing ```(stellarSwap-tradecoinvstoken.php)``` it's under maintenance for security purpose. contains some mistakes.
4.passwords are saved without encrypt . Need to be encrypted.

### Support me:
If you like the project and you want to support me . You can donate:
* Stellar wallet:``` GDI4HFEIZIPUGMXL7MM5BXRAJKC76XU2EDSS6GML2PL7MBTG6GICUYS3 ```
* BTC wallet:``` 1PD1UBxTajiHEa4oDZex6QN6UT4aRxCDsM ```
* ETH wallet:``` 0x083c01b98810e17b0b6cce27cb1cb37a6a40e4eb ```
* LTC wallet:``` LQ3fQoLJkW7hwuPdWtcPa5YYtAvmsp7UCs ```

You can contact me on GitHub or on my email address jonasess@gmail.com / younes.graichi.93@gmail.com .

## StellarSwap screenshots

### Main page create stellar wallet
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/index.png)

### Create stellarswap wallet (contains stellarswallet and other wallets such as BTC, LTC ...etc)
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/createSWaccount.png)

### Check wallet ids and balances
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/SwAccountwallet.png)

### Send payments (assets && coins) to other wallets
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/sendpayments.png)

### Ability to add trust either from a curated list, manually, or via federation
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/trustline.png)

### Check assets prices and choose the trading pair
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/market.png)

### Price history charts
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/chart.png)

### Ability to make offers (sell or buy)
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/buyandsell.png)

### Ability to cancel offers (sell or buy)
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/canceloffer.png)

### Checking available offers (sell and buy)
![Orderbook](https://raw.githubusercontent.com/jonasess/Stellarswap/master/screenshots/sellandbuyoffers.png)

# And more && more other options ...
