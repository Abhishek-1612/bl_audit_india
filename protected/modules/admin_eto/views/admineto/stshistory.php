<?php

echo '<html>
<title> Send Email to Supplier
</title>
<head>
<style TYPE="text/css">
.admintext {font-family:ms sans serif,verdana; font-size:12px;font-weight:bold;line-height:17px;}
.form-style-9{
    max-width: 700px;
    background: #FAFAFA;
    padding: 30px;
    margin: 50px auto;
    box-shadow: 1px 1px 25px rgba(0, 0, 0, 0.35);
    border-radius: 10px;
    border: 6px solid #305A72;
}
</style>
<script>
function validate()
{
var message =document.getElementById("message").value;
if(message == "")
{
        alert("Please enter Message");
        document.getElementById("message").focus();
        return false;
}
}
</script>
</head>
<div class="form-style-3">';
 if($sts_id == 0)
      {
      echo '<div id="stsmessage3" class="admintext" style="color:red">STS ID does not exist.</div>';
     
      }
  else
  { 

echo '<form name="searchForm" method="post" onsubmit="return validate()" class="form-style-9">
<table width=80% align="center"><tr><td align="left"> <b>Enter Message:</b></td></tr>
<tr><td align="left"><textarea name="message" id="message" class="field-style" style="height:280px;width:680px"></textarea></td></tr>
<tr><td align="center"><input type="submit" name="submit" value="Save" style="height:30px;width:150px" /></td></tr>
<tr><td align="left"><input type="hidden" name="sts_id" value="'.$sts_id.'"  /></td></tr>
';
if(isset($_REQUEST['submit']))
{
    if(!$success && $sts_exist == 1)
      {  
	 echo '<tr><td align="center" id="stsmessage1"  style="color:red">Some Error Occured</td></tr>';
	    
      }
    elseif($sts_exist == 1)
      {
	echo '<tr><td align="center"  id="stsmessage2" style="color:green">Successfully Updated</td></tr>';
      }
     
}
echo '</table></form>';
}
echo '</html>';

?>