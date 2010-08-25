<?php
// check subject alternative name for web ID uri
// get cert from uri confirm is the same as client-side cert

$rval = array();
$rval['success'] = false;

// check for client-side certificate
if(!isset($_SERVER[SSL_CLIENT_CERT]) ||
   $_SERVER[SSL_CLIENT_CERT] === '')
{
   $rval['error'] = 'No client-side certificate.';
}
else
{
   // get client-side certificate
   $cert = openssl_x509_parse($_SERVER[SSL_CLIENT_CERT]);

   // check for web ID url
   if(!isset($cert['extensions']['subjectAltName']))
   {
      $rval['error'] = 'No WebID subjectAltName in certificate.';
   }
   else
   {
      // FIXME: go to WebID url and check public key
      $rval['cert'] = $cert;//$_SERVER[SSL_CLIENT_CERT];
      $rval['success'] = true;
      $webID = $cert['extensions']['subjectAltName'];
      $webID = substr($webID, 4);
      $rval['webID'] = $webID;
      $rval['rdf'] = '';

      // grab rdf data from the WebID uri
      $timeout = 30;
      $ch = curl_init();
      //curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
      // FIXME: force https
      curl_setopt($ch, CURLOPT_URL, $webID);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
      curl_setopt($ch, CURLOPT_ENCODING, '');
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_AUTOREFERER, true);
      // ignore https certificate check
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
      $content = curl_exec($ch);
      $rval['rdf'] = base64_encode($content);
      //print_r($content);
      /*if($content !== false)
      {
         $rval['rdf'] = base64_encode($content);
      }*/
      $response = curl_getinfo($ch);
      curl_close($ch);

      if($response['http_code'] >= 400)
      {
         // bad WebID url
      }

      /* cookie is also set by javascript in case
      javascript TLS made the connection */
      // set cookie
      setcookie(
         'webid',
         urlencode(json_encode($rval)),
         0, '/', '.payswarm.com', true);
      setcookie(
         'rdf', $rval['rdf'],
         0, '/', '.payswarm.com', true);
   }
}

// send headers
header('Content-Type: application/json');
//header('Content-Type: x-www-form-urlencoded');
//header('Content-Type: text/plain');

/*
// send output
$output = '';
foreach($rval as $key => $value)
{
   if(strlen($output) > 0)
   {
      $output .= '&';
   }
   $output .= urlencode($key) . '=' . urlencode($value);
}
echo $output;*/

echo json_encode($rval);
?>
