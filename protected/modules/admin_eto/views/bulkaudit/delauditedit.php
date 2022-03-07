<?php 
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
$team_leader=isset($_REQUEST['team_leader_select']) ? $_REQUEST['team_leader_select'] : 'ALL';
$team_qa=isset($_REQUEST['qa_select']) ? $_REQUEST['qa_select'] : 'ALL';
$team_agent=isset($_REQUEST['agent_select']) ? $_REQUEST['agent_select'] : 'ALL';
$vendor_approve=isset($vendor_approve) ? $vendor_approve : 'ALL';
$offerid=isset($_REQUEST['offerid']) ? $_REQUEST['offerid'] : '';
?>
<head>
<title>Buy Lead Audit CRM</title>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script type="text/javascript">
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
function showuserstats(offerid,glusrid){  
    $("#showuserstat_"+offerid).hide();
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
function validate_opt(grpname){
       var group =document.getElementsByName(grpname);
        if (group[0].checked === true) {
            radioname=grpname.replace("chk", "delopt");
            $('input:radio[name=\''+radioname+'\'][value="2"]').attr('checked',true);           
        }
}
function validate_radio(radioname){
        grpname=radioname.replace("delopt", "chk");
        var opt_val= $('input:radio[name=\''+radioname+'\']:checked').val();
        if(opt_val===2){
            
        }else{  
            $('input[name=\''+grpname+'\']').each(function() {
                    this.checked = false;
            });
        }
}

function check_validate(){
                         var a ={};
                        var x={};
                        var ids = document.getElementById("all_ofr_id").value.split(",");
              
               for(var j=0;j<ids.length;j++)
                {
                        ofrid= ids[j];
                        primeId="delopt_"+ofrid;
                        var opt_val= $('input:radio[name=\''+primeId+'\']:checked').val();
                        if(opt_val==2){                        
                            var grpname="chk_" + ofrid;
                            var sel_grp=false;
                             var group =document.getElementsByName(grpname);   
                             for (var opt=0; opt< group.length; opt++) {
                                     if(group[opt].checked === true){                                         
                                         sel_grp=true;                                         
                                     }                      
                             }
                             if(sel_grp === false){
                                 alert("Please Select Atleast one error option for Offer Id " + ofrid);                                 
                                 return false;
                             } 
                        }  
                }
                for(var j=0;j<ids.length;j++)
                {
                        var optionvalues = new Array();
                        var questionvalues = new Array();
                       ofrid= ids[j];
                       primeId="delopt_"+ofrid;
                       primeId2="chk_"+ofrid;
                        var opt_val= $('input:radio[name=\''+primeId+'\']:checked').val();
                        optionvalues.push(opt_val);
                        questionvalues.push('32');
                        var rem_val=$('#remarks_'+ofrid).val();
                        var opt_id=ofrid;
                        if(opt_val==227){                            
                            x[opt_id]={
                                    ofr_id:ofrid,
                                    opt_val:optionvalues,
                                    ques_val:questionvalues,
                                    rem_val:rem_val
                                };                   
                             }
                        else{
                            var optionvalues = new Array();
                            var questionvalues = new Array();
                            var opt_val= document.getElementsByName(primeId2);
                            for(var i=0;i<opt_val.length;i++)
                            {
                                if(opt_val[i].checked === true ){
                                    optionvalues.push(opt_val[i].value); 
                                    questionvalues.push('32'); 
                                }
                            }

                         
                           
                            x[opt_id]={
                                    ofr_id:ofrid,
                                    opt_val:optionvalues,
                                    ques_val:questionvalues,
                                    rem_val:rem_val
                                };  
                        }
                       
                }                
                var newArr=JSON.stringify(x);
               
                
                a['opt_ids']=newArr;
                a['auditid']= document.getElementById('auditid').value;
                a['offer_id']=document.getElementById('offer_id').value;

                $("#save_all").hide();   
                $.ajax({ 	 	
                    type: "POST", 	
                    async: false,
                    url: "/index.php?r=admin_eto/BulkAuditEto/Audit_Edit&mid=3549", 	 	
                    data: a, 
                    success: function(result){ 	 
                            $('#auditresult').html(result);                          
                    }, 	 	
                    error: function() { 
                            alert('Error occured');
                            result = false;
                    } 	 	
                });  
  
}

    $(function() {
    $('input:radio[name="stype"]').change(function() {
        if ($(this).val() == 'ADV') {
              Newfilter('<?php echo $vendor_approve ?>','<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');
                $("#trmain").show();
            }else{
                 $("#trmain").hide();                 
            }
    });
    
});
$(document).ready(
    function()
            {
           if ($("input[name='stype']:checked"). val()== 'ADV') {
               $("#trmain").show();               
            }else{
                $("#trmain").hide();                
            } 
                $('#submit_view').click(function(){                 
                        a={};
                        a['stype']= $("input[name='stype']:checked"). val();
                        a['vendor_approval']=$('#vendor_approval').val();
                        a['maxrecords']=$('#maxrecords').val();
                        a['start_date']=$('#start_date').val(); 
                        a['end_date']=$('#end_date').val(); 
                        a['submit_view']=$('#submit_view').val();
                        a['tlselect']=$('#tlselect').val();
                        a['team_leader_select']=$('#team_leader_select').val();
                        a['qa_select']=$('#qa_select').val();
                        a['agent_select']=$('#agent_select').val();
                        a['agentselect']=$('#agentselect').val();  
                        a['offer_id']=$('#offer_id').val(); 
                             if($('input[name="delsource"]:checked').val() =='direct')
                             {
                              a['delsource']='direct';
                             }
                             else
                             {
                              a['delsource']='fenq';
                             }
                            a['bucket']=$('#bucket').val();  
                            a['deletedreasonselect']=$('#deletedreasonselect').val();
                            a['deletedcall_noncall']=$('#deletedcall_noncall').val();
                            a['leadtype']= $('input[name="leadtype"]:checked').val();
                            a['buyer_type']= $('input[name="buyer_type"]:checked').val();
                            a['pool']= $('input[name="pool"]:checked').val();
                            a['poolVal']=$('#poolVal').val(); 
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/BulkAuditEto/Sampling&mid=3794",
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
$checkradio1 = "checked";
$checkradio2 = "";
$check1 = $check2 =  $check3 =$check4= '';


$tot_records = count($dataArr);
if ($tot_records > 0) {
    if(isset($auditdet) ){
    foreach($auditdet as $d){
       
        if($d['OPT'] == 'Wrong Deletion'){
            $check2 = " checked";
            $checkradio1 = "";
            $checkradio2 = "checked";
        }
        if($d['OPT'] == 'Wrong Deletion Dispostion Selection'){
            $check1 = " checked";
            $checkradio1 = "";
            $checkradio2 = "checked";
        }
        if($d['OPT'] == 'Phone Etiquette Error'){
            $check3 = " checked";
            $checkradio1 = "";
            $checkradio2 = "checked";
        }
        if($d['OPT'] == 'Others'){
            $check4 = " checked";
            $checkradio1 = "";
            $checkradio2 = "checked";
        }
    }
}

    echo '<br><table style="border-collapse: collapse;" border="0" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">';
    $all_ofr_id = '';
    for ($i = 0; $i < count($dataArr); $i++) {
       
      
        $title   = isset($dataArr[$i]['ETO_OFR_TITLE']) ? $dataArr[$i]['ETO_OFR_TITLE'] : '';
        $offerID = isset($dataArr[$i]['ETO_OFR_DISPLAY_ID']) ? $dataArr[$i]['ETO_OFR_DISPLAY_ID'] : '';
        $all_ofr_id .= $offerID . ",";
        $ETO_OFR_APPROV_DATE = isset($dataArr[$i]['ETO_OFR_APPROV_DATE']) ? $dataArr[$i]['ETO_OFR_APPROV_DATE'] : '';
        if (isset($dataArr[$i]['CALL_RECORDING_URL'])) {
            $prim1              = $dataArr[$i]['CALL_RECORDING_URL'];
            $CALL_RECORDING_URL = '<a href="' . $prim1 . '" TARGET="_blank"><b style="color:#0000ff">&#187;&nbsp;Play Recording </b></A>';
        } else {
            $CALL_RECORDING_URL = '<b style="color:#0000ff">&#187;&nbsp;Recording Not Available </b>';
        }
        $glid = $dataArr[$i]["FK_GLUSR_USR_ID"];
        echo '<tr>
        
                             <td style="background: #0195d3; color: white;padding:4px;"><b>ID:</b>&nbsp; <a href="/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer=' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '&go=Go&mid=3424" style="text-decoration:none;color: white;" target="_blank">' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '</a></td>
                             <td style="background: #0195d3; color: white;padding:4px;"><b>Lead title:</b>&nbsp;' . $title . '</td>
                             <td style="background: #0195d3; color: white;padding:4px;"><b>History:</b>&nbsp; <a href="/index.php?r=admin_eto/OfrHist/etohistory&action=etohistory&act=ofrHist&offer=' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '&mid=3424" style="text-decoration:none;color: white;" target="_blank">' . $dataArr[$i]['ETO_OFR_DISPLAY_ID'] . '</a></td>
                             </tr>
                             <tr><td style="padding:4px;"><b>Associate:</b>&nbsp; ' . $dataArr[$i]['ETO_LEAP_EMP_NAME'] . '(' . $dataArr[$i]['ETO_LEAP_EMP_ID'] . ')</td>
                             <td style="padding:4px;"><b>Call Recording:</b>&nbsp; ' . $CALL_RECORDING_URL . '</td><td style="padding:4px;"><a href="index.php?r=admin_eto/OfferDetail/multiplecallrecord&offer=' . $offerID . '&mid=3424" target="_blank">&#187;&nbsp;View All Recordings</A></td>
                             </tr><tr>
                             <td style="padding:4px;"><b>Deletion On:</b>&nbsp; ' . $ETO_OFR_APPROV_DATE . '</td>
                             <td style="padding:4px;"><input onclick = "validate_radio(this.name)" type="radio" name="delopt_' . $offerID . '" value="227"  '.$checkradio1.'  id="delopt_' . $offerID . '">
                                 <font color="green">&nbsp;No Error Found</font>
                             </td>  
                              <td width="40%" rowspan=2>
                              <table border=0 cellpadding="0" cellspacing="0"  width="100%"><tr>
                              <td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check1.' width="100px" value="228" name="chk_' . $offerID . '" id="chk_228_' . $offerID . '">
                            <font color="red">Wrong Deletion Dispostion Selection</font></td>
                            <td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check3.' width="100px" value="230" name="chk_' . $offerID . '" id="chk_230_' . $offerID . '">
                                <font color="red">Phone Etiquette Error</font>
                                </td></tr>
                                <tr><td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check2.' width="100px" value="229" name="chk_' . $offerID . '" id="chk_229_' . $offerID . '">
                                <font color="red">Wrong Deletion</font></td>
                                <td><input onclick = "validate_opt(this.name)"  type="checkbox" '.$check4.' width="100px" value="231"' . $offerID . '" name="chk_' . $offerID . '" id="chk_231_' . $offerID . '">
                                <font color="red">Others</font></td></tr>
                                </table></td></tr>
                             <tr>
                             <td style="padding:4px;"><b>Deletion Reason: </b>&nbsp;' . $dataArr[$i]['deletedreason'] . '</td>
                             <td><input type="radio" '.$checkradio2.' onclick = "validate_radio(this.name)" name="delopt_' . $offerID . '" id="delopt_' . $offerID . '" value="2" ><font color="red">&nbsp;Error Found</font></td>
                             </tr><tr>
                             <td style="padding:4px;"><b>User Stats: </b>&nbsp;<input type="button" name="showuserstat_' . $offerID . '" id="showuserstat_' . $offerID . '" value="Show" onclick="showuserstats(' . $offerID . ',' . $glid . ')"><div style="font-size:12px;padding:8px 15px 8px 8px; line-height:23px;letter-spacing:-0.02em;font-weight:bold" id="userstat_' . $offerID . '"></div>
                             </td>
                             <td style="padding:4px;" colspan=2><textarea id="remarks_' . $offerID . '" name="remarks" style="width: 98%; height: 40px; margin-bottom:8px; ">Comment(if any):</textarea></td>
                             </tr>';
    }

    

    $all_ofr_id = trim($all_ofr_id, ",");
    $auditid = isset($_REQUEST['auditid'])?$_REQUEST['auditid']:'';
    $offer_id = isset($_REQUEST['offer_id'])?$_REQUEST['offer_id']:'';
    echo '<TR >
                    <TD valign="top"  align="center" colspan=3><input id = "save_all" type="button" name="save_all" value="Save" class="btn btn-success" ONCLICK="return check_validate();">
                    <input id = "all_ofr_id" type="hidden" name="all_ofr_id" value="' . $all_ofr_id . '">
                    <input  id ="auditid" type="hidden" name="auditid" value="'.$auditid .'">
                    <input  id ="offer_id" type="hidden" name="offer_id" value="'.$offer_id.'">
                   
                   
                     </table>
                    <div id="auditresult" name="auditresult" style="color:blue;text-align:center;"></div>';

    
} else {
    echo '<br><div  style="padding:4px;font-weight:bold;text-align:center;">No Records Found</div>';
}
?>

</body><div style="clear:both;"><!-- --></div></div>
