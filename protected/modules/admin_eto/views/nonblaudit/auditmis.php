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

</script>
</head>
<body>
<?php

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
     <form name="searchForm" id="searchForm" method="post" action="/index.php?r=admin_eto/NonBLAudit/Mis&tabselect=2" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Audit MIS</b></font></font>)             
              </td>   
              </TR>
              <tr>
              <td WIDTH="20%">&nbsp;Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </td>
              
               <td WIDTH="20%">&nbsp;Score:</td>
              <td> &nbsp;<input type="radio" name="score" checked />Both&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="score" value="pass" <?php echo (isset($_REQUEST['score']) && $_REQUEST['score'] == 'pass')?'CHECKED="CHECKED"':'' ?>/>Pass&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="score" value="fail" <?php echo (isset($_REQUEST['score']) && $_REQUEST['score'] == 'fail')?'CHECKED="CHECKED"':'' ?>/>Fail&nbsp;</td>
              </tr>
              
                          <tr>
    <td >&nbsp;Called By: </td>
    <td>&nbsp;<select name="vendor_approve" id="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;" onchange="Newfilter(this.value,'<?php echo $team_leader ?>','<?php echo $team_qa ?>','<?php echo $team_agent ?>');">
    <?php       $vendorArr1=array();
                if(count($vendorArr)==1){
                     $vendor_name=$vendorArr[0];
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('COGENTBRB','COGENTDNC','COGENTPNS' );
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('KOCHARTECHCHN','KOCHARTECHAUTO','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
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
                          $vendorArr1 = array('RADIATEPNSTOBL','RADIATEINTENT','RADIATEPNSMRK','RADIATEAUTO');  
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
   
                 <td>&nbsp;Search by Audit Id:</td><td>
                    &nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="audit_id" id="audit_id" value="<?php echo $auditId;  ?>"></td>
    <td >&nbsp;Search by Call record Id: </td>
    <td >&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="offer_id" id="offer_id" value="<?php echo $offerid ; ?>">
    </td>
    </tr>
    <tr><td >&nbsp;Deletion Reason: </td>
    <td>   
         <span id="deletedreason" name="deletedreason">
         <select name="deletedreasonselect" id="deletedreasonselect">
         <OPTION VALUE="">ALL</OPTION>
         <?php 
         $deletedreasonArr=array(211=>"BL Approved",212=>"BL Enriched",
214=>"Particular Company Details",
215=>"Selling Related",
216=>"Short Call",
218=>"Voice Not Clear",
219=>"Supplier Call",
231=>"No Mcat",
232=>"Foreign Lead not approved",
233=>"No Response",
234=>"IVR Call",
235=>"Test Call",
249=>"Call Dropped in Between - Unable to Identify the Concern",
250=>"Call Drop in Between - BL Lead Opportunity",
251=>"No Product Requirement",
252=>"Banned Product",
253=>"Time Pass/ Abusive Caller",
254=>"Language Barrier",
255=>"Telemarketing/Promotional Call",
339=>"Disable Customer",
340=>"Job Related_BL not approved",
346=>"Duplicate Requirement");

         foreach($deletedreasonArr as $key=>$value)
         {
          echo '<OPTION VALUE="'.$key.'">'.$value.'</OPTION>';
         }
          ?>
         </select>
         </td>
        <TD colspan="2" align="left">                      
    <input type="submit" name="submit_dump" id="submit_dump" value="Generate Report">
    <input type="hidden" name="stype" value="NONBL">
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
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][5].' / Call Recording Url</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][8].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][9].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][10].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][11].'</td>'
                                       . '<td style="color:#ffffff;padding:4px;">'.$dataArr[$i][12].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][13].'</td>'
                                       . '<td style="color:#ffffff;padding:4px;">'.$dataArr[$i][14].'</td>
                                      <td style="color:#ffffff;padding:4px;">'.$dataArr[$i][15].'</td>
                                          <td style="color:#ffffff;padding:4px;">Raise Rebuttal</td>
                                      </tr>';
                           }else{ //echo '<pre>';print_r($dataArr);
                                if((($dataArr[$i][15]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][15]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][15])) && (($dataArr[$i][14]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][14]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][14])) && (($dataArr[$i][13]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][13]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][13])) && (($dataArr[$i][9]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][9]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][9])) && (($dataArr[$i][10]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][10]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][10])) && (($dataArr[$i][11]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][11]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][11])) && (($dataArr[$i][12]=='Pass') || (preg_match("/^Feedback/",$dataArr[$i][12]) > 0) || preg_match("/^Not Applicable/", $dataArr[$i][12]))){
                                 $totalpass = $totalpass + 1;
                               }
                                 $html .= '<tr><td style="padding:4px;">'.$i.'</td><td style="padding:4px;">'.$dataArr[$i][0].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][1].'</td>
                                    <td style="padding:4px;width:100px;">'.$dataArr[$i][2].'</td>
                                      <td style="padding:4px;"><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/NonBLAudit/Auditedit/stype/NONBL/audit_id/'.$dataArr[$i][3].'/call_id/'.$dataArr[$i][4].'/\',\'_blank\',\'scrollbars=yes,width=900, height=800\');" style="text-decoration:none;color:#0000ff">
                                      '.$dataArr[$i][3].'</a></td>
                                      <td style="padding:4px;">'.$dataArr[$i][4].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][5].'<br> <a href="'.$dataArr[$i][17].'" '
                                         . 'target="_blank">Play Recording</a></td>
                                      <td style="padding:4px;">'.$dataArr[$i][6].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][7].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][8].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][9].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][10].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][11].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][12].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][13].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][14].'</td>
                                      <td style="padding:4px;">'.$dataArr[$i][15].'</td>';

                                      if($dataArr[$i][16]=='No')
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
                                   . '<td align="center" style="padding:4px;font-weight:bold;">Quality-Pass</td>
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

  echo '<div style="clear:both;"><!-- --></div></div>';

 
 
?>