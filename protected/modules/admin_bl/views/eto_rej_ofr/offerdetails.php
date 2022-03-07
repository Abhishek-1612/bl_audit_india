<?php
echo '<html>
      <head><title>Offer Details</title>
      <style>body{font-family:arial;}</style>
      </head>
      <body>
      <div>
      <table bgcolor="#EFFBFB" border="1" bordercolor="#29A2A3" style="border-collapse:collapse" width="100%">';
     // ($id,$name)
        $id = $rec['ETO_OFR_TITLE'];
        $name = $rec['ETO_OFR_DESC'];
       echo '<tr><td style="color:red;font-size:12px;padding:4px;" valign="top" width="120"><b>Title: </b></td><td style="font-size:12px" colspan=7>'.$id.'</td></tr>
                  <tr><td style="color:red;font-size:12px; padding:4px;" valign="top" width="120"><b>Description: </b></td><td style="font-size:12px" colspan=7>'.$name.'</td></tr>
                  <tr><td style="color:red;font-size:12px;padding:4px;" valign="top" width="120"><b>MCats Mapping: </b></td>';
                  
      $date = $city = $state = $counrty = $quantity = $call_verified = $email_verified = $lock_by = '';
  
           if(isset($rec['GLCAT_MCAT_IS_GENERIC']))
               {
                $rec['GLCAT_MCAT_IS_GENERIC'] = $rec['GLCAT_MCAT_IS_GENERIC'];
               }
               else
               {
               $rec['GLCAT_MCAT_IS_GENERIC'] = 0;
               }
	       
	       if($rec['GLCAT_MCAT_IS_GENERIC'] > 0)
	       {
                echo '<td style="font-size:12px;padding:4px;" width="200">'.@$rec['MCAT_NAME'].'<span style="color:red;font-weight:bold;"> * </span>';
               }
	       else
	       {
	        echo '<td style="font-size:12px;padding:4px;" width="200">'.@$rec['MCAT_NAME'];
	       }
	       
	       if(@$rec['PRIME_FLG'] == 1)
                {
                echo ' <label style="color:red;font-size:12px">PRIME</label>';
                }
                echo '</td>';
           
                        $date=@$rec['POST_DATE'];
			$city=@$rec['GLUSR_USR_CITY'];
			$state=@$rec['GLUSR_USR_STATE'];
			$counrty=@$rec['GLUSR_USR_COUNTRYNAME'];
			$quantity=@$rec['ETO_OFR_QTY'];
			if(isset($rec['ETO_OFR_CALL_VERIFIED']))
			{
				$call_verified=$rec['ETO_OFR_CALL_VERIFIED'];
			}
			
	                if(isset($data['GL_EMP_NAME']) && isset($rec['ETO_OFR_POSTEDBYEMPLOYEE']))
	                {
				$lock_by= $rec['GL_EMP_NAME'].' '.'('.$rec['ETO_OFR_POSTEDBYEMPLOYEE'].')';
			}
			
			if($call_verified==2)
			{	
				$call_verified='Call Verified & Updated';
			}
			elseif($call_verified==1)
			{
				$call_verified='Call Verified';
			}
			elseif($call_verified==3)
			{
				$call_verified='Call Updated';
			}
			if(isset($rec['ETO_OFR_EMAIL_VERIFIED']))
			{
				$email_verified=$rec['ETO_OFR_EMAIL_VERIFIED'];
			}
			
			if($email_verified==2)
			{	$email_verified='Email Verified & Updated';
			}
			elseif($email_verified==1)
			{
				$email_verified='Email Verified';
			}
			elseif($email_verified==3)
			{
				$email_verified='Email Updated';
			}
                        
                        
                        
        echo '<tr><td style="color:red;font-size:12px; padding:4px;" valign="top" width="120"><b>Quantity: </b></td><td style="font-size:12px">'.$quantity.'</td><td style="color:red;font-size:12px;padding:4px;" valign="top" width="30"><b>Status: </b></td><td style="font-size:12px;padding:4px;">';
	if (isset($call_verified))
	{ echo '<strong>'.$call_verified .'</strong>';
	}
	if (isset($email_verified))
	{ 
	  if (isset($call_verified))
	  {echo '<strong>'.$email_verified.' </strong>';}
	  if (!$call_verified)
	  {echo '<strong>'.$email_verified .'</strong>';}
	  }
          
          
          
	echo '</td><td style="color:red;font-size:12px; padding:4px;" valign="top" width="120"><b>Approved By: </b></td><td colspan="4" style="font-size:12px">'.$lock_by.'</td></tr><tr><td style="color:red;font-size:12px;padding:4px;" valign="top" width="120"><b>Post Date: </b></td><td style="font-size:12px;padding:4px;">'.$date.'</td>
	<td style="color:red;font-size:12px;padding:4px;" valign="top" width="30"><b>City: </b></td><td style="font-size:12px;padding:4px;">'.$city.'</td>
	<td style="color:red;font-size:12px;padding:4px;" valign="top" width="40"><b>State: </b></td><td style="font-size:12px;padding:4px;">'.$state.'</td>
	<td style="color:red;font-size:12px;padding:4px;" valign="top" width="50"><b>Counrty: </b></td><td style="font-size:12px;padding:4px;">'.$counrty.'</td></tr></tr></table></div>
	</body></html>';

?>