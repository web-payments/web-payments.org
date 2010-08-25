<?php
require_once('get_webid_rdf.inc');
require_once('check_public_key.inc');

$info = get_certificate_info();
print_r($info);

$rv = compare_public_keys($info['publicKey'], $info['publicKey']);
echo 'result: "' . $rv . '"';

//get_webid_rdf($info['webID']);

?>
