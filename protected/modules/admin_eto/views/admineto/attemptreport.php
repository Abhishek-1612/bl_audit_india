<?php  $utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; ?>
<head>
<title>Payment Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; } 
.cancel 
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1; 
 
border-size:2px;border-style:solid;border-color:#0195d3;
} 
</style>

<script type="text/javascript" src="../protected/js/animatedcollapse.js"></script>
<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="<?php echo$utilsHost?>/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>

 

<script type="text/javascript">
$(document).ready(
    function()
            {
                  
                    $('#generate_report').click(function(){
                        a={};
                            a['vendor_approve']=$('#vendor_approve').val();
                            a['drp_pool']=$('#drp_pool').val();
                            a['start_date']=$('#start_date').val();
                            a['end_date']=$('#end_date').val();
                            a['generate_report']=$('#generate_report').val();
                        result='';               
                        $.ajax({
                           url:"/index.php?r=admin_eto/AdminEto/Attemptreport",
                            type: 'post',
                            data:a,
                            beforeSend: function(){$("#result").html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
			    success:function(result){                          
                               $('#result').html(result);                    
                            }
                        });                    
                    });  
            }
);   
  


</script>

<style type="text/css">
.dark{background : #eefaff;     }.wbg{background : #ffffff;      }.fnt{font-size:12px;width:33%;height:15px;}
.tab-container{ background:#ffffff; width:100%; margin:0px auto; border:1px solid #80c0e5;}.eb{ padding:0px 0px 0px 0px; margin:0px auto;width:100%; float:left;}
.data_off{display:none}.data_on{display:block}
.nav{ float:left;width:100%;}.nav ul{ padding:0px; margin:0px;}.nav ul li{ float:left; font-size:14px;list-style:none; font-weight:bold;}
.nav ul li a{ float:left; font-size:14px; color:#12569d; list-style:none; font-weight:bold;  height:30px; padding:0px 11px; border-left:1px solid #80c0e5; line-height:30px; text-decoration:none;}
.nav ul li a:hover{color:#000000; text-decoration:none;}.nav ul li a.selected{ float:left;color:#bc0800; list-style:none; font-weight:bold; background:#ffffff; background-image:none; height:30px; padding:0px 11px;  line-height:30px; text-decoration:none;border-left:1px solid #80c0e5}
</style>
</head>
<body>
<?php 
$start_date=$end_date= strtoupper(date('d-M-Y'));

echo '<div class="tab-container" id="left_tabs">';
    


    ?><form name="generateReportForm" id="generateReportForm" method="post" action="/index.php?r=admin_marketplace/payaudit/GenerateReport" style="margin-top:0;margin-bottom:0;">
     <input name="frame_height" id="frame_height" value="" type="hidden">
		    <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			  <TR>
			  <td bgcolor="#dff8ff" colspan="6" align="center"><font COLOR =" #333399"><b>Attempt Wise Report [Running with 48 Hour Old Data]</b></font>			 
			  </td>	
			  </TR>
			  <tr>
			  <td WIDTH="10%">&nbsp;Select Date:</td>
			  <td WIDTH="30%"> &nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.generateReportForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.generateReportForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input name="end_date"  type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.generateReportForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.generateReportForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
			  </td>
                          <td WIDTH="10%">&nbsp;Vendor :</td>
			  <td WIDTH="20%"> &nbsp;&nbsp;<select name="vendor_approve" id="vendor_approve" style="border-radius: 3px 3px 3px 3px;font-size: 100%;">
                            <?php         
                            foreach($vendorArr as $k)
                            {
                                    if($vendor_approve == $k)
                                            {
                                                    echo '<OPTION VALUE="'.$k.'" SELECTED="SELECTED" >'.$k.'</OPTION>';
                                            }
                                            else
                                            {
                                                    echo "<OPTION VALUE=\"$k\"  >$k</OPTION>";
                                            }

                            } echo '</select>';
                            ?>
			  </td>
                          
                           <td WIDTH="10%">&nbsp;Pool :</td>
			  <td WIDTH="20%"> &nbsp; <select id="drp_pool" name="drp_pool" width="100px">
                            <option value="" selected>--All--</option>
                            <option value="MUSTCALL" selected>Must Call</option>
                            <option value="DNC">DNC</option>
                            <option value="SERVICE">Service</option>
                            <option value="INTENT">Intent</option>
                           </select>
 
			  </td>
			  </tr>                          
                          
        <tr><TD colspan="6" align="center">                       
                        <input type="button" name="generate_report" id="generate_report" value="Generate Report"> 
                        <div id="loading1" class="busy" style="display:none; width:20px;height:20px;"> </div>
                        </TD>
                        </TR>
                        </TABLE><div id="result" name="result"></div></form>

<div style="clear:both;"><!-- --></div></div>