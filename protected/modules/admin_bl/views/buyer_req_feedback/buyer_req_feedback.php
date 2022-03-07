<?php
    
    $Second = '';
    $Minute = '';
    $Hour = '';
    $Day = '';
    $Month = '';
    $Year = '';

    $time_arr = localtime();
    $Second = $time_arr[0];
    $Minute = $time_arr[1];
    $Hour = $time_arr[2];
    $Day = $time_arr[3];
    $Month = $time_arr[4] + 1;
    $Year = $time_arr[5] + 1900;
    
    $complete_time = "$Year-$Month-$Day-$Hour-$Minute-$Second";
    $Day = $Day."/".($Month)."/".($Year);
    $Hour_full = $Hour.":".$Minute.":".$Second;
    $timeArray = array("0"=>"$Day $Hour_full", "1"=>$Hour, "2"=>$complete_time);
    $timeArr = explode('-', $timeArray[2]);
    $curr_sec = $timeArr[5];
    $curr_min = $timeArr[4];
    $curr_hour = $timeArr[3];
    $curr_day = $timeArr[2];
    $curr_month = $timeArr[1];
    $curr_year = $timeArr[0];

	$fields = array('edate_day','edate_month','edate_year','sdate_day','sdate_month','sdate_year');
	$param = array();
	foreach ($fields as $field)
	{
		if(isset($_POST[$field]) && $_POST[$field])
		{
			$param[$field]=$_POST[$field];
		}
		else
		{
			$param[$field]='';
		}
	}

	$curr_month = $curr_month+1;

	if($curr_month < 10)
	{
		$curr_month = '0'.$curr_month;
	}

	
	$curr_year=$curr_year+1900;
	$this->pageTitle=Yii::app()->name . ' -Buyer Requirement Fulfillment Feedback';
	
	$months = array('01' => "January", '02' => "February", '03' => "March", '04' => "April", '05' => "May", '06' => "June", '07' => "July", '08' => "August", '09' => "September", '10' => "October", '11' => "November", '12' => "December");
	 print '<html><head><style>.table_report td{font-family:arial;font-size:12px}
        .table_report td{padding:4px 6px 4px 6px;}
        .table_report td.hd1{background:#d4e8ff;font-weight:bold;border:1px solid #FFF;padding:5px 6px 5px 6px;}
        .table_report td.hd1 span{color:#0000ff;font-weight:normal;}
	.buttonHover{color:#0000ff;border:none;background:#fff;}
	.buttonHover:hover{color:#0000ff;cursor:pointer;border:none;background:#fff;}
 	</style>
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
 	
 	</head><script language="javascript">
          <!--
 	function checkBuyForm()
 	{

 	        if(document.formreport.sdate_day.value == 0 || document.formreport.sdate_month.value == 0 || document.formreport.sdate_year.value == 0)
 		{
 			alert("Fill Start Date");
 			return false;
 		}

                 if(document.formreport.edate_day.value == 0 || document.formreport.edate_month.value == 0 || document.formreport.edate_year.value == 0)
 		{
 			alert("Fill End Date");
 			return false;
 		}

 		if(document.formreport.sdate_month.value == 2 || document.formreport.sdate_month.value == 4
 		|| document.formreport.sdate_month.value == 6|| document.formreport.sdate_month.value == 9|| document.formreport.sdate_month.value == 11)
 		{
 			if(document.formreport.sdate_day.value == 31)
 			{
 			alert("This date does not exists");
 			return false;
 			}
 		}
 		if(document.formreport.edate_month.value == 2 || document.formreport.edate_month.value == 4
 		|| document.formreport.edate_month.value == 6|| document.formreport.edate_month.value == 9|| document.formreport.edate_month.value == 11)
 		{
 			if(document.formreport.edate_day.value == 31)
 			{
 			alert("This date does not exists");
 			return false;
 			}
 		}
 	}
 	//-->
 	</script><body topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">';

	$startday='';
	$endday='';
	$startmonth='';
	$endmonth='';
	$startyear='';
	$endyear='';

	for($day = 1; $day<32; $day++)
	{
    if(strlen($day) == 1)
    {
	   	$day='0'.$day;
    }

		$startday .= "<option value='$day'";
		$endday .= "<option value='$day'";

		if ($param['sdate_day'] == $day)
		{
			$startday .= ' selected ';
		}

		if($param['edate_day'] == $day)
		{
			$endday .= ' selected ';
		}

		if($day == $curr_day && !($param['sdate_day'] || $param['edate_day']))
		{
			$startday .= ' selected ';
			$endday .= ' selected ';
		}

		$startday .= ">$day</option\">";

		$endday .= ">$day</option\">";
	}

	foreach ($months as $key=>$month)
	{

    if(strlen($key) == 1)
    {
		  $key = '0'.$key;
    }

		$startmonth .= "<option value=\"$month\"";

		$endmonth .= "<option value=\"$month\"";

		if($param['sdate_month'] == $month)
		{
			$startmonth.= " selected ";
		}

		if($param['edate_month'] == $month)
		{
			$endmonth .= " selected ";
		}

		if($month == $curr_month && !($param['sdate_month'] || $param['edate_month']))
		{
			$startmonth.= " selected ";
			$endmonth.= " selected ";
		}

		$startmonth.=">$month</option\">";

		$endmonth.= ">$month</option\">";
	}

	for($year=2012;$year<2016;$year++) 
  {
		$startyear .= "<option value=\"$year\"";
		$endyear.= "<option value=\"$year\"";

		if ($param['sdate_year'] == $year)
		{
			$startyear.= " selected ";
		}

		if($param['edate_year'] == $year)
		{
			$endyear.= " selected ";
		}

		if($year == $curr_year && !($param['sdate_year'] || $param['edate_year']))
		{
			$startyear.= ' selected ';
			$endyear.= ' selected ';
		}

		$startyear.= ">$year</option\">";
		$endyear.= ">$year</option\">";
	}

	echo '<form name="formreport" method="post" action="index.php?r=admin_bl/Buyer_req_feedback/Index&mid=3429" style="margin-top:0;margin-bottom:0;" onsubmit="return checkBuyForm();"><table width="100%" border="0" cellpadding="0" cellspacing="0" height="30"><tr><td bgcolor="#00479e" align="center" style="font-family:arial;font-size:14px;font-weight:bold;color:#fff"><b>Buyer Requirement Fulfillment Feedback - Report</b></td></tr></table><br>
      	<table border="0" cellpadding="0" cellspacing="1" align="center"><tr><td bgcolor="#ccccff" style="font-family:arial;font-size:12px;font-weight:bold;" width="100" height="30">&nbsp;select period</td><td style="font-family:arial;font-size:12px;font-weight:bold;"bgcolor="#eaeaea"><table border="0" cellpadding="3" cellspacing="0"><tr><td><select name="sdate_day" size="1"><option value="0">day</option>'.$startday.'</select></td><td><select name="sdate_month" size="1"><option value="0">month</option>'.$startmonth.'</select></td><td><select name="sdate_year" size="1"><option value="0">year</option>'.$startyear.'</select></td><td>&nbsp;to&nbsp;</td><td><select name="edate_day" size="1"><option value="0">day</option>'.$endday.'</select></td><td><select name="edate_month" size="1"><option value="0">month</option>'.$endmonth.'</select></td><td><select name="edate_year" size="1"><option value="0">year</option>'.$endyear.'</select></td></tr></tbody></table></td>
        <td bgcolor="#ccccff" style="padding:5px"><input type="submit" name="submit" id="submit" value=" Generate Report " style="font-size:13px;font-family:arial;font-weight:bold;padding:5px;"></td></tr></table></td></td></tr></tbody></table></form>';

    if(isset($_POST) && !empty($_POST))
    {
    	$startdate = $_POST['sdate_day'].'-'.$_POST['sdate_month'].'-'.$_POST['sdate_year'];
    	$enddate = $_POST['edate_day'].'-'.$_POST['edate_month'].'-'.$_POST['edate_year'];
    }

	if(isset($_POST['submit']) && $_POST['submit'])
	{
  		echo '<div align="center"><style>';
    echo '.tables{border-collapse:collapse;}';
    echo '.tables td{border:1px solid #dcdcdc;font-family:arial;font-size:13px;}';
    echo '</style>';
    echo '<p style="font-family:arial;font-size:14px;font-weight:bold;margin: 10px 0 5px 0;"><b>Detailed Report</b></p>';
    echo '<table cellspacing="0" cellpadding="5" border="0" class="tables">';
    echo '<tbody><tr><td style="color:#FFF; background:#003366; padding:5px; text-align:right"><b>S&#46;No&#46;</b></td>';
    echo '<td style="color:#FFF; background:#003366; padding:5px;"><b>PARAMETER</b></td>';
    echo '<td style="color:#FFF; background:#003366; padding:5px;"><b>VALUE</b></td></tr>';

    $rows = oci_fetch_array($sth, OCI_BOTH);
    $i=0;
    $paraArr = array(
//    '<b>Unique Suppliers with at Least 1 Maturity<b>',
//    '<b>Buy Lead Generated Through Paid Enq. Campaign</b>',
//    '&nbsp; &nbsp; Approved Buy Lead',
//    '<b>Total Enriched Feedback Received</b>',
//    '&nbsp; &nbsp; Call &#45; Provided by buyer on call',
//    '&nbsp; &nbsp; Online &#45; Filled by buyer',
//    '&nbsp; &nbsp; Verified on call',
      '<b style="color:#FFF;background:#003366;display:block;padding:5px;">DETAILED SUMMARY</b>',
      '<b>Total Feedback Received</b>',
      '<b>Click on Need more Supplier</b>',
      '<b>&nbsp; &nbsp; Requirement Over Feedback</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Click(111)</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Submit(GlusrId)</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Click(222)</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Submit(-999)</b>',
      '<b>&nbsp; &nbsp; Requirement under Negotiation Feedback</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Submit(-555)</b>',
      '<b>&nbsp; &nbsp;  Requirement Postpone Feedback</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Click(-888)</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; We didn&#39;t receive final order from our client&#46</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Supplier didn&#39;t respond&#46</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; We wanted price&#47;quotation only&#46</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Other</b>',   
      '<b>&nbsp; &nbsp; Requirement Push to Top (Unique)</b>',
      '<b>&nbsp; &nbsp; BL Generated via Paid feedback mailer</b>',
      '<b>&nbsp; &nbsp;  Approved Buy Leads via Paid feedback mailer</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; <u>Requirement Over by IndiaMART Supplier</u>',
      '&nbsp; &nbsp; &nbsp; &nbsp; <u>Requirement Over by IndiaMART Supplier</u> &#40;<i><font face="Calibri"
       color="#0000FF">Verified</font></i>&#41;',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Overall ASTBUY',
       '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through ASTBUY</b>',
       '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through Paid Supplier',
       '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through VFCP Supplier',
       '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through Free Supplier',
       '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through INSTANT</b>',
       '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through Paid Supplier',
       '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through VFCP Supplier',
       '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through Free Supplier',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through BUYLEAD',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through Direct Enquiry',
      '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through Paid Supplier</i>',
      '<i>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Through Free Supplier</i>',
      '&nbsp; &nbsp; &nbsp; &nbsp; <u>Requirement Over by Other Supplier</u>',
      '<b>Unique Suppliers with at Least 1 Maturity<b>',
      '<b>&nbsp; &nbsp; Requirement Feedback By Source</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; MY.IndiaMART',
      '&nbsp; &nbsp; &nbsp; &nbsp; EMKTG Mails',
//    '&nbsp; &nbsp; &nbsp; &nbsp; Buyers Help Team',
//    '&nbsp; &nbsp; &nbsp; &nbsp; BL Complaint Team',
      '<b>&nbsp; &nbsp; Total Buy Requirement Push to Top</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; Through Admin',
      '&nbsp; &nbsp; &nbsp; &nbsp; Through MY',
      '&nbsp; &nbsp; &nbsp; &nbsp; Through Buy Lead Feedback Email Campaign Only',
      '&nbsp; &nbsp; &nbsp; &nbsp; Through All Emails',
      '<b>&nbsp; &nbsp; Push to Top Repeat:</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; Once in a Week',
      '&nbsp; &nbsp; &nbsp; &nbsp; 2 to 5 Time in a Week',
      '&nbsp; &nbsp; &nbsp; &nbsp; 6 to 10 Time in a Week',
      '&nbsp; &nbsp; &nbsp; &nbsp; &gt; 10 Time in a Week',
      '<b>&nbsp; &nbsp; Region Wise Total Feedback Received</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; India',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign',
//    '<b>Extended Feedback Data</b>',
//    '&nbsp; &nbsp; Supplier Rating',
//    '&nbsp; &nbsp; Order Value',
//    '<i><font face="Calibri" color="#0000FF">&nbsp; &nbsp; &nbsp; &nbsp; Verified</i></font>',
//    '&nbsp; &nbsp; Quantity',
//    '<i><font face="Calibri" color="#0000FF">&nbsp; &nbsp; &nbsp; &nbsp; Verified</i></font>',
//    '&nbsp; &nbsp; Frequency',
//    '<i><font face="Calibri" color="#0000FF">&nbsp; &nbsp; &nbsp; &nbsp; Verified</i></font>',
//    '&nbsp; &nbsp; Purchase Purpose',
//    '<i><font face="Calibri" color="#0000FF">&nbsp; &nbsp; &nbsp; &nbsp; Verified</i></font>',
      '<b style="color:#FFF;background:#003366;display:block;padding:5px;">FEEDBACKS VERIFIED ON CALL</b>',
      '<b style="background:#83CAFF; padding:5px; display:block">Total Buy Lead Feedback Received</b>',
//    '<b><i>by internal teams &#40;buyershelp team&#41;</i></b>',
      '<b>Feedback by type</b>',
      '&nbsp; &nbsp; Requirement Over',
      '&nbsp; &nbsp; Requirement Postponed',
      '&nbsp; &nbsp; Under Negotiation',
      '&nbsp; &nbsp; Requirement Push to Top (Unique)',
      '<b>Feedback by Location</b>',
      '&nbsp; &nbsp; Foreign',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign Requirement Over',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign Requirement Postponed',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign Under Negotiation',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign PTT',
      '&nbsp; &nbsp; India',
      '<b>Non Callable Data</b> (Retail+Spam+Not to be Called)',
//    '&nbsp; &nbsp; Retail Enquiry',
//    '&nbsp; &nbsp; Spam',
//    '&nbsp; &nbsp; Not to be called &#40;Packers &amp; Movers&#47;Travel&#47;Incomplete Requirement&#41;',
      '<b>Callable Data</b>',
      '<b>&nbsp; &nbsp; Pending Call Data</b>',
      '<b>&nbsp; &nbsp; Called Data</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; Verified Feedback</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correct Feedback Received</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Selected IndiaMART Supplier',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Clicked IndiaMART Supplier',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly selected requirement postponed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Selected Other Supplier',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Other Supplier Selected &amp; disclosed right supplier &amp; Order yet not Placed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Clicked Other Supplier',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Rightly Selected Negotiating',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Rightly Clicked Negotiating',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrong Feedback Received</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Selected IndiaMART But purchased through Other',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrong supplier selected &amp; correct supplier disclosed &amp; order yet not placed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Clicked IndiaMART Supplier But purchased through Other',
       '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on postponed but requirement is Over',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on postponed but Requirement is still
      active&#47 negotiating',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on Requirement over but requirement is still active&#47 negotiating',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on Requirement over but requirement is
       postponed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Selected Other Supplier But purchased through IndiaMART',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Selected Negotiation',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; No supplier selected but disclosed right supplier &amp; order yet not placed',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Not Verified &#40;call not connected or buyer unable to verify&#41;</b>',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Retry Call Back',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Unable to verify',
      '<b style="background:#83CAFF; padding:5px; display:block">Total Enquiries Feedback Received &#45; Buyers Sent Enquiries to Paid Suppliers</b>',
      '<b>Feedback by type</b>',
      '&nbsp; &nbsp; Requirement Over',
      '&nbsp; &nbsp; Requirement Postponed',
      '&nbsp; &nbsp; Under Negotiation',
//    '&nbsp; &nbsp; Under Negotiation',
      '&nbsp; &nbsp; BL Generated via Paid feedback mailer',
      '<b>Feedback by Location</b>',
      '&nbsp; &nbsp; Foreign',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign Requirement Over',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign Requirement Postponed',
      '&nbsp; &nbsp; &nbsp; &nbsp; Foreign Under Negotiation',
      '&nbsp; &nbsp; &nbsp; &nbsp; BL Generated via Paid feedback mailer (Foreign)',

      '&nbsp; &nbsp; India',
      '<b>Non Callable Data</b> (Retail+Spam+Not to be Called)',
//    '&nbsp; &nbsp; Retail Enquiry',
//    '&nbsp; &nbsp; Spam',
//    '&nbsp; &nbsp; Not to be called &#40;Packers &amp; Movers&#47;Travel&#47;Incomplete Requirement&#41;',
      '<b>Callable Data</b>',
      '<b>&nbsp; &nbsp; Pending Call Data</b>',
      '<b>&nbsp; &nbsp; Called Data</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; Verified Feedback</b>',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correct Feedback Received</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Selected IndiaMART Supplier',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Clicked IndiaMART Supplier',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly selected requirement postponed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Selected Other Supplier',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Other Supplier Selected &amp; disclosed right supplier &amp; Order yet not Placed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Correctly Clicked Other Supplier',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Rightly Selected Negotiating',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Rightly Clicked Negotiating',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrong Feedback Received</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Selected IndiaMART But purchased through Other',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrong supplier selected &amp; correct supplier disclosed &amp; order yet not placed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Clicked IndiaMART Supplier But purchased through Other',
       '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on postponed but requirement is Over',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on postponed but Requirement is still
      active&#47 negotiating',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on Requirement over but requirement is still active&#47 negotiating',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly clicked on Requirement over but requirement is
       postponed',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Selected Other Supplier But purchased through IndiaMART',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Wrongly Selected Negotiation',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; No supplier selected but disclosed right supplier &amp; order yet not placed',
      '<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Not Verified &#40;call not connected or buyer unable to verify&#41;</b>',
//    '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Retry Call Back',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Unable to verify',
      '<b style="background:#83CAFF; padding:5px; display:block">PNS FEEDBACK DETAILS</b>',
//    '<b>&nbsp; &nbsp; Total PNS Buyers Vs. Buyers Eligible for Feedback</b>',
      '<b>&nbsp; &nbsp; BL Generated via PNS feedback mailer</b>',
      '<b style="background:#83CAFF; padding:5px; display:block">Requirement Over by IM supplier (FOR PAID & BL) CUST-TYPE DETAILS</b>',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Leader',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Star',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Ts Catalog',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Catalog',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; PNS Defaulter',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Email Defaulter',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; MarketPlace Verified',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Free Verified',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Marketplace',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Old Catalog',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Qualified FCP',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Free Catalog',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Demoted FCP',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Temp Block',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; OthersPaid',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Freelist',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Disabled Company',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Mkt PNS Defaulter',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; FCP PNS Defaulter',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Travel VFCP',
          '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Portal',
      '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; NULL',  
      
    );

    $row=3;

    for($i=0;$i<count($paraArr);$i++)
    {
      echo '<tr><td style="text-align:right">';
      $count = $i;
      echo $count+2;
      echo "</td><td>$paraArr[$i]</td><td>";
      echo "$rows[$i]";
      echo '</td></tr>';
      $row++;
    }

    echo '</table><br><br></div></br>';

	}

	print '</body></html>';
	
?>