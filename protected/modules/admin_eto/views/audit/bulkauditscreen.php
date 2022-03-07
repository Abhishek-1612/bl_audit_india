<?php 
$team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa=isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent=isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve=isset($vendor_approve) ? $vendor_approve : 'ALL';
$tabselect=isset($_REQUEST['tabselect']) ? $_REQUEST['tabselect']:3;
?>
<head>
<title>Buy Lead Audit CRM</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:2px;border-style:solid;border-color:#0195d3;
}
</style>

<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<?php
if($tabselect<>1){?>
<script type="text/javascript">
</script>
<?php }
?>
<script type="text/javascript">
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
            }else{
                $("#tr_ban_reason").hide(); 
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
            }else{
                $("#tr_ban_reason").hide(); 
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
                            a['leadtype']= $('input[name="leadtype"]:checked').val();
                            a['buyer_type']= $('input[name="buyer_type"]:checked').val();
                            a['pool']= $('input[name="pool"]:checked').val();
                            a['poolVal']=$('#poolVal').val();                            
                        } 
                        if($("input[name='stype']:checked"). val() =='DNC'){
                            a['calling_del']=$('#calling_del').val();                            
                        }
                        if($("input[name='stype']:checked"). val()== 'BAN'){
                            a['ban_reason']=$('#ban_reason').val();
                            a['key_category']=$('#key_category').val();
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
                            a['leadtype']= $('input[name="leadtype"]:checked').val();
                            a['buyer_type']= $('input[name="buyer_type"]:checked').val();
                        }   
                        if($("input[name='stype']:checked"). val() =='DNC'){
                            a['calling_del']=$('#calling_del').val();                            
                        }
                        if($("input[name='stype']:checked"). val()== 'BAN'){
                            a['ban_reason']=$('#ban_reason').val();
                            a['key_category']=$('#key_category').val();
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

if(!(($tabselect == 7) || ($tabselect == 8))){
echo '<div align="center" width="98%">
<h2 style="font-family:arial; padding:15px 0px 0px 13px;margin:0px;font-size:20px; float:left; text-align:left; line-height:20px; color:#bc0800;">Buy Lead Audit CRM</h2>
<br style="clear:both;"/><br />
</div>
<div class="tab-container" id="left_tabs">
            <div class="nav" id="top_navigation">
                <ul>';
               
              
              
        if(!($tabselect) || $tabselect == 3)
        {
                    echo '<li><a href="/index.php?r=admin_eto/auditEto/Sampling&tabselect=3" class="selected" style="padding:0px 12px;" id="tab3">Audit Sample </a></li>';

        }
        else
        {
                        echo '<li><a href="/index.php?r=admin_eto/auditEto/Sampling&tabselect=3" style="padding:0px 16px;" id="tab9">Audit Sample</a></li>';
        }
              
              
              
               if($tabselect == 1)
                {  
                    
                     echo '<li><a href="/index.php?r=admin_eto/auditEto/Index&tabselect=1" class="selected"  style="padding:0px 12px;" id="tab1">Audit Form</a></li>';
                 }
                else
                {    
                     
                      echo '<li><a href="/index.php?r=admin_eto/auditEto/Index&tabselect=1" style="padding:0px 16px;" id="tab1">Audit Form</a></li>';
               }
        if($tabselect == 2)
        {
                    echo '<li><a href="/index.php?r=admin_eto/auditEto/Mis&tabselect=2" class="selected" style="padding:0px 12px;" id="tab2">Search Audit</a></li>';

        }
        else
        {
                        echo '<li><a href="/index.php?r=admin_eto/auditEto/Mis&tabselect=2" style="padding:0px 16px;" id="tab9"">Search Audit</a></li>';
        }
       
        if($tabselect ==5)
        {
                    echo '<li><a href="/index.php?r=admin_eto/auditEto/Reports&tabselect=5" class="selected" style="padding:0px 12px;" id="tab5">Audit Report</a></li>';

        }
        else
        {
                        echo '<li><a href="/index.php?r=admin_eto/auditEto/Reports&tabselect=5" style="padding:0px 16px;" id="tab5">Audit Report</a></li>';
        }
       
       
       
        if($tabselect == 6)
        {
                    echo '<li><a href="/index.php?r=admin_eto/auditEto/RebuttalMis&tabselect=6" class="selected" style="padding:0px 12px;" id="tab6">Audit Rebuttal</a></li>';

        }
        else
        {
                        echo '<li><a href="/index.php?r=admin_eto/auditEto/RebuttalMis&tabselect=6" style="padding:0px 16px;" id="tab6" >Audit Rebuttal</a></li>';
        }
                    
               
                if($tabselect == 4)
        {
                    echo '<li><a href="/index.php?r=admin_eto/auditEto/Guidelines&tabselect=4" class="selected" style="padding:0px 12px;" id="tab4">Guidelines</a></li>';

        }
        else
        {
                        echo '<li><a href="/index.php?r=admin_eto/auditEto/Guidelines&tabselect=4" style="padding:0px 16px;" id="tab4" >Guidelines</a></li>';
        }
       
         
       
               
              
      echo '</ul>';
echo '</div>';
}

if($tabselect == 1 || $tabselect == 7 || $tabselect == 8)
      {$ban='';
    if($tabselect == 1){?>
                  
                <form name="searchform" method="post" action="/index.php?r=admin_eto/auditEto/Index&tabselect=1">
                 <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="3" align="center"><font COLOR =" #333399"><b>Audit Form</b></font>             
              </td>   
              </TR>
        <tr bgcolor="#fff" >
        <td style="width:10%;padding:4px;"><span style="float:left;margin:3px 0px 0px 0px;">Enter Offer ID:</span></td>
        <td style="width:10%;padding:4px;"><input type="text" id="offerID" name="offerID" style="width: 200px; float:left;margin:0px 0px 0px 3px;" maxlength="15" value="<?php echo $offerID ?>"></td>
                <td style="padding:4px;"><input type="submit" name="search" style="font-weight:bold;margin: 0px 0px 0px 3px;float:left;width:80px;height:25px; text-align:center;" value="Search" onclick="return validate_number();"/></td></tr>
         </table>
                </form>
               
               <?php
    }else{
        $headform="Super Audit Form";
        if($tabselect == 8){
            $ban='&ban=1';
            $headform="Audit Form";
        }       
        echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="3" align="center"><font COLOR =" #333399"><b>'.$headform.'</b></font>             
              </td>   
              </TR></table>';
    }
    if($offerID !=''){
                  
                   if(isset($message) && $message!=''){
                        echo '<div style="color:red;text-align:center;">'.$message.'</div>';                        
                    }
                    $associateID='';$tl_name='';$aon='';
                    $partner_name='';$remarks='';
                   if(isset($offerArr) && isset($offerArr['ETO_OFR_DISPLAY_ID'])){
                    $associateID=$offerArr['ASSOC_NAME'];
                    $partner_name=$offerArr['ETO_LEAP_VENDOR_NAME'];
                    $tl_name=$offerArr['TL_NAME'];
                    $aon=$offerArr['AON_FLAG'];
                    $recording_url=isset($offerArr['ETO_OFR_CALL_RECORDING_URL']) ? $offerArr['ETO_OFR_CALL_RECORDING_URL'] : '';  


                echo '<form name="questionform" method="post" action="/index.php?r=admin_eto/auditEto/Index&tabselect='.$tabselect.'">
                    <table border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
                   <tr style="background: #0195d3;">       
        <td style="padding:4px;font-weight:bold;color:#fff;" colspan="4">Offer Detail - <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads'.$ban.'&offer='.$offerID.'&go=Go&mid=3424" style="text-decoration:underline;color:#fff" target="_blank">'.$offerID.'</a></td>               
                </tr>
                <tr>       
        <td style="padding:4px;">Associate :</td>
                <td style="padding:4px;">'.$associateID.'</td>
                   
                <td style="padding:4px;">TL Name :</td>
                <td style="padding:4px;">'.$tl_name.'</td>
                </tr>
               


                <tr>       
        <td style="padding:4px;">Partner name :</td>
                <td style="padding:4px;">'.$partner_name.'</td>
                   
                <td style="padding:4px;">AON :</td>
                <td style="padding:4px;">'.$aon.'</td>   
                </tr>
<tr>       
        <td style="padding:4px;">Auditors Name :</td>
                <td style="padding:4px;" colspan="3">'.$auditors_name.'</td>
                </tr>
               

                </table>';
            


$errMsg = $auditArr['errMsg'];
if(isset($auditArr['quesArr'])){
  $quesArr = $auditArr['quesArr']; 
}

$prevQID='';
$cnt=0;
$q_cnt=0;$cnt_tr=0;
$Call_Quality ='';

if(isset($quesArr)){

foreach($quesArr as $quesValue){
    if($quesValue['QUESTION_TYPE']==1){
       
                    $cnt++;                   
                    $qid = $quesValue['QUES_ID'];
                    $optId = $quesValue['OPTIONS_ID'];
                    $qdesc = $quesValue['QUES_DESC'];
                    $optdesc = $quesValue['OPTIONS_DESC'];
                    $tot_q=$quesValue['Q_OPT_CNT'];
                    $finalcount=isset($feedbackcount[$qid]['quescount'])?$feedbackcount[$qid]['quescount']:'';
                    if($prevQID!=$qid){
                        if($prevQID!=''){
                            $Call_Quality .= '</tr></table></td><tr>';  
                        }
                        $q_cnt++;
                        $Call_Quality .='<tr><td><div id="quesion'.$q_cnt .'" style="height: 30px;vertical-align:middle;padding-top:10px;" title="'.$quesValue['QUESTION_HELP_TEXT'].'"><b>Question '.$q_cnt .'- '. $qdesc.'</b>';
                        if($quesValue['IS_OPTIONAL'] == 0){
                           $Call_Quality .='<span style="color:red;"> *</span>';
                        }
                        $Call_Quality .= '</div><table border="1" style="border-collapse: collapse;" bordercolor="#d7f3ff"  width="100%" cellpadding="0" cellspacing="0">';
                       
                        $cnt_tr=0;
                    }
                   
                    $cnt_tr++;
                   
                   
                    if($cnt_tr%2 == 1){
                        $Call_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                        $Call_Quality .= '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                         if($recording_url=='' && $optdesc=='Not Applicable'){
                             $Call_Quality .= '<td style="width:50%;height: 30px;vertical-align:middle;"><input checked onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                         }else{
                               if($finalcount>=2 && $optdesc=='Feedback'){
                                    $Call_Quality .= '<td style="width:50%;display:none;height: 30px;vertical-align:middle;"><input disabled onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                                }else{
                                 $Call_Quality .= '<td style="width:50%;height: 30px;vertical-align:middle;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                                }
                         }
                    }
                    $prevQID=$qid;
                   
                    if($tot_q==$cnt){
                        if($tot_q%2==1){
                            $Call_Quality .= '<td>&nbsp;</td>'; 
                        }                   
                        $Call_Quality .= '</tr></table></div></td><tr>'; 
                    }   
     }                    
 }
 
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;">Call Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
     
echo $Call_Quality.'</table></td></tr>';

$prevQID='';//print_r($quesArr);
$cnt=0;
$cnt_tr=0;
$Lead_Quality ='';
$stype="";
foreach($quesArr as $quesValue){
    if($quesValue['QUESTION_TYPE']==2){
       $stype="D";
                    $cnt++;                   
                    $qid = $quesValue['QUES_ID'];
                    $optId = $quesValue['OPTIONS_ID'];
            $qdesc = $quesValue['QUES_DESC'];
            $optdesc = $quesValue['OPTIONS_DESC'];
                    $tot_q=$quesValue['Q_OPT_CNT'];
                    if($prevQID!=$qid){
                        if($prevQID!=''){
                            $Lead_Quality .= '</tr></table></td><tr>';  
                        }
                        $q_cnt++;
                        $Lead_Quality .='<tr><td><div id="quesion'.$q_cnt .'" style="height: 30px;vertical-align:middle;" title="'.$quesValue['QUESTION_HELP_TEXT'].'"><b>Question '.$q_cnt .'- '. $qdesc.'</b>';
                        if($quesValue['IS_OPTIONAL'] == 0){
                           $Lead_Quality .='<span style="color:red;"> *</span>';
                        }
                        $Lead_Quality .= '</div><table border="1" style="border-collapse: collapse;" bordercolor="#d7f3ff"  width="100%" cellpadding="0" cellspacing="0">';
                       
                        $cnt_tr=0;
                    }
                   
                    $cnt_tr++;
                   
                   
                    if($cnt_tr%2 == 1){
                        $Lead_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                      $Lead_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                        $Lead_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }
                   
                    $prevQID=$qid;
                    if($tot_q==$cnt){
                        if($tot_q%2==1){
                            $Lead_Quality .= '<td>&nbsp;</td>'; 
                        }
                        $Lead_Quality .= '</tr></table></div></td><tr>'; 
                    }   
     }                    
 }
 
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;">Lead Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
     
echo $Lead_Quality.'</table></td></tr>';

$Review_Quality='';
foreach($quesArr as $quesValue){
    if($quesValue['QUESTION_TYPE']==3){
       $stype="R";
                    $cnt++;                   
                    $qid = $quesValue['QUES_ID'];
                    $optId = $quesValue['OPTIONS_ID'];
                    $qdesc = $quesValue['QUES_DESC'];
                    $optdesc = $quesValue['OPTIONS_DESC'];
                    $tot_q=$quesValue['Q_OPT_CNT'];
                    if($prevQID!=$qid){
                        if($prevQID!=''){
                            $Review_Quality .= '</tr></table></td><tr>';  
                        }
                        $q_cnt++;
                        $Review_Quality .='<tr><td><div id="quesion'.$q_cnt .'" style="height: 30px;vertical-align:middle;" title="'.$quesValue['QUESTION_HELP_TEXT'].'"><b>Question '.$q_cnt .'- '. $qdesc.'</b>';
                        if($quesValue['IS_OPTIONAL'] == 0){
                           $Review_Quality .='<span style="color:red;"> *</span>';
                        }
                        $Review_Quality .= '</div><table border="1" style="border-collapse: collapse;" bordercolor="#d7f3ff"  width="100%" cellpadding="0" cellspacing="0">';
                       
                        $cnt_tr=0;
                    }
                   
                    $cnt_tr++;
                   
                   
                    if($cnt_tr%2 == 1){
                        $Review_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                      $Review_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                        $Review_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }
                   
                    $prevQID=$qid;
                    if($tot_q==$cnt){
                        if($tot_q%2==1){
                            $Review_Quality .= '<td>&nbsp;</td>'; 
                        }
                        $Review_Quality .= '</tr></table></div></td><tr>'; 
                    }   
     }                    
 }
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;">Review Pool Lead Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
     
echo $Review_Quality.'</table></td></tr>';

$Ban_Quality='';
foreach($quesArr as $quesValue){
    if($quesValue['QUESTION_TYPE']==4){
       $stype="BAN";
                    $cnt++;                   
                    $qid = $quesValue['QUES_ID'];
                    $optId = $quesValue['OPTIONS_ID'];
                    $qdesc = $quesValue['QUES_DESC'];
                    $optdesc = $quesValue['OPTIONS_DESC'];
                    $tot_q=$quesValue['Q_OPT_CNT'];
                    if($prevQID!=$qid){
                        if($prevQID!=''){
                            $Ban_Quality .= '</tr></table></td><tr>';  
                        }
                        $q_cnt++;
                        $Ban_Quality .='<tr><td><div id="quesion'.$q_cnt .'" style="height: 30px;vertical-align:middle;" title="'.$quesValue['QUESTION_HELP_TEXT'].'"><b>Question '.$q_cnt .'- '. $qdesc.'</b>';
                        if($quesValue['IS_OPTIONAL'] == 0){
                           $Ban_Quality .='<span style="color:red;"> *</span>';
                        }
                        $Ban_Quality .= '</div><table border="1" style="border-collapse: collapse;" bordercolor="#d7f3ff"  width="100%" cellpadding="0" cellspacing="0">';
                       
                        $cnt_tr=0;
                    }
                   
                    $cnt_tr++;
                   
                   
                    if($cnt_tr%2 == 1){
                        $Ban_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                      $Ban_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                        $Ban_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }
                   
                    $prevQID=$qid;
                    if($tot_q==$cnt){
                        if($tot_q%2==1){
                            $Ban_Quality .= '<td>&nbsp;</td>'; 
                        }
                        $Ban_Quality .= '</tr></table></div></td><tr>'; 
                    }   
     }                    
 }
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;">Ban Pool Lead Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
     
echo $Ban_Quality.'</table></td></tr>';
echo '<tr style="background: #0195d3;">       
        <td style="font-weight:bold;padding:4px;color:#fff;" colspan="2">Remarks and Observations</td>               
                </tr>
 <tr>       
        <td style="padding:4px;" colspan="2">              
<textarea id="remarks" name="remarks" style="width: 98%; height: 100px; margin-bottom:8px; ">';
if($remarks==''){
echo "What went wrong (if any): "."\n";
 echo "Feedback/Suggestion(if any):";
}else{
    echo $remarks;
}
$status=isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
echo '</textarea></td>               
                </tr>
 <tr>       
        <td style="padding:4px;" colspan="2" align="center">   
<input type="submit" name="save" onclick = "return validate()" style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:80px;height:25px; text-align:center;" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="Associate_feedback" id="Associate_feedback" value="Associate_feedback">&nbsp;Disable login credential as associate education required in respect to this audit(Ex DDN/NOIDA)
<input id="tot_question" name="tot_question"  type="hidden" value="'.$q_cnt.'">
<input id="selofferID" name="selofferID" type="hidden" value="'.$offerID.'">
<input id="auditors_name" name="auditors_name" type="hidden" value="'.$auditors_name.'"> 
<input id="v_name" name="v_name" type="hidden" value="'.$v_name.'"> 
<input id="selopt_val" name="selopt_val" type="hidden" value="">
<input id="stype" name="stype" type="hidden" value="'.$stype.'">
<input id="status" name="status" type="hidden" value="'.$status.'">    
</td>               
                </tr>
                </table></form>';


                   }else{
                       echo '<div style="color:red;text-align:center;">'.$auditArr['errMsg'].'</div>';
                   }

                   }else{
                       echo '<div style="color:red;text-align:center;">No Offer detail exist</div>';
                   }
               }elseif(isset($message) && $message!=''){
                   echo '<div style="color:green;text-align:center;">'.$message.'</div>';
               }
               
}
elseif($tabselect == 2){
$checkarch='';
$offerid=isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
$auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
$team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa=isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent=isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor1=isset($_REQUEST['vendor1']) ? $_REQUEST['vendor1'] : array();
$vendor_audit=isset($_REQUEST['vendor_audit']) ? $_REQUEST['vendor_audit'] : 'ALL';
$vendor_approve=isset($_REQUEST['vendor_approve']) ? $_REQUEST['vendor_approve'] : 'ALL';
$Archive_data=isset($_REQUEST['Archive_data']) ? $_REQUEST['Archive_data'] :  '';
$stype=isset($_REQUEST['stype']) ? $_REQUEST['stype'] :  '';
if(!empty($Archive_data))
$checkarch='checked';
     ?>
     <body>
     <div id="complete_mis">
     <form name="searchForm" id="searchForm" method="post" action="/index.php?r=admin_eto/auditEto/Mis&tabselect=2" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Audit MIS</b></font>(<font COLOR ="red"> *This Audit Search works for Vendor 7 Days otherwise 2 Date Range Only</font>)             
              </td>   
              </TR>
              <TR id="tr_search">
                <TD  CLASS="admintext">Search Type</TD>
                <TD colspan="3">      
                <input type="radio" id="s1" name="stype" value="" <?php echo ($stype=='') ?"checked":'' ?> >&nbsp;Default &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s2" name="stype" value="ADV"  <?php echo ($stype=="ADV")?"checked":'' ?> >&nbsp;Advanced&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s3" name="stype" value="R"  <?php echo ($stype=="R") ? "checked":'' ?> >&nbsp;Reviewed&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s4" name="stype" value="BAN"  <?php echo ($stype=="BAN")?"checked":'' ?> >&nbsp;Ban Pool&nbsp;
                 <span id="tr_ban_reason" name="tr_ban_reason" style="display:none;"> 
                     <select name="ban_reason" id="ban_reason"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="A">Approved</option>
                        <option value="R">Deleted</option><option value="E">Expired</option></select>&nbsp;&nbsp;&nbsp;
                      <select name="key_category" id="key_category"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="2">Adult</option>
                        <option value="4">Drug</option><option value="3">Trademark</option></select>
               </span>
                </TD>
            </TR>
              <tr>

              <td WIDTH="20%">&nbsp;Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="checkbox" name="Archive_data" value="Archive_data" <?php echo $checkarch;?>>&nbsp;&nbsp;<b>Archive Data</b>   
              </td>
              
               <td WIDTH="20%">&nbsp;Score:</td>
              <td> &nbsp;<input type="radio" name="score" checked />Both&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="score" value="pass" <?php echo (isset($_REQUEST['score']) && $_REQUEST['score'] == 'pass')?'CHECKED="CHECKED"':'' ?>/>Pass&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="score" value="fail" <?php echo (isset($_REQUEST['score']) && $_REQUEST['score'] == 'fail')?'CHECKED="CHECKED"':'' ?>/>Fail&nbsp;</td>
              </tr>
              <tr>
    <td >&nbsp;Auditor Type/Level:</td>
    <td>
    &nbsp;<input type="checkbox" value="ALL" id="ALL" <?php if(empty($vendor1) || in_array("ALL",$vendor1)) echo "checked"; ?> name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;ALL
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="EMP" id="EMP" <?php if(!empty($vendor1) && in_array("EMP",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;EMP
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="AGENT" id="AGENT" <?php if(!empty($vendor1) && in_array("AGENT",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;AGENT
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="TL" id="TL" <?php if(!empty($vendor1) && in_array("TL",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;TL
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="QA" id="QA" <?php if(!empty($vendor1) && in_array("QA",$vendor1)) echo "checked"; ?>  name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;QA
    &nbsp;&nbsp;&nbsp;<input type="checkbox" value="MGR" id="MGR" <?php if(!empty($vendor1) && in_array("MGR",$vendor1)) echo "checked"; ?> name="vendor1[]" onclick="ChecklistCheckbox(this);">&nbsp;MGR
    </td>          
      <td WIDTH="20%">&nbsp;Buyer Type:</td>
              <td> &nbsp;<input type="radio" name="buyer_type" value="" checked />All&nbsp;&nbsp;
                  <input type="radio" name="buyer_type" value="Frequent" <?php echo (isset($_REQUEST['buyer_type']) && $_REQUEST['buyer_type'] == 'Frequent')?'CHECKED="CHECKED"':'' ?>/>Frequent</td>
          </tr>
                          <tr>
    <td >&nbsp;Approved By: </td>
    <td>&nbsp;<select name="vendor_approve" id="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;" onchange="Newfilter(this.value,'<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');">
    <?php       $vendorArr1=array();
                if(count($vendorArr)==1){
                     $vendor_name=$vendorArr[0];
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHCHN','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW','NOIDA'); 
                      }elseif(preg_match("/COMPETENT/i",$vendor_name)) {
                          $vendorArr1 = array('COMPETENT','BANREVIEW');
                      }else{
                          $vendorArr1 = array($vendor_name);
                      }
                }else{
                    
                        $vendorArr1 = $vendorArr;               
                }
        foreach($vendorArr1 as $k)
        {
            if($vendor_approve == $k)
                {
                    echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$k.'" >'.$k.'</OPTION>';
                }

        } echo '</select>';
        ?>
    </td>
    <td >&nbsp;Audited By: </td>
    <td>&nbsp;<select name="vendor_audit" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
    <?php
        $auditor_count=count($vendorArr);
                $vendorArr1=array();$vendor_name='';
                if(count($vendorArr)==1){
                    $vendor_name=$vendorArr[0];
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHCHN','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW');        
                      }else{
                          $vendorArr1 = array($vendor_name);
                      }
                }else{
                        $vendorArr1 = $vendorArr;
                }
        foreach($vendorArr1 as $k)
        {
            if($vendor_audit == $k)
                {
                    echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$k.'" >'.$k.'</OPTION>';
                }

        } 
         if($auditor_count == 1){
                            if($vendor_audit =='NOIDA')
                            {
                            echo "<OPTION VALUE=\"NOIDA\" SELECTED=\"SELECTED\">NOIDA</OPTION>";
                            }
                            else
                            {
                             echo "<OPTION VALUE=\"NOIDA\">NOIDA</OPTION>";
                            }
                            if($vendor_audit =='DDN'){
                            echo "<OPTION VALUE=\"DDN\" SELECTED=\"SELECTED\">DDN</OPTION>";}
                            else
                            {
                             echo "<OPTION VALUE=\"DDN\">DDN</OPTION>";
                            }
                        }
                   
       
       
        echo '</select>';
        ?>
    </td></tr>
   
     <tr>
   
      <td WIDTH="20%">&nbsp;Lead Type:</td>
              <td> &nbsp; <input type="radio" name="leadtype" value="Both" checked/>Both&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="leadtype" value="R" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'R')?'CHECKED="CHECKED"':'' ?> />Retail&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="leadtype" value="NR" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'NR')?'CHECKED="CHECKED"':'' ?>/>Non Retail&nbsp;&nbsp;&nbsp;
                  <input type="radio" name="leadtype" value="AOV" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'AOV')?'CHECKED="CHECKED"':'' ?>/>High AOV 
                 </td>
                 <td>&nbsp;Search by Audit Id:</td><td>
                    &nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="audit_id" id="audit_id" value="<?php echo $auditId;  ?>"></td>
     </tr>   
     <tr>
    <td >&nbsp;Search by Offer Id: </td>
    <td >&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="offer_id" id="offer_id" value="<?php echo $offerid ; ?>">
    </td>
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
        <TD colspan="4" align="center">                      
    <input type="submit" name="submit_dump" id="submit_dump" value="Generate Report">
    <input type="hidden" name="in_flag" value="0">
    <input type="hidden" name="action" value="generate">
    <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
    </TD>
    </TR>
    </TABLE>        
<?php              
         if(isset($_REQUEST['submit_dump'])){ 
         if($vendor_audit<>'ALL'){
                    $noofdays=7;
                }else{
                    $noofdays=2;
                }
         if($interval <=$noofdays){
         //print_r($dataArr); 
             if(isset($_REQUEST['stype']) && $_REQUEST['stype']=='BAN'){ 
                // print_r($dataArr);// die;
                 $tot_records=count($dataArr);
                $totalpass=0;
                $remark_display=$prevId='';$cnt=0;$html='';$row_num=0;    
                if($tot_records>0){
                 $html .= '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';       
                    for($i=0;$i<count($dataArr);$i++){  
                           if($i==0){
                               $html .= '<tr style="background: #0195d3; "><td style="color: #ffffff;padding:4px;">S No</td>'
                                       . '<td style="color: #ffffff;padding:4px;">'.$dataArr[$i][0].'</td>                         
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][1].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][2].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][3].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][4].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][5].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][8].'</td>                                                                    
                                      <td style="color:#ffffff;padding:4px;">Raise Rebuttal</td>
                                      </tr>';
                           }else{
                               if($dataArr[$i][8]=='Pass'){
                                 $dataArr[$i][9]=1;
                                 $totalpass = $totalpass +1;
                               }
                                 $html .= '<tr><td style="padding:4px;">'.$i.'</td><td style="padding:4px;">'.$dataArr[$i][0].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][1].'</td>
                                    <td style="padding:4px;width:100px;">'.$dataArr[$i][2].'</td>
                                      <td style="padding:4px;">
                                      <a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Auditedit/stype/BAN/audit_id/'.$dataArr[$i][3].'/ven_app/'.$vendor_approve.'/ven_audit/'.$vendor_audit.'/sd/'.$start_date.'/ed/'.$end_date.'/offer_id/'.$dataArr[$i][4].'/r/'.$remark_display.'/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      '.$dataArr[$i][3].'</a>';
                                if($permision==4 && (preg_match("/DDN/", $dataArr[$i][1]) == 0 && preg_match("/NOIDA/", $dataArr[$i][1])==0)){ 
                                       $html .= '<br/><br/><div><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Index&tabselect=7&stype=BAN&reaudit=1&offerID='.$dataArr[$i][4].'\',\'_blank\',\'scrollbars=1,width=900, height=800\');" style="text-decoration:none;color:#0000ff"><font color="red">Re-Audit</font></a></div>';
                                }
                                       $html .= '</td>
                                      <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&ban=1&offer='.$dataArr[$i][4].'&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">'.$dataArr[$i][4].'</a></td>
                                      <td style="padding:4px;">'.$dataArr[$i][5].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][8].'</td>';
                                      if($dataArr[$i][10]=='No')
                                      {
                                      $html .= '<td style="padding:4px;position:relative;"><div id="Rebuttal_div'.$i.'"><input type="button" name="Raise_Rebuttal" id="Raise_Rebuttal" value="Raise Rebuttal" onclick="showCmplntForm('.$dataArr[$i][3].','.$dataArr[$i][4].','.$i.','.$tot_records.')"></div>
                                       <div id="cmplnt_div'.$i.'" class="cancel" style="display:none;" ></div>
                                      </td>';
                                      }
                                      else
                                      {
                                        $html .= '<td style="padding:4px;"><div id="cmplnt_div'.$i.'">Already Raised</div></td>';
                                      }
                                     $html .= '</tr>';
                                }

                            }
                            $html .="</table>";
                            if(count($dataArr)>1){
                                $totalaudit=count($dataArr) -1;
                                echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                                 echo '<tr style="background: #0195d3; color: white;">
                                 <td colspan="2" align="center" style="padding:4px;"><b>Quality Score Summary</b></td></tr>
                                    <tr style="background: #dff8ff; color: white;"><td align="center" style="padding:4px;font-weight:bold;">Total Audits</td>'
                                   . '<td align="center" style="padding:4px;font-weight:bold;">Ban Pool Quality-Pass</td>
                                  </tr>';
                                   echo '<tr><td align="center" style="padding:4px;">'.$totalaudit.'</td>'
                                   . '<td align="center" style="padding:4px;">'.$totalpass.'</td>
                                  </tr>';
                                    echo '<tr><td align="center" style="padding:4px;">%</td>'
                                  . '<td align="center" style="padding:4px;">'.round((($totalpass/$totalaudit)*100),2).'</td>'
                                         . '</tr>';
                                         echo '</table>';
                                         echo '<br><br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr><td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total '.(count($dataArr) -1).' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="export_dump" id="export_dump" value="Export Dump"></td></tr></table><div style="width:100%;">'.$html.'</div>';
                                   }else{
                                      echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
                                   }
                      }
             }elseif(isset($_REQUEST['stype']) && $_REQUEST['stype']=='R'){ 
                // print_r($dataArr); 
                 $tot_records=count($dataArr);
                $totalpass=0;
                $remark_display=$prevId='';$cnt=0;$html='';$row_num=0;    
                if($tot_records>0){
                 $html .= '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';       
                    for($i=0;$i<count($dataArr);$i++){  
                           if($i==0){
                               $html .= '<tr style="background: #0195d3; "><td style="color: #ffffff;padding:4px;">S No</td>'
                                       . '<td style="color: #ffffff;padding:4px;">'.$dataArr[$i][0].'</td>                         
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][1].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][2].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][3].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][4].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][5].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][8].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][9].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][10].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][11].'</td><td style="color:#ffffff;padding:4px;">'.$dataArr[$i][12].'</td>
                                      <td style="color:#ffffff;padding:4px;">Raise Rebuttal</td>
                                      </tr>';
                           }else{
                               if($dataArr[$i][8]=='Pass' && $dataArr[$i][9]=='Pass' && $dataArr[$i][10]=='Pass'){
                                 $dataArr[$i][11]=1;
                                 $totalpass = $totalpass +1;
                               }
                                 $html .= '<tr><td style="padding:4px;">'.$i.'</td><td style="padding:4px;">'.$dataArr[$i][0].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][1].'</td>
                                    <td style="padding:4px;width:100px;">'.$dataArr[$i][2].'</td>
                                      <td style="padding:4px;">
                                      <a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Auditedit/stype/R/audit_id/'.$dataArr[$i][3].'/ven_app/'.$vendor_approve.'/ven_audit/'.$vendor_audit.'/sd/'.$start_date.'/ed/'.$end_date.'/offer_id/'.$dataArr[$i][4].'/r/'.$remark_display.'/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      '.$dataArr[$i][3].'</a>';
                                if($permision==4 && (preg_match("/DDN/", $dataArr[$i][1]) == 0 && preg_match("/NOIDA/", $dataArr[$i][1])==0)){ 
                                       $html .= '<br/><br/><div><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Index&tabselect=7&reaudit=1&offerID='.$dataArr[$i][4].'\',\'_blank\',\'scrollbars=1,width=900, height=800\');" style="text-decoration:none;color:#0000ff"><font color="red">Re-Audit</font></a></div>';
                                }
                                       $html .= '</td>
                                      <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$dataArr[$i][4].'&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">'.$dataArr[$i][4].'</a></td>
                                      <td style="padding:4px;">'.$dataArr[$i][5].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][8].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][9].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][10].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][11].'</td><td style="padding:4px;">'.$dataArr[$i][12].'</td>
                                      ';

                                      if($dataArr[$i][13]=='No')
                                      {
                                      $html .= '<td style="padding:4px;position:relative;"><div id="Rebuttal_div'.$i.'"><input type="button" name="Raise_Rebuttal" id="Raise_Rebuttal" value="Raise Rebuttal" onclick="showCmplntForm('.$dataArr[$i][3].','.$dataArr[$i][4].','.$i.','.$tot_records.')"></div>
                                       <div id="cmplnt_div'.$i.'" class="cancel" style="display:none;" ></div>
                                      </td>';
                                      }
                                      else
                                      {
                                        $html .= '<td style="padding:4px;"><div id="cmplnt_div'.$i.'">Already Raised</div></td>';
                                      }
                                     $html .= '</tr>';
                                }

                            }
                            $html .="</table>";
                            if(count($dataArr)>1){
                                $totalaudit=count($dataArr) -1;
                                echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                                 echo '<tr style="background: #0195d3; color: white;">
                                 <td colspan="2" align="center" style="padding:4px;"><b>Quality Score Summary</b></td></tr>
                                    <tr style="background: #dff8ff; color: white;"><td align="center" style="padding:4px;font-weight:bold;">Total Audits</td>'
                                   . '<td align="center" style="padding:4px;font-weight:bold;">Review Quality-Pass</td>
                                  </tr>';
                                   echo '<tr><td align="center" style="padding:4px;">'.$totalaudit.'</td>'
                                   . '<td align="center" style="padding:4px;">'.$totalpass.'</td>
                                  </tr>';
                                    echo '<tr><td align="center" style="padding:4px;">%</td>'
                                  . '<td align="center" style="padding:4px;">'.round((($totalpass/$totalaudit)*100),2).'</td>'
                                         . '</tr>';
                                         echo '</table>';
                                         echo '<br><br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr><td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total '.(count($dataArr) -1).' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="export_dump" id="export_dump" value="Export Dump"></td></tr></table><div style="width:100%;">'.$html.'</div>';
                                   }else{
                                      echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
                                   }
                      }
             }else{
                $tot_records=count($dataArr);
                $callqualitypass=0;
                $leadqualitypass=0;
                $noisequalitypass=0;
                $formattingpass=0;
                $qualitypass_ex=0;
                $qualitypass_in=0;

                $prevId='';$cnt=0;$html='';$row_num=0;    
                if($tot_records>0){
                 $html .= '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
       
                    for($i=0;$i<count($dataArr);$i++){  
                           if($i==0){
                               $html .= '<tr style="background: #0195d3; color: white;"><td style="padding:4px;">S No</td>'
                                       . '<td style="padding:4px;">'.$dataArr[$i][0].'</td>                         
                                      <td style="padding:4px;">'.$dataArr[$i][1].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][2].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][3].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][4].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][5].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][8].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][9].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][10].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][11].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][12].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][13].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][14].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][15].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][16].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][17].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][18].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][19].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][20].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][21].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][22].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][23].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][24].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][25].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][26].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][27].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][28].'</td>
                                      <td style="padding:4px;">Raise Rebuttal</td>
                                      </tr>';
                           }else{
                               $remark_display=0;
                               if($dataArr[$i][7]=='-'){
                                 $remark_display=1; 
                               }
                                $html .= '<tr><td style="padding:4px;">'.$i.'</td><td style="padding:4px;">'.$dataArr[$i][0].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][1].'</td>
                                    <td style="padding:4px;width:100px;">'.$dataArr[$i][2].'</td>
                                      <td style="padding:4px;">
                                      <a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Auditedit/audit_id/'.$dataArr[$i][3].'/ven_app/'.$vendor_approve.'/ven_audit/'.$vendor_audit.'/sd/'.$start_date.'/ed/'.$end_date.'/offer_id/'.$dataArr[$i][4].'/r/'.$remark_display.'/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      '.$dataArr[$i][3].'</a>';
                                if($permision==4 && (preg_match("/DDN/", $dataArr[$i][1]) == 0 && preg_match("/NOIDA/", $dataArr[$i][1])==0)){ 
                                       $html .= '<br/><br/><div><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Index&tabselect=7&reaudit=1&offerID='.$dataArr[$i][4].'\',\'_blank\',\'scrollbars=1,width=900, height=800\');" style="text-decoration:none;color:#0000ff"><font color="red">Re-Audit</font></a></div>';
                                }
                                       $html .= '</td>
                                      <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$dataArr[$i][4].'&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">'.$dataArr[$i][4].'</a></td>
                                      <td style="padding:4px;">'.$dataArr[$i][5].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][8].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][9].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][10].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][11].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][12].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][13].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][14].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][15].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][16].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][17].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][18].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][19].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][20].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][21].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][22].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][23].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][24].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][25].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][26].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][27].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][28].'</td>';

                                      if($dataArr[$i][30]=='No')
                                      {
                                      $html .= '<td style="padding:4px;position:relative;"><div id="Rebuttal_div'.$i.'"><input type="button" name="Raise_Rebuttal" id="Raise_Rebuttal" value="Raise Rebuttal" onclick="showCmplntForm('.$dataArr[$i][3].','.$dataArr[$i][4].','.$i.','.$tot_records.')"></div>
                                       <div id="cmplnt_div'.$i.'" class="cancel" style="display:none;" ></div>
                                      </td>';
                                      }
                                      else
                                      {
                                        $html .= '<td style="padding:4px;"><div id="cmplnt_div'.$i.'">Already Raised</div></td>';
                                      }
                                     $html .= '</tr>';
                                 $callqualitypass=$callqualitypass+$dataArr[$i][23];
                                 $leadqualitypass=$leadqualitypass+$dataArr[$i][24];
                                 $noisequalitypass=$noisequalitypass+$dataArr[$i][25];
                                 $formattingpass=$formattingpass+$dataArr[$i][26];
                                 $qualitypass_ex=$qualitypass_ex+$dataArr[$i][27];
                                 $qualitypass_in=$qualitypass_in+$dataArr[$i][28];
                           }

                            }
                            $html .="</table>";

                      }
         $totalaudit=count($dataArr) -1;
         
          if(count($dataArr)>1){
               echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">';
                echo '<tr style="background: #0195d3; color: white;">
                <td colspan="7" align="center" style="padding:4px;"><b>Quality Score Summary</b></td></tr>
                   <tr style="background: #dff8ff; color: white;"><td style="padding:4px;font-weight:bold;">Total Audits</td>'
                  . '<td align="center" style="padding:4px;font-weight:bold;">Call Quality-Pass</td>'
                  . '<td align="center" style="padding:4px;font-weight:bold;">Lead Quality-Pass</td>'
                  . '<td align="center" style="padding:4px;font-weight:bold;">Noise Quality-Pass</td>'
                  . '<td align="center" style="padding:4px;font-weight:bold;">Formatting-Pass</td>'
                  . '<td align="center" style="padding:4px;font-weight:bold;">Quality Score (Excluding Noise and Formatting)</td>'
                  . '<td align="center" style="padding:4px;font-weight:bold;">Quality Score (Including Noise and Formatting)</td>'
                        . '</tr>';
                  echo '<tr><td align="center" style="padding:4px;">'.$totalaudit.'</td>'
                  . '<td align="center" style="padding:4px;">'.$callqualitypass.'</td>'
                  . '<td align="center" style="padding:4px;">'.$leadqualitypass.'</td>'
                  . '<td align="center" style="padding:4px;">'.$noisequalitypass.'</td>'
                  . '<td align="center" style="padding:4px;">'.$formattingpass.'</td>'
                  . '<td align="center" style="padding:4px;">'.$qualitypass_ex.'</td>'
                  . '<td align="center" style="padding:4px;">'.$qualitypass_in.'</td>'
                        . '</tr>';
                   echo '<tr><td align="center" style="padding:4px;">%</td>'
                  . '<td align="center" style="padding:4px;">'.round((($callqualitypass/$totalaudit)*100),2).'</td>'
                  . '<td align="center" style="padding:4px;">'.round((($leadqualitypass/$totalaudit)*100),2).'</td>'
                  . '<td align="center" style="padding:4px;">'.round((($noisequalitypass/$totalaudit)*100),2).'</td>'
                  . '<td align="center" style="padding:4px;">'.round((($formattingpass/$totalaudit)*100),2).'</td>'
                  . '<td align="center" style="padding:4px;">'.round((($qualitypass_ex/$totalaudit)*100),2).'</td>'
                  . '<td align="center" style="padding:4px;">'.round((($qualitypass_in/$totalaudit)*100),2).'</td>'
                        . '</tr>';
                        echo '</table>';
                        echo '<br><br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr><td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total '.(count($dataArr) -1).' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="export_dump" id="export_dump" value="Export Dump"></td></tr></table><div style="width:100%;">'.$html.'</div>';
                  }else{
                     echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
                  }
             }
         }
         else
         {
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
elseif($tabselect == 3){
$pool=isset($_REQUEST['pool']) ? $_REQUEST['pool'] : array();
$search=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
$stype=isset($_REQUEST['stype'])?$_REQUEST['stype']:'';
$start_date1=isset($start_date)?$start_date:'';
$deletedreasonArr=array(1=>'Duplicate Requirement',
			3=>'Invalid Description',
			10=>'Wrong Contact Details',
			14=>'Is a Supplier',
			15=>'No Requirement',
			17=>'Test Requirement Posted',
			21=>'Job Enquiry',
			24=>'Not Ready to Confirm',
			33=>'Not Talked Lead',
			16=>'Do Not Call',
			31=>'Banned and Adult Product',
			35=>'One Time Pending Deletion',
			45=>'Deleted because one similar lead recently approved',
			11=>'Offer Rejected',
			53=>'Lead from IM employee',
			52=>'3 leads deleted on call',
			41=>'Drugs Keywords',
			51=>'Drugs Keywords',
			49=>'Duplicate Generation - Time',
			61=>'User Registered With Blacklisted Country',
			36=>'Blacklisted User',
			37=>'Disabled User',
			38=>'Invalid Email Domains',
                        64=>'Calling Required');

    ?><form name="sampleForm" id="sampleForm" method="post" action="/index.php?r=admin_eto/auditEto/Sampling&tabselect=3&mid=3549" style="margin-top:0;margin-bottom:0;">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Sample Data </b></font>(<font COLOR ="red">*This Sample  Generator works for 1 Day Only</font>)             
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
                        <option value="4">Drug</option><option value="3">Trademark</option></select>
               </span></TD>
            </TR>
             <TR id="tr2">
              <td WIDTH="20%">&nbsp;Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date1; ?>" SIZE="13" onfocus="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.sampleForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly"></td>
              <td >&nbsp;Approved/Deleted By: </td>
              <td>&nbsp;<div style="float:left;margin:0 100 0 0"><select onchange="Newfilter(this.value,'<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');" name="vendor_approval" id="vendor_approval" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">
   <?php       $vendorArr1=array();
               if(count($vendorArr)==1){                                       
                     $vendor_name=key($vendorArr);
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('16'=>'COGENTBRB','15'=>'COGENTDNC','23'=>'COGENTPNS','4'=>'COMPETENT');
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('28'=>'KOCHARTECHAUTO','6'=>'KOCHARTECHCHN','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('24'=>'RADIATEAUTO','1'=>'RADIATEDNC','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
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
    <tr id="tr3">
    <td >&nbsp;Sample Type: </td>
    <td colspan="3">
    &nbsp;Approved&nbsp;&nbsp;<input type="radio" name="deletedsample" value="NO" id="deletedsample" checked onclick="deleteddump(this);">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Deleted&nbsp;&nbsp;<input type="radio" name="deletedsample" value="YES" id="deletedsample" onclick="deleteddump(this);">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         <span id="deletedreason" name="deletedreason" style="display:none;">
         <select name="deletedreasonselect" id="deletedreasonselect">
         <OPTION VALUE="ALL">ALL</OPTION>
         <?php 
         foreach($deletedreasonArr as $key=>$value)
         {
          echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
         }
          ?>
         </select>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Direct&nbsp;&nbsp;<input type="radio" name="delsource" value="direct" id="delsource" checked>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fenq&nbsp;&nbsp;<input type="radio" name="delsource" value="fenq" id="delsource">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="deletedcall_noncall" id="deletedcall_noncall">
	  <OPTION value="0">ALL</OPTION>
	  <OPTION value="1">With Call</OPTION>
	  <OPTION value="2">Without Call</OPTION>
	  <OPTION value="3">Manual Flag</OPTION>
	  <OPTION value="4">Auto Delete</OPTION>
	  <OPTION value="5">Manual Delete</OPTION>
         </select>
         </span>
    </td>
    </tr>
     <tr id="tr4">
    <td >&nbsp;Bucket: </td>
    <td><select id="bucket" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
            <?php
        $bucketArr=array('ALL','AON 0-30','Service Only','Retail Only','1 Sample Per Associate','High AOV');
        foreach($bucketArr as $k)
    {
        if($bucket == $k)
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
        if($mailoption == $k)
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
        if($maxrecords == $k)
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
                     <td> &nbsp; <input type="radio" name="leadtype" value="Both" checked/>Both&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="leadtype" value="R" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'R')?'CHECKED="CHECKED"':'' ?> />Retail&nbsp;&nbsp;
                         <input type="radio" name="leadtype" value="NR" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'NR')?'CHECKED="CHECKED"':'' ?>/>Non Retail&nbsp;&nbsp;
                         <input type="radio" name="leadtype" value="AOV" <?php echo (isset($_REQUEST['leadtype']) && $_REQUEST['leadtype'] == 'AOV')?'CHECKED="CHECKED"':'' ?>/>High AOV
                        </td>
                         <td WIDTH="20%">&nbsp;Buyer Type:</td>
              <td> &nbsp;<input type="radio" name="buyer_type" value="" checked />All&nbsp;&nbsp;
                  <input type="radio" name="buyer_type" value="Frequent" <?php echo (isset($_REQUEST['buyer_type']) && $_REQUEST['buyer_type'] == 'Frequent')?'CHECKED="CHECKED"':'' ?>/>Frequent</td>

    </tr>
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
                        <input type="button" name="submit_send" id="submit_send" value="Send Sample">
                        <input type="hidden" name="in_flag" id="in_flag" value="0">
                        <input type="hidden" name="action" id="action" value="generate">
                        <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"></div>
                            </TD></tr>
                        </TABLE><div id="sampleresult" name="sampleresult"></div>
        
        
        
<?php   
 
  echo '</form>';
 
}
elseif($tabselect == 4){
   
    echo ' <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" align="center"><font COLOR =" #333399"><b>Audit Guidelines</b></font>             
              </td>   
              </TR>
        <tr bgcolor="#fff" >
        <td align="center" style="width:10%;padding:4px;"><a target="_new" href="/protected/modules/admin_bl/samplefile/approvalsop.docx" href=""><b>Download BL Audit Guidelines PDF</b></a></td></tr>
                <tr bgcolor="#fff" >
        <td align="center" style="width:10%;padding:4px;"><a target="_new" href="/protected/modules/admin_bl/samplefile/blqcchecklist.pdf"><b>Download Leap Audit Checklist PDF</b></a></td></tr>
        <tr bgcolor="#fff" >
        <td align="center" style="width:10%;padding:4px;"><a target="_new" href="/protected/modules/admin_bl/samplefile/rebuttal.pdf"><b>IndiaMART LEAP  Quality Audit Rebuttal Guideline</b></a></td></tr>
        <tr bgcolor="#fff" >
        <td align="center" style="width:10%;padding:4px;"><a target="_new" href="/protected/modules/admin_bl/samplefile/deletionSOP.docx"><b>Download BL Deletion Audit Guidelines PDF</b></a></td></tr>
         <tr bgcolor="#fff" >
        <td align="center" style="width:10%;padding:4px;"><a target="_new" href="/protected/modules/admin_bl/samplefile/BuyerSupplierConfusion.docx" href=""><b>Download Buyer-Supplier Confusion SOP</b></a></td></tr>
         <tr bgcolor="#fff" >
        <td align="center" style="width:10%;padding:4px;"><a target="_new" href="/protected/modules/admin_bl/samplefile/ReviewPoolSOP.pdf" href=""><b>Download Review Pool SOP</b></a></td></tr>
        </table>
';
}

elseif($tabselect == 5){
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
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHCHN','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW');   
                       }elseif(preg_match("/COMPETENT/i",$vendor_name)) {
                          $vendorArr1 = array('COMPETENT','BANREVIEW');
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
                          $vendorArr1 = array('KOCHARTECHCHN','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');    
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
}
elseif($tabselect == 6){

 $offerid=isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
 $auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
 $is_archive=isset($_REQUEST['is_archive'])?$_REQUEST['is_archive']:'';
$stype=isset($_REQUEST['stype'])?$_REQUEST['stype']:'';
 echo '<body>
 <form name="RebuttalMis" id="RebuttalMis" method="post" action="/index.php?r=admin_eto/auditEto/RebuttalMis&tabselect=6" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="2" align="center"><font COLOR =" #333399"><b>Rebuttal MIS</b></font>             
              </td>   
              </TR>
              <TR id="tr_search">
                <TD  CLASS="admintext">Search Type</TD>
                <TD colspan="3">';  
 ?>
            <input type="radio" id="s1" name="stype" value="" <?php echo ($stype=='') ?"checked":'' ?> >&nbsp;Default &nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s2" name="stype" value="ADV"  <?php echo ($stype=="ADV")?"checked":'' ?> >&nbsp;Advanced&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s3" name="stype" value="R"  <?php echo ($stype=="R") ? "checked":'' ?> >&nbsp;Reviewed&nbsp;&nbsp;&nbsp;
                <input type="radio" id="s4" name="stype" value="BAN"  <?php echo ($stype=="BAN")?"checked":'' ?> >&nbsp;Ban Pool&nbsp;
                 <span id="tr_ban_reason" name="tr_ban_reason" style="display:none;"> 
                     <select name="ban_reason" id="ban_reason"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="A">Approved</option>
                        <option value="R">Deleted</option><option value="E">Expired</option></select>&nbsp;&nbsp;&nbsp;
                      <select name="key_category" id="key_category"><OPTION VALUE="ALL">ALL</OPTION> 
                        <option value="2">Adult</option>
                        <option value="4">Drug</option><option value="3">Trademark</option></select>
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
              </tr>
            <tr>
    <td >&nbsp;Approved By: </td>
    <td>&nbsp;<select name="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;" onchange="Newfilter(this.value,\''.$team_leader.'\',\''.$team_qa.'\',\''.$team_agent.'\');">';
 
                $vendorArr1=array();$vendor_name='';
                if(count($vendorArr)==1){
                    $vendor_name=$vendorArr[0];
                    $vendor_name_login=$vendorArr[0];
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHCHN','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('VKALPDNC','VKALPAUTOFRN' ,'VKALPAUTOIND','VKALPINTENT','VKALPREVIEW','NOIDA'); 
                      }elseif(preg_match("/COMPETENT/i",$vendor_name)) {
                          $vendorArr1 = array('COMPETENT','BANREVIEW');
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
      
    </td></tr>
    <tr>
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
                          $vendorArr1 = array('KOCHARTECHCHN','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
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
    <td >&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="offer_id" id="offer_id" value="'.$offerid.'">
    &nbsp;&nbsp;&nbsp;&nbsp;Search by Audit Id:
    &nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="audit_id" id="audit_id" value="'.$auditId.'"></td>
    </tr>
   
      <tr>
    <td >&nbsp;Status: </td>
    <td >&nbsp;
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
        <TD colspan="2" align="center">
        <input type="submit" name="submit_dump" id="submit_dump" onclick="return validateRebuttal()" value="Generate Report">
        </TD>
       </TR>
       </TABLE>';
      
  if(isset($_REQUEST['submit_dump'])){
  if(sizeof($rec1) >=1)
  {
  echo '<br><br><table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr><td colspan="30" align="center"><span style="padding:4px;font-weight:bold;text-align:center;">Total '.sizeof($rec1).' Records Found</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="export_dump" id="export_dump" value="Export Dump"></td></tr></table>';
           
                   echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">
                   <tr style="background: #0195d3; color: white;">
              <td style="padding:4px;">S No</td>                   
                          <td style="padding:4px;">Offer ID</td>
                          <td style="padding:4px;">Approved By</td>
                          <td style="padding:4px;">Audit ID</td>     
                          <td style="padding:4px;">Audited By</td>
                          <td style="padding:4px;">Audited On</td>
                          <td style="padding:4px;">Raised By</td>
                          <td style="padding:4px;">Raised On</td>
                          <td style="padding:4px;">Audit Remarks</td>
                          <td style="padding:4px;">Rebuttal Remarks</td>
                          <td style="padding:4px;">Status</td>
                          <td style="padding:4px;">Update Rebuttal</td>
                          </tr>';
                        $perm=0;$n=1; 

                        $empId = Yii::app()->session['empid'];  
                        $admineto=new AdminEtoForm(); 
                        $arr_lvl_code = $admineto->getLeapEmpLVL($empId); //print_r($arr_lvl_code); 
            
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
             $REBUTTAL_REMARKS=$rec['REBUTTAL_REMARKS'];
             $AUDIT_REMARKS=$rec['REMARKS'];
             echo '<tr >
              <td style="padding:4px;">'.$n.'</td>                       
                          <td style="padding:4px;"><a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads'.$ban.'&offer='.$rec['FK_ETO_OFR_DISPLAY_ID'].'&go=Go&mid=3424" style="text-decoration:none;color:#0000ff" target="_blank">'.$rec['FK_ETO_OFR_DISPLAY_ID'].'</a></td>
                           <td style="padding:4px;width:40px">'.$rec['BL_APPROVEDBY_EMP_NAME'].'</td>
                          <td style="padding:4px;">
                          <a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/Auditedit/stype/'.$stype.'/audit_id/'.$rec['FK_BL_AUDIT_RESPONSE_ID'].'/ven_app/'.$vendor_approve.'/ven_audit/'.$vendor_raised.'/sd/'.$start_date.'/ed/'.$end_date.'/offer_id/'.$rec['FK_ETO_OFR_DISPLAY_ID'].'/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration: none;">
                          '.$rec['FK_BL_AUDIT_RESPONSE_ID'].'</a></td> 
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
                          
                          echo '<div id="Update_Rebuttal_div'.$n.'"><input type="button" name="Update_Rebuttal" id="Update_Rebuttal" value="Update Rebuttal" onclick="updateRebuttalnew('.$perm.','.$rec['FK_BL_AUDIT_RESPONSE_ID'].','.$rec['FK_ETO_OFR_DISPLAY_ID'].','.$n.','.sizeof($rec1).')"></div>
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

}

  echo '<div style="clear:both;"><!-- --></div></div>';

 
 
?>