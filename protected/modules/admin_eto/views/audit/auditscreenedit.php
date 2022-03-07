<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<head>
<title>Leap Audit CRM</title>
<script type="text/javascript" src="../protected/js/animatedcollapse.js"></script>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>

 

<script type="text/javascript">
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
           
            
        }
       
        
        document.getElementById("selopt_val").value=sel_opt_value;
       
        if(document.getElementById("remarks").value.trim()=='')
        {
                alert("Please Fill the Remarks ");
                return false;
        }
   return true;
}

function validate_number(){    
    if(document.getElementById("offerID").value !==''){
        if(document.getElementById("offerID").value.match('^[0-9]+\$')){
            return true;
        }else{            
            document.getElementById("offerID").value='';alert('Enter only Numeric Value');return false; 
        }
    }else{
        alert('Enter Offer ID');
        return false;
    }
    
}

function checkvalidate()
{
var offer_id=document.getElementById("offer_id").value.trim();
if(offer_id !==''){
        if(offer_id.match('^[0-9]+\$')){
        }else{            
            alert('Enter only Numeric Value in Offer ID');
            return false; 
        }
    }
    
    var audit_id=document.getElementById("audit_id").value.trim();
    if(audit_id !==''){
        if(audit_id.match('^[0-9]+\$')){
        }else{            
            alert('Enter only Numeric Value in Audit ID');
            return false; 
        }
        
        if(audit_id !=='' && offer_id !=='')
        {
         alert('Search by only One parameter offer Id OR  Audit ID');
            return false;
        }
    }
    
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
            
        }
        document.getElementById("selopt_val").value=sel_opt_value;
       
        if(document.getElementById("remarks").value.trim()==='' || document.getElementById("remarks").value.trim())
        {
                alert("Please Fill Remarks ");
                return false;
        }
   return true;
}
</script>

<style type="text/css">
.dark{background : #eefaff;     }.wbg{background : #ffffff;      }.fnt{font-size:12px;width:33%;height:15px;}
.tab-container{ background:#ffffff; width:98%; margin:0px auto; border:1px solid #80c0e5;}.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
.data_off{display:none}.data_on{display:block}
.nav{ float:left;width:100%;}.nav ul{ padding:0px; margin:0px;}.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
.nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
.nav ul li a:hover{color:#000000; text-decoration:none;}.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}
</style>
</head>


<?php if($offerID !=''){
    $display='';
                   
                  if(isset($message) && $message!=''){
                   echo '<div style="color:green;text-align:center;">'.$message.'</div>';
               }
               
               
                    $associateID='';$tl_name='';$aon='';
                    $partner_name='';$remarks='';
                   if(isset($offerArr) && isset($offerArr['ETO_OFR_DISPLAY_ID'])){
                       
                    $associateID=$offerArr['ASSOC_NAME'];
                    $partner_name=$offerArr['ETO_LEAP_VENDOR_NAME'];
                    $tl_name=$offerArr['TL_NAME'];
                    $aon=$offerArr['AON_FLAG'];
                    $remarks=isset($dataArr[1][7]) ? $dataArr[1][7] : '';

                echo '<form name="questionform" method="post" action="/index.php?r=admin_eto/auditEto/Auditedit">
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
                </tr></table>';
 

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
                    if(isset($dataArr[1][$q_cnt+7]))
                    {
                    $QuesRes=explode(',',$dataArr[1][$q_cnt+7]);
                    }
                    else
                    {
                     $QuesRes=array();
                    }
                    if(in_array($optdesc,$QuesRes))
                    {
                     $selected='checked';
                    }
                    else
                    {
                     $selected='';
                    }
                 
                    
                    if($optdesc=='Pass'){
                        $Call_Quality .= '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input  onclick = "validate_opt(this.name)"   type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                         $Call_Quality .= '<td style="width:50%;height: 30px;vertical-align:middle;"><input  onclick = "validate_opt(this.name)"   type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
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
if($Call_Quality <>''){ 
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">             
<tr style="background: #0195d3;">		
<td style="font-weight:bold;padding:4px;color:#fff;">Call Quality</td>                
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';      
echo $Call_Quality.'</table></td></tr>';
}
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
                    if(isset($dataArr[1][$q_cnt+7]))
                    {
                    $QuesRes=explode(';',$dataArr[1][$q_cnt+7]);
                    }
                    else
                    {
                     $QuesRes=array();
                    }
                    if(in_array($optdesc,$QuesRes))
                    {
                     $selected='checked';
                    }
                    else
                    {
                     $selected='';
                    }
                    
                    if($cnt_tr%2 == 1){
                        $Lead_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                      $Lead_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input  onclick = "validate_opt(this.name)"   type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                        $Lead_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input  onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
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
if($Lead_Quality<>'') {
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">             
<tr style="background: #0195d3;">		
<td style="font-weight:bold;padding:4px;color:#fff;">Lead Quality</td>                
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
      
echo $Lead_Quality.'</table></td></tr>';
}

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
                    if(isset($dataArr[1][$q_cnt+7]))
                    {
                    $QuesRes=explode(' , ',$dataArr[1][$q_cnt+7]);
                    }
                    else
                    {
                     $QuesRes=array();
                    }
                    if(in_array($optdesc,$QuesRes))
                    {
                     $selected='checked';
                    }
                    else
                    {
                     $selected='';
                    }
                    
                    if($cnt_tr%2 == 1){
                        $Review_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                      $Review_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input  onclick = "validate_opt(this.name)"   type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                        $Review_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input  onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
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
 if($Review_Quality<>'') {
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;">Review Lead Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
echo $Review_Quality.'</table></td></tr>';
}
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
                    if(isset($dataArr[1][$q_cnt+7]))
                    {
                    $QuesRes=explode(';',$dataArr[1][$q_cnt+7]);
                    }
                    else
                    {
                     $QuesRes=array();
                    }
                    if(in_array($optdesc,$QuesRes))
                    {
                     $selected='checked';
                    }
                    else
                    {
                     $selected='';
                    }
                    
                    if($cnt_tr%2 == 1){
                        $Ban_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                      $Ban_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input  onclick = "validate_opt(this.name)"   type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                        $Ban_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input  onclick = "validate_opt(this.name)"  type="checkbox" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
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
if($Ban_Quality<>'') {
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;">Ban Lead Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';   
echo $Ban_Quality.'</table></td></tr>';
}

$auto_Quality='';
foreach($quesArr as $quesValue){
     if($quesValue['QUESTION_TYPE']==11){
        $stype="AUTO";
                    $cnt++;                    
                    $qid = $quesValue['QUES_ID']; 
                    $optId = $quesValue['OPTIONS_ID']; 
		    $qdesc = $quesValue['QUES_DESC'];
		    $optdesc = $quesValue['OPTIONS_DESC'];
                    $tot_q=$quesValue['Q_OPT_CNT'];
                    if($prevQID!=$qid){
                        if($prevQID!=''){
                            $auto_Quality .= '</tr></table></td><tr>';   
                        }
                        $q_cnt++;
                        $auto_Quality .='<tr><td><div id="quesion'.$q_cnt .'" style="height: 30px;vertical-align:middle;" title="'.$quesValue['QUESTION_HELP_TEXT'].'"><b>Question '.$q_cnt .'- '. $qdesc.'</b>';
                        if($quesValue['IS_OPTIONAL'] == 0){
                           $auto_Quality .='<span style="color:red;"> *</span>';
                        }
                        $auto_Quality .= '</div><table border="1" style="border-collapse: collapse;" bordercolor="#d7f3ff"  width="100%" cellpadding="0" cellspacing="0">';
                        $cnt_tr=0;
                    }
                    
                    $cnt_tr++;
                    if(isset($dataArr[1][$q_cnt+7]))
                    {
                    $QuesRes=explode(';',$dataArr[1][$q_cnt+7]);
                    }
                    else
                    {
                     $QuesRes=array();
                    }
                    if(in_array($optdesc,$QuesRes))
                    {
                     $selected='checked';
                    }
                    else
                    {
                     $selected='';
                    }
                    
                    if($cnt_tr%2 == 1){
                        $auto_Quality .= '<tr>';
                    }
                    if($optdesc=='Pass'){
                      $auto_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;">'
                              . '<input  type="radio" width="100px" value="'.$optId.'" '
                              . 'name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .'<input type="hidden" '
                              . 'name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }else{
                        $auto_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input type="radio" width="100px" value="'.$optId.'" '
                                . 'name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'" '.$selected.'>'.$optdesc .''
                                . '<input type="hidden" name="chkH_'.$q_cnt.'_'.$cnt_tr.'" id ="chkH_'.$q_cnt.'_'.$cnt_tr.'" value="'.$optdesc.'"></td>';
                    }
                    
                    $prevQID=$qid;
                    if($tot_q==$cnt){
                        if($tot_q%2==1){
                            $auto_Quality .= '<td>&nbsp;</td>';  
                        }
                        $auto_Quality .= '</tr></table></div></td><tr>';  
                    }    
     }                     
 }
if($auto_Quality<>'') {
$display='display:none';
echo '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;">Auto Lead Quality</td>               
</tr><td>
<table style="border-collapse: collapse;" width="99%" border="0" bordercolor="#bedaff" cellpadding="8" cellspacing="4">';
 
echo $auto_Quality.'</table></td></tr>';
}
$remark_display='';
if(isset($_REQUEST['r']) && $_REQUEST['r']==1){
    $remark_display="display:none;";
}
echo '<tr style="background: #0195d3;'.$remark_display.'">		
		<td style="font-weight:bold;padding:4px;color:#fff;" colspan="2">Old Remarks and Observations</td>                
                </tr> 
 <tr style="'.$remark_display.'">		
		<td style="padding:4px;" colspan="2">               
<textarea id="remarks1" name="remarks1" style="width: 100%; height: 100px; " readonly>';
if($remarks==''){
echo "What went wrong (if any): "."\n";
 echo "Feedback/Suggestion(if any):";
}else{

$remarks = preg_replace("(<br>+)", "\n", $remarks);
    echo $remarks;
}
echo '</textarea></td>                
                </tr>
                
 <tr style="background: #0195d3;">		
		<td style="font-weight:bold;padding:4px;color:#fff;" colspan="2">New Remarks and Observations</td>                
                </tr> 
 <tr>		
		<td style="padding:4px;" colspan="2">               
<textarea id="remarks" name="remarks" style="width: 100%; height: 100px; margin-bottom:8px; ">';
echo '</textarea></td>                
                </tr>               
                
                
 <tr>		
<td style="padding:4px;" colspan="2" align="center">    
<input type="submit" name="save" onclick = "return validate()" style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:80px;height:25px; text-align:center;" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span style="'.$display.'"><input type="checkbox" name="enable_emp" id="enable_emp" value="enable_emp" checked>&nbsp;Enable login credential as feedback provided in person to associate
</span><input id="audit_id" name="audit_id"  type="hidden" value="'.$auditId.'">
<input id="offer_id" name="offer_id" type="hidden" value="'.$offerID.'">
<input id="auditors_name" name="auditors_name" type="hidden" value="'.$auditors_name.'">  
<input id="ven_audit" name="ven_audit" type="hidden" value="'.$vendor_audit.'">
<input id="ven_app" name="ven_app" type="hidden" value="'.$vendor_approve.'">
<input id="sd" name="sd" type="hidden" value="'.$start_date.'">
<input id="ed" name="ed" type="hidden" value="'.$end_date.'">
<input id="selopt_val" name="selopt_val" type="hidden" value="">
<input id="tot_question" name="tot_question"  type="hidden" value="'.$q_cnt.'">
<input id="associateID" name="associateID"  type="hidden" value="'.$associateID.'">
<input id="stype" name="stype"  type="hidden" value="'.$stype.'">
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
                

