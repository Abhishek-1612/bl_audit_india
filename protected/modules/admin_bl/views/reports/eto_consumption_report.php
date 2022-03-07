<?php $this->pageTitle='ETO Consumption Report';?>
<script LANGUAGE="JavaScript" SRC="js/eto-buy-sale-report.js"></SCRIPT>
        <SCRIPT LANGUAGE="JavaScript">
         <!--
        
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
        
        function print_time()
        {
                // var time = document.getElementById('times').value;
                // document.getElementById('se_time').innerHTML = time;
        }
        function show_search(obj)
        {
                if(obj.value == 'DIR' || obj.value == 'ETO')
                {
                        document.getElementById('div-search').style.display = 'block';
                }
                else
                {
                        document.getElementById('div-search').style.display = 'none';
                }
        }

function trackingcheck()
        {
                if(document.getElementById('bl_tracking_rep').checked==true)
                {
                //      document.getElementById('bl_tracking_hr_rep').style.display='inline-block';
                }
                else
                {
                //      document.getElementById('bl_tracking_hr_rep').style.display='none';
                }
        }

        //-->
        </SCRIPT></head>
        <FORM name="searchForm" METHOD="post" ACTION="" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
        <TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
        <TR>
                <TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">Consumption Report (MODID Wise)</TD>
        </TR>
        </TABLE>
        <TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1">
        <TR>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;" WIDTH="100" HEIGHT="30">&nbsp;Select Period</TD>
                <TD STYLE="font-family:arial;font-size:12px;font-weight:bold;" 
                BGCOLOR="#EAEAEA">
                <TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
                <TR>

                <TD><SELECT NAME="bdate_day" SIZE="1">
            <OPTION VALUE="0">Day</OPTION>
<?php 
	$obj= new EtoConsumptionReport;
	$months=array('01' => "January",
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
	$currdate = getdate();
	$curr_day=$currdate['mday'];
	$curr_month=$currdate['mon'];
	$curr_year=$currdate['year'];
	$valYear=array($curr_year-5,$curr_year-4,$curr_year-3,$curr_year-2,$curr_year-1,$curr_year,$curr_year+1,$curr_year+2,$curr_year+3,$curr_year+4,$curr_year+5);
	$REQUEST['bdate_day']=(isset($REQUEST['bdate_day']))?$REQUEST['bdate_day']:'';
	$REQUEST['bdate_month']=(isset($REQUEST['bdate_month']))?$REQUEST['bdate_month']:'';
	$REQUEST['bdate_year']=(isset($REQUEST['bdate_year']))?$REQUEST['bdate_year']:'';
	$REQUEST['adate_day']=(isset($REQUEST['adate_day']))?$REQUEST['adate_day']:'';
	$REQUEST['adate_month']=(isset($REQUEST['adate_month']))?$REQUEST['adate_month']:'';
	$REQUEST['adate_year']=(isset($REQUEST['adate_year']))?$REQUEST['adate_year']:'';
	$modval=(isset($REQUEST['modid']))?$REQUEST['modid']:'';
	$submodval=(isset($REQUEST['submodid']))?$REQUEST['submodid']:'';

		foreach (range(1,31) as $bday)
                {
                        if($bday < 10)
                        {
                                echo "<OPTION VALUE='0$bday'";
                                if (strcmp($REQUEST['bdate_day'],"0$bday")==0)
                                {
                                        echo " SELECTED ";
                                }
                                elseif($bday == $curr_day && empty($REQUEST['bdate_day']))
                                {
                                        echo " SELECTED ";
                                }
                                echo ">0$bday</OPTION>";
                        }
                        else
                        {
                                echo "<OPTION VALUE='$bday'";
                                if ($REQUEST['bdate_day'] == $bday)
                                {
                                        echo " SELECTED ";
                                }
                                elseif($bday == $curr_day && empty($REQUEST['bdate_day']))
                                {
                                        echo " SELECTED ";
                                }
                                echo ">$bday</OPTION>";
                        }
                }
 ?>              
		</SELECT></TD>
		<TD><SELECT NAME="bdate_month" SIZE="1">
	            <OPTION VALUE="0">Month</OPTION>
<?php
		ksort($months);
		foreach ($months as $key => $val) {
                   echo "<OPTION VALUE='$key'";
                   if (!empty($REQUEST['bdate_month']) && $REQUEST['bdate_month'] == $key) {
                       echo " SELECTED ";
                   }
                elseif($key == $curr_month && empty($REQUEST['bdate_month']))
                {
                        echo " SELECTED ";
                }
                 echo ">$val</OPTION>";
                }
?>
            </SELECT></TD>
            <TD><SELECT NAME="bdate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>~;
<?php
		foreach($valYear as $vyear)
		{
			echo "<OPTION VALUE='$vyear'";
			if (!empty($REQUEST['bdate_year']) && $REQUEST['bdate_year']== $vyear) {
				echo " SELECTED ";
			}
			elseif($vyear == $curr_year && empty($REQUEST['bdate_year']))
			{
				echo " SELECTED ";
			}
			echo ">$vyear</OPTION>";

		}
?>
		</SELECT></TD>
                <TD>&nbsp;to&nbsp;</TD>

                <TD><SELECT NAME="adate_day" SIZE="1">
            <OPTION VALUE="0">Day</OPTION>
<?php
            foreach (range(1,31) as $aday)
                {
                        if($aday < 10)
                        {
                                echo "<OPTION VALUE='0$aday'";
                                if (strcmp($REQUEST['adate_day'],"0$aday")==0)
                                {
                                        echo " SELECTED ";
                                }
                                elseif($aday == $curr_day && empty($REQUEST['adate_day']))
                                {
                                        echo " SELECTED ";
                                }
                                echo ">0$aday</OPTION>";
                        }
                        else
                        {
                                echo "<OPTION VALUE='$aday'";
                                if ($REQUEST['adate_day'] == $aday)
                                {
                                        echo " SELECTED ";
                                }
                                elseif($aday == $curr_day && empty($REQUEST['adate_day']))
                                {
                                        echo " SELECTED ";
                                }
                                echo ">$aday</OPTION>";
                        }
                }
?>
		</SELECT></TD>
	            <TD><SELECT NAME="adate_month" SIZE="1">
	            <OPTION VALUE="0">Month</OPTION>
<?php
		foreach ($months as $key => $val) {
                   echo "<OPTION VALUE='$key'";
                   if (!empty($REQUEST['adate_month']) && $REQUEST['adate_month'] == $key) {
                       echo " SELECTED ";
                   }
                elseif($key == $curr_month && empty($REQUEST['adate_month']))
                {
                        echo " SELECTED ";
                }
                 echo ">$val</OPTION>";
                }
?>
		</SELECT></TD>
        	    <TD><SELECT NAME="adate_year" SIZE="1">
	            <OPTION VALUE="0">Year</OPTION>
<?php
                foreach($valYear as $vyear)
                {
                        echo "<OPTION VALUE='$vyear'";
                        if (!empty($REQUEST['adate_year']) && $REQUEST['adate_year']== $vyear) {
                                echo " SELECTED ";
                        }
                        elseif($vyear == $curr_year && empty($REQUEST['adate_year']))
                        {
                                echo " SELECTED ";
                        }
                        echo ">$vyear</OPTION>";

                }
?>
		</SELECT></TD>
                </TR>
                </TABLE></TD>
                <TD WIDTH="100" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;MODID</TD>
                <TD BGCOLOR="#EAEAEA">
                <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
                <TR>
                        <TD>
                                <SELECT NAME="modid" SIZE="1" style="width:200px;" onchange='show_search(this)'>
                                <OPTION VALUE='<?php                                if(strcmp($modval,'all')==0){
                                        echo "all' SELECTED='SELECTED'";
                                }else{
                                        echo "all'";
                                }
                                echo ">All</OPTION>
                                <OPTION VALUE='";
                                if(strcmp($modval,'bpf')==0){
                                        echo "bpf'  SELECTED='SELECTED'";
                                }else{
                                        echo "bpf'";
                                }
                                echo ">BPF</OPTION>";

//getting gmodule id
$rec=$obj->getGlModuleId($dbh);
foreach($rec as $glmodule)
{
	 echo "<OPTION VALUE='";
                        if(strcmp($modval,$glmodule['GL_MODULE_ID'])==0){
                                echo "$modval' SELECTED='SELECTED'";
                        }
			else{
                                echo $glmodule['GL_MODULE_ID']."'";
                        }
                        echo "> ".$glmodule['GL_MODULE_ID']."</OPTION>";
}
$search = '';
if(isset($REQUEST['search']))
{
	$search = $REQUEST['search'];
}
$display_option = '';
if(strcmp($modval,'DIR')==0 || strcmp($modval,'ETO')==0)
{
	$display_option = ' style="display:block;"';
}
else
{
	$display_option = ' style="display:none;"';
}
?>
 </select>
                <div id='div-search' <?php echo $display_option;?>>
                <input type='radio' name='search' id="search1" value="all"
<?php 
		if(!empty($search) || strcmp($search,'all')==0)
		{
                        print ' checked';
                }
                echo "/> All
                <input type='radio' name='search' id='search2' value='search'";
                if(strcmp($search,'search')==0)
                {
                        print " checked";
                }
?>
              /> Search
                </div>
                </TD>
                </TR>
                </TABLE>
                </TD>
		<TD WIDTH="100" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;FENQ MODID</TD>
                        <TD BGCOLOR="#EAEAEA">
                <TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
                <TR>
                        <TD>
                <SELECT NAME="submodid" id ="submodid" SIZE="1" style="width:150px;" >
		<OPTION VALUE="
<?php
		if(strcmp($submodval,'all')==0){
                	echo 'all" SELECTED="SELECTED"';
                }else{
                	echo 'all"';
                }
		echo '>All</OPTION>
                <OPTION VALUE="';
                if(strcmp($submodval,'bpf')==0){
                        echo 'bpf" SELECTED="SELECTED"';
                }else{
                        echo 'bpf"';
                }
                echo '>BPF</OPTION>';
		$obj->getGlModuleId($dbh);
		foreach($rec as $glmodule)
		{
         		echo "<OPTION VALUE='";
                        if(strcmp($submodval,$glmodule['GL_MODULE_ID'])==0){
                                echo "$submodval' SELECTED='SELECTED'";
                        }
                        else{
                                echo $glmodule['GL_MODULE_ID']."'";
                        }
                        echo "> ".$glmodule['GL_MODULE_ID']."</OPTION>";
		}
?>		</select>
		</TD>
                </TR>
                </TABLE>
                </TD>
        </TR>
        </TABLE>
        <br><br>
        <TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
        <TR>
                <TD BGCOLOR="#F4F4F4" width="60%" ALIGN="LEFT" STYLE="font-family:arial;font-size:14px;font-weight:bold;">	
<?php
	$bl_report='';
        if(!empty($REQUEST['bl_report']))
        {
        	$bl_report = $REQUEST['bl_report'];
        }
	if(strcmp($bl_report,'bl_report')==0)
	{
		echo '<input type="checkbox" name="bl_report" id="bl_report" value="bl_report" checked/><b>BUYLEAD REPORT</b>';
	}
	else
	{
		echo '<input type="checkbox" name="bl_report" id="bl_report" value="bl_report"/><b>BUYLEAD REPORT</b>';
	}
	$bl_tracking_rep = (isset($REQUEST['bl_tracking_rep']))?$REQUEST['bl_tracking_rep']:'';
	if(strcmp($bl_tracking_rep,'bl_tracking_rep')==0)
	{
		echo '<input type="checkbox" style="margin:0 5px 0 20px" name="bl_tracking_rep" id="bl_tracking_rep" onclick="trackingcheck()" value="bl_tracking_rep" checked/><b>BL Tracking Report</b>';
	}
	else
	{
		echo '<input type="checkbox" style="margin:0 5px 0 20px" name="bl_tracking_rep" id="bl_tracking_rep" onclick="trackingcheck()" value="bl_tracking_rep"/><b>BL Tracking Report</b>';
	}
	$bl_tender_rep = (isset($REQUEST['bl_tender_rep']))?$REQUEST['bl_tender_rep']:'';
	if(strcmp($bl_tender_rep,'bl_tender_rep')==0)
	{
		echo '<input type="checkbox" style="margin:0 5px 0 20px" name="bl_tender_rep" id="bl_tender_rep" value="bl_tender_rep" checked/><b>BL Tender Report</b>';
	}
	else
	{
		echo '<input type="checkbox" style="margin:0 5px 0 20px" name="bl_tender_rep" id="bl_tender_rep" value="bl_tender_rep"/><b>BL Tender Report</b>';
	}
?>
	<span id="bl_tracking_hr_rep" style="margin:0 5px 0 20px;display:none"><input type="checkbox" name="bl_track_hr_rep" id="bl_track_hr_rep" onclick="trackingcheck()" value="bl_track_hr_rep"/><b>BL Tracking Report Hourwise</b></span></td><TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
                <input type="hidden" name="action" value="get_cons_rpt">
                <INPUT TYPE="SUBMIT" NAME="Submit1" VALUE="Generate Report">
                </TD>
        </TR>
        </TABLE></FORM>
        <div id='se_time' STYLE="font-family:arial;font-size:11px;"></div>
<?php
        if(isset($REQUEST['action']) && strcmp($REQUEST['action'],'get_cons_rpt')==0){
                                        if(!empty($REQUEST['bl_report']) && strcmp($REQUEST['bl_report'],'bl_report')==0){
							BL_consumption_report($dbh,$REQUEST);
                                        }
                                        elseif(!empty($REQUEST['bl_tracking_rep']) && strcmp($REQUEST['bl_tracking_rep'],'bl_tracking_rep')==0)
					{
							trackingReport($dbh,$REQUEST,$diff_sded);
                                        }
                                        elseif(!empty($REQUEST['bl_tender_rep']) && strcmp($REQUEST['bl_tender_rep'],'bl_tender_rep')==0){
							BlTenderReport($dbh,$REQUEST);
                                        }
					else{
							showConsumptionReport($dbh,$REQUEST);
					}
                                }
function showConsumptionReport($dbh,$REQUEST)
{
	$search=(!empty($REQUEST['search']))?$REQUEST['search']:'';
	$months=array('01' => "January",
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
	$flagError=0;
	$errArr =array();
	date_default_timezone_set('Asia/Kolkata') ;
	$times =(!empty($REQUEST['times']))?$REQUEST['times']: '<strong>Start Time:</strong> '.date("j-F-Y h:i:s");
	$obj= new EtoConsumptionReport;
        $start_date=$REQUEST['bdate_day'].'-'.$REQUEST['bdate_month'].'-'.$REQUEST['bdate_year'];
        $end_date=$REQUEST['adate_day'].'-'.$REQUEST['adate_month'].'-'.$REQUEST['adate_year'];
        $modid=$REQUEST['modid'];
        $submodid=$REQUEST['submodid'];
	$arr_rec=$obj->getLeadSoldCount($start_date,$end_date,$dbh,$modid,$submodid);
	$rec=$arr_rec[0];
	$rec2=$arr_rec[1];
	$rec3=$arr_rec[2];
	$rec4=$arr_rec[3];
	
	$bg_table = "#B5EAAA";
        $bg_table_web = "#FFCCCC";
        $bg_table_mob = "#E6E6FA";
        echo '<TABLE WIDTH="100%" BORDER="1" CELLPADDING="5" CELLSPACING="1" ALIGN="CENTER" border-color="#f8f8f8" style="border-collapse:collapse" >
                <TR>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" HEIGHT="30" rowspan="2" ALIGN="CENTER"><B>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</B></TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Leads Sold</B></TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Leads Sold (UNIQUE)</B></TD>
                <td width="180" bgcolor="#CCCCFF" align="CENTER" style="font-family:arial;font-size:11px;" rowspan="2"><b>Transactions per 100 leads approved</b> </td>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Total Credits Used</B></TD>
                <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="3"><B>Web Used </B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="11"><B>Mail Used</B></TD>
                <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" colspan="3"><B>Mobile Used</B>
                </TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Unique User</B></TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Fresh User</B></TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Transactions per Active User</B></TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" rowspan="2"><B>Credits Earned Per Lead Transaction</B></TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="180" rowspan="2"><B>Leads Approved</B><br><span style="font-size:10px; font-family:arial">(Shows data only if there is some consumption on a date)</span> </TD>
                <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" width="180" rowspan="2"><B>Leads Approved ORIG_DATE</B><br><span style="font-size:10px; font-family:arial">(Shows data only if there is some consumption on a date)</span> </TD>
                
                </TR>
                <TR>
                <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>MY</B></TD>
                <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>ETO</B></TD>
                <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>HT</B></TD>
                
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>TOTAL</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>EMORNING</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>MORNING</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>EVENING</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>LEVENING</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>MORNING_NF</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>AUTOINSTANT</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>INSTANT</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>WITHINST</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>Others</B></TD>
                <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>HT Mail</B></TD>
                <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>IOS App</b></td>
                <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>Android App</b></td>
                <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><b>M.im</b></td>
                </TR>
                ';
	$rec_apps_arr=$obj->getAppsCount($start_date,$end_date,$dbh);
	$apps_cnt=0;
	$totalapps_cnt=0;
	$hash=array();
	foreach($rec_apps_arr as $rec_apps)
                        {
                            $apps_cnt=(!empty($rec_apps['CNT']))?$rec_apps['CNT']: 0;
                            $hash[$rec_apps['PUR_DATE']]=$apps_cnt;
                            $totalapps_cnt=$totalapps_cnt+$apps_cnt;
                        }
	$rec_apps1_arr=$obj->getIosCount($start_date,$end_date,$dbh);
	$ios_cnt=0;
	$totalios_cnt=0;
	$hash_iphone=array();
	foreach($rec_apps1_arr as $rec_apps1)
	{
		 $ios_cnt=(!empty($rec_apps1['CNT1']))?$rec_apps1['CNT1']: 0;
                 $hash_iphone[$rec_apps1['PUR_DATE1']]=$ios_cnt;
                 $totalios_cnt=$totalios_cnt+$ios_cnt;
	}
	$rec_autoinst_arr=$obj->getAutoInstCount($start_date,$end_date,$dbh);
	$autoinst_cnt=0;
	$totalautoinst_cnt=0;
	$hash1=array();
	foreach($rec_autoinst_arr as $rec_autoinst)
	{
		$autoinst_cnt=(!empty($rec_autoinst['CNT']))?$rec_autoinst['CNT']: 0;
		$temp=$rec_autoinst['PUR_DATE'];
                $hash1["$temp"]=$autoinst_cnt;
                $totalautoinst_cnt=$totalautoinst_cnt+$autoinst_cnt;

	}
	$totlead=0;
	$totcredit=0;
	$totunqlead=0;
	$totunquser=0;
	$totactvusr=0;
	$totactvusr1=0;
	$totwebused=0;
	$totmy=0;
	$toteto=0;
	$totht=0;
	$totmailused=0;
	$totmailemor=0;
	$totmailmor=0;
	$totmaileve=0;
	$totmailleve=0;
	$totmailmor_f=0;
	$totmaileve_f=0;
	$totmailinstant=0;
	$totmail_withinstant=0;
	$total_lead_appv=0;
	$total_lead_appv_orig=0;
	$totmailmor_nf=0;
	$totfresh = 0;
	$totearned = 0;
	$totcontact = 0;
	$totcontactcrd = 0;
	$totmobileused = 0;
	$tothtmailused = 0;
	
	$unique_lead_sold=(!empty($rec2[0]))?$rec2[0]['LEAD_SOLD_UNIQUE']:0;
	$unique_glusr =(!empty($rec2[0]))?$rec2[0]['UNIQUE_GLUSR_ID']:0;

	$appv_lead =array();
	foreach($rec3 as $rec_appv_lead)
	{
		$appv_date = $rec_appv_lead['TDATE'];
	        $appv_lead["$appv_date"] = $rec_appv_lead['TOTAL'];	
	}
	$appv_lead_orig =array();
        foreach($rec4 as $rec_appv_lead_orig) {
        	$appv_date_orig = $rec_appv_lead_orig['TDATE'];
	        $appv_lead_orig["$appv_date_orig"] = $rec_appv_lead_orig['TOTAL'];
        }
	
	foreach($rec as $rec1)
	{
		$totlead=((!empty($rec1['LEADCNT']))?$rec1['LEADCNT']:0)+$totlead ;
		$totcredit=((!empty($rec1['CREDIT']))?$rec1['CREDIT']:0)+$totcredit;
		$totunqlead=((!empty($rec1['UNIQUELEADS']))?$rec1['UNIQUELEADS']:0)+$totunqlead;
		$totunquser=((!empty($rec1['UNIQUE_USER']))?$rec1['UNIQUE_USER']:0)+$totunquser;
		$totwebused=((!empty($rec1['WEBUSED']))?$rec1['WEBUSED']:0)+$totwebused;
		$totmobileused=((!empty($rec1['MOB_COUNT']))?$rec1['MOB_COUNT']:0)+$totmobileused;
		$totmy=((!empty($rec1['MY']))? $rec1['MY']:0)+$totmy;
		$toteto=((!empty($rec1['ETO']))?$rec1['ETO']:0)+$toteto;
		$totht=((!empty($rec1['HT']))? $rec1['HT']:0)+$totht;
		$totmailused=((!empty($rec1['MAILUSED']))? $rec1['MAILUSED']:0)+$totmailused;
		$totmailemor=((!empty($rec1['MAIL_COUNT_EMOR']))? $rec1['MAIL_COUNT_EMOR']:0)+$totmailemor;
		$totmailmor=((!empty($rec1['MAIL_COUNT_MOR']))? $rec1['MAIL_COUNT_MOR']:0)+$totmailmor;
		$totmaileve=((!empty($rec1['MAIL_COUNT_EVE']))? $rec1['MAIL_COUNT_EVE']:0)+$totmaileve;
		$totmailleve=((!empty($rec1['MAIL_COUNT_LEVE']))? $rec1['MAIL_COUNT_LEVE']:0)+$totmailleve;
		$totmailmor_f=((!empty($rec1['MAIL_COUNT_MOR_F']))? $rec1['MAIL_COUNT_MOR_F']:0)+$totmailmor_f;
		$totmaileve_f=((!empty($rec1['MAIL_COUNT_EVE_F']))? $rec1['MAIL_COUNT_EVE_F']:0)+$totmaileve_f;
		$totmailmor_nf=((!empty($rec1['MAIL_COUNT_MOR_NF']))? $rec1['MAIL_COUNT_MOR_NF']:0)+$totmailmor_nf;
		$tothtmailused =((!empty( $rec1['HTD_CNT_MAIL']))? $rec1['HTD_CNT_MAIL']:0)+ $tothtmailused;
		
		$totmailinstant =((!empty( $rec1['MAIL_COUNT_INST']))? $rec1['MAIL_COUNT_INST']:0) + $totmailinstant;
		$totmail_withinstant =((!empty( $rec1['MAIL_COUNT_WITHINST']))? $rec1['MAIL_COUNT_WITHINST']:0) + $totmail_withinstant;
		
		$totcontact = ((!empty($rec1['CONTACT_COUNT']))? $rec1['CONTACT_COUNT']:0)+ $totcontact;
		$totcontactcrd =((!empty( $rec1['TOTAL_CONTACT_CRDITS']))? $rec1['TOTAL_CONTACT_CRDITS']:0)+$totcontactcrd;
		
		$fresh_user = (!empty($rec1['CNT']))? $rec1['CNT'] : 0;
		$totfresh = ($totfresh + $fresh_user)? $totfresh + $fresh_user: 0;
		$temp_credit=($rec1['CREDIT'] - $rec1['TOTAL_CONTACT_CRDITS'])/($rec1['LEADCNT'] - $rec1['CONTACT_COUNT']);
		$credit_per_lead =(!empty( $temp_credit))?$temp_credit : 0;
		$credit_per_lead=round($credit_per_lead, 2);

                $date=$rec1['ETO_PUR_DATE'];
                $lead=$rec1['LEADCNT'];
                $credit=$rec1['CREDIT'];
                $unqlead=$rec1['UNIQUELEADS'];
                $unquser=$rec1['UNIQUE_USER'];
//               $actvusr=($credit/$unquser);
                $actvusr=($lead/$unquser);
                $actvusr1=round($actvusr,2);
                $webused=$rec1['WEBUSED'];
                $my=$rec1['MY'];
                $eto=$rec1['ETO'];
                $ht=$rec1['HT'];
                $mailused=$rec1['MAILUSED'];
                $mail_emorming = $rec1['MAIL_COUNT_EMOR'];
                $mail_morming = $rec1['MAIL_COUNT_MOR'];
                $mail_evening = $rec1['MAIL_COUNT_EVE'];
                $mail_levening = $rec1['MAIL_COUNT_LEVE'];
                $mail_morming_f = $rec1['MAIL_COUNT_MOR_F'];
                $mail_evening_f = $rec1['MAIL_COUNT_EVE_F'];
                $mail_morming_nf = $rec1['MAIL_COUNT_MOR_NF'];
                $mob_used = $rec1['MOB_COUNT'];
                $ht_cnt_mail = (!empty($rec1['HTD_CNT_MAIL']))?$rec1['HTD_CNT_MAIL']: 0;

		$temp=$rec1['ETO_PUR_DATE'];
		if(isset($hash1["$temp"]))
                $autoinst_cnt=$hash1["$temp"];
                $mail_instant = $rec1['MAIL_COUNT_INST'];
                $mail_withinstant = $rec1['MAIL_COUNT_WITHINST'];
//               $other=($credit-($my+$eto+$ht+$mailused));
                $other=($lead-($my+$eto+$ht+$mailused+$mob_used));

                $mailother = ($mailused - ($mail_emorming + $mail_morming + $mail_evening + $mail_levening + $mail_morming_f + $mail_evening_f + $mail_morming_nf + $mail_instant + $mail_withinstant + $ht_cnt_mail + $autoinst_cnt));
                $cont = $rec1['CONTACT_COUNT'];
                $cont_credits = $rec1['TOTAL_CONTACT_CRDITS'];
		$lead_appv = 0;
		$lead_appv_date = (isset($appv_lead["$date"]))?$appv_lead["$date"]:0;
		if($lead_appv_date) $lead_appv = $lead_appv_date;
		$total_lead_appv=($lead_appv+$total_lead_appv)?$lead_appv+$total_lead_appv : 0;
		
		$lead_appv_orig = 0;
		$lead_appv_date_orig = (isset($appv_lead_orig["$date"]))?$appv_lead_orig["$date"]:0;
		if($lead_appv_date_orig) $lead_appv_orig = $lead_appv_date_orig;
		$total_lead_appv_orig=($lead_appv_orig+$total_lead_appv_orig)?$lead_appv_orig+$total_lead_appv_orig : 0;
		
		$trasper_100 = 0;
		if($lead_appv_orig) $trasper_100 = ($lead * 100)/$lead_appv_orig;
		$trasper_100=round($trasper_100,2);
                print '
                <TR>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$date.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$lead.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$unqlead.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$trasper_100.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$credit.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$my.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$eto.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$ht.'</TD>
                        
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mailused.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mail_emorming.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mail_morming.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mail_evening.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mail_levening.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mail_morming_nf.'</TD>';
                       
			$temp=$rec1["ETO_PUR_DATE"];
			if(isset($hash1["$temp"]))
                        {
	                        print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$hash1["$temp"].'</TD>';
                        }
                        else
                        {
                        print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">0</TD>';
                        }

                        print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mail_instant.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mail_withinstant.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mailother.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$ht_cnt_mail.'</TD>';
			$temp=$rec1['ETO_PUR_DATE'];
                        if(isset($hash_iphone["$temp"]))
                        {
                        print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$hash_iphone["$temp"].'</TD>';
                        }
                        else
                        {
                          print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">0</TD>';
                        }
			$temp=$rec1["ETO_PUR_DATE"];
                        if(isset($hash["$temp"]))
                        {
                        print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$hash["$temp"].'</TD>';

                        }
                        else
                        {
                          print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">0</TD>';
                        }
                        print '<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$mob_used.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$unquser.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$fresh_user.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$actvusr1.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$credit_per_lead.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$lead_appv.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER">'.$lead_appv_orig.'</TD>
	                </TR>
        	        ';

	}
	if($totcredit)
        {
//              $totactvusr=($totcredit/$unique_glusr);

                $totactvusr=($totlead/$unique_glusr);
                $totactvusr1=round($totactvusr,2);

                $tottrasper_100 = 0;
                if($total_lead_appv_orig) $tottrasper_100 = ($totlead * 100)/$total_lead_appv_orig;
                $tottrasper_100=round($tottrasper_100,2);

//               $totother=($totcredit-($totmy+$toteto+$totht+$totmailused));
                $totother=($totlead-($totmy+$toteto+$totht+$totmailused+$totmobileused));
                $totearned =(($totcredit-$totcontactcrd)/($totlead-$totcontact));
                $totearned=round($totearned,2);

                $totmailother = ($totmailused - ($totmailemor + $totmailmor + $totmaileve + $totmailleve + $totmailmor_f + $totmaileve_f + $totmailmor_nf + $totalautoinst_cnt + $totmailinstant + $totmail_withinstant + $tothtmailused));
                print '
                        <TR>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" HEIGHT="30" ALIGN="CENTER"><B>Total</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totlead.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$unique_lead_sold.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$tottrasper_100.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totcredit.'</B></TD>
                        <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmy.'</B></TD>
                        <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$toteto.'</B></TD>
                        <TD BGCOLOR="'.$bg_table_web.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totht.'</B></TD>
                
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmailused.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmailemor.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmailmor.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmaileve.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmailleve.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmailmor_nf.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totalautoinst_cnt.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmailinstant.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmail_withinstant.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmailother.'</B></TD>
                        <TD BGCOLOR="'.$bg_table.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$tothtmailused.'</B></TD>
                        <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totalios_cnt.'</B></TD>
                        <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totalapps_cnt.'</B></TD>
                        <TD BGCOLOR="'.$bg_table_mob.'" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totmobileused.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$unique_glusr.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totfresh.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totactvusr1.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$totearned.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$total_lead_appv.'</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"><B>'.$total_lead_appv_orig.'</B></TD>

                        </TR>
                        ';
                }
                print '</TABLE>';
        

        $times .= '<br><strong>End Time:</strong>'.date("j-F-Y h:i:s");
        print '<input type="hidden" id="times" name="times" value="'.$times.'"/>';
        print '<script>
			var time = document.getElementById("times").value;
			document.getElementById("se_time").innerHTML = time;
		</script>';


}

function BL_consumption_report($dbh,$REQUEST)
{
	$obj= new EtoConsumptionReport;
	$start_date=$REQUEST['bdate_day'].'-'.$REQUEST['bdate_month'].'-'.$REQUEST['bdate_year'];
	$end_date=$REQUEST['adate_day'].'-'.$REQUEST['adate_month'].'-'.$REQUEST['adate_year'];
	$modval=$REQUEST['modid'];
	$submodval=$REQUEST['submodid'];
	$module='';
	$module_cust_hist = '';
	$module_pur_hist = '';
	$fenq = '';
	$fenq_submod = '';
	$fenq_pur_hist = '';
	if (strcmp($modval,'all')!=0)
	{
        	$module=" AND FK_GL_MODULE_ID = '$modval' ";
                $module_cust_hist=" AND ETO_CUST_FK_GL_MODULE_ID = '$modval' ";
                $module_pur_hist=" AND ETO_LEAD_FK_GL_MODULE_ID = '$modval' ";
	}
	if(strcmp($modval,'FENQ')==0 && !empty($submodval) && (strcmp($submodval,'all')!=0))
	{
        	$fenq=",ETO_OFR_FROM_FENQ";
        	$fenq_submod= "AND ETO_OFR_FROM_FENQ.QUERY_MODID = '$submodval' AND ETO_OFR_FROM_FENQ.FK_ETO_OFR_ID = ETO_OFR_DISPLAY_ID";
	        $fenq_pur_hist= "AND ETO_OFR_FROM_FENQ.QUERY_MODID = '$submodval' AND ETO_OFR_FROM_FENQ.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID";
	}
//for leads within 1 hr of approval
	$rec_1hr_approv=$obj->getLeadOneApprov($start_date,$end_date,$dbh);
	$leads_1hr_approv_transactions = (!empty($rec_1hr_approv[0]['CNT']))?$rec_1hr_approv[0]['CNT']:0;
	$leads_1hr_approv_unique =  (!empty($rec_1hr_approv[0]['CNT_UN']))?$rec_1hr_approv[0]['CNT_UN'] : 0;
//for leads within 2 hr of approval
	$rec_2hr_approv=$obj->getLeadTwoApprov($start_date,$end_date,$dbh);
	$leads_2hr_approv_transactions = (!empty($rec_2hr_approv[0]['CNT']))?$rec_2hr_approv[0]['CNT']:0;
	$leads_2hr_approv_unique =  (!empty($rec_2hr_approv[0]['CNT_UN']))?$rec_2hr_approv[0]['CNT_UN'] : 0;
//for leads within 3 hr of approval
	$rec_3hr_approv=$obj->getLeadThreeApprov($start_date,$end_date,$dbh);
	$leads_3hr_approv_transactions = (!empty($rec_3hr_approv[0]['CNT']))?$rec_3hr_approv[0]['CNT']:0;
	$leads_3hr_approv_unique =  (!empty($rec_3hr_approv[0]['CNT_UN']))?$rec_3hr_approv[0]['CNT_UN'] : 0;
//for leads within 4 hr of approval
	$rec_4hr_approv=$obj->getLeadFourApprov($start_date,$end_date,$dbh);
	$leads_4hr_approv_transactions = (!empty($rec_4hr_approv[0]['CNT']))?$rec_4hr_approv[0]['CNT']:0;
	$leads_4hr_approv_unique =  (!empty($rec_4hr_approv[0]['CNT_UN']))?$rec_4hr_approv[0]['CNT_UN'] : 0;

	
echo '<br><div>
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

/////////query for Mcats Selected per Lead Approved////
	$rec_mcat=$obj->getmcatsLeadApprov($start_date,$end_date,$dbh);
	$lead_count=0;
	$hash_mcat=array();
	echo '<TR>
                                <td valign="top">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>

                                <TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>MCAT\'s selected/Lead approved</B></TD>                     
                                </TR>';
	 foreach($rec_mcat as $rec_mcat_approved )
                        {
                        	$lead_count = $rec_mcat_approved['OFFER_MAP'];

                        $hash_mcat[$rec_mcat_approved['OFR_MAPPING_COUNT']]= $lead_count;

				echo '
	                                <TR>                    
        	                        <TD width="73%" STYLE="font-family:arial;font-size:13px;padding:9px" ><b>Leads with '.$rec_mcat_approved["OFR_MAPPING_COUNT"].' MCAT selection</b></TD>
                                <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$hash_mcat[$rec_mcat_approved['OFR_MAPPING_COUNT']].'</TD></TR>
                                ';
                        }
                        print '</table>
                                </td>
                                </tr>';

/////////////for Email/Sms Disabled Users
	$rec_disabled=$obj->getDisableEmailSms($dbh);
	$email_disabled=(!empty($rec_disabled[0]['DISABLED_EMAIL']))?$rec_disabled[0]['DISABLED_EMAIL']:0;
	$sms_disabled=(!empty($rec_disabled[0]['DISABLED_SMS']))?$rec_disabled[0]['DISABLED_SMS']:0;
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
	
////////////for Total Email Alert enabled Users
	$rec_emailEnabled=$obj->getEmailEnable($dbh);
	$email_enabled=(!empty($rec_emailEnabled[0]['ENABLED_EMAIL']))?$rec_emailEnabled[0]['ENABLED_EMAIL']:0;
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

///////////for Active users who purchased 1-2,3-5,6-10,10+ leads
	$rec_activeusers=$obj->getActiveUserCount($start_date,$end_date,$dbh,$fenq,$module_pur_hist,$fenq_pur_hist);
	$totalactiveusers=(!empty($rec_activeusers[0]['ACTIVE_USR']))?$rec_activeusers[0]['ACTIVE_USR']:0;
	$usr_1to2_leads=(!empty($rec_activeusers[0]['USR_1_2']))?$rec_activeusers[0]['USR_1_2']:0;
	$usr_3to5_leads=(!empty($rec_activeusers[0]['USR_3_5']))?$rec_activeusers[0]['USR_3_5']:0;
	$usr_6to10_leads=(!empty($rec_activeusers[0]['USR_6_10']))?$rec_activeusers[0]['USR_6_10']:0;
	$usr_10plus_leads=(!empty($rec_activeusers[0]['USR_10']))?$rec_activeusers[0]['USR_10']:0;
	
	echo '       <TR>
                <td valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>

                                <TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>ACTIVE USERS PURCHASED ATLEAST ONE LEAD</B></TD>                   
                                </TR>
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

////////////for finding the customers who never used credits(free paid and complimentary)
	$rec_neverused=$obj->getNeverUsedCredit($end_date,$dbh);
	$count=0;
	echo '       <TR>
                <td valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>

                                <TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>NEVER USED</B></TD>                        
                                </TR>';
	foreach($rec_neverused as $recneverused)
                        {
                                $bifurcation = $recneverused['BIFERCATION'];
                                $cnt = (!empty($recneverused['CNT']))?$recneverused['CNT']:0;
                                echo '<TR>                   
                                      <TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>'.$bifurcation.'</b></TD>
                                      <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >'.$cnt.'</TD></TR>
                                      ';
                                $count++;
                        }
	if(!$count)
                {
                                echo '<TR>                   
                                <TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>COMPLIMENTRY</b></TD>
                                <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >0</TD></TR>
                                <TR>                    
                                <TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>PAID</b></TD>
                                <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >0</TD></TR>
                                <TR>                    
                                <TD width="73%"  STYLE="font-family:arial;font-size:13px;padding:9px" ><b>FREE</b></TD>
                                <TD STYLE="font-family:arial;font-size:11px;" ALIGN="LEFT" >0</TD></TR>
                                ';
                }

	echo '</table></td></tr>';

////////////for expired unsold leads
	$rec_expired=$obj->getExpiredLeadCount($start_date,$end_date,$dbh,$fenq,$module,$fenq_submod);
	$total_expired=(!empty($rec_expired[0]['TOTAL_EXPIRED']))?$rec_expired[0]['TOTAL_EXPIRED']:0;
	$total_unsold=(!empty($rec_expired[0]['UNSOLD']))?$rec_expired[0]['UNSOLD']:0;
	$no_supplier=(!empty($rec_expired[0]['NO_SUPPLIER']))?$rec_expired[0]['NO_SUPPLIER']:0;
	
	echo '<TR>
                <td valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>

                                <TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>EXPIRED UNSOLD</B></TD>            </TR>
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

////////////for total users whose credits lapse
	$rec_credit=$obj->getCreditLapseCount($start_date,$end_date,$dbh,$fenq, $module_pur_hist,$fenq_pur_hist);
	$totalusers=(!empty($rec_credit[0]['TOTAL_USERS_CREDIT_LAPSED']))?$rec_credit[0]['TOTAL_USERS_CREDIT_LAPSED']:0;

////////////for total users whose lapsed credits were <30
	$rec_credit30=$obj->getCreditLapse30Count($start_date,$end_date,$dbh,$fenq, $module_pur_hist,$fenq_pur_hist);
	$totalusers30=(!empty($rec_credit30[0]['TOTAL_USERS30']))?$rec_credit30[0]['TOTAL_USERS30']:0;
	
	echo '<TR>
                <td valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>

                                <TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>No-Usage Credits Lapsed</B></TD>   </TR>
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
////////////for total users visited alerts section of MY
	$rec_totalusers=$obj->getVisitedMYCount($start_date,$end_date,$dbh);
	$totalusers_my=(!empty($rec_totalusers[0]['TOTAL_USERS']))?$rec_totalusers[0]['TOTAL_USERS']:0;
	
////////////for users with >0 Available credits
	$rec_usrcredits=$obj->getAvailableCreditCount($start_date,$end_date,$dbh);
	$usrcredits=(!empty( $rec_usrcredits[0]['USER_CREDITS']))? $rec_usrcredits[0]['USER_CREDITS']:0;

////////////for users who purchased atleast one lead
	$rec_1lead=$obj->getAtleastOneLeadCount($start_date,$end_date,$dbh);
	$users_1lead=(!empty($rec_1lead[0]['ACTIVE_USERS']))?$rec_1lead[0]['ACTIVE_USERS']:0;

////////////for users who did not purchase any lead on MY
	$rec_nopurchase=$obj->getNoLeadMYCount($start_date,$end_date,$dbh);
	$nopurchase=(!empty($rec_nopurchase[0]['NOT_PURCHASED']))?$rec_nopurchase[0]['NOT_PURCHASED']:0;

////////////for Marked any Lead as N/I(Rejected Leads)
	$rec_notinterested=$obj->getRejectedLeadCount($start_date,$end_date,$dbh);
	$rejected=(!empty($rec_notinterested[0]['REJECTED_LEADS']))?$rec_notinterested[0]['REJECTED_LEADS']:0;

////////////for Marked Lead as N/I and not pur.any lead
	$rec_rej_notpur=$obj->getRejectedNotPurCount($start_date,$end_date,$dbh);
	$rej_notpur=(!empty($rec_rej_notpur[0]['REJ_NOTPUR']))?$rec_rej_notpur[0]['REJ_NOTPUR']:0;
	
	echo '<TR>
                <td valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>

                                <TD colspan="2" BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:13px;color:#0303bd;" ALIGN="LEFT" height="30" >&nbsp;<B>ACTIVE USERS:ONLINE ACTIVITY</B></TD>      </TR>
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
		</table>
	</div>';

}
function trackingReport($dbh,$REQUEST,$diff_sded)
{
	$obj= new EtoConsumptionReport;
	$start_date=$REQUEST['bdate_day'].'-'.$REQUEST['bdate_month'].'-'.$REQUEST['bdate_year'];
        $end_date=$REQUEST['adate_day'].'-'.$REQUEST['adate_month'].'-'.$REQUEST['adate_year'];
	echo '<div style="margin:0px auto;text-align:center;"><br><div style="font-weight:bold;">Tracking Report</div><br><table border="1" cellpadding="5" cellspacing="1" align="center" style="border-collapse:collapse"><tr bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER">
        <td>Date</td>
        <td>No. of Unique Visitors</td>
        <td>No. of leads viewed</td>
        </tr>';
	$datemin='';
	if($diff_sded==0)
        {
		$rec=$obj->getViewTracking($start_date,$end_date,$dbh,$datemin);
		foreach($rec as $result)
                {
                	echo '	<tr>
                		<td>'.$result['SDT'].'</td>
		                <td>'.$result['UNIGLUSR'].'</td>
		                <td>'.$result['UNQIOFID'].'</td>
                		</tr>';
                }

	$datemin='-1';
	}
	$rec1=$obj->getViewTracking($start_date,$end_date,$dbh,$datemin);
	foreach($rec1 as $result)
                {
                        echo '  <tr>
                                <td>'.$result['SDT'].'</td>
                                <td>'.$result['UNIGLUSR'].'</td>
                                <td>'.$result['UNQIOFID'].'</td>
                                </tr>';
                }

	
}
function BlTenderReport($dbh,$REQUEST)
{
        $obj= new EtoConsumptionReport;
	$start_date=$REQUEST['bdate_day'].'-'.$REQUEST['bdate_month'].'-'.$REQUEST['bdate_year'];
        $end_date=$REQUEST['adate_day'].'-'.$REQUEST['adate_month'].'-'.$REQUEST['adate_year'];
	$currdate = getdate();
        $cdate=$currdate['mday'].'-'.$currdate['mon'].'-'.$currdate['year'];
	echo '
		<div style="margin:0px auto;text-align:center;"><br><div style="font-weight:bold;">Tenders Report</div><br>

<table width="70%" border="1" cellpadding="5" cellspacing="1" align="CENTER" border-color="#f8f8f8" style="border-collapse:collapse">
<tr>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" height="30" rowspan="2" align="CENTER"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>All</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>MY Tenders</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>Tender.IM</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER" colspan="3"><b>Tender Email Alerts</b></td></tr>

<tr>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Total Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique Sold</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>Unique User</b></td>

</tr>
	';
	$tdrtoal=array(0,0,0,0,0,0,0,0,0,0,0,0);
	$rec=$obj->getSoldCount($start_date,$end_date,$dbh);
	
 	foreach($rec as $result)
        {
           echo '
                <tr>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["SDT"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["TOT_SOLD"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNI_SOLD"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNIGLUSR_SOLD"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["SOLD_MY"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNISOLD_MY"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNIGLUSR_MY"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["SOLD_TDR"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNISOLD_TDR"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNIGLUSR_TDR"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["SOLD_EMKTG"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNISOLD_EMKTG"].'</td>
                <td style="font-family:arial;font-size:11px;" align="CENTER">'.$result["UNIGLUSR_EMKTG"].'</td>
                
                </tr>
                ';
                $tdrtoal[0]+=$result["SOLD_MY"];
                $tdrtoal[1]+=$result["UNISOLD_MY"];
                $tdrtoal[2]+=$result["UNIGLUSR_MY"];
                $tdrtoal[3]+=$result["SOLD_TDR"];
                $tdrtoal[4]+=$result["UNISOLD_TDR"];
                $tdrtoal[5]+=$result["UNIGLUSR_TDR"];
                $tdrtoal[6]+=$result["TOT_SOLD"];
                $tdrtoal[7]+=$result["UNI_SOLD"];
                $tdrtoal[8]+=$result["UNIGLUSR_SOLD"];
                $tdrtoal[9]+=$result["SOLD_EMKTG"];
                $tdrtoal[10]+=$result["UNISOLD_EMKTG"];
                $tdrtoal[11]+=$result["UNIGLUSR_EMKTG"];
        }
 print '<tr>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" height="30" align="CENTER"><b>Total</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[6].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[7].'</b></td>
<td bgcolor="#B5EAAA" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[8].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[0].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[1].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[2].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[3].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[4].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[5].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[9].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[10].'</b></td>
<td bgcolor="#CCCCFF" style="font-family:arial;font-size:11px;" align="CENTER"><b>'.$tdrtoal[11].'</b></td>

</tr></div>';


	
}
?>
</div>
</body>
</html>
