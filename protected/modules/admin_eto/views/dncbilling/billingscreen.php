<?php 
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
 $currentDate = date("d-m-Y");
$request = Yii::app()->request;
$start_date=$start_date1= $request->getParam('start_date','');
$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));

$end_date=$end_date1= $request->getParam('end_date','');
$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
$rtype=$request->getParam('rtype',1);
$stype=$request->getParam('stype',1);
$score_int=$score_ext=$rtype1=$rtype2=$rtype3='';
if($stype=='I'){
    $score_int='checked';
}else{
    $score_ext='checked';
}
if($rtype==1){
    $rtype1='checked';
}elseif($rtype==2){
    $rtype2='checked';
}elseif($rtype==3){
    $rtype3='checked';
}
if(isset($_REQUEST['Archive_data']) && ($_REQUEST['Archive_data']=='Archive_data')){
   $is_archive='checked';
}else{
    $is_archive='';
}
$associateid=$request->getParam('associateid','');
?>
<head>
<title>DNC Billing CRM</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:2px;border-style:solid;border-color:#0195d3;
}
</style>

<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script>
    function Update(i){
         a={};
           var bid=$('#bid'+i).val();   
           var previous_target=$('#leap_previous_target'+i).val();
           var revised_target=$('#leap_revised_target'+i).val();
           var billable_leads=$('#leap_billable_leads'+i).val();
           var remarks=$('#remarks'+i).val();
           var met_id="met" + i;
           var mg_id="mg" + i;
           var met=$('input[name="'+met_id+'"]:checked').val(); 
           var mg=$('input[name="'+mg_id+'"]:checked').val();
           if(revised_target === ""){
                alert('Please fill Revised target for '+i);
                return false;
            }
           if(previous_target === ""){
                     alert('Please fill Previous target for '+i);
                     return false;
                 }                 
            
             if(!$('input[name="'+mg_id+'"]:checked').val()){
                     alert('Please select MG/Not MG for '+i);
                     return false;
                 }
               
            a['bid']=bid,
            a['previous_target']=previous_target,
            a['revised_target']=revised_target,
            a['billable_leads']=billable_leads,
            a['remarks']=remarks,
            a['met']=met,
            a['mg']=mg,
            a['action']=$('#update'+i).val(); 
            $("#update"+i).hide();
            $.ajax({ 	 	
            type: "POST", 	
            async: false,
            url:"/index.php?r=admin_eto/DNCBilling/Billedit&mid=3549",	
            data: a, 
            success: function(result) 	 	
            { 	 
                    $("#update_message"+i).html(result);                     
            }
            , 	 	
            error: function(result) {
                    $("#update_message"+i).html(result.responseText); 
                    $("#update"+i).show();
                    return false; 
            } 	 	
            });         
       
}
</script>
</head>
<body>
<?php
 echo '<body>
 <form name="RebuttalMis" method="post" style="margin-top:0;margin-bottom:0;">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
              <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>DNC Billing Report</b></font>             
              </td>   
              </TR>';  
        echo '<tr><td WIDTH="10%">&nbsp;Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="'.$start_date.'" SIZE="13" onfocus="displayCalendar(document.RebuttalMis.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" onclick="displayCalendar(document.RebuttalMis.start_date,\'dd-mm-yyyy\',this,\'\',\'\',\'from_date1\')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="end_date" type="text" VALUE="'.$end_date.'" SIZE="13" onfocus="displayCalendar(document.RebuttalMis.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'to_date1\')" onclick="displayCalendar(document.RebuttalMis.end_date,\'dd-mm-yyyy\',this,\'\',\'\',\'to_date1\')" id="end_date" TYPE="text" readonly="readonly">
             </td>
              <td align="center" colspan="2"><input type="radio" name="rtype" value="1" '.$rtype1.'>Approval
              &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="rtype" value="2" '.$rtype2.'>Pending Leads
             &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="rtype" value="3" '.$rtype3.'>Quality Score &nbsp;&nbsp;<input type="checkbox" name="Archive_data" value="Archive_data" '.$is_archive.'>&nbsp;&nbsp;<b>Archive Data</b>   
             &nbsp;&nbsp;Associate ID:&nbsp;<input type="text" id="associateid" name="associateid" style="width: 60px; margin:0px 0px 0px 3px;" maxlength="15" value="'.$associateid.'"> 
            &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="stype" value="I" '.$score_int.'> Internal Quality Score
                 &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="stype" value="E" '.$score_ext.'> External Quality Score
</td>
</tr>
        <tr>
            <td >&nbsp;Vendor: </td>
              <td>&nbsp;<div style="float:left;margin:0 100 0 0"><select name="vendor" id="vendor" style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:320px;">';
         $vendorArr1=array();
               if(count($vendorArr)==1){                                       
                     $vendor_name=key($vendorArr);
                     if(preg_match("/COGENT/i",$vendor_name)) {
                      $vendorArr1 = array('2'=>'COGENT','16'=>'COGENTBRB','15'=>'COGENTDNC','3'=>'COGENTINBOUND','12'=>'COGENTINTENT','23'=>'COGENTPNS','4'=>'COMPETENT');
                      }elseif(preg_match("/KOCHAR/i",$vendor_name)) {
                          $vendorArr1 = array('21'=>'KOCHARTECH','28'=>'KOCHARTECHAUTO','6'=>'KOCHARTECHCHN','20'=>'KOCHARTECHDNC','7'=>'KOCHARTECHINTENT','13'=>'KOCHARTECHLDH','30'=>'KOCHARTECHREVIEW');
                      }elseif(preg_match("/RADIATE/i",$vendor_name)) {
                          $vendorArr1 = array('17'=>'RADIATE','24'=>'RADIATEAUTO','1'=>'RADIATEDNC','8'=>'RADIATEINTENT','26'=>'RADIATEPNSMRK','19'=>'RADIATEPNSTOBL');    
                      }elseif(preg_match("/VKALP/i",$vendor_name)) {
                          $vendorArr1 = array('27'=>'VKALP','10'=>'VKALPAUTOIND','5'=>'VKALPDNC','11'=>'VKALPINTENT','29'=>'VKALPREVIEW');       
                      }else{
                          $vendorArr1 = $vendorArr;
                      }
                }else{
                    
                        $vendorArr1 = $vendorArr;
                }
                
                
        foreach($vendorArr1 as  $key => $value)
        {
            if($vendor == $key)
                {
                   echo '<OPTION VALUE="'.$key.'" SELECTED="SELECTED" >'.$value.'</OPTION>';
                }
                else
                {
                    echo '<OPTION VALUE="'.$key.'" >'.$value.'</OPTION>';
                }

        } echo '</select>';

         
               echo '</div>
    </td>
        <TD colspan="2" align="center">
        <input type="submit" name="search" id="search" value="Generate Report">
        </TD>
       </TR>
       </TABLE><br><br><table cellspacing="0" cellpadding="4" width="100%" bordercolor="#bedadd" border="1" style="border-collapse: collapse;">';
echo $response.'</table></body>';
?>