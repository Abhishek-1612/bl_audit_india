<?php
class Eto_location_pref extends CFormModel
{
public function showLocationPrefrencesForm($dbh,$emp_id)
{
       $err=new Mail_oracle_error;	
	if(isset($_REQUEST['action_choice']))
	{
	$action_choice=$_REQUEST['action_choice'];
	}
	else
	{
	$action_choice ='ALL';
	}
	if(isset($_REQUEST['useDate']))
	{
	$useDate=$_REQUEST['useDate'];
	}
	else{
	$useDate ='ALL';
        }
	$fields=array();
	if (isset($_REQUEST['Submit']) && $_REQUEST['Submit'] == 'Manager Report')
	{
		$fields = array('adate_day','adate_month','adate_year','bdate_day','bdate_month','bdate_year','modid','client','email_box','glusr_box','manager_box');
	}
	else
	{
		$fields = array('adate_day','adate_month','adate_year','bdate_day','bdate_month','bdate_year','modid','client','email_box','glusr_box');
	}
	$param=array();
	foreach ($fields as $x) 
	{
     		if (isset($_REQUEST[$x])) 
		{
        		$param[$x]=$_REQUEST[$x];
     		} 
		else 
		{
        		$param[$x]='';
     		}
  	}

	list($curr_sec,$curr_min,$curr_hour,$curr_day,$curr_month,$curr_year) = localtime(time());
	$curr_month=$curr_month+1;
	if($curr_month < 10)
	{
		$curr_month='0'.$curr_month;
	}
	$curr_year=$curr_year+1900;

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

	

	echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>
	<SCRIPT LANGUAGE="JavaScript">
         <!--
        function checkGlusrWiseForm()
	{
	
		if(!document.f2.email_box.value && !document.f2.glusr_box.value )
		{
			alert("Please Enter GLusr ID or Email ID");
			return false;
		}
	}

	function checkmanegerForm()
	{
		if(document.getElementById("manager_box").value == "")
		{
			alert("Please Enter Manager ID");
			return false;
		}
	}

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
	//-->
	</SCRIPT>
	</HEAD><BODY>';
echo '<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" HEIGHT="30">
	<TR>
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">Location Preferences Report</TD>
	</TR>
	</TABLE>';
echo '<DIV STYLE="width:980px; padding:1px; border:solid 1px #c7c7c7; margin:0 auto;" align="center">
   <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
       <td width="50%" style="border:solid 1px #ccc;">';
	echo '
	<FORM name="searchForm" METHOD="post" ACTION="index.php?r=admin_bl/Eto_location_pref/Index&empid='.$emp_id.'&mid=3437" STYLE="margin-top:0;margin-bottom:0;" ONSUBMIT="return checkBuyForm();">
	
	<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1" STYLE="font-family: arial;">
	<TR>
		<TD COLSPAN="3" BGCOLOR="#f2f2f2" ALIGN="center"><B STYLE="font-size:13px;width:410px;">Date Wise</B></TD>
	</TR>
	<TR>
		<TD COLSPAN="3" STYLE="font-family:arial;font-size:12px;font-weight:bold;" 
		BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="3" CELLSPACING="0">
		<TR>

		<TD><SELECT NAME="bdate_day" SIZE="1">
            <OPTION VALUE="0">Day</OPTION>';

		foreach (range(1,31) as $x) 
		{
			if($x < 10)
			{
				echo '<OPTION VALUE="0'.$x.'"';
				if ($param['bdate_day'] == "0".$x) 
				{
					echo 'SELECTED';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo 'SELECTED ';
				}
				echo '>0'.$x.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$x.'"';
				if ($param['bdate_day'] == $x) 
				{
					echo 'SELECTED ';
				}
				elseif($x == $curr_day && !$param['bdate_day'])
				{
					echo  'SELECTED ';
				}
				echo '>'.$x.'</OPTION">';
			}  
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';

            
                $months2=array_keys($months);
		foreach ($months2 as $x) 
		{
                   echo '<OPTION VALUE="'.$x.'"';
                   if (isset($param['bdate_month']) && $param['bdate_month'] == $x)
                   {
                       echo ' SELECTED ';
                   }
		elseif($x == $curr_month && !$param['bdate_month'])
		{
			echo 'SELECTED ';
		}
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="bdate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';

		foreach (range(2010,2017) as $x) 
		{
                   echo '<OPTION VALUE="'.$x.'"';
                   if (isset($param['bdate_year']) && $param['bdate_year'] == $x) 
                   {
                       echo 'SELECTED ';
                   }
		elseif($x == $curr_year && !$param['bdate_year'])
		{
			echo ' SELECTED ';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
		echo '</SELECT></TD>


		<TD>&nbsp;to&nbsp;</TD>

		<TD><SELECT NAME="adate_day" SIZE="1">
            <OPTION VALUE="0">Day</OPTION>';

		foreach (range(1,31) as $x) 
		{
			if($x < 10)
			{
				echo '<OPTION VALUE="0'.$x.'"';
				if ($param['adate_day'] == "0".$x) 
				{
					echo 'SELECTED ';
				}
				elseif($x == $curr_day && !$param['adate_day'])
				{
					echo 'SELECTED ';
				}
				echo '>0'.$x.'</OPTION">';
			}
			else
			{
				echo '<OPTION VALUE="'.$x.'"';
				if ($param['adate_day'] == $x) 
				{
					echo 'SELECTED ';
				}
				elseif($x == $curr_day && !$param['adate_day'])
				{
					echo 'SELECTED ';
				}
				echo '>'.$x.'</OPTION">';
			}  
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_month" SIZE="1">
            <OPTION VALUE="0">Month</OPTION>';
                 
                 
                 $months2=array_keys($months);
		foreach ($months2 as $x) 
		{
                   echo '<OPTION VALUE="'.$x.'"';
                   if (isset($param['adate_month']) && $param['adate_month'] == $x) 
                   {
                       echo 'SELECTED ';
                   }
		elseif($x == $curr_month && !$param['adate_month'])
		{
			echo 'SELECTED ';
		}
                   echo '>'.$months[$x].'</OPTION">
                   ';
                }

		echo '</SELECT></TD>
            <TD><SELECT NAME="adate_year" SIZE="1">
            <OPTION VALUE="0">Year</OPTION>';

		foreach (range(2010,2017) as $x)
		{
                  echo '<OPTION VALUE="'.$x.'"';
                   if (isset($param['adate_year']) && $param['adate_year'] == $x) 
                   {
                       echo 'SELECTED ';
                   }
		elseif($x == $curr_year && !$param['adate_year'])
		{
			echo ' SELECTED ';
		}
                   echo '>'.$x.'</OPTION">
                   ';
                }
                
		echo '</SELECT></TD>
		</TR>
		</TABLE></TD></tr><tr>
		<TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;SOURCE</TD>
		<TD BGCOLOR="#EAEAEA">
		<TABLE BORDER="0" CELLPADDING="1" CELLSPACING="0">
		<TR>
			<TD>
				<SELECT NAME="action_choice" SIZE="1" style="width:130px;">
<OPTION VALUE="';
				if($action_choice == 'ALL')
				{
					echo 'ALL" SELECTED="SELECTED"';
				}
				else
				{
					echo 'ALL"';
				}
				echo '>ALL</OPTION>				
<OPTION VALUE="';
				if($action_choice == 'MY')
				{
					echo 'MY" SELECTED="SELECTED"';
				}
				else
				{
					echo 'MY"';
				}
				echo '>MY</OPTION>
				<OPTION VALUE="';
				if($action_choice == 'GLADMIN')
				{
					echo 'GLADMIN" SELECTED="SELECTED"';
				}
				else
				{
					echo 'GLADMIN"';
				}
				echo '>GLADMIN</OPTION>
<OPTION VALUE="';
				if($action_choice == 'CONSUMPTION')
				{
					echo 'CONSUMPTION" SELECTED="SELECTED"';
				}
				else
				{
					echo 'CONSUMPTION"';
				}
				echo '>CONSUMPTION</OPTION>
<OPTION VALUE="';
				if($action_choice == 'SAMPARK')
				{
					echo 'SAMPARK" SELECTED="SELECTED"';
				}
				else
				{
					echo 'SAMPARK"';
				}
				echo '>SAMPARK</OPTION>
					</SELECT>';
				
			echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD>
			<TD bgcolor="#CCCCFF" style="font-family:arial;font-size:12px;font-weight:bold;">&nbsp;Sort By</TD>
			<TD>
				<SELECT name="useDate">			
<OPTION VALUE="';
				if($useDate == 'ALL')
				{
					echo 'ALL" SELECTED="SELECTED"';
				}
				else
				{
					echo 'ALL"';
				}
				echo '>ALL</OPTION>				
<OPTION VALUE="';
				if($useDate == 'FS')
				{
					echo 'FS" SELECTED="SELECTED"';
				}
				else
				{
					echo 'FS"';
				}
				echo '>First Set</OPTION>
				<OPTION VALUE="';
				if($useDate == 'LS')
				{
					echo 'LS" SELECTED="SELECTED"';
				}
				else
				{
					echo 'LS"';
				}
				echo '>Last Updated</OPTION>
				</SELECT>
			</TD>

		</TR>
		</TABLE>
		</TD>
	
		<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
		<input type="hidden" name="action" value="get_locpref_rpt">
		<INPUT TYPE="SUBMIT" NAME="Submit1" style="display:none;" VALUE="Generate Report">
		</TD>

	</TR>
	
	<TR><TD  BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:12px;font-weight:bold;">MANAGER-ID</TD>
	<TD BGCOLOR="#f2f2f2"><INPUT NAME="manager_box" id="manager_box" TYPE="text" value="';if(isset($param['manager_box']))
	{
	echo $param['manager_box'];
	}
	echo '" style="width:130px;"> </TD>
	
	<TD BGCOLOR="#F4F4F4" ALIGN="CENTER" STYLE="font-family:arial;font-size:14px;font-weight:bold;">
	
	<input type="hidden" name="action" value="get_locpref_rpt1">

	<INPUT TYPE="SUBMIT" NAME="Submit" style="display:none;" ONCLICK="return checkmanegerForm()" VALUE="Manager Report">
	</TD></TR>

	</TABLE>
	</FORM>';
echo '</td>
<td style="border:solid 1px #ccc;" width="50%" valign="top">
<FORM ACTION="index.php?r=admin_bl/Eto_location_pref/Index&empid='.$emp_id.'&mid=3437" METHOD="post" NAME="f2" ONSUBMIT="return checkGlusrWiseForm();">

    <TABLE WIDTH="100%" BORDER="0" cellspacing="01" cellpadding="1"  STYLE="font-family:arial;font-size:13px; font-weight:bold;">
      <TR>

        <TD COLSPAN="4" BGCOLOR="#f2f2f2" ALIGN="center"><B STYLE="font-size:13px;width:410px;">GLUser Wise</B></TD>
	
      </TR>
	<TR><TD BGCOLOR="#f2f2f2" COLSPAN="2" align="left">GLUser ID</TD><TD BGCOLOR="#f2f2f2" COLSPAN="2" align="left">Email ID</TD></TR>
      <TR>
         <TD BGCOLOR="#f2f2f2"><INPUT NAME="glusr_box" id="glusr_box" TYPE="text" value="'.$param['glusr_box'].'" style="width:130px;"> </TD>
	<TD BGCOLOR="#f2f2f2"> or </TD>
	<TD BGCOLOR="#f2f2f2"><INPUT NAME="email_box" id="email_box" TYPE="text" value="'.$param['email_box'].'" style="width:160px;"> </TD>
        <TD BGCOLOR="#f2f2f2">
	<input type="hidden" name="action" value="glusr_wise_locpref_rpt">
	<input type="submit" value="Generate Report" name="glusr_wise_locpref_rpt">
        </TD>
      </TR></TABLE></FORM>
	</td>
</TR>
    </TABLE></DIV>';

 if(!isset($_REQUEST['action']))
 {
 echo '</BODY></HTML>';
 }
}
public function showLocationPrefrencesReport_Glusr_Wise($dbh,$emp_id)
{
        $obj = new Globalconnection();	
        $model = new GlobalmodelForm();	
     
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))	
        {	
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   	
        }else{	
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 	
        }
		
	$this->showLocationPrefrencesForm('',$emp_id);
	if(isset($_REQUEST['email_box']))
	{
	$glusr_email = $_REQUEST['email_box'];
	}
	else
	{
	$glusr_email='';
	}
	if(isset($_REQUEST['glusr_box']))
	{
	$usrid = $_REQUEST['glusr_box'];
	}
	else
	{
	$usrid='';
	}
	if(isset($_REQUEST['redirect']))
	{
	$usrid = $_REQUEST['glid'] ;
	}
	$glusr_setdate='';
	$glusr_updatedate='';
	$main_condtion='';
	$condition='';
	$flag=0;
	$glusr_id=0;

	$glusr_name='';
	$bl_purchase_count=0;
	$custtype='';
	$glusr_company='';
	$glusr_city='';
	$glusr_country='';
	$glusr_phone='';
	$glusr_mobile='';
	$glusr_value='';
	$glusr_loc_updated_by='';
	$history_url='';
	if(!preg_match('/^\d+$/',$usrid,$match))
	{
	$usrid='';
	}
	if($usrid || $glusr_email)
	{
		if($usrid)
		{
		$main_condtion = " GLUSR_USR_ID ='$usrid'";
		}
		elseif($glusr_email)
		{
		$main_condtion = " GLUSR_USR_EMAIL = '$glusr_email'";
		}
	

	 $sql = "SELECT A.*,(SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST WHERE FK_GLUSR_USR_ID = GLUSR_USR_ID AND FK_ETO_OFR_ID > -1) TOTAL_CNT,
	(
	(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID 
        AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR.FK_GL_COUNTRY_ISO = 'IN' AND FK_ETO_OFR_ID > -1)),0) )
	+
	(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR_EXPIRED WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID 
        AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO = 'IN' AND FK_ETO_OFR_ID > -1)),0) )
	)TOTAL_IN
	,
	(
	(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID 
        AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN' AND FK_ETO_OFR_ID > -1)),0) )
	+
	(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR_EXPIRED WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID 
        AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN' AND FK_ETO_OFR_ID > -1)),0) )
	)TOTAL_FN
	,	
	(
	(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR,GLUSR_USR S_CITY_TAB WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = A.GLUSR_USR_ID AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR.FK_GLUSR_USR_ID = S_CITY_TAB.GLUSR_USR_ID AND A.FK_GL_CITY_ID = S_CITY_TAB.FK_GL_CITY_ID AND ETO_OFR.FK_GL_COUNTRY_ISO = 'IN' AND FK_ETO_OFR_ID > -1)),0) )
	+
	(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR_EXPIRED,GLUSR_USR S_CITY_TAB WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = A.GLUSR_USR_ID AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID = S_CITY_TAB.GLUSR_USR_ID AND A.FK_GL_CITY_ID = S_CITY_TAB.FK_GL_CITY_ID AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO = 'IN' AND FK_ETO_OFR_ID > -1)),0) )
	)TOTAL_LOCAL 	
	FROM
	(SELECT GLUSR_USR_ID,
	(GLUSR_USR_SALUTE || ' ' || GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME, 
	GLUSR_USR_CUSTTYPE_NAME,
	GLUSR_USR_COMPANYNAME GLUSR_COMPANY,
	GLUSR_USR_CITY GLUSR_CITY,
	GLUSR_USR_COUNTRYNAME,
	'+(' || GLUSR_USR_PH_COUNTRY || ') - ' || GLUSR_USR_PH_AREA || '-' || GLUSR_USR_PH_NUMBER as GLUSR_PHONE,
	'+('|| GLUSR_USR_PH_COUNTRY || ')-' || GLUSR_USR_PH_MOBILE AS GLUSR_MOBILE,
	GLUSR_USR_LOC_PREF_SET_DATE SET_DATE,
	GLUSR_USR_LOC_PREF_UPDATE_DATE UPDATE_DATE,
	(case when GLUSR_USR_LOC_PREF=1 then 'Global' when GLUSR_USR_LOC_PREF=2 then 'India Only'  
        when GLUSR_USR_LOC_PREF=3 then 'Foreign Only' when GLUSR_USR_LOC_PREF=4 then 'Local Only' end) VAL_1, 
        GLUSR_USR_LOC_PREF_SET_BY LOC_UPDATED_BY,
	FK_GL_COUNTRY_ISO,
	FK_GL_CITY_ID,
	GLUSR_BIZ_TYPE,
        (CASE WHEN glusr_usr_deduced_loc_pref1=1 then 'Global' 
        WHEN glusr_usr_deduced_loc_pref1=2 then 'India only'
        WHEN glusr_usr_deduced_loc_pref1=3 then 'Foreign only' 
        when glusr_usr_deduced_loc_pref1=4 then 'Local only' 
        when glusr_usr_deduced_loc_pref1=5 then 'Hyperlocal (City+50km)' end) loc_pref1, 
        (CASE WHEN glusr_usr_deduced_loc_pref2=1 then 'Global' 
        WHEN glusr_usr_deduced_loc_pref2=2 then 'India only'
        WHEN glusr_usr_deduced_loc_pref2=3 then 'Foreign only' 
        when glusr_usr_deduced_loc_pref2=4 then 'Local only' 
        when glusr_usr_deduced_loc_pref2=5 then 'Hyperlocal (City+50km)' end) loc_pref2 
	FROM
		GLUSR_USR join 
        GLUSR_BIZ on GLUSR_USR.FK_GLUSR_USR_PBIZ_ID=GLUSR_BIZ.GLUSR_BIZ_ID 
        left outer join GLUSR_USR_LOC_PREF on GLUSR_USR.GLUSR_USR_ID =GLUSR_USR_LOC_PREF.FK_GLUSR_USR_ID 
        WHERE 
	$main_condtion
	)A";
	//echo $sql;
	 	echo '<br><br>
			<TABLE  BORDER="1" CELLPADDING="3" style="border-collapse:collapse" border-color="#f2f2f2" CELLSPACING="1" ALIGN="CENTER">
			<TR>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"   height="35">&nbsp;<B>GLusr ID</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Company</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Person Name</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Cust Type</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" ><B>&nbsp;Nature of Business</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;City</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Mobile</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" ><B>&nbsp;Current Location Pref.</B></TD>
                         <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" ><B>&nbsp;Dynamic Location Preference (2 months)</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" ><B>&nbsp;Dynamic Location Preference (1 year)</B></TD>			
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Total Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;India Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;India Purchase %</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Foreign Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Foreign Purchase %</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Local Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Rest IN Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;First Set On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Updated On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Updated By</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Previous Value</B></TD>
			
			
			</TR>';
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());// echo"<pre>";echo $sql1; echo"</pre>";        
		 while($record = $sth->read()) {
                        $rec=array_change_key_case($record, CASE_UPPER);                    
			
   			 if(isset($rec['GLUSR_USR_ID']))
   			 {
   			 $glusr_id = $rec['GLUSR_USR_ID'];
   			 }
   			 else
   			 {
   			 $glusr_id='';
   			 }
   			 if(isset($rec['GLUSR_NAME']))
   			 {
			 $glusr_name = $rec['GLUSR_NAME'];
			 }
			 else
			 {
			 $glusr_name='';
			 }
                         
			$bl_purchase_count=0;
                                               
			 if(isset($rec['GLUSR_USR_CUSTTYPE_NAME']))
			 {
			 $custtype = $rec['GLUSR_USR_CUSTTYPE_NAME'];
			 }
			 else
			 {
			 $custtype='';
			 }
			 if(isset($rec['GLUSR_COMPANY']))
			 {
			 $glusr_company = $rec['GLUSR_COMPANY'];
			 }
			 else
			 {
			 $glusr_company='';
			 }
			 if(isset($rec['GLUSR_CITY']))
			 {
			 $glusr_city = $rec['GLUSR_CITY'];
			 }
			 else
			 {
			 $glusr_city='';
			 }
			 if(isset($rec['GLUSR_USR_COUNTRYNAME']))
			 {
			 $glusr_country = $rec['GLUSR_USR_COUNTRYNAME'];
			 }
			 else
			 {
			 $glusr_country='';
			 }
			 if(isset($rec['GLUSR_PHONE']))
			 {
			 $glusr_phone = $rec['GLUSR_PHONE'];
			 }
			 else
			 {
			 $glusr_phone='';
			 }
			 if(isset($rec['GLUSR_MOBILE']))
			 {
			 $glusr_mobile = $rec['GLUSR_MOBILE'];
			 }
			 else
			 {
			 $glusr_mobile='';
			 }
			 if(isset($rec['SET_DATE']))
			 {
			 $glusr_setdate = $rec['SET_DATE'];
			 }
			 else
			 {
			 $glusr_setdate='';
			 }
			 if(isset($rec['UPDATE_DATE']))
			 {
			 $glusr_updatedate = $rec['UPDATE_DATE'];
			 }
			 else
			 {
			 $glusr_updatedate='';
			 }
			 if(isset($rec['VAL_1']))
			 {
			 $glusr_value = $rec['VAL_1'];
			 }
			 else
			 {
			 $glusr_value='';
			 }
			 if(isset($rec['LOC_UPDATED_BY']))
			 {
			 $glusr_loc_updated_by = $rec['LOC_UPDATED_BY'];
			 }
			 else
			 {
			 $glusr_loc_updated_by='';
			 }
			 if(isset($rec['TOTAL_CNT']))
			 {
			 $glusr_total_pur = $rec['TOTAL_CNT'];
			 }
			 else
			 {
			 $glusr_total_pur=0;
			 }
			 if(isset($rec['TOTAL_IN']))
			 {
			 $glusr_in_pur = $rec['TOTAL_IN'];
			 }
			 else
			 {
			 $glusr_in_pur=0;
			 }
			 $glusr_in_pur_per = 0;
			 if(isset($rec['TOTAL_FN']))
			 {
			 $glusr_frgn_pur = $rec['TOTAL_FN'];
			 }
			 else
			 {
			 $glusr_frgn_pur=0;
			 }
			 $glusr_frgn_pur_per = 0;
			 if(isset($rec['TOTAL_LOCAL']))
			 {
			 $glusr_local_pur = $rec['TOTAL_LOCAL'];
			 }
			 else
			 {
			 $glusr_local_pur=0;
			 }
			 $glusr_restin_pur = $glusr_in_pur - $glusr_local_pur;
			 $history_url = '';
			if($glusr_total_pur)
			{
				$glusr_in_pur_per = ($glusr_in_pur / $glusr_total_pur) * 100;
				$glusr_frgn_pur_per = ($glusr_frgn_pur / $glusr_total_pur) * 100;
				$glusr_in_pur_per = floor( $glusr_in_pur_per + 0.5 );
				$glusr_frgn_pur_per = floor( $glusr_frgn_pur_per + 0.5 );
			}
			$flag = 1;
			 if($glusr_id)
			 {
			  $history_url = '<a href="http://gladmin.intermesh.net/index.php?r=admin_glusr/GlusrHistory/GlusrHistory&id='.$glusr_id.'&mid=46" target="_blank">Glusr History</a>';
                         }
			if($glusr_loc_updated_by && $glusr_loc_updated_by == '-1')
			{
				$glusr_loc_updated_by = 'User';
			}
			else
			{
				$glusr_loc_updated_by = $glusr_loc_updated_by;
			}
			
			if(isset($rec['GLUSR_BIZ_TYPE']) && $rec['GLUSR_BIZ_TYPE']!=NULL)
			{
			$glusr_biz = $rec['GLUSR_BIZ_TYPE'];
			}
			else{
			$glusr_biz='';
			}
                        if(isset($rec['LOC_PREF1']))
                        {$loc_pref1 = $rec['LOC_PREF1'];} 
                        else
                        {$loc_pref1 = '';}

                         if(isset($rec['LOC_PREF2']))
                        {$loc_pref2 = $rec['LOC_PREF2'];} 
                        else
                        {$loc_pref2 = '';}
            
            
		echo 	'
	<TR>
		       <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_id.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_company.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_name.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$custtype.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_biz.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_city.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_mobile.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_value.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$loc_pref1.'</TD>
                        <TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$loc_pref2.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_total_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_in_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_in_pur_per.'%</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_frgn_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_frgn_pur_per.'%</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_local_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_restin_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_setdate.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_updatedate.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_loc_updated_by.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" ">'.$history_url.'</TD>
			
			
			</TR>';
		}
		echo '</TABLE>';
		$pattern_date = '';
		if($glusr_updatedate)
		{
			$condition = " and DATE(ETO_PUR_DATE) >= '$glusr_updatedate'";//TO_DATE(GLUSR_USR_LOC_PREF_UPDATE_DATE,'DD-MON-YYYY')";
			$pattern_date = $glusr_updatedate;
		}
		elseif($glusr_setdate)
		{
			$condition = "and DATE(ETO_PUR_DATE) >= '$glusr_setdate'";//and DATE(ETO_PUR_DATE) >= TO_DATE(GLUSR_USR_LOC_PREF_SET_DATE,'DD-MON-YYYY')";
			$pattern_date = $glusr_setdate;
		}

		if($flag)
		{
			$sql = "SELECT 	
			(SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST WHERE FK_GLUSR_USR_ID = GLUSR_USR_ID AND FK_ETO_OFR_ID > -1 $condition) TOTAL_CNT,
			(
				(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR.FK_GL_COUNTRY_ISO = 'IN' AND FK_ETO_OFR_ID > -1 $condition )),0) )
				+
				(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR_EXPIRED WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO = 'IN' AND FK_ETO_OFR_ID > -1 $condition)),0) )
				)TOTAL_IN
				,
				(
				(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN' AND FK_ETO_OFR_ID > -1 $condition)),0) )
				+
				(coalesce( ((SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST,ETO_OFR_EXPIRED WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR_ID AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID AND ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN' AND FK_ETO_OFR_ID > -1 $condition)),0) )
				)TOTAL_FN
				,
				NULL TOTAL_LOCAL 			
			FROM GLUSR_USR
			WHERE GLUSR_USR_ID = $glusr_id";

			
			
                 $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());// echo"<pre>";echo $sql1; echo"</pre>";        
		 $rec2 = $sth->read();
			if(isset($rec2['total_cnt']))
			{
		        $glusr_total_pur = $rec2['total_cnt'];
		        }
		        else
		        {
		        $glusr_total_pur=0;
		        }
		        if(isset($rec2['total_in']))
		        {
			$glusr_in_pur = $rec2['total_in'];
			}
			else
			{
			$glusr_in_pur=0;
			}
			$glusr_in_pur_per = 0;
			if(isset($rec2['total_fn']))
			{
			$glusr_frgn_pur = $rec2['total_fn'];
			}
			else
			{
			$glusr_frgn_pur=0;
			}
			$glusr_frgn_pur_per = 0;
			if(isset($rec2['total_local']))
			{
			$glusr_local_pur = $rec2['total_local'];
			}
			else
			{
			$glusr_local_pur=0;
			}
			$glusr_restin_pur = $glusr_in_pur - $glusr_local_pur;

			if($glusr_total_pur)
			{
				$glusr_in_pur_per = ($glusr_in_pur / $glusr_total_pur) * 100;
				$glusr_frgn_pur_per = ($glusr_frgn_pur / $glusr_total_pur) * 100;
				$glusr_in_pur_per = floor( $glusr_in_pur_per + 0.5 );
				$glusr_frgn_pur_per = floor( $glusr_frgn_pur_per + 0.5 );
			}
			echo '<br><center>Buy Lead Purchase (Usage) Pattern After '.$pattern_date.'</center><br>
			<TABLE  BORDER="1" CELLPADDING="3" style="border-collapse:collapse" border-color="#f2f2f2" CELLSPACING="1" ALIGN="CENTER">
			<TR>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"   height="35">&nbsp;<B>GLusr ID</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Company</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Person Name</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Cust Type</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;City</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Mobile</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Phone</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Total Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;India Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;India Purchase %</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Foreign Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Foreign Purchase %</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Local Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Rest IN Purchase</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;First Set On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Updated On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Updated By</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER"  ><B>&nbsp;Previous Value</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" ><B>&nbsp;New Value</B></TD>
                       </TR>
			<TR>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_id.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_company.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_name.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$custtype.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_city.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_mobile.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_phone.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_total_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_in_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_in_pur_per.'%</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_frgn_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_frgn_pur_per.'%</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_local_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_restin_pur.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_setdate.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_updatedate.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_loc_updated_by.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" ">'.$history_url.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" >'.$glusr_value.'</TD>                       
			</TR>
			</TABLE>
			';
			
		}
		echo '</BODY></HTML>';

	}

}

public function NullLocPref($dbh,$emp_id)
{ 
    $obj = new Globalconnection();
    $model = new GlobalmodelForm();

    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
    {
        $dbh = $obj->connect_db_yii('postgress_web68v');   
    }else{
        $dbh = $obj->connect_db_yii('postgress_web68v'); 
    }
	echo '<html>
         <head><title>Users whose Location Preference Is Not Set Yet</title>
	<style>.th-heading{font-size:13px; padding:5px 7px; font-weight:bold;color:red;font-family:arial}
	.ttext{font-size:12px; padding:4px 4px 4px 7px; font-family:arial}
	</style>
	</head>
        <body>
        <table width="100%" bgcolor="#EFFBFB" border="1" bordercolor="#ffffff" style="border-collapse:collapse">
	<tr>
	<td colspan="8" align="CENTER" bgcolor="#e8f3f7" style="font-family: arial; font-size: 20px; font-weight: bold; border:1px solid #d2e2e8;color:#000099;">Users Whose Location Preference Is Not Set Yet(Indian Only)</td>
	</tr>
	<TR  bgcolor="#dddddd">
		<td align="center" width="33%"  bgcolor="#f5f5f5" class="th-heading">Gluser Id</td>
		<td align="center" width="33%"  bgcolor="#f5f5f5" class="th-heading">CustType Id</td>
		</TR>';
	
	$sql="SELECT GLUSR_USR_ID,
	(CASE WHEN GLUSR_USR_CUSTTYPE_ID is not null then (GLUSR_USR_CUSTTYPE_NAME || ' (' || GLUSR_USR_CUSTTYPE_ID || ')')  end) GLUSR_USR_CUSTTYPE_WEIGHT	
	FROM GLUSR_USR left outer join CUSTTYPE 
        on 
        GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID 	
	WHERE (GLUSR_USR_CUSTTYPE_ID  IN(1,2,10,12) 
	AND GLUSR_USR_CUSTTYPE_ID   IS NOT NULL)
	AND GLUSR_USR_LOC_PREF          IS   NULL
	AND FK_GL_COUNTRY_ISO = 'IN'";
	
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
        while($rec = $sth->read()) {
        	echo '<TR  bgcolor="#dddddd">
		<td align="center" width="16%"  bgcolor="#EFFBFB" class="ttext"><strong>'.$rec['glusr_usr_id'].'</strong></td>
		<td align="center"  bgcolor="#EFFBFB" class="ttext">'.$rec['glusr_usr_custtype_weight'].'</td>
		</TR>';
        }

        echo '</table></div></body></html>';
}

}

?>