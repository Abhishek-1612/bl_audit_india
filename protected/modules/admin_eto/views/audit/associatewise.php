<?php
$finalArr=array();
$cnt=1;
$tempDate='';
$leadqualitypass=$callqualitypass=$noisequalitypass=$formattingpass=$qualitypass_ex=$qualitypass_in='';
$submit=isset($_REQUEST['submit']) ? $_REQUEST['submit'] : '';
$AssociateId=isset($_REQUEST['emp_id']) ? $_REQUEST['emp_id'] : '';
$end_date=isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : ''; 
if($end_date == '')
{
$today_date=date('d-M-y', strtotime(date("d-M-Y")));

$tempArray=explode('-',$today_date);
$day=$tempArray[0];
$day=$day-1;
if($day<10)
$day="0$day";
$month=$tempArray[1];
$year=$tempArray[2];
$year=$year+2000;
$today_date="$day-$month-$year";
$end_date=$today_date;
}
$end_date=strtoupper($end_date);




echo '<!DOCTYPE html><html><head> <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/calendar.js"></script>';?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28761981-2']);
  _gaq.push(['_setDomainName', '.intermesh.net']);
  _gaq.push(['_setSiteSpeedSampleRate', 10]);
  _gaq.push(['_trackPageview','/index.php?r=admin_eto/AdminEto/leapdashboard&action=hourlydata&mid=3424']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

function checkform()
{
if(document.getElementById('emp_id').value.trim() =='' || isNaN(document.getElementById('emp_id').value))
		{
			alert("Please enter valid Emp ID")
			document.getElementById('emp_id').focus();
			return false;
		}  
}  
</script>
<?php
echo '</head>
<body>
<table style="border-collapse: collapse;align: center;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" >
		<tr>
		<td style="text-align:center;" bgcolor="#dff8ff" colspan="100"><b>
		<form name="searchlead" method="post" action="" onsubmit="return checkform();">
		Date:&nbsp;&nbsp;&nbsp;<input name="end_date" type="text" VALUE="'.$end_date.'" SIZE="13" onfocus="displayCalendar(document.searchlead.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchlead.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="end_date" TYPE="text" readonly="readonly">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		Associate Id:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="emp_id" id="emp_id" value='.$AssociateId.'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input type="submit" name="submit" value="Generate">
		</form>
		</table>';

if(!empty($submit))		
{
for($i=1;$i<count($dataArr);$i++)
{
 $auditdate=$dataArr[$i][2];
 $auditdate=explode(' ',$auditdate);
 $auditdate=$auditdate[0];
 if($auditdate != $tempDate)
 {
  $leadqualitypass=$callqualitypass=$noisequalitypass=$formattingpass=$qualitypass_ex=$qualitypass_in=$errorString='';
  
  if((($dataArr[$i][8]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][8]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][8]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Call Opening,';
  }
  
   if((($dataArr[$i][9]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][9]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][9]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Phone Etiquette,';
  }
  
  if((($dataArr[$i][10]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][10]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][10]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Valid Probing,';
  }
  
  if((($dataArr[$i][11]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][11]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][11]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Call Closing,';
  }
  
  if((($dataArr[$i][12]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][12]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][12]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Noise on Call,';
  }
  
  if((($dataArr[$i][13]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][13]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][13]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Wrong Approval,';
  }
 
 if((($dataArr[$i][14]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][14]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][14]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Title,';
  }
  if((($dataArr[$i][15]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][15]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][15]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Call),';
  }
  
  if((($dataArr[$i][16]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][16]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][16]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Original/Existing),';
  }

  if((($dataArr[$i][17]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][17]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][17]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'MCAT Selection,';
  }
  
   if((($dataArr[$i][18]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][18]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][18]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Supplier Selection - Manual,';
  }
  
  if((($dataArr[$i][19]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][19]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][19]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Contact Details,';
  }
  
  if((($dataArr[$i][20]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][20]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][20]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Grammar and Spelling,';
  }
  
  if((($dataArr[$i][21]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][21]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][21]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Supplier Selection - Auto,';
  }
  
  if((($dataArr[$i][22]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][22]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][22]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Retail and Bulk,';
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
   $errorString .= 'Call Opening,';
  }
  
   if((($dataArr[$i][9]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][9]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][9]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Phone Etiquette,';
  }
  
  if((($dataArr[$i][10]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][10]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][10]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Valid Probing,';
  }
  
  if((($dataArr[$i][11]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][11]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][11]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Call Closing,';
  }
  
  if((($dataArr[$i][12]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][12]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][12]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Noise on Call,';
  }
  
  if((($dataArr[$i][13]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][13]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][13]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Wrong Approval,';
  }
 
 if((($dataArr[$i][14]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][14]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][14]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Title,';
  }
  if((($dataArr[$i][15]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][15]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][15]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Call),';
  }
  
  if((($dataArr[$i][16]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][16]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][16]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Information Missing/Wrong (From Original/Existing),';
  }

  if((($dataArr[$i][17]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][17]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][17]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'MCAT Selection,';
  }
  
   if((($dataArr[$i][18]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][18]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][18]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Supplier Selection - Manual,';
  }
  
  if((($dataArr[$i][19]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][19]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][19]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Contact Details,';
  }
  
  if((($dataArr[$i][20]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][20]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][20]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Grammar and Spelling,';
  }
  
  if((($dataArr[$i][21]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][21]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][21]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Supplier Selection - Auto,';
  }
  
  if((($dataArr[$i][22]=='Pass') || preg_match("/^Feedback/", $dataArr[$i][22]) > 0 || preg_match("/^Not Applicable/",$dataArr[$i][22]) > 0))
  {
   $errorString .= '';
  }
  else
  {
   $errorString .= 'Retail and Bulk,';
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



echo '<table style="border-collapse: collapse;align: center;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" >
		<tr>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Date</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Audit Count</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Call Failed</b></td>
        	<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Call Quality(Excluding Noise)</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Lead Failed(Including Formating)</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Lead Quality</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Total Failed</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Overall Quality(Excluding Noise & Formating)</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Overall Quality(Including Noise & Formating)</b></td>
		<td  style="text-align:center;" bgcolor="#dff8ff" ><b>Parameter Where Error</b></td>
		</tr>';

foreach($finalArr as $x)
{
 $callFailed=$x['cnt']-$x['callqualitypass'];
 $leadFailed=$x['cnt']-$x['leadqualitypass'];
 $Total_failed=$callFailed+$leadFailed;
 $err=rtrim($x['errorString'],',');
 echo '<tr>
		<td  style="text-align:center;" bgcolor="white"><b>'.$x['date'].'</b></td>
		<td  style="text-align:center;" bgcolor="white">'.$x['cnt'].'</td>
		<td  style="text-align:center;" bgcolor="white">'.$callFailed.'</td>
        	<td  style="text-align:center;" bgcolor="white">'.round((($x['callqualitypass']/$x['cnt'])*100),2).'%</td>
		<td  style="text-align:center;" bgcolor="white">'.$leadFailed.'</td>
		<td  style="text-align:center;" bgcolor="white">'.round((($x['leadqualitypass']/$x['cnt'])*100),2).'%</td>
		<td  style="text-align:center;" bgcolor="white">'.$Total_failed.'</td>
		<td  style="text-align:center;" bgcolor="white">'.round((($x['qualitypass_ex']/$x['cnt'])*100),2).'%</td>
		<td  style="text-align:center;" bgcolor="white">'.round((($x['qualitypass_in']/$x['cnt'])*100),2).'%</td>
		<td  style="text-align:center;" bgcolor="white">'.$err.'</td>
		</tr>';
  
 
}

echo '</table><br><br>';

}

?>