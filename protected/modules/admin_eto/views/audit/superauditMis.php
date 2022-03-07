<?php  
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));
$end_date = (!empty($end_date)?$end_date:strtoupper(date('d-M-Y')));

?>
<html><head>
<title>Super Audit MIS Screen</title>
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


</style>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">       
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script>
<script language="javascript" src="/js/calendar.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>


<script>
$(document).ready(
   
   function()
            {  
                $('#audit_summary').click(function(){
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['audit_summary']=$('#audit_summary').val();
                         result='';              
                        $.ajax({
                            url:"index.php?r=admin_eto/auditEto/SuperAuditMis/audit_summary&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#result').html(result);
                            }
                        }); 
            }); 

            $('#audit_report').click(function(){
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['audit_report']='audit_report';
                        result='';              
                        $.ajax({
                            url:"index.php?r=admin_eto/auditEto/SuperAuditMis/audit_report&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#resultm").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){
                                 $('#resultm').html(result);     
                                     $('#examplep').DataTable( {
                                        "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                                        "order": [[ 1, "desc" ]],
                                        "lengthMenu": [[10,25, 50, -1], [10,25, 50, "All"]]
                                    } );

                            }
                        });            
                        });
                       
            $('#audit_detail').click(function(){
                        a={};
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['audit_detail']='audit_detail';
                        result='';              
                        $.ajax({
                            url:"index.php?r=admin_eto/auditEto/SuperAuditMis/audit_detail&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#resultp").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){
                                 $('#resultp').html(result);     
                                     $('#example').DataTable( {
                                        "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                                        "order": [[ 1, "desc" ]],
                                        "lengthMenu": [[10,25, 50, -1], [10,25, 50, "All"]]
                                    } );

                            }
                        });            
                        });
        }
)
</script>
<style>
    th.dt-center, td.dt-center { text-align: center; }
</style>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;">
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">

<tr>
<td WIDTH="40%" style="font-weight: bold">&nbsp;Super Audit Date:&nbsp;&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
</td> 
</tr>                      
<tr><td td colspan="2"  align="center"> &nbsp; <input type="button" name="audit_summary" id="audit_summary" value="Super Audit Report Summary"> 
&nbsp;&nbsp;&nbsp; <input type="button" name="audit_report" id="audit_report" value="Super Audit Report"> &nbsp;&nbsp;&nbsp; <input type="button" name="audit_detail" id="audit_detail" value="Super Audit Detailed Report"> 
</td>
</TR>
</TABLE></FORM>
</td></tr>
</TABLE> 
<div id="result" name="result"></div>
    <div id="resultm" name="resultm"></div>
    <div id="resultp" name="resultp"></div>

</form>
</body>
</html>