<?php

//$mod_id = ($_REQUEST['modid']=='BIGBUYER')?'BIGBUYER':'ASTBUYM';
//print_r($mod_id);

$message = '';

$message .= '<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-28761981-2\']);
  _gaq.push([\'_setDomainName\', \'.intermesh.net\']);
  _gaq.push([\'_setSiteSpeedSampleRate\', 10]);
  _gaq.push([\'_trackPageview\',\''.$_SERVER['REQUEST_URI'].'\']);
  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

function checkvalid(){
 if(document.getElementById("GLUSERID").value == "" && (document.getElementById("glusrcheck").checked === false)){
alert("Either enter the GluserID or check the checkbox for all users");
return false;
}else if(document.getElementById("OFFERID").value == ""){
alert("Please enter the OfferID");
return false;
}
else{
document.getElementById("astbuym" ).submit();
}

}
</script>
<body>
<form id="astbuym" method="post" action="index.php?r=admin_bl/ast_buym_mailer/sendmail" >';
$message .='SELECT MODULE:<br>';
$message .='<select name="modid">';
if(!empty($mod_id))
{

$message .='<option selected>'.$mod_id.'</option>';

}else{

 $message .='<option selected>ASTBUYM</option>';


}
foreach ($modid['GL_MODULE_ID'] as $key => $value) {

//echo $key; echo "<br>"; echo $value;

   $message .= '<option value="'.$value.'">'.$value.'</option>';
  
}


$message .= '</select><br>';







 $message .='
  GLUSERID:<br>
  <input type="text" name="GLUSERID" id= "GLUSERID" value=""><br>
  OFFERID:<br>';
if(!empty($offerID)){
$message .= '<input type="text" name="OFFERID" id= "OFFERID" value="'.$offerID.'"><br><br>';
}else{
$message .= '<input type="text" name="OFFERID" id= "OFFERID" value=""><br><br>';

}


    $message .= '<input type="checkbox" id = "glusrcheck" name="glusrcheck" value="gluser">All User<br><br>
  <button type="button" value="Submit" onclick="checkvalid()" >Submit</button>
<br><br>

</form></body>';
/*
if($success_flag == 1){

$message .= 'Your mail has been sent to GlusrID : '.$glusrid.' for OfferID : '.$offerID;

}elseif($success_flag == 0){

$message .= 'Record not found from this GluserId or OfferID ';

}*/
if($success_flag != 2){
$message .= 'Mail Sent to following GLUSERS:-'.$mailsent;
}
echo $message;


