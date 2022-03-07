<?php
require('JPhpMailer.php');
class MarkComplnt extends CFormModel
{

// require('JPhpMailer.php');
public function Eto_Complain1($dbh_ImAlrt,$dbh,$glusr_id,$offerID)
{
  $error=new Mail_oracle_error;
  $str='';
  $sql ="SELECT ETO_LEAD_PUR_ID FROM ETO_LEAD_PUR_HIST 
			WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID AND FK_ETO_OFR_ID = :FK_ETO_OFR_ID";
			
			
		$sth=@oci_parse($dbh_ImAlrt,$sql);
		if(!$sth)
		{
		$e=oci_error($dbh_ImAlrt);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
	        }
 
                        oci_bind_by_name($sth,':FK_ETO_OFR_ID',$offerID);
			oci_bind_by_name($sth,':FK_GLUSR_USR_ID',$glusr_id);
   
		$chk=@oci_execute($sth);	
			if(!$chk)
			{
			$e=oci_error($sth);
			$errorMsg = $e['message'];
				$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			
		      }

			$rec = oci_fetch_assoc($sth);

			$lead_pur_id = $rec['ETO_LEAD_PUR_ID'];
                        
			 $sql = "SELECT COUNT(1) CMP FROM ETO_BL_CMPLNT WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID and FK_ETO_LEAD_PUR_ID = :FK_ETO_LEAD_PUR_ID";
			 
			  $sth1=@oci_parse($dbh,$sql);
			  if(!$sth1)
			  {
			  $e=oci_error($dbh);
			  $errorMsg = $e['message'];
				  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			 
			  }
		         
			  oci_bind_by_name($sth1,':FK_GLUSR_USR_ID',$glusr_id);
			  oci_bind_by_name($sth1,':FK_ETO_LEAD_PUR_ID',$lead_pur_id);
			  
			  $chk=@oci_execute($sth1);	
			  if(!$chk)
			  {
			  $e=oci_error($sth1);
			  $errorMsg = $e['message'];
				  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			
			  }
			  
			 $rec = oci_fetch_assoc($sth1);
			
			if($rec['CMP'])
			{
				# send msg for already complained
				$str.= <<<MSG
				<div style="padding-top:8px; margin:0px; position:absolute;top:-20px;right:-11px;border:0px;"><a href="javascript:show_alert_off('mc-part')"><img src="/gifs/close-button.png" border="0px"></img></a></div>
				<div align="center" class="alrt-headTxt"  style="margin-top:80px;margin-left:115px">
				A complaint is already marked for this Buy Lead
				</div>
				<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off('mc-part')"></button></div>
MSG;
			}
			else
			{
				#check for differernce in purchased date and current date must not be more than 7
				$sql1 = "SELECT COUNT(1) CNT 
						FROM ETO_LEAD_PUR_HIST
						WHERE (SYSDATE - ETO_PUR_DATE) > 90 AND ETO_LEAD_PUR_ID = :ETO_LEAD_PUR_ID";
						
			        $sth1=@oci_parse($dbh_ImAlrt,$sql1);
				if(!$sth1)
				{
				$e=oci_error($dbh_ImAlrt);
				$errorMsg = $e['message'];
					$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
				
				}
			      oci_bind_by_name($sth1,':ETO_LEAD_PUR_ID',$lead_pur_id);
				
			      $chk=@oci_execute($sth1);	
			      if(!$chk)
			      {
			      $e=oci_error($sth1);
			      $errorMsg = $e['message'];
				      $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			      
			      }		
                              
				$rec1 = oci_fetch_assoc($sth1);
				if($rec1['CNT'])
				{
					#lead purchased not within 7 days
					#send error msg
					$str.=<<<MSG
					<div style="padding-top:8px; margin:0px; position:absolute;top:-20px;right:-11px;border:0px;"><a href="javascript:show_alert_off('mc-part')"><img src="/gifs/close-button.png" border="0px"></img></a></div>
					<div align="center" class="alrt-headTxt"  style="margin-top:80px;margin-left:30px">
					Sorry! Buy Lead Complaint cannot be raised after 30 days of purchase.

					</div>
					<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off('mc-part')"></button></div>
MSG;
				}
				else
				{
					$str.=$this->showHtml($dbh_ImAlrt,$dbh,$lead_pur_id,$offerID,$glusr_id);
				}
			}
			return $str;


}


public function mail_copy()
{
if(isset($_REQUEST['text']))
                       
 {
			      if(isset($_REQUEST['text']))
			      {
			      $mailtext = $_REQUEST['text'];
			      }
			      else
			      {
			      $mailtext='';
			      }
			      if(isset($_REQUEST['purid']))
			      {
			      $purid = $_REQUEST['purid'];
			      }
			      else
			      {
			      $purid='';
			      }
			      if(isset($_REQUEST['glid']))
			      {
			      $supid = $_REQUEST['glid'];
			      }
			      else
			      {
			      $supid='';
			      }
			      $root = $_SERVER['DOCUMENT_ROOT'];
			      $rootpath = "$root/admin_eto/mailer/cmplnt_crm";
			      $filename = "$rootpath/$supid-$purid"."mail.txt"; 
			      $file=fopen($filename,"w");
			      fwrite($file,$mailtext);
			      fclose($file);
                        }

}

public function sendmailtobuyer($dbh,$suppglusrid,$offerID)
{
              
         $sql="SELECT GLUSR_USR.GLUSR_USR_ID GLUSR_USR_ID,TRIM(GLUSR_USR_FIRSTNAME) ||' '||TRIM(GLUSR_USR_LASTNAME) BUYERNAME,GLUSR_USR.GLUSR_USR_EMAIL GLUSR_USR_EMAIL,ETO_OFR.ETO_OFR_TITLE ETO_OFR_TITLE,GLUSR_USR.FK_GL_COUNTRY_ISO FROM ETO_OFR, GLUSR_USR WHERE ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
        AND ETO_OFR.ETO_OFR_DISPLAY_ID=:offerID";
        
        $sth=@oci_parse($dbh,$sql);
				if(!$sth)
				{
				$e=oci_error($dbh);
				$errorMsg = $e['message'];
					$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
				
				}
			        oci_bind_by_name($sth,':offerID',$offerID);
				
				$chk=@oci_execute($sth);	
				if(!$chk)
				{
				$e=oci_error($sth);
				$errorMsg = $e['message'];
					$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
				
				}	
		
        $rec = oci_fetch_assoc($sth);
	$buyername = $rec['BUYERNAME'];
	$glusrID=$rec['GLUSR_USR_ID'];
	$ofr_title=$rec['ETO_OFR_TITLE'];
	$buyerEmail = $rec['GLUSR_USR_EMAIL'];


	$sql_company="SELECT GLUSR_USR_COMPANYNAME FROM GLUSR_USR WHERE  GLUSR_USR_ID=:suppglusrid";
	
	$sth_company=@oci_parse($dbh,$sql_company);
	
				if(!$sth_company)
				{
				$e=oci_error($dbh);
				$errorMsg = $e['message'];
					$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
				
				}
			        oci_bind_by_name($sth_company,':suppglusrid',$suppglusrid);
				
				$chk=@oci_execute($sth_company);	
				if(!$chk)
				{
				$e=oci_error($sth_company);
				$errorMsg = $e['message'];
					$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
				
				}

       
	$rec_company = oci_fetch_assoc($sth_company);
	$sup_company = $rec_company['GLUSR_USR_COMPANYNAME'];
	list($sysyear,$sysmonth,$sysdate) = explode("-", date('Y-m-d'));
	$sysDateFull = $sysyear . $sysmonth . $sysdate;
	$buyerReUpdUrl = $offerID.'-'.$sysDateFull;
	$buyerReUpdUrl = base64_encode($buyerReUpdUrl);
	$buyerReUpdUrl=preg_replace('/\n/i','',$buyerReUpdUrl);
	$offerID=base64_encode($offerID);
	$delUrl='http://my.indiamart.com/cgi/eto-delete-offer-feedback.mp?offer='.$offerID.'&flag=feedback';
	  $toEmail=$buyerEmail;
	 $from = 'buyershelp@indiamart.com';
        $from_name = 'IndiaMART Buyers Helpdesk';
        if(isset($rec['ETO_OFR_TITLE']))
        {
	$offerTitle = $rec['ETO_OFR_TITLE'];
	}
	else
	{
	$offerTitle='';
	}

	$reply_to = '';
	$cc = '';	
	$subject = 'Update Status: Your Buy Requirement for "'.$offerTitle.'"';
        $mime_header = "Content-type: text/html\n\n";
        $formatEmail = $toEmail;
        strtr($formatEmail,"@","=");
	$bouncemail = 'tradeadmin-'.$glusrID.'-'.$formatEmail.'@route.indiamart.com';
	$message = '';
        $category_buyer = 'BL Complaint Feedback Mails';          
        
	$message = '<html>
<head>
<title>Update Status On Your Buy Requirement</title>
</head>
<body>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td style="padding:5px 0px 5px 0px;border-bottom:3px solid #2e3192">
<span style="font-family:arial;font-size:26px;font-weight:bold;color:#990000;text-align:left">Buyers Helpdesk</span>
<img src="https://www.indiamart.com/gifs06/logo-imart-new.gif" alt="IndiaMART.com" title="IndiaMART.com" align="right" style="width:120px">
</td>
</tr>
<tr>
<td style="font-family:arial;">
<div style="font-family:Segoe UI,arial;font-size:13px;line-height:18px;color:#000000">
<br>
<div style="font-size:15px;line-height:21px;">Dear '.$buyername.',<br><br>
This is in reference to your Buy Requirement for <b>"'.$offerTitle.'"</b>.

<b>Just a short note to thank you for all the help and support almost all the vendors listed.</b>
<br><br>In response to your buy requirement,<b> "'.$sup_company.'"</b> tried to contact you but did not get any response from you. 
</div><br>
	

<div style="padding:5px 0 5px 10px;line-height:25px;background:#effaff;border:dashed 1px #9ebdcc; border-radius:5px;
-moz-border-radius:5px;">
<span style="color:#585858"></span><a href="'.$delUrl.'" style="color:#0000ff" target="_blank"><strong style="font-size:15px;">Click Here</strong></a> to update the current status of your buy requirement.</div>
<br><br>
For any query or clarification, please feel free to contact us and we will be glad to serve you.<br><br>
<div style="color:#585858"><b>Regards,</b><br>

IndiaMART Buyers Helpdesk <br>
Email: <a href="mailto:buyershelp@indiamart.com" target="_blank"><span class="il">buyershelp@indiamart.com</span></a> | Call: +91-9953870004';

if($rec['FK_GL_COUNTRY_ISO'] == 'IN')
{
$message .= ' | Toll Free: 1800-200-4444';
}


$message .= '</div></div></td>
</tr>
</tbody></table>
</body>
</html>
';

  setlocale(LC_ALL,"hu_HU.UTF8");
  $date=strftime("%Y. %B %d. %A. %X %Z");

 $unique_args = array("sentdate"=>$date,"iilglusrid"=>$glusrID);
// $this->SendMail($toEmail,$from,$subject,$message,$from_name,$category_buyer,$unique_args);
//  $sendGridUserName = 'rajkamal@indiamart.com';
$sendGridUserName = 'rajkamal+BLFeedback@indiamart.com';
 $sendGridPassword='motherindia12';
 $mail_cnt=0;

 $mail_cnt=$this->SendMail($subject, $category_buyer,$message, $toEmail, $from_name, $from, $sendGridUserName, $sendGridPassword,$mail_cnt,$glusrID);

}


 public function InsertCmplnt($dbh_ImAlrt,$dbh,$lead_pur_id,$cmplnt_reason,$cmplnt_desc,$emp_id,$cmplnt_id,$suppglusrid,$offerID)
 {
   $str1='';
   $cmplnt_return_id='';

   //$cmplnt_desc=preg_replace('/\s+/','',$cmplnt_desc);
   $sql = "SELECT 
		FK_GLUSR_USR_ID,
		ETO_CREDITS_USED
	FROM 	ETO_LEAD_PUR_HIST
	WHERE   ETO_LEAD_PUR_ID = :ETO_LEAD_PUR_ID";
	
	$sth=@oci_parse($dbh_ImAlrt,$sql);
		if(!$sth)
		{
		$e=oci_error($dbh_ImAlrt);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	       
	        }
 
   oci_bind_by_name($sth,':ETO_LEAD_PUR_ID',$lead_pur_id);
   
	$chk=@oci_execute($sth);	
		if(!$chk)
		{
		$e=oci_error($sth);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
	       }
	       
   $rec = oci_fetch_assoc($sth);

	$glusr_id = $rec['FK_GLUSR_USR_ID'];
        $credit_used = $rec['ETO_CREDITS_USED'];
	
	 $sql = "BEGIN INSERT INTO  ETO_BL_CMPLNT
			(
			FK_ETO_LEAD_PUR_ID,
			FK_ETO_CREDITS_USED,
			FK_GLUSR_USR_ID,
			ETO_BL_CMPLNT_REASON,
			ETO_CMPLNT_RAISED_FROM,
			ETO_BL_CMPLNT_BY,
			ETO_BL_CMPLNT_DESC,
			ETO_BL_CMPLNT_ON,
			FK_ETO_OFR_DISPLAY_ID
			";
			
			
	if($cmplnt_id)
	{
		$sql .= ",ETO_CMPLNT_ERP_ADD_STATUS,
				FK_COMPLAINT_ID";
	}
	
	$sql .= " ) VALUES
		(
		:FK_ETO_LEAD_PUR_ID,
		:FK_ETO_CREDITS_USED,
		:FK_GLUSR_USR_ID,
		:ETO_BL_CMPLNT_REASON,
		'Gladmin',
		:ETO_BL_CMPLNT_BY,
		:ETO_BL_CMPLNT_DESC,
		SYSDATE,
		:FK_ETO_OFR_DISPLAY_ID";

	if($cmplnt_id)
	{
		$sql .=",1,
			:FK_COMPLAINT_ID";
	}
// 	$sql .=")";
	$sql .= ")  RETURNING ETO_BL_CMPLNT_ID INTO :cmplnt_return_id;
		END;";


	$sth=@oci_parse($dbh,$sql);
		if(!$sth)
		{
		$e=oci_error($dbh);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	       
	        }
 
   oci_bind_by_name($sth,':FK_ETO_LEAD_PUR_ID',$lead_pur_id);
   oci_bind_by_name($sth,':FK_ETO_CREDITS_USED',$credit_used);
   oci_bind_by_name($sth,':FK_GLUSR_USR_ID',$glusr_id);
   oci_bind_by_name($sth,':ETO_BL_CMPLNT_REASON',$cmplnt_reason);
   oci_bind_by_name($sth,':ETO_BL_CMPLNT_BY',$emp_id);
   oci_bind_by_name($sth,':ETO_BL_CMPLNT_DESC',$cmplnt_desc);
   oci_bind_by_name($sth,':FK_ETO_OFR_DISPLAY_ID',$offerID);      
    
    
        if($cmplnt_id)
	{
	 oci_bind_by_name($sth,':FK_COMPLAINT_ID',$cmplnt_id);
	}
 	 oci_bind_by_name($sth,':cmplnt_return_id',$cmplnt_return_id,10);
   
	$chk=@oci_execute($sth);	
		if(!$chk)
		{
		$e=oci_error($sth);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	       
	       }	
	 

        $this->sendmailtobuyer($dbh_ImAlrt,$suppglusrid,$offerID);
   
       
        if($cmplnt_id)
	{
		echo  '<div align="center" class="alrt-headTxt"  style="margin-top:50px;margin-left:30px">
			 Complaint has been issued with Ticket Id: '. $cmplnt_id .'
			</div>
			<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off(\'mc-part\')"></button></div>';
	}
	else
	{
		
		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net'))
		  {
		  $url= "http://207.228.237.247:83/buy-leads/index.php";
		  }
		  elseif(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
		  {
		    $url= "http://207.228.237.247:83/buy-leads/index.php";
		  }
		  else
		  {
		    $url= "http://blweberp.intermesh.net/buy-leads/index.php";
		  }
				  
		$content = array(
			    'ofr' => $offerID,
			    'cmplnt' => $cmplnt_return_id,
			    'usrID' => $glusr_id
				    );
	      

		$curl = curl_init($url);                                                                    
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		
		
		
		
		
                $response = curl_exec($curl); 
 		if ($response === FALSE) 
			      {
				  echo('cURL error: '.curl_error($ch)."\n");
			
			      } 
		
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$wsresult = '';
		$cmpflag = 0;
		
		




	  if($http_status == 200 || $http_status == '200')
	  {
	 

	  $wsresult='';
	  $wsresult = json_decode($response,true);
	  $cmpflag = isset($wsresult['flag']) ? $wsresult['flag'] :'';
	  $msg = isset($wsresult['msg']) ? $wsresult['msg'] : '';
	  $weberpCmplntID = isset($wsresult['Complaint_ID']) ? $wsresult['Complaint_ID'] : '';
	  }
	  else
	  { 
	 
	        ob_start();
		$message=print_r($response);
		$result = ob_get_clean();

                $this->Sendmail1(__FILE__,__LINE__,'gladmin-team@indiamart.com','gladmin-team@indiamart.com','','Error While Mark Complaint',$message,'Laxmi Sachan');
          }



	curl_close($curl);

	
        if(isset($cmpflag) && $cmpflag==1)
	{
	
	       
		echo '<div align="center" class="alrt-headTxt"  style="margin-top:50px;margin-left:30px">'.$msg.' Complaint ID: '.$weberpCmplntID.'</div>';
	}
	else
	{	
	
		echo '<div align="center" class="alrt-headTxt"  style="margin-top:50px;margin-left:30px">
		Your complaint has been recorded. We will contact you soon.
		</div>
		<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off(\'mc-part\')"></button></div>';
		
		
	}
   }
  
 }





public function showHtml($dbh_ImAlrt,$dbh,$lead_pur_id,$offerID,$suppglusrid)
{
  $str2='';
//   $suppglusrid=0;
  if(!isset($suppglusrid))
  {
   $suppglusrid=0;
  }
  $sql ="SELECT (GLUSR_USR_FIRSTNAME ||' '|| GLUSR_USR_LASTNAME) GLUSR_NAME,
	DECODE(LTRIM(GLUSR_USR_PH_MOBILE),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || GLUSR_USR_PH_MOBILE)) GLUSR_MOBILE,GLUSR_USR_EMAIL,ETO_OFR.ETO_OFR_TITLE OFR_TITLE,FK_GLUSR_USR_ID
	FROM GLUSR_USR,
        (
                SELECT ETO_OFR_TITLE,FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID = :ETO_OFR_DISPLAY_ID
                UNION
                SELECT ETO_OFR_TITLE,FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_DISPLAY_ID = :ETO_OFR_DISPLAY_ID
                UNION
                SELECT ETO_OFR_TITLE,FK_GLUSR_USR_ID FROM ETO_OFR_TEMP_DEL WHERE ETO_OFR_DISPLAY_ID = :ETO_OFR_DISPLAY_ID
        ) ETO_OFR
	WHERE GLUSR_USR.GLUSR_USR_ID = ETO_OFR.FK_GLUSR_USR_ID";
	
	$sth=@oci_parse($dbh_ImAlrt,$sql);
		if(!$sth)
		{
		$e=oci_error($dbh_ImAlrt);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
	        }
	     
	
	oci_bind_by_name($sth,':eto_ofr_display_id',$offerID);
	
	$chk=@oci_execute($sth);	
		if(!$chk)
		{
		$e=oci_error($sth);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
	       }
	
	
	$rec = oci_fetch_assoc($sth);
	$glusr_name = $rec['GLUSR_NAME'];
	$glusr_email = $rec['GLUSR_USR_EMAIL'];
	$mobile = $rec['GLUSR_MOBILE'];
	$ofr_title = $rec['OFR_TITLE'];
	$glusrID = $rec['FK_GLUSR_USR_ID'];
	
        
        
        
	$str2.= '
	<div style="padding-top:8px; margin:0px; position:absolute;top:-20px;right:-11px;border:0px;">
	<a href="javascript:show_alert_off(\'mc-part\')"><img src="/gifs/close-button.png" border="0px"></img></a></div>
	<Form action=\'index.php?r=admin_bl/Eto_mark_complaint/Index\' name=\'markComplntForm\'>
	<div class="alrt-headTxt">Buy Requirement for: '.$ofr_title.'</div>
	<table width="95%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin:0px 0px 0px 10px;">
	<tr>
	<td width="15%" height="25" align="left" class="ftext">Buyer Name:</td>
	<td width="85%" align="left" class="ftext">'.$glusr_name.' ( ';
	if($glusr_email)
	{
		$str2.= 'Email : '.$glusr_email.' &nbsp;';
	}
	if($glusr_email && $mobile)
	{
		$str2.= '/&nbsp;';
	}
	if($mobile)
	{
		$str2.= 'Mobile : '.$mobile.' ';
	}
	$str2.= ')</td>
	</tr>
	<tr>
	<td height="25" align="left" class="ftext">Reason: </td>
	<td align="left" class="ftext"><select id=\'reason\' name=\'reason\' style="width:400px">
	<option value=\'----\'>--Select Reason--</option>';
	
	$sql = "SELECT ETO_BL_CMPLNT_REASON_ID,ETO_BL_CMPLNT_REASON_DESC FROM ETO_BL_CMPLNT_REASON WHERE ETO_BL_CMPLNT_REASON_DISPLAY='1' ORDER BY substr(ETO_BL_CMPLNT_REASON_DESC,1,100)";
	
	
	$sth=@oci_parse($dbh,$sql);
        
		if(!$sth)
		{
		$e=oci_error($dbh);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	      
	        }
	
	
	
	$chk=@oci_execute($sth);	
		if(!$chk)
		{
		$e=oci_error($sth);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	       
	       }
	
	while($rec = oci_fetch_assoc($sth))
	{
		$str2.= '<option value="'.$rec['ETO_BL_CMPLNT_REASON_ID'].'">
		'.$rec['ETO_BL_CMPLNT_REASON_DESC'].'
		</option>';
	}
	
	$str2.= '</select></td>
	</tr>
	<tr>
	<td height="25" align="left" valign="top" class="ftext" style="padding-top:10px;">Remarks:</td>
	<td align="left" class="ftext"><textarea class="textar" name=\'cmplnt_desc\' id=\'cmplnt_desc\' style="width:400px;height:100px"></textarea></td>
	</tr>
	<tr>	
	<td height="25" align="left" class="ftext">Web ERP Complaint ID : </td>
	<td align="left" class="ftext">
	<input type="text" name="cmplntID" id="cmplntID" size="10" maxlength="10"> (Make Sure to Enter Correct ID)
	</td>
	</tr>';
        
	if($suppglusrid>0){           
            $sql = "SELECT FK_COMPLAINT_ID,ETO_BL_CMPLNT_ON FROM ETO_BL_CMPLNT WHERE FK_GLUSR_USR_ID =:GLUSR_ID AND ETO_BL_CMPLNT_CLOSE_ON IS NULL";
            $sth=oci_parse($dbh,$sql);
            oci_bind_by_name($sth,':GLUSR_ID',$suppglusrid);
            if(!$sth)
            {
                $e=oci_error($dbh);
                $errorMsg = $e['message'];
                $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);

            }	
            oci_execute($sth);	
            while($rec = oci_fetch_assoc($sth))
            {
                    $str2.= '<tr><td align="left" class="ftext" colspan="2"><b>Existing Complaint ID:</b> '.$rec['FK_COMPLAINT_ID'].'&nbsp;&nbsp; <b>Issued On:</b> '.$rec['ETO_BL_CMPLNT_ON'].'</td></tr>';
            }         
        }
       
        $str2.= '<tr>
	<td>&nbsp;
	<input type=\'hidden\' name=\'action_val\' id=\'action_val\' value=\'mark_cmplnt\'/>
	<input type=\'hidden\' id=\'leadPurId\' name=\'leadPurId\' value=\''.$lead_pur_id.'\'/>
	<input type=\'hidden\' id=\'offerID\' name=\'offerID\' value=\''.$offerID.'\'/>
	<input type=\'hidden\' id=\'suppglusrid\' name=\'suppglusrid\' value=\''.$suppglusrid.'\'/>
	</td>
	<td style="padding-left:75px"><input name="mark-complaint" type="button" style="padding: 3px 8px;" class="fwb mf14 mc2" id="mark-complaint" value="Mark Complaint" onClick="check_mark_complaint(\'index.php?r=admin_bl/Eto_mark_complaint/Index\',\'cmplnt_div\',this.form);"></input>
        &nbsp;&nbsp;<input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Cancel" onClick="javascript:show_alert_off(\'mc-part\')"></button>
        &nbsp;&nbsp;<input name="copymail" style="color: violet;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="copymail" value="Copy Mail" onClick="javascript:copy_mail('.$lead_pur_id.','.$suppglusrid.')"></td>
	</tr>
	</table>
	</form>
	';
	
	return $str2;
}
   
    
    
    
    
    
  public function removeUnwantedInfo($str)
{

	$str = preg_replace('/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)/i', '',$str);
	$str = preg_replace('/(<\s*img\b.*?\s*>)/i', '',$str);
	$str = preg_replace('/(http|www)(.*?)(\s+?|$/i)', '',$str);
	$str = preg_replace('/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)/i', '',$str);
	return $str;
}  


public function Sendmail1($file_name,$lineno,$to,$from,$cc,$subject,$message,$sender_name)
        {
		
		$headers=
				"From:$from \n".
				"Reply-To:$to\n".
				"Cc:$cc\n".
				"MIME-Version: 1.0 \n".
				"Content-type: text/html; charset=UTF-8";
		mail($to,$subject,$message,$headers);
        }
        

public function SendMail($subject, $sendGridCategory,$body, $to, $fromName, $fromMail, $sendGridUserName, $sendGridPassword,$mail_cnt,$gl_id)
    {
        $sent_date=date('d-m-y', time());
        $title    = $fromName;
        $from     = $fromMail;
        $usrName  = $sendGridUserName;
        $pass     = $sendGridPassword;

        $toarr=explode(",",$to);
      
        $url = 'https://api.sendgrid.com/';
        $user = $usrName;
        $pass = $pass;
      
      
       //for removing Unsubscribe link 
        $json_string = array(

        'to' => $toarr,
        'category' => $sendGridCategory,
        'unique_args' => array('sentdate' => $sent_date, 'iilglusrid' => $gl_id),
        'filters' => array(
        'subscriptiontrack' => array(
        'settings' => array(
        'enable' => 0,
              )
          )
        ),
          ); 
         
        $params = array(
        'api_user'  => $usrName,
            
        'api_key'   => $pass,
        //'name'=>'footer','text/html'=>'','text/plain'=>'',
        'x-smtpapi' => json_encode($json_string),
           'to'        => $to,
        'subject'   => $subject,
        'html'      => $body,
        'from'      => $from,
        'fromname'  => $title,

        );
      
        $request =  $url.'api/mail.send.json';

        $session = curl_init($request);
        curl_setopt ($session, CURLOPT_POST, true);
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($session);
        $http_status = curl_getinfo($session, CURLINFO_HTTP_CODE);
       
        if($http_status==200)
        {   
           $mail_cnt++;
        }
     
        curl_close($session);
       
     return $mail_cnt;  

    }

public function Eto_Complain1_PG($dbh_ImAlrt,$dbh,$glusr_id,$offerID)
{

  $error=new Mail_oracle_error;
  $str='';
    
  $sql ="SELECT ETO_LEAD_PUR_ID FROM ETO_LEAD_PUR_HIST 
			WHERE FK_GLUSR_USR_ID = $2 AND FK_ETO_OFR_ID = $1";
			
		$params = array($offerID,$glusr_id);
                $sth = pg_query_params($dbh_ImAlrt,$sql, $params);
		if(!$sth)
		{
			 mail("gladmin-team@indiamart.com","PG-Error in Query:Mark Complaint","sql=$sql");
	        
	        }
 
			$rec = pg_fetch_array($sth);
			 if(empty($rec))
			  $rec=array();
			  $rec=array_change_key_case($rec, CASE_UPPER);

			  $lead_pur_id = $rec['ETO_LEAD_PUR_ID'];
                        
			 $sql = "SELECT COUNT(1) CMP FROM ETO_BL_CMPLNT WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID and FK_ETO_LEAD_PUR_ID = :FK_ETO_LEAD_PUR_ID";
			 
			  $sth1=@oci_parse($dbh,$sql);
			  if(!$sth1)
			  {
			  $e=oci_error($dbh);
			  $errorMsg = $e['message'];
				  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			 
			  }
		         
			  oci_bind_by_name($sth1,':FK_GLUSR_USR_ID',$glusr_id);
			  oci_bind_by_name($sth1,':FK_ETO_LEAD_PUR_ID',$lead_pur_id);
			  
			  $chk=@oci_execute($sth1);	
			  if(!$chk)
			  {
			  $e=oci_error($sth1);
			  $errorMsg = $e['message'];
				  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			
			  }
			  
			 $rec = oci_fetch_assoc($sth1);
			
			if($rec['CMP'])
			{
				# send msg for already complained
				$str.= <<<MSG
				<div style="padding-top:8px; margin:0px; position:absolute;top:-20px;right:-11px;border:0px;"><a href="javascript:show_alert_off('mc-part')"><img src="/gifs/close-button.png" border="0px"></img></a></div>
				<div align="center" class="alrt-headTxt"  style="margin-top:80px;margin-left:115px">
				A complaint is already marked for this Buy Lead
				</div>
				<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off('mc-part')"></button></div>
MSG;
			}
			else
			{
				#check for differernce in purchased date and current date must not be more than 7
				
				$sql1 = "SELECT COUNT(1) CNT 
						FROM ETO_LEAD_PUR_HIST
						WHERE (SYSDATE - ETO_PUR_DATE) > 90 AND ETO_LEAD_PUR_ID = $1";
						
			       $params = array($lead_pur_id);
			    $sth1 = pg_query_params($dbh_ImAlrt,$sql1, $params);
			    if(!$sth1)
			    {
				    mail("gladmin-team@indiamart.com","PG-Error in Query:Mark Complaint","sql=$sql1");
			    
			    }
			       
			 	
				$rec1 = pg_fetch_array($sth1);
			        if(empty($rec1))
				$rec1=array();
				$rec1=array_change_key_case($rec1, CASE_UPPER);
				if($rec1['CNT'])
				{
					#lead purchased not within 7 days
					#send error msg
					$str.=<<<MSG
					<div style="padding-top:8px; margin:0px; position:absolute;top:-20px;right:-11px;border:0px;"><a href="javascript:show_alert_off('mc-part')"><img src="/gifs/close-button.png" border="0px"></img></a></div>
					<div align="center" class="alrt-headTxt"  style="margin-top:80px;margin-left:30px">
					Sorry! Buy Lead Complaint cannot be raised after 30 days of purchase.

					</div>
					<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off('mc-part')"></button></div>
MSG;
				}
				else
				{
					$str.=$this->showHtml_PG($dbh_ImAlrt,$dbh,$lead_pur_id,$offerID,$glusr_id);
				}
			}
			return $str;


}

public function sendmailtobuyer_PG($dbh,$suppglusrid,$offerID)
{
      
    
    $sql="SELECT GLUSR_USR.GLUSR_USR_ID GLUSR_USR_ID,TRIM(GLUSR_USR_FIRSTNAME) ||' '||TRIM(GLUSR_USR_LASTNAME) BUYERNAME,GLUSR_USR.GLUSR_USR_EMAIL GLUSR_USR_EMAIL,ETO_OFR.ETO_OFR_TITLE ETO_OFR_TITLE,GLUSR_USR.FK_GL_COUNTRY_ISO FROM ETO_OFR, GLUSR_USR WHERE ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
        AND ETO_OFR.ETO_OFR_DISPLAY_ID=$1";
        
        
        		
			       $params = array($offerID);
			    $sth = pg_query_params($dbh,$sql, $params);
			    if(!$sth)
			    {
				    mail("gladmin-team@indiamart.com","PG-Error in Query:Mark Complaint","sql=$sql");
			    
			    }
			       
			 	
	$rec = pg_fetch_array($sth);
	if(empty($rec))
	$rec=array();
	$rec=array_change_key_case($rec, CASE_UPPER);
    
    
	$buyername = isset($rec['BUYERNAME']) ? $rec['BUYERNAME'] : '';
	$glusrID=isset($rec['GLUSR_USR_ID']) ? $rec['GLUSR_USR_ID'] : '';
	$ofr_title=isset($rec['ETO_OFR_TITLE']) ? $rec['ETO_OFR_TITLE'] : '';
	$buyerEmail = isset($rec['GLUSR_USR_EMAIL']) ? $rec['GLUSR_USR_EMAIL'] : '';

	$sql_company="SELECT GLUSR_USR_COMPANYNAME FROM GLUSR_USR WHERE  GLUSR_USR_ID=$1";
	
	   $params = array($suppglusrid);
			    $sth_company = pg_query_params($dbh,$sql_company, $params);
			    if(!$sth_company)
			    {
				    mail("gladmin-team@indiamart.com","PG-Error in Query:Mark Complaint","sql=$sql_company");
			    
			    }
			       
			 	
	$rec_company = pg_fetch_array($sth_company);
	if(empty($rec_company))
	$rec_company=array();
	$rec_company=array_change_key_case($rec_company, CASE_UPPER);

	$sup_company = isset($rec_company['GLUSR_USR_COMPANYNAME']) ? $rec_company['GLUSR_USR_COMPANYNAME'] : '';
	list($sysyear,$sysmonth,$sysdate) = explode("-", date('Y-m-d'));
	$sysDateFull = $sysyear . $sysmonth . $sysdate;
	$buyerReUpdUrl = $offerID.'-'.$sysDateFull;
	$buyerReUpdUrl = base64_encode($buyerReUpdUrl);
	$buyerReUpdUrl=preg_replace('/\n/i','',$buyerReUpdUrl);
	$offerID=base64_encode($offerID);
	$delUrl='http://my.indiamart.com/cgi/eto-delete-offer-feedback.mp?offer='.$offerID.'&flag=feedback';
	 $toEmail=$buyerEmail;
	 $from = 'buyershelp@indiamart.com';
        $from_name = 'IndiaMART Buyers Helpdesk';
        if(isset($rec['ETO_OFR_TITLE']))
        {
	$offerTitle = $rec['ETO_OFR_TITLE'];
	}
	else
	{
	$offerTitle='';
	}

	$reply_to = '';
	$cc = '';	
	$subject = 'Update Status: Your Buy Requirement for "'.$offerTitle.'"';
        $mime_header = "Content-type: text/html\n\n";
        $formatEmail = $toEmail;
        strtr($formatEmail,"@","=");
	$bouncemail = 'tradeadmin-'.$glusrID.'-'.$formatEmail.'@route.indiamart.com';
	$message = '';
        $category_buyer = 'BL Complaint Feedback Mails';          
        
	$message = '<html>
<head>
<title>Update Status On Your Buy Requirement</title>
</head>
<body>
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
<td style="padding:5px 0px 5px 0px;border-bottom:3px solid #2e3192">
<span style="font-family:arial;font-size:26px;font-weight:bold;color:#990000;text-align:left">Buyers Helpdesk</span>
<img src="https://www.indiamart.com/gifs06/logo-imart-new.gif" alt="IndiaMART.com" title="IndiaMART.com" align="right" style="width:120px">
</td>
</tr>
<tr>
<td style="font-family:arial;">
<div style="font-family:Segoe UI,arial;font-size:13px;line-height:18px;color:#000000">
<br>
<div style="font-size:15px;line-height:21px;">Dear '.$buyername.',<br><br>
This is in reference to your Buy Requirement for <b>"'.$offerTitle.'"</b>.

<b>Just a short note to thank you for all the help and support almost all the vendors listed.</b>
<br><br>In response to your buy requirement,<b> "'.$sup_company.'"</b> tried to contact you but did not get any response from you. 
</div><br>
	

<div style="padding:5px 0 5px 10px;line-height:25px;background:#effaff;border:dashed 1px #9ebdcc; border-radius:5px;
-moz-border-radius:5px;">
<span style="color:#585858"></span><a href="'.$delUrl.'" style="color:#0000ff" target="_blank"><strong style="font-size:15px;">Click Here</strong></a> to update the current status of your buy requirement.</div>
<br><br>
For any query or clarification, please feel free to contact us and we will be glad to serve you.<br><br>
<div style="color:#585858"><b>Regards,</b><br>

IndiaMART Buyers Helpdesk <br>
Email: <a href="mailto:buyershelp@indiamart.com" target="_blank"><span class="il">buyershelp@indiamart.com</span></a> | Call: +91-9953870004';

if(isset($rec['FK_GL_COUNTRY_ISO']) && $rec['FK_GL_COUNTRY_ISO'] == 'IN')
{
$message .= ' | Toll Free: 1800-200-4444';
}


$message .= '</div></div></td>
</tr>
</tbody></table>
</body>
</html>
';

  setlocale(LC_ALL,"hu_HU.UTF8");
  $date=strftime("%Y. %B %d. %A. %X %Z");

 $unique_args = array("sentdate"=>$date,"iilglusrid"=>$glusrID);
// $this->SendMail($toEmail,$from,$subject,$message,$from_name,$category_buyer,$unique_args);
//  $sendGridUserName = 'rajkamal@indiamart.com';
$sendGridUserName = 'rajkamal+BLFeedback@indiamart.com';
 $sendGridPassword='motherindia12';
 $mail_cnt=0;

 $mail_cnt=$this->SendMail($subject, $category_buyer,$message, $toEmail, $from_name, $from, $sendGridUserName, $sendGridPassword,$mail_cnt,$glusrID);

}



 public function InsertCmplnt_PG($dbh_ImAlrt,$dbh,$lead_pur_id,$cmplnt_reason,$cmplnt_desc,$emp_id,$cmplnt_id,$suppglusrid,$offerID)
 {
   $str1='';
   $cmplnt_return_id='';
  
     $sql = "SELECT 
		FK_GLUSR_USR_ID,
		ETO_CREDITS_USED
	FROM 	ETO_LEAD_PUR_HIST
	WHERE   ETO_LEAD_PUR_ID =$1";

	$params = array($lead_pur_id);
			    $sth = pg_query_params($dbh_ImAlrt,$sql, $params);
			    if(!$sth)
			    {
				    mail("gladmin-team@indiamart.com","PG-Error in Query:Mark Complaint","sql=$sql");
			    
			    }
			       
			 	
	$rec = pg_fetch_array($sth);
	if(empty($rec))
	$rec=array();
	$rec=array_change_key_case($rec, CASE_UPPER);
    
   

	$glusr_id = $rec['FK_GLUSR_USR_ID'];
        $credit_used = $rec['ETO_CREDITS_USED'];
	
	 $sql = "BEGIN INSERT INTO  ETO_BL_CMPLNT
			(
			FK_ETO_LEAD_PUR_ID,
			FK_ETO_CREDITS_USED,
			FK_GLUSR_USR_ID,
			ETO_BL_CMPLNT_REASON,
			ETO_CMPLNT_RAISED_FROM,
			ETO_BL_CMPLNT_BY,
			ETO_BL_CMPLNT_DESC,
			ETO_BL_CMPLNT_ON,
			FK_ETO_OFR_DISPLAY_ID
			";
			
			
	if($cmplnt_id)
	{
		$sql .= ",ETO_CMPLNT_ERP_ADD_STATUS,
				FK_COMPLAINT_ID";
	}
	
	$sql .= " ) VALUES
		(
		:FK_ETO_LEAD_PUR_ID,
		:FK_ETO_CREDITS_USED,
		:FK_GLUSR_USR_ID,
		:ETO_BL_CMPLNT_REASON,
		'Gladmin',
		:ETO_BL_CMPLNT_BY,
		:ETO_BL_CMPLNT_DESC,
		SYSDATE,
		:FK_ETO_OFR_DISPLAY_ID";

	if($cmplnt_id)
	{
		$sql .=",1,
			:FK_COMPLAINT_ID";
	}
// 	$sql .=")";
	$sql .= ")  RETURNING ETO_BL_CMPLNT_ID INTO :cmplnt_return_id;
		END;";


	$sth=@oci_parse($dbh,$sql);
		if(!$sth)
		{
		$e=oci_error($dbh);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	       
	        }
 
   oci_bind_by_name($sth,':FK_ETO_LEAD_PUR_ID',$lead_pur_id);
   oci_bind_by_name($sth,':FK_ETO_CREDITS_USED',$credit_used);
   oci_bind_by_name($sth,':FK_GLUSR_USR_ID',$glusr_id);
   oci_bind_by_name($sth,':ETO_BL_CMPLNT_REASON',$cmplnt_reason);
   oci_bind_by_name($sth,':ETO_BL_CMPLNT_BY',$emp_id);
   oci_bind_by_name($sth,':ETO_BL_CMPLNT_DESC',$cmplnt_desc);
   oci_bind_by_name($sth,':FK_ETO_OFR_DISPLAY_ID',$offerID);      
    
    
        if($cmplnt_id)
	{
	 oci_bind_by_name($sth,':FK_COMPLAINT_ID',$cmplnt_id);
	}
 	 oci_bind_by_name($sth,':cmplnt_return_id',$cmplnt_return_id,10);
   
	$chk=@oci_execute($sth);	
		if(!$chk)
		{
		$e=oci_error($sth);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	       
	       }	
	 

        $this->sendmailtobuyer_PG($dbh_ImAlrt,$suppglusrid,$offerID);      
        if($cmplnt_id)
	{
		echo  '<div align="center" class="alrt-headTxt"  style="margin-top:50px;margin-left:30px">
			 Complaint has been issued with Ticket Id: '. $cmplnt_id .'
			</div>
			<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off(\'mc-part\')"></button></div>';
	}
	else
	{
        
		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net'))
		  {
		  $url= "http://207.228.237.247:83/buy-leads/index.php";
		  }
		  elseif(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
		  {
		    $url= "http://207.228.237.247:83/buy-leads/index.php";
		  }
		  else
		  {
		    $url= "http://blweberp.intermesh.net/buy-leads/index.php";
		  }
		
		
		$content = array(
			    'ofr' => $offerID,
			    'cmplnt' => $cmplnt_return_id,
			    'usrID' => $glusr_id
				    );
	      

		$curl = curl_init($url);                                                                    
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		
		
		
		
		
                $response = curl_exec($curl); 
 		if ($response === FALSE) 
			      {
				  echo('cURL error: '.curl_error($ch)."\n");
			
			      } 
		
		$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		$wsresult = '';
		$cmpflag = 0;
		
		




	  if($http_status == 200 || $http_status == '200')
	  {
	 

	  $wsresult='';
	  $wsresult = json_decode($response,true);
	  $cmpflag = isset($wsresult['flag']) ? $wsresult['flag'] :'';
	  $msg = isset($wsresult['msg']) ? $wsresult['msg'] : '';
	  $weberpCmplntID = isset($wsresult['Complaint_ID']) ? $wsresult['Complaint_ID'] : '';
	  }
	  else
	  { 
	 
	        ob_start();
		$message=print_r($response);
		$result = ob_get_clean();

                $this->Sendmail1(__FILE__,__LINE__,'gladmin-team@indiamart.com','gladmin-team@indiamart.com,laxmi@indiamart.com','','Error While Mark Complaint',$message,'Laxmi Sachan');
          }



	curl_close($curl);

	
        if(isset($cmpflag) && $cmpflag==1)
	{
	
	       
		echo '<div align="center" class="alrt-headTxt"  style="margin-top:50px;margin-left:30px">'.$msg.' Complaint ID: '.$weberpCmplntID.'</div>';
	}
	else
	{	
	
		echo '<div align="center" class="alrt-headTxt"  style="margin-top:50px;margin-left:30px">
		Your complaint has been recorded. We will contact you soon.
		</div>
		<div align="center" style="margin-top:30px;"><input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Close" onClick="javascript:show_alert_off(\'mc-part\')"></button></div>';
		
		
	}
   }
  
 }
 
 
public function showHtml_PG($dbh_ImAlrt,$dbh,$lead_pur_id,$offerID,$suppglusrid)
{
  $str2='';
//   $suppglusrid=0;
  if(!isset($suppglusrid))
  {
   $suppglusrid=0;
  }

    
    $sql ="SELECT (GLUSR_USR_FIRSTNAME ||' '|| GLUSR_USR_LASTNAME) GLUSR_NAME,
	DECODE(LTRIM(GLUSR_USR_PH_MOBILE),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || GLUSR_USR_PH_MOBILE)) GLUSR_MOBILE,GLUSR_USR_EMAIL,ETO_OFR.ETO_OFR_TITLE OFR_TITLE,FK_GLUSR_USR_ID
	FROM GLUSR_USR,
        (
                SELECT ETO_OFR_TITLE,FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID = $1
                UNION
                SELECT ETO_OFR_TITLE,FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_DISPLAY_ID = $1
                UNION
                SELECT ETO_OFR_TITLE,FK_GLUSR_USR_ID FROM ETO_OFR_TEMP_DEL WHERE ETO_OFR_DISPLAY_ID = $1
        ) ETO_OFR
	WHERE GLUSR_USR.GLUSR_USR_ID = ETO_OFR.FK_GLUSR_USR_ID";
	
	
			    $params = array($offerID);
			    $sth = pg_query_params($dbh_ImAlrt,$sql, $params);
			    if(!$sth)
			    {
				    mail("gladmin-team@indiamart.com","PG-Error in Query:Mark Complaint","sql=$sql");
			    
			    }
			       
			 	
	$rec = pg_fetch_array($sth);
	if(empty($rec))
	$rec=array();
	$rec=array_change_key_case($rec, CASE_UPPER);
    
	$glusr_name = $rec['GLUSR_NAME'];
	$glusr_email = $rec['GLUSR_USR_EMAIL'];
	$mobile = $rec['GLUSR_MOBILE'];
	$ofr_title = $rec['OFR_TITLE'];
	$glusrID = $rec['FK_GLUSR_USR_ID'];
	
	$str2.= '
	<div style="padding-top:8px; margin:0px; position:absolute;top:-20px;right:-11px;border:0px;">
	<a href="javascript:show_alert_off(\'mc-part\')"><img src="/gifs/close-button.png" border="0px"></img></a></div>
	<Form action=\'index.php?r=admin_bl/Eto_mark_complaint/Index\' name=\'markComplntForm\'>
	<div class="alrt-headTxt">Buy Requirement for: '.$ofr_title.'</div>
	<table width="95%" border="0" align="left" cellpadding="0" cellspacing="0" style="margin:0px 0px 0px 10px;">
	<tr>
	<td width="15%" height="25" align="left" class="ftext">Buyer Name:</td>
	<td width="85%" align="left" class="ftext">'.$glusr_name.' ( ';
	if($glusr_email)
	{
		$str2.= 'Email : '.$glusr_email.' &nbsp;';
	}
	if($glusr_email && $mobile)
	{
		$str2.= '/&nbsp;';
	}
	if($mobile)
	{
		$str2.= 'Mobile : '.$mobile.' ';
	}
	$str2.= ')</td>
	</tr>
	<tr>
	<td height="25" align="left" class="ftext">Reason: </td>
	<td align="left" class="ftext"><select id=\'reason\' name=\'reason\' style="width:400px">
	<option value=\'----\'>--Select Reason--</option>';
	
	$sql = "SELECT ETO_BL_CMPLNT_REASON_ID,ETO_BL_CMPLNT_REASON_DESC FROM ETO_BL_CMPLNT_REASON WHERE ETO_BL_CMPLNT_REASON_DISPLAY='1' ORDER BY substr(ETO_BL_CMPLNT_REASON_DESC,1,100)";
	
	
	$sth=@oci_parse($dbh,$sql);	
		if(!$sth)
		{
		$e=oci_error($dbh);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	      
	        }
	
	
	
	$chk=@oci_execute($sth);	
		if(!$chk)
		{
		$e=oci_error($sth);
		$errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	       
	       }
	
	while($rec = oci_fetch_assoc($sth))
	{
		$str2.= '<option value="'.$rec['ETO_BL_CMPLNT_REASON_ID'].'">
		'.$rec['ETO_BL_CMPLNT_REASON_DESC'].'
		</option>';
	}
	
	$str2.= '</select></td>
	</tr>
	<tr>
	<td height="25" align="left" valign="top" class="ftext" style="padding-top:10px;">Remarks:</td>
	<td align="left" class="ftext"><textarea class="textar" name=\'cmplnt_desc\' id=\'cmplnt_desc\' style="width:400px;height:100px"></textarea></td>
	</tr>
	<tr>
	<tr>
	<td height="25" align="left" class="ftext">Web ERP Complaint ID : </td>
	<td align="left" class="ftext">
	<input type="text" name="cmplntID" id="cmplntID" size="10" maxlength="10"> (Make Sure to Enter Correct ID)
	</td>
	</tr>
	<td>&nbsp;
	<input type=\'hidden\' name=\'action_val\' id=\'action_val\' value=\'mark_cmplnt\'/>
	<input type=\'hidden\' id=\'leadPurId\' name=\'leadPurId\' value=\''.$lead_pur_id.'\'/>
	<input type=\'hidden\' id=\'offerID\' name=\'offerID\' value=\''.$offerID.'\'/>
	<input type=\'hidden\' id=\'suppglusrid\' name=\'suppglusrid\' value=\''.$suppglusrid.'\'/>
	</td>
	<td style="padding-left:75px"><input name="mark-complaint" type="button" style="padding: 3px 8px;" class="fwb mf14 mc2" id="mark-complaint" value="Mark Complaint" onClick="check_mark_complaint(\'index.php?r=admin_bl/Eto_mark_complaint/Index\',\'cmplnt_div\',this.form);"></input>
        &nbsp;&nbsp;<input name="cancel-cmplnt" style="color: #388500;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="cancel-cmplnt" value="Cancel" onClick="javascript:show_alert_off(\'mc-part\')"></button>
        &nbsp;&nbsp;<input name="copymail" style="color: violet;margin-left: 5px;padding: 3px 8px;" class="fwb mf14" type="button" id="copymail" value="Copy Mail" onClick="javascript:copy_mail('.$lead_pur_id.','.$suppglusrid.')"></td>
	</tr>
	</table>
	</form>
	';
	
	return $str2;
}


}
?>