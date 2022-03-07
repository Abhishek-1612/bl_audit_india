<?php
echo '
	<FORM name="searchForm" METHOD="post" ACTION="/index.php?r=admin_bl/Regular_buyer_alert/Index" STYLE="margin-top:0;margin-bottom:0;" >
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:16px;font-weight:bold;">Generation Report</TD>
	</TR>
	</TABLE>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD>
		<TD STYLE="font-family:arial;font-size:12px;font-weight:bold;" 
		BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
		
		<TD><SELECT NAME="bdate_day" SIZE="1">
	      <OPTION VALUE="0">Day</OPTION>';
		
$fields = array('adate_day','adate_month','adate_year','bdate_day','bdate_month','bdate_year','modid','client');
	 $param=array();
	foreach ($fields as $x) 
	{
     		if (isset($_REQUEST[$x])) 
		{
        		$param[$x]=$_REQUEST[$x];
     		} 
		else 
		{
        		$param[$x]='';
     		}
  	}
  	
  list ($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
	$curr_month = $curr_month+1;
	if($curr_month < 10)
	{
		$curr_month='0'.$curr_month;
	}
     $curr_year=$curr_year+1900;

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
	     
      foreach (range(1,31) as $x) 
		{
			if($x < 10)
			{
				echo '<OPTION VALUE="0'.$x.'"';
				if ($param['bdate_day'] == '0'.$x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo ' SELECTED';
				}
				echo '>0'.$x.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$x.'"';
				if ($param['bdate_day'] == $x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo  'SELECTED ';
				}
				echo '>'.$x.'</OPTION">';
			}  
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
		$months2=array_keys($months);
		foreach ($months2 as $x) {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['bdate_month'] && $param['bdate_month'] == $x) {
                       echo 'SELECTED';
                   }
		elseif($x == $curr_month && !$param['bdate_month'])
		{
			echo 'SELECTED';
		}
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';

		foreach (range(($curr_year-5),($curr_year+5)) as $x) {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['bdate_year'] && $param['bdate_year'] == $x) {
                       echo 'SELECTED ';
                   }
		elseif($x == $curr_year && !$param['bdate_year'])
		{
			echo 'SELECTED';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
		echo '</SELECT></TD>


		<TD>&nbsp;to&nbsp;</TD>

		<TD><SELECT NAME="adate_day" SIZE="1">
            <OPTION VALUE="0">Day</OPTION>';

		foreach (range(1,31) as $x) 
		{
			if($x < 10)
			{
				echo '<OPTION VALUE="0'.$x.'"';
				if ($param['adate_day'] == '0'.$x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['adate_day'])
				{
					echo 'SELECTED';
				}
				echo '>0'.$x.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$x.'"';
				if ($param['adate_day'] == $x) 
				{
					echo ' SELECTED ';
				}
				elseif($x == $curr_day && !$param['adate_day'])
				{
					echo ' SELECTED ';
				}
				echo '>'.$x.'</OPTION">';
			}  
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
		 $months2=array_keys($months);
		 foreach($months2 as $x)
		 {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['adate_month'] && $param['adate_month'] == $x) {
                      echo 'SELECTED';
                   }
		elseif($x == $curr_month && !$param['adate_month'])
		{
			echo 'SELECTED ';
		}
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';

		foreach (range(($curr_year-5),($curr_year+5)) as $x) {
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['adate_year'] && $param['adate_year'] == $x) {
                       echo 'SELECTED';
                   }
		elseif($x == $curr_year && !$param['adate_year'])
		{
		echo ' SELECTED ';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
		
		echo '</SELECT></TD>
		
		</TABLE></TD>';

      echo '<TD WIDTH="100" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Category:</TD>
		<TD BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
		<TD>';

 	    echo '<SELECT NAME="client" SIZE="1" style="width:300px;">
 	    <OPTION VALUE="0" selected="selected"> Select Category </OPTION>
	    <OPTION VALUE="13"';
	    if($param['client']==13)
		{
		  echo ' selected';
		}
	    
	    echo '>All India</OPTION>
	    <OPTION VALUE="1"';
		if($param['client']==1)
		{
			echo ' selected';
		}

		echo '>Old Buyers Reactivation - India 1</OPTION>
		<OPTION VALUE="2"';
		if($param['client']==2)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - India 3</OPTION>';
		echo '<OPTION VALUE="3"';
		if($param['client']==3)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - India 7</OPTION>';
		echo '<OPTION VALUE="4"';
		if($param['client']==4)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - India 15</OPTION>';
		echo '<OPTION VALUE="5"';
		if($param['client']==5)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - India 30</OPTION>';
		echo '<OPTION VALUE="6"';
		if($param['client']==6)
		{
			echo  'selected';
		}

		echo '>All Foreign </OPTION>';
		echo '<OPTION VALUE="7"';
		if($param['client']==7)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - Foreign 1</OPTION>';
		echo '<OPTION VALUE="8"';
		if($param['client']==8)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - Foreign 3</OPTION>';
		echo '<OPTION VALUE="9"';
		if($param['client']==9)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - Foreign 7</OPTION>';
		echo '<OPTION VALUE="10"';
		if($param['client']==10)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - Foreign 15</OPTION>';
		echo '<OPTION VALUE="11"';
		if($param['client']==11)
		{
			echo  'selected';
		}

		echo '>Old Buyers Reactivation - Foreign 30</OPTION>';
		echo '<OPTION VALUE="12"';
		if($param['client']==12)
		{
			echo  'selected';
		}

		echo '>All (India + Foreign)</OPTION>';
		echo '</SELECT>';		

echo ' &nbsp;
	  </TD> 
          </TR>
        </TABLE>';
        
	echo '</TD>
      </TR>';
      echo '<TR>
        
	<TD BGCOLOR="#EAEAEA"></TD><TD BGCOLOR="#EAEAEA"></TD>
	<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Report Type</TD>
        <TD BGCOLOR="#EAEAEA">
        <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
          <TR>
            ';
         echo '<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="NOR" ';
		if (isset($param['modid']) && $param['modid'] == 'NOR')
		{
		   
		   echo 'CHECKED';
		}
		echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">Regular Buyer Alert&nbsp;&nbsp;</TD>
		<TD><INPUT TYPE="RADIO" NAME="modid" VALUE="REM"';

		if (isset($param['modid']) && $param['modid'] == 'REM')
		{
			echo 'CHECKED';
		}

		echo '></TD>
		<TD STYLE="font-family:arial;font-size:12px;">Buyer Remarketing&nbsp;&nbsp;</TD>
		</TR>';
		echo '</TABLE></TABLE>';
		
   echo '<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
		<input type="hidden" name="action" value="sellstatus">
		<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
		</TD>
	</TR>
	</TABLE></FORM><br><br><br>';
	

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'sellstatus')
  {
         echo ' <TABLE>
			    <tbody><tr>
			    <td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:14px;color:#000090;" colspan="3"><b>Buyer Re-marketing Summary :</b></td></tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" ><B>&nbsp;&nbsp;Total Buyers</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >--</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;New Buyers</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$new_buyers_rec['COUNT(1)'].'</TD>
			    </tr>
			     <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;Buyers Downloaded</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$buyer_downloaded_rec['COUNT(1)'].'</TD>
			    </tr>
			     <tr>
			    <TD STYLE="font-family:arial;font-size:13px; color:#000090;"  ><B>&nbsp;&nbsp;Existing Buyers</B></TD>
			    </tr>
			     <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BL</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$existing_Buyer_bl_rec['COUNT(GLID)'].'</TD>
			    </tr>
			     <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enquiries</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$existing_Buyer_enq_rec['COUNT(GLID)'].'</TD>
			    </tr>
			    <tr>
			    <TD STYLE="font-family:arial;font-size:13px; color:#000090;"  ><B>&nbsp;&nbsp;Buyers Reactivated</B></TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BL</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$reactivated_buyer_bl_rec['COUNT(GLID)'].'</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enquiries</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$reactivated_buyer_enq_rec['COUNT(GLID)'].'</TD>
			    </tr></tbody></table><br><hr style="color:#EAEAEA">
			    ';
	echo '<TABLE>
			    <tbody><tr>
			    <td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:14px;color:#000090;" colspan="3"><b>Identified User Generated :</b></td></tr>
			    
			     <tr>
			    <TD STYLE="font-family:arial;font-size:13px; color:#000090;"  ><B>&nbsp;&nbsp;BL Generation</B></TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leads Generated</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$lead_generated_rec['SUM(CNT)'].'</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Leads Approved</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$lead_approved_rec['SUM(CNT)'].'</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Enquiries Generated</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$enq_generated_rec['COUNT(CNT)'].'</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Intent Generated</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$intent_generated_rec['SUM(CNT)'].'</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;"  ><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Converted To Approved BL</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >--</TD>
			    </tr>
			  </tbody></table><br><hr style="color:#EAEAEA">  
			    ';		     
	
	echo '<TABLE>
			    <tbody><tr>
			    <td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:14px;color:#000090;" colspan="3"><b>App Installation :</b></td></tr>
			     <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" ><B>&nbsp;&nbsp;No. Of App User</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >242212</TD>
			    </tr>
			     <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" ><B>&nbsp;&nbsp;App Installed From Mailing Activities</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$app_installed_rec['COUNT(1)'].'</TD>
			    </tr>
			    </tbody></table><br><hr style="color:#EAEAEA">';
	
	echo '<TABLE>
			    <tr>
			    <td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:14px;color:#000090;" colspan="3"><b>Email Stats :</b></td>
			    </tr></TABLE><br>';
	
	$start_date = $_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];
	$end_date = $_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];
	$start_date= date("Y-m-d", strtotime($start_date));
	$end_date = date("Y-m-d", strtotime($end_date));
	
	echo ' <TABLE bgcolor="#6495ED" WIDTH="100%">
			    <tbody><tr style="font-family: arial; padding-left:8px; font-size:15px;color:#000090;">
			    <td ><b>Date </b></td>
			    <td ><b>Mails Sent</b></td>
			    <td ><b>Mails Delivered </b></td>
			    <td ><b> Unique Open </b></td>
			    <td ><b> Unique Clicks </b></td>
			    <td ><b>Bounces </b></td>
			    <td ><b>Spam </b></td>
			    <td ><b>Blocked </b></td>
			    <td ><b>Unsubscribed </b></td>
			    <td ><b>Invalid Email </b></td>
			     </tr>';
	
	
	$sendgrid_india_all = "https://api.sendgrid.com/api/stats.get.json?api_user=tradeadmin@indiamart.com&api_key=motherindia41&start_date=$start_date&end_date=$end_date&category=Old%20Buyers%20Reactivation%20-%20India%201&category=Old%20Buyers%20Reactivation%20-%20India%203&category=Old%20Buyers%20Reactivation%20-%20India%2015";
	  $context = stream_context_create(array(
					'http' => array(
					    'ignore_errors' => true
					)
				    ));
	$json = file_get_contents($sendgrid_india_all,false,$context);
	$value = json_decode($json);
	$length = count($value);
//  	print_r($value);
	
	
	if($param['client']==13)
	{   $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    $len = $length/3;
	    for($i=0;$i<$len;$i++)
	      {
		$requests=0;
		$delivered =0;
		$open = 0;
		$click =0;
		$bounces = 0;
		$spam = 0;
		$block =0;
		$invalid = 0;
		$unsubscribed =0;
		  for($j=0;$j<$length;$j++)
		    {
		      $date = $value[$j]->date;
		      if($date == $start_date)
			{
			  $requests = $requests + $value[$j]->requests;
			  $delivered = $delivered + $value[$j]->delivered;
			  $open = $open + $value[$j]->unique_opens;
			  $click = $click + $value[$j]->unique_clicks;
			  $bounces = $bounces +$value[$j]->bounces;
			  $spam = $spam + $value[$j]->spamreports;
			  $block = $block + $value[$j]->blocked;
			  $unsubscribed = $unsubscribed + $value[$j]->unsubscribes;
			  $invalid = $invalid + $value[$j]->invalid_email;
			}
		    }
		  $requests_sum = $requests_sum + $requests; 
		  $delivered_sum = $delivered_sum + $delivered;
		  $open_sum = $open_sum + $open;
		  $click_sum = $click_sum + $click;
		  $bounces_sum = $bounces_sum + $bounces;
		  $spam_sum = $spam_sum + $spam;
		  $block_sum = $block_sum + $block;
		  $invalid_sum = $invalid_sum + $invalid;
		  $unsubscribed_sum = $unsubscribed_sum + $unsubscribed;
		    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$start_date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$open.'</td>
		      <td bgcolor="#F0E68C">'.$click.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spam.'</td>
		      <td bgcolor="#F0E68C">'.$block.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribed.'</td>
		      <td bgcolor="#F0E68C">'.$invalid.'</td>
		      </tr>';  
		  $datetime = new DateTime($start_date);
		  $datetime->modify('+1 day');
		  $start_date = $datetime->format('Y-m-d');
	    
		}
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';
	}
	
	if($param['client']==1)
	{	
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    for($i=0;$i<$length;$i++)
	      {
	        if($value[$i]->category  == 'Old Buyers Reactivation - India 1')
		  {  
		      $requests = $value[$i]->requests;
		      $delivered = $value[$i]->delivered;
		      $opens = $value[$i]->unique_opens;
		      $clicks = $value[$i]->unique_clicks;
		      $bounces = $value[$i]->bounces;
		      $spamreports = $value[$i]->spamreports;
		      $blocked = $value[$i]->blocked;
		      $unsubscribes = $value[$i]->unsubscribes;
		      $invalid_email = $value[$i]->invalid_email;
		      echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$value[$i]->date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$opens.'</td>
		      <td bgcolor="#F0E68C">'.$clicks.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spamreports.'</td>
		      <td bgcolor="#F0E68C">'.$blocked.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribes.'</td>
		      <td bgcolor="#F0E68C">'.$invalid_email.'</td>
		      </tr>';
		      $requests_sum = $requests_sum + $requests;
		      $delivered_sum = $delivered_sum + $delivered;
		      $open_sum = $open_sum + $opens;
		      $click_sum = $click_sum + $clicks;
		      $bounces_sum = $bounces_sum + $bounces;
		      $spam_sum = $spam_sum + $spamreports;
		      $block_sum = $block_sum + $blocked;
		      $invalid_sum = $invalid_sum + $invalid_email;
		      $unsubscribed_sum = $unsubscribed_sum + $unsubscribes;
		  }
		
	      }
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';
	      
	}
	
	if($param['client']==2)
	{
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    for($i=0;$i<$length;$i++)
	      {
	        if($value[$i]->category  == 'Old Buyers Reactivation - India 3')
		  {  
		      $requests = $value[$i]->requests;
		      $delivered = $value[$i]->delivered;
		      $opens = $value[$i]->unique_opens;
		      $clicks = $value[$i]->unique_clicks;
		      $bounces = $value[$i]->bounces;
		      $spamreports = $value[$i]->spamreports;
		      $blocked = $value[$i]->blocked;
		      $unsubscribes = $value[$i]->unsubscribes;
		      $invalid_email = $value[$i]->invalid_email;
		      echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$value[$i]->date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$opens.'</td>
		      <td bgcolor="#F0E68C">'.$clicks.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spamreports.'</td>
		      <td bgcolor="#F0E68C">'.$blocked.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribes.'</td>
		      <td bgcolor="#F0E68C">'.$invalid_email.'</td>
		      </tr>';
		      $requests_sum = $requests_sum + $requests;
		      $delivered_sum = $delivered_sum + $delivered;
		      $open_sum = $open_sum + $opens;
		      $click_sum = $click_sum + $clicks;
		      $bounces_sum = $bounces_sum + $bounces;
		      $spam_sum = $spam_sum + $spamreports;
		      $block_sum = $block_sum + $blocked;
		      $invalid_sum = $invalid_sum + $invalid_email;
		      $unsubscribed_sum = $unsubscribed_sum + $unsubscribes;
		  }
		
	      }
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';
	}
	if($param['client']==3)
	{
	   echo "Currently Old Buyers Reactivation - India 7 Category not present in Sendgrid";
	}
			    
	if($param['client']==4)
	{
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    for($i=0;$i<$length;$i++)
	      {
	        if($value[$i]->category  == 'Old Buyers Reactivation - India 15')
		  {  
		      $requests = $value[$i]->requests;
		      $delivered = $value[$i]->delivered;
		      $opens = $value[$i]->unique_opens;
		      $clicks = $value[$i]->unique_clicks;
		      $bounces = $value[$i]->bounces;
		      $spamreports = $value[$i]->spamreports;
		      $blocked = $value[$i]->blocked;
		      $unsubscribes = $value[$i]->unsubscribes;
		      $invalid_email = $value[$i]->invalid_email;
		      echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$value[$i]->date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$opens.'</td>
		      <td bgcolor="#F0E68C">'.$clicks.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spamreports.'</td>
		      <td bgcolor="#F0E68C">'.$blocked.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribes.'</td>
		      <td bgcolor="#F0E68C">'.$invalid_email.'</td>
		      </tr>';
		      $requests_sum = $requests_sum + $requests;
		      $delivered_sum = $delivered_sum + $delivered;
		      $open_sum = $open_sum + $opens;
		      $click_sum = $click_sum + $clicks;
		      $bounces_sum = $bounces_sum + $bounces;
		      $spam_sum = $spam_sum + $spamreports;
		      $block_sum = $block_sum + $blocked;
		      $invalid_sum = $invalid_sum + $invalid_email;
		      $unsubscribed_sum = $unsubscribed_sum + $unsubscribes;
		  }
		
	      }
		echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';
	}
	if($param['client']==5)
	{
	   echo "Currently Old Buyers Reactivation - India 30 Category not present in Sendgrid";
	}
	
	$start_date = $_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];
	$end_date = $_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];
	$start_date= date("Y-m-d", strtotime($start_date));
	$end_date = date("Y-m-d", strtotime($end_date));
	$sendgrid_foreign_all="https://api.sendgrid.com/api/stats.get.json?api_user=tradeadmin@indiamart.com&api_key=motherindia41&start_date=$start_date&end_date=$end_date&category=Old%20Buyers%20Reactivation%20-%20Foreign%201&category=Old%20Buyers%20Reactivation%20-%20Foreign%203&category=Old%20Buyers%20Reactivation%20-%20Foreign%2015";
	$json = file_get_contents($sendgrid_foreign_all,false,$context);
	$value = json_decode($json);
	$length = count($value);
	if($param['client']==6)
	{
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    $len = $length/3;
	    for($i=0;$i<$len;$i++)
	      {
		$requests=0;
		$delivered =0;
		$open = 0;
		$click =0;
		$bounces = 0;
		$spam = 0;
		$block =0;
		$invalid = 0;
		$unsubscribed =0;
		  for($j=0;$j<$length;$j++)
		    {
		      $date = $value[$j]->date;
		      if($date == $start_date)
			{
			  $requests = $requests + $value[$j]->requests;
			  $delivered = $delivered + $value[$j]->delivered;
			  $open = $open + $value[$j]->unique_opens;
			  $click = $click + $value[$j]->unique_clicks;
			  $bounces = $bounces +$value[$j]->bounces;
			  $spam = $spam + $value[$j]->spamreports;
			  $block = $block + $value[$j]->blocked;
			  $unsubscribed = $unsubscribed + $value[$j]->unsubscribes;
			  $invalid = $invalid + $value[$j]->invalid_email;
			}
		    }
		  $requests_sum = $requests_sum + $requests; 
		  $delivered_sum = $delivered_sum + $delivered;
		  $open_sum = $open_sum + $open;
		  $click_sum = $click_sum + $click;
		  $bounces_sum = $bounces_sum + $bounces;
		  $spam_sum = $spam_sum + $spam;
		  $block_sum = $block_sum + $block;
		  $invalid_sum = $invalid_sum + $invalid;
		  $unsubscribed_sum = $unsubscribed_sum + $unsubscribed;
		    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$start_date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$open.'</td>
		      <td bgcolor="#F0E68C">'.$click.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spam.'</td>
		      <td bgcolor="#F0E68C">'.$block.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribed.'</td>
		      <td bgcolor="#F0E68C">'.$invalid.'</td>
		      </tr>';  
		  $datetime = new DateTime($start_date);
		  $datetime->modify('+1 day');
		  $start_date = $datetime->format('Y-m-d');
	    
		}
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';

	}
	if($param['client']==7)
	{
	    	
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    for($i=0;$i<$length;$i++)
	      {
	        if($value[$i]->category  == 'Old Buyers Reactivation - Foreign 1')
		  {  
		      $requests = $value[$i]->requests;
		      $delivered = $value[$i]->delivered;
		      $opens = $value[$i]->unique_opens;
		      $clicks = $value[$i]->unique_clicks;
		      $bounces = $value[$i]->bounces;
		      $spamreports = $value[$i]->spamreports;
		      $blocked = $value[$i]->blocked;
		      $unsubscribes = $value[$i]->unsubscribes;
		      $invalid_email = $value[$i]->invalid_email;
		      echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$value[$i]->date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$opens.'</td>
		      <td bgcolor="#F0E68C">'.$clicks.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spamreports.'</td>
		      <td bgcolor="#F0E68C">'.$blocked.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribes.'</td>
		      <td bgcolor="#F0E68C">'.$invalid_email.'</td>
		      </tr>';
		      $requests_sum = $requests_sum + $requests;
		      $delivered_sum = $delivered_sum + $delivered;
		      $open_sum = $open_sum + $opens;
		      $click_sum = $click_sum + $clicks;
		      $bounces_sum = $bounces_sum + $bounces;
		      $spam_sum = $spam_sum + $spamreports;
		      $block_sum = $block_sum + $blocked;
		      $invalid_sum = $invalid_sum + $invalid_email;
		      $unsubscribed_sum = $unsubscribed_sum + $unsubscribes;
		  }
		
	      }
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';
	}
	
	if($param['client']==8)
	{
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    for($i=0;$i<$length;$i++)
	      {
	        if($value[$i]->category  == 'Old Buyers Reactivation - Foreign 3')
		  {  
		      $requests = $value[$i]->requests;
		      $delivered = $value[$i]->delivered;
		      $opens = $value[$i]->unique_opens;
		      $clicks = $value[$i]->unique_clicks;
		      $bounces = $value[$i]->bounces;
		      $spamreports = $value[$i]->spamreports;
		      $blocked = $value[$i]->blocked;
		      $unsubscribes = $value[$i]->unsubscribes;
		      $invalid_email = $value[$i]->invalid_email;
		      echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$value[$i]->date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$opens.'</td>
		      <td bgcolor="#F0E68C">'.$clicks.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spamreports.'</td>
		      <td bgcolor="#F0E68C">'.$blocked.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribes.'</td>
		      <td bgcolor="#F0E68C">'.$invalid_email.'</td>
		      </tr>';
		      $requests_sum = $requests_sum + $requests;
		      $delivered_sum = $delivered_sum + $delivered;
		      $open_sum = $open_sum + $opens;
		      $click_sum = $click_sum + $clicks;
		      $bounces_sum = $bounces_sum + $bounces;
		      $spam_sum = $spam_sum + $spamreports;
		      $block_sum = $block_sum + $blocked;
		      $invalid_sum = $invalid_sum + $invalid_email;
		      $unsubscribed_sum = $unsubscribed_sum + $unsubscribes;
		  }
		
	      }
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';
	}
	if($param['client']==9)
	{
	    echo 'Currently Old Buyers Reactivation - Foreign 7 Category not present in Sendgrid';
	}
	if($param['client']==10)
	{ 
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    for($i=0;$i<$length;$i++)
	      {
	        if($value[$i]->category  == 'Old Buyers Reactivation - Foreign 15')
		  {  
		      $requests = $value[$i]->requests;
		      $delivered = $value[$i]->delivered;
		      $opens = $value[$i]->unique_opens;
		      $clicks = $value[$i]->unique_clicks;
		      $bounces = $value[$i]->bounces;
		      $spamreports = $value[$i]->spamreports;
		      $blocked = $value[$i]->blocked;
		      $unsubscribes = $value[$i]->unsubscribes;
		      $invalid_email = $value[$i]->invalid_email;
		      echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$value[$i]->date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$opens.'</td>
		      <td bgcolor="#F0E68C">'.$clicks.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spamreports.'</td>
		      <td bgcolor="#F0E68C">'.$blocked.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribes.'</td>
		      <td bgcolor="#F0E68C">'.$invalid_email.'</td>
		      </tr>';
		      $requests_sum = $requests_sum + $requests;
		      $delivered_sum = $delivered_sum + $delivered;
		      $open_sum = $open_sum + $opens;
		      $click_sum = $click_sum + $clicks;
		      $bounces_sum = $bounces_sum + $bounces;
		      $spam_sum = $spam_sum + $spamreports;
		      $block_sum = $block_sum + $blocked;
		      $invalid_sum = $invalid_sum + $invalid_email;
		      $unsubscribed_sum = $unsubscribed_sum + $unsubscribes;
		  }
		
	      }
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';
	}
	
	if($param['client']==11)
	{ 
	    echo 'Currently Old Buyers Reactivation - Foreign 30 Category not present in Sendgrid';
	}
	
	
	$start_date = $_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];
	$end_date = $_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];
	$start_date= date("Y-m-d", strtotime($start_date));
	$end_date = date("Y-m-d", strtotime($end_date));
	$sendgrid_foreign_all="https://api.sendgrid.com/api/stats.get.json?api_user=tradeadmin@indiamart.com&api_key=motherindia41&start_date=$start_date&end_date=$end_date&category=Old%20Buyers%20Reactivation%20-%20Foreign%201&category=Old%20Buyers%20Reactivation%20-%20Foreign%203&category=Old%20Buyers%20Reactivation%20-%20Foreign%2015&category=Old%20Buyers%20Reactivation%20-%20India%201&category=Old%20Buyers%20Reactivation%20-%20India%203&category=Old%20Buyers%20Reactivation%20-%20India%2015";
	$json = file_get_contents($sendgrid_foreign_all,false,$context);
	$value = json_decode($json);
	$length = count($value);
	if($param['client']==12)
	{
	    $requests_sum=0;
	    $delivered_sum =0;
	    $open_sum = 0;
	    $click_sum =0;
	    $bounces_sum = 0;
	    $spam_sum = 0;
	    $block_sum =0;
	    $invalid_sum = 0;
	    $unsubscribed_sum =0;
	    
	    $len = $length/6;
	    for($i=0;$i<$len;$i++)
	      {
		$requests=0;
		$delivered =0;
		$open = 0;
		$click =0;
		$bounces = 0;
		$spam = 0;
		$block =0;
		$invalid = 0;
		$unsubscribed =0;
		  for($j=0;$j<$length;$j++)
		    {
		      $date = $value[$j]->date;
		      if($date == $start_date)
			{
			  $requests = $requests + $value[$j]->requests;
			  $delivered = $delivered + $value[$j]->delivered;
			  $open = $open + $value[$j]->unique_opens;
			  $click = $click + $value[$j]->unique_clicks;
			  $bounces = $bounces +$value[$j]->bounces;
			  $spam = $spam + $value[$j]->spamreports;
			  $block = $block + $value[$j]->blocked;
			  $unsubscribed = $unsubscribed + $value[$j]->unsubscribes;
			  $invalid = $invalid + $value[$j]->invalid_email;
			}
		    }
		  $requests_sum = $requests_sum + $requests; 
		  $delivered_sum = $delivered_sum + $delivered;
		  $open_sum = $open_sum + $open;
		  $click_sum = $click_sum + $click;
		  $bounces_sum = $bounces_sum + $bounces;
		  $spam_sum = $spam_sum + $spam;
		  $block_sum = $block_sum + $block;
		  $invalid_sum = $invalid_sum + $invalid;
		  $unsubscribed_sum = $unsubscribed_sum + $unsubscribed;
		    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#7FFFD4">'.$start_date.' </td>';
		    echo '<td bgcolor="#F0E68C">'.$requests.' </td>
		      <td bgcolor="#F0E68C">'.$delivered.'</td>
		      <td bgcolor="#F0E68C">'.$open.'</td>
		      <td bgcolor="#F0E68C">'.$click.'</td>
		      <td bgcolor="#F0E68C">'.$bounces.'</td>
		      <td bgcolor="#F0E68C">'.$spam.'</td>
		      <td bgcolor="#F0E68C">'.$block.'</td>
		      <td bgcolor="#F0E68C">'.$unsubscribed.'</td>
		      <td bgcolor="#F0E68C">'.$invalid.'</td>
		      </tr>';  
		  $datetime = new DateTime($start_date);
		  $datetime->modify('+1 day');
		  $start_date = $datetime->format('Y-m-d');
	    
		}
	    echo '<tr BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;">
			    <td bgcolor="#90EE90"> Total </td>';
		    echo '<td bgcolor="#90EE90">'.$requests_sum.' </td>
		      <td bgcolor="#90EE90">'.$delivered_sum.'</td>
		      <td bgcolor="#90EE90">'.$open_sum.'</td>
		      <td bgcolor="#90EE90">'.$click_sum.'</td>
		      <td bgcolor="#90EE90">'.$bounces_sum.'</td>
		      <td bgcolor="#90EE90">'.$spam_sum.'</td>
		      <td bgcolor="#90EE90">'.$block_sum.'</td>
		      <td bgcolor="#90EE90">'.$unsubscribed_sum.'</td>
		      <td bgcolor="#90EE90">'.$invalid_sum.'</td>
		      </tr></tbody></table>';

	}
    
    echo '<br><hr style="color:#EAEAEA"><TABLE>
			    <tbody><tr>
			    <td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:14px;color:#000090;" colspan="3"><b>Rejection Rate :</b></td></tr>
			     <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" ><B>&nbsp;&nbsp;Total (Lead + Enquiries)</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$rejection_total_rec['COUNT(1)'].'</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" ><B>&nbsp;&nbsp;Lead</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$rejection_total_rec['COUNT(1)'].'</TD>
			    </tr>
			    </tbody></table><br><hr style="color:#EAEAEA">';   
    echo '<TABLE>
			    <tbody><tr>
			    <td bgcolor="#EAEAEA" style="font-family: arial; padding-left:8px; font-size:14px;color:#000090;" colspan="3"><b>Approved Lead Conversion :</b></td></tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" ><B>&nbsp;&nbsp;Lead Sold</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$lead_sold_rec['COUNT(DISTINCTETO_OFR_DISPLAY_ID)'].'</TD>
			    </tr>
			    <tr>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:12px;" ><B>&nbsp;&nbsp;Total Transaction</B></TD>
			    <TD BGCOLOR="#FEFCFF" STYLE="font-family:arial;font-size:14px;" >'.$total_transaction_rec['COUNT(1)'].'</TD>
			    </tr>
			    </tbody></table><br><hr style="color:#EAEAEA">';
	
	  
  
  }


?>