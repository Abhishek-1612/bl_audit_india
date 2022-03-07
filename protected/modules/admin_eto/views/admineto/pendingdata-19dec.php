<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
       <title>Pending BL Approval Dashboard-3</title>
       <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
        <script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
        <script language="javascript" src="/js/calendar.js"></script>
        
<!--google analytics async code end-->	
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="S" || $(this).attr("value")=="PD"){          
           $('#td_pool').hide();
           $('#drp_pool').hide();
           $('#pr_pool').hide();
           $('#pr_checkbox').hide();
        }
        if($(this).attr("value")=="D" || $(this).attr("value")=="T"){
            $('#td_pool').show();
            $('#drp_pool').show();
            $('#pr_pool').hide();
            $('#pr_checkbox').hide();    
        }
        if($(this).attr("value")=="P"){
            $('#td_pool').hide();
            $('#drp_pool').hide();
            $('#pr_pool').show();
             $('#pr_checkbox').show();
        }
       
    });
    
    $('input[type="checkbox"]').click(function(){
    if($(this).attr("value")=="ALL"){ 
    
    $('#vendor2').attr('checked', false);
    $('#vendor3').attr('checked', false);
    $('#vendor4').attr('checked', false);
    $('#vendor5').attr('checked', false);
    $('#vendor6').attr('checked', false);
    }
    
    if($(this).attr("value")=="COGENT" || $(this).attr("value")=="COGENTINTENT" || $(this).attr("value")=="KOCHARTECH" || $(this).attr("value")=="VKALP"  || $(this).attr("value")=="RADIATE"){
    
    $('#vendor1').attr('checked', false);
    }
   });
    
});

function check()
{
var vendorVal = '';
vendorVal = $('input[name="vendor1"]:checked').map(function() {
return this.value;
}).get().join();
$("#vendorVal").val(vendorVal);
}
</script>
<style>.c {text-align:center}
.h1{background: #0195d3; color: white;font-size:13px;padding:2px 4px;font-weight: bold;}
.h2{background: #dff8ff; color: black;font-size:12px;padding:2px 4px;font-weight: bold;}
</style>
        </head>
        <body>   
<?php 
$start_date= Yii::app()->request->getParam('start_date','');

$vendorVal=isset($_REQUEST['vendorVal']) ? $_REQUEST['vendorVal'] : '';
$dataHeading = 'Inserted';
$arrvendorVal=explode(',',$vendorVal);
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));
$sel_pool= Yii::app()->request->getParam('drp_pool','All');
$prtype=isset($_REQUEST['prtype']) ? $_REQUEST['prtype'] : '';
$display_pool='style="display:none;"';
$display_pr_pool='style="display:none;"';
$display_pr_checkbox='style="display:none;"';
if($rtype == 'D'){
    $display_pool='';
}
if($rtype == 'P'){
    $display_pr_pool='';
	$display_pr_checkbox = '';
}
if($rtype == 'T'){
	$display_pool='';
	$display_pr_checkbox = '';
}
if($vendorVal == 'ALL'){
	$dataHeading = 'Generated';
}
?>
<form name="searchForm" id="searchForm" method="post" style="margin-top:0;margin-bottom:0;" onsubmit="return check();">
 <table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
 <tr>
<td align="center" bgcolor="#dff8ff" colspan="6">
<font color=" #333399">
<b>Pending BL Dashboard</b>
</font>
</td>
</tr>
     <tr><td width="4%" style="font-weight: bold">Select Date:</td><td width="6%">        
<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
         </td><td width="5%" style="font-weight: bold">Report Type:</td><td width="15%">    
<input type="radio" name="rtype" value="S" <?php echo ($rtype == 'S' || $rtype == '')?'checked':''; ?> >&nbsp;Summary&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                
<input type="radio" name="rtype" value="D" <?php echo ($rtype == 'D')?'CHECKED="CHECKED"':'' ?> >&nbsp;Detailed Report&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="rtype" value="P" <?php echo ($rtype == 'P')?'CHECKED="CHECKED"':'' ?> >&nbsp;Predictive Report&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="rtype" value="PD" <?php echo ($rtype == 'PD')?'CHECKED="CHECKED"':'' ?> >&nbsp;Pending Report&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="rtype" value="T" <?php echo ($rtype == 'T')?'CHECKED="CHECKED"':'' ?> >&nbsp;Timeliness Report
</td>
<td width="15%" style="font-weight: bold"><span id="td_pool" <?php echo $display_pool;?> >Select Pool:</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="drp_pool" name="drp_pool" width="100px" <?php echo $display_pool;?> >
 <?php 

	if($sel_pool=='All'){
		echo '<option value="All" selected>--All--</option>';
	}else{
		echo '<option value="All">--All--</option>'; 
	}
       
	if($sel_pool=='MUSTCALL'){
		echo '<option value="MUSTCALL" selected>Must Call(Ex.Service)</option>';
	}else{
		echo '<option value="MUSTCALL">Must Call(Ex. Service)</option>'; 
	}
        if($sel_pool=='SERVICE'){
		echo '<option value="SERVICE" selected>Must Call (In. Service)</option>';
	}else{
		echo '<option value="SERVICE">Must Call (In. Service)</option>'; 
	}
        if($sel_pool=='TOT_MUSTCALL'){
		echo '<option value="TOT_MUSTCALL" selected>Total Must Call</option>';
	}else{
		echo '<option value="TOT_MUSTCALL">Total Must Call</option>'; 
	}
        
	if($sel_pool=='DNC-INDIA'){
		echo '<option value="DNC-INDIA" selected>DNC India</option>';
	}else{
		echo '<option value="DNC-INDIA">DNC India</option>'; 
	}
        if($sel_pool=='DNC-FOREIGN'){
		echo '<option value="DNC-FOREIGN" selected>DNC Foreign</option>';
	}else{
		echo '<option value="DNC-FOREIGN">DNC Foreign</option>'; 
	}
        if($sel_pool=='TOT_DNC'){
		echo '<option value="TOT_DNC" selected>Total DNC</option>';
	}else{
		echo '<option value="TOT_DNC">Total DNC</option>'; 
	}
	
	if($sel_pool=='INTENT'){
		echo '<option value="INTENT" selected>Intent</option>';
	}else{
		echo '<option value="INTENT">Intent</option>'; 
	}
	if($sel_pool=='PROCMART'){
		echo '<option value="PROCMART" selected>Procmart</option>';
	}else{
		echo '<option value="PROCMART">Procmart</option>'; 
	}


 
?>
</select>
    
 <span id="pr_pool" <?php echo $display_pr_pool;?>><b>PR Type:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="ALL" <?php echo ($prtype == 'ALL' || $prtype == '')?'checked':''; ?> >&nbsp;ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                
<input type="radio" name="prtype" value="fresh" <?php echo ($prtype == 'fresh')?'CHECKED="CHECKED"':'' ?> >&nbsp;Fresh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="flag" <?php echo ($prtype == 'flag')?'CHECKED="CHECKED"':'' ?> >&nbsp;Flag
</span>   
</td>
</tr>
<tr>

<td  colspan="4">
<span id="pr_checkbox" <?php echo $display_pr_checkbox;?>>
<b>Vendor:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
if($vendorVal =='ALL' || $vendorVal =='')
{
echo '<input type="checkbox" value="ALL" checked="checked" name="vendor1" id="vendor1">ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="ALL"  name="vendor1" id="vendor1">ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('COGENT',$arrvendorVal))
{
echo '<input type="checkbox" value="COGENT" checked="checked" name="vendor1" id="vendor2">COGENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="COGENT"  name="vendor1" id="vendor2">COGENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('COGENTINTENT',$arrvendorVal))
{
 echo '<input type="checkbox" value="COGENTINTENT" checked="checked" name="vendor1" id="vendor3">COGENTINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="COGENTINTENT"  name="vendor1" id="vendor3">COGENTINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('KOCHARTECH',$arrvendorVal))
{
 echo '<input type="checkbox" value="KOCHARTECH" checked="checked" name="vendor1" id="vendor4">KOCHARTECH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="KOCHARTECH"  name="vendor1" id="vendor4">KOCHARTECH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('VKALP',$arrvendorVal))
{
 echo '<input type="checkbox" value="VKALP" checked="checked" name="vendor1" id="vendor5">VKALP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="VKALP"  name="vendor1" id="vendor5">VKALP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('RADIATE',$arrvendorVal))
{
 echo '<input type="checkbox" value="RADIATE" checked="checked" name="vendor1" id="vendor6">RADIATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="RADIATE"  name="vendor1" id="vendor5">RADIATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
echo '<input type="hidden" name="vendorVal" id="vendorVal" value="">
</span>
</td>';
?>
<td colspan="2"> <input type="submit" name="btnsubmit" id="btnsubmit" value="Generate">
</td></tr></table>   
</form><br>

<?php
$dtime= Yii::app()->request->getParam('start_date',strtoupper(date("d-M-Y"))); 
$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
$pendData_bl=isset($data['pendData_bl']) ? $data['pendData_bl'] : '';
$pendData_user=isset($data['pendData_user']) ? $data['pendData_user'] : '';
$redis_data=isset($data['redis_data']) ? $data['redis_data'] :'';

$genDataSth=isset($data['genData']) ? $data['genData'] : '';
$deletedEnquiry=isset($data['deletedEnquiry']) ? $data['deletedEnquiry'] : '';
$flagged=isset($data['flagged']) ? $data['flagged'] : '';
$appData_bl=isset($data['appData_bl']) ? $data['appData_bl'] : '';
$appData_user=isset($data['appData_user']) ? $data['appData_user'] : '';
$genData_bl=isset($data['genData_bl']) ? $data['genData_bl'] : '';
$genData_user=isset($data['genData_user']) ? $data['genData_user'] : '';
$flagged_bl=isset($data['flagged_bl']) ? $data['flagged_bl'] : '';
$fresh_bl=isset($data['fresh_bl']) ? $data['fresh_bl'] : '';

if(isset($_REQUEST['btnsubmit']))
{ 
if($rtype == 'T')
{
	$totalGen = $totalApp = $gen9_to_9 = $app9_to_9 = $totalApp15Min = $totalDel15Min = $del15Min_9_to_9 = $app15Min_9_to_9 =0;
	
	echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
			<tr>
				<td colspan="27" align="center" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Timeliness Report </td>
			</tr>	
			<tr>
				<td colspan="27" align="center" style="font-size:15px;font-weight:bold;color:#000099;background:#e3eff8;">Pool :- '.$sel_pool.'&nbsp;&nbsp; Vendor :- '.$vendorVal.'</td>
			</tr>
			<tr>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">0-1</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">1-2</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">2-3</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">3-4</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">4-5</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">5-6</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">6-7</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">7-8</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">8-9</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">9-10</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">10-11</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">11-12</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">12-13</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">13-14</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">14-15</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">15-16</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">16-17</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">17-18</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">18-19</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">19-20</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">20-21</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">21-22</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">22-23</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">23-24</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Overall Timeliness</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Overall Timeliness (9AM to 9 PM)</td>
			<tr>';
			
	$genHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Data '.$dataHeading.'</td>';
	$appHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Approved & Deleted(Within 15 Minutes)</td>';
	$app15MinHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Approved (Within 15 Minutes)</td>';
	$del15MinHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Deleted (Within 15 Minutes)</td>';
	$timelinessHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Timeliness (Within 15 Minutes)</td>';
	
	for($i=0;$i<24;$i++)
	{		
		$data1 = $data[$i];
				
		$gen = isset($data1['GEN']) ? $data1['GEN'] : 0; 
		$genHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$gen.'</td>';
		
		$app = isset($data1['TOTAL_APPROVED']) ? $data1['TOTAL_APPROVED'] : 0; 
		$appHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$app.'</td>';
		
		$app15Min = isset($data1['APP_WITH_IN_15MIN']) ? $data1['APP_WITH_IN_15MIN'] : 0; 
		$app15MinHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$app15Min.'</td>';
		
		$del15Min = isset($data1['DEL_WITH_IN_15MIN']) ? $data1['DEL_WITH_IN_15MIN'] : 0; 
		$del15MinHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$del15Min.'</td>';
		
		$timeliness = ($gen != 0) ? round($app*100/$gen,2) : 0;
		$timelinessHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$timeliness.'%</td>';

		$totalGen += $gen;		
		$totalApp += $app;	
		$totalApp15Min += $app15Min;	
		$totalDel15Min += $del15Min;	
		
		$timeRange = range(9,20,1);
		
		if(in_array($i,$timeRange)){
			$gen9_to_9 += $gen;
			$app9_to_9 += $app;
			$app15Min_9_to_9 += $app15Min;
			$del15Min_9_to_9 += $del15Min;
		} 	
	}
	$totalTimeliness  		= ($totalGen != 0) ? round($totalApp*100/$totalGen,2) : 0;
	$totalTimeliness9_to_9 	= ($gen9_to_9 != 0) ? round($app9_to_9*100/$gen9_to_9,2) : 0;

	$genHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalGen.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$gen9_to_9.'</td></tr>';
	
	$appHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalApp.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$app9_to_9.'</td></tr>';
	
	$app15MinHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalApp15Min.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$app15Min_9_to_9.'</td></tr>';
	
	$del15MinHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalDel15Min.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$del15Min_9_to_9.'</td></tr>';
	
	$timelinessHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness.'%</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness9_to_9.'%</td></tr></table>';
	
	echo $genHtml;
	echo $appHtml;	
	echo $app15MinHtml;	
	echo $del15MinHtml;
	echo $timelinessHtml;
}
elseif($rtype == 'P'){
 
    $pend=$data['pend'];//echo '<pre>';print_r($pend);echo '</pre>';//die;
    $total_pend_record=$data['total_pend'];
    echo '<table width="60%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr><td colspan="2" class="h1 c">Pending Till Date
            </td></tr>';
        foreach($total_pend_record as $row){
                echo '<tr><td class="h2 c">'.$row['LEAP_VENDOR_NAME'].'</td><td class="h2 c">'.$row['PENDING_CNT'].'</td></tr>';
        }
       echo '</table><br/>';
    
    $vendor_name='';
    echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr><td colspan="27" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Predictive dialing Hourly Report 
            </td></tr>';
            $vendor_name='';$total_sent=0;$total_pend=0;$total_tim=0;$cnt=0;
           foreach($pend as $row){
               if($vendor_name != $row['LEAP_VENDOR_NAME']){//echo '<pre>';echo 'hh'.$i.'=='.$vendor_name;echo '</pre>';
                    $k=0;   $cnt++;                 
                    $d1[$cnt]['LEAP_VENDOR_NAME']=$row['LEAP_VENDOR_NAME'];                    
                    for($hour=0;$hour<24;$hour++){        
                            $d1[$cnt]['SENT_'.$hour]=$d1[$cnt]['REC_'.$hour]=$d1[$cnt]['PEND_'.$hour]=$d1[$cnt]['TIM_'.$hour]=0;  
                            $d1[$cnt]['ATTEMP_'.$hour]=$d1[$cnt]['PEND_TEN_'.$hour]=$d1[$cnt]['ATTEMP_1_'.$hour]=0; 
                            $d1[$cnt]['ATTEMP_2_'.$hour]=$d1[$cnt]['ATTEMP_5_'.$hour]=$d1[$cnt]['ATTEMP_TEN_'.$hour]=0; 
                    } 
                    
               }                
                if($row['HR'] == '00'){     
                    $d1[$cnt]['SENT_0']=$row['TOTAL_SENT'];$d1[$cnt]['REC_0']=$row['REC_CNT'];$d1[$cnt]['PEND_0']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_0']=$row['ATTEMPT_CNT'];
                    $d1[$cnt]['PEND_TEN_0']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_0']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_0']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_0']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_0']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_0']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_0']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '01'){
                     $d1[$cnt]['SENT_1']=$row['TOTAL_SENT'];$d1[$cnt]['REC_1']=$row['REC_CNT'];$d1[$cnt]['PEND_1']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_1']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_1']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_1']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_1']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_1']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_1']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_1']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['ATTEMP_TEN_1']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_1']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                 }elseif($row['HR'] == '02'){
                    $d1[$cnt]['SENT_2']=$row['TOTAL_SENT'];$d1[$cnt]['REC_2']=$row['REC_CNT'];$d1[$cnt]['PEND_2']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_2']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_2']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_2']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_2']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_2']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_2']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                 }elseif($row['HR'] == '03'){
                   $d1[$cnt]['SENT_3']=$row['TOTAL_SENT'];$d1[$cnt]['REC_3']=$row['REC_CNT'];$d1[$cnt]['PEND_3']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_3']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_3']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_3']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_3']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_3']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_3']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_3']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_3']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_3']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                 }elseif($row['HR'] == '04'){
                     $d1[$cnt]['SENT_4']=$row['TOTAL_SENT'];$d1[$cnt]['REC_4']=$row['REC_CNT'];$d1[$cnt]['PEND_4']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_4']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_4']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_4']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_4']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_4']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_4']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_4']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_4']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_4']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                 }elseif($row['HR'] == '05'){
                    $d1[$cnt]['SENT_5']=$row['TOTAL_SENT'];$d1[$cnt]['REC_5']=$row['REC_CNT'];$d1[$cnt]['PEND_5']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_5']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_5']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_5']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_5']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_5']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_5']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                 }elseif($row['HR'] == '06'){
                    $d1[$cnt]['SENT_6']=$row['TOTAL_SENT'];$d1[$cnt]['REC_6']=$row['REC_CNT'];$d1[$cnt]['PEND_6']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_6']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_6']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_6']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_6']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_6']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_6']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                }elseif($row['HR'] == '07'){
                     $d1[$cnt]['SENT_7']=$row['TOTAL_SENT'];$d1[$cnt]['REC_7']=$row['REC_CNT'];$d1[$cnt]['PEND_7']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_7']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_7']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_7']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_7']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_7']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_7']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                }elseif($row['HR'] == '08'){
                    $d1[$cnt]['SENT_8']=$row['TOTAL_SENT'];$d1[$cnt]['REC_8']=$row['REC_CNT'];$d1[$cnt]['PEND_8']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_8']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_8']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_8']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_8']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_8']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_8']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_8']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_8']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_8']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                }elseif($row['HR'] == '09'){
                     $d1[$cnt]['SENT_9_9_9']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_9']=$row['TOTAL_SENT'];$d1[$cnt]['REC_9']=$row['REC_CNT'];$d1[$cnt]['PEND_9']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_9']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_9']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_9']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_9']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_9']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_9']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_9']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_9']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['ATTEMP_1_9']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_9']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_9']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_9']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                }elseif($row['HR'] == '10'){
                     $d1[$cnt]['SENT_9_9_10']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_10']=$row['TOTAL_SENT'];$d1[$cnt]['REC_10']=$row['REC_CNT'];$d1[$cnt]['PEND_10']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_10']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_10']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_10']=$row['PENDING_TIMLINESS_CNT'];
                     $d1[$cnt]['ATTEMP_TEN_10']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_10']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_10']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_10']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['ATTEMP_1_10']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_10']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_10']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_10']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_10']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '11'){                     
                    $d1[$cnt]['SENT_9_9_11']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_11']=$row['TOTAL_SENT'];$d1[$cnt]['REC_11']=$row['REC_CNT'];$d1[$cnt]['PEND_11']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_11']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_11']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_11']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_11']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_11']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_11']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_11']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_11']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_11']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '12'){         
                    $d1[$cnt]['SENT_9_9_12']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_12']=$row['TOTAL_SENT'];$d1[$cnt]['REC_12']=$row['REC_CNT'];$d1[$cnt]['PEND_12']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_12']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_12']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_12']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_12']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_12']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_12']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_12']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_12']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_12']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '13'){         
                   $d1[$cnt]['SENT_9_9_13']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_13']=$row['TOTAL_SENT'];$d1[$cnt]['REC_13']=$row['REC_CNT'];$d1[$cnt]['PEND_13']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_13']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_13']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_13']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_13']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_13']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_13']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_13']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_13']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_13']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '14'){         
                   $d1[$cnt]['SENT_9_9_14']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_14']=$row['TOTAL_SENT'];$d1[$cnt]['REC_14']=$row['REC_CNT'];$d1[$cnt]['PEND_14']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_14']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_14']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_14']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_14']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_14']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_14']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_14']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_14']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_14']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '15'){         
                    $d1[$cnt]['SENT_9_9_15']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_9_9_7']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_15']=$row['TOTAL_SENT'];$d1[$cnt]['REC_15']=$row['REC_CNT'];$d1[$cnt]['PEND_15']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_15']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_15']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_15']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_15']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_15']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_15']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_15']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_15']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_TIM_15']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '16'){         
                    $d1[$cnt]['SENT_9_9_16']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_9_9_7']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_16']=$row['TOTAL_SENT'];$d1[$cnt]['REC_16']=$row['REC_CNT'];$d1[$cnt]['PEND_16']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_16']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_16']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_16']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_16']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_16']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_16']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_16']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_16']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_TIM_16']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '17'){         
                    $d1[$cnt]['SENT_9_9_17']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_17']=$row['TOTAL_SENT'];$d1[$cnt]['REC_17']=$row['REC_CNT'];$d1[$cnt]['PEND_17']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_17']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_17']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_17']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_17']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_17']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_17']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_17']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_17']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_17']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '18'){         
                    $d1[$cnt]['SENT_9_9_18']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_18']=$row['TOTAL_SENT'];$d1[$cnt]['REC_18']=$row['REC_CNT'];$d1[$cnt]['PEND_18']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_18']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_18']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_18']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_18']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_18']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_18']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_18']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_18']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_18']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '19'){         
                    $d1[$cnt]['SENT_9_9_19']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_19']=$row['TOTAL_SENT'];$d1[$cnt]['REC_19']=$row['REC_CNT'];$d1[$cnt]['PEND_19']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_19']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_19']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_19']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_19']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_19']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_19']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_19']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_19']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_19']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '20'){         
                    $d1[$cnt]['SENT_9_9_20']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_20']=$row['TOTAL_SENT'];$d1[$cnt]['REC_20']=$row['REC_CNT'];$d1[$cnt]['PEND_20']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_20']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_20']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_20']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_20']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_20']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_20']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_20']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_20']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_20']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '21'){         
                    $d1[$cnt]['SENT_21']=$row['TOTAL_SENT'];$d1[$cnt]['REC_21']=$row['REC_CNT'];$d1[$cnt]['PEND_21']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_21']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_21']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_21']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_21']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_21']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_21']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_21']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_21']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_21']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '22'){         
                    $d1[$cnt]['SENT_22']=$row['TOTAL_SENT'];$d1[$cnt]['REC_22']=$row['REC_CNT'];$d1[$cnt]['PEND_22']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_22']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_22']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_22']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_22']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_22']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_22']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_22']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_22']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_22']=$row['NOT_TIMLINESS_CNT'];
                }elseif($row['HR'] == '23'){         
                    $d1[$cnt]['SENT_23']=$row['TOTAL_SENT'];$d1[$cnt]['REC_23']=$row['REC_CNT'];$d1[$cnt]['PEND_23']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_23']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_23']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_23']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_23']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_23']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_23']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_23']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_23']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_23']=$row['NOT_TIMLINESS_CNT'];
                } 
                $vendor_name=$row['LEAP_VENDOR_NAME'];   
            }
           // echo '<pre>';print_r($d1);echo '</pre>';
            for($i=1;$i<=count($d1);$i++){ //echo '<pre>';print_r($d1[$i]);echo '</pre>';               
                 echo '<tr><td colspan="27" class="h1 c">'.$d1[$i]['LEAP_VENDOR_NAME'].'</td></tr>';                 
                 echo '<tr><td width="65" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545"></td>';
                 $total_sent_9_9=$total_rec_9_9=$total_pend_9_9=$total_tim_9_9=$total_attemp_9_9=$total_attemp_1_9_9=$total_attemp_2_9_9=$total_attemp_5_9_9=$total_attemp_ten_9_9=$total_pend_ten_9_9=$total_attemp_not_ten_9_9=$total_rec_not_ten_9_9=0;
                 $total_sent=0;$total_rec=0;$total_pend=0;$total_tim=0;$total_attemp=0;$total_attemp_1=$total_attemp_2=$total_attemp_5=$total_attemp_ten=0;$total_pend_ten=0;$total_attemp_not_ten=0;$total_rec_not_ten=0;
                for($counter=0;$counter<24;$counter++){
                    $total_sent=$total_sent+$d1[$i]['SENT_'.$counter];
                    $total_rec=$total_rec+$d1[$i]['REC_'.$counter];
                    $total_pend=$total_pend+$d1[$i]['PEND_'.$counter];
                    $total_tim=$total_tim+$d1[$i]['TIM_'.$counter];
                    $total_attemp=$total_attemp+$d1[$i]['ATTEMP_'.$counter];
                    $total_attemp_ten=$total_attemp_ten+$d1[$i]['ATTEMP_TEN_'.$counter];
                    $total_attemp_1=$total_attemp_1+$d1[$i]['ATTEMP_1_'.$counter];
                    $total_attemp_2=$total_attemp_2+$d1[$i]['ATTEMP_2_'.$counter];
                    $total_attemp_5=$total_attemp_5+$d1[$i]['ATTEMP_5_'.$counter];
                    $total_not_attemp_ten=$total_attemp_not_ten+$d1[$i]['NOT_ATTEMP_TEN_'.$counter];
                    $total_pend_ten=$total_pend_ten+$d1[$i]['PEND_TEN_'.$counter];
                    $total_pend_1=$total_pend_ten+$d1[$i]['PEND_1_'.$counter];
                    $total_pend_2=$total_pend_ten+$d1[$i]['PEND_2_'.$counter];
                    $total_pend_5=$total_pend_ten+$d1[$i]['PEND_5_'.$counter];
                    $total_rec_not_ten=$total_rec_not_ten+$d1[$i]['NOT_TIM_'.$counter];
                    if($counter>8 && $counter<21){
                        $total_sent_9_9=$total_sent_9_9+$d1[$i]['SENT_9_9_'.$counter];                    
                        $total_rec_9_9=$total_rec_9_9+$d1[$i]['REC_'.$counter];
                        $total_pend_9_9=$total_pend_9_9+$d1[$i]['PEND_'.$counter];
                        $total_tim_9_9=$total_tim_9_9+$d1[$i]['TIM_'.$counter];
                        $total_attemp_9_9=$total_attemp_9_9+$d1[$i]['ATTEMP_'.$counter];
                        $total_attemp_ten_9_9=$total_attemp_ten_9_9+$d1[$i]['ATTEMP_TEN_'.$counter];
                        $total_attemp_1_9_9=$total_attemp_1_9_9+$d1[$i]['ATTEMP_1_'.$counter];
                        $total_attemp_2_9_9=$total_attemp_2_9_9+$d1[$i]['ATTEMP_2_'.$counter];
                        $total_attemp_5_9_9=$total_attemp_5_9_9+$d1[$i]['ATTEMP_5_'.$counter];
                        $total_not_attemp_ten_9_9=$total_attemp_not_ten_9_9+$d1[$i]['NOT_ATTEMP_TEN_'.$counter];
                        $total_pend_ten_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_TEN_'.$counter];
                        $total_pend_1_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_1_'.$counter];
                        $total_pend_2_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_2_'.$counter];
                        $total_pend_5_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_5_'.$counter];
                        $total_rec_not_ten_9_9=$total_rec_not_ten_9_9+$d1[$i]['NOT_TIM_'.$counter];
                    }
                    echo '<td width="35" class="h2 c">'.$counter.'-'.($counter+1).'</td>'; 
                }
                echo '<td width="35" class="h2 c">Total <br>(24 Hours)</td><td width="35" class="h2 c">Total <br>(9 TO 9)</td></tr>';   
               
                echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;" width="155px">Data Inserted</td>';                      
                    for($counter=0;$counter<24;$counter++){
                        $col='SENT_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=".$counter."&subtype=SENT"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    }     
                       
                     if($total_sent ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=SENT"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_sent.'</a></td>';
                     }
                    if($total_sent_9_9 ==0)
                     {
                       echo '<td class="c">0</td><td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT_9&subtype=SENT"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_sent_9_9.'</a></td>';
                     }
                    echo '</tr>';
                    
                    // 1 min
                    echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted In 0-1 Min</td>';                    
                   for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_1_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=ATTEMP_1"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    }     
                     
                     if($total_attemp_1 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=ATTEMP_1"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_1.'</a></td>';
                     }
                     if($total_attemp_1_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=ATTEMP_1"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_1_9_9.'</a></td>';
                     }
                      echo '<tr bgcolor="#c0fcfe"><td align="left" style="font-size:12px;padding:2px 4px;"><font >Attempted % In 1 Min</font></td>';
                       for($counter=0;$counter<24;$counter++){
                        $col1='ATTEMP_1_'.$counter;
                        $col2='SENT_'.$counter;
                        if($d1[$i][$col1] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><font>'.number_format($d1[$i][$col1]/$d1[$i][$col2] * 100, 2 ).'</font></td>';
                        }
                    }
                    echo '<td class="c"><font >'.number_format($total_attemp_1/$total_sent * 100, 2 ).'</font></td><td class="c"><font >'.number_format($total_attemp_1_9_9/$total_sent_9_9 * 100, 2 ).'</font></td></tr>';     
                   
                    // end 1 min
                     // 2 min
                    echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted In 0-2 Min</td>';
                    for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_2_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=ATTEMP_2"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    }                    
                     if($total_attemp_2 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=ATTEMP_2"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_2.'</a></td>';
                     }
                     if($total_attemp_2_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT_9_9&subtype=ATTEMP_2"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_2_9_9.'</a></td>';
                     }
                      echo '</tr><tr bgcolor="#c0fcfe"><td align="left" style="font-size:12px;padding:2px 4px;"><font >Attempted % In 2 Min</font></td>';
                       for($counter=0;$counter<24;$counter++){
                        $col1='ATTEMP_2_'.$counter;
                        $col2='SENT_'.$counter;
                        if($d1[$i][$col1] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><font>'.number_format($d1[$i][$col1]/$d1[$i][$col2] * 100, 2 ).'</font></td>';
                        }
                    }
                     echo '<td class="c"><font >'.number_format($total_attemp_2/$total_sent * 100, 2 ).'</font></td><td class="c"><font >'.number_format($total_attemp_2_9_9/$total_sent_9_9 * 100, 2 ).'</font></td></tr>'; 
                    // end 2 min
                     // 5 min
                    echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted In 0-5 Min</td>';
                    
                    for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_5_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     if($total_attemp_5 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_5.'</a></td>';
                     }
                     if($total_attemp_5_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_5_9_9.'</a></td>';
                     }
                      echo '<tr bgcolor="#c0fcfe"><td align="left" style="font-size:12px;padding:2px 4px;"><font >Attempted % In 5 Min</font></td>';
                       for($counter=0;$counter<24;$counter++){
                        $col1='ATTEMP_5_'.$counter;
                        $col2='SENT_'.$counter;
                        if($d1[$i][$col1] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><font>'.number_format($d1[$i][$col1]/$d1[$i][$col2] * 100, 2 ).'</font></td>';
                        }
                    }
                     echo '<td class="c"><font >'.number_format($total_attemp_5/$total_sent * 100, 2 ).'</font></td><td class="c"><font >'.number_format($total_attemp_5_9_9/$total_sent_9_9 * 100, 2 ).'</font></td></tr>'; 
                    // end 5 min 
                       echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted In 10 Min</td>';
                    for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_TEN_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     if($total_attemp_ten ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_ten.'</a></td>';
                     }
                     if($total_attemp_ten_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT_9_9&subtype=ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_ten_9_9.'</a></td>';
                     }
                    echo '</tr>';  
                    echo '<tr bgcolor="#c0fcfe"><td align="left" style="font-size:12px;padding:2px 4px;"><font >Attempted % In 10 Min</font></td>';
                    for($counter=0;$counter<24;$counter++){
                        $col1='ATTEMP_TEN_'.$counter;
                        $col2='SENT_'.$counter;
                        if($d1[$i][$col1] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><font>'.number_format($d1[$i][$col1]/$d1[$i][$col2] * 100, 2 ).'</font></td>';
                        }
                    }
                    echo '<td class="c"><font>'.number_format($total_attemp_ten/$total_sent * 100, 2 ).'</font></td><td class="c"><font>'.number_format($total_attemp_ten_9_9/$total_sent_9_9 * 100, 2 ).'</font></td></tr>';
                     echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Not Attempted In 10 Min</td>';
                   for($counter=0;$counter<24;$counter++){
                        $col='NOT_ATTEMP_TEN_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=NOT_ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     
                      if($total_attemp_not_ten ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=NOT_ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_ten.'</a></td>';
                     }
                     if($total_attemp_not_ten_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT_9_9&subtype=NOT_ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_ten_9_9.'</a></td>';
                     }
                    echo '</tr>';  
                     echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted Till Now</td>';
                    
                    for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=ATTEMP"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     
                     if($total_attemp ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=ATTEMP"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp.'</a></td>';
                     }
                    if($total_attemp_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT_9_9&subtype=ATTEMP"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_9_9.'</a></td>';
                     }
                    echo '</tr>';  
                    echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted % Till Now</td>';
                    for($counter=0;$counter<24;$counter++){
                        $col1='ATTEMP_'.$counter;
                        $col2='SENT_'.$counter;
                        if($d1[$i][$col1] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><font>'.number_format($d1[$i][$col1]/$d1[$i][$col2] * 100, 2 ).'</font></td>';
                        }
                    }
                    echo '<td class="c">'.number_format($total_attemp/$total_sent * 100, 2 ) . '</td><td class="c">'.number_format($total_attemp_9_9/$total_sent_9_9 * 100, 2 ) . '</td></tr>';
                    
                    echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Pending Till Now</td>';
                    
                   for($counter=0;$counter<24;$counter++){
                        $col='PEND_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=PEND"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                    
                     if($total_pend ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=PEND"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_pend.'</a></td>';
                     }   
                     if($total_pend_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT_9_9&subtype=PEND"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_pend_9_9.'</a></td>';
                     }   
                     echo '<tr bgcolor="#c0fcfe"><td align="left" style="font-size:12px;padding:2px 4px;"><font >Pending % Till Now</font></td>'; 
                    for($counter=0;$counter<24;$counter++){
                        $col1='PEND_'.$counter;
                        $col2='SENT_'.$counter;
                        if($d1[$i][$col1] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><font>'.number_format($d1[$i][$col1]/$d1[$i][$col2] * 100, 2 ).'</font></td>';
                        }
                    }
                    echo '<td class="c"><font >'.number_format($total_pend/$total_sent * 100, 2 ) . '</font></td><td class="c"><font >'.number_format($total_pend_9_9/$total_sent_9_9 * 100, 2 ) . '</font></td></tr>';
                     echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Response Received In 10 Min</td>';
                     
                     
                   for($counter=0;$counter<24;$counter++){
                        $col='TIM_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     
                    if($total_tim ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_tim.'</a></td>';
                     } 
                     if($total_tim_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_tim.'</a></td>';
                     }
                    
                    
                     echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Response Received % In 10 Min</td>';
                     for($counter=0;$counter<24;$counter++){
                        $col1='TIM_'.$counter;
                        $col2='ATTEMP_'.$counter;
                        if($d1[$i][$col1] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><font>'.number_format($d1[$i][$col1]/$d1[$i][$col2] * 100, 2 ).'</font></td>';
                        }
                    }
                    echo '<td class="c">'.number_format($total_tim/$total_attemp * 100, 2 ).'</td><td class="c">'.number_format($total_tim_9_9/$total_attemp_9_9 * 100, 2 ).'</td></tr>';
                    
                      echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Response Not Received In 10 Min</td>';
                      
                    for($counter=0;$counter<24;$counter++){
                        $col='NOT_TIM_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=$counter&subtype=NOT_REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                      
                     if($total_rec_not_ten ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=NOT_REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_rec_not_ten.'</a></td>';
                     } 
                     if($total_rec_not_ten_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&HR=TOT&subtype=NOT_REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_rec_not_ten_9_9.'</a></td>';
                     } 
               echo '</tr><tr><td colspan="27" bgcolor="#FFFFFF"></td></tr>';  
            }
            echo '</table>';
}elseif($rtype == 'S')
    {   

$bl_gen_must_call=isset($genData_bl['GEN_MUST_CALL_COUNT'])?$genData_bl['GEN_MUST_CALL_COUNT']:0;
$bl_gen_must_call_service=isset($genData_bl['GEN_SERVICE_COUNT'])?$genData_bl['GEN_SERVICE_COUNT']:0;
$bl_gen_dnc_in=isset($genData_bl['GEN_DNC_COUNT'])?$genData_bl['GEN_DNC_COUNT']:0;
$bl_gen_dnc_fr=isset($genData_bl['GEN_FOREIGN_COUNT'])?$genData_bl['GEN_FOREIGN_COUNT']:0;
$bl_gen_intent=isset($genData_bl['GEN_INTENT_COUNT'])?$genData_bl['GEN_INTENT_COUNT']:0;
$bl_gen_proc=isset($genData_bl['GEN_PROCMAT_COUNT'])?$genData_bl['GEN_PROCMAT_COUNT']:0;
$bl_gen=$bl_gen_must_call+$bl_gen_must_call_service+$bl_gen_dnc_in+$bl_gen_dnc_fr+$bl_gen_intent+$bl_gen_proc;
        
        
        
        
$user_gen_must_call=isset($genData_user['GEN_MUST_CALL_COUNT'])?$genData_user['GEN_MUST_CALL_COUNT']:0;
$user_gen_must_call_service=isset($genData_user['GEN_SERVICE_COUNT'])?$genData_user['GEN_SERVICE_COUNT']:0;
$user_gen_dnc_in=isset($genData_user['GEN_DNC_COUNT'])?$genData_user['GEN_DNC_COUNT']:0;
$user_gen_dnc_fr=isset($genData_user['GEN_FOREIGN_COUNT'])?$genData_user['GEN_FOREIGN_COUNT']:0;
$user_gen_intent=isset($genData_user['GEN_INTENT_COUNT'])?$genData_user['GEN_INTENT_COUNT']:0;
$user_gen_proc=isset($genData_user['GEN_PROCMAT_COUNT'])?$genData_user['GEN_PROCMAT_COUNT']:0;
$user_gen=$user_gen_must_call+$user_gen_must_call_service+$user_gen_dnc_in+$user_gen_dnc_fr+$user_gen_intent+$user_gen_proc;

$bl_app_must_call=isset($appData_bl['APP_MUST_CALL_COUNT'])?$appData_bl['APP_MUST_CALL_COUNT']:0;
$bl_app_must_call_service=isset($appData_bl['APP_SERVICE_COUNT'])?$appData_bl['APP_SERVICE_COUNT']:0;
$bl_app_dnc_in=isset($appData_bl['APP_DNC_COUNT'])?$appData_bl['APP_DNC_COUNT']:0;
$bl_app_dnc_fr=isset($appData_bl['APP_FOREIGN_COUNT'])?$appData_bl['APP_FOREIGN_COUNT']:0;
$bl_app_intent=isset($appData_bl['APP_INTENT_COUNT'])?$appData_bl['APP_INTENT_COUNT']:0;
$bl_app_proc=isset($appData_bl['APP_PROCMAT_COUNT'])?$appData_bl['APP_PROCMAT_COUNT']:0;
$bl_app=$bl_app_must_call+$bl_app_must_call_service+$bl_app_dnc_in+$bl_app_dnc_fr+$bl_app_intent+$bl_app_proc;

$user_app_must_call=isset($appData_user['APP_MUST_CALL_COUNT'])?$appData_user['APP_MUST_CALL_COUNT']:0;
$user_app_must_call_service=isset($appData_user['APP_SERVICE_COUNT'])?$appData_user['APP_SERVICE_COUNT']:0;
$user_app_dnc_in=isset($appData_user['APP_DNC_COUNT'])?$appData_user['APP_DNC_COUNT']:0;
$user_app_dnc_fr=isset($appData_user['APP_FOREIGN_COUNT'])?$appData_user['APP_FOREIGN_COUNT']:0;
$user_app_intent=isset($appData_user['APP_INTENT_COUNT'])?$appData_user['APP_INTENT_COUNT']:0;
$user_app_proc=isset($appData_user['APP_PROCMAT_COUNT'])?$appData_user['APP_PROCMAT_COUNT']:0;
$user_app=$user_app_must_call+$user_app_must_call_service+$user_app_dnc_in+$user_app_dnc_fr+$user_app_intent+$user_app_proc;
       

$red_gen_must_call='';
$red_gen_must_call_service='';
$red_gen_dnc_in='';
$red_gen_dnc_fr='';
$red_gen_intent='';
$red_gen_proc='';

$red_app_must_call='';
$red_app_must_call_service='';
$red_app_dnc_in='';
$red_app_dnc_fr='';
$red_app_intent='';
$red_app_proc='';


$fresh_gen_must_call='';
$fresh_gen_must_call_service='';
$fresh_gen_dnc_in='';
$fresh_gen_dnc_fr='';
$fresh_gen_intent='';
$fresh_gen_proc='';
    

$fresh_app_must_call='';
$fresh_app_must_call_service='';
$fresh_app_dnc_in='';
$fresh_app_dnc_fr='';
$fresh_app_intent='';
$fresh_app_proc='';

$flagged_gen_must_call='';
$flagged_gen_must_call_service='';
$flagged_gen_dnc_in='';
$flagged_gen_dnc_fr='';
$flagged_gen_intent='';
$flagged_gen_proc='';
    

$flagged_app_must_call='';
$flagged_app_must_call_service='';
$flagged_app_dnc_in='';
$flagged_app_dnc_fr='';
$flagged_app_intent='';
$flagged_app_proc='';
    

/*$flagged_pen_must_call=isset($flagged_bl['PENDING_MUST_CALL_USER'])?$flagged_bl['PENDING_MUST_CALL_USER']: 0;
$flagged_pen_must_call_service=isset($flagged_bl['PENDING_SERVICE_USER'])?$flagged_bl['PENDING_SERVICE_USER']: 0;
$flagged_pen_dnc_in=isset($flagged_bl['PENDING_DNC_USER'])?$flagged_bl['PENDING_DNC_USER']: 0;
$flagged_pen_dnc_fr=isset($flagged_bl['PENDING_FOREIGN_USER'])?$flagged_bl['PENDING_FOREIGN_USER']: 0;
$flagged_pen_intent=isset($flagged_bl['PENDING_INTENT_USER'])?$flagged_bl['PENDING_INTENT_USER']: 0;
$flagged_pen_proc=isset($flagged_bl['PENDING_PROCMART_USER'])?$flagged_bl['PENDING_PROCMART_USER']: 0;

$flagged_cnt=$flagged_pen_must_call+$flagged_pen_must_call_service+$flagged_pen_dnc_in+$flagged_pen_dnc_fr+$flagged_pen_intent+$flagged_pen_proc;
 * 
 */

     
        
echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
<td colspan="7" align="center" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Generation</td>
<td colspan="7" align="center" bgcolor="#d6cff4" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Approval</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td> 
<td colspan="2" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Must Call</td>
<td colspan="2" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">DNC</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">INTENT</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Procmart</td>

<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td> 
<td colspan="2" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Must Call</td>
<td colspan="2" align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">DNC</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">INTENT</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Procmart</td>
</tr>


<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Total</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Service</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">India</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Foriegn</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>

<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Total</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Service</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">India</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Foriegn</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
</tr>




<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">Buy Leads</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen.'</td>

<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_proc.'</td>
    
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_proc.'</td>
    
</tr>

<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">Unique Users</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_proc.'</td>
    
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_proc.'</td>
    
</tr>


<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">Redis Queue</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_gen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_gen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_gen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_gen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_gen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_gen_proc.'</td>
    

<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_app_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_app_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_app_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_app_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_app_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$red_app_proc.'</td>
    

</tr>


<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">Fresh</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_gen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_gen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_gen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_gen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_gen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_gen_proc.'</td>
    
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_app_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_app_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_app_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_app_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_app_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$fresh_app_proc.'</td>
    
</tr>


<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">Flagged</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_gen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_gen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_gen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_gen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_gen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_gen_proc.'</td>
    
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_app_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_app_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_app_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_app_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_app_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$flagged_app_proc.'</td>
    
</tr>
</table>  
  </br></br>

           ';
                

 }
elseif($rtype == 'D') {
          echo '
            <table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr><td colspan="10" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Today\'s Generation (Working Hour wise)
            </td><td colspan="4"  style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Report Generation Date: '. date('d-M-Y H:i:s').'</td></tr>
            
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
       
       // Total Procmart count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Procmart</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT20'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT21'].'</td>'; 
            $total_procmart=$genDataSth['PROCMART_CALL_CNT10'] + $genDataSth['PROCMART_CALL_CNT11'] + $genDataSth['PROCMART_CALL_CNT12'] + $genDataSth['PROCMART_CALL_CNT13'] + $genDataSth['PROCMART_CALL_CNT14'] +  $genDataSth['PROCMART_CALL_CNT15'] + $genDataSth['PROCMART_CALL_CNT16'] + $genDataSth['PROCMART_CALL_CNT17'] + $genDataSth['PROCMART_CALL_CNT18'] + $genDataSth['PROCMART_CALL_CNT19'] + $genDataSth['PROCMART_CALL_CNT20'] + $genDataSth['PROCMART_CALL_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_procmart.'</td>'; 
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
         
         $total_timleness=($flagged['ENQ_DISPLAY_CNT10']) +($flagged['ENQ_DISPLAY_CNT11'])+ ($flagged['ENQ_DISPLAY_CNT12'])+  ($flagged['ENQ_DISPLAY_CNT13'])+      ($flagged['ENQ_DISPLAY_CNT14'])+           ($flagged['ENQ_DISPLAY_CNT15'])+           ($flagged['ENQ_DISPLAY_CNT16'])+           ($flagged['ENQ_DISPLAY_CNT17'])+           ($flagged['ENQ_DISPLAY_CNT18'])+           ($flagged['ENQ_DISPLAY_CNT19'])+           ($flagged['ENQ_DISPLAY_CNT20'])+           ($flagged['ENQ_DISPLAY_CNT21']);
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
      echo '</table>';
      
   echo '<br/>
            <table width="90%" border="1" bordercolor="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Adherence
            </td></tr>
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
               </tr></tbody></table>';   
// Non Hourly
      
echo '<br><table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
             <tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Today\'s Generation (Non-Working Hour wise)
           </td></tr>
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
             // Total PROCMART count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Procmart</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT1'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT2'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT3'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT4'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT5'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT6'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT7'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT8'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT21'].'</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT22'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT23'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['PROCMART_CALL_CNT24'].'</td>'; 
            $totalnw_procmart_call= $genDataSth['PROCMART_CALL_CNT1']+ $genDataSth['PROCMART_CALL_CNT2']+ $genDataSth['PROCMART_CALL_CNT3']+ $genDataSth['PROCMART_CALL_CNT4']+ $genDataSth['PROCMART_CALL_CNT5']+ $genDataSth['PROCMART_CALL_CNT6']+ $genDataSth['PROCMART_CALL_CNT7']+ $genDataSth['PROCMART_CALL_CNT8']+ $genDataSth['PROCMART_CALL_CNT9']+ $genDataSth['PROCMART_CALL_CNT22']+ $genDataSth['PROCMART_CALL_CNT23']+ $genDataSth['PROCMART_CALL_CNT24'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$totalnw_procmart_call.'</td>';
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
      echo '</table> ';  
      
}

 //Modification in Pending Dashboard

elseif($rtype == 'PD')
{
//Total Pending Data
$date_time = strtoupper(date("d M Y H:i:s"));
$redis_CALL_TOT = $redis->LLEN('LEAP_CALL_USER');     
$redis_CON_FLAG = $redis->LLEN('LEAP_CALL_USER_FLAG');

$Total_buylead=$pend_bl['PENDING_LEADS'];

$Total_user=$pend_user['PENDING_USERS'];
//Manual Pool Data

$redis_data_mustcall = $redis->LLEN('LEAP_MUST_CALL');
$redis_data_mustcall_flag =$redis->LLEN('LEAP_MUST_CALL_FLAGGED');


$redis_data_dnccal = $redis->LLEN('LEAP_DO_NOT_CALL');
$redis_data_foreign = $redis->LLEN('LEAP_FOREIGN');

$redis_data_service = $redis->LLEN('LEAP_SERVICE');
$redis_data_service_flag =$redis->LLEN('LEAP_SERVICE_FLAGGED');

$redis_data_intentpool =$redis->LLEN('LEAP_INTENT');
$redis_data_intentpool_flag = $redis->LLEN('LEAP_INTENT_FLAGGED');


echo '<table style="width:100%;" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<th colspan="10" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Total Pending As On ('.$date_time.')(From Previous Screen)</th>
</tr>
<tr>
<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">PENDING_FOREIGN_USER</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_FOREIGN_LEADS</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_SERVICE_USER</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_SERVICE_LEADS</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_DNC_USER</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_DNC_LEADS</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_MUST_CALL_USER</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_MUST_CALL_LEADS</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_INTENT_USER</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">PENDING_INTENT_LEADS</td>
</tr>
<tr>
<td align="center" style="font-size:13px;padding:2px 4px;;color:#454545;">'.$pend_user['PENDING_FOREIGN_USER'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_bl['PENDING_FOREIGN'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_user['PENDING_SERVICE_USER'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_bl['PENDING_SERVICE'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_user['PENDING_DNC_USER'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_bl['PENDING_DNC'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_user['PENDING_MUST_CALL_USER'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_bl['PENDING_MUST_CALL'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_user['PENDING_INTENT_USER'].'</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_bl['PENDING_INTENT'].'</td>
</tr>
</table><br><br>';


    echo '<table style="width:40%;" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<th colspan="7" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Total Pending As On ('.$date_time.')</th>
</tr>
<tr>
<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Section</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Intent</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Non Intent</td>
<td align="center" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Total</td>
</tr>
<tr>
<td align="left" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Buyleads</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_bl['PENDING_INTENT'].'</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($Total_buylead-$pend_bl['PENDING_INTENT']).'</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Total_buylead.'</td>
</tr>
<tr>
<td align="left" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Unique User</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$pend_user['PENDING_INTENT_USER'].'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($Total_user-$pend_user['PENDING_INTENT_USER']).'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$Total_user.'</td>
</tr>



<tr>
<td align="left" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Attempted Once</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td> 
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_CALL_TOT.'</td>
</tr>

<tr>
<td align="left" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Connected But Flagged</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td> 
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_CON_FLAG.'</td>
</tr>
<tr>
<td align="left" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Total</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">'.($pendData_user_Buyleads['INTENT_BUYLEAD']+$pendData_user_intent['INTENT_USER']).'</td> 
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">'.($pendData_user_Buyleads['NON_INTENT_BUYLEAD']+$pendData_user_NON_intent['NON_INTENT_USER']).'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($Total_buylead+$Total_user+$redis_CALL_TOT+$redis_CON_FLAG).'</td>
</tr>

</table><br><br>';
  
  echo '<table style="width:50%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
  <tr>
<th colspan="7" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Manual Pending Pool As On ('.$date_time.')</th>
</tr>
<tr>
<td align="center" rowspan="2"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Pool</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Fresh Leads</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Flagged Leads</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Total</td>
</tr>
<tr>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_mustcall.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_mustcall_flag.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_data_mustcall+$redis_data_mustcall_flag).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>



<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Service</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_service.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_service_flag.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_data_service+$redis_data_service_flag).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Intent</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_intentpool.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_intentpool_flag.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_data_intentpool+$redis_data_intentpool_flag).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Indian)</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_dnccal.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Foriegn)</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$redis_data_foreign.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Total</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_data_mustcall+$redis_data_service+$redis_data_intentpool).'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_data_mustcall_flag+$redis_data_service_flag+$redis_data_intentpool_flag).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_data_mustcall+$redis_data_mustcall_flag+$redis_data_service+$redis_data_service_flag+$redis_data_intentpool+$redis_data_intentpool_flag+$redis_data_dnccal+$redis_data_foreign).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>


</table><br><br>';
  
  if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN')
  {
  echo '<table style="width:50%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
  <tr>
<th colspan="7" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Predictive Pending Pool As On ('.$date_time.')</th>
</tr>
<tr>
<td align="center" rowspan="2"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Pool</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Fresh Leads</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Flagged Leads</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Total</td>
</tr>
<tr>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">to be Taken</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">to be Taken</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">to be Taken</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>


<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Intent</td>
<td align="center" bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">to be Taken</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">to be Taken</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#d0f8be" style="font-size:13px;padding:2px 4px;color:#454545;">to be Taken</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Indian)</td>
<td align="center" bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Foriegn)</td>
<td align="center" bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Total</td>
<td align="center" bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>
</table><br><br>';

}
  
   list($fresh_kohar_must,$flag_kohar_must,$fresh_VKALP_must,$flag_VKALP_must,$fresh_COGENT_must,$flag_COGENT_must,$fresh_COGENTINTENT_INTENT,$flag_COGENTINTENT_INTENT,$fresh_KOCHARTECHDNC_DNC,$flag_KOCHARTECHDNC_DNC,$fresh_RADIATE_must,$flag_RADIATE_must)='';
        while($row=oci_fetch_array($pendingtot_pred_sth)){
                if($row['LEAP_VENDOR_NAME'] =='KOCHARTECH' && $row['CALL_DURATION'] ==NULL)
                {
                  $fresh_kohar_must=$row['PENDING_CNT'];
                }
                if($row['LEAP_VENDOR_NAME'] =='KOCHARTECH' && $row['CALL_DURATION'] !=NULL)
                {
                  $flag_kohar_must=$row['PENDING_CNT'];
                }
                if($row['LEAP_VENDOR_NAME'] =='VKALP' && $row['CALL_DURATION'] ==NULL)
                {
                  $fresh_VKALP_must=$row['PENDING_CNT'];
                }
                if($row['LEAP_VENDOR_NAME'] =='VKALP' && $row['CALL_DURATION'] !=NULL)
                {
                  $flag_VKALP_must=$row['PENDING_CNT'];
                }
                if($row['LEAP_VENDOR_NAME'] =='COGENT' && $row['CALL_DURATION'] ==NULL)
                {
                  $fresh_COGENT_must=$row['PENDING_CNT'];
                }
                if($row['LEAP_VENDOR_NAME'] =='COGENT' && $row['CALL_DURATION'] !=NULL)
                {
                  $flag_COGENT_must=$row['PENDING_CNT'];
                }
                if($row['LEAP_VENDOR_NAME'] =='COGENTINTENT' && $row['CALL_DURATION'] ==NULL)
                {
                  $fresh_COGENTINTENT_INTENT=$row['PENDING_CNT'];
                }
                
                if($row['LEAP_VENDOR_NAME'] =='COGENTINTENT' && $row['CALL_DURATION'] !=NULL)
                {
                  $flag_COGENTINTENT_INTENT=$row['PENDING_CNT'];
                }
                
                if($row['LEAP_VENDOR_NAME'] =='KOCHARTECHDNC' && $row['CALL_DURATION'] ==NULL)
                {
                  $fresh_KOCHARTECHDNC_DNC=$row['PENDING_CNT'];
                }
                
                if($row['LEAP_VENDOR_NAME'] =='KOCHARTECHDNC' && $row['CALL_DURATION'] !=NULL)
                {
                  $flag_KOCHARTECHDNC_DNC=$row['PENDING_CNT'];
                }
                if($row['LEAP_VENDOR_NAME'] =='RADIATE' && $row['CALL_DURATION'] ==NULL)
                {
                  $fresh_RADIATE_must=$row['PENDING_CNT'];
                }
                
                if($row['LEAP_VENDOR_NAME'] =='RADIATE' && $row['CALL_DURATION'] !=NULL)
                {
                  $flag_RADIATE_must=$row['PENDING_CNT'];
                }
                
            
        }
  if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='VKALP' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='COGENT' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='COGENTINTENT')    
  {
  
  echo '<table style="width:50%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
  <tr>
<th colspan="7" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Predictive Pending CenterWise As On ('.$date_time.') (One Day Old Data)</th>
</tr>
<tr>
<td align="center" rowspan="2"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Center</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Fresh Leads</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Flagged Leads</td>
<td colspan="2" align="center"  style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Total</td>
</tr>
<tr>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
</tr>';
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECH')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Kochartech</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_kohar_must.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_kohar_must.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_kohar_must+$flag_kohar_must).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>';
}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='VKALP')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Vkalp</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_VKALP_must.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_VKALP_must.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_VKALP_must+$flag_VKALP_must).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>';
}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='COGENT')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Cogent</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_COGENT_must.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_COGENT_must.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_COGENT_must+$flag_COGENT_must).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>';
}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='COGENTINTENT')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Cogentintent</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_COGENTINTENT_INTENT.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_COGENTINTENT_INTENT.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_COGENTINTENT_INTENT+$flag_COGENTINTENT_INTENT).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>';

}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='RADIATE')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">RADIATE</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_RADIATE_must.'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_RADIATE_must.'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_RADIATE_must+$flag_RADIATE_must).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>';

}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Total</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_kohar_must+$fresh_VKALP_must+$fresh_COGENT_must+$fresh_COGENTINTENT_INTENT+$fresh_RADIATE_must+$flag_RADIATE_must).'</td> 
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($flag_kohar_must+$flag_VKALP_must+$flag_COGENT_must+$flag_COGENTINTENT_INTENT).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_VKALP_must+$flag_VKALP_must+$fresh_COGENTINTENT_INTENT+$flag_COGENTINTENT_INTENT+$fresh_COGENT_must+$flag_COGENT_must+$fresh_kohar_must+$flag_kohar_must+$fresh_RADIATE_must+$flag_RADIATE_must).'</td>
<td align="center"  bgcolor="#f8bec2" style="font-size:13px;padding:2px 4px;color:#454545;">NA</td>
</tr>';
}
echo '</table>';

}
   
}
}
  ?>
        </body></html>