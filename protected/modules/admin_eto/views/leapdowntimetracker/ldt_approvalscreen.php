<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<html><head>
<title>Leap Downtime Approval Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:204px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:1px;border-style:solid;border-color:#0195d3;
}
</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script>
$(document).ready(
    function()
            {  
                $('#search').click(function(){
                        a={};
                        a['vendor_name']=$('#vendor_name').val();                           
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['tracker_id']=$('#tracker_id').val();
                        a['search']=$('#search').val();                       
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapDowntimeTracker/ApprovalForm&mid=3678",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                success:function(result){                         
                               $('#result').html(result);                   
                            }
                        }); 
            }
);  
}
)

function showApprovalForm(tracker_id,div_id)
{
    var total_record=document.getElementById('total_record').value;
    document.getElementById('Approveform_div'+div_id).style.opacity=1;
    document.getElementById('Approveform_div'+div_id).style.display="block";
    for(i=1;i<=total_record;i++)
    {
      if(i !== div_id){
      document.getElementById('Approveform_div'+i).style.display="none";
      }
    }
    document.getElementById('Approveform_div'+div_id).innerHTML = '<form name="searchForm" method="post" action=""><div style="border-size:2px;border-style:solid;border-color:#0195d3;height:200px;"><table style="border-collapse: collapse;" border="1" cellpadding="4" cellspacing="0" width="100%" height="100%"><tr><td  align="center" style="color:#ffffff;" colspan="2" width="100%"  bgcolor="#0195d3"><b>Tracker Id:</b>'+tracker_id+'</td></tr><tr><td>Action:</td><td align=left><input id="verify_status" type="radio" value="1" name="verify_status" Checked>Accept &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" value="-1" name="verify_status" id="verify_status">Reject</td></tr><tr><td width="10%"><span style="float:left;margin:3px 0px 0px 0px;">Indiamart Remarks:</span></td><td width="80%"><textarea id="remarks'+div_id+'" name="remarks" style="width: 98%; height: 60px; margin-bottom:8px;resize: none; "></textarea></td></tr><tr><td align="center" colspan="2" style="padding:4px;"><input type="hidden" name="tracker_id1" value=""><input type="button" name="Update" value="Update" onclick="return validate_remark('+tracker_id+','+div_id+');">&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="close" value="Close" onclick="return show_alert_off('+div_id+',2);"></td></tr></table></div></form>';
    document.getElementById("remarks"+div_id).focus();   
}
function show_alert_off(div_id,check)
{
if(check === 1)
{
 document.getElementById('Approve_div'+div_id).innerHTML="Already Updated";
}
 document.getElementById('Approveform_div'+div_id).style.display="none";
 document.getElementById('complete_mis').style.opacity=1;
 
 
}

function validate_remark(tracker_id,div_id)
{

 var remarks=document.getElementById("remarks"+div_id).value.trim();
 if(remarks ==='')
        {
                alert("Please Fill Indiamart Remarks ");
                return false;
        }
  else{
        a={};
        a['remarks']=remarks;
        a['tracker_id']=tracker_id;
        a['update']='update';
        a['status']=$('input[name=verify_status]:radio:checked').val();
        a['div_id']=div_id;
        $.ajax({
        type : 'POST',
        url : "/index.php?r=admin_eto/LeapDowntimeTracker/ApprovalForm/",
        data : a,
        success:function(result){
                if(document.getElementById('Approveform_div'+div_id)){
                    document.getElementById('Approveform_div'+div_id).innerHTML = result;
                }
                if(document.getElementById('Approve_div'+div_id)){
                    document.getElementById('Approve_div'+div_id).innerHTML = "Updated";
                }
        }
        });
    }  
}
</script>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
<div id="complete_mis">

<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
                  <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Leap Downtime Entry Report</b></font>             
              </td>   
              </TR>
              <tr>
              <td WIDTH="20%">&nbsp;Issue Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="end_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
              </td>
     </tr>      
     <tr>
    <td >&nbsp;Search by Tracker Id: </td>
    <td>&nbsp;<input style="border-radius: 3px 3px 3px 3px;font-size: 100%;width:130px;" type="text" name="tracker_id" id="tracker_id" value="">
    </td>
    <td WIDTH="20%">&nbsp;Vendor Name:</td>
<td> &nbsp;<select id="vendor_name"><option value="">Select</option>
 <?php foreach($allVenders as $value){
     echo '<option value="'.$value.'">'.$value.'</option>';
 }
 ?>
    </select>
</td>
     </tr>
    <tr><TD colspan="4" align="center">
    <input type="button" name="search" id="search" value="Search">
    <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
    </TD>
    </TR>
    </TABLE> 
    <div id="result" name="result"></div>
</form>
</div>                 
</body>
</html>
