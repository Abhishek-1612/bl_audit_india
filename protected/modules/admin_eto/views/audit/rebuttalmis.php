<?php $team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa=isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent=isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve=isset($vendor_approve) ? $vendor_approve : 'ALL';
$tabselect=isset($_REQUEST['tabselect']) ? $_REQUEST['tabselect']:3;
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
?>
<head>
<title>Buy Lead Audit CRM</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:2px;border-style:solid;border-color:#0195d3;
}
a:visited {color: red;}
a:active {color: blue;}
a:link {color: blue;}
</style>

<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<?php
if($tabselect<>1){?>
<script type="text/javascript">
</script>
<?php }
?>
<script type="text/javascript">
function resetForm() {
    document.getElementById("sampleForm").reset();
}
    $(function() {
    $('input:radio[name="stype"]').change(function() {
        if ($(this).val() == 'ADV') {
              Newfilter('<?php echo $vendor_approve ?>','<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');
                $("#trmain").show();
            }else{
                 $("#trmain").hide();                 
            }
            if ($("input[name='stype']:checked"). val()== 'DNC'){
                $("#tr_calling_del").show(); 
            }else{
                $("#tr_calling_del").hide(); 
            }
            if($("input[name='stype']:checked"). val()== 'BAN'){
                $("#tr_ban_reason").show(); 
                $("#tr_auditor").hide();
                $("#lead_type").hide();
            }else{
                $("#tr_ban_reason").hide(); 
                $("#tr_auditor").show();
                $("#lead_type").show();
            }
            if (($("input[name='stype']:checked"). val()== 'DNC') || ($("input[name='stype']:checked"). val()== 'R'  || ($("input[name='stype']:checked"). val()== 'BAN'))) {
               $("#trmain").hide();
               $("#tr3").hide();
               $("#tr4").hide();
               $("#tr6").hide();              
            }else{
               $("#tr3").show();
               $("#tr4").show();
               $("#tr6").show();
             
           }
           if($("input[name='stype']:checked"). val()== 'R'){
                $("#tr7").show(); 
               
            }else{
              $("#tr7").hide(); 
            }

         
    });
});
$(document).ready(
    function()
            {
            if (($("input[name='stype']:checked"). val()== 'DNC') || ($("input[name='stype']:checked"). val()== 'BAN')){
                $("#tr_calling_del").show(); 
            }else{
                $("#tr_calling_del").hide(); 
            }
            if ($("input[name='stype']:checked"). val()== 'BAN'){
                $("#tr_ban_reason").show(); 
                $("#tr_auditor").hide(); 
                $("#lead_type").hide();
            }else{
                $("#tr_ban_reason").hide(); 
                $("#tr_auditor").show(); 
                $("#lead_type").show();
            }
            if ($("input[name='stype']:checked"). val()== 'R'){
                 $("#tr7").show(); 
            }else{
                 $("#tr7").hide();  
            }
            
            if (($("input[name='stype']:checked"). val()== 'DNC') || ($("input[name='stype']:checked"). val()== 'R') || ($("input[name='stype']:checked"). val()== 'BAN')) {
               $("#trmain").hide();
               $("#tr3").hide();
               $("#tr4").hide();
               $("#tr6").hide();
           }else if ($("input[name='stype']:checked"). val()== 'ADV') {
               $("#trmain").show();
               $("#tr3").show();
               $("#tr4").show();
               $("#tr6").show();
            }else{
                $("#trmain").hide();
                $("#tr3").show();
               $("#tr4").show();
               $("#tr6").show();
            }  
            }
); 

 
function validateRebuttal()
{
    var date1=$('#start_date').val();
    var mdy = date1.split('-');
    var date1=mdy[0] +' '+mdy[1]+' '+mdy[2];
    var date1 = new Date(date1);

    var date2=$('#end_date').val();
    var mdy2 = date2.split('-');
    var date2=mdy2[0] +' '+mdy2[1]+' '+mdy2[2];
    var date2 = new Date(date2);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    if(diffDays>7)
    {
        alert('Please Select maximum 7 days difference Only');
        return false;
    }
    var process_level_val = '';
    process_level_val = $('input[name="process_level"]:checked').map(function() {
    return this.value;
    }).get().join();
    $("#process_level_val").val(process_level_val);
}
function showTL(sel){
        var selectedValue = $(sel).val();//alert(selectedValue);
        if( selectedValue != 'ALL'){
            a={};
                a['audit_id1']=selectedValue;
                    result='';              
            $.ajax({
                url:"/index.php?r=admin_eto/auditEto/TLlist/",
                type: 'post',
                data:a,
                success:function(result){
                    $("#tldiv").show();
                    $('#tlselect').html(''); 
                    $('#tlselect').html(result);                   
                }
            });
        }  
                               
}

function showagent(sel){
        var selectedValue = $(sel).val();//alert(selectedValue);
        if( $(sel).val() != '0'){
            a={};
                a['tl_id']=selectedValue;
                    result='';              
            $.ajax({
                url:"/index.php?r=admin_eto/auditEto/Agentlist/",
                type: 'post',
                data:a,
                success:function(result){  //alert(result); 
                    $("#agentdiv").show();
                    $('#agentselect').html(''); 
                    $('#agentselect').html(result);                   
                }
            });
        }   
                               
}


var temp1=0;
var temp2=0;
var temp3=0;
var temp33=0;
var temp11=0;
function showCmplntForm(audit_id,offer_id,div_id,total_record)
{
 temp1=div_id;
 temp2=total_record;
 temp3=1;
 document.getElementById('cmplnt_div'+div_id).style.opacity=1;
 document.getElementById('cmplnt_div'+div_id).style.display="block";
 
 for(i=1;i<total_record;i++)
 {
   if(i != div_id){
   if(document.getElementById('cmplnt_div'+i).innerHTML !='Already Raised')
   {
   document.getElementById('cmplnt_div'+i).style.display="none";
   }
   }
 }
 
   
    document.getElementById('cmplnt_div'+div_id).innerHTML = '<form name="searchform" method="post" action=""><div style="border-size:2px;border-style:solid;border-color:#0195d3;height:150px;"><table style="border-collapse: collapse;" border="0" cellpadding="4" cellspacing="0" width="100%" height="100%"><tr><td  align="center" style="color:#ffffff;" colspan="2" width="100%"  bgcolor="#0195d3"><b>Rebuttal for Audit Id:</b></td></tr><tr><td width="10%"><span style="float:left;margin:3px 0px 0px 0px;">Remarks:</span></td><td width="80%"><textarea id="remarks'+div_id+'" name="remarks" style="width: 98%; height: 60px; margin-bottom:8px;resize: none; "></textarea></td></tr><tr><td align="center" colspan="2" style="padding:4px;"><input type="hidden" name="audit_id1" value=""><input type="hidden" name="offer_id1" value=""><input type="button" name="Raise" value="Raise" onclick="return validate_remark('+audit_id+','+offer_id+','+div_id+');">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="close" value="Close" onclick="return show_alert_off('+div_id+',2);"></td></tr></table></div></form>';
   

document.getElementById("remarks"+div_id).focus();   
}
function show_ul(div_id) {
    x=document.getElementById("mapping_ul"+div_id).style.display;
    if(x=="none")
    {
        document.getElementById("mapping_ul"+div_id).style.display="block";
    }
    else{
        document.getElementById("mapping_ul"+div_id).style.display="none";
    }
}
        
function updateRebuttalnew(perm,audit_id,offer_id,div_id,total_record,stype)
{
    // alert(perm);
temp11=div_id;
 temp2=total_record;
 temp33=1;

for(i=1;i<=total_record;i++)
 {
   if(i != div_id){
   document.getElementById('Update_cmplnt_div'+i).style.display="none";
   }
 }
 var rejhtml='<div class="btn-group" id="drop'+div_id+'" style="display: inline-block;">\n\
<a data-toggle="dropdown" class="btn btn-medium btn-danger dropdown-toggle" name="drpnfl" id="drpnfl" onclick="show_ul('+div_id+')"><b>Reject</b>&nbsp;&nbsp;&nbsp;<span class="caret"></span></a>\n\
<ul  style="display:none;max-width: fit-content;" role="menu" class="dropdown-menu" id="mapping_ul'+div_id+'">\n\
<li style="cursor:pointer"><a onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',2,'+stype+')">Technical/ Logical Issue at IndiaMART end</a>\n\
</li><li style="cursor:pointer"><a onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',4,'+stype+')">Error at Center/Associate end</a></li></ul></div>';
                
     document.getElementById('Update_cmplnt_div'+div_id).style.display="block";
        if(perm == 1){
             document.getElementById('Update_cmplnt_div'+div_id).innerHTML ='<form name="searchform" method="post" action=""><div style="border-size:2px;border-style:solid;border-color:#0195d3;height:150px;"><table style="border-collapse: collapse;" border="0" cellpadding="4" cellspacing="0" width="100%" height="100%">\n\
        <tr>\n\
        <td align="center" style="color:#ffffff;" colspan="2" width="100%"  bgcolor="#0195d3"><b>Update Rebuttal for Audit Id:'+audit_id+'</b>\n\
        <img src="/gifs/close1.gif" style="cursor:pointer;margin:5px;height: auto;width: auto;float: right;margin-top: -12px;margin-right:-10px;" onclick="return show_alert_off2('+div_id+',2);"></td></tr>\n\
                <tr>\n\
                <td width="10%"><span style="float:left;margin:3px 0px 0px 0px;">Remarks:</span></td>\n\
                <td width="80%"><textarea id="remarks'+div_id+'" name="remarks" style="width: 98%; height: 60px; margin-bottom:8px;resize: none; "></textarea></td></tr>\n\
                <tr>\n\
                <td align="center" colspan="2" style="padding:4px;">\n\
                <input type="hidden" name="audit_id1" value="">\n\
                <input type="hidden" name="offer_id1" value="">\n\
                <input type="button" style="background-color: #4CAF50;vertical-align: top;" name="Accept" value="Accept" onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',1,'+stype+');">&nbsp;&nbsp;'+rejhtml+'&nbsp;&nbsp;\n\
                <input type="button" style="vertical-align: top;background-color: orange;" name="Update" value="Update" onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',3,'+stype+');">\n\
                </td></tr></table></div></form>';
                        }else{
                            document.getElementById('Update_cmplnt_div'+div_id).innerHTML = '<form name="searchform" method="post" action=""><div style="border-size:2px;border-style:solid;border-color:#0195d3;height:150px;">\n\
                        <table style="border-collapse: collapse;" border="0" cellpadding="4" cellspacing="0" width="100%" height="100%">\n\
                <tr>\n\
                <td align="center" style="color:#ffffff;" colspan="2" width="100%"  bgcolor="#0195d3"><b>Update Rebuttal for Audit Id:'+audit_id+'</b><img src="/gifs/close1.gif" style="cursor:pointer;margin:5px;height: auto;width: auto;float: right;margin-top: -12px;margin-right:-10px;" onclick="return show_alert_off2('+div_id+',2,'+stype+');"></td></tr>\n\
\n\             <tr><td width="10%"><span style="float:left;margin:3px 0px 0px 0px;">Remarks:</span></td>\n\
                <td width="80%"><textarea id="remarks'+div_id+'" name="remarks" style="width: 98%; height: 60px; margin-bottom:8px;resize: none; "></textarea></td></tr>\n\
                <tr>\n\
                <td align="center" colspan="2" style="padding:4px;">&nbsp;&nbsp;'+rejhtml+'&nbsp;&nbsp;\n\
                <input type="button" style="background-color: orange;vertical-align:top;" name="Update" value="Update" onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',3,'+stype+');">\n\
               </table></div></form>';
                        }   
                        document.getElementById("remarks"+div_id).focus();
                    }

function show_alert_off(div_id,check)
{
if(check ==1)
{
 document.getElementById('Rebuttal_div'+div_id).innerHTML="Already Raised";
}
 temp=2;
 document.getElementById('cmplnt_div'+div_id).style.display="none";
 document.getElementById('complete_mis').style.opacity=1;
 
 
}

function show_alert_off2(div_id,check)
{
 document.getElementById('Update_cmplnt_div'+div_id).style.display="none";

}

function validate_remark2(audit_id,offer_id,div_id,status,stype)
{ 
temp33=1;
 var remarks=document.getElementById("remarks"+div_id).value.trim();
 if(remarks =='')
        {
                alert("Please Fill Remarks ");
                return false;
        }
  else{  
        if(document.getElementById('Update_cmplnt_div'+div_id)){
            document.getElementById('Update_cmplnt_div'+div_id).innerHTML='<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0"  ALIGN="CENTER" height="100%"><TR><TD VALIGN="TOP" WIDTH="50%" class="mp5"><BR><BR><div style="font-size: 15px; font-family: arial; color: rgb(77, 77, 77);" align="center">Processing.....<BR><BR><img src="/gifs/loading2.gif"></div><BR></td></tr></table>';
        }  
        a={};
        a['remarks']=remarks;
        a['audit_id1']=audit_id;
        a['offer_id1']=offer_id;
        a['div_id']=div_id;
        a['status']=status;
        a['stype']=stype;
        $.ajax({
        type : 'POST',
        url : "/index.php?r=admin_eto/auditEto/Rebuttal/",
        data : a,
        success:function(result){
                if(document.getElementById('Update_cmplnt_div'+div_id)){
                    document.getElementById('Update_cmplnt_div'+div_id).innerHTML = result;
                }
        }
        });
 }    
}

function validate_opt(grpname){
       var group =document.getElementsByName(grpname);
        if (group[0].checked === true) {
            for (var i=1; i<group.length; i++) {
                group[i].checked = false;
            }           
        }

}


function ChecklistCheckbox(id)
{
 if(id.checked==true)
 {
  if(id.value =='ALL')
  {
   $( "#TL").attr('checked',false);
   $( "#QA").attr('checked',false);
   $( "#EMP").attr('checked',false);
   $( "#AGENT").attr('checked',false);
   $( "#MGR").attr('checked',false);
  }
  if(id.value =='TL' || id.value =='QA' || id.value =='EMP' || id.value =='AGENT' || id.value =='MGR')
  {
   $( "#ALL").attr('checked',false);
  }
 }
}
function check()
{
    var poolVal = '';
    poolVal = $('input[name="pool"]:checked').map(function() {
    return this.value;
    }).get().join();
    $("#poolVal").val(poolVal);
    return true;
}
   
function checkvalidate()
{
    var poolVal = '';
    poolVal = $('input[name="pool[]"]:checked').map(function() {
    return this.value;
    }).get().join();
    $("#poolVal").val(poolVal);

 var audit_id='';
 var offer_id='';
if(document.getElementById("offer_id")){        
offer_id= document.getElementById("offer_id").value;
if(offer_id.trim() !==''){
   
        if(offer_id.match('^[0-9]+\$')){
        }else{           
            alert('Enter only Numeric Value in Offer ID');
            return false;
        }
    }
 }
if(document.getElementById("audit_id")){
audit_id=document.getElementById("audit_id").value;
if(audit_id.trim() !==''){   
        if(audit_id.match('^[0-9]+\$')){
        }else{           
            alert('Enter only Numeric Value in Audit ID');
            return false;
        }
    }
 }
    if(audit_id !=='' && offer_id !=='')
        {
         alert('Search by only One parameter offer Id OR  Audit ID');
            return false;
        }

}
function trend_check(id)
{
 if(id ==1)
 {
  document.getElementById("end_date1").style.display='block';
  $("#trend_format_row").show();
  $("#parameter_row").hide();
 }
 else if(id ==3)
 {
  document.getElementById("end_date1").style.display='block';
  $("#trend_format_row").hide();
  $("#parameter_row").show();
 }
 else
 {
  document.getElementById("end_date1").style.display='none';
  $("#trend_format_row").show();
  $("#parameter_row").hide();
 }
 
}

function Newfilter(id,team_leader,qa,agent)
{
        a={};
        a['vendor']=id;
        a['leader']=team_leader;
        a['qa']=qa;
        a['agent']=agent;
        $.ajax({
        type : 'POST',
        url : "/index.php?r=admin_eto/auditEto/Newfilter/",
        data : a,
        success:function(result){
                var fields = result.split('####');
                document.getElementById('team_leader').innerHTML =fields[0];
                document.getElementById('team_qa').innerHTML =fields[1];
                document.getElementById('team_agent').innerHTML =fields[2];
        }
        });
    
}
</script>

<style type="text/css">
.dark{background : #eefaff;     }.wbg{background : #ffffff;      }.fnt{font-size:12px;width:33%;height:15px;}
.tab-container{ background:#ffffff; width:100%; margin:0px auto; border:1px solid #80c0e5;}.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
.data_off{display:none}.data_on{display:block}
.nav{ float:left;width:100%;}.nav ul{ padding:0px; margin:0px;}.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
.nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
.nav ul li a:hover{color:#000000; text-decoration:none;}.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}
</style>
</head>
<body>
<?php

 $offerid=isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
 $auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
 $is_archive=isset($_REQUEST['is_archive'])?$_REQUEST['is_archive']:'';
$stype=isset($_REQUEST['stype'])?$_REQUEST['stype']:'';
 echo '<body>
 <form name="RebuttalMis" id="RebuttalMis" method="post" action="/index.php?r=admin_eto/auditEto/RebuttalMis&mid=3872" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Rebuttal MIS</b></font>             
              </td>   
              </TR>
              <TR id="tr_search">
                <TD  CLASS="admintext">Search Type</TD>
                <TD colspan="3">';  
 ?>
            <input type="radio" id="s1" name="stype" value="" <?php echo ($stype=='') ?"checked":'' ?> >&nbsp;Approved &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s2" name="stype" value="ADV"  <?php echo ($stype=="ADV")?"checked":'' ?> >&nbsp;Approved - Advanced&nbsp;&nbsp;&nbsp;
              <input type="radio" id="s7" name="stype" value="AUTO"  <?php echo ($stype=="AUTO") ? "checked":'' ?> >&nbsp;Auto Approved&nbsp;&nbsp;&nbsp;

                <input type="radio" id="s3" name="stype" value="R"  <?php echo ($stype=="R") ? "checked":'' ?> >&nbsp;Reviewed&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s4" name="stype" value="BAN"  <?php echo ($stype=="BAN")?"checked":'' ?> >&nbsp;Ban Pool&nbsp;
                <input type="radio" id="s6" name="stype" value="NONBL"  <?php echo ($stype=="NONBL")?"checked":'' ?> >&nbsp;Non BL&nbsp; 
                <input type="radio" id="s5" name="stype" value="DEL"  <?php echo ($stype=="DEL")?"checked":'' ?> >&nbsp;Deleted Buylead&nbsp;
                 <span id="tr_ban_reason" name="tr_ban_reason" style="display:none;"> 
                     <select name="ban_reason" id="ban_reason"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="A">Approved</option>
                        <option value="R">Deleted</option><option value="E">Expired</option></select>&nbsp;&nbsp;&nbsp;
                      <select name="key_category" id="key_category"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="2">Adult</option>
                        <option value="4">Drug</option><option value="3">Trademark</option></select>&nbsp;&nbsp;&nbsp;
                        <select name="key_type" id="key_type"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="3">By Script</option>
                        <option value="1">By Service</option><option value="2">Both</option></select>
               </span>
                </TD>
            </TR>
              <tr>
<?php
        echo '<td WIDTH="20%">&nbsp;Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="'.$start_date.'" SIZE="13" onfocus="displayCalendar(document.RebuttalMis.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.RebuttalMis.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="end_date" type="text" VALUE="'.$end_date.'" SIZE="13" onfocus="displayCalendar(document.RebuttalMis.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'to_date1\')" onclick="displayCalendar(document.RebuttalMis.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'to_date1\')" id="end_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Archive Data:  &nbsp;&nbsp;<input type="checkbox" name="is_archive" value="yes"';
              if($is_archive=="yes"){echo " checked";}             
              echo'></td>
              <td WIDTH="20%">&nbsp;Process Level:&nbsp; </td> <td>';
    ?>
<input type="checkbox" id="process_level0" name="process_level" value="5" <?php 
                if(preg_match("/5/i",@$_REQUEST['process_level_val'])){echo 'CHECKED';                
                }?>/>&nbsp;5&nbsp;&nbsp; 
<input type="checkbox" id="process_level1" name="process_level" value="6" <?php 
                if(preg_match("/6/i",@$_REQUEST['process_level_val'])){echo 'CHECKED';                
                }?> />&nbsp;6&nbsp;&nbsp;
<input type="checkbox" id="process_level2" name="process_level" value="7" <?php 
                if(preg_match("/7/i",@$_REQUEST['process_level_val'])){echo 'CHECKED';                
                }?>/>&nbsp;7&nbsp;&nbsp;
<?php 
        echo '</td>               
        </tr>
            <tr>
    <td >&nbsp;Approved By: </td>
    <td>&nbsp;<select name="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;" onchange="Newfilter(this.value,\''.$team_leader.'\',\''.$team_qa.'\',\''.$team_agent.'\');">';
 
                $vendorArr1=array();$vendor_name='';
                if(count($vendorArr)==1){
                    $vendor_name=$vendorArr[0];
                    $vendor_name_login=$vendorArr[0];
                    if(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW','NOIDA'); 
                      }elseif(preg_match("/COMPETENT/i",$vendor_name)) {
                          $vendorArr1 = array('COMPETENT','BANREVIEW','COMPETENTDNC');
                      }else{
                          $vendorArr1 = array($vendor_name);
                      }
                }else{
                        $vendorArr1 = $vendorArr;
                        $vendor_name='ALL';
                }
        foreach($vendorArr1 as $k)
        {
            if($vendor_name == $k)
                {
                    echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$k.'" >'.$k.'</OPTION>';
                }

        } 

         echo '</select>
      
    </td>
    <td >&nbsp;Raised By: </td>
    <td>&nbsp;<select name="vendor_rebuttal" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">';     
        $auditor_count=count($vendorArr);
        $vendorArr1=array();$vendor_name='';
                if(count($vendorArr)==1){
                    $vendor_name=$vendorArr[0];
                    $vendor_name_login=$vendorArr[0];
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 =array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW');     
                      }else{
                          $vendorArr1 = array($vendor_name);
                      }
                }else{
                        $vendorArr1 = $vendorArr;
                        $vendor_name='ALL';
                }
        foreach($vendorArr1 as $k)
        {
            if($vendor_name == $k)
                {
                    echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$k.'" >'.$k.'</OPTION>';
                }

        } 
         if($auditor_count == 1){
                            if($vendor_raised =='NOIDA')
                            {
                            echo "<OPTION VALUE=\"NOIDA\" SELECTED=\"SELECTED\">NOIDA</OPTION>";
                            }
                            else
                            {
                             echo "<OPTION VALUE=\"NOIDA\">NOIDA</OPTION>";
                            }
                            if($vendor_raised =='DDN'){
                            echo "<OPTION VALUE=\"DDN\" SELECTED=\"SELECTED\">DDN</OPTION>";}
                            else
                            {
                             echo "<OPTION VALUE=\"DDN\">DDN</OPTION>";
                            }
                        }
       
        echo '</select>
      
    </td></tr>
   
    <tr>
    <td >&nbsp;Search by Offer Id: </td>
    <td colspan="3">&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="offer_id" id="offer_id" value="'.$offerid.'">
    &nbsp;&nbsp;&nbsp;&nbsp;Search by Audit Id:
    &nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="audit_id" id="audit_id" value="'.$auditId.'"></td>
    </tr>
   <tr id="trmain">
        <td >&nbsp;Team Leader: </td>
        <td colspan="3">&nbsp;<span name="team_leader" id="team_leader"></span>
        &nbsp;&nbsp;&nbsp;&nbsp;Associate:
        &nbsp;<span name="team_agent" id="team_agent"></span>
        &nbsp;QA: 
       &nbsp;<span name="team_qa" id="team_qa"></span>
        </td></tr>
       
      <tr>
    <td >&nbsp;Status: </td>
    <td>&nbsp;
    <input type="radio" name="status" id="status" value="5"';
   
    if((isset($_REQUEST['status']) &&  $_REQUEST['status'] ==5) || !isset($_REQUEST['status']))
    {
     echo ' checked';
    }
   
    echo '>&nbsp;All
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="status" id="status" value="2"';
   
    if((isset($_REQUEST['status']) && $_REQUEST['status'] ==2))
    {
     echo ' checked';
    }
   
    echo '>&nbsp;Rejected
   
    &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="status" id="status" value="1"';
   
    if((isset($_REQUEST['status']) && $_REQUEST['status'] ==1))
    {
     echo ' checked';
    }
   
    echo '>&nbsp;Accepted&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="radio" name="status" id="status" value="0"';
   
    if((isset($_REQUEST['status']) && $_REQUEST['status'] ==0))
    {
     echo ' checked';
    }
   
    echo '>&nbsp;WIP
   
    </td>
        <TD colspan="2" align="center">
        <input type="submit" name="submit_dump" id="submit_dump" onclick="return validateRebuttal()" value="Generate Report">
        <input type="submit" name="submit_summary" id="submit_summary" onclick="return validateRebuttal()" value="Summary Report">

        <input type="hidden" name="process_level_val" id="process_level_val" value="">
        </TD>
       </TR>
       </TABLE>';
      
  if(isset($_REQUEST['submit_dump'])){
  if(sizeof($rec1) >=1)
  {
  echo '<br><br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr><td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total '.sizeof($rec1).' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="export_dump" id="export_dump" value="Export Dump"></td></tr></table>';
           
                   echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">
                   <tr style="background: #0195d3; color: white;">
              <td style="padding:4px;color: white;">S No</td>                   
                          <td style="padding:4px;color: white;">Offer ID</td>
                          <td style="padding:4px;color: white;">Approved By</td>
                          <td style="padding:4px;color: white;">Audit ID / Call Recording Url</td>     
                          <td style="padding:4px;color: white;">Audited By</td>
                          <td style="padding:4px;color: white;">Audited On</td>
                          <td style="padding:4px;color: white;">Raised By</td>
                          <td style="padding:4px;color: white;">Raised On</td>
                          <td style="padding:4px;color: white;">Audit Remarks</td>
                          <td style="padding:4px;color: white;">Rebuttal Remarks</td>
                          <td style="padding:4px;color: white;">Status</td>
                          <td style="padding:4px;color: white;">Update Rebuttal</td>
                          </tr>';
                        $perm=0;$n=1; 

                        $empId = Yii::app()->session['empid'];  
                        $admineto=new AdminEtoForm(); 
                        $arr_lvl_code = $admineto->getLeapEmpLVL($empId); //print_r($arr_lvl_code); 
                        $mqtype=0;
                            if($stype=='NONBL'){
                                $mqtype= 2;
                            }elseif($stype=='AUTO'){
                                $mqtype=3;
                            }elseif($stype=='ADV'){
                                $mqtype= 4;
                            }elseif($stype=='BAN'){
                                $mqtype=5;
                            }elseif($stype=='R'){
                                $mqtype=6;
                            }elseif($stype=='DEL'){
                                $mqtype=7;    
                            }else{
                                $mqtype=1;
                            }
                            
                            
            foreach($rec1 as $rec)
            {
             $perm=0;
             $rec=array_change_key_case($rec, CASE_UPPER);
             $auditby=$rec['BL_AUDIT_RESPONSE_EMP_NAME'];
             $auditby_arr=explode("[",$auditby);  
             $auditby_center=str_replace("]","",$auditby_arr[1]);
             
             $rebby=$rec['REBUTTAL_EMP_NAME'];
             $rebby_arr=explode("[",$rebby);  
             $rebby_center=str_replace("]","",$rebby_arr[1]);
             
             if(($arr_lvl_code['ETO_LEAP_VENDOR_NAME']=='DDN') OR (($arr_lvl_code['ETO_LEAP_EMP_LEVEL']== 4) && $auditby_center==$rebby_center)){
                $perm=1;
             }
             if(isset($rec['REBUTTAL_STATUS']) && $rec['REBUTTAL_STATUS'] ==0)
             {
              $REBUTTAL_STATUS='WIP';
             }
             elseif(isset($rec['REBUTTAL_STATUS']) && $rec['REBUTTAL_STATUS'] ==1)
             {
              $REBUTTAL_STATUS='Accepted';
             }
             elseif(isset($rec['REBUTTAL_STATUS']) && $rec['REBUTTAL_STATUS'] ==2 || isset($rec['REBUTTAL_STATUS']) && $rec['REBUTTAL_STATUS'] ==4)
             {
              $REBUTTAL_STATUS='Rejected';
             }
             $ban='';
             if($stype=='BAN'){
                 $ban='&ban=1';
             }
             $url_audit_mis_form = '';
             if($stype =='DEL'){
              $url_audit_mis_form = 'javascript:window.open(\'/index.php?r=admin_eto/BulkAuditEto/AuditMis_Edit&offer_id=' . $rec['FK_ETO_OFR_DISPLAY_ID']. '&auditid='.$rec['FK_BL_AUDIT_RESPONSE_ID'].'&mid=3549\');';
             }else if(($stype =='ADV') || ($stype =='')){
              $url_audit_mis_form = 'javascript:window.open(\'/index.php?mid=3826&r=admin_eto/auditEto/Auditedit_v1/audit_id/'
                      . ''.$rec['FK_BL_AUDIT_RESPONSE_ID'].'/ven_app/'.$vendor_approve.'/ven_audit/'.$vendor_raised.'/sd/'.$start_date.'/ed/'.$end_date.
                      '/offer_id/'.$rec['FK_ETO_OFR_DISPLAY_ID'].'/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');';
             }else{
              $url_audit_mis_form = 'javascript:window.open(\'/index.php?r=admin_eto/auditEto/Auditedit/stype/'.$stype.'/audit_id/'.$rec['FK_BL_AUDIT_RESPONSE_ID'].'/ven_app/'.$vendor_approve.'/ven_audit/'.$vendor_raised.'/sd/'.$start_date.'/ed/'.$end_date.'/offer_id/'.$rec['FK_ETO_OFR_DISPLAY_ID'].'/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');';             
             }
             $REBUTTAL_REMARKS=$rec['REBUTTAL_REMARKS'];
             $AUDIT_REMARKS=$rec['REMARKS'];
             echo '<tr >
              <td style="padding:4px;">'.$n.'</td>                       
                          <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads'.$ban.'&offer='.$rec['FK_ETO_OFR_DISPLAY_ID'].'&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">'.$rec['FK_ETO_OFR_DISPLAY_ID'].'</a></td>
                           <td style="padding:4px;width:40px">'.$rec['BL_APPROVEDBY_EMP_NAME'].'</td>
                          <td style="padding:4px;"><a href="#" onclick="'.$url_audit_mis_form.'" style="text-decoration: none;">
                          '.$rec['FK_BL_AUDIT_RESPONSE_ID'].'</a>';                              
                          if($stype=='NONBL'){
                                $callrec=@$rec['CALL_RECORDING_URL'];
                                echo '<br> <a href="'.$callrec.'" target="_blank">Play Recording</a>';
                            }
                          echo '</td> 
                          <td style="padding:4px;width:40px">'.$rec['BL_AUDIT_RESPONSE_EMP_NAME'].'</td>
                          <td style="padding:4px;width:40px">'.$rec['BL_AUDIT_RESPONSE_DATE'].'</td>
                          <td style="padding:4px;width:40px">'.$rec['REBUTTAL_EMP_NAME'].'</td>
                          <td style="padding:4px;width:40px;">'.$rec['REBUTTAL_DATE'].'</td>
                          <td style="padding:4px;">';
                          $AUDIT_REMARKS = str_replace("\n", '<br>', $AUDIT_REMARKS);
                          echo $AUDIT_REMARKS.'
                          </td>
                          <td style="padding:4px;">';
                          $REBUTTAL_REMARKS = str_replace("\n", '<br>', $REBUTTAL_REMARKS);
                          $REBUTTAL_REMARKS = str_replace("%20", ' ', $REBUTTAL_REMARKS);
                          $REBUTTAL_REMARKS = str_replace("%2C", ' ', $REBUTTAL_REMARKS);
                          $REBUTTAL_REMARKS = str_replace("%27", ' ', $REBUTTAL_REMARKS);
                          $REBUTTAL_REMARKS = str_replace("%0A", ' ', $REBUTTAL_REMARKS);
                          $REBUTTAL_REMARKS = str_replace("%22", ' ', $REBUTTAL_REMARKS);
                           echo $REBUTTAL_REMARKS.'
                          <input type="hidden" name="finalremark'.$n.'" id="finalremark'.$n.'" value="'.$rec['REBUTTAL_REMARKS'].'">
                          </td>
                          <td style="padding:4px;width:10px">'.$REBUTTAL_STATUS.'</td>';
                          echo '<td style="padding:4px;position:relative;">';
                                                      
                            echo '<div id="Update_Rebuttal_div'.$n.'"><input type="button" name="Update_Rebuttal" id="Update_Rebuttal" value="Update Rebuttal" onclick="updateRebuttalnew('.$perm.','.$rec['FK_BL_AUDIT_RESPONSE_ID'].','.$rec['FK_ETO_OFR_DISPLAY_ID'].','.$n.','.sizeof($rec1).','.$mqtype.')"></div>
                           <div id="Update_cmplnt_div'.$n.'" class="cancel" style="display:none;" ></div>';
                          
                          echo '</td>
                          </tr>';
             
             $n++;
            }
           
            echo '</table>';
          }
         
          else
          {
           echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
          }
  }
 
if(isset($_REQUEST['submit_summary'])){
  echo '<br><br>';
    if($rec1<>'') {
        echo $rec1;
    }else{
            echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
    }
}
   echo '<script>  
    $(document).on(\'click\', function (e) {
    if ($(e.target).closest("#Update_cmplnt_div"+temp11).length === 0) {
        if(temp33 !=1)
        {
            if(document.getElementById(\'Update_cmplnt_div\'+temp11)){
                document.getElementById(\'Update_cmplnt_div\'+temp11).style.display="none";
            }
        }
    }
   
  temp33=0;

  
});

$( document ).on(\'keydown\', function ( e ) {
    if ( e.keyCode === 27 && document.getElementById(\'Update_cmplnt_div\'+temp11)) {
        document.getElementById(\'Update_cmplnt_div\'+temp11).style.display="none";
    }
});
 
    </script>
    </body>';



  echo '<div style="clear:both;"><!-- --></div></div>';

 
 
?>
