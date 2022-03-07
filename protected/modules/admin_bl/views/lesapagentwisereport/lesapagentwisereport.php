<?php
if(isset($_REQUEST['agent_detail']))
{$i=0;
$date = $_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];

echo '<div align="center"><b>'.date('d-M-Y',strtotime($date)).' to '.date('d-M-Y',strtotime('-6 day', strtotime($date))).'</b></div>';

echo '
    <br/><br/>
      <table align="center" width="65%">
      <tr><td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">S.NO.</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">Associate-ID</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">Associate Name</td>';
       $pool = isset($_REQUEST['pool']) ? $_REQUEST['pool'] : '';
       if($pool=='DNC')
       {
       echo '<td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center"><6</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">7-10</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">11-15</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">16-20</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">>20</td></tr>';
       }
       else
       {
       echo '<td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center"><2</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">2-4</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">5-6</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">7-10</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">>10</td></tr>';
       }
    $total1=$total2=$total3=$total4=$total5=0;$i=0;   
while($rec=$sth_agent_detail->read()){
 $agent_detail=array_change_key_case($rec,CASE_UPPER);
$total1+=$agent_detail["LEAD_LESS_THAN6"];
$total2+=$agent_detail["LEAD_LESS_THAN7_10"];
$total3+=$agent_detail["LEAD_LESS_THAN10_15"];
$total4+=$agent_detail["LEAD_LESS_THAN15_20"];
$total5+=$agent_detail["LEAD_LESS_THAN_20"];
echo '
      <tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.($i+1).'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$agent_detail['ETO_LEAP_EMP_ID'].'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$agent_detail['ETO_LEAP_EMP_NAME'].'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$agent_detail["LEAD_LESS_THAN6"].'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$agent_detail["LEAD_LESS_THAN7_10"].'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$agent_detail["LEAD_LESS_THAN10_15"].'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$agent_detail["LEAD_LESS_THAN15_20"].'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$agent_detail["LEAD_LESS_THAN_20"].'</td>
     </tr>
      ';
      $i++;
}
echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center" colspan="3"><b align="center">Total</b></td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$total1.'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$total2.'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$total3.'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$total4.'</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">'.$total5.'</td>
     </tr></table>';
exit;
}
$poolarray=array('all','Must Call','DNC','Service','Foreign');

$fields = array('adate_day','adate_month','adate_year','vendor_name','pool');
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

    $this->pageTitle=Yii::app()->name . ' - Associate Performance Report';
	     
	 echo '<html>
	       <head>
	 <script LANGUAGE="JavaScript" SRC="eto-buy-sale-report.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript">
       
        <!--
        
	function checkBuyForm()
	{
		
		if(document.searchForm.adate_day.value == 0 || document.searchForm.adate_month.value == 0 || document.searchForm.adate_year.value == 0)
		{
			alert("Fill Start Date");
			return false;
		}
	
		
		if(document.searchForm.adate_month.value == 2 || document.searchForm.adate_month.value == 4
		|| document.searchForm.adate_month.value == 6|| document.searchForm.adate_month.value == 9|| document.searchForm.adate_month.value == 11)
		{
			if(document.searchForm.adate_day.value == 31)
			{
			alert("This date does not exists");
			return false;
			}
		}
	}

	
	//-->
	</SCRIPT>
	<!--google analytics async code start-->
	 <script type="text/javascript">
	function popup(vendername,adate_day,adate_month,adate_year,colname,colvalue,pool) {
			//var value=document.getElementById(mid).value;
			var myWindow = window.open("index.php?r=admin_bl/Lesapagentwisereport/Index/mid/3436/agent_detail/agent_details/adate_day/"+adate_day+"/adate_month/"
			+adate_month+"/adate_year/"+adate_year+"/vendername/"+vendername+"/colname/"+colname+"/colvalue/"+colvalue+"/pool/"+pool,"", "width=1200, height=650,scrollbars=yes, resizable=yes");
			//myWindow.document.write(mid);
		}
 
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
	<body>';

	echo '
	<FORM name="searchForm" METHOD="post" ACTION="/index.php?r=admin_bl/Lesapagentwisereport/Index&mid=3436" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
	<input name="frame_height" id="frame_height" value="" type="hidden">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;"> Associate Performance Report</TD>
	</TR>
	</TABLE>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="12%" HEIGHT="30">&nbsp;Select Date</TD>
		<TD STYLE="font-family:arial;font-size:12px;font-weight:bold;" 
		BGCOLOR="#EAEAEA" width="40%">
		<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
		<TR>

		';
            
            if($mesg)
	      {
		      echo  $mesg;
	      }
       $sysyear = date('Y');
            
       $valYear = array($sysyear-5,$sysyear-4,$sysyear-3,$sysyear-2,$sysyear-1,$sysyear,$sysyear+1,$sysyear+2,$sysyear+3,$sysyear+4,$sysyear+5);

             
		echo '<TD><SELECT NAME="adate_day" SIZE="1">
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

                
                 foreach($valYear as $x)
		{
# 		foreach (2008..2011) {
                   echo '<OPTION VALUE="'.$x.'"';
                   if (isset($param['adate_year']) && $param['adate_year'] == $x) 
                   {
                       echo ' SELECTED ';
                   }
		elseif($x == $curr_year && !$param['adate_year'])
		{
			echo ' SELECTED ';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
            
            
            echo '</SELECT></TD>
		</TR>
		</TABLE></TD>
		<TD WIDTH="12%" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Vender</TD>
		<TD BGCOLOR="#EAEAEA" width="12%">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
				<SELECT NAME="vendor_name" SIZE="1" style="width:100px;">
				<OPTION VALUE="';
				if(isset($_REQUEST['vendor_name'])  &&  $_REQUEST['vendor_name'] ==  'all'){
					echo 'all" SELECTED="SELECTED"';
				}
				else
				{
					echo 'all"';
				}
				echo '>All</OPTION>
				';
			
	   foreach ( $allvendernames as $value) 
		{
			echo '<OPTION VALUE="';
			if(isset($_REQUEST['vendor_name'])  &&  $_REQUEST['vendor_name'] ==  $value)
			{
			    echo ''.$value.'" SELECTED="SELECTED"';	
			}
			else
			{
				echo ''.$value.'"';
			}
			echo '> '.$value.'</OPTION>';
		}
	
	
	echo '</TD>
		</TR>
		</TABLE>
		</TD>';
# 		if($modval && $modval eq 'FENQ')
# 		{

	echo '<TD WIDTH="12%" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Pool</TD>
			<TD BGCOLOR="#EAEAEA" width="12%">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
		<SELECT NAME="pool" id ="source" SIZE="1" style="width:150px;" >';
		
                  foreach($poolarray as $x)
                        {
                                echo '<OPTION VALUE="'.$x.'"';
                                if (isset($_REQUEST['pool'])  &&  $_REQUEST['pool'] ==  $x) 
                                {
                                        echo ' SELECTED ';
                                }
                                echo '>'.$x.'</OPTION">';
                        }		
			
# 		}
		echo '</TD>
		</TR>
		</TABLE>
		</TD>';
       echo '
	</TR>
	</TABLE>
	<br><br>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR colspan="3"><TD BGCOLOR="#F4F4F4">';
		
	echo '</td><td BGCOLOR="#F4F4F4"><div id="smsreport" style="display:none">';
   $hours=array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
   $i=0;
   $j=0;
   $timestamp = isset($_REQUEST['timestamp']) ? $_REQUEST['timestamp'] : '';
   $timestamp1 = isset($_REQUEST['timestamp1']) ? $_REQUEST['timestamp1'] : '';
     echo 'Time:<SELECT NAME="timestamp">';					
                foreach($hours as $x)
                  {
                     echo '<OPTION VALUE="'.$hours[$i].'"';
                     if($timestamp == $hours[$i]) 
                     {
                        echo ' SELECTED ';
                     }
                        echo '>'.$hours[$i].'</OPTION>';
                        $i++;
                  }
                echo '</SELECT>
                &nbsp;to &nbsp;<SELECT NAME="timestamp1">';					
               foreach($hours as $x)
                  {
                     echo '<OPTION VALUE="'.$hours[$j].'"';
                     if($timestamp1 == $hours[$j]) 
                     {
                        echo ' SELECTED ';
                     }
                        echo '>'.$hours[$j].'</OPTION>';
                        $j++;
                  }

                  
            echo '</select>';
echo '&nbsp;&nbsp;&nbsp;<SELECT NAME="sourceid" id ="sourceid" SIZE="1" style="width:150px;" >';
$sourceid=array('General','FENQ');
                        foreach($sourceid as $x)
                        {
                                echo '<OPTION VALUE="'.$x.'"';
                                if (isset($_REQUEST['sourceid'])  && $_REQUEST['sourceid'] == $x) 
                                {
                                       echo ' SELECTED ';
                                }
                                echo '>'.$x.'</OPTION">';
                        }		
echo '</div></TD><TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
<input type="hidden" name="action" value="get_lead_quality_rpt">
<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
</TD>
	</TR>
	</TABLE></FORM>
	</body>
	</html>';
	
if(isset($_REQUEST['action']) && $_REQUEST['action']  == 'get_lead_quality_rpt')
		{
	$pool = isset($_REQUEST['pool']) ? $_REQUEST['pool'] : '';
	if(isset($_REQUEST['vendor_name'])  &&  $_REQUEST['vendor_name'] ==  'all'){
	$vname=$_REQUEST['vendor_name'];
	echo '<br/><br/>
      <table align="center" width="65%">
      <tr><td bgcolor="#CCCCCC" style="font-family:arial;font-size:12px;font-weight:bold;" width="12%" height="30" align="center" colspan="13">&nbsp;'.'ALL'.'</td></tr>
      <tr><td bgcolor="#CCCCFF" style="font-family:arial;font-size:12px;font-weight:bold;" width="12%" height="30" align="center">&nbsp;Lead Count</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:12px;font-weight:bold;" width="12%" height="30" align="center" colspan="12">&nbsp;Associate Count</td></tr>
      <tr><td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">9-10</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">10-11</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">11-12</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">12-1</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">1-2</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">2-3</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">3-4</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">4-5</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">5-6</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">6-7</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">7-8</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">8-9</td>
      </tr>
      <tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
      if($pool=='DNC')
        echo '<6';
      else
        echo '<2';
      echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if( $rec_allvendor['AGENT_LESS_THAN2_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT9_10'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if( $rec_allvendor["AGENT_LESS_THAN2_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor["AGENT_LESS_THAN2_CNT10_11"].'</a>';
        else
        echo  $rec_allvendor["AGENT_LESS_THAN2_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT11_12'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT12_13'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT13_14'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT14_15'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT15_16'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if( $rec_allvendor['AGENT_LESS_THAN2_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT16_17'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT17_18']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT17_18'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT17_18'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if( $rec_allvendor['AGENT_LESS_THAN2_CNT18_19']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT18_19'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT18_19'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT19_20']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT19_20'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT19_20'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_LESS_THAN2_CNT20_21']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_LESS_THAN2_CNT20_21'].'</a>';
        else
        echo  $rec_allvendor['AGENT_LESS_THAN2_CNT20_21'];
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
      echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
      if($pool=='DNC')
        echo '7-10';
      else
        echo '2-4';
      echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if( $rec_allvendor['AGENT_2_4_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT9_10'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if( $rec_allvendor["AGENT_2_4_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor["AGENT_2_4_CNT10_11"].'</a>';
        else
        echo  $rec_allvendor["AGENT_2_4_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT11_12'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT12_13'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT13_14'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT14_15'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT15_16'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if( $rec_allvendor['AGENT_2_4_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT16_17'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT17_18']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT17_18'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT17_18'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if( $rec_allvendor['AGENT_2_4_CNT18_19']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT18_19'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT18_19'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT19_20']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT19_20'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT19_20'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_2_4_CNT20_21']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_2_4_CNT20_21'].'</a>';
        else
        echo  $rec_allvendor['AGENT_2_4_CNT20_21'];
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
      echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
      if($pool=='DNC')
        echo '11-15';
      else
        echo '5-6';
      echo ' </td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if( $rec_allvendor['AGENT_5_6_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT9_10'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if( $rec_allvendor["AGENT_5_6_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor["AGENT_5_6_CNT10_11"].'</a>';
        else
        echo  $rec_allvendor["AGENT_5_6_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT11_12'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT12_13'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT13_14'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT14_15'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT15_16'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if( $rec_allvendor['AGENT_5_6_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT16_17'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT17_18'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT17_18'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT17_18'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if( $rec_allvendor['AGENT_5_6_CNT18_19'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT18_19'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT18_19'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT19_20'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT19_20'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT19_20'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_5_6_CNT20_21'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_5_6_CNT20_21'].'</a>';
        else
        echo  $rec_allvendor['AGENT_5_6_CNT20_21'] ;
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
         echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
         if($pool=='DNC')
        echo '16-20';
      else
        echo '7-10';
         echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if( $rec_allvendor['AGENT_7_10_CNT9_10'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT9_10'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT9_10'] ;
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if( $rec_allvendor["AGENT_7_10_CNT10_11"] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor["AGENT_7_10_CNT10_11"].'</a>';
        else
        echo  $rec_allvendor["AGENT_7_10_CNT10_11"] ;
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT11_12'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT11_12'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT11_12'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT12_13'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT12_13'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT12_13'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT13_14'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT13_14'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT13_14'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT14_15'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT14_15'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT14_15'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT15_16'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT15_16'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT15_16'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if( $rec_allvendor['AGENT_7_10_CNT16_17'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT16_17'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT16_17'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT17_18'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT17_18'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT17_18'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if( $rec_allvendor['AGENT_7_10_CNT18_19'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT18_19'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT18_19'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT19_20'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT19_20'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT19_20'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_7_10_CNT20_21'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_7_10_CNT20_21'].'</a>';
        else
        echo  $rec_allvendor['AGENT_7_10_CNT20_21'] ;
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
      
         echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
         if($pool=='DNC')
        echo '>20';
      else
        echo '>10';
        echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if( $rec_allvendor['AGENT_GREATER_THAN10_CNT9_10'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT9_10'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT9_10'] ;
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if( $rec_allvendor["AGENT_GREATER_THAN10_CNT10_11"] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor["AGENT_GREATER_THAN10_CNT10_11"].'</a>';
        else
        echo  $rec_allvendor["AGENT_GREATER_THAN10_CNT10_11"] ;
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT11_12'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT11_12'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT11_12'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT12_13'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'>10'."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT12_13'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT12_13'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT13_14'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT13_14'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT13_14'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT14_15'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT14_15'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT14_15'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT15_16'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT15_16'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT15_16'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if( $rec_allvendor['AGENT_GREATER_THAN10_CNT16_17'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT16_17'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT16_17'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT17_18'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT17_18'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT17_18'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if( $rec_allvendor['AGENT_GREATER_THAN10_CNT18_19'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT18_19'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT18_19'] ;
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT19_20'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT19_20'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT19_20'] ;
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if( $rec_allvendor['AGENT_GREATER_THAN10_CNT20_21'] !=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'. $rec_allvendor['AGENT_GREATER_THAN10_CNT20_21'].'</a>';
        else
        echo  $rec_allvendor['AGENT_GREATER_THAN10_CNT20_21'] ;
      
      echo '</td></tr></table>';
	}
	
$i=0;
$pool = isset($_REQUEST['pool']) ? $_REQUEST['pool'] : '';	

while($rec=$sth_data->read()){
$data=array_change_key_case($rec,CASE_UPPER);
$vname=isset($data['ETO_LEAP_VENDOR_NAME'])?$data['ETO_LEAP_VENDOR_NAME']:$_REQUEST['vendor_name'];
echo '<br/><br/>
      <table align="center" width="65%">
      <tr><td bgcolor="#CCCCCC" style="font-family:arial;font-size:12px;font-weight:bold;" width="12%" height="30" align="center" colspan="13">&nbsp;'.$vname.'</td></tr>
      <tr><td bgcolor="#CCCCFF" style="font-family:arial;font-size:12px;font-weight:bold;" width="12%" height="30" align="center">&nbsp;Lead Count</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:12px;font-weight:bold;" width="12%" height="30" align="center" colspan="12">&nbsp;Associate Count</td></tr>
      <tr><td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">9-10</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">10-11</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">11-12</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">12-1</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">1-2</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">2-3</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">3-4</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">4-5</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">5-6</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">6-7</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">7-8</td>
      <td bgcolor="#CCCCFF" style="font-family:arial;font-size:10px;font-weight:bold;" width="5%" height="20" align="center">8-9</td>
      </tr>
      <tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
      if($pool=='DNC')
        echo '<6';
      else
        echo '<2';
      echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if($data['AGENT_LESS_THAN2_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT9_10'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if($data["AGENT_LESS_THAN2_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data["AGENT_LESS_THAN2_CNT10_11"].'</a>';
        else
        echo $data["AGENT_LESS_THAN2_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT11_12'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT12_13'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT13_14'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT14_15'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT15_16'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if($data['AGENT_LESS_THAN2_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT16_17'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT17_18']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT17_18'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT17_18'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if($data['AGENT_LESS_THAN2_CNT18_19']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT18_19'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT18_19'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT19_20']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT19_20'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT19_20'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_LESS_THAN2_CNT20_21']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'1'."'".','."'".$pool."'".');return false;">'.$data['AGENT_LESS_THAN2_CNT20_21'].'</a>';
        else
        echo $data['AGENT_LESS_THAN2_CNT20_21'];
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
      echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
      if($pool=='DNC')
        echo '7-10';
      else
        echo '2-4';
      echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if($data['AGENT_2_4_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT9_10'].'</a>';
        else
        echo $data['AGENT_2_4_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if($data["AGENT_2_4_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data["AGENT_2_4_CNT10_11"].'</a>';
        else
        echo $data["AGENT_2_4_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT11_12'].'</a>';
        else
        echo $data['AGENT_2_4_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT12_13'].'</a>';
        else
        echo $data['AGENT_2_4_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT13_14'].'</a>';
        else
        echo $data['AGENT_2_4_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT14_15'].'</a>';
        else
        echo $data['AGENT_2_4_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT15_16'].'</a>';
        else
        echo $data['AGENT_2_4_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if($data['AGENT_2_4_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT16_17'].'</a>';
        else
        echo $data['AGENT_2_4_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT17_18']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT17_18'].'</a>';
        else
        echo $data['AGENT_2_4_CNT17_18'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if($data['AGENT_2_4_CNT18_19']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT18_19'].'</a>';
        else
        echo $data['AGENT_2_4_CNT18_19'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT19_20']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT19_20'].'</a>';
        else
        echo $data['AGENT_2_4_CNT19_20'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_2_4_CNT20_21']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'2-4'."'".','."'".$pool."'".');return false;">'.$data['AGENT_2_4_CNT20_21'].'</a>';
        else
        echo $data['AGENT_2_4_CNT20_21'];
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
      echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
      if($pool=='DNC')
        echo '11-15';
      else
        echo '5-6';
      echo ' </td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if($data['AGENT_5_6_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT9_10'].'</a>';
        else
        echo $data['AGENT_5_6_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if($data["AGENT_5_6_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data["AGENT_5_6_CNT10_11"].'</a>';
        else
        echo $data["AGENT_5_6_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT11_12'].'</a>';
        else
        echo $data['AGENT_5_6_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT12_13'].'</a>';
        else
        echo $data['AGENT_5_6_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT13_14'].'</a>';
        else
        echo $data['AGENT_5_6_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT14_15'].'</a>';
        else
        echo $data['AGENT_5_6_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT15_16'].'</a>';
        else
        echo $data['AGENT_5_6_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if($data['AGENT_5_6_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT16_17'].'</a>';
        else
        echo $data['AGENT_5_6_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT17_18']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT17_18'].'</a>';
        else
        echo $data['AGENT_5_6_CNT17_18'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if($data['AGENT_5_6_CNT18_19']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT18_19'].'</a>';
        else
        echo $data['AGENT_5_6_CNT18_19'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT19_20']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT19_20'].'</a>';
        else
        echo $data['AGENT_5_6_CNT19_20'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_5_6_CNT20_21']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'5-6'."'".','."'".$pool."'".');return false;">'.$data['AGENT_5_6_CNT20_21'].'</a>';
        else
        echo $data['AGENT_5_6_CNT20_21'];
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
         echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
         if($pool=='DNC')
        echo '16-20';
      else
        echo '7-10';
         echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if($data['AGENT_7_10_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT9_10'].'</a>';
        else
        echo $data['AGENT_7_10_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if($data["AGENT_7_10_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data["AGENT_7_10_CNT10_11"].'</a>';
        else
        echo $data["AGENT_7_10_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT11_12'].'</a>';
        else
        echo $data['AGENT_7_10_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT12_13'].'</a>';
        else
        echo $data['AGENT_7_10_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT13_14'].'</a>';
        else
        echo $data['AGENT_7_10_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT14_15'].'</a>';
        else
        echo $data['AGENT_7_10_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT15_16'].'</a>';
        else
        echo $data['AGENT_7_10_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if($data['AGENT_7_10_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT16_17'].'</a>';
        else
        echo $data['AGENT_7_10_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT17_18']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT17_18'].'</a>';
        else
        echo $data['AGENT_7_10_CNT17_18'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if($data['AGENT_7_10_CNT18_19']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT18_19'].'</a>';
        else
        echo $data['AGENT_7_10_CNT18_19'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT19_20']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT19_20'].'</a>';
        else
        echo $data['AGENT_7_10_CNT19_20'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_7_10_CNT20_21']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'7-10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_7_10_CNT20_21'].'</a>';
        else
        echo $data['AGENT_7_10_CNT20_21'];
      
      echo '</td></tr>';
      //////////////////////////////////////////////////
      
         echo '<tr><td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">&nbsp;';
         if($pool=='DNC')
        echo '>20';
      else
        echo '>10';
        echo '</td>
        <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
        if($data['AGENT_GREATER_THAN10_CNT9_10']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT9_10'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT9_10'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT9_10'];
        
        echo '</td>
       <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      
        if($data["AGENT_GREATER_THAN10_CNT10_11"]!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT10_11'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data["AGENT_GREATER_THAN10_CNT10_11"].'</a>';
        else
        echo $data["AGENT_GREATER_THAN10_CNT10_11"];
        
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT11_12']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT11_12'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT11_12'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT11_12'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT12_13']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT12_13'."'".','."'".'>10'."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT12_13'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT12_13'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT13_14']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT13_14'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT13_14'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT13_14'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT14_15']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT14_15'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT14_15'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT14_15'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT15_16']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT15_16'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT15_16'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT15_16'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
     if($data['AGENT_GREATER_THAN10_CNT16_17']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT16_17'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT16_17'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT16_17'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT17_18']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT17_18'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT17_18'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT17_18'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
    if($data['AGENT_GREATER_THAN10_CNT18_19']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT18_19'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT18_19'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT18_19'];
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT19_20']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT19_20'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT19_20'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT19_20'];
      
      echo '</td>
      <td bgcolor="#EAEAEA" style="font-family:arial;font-size:10px;" width="5%" height="20" align="center">';
      if($data['AGENT_GREATER_THAN10_CNT20_21']!=0)
        echo '<a href="" onClick="popup('."'".$vname."'".','."'".$_REQUEST['adate_day']."'".','."'".$_REQUEST['adate_month']."'".','."'".$_REQUEST['adate_year']."'".','."'".'SERVICE_ND_CNT20_21'."'".','."'".'>10'."'".','."'".$pool."'".');return false;">'.$data['AGENT_GREATER_THAN10_CNT20_21'].'</a>';
        else
        echo $data['AGENT_GREATER_THAN10_CNT20_21'];
      
      echo '</td></tr></table>';
     
    $i++;
    }
     

}                
		


?>