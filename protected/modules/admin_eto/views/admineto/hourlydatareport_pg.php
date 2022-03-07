<?php 
$temp_array=array();
$activity_array=array();
$radio=isset($_REQUEST['leadtype']) ? $_REQUEST['leadtype'] : '';
$submit=isset($_REQUEST['submit']) ? $_REQUEST['submit'] : '';




$end_date=isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : ''; 
if($end_date == '')
{
$today_date=date('d-M-y', strtotime(date("d-M-Y")));

$tempArray=explode('-',$today_date);
$day=$tempArray[0];
$day=$day-1;
$day="0$day";
$month=$tempArray[1];
$year=$tempArray[2];
$year=$year+2000;
$today_date="$day-$month-$year";
$end_date=$today_date;
}
$end_date=strtoupper($end_date);




echo '<!DOCTYPE html><html><head> <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/calendar.js"></script>
</head>
<body>
<table style="border-collapse: collapse;align: center;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" >
		<tr>
		<td style="text-align:center;" bgcolor="#dff8ff" colspan="100"><b>
		<form name="searchlead" method="post" action="">
		Date:&nbsp;&nbsp;&nbsp;<input name="end_date" type="text" VALUE="'.$end_date.'" SIZE="13" onfocus="displayCalendar(document.searchlead.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchlead.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="end_date" TYPE="text" readonly="readonly">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		if(empty($submit) || $radio =='Approved')
		{
		echo '<input type="radio" name="leadtype" value="Approved" checked>&nbsp;Approved &nbsp;&nbsp;&nbsp;';
		}
		else
		{
		echo '<input type="radio" name="leadtype" value="Approved">&nbsp;Approved &nbsp;&nbsp;&nbsp;';
		}
		if($radio =='Pending')
		{
		 echo '<input type="radio" name="leadtype" value="Pending" checked>&nbsp;Flagged   &nbsp;&nbsp;&nbsp;';
		}
		else
		{
		echo '<input type="radio" name="leadtype" value="Pending">&nbsp;Flagged   &nbsp;&nbsp;&nbsp;';
		}
		if($radio =='Deleted')
		{
		echo '<input type="radio" name="leadtype" value="Deleted" checked>&nbsp;Deleted   &nbsp;&nbsp;&nbsp;&nbsp;';
		}
		else
		{
		echo '<input type="radio" name="leadtype" value="Deleted">&nbsp;Deleted   &nbsp;&nbsp;&nbsp;&nbsp;';
		}
		echo '<input type="submit" name="submit" value="Generate">
		</form>
		</b>
		</td>
		</tr>
		<tr>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>Date / Time Slot</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b><8</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>8-9</b></td>
        	<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>9-10</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>10-11</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>11-12</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>12-1</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>1-2</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>2-3</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>3-4</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>4-5</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>5-6</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>6-7</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>7-8</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>8-9</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>9-10</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>>10</b></td>';
		if(empty($submit) || $radio =='Approved')
		{
		
		echo '<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>Approved</b></td>';
		}
		elseif($radio =='Pending')
		{
		echo '<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>Flagged</b></td>';
		}
		else
		{
		echo '<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>Deleted</b></td>';
		}
		if(empty($submit) || $radio =='Approved')
		{
		 echo '<td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>FTE</b></td>
		       <td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>PPP as per FTE</b></td>
		       <td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>Last Activity</b></td>
		       <td  style="text-align:center;" bgcolor="#dff8ff" width="20px"><b>First Activity</b></td>
		</tr>';
		}

$end1 = strtotime($end_date);


$today = strtotime(date("d-M-Y"));


  
if($today ==$end1)
{
 
 
if($radio =='Pending')
{

while($rec=pg_fetch_array($sth_pending_curr))
{ 
 $rec=array_change_key_case($rec, CASE_UPPER);
$temp_array[$rec['ETO_OFR_DELETIONDATE']][$rec['HOURLY']]=$rec['TTL_NT_FLAGGED'];
}

}
elseif($radio =='Deleted')
{
while($rec=pg_fetch_array($sth_deletion_curr))
{ 
$rec=array_change_key_case($rec, CASE_UPPER);
$temp_array[$rec['ETO_OFR_DELETIONDATE']][$rec['HOURLY']]=$rec['CNT_DELETED'];
}

}
else
{
while($rec=pg_fetch_array($sth_approval_curr))
{
 
$rec=array_change_key_case($rec, CASE_UPPER);
$temp_array[$rec['ETO_OFR_APPROV_DATE_ORIG']][$rec['HOURLY']]=$rec['TTL_APPROVAL'];

}
while($rec=pg_fetch_array($sth_activity_App_curr))
{
 $rec=array_change_key_case($rec, CASE_UPPER); 
$activity_array[$rec['DATE_WISE']]['MAX_TIME']=$rec['MAX_TIME'];
$activity_array[$rec['DATE_WISE']]['MIN_TIME']=$rec['MIN_TIME'];

}
}


if($radio =='Pending')
{

while($rec=pg_fetch_array($sth_pending))
{ $rec=array_change_key_case($rec, CASE_UPPER);
$temp_array[$rec['ETO_OFR_DELETIONDATE']][$rec['HOURLY']]=$rec['TTL_NT_FLAGGED'];
}


}
elseif($radio =='Deleted')
{
while($rec=pg_fetch_array($sth_deletion))
{ $rec=array_change_key_case($rec, CASE_UPPER);
$temp_array[$rec['ETO_OFR_DELETIONDATE']][$rec['HOURLY']]=$rec['CNT_DELETED'];
}
}
else
{
while($rec=pg_fetch_array($sth_approval))
{ $rec=array_change_key_case($rec, CASE_UPPER);
$temp_array[$rec['ETO_OFR_APPROV_DATE_ORIG']][$rec['HOURLY']]=$rec['TTL_APPROVAL'];
}
while($rec=pg_fetch_array($sth_activity_App))
{ $rec=array_change_key_case($rec, CASE_UPPER);
$activity_array[$rec['DATE_WISE']]['MAX_TIME']=$rec['MAX_TIME'];
$activity_array[$rec['DATE_WISE']]['MIN_TIME']=$rec['MIN_TIME'];
}
}
 
}
else
{
if($radio =='Pending')
{
while($rec=pg_fetch_array($sth_pending))
{ $rec=array_change_key_case($rec, CASE_UPPER);
$temp_array[$rec['ETO_OFR_DELETIONDATE']][$rec['HOURLY']]=$rec['TTL_NT_FLAGGED'];
}
}
elseif($radio =='Deleted')
{
while($rec=pg_fetch_array($sth_deletion))
{  
    $rec=array_change_key_case($rec, CASE_UPPER);
    $temp_array[$rec['ETO_OFR_DELETIONDATE']][$rec['HOURLY']]=$rec['CNT_DELETED'];
}

}
else
{
while($rec=pg_fetch_array($sth_approval))
{
 $rec=array_change_key_case($rec, CASE_UPPER); 
$temp_array[$rec['ETO_OFR_APPROV_DATE_ORIG']][$rec['HOURLY']]=$rec['TTL_APPROVAL'];
}
while($rec=pg_fetch_array($sth_activity_App))
{
    $rec=array_change_key_case($rec, CASE_UPPER); 
    $activity_array[$rec['DATE_WISE']]['MAX_TIME']=$rec['MAX_TIME'];
    $activity_array[$rec['DATE_WISE']]['MIN_TIME']=$rec['MIN_TIME'];
}
}
}
	$temp_array2=array_keys($temp_array);
	$temp_date=$end_date;
	$temp_date=date('d-M-y', strtotime($temp_date));
	$temp_date=strtoupper($temp_date).' 00:00:00';
	for($i=1;$i<=8;$i++)
	{
	if(isset($temp_array[$temp_date][7]))
	{
	$SUM_Less8=$temp_array[$temp_date][7];
	}
	else
	{
	$SUM_Less8=0;
	}
	if(isset($temp_array[$temp_date][8]))
	{
	$SUM_8_9=$temp_array[$temp_date][8];
	}
	else
	{
	$SUM_8_9=0;
	}
	if(isset($temp_array[$temp_date][9]))
	{
	$SUM_9_10=$temp_array[$temp_date][9];
	}
	else
	{
	$SUM_9_10=0;
	}
	if(isset($temp_array[$temp_date][10]))
	{
	$SUM_10_11=$temp_array[$temp_date][10];
	}
	else
	{
	$SUM_10_11=0;
	}
	if(isset($temp_array[$temp_date][11]))
	{
	$SUM_11_12=$temp_array[$temp_date][11];
	}
	else
	{
	$SUM_11_12=0;
	}
	if(isset($temp_array[$temp_date][12]))
	{
	$SUM_12_1=$temp_array[$temp_date][12];
	}
	else
	{
	$SUM_12_1=0;
	}
	if(isset($temp_array[$temp_date][13]))
	{
	$SUM_1_2=$temp_array[$temp_date][13];
	}
	else
	{
	$SUM_1_2=0;
	}
	if(isset($temp_array[$temp_date][14]))
	{
	$SUM_2_3=$temp_array[$temp_date][14];
	}
	else
	{
	$SUM_2_3=0;
	}
	if(isset($temp_array[$temp_date][15])){
	$SUM_3_4=$temp_array[$temp_date][15];
	}
	else
	{
	$SUM_3_4=0;
	}
	if(isset($temp_array[$temp_date][16])){
	$SUM_4_5=$temp_array[$temp_date][16];
	}
	else
	{
	$SUM_4_5=0;
	}
	if(isset($temp_array[$temp_date][17])){
	$SUM_5_6=$temp_array[$temp_date][17];
	}
	else
	{
	$SUM_5_6=0;
	}
	if(isset($temp_array[$temp_date][18])){
	$SUM_6_7=$temp_array[$temp_date][18];
	}
	else
	{
	$SUM_6_7=0;
	}
	if(isset($temp_array[$temp_date][19])){
	$SUM_7_8=$temp_array[$temp_date][19];
	}
	else
	{
	$SUM_7_8=0;
	}
	if(isset($temp_array[$temp_date][20])){
	$SUM_20_21=$temp_array[$temp_date][20];
	}
	else
	{
	$SUM_20_21=0;
	}
	if(isset($temp_array[$temp_date][21])){
	$SUM_21_22=$temp_array[$temp_date][21];
	}
	else
	{
	$SUM_21_22=0;
	}
	if(isset($temp_array[$temp_date][22])){
	$SUM_GR_10=$temp_array[$temp_date][22];
	}
	else
	{
	$SUM_GR_10=0;
	}
	$ALL_SUM=$SUM_Less8+$SUM_8_9+$SUM_9_10+$SUM_10_11+$SUM_11_12+$SUM_12_1+$SUM_1_2+$SUM_2_3+$SUM_3_4+$SUM_4_5+$SUM_5_6+$SUM_6_7+$SUM_7_8+$SUM_20_21+$SUM_21_22+$SUM_GR_10;
	$MAX_TIME=isset($activity_array[$temp_date]['MAX_TIME']) ? $activity_array[$temp_date]['MAX_TIME'] : 'NA'; 
	$MIN_TIME=isset($activity_array[$temp_date]['MIN_TIME']) ? $activity_array[$temp_date]['MIN_TIME'] : 'NA';
	
	$t1 = StrToTime ($MIN_TIME);
	$t2 = StrToTime ($MAX_TIME);
	$diff = $t1 - $t2;
	$hours = $diff / ( 60 * 60 );
	$FTE=$hours/9;
	$FTE=round($FTE,2);
	if($FTE !=0)
	{
	$PPP=$ALL_SUM/$FTE;
	}
	else{
	$PPP=0;
	}
	$PPP=round($PPP,2);


	
	
	echo '<tr>
		<td  style="text-align:center;" bgcolor="white" width="25px">'.str_replace(' 00:00:00','',$temp_date).'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_Less8.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_8_9.'</td>
        	<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_9_10.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_10_11.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_11_12.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_12_1.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_1_2.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_2_3.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_3_4.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_4_5.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_5_6.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_6_7.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_7_8.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_20_21.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_21_22.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px">'.$SUM_GR_10.'</td>
		<td  style="text-align:center;" bgcolor="white" width="20px"><b>'.$ALL_SUM.'</b></td>';
		if(empty($submit) || $radio =='Approved')
		{
		 echo '<td  style="text-align:center;" bgcolor="white" width="20px">'.$FTE.'</td>
		       <td  style="text-align:center;" bgcolor="white" width="20px">'.$PPP.'</td>
		       <td  style="text-align:center;" bgcolor="white" width="20px">'.$MIN_TIME.'</td>
		       <td  style="text-align:center;" bgcolor="white" width="20px">'.$MAX_TIME.'</td>';
		}
		echo '</tr>';
		$temp_date=date('d-M-y', strtotime('-1 day', strtotime($temp_date)));
		$temp_date=strtoupper($temp_date).' 00:00:00';
	}
		
		
		echo '</table>';
		
		
if(!empty($dataArr))		
{
for($i=1;$i<count($dataArr);$i++)
{
 $auditdate=$dataArr[$i][2];
 $auditdate=explode(' ',$auditdate);
 $auditdate=$auditdate[0];
 if($auditdate != $tempDate)
 {
  $leadqualitypass=$callqualitypass=$noisequalitypass=$formattingpass=$qualitypass_ex=$qualitypass_in=$errorString=$Remarks='';
  if((($dataArr[$i][8]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][8]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][8]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Call Opening<br>';
  }
  
   if((($dataArr[$i][9]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][9]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][9]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Phone Etiquette<br>';
  }
  
  if((($dataArr[$i][10]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][10]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][10]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Valid Probing<br>';
  }
  
  if((($dataArr[$i][11]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][11]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][11]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Call Closing<br>';
  }
  
  
  if((($dataArr[$i][13]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][13]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][13]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Wrong Approval<br>';
  }
 
 if((($dataArr[$i][14]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][14]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][14]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Title<br>';
  }
  if((($dataArr[$i][15]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][15]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][15]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Call)<br>';
  }
  
  if((($dataArr[$i][16]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][16]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][16]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Original/Existing)<br>';
  }

  if((($dataArr[$i][17]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][17]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][17]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'MCAT Selection<br>';
  }
  
   if((($dataArr[$i][18]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][18]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][18]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Supplier Selection - Manual<br>';
  }
  
  if((($dataArr[$i][19]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][19]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][19]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Contact Details<br>';
  }
  
  $cnt=1;  
  $callqualitypass=$callqualitypass+$dataArr[$i][23];
  $leadqualitypass=$leadqualitypass+$dataArr[$i][24];
  $qualitypass_ex=$qualitypass_ex+$dataArr[$i][27];
  $qualitypass_in=$qualitypass_in+$dataArr[$i][28];
  $noisequalitypass=$noisequalitypass+$dataArr[$i][25];
  $formattingpass=$formattingpass+$dataArr[$i][26];
  
   $finalArr[$auditdate]['cnt']=$cnt;
   $finalArr[$auditdate]['date']=$auditdate;
   $finalArr[$auditdate]['callqualitypass']=$callqualitypass;
   $finalArr[$auditdate]['leadqualitypass']=$leadqualitypass;
   $finalArr[$auditdate]['noisequalitypass']=$noisequalitypass;
   $finalArr[$auditdate]['formattingpass']=$formattingpass;
   $finalArr[$auditdate]['qualitypass_ex']=$qualitypass_ex;
   $finalArr[$auditdate]['qualitypass_in']=$qualitypass_in;
   $finalArr[$auditdate]['errorString']=$errorString;
 }
 else
 {
 if((($dataArr[$i][8]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][8]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][8]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Call Opening<br>';
  }
  
   if((($dataArr[$i][9]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][9]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][9]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Phone Etiquette<br>';
  }
  
  if((($dataArr[$i][10]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][10]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][10]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Valid Probing<br>';
  }
  
  if((($dataArr[$i][11]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][11]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][11]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Call Closing<br>';
  }
  
  
  if((($dataArr[$i][13]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][13]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][13]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Wrong Approval<br>';
  }
 
 if((($dataArr[$i][14]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][14]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][14]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Title<br>';
  }
  if((($dataArr[$i][15]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][15]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][15]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Call)<br>';
  }
  
  if((($dataArr[$i][16]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][16]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][16]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Original/Existing)<br>';
  }

  if((($dataArr[$i][17]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][17]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][17]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'MCAT Selection<br>';
  }
  
   if((($dataArr[$i][18]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][18]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][18]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Supplier Selection - Manual<br>';
  }
  
  if((($dataArr[$i][19]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][19]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][19]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Contact Details<br>';
  }
  
  $callqualitypass=$callqualitypass+$dataArr[$i][23];
  $leadqualitypass=$leadqualitypass+$dataArr[$i][24];
  $qualitypass_ex=$qualitypass_ex+$dataArr[$i][27];
  $qualitypass_in=$qualitypass_in+$dataArr[$i][28];
  $noisequalitypass=$noisequalitypass+$dataArr[$i][25];
  $formattingpass=$formattingpass+$dataArr[$i][26];
  $cnt++;
  
   $finalArr[$auditdate]['cnt']=$cnt;
   $finalArr[$auditdate]['date']=$auditdate;
   $finalArr[$auditdate]['callqualitypass']=$callqualitypass;
   $finalArr[$auditdate]['leadqualitypass']=$leadqualitypass;
   $finalArr[$auditdate]['noisequalitypass']=$noisequalitypass;
   $finalArr[$auditdate]['formattingpass']=$formattingpass;
   $finalArr[$auditdate]['qualitypass_ex']=$qualitypass_ex;
   $finalArr[$auditdate]['qualitypass_in']=$qualitypass_in;
   $finalArr[$auditdate]['errorString']=$errorString;
 
 }
 $tempDate=$auditdate;
}



echo '<br><br><div><table style="border-collapse: collapse;align: center;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" >
		<th style="text-align:center;" bgcolor="#009DCC" width="20px" colspan="10">Quality Trend</th>
		<tr>
		<td   bgcolor="#dff8ff" ><b>Date</b></td>
		<td   bgcolor="#dff8ff" ><b>Audit Count</b></td>
		<td   bgcolor="#dff8ff" ><b>Call Failed</b></td>
        	<td   bgcolor="#dff8ff" ><b>Call Quality(Excluding Noise)</b></td>
		<td   bgcolor="#dff8ff" ><b>Lead Failed(Including Formating)</b></td>
		<td   bgcolor="#dff8ff" ><b>Lead Quality</b></td>
		<td   bgcolor="#dff8ff" ><b>Total Failed</b></td>
		<td   bgcolor="#dff8ff" ><b>Overall Quality(Excluding Noise & Formating)</b></td>
		<td   bgcolor="#dff8ff" ><b>Overall Quality(Including Noise & Formating)</b></td>
		<td   bgcolor="#dff8ff" ><b>Parameter Where Error</b></td>
		</tr>';

foreach($finalArr as $x)
{
 $callFailed=$x['cnt']-$x['callqualitypass'];
 $leadFailed=$x['cnt']-$x['leadqualitypass'];
 $Total_failed=$callFailed+$leadFailed;
 $err=rtrim($x['errorString'],',');
 echo '<tr>
		<td valign="top"  bgcolor="white"><b>'.$x['date'].'</b></td>
		<td valign="top"  bgcolor="white">'.$x['cnt'].'</td>
		<td valign="top"  bgcolor="white">'.$callFailed.'</td>
        	<td valign="top"  bgcolor="white">'.round((($x['callqualitypass']/$x['cnt'])*100),2).'%</td>
		<td valign="top"  bgcolor="white">'.$leadFailed.'</td>
		<td valign="top"  bgcolor="white">'.round((($x['leadqualitypass']/$x['cnt'])*100),2).'%</td>
		<td valign="top"  bgcolor="white">'.$Total_failed.'</td>
		<td valign="top"  bgcolor="white">'.round((($x['qualitypass_ex']/$x['cnt'])*100),2).'%</td>
		<td valign="top"  bgcolor="white">'.round((($x['qualitypass_in']/$x['cnt'])*100),2).'%</td>
		<td valign="top"  bgcolor="white">'.$err.'</td>
		
		</tr>';
  
 
}

echo '</table></div>';

echo '<br><br><div><table style="border-collapse: collapse;align: center;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" >
		<th style="text-align:center;" bgcolor="#009DCC" width="20px" colspan="5">Audit Dump</th>
		<tr>
		<td   bgcolor="#dff8ff" ><b>Sr.No</b></td>
		<td   bgcolor="#dff8ff" ><b>Audit Date</b></td>
		<td   bgcolor="#dff8ff" ><b>Offer ID</b></td>
		<td   bgcolor="#dff8ff" ><b>Auditor Name</b></td>
		<td   bgcolor="#dff8ff" ><b>Remarks</b></td>
		</tr>';

for($i=1;$i<count($dataArr);$i++)
{
 $AUDIT_REMARKS = str_replace("\n", '<br>', $dataArr[$i][7]);
  echo '<tr>
		<td valign="top"  bgcolor="white"><b>'.$i.'</b></td>
		<td valign="top"  bgcolor="white">'.$dataArr[$i][2].'</td>
		<td valign="top"  bgcolor="white">'.$dataArr[$i][4].'</td>
		<td valign="top"  bgcolor="white">'.$dataArr[$i][1].'</td>
		<td valign="top"  bgcolor="white">'.$AUDIT_REMARKS.'</td>
        	</tr>';
}
echo '</table></div>';

}		
		
						