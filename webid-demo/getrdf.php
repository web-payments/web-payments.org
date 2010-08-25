<?php

function compare_public_keys($key1, $key2)
{
   // FIXME: implement me
}

function check_public_key($rdf, $publicKey)
{
   $rval = false;
   
   // sparql query to get public key modulus and exponent
   $publicKeyQuery = <<<"EOD"
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>"
PREFIX cert: <http://www.w3.org/ns/auth/cert#>"
PREFIX rsa: <http://www.w3.org/ns/auth/rsa#>"
SELECT ?m ?e ?mod ?exp WHERE {
?key cert:identity <%s>; rsa:modulus ?m; rsa:public_exponent ?e.
OPTIONAL { ?m cert:hex ?mod. }
OPTIONAL { ?e cert:decimal ?exp. }
}
EOD;
   
   // create rdf model
   $world = librdf_php_get_world();
   $storage = librdf_new_storage(
      $world, 'hashes', NULL, "new='yes',hash-type='memory'");
   $model = librdf_new_model($world, $storage, NULL);
   
   // parse rdf data into model
   $parser = librdf_new_parser($world, 'rdfxml', 'application/rdf+xml', null);
   $rv = librdf_parser_parse_string_into_model($parser, $rdf, NULL, $model);
   librdf_free_parser($parser);
   if($rv !== 0)
   {
      // parse error
      echo 'parse error: "' . $rv . '"';
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
            
            // FIXME: check public key
            // $rval = compare_public_keys($key, $publicKey);
            print_r($key);
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

// FIXME: move elsewhere
// grab rdf data from the WebID url
$timeout = 30;
$ch = curl_init();
// FIXME: force https
curl_setopt($ch, CURLOPT_URL, 'http://foaf.me/dbtest');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_ENCODING, '');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
// ignore https certificate check
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
$rdf = curl_exec($ch);
$response = curl_getinfo($ch);
curl_close($ch);

if($response['http_code'] >= 400)
{
   // bad WebID url
   echo 'bad webid url';
}

print_r($rdf);

// FIXME: pass in the public key from the cert
check_public_key($rdf, NULL);

?>
