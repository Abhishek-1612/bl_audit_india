<?php  
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
$start_date = (!empty($start_date)?$start_date:strtoupper(date('d-M-Y')));
$end_date = (!empty($end_date)?$end_date:strtoupper(date('d-M-Y')));
$mcat_name=isset($mcat_name) ? $mcat_name : '';
$mcat_id=isset($mcat_id) ? $mcat_id : '';
$p = '';
$s = '';
$radio_val1 = isset($_REQUEST['radio_val']) ? $_REQUEST['radio_val'] : '';
if ($radio_val1 == "") {
   $radio_val1 = isset($_REQUEST['radio_val1']) ? $_REQUEST['radio_val1'] : '';
}

if (($radio_val1 == 'p') or ($radio_val1 == "")) {
       $p = 'checked';
   } else {
       $s = 'checked';
   }
?>
<html><head>
<title>TOV ML Prediction Audit MIS Screen</title>
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

<LINK HREF="/css/jquery.dataTables.min.css" REL="STYLESHEET" TYPE="text/css">
<script language="javascript" src="/js/jquery.dataTables.min.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

<script>
     
function chbg() {
    
    document.getElementById('u6').style.backgroundColor = "#f7f3e6";
    document.getElementById('u3').style.backgroundColor = "#f7f3e6";
    document.getElementById('u4').style.backgroundColor = "#f7f3e6";
    document.getElementById('u9').style.backgroundColor = "#f7f3e6";
    document.getElementById('u0').style.backgroundColor = "#f7f3e6";
    document.getElementById('u7').style.backgroundColor = "#f7f3e6";
} 
function chbg1() {
    
    document.getElementById('u6').style.backgroundColor = "#F0F9FF";
    document.getElementById('u3').style.backgroundColor = "#F0F9FF";
    document.getElementById('u4').style.backgroundColor = "#F0F9FF";
    document.getElementById('u9').style.backgroundColor = "#ffd1e9";
    document.getElementById('u0').style.backgroundColor = "#F0F9FF";
    document.getElementById('u7').style.backgroundColor = "#ffd1e9";
} 
function chbg3() {
    
    document.getElementById('u6').style.backgroundColor = "#f7f3e6";
    document.getElementById('u7').style.backgroundColor = "#f7f3e6";
} 
function chbg4() {
    
    document.getElementById('u6').style.backgroundColor = "#F0F9FF";
    document.getElementById('u7').style.backgroundColor = "#ffd1e9";
} 
function chbg5() {
    
    document.getElementById('u6').style.backgroundColor = "#f7f3e6";
    document.getElementById('u9').style.backgroundColor = "#f7f3e6";
    document.getElementById('u3').style.backgroundColor = "#f7f3e6";
} 
function chbg6() {
    document.getElementById('u9').style.backgroundColor = "#ffd1e9";
    document.getElementById('u6').style.backgroundColor = "#F0F9FF";
    document.getElementById('u3').style.backgroundColor = "#F0F9FF";
} 
function chbg7() {
    
    document.getElementById('u0').style.backgroundColor = "#f7f3e6";
    document.getElementById('u9').style.backgroundColor = "#f7f3e6";
} 
function chbg8() {
    document.getElementById('u9').style.backgroundColor = "#ffd1e9";
    document.getElementById('u0').style.backgroundColor = "#F0F9FF";
} 
function chbg9() {
    
    document.getElementById('u0').style.backgroundColor = "#f7f3e6";
    document.getElementById('u7').style.backgroundColor = "#f7f3e6";
    document.getElementById('u4').style.backgroundColor = "#f7f3e6";
} 
function chbg0() {
    
    document.getElementById('u0').style.backgroundColor = "#F0F9FF";
    document.getElementById('u7').style.backgroundColor = "#ffd1e9";
    document.getElementById('u4').style.backgroundColor = "#F0F9FF";
} 
$(document).ready(
   
   function()
            {  
                $('#audit_usage').click(function(){
                        a={};
                        a['mcat_name']=$('#mcat_name').val();
                        a['mcat_id']=$('#mcatid11').val();
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['audit_usage']=$('#audit_usage').val();
                        a['vendor']=$('#vendor').val();
                        a['quantity_flag']=$('#quantity_flag').val();
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Auditmis&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#result').html(result);
                            }
                        }); 
            }); 
            $('#audit_tov').click(function(){
                        a={};
                        a['mcat_name']=$('#mcat_name').val();
                        a['mcat_id']=$('#mcatid11').val();
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['audit_tov']=$('#audit_tov').val();
                        a['vendor']=$('#vendor').val();
                        a['quantity_flag']=$('#quantity_flag').val();
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Auditmis&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#result').html(result);
                            }
                        }); 
            }); 
            $('#audit_retail').click(function(){
                        a={};
                        a['mcat_name']=$('#mcat_name').val();
                        a['mcat_id']=$('#mcatid11').val();
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['audit_retail']=$('#audit_retail').val();
                        a['vendor']=$('#vendor').val();
                        a['quantity_flag']=$('#quantity_flag').val();
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Auditmis&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#result').html(result);
                            }
                        }); 
                    }); 
            $('#mcataudit').click(function(){
                        a={};
                        a['mcat_name']=$('#mcat_name').val();
                        a['mcat_id']=$('#mcatid11').val();
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['mcataudit']=$('#mcataudit').val();
                        a['vendor']=$('#vendor').val();
                        a['quantity_flag']=$('#quantity_flag').val();
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Auditmis&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#resultm").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){                         
                               $('#resultm').html(result);
                                $('#examplem').DataTable( {
                                    "columnDefs": [{"className": "dt-center", "targets": "_all"}],
                                    "order": [[ 1, "desc" ]],
                                    "lengthMenu": [[10,20, 50, -1], [10,20, 50, "All"]]
                                } );
                            }
                        }); 
            }); 
            

            $('#detailed').click(function(){
                        a={};
                        a['mcat_name']=$('#mcat_name').val();
                        a['mcat_id']=$('#mcatid11').val();
                        a['start_date']=$('#start_date').val();
                        a['end_date']=$('#end_date').val();
                        a['detailed']='detailed';
                        a['vendor']=$('#vendor').val();
                        a['quantity_flag']=$('#quantity_flag').val();
                         result='';              
                        $.ajax({
                            url:"/index.php?r=admin_eto/LeapMLReport/Auditmis&mid=3934",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#resultp").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
                            success:function(result){
                                 $('#resultp').html(result);     
                                     $('#examplep').DataTable( {
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

<script>

function lookup(idd,obj,divId) 

{	var auto_ajax_call=0;
	$("#mcatsmain").css("display", "block");
	var inputString=$('#'+idd).val();
	obj = "find";
			
	if(inputString.length == 0) {
		$('#'+divId).html('<div></div>');
	} 
	else if(inputString.length > 2)
	{
		if(/[.]/.test(inputString)){
			$('#'+divId).html('<div></div>');
		}
		else
		{
			var typ='P';			
            if(document.searchForm.radio_val.value == 'p')
					{
						typ='P';
					}
					else if(document.searchForm.radio_val.value == 's')
					{
						typ='S';
					}
					auto_ajax_call++;
                $.post("/cron/rpc2.php", {queryString: ""+inputString+"", ff: ""+typ+"",searchtype:""+obj+"", ajax_rq: ""+auto_ajax_call+""}, function(data){
				if(data.length >0) {
                     var mcat_arr = data.split("###");
                     if(mcat_arr[0] == auto_ajax_call)
                     {
                        $('#'+divId).html(mcat_arr[1]);
					 }
				}
				else{
					$('#'+divId).html('<div></div>');
				}
			});				
		}
	}
	else if(inputString.length <=2){
		$('#'+divId).html('<div></div>');
	}
}
	
function abc(mcatname,mcatid)
{	
	mcat_name.value=mcatname;
	mcatid11.value=mcatid;
	$("#mcatsmain").hide(); 
}

</script>
<style>
    th.dt-center, td.dt-center { text-align: center; }
</style>
</head>
<body><input name="frame_height" id="frame_height" value="" type="hidden">
<form name="searchForm" id="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;">
<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
<TR>
    <td colspan="3" style="width:10%;padding:4px;background-color:#009DCC;color:#fff;font-weight:bold;" align="center">TOV ML Prediction Audit MIS Screen</td>
</tr>
<tr>
<td WIDTH="40%" style="font-weight: bold">&nbsp;Approval Date:&nbsp;&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date;?>" SIZE="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
&nbsp;<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
</td> 
<td><?php               
echo '<FORM name="searchForm" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" id = "searchForm">
<input type="hidden" name="mid" value="'.$_REQUEST["mid"].'">
<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
<TR>';
echo '<td WIDTH="8%"><b>MCAT:</b>&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE="TEXT" name="mcat_name" id="mcat_name" autocomplete="off" onkeyup="lookup(\'mcat_name\',\'MCAT\',\'mcats\');" value="'.$mcat_name.'">
<INPUT TYPE="hidden" name="mcatid11" id="mcatid11" value="'.$mcat_id.'">';
echo '<input type="hidden" name="action1" id="action1" value="">'
. '<input type="hidden" name="radio_val" value="'.$radio_val1.'"><input type="radio" id="radioval1" name="radioval" value="P" '.$p.' onclick="showhide();">Product
<input type="radio" id="radioval2" name="radioval" value="S" '.$s.' onclick="showhide();">Service</TD></tr></table></td>';
?>
    <td><b>Audited By:</b> &nbsp;<select name="vendor" id="vendor"><OPTION VALUE="">All</OPTION><OPTION VALUE="18">DDN</OPTION><OPTION VALUE="9">Noida</OPTION>
 </select></td>
</tr>                      
<TR>
<td>&nbsp;</td><TD colspan="2"><div id="mcatsmain" style="height:200px;overflow:auto;display:none; font-family: arial;font-size: 13px;width:425px;">
<div id="mcats"></div></div></TD>
</TR>
<tr><td align="left">
<b>Select Qty:</b> &nbsp;<select name="quantity_flag" id="quantity_flag"><OPTION VALUE="">ALL</OPTION> 
<option value="wq">Qty Filled</option>
<option value="woutq">Qty Not Filled</option>
</select></td><td colspan="2" align="left">&nbsp; <input type="button" name="audit_usage" id="audit_usage" value="Usage Audit Summary"> 
        &nbsp;&nbsp;&nbsp; <input type="button" name="audit_tov" id="audit_tov" value="TOV Audit Summary"> 
        &nbsp;&nbsp;&nbsp; <input type="button" name="audit_retail" id="audit_retail" value="Retail Audit Summary"> 
        &nbsp;&nbsp;&nbsp; <input type="button" name="mcataudit" id="mcataudit" value="Mcat Wise Audit Summary"> 
        &nbsp;&nbsp;&nbsp; <input type="button" name="detailed" id="detailed" value="Detailed Audit Report"> 
</TD>
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
