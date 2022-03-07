<?php 
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
?>
<head>
<title>Buy Lead Audit CRM</title>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
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
    clearInterval(xtimer); 
   return true;
}
</script>
</head>
<body>
 <?php if($message!=''){
        echo '<div style="padding:4px;font-weight:bold;color:red;">' . $message . '</div>';
    }?>
<?php
    if($offerID !=''){
                  
                    $associateID='';$tl_name='';$aon='';
                    $partner_name='';$remarks='';
                   if(isset($offerArr) && isset($offerArr['ETO_OFR_DISPLAY_ID'])){
                    $associateID=$offerArr['ASSOC_NAME'];
                    $partner_name=$offerArr['ETO_LEAP_VENDOR_NAME'];
                    $tl_name=$offerArr['TL_NAME'];
                    $aon=$offerArr['AON_FLAG'];
                    $recording_url=isset($offerArr['ETO_OFR_CALL_RECORDING_URL']) ? $offerArr['ETO_OFR_CALL_RECORDING_URL'] : '';  


                echo '<form name="questionform" method="post">
                    <table border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
                   <tr style="background: #0195d3;">       
        <td style="padding:4px;font-weight:bold;color:#fff;" colspan="4">Offer Detail - <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$offerID.'&go=Go&mid=3424" style="text-decoration:underline;color:#fff" target="_blank">'.$offerID.'</a></td>               
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


$prevQID='';//print_r($quesArr);
$cnt=0;
$cnt_tr=0;
$Lead_Quality ='';
$stype="";
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
<div id="savediv" style="display:none;"> 
<input type="submit" name="save" id="save" onclick = "return validate()" 
style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:120px;height:25px; text-align:center;" value="Save & Next"/>&nbsp;
<input type="submit" id="save_close" name="save_close" onclick = "return validate()" 
style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:120px;height:25px; text-align:center;" 
value="Save & Exit"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</div>
<input id="tot_question" name="tot_question"  type="hidden" value="'.$q_cnt.'">
<input id="selofferID" name="selofferID" type="hidden" value="'.$offerID.'">
<input id="auditors_name" name="auditors_name" type="hidden" value="'.$auditors_name.'"> 
<input id="v_name" name="v_name" type="hidden" value="'.$v_name.'"> 
<input id="selopt_val" name="selopt_val" type="hidden" value="">
<input id="stype" name="stype" type="hidden" value="'.$stype.'">
<input id="status" name="status" type="hidden" value="'.$status.'">
<input id="job_id" name="job_id" type="hidden" value="'.$job_id.'">
<input id="job_type_id" name="job_type_id" type="hidden" value="'.$job_type_id.'">    
<input id="job_type" name="job_type" type="hidden" value="'.$job_type_id.'"> 
<input type="hidden" name="maxtimelimit" id="maxtimelimit" value="'.$maxtimelimit.'">  
<input type="hidden" name="mintimelimit" id="mintimelimit" value="'.$mintimelimit.'">   
<input type="hidden" name="midfortimer" id="midfortimer" value="'.$mid_for_timer.'">     
</td>               
                </tr>
                </table></form><div id="add_to_me"></div><script src="protected\js\timerforall.js?v=8"></script>  
                <link rel="stylesheet" href="protected\css\timerforall.css">';


    }else{
        echo '<div style="color:red;text-align:center;">'.$auditArr['errMsg'].'</div>';
    }

    }else{
        echo '<div style="color:red;text-align:center;">No Offer detail exist</div>';
    }
}              

