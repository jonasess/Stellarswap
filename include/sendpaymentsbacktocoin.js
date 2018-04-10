"use strict";
function sendpayments(myseckeypkey,destinationId,amountsend,assetcode,assetissuer){	
StellarSdk.Network.usePublicNetwork();
var server = new StellarSdk.Server('https://horizon.stellar.org');
var sourceKeys = StellarSdk.Keypair
  .fromSecret(myseckeypkey);

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

server.loadAccount(destinationId)
  // If the account is not found, surface a nicer error message for logging.
  .catch(StellarSdk.NotFoundError, function (error) {
    throw new Error('check wallet id');
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
      .addMemo(StellarSdk.Memo.text('coin exchange'))
      .build();
    // Sign the transaction to prove you are actually the person sending it.
    transaction.sign(sourceKeys);
    // And finally, send it off to Stellar!
    return server.submitTransaction(transaction);
  })
  .then(function(result) {
    console.log('Success! ');
	//location.reload();
	//return true;
  })
  .catch(function(error) {
	
	
//location.reload();
    console.error('Something went wrong!', error.message);
    // If the result is unknown (no response body, timeout etc.) we simply resubmit
    // already built transaction:
    // server.submitTransaction(transaction);
  });
	 

}