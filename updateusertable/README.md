Only run these two files in these cases:
Run updateondaemonchange.php when you change any daemon (for example bitcoin daemon) to change the addresses of all users.
Be careful it's so sensitive and users may loose their balance because changing daemon means changing the node.

Run updateoncoinadd.php whenever you add new coin to the list. by running this file the users who registered in the website(Stellarswap board)
will get new address for the new coin (in other words this file will generate new addresses from the added new coin to your registered users)