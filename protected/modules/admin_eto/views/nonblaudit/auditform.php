<?php 
$team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa=isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent=isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve=isset($vendor_approve) ? $vendor_approve : 'ALL';
$tabselect=isset($_REQUEST['tabselect']) ? $_REQUEST['tabselect']:3;
$btndisplay='';
if(isset($callfrom) && ($callfrom=='freelance')){
  $btndisplay='display:none;';  
}

?>
<head>
<title>Non BL Audit Form</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:2px;border-style:solid;border-color:#0195d3;
}
</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<style type="text/css">
.dark{background : #eefaff;     }.wbg{background : #ffffff;      }.fnt{font-size:12px;width:33%;height:15px;}
.tab-container{ background:#ffffff; width:100%; margin:0px auto; border:1px solid #80c0e5;}.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
.data_off{display:none}.data_on{display:block}
.nav{ float:left;width:100%;}.nav ul{ padding:0px; margin:0px;}.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
.nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
.nav ul li a:hover{color:#000000; text-decoration:none;}.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}
</style>
<script>
    
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
            if(sel_grp === false){
                alert("Please Select Answer for Question " + i);
                return false;
            }
        }
        document.getElementById("selopt_val").value=sel_opt_value;
      
        if(document.getElementById("remarks").value.trim()==='' || document.getElementById("remarks").value.trim()== 'What went wrong (if any): \nFeedback/Suggestion(if any):')
        {
                alert("Please Fill Remarks ");
                return false;
        }
       
    if(document.getElementById("callrecordid").value !==''){
        if(document.getElementById("callrecordid").value.match('^[0-9]+\$')){
        }else{           
            document.getElementById("callrecordid").value='';alert('Enter only Numeric Value');return false;
        }
    }else{
        alert('Enter Call record ID');
        return false;
    }
    var callrecordid=document.getElementById("callrecordid").value;
    var temo='';
      $.ajax({
                  url: '/index.php?r=admin_eto/NonBLAudit/Auditcheck',
                  data: {callrecordid: callrecordid},
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
    if(document.getElementById("callrecordid").value !==''){
        if(document.getElementById("callrecordid").value.match('^[0-9]+\$')){
        }else{           
            document.getElementById("callrecordid").value='';alert('Enter only Numeric Value');return false;
        }
    }else{
        alert('Enter Offer ID');
        return false;
    }
    var callrecordid=document.getElementById("callrecordid").value;
    var temo='';
      $.ajax({
                  url: '/index.php?r=admin_eto/NonBLAudit/Auditcheck',
                  data: {callrecordid: callrecordid},
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
function showuserstats(offerid,glusrid){  
    $("#showuserstat_"+offerid).hide();
    $("#showuserstats_head").hide();
    $("#userstat_"+offerid).html('Processing...');    
    $.ajax({
        type: "POST",
        url:"/index.php?r=admin_eto/OfferDetail/showuserstats&offerid="+offerid+"&glusrid="+glusrid,
                data: "",
        success: function(response){            
            $("#userstat_"+offerid).html(response);            
        }
    });        
}   
</script>
</head>
<body>
<form name="searchform" method="post" action="/index.php?r=admin_eto/NonBLAudit/Index">
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">              
<tr style="background: #dff8ff;<?php echo $btndisplay;?>">
<td style="width:20%;padding:4px;"><span style="float:left;margin:3px 0px 0px 0px;">Enter Call Record ID:</span></td>
<td style="width:20%;padding:4px;"><input type="text" id="callrecordid" name="callrecordid" style="width: 200px; float:left;margin:0px 0px 0px 3px;" maxlength="15" value="<?php echo $callrecordid ?>"></td>
<td style="padding:4px;"><input type="submit" name="search" style="font-weight:bold;margin: 0px 0px 0px 3px;float:left;width:80px;height:25px; text-align:center;" value="Search" onclick="return validate_number();"/></td></tr>
</table>
</form>               
<?php 
    if($callrecordid !=''){                  
                   if(isset($message) && $message!=''){
                        echo '<div style="color:red;text-align:center;">'.$message.'</div>';
                    }  
                    $associateID='';$tl_name='';$aon='';
                    $partner_name='';$remarks='';
                   if(isset($offerArr) && isset($offerArr['fk_leap_call_records_id'])){ //print_r($offerArr);
                       $callrecordid=$offerArr['fk_leap_call_records_id'];
                     $recording_url=isset($offerArr['call_recording_url']) ? $offerArr['call_recording_url'] : '';
                     $assoc_name=isset($offerArr['assoc_name']) ? $offerArr['assoc_name'] : '';
                     $fk_glusr_usr_id=isset($offerArr['fk_glusr_usr_id']) ? $offerArr['fk_glusr_usr_id'] : '';

                     $entered_on=isset($offerArr['entered_on']) ? $offerArr['entered_on'] : '';
                     $eto_leap_vendor_name=isset($offerArr['eto_leap_vendor_name']) ? $offerArr['eto_leap_vendor_name'] : '';
                echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
                  <tr><td>Call Record ID: '.$callrecordid.'</td><td>Call Recording:';
                if($recording_url<>''){
                    echo '&nbsp;&nbsp;<a href="'.$recording_url.'" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';
                }else{
                    echo '&nbsp;&nbsp;NA';
                }
                if($fk_glusr_usr_id <> ''){
                     echo '</td><td>Reason: ' .$offerArr['disposition_remarks'].'-'. $offerArr['call_disposition_reason'].' </td></tr>'
                        . '<tr><td>Entered on: '.$entered_on.'<br/>Glusr_usr_id: '.$fk_glusr_usr_id.' </td><td>Vendor: '.$eto_leap_vendor_name.'&nbsp;&nbsp;&nbsp; '.$assoc_name.'</td>
                            <td><span id="showuserstats_head"><b>User Stats: </b>&nbsp;</span><input type="button" name="showuserstat_' . $callrecordid . '" '
                        . 'id="showuserstat_' . $callrecordid . '" value="Show" onclick="showuserstats(' . $callrecordid . ',' . $fk_glusr_usr_id . ')">'
                        . '<span style="font-size:12px;padding:8px 15px 8px 8px; line-height:23px;letter-spacing:-0.02em;font-weight:bold" '
                        . 'id="userstat_' . $callrecordid . '"></span>
                                     </td>';
                }else{
                     echo '</td><td>Reason: ' .$offerArr['disposition_remarks'].'-'. $offerArr['call_disposition_reason'].' </td></tr>'
                        . '<tr><td>Entered on: '.$entered_on.'<br/>Glusr_usr_id: '.$fk_glusr_usr_id.' </td><td>Vendor: '.$eto_leap_vendor_name.'&nbsp;&nbsp;&nbsp; '.$assoc_name.'</td>
                            <td></td>';
                }
               
echo '</tr>
                            </table>
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<tr><td><form name="questionform" method="post" action="/index.php?r=admin_eto/NonBLAudit/Index">';
$errMsg = $auditArr['errMsg'];
if(isset($auditArr['quesArr'])){
  $quesArr = $auditArr['quesArr']; 
}

$prevQID='';
$cnt=0;
$q_cnt=0;$cnt_tr=0;
$Call_Quality ='';
echo '<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';     

if(isset($quesArr)){
foreach($quesArr as $quesValue){
    if($quesValue['QUESTION_TYPE']==10){       
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
 
echo $Call_Quality;

echo '<tr style="background: #0195d3;"><td style="font-weight:bold;padding:4px;color:#fff;" colspan="2">Remarks and Observations</td></tr>
 <tr><td style="padding:4px;" colspan="2">              
<textarea id="remarks" name="remarks" style="width: 98%; height: 100px; margin-bottom:8px; ">';
if($remarks==''){
echo "What went wrong (if any): "."\n";
 echo "Feedback/Suggestion(if any):";
}else{
    echo $remarks;
}
echo '</textarea></td></tr>
 <tr><td style="padding:4px;" colspan="2" align="center">   
<input type="submit" name="save" onclick = "return validate()" style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:80px;height:25px; text-align:center;" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input id="tot_question" name="tot_question"  type="hidden" value="'.$q_cnt.'">
<input id="selcallrecordid" name="selcallrecordid" type="hidden" value="'.$callrecordid.'">
<input id="v_name" name="v_name" type="hidden" value="'.$v_name.'">  
<input id="assoc_name" name="assoc_name" type="hidden" value="'.$offerArr['assoc_name'].'">  
<input id="selopt_val" name="selopt_val" type="hidden" value="">
   
</td>               
</tr>
</table></form></td></tr></table>'; 
}else{
    echo '<div style="color:red;text-align:center;">'.$auditArr['errMsg'].'</div>';
}
}else{
    echo '<div style="color:red;text-align:center;">No Call detail exist</div>';
}                       
}
elseif(isset($message) && $message!=''){
    echo '<div style="color:green;text-align:center;">'.$message.'</div>';
}          
echo '<div style="clear:both;"><!-- --></div></div>';

 
 
?>