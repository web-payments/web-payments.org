<?php
require_once('get_webid_rdf.inc');
require_once('check_public_key.inc');

$info = get_certificate_info();
print_r($info);

$rv = compare_public_keys($info['publicKey'], $info['publicKey']);
echo 'public key result: "' . $rv . '"';

//get_webid_rdf($info['webID']);
$rdf = get_webid_rdf('http://foaf.me/dbtest#me');
echo '</br>start rdf</br>';
print_r($rdf);
echo '</br>end rdf</br>';

check_public_key($rdf, 'http://foaf.me/dbtest#me', NULL);

?>
