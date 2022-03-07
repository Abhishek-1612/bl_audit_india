<?php
// require_once 'Spreadsheet/Excel/Writer.php';
class Emailnotificationnewreport extends CFormModel
{
   
   public function new_call1($dbh1,$res1,$email_search,$bouncereport,$event_search,$category_search1,$category_search,$dbhpg)
   {
   
    $error=new Mail_oracle_error;
   
                   $str='';
                   $sdate_year=$res1[0];
                   $sdate_month=$res1[1];
                   $sdate_day=$res1[2];
                   $edate_year=$res1[3];
                   $edate_month=$res1[4];
                   $edate_day=$res1[5];
   
	      if(!isset($_REQUEST['popup']))
	      {
		$fields = array('edate_day','edate_month','edate_year','sdate_day','sdate_month','sdate_year');
		$param=array();
		foreach($fields as $key)
		{
			  if (isset($q[$key])) 
			  {
				  $param[$key] = $q[$key];	
			  } 
			  else 
			  {
				  $param[$key]='';
			  }
		    
		}
      
	     if(isset($_REQUEST['dropped_reason']))
	     {
	     $dropped_res_val_condition=$_REQUEST['dropped_reason'];
	     }
	     else
	     {
	     $dropped_res_val_condition='';
	     }

	 if(isset($_REQUEST['Submit']))
	 {
            $startdate=$sdate_day.'-'.$sdate_month.'-'.$sdate_year;
	    $enddate=$edate_day.'-'.$edate_month.'-'.$edate_year;
	    $minusenddate=1;
	    $condition='';
	    
	    
                     
            $sqlmailarchived="SELECT MAIL_RECV_MAILID,
                              MAIL_CATEGORY,
                              FK_MAIL_TYPE_ID,
                              NULL IIL_MAIL_EVENT_URL,
                              MAIL_REQUEST_DATE,
                              TO_CHAR(MAIL_REQUEST_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,
                              MAIL_BOUNCE_REASON,
                              MAIL_BOUNCE_CODE,
                              MAIL_RECV_GLID,
                              MAIL_SENT_DATE,
                              MAIL_FIRST_OPEN_DATE,
                              MAIL_LAST_CLICK_DATE,
                              MAIL_BOUNCE_DATE,
                              MAIL_SPAM_DATE,
                              MAIL_UNSUBSCRIBE_DATE
                              FROM IIL_MAIL_LOG_J1";
                              
                            
            
	        $condition='';

	        $event_search = $_REQUEST['event_search'];
	      
	        
	          if($event_search == 'ALL')
                 {
                  $condition .=" WHERE date_trunc('day',MAIL_REQUEST_DATE) >= to_date('$startdate','dd-mm-yyyy')
                              AND  date_trunc('day',MAIL_REQUEST_DATE)  <= to_date('$enddate','dd-mm-yyyy')";
                 }
                 elseif($event_search == 'open')
                 {
                  $condition .=" WHERE date_trunc('day',MAIL_FIRST_OPEN_DATE) >= to_date('$startdate','dd-mm-yyyy')
                              AND  date_trunc('day',MAIL_FIRST_OPEN_DATE)  <= to_date('$enddate','dd-mm-yyyy')";
                 
                 }
                 elseif($event_search == 'unsubscribe')
                 {
                  $condition .=" WHERE  date_trunc('day',MAIL_UNSUBSCRIBE_DATE) >= to_date('$startdate','dd-mm-yyyy')
                              AND  date_trunc('day',MAIL_UNSUBSCRIBE_DATE)  <= to_date('$enddate','dd-mm-yyyy')";
                 
                 }
                 elseif($event_search == 'click')
                 {
                  $condition .=" WHERE  date_trunc('day',MAIL_LAST_CLICK_DATE)  >= to_date('$startdate','dd-mm-yyyy')
                              AND  date_trunc('day',MAIL_LAST_CLICK_DATE)   <= to_date('$enddate','dd-mm-yyyy')";
                 
                 }
                 elseif($event_search == 'bounce')
                 {
                  $condition .=" WHERE  date_trunc('day',MAIL_BOUNCE_DATE) >= to_date('$startdate','dd-mm-yyyy')
                              AND  date_trunc('day',MAIL_BOUNCE_DATE)   <= to_date('$enddate','dd-mm-yyyy')";
                 
                 }
                 elseif($event_search == 'spamreport')
                 {
                  $condition .=" WHERE  date_trunc('day',MAIL_SPAM_DATE) >= to_date('$startdate','dd-mm-yyyy')
                              AND date_trunc('day',MAIL_SPAM_DATE)  <= to_date('$enddate','dd-mm-yyyy')";
                 
                 }
                  elseif($event_search == 'dropped')
                 {
                  $condition .=" WHERE date_trunc('day',MAIL_DROPPED_DATE) >= to_date('$startdate','dd-mm-yyyy')
                              AND  date_trunc('day',MAIL_DROPPED_DATE)   <= to_date('$enddate','dd-mm-yyyy')";
                 
                 }
    
	         if($category_search == 'BL Approval Mails')
	         {
	          $category_search="BL Approval Mails','Buy Leads Approval Mails";
	          
	         }
	         
	         
	         
	         if($category_search!= 'ALL' && $category_search!= 'AllDailyBLA' && $category_search!= 'User Admin Mails')
	         {
	         $condition.="and MAIL_CATEGORY in ('$category_search')";
	         }
	         if($category_search != 'ALL' && $category_search == 'AllDailyBLA')
	         {
	         $condition.="and MAIL_CATEGORY in ('All Daily BL Alerts','Morning > 0 and LP<> F','Morning > 0 and LP=F','Evening > 0 and LP<>F','Evening > 0 and LP=F','Once in Two Days Credit = 0 or NULL and LP <>F','Once in Two Days Credit = 0 or NULL and LP=F','Once Daily Morning LP <> F But 10+ Foreign Purchased','EMorning > 0 and LP<> F','LEvening > 0 and LP<>F','Instant BL Alerts','Product Preference Alerts','BL CREDITS ALLOCATION - INDIAMART TRIAL','IndiaMART Trial Reminder - IndiaMART Trial','BL Alert- Instant with Credits','BL Alert- Instant without Credits','BL Alert- Early Morning','BL Alert- Morning','BL Alert- Evening','BL Alert- Late Evening','BL Alert- ITO','IMA- Instant without Credits','IMA- Instant with Credits','IMA- Late Evening','IMA- Morning',
		'IMA- Early Morning','ITO- Instant without Credits','ITO- Instant with Credits','ITO- Late Evening','ITO- Morning',
		'ITO- Early Morning')";
		}
		if($category_search!= 'ALL' && $category_search == 'User Admin Mails')
		{
		  $condition .=" and MAIL_CATEGORY='$category_search1'";
	         
	        } 
       
              
                 
                
                 $sqlmailarchived .= $condition;
		
		 $sql = "SELECT * FROM ( $sqlmailarchived) IIL_LOG ORDER BY MAIL_REQUEST_DATE DESC limit 5000";
		 
	       
	         
		 $sth = pg_query($dbhpg,$sql);
		
                
		 
		 $time=time();
		 $filename="email-event-report-".$time.".xls";
		 $path=$_SERVER['DOCUMENT_ROOT']."/email-notification/";
		 $Excelfile =$path.$filename; 

		 
//                 $sql1interim="select count(*) CNT  from IIL_MAIL_LOG_J1";
// 		
// 		$sql1interim .= $condition;
// 		
// 		$sql1 = $sql1interim;
// 		
// 		echo "===$sql1";die;
		
// 		 $sth1 =@pg_query($dbhpg,$sql1);
// 		 
// 		
// 		  
// 
// 		 if(!$sth1)
// 		 {
// 		  $e=oci_error($dbhpg);
// 		  $errorMsg = $e['message'];
// 			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
// 	        
// 		 }
// // 		  echo "===$sql1";die;
//                
// 		
// 		$rec3=pg_fetch_assoc($sth1);
// // 		print_r($rec3);die;
// 		$cnt=$rec3['cnt'];
// 		
// 		
		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
	{
	$fp = '';
	}
	else
	{
	$fp = fopen($Excelfile, 'w');
	}
                
// 		$fp = fopen($Excelfile, 'w');

 
		$row=0;
		
		 $category_list=array('Daily BL Alerts','1','All Daily BL Alerts','All Daily BL Alerts','&nbsp;&nbsp;Morning > 0 and LP<> F','Morning > 0 and LP<> F','&nbsp;&nbsp;Morning > 0 and LP=F','Morning > 0 and LP=F','&nbsp;&nbsp;Evening > 0 and LP<>F','Evening > 0 and LP<>F','&nbsp;&nbsp;Evening > 0 and LP=F','Evening > 0 and LP=F','&nbsp;&nbsp;EMorning > 0 and LP<> F','EMorning > 0 and LP<> F','&nbsp;&nbsp;LEvening > 0 and LP<>F','LEvening > 0 and LP<>F','&nbsp;&nbsp;Once in Two Days Credit = 0 or NULL and LP <>F','Once in Two Days Credit = 0 or NULL and LP <>F','&nbsp;&nbsp;Once in Two Days Credit = 0 or NULL and LP=F','Once in Two Days Credit = 0 or NULL and LP=F','&nbsp;&nbsp;Once Daily Morning LP <> F But 10+ Foreign Purchased','Once Daily Morning LP <> F But 10+ Foreign Purchased','&nbsp;&nbsp;Instant BL Alerts','Instant BL Alerts','&nbsp;&nbsp;Product Preference Alerts','Product Preference Alerts','&nbsp;&nbsp;BL CREDITS ALLOCATION - INDIAMART TRIAL','BL CREDITS ALLOCATION - INDIAMART TRIAL','&nbsp;&nbsp;IndiaMART Trial Reminder - IndiaMART Trial','IndiaMART Trial Reminder - IndiaMART Trial','&nbsp;&nbsp;BL Alert- Instant with Credits','BL Alert- Instant with Credits','&nbsp;&nbsp;BL Alert- Instant without Credits','BL Alert- Instant without Credits','&nbsp;&nbsp;BL Alert- Early Morning','BL Alert- Early Morning','&nbsp;&nbsp;BL Alert- Morning','BL Alert- Morning','&nbsp;&nbsp;BL Alert- Evening','BL Alert- Evening','&nbsp;&nbsp;BL Alert- Late Evening','BL Alert- Late Evening','&nbsp;&nbsp;BL Alert- ITO','BL Alert- ITO','&nbsp;&nbsp;IMA- Instant without Credits','IMA- Instant without Credits','&nbsp;&nbsp;IMA- Instant with Credits','IMA- Instant with Credits','&nbsp;&nbsp;IMA- Late Evening','IMA- Late Evening','&nbsp;&nbsp;IMA- Morning','IMA- Morning','&nbsp;&nbsp;IMA- Early Morning','IMA- Early Morning','&nbsp;&nbsp;ITO- Instant without Credits','ITO- Instant without Credits','&nbsp;&nbsp;ITO- Instant with Credits','ITO- Instant with Credits','&nbsp;&nbsp;ITO- Late Evening','ITO- Late Evening','&nbsp;&nbsp;ITO- Morning','ITO- Morning','&nbsp;&nbsp;ITO- Early Morning','ITO- Early Morning','&nbsp;&nbsp;BL Expiry Reminder','2','Expiry Notification','Expiry Notification','Expiry Reminder','Expiry Reminder','Buy Lead Approval Mails','3','BL Approval- India','BL Approval- India','BL Approval- India-ALT','BL Approval- India-ALT','BL Approval- Foreign','BL Approval- Foreign','BL Approval- Foreign-ALT','BL Approval- Foreign-ALT','BL Insta AstBuy- India','BL Insta AstBuy- India','BL Insta AstBuy- India-ALT','BL Insta AstBuy- India-ALT','BL Insta AstBuy- Foreign','BL Insta AstBuy- Foreign','BL Insta AstBuy- Foreign-ALT','BL Insta AstBuy- Foreign-ALT','ASSISTED BUY','4','ASTBUY Mail to Buyer','ASTBUY Mail to Buyer','ASTBUY Mail to Supplier','ASTBUY Mail to Supplier','Buy Leads Deletion','5','BL Rejection- India','BL Rejection- India','BL Rejection- India-ALT','BL Rejection- India-ALT','BL Rejection- Foreign','BL Rejection- Foreign','BL Rejection- Foreign-ALT','BL Rejection- Foreign-ALT','BL Purchase','6','BL Purchase Mail to Buyer','BL Purchase Mail to Buyer','BL Purchase Mail to Supplier','BL Purchase Mail to Supplier','BL Renewal Mails','7','Buy Leads Renewal','BuyLeadsRenewal','BL Subscription Renewal Mails','BL Subscription Renewal Mails','MISC Mails','8','BL Call Center Approval Mails','BL Call Center Approval Mails','BL Feedback Mails','BL Feedback Mails','BL Complaint Feedback Mails','BL Complaint Feedback Mails','Feedback Mails paid Enq','Feedback mail on paid enquiries','Response Mail Sent thru MY','Response Mail Sent thru MY','BL Loc Pref Mails','BL Loc Pref Mails','BL Subscription Renewal Mails','BL Subscription Renewal Mails','BL Weberp Sales Mailer','BL Weberp Sales Mailer','BL Credits Allocation Mail','BL Credits Allocation Mail','BL Weekly Offer Mail','BL Weekly Offer Mail','Failure','Failure','IIL Advantage - Credit allocation process','IIL Advantage - Credit allocation process','No Usage Reminder','No Usage Reminder','No-Usage Credits Lapse','No-Usage Credits Lapse','Feedback Mail','Feedback Mail','
Taging Mail','
Taging Mail','Performance Scorecard','Performance Scorecard','Welcome Kit','Welcome Kit','PNS defaulter','PNS defaulter','Order Confirmation','Order Confirmation','CSD Renewal Reminder','CSD Renewal Reminder','Web Enquiry Mail-IMOB M','Web Enquiry Mail-IMOB M');

$useradmin=array('--Select--','FCP New Registration Mail','Invitation to view Product Catalog','Modify Freelisting Mail','Web Enquiry Mail - IIND QAS','Newsletter','Business Inquiry from Private Buyer Catalog','Web Enquiry Mail - 2571750','Web Enquiry Mail-FCP F','Forgot Password Mail','Web Enquiry Mail-DIR-P-ISCC','Primary Email Change','Web Enquiry Mail-ETO QAS,Web Enquiry Mail-CTL QAS','Web Enquiry Mail-ETO CC','Web Enquiry Mail - TDW QAS','Web Enquiry Mail-ETO P','PURL Approved','Web Enquiry Mail-CTL F CC','Web Enquiry Mail - INE QAS','Alternate Email Change','Web Enquiry Mail - DIR QAS','PURL Denied','Change Password Mail','Web Enquiry Mail - MDC QAS','Web Enquiry Mail-DIR-F-ISCC','Web Enquiry Mail-DIR-F','Quarterly Listing Mail','My Enquiry Reply Mail','Web Enquiry Mail-CTL P','Web Enquiry Mail-CTL F','Additional Information by Buyer','Web Enquiry Mail-DIR-P','My New Registration Mail','Web Enquiry Mail-FCP','Alternative Email-id at IndiaMART','Web Enquiry Mail-FCP F CC','FCP SMS Enquiry Mail','Web Enquiry Mail-ETO F','Web Enquiry Mail-CTL P CC','Web Enquiry Mail - FCP QAS','New Freelisting Mail','Forgot Password Mail-FCP','Web Enquiry Mail - HELLOTD QAS');

$catlist_ofrid=array('AllDailyBLA'=>'1','Morning > 0 and LP<> F'=>'1','Morning > 0 and LP=F'=>'1','Evening > 0 and LP<>F'=>'1','Evening > 0 and LP=F'=>'1','Once in Two Days Credit = 0 or NULL and LP <>F' =>'1','Once in Two Days Credit = 0 or NULL and LP=F'=>'1','Once Daily Morning LP <> F But 10+ Foreign Purchased'=>'1','EMorning > 0 and LP<> F'=>'1','LEvening > 0 and LP<>F'=>'1','Instant BL Alerts'=>'1','Product Preference Alerts'=>'1','BL CREDITS ALLOCATION - INDIAMART TRIAL'=>'1','IndiaMART Trial Reminder - IndiaMART Trial'=>'1','BL Alert- Instant with Credits'=>'1','BL Alert- Instant without Credits'=>'1','BL Alert- Early Morning'=>'1','BL Alert- Morning'=>'1','BL Alert- Evening'=>'1','BL Alert- Late Evening'=>'1','BL Alert- ITO'=>'1','IMA- Instant without Credits'=>'1','IMA- Instant with Credits'=>'1','IMA- Late Evening'=>'1','IMA- Morning'=>'1','IMA- Early Morning'=>'1','ITO- Instant without Credits'=>'1','ITO- Instant with Credits'=>'1','ITO- Late Evening'=>'1','ITO- Morning'=>'1','ITO- Early Morning'=>'1');
				
// 		$rec = pg_fetch_array($sth);
// 		print_r($rec);die;

$arr = pg_fetch_all($sth);
 			
if(empty($arr))
{
$size=0;
}
else
{
$size= sizeof($arr);
}
// 		
		while(($rec = pg_fetch_array($sth))!= false)
		{
		    
		    
		         $email=$rec['mail_recv_mailid'];
			 $timestamp=$rec['iil_mail_event_date1'];
			 $category=$rec['mail_category'];
			 $event=$rec['fk_mail_type_id'];
			 $url=$rec['iil_mail_event_url'];
			 $reason=$rec['mail_bounce_reason'];
			 $status=$rec['mail_bounce_code'];
			 $opendate=$rec['mail_first_open_date'];
			 $clicdate=$rec['mail_last_click_date'];
			 $bouncedate=$rec['mail_bounce_date'];
			 $spamdate=$rec['mail_spam_date'];
			 $unsubscribe=$rec['mail_unsubscribe_date'];
			 $type='';
			 $gluser_id='';
			 $gluser_id=$rec['mail_recv_glid'];
			 $subcat='';
			 $sent_date=$rec['mail_sent_date'];
			 $val=0;
			 $col=0;
			 $sent_date_new='';
			 $sent_date_new=$sent_date;
			 $sent_date_new = date("d-m-Y",strtotime($sent_date_new));
			
			 $mailsent_sql="select count(Distinct mail_uid) as mail_sent_to_user from IIL_MAIL_LOG_J1 where mail_recv_glid=".$gluser_id." and 
					  MAIL_SENT_DATE= to_date('".$sent_date_new."','dd-mm-yyyy')
					  group by mail_recv_glid";
					  
				
			 $mailsent_user='';
			 if($gluser_id && $sent_date_new)
			 {
			  if($mailsent_user1= pg_query($dbhpg, $mailsent_sql))
			   {$mailsent_user2=pg_fetch_array($mailsent_user1);
		            $mailsent_user=$mailsent_user2['mail_sent_to_user'];
		            }
		         }
		        if($event_search == 'ALL')
			  {
			  $val=1;
			  }
			  
			if($event_search == 'click')
			{
			$val=2;
			}
			if($event_search == 'bounce')
			{
			$val=3;
			}
			if($event_search == 'dropped')
			{
			$val=4;
			}
			$offerid=0;
			
				if(isset($catlist_ofrid["$category_search"]) && isset($url) && $catlist_ofrid["$category_search"] == '1')
				{
				$urlsplit=preg_split('/&/',$url);
				$urlsplit=preg_split('/mailpurchased.mp\?offer=/',$url);
				$offerid=$urlsplit[1];
				if($offerid)
				{
				$offerid  = urldecode($offerid);
				}
				if($offerid)
				{
				$offerid = $this->get_decryptedID($offerid);
				}
			        }
			        
				$handle=preg_split('/\@/',$email);
				
				if(preg_match( "/^[^_0-9a-zA-Z]/", $handle[0]))
				{
				$handle[0]='"'.$handle[0];
				$email=$handle[0].'@'.$handle[1].'"';
				}
				
				if($row==0)
			        {
				$col=0;
                                $var1='';
 				if($val == 1 || $val ==2)
 				{

                                $var1.='EMAIL,GLUSERID,CATEGORY,MAIL SENT DATE,OPEN DATE,CLICK DATE,BOUNCE DATE,SPAM DATE,UNSUBSCRIBE DATE';
				}
				else{
				$var1.='EMAIL,GLUSERID,CATEGORY,MAIL SENT DATE,OPEN DATE,CLICK DATE,BOUNCE DATE,SPAM DATE,UNSUBSCRIBE DATE';
				}
				

// 				$ecnt=200;
// 				$scnt=1;
// 				if($cnt==0)
// 				{
// 				$scnt=0;
// 				}
// 				if($cnt<200)
// 				{
// 				$ecnt=$cnt;
// 				}
				
				if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
	{
	$fp='';
	}
	else
	{
	fwrite($fp,"$var1\n");
	}
				
				
				
				
// 				fwrite($fp,"$var1\n");
				$row++;
				$str.='<html><body>';
				
				
				$str.='<div><br>';
				$str.='<div id="link_top" align="center" style="font-size:12px;display:block;font-family:arial;padding-bottom:10px;"><b>Displaying '.$size.' Records Found.</b></div>
				<table align="center" class="report_table" border="1" width="1250" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
				<tr bgcolor="#E1EDFA">
				<td width="210"><b>Email ID</b></td>
				<td width="75"><b>GLUSERID</b></td>
				<td width="130"><b>CATEGORY</b></td>
				<td width="200"><b>Mail Sent Date</b></td>
				<td width="70"><b>Open Date</b></td>
				<td width="80"><b>Click Date</b></td>
				<td width="80"><b>Bounce Date</b></td>
				<td width="80"><b>Spam Date</b></td>
				<td width="80"><b>Unsubscribe Date</b></td>
				';

			      }
			$var2='';      
			$col=0;

			$var2.="$email,$gluser_id,$category,$sent_date,$opendate,$clicdate,$bouncedate,$spamdate,$unsubscribe";
			
			
			if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
	{
	$fp='';
	}
	else
	{
	fwrite($fp,"$var2\n");
	}
			
// 			fwrite($fp,"$var2\n");
			if($row<200)
			{
			$email=preg_replace('/"/','',$email);
			$str.='<tr><td>';
			if($email)
			{
			$str.='<span style="font-size: 12px; color:#0000ff;text-decoration:underline; cursor: pointer;"   onclick="window.open(\'/index.php?r=admin_bl/Email/Index/glusremail/'.$email.'/popup/popup\',\'rem\',\'toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=971,height=500\');">'.$email.'</span>';
			}
			$str.='</td>';
			$str.='<td>';
			if($gluser_id)
			{
			$str.=''.$gluser_id.'';
			}
			$str.='</td>';
// 			$str.='<td>';
// 			if($timestamp){
// 			$str.='<div style="width:100px">'.$timestamp.'
// 			</div>';}
// 			$str.='</td>';
			$str.='<td>';
			if($category)
			{
			$str.=''.$category.'';
			}
			$str.='	</td>';
			$str.='<td>';
			
			if($sent_date)
			{
			$str.=''.$sent_date.'';
			}
			$str.='</td>';
			$str.='<td>';
			if($opendate)
			{
			$str.=''.$opendate.'';
			}
			$str.='</td>';
                       
                        $str.='<td>';
			if($clicdate)
			{
			$str.=''.$clicdate.'';
			}
			$str.='</td>';

                       $str.='<td>';
			if($bouncedate)
			{
			$str.=''.$bouncedate.'';
			}
			$str.='</td>';
			
			 $str.='<td>';
			if($spamdate)
			{
			$str.=''.$spamdate.'';
			}
			$str.='</td>';
			
			 $str.='<td>';
			if($unsubscribe)
			{
			$str.=''.$unsubscribe.'';
			}
			$str.='</td>';
                          
			}
			$row++;
		}
		if($row)
		{
		 $str.='</table></div><br><br><div align="center"><A HREF="/email-notification/'.$filename.'" style="font-family:arial;font-size:16px;font-weight:bold">CLICK HERE TO DOWNLOAD ALL RECORDS</A></div><br><br></body></html>';
		}
		else
		{ 
		 $str.='<br><div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
		}
		
		
	}
	if(isset($_REQUEST['popup']))
	{
		$glusremail=$_REQUEST['glusremail'];
		$glusremail= preg_replace('"','',$glusremail);
		$glusremail=preg_replace('^\s+','',$glusremail);
		$glusremail=preg_replace('\s+$','',$glusremail);
		

                  
	        $glusrid='';
	        $company='';
	        $city='';
	        $state='';
	        $country='';
	        $ph_country='';
	        $ph_area='';
	        $ph_no='';
	        $mobile='';
	        $address='';
	        $fax_country='';
	        $fax_area='';
	        $fax_no='';
	        
	        if($ph_country)
	        {
	        $phone = "($ph_country)";
	        }
	        
	        if($ph_area)
		{
			$phone .="-($ph_area)"; 
		}
	        if($ph_no)
	        {
	        $phone .="-$ph_no"; 
	        }
	        
	        if($fax_country)
	        {
	        $fax = "($fax_country)";
	        }
	        if($fax_area)
		{
			$fax .="-($fax_area)"; 
		}
		if($fax_no){
		$fax .="-$fax_no";
		}
		$str.='<TABLE BORDER="0" WIDTH="100%"><TR>
		<TD width="98%" align="left" STYLE="font-family:arial;font-size:13px;padding:5px;">
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">
		Complete Contact Details for Gluser:';
		
		if($glusrid)
		{
		$str.=''.$glusrid.'';
		}
	        $str.='</DIV>';
	        if($company)
		{
	        $str.='<div><B>Company:</B> '.$company.'</div>';
	        }
	        if($name)
		{
		$str.='<div><B>Name:</B> '.$name.'</div>';
		}
		if($address)
		{
			$str.='<div><B>Address:</B> '.$address.'</div>';
		}
		if($city)
		{
			$str.='<div><B>City:</B> '.$city.'</div>';
		}
		if($state)
		{
			$str.='<div><B>State:</B> '.$state.'</div>';
		}
		if($country)
		{
		$str.='<div><B>Country:</B> '.$country.'</div>';
		}
		if($ph_no)
		{
			$str.='<div><B>Telephone:</B> '.$phone.'</div>';
		}
		
		if($fax_no)
		{
			$str.='<div><B>Fax:</B> '.$fax.'</div>';
		}
		if($mobile)
		{
			$mobile ="($ph_country)-$mobile";
			$str.='<div><B>Mobile / Cell Phone:</B> '.$mobile.'</div>';
		}
	        $str.='<div><B>Email:</B>'.$glusremail.'</div></td><tr></table><DIV><BR></DIV><DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">All Email Activities Of This Gluser</DIV>';
	        
	        $styletd='style="font-family:arial;font-size:12px;padding:3px 0 3px 5px;"';
	       $sql="SELECT MAIL_RECV_MAILID,MAIL_CATEGORY,FK_MAIL_TYPE_ID,NULL IIL_MAIL_EVENT_URL,
				TO_CHAR(MAIL_REQUEST_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,MAIL_RECV_GLID,MAIL_REQUEST_DATE,
				MAIL_BOUNCE_CODE,MAIL_BOUNCE_REASON,
				MAIL_SENT_DATE,MAIL_FIRST_OPEN_DATE,
                              MAIL_LAST_CLICK_DATE,
                              MAIL_BOUNCE_DATE,
                              MAIL_SPAM_DATE,
                              MAIL_UNSUBSCRIBE_DATE
				FROM IIL_MAIL_LOG_J1 WHERE MAIL_RECV_MAILID='$glusremail'
				ORDER BY IIL_MAIL_EVENT_DATE1 DESC limit 5000";
				
				
				
			
	         $sth= @pg_query($dbhpg, $sql);
	         
	         if(!$sth)
		 {
		  $e=oci_error($dbhpg);
		  $errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
		 }
		 
		 
		 
		 $str.='<div><table align="center" class="report_table" border="1" width="1210" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
			<tr bgcolor="#E1EDFA">
			<td width="210" '.$styletd.'><b>Email ID</b></td>
			<td width="75" '.$styletd.'><b>GLUSERID</b></td>
			<td width="130" '.$styletd.'><b>CATEGORY</b></td>
			<td width="200" '.$styletd.'><b>Mail Sent Date</b></td>
			<td width="70" '.$styletd.'><b>Open Date</b></td>
			<td width="80" '.$styletd.'><b>Click Date</b></td>
			<td width="155" '.$styletd.'><b>Bounce Date</b></td>
			<td width="120" '.$styletd.'><b>Spam Date</b></td>
			<td width="90" '.$styletd.'><b>Unsubscribe Date</b></td>
			</tr>';
			
		while($rec = pg_fetch_array($sth))
		{
		 $email=$rec['mail_recv_mailid'];
		 $timestamp=$rec['iil_mail_event_date1'];
		 $category=$rec['mail_category'];
		 $event=$rec['fk_mail_type_id'];
		 $url=$rec['iil_mail_event_url'];
		 $reason=$rec['mail_bounce_reason'];
		 $status=$rec['mail_bounce_code'];
		$opendate=$rec['mail_first_open_date'];
		$clicdate=$rec['mail_last_click_date'];
		$bouncedate=$rec['mail_bounce_date'];
		$spamdate=$rec['mail_spam_date'];
		$unsubscribe=$rec['mail_unsubscribe_date'];
		 $type='';
		 $gluser_id=$rec['mail_recv_glid'];
		 $subcat='';
		 $sent_date=$rec['mail_sent_date'];
		 $str.='<tr><td '.$styletd.'>'.$email.'</td>';
				$str.='<td '.$styletd.'>';
				if($gluser_id){
				$str.=''.$gluser_id.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($category){
				$str.='<div style="width:100px">'.$category.'</div>';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($sent_date)
				{
				$str.=''.$sent_date.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($opendate){
				$str.=''.$opendate.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($clicdate){
				$str.=''.$clicdate.'';
				}
				$str.='</td>
				<td '.$styletd.'>';
				if($bouncedate){
				$str.=''.$bouncedate.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($spamdate){
				$str.=''.$spamdate.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($unsubscribe){
				$str.=''.$unsubscribe.'';
				}
				$str.='</td></tr> ';
			}
			$str.='</table></div>';
		}
	        
	if($bouncereport==1)
	{
	   $sql="SELECT MAIL_RECV_MAILID,COUNT(FK_MAIL_TYPE_ID) CNTTBOUN,COUNT(DISTINCT(MAIL_REQUEST_DATE)) CNTDISDATBOUN 
		FROM 
		(
		SELECT * FROM IIL_MAIL_LOG_J1 WHERE MAIL_BOUNCE_FLAG=1
		) IIL_LOG
		GROUP BY MAIL_RECV_MAILID ORDER BY MAIL_RECV_MAILID";
		
	
		
		   $sth= pg_query($dbhpg, $sql);
		  if(!$sth)
		 {
		  $e=pg_last_error();
		  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Postgresql", "Cant execute  the query on Postgresql",$e, 1);
	        
		 }
		 
		 $time=time();
		 $filename="email-bounce-report-".$time.".xls";
		 $path=$_SERVER['DOCUMENT_ROOT']."/email-notification/";
		 $Excelfile =$path.$filename; 
	        $sql1="SELECT COUNT(MAIL_RECV_MAILID) CNT FROM
			(SELECT * FROM IIL_MAIL_LOG_J1 WHERE MAIL_BOUNCE_FLAG=1
			) IIL_LOG";
			 $sth1= pg_query($dbhpg, $sql1);
		  if(!$sth1)
		 {
		  $e=pg_last_error();
		  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Postgresql", "Cant execute  the query on Postgresql",$e, 1);
	        
		 }
		
		 $rec2=pg_fetch_array($sth1);
		 $cnt=$rec2['cnt'];
	
                $fp = fopen($Excelfile, 'w');
		$row=0;
		
		while($rec = pg_fetch_assoc($sth))
		{
		   
		  $email=$rec['mail_recv_mailid'];
		  $cnttboun=$rec['cnttboun'];
		  $cntdisdatboun=$rec['cntdisdatboun'];			
		  $col=0;
		  $offerid=0;
		  $handle=preg_split('/\@/',$email);			
			if(preg_match("/^[^_0-9a-zA-Z]/",$handle[0]))
			{
				$handle[0]='"'.$handle[0];
				$email=$handle[0].'@'.$handle[1].'"';
			}			
			if($row==0)
			{
			        $var3='';
				$col=0;
			        $var3.='EMAIL,Total Entry of Bounce,Count of Distinct Date';
			        $ecnt=200;
				$scnt=1;
				if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
	{
	$fp='';
	}
	else
	{
	fwrite($fp,"$var3\n");
	}
				
				
// 				fwrite($fp,"$var3\n");
				if($cnt==0)
				{
				$scnt=0;
				}
				if($cnt<200)
				{
				$ecnt=$cnt;
				}
				$row++;
				
				$str.='<div><br>';
				
				$str.='<div id="link_top" align="center" style="font-size:12px;display:block;font-family:arial;padding-bottom:10px;"><b>Displaying '.$scnt.'-'.$ecnt.' of Total '.$cnt.' Records Found.</b></div><table align="center" class="report_table" border="1" width="600" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
				<tr bgcolor="#E1EDFA">
				<td width="400"><b>Email ID</b></td>			
				<td width="100"><b>Total Entry of Bounce</b></td>
				<td width="100"><b>Count of Distinct Date</b></td>';
				
				}
			$var4='';	
			$col=0;
			$var4.="$email,$cnttboun,$cntdisdatboun";
			
// 			fwrite($fp,"$var4\n");

if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
	{
	$fp='';
	}
	else
	{
	fwrite($fp,"$var4\n");
	}


			if($row<200)
			{
			   preg_replace('"','',$email);
			   $str.='<tr><td>';
			   if($email){
			   $str.='<span style="font-size: 12px; color:#0000ff;text-decoration:underline; cursor: pointer;"   onclick="window.open(\'index.php?r=admin_bl/Email/Index/glusremail/'.$email.'/popup/popup/\',\'rem\',\'toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=971,height=500\');">'.$email.'</span>';
			   }	
			   $str.='</td>';
			   $str.='<td>';
			   $str.=''.$cnttboun.'';
			   $str.='</td>';
			   $str.='<td>';
			   $str.=''.$cntdisdatboun.'';
			   $str.='</td>';
			   
			   }
		$row++;
		}
		
		if($row)
		{
			 $str.='</table></div><br><br><div align="center"><A HREF="/email-notification/'.$filename.'" style="font-family:arial;font-size:16px;font-weight:bold">CLICK HERE TO DOWNLOAD ALL RECORDS</A></div><br><br></body></html>';
		}
		else
		{
			 $str.='<br><div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
		}
	}
	
	if($bouncereport==2)
	{
	   $sqlcnt="SELECT COUNT(DISTINCT MAIL_BOUNCE_CODE) CNT 
			FROM
			(
			SELECT * FROM IIL_MAIL_LOG_J1 WHERE MAIL_BOUNCE_CODE IS NOT NULL AND MAIL_BOUNCE_FLAG=1
			) IIL_LOG";
	
	         $sthcnt=pg_query($dbhpg, $sqlcnt);	
		 //oci_execute($sthcnt);
		 $cnt1=pg_fetch_assoc($sthcnt);
		 $sql1="SELECT BOUNCESTATUS,BOUNCEREASON FROM
			(
			SELECT MAIL_BOUNCE_CODE BOUNCESTATUS,MAIL_BOUNCE_REASON BOUNCEREASON,ROW_NUMBER()OVER(PARTITION BY MAIL_BOUNCE_CODE 
			ORDER BY 1)RN FROM IIL_MAIL_LOG_J1 WHERE MAIL_BOUNCE_CODE IS NOT NULL 
			AND MAIL_BOUNCE_REASON IS NOT NULL AND MAIL_BOUNCE_FLAG=1
			) IIL_LOG WHERE  RN=1 order by BOUNCESTATUS";
		$sth1=pg_query($dbhpg, $sql1);	
		if(!$sth1)
		 {
		  $e=pg_last_error();
		  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Postgresql", "Cant execute  the query on Postgresql",$e, 1);
	        
		 }
	
// 		oci_execute($sth1);
		$cnt=0;
		 while($rec=pg_fetch_assoc($sth1))
		 {
		  
		  $bouncestatus=$rec1['bouncestatus'];
		  $bouncereason=$rec1['bouncereason'];
		  $hash[$cnt++]=$bouncereason;
		  $hash[$cnt++]=$bouncestatus;
		  
		 }
		 $sql="SELECT MAIL_BOUNCE_CODE BOUNCESTATUS,COUNT(MAIL_BOUNCE_CODE) CNTBOUNCESTATUS,
			(SELECT COUNT(MAIL_BOUNCE_CODE) FROM 
			(SELECT * FROM IIL_MAIL_LOG_J1 
			WHERE MAIL_BOUNCE_CODE IS NOT NULL
			) IIL_LOG1) TCNTBOUNCESTATUS
			FROM 
			(
			SELECT * FROM IIL_MAIL_LOG_J1 
			WHERE MAIL_BOUNCE_CODE IS NOT NULL 
			AND MAIL_BOUNCE_FLAG=1 
			) IIL_LOG
			GROUP BY MAIL_BOUNCE_CODE
			ORDER BY MAIL_BOUNCE_CODE";
			
			$sth=pg_query($dbhpg, $sql);
			
		if(!$sth)
		 {
		  $e=pg_last_error();
		  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Postgresql", "Cant execute  the query on Postgresql",$e, 1);
	        
		 }
	

	       $time=time();
	       $filename="email-unique-bounce-report-".$time.".xls";
	       $path=$_SERVER['DOCUMENT_ROOT']."/email-notification/";
	       $Excelfile =$path.$filename; 

                  $fp = fopen($Excelfile, 'w');

		$row=0;
		$cntcheck=$cnt;
		
		$cnt=0;
		while($rec = pg_fetch_assoc($sth))
		{
	          $bouncestatus=$rec['bouncestatus'];
		  $cntbouncestatus=$rec['cntbouncestatus'];
		  $tcntbouncestatus=$rec['tcntbouncestatus'];
		  $tcntbouncestatus = sprintf("%.0f",($cntbouncestatus/$tcntbouncestatus)*100);
		  $col=0;
		  if($row==0)
			{
			        $var5='';
				$col=0;

				$var5.="BOUNCESTATUS,BOUNCEREASON,REPEATING NUMBER OF TIME,PERCENTAGE BOUNCESTATUS";
				$row++;
				 $ecnt=200;
				 $scnt=1;
				 if($cnt1==0){
				$scnt=0;
				}
				if($cnt1<200){
				$ecnt=$cnt1;
	                        }
	                        fwrite($fp,"$var5\n");
	                        $str.='<div><br>';
	                        $str.='<div id="link_top" align="center" style="font-size:12px;display:block;font-family:arial;padding-bottom:10px;"><b>Displaying '.$scnt.'-'.$ecnt.' of Total '.$cnt1.' Records Found.</b></div>
				<table align="center" class="report_table" border="1" width="750" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
				<tr bgcolor="#E1EDFA">
				<td width="100"><b>BOUNCE STATUS</b></td>
				<td width="450"><b>BOUNCE REASON</b></td>
				<td width="100"><b>REPEATING NUMBER OF TIME</b></td>
				<td width="100"><b>PERCENTAGE BOUNCESTATUS</b></td>';
				
				}
				$var6='';
			$col=0;
// 			$worksheet->write($row,$col++,$bouncestatus);
			$var6.="$bouncestatus";
			 $checkcnt=1;
			 $checkflag=1;
			while($checkcnt<$cntcheck)
			{
			if($hash[$checkcnt] == $bouncestatus)
			{
// 	                        $worksheet->write($row,$col++,$hash[$checkcnt-1]);
                                $var6.=",";
	                        $var6.=$hash[$checkcnt-1];
	                        break;
			$checkflag=0;
			}
			$checkcnt+=2;
			}
			if($checkflag)
			{
// 			$worksheet->write($row,$col++,'');
			 $var6.=",";
			}
// 			$worksheet->write($row,$col++,$cntbouncestatus);
			$var6.=",$cntbouncestatus";
// 			$worksheet->write($row,$col++,$tcntbouncestatus);
			$var6.=",$tcntbouncestatus";
			fwrite($fp,"$var6\n");
			if($row<200)
			{
			  $str.='<tr><td>';
			  $str.=''.$bouncestatus.'';
			  $str.='</td>';
			  $str.='<td>';
			  if($hash[$checkcnt-1] && $checkflag){
			  $str.=''.$hash[$checkcnt-1].'';
			  }
			 $str.='</td>';
			  $str.='<td>';
			  $str.=''.$cntbouncestatus.'';
				$str.='</td>';
				$str.='<td>';
				$str.=''.$tcntbouncestatus.'';
				$str.='</td>';
			}
		$row++;
		$cnt+=2;
		}
		if($row)
		{
			$str.='</table></div><br><br><div align="center"><A HREF="/email-notification/'.$filename.'" style="font-family:arial;font-size:16px;font-weight:bold">CLICK HERE TO DOWNLOAD ALL RECORDS</A></div><br><br></body></html>';
		}
		else
		{
			$str.='<br><div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
		}
	}

}
   return $str;
}
public function new_call2($dbhpg,$glusremail)
{

// 		$glusremail=$_REQUEST['glusremail'];
// 		$glusremail= preg_replace('"','',$glusremail);
// 		$glusremail=preg_replace('^\s+','',$glusremail);
// 		$glusremail=preg_replace('\s+$','',$glusremail);
// 		
                $str1='';
// 		$sql="SELECT
// 		TRIM(TRIM(GLUSR_USR.GLUSR_USR_FIRSTNAME)||' '||TRIM(GLUSR_USR.GLUSR_USR_LASTNAME)) FULLNAME,
// 		GLUSR_USR_ID,
// 		GLUSR_USR_COMPANYNAME,
// 		GLUSR_USR_CITY,
// 		GLUSR_USR_STATE,
// 		GLUSR_USR_COUNTRYNAME,
// 		GLUSR_USR_PH_COUNTRY,
// 		GLUSR_USR_PH_AREA,
// 		GLUSR_USR_PH_NUMBER,
// 		GLUSR_USR_PH_MOBILE,
// 		GLUSR_USR_ADD1,
// 		GLUSR_USR_FAX_COUNTRY,
// 		GLUSR_USR_FAX_AREA,
// 		GLUSR_USR_FAX_NUMBER
// 		FROM 
// 		GLUSR_USR
// 		WHERE GLUSR_USR_EMAIL=:EMAIL";
// 		
// 		$sth= oci_parse($dbh1, $sql);
// 		 oci_bind_by_name($sth, ':EMAIL', $glusremail);
// 		 oci_execute($sth);
// 		 $arr1=oci_fetch_array($sth);
		$name= '';
                  
	        $glusrid='';
	        $company='';
	        $city='';
	        $state='';
	        $country='';
	        $ph_country='';
	        $ph_area='';
	        $ph_no='';
	        $mobile='';
	        $address='';
	        $fax_country='';
	        $fax_area='';
	        $fax_no='';
	        
	        if($ph_country)
	        {
	        $phone = "($ph_country)";
	        }
	        
	        if($ph_area)
		{
			$phone .="-($ph_area)"; 
		}
	        if($ph_no)
	        {
	        $phone .="-$ph_no"; 
	        }
	        
	        if($fax_country)
	        {
	        $fax = "($fax_country)";
	        }
	        if($fax_area)
		{
			$fax .="-($fax_area)"; 
		}
		if($fax_no){
		$fax .="-$fax_no";
		}
		$str1.='<TABLE BORDER="0" WIDTH="100%"><TR>
		<TD width="98%" align="left" STYLE="font-family:arial;font-size:13px;padding:5px;">
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">
		Complete Contact Details for Gluser:';
		
		if($glusrid)
		{
		$str1.=''.$glusrid.'';
		}
	        $str1.='</DIV>';
	        if($company)
		{
	        $str1.='<div><B>Company:</B> '.$company.'</div>';
	        }
	        if($name)
		{
		$str1.='<div><B>Name:</B> '.$name.'</div>';
		}
		if($address)
		{
			$str1.='<div><B>Address:</B> '.$address.'</div>';
		}
		if($city)
		{
			$str1.='<div><B>City:</B> '.$city.'</div>';
		}
		if($state)
		{
			$str1.='<div><B>State:</B> '.$state.'</div>';
		}
		if($country)
		{
		$str1.='<div><B>Country:</B> '.$country.'</div>';
		}
		if($ph_no)
		{
			$str1.='<div><B>Telephone:</B> '.$phone.'</div>';
		}
		
		if($fax_no)
		{
			$str1.='<div><B>Fax:</B> '.$fax.'</div>';
		}
		if($mobile)
		{
			$mobile ="($ph_country)-$mobile";
			$str1.='<div><B>Mobile / Cell Phone:</B> '.$mobile.'</div>';
		}
	        $str1.='<div><B>Email:</B>'.$glusremail.'</div></td><tr></table><DIV><BR></DIV><DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">All Email Activities Of This Gluser</DIV>';
	        
	        $styletd='style="font-family:arial;font-size:12px;padding:3px 0 3px 5px;"';
	        $sql="SELECT MAIL_RECV_MAILID,MAIL_CATEGORY,FK_MAIL_TYPE_ID,NULL IIL_MAIL_EVENT_URL,
				TO_CHAR(MAIL_REQUEST_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,MAIL_RECV_GLID,MAIL_REQUEST_DATE,
				MAIL_BOUNCE_CODE,MAIL_BOUNCE_REASON,
				MAIL_SENT_DATE,MAIL_FIRST_OPEN_DATE,
                              MAIL_LAST_CLICK_DATE,
                              MAIL_BOUNCE_DATE,
                              MAIL_SPAM_DATE,
                              MAIL_UNSUBSCRIBE_DATE
				FROM IIL_MAIL_LOG_J1 WHERE MAIL_RECV_MAILID='$glusremail'
				ORDER BY IIL_MAIL_EVENT_DATE1 DESC";
				
				
	         $sth= @pg_query($dbhpg, $sql);
		 $str1.='<div><table align="center" class="report_table" border="1" width="1210" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
			<tr bgcolor="#E1EDFA">
			<td width="210" '.$styletd.'><b>Email ID</b></td>
			<td width="75" '.$styletd.'><b>GLUSERID</b></td>
			<td width="130" '.$styletd.'><b>CATEGORY</b></td>
			<td width="200" '.$styletd.'><b>Mail Sent Date</b></td>
			<td width="70" '.$styletd.'><b>Open Date</b></td>
			<td width="80" '.$styletd.'><b>Click Date</b></td>
			<td width="155" '.$styletd.'><b>Bounce Date</b></td>
			<td width="120" '.$styletd.'><b>Spam Date</b></td>
			<td width="90" '.$styletd.'><b>Unsubscribe Date</b></td>
			</tr>';
			
		while($rec = pg_fetch_array($sth))
		{
		 $email=$rec['mail_recv_mailid'];
		 $timestamp=$rec['iil_mail_event_date1'];
		 $category=$rec['mail_category'];
		 $event=$rec['fk_mail_type_id'];
		 $url=$rec['iil_mail_event_url'];
		 $reason=$rec['mail_bounce_reason'];
		 $status=$rec['mail_bounce_code'];
		$opendate=$rec['mail_first_open_date'];
		$clicdate=$rec['mail_last_click_date'];
		$bouncedate=$rec['mail_bounce_date'];
		$spamdate=$rec['mail_spam_date'];
		$unsubscribe=$rec['mail_unsubscribe_date'];
		 $type='';
		 $gluser_id=$rec['mail_recv_glid'];
		 $subcat='';
		 $sent_date=$rec['mail_sent_date'];
		  $str1.='<tr><td '.$styletd.'>'.$email.'</td>';
				$str1.='<td '.$styletd.'>';
				if($gluser_id){
				$str1.=''.$gluser_id.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($category){
				$str1.='<div style="width:100px">'.$category.'</div>';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($sent_date)
				{
				$str1.=''.$sent_date.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($opendate){
				$str1.=''.$opendate.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($clicdate){
				$str1.=''.$clicdate.'';
				}
				$str1.='</td>
				<td '.$styletd.'>';
				if($bouncedate){
				$str1.=''.$bouncedate.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($spamdate){
				$str1.=''.$spamdate.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($unsubscribe){
				$str1.=''.$unsubscribe.'';
				}
				$str1.='</td></tr> ';
			}
			$str1.='</table></div>';
return $str1;
}

function get_decryptedID($orig_string)
        {
            $orig_string = base64_decode($orig_string);
            $key = '1996c39iil';
            $s = array();
            for ($i = 0; $i < 256; $i++)
            {
                $s[$i] = $i;
            }
            $j = 0;
            for ($i = 0; $i < 256; $i++)
            {
                $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
                $x = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $x;
            }
            $i = 0;
            $j = 0;
            $res = '';
            for ($y = 0; $y < strlen($orig_string); $y++)
            {
                $i = ($i + 1) % 256;
                $j = ($j + $s[$i]) % 256;
                $x = $s[$i];
                $s[$i] = $s[$j];
                $s[$j] = $x;
                $res .= $orig_string[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
            }
            return $res;
        }
}

?>
	                        
	                        
	                        
	                        
	                       
	