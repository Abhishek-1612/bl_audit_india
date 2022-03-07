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
    <script type="text/javascript">
  function showhide(){
      if(document.getElementById("tblodio").style.display == "none"){
        document.getElementById("tblodio").style.display = "";
        document.getElementById("sp_odio").innerHTML ='Hide';
      }else{
          document.getElementById("tblodio").style.display = "none";
          document.getElementById("sp_odio").innerHTML ='Show';
      }
}      
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
    <script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script>
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
                        "<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processsing.....<br><IMG SRC='/gifs/loading2.gif' align='absmiddle'></DIV>"
                    );
                },
                success: function(result) {
                    $('#searchmcatresult').html(result);
                }
            });
        });

   });


    function validate_opt(qcnt) {
      
        var ischecked = document.getElementById('chk_'+qcnt+'_'+'1');
        ischecked.checked =false;

    }

    function validate() {
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
            }
            
            if (document.getElementById("remarks").value.trim() === '' || document.getElementById(
                    "remarks").value.trim() ==
                'Any Other issues:') {
                alert("Please Fill Remarks ");
                return false;
            }
            document.getElementById("save").style.display = "none";
            document.getElementById("save_close").style.display = "none";
            clearInterval(xtimer);
            var newArr = JSON.stringify(x);
            document.getElementById("selopt_val").value= newArr;
        return true;
    }
      function validate_close() {
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
            } 
            
            if (document.getElementById("remarks").value.trim() === '' || document.getElementById(
                    "remarks").value.trim() ==
                'Any Other issues:') {
                alert("Please Fill Remarks ");
                return false;
            }
            document.getElementById("save").style.display = "none";
            document.getElementById("save_close").style.display = "none";
            clearInterval(xtimer);
            var newArr = JSON.stringify(x);
            document.getElementById("selopt_val").value= newArr;
        return true;
    }
    
    
  </script>
</head>

<body>
        <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"
            width="100%">
            <tr style="background: #F0F9FF;">
                <td style="padding:4px;font-weight:bold;color:#3b5998;" width="45%">Offer Detail:
                    <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=<?php
echo $offerID;
?>&go=Go&mid=3424" style="text-decoration:underline;color:#3b5998" target="_blank">
                        <?php
echo $offerID;
?>
                  </a>
                </td>
                <td>  
     <?php  if (isset($message) && $message != '') {
            if(preg_match('/successfully/i', $message)){
                echo '<div style="padding:4px;font-weight:bold;color:green;">' . $message . '</div>';
            }elseif(preg_match('/already/i', $message)){
                echo '<div style="padding:4px;font-weight:bold;color:red;">' . $message . '</div>';
            }else{
                echo '<div style="padding:4px;font-weight:bold;color:red;">' . $message . '</div>';
            }
    }
    ?></td>
        </tr>
        </table>
    <?php
if ($offerID != '') {
    $associateID  = '';
    $tl_name      = '';
    $aon          = '';
    $partner_name = '';
    $remarks      = '';
    
    $recNotMapResult = isset($mappedMcat['recNotMapResult'])?$mappedMcat['recNotMapResult']:'';
    $recMapResult    = isset($mappedMcat['recMapResult'])?$mappedMcat['recMapResult']:'';
    $searchkeyword   =  isset($mappedMcat['searchkeyword'])?$mappedMcat['searchkeyword']:'';

    //echo '<pre>'; print_r($offerArr);

    if (isset($offerArr) && isset($offerArr['ETO_OFR_DISPLAY_ID'])) {
        $odio='';
        $recording_url = isset($offerArr['ETO_OFR_CALL_RECORDING_URL']) ? $offerArr['ETO_OFR_CALL_RECORDING_URL'] : '';
        $eto_leap_vendor_name = isset($offerArr['ETO_LEAP_VENDOR_NAME']) ? $offerArr['ETO_LEAP_VENDOR_NAME'] : '';
        $no_background_noise=$no_high_ros=$no_dead_air=$call_cl_opt=$call_co_opt=$call_co3_opt=1;
        $call_co=$call_co1=$call_co2=$call_co3=$call_co4=$call_co5='';
        $call_cl=$call_cl1=$call_cl2=$call_cl3=$call_cl4='';

         //  echo '<pre>'; print_r($offerArr);
        if(($recording_url<>'') && ($eto_leap_vendor_name <> 'CONNECT_C2C')){  
            $obj           = new AuditModel;
            $odioArr      = $obj->getodiodetails($offerID);
            if($odioArr){
                $ros=$dead_air=$background_noise='';
                $odioArr1 = json_decode($odioArr, true);// echo '<pre>'; print_r($odioArr1);
                if(isset($odioArr1['STATUS'])){
                    $msg=isset($odioArr1['MSG'])?$odioArr1['MSG']:'';
                    $msg .=' Status:'.$odioArr1['STATUS'];
                    $msg = str_replace("Please try after Sometime","Still in Process. Please Wait.",$msg);
                   $odio= '<tr><td colspan="3">&nbsp;&nbsp;<span style="color:red;">ODIO API Response :</span>'.$msg.''
                           . '&nbsp;&nbsp;<a href="/index.php?r=admin_eto/Odio/sendodio&mid=3940&offer_id='. $offerID .'" target="_blank">&nbsp;Send Request</A></td></tr>'; 
                }else{
                    if(isset($odioArr1['no_background_noise'])){
                       $no_background_noise=$odioArr1['no_background_noise'];
                       if($no_background_noise == 0){
                            $background_noise=$odioArr1['background_noise_time_stamp'];
                            }
                    }
                    if(isset($odioArr1['no_high_ros'])){
                        $no_high_ros=$odioArr1['no_high_ros'];
                        if($no_high_ros == 0){
                        $ros_time_stamp=$odioArr1['ros_time_stamp'];
                        foreach($ros_time_stamp as $row){
                            $ros .='<tr><td>'.@$row['ros'].'</td><td>'.@$row['start_time'].'</td><td>'.@$row['till_time'].'</td></tr>';
                        }
                        $ros ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" 
                            bordercolor="#bedaff" border="1"><tr><td>ROS (Words/second)</td><td>START_TIME</td><td>TILL_TIME</td></tr>'.$ros.'</table>';
                        }
                    }
                    if(isset($odioArr1['no_dead_air'])){
                        $no_dead_air=$odioArr1['no_dead_air'];
                        if($no_dead_air == 0){
                            $dead_air=$odioArr1['dead_air_time'];
                        }
                        }
                    if(isset($odioArr1['call_opening_parameter'])){
                        $call_opening_parameter=$odioArr1['call_opening_parameter'];
                        $call_co=@$odioArr1['no_call_introduction_error'];
                        $call_co1=@$call_opening_parameter['Agent_Name'];
                        $call_co2=@$call_opening_parameter['Client_Name'];
                        $call_co3=@$call_opening_parameter['Greet_Buyer'];
                        $call_co4= @$call_opening_parameter['Recorded_Line'];
                        $call_co5= @$call_opening_parameter['Purpose_Of_Call'];
                    }
                    if(isset($odioArr1['no_call_introduction_error'])){
                        $call_co_opt=$odioArr1['no_call_introduction_error'];
                    }
                    if(isset($odioArr1['call_opening_parameter'])){
                        $arr_co=$odioArr1['call_opening_parameter'];
                        if(isset($arr_co['Greet_Buyer'])){
                            $call_co3_opt=$arr_co['Greet_Buyer'];
                        }
                    }
                    if(isset($odioArr1['no_call_closing_error'])){
                        $call_cl_opt=$odioArr1['no_call_closing_error'];
                    }   
                    if(isset($odioArr1['call_closing_parameter'])){
                        $call_closing_parameter=$odioArr1['call_closing_parameter'];
                        $call_cl=@$odioArr1['no_call_closing_error'];                        
                        $call_cl1=@$call_closing_parameter['Expectation_Explained'];
                        $call_cl2=@$call_closing_parameter['Feedback_Mentioned'];
                        $call_cl3= @$call_closing_parameter['End_Greeting'];
                    }
                    if(isset($odioArr1['no_background_noise']) && isset($odioArr1['no_high_ros']) && isset($odioArr1['no_dead_air'])){
                        $odio= '<tr><td colspan="3"><b>ODIO Results&nbsp;&nbsp;<a id="sp_odio" href="#" onclick="showhide();return false;">Hide</a></b>
                            <div id="tblodio"><table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" 
                            bordercolor="#bedaff" border="1">
<tr><td width="10%"><b>SN</b></td>'
                                . '<td  width="20%"><b>ODIO Audit Parameter</b></td><td  width="10%"><b>Response</b></td><td  width="60%"><b>Time Stamp</b></td></tr>'
                                . '<tr><td>1</td><td>no_background_noise</b></td><td>'.$no_background_noise.'</td><td>'.$background_noise.'</td></tr>'
                                . '<tr><td>2</td><td>no_high_ros</b></td><td>'.$no_high_ros.'</td><td>'.$ros.'</td></tr>'
                                . '<tr><td>3</td><td>no_dead_air</b></td><td>'.$no_dead_air.'</td><td>'.$dead_air.'</td></tr>'
                             . '<tr><td>4</td><td>Greet_Buyer</b></td><td>'.$call_co3.'&nbsp;</td></tr>'

                                . '<tr><td>5</td><td>no_call_introduction_error</b></td><td>'.$call_co.'</td><td><table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" 
                            bordercolor="#bedaff" border="1"><tr><td>Agent_Name:'.$call_co1.'&nbsp;</td><td>'
                                . 'Client_Name:'.$call_co2.'&nbsp;</td><td>Recorded_Line:'.$call_co4.'&nbsp;</td>'
                                . '<td>Purpose_Of_Call:'.$call_co5.'</td></tr></table></td></tr>'
                                . '<tr><td>6</td><td>no_call_closing_error</b></td><td>'.$call_cl.'</td><td><table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" 
                            bordercolor="#bedaff" border="1"><td>Expectation_Explained:'.$call_cl1.'&nbsp;'
                                . '</td><td>Feedback_Mentioned:'.$call_cl2.'&nbsp;</td><td></td><td>End_Greeting:'.$call_cl3.'</td></tr></table></td></tr></table></div></td></tr>';
                    }else{
                        $odio= '<tr><td colspan="3">&nbsp;&nbsp;<span style="color:red;">Error in Response. Please retry.</span>&nbsp;&nbsp;<a href="/index.php?r=admin_eto/Odio/sendodio&mid=3813&offer_id='. $offerID .'" target="_blank">&nbsp;Send Request</A></td></tr>'; 
                   } 
                }
                }else{
               $odio= '<tr><td colspan="3">&nbsp;&nbsp;<span style="color:red;">Still in Process. Please retry.</span>&nbsp;&nbsp;<a href="/index.php?r=admin_eto/Odio/sendodio&mid=3813&offer_id='. $offerID .'" target="_blank">&nbsp;Send Request</A></td></tr>'; 
            }
        }

        echo '<table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" style="background-color:#fff">
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


<table style="border-collapse: collapse;background-color:#fff" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
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
                <table style="background-color:#fff;border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
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
        
        $sr              = 0;
        $imgSr           = 50;
        $tabcnt          = 60;
        $chmcatids       = array();
        $color_arr       = array(
            "#00a907",
            "#008CBA",
            "#f44336",
            "#555555",
            "#9936f4",
            "#ce8602"
        );
        $color_flag      = 0;
        $cat_id_temp_arr = array();
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
            $Review_Quality = '';
            $headings = array(
                "5" => "Lead Quality",
                "6" => "MCAT/ Supplier Mapping Quality",
                "7" => "Call Quality",
                "8" => "Contact Details"                
            );
            $Quality .= '<table  border="0" cellpadding="0" cellspacing="1" width="100%" align="center" style = "border-collapse: separate;background-color:#fff;">';
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
                                    <tr style="background: #29abe0; "onclick="dropdownques(' . $qtype . ')" class = "questionheading">       
                                        <td style="font-weight:bold;padding:2px;color:#fff;padding-left:12px; height:25px;font-size: 14px;">' . $headings[$qtype] . '
                                        </td>               
                                    </tr>                                  
                                    ';
                    } else {
                        $Quality .= '
                                    <tr style="background: #29abe0;"onclick="dropdownques(' . $qtype . ')"id = "qtypeid">       
                                        <td style="font-weight:bold;padding:2px;color:#fff;padding-left:12px; height:25px;font-size: 14px;">' . $headings[$qtype] . '
                                        </td>               
                                    </tr>                                  
                                    ';
                    }                    
                }
                if ($prevQID != $qid) {
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
                                            </span> <span onclick="" id = "resetclass' . $q_cnt . '"  style = "float:right; font-size : 12px; margin-right:20px;color: blue;text-decoration: underline;display:none; "> <a
                                            onclick="radioreset(event , ' . $q_cnt . ')"  >Reset</a></span>';
                    }
                    $Quality .= '           
                                        </div>
                                            <table border="1" id="options' . $q_cnt . '" width: 30% style="  margin-left: 45px;display:none;border-collapse: collapse; " bordercolor="#d7f3ff"  width="100%" cellpadding="0" cellspacing="0">
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
                        $optId1   = $quesValue1['OPTIONS_ID'];
                        $qdesc1   = $quesValue1['QUES_DESC'];
                        $optdesc1 = $quesValue1['OPTIONS_DESC'];
                        $tot_q1   = $quesValue1['Q_OPT_CNT'];

                        if($optdesc1 == "Dead-air observed - Error"){                            
                         $optdesc1 = "Dead air observed - Error";
                        }

                        if($optdesc1 == "Dead-air observed - Feedback"){
                            $optdesc1 = "Dead air observed - Feedback";
                           }
                        $checkedradio='';
                        if(($qid1==27) && ($optId1==203) && ($no_high_ros==0)){
                            $checkedradio='checked';
                        }
                        if(($qid1==29) && ($optId1==214) && ($no_background_noise==0)){
                            $checkedradio='checked';
                        }
                        if(($qid1==29) && ($optId1==218) && ($no_dead_air==0)){
                            $checkedradio='checked';
                        }
                        $checkedradio_paas='checked';
                        if(($qid1==27) && ($optId1==194) && (($no_high_ros==0) || ($call_co3_opt==0) || ($call_co_opt==0) || ($call_cl_opt==0))){
                            $checkedradio_paas='';
                        }
                        if(($qid1==29) && ($optId1==213) && (($no_background_noise==0) || ($no_dead_air==0))){
                            $checkedradio_paas='';
                        }
                        if(($qid1==27) && ($optId1==195) && ($call_co3_opt==0)){ //Greetings not done on call
                            $checkedradio='checked';
                        }
                        if(($qid1==27) && ($optId1==197) && ($call_co_opt==0)){ //Introduction / Call Purpose not shared
                            $checkedradio='checked';
                        }
                        if(($qid1==27) && ($optId1==207) && ($call_cl_opt==0)){ //Call closing error
                            $checkedradio='checked';
                        }
                        $qtype = $quesValue['QUESTION_TYPE'];
                        
                        if ($prevQID1 != $qid1) {
                            $cnt_tr1 = 0;
                        }
                        $cnt_tr1++;                        
                        $cnt_tr55++;
                        
                        if ($qid1 == $qid) {
                            
                            $optdescextract = strstr($optdesc1, '-', true);
                            if ($optdesc1 == 'Pass') {
                                 $Quality .= '<td style="width:50%;height: 30px;vertical-align:middle;color:green;display:none;">
                                        <input style ="height:0px;" type="radio" width="100px" value="' . $qid1 . '#' . $optId1 . '" name="' . $optdescextract . '"  id="chk_' . $q_cnt . '_' . $cnt_tr1 . '" '.$checkedradio_paas.'>' . $optdesc1 . '
                                        <input style ="display:none;"type="hidden" name="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" id="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" value="' . $optdesc1 . '">
                                    </td>';  
                            } else {
                                
                                if ($cnt_tr155 % 2 == 0) {
                                    $Quality .= '<td style="width:30%;height: 30px;vertical-align:middle; font-size:14px;">' . $optdescextract . '</td>';
                                }
                                
                                $Quality .= '
                                <td style="width:30%;height: 30px;vertical-align:middle float :left; ">
                                    <input '.$checkedradio.' onclick="validate_opt(' . $q_cnt . ')" type="radio" width="100px" '
                                        . 'value="' . $qid1 . '#' . $optId1 . '" name="' . $optdescextract . '" id="chk_'.$q_cnt.'_'.$cnt_tr1.'">
                                    <input type="hidden" name="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" id="chkH_' . $q_cnt . '_' . $cnt_tr1 . '" '
                                        . 'value="' . $optdesc1 . '">
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
            echo '<tr style="background: #29abe0;">       
<td style="font-weight:bold;padding:2px;color:#fff;padding-left:12px; height:25px;font-size: 14px;" colspan="2">Remarks and Observations</td>               
</tr>
<tr>       
<td style="padding:4px;" colspan="2">              
<textarea id="remarks" name="remarks" style="width: 98%; height: 100px; margin-bottom:8px; ">';
            if ($remarks == '') {
                echo "Any Other issues: ";
                
            } else {
                echo $remarks;
            }
            echo '</textarea></td>               
</tr>
<tr>       
<td style="padding:4px;" colspan="2" align="center">
<div id="savediv" style="display:none;">  
<input onclick = "return validate()" type="submit" name="save" id="save" value="Save & Next" 
style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:120px;height:25px; text-align:center;">
&nbsp;&nbsp;
<input onclick = "return validate_close()" type="submit" name="save_close" id="save_close" value="Save & Exit" 
style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:120px;height:25px; text-align:center;">
</div>
<input id="tot_question" name="tot_question"  type="hidden" value="' . $q_cnt . '">
<input id="selofferID" name="selofferID" type="hidden" value="' . $offerID . '">
<input id="auditors_name" name="auditors_name" type="hidden" value="' . $auditors_name . '"> 
<input id="v_name" name="v_name" type="hidden" value="' . $v_name . '"> 
<input id="selopt_val" name="selopt_val" type="hidden" value="">
<input id="stype" name="stype" type="hidden" value="' . $stype . '">
<input id="job_id" name="job_id" type="hidden" value="'.$job_id.'">
<input id="job_type_id" name="job_type_id" type="hidden" value="'.$job_type_id.'"> 
<input id="job_type" name="job_type" type="hidden" value="'.$job_type_id.'"> 
<input type="hidden" name="maxtimelimit" id="maxtimelimit" value="'.$maxtimelimit.'">  
<input type="hidden" name="mintimelimit" id="mintimelimit" value="'.$mintimelimit.'">    
<input type="hidden" name="midfortimer" id="midfortimer" value="'.$mid_for_timer.'"> 
</td>               
</tr>
</table></form></td></tr></table><div id="add_to_me"></div><script src="protected\js\timerforall.js?v=8"></script>
<link rel="stylesheet" href="protected\css\timerforall.css">';

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