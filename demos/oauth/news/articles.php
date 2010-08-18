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
      'asset' => "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
      'license' => 'http://example.org/licenses/personal-use',
      'license_hash' => '866f3f9540e572e8cc4467f470a869242db201ba');

   // see if we can fetch an existing license for the given URL
   $article = $_GET['article'];
   $json = "{}";
   $random = rand(2, 9999);
   try
   {
      $oauth->fetch($CONTRACTS_URL, $params);
      $json = $oauth->getLastResponse();
   }
   catch(OAuthException $E)
   {
      // if we can't fetch a license but the payment token is valid, 
      // redirect to the purchase stage
      $redir_url = "$BUY_URL/$article";
      header("Location: $redir_url");
   }
   $json = str_replace("\"", "\\\"", $json);
   $json = str_replace("<", "&lt;", $json);

   // if the payment token state for the current story is set to 3, then
   // the story has been purchased, so display the full story
   $fh = fopen("articles/full.html", "r");
   $html = fread($fh, 32768);
   $html = str_replace("%ARTICLE%", print_r($article, true), $html);
   $html = str_replace("%RANDOM%", print_r($random, true), $html);
   $html = str_replace("%BALANCE%", $ptok['amount'], $html);
   $html = str_replace("%CONTRACT%", $json, $html);
   print($html);
   fclose($fh);
}
else
{
   error("Couldn't find a payment token!");
}
?>
