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


echo '<html><head><title>SMS Report</title></head><body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0"><SCRIPT LANGUAGE="JavaScript">
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
	
        if(document.reportform.glid.value.trim().length == 0)
	{
            alert("Fill GLUSR ID");           
            return false;
        }else	{
                if (isNaN(document.reportform.glid.value)) 
                  {
                  alert("Must input numbers in GLUSR ID");                 
                  return false;
                 }
        }	
		
	}
	
	//-->
	</SCRIPT>
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
	<style>.report_table td{font-family:arial;font-size:12px;padding:3px 0 3px 5px;}</style>';
	
	echo '<FORM name="reportform" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
	<TD BGCOLOR="#00479e" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;color:#FFF">
	<b>SMS REPORT</b></TD>
	</TR>
	</TABLE>
	<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="1" align="center">
	<TR>
	<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD>
	<TD STYLE="font-family:arial;font-size:12px;font-weight:bold;"BGCOLOR="#EAEAEA">
	<TABLE BORDER="1" CELLPADDING="3" CELLSPACING="0"><TR><TD><SELECT NAME="sdate_day" SIZE="1"><OPTION VALUE="0">Day</OPTION>';
	
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
                
               echo '</SELECT></TD></tr></TABLE></td></tr>
               <tr>               
               <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;GLUSR ID</TD>
               <td STYLE="font-family:arial;font-size:12px;font-weight:bold;"BGCOLOR="#EAEAEA"><input style="width:190px;" type="text" name="glid" id="glid" value="'.$glusr_id.'"> &nbsp;&nbsp;&nbsp;
               <input type="SUBMIT" name="Submit" value="Generate Report" style="font-size:13px;font-family:arial;font-weight:bold;padding:5px;">
               </td>              
               </tr>';
if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=='Generate Report')
 			{
 			
 			$arr = pg_fetch_all($sth_main);
 			
 			if(empty($arr))
 			{
 			$size=0;
 			}
 			else
 			{
 			$size= sizeof($arr);
 			}
 			
 		       $sr=1;
 		       
 		       if($size ==0)
 		       {
 		       echo '<p align="center"><font size="2" color="red"><b>No  records found</b></font></p>';
 		       }
 		       else
 		       {
 			echo '<br>';
 			echo '<table width="100%">
 			<tr>
 			<td align="center"><a href="/index.php?r=admin_bl/SMS_Report/Index&mid=3503&export=yes&startdate='.$startdate.'&enddate='.$enddate.'&glid='.$glusr_id.'&mobno='.$mob_no.'&process='.$process_name.'&subprocess='.$sub_process_name.'&Status='.$delivery_status.'" target="_blank">Export To Excel</a> </td></tr>
 			<tr>
 			<td align="center"><font size="2"><b>No. of records found : '.$size.'</b></font></td>
 			</tr>
 			</table>';
 			echo '<table align="center" class="report_table" border="1" width="95%" cellpadding="0" cellspacing="0" bordercolor="#9098A0" style="border-collapse:collapse">

				<tr bgcolor="#E1EDFA">
				<td width="2%"><b>Sn.</b></td>
				<td width="5%"><b>Glusr Id</b></td>
				<td width="2%"><b>Type</b></td>
				<td width="5%"><b>Refrence Id</b></td>
				<td width="5%"><b>Sent Date</b></td>
				<td width="5%"><b>Response Time</b></td>
				<td width="5%"><b>Delivery Time</b></td>
				<td width="5%"><b>Delivery Status</b></td>
				<td width="5%"><b>Mobile</b></td>
				<td width="5%"><b>Provider</b></td>
				<td width="5%"><b>Account Id</b></td>
				<td width="5%"><b>Process Name</b></td>
				<td width="5%"><b>Sub Process Name</b></td>
				<td width="5%"><b>Message Id</b></td>
				<td width="5%"><b>Failure Reason</b></td>
				<td width="5%"><b>Content Id</b></td>
				<td width="5%"><b>Mcat Id</b></td>
				<td width="5%"><b>Offer Id</b></td>
				<td width="16%"><b>Content</b></td></tr>';
				
				while($rec=pg_fetch_assoc($sth_main))
				
				{
				
				$iil_sms_glusr_id=isset($rec['iil_sms_glusr_id']) ? $rec['iil_sms_glusr_id'] : '';
				$iil_sms_type=isset($rec['iil_sms_type']) ? $rec['iil_sms_type'] : '';
				$iil_sms_refrence_id=isset($rec['iil_sms_refrence_id']) ? $rec['iil_sms_refrence_id'] : '';
				$iil_sms_send_date=isset($rec['iil_sms_sent_date']) ? $rec['iil_sms_sent_date'] : '';
				$iil_sms_response_time=isset($rec['iil_sms_response_time']) ? $rec['iil_sms_response_time'] : '';
				$iil_sms_delivery_time=isset($rec['iil_sms_delivery_time']) ? $rec['iil_sms_delivery_time'] : '';
				$iil_sms_delivery_status=isset($rec['iil_sms_delivery_status']) ? $rec['iil_sms_delivery_status'] : '';
				$iil_sms_mobile=isset($rec['iil_sms_mobile']) ? $rec['iil_sms_mobile'] : '';
				$iil_sms_provider=isset($rec['iil_sms_provider']) ? $rec['iil_sms_provider'] : '';
				$iil_sms_account_id=isset($rec['iil_sms_account_id']) ? $rec['iil_sms_account_id'] : '';
				$iil_sms_process_name=isset($rec['iil_sms_process_name']) ? $rec['iil_sms_process_name'] : '';
				$iil_sms_sub_process_name=isset($rec['iil_sms_sub_process_name']) ? $rec['iil_sms_sub_process_name'] : '';
				$iil_sms_message_id=isset($rec['iil_sms_message_id']) ? $rec['iil_sms_message_id'] : '';
				$ill_sms_failure_reason=isset($rec['ill_sms_failure_reason']) ? $rec['ill_sms_failure_reason'] : '';
				$fk_sms_content_id=isset($rec['fk_sms_content_id']) ? $rec['fk_sms_content_id'] : '';
				$fk_glcat_mcat_id=isset($rec['fk_glcat_mcat_id']) ? $rec['fk_glcat_mcat_id'] : '';
				$fk_eto_ofr_display_id=isset($rec['fk_eto_ofr_display_id']) ? $rec['fk_eto_ofr_display_id'] : '';
				$sms_content=isset($rec['sms_content']) ? $rec['sms_content'] : '';
				
				
				echo '<tr>
				<td width="2%">'.$sr.'</td>
				<td width="5%">'.$iil_sms_glusr_id.'</td>
				<td width="2%">'.$iil_sms_type.'</td>
				<td width="5%">'.$iil_sms_refrence_id.'</td>
				<td width="5%">'.$iil_sms_send_date.'</td>
				<td width="5%">'.$iil_sms_response_time.'</td>
				<td width="5%">'.$iil_sms_delivery_time.'</td>
				<td width="5%">'.$iil_sms_delivery_status.'</td>
				<td width="5%">'.$iil_sms_mobile.'</td>
				<td width="5%">'.$iil_sms_provider.'</td>
				<td width="5%">'.$iil_sms_account_id.'</td>
				<td width="5%">'.$iil_sms_process_name.'</td>
				<td width="5%">'.$iil_sms_sub_process_name.'</td>
				<td width="5%">'.$iil_sms_message_id.'</td>
				<td width="5%">'.$ill_sms_failure_reason.'</td>
				<td width="5%">'.$fk_sms_content_id.'</td>
				<td width="5%">'.$fk_glcat_mcat_id.'</td>
				<td width="5%">'.$fk_eto_ofr_display_id.'</td>
				<td width="16%">'.$sms_content.'</td></tr>';
				$sr=$sr+1;
				}
				
			   
				
				echo '</table>';
				
				}
				
			
 			}
        
    
        
?>
  