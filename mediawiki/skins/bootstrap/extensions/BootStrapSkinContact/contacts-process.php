<?php
if( isset($_POST['name']) )
{
$to = 'info@mediawikibootstrapskin.co.uk';
$subject = 'Message from website';

if(!preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/',$_POST['email']))
die('oops something bad happened!');

$headers = 'From: ' . $_POST['email'] . "\r\n" . 'Reply-To: ' . $_POST['email'];

$message = 'Name: ' . $_POST['name'] . "\n" .
 'E-mail: ' . $_POST['email'] . "\n" .
 'Subject: ' . $_POST['subject'] . "\n" .
 'Message: ' . $_POST['message'];

mail($to, $subject, $message, $headers);

}
header("Location: ../../index.php?title=Thankyou_Message");
?>