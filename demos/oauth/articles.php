<?php
include './inc/payswarmdb.inc'; 

$consumer_key = 'devclient';
$consumer_secret = 'password';
$payswarm_api_server = "localhost:19100";

// get the session ID if it exists
$id = 0;
if(array_key_exists("session", $_COOKIE))
{
   $id = $_COOKIE["session"];
}
else if(array_key_exists("session", $_GET))
{
   $id = $_GET["session"];
}

// get the payment token if it exists
$ps = new payswarm;
$ptok = $ps->load($id);

if($ptok !== false and $ptok['state'] == 3)
{
   // if the payment token state for the current story is set to 3, then
   // the story has been purchased, so display the full story
   $fh = fopen("articles/full.html", "r");
   print(fread($fh, 32768));
   fclose($fh);
}
else
{
   print_r("<pre>Couldn't find a payment token!</pre>");
}

