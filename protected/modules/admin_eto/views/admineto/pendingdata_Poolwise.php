<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
       <title>Pending BL Approval Dashboard-3</title>
       <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
        <script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
        <script language="javascript" src="/js/calendar.js"></script>
        <script type="text/javascript">
    _gaq.push(['_setAccount', 'UA-28761981-2']);
    _gaq.push(['_setDomainName', '.intermesh.net']);
    _gaq.push(['_setSiteSpeedSampleRate', 10]);
    _gaq.push(['_trackPageview','<?php echo $_SERVER['REQUEST_URI'];?>']);
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();</script>
<!--google analytics async code end-->		
        </head>
        <body> 
            
		   
<?php 
$approvalData=$data['approvalData'];
$pendingData=$data['pendingData'];
$deletedData=$data['deletedData'];
$flaggedData=$data['flaggedData'];

//$leadhourarray=$data['leadhourarray'];
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

// if($sel_pool=='All' && (strtotime(date("d-M-Y")) == strtotime(date("d-M-Y",strtotime($dtime))))){     
// $PENDING_UNI_USER=isset($pendData['PENDING_UNI_USER'])?$pendData['PENDING_UNI_USER']:0; 
// $PENDING_LEADS=isset($pendData['PENDING_LEADS'])?$pendData['PENDING_LEADS']:0; 
// $PENDING_UNTOUCHED=isset($pendData['PENDING_UNTOUCHED'])?$pendData['PENDING_UNTOUCHED']:0; 
// $attempt_1 = isset($pendData['ATTEMPT_1'])?$pendData['ATTEMPT_1']:0;
// $attempt_2 = isset($pendData['ATTEMPT_2'])?$pendData['ATTEMPT_2']:0;
// $attempt_3 = isset($pendData['ATTEMPT_3'])?$pendData['ATTEMPT_3']: 0;
// $Must_Call = isset($pendData['PENDING_MUST_CALL'])?$pendData['PENDING_MUST_CALL']:0;
// $DNC = isset($pendData['PENDING_DNC'])?$pendData['PENDING_DNC']:0;
// $Service = isset($pendData['PENDING_SERVICE'])?$pendData['PENDING_SERVICE']: 0;
// $Foreign = isset($pendData['PENDING_FOREIGN'])?$pendData['PENDING_FOREIGN']: 0;
// $pend_intent = isset($pendData['PENDING_INTENT'])?$pendData['PENDING_INTENT']: 0;
// echo '<br><div style="margin:0px auto;width:1100px;font-family:arial;border:2px solid #e3eff8;padding:5px 30px;margin-top:0px">
// <div style="width:1087px; float:left; padding:2px 4px; 0 4px 4px;margin:0px;font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;line-height:15px;border:1px solid #c6def1;margin-bottom:10px">Pending Details</div>
//            </div><br>
//            ';
// 
//  }
          echo '<div style="margin:0px auto;width:1100px;font-family:arial;border:2px solid #e3eff8;padding:5px 30px;margin-top:0px">
            <div style="width:1087px; float:left; padding:2px 4px; 0 4px 4px;margin:0px;font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;line-height:15px;border:1px solid #c6def1;margin-bottom:10px">Today\'s Generation (Working Hour wise)
            <div style="float:right; font-size:14px;  ">Report Generation Date: '. date('d-M-Y H:i:s').'</div></div>
            <table width="100%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr>
                <td width="65" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545"><b>Pool</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Timliness</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Display%</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Approval%</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Associates Logged</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Associates Mapped</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>PPP</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Fresh Pending</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Flagged Pending</b></td>
                <td width="35" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545"><b>Approval</b></td>
                </tr>';              
            echo '<tr><td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">'.$sel_pool.'</td>';
       
           
           if($approvalData['ENQ_CNT']!=0)
           {
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.(round(($approvalData['ENQ_APPROVED_CNT15']+$deletedData['ENQ_DELETED_CNT15'])*100/$approvalData['ENQ_CNT'],2)).'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.(round($flaggedData['ENQ_DISPLAY_CNT10']*100/$approvalData['ENQ_CNT'],2)).'</td>';
           }
           else
           {
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">0</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">0</td>';
           }
           if($approvalData['ENQ_APPROVED_CNT']!=0 or $deletedData['ENQ_DELETED_CNT']!=0)
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.(round($approvalData['ENQ_APPROVED_CNT']*100/($approvalData['ENQ_APPROVED_CNT']+$deletedData['ENQ_DELETED_CNT']),2)).'</td>';
           else
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">0</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">-</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">-</td>';
           if($approvalData['TOTAL_EMP_APP']!=0)
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.(round($approvalData['ENQ_APPROVED_CNT']/$approvalData['TOTAL_EMP_APP'],2)).'</td>';
           else
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">0</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$pendingData['PENDING_UNTOUCHED'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$pendingData['PENDING_LEADS'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$approvalData['ENQ_APPROVED_CNT'].'</td>';
           
                echo '</tr>'; 
       echo '<tr> <td colspan="14" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
      echo '</table></div> ';
       


  ?>
        </body></html>