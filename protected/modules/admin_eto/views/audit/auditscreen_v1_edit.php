<?php
$team_leader    = isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa        = isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent     = isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve = isset($vendor_approve) ? $vendor_approve : 'ALL';
$tabselect      = isset($_REQUEST['tabselect']) ? $_REQUEST['tabselect'] : 3;
$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';

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
    <script>
    function dropdown(parameter) 
    {
        var idvalue = 'options'+parameter;
        var coll2 = document.getElementById(idvalue);

        
        if (coll2.style.display === "table") {
                    coll2.style.display = "none";
                    coll2.style.transition="display : 2s ease-out";
                } else {
                    coll2.style.display = "table";
                    coll2.style.transition="display : 2s ease-out";
                }
    
        var idvalue2 = 'resetclass'+ parameter;
       
        var coll3 = document.getElementById(idvalue2);
        

        if (coll3.style.display === "block") {
                    coll3.style.display = "none";                    
                } else {
                    coll3.style.display = "block";
                }
    }

    function radioreset(event, parameter)
    {
        event.stopPropagation();
        var idvalue = 'options'+ parameter;       
        var coll = document.getElementById(idvalue).getElementsByTagName("input");
        coll[0].checked = true;
        coll[1].checked = true;
        for(i=2;i<coll.length;i++){
            coll[i].checked = false;
        }
       


    }
    function dropdownques(parameter) 
    {
        var idvalue = 'questionlist'+parameter;
        var coll = document.getElementsByClassName(idvalue);
        var i=0;
        for(i = 0; i<coll.length; i++){
            if (coll[i].style.display === "table-row") {
                    coll[i].style.display = "none";
                } else {
                    coll[i].style.display = "table-row";
                    coll[i].style.transition="display : 2s ease-out";
                }
              }

    }
    </script>
    <script language="javascript" type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">
    </script>
    <script type="text/javascript">
    $(function() {
        $('#searchmcat').click(function() {
            a = {};
            a['ss'] = $('#ss').val();
            result = '';
            $.ajax({
                url: "/index.php?r=admin_eto/AuditEto/Searchmcat&mid=<?php echo$mid ?>",
                type: 'post',
                data: a,
                beforeSend: function() {
                    $("#searchmcatresult").html(
                        "<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processsing.....<br></DIV>"
                    );
                },
                success: function(result) {
                    $('#searchmcatresult').html(result);
                }
            });
        });

        $('#save').click(function() {
            optionvalues = {};
            var a = {};
            var x = {};
            var tot_ques = document.getElementById("tot_question").value;
            var optionvalues = new Array();
            var sel_opt_value = '';
            cnt = 0;
            for (var i = 1; i <= tot_ques; i++) {
                var grpname = "options" + i;
                var sel_grp = false;
                var group = document.getElementById(grpname).getElementsByTagName("input");
                for (var opt = 0; opt < group.length; opt = opt + 2) {
                    if (group[opt].checked === true) {
                        optionvalues.push(group[opt].value);                               
                        x[cnt] = {
                            optionid: group[opt].value
                        };
                        cnt++;
                    }
                }
                var grpname2 = "chk_"+i+"_"+ i;
                var group2 = document.getElementsByName(grpname2);
                for (var opt = 0; opt < group2.length; opt++) {
                    if (group2[opt].checked === true) {
                        var opt2 = opt + 1;
                        
                    }
                }
            }
            
            if (document.getElementById("remarks").value.trim() === '' || document.getElementById(
                    "remarks").value.trim() ==
                'Any Other issues:') {
                alert("Please Fill Remarks ");
                return false;
            }
            document.getElementById("save").style.display = "none";
            var newArr = JSON.stringify(x);
            a['opt_array'] = newArr;
            a['save'] = 'save';
            a['audit_id'] = <?php echo$_REQUEST['audit_id']?>;
            a['remarks'] = document.getElementById("remarks").value.trim();
            a['selofferID'] = document.getElementById("selofferID").value.trim();
            if(document.getElementById('enable_emp').checked){
                a['enable_emp'] = true;
            }

            result = '';
            $.ajax({
                url: "/index.php?r=admin_eto/auditEto/AuditForm_edit&mid=<?php echo$mid ?>",
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
            url: '/index.php?r=admin_eto/AuditEto/Auditcheck&mid=<?php echo$mid ?>',
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

    function validate_opt(qcnt) {
        console.log("inside grpname");
        console.log();
        var ischecked = document.getElementById('chk_'+qcnt+'_'+'1');
        console.log(ischecked.checked);
        ischecked.checked =false;
        console.log(ischecked.checked);
        console.log( document.getElementById('chk_'+qcnt+'_'+'1').value );

    }

    function validate() {
        var tot_ques = document.getElementById("tot_question").value;

        var optionvalues = new Array();
       
        var sel_opt_value = '';
        for (var i = 1; i <= tot_ques; i++) {
            var grpname = "options" + i;
            var sel_grp = false;
            var group = document.getElementById(grpname).getElementsByTagName("input");
        


            for (var opt = 0; opt < group.length; opt = opt + 2) {
                if (group[opt].checked === true) {
                    optionvalues.push(group[opt].value);
          
                }
            }
            var grpname2 = "chk_"+i+"_" + i;
            var group2 = document.getElementsByName(grpname2);
            for (var opt = 0; opt < group2.length; opt++) {
                if (group2[opt].checked === true) {
                    var opt2 = opt + 1;                   
                }
            }
        }

        alert(document.getElementById("remarks").value);
        if (document.getElementById("remarks").value.trim() === '' || document.getElementById("remarks").value.trim() ==
            'What went wrong (if any): \nFeedback/Suggestion(if any):') {
            alert("Please Fill Remarks ");
            return false;
        }

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
        a = {};
        console.log(optionvalues);
        a['optionvalues'] = optionvalues;
        $.ajax({
            url: '/index.php?r=admin_eto/auditEto/AuditForm_edit&mid=<?php echo$mid ?>',
            data: {
                optionvalues: optionvalues
            },
            success: function(data) {
              
            }
        });
       
        //akash*************/



        var offerID = document.getElementById("offerID").value;
        var temo = '';
        $.ajax({
            url: '/index.php?r=admin_eto/AuditEto/Auditcheck&mid=<?php echo$mid ?>',
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
    </script>
</head>

<body>
    
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
  

    
    
    if (isset($offerArr) && isset($offerArr['ETO_OFR_DISPLAY_ID'])) {
       
        echo'
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<TR>';
       
        
        echo '
            <td style = "vertical-align: top;">
            <form name="questionform" method="post" action="/index.php?r=admin_eto/auditEto/AuditFrom&tabselect=1">
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
            $Review_Quality = '';
            $headings = array(
                "5" => "Lead Quality",
                "6" => "MCAT/ Supplier Mapping Quality",
                "7" => "Call Quality",
                "8" => "Contact Details"                
            );
            $Quality .= '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center" style = "border-collapse: separate;">';
            $prevQTYPE = null;
          
            
            foreach ($quesArr as $quesValue) {
                $qid     = $quesValue['QUES_ID'];
                $optId   = $quesValue['OPTIONS_ID'];
                $qdesc   = $quesValue['QUES_DESC'];
                $optdesc = $quesValue['OPTIONS_DESC'];
                $tot_q   = $quesValue['Q_OPT_CNT'];
                $qtype = $quesValue['QUESTION_TYPE'];
                
              
                
                
                if ($prevQTYPE != $qtype) {
                    if ($prevQTYPE == '') {
                        $Quality .= '
                                    <tr style="background: #0097CE; "onclick="dropdownques(' . $qtype . ')" class = "questionheading">       
                                        <td style="font-weight:bold;padding:2px;color:#fff;padding-left:12px; height:25px;font-size: 14px;">' . $headings[$qtype] . '
                                        </td>               
                                    </tr>                                  
                                    ';
                    } else {
                        $Quality .= '
                                    <tr style="background: #0097CE;"onclick="dropdownques(' . $qtype . ')"id = "qtypeid">       
                                        <td style="font-weight:bold;padding:2px;color:#fff;padding-left:12px; height:25px;font-size: 14px;">' . $headings[$qtype] . '
                                        </td>               
                                    </tr>                                  
                                    ';
                    }                    
                }
                
                if ($prevQID != $qid) {

                    $displayoptions='none';
                    $resetButton = 'none';
                    foreach($dataArr as $d){
                        if($d['OPT']!='Pass' && $qid == $d['QUESTION_ID']) {
                            $displayoptions="table";
                            $resetButton ='block';
                        }
                    }


                    $q_cnt++;
                    if ($qtype == 7) {
                        $Quality .= '  <tr class = "questionlist' . $qtype . '" style = "display:none;">';
                        
                    } else {
                        $Quality .= '  <tr class = "questionlist' . $qtype . '">';
                    }
                    $Quality .= '             <td style = "vertical-align:middle;">
                                            <div class = "collapsible"  onclick="dropdown(' . $q_cnt . ')" id="quesion' . $q_cnt . '"   title="' . $quesValue['QUESTION_HELP_TEXT'] . '">
                                                Q.' . $q_cnt . ' - ' . $qdesc . '';
                    if ($quesValue['IS_OPTIONAL'] == 0) {
                        $Quality .= '       <span style="color:red;"> * &nbsp 
                                            </span> <span onclick="" id = "resetclass' . $q_cnt . '"  style = "float:right; font-size : 12px; margin-right:20px;color: blue;text-decoration: underline;display:'.$resetButton.'; "> <a
                                            onclick="radioreset(event , ' . $q_cnt . ')"  >Reset</a></span>';
                    }

                  
                    $Quality .= '           
                                        </div>
                                            <table border="1" id="options' . $q_cnt . '" width: 30% style="  margin-left: 45px;display:'. $displayoptions.';border-collapse: collapse; " bordercolor="#d7f3ff"  width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="width:30%;height: 30px;vertical-align:middle;"> </td>
                                                    <td style="width:30%;height: 30px;vertical-align:middle; font-style:bold; font-weight:bold;" >Error</td>
                                                    <td style="width:30%;height: 30px;vertical-align:middle; font-style:bold; font-weight:bold;">Feedback</td>
                                                </tr>';
                    $cnt1     = 0;
                    $prevQID1 = '';
                    $cnt_tr1 = 0;                  
                    $cnt_tr55  = 0;
                    $cnt_tr155 = 0;
                    foreach ($quesArr as $quesValue1) { 
                        $qid1     = $quesValue1['QUES_ID'];
                        $qid1     = $quesValue1['QUES_ID'];
                        $optId1   = $quesValue1['OPTIONS_ID'];
                        $qdesc1   = $quesValue1['QUES_DESC'];
                        $optdesc1 = $quesValue1['OPTIONS_DESC'];
                        $tot_q1   = $quesValue1['Q_OPT_CNT'];                        
                        $qtype = $quesValue['QUESTION_TYPE'];
                        
                        if ($prevQID1 != $qid1) {
                            $cnt_tr1 = 0;
                        }
                        $cnt_tr1++;                        
                        $cnt_tr55++;
                        
                        if ($qid1 == $qid) {
                             $checked = '';                            
                            foreach($dataArr as $d){
                                if($d['OPT'] == $optdesc1 && $qid == $d['QUESTION_ID']){
                                    $checked = 'checked';
                                    break;
                                }
                                
                            }
                            if($optdesc1 == "Dead-air observed - Error"){
                             $optdesc1 = "Dead air observed - Error";
                            }

                            if($optdesc1 == "Dead-air observed - Feedback"){
                                $optdesc1 = "Dead air observed - Feedback";
                               }
                        
                            $optdescextract = strstr($optdesc1, '-', true);
                            if ($optdesc1 == 'Pass') {   
                                                  
                                $Quality .= '
                                    <td style="width:50%;height: 30px;vertical-align:middle;color:green;display:none;">
                                        <input style ="height:0px;" type="radio" width="100px" value="' . $qid1 . '#' . $optId1 . '" name="' . $optdescextract . '"  id="chk_' . $q_cnt . '_' . $cnt_tr1 . '"'.$checked.'>' . $optdesc1 . '
                                        <input style ="display:none;"type="hidden" name="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" id="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" value="' . $optdesc1 . '">
                                    </td>
                                    ';
                                
                            } else {
                                
                                if ($cnt_tr155 % 2 == 0) {
                                    $Quality .= '<td style="width:30%;height: 30px;vertical-align:middle; font-size:14px;">' . $optdescextract . '</td>';
                                }
                               
                                $Quality .= '
                                <td style="width:30%;height: 30px;vertical-align:middle float :left; ">
                                    <input onclick="validate_opt(' . $q_cnt . ')" type="radio" width="100px" value="' . $qid1 . '#' . $optId1 . '" name="' . $optdescextract . '" id="chk_'.$q_cnt.'_'.$cnt_tr1.'" '.$checked.'>
                                    <input type="hidden" name="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" id="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" value="' . $optdesc1 . '">
                                </td>
                                ';
                                $cnt_tr155++;
                                if ($cnt_tr155 % 2 == 0) {
                                    $Quality .= '</tr>';
                                }
                            }
                        }
                        $prevQID1 = $qid1;
                    }
                    $Quality .= '             </table>
                                        </td>
                                    </tr>
                                ';
                    $cnt_tr = 0;
                    
                }
                $Quality .= '';
                $prevQID   = $qid;
                $prevQTYPE = $qtype;
                
                
                
            }
            echo $Quality . '</td>';
            echo '<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:2px;color:#fff;padding-left:12px; height:25px;font-size: 14px;" colspan="2">Remarks and Observations</td>               
</tr>
<tr>       
<td style="padding:4px;" colspan="2">              
<textarea id="remarks" name="remarks" style="width: 98%; height: 100px; margin-bottom:8px; ">';
if(isset($dataArr[0]['REMARKS'])){
    print($dataArr[0]['REMARKS']);
}
    
            echo '</textarea></td>               
</tr>
<tr>       
<td style="padding:4px;" colspan="2" align="center">
<div id="savediv">  
<input type="button" name="save" id="save" value="Save" style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:80px;height:25px; text-align:center;">

<input type="checkbox" name="enable_emp" id="enable_emp" value="enable_emp" checked>&nbsp;Enable login credential as feedback provided in person to associate
</div>
<input id="tot_question" name="tot_question"  type="hidden" value="' . $q_cnt . '">
<input id="selofferID" name="selofferID" type="hidden" value="' . $offerID . '">
<input id="auditors_name" name="auditors_name" type="hidden" value="' . $auditors_name . '"> 
<input id="v_name" name="v_name" type="hidden" value="' . $v_name . '"> 
<input id="selopt_val" name="selopt_val" type="hidden" value="">
<input id="stype" name="stype" type="hidden" value="' . $stype . '">
</td>               
</tr>
</table></form></td></tr></table>';

            
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
