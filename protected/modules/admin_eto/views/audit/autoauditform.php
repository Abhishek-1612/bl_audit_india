<?php
$team_leader    = isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa        = isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent     = isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve = isset($vendor_approve) ? $vendor_approve : 'ALL';
$tabselect      = isset($_REQUEST['tabselect']) ? $_REQUEST['tabselect'] : 3;
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
$btndisplay='';
if(isset($callfrom) && ($callfrom=='freelance')){
  $btndisplay='display:none;';  
}    
?>

<head>
    <title>Buy Lead Audit CRM
    </title>
    <LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css"> 
    <style>
    .collapsible {
        cursor: pointer;
        padding: 8px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 14px;
        font-weight: bold;
        transition: display 0.2s ease;
    }

    .plusicon:hover {
        background-color: rgba(255, 255, 255, 0.5);
        transition: font-size 0.3s ease;
    }

    .questionheading:hover {
        background-color: rgba(255, 255, 255, 0.5);
        transition: font-size 0.3s ease;
        cursor: pointer;

    }

    .active,
    .collapsible:hover {
        background-color: rgba(255, 255, 255);
        text-shadow: 2px 2px 8px #F2F2F2;
        transition: font-size 0.3s ease;
        position: relative;
        vertical-align: middle;
    }

    .content {
        display: none;
        padding: 0 4px;
        max-height: 0;
        overflow: hidden;
        transition: display 0.2s ease;

    }
    </style>   
    <script language="javascript" type="text/javascript"
        src="<?php echo$utilsHost?>/js/jquery.min.js">
    </script>
    <script type="text/javascript">
    $(function() {
        $('#searchmcat').click(function() {
            a = {};
            a['ss'] = $('#ss').val();
            result = '';
            $.ajax({
                url: "/index.php?r=admin_eto/AuditEto/Searchmcat&mid=3549",
                type: 'post',
                data: a,
                beforeSend: function() {
                    $("#searchmcatresult").html(
                        "<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processsing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>"
                    );
                },
                success: function(result) {
                    $('#searchmcatresult').html(result);
                }
            });
        });

        $('#save').click(function() {
                a = {};
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
            
            if (document.getElementById("remarks").value.trim() === '' || document.getElementById("remarks").value.trim() =='Any Other issues:') {
                alert("Please Fill Remarks ");
                return false;
            }
            document.getElementById("save").style.display = "none";
            a['selopt_val'] = sel_opt_value;           
            a['save'] = 'save';
            a['remarks'] = document.getElementById("remarks").value.trim();
            a['selofferID'] = document.getElementById("selofferID").value.trim();
            result = '';
            $.ajax({
                url: "/index.php?r=admin_eto/AuditEto/AutoAudit&mid=3881",
                type: 'post',
                data: a,
                success: function(result) {
                     document.getElementById("savediv").innerHTML ="<div style='color:green;text-align:center;'>"+result+"</div>";
                }
            }); 
        });
    });

    function validate_number() {
        if (document.getElementById("offerID").value !== '') {
            if (document.getElementById("offerID").value.match('^[0-9]+\$')) {} else {
                document.getElementById("offerID").value = '';
                alert('Enter only Numeric Value');
                return false;
            }
        } else {
            alert('Enter Offer ID');
            return false;
        }

        
        var offerID = document.getElementById("offerID").value;
        var temo = '';
        $.ajax({
            url: '/index.php?r=admin_eto/AuditEto/Auditcheck&mid=3549',
            data: {
                offerID: offerID
            },
            async: false,
            success: function(data) {
                temo1 = data.split("#");
                temo = temo1[1].replace('NA', '');
            }
        });
        if (temo.trim() != '') {
            var patt = /DDN|NOIDA/;
            if (patt.test(temo)) {
                var res = temo.replace("DDN-", "");
                var res1 = res.replace("NOIDA-", "");
                alert(res1);
                return true;
            } else {
                alert(temo);
                return false;
            }
        }
        return true;
    }

    function validate_opt(grpname){
       var group =document.getElementsByName(grpname);
        if (group[0].checked === true) {
            for (var i=1; i<group.length; i++) {
                group[i].checked = false;
            }           
        }

}



    </script>
</head>

<body>
    <form name="searchform" method="post">
        <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"
            width="100%">
            <tr style="background: #0195d3;">
                <td style="padding:4px;font-weight:bold;color:#fff;" width="45%">Offer Detail:
                    <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=<?php
echo $offerID;
?>&go=Go&mid=3424" style="text-decoration:underline;color:#fff" target="_blank">
                        <?php
echo $offerID;
?>
                  </a>
                </td>
                <td style="width:10%;padding:4px;">
                    <span style="float:left;margin:3px 0px 0px 0px;color:#fff;">Enter
                        Offer ID:
                    </span>
                </td>
                <td style="width:10%;padding:4px;">
                    <input type="text" id="offerID" name="offerID"
                        style="width: 200px; float:left;margin:0px 0px 0px 3px;" maxlength="15" value="<?php
echo $offerID;
?>">
                </td>
                <td style="padding:4px;">
                    <input type="submit" name="search" id="search" 
                        style="font-weight:bold;margin: 0px 0px 0px 3px;float:left;width:80px;height:25px; text-align:center; <?php echo $btndisplay;?>"
                        value="Search" onclick="return validate_number();" />
                </td>
            </tr>
        </table>
    </form>
    <?php
if ($offerID != '') {
    if (isset($message) && $message != '') {
        echo '<div style="color:red;text-align:center;">' . $message . '</div>';
    }
    $associateID  = '';
    $tl_name      = '';
    $aon          = '';
    $partner_name = '';
    $remarks      = '';
    
    $recNotMapResult = isset($mappedMcat['recNotMapResult'])?$mappedMcat['recNotMapResult']:'';
    $recMapResult    = isset($mappedMcat['recMapResult'])?$mappedMcat['recMapResult']:'';
    $searchkeyword   =  isset($mappedMcat['searchkeyword'])?$mappedMcat['searchkeyword']:'';

    
    
    if (isset($offerArr) && isset($offerArr['ETO_OFR_DISPLAY_ID'])) {
        $odio='';
        $recording_url = isset($offerArr['ETO_OFR_CALL_RECORDING_URL']) ? $offerArr['ETO_OFR_CALL_RECORDING_URL'] : '';
        $no_background_noise=$no_high_ros=$no_dead_air=1;
         //  echo '<pre>'; print_r($offerArr);
        if($recording_url<>''){  
            $obj           = new AuditModel;
            $odioArr      = $obj->getodiodetails($offerID);
            if($odioArr){
                $odioArr1 = json_decode($odioArr, true); 
                 //print_r($odioArr1);
                if(isset($odioArr1['STATUS'])){
                    $msg=isset($odioArr1['MSG'])?$odioArr1['MSG']:'';
                    $msg .=' Status:'.$odioArr1['STATUS'];
                    $msg = str_replace("Please try after Sometime","Still in Process. Please Wait.",$msg);
                    

                   $odio= '<tr><td colspan="3">&nbsp;&nbsp;<span style="color:red;">ODIO API Response :</span>'.$msg.'&nbsp;&nbsp;<a href="https://leap.intermesh.net/webservice/odioAudit.php?offer_id='. $offerID .'" target="_blank">&nbsp;Send Request</A></td></tr>'; 
                }else{
                $no_background_noise=isset($odioArr1['no_background_noise'])?$odioArr1['no_background_noise']:'';
                $no_high_ros=isset($odioArr1['no_high_ros'])?$odioArr1['no_high_ros']:'';
                $no_dead_air=isset($odioArr1['no_dead_air'])?$odioArr1['no_dead_air']:'';                
                $odio= '<tr><td colspan="3"> &nbsp;&nbsp;<div style="color:green;"><b>Response from ODIO API</b>  no_high_ros:'.$no_high_ros.' | no_background_noise:'.$no_background_noise.' | no_dead_air:'.$no_dead_air.'</span></td></tr>';
                }                
                }else{
               $odio= '<tr><td colspan="3">&nbsp;&nbsp;<span style="color:red;">Still in Process. Please retry.</span>&nbsp;&nbsp;<a href="https://leap.intermesh.net/webservice/odioAudit.php?offer_id='. $offerID .'" target="_blank">&nbsp;Send Request</A></td></tr>'; 
            }
        }
        echo '<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center">
<tr><td> Call Recording:';
        if ($recording_url <> '') {
            echo '&nbsp;&nbsp;<a href="' . $recording_url . '" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';
        } else {
            echo '&nbsp;&nbsp;NA';
        }

        if ($recording_url <> '') {
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer=' . $offerID . '&mid=3424" target="_blank">&#187;&nbsp;View All Recordings:</A></td>';
        }
        else{
            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;View All Recordings:</A>&nbsp;&nbsp;NA</td>';

        }
       
        echo'
<td><b> &nbsp;&nbsp; 
<a href="/index.php?r=admin_eto/ofrHist/etohistory&action=etohistory&act=ofrHist&offer=' . $offerID . '&mid=3424" target="_blank">Offer History</a></b>
</td>
<td><b>&nbsp;<a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=mapHist&offer=' . $offerID . '&status='.$offerArr['TBL_STATUS'].'&mid=3424" target="_blank">List of suppliers</a></b></td>
</tr>
'.$odio.'</table>


<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<TR>
   <td width="45%" valign="top">';
        echo $offerdetHTML;
        
        $searchkeyword['ETO_LEAD_SEARCH_KEYWORD'] = isset($searchkeyword['ETO_LEAD_SEARCH_KEYWORD'] )?$searchkeyword['ETO_LEAD_SEARCH_KEYWORD'] :'';
        $countmcat = 0;
        foreach ($recNotMapResult as $c) {
            if(  $countmcat == 0){
                echo '<fieldset style = "border:1px solid #0097CE;">';
                echo'<div><B style="margin-left: 10px;font-size:15px;color:#FF5733;">Search Keyword </B> &nbsp &nbsp &nbsp &nbsp;'.$searchkeyword['ETO_LEAD_SEARCH_KEYWORD'].'</div><br>';
                
                $countmcat =1;
            }
            
            $generic = "";
            if (isset($c['IS_GENERIC'])) {
                $generic = $c['IS_GENERIC'];
            }
            
            foreach ($recMapResult as $d) {
                if ($c['GLCAT_MCAT_NAME'] == $d['GLCAT_MCAT_NAME']) {
                    if (isset($d['IS_GENERIC'])) {
                        $generic = $d['IS_GENERIC'];
                    }
                }
            }
            if ($c['ETO_AUTO_MCAT_RANK'] > 0) {
                $statusMcat = "Selected";
                $colorcheck = "color:green;";
            } else {
                $statusMcat = "Not Selected";
                $colorcheck = "color:red;";
            }
            echo '<div id="aaa" style="white-space: nowrap; padding: 8px; cursor: pointer;">
            <span id = "mcatsubcat">' . $c['GLCAT_CAT_NAME'] . '->  </span><b>
            <span id = "mcatname" style = ' . $colorcheck . '>' . $c['GLCAT_MCAT_NAME'] . ' (' . $c['GLCAT_MCAT_ID'] . ' ) <span style = "color:maroon;">' . $generic . '</span></b> </span>
            <span id = "mcarelevancy" style = ' . $colorcheck . '>' . $c['MCAT_RELEVANCY_SCORE'] . '</span> 
                </div>';
            
        }
        if(  $countmcat == 1){
            echo '</fieldset><br>'; 
        }
        
        
        echo '
            <div>
            <form name="searchmcatForm" id="searchmcatForm" style="margin-top:0;margin-bottom:0;">
                <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
                    <tr>
                        <td class="tt" width="20%" style="vertical-align:middle;color: #08c;font-weight: bold;line-height: 20px;font-size: 14px;text-align: left;">
                        Sugg. MCAT
                        </td>
                        <td  style="border:0px;" class="tt" ><input type="text" size="20" id="ss" value="" style="font-size: 14px;font-weight: normal;line-height: 20px;"></td>
                        <td style="border:0px;" class="tt">
                        <input type="button" name="searchmcat" id="searchmcat" value="MCAT Search" ></td>
                    </tr>
                </table>
            </form>
            </div>
            <br>
            <div id="searchmcatresult">';
        echo '<div class="new_mcat_sel" id="mcatList" style="width:100%;"> ';        
        echo '</div>';
        echo '</div>
            </td>
            <td style = "vertical-align: top;">
            <form name="questionform" method="post">
';
        $errMsg = $auditArr['errMsg'];
        if (isset($auditArr['quesArr'])) {
            $quesArr = $auditArr['quesArr']; 
        }

        $prevQID = '';
        $cnt     = 0;
        $q_cnt   = 0;
        $cnt_tr  = 0;
        $Quality = '';
        $stype   = '';
        if (isset($quesArr)) {
            
$prevQID='';
$cnt=0;
$cnt_tr=0;
$Lead_Quality ='';
$stype="";
$Review_Quality='';
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
                      $Review_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;color:green;"><input checked type="radio" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'</td>';
                    }else{
                        $Review_Quality .=  '<td style="width:50%;height: 30px;vertical-align:middle;"><input  type="radio" width="100px" value="'.$optId.'" name="chk_'.$q_cnt.'" id="chk_'.$cnt_tr.'">'.$optdesc .'</td>';
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
<tr><td>
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
<div id="savediv">  
<input type="button" name="save" id="save" value="Save" 
style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:80px;height:25px; text-align:center;">
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
</td>               
                </tr>
                </table></form>';
        } else {
            echo '<div style="color:red;text-align:center;">' . $auditArr['errMsg'] . '</div>';
        }
    } else {
        echo '<div style="color:red;text-align:center;">No Offer detail exist</div>';
    }
} elseif (isset($message) && $message != '') {
    echo '<div style="color:green;text-align:center;">' . $message . '</div>';
}
?>
  </form>
</body>