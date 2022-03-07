<?php 
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
?>

<head>
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
$(document).ready(
    function()
            {
                    $("#result").css("width", "100%");     
                    $('#generate_report').click(function(){
                        
                    var start=new Date(document.generateReportForm.start_date.value);
                    var end=new Date(document.generateReportForm.end_date.value);
                    var timeDiff = end.getTime() - start.getTime();
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
                    if (diffDays>7)
                    {
                     alert("Kindly Select Dates In Span Of 7 Days Only");
                     return false;
                    }else{
                        a={};
                            a['start_date']=$('#start_date').val();
                            a['end_date']=$('#end_date').val();
                            a['action']='generate_report';
                        result='';               
                        $.ajax({
                           url:"/index.php?r=admin_bl/Eto_rej_ofr/Topmcatreport&mid=3439",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....</DIV>");},
			    success:function(result){                          
                               $('#result').html(result);                    
                            }
                        });   
                        
    }
                    });  
            }
);   
                      
</script>
</head>

<form name="generateReportForm" id="generateReportForm" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="">
<input name="frame_height" id="frame_height" value="" type="hidden">
		    <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			  <TR>
				<td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>Top 50 Rejected Mcat Report</b></font>			 </td>	
			  </TR>
			  <tr>

				<td WIDTH="15%">&nbsp;Date:</td>
				<td WIDTH="45%">
&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.generateReportForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.generateReportForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
			  <input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.generateReportForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.generateReportForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div>
				</td>
			
		
	</tr>
	<tr>
       <TD colspan="2" align="center">                      
<input type="button" name="generate_report" id="generate_report" value="Generate Report">
<div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
		</TD>
	</TR>
                    </table>
<div id="result" name="result"></div></form>

<div style="clear:both;"><!-- --></div>
                        
  