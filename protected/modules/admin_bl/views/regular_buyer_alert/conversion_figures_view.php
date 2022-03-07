<html>
<head><LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/calendar.js"></script>
<script>
    function validateForm(){
                var date1=document.searchForm.start_date.value;
                var mdy = date1.split('-');
                var date1=mdy[0] +' '+mdy[1]+' '+mdy[2];
                var date1 = new Date(date1);

                var date2=document.searchForm.end_date.value;
                var mdy2 = date2.split('-');
                var date2=mdy2[0] +' '+mdy2[1]+' '+mdy2[2];
                var date2 = new Date(date2);
               var timeDiff = Math.abs(date2.getTime() - date1.getTime());
               var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
               if(diffDays>7)
               {
                alert('Kindly Select Dates In Span Of 7 Days Only');
                return false;
               }
               return true;
    }    
</script>
</head>
<?php
$start=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:'';
$end=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:'';
$rtype=isset($_REQUEST['type'])?$_REQUEST['type']:'BL';
$selmod=isset($_REQUEST['modid'])?$_REQUEST['modid']:"DIR";
$selcountry=isset($_REQUEST['country'])?$_REQUEST['country']:'IN';
echo '<body>
    
<FORM name="searchForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return validateForm()">
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<TR>
<TD bgcolor="#dff8ff" ALIGN="CENTER" colspan="4"><font COLOR =" #333399"><b>Conversion Report</b></font></TD>
</TR>
<TR>
<TD WIDTH="150" HEIGHT="30" STYLE="text-align:center">&nbsp;Select Period</TD>  
<TD>From:
<input name="start_date" type="text"  SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchForm.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="start_date" TYPE="text" readonly="readonly" value= '.$start.'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
To:
<input name="end_date" type="text"  SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.searchForm.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="end_date" TYPE="text" readonly="readonly" value= '.$end.'>
</TD>
<td STYLE="text-align:center">MODID</td>
<TD><select name="modid">';


foreach($modlist as $v)
{
    if($v==$selmod){
        echo '<option value="'.$v.'" selected> '.$v.'</option>'; 
    }else{
        echo '<option value="'.$v.'"> '.$v.'</option>'; 
    }	
} 
echo '</select></TR>';
echo '<TR>
<TD STYLE="text-align:center">&nbsp;Country</TD>
<TD>
<TABLE width="30%" BORDER="0" CELLPADDING="1" CELLSPACING="0">
<TR>';

echo '<TD><INPUT TYPE="RADIO" NAME="country" VALUE="" checked>&nbsp;All &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;<INPUT TYPE="RADIO" NAME="country" VALUE="IN"';
if($selcountry=="IN"){echo ' checked';}
echo '>&nbsp;India &nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;
<INPUT TYPE="RADIO" NAME="country" VALUE="FOR"';
if($selcountry=="FOR"){echo ' checked';}
echo '>&nbsp; Foreign &nbsp;<INPUT TYPE="RADIO" NAME="country" VALUE="CITY"';
if($selcountry=="CITY"){echo ' checked';}
echo '>&nbsp; City &nbsp;
</TD>';
'</TR>';
echo '</TABLE></TD>
<TD STYLE="text-align:center">&nbsp;Type</TD>
<TD>
<TABLE width="30%" BORDER="0" CELLPADDING="1" CELLSPACING="0">
<TR>';

echo '<TD><INPUT TYPE="RADIO" NAME="type" VALUE="BL"';
if($rtype=='BL'){echo ' checked';}
echo '>&nbsp;BL &nbsp;&nbsp;&nbsp&nbsp;
<INPUT TYPE="RADIO" NAME="type" VALUE="ENQ"';
if($rtype=="ENQ"){echo ' checked';}
echo '>&nbsp; ENQ &nbsp;&nbsp;&nbsp;<INPUT TYPE="RADIO" NAME="type" VALUE="INTENT"';
if($rtype=="INTENT"){echo ' checked';}
echo'>&nbsp;&nbsp&nbsp;INTENT</TD>';
'</TR>';
echo '</TABLE></TD></TR>';
echo '<TR>
<TD colspan="4" align="center">
<input type="hidden" name="action" value="sellstatus">
<INPUT TYPE="SUBMIT" NAME="Submit1" id="Submit1" VALUE="Search">
</TD>
</TR></table>
</FORM><br>'; 
if(isset($_REQUEST['Submit1']))
{
 echo '<center><table style="border-collapse: collapse;width:40%; align:center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
 <tbody><tr>
 <td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;background-color:
#d0f8be"><b>Heading</b></td>
 <td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;background-color:
#d0f8be">Count</td>
 </tr>';
 if($rtype=='INTENT')
    {
 echo '
 <tr>
 <td align="left" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Total Intent Captured</b></td>
 <td STYLE="text-align:left;background-color:#FFFFFF;">'.$data['CAPTURED_INTENTS'] .'</td>
 </tr>
  <tr>
 <td align="left" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Unique Intent Generated</b></td>
 <td STYLE="text-align:left;background-color:#FFFFFF;">'.$data['GENERATED_INTENTS'] .'</td>
 </tr>
 <tr>
 <td align="left" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Total Intent Approved</b></td>
 <td  STYLE="text-align:left;background-color:#FFFFFF;"> '.$data['APPROVED_INTENTS'] .'</td>
 </tr>
';
}elseif($rtype=='ENQ')
    {
 echo '
 <tr>
 <td align="center" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Total Enquiries generated</b></td>
 <td STYLE="text-align:left;background-color:#FFFFFF;">'.$data['generated'] .'</td>
 </tr>
 <tr>
 <td align="center" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Total Enquiries Approved</b></td>
 <td  STYLE="text-align:left;background-color:#FFFFFF;"> '.$data['enq_approved'] .'</td>
 </tr>
 <tr>
 <td align="center" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Unique Enquiry Sender</b></td>
 <td STYLE="text-align:left;background-color:#FFFFFF;">'.$data['unq_enq_sender'] .'</td>
 </tr>';
}
else
    {
 echo '<tr>
 <td align="center" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Unique BL Sender </b></td>
 <td STYLE="text-align:left;background-color:#FFFFFF;"> '.$data['unq_BL_sender'] .'</td>
 </tr>
 <tr>
<td align="center" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Total BL Generated </b></td>
<td STYLE="text-align:left;background-color:#FFFFFF;">'.$data['TOT_BL_GEN'] .'</td>
</tr>  
 <tr>
<td align="center" style="font-size:11px;padding:2px 4px;font-weight:bold;color:#454545;"><b>Total BL Approved </b></td>
<td STYLE="text-align:left;background-color:#FFFFFF;">'.$data['TOT_BL_APPR'] .'</td>
</tr>';
}
echo'</table>';
}

?>