<?php
			    $leads_1hr_approv_transactions=$res[0];
			    $leads_2hr_approv_transactions=$res[1];
			    $leads_3hr_approv_transactions=$res[2];
			    $leads_4hr_approv_transactions=$res[3];
			    $leads_1hr_approv_unique=$res[4];
			    $leads_2hr_approv_unique=$res[5];
			    $leads_3hr_approv_unique=$res[6];
			    $leads_4hr_approv_unique=$res[7];
			    $str=$res[8];
			    $email_disabled=$res[9];
			    $sms_disabled=$res[10];
			    $email_enabled=$res[11];
			    $totalactiveusers=$res[12];
			    $usr_1to2_leads=$res[13];
			    $usr_3to5_leads=$res[14];
			    $usr_6to10_leads=$res[15];
			    $usr_10plus_leads=$res[16];
			    $str1=$res[17];
			    $count=$res[18];
			    $total_expired=$res[19];
			    $total_unsold=$res[20];
			    $no_supplier=$res[21];
			    $totalusers=$res[22];
			    $totalusers30=$res[23];
			    $totalusers_my=$res[24];
			    $usrcredits=$res[25];
			    $users_1lead=$res[26];
			    $nopurchase=$res[27];
			    $rejected=$res[28];
			    $rej_notpur=$res[29];
			   

if($req ==1)
{
 echo '<TR>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">';
				echo $str;
				
echo '</table>
						    </td>
						    </tr>';
                    echo '<TR>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>Email/Sms Disabled Users</B></TD></TR>
				<TR>			
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Email disabled users</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$email_disabled.'</TD>
				
				</TR>
				<TR>			
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>SMS disabled users</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$sms_disabled.'</TD>
				
				</TR></table>
				</td>
				</tr>';
                 echo '<TR>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>Total Email Alert enabled Users</B></TD></TR>
				<TR>			
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Email Enabled users</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$email_enabled.'</TD>
				
				</TR></table>
				</td>
				</tr>';
				
				
                echo '<TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>ACTIVE USERS PURCHASED ATLEAST ONE LEAD</B></TD></TR>
				<TR>			
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Active Users</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$totalactiveusers.'</TD></TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" ><b>Active Users with 1-2 Leads</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" >'.$usr_1to2_leads.' 			 
				</TD>
				</TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" ><b>Active Users with 3-5 Leads</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" >'.$usr_3to5_leads.' 			 
				</TD>
				</TR>
				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;padding:9px;" ><b>Active Users with 6-10 Leads</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" >'.$usr_6to10_leads.' 			 
				</TD>
				</TR>
				<TR>			
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Active Users with 10+ Leads</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$usr_10plus_leads.'</TD></TR>
				</table>
				</td>
				</tr>';
 
}
elseif($req==2)
{

      echo '<TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>NEVER USED</B></TD>			
				</TR>';
                               echo $str1;
		   
		   
		   if($count==0)
		   {
		   echo 'TR>			
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>COMPLIMENTRY</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >0</TD></TR>
				<TR>			
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>PAID</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >0</TD></TR>
				<TR>			
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>FREE</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >0</TD></TR>';
				
		    }
		  
		 echo '</table></td></tr>';
}
elseif($req==3)
{
 echo '<TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<TR>	
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Expired Leads</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$total_expired.'</TD></TR>
				</TR>
			
				<TR>	
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Unsold Leads</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$total_unsold.'</TD></TR>
				</TR>
			
				<TR>	
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Leads with No Supplier</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$no_supplier.'</TD></TR>
				</TR>
				</table>
				</td>
				</tr>';
				
		echo '<TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>No-Usage Credits Lapsed</B></TD>	</TR>
				<TR>	
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Users whose credits lapsed</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$totalusers.'</TD></TR>
				</TR>
			
				<TR>	
				<TD  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Users whose lapsed credits were &#60 30</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$totalusers30.'</TD></TR>
				</TR>
				</table>
				</td>
				</tr>';

}
elseif($req==4)
{
  echo '<TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<TR>	
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Users visited alerts section of MY  </b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$totalusers_my.'</TD></TR>
				</TR>
			
				<TR>	
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Users with &#62 0 Available Credits</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$usrcredits.'</TD></TR>
				<TR>	
				<TD   STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Users who purchased atleast one lead </b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$users_1lead.'</TD></TR>
				</TR>
				<TR>	
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Total Users who did not purchase any lead on MY </b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$nopurchase.'</TD></TR>
				</TR>
				<TR>	
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Marked any lead as N/I </b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$rejected.'</TD></TR>
				<TR>	
				<TD STYLE="font-family:arial;font-size:13px;padding:9px" ><b> Marked lead as N/I and not pur.any lead </b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$rej_notpur.'</TD></TR>
				</TR></TR>
				</table>
				</td>
				</tr>			
	
	</table>';

}
else
{
echo '
     <br><div>
		<table width="50%" border="0" cellpadding="0" cellspacing="0"  bgcolor="#ffffff">
     <TR>
		<td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>

				<TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>LEADS SOLD WITHIN \'x\' HR. OF APPROVAL</B></TD>			
				</TR>
				<TR>
				<TD STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30"><b>TOTAL</b>
				</TD>
				</TR>
				<TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 1 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_1hr_approv_transactions.'</TD>
				</TR>
				<TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 2 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_2hr_approv_transactions.'</TD>
				</TR>
				<TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 3 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_3hr_approv_transactions.'</TD>
				</TR>
				<TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 4 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_4hr_approv_transactions.'</TD>
				</TR>

				<TR>			
				<TD STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30"><b>Unique</b></TD>
				</TR>
				<TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 1 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_1hr_approv_unique.'
				</TD>
				</TR>
				<TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 2 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_2hr_approv_unique.'</TD>
				</TR><TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 3 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_3hr_approv_unique.'</TD>
				</TR><TR>
				<TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Lead sold within 4 hr of approval</b></TD>
				<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$leads_4hr_approv_unique.'</TD>
				</TR>
				</table>
				</td>
				</tr>';
				  echo '<TR>
				<td valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr><TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>MCAT\'s selected/Lead approved</B></TD>			
				<TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30">&nbsp;<B><div id="show_data1"><a href="javascript:void(0);" onclick="ShowDemandData(1);" style="text-decoration:none;">Show data</a></div></B></TD>
				</TR>
				<TR><TD STYLE="font-family:arial;font-size:13px;padding:9px" colspan="2">
				<div id="demand_data1">
				</TD>
				</TR>
				<tr>
                                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>NEVER USED</B></TD>
                                <TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30">&nbsp;<B><div id="show_data2"><a href="javascript:void(0);" onclick="ShowDemandData(2);" style="text-decoration:none;">Show data</a></div></B></TD>
				</TR>
				<TR><TD STYLE="font-family:arial;font-size:13px;padding:9px" colspan="2">
				<div id="demand_data2">
				</TD>
				</TR>
				<tr>
				<TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>EXPIRED UNSOLD</B></TD>
				<TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30">&nbsp;<B><div id="show_data3"><a href="javascript:void(0);" onclick="ShowDemandData(3);" style="text-decoration:none;">Show data</a></div></B></TD>
				</TR>
				<TR><TD STYLE="font-family:arial;font-size:13px;padding:9px" colspan="2">
				<div id="demand_data3">
				</TD>
				</TR>
				<tr><TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>ACTIVE USERS:ONLINE ACTIVITY</B></TD>
				<TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30">&nbsp;<B><div id="show_data4"><a href="javascript:void(0);" onclick="ShowDemandData(4);" style="text-decoration:none;">Show data</a></div></B></TD>
				</TR>
				<TR><TD STYLE="font-family:arial;font-size:13px;padding:9px" colspan="2">
				<div id="demand_data4">
				</TD>
				</TR>
				</TR></div>';
}
?>