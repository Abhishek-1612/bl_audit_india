<?php
class  Ast_buy_report_model extends CFormModel
{
 public function ASTBUY_Report($dbh)
  {
        $total             = 0;
	$processed         = 0;
	$notProcessed      = 0;
	$sms_processed     = 0;
	$sms_notProcessed  = 0;
	$paid_total        = 0;
	$paid_processed    = 0;
	$paid_notProcessed = 0;
	$pns_total         = 0;
	$pns_processed     = 0;
	$pns_notProcessed  = 0;
	$buylead_total     = 0;
	$buylead_processed = 0;
	$buylead_notProcessed = 0;
	
	if($dbh)
	{	
		$sql = "
		SELECT SUM(1) TOTAL,
		SUM(CASE WHEN ETO_UNSOLD_LEAD_PROCESSED = 1 THEN 1 ELSE 0 END) PROCESSED,
		SUM(CASE WHEN ETO_UNSOLD_LEAD_PROCESSED = 2 THEN 1 ELSE 0 END) NOT_PROCESSED,
		SUM(CASE WHEN ETO_UNSOLD_LEAD_SMS_PROCESSED = 1 THEN 1 ELSE 0 END) SMS_PROCESSED,
		SUM(CASE WHEN ETO_UNSOLD_LEAD_SMS_PROCESSED IS NUll THEN 1 ELSE 0 END) SMS_NOT_PROCESSED
		FROM ETO_UNSOLD_LEAD_MAIL";

		$sth = oci_parse($dbh, $sql);
		if(!$sth)
		{
			$e = oci_error($dbh);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to parse query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		}
		
		$sth1 = oci_execute($sth, OCI_DEFAULT);
		if(!$sth1)
		{
			$e = oci_error($sth);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to execute query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		}
		
		$result1 = oci_fetch_all($sth, $rec_arr1, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);
		foreach($rec_arr1 as $rec1)
		{
			$total = $rec1['TOTAL'];
			$processed = $rec1['PROCESSED'];
			$notProcessed = $rec1['NOT_PROCESSED'];
			$sms_processed = $rec1['SMS_PROCESSED'];
			$sms_notProcessed = $rec1['SMS_NOT_PROCESSED'];
		}
		
		$buylead_sql = " 
			SELECT COUNT(1) TOTAL,
			SUM(CASE WHEN NVL(IIL_FEEDBACK_MAIL_IS_SENT,0) = 1 AND IIL_BL_PAID_FLAG='BUYLEAD' THEN 1 ELSE 0 END) BL_PROCESSED,
			SUM(CASE WHEN NVL(IIL_FEEDBACK_MAIL_IS_SENT,0) = 0 AND IIL_BL_PAID_FLAG='BUYLEAD' THEN 1 ELSE 0 END) BL_NOT_PROCESSED
			FROM IIL_FEEDBACK_MAIL_BL_PAID where  IIL_BL_PAID_FLAG = 'BUYLEAD'";
		
		$sth = oci_parse($dbh, $buylead_sql);
		if(!$sth)
		{
			$e = oci_error($dbh);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to parse query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		} 
		
		$sth1 = oci_execute($sth, OCI_DEFAULT);
		if(!$sth1)
		{
			$e = oci_error($sth);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to execute query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		}
		
		$result2 = oci_fetch_all($sth, $rec_arr2, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);
		
		foreach($rec_arr2 as $rec2)
		{
			$buylead_total = $rec2['TOTAL'];
			$buylead_processed = $rec2['BL_PROCESSED'];
			$buylead_notProcessed = $rec2['BL_NOT_PROCESSED'];
		}
		
		
		$paid_sql = " 
			SELECT COUNT(1) TOTAL,
			SUM(CASE WHEN NVL(IIL_FEEDBACK_MAIL_IS_SENT,0) = 1 AND IIL_BL_PAID_FLAG='PAID' THEN 1 ELSE 0 END) PAID_PROCESSED,
			SUM(CASE WHEN NVL(IIL_FEEDBACK_MAIL_IS_SENT,0) = 0 AND IIL_BL_PAID_FLAG='PAID' THEN 1 ELSE 0 END) PAID_NOT_PROCESSED
			FROM IIL_FEEDBACK_MAIL_BL_PAID where  IIL_BL_PAID_FLAG = 'PAID'";

		$sth = oci_parse($dbh, $paid_sql);
		if(!$sth)
		{
			$e = oci_error($dbh);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to parse query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		}
		
		$sth1 = oci_execute($sth, OCI_DEFAULT);
		if(!$sth1)
		{
			$e = oci_error($sth);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to execute query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		}
		
		$result3 = oci_fetch_all($sth, $rec_arr3, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);
		
		foreach($rec_arr3 as $rec3)
		{
			$paid_total = $rec3['TOTAL'];
			$paid_processed = $rec3['PAID_PROCESSED'];
			$paid_notProcessed = $rec3['PAID_NOT_PROCESSED'];
		}
		
		$pns_sql = " 
			SELECT COUNT(1) TOTAL_PNS,
			SUM(CASE WHEN NVL(IIL_PNS_FLAG,0) = 1 THEN 1 ELSE 0 END) PNS_PROCESSED,
			SUM(CASE WHEN NVL(IIL_PNS_FLAG,0) = 0 THEN 1 ELSE 0 END) PNS_NOT_PROCESSED
			FROM IIL_PNS_FEEDBACK_RECORDS
			WHERE TRUNC(IIL_CUR_DATE)=TRUNC(SYSDATE)";
		
		$sth = oci_parse($dbh, $pns_sql);
		if(!$sth)
		{
			$e = oci_error($dbh);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to parse query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		}
		
		$sth1 = oci_execute($sth, OCI_DEFAULT);
		if(!$sth1)
		{
			$e = oci_error($sth);
			$message = $e['message']." in ". $_SERVER['PWD'] ."/".$_SERVER['PHP_SELF'] ." on line no ".__LINE__; 
			$subject = "Unable to execute query in ASTBUY_Reports.php";
			database_error($subject, $message);
			exit;
		}
		
		$result4 = oci_fetch_all($sth, $rec_arr4, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);
		
		foreach($rec_arr4 as $rec4)
		{
			$pns_total = $rec4['TOTAL_PNS'];
			$pns_processed = $rec4['PNS_PROCESSED'];
			$pns_notProcessed = $rec4['PNS_NOT_PROCESSED'];
		}
		return array($total,$processed,$notProcessed,$sms_processed,$sms_notProcessed,$paid_total,$paid_processed,$paid_notProcessed,$pns_total,$pns_processed,$pns_notProcessed,$buylead_total,$buylead_processed,$buylead_notProcessed);
	}
  
  }
  
}
 