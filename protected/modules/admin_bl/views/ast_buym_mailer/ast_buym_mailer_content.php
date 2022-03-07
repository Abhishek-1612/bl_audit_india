<?php
//print_r($result);

$offer_id= isset($result['ETO_OFR_DISPLAY_ID'])?$result['ETO_OFR_DISPLAY_ID']:'';
$eto_ofr_title = isset($result['ETO_OFR_TITLE'])?$result['ETO_OFR_TITLE']:'';
$usr_identifier_flag = isset($result['USER_IDENTIFIER_FLAG'])?$result['USER_IDENTIFIER_FLAG']:'';
$verified = isset($result['ETO_OFR_VERIFIED'])?$result['ETO_OFR_VERIFIED']:'';
$quantity = isset($result['ETO_OFR_QTY'])?$result['ETO_OFR_QTY']:'';
$hr = isset($result['OFR_DATE_HR'])?$result['OFR_DATE_HR']:'';

$city = isset($result['GLUSR_CITY'])?$result['GLUSR_CITY']:'';
$state = isset($result['GLUSR_STATE'])?$result['GLUSR_STATE']:'';
$offer_date=isset($result['OFFER_DATE'])?$result['OFFER_DATE']:'';
$offer_date_hr = isset($result['OFR_DATE_HR'])?$result['OFR_DATE_HR']:'';
$Rej_mcat = isset($result['FK_GLCAT_MCAT_ID'])?$result['FK_GLCAT_MCAT_ID']:'';
$mcat_name = isset($result['ETO_OFR_GLCAT_MCAT_NAME'])?$result['ETO_OFR_GLCAT_MCAT_NAME']:'';
$flag = isset($result['GL_COUNTRY_FLAG_SMALL'])?$result['GL_COUNTRY_FLAG_SMALL']:'';
$country = isset($result['GLUSR_COUNTRY'])?$result['GLUSR_COUNTRY']:'';
$unit = isset($result['ETO_OFR_QTY_UNIT'])?$result['ETO_OFR_QTY_UNIT']:'';
$count_iso = isset($result['FK_GL_COUNTRY_ISO'])?$result['FK_GL_COUNTRY_ISO']:'';
$flag_small = isset($result['GL_COUNTRY_FLAG_SMALL'])?$result['GL_COUNTRY_FLAG_SMALL']:'';
$count_iso = strtolower($count_iso);
$tinyflag="seller.imimg.com/gifs/flags-img/".$count_iso."_flag_s.png";
$contact_no='8860632815';
$mail_to='fulfilment@indiamart.com';
$mail_to1='fulfilment@indiamart.com';


  $desc = preg_replace("/(\n)+$/","\n",$desc);
                    

                    $desc = preg_replace("/(\s+\n|\n){3,}/","\n\n",$desc);

                    $desc = preg_replace("/\n/","<BR>",$desc);

                    $desc = preg_replace("/\t/","&nbsp;&nbsp;&nbsp;&nbsp;/",$desc);

$message = '';





$message = <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>
<body>

<table width="68%" border="0" cellspacing="0" cellpadding="0" style="max-width:600px; text-align:left; background:#CCCCCC; padding:10px;" align="center">
<tr>
<td valign="top" style="width:100%;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fff";>
  <tr>
  	<td valign="top">
    	<table border="0" cellpadding="0" cellspacing="0" width="100%" style="background:#FFFFFF;">
<tbody>
<tr>
<td height="60" style=" width:100%; border-bottom:3px solid #2e3192; padding:5px 10px 5px 10px;" bgcolor="#fff">
<img style="vertical-align:middle; display:block; background:#FFFFFF;" 
src="https://www.indiamart.com/newsletters/mailer/images/indiamart-logo-mt.jpg" alt="IndiaMART" height="40" border="0" width="200"></td>
</tr>
</tbody>
</table>
    </td>
  </tr>
  
   <tr>
    <td width="100%" style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:10px 10px 10px 10px; background:#c8f2f4; color:#000 ">Dear $glusrname</td>
  </tr>
  <tr>
    <td width="100%" bgcolor="#fff" style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px;"><img src="https://www.indiamart.com/newsletters/mailer/images/buyer-requesting-280616.jpg" width="100%" style="max-width:600px; padding-bottom:5px;" ></td>
    <tr>
    <td width="100%" bgcolor="#fff" style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#FFFFFF;">
  <tbody>
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:18px; line-height:18px; font-weight:bold; color:#9e0b0f; padding:10px; border-bottom:1px solid #C9C9C9;">$eto_ofr_title</td>
    </tr>
    <tr>
      <td style="border-bottom:1px solid #C9C9C9;"><table width="600px" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td style="padding:10px 0px 10px 10px;" width="20px"><img src="https://www.indiamart.com/newsletters/mailer/images/time-buyer-request280616.png" style="display:block; border:0; max-width:17px;"/></td>
      <td width="" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:18px; padding:10px; text-align:left;">$offer_disp_date</td>
      <td width="20px"><img src="https://www.indiamart.com/newsletters/mailer/images/location-buyer-request280616.png" /></td>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:18px; padding:1px; text-align:left;">
EOF;

if(!empty($city) &&  $country == 'India')
						{
						$message .=  $city;
							if(!empty($state))
						{

							$state = preg_replace("/^\s+|\s+$/","",$state);
 							$city = preg_replace("/^\s+|\s+$/","",$city);
							if(strtolower($state) != strtolower($city))
							{
							$message .=  ', '.$state;
							}
						}
						else
						{
							$message .=  ', '.$country;
						}
						}
						else
						{
						$message .=  $country;
						}
$message .= <<<EOF
<span style="display:inline-block;padding:5px"><img style="vertical-align:top;margin-top:2px;font-size:12px" alt="" src="http://seller.imimg.com/gifs/flags-img/in_flag_s.png" height="16" border="0" width="17" ></span></td>
              
EOF;



$message .='
</td>
    </tr>
  </tbody>
</table>
</td>
    </tr>
    <tr>
      <td style="font-family:Arial, Helvetica, sans-serif; font-size:14px;background-color:"#fff"; bgcolor:"#fff";line-height:18px;padding:10px;">';
      
     

  if(!empty($quantity) && $quantity!=" "){
$message .='
<tr>
                    <td colspan="2"><table width="100%"><tr><td><table style="padding-top:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
                              <tbody><tr>
						<td style="white-space:nowrap" valign="top" width="50"><b>Quantity</b></td>
						<td align="left" valign="top" width="11"><b>:</b></td>
						<td valign="top">'.$quantity.'&nbsp;'.$unit.'</td>
						
						</tr></tbody>
				</table>';
				 if($mod_id=='BIGBUYER')
 {
  $message .= ' </td><td align="right" style="padding-right:8px;padding-top:8px;"><img src="http://seller.imimg.com/gifs/big-buyer-logo.png"></td></tr></table></td>';
             
               } 
				
$message .='		</tr></tr>

          <tr>';
          

               
}
$message .= <<<EOF
<td style= colspan="2"></td>
          </tr><tr>
               <td colspan="2" style="padding:5px;">
EOF;
$message .= $desc;
$message .= '<br><br>';
$message .= '</td></tr>';



$enrichment_info = isset($result['ENRICHMENTINFO'])?$result['ENRICHMENTINFO']:'';
$enrichment_array = json_decode($enrichment_info,true);


if(!empty($enrichment_array))
{
//$message .= '<br>';
$message .='<table cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" class="mpr10"><tbody>';

      foreach($enrichment_array as $key=>$value)
      {
      
	  $message .='<tr><td width="100px" valign="top" style="white-space:nowrap;padding:5px; background-color:#ffffff">'.$key.'</td><td width="8" valign="top" align="left"><strong>:</strong></td><td valign="top"> '.$value.'</td></tr>';
      
      }
     $message .= '</tbody></table>';
	$message .= '<tr>

</tr>';
}
if(!empty($enrichment_detail)){
$message .= '<table  width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#FFFFFF;padding:5px;"><tbody>';
	foreach($enrichment_detail as $key=>$val)
			{
					$key_name = str_replace('_',' ',$key);
					$message .= '<tr><td><strong>'.ucfirst($key_name).'</strong></td><td><strong>&nbsp;:&nbsp;  </strong></td><td>'.$val.'</td></tr>';
				

			}
$message .= '</tbody></table>';

		$message .= '<tr>
<td colspan="2" style="padding-top:20px" background-color:#fff" bgcolor="#fff"></td>
';
}    
      
      
 $message .='    
      </tr>
    <tr>
      <td style="padding:10px; background-color:#fff" bgcolor="#fff" align="center">';
      
 //<div>sdgfsd g</div> TO ADD ANY TEXT 
 $message .='     
      <a href="'.$url.'" style="text-decoration:none; color:#000000;"><div style=" background:#31d247; padding:13px; border:0px; border-radius:10px; font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:18px; text-align:center; width:45%; outline:none;"><strong>Submit Quote Now</strong></div></a></td>
    </tr>
       
  </tbody>
</table>
</td>
  </tr>
  

<tr>
    <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; background-color:#fff" bgcolor="#fff" line-height:18px; padding:12px 0px">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#FFFFFF; max-width:600px;">
    <tr>
 <td valign="top" width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#fff; border:1px solid #d1d1d1; text-align:center;">
 	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="background:#eee; border-bottom:1px solid #d1d1d1;">
  <tr>
    <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#2e3192; text-align:left; padding:10px; background:#eee; font-weight:bold; ">Happy to Help</td>
  </tr>
</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
  <tr>';
  $message .=
  <<<EOF
    <td width="50%" style="width:50%;font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; color:#10005f; padding:5px;  text-align:left; border-right:1px solid #d1d1d1;"><strong>Email:</strong>
      <a href="mailto:$mail_to1" style="color:#10005f">$mail_to</a><br />
	<strong>Call Us:</strong> <span style="color:#444"><a style="color:#10005f">$contact_no</a></span></td>
     </tr>
</table>   
	</td>
  </tr>
</table>
    
    </td>
  	</tr>
 <tr>
    <td>
	
<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td valign="top" style=" font-family:Arial, Helvetica, sans-serif; font-size:10px; text-align:center; color:#737373; padding:5px 0 0 0 ">IndiaMART InterMESH Ltd. Advant Navis Business Park, 7th Floor, Sector - 142, Noida, UP</td>
  </tr>
</table></td>
  	</tr>
  	 	
</tbody></table>
    </td>
  </tr>
</tbody></table>

</body></html>
EOF;
echo $message;