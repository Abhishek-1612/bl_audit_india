<?php	

$heading = 'BL Consumption - Daily - Hourly Report (For Today)';
if($_SERVER['HTTP_HOST'] == 'dev-gladmin.intermesh.net' || $_SERVER['HTTP_HOST'] == 'stg-gladmin.intermesh.net')
{
	$heading = 'BL Consumption - Daily - Hourly Report (For Yesterday)';
}	
?>

<html>
<body>
	
<title>BL Consumption Report</title>
<style type="text/css"> .button { width: 150px; padding: 10px; background-color: #FF8C00; box-shadow: -8px 8px 10px 3px rgba(0,0,0,0.2); font-weight:bold; text-decoration:none; } #cover{ position:fixed; top:0; left:0; background:rgba(0,0,0,0.6); z-index:5; width:100%; height:100%; display:none; } #loginScreen { height:380px; width:340px; margin:0 auto; position:relative; z-index:10; display:none; background: url(login.png) no-repeat; border:5px solid #cccccc; border-radius:10px; } #loginScreen:target, #loginScreen:target + #cover{ display:block; opacity:1; } 
.cancel 
{ display:block; position:absolute; top:0px; right:0px; background:#f0f9ff;z-index:5; color:black; height:154px; width:600px; font-size:30px; text-decoration:none; text-align:center; font-weight:bold;opacity:1; 
 
border-size:2px;border-style:solid;border-color:#0195d3;
} 
</style>

<link href="/css/report.css" rel="STYLESHEET" type="text/css">		

<FORM name="searchForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;">
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
		<tbody>
		
			<tr>
				<td bgcolor="#dff8ff" align="center" colspan="2"><font color=" #333399"><b><?php echo $heading; ?></b></font></td>	
			</tr>
			
<!-- 		Date selection Code	
			<tr>
				<td width="20%">&nbsp;Date:</td>
				<td width="30%"> &nbsp;
					<input name="start_date" type="text" value="" size="13" onfocus="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" onclick="displayCalendar(document.searchForm.start_date,'dd-mm-yyyy',this,'','','from_date1')" id="start_date" readonly="readonly">
							  
					<input name="end_date" type="text" value="" size="13" onfocus="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" onclick="displayCalendar(document.searchForm.end_date,'dd-mm-yyyy',this,'','','to_date1')" id="end_date" readonly="readonly"> 
				</td>												  
			</tr>
-->
			
			<tr>											
				<td colspan="2" align="center">                 
					<input type="hidden" name="step" value="1" id ="step">
					<input type="hidden" name="action" value="display">
					<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
				</td>	
			</tr>
				
		</tbody>
	</table>                
</form>
<?php
if(!empty($data))
{
	$cnt = COUNT($data);
	$sumArray = array();
	$bg_table = '#B5EAAA';
	$bg_table_web = '#FFCCCC';
	$bg_table_mob = '#E6E6FA';
	
	echo '<br><TABLE WIDTH="100%" BORDER="1" CELLPADDING="5" CELLSPACING="1" ALIGN="CENTER" border-color="#f8f8f8" style="border-collapse:collapse" >
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" HEIGHT="30" rowspan="2" ALIGN="CENTER"><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hour&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Leads Sold</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Leads Sold (UNIQUE)</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Total Credits Used</B></TD>
		<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="4"><B>Web Used </B></TD>
		<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="9"><B>Mail Used</B></TD>
		<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="4"><B>Attribution for Display Only</B></TD>    
		<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="9"><B>Mobile Used</B></TD>
	</TR>
	
	<TR>
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>MY</B></TD>
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>ETO</B></TD>
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>HT</B></TD>
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>FFEXT</B></TD>		
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>TOTAL</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>EMORNING</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>MORNING</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>LEVENING</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>AUTOINSTANT</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>INSTANT</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>WITHINST</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Others</B></TD>
	<TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>HT Mail</B></TD>			
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Mail Mob</B></TD>			
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Email App</B></TD>
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Email Mob</B></TD>
	<TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Email MY</B></TD>    
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Fusion App (W)</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Fusion App (B)</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Fusion App (I)</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Android Total</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Android Email Direct</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Android App</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTE.iR"><b>Android SMS</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTE.iR"><b>MIM</b></td>
	<TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTE.iR"><b>MIM SMS</b></td>
	</TR>';
	
	foreach($data as $val)
	{	echo '<TR>';
		foreach($val as $key=>$value){
			if($key=='ETO_PUR_DATE'){
				// $hrArray = array('0' => "00:00-00:59",'1' => "01:00-01:59",'2' => "02:00-02:59",'3' => "03:00-03:59",'4' => "04:00-04:59",'5' => "05:00-05:59",'6' => "06:00-06:59",'7' => "07:00-07:59",'8' => "08:00-08:59",'9' => "09:00-09:59",'10' => "10:00-10:59",'11' => "11:00-12:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59",'10' => "10:00-10:59", '2' => "D", '3' => "E", '4' => "P", '5' => "R", '6' => "T",'7' => "A");
				
				$hr= $value.':00-'.$value.':59';
				$value = $hr;
			}
			echo '<TD BGCOLOR="#FFFFFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'."$value".'</TD>';
			@$sumArray[$key]+=$value;
		}
	}
	$sumArray['ETO_PUR_DATE'] = 'Total';
	echo '<TR>';
	$colorCounter = 1;
	
	foreach($sumArray as $key=>$value)
	{
		if($colorCounter <= 4){
			$bgColor = "#CCCCFF";
		}
		elseif($colorCounter > 4 && $colorCounter <= 8){
			$bgColor = "#FFCCCC";
		}		
		elseif($colorCounter > 8 && $colorCounter <= 17){
			$bgColor = "#B5EAAA";
		}
		elseif($colorCounter > 17 && $colorCounter <= 21){
			$bgColor = "#FFCCCC";
		}	
		elseif($colorCounter > 21 && $colorCounter < 31){
			$bgColor = "#E6E6FA";
		}
		if($key == 'LEAD_SOLD_UNIQUE'){ $value = '-';}
		echo '<TD  BGCOLOR="'.$bgColor.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>'."$value".'</b></TD>';
		$colorCounter++;
	}
}

?>
