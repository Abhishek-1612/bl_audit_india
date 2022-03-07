<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
       <title>Pending BL Approval Dashboard-3</title>
       <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
        <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
        <script language="javascript" src="/js/calendar.js"></script>
      	
        </head>
        <body> 
            
		   
<?php 
$start_date= Yii::app()->request->getParam('start_date','');
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));
$sel_pool= Yii::app()->request->getParam('drp_pool','All');
?>
<div style="margin:0px auto;width:1100px;font-family:arial;border:2px solid #e3eff8;padding:5px 30px;margin-top:0px">
<form name="searchForm" id="searchForm" method="post" style="margin-top:0;margin-bottom:0;">
Select Date:&nbsp;&nbsp;&nbsp;           
<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Select Pool:&nbsp;<select id="drp_pool" name="drp_pool" style="width:100px">
 <?php 
 if($sel_pool=='All'){
    echo '<option value="All" selected>--All--</option>';
 }else{
     echo '<option value="All">--All--</option>'; 
 }
 if($sel_pool=='Must_Call'){
    echo '<option value="Must_Call" selected>Must Call</option>';
 }else{
     echo '<option value="Must_Call">Must Call</option>'; 
 }
 if($sel_pool=='DNC'){
    echo '<option value="DNC" selected>DNC</option>';
 }else{
     echo '<option value="DNC">DNC</option>'; 
 }
 if($sel_pool=='Service'){
    echo '<option value="Service" selected>Service</option>';
 }else{
     echo '<option value="Service">Service</option>'; 
 }
  if($sel_pool=='Intent'){
    echo '<option value="Intent" selected>Intent</option>';
 }else{
     echo '<option value="Intent">Intent</option>'; 
 }
?>
</select>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="btnsubmit" id="btnsubmit" value="Generate">
</form></div><br>

<?php
$dtime= Yii::app()->request->getParam('start_date',strtoupper(date("d-M-Y")));  

if($_REQUEST['btnsubmit']){
$genDataSth=$data['genData'];
$pendData=$data['pendData'];$pendData_unique=$data['pendData_unique'];
$deletedEnquiry=$data['deletedEnquiry'];
$flagged=$data['flagged'];
$leadhourarray=$data['leadhourarray']; 

if($sel_pool=='All' && (strtotime(date("d-M-Y")) == strtotime(date("d-M-Y",strtotime($dtime))))){   
$PENDING_UNI_USER=isset($pendData['PENDING_UNI_USER'])?$pendData['PENDING_UNI_USER']:0; 
$PENDING_LEADS=isset($pendData['PENDING_LEADS'])?$pendData['PENDING_LEADS']:0; 
$PENDING_UNTOUCHED=isset($pendData['PENDING_UNTOUCHED'])?$pendData['PENDING_UNTOUCHED']:0; 
$attempt_1 = isset($pendData['ATTEMPT_1'])?$pendData['ATTEMPT_1']:0;
$attempt_2 = isset($pendData['ATTEMPT_2'])?$pendData['ATTEMPT_2']:0;
$attempt_3 = isset($pendData['ATTEMPT_3'])?$pendData['ATTEMPT_3']: 0;
$Must_Call = isset($pendData['PENDING_MUST_CALL'])?$pendData['PENDING_MUST_CALL']:0;
$DNC = isset($pendData['PENDING_DNC'])?$pendData['PENDING_DNC']:0;
$Service = isset($pendData['PENDING_SERVICE'])?$pendData['PENDING_SERVICE']: 0;
$Foreign = isset($pendData['PENDING_FOREIGN'])?$pendData['PENDING_FOREIGN']: 0;
$pend_intent = isset($pendData['PENDING_INTENT'])?$pendData['PENDING_INTENT']: 0;
$pend_procmart = isset($pendData['PENDING_PROCMART'])?$pendData['PENDING_PROCMART']: 0;


$Must_Call_user = isset($pendData_unique['PENDING_MUST_CALL_USER'])?$pendData_unique['PENDING_MUST_CALL_USER']:0;
$DNC_user = isset($pendData_unique['PENDING_DNC_USER'])?$pendData_unique['PENDING_DNC_USER']:0;
$Service_user = isset($pendData_unique['PENDING_SERVICE_USER'])?$pendData_unique['PENDING_SERVICE_USER']: 0;
$pend_intent_user = isset($pendData_unique['PENDING_INTENT_USER'])?$pendData_unique['PENDING_INTENT_USER']: 0;
$pend_procmart_user = isset($pendData_unique['PENDING_PROCMART_USER'])?$pendData_unique['PENDING_PROCMART_USER']: 0;
$Foreign_user = isset($pendData_unique['PENDING_FOREIGN_USER'])?$pendData_unique['PENDING_FOREIGN_USER']: 0;

echo '<br><div style="margin:0px auto;width:1100px;font-family:arial;border:2px solid #e3eff8;padding:5px 30px;margin-top:0px">
<div style="width:1087px; float:left; padding:2px 4px; 0 4px 4px;margin:0px;font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;line-height:15px;border:1px solid #c6def1;margin-bottom:10px">Pending Details</div>
<table width="99%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<td colspan="4" bgcolor="#FFFFFF"></td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Pool</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Leads</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Unique Users</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Redis Users</td>
</tr>
<tr>
 <td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Unique users</td>
 <td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$PENDING_UNI_USER.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Attempt 1</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$attempt_1.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Must_Call.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Must_Call_user.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$mustcall.'</td>
</tr>
<tr> 
 <td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
 <td  align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$PENDING_LEADS.'</td> 
 <td  align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Attempt 2</td>
 <td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$attempt_2.'</td>
<td  align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC</td>
<td  align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$DNC.'</td>
<td  align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$DNC_user.'</td>
<td  align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$dntcall.'</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Untouched</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545">'.$PENDING_UNTOUCHED.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Attempt 3</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$attempt_3.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Service</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Service.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Service_user.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$servicepool.'</td>
</tr>
<tr>
<td colspan="4" bgcolor="#FFFFFF"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Foreign</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Foreign.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Foreign_user.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$foreignpool.'</td>
</tr>
<tr>
<td colspan="4" bgcolor="#FFFFFF"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Intent</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_intent.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_intent_user.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$intentpool.'</td>
</tr>
<tr>
<td colspan="4" bgcolor="#FFFFFF"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Procmart</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_procmart.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_procmart_user.'</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$procmartpool.'</td>
</tr>
</table>  
  </br>
   <div style="width:1087px; float:left; padding:2px 4px; 0 4px 4px;margin:0px;font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;line-height:15px;border:1px solid #c6def1;margin-bottom:10px">Leads to be released</div>
            <table border=1 height="50%" bgcolor="#ededed" BORDERCOLOR="#c6def1">
<tr><td align="center"  bgcolor="#FFFFFF" style="font-size:10px;padding:2px 4px;color:#454545;"><b>0 to 1 Hour</b></td><td align="center"  bgcolor="#FFFFFF" style="font-size:11px;padding:2px 4px;color:#454545;">'.$leadhourarray['ZERO_ONE_HOUR'].'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:10px;padding:2px 4px;color:#454545;"><b>1 to 2 Hour</b></td><td align="center"  bgcolor="#FFFFFF" style="font-size:11px;padding:2px 4px;color:#454545;">'.$leadhourarray['ONE_TWO_HOUR'].'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:10px;padding:2px 4px;color:#454545;"><b>2 to 3 Hour</b></td><td align="center"  bgcolor="#FFFFFF" style="font-size:11px;padding:2px 4px;color:#454545;">'.$leadhourarray['TWO_THREE_HOUR'].'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:10px;padding:2px 4px;color:#454545;"><b>3 to 4 Hour</b></td><td align="center"  bgcolor="#FFFFFF" style="font-size:11px;padding:2px 4px;color:#454545;">'.$leadhourarray['THREE_FOUR_HOUR'].'</td>
</tr>

</table>
            </div><br>
           ';

 }
  
          echo '<div style="margin:0px auto;width:1100px;font-family:arial;border:2px solid #e3eff8;padding:5px 30px;margin-top:0px">
            <div style="width:1087px; float:left; padding:2px 4px; 0 4px 4px;margin:0px;font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;line-height:15px;border:1px solid #c6def1;margin-bottom:10px">Today\'s Generation (Working Hour wise)
            <div style="float:right; font-size:14px;  ">Report Generation Date: '. date('d-M-Y H:i:s').'</div></div>
            <table width="100%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr>
                <td width="65" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545"></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>9-10</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>10-11</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>11-12</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>12-13</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>13-14</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>14-15</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>15-16</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>16-17</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>17-18</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>18-19</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>19-20</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>20-21</b></td>  
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Total</b></td> 
                </tr>';              
            echo '<tr><td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Unique users</td>';
       
           
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT10'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT11'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT12'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT13'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT14'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT15'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT16'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT17'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT18'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT19'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT20'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT21'].'</td>';  
            $total_user=$genDataSth['UNI_USER_CNT10'] + $genDataSth['UNI_USER_CNT11'] + $genDataSth['UNI_USER_CNT12'] + $genDataSth['UNI_USER_CNT13'] + $genDataSth['UNI_USER_CNT14'] +  $genDataSth['UNI_USER_CNT15'] + $genDataSth['UNI_USER_CNT16'] + $genDataSth['UNI_USER_CNT17'] + $genDataSth['UNI_USER_CNT18'] + $genDataSth['UNI_USER_CNT19'] + $genDataSth['UNI_USER_CNT20'] + $genDataSth['UNI_USER_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_user.'</td>'; 
       
                echo '</tr>'; 
       echo '<tr> <td colspan="14" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
        // Total Enquiries count
      echo '<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Total Enquiries</td>';
          
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT10'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT11'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT12'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT13'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT14'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT15'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT16'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT17'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT18'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT19'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT20'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT21'].'</td>';
        $total_enq=$genDataSth['ENQ_CNT10'] + $genDataSth['ENQ_CNT11'] + $genDataSth['ENQ_CNT12'] + $genDataSth['ENQ_CNT13'] + $genDataSth['ENQ_CNT14'] +  $genDataSth['ENQ_CNT15'] + $genDataSth['ENQ_CNT16'] + $genDataSth['ENQ_CNT17'] + $genDataSth['ENQ_CNT18'] + $genDataSth['ENQ_CNT19'] + $genDataSth['ENQ_CNT20'] + $genDataSth['ENQ_CNT21'];
        echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_enq.'</td>'; 
           
         echo '</tr>';  
        echo '<tr> <td colspan="14" bgcolor="#FFFFFF" style="height:10px"></td></tr>';       
       // Total Approved count
      echo '<tr>
            <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Approved</td>';
           
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT10'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT11'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT12'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT13'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT14'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT15'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT16'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT17'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT18'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT19'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT20'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT21'].'</td>';
          $total_app_enq=$genDataSth['ENQ_APPROVED_CNT10'] + $genDataSth['ENQ_APPROVED_CNT11'] + $genDataSth['ENQ_APPROVED_CNT12'] + $genDataSth['ENQ_APPROVED_CNT13'] + $genDataSth['ENQ_APPROVED_CNT14'] +  $genDataSth['ENQ_APPROVED_CNT15'] + $genDataSth['ENQ_APPROVED_CNT16'] + $genDataSth['ENQ_APPROVED_CNT17'] + $genDataSth['ENQ_APPROVED_CNT18'] + $genDataSth['ENQ_APPROVED_CNT19'] + $genDataSth['ENQ_APPROVED_CNT20'] + $genDataSth['ENQ_APPROVED_CNT21'];
         echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_app_enq.'</td>'; 
         echo '</tr>';    echo '</tr>';  
        // Total Deleted count
      echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Deleted</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT10'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT11'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT12'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT13'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT14'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT15'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT16'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT17'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT18'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT19'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT20'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT21'].'</td>';
          $total_deleted=$deletedEnquiry['ENQ_DELETED_CNT10'] + $deletedEnquiry['ENQ_DELETED_CNT11'] + $deletedEnquiry['ENQ_DELETED_CNT12'] + $deletedEnquiry['ENQ_DELETED_CNT13'] + $deletedEnquiry['ENQ_DELETED_CNT14'] +  $deletedEnquiry['ENQ_DELETED_CNT15'] + $deletedEnquiry['ENQ_DELETED_CNT16'] + $deletedEnquiry['ENQ_DELETED_CNT17'] + $deletedEnquiry['ENQ_DELETED_CNT18'] + $deletedEnquiry['ENQ_DELETED_CNT19'] + $deletedEnquiry['ENQ_DELETED_CNT20'] + $deletedEnquiry['ENQ_DELETED_CNT21'];
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$total_deleted.'</td>'; 
       echo '</tr>';  
       
        // Total Flagged count
      echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Flagged</td>';
       echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT10'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT11'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT12'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT13'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT14'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT15'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT16'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT17'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT18'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT19'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT20'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT21'].'</td>';
           $total_flagged= $flagged['FLAGGED_CNT10'] + $flagged['FLAGGED_CNT11'] + $flagged['FLAGGED_CNT12'] + $flagged['FLAGGED_CNT13'] + $flagged['FLAGGED_CNT14'] +  $flagged['FLAGGED_CNT15'] + $flagged['FLAGGED_CNT16'] + $flagged['FLAGGED_CNT17'] + $flagged['FLAGGED_CNT18'] + $flagged['FLAGGED_CNT19'] + $flagged['FLAGGED_CNT20'] + $flagged['FLAGGED_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$total_flagged.'</td>'; 
       echo '</tr>'; 
       // Total Pending count
      echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Pending</td>';
      $p10=$genDataSth['ENQ_CNT10'] - $genDataSth['ENQ_APPROVED_CNT10'] - $deletedEnquiry['ENQ_DELETED_CNT10'] - $flagged['FLAGGED_CNT10'];
      $p11=$genDataSth['ENQ_CNT11'] - $genDataSth['ENQ_APPROVED_CNT11'] - $deletedEnquiry['ENQ_DELETED_CNT11'] - $flagged['FLAGGED_CNT11'];
      $p12=$genDataSth['ENQ_CNT12'] - $genDataSth['ENQ_APPROVED_CNT12'] - $deletedEnquiry['ENQ_DELETED_CNT12'] - $flagged['FLAGGED_CNT12'];
      $p13=$genDataSth['ENQ_CNT13'] - $genDataSth['ENQ_APPROVED_CNT13'] - $deletedEnquiry['ENQ_DELETED_CNT13'] - $flagged['FLAGGED_CNT13'];
      $p14=$genDataSth['ENQ_CNT14'] - $genDataSth['ENQ_APPROVED_CNT14'] - $deletedEnquiry['ENQ_DELETED_CNT14'] - $flagged['FLAGGED_CNT14'];
      $p15=$genDataSth['ENQ_CNT15'] - $genDataSth['ENQ_APPROVED_CNT15'] - $deletedEnquiry['ENQ_DELETED_CNT15'] - $flagged['FLAGGED_CNT15'];
      $p16=$genDataSth['ENQ_CNT16'] - $genDataSth['ENQ_APPROVED_CNT16'] - $deletedEnquiry['ENQ_DELETED_CNT16'] - $flagged['FLAGGED_CNT16'];
      $p17=$genDataSth['ENQ_CNT17'] - $genDataSth['ENQ_APPROVED_CNT17'] - $deletedEnquiry['ENQ_DELETED_CNT17'] - $flagged['FLAGGED_CNT17'];
      $p18=$genDataSth['ENQ_CNT18'] - $genDataSth['ENQ_APPROVED_CNT18'] - $deletedEnquiry['ENQ_DELETED_CNT18'] - $flagged['FLAGGED_CNT18'];
      $p19=$genDataSth['ENQ_CNT19'] - $genDataSth['ENQ_APPROVED_CNT19'] - $deletedEnquiry['ENQ_DELETED_CNT19'] - $flagged['FLAGGED_CNT19'];
      $p20=$genDataSth['ENQ_CNT20'] - $genDataSth['ENQ_APPROVED_CNT20'] - $deletedEnquiry['ENQ_DELETED_CNT20'] - $flagged['FLAGGED_CNT20'];
      $p21=$genDataSth['ENQ_CNT21'] - $genDataSth['ENQ_APPROVED_CNT21'] - $deletedEnquiry['ENQ_DELETED_CNT21'] - $flagged['FLAGGED_CNT21'];
      
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p10.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p11.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p12.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p13.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p14.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p15.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p16.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p17.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p18.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p19.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p20.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p21.'</td>';
           $total_pending = $total_enq - $total_app_enq - $total_deleted - $total_flagged;
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$total_pending.'</td>'; 
       echo '</tr>'; 
       
       
      if($sel_pool=='All' ){
            echo '<tr> <td colspan="14" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
      // Total Must Call count
             echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Must Call</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT20'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT21'].'</td>';
            $total_must_call=$genDataSth['MUST_CALL_CNT10'] + $genDataSth['MUST_CALL_CNT11'] + $genDataSth['MUST_CALL_CNT12'] + $genDataSth['MUST_CALL_CNT13'] + $genDataSth['MUST_CALL_CNT14'] +  $genDataSth['MUST_CALL_CNT15'] + $genDataSth['MUST_CALL_CNT16'] + $genDataSth['MUST_CALL_CNT17'] + $genDataSth['MUST_CALL_CNT18'] + $genDataSth['MUST_CALL_CNT19'] + $genDataSth['MUST_CALL_CNT20'] + $genDataSth['MUST_CALL_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$total_must_call.'</td>'; 
            echo '</tr>';
       
       // Total DNC count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">DNC</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT20'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT21'].'</td>'; 
            $total_dnc=$genDataSth['DNC_CALL_CNT10'] + $genDataSth['DNC_CALL_CNT11'] + $genDataSth['DNC_CALL_CNT12'] + $genDataSth['DNC_CALL_CNT13'] + $genDataSth['DNC_CALL_CNT14'] +  $genDataSth['DNC_CALL_CNT15'] + $genDataSth['DNC_CALL_CNT16'] + $genDataSth['DNC_CALL_CNT17'] + $genDataSth['DNC_CALL_CNT18'] + $genDataSth['DNC_CALL_CNT19'] + $genDataSth['DNC_CALL_CNT20'] + $genDataSth['DNC_CALL_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_dnc.'</td>'; 
       echo '</tr>';
      
        // Total SERVICE count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Service</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT20'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT21'].'</td>'; 
            $total_service=$genDataSth['SERVICE_CALL_CNT10'] + $genDataSth['SERVICE_CALL_CNT11'] + $genDataSth['SERVICE_CALL_CNT12'] + $genDataSth['SERVICE_CALL_CNT13'] + $genDataSth['SERVICE_CALL_CNT14'] +  $genDataSth['SERVICE_CALL_CNT15'] + $genDataSth['SERVICE_CALL_CNT16'] + $genDataSth['SERVICE_CALL_CNT17'] + $genDataSth['SERVICE_CALL_CNT18'] + $genDataSth['SERVICE_CALL_CNT19'] + $genDataSth['SERVICE_CALL_CNT20'] + $genDataSth['SERVICE_CALL_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_service.'</td>'; 
       echo '</tr>';
       
       
          // Total Intent count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Intent</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT20'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['INTENT_CALL_CNT21'].'</td>'; 
            $total_service=$genDataSth['INTENT_CALL_CNT10'] + $genDataSth['INTENT_CALL_CNT11'] + $genDataSth['INTENT_CALL_CNT12'] + $genDataSth['INTENT_CALL_CNT13'] + $genDataSth['INTENT_CALL_CNT14'] +  $genDataSth['INTENT_CALL_CNT15'] + $genDataSth['INTENT_CALL_CNT16'] + $genDataSth['INTENT_CALL_CNT17'] + $genDataSth['INTENT_CALL_CNT18'] + $genDataSth['INTENT_CALL_CNT19'] + $genDataSth['INTENT_CALL_CNT20'] + $genDataSth['INTENT_CALL_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_service.'</td>'; 
       echo '</tr>';
       
       
        echo '<tr> <td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
        }
        ///////////////pending
        
     
    
          echo '<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Timliness</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT10']+ $deletedEnquiry['ENQ_DELETED15_CNT10'])*100/$genDataSth['ENQ_CNT10'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT11']+ $deletedEnquiry['ENQ_DELETED15_CNT11'])*100/$genDataSth['ENQ_CNT11'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT12']+ $deletedEnquiry['ENQ_DELETED15_CNT12'])*100/$genDataSth['ENQ_CNT12'],2).'%</td>';         
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT13']+ $deletedEnquiry['ENQ_DELETED15_CNT13'])*100/$genDataSth['ENQ_CNT13'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT14']+ $deletedEnquiry['ENQ_DELETED15_CNT14'])*100/$genDataSth['ENQ_CNT14'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT15']+ $deletedEnquiry['ENQ_DELETED15_CNT15'])*100/$genDataSth['ENQ_CNT15'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT16']+ $deletedEnquiry['ENQ_DELETED15_CNT16'])*100/$genDataSth['ENQ_CNT16'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT17']+ $deletedEnquiry['ENQ_DELETED15_CNT17'])*100/$genDataSth['ENQ_CNT17'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT18']+ $deletedEnquiry['ENQ_DELETED15_CNT18'])*100/$genDataSth['ENQ_CNT18'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT19']+ $deletedEnquiry['ENQ_DELETED15_CNT19'])*100/$genDataSth['ENQ_CNT19'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT20']+ $deletedEnquiry['ENQ_DELETED15_CNT20'])*100/$genDataSth['ENQ_CNT20'],2).'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round(($genDataSth['ENQ_APPROVED15_CNT21']+ $deletedEnquiry['ENQ_DELETED15_CNT21'])*100/$genDataSth['ENQ_CNT21'],2).'%</td>';
           $total_timleness=$genDataSth['ENQ_APPROVED15_CNT10']+ $deletedEnquiry['ENQ_DELETED15_CNT10']+
           $genDataSth['ENQ_APPROVED15_CNT11']+ $deletedEnquiry['ENQ_DELETED15_CNT11']+
           $genDataSth['ENQ_APPROVED15_CNT12']+ $deletedEnquiry['ENQ_DELETED15_CNT12']+
           $genDataSth['ENQ_APPROVED15_CNT13']+ $deletedEnquiry['ENQ_DELETED15_CNT13']+
           $genDataSth['ENQ_APPROVED15_CNT14']+ $deletedEnquiry['ENQ_DELETED15_CNT14']+
           $genDataSth['ENQ_APPROVED15_CNT15']+ $deletedEnquiry['ENQ_DELETED15_CNT15']+
           $genDataSth['ENQ_APPROVED15_CNT16']+ $deletedEnquiry['ENQ_DELETED15_CNT16']+
           $genDataSth['ENQ_APPROVED15_CNT17']+ $deletedEnquiry['ENQ_DELETED15_CNT17']+
           $genDataSth['ENQ_APPROVED15_CNT18']+ $deletedEnquiry['ENQ_DELETED15_CNT18']+
           $genDataSth['ENQ_APPROVED15_CNT19']+ $deletedEnquiry['ENQ_DELETED15_CNT19']+
           $genDataSth['ENQ_APPROVED15_CNT20']+ $deletedEnquiry['ENQ_DELETED15_CNT20']+
           $genDataSth['ENQ_APPROVED15_CNT21']+ $deletedEnquiry['ENQ_DELETED15_CNT21'];
          
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round($total_timleness*100/$total_enq,2).'%</td>';
         echo '</tr>'; 
         $display_per_10=round(($flagged['ENQ_DISPLAY_CNT10'])*100/$genDataSth['ENQ_CNT10'],2);
         $display_per_11=round(($flagged['ENQ_DISPLAY_CNT11'])*100/$genDataSth['ENQ_CNT11'],2);
         $display_per_12=round(($flagged['ENQ_DISPLAY_CNT12'])*100/$genDataSth['ENQ_CNT12'],2);
         $display_per_13=round(($flagged['ENQ_DISPLAY_CNT13'])*100/$genDataSth['ENQ_CNT13'],2);
         $display_per_14=round(($flagged['ENQ_DISPLAY_CNT14'])*100/$genDataSth['ENQ_CNT14'],2);
         $display_per_15=round(($flagged['ENQ_DISPLAY_CNT15'])*100/$genDataSth['ENQ_CNT15'],2);
         $display_per_16=round(($flagged['ENQ_DISPLAY_CNT16'])*100/$genDataSth['ENQ_CNT16'],2);
         $display_per_17=round(($flagged['ENQ_DISPLAY_CNT17'])*100/$genDataSth['ENQ_CNT17'],2);
         $display_per_18=round(($flagged['ENQ_DISPLAY_CNT18'])*100/$genDataSth['ENQ_CNT18'],2);
         $display_per_19=round(($flagged['ENQ_DISPLAY_CNT19'])*100/$genDataSth['ENQ_CNT19'],2);
         $display_per_20=round(($flagged['ENQ_DISPLAY_CNT20'])*100/$genDataSth['ENQ_CNT20'],2);
         $display_per_21=round(($flagged['ENQ_DISPLAY_CNT21'])*100/$genDataSth['ENQ_CNT21'],2);
         $cnt_y=0;
         if(($display_per_10 >=95))
         {
          $cnt_y++;
          $display_per_flag_10='Y';
         }
         else
         $display_per_flag_10='N';
         
         if(($display_per_11 >=95))
         {
          $cnt_y++;
          $display_per_flag_11='Y';
         }
         else
         $display_per_flag_11='N';
         
         if(($display_per_12 >=95))
         {
          $cnt_y++;
          $display_per_flag_12='Y';
         }
         else
         $display_per_flag_12='N';
         
         if(($display_per_13 >=95))
         {
          $cnt_y++;
          $display_per_flag_13='Y';
         }
         else
         $display_per_flag_13='N';
         
         if(($display_per_14 >=95))
         {
          $cnt_y++;
          $display_per_flag_14='Y';
         }
         else
         $display_per_flag_14='N';
         
         if(($display_per_15 >=95))
         {
          $cnt_y++;
          $display_per_flag_15='Y';
         }
         else
         $display_per_flag_15='N';
         
         if(($display_per_16 >=95))
         {
          $cnt_y++;
          $display_per_flag_16='Y';
         }
         else
         $display_per_flag_16='N';
         
         if(($display_per_17 >=95))
         {
          $cnt_y++;
          $display_per_flag_17='Y';
         }
         else
         $display_per_flag_17='N';
         
         if(($display_per_18 >=95))
         {
          $cnt_y++;
          $display_per_flag_18='Y';
         }
         else
         $display_per_flag_18='N';
         
         if(($display_per_19 >=95))
         {
          $cnt_y++;
          $display_per_flag_19='Y';
         }
         else
         $display_per_flag_19='N';
         
         if(($display_per_20 >=95))
         {
          $cnt_y++;
          $display_per_flag_20='Y';
         }
         else
         $display_per_flag_20='N';
         
         if(($display_per_21 >=95))
         {
          $cnt_y++;
          $display_per_flag_21='Y';
         }
         else
         $display_per_flag_21='N';
         
         $total_timleness=($flagged['ENQ_DISPLAY_CNT10'])
           +($flagged['ENQ_DISPLAY_CNT11'])+
           ($flagged['ENQ_DISPLAY_CNT12'])+
           ($flagged['ENQ_DISPLAY_CNT13'])+
           ($flagged['ENQ_DISPLAY_CNT14'])+
           ($flagged['ENQ_DISPLAY_CNT15'])+
           ($flagged['ENQ_DISPLAY_CNT16'])+
           ($flagged['ENQ_DISPLAY_CNT17'])+
           ($flagged['ENQ_DISPLAY_CNT18'])+
           ($flagged['ENQ_DISPLAY_CNT19'])+
           ($flagged['ENQ_DISPLAY_CNT20'])+
           ($flagged['ENQ_DISPLAY_CNT21']);
           $total_timleness_per=round($total_timleness*100/$total_enq,2);
           $total_timleness_per_flag=round(($cnt_y*100/12),2);
           echo '<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Display %</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_10.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_11.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_12.'%</td>';         
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_13.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_14.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_15.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_16.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_17.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_18.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_19.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_20.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_21.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$total_timleness_per.'%</td>';
         echo '</tr>';
          echo '<tr> <td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
       
         
        if(isset($data['adfarray']['APP_DEL_FLAG_HOUR']) and $data['adfarray']['APP_DEL_FLAG_HOUR']!=NULL)
        {$cnti=0;
        $appd='<tr> <td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr><tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Approval Time in Hr</td>';
        $deld='<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Deletion Time in Hr</td>';
        $flagd='<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Flagging Time in Hr</td>';
        $appdp='<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Approval Time %</td>';
        $deldp='<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Deletion Time %</td>';
        $flagdp='<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Flagging Time %</td>';

        foreach($data['adfarray']['APP_DEL_FLAG_HOUR'] as $value)
        {
         
         $tempcnt=0;
         $tempcnt=$data['adfarray']['TOTAL_APP_TIME'][$cnti]+$data['adfarray']['TOTAL_DEL_TIME'][$cnti]+$data['adfarray']['TOTAL_FLAG_TIME'][$cnti];
         
         $appd.= '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$data['adfarray']['APP_TIME_HR'][$cnti].'</td>';
         $deld.= '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$data['adfarray']['DEL_TIME_HR'][$cnti].'</td>';
         $flagd.= '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$data['adfarray']['FLAG_TIME_HR'][$cnti].'</td>';
         
         $appdp.= '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round($data['adfarray']['TOTAL_APP_TIME'][$cnti]*100/$tempcnt,2).' %</td>';
         $deldp.= '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round($data['adfarray']['TOTAL_DEL_TIME'][$cnti]*100/$tempcnt,2).' %</td>';
         $flagdp.= '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.round($data['adfarray']['TOTAL_FLAG_TIME'][$cnti]*100/$tempcnt,2).' %</td>';
         $cnti++;
        }
        
        echo $appd;
        echo $deld;
        echo $flagd;
        echo $appdp;
        echo $deldp;
        echo $flagdp;
      }
       echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Associates</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER20'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER21'].'</td>'; 
            
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER9_21'].'</td>'; 
       echo '</tr>';
      echo '</table></div> ';
      
   echo '<br/><div style="margin:0px auto;width:1100px;font-family:arial;border:2px solid #e3eff8;padding:5px 30px;margin-top:0px">
            <div style="width:1087px; float:left; padding:2px 4px; 0 4px 4px;margin:0px;font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;line-height:15px;border:1px solid #c6def1;margin-bottom:10px">Adherence
            <div style="float:right; font-size:14px;  "></div></div>
            <table width="100%" border="1" bordercolor="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tbody><tr>
                <td width="65" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545"></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>9-10</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>10-11</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>11-12</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>12-13</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>13-14</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>14-15</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>15-16</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>16-17</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>17-18</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>18-19</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>19-20</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>20-21</b></td>  
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Total</b></td> 
                </tr>
                <tr>
                 <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Fresh</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_10.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_11.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_12.'</td>         
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_13.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_14.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_15.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_16.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_17.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_18.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_19.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_20.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$display_per_flag_21.'</td>
		<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$total_timleness_per_flag.'%</td>
               </tr></tbody></table></div>';   
// Non Hourly
      
echo '<br><div style="margin:0px auto;width:1100px;font-family:arial;border:2px solid #e3eff8;padding:5px 30px;margin-top:0px">
            <div style="width:1087px; float:left; padding:2px 4px; 0 4px 4px;margin:0px;font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;line-height:15px;border:1px solid #c6def1;margin-bottom:10px">Today\'s Generation (Non-Working Hour wise)
           </div>
            <table width="100%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr>
                <td width="65" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545"></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>0-1</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>1-2</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>2-3</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>3-4</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>4-5</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>5-6</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>6-7</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>7-8</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>8-9</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>21-22</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>22-23</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>23-24</b></td>  
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Total</b></td> 
                </tr>';              
            echo '<tr><td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Unique users</td>';
       
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT1'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT2'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT3'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT4'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT5'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT6'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT7'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT8'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT9'].'</td>';          
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT22'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT23'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['UNI_USER_CNT24'].'</td>';
           $totalnw_user=$genDataSth['UNI_USER_CNT1']+$genDataSth['UNI_USER_CNT2']+$genDataSth['UNI_USER_CNT3']+$genDataSth['UNI_USER_CNT4']+$genDataSth['UNI_USER_CNT5']+$genDataSth['UNI_USER_CNT6']+$genDataSth['UNI_USER_CNT7']+$genDataSth['UNI_USER_CNT8']+$genDataSth['UNI_USER_CNT9']+$genDataSth['UNI_USER_CNT22']+$genDataSth['UNI_USER_CNT23']+$genDataSth['UNI_USER_CNT24'];
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_user.'</td>';
       echo '</tr>'; 
       echo '<tr><td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
        // Total Enquiries count
      echo '<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Total Enquiries</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT1'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT2'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT3'].'</td>';         
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT4'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT5'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT6'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT7'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT8'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT9'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT22'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT23'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_CNT24'].'</td>';
           $totalnw_enq=$genDataSth['ENQ_CNT1']+$genDataSth['ENQ_CNT2']+$genDataSth['ENQ_CNT3']+$genDataSth['ENQ_CNT4']+$genDataSth['ENQ_CNT5']+$genDataSth['ENQ_CNT6']+$genDataSth['ENQ_CNT7']+$genDataSth['ENQ_CNT8']+$genDataSth['ENQ_CNT9']+$genDataSth['ENQ_CNT22']+$genDataSth['ENQ_CNT23']+$genDataSth['ENQ_CNT24'];
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_enq.'</td>';
         echo '</tr>';  
        echo '<tr> <td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr>';       
       // Total Approved count
      echo '<tr>
            <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Approved</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT1'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT2'].'</td>';          
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT3'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT4'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT5'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT6'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT7'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT8'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT9'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT22'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT23'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT24'].'</td>';
           $totalnw_app_enq=$genDataSth['ENQ_APPROVED_CNT1']+$genDataSth['ENQ_APPROVED_CNT2']+$genDataSth['ENQ_APPROVED_CNT3']+$genDataSth['ENQ_APPROVED_CNT4']+$genDataSth['ENQ_APPROVED_CNT5']+$genDataSth['ENQ_APPROVED_CNT6']+$genDataSth['ENQ_APPROVED_CNT7']+$genDataSth['ENQ_APPROVED_CNT8']+$genDataSth['ENQ_APPROVED_CNT9']+$genDataSth['ENQ_APPROVED_CNT22']+$genDataSth['ENQ_APPROVED_CNT23']+$genDataSth['ENQ_APPROVED_CNT24'];
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_app_enq.'</td>';
         echo '</tr>';   
        // Total Deleted count
      echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Deleted</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT1'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT2'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT3'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT4'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT5'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT6'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT7'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT8'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT9'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT22'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT23'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$deletedEnquiry['ENQ_DELETED_CNT24'].'</td>';
           $totalnw_del=$deletedEnquiry['ENQ_DELETED_CNT1']+$deletedEnquiry['ENQ_DELETED_CNT2']+$deletedEnquiry['ENQ_DELETED_CNT3']+$deletedEnquiry['ENQ_DELETED_CNT4']+$deletedEnquiry['ENQ_DELETED_CNT5']+$deletedEnquiry['ENQ_DELETED_CNT6']+$deletedEnquiry['ENQ_DELETED_CNT7']+$deletedEnquiry['ENQ_DELETED_CNT8']+$deletedEnquiry['ENQ_DELETED_CNT9']+$deletedEnquiry['ENQ_DELETED_CNT22']+$deletedEnquiry['ENQ_DELETED_CNT23']+$deletedEnquiry['ENQ_DELETED_CNT24'];
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_del.'</td>';
           echo '</tr>';  
       
        // Total Flagged count
      echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Flagged</td>';     
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT1'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT2'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT3'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT4'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT5'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT6'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT7'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT8'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT9'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT22'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT23'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$flagged['FLAGGED_CNT24'].'</td>';
           $totalnw_flag=$flagged['FLAGGED_CNT1']+$flagged['FLAGGED_CNT2']+$flagged['FLAGGED_CNT3']+$flagged['FLAGGED_CNT4']+$flagged['FLAGGED_CNT5']+$flagged['FLAGGED_CNT6']+$flagged['FLAGGED_CNT7']+$flagged['FLAGGED_CNT8']+$flagged['FLAGGED_CNT9']+$flagged['FLAGGED_CNT22']+$flagged['FLAGGED_CNT23']+$flagged['FLAGGED_CNT24'];
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_flag.'</td>';
       echo '</tr>'; 
       
          // Total Pending count
      echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Pending</td>';
           $p1=$genDataSth['ENQ_CNT1'] - $genDataSth['ENQ_APPROVED_CNT1'] - $deletedEnquiry['ENQ_DELETED_CNT1'] - $flagged['FLAGGED_CNT1'];
           $p2=$genDataSth['ENQ_CNT2'] - $genDataSth['ENQ_APPROVED_CNT2'] - $deletedEnquiry['ENQ_DELETED_CNT2'] - $flagged['FLAGGED_CNT2'];
           $p3=$genDataSth['ENQ_CNT3'] - $genDataSth['ENQ_APPROVED_CNT3'] - $deletedEnquiry['ENQ_DELETED_CNT3'] - $flagged['FLAGGED_CNT3'];
           $p4=$genDataSth['ENQ_CNT4'] - $genDataSth['ENQ_APPROVED_CNT4'] - $deletedEnquiry['ENQ_DELETED_CNT4'] - $flagged['FLAGGED_CNT4'];
           $p5=$genDataSth['ENQ_CNT5'] - $genDataSth['ENQ_APPROVED_CNT5'] - $deletedEnquiry['ENQ_DELETED_CNT5'] - $flagged['FLAGGED_CNT5'];
           $p6=$genDataSth['ENQ_CNT6'] - $genDataSth['ENQ_APPROVED_CNT6'] - $deletedEnquiry['ENQ_DELETED_CNT6'] - $flagged['FLAGGED_CNT6'];
           $p7=$genDataSth['ENQ_CNT7'] - $genDataSth['ENQ_APPROVED_CNT7'] - $deletedEnquiry['ENQ_DELETED_CNT7'] - $flagged['FLAGGED_CNT7'];
           $p8=$genDataSth['ENQ_CNT8'] - $genDataSth['ENQ_APPROVED_CNT8'] - $deletedEnquiry['ENQ_DELETED_CNT8'] - $flagged['FLAGGED_CNT8'];
           $p9=$genDataSth['ENQ_CNT9'] - $genDataSth['ENQ_APPROVED_CNT9'] - $deletedEnquiry['ENQ_DELETED_CNT9'] - $flagged['FLAGGED_CNT9'];
           $p22=$genDataSth['ENQ_CNT22'] - $genDataSth['ENQ_APPROVED_CNT22'] - $deletedEnquiry['ENQ_DELETED_CNT22'] - $flagged['FLAGGED_CNT22'];
           $p23=$genDataSth['ENQ_CNT23'] - $genDataSth['ENQ_APPROVED_CNT23'] - $deletedEnquiry['ENQ_DELETED_CNT23'] - $flagged['FLAGGED_CNT23'];
           $p24=$genDataSth['ENQ_CNT24'] - $genDataSth['ENQ_APPROVED_CNT24'] - $deletedEnquiry['ENQ_DELETED_CNT24'] - $flagged['FLAGGED_CNT24'];
           
           
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p1.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p2.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p3.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p4.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p5.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p6.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p7.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p8.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p9.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p22.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p23.'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$p24.'</td>';
           $totalnw_pending=$totalnw_enq - $totalnw_app_enq - $totalnw_del - $totalnw_flag;
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_pending.'</td>';
       echo '</tr>'; 
       
       if($sel_pool=='All'){
       echo '<tr> <td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
      // Total Must Call count
      echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Must Call</td>';  
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT1'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT2'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT3'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT4'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT5'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT6'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT7'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT8'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT9'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT22'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT23'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['MUST_CALL_CNT24'].'</td>'; 
            $totalnw_must_call= $genDataSth['MUST_CALL_CNT1']+ $genDataSth['MUST_CALL_CNT2']+ $genDataSth['MUST_CALL_CNT3']+ $genDataSth['MUST_CALL_CNT4']+ $genDataSth['MUST_CALL_CNT5']+ $genDataSth['MUST_CALL_CNT6']+ $genDataSth['MUST_CALL_CNT7']+ $genDataSth['MUST_CALL_CNT8']+ $genDataSth['MUST_CALL_CNT9']+ $genDataSth['MUST_CALL_CNT22']+ $genDataSth['MUST_CALL_CNT23']+ $genDataSth['MUST_CALL_CNT24'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_must_call.'</td>';
            echo '</tr>';
       
       // Total DNC count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">DNC</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT1'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT2'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT3'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT4'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT5'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT6'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT7'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT8'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT9'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT22'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT23'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_CNT24'].'</td>'; 
            $totalnw_dnc_call= $genDataSth['DNC_CALL_CNT1']+ $genDataSth['DNC_CALL_CNT2']+ $genDataSth['DNC_CALL_CNT3']+ $genDataSth['DNC_CALL_CNT4']+ $genDataSth['DNC_CALL_CNT5']+ $genDataSth['DNC_CALL_CNT6']+ $genDataSth['DNC_CALL_CNT7']+ $genDataSth['DNC_CALL_CNT8']+ $genDataSth['DNC_CALL_CNT9']+ $genDataSth['DNC_CALL_CNT22']+ $genDataSth['DNC_CALL_CNT23']+ $genDataSth['DNC_CALL_CNT24'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_dnc_call.'</td>';
            echo '</tr>';
      
             // Total SERVICE count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Service</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT1'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT2'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT3'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT4'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT5'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT6'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT7'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT8'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT21'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT22'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT23'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['SERVICE_CALL_CNT24'].'</td>'; 
            $totalnw_service_call= $genDataSth['SERVICE_CALL_CNT1']+ $genDataSth['SERVICE_CALL_CNT2']+ $genDataSth['SERVICE_CALL_CNT3']+ $genDataSth['SERVICE_CALL_CNT4']+ $genDataSth['SERVICE_CALL_CNT5']+ $genDataSth['SERVICE_CALL_CNT6']+ $genDataSth['SERVICE_CALL_CNT7']+ $genDataSth['SERVICE_CALL_CNT8']+ $genDataSth['SERVICE_CALL_CNT9']+ $genDataSth['SERVICE_CALL_CNT22']+ $genDataSth['SERVICE_CALL_CNT23']+ $genDataSth['SERVICE_CALL_CNT24'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_service_call.'</td>';
            echo '</tr>';
       }
           echo '<tr> <td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
           echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Associates</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER1'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER2'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER3'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER4'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER5'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER6'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER7'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER8'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER9'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER22'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER23'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['ENQ_APPROVED_CNT_USER24'].'</td>'; 
           
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.($genDataSth['ENQ_APPROVED_CNT_USER1_9']+$genDataSth['ENQ_APPROVED_CNT_USER21_24']).'</td>'; 
       echo '</tr>';
      echo '</table></div> ';  
      
}

  ?>
        </body></html>