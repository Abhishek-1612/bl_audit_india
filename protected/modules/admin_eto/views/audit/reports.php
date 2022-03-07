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
$checkarch='';
$vendor1=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : array();
$pool=isset($_REQUEST['pool']) ? $_REQUEST['pool'] : array();
if(isset($_REQUEST['trend']) && $_REQUEST['trend'] =='tni')
{
 $display="";
}
else
{
 $display="none";
}

$Archive_data=isset($_REQUEST['Archive_data']) ? $_REQUEST['Archive_data'] :  '';
if(!empty($Archive_data))
$checkarch='checked';
$stype=isset($_REQUEST['stype'])?$_REQUEST['stype']:'';
$quetion_arr=array('Call_Opening','Phone_Etiquette','Valid_Probing','Call_Closing','Noise_on_Call','Wrong_Approval','Title','Information_Mis_call','Information_Mis_orig','MCAT_Selection','Supplier_Manual','Contact_Details','Grammar_Spelling','Reviewed','Deletion','Reposting');

     ?><form name="searchForm" id="searchForm" method="post" action="/index.php?r=admin_eto/auditEto/Reports&tabselect=5" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Reports</b></font>             
              </td>   
              </TR>
              <TR id="tr_search">
                <TD  CLASS="admintext">Search Type</TD>
                <TD colspan="3">      
                <input type="radio" id="s1" name="stype" value="" <?php echo ($stype=='') ?"checked":'' ?> >&nbsp;Default &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s2" name="stype" value="ADV"  <?php echo ($stype=="ADV")?"checked":'' ?> >&nbsp;Advanced&nbsp;&nbsp;&nbsp;
                </TD>
            </TR>
              <tr>

              <td WIDTH="20%">&nbsp;Audit Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
             
              <?php
              if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='monthly'))
              {
              ?>
              <div id="end_date1" style="margin-left:185px; margin-top:-20px;display:none;">
              <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div>
              <?php }
             
              else { ?>
             
              <div id="end_date1" style="margin-left:185px; margin-top:-20px;display:block;">
              <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div>
              <?php } ?>
              </td>
              
    <td >&nbsp;Auditor Type/Level:</td>
    <td>
    &nbsp;<input type="checkbox" value="ALL" id="ALL" <?php if(empty($vendor1) || in_array("ALL",$vendor1)) echo "checked"; ?> name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;ALL
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="EMP" id="EMP" <?php if(!empty($vendor1) && in_array("EMP",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;EMP
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="AGENT" id="AGENT" <?php if(!empty($vendor1) && in_array("AGENT",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;AGENT
   &nbsp;&nbsp;&nbsp;<input type="checkbox" value="TL" id="TL" <?php if(!empty($vendor1) && in_array("TL",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;TL
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="QA" id="QA" <?php if(!empty($vendor1) && in_array("QA",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;QA
   &nbsp;&nbsp;&nbsp;<input type="checkbox" value="MGR" id="MGR" <?php if(!empty($vendor1) && in_array("MGR",$vendor1)) echo "checked"; ?> name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;MGR
    </td>          
              </tr>
                          <tr>
    <td >&nbsp;Approved By: </td>
    <td >&nbsp;<select name="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;" onchange="Newfilter(this.value,'<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');">
    <?php       
                $vendorArr1=array();$vendor_name='';
                if(count($vendorArr)==1){
                    $vendor_name=$vendorArr[0];
                    if(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW');   
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
          echo '</select>';
        ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Archive_data" value="Archive_data" <?php echo $checkarch;?>>&nbsp;&nbsp;<b>Archive Data</b>      
    </td>
    <td >&nbsp;Audited By: </td>
    <td >&nbsp;<select name="vendor_audit" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
    <?php
        $auditor_count=count($vendorArr);
        
		$vendorArr1=array();$vendor_name='';
                if(count($vendorArr)==1){
                    $vendor_name=$vendorArr[0];
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');    
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW');      
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
                            echo "<OPTION VALUE=\"NOIDA\">NOIDA</OPTION>";
                            echo "<OPTION VALUE=\"DDN\">DDN</OPTION>";
                        }
       
        echo '</select>';
        ?>
    </td></tr>
    <tr>
   
    <td >&nbsp;Trend: </td>
    <td >&nbsp;<input type="radio" name="trend" id="trend" value="daily"
    <?php
    if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='daily') || !isset($_REQUEST['trend']))
    {
     echo ' checked';
    }
   
    ?>
    onclick="trend_check(1);">&nbsp;Daily
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trend" id="trend" value="monthly"
    <?php
    if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='monthly'))
    {
     echo ' checked';
    }
   
    ?>
    onclick="trend_check(2);">&nbsp;Monthly
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trend" id="trend" value="tni"
    <?php
    if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='tni'))
    {
     echo ' checked';
    }
  
    ?>
    onclick="trend_check(3);">&nbsp;TNI Report
    </td>
    
    </tr>
    <tr id="trend_format_row">
    <td >&nbsp;Trend Format: </td>
    <td colspan="1">&nbsp;<input type="radio" name="trend_format" id="trend_format" value="number"
    <?php
    if((isset($_REQUEST['trend_format']) && $_REQUEST['trend_format'] =='number') || !isset($_REQUEST['trend']))
    {
     echo ' checked';
    }
   
    ?>
    >&nbsp;Absolute Number
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trend_format" id="trend_format" value="percentage"
    <?php
    if((isset($_REQUEST['trend_format']) && $_REQUEST['trend_format'] =='percentage'))
    {
     echo ' checked';
    }
   
    ?>
    >&nbsp;Percentage
    </td>
    <td >&nbsp;Pool:</td>
    <td>
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="MUSTCALL" id="mustcall"  <?php if(!empty($pool) && in_array("MUSTCALL",$pool)) echo "checked"; ?>  name="pool[]" >&nbsp;Must Call
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="INTENT" id="intent" <?php  if(!empty($pool) && in_array("INTENT",$pool))  echo "checked"; ?>  name="pool[]" >&nbsp;Intent
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="DNC-INDIAN" id="dnc" <?php if(!empty($pool) && in_array("DNC-INDIAN",$pool)) echo "checked"; ?>  name="pool[]" >&nbsp;DNC-Indian
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="DNC-FORIEGN" id="foreign" <?php  if(!empty($pool) && in_array("DNC-FORIEGN",$pool)) echo "checked"; ?> name="pool[]">&nbsp;Foreign
    <input type="hidden" name="poolVal" id="poolVal" value="">
    </td>  
    
    </tr>
   
    <tr id="parameter_row" style="display:<?php echo $display ?>;">
    <td >&nbsp;Parameter: </td>
    <td colspan="3">&nbsp;
    <select name="parameter" id="parameter" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
        
        
    <?php  
     $QuesArray_new=array(1=>'Call Opening',2=>'Phone Etiquette',3=>'Valid Probing',4=>'Call Closing',5=>'Noise on Call',6=>'Wrong Approval',7=>'Title',8=>'Information Missing/Wrong (From Call)',9=>'Information Missing/Wrong (From Original/Existing)',10=>'MCAT Selection',11=>'Supplier Selection - Manual',12=>'Contact Details',13=>'Grammar and Spelling');
     for($i=1;$i<count($QuesArray_new);$i++){
      if(isset($_REQUEST['parameter']) && $_REQUEST['parameter'] ==$i)
        { 
           echo '<OPTION value="'.$i.'" selected>'.str_replace("_"," ",$QuesArray_new[$i]).'</OPTION>';
        } else { 
          echo '<OPTION value="'.$i.'" >'.str_replace("_"," ",$QuesArray_new[$i]).'</OPTION>';
        }  
    
    }
    ?>
   </select>
    </td>
    </tr>
   
    <tr>  <td WIDTH="20%">&nbsp;Lead Type:</td>
              <td ><input type="radio" name="leadtype" value="Both" checked/>Both&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="leadtype" value="R" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'R')?'CHECKED="CHECKED"':'' ?> />Retail&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="leadtype" value="NR" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'NR')?'CHECKED="CHECKED"':'' ?>/>Non Retail&nbsp;&nbsp;&nbsp;&nbsp;
                   <input type="radio" name="leadtype" value="AOV" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'AOV')?'CHECKED="CHECKED"':'' ?>/>High AOV
              </td>
        <td WIDTH="20%">&nbsp;Buyer Type:</td>
              <td ><input type="radio" name="buyer_type" value="" checked />All&nbsp;&nbsp;
                  <input type="radio" name="buyer_type" value="Frequent" <?php echo (isset($_REQUEST['buyer_type']) && $_REQUEST['buyer_type'] == 'Frequent')?'CHECKED="CHECKED"':'' ?>/>Frequent</td>
</tr>
   
    <tr id='trmain'>
    <td >&nbsp;Team Leader: </td>
    <td colspan="3">&nbsp;<span name="team_leader" id="team_leader"></span>
    &nbsp;&nbsp;&nbsp;&nbsp;Associate:
    &nbsp;<span name="team_agent" id="team_agent"></span>
   &nbsp;QA:
  &nbsp;<span name="team_qa" id="team_qa"></span>
    </td></tr>
   
   
    <tr><TD colspan="4" align="center">
    <input type="submit" name="submit_dump" id="submit_dump" value="Generate Report">
    <input type="hidden" name="in_flag" value="0">
    <input type="hidden" name="action" value="generate">
    <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
    </TD>
    </TR>
    </TABLE>
<?php              
    $stype=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';    
    $quetion_arr_1=array('Fail_Greetings','Fail_Self_and_Company_Introduction','Fail_Right_Party_Confirmation','Fail_Purpose_of_Call');        
    $quetion_arr_2=array('Fail_Rate_of_Speech','Fail_Active_Listening','Fail_Poor_Language_Expertise','Fail_Abusive-Rude-Sarcastic_-_ZTP','Fail_Dead_Air_and_Hold_Procedure');
    $quetion_arr_3=array('Fail_ISQ_Available_But_Not_Asked','Fail_Invalid/No_Probing','Fail_Application	Fail_Why_do_you_need_this','Fail_Quantity','Fail_Requirement_Type','Fail_Preferred_Supplier_Location','Fail_Requirement_Frequency','Fail_Order_Value');
    $quetion_arr_4=array('Fail_After_Call_Expectation_Setting','Fail_Thanking_Buyer');
    $quetion_arr_5=array('Fail_Technology_Issue','Fail_Near_By_Noise');
    $quetion_arr_6=array('Fail_Duplicate_Buy_Lead_-_Same_MCAT','Fail_Supplier_as_Buyer','Fail_Approved_Without_Consent/RPC','Fail_Grossly_Different_Requirement');
    $quetion_arr_7=array('Fail_Major_Spelling_Error','Fail_Different_Title','Fail_Too_Generic_Title');
    $quetion_arr_8=array('Fail_Description','Fail_ISQ','Fail_Application','Fail_Why_do_you_need_this','Fail_Quantity','Fail_Requirement_Type','Fail_Preferred_Supplier_Location','Fail_Requirement_Frequency','Fail_Order_Value','Fail_Supplier_Type');
    $quetion_arr_9=array('Fail_Description','Fail_ISQ','Fail_Application','Fail_Why_do_you_need_this','Fail_Quantity','Fail_Requirement_Type','Fail_Preferred_Supplier_Location','Fail_Requirement_Frequency','Fail_Order_Value','Fail_Supplier_Type');
    $quetion_arr_10=array('Fail_Wrong_Prime_MCAT_Selected','Fail_Wrong_MCAT_Selected','Fail_Right_MCAT_Deselected');
    $quetion_arr_11=array('Fail_Wrong_Search_Keyword','Fail_Wrong_Supplier_Selected','Fail_Correct_Supplier_Deselected');
    $quetion_arr_12=array('Fail_Name','Fail_Email','Fail_City','Fail_Company_Name','Fail_Mobile');
    $quetion_arr_13=array('Fail_Grammar','Fail_Spelling','Fail_Formatting_and_Presentation');
    $quetion_arr_14=array('Title_Review_Fail','Search_Keyword_Review_Fail','MCAT_review_Fail','Description_Review_Fail','ISQ_Review_Fail','Reposting_Required_Fail','Feedback_Wrong_disposition_selected_as_per_changes_made');
    $quetion_arr_15=array('Correct_Lead_Deletion_Fail','Wrong_deletion_disposition_selected_Fail','Reposting_required_but_deleted_Fail');
    $quetion_arr_16=array('Reposting_not_required_Fail','Wrong_Reposting_Disposition_Selection_Fail','Deletion_required_but_Reposted_Fail');   

      if(isset($_REQUEST['trend']) && $_REQUEST['trend'] =='daily')
         {
        if(isset($_REQUEST['submit_dump']) && $interval<=7)
        {
        $dailyArray=array();
        $dailyArrayFinal=array();
        $auditdate1='';
        $AON_0_30=0;
        $AON_GR_30=0;
        $m=0;
        usort($dataArr, function($a, $b) {
                return (strtotime($a[2]) - strtotime($b[2]));
                });

             for($i=1;$i<sizeof($dataArr);$i++)
                {
                 $k=0;
                  $auditdate=$dataArr[$i][2];
                  $auditdate=explode(' ',$auditdate);
                  $auditdate=$auditdate[0];
                  $auditdate=strtoupper($auditdate);
                  if($auditdate1 !=$auditdate)
                  {
                    $AON_0_30=0;
                    $AON_GR_30=0;
                    if(isset($dataArr[$i][29]) && $dataArr[$i][29] =='0-30')
                    {
                    $AON_0_30++;
                    }
                    if(isset($dataArr[$i][29]) && $dataArr[$i][29] !='0-30')
                    {
                    $AON_GR_30++;
                    }
                   
                    $j=0;
                    $dailyArray[$auditdate]['audit_date']=$auditdate;                  
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][8]))
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_1);$i_sub++){ 
                                $dailyArray[$auditdate]['1-'.$quetion_arr_1[$i_sub]]=0;
                        }
                    }
                    else
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_1);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_1[$i_sub])== $dataArr[$i][8])
                            {
                                $dailyArray[$auditdate]['1-'.$quetion_arr_1[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['1-'.$quetion_arr_1[$i_sub]]=0;
                            } 
                        }
                    }
                    //print_r($dailyArray[$auditdate]);die;
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][9]))
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_2);$i_sub++){ 
                            $dailyArray[$auditdate]['2-'.$quetion_arr_2[$i_sub]]=0;
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_2);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_2[$i_sub])== $dataArr[$i][9])
                            {
                                $dailyArray[$auditdate]['2-'.$quetion_arr_2[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['2-'.$quetion_arr_2[$i_sub]]=0;
                            } 
                        }
                    }
                   
                    
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][10]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_3);$i_sub++){                           
                                $dailyArray[$auditdate]['3-'.$quetion_arr_3[$i_sub]]=0;
                        }
                    }
                    else
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_3);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_3[$i_sub])== $dataArr[$i][10])
                            {
                                $dailyArray[$auditdate]['3-'.$quetion_arr_3[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['3-'.$quetion_arr_3[$i_sub]]=0;
                            } 
                        }
                    }
                   
                    
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][11]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                       for($i_sub=0;$i_sub<count($quetion_arr_4);$i_sub++){
                                $dailyArray[$auditdate]['4-'.$quetion_arr_4[$i_sub]]=0;
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_4);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_4[$i_sub])== $dataArr[$i][11])
                            {
                                $dailyArray[$auditdate]['4-'.$quetion_arr_4[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['4-'.$quetion_arr_4[$i_sub]]=0;
                            } 
                        }
                    }
                   
                   
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][12]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_5);$i_sub++){
                            $dailyArray[$auditdate]['5-'.$quetion_arr_5[$i_sub]]=0;
                        }
                    }
                    else
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_5);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_5[$i_sub])== $dataArr[$i][12])
                            {
                                $dailyArray[$auditdate]['5-'.$quetion_arr_5[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['5-'.$quetion_arr_5[$i_sub]]=0;
                            } 
                        }
                    }
                   
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][13]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_6);$i_sub++){
                                $dailyArray[$auditdate]['6-'.$quetion_arr_6[$i_sub]]=0;
                            }
                    }
                    else
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_6);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_6[$i_sub])== $dataArr[$i][13])
                            {
                                $dailyArray[$auditdate]['6-'.$quetion_arr_6[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['6-'.$quetion_arr_6[$i_sub]]=0;
                            } 
                        }
                    }
                   
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][14]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_7);$i_sub++){                           
                                $dailyArray[$auditdate]['7-'.$quetion_arr_7[$i_sub]]=0;
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_7);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_7[$i_sub])== $dataArr[$i][14])
                            {
                                $dailyArray[$auditdate]['7-'.$quetion_arr_7[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['7-'.$quetion_arr_7[$i_sub]]=0;
                            } 
                        }
                    }
                   
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][15]))
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                    for($i_sub=0;$i_sub<count($quetion_arr_8);$i_sub++){
                                $dailyArray[$auditdate]['8-'.$quetion_arr_8[$i_sub]]=0;
                            }
                    }
                    else
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_8);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_8[$i_sub])== $dataArr[$i][15])
                            {
                                $dailyArray[$auditdate]['8-'.$quetion_arr_8[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['8-'.$quetion_arr_8[$i_sub]]=0;
                            } 
                        }
                    }
                   if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][16]))
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_9);$i_sub++){ 
                          $dailyArray[$auditdate]['9-'.$quetion_arr_9[$i_sub]]=0;                             
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_9);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_9[$i_sub])== $dataArr[$i][16])
                            {
                                $dailyArray[$auditdate]['9-'.$quetion_arr_9[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['9-'.$quetion_arr_9[$i_sub]]=0;
                            } 
                        }
                    }
                   
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][17]))
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_10);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_10[$i_sub])== $dataArr[$i][17])
                            {
                                $dailyArray[$auditdate]['10-'.$quetion_arr_10[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['10-'.$quetion_arr_10[$i_sub]]=0;
                            } 
                        }
                    }
                    else
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_10);$i_sub++){
                                $dailyArray[$auditdate]['10-'.$quetion_arr_10[$i_sub]]=0;                             
                        }
                    }
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][18]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_11);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_11[$i_sub])== $dataArr[$i][18])
                            {
                                $dailyArray[$auditdate]['11-'.$quetion_arr_11[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['11-'.$quetion_arr_11[$i_sub]]=0;
                            } 
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_11);$i_sub++){
                                $dailyArray[$auditdate]['11-'.$quetion_arr_11[$i_sub]]=0;                           
                        }
                    }
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][19]))
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_12);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_12[$i_sub])== $dataArr[$i][19])
                            {
                                $dailyArray[$auditdate]['12-'.$quetion_arr_12[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['12-'.$quetion_arr_12[$i_sub]]=0;
                            } 
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_12);$i_sub++){
                                $dailyArray[$auditdate]['12-'.$quetion_arr_12[$i_sub]]=0;                             
                        }
                    }
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][20]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_13);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_13[$i_sub])== $dataArr[$i][20])
                            {
                                $dailyArray[$auditdate]['13-'.$quetion_arr_13[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['13-'.$quetion_arr_13[$i_sub]]=0;
                            } 
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_13);$i_sub++){ 
                                $dailyArray[$auditdate]['13-'.$quetion_arr_13[$i_sub]]=0;                             
                        }
                    }
                  //   echo '<pre>'.$k;print_r($quetion_arr);echo '</pre>';die;
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][20]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_14);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_14[$i_sub])== $dataArr[$i][20])
                            {
                                $dailyArray[$auditdate]['14-'.$quetion_arr_14[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['14-'.$quetion_arr_14[$i_sub]]=0;
                            } 
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_14);$i_sub++){ 
                                $dailyArray[$auditdate]['14-'.$quetion_arr_14[$i_sub]]=0;                             
                        }
                    }
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][20]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_15);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_15[$i_sub])== $dataArr[$i][20])
                            {
                                $dailyArray[$auditdate]['15-'.$quetion_arr_15[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['15-'.$quetion_arr_15[$i_sub]]=0;
                            } 
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_15);$i_sub++){ 
                                $dailyArray[$auditdate]['15-'.$quetion_arr_15[$i_sub]]=0;                             
                        }
                    }
                    if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][20]))
                    {
                        $dailyArray[$auditdate][$quetion_arr[$k++]]=1;
                        for($i_sub=0;$i_sub<count($quetion_arr_16);$i_sub++){ 
                           if (str_replace("_"," ",$quetion_arr_16[$i_sub])== $dataArr[$i][20])
                            {
                                $dailyArray[$auditdate]['16-'.$quetion_arr_16[$i_sub]]=1;
                            }else{
                                $dailyArray[$auditdate]['16-'.$quetion_arr_16[$i_sub]]=0;
                            } 
                        }
                    }
                    else
                    {
                    $dailyArray[$auditdate][$quetion_arr[$k++]]=0;
                        for($i_sub=0;$i_sub<count($quetion_arr_16);$i_sub++){ 
                                $dailyArray[$auditdate]['16-'.$quetion_arr_16[$i_sub]]=0;                             
                        }
                    }
                    
                   
                   //$CALL_OPENING==1) && ($Phone_Etiquette==1) && ($Valid_Probing==1) && ($Call_Closing==1) && ($Noise_on_Call==1
                    if(preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][8]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][9]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][10]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][11]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][12]))
                    {
                    $Call_Score_over_all=1;
                    }
                    else
                    {
                     $Call_Score_over_all=0;
                    }
                   //$Wrong_Approval==1) && ($Title==1) && ($Information_Mis_call==1) && ($Information_Mis_orig==1) && ($MCAT_Selection==1) && ($Supplier_Manual==1) &&  ($Contact_Details==1) && ($Grammar_Spelling==1)
                    if(preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][13]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][14]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][15]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][16]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][17]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][18]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][19]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][20]))
                    {
                     $Lead_Score_over_all=1;
                     }
                     else
                     {
                      $Lead_Score_over_all=0;
                     }
                    if(preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][14]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][15]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][16]))
                    {
                     $Review_Score=1;
                     }
                     else
                     {
                      $Review_Score=0;
                     }
                    $dailyArray[$auditdate]['Call_Score_over_all']=$Lead_Score_over_all;
                    $dailyArray[$auditdate]['Lead_Score_over_all']=$Lead_Score_over_all;
                   
                    $dailyArray[$auditdate]['Call_Score']=$dataArr[$i][23];
                    $dailyArray[$auditdate]['Lead_Score']=$dataArr[$i][24];
                    $dailyArray[$auditdate]['Noise_Score']=$dataArr[$i][25];
                    $dailyArray[$auditdate]['Formating_Score']=$dataArr[$i][26];
                    $dailyArray[$auditdate]['Score_Excluding']=$dataArr[$i][27];                    
                    $dailyArray[$auditdate]['Score_including']=$dataArr[$i][28];
                    $dailyArray[$auditdate]['Review_Score']=$Review_Score;
                    $dailyArray[$auditdate]['AON_0_30']=$AON_0_30;
                    $dailyArray[$auditdate]['AON_GR_30']=$AON_GR_30;
                    $j++;
                    $dailyArray[$auditdate]['audit_count']=$j;
                    $dailyArray['audit_date'][$m]=$auditdate;
                    $m++;
                    
                  }
                  else
                  {
                   $k=0;
                  if(isset($dataArr[$i][29]) && $dataArr[$i][29] =='0-30')
                  {
                   $AON_0_30++;
                  }
                  if(isset($dataArr[$i][29]) && $dataArr[$i][29] !='0-30')
                  {
                   $AON_GR_30++;
                  }
                   $j++;
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][8]))
                  {
                    $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;                   
                  }
                  else
                  {
                    $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_1);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_1[$i_sub])== $dataArr[$i][8])
                            {
                                $dailyArray[$auditdate]['1-'.$quetion_arr_1[$i_sub]]=$dailyArray[$auditdate]['1-'.$quetion_arr_1[$i_sub]] + 1;
                            }
                    }
                  }
                 
                 if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][9]))
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;                  
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_2);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_2[$i_sub])== $dataArr[$i][9])
                            {
                                $dailyArray[$auditdate]['2-'.$quetion_arr_2[$i_sub]]=$dailyArray[$auditdate]['2-'.$quetion_arr_2[$i_sub]] + 1;
                            } 
                    }
                  }
                 
                 if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][10])) {
                    $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;                    
                  }
                  else
                  {
                    $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_3);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_3[$i_sub])== $dataArr[$i][10])
                            {
                                $dailyArray[$auditdate]['3-'.$quetion_arr_3[$i_sub]]=$dailyArray[$auditdate]['3-'.$quetion_arr_3[$i_sub]] + 1;
                            }
                    }
                  }
                 
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][11])) {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_4);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_4[$i_sub])== $dataArr[$i][11])
                            {
                                $dailyArray[$auditdate]['4-'.$quetion_arr_4[$i_sub]]=$dailyArray[$auditdate]['4-'.$quetion_arr_4[$i_sub]] + 1;
                            }
                    }
                  }
                 
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][12])){
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                   
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_5);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_5[$i_sub])== $dataArr[$i][12])
                            {
                                $dailyArray[$auditdate]['5-'.$quetion_arr_5[$i_sub]]=$dailyArray[$auditdate]['5-'.$quetion_arr_5[$i_sub]] + 1;
                            }
                    }
                  }
                 
                 if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][13])) {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_6);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_6[$i_sub])== $dataArr[$i][13])
                            {
                                $dailyArray[$auditdate]['6-'.$quetion_arr_6[$i_sub]]=$dailyArray[$auditdate]['6-'.$quetion_arr_6[$i_sub]] + 1;
                            }
                    }
                  }
                 
                 if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][14]))
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_7);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_7[$i_sub])== $dataArr[$i][14])
                            {
                                $dailyArray[$auditdate]['7-'.$quetion_arr_7[$i_sub]]=$dailyArray[$auditdate]['7-'.$quetion_arr_7[$i_sub]] + 1;
                            }
                    }
                  }
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][15]))
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_8);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_8[$i_sub])== $dataArr[$i][15])
                            {
                                $dailyArray[$auditdate]['8-'.$quetion_arr_8[$i_sub]]=$dailyArray[$auditdate]['8-'.$quetion_arr_8[$i_sub]] + 1;
                            }
                    }
                  }
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][16]))
                  {
                    $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                    $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_9);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_9[$i_sub])== $dataArr[$i][16])
                            {
                                $dailyArray[$auditdate]['9-'.$quetion_arr_9[$i_sub]]=$dailyArray[$auditdate]['9-'.$quetion_arr_9[$i_sub]] + 1;
                            }
                    }
                  }
                 
                 
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][17]))
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_10);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_10[$i_sub])== $dataArr[$i][17])
                            {
                                $dailyArray[$auditdate]['10-'.$quetion_arr_10[$i_sub]]=$dailyArray[$auditdate]['10-'.$quetion_arr_10[$i_sub]] + 1;
                            }
                    }
                  }
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][18])){
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                    for($i_sub=0;$i_sub<count($quetion_arr_11);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_11[$i_sub])== $dataArr[$i][18])
                            {
                                $dailyArray[$auditdate]['11-'.$quetion_arr_11[$i_sub]]=$dailyArray[$auditdate]['11-'.$quetion_arr_11[$i_sub]] + 1;
                            }
                    }
                  }
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][19])){
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  { 
                    for($i_sub=0;$i_sub<count($quetion_arr_12);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_12[$i_sub])== $dataArr[$i][19])
                            {
                                $dailyArray[$auditdate]['12-'.$quetion_arr_12[$i_sub]]=$dailyArray[$auditdate]['12-'.$quetion_arr_12[$i_sub]] + 1;
                            }
                    }
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                  }
                  if (preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][20])){
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]] + 1;$k++;
                  }
                  else
                  {
                    for($i_sub=0;$i_sub<count($quetion_arr_13);$i_sub++){ 
                           if(str_replace("_"," ",$quetion_arr_13[$i_sub])== $dataArr[$i][20])
                            {
                                $dailyArray[$auditdate]['13-'.$quetion_arr_13[$i_sub]]=$dailyArray[$auditdate]['13-'.$quetion_arr_13[$i_sub]] + 1;
                            }
                    }
                   $dailyArray[$auditdate][$quetion_arr[$k]]=$dailyArray[$auditdate][$quetion_arr[$k]];$k++;
                  }
                  
                  if(preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][8]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][9]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][10]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][11]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][12]))
                    {
                    $Call_Score_over_all1=1;
                    }
                    else
                    {
                     $Call_Score_over_all1=0;
                    }
                   
                    if(preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][13]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][14]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][15]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][16]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][17]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][18]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][19]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][20]))
                    {  
                        $Lead_Score_over_all1=1;
                     }
                     else
                     {
                      $Lead_Score_over_all1=0;
                     } 
                   if(preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][14]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][15]) && preg_match("/Pass|Feedback|Not Applicable/i", $dataArr[$i][16]))
                    {
                     $Review_Score=1;
                     }
                     else
                     {
                      $Review_Score=0;
                     }
                   $dailyArray[$auditdate]['audit_date']=$auditdate; 
                   $dailyArray[$auditdate]['Call_Score_over_all']=$dailyArray[$auditdate]['Call_Score_over_all']+$Call_Score_over_all1;
                   $dailyArray[$auditdate]['Lead_Score_over_all']=$dailyArray[$auditdate]['Lead_Score_over_all']+$Lead_Score_over_all1;                  
                   $dailyArray[$auditdate]['Call_Score']=$dailyArray[$auditdate]['Call_Score'] + $dataArr[$i][23];
                   $dailyArray[$auditdate]['Lead_Score']=$dailyArray[$auditdate]['Lead_Score'] + $dataArr[$i][24];
                   $dailyArray[$auditdate]['Noise_Score']=$dailyArray[$auditdate]['Noise_Score'] + $dataArr[$i][25];
                   $dailyArray[$auditdate]['Formating_Score']=$dailyArray[$auditdate]['Formating_Score'] + $dataArr[$i][26];
                   $dailyArray[$auditdate]['Score_Excluding']=$dailyArray[$auditdate]['Score_Excluding'] + $dataArr[$i][27];
                   $dailyArray[$auditdate]['Score_including']=$dailyArray[$auditdate]['Score_including'] + $dataArr[$i][28];
                   $dailyArray[$auditdate]['Review_Score']=$Review_Score;
                   $dailyArray[$auditdate]['AON_0_30']=$AON_0_30;
                   $dailyArray[$auditdate]['AON_GR_30']=$AON_GR_30;
                   $dailyArray[$auditdate]['audit_count']=$j;
                  // echo 'hh';print_r($dailyArray[$auditdate]);die;
                  }
                // print_r($dailyArray[$auditdate]);die;
                $auditdate1=$auditdate; 
                }
               // print_r($dailyArray[$auditdate]);//die;
                if(!empty($dailyArray)){
                 $colspan=sizeof($dailyArray['audit_date'])+1;
               
              echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #0195d3; color: white;">
                <td align="left" style="padding:4px;"><b>Day Wise</b></td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$dailyArray['audit_date'][$i].'</b></td>';
                }
                echo '</tr>';
               
         if((isset($_REQUEST['trend_format']) && $_REQUEST['trend_format'] =='percentage')){
               
                   echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Summary</b></td></tr>';
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Audits</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Call_Score_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Call_Score']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 
                  $Call_Score_per = sprintf('%0.2f', $Call_Score_per);
               
                  echo '<td align="center" style="padding:4px;">'.$Call_Score_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Lead Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                 $Lead_Score_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Lead_Score']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 $Lead_Score_per = sprintf('%0.2f', $Lead_Score_per);
                  echo '<td align="center" style="padding:4px;">'.$Lead_Score_per.'%</td>';
                }
                echo '</tr>';
               
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Noise Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Noise_Score_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Noise_Score']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Noise_Score_per = sprintf('%0.2f', $Noise_Score_per);
                  echo '<td align="center" style="padding:4px;">'.$Noise_Score_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Formatting Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Formating_Score_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Formating_Score']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Formating_Score_per = sprintf('%0.2f', $Formating_Score_per);
                  echo '<td align="center" style="padding:4px;">'.$Formating_Score_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Quality Score Excluding Noise+Formatting</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Score_Excluding_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Score_Excluding']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 
                  $Score_Excluding_per = sprintf('%0.2f', $Score_Excluding_per);
                  echo '<td align="center" style="padding:4px;">'.$Score_Excluding_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Review Score</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                   $Review_Score_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Review_Score']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                    $Review_Score_per = sprintf('%0.2f', $Review_Score_per);
                  echo '<td align="center" style="padding:4px;">'.$Review_Score_per.'%</td>';
                }
                echo '</tr><tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Detailed</b></td></tr>';
               
               
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Parameter Wise</b></td></tr>';
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td  align="left" style="padding:4px;"><b>Call Quality</b></td>';
                 for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                 
                 $Call_Quality_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Call_Score_over_all']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 $Call_Quality_per = sprintf('%0.2f', $Call_Quality_per);
                 
                  echo '<td align="center" style="padding:4px;"><b>'.$Call_Quality_per.'%</b></td>';
                }
               
                echo '</tr><tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Opening</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                 $Call_Opening_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Call_Opening']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 $Call_Opening_per = sprintf('%0.2f', $Call_Opening_per);
                 echo '<td align="center" style="padding:4px;">'.$Call_Opening_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Phone Etiquette</td>';
                 for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                 $Phone_Etiquette_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Phone_Etiquette']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 $Phone_Etiquette_per = sprintf('%0.2f', $Phone_Etiquette_per);
                 echo '<td align="center" style="padding:4px;">'.$Phone_Etiquette_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Valid Probing</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Valid_Probing_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Valid_Probing']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Valid_Probing_per = sprintf('%0.2f', $Valid_Probing_per);
                  echo '<td align="center" style="padding:4px;">'.$Valid_Probing_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Closing</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Call_Closing_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Call_Closing']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                   $Call_Closing_per = sprintf('%0.2f', $Call_Closing_per);
                  echo '<td align="center" style="padding:4px;">'.$Call_Closing_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Noise On Call</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                 $Noise_on_Call_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Noise_on_Call']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 $Noise_on_Call_per = sprintf('%0.2f', $Noise_on_Call_per);
                 echo '<td align="center" style="padding:4px;">'.$Noise_on_Call_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="background: #dff8ff; color: white;">
                <td  align="left" style="padding:4px;"><b>Lead Quality</b></td>';
               
                 for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                 
                 $Lead_Quality_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Lead_Score_over_all']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 $Lead_Quality_per = sprintf('%0.2f', $Lead_Quality_per);
                 
                  echo '<td align="center" style="padding:4px;"><b>'.$Lead_Quality_per.'%</b></td>';
                }
               
               
                 echo '</tr><tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Wrong Approval</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                 
                   $Wrong_Approval_Call_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Wrong_Approval']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Wrong_Approval_Call_per = sprintf('%0.2f', $Wrong_Approval_Call_per);
                  echo '<td align="center" style="padding:4px;">'.$Wrong_Approval_Call_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Title</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Title_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Title']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Title_per = sprintf('%0.2f', $Title_per);
                  echo '<td align="center" style="padding:4px;">'.$Title_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Information Missing/Wrong (From Call)</td>';
               for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Information_Mis_call_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Information_Mis_call']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                   $Information_Mis_call_per = sprintf('%0.2f', $Information_Mis_call_per);
                  echo '<td align="center" style="padding:4px;">'.$Information_Mis_call_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Information Missing/Wrong (From Original/Existing)</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Information_Mis_orig_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Information_Mis_orig']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Information_Mis_orig_per = sprintf('%0.2f', $Information_Mis_orig_per);
                  echo '<td align="center" style="padding:4px;">'.$Information_Mis_orig_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">MCAT Selection</td>';
               for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                   $MCAT_Selection_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['MCAT_Selection']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $MCAT_Selection_per = sprintf('%0.2f', $MCAT_Selection_per);
                 echo '<td align="center" style="padding:4px;">'.$MCAT_Selection_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Supplier Selection - Manual</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Supplier_Manual_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Supplier_Manual']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                 $Supplier_Manual_per = sprintf('%0.2f', $Supplier_Manual_per);
                echo '<td align="center" style="padding:4px;">'.$Supplier_Manual_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Contact Details</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Contact_Details_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Contact_Details']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Contact_Details_per = sprintf('%0.2f', $Contact_Details_per);
                  echo '<td align="center" style="padding:4px;">'.$Contact_Details_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Grammar and Spelling</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Grammar_Spelling_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Grammar_Spelling']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Grammar_Spelling_per = sprintf('%0.2f', $Grammar_Spelling_per);
                  echo '<td align="center" style="padding:4px;">'.$Grammar_Spelling_per.'%</td>';
                }
                echo '</tr>';
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Reviewed</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Reviewed_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Reviewed']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Reviewed_per = sprintf('%0.2f', $Reviewed_per);
                  echo '<td align="center" style="padding:4px;">'.$Reviewed_per.'%</td>';
                }
                echo '</tr>';
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Deletion</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Deletion_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Deletion']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Deletion_per = sprintf('%0.2f', $Deletion_per);
                  echo '<td align="center" style="padding:4px;">'.$Deletion_per.'%</td>';
                }
                echo '</tr>';
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Reposting</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  $Reposting_per=round(($dailyArray[$dailyArray['audit_date'][$i]]['Reviewed']/$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'])*100,2);
                  $Reviewed_per = sprintf('%0.2f', $Reposting_per);
                  echo '<td align="center" style="padding:4px;">'.$Reposting_per.'%</td>';
                }
                echo '</tr>';
                
               
     }
   else
        {
        
               
                echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Summary</b></td></tr>';
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Audits</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['audit_count'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['Call_Score'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Lead Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['Lead_Score'].'</td>';
                }
                echo '</tr>';
               
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Noise Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['Noise_Score'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Formatting Quality</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['Formating_Score'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Quality Score Excluding Noise+Formatting</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['Score_Excluding'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Quality Score Including Noise+Formatting</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['Score_including'].'</td>';
                }
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Review Score</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['Review_Score'].'</td>';
                }
                echo '</tr><tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Detailed</b></td></tr>';
               
               
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Parameter Wise</b></td></tr>';
               
                              
                for($i_cnt=0;$i_cnt<count($quetion_arr);$i_cnt++)
                {
                    if($i_cnt==0){
                            echo '<tr style="background: #dff8ff; color: white;">
                            <td  align="left" style="padding:4px;"><b>Call Quality</b></td>';               
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;"><b>'.$dailyArray[$dailyArray['audit_date'][$i]]['Call_Score_over_all'].'</b></td>';
                            }
                            echo '</tr>'; 
                    }
                    if($i_cnt==5){
                            echo '<tr style="background: #dff8ff; color: white;">
                            <td  align="left" style="padding:4px;"><b>Lead Quality</b></td>';               
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;"><b>'.$dailyArray[$dailyArray['audit_date'][$i]]['Lead_Score_over_all'].'</b></td>';
                            }
                            echo '</tr>'; 
                       }
                    echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:20px;">'.str_replace("_"," ",$quetion_arr[$i_cnt]).'</td>';
                    for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                    {                       
                      echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]][$quetion_arr[$i_cnt]].'</td>';
                    }
                    echo '</tr>';
                    if($i_cnt==0){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_1);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'1-'.$quetion_arr_1[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['1-'.$quetion_arr_1[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==1){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_2);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'2-'.$quetion_arr_2[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['2-'.$quetion_arr_2[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==2){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_3);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'3-'.$quetion_arr_3[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['3-'.$quetion_arr_3[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==3){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_4);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'4-'.$quetion_arr_4[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['4-'.$quetion_arr_4[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==4){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_5);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'5-'.$quetion_arr_5[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['5-'.$quetion_arr_5[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==5){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_6);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'6-'.$quetion_arr_6[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['6-'.$quetion_arr_6[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==6){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_7);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'7-'.$quetion_arr_7[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['7-'.$quetion_arr_7[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==7){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_8);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'8-'.$quetion_arr_8[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['8-'.$quetion_arr_8[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==8){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_9);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'9-'.$quetion_arr_9[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['9-'.$quetion_arr_9[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==9){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_10);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'10-'.$quetion_arr_10[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['10-'.$quetion_arr_10[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==10){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_11);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'11-'.$quetion_arr_11[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['11-'.$quetion_arr_11[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==11){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_12);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'12-'.$quetion_arr_12[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['12-'.$quetion_arr_12[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==12){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_13);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'13-'.$quetion_arr_13[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['13-'.$quetion_arr_13[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==13){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_14);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'14-'.$quetion_arr_14[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['14-'.$quetion_arr_14[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==14){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_15);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'15-'.$quetion_arr_15[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['15-'.$quetion_arr_15[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    if($i_cnt==15){
                        for($i_cnt_sub=0;$i_cnt_sub<count($quetion_arr_16);$i_cnt_sub++)
                        {
                            echo '<tr style="color: white;"><td align="left" style="padding:4px;padding-left:40px;color:red;">'.str_replace("_"," ",'16-'.$quetion_arr_16[$i_cnt_sub]).'</td>';
                            for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                            {
                              echo '<td align="center" style="padding:4px;color:red;">'.$dailyArray[$dailyArray['audit_date'][$i]]['16-'.$quetion_arr_16[$i_cnt_sub]].'</td>';
                            }
                            echo '</tr>';
                        }
                    }
                }
       }
               
                echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Audit Count</b></td></tr>';
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>AON Wise</b></td></tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">0-30 Days Old</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['AON_0_30'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">>30 Days Old</td>';
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$dailyArray[$dailyArray['audit_date'][$i]]['AON_GR_30'].'</td>';
                }
                echo '</tr>';
               
        ###TL Wise DATA Start---------------------
                $arrayTL=array();
                $n=0;
                $emp_name=array();
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  for($j=0;$j<sizeof($rec2);$j++)
                  {
                    $rec2[$j]=array_change_key_case($rec2[$j], CASE_UPPER);
                    $temp_date=explode(' ',$rec2[$j]['BL_AUDIT_RESPONSE_DATE']);
                    $rec2[$j]['BL_AUDIT_RESPONSE_DATE']=$temp_date[0];
                     if(strtoupper($dailyArray['audit_date'][$i])==$rec2[$j]['BL_AUDIT_RESPONSE_DATE'])
              {
                        $arrayTL[$rec2[$j]['ETO_LEAP_EMP_NAME']][$dailyArray['audit_date'][$i]]=$rec2[$j]['COUNT'];
                        if(!in_array($rec2[$j]['ETO_LEAP_EMP_NAME'],$emp_name))
                        {
                        $arrayTL['emp'][$n]=$rec2[$j]['ETO_LEAP_EMP_NAME'];
                        $n++;
                        }
                        array_push($emp_name,$rec2[$j]['ETO_LEAP_EMP_NAME']);
              }
             
                  }
                }
              
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>TL Wise Audit Count</b></td></tr>';
                 if(!empty($arrayTL['emp']))
                 sort($arrayTL['emp']);
                for($i=0;$i<sizeof($arrayTL)-1;$i++)
                {
                   if(empty($arrayTL['emp'][$i]))
                   $tl_name='Without TL';
                   else
                   $tl_name=$arrayTL['emp'][$i];
                  
                   echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">'.$tl_name.'</td>';
                   for($m=0;$m<sizeof($dailyArray['audit_date']);$m++)
            {
             if(array_key_exists($dailyArray['audit_date'][$m], $arrayTL[$arrayTL['emp'][$i]]))
             echo '<td align="center" style="padding:4px;">'.$arrayTL[$arrayTL['emp'][$i]][$dailyArray['audit_date'][$m]].'</td>';
             else
             echo '<td align="center" style="padding:4px;">0</td>';
            }
                  echo '</tr>';
                }
                 ###TL Wise DATA End---------------------
                
               ### Audit Wise DATA Start---------------------
              
                $arrayTL=array();
                $n=0;
                $emp_name=array();
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  for($j=0;$j<sizeof($rec3);$j++)
                  {
                    $rec3[$j]=array_change_key_case($rec3[$j], CASE_UPPER);
                    $temp_date=explode(' ',$rec3[$j]['BL_AUDIT_RESPONSE_DATE']);
                    $rec3[$j]['BL_AUDIT_RESPONSE_DATE']=$temp_date[0];
                     if(strtoupper($dailyArray['audit_date'][$i])==$rec3[$j]['BL_AUDIT_RESPONSE_DATE'])
              {
                        $arrayTL[$rec3[$j]['ETO_LEAP_EMP_NAME']][$dailyArray['audit_date'][$i]]=$rec3[$j]['COUNT'];
                        if(!in_array($rec3[$j]['ETO_LEAP_EMP_NAME'],$emp_name))
                        {
                        $arrayTL['emp'][$n]=$rec3[$j]['ETO_LEAP_EMP_NAME'];
                        $n++;
                        }
                        array_push($emp_name,$rec3[$j]['ETO_LEAP_EMP_NAME']);
              }
             
                  }
                }
            
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>QA Audit Count</b></td></tr>';
                if(!empty($arrayTL['emp']))
                sort($arrayTL['emp']);
                for($i=0;$i<sizeof($arrayTL)-1;$i++)
                {
                   echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">'.$arrayTL['emp'][$i].'</td>';
                   for($m=0;$m<sizeof($dailyArray['audit_date']);$m++)
            {
             if(array_key_exists($dailyArray['audit_date'][$m], $arrayTL[$arrayTL['emp'][$i]]))
             echo '<td align="center" style="padding:4px;">'.$arrayTL[$arrayTL['emp'][$i]][$dailyArray['audit_date'][$m]].'</td>';
             else
             echo '<td align="center" style="padding:4px;">0</td>';
            }
                  echo '</tr>';
                }
                 ###Audit Wise DATA End---------------------                
                
                 ### QA Wise DATA Start---------------------
                $arrayTL=array();
                $n=0;
                $emp_name=array();
                for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                {
                  for($j=0;$j<sizeof($rec4);$j++)
                  {
                    $rec4[$j]=array_change_key_case($rec4[$j], CASE_UPPER);
                    $temp_date=explode(' ',$rec4[$j]['BL_AUDIT_RESPONSE_DATE']);
                    $rec4[$j]['BL_AUDIT_RESPONSE_DATE']=$temp_date[0];
                     if(strtoupper($dailyArray['audit_date'][$i])==$rec4[$j]['BL_AUDIT_RESPONSE_DATE'])
              {
                        $arrayTL[$rec4[$j]['ETO_LEAP_EMP_NAME']][$dailyArray['audit_date'][$i]]=$rec4[$j]['COUNT'];
                        if(!in_array($rec4[$j]['ETO_LEAP_EMP_NAME'],$emp_name))
                        {
                        $arrayTL['emp'][$n]=$rec4[$j]['ETO_LEAP_EMP_NAME'];
                        $n++;
                        }
                        array_push($emp_name,$rec4[$j]['ETO_LEAP_EMP_NAME']);
              }
             
                  }
                }               

                ###### QA Wise DATA End---------------------
                $arrayHeadcount=array();
                $arrayHeadcount1=array();
                $arrayDatehead=array();
                for($i=0;$i<sizeof($rec5);$i++)
                {
                $rec5[$i]=array_change_key_case($rec5[$i], CASE_UPPER);
                $arrayDatehead['ETO_OFR_APPROV_DATE_ORIG'][$i]=$rec5[$i]['ETO_OFR_APPROV_DATE_ORIG'];
                $arrayHeadcount[$rec5[$i]['ETO_OFR_APPROV_DATE_ORIG']]=$rec5[$i]['COUNT'];
                }
               
                for($j=0;$j<sizeof($dailyArray['audit_date']);$j++)
                {
               
               
                if(!empty($arrayDatehead['ETO_OFR_APPROV_DATE_ORIG']) && in_array($dailyArray['audit_date'][$j],$arrayDatehead['ETO_OFR_APPROV_DATE_ORIG']))
                {
                  $arrayHeadcount1[$dailyArray['audit_date'][$j]]=$arrayHeadcount[$dailyArray['audit_date'][$j]];
                }
                else
                {
                 $arrayHeadcount1[$dailyArray['audit_date'][$j]]=0;
                }
               }
               
       
                echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Audit Per Associate</b></td></tr>';
                echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">Associate HC</td>';
                
                 for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                 {
                  echo '<td align="center" style="padding:4px;">'.$arrayHeadcount1[$dailyArray['audit_date'][$i]].'</td>';
                 }
                
                 echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">Audit Per Associate</td>';
                  for($i=0;$i<sizeof($dailyArray['audit_date']);$i++)
                   {
                     $AON_0_30=$dailyArray[$dailyArray['audit_date'][$i]]['AON_0_30'];
                     $AON_GR_30=$dailyArray[$dailyArray['audit_date'][$i]]['AON_GR_30'];
                     $HC=$arrayHeadcount1[$dailyArray['audit_date'][$i]];
                    
                      if($HC ==0)
                      {
                       $Audit_Per_Asso=0;
                      }
                      else
                      {
                       $Audit_Per_Asso=($AON_0_30+$AON_GR_30)/$HC;
                       $Audit_Per_Asso=round($Audit_Per_Asso,2);
                      }
                  
                     echo '<td align="center" style="padding:4px;">'.$Audit_Per_Asso.'</td>';
                   }
                
                
                
                echo '</table>';  
               
           
          }
          else{
                       echo '<div style="color:red;text-align:center;">No Data Found</div>';
                   }
         
              
         }
          elseif($interval >7)
         {
           echo '<div style="color:red;text-align:center;">Please Select Maximum 7 Days Date Range</div>';
         }
       
        
         }
        
 elseif(isset($_REQUEST['trend']) && $_REQUEST['trend'] =='monthly')
          {
     if($interval <=7)
           {
############Monthly Data
        $monthlyArray=array();
        $auditmonth1='';
        $AON_0_30=0;
        $AON_GR_30=0;
        $m=0;
             for($i=1;$i<sizeof($dataArr);$i++)
                {
                  $auditdate=$dataArr[$i][2];
                  $auditdate=explode(' ',$auditdate);
                  $auditdate=$auditdate[0];
                  $auditdate=strtoupper($auditdate);
                  $auditmonth=explode('-',$auditdate);
                  $auditmonth=$auditmonth[1]."-".$auditmonth[2];
                  if($auditmonth1 !=$auditmonth)
                  {
                    $AON_0_30=0;
                    $AON_GR_30=0;
                    if(isset($dataArr[$i][29]) && $dataArr[$i][29] =='0-30')
                    {
                    $AON_0_30++;
                    }
                    if(isset($dataArr[$i][29]) && $dataArr[$i][29] !='0-30')
                    {
                    $AON_GR_30++;
                    }
                   
                    $j=0;
                    $monthlyArray[$auditmonth]['audit_month']=$auditmonth;
                    $CALL_OPENING_txt=$dataArr[$i][8];
                    if($CALL_OPENING_txt=='Pass' || $CALL_OPENING_txt=='Feedback'  || $CALL_OPENING_txt=='Not Applicable')
                    {
                    $CALL_OPENING=1;
                    }
                    else
                    {
                    $CALL_OPENING=0;
                    }
                   
                    $Phone_Etiquette_txt=$dataArr[$i][9];
                    if($Phone_Etiquette_txt=='Pass' || $Phone_Etiquette_txt=='Feedback'  || $Phone_Etiquette_txt=='Not Applicable')
                    {
                    $Phone_Etiquette=1;
                    }
                    else
                    {
                    $Phone_Etiquette=0;
                    }
                   
                    $Valid_Probing_txt=$dataArr[$i][10];
                    if($Valid_Probing_txt=='Pass' || $Valid_Probing_txt=='Feedback'  || $Valid_Probing_txt=='Not Applicable')
                    {
                    $Valid_Probing=1;
                    }
                    else
                    {
                    $Valid_Probing=0;
                    }
                   
                    $Call_Closing_txt=$dataArr[$i][11];
                    if($Call_Closing_txt=='Pass' || $Call_Closing_txt=='Feedback'  || $Call_Closing_txt=='Not Applicable')
                    {
                    $Call_Closing=1;
                    }
                    else
                    {
                    $Call_Closing=0;
                    }
                   
                    $Noise_on_Call_txt=$dataArr[$i][12];
                    if($Noise_on_Call_txt=='Pass' || $Noise_on_Call_txt=='Feedback'  || $Noise_on_Call_txt=='Not Applicable')
                    {
                    $Noise_on_Call=1;
                    }
                    else
                    {
                    $Noise_on_Call=0;
                    }
                   
                    $Wrong_Approval_txt=$dataArr[$i][13];
                    if($Wrong_Approval_txt=='Pass' || $Wrong_Approval_txt=='Feedback'  || $Wrong_Approval_txt=='Not Applicable')
                    {
                    $Wrong_Approval=1;
                    }
                    else
                    {
                    $Wrong_Approval=0;
                    }
                   
                    $Title_txt=$dataArr[$i][14];
                    if($Title_txt=='Pass' || $Title_txt=='Feedback'  || $Title_txt=='Not Applicable')
                    {
                    $Title=1;
                    }
                    else
                    {
                    $Title=0;
                    }
                   
                    $Information_Mis_call_txt=$dataArr[$i][15];
                    if($Information_Mis_call_txt=='Pass' || $Information_Mis_call_txt=='Feedback'  || $Information_Mis_call_txt=='Not Applicable')
                    {
                    $Information_Mis_call=1;
                    }
                    else
                    {
                    $Information_Mis_call=0;
                    }
                    $Information_Mis_orig_txt=$dataArr[$i][16];
                    if($Information_Mis_orig_txt=='Pass' || $Information_Mis_orig_txt=='Feedback'  || $Information_Mis_orig_txt=='Not Applicable')
                    {
                    $Information_Mis_orig=1;
                    }
                    else
                    {
                    $Information_Mis_orig=0;
                    }
                   
                   
                    $MCAT_Selection_txt=$dataArr[$i][17];
                    if($MCAT_Selection_txt=='Pass' || $MCAT_Selection_txt=='Feedback'  || $MCAT_Selection_txt=='Not Applicable')
                    {
                    $MCAT_Selection=1;
                    }
                    else
                    {
                    $MCAT_Selection=0;
                    }
                    $Supplier_Manual_txt=$dataArr[$i][18];
                    if($Supplier_Manual_txt=='Pass' || $Supplier_Manual_txt=='Feedback'  || $Supplier_Manual_txt=='Not Applicable')
                    {
                    $Supplier_Manual=1;
                    }
                    else
                    {
                    $Supplier_Manual=0;
                    }
                    $Contact_Details_txt=$dataArr[$i][19];
                    if($Contact_Details_txt=='Pass' || $Contact_Details_txt=='Feedback'  || $Contact_Details_txt=='Not Applicable')
                    {
                    $Contact_Details=1;
                    }
                    else
                    {
                    $Contact_Details=0;
                    }
                    $Grammar_Spelling_txt=$dataArr[$i][20];
                    if($Grammar_Spelling_txt=='Pass' || $Grammar_Spelling_txt=='Feedback'  || $Grammar_Spelling_txt=='Not Applicable')
                    {
                    $Grammar_Spelling=1;
                    }
                    else
                    {
                    $Grammar_Spelling=0;
                    }
                   
                   
                  if(($CALL_OPENING==1) && ($Phone_Etiquette==1) && ($Valid_Probing==1) && ($Call_Closing==1) && ($Noise_on_Call==1))
                    {
                    $Call_Score_over_all=1;
                    }
                    else
                    {
                     $Call_Score_over_all=0;
                    }
                   
                     if(($Wrong_Approval==1) && ($Title==1) && ($Information_Mis_call==1) && ($Information_Mis_orig==1) && ($MCAT_Selection==1) && ($Supplier_Manual==1) &&  ($Contact_Details==1) && ($Grammar_Spelling==1))   
                     {
                     $Lead_Score_over_all=1;
                     }
                     else
                     {
                      $Lead_Score_over_all=0;
                     }   
                   
                   
                    $Call_Score=$dataArr[$i][23];
                    $Lead_Score=$dataArr[$i][24];
                    $Noise_Score=$dataArr[$i][25];
                    $Formating_Score=$dataArr[$i][26];
                    $Score_Excluding=$dataArr[$i][27];
                    $Score_including=$dataArr[$i][28];
                    $monthlyArray[$auditmonth]['Call_Opening']=$CALL_OPENING;
                    $monthlyArray[$auditmonth]['Phone_Etiquette']=$Phone_Etiquette;
                    $monthlyArray[$auditmonth]['Valid_Probing']=$Valid_Probing;
                    $monthlyArray[$auditmonth]['Call_Closing']=$Call_Closing;
                    $monthlyArray[$auditmonth]['Noise_on_Call']=$Noise_on_Call;                 
                    $monthlyArray[$auditmonth]['Wrong_Approval']=$Wrong_Approval;                 
                    $monthlyArray[$auditmonth]['Title']=$Title;                 
                    $monthlyArray[$auditmonth]['Information_Mis_call']=$Information_Mis_call;                 
                    $monthlyArray[$auditmonth]['Information_Mis_orig']=$Information_Mis_orig;                 
                    $monthlyArray[$auditmonth]['MCAT_Selection']=$MCAT_Selection;                 
                    $monthlyArray[$auditmonth]['Supplier_Manual']=$Supplier_Manual;                 
                    $monthlyArray[$auditmonth]['Contact_Details']=$Contact_Details;                 
                    $monthlyArray[$auditmonth]['Grammar_Spelling']=$Grammar_Spelling;
                   
                    $monthlyArray[$auditmonth]['Call_Score_over_all']=$Call_Score_over_all;
                    $monthlyArray[$auditmonth]['Lead_Score_over_all']=$Lead_Score_over_all;
                   
                    $monthlyArray[$auditmonth]['Call_Score']=$Call_Score;
                    $monthlyArray[$auditmonth]['Lead_Score']=$Lead_Score;
                    $monthlyArray[$auditmonth]['Noise_Score']=$Noise_Score;
                    $monthlyArray[$auditmonth]['Formating_Score']=$Formating_Score;
                    $monthlyArray[$auditmonth]['Score_Excluding']=$Score_Excluding;
                    $monthlyArray[$auditmonth]['Score_including']=$Score_including;
                    $monthlyArray[$auditmonth]['AON_0_30']=$AON_0_30;
                    $monthlyArray[$auditmonth]['AON_GR_30']=$AON_GR_30;
                    $j++;
                    $monthlyArray[$auditmonth]['audit_count']=$j;
                    $monthlyArray['audit_month'][$m]=$auditmonth;
                    $m++;
                  }
                  else
                  {
                   if(isset($dataArr[$i][29]) && $dataArr[$i][29] =='0-30')
                  {
                   $AON_0_30++;
                  }
                  if(isset($dataArr[$i][29]) && $dataArr[$i][29] !='0-30')
                  {
                   $AON_GR_30++;
                  }
                   $j++;
                    $CALL_OPENING_txt=$dataArr[$i][8];
                  if($CALL_OPENING_txt=='Pass' || $CALL_OPENING_txt=='Feedback'  || $CALL_OPENING_txt=='Not Applicable')
                  {
                   $CALL_OPENING1=1;
                  }
                  else
                  {
                   $CALL_OPENING1=0;
                  }
                 
                  $Phone_Etiquette_txt=$dataArr[$i][9];
                  if($Phone_Etiquette_txt=='Pass' || $Phone_Etiquette_txt=='Feedback'  || $Phone_Etiquette_txt=='Not Applicable')
                  {
                   $Phone_Etiquette1=1;
                  }
                  else
                  {
                   $Phone_Etiquette1=0;
                  }
                 
                   $Valid_Probing_txt=$dataArr[$i][10];
                  if($Valid_Probing_txt=='Pass' || $Valid_Probing_txt=='Feedback'  || $Valid_Probing_txt=='Not Applicable')
                  {
                   $Valid_Probing1=1;
                  }
                  else
                  {
                   $Valid_Probing1=0;
                  }
                 
                   $Call_Closing_txt=$dataArr[$i][11];
                  if($Call_Closing_txt=='Pass' || $Call_Closing_txt=='Feedback'  || $Call_Closing_txt=='Not Applicable')
                  {
                   $Call_Closing1=1;
                  }
                  else
                  {
                   $Call_Closing1=0;
                  }
                 
                   $Noise_on_Call_txt=$dataArr[$i][12];
                  if($Noise_on_Call_txt=='Pass' || $Noise_on_Call_txt=='Feedback'  || $Noise_on_Call_txt=='Not Applicable')
                  {
                   $Noise_on_Call1=1;
                  }
                  else
                  {
                   $Noise_on_Call1=0;
                  }
                 
                   $Wrong_Approval_txt=$dataArr[$i][13];
                  if($Wrong_Approval_txt=='Pass' || $Wrong_Approval_txt=='Feedback'  || $Wrong_Approval_txt=='Not Applicable')
                  {
                   $Wrong_Approval1=1;
                  }
                  else
                  {
                   $Wrong_Approval1=0;
                  }
                 
                  $Title_txt=$dataArr[$i][14];
                  if($Title_txt=='Pass' || $Title_txt=='Feedback'  || $Title_txt=='Not Applicable')
                  {
                   $Title1=1;
                  }
                  else
                  {
                   $Title1=0;
                  }
                 
                  $Information_Mis_call_txt=$dataArr[$i][15];
                  if($Information_Mis_call_txt=='Pass' || $Information_Mis_call_txt=='Feedback'  || $Information_Mis_call_txt=='Not Applicable')
                  {
                   $Information_Mis_call1=1;
                  }
                  else
                  {
                   $Information_Mis_call1=0;
                  }
                  $Information_Mis_orig_txt=$dataArr[$i][16];
                  if($Information_Mis_orig_txt=='Pass' || $Information_Mis_orig_txt=='Feedback'  || $Information_Mis_orig_txt=='Not Applicable')
                  {
                   $Information_Mis_orig1=1;
                  }
                  else
                  {
                   $Information_Mis_orig1=0;
                  }
                 
                 
                  $MCAT_Selection_txt=$dataArr[$i][17];
                  if($MCAT_Selection_txt=='Pass' || $MCAT_Selection_txt=='Feedback'  || $MCAT_Selection_txt=='Not Applicable')
                  {
                   $MCAT_Selection1=1;
                  }
                  else
                  {
                   $MCAT_Selection1=0;
                  }
                  $Supplier_Manual_txt=$dataArr[$i][18];
                  if($Supplier_Manual_txt=='Pass' || $Supplier_Manual_txt=='Feedback'  || $Supplier_Manual_txt=='Not Applicable')
                  {
                   $Supplier_Manual1=1;
                  }
                  else
                  {
                   $Supplier_Manual1=0;
                  }
                  $Contact_Details_txt=$dataArr[$i][19];
                  if($Contact_Details_txt=='Pass' || $Contact_Details_txt=='Feedback'  || $Contact_Details_txt=='Not Applicable')
                  {
                   $Contact_Details1=1;
                  }
                  else
                  {
                   $Contact_Details1=0;
                  }
                  $Grammar_Spelling_txt=$dataArr[$i][20];
                  if($Grammar_Spelling_txt=='Pass' || $Grammar_Spelling_txt=='Feedback'  || $Grammar_Spelling_txt=='Not Applicable')
                  {
                   $Grammar_Spelling1=1;
                  }
                  else
                  {
                   $Grammar_Spelling1=0;
                  }
                  
                   if(($CALL_OPENING1==1) && ($Phone_Etiquette1==1) && ($Valid_Probing1==1) && ($Call_Closing1==1) && ($Noise_on_Call1==1))
                {
                $Call_Score_over_all1=1;
                }
                else
                {
                  $Call_Score_over_all1=0;
                }
               
              if(($Wrong_Approval1==1) && ($Title1==1) && ($Information_Mis_call1==1) && ($Information_Mis_orig1==1) && ($MCAT_Selection1==1) && ($Supplier_Manual1==1) &&  ($Contact_Details1==1) && ($Grammar_Spelling1==1))   
              {
              $Lead_Score_over_all1=1;
              }
              else
              {
              $Lead_Score_over_all1=0;
              }   
                   
                  
                  
                  
                   $CALL_OPENING=$CALL_OPENING+$CALL_OPENING1;
                   $Phone_Etiquette=$Phone_Etiquette+$Phone_Etiquette1;
                   $Valid_Probing=$Valid_Probing+$Valid_Probing1;
                   $Call_Closing=$Call_Closing+$Call_Closing1;
                   $Noise_on_Call=$Noise_on_Call+$Noise_on_Call1;
                   $Wrong_Approval=$Wrong_Approval+$Wrong_Approval1;
                   $Title=$Title+$Title1;
                   $Information_Mis_call=$Information_Mis_call+$Information_Mis_call1;
                   $Information_Mis_orig=$Information_Mis_orig+$Information_Mis_orig1;
                   $MCAT_Selection=$MCAT_Selection+$MCAT_Selection1;
                   $Supplier_Manual=$Supplier_Manual+$Supplier_Manual1;
                   $Contact_Details=$Contact_Details+$Contact_Details1;
                   $Grammar_Spelling=$Grammar_Spelling+$Grammar_Spelling1;
                  
                   $Call_Score_over_all=$Call_Score_over_all+$Call_Score_over_all1;
                   $Lead_Score_over_all=$Lead_Score_over_all+$Lead_Score_over_all1;
                  
                   $Call_Score=$Call_Score+$dataArr[$i][23];
                   $Lead_Score=$Lead_Score+$dataArr[$i][24];
                   $Noise_Score=$Noise_Score+$dataArr[$i][25];
                   $Formating_Score=$Formating_Score+$dataArr[$i][26];
                   $Score_Excluding=$Score_Excluding+$dataArr[$i][27];
                   $Score_including=$Score_including+$dataArr[$i][28];
                   $monthlyArray[$auditmonth]['audit_month']=$auditmonth;
                  
                   $monthlyArray[$auditmonth]['Call_Opening']=$CALL_OPENING;
                  $monthlyArray[$auditmonth]['Phone_Etiquette']=$Phone_Etiquette;
                  $monthlyArray[$auditmonth]['Valid_Probing']=$Valid_Probing;
                  $monthlyArray[$auditmonth]['Call_Closing']=$Call_Closing;
                  $monthlyArray[$auditmonth]['Noise_on_Call']=$Noise_on_Call;                 
                  $monthlyArray[$auditmonth]['Wrong_Approval']=$Wrong_Approval;                 
                  $monthlyArray[$auditmonth]['Title']=$Title;                 
                  $monthlyArray[$auditmonth]['Information_Mis_call']=$Information_Mis_call;                 
                  $monthlyArray[$auditmonth]['Information_Mis_orig']=$Information_Mis_orig;                 
                  $monthlyArray[$auditmonth]['MCAT_Selection']=$MCAT_Selection;                 
                  $monthlyArray[$auditmonth]['Supplier_Manual']=$Supplier_Manual;                 
                  $monthlyArray[$auditmonth]['Contact_Details']=$Contact_Details;                 
                  $monthlyArray[$auditmonth]['Grammar_Spelling']=$Grammar_Spelling;
                 
                   $monthlyArray[$auditmonth]['Call_Score_over_all']=$Call_Score_over_all;
                   $monthlyArray[$auditmonth]['Lead_Score_over_all']=$Lead_Score_over_all;
                  
                   $monthlyArray[$auditmonth]['Call_Score']=$Call_Score;
                   $monthlyArray[$auditmonth]['Lead_Score']=$Lead_Score;
                   $monthlyArray[$auditmonth]['Noise_Score']=$Noise_Score;
                   $monthlyArray[$auditmonth]['Formating_Score']=$Formating_Score;
                   $monthlyArray[$auditmonth]['Score_Excluding']=$Score_Excluding;
                   $monthlyArray[$auditmonth]['Score_including']=$Score_including;
                   $monthlyArray[$auditmonth]['AON_0_30']=$AON_0_30;
                   $monthlyArray[$auditmonth]['AON_GR_30']=$AON_GR_30;
                   $monthlyArray[$auditmonth]['audit_count']=$j;
                  }
                 
                $auditmonth1=$auditmonth; 
                }
               
                if(!empty($monthlyArray)){
                 $colspan=sizeof($monthlyArray['audit_month'])+1;
               
              echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #0195d3; color: white;">
                <td align="left" style="padding:4px;"><b>Month Wise</b></td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$monthlyArray['audit_month'][$i].'</b></td>';
                }
                echo '</tr>';
               
         if((isset($_REQUEST['trend_format']) && $_REQUEST['trend_format'] =='percentage')){
               
                   echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Summary</b></td></tr>';
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Audits</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Call_Score_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Score']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 
                  $Call_Score_per = sprintf('%0.2f', $Call_Score_per);
               
                  echo '<td align="center" style="padding:4px;">'.$Call_Score_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Lead Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                 $Lead_Score_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Lead_Score']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 $Lead_Score_per = sprintf('%0.2f', $Lead_Score_per);
                  echo '<td align="center" style="padding:4px;">'.$Lead_Score_per.'%</td>';
                }
                echo '</tr>';
               
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Noise Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Noise_Score_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Noise_Score']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Noise_Score_per = sprintf('%0.2f', $Noise_Score_per);
                  echo '<td align="center" style="padding:4px;">'.$Noise_Score_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Formatting Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Formating_Score_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Formating_Score']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Formating_Score_per = sprintf('%0.2f', $Formating_Score_per);
                  echo '<td align="center" style="padding:4px;">'.$Formating_Score_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Quality Score Excluding Noise+Formatting</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Score_Excluding_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Score_Excluding']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 
                  $Score_Excluding_per = sprintf('%0.2f', $Score_Excluding_per);
                  echo '<td align="center" style="padding:4px;">'.$Score_Excluding_per.'%</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Quality Score Including Noise+Formatting</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                   $Score_including_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Score_including']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                    $Score_including_per = sprintf('%0.2f', $Score_including_per);
                  echo '<td align="center" style="padding:4px;">'.$Score_including_per.'%</td>';
                }
                echo '</tr><tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Detailed</b></td></tr>';
               
               
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Parameter Wise</b></td></tr>';
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td  align="left" style="padding:4px;"><b>Call Quality</b></td>';
               
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                 
                 $Call_Quality_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Score_over_all']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 $Call_Quality_per = sprintf('%0.2f', $Call_Quality_per);
                 
                  echo '<td align="center" style="padding:4px;"><b>'.$Call_Quality_per.'%</b></td>';
                }
               
                echo '</tr><tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Opening</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                 $Call_Opening_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Opening']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 $Call_Opening_per = sprintf('%0.2f', $Call_Opening_per);
                 echo '<td align="center" style="padding:4px;">'.$Call_Opening_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Phone Etiquette</td>';
                 for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                 $Phone_Etiquette_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Phone_Etiquette']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 $Phone_Etiquette_per = sprintf('%0.2f', $Phone_Etiquette_per);
                 echo '<td align="center" style="padding:4px;">'.$Phone_Etiquette_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Valid Probing</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Valid_Probing_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Valid_Probing']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Valid_Probing_per = sprintf('%0.2f', $Valid_Probing_per);
                  echo '<td align="center" style="padding:4px;">'.$Valid_Probing_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Closing</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Call_Closing_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Closing']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                   $Call_Closing_per = sprintf('%0.2f', $Call_Closing_per);
                  echo '<td align="center" style="padding:4px;">'.$Call_Closing_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Noise On Call</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                 $Noise_on_Call_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Noise_on_Call']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 $Noise_on_Call_per = sprintf('%0.2f', $Noise_on_Call_per);
                 echo '<td align="center" style="padding:4px;">'.$Noise_on_Call_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="background: #dff8ff; color: white;">
                <td align="left" style="padding:4px;"><b>Lead Quality</b></td>';
               
                 for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                 
                 $Lead_Quality_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Lead_Score_over_all']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 $Lead_Quality_per = sprintf('%0.2f', $Lead_Quality_per);
                 
                  echo '<td align="center" style="padding:4px;"><b>'.$Lead_Quality_per.'%</b></td>';
                }
               
                 echo '</tr><tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Wrong Approval</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                 
                   $Wrong_Approval_Call_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Wrong_Approval']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Wrong_Approval_Call_per = sprintf('%0.2f', $Wrong_Approval_Call_per);
                  echo '<td align="center" style="padding:4px;">'.$Wrong_Approval_Call_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Title</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Title_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Title']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Title_per = sprintf('%0.2f', $Title_per);
                  echo '<td align="center" style="padding:4px;">'.$Title_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Information Missing/Wrong (From Call)</td>';
               for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Information_Mis_call_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Information_Mis_call']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                   $Information_Mis_call_per = sprintf('%0.2f', $Information_Mis_call_per);
                  echo '<td align="center" style="padding:4px;">'.$Information_Mis_call_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Information Missing/Wrong (From Original/Existing)</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Information_Mis_orig_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Information_Mis_orig']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Information_Mis_orig_per = sprintf('%0.2f', $Information_Mis_orig_per);
                  echo '<td align="center" style="padding:4px;">'.$Information_Mis_orig_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">MCAT Selection</td>';
               for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                   $MCAT_Selection_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['MCAT_Selection']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $MCAT_Selection_per = sprintf('%0.2f', $MCAT_Selection_per);
                 echo '<td align="center" style="padding:4px;">'.$MCAT_Selection_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Supplier Selection - Manual</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Supplier_Manual_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Supplier_Manual']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                 $Supplier_Manual_per = sprintf('%0.2f', $Supplier_Manual_per);
                echo '<td align="center" style="padding:4px;">'.$Supplier_Manual_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Contact Details</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Contact_Details_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Contact_Details']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Contact_Details_per = sprintf('%0.2f', $Contact_Details_per);
                  echo '<td align="center" style="padding:4px;">'.$Contact_Details_per.'%</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Grammar and Spelling</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  $Grammar_Spelling_per=round(($monthlyArray[$monthlyArray['audit_month'][$i]]['Grammar_Spelling']/$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'])*100,2);
                  $Grammar_Spelling_per = sprintf('%0.2f', $Grammar_Spelling_per);
                  echo '<td align="center" style="padding:4px;">'.$Grammar_Spelling_per.'%</td>';
                }
                echo '</tr>';
               
     }
   else
        {
                 echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Summary</b></td></tr>';
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Audits</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['audit_count'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Score'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Lead Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Lead_Score'].'</td>';
                }
                echo '</tr>';
               
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Noise Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Noise_Score'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Formatting Quality</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Formating_Score'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Quality Score Excluding Noise+Formatting</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Score_Excluding'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Quality Score Including Noise+Formatting</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Score_including'].'</td>';
                }
                echo '</tr><tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Detailed</b></td></tr>';
               
               
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Parameter Wise</b></td></tr>';
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td align="left" style="padding:4px;"><b>Call Quality</b></td>';
               
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Score_over_all'].'<b></td>';
                }               
                echo '</tr>';
               
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Opening</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Opening'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Phone Etiquette</td>';
                 for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Phone_Etiquette'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Valid Probing</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Valid_Probing'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Call Closing</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Call_Closing'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Noise On Call</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Noise_on_Call'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="background: #dff8ff; color: white;">
                <td align="left" style="padding:4px;"><b>Lead Quality</b></td>';
               
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;"><b>'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Lead_Score_over_all'].'</b></td>';
                }
               
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Wrong Approval</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Wrong_Approval'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Title</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Title'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Information Missing/Wrong (From Call)</td>';
               for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Information_Mis_call'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Information Missing/Wrong (From Original/Existing)</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Information_Mis_orig'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">MCAT Selection</td>';
               for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['MCAT_Selection'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Supplier Selection - Manual</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Supplier_Manual'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Contact Details</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Contact_Details'].'</td>';
                }
                echo '</tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">Grammar and Spelling</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['Grammar_Spelling'].'</td>';
                }
                echo '</tr>';
             
       }
               
                echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Audit Count</b></td></tr>';
               
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>AON Wise</b></td></tr>';
               
                 echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">0-30 Days Old</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['AON_0_30'].'</td>';
                }
                echo '</tr>';
               
                echo '<tr style="color: white;">
                <td align="left" style="padding:4px;padding-left:20px;">>30 Days Old</td>';
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  echo '<td align="center" style="padding:4px;">'.$monthlyArray[$monthlyArray['audit_month'][$i]]['AON_GR_30'].'</td>';
                }
                echo '</tr>';
               
        ###TL Wise DATA Start---------------------
                $arrayTL=array();
                $n=0;
                $emp_name=array();
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  for($j=0;$j<sizeof($rec2);$j++)
                  {
                    $rec2[$j]=array_change_key_case($rec2[$j], CASE_UPPER);
                    $temp_date=explode(' ',$rec2[$j]['BL_AUDIT_RESPONSE_DATE']);
                    $rec2[$j]['BL_AUDIT_RESPONSE_DATE']=$temp_date[0];
                     if(strtoupper($monthlyArray['audit_month'][$i])==$rec2[$j]['BL_AUDIT_RESPONSE_DATE'])
              {
                        $arrayTL[$rec2[$j]['ETO_LEAP_EMP_NAME']][$monthlyArray['audit_month'][$i]]=$rec2[$j]['COUNT'];
                        if(!in_array($rec2[$j]['ETO_LEAP_EMP_NAME'],$emp_name))
                        {
                        $arrayTL['emp'][$n]=$rec2[$j]['ETO_LEAP_EMP_NAME'];
                        $n++;
                        }
                        array_push($emp_name,$rec2[$j]['ETO_LEAP_EMP_NAME']);
              }
             
                  }
                }
              
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>TL Wise Audit Count</b></td></tr>';
                 if(!empty($arrayTL['emp']))
                 sort($arrayTL['emp']);
                for($i=0;$i<sizeof($arrayTL)-1;$i++)
                {
                   if(empty($arrayTL['emp'][$i]))
                   $tl_name='Without TL';
                   else
                   $tl_name=$arrayTL['emp'][$i];
                  
                   echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">'.$tl_name.'</td>';
                   for($m=0;$m<sizeof($monthlyArray['audit_month']);$m++)
            {
             if(array_key_exists($monthlyArray['audit_month'][$m], $arrayTL[$arrayTL['emp'][$i]]))
             echo '<td align="center" style="padding:4px;">'.$arrayTL[$arrayTL['emp'][$i]][$monthlyArray['audit_month'][$m]].'</td>';
             else
             echo '<td align="center" style="padding:4px;">0</td>';
            }
                  echo '</tr>';
                }
                 ###TL Wise DATA End---------------------
                
               ### Audit Wise DATA Start---------------------
              
                $arrayTL=array();
                $n=0;
                $emp_name=array();
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  for($j=0;$j<sizeof($rec3);$j++)
                  {
                    $rec3[$j]=array_change_key_case($rec3[$j], CASE_UPPER);
                    $temp_date=explode(' ',$rec3[$j]['BL_AUDIT_RESPONSE_DATE']);
                    $rec3[$j]['BL_AUDIT_RESPONSE_DATE']=$temp_date[0];
                     if(strtoupper($monthlyArray['audit_month'][$i])==$rec3[$j]['BL_AUDIT_RESPONSE_DATE'])
              {
                        $arrayTL[$rec3[$j]['ETO_LEAP_EMP_NAME']][$monthlyArray['audit_month'][$i]]=$rec3[$j]['COUNT'];
                        if(!in_array($rec3[$j]['ETO_LEAP_EMP_NAME'],$emp_name))
                        {
                        $arrayTL['emp'][$n]=$rec3[$j]['ETO_LEAP_EMP_NAME'];
                        $n++;
                        }
                        array_push($emp_name,$rec3[$j]['ETO_LEAP_EMP_NAME']);
              }
             
                  }
                }
            
                echo '<tr style="background: #dff8ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>QA Audit Count</b></td></tr>';
                if(!empty($arrayTL['emp']))
                sort($arrayTL['emp']);
                for($i=0;$i<sizeof($arrayTL)-1;$i++)
                {
                   echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">'.$arrayTL['emp'][$i].'</td>';
                   for($m=0;$m<sizeof($monthlyArray['audit_month']);$m++)
            {
             if(array_key_exists($monthlyArray['audit_month'][$m], $arrayTL[$arrayTL['emp'][$i]]))
             echo '<td align="center" style="padding:4px;">'.$arrayTL[$arrayTL['emp'][$i]][$monthlyArray['audit_month'][$m]].'</td>';
             else
             echo '<td align="center" style="padding:4px;">0</td>';
            }
                  echo '</tr>';
                }
                 ###Audit Wise DATA End---------------------
                
                
                 ### QA Wise DATA Start---------------------
                $arrayTL=array();
                $n=0;
                $emp_name=array();
                for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                {
                  for($j=0;$j<sizeof($rec4);$j++)
                  {
                    $rec4[$j]=array_change_key_case($rec4[$j], CASE_UPPER);
                    $temp_date=explode(' ',$rec4[$j]['BL_AUDIT_RESPONSE_DATE']);
                    $rec4[$j]['BL_AUDIT_RESPONSE_DATE']=$temp_date[0];
                     if(strtoupper($monthlyArray['audit_month'][$i])==$rec4[$j]['BL_AUDIT_RESPONSE_DATE'])
              {
                        $arrayTL[$rec4[$j]['ETO_LEAP_EMP_NAME']][$monthlyArray['audit_month'][$i]]=$rec4[$j]['COUNT'];
                        if(!in_array($rec4[$j]['ETO_LEAP_EMP_NAME'],$emp_name))
                        {
                        $arrayTL['emp'][$n]=$rec4[$j]['ETO_LEAP_EMP_NAME'];
                        $n++;
                        }
                        array_push($emp_name,$rec4[$j]['ETO_LEAP_EMP_NAME']);
              }
             
                  }
                }

                ###### QA Wise DATA End---------------------
                $arrayHeadcount=array();
                $arrayHeadcount1=array();
                $arrayDatehead=array();
                for($i=0;$i<sizeof($rec5);$i++)
                {
                $rec5[$i]=array_change_key_case($rec5[$i], CASE_UPPER);
                $arrayDatehead['ETO_OFR_APPROV_DATE_ORIG'][$i]=$rec5[$i]['ETO_OFR_APPROV_DATE_ORIG'];
                $arrayHeadcount[$rec5[$i]['ETO_OFR_APPROV_DATE_ORIG']]=$rec5[$i]['COUNT'];
                }
               
                for($j=0;$j<sizeof($monthlyArray['audit_month']);$j++)
                {
               
               
                if(!empty($arrayDatehead['ETO_OFR_APPROV_DATE_ORIG']) && in_array($monthlyArray['audit_month'][$j],$arrayDatehead['ETO_OFR_APPROV_DATE_ORIG']))
                {
                  $arrayHeadcount1[$monthlyArray['audit_month'][$j]]=$arrayHeadcount[$monthlyArray['audit_month'][$j]];
                }
                else
                {
                 $arrayHeadcount1[$monthlyArray['audit_month'][$j]]=0;
                }
               }
               
       
                echo '<tr style="background: #33d7ff; color: white;">
                <td colspan="'.$colspan.'" align="left" style="padding:4px;"><b>Audit Per Associate</b></td></tr>';
                echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">Associate HC</td>';
                
                 for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                 {
                  echo '<td align="center" style="padding:4px;">'.$arrayHeadcount1[$monthlyArray['audit_month'][$i]].'</td>';
                 }
                
                 echo '<tr style="color: white;">
                   <td align="left" style="padding:4px;padding-left:20px;">Audit Per Associate</td>';
                  for($i=0;$i<sizeof($monthlyArray['audit_month']);$i++)
                   {
                     $AON_0_30=$monthlyArray[$monthlyArray['audit_month'][$i]]['AON_0_30'];
                     $AON_GR_30=$monthlyArray[$monthlyArray['audit_month'][$i]]['AON_GR_30'];
                     $HC=$arrayHeadcount1[$monthlyArray['audit_month'][$i]];
                    
                      if($HC ==0)
                      {
                       $Audit_Per_Asso=0;
                      }
                      else
                      {
                       $Audit_Per_Asso=($AON_0_30+$AON_GR_30)/$HC;
                       $Audit_Per_Asso=round($Audit_Per_Asso,2);
                      }
                  
                     echo '<td align="center" style="padding:4px;">'.$Audit_Per_Asso.'</td>';
                   }
                
                
                
                echo '</table>';  
               
           
          }
          else{
                       echo '<div style="color:red;text-align:center;">No Data Found</div>';
                   }
                  
########Monthly Data End                  

         
         }elseif($interval > 7)
         {
           echo '<div style="color:red;text-align:center;">Please Select Maximum  Days Date Range</div>';
         }         
         }
          elseif(isset($_REQUEST['trend']) && $_REQUEST['trend'] =='tni')
          { 
            if($interval <=7)
           {
            $temp_assco_id='';
             $finaArr=array();
             $j=-1;
             for($i=0;$i<count($dataArr);$i++)
             {
               if($dataArr[$i]['ASSOCIATE_ID'] !=$temp_assco_id)
               {
                 $cnt=0;
                 $audit_wrong=0;
                 $cnt++;
                 $j++;
                 $finaArr[$j]['total_audit']=$cnt;
                 $finaArr[$j]['ASSOCIATE_ID']=$dataArr[$i]['ASSOCIATE_ID'];
                 $finaArr[$j]['ASSOCIATE_NAME']=$dataArr[$i]['ASSOCIATE_NAME'];
                 $finaArr[$j]['TL_NAME']=isset($dataArr[$i]['TL_NAME']) ? $dataArr[$i]['TL_NAME'] : '';
                 $finaArr[$j]['ON_FLOOR_DATE']=isset($dataArr[$i]['ON_FLOOR_DATE']) ? $dataArr[$i]['ON_FLOOR_DATE'] : '';
                 $finaArr[$j]['ETO_LEAP_VENDOR_NAME']=$dataArr[$i]['ETO_LEAP_VENDOR_NAME'];
                 $finaArr[$j]['QUESTION_ID']=$dataArr[$i]['QUESTION_ID'];
                 if((($dataArr[$i]['OPT']=='Pass') || preg_match("/^Feedback/", $dataArr[$i]['OPT']) > 0 || preg_match("/^Not Applicable/",$dataArr[$i]['OPT']) > 0))
                 {
                  $audit_wrong=$audit_wrong;
                 }
                 else
                 {
                  $audit_wrong++;
                 }
                 $finaArr[$j]['WRONG_AUDIT']=$audit_wrong;
                 $finaArr[$j]['ERROR']=round((($audit_wrong/$cnt)*100),2);
                 $temp_assco_id=$dataArr[$i]['ASSOCIATE_ID'];
               }
               else
               {
                 $cnt++;
                 $finaArr[$j]['total_audit']=$cnt;
                 $finaArr[$j]['ASSOCIATE_ID']=$dataArr[$i]['ASSOCIATE_ID'];
                 $finaArr[$j]['ASSOCIATE_NAME']=$dataArr[$i]['ASSOCIATE_NAME'];
                 $finaArr[$j]['TL_NAME']=isset($dataArr[$i]['TL_NAME']) ? $dataArr[$i]['TL_NAME'] : '';
                 $finaArr[$j]['ON_FLOOR_DATE']=isset($dataArr[$i]['ON_FLOOR_DATE']) ? $dataArr[$i]['ON_FLOOR_DATE'] : '';
                 $finaArr[$j]['ETO_LEAP_VENDOR_NAME']=$dataArr[$i]['ETO_LEAP_VENDOR_NAME'];
                 $finaArr[$j]['QUESTION_ID']=$dataArr[$i]['QUESTION_ID'];
                 if((($dataArr[$i]['OPT']=='Pass') || preg_match("/^Feedback/", $dataArr[$i]['OPT']) > 0 || preg_match("/^Not Applicable/",$dataArr[$i]['OPT']) > 0))
                 {
                  $audit_wrong=$audit_wrong;
                 }
                 else
                 {
                  $audit_wrong++;
                 }
                 $finaArr[$j]['WRONG_AUDIT']=$audit_wrong;
                 $finaArr[$j]['ERROR']=round((($audit_wrong/$cnt)*100),2);
               }
             }
            
             echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #0195d3; color: white;">
                <th align="center" colspan="10" style="padding:4px;"><b>TNI (Training Need Identification) Report</b></th>
                </tr>
                <tr>
                <td align="center" style="padding:4px;"><b>Sr. No.</b></td>
                <td align="center" style="padding:4px;"><b>Partner Name</b></td>
                <td align="center" style="padding:4px;"><b>Team Leader Name</b></td>
                <td align="center" style="padding:4px;"><b>Associate Name</b></td>
                <td align="center" style="padding:4px;"><b>Associate Id</b></td>
                <td align="center" style="padding:4px;"><b>On Floor Date</b></td>
                <td align="center" style="padding:4px;"><b>Audits Done</b></td>
                <td align="center" style="padding:4px;"><b>Audits With Error</b></td>
                <td align="center" style="padding:4px;"><b>Parameter Name</b></td>
                <td align="center" style="padding:4px;"><b>Error %</b></td>
                </tr>';
             
              $QuesArray=array(1=>'Call Opening',2=>'Phone Etiquette',3=>'Valid Probing',4=>'Call Closing',5=>'Noise on Call',6=>'Wrong Approval',7=>'Title',8=>'Information Missing/Wrong (From Call)',9=>'Information Missing/Wrong (From Original/Existing)',10=>'MCAT Selection',11=>'Supplier Selection - Manual',12=>'Contact Details',13=>'Grammar and Spelling');
              $sr=1;
              uasort($finaArr, function($a,$b){
	      $c = $b['ERROR'] - $a['ERROR'];
	      return $c;
		});
		
              
              foreach($finaArr as $x)
              {
              echo '<tr>
                <td align="center" style="padding:4px;">'.$sr.'</td>
                <td align="center" style="padding:4px;">'.$x['ETO_LEAP_VENDOR_NAME'].'</td>
                <td align="center" style="padding:4px;">'.$x['TL_NAME'].'</td>
                <td align="center" style="padding:4px;">'.$x['ASSOCIATE_NAME'].'</td>
                <td align="center" style="padding:4px;">'.$x['ASSOCIATE_ID'].'</td>
                <td align="center" style="padding:4px;">'.$x['ON_FLOOR_DATE'].'</td>
                <td align="center" style="padding:4px;">'.$x['total_audit'].'</td>
                <td align="center" style="padding:4px;">'.$x['WRONG_AUDIT'].'</td>
                <td align="center" style="padding:4px;">'.$QuesArray[$x['QUESTION_ID']].'</td>
                <td align="center" style="padding:4px;">'.round((($x['WRONG_AUDIT']/$x['total_audit'])*100),2).'%</td>
                </tr>';
                $sr++;
              }
               
               echo '</table>';
           
          
          }
          
           elseif($interval >7)
         {
           echo '<div style="color:red;text-align:center;">Please Select Maximum 7 Days Date Range</div>';
         }
          }
    echo '</FORM>';

  echo '<div style="clear:both;"><!-- --></div></div>';

 
 
?>
