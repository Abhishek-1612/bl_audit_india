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
<script type="text/javascript">
$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="S"){          
           $('#td_pool').hide();
           $('#drp_pool').hide();
           $('#pr_pool').hide();
           $('#pr_checkbox').hide();
        }
        if($(this).attr("value")=="D"){
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
    }
    
    if($(this).attr("value")=="COGENT" || $(this).attr("value")=="COGENTINTENT" || $(this).attr("value")=="KOCHARTECH" || $(this).attr("value")=="VKALP"){
    
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
$arrvendorVal=explode(',',$vendorVal);
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));
$sel_pool= Yii::app()->request->getParam('drp_pool','All');
$prtype=isset($_REQUEST['prtype']) ? $_REQUEST['prtype'] : '';
$display_pool='style="display:none;"';
$display_pr_pool='style="display:none;"';
if($rtype == 'D'){
    $display_pool='';
}
if($rtype == 'P'){
    $display_pr_pool='';
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
     <tr><td width="10%" style="font-weight: bold">Select Date:</td><td width="30%">        
<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
</td><td width="10%" style="font-weight: bold">Report Type:</td><td width="30%">    
<input type="radio" name="rtype" value="S" <?php echo ($rtype == 'S' || $rtype == '')?'checked':''; ?> >&nbsp;Manual&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                
<input type="radio" name="rtype" value="P" <?php echo ($rtype == 'P')?'CHECKED="CHECKED"':'' ?> >&nbsp;Predictive Report
</td>
<td width="20%"> <input type="submit" name="btnsubmit" id="btnsubmit" value="Generate">
</td>
</tr>
</table>   
</form><br>

<?php
$dtime= Yii::app()->request->getParam('start_date',strtoupper(date("d-M-Y"))); 
$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
$pendData_bl=$data['pendData_bl'];$pendData_user=$data['pendData_user'];
$redis_data=$data['redis_data'];

$genDataSth=$data['genData'];
$deletedEnquiry=$data['deletedEnquiry'];
$flagged=$data['flagged'];
$appData_bl=$data['appData_bl'];
$appData_user=$data['appData_user'];
$genData_bl=$data['genData_bl'];
$genData_user=$data['genData_user'];
$flagged_bl=$data['flagged_bl'];
$fresh_bl=$data['fresh_bl'];

if(isset($_REQUEST['btnsubmit']))
    { 
if($rtype == 'P'){
 
    $total_pend_record=$data['total_pend'];
    list($fresh_kohar_must,$flag_kohar_must,$fresh_VKALP_must,$flag_VKALP_must,$fresh_COGENT_must,$flag_COGENT_must,$fresh_COGENTINTENT_INTENT,$flag_COGENTINTENT_INTENT,$fresh_KOCHARTECHDNC_DNC,$flag_KOCHARTECHDNC_DNC)='';
        foreach($total_pend_record as $row){
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
                
            
        }
        
$pendData_user=$data['pendData_user'];   
$user_pen_must_call=isset($pendData_user['PENDING_MUST_CALL_USER'])?$pendData_user['PENDING_MUST_CALL_USER']:0;
$user_pen_must_call_service=isset($pendData_user['PENDING_SERVICE_USER'])?$pendData_user['PENDING_SERVICE_USER']: 0;
$user_pen_dnc_in=isset($pendData_user['PENDING_DNC_USER'])?$pendData_user['PENDING_DNC_USER']:0;
$user_pen_dnc_fr= isset($pendData_user['PENDING_FOREIGN_USER'])?$pendData_user['PENDING_FOREIGN_USER']: 0;
$user_pen_intent=isset($pendData_user['PENDING_INTENT_USER'])?$pendData_user['PENDING_INTENT_USER']: 0;
$user_pen_proc=isset($pendData_user['PENDING_PROCMART_USER'])?$pendData_user['PENDING_PROCMART_USER']: 0;

$redis_data=$data['redis_data'];
$red_pen_must_call=isset($redis_data['mustcall'])?$redis_data['mustcall']:0;
$red_pen_must_call_service=isset($redis_data['service'])?$redis_data['service']:0;
$red_pen_dnc_in=isset($redis_data['dnccal'])?$redis_data['dnccal']:0;
$red_pen_dnc_fr=isset($redis_data['foreign'])?$redis_data['foreign']:0;
$red_pen_intent=isset($redis_data['intentpool'])?$redis_data['intentpool']:0;
$red_pen_proc=isset($redis_data['procmartpool'])?$redis_data['procmartpool']:0;     
        
        echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<td align="center" rowspan="2" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Pool</td>
<td colspan="2" align="center" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Fresh Leads</td>
<td colspan="2" align="center" bgcolor="#d6cff4" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Flagged Leads</td>
<td colspan="2" align="center" bgcolor="#e9f99f" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Workable Leads(Redis)</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($fresh_kohar_must+$fresh_VKALP_must+$fresh_COGENT_must).'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($flag_kohar_must+$flag_VKALP_must+$flag_COGENT_must).'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_must_call.'</td>
</tr>



<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Service</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call_service.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;"></td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Intent</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_COGENTINTENT_INTENT.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_COGENTINTENT_INTENT.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_must_call_service.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Indian)</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_in.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_KOCHARTECHDNC_DNC.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_KOCHARTECHDNC_DNC.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_dnc_in.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Foriegn)</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_fr.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;"></td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_dnc_fr.'</td>
</tr>

</table>  
  </br></br>';
   
   

echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<td align="center" rowspan="2" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Center</td>
<td colspan="2" align="center" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Fresh Leads</td>
<td colspan="2" align="center" bgcolor="#d6cff4" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Flagged Leads</td>
<td colspan="2" align="center" bgcolor="#e9f99f" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Workable Leads(Redis)</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Kochar Must</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_kohar_must.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_kohar_must.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_must_call.'</td>
</tr>



<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Vkalp Must</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_VKALP_must.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_VKALP_must.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_must_call.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Cogent Must</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_COGENT_must.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_COGENT_must.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_must_call.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Cogent Intent</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_COGENTINTENT_INTENT.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_COGENTINTENT_INTENT.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_intent.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">KocharDNC</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($user_pen_dnc_in+$user_pen_dnc_fr).'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_KOCHARTECHDNC_DNC.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($user_pen_dnc_in+$user_pen_dnc_fr).'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flag_KOCHARTECHDNC_DNC.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($user_pen_dnc_in+$user_pen_dnc_fr).'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.($red_pen_dnc_in+$red_pen_dnc_fr).'</td>
</tr>

</table>  
  </br></br>';   
    
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


$bl_pen_must_call=isset($pendData_bl['PENDING_MUST_CALL'])?$pendData_bl['PENDING_MUST_CALL']:0;
$bl_pen_must_call_service=isset($pendData_bl['PENDING_SERVICE'])?$pendData_bl['PENDING_SERVICE']: 0;
$bl_pen_dnc_in=isset($pendData_bl['PENDING_DNC'])?$pendData_bl['PENDING_DNC']:0;
$bl_pen_dnc_fr=isset($pendData_bl['PENDING_FOREIGN'])?$pendData_bl['PENDING_FOREIGN']: 0;
$bl_pen_intent=isset($pendData_bl['PENDING_INTENT'])?$pendData_bl['PENDING_INTENT']: 0;
$bl_pen_proc= isset($pendData_bl['PENDING_PROCMART'])?$pendData_bl['PENDING_PROCMART']: 0;
$bl_pen=$bl_pen_must_call+$bl_pen_must_call_service+$bl_pen_dnc_in+$bl_pen_dnc_fr+$bl_pen_intent+$bl_pen_proc;
        
        
        
$user_pen_must_call=isset($pendData_user['PENDING_MUST_CALL_USER'])?$pendData_user['PENDING_MUST_CALL_USER']:0;
$user_pen_must_call_service=isset($pendData_user['PENDING_SERVICE_USER'])?$pendData_user['PENDING_SERVICE_USER']: 0;
$user_pen_dnc_in=isset($pendData_user['PENDING_DNC_USER'])?$pendData_user['PENDING_DNC_USER']:0;
$user_pen_dnc_fr= isset($pendData_user['PENDING_FOREIGN_USER'])?$pendData_user['PENDING_FOREIGN_USER']: 0;
$user_pen_intent=isset($pendData_user['PENDING_INTENT_USER'])?$pendData_user['PENDING_INTENT_USER']: 0;
$user_pen_proc=isset($pendData_user['PENDING_PROCMART_USER'])?$pendData_user['PENDING_PROCMART_USER']: 0;
$user_pen=$user_pen_must_call+$user_pen_must_call_service+$user_pen_dnc_in+$user_pen_dnc_fr+$user_pen_intent+$user_pen_proc;

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

$red_pen_must_call=isset($redis_data['mustcall'])?$redis_data['mustcall']:0;
$red_pen_must_call_service=isset($redis_data['service'])?$redis_data['service']:0;
$red_pen_dnc_in=isset($redis_data['dnccal'])?$redis_data['dnccal']:0;
$red_pen_dnc_fr=isset($redis_data['foreign'])?$redis_data['foreign']:0;
$red_pen_intent=isset($redis_data['intentpool'])?$redis_data['intentpool']:0;
$red_pen_proc=isset($redis_data['procmartpool'])?$redis_data['procmartpool']:0;
$red=$red_pen_must_call+$red_pen_must_call_service+$red_pen_dnc_in+$red_pen_dnc_fr+$red_pen_intent+$red_pen_proc;  

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
    

$flagged_pen_must_call='';
$flagged_pen_must_call_service='';
$flagged_pen_dnc_in='';
$flagged_pen_dnc_fr='';
$flagged_pen_intent='';
$flagged_pen_proc='';
$flagged_cnt='';


$flagged_pen_must_call=isset($flagged_bl['PENDING_MUST_CALL_USER'])?$flagged_bl['PENDING_MUST_CALL_USER']: 0;
$flagged_pen_must_call_service=isset($flagged_bl['PENDING_SERVICE_USER'])?$flagged_bl['PENDING_SERVICE_USER']: 0;
$flagged_pen_dnc_in=isset($flagged_bl['PENDING_DNC_USER'])?$flagged_bl['PENDING_DNC_USER']: 0;
$flagged_pen_dnc_fr=isset($flagged_bl['PENDING_FOREIGN_USER'])?$flagged_bl['PENDING_FOREIGN_USER']: 0;
$flagged_pen_intent=isset($flagged_bl['PENDING_INTENT_USER'])?$flagged_bl['PENDING_INTENT_USER']: 0;
$flagged_pen_proc=isset($flagged_bl['PENDING_PROCMART_USER'])?$flagged_bl['PENDING_PROCMART_USER']: 0;

$flagged_cnt=$flagged_pen_must_call+$flagged_pen_must_call_service+$flagged_pen_dnc_in+$flagged_pen_dnc_fr+$flagged_pen_intent+$flagged_pen_proc;

$fresh_pen_must_call=isset($fresh_bl['PENDING_MUST_CALL_USER'])?$fresh_bl['PENDING_MUST_CALL_USER']: 0;
$fresh_pen_must_call_service=isset($fresh_bl['PENDING_SERVICE_USER'])?$fresh_bl['PENDING_SERVICE_USER']: 0;
$fresh_pen_dnc_in=isset($fresh_bl['PENDING_DNC_USER'])?$fresh_bl['PENDING_DNC_USER']: 0;
$fresh_pen_dnc_fr=isset($fresh_bl['PENDING_FOREIGN_USER'])?$fresh_bl['PENDING_FOREIGN_USER']: 0;
$fresh_pen_intent=isset($fresh_bl['PENDING_INTENT_USER'])?$fresh_bl['PENDING_INTENT_USER']: 0;
$fresh_pen_proc=isset($fresh_bl['PENDING_PROCMART_USER'])?$fresh_bl['PENDING_PROCMART_USER']: 0;


$fresh=$fresh_pen_must_call+$fresh_pen_must_call_service+$fresh_pen_dnc_in+$fresh_pen_dnc_fr+$fresh_pen_intent+$fresh_pen_proc;
     
        
echo '<table width="90%" border="1" BORDERCOLOR="#c6def1" align="center" bgcolor="#ededed" cellpadding="1" cellspacing="1">  
<tr>
<td align="center" rowspan="2" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Pool</td>
<td colspan="2" align="center" bgcolor="#c0fcfe" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Fresh Leads</td>
<td colspan="2" align="center" bgcolor="#d6cff4" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Flagged Leads</td>
<td colspan="2" align="center" bgcolor="#e9f99f" style="font-size:13px;padding:2px 4px;color:#454545;font-weight:bold;">Workable Leads(Redis)</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Users</td> 
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Leads</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Must Call</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flagged_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_must_call.'</td>
</tr>



<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Service</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call_service.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_pen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flagged_pen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_must_call_service.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_must_call_service.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">Intent</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flagged_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_intent.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_intent.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Indian)</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_in.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_pen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flagged_pen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_in.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_dnc_in.'</td>
</tr>

<tr>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;font-weight:bold;color:#454545;">DNC(Foriegn)</td>
<td align="center" bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_fr.'</td> 
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$fresh_pen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$flagged_pen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$user_pen_dnc_fr.'</td>
<td align="center"  bgcolor="#FFFFFF" style="font-size:13px;padding:2px 4px;color:#454545;">'.$red_pen_dnc_fr.'</td>
</tr>

</table>  
  </br></br>';

 }
}
  ?>
        </body></html>