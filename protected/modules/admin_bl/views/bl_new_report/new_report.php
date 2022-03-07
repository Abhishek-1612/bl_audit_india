<?php 
 
 
	$start11_date=date("Y-m-d h:i:s");
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
	  $glid=isset($_REQUEST['glid']) ? $_REQUEST['glid'] : '';

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

	
	echo '<HTML><HEAD><TITLE>Buy Lead NEW Report</TITLE>
	<script>
       function checkform(form)
       {
     if(document.searchForm.glid.value == "" || document.searchForm.glid.value == null)
     {
     alert("Please enter GL user ID.");
     
     return false;
     }
       
       }
       
       </script>
	
	</HEAD>
	<BODY>

	<FORM name="searchForm" METHOD="post" ACTION="index.php?r=admin_bl/Bl_new_report/Index" STYLE="margin-top:0;margin-bottom:0;" >
    <TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="2">
      <TR>
        <TD BGCOLOR="#F4F4F4" HEIGHT="30" COLSPAN="9" ALIGN="CENTER" 
        STYLE="font-family:arial;font-size:14px;font-weight:bold;">Buy Lead New Report</TD>
      </TR>
      <TR>
        <TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">
	&nbsp;Start Date</TD>

        <TD BGCOLOR="#EAEAEA" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="10%">
        <TABLE BORDER="0" CELLPADDING="" CELLSPACING="0">
          <TR>
            <TD><SELECT NAME="bdate_day" SIZE="1" >
            <OPTION VALUE="0">Day</OPTION>';

		foreach ( range(1,31) as $x ) 
		{
			if($x < 10)
			{
				echo '<OPTION VALUE="0'.$x.'"';
				if ($param['bdate_day'] == "0".$x) 
				{
					echo  'SELECTED ';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo 'SELECTED';
				}
				echo '>0'.$x.'</OPTION">';
			}
			else
			{
				print '<OPTION VALUE="'.$x.'"';
				if ($param['bdate_day'] == $x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo 'SELECTED ';
				}
				echo '>'.$x.'</OPTION">';
			}  
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
            
                 $months2=array_keys($months);
		foreach ($months2 as $x) 
		{
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['bdate_month'] && $param['bdate_month'] == $x) {
                       echo 'SELECTED';
                   }
		   elseif($x == $curr_month && !$param['bdate_month'])
		   {
			print 'SELECTED';
		   }
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';
            
$sysyear = date('Y');
$valYear = array($sysyear-5,$sysyear-4,$sysyear-3,$sysyear-2,$sysyear-1,$sysyear,$sysyear+1,$sysyear+2,$sysyear+3,$sysyear+4,$sysyear+5);

		foreach($valYear as $x)
		{

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
                echo '</SELECT></TD></tr></table>';
                
	
	echo '<TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">
	&nbsp;End Date</TD>
  
	   <TD BGCOLOR="#EAEAEA" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="10%">

        <TABLE BORDER="0" CELLPADDING="" CELLSPACING="0">
          <TR>
            <TD><SELECT NAME="adate_day" SIZE="1" >
            <OPTION VALUE="0">Day</OPTION>';
	    

		foreach (range(1,31) as $y) 
		{
			if($y < 10)
			{
				echo '<OPTION VALUE="0'.$y.'"';
				if ($param['adate_day'] == "0".$y) 
				{
					echo 'SELECTED';
				}
				elseif($y == $curr_day && !$param['adate_day'])
				{
					echo 'SELECTED';
				}
				echo '>0'.$y.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$y.'"';
				if ($param['adate_day'] == $y) 
				{
					echo 'SELECTED';
				}
				elseif($y == $curr_day && !$param['adate_day'])
				{
					echo 'SELECTED';
				}
				echo '>'.$y.'</OPTION">';
			}  
                }

              
                
		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
              $months3=array_keys($months);
		foreach ($months3 as $x) 
		{
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['adate_month'] && $param['adate_month'] == $x) {
                       echo 'SELECTED';
                   }
		elseif($x == $curr_month && !$param['adate_month'])
		{
			echo 'SELECTED';
		}
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';

		foreach($valYear as $x)
		{
                   echo '<OPTION VALUE="'.$x.'"';
                   if ($param['adate_year'] && $param['adate_year'] == $x) {
                       echo 'SELECTED';
                   }
		elseif($x == $curr_year && !$param['adate_year'])
		{
			echo 'SELECTED';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
	echo '</SELECT></TD></TD></tr></table></td>';
	
	  
echo '
<TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">
	&nbsp;GLUser Id </TD>
<td BGCOLOR="#F4F4F4" WIDTH="10%"><INPUT TYPE="text" NAME="glid" value='.$glid.'></td>
<TD BGCOLOR="#DEF2FE" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" WIDTH="10%">
	&nbsp;INTEREST TYPE</TD>
	<TD BGCOLOR="#F4F4F4"><SELECT NAME="INTEREST" SIZE="1">';
	echo '<OPTION VALUE="ALL">ALL</OPTION>';
	while($rec=oci_fetch_array($sth1,OCI_BOTH))
	{ 
	  if(isset($_REQUEST['INTEREST']) && $_REQUEST['INTEREST']==$rec['IIL_ENQ_INTEREST_TYPE'])
	  {
           echo '<OPTION VALUE="'.$rec['IIL_ENQ_INTEREST_TYPE'].'" SELECTED>'.$rec['IIL_ENQ_INTEREST_TYPE'].'</OPTION>';
           }
           else
           {
           echo '<OPTION VALUE="'.$rec['IIL_ENQ_INTEREST_TYPE'].'">'.$rec['IIL_ENQ_INTEREST_TYPE'].'</OPTION>';
           }
         }         
echo '</td><td BGCOLOR="#F4F4F4"><INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report" onclick="return checkform(this.form)"></td>
</tr>
</FORM></TABLE>';
