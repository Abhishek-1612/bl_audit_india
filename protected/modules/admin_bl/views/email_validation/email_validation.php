<?php
echo '<html>
      <body>';
      
      
      if($message1=='invalid')
      {
     echo ' <p><font style="color:red;font-size:16px;font-family:bold">Syntax error in email address.</font></p>';   
     echo ' <p><font style="color:red;font-size:14px;font-family:bold"><b>Email is InValid</b></font></p>'; 
      }
if ($message3=='invalid' || $message4=='invalid')
{ 
      echo ' <p><font style="color:red;font-size:16px;font-family:bold">No MX or A DNS records for this domain.</font></p>';   
      echo ' <p><font style="color:red;font-size:14px;font-family:bold"><b>Email is InValid</b></font></p>';
}

if($message2=='valid')
{
   echo ' <p><font style="color:green;font-size:16px;font-family:bold">Email address seems valid.</font></p>';
   echo ' <p><font style="color:green;font-size:14px;font-family:bold"><b>Email is Valid</b></font></p>';
}
if($message2=='invalid')
{
      echo ' <p><font style="color:red;font-size:16px;font-family:bold">One Advertised SMTP server permanently refused mail.</font></p>';   
      echo ' <p><font style="color:red;font-size:14px;font-family:bold"><b>Email is InValid</b></font></p>';
}

 
 echo '    
</html>
</body>';
?>