<?php
// require_once 'Spreadsheet/Excel/Writer.php';
class Emailnotificationnew extends CFormModel
{
   
   public function call1($dbh,$dbh1,$res1,$email_search,$bouncereport,$event_search,$category_search1,$category_search,$dbhpg)
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
	     
// 	   $startdate=$_REQUEST['sdate_day'].'-'.$_REQUEST['sdate_month'].'-'.$_REQUEST['sdate_year'];
// 	   $enddate=$_REQUEST['edate_day'].'-'.$_REQUEST['edate_month'].'-'.$_REQUEST['edate_year'];   
	   
	 if(isset($_REQUEST['Submit']))
	 {
            $startdate=$sdate_day.'-'.$sdate_month.'-'.$sdate_year;
	    $enddate=$edate_day.'-'.$edate_month.'-'.$edate_year;
	    $minusenddate=1;
	    $condition='';
	    
	    
                     
            $sqlmailarchived="SELECT /*+INDEX(IIL_MAIL_EVENTS_ARCHIVED IIL_MAIL_EVENTSARCHIVEN_INDX)*/IIL_MAIL_EVENT_MAILID,
                              IIL_MAIL_EVENT_CATEGORY,
                              IIL_MAIL_EVENT_TYPE,
                              IIL_MAIL_EVENT_URL,
                              IIL_MAIL_EVENT_DATE,
                              TO_CHAR(IIL_MAIL_EVENT_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,
                              IIL_MAIL_EVENT_BOUNCEREASON,
                              IIL_MAIL_EVENT_BOUNCESTATUS,
                              IIL_MAIL_EVENT_GLUSER_ID,
                              IIL_MAIL_EVENT_SENT_DATE
                              FROM IIL_MAIL_EVENTS_ARCHIVED
                              WHERE TRUNC(IIL_MAIL_EVENT_DATE) >= to_date(:STDATE,'dd-mm-yyyy')
                              AND TRUNC(IIL_MAIL_EVENT_DATE)   <= to_date(:EDDATE,'dd-mm-yyyy')";
                              
            $sqlmailinterim="SELECT /*+index(IIL_MAIL_EVENTS_INTERIM IIL_MAILN_EVENTS_INT_INDX)*/IIL_MAIL_EVENT_MAILID,
				IIL_MAIL_EVENT_CATEGORY,
				IIL_MAIL_EVENT_TYPE,
				IIL_MAIL_EVENT_URL,
				IIL_MAIL_EVENT_DATE,
				TO_CHAR(IIL_MAIL_EVENT_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,
				IIL_MAIL_EVENT_BOUNCEREASON,
				IIL_MAIL_EVENT_BOUNCESTATUS,
				IIL_MAIL_EVENT_GLUSER_ID,
				IIL_MAIL_EVENT_SENT_DATE
				FROM IIL_MAIL_EVENTS_INTERIM
				WHERE TRUNC(IIL_MAIL_EVENT_DATE)>= to_date(:STDATE,'dd-mm-yyyy')
				AND TRUNC(IIL_MAIL_EVENT_DATE)  <= to_date(:EDDATE,'dd-mm-yyyy')";
	        $condition='';
	    
// 	        $email_search=$_REQUEST['email_search'];
		
// 		$email_search=preg_replace('/s+/','',$email_search);
	        $email_search = preg_replace('/\s\s+/','',$email_search);
	        
	         if($category_search == 'BL Approval Mails')
	         {
	          $category_search="BL Approval Mails','Buy Leads Approval Mails";
	          
	         }
	         
	         
	         
	         if($category_search!= 'ALL' && $category_search!= 'AllDailyBLA' && $category_search!= 'User Admin Mails')
	         {
	         $condition.="and IIL_MAIL_EVENT_CATEGORY in ('$category_search')";
	         }
	         if($category_search != 'ALL' && $category_search == 'AllDailyBLA')
	         {
	         $condition.="and IIL_MAIL_EVENT_CATEGORY in ('All Daily BL Alerts','Morning > 0 and LP<> F','Morning > 0 and LP=F','Evening > 0 and LP<>F','Evening > 0 and LP=F','Once in Two Days Credit = 0 or NULL and LP <>F','Once in Two Days Credit = 0 or NULL and LP=F','Once Daily Morning LP <> F But 10+ Foreign Purchased','EMorning > 0 and LP<> F','LEvening > 0 and LP<>F','Instant BL Alerts','Product Preference Alerts','BL CREDITS ALLOCATION - INDIAMART TRIAL','IndiaMART Trial Reminder - IndiaMART Trial','BL Alert- Instant with Credits','BL Alert- Instant without Credits','BL Alert- Early Morning','BL Alert- Morning','BL Alert- Evening','BL Alert- Late Evening','BL Alert- ITO','IMA- Instant without Credits','IMA- Instant with Credits','IMA- Late Evening','IMA- Morning',
		'IMA- Early Morning','ITO- Instant without Credits','ITO- Instant with Credits','ITO- Late Evening','ITO- Morning',
		'ITO- Early Morning')";
		}
		if($category_search!= 'ALL' && $category_search == 'User Admin Mails')
		{
		  $condition .=" and IIL_MAIL_EVENT_CATEGORY='$category_search1'";
	         
	        } 
       
                if($event_search!= 'ALL')
                 {
                  $condition .=" and IIL_MAIL_EVENT_TYPE='$event_search'";
                 }
                 if($dropped_res_val_condition == 'Invalid' && $event_search == 'dropped')
                 {
                  $condition .=" and IIL_MAIL_EVENT_BOUNCEREASON='Invalid'";
                 
                 }
           
                 if($email_search)
                 {
                 $condition .=" and IIL_MAIL_EVENT_MAILID='$email_search'";
                 
                 }
                 
                
                 $sqlmailarchived .= $condition;
	         $sqlmailinterim .= $condition;
		
		 $sql = "SELECT * FROM ( $sqlmailinterim UNION ALL $sqlmailarchived ) ORDER BY IIL_MAIL_EVENT_DATE DESC";
		 
	         
	         
	        
	         
		 $sth =@oci_parse($dbh,$sql);
		 if(!$sth)
		 {
		  $e=oci_error($dbh);
		  $errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
		 }
                 oci_bind_by_name($sth, ':STDATE', $startdate);
                 oci_bind_by_name($sth, ':EDDATE', $enddate);
                 
                 $chk=@oci_execute($sth);	
			if(!$chk)
			{
			$e=oci_error($sth);
			$errorMsg = $e['message'];
				$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			
		      }

// 		 oci_execute($sth);

          
		 
		 $time=time();
		 $filename="email-event-report-".$time.".xls";
		 $path=$_SERVER['DOCUMENT_ROOT']."/email-notification/";
		 $Excelfile =$path.$filename; 

		 
                $sql1interim="select *  from IIL_MAIL_EVENTS_INTERIM where
		trunc(IIL_MAIL_EVENT_DATE)>=trunc(to_date(:STDATE,'dd-mm-yyyy'))
		and trunc(IIL_MAIL_EVENT_DATE)<=trunc(to_date(:EDDATE,'dd-mm-yyyy'))";
		
		$sql1interim .= $condition;
		$sql1interim .=" UNION ALL 
		select *  from IIL_MAIL_EVENTS_ARCHIVED where
		trunc(IIL_MAIL_EVENT_DATE)>=trunc(to_date(:STDATE,'dd-mm-yyyy'))
		and trunc(IIL_MAIL_EVENT_DATE)<=trunc(to_date(:EDDATE,'dd-mm-yyyy'))";
		$sql1interim .= $condition;
		
		$sql1 = "SELECT COUNT(*) CNT FROM ( $sql1interim  )";
		
// 		echo "$sql1";
// 		die;
		
		 $sth1 =@oci_parse($dbh,$sql1);
		 if(!$sth1)
		 {
		  $e=oci_error($dbh);
		  $errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
		 }
		
// 		$sth1= oci_parse($dbh, $sql1);
		oci_bind_by_name($sth1, ':STDATE', $startdate);
                oci_bind_by_name($sth1, ':EDDATE', $enddate);
                
                 $chk=@oci_execute($sth1);	
			if(!$chk)
			{
			$e=oci_error($sth1);
			$errorMsg = $e['message'];
				$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			
		      }

// 		oci_execute($sth1);
		
		$rec3=oci_fetch_array($sth1);
		$cnt=$rec3['CNT'];
                
		$fp = fopen($Excelfile, 'w');

// 		$excel = Spreadsheet::WriteExcel->new("$Excelfile");
// 		 $worksheet = $excel->addworksheet();
// 		$workbook = new Spreadsheet_Excel_Writer();
// 		$workbook->send($Excelfile);
// 
// 		$worksheet =& $workbook->addWorksheet();

//                 $rec = oci_fetch_assoc($sth);
              
		$row=0;
		
		 $category_list=array('Daily BL Alerts','1','All Daily BL Alerts','All Daily BL Alerts','&nbsp;&nbsp;Morning > 0 and LP<> F','Morning > 0 and LP<> F','&nbsp;&nbsp;Morning > 0 and LP=F','Morning > 0 and LP=F','&nbsp;&nbsp;Evening > 0 and LP<>F','Evening > 0 and LP<>F','&nbsp;&nbsp;Evening > 0 and LP=F','Evening > 0 and LP=F','&nbsp;&nbsp;EMorning > 0 and LP<> F','EMorning > 0 and LP<> F','&nbsp;&nbsp;LEvening > 0 and LP<>F','LEvening > 0 and LP<>F','&nbsp;&nbsp;Once in Two Days Credit = 0 or NULL and LP <>F','Once in Two Days Credit = 0 or NULL and LP <>F','&nbsp;&nbsp;Once in Two Days Credit = 0 or NULL and LP=F','Once in Two Days Credit = 0 or NULL and LP=F','&nbsp;&nbsp;Once Daily Morning LP <> F But 10+ Foreign Purchased','Once Daily Morning LP <> F But 10+ Foreign Purchased','&nbsp;&nbsp;Instant BL Alerts','Instant BL Alerts','&nbsp;&nbsp;Product Preference Alerts','Product Preference Alerts','&nbsp;&nbsp;BL CREDITS ALLOCATION - INDIAMART TRIAL','BL CREDITS ALLOCATION - INDIAMART TRIAL','&nbsp;&nbsp;IndiaMART Trial Reminder - IndiaMART Trial','IndiaMART Trial Reminder - IndiaMART Trial','&nbsp;&nbsp;BL Alert- Instant with Credits','BL Alert- Instant with Credits','&nbsp;&nbsp;BL Alert- Instant without Credits','BL Alert- Instant without Credits','&nbsp;&nbsp;BL Alert- Early Morning','BL Alert- Early Morning','&nbsp;&nbsp;BL Alert- Morning','BL Alert- Morning','&nbsp;&nbsp;BL Alert- Evening','BL Alert- Evening','&nbsp;&nbsp;BL Alert- Late Evening','BL Alert- Late Evening','&nbsp;&nbsp;BL Alert- ITO','BL Alert- ITO','&nbsp;&nbsp;IMA- Instant without Credits','IMA- Instant without Credits','&nbsp;&nbsp;IMA- Instant with Credits','IMA- Instant with Credits','&nbsp;&nbsp;IMA- Late Evening','IMA- Late Evening','&nbsp;&nbsp;IMA- Morning','IMA- Morning','&nbsp;&nbsp;IMA- Early Morning','IMA- Early Morning','&nbsp;&nbsp;ITO- Instant without Credits','ITO- Instant without Credits','&nbsp;&nbsp;ITO- Instant with Credits','ITO- Instant with Credits','&nbsp;&nbsp;ITO- Late Evening','ITO- Late Evening','&nbsp;&nbsp;ITO- Morning','ITO- Morning','&nbsp;&nbsp;ITO- Early Morning','ITO- Early Morning','&nbsp;&nbsp;BL Expiry Reminder','2','Expiry Notification','Expiry Notification','Expiry Reminder','Expiry Reminder','Buy Lead Approval Mails','3','BL Approval- India','BL Approval- India','BL Approval- India-ALT','BL Approval- India-ALT','BL Approval- Foreign','BL Approval- Foreign','BL Approval- Foreign-ALT','BL Approval- Foreign-ALT','BL Insta AstBuy- India','BL Insta AstBuy- India','BL Insta AstBuy- India-ALT','BL Insta AstBuy- India-ALT','BL Insta AstBuy- Foreign','BL Insta AstBuy- Foreign','BL Insta AstBuy- Foreign-ALT','BL Insta AstBuy- Foreign-ALT','ASSISTED BUY','4','ASTBUY Mail to Buyer','ASTBUY Mail to Buyer','ASTBUY Mail to Supplier','ASTBUY Mail to Supplier','Buy Leads Deletion','5','BL Rejection- India','BL Rejection- India','BL Rejection- India-ALT','BL Rejection- India-ALT','BL Rejection- Foreign','BL Rejection- Foreign','BL Rejection- Foreign-ALT','BL Rejection- Foreign-ALT','BL Purchase','6','BL Purchase Mail to Buyer','BL Purchase Mail to Buyer','BL Purchase Mail to Supplier','BL Purchase Mail to Supplier','BL Renewal Mails','7','Buy Leads Renewal','BuyLeadsRenewal','BL Subscription Renewal Mails','BL Subscription Renewal Mails','MISC Mails','8','BL Call Center Approval Mails','BL Call Center Approval Mails','BL Feedback Mails','BL Feedback Mails','BL Complaint Feedback Mails','BL Complaint Feedback Mails','Feedback Mails paid Enq','Feedback mail on paid enquiries','Response Mail Sent thru MY','Response Mail Sent thru MY','BL Loc Pref Mails','BL Loc Pref Mails','BL Subscription Renewal Mails','BL Subscription Renewal Mails','BL Weberp Sales Mailer','BL Weberp Sales Mailer','BL Credits Allocation Mail','BL Credits Allocation Mail','BL Weekly Offer Mail','BL Weekly Offer Mail','Failure','Failure','IIL Advantage - Credit allocation process','IIL Advantage - Credit allocation process','No Usage Reminder','No Usage Reminder','No-Usage Credits Lapse','No-Usage Credits Lapse','Feedback Mail','Feedback Mail','
Taging Mail','
Taging Mail','Performance Scorecard','Performance Scorecard','Welcome Kit','Welcome Kit','PNS defaulter','PNS defaulter','Order Confirmation','Order Confirmation','CSD Renewal Reminder','CSD Renewal Reminder','Web Enquiry Mail-IMOB M','Web Enquiry Mail-IMOB M');

$useradmin=array('--Select--','FCP New Registration Mail','Invitation to view Product Catalog','Modify Freelisting Mail','Web Enquiry Mail - IIND QAS','Newsletter','Business Inquiry from Private Buyer Catalog','Web Enquiry Mail - 2571750','Web Enquiry Mail-FCP F','Forgot Password Mail','Web Enquiry Mail-DIR-P-ISCC','Primary Email Change','Web Enquiry Mail-ETO QAS,Web Enquiry Mail-CTL QAS','Web Enquiry Mail-ETO CC','Web Enquiry Mail - TDW QAS','Web Enquiry Mail-ETO P','PURL Approved','Web Enquiry Mail-CTL F CC','Web Enquiry Mail - INE QAS','Alternate Email Change','Web Enquiry Mail - DIR QAS','PURL Denied','Change Password Mail','Web Enquiry Mail - MDC QAS','Web Enquiry Mail-DIR-F-ISCC','Web Enquiry Mail-DIR-F','Quarterly Listing Mail','My Enquiry Reply Mail','Web Enquiry Mail-CTL P','Web Enquiry Mail-CTL F','Additional Information by Buyer','Web Enquiry Mail-DIR-P','My New Registration Mail','Web Enquiry Mail-FCP','Alternative Email-id at IndiaMART','Web Enquiry Mail-FCP F CC','FCP SMS Enquiry Mail','Web Enquiry Mail-ETO F','Web Enquiry Mail-CTL P CC','Web Enquiry Mail - FCP QAS','New Freelisting Mail','Forgot Password Mail-FCP','Web Enquiry Mail - HELLOTD QAS');

$catlist_ofrid=array('AllDailyBLA'=>'1','Morning > 0 and LP<> F'=>'1','Morning > 0 and LP=F'=>'1','Evening > 0 and LP<>F'=>'1','Evening > 0 and LP=F'=>'1','Once in Two Days Credit = 0 or NULL and LP <>F' =>'1','Once in Two Days Credit = 0 or NULL and LP=F'=>'1','Once Daily Morning LP <> F But 10+ Foreign Purchased'=>'1','EMorning > 0 and LP<> F'=>'1','LEvening > 0 and LP<>F'=>'1','Instant BL Alerts'=>'1','Product Preference Alerts'=>'1','BL CREDITS ALLOCATION - INDIAMART TRIAL'=>'1','IndiaMART Trial Reminder - IndiaMART Trial'=>'1','BL Alert- Instant with Credits'=>'1','BL Alert- Instant without Credits'=>'1','BL Alert- Early Morning'=>'1','BL Alert- Morning'=>'1','BL Alert- Evening'=>'1','BL Alert- Late Evening'=>'1','BL Alert- ITO'=>'1','IMA- Instant without Credits'=>'1','IMA- Instant with Credits'=>'1','IMA- Late Evening'=>'1','IMA- Morning'=>'1','IMA- Early Morning'=>'1','ITO- Instant without Credits'=>'1','ITO- Instant with Credits'=>'1','ITO- Late Evening'=>'1','ITO- Morning'=>'1','ITO- Early Morning'=>'1');
				
		
		while(($rec = oci_fetch_assoc($sth))!= false)
		{
		
		    
		         $email=$rec['IIL_MAIL_EVENT_MAILID'];
			 $timestamp=$rec['IIL_MAIL_EVENT_DATE1'];
			 $category=$rec['IIL_MAIL_EVENT_CATEGORY'];
			 $event=$rec['IIL_MAIL_EVENT_TYPE'];
			 $url=$rec['IIL_MAIL_EVENT_URL'];
			 $reason=$rec['IIL_MAIL_EVENT_BOUNCEREASON'];
			 $status=$rec['IIL_MAIL_EVENT_BOUNCESTATUS'];
			 $type='';
			 $gluser_id=$rec['IIL_MAIL_EVENT_GLUSER_ID'];
			 $subcat='';
			 $sent_date=$rec['IIL_MAIL_EVENT_SENT_DATE'];
			 $val=0;
			 $col=0;
			 
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
// 				$worksheet->write($row,$col++,'EMAIL');
// 				$worksheet->write($row,$col++,'GLUSERID');
// 				$worksheet->write($row,$col++,'TIMESTAMP');
// 				$worksheet->write($row,$col++,'CATEGORY');
// 				$worksheet->write($row,$col++,'SUB CAT');
// 				$worksheet->write($row,$col++,'EVENT');

                                $var1='';
 				if($val == 1 || $val ==2)
 				{
// 				$worksheet->write($row,$col++,'URL');
                                $var1.='EMAIL,GLUSERID,TIMESTAMP,TIMESTAMP,CATEGORY,SUB CAT,EVENT,URL,MAIL SENT DATE';
				}
				else{
				$var1.='EMAIL,GLUSERID,TIMESTAMP,TIMESTAMP,CATEGORY,SUB CAT,EVENT,MAIL SENT DATE';
				}
// 				$worksheet->write($row,$col++,'MAIL SENT DATE');
				
				if($val == 1 || $val == 3)
				{
// 				$worksheet->write($row,$col++,'REASON');
// 				$worksheet->write($row,$col++,'STATUS');
// 				$worksheet->write($row,$col++,'TYPE');
//                                 fwrite($fp,'REASON,STATUS,TYPE');
                                $var1.=',REASON,STATUS,TYPE';

				}
				if($val == 4)
				{
// 				$worksheet->write($row,$col++,'REASON');
//                                 fwrite($fp,'REASON');
                                $var1.=',REASON';
				}
				$ecnt=200;
				$scnt=1;
				if($cnt==0)
				{
				$scnt=0;
				}
				if($cnt<200)
				{
				$ecnt=$cnt;
				}
				fwrite($fp,"$var1\n");
				$row++;
				$str.='<html><body>';
				
				
				$str.='<div><br>';
				$str.='<div id="link_top" align="center" style="font-size:12px;display:block;font-family:arial;padding-bottom:10px;"><b>Displaying '.$scnt.'-'.$ecnt.' of Total '.$cnt.' Records Found.</b></div>
				<table align="center" class="report_table" border="1" width="1250" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
				<tr bgcolor="#E1EDFA">
				<td width="210"><b>Email ID</b></td>
				<td width="75"><b>GLUSERID</b></td>
				<td width="130"><b>TIMESTAMP</b></td>
				<td width="200"><b>CATEGORY</b></td>
				<td width="70"><b>SUB CAT</b></td>
				<td width="80"><b>EVENT</b></td>';
				
				if($val == 1 || $val ==2)
				{
				$str.='<td width="155"><b>URL</b></td>';
				}
				$str.='<td width="120"><b>MAIL SENT DATE</b></td>';
				if($val == 1 || $val == 3)
				{
				$str.='<td width="90"><b>REASON</b></td>
				<td width="60"><b>STATUS</b></td>
				<td width="60"><b>TYPE</b></td>
				</tr>';
				}
				if($val == 4)
				{
				$str.='<td width="90"><b>REASON</b></td></tr>';
				}
			      }
			$var2='';      
			$col=0;
// 			$worksheet->write($row,$col++,$email);
// 			$worksheet->write($row,$col++,$gluser_id);
// 			$worksheet->write($row,$col++,$timestamp);
// 			$worksheet->write($row,$col++,$category);
// 			$worksheet->write($row,$col++,$subcat);
// 			$worksheet->write($row,$col++,$event);
			$var2.="$email,$gluser_id,$timestamp,$category,$subcat,$event";
			
			if($val == 1 || $val ==2){
// 			$worksheet->write($row,$col++,$url);
			$var2.=",$url";
			}
// 			$worksheet->write($row,$col++,$sent_date);
			$var2.=",$sent_date";
			if($val == 1 || $val == 3)
			{
// 			$worksheet->write($row,$col++,$reason);
// 			$worksheet->write($row,$col++,$status);
// 			$worksheet->write($row,$col++,$type);
			$var2.=",$reason,$status,$type";
			}
			if($val == 4)
			{
// 			$worksheet->write($row,$col++,$reason);
			$var2.=",$reason";
			}
			fwrite($fp,"$var2\n");
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
			$str.='<td>';
			if($timestamp){
			$str.='<div style="width:100px">'.$timestamp.'
			</div>';}
			$str.='</td>';
			$str.='<td>';
			if($category)
			{
			$str.=''.$category.'';
			}
			$str.='	</td>';
			$str.='<td>';
			
			if($subcat)
			{
			$str.=''.$subcat.'';
			}
			$str.='</td>';
			$str.='<td>';
			if($event)
			{
			$str.=''.$event.'';
			}
			$str.='</td>';
			if($val == 1 || $val ==2){
			$str.='<td style="font-size:11px">';
			}
			        if(isset($url) && ($val == 1 || $val ==2))
			        {
				$str.='<input type="text" title="'.$url.'" value="'.$url.'" style="border:0px;font-family:arial;font-size:11px;width:155px" readonly>';
				}
				if($offerid){
				$str.='<br><b>Offer Id: '.$offerid.'<b>';
				}
				if($val == 1 || $val ==2){
				$str.='</td>'; 
				}
				$str.='<td>';
				if($sent_date){
				$str.=''.$sent_date.'';
				}
				$str.='</td>';				
				if($val == 1 || $val == 3)
				{
				$str.='<td style="font-size:11px;">';
				if($reason){
				$str.=' '.$reason.'';
				}
				$str.='</td>';
				$str.='<td>';
				if($status){
				$str.=''.$status.'';
				}
				$str.='</td>';
				$str.='<td>';
				if($type){
				$str.=''.$type.'';
				}
				$str.='</td></tr>';
				}
				if($val == 4)
				{
				$str.='<td style="font-size:11px;">';
				if($reason){
				$str.=' '.$reason.'';
				}
				$str.='</td></tr>';
				}
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
		
		$sql="SELECT
		TRIM(TRIM(GLUSR_USR.GLUSR_USR_FIRSTNAME)||' '||TRIM(GLUSR_USR.GLUSR_USR_LASTNAME)) FULLNAME,
		GLUSR_USR_ID,
		GLUSR_USR_COMPANYNAME,
		GLUSR_USR_CITY,
		GLUSR_USR_STATE,
		GLUSR_USR_COUNTRYNAME,
		GLUSR_USR_PH_COUNTRY,
		GLUSR_USR_PH_AREA,
		GLUSR_USR_PH_NUMBER,
		GLUSR_USR_PH_MOBILE,
		GLUSR_USR_ADD1,
		GLUSR_USR_FAX_COUNTRY,
		GLUSR_USR_FAX_AREA,
		GLUSR_USR_FAX_NUMBER
		FROM 
		GLUSR_USR
		WHERE GLUSR_USR_EMAIL=:EMAIL";
		$sth= @oci_parse($dbh1, $sql);
		if(!$sth)
		 {
		  $e=oci_error($dbh1);
		  $errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
		 }
		
		
// 		$sth= oci_parse($dbh1, $sql);
		 oci_bind_by_name($sth, ':EMAIL', $glusremail);
		 
		  $chk=@oci_execute($sth);	
			if(!$chk)
			{
			$e=oci_error($sth);
			$errorMsg = $e['message'];
				$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			
		      }

		 
// 		 oci_execute($sth);
		 $arr1=oci_fetch_array($sth);
		$name= $arr1[0];
                  
	        $glusrid=$arr1[1];
	        $company=$arr1[2];
	        $city=$arr1[3];
	        $state=$arr1[4];
	        $country=$arr1[5];
	        $ph_country=$arr1[6];
	        $ph_area=$arr1[7];
	        $ph_no=$arr1[8];
	        $mobile=$arr1[9];
	        $address=$arr1[10];
	        $fax_country=$arr1[11];
	        $fax_area=$arr1[12];
	        $fax_no=$arr1[13];
	        
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
			$str.='<div><B>Mobile / Cell Phone:</B> $mobile</div>';
		}
	        $str.='<div><B>Email:</B>'.$glusremail.'</div></td><tr></table><DIV><BR></DIV><DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">All Email Activities Of This Gluser</DIV>';
	        
	        $styletd='style="font-family:arial;font-size:12px;padding:3px 0 3px 5px;"';
	       $sql="SELECT IIL_MAIL_EVENT_MAILID,IIL_MAIL_EVENT_CATEGORY,IIL_MAIL_EVENT_TYPE,IIL_MAIL_EVENT_URL,
				TO_CHAR(IIL_MAIL_EVENT_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,IIL_MAIL_EVENT_GLUSER_ID,IIL_MAIL_EVENT_SENT_DATE,
				IIL_MAIL_EVENT_BOUNCESTATUS,IIL_MAIL_EVENT_BOUNCEREASON,
				IIL_MAIL_EVENT_SENT_DATE 
				FROM IIL_MAIL_EVENTS_INTERIM WHERE IIL_MAIL_EVENT_MAILID=:EMAIL
				UNION
				SELECT IIL_MAIL_EVENT_MAILID,IIL_MAIL_EVENT_CATEGORY,IIL_MAIL_EVENT_TYPE,IIL_MAIL_EVENT_URL,
				TO_CHAR(IIL_MAIL_EVENT_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,IIL_MAIL_EVENT_GLUSER_ID,IIL_MAIL_EVENT_SENT_DATE,
				IIL_MAIL_EVENT_BOUNCESTATUS,IIL_MAIL_EVENT_BOUNCEREASON,
				IIL_MAIL_EVENT_SENT_DATE 
				FROM IIL_MAIL_EVENTS_ARCHIVED WHERE IIL_MAIL_EVENT_MAILID=:EMAIL
				ORDER BY IIL_MAIL_EVENT_DATE1 DESC";
	         $sth= @oci_parse($dbh, $sql);
	         
	         if(!$sth)
		 {
		  $e=oci_error($dbh);
		  $errorMsg = $e['message'];
			$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
	        
		 }
		 oci_bind_by_name($sth, ':EMAIL', $glusremail);
		 
		  $chk=@oci_execute($sth);	
			if(!$chk)
			{
			$e=oci_error($sth);
			$errorMsg = $e['message'];
				$error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Oracle", "Cant execute  the query on Oracle",$errorMsg, 1);
			
		      }

// 		 oci_execute($sth);
		 
		 $str.='<div><table align="center" class="report_table" border="1" width="1210" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
			<tr bgcolor="#E1EDFA">
			<td width="210" '.$styletd.'><b>Email ID</b></td>
			<td width="75" '.$styletd.'><b>GLUSERID</b></td>
			<td width="130" '.$styletd.'><b>TIMESTAMP</b></td>
			<td width="200" '.$styletd.'><b>CATEGORY</b></td>
			<td width="70" '.$styletd.'><b>SUB CAT</b></td>
			<td width="80" '.$styletd.'><b>EVENT</b></td>
			<td width="155" '.$styletd.'><b>URL</b></td>
			<td width="120" '.$styletd.'><b>MAIL SENT DATE</b></td>
			<td width="90" '.$styletd.'><b>REASON</b></td>
			<td width="60" '.$styletd.'><b>STATUS</b></td>
			<td width="60" '.$styletd.'><b>TYPE</b></td>
			</tr>';
			
		while($rec = oci_fetch_array($sth))
		{
		 $email=$rec['IIL_MAIL_EVENT_MAILID'];
		 $timestamp=$rec['IIL_MAIL_EVENT_DATE1'];
		 $category=$rec['IIL_MAIL_EVENT_CATEGORY'];
		 $event=$rec['IIL_MAIL_EVENT_TYPE'];
		 $url=$rec['IIL_MAIL_EVENT_URL'];
		 $reason=$rec['IIL_MAIL_EVENT_BOUNCEREASON'];
		 $status=$rec['IIL_MAIL_EVENT_BOUNCESTATUS'];
# 				my $type=$rec->{'IIL_MAIL_EVENT_BOUNCETYPE'};
		 $type='';
		 $gluser_id=$rec['IIL_MAIL_EVENT_GLUSER_ID'];
# 				my $subcat=$rec->{'IIL_MAIL_EVENT_SUBCAT'};
		 $subcat='';
		 $sent_date=$rec['IIL_MAIL_EVENT_SENT_DATE'];
		 $str.='<tr><td '.$styletd.'>'.$email.'</td>';
				$str.='<td '.$styletd.'>';
				if($gluser_id){
				$str.=''.$gluser_id.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($timestamp){
				$str.='<div style="width:100px">'.$timestamp.'</div>';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($category)
				{
				$str.=''.$category.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($subcat){
				$str.=''.$subcat.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($event){
				$str.=''.$event.'';
				}
				$str.='</td>
				<td '.$styletd.'>';
				if($url){
				$str.='<input type="text" title="$url" value="$url" style="border:0px;font-family:arial;font-size:11px;width:155px" readonly>';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($sent_date){
				$str.=''.$sent_date.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($reason){
				$str.=''.$reason.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($status){
				$str.=''.$status.'';
				}
				$str.='</td>';
				$str.='<td '.$styletd.'>';
				if($type){
				$str.=''.$type.'';
				}
				$str.='</td></tr> ';
			}
			$str.='</table></div>';
		}
	        
	if($bouncereport==1)
	{
	   $sql="SELECT IIL_MAIL_EVENT_MAILID,COUNT(IIL_MAIL_EVENT_TYPE) CNTTBOUN,COUNT(DISTINCT(TRUNC(IIL_MAIL_EVENT_DATE))) CNTDISDATBOUN 
		FROM 
		(
		SELECT * FROM IIL_MAIL_LOG WHERE IIL_MAIL_EVENT_TYPE='bounce'
		/*UNION
		SELECT * FROM IIL_MAIL_EVENTS_INTERIM WHERE IIL_MAIL_EVENT_TYPE='bounce'
		*/)
		GROUP BY IIL_MAIL_EVENT_MAILID ORDER BY IIL_MAIL_EVENT_MAILID";
		
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
	        $sql1="SELECT COUNT(IIL_MAIL_EVENT_MAILID) CNT FROM
			(SELECT * FROM IIL_MAIL_LOG WHERE IIL_MAIL_EVENT_TYPE='bounce'
			/*UNION
			SELECT * FROM IIL_MAIL_EVENTS_INTERIM WHERE IIL_MAIL_EVENT_TYPE='bounce'*/
			)";
			 $sth1= pg_query($dbhpg, $sql1);
		  if(!$sth1)
		 {
		  $e=pg_last_error();
		  $error->print_oracle_error(__class__,__FILE__,__LINE__,"Cant execute  the query on Postgresql", "Cant execute  the query on Postgresql",$e, 1);
	        
		 }
		 
		  	
// 		$sth1= oci_parse($dbh, $sql1);	
// 		 oci_execute($sth1);
		 $rec2=pg_fetch_array($sth1);
		 $cnt=$rec2['CNT'];
// 		 my $excel = Spreadsheet::WriteExcel->new("$Excelfile");
// 		my $worksheet = $excel->addworksheet();
// 		my $row=0;
		 
// 		$workbook = new Spreadsheet_Excel_Writer();
// 		$workbook->send($Excelfile);

// 		$worksheet =& $workbook->addWorksheet();	
                $fp = fopen($Excelfile, 'w');
		$row=0;
		
		while($rec = pg_fetch_assoc($sth))
		{
		   
		  $email=$rec['IIL_MAIL_EVENT_MAILID'];
			#my $gluser_id=$rec->{'IIL_MAIL_EVENT_GLUSER_ID'};
		  $cnttboun=$rec['CNTTBOUN'];
		  $cntdisdatboun=$rec['CNTDISDATBOUN'];			
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
// 				$worksheet->write($row,$col++,'EMAIL');
				#$worksheet->write($row,$col++,'GLUSERID');
// 				$worksheet->write($row,$col++,'Total Entry of Bounce');
// 				$worksheet->write($row,$col++,'Count of Distinct Date');
			        $var3.='EMAIL,Total Entry of Bounce,Count of Distinct Date';
			        $ecnt=200;
				$scnt=1;
				fwrite($fp,"$var3\n");
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
// 			$worksheet->write($row,$col++,$email);
			$var4.="$email,$cnttboun,$cntdisdatboun";
			#$worksheet->write($row,$col++,$gluser_id);
// 			$worksheet->write($row,$col++,$cnttboun);
// 			$worksheet->write($row,$col++,$cntdisdatboun);
			fwrite($fp,"$var4\n");
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
	   $sqlcnt="SELECT COUNT(DISTINCT IIL_MAIL_EVENT_BOUNCESTATUS) CNT 
			FROM
			(
			SELECT * FROM IIL_MAIL_LOG WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL AND IIL_MAIL_EVENT_TYPE='bounce'
			/*UNION
			SELECT * FROM IIL_MAIL_EVENTS_INTERIM WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL AND IIL_MAIL_EVENT_TYPE='bounce'
			*/)";
	
	         $sthcnt=pg_query($dbhpg, $sqlcnt);	
		 //oci_execute($sthcnt);
		 $cnt1=pg_fetch_assoc($sthcnt);
		 $sql1="SELECT BOUNCESTATUS,BOUNCEREASON FROM
			(
			SELECT IIL_MAIL_EVENT_BOUNCESTATUS BOUNCESTATUS,IIL_MAIL_EVENT_BOUNCEREASON BOUNCEREASON,ROW_NUMBER()OVER(PARTITION BY IIL_MAIL_EVENT_BOUNCESTATUS 
			ORDER BY 1)RN FROM IIL_MAIL_LOG WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL 
			AND IIL_MAIL_EVENT_BOUNCEREASON IS NOT NULL AND IIL_MAIL_EVENT_TYPE='bounce'
			/*UNION
			SELECT IIL_MAIL_EVENT_BOUNCESTATUS BOUNCESTATUS,IIL_MAIL_EVENT_BOUNCEREASON BOUNCEREASON,ROW_NUMBER()OVER(PARTITION BY IIL_MAIL_EVENT_BOUNCESTATUS 
			ORDER BY 1)RN FROM IIL_MAIL_EVENTS_INTERIM WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL 
			AND IIL_MAIL_EVENT_BOUNCEREASON IS NOT NULL AND IIL_MAIL_EVENT_TYPE='bounce'
			*/)WHERE  RN=1 order by BOUNCESTATUS";
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
		  
		  $bouncestatus=$rec1['BOUNCESTATUS'];
		  $bouncereason=$rec1['BOUNCEREASON'];
		  $hash[$cnt++]=$bouncereason;
		  $hash[$cnt++]=$bouncestatus;
		  
		 }
		 $sql="SELECT IIL_MAIL_EVENT_BOUNCESTATUS BOUNCESTATUS,COUNT(IIL_MAIL_EVENT_BOUNCESTATUS) CNTBOUNCESTATUS,
			(SELECT COUNT(IIL_MAIL_EVENT_BOUNCESTATUS) FROM 
			(SELECT * FROM IIL_MAIL_LOG 
			WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL
			/*UNION 
			SELECT * FROM IIL_MAIL_EVENTS_INTERIM 
			WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL
			*/)) TCNTBOUNCESTATUS
			FROM 
			(
			SELECT * FROM IIL_MAIL_LOG 
			WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL 
			AND IIL_MAIL_EVENT_TYPE='bounce' 
			/*UNION
			SELECT * FROM IIL_MAIL_EVENTS_INTERIM 
			WHERE IIL_MAIL_EVENT_BOUNCESTATUS IS NOT NULL 
			AND IIL_MAIL_EVENT_TYPE='bounce' 
			*/)
			GROUP BY IIL_MAIL_EVENT_BOUNCESTATUS
			ORDER BY IIL_MAIL_EVENT_BOUNCESTATUS";
			
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
	          $bouncestatus=$rec['BOUNCESTATUS'];
		  $cntbouncestatus=$rec['CNTBOUNCESTATUS'];
		  $tcntbouncestatus=$rec['TCNTBOUNCESTATUS'];
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
	                        
	                        
	                        
	                        
	                       
	