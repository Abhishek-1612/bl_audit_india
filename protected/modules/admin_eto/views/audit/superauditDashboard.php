<?php  
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));

?>
<html><head>
<title>Super Audit Dashboard</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; }
.cancel
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:204px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1;
 
border-size:1px;border-style:solid;border-color:#0195d3;
}
 .table .thead-dark th {
            color: #fff;
            background-color: #343a40;
            border-color: #454d55;
        }
  .error {
  color: red;}
    .correct {
  color: green;}
    .b {
  font-weight:bold; }
  .recall .hovertext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  padding: 5px 0;
  border-radius: 6px;
  position: absolute;
  z-index: 1;
}
.recall:hover .hovertext {
  visibility: visible;
}
a {
    background: #1dc52b;
    cursor: pointer;
    border-radius: 40px;
    padding: 8px 20px;
    font-family: inherit;
    font-size: 12px;
    line-height: inherit;
    color: white;
    text-decoration: none;
   
}
td{
    font-size:17px;
}

</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/protected/js/jquery.dataTables.min.js"></script>


<script>
$(document).ready(
   
   function()
            {  $('#fetch_sample').click(function(){
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['emp_id']=$('#emp_id').val();
                        a['fetch_sample']=$('#fetch_sample').val();
                        var sysdate=new Date();
                        a['date']=sysdate.getDate();
                        a['month']=sysdate.getMonth();
                        var s_date= new Date(a['start_date']);
                        var e_date=new Date(a['end_date']);
                       var Difference_In_Time = e_date.getTime() - s_date.getTime();
                       var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
                       var diff_t= sysdate.getDate() - s_date.getDate();
                       var diff_d = diff_t / (1000 * 3600 * 24);
                        if(Difference_In_Days > 2){
                          alert("Date Range cannot be more than 3 days!");
                            return false;
                        }
                        if(diff_t >3 ){
                          alert("From Date cannot be older than 3 days!");
                            return false;
                        }
                        if(e_date.getMonth() == sysdate.getMonth() && e_date.getDate() == sysdate.getDate()){
                          alert("Can't select today's date!");
                            return false;
                        }

                        if(s_date > e_date){
                          alert("To Date should be greater than From date!");
                            return false;
                        }
                         result='';              
                        $.ajax({
                            url:"index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=fetch_sample",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#result').html(result);
                            }
                        }); 
            }); 
        }
      
)

</script>
<script>
function emp_autosuggest1(id, divid) {
  $("#divState_empreport").show();
  call_auto();
}
function set_empid_new(empId, empName) {
  $("#divState_empreport").hide();
  $("#emp_name").val(`${empName}`);
  $("#emp_id").val(empId);
   window.autoCheck1=true;
}
function call_auto(id) {
  var a = $("#emp_name").val();
  if (a.length >= 3) {
    $("#loadinggif").show();
    $.ajax({
      url:
        "/index.php?r=getAutoSuggestEmp/Index&TextBoxID=emp_name&MenuDivID=divState&DataType=emp&NumMenuItems=15&IncludeMoreMenuItem=false&MoreMenuItemLabel=...&MenuItemCSSClass=asbMenuItem&Keyword=" +
        a,
      type: "post",
      data: "",
      success: function (result) {
        $("#divState_empreport").html(result);
        $("#divState_empreport").css("visibility", "visible");
        $("#loadinggif").hide();
      },
    });
  }
}

</script>
<style>
    th.dt-center, td.dt-center { text-align: center; }
</style>
</head>
<body style="background-color:#fafbff;--font-family-sans-serif: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    --font-family-monospace: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;"><input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="#" style="margin-top:0;margin-bottom:0;" >
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<TR>
 <td colspan="3" style="background-color: #211E97;
    width: 100%;
    height: 25px;
    text-align: center;
    color: white;
    font-size: 19px;
    font-weight:bold;
    padding-top: 0.6%;" align="center"> BL Super Audit Dashboard</td>
</tr>
 
<tr> 
<td WIDTH="40%" style="font-weight: bold">&nbsp;From Date:&nbsp;&nbsp;<input name="start_date" type="text" VALUE="<?php ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
&nbsp;To Date:&nbsp;&nbsp;<input name="end_date" type="text" VALUE="<?php  ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1'); " id="end_date" TYPE="text" readonly="readonly">
(<font COLOR ="red"> *New Super Audit Sample will be generated only after Super Audit of all job types of current date range</font>)
</td> 
<TR>
</TD></tr></table></td>
</tr>                    
<tr><td colspan="2"  style="text-align:center;"> &nbsp; <div align="center"> <input type="button" name="fetch_sample" style="background: #1dc52b;
    cursor: pointer;
    width:200px;
    border-radius: 40px;
    font-family: sans-serif;
    font-size: 14px;
    line-height: inherit;
    color: white;" id="fetch_sample" value="Fetch Super Audit Sample" /> </div>
&nbsp;&nbsp;&nbsp; 
</td>
</TR>
</TABLE></form>
</td></tr>
</TABLE> 
<div id="result" name="result"></div>
<div id="res" name="res"></div>
 </form>
</body>
</html>