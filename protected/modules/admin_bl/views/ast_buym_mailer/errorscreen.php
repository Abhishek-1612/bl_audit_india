<?php

$msg=isset($msg)?$msg:'Record does not found from this GluserId or OfferID';
$message = '';
 
$message .= '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<body>'. $msg . '</body>';

echo $message;