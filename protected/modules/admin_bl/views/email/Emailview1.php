<?php

        $start11_date=date("Y-m-d h:i:sa");
	$string11=explode(" ",$start11_date);
	$date_1=$string11[0];
	$date_2=$string11[1];
	$string_2=explode("-",$date_1);
	$curr_year=$string_2[0];
	$curr_month=$string_2[1];
	$curr_day=$string_2[2];
	$string_3=explode(":",$date_2);
	$curr_hour=$string_3[0];
	$curr_min=$string_3[1];
	$curr_sec=$string_3[2];
	
	if($curr_month < 10)
	{
		$curr_month='0'.$curr_month;
	}
	$months = array('01' => "January",
             '02' => "February",
	     '03' => "March",
	     '04' => "April",
	     '05' => "May",
	     '06' => "June",
	     '07' => "July",
	     '08' => "August",
	     '09' => "September",
	     '10' => "October",
	     '11' => "November",
	     '12' => "December");  



echo '<html><head><title>Email Event Notification Report</title></head><body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"><SCRIPT LANGUAGE="JavaScript">
         <!--
	function checkBuyForm()
	{

		if(document.reportform.sdate_day.value == 0 || document.reportform.sdate_month.value == 0 || document.reportform.sdate_year.value == 0)
		{
			alert("Fill Start Date");
			return false;
		}
	
		if(document.reportform.edate_day.value == 0 || document.reportform.edate_month.value == 0 || document.reportform.edate_year.value == 0)
		{
			alert("Fill End Date");
			return false;
		}
	
		if(document.reportform.sdate_month.value == 2 || document.reportform.sdate_month.value == 4
		|| document.reportform.sdate_month.value == 6|| document.reportform.sdate_month.value == 9|| document.reportform.sdate_month.value == 11)
		{
			if(document.reportform.sdate_day.value == 31)
			{
			alert("This date does not exists");
			return false;
			}
		}
		if(document.reportform.edate_month.value == 2 || document.reportform.edate_month.value == 4
		|| document.reportform.edate_month.value == 6|| document.reportform.edate_month.value == 9|| document.reportform.edate_month.value == 11)
		{
			if(document.reportform.edate_day.value == 31)
			{
			alert("This date does not exists");
			return false;
			}
		}
	}
	function change()
	{
	var cat = document.getElementById("category_search");
	var val = cat.options[cat.selectedIndex].value;
	if(val == \'User Admin Mails\')
	document.getElementById("category_search1").style.display = \'block\';
	else
	document.getElementById("category_search1").style.display = \'none\';
	}
	//-->
	</SCRIPT><style>.report_table td{font-family:arial;font-size:12px;padding:3px 0 3px 5px;}</style>';
	
	echo '<FORM name="reportform" METHOD="post" ACTION="index.php?r=admin_bl/Email/Index" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();"><TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30"><TR><TD BGCOLOR="#00479e" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;color:#FFF"><b>EMAIL EVENT NOTIFICATION REPORT</b></TD></TR></TABLE><TABLE BORDER="0" CELLPADDING="0" CELLSPACING="1" align="center"><TR><TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD><TD STYLE="font-family:arial;font-size:12px;font-weight:bold;"		BGCOLOR="#EAEAEA"><TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0"><TR><TD><SELECT NAME="sdate_day" SIZE="1"><OPTION VALUE="0">Day</OPTION>';
	
	 foreach(range(1,31) as $value)
		{
			if($value < 10)
			{
				
				echo '<OPTION VALUE="0'.$value.'"';
				if (isset($xyz['sdate_day']) && $xyz['sdate_day'] == $value) 
				{
					echo ' SELECTED ';
				}
				elseif($value == $curr_day && !isset($xyz['sdate_day']))
				{
				  
				  
					echo ' SELECTED';
				}
				echo '>0'.$value.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$value.'"';
				if (isset($xyz['sdate_day']) && $xyz['sdate_day'] == $value) 
				{
					echo ' SELECTED ';
				}
				elseif($value == $curr_day && !isset($xyz['sdate_day']))
				{
					echo ' SELECTED ';
				}
				echo '>'.$value.'</OPTION">';
			}  
                }
                
               

		echo '</SELECT></TD>
            <TD><SELECT NAME="sdate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
            
            
            $month = array_keys($months);
	    foreach ($month as $key) {
                echo '<OPTION VALUE="'.$key.'"';
                   if(isset($xyz['sdate_month']) && $xyz['sdate_month'] == $key)
                   {
                       echo ' SELECTED ';
                   }
		elseif($key == $curr_month && !isset($xyz['sdate_month']))
		{
			echo 'SELECTED ';
		}
                   echo '>'.$months[$key].'</OPTION">'; 
                }
                             
                
                
		echo '</SELECT></TD>
            <TD><SELECT NAME="sdate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';
            
            foreach(range(2012,2018) as $key1)
            {
             echo '<OPTION VALUE="'.$key1.'"';
                   if(isset($xyz['sdate_year'])  && $xyz['sdate_year'] == $key1 )
                    {
                      echo 'SELECTED';
                     }
                     elseif($key1 == $curr_year  && !isset($xyz['sdate_year']))
                     {
                        echo 'SELECTED';
                     }
                     echo '>'.$key1.'</OPTION">';
            }
            
            echo '</SELECT></TD>


		<TD>&nbsp;to&nbsp;</TD>

		<TD><SELECT NAME="edate_day" SIZE="1">
            <OPTION VALUE="0">Day</OPTION>';


                foreach(range(1,31) as $val)
                {
                   if($val < 10)
                   {
                       echo '<OPTION VALUE="0'.$val.'"';
                       if(isset($xyz['edate_day']) == "0'.$val.'"  && $xyz['edate_day'] == $val)
                       {
                          echo 'SELECTED';
                       }
                    elseif($val == $curr_day && !isset($xyz['edate_day']))
                    {
                      echo 'SELECTED';
                     }
                     echo '>0'.$val.'</OPTION">';
                   }
                   else
                     {
                      echo '<OPTION VALUE="'.$val.'"';
                      if(isset($xyz['edate_day'])  == $val && $xyz['edate_day'] == $val) 
                      {
                         echo ' SELECTED';
                      }
                      elseif($val == $curr_day && !isset($xyz['edate_day']))
                      {
                         echo ' SELECTED';
                      }
                      echo '>'.$val.'</OPTION">';
                       }
                     }        
                     
                   echo '</SELECT></TD>
            <TD><SELECT NAME="edate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
            
            foreach ($month as $key) 
	      {
                    echo '<OPTION VALUE="'.$key.'"';
                   if(isset($xyz['edate_month']) && $xyz['edate_month'] == $key)
                   {
                       echo ' SELECTED ';
                   }
		elseif($key == $curr_month && !isset($xyz['edate_month']))
		   {
			echo 'SELECTED ';
		   }
                    echo '>'.$months[$key].'</OPTION">'; 
              }

           

		echo '</SELECT></TD>
            <TD><SELECT NAME="edate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';
            
             foreach(range(2012,2018) as $key1)
                {
                   echo '<OPTION VALUE="'.$key1.'"';
                   if(isset($xyz['edate_year'])  && $xyz['edate_year'] == $key1 )
                    {
                      echo 'SELECTED';
                     }
                     elseif($key1 ==$curr_year  && !isset($xyz['edate_year']))
                     {
                        echo 'SELECTED';
                     }
                     echo '>'.$key1.'</OPTION">';
                }
                
               echo '</SELECT></TD></tr></tbody></table></td><td rowspan="2" bgcolor="#CCCCFF" style="padding:8px"><input type="hidden" name="report" value="1"><input type="SUBMIT" name="Submit" value=" Generate Report " style="font-size:13px;font-family:arial;font-weight:bold;padding:5px;"></td></tr><tr><td colspan="2" bgcolor="#EAEAEA" style="font-family:arial;padding:5px"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="250"><input type="text" style="border:1px solid #b6cae4;width:210px;padding-left:5px;" VALUE="" placeholder="Please enter email id here" name="email_search"> <span style="font-family:arial;font-size:12px;font-weight:bold;color:#0000ff" title="If you want result for a specific email id">[?]</span> </td><td style="border-left:1px solid #FFF;padding-left:15px;padding-right:15px">';
               
               if(isset($_REQUEST['category_search']))
               {
               $category_search=$_REQUEST['category_search'];
               }
               else
               {
               $category_search='';
               }
               
              $category_list=array('Daily BL Alerts','1','All Daily BL Alerts','All Daily BL Alerts','&nbsp;&nbsp;Morning > 0 and LP<> F','Morning > 0 and LP<> F','&nbsp;&nbsp;Morning > 0 and LP=F','Morning > 0 and LP=F','&nbsp;&nbsp;Evening > 0 and LP<>F','Evening > 0 and LP<>F','&nbsp;&nbsp;Evening > 0 and LP=F','Evening > 0 and LP=F','&nbsp;&nbsp;EMorning > 0 and LP<> F','EMorning > 0 and LP<> F','&nbsp;&nbsp;LEvening > 0 and LP<>F','LEvening > 0 and LP<>F','&nbsp;&nbsp;Once in Two Days Credit = 0 or NULL and LP <>F','Once in Two Days Credit = 0 or NULL and LP <>F','&nbsp;&nbsp;Once in Two Days Credit = 0 or NULL and LP=F','Once in Two Days Credit = 0 or NULL and LP=F','&nbsp;&nbsp;Once Daily Morning LP <> F But 10+ Foreign Purchased','Once Daily Morning LP <> F But 10+ Foreign Purchased','&nbsp;&nbsp;Instant BL Alerts','Instant BL Alerts','&nbsp;&nbsp;Product Preference Alerts','Product Preference Alerts','&nbsp;&nbsp;BL CREDITS ALLOCATION - INDIAMART TRIAL','BL CREDITS ALLOCATION - INDIAMART TRIAL','&nbsp;&nbsp;IndiaMART Trial Reminder - IndiaMART Trial','IndiaMART Trial Reminder - IndiaMART Trial','&nbsp;&nbsp;BL Alert- Instant with Credits','BL Alert- Instant with Credits','&nbsp;&nbsp;BL Alert- Instant without Credits','BL Alert- Instant without Credits','&nbsp;&nbsp;BL Alert- Early Morning','BL Alert- Early Morning','&nbsp;&nbsp;BL Alert- Morning','BL Alert- Morning','&nbsp;&nbsp;BL Alert- Evening','BL Alert- Evening','&nbsp;&nbsp;BL Alert- Late Evening','BL Alert- Late Evening','&nbsp;&nbsp;BL Alert- ITO','BL Alert- ITO','&nbsp;&nbsp;IMA- Instant without Credits','IMA- Instant without Credits','&nbsp;&nbsp;IMA- Instant with Credits','IMA- Instant with Credits','&nbsp;&nbsp;IMA- Late Evening','IMA- Late Evening','&nbsp;&nbsp;IMA- Morning','IMA- Morning','&nbsp;&nbsp;IMA- Early Morning','IMA- Early Morning','&nbsp;&nbsp;ITO- Instant without Credits','ITO- Instant without Credits','&nbsp;&nbsp;ITO- Instant with Credits','ITO- Instant with Credits','&nbsp;&nbsp;ITO- Late Evening','ITO- Late Evening','&nbsp;&nbsp;ITO- Morning','ITO- Morning','&nbsp;&nbsp;ITO- Early Morning','ITO- Early Morning','&nbsp;&nbsp;BL Expiry Reminder','2','Expiry Notification','Expiry Notification','Expiry Reminder','Expiry Reminder','Buy Lead Approval Mails','3','BL Approval- India','BL Approval- India','BL Approval- India-ALT','BL Approval- India-ALT','BL Approval- Foreign','BL Approval- Foreign','BL Approval- Foreign-ALT','BL Approval- Foreign-ALT','BL Insta AstBuy- India','BL Insta AstBuy- India','BL Insta AstBuy- India-ALT','BL Insta AstBuy- India-ALT','BL Insta AstBuy- Foreign','BL Insta AstBuy- Foreign','BL Insta AstBuy- Foreign-ALT','BL Insta AstBuy- Foreign-ALT','ASSISTED BUY','4','ASTBUY Mail to Buyer','ASTBUY Mail to Buyer','ASTBUY Mail to Supplier','ASTBUY Mail to Supplier','Buy Leads Deletion','5','BL Rejection- India','BL Rejection- India','BL Rejection- India-ALT','BL Rejection- India-ALT','BL Rejection- Foreign','BL Rejection- Foreign','BL Rejection- Foreign-ALT','BL Rejection- Foreign-ALT','BL Purchase','6','BL Purchase Mail to Buyer','BL Purchase Mail to Buyer','BL Purchase Mail to Supplier','BL Purchase Mail to Supplier','BL Renewal Mails','7','Buy Leads Renewal','BuyLeadsRenewal','BL Subscription Renewal Mails','BL Subscription Renewal Mails','MISC Mails','8','BL Call Center Approval Mails','BL Call Center Approval Mails','BL Feedback Mails','BL Feedback Mails','BL Complaint Feedback Mails','BL Complaint Feedback Mails','Feedback Mails paid Enq','Feedback mail on paid enquiries','Response Mail Sent thru MY','Response Mail Sent thru MY','BL Loc Pref Mails','BL Loc Pref Mails','BL Subscription Renewal Mails','BL Subscription Renewal Mails','BL Weberp Sales Mailer','BL Weberp Sales Mailer','BL Credits Allocation Mail','BL Credits Allocation Mail','BL Weekly Offer Mail','BL Weekly Offer Mail','Failure','Failure','IIL Advantage - Credit allocation process','IIL Advantage - Credit allocation process','No Usage Reminder','No Usage Reminder','No-Usage Credits Lapse','No-Usage Credits Lapse','Feedback Mail','Feedback Mail','
Taging Mail','
Taging Mail','Performance Scorecard','Performance Scorecard','Welcome Kit','Welcome Kit','PNS defaulter','PNS defaulter','Order Confirmation','Order Confirmation','CSD Renewal Reminder','CSD Renewal Reminder','Web Enquiry Mail-IMOB M','Web Enquiry Mail-IMOB M');

$useradmin=array('--Select--','FCP New Registration Mail','Invitation to view Product Catalog','Modify Freelisting Mail','Web Enquiry Mail - IIND QAS','Newsletter','Business Inquiry from Private Buyer Catalog','Web Enquiry Mail - 2571750','Web Enquiry Mail-FCP F','Forgot Password Mail','Web Enquiry Mail-DIR-P-ISCC','Primary Email Change','Web Enquiry Mail-ETO QAS,Web Enquiry Mail-CTL QAS','Web Enquiry Mail-ETO CC','Web Enquiry Mail - TDW QAS','Web Enquiry Mail-ETO P','PURL Approved','Web Enquiry Mail-CTL F CC','Web Enquiry Mail - INE QAS','Alternate Email Change','Web Enquiry Mail - DIR QAS','PURL Denied','Change Password Mail','Web Enquiry Mail - MDC QAS','Web Enquiry Mail-DIR-F-ISCC','Web Enquiry Mail-DIR-F','Quarterly Listing Mail','My Enquiry Reply Mail','Web Enquiry Mail-CTL P','Web Enquiry Mail-CTL F','Additional Information by Buyer','Web Enquiry Mail-DIR-P','My New Registration Mail','Web Enquiry Mail-FCP','Alternative Email-id at IndiaMART','Web Enquiry Mail-FCP F CC','FCP SMS Enquiry Mail','Web Enquiry Mail-ETO F','Web Enquiry Mail-CTL P CC','Web Enquiry Mail - FCP QAS','New Freelisting Mail','Forgot Password Mail-FCP','Web Enquiry Mail - HELLOTD QAS');

$catlist_ofrid=array('AllDailyBLA'=>'1','Morning > 0 and LP<> F'=>'1','Morning > 0 and LP=F'=>'1','Evening > 0 and LP<>F'=>'1','Evening > 0 and LP=F'=>'1','Once in Two Days Credit = 0 or NULL and LP <>F' =>'1','Once in Two Days Credit = 0 or NULL and LP=F'=>'1','Once Daily Morning LP <> F But 10+ Foreign Purchased'=>'1','EMorning > 0 and LP<> F'=>'1','LEvening > 0 and LP<>F'=>'1','Instant BL Alerts'=>'1','Product Preference Alerts'=>'1','BL CREDITS ALLOCATION - INDIAMART TRIAL'=>'1','IndiaMART Trial Reminder - IndiaMART Trial'=>'1','BL Alert- Instant with Credits'=>'1','BL Alert- Instant without Credits'=>'1','BL Alert- Early Morning'=>'1','BL Alert- Morning'=>'1','BL Alert- Evening'=>'1','BL Alert- Late Evening'=>'1','BL Alert- ITO'=>'1','IMA- Instant without Credits'=>'1','IMA- Instant with Credits'=>'1','IMA- Late Evening'=>'1','IMA- Morning'=>'1','IMA- Early Morning'=>'1','ITO- Instant without Credits'=>'1','ITO- Instant with Credits'=>'1','ITO- Late Evening'=>'1','ITO- Morning'=>'1','ITO- Early Morning'=>'1');



echo '<select style="width:259px" name="category_search" id="category_search" onchange="change()"><option value="ALL">All Categories</option>';

$cntcat=0;
   while ($cntcat<count($category_list))
	{
		if((($cntcat+1)<count($category_list)) && (($category_list[$cntcat+1] == '1') || ($category_list[$cntcat+1] == '2') || ($category_list[$cntcat+1] == '3')|| ($category_list[$cntcat+1] =='4') || ($category_list[$cntcat+1] =='5') || ($category_list[$cntcat+1] =='6') || ($category_list[$cntcat+1] =='7') || ($category_list[$cntcat+1] =='8')))
		{
		       if($cntcat !=0){
			echo '</optgroup>';
			}
			echo '<optgroup label="'.$category_list[$cntcat].'">';
		}
		else
		{
			if(($cntcat<=count($category_list)) && ($cntcat == '3') && ($category_search =='AllDailyBLA'))
			{
			echo '<option value="AllDailyBLA" selected>All Daily BL Alerts</option>';
			}
			else
			{
				if(($cntcat<=count($category_list)) && ($cntcat == '3'))
				{
				echo '<option value="AllDailyBLA">All Daily BL Alerts</option>';
				}
			}

			if(($cntcat<=count($category_list)) && ($cntcat % 2 !=0) && !($cntcat == '3')  &&  !(($category_list[$cntcat] =='1') || ($category_list[$cntcat] =='2') || ($category_list[$cntcat] =='3') || ($category_list[$cntcat] =='4') || ($category_list[$cntcat] =='5') || ($category_list[$cntcat] =='6') || ($category_list[$cntcat] =='7' || ($category_list[$cntcat] =='8'))))
			{
				if($category_list[$cntcat] == $category_search)
				{
					echo '<option value="'.$category_list[$cntcat].'" selected>'.$category_list[$cntcat-1].'</option>';
				}
				else
				{
					echo '<option value="'.$category_list[$cntcat].'">'.$category_list[$cntcat-1].'</option>';
				}
			}
		}	
		
		$cntcat++;	
	}
	
	$disp = "none";
	if($category_search == 'User Admin Mails')
	{
	$disp = "block";
	echo '<option value="User Admin Mails" selected>User Admin Mails</option>';
	}
	else
	{
	echo '<option value="User Admin Mails">User Admin Mails</option>';
	}
	
	
	
	
	
	$disp = "none";
	if($category_search == 'Call Enquiry - Missed')
	{
	$disp = "block";
	echo '<option value="Call Enquiry - Missed" selected>Call Enquiry - Missed</option>';
	}
	else
	{
	echo '<option value="Call Enquiry - Missed">Call Enquiry - Missed</option>';
	}
	
	$disp = "none";
	if($category_search == 'Call Enquiry - success')
	{
	$disp = "block";
	echo '<option value="Call Enquiry - success" selected>Call Enquiry - success</option>';
	}
	else
	{
	echo '<option value="Call Enquiry - success">Call Enquiry - success</option>';
	}
	
	$disp = "none";
	if($category_search == 'PNS Suppress')
	{
	$disp = "block";
	echo '<option value="PNS Suppress" selected>PNS Suppress</option>';
	}
	else
	{
	echo '<option value="PNS Suppress">PNS Suppress</option>';
	}
	$disp = "none";
	if($category_search == 'PNS Info')
	{
	$disp = "block";
	echo '<option value="PNS Info" selected>PNS Info</option>';
	}
	else
	{
	echo '<option value="PNS Info">PNS Info</option>';
	}
	$disp = "none";
	if($category_search == 'PNS Warning')
	{
	$disp = "block";
	echo '<option value="PNS Warning" selected>PNS Warning</option>';
	}
	else
	{
	echo '<option value="PNS Warning">PNS Warning</option>';
	}
	
	
	$disp = "none";
	if($category_search == 'BL Performance Scorecard')
	{
	$disp = "block";
	echo '<option value="BL Performance Scorecard" selected>BL Performance Scorecard</option>';
	}
	else
	{
	echo '<option value="BL Performance Scorecard">BL Performance Scorecard</option>';
	}
	
	
	
	
	
	
	echo '</optgroup></select>';
	if(isset($_REQUEST['category_search1']))
	{
	$category_search1=$_REQUEST['category_search1'];
        }
        else
        {
        $category_search1='';
        }
        
        echo '<br><select style="width:259px;display:'.$disp.'" id="category_search1" name="category_search1">';
        $cntcat1=0;
        
        while ($cntcat1<count($useradmin))
	{ 
	  if($useradmin[$cntcat1] == $category_search1)
	 {
	  echo '<option value="'.$useradmin[$cntcat1].'" selected>'.$useradmin[$cntcat1].'</option>';
	 }
	  else
	 {	
	   echo '<option value="'.$useradmin[$cntcat1].'">'.$useradmin[$cntcat1].'</option>';
	 }
	$cntcat1++;
	}
	echo '</select></td>';
	if(isset($_REQUEST['event_search']))
	{
	$event_search=$_REQUEST['event_search'];
        }
        else
        {
        $event_search='';
        }
        echo '<td style="border-left:1px solid #FFF;padding-left:15px;">
	<select style="width:110" name="event_search" onchange="if(this.value==\'dropped\'){document.getElementById(\'dropped_reason\').style.display=\'block\'}else{document.getElementById(\'dropped_reason\').style.display=\'none\'}"><option value="ALL">All Events</option>';
	$event_value=array('Open'=>'open','Unsubscribe'=>'unsubscribe','Click'=>'click','Bounce'=>'bounce','Spamreport'=>'spamreport','Drop'=>'dropped');
	
	while (list($key, $val) = each($event_value)) 
	{
         if($val == $event_search)
		{
			echo '<option value="'.$val.'" selected>'.$key.'</option>';
		}
		else
		{
			echo '<option value="'.$val.'">'.$key.'</option>';
		}
	}
	
	echo '</select>';
	$dropped_res_val='none';
	if($event_search == 'dropped')
	{
	$dropped_res_val='block';
	}
	echo '<select style="width:110;display:'.$dropped_res_val.'" id="dropped_reason" name="dropped_reason"><option value="ALL">All Reason</option><option value="Invalid">Invalid Only</option></select>';
	echo '</td></tr></table></td></tr></tbody></table></FORM>';
	echo '</body></html>';
	
// 	$systmdate=sprintf("%02d-%02d-%04d",$curr_day,$curr_month,$curr_year);
// 	
// 	if($_REQUEST['dropped_reason'])
// 	{
// 	$dropped_res_val_condition=$_REQUEST['dropped_reason'];
// 	}
//         else{
//         $dropped_res_val_condition='';
//         }
        
//         echo $str;
        
?>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  