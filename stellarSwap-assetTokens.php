
  <?php
//include("stellarSwap-session.php");

error_reporting(E_ERROR | E_PARSE);

			$json_string ='https://horizon.stellar.org/accounts/'.$_SESSION['publickey'];
			$jsondata = file_get_contents($json_string);
			$obj = json_decode($jsondata,true);
			//echo "<pre>";
		//print_r($obj);
		
		
  $asset_tokes = array
  (
  array("domain"=>"anclax.com","logo"=>"logo/anclax.com.png","code"=>"COP","issuer"=>"GAEDLNMCQZOSLY7Y4NW3DTEWQEVVCXYYMBDNGPPGBMQH4GFYECBI7YVK"),
  array("domain"=>"charnatoken.top","logo"=>"logo/charnatoken.top.png","code"=>"CHRC","issuer"=>"GBRPTWEZTUKYM6VJXLHXBFI23M2GSY3TCVIQSZKFQLMOJXH7VPDGKBDP"),
  array("domain"=>"coins.asia","logo"=>"logo/coins.asia.png","code"=>"PHP","issuer"=>"GBUQWP3BOUZX34TOND2QV7QQ7K7VJTG6VSE7WMLBTMDJLLAW7YKGU6EP"),
  array("domain"=>"collective21.org","logo"=>"logo/collective21.org.png","code"=>"SEED","issuer"=>"GDPFSEBZO2W4TLWZO7FIMMG3QONHXYVF6LUULI6HUJS6PJLE4TRZEXLF"),
  array("domain"=>"equid.co","logo"=>"logo/equid.co.png","code"=>"EQD","issuer"=>"GCGEQJR3E5BVMQYSNCHPO6NPP3KOT4VVZHIOLSRSNLE2GFY7EWVSLLTN"),
 // array("domain"=>"irene.energy","logo"=>"logo/irene.energy.png","code"=>"TELLUS","issuer"=>"GBBRMEXJMS3L7Y3DZZ2AHBD545GZ72OAEHHEFKGZAHHASHGWMHK5P6PL"),
  array("domain"=>"liquido.i-server.org","logo"=>"logo/liquido.i-server.org.png","code"=>"XLQ","issuer"=>"GD2RRX6BKVTORZ6RIMBLWFVUOAYOLTS2QFJQUQPXLI3PBHR3TMLQNGZX"),
  array("domain"=>"mobius.network","logo"=>"logo/mobius.network.png","code"=>"MOBI","issuer"=>"GA6HCMBLTZS5VYYBCATRBRZ3BZJMAFUDKYYF6AH6MVCMGWMRDNSWJPIH"),
  //array("domain"=>"moni.com","logo"=>"logo/moni.com.png","code"=>"EUR","issuer"=>"GAKBPBDMW6CTRDCXNAPSVJZ6QAN3OBNRG6CWI27FGDQT2ZJJEMDRXPKK"),
  array("domain"=>"ripplefox.com","logo"=>"logo/ripplefox.com.png","code"=>"CNY","issuer"=>"GAREELUB43IRHWEASCFBLKHURCGMHE5IF6XSE7EXDLACYHGRHM43RFOX"),
  array("domain"=>"smartlands.io","logo"=>"logo/smartlands.io.png","code"=>"SLT","issuer"=>"GCKA6K5PCQ6PNF5RQBF7PQDJWRHO6UOGFMRLK3DYHDOI244V47XKQ4GP"),
  array("domain"=>"stemchain.io","logo"=>"logo/stemchain.io.png","code"=>"STEM","issuer"=>"GAFXX2VJE2EGLLY3EFA2BQXJADAZTNR7NC7IJ6LFYPSCLE7AI3AK3B3M"),
  array("domain"=>"stronghold","logo"=>"logo/stronghold.co.png","code"=>"ETH","issuer"=>"GBSTRH4QOTWNSVA6E4HFERETX4ZLSR3CIUBLK7AXYII277PFJC4BBYOG"),
  array("domain"=>"apay.io","logo"=>"logo/papayame.com.png","code"=>"BCH","issuer"=>"GAEGOS7I6TYZSVHPSN76RSPIVL3SELATXZWLFO4DIAFYJF7MPAHFE7H4"),
  array("domain"=>"sureremit.co","logo"=>"logo/sureremit.co.png","code"=>"RMT","issuer"=>"GCVWTTPADC5YB5AYDKJCTUYSCJ7RKPGE4HT75NIZOUM4L7VRTS5EKLFN"),
  array("domain"=>"tempo.eu.com","logo"=>"logo/tempo.eu.com.png","code"=>"EURT","issuer"=>"GAP5LETOV6YIE62YAM56STDANPRDO7ZFDBGSNHJQIYGGKSMOZAHOOS2S"),
  array("domain"=>"vcbear.net","logo"=>"logo/vcbear.net.png","code"=>"XRP","issuer"=>"GA7FCCMTTSUIC37PODEL6EOOSPDRILP6OQI5FWCWDDVDBLJV72W6RINZ"),
  array("domain"=>"xirkle.com","logo"=>"logo/xirkle.com.png","code"=>"XIR","issuer"=>"GAO4DADCRAHA35GD6J3KUNOB5ELZE5D6CGPSJX2WBMEQV7R2M4PGKJL5")
  );
   $asset_alreadyaccepted = array(array("code"=>"XLM","issuer"=>"native"));

		for($i=0;$i<sizeof($obj['balances']);$i++){
			if($obj['balances'][$i]['asset_type']!='native'){
				array_push($asset_alreadyaccepted,["code"=>$obj['balances'][$i]['asset_code'] ,"issuer"=>$obj['balances'][$i]['asset_issuer']]);
			}
			for($j=0;$j<sizeof($asset_tokes);$j++){
				if($obj['balances'][$i]['asset_type']!='native'){
				if($obj['balances'][$i]['asset_code']==$asset_tokes[$j]['code'] && $obj['balances'][$i]['asset_issuer']==$asset_tokes[$j]['issuer']){
					//$boll=false;
					$boll=true;
					$j=sizeof($asset_tokes)+2;
				}else{
					$boll=false;
				}
				}else{
					$boll=false;
				}
		}
		if($boll==false){
		if($obj['balances'][$i]['asset_type']=='native'){
					array_push($asset_tokes, ["domain"=>"Stellar.org", "logo"=>"logo/stellar.png","code"=>"XLM" ,"issuer"=>"native"]);
				}else{
					array_push($asset_tokes, ["domain"=>"Unknow", "logo"=>"logo/unknown.png","code"=>$obj['balances'][$i]['asset_code'] ,"issuer"=>$obj['balances'][$i]['asset_issuer']]);
				}
		}
		}
			//	echo "<pre>";
		//print_r($asset_alreadyaccepted);
		
		 
?>