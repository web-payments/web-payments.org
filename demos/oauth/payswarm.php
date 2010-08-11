<?php
include './inc/payswarmdb.inc'; 

$consumer_key = 'consumerKey';
$consumer_secret = 'consumerSecret';
$id = 555; // fix the user ID or session ID stuff

try
{
   $ps = new payswarm;
   $ptok = $ps->load($id); // the payment token that specifies OAuth variables

   if($ptok === false)
   {
      $ptok = array('id' => $id, 'state' => 0);
   }

   // If we are in state == 1 there should be an OAuth_token, if not go back to 0
   if($ptok['state'] == 1 && !isset($_GET['oauth_token']))
   {
      $ptok['state'] = 0;
   }
}
catch(PDOException $E)
{
   print_r('<pre>' . $E . '</pre>');
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
      print_r("<pre>STATE: 0</pre>");
      // State 0 - Generate request token and redirect user to payswarm site 
      // to authorize
      $request_token_info = $oauth->getRequestToken(
         'https://localhost:19100/api/3.2/oauth1/tokens/request');
      $tok['id'] = $id;
      $tok['token'] = $request_token_info['oauth_token'];
      $tok['secret'] = $request_token_info['oauth_token_secret'];
      $tok['amount'] = "0.0";
      $tok['state'] = 1;

      // Save the token and the secret, which will be used later
      $ps->save($tok);
      //header('Location: https://localhost:19100' .
      //   '/api/3.2/oauth1/tokens/authorized?oauth_token='.$tok['token']);
      exit;
   }
   else if($ptok['state'] == 1)
   {
      print_r("<pre>STATE: 1</pre>");
      // State 1 - Handle callback from payswarm and get and store an access token
      $oauth->setToken($_GET['oauth_token'], $ptok['secret']);
      $access_token_info = $oauth->getAccessToken(
         'https://localhost:19100/api/3.2/oauth1/tokens');
      $tok['state'] = 2;
      $tok['token'] = $access_token_info['oauth_token'];
      $tok['secret'] = $access_token_info['oauth_token_secret'];
      $ps->save($tok); // Save the access token and secret
      $ptok['token'] = $tok['token'];
      $ptok['secret'] = $tok['secret'];
      unset($tok);
      // Fall through to authorized state
   }
   else if($ptok['state'] == 2)
   {
     // State 2 - Authorized. We can just use the stored access token
     $oauth->setToken($ptok['token'], $ptok['secret']);
     $params = array(
        'asset' => 'http://example.org/news/myarticle.html',
        'license' => 'http://example.org/licenses/personal-use');
     $oauth->fetch('https://localhost:19100/api/3.2/oauth1/contracts', $params);
     $json = json_decode($oauth->getLastResponse());
     /*
     $debug = $oauth->getLastResponseInfo();
     print_r($debug);
     */
     print_r('GOT: <pre>' . $json . '</pre>');
   }
}
catch(OAuthException $E)
{
   print_r('<pre>' . $E . '</pre>');
}

