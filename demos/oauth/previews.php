<?php
include 'config.inc'; 
include 'payswarmdb.inc'; 

// get the session ID if it exists, otherwise create a new session ID
$id = 0;
$ptok = null;
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
      'id' => $id, 'state' => 0, 
      'token' => "", 'secret' => "", 'amount' => "");
}
setcookie("session", $id, time() + 3600, "/$DEMO_PATH/", $WEBSITE, true);

// Create the payment token if it doesn't already exist
$ps = new payswarm;
$tok = $ps->load($id);
if($tok === false)
{
   if($ps->save($ptok) === false)
   {
      setcookie("session", "", time() - 3600, "/$DEMO_PATH/", $WEBSITE, true);
      error("Failed to initialize Payment Token: " . print_r($ptok, true) .
         "Try again...");
   }
}

// Display the article preview
$fh = fopen("articles/preview.html", "r");
print(fread($fh, 32768));
fclose($fh);

