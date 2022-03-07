<?php
  error_reporting(0);
  class attribute_data extends CFormModel
  {

  public function showattribute_dataReport($dbh)
  {
  $errArr = array();
	$flagError=0;
         $mesg = '';
         $sth = '';
         $total_fenq_generated = 0;
         $total_fenq_approved = 0;
         $total_fenq_rejected = 0;
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
	{  if(isset($_REQUEST['source']) && $_REQUEST['source']=='Buy Lead')
          {  
	         $modid = isset($_REQUEST['modid']) ? $_REQUEST['modid'] : '';
		 $submodid = isset($_REQUEST['submodid']) ? $_REQUEST['submodid'] : '';
		 $source = isset($_REQUEST['source']) ? $_REQUEST['source'] : '';

		//&showLeadQualityForm($cgiObject,$modid,$source);
		 $bdate_day = isset($_REQUEST['bdate_day']) ? $_REQUEST['bdate_day'] : '';
		 $bdate_month = isset( $_REQUEST['bdate_month']) ? $_REQUEST['bdate_month'] : '';
		 $bdate_year = isset($_REQUEST['bdate_year']) ? $_REQUEST['bdate_year'] : '';
		 $adate_day = isset( $_REQUEST['adate_day']) ? $_REQUEST['adate_day'] : '';
		 $adate_month = isset( $_REQUEST['adate_month']) ? $_REQUEST['adate_month'] : '';
		 $adate_year = isset($_REQUEST['adate_year']) ? $_REQUEST['adate_year'] : '';
		
		 $fenq_table = isset($_REQUEST['fenq_table']) ? $_REQUEST['fenq_table'] : 'ETO_OFR_FROM_FENQ';

		/*-------------------added on18/02/16---------------------------*/
		$sql_total="SELECT FILLED_ATTRIBUTE, COUNT(DISTINCT ETO_OFR_ID) TOTAL_BL FROM 
				  (
				  SELECT 
				    ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
				    COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
				    FROM
				    (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
				      (
				      SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
				      AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
				      ) ALL_SPECIFICATIONS,
				      (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_IDS FK_GLCAT_MCAT_ID FROM 
						      (
						      SELECT A.*,(CASE WHEN ETO_OFR_HIST_OLD_VAL IS NULL THEN FK_GLCAT_MCAT_ID ELSE TO_NUMBER(ETO_OFR_HIST_OLD_VAL) END) FK_GLCAT_MCAT_IDS
							      FROM 
								(
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								UNION
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								)A,
								(
								  SELECT * FROM
								  (
								  SELECT FK_ETO_OFR_ID,ETO_OFR_HIST_FIELD,ETO_OFR_HIST_OLD_VAL,ETO_OFR_HIST_NEW_VAL,ROW_NUMBER() OVER (PARTITION BY FK_ETO_OFR_ID ORDER BY ETO_OFR_HIST_DATE  ) RN FROM ETO_OFR_HIST_MAIN,ETO_OFR_HIST_DETAIL
									   WHERE ETO_OFR_HIST_ID=FK_ETO_OFR_HIST_ID AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID' AND ETO_OFR_HIST_OLD_VAL IS NOT NULL AND ETO_OFR_HIST_OLD_VAL <> -1 AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID'
										    AND TRUNC(ETO_OFR_HIST_DATE) >=trunc(TO_DATE(:start_date,'DD-MM-YYYY'))
								   )
								  WHERE RN<2)B
								WHERE A.ETO_OFR_DISPLAY_ID =B.FK_ETO_OFR_ID(+)
						      )           
						      WHERE FK_GLCAT_MCAT_IDS=:mcatid
				      ) ALL_OFFERS
				    ) TAB1,
				    ( 
					SELECT BUYER_RESPONSE_RFQ_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID, BUYER_RESPONSE_DETAIL FROM BUYER_RESPONSE
				    ) TAB2
				    WHERE MASTER_ID = FILLED_ID(+)
				  )   GROUP BY FILLED_ATTRIBUTE 
				  ORDER BY 1
				  ";
		$sth_total = oci_parse($dbh,$sql_total);
		oci_bind_by_name($sth_total,':mcatid',$modid);
                oci_bind_by_name($sth_total,':start_date',$start_date);
                oci_bind_by_name($sth_total,':end_date',$end_date);
                oci_execute($sth_total);
		//$rec_sold = oci_fetch_assoc($sth_sold);
		$rec_total =array();
		oci_fetch_all($sth_total,$rec_total);
		//var_dump($rec_total);
		//echo $modid;
		//die;
		//======================================
		$sql_sold="
			        SELECT FILLED_ATTRIBUTE, COUNT(DISTINCT ETO_OFR_DISPLAY_ID ) TOTAL_BL
           FROM
           ( SELECT 
				    DISTINCT ETO_OFR_DISPLAY_ID ,FILLED_ATTRIBUTE
            FROM
           (
           SELECT 
				     ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
				    COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
				    FROM
				    (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
				      (
				      SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
				      AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
				      ) ALL_SPECIFICATIONS,
				      (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_IDS FK_GLCAT_MCAT_ID FROM 
						      (
						      SELECT A.*,(CASE WHEN ETO_OFR_HIST_OLD_VAL IS NULL THEN FK_GLCAT_MCAT_ID ELSE TO_NUMBER(ETO_OFR_HIST_OLD_VAL) END) FK_GLCAT_MCAT_IDS
							      FROM 
								(
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								UNION
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								)A,
								(
								 SELECT * FROM
								  (
								  SELECT FK_ETO_OFR_ID,ETO_OFR_HIST_FIELD,ETO_OFR_HIST_OLD_VAL,ETO_OFR_HIST_NEW_VAL,ROW_NUMBER() OVER (PARTITION BY FK_ETO_OFR_ID ORDER BY ETO_OFR_HIST_DATE  ) RN FROM ETO_OFR_HIST_MAIN,ETO_OFR_HIST_DETAIL
									    WHERE ETO_OFR_HIST_ID=FK_ETO_OFR_HIST_ID AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID' AND ETO_OFR_HIST_OLD_VAL IS NOT NULL AND ETO_OFR_HIST_OLD_VAL <> -1 AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID'
									    AND TRUNC(ETO_OFR_HIST_DATE) >=trunc(TO_DATE(:start_date,'DD-MM-YYYY'))
								   )
								  WHERE RN<2)B
								WHERE A.ETO_OFR_DISPLAY_ID =B.FK_ETO_OFR_ID(+)
						      )           
						      WHERE FK_GLCAT_MCAT_IDS=:mcatid
						      ) ALL_OFFERS
				    ) TAB1,
				    ( 
					SELECT BUYER_RESPONSE_RFQ_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID, BUYER_RESPONSE_DETAIL FROM BUYER_RESPONSE
				    ) TAB2
				    WHERE MASTER_ID = FILLED_ID(+)
            )
            )A,
            (select DISTINCT fk_eto_ofr_id from eto_lead_pur_hist where
				    nvl(ETO_LEAD_PUR_TYPE,'B')='B' and FK_ETO_OFR_ID>0  
				    )eto_lead_pur_hist
				    where A.ETO_OFR_DISPLAY_ID=eto_lead_pur_hist.fk_eto_ofr_id 
            GROUP BY FILLED_ATTRIBUTE
            order by 1";
		$sth_sold = oci_parse($dbh,$sql_sold);
		 oci_bind_by_name($sth_sold,':mcatid',$modid);
                oci_bind_by_name($sth_sold,':start_date',$start_date);
                oci_bind_by_name($sth_sold,':end_date',$end_date);
                
                oci_execute($sth_sold);
		
		//$rec_sold = oci_fetch_assoc($sth_sold);
		$rec_sold =array();
		oci_fetch_all($sth_sold,$rec_sold);
	       $sql_sold_percent="
			         SELECT FILLED_ATTRIBUTE, COUNT( ETO_OFR_DISPLAY_ID ) TOTAL_BL
           FROM
           ( SELECT 
				    DISTINCT ETO_OFR_DISPLAY_ID ,FILLED_ATTRIBUTE
            FROM
           (
           SELECT 
				     ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
				    COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
				    FROM
				    (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
				      (
				      SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
				      AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
				      ) ALL_SPECIFICATIONS,
				      (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_IDS FK_GLCAT_MCAT_ID FROM 
						      (
						      SELECT A.*,(CASE WHEN ETO_OFR_HIST_OLD_VAL IS NULL THEN FK_GLCAT_MCAT_ID ELSE TO_NUMBER(ETO_OFR_HIST_OLD_VAL) END) FK_GLCAT_MCAT_IDS
							      FROM 
								(
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								UNION
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								)A,
								(
								 SELECT * FROM
								  (
								  SELECT FK_ETO_OFR_ID,ETO_OFR_HIST_FIELD,ETO_OFR_HIST_OLD_VAL,ETO_OFR_HIST_NEW_VAL,ROW_NUMBER() OVER (PARTITION BY FK_ETO_OFR_ID ORDER BY ETO_OFR_HIST_DATE  ) RN FROM ETO_OFR_HIST_MAIN,ETO_OFR_HIST_DETAIL
								    WHERE ETO_OFR_HIST_ID=FK_ETO_OFR_HIST_ID AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID' AND ETO_OFR_HIST_OLD_VAL IS NOT NULL AND ETO_OFR_HIST_OLD_VAL <> -1 AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID'
									    AND TRUNC(ETO_OFR_HIST_DATE) >=trunc(TO_DATE(:start_date,'DD-MM-YYYY'))
								  )
								  WHERE RN<2)B
								WHERE A.ETO_OFR_DISPLAY_ID =B.FK_ETO_OFR_ID(+)
						      )           
						      WHERE FK_GLCAT_MCAT_IDS=:mcatid
				      ) ALL_OFFERS
				    ) TAB1,
				    ( 
					SELECT BUYER_RESPONSE_RFQ_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID, BUYER_RESPONSE_DETAIL FROM BUYER_RESPONSE
				    ) TAB2
				    WHERE MASTER_ID = FILLED_ID(+)
            )
            )A,
            (select  fk_eto_ofr_id from eto_lead_pur_hist where
				    nvl(ETO_LEAD_PUR_TYPE,'B')='B' and FK_ETO_OFR_ID>0  
				    )eto_lead_pur_hist
				    where A.ETO_OFR_DISPLAY_ID=eto_lead_pur_hist.fk_eto_ofr_id 
            GROUP BY FILLED_ATTRIBUTE
            order by 1";
		$sth_sold_percent = oci_parse($dbh,$sql_sold_percent);
		 oci_bind_by_name($sth_sold_percent,':mcatid',$modid);
                oci_bind_by_name($sth_sold_percent,':start_date',$start_date);
                oci_bind_by_name($sth_sold_percent,':end_date',$end_date);
                
                oci_execute($sth_sold_percent);
	
	
		//$rec_sold = oci_fetch_assoc($sth_sold);
		$rec_sold_percent =array();
		oci_fetch_all($sth_sold_percent,$rec_sold_percent);
		$sql_other="select IM_SPEC_MASTER_DESC, COUNT(OTHER_COUNT) OTHER_COUNT
				    FROM
				    (
				    SELECT 
				    IM_SPEC_MASTER_DESC, 
				    FILLED_ATTRIBUTE,
				    COUNT(1) TOTAL_FILLED,
				    COUNT( DECODE(BUYER_RESPONSE_DETAIL,'Other',1,'Others',1,NULL) ) Other_Count 
				    FROM 
				    (
				    SELECT DISTINCT ETO_OFR_ID,IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE, DECODE(BUYER_RESPONSE_DETAIL,NULL,0,1) IS_FILLED, BUYER_RESPONSE_DETAIL FROM
				    (
				        SELECT * FROM (
				    select A.*, ROW_NUMBER () OVER (PARTITION BY ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID,FILLED_ATTRIBUTE
								ORDER BY BUYER_RESPONSE_DETAIL) RN from
				    (
				      SELECT 
				    ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
				    COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
				    FROM
				    (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
				      (
				      SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
				      AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
				      ) ALL_SPECIFICATIONS,
				      (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_IDS FK_GLCAT_MCAT_ID FROM 
						      (
						      SELECT A.*,(CASE WHEN ETO_OFR_HIST_OLD_VAL IS NULL THEN FK_GLCAT_MCAT_ID ELSE TO_NUMBER(ETO_OFR_HIST_OLD_VAL) END) FK_GLCAT_MCAT_IDS
							      FROM 
								(
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								UNION
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								)A,
								(
								  SELECT * FROM
								  (
								  SELECT FK_ETO_OFR_ID,ETO_OFR_HIST_FIELD,ETO_OFR_HIST_OLD_VAL,ETO_OFR_HIST_NEW_VAL,ROW_NUMBER() OVER (PARTITION BY FK_ETO_OFR_ID ORDER BY ETO_OFR_HIST_DATE  ) RN FROM ETO_OFR_HIST_MAIN,ETO_OFR_HIST_DETAIL
									   WHERE ETO_OFR_HIST_ID=FK_ETO_OFR_HIST_ID AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID' AND ETO_OFR_HIST_OLD_VAL IS NOT NULL AND ETO_OFR_HIST_OLD_VAL <> -1 AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID'
										    AND TRUNC(ETO_OFR_HIST_DATE) >=trunc(TO_DATE(:start_date,'DD-MM-YYYY'))
								   )
								  WHERE RN<2)B
								WHERE A.ETO_OFR_DISPLAY_ID =B.FK_ETO_OFR_ID(+)
						      )           
						      WHERE FK_GLCAT_MCAT_IDS=:mcatid
				      ) ALL_OFFERS
				    ) TAB1,
				    ( 
					SELECT BUYER_RESPONSE_RFQ_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID, BUYER_RESPONSE_DETAIL FROM BUYER_RESPONSE
				    ) TAB2
				    WHERE MASTER_ID = FILLED_ID(+)
				      )A
				    )
				    WHERE RN< 2
				    )  
				    ) WHERE IS_FILLED <> 0 GROUP BY IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE
				    ORDER BY 1,2
				    )
				    GROUP BY IM_SPEC_MASTER_DESC";
		 $sth_other = oci_parse($dbh,$sql_other);
		 oci_bind_by_name($sth_other,':mcatid',$modid);
                oci_bind_by_name($sth_other,':start_date',$start_date);
                oci_bind_by_name($sth_other,':end_date',$end_date);
                
                oci_execute($sth_other);
		
		//$rec_sold = oci_fetch_assoc($sth_sold);
		$rec_other =array();
		oci_fetch_all($sth_other,$rec_other);
		//========================================
		$sql_attribute_name="SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
                AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid ORDER BY 1";
                $sth_attribute_name = oci_parse($dbh,$sql_attribute_name);
                oci_bind_by_name($sth_attribute_name,':mcatid',$modid);
		oci_execute($sth_attribute_name);
		$rec_attribute_name =array();
		oci_fetch_all($sth_attribute_name,$rec_attribute_name);
		//var_dump($rec_attribute_name);
		////////////////////////////////////
		$sql="SELECT FILLED_ATTRIBUTE,TOTAL_FILLED FROM (SELECT 
			    IM_SPEC_MASTER_DESC, 
			    FILLED_ATTRIBUTE,
			    COUNT(1) TOTAL_FILLED,
			    COUNT( DECODE(BUYER_RESPONSE_DETAIL,'Other',1,'Others',1,NULL) ) Other_Count 
			    FROM 
			    (
			    SELECT DISTINCT ETO_OFR_ID,IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE, DECODE(BUYER_RESPONSE_DETAIL,NULL,0,1) IS_FILLED, BUYER_RESPONSE_DETAIL FROM
			    (
			       SELECT * FROM (
			      select A.*, ROW_NUMBER () OVER (PARTITION BY ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID,FILLED_ATTRIBUTE
							  ORDER BY BUYER_RESPONSE_DETAIL) RN from
			      (
				SELECT 
				    ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
				    COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
				    FROM
				    (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
				      (
				      SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
				      AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
				      ) ALL_SPECIFICATIONS,
				      (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_IDS FK_GLCAT_MCAT_ID FROM 
						      (
						      SELECT A.*,(CASE WHEN ETO_OFR_HIST_OLD_VAL IS NULL THEN FK_GLCAT_MCAT_ID ELSE TO_NUMBER(ETO_OFR_HIST_OLD_VAL) END) FK_GLCAT_MCAT_IDS
							      FROM 
								(
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								UNION
								SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED 
								WHERE TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
								)A,
								(
								  SELECT * FROM
								  (
								  SELECT FK_ETO_OFR_ID,ETO_OFR_HIST_FIELD,ETO_OFR_HIST_OLD_VAL,ETO_OFR_HIST_NEW_VAL,ROW_NUMBER() OVER (PARTITION BY FK_ETO_OFR_ID ORDER BY ETO_OFR_HIST_DATE  ) RN FROM ETO_OFR_HIST_MAIN,ETO_OFR_HIST_DETAIL
									   WHERE ETO_OFR_HIST_ID=FK_ETO_OFR_HIST_ID AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID' AND ETO_OFR_HIST_OLD_VAL IS NOT NULL AND ETO_OFR_HIST_OLD_VAL <> -1 AND ETO_OFR_HIST_FIELD='FK_GLCAT_MCAT_ID'
										    AND TRUNC(ETO_OFR_HIST_DATE) >=trunc(TO_DATE(:start_date,'DD-MM-YYYY'))
								   )
								  WHERE RN<2)B
								WHERE A.ETO_OFR_DISPLAY_ID =B.FK_ETO_OFR_ID(+)
						      )           
						      WHERE FK_GLCAT_MCAT_IDS=:mcatid
				      ) ALL_OFFERS
				    ) TAB1,
				    ( 
					SELECT BUYER_RESPONSE_RFQ_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID, BUYER_RESPONSE_DETAIL FROM BUYER_RESPONSE
				    ) TAB2
				    WHERE MASTER_ID = FILLED_ID(+)
				)A

			      )
			      WHERE RN< 2
			    )  
			    ) WHERE IS_FILLED <> 0 GROUP BY IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE
			    ORDER BY 1
			    )
			    WHERE IM_SPEC_MASTER_DESC=:attname
			    ";
                $rec =array();
                $i=0;
                
                foreach($rec_attribute_name['IM_SPEC_MASTER_DESC'] as $value)
                {
                $sth = oci_parse($dbh,$sql);
               // echo $value;
                oci_bind_by_name($sth,':attname',$value);
                oci_bind_by_name($sth,':mcatid',$modid);
                oci_bind_by_name($sth,':start_date',$start_date);
                oci_bind_by_name($sth,':end_date',$end_date);
                oci_execute($sth);
		oci_fetch_all($sth,$rec[$value]);
		
		}
		//var_dump($rec);
	        
		/////////////////////////////////////
		return array($rec,$rec_total,$rec_attribute_name,$rec_sold,$rec_sold_percent,$rec_other);
	}
	else
	{//////////////////code for Enquiry//////////////////////////////////
	 $modid = isset($_REQUEST['modid']) ? $_REQUEST['modid'] : '';
		 $submodid = isset($_REQUEST['submodid']) ? $_REQUEST['submodid'] : '';
		 $source = isset($_REQUEST['source']) ? $_REQUEST['source'] : '';
		$sql_total="SELECT FILLED_ATTRIBUTE, COUNT(DISTINCT ETO_OFR_ID) TOTAL_BL FROM 
				  (
				  SELECT 
				    ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
				    COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
				    FROM
				    (
				      SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
				      (
				      SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
				      AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
				      ) ALL_SPECIFICATIONS,
				      (
				      SELECT DIR_QUERY_MCATID,QUERY_ID ETO_OFR_ID, QUERY_ID ETO_OFR_DISPLAY_ID FROM DIR_QUERY@ENQDBR.intermesh.net 
				     WHERE TRUNC(DATE_R) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
			      AND DIR_QUERY_MCATID = :mcatid
				      ) ALL_OFFERS
				    ) TAB1,
				    ( 
					SELECT BUYER_RESPONSE_RFQ_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID, BUYER_RESPONSE_DETAIL FROM BUYER_RESPONSE@ENQDBR.intermesh.net
				    ) TAB2
				    WHERE MASTER_ID = FILLED_ID(+)
				  )   GROUP BY FILLED_ATTRIBUTE 
				  ORDER BY 1
				  ";
				  
		$sth_total = oci_parse($dbh,$sql_total);
		oci_bind_by_name($sth_total,':mcatid',$modid);
                oci_bind_by_name($sth_total,':start_date',$start_date);
                oci_bind_by_name($sth_total,':end_date',$end_date);
                oci_execute($sth_total);
                
                
		//$rec_sold = oci_fetch_assoc($sth_sold);
		$rec_total =array();
		oci_fetch_all($sth_total,$rec_total);
		$rec_attribute_name =array();
		$sql_attribute_name="SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
                AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid ORDER BY 1";
                $sth_attribute_name = oci_parse($dbh,$sql_attribute_name);
                oci_bind_by_name($sth_attribute_name,':mcatid',$modid);
		oci_execute($sth_attribute_name);
		$rec_attribute_name =array();
		oci_fetch_all($sth_attribute_name,$rec_attribute_name);
	$sql="SELECT FILLED_ATTRIBUTE,TOTAL_FILLED FROM (SELECT 
			    IM_SPEC_MASTER_DESC, 
			    FILLED_ATTRIBUTE,
			    COUNT(1) TOTAL_FILLED,
			    COUNT( DECODE(BUYER_RESPONSE_DETAIL,'Other',1,'Others',1,NULL) ) Other_Count 
			    FROM 
			    (
			    SELECT DISTINCT ETO_OFR_ID,IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE, DECODE(BUYER_RESPONSE_DETAIL,NULL,0,1) IS_FILLED, BUYER_RESPONSE_DETAIL FROM
			    (
			      SELECT 
			      ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
			      COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
			      FROM
			      (
				SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
				(
				SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
				AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
				) ALL_SPECIFICATIONS,
				(
				SELECT DIR_QUERY_MCATID,QUERY_ID ETO_OFR_ID, QUERY_ID ETO_OFR_DISPLAY_ID FROM DIR_QUERY@ENQDBR.intermesh.net 
				WHERE TRUNC(DATE_R) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
			 AND DIR_QUERY_MCATID = :mcatid
				) ALL_OFFERS
			      ) TAB1,
			      ( 
				  SELECT BUYER_RESPONSE_RFQ_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID, BUYER_RESPONSE_DETAIL FROM BUYER_RESPONSE@ENQDBR.intermesh.net
			      ) TAB2
			      WHERE MASTER_ID = FILLED_ID(+)
			    )  
			    ) WHERE IS_FILLED <> 0 GROUP BY IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE
			    ORDER BY 1
			    )
			    WHERE IM_SPEC_MASTER_DESC=:attname
			    ";
                $rec_enq =array();
                $i=0;
                
                foreach($rec_attribute_name['IM_SPEC_MASTER_DESC'] as $value)
                {
                $sth = oci_parse($dbh,$sql);
               // echo $value;
                oci_bind_by_name($sth,':attname',$value);
                oci_bind_by_name($sth,':mcatid',$modid);
                oci_bind_by_name($sth,':start_date',$start_date);
                oci_bind_by_name($sth,':end_date',$end_date);
                oci_execute($sth);
		oci_fetch_all($sth,$rec_enq[$value]);
		
		}
	
	$sql_other="select IM_SPEC_MASTER_DESC, COUNT(OTHER_COUNT) OTHER_COUNT
				    FROM
				    (
				    SELECT 
				    IM_SPEC_MASTER_DESC, 
				    FILLED_ATTRIBUTE,
				    COUNT(1) TOTAL_FILLED,
				    COUNT( DECODE(BUYER_RESPONSE_DETAIL,'Other',1,'Others',1,NULL) ) Other_Count 
				    FROM 
				    (
				    SELECT DISTINCT ETO_OFR_ID,IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE, DECODE(BUYER_RESPONSE_DETAIL,NULL,0,1) IS_FILLED, BUYER_RESPONSE_DETAIL FROM
				    (
				      SELECT 
				      ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, FILLED_ID, BUYER_RESPONSE_DETAIL ,
				      COUNT( DISTINCT DECODE(BUYER_RESPONSE_DETAIL,NULL,NULL,IM_SPEC_MASTER_DESC) ) OVER( PARTITION BY ETO_OFR_ID ) FILLED_ATTRIBUTE 
				      FROM
				      (
					SELECT ETO_OFR_ID, ETO_OFR_DISPLAY_ID, IM_SPEC_MASTER_DESC, ETO_OFR_DISPLAY_ID || IM_SPEC_MASTER_DESC MASTER_ID FROM
					(
					SELECT IM_SPEC_MASTER_DESC FROM IM_CAT_SPECIFICATION,IM_SPECIFICATION_MASTER  WHERE IM_CAT_SPEC_CATEGORY_TYPE = 3 
					 AND FK_IM_SPEC_MASTER_ID = IM_SPEC_MASTER_ID AND IM_CAT_SPEC_CATEGORY_ID = :mcatid
					) ALL_SPECIFICATIONS,
					(
					SELECT DIR_QUERY_MCATID,QUERY_ID ETO_OFR_ID, QUERY_ID ETO_OFR_DISPLAY_ID FROM DIR_QUERY@ENQDBR.intermesh.net 
				        WHERE TRUNC(DATE_R) BETWEEN trunc(TO_DATE(:start_date,'DD-MM-YYYY')) and trunc(TO_DATE(:end_date,'DD-MM-YYYY'))
			                AND DIR_QUERY_MCATID = :mcatid
					) ALL_OFFERS
				      ) TAB1,
				      ( 
					 SELECT FK_ETO_OFR_DISPLAY_ID || FK_IM_SPEC_MASTER_DESC FILLED_ID,FK_IM_SPEC_OPTIONS_DESC BUYER_RESPONSE_DETAIL FROM ETO_ATTRIBUTE@ENQDBR.intermesh.net
				      ) TAB2
				      WHERE MASTER_ID = FILLED_ID(+)
				    )  
				    ) WHERE IS_FILLED <> 0 GROUP BY IM_SPEC_MASTER_DESC, FILLED_ATTRIBUTE
				    ORDER BY 1,2
				    )
				    GROUP BY IM_SPEC_MASTER_DESC";
		 $sth_other = oci_parse($dbh,$sql_other);
		 oci_bind_by_name($sth_other,':mcatid',$modid);
                oci_bind_by_name($sth_other,':start_date',$start_date);
                oci_bind_by_name($sth_other,':end_date',$end_date);
                
                oci_execute($sth_other);
		
		//$rec_sold = oci_fetch_assoc($sth_sold);
		$rec_other =array();
		oci_fetch_all($sth_other,$rec_other);
	
	return array($rec_enq,$rec_total,$rec_attribute_name,$rec_other);	
	}

      }
  }
  
  public function showattribute_dataForm($dbh)
  {
    $sql = "select Distinct GLCAT_MCAT.GLCAT_MCAT_NAME GL_MODULE_ID,GLCAT_MCAT_ID 
from IM_CAT_SPECIFICATION,GLCAT_MCAT 
where 
GLCAT_MCAT.GLCAT_MCAT_ID=im_cat_spec_category_id 
and  IM_CAT_SPEC_CATEGORY_TYPE=3
 ORDER BY GLCAT_MCAT_NAME"; 
    $sth = oci_parse($dbh,$sql);
    oci_execute($sth);    
    return $sth;
		
  }

  

 /*############################ Additon OF Bulk Upload of ISQ ############################*/
  
  public $host_name;
  function __construct() 
   {
        $this->host_name = $_SERVER['SERVER_NAME'];
    }



public function show_html($cookie_mid, $js_file) {

    $head='ISQ Bulk Upload';
    $action='add';

        print <<<ae
    <html>
        <head><title>ISQ Addition Bulk Upload Screen</title>
    <LINK HREF="$js_file/css/report.css" REL="STYLESHEET" TYPE="text/css">
    <style type="text/css"> 
        table td {font-size:12px;background-color:#F0F9FF;} 
        .bg { background-color:#F0F9FF;} 
        select {  width: 180px;  background-color: #ffffff;}
    </style>   
    <script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script language="javascript" src="admin_eto/common-scripts/bulk_bb_mgr.js"></script>
    </head>
    <body><input name="frame_height" id="frame_height" value="" type="hidden">
        <form name="Search" method="post" enctype="multipart/form-data" action="/index.php?r=admin_bl/Attribute_data/BulkBBAdd&act=$action&mid=$cookie_mid">
            <input type="hidden" name="mid" value="$cookie_mid">
            <table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
                <TR>
                    <TD colspan="2" align="center" style="background-color:#006DCC;color:#fff">
                        <B><FONT SIZE = "2px">$head</FONT></B>
                    </TD>
                </tr>
<TR>
                    <TD colspan="2" align="right">  

</td></tr>
                <tr>
                    <TD bgcolor="#F0F9FF" style="color: #4A4A4A;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size: 12px; line-height:2px;" width="15%">
                        <B>Upload Excel:</B>
                    </TD>
                    <TD bgcolor="#F0F9FF" style="line-height:2px;" width="30%">
                        <input type="FILE" name="S_attachment" value="" >
                    </TD>
                </tr>
                <tr id ="tspbl_data"></tr>
                <tr>
                    <td align="center" colspan="2" bgcolor="#F0F9FF">
ae;
        print <<<hj
<input type="submit" name="action" id ="Upload" value="Upload" onclick="return upload();" class="btn btn-small btn-primary" style="font-weight:normal">
<input type="submit" name="action1" id ="disable" value="Process" onclick = "process();" class="btn btn-small btn-primary" style="font-weight:normal">
hj;
        print "</td></tr>";
if (isset($_REQUEST['act']) && $_REQUEST['act'] == 'add') {
 
echo '<tr>
    <td colspan = "4" align="left" bgcolor="#F0F9FF">
<table width=100%><tr>
<td width=50%>
<div style="float:left"><B><a href="/index.php?r=admin_bl/Attribute_data/BulkBBAdd&act=add&mid='.$cookie_mid.'">ISQ Bulk Upload</a></B></div><br/>
</td>
<td width=50%>
<div style="float:left"><B><a href="/admin_eto/ISQ_Bulk_upload_sample.xls">Download Sample Excel of ISQ Bulk Upload</a></B></div><br/>    
</td>
</tr>
    </table>
</td></tr>';
}
 echo " </table><br> ";
    }



    public function showInst() {
        print <<<hj
<div id="div_inst">
    <table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0">
    <TR>
    <TD align="center" bgcolor="#F0F9FF"><B>ISQ Bulk Data process Instructions</B></TD>
    </TR>
    <TR>
    <TD bgcolor="#F0F9FF" style="font-size: 11px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">
    <ul>
    <li>Document must be in Excel Format (File Format Should be in .xls)</li>
    <li>Only 5000 records will be process in one excel.</li>
    <li>All headings should be in first row of Excel.</li>
    <li>Delete blank rows from excel before upload. Otherwise all blank rows will be skipped.</li>
    <li>All headings should be in given format and Don't change the given headings. Please download sample excel and refer all given headings.</li>
    <li>Only one excel will be process at once. If you have uploaded one excel it must be processed or deleted before uploading another excel. </li>
    </ul>
    </TD>
    </TR></Table></div>
hj;
    }


    

    public function upload($empid,$cookie_mid) {
        $action='';
        if (isset($_REQUEST['act'])) { 
             $action=$_REQUEST['act'];
        }
        $file_id          = 'S_attachment';
        $file_name        = '';
        $upload_path      = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/";
        $j                = 0;
      
        $file_name_upload = $_FILES[$file_id]['name'];
        $time             = getdate();
        $date             = substr($time['month'], 0, 3) . "-" . $time['mday'] . "-" . $time['year'];
        $file_name        = $file_name_upload;      
       
       
        $file_name        = basename($file_name);
        $file_name        = preg_replace("/\s+/", '_', $file_name);
        $file_name        = preg_replace("/.xls/", '', $file_name);
        $file_name .= "_";
        $file_name .= $date;
        $file_name .= "(" . (floor((mt_rand() / mt_getrandmax()) * 10000000)) . ")";
        $file_name .= "-" . $empid;
        $file_name .= ".xls";
        $split_empid  = '';
        $split_empid1 = '';
        $html         = '';
        $i            = 0;
        $arr          = explode("-", $file_name);
        $arr1         = array();
        foreach ($arr as $_) {
            if (preg_match("/(.*)\.xls/", $_, $match)) {
                $temp        = explode('.', $_);
                $split_empid = $temp[0];
            }
        }


        $DIR = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
        print <<<sd
<input type="hidden" name="mid" value="$cookie_mid"><TABLE bordercolor="#bedaff" border="1" cellspacing="0" cellpadding="4" align="center" class="table_txt" style="border-collapse: collapse; width:98%">
sd;
        $tr              = '';
        $match_filecount = 0;
        while (false !== ($file = readdir($DIR))) {
            preg_match("/.xls/i", $file, $match);
            if ($match) {
                $arr1 = explode("-", $file);
                foreach ($arr1 as $_) {
                    preg_match("/(.*).xls/", $_, $match);
                    if ($match) {
                        $temp         = explode('.', $_);
                        $split_empid1 = $temp[0];
                    }
                }
                
                if ($split_empid1 == $split_empid) {
                    $tr .= <<<ll
<TR><TD align="right" bgcolor="#F0F9FF"><b><font size= "2" color="black" >$file</font>
<img src="/admin_glusr/gifs/trash.gif" border="0" onclick = "return remove_file_isq('$file','excel','$action','$cookie_mid','bb');"><input type="hidden" name="excel" value="$file"></b>
<div id="removedexcel" style="display:none"> ( Removed ) </div>                                
ll;
                    
                    $tr .= "</TD></tr>";
                    $match_filecount++;
                }
            }
        }
        $uploadfile = $upload_path . $file_name;
        if ($match_filecount == 0) {
            if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
                $html = "Cannot upload the file '" . $_FILES[$file_id]['name'] . "'";
                if (!file_exists($folder)) {
                    $html .= " : Folder don't exist.";
                } elseif (!is_writable($folder)) {
                    $html .= " : Folder not writable.";
                } elseif (!is_writable($uploadfile)) {
                    $html .= " : File not writable.";
                }
                $file_name = '';
            } else {
                if (!$_FILES[$file_id]['size']) {
                    @unlink($uploadfile);
                    $file_name = '';
                    $html      = "Empty file found - please use a valid file.";
                } else {
                    chmod($uploadfile, 0777);
                    $i = 1;
                }
            }
        } else {
            print <<<lk
<TR><TD align="Left" bgcolor="#F0F9FF">You Already Upload These Files. Kindly Process Them Before Uploading New File or Delete Below Files.</TD></TR>$tr</table>
lk;
            print <<<gh
<script language="JavaScript" type="text/javascript"> document.getElementById('disable').disabled=true;
            document.getElementById('Upload').disabled=true;</script>
gh;
        }
        if ($i == 1) {
            $excelfile = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$file_name"; 
            Yii::import('ext.phpexcelreader.JPhpExcelReader');
            $data          = new JPhpExcelReader($excelfile);    
            $heading_error = '';
 if (isset($_REQUEST['act']) && ($_REQUEST['act'] == 'add' || $_REQUEST['act'] == 'update')) {   

            $heading_hash  = array(
                'IM_CAT_SPEC_CATEGORY_ID' => '',
                'IM_CAT_SPEC_CATEGORY_TYPE' => '',
                'IM_SPEC_MASTER_DESC' => '',
                'IM_SPEC_MASTER_FULL_DESC'=>'',
                'IM_SPEC_MASTER_BUYER_SELLER'=>'',
                'IM_SPEC_MASTER_TYPE' => '',
                'IM_CAT_SPEC_PRIORITY' => '',
                'IM_CAT_SPEC_STATUS' => '',
                'IM_SPEC_OPTIONS_DESC' => '',	
                'IM_SPEC_OPTIONS_STATUS' => '',               
                'IM_SPEC_OPT_BUYER_SELLER' => '' 
                );
            if (isset($data->sheets[0]['cells'][1][1])) {
                $heading_hash['IM_CAT_SPEC_CATEGORY_ID'] = $data->sheets[0]['cells'][1][1];
            }
            if (isset($data->sheets[0]['cells'][1][2])) {
                $heading_hash['IM_CAT_SPEC_CATEGORY_TYPE'] = $data->sheets[0]['cells'][1][2];
            }
            if (isset($data->sheets[0]['cells'][1][3])) {
                $heading_hash['IM_SPEC_MASTER_DESC'] = $data->sheets[0]['cells'][1][3];
            }
            if (isset($data->sheets[0]['cells'][1][4])) {
                $heading_hash['IM_SPEC_MASTER_FULL_DESC'] = $data->sheets[0]['cells'][1][4];
            }
            if (isset($data->sheets[0]['cells'][1][5])) {
                $heading_hash['IM_SPEC_MASTER_BUYER_SELLER'] = $data->sheets[0]['cells'][1][5];
            }
            
            if (isset($data->sheets[0]['cells'][1][6])) {
                $heading_hash['IM_SPEC_MASTER_TYPE'] = $data->sheets[0]['cells'][1][6];
            }
            if (isset($data->sheets[0]['cells'][1][7])) {
                $heading_hash['IM_CAT_SPEC_PRIORITY'] = $data->sheets[0]['cells'][1][7];
            }
            if (isset($data->sheets[0]['cells'][1][8])) {
                $heading_hash['IM_CAT_SPEC_STATUS'] = $data->sheets[0]['cells'][1][8];
            }
            if (isset($data->sheets[0]['cells'][1][9])) {
                $heading_hash['IM_SPEC_OPTIONS_DESC'] = $data->sheets[0]['cells'][1][9];
            }
            if (isset($data->sheets[0]['cells'][1][10])) {
                $heading_hash['IM_SPEC_OPTIONS_STATUS'] = $data->sheets[0]['cells'][1][10];
            }
            
            if (isset($data->sheets[0]['cells'][1][11])) {
                $heading_hash['IM_SPEC_OPT_BUYER_SELLER'] = $data->sheets[0]['cells'][1][11];
            }
           
            if ($heading_hash['IM_CAT_SPEC_CATEGORY_ID'] != 'IM_CAT_SPEC_CATEGORY_ID') {
                $heading_error .= "<BR>Column - A should be IM_CAT_SPEC_CATEGORY_ID";
            }
            if ($heading_hash['IM_CAT_SPEC_CATEGORY_TYPE'] != 'IM_CAT_SPEC_CATEGORY_TYPE') {
                $heading_error .= "<BR>Column - B should be IM_CAT_SPEC_CATEGORY_TYPE";
            }
            if ($heading_hash['IM_SPEC_MASTER_DESC'] != 'IM_SPEC_MASTER_DESC') {
                $heading_error .= "<BR>Column - C should be IM_SPEC_MASTER_DESC";
            }
             if ($heading_hash['IM_SPEC_MASTER_FULL_DESC'] != 'IM_SPEC_MASTER_FULL_DESC') {
                $heading_error .= "<BR>Column - D should be IM_SPEC_MASTER_FULL_DESC";
            }
            if ($heading_hash['IM_SPEC_MASTER_BUYER_SELLER'] != 'IM_SPEC_MASTER_BUYER_SELLER') {
                $heading_error .= "<BR>Column - E should be IM_SPEC_MASTER_BUYER_SELLER";
            }
             if ($heading_hash['IM_SPEC_MASTER_TYPE'] != 'IM_SPEC_MASTER_TYPE') {
                $heading_error .= "<BR>Column - F should be IM_SPEC_MASTER_TYPE";
            }
            if ($heading_hash['IM_CAT_SPEC_PRIORITY'] != 'IM_CAT_SPEC_PRIORITY') {
                $heading_error .= "<BR>Column - G should be IM_CAT_SPEC_PRIORITY";
            }
            if ($heading_hash['IM_CAT_SPEC_STATUS'] != 'IM_CAT_SPEC_STATUS') {
                $heading_error .= "<BR>Column - H should be IM_CAT_SPEC_STATUS";
            }
            if ($heading_hash['IM_SPEC_OPTIONS_DESC'] != 'IM_SPEC_OPTIONS_DESC') {
                $heading_error .= "<BR>Column - I should be IM_SPEC_OPTIONS_DESC";
            }
           
            if ($heading_hash['IM_SPEC_OPTIONS_STATUS'] != 'IM_SPEC_OPTIONS_STATUS') {
                $heading_error .= "<BR>Column - J should be IM_SPEC_OPTIONS_STATUS";
            }
             if ($heading_hash['IM_SPEC_OPT_BUYER_SELLER'] != 'IM_SPEC_OPT_BUYER_SELLER') {
                $heading_error .= "<BR>Column - K should be IM_SPEC_OPT_BUYER_SELLER";
}
}

          if ($heading_error) {
                print <<<hj
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF"> Heading Mismatch Please Follow These  : $heading_error</TD></TR></TABLE>
hj;
                print <<<lp
<script language="JavaScript" type="text/javascript">
            document.getElementById('disable').disabled=true;
            </script>
lp;
                unlink("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$file_name");
                exit;
            } else {
                print <<<ki
<div id="ok_tab"><table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF"> All Headings Are OK !! Click on Process Button to Proceed.</TD></TR></div><TABLE>
ki;
                print <<<bh
<script language="JavaScript" type="text/javascript">
                document.getElementById('disable').disabled=false;
                document.getElementById('Upload').disabled=true;
                </script>
bh;
            }

            return $file_name;
        }
    }
    
    public function Process($empid,$excel_data, $cookie_mid, $user_del, $user_download, $uploaded_filename, $process_time) {
        $finaldata  = array();
        $update=0;
        $tr         = 1;       
        $j = 0;
        $msg2='';
        print '<div id="processing"></div>';
        if ($excel_data == 'excel') {
            $DIR = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
            while (false !== ($file1 = readdir($DIR))) {
                $file_name   = '';
                $upload_path = '';
                $tr          = 1;               
                if (preg_match("/^\.\.?$/", $file1)) {
                    continue;
                }
                if (preg_match("/.xls/", $file1) && ($file1 == $uploaded_filename)) {
                    print <<<hj
<input type="hidden" name="mid" value="$cookie_mid">
<TABLE bordercolor="#bedaff" border="1" cellspacing="0" cellpadding="4" align="center" class="table_txt" style="border-collapse: collapse; width:98%" align="center"><TR><TD align="right" bgcolor="#F0F9FF"><b>
hj;
                    print <<<kl
<font size= "2" color="black" >$uploaded_filename</font>
kl;
                    if ($user_del || 1) {
                        print <<<mk
<INPUT type="image" name="search_file" src="/admin_glusr/gifs/trash.gif" border="0" onclick = "return remove('$uploaded_filename','excel');"><input type="hidden" name="excel" value="$uploaded_filename"></b>
mk;
                    }
                    print "</TD></tr></table>";
                    $j++;
                }
            }           
        }
      
        
        if ($excel_data == 'excel_data') {
            $action='';
            if (isset($_REQUEST['act'])) { 
                $action='BB_'.strtoupper($_REQUEST['act']);
            }
            
        $glEtoModel = new AdminEtoModelForm(); 
        $empid = Yii::app()->session['empid'];	
	$empName = Yii::app()->session['empname'];
	$histip = $_SERVER['REMOTE_ADDR'];        
        
            $DIR       = opendir("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/");
            $cntry_iso = '';
            while (false !== ($file1 = readdir($DIR))) {
                preg_match("/.xls/", $file1, $match);
                if ($match) {
                    $arr1 = explode("-", $file1);
                    foreach ($arr1 as $_) {
                        preg_match("/(.*).xls/", $_, $match);
                        if ($match) {
                            $temp         = explode('.', $_);
                            $split_empid1 = $temp[0];
                        }
                    }
                    $file_name   = '';
                    $upload_path = '';
                     if ($split_empid1 == $empid) {
                        print <<<gf
<script language="JavaScript" type="text/javascript">
                    document.getElementById('disable').disabled=false;
                    </script>
gf;
                        $upload_path = "/home3/indiamart/public_html/excel_download/bulk_bigbuyer_output/";
                        $filename_input   = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$uploaded_filename";
                        Yii::import('ext.phpexcelreader.JPhpExcelReader');
                        $data       = new JPhpExcelReader($filename_input);
                        $total_rows = $data->sheets[0]['numRows'];                       
                       
                        if ($total_rows > 5000) {
                            print <<<jh
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF">Record Limit Exceed !! Only 5000 Records Are Allowed. You Have Entered <b>$total_rows</b> Records. Re-Upload Excel The File and Try Again.</TD></TR><TABLE>
jh;
                            unlink("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$uploaded_filename");
                            print <<<vg
<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true;document.getElementById('Upload').disabled=false;</script>
vg;
                            exit;
                        } else if ($total_rows == 0 || $total_rows == 1) {
                            print <<<fd
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF" align="Center"><B>No Records Found in Excel. Kindly Enter Some Data To Proceed.</B></TD></TR><TABLE>
fd;
                            unlink("/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/$uploaded_filename");
                            print <<<mn
<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true;document.getElementById('Upload').disabled=false;</script>
mn;
                            exit;
                        }
                        
                        $filename_out      = $upload_path ."isq_bulk_add_".Yii::app()->session['empid'].".xls";               
                        $BBFILE       = fopen($filename_out, "w");
                        if ($BBFILE === FALSE)
                            $remark = "Cannot open file [$filename_out] for writing";
                            
                            
                            
                        if($action =='BB_ADD'){
                            if (fwrite($BBFILE, "IM_CAT_SPEC_CATEGORY_ID\t IM_CAT_SPEC_CATEGORY_TYPE\t IM_SPEC_MASTER_DESC\t IM_SPEC_MASTER_FULL_DESC\t IM_SPEC_MASTER_BUYER_SELLER\t IM_SPEC_MASTER_TYPE\t IM_CAT_SPEC_PRIORITY\t IM_CAT_SPEC_STATUS\t IM_SPEC_OPTIONS_DESC\t IM_SPEC_OPTIONS_STATUS\t IM_SPEC_OPT_BUYER_SELLER\t INSERT_STATUS_IM_SPECIFICATION_MASTER\t INSERT_STATUS_IM_CAT_SPECIFICATION\t INSERT_STATUS_IM_SPECIFICATION_OPTIONS\n") === FALSE)
                                $remark = "Cannot write to file [$filename_out]";
                        }
                        $process_flag = 0;
                        $CATEGORY_ID='';
                        $finalDataArr=array();
                        $Arr_MASTER_DESC=array(); $Arr_MASTER_FULL_DESC=array();$Arr_MASTER_BUYER_SELLER=array();
                        $Arr_MASTER_TYPE=$Arr_MASTER_TYPE_OPT= $Arr_CATEGORY_ID=$Arr_CATEGORY_TYPE=$Arr_SPEC_PRIORITY=array();
                        $Arr_SPEC_STATUS=$Arr_OPTIONS_DESC= $Arr_OPTIONS_STATUS=$Arr_MASTER_OPT_BUYER_SELLER=array();
                                               
                        $n=-1;$m=0;
                        foreach (range(2, $total_rows) as $i) {                            
                            $excel_row=array();
                            $finalmsg='';                            
                        if($action =='BB_ADD'){
                            $excel_row['IM_CAT_SPEC_CATEGORY_ID']=""; 
                            $excel_row['IM_CAT_SPEC_CATEGORY_TYPE']="";          
                            $excel_row['IM_SPEC_MASTER_DESC']="";$excel_row['IM_SPEC_MASTER_FULL_DESC']="";$excel_row['IM_SPEC_MASTER_BUYER_SELLER']="";          
                            $excel_row['IM_SPEC_MASTER_TYPE'] ="";                 
                            $excel_row['IM_CAT_SPEC_PRIORITY']='';     
                            $excel_row['IM_CAT_SPEC_STATUS']="";        
                            $excel_row['IM_SPEC_OPTIONS_DESC']="";        
                            $excel_row['IM_SPEC_OPTIONS_STATUS']="";            
                            $excel_row['IM_SPEC_OPT_BUYER_SELLER']="";     
                            if (isset($data->sheets[0]['cells'][$i][1])) {                                
                                $excel_row['IM_CAT_SPEC_CATEGORY_ID']=$data->sheets[0]['cells'][$i][1];                                                                   
                            }
                            if (isset($data->sheets[0]['cells'][$i][2])) {
                               $excel_row['IM_CAT_SPEC_CATEGORY_TYPE']=$data->sheets[0]['cells'][$i][2];
                            }
                            if (isset($data->sheets[0]['cells'][$i][3])) {
                               $excel_row['IM_SPEC_MASTER_DESC']=$data->sheets[0]['cells'][$i][3];
                            }
                            if (isset($data->sheets[0]['cells'][$i][4])) {
                               $excel_row['IM_SPEC_MASTER_FULL_DESC']=$data->sheets[0]['cells'][$i][4];
                            } 
                            
                            if (isset($data->sheets[0]['cells'][$i][5])) {
                               $excel_row['IM_SPEC_MASTER_BUYER_SELLER']=$data->sheets[0]['cells'][$i][5];
                            }
                            if (isset($data->sheets[0]['cells'][$i][6])) {
                               $excel_row['IM_SPEC_MASTER_TYPE']=$data->sheets[0]['cells'][$i][6];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][7])) {                                
                                    $excel_row['IM_CAT_SPEC_PRIORITY']=$data->sheets[0]['cells'][$i][7];                                   
                            }
                            if (isset($data->sheets[0]['cells'][$i][8])) {
                               $excel_row['IM_CAT_SPEC_STATUS']=$data->sheets[0]['cells'][$i][8];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][9])) {
                               $excel_row['IM_SPEC_OPTIONS_DESC']=$data->sheets[0]['cells'][$i][9];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][10])) {
                               $excel_row['IM_SPEC_OPTIONS_STATUS']=$data->sheets[0]['cells'][$i][10];
                            } 
                            if (isset($data->sheets[0]['cells'][$i][11])) {
                               $excel_row['IM_SPEC_OPT_BUYER_SELLER']=$data->sheets[0]['cells'][$i][11];
                            }
                           

                            if(is_numeric($excel_row['IM_CAT_SPEC_CATEGORY_ID']) &&  $excel_row['IM_CAT_SPEC_CATEGORY_ID']>0 && $excel_row['IM_CAT_SPEC_CATEGORY_TYPE'] >2 && $excel_row['IM_SPEC_MASTER_DESC']<>'' && $excel_row['IM_SPEC_MASTER_BUYER_SELLER']<>'' && $excel_row['IM_SPEC_MASTER_TYPE']<>'' && $excel_row['IM_CAT_SPEC_PRIORITY']<>'' && $excel_row['IM_SPEC_OPTIONS_DESC']<>'' && $excel_row['IM_SPEC_OPTIONS_STATUS']<>'' && $excel_row['IM_SPEC_OPT_BUYER_SELLER']<>''){                            
                                  $IM_CAT_SPEC_CATEGORY_ID=   $excel_row['IM_CAT_SPEC_CATEGORY_ID'];
				  $IM_CAT_SPEC_CATEGORY_TYPE=   $excel_row['IM_CAT_SPEC_CATEGORY_TYPE'];  
                                   if($CATEGORY_ID !=$excel_row['IM_CAT_SPEC_CATEGORY_ID'])
                                   {
                                    $n++;
                                    $m=0;
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_CATEGORY_ID']=$excel_row['IM_CAT_SPEC_CATEGORY_ID'];
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_CATEGORY_TYPE']=$excel_row['IM_CAT_SPEC_CATEGORY_TYPE'];
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_DESC']=utf8_decode($excel_row['IM_SPEC_MASTER_DESC']);
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_FULL_DESC']=utf8_decode($excel_row['IM_SPEC_MASTER_FULL_DESC']);
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_BUYER_SELLER']=$excel_row['IM_SPEC_MASTER_BUYER_SELLER'];
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_TYPE']=$excel_row['IM_SPEC_MASTER_TYPE'];
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_PRIORITY']=$excel_row['IM_CAT_SPEC_PRIORITY'];
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_STATUS']=$excel_row['IM_CAT_SPEC_STATUS'];
                                    $finalDataArr[$n][$m]['IM_SPEC_OPTIONS_DESC']=utf8_decode($excel_row['IM_SPEC_OPTIONS_DESC']);
                                    $finalDataArr[$n][$m]['IM_SPEC_OPTIONS_STATUS']=$excel_row['IM_SPEC_OPTIONS_STATUS'];
                                    $finalDataArr[$n][$m]['IM_SPEC_OPT_BUYER_SELLER']=$excel_row['IM_SPEC_OPT_BUYER_SELLER'];
                                    $CATEGORY_ID=$excel_row['IM_CAT_SPEC_CATEGORY_ID'];
                                   }
                                   else
                                   {                                     
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_CATEGORY_ID']=$excel_row['IM_CAT_SPEC_CATEGORY_ID'];
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_CATEGORY_TYPE']=$excel_row['IM_CAT_SPEC_CATEGORY_TYPE'];
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_DESC']=utf8_decode($excel_row['IM_SPEC_MASTER_DESC']);
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_FULL_DESC']=utf8_decode($excel_row['IM_SPEC_MASTER_FULL_DESC']);
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_BUYER_SELLER']=$excel_row['IM_SPEC_MASTER_BUYER_SELLER'];
                                    $finalDataArr[$n][$m]['IM_SPEC_MASTER_TYPE']=$excel_row['IM_SPEC_MASTER_TYPE'];
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_PRIORITY']=$excel_row['IM_CAT_SPEC_PRIORITY'];
                                    $finalDataArr[$n][$m]['IM_CAT_SPEC_STATUS']=$excel_row['IM_CAT_SPEC_STATUS'];
                                    $finalDataArr[$n][$m]['IM_SPEC_OPTIONS_DESC']=utf8_decode($excel_row['IM_SPEC_OPTIONS_DESC']);
                                    $finalDataArr[$n][$m]['IM_SPEC_OPTIONS_STATUS']=$excel_row['IM_SPEC_OPTIONS_STATUS'];
                                    $finalDataArr[$n][$m]['IM_SPEC_OPT_BUYER_SELLER']=$excel_row['IM_SPEC_OPT_BUYER_SELLER'];
                                    $CATEGORY_ID=$excel_row['IM_CAT_SPEC_CATEGORY_ID'];
                                   }
                                      $m++;
                                      $finalmsg['IM_SPECIFICATION_MASTER']='YES';
                                      $finalmsg['IM_CAT_SPECIFICATION']='YES';
                                      $finalmsg['IM_SPECIFICATION_OPTIONS']='YES';                                   
                            }else{
                                 $finalmsg=array('IM_SPECIFICATION_MASTER'=>'Error in Data Format','IM_CAT_SPECIFICATION'=>'Error in Data Format','IM_SPECIFICATION_OPTIONS'=>'Error in Data Format');
                            }			  
                                    $IM_CAT_SPEC_CATEGORY_ID=   "\"" . $excel_row['IM_CAT_SPEC_CATEGORY_ID']. "\"";                                    
                                    $IM_CAT_SPEC_CATEGORY_TYPE=   "\"" . $excel_row['IM_CAT_SPEC_CATEGORY_TYPE']. "\"";                                    
                                    $IM_SPEC_MASTER_DESC= $excel_row['IM_SPEC_MASTER_DESC'];
                                    if($IM_SPEC_MASTER_DESC!=utf8_decode($IM_SPEC_MASTER_DESC))
							  {
							  $IM_SPEC_MASTER_DESC=utf8_decode($IM_SPEC_MASTER_DESC);
							  $IM_SPEC_MASTER_DESC=str_replace("?",'"',$IM_SPEC_MASTER_DESC);
							  }
                                    $IM_SPEC_MASTER_DESC=   "\"" . $IM_SPEC_MASTER_DESC. "\"";  
         
                                    $IM_SPEC_MASTER_FULL_DESC= $excel_row['IM_SPEC_MASTER_FULL_DESC'];
                                    if($IM_SPEC_MASTER_FULL_DESC!=utf8_decode($IM_SPEC_MASTER_FULL_DESC))
							  {
							  $IM_SPEC_MASTER_FULL_DESC=utf8_decode($IM_SPEC_MASTER_FULL_DESC);
							  $IM_SPEC_MASTER_FULL_DESC=str_replace("?",'"',$IM_SPEC_MASTER_FULL_DESC);
							  }
                                    $IM_SPEC_MASTER_FULL_DESC=   "\"" . $IM_SPEC_MASTER_FULL_DESC. "\""; 
                                    
                                    
                                    $IM_SPEC_MASTER_BUYER_SELLER=   "\"" . $excel_row['IM_SPEC_MASTER_BUYER_SELLER']. "\"";             
                                    $IM_SPEC_MASTER_TYPE=   "\"" . $excel_row['IM_SPEC_MASTER_TYPE']. "\"";                
                                    $IM_CAT_SPEC_PRIORITY=   "\"" . $excel_row['IM_CAT_SPEC_PRIORITY']. "\"";     
                                    $IM_CAT_SPEC_STATUS=   "\"" . $excel_row['IM_CAT_SPEC_STATUS']. "\""; 
                                    
                                    $IM_SPEC_OPTIONS_DESC=$excel_row['IM_SPEC_OPTIONS_DESC'];
                                    if($IM_SPEC_OPTIONS_DESC!=utf8_decode($IM_SPEC_OPTIONS_DESC))
							  {
							  $IM_SPEC_OPTIONS_DESC=utf8_decode($IM_SPEC_OPTIONS_DESC);
							  $IM_SPEC_OPTIONS_DESC=str_replace("?",'"',$IM_SPEC_OPTIONS_DESC);
							  }
                                
                                    $IM_SPEC_OPTIONS_DESC=   "\"" .$IM_SPEC_OPTIONS_DESC. "\"";           
                                    $IM_SPEC_OPTIONS_STATUS=   "\"" . $excel_row['IM_SPEC_OPTIONS_STATUS']. "\"";            
                                    $IM_SPEC_OPT_BUYER_SELLER=   "\"" . $excel_row['IM_SPEC_OPT_BUYER_SELLER']. "\"";  
                                    //$REMARK=   "\"" . $finalmsg. "\""; 
                                    $INSERT_STATUS_IM_SPECIFICATION_MASTER=   "\"" .$finalmsg['IM_SPECIFICATION_MASTER']. "\""; 
                                    $INSERT_STATUS_IM_CAT_SPECIFICATION=   "\"" .$finalmsg['IM_CAT_SPECIFICATION']. "\""; 
                                    $INSERT_STATUS_IM_SPECIFICATION_OPTIONS=   "\"" .$finalmsg['IM_SPECIFICATION_OPTIONS']. "\""; 
                                    if($finalmsg=='success'){                                                         
                                        $process_flag = 1;
                                    }
                                       if (fwrite($BBFILE, "$IM_CAT_SPEC_CATEGORY_ID\t $IM_CAT_SPEC_CATEGORY_TYPE\t $IM_SPEC_MASTER_DESC\t $IM_SPEC_MASTER_FULL_DESC\t $IM_SPEC_MASTER_BUYER_SELLER\t $IM_SPEC_MASTER_TYPE\t $IM_CAT_SPEC_PRIORITY\t $IM_CAT_SPEC_STATUS\t $IM_SPEC_OPTIONS_DESC\t $IM_SPEC_OPTIONS_STATUS\t  $IM_SPEC_OPT_BUYER_SELLER\t $INSERT_STATUS_IM_SPECIFICATION_MASTER\t $INSERT_STATUS_IM_CAT_SPECIFICATION\t $INSERT_STATUS_IM_SPECIFICATION_OPTIONS\t\n") === FALSE)
                                        $remark = "Cannot write to file [$filename_out]";


                        }
                    }
                   $z=0;
                   $k=-1;$master_desc='';$cat_id='';
                   for($j=0;$j<count($finalDataArr);$j++)
                   {
                    ${"Arr_CATEGORY_ID".$j}=${"Arr_CATEGORY_TYPE".$j}=${"Arr_MASTER_DESC".$j}=${"Arr_MASTER_FULL_DESC".$j}=${"Arr_MASTER__BUYER_SELLER".$j}=${"Arr_MASTER_TYPE".$j}=${"Arr_SPEC_PRIORITY".$j}=${"Arr_SPEC_STATUS".$j}=${"Arr_MASTER_DESC_UNIQ".$j}=${"Arr_MASTER_TYPE_UNIQ".$j}=array();
                    
                    for($i=0;$i<count($finalDataArr[$j]);$i++)
                    {
                      if(($cat_id ==$finalDataArr[$j][$i]['IM_CAT_SPEC_CATEGORY_ID']) && ($master_desc ==$finalDataArr[$j][$i]['IM_SPEC_MASTER_DESC']))
                      {
                           $z++;
                           ${"Arr_OPTIONS_DESC"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_OPTIONS_DESC'];
                           ${"Arr_OPTIONS_STATUS"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_OPTIONS_STATUS'];
                           ${"Arr_MASTER_TYPE_OPT"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_MASTER_TYPE'];
                           ${"Arr_MASTER_OPT_BUYER_SELLER"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_OPT_BUYER_SELLER'];
                      }
                      else{
                          $z=0;
                            $k++;
                            array_push(${"Arr_MASTER_DESC".$j},$finalDataArr[$j][$i]['IM_SPEC_MASTER_DESC']);
                            array_push(${"Arr_MASTER_FULL_DESC".$j},$finalDataArr[$j][$i]['IM_SPEC_MASTER_FULL_DESC']);
                            array_push(${"Arr_MASTER_BUYER_SELLER".$j},$finalDataArr[$j][$i]['IM_SPEC_MASTER_BUYER_SELLER']);
                            array_push(${"Arr_MASTER_TYPE".$j},$finalDataArr[$j][$i]['IM_SPEC_MASTER_TYPE']);
                            array_push(${"Arr_CATEGORY_ID".$j},$finalDataArr[$j][$i]['IM_CAT_SPEC_CATEGORY_ID']);
                            array_push(${"Arr_CATEGORY_TYPE".$j},$finalDataArr[$j][$i]['IM_CAT_SPEC_CATEGORY_TYPE']);
                            array_push(${"Arr_SPEC_PRIORITY".$j},$finalDataArr[$j][$i]['IM_CAT_SPEC_PRIORITY']);
                            array_push(${"Arr_SPEC_STATUS".$j},$finalDataArr[$j][$i]['IM_CAT_SPEC_STATUS']);
                            ${"Arr_OPTIONS_DESC"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_OPTIONS_DESC'];
                            ${"Arr_OPTIONS_STATUS"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_OPTIONS_STATUS'];
                            ${"Arr_MASTER_TYPE_OPT"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_MASTER_TYPE'];
                            ${"Arr_MASTER_OPT_BUYER_SELLER"}[$k][$z]=$finalDataArr[$j][$i]['IM_SPEC_OPT_BUYER_SELLER'];
                            $master_desc=$finalDataArr[$j][$i]['IM_SPEC_MASTER_DESC'];
                            $cat_id=$finalDataArr[$j][$i]['IM_CAT_SPEC_CATEGORY_ID'];
                          
                       }                      
                    }                   
                    
                    $Arr_MASTER_DESC=array_merge($Arr_MASTER_DESC,${"Arr_MASTER_DESC".$j});
                    $Arr_MASTER_FULL_DESC=array_merge($Arr_MASTER_FULL_DESC,${"Arr_MASTER_FULL_DESC".$j});                    
                    $Arr_MASTER_BUYER_SELLER=array_merge($Arr_MASTER_BUYER_SELLER,${"Arr_MASTER_BUYER_SELLER".$j});
                    $Arr_MASTER_TYPE=array_merge($Arr_MASTER_TYPE,${"Arr_MASTER_TYPE".$j});
                    $Arr_CATEGORY_ID=array_merge($Arr_CATEGORY_ID,${"Arr_CATEGORY_ID".$j});
                    $Arr_CATEGORY_TYPE=array_merge($Arr_CATEGORY_TYPE,${"Arr_CATEGORY_TYPE".$j});
                    $Arr_SPEC_PRIORITY=array_merge($Arr_SPEC_PRIORITY,${"Arr_SPEC_PRIORITY".$j});
                    $Arr_SPEC_STATUS=array_merge($Arr_SPEC_STATUS,${"Arr_SPEC_STATUS".$j});
                    $Arr_SPEC_MASTER_BUYER_SELLER=array_merge($Arr_SPEC_MASTER_BUYER_SELLER,${"Arr_SPEC_MASTER_BUYER_SELLER".$j});
                   }
                   $screen='GLADMIN(Bulk Upload)';
                   
                 if(!empty($Arr_MASTER_DESC)){ 
                 $QuesMasterId=$glEtoModel->ADDISQ_IM_SPECIFICATION_MASTER($empName,'',$histip,$Arr_MASTER_DESC,$Arr_MASTER_FULL_DESC,$Arr_MASTER_TYPE,$Arr_MASTER_BUYER_SELLER,$update,$screen);
                 
                 
		  if(!empty($QuesMasterId))
		  {
		    $msg=$glEtoModel->ADDISQ_IM_CAT_SPECIFICATION($empName,$histip,$QuesMasterId,$Arr_CATEGORY_ID,$Arr_CATEGORY_TYPE,$Arr_SPEC_PRIORITY,$Arr_SPEC_STATUS,$update,$screen);
		  }
		  
		  if($msg =='SUCCESS')
		  {
			$OPTIONS_DESCArray=array();
			$QuesMasterId1=array();
			$OPTStatus=array();
			$OPTIONS_ForArray=array();
			$QuestypeArray=array();
			for($i=0;$i<count($Arr_OPTIONS_DESC);$i++)
			{
			  foreach($Arr_OPTIONS_DESC[$i] as $x)
			  {
			    array_push($OPTIONS_DESCArray,$x);
			    array_push($QuesMasterId1,$QuesMasterId[$i]);
			  }
			  foreach($Arr_MASTER_OPT_BUYER_SELLER[$i] as $x)
			  {
			    array_push($OPTIONS_ForArray,$x);
			  }
			  foreach($Arr_OPTIONS_STATUS[$i] as $x)
			  {
			    array_push($OPTStatus,$x);
			  }
			  
			  foreach($Arr_MASTER_TYPE_OPT[$i] as $x)
			  {
			    array_push($QuestypeArray,$x);
			  }			  
			}
			
			    $msg2=$glEtoModel->ADDISQ_IM_SPECIFICATION_OPTIONS($empName,'',$histip,$QuesMasterId1,$OPTIONS_DESCArray,$OPTStatus,$OPTIONS_ForArray,$QuestypeArray,$update,$screen);
			    
			    if($msg2 =='SUCCESS')
			    {
			    $process_flag=1;
			    }
		  
		  }
		}  

                        if ($process_flag == 1) {
                            print <<<jk
<script language="JavaScript" type="text/javascript">
                        document.getElementById('processing').style.display = "none";
                        </script>
jk;
                        }
                    if($msg2 =='SUCCESS')
                    {
                        
                        fclose($BBFILE);                       
                        chmod($filename_out, 0755);
                        $file_size = filesize($filename_out);
                        $handle    = fopen($filename_out, "r");
                        $content   = fread($handle, $file_size);
                        fclose($handle);
                        $content = chunk_split(base64_encode($content));
                      
                         $this->mailsent($content,$filename_out,$process_time,$action);
                       
                        unlink("$filename_out");
                        unlink("$filename_input");
                        print <<<kl
<table style="border-collapse: collapse; width:98%" class="table_txt" align="center" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0"><TR><TD bgcolor="#F0F9FF">Process Complete. Please Check Your Mail For Summary.</TD></TR></TABLE>
kl;
                        print <<<op
<script language="JavaScript" type="text/javascript">
                    document.getElementById('disable').disabled=true;document.getElementById('Upload').disabled=false;
                    </script>
op;
                        $j++;
                    } else {
                        print <<<bh
<script language="JavaScript" type="text/javascript">
                        document.getElementById('disable').disabled=true;
                        </script>
bh;
                    }
                    
                    
                    }
                    
                        }
                    }
                }
            }
        
    
   
public function mailsent($content,$filename_out,$process_time,$action){  
                        
                        $empname       = Yii::app()->session['empname'];
                        $empmail     = Yii::app()->session['empemail'];  
                        $subject=''; $body='';
                        $mailbody = "Hi $empname !";                       
                        $to       = "$empname<$empmail>";
                        if($action=='BB_ADD'){
                            $subject='ISQ Bulk Creation Status Report [Start Time : '.$process_time . " End Time : " . date("F j, Y, g:i a") .")";                        
                            $body     = "Please find the attached excel file for complete status of ISQ Bulk Creation\n\n";   
                        }elseif($action=='copy'){
                            $subject='ISQ Bulk Copy Status Report [Start Time : '.$process_time . " End Time : " . date("F j, Y, g:i a") ."]";                        
                            $body     = "Please find the attached excel file for complete status of ISQ Bulk Copy\n\n"; 
                        }
                        
			  $uid     = md5(uniqid(time()));
			  $message = "";
			  $header  = "From: Gladmin-Team <gladmin-team@indiamart.com>\r\n";
			  if (($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') or ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')) {
						  $header .= "Cc: laxmi@indiamart.com \r\n";
					      }else{
						  $header .= "Cc: gladmin-team@indiamart.com \r\n";
					      }
			  $header .= "Reply-To: " . $to . "\r\n";
			  $header .= "MIME-Version: 1.0\r\n";
			  $header .= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";

			  $message .= "This is a multi-part message in MIME format.\r\n";
			  $message .= "--" . $uid . "\r\n";
			  $message .= "Content-type:text/plain; charset=iso-8859-1\r\n". $body;
			  $message .= "--" . $uid . "\r\n";
			  $message .= "Content-Type: application/ms-excel; name=\"" . $filename_out . "\"\r\n";
			  $message .= "Content-Transfer-Encoding: base64\r\n";
			  $message .= "Content-Disposition: attachment; filename=\"" . $filename_out . "\"\r\n\r\n";
			  $message .= $content . "\r\n\r\n";
			  $message .= "--" . $uid . "--";
			 
			  if (mail($to, $subject,$message, $header));
			  else
			    echo "mail send ... ERROR!";
		  
                        
                        
               
}


  }

?>