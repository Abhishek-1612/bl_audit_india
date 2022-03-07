<?php 
$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
?>
<head>
<title>DNC Report</title>
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
function trend_check(id)
{
 if(id ==1)
 {
  document.getElementById("end_date1").style.display='block';
 }
 else
 {
  document.getElementById("end_date1").style.display='none';
 }
 
}
function del_check(id)
{
 if(id.value =='approval')
 {
  document.getElementById("del_type").style.display='none';
 }
 if(id.value =='generation')
 {
  document.getElementById("del_type").style.display='none';
 }
 if(id.value =='deletion')
 {
  document.getElementById("del_type").style.display='block';
 }
}

function showdemanddata(req,flag)
{
	a={};
	a['trend'] = $('input[name=trend]:checked').val();
	a['start_date']=$('#start_date').val();
	a['end_date']=$('#end_date').val();
	a['req']=req;
	a['flag']=flag;
				
	var obj='demand_data'+req;
 
	document.getElementById('show_data'+req).style.display = "none";
	result='';  

	$.ajax({
		url:"index.php?r=admin_bl/DncReport/aovOndemand",
		type: 'post',
		data:a,
		beforeSend: function(){$("#"+obj).html("<DIV STYLE='font-size:18px; font-family:arial; text-align:center; color:#333333; margin:0 auto;'>Processing.....<br><IMG SRC='<?php echo$utilsHost?>/gifs/loading2.gif' align='absmiddle'></DIV>");},
		success:function(result){                          
		   document.getElementById(obj).innerHTML =result;                    
		}
	});                    
                    
} 
</script>
</head>

<form name="dncReport" id="dncReport" method="post" action="" style="margin-top:0;margin-bottom:0;" onsubmit="">
<input name="frame_height" id="frame_height" value="" type="hidden">
		    <table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
			  <TR>
				<td bgcolor="#dff8ff" colspan="4" align="center"><font COLOR =" #333399"><b>LEAP POOL WISE Report</b></font>			 </td>	
			  </TR>
			  <tr>

				<td WIDTH="15%">&nbsp;Date:</td>
				<td WIDTH="45%">
					&nbsp;<input name="start_date" type="text" VALUE="<?php echo $start_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.dncReport.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" TYPE="text" readonly="readonly">
			  
					<?php if(!isset($_REQUEST['trend']) || $_REQUEST['trend']=='datewise') { ?>
			  
					<div id="end_date1" style="margin-left:200px; margin-top:-20px;display:block;">
					<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div>
					<?php } 
					else
					{
					?>
					<div id="end_date1" style="margin-left:200px; margin-top:-20px;display:none;">
					<input name="end_date" type="text" VALUE="<?php echo $end_date; ?>" SIZE="13" onfocus="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.dncReport.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" TYPE="text" readonly="readonly"></div> <?php } ?>
				</td>
				
		
				<td >&nbsp;Trend: </td>
				<td>&nbsp;<input type="radio" name="trend" id="trend" onclick="trend_check(1);" value="datewise" 
				<?php
				if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='datewise') || !isset($_REQUEST['trend']))
				{
				 echo ' checked';
				}
				
				?>
				 >&nbsp;Date Wise
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="trend" id="trend" onclick="trend_check(2);" value="hourly"
				<?php
				if((isset($_REQUEST['trend']) && $_REQUEST['trend'] =='hourly'))
				{
				 echo ' checked';
				}
				
				?>
				>&nbsp;Hourly
				</td>
			
			</tr>
	<tr>
       <TD colspan="4" align="center">                      
			<input type="submit" name="submit_dump" id="submit_dump" value="Generate Report"> 
			<input type="hidden" name="action" value="generate">
		</TD>
	</TR>
</TABLE>
                        
  <?php
  
if(isset($_REQUEST['action']))
{	
	if($interval <=31)
	{   
		$type = isset($_REQUEST['trend']) ? $_REQUEST['trend'] : '';
		$arrayIndexs = array_keys($recData['1']);
		$loopCounter = ($type == 'datewise') ? @$recData['1']['ROWS'] : 23;

		$arrayOmission = array('ROWS');
		$headingTd = $dataTd = $timelinessTd = '';
		$colspanValue = $loopCounter+2;
		$colspanValue1 = $loopCounter+1;
		$dataTdArray = array("1"=>"Total Generated in High AOV","2"=>"Gen in High AOV & Approved in High AOV(Differentially Treated)","3"=>"Generated In rest & Approved in High AOV(Non-Differentially Treated)","4"=>"Gen in High AOV but Approved in Non High AOV(Differentially Treated but PMCAT is not in High AOV LIST");
		
		$headingIndexes = array_diff($arrayIndexs,$arrayOmission);
		
		if($type == 'datewise')
		{
			for($i=1;$i<=count($headingIndexes);$i++){
				$headingTd .= '<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="3%" >&nbsp;<B>'.@$headingIndexes[$i].'</B></TD>';
			}			
			
			for($x=1;$x<=count($recData);$x++)
			{
				$dataTd .= '<TR><TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="15%" >&nbsp;'.@$dataTdArray[$x].'</TD>';
				$dataArray = $recData[$x];
				foreach($dataArray as $key=>$value){
					if($key == 'ROWS'){
						CONTINUE;
					}else{
						$dataTd .='<TD STYLE="font-family:arial;font-size:11px;" ALIGN="RIGHT" width="3%" >&nbsp;<B>'.$value.'</B></TD>';
					}	
				}
			}
			foreach($result as $row){
				$timeliness = isset($row['TIMELINESS']) ? $row['TIMELINESS'] : 'NA';
				$timelinessTd .= '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="RIGHT" width="3%" >&nbsp;<B>'.$timeliness.'</B></TD>';
			}
		}else
		{
			$timelinessData = array_column($result, 'TIMELINESS', 'HR');

			$ArrHour=array('0'=>'00 - 01','1'=>'01 - 02','2'=>'02 - 03','3'=>'03 - 04','4'=>'04 - 05','5'=>'05 - 06','6'=>'06 - 07','7'=>'07 - 08','8'=>'08 - 09','9'=>'09 - 10','10'=>'10 - 11','11'=>'11 - 12','12'=>'12 - 13','13'=>'13 - 14','14'=>'14 - 15','15'=>'15 - 16','16'=>'16 - 17','17'=>'17 - 18','18'=>'18 - 19','19'=>'19 - 20','20'=>'20 - 21','21'=>'21 - 22','22'=>'22 - 23','23'=>'23 - 24');
			
			for($i=0;$i<=23;$i++){
				$headingTd .= '<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="3%">&nbsp;<B>'.$ArrHour[$i].'</B></TD>';
			}
			$headingTd1 = $headingTd;
			$headingTd .= '<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="5%">&nbsp;<B>Total</B></TD>';
			for($x=1;$x<=count($recData);$x++)
			{
				$dataTd .= '<TR><TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" width="15%" >&nbsp;'.@$dataTdArray[$x].'</TD>';
				$dataArray = $recData[$x];
				for($i=0;$i<=23;$i++)
				{
					$j = ($i <10) ? "0$i" : $i;
					$value = isset($dataArray[$j]) ? $dataArray[$j] : 'NA';				
					$dataTd .='<TD STYLE="font-family:arial;font-size:11px;" ALIGN="RIGHT">&nbsp;<B>'.$value.'</B></TD>';
					
					
				}
				$total = $dataArray['TOTAL'];
				$dataTd .='<TD STYLE="font-family:arial;font-size:11px;" ALIGN="RIGHT">&nbsp;<B>'.$total.'</B></TD>';
			}
			
			for($x =0; $x <=23 ;$x++)
			{
				$j = ($x <10) ? "0$x" : $x;
				$timeliness = isset($timelinessData[$j]) ? $timelinessData[$j] : 'NA';
				$timelinessTd .= '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="RIGHT">&nbsp;<B>'.$timeliness.'</B></TD>';	
			}

	
			$colspanValue++;			
			$colspanValue1++;
		}
		
		$colspanValue3 = $colspanValue+1;
		
		$headingTd1 = '<TR><TD width ="15%"></TD></TD>'.$headingTd.'</TR>';
		
		echo '<br><br><table width="100%" align="left" border="1" cellpadding="5" cellspacing="2"><TR><TD BGCOLOR="#dff8ff"></TD>'.$headingTd.'</TR>'.$dataTd.'</TR>
		
		<TR>
			<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
					 <div id="demand_data0">
			</TD>
		</TR>

		<TR>
			<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:13px;font-weight:bold;" ALIGN="CENTER" colspan="'.$colspanValue3.'">&nbsp;&nbsp;Differentially Treated</TD>
		</TR>
		
		<TR>
			<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
				<div id="demand1" style="width:auto;">
					<table align="CENTER" border="1" cellpadding="0" cellspacing="0">
						<table align="CENTER" border="1" cellpadding="0" cellspacing="0">
						'.$headingTd1.'	

						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;TIMELINESS</TD>'.$timelinessTd.'
							<TD STYLE="font-family:arial;font-size:11px;" ALIGN="RIGHT" width ="3%">&nbsp;<B>NA</B></TD>
						</TR>						
						
						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;ISQ</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data1"><a href="javascript:void(0);" onclick="showdemanddata(1,1);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data1" style="width:auto;">
							</TD>
						</TR>
						
						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;INDICATORS</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data2"><a href="javascript:void(0);" onclick="showdemanddata(2,1);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data2" style="width:auto;">
							</TD>
						</TR>
						
						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;QUALITY</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data3"><a href="javascript:void(0);" onclick="showdemanddata(3,1);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data3" style="width:auto;">
							</TD>
						</TR>
						
								<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;ISQ FEEDBACK</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data7"><a href="javascript:void(0);" onclick="showdemanddata(7,1);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data7" style="width:auto;">
							</TD>
						</TR>

						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;CUSTOM ISQ</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data8"><a href="javascript:void(0);" onclick="showdemanddata(8,1);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data8" style="width:auto;">
							</TD>
						</TR>

					</TABLE>
				</div>
			</TD>
		</TR>
		
		<TR>
			<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:13px;font-weight:bold;" ALIGN="CENTER" colspan="'.$colspanValue3.'">&nbsp;&nbsp;Non-Differentially Treated</TD>
		</TR>
		
		<TR>
			<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
				<div id="demand2" style="width:auto;">
					<table align="CENTER" border="1" cellpadding="0" cellspacing="0">
						'.$headingTd1.'			
						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT">&nbsp;&nbsp;ISQ</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data4"><a href="javascript:void(0);" onclick="showdemanddata(4,2);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data4" style="width:auto;">
							</TD>
						</TR>
						
						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;INDICATORS</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data5"><a href="javascript:void(0);" onclick="showdemanddata(5,2);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data5" style="width:auto;">
							</TD>
						</TR>
						
						<TR>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;font-weight:bold;" ALIGN="LEFT"  >&nbsp;&nbsp;QUALITY</TD>
							<TD BGCOLOR="#dff8ff" STYLE="font-family:arial;font-size:12px;" ALIGN="LEFT" colspan="'.$colspanValue1.'"><center><B><div id="show_data6"><a href="javascript:void(0);" onclick="showdemanddata(6,2);" style="text-decoration:none;">Show data</a></div></B></center></TD>	
						</TR>
						
						<TR>
							<TD STYLE="font-family:arial;font-size:11px;padding-left:10px" colspan="'.$colspanValue.'">
								 <div id="demand_data6" style="width:auto;">
							</TD>
						</TR>

					</TABLE>
				</div>
			</TD>
		</TR>
		
		</table>';
  
  
 } 
	else
	{
		echo '<div style="color:red;text-align:center;">Please Select Maximum 31 Days Date Range</div>'; 
	}
}
  
  
  
  
  ?>
