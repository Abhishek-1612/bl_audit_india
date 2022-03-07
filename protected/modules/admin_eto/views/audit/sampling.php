<?php 
$team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
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
               $("#tr4").hide();
               $("#tr6").hide();              
            }else{
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
               $("#tr4").hide();
               $("#tr6").hide();
           }else if ($("input[name='stype']:checked"). val()== 'ADV') {
               $("#trmain").show();
               $("#tr4").show();
               $("#tr6").show();
            }else{
                $("#trmain").hide();
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
                        a['stype_review']= $("input[name='stype_review']:checked"). val(); 
                        
                        if($("input[name='stype']:checked"). val() !='R'){                            
                             a['deletedsample']='NO';  
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
                            var process_level_val = '';
                            process_level_val = $('input[name="process_level"]:checked').map(function() {
                            return this.value;
                            }).get().join();
    
                            a['process_level']=process_level_val;
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
                        if($("input[name='stype']:checked"). val() =='R'){
                            a['bucket_per']=$('#bucket_per').val();                            
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
                             a['deletedsample']='NO';                            
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
$pool=isset($_REQUEST['pool']) ? $_REQUEST['pool'] : array();
$search=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
$stype=isset($_REQUEST['stype'])?$_REQUEST['stype']:'';
$start_date1=isset($start_date)?$start_date:'';

    ?><form name="sampleForm" id="sampleForm" method="post" action="/index.php?r=admin_eto/auditEto/Sampling&tabselect=3&mid=3549" style="margin-top:0;margin-bottom:0;">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Sample Data </b></font>             
              </td>   
              </TR>
              <TR id="tr1">
                <TD  CLASS="admintext">Search Type</TD>
                <TD colspan="3">      
                <input type="radio" id="s1" name="stype" value="" <?php echo ($stype=='') ?"checked":'' ?> >&nbsp;Default &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s2" name="stype" value="ADV"  <?php echo ($stype=="ADV")?"checked":'' ?> >&nbsp;Advanced&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s3" name="stype" value="R"  <?php echo ($stype=="R") ? "checked":'' ?> >&nbsp;Reviewed&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s4" name="stype" value="DNC"  <?php echo ($stype=="DNC") ? "checked":'' ?> >&nbsp;Flag for Calling&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s5" name="stype" value="BAN"  <?php echo ($stype=="BAN") ? "checked":'' ?> >&nbsp;BAN Pool Audit&nbsp;&nbsp;&nbsp;
                <span id="tr_calling_del" name="tr_calling_del" style="display:none;"><select name="calling_del" id="calling_del">
                      <OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="1">Product not Clear</option>
                        <option value="2">Approve with Call</option>
                        <option value="3">Name not clearly specified</option>
                        <option value="4">Generic Product</option>
                        <option value="5">Buyer Supplier Confusion</option>
                        <option value="6">Service Leads</option>
                        <option value="7">Multiple Product Requirement</option></select></span>
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
               </span></TD>
            </TR>
             <TR id="tr2">
              <td WIDTH="20%">&nbsp;Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date1; ?>" SIZE="13" onfocus="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly"></td>
              <td >&nbsp;Center Name: </td>
              <td>&nbsp;<div style="float:left;margin:0 100 0 0"><select onchange="Newfilter(this.value,'<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');" name="vendor_approval" id="vendor_approval" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
   <?php       $vendorArr1=array();
               if(count($vendorArr)==1){                                       
                     $vendor_name=key($vendorArr);
                     if(preg_match("/COMPETENT/i",$vendor_name)) {
                      $vendorArr1 = array('4'=>'COMPETENT','34'=>'COMPETENTDNC');
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('28'=>'KOCHARTECHAUTO','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('24'=>'RADIATEAUTO','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT','29'=>'VKALPREVIEW');       
                      }else{
                          $vendorArr1 = $vendorArr;
                      }
                }else{
                    
                        $vendorArr1 = $vendorArr;
                }
                
                
        foreach($vendorArr1 as  $key => $value)
        {
            if($vendor_approve == $key)
                {
                   echo '<OPTION VALUE="'.$key.'" SELECTED="SELECTED" >'.$value.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$key.'" >'.$value.'</OPTION>';
                }

        } echo '</select>';
        ?>
         
               </div>
    </td>
              </tr>
     <tr id="tr4">
    <td >&nbsp;Bucket: </td>
    <td><select id="bucket" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
            <?php
        $bucketArr=array('ALL','AON 0-30','Service Only','Retail Only','1 Sample Per Associate','2 Sample Per Associate','High AOV');
        foreach($bucketArr as $k)
    {
        if(isset($bucket) && $bucket == $k)
            {
                echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
            }
            else
            {
                echo "<OPTION VALUE=\"$k\"  >$k</OPTION>";
            }

    } echo '</select>';
        ?>
    </td>
     <td>&nbsp;Pool Type:</td>
    <td>
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="MUSTCALL" id="mustcall"  <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'MUSTCALL')?'CHECKED="CHECKED"':'' ?> name="pool" >&nbsp;Must Call
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="INTENT" id="intent" <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'INTENT')?'CHECKED="CHECKED"':'' ?>   name="pool" >&nbsp;Intent
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="DNC-INDIAN" id="dnc"  <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'DNC-INDIAN')?'CHECKED="CHECKED"':'' ?> name="pool" >&nbsp;DNC-Indian
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="DNC-FORIEGN" id="foreign" <?php echo (isset($_REQUEST['pool']) && $_REQUEST['pool'] == 'DNC-FORIEGN')?'CHECKED="CHECKED"':'' ?>  name="pool">&nbsp;Foreign
    <input type="hidden" name="poolVal" id="poolVal" value="">
    </td>
    </tr>
    <TR id="tr5">
    <td >&nbsp;Mail Sent To: </td>
    <td><select id="mailoption" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
            <?php
        $mailArr=array('Both','Me');
        foreach($mailArr as $k)
    {
        if(isset($mailoption) && $mailoption == $k)
            {
                echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
            }
            else
            {
                echo "<OPTION VALUE=\"$k\"  >$k</OPTION>";
            }

    } echo '</select>';?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Max Records:&nbsp;&nbsp;<select name="maxrecords" id="maxrecords" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
    <?php
        $recordsArr=array(5,10,15,20,25,30,40,50,60,70,80,90,100,120,140,160,180,200,220,240,260,280,300,400,500);
        foreach($recordsArr as $k)
    {
        if(isset($mailoption) && $maxrecords == $k)
            {
                echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
            }
            else
            {
                echo "<OPTION VALUE=\"$k\"  >$k</OPTION>";
            }

    } echo '</select></td>';
        ?>        
    <?php if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] =='DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] =='NOIDA'))
    {
    ?>
     <td ><b>Audit Sample For: </b></td>
     <td><input type="radio" name="audit_for" value="normal_audit" checked />Normal Audit&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="audit_for" value="super_audit" <?php echo (isset($_REQUEST['audit_for']) && $_REQUEST['audit_for'] == 'super_audit')?'CHECKED="CHECKED"':'' ?>/>Super Audit 
          
     </td>
    <?php } ?>
    
    </tr>
                 <tr id="tr6">
                       <td WIDTH="20%">&nbsp;Lead Type:</td>
                     <td><input type="checkbox" id="leadtype1" name="leadtype1" value="R" <?php echo (isset($_REQUEST['leadtype1']) && $_REQUEST['leadtype1'] == 'R')?'CHECKED="CHECKED"':'' ?> />Retail&nbsp;&nbsp;
                         <input type="checkbox" id="leadtype2" name="leadtype2" value="NR" <?php echo (isset($_REQUEST['leadtype2']) && $_REQUEST['leadtype2'] == 'NR')?'CHECKED="CHECKED"':'' ?>/>Non Retail&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp; <input type="checkbox" name="AOV" value="AOV" <?php echo (isset($_REQUEST['AOV']) && $_REQUEST['AOV'] == 'AOV')?'CHECKED="CHECKED"':'' ?>/>High AOV
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" value="shortcall" id="shortcall"  <?php echo (isset($_REQUEST['shortcall']) && $_REQUEST['shortcall'] == 'shortcall')?'CHECKED="CHECKED"':'' ?> name="shortcall" >&nbsp;Short Call</td>
                        
<td WIDTH="20%">&nbsp;Process Level:</td>
<td>
<input type="checkbox" id="process_level0" name="process_level" value="5" <?php echo (isset($_REQUEST['process_level0']) && $_REQUEST['process_level0'] == '5')?'CHECKED="CHECKED"':'' ?> />&nbsp;5&nbsp;&nbsp; 
<input type="checkbox" id="process_level1" name="process_level" value="6" <?php echo (isset($_REQUEST['process_level1']) && $_REQUEST['process_level1'] == '6')?'CHECKED="CHECKED"':'' ?> />&nbsp;6&nbsp;&nbsp;
<input type="checkbox" id="process_level2" name="process_level" value="7" <?php echo (isset($_REQUEST['process_level2']) && $_REQUEST['process_level1'] == '7')?'CHECKED="CHECKED"':'' ?>/>&nbsp;7&nbsp;&nbsp;
                     </td>                       
    </tr>
    <TR id="tr7">
                <TD  CLASS="admintext">Search Type</TD>
                <TD>      
                <input type="radio" id="stype_review_both" name="stype_review" value="0" checked > &nbsp;All &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="stype_review_auto" name="stype_review" value="-14">&nbsp;Auto Approved&nbsp;&nbsp;&nbsp;
                <input type="radio" id="stype_review_review" name="stype_review" value="-11">&nbsp;Review Approved&nbsp;&nbsp;&nbsp;
                </TD>
          <td >&nbsp;Bucket: </td>
    <td><select id="bucket_per" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
            <?php
    $bucketArr_per=array('ALL','1 Sample Per Associate','2 Sample Per Associate');
    foreach($bucketArr_per as $k)
    {
                echo "<OPTION VALUE=\"$k\"  >$k</OPTION>";
            
    } echo '</select>';
    ?>
    </td>
          
            </TR>

 

   
     <tr id="trmain">
    <td>&nbsp;Team Leader: </td>
    <td colspan="3"><span name="team_leader" id="team_leader"></span>
   &nbsp;&nbsp;Associate: 
   &nbsp;<span name="team_agent" id="team_agent"></span>
  &nbsp;&nbsp;QA: &nbsp;
    <span name="team_qa" id="team_qa"></span>
    </td>
    
    </tr>
                        <tr><TD colspan="4" align="center">                      
                        <input type="button" name="submit_view" id="submit_view" value="View Sample" onclick="check();">
                        &nbsp; &nbsp;<input type="button" name="submit_send" id="submit_send" value="Send Sample">
                        &nbsp; &nbsp;<button type="button" onclick="resetForm();">Reset</button>
                        <input type="hidden" name="in_flag" id="in_flag" value="0">
                        <input type="hidden" name="action" id="action" value="generate">
                        <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"></div>
                            </TD></tr>
                        </TABLE><div id="sampleresult" name="sampleresult"></div>
        
        
        
<?php   
 
  echo '</form>';
 
  echo '<div style="clear:both;"><!-- --></div></div>';

 
 
?>
