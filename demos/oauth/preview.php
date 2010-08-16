<?php
include './inc/payswarmdb.inc'; 

// get the session ID if it exists
$id = 0;
if(array_key_exists("session", $_COOKIE))
{
   $id = $_COOKIE["session"];
}
else
{
   $timeVal = time();
   $randomVal = rand(0, 100000);
   $id = sha1("$timeVal$randomVal");
   $ptok = array(
      'id' => $id, 'token' => "", 'secret' => "", 'amount' => "", 'state' => 0);
}

// Create the payment token if it doesn't already exist
$ps = new payswarm;
$ptok = $ps->load($id);
if($ptok === false)
{
   $ps->save($ptok);
}
setcookie("session", $id, time() + 3600, "/payswarm.com/demos/oauth/");

// if the story action is not set and the token doesn't exist, preview
// the article
$fh = fopen("articles/preview.html", "r");
print(fread($fh, 32768));
fclose($fh);

