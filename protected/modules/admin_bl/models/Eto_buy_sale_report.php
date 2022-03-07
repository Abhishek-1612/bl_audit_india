<?php

 class Eto_buy_sale_report extends CFormModel
{
 

  public function dailySaleStatus($dbh)
  {
    
	$errArr = array();
	$flagError=0;
         $mesg = '';
         $sth = '';
	 $s_date = $_REQUEST['bdate_year']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_day'];

	 $start_date = $_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];


	 $e_date = $_REQUEST['adate_year']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_day'];

	 $end_date = $_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];

	 $date  = date($s_date);
  	 $date1 = date($e_date);

	if (!isset($_REQUEST['bdate_day']) || !isset($_REQUEST['bdate_month']) || !isset($_REQUEST['bdate_year'])) 
	{
		array_push($errArr,"Please select the complete \'Start\' date");
		$flagError=1;
	}
	elseif(!(isset($date)))
	{
		array_push($errArr,"Invalid Start Date");
		$flagError=1;
	}
	
	if (!isset($_REQUEST['adate_day']) || !isset($_REQUEST['adate_month']) || !isset($_REQUEST['adate_year'])) 
	{
		array_push($errArr,"Please select the complete \'End\' date");
		$flagError=1;
	}
	elseif(!(isset($date1)))
	{
		array_push($errArr,"Invalid End Date");
		$flagError=1;
	}

	if ($flagError==1)
	{
		
		$mesg = '<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
		 $errorCounter=0;
		foreach ($errArr as $temp)
		{
			$errorCounter++;
			$mesg .= 'Error '.$errorCounter.':'.$temp.'<BR>';
		}
		$mesg .='<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>';

	
	} 
	else 
	{	
	

		 $months = array('01' => "Jan",
		'02' => "Feb",
		'03' => "Mar",
		'04' => "Apr",
		'05' => "May",
		'06' => "June",
		'07' => "July",
		'08' => "Aug",
		'09' => "Sept",
		'10' => "Oct",
		'11' => "Nov",
		'12' => "Dec");

		 $bdate_day = isset($_REQUEST['bdate_day']) ? $_REQUEST['bdate_day'] : '';
		 $bdate_month = isset($_REQUEST['bdate_month']) ? $_REQUEST['bdate_month'] : '';
		 $bdate_year = isset($_REQUEST['bdate_year']) ? $_REQUEST['bdate_year'] : '';
		 $adate_day = isset($_REQUEST['adate_day']) ? $_REQUEST['adate_day'] : '';
		 $adate_month = isset($_REQUEST['adate_month']) ? $_REQUEST['adate_month'] : '';
		 $adate_year = isset($_REQUEST['adate_year']) ? $_REQUEST['adate_year'] : '';

		 $modid = isset($_REQUEST['modid']) ? $_REQUEST['modid'] : '';
		 $offertype = isset($_REQUEST['offertype']) ? $_REQUEST['offertype'] : 1;
		 $country_quality = isset($_REQUEST['country_quality']) ? $_REQUEST['country_quality'] : '';

		 $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : 0;

		echo '<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>';

		#################### New Design ############################

		
		#qeury
		$sql = " SELECT A.*, DENSE_RANK() OVER(ORDER BY ETO_OFR_ID desc) SEQ FROM (";

		$sql .= "
			SELECT
				ETO_OFR_DISPLAY_ID ETO_OFR_ID,
				ETO_OFR_TITLE,
				TO_CHAR(ETO_OFR_DATE,'dd-mm-yyyy') AS OFFER_DATE,
				TO_CHAR(ETO_PUR_DATE,'dd-mm-yyyy') AS PUR_DATE,
				ETO_PUR_DATE,
				ETO_OFR_DESC,
				TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
				TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
				TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
				ETO_OFR_S_IP,
				ETO_OFR_S_IP_COUNTRY,
				DECODE(ETO_OFR.FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/', ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
				0 AS EXPIRED,
				(GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
				DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
				DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
				GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
				GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
				GLUSR_USR_URL ETO_OFR_GLUSR_DISP_URL,
				LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
				LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
				LTRIM(GL_COUNTRY_NAME) GLUSR_COUNTRY,
				LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
				GLUSR_USR_EMAIL,
				GLUSR_USR_PH_COUNTRY,
				GLUSR_USR_PH_MOBILE_ALT,
				LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
				LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
				LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
				ETO_CREDITS_USED,
				ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID FK_GLUSR_USR_ID,
				'<FONT COLOR=\"GREEN\">Live</FONT>' ETO_OFR_STATUS,
				NULL ETO_OFR_PREFERED_FK_GLUSR_ID,
				DECODE(ETO_LEAD_FK_GL_MODULE_ID,'HELLOTD','HT','IM') ETO_LEAD_FK_GL_MODULE_ID,
				(SELECT (SUM(ETO_CUST_PURCHASE_AMOUNTPAID)/SUM(ETO_CUST_PURCHASE_CREDITS)) FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND P_H.ETO_CUST_ORDER_ID > -1) AVG_PER_CREDIT_COST,
				NVL((SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),2) GLUSR_STATUS,
				ETO_OFR.FK_GLUSR_USR_ID BUYER_ID,
				0 PREFERRED_STATUS
			FROM 
				ETO_OFR, ETO_LEAD_PUR_HIST, GLUSR_USR, GL_COUNTRY
			WHERE 
				FK_ETO_OFR_ID > -1
				AND ETO_OFR_TYP = 'B'
				AND FK_ETO_OFR_ID = ETO_OFR_DISPLAY_ID
				AND ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
				AND GLUSR_USR.FK_GL_COUNTRY_ISO = GL_COUNTRY.GL_COUNTRY_ISO";

		if ($start_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) >= TRUNC(TO_DATE('$start_date','dd-mm-yyyy'))";
		}
		if ($end_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) <= TRUNC(TO_DATE('$end_date','dd-mm-yyyy'))";
		}
		if($modid)
		{
			$sql .= " and ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID = :modid";
		}

		if($client)
		{
			if($client==1)
			{
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) > 0 ";
			}
			elseif($client==2)
			{	
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) IS NULL";
			}			
		}

		$sql .= " UNION
		SELECT
			ETO_OFR_DISPLAY_ID ETO_OFR_ID,
			ETO_OFR_TITLE,
			TO_CHAR(ETO_OFR_DATE,'dd-mm-yyyy') AS OFFER_DATE,
			TO_CHAR(ETO_PUR_DATE,'dd-mm-yyyy') AS PUR_DATE,
			ETO_PUR_DATE,
			ETO_OFR_DESC,
			TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
			TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
			TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
			ETO_OFR_S_IP,
			ETO_OFR_S_IP_COUNTRY,
			DECODE(ETO_OFR_EXPIRED.FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/', ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
			0 AS EXPIRED,
			(GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
			DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
			DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
			GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
			GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
			GLUSR_USR_URL ETO_OFR_GLUSR_DISP_URL,
			LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
			LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
			LTRIM(GL_COUNTRY_NAME) GLUSR_COUNTRY,
			LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
			GLUSR_USR_EMAIL,
			GLUSR_USR_PH_COUNTRY,
			GLUSR_USR_PH_MOBILE_ALT,
			LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
			LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
			LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
			ETO_CREDITS_USED,
			ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID FK_GLUSR_USR_ID,
			'<FONT COLOR=\"GREEN\">Live</FONT>' ETO_OFR_STATUS,
			NULL ETO_OFR_PREFERED_FK_GLUSR_ID,
			DECODE(ETO_LEAD_FK_GL_MODULE_ID,'HELLOTD','HT','IM') ETO_LEAD_FK_GL_MODULE_ID,
			(SELECT (SUM(ETO_CUST_PURCHASE_AMOUNTPAID)/SUM(ETO_CUST_PURCHASE_CREDITS)) FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND P_H.ETO_CUST_ORDER_ID > -1) AVG_PER_CREDIT_COST,
			NVL((SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),2) GLUSR_STATUS,
			ETO_OFR_EXPIRED.FK_GLUSR_USR_ID BUYER_ID,
			0 PREFERRED_STATUS
		FROM 
			ETO_OFR_EXPIRED, ETO_LEAD_PUR_HIST, GLUSR_USR, GL_COUNTRY
		WHERE 
			FK_ETO_OFR_ID > -1
			AND ETO_OFR_TYP = 'B'
			AND FK_ETO_OFR_ID = ETO_OFR_DISPLAY_ID
			AND ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
			AND GLUSR_USR.FK_GL_COUNTRY_ISO = GL_COUNTRY.GL_COUNTRY_ISO";

		if ($start_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) >= TRUNC(TO_DATE('$start_date','dd-mm-yyyy'))";
		}
		if ($end_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) <= TRUNC(TO_DATE('$end_date','dd-mm-yyyy'))";
		}
		if($modid)
		{
			$sql .= " and ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID = :modid";
		}

		if($client)
		{
			if($client==1)
			{
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) > 0";
			}
			elseif($client==2)
			{	
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) is null";
			}			
		}

		$sql .= " ) A ORDER BY ETO_OFR_ID desc, ETO_PUR_DATE desc";
		//echo $sql;
		
# 		print $sql;
# 		exit;
	         $sth= oci_parse($dbh ,$sql);
		 
		if($modid)
		{       
		         oci_bind_by_name($sth,':modid',$modid); 
			
		}
                oci_execute($sth);
                
                
	}
	return array($mesg,$sth);
	
	}

  public function dailySaleStatus_pg($dbh)
  {
    
	$errArr = array();
	$flagError=0;
         $mesg = '';
         $sth1 = '';
	 $s_date = $_REQUEST['bdate_year']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_day'];

	 $start_date = $_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];


	 $e_date = $_REQUEST['adate_year']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_day'];

	 $end_date = $_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];

	 $date  = date($s_date);
  	 $date1 = date($e_date);

	if (!isset($_REQUEST['bdate_day']) || !isset($_REQUEST['bdate_month']) || !isset($_REQUEST['bdate_year'])) 
	{
		array_push($errArr,"Please select the complete \'Start\' date");
		$flagError=1;
	}
	elseif(!(isset($date)))
	{
		array_push($errArr,"Invalid Start Date");
		$flagError=1;
	}
	
	if (!isset($_REQUEST['adate_day']) || !isset($_REQUEST['adate_month']) || !isset($_REQUEST['adate_year'])) 
	{
		array_push($errArr,"Please select the complete \'End\' date");
		$flagError=1;
	}
	elseif(!(isset($date1)))
	{
		array_push($errArr,"Invalid End Date");
		$flagError=1;
	}

	if ($flagError==1)
	{
		
		$mesg = '<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
		 $errorCounter=0;
		foreach ($errArr as $temp)
		{
			$errorCounter++;
			$mesg .= 'Error '.$errorCounter.':'.$temp.'<BR>';
		}
		$mesg .='<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>';

	
	} 
	else 
	{	
	
		 $months = array('01' => "Jan",
		'02' => "Feb",
		'03' => "Mar",
		'04' => "Apr",
		'05' => "May",
		'06' => "June",
		'07' => "July",
		'08' => "Aug",
		'09' => "Sept",
		'10' => "Oct",
		'11' => "Nov",
		'12' => "Dec");

		 $bdate_day = isset($_REQUEST['bdate_day']) ? $_REQUEST['bdate_day'] : '';
		 $bdate_month = isset($_REQUEST['bdate_month']) ? $_REQUEST['bdate_month'] : '';
		 $bdate_year = isset($_REQUEST['bdate_year']) ? $_REQUEST['bdate_year'] : '';
		 $adate_day = isset($_REQUEST['adate_day']) ? $_REQUEST['adate_day'] : '';
		 $adate_month = isset($_REQUEST['adate_month']) ? $_REQUEST['adate_month'] : '';
		 $adate_year = isset($_REQUEST['adate_year']) ? $_REQUEST['adate_year'] : '';

		 $modid = isset($_REQUEST['modid']) ? $_REQUEST['modid'] : '';
		 $offertype = isset($_REQUEST['offertype']) ? $_REQUEST['offertype'] : 1;
		 $country_quality = isset($_REQUEST['country_quality']) ? $_REQUEST['country_quality'] : '';

		 $client = isset($_REQUEST['client']) ? $_REQUEST['client'] : 0;

		echo '<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>';

		#################### New Design ############################

		
		#qeury
		$sql = " SELECT A.*, DENSE_RANK() OVER(ORDER BY ETO_OFR_ID desc) SEQ FROM (";

		$sql .= "
			SELECT
				ETO_OFR_DISPLAY_ID ETO_OFR_ID,
				ETO_OFR_TITLE,
				TO_CHAR(ETO_OFR_DATE,'dd-mm-yyyy') AS OFFER_DATE,
				TO_CHAR(ETO_PUR_DATE,'dd-mm-yyyy') AS PUR_DATE,
				ETO_PUR_DATE,
				ETO_OFR_DESC,
				TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
				TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
				TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
				ETO_OFR_S_IP,
				ETO_OFR_S_IP_COUNTRY,
				DECODE(ETO_OFR.FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/', ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
				0 AS EXPIRED,
				(GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
				DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
				DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
				GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
				GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
				GLUSR_USR_URL ETO_OFR_GLUSR_DISP_URL,
				LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
				LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
				LTRIM(GL_COUNTRY_NAME) GLUSR_COUNTRY,
				LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
				GLUSR_USR_EMAIL,
				GLUSR_USR_PH_COUNTRY,
				GLUSR_USR_PH_MOBILE_ALT,
				LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
				LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
				LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
				ETO_CREDITS_USED,
				ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID FK_GLUSR_USR_ID,
				'<FONT COLOR=\"GREEN\">Live</FONT>' ETO_OFR_STATUS,
				NULL ETO_OFR_PREFERED_FK_GLUSR_ID,
				DECODE(ETO_LEAD_FK_GL_MODULE_ID,'HELLOTD','HT','IM') ETO_LEAD_FK_GL_MODULE_ID,
				(SELECT (SUM(ETO_CUST_PURCHASE_AMOUNTPAID)/SUM(ETO_CUST_PURCHASE_CREDITS)) FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND P_H.ETO_CUST_ORDER_ID > -1) AVG_PER_CREDIT_COST,
				NVL((SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),2) GLUSR_STATUS,
				ETO_OFR.FK_GLUSR_USR_ID BUYER_ID,
				0 PREFERRED_STATUS
			FROM 
				ETO_OFR, ETO_LEAD_PUR_HIST, GLUSR_USR, GL_COUNTRY
			WHERE 
				FK_ETO_OFR_ID > -1
				AND ETO_OFR_TYP = 'B'
				AND FK_ETO_OFR_ID = ETO_OFR_DISPLAY_ID
				AND ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
				AND GLUSR_USR.FK_GL_COUNTRY_ISO = GL_COUNTRY.GL_COUNTRY_ISO";

		if ($start_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) >= TRUNC(TO_DATE('$start_date','dd-mm-yyyy'))";
		}
		if ($end_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) <= TRUNC(TO_DATE('$end_date','dd-mm-yyyy'))";
		}
		if($modid)
		{
			$sql .= " and ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID = $modid";
		}

		if($client)
		{
			if($client==1)
			{
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) > 0 ";
			}
			elseif($client==2)
			{	
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) IS NULL";
			}			
		}

		$sql .= " UNION
		SELECT
			ETO_OFR_DISPLAY_ID ETO_OFR_ID,
			ETO_OFR_TITLE,
			TO_CHAR(ETO_OFR_DATE,'dd-mm-yyyy') AS OFFER_DATE,
			TO_CHAR(ETO_PUR_DATE,'dd-mm-yyyy') AS PUR_DATE,
			ETO_PUR_DATE,
			ETO_OFR_DESC,
			TRIM(ETO_OFR_QTY) ETO_OFR_QTY,
			TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM,
			TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM,
			ETO_OFR_S_IP,
			ETO_OFR_S_IP_COUNTRY,
			DECODE(ETO_OFR_EXPIRED.FK_GL_MODULE_ID,'ETO','https://trade.indiamart.com/', ETO_OFR_PAGE_REFERRER) ETO_OFR_PAGE_REFERRER,
			0 AS EXPIRED,
			(GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
			DECODE(LTRIM(GLUSR_USR_PH_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)) GLUSR_PHONE,
			DECODE(LTRIM(GLUSR_USR_FAX_NUMBER),NULL,NULL,('+' || '(' || GLUSR_USR_FAX_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_FAX_AREA, NULL, NULL,'(' || GLUSR_USR_FAX_AREA || ')' || '-') || GLUSR_USR_FAX_NUMBER)) GLUSR_FAX,
			GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
			GLUSR_USR_PH_MOBILE GLUSR_MOBILE,
			GLUSR_USR_URL ETO_OFR_GLUSR_DISP_URL,
			LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY,
			LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
			LTRIM(GL_COUNTRY_NAME) GLUSR_COUNTRY,
			LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS,
			GLUSR_USR_EMAIL,
			GLUSR_USR_PH_COUNTRY,
			GLUSR_USR_PH_MOBILE_ALT,
			LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP,
			LTRIM(GLUSR_USR_STATE) GLUSR_STATE,
			LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION,
			ETO_CREDITS_USED,
			ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID FK_GLUSR_USR_ID,
			'<FONT COLOR=\"GREEN\">Live</FONT>' ETO_OFR_STATUS,
			NULL ETO_OFR_PREFERED_FK_GLUSR_ID,
			DECODE(ETO_LEAD_FK_GL_MODULE_ID,'HELLOTD','HT','IM') ETO_LEAD_FK_GL_MODULE_ID,
			(SELECT (SUM(ETO_CUST_PURCHASE_AMOUNTPAID)/SUM(ETO_CUST_PURCHASE_CREDITS)) FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND P_H.ETO_CUST_ORDER_ID > -1) AVG_PER_CREDIT_COST,
			NVL((SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),2) GLUSR_STATUS,
			ETO_OFR_EXPIRED.FK_GLUSR_USR_ID BUYER_ID,
			0 PREFERRED_STATUS
		FROM 
			ETO_OFR_EXPIRED, ETO_LEAD_PUR_HIST, GLUSR_USR, GL_COUNTRY
		WHERE 
			FK_ETO_OFR_ID > -1
			AND ETO_OFR_TYP = 'B'
			AND FK_ETO_OFR_ID = ETO_OFR_DISPLAY_ID
			AND ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
			AND GLUSR_USR.FK_GL_COUNTRY_ISO = GL_COUNTRY.GL_COUNTRY_ISO";

		if ($start_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) >= TRUNC(TO_DATE('$start_date','dd-mm-yyyy'))";
		}
		if ($end_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) <= TRUNC(TO_DATE('$end_date','dd-mm-yyyy'))";
		}
		if($modid)
		{
			$sql .= " and ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID = $modid";
		}

		if($client)
		{
			if($client==1)
			{
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) > 0";
			}
			elseif($client==2)
			{	
				$sql .= " AND (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2) is null";
			}			
		}

		$sql .= " ) A ORDER BY ETO_OFR_ID desc, ETO_PUR_DATE desc";
	        $sth1=  pg_query($dbh,$sql); 
	}
	return array($mesg,$sth1);	
	}
}
		