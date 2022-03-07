<?php
class Email_validation extends CFormModel
{
public function emailStatus($email1)
{

$message1=$message2=$message3=$message4=$message5='';
        if (!filter_var($email1, FILTER_VALIDATE_EMAIL)) 
	   {
		$message1 ='invalid';
           }
        else
          { 
                $message1='valid';
          }
 
 if($message1=='valid')
 {
	
	$array=explode('@',$email1);
	$host=$array[1];
	$name=$array[0];
	
        $ip = gethostbyname($host);	
	
	
	  if (!filter_var($ip, FILTER_VALIDATE_IP) === false)
	     {
	      
               if(checkdnsrr($host,'MX'))
                { 
                  
                 require_once('smtp_validateEmail.class.php');
                 $email =$email1;

                 $sender = 'useradmin@indiamart.com';

                 $SMTP_Validator = new SMTP_validateEmail();
                 $SMTP_Validator->debug = true;
                 $results = $SMTP_Validator->validate(array($email), $sender);
          //echo $email.' is '.($results[$email] ? 'valid' : 'invalid')."\n";
                if ($results[$email]) 
                   { 
                     $message2='valid';
                     
                   } 
             else 
                  {
                  $message2='invalid';
                  }
                }
              else
              { 
               $message3='invalid';
              }
          
          }
         else
         {
          $message4='invalid';
         }
            
  
      }
      
      return array($message1,$message2,$message3,$message4);
      }
      }


      
    