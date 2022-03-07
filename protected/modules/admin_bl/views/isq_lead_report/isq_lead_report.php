<?php
	$hostname=$_SERVER['SERVER_NAME'];
	$q = $_REQUEST;
	$fields = array('adate_day','adate_month','adate_year','bdate_day','bdate_month','bdate_year','modid','client');
	$param=array();
	foreach ($fields as $key) 
	{
     		if (!empty($q[$key])) 
		{
        		$param[$key]=$q[$key];
     		} 
		else 
		{
        		$param[$key]='';
     		}
  	}

// 	my ($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time);
	list($curr_year,$curr_month,$curr_day)= preg_split('/-/',date('Y-m-d'));
// 	$curr_month=$curr_month+1;
// 	if($curr_month < 10)
// 	{
// 		$curr_month='0'.$curr_month;
// 	}
// 	$curr_year=$curr_year+1900;

	$months = array('01' => "January",
             '02' => "February",
	     '03' => "March",
	     '04' => "April",
	     '05' => "May",
	     '06' => "June",
	     '07' => "July",
	     '08' => "August",
	     '09' => "September",
	     '10' => "October",
	     '11' => "November",
	     '12' => "December");


?>
<SCRIPT LANGUAGE="JavaScript">
	function checkBuyForm()
	{

		if(document.searchForm.bdate_day.value == 0 || document.searchForm.bdate_month.value == 0 || document.searchForm.bdate_year.value == 0)
		{
			alert("Fill Start Date");
			return false;
		}
	
		if(document.searchForm.adate_day.value == 0 || document.searchForm.adate_month.value == 0 || document.searchForm.adate_year.value == 0)
		{
			alert("Fill End Date");
			return false;
		}
	
		if(document.searchForm.bdate_month.value == 2 || document.searchForm.bdate_month.value == 4
		|| document.searchForm.bdate_month.value == 6|| document.searchForm.bdate_month.value == 9|| document.searchForm.bdate_month.value == 11)
		{
			if(document.searchForm.bdate_day.value == 31)
			{
			alert("This date does not exists");
			return false;
			}
		}
		if(document.searchForm.adate_month.value == 2 || document.searchForm.adate_month.value == 4
		|| document.searchForm.adate_month.value == 6|| document.searchForm.adate_month.value == 9|| document.searchForm.adate_month.value == 11)
		{
			if(document.searchForm.adate_day.value == 31)
			{
			alert("This date does not exists");
			return false;
			}
		}
	}
</SCRIPT><input name="frame_height" id="frame_height" value="" type="hidden">
<FORM name="searchForm" METHOD="post" ACTION="http://<?php echo $hostname; ?>/index.php?r=admin_bl/Isq_lead_report/Index&mid=3483" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
		<TR>
			<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">ISQ Lead Report</TD>
		</TR>
	</TABLE>
	<TABLE WIDTH="100%" ALIGN="CENTER" BORDER="0" CELLPADDING="0" CELLSPACING="1">
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD>
		<TD STYLE="font-family:arial;font-size:12px;font-weight:bold;" 
		BGCOLOR="#EAEAEA">
			<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
			<TR>
				<TD>
					<SELECT NAME="bdate_day" SIZE="1">
            				<OPTION VALUE="0">Day</OPTION>
<?php
	for($i=1;$i<=31;$i++)
	{
		if($i<10)
		{
			if($param['bdate_day'] == $i)
			{
				echo <<<qqq
<OPTION VALUE="0$i" SELECTED >0$i</OPTION>
qqq;
			}
			elseif($i == $curr_day && empty($param['bdate_day']))
			{
				echo <<<qqq
<OPTION VALUE="0$i" SELECTED >0$i</OPTION>
qqq;
			}
			else
			{
				echo <<<qqq
<OPTION VALUE="0$i" >0$i</OPTION>
qqq;
			}
		}
		else
		{
			if($param['bdate_day'] == $i)
			{
				echo <<<qqq
<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
			}
			elseif($i == $curr_day && empty($param['bdate_day']))
			{
				echo <<<qqq
<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
			}
			else
			{
				echo <<<qqq
<OPTION VALUE="$i" >$i</OPTION>
qqq;
			}
		}
	}
?>
					</SELECT>
				</TD>
           			 <TD>
					<SELECT NAME="bdate_month" SIZE="1">
            				<OPTION VALUE="0">Month</OPTION>
<?php
	ksort($months,SORT_NUMERIC);
	foreach(array_keys($months) as $key)
	{
		 if(!empty($param['bdate_month']) && $param['bdate_month'] == $key) {
                       echo <<<qqq
<OPTION VALUE="$key" SELECTED >$months[$key]</OPTION">
qqq;
                   }
		elseif($key == $curr_month && empty($param['bdate_month']))
		{
		echo <<<qqq
<OPTION VALUE="$key" SELECTED >$months[$key]</OPTION>
qqq;
		}
		else
		{
		echo <<<qqq
<OPTION VALUE="$key" >$months[$key]</OPTION>
qqq;
		}
	}

?>
		
					</SELECT>
				</TD>
           			 <TD>
					<SELECT NAME="bdate_year" SIZE="1">
            				<OPTION VALUE="0">Year</OPTION>;
<?php
	for($i=2011;$i<=2020;$i++)
	{
		if(!empty($param['bdate_year']) && $param['bdate_year'] == $i) 
		{
			echo <<<qqq
			<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
		}
		elseif($i == $curr_year && empty($param['bdate_year']))
		{
			echo <<<qqq
			<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
		}
		else
		{
echo <<<qqq
			<OPTION VALUE="$i" >$i</OPTION>
qqq;
		}
	}
?>

					</SELECT>
				</TD>
				<TD>&nbsp;to&nbsp;</TD>
				<TD>
					<SELECT NAME="adate_day" SIZE="1">
            				<OPTION VALUE="0">Day</OPTION>
<?php
	for($i=1;$i<=31;$i++)
	{
		if($i<10)
		{
			if($param['adate_day'] == $i)
			{
				echo <<<qqq
<OPTION VALUE="0$i" SELECTED >0$i</OPTION>
qqq;
			}
			elseif($i == $curr_day && empty($param['adate_day']))
			{
				echo <<<qqq
<OPTION VALUE="0$i" SELECTED >0$i</OPTION>
qqq;
			}
			else
			{
				echo <<<qqq
<OPTION VALUE="0$i" >0$i</OPTION>
qqq;
			}
		}
		else
		{
			if($param['adate_day'] == $i)
			{
				echo <<<qqq
<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
			}
			elseif($i == $curr_day && empty($param['adate_day']))
			{
				echo <<<qqq
<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
			}
			else
			{
				echo <<<qqq
<OPTION VALUE="$i" >$i</OPTION>
qqq;
			}
		}
	}
?>
					</SELECT>
				</TD>
				<TD>
				<SELECT NAME="adate_month" SIZE="1">
				<OPTION VALUE="0">Month</OPTION>
<?php
	ksort($months);
	foreach($months as $key => $val)
	{
		 if(!empty($param['adate_month']) && $param['adate_month'] == $key) {
                       echo <<<qqq
<OPTION VALUE="$key" SELECTED >$months[$key]</OPTION">
qqq;
                   }
		elseif($key == $curr_month && empty($param['adate_month']))
		{
		echo <<<qqq
<OPTION VALUE="$key" SELECTED >$months[$key]</OPTION>
qqq;
		}
		else
		{
		echo <<<qqq
<OPTION VALUE="$key" >$months[$key]</OPTION>
qqq;
		}
	}

?>

				</SELECT>
				</TD>
            			<TD>
					<SELECT NAME="adate_year" SIZE="1">
            				<OPTION VALUE="0">Year</OPTION>

<?php
	for($i=2011;$i<=2020;$i++)
	{
		if(!empty($param['adate_year']) && $param['adate_year'] == $i) 
		{
			echo <<<qqq
			<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
		}
		elseif($i == $curr_year && empty($param['adate_year']))
		{
			echo <<<qqq
			<OPTION VALUE="$i" SELECTED >$i</OPTION>
qqq;
		}
		else
		{
echo <<<qqq
			<OPTION VALUE="$i" >$i</OPTION>
qqq;
		}
	}
?>
					</SELECT>
				</TD>
			</TR>
		</TABLE>
	</TD>	
	</TR>
	</TABLE>
	<br><br>
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
		<input type="hidden" name="step" value="1" id ="step">
		<input type="hidden" name="action" value="get_weekly_gen_rpt">
		<INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
		</TD>
	</TR>
	</TABLE></FORM>
<?php 
$submit =isset($_REQUEST['Submit1']) ? $_REQUEST['Submit1'] : '';
if($submit)
{
    if($db=='PG'){
        $rec=pg_fetch_array($sth_mcats);
       $live_mcats=isset($rec['cnt']) ? $rec['cnt'] : 0;
       $rec1=pg_fetch_array($sth_mcats_isq);
       $live_mcats_isq=isset($rec1['cnt']) ? $rec1['cnt'] : 0;
       $rec4=pg_fetch_array($sth_direct);
       $direct_lead_genration=isset($rec4['direct_lead_genration']) ? $rec4['direct_lead_genration'] : 0;
       
       $rec_direct_isq=pg_fetch_array($sth_direct_isq);
       $direct_lead_genration_isq=isset($rec_direct_isq['direct_lead_genration']) ? $rec_direct_isq['direct_lead_genration'] : 0;
       
  
       $rec_gen_fenq_isq=pg_fetch_array($sth_gen_fenq_isq);
       $fenq_lead_genration_isq=isset($rec_gen_fenq_isq['fenq_lead_genration']) ? $rec_gen_fenq_isq['fenq_lead_genration'] : 0;
       
       
       $rec2=pg_fetch_array($sth_gen_fenq);
       $fenq_lead_genration=isset($rec2['fenq_lead_genration']) ? $rec2['fenq_lead_genration'] : 0;
       
       $rec3=pg_fetch_array($sth_lead_approved);  
       $direct_lead_approv=isset($rec3['direct_lead_approv']) ? $rec3['direct_lead_approv'] : 0;
       $fenq_lead_approv=isset($rec3['fenq_lead_approv']) ? $rec3['fenq_lead_approv'] : 0;
       
       
        $rec1=pg_fetch_array($sth_isq_approved);  
       $direct_lead_approv_isq_res=isset($rec1['direct_lead_approv_isq_res']) ? $rec1['direct_lead_approv_isq_res'] : '';
       $fenq_lead_approv_isq_res=isset($rec1['fenq_lead_approv_isq_res']) ? $rec1['fenq_lead_approv_isq_res'] : '';
       
  echo '<table align="CENTER" border="0" width="70%" cellpadding="5" cellspacing="2">
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Mcats Live</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$live_mcats.'</B></TD>	
	</TR>
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Mcats With ISQ</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$live_mcats_isq.'</B></TD>	
	</TR>
	
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Generated From These Mcats</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	    
	   
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fenq_lead_genration.'</TD>	
	       </TR>
	       <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$direct_lead_genration.'</TD>	
	       </TR>';
	
	
	echo '
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Generated ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fenq_lead_genration_isq.'</TD>	
	      </TR>';
              
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$direct_lead_genration_isq.'</TD>	
	      </TR>';
        
        
        echo '<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approval Leads </B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fenq_lead_approv.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$direct_lead_approv.'</TD>	
	</TR>';
	
        
        
        
	echo '<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approval Leads  With ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fenq_lead_approv_isq_res.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$direct_lead_approv_isq_res.'</TD>	
	</TR>';
	if($direct_lead_genration_isq !=0)
	{
	$direct_per=($direct_lead_approv_isq_res/$direct_lead_genration_isq)*100;
	$direct_per=round($direct_per,2);
	}
	else
	{
	$direct_per=0;
	}
	if($fenq_lead_genration_isq != 0)
	{
	$fenq_per=($fenq_lead_approv_isq_res/$fenq_lead_genration_isq)*100;
	$fenq_per=round($fenq_per,2);
	}
	else
	{
	$fenq_per=0;
	}
	
	echo '
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Approval %</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ %</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fenq_per.'%</TD>	
	</TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct %</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$direct_per.'%</TD>	
	</TR>
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Sold & Unsold</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	$rec=pg_fetch_array($sth_lead_sold);
	$uniq_sold=$rec['tot_purchased'];
	echo '
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Sold For ISQ MCATS</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$uniq_sold.'</TD>	
	</TR>';
	$rec=pg_fetch_array($sth_lead_sold_isq);
	$uniq_sold_isq=$rec['tot_purchased_isq'];
echo '	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Sold For ISQ MCATS With ISQ Response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$uniq_sold_isq.'</TD>	
	</TR>
	
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>FEEDBACK</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	$rec=pg_fetch_array($buylead_feedback_sth1);
	$im_supplier_submit=isset($rec['im supplier submit']) ? $rec['im supplier submit'] : '';
	$other_supplier_submit=isset($rec['other supplier submit']) ? $rec['other supplier submit'] : '';
	$postponed_submit=isset($rec['postponed submit']) ? $rec['postponed submit'] : '';
	$need_supp_submit=isset($rec['need supp submit']) ? $rec['need supp submit'] : '';
	$rec=pg_fetch_array($buylead_feedback_sth2);
	$negotiation_submit=isset($rec['negotiation submit']) ? $rec['negotiation submit'] : '';



	$rec=pg_fetch_array($enquiry_feedback_sth1);



	$im_supplier_submit2=isset($rec['im supplier submit']) ? $rec['im supplier submit'] : '';
	$other_supplier_submit2=isset($rec['other supplier submit']) ? $rec['other supplier submit'] : '';
	$postponed_submit2=isset($rec['postponed submit']) ? $rec['postponed submit'] : '';


	$rec=pg_fetch_array($enquiry_feedback_sth2);
	$negotiation_submit2=isset($rec['negotiation submit']) ? $rec['negotiation submit'] : '';

	$rec=pg_fetch_array($enquiry_feedback_sth3);
	$need_supp_submit2=isset($rec['need supp submit']) ? $rec['need supp submit'] : '';

	$bl= 'im='.$im_supplier_submit.' | other-'.$other_supplier_submit.' | postponed-'.$postponed_submit.' | negotiation-'.$negotiation_submit.' | need supp-'.$need_supp_submit;
	if(($im_supplier_submit2+$other_supplier_submit2+$postponed_submit2+$negotiation_submit2+$need_supp_submit2) !=0)
	{
	$im_supplier_submit=($im_supplier_submit/($im_supplier_submit+$postponed_submit+$other_supplier_submit+$need_supp_submit+$negotiation_submit))*100;
	}
	else
	{
	$im_supplier_submit=0;
	}
	$im_supplier_submit=round($im_supplier_submit,2);

        $enq= 'im='.$im_supplier_submit2.' | other-'.$other_supplier_submit2.' | postponed-'.$postponed_submit2.' | negotiation-'.$negotiation_submit2.' | need supp-'.$need_supp_submit2;
        if(($im_supplier_submit2+$other_supplier_submit2+$postponed_submit2+$negotiation_submit2+$need_supp_submit2) != 0)
        {
	$im_supplier_submit2=($im_supplier_submit2/($im_supplier_submit2+$other_supplier_submit2+$postponed_submit2+$negotiation_submit2+$need_supp_submit2))*100;
	}
	else
	{
	$im_supplier_submit2=0;
	}
	$im_supplier_submit2=round($im_supplier_submit2,2);
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Buylead Feedback</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$im_supplier_submit.'% ('.$bl.')</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Enquiry Feedback</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$im_supplier_submit2.'% ('.$enq.')</TD></TR>
		<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Platform Wise Generation</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	$rec=pg_fetch_array($sth_lead_platform);
	
	$mob_gen=isset($rec['lead_genration_mob']) ? $rec['lead_genration_mob'] : '';
	$app_gen=isset($rec['lead_genration_app']) ? $rec['lead_genration_app'] : '';
	$email_gen=isset($rec['lead_genration_email']) ? $rec['lead_genration_email'] : '';
	$web_gen= isset($rec['lead_genration_web']) ? $rec['lead_genration_web'] : '';
	$leap_gen=isset($rec['lead_genration_leap']) ? $rec['lead_genration_leap'] : '';
	$buyrcall_gen=isset($rec['lead_genration_buyrcall']) ? $rec['lead_genration_buyrcall'] : '';
	
	$mob_app=isset($rec['lead_approved_mob']) ? $rec['lead_approved_mob'] : '';
	$app_app=isset($rec['lead_approved_app']) ? $rec['lead_approved_app'] : '';
	$email_app=isset($rec['lead_approved_email']) ? $rec['lead_approved_email'] : '';
	$web_app=isset($rec['lead_approved_web']) ? $rec['lead_approved_web'] : '';
	$leap_app=isset($rec['lead_approved_leap']) ? $rec['lead_approved_leap'] : '';
	$buyrcall_app=isset($rec['lead_approved_buyrcall']) ? $rec['lead_approved_buyrcall'] : '';
	 
	$rec_fenq=pg_fetch_array($sth_lead_platform_fenq);
	
	$mob_gen_fenq= isset($rec_fenq['lead_genration_mob']) ? $rec_fenq['lead_genration_mob'] : '';
	$app_gen_fenq=isset($rec_fenq['lead_genration_app']) ? $rec_fenq['lead_genration_app'] : '';
	$email_gen_fenq= isset($rec_fenq['lead_genration_email']) ? $rec_fenq['lead_genration_email'] : '';
	$web_gen_fenq= isset($rec_fenq['lead_genration_web']) ? $rec_fenq['lead_genration_web'] : '';
	$leap_gen_fenq= isset($rec_fenq['lead_genration_leap']) ? $rec_fenq['lead_genration_leap'] : '';
	$buyrcall_gen_fenq= isset($rec_fenq['lead_genration_buyrcall']) ? $rec_fenq['lead_genration_buyrcall'] : '';
	
	$mob_app_fenq=isset($rec_fenq['lead_approved_mob']) ? $rec_fenq['lead_approved_mob'] : '';
	$app_app_fenq=isset($rec_fenq['lead_approved_app']) ? $rec_fenq['lead_approved_app'] : '';
	$email_app_fenq=isset($rec_fenq['lead_approved_email']) ? $rec_fenq['lead_approved_email'] : '';
	$web_app_fenq=isset($rec_fenq['lead_approved_web']) ? $rec_fenq['lead_approved_web'] : '';
	$leap_app_fenq=isset($rec_fenq['lead_approved_leap']) ? $rec_fenq['lead_approved_leap'] : '';
	$buyrcall_app_fenq=isset($rec_fenq['lead_approved_buyrcall']) ? $rec_fenq['lead_approved_buyrcall'] : '';
	
	$total_mob_gen=$mob_gen+$mob_gen_fenq;
	$total_app_gen=$app_gen+$app_gen_fenq;
	$total_email_gen=$email_gen+$email_gen_fenq;
	$totalweb_gen=$web_gen+$web_gen_fenq;
	$totalleap_gen=$leap_gen+$leap_gen_fenq;
	$totalbuyrcall_gen=$buyrcall_gen+$buyrcall_gen_fenq;
	
	$total_mob_app=$mob_app+$mob_app_fenq;
	$total_app_app=$app_app+$app_app_fenq;
	$total_email_app=$email_app+$email_app_fenq;
	$total_web_app=$web_app+$web_app_fenq;
	$total_leap_app=$leap_app+$leap_app_fenq;
	$total_buyrcall_app=$buyrcall_app+$buyrcall_app_fenq;
	
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;WEB</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$totalweb_gen.' ( Direct='.$web_gen.', Fenq='.$web_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;LEAP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$totalleap_gen.' ( Direct='.$leap_gen.', Fenq='.$leap_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;BUYRCALL</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$totalbuyrcall_gen.' ( Direct='.$buyrcall_gen.', Fenq='.$buyrcall_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;M.IM</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_mob_gen.' ( Direct='.$mob_gen.', Fenq='.$mob_gen_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;APP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_app_gen.' ( Direct='.$app_gen.', Fenq='.$app_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;EMKTG</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_email_gen.' ( Direct='.$email_gen.', Fenq='.$email_gen_fenq.' )</TD>	
	</TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Platform Wise Approval</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;WEB</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_web_app.' ( Direct='.$web_app.', Fenq='.$web_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;LEAP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_leap_app.' ( Direct='.$leap_app.', Fenq='.$leap_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;BUYRCALL</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_buyrcall_app.' ( Direct='.$buyrcall_app.', Fenq='.$buyrcall_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;M.IM</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_mob_app.'( Direct='.$mob_app.', Fenq='.$mob_app_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;APP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_app_app.' ( Direct='.$app_app.', Fenq='.$app_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;EMKTG</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_email_app.' ( Direct='.$email_app.', Fenq='.$email_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Response-count wise Approved Lead & Sold Leads</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
         $rec=pg_fetch_array($sth_lead_res_count);
	
	$cnt_1=isset($rec['cnt_1']) ? $rec['cnt_1'] : '';
	$cnt_2=isset($rec['cnt_2']) ? $rec['cnt_2'] : '';
	$cnt_3=isset($rec['cnt_3']) ? $rec['cnt_3'] : '';
	$cnt_4=isset($rec['cnt_4']) ? $rec['cnt_4'] : '';
	$cnt_5=isset($rec['cnt_5']) ? $rec['cnt_5'] : '';
	$rec=pg_fetch_array($sth_lead_res_count_sold);
	
	$sold_cnt_1=isset($rec['sold_cnt_1']) ? $rec['sold_cnt_1'] : '';
	$sold_cnt_2=isset($rec['sold_cnt_2']) ? $rec['sold_cnt_2'] : '';
	$sold_cnt_3=isset($rec['sold_cnt_3']) ? $rec['sold_cnt_3'] : '';
	$sold_cnt_4=isset($rec['sold_cnt_4']) ? $rec['sold_cnt_4'] : '';
	$sold_cnt_5=isset($rec['sold_cnt_5']) ? $rec['sold_cnt_5'] : '';
	
 $rec_fenq=pg_fetch_array($sth_lead_res_count_fenq);
	
	$cnt_1_fenq=isset($rec_fenq['cnt_1']) ? $rec_fenq['cnt_1'] : '';
	$cnt_2_fenq= isset($rec_fenq['cnt_2']) ? $rec_fenq['cnt_2'] : '';
	$cnt_3_fenq=isset($rec_fenq['cnt_3']) ? $rec_fenq['cnt_3'] : '';
	$cnt_4_fenq= isset($rec_fenq['cnt_4']) ? $rec_fenq['cnt_4'] : '';
	$cnt_5_fenq= isset($rec_fenq['cnt_5']) ? $rec_fenq['cnt_5'] : '';
 $rec_fenq=pg_fetch_array($sth_lead_res_count_sold_fenq);
	
	$sold_cnt_1_fenq=isset($rec_fenq['sold_cnt_1']) ? $rec_fenq['sold_cnt_1'] : '';
	$sold_cnt_2_fenq=isset($rec_fenq['sold_cnt_2']) ? $rec_fenq['sold_cnt_2'] : '';
	$sold_cnt_3_fenq=isset($rec_fenq['sold_cnt_3']) ? $rec_fenq['sold_cnt_3'] : '';
	$sold_cnt_4_fenq=isset($rec_fenq['sold_cnt_4']) ? $rec_fenq['sold_cnt_4'] : '';
	$sold_cnt_5_fenq=isset($rec_fenq['sold_cnt_5']) ? $rec_fenq['sold_cnt_5'] : '';
	
$total_cnt1=$cnt_1+$cnt_1_fenq;	
$total_cnt2=$cnt_2+$cnt_2_fenq;
$total_cnt3=$cnt_3+$cnt_3_fenq;
$total_cnt4=$cnt_4+$cnt_4_fenq;
$total_cnt5=$cnt_5+$cnt_5_fenq;

$total_sold_cnt1=$sold_cnt_1+$sold_cnt_1_fenq;
$total_sold_cnt2=$sold_cnt_2+$sold_cnt_2_fenq;
$total_sold_cnt3=$sold_cnt_3+$sold_cnt_3_fenq;
$total_sold_cnt4=$sold_cnt_4+$sold_cnt_4_fenq;
$total_sold_cnt5=$sold_cnt_5+$sold_cnt_5_fenq;
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 1 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt1.' (Direct='.$cnt_1.' , Fenq= '.$cnt_1_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 1 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt1.' (Direct='.$sold_cnt_1.' , Fenq= '.$sold_cnt_1_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 2 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt2.' (Direct='.$cnt_2.' , Fenq= '.$cnt_2_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 2 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt2.' (Direct='.$sold_cnt_2.' , Fenq= '.$sold_cnt_2_fenq.' )</TD>	
	</TR>
		
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 3 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt3.' (Direct='.$cnt_3.' , Fenq= '.$cnt_3_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 3 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt3.' (Direct='.$sold_cnt_3.' , Fenq= '.$sold_cnt_3_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 4 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt4.' (Direct='.$cnt_4.' , Fenq= '.$cnt_4_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 4 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt4.' (Direct='.$sold_cnt_4.' , Fenq= '.$sold_cnt_4_fenq.' )</TD>	
	</TR>
	   <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 5 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt5.' (Direct='.$cnt_5.' , Fenq= '.$cnt_5_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 5 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt5.' (Direct='.$sold_cnt_5.' , Fenq= '.$sold_cnt_5_fenq.' )</TD>	
	</TR>';
	
	
	 $rec=pg_fetch_array($sth_new_direct_gen_app);
	 
	 $direct_lead_genration_new=isset($rec['direct_lead_genration']) ? $rec['direct_lead_genration'] : '';
	 $direct_lead_approved_new=isset($rec['direct_lead_approved']) ? $rec['direct_lead_approved'] : '';
	 
	  $rec=pg_fetch_array($sth_new_fenq_gen);
	  
	  $fenq_lead_genration_new=isset($rec['fenq_lead_genration']) ? $rec['fenq_lead_genration'] : '';
	  
	   $rec=pg_fetch_array($sth_new_fenq_app);
	   
	   $fenq_lead_approv_isq_res_new=isset($rec['fenq_lead_approv_isq_res']) ? $rec['fenq_lead_approv_isq_res'] : '';
	   
	  echo '
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Generated ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fenq_lead_genration_new.'</TD>	
	      </TR>';
              
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$direct_lead_genration_new.'</TD>	
	      </TR>'; 
	echo '<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approval Leads  With ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$fenq_lead_approv_isq_res_new.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$direct_lead_approved_new.'</TD>	
	</TR>';
	
    }else{
        $rec=oci_fetch_array($sth_mcats,OCI_BOTH);
       $live_mcats=isset($rec['CNT']) ? $rec['CNT'] : 0;
       $rec1=oci_fetch_array($sth_mcats_isq,OCI_BOTH);
       $live_mcats_isq=isset($rec1['CNT']) ? $rec1['CNT'] : 0;
       $rec4=oci_fetch_array($sth_direct,OCI_BOTH);
       $DIRECT_LEAD_GENRATION=isset($rec4['DIRECT_LEAD_GENRATION']) ? $rec4['DIRECT_LEAD_GENRATION'] : 0;
       
       $rec_direct_isq=oci_fetch_array($sth_direct_isq,OCI_BOTH);
       $DIRECT_LEAD_GENRATION_ISQ=isset($rec_direct_isq['DIRECT_LEAD_GENRATION']) ? $rec_direct_isq['DIRECT_LEAD_GENRATION'] : 0;
       
  
       $rec_gen_fenq_isq=oci_fetch_array($sth_gen_fenq_isq,OCI_BOTH);
       $FENQ_LEAD_GENRATION_ISQ=isset($rec_gen_fenq_isq['FENQ_LEAD_GENRATION']) ? $rec_gen_fenq_isq['FENQ_LEAD_GENRATION'] : 0;
       
       
       $rec2=oci_fetch_array($sth_gen_fenq,OCI_BOTH);
       $FENQ_LEAD_GENRATION=isset($rec2['FENQ_LEAD_GENRATION']) ? $rec2['FENQ_LEAD_GENRATION'] : 0;
       
       $rec3=oci_fetch_array($sth_lead_approved,OCI_BOTH);  
       $DIRECT_LEAD_APPROV=isset($rec3['DIRECT_LEAD_APPROV']) ? $rec3['DIRECT_LEAD_APPROV'] : 0;
       $FENQ_LEAD_APPROV=isset($rec3['FENQ_LEAD_APPROV']) ? $rec3['FENQ_LEAD_APPROV'] : 0;
       
       
        $rec1=oci_fetch_array($sth_isq_approved,OCI_BOTH);  
       $DIRECT_LEAD_APPROV_ISQ_RES=isset($rec1['DIRECT_LEAD_APPROV_ISQ_RES']) ? $rec1['DIRECT_LEAD_APPROV_ISQ_RES'] : '';
       $FENQ_LEAD_APPROV_ISQ_RES=isset($rec1['FENQ_LEAD_APPROV_ISQ_RES']) ? $rec1['FENQ_LEAD_APPROV_ISQ_RES'] : '';
       
  echo '<table align="CENTER" border="0" width="70%" cellpadding="5" cellspacing="2">
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Total Mcats Live</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$live_mcats.'</B></TD>	
	</TR>
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Mcats With ISQ</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>'.$live_mcats_isq.'</B></TD>	
	</TR>
	
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Generated From These Mcats</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	    
	   
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$FENQ_LEAD_GENRATION.'</TD>	
	       </TR>
	       <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$DIRECT_LEAD_GENRATION.'</TD>	
	       </TR>';
	
	
	echo '
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Generated ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$FENQ_LEAD_GENRATION_ISQ.'</TD>	
	      </TR>';
              
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$DIRECT_LEAD_GENRATION_ISQ.'</TD>	
	      </TR>';
        
        
        echo '<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approval Leads </B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$FENQ_LEAD_APPROV.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$DIRECT_LEAD_APPROV.'</TD>	
	</TR>';
	
        
        
        
	echo '<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approval Leads  With ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$FENQ_LEAD_APPROV_ISQ_RES.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$DIRECT_LEAD_APPROV_ISQ_RES.'</TD>	
	</TR>';
	if($DIRECT_LEAD_GENRATION_ISQ !=0)
	{
	$Direct_per=($DIRECT_LEAD_APPROV_ISQ_RES/$DIRECT_LEAD_GENRATION_ISQ)*100;
	$Direct_per=round($Direct_per,2);
	}
	else
	{
	$Direct_per=0;
	}
	if($FENQ_LEAD_GENRATION_ISQ != 0)
	{
	$FENQ_per=($FENQ_LEAD_APPROV_ISQ_RES/$FENQ_LEAD_GENRATION_ISQ)*100;
	$FENQ_per=round($FENQ_per,2);
	}
	else
	{
	$FENQ_per=0;
	}
	
	echo '
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Approval %</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ %</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$FENQ_per.'%</TD>	
	</TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct %</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$Direct_per.'%</TD>	
	</TR>
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Sold & Unsold</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	$rec=oci_fetch_array($sth_lead_sold,OCI_BOTH);
	$uniq_sold=$rec['TOT_PURCHASED'];
	echo '
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Sold For ISQ MCATS</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$uniq_sold.'</TD>	
	</TR>';
	$rec=oci_fetch_array($sth_lead_sold_isq,OCI_BOTH);
	$uniq_sold_isq=$rec['TOT_PURCHASED_ISQ'];
echo '	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Leads Sold For ISQ MCATS With ISQ Response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$uniq_sold_isq.'</TD>	
	</TR>
	
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>FEEDBACK</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	$rec=oci_fetch_array($BUYLEAD_FEEDBACK_sth1,OCI_BOTH);
	$IM_SUPPLIER_SUBMIT=isset($rec['IM SUPPLIER SUBMIT']) ? $rec['IM SUPPLIER SUBMIT'] : '';
	$OTHER_SUPPLIER_SUBMIT=isset($rec['OTHER SUPPLIER SUBMIT']) ? $rec['OTHER SUPPLIER SUBMIT'] : '';
	$POSTPONED_SUBMIT=isset($rec['POSTPONED SUBMIT']) ? $rec['POSTPONED SUBMIT'] : '';
	$NEED_SUPP_SUBMIT=isset($rec['NEED SUPP SUBMIT']) ? $rec['NEED SUPP SUBMIT'] : '';
	$rec=oci_fetch_array($BUYLEAD_FEEDBACK_sth2,OCI_BOTH);
	$Negotiation_submit=isset($rec['Negotiation submit']) ? $rec['Negotiation submit'] : '';



	$rec=oci_fetch_array($Enquiry_FEEDBACK_sth1,OCI_BOTH);



	$IM_SUPPLIER_SUBMIT2=isset($rec['IM SUPPLIER SUBMIT']) ? $rec['IM SUPPLIER SUBMIT'] : '';
	$OTHER_SUPPLIER_SUBMIT2=isset($rec['OTHER SUPPLIER SUBMIT']) ? $rec['OTHER SUPPLIER SUBMIT'] : '';
	$POSTPONED_SUBMIT2=isset($rec['POSTPONED SUBMIT']) ? $rec['POSTPONED SUBMIT'] : '';


	$rec=oci_fetch_array($Enquiry_FEEDBACK_sth2,OCI_BOTH);
	$Negotiation_submit2=isset($rec['Negotiation submit']) ? $rec['Negotiation submit'] : '';

	$rec=oci_fetch_array($Enquiry_FEEDBACK_sth3,OCI_BOTH);
	$NEED_SUPP_SUBMIT2=isset($rec['NEED SUPP SUBMIT']) ? $rec['NEED SUPP SUBMIT'] : '';

	$bl= 'IM='.$IM_SUPPLIER_SUBMIT.' | Other-'.$OTHER_SUPPLIER_SUBMIT.' | Postponed-'.$POSTPONED_SUBMIT.' | Negotiation-'.$Negotiation_submit.' | Need Supp-'.$NEED_SUPP_SUBMIT;
	if(($IM_SUPPLIER_SUBMIT2+$OTHER_SUPPLIER_SUBMIT2+$POSTPONED_SUBMIT2+$Negotiation_submit2+$NEED_SUPP_SUBMIT2) !=0)
	{
	$IM_SUPPLIER_SUBMIT=($IM_SUPPLIER_SUBMIT/($IM_SUPPLIER_SUBMIT+$POSTPONED_SUBMIT+$OTHER_SUPPLIER_SUBMIT+$NEED_SUPP_SUBMIT+$Negotiation_submit))*100;
	}
	else
	{
	$IM_SUPPLIER_SUBMIT=0;
	}
	$IM_SUPPLIER_SUBMIT=round($IM_SUPPLIER_SUBMIT,2);

        $enq= 'IM='.$IM_SUPPLIER_SUBMIT2.' | Other-'.$OTHER_SUPPLIER_SUBMIT2.' | Postponed-'.$POSTPONED_SUBMIT2.' | Negotiation-'.$Negotiation_submit2.' | Need Supp-'.$NEED_SUPP_SUBMIT2;
        if(($IM_SUPPLIER_SUBMIT2+$OTHER_SUPPLIER_SUBMIT2+$POSTPONED_SUBMIT2+$Negotiation_submit2+$NEED_SUPP_SUBMIT2) != 0)
        {
	$IM_SUPPLIER_SUBMIT2=($IM_SUPPLIER_SUBMIT2/($IM_SUPPLIER_SUBMIT2+$OTHER_SUPPLIER_SUBMIT2+$POSTPONED_SUBMIT2+$Negotiation_submit2+$NEED_SUPP_SUBMIT2))*100;
	}
	else
	{
	$IM_SUPPLIER_SUBMIT2=0;
	}
	$IM_SUPPLIER_SUBMIT2=round($IM_SUPPLIER_SUBMIT2,2);
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Buylead Feedback</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$IM_SUPPLIER_SUBMIT.'% ('.$bl.')</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Enquiry Feedback</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$IM_SUPPLIER_SUBMIT2.'% ('.$enq.')</TD></TR>
		<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Platform Wise Generation</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	$rec=oci_fetch_array($sth_lead_platform,OCI_BOTH);
	
	$mob_gen=isset($rec['LEAD_GENRATION_MOB']) ? $rec['LEAD_GENRATION_MOB'] : '';
	$app_gen=isset($rec['LEAD_GENRATION_APP']) ? $rec['LEAD_GENRATION_APP'] : '';
	$email_gen=isset($rec['LEAD_GENRATION_EMAIL']) ? $rec['LEAD_GENRATION_EMAIL'] : '';
	$web_gen= isset($rec['LEAD_GENRATION_WEB']) ? $rec['LEAD_GENRATION_WEB'] : '';
	$leap_gen=isset($rec['LEAD_GENRATION_LEAP']) ? $rec['LEAD_GENRATION_LEAP'] : '';
	$BUYRCALL_gen=isset($rec['LEAD_GENRATION_BUYRCALL']) ? $rec['LEAD_GENRATION_BUYRCALL'] : '';
	
	$mob_app=isset($rec['LEAD_APPROVED_MOB']) ? $rec['LEAD_APPROVED_MOB'] : '';
	$app_app=isset($rec['LEAD_APPROVED_APP']) ? $rec['LEAD_APPROVED_APP'] : '';
	$email_app=isset($rec['LEAD_APPROVED_EMAIL']) ? $rec['LEAD_APPROVED_EMAIL'] : '';
	$web_app=isset($rec['LEAD_APPROVED_WEB']) ? $rec['LEAD_APPROVED_WEB'] : '';
	$leap_app=isset($rec['LEAD_APPROVED_LEAP']) ? $rec['LEAD_APPROVED_LEAP'] : '';
	$BUYRCALL_app=isset($rec['LEAD_APPROVED_BUYRCALL']) ? $rec['LEAD_APPROVED_BUYRCALL'] : '';
	 
	$rec_fenq=oci_fetch_array($sth_lead_platform_fenq,OCI_BOTH);
	
	$mob_gen_fenq= isset($rec_fenq['LEAD_GENRATION_MOB']) ? $rec_fenq['LEAD_GENRATION_MOB'] : '';
	$app_gen_fenq=isset($rec_fenq['LEAD_GENRATION_APP']) ? $rec_fenq['LEAD_GENRATION_APP'] : '';
	$email_gen_fenq= isset($rec_fenq['LEAD_GENRATION_EMAIL']) ? $rec_fenq['LEAD_GENRATION_EMAIL'] : '';
	$web_gen_fenq= isset($rec_fenq['LEAD_GENRATION_WEB']) ? $rec_fenq['LEAD_GENRATION_WEB'] : '';
	$leap_gen_fenq= isset($rec_fenq['LEAD_GENRATION_LEAP']) ? $rec_fenq['LEAD_GENRATION_LEAP'] : '';
	$BUYRCALL_gen_fenq= isset($rec_fenq['LEAD_GENRATION_BUYRCALL']) ? $rec_fenq['LEAD_GENRATION_BUYRCALL'] : '';
	
	$mob_app_fenq=isset($rec_fenq['LEAD_APPROVED_MOB']) ? $rec_fenq['LEAD_APPROVED_MOB'] : '';
	$app_app_fenq=isset($rec_fenq['LEAD_APPROVED_APP']) ? $rec_fenq['LEAD_APPROVED_APP'] : '';
	$email_app_fenq=isset($rec_fenq['LEAD_APPROVED_EMAIL']) ? $rec_fenq['LEAD_APPROVED_EMAIL'] : '';
	$web_app_fenq=isset($rec_fenq['LEAD_APPROVED_WEB']) ? $rec_fenq['LEAD_APPROVED_WEB'] : '';
	$leap_app_fenq=isset($rec_fenq['LEAD_APPROVED_LEAP']) ? $rec_fenq['LEAD_APPROVED_LEAP'] : '';
	$BUYRCALL_app_fenq=isset($rec_fenq['LEAD_APPROVED_BUYRCALL']) ? $rec_fenq['LEAD_APPROVED_BUYRCALL'] : '';
	
	$total_mob_gen=$mob_gen+$mob_gen_fenq;
	$total_app_gen=$app_gen+$app_gen_fenq;
	$total_email_gen=$email_gen+$email_gen_fenq;
	$totalweb_gen=$web_gen+$web_gen_fenq;
	$totalleap_gen=$leap_gen+$leap_gen_fenq;
	$totalBUYRCALL_gen=$BUYRCALL_gen+$BUYRCALL_gen_fenq;
	
	$total_mob_app=$mob_app+$mob_app_fenq;
	$total_app_app=$app_app+$app_app_fenq;
	$total_email_app=$email_app+$email_app_fenq;
	$total_web_app=$web_app+$web_app_fenq;
	$total_leap_app=$leap_app+$leap_app_fenq;
	$total_BUYRCALL_app=$BUYRCALL_app+$BUYRCALL_app_fenq;
	
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;WEB</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$totalweb_gen.' ( Direct='.$web_gen.', Fenq='.$web_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;LEAP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$totalleap_gen.' ( Direct='.$leap_gen.', Fenq='.$leap_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;BUYRCALL</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$totalBUYRCALL_gen.' ( Direct='.$BUYRCALL_gen.', Fenq='.$BUYRCALL_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;M.IM</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_mob_gen.' ( Direct='.$mob_gen.', Fenq='.$mob_gen_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;APP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_app_gen.' ( Direct='.$app_gen.', Fenq='.$app_gen_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;EMKTG</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_email_gen.' ( Direct='.$email_gen.', Fenq='.$email_gen_fenq.' )</TD>	
	</TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Platform Wise Approval</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;WEB</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_web_app.' ( Direct='.$web_app.', Fenq='.$web_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;LEAP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_leap_app.' ( Direct='.$leap_app.', Fenq='.$leap_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;BUYRCALL</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_BUYRCALL_app.' ( Direct='.$BUYRCALL_app.', Fenq='.$BUYRCALL_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;M.IM</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_mob_app.'( Direct='.$mob_app.', Fenq='.$mob_app_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;APP</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_app_app.' ( Direct='.$app_app.', Fenq='.$app_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;EMKTG</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_email_app.' ( Direct='.$email_app.', Fenq='.$email_app_fenq.' )</TD>	
	</TR>
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Response-count wise Approved Lead & Sold Leads</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
         $rec=oci_fetch_array($sth_lead_res_count,OCI_BOTH);
	
	$CNT_1=isset($rec['CNT_1']) ? $rec['CNT_1'] : '';
	$CNT_2=isset($rec['CNT_2']) ? $rec['CNT_2'] : '';
	$CNT_3=isset($rec['CNT_3']) ? $rec['CNT_3'] : '';
	$CNT_4=isset($rec['CNT_4']) ? $rec['CNT_4'] : '';
	$CNT_5=isset($rec['CNT_5']) ? $rec['CNT_5'] : '';
	$rec=oci_fetch_array($sth_lead_res_count_sold,OCI_BOTH);
	
	$SOLD_CNT_1=isset($rec['SOLD_CNT_1']) ? $rec['SOLD_CNT_1'] : '';
	$SOLD_CNT_2=isset($rec['SOLD_CNT_2']) ? $rec['SOLD_CNT_2'] : '';
	$SOLD_CNT_3=isset($rec['SOLD_CNT_3']) ? $rec['SOLD_CNT_3'] : '';
	$SOLD_CNT_4=isset($rec['SOLD_CNT_4']) ? $rec['SOLD_CNT_4'] : '';
	$SOLD_CNT_5=isset($rec['SOLD_CNT_5']) ? $rec['SOLD_CNT_5'] : '';
	
 $rec_fenq=oci_fetch_array($sth_lead_res_count_fenq,OCI_BOTH);
	
	$CNT_1_fenq=isset($rec_fenq['CNT_1']) ? $rec_fenq['CNT_1'] : '';
	$CNT_2_fenq= isset($rec_fenq['CNT_2']) ? $rec_fenq['CNT_2'] : '';
	$CNT_3_fenq=isset($rec_fenq['CNT_3']) ? $rec_fenq['CNT_3'] : '';
	$CNT_4_fenq= isset($rec_fenq['CNT_4']) ? $rec_fenq['CNT_4'] : '';
	$CNT_5_fenq= isset($rec_fenq['CNT_5']) ? $rec_fenq['CNT_5'] : '';
 $rec_fenq=oci_fetch_array($sth_lead_res_count_sold_fenq,OCI_BOTH);
	
	$SOLD_CNT_1_fenq=isset($rec_fenq['SOLD_CNT_1']) ? $rec_fenq['SOLD_CNT_1'] : '';
	$SOLD_CNT_2_fenq=isset($rec_fenq['SOLD_CNT_2']) ? $rec_fenq['SOLD_CNT_2'] : '';
	$SOLD_CNT_3_fenq=isset($rec_fenq['SOLD_CNT_3']) ? $rec_fenq['SOLD_CNT_3'] : '';
	$SOLD_CNT_4_fenq=isset($rec_fenq['SOLD_CNT_4']) ? $rec_fenq['SOLD_CNT_4'] : '';
	$SOLD_CNT_5_fenq=isset($rec_fenq['SOLD_CNT_5']) ? $rec_fenq['SOLD_CNT_5'] : '';
	
$total_cnt1=$CNT_1+$CNT_1_fenq;	
$total_cnt2=$CNT_2+$CNT_2_fenq;
$total_cnt3=$CNT_3+$CNT_3_fenq;
$total_cnt4=$CNT_4+$CNT_4_fenq;
$total_cnt5=$CNT_5+$CNT_5_fenq;

$total_sold_cnt1=$SOLD_CNT_1+$SOLD_CNT_1_fenq;
$total_sold_cnt2=$SOLD_CNT_2+$SOLD_CNT_2_fenq;
$total_sold_cnt3=$SOLD_CNT_3+$SOLD_CNT_3_fenq;
$total_sold_cnt4=$SOLD_CNT_4+$SOLD_CNT_4_fenq;
$total_sold_cnt5=$SOLD_CNT_5+$SOLD_CNT_5_fenq;
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 1 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt1.' (Direct='.$CNT_1.' , Fenq= '.$CNT_1_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 1 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt1.' (Direct='.$SOLD_CNT_1.' , Fenq= '.$SOLD_CNT_1_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 2 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt2.' (Direct='.$CNT_2.' , Fenq= '.$CNT_2_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 2 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt2.' (Direct='.$SOLD_CNT_2.' , Fenq= '.$SOLD_CNT_2_fenq.' )</TD>	
	</TR>
		
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 3 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt3.' (Direct='.$CNT_3.' , Fenq= '.$CNT_3_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 3 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt3.' (Direct='.$SOLD_CNT_3.' , Fenq= '.$SOLD_CNT_3_fenq.' )</TD></TR>
		<TR>
        <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 4 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt4.' (Direct='.$CNT_4.' , Fenq= '.$CNT_4_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 4 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt4.' (Direct='.$SOLD_CNT_4.' , Fenq= '.$SOLD_CNT_4_fenq.' )</TD>	
	</TR>
	   <TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Approved Lead with 5 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_cnt5.' (Direct='.$CNT_5.' , Fenq= '.$CNT_5_fenq.' )</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Total Unique SOLD Lead with 5 response</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$total_sold_cnt5.' (Direct='.$SOLD_CNT_5.' , Fenq= '.$SOLD_CNT_5_fenq.' )</TD>	
	</TR>';
	
	
	 $rec=oci_fetch_array($sth_new_direct_gen_app,OCI_BOTH);
	 
	 $DIRECT_LEAD_GENRATION_new=isset($rec['DIRECT_LEAD_GENRATION']) ? $rec['DIRECT_LEAD_GENRATION'] : '';
	 $DIRECT_LEAD_APPROVED_new=isset($rec['DIRECT_LEAD_APPROVED']) ? $rec['DIRECT_LEAD_APPROVED'] : '';
	 
	  $rec=oci_fetch_array($sth_new_fenq_gen,OCI_BOTH);
	  
	  $FENQ_LEAD_GENRATION_new=isset($rec['FENQ_LEAD_GENRATION']) ? $rec['FENQ_LEAD_GENRATION'] : '';
	  
	   $rec=oci_fetch_array($sth_new_fenq_app,OCI_BOTH);
	   
	   $FENQ_LEAD_APPROV_ISQ_RES_new=isset($rec['FENQ_LEAD_APPROV_ISQ_RES']) ? $rec['FENQ_LEAD_APPROV_ISQ_RES'] : '';
	   
	  echo '
	<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Leads Generated ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$FENQ_LEAD_GENRATION_new.'</TD>	
	      </TR>';
              
	      echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$DIRECT_LEAD_GENRATION_new.'</TD>	
	      </TR>'; 
	echo '<TR>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B>Approval Leads  With ISQ Response</B></TD>
		<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;<B></B></TD>	
	</TR>';
	
	echo '<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;FENQ</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$FENQ_LEAD_APPROV_ISQ_RES_new.'</TD>	
	</TR>
	<TR>
		<TD STYLE="font-family:arial;font-size:11px;padding:2 0 2 8;" ALIGN="LEFT"  >&nbsp;&nbsp;Direct</TD>
		<TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT"  >&nbsp;'.$DIRECT_LEAD_APPROVED_new.'</TD>	
	</TR>';
	
        
    }
       
}
?>
	