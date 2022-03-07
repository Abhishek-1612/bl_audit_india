<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
		<html>
       <title>Pending BL Approval Dashboard-3</title>
       <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
        <script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
        <script language="javascript" src="/js/calendar.js"></script>
        
<!--google analytics async code end-->	
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="S"){          
           $('#td_pool').hide();
           $('#drp_pool').hide();
           $('#pr_pool').hide();
           $('#pr_checkbox').hide();
           $('#pr_checkbox_aov').hide(); 
           $('#drp_rag').hide();
        }else{
            $('#td_pool').show();
            $('#drp_pool').show();
        }
        if($(this).attr("value")=="D"){
            $('#td_pool').show();
            $('#drp_pool').show();
            $('#pr_pool').hide();
             $('#pr_checkbox').hide();
             $('#pr_checkbox_aov').hide(); 
             $('#drp_rag').hide();
        }
         if(($(this).attr("value")=="R") || ($(this).attr("value")=="GEN") || ($(this).attr("value")=="INS") || ($(this).attr("value")=="PEND") || ($(this).attr("value")=="APP")) {
            $('#td_pool').hide();
            $('#drp_pool').hide();
            $('#pr_pool').hide();
            $('#drp_rag').show();
             $('#pr_checkbox').hide();
             $('#pr_checkbox_aov').hide(); 
        }
        if(($(this).attr("value")=="P") || ($(this).attr("value")=="PT")){
            $('#drp_rag').hide();
            $('#td_pool').hide();
            $('#drp_pool').hide();
            $('#pr_pool').show();
            $('#pr_checkbox').show();
            $('#pr_checkbox_aov').show(); 
        }
        
        if($(this).attr("value")=="PD"){
            $('#drp_rag').hide();
            $('#td_pool').hide();
            $('#drp_pool').hide();
            $('#pr_pool').hide();
             $('#pr_checkbox').hide();
             $('#pr_checkbox_aov').hide(); 
        } 
	if($(this).attr("value")=="T"){
            $('#drp_rag').hide();
            $('#td_pool').show();
            $('#drp_pool').show();
            $('#pr_pool').hide();
            $('#pr_checkbox').show(); $('#pr_checkbox_aov').hide();            		
        }
        if($(this).attr("value")=="RT"){
            $('#drp_rag').hide();
            $('#td_pool').hide();
            $('#drp_pool').show();
            $('#pr_pool').hide();
            $('#pr_checkbox').show(); $('#pr_checkbox_aov').hide();            		
        }
        
    });
    
    $('input[type="checkbox"]').click(function(){
    if($(this).attr("value")=="ALL"){ 
    
    $('#vendor2').attr('checked', false);
    $('#vendor3').attr('checked', false);
    $('#vendor4').attr('checked', false);
    $('#vendor5').attr('checked', false);
    $('#vendor6').attr('checked', false);
    $('#vendor7').attr('checked', false);
    $('#vendor8').attr('checked', false);
    $('#vendor9').attr('checked', false);
    $('#vendor10').attr('checked', false);
    $('#vendor11').attr('checked', false);
    $('#vendor12').attr('checked', false);
    $('#vendor13').attr('checked', false);
    $('#vendor14').attr('checked', false);
    $('#vendor15').attr('checked', false);
    $('#vendor16').attr('checked', false);
    $('#vendor17').attr('checked', false);
    $('#vendor35').attr('checked', false);
    
    }
    
    if($(this).attr("value")=="COGENT" ||$(this).attr("value")=="BANREVIEW" || $(this).attr("value")=="COGENTINTENT" || $(this).attr("value")=="KOCHARTECH" || $(this).attr("value")=="KOCHARTECHAUTO" || $(this).attr("value")=="KOCHARTECHINTENT" || $(this).attr("value")=="VKALP"  || $(this).attr("value")=="VKALPAUTOFRN" || $(this).attr("value")=="VKALPAUTOIND" || $(this).attr("value")=="RADIATE"  || $(this).attr("value")=="RADIATEINTENT"   || $(this).attr("value")=="RADIATEPNSMRK"  || $(this).attr("value")=="RADIATEAUTO" || $(this).attr("value")=="VKALPINTENT"){
    
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
.headt{background: #FFFFFF; color: black;font-size:12px;padding:2px 4px;font-weight: bold;}
.t{background: #FFFFFF; color: black;font-size:12px;padding:2px 4px;}
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
$aov=isset($_REQUEST['aov']) ? $_REQUEST['aov'] : '';
$display_pool='style="display:none;"';
$display_pr_rag='style="display:none;"';
$display_pr_pool='style="display:none;"';
$display_pr_checkbox='style="display:none;"';
$display_pr_checkbox_aov='style="display:none;"';
if($rtype == 'D'){
    $display_pool='';
}
if($rtype == 'R'){
    $display_pr_rag='';
}
if($rtype == 'P'){
    $display_pr_pool=$display_pr_checkbox_aov =$display_pr_checkbox = '';
}
if($rtype == 'T'){
	$display_pool='';
	$display_pr_checkbox_aov =$display_pr_checkbox = '';
}
if($vendorVal == 'ALL'){
	$dataHeading = 'Generated';
}
$sel_pool_i=$sel_pool_a=$sel_pool_d=$sel_pool_i=$sel_pool_df=$sel_pool_m='';
if($rtype == "D" || $rtype == "T")
{
	if($sel_pool=='All'){
		$sel_pool_a= 'selected';
	}
	if($sel_pool=='MUST CALL'){
		$sel_pool_m= 'selected';
	}
	if($sel_pool=='DNC-INDIA'){
		$sel_pool_d= 'selected';
	}
	
	if($sel_pool=='INTENT'){
		$sel_pool_i= 'selected';
	}
        if($sel_pool=='DNC-FORIEGN'){
		$sel_pool_df= 'selected';
	}
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
     <tr><td width="10%" style="font-weight: bold">Select Date:</td><td width="60%">        
<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
         </td>
         <td width="30%"><input type="submit" name="btnsubmit" id="btnsubmit" value="Generate"></td>
     </tr><tr>
         <td style="font-weight: bold">Report Type:</td><td>
<input type="radio" name="rtype" value="D" <?php echo ($rtype == 'D' || $rtype == '')?'checked':''; ?> >&nbsp;Detailed Report&nbsp;&nbsp;
<input type="radio" name="rtype" value="P" <?php echo ($rtype == 'P')?'CHECKED="CHECKED"':'' ?> >&nbsp;Predictive Report&nbsp;&nbsp;
<input type="radio" name="rtype" value="PD" <?php echo ($rtype == 'PD')?'CHECKED="CHECKED"':'' ?> >&nbsp;Pending Report&nbsp;&nbsp;
<input type="radio" name="rtype" value="T" <?php echo ($rtype == 'T')?'CHECKED="CHECKED"':'' ?> >&nbsp;Timeliness Report&nbsp;&nbsp;
<input type="radio" name="rtype" value="R" <?php echo ($rtype == 'R')?'CHECKED="CHECKED"':'' ?> >&nbsp;RAG Report&nbsp;&nbsp;
<input type="radio" name="rtype" value="RT" <?php echo ($rtype == 'RT')?'CHECKED="CHECKED"':'' ?> >&nbsp;Review Pool Timeliness 
<input type="radio" name="rtype" value="PT" <?php echo ($rtype == 'PT')?'CHECKED="CHECKED"':'' ?> >&nbsp;Pending Till Date&nbsp;&nbsp;
</td>
<td style="font-weight: bold"><span id="td_pool" <?php echo $display_pool;?>>Select Pool:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="drp_pool" id="drp_pool"  width="100px">
        <option value="All">--All--</option><option <?php echo $sel_pool_m;?> value="MUST CALL">MUST CALL</option><option <?php echo $sel_pool_d;?>  value="DNC-INDIA">DNC-INDIA</option><option <?php echo $sel_pool_df;?>  value="DNC-FORIEGN">DNC-FORIEGN</option><option <?php echo $sel_pool_i;?> value="INTENT">INTENT</option>
</select></span>
    
 <span id="pr_pool" <?php echo $display_pr_pool;?>><b>PR Type:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="ALL" <?php echo ($prtype == 'ALL' || $prtype == '')?'checked':''; ?> >&nbsp;ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                
<input type="radio" name="prtype" value="fresh" <?php echo ($prtype == 'fresh')?'CHECKED="CHECKED"':'' ?> >&nbsp;Fresh&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="flag" <?php echo ($prtype == 'flag')?'CHECKED="CHECKED"':'' ?> >&nbsp;Flag
</span>   
    
 <span id="drp_rag" <?php echo $display_pr_rag;?>><b>Type:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="PEND" <?php echo ($prtype == 'PEND' || $prtype == '')?'checked':''; ?> >&nbsp;Pendency&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="GEN" <?php echo ($prtype == 'GEN')?'CHECKED="CHECKED"':'' ?> >&nbsp;Generation&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="APP" <?php echo ($prtype == 'APP')?'CHECKED="CHECKED"':'' ?> >&nbsp;Approval&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="prtype" value="INS" <?php echo ($prtype == 'INS')?'CHECKED="CHECKED"':'' ?> >&nbsp;Insertion
</span>   
</td>
</tr>

<tr id="pr_checkbox" <?php echo $display_pr_checkbox;?>>
<td>
<b>Vendor:</b>&nbsp;</td><td colspan="3">
<?php 
if($vendorVal =='ALL' || $vendorVal =='')
{
echo '<input type="checkbox" value="ALL" checked="checked" name="vendor1" id="vendor1">ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="ALL"  name="vendor1" id="vendor1">ALL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
// if($rtype=='P'){
if(in_array('BANREVIEW',$arrvendorVal) )
{
echo '<input type="checkbox" value="BANREVIEW" checked="checked" name="vendor1" id="vendor35">BANREVIEW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="BANREVIEW"  name="vendor1" id="vendor35">BANREVIEW&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
// }
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
if(in_array('COMPETENT',$arrvendorVal))
{
 echo '<input type="checkbox" value="COMPETENT" checked="checked" name="vendor1" id="vendor10">COMPETENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="COMPETENT"  name="vendor1" id="vendor10">COMPETENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('COMPETENTDNC',$arrvendorVal))
{
 echo '<input type="checkbox" value="COMPETENTDNC" checked="checked" name="vendor1" id="vendor34">COMPETENTDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="COMPETENTDNC"  name="vendor1" id="vendor34">COMPETENTDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('IENERGIZERPNSMRK',$arrvendorVal))
{
 echo '<input type="checkbox" value="IENERGIZERPNSMRK" checked="checked" name="vendor1" id="vendor18">IENERGIZERPNSMRK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="IENERGIZERPNSMRK"  name="vendor1" id="vendor18">IENERGIZERPNSMRK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('KOCHARTECH',$arrvendorVal))
{
 echo '<input type="checkbox" value="KOCHARTECH" checked="checked" name="vendor1" id="vendor17">KOCHARTECH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="KOCHARTECH"  name="vendor1" id="vendor17">KOCHARTECH&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
//new-vendor-KOCHARTECHAUTO
if(in_array('KOCHARTECHAUTO',$arrvendorVal))
{
 echo '<input type="checkbox" value="KOCHARTECHAUTO" checked="checked" name="vendor1" id="vendor4">KOCHARTECHAUTO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="KOCHARTECHAUTO"  name="vendor1" id="vendor4">KOCHARTECHAUTO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('KOCHARTECHDNC',$arrvendorVal))
{
 echo '<input type="checkbox" value="KOCHARTECHDNC" checked="checked" name="vendor1" id="vendor20">KOCHARTECHDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="KOCHARTECHDNC"  name="vendor1" id="vendor20">KOCHARTECHDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('KOCHARTECHINTENT',$arrvendorVal))
{
 echo '<input type="checkbox" value="KOCHARTECHINTENT" checked="checked" name="vendor1" id="vendor8">KOCHARTECHINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="KOCHARTECHINTENT"  name="vendor1" id="vendor8">KOCHARTECHINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('LIVEDIGITAL',$arrvendorVal))
{
 echo '<input type="checkbox" value="LIVEDIGITAL" checked="checked" name="vendor1" id="vendor19">LIVEDIGITAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
  echo '<input type="checkbox" value="LIVEDIGITAL"  name="vendor1" id="vendor19">LIVEDIGITAL&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('VKALP',$arrvendorVal))
{
 echo '<input type="checkbox" value="VKALP" checked="checked" name="vendor1" id="vendor5">VKALP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="VKALP"  name="vendor1" id="vendor5">VKALP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('VKALPDNC',$arrvendorVal))
{
 echo '<input type="checkbox" value="VKALPDNC" checked="checked" name="vendor1" id="vendor11">VKALPDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="VKALPDNC"  name="vendor1" id="vendor11">VKALPDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('VKALPAUTOFRN',$arrvendorVal))
{
 echo '<input type="checkbox" value="VKALPAUTOFRN" checked="checked" name="vendor1" id="vendor9">VKALPAUTOFRN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="VKALPAUTOFRN"  name="vendor1" id="vendor9">VKALPAUTOFRN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('VKALPAUTOIND',$arrvendorVal))
{
 echo '<input type="checkbox" value="VKALPAUTOIND" checked="checked" name="vendor1" id="vendor16">VKALPAUTOIND&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="VKALPAUTOIND"  name="vendor1" id="vendor16">VKALPAUTOIND&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('VKALPINTENT',$arrvendorVal))
{
 echo '<input type="checkbox" value="VKALPINTENT" checked="checked" name="vendor1" id="vendor14">VKALPINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="VKALPINTENT"  name="vendor1" id="vendor14">VKALPINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('RADIATE',$arrvendorVal))
{
 echo '<input type="checkbox" value="RADIATE" checked="checked" name="vendor1" id="vendor6">RADIATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="RADIATE"  name="vendor1" id="vendor6">RADIATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
//test

if(in_array('RADIATEDNC',$arrvendorVal))
{
 echo '<input type="checkbox" value="RADIATEDNC" checked="checked" name="vendor1" id="vendor12">RADIATEDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="RADIATEDNC"  name="vendor1" id="vendor12">RADIATEDNC&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('RADIATEFRN',$arrvendorVal))
{
 echo '<input type="checkbox" value="RADIATEFRN" checked="checked" name="vendor1" id="vendor13">RADIATEFRN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="RADIATEFRN"  name="vendor1" id="vendor13">RADIATEFRN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('RADIATEINTENT',$arrvendorVal))
{
 echo '<input type="checkbox" value="RADIATEINTENT" checked="checked" name="vendor1" id="vendor7">RADIATEINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="RADIATEINTENT"  name="vendor1" id="vendor7">RADIATEINTENT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}

if(in_array('RADIATEPNSMRK',$arrvendorVal))
{
 echo '<input type="checkbox" value="RADIATEPNSMRK" checked="checked" name="vendor1" id="vendor8">RADIATEPNSMRK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="RADIATEPNSMRK"  name="vendor1" id="vendor8">RADIATEPNSMRK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
if(in_array('RADIATEAUTO',$arrvendorVal))
{
 echo '<input type="checkbox" value="RADIATEAUTO" checked="checked" name="vendor1" id="vendor15">RADIATEAUTO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}
else
{
 echo '<input type="checkbox" value="RADIATEAUTO"  name="vendor1" id="vendor15">RADIATEAUTO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
}

echo '<input type="hidden" name="vendorVal" id="vendorVal" value="">
</span>
</td>';
?>
</tr>
<tr id="pr_checkbox_aov" <?php echo $display_pr_checkbox_aov;?>>
<td>
<b>Type:</b>&nbsp;</td><td colspan="3">
<input type="radio" value="All"  name="aov" <?php echo ($aov == 'All' || $aov == '')?'checked':''; ?> >All&nbsp;&nbsp;
<input type="radio" name="aov" value="HIGHAOV"  <?php echo ($aov == 'AOV') ?'checked':''; ?>>High AOV&nbsp;&nbsp;
<input type="radio" name="aov" value="REINSERT"  <?php echo ($aov == 'REINSERT') ?'checked':''; ?>>Flag Re-Insertion&nbsp;&nbsp;
</td>
</tr></table>   
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
    $data1=array();
		$data1 = isset($data[$i])?$data[$i]:'';
				
		$gen = isset($data1['GEN']) ? $data1['GEN'] : 0; 
		$genHtml .= '<td align="center" >'.$gen.'</td>';
		
		$app = isset($data1['TOTAL_APPROVED']) ? $data1['TOTAL_APPROVED'] : 0; 
		$appHtml .= '<td align="center" >'.$app.'</td>';
		
		$app15Min = isset($data1['APP_WITH_IN_15MIN']) ? $data1['APP_WITH_IN_15MIN'] : 0; 
		$app15MinHtml .= '<td align="center" >'.$app15Min.'</td>';
		
		$del15Min = isset($data1['DEL_WITH_IN_15MIN']) ? $data1['DEL_WITH_IN_15MIN'] : 0; 
		$del15MinHtml .= '<td align="center" >'.$del15Min.'</td>';
		
		$timeliness = ($gen != 0) ? round($app*100/$gen,2) : 0;
		$timelinessHtml .= '<td align="center" >'.$timeliness.'%</td>';

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
if($rtype == 'RT')
{
	$totalGen = $totalApp = $gen9_to_9 = $app9_to_9=$app29_to_9 = $totalApp15Min = $totalDel15Min = $del15Min_9_to_9 = $app15Min_9_to_9 =0;$tdhtml=$appHtml2=$timelinessHtml2='';
	
	echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
			<tr>
				<td colspan="27" align="center" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Review Pool Timeliness Report </td>
			</tr>	
			<tr>
				<td colspan="27" align="center" style="font-size:15px;font-weight:bold;color:#000099;background:#e3eff8;">Vendor :- '.$vendorVal.'</td>
			</tr>';
        $tdhtml .='<tr>
                    <td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>';
                                
    for($i=0;$i<24;$i++)
	{
        $tdhtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$i.'-'.($i+1).'</td>';
        }
                             
        $tdhtml .='<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Overall Timeliness</td>
				<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Overall Timeliness (9AM to 9 PM)</td>
			<tr>';
			
        echo $tdhtml;
			
	$genHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Auto Approved</td>';
	$appHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Reviewed(Within 5 Minutes)</td>';
	$timelinessHtml = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Timeliness (Within 5 Minutes)</td>';
	$appHtml2 = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Reviewed(Within 2 Minutes)</td>';
	$timelinessHtml2 = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Timeliness (Within 2 Minutes)</td>';
        $appHtml1 = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Reviewed(Within 1 Minutes)</td>';
	$timelinessHtml1 = '<tr><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Timeliness (Within 1 Minutes)</td>';
	for($i=0;$i<24;$i++)
	{		
    $data1=array();
		$data1 = @$data[$i];
    if(!empty($data1)){
		$data1= array_change_key_case($data1,CASE_UPPER);
    }        
		$gen = isset($data1['GEN_COUNT']) ? $data1['GEN_COUNT'] : 0; 
		$genHtml .= '<td align="center" >'.$gen.'</td>';
		$app = isset($data1['APP_DEL']) ? $data1['APP_DEL'] : 0; 
                $app2 = isset($data1['APP_DEL_2']) ? $data1['APP_DEL_2'] : 0;
                $app1 = isset($data1['APP_DEL_1']) ? $data1['APP_DEL_1'] : 0;
		$appHtml .= '<td align="center" >'.$app.'</td>';
		$appHtml2 .= '<td align="center" >'.$app2.'</td>';
                $appHtml1 .= '<td align="center" >'.$app1.'</td>';
		$timeliness = ($gen != 0) ? round($app*100/$gen,2) : 0;
		$timelinessHtml .= '<td align="center" >'.$timeliness.'%</td>';

                $timeliness2 = ($gen != 0) ? round($app2*100/$gen,2) : 0;
		$timelinessHtml2 .= '<td align="center" >'.$timeliness2.'%</td>';
                
                $timeliness1 = ($gen != 0) ? round($app1*100/$gen,2) : 0;
		$timelinessHtml1 .= '<td align="center" >'.$timeliness1.'%</td>';
    $totalApp2=isset($totalApp2)?$totalApp2:0; 
    $totalApp1=isset($totalApp1)?$totalApp1:0;             
		$totalGen += $gen;		
		$totalApp += $app;
                $totalApp2 += $app2;
                $totalApp1 += $app1;
		$timeRange = range(9,20,1);
		$app19_to_9=isset($app19_to_9)?$app19_to_9:0;    
    $app29_to_9=isset($app29_to_9)?$app29_to_9:0;    
		if(in_array($i,$timeRange)){
			$gen9_to_9 += $gen;
			$app9_to_9 += $app;
                        $app19_to_9 += $app1;
                        $app29_to_9 += $app2;
		} 	
	}
	$totalTimeliness = ($totalGen != 0) ? round($totalApp*100/$totalGen,2) : 0;
	$totalTimeliness9_to_9 	= ($gen9_to_9 != 0) ? round($app9_to_9*100/$gen9_to_9,2) : 0;

        $totalTimeliness2 = ($totalGen != 0) ? round($totalApp2*100/$totalGen,2) : 0;
	$totalTimeliness29_to_9 	= ($gen9_to_9 != 0) ? round($app29_to_9*100/$gen9_to_9,2) : 0;
        
        $totalTimeliness1 = ($totalGen != 0) ? round($totalApp1*100/$totalGen,2) : 0;
	$totalTimeliness19_to_9 	= ($gen9_to_9 != 0) ? round($app19_to_9*100/$gen9_to_9,2) : 0;
        
	$genHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalGen.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$gen9_to_9.'</td></tr>';
	
	$appHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalApp.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$app9_to_9.'</td></tr>';
	
	$timelinessHtml .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness.'%</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness9_to_9.'%</td></tr>';
	
        $appHtml2 .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalApp2.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$app29_to_9.'</td></tr>';
	
        $appHtml1 .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalApp1.'</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$app19_to_9.'</td></tr>';
	
	$timelinessHtml2 .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness2.'%</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness29_to_9.'%</td></tr>';
	$timelinessHtml1 .= '<td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness1.'%</td><td align="center" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">'.$totalTimeliness19_to_9.'%</td></tr></table>';
	
	echo $genHtml;
	echo $appHtml;	
        echo $timelinessHtml;
	echo $appHtml2;	
	echo $timelinessHtml2;
        echo $appHtml1;	
	echo $timelinessHtml1;
	
}
elseif($rtype == 'PT'){
    $total_pend_record=$data['total_pend'];
    echo '<table width="60%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr><td colspan="2" class="h1 c">Pending Till Date
            </td></tr>';
        foreach($total_pend_record as $row){
                echo '<tr><td class="h2 c">'.$row['LEAP_VENDOR_NAME'].'</td><td class="h2 c">'.$row['PENDING_CNT'].'</td></tr>';
        }
       echo '</table><br/>';
}elseif($rtype == 'P'){
    $pend=$data['pend'];
    $vendor_name='';
    echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
            <tr><td colspan="27" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Predictive dialing Hourly Report 
            </td></tr>';
            $vendor_name='';$total_sent=0;$total_pend=0;$total_tim=0;$cnt=0;$d1=array();
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
                    $d1[$cnt]['SENT_0']=$row['TOTAL_SENT'];
                    $d1[$cnt]['REC_0']=$row['REC_CNT'];
                    $d1[$cnt]['PEND_0']=$row['PENDING_CNT'];
                    $d1[$cnt]['ATTEMP_0']=$row['ATTEMPT_CNT'];
                    $d1[$cnt]['PEND_TEN_0']=$row['PENDING_TIMLINESS_CNT'];
                    $d1[$cnt]['ATTEMP_TEN_0']=$row['ATTEMPTED_TIMLINESS_CNT'];
                    $d1[$cnt]['ATTEMP_1_0']=$row['ATTEMPTED_TIMLINESS_CNT_1'];
                    $d1[$cnt]['ATTEMP_2_0']=$row['ATTEMPTED_TIMLINESS_CNT_2'];
                    $d1[$cnt]['ATTEMP_5_0']=$row['ATTEMPTED_TIMLINESS_CNT_5'];
                    $d1[$cnt]['ATTEMP_15_0']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_TEN_0']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                    $d1[$cnt]['NOT_ATTEMP_5_0']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_0']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_TIM_0']=isset($row['NOT_TIMLINESS_CNT'])?$row['NOT_TIMLINESS_CNT']:'';
                }elseif($row['HR'] == '01'){
                     $d1[$cnt]['SENT_1']=$row['TOTAL_SENT'];$d1[$cnt]['REC_1']=$row['REC_CNT'];$d1[$cnt]['PEND_1']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_1']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_1']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_1']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_1']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_1']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_1']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_1']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['ATTEMP_TEN_1']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_1']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];
                     $d1[$cnt]['ATTEMP_15_1']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                     $d1[$cnt]['NOT_ATTEMP_5_1']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                     $d1[$cnt]['NOT_ATTEMP_15_1']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
                 }elseif($row['HR'] == '02'){
                    $d1[$cnt]['SENT_2']=$row['TOTAL_SENT'];$d1[$cnt]['REC_2']=$row['REC_CNT'];$d1[$cnt]['PEND_2']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_2']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_2']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_2']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_2']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_2']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_2']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_2']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_2']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_2']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                 }elseif($row['HR'] == '03'){
                   $d1[$cnt]['SENT_3']=$row['TOTAL_SENT'];$d1[$cnt]['REC_3']=$row['REC_CNT'];$d1[$cnt]['PEND_3']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_3']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_3']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_3']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_3']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_3']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_3']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_3']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_3']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_3']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_3']=$row['ATTEMPTED_TIMLINESS_CNT_15'];
                    $d1[$cnt]['NOT_ATTEMP_5_3']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_3']=$row['NOT_ATTEMPTED_TIMLINESS_CNT_15'];

                 }elseif($row['HR'] == '04'){
                     $d1[$cnt]['SENT_4']=$row['TOTAL_SENT'];$d1[$cnt]['REC_4']=$row['REC_CNT'];$d1[$cnt]['PEND_4']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_4']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_4']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_4']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_4']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_4']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_4']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_4']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_4']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_4']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_4']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                     $d1[$cnt]['NOT_ATTEMP_5_4']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                     $d1[$cnt]['NOT_ATTEMP_15_4']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
 
                 }elseif($row['HR'] == '05'){
                    $d1[$cnt]['SENT_5']=$row['TOTAL_SENT'];$d1[$cnt]['REC_5']=$row['REC_CNT'];$d1[$cnt]['PEND_5']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_5']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_5']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_5']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_5']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_5']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_5']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_5']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_5']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_5']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                 
                  }elseif($row['HR'] == '06'){
                    $d1[$cnt]['SENT_6']=$row['TOTAL_SENT'];$d1[$cnt]['REC_6']=$row['REC_CNT'];$d1[$cnt]['PEND_6']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_6']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_6']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_6']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_6']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_6']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_6']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_6']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_6']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_6']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
                }elseif($row['HR'] == '07'){
                     $d1[$cnt]['SENT_7']=$row['TOTAL_SENT'];$d1[$cnt]['REC_7']=$row['REC_CNT'];$d1[$cnt]['PEND_7']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_7']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_7']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_7']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_7']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_7']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_7']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_7']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                     $d1[$cnt]['NOT_ATTEMP_5_7']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                     $d1[$cnt]['NOT_ATTEMP_15_7']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
 
                }elseif($row['HR'] == '08'){
                    $d1[$cnt]['SENT_8']=$row['TOTAL_SENT'];$d1[$cnt]['REC_8']=$row['REC_CNT'];$d1[$cnt]['PEND_8']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_8']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_8']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_8']=$row['NOT_TIMLINESS_CNT'];
                    $d1[$cnt]['PEND_TEN_8']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_8']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_8']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_8']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_8']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_8']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_8']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_8']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_8']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '09'){
                     $d1[$cnt]['SENT_9_9_9']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_9']=$row['TOTAL_SENT'];$d1[$cnt]['REC_9']=$row['REC_CNT'];$d1[$cnt]['PEND_9']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_9']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_9']=$row['TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_9']=$row['NOT_TIMLINESS_CNT'];
                     $d1[$cnt]['PEND_TEN_9']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_9']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_9']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_9']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_9']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['ATTEMP_1_9']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_9']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_9']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_9']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_9']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                     $d1[$cnt]['NOT_ATTEMP_5_9']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                     $d1[$cnt]['NOT_ATTEMP_15_9']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
 
                }elseif($row['HR'] == '10'){
                     $d1[$cnt]['SENT_9_9_10']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_10']=$row['TOTAL_SENT'];$d1[$cnt]['REC_10']=$row['REC_CNT'];$d1[$cnt]['PEND_10']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_10']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_10']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_10']=$row['PENDING_TIMLINESS_CNT'];
                     $d1[$cnt]['ATTEMP_TEN_10']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_10']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_10']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_10']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['ATTEMP_1_10']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_10']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_10']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_10']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_10']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_10']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                     $d1[$cnt]['NOT_ATTEMP_5_10']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                     $d1[$cnt]['NOT_ATTEMP_15_10']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
 
                }elseif($row['HR'] == '11'){                     
                    $d1[$cnt]['SENT_9_9_11']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_11']=$row['TOTAL_SENT'];$d1[$cnt]['REC_11']=$row['REC_CNT'];$d1[$cnt]['PEND_11']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_11']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_11']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_11']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_11']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_11']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_11']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_11']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_11']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_11']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_11']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_11']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_11']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                  }elseif($row['HR'] == '12'){         
                    $d1[$cnt]['SENT_9_9_12']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_12']=$row['TOTAL_SENT'];$d1[$cnt]['REC_12']=$row['REC_CNT'];$d1[$cnt]['PEND_12']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_12']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_12']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_12']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_12']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_12']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_12']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_12']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_12']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_12']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_12']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_12']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_12']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                  }elseif($row['HR'] == '13'){         
                   $d1[$cnt]['SENT_9_9_13']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_13']=$row['TOTAL_SENT'];$d1[$cnt]['REC_13']=$row['REC_CNT'];$d1[$cnt]['PEND_13']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_13']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_13']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_13']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_13']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_13']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_13']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_13']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_13']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_13']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_13']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                   $d1[$cnt]['NOT_ATTEMP_5_13']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                   $d1[$cnt]['NOT_ATTEMP_15_13']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                  }elseif($row['HR'] == '14'){         
                   $d1[$cnt]['SENT_9_9_14']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_14']=$row['TOTAL_SENT'];$d1[$cnt]['REC_14']=$row['REC_CNT'];$d1[$cnt]['PEND_14']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_14']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_14']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_14']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_14']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_14']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_14']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_14']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_14']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_14']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_14']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                   $d1[$cnt]['NOT_ATTEMP_5_14']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                   $d1[$cnt]['NOT_ATTEMP_15_14']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                  }elseif($row['HR'] == '15'){         
                    $d1[$cnt]['SENT_9_9_15']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_9_9_7']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_15']=$row['TOTAL_SENT'];$d1[$cnt]['REC_15']=$row['REC_CNT'];$d1[$cnt]['PEND_15']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_15']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_15']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_15']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_15']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_15']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_15']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_15']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_15']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_TIM_15']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_15']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_15']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_15']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';
                }elseif($row['HR'] == '16'){         
                    $d1[$cnt]['SENT_9_9_16']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_9_9_7']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_16']=$row['TOTAL_SENT'];$d1[$cnt]['REC_16']=$row['REC_CNT'];$d1[$cnt]['PEND_16']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_16']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_16']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_16']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_16']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_ATTEMP_TEN_16']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_16']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_16']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_16']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_TIM_16']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_16']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_16']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_16']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '17'){         
                    $d1[$cnt]['SENT_9_9_17']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_17']=$row['TOTAL_SENT'];$d1[$cnt]['REC_17']=$row['REC_CNT'];$d1[$cnt]['PEND_17']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_17']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_17']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_17']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_17']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_17']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_17']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_17']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_17']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_17']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_17']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_17']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_17']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '18'){         
                    $d1[$cnt]['SENT_9_9_18']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_18']=$row['TOTAL_SENT'];$d1[$cnt]['REC_18']=$row['REC_CNT'];$d1[$cnt]['PEND_18']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_18']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_18']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_18']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_18']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_18']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_18']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_18']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_18']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_18']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_18']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_18']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_18']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '19'){         
                    $d1[$cnt]['SENT_9_9_19']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_19']=$row['TOTAL_SENT'];$d1[$cnt]['REC_19']=$row['REC_CNT'];$d1[$cnt]['PEND_19']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_19']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_19']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_19']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_19']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_19']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_19']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_19']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_19']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_19']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_19']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_19']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_19']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '20'){         
                    $d1[$cnt]['SENT_9_9_20']=$row['TOTAL_SENT'];$d1[$cnt]['SENT_20']=$row['TOTAL_SENT'];$d1[$cnt]['REC_20']=$row['REC_CNT'];$d1[$cnt]['PEND_20']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_20']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_20']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_20']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_20']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_20']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_20']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_20']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_20']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_20']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_20']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_20']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_20']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '21'){         
                    $d1[$cnt]['SENT_21']=$row['TOTAL_SENT'];$d1[$cnt]['REC_21']=$row['REC_CNT'];$d1[$cnt]['PEND_21']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_21']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_21']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_21']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_21']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_21']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_21']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_21']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_21']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_21']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_21']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_21']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_21']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '22'){         
                    $d1[$cnt]['SENT_22']=$row['TOTAL_SENT'];$d1[$cnt]['REC_22']=$row['REC_CNT'];$d1[$cnt]['PEND_22']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_22']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_22']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_22']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_22']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_22']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_22']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_22']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_22']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_22']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_22']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_22']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_22']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                }elseif($row['HR'] == '23'){         
                    $d1[$cnt]['SENT_23']=$row['TOTAL_SENT'];$d1[$cnt]['REC_23']=$row['REC_CNT'];$d1[$cnt]['PEND_23']=$row['PENDING_CNT'];$d1[$cnt]['ATTEMP_23']=$row['ATTEMPT_CNT'];$d1[$cnt]['TIM_23']=$row['TIMLINESS_CNT'];$d1[$cnt]['PEND_TEN_23']=$row['PENDING_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_TEN_23']=$row['ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_1_23']=$row['ATTEMPTED_TIMLINESS_CNT_1'];$d1[$cnt]['ATTEMP_2_23']=$row['ATTEMPTED_TIMLINESS_CNT_2'];$d1[$cnt]['ATTEMP_5_23']=$row['ATTEMPTED_TIMLINESS_CNT_5'];$d1[$cnt]['NOT_ATTEMP_TEN_23']=$row['NOT_ATTEMPTED_TIMLINESS_CNT'];$d1[$cnt]['NOT_TIM_23']=$row['NOT_TIMLINESS_CNT'];$d1[$cnt]['ATTEMP_15_23']=isset($row['ATTEMPTED_TIMLINESS_CNT_15'])?$row['ATTEMPTED_TIMLINESS_CNT_15']:'';
                    $d1[$cnt]['NOT_ATTEMP_5_23']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_5'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_5']:'';
                    $d1[$cnt]['NOT_ATTEMP_15_23']=isset($row['NOT_ATTEMPTED_TIMLINESS_CNT_15'])?$row['NOT_ATTEMPTED_TIMLINESS_CNT_15']:'';

                } 
                $vendor_name=$row['LEAP_VENDOR_NAME'];   
            }
            // echo '<pre>';print_r($d1);echo '</pre>';
            for($i=1;$i<=count($d1);$i++){              
                 echo '<tr><td colspan="27" class="h1 c">'.$d1[$i]['LEAP_VENDOR_NAME'].'</td></tr>';                 
                 echo '<tr><td width="65" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545"></td>';
                 $total_sent_9_9=$total_rec_9_9=$total_pend_9_9=$total_tim_9_9=$total_attemp_9_9=$total_attemp_1_9_9=$total_attemp_2_9_9=$total_attemp_5_9_9 = $total_attemp_15_9_9=$total_attemp_ten_9_9=$total_pend_ten_9_9=$total_attemp_not_ten_9_9=$total_rec_not_ten_9_9=0;
                 $total_sent=0;$total_rec=0;$total_pend=0;$total_tim=0;$total_attemp=0;$total_attemp_1=$total_attemp_2=$total_attemp_5=$total_attemp_15=$total_attemp_ten=0;$total_pend_ten=0;$total_attemp_not_ten=0;$total_rec_not_ten=0;$total_attemp_not_5=$total_attemp_not_15=0;
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
                    $total_attemp_15=$total_attemp_15+isset($d1[$i]['ATTEMP_15_'.$counter])?$d1[$i]['ATTEMP_15_'.$counter]:0;

                    $total_not_attemp_ten=$total_attemp_not_ten+isset($d1[$i]['NOT_ATTEMP_TEN_'.$counter])?$d1[$i]['NOT_ATTEMP_TEN_'.$counter]:0;
                    $total_not_attemp_5=$total_attemp_not_5+isset($d1[$i]['NOT_ATTEMP_5_'.$counter])?$d1[$i]['NOT_ATTEMP_5_'.$counter]:0;
                    $total_not_attemp_15=$total_attemp_not_15+isset($d1[$i]['NOT_ATTEMP_15_'.$counter])?$d1[$i]['NOT_ATTEMP_15_'.$counter]:0;


                    
                    $total_pend_ten=$total_pend_ten+$d1[$i]['PEND_TEN_'.$counter];
                    $d1[$i]['PEND_1_'.$counter]=isset($d1[$i]['PEND_1_'.$counter])?$d1[$i]['PEND_1_'.$counter]:0;
                    $d1[$i]['PEND_2_'.$counter]=isset($d1[$i]['PEND_2_'.$counter])?$d1[$i]['PEND_2_'.$counter]:0;
                    $d1[$i]['PEND_5_'.$counter]=isset($d1[$i]['PEND_5_'.$counter])?$d1[$i]['PEND_5_'.$counter]:0;
                    $d1[$i]['PEND_15_'.$counter]=isset($d1[$i]['PEND_15_'.$counter])?$d1[$i]['PEND_15_'.$counter]:0;
                    $total_pend_1=$total_pend_ten+$d1[$i]['PEND_1_'.$counter];
                    $total_pend_2=$total_pend_ten+$d1[$i]['PEND_2_'.$counter];
                    $total_pend_5=$total_pend_ten+$d1[$i]['PEND_5_'.$counter];
                    $total_pend_15=$total_pend_ten+$d1[$i]['PEND_15_'.$counter];
                    $total_rec_not_ten=$total_rec_not_ten+isset($d1[$i]['NOT_TIM_'.$counter])?$d1[$i]['NOT_TIM_'.$counter]:0;
                    if($counter>8 && $counter<21){
                      $d1[$i]['SENT_9_9_'.$counter]=isset($d1[$i]['SENT_9_9_'.$counter])?$d1[$i]['SENT_9_9_'.$counter]:0;
                        $total_sent_9_9=$total_sent_9_9+$d1[$i]['SENT_9_9_'.$counter];                    
                        $total_rec_9_9=$total_rec_9_9+$d1[$i]['REC_'.$counter];
                        $total_pend_9_9=$total_pend_9_9+$d1[$i]['PEND_'.$counter];
                        $total_tim_9_9=$total_tim_9_9+$d1[$i]['TIM_'.$counter];
                        $total_attemp_9_9=$total_attemp_9_9+$d1[$i]['ATTEMP_'.$counter];
                        $total_attemp_ten_9_9=$total_attemp_ten_9_9+$d1[$i]['ATTEMP_TEN_'.$counter];
                        $total_attemp_1_9_9=$total_attemp_1_9_9+$d1[$i]['ATTEMP_1_'.$counter];
                        $total_attemp_2_9_9=$total_attemp_2_9_9+$d1[$i]['ATTEMP_2_'.$counter];

                        $total_attemp_5_9_9=$total_attemp_5_9_9+$d1[$i]['ATTEMP_5_'.$counter];
                        $d1[$i]['ATTEMP_15_'.$counter]=isset($d1[$i]['ATTEMP_15_'.$counter])?$d1[$i]['ATTEMP_15_'.$counter]:0;
                        $total_attemp_15_9_9=$total_attemp_15_9_9+$d1[$i]['ATTEMP_15_'.$counter];

                        $d1[$i]['NOT_ATTEMP_TEN_'.$counter]=isset($d1[$i]['NOT_ATTEMP_TEN_'.$counter])?$d1[$i]['NOT_ATTEMP_TEN_'.$counter]:0;
                        $total_not_attemp_ten_9_9=$total_attemp_not_ten_9_9+$d1[$i]['NOT_ATTEMP_TEN_'.$counter];
                        $total_attemp_not_5_9_9=isset($total_attemp_not_5_9_9)?$total_attemp_not_5_9_9:0;
                        $total_attemp_not_15_9_9=isset($total_attemp_not_15_9_9)?$total_attemp_not_15_9_9:0;
                        $d1[$i]['NOT_ATTEMP_5_'.$counter]=isset($d1[$i]['NOT_ATTEMP_5_'.$counter])?$d1[$i]['NOT_ATTEMP_5_'.$counter]:0;
                        $d1[$i]['NOT_ATTEMP_15_'.$counter]=isset($d1[$i]['NOT_ATTEMP_15_'.$counter])?$d1[$i]['NOT_ATTEMP_15_'.$counter]:0;
                        $total_not_attemp_5_9_9=$total_attemp_not_5_9_9+$d1[$i]['NOT_ATTEMP_5_'.$counter];
                        $total_not_attemp_15_9_9=$total_attemp_not_15_9_9+$d1[$i]['NOT_ATTEMP_15_'.$counter];


                        $total_pend_ten_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_TEN_'.$counter];
                        $total_pend_1_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_1_'.$counter];
                        $total_pend_2_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_2_'.$counter];
                        $total_pend_5_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_5_'.$counter];
                        $total_pend_15_9_9=$total_pend_ten_9_9+$d1[$i]['PEND_15_'.$counter];
                        $d1[$i]['NOT_TIM_'.$counter]=isset($d1[$i]['NOT_TIM_'.$counter])?$d1[$i]['NOT_TIM_'.$counter]:0;
                        $total_rec_not_ten_9_9=$total_rec_not_ten_9_9+$d1[$i]['NOT_TIM_'.$counter];
                    }

                    // echo"<br> total_rec_not_ten_9_9 $total_rec_not_ten_9_9<br>";
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
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=".$counter."&totalcount=".$d1[$i][$col]."&subtype=SENT"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    }     
                       
                     if($total_sent ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_sent."&subtype=SENT"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_sent.'</a></td>';
                     }
                    if($total_sent_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9&totalcount=".$total_sent_9_9."&subtype=SENT"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_sent_9_9.'</a></td>';
                     }
                    echo '</tr>';

                    if($d1[$i]['LEAP_VENDOR_NAME'] != "BANREVIEW" ){
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
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=".$counter."&totalcount=".$d1[$i][$col]."&subtype=ATTEMP_1"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    }     
                     
                     if($total_attemp_1 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_1."&subtype=ATTEMP_1"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_1.'</a></td>';
                     }
                     if($total_attemp_1_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_1_9_9."&subtype=ATTEMP_1"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_1_9_9.'</a></td>';
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
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=ATTEMP_2"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    }                    
                     if($total_attemp_2 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_2."&subtype=ATTEMP_2"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_2.'</a></td>';
                     }
                     if($total_attemp_2_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&totalcount=".$total_attemp_2_9_9."&subtype=ATTEMP_2"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_2_9_9.'</a></td>';
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

                  }
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
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     if($total_attemp_5 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_5."&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_5.'</a></td>';
                     }
                     if($total_attemp_5_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_5_9_9.'</a></td>';
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

                    if($d1[$i]['LEAP_VENDOR_NAME'] == "BANREVIEW" && $rtype=='P' ){
                     //start 

                     echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Not Attempted In 5 Min</td>';
                     for($counter=0;$counter<24;$counter++){
                          $col='NOT_ATTEMP_5_'.$counter;
                          if($d1[$i][$col] ==0)
                          {
                            echo '<td class="c">0</td>';
                          }
                          else
                          {
                           echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=NOT_ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                          }
                      } 
                       
                        if($total_attemp_not_5 ==0)
                       {
                         echo '<td class="c">0</td>';
                       }
                       else
                       {
                        echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_not_15."&subtype=NOT_ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_5.'</a></td>';
                       }
                       if($total_attemp_not_5_9_9 ==0)
                       {
                         echo '<td class="c">0</td>';
                       }
                       else
                       {
                        echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&totalcount=".$total_attemp_not_5_9_9."&subtype=NOT_ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_5_9_9.'</a></td>';
                       }
                      echo '</tr>';  
 
                     //end
                      }

                      

                       echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted In 10 Min</td>';
                    for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_TEN_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     if($total_attemp_ten ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_ten."&subtype=ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_ten.'</a></td>';
                     }
                     if($total_attemp_ten_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&totalcount=".$total_attemp_ten_9_9."&subtype=ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_ten_9_9.'</a></td>';
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
                        if(isset($d1[$i][$col])){
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=NOT_ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                      }
                    } 
                     
                      if($total_attemp_not_ten ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_not_ten."&subtype=NOT_ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_ten.'</a></td>';
                     }
                     if($total_attemp_not_ten_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&totalcount=".$total_attemp_not_ten_9_9."&subtype=NOT_ATTEMP_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_ten_9_9.'</a></td>';
                     }
                    echo '</tr>';  
                     //end of 10

                    // 15 min
                    if($d1[$i]['LEAP_VENDOR_NAME'] == "BANREVIEW" && $rtype=='P' ){
                    echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted In 0-15 Min</td>';
                  
                    for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_15_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                          echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=ATTEMP_15"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                      if($total_attemp_15 ==0)
                      {
                        echo '<td class="c">0</td>';
                      }
                      else
                      {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_15."&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_15.'</a></td>';
                      }
                      if($total_attemp_15_9_9 ==0)
                      {
                        echo '<td class="c">0</td>';
                      }
                      else
                      {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&subtype=ATTEMP_5"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_15_9_9.'</a></td>';
                      }
                      echo '<tr bgcolor="#c0fcfe"><td align="left" style="font-size:12px;padding:2px 4px;"><font >Attempted % In 15 Min</font></td>';
                        for($counter=0;$counter<24;$counter++){
                        $col1='ATTEMP_15_'.$counter;
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
                      echo '<td class="c"><font >'.number_format($total_attemp_15/$total_sent * 100, 2 ).'</font></td><td class="c"><font >'.number_format($total_attemp_15_9_9/$total_sent_9_9 * 100, 2 ).'</font></td></tr>'; 
                  
                    // end 15 min 

                    //start 

                    echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Not Attempted In 15 Min</td>';
                    for($counter=0;$counter<24;$counter++){
                         $col='NOT_ATTEMP_15_'.$counter;
                         if($d1[$i][$col] ==0)
                         {
                           echo '<td class="c">0</td>';
                         }
                         else
                         {
                          echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=NOT_ATTEMP_15"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                         }
                     } 
                      
                       if($total_attemp_not_15 ==0)
                      {
                        echo '<td class="c">0</td>';
                      }
                      else
                      {
                       echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_attemp_not_15."&subtype=NOT_ATTEMP_15"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_15.'</a></td>';
                      }
                      if($total_attemp_not_15_9_9 ==0)
                      {
                        echo '<td class="c">0</td>';
                      }
                      else
                      {
                       echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&totalcount=".$total_attemp_not_15_9_9."&subtype=NOT_ATTEMP_15"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_not_15_9_9.'</a></td>';
                      }
                     echo '</tr>';  

                    //end
                    }
                     echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Attempted Till Now</td>';
                    
                    for($counter=0;$counter<24;$counter++){
                        $col='ATTEMP_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=ATTEMP"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     
                     if($total_attemp ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&subtype=ATTEMP"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp.'</a></td>';
                     }
                    if($total_attemp_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&totalcount=".$total_attemp_9_9."&subtype=ATTEMP"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_attemp_9_9.'</a></td>';
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
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=PEND"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                    
                     if($total_pend ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_pend."&subtype=PEND"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_pend.'</a></td>';
                     }   
                     if($total_pend_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT_9_9&totalcount=".$total_pend_9_9."&subtype=PEND"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_pend_9_9.'</a></td>';
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

                    //start 
                    if($d1[$i]['LEAP_VENDOR_NAME'] != "BANREVIEW"){
                     echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Response Received In 10 Min</td>';
                     
                     
                   for($counter=0;$counter<24;$counter++){
                        $col='TIM_'.$counter;
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                    } 
                     
                    if($total_tim ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_tim."&subtype=REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_tim.'</a></td>';
                     } 
                     if($total_tim_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_tim_9_9."&subtype=REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_tim_9_9.'</a></td>';
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
                    }if($total_attemp==0 && $total_attemp_9_9==0){
                      echo '<td class="c">'.number_format(0).'</td><td class="c">'.number_format(0).'</td></tr>';
                    }
                    else if($total_attemp!=0 && $total_attemp_9_9==0){
                      echo '<td class="c">'.number_format($total_tim/$total_attemp * 100, 2 ).'</td><td class="c">'.number_format(0).'</td></tr>';
                    }
                    else if($total_attemp==0 && $total_attemp_9_9!=0){
                      echo '<td class="c">'.number_format(0).'</td><td class="c">'.number_format($total_tim_9_9/$total_attemp_9_9 * 100, 2 ).'</td></tr>';    
                    }
                    else{
                    echo '<td class="c">'.number_format($total_tim/$total_attemp * 100, 2 ).'</td><td class="c">'.number_format($total_tim_9_9/$total_attemp_9_9 * 100, 2 ).'</td></tr>';
                    }
                      echo '<tr><td align="left" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">Response Not Received In 10 Min</td>';
                      
                    for($counter=0;$counter<24;$counter++){
                        $col='NOT_TIM_'.$counter;
                        if(isset($d1[$i][$col])){
                        if($d1[$i][$col] ==0)
                        {
                          echo '<td class="c">0</td>';
                        }
                        else
                        {
                         echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=$counter&totalcount=".$d1[$i][$col]."&subtype=NOT_REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$d1[$i][$col].'</a></td>';
                        }
                      }
                    } 
                      
                     if($total_rec_not_ten ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_rec_not_ten."&subtype=NOT_REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_rec_not_ten.'</a></td>';
                     } 
                     if($total_rec_not_ten_9_9 ==0)
                     {
                       echo '<td class="c">0</td>';
                     }
                     else
                     {
                      echo '<td class="c"><a href="javascript:void(0);" style="text-decoration:none;" onclick="window.open('."'"."/index.php?r=admin_eto/AdminEto/pendingdata&emp=1&start_date=".$start_date."&vendor=".$d1[$i]['LEAP_VENDOR_NAME']."&rtype=Detail&mid=".$mid."&prtype=".$prtype."&aov=".$aov."&HR=TOT&totalcount=".$total_rec_not_ten_9_9."&subtype=NOT_REC_TEN"."', '".'_blank'."', '"."location=yes,height=970,width=1150,scrollbars=yes,status=yes'".');">'.$total_rec_not_ten_9_9.'</a></td>';
                     }  

                     //end 
                    }
               echo '</tr><tr><td colspan="27" bgcolor="#FFFFFF"></td></tr>';  
            }
            echo '</table>';
}
elseif($rtype == 'S')
    {   

$bl_gen_must_call=isset($genData_bl['GEN_MUST_CALL_COUNT'])?$genData_bl['GEN_MUST_CALL_COUNT']:0;

$bl_gen_dnc_in=isset($genData_bl['GEN_DNC_COUNT'])?$genData_bl['GEN_DNC_COUNT']:0;
$bl_gen_dnc_fr=isset($genData_bl['GEN_FOREIGN_COUNT'])?$genData_bl['GEN_FOREIGN_COUNT']:0;
$bl_gen_intent=isset($genData_bl['GEN_INTENT_COUNT'])?$genData_bl['GEN_INTENT_COUNT']:0;
$bl_gen=$bl_gen_must_call+$bl_gen_dnc_in+$bl_gen_dnc_fr+$bl_gen_intent;
        
        
        
        
$user_gen_must_call=isset($genData_user['GEN_MUST_CALL_COUNT'])?$genData_user['GEN_MUST_CALL_COUNT']:0;

$user_gen_dnc_in=isset($genData_user['GEN_DNC_COUNT'])?$genData_user['GEN_DNC_COUNT']:0;
$user_gen_dnc_fr=isset($genData_user['GEN_FOREIGN_COUNT'])?$genData_user['GEN_FOREIGN_COUNT']:0;
$user_gen_intent=isset($genData_user['GEN_INTENT_COUNT'])?$genData_user['GEN_INTENT_COUNT']:0;
$user_gen=$user_gen_must_call+$user_gen_dnc_in+$user_gen_dnc_fr+$user_gen_intent;

$bl_app_must_call=isset($appData_bl['APP_MUST_CALL_COUNT'])?$appData_bl['APP_MUST_CALL_COUNT']:0;

$bl_app_dnc_in=isset($appData_bl['APP_DNC_COUNT'])?$appData_bl['APP_DNC_COUNT']:0;
$bl_app_dnc_fr=isset($appData_bl['APP_FOREIGN_COUNT'])?$appData_bl['APP_FOREIGN_COUNT']:0;
$bl_app_intent=isset($appData_bl['APP_INTENT_COUNT'])?$appData_bl['APP_INTENT_COUNT']:0;
$bl_app=$bl_app_must_call+$bl_app_dnc_in+$bl_app_dnc_fr+$bl_app_intent;

$user_app_must_call=isset($appData_user['APP_MUST_CALL_COUNT'])?$appData_user['APP_MUST_CALL_COUNT']:0;
$user_app_dnc_in=isset($appData_user['APP_DNC_COUNT'])?$appData_user['APP_DNC_COUNT']:0;
$user_app_dnc_fr=isset($appData_user['APP_FOREIGN_COUNT'])?$appData_user['APP_FOREIGN_COUNT']:0;
$user_app_intent=isset($appData_user['APP_INTENT_COUNT'])?$appData_user['APP_INTENT_COUNT']:0;
$user_app=$user_app_must_call+$user_app_dnc_in+$user_app_dnc_fr+$user_app_intent;      

     
        
echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
<td colspan="5" align="center" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Generation</td>
<td colspan="5" align="center" bgcolor="#d6cff4" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Approval</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;"></td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">TOTAL</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC-India</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC-Foriegn</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">INTENT</td>

<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">TOTAL</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">MUST CALL</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC-INDIA</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC-FORIEGN</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">INTENT</td>
</tr>




<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">Buy Leads</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_gen_intent.'</td>
   
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$bl_app_intent.'</td>
  
</tr>

<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">Unique Users</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_gen_intent.'</td>
   
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;">'.$user_app_intent.'</td>   
</tr>
</table>  
</br></br>';
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
            $tot_must_10=$genDataSth['MUST_CALL_CNT10'];
            $tot_must_11=$genDataSth['MUST_CALL_CNT11'];
            $tot_must_12=$genDataSth['MUST_CALL_CNT12'];
            $tot_must_13=$genDataSth['MUST_CALL_CNT13'];
            $tot_must_14=$genDataSth['MUST_CALL_CNT14'];
            $tot_must_15=$genDataSth['MUST_CALL_CNT15'] ;
            $tot_must_16=$genDataSth['MUST_CALL_CNT16'] ;
            $tot_must_17=$genDataSth['MUST_CALL_CNT17'] ;
            $tot_must_18=$genDataSth['MUST_CALL_CNT18'] ;
            $tot_must_19=$genDataSth['MUST_CALL_CNT19'] ;
            $tot_must_20=$genDataSth['MUST_CALL_CNT20'];
            $tot_must_21=$genDataSth['MUST_CALL_CNT21'];
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">TOTAL MUST CALL</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_10.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_11.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_12.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_13.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_14.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_15.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_16.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_17.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_18.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_19.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_20.'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$tot_must_21.'</td>';
            $total_must_call_tot=$tot_must_10+$tot_must_11+$tot_must_12+$tot_must_13+$tot_must_14+$tot_must_15+$tot_must_16+$tot_must_17+$tot_must_18+$tot_must_19+$tot_must_20+$tot_must_21;
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$total_must_call_tot.'</td>'; 
            echo '</tr>';
            
       //  MUST CALL count
             echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">MUST CALL</td>';
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
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Total DNC</td>';
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
       
       // Total DNC india count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">DNC India</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT20'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_IN_CNT21'].'</td>'; 
            $total_dnc_in=$genDataSth['DNC_CALL_IN_CNT10'] + $genDataSth['DNC_CALL_IN_CNT11'] + $genDataSth['DNC_CALL_IN_CNT12'] + $genDataSth['DNC_CALL_IN_CNT13'] + $genDataSth['DNC_CALL_IN_CNT14'] +  $genDataSth['DNC_CALL_IN_CNT15'] + $genDataSth['DNC_CALL_IN_CNT16'] + $genDataSth['DNC_CALL_IN_CNT17'] + $genDataSth['DNC_CALL_IN_CNT18'] + $genDataSth['DNC_CALL_IN_CNT19'] + $genDataSth['DNC_CALL_IN_CNT20'] + $genDataSth['DNC_CALL_IN_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_dnc_in.'</td>'; 
       echo '</tr>';
       // Total DNC Foriegn count
            echo '<tr> <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">DNC Foreign</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT10'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT11'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT12'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT13'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT14'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT15'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT16'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT17'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT18'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT19'].'</td>';
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT20'].'</td>'; 
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$genDataSth['DNC_CALL_FR_CNT21'].'</td>'; 
            $total_dnc_fr=$genDataSth['DNC_CALL_FR_CNT10'] + $genDataSth['DNC_CALL_FR_CNT11'] + $genDataSth['DNC_CALL_FR_CNT12'] + $genDataSth['DNC_CALL_FR_CNT13'] + $genDataSth['DNC_CALL_FR_CNT14'] +  $genDataSth['DNC_CALL_FR_CNT15'] + $genDataSth['DNC_CALL_FR_CNT16'] + $genDataSth['DNC_CALL_FR_CNT17'] + $genDataSth['DNC_CALL_FR_CNT18'] + $genDataSth['DNC_CALL_FR_CNT19'] + $genDataSth['DNC_CALL_FR_CNT20'] + $genDataSth['DNC_CALL_FR_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_dnc_fr.'</td>'; 
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
            $total_intent=$genDataSth['INTENT_CALL_CNT10'] + $genDataSth['INTENT_CALL_CNT11'] + $genDataSth['INTENT_CALL_CNT12'] + $genDataSth['INTENT_CALL_CNT13'] + $genDataSth['INTENT_CALL_CNT14'] +  $genDataSth['INTENT_CALL_CNT15'] + $genDataSth['INTENT_CALL_CNT16'] + $genDataSth['INTENT_CALL_CNT17'] + $genDataSth['INTENT_CALL_CNT18'] + $genDataSth['INTENT_CALL_CNT19'] + $genDataSth['INTENT_CALL_CNT20'] + $genDataSth['INTENT_CALL_CNT21'];
            echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'. $total_intent.'</td>'; 
       echo '</tr>';
       
 
       
        echo '<tr> <td colspan="15" bgcolor="#FFFFFF" style="height:10px"></td></tr>';
        }
        ///////////////pending
        
     if($genDataSth['ENQ_CNT10']==0){
     $ENQ_APPROVED15_CNT10=0;
     }
     else{
      $ENQ_APPROVED15_CNT10=round(($genDataSth['ENQ_APPROVED15_CNT10']+ $deletedEnquiry['ENQ_DELETED15_CNT10'])*100/$genDataSth['ENQ_CNT10'],2);
     }
     if($genDataSth['ENQ_CNT11']==0){
      $ENQ_APPROVED15_CNT11=0;
     } 
     else{
      $ENQ_APPROVED15_CNT11=round(($genDataSth['ENQ_APPROVED15_CNT11']+ $deletedEnquiry['ENQ_DELETED15_CNT11'])*100/$genDataSth['ENQ_CNT11'],2);
     }
     if($genDataSth['ENQ_CNT12']==0){
      $ENQ_APPROVED15_CNT12=0;
         } 
         else{
          $ENQ_APPROVED15_CNT12=round(($genDataSth['ENQ_APPROVED15_CNT12']+ $deletedEnquiry['ENQ_DELETED15_CNT12'])*100/$genDataSth['ENQ_CNT12'],2);
         }
     if($genDataSth['ENQ_CNT13']==0){
      $ENQ_APPROVED15_CNT13=0;     }
      else{
        $ENQ_APPROVED15_CNT13=round(($genDataSth['ENQ_APPROVED15_CNT13']+ $deletedEnquiry['ENQ_DELETED15_CNT13'])*100/$genDataSth['ENQ_CNT13'],2);
       }
     if($genDataSth['ENQ_CNT14']==0){
      $ENQ_APPROVED15_CNT14=0;     }
      else{
        $ENQ_APPROVED15_CNT14=round(($genDataSth['ENQ_APPROVED15_CNT14']+ $deletedEnquiry['ENQ_DELETED15_CNT14'])*100/$genDataSth['ENQ_CNT14'],2);
       }
     if($genDataSth['ENQ_CNT15']==0){
      $ENQ_APPROVED15_CNT15=0;     }
      else{
        $ENQ_APPROVED15_CNT15=round(($genDataSth['ENQ_APPROVED15_CNT15']+ $deletedEnquiry['ENQ_DELETED15_CNT15'])*100/$genDataSth['ENQ_CNT15'],2);
       }
     if($genDataSth['ENQ_CNT16']==0){
      $ENQ_APPROVED15_CNT16=0;     }
      else{
        $ENQ_APPROVED15_CNT16=round(($genDataSth['ENQ_APPROVED15_CNT16']+ $deletedEnquiry['ENQ_DELETED15_CNT16'])*100/$genDataSth['ENQ_CNT16'],2);
       }
     if($genDataSth['ENQ_CNT17']==0){
      $ENQ_APPROVED15_CNT17=0;     }
      else{
        $ENQ_APPROVED15_CNT17=round(($genDataSth['ENQ_APPROVED15_CNT17']+ $deletedEnquiry['ENQ_DELETED15_CNT17'])*100/$genDataSth['ENQ_CNT17'],2);
       }
     if($genDataSth['ENQ_CNT18']==0){
      $ENQ_APPROVED15_CNT18=0;     }
      else{
        $ENQ_APPROVED15_CNT18=round(($genDataSth['ENQ_APPROVED15_CNT18']+ $deletedEnquiry['ENQ_DELETED15_CNT18'])*100/$genDataSth['ENQ_CNT18'],2);
       }
     if($genDataSth['ENQ_CNT19']==0){
      $ENQ_APPROVED15_CNT19=0;     }
      else{
        $ENQ_APPROVED15_CNT19=round(($genDataSth['ENQ_APPROVED15_CNT10']+ $deletedEnquiry['ENQ_DELETED15_CNT10'])*100/$genDataSth['ENQ_CNT10'],2);
       }
     if($genDataSth['ENQ_CNT20']==0){
      $ENQ_APPROVED15_CNT20=0;     }
      else{
        $ENQ_APPROVED15_CNT20=round(($genDataSth['ENQ_APPROVED15_CNT20']+ $deletedEnquiry['ENQ_DELETED15_CNT20'])*100/$genDataSth['ENQ_CNT20'],2);
       }
     if($genDataSth['ENQ_CNT21']==0){
      $ENQ_APPROVED15_CNT21=0;     }
      else{
        $ENQ_APPROVED15_CNT21=round(($genDataSth['ENQ_APPROVED15_CNT21']+ $deletedEnquiry['ENQ_DELETED15_CNT21'])*100/$genDataSth['ENQ_CNT21'],2);
       }
    
          echo '<tr>
                <td bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545">Timliness</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT10.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT11.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT12.'%</td>';         
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT13.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT14.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT15.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT16.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT17.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT18.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT19.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT20.'%</td>';
           echo '<td align="center" bgcolor="#FFFFFF" style="font-size:12px;padding:2px 4px;">'.$ENQ_APPROVED15_CNT21.'%</td>';
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
         if($genDataSth['ENQ_CNT10']!=0){
         $display_per_10=round(($flagged['ENQ_DISPLAY_CNT10'])*100/$genDataSth['ENQ_CNT10'],2);
         }
         else{
          $display_per_10=0;
         }
         if($genDataSth['ENQ_CNT11']!=0){
          $display_per_11=round(($flagged['ENQ_DISPLAY_CNT11'])*100/$genDataSth['ENQ_CNT11'],2);
          }
          else{
           $display_per_11=0;
          }
      if($genDataSth['ENQ_CNT12']!=0){
            $display_per_12=round(($flagged['ENQ_DISPLAY_CNT12'])*100/$genDataSth['ENQ_CNT12'],2);
            }
            else{
             $display_per_12=0;
            }
            if($genDataSth['ENQ_CNT13']!=0){
         $display_per_13=round(($flagged['ENQ_DISPLAY_CNT13'])*100/$genDataSth['ENQ_CNT13'],2);
         }
         else{
          $display_per_13=0;
         }
         if($genDataSth['ENQ_CNT14']!=0){
          $display_per_14=round(($flagged['ENQ_DISPLAY_CNT14'])*100/$genDataSth['ENQ_CNT14'],2);
          }
          else{
           $display_per_14=0;
          }
          if($genDataSth['ENQ_CNT15']!=0){
            $display_per_15=round(($flagged['ENQ_DISPLAY_CNT15'])*100/$genDataSth['ENQ_CNT15'],2);
            }
            else{
             $display_per_15=0;
            }
            if($genDataSth['ENQ_CNT16']!=0){
              $display_per_16=round(($flagged['ENQ_DISPLAY_CNT16'])*100/$genDataSth['ENQ_CNT16'],2);
              }
              else{
               $display_per_16=0;
              }
          if($genDataSth['ENQ_CNT17']!=0){
            $display_per_17=round(($flagged['ENQ_DISPLAY_CNT17'])*100/$genDataSth['ENQ_CNT17'],2);
            }
            else{
             $display_per_17=0;
            }
            if($genDataSth['ENQ_CNT18']!=0){
              $display_per_18=round(($flagged['ENQ_DISPLAY_CNT18'])*100/$genDataSth['ENQ_CNT18'],2);
              }
              else{
               $display_per_18=0;
              }
              if($genDataSth['ENQ_CNT19']!=0){
                $display_per_19=round(($flagged['ENQ_DISPLAY_CNT19'])*100/$genDataSth['ENQ_CNT19'],2);
                }
                else{
                 $display_per_19=0;
                }
                if($genDataSth['ENQ_CNT20']!=0){
                  $display_per_20=round(($flagged['ENQ_DISPLAY_CNT20'])*100/$genDataSth['ENQ_CNT20'],2);
                  }
                  else{
                   $display_per_20=0;
                  }
                  if($genDataSth['ENQ_CNT21']!=0){
                    $display_per_21=round(($flagged['ENQ_DISPLAY_CNT21'])*100/$genDataSth['ENQ_CNT21'],2);
                    }
                    else{
                     $display_per_21=0;
                    }
    
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
echo $redis->HGET('LLEN','LEAP_CALL_USER');
echo 'h';
exit;

$date_time = strtoupper(date("d M Y H:i:s"));
$redis_CALL_TOT = $redis->LLEN('LEAP_CALL_USER');     
$redis_CON_FLAG = $redis->LLEN('LEAP_CALL_USER_FLAG');
$redis_data_mustcall = $redis->LLEN('LEAP_MUST_CALL');
$redis_data_mustcall_flag =$redis->LLEN('LEAP_MUST_CALL_FLAGGED');
$redis_data_dnccal = $redis->LLEN('LEAP_DO_NOT_CALL');
$redis_data_foreign = $redis->LLEN('LEAP_FOREIGN');

$redis_data_intentpool =$redis->LLEN('LEAP_INTENT');
$redis_data_intentpool_flag = $redis->LLEN('LEAP_INTENT_FLAGGED');
//test
$redis_vkalp_india=$redis->LLEN('LEAP_DO_NOT_CALL');
$redis_kocher_dnc=$redis->LLEN('LEAP_DO_NOT_CALL2');
$redis_vkalp_auto_ind=$redis->LLEN('LEAP_AUTOAPP_IND');
$redis_vkalp_auto_frn=$redis->LLEN('LEAP_FOREIGN');//$redis->LLEN('LEAP_AUTOAPP_FGN');
$redis_radiate_auto=$redis->LLEN('LEAP_AUTOAPP_IND2');
$redis_review_pool=$redis->LLEN('RP_VKALPREVIEW_QUEUE');
$redis_review_kocher=$redis->LLEN('RP_KOCHARTECHREVIEW_QUEUE');
$redis_kochar_auto=$redis->LLEN('LEAP_AUTOAPP_IND3');
$redis_comptentdnc=$redis->LLEN('LEAP_DO_NOT_CALL4');//LEAP_DO_NOT_CALL4 -> comp (CompetentDNC)
$redis_leap_connect_c2c=$redis->ZCARD('LEAP_CONNECT_C2C');

 echo '<table style="width:50%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">
  <tr>
<th colspan="7" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">DNC Center Wise Pending As On ('.$date_time.')</th>
</tr>
<tr>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Pool</td>
<td align="center"  style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">User</td> 
</tr>';
  
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='COMPETENTDNC')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">COMPETENT DNC</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_comptentdnc).'</td>
</tr>';
}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='VKALP' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='VKALPDNC' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='VKALPAUTOFRN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='VKALPAUTOIND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='VKALPREVIEW')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Vkalp-India</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_vkalp_india).'</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Vkalp- AutoIND</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_vkalp_auto_ind).'</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Vkalp- AutoFRN</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_vkalp_auto_frn).'</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">VKALP Review</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_review_pool).'</td>
</tr>
<tr>';
}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECHAUTO' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECHCHN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECHDNC' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECHINTENT' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='KOCHARTECHREVIEW')
{
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">KOCHARTECHAUTO</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_kochar_auto).'</td>
</tr>

<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">KOCHARTECH Review</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_review_kocher).'</td>
</tr>
<tr><td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">KOCHARTECH DNC</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_kocher_dnc).'</td>
</tr>
';
}
if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='RADIATE' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']== 'RADIATEDNC'|| $arr_lvl_code['ETO_LEAP_VENDOR_NAME']== 'RADIATEFRN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']== 'RADIATEINTENT'|| $arr_lvl_code['ETO_LEAP_VENDOR_NAME']== 'RADIATEPNSMRK' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']== 'RADIATEAUTO')
{
echo '
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Radiate-Foreign</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">0</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Radiate-Auto</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_radiate_auto).'</td>
</tr>';
}

if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='CONNECT_C2C')
{
echo '
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Connect c2c</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_leap_connect_c2c).'</td>
</tr>';
}

if($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN'){
echo '<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">TOTAL</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($redis_leap_connect_c2c + $redis_vkalp_india + $redis_vkalp_auto_ind + $redis_vkalp_auto_frn + $redis_kochar_auto +  $redis_radiate_auto + $redis_review_pool + $redis_review_kocher + $redis_kochar_auto + $redis_comptentdnc).'</td>
</tr>';
}



echo '</table><br><br>';   
}
elseif($rtype == 'R') {
    $pendnw=$pendhtml=$genhtml=$app='';
    $gen=isset($data['GEN'])?$data['GEN']:'';
    $pend=isset($data['PEND'])?$data['PEND']:'';
    $ins=isset($data['INS'])?$data['INS']:'';
   $pendhtml = '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center">'
    . '<tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Pendency (Working Hour wise)&nbsp;&nbsp; &nbsp; Report Generation Date: '. date('d-M-Y H:i:s').'</td></tr>
            ';
if(isset($_REQUEST['prtype']) && ($_REQUEST['prtype'] =='PEND')){ 
    $pendnw = '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center">'
    . '<tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Pendency (Non Working Hour wise)</td></tr>
            ';
    
        foreach($pend as $key => $row){
            $total=$totalnw=0;
            $pendhtml .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>'; 
            $pendnw .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>'; 
            for($i=0;$i<24;$i++){ 
                if($i>8 && $i<21){
                        if(isset($row[$i])){
                            $pendhtml .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                            if(is_numeric($row[$i])){
                                $total=$total+$row[$i];
                            }                    
                        }else{
                            $pendhtml .= '<td class="t" align="center" width="6%">0</td>';
                        }
                }else{
                        if(isset($row[$i])){
                            $pendnw .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                            if(is_numeric($row[$i])){
                                $totalnw=$totalnw+$row[$i];
                            }                    
                        }else{
                            $pendnw .= '<td class="t" align="center" width="6%">0</td>';
                        } 
                }
                
            }
            if($key=='Hour'){
                $totalnw=$total='Total';
            }
             $pendhtml .= '<td class="headt" align="center">'.$total.'</td></tr>';
             $pendnw .= '<td class="headt" align="center">'.$totalnw.'</td></tr>';
        }
       $pendhtml .= '</table><br/>';      
       $pendnw .= '</table><br/>';      
       echo $pendhtml;
       echo $pendnw;
}  

        
        
       
if(isset($_REQUEST['prtype']) && ($_REQUEST['prtype'] =='GEN')){  
    $genhtml=$genhtmlnw='';
    foreach($gen as $key => $row){
            $totalnw=$total=0;   
                $key = preg_replace('/ENQ-/', ' -- ', $key);
                $key = preg_replace('/USER-/', ' -- ', $key);
                $key = preg_replace('/_/', ' ', $key);
                $key=ucwords(strtolower($key));
                $genhtml .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>'; 
                $genhtmlnw .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>'; 
                for($i=0;$i<24;$i++){
                    if($i>8 && $i<21){
                        if(isset($row[$i])){
                            $genhtml .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                            if(is_numeric($row[$i])){
                                $total=$total+$row[$i];
                            }                    
                        }else{
                            $genhtml .= '<td class="t" align="center" width="6%">0</td>';
                        } 
                    }else{
                        if(isset($row[$i])){
                            $genhtmlnw .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                            if(is_numeric($row[$i])){
                                $totalnw=$totalnw+$row[$i];
                            }                    
                        }else{
                            $genhtmlnw .= '<td class="t" align="center" width="6%">0</td>';
                        } 
                    }                
                }
                 if($key=='Hour'){
                    $total=$totalnw='Total';
                    }
                    $genhtml .= '<td class="headt" align="center">'.$total.'</td></tr>';
                    $genhtmlnw .= '<td class="headt" align="center">'.$totalnw.'</td></tr>';
                        
        }
         $genhtml= '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center"><tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Generation (Working Hour wise)</td></tr>'.$genhtml.'</table><br/>';
        $genhtmlnw= '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center"><tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Generation (Non Working Hour wise)</td></tr>'.$genhtmlnw.'</table><br/>';
       
       echo $genhtml.$genhtmlnw;
}
if(isset($_REQUEST['prtype']) && ($_REQUEST['prtype'] =='APP')){ 
    $appnw=$app='';
    foreach($gen as $key => $row){
            $totalnw=$total=0;  
                $key = preg_replace('/APPROVED/', '', $key);  
                $app .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>';
                $appnw .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>';
                for($i=0;$i<24;$i++){
                    if($i>8 && $i<21){
                        if(isset($row[$i])){
                        $app .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                        if(is_numeric($row[$i])){
                            $total=$total+$row[$i];
                        }                    
                        }else{
                            if($key=='Hour'){
                                $app .= '<td class="t" align="center" width="6%">'.$i.'-'.($i+1).'</td>';
                            }else{
                                $app .= '<td class="t" align="center" width="6%">0</td>';
                            }
                            
                        } 
                    }else{
                        if(isset($row[$i])){
                        $appnw .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                        if(is_numeric($row[$i])){
                            $totalnw=$totalnw+$row[$i];
                        }                    
                        }else{
                            if($key=='Hour'){
                                $appnw .= '<td class="t" align="center" width="6%">'.$i.'-'.($i+1).'</td>';
                            }else{
                                $appnw .= '<td class="t" align="center" width="6%">0</td>';
                            }
                        } 
                    }                
                }                
                if($key=='Hour'){
                    $totalnw=$total='Total';
                }
                $app .= '<td class="headt" align="center">'.$total.'</td></tr>';
                $appnw .= '<td class="headt" align="center">'.$totalnw.'</td></tr>';
            }                 
                       
        
     $app= '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center"><tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Approvals (Working Hour wise)</td></tr>'.$app.'</table><br/>';
     $appnw= '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center"><tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Approvals (Non Working Hour wise)</td></tr>'.$appnw.'</table><br/>';

       echo $app.$appnw;
}       
 if(isset($_REQUEST['prtype']) && ($_REQUEST['prtype'] =='INS')){      
   $insw = '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center">'
    . '<tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Insertion (Working Hour wise)</td></tr>
            ';   
    $insnw = '<table width="90%" cellspacing="2" cellpadding="2" bordercolor="#c6def1" border="1" bgcolor="#ededed" align="center">'
    . '<tr><td colspan="14" style="font-size:17px;font-weight:bold;color:#000099;background:#e3eff8;">Insertion (Non Working Hour wise)</td></tr>
            ';
   // echo '<pre>';
    //print_r($ins);echo '</pre>';
        foreach($ins as $key => $row){
            $total=$totalnw=0;
            $insw .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>'; 
            $insnw .= '<tr><td class="headt" align="left" width="12%">'.$key.'</td>'; 
            for($i=0;$i<24;$i++){ 
                if($i>8 && $i<21){
                        if(isset($row[$i])){
                            $insw .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                            if(is_numeric($row[$i])){
                                $total=$total+$row[$i];
                            }                    
                        }else{
                            $insw .= '<td class="t" align="center" width="6%">0</td>';
                        }
                }else{
                        if(isset($row[$i])){
                            $insnw .= '<td class="t" align="center" width="6%">'.$row[$i].'</td>';
                            if(is_numeric($row[$i])){
                                $totalnw=$totalnw+$row[$i];
                            }                    
                        }else{
                            $insnw .= '<td class="t" align="center" width="6%">0</td>';
                        } 
                }
                
            }
             if($key=='HR'){
                    $total=$totalnw='Total';
                    }
             $insw .= '<td class="headt" align="center">'.$total.'</td></tr>';
             $insnw .= '<td class="headt" align="center">'.$totalnw.'</td></tr>';
        }
       $insw .= '</table><br/>';      
       $insnw .= '</table><br/>';      
       echo $insw;
       echo $insnw;
 }
}
}
  ?>
        </body></html>