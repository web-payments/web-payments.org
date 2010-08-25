<?php

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
librdf_parser_parse_string_into_model($parser, $rdf, NULL, $model);
librdf_free_parser($parser);

// do sparql query
$query = librdf_new_query($world, 'sparql', NULL, $publicKeyQuery, NULL);
$results = librdf_model_query_execute($model, $query);

// check for a public key that matches
$match = false;
while(!$match and $results and !librdf_query_results_finished($results))
{
   // FIXME: better error checking needed
   $m_node = librdf_query_results_get_binding_value_by_name($results, 'm');
   $e_node = librdf_query_results_get_binding_value_by_name($results, 'e');
   
   if(librdf_node_get_type($m_node) != LIBRDF_NODE_TYPE_LITERAL)
   {
      librdf_free_node($m_node);
      $m_node =
         librdf_query_results_get_binding_value_by_name($results, 'mod');
   }
   if(librdf_node_get_type($e_node) != LIBRDF_NODE_TYPE_LITERAL)
   {
      librdf_free_node($e_node);
      $e_node =
         librdf_query_results_get_binding_value_by_name($results, 'exp');
   }
   
   if(librdf_node_get_type($m_node) != LIBRDF_NODE_TYPE_LITERAL and
      librdf_node_get_type($e_node) != LIBRDF_NODE_TYPE_LITERAL)
   {
      $mod = librdf_node_get_literal_value($m_node);
      $exp = librdf_node_get_literal_value($e_node);
      
      // FIXME: check public key
      // $match =
      print_r($mod);
      print_r($exp);
   }
   
   // clean up
   librdf_free_node($m_node);
   librdf_free_node($e_node);
   
   // match not found, go to next result
   if(!$match)
   {
      librdf_query_results_next($results);
   }
}

// clean up
librdf_free_model($model);
librdf_free_storage($storage);

?>

