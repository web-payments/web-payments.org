<?php
require_once('get_webid_rdf.inc');
require_once('check_public_key.inc');

$info = get_certificate_info();
print_r($info);

//get_webid_rdf($info['webID']);

?>
