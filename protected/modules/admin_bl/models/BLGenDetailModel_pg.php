<?php

class BLGenDetailModel_pg extends CFormModel
{
	function weeklyshowBLGenerationReport($dbh)
	{
		$retrnArray = array();
		$errArr = array();
		$flagError=0;
		$sth=' ';
		$extract_data='';
		$tot_count=0;
		$tot_aff=0;
		$s_date = $_REQUEST['bdate_year']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_day'];
	
		$start_date = $_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];
	
		$e_date = $_REQUEST['adate_year']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_day'];
	
		$end_date = $_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];
	
		$date = checkdate($_REQUEST['bdate_month'],$_REQUEST['bdate_day'],$_REQUEST['bdate_year']);
		$date1 = checkdate($_REQUEST['adate_month'],$_REQUEST['adate_day'],$_REQUEST['adate_year']);
	// 	$date  = date($s_date);
	//   	$date1 = date($e_date);
	
		if (empty($_REQUEST['bdate_day']) || empty($_REQUEST['bdate_month']) || empty($_REQUEST['bdate_year'])) 
		{
			array_push($errArr,"Please select the complete \'Start\' date");
			$flagError=1;
		}
		elseif(!$date)
		{
			array_push($errArr,"Invalid Start Date");
			$flagError=1;
		}
		
		if (empty($_REQUEST['adate_day']) || empty($_REQUEST['adate_month']) || empty($_REQUEST['adate_year'])) 
		{
			array_push($errArr,"Please select the complete \'End\' date");
			$flagError=1;
		}
		elseif(!$date1)
		{
			array_push($errArr,"Invalid End Date");
			$flagError=1;
		}
	
		if ($flagError==1)
		{
			$mesg = '';
			$mesg =<<<qqq
				<tr><TABLE BORDER="0" WIDTH="100%"><TR>
				<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>
qqq;
			$errorCounter=0;
			foreach ($errArr as $_)
			{
				$errorCounter++;
				$mesg .=" Error $errorCounter: $_<BR>";
			}
			$mesg .="<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
				</TR></TABLE></tr></table>";
		} 
	
		$bdate_day = !empty($REQUEST['bdate_day']) ? $REQUEST['bdate_day'] : '';
		$bdate_month = !empty($REQUEST['bdate_month']) ? $REQUEST['bdate_month'] : '';
		$bdate_year =  !empty($REQUEST['bdate_year']) ? $REQUEST['bdate_year'] : '';
		$adate_day = !empty($REQUEST['adate_day']) ? $REQUEST['adate_day'] : '';
		$adate_month =  !empty($REQUEST['adate_month']) ? $REQUEST['adate_month'] : '';
		$adate_year = !empty($REQUEST['adate_year']) ? $REQUEST['adate_year'] : '';
	
                   
	
	/*  Emktg Gen   */
                    $sql_Regular="SELECT 
                        sum(case when FK_ETO_AFL_ID IN (-15,-16,-17,-18) then 1 else 0 end) REMKTG_GEN,
                        sum(case when FK_ETO_AFL_ID IN (-11,-12,-34,-35,-36,-32,-37,-41) then 1 else 0 end) REG_GEN,
                        sum(case when (fk_eto_afl_id in (-3,-28,-29,-30,-31) OR (nvl(fk_eto_afl_id,0) = 0 and fk_gl_module_id = 'EMKTG')) then 1 else 0 end) REACT_GEN            
                FROM
                    (
                    SELECT  ETO_OFR_DISPLAY_ID,FK_ETO_AFL_ID,fk_gl_module_id 
                    FROM ETO_OFR
                    WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))  AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))  AND ETO_OFR_TYP = 'B' 
                    UNION
                    SELECT  ETO_OFR_DISPLAY_ID,FK_ETO_AFL_ID,fk_gl_module_id 
                    FROM ETO_OFR_EXPIRED
                    WHERE 
                     TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))  AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))  AND ETO_OFR_TYP = 'B' 
                    UNION
                    SELECT  ETO_OFR_DISPLAY_ID,FK_ETO_AFL_ID,fk_gl_module_id 
                    FROM eto_ofr_temp_del
                    WHERE 
                     TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))  AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))  AND ETO_OFR_TYP = 'B' 
                    UNION
                    SELECT ETO_OFR_DISPLAY_ID,FK_ETO_AFL_ID,fk_gl_module_id 
                    FROM eto_ofr_temp_del_arch
                    WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))  AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))  AND ETO_OFR_TYP = 'B'  
                    union
                    select ETO_OFR_DISPLAY_ID,FK_ETO_AFL_ID,query_modid from dir_query_free
                    where trunc(DATE_R) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))  AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
                    and DIR_QUERY_FREE_BL_TYP = 1 AND ETO_OFR_TYP = 'B'                   
                    )   ";
	
	$Rec_Regular= pg_query($dbh,$sql_Regular);
  
	array_push($retrnArray,$Rec_Regular);
        
                    /*  Email Approval */
                    $sql_email_re_activation="SELECT 
                        sum(case when FK_ETO_AFL_ID IN (-15,-16,-17,-18,-19,-20,-51) then 1 else 0 end) REMKTG_APPROVED,
                        sum(case when FK_ETO_AFL_ID IN (-11,-12,-34,-35,-36,-32,-37,-41) then 1 else 0 end) REG_APPROVED,
                        sum(case when (fk_eto_afl_id in (-3,-28,-29,-30,-31) OR (nvl(fk_eto_afl_id,0) = 0 and fk_gl_module_id = 'EMKTG')) then 1 else 0 end) REACT_APPROVED
              
                 FROM
                   (SELECT ETO_OFR_DISPLAY_ID,FK_ETO_AFL_ID,fk_gl_module_id  
                    FROM ETO_OFR
                    WHERE TRUNC(ETO_OFR_APPROV_DATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))  AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) AND ETO_OFR_TYP = 'B' 
		                AND ETO_OFR_APPROV='A' 
                    UNION
                    SELECT ETO_OFR_DISPLAY_ID,FK_ETO_AFL_ID,fk_gl_module_id  
                    FROM ETO_OFR_EXPIRED
                    WHERE
                    TRUNC(ETO_OFR_APPROV_DATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))  AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) AND ETO_OFR_TYP = 'B' 
                    AND ETO_OFR_APPROV='A'                             
                   )";
	
                $Rec_re_activation= pg_query($dbh,$sql_email_re_activation);
               
                array_push($retrnArray,$Rec_re_activation);
      
                  /* Lead with Attachment */
                    $sql_Lead_with_Attachment="SELECT
                            SUM(CASE WHEN (ETO_OFR_ATTACH_IMG_ORIG is not null OR ETO_OFR_ATTACH_DOC_PATH is not null) THEN 1 ELSE 0 END) LEAD_WITH_ATTACHMENT,
                            SUM(CASE WHEN GLUSR_USR_EMAIL is null AND A.FK_GL_COUNTRY_ISO ='IN' THEN 1 ELSE 0 END) MOBILE_ONLY 
                        FROM (
                            SELECT
                                  FK_GLUSR_USR_ID,ETO_OFR_DISPLAY_ID,ETO_OFR_ATTACH_IMG_ORIG,ETO_OFR_ATTACH_DOC_PATH,FK_GL_COUNTRY_ISO
                            FROM
                                  ETO_OFR,ETO_OFR_ATTACHMENT 
                            WHERE
                                FK_ETO_OFR_DISPLAY_ID(+)= ETO_OFR_DISPLAY_ID AND ETO_OFR_TYP = 'B'
                                AND ETO_OFR_APPROV='A'
                                AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
                                and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
                            UNION
                            SELECT
                                  FK_GLUSR_USR_ID,ETO_OFR_DISPLAY_ID,ETO_OFR_ATTACH_IMG_ORIG,ETO_OFR_ATTACH_DOC_PATH,FK_GL_COUNTRY_ISO
                            FROM
                                  ETO_OFR_EXPIRED,ETO_OFR_ATTACHMENT_EXPIRED
                            WHERE
                                FK_ETO_OFR_DISPLAY_ID(+)= ETO_OFR_DISPLAY_ID 
                                AND ETO_OFR_TYP = 'B'
                                AND ETO_OFR_APPROV='A'
                                AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
                                and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
                        )A,
                            GLUSR_USR WHERE GLUSR_USR_ID= FK_GLUSR_USR_ID ";
	
	$Rec_Lead_with_Attachment= pg_query($dbh,$sql_Lead_with_Attachment);
     
	array_push($retrnArray,$Rec_Lead_with_Attachment);
	
        
                          /* Big Buyer Leads   */
        $sql_Big_Buyer_Leads="SELECT 
                                COUNT(1) TOTAL_APPROVED,
                                COUNT (CASE WHEN BIG_BUYER IS NOT NULL THEN 1 END) BIG_BUYER_APPROVED,                                
                                COUNT (CASE WHEN BIG_BUYER IS NOT NULL AND USER_IDENTIFIER_FLAG =5 THEN 1 END) BIG_BUYER_5,
                                COUNT (CASE WHEN BIG_BUYER IS NOT NULL AND USER_IDENTIFIER_FLAG =6 THEN 1 END) BIG_BUYER_6,
                                COUNT (CASE WHEN BIG_BUYER IS NOT NULL AND USER_IDENTIFIER_FLAG  NOT IN( 5,6) THEN 1 END) BIG_BUYER_NULL
                             FROM
                             (
                             SELECT 
                                ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG,   
                                CASE WHEN A.FK_GLUSR_USR_ID IS NOT NULL THEN A.FK_GLUSR_USR_ID END BIG_BUYER
                             FROM ETO_OFR OFR,GLUSR_USR,IIL_BIG_BUYER_TO_GLUSR A 
                             WHERE 
                             GLUSR_USR_ID=OFR.FK_GLUSR_USR_ID 
                             AND OFR.FK_GLUSR_USR_ID = A.FK_GLUSR_USR_ID(+) AND GLUSR_USR.FK_GL_COUNTRY_ISO='IN' 
                             AND ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' 
                             AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE('$start_date','DD-MM-YYYY')
                             AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE('$end_date','DD-MM-YYYY')
                             UNION 
                             SELECT 
                                ETO_OFR_DISPLAY_ID,  USER_IDENTIFIER_FLAG,  
                                CASE WHEN A.FK_GLUSR_USR_ID IS NOT NULL THEN A.FK_GLUSR_USR_ID END BIG_BUYER
                             FROM ETO_OFR_EXPIRED OFR,GLUSR_USR,IIL_BIG_BUYER_TO_GLUSR A 
                             WHERE 
                             GLUSR_USR_ID=OFR.FK_GLUSR_USR_ID 
                             AND OFR.FK_GLUSR_USR_ID = A.FK_GLUSR_USR_ID(+) AND GLUSR_USR.FK_GL_COUNTRY_ISO='IN' 
                             AND ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' 
                             AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE('$start_date','DD-MM-YYYY')
                             AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE('$end_date','DD-MM-YYYY')
                             )";
	
	$Rec_Big_Buyer_Leads= pg_query($dbh,$sql_Big_Buyer_Leads);
       
	array_push($retrnArray,$Rec_Big_Buyer_Leads);
        
        
                                  /* Retail Leads Approved    */
        $sql_Retail_Leads_Approved ="SELECT 
                                        COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=1 THEN ETO_OFR_DISPLAY_ID END)RETAIL,
                                        COUNT(CASE WHEN ETO_ENQ_TYP=1 THEN FK_ETO_OFR_ID END) TOTAL_PURCHASED,
                                        COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=1 THEN FK_ETO_OFR_ID END) UNIQ_PURCHASED
                                    FROM
                                    (
                                    SELECT ETO_OFR_DISPLAY_ID,ETO_ENQ_TYP FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
                                    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE('$start_date','DD-MM-YYYY')
                                    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE('$end_date','DD-MM-YYYY')
                                    UNION
                                    SELECT ETO_OFR_DISPLAY_ID,ETO_ENQ_TYP FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
                                    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE('$start_date','DD-MM-YYYY')
                                    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE('$end_date','DD-MM-YYYY')
                                    )ETO_OFR,
                                    ETO_LEAD_PUR_HIST
                                    WHERE 
                                    ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID(+)";
	
	$Rec_Retail_Leads_Approved= pg_query($dbh,$sql_Retail_Leads_Approved);
        
	array_push($retrnArray,$Rec_Retail_Leads_Approved);
        
            
		$sql2="SELECT
		SUM(CASE WHEN FK_GL_MODULE_ID <>'FENQ' THEN 1 ELSE 0 END) DIRECT_LEAD_GENRATION,
		SUM(CASE WHEN ETO_OFR_APPROV = 'A' THEN 1 ELSE 0 END) TOTAL_LEADS_APPROVED_THIS_WEEK,
		SUM(CASE WHEN ETO_OFR_APPROV = 'W' AND FLAG=1 THEN 1 ELSE 0 END) TOTAL_LEADS_WAITING_THIS_WEEK,
		SUM(CASE WHEN ETO_OFR_APPROV = 'W' AND FLAG=1 AND FK_GL_MODULE_ID='FENQ' THEN 1 ELSE 0 END) FENQ_LEADS_WAITING_THIS_WEEK,
		SUM(CASE WHEN ETO_OFR_APPROV = 'W' AND FLAG=1 AND FK_GL_MODULE_ID!='FENQ' THEN 1 ELSE 0 END) DIRECT_LEADS_WAITING_THIS_WEEK,
		SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) NOT IN (-1,-2,-5,-7,-6,-3,-9,-4,-8,535,765,766,767,471) AND FK_GL_MODULE_ID IN 	('Z3EBD','ZAFRBUS','ZAHI','ZALCALA','ZALTIND','ZAPPSRCH','ZARBET','ZATGLB','ZB4IND','ZBLDTRKY','ZBSYTRDE', 'ZDBAICHM', 'ZDDEX', 'ZDMINDON', 'ZEKERALA', 'ZENF', 	'ZFOODMCH', 'ZFRNTRAD', 'ZFTASIA', 'ZGLOBAL', 'ZGRUPOF3', 'ZIDEA', 'ZIIFJS', 'ZIMP', 'ZINCNST', 'ZINDASTP', 'ZINDMAAL', 'ZINDSTK', 'ZINDSVE', 'ZINFUR','ZJETC', 'ZLCHAAT', 'ZLIVELST', 'ZMAST', 'ZMFINDIA', 'ZMKTUSA', 'ZMYCITY', 'ZMYTRADE', 'ZPESCAL', 'ZPINDEX', 'ZPRINTCT', 'ZPWEB', 'ZSHWMRT', 'ZSURAJ', 		'ZTDRCHN', 'ZTRADPLY', 'ZTRDEB2B', 'ZTRDEWRD', 'ZTRDEXL', 'ZTRDNMAP', 'ZTRDXPRO', 'ZTRSEAFD', 'ZUKWHOLE', 'ZWHLEUK', 'ZWHVAC', 'ZWTRADE', 'ZYPG', 'BLAFFLT') THEN 1 ELSE 0 END) LEADS_FROM_EXTERNAL_AFF_NEW,
		SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) IN (535,765,766,767) THEN 1 ELSE 0 END) ADWORD,
		SUM(CASE WHEN ETO_OFR_APPROV = 'A' AND NVL(FK_ETO_AFL_ID,0) IN (471) THEN 1 ELSE 0 END) SLIDESHARE
	FROM
		(
			SELECT 1 FLAG,
			ETO_OFR_DISPLAY_ID ,
			FK_GL_MODULE_ID,
			FK_ETO_AFL_ID,
			ETO_OFR_APPROV,
			FK_GL_COUNTRY_ISO
			FROM ETO_OFR
			WHERE ETO_OFR_TYP                 = 'B'
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
			AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
			UNION
			SELECT 1 FLAG,
			ETO_OFR_DISPLAY_ID ,
			QUERY_MODID FK_GL_MODULE_ID,
			FK_ETO_AFL_ID,
			ETO_OFR_APPROV,
			FK_GL_COUNTRY_ISO
			FROM DIR_QUERY_FREE
			WHERE ETO_OFR_TYP         = 'B'
			AND DIR_QUERY_FREE_BL_TYP = 1
			AND TRUNC(DATE_R)        >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
			AND TRUNC(DATE_R)        <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))

			UNION
		
			SELECT NULL FLAG,ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV,FK_GL_COUNTRY_ISO  FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B'  
                        AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
		
			UNION
		
			SELECT NULL FLAG,ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV,FK_GL_COUNTRY_ISO  FROM ETO_OFR_TEMP_DEL WHERE ETO_OFR_TYP = 'B'  
                        AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
			union
			SELECT NULL FLAG,ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV,FK_GL_COUNTRY_ISO  FROM ETO_OFR_TEMP_DEL_ARCH WHERE ETO_OFR_TYP = 'B'  
                        AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
		) LEADS ";
	
		$sthTotalGen = pg_query($dbh,$sql2);
                
		array_push($retrnArray,$sthTotalGen);
	
		$afl_content='';
		
		$sql22="
			SELECT COUNT(FK_GLUSR_USR_ID) TOT_FENQ,
			SUM(CASE WHEN FLAG=2 THEN 1 ELSE 0  END) PENDING_FENQ,
			SUM(CASE WHEN QUERY_MODID='IMOB' THEN 1 ELSE 0  END) TOT_IMOB_FENQ,
			SUM(CASE WHEN QUERY_MODID='INTENT' THEN 1 ELSE 0  END) TOT_INTENT_FENQ,
			SUM(CASE WHEN QUERY_MODID='SINTENT' THEN 1 ELSE 0  END) TOT_SINTENT_FENQ,
			SUM(CASE WHEN QUERY_MODID='CINTENT' THEN 1 ELSE 0  END) TOT_CINTENT_FENQ,
			SUM(CASE WHEN QUERY_MODID not in ('IMOB','INTENT','SINTENT','CINTENT')THEN 1 ELSE 0  END) TOT_OTHER_FENQ
			FROM (
			SELECT 
				1 FLAG, FK_GLUSR_USR_ID ,QUERY_MODID
			FROM 
				ETO_OFR_FROM_FENQ 
			WHERE 
				TRUNC(DATE_R) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
				AND TRUNC(DATE_R) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
			UNION ALL
			SELECT 
				1 FLAG, FK_GLUSR_USR_ID ,QUERY_MODID
			FROM 
				ETO_OFR_FROM_FENQ_ARCH
			WHERE 
				TRUNC(DATE_R) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
				AND TRUNC(DATE_R) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
			UNION ALL
			SELECT 
				2 FLAG, FK_GLUSR_USR_ID ,QUERY_MODID
			FROM 
				DIR_QUERY_FREE
			WHERE 
				TRUNC(DATE_R) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
				AND TRUNC(DATE_R) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
				AND DIR_QUERY_FREE_BL_TYP = 2) ";
	
		$sthTotalFenq = pg_query($dbh,$sql22);
              
		array_push($retrnArray,$sthTotalFenq);
	
	
	//########## FENQ APPROVAL COUNT QUERY ####################
	
		$sql22="
			SELECT 
				COUNT(ETO_OFR_DISPLAY_ID) FENQ_APPROVED,
				SUM(CASE WHEN  FK_GL_COUNTRY_ISO='IN' THEN 1 ELSE 0 END) FENQ_IN_APPROVED,
				SUM(CASE WHEN  FK_GL_COUNTRY_ISO!='IN' THEN 1 ELSE 0 END) FENQ_FOREIGN_APPROVED
			FROM (
			SELECT
				DISTINCT ETO_OFR_DISPLAY_ID ETO_OFR_DISPLAY_ID,FK_GL_COUNTRY_ISO
			FROM
				(SELECT FK_ETO_OFR_ID,QUERY_MODID,FK_QUERY_ID FROM ETO_OFR_FROM_FENQ
				UNION all
				SELECT FK_ETO_OFR_ID,QUERY_MODID,FK_QUERY_ID FROM ETO_OFR_FROM_FENQ_ARCH
				) B,
				(
					SELECT 
						ETO_OFR_DISPLAY_ID,FK_GL_COUNTRY_ISO
					FROM 
						ETO_OFR 
					WHERE 
						ETO_OFR_TYP = 'B' 
						AND ETO_OFR_APPROV='A'  AND FK_GL_MODULE_ID = 'FENQ'
						AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
						AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
					UNION
					SELECT 
						ETO_OFR_DISPLAY_ID,FK_GL_COUNTRY_ISO
					FROM 
						ETO_OFR_EXPIRED 
					WHERE 
						ETO_OFR_TYP = 'B' 
						AND ETO_OFR_APPROV='A' AND FK_GL_MODULE_ID = 'FENQ'
						AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
						AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
				) A
			WHERE 
				FK_ETO_OFR_ID= ETO_OFR_DISPLAY_ID
			)  ";
		$sthFenqApproval = pg_query($dbh,$sql22);
               
		array_push($retrnArray,$sthFenqApproval);
	
	
	
		$sql1="SELECT
		COUNT(DISTINCT ETO_OFR_DISPLAY_ID) LEADS_APPROVED_THIS_WEEK,
		COUNT(DISTINCT DECODE(FK_GL_COUNTRY_ISO,'IN',ETO_OFR_DISPLAY_ID,NULL)) LEADS_APPROVED_INDIA,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 1 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_VER_ONLY,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 3 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_ENRCHD_ONLY,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 2 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_VER_ENRCHD,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO = 'IN' and ETO_OFR_VERIFIED = 0 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_INDIA_NON_VER,
		COUNT(DISTINCT DECODE(FK_GL_COUNTRY_ISO,'IN',NULL,ETO_OFR_DISPLAY_ID)) LEADS_GEN_FOREIGN,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 1 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_VER_ONLY,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 3 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_ENRCHD_ONLY,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 2 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_VER_ENRCHD,
		COUNT(DECODE( (CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' and ETO_OFR_VERIFIED = 0 THEN 1 ELSE 0 END),1,1,NULL)) LEADS_FOREIGN_NON_VER,
		SUM(CASE WHEN  FK_GL_MODULE_ID!='FENQ' THEN 1 ELSE 0 END) DIRECT_APPROVED,
		SUM(CASE WHEN  FK_GL_MODULE_ID!='FENQ' AND FK_GL_COUNTRY_ISO='IN' THEN 1 ELSE 0 END) DIRECT_IN_APPROVED, 
		SUM(CASE WHEN  FK_GL_MODULE_ID!='FENQ' AND FK_GL_COUNTRY_ISO!='IN' THEN 1 ELSE 0 END) DIRECT_FOREIGN_APPROVED,
		SUM(CASE WHEN  FK_GL_MODULE_ID='FENQ' THEN 1 ELSE 0 END) FENQ_APPROVED,
		SUM(CASE WHEN  FK_GL_MODULE_ID='FENQ' AND FK_GL_COUNTRY_ISO='IN' THEN 1 ELSE 0 END) FENQ_IN_APPROVED,
		SUM(CASE WHEN  FK_GL_MODULE_ID='FENQ' AND FK_GL_COUNTRY_ISO!='IN' THEN 1 ELSE 0 END) FENQ_FOREIGN_APPROVED,
		SUM(CASE WHEN NVL(FK_ETO_AFL_ID,0) NOT IN (-1,-2,-5,-7,-6,-3,-9,-4,-8,535,765,766,767,471) AND FK_GL_MODULE_ID IN 	('Z3EBD','ZAFRBUS','ZAHI','ZALCALA','ZALTIND','ZAPPSRCH','ZARBET','ZATGLB','ZB4IND','ZBLDTRKY','ZBSYTRDE', 'ZDBAICHM', 'ZDDEX', 'ZDMINDON', 'ZEKERALA', 'ZENF', 	'ZFOODMCH', 'ZFRNTRAD', 'ZFTASIA', 'ZGLOBAL', 'ZGRUPOF3', 'ZIDEA', 'ZIIFJS', 'ZIMP', 'ZINCNST', 'ZINDASTP', 'ZINDMAAL', 'ZINDSTK', 'ZINDSVE', 'ZINFUR','ZJETC', 'ZLCHAAT', 'ZLIVELST', 'ZMAST', 'ZMFINDIA', 'ZMKTUSA', 'ZMYCITY', 'ZMYTRADE', 'ZPESCAL', 'ZPINDEX', 'ZPRINTCT', 'ZPWEB', 'ZSHWMRT', 'ZSURAJ', 		'ZTDRCHN', 'ZTRADPLY', 'ZTRDEB2B', 'ZTRDEWRD', 'ZTRDEXL', 'ZTRDNMAP', 'ZTRDXPRO', 'ZTRSEAFD', 'ZUKWHOLE', 'ZWHLEUK', 'ZWHVAC', 'ZWTRADE', 'ZYPG', 'BLAFFLT') THEN 1 ELSE 0 END) LEADS_FROM_EXTERNAL_AFF_NEW,
		SUM(CASE WHEN NVL(FK_ETO_AFL_ID,0) IN (471) THEN 1 ELSE 0 END) SLIDESHARE
	FROM
	(
		SELECT 
		ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, ETO_OFR_VERIFIED,FK_GL_MODULE_ID,FK_ETO_AFL_ID
		FROM 
		ETO_OFR 
		WHERE 
		ETO_OFR_TYP = 'B' 
		AND ETO_OFR_APPROV='A' 
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
		and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		UNION
		SELECT 
		ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, ETO_OFR_VERIFIED,FK_GL_MODULE_ID,FK_ETO_AFL_ID
		FROM 
		ETO_OFR_EXPIRED 
		WHERE 
		ETO_OFR_TYP = 'B' 
		AND ETO_OFR_APPROV='A' 
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
		and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
	)
	";
	$sthApproval = pg_query($dbh,$sql1);
       
	array_push($retrnArray,$sthApproval);
	
	
		$sql_mod="select FK_GL_MODULE_ID,count(FK_GL_MODULE_ID) CNT 
		FROM
	(
		SELECT 
		ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, FK_GL_MODULE_ID
		FROM 
		ETO_OFR 
		WHERE 
		ETO_OFR_TYP = 'B' 
		AND ETO_OFR_APPROV='A' 
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
		and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		UNION
		SELECT 
		ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, FK_GL_MODULE_ID 
		FROM 
		ETO_OFR_EXPIRED 
		WHERE 
		ETO_OFR_TYP = 'B' 
		AND ETO_OFR_APPROV='A' 
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
		and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
	) group by FK_GL_MODULE_ID
	order by FK_GL_MODULE_ID desc
	";
	$sth_mod = pg_query($dbh,$sql_mod);
       
	array_push($retrnArray,$sth_mod);
	
	$sql_bl_flag= "select (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA where IIL_MASTER_DATA_VALUE=fk_eto_afl_id and FK_IIL_MASTER_DATA_TYPE_ID=12) || ' (AFLID- ' || fk_eto_afl_id ||')' AFL_NAME, CNT
	from (
	select fk_eto_afl_id,count(ETO_OFR_DISPLAY_ID) CNT
		FROM
	(
		SELECT 
		ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, fk_eto_afl_id
		FROM 
		ETO_OFR 
		WHERE 
		ETO_OFR_TYP = 'B' 
		AND ETO_OFR_APPROV='A' and NVL(FK_ETO_AFL_ID,0) <0
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
		and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		UNION
		SELECT 
		ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, fk_eto_afl_id 
		FROM 
		ETO_OFR_EXPIRED 
		WHERE 
		ETO_OFR_TYP = 'B' 
		AND ETO_OFR_APPROV='A' and NVL(FK_ETO_AFL_ID,0) <0
		AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
		and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
	) group by fk_eto_afl_id
	)
	order by AFL_NAME,fk_eto_afl_id";
	
	$sth_bl_flag = pg_query($dbh,$sql_bl_flag);
       
	array_push($retrnArray,$sth_bl_flag);
	
		$sql_fenq=" 
				SELECT 
					B.QUERY_MODID QUERY_MODID, COUNT(B.FK_ETO_OFR_ID) TOTAL_FENQ_APPROV
				FROM
				(	SELECT FK_ETO_OFR_ID,QUERY_MODID,FK_QUERY_ID FROM ETO_OFR_FROM_FENQ
					UNION ALL
					SELECT FK_ETO_OFR_ID,QUERY_MODID,FK_QUERY_ID FROM ETO_OFR_FROM_FENQ_ARCH 
				) B,
				(
				SELECT 
					ETO_OFR_DISPLAY_ID
				FROM 
					ETO_OFR 
				WHERE 
					ETO_OFR_TYP = 'B' 
					AND ETO_OFR_APPROV='A'  AND FK_GL_MODULE_ID = 'FENQ'
					AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
					AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
				UNION
				SELECT 
					ETO_OFR_DISPLAY_ID
				FROM 
					ETO_OFR_EXPIRED 
				WHERE 
					ETO_OFR_TYP = 'B' 
					AND ETO_OFR_APPROV='A' AND FK_GL_MODULE_ID = 'FENQ'
					AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
					AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
				) A
				WHERE 
					FK_ETO_OFR_ID= ETO_OFR_DISPLAY_ID
					--AND FK_ETO_OFR_ID IS NOT NULL
					--AND TRUNC(ETO_OFR_FENQ_DATE)>=TO_DATE('$start_date','DD-MM-YYYY') 
					--AND TRUNC(ETO_OFR_FENQ_DATE)<=TO_DATE('$end_date','DD-MM-YYYY')
					GROUP BY QUERY_MODID
					ORDER BY QUERY_MODID ";
	
		$sth_fenq = pg_query($dbh,$sql_fenq);
                
		array_push($retrnArray,$sth_fenq);
		
		$sql_fenq_rej="SELECT SUM(REJ_CNT) FENQ_REJ_COUNT,
				SUM(IMOB_REJ) IMOB_REJ,
				SUM(INTENT_REJ) INTENT_REJ,
				SUM(SINTENT_REJ) SINTENT_REJ,
				SUM(CINTENT_REJ) CINTENT_REJ,
				SUM(OTHER_REJ) OTHER_REJ FROM
				(
				SELECT COUNT(FK_GLUSR_USR_ID) REJ_CNT ,
				SUM(CASE WHEN QUERY_MODID='IMOB' THEN 1 ELSE 0 END) IMOB_REJ,
				SUM(CASE WHEN QUERY_MODID='INTENT' THEN 1 ELSE 0 END) INTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='SINTENT' THEN 1 ELSE 0 END) SINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='CINTENT' THEN 1 ELSE 0 END) CINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID not in ('SINTENT','INTENT','IMOB','CINTENT') THEN 1 ELSE 0 END) OTHER_REJ
				FROM ETO_OFR_FROM_FENQ
				WHERE FK_ETO_OFR_ID IS NULL
				AND TRUNC(ETO_OFR_FENQ_DATE)>=TO_DATE('$start_date','DD-MM-YYYY') 
				AND TRUNC(ETO_OFR_FENQ_DATE)<=TO_DATE('$end_date','DD-MM-YYYY')
				UNION ALL
				SELECT COUNT(FK_GLUSR_USR_ID) REJ_CNT ,
				SUM(CASE WHEN QUERY_MODID='IMOB' THEN 1 ELSE 0 END) IMOB_REJ,
				SUM(CASE WHEN QUERY_MODID='INTENT' THEN 1 ELSE 0 END) INTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='SINTENT' THEN 1 ELSE 0 END) SINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='CINTENT' THEN 1 ELSE 0 END) CINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID not in ('SINTENT','INTENT','IMOB','CINTENT') THEN 1 ELSE 0 END) OTHER_REJ
				FROM ETO_OFR_FROM_FENQ_ARCH
				WHERE FK_ETO_OFR_ID IS NULL
				AND TRUNC(ETO_OFR_FENQ_DATE)>=TO_DATE('$start_date','DD-MM-YYYY') 
				AND TRUNC(ETO_OFR_FENQ_DATE)<=TO_DATE('$end_date','DD-MM-YYYY')
				UNION ALL
				SELECT COUNT(ETO_OFR_DISPLAY_ID) REJ_CNT ,
				SUM(CASE WHEN QUERY_MODID='IMOB' THEN 1 ELSE 0 END) IMOB_REJ,
				SUM(CASE WHEN QUERY_MODID='INTENT' THEN 1 ELSE 0 END) INTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='SINTENT' THEN 1 ELSE 0 END) SINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='CINTENT' THEN 1 ELSE 0 END) CINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID not in ('SINTENT','INTENT','IMOB','CINTENT') THEN 1 ELSE 0 END) OTHER_REJ
				FROM ETO_OFR_TEMP_DEL A,ETO_OFR_FROM_FENQ B
				WHERE  ETO_OFR_TYP = 'B' AND B.FK_ETO_OFR_ID=A.ETO_OFR_DISPLAY_ID
				AND FK_GL_MODULE_ID = 'FENQ'
				AND TRUNC(ETO_OFR_DELETIONDATE) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
				AND TRUNC(ETO_OFR_DELETIONDATE) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
				UNION ALL
				SELECT COUNT(ETO_OFR_DISPLAY_ID) REJ_CNT ,
				SUM(CASE WHEN QUERY_MODID='IMOB' THEN 1 ELSE 0 END) IMOB_REJ,
				SUM(CASE WHEN QUERY_MODID='INTENT' THEN 1 ELSE 0 END) INTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='SINTENT' THEN 1 ELSE 0 END) SINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID='CINTENT' THEN 1 ELSE 0 END) CINTENT_REJ,
				SUM(CASE WHEN QUERY_MODID not in ('SINTENT','INTENT','IMOB','CINTENT') THEN 1 ELSE 0 END) OTHER_REJ
				FROM ETO_OFR_TEMP_DEL_ARCH A,ETO_OFR_FROM_FENQ B
				WHERE  ETO_OFR_TYP = 'B' AND B.FK_ETO_OFR_ID=A.ETO_OFR_DISPLAY_ID
				AND FK_GL_MODULE_ID = 'FENQ'
				AND TRUNC(ETO_OFR_DELETIONDATE) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
				AND TRUNC(ETO_OFR_DELETIONDATE) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
				) ";
	
		$sth_fenq_rej = pg_query($dbh,$sql_fenq_rej);
		array_push($retrnArray,$sth_fenq_rej);
	
	
		$sql_gen_rej="SELECT COUNT(ETO_OFR_DISPLAY_ID) GEN_REJ_CNT FROM
					(
					SELECT ETO_OFR_DISPLAY_ID
					FROM ETO_OFR_TEMP_DEL
					WHERE ETO_OFR_TYP                = 'B'
					AND FK_GL_MODULE_ID             <> 'FENQ'
					AND TRUNC(ETO_OFR_DELETIONDATE) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
					AND TRUNC(ETO_OFR_DELETIONDATE) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
					UNION
					SELECT ETO_OFR_DISPLAY_ID
					FROM ETO_OFR_TEMP_DEL_ARCH
					WHERE ETO_OFR_TYP                = 'B'
					AND FK_GL_MODULE_ID             <> 'FENQ'
					AND TRUNC(ETO_OFR_DELETIONDATE) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
					AND TRUNC(ETO_OFR_DELETIONDATE) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
					)";
	
		$sth_gen_rej = pg_query($dbh,$sql_gen_rej);
		array_push($retrnArray,$sth_gen_rej);	
	
	$sthZeroCreadit='';
	array_push($retrnArray,$sthZeroCreadit);
	
        $sthTotalRepeat='';
	array_push($retrnArray,$sthTotalRepeat);
        $sthTotalRepeat3Mon='';
	array_push($retrnArray,$sthTotalRepeat3Mon);
	//### Repeat in Last 12 Months ######
        $sthTotalRepeat12Mon='';
	array_push($retrnArray,$sthTotalRepeat12Mon);
	

	
	
	$sql_mod="select FK_GL_MODULE_ID,count(FK_GL_MODULE_ID) CNT
		FROM
		(
			SELECT 
				ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, FK_GL_MODULE_ID
			FROM 
				ETO_OFR 
			WHERE 
				ETO_OFR_TYP = 'B' 
				AND ETO_OFR_APPROV='A'  and NVL(FK_ETO_AFL_ID,0) <0
				AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
				and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
			UNION
			SELECT 
				ETO_OFR_DISPLAY_ID, FK_GL_COUNTRY_ISO, FK_GL_MODULE_ID 
			FROM 
				ETO_OFR_EXPIRED 
			WHERE 
				ETO_OFR_TYP = 'B' 
				AND ETO_OFR_APPROV='A' and NVL(FK_ETO_AFL_ID,0) <0
				AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) 
				and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		) group by FK_GL_MODULE_ID
		order by CNT desc
	";
	
	$sql10="SELECT
		FK_GL_MODULE_ID, COUNT(ETO_OFR_DISPLAY_ID) OFR_CNT
	FROM 
	(
		SELECT 
			ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV,FK_GL_COUNTRY_ISO 
		FROM 
			ETO_OFR 
		WHERE 
			ETO_OFR_TYP = 'B'  
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
			and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
			AND NVL(FK_ETO_AFL_ID,0) >= 0
			AND FK_GL_MODULE_ID IN ('MY','ETO','CTL','DIR','FCP','TDR','SEM')
			AND ETO_OFR_APPROV='A'
	
		UNION
	
		SELECT 
			ETO_OFR_DISPLAY_ID , FK_GL_MODULE_ID,FK_ETO_AFL_ID,ETO_OFR_APPROV,FK_GL_COUNTRY_ISO 
		FROM 
			ETO_OFR_EXPIRED 
		WHERE 
			ETO_OFR_TYP = 'B'  
			AND TRUNC(ETO_OFR_APPROV_DATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
			and TRUNC(ETO_OFR_APPROV_DATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
			AND NVL(FK_ETO_AFL_ID,0) >= 0
			AND FK_GL_MODULE_ID IN ('MY','ETO','CTL','DIR','FCP','TDR','SEM')
			AND ETO_OFR_APPROV='A'
	)
	GROUP BY FK_GL_MODULE_ID ";
	
	$sthMainMyForm= pg_query($dbh,$sql10);
        

	array_push($retrnArray,$sthMainMyForm);
	
	
	$sthJSFormMod= pg_query($dbh,$sql_mod);
        
	
	array_push($retrnArray,$sthJSFormMod);
	
	
	$sql_adword_only="select sum(APPROVED_CNT) ADWORD from 
    (
    SELECT count(distinct(ETO_OFR_DISPLAY_ID)) approved_cnt FROM ETO_OFR WHERE  TRUNC(ETO_OFR_APPROV_DATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
    AND (ETO_OFR_PAGE_REFERRER LIKE '%buyertraffic%' OR ETO_OFR_PAGE_REFERRER LIKE '%DSA%')
    union
    SELECT count(distinct(ETO_OFR_DISPLAY_ID))approved_cnt FROM ETO_OFR_EXPIRED WHERE  TRUNC(ETO_OFR_APPROV_DATE_ORIG) BETWEEN TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) AND TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
    AND (ETO_OFR_PAGE_REFERRER LIKE '%buyertraffic%' OR ETO_OFR_PAGE_REFERRER LIKE '%DSA%')
    )";

        $sth_adword_only= pg_query($dbh,$sql_adword_only);
     	array_push($retrnArray,$sth_adword_only);
        
      
	return $retrnArray;
	}
	
	public function weeklyshowBLGenerationDemandReport($dbh,$start_date,$end_date)
	{
	
	$sql5="select   FK_GLUSR_USR_ID , CRD_AV
     from
       (
         select FK_GLUSR_USR_ID ,
         (
          sum(ETO_CUST_PURCHASE_CREDITS)
         -
         (
           ( NVL( (select sum(ETO_CREDITS_USED) from ETO_LEAD_PUR_HIST where
           TRUNC(ETO_PUR_DATE) < TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
           and ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = ETO_CUST_PURCHASE_HIST.FK_GLUSR_USR_ID),0) )
           +
           (NVL( (select sum(GLUSR_DBM_CREDITS) from GLUSR_DBM_CONTACT where
           GLUSR_DBM_CONTACT.FK_GLUSR_USR_ID = ETO_CUST_PURCHASE_HIST.FK_GLUSR_USR_ID
           and GLUSR_DBM_CONTACT.GLUSR_DBM_CONTACT_DATE < TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) ),0 ) )
         )
         ) CRD_AV
         from ETO_CUST_PURCHASE_HIST
         where TRUNC(ETO_CUST_PURCHASE_DATE) < TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
         group by FK_GLUSR_USR_ID  
      )A";
		
	$sthZeroCreadit = pg_query($dbh,$sql5);      	
	
	### Repeat in Last 12 Months ######
	
 	$sql8="SELECT
		COUNT (DISTINCT A.FK_GLUSR_USR_ID) TOTAL_REPEAT_12_MONTHS
		FROM
		(
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		UNION
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		) A,
		(
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE('$start_date','DD-MM-YYYY')),-12) AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		UNION
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE('$start_date','DD-MM-YYYY')),-12) AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		) B
		WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID";
 	
 	$sthTotalRepeat12Mon = pg_query($dbh,$sql8);
   
	
	//### Repeat in Last 3 Months ######
	
 	$sql7="SELECT
		COUNT (DISTINCT A.FK_GLUSR_USR_ID) TOTAL_REPEAT_3_MONTHS
		FROM
		(
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		UNION
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		) A,
		(
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE('$start_date','DD-MM-YYYY')),-3) AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		UNION
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG)>= ADD_MONTHS(TRUNC(TO_DATE('$start_date','DD-MM-YYYY')),-3) AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		) B
		WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID";
 	
 	$sthTotalRepeat3Mon = pg_query($dbh,$sql7);
       	
	//### Repeat Buyer ##########
	
 	$sql6="SELECT
		COUNT (DISTINCT A.FK_GLUSR_USR_ID) TOTAL_REPEAT
		FROM
		(
		SELECT DISTINCT FK_GLUSR_USR_ID
		FROM ETO_OFR
		WHERE ETO_OFR_TYP = 'B'
		AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		UNION
		SELECT DISTINCT FK_GLUSR_USR_ID
		FROM ETO_OFR_EXPIRED
		WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
		) A,
		(
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		UNION
		SELECT DISTINCT FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A'
		AND TRUNC(ETO_OFR_POSTDATE_ORIG) < TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
		) B
		WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID";
 	
 	 $sthTotalRepeat = pg_query($dbh,$sql6);
         	
	
	$sql9="SELECT
                COUNT(DISTINCT ETO_OFR_DISPLAY_ID) IM_CUSTOMER,
                SUM(CASE WHEN CUSTTYPE_ID IN(1,2,4,7,8,10,12,13,15,16,21,24,26) THEN 1 ELSE 0 END )IM_PAID_CUSTOMER,
                SUM(CASE WHEN IS_CATALOG = -1 THEN 1 ELSE 0 END) CATALOG,
                SUM(CASE WHEN CUSTTYPE_ID IN(8,16,21,24,26) THEN 1 ELSE 0 END) BL,
                SUM(CASE WHEN CUSTTYPE_ID IN(5,23,25,27) THEN 1 ELSE 0 END) OTHERS_PAID,
                SUM(CASE WHEN (FCP_FLAG=1 OR CUSTTYPE_ID IN(6,9,11,14,17,18,19,20,22)) THEN 1 ELSE 0 END) FREE
                FROM
                    (
                    SELECT
                        ETO_OFR_DISPLAY_ID,FCP_FLAG,CUSTTYPE_ID, IS_CATALOG ,PAID 
                    FROM
                        ETO_OFR,
                        GLUSR_USR,CUSTTYPE
                    WHERE
                        GLUSR_USR_ID = FK_GLUSR_USR_ID AND GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID(+) 
                        AND ETO_OFR_APPROV = 'A'
                        AND ETO_OFR_TYP = 'B'
                        AND (FCP_FLAG =1 OR GLUSR_USR_CUSTTYPE_WEIGHT IS NOT NULL )
                        AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
                        AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))

                    UNION

                    SELECT
                        ETO_OFR_DISPLAY_ID,FCP_FLAG,CUSTTYPE_ID, IS_CATALOG , PAID 
                    FROM
                        ETO_OFR_EXPIRED,
                        GLUSR_USR,CUSTTYPE
                    WHERE
                        GLUSR_USR_ID = FK_GLUSR_USR_ID AND GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID(+) 
                        AND ETO_OFR_APPROV = 'A'
                        AND ETO_OFR_TYP = 'B'
                        AND (FCP_FLAG =1 OR GLUSR_USR_CUSTTYPE_WEIGHT IS NOT NULL)
                        AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY'))
                        AND TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY'))
                    )";

	$sthTotalIMPaid= pg_query($dbh,$sql9);
      
	
	
	//######Indian Leads Approved with No City#####
	$sql10="SELECT COUNT(1) APPROVED_WITH_NO_CITY FROM 
	(
	SELECT ETO_OFR_DISPLAY_ID FROM ETO_OFR,GLUSR_USR WHERE GLUSR_USR_ID = FK_GLUSR_USR_ID 
        AND ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND FK_GL_CITY_ID IS NULL 
        AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) "
                . "and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
                    AND GLUSR_USR.FK_GL_COUNTRY_ISO = 'IN'
	
		UNION
	
	SELECT ETO_OFR_DISPLAY_ID FROM ETO_OFR_EXPIRED,GLUSR_USR WHERE GLUSR_USR_ID = FK_GLUSR_USR_ID 
        AND ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND FK_GL_CITY_ID IS NULL 
        AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(TO_DATE('$start_date','DD-MM-YYYY')) "
                . "and TRUNC(ETO_OFR_POSTDATE_ORIG) <= TRUNC(TO_DATE('$end_date','DD-MM-YYYY')) 
                    AND GLUSR_USR.FK_GL_COUNTRY_ISO = 'IN'
	)
	";
	
	$sthNocity= pg_query($dbh,$sql10);	
	
	return array($sthZeroCreadit,$sthTotalRepeat12Mon,$sthTotalRepeat3Mon,$sthTotalRepeat,$sthTotalIMPaid,$sthNocity);
	
	
	}

}

?>