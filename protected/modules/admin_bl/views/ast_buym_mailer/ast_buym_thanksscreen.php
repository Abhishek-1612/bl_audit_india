<?php

$message = '';

if($glusrid == '' || $offerID == '' || $glusr_email == '' || empty($result)){
$message .= '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>Error in occurred .. Please check the GluserId or OfferID filled</body>';
}

else{
$message .= '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>Your mail has been sent to GlusrID : '.$glusrid.' for OfferID : '.$offerID.' </body>';
}
echo $message;