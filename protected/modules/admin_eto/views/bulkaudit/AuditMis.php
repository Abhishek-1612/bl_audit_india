<?php
$team_leader    = isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa        = isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent     = isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve = isset($vendor_approve) ? $vendor_approve : 'ALL';
$tabselect      = isset($_REQUEST['tabselect']) ? $_REQUEST['tabselect'] : 3;
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
$agent_id=isset($_REQUEST['agent_id']) ? $_REQUEST['agent_id'] : '';

?>
<head>
<title>Buy Lead Audit MIS</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:2px;border-style:solid;border-color:#0195d3;
}
a:visited {color: red;}
a:active {color: blue;}
a:link {color: blue;}
</style>     
<link href="/gladmin/css/report.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="/gladmin/js/jquery.min.js"></script>
<script language="javascript" src="/gladmin/js/calendar.js"></script>
<!-- <link href="/css/report.css" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript" src="<?php //echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script> -->
<?php
if ($tabselect <> 1) {
?>
<script type="text/javascript">
</script>
<?php
}
?>
<script type="text/javascript">
function resetForm() {
    document.getElementById("sampleForm").reset();
}
    $(function() {
    $('input:radio[name="stype"]').change(function() {
        if ($(this).val() == 'ADV') {
              Newfilter('<?php
echo $vendor_approve;
?>','<?php
echo $team_leader;
?>','<?php
echo $team_qa;
?>','<?php
echo $team_agent;
?>');
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
                $('#submit_view').click(function(){                 
                        a={};
                        a['stype']= $("input[name='stype']:checked"). val();
                        a['vendor_approval']=$('#vendor_approval').val();                        
                        a['mailoption']=$('#mailoption').val();
                        a['maxrecords']=$('#maxrecords').val();
                        a['start_date']=$('#start_date').val();                        
                        a['submit_view']=$('#submit_view').val();
                        a['tlselect']=$('#tlselect').val();
                        a['team_leader_select']=$('#team_leader_select').val();
                        a['qa_select']=$('#qa_select').val();
                        a['agent_select']=$('#agent_select').val();
                        a['agentselect']=$('#agentselect').val();  
                        
                        if($("input[name='stype']:checked"). val() !='R'){
                            if($('input[name="deletedsample"]:checked').val() =='YES')
                            {
                             a['deletedsample']='YES';
                             if($('input[name="delsource"]:checked').val() =='direct')
                             {
                              a['delsource']='direct';
                             }
                             else
                             {
                              a['delsource']='fenq';
                             }
                            }
                            else
                            {
                             a['deletedsample']='NO';
                            }
                            
                            if($('input[name="audit_for"]:checked').val() =='super_audit')
                            {
                              a['audit_for']='super_audit';
                            }
                            else
                            {
                             a['audit_for']='normal_audit';
                            }
                            
                            a['bucket']=$('#bucket').val();  
                            a['deletedreasonselect']=$('#deletedreasonselect').val();
                            a['deletedcall_noncall']=$('#deletedcall_noncall').val();
                            
                            a['pool']= $('input[name="pool"]:checked').val();
                            a['poolVal']=$('#poolVal').val();   
                            
                            a['leadtype1']= $('input[name="leadtype1"]:checked').val();
                            a['leadtype2']=$('input[name="leadtype2"]:checked').val();
                            a['AOV']= $('input[name="AOV"]:checked').val();
                            a['shortcall']= $('input[name="shortcall"]:checked').val();
                        } 
                        if($("input[name='stype']:checked"). val() =='DNC'){
                            a['calling_del']=$('#calling_del').val();                            
                        }
                        if($("input[name='stype']:checked"). val()== 'BAN'){
                            a['ban_reason']=$('#ban_reason').val();
                            a['key_category']=$('#key_category').val();
                            a['key_type']=$('#key_type').val();
                        }
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/auditEto/Sampling&tabselect=3",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                success:function(result){                         
                               $('#sampleresult').html(result);                   
                            }
                        });                   
                    }); 
                    $('#submit_send').click(function(){                      
                        a={};
                        a['stype']= $("input[name='stype']:checked"). val();
                        a['vendor_approval']=$('#vendor_approval').val();
                        a['mailoption']=$('#mailoption').val();
                        a['maxrecords']=$('#maxrecords').val();
                        a['start_date']=$('#start_date').val();                        
                        a['submit_send']=$('#submit_send').val();
                        a['tlselect']=$('#tlselect').val();
                        a['team_leader_select']=$('#team_leader_select').val();
                        a['qa_select']=$('#qa_select').val();
                        a['agent_select']=$('#agent_select').val();
                        a['agentselect']=$('#agentselect').val(); 
                        
                        if($("input[name='stype']:checked"). val() !='R')
                            {
                            if($('input[name="deletedsample"]:checked').val() =='YES')
                            {
                             a['deletedsample']='YES';
                             if($('input[name="delsource"]:checked').val() =='direct')
                             {
                              a['delsource']='direct';
                             }
                             else
                             {
                              a['delsource']='fenq';
                             }
                            }
                            else
                            {
                             a['deletedsample']='NO';
                            }
                            if($('input[name="audit_for"]:checked').val() =='super_audit')
                            {
                              a['audit_for']='super_audit';
                            }
                            else
                            {
                             a['audit_for']='normal_audit';
                            }                            
                            a['bucket']=$('#bucket').val();                         
                            a['deletedreasonselect']=$('#deletedreasonselect').val();
                            a['deletedcall_noncall']=$('#deletedcall_noncall').val();
                            a['leadtype1']= $('input[name="leadtype1"]:checked').val();
                            a['leadtype2']=$('input[name="leadtype2"]:checked').val();
                            a['AOV']= $('input[name="AOV"]:checked').val();
                        }   
                        if($("input[name='stype']:checked"). val() =='DNC'){
                            a['calling_del']=$('#calling_del').val();                            
                        }
                        if($("input[name='stype']:checked"). val()== 'BAN'){
                            a['ban_reason']=$('#ban_reason').val();
                            a['key_category']=$('#key_category').val();
                            a['key_type']=$('#key_type').val();
                        }
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/auditEto/Sampling&tabselect=3",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#sampleresult").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='http://my.imimg.com/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#sampleresult').html(result);                   
                            }
                        });                   
                    }); 
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

function deleteddump(val)
{
 if(val.value =='NO')
 {
  $('#deletedreason').hide();
 }
 if(val.value =='YES')
 {
  $('#deletedreason').show();
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
        
function updateRebuttalnew(perm,audit_id,offer_id,div_id,total_record)
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
<li style="cursor:pointer"><a onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',2)">Technical/ Logical Issue at IndiaMART end</a>\n\
</li><li style="cursor:pointer"><a onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',4)">Error at Center/Associate end</a></li></ul></div>';
                
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
                <input type="button" style="background-color: #4CAF50;vertical-align: top;" name="Accept" value="Accept" onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',1);">&nbsp;&nbsp;'+rejhtml+'&nbsp;&nbsp;\n\
                <input type="button" style="vertical-align: top;background-color: orange;" name="Update" value="Update" onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',3);">\n\
                </td></tr></table></div></form>';
                        }else{
                            document.getElementById('Update_cmplnt_div'+div_id).innerHTML = '<form name="searchform" method="post" action=""><div style="border-size:2px;border-style:solid;border-color:#0195d3;height:150px;">\n\
                        <table style="border-collapse: collapse;" border="0" cellpadding="4" cellspacing="0" width="100%" height="100%">\n\
                <tr>\n\
                <td align="center" style="color:#ffffff;" colspan="2" width="100%"  bgcolor="#0195d3"><b>Update Rebuttal for Audit Id:'+audit_id+'</b><img src="/gifs/close1.gif" style="cursor:pointer;margin:5px;height: auto;width: auto;float: right;margin-top: -12px;margin-right:-10px;" onclick="return show_alert_off2('+div_id+',2);"></td></tr>\n\
\n\             <tr><td width="10%"><span style="float:left;margin:3px 0px 0px 0px;">Remarks:</span></td>\n\
                <td width="80%"><textarea id="remarks'+div_id+'" name="remarks" style="width: 98%; height: 60px; margin-bottom:8px;resize: none; "></textarea></td></tr>\n\
                <tr>\n\
                <td align="center" colspan="2" style="padding:4px;">&nbsp;&nbsp;'+rejhtml+'&nbsp;&nbsp;\n\
                <input type="button" style="background-color: orange;vertical-align:top;" name="Update" value="Update" onclick="return validate_remark2('+audit_id+','+offer_id+','+div_id+',3);">\n\
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

function validate_remark(audit_id,offer_id,div_id)
{
 temp3=1;
 var remarks=document.getElementById("remarks"+div_id).value.trim();
 if(remarks =='')
        {
                alert("Please Fill Remarks ");
                return false;
        }
  else{
        document.getElementById('cmplnt_div'+div_id).innerHTML='<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0"  ALIGN="CENTER" height="100%"><TR><TD VALIGN="TOP" WIDTH="50%" class="mp5"><BR><BR><div style="font-size: 15px; font-family: arial; color: rgb(77, 77, 77);" align="center">Processing.....<BR><BR><img src="/gifs/loading2.gif"></div><BR></td></tr></table>';
        a={};
        a['remarks']=remarks;
        a['audit_id1']=audit_id;
        a['offer_id1']=offer_id;
        a['div_id']=div_id;
        $.ajax({
        type : 'POST',
        url : "/index.php?r=admin_eto/auditEto/Rebuttal/",
        data : a,
        success:function(result){
                if(document.getElementById('cmplnt_div'+div_id)){
                    document.getElementById('cmplnt_div'+div_id).innerHTML = result;
                }
        }
        });
    }  
}

function validate_remark2(audit_id,offer_id,div_id,status)
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

function validate(){
        var tot_ques=document.getElementById("tot_question").value;
        var sel_opt_value='';
        for (var i=1; i<=tot_ques; i++) {
            var grpname="chk_" + i;
            var sel_grp=false;
            var group =document.getElementsByName(grpname);    
            for (var opt=0; opt< group.length; opt++) {
                    if(group[opt].checked === true){
                        if(sel_opt_value == ''){
                            sel_opt_value= group[opt].value;
                        }else{
                            sel_opt_value=sel_opt_value + '-' + group[opt].value;
                        }
                       
                        sel_grp=true;
                    }                      
            }
            if(sel_grp === false && i !== 14 && i !== 15){
                alert("Please Select Answer for Question " + i);
                return false;
            }
            if(i === 5 || i === 13)
            {
            }
            else
            {
          var grpname2="chk_" + i;
          var group2 =document.getElementsByName(grpname2);
          for (var opt=0; opt< group2.length; opt++) {  
           if(group2[opt].checked === true){
           var opt2=opt+1;
           if(document.getElementById("chkH_"+i+"_"+opt2).value =='Feedback' || document.getElementById("chkH_"+i+"_"+opt2).value =='Pass' || document.getElementById("chkH_"+i+"_"+opt2).value =='Not Applicable')
           {
           
           }
           else
           {
            document.getElementById('Associate_feedback').checked=true;
           }
          }
                                         
            } 
          
        }
      
        }
        document.getElementById("selopt_val").value=sel_opt_value;
      
        if(document.getElementById("remarks").value.trim()==='' || document.getElementById("remarks").value.trim()== 'What went wrong (if any): \nFeedback/Suggestion(if any):')
        {
                alert("Please Fill Remarks ");
                return false;
        }
       
    if(document.getElementById("offerID").value !==''){
        if(document.getElementById("offerID").value.match('^[0-9]+\$')){
        }else{           
            document.getElementById("offerID").value='';alert('Enter only Numeric Value');return false;
        }
    }else{
        alert('Enter Offer ID');
        return false;
    }
    var offerID=document.getElementById("offerID").value;
    var temo='';
      $.ajax({
                  url: '/index.php?r=admin_eto/AuditEto/Auditcheck',
                  data: {offerID: offerID},
                  async:false,
                  success: function(data) {                  
                  temo1=data.split("#");   
                  temo=temo1[1].replace('NA','');
        }
    });
    
    if(temo.trim() !=''){
          var patt = /DDN|NOIDA/;
            if(patt.test(temo)){
                var res = temo.replace("DDN-", "");
                var res1 = res.replace("NOIDA-", "");
                alert(res1);
                return true;
            }else{            
                alert(temo);
                return false;
            }
      }   
       
       
   return true;
}

function validate_number(){   
    if(document.getElementById("offerID").value !==''){
        if(document.getElementById("offerID").value.match('^[0-9]+\$')){
        }else{           
            document.getElementById("offerID").value='';alert('Enter only Numeric Value');return false;
        }
    }else{
        alert('Enter Offer ID');
        return false;
    }
    var offerID=document.getElementById("offerID").value;
    var temo='';
      $.ajax({
                  url: '/index.php?r=admin_eto/AuditEto/Auditcheck',
                  data: {offerID: offerID},
                  async:false,
                  success: function(data) {
                  temo1=data.split("#");   
                  temo=temo1[1].replace('NA','');                  
        }
    });    
    if(temo.trim() !=''){
          var patt = /DDN|NOIDA/;
            if(patt.test(temo)){
                var res = temo.replace("DDN-", "");
                var res1 = res.replace("NOIDA-", "");
                alert(res1);
                return true;
            }else{            
                alert(temo);
                return false;
            }
      } 
       return true;
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
        alert('This Audit Search works for Vendor 7 Days otherwise 2 Date Range Only');
        return false;
    }
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
    var process_level_val = '';
    process_level_val = $('input[name="process_level"]:checked').map(function() {
    return this.value;
    }).get().join();
    $("#process_level_val").val(process_level_val);

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
if (1) { //tabselect condition
    
    $deletedreasonArr = array(
        1 => 'Duplicate Requirement',
        3 => 'Invalid Description',
        10 => 'Wrong Contact Details',
        14 => 'Is a Supplier',
        15 => 'No Requirement',
        17 => 'Test Requirement Posted',
        21 => 'Job Enquiry',
        24 => 'Not Ready to Confirm',
        33 => 'Not Talked Lead',
        16 => 'Do Not Call',
        31 => 'Banned and Adult Product',
        35 => 'One Time Pending Deletion',
        45 => 'Deleted because one similar lead recently approved',
        11 => 'Offer Rejected',
        53 => 'Lead from IM employee',
        52 => '3 leads deleted on call',
        41 => 'Drugs Keywords',
        51 => 'Drugs Keywords',
        49 => 'Duplicate Generation - Time',
        61 => 'User Registered With Blacklisted Country',
        36 => 'Blacklisted User',
        37 => 'Disabled User',
        38 => 'Invalid Email Domains',
        64 => 'Calling Required'
    );
    $checkarch        = '';
    $offerid          = isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
    $auditId          = isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
    $team_leader      = isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
    $team_qa          = isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
    $team_agent       = isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
    $vendor1          = isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : array();
    $vendor_audit     = isset($_REQUEST['vendor_audit']) ? $_REQUEST['vendor_audit'] : 'ALL';
    $vendor_approve   = isset($_REQUEST['vendor_approve']) ? $_REQUEST['vendor_approve'] : 'ALL';
    $Archive_data     = isset($_REQUEST['Archive_data']) ? $_REQUEST['Archive_data'] : '';
    $stype            = isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
    if (!empty($Archive_data))
        $checkarch = 'checked';
?>
    <body>
     <div id="complete_mis">
     <form name="searchForm" id="searchForm" method="post" action="./index.php?r=admin_eto/BulkAuditEto/AuditMis&mid=3549" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Audit MIS</b></font>(<font COLOR ="red"> *This Audit Search works for Vendor 7 Days otherwise 2 Date Range Only</font>)             
              </td>   
              </TR>
             
              <tr>

              <td WIDTH="20%">&nbsp;Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php
    echo $start_date;
?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="end_date" type="text" VALUE="<?php
    echo $end_date;
?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Archive_data" value="Archive_data" <?php
    echo $checkarch;
?>>&nbsp;&nbsp;<b>Archive Data</b>   
              </td>
              
               <td WIDTH="20%">&nbsp;Score:</td>
              <td> &nbsp;<input type="radio" name="score" checked />Both&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="score" value="pass" <?php
    echo (isset($_REQUEST['score']) && $_REQUEST['score'] == 'pass') ? 'CHECKED="CHECKED"' : '';
?>/>Pass&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="score" value="fail" <?php
    echo (isset($_REQUEST['score']) && $_REQUEST['score'] == 'fail') ? 'CHECKED="CHECKED"' : '';
?>/>Fail&nbsp;</td>
              </tr>
              <tr id="tr_auditor">
    <td >&nbsp;Auditor Type/Level:</td>
    <td>
    &nbsp;<input type="checkbox" value="ALL" id="ALL" <?php
    if (empty($vendor1) || in_array("ALL", $vendor1))
        echo "checked";
?> name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;ALL
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="EMP" id="EMP" <?php
    if (!empty($vendor1) && in_array("EMP", $vendor1))
        echo "checked";
?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;EMP
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="AGENT" id="AGENT" <?php
    if (!empty($vendor1) && in_array("AGENT", $vendor1))
        echo "checked";
?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;AGENT
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="TL" id="TL" <?php
    if (!empty($vendor1) && in_array("TL", $vendor1))
        echo "checked";
?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;TL
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="QA" id="QA" <?php
    if (!empty($vendor1) && in_array("QA", $vendor1))
        echo "checked";
?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;QA
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="MGR" id="MGR" <?php
    if (!empty($vendor1) && in_array("MGR", $vendor1))
        echo "checked";
?> name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;MGR
    </td>          
      <td WIDTH="20%">&nbsp;Buyer Type:</td>
              <td> &nbsp;<input type="radio" name="buyer_type" value="" checked />All&nbsp;&nbsp;
                  <input type="radio" name="buyer_type" value="Frequent" <?php
    echo (isset($_REQUEST['buyer_type']) && $_REQUEST['buyer_type'] == 'Frequent') ? 'CHECKED="CHECKED"' : '';
?>/>Frequent</td>
          </tr>
                          <tr>
                          




<td >&nbsp;Deleted By: </td>
    <td>&nbsp;<select name="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
    <?php
    $auditor_count = count($vendorArr);
    $vendorArr1    = array();
    $vendor_name   = '';
    if (count($vendorArr) == 1) {
        $vendor_name = $vendorArr[0];
        if (preg_match("/KOCHAR/i", $vendor_name)) {
            $vendorArr1 = array(
                'KOCHARTECHAUTO',
                'KOCHARTECHDNC',
                'KOCHARTECHLDH',
                'KOCHARTECHINTENT',
                'KOCHARTECHREVIEW'
            );
        } elseif (preg_match("/RADIATE/i", $vendor_name)) {
            $vendorArr1 = array(
                'RADIATEPNSTOBL',
                'RADIATEINTENT',
                'RADIATEPNSMRK',
                'RADIATEAUTO'
            );
        } elseif (preg_match("/VKALP/i", $vendor_name)) {
            $vendorArr1 = array(
                'VKALPDNC',
                'VKALPAUTOFRN',
                'VKALPAUTOIND',
                'VKALPINTENT',
                'VKALPREVIEW'
            );
        } else {
            $vendorArr1 = array(
                $vendor_name
            );
        }
    } else {
        $vendorArr1 = $vendorArr;
    }
    foreach ($vendorArr1 as $k) {
        if ($vendor_approve == $k) {
            echo '<OPTION VALUE="' . $k . '" SELECTED="SELECTED" >' . $k . '</OPTION>';
        } else {
            echo '<OPTION VALUE="' . $k . '" >' . $k . '</OPTION>';
        }
        
    }
    if ($auditor_count == 1) {
        if ($vendor_approve == 'NOIDA') {
            echo "<OPTION VALUE=\"NOIDA\" SELECTED=\"SELECTED\">NOIDA</OPTION>";
        } else {
            echo "<OPTION VALUE=\"NOIDA\">NOIDA</OPTION>";
        }
        if ($vendor_approve == 'DDN') {
            echo "<OPTION VALUE=\"DDN\" SELECTED=\"SELECTED\">DDN</OPTION>";
        } else {
            echo "<OPTION VALUE=\"DDN\">DDN</OPTION>";
        }
    }
    
    
    
    echo '</select>';
?>
   </td>
<td >&nbsp;Audited By: </td>
    <td>&nbsp;<select name="vendor_audit" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
    <?php
    $auditor_count = count($vendorArr);
    $vendorArr1    = array();
    $vendor_name   = '';
    if (count($vendorArr) == 1) {
        $vendor_name = $vendorArr[0];
        if (preg_match("/KOCHAR/i", $vendor_name)) {
            $vendorArr1 = array(
                'KOCHARTECHAUTO',
                'KOCHARTECHDNC',
                'KOCHARTECHLDH',
                'KOCHARTECHINTENT',
                'KOCHARTECHREVIEW'
            );
        } elseif (preg_match("/RADIATE/i", $vendor_name)) {
            $vendorArr1 = array(
                'RADIATEPNSTOBL',
                'RADIATEINTENT',
                'RADIATEPNSMRK',
                'RADIATEAUTO'
            );
        } elseif (preg_match("/VKALP/i", $vendor_name)) {
            $vendorArr1 = array(
                'VKALPDNC',
                'VKALPAUTOFRN',
                'VKALPAUTOIND',
                'VKALPINTENT',
                'VKALPREVIEW'
            );
        } else {
            $vendorArr1 = array(
                $vendor_name
            );
        }
    } else {
        $vendorArr1 = $vendorArr;
    }
    foreach ($vendorArr1 as $k) {
        if ($vendor_audit == $k) {
            echo '<OPTION VALUE="' . $k . '" SELECTED="SELECTED" >' . $k . '</OPTION>';
        } else {
            echo '<OPTION VALUE="' . $k . '" >' . $k . '</OPTION>';
        }
        
    }
    if ($auditor_count == 1) {
        if ($vendor_audit == 'NOIDA') {
            echo "<OPTION VALUE=\"NOIDA\" SELECTED=\"SELECTED\">NOIDA</OPTION>";
        } else {
            echo "<OPTION VALUE=\"NOIDA\">NOIDA</OPTION>";
        }
        if ($vendor_audit == 'DDN') {
            echo "<OPTION VALUE=\"DDN\" SELECTED=\"SELECTED\">DDN</OPTION>";
        } else {
            echo "<OPTION VALUE=\"DDN\">DDN</OPTION>";
        }
    }
    echo '</select>';
?>
   </td></tr>
   
     <tr>
     <td >&nbsp;Deletion Reason: </td>
    <td> <select name="deletedreasonselect" id="deletedreasonselect"style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
         <OPTION VALUE="ALL">ALL</OPTION>
         <?php
    foreach ($deletedreasonArr as $key => $value) {
        echo '<OPTION VALUE="' . $key . '">' . $value . '</OPTION>';
    }
?>
        </select>
        
    </td>
    <td WIDTH="20%">&nbsp;Sample type:</td>
    <td>   &nbsp;<input type="radio" name="sample_type" value="0" <?php
    echo (isset($_REQUEST['sample_type']) && $_REQUEST['sample_type'] == 0) ? 'CHECKED="CHECKED"' : '';
?> />All&nbsp;&nbsp;
               &nbsp;<input type="radio" name="sample_type" value="1"<?php
    echo (isset($_REQUEST['sample_type']) && $_REQUEST['sample_type'] == 1) ? 'CHECKED="CHECKED"' : '';
?> />Manual&nbsp;&nbsp;
               &nbsp; <input type="radio" name="sample_type" value="2"<?php
    echo (isset($_REQUEST['sample_type']) && $_REQUEST['sample_type'] == 2) ? 'CHECKED="CHECKED"' : '';
?> />Auto
    </td>

                    </tr> <tr>
   <td >&nbsp;Search by Offer Id: </td>
    <td >&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="offer_id" id="offer_id" value="<?php
    echo $offerid;
?>">
    </td>
      <td>&nbsp;Search by Audit Id:</td><td>
                    &nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="audit_id" id="audit_id" value="<?php
    echo $auditId;
?>"></td>
     </tr>   
     
    <tr id="trmain">
    <td >&nbsp;Team Leader: </td>
    <td colspan="3">&nbsp;<span name="team_leader" id="team_leader"></span>
    &nbsp;&nbsp;Associate:
    &nbsp;<span name="team_agent" id="team_agent"></span>
    &nbsp;&nbsp;QA:
    &nbsp;<span name="team_qa" id="team_qa"></span>
    </td>
     </tr>
    <tr>
        <td>&nbsp;Deleted by(Agent Id):</td><td>
&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="agent_id" id="agent_id" value="<?php echo $agent_id;?>"></td>
<td WIDTH="20%">&nbsp;Process Level:&nbsp; </td> <td>
<input type="checkbox" id="process_level0" name="process_level" value="5" <?php 
                if(preg_match("/5/i",@$_REQUEST['process_level_val'])){echo 'CHECKED';                
                }?>/>&nbsp;5&nbsp;&nbsp; 
<input type="checkbox" id="process_level1" name="process_level" value="6" <?php 
                if(preg_match("/6/i",@$_REQUEST['process_level_val'])){echo 'CHECKED';                
                }?> />&nbsp;6&nbsp;&nbsp;
<input type="checkbox" id="process_level2" name="process_level" value="7" <?php 
                if(preg_match("/7/i",@$_REQUEST['process_level_val'])){echo 'CHECKED';                
                }?>/>&nbsp;7&nbsp;&nbsp;

</td></tr><tr> <TD colspan="4" align="center">                      
    <input type="submit" name="submit_dump" id="submit_dump" value="Generate Report">&nbsp;&nbsp;
    <input type="submit" name="export_dump" id="export_dump" value="Export Dump">
    <input type="hidden" name="in_flag" value="0">
    <input type="hidden" name="action" value="generate">
    <input type="hidden" name="process_level_val" id="process_level_val" value="">
    <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
    </TD>
    </TR>
    </TABLE>        
<?php
    if (isset($_REQUEST['submit_dump'])) {
        if ($vendor_audit <> 'ALL') {
            $noofdays = 17;
        } else {
            $noofdays = 17;
        }
        if ($interval <= $noofdays) {
            //print_r($dataArr); 
            
            $tot_records                   = count($dataArr);
            $wrong_del_dis_selection_error = 0;
            $wrong_del_error               = 0;
            $can_be_approved               = 0;
            $can_be_flagged                = 0;
            $call_ettiquettes              = 0;
            $error_score                   = 0;
            
            $prevId  = '';
            $cnt     = 0;
            $html    = '';
            $row_num = 0;
            if ($tot_records > 0) {
                $html .= '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                
                for ($i = 0; $i < count($dataArr); $i++) {
                    if ($i == 0) {
                        $html .= '<tr style="background: #0195d3; color: white;"><td style="padding:4px;">S No</td>' . '<td style="padding:4px;">' . @$dataArr[$i][0] . '</td>                         
                                      <td style="padding:4px;">' . @$dataArr[$i][1] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][2] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][3] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][4] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][5] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][6] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][7] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][8] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][9] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][10] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][11] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][12] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][13] . '</td>                                      
                                      <td style="padding:4px;">' . @$dataArr[$i][14] . '</td><td style="padding:4px;">Raise Rebuttal</td>
                                      </tr>';
                    } else {
                        $remark_display = 0;
                        if ($dataArr[$i][7] == '-') {
                            $remark_display = 1;
                        }
                        $html .= '<tr><td style="padding:4px;">' . $i . '</td><td style="padding:4px;">' . @$dataArr[$i][0] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][1] . '</td>
                                    <td style="padding:4px;width:100px;">' . @$dataArr[$i][2] . '</td>
                                      <td style="padding:4px;">
                                      <a href="/index.php?r=admin_eto/BulkAuditEto/AuditMis_Edit&offer_id=' . @$dataArr[$i][4] . '&auditid='.@$dataArr[$i][3].'&mid=3549" style="text-decoration:none;color:#0000ff" target="_blank">' . @$dataArr[$i][3] . '</a>';
                        if ($permision == 4 && (preg_match("/DDN/", @$dataArr[$i][1]) == 0 && preg_match("/NOIDA/", @$dataArr[$i][1]) == 0)) {
                            $html .= '<br/><br/><div><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Index&tabselect=7&reaudit=1&offerID=' . @$dataArr[$i][4] . '\',\'_blank\',\'scrollbars=1,width=900, height=800\');" style="text-decoration:none;color:#0000ff"><font color="red">Re-Audit</font></a></div>';
                        }
                        $html .= '</td>
                                      <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . @$dataArr[$i][4] . '&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">' . @$dataArr[$i][4] . '</a></td>
                                      <td style="padding:4px;">' . @$dataArr[$i][5] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][6] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][7] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][8] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][9] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][10] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][11] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][12] . '</td>
                                      <td style="padding:4px;">' . @$dataArr[$i][13] . '</td>'
                                . '<td style="padding:4px;">' . @$dataArr[$i][14] . '</td>';
                        
                        if (@$dataArr[$i][15] == 'No') {
                            $html .= '<td style="padding:4px;position:relative;"><span id="Rebuttal_div' . $i . '"><input type="button" name="Raise_Rebuttal" id="Raise_Rebuttal" value="Raise Rebuttal" onclick="showCmplntForm(' . @$dataArr[$i][3] . ',' . @$dataArr[$i][4] . ',' . $i . ',' . $tot_records . ')"></span>
                                       <span id="cmplnt_div' . $i . '" class="cancel" style="display:none;" ></span>
                                      </td>';
                        } else {
                            $html .= '<td style="padding:4px;"><span id="cmplnt_div' . $i . '">Already Raised</span></td>';
                        }
                        $html .= '</tr>';
                        if ($dataArr[$i][9] != '-') {
                            $wrong_del_dis_selection_error++;
                        }
                        if ($dataArr[$i][10] != '-') {
                            $wrong_del_error++;
                        }
                        if ($dataArr[$i][11] != '-') {
                            $call_ettiquettes++;
                        }
                        if ($dataArr[$i][14] == '0') {
                            $error_score++;
                        }
                        
                    }
                    
                }
                $html .= "</table>";
                
            }
            $totalaudit = count($dataArr) - 1;
            
            if (count($dataArr) > 1) {
                echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #0195d3; color: white;">
                <td colspan="7" align="center" style="padding:4px;"><b>Quality Score Summary</b></td></tr>
                   <tr style="background: #dff8ff; color: white;"><td style="padding:4px;font-weight:bold;">Total Audits</td>' . '<td align="center" style="padding:4px;font-weight:bold;">Wrong Deletion Disposition Selection Error</td>' . '<td align="center" style="padding:4px;font-weight:bold;">Can be Approved Error</td>'. '<td align="center" style="padding:4px;font-weight:bold;">Can be Flagged Error</td>' . '<td align="center" style="padding:4px;font-weight:bold;">Call Etiquettes</td>' . '<td align="center" style="padding:4px;font-weight:bold;">Error Score</td>' . '</tr>';
                echo '<tr><td align="center" style="padding:4px;">' . $totalaudit . '</td>' . '<td align="center" style="padding:4px;">' . $wrong_del_dis_selection_error . '</td>' . '<td align="center" style="padding:4px;">' . $can_be_approved . '</td>' . '<td align="center" style="padding:4px;">' . $can_be_flagged . '</td>' . '<td align="center" style="padding:4px;">' . $call_ettiquettes . '</td>' . '<td align="center" style="padding:4px;">' . $error_score . '</td>' . '</tr>';
                echo '<tr><td align="center" style="padding:4px;">%</td>' . '<td align="center" style="padding:4px;">' . round((($wrong_del_dis_selection_error / $totalaudit) * 100), 2) . '</td>' . '<td align="center" style="padding:4px;">' . round((($wrong_del_error / $totalaudit) * 100), 2) . '</td>' . '<td align="center" style="padding:4px;">' . round((($call_ettiquettes / $totalaudit) * 100), 2) . '</td>' . '<td align="center" style="padding:4px;">' . round((($error_score / $totalaudit) * 100), 2) . '</td>' . '</tr>';
                echo '</table>';
                echo '<br><br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr><td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total ' . (count($dataArr) - 1) . ' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" style="display:none;" name="export_dump" id="export_dump" value="Export Dump"></td></tr></table><div style="width:100%;" >' . $html . '</div>';
            } else {
                echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;"> No Records Found</div>';
            }
            
        } else {
            echo '<div style="color:red;text-align:center;">Please Select Maximum Days Date Range</div>';
        }
        
    }
    
    echo '</FORM></div>
   
   <script>
  
    $(document).on(\'click\', function (e) {
    if(document.getElementById(\'cmplnt_div\'+temp1)){
        if ($(e.target).closest("#cmplnt_div"+temp1).length === 0) {
            if(temp3 !=1)
            {
            document.getElementById(\'cmplnt_div\'+temp1).style.display="none";
            }
        }
    }
  temp3=0;  
});

$( document ).on(\'keydown\', function ( e ) {
    if ( e.keyCode === 27 ) {
        if(document.getElementById(\'cmplnt_div\'+temp1)){
        document.getElementById(\'cmplnt_div\'+temp1).style.display="none";
        }
    }
});
 
    </script>
    </body>';
    
    
}

echo '<div style="clear:both;"><!-- --></div></div>';



?>