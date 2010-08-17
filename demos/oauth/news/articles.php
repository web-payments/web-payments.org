<?php
include 'config.inc';
include 'payswarmdb.inc';

// get the session ID if it exists
$id = 0;
if(array_key_exists("session", $_COOKIE))
{
   $id = $_COOKIE["session"];
}

// get the payment token if it exists
$ps = new payswarm;
$ptok = $ps->load($id);

if($ptok !== false and $ptok['state'] == "valid")
{
   // check to make sure that the customer associated with the OAuth token 
   // has purchased access to the current URL
   $oauth = new OAuth(
      $CONSUMER_KEY, $CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1);

   // enable debug output for OAuth and remove SSL checks
   $oauth->enableDebug();
   $oauth->disableSSLChecks();
   $oauth->setToken($ptok['token'], $ptok['secret']);
   $params = array(
      'asset' => 'http://example.org/news/myarticle.html',
      'license' => 'http://example.org/licenses/personal-use',
      'license_hash' => '866f3f9540e572e8cc4467f470a869242db201ba');
   try
   {
      $oauth->fetch($CONTRACTS_URL, $params);
      $json_txt = $oauth->getLastResponse();
      $json = json_decode($json_txt);
      //error(print_r($json, true));

      // if the payment token state for the current story is set to 3, then
      // the story has been purchased, so display the full story
      $fh = fopen("articles/full.html", "r");
      print(fread($fh, 32768));
      fclose($fh);
   }
   catch(OAuthException $E)
   {
      error($E);
   }
}
else
{
   error("Couldn't find a payment token!");
}
?>
