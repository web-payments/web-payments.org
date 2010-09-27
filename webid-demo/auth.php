<?php
require_once('get_webid_rdf.inc');
require_once('check_public_key.inc');

$rval = array();
$rval['success'] = false;

// the user may have selected a browser-generated WebID...
// so grab that information here
$info = get_certificate_info();
if(isset($info['error']))
{
   $rval['error'] = $info['error'];
}
else
{
   // get the web ID rdf
   $rdf = get_webid_rdf($info['webID']);
   if($rdf === false)
   {
      $rval['error'] = 'Could not retrieve RDF from WebID url.';
   }
   // authenticate by checking public key
   else if(!check_public_key($rdf, $info['webID'], $info['publicKey']))
   {
      $rval['error'] = 'Public keys did not match.';
   }
   else
   {
      // set cert and web ID
      $rval['success'] = true;
      $rval['cert'] = $info['cert'];
      $rval['webID'] = $info['webID'];
      
      // encode rdf for transport
      $rval['rdf'] = base64_encode($rdf);
   }
}
//print_r($rval);

// send headers and output
header('Content-Type: application/json');
echo json_encode($rval);
?>
