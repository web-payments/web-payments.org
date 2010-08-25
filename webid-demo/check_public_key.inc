<?php

// load redland lib
$dlls = array(
   'redland.so', 'php_redland.dll', 'redland.dylib', 'redland.bundle');
foreach($dlls as $dll)
{
   if(file_exists($dll))
   {
      dl($dll);
   }
}

// compare 2 public keys to ensure they are the same
function compare_public_keys($key1, $key2)
{
   // assume exponent is small enough to be a regular int
   $rval =
      (is_array($key1) and is_array($key2) and
      $key1['exponent'] == $key2['exponent']);
   if($rval)
   {
      // get hex
      $hex1 = strtoupper($key1['modulus']);
      $hexlen1 = strlen($hex1);
      $hex2 = strtoupper($key2['modulus']);
      $hexlen2 = strlen($hex2);
      
      $rval = ($hex1len !== 0 and $hex2len !== 0);
      if($rval)
      {
         // normalize hex
         if($hexlen1 % 2 !== 0)
         {
            $hex1 = '0' . $hex1;
            ++$hex1len;
         }
         if($hexlen2 % 2 !== 0)
         {
            $hex2 = '0' . $hex2;
            ++$hex2len;
         }
         
         // compare hex
         $rval = ($hex1len === $hex2len);
         {
            $rval = true;
            for($i = 0; $rval and $i < $hex1len; ++$i)
            {
               $rval = ($hex1[$i] === $hex2[$i]);
            }
         }
      }
   }
   
   return $rval;
}

// read the info from the certificate
function get_certificate_info()
{
   $rval = array();
   
   // check for client-side certificate
   if(!isset($_SERVER[SSL_CLIENT_CERT]) || $_SERVER[SSL_CLIENT_CERT] === '')
   {
      $rval['error'] = 'No client-side certificate.';
   }
   else
   {
      // get client-side certificate
      $cert = openssl_x509_parse($_SERVER[SSL_CLIENT_CERT]);
      $key = openssl_get_publickey($_SERVER[SSL_CLIENT_CERT]);
      
      // check for web ID url
      if(!isset($cert['extensions']['subjectAltName']))
      {
         $rval['error'] = 'No WebID subjectAltName in certificate.';
      }
      else if($key === false)
      {
         $rval['error'] = 'Could not read public key in certificate.';
      }
      else
      {
         // strip 'URI:' from web ID
         $webID = $cert['extensions']['subjectAltName'];
         $webID = substr($webID, 4);
         $rval['webID'] = $webID;
         $rval['cert'] = $cert;
         $details = openssl_pkey_get_details($key);
         $rval['publicKey']['modulus'] = bin2hex($details['rsa']['n']);
         $rval['publicKey']['exponent'] = hexdec(bin2hex($details['rsa']['e']));
         openssl_free_key($key);
      }
   }
   
   return $rval;
}

// check the public key against rdf from a web ID url
function check_public_key($rdf, $webID, $publicKey)
{
   $rval = false;
   
   // sparql query to get public key modulus and exponent
   $publicKeyQuery = <<<"EOD"
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX cert: <http://www.w3.org/ns/auth/cert#>
PREFIX rsa: <http://www.w3.org/ns/auth/rsa#>
SELECT ?m ?e ?mod ?exp WHERE {
?key cert:identity <$webID>; rsa:modulus ?m; rsa:public_exponent ?e.
OPTIONAL { ?m cert:hex ?mod. }
OPTIONAL { ?e cert:decimal ?exp. }
}
EOD;
   
   // create rdf model
   $world = librdf_php_get_world();
   $storage = librdf_new_storage($world, 'memory', NULL, NULL);
   $model = librdf_new_model($world, $storage, NULL);
   
   // parse rdf data into model
   $uri = librdf_new_uri($world, $webID);
   $parser = librdf_new_parser($world, 'rdfxml', 'application/rdf+xml', NULL);
   $rv = librdf_parser_parse_string_into_model($parser, $rdf, $uri, $model);
   librdf_free_parser($parser);
   librdf_free_uri($uri);
   if($rv !== 0)
   {
      // parse error
      //echo 'parse error: "' . $rv . '"';
   }
   else
   {
      // do sparql query
      $query = librdf_new_query($world, 'sparql', NULL, $publicKeyQuery, NULL);
      $rs = librdf_model_query_execute($model, $query);
      
      // check for a public key that matches
      while(!$rval and $rs and !librdf_query_results_finished($rs))
      {
         // FIXME: better error checking needed
         $mn = librdf_query_results_get_binding_value_by_name($rs, 'm');
         $en = librdf_query_results_get_binding_value_by_name($rs, 'e');
         
         if(librdf_node_get_type($mn) != LIBRDF_NODE_TYPE_LITERAL)
         {
            librdf_free_node($mn);
            $mn = librdf_query_results_get_binding_value_by_name($rs, 'mod');
         }
         if(librdf_node_get_type($en) != LIBRDF_NODE_TYPE_LITERAL)
         {
            librdf_free_node($en);
            $en = librdf_query_results_get_binding_value_by_name($rs, 'exp');
         }
         
         if(librdf_node_get_type($mn) != LIBRDF_NODE_TYPE_LITERAL and
            librdf_node_get_type($en) != LIBRDF_NODE_TYPE_LITERAL)
         {
            $key = array();
            $key['modulus'] = librdf_node_get_literal_value($mn);
            $key['exponent'] = librdf_node_get_literal_value($en);
            
            // check public key
            $rval = compare_public_keys($key, $publicKey);
         }
         
         // clean up
         librdf_free_node($mn);
         librdf_free_node($en);
         
         // match not found, go to next result
         if(!$rval)
         {
            librdf_query_results_next($rs);
         }
      }
   }
   
   // clean up
   librdf_free_model($model);
   librdf_free_storage($storage);
   
   return $rval;
}

?>
