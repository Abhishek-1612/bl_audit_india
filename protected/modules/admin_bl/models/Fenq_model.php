<?php

class Fenq_model extends CFormModel
{
   public function histFENQForm($xyz)
   {
      $modidDropDown='';
     if(isset($xyz['modiddrpdwn']))
     {
     $modidDrpDwn = $xyz['modiddrpdwn'];
     }
	 $modid_result=CommonVariable::get_modid_type();
	foreach($modid_result as $key=>$value)
      {
		if(isset($modidDrpDwn) && $modidDrpDwn == $key){
			$modidDropDown.= '<option value="'.$key.'" selected>'.$value.'('.$key.')</option>';
		}else{
			$modidDropDown.= '<option value="'.$key.'">'.$value.'('.$key.')</option>';
		}
	}

	$select = '<SELECT NAME="modiddrpdwn" onChange="ShowDDL(this.value);"><OPTION VALUE="">--- Select ModID ---</OPTION>'.$modidDropDown.'</SELECT>'; 
	
	return $select;

   }
   
   public function histFENQResult($dbh,$xyz)
   {

	
    $show=0;
    $mesg='';
    if(isset($_REQUEST['fenq_table']))
    {
    $fenqTable=$_REQUEST['fenq_table'];
    }
    else
    {
    $fenqTable='ETO_OFR_FROM_FENQ';
    } 
 
    $errArr = array();
    $flagError=0;
    $tableSize=100;
    $start_date='';
    $end_date='';
    $approvby='';
    $str1='';
    if(isset($_REQUEST['modiddrpdwn']))
    {
      $modiddrpdwn=$_REQUEST['modiddrpdwn'];
     }
     else
     {
     $modiddrpdwn='';
     }
     if(isset($_REQUEST['eto_enquiry']))
     {
      $eto_enquiry =$_REQUEST['eto_enquiry'];
     }
     else
     {
      $eto_enquiry='';
     }
   $approvby=isset($_REQUEST['approvby'])?$_REQUEST['approvby']:0;
   $report=isset($_REQUEST['report'])?$_REQUEST['report']:1;
   if(isset($_REQUEST['cntry']))
   {
   $cntry=$_REQUEST['cntry'];
   }
   else
   {
    $cntry=1;
   }
   if(isset($_REQUEST['rating']))
   {
   $rating=$_REQUEST['rating'];
   }
   else
   {
   $rating='';
   }
   if(isset($_REQUEST['querytype']))
   {
   $querytype=$_REQUEST['querytype'];
   }
   else
   {
   $querytype='';
   }
   if(isset($_REQUEST['dir_enquiry']))
   {
   $dir_enquiry=$_REQUEST['dir_enquiry'];
   }
   else
   {
   $dir_enquiry='';
   }
   
   	$start_date=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:strtoupper(date('d-M-Y'));
	$end_date=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:strtoupper(date('d-M-Y'));
	$reporttype=isset($_REQUEST['reporttype'])?$_REQUEST['reporttype']:'';

	if (!$_REQUEST['start_date'])
	{
		array_push($errArr,"Please select the complete \'Start\' date");
		$flagError=1;
	}
	
	if (!$_REQUEST['end_date'])
	{
	array_push($errArr,"Please select the complete \'End\' date");
	$flagError=1;
	}
		
	if ($flagError==1)
		{
		$mesg = '';
		$mesg ='<TABLE BORDER="0" WIDTH="100%"><TR>
		<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
	  	$errorCounter=0;
		foreach ($errArr as $item)
		{
			$errorCounter++;
			$mesg .=" Error $errorCounter: $item".'<BR>';
		}
		$mesg .='<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>';
                 $show=1;
	}
	else
	{

	 $condition = $cond_summary1 = $cond_summary2=''; 
	 $more_link = '';
	 $sel_elements = '';
	 $groupbyOrderby = '';
	 $heading = ''; 
	 $td_date_modid = '';
	 $disp_heading =  '';
	 $cols1 = '';
	 $cols2 = '';
	 $cond1 = '';

	if($reporttype=='datewise'){
	   $heading = '<td class="admintext" align="center" bgcolor="#ccccff"><b>Date</b></td>';
	}else{
		$heading = '<td class="admintext" align="center" bgcolor="#ccccff"><b>Summary</b></td>';
	}
	if ($start_date!= '')
	{
		$condition .= ' TRUNC(DATE_R) >= TRUNC(TO_DATE(:start_date,\'dd-mm-yyyy\')) ';
	}
	if ($end_date!= '')
	{
		$condition .= ' AND TRUNC(DATE_R) <= TRUNC(TO_DATE(:end_date,\'dd-mm-yyyy\')) ';
	}
	if($reporttype=='datewise'){
	$groupbyOrderby = '
	GROUP BY
		TRUNC(DATE_R)
	ORDER BY
		TRUNC(DATE_R) DESC';
	$sel_elements = '
	TRUNC(DATE_R) DATE_R, ';
	}

	if($reporttype=='datewise'){
	$disp_heading =  'Day Wise Result between '.$start_date.' & '.$end_date.'';
	$cond_summary1= ' date(DATE_R) DATE_R, ';
	$cond_summary2= ' GROUP BY  date(DATE_R) ORDER BY  date(DATE_R) DESC  ';
	
	}
	else{
		$disp_heading =  'Summary Result between '.$start_date.' & '.$end_date.'';
	}

			$cols1 = 15; $cols2 = 1;
		
		$cntryrating = array('1' => "A", '2' => "B", '3' => "C", '4' => "D", '5' => "Others(C & D)", '6' => "All");
		
	
	 
		if($modiddrpdwn && $modiddrpdwn!= '0')
		{ 
			$more_link .= "&modiddrpdwn=$modiddrpdwn";
			$cond1 .=  " AND QUERY_MODID = '$modiddrpdwn' ";
		}
		if($cntry)
		{ 
			if($cntry =='2')
			{
				$cond1 .= " AND S_COUNTRY_UPPER NOT IN ('INDIA','IN')";
			}
			else
			{
				$cond1 .= " AND S_COUNTRY_UPPER IN ('INDIA','IN')";
			}
			$more_link .= "&cntry=$cntry";
		}
		if($querytype)
		{ 
			if($querytype =='2')
			{
				$cond1 .= " AND ENQUIRY_SMS_ID IS NULL ";
			}
			elseif($querytype =='3')
			{
				$cond1 .= " AND ENQUIRY_SMS_ID IS NOT NULL";
			}
		}
		
		$obj = new Globalconnection();
                $dbh=$obj->connect_db_oci('postgress_web68v');
		$sql_pg="SELECT $cond_summary1
		COUNT(DISTINCT ALL_QUERIES.Q_ID ) CNT,
		COUNT(DISTINCT GLUSR_ID_EMAIL) USERS,
		SUM((case
				WHEN STATUS=2 THEN
				(case
				WHEN ALL_QUERIES.FK_ETO_OFR_ID=NULL THEN
				1
				ELSE 0
				END )
				ELSE 0 end)) REJ_CNT, SUM (CASE
				WHEN ((case
				WHEN STATUS=2 THEN
				(case
				WHEN ALL_QUERIES.FK_ETO_OFR_ID=NULL THEN
				1
				ELSE 0 end)
				ELSE 0 end)) = 1
					AND REVIEWED IS NULL THEN
				1 END) PENDING_QC_CNT, COUNT(DISTINCT (case
				WHEN STATUS=2 THEN
				(case
				WHEN ALL_QUERIES.FK_ETO_OFR_ID=NULL THEN
				GLUSR_ID_EMAIL
				ELSE NULL end)
				ELSE NULL
				END )) REJ_USERS, COUNT(DISTINCT (case
				WHEN STATUS=2 THEN
				(case
				WHEN ALL_QUERIES.FK_ETO_OFR_ID= NULL THEN
				NULL
				ELSE ALL_QUERIES.FK_ETO_OFR_ID end)
				ELSE NULL
				END )) APP_CNT, COUNT(DISTINCT (case
				WHEN STATUS=2 THEN
				(case
				WHEN ALL_QUERIES.FK_ETO_OFR_ID=NULL THEN
				NULL
				ELSE GLUSR_ID_EMAIL
				END )
				ELSE NULL end)) APP_USERS, SUM((case
				WHEN STATUS=1 THEN
				1
				ELSE 0 end)) NO_WORK, COUNT(DISTINCT (case
				WHEN STATUS=1 THEN
				GLUSR_ID_EMAIL
				ELSE NULL end)) NO_WORK_USERS
				FROM 
				(SELECT 1 AS STATUS,
						coalesce(QUERY_ID,
					ENQUIRY_SMS_ID) Q_ID,
						NULL AS FK_ETO_OFR_ID,
						DATE_R,
						(case
					WHEN FK_GLUSR_USR_ID=NULL THEN
					TRIM(SENDEREMAIL)
					ELSE FK_GLUSR_USR_ID::character  end) GLUSR_ID_EMAIL, NULL AS ETO_OFR_FENQ_EMP_ID, QUERY_MODID, NULL REVIEWED, TO_CHAR(DATE_R,'YY-MM') POSTMON, TO_CHAR(DATE_R,'MON-YY') POSTMON_NAME
				FROM DIR_QUERY_FREE
				WHERE date(DATE_R) >= date(TO_DATE('$start_date','dd-mon-yyyy'))
						AND date(DATE_R) <= date(TO_DATE('$end_date','dd-mon-yyyy')) $cond1
				UNION
				SELECT 2 AS STATUS,
						coalesce(FK_QUERY_ID,
					ENQUIRY_SMS_ID) Q_ID,
						FK_ETO_OFR_ID,
						DATE_R,
						(case
					WHEN FK_GLUSR_USR_ID=NULL THEN
					TRIM(SENDEREMAIL)
					ELSE FK_GLUSR_USR_ID::character end ) GLUSR_ID_EMAIL, ETO_OFR_FENQ_EMP_ID, QUERY_MODID, FENQ_IS_REVIEWED REVIEWED, TO_CHAR(DATE_R,'YY-MM') POSTMON, TO_CHAR(DATE_R,'MON-YY') POSTMON_NAME
				FROM ETO_OFR_FROM_FENQ_ARCH
				WHERE date(DATE_R) >= date(TO_DATE('$start_date','dd-mon-yyyy'))
						AND date(DATE_R) <= date(TO_DATE('$end_date','dd-mon-yyyy')) ) ALL_QUERIES
						$cond_summary2 ;";
		$sth=pg_query_params($dbh,$sql_pg, array() );
		if($reporttype=='summary'){
		 $rec=pg_fetch_assoc($sth);
		 $rec=array_change_key_case($rec, CASE_UPPER);
		if(isset($rec['CNT']))
		{
		$t_enq=$rec['CNT'];
		}else{
		$t_enq='-';
		}
		if(isset($rec['USERS']))
		{
		$t_users=$rec['USERS'];
		}else
		{
		$t_users='-';
		}
		if(isset($rec['REJ_CNT']))
		{
		$r_enq=$rec['REJ_CNT'];
		}else{
		$r_enq='-';
		}
		if(isset($rec['PENDING_QC_CNT']))
		{
		$p_enq_qc=$rec['PENDING_QC_CNT'];
		}else{
		$p_enq_qc='-';
		}
		if(isset($rec['REJ_USERS']))
		{
		$r_users=$rec['REJ_USERS'];
		}else{
		$r_users='-';
		}
		if(isset($rec['APP_CNT']))
		{
		$a_enq=$rec['APP_CNT'];
		}else{
		$a_enq='-';
		}
		if(isset($rec['APP_USERS']))
		{
		$a_users=$rec['APP_USERS'];
		}else
		{
		$a_users='-';
		}
		if($rec['NO_WORK'])
		{
		$p_enq=$rec['NO_WORK'];
		}else
		{
		$p_enq='-';
		}
		if($rec['NO_WORK_USERS'])
		{
		$p_users=$rec['NO_WORK_USERS'];
		}else
		{
		$p_users='-';
		}
		$a_r_users = '';
		
		if($rec['NO_WORK'])
		{
			$a_r_users = '-';	
		}
		else
		{
			$a_r_users = $rec['USERS']- $rec['APP_CNT'];
		}
	}
	
		$str1.='<script language="javascript">
		function popup1(url)
		{
			window.open(url, \'Lookup\', \'toolbar=no, location=no, width=1000,scrollbars=yes,resizable=yes, height=1000, left=10, top=10\');
		}
		</script>

		<STYLE TYPE="text/css">
		.admintext {font-family:arial; font-size:11px;font-weight:bold;line-height:15px;}
		.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
		.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}
		</STYLE>

		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody><tr>
			<td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#dff8ff" height="30">'.$disp_heading.'</td>
		</tr>
		</tbody></table>
	
		<div id="masterdiv" style="clear: both;">
		<table align="center" border="1" cellpadding="2" cellspacing="0" width="100%">
		<tbody><tr>
			'.$heading.'
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Total Enquiry Count</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Unique Enquiry Senders</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Enquiry not Converted to PBL</b></td>
			<td class="admintext" align="center"  bgcolor="#ffe981"><b>Enquiry Pending For QC</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Users Count with atleast 1 rejected Enquiry</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Users Count with All rejected Enquiry</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Enquiry Converted to PBL</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Users Count with atleast 1 approved Enquiry</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Pending Enquiry Count</b></td>
			<td class="admintext" align="center"  bgcolor="#ccccff"><b>Pending Users</b></td>
		</tr>';
		
		$link = ''; $link1 = ''; $i=0;
		if($reporttype=='datewise'){
		while ($rec = pg_fetch_assoc($sth))
		{
			$rec=array_change_key_case($rec, CASE_UPPER);
			$i++;
			$date_modID = ''; 
			$rep_link = '';
			$all_rej = '<font color="red">0</font>'; 
			if($rec['NO_WORK'])
			{
			$no_work = $rec['NO_WORK'];
                        }
                        else
                        {
                        $no_work=0;
                        }
			if($no_work == 0)
			{
				$all_rej = $rec['USERS'] - $rec['APP_USERS'];
			}
			
			if($report == 1)
			{
				$date_modID = '<td class="admintext1" align="center" >'.$rec['DATE_R'].'</td>';
				$rep_link = '&date='.$rec['DATE_R'].'';
			}
			else
			{
				$date_modID = '<td class="admintext1" align="center" >'.$rec['QUERY_MODID'].'</td>
				<td class="admintext1" align="center" >'.$rec['POSTMON_NAME'].'</td>';

				$rep_link = '&month='.$rec['POSTMON'].'';
				if(!$modiddrpdwn)
				{
					$rep_link .= '&modiddrpdwn='.$rec['QUERY_MODID'].'';
				}
			}
			$rep_link .= '&report='.$report.'';
			$link = 'eto-history-fenq.mp?action=detail'.$rep_link.''.$more_link.'';
			$link1 = 'eto-history-fenq1.mp?action=detail'.$rep_link.''.$more_link.'';
			$str1.='
			<tr>
			'.$date_modID.'
			<td class="admintext1" align="center" >'.$rec['CNT'].'</td>
			<td class="admintext1" align="center" >'.$rec['USERS'].'</td>
			<td class="admintext1" align="center" >';

			if($rec['REJ_CNT'])
			{
				$str1.=''.$rec['REJ_CNT'].'</td>
				<td class="admintext1" align="center">'.$rec['PENDING_QC_CNT'].'</td>
				<td class="admintext1" align="center">'.$rec['REJ_USERS'].'';
			}
			else
			{
				$str1.='
				-</td><td class="admintext1" align="center" >-</td><td class="admintext1" align="center" >-';
			}

			$str1.='</td>
			<td class="admintext1" align="center" >'.$all_rej.'</td>
			<td class="admintext1" align="center" >';

			if($rec['APP_CNT'])
			{
				$str1.=$rec['APP_CNT'].'</td>
				<td class="admintext1" align="center">'.$rec['APP_USERS'].'';
			}
			else
			{
				$str1.='
				-</td><td class="admintext1" align="center" >-';
			}

			$str1.='</td>
			<td class="admintext1" align="center" >';
                 
			if($rec['NO_WORK'])
			{
				$str1.=$rec['NO_WORK'].'</td>
				<td class="admintext1" align="center">'.$rec['NO_WORK_USERS'].'';
			}
			else
			{
				$str1.='
				-</td><td class="admintext1" align="center" >-';
			}
			$str1.='</td>';
			$str1.='</tr>';
		}
		if($i == 0)
		{
			$str1.='
			<tr>
			<td class="admintext1" align="center" colspan="'.$cols1.'">
			<DIV CLASS="tab-head">No Record Found !</DIV> </td>
			</tr>';
		}
	}
		if($reporttype=="summary"){
			$str1.='
			<tr>
			<td class="admintext1" align="center"  colspan="'.$cols2.'">Total Summary</td>
			<td class="admintext1" align="center" >'.$t_enq.'</td>
			<td class="admintext1" align="center" >'.$t_users.'</td>
			<td class="admintext1" align="center" >'.$r_enq.'</td>
			<td class="admintext1" align="center" >'.$p_enq_qc.'</td>
			<td class="admintext1" align="center" >'.$r_users.'</td>
			<td class="admintext1" align="center" >'.$a_r_users.'</td>
			<td class="admintext1" align="center" >'.$a_enq.'</td>
			<td class="admintext1" align="center" >'.$a_users.'</td>
			<td class="admintext1" align="center" >'.$p_enq.'</td>
			<td class="admintext1" align="center" >'.$p_users.'</td>
			</tr>';
		}
		$str1.='</tbody></table>';
	}
     return array($str1,$show,$mesg);
   }
}
?>