<?php

class Fenq_model_pg extends CFormModel
{
   public function histFENQForm($dbh,$xyz)
   {
      $modidDropDown='';
     if(isset($xyz['modiddrpdwn']))
     {
     $modidDrpDwn = $xyz['modiddrpdwn'];
     }
     
     $sql="SELECT GL_MODULE_ID, GL_MODULE_NAME FROM GL_MODULE ORDER BY GL_MODULE_ID";
     $sth=  pg_query($dbh,$sql);    
     
//      $modidDropDown='';
     while ($rec = pg_fetch_array($sth))
      {
                 $rec=array_change_key_case($rec, CASE_UPPER);  
		if(isset($modidDrpDwn) && $modidDrpDwn == $rec['GL_MODULE_ID'])
		{
		$modidDropDown .= '<OPTION VALUE="'.$rec['GL_MODULE_ID'].'" SELECTED> '.$rec['GL_MODULE_ID'].' ('.$rec['GL_MODULE_NAME'].') </OPTION>';
		}
		else
		{
		$modidDropDown .= '<OPTION VALUE="'.$rec['GL_MODULE_ID'].'"> '.$rec['GL_MODULE_ID'].' ('.$rec['GL_MODULE_NAME'].') </OPTION>';
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
   $report=isset($_REQUEST['report'])?$_REQUEST['report']:0;
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
   
   
          $s_date =$_REQUEST['bdate_year']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_day'];

	  $start_date =$_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];
	  
	  $e_date =$_REQUEST['adate_year']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_day'];

	  $end_date =$_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];
       
	        $date  = date($s_date);
	
  	        $date1 = date($e_date);
  	        
  	        
//   	     echo $start_date.'start-date<br>';
//   	     echo $end_date.'end-date<br>';
//   	     
  	        
        if ($_REQUEST['bdate_day'] || $_REQUEST['bdate_month'] || $_REQUEST['bdate_year'])
	{
	    if (!$_REQUEST['bdate_day'] || !$_REQUEST['bdate_month'] || !$_REQUEST['bdate_year']) 
	    {
		  
		    array_push($errArr,"Please select the complete \'Start\' date");
		    $flagError=1;
	    }
	    elseif(!(isset($date)))
	    {
		    
		    array_push($errArr,"Invalid Start Date");
		    $flagError=1;
	    }
	}
	if ($_REQUEST['adate_day'] || $_REQUEST['adate_month'] || $_REQUEST['adate_year'])
	{
	    if (!$_REQUEST['adate_day'] || !$_REQUEST['adate_month'] || !$_REQUEST['adate_year']) 
	    {
		    
		    array_push($errArr,"Please select the complete \'End\' date");
		    $flagError=1;
	    }
	    elseif(!(isset($date1)))
	    
	    { 
	      
		  array_push($errArr,"Invalid End Date");
		    $flagError=1;
	    }
	
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
// 		$this->histFENQForm($dbh,$mesg);
	}
	else
	{

	 $condition = ''; 
	 $more_link = '';
	 $sel_elements = '';
	 $groupbyOrderby = '';
	 $heading = ''; 
	 $td_date_modid = '';
	 $disp_heading =  '';
	 $cols1 = '';
	 $cols2 = '';

	 if($report == 1)
	 {
	   $heading = '<td class="admintext" align="center" bgcolor="#ccccff"><b>Date</b></td>';
			if ($start_date!= '')
			{
				$condition .= ' TRUNC(DATE_R) >= TRUNC(TO_DATE($1,\'dd-mm-yyyy\')) ';
			}
			if ($end_date!= '')
			{
				$condition .= ' AND TRUNC(DATE_R) <= TRUNC(TO_DATE($2,\'dd-mm-yyyy\')) ';
			}

			$groupbyOrderby = '
			GROUP BY
				TRUNC(DATE_R)
			ORDER BY
				TRUNC(DATE_R) DESC';
			$sel_elements = '
			TRUNC(DATE_R) DATE_R, ';

			$disp_heading =  'Day Wise Result between '.$start_date.' & '.$end_date.'';

			$cols1 = 15; $cols2 = 1;
		}
		else
		{
		
		$heading = '<td class="admintext" align="center" bgcolor="#ccccff"><b>ModID</b></td>
			<td class="admintext" align="center" bgcolor="#ccccff"><b>Month</b></td>';

			if ($start_date!='')
			{
				$condition .= ' TRUNC(DATE_R) >= TRUNC(TO_DATE($1,\'dd-mm-yyyy\'),\'MONTH\') ';
			}
			if ($end_date!= '')
			{
				$condition .= ' AND TRUNC(DATE_R) <= LAST_DAY(TO_DATE($2,\'dd-mm-yyyy\')) ';
			}

			$groupbyOrderby ='
			GROUP BY
				POSTMON, POSTMON_NAME, QUERY_MODID
			ORDER BY
				QUERY_MODID, POSTMON DESC';
			$sel_elements = 'QUERY_MODID, POSTMON, POSTMON_NAME, ';

			$before_month = $_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];

			$after_month =  $_REQUEST['adate_month']."-".$_REQUEST['adate_year'];

			$disp_heading =  'Monthly Wise Result between '.$before_month.' & '.$after_month.'';
			$cols1 = 16; $cols2 = 2;
		}
		$cntryrating = array('1' => "A", '2' => "B", '3' => "C", '4' => "D", '5' => "Others(C & D)", '6' => "All");
		
		$filter_elements = "
		COUNT(DISTINCT ALL_QUERIES.Q_ID ) CNT,
		COUNT(DISTINCT GLUSR_ID_EMAIL) USERS,
		SUM(DECODE(STATUS,2,DECODE(ALL_QUERIES.FK_ETO_OFR_ID,NULL,1,0),0)) REJ_CNT,
		SUM (CASE WHEN (DECODE(STATUS,2,DECODE(ALL_QUERIES.FK_ETO_OFR_ID,NULL,1,0),0)) = 1 AND REVIEWED IS NULL THEN 1 END) PENDING_QC_CNT,
		COUNT(DISTINCT DECODE(STATUS,2,DECODE(ALL_QUERIES.FK_ETO_OFR_ID,NULL,GLUSR_ID_EMAIL,NULL),NULL)) REJ_USERS,
		COUNT(DISTINCT DECODE(STATUS,2,DECODE(ALL_QUERIES.FK_ETO_OFR_ID,NULL,NULL,ALL_QUERIES.FK_ETO_OFR_ID),NULL)) APP_CNT,
		COUNT(DISTINCT DECODE(STATUS,2,DECODE(ALL_QUERIES.FK_ETO_OFR_ID,NULL,NULL,GLUSR_ID_EMAIL),NULL)) APP_USERS,
		SUM(DECODE(STATUS,1,1,0)) NO_WORK,
		COUNT(DISTINCT DECODE(STATUS,1,GLUSR_ID_EMAIL,NULL)) NO_WORK_USERS,
	
		COUNT(DISTINCT CASE WHEN ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID IS NOT NULL THEN ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID ELSE NULL END) SOLD_UNIQUE,
		COUNT(CASE WHEN ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID IS NOT NULL THEN ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID ELSE NULL END) SOLD_NUM_OF_TIMES,
		COUNT(DISTINCT CASE WHEN ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID IS NULL THEN ALL_QUERIES.FK_ETO_OFR_ID ELSE NULL END) UNSOLD,
		SUM(CASE WHEN ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID IS NOT NULL THEN ETO_LEAD_PUR_HIST.ETO_CREDITS_USED ELSE NULL END) CREDITS_EARNED";
		
		$filter_where = ",
	( SELECT FK_ETO_OFR_ID, ETO_CREDITS_USED FROM ETO_LEAD_PUR_HIST WHERE FK_ETO_OFR_ID > -1 ) ETO_LEAD_PUR_HIST
WHERE
	ALL_QUERIES.FK_ETO_OFR_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID (+)";
	
	      $sel_elements .= $filter_elements;
	      $sel_where = $filter_where;

		if($modiddrpdwn && $modiddrpdwn!= '0')
		{ 
			$condition .=" AND QUERY_MODID = $3";
			$more_link .= "&modiddrpdwn=$modiddrpdwn";
		}
		if($cntry)
		{ 
			if($cntry =='2')
			{
				$condition .= " AND S_COUNTRY_UPPER NOT IN ('INDIA','IN')";
			}
			else
			{
				$condition .= " AND S_COUNTRY_UPPER IN ('INDIA','IN')";
			}
			$more_link .= "&cntry=$cntry";
		}
		if($querytype)
		{ 
			if($querytype =='2')
			{
				$condition .= " AND ENQUIRY_SMS_ID IS NULL";
			}
			elseif($querytype =='3')
			{
				$condition .= " AND ENQUIRY_SMS_ID IS NOT NULL";
			}
		}
		if($rating && $rating != '6')
		{ 
			if($rating =='5')
			{
				$condition .= " AND S_COUNTRY_RATING NOT IN ('A','B')";
			}
			else
			{
				$condition .= " AND S_COUNTRY_RATING = '$cntryrating[$rating]'";
			}
			$more_link .= "&rating=$rating";
		}
		if($eto_enquiry && $eto_enquiry =='Detail' && $modiddrpdwn =='ETO')
		{			
			$condition .= " AND NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) like '%details.mp%'";
		
		}
		elseif($eto_enquiry && $eto_enquiry =='Search' && $modiddrpdwn =='ETO')	
		{
# 			$condition .= " AND lower(QUERY_REFERENCE_URL) like '%search.mp%'";
			$condition .= " AND NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) like '%search.mp%'";
		}
		elseif($eto_enquiry && $eto_enquiry =='Other' && $modiddrpdwn =='ETO')
		{
			$condition .= " AND NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) not like '%details.mp%' and NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) not like '%search.mp%'";
		}
		
		if($dir_enquiry && $dir_enquiry =='Search' && $modiddrpdwn == 'DIR')	
               {
	$condition .= " AND (NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) like '%catprdsearch.mp%' OR NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) like '%search.mp%')";
                }
		elseif($dir_enquiry && $dir_enquiry =='Other' && $modiddrpdwn == 'DIR')
		{
			$condition .= " AND (NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) not like '%catprdsearch.mp%' AND NVL(QUERY_REF_CURRENT_URL , QUERY_REFERENCE_URL) not like '%search.mp%')";
		}
		 $in_sql='';
		if($approvby > 0)
		{
			$in_sql = " WHERE ETO_OFR_FENQ_EMP_ID =$4";
			$more_link .= "&emp=$approvby";
		}

		if($condition !='')
		{
			$condition = " WHERE $condition";
		}
     
                 $in_query = "
		SELECT
			1 AS STATUS,
			NVL(QUERY_ID,ENQUIRY_SMS_ID) Q_ID,
			NULL AS FK_ETO_OFR_ID,
			DATE_R,
			DECODE(FK_GLUSR_USR_ID,NULL,TRIM(SENDEREMAIL),TO_CHAR(FK_GLUSR_USR_ID)) GLUSR_ID_EMAIL,
			NULL AS ETO_OFR_FENQ_EMP_ID,
			QUERY_MODID,
			NULL REVIEWED,
			TO_CHAR(DATE_R,'YY-MM') POSTMON,
			TO_CHAR(DATE_R,'MON-YY') POSTMON_NAME
		FROM
			DIR_QUERY_FREE $condition
		UNION
		SELECT
			2 AS STATUS,
			NVL(FK_QUERY_ID,ENQUIRY_SMS_ID) Q_ID,
			FK_ETO_OFR_ID,
			DATE_R,
			DECODE(FK_GLUSR_USR_ID,NULL,TRIM(SENDEREMAIL),TO_CHAR(FK_GLUSR_USR_ID)) GLUSR_ID_EMAIL,
			ETO_OFR_FENQ_EMP_ID,
			QUERY_MODID,
			FENQ_IS_REVIEWED REVIEWED,
			TO_CHAR(DATE_R,'YY-MM') POSTMON,
			TO_CHAR(DATE_R,'MON-YY') POSTMON_NAME
		FROM
			$fenqTable $condition";
			
			
			$sql = "
		SELECT $sel_elements FROM ( $in_query ) ALL_QUERIES $sel_where $in_sql $groupbyOrderby";

                $params=array();        
		
		if ($start_date != '')
		{
		        array_push($params, $start_date);
			
		}
		
		if ($end_date != '')
		{
		        array_push($params, $end_date);
			
		}

		if($approvby > 0)
		{
		        array_push($params, $approvby);
			
		}
		if($modiddrpdwn && $modiddrpdwn != '0')
		{
		         array_push($params, $modiddrpdwn);
			
		}
                $sth=pg_query_params($dbh,$sql,$params);
		
		$sql_t = "
		SELECT $filter_elements FROM ( $in_query ) ALL_QUERIES $filter_where $in_sql";		 
		$sth_t=pg_query_params($dbh,$sql_t,$params);
		 
//                  echo '<br><br><br>';
//                  die;

		if ($start_date != '')
		{
		        array_push($params, $start_date);				
		}
		if ($end_date != '')
		{
		        array_push($params, $end_date);				
		}
		if($approvby > 0)
		{
		       array_push($params, $approvby);		
		}
		if($modiddrpdwn && $modiddrpdwn != '0')
		{
		         array_push($params, $modiddrpdwn);			
		}
		
// 		echo '$modiddrpdwn'.$modiddrpdwn.'<br>';
// 		echo '$approvby'.$approvby.'<br>';
// 		echo '$start_date'.$start_date.'<br>';
// 		echo '$end_date'.$end_date.'<br><br>';
		
		
		
// 		  echo $sql_t;
//                  echo '<br><br><br>';
// 		
		
		
		$rec_t=  pg_fetch_array($sth_t);
                $rec_t=array_change_key_case($rec_t, CASE_UPPER);  
		if(isset($rec_t['CNT']))
		{
		$t_enq=$rec_t['CNT'];
		}
		else{
		$t_enq='-';
		}
		if(isset($rec_t['USERS']))
		{
		$t_users=$rec_t['USERS'];
		}
		else
		{
		$t_users='-';
		}
		if(isset($rec_t['REJ_CNT']))
		{
		$r_enq=$rec_t['REJ_CNT'];
		}
		else{
		$r_enq='-';
		}
		if(isset($rec_t['PENDING_QC_CNT']))
		{
		$p_enq_qc=$rec_t['PENDING_QC_CNT'];
		}
		else{
		$p_enq_qc='-';
		}
		if(isset($rec_t['REJ_USERS']))
		{
		$r_users=$rec_t['REJ_USERS'];
		}
		else{
		$r_users='-';
		}
		if(isset($rec_t['APP_CNT']))
		{
		$a_enq=$rec_t['APP_CNT'];
		}
		else{
		$a_enq='-';
		}
		if(isset($rec_t['APP_USERS']))
		{
		$a_users=$rec_t['APP_USERS'];
		}
		else
		{
		$a_users='-';
		}
		if($rec_t['NO_WORK'])
		{
		$p_enq=$rec_t['NO_WORK'];
		}
		else
		{
		$p_enq='-';
		}
		if($rec_t['NO_WORK_USERS'])
		{
		$p_users=$rec_t['NO_WORK_USERS'];
                }
                else
                {
                $p_users='-';
                }
                if($rec_t['SOLD_UNIQUE'])
                {
		$sold_unique=$rec_t['SOLD_UNIQUE'];
		}
		else{
		$sold_unique='-';
		}
		if($rec_t['SOLD_NUM_OF_TIMES'])
		{
		$sold_num_of_times=$rec_t['SOLD_NUM_OF_TIMES'];
		}
		else
		{
		$sold_num_of_times='-';
		}
		if($rec_t['UNSOLD'])
		{
		$unsold=$rec_t['UNSOLD'];
		}
		else
		{
		$unsold='-';
		}
		if($rec_t['CREDITS_EARNED'])
		{
		$credits_earned=$rec_t['CREDITS_EARNED'];
		}
		else{
		$credits_earned='-';
		}

		$a_r_users = '';
		
		if($rec_t['NO_WORK'])
		{
			$a_r_users = '-';	
		}
		else
		{
			$a_r_users = $rec_t['USERS']- $rec_t['APP_CNT'];
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
			<td colspan="4" style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">'.$disp_heading.'</td>
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

			<td class="admintext" align="center" bgcolor="#ccccff"><b>Unique Sold</b></td>
			<td class="admintext" align="center" bgcolor="#ccccff"><b>Total Sold</b></td>
			<td class="admintext" align="center" bgcolor="#ccccff"><b>Unsold</b></td>
			<td class="admintext" align="center" bgcolor="#ccccff"><b>Credits Earned</b></td>
		</tr>';
		
		$link = ''; $link1 = ''; $i=0;

		while ($rec = pg_fetch_array($sth))
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

			if($rec['SOLD_UNIQUE'])
			{
				$str1.='<td class="admintext1" align="center" >'.$rec['SOLD_UNIQUE'].'</td>';
			}
			else
			{
				$str1.='<td class="admintext1" align="center" >-</td>';
			}
			if($rec['SOLD_NUM_OF_TIMES'])
			{
				$str1.='<td class="admintext1" align="center" >'.$rec['SOLD_NUM_OF_TIMES'].'</td>';
			}
			else
			{
				$str1.='<td class="admintext1" align="center" >-</td>';
			}
			if($rec['UNSOLD'])
			{
				$str1.='<td class="admintext1" align="center" >'.$rec['UNSOLD'].'</td>';
			}
			else
			{
				$str1.='<td class="admintext1" align="center" >-</td>';
			}
			if($rec['CREDITS_EARNED'])
			{
				$str1.='<td class="admintext1" align="center" >'.$rec['CREDITS_EARNED'].'</td>';
			}
			else
			{
				$str1.='<td class="admintext1" align="center" >-</td>';
			}

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
		else
		{
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

			<td class="admintext1" align="center" >'.$sold_unique.'</td>
			<td class="admintext1" align="center" >'.$sold_num_of_times.'</td>
			<td class="admintext1" align="center" >'.$unsold.'</td>
			<td class="admintext1" align="center" >'.$credits_earned.'</td>
			</tr>';
		}
		$str1.='</tbody></table>';
	}
// 	echo $str1;
// 	die;
     return array($str1,$show,$mesg);
   }
}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> 9dc441d26295495f79ddfc94bf793c3efd86f940
