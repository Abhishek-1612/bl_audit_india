<?php
$this->pageTitle=Yii::app()->name . ' - Email Validation';
echo '<html>
      <head>
      <!--google analytics async code start-->
  <script type="text/javascript">
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
</script>
<!--google analytics async code end-->
      </head>
      <body>
      <table>
<font style="color:blue;font-size:14px;font-family:arial;">Email Validation Form</font><BR><BR>
	<form name="emailForm" action="index.php?r=admin_bl/Email_validation/Index&mid=3421" method="post">
	Enter Email Id- <input type="text" name="email" value="'.$email.'"><BR>
	<input type="hidden" value="1" name="frm"><BR>
	<input type="submit" value="submit" name="submit">
	</form>
</div>
<div style="height:"100px;"></div>
</td>
</tr>
</table>';
if($email)
{
echo '
  <p><font style="color:blue;font-size:14px;font-family:arial">Email Status of "'.$email.'" </font></p>    
';
}

echo '</body></html>';
?>