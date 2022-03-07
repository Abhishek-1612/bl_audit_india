<?php


 
echo '<html>
<head>
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
</head>
<body>


<form name="blform" id="blform" method="post" action="index.php?r=admin_bl/Bl_common_report/Index&mid=3430">
	<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" width="100%">
  	<tr>
	<td bgcolor="#EAEAEA" STYLE="font-size:16px" align="center"><b>BuyLead Common Report</b></td>
	</tr>
	<tr>
   	<td class="admintext1" align="left" style="padding-left: 8px; padding-top: 8px;" bgcolor="#FFFFFF" width="60%" valign="top"><table cellspacing="0" cellpadding="3" border="0">
	<tbody><tr>
        <td bgcolor="#CCCCFF" STYLE="font-size:12px"><b>Select Period</b></td>';
	
	list($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
	$curr_month=$curr_month+1;
	if($curr_month < 10)
	{
		$curr_month='0'.$curr_month;
	}
	$curr_year=$curr_year+1900;

       if(isset($_REQUEST['s_day']))
		{
			$curr_day = $_REQUEST['s_day'];
			$curr_month = $_REQUEST['s_month'];
			$curr_year = $_REQUEST['s_year'];
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

	echo '<td><select size="1" name="s_day" id="s_day">';
	
	foreach(range(1,31) as $day)
	{       
	        if($day < 10)
		{
		$day = "0$day" ;
		}
		if($day == $curr_day)
		{
			echo '<option value="'.$day.'" selected>'.$day.'</option>';
		}
		else
		{
			echo '<option value="'.$day.'">'.$day.'</option>';
		}
	}
	echo '</select></td>';
	echo '<td><select size="1" name="s_month" id="s_month">';
	
	foreach(range(1,12) as $month)
	{     
	        if($month < 10)
		{
		$month = "0$month" ;
		}
		if($curr_month == $month)
		{
			echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
		}
		else
		{
			echo '<option value="'.$month.'">'.$months[$month].'</option>';
		}
	}
	echo '</select></td>';
	echo '<td><select size="1" name="s_year" id="s_year">';
	
	foreach(range(($curr_year-5),($curr_year+5)) as $year)
	{
		if($curr_year == $year)
		{
			echo '<option value="'.$year.'" selected>'.$year.'</option>';
		}
		else
		{
			echo '<option value="'.$year.'">'.$year.'</option>';
		}
	}
	echo '</select></td>';

		if(isset($_REQUEST['e_day']))
		{
			$curr_day = $_REQUEST['e_day'];
			$curr_month = $_REQUEST['e_month'];
			$curr_year = $_REQUEST['e_year'];
		}
	
	echo '<td> To </td>';
	echo '<td><select size="1" name="e_day" id="e_day">';
	foreach(range(1,31) as $day)
	{   
	        if($day < 10)
		{
		$day = "0$day" ;
		}
		if($day == $curr_day)
		{
			echo '<option value="'.$day.'" selected>'.$day.'</option>';
		}
		else
		{
			echo '<option value="'.$day.'">'.$day.'</option>';
		}
	}
	echo '</select></td>';
	echo '<td><select size="1" name="e_month" id="e_month">';

	foreach(range(1,12) as $month)
	{      
	        if($month < 10)
		{
		$month = "0$month" ;
		}
		if($curr_month == $month)
		{
			echo '<option value="'.$month.'" selected>'.$months[$month].'</option>';
		}
		else
		{
	            echo '<option value="'.$month.'">'.$months[$month].'</option>';
		}
	}
	echo '</select></td>';
	echo '<td><select size="1" name="e_year" id="e_year">';
	
	foreach(range(($curr_year-5),($curr_year+5)) as $year)
	{
		if($curr_year == $year)
		{
			echo '<option value="'.$year.'" selected>'.$year.'</option>';
		}
		else
		{
			echo '<option value="'.$year.'">'.$year.'</option>';
		}
	}
echo '</select></td>
<TD WIDTH="100" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;MODID</TD>
		<TD BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
				<SELECT NAME="modid" SIZE="1" style="width:200px;">
				<OPTION VALUE="';
				if($modval == 'all')
				{
					echo 'all" SELECTED="SELECTED"';
				}
				else
				{
					echo 'all"';
				}
				echo '>All</OPTION>
				
			';
		
	
		while ( $rec = oci_fetch_assoc($sth)) 
		{
			echo '<OPTION VALUE="';
			if($modval == $rec['GL_MODULE_ID'])
			{
				echo $modval.'" SELECTED="SELECTED"';	
			}
			else
			{
				echo $rec['GL_MODULE_ID'].'"';
			}
		   echo '>'. $rec['GL_MODULE_ID'].'</OPTION>';
		}
		
		
		//echo '';


echo '</select></TD>
		</TR>
		</TABLE>
		</TD>';


echo '</td><td style= "width:320px">
<input name="glusr_submit" value="Generate Report" style="font-size:11px; padding:2px 10px; font-weight:bold;  cursor:pointer;" type="SUBMIT">
</td>
</tr>
</tbody></td>
</tr></table></table>
</form></body></html>';


?>