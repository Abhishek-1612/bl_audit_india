<head>
<title>Leap Billing CRM</title>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script>
    function validate(){  
        if(document.getElementById("issue_date").value.trim()==='')
        {
                alert("Please Fill Lead Issue date ");
                return false;
        }
        if(document.getElementById("vendor_name").value.trim()==='')
        {
                alert("Please Select vendor name ");
                return false;
        }
       
        if(document.getElementById("agent_impacted").value.trim()==='')
        {
                alert("Please Fill Number of Agent Impacted ");
                return false;
        }
         if(isNaN(document.getElementById("agent_impacted").value))
        {
                alert("Please Fill Number of Agent Impacted ");
                return false;
        }
        if(document.getElementById("lead_impacted").value.trim()==='')
        {
                alert("Please Fill Number of Lead Impacted ");
                return false;
        }
         if(isNaN(document.getElementById("lead_impacted").value))
        {
                alert("Please Fill Number of Lead Impacted ");
                return false;
        }
        if(document.getElementById("remarks").value.trim()==='')
        {
                alert("Please Fill Remarks ");
                return false;
        }
   return true;
}
</script>
</head>
<?php if($bid !=''){//print_r($dataArr);//die;    
$metchecked_1=$metchecked_0=$mgchecked_1=$mgchecked_0='';
               if(isset($message) && $message!=''){
                   echo '<div style="color:green;text-align:center;">'.$message.'</div>';
               }
               if(isset($dataArr['leap_is_gauranteed']) && ($dataArr['leap_is_gauranteed']==1)){
                   $mgchecked_1='checked';
               }else{
                   $mgchecked_0='checked';
               }
               if(isset($dataArr['leap_target_met']) && ($dataArr['leap_target_met']==1)){
                   $metchecked_1='checked';
               }else{
                   $metchecked_0='checked';
               }   
               $remarks=isset($dataArr['leap_mgr_remarks'])?$dataArr['leap_mgr_remarks']:'';
               
                echo '<form name="questionform" method="post">
                    <table border="1" cellpadding="0" cellspacing="1" width="100%" align="center">
                   <tr style="background: #0195d3;">		
		<td style="padding:4px;font-weight:bold;color:#fff;" colspan="2">Billing Detail (ID-'.$dataArr['im_leap_billing_id'].')</td>                
                </tr> 
                <tr>		
		<td style="padding:4px;">Billing Date :</td>
                <td width="80%" style="padding:4px;">'.$dataArr['leap_billing_date'].'</td>
                  </tr>
                <tr>   
                <td style="padding:4px;">Vendor Name :</td>
                <td width="80%" style="padding:4px;">'.@$dataArr['fk_eto_leap_vendor_id'].'</td> 
                </tr>
                <tr>		
		<td style="padding:4px;">Approval Count :</td>
                <td  width="80%" style="padding:4px;" >'.@$dataArr['leap_approval_count'].'</td>
                </tr> 
                <tr>		
		<td style="padding:4px;">Previous Target(+-10%) :</td>
                <td  width="80%" style="padding:4px;"><input id="previous_target" name="previous_target" type="text" value="'.@$dataArr['leap_previous_target'].'"></td>
                 </tr>
                <tr>    
                <td style="padding:4px;">Revised Target +-10%(If target revised) :</td>
                <td  width="80%" style="padding:4px;"><input id="revised_target" name="revised_target" type="text" value="'.@$dataArr['leap_revised_target'].'"></td>    
                </tr> 

                <tr>		
		<td style="padding:4px;">Billable leads :</td>
                <td  width="80%" style="padding:4px;" ><input id="billable_leads" name="billable_leads" type="text" value="'.@$dataArr['leap_billable_leads'].'"></td>  
                </tr> 
<tr>		
		<td style="padding:4px;">Met/Not Met :</td>
                <td  width="80%" style="padding:4px;" ><input type="radio" name="met" value="0" '.$metchecked_0.'> Not Met &nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="radio" name="met" value="1" '.$metchecked_1.'> Met</td>
                </tr>
       <tr>		
		<td style="padding:4px;">MG or NO MG :</td>
                <td  width="80%" style="padding:4px;" ><input type="radio" name="mg" value="0" '.$mgchecked_0.'> No MG &nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="radio" name="mg" value="1" '.$mgchecked_1.'> MG</td>
                </tr>        
                
<tr>		
		<td style="padding:4px;">Remarks from Centre Manager :</td>
                <td  width="80%" style="padding:4px;" ><textarea id="remarks" name="remarks" style="width: 100%; height: 100px; " >'.$remarks.'</textarea></td>
                </tr>       
 <tr>		
<td style="padding:4px;" colspan="2" align="center">    
<input type="submit" name="save" onclick = "return validate()" style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:80px;height:25px; text-align:center;" value="Save"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input id="audit_id" name="bid"  type="hidden" value="'.$bid.'">
</td>                
</tr> 
</table></form>';
}else{
    echo '<div style="color:red;text-align:center;"></div>';
}

                  