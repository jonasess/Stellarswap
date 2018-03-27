# StellarSwap 
Stellarswap is a global exchange board for all Stellar token and cryptocurrencies (coins). Easy sign up, easy trading.
developed by Graichi Younes.

### Requirements

This part will be removed in the future since i will no longer support block.io api (i will move to other unlimited choices).

*This library requires the 'gmp', and cURL extensions for PHP. To enable these extensions, see:
   
   [GMP Installation Guide](http://php.net/manual/en/gmp.installation.php)

   [cURL Installation Guide](http://php.net/manual/en/curl.installation.php)
   
[Also check Block.io on how for more information.](https://github.com/BlockIo/block_io-php)


### Installation

Clone the project or download it and copy it to your main direction ```(Example: /var/www/html/).```
* ``` git clone https://github.com/jonasess/Stellarswap ```

### Usage:

Sent up the data base tables ...

Set up your database connection in this directory ``` include/dbconnection.php ```

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
Details soon.
Hint you need to use api or daemons.

### Note:
Stellarswap use the api from block.io to support 3 coins (BTC, LTC and DOGE).
Giving the ability to create wallet, send and receive payments, exchange vs coins or tokens (stellar tokens) ... etc .

### Goals:
1. block.io api is limited, one of the goals is to change it and connect the board to daemon file of BTC or any other coin to give more control and unlimited usage.
2. Support more coins and tokens.
3. Add more security to the board.

### Warning:
1. For stellarswap account reset the password function is not working (under maintenance).
2. History of Stellar trades is under maintenance.
3. There's no History exchanges of coins yet, i will add it soon.
4. One fike is missing ```(stellarSwap-tradecoinvstoken.php)``` it's under maintenance for security purpose.

### Support me:
If you like the project and you want to support me . You can donate:
* Stellar wallet:``` GDI4HFEIZIPUGMXL7MM5BXRAJKC76XU2EDSS6GML2PL7MBTG6GICUYS3 ```
* BTC wallet:``` 1PD1UBxTajiHEa4oDZex6QN6UT4aRxCDsM ```
* ETH wallet:``` 0x083c01b98810e17b0b6cce27cb1cb37a6a40e4eb ```
* LTC wallet:``` LQ3fQoLJkW7hwuPdWtcPa5YYtAvmsp7UCs ```

You can contact me on GitHub or on my email address jonasess@gmail.com / younes.graichi.93@gmail.com .

## StellarSwap screenshots from localhost

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

### Check the assets prices and choose the trading pair
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
