<?php
class  bl_common_report extends CFormModel
{
 public function disphtml($dbh)
  {
   $sql = "SELECT GL_MODULE_ID FROM GL_MODULE ORDER BY GL_MODULE_ID";
   $sth = oci_parse($dbh,$sql);
   oci_execute($sth);
   
   return $sth;
  }
  
  public function lead_summary($dbh,$modval)
  {
   $start_date = ($_REQUEST['s_day']).'-'.($_REQUEST['s_month']).'-'.($_REQUEST['s_year']);
   $end_date = ($_REQUEST['e_day']).'-'.($_REQUEST['e_month']).'-'.($_REQUEST['e_year']);
   
   $condition = '';
    if($modval != 'all')
    {
    $condition = " AND FK_GL_MODULE_ID='$modval'";

    } 
	
  $sql_generated= "SELECT COUNT(DISTINCT ETO_OFR_DISPLAY_ID) 					      TOTAL_LEADS_GEN_THIS_WEEK,
  		      NVL(SUM(
                      CASE
                      WHEN FK_GL_COUNTRY_ISO = 'IN'
                      THEN 1
                      ELSE 0
                      END),0) TOTAL_INDIAN_LEADS,
                      NVL(SUM(
                      CASE
                      WHEN FK_GL_COUNTRY_ISO <> 'IN'
                      THEN 1
                      ELSE 0
                      END),0) TOTAL_FOREIGN_LEADS
 
                      FROM(
			 SELECT ETO_OFR_DISPLAY_ID ,
                         FK_GL_MODULE_ID,
                         FK_ETO_AFL_ID,
                         ETO_OFR_APPROV,
                         FK_GL_COUNTRY_ISO
                         FROM ETO_OFR
                         WHERE ETO_OFR_TYP= 'B'
			 AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC (TO_DATE(:start_date,'DD-MM-YYYY'))
			 AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
			 $condition
UNION
			SELECT ETO_OFR_DISPLAY_ID ,
			FK_GL_MODULE_ID,
			FK_ETO_AFL_ID,
			ETO_OFR_APPROV,FK_GL_COUNTRY_ISO
			FROM ETO_OFR_EXPIRED
			WHERE ETO_OFR_TYP= 'B'
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
			$condition
UNION
			SELECT ETO_OFR_DISPLAY_ID ,
			FK_GL_MODULE_ID,
			FK_ETO_AFL_ID,
			ETO_OFR_APPROV,FK_GL_COUNTRY_ISO
			FROM
			ETO_OFR_TEMP_DEL
			WHERE ETO_OFR_TYP= 'B'
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY'))
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))
			$condition
			) LEADS";
			
		$sth_generated = oci_parse($dbh,$sql_generated);
		oci_bind_by_name($sth_generated,':start_date',$start_date);
		oci_bind_by_name($sth_generated,':end_date',$end_date);
		oci_execute($sth_generated);
                $rec_generated = oci_fetch_assoc($sth_generated);
                
                $sql_approved= "SELECT
        COUNT(DISTINCT ETO_OFR_DISPLAY_ID) LEADS_APPROVED_THIS_WEEK,
        
	COUNT(DISTINCT DECODE(FK_GL_COUNTRY_ISO,'IN',ETO_OFR_DISPLAY_ID,NULL)) LEADS_APPROVED_INDIA,
        
	COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 1 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_VER_ONLY,
	
	COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 3 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_ENRCHD_ONLY,
        
	COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 2 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_VER_ENRCHD,
        COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 0 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_NON_VER,
        
	COUNT(DISTINCT DECODE(FK_GL_COUNTRY_ISO,'IN',NULL,ETO_OFR_DISPLAY_ID)) LEADS_APPROV_FOREIGN,
        
	COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 1 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_VER_ONLY,
        
	COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 3 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_ENRCHD_ONLY,
	
	COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 2 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_VER_ENRCHD,
	
	COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 0 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_NON_VER
FROM
        (
        	SELECT ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, ETO_OFR_VERIFIED 
		FROM ETO_OFR 
		WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= 	TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))$condition
UNION

		SELECT ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, ETO_OFR_VERIFIED FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND TRUNC	(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE(:start_date,'DD-MM-YYYY')) and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE(:end_date,'DD-MM-YYYY'))$condition
        )

";
      $sth_approved = oci_parse($dbh,$sql_approved);
      oci_bind_by_name($sth_approved,':start_date',$start_date);
      oci_bind_by_name($sth_approved,':end_date',$end_date);
      oci_execute($sth_approved);
      $rec_approved = oci_fetch_assoc($sth_approved);
      
      $sql_expired= " SELECT COUNT(1) TOTAL_EXPIRED,
		
		COUNT(DECODE(FK_GL_COUNTRY_ISO,'IN',1,NULL)) TOTAL_IN,
		
		COUNT(DECODE(FK_GL_COUNTRY_ISO,'IN',NULL,1)) TOTAL_FN,
		
		COUNT(DECODE(ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID,NULL,1,NULL)) TOTAL_UNSOLD,
		
		COUNT(DECODE(ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID,NULL,DECODE(FK_GL_COUNTRY_ISO,'IN',1,NULL),NULL)) TOTAL_UNSOLD_IN,
		
		COUNT(DECODE(ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID,NULL,DECODE(FK_GL_COUNTRY_ISO,'IN',NULL,1),NULL)) TOTAL_UNSOLD_FN		
		FROM
		(
		SELECT 
		ETO_OFR_DISPLAY_ID,FK_GL_COUNTRY_ISO
		FROM 
		ETO_OFR_EXPIRED 
		WHERE 
		TRUNC(ETO_OFR_EXP_DATE) >= TO_DATE(:start_date,'DD-MM-YYYY')
		AND TRUNC(ETO_OFR_EXP_DATE) <= TO_DATE(:end_date,'DD-MM-YYYY')
		AND ETO_OFR_TYP='B'
		AND ETO_OFR_APPROV='A' $condition
		) ETO_OFR_EXPIRED,
		(SELECT DISTINCT FK_ETO_OFR_ID FROM ETO_LEAD_PUR_HIST WHERE FK_ETO_OFR_ID > -1)
		ETO_LEAD_PUR_HIST
		WHERE ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID=ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID(+)
		";
   
             $sth_expired = oci_parse($dbh,$sql_expired);
             oci_bind_by_name($sth_expired,':start_date',$start_date);
             oci_bind_by_name($sth_expired,':end_date',$end_date);
             oci_execute($sth_expired);
             $rec_expired = oci_fetch_assoc($sth_expired);
             
             $sql_nosup= "SELECT COUNT(1) TOTAL,
	SUM(CASE WHEN ISO = 'IN' THEN 1 ELSE 0 END) TOTAL_IN,
	SUM(CASE WHEN ISO <> 'IN' THEN 1 ELSE 0 END) TOTAL_FN
	FROM (SELECT
	ETO_OFR_DISPLAY_ID,FK_GL_COUNTRY_ISO ISO ,ETO_OFR_GEOGRAPHY_ID FROM
(SELECT
	B.ETO_OFR_DISPLAY_ID,B.FK_GL_COUNTRY_ISO,B.ETO_OFR_GEOGRAPHY_ID,COUNT(B.FK_GLUSR_USR_ID)
FROM
(
	SELECT
ETO_OFR_DISPLAY_ID,A.FK_GL_COUNTRY_ISO,A.ETO_OFR_GEOGRAPHY_ID,FK_GLUSR_USR_ID
	FROM
	(
		SELECT
			ETO_OFR_DISPLAY_ID,FK_GL_COUNTRY_ISO,ETO_OFR_GEOGRAPHY_ID
		FROM
			ETO_OFR_EXPIRED
		WHERE
			ETO_OFR_EXPIRED.ETO_OFR_TYP = 'B'
			AND ETO_OFR_EXPIRED.ETO_OFR_APPROV = 'A'
			AND TRUNC(ETO_OFR_EXP_DATE) >= TRUNC(TO_DATE(:START_DATE,'DD-MM-YYYY'))
			AND TRUNC(ETO_OFR_EXP_DATE) <= TRUNC(TO_DATE(:END_DATE,'DD-MM-YYYY')) $condition
	)A,
	(
		SELECT FK_ETO_OFR_DISPLAY_ID,FK_GLUSR_USR_ID
		FROM ETO_LEAD_SUPPLIER_MAPPING_EXP WHERE ETO_LEADSUPMAP_PROCESSED <> 9
	) ETO_LEAD_SUPPLIER_MAPPING_EXP
	WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID
	)B,ETO_LEAD_PUR_HIST
WHERE
	B.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID
	AND ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID >-1
	HAVING COUNT(B.FK_GLUSR_USR_ID) = 0
	GROUP BY ETO_OFR_DISPLAY_ID,FK_GL_COUNTRY_ISO,ETO_OFR_GEOGRAPHY_ID))";
	
	$sth_nosup = oci_parse($dbh,$sql_nosup);
	oci_bind_by_name($sth_nosup,':start_date',$start_date);
	oci_bind_by_name($sth_nosup,':end_date',$end_date);
	oci_execute($sth_nosup);
        $rec_nosup = oci_fetch_assoc($sth_nosup);
        
        #**********************************expired unsold + No Supplier ends here*****************

#**********************************Email verified starts here******************************

#=============query for verified and enriched leads by email===========================

		$sql_verifyemail= "SELECT
		COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 THEN ETO_OFR_DISPLAY_ID end ) LEADS_VERIFIED_BY_EMAIL,
		COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 THEN ETO_OFR_DISPLAY_ID end) LEADS_ENRICHED_BY_EMAIL,
		COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 AND FK_GL_COUNTRY_ISO ='IN' THEN ETO_OFR_DISPLAY_ID end ) IN_LEADS_VERIFIED_BY_EMAIL,
		COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 AND FK_GL_COUNTRY_ISO ='IN' THEN ETO_OFR_DISPLAY_ID end) IN_LEADS_ENRICHED_BY_EMAIL,
		COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 AND FK_GL_COUNTRY_ISO !='IN' THEN ETO_OFR_DISPLAY_ID end ) FOR_LEADS_VERIFIED_BY_EMAIL,
		COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 AND FK_GL_COUNTRY_ISO !='IN' THEN ETO_OFR_DISPLAY_ID end) FOR_LEADS_ENRICHED_BY_EMAIL
		FROM (
		SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_VERIFIED,ETO_OFR_EMAIL_VERIFIED,FK_GL_COUNTRY_ISO
		FROM ETO_OFR
		WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=to_date(:start_date,'DD-MM-YYYY')
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=to_date(:end_date,'DD-MM-YYYY')
		$condition
		UNION
		SELECT ETO_OFR_DISPLAY_ID,ETO_OFR_VERIFIED,ETO_OFR_EMAIL_VERIFIED,FK_GL_COUNTRY_ISO
		FROM ETO_OFR_EXPIRED
		WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=to_date(:start_date,'DD-MM-YYYY')
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=to_date(:end_date,'DD-MM-YYYY')
		$condition
		)";
		
	$sth_verifyemail = oci_parse($dbh,$sql_verifyemail);
	oci_bind_by_name($sth_verifyemail,':start_date',$start_date);
	oci_bind_by_name($sth_verifyemail,':end_date',$end_date);
	oci_execute($sth_verifyemail);
	$rec_verifyemail = oci_fetch_assoc($sth_verifyemail);
   
       $sql_verifycall= "SELECT NVL(SUM(A.verified_only),0) as verified
		FROM (
			SELECT
			SUM(CASE when ETO_OFR_VERIFIED=1 then 1 else 0 END) as verified_only,

			SUM(CASE when ETO_OFR_VERIFIED=2 then 1 else 0 END) as verified_updated
			FROM
			ETO_OFR
			WHERE ETO_OFR_TYP = 'B' and ETO_OFR_APPROV='A'
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=trunc(to_date(:start_date,'DD-MM-YYYY'))
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=trunc(to_date(:end_date,'DD-MM-YYYY'))
			$condition
			AND TRIM(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated'
		UNION
			SELECT
			SUM(case when ETO_OFR_VERIFIED=1 then 1 else 0 END) as verified_only,
			sum(case when ETO_OFR_VERIFIED=2 then 1 else 0 END) as verified_updated
		FROM
			ETO_OFR_EXPIRED
			WHERE
			ETO_OFR_TYP = 'B' and eto_ofr_approv='A'
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=to_date(:start_date,'DD-MM-YYYY')
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=to_date(:end_date,'DD-MM-YYYY')
			$condition
			
			AND TRIM(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated'
			) A";
		
		$sth_verifycall = oci_parse($dbh,$sql_verifycall);
		oci_bind_by_name($sth_verifycall,':start_date',$start_date);
		oci_bind_by_name($sth_verifycall,':end_date',$end_date);
		oci_execute($sth_verifycall);
		$rec_verifycall = oci_fetch_assoc($sth_verifycall);
		
		$sql_enrichcall = " 
		
		SELECT COUNT(A.eto_ofr_display_id) AS VERIFIED_UPDATED
		FROM (
			SELECT
			distinct eto_ofr_display_id
			FROM
			ETO_OFR
			WHERE
			ETO_OFR_TYP = 'B' and ETO_OFR_APPROV='A' and eto_ofr_verified=2
			AND ETO_OFR_CALL_VERIFIED IN (1,2)
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=to_date(:start_date,'DD-MM-YYYY')
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=to_date(:end_date,'DD-MM-YYYY')
			and Trim(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated'
			$condition
		
		UNION
			SELECT
			DISTINCT ETO_OFR_DISPLAY_ID
			FROM
			ETO_OFR_EXPIRED
			WHERE
			ETO_OFR_TYP = 'B' and ETO_OFR_APPROV='A' and eto_ofr_verified=2
			AND ETO_OFR_CALL_VERIFIED IN (1,2)
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=to_date(:start_date,'DD-MM-YYYY')
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=to_date(:end_date,'DD-MM-YYYY')
			and Trim(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated'
			$condition
			) A";
			
	$sth_enrichcall = oci_parse($dbh,$sql_enrichcall);
	oci_bind_by_name($sth_enrichcall,':start_date',$start_date);
	oci_bind_by_name($sth_enrichcall,':end_date',$end_date);
	oci_execute($sth_enrichcall);
	$rec_enrichcall = oci_fetch_assoc($sth_enrichcall);








    
    return array($rec_generated,$rec_approved,$rec_expired,$rec_nosup,$rec_verifyemail,$rec_verifycall,$rec_enrichcall);



  }
}



?>