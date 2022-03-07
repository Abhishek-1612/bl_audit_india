<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<html><head>
<title>Leap Downtime Report</title>
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
                        a['status']=$('#status').val();
                        a['search']=$('#search').val();
                        a['issue_at']=$('#issue_at').val();
                        result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapDowntimeTracker/Report&mid=3678",
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
</script>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="return checkvalidate();">
            <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
              <TR>
                  <td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Leap Downtime Report</b></font>             
              </td>   
              </TR>
              <tr>
              <td WIDTH="20%">&nbsp;Issue Date:</td>
              <td> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="end_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
              </td>
              <td>Issue At:</td><td>&nbsp;<input type="radio" name="issue_at" value="Indiamart" id="issue_at1" checked>&nbsp;Indiamart&nbsp;&nbsp; 
              <input type="radio" name="issue_at" value="Partner" id="issue_at2" >&nbsp;Partner
              </td>
     </tr>      
     <tr>
    <td >&nbsp;Status: </td>
    <td>&nbsp;<input type="radio" name="status" value="1" id="status1" checked>&nbsp;Approved&nbsp;&nbsp; 
              <input type="radio" name="status" value="-1" id="status2" >&nbsp;Rejected&nbsp;&nbsp; 
              <input type="radio" name="status" value="" id="status3" >&nbsp;Pending
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
               
</body>
</html>
