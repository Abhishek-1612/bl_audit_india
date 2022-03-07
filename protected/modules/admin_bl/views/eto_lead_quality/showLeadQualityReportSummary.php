<?php

 

 $L_15 = '';
 $L_30= ''; 
 $L_45= ''; 
 $L_60= ''; 
 $LT_1= ''; 
 $LT_2= ''; 
 $LT_3= ''; 
 $LT_4= ''; 
 $LT_5= '';
 $MORE_THEN_8_HR= ''; 
 $MORE_THEN_8HR= '';




if(isset($rec['TOTAL_APPROV']) && $rec['TOTAL_APPROV'] != 0 )
{
		$L_15 = ($rec1['M15']/$rec['TOTAL_APPROV']) * 100;
 		$L_15 = round( $L_15);
		$L_30 = ($rec1['M30']/$rec['TOTAL_APPROV']) * 100;
		$L_30 = round( $L_30);
		$L_45 = ($rec1['M45']/$rec['TOTAL_APPROV']) * 100;
 		$L_45 = round( $L_45);
		$L_60 = ($rec1['M60']/$rec['TOTAL_APPROV']) * 100;
 		$L_60 = round( $L_60);


		$LT_1 = ($rec1['T1_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 		$LT_1 = round( $LT_1);
		$LT_2 = ($rec1['T2_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 		$LT_2 = round( $LT_2);
		$LT_3 = ($rec1['T3_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 		$LT_3 = round( $LT_3);
		$LT_4 = ($rec1['T4_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 		$LT_4 = round( $LT_4);
		$LT_5 = ($rec1['T5_TOTAL']/$rec['TOTAL_APPROV']) * 100;
 		$LT_5 = round( $LT_5);
		$MORE_THEN_8_HR = ($rec['TOTAL_APPROV']-( $rec1['T1_TOTAL'] + $rec1['T2_TOTAL'] + $rec1['T3_TOTAL']));
		$MORE_THEN_8HR = ($MORE_THEN_8_HR/$rec['TOTAL_APPROV']) * 100;
 		$MORE_THEN_8HR = round( $MORE_THEN_8HR);
}
else
{


$L_15 = 0;
 $L_15 = round( $L_15);
	
$L_30 = 0;
 $L_30 = round( $L_30);
		
$L_45 = 0;
 $L_45 = round( $L_45);
		
$L_60 = 0;
 $L_60 = round( $L_60);

$LT_1 = 0;
 $LT_1 = round( $LT_1);

$LT_2 = 0;
 $LT_2 = round( $LT_2);

$LT_3 = 0;
 $LT_3 = round( $LT_3);

$LT_4 = 0;
 $LT_4 = round( $LT_4);

$LT_5 = 0;
 $LT_5 = round( $LT_5);

$MORE_THEN_8_HR = 0;
 $MORE_THEN_8_HR = round( $MORE_THEN_8_HR);

 $MORE_THEN_8HR = round( $MORE_THEN_8HR);
$MORE_THEN_8HR = 0;

}


                         $tot_lead_sold = isset( $rec_transaction['TOT']) ? $rec_transaction['TOT'] : 0;
			 $in_sold = isset($rec_transaction['SOLD_LEADS_IN']) ? $rec_transaction['SOLD_LEADS_IN'] : 0;
			 $for_sold = isset($rec_transaction['SOLD_LEADS_FORN']) ? $rec_transaction['SOLD_LEADS_FORN'] : 0;
			 $totalunq_sold = isset($rec_transaction['UNIQ_SOLD']) ? $rec_transaction['UNIQ_SOLD'] : 0;
			 $unq_in_sold = isset($rec_transaction['UNIQ_IN']) ? $rec_transaction['UNIQ_IN'] : 0;
			 $unq_for_sold = isset($rec_transaction['UNIQ_FOR']) ? $rec_transaction['UNIQ_FOR'] : 0;
		
#***********************query for fenq generated leads*****************************
		

  echo '
		<div>
		
		<table width="80%" border="0" cellpadding="0" cellspacing="0" align="CENTER" bgcolor="#ffffff">	
	<tr>
	<td height="30" colspan="2" align="CENTER" bgcolor="#ccccff" style="font-family:arial;font-weight:bold;font-size:11px;border-top:1px solid #ffffff">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="20%" height="30" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Buy Lead Latency (in Hours)</b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
	</tr>	
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">0 - 1 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['T1_TOTAL'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$LT_1.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px"> 1 - 3 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['T4_TOTAL'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$LT_4.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px"> 1 - 8 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['T2_TOTAL'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$LT_2.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px"> 3 - 24 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['T5_TOTAL'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$LT_5.'%</td>
	</tr>
	</table></td>
	</tr>


	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">8 - 24 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['T3_TOTAL'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$LT_3.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">MORE THAN 24 HR</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$MORE_THEN_8_HR.'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$MORE_THEN_8HR.'%</td>
	</tr>
	</table></td>
	</tr>


	<tr>
	<td height="30" colspan="2" align="CENTER" bgcolor="#ccccff" style="font-family:arial;font-weight:bold;font-size:11px;border-top:1px solid #ffffff">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td width="20%" height="30" style="padding-left:8px;color:#0303bd; font-size:13px;"><b>Buy Lead Latency (in Minutes)</b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
		<td width="15%" style="padding-left:8px;color:#0303bd; font-size:13px;"><b></b></td>
	</tr>	
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">0 - 15 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['M15'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$L_15.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">15 - 30 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['M30'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$L_30.'%</td>
	</tr>
	</table></td>
	</tr>

	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">30 - 45 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['M45'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$L_45.'%</td>
	</tr>
	</table></td>
	</tr>
	<tr>
	<td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td width="20%" height="30" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;padding-left:40px">45 - 60 MIN</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$rec1['M60'].'</td>
		<td width="15%" style="font-size:11px;font-family:arial;color:#000000;border-bottom:1px solid #cacaca;border-left:1px solid #cacaca;padding-left:10px">'.$L_60.'%</td>
	</tr>
	</table></td>
		<TR >
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>LEAD PURCHASE ACTIVITY</B></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" ><b>Total Leads Sold - Unique</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" >'.$totalunq_sold.' 			 
				</TD></TR>
				<TR>			
				<TD width="15%" STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px;" >Indian Sold - Unique</TD>
				<TD STYLE="font-family:arial;font-size:11px;" >'.$unq_in_sold.'</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px" >Foreign Sold - Unique</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$unq_for_sold.'</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Leads Sold - Transactions</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$tot_lead_sold.'</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px" >Indian Lead - Transactions</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$in_sold.'</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px 0px 9px 29px" >Foreign Lead - Transactions</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$for_sold.'</TD></TR></table></td></tr>


		<TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>Total Leads Rejected</B></TD>			
				</TR>
				<TR>			
				<TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px;" >Total General leads generated</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$total_general_generated.'			 
				</TD></TR>
				<TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px;" >Total General leads approved</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$total_general_approved.' 			 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total General leads Rejected</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$total_general_rejected.' 			 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Fenq leads Generated</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" > '.$total_fenq_generated.'			 
				</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" >Total Fenq leads approved</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$total_fenq_approved.' 			 
				</TD></TR>		 
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" >Total Fenq Leads Rejected</TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$total_fenq_rejected.'</TD>
				</TR><table></td></tr>				
		

	</table>
</div>
<br><br><br>';
?>