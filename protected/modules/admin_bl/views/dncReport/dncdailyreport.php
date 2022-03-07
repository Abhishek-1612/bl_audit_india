<?php 
$sel= ' checked';$sel_app='';
if((isset($_REQUEST['rtype']) && $_REQUEST['rtype'] =='gen'))
{
 $sel= ' checked';
}elseif((isset($_REQUEST['rtype']) && $_REQUEST['rtype'] =='app'))
{
 $sel_app= ' checked';
}

?>

<head>
<title>DNC Daily Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; } 
.cancel 
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1; 
 
border-size:2px;border-style:solid;border-color:#0195d3;
} 
</style>

<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">		
<script language="javascript" type="text/javascript" src="/js/jquery.min.js"></script> 
<script language="javascript" src="/js/calendar.js"></script>
<script>
</script>
</head>

<form name="dncReport" id="dncReport" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="">
<input name="frame_height" id="frame_height" value="" type="hidden">
		    <table align="center" style="border-collapse: collapse;width:70%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
			  <TR>
				<td bgcolor="#dff8ff" colspan="3" align="center"><font COLOR =" #333399"><b>DNC Daily Report</b></font>			 </td>	
			  </TR>
			  <tr>

                              <td WIDTH="15%"><b>&nbsp;Date:</b></td>
				<td WIDTH="50%">
					&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.dncReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
					<input style="display:none;" name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly">
                                       </td>
                                       <td WIDTH="35%"> &nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="rtype" id="rtype1" value="gen" <?php echo $sel;?>>&nbsp;Generation
			&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="rtype" id="rtype2" value="app" <?php echo $sel_app;?>>&nbsp; Approval </td>
			  </tr>
       <tr>
       <TD colspan="3" align="center">                      
			<input type="submit" name="submit_dump" id="submit_dump" value="Generate Report"> 
			<input type="hidden" name="action" value="generate">
		</TD>
	</TR>
</TABLE>
                        
  <?php
  
  if(isset($_REQUEST['action']))
  {
echo '<br><br><table align="center" style="border-collapse: collapse;width:70%" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">';
$count_tot_gen=$count_tot_app=0;
$tr_app=$tr_gen=$html='';
for($i=0;$i<count($recData);$i++){ //print_r($recData[$i]);//die;
                $pool=$recData[$i]['pool'];
                $count=$recData[$i]['count'];
                if (preg_match("/Gen/i", $pool)>0){
                    $count_tot_gen +=$count;
                    $tr_gen .= '<tr style="color: white;"><td align="left" style="padding:4px;background-color:white;"><b>'.$pool.'</b></td>
                    <td align="center" style="padding:4px;background-color:white"><b>'.$count.'</b></td>
                    </tr>';
                }      
                if (preg_match("/App/i", $pool)>0){
                    $count_tot_app +=$count;
                    $tr_app .= '<tr style="color: white;"><td align="left" style="padding:4px;background-color:white;"><b>'.$pool.'</b></td>
                    <td align="center" style="padding:4px;background-color:white"><b>'.$count.'</b></td>
                    </tr>';
                }
                
                }
                if($tr_gen<>''){
                $html.=  '<tr style="color: white;">
                <td align="left" style="padding:4px;"><b>Total Generation</b></td>
                <td align="center" style="padding:4px;"><b>'.$count_tot_gen.'</b></td>
                </tr>'.$tr_gen;
                }
                if($tr_app<>''){
                 $html.= '<tr style="color: white;">
                 <td align="left" style="padding:4px;"><b>Total Approval</b></td>
                 <td align="center" style="padding:4px;"><b>'.$count_tot_app.'</b></td>
                </tr>'.$tr_app;
                $html.=  '</table>';
                }
                echo $html;
  }
  
  
  
  
  ?>
