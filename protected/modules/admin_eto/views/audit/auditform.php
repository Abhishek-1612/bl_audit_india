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
            if (($("input[name='stype']:checked"). val()== 'DNC') || ($("input[name='stype']:checked"). val()== 'R')) {
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
            if ($("input[name='stype']:checked"). val()== 'DNC'){
                $("#tr_calling_del").show(); 
            }else{
                $("#tr_calling_del").hide(); 
            }
            if (($("input[name='stype']:checked"). val()== 'DNC') || ($("input[name='stype']:checked"). val()== 'R')) {
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

if($tabselect <> 7){
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

if($tabselect == 1 || $tabselect == 7)
      {    
    if($tabselect == 1){?>
                  
                <form name="searchform" method="post" action="/index.php?r=admin_eto/auditEto/Index&tabselect=1">
                 <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">              
        <tr style="background: #0195d3;">
       <td style="padding:4px;font-weight:bold;color:#fff;" width="20%">Offer Detail: <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=<?php echo $offerID;?>&go=Go&mid=3424" style="text-decoration:underline;color:#fff" target="_blank"><?php echo $offerID;?></a></td>               
       <td style="width:10%;padding:4px;"><span style="float:left;margin:3px 0px 0px 0px;color:#fff;">Enter Offer ID:</span></td>
       <td style="width:10%;padding:4px;"><input type="text" id="offerID" name="offerID" style="width: 200px; float:left;margin:0px 0px 0px 3px;" maxlength="15" value="<?php echo $offerID ?>"></td>
       <td style="padding:4px;"><input type="submit" name="search" style="font-weight:bold;margin: 0px 0px 0px 3px;float:left;width:80px;height:25px; text-align:center;" value="Search" onclick="return validate_number();"/></td></tr>
         </table>
                </form>               
               <?php
    }
    else{
        echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="3" align="center"><font COLOR =" #333399"><b>Super Audit Form</b></font>             
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
                     $recording_url=isset($offerArr['ETO_OFR_CALL_RECORDING_URL']) ? $offerArr['ETO_OFR_CALL_RECORDING_URL'] : '';
                echo '<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
                  <tr><td> Call Recording: &nbsp;&nbsp;&nbsp;';
                if($recording_url<>''){
                    echo '&nbsp;&nbsp;<a href="'.$recording_url.'" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';
                }else{
                    echo '&nbsp;&nbsp;NA';
                }
                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer='.$offerID.'&mid=3424" target="_blank">&#187;&nbsp;View All Recordings</A></td>
                  <td><b> &nbsp;&nbsp; <a href="/index.php?r=admin_eto/ofrHist/etohistory&action=etohistory&act=ofrHist&offer='.$offerID.'&mid=3424" target="_blank">Offer History</a></b> </td>
                  <td><b>&nbsp;<a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=mapHist&offer='.$offerID.'&status=A&mid=3424" target="_blank">List of suppliers</a></b></td></tr>
                </table><table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR><td width="30%" valign="top">';
    echo $offerdetHTML;
    echo '</td><td><form name="questionform" method="post" action="/index.php?r=admin_eto/auditEto/Index&tabselect=1">
                    ';
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
<td style="font-weight:bold;padding:4px;color:#fff;">Review Lead Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
     
echo $Review_Quality.'</table></td></tr>';
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
</td>               
</tr>
</table></form></td></tr></table>'; 


                   }else{
                       echo '<div style="color:red;text-align:center;">'.$auditArr['errMsg'].'</div>';
                   }

                   }else{
                       echo '<div style="color:red;text-align:center;">No Offer detail exist</div>';
                   }
                       
               }
               elseif(isset($message) && $message!=''){
                   echo '<div style="color:green;text-align:center;">'.$message.'</div>';
               }          
               
}
  echo '<div style="clear:both;"><!-- --></div></div>';

 
 
?>