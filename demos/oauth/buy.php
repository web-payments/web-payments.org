<?php
include './inc/payswarmdb.inc'; 

$consumer_key = 'devclient';
$consumer_secret = 'password';
$payswarm_api_server = "localhost:19100";
$preview_url = 'https://' . $_SERVER['SERVER_NAME'] . 
   '/payswarm.com/demos/oauth/previews/1';

// get the session ID if it exists
$id = 0;
if(array_key_exists("session", $_COOKIE))
{
   $id = $_COOKIE["session"];
}
else if(array_key_exists("session", $_GET))
{
   $id = $_GET["session"];
}

// get the payment token if it exists
$ps = new payswarm;
$ptok = $ps->load($id);

if($ptok === false)
{
   $ptok = array('id' => $id, 'state' => 0);
}

// If we are in state == 1 there should be an OAuth_token, if not go back to 0
if($ptok['state'] == 1 && !isset($_GET['oauth_token']))
{
   $ptok['state'] = 0;
   header("Location: $redir_url");
}

try
{
   $oauth = new OAuth(
      $consumer_key, $consumer_secret, OAUTH_SIG_METHOD_HMACSHA1);

   // enable debug output for OAuth and remove SSL checks
   $oauth->enableDebug();
   $oauth->disableSSLChecks();

   // check the state of the payment token
   if($ptok['state'] == 0)
   {
      $fh = fopen("/tmp/ps-oauth-state-0.txt", "w");
      fwrite($fh, "STATE: 0\n");
      fwrite($fh, "GPARAMS: " . print_r($_GET, true) . "\n");
      fwrite($fh, "PPARAMS: " . print_r($_POST, true) . "\n");
      fwrite($fh, "PTOK: " . print_r($ptok, true) . "\n");
      // State 0 - Generate request token and redirect user to payswarm site 
      // to authorize
      $callback_url = "https://" . $_SERVER['SERVER_NAME'] .
         $_SERVER['SCRIPT_NAME'] . "?session=" . $id;
      $request_token_info = $oauth->getRequestToken(
         "https://$payswarm_api_server/api/3.2/oauth1/tokens/request",
         $callback_url);

      $tok['id'] = $id;
      $tok['token'] = $request_token_info['oauth_token'];
      $tok['secret'] = $request_token_info['oauth_token_secret'];
      $tok['amount'] = "0.0";
      $tok['state'] = 1;
      if($ps->save($tok))
      {
         // Save the token and the secret, which will be used later
         header("Location: https://$payswarm_api_server" .
            '/home/authorize?oauth_token=' . $tok['token']);
      }
      else
      {
         // if something went wrong, clear the cookie and attempt the purchase
         // again
         setcookie("session", "", time() - 3600);
         $redir_url = 'https://' . $_SERVER['SERVER_NAME'] . 
            $_SERVER['SCRIPT_NAME'];
         header("Location: $redir_url");
      }
      fwrite($fh, "TOK: " . print_r($tok, true) . "\n");
      fclose($fh);
   }
   else if($ptok['state'] == 1)
   {
      $fh = fopen("/tmp/ps-oauth-state-1.txt", "w");
      fwrite($fh, "STATE: 1\n");
      fwrite($fh, "GPARAMS: " . print_r($_GET, true) . "\n");
      fwrite($fh, "PPARAMS: " . print_r($_POST, true) . "\n");
      fwrite($fh, "PTOK: " . print_r($ptok, true) . "\n");
      fclose($fh);
      // State 1 - Handle callback from payswarm and get and store an access token
      $oauth->setToken($_GET['oauth_token'], $ptok['secret']);
      $access_token_info = $oauth->getAccessToken(
         "https://$payswarm_api_server/api/3.2/oauth1/tokens");
      $tok['id'] = $id;
      $tok['state'] = 2;
      $tok['token'] = $access_token_info['oauth_token'];
      $tok['secret'] = $access_token_info['oauth_token_secret'];
      $tok['amount'] = '0.2'; // FIXME: Make this read the actual amount value
      $ps->save($tok); // Save the access token and secret

      $redir_url = "https://" . $_SERVER['SERVER_NAME'] . 
         $_SERVER['SCRIPT_NAME'];
      header("Location: $redir_url?action=purchase_contract");
   }
   else if($ptok['state'] == 2)
   {
      $fh = fopen("/tmp/ps-oauth-state-2.txt", "w");
      fwrite($fh, "STATE: 2\n");
      fwrite($fh, "GPARAMS: " . print_r($_GET, true) . "\n");
      fwrite($fh, "PPARAMS: " . print_r($_POST, true) . "\n");
      fwrite($fh, "PTOK: " . print_r($ptok, true) . "\n");
      fclose($fh);
      // State 2 - Authorized. We can just use the stored access token
      $oauth->setToken($ptok['token'], $ptok['secret']);
      $params = array(
         'asset' => 'http://example.org/news/myarticle.html',
         'license' => 'http://example.org/licenses/personal-use',
         'license_hash' => '866f3f9540e572e8cc4467f470a869242db201ba');
      $oauth->fetch("https://$payswarm_api_server/api/3.2/oauth1/contracts", 
         $params);
      $json = json_decode($oauth->getLastResponse());
      $ptok['state'] = 3;
      /*
      $debug = $oauth->getLastResponseInfo();
      print_r($debug);
      */
      $tok['id'] = $ptok['id'];
      $tok['state'] = $ptok['state'];
      $tok['token'] = $ptok['token'];
      $tok['secret'] = $ptok['secret'];
      $tok['amount'] = $ptok['amount'];
      // Save the access token and secret
      $ps->save($tok); 
      $redir_url = 'https://' . $_SERVER['SERVER_NAME'] . 
         $_SERVER['SCRIPT_NAME'];
      //print_r('GOT: <pre>' . print_r($json, true) . '</pre>');
      header("Location: $redir_url");
   }
   
   if($ptok['state'] == 3)
   {
      // if the payment token state for the current story is set to 3, then
      // the story has been purchased, so display the full story
      $fh = fopen("stories/full.html", "r");
      print(fread($fh, 32768));
      fclose($fh);
   }
}
catch(OAuthException $E)
{
   print_r('<pre>' . $E . '</pre>');
}

