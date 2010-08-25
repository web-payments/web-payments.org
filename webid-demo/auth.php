<?php
require_once('get_webid_rdf.inc');
require_once('check_public_key.inc');

$rval = array();
$rval['success'] = false;

// the user may have selected a browser-generated WebID...
// so grab that information here
$info = get_certificate_info();
if(!isset($rval['error']))
{
   // get the web ID rdf
   $rdf = get_webid_rdf($info['webID']);
   if($rdf !== false)
   {
      // authenticate by checking public key
      if(check_public_key($rdf, $info['webID'], $info['publicKey']))
      {
         // set cert and web ID
         $rval['cert'] = $info['cert'];
         $rval['webID'] = $info['webID'];
         
         // encode rdf for transport
         $rval['rdf'] = base64_encode($rdf);
         
         // set cookies (current js code doesn't grab the
         // cookies in the javascript and pass them on but could to avoid
         // having to deal with the return data as json)
         setcookie(
            'webid',
            urlencode(json_encode($rval)),
            0, '/', '.payswarm.com', true);
         setcookie(
            'rdf', $rval['rdf'],
            0, '/', '.payswarm.com', true);
      }
   }
}
//print_r($rval);

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
