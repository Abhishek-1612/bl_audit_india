<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<head>
<title>Leap Downtime Time Entry Form</title>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
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
<body>

<form name="searchForm" method="post" action="/index.php?r=admin_eto/LeapDowntimeTracker/EntryForm&mid=3777">
    <input name="frame_height" id="frame_height" value="" type="hidden">
<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center">            
<tr style="background: #0195d3;">       
<td style="font-weight:bold;padding:4px;color:#fff;" colspan="4" algn="center">Leap Downtime Entry Form</td>               
</tr>

 <?php if($message<>''){
    echo '<tr><td colspan="4"><div style="color:green;text-align:center;font-weight:bold;">'.$message.'</div></td></tr>';
}?>  
 <tr>
<td WIDTH="20%">&nbsp;Issue Date:<span style="color:red;"> *</span></td>
<td> &nbsp;<input name="issue_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.issue_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.issue_date,'dd-mm-yyyy',this,'','','issue_date')" id="issue_date" TYPE="text" readonly="readonly">
</td>
<td WIDTH="20%">&nbsp;Vendor Name:<span style="color:red;"> *</span></td>
<td> &nbsp;<select id="vendor_name" name="vendor_name"><option value="">Select</option><option value="ALL">ALL</option>';
 <?php foreach($allVenders as $value){
     echo '<option value="'.$value.'">'.$value.'</option>';
 }
 ?>
    </select>
</td>
 </tr>
<tr>       
    <td>Downtime slot:<span style="color:red;"> *</span></td><td><select id="dst1" name="dst1" style="width:50px;height:25px"><?php 
for($in=1;$in<24;$in++){
       echo '<option value="'.$in.'">'.$in.'</option>';   
}
echo '</select>&nbsp;&nbsp;<select id="dst2" name="dst2" style="width:50px;height:25px">';
for($in=1;$in<24;$in++){
       echo '<option value="'.$in.'">'.$in.'</option>';   
}?></select></td><td></td><td></td>               
</tr>
<tr>       
    <td>Issue Start time:<span style="color:red;"> *</span></td><td>&nbsp;<input name="issue_start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.issue_start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.issue_start_date,'dd-mm-yyyy',this,'','','issue_start_date')" id="issue_start_date" TYPE="text" readonly="readonly">
    <select id="issue_st1" name="issue_st1" style="width:50px;height:25px"><?php 
$in1='';
for($in=0;$in<24;$in++){
        if($in<10){
            $in1='0'.$in;
        }else{
            $in1=$in;
        }
       echo '<option value="'.$in1.'">'.$in1.'</option>';   
      }
echo '</select>&nbsp;&nbsp;<select id="issue_st2" name="issue_st2" style="width:50px;height:25px">';
$in1='';
for($in=0;$in<60;$in++){
        if($in<10){
            $in1='0'.$in;
        }else{
            $in1=$in;
        }
       echo '<option value="'.$in1.'">'.$in1.'</option>';   
       }?></select></td>
    <td>Issue End time:<span style="color:red;"> *</span></td><td><input name="issue_end_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.issue_end_date,'dd-mm-yyyy',this,'','','issue_end_date')" onclick="displayCalendar(document.searchForm.issue_end_date,'dd-mm-yyyy',this,'','','issue_end_date')" id="issue_end_date" TYPE="text" readonly="readonly">
<select id="issue_et1" name="issue_et1" style="width:50px;height:25px"><?php 
$in1='';
for($in=0;$in<24;$in++){
        if($in<10){
            $in1='0'.$in;
        }else{
            $in1=$in;
        }
       echo '<option value="'.$in1.'">'.$in1.'</option>';   
      }
echo '</select>&nbsp;&nbsp;<select id="issue_et2" name="issue_et2" style="width:50px;height:25px">';
for($in=0;$in<60;$in++){
    if($in<10){
        $in1='0'.$in;
    }else{
        $in1=$in;
    }
       echo '<option value="'.$in1.'">'.$in1.'</option>';   
}?></select>
    </td>                
</tr>
<tr>       
    <td>Issue at:<span style="color:red;"> *</span></td><td>&nbsp;<input type="radio" name="issue_at" value="Indiamart" id="issue_at1" checked>&nbsp;Indiamart&nbsp;&nbsp; 
        <input type="radio" name="issue_at" value="Partner" id="issue_at2" >&nbsp;Partner
</td><td>Issue name</td><td>
    &nbsp;<input type="radio" name="issue_name" value="No Enquiry" id="issue_name1" checked>&nbsp;No Enquiry&nbsp;&nbsp; 
        <input type="radio" name="issue_name" value="CRM Down" id="issue_name2" >&nbsp;CRM Down&nbsp;&nbsp; 
        <input type="radio" name="issue_name" value="Dialer" id="issue_name3" >&nbsp;Dialer&nbsp;&nbsp; 
        <input type="radio" name="issue_name" value="Internet" id="issue_name4" >&nbsp;Internet&nbsp;&nbsp; 
        <input type="radio" name="issue_name" value="Training" id="issue_name5" >&nbsp;Training&nbsp;&nbsp; 
    </td>                
</tr>
<tr>       
    <td>Agent Impacted:<span style="color:red;"> *</span></td><td><input id='agent_impacted' name='agent_impacted' type="text" value='' /></td>
    <td>Lead Impacted:<span style="color:red;"> *</span></td><td><input id='lead_impacted' name='lead_impacted' type="text" value='' /></td>                
</tr>
<tr >       
    <td >Remark:<span style="color:red;"> *</span></td><td colspan="3"><textarea id="remarks" name="remarks" style="width: 98%; height: 100px; margin-bottom:8px; "></textarea></td>               
</tr>

 <tr>       
<td style="padding:4px;" colspan="4" align="center">   
<input type="submit" name="save" onclick = "return validate()" style="font-weight:bold;margin: 0px 0px 0px 3px;float:center;width:80px;height:25px; text-align:center;" value="Save"/>
</td>               
</tr>
</table></form>
                   
</body>
</head>
