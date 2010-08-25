<?php

function get_webid_rdf($url)
{
   $rval = false;
   
   // force web ID url to https
   if(strpos($url, 'http://') === 0)
   {
      $url = 'https://' . substr($url, 4);
   }
   
   // TODO: don't assume its RDF data, it may be something else
   
   // grab rdf data from the url
   $timeout = 30;
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
   //curl_setopt($ch, CURLOPT_ENCODING, '');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_AUTOREFERER, true);
   // ignore https certificate check
   // FIXME: can't do this in a real system, it needs to be checked 
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
   $rdf = curl_exec($ch);
   $response = curl_getinfo($ch);
   curl_close($ch);
   
   if($response['http_code'] == 200)
   {
      $rval = $rdf;
   }
   
   return $rval;
}

?>
