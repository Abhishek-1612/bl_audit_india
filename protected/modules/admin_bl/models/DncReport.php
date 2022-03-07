<?php

class DncReport extends CFormModel
{
   public function DNCform()
   {
      $model = new GlobalmodelForm();
	$conn_obj=new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
        }
      $sql="SELECT DISTINCT FK_GL_MODULE_ID FROM ETO_OFR ORDER BY FK_GL_MODULE_ID ASC";
      $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
      $rec=$sth->readAll();
      return $rec;
   }
   
	public function DNCData($request)
	{
		$model = new GlobalmodelForm();
                $conn_obj=new Globalconnection();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
                }
		$country=$request->getParam('country','');
		$data=$request->getParam('data','');
		$type=$request->getParam('type','');
		$modid=$request->getParam('modid','');
		$trend=$request->getParam('trend','');
		$modid=$request->getParam('modid','');
		$start_date=$request->getParam('start_date','');
		$end_date=$request->getParam('end_date','');
		$source=$request->getParam('source','');
		$pool=$request->getParam('pool','');
		
		$sqlcond4 = $sqlcond5 = "";$recData=array();
		$column = $column2=" USER_IDENTIFIER_FLAG";
		
		if($source =='FENQ'){
			$sqlcond7= " AND FK_GL_MODULE_ID ='FENQ'";
		}
		elseif($source =='DIRECT'){
			$sqlcond7= " AND coalesce(FK_GL_MODULE_ID,0) <>'FENQ'";
		}
		elseif($source =='all'){
			$sqlcond7= "";
		}

		if($trend =='datewise')
		{ 
			if($data =='approval')
			{
				$column3="DATE(eto_ofr_approv_date_orig)";
				$dateCond1=" AND DATE(eto_ofr_approv_date_orig)>=to_date(:st_date,'DD-MON-YYYY')
				AND DATE(eto_ofr_approv_date_orig)<=to_date(:ed_date,'DD-MON-YYYY')";
			}
			else
			{ 
				$column3="DATE(ETO_OFR_POSTDATE_ORIG)";
				$dateCond1=" AND DATE(ETO_OFR_POSTDATE_ORIG)>=to_date(:st_date,'DD-MON-YYYY')
				AND DATE(ETO_OFR_POSTDATE_ORIG)<=to_date(:ed_date,'DD-MON-YYYY')";
			}
			$column4="DATE(DATE_R)";
			$dateCond2=" AND DATE(DATE_R)>=to_date(:st_date,'DD-MON-YYYY')
			AND DATE(DATE_R)<=to_date(:ed_date,'DD-MON-YYYY')";
		}
		
		if($trend =='hourly')
		{
			if($data =='approval'){
				$column3="to_char(eto_ofr_approv_date_orig,'HH24')";
				$dateCond1=" AND DATE(eto_ofr_approv_date_orig)=to_date(:st_date,'DD-MON-YYYY')";
			}
			else
			{
				$column3="to_char(ETO_OFR_POSTDATE_ORIG,'HH24')";
				$dateCond1=" AND DATE(ETO_OFR_POSTDATE_ORIG)=to_date(:st_date,'DD-MON-YYYY')";
			}
			$column4="to_char(DATE_R,'HH24')";
			$dateCond2=" AND DATE(DATE_R)=to_date(:st_date,'DD-MON-YYYY')";
		} 
     	 
		if($type =='modidwise')
		{
			$column=" FK_GL_MODULE_ID";
			$column2=" QUERY_MODID";
		}
				
		if($modid <>'ALL')
		{
			$sqlcond4 = " AND FK_GL_MODULE_ID ='$modid'";
			$sqlcond5 = " AND QUERY_MODID ='$modid'";
		}
		
		$identifier = 'DNC_COUNT';
		if($pool == 'MUSTCALL'){
			$identifier = 'MUST_CALL_COUNT';
		}elseif($pool == 'INTENT'){
			$identifier = 'INTENT_COUNT';
		}

		if($country =='india'){
			$count_col="COUNT(CASE WHEN $identifier > 0 AND SERVICE_COUNT=0 AND FOREIGN_COUNT=0 THEN ETO_OFR_DISPLAY_ID END) CNT";
		}elseif($country =='foreign'){
			$count_col="COUNT(CASE WHEN FOREIGN_COUNT > 0 THEN ETO_OFR_DISPLAY_ID END) CNT";
		}else{
		   $count_col="COUNT(CASE WHEN (FOREIGN_COUNT > 0 OR ($identifier > 0 AND SERVICE_COUNT=0 AND FOREIGN_COUNT=0)) THEN ETO_OFR_DISPLAY_ID END) CNT"; 
		} 	
     
		if($data =='generation')
		{
			$sqlcond3 ="";
			if($source =='FENQ')
			{
				$sql="SELECT 
				$column,ETO_OFR_POSTDATE_ORIG,$count_col 
				FROM
				(SELECT
				ETO_OFR_DISPLAY_ID,$column,ETO_OFR_POSTDATE_ORIG,
				COUNT(CASE
				WHEN  S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1
				WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1 END) FOREIGN_COUNT,
				COUNT(CASE WHEN
				coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1 END) PROCMAT_COUNT,
				COUNT(CASE WHEN 
				coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,22,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1 END) DNC_COUNT,
				COUNT(CASE WHEN
				coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1 END) SERVICE_COUNT,
				COUNT(CASE WHEN
				S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1
				 END) MUST_CALL_COUNT,
				COUNT(CASE WHEN
				coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1 END) INTENT_COUNT
				FROM (
				SELECT eto_ofr_display_id,S_COUNTRY_UPPER,QUERY_MODID FK_GL_MODULE_ID,USER_IDENTIFIER_FLAG,
				$column4 ETO_OFR_POSTDATE_ORIG
				FROM DIR_QUERY_FREE
				WHERE  1=1
				$sqlcond5
				$dateCond2
				AND DIR_QUERY_FREE_BL_TYP= 2       
				UNION ALL
				SELECT DIR_QUERY_FREE_REFID eto_ofr_display_id,S_COUNTRY_UPPER,QUERY_MODID FK_GL_MODULE_ID,USER_IDENTIFIER_FLAG,
				$column4  ETO_OFR_POSTDATE_ORIG
				FROM ETO_OFR_FROM_FENQ
				WHERE 1=1
				$sqlcond5
				$dateCond2
				UNION ALL 
				SELECT DIR_QUERY_FREE_REFID eto_ofr_display_id,S_COUNTRY_UPPER,QUERY_MODID FK_GL_MODULE_ID,USER_IDENTIFIER_FLAG,
				$column4  ETO_OFR_POSTDATE_ORIG
				FROM ETO_OFR_FROM_FENQ_ARCH
				WHERE 1=1
				$sqlcond5
				$dateCond2
				) A GROUP BY ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,$column 
				)B 
				GROUP BY $column,ETO_OFR_POSTDATE_ORIG order by ETO_OFR_POSTDATE_ORIG ASC";
			}
			elseif($source =='DIRECT')
			{
				$sql="SELECT 
				$column,ETO_OFR_POSTDATE_ORIG,$count_col 
			   FROM
			   (SELECT
			   ETO_OFR_DISPLAY_ID,$column,ETO_OFR_POSTDATE_ORIG,
			   COUNT(CASE
			   WHEN ETO_OFR_CALL_DISPOSITION_TYPE='Non Calling Window' THEN 1
			   WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1 END) FOREIGN_COUNT,
			   COUNT(CASE
			   WHEN ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID='PROCMART' THEN 1
			   WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1 END) PROCMAT_COUNT,
			   COUNT(CASE
			   WHEN ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID<>'PROCMART' THEN 1
			   WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1 END) DNC_COUNT,
			   COUNT(CASE
			   WHEN ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
			   WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1 END) SERVICE_COUNT,
			   COUNT(CASE
			   WHEN ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) NOT IN (11,12,17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
			   WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1 END) MUST_CALL_COUNT,
			   COUNT(CASE
			   WHEN ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
			   WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1 END) INTENT_COUNT
			   FROM 
				(SELECT ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,eto_ofr_display_id,FK_GL_MODULE_ID,
				$column3 ETO_OFR_POSTDATE_ORIG 
				FROM eto_ofr
				WHERE 1=1
				$sqlcond4
				$dateCond1
				AND  FK_GL_MODULE_ID<>'FENQ'
				UNION ALL 
				SELECT ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,S_COUNTRY_UPPER,eto_ofr_display_id,QUERY_MODID FK_GL_MODULE_ID,
				$column4 ETO_OFR_POSTDATE_ORIG
				FROM DIR_QUERY_FREE
				WHERE  1=1
				$sqlcond5
				$dateCond2
				AND DIR_QUERY_FREE_BL_TYP             = 1
				UNION ALL 
				SELECT ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,eto_ofr_display_id,FK_GL_MODULE_ID,
				$column3 ETO_OFR_POSTDATE_ORIG
				FROM eto_ofr_expired
				WHERE 1=1  

				$sqlcond4
				$dateCond1
				AND  FK_GL_MODULE_ID<>'FENQ'
				UNION ALL 
				SELECT ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,eto_ofr_display_id,FK_GL_MODULE_ID,
				$column3 ETO_OFR_POSTDATE_ORIG
				FROM eto_ofr_temp_del
				WHERE  1=1
				$sqlcond4
				$dateCond1
				AND  FK_GL_MODULE_ID<>'FENQ'
				UNION ALL 
				SELECT ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,eto_ofr_display_id, FK_GL_MODULE_ID,
				$column3  ETO_OFR_POSTDATE_ORIG
				FROM eto_ofr_temp_del_arch
				WHERE  1=1
				$sqlcond4
				$dateCond1
				AND  FK_GL_MODULE_ID<>'FENQ'
				 ) A GROUP BY ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,$column 
				)B 
				GROUP BY $column,ETO_OFR_POSTDATE_ORIG order by ETO_OFR_POSTDATE_ORIG ASC";
			}
			elseif($source =='all')
			{
				$sql="SELECT 
				 $column,ETO_OFR_POSTDATE_ORIG,$count_col 
				FROM
				(SELECT
				ETO_OFR_DISPLAY_ID,$column,ETO_OFR_POSTDATE_ORIG,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Non Calling Window' THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1
				WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1 END) FOREIGN_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID='PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1 END) PROCMAT_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID<>'PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1 END) DNC_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1 END) SERVICE_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) NOT IN (11,12,17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1
				WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1 END) MUST_CALL_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1 END) INTENT_COUNT
				FROM (

				SELECT 1 BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,$column3 ETO_OFR_POSTDATE_ORIG , FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR
				WHERE 1=1 $dateCond1 AND FK_GL_MODULE_ID<>'FENQ'
				UNION
				SELECT 1 BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID, $column3 ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_EXPIRED
				WHERE 1=1 $dateCond1 AND FK_GL_MODULE_ID<>'FENQ'
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID FK_GL_MODULE_ID,$column4 ETO_OFR_POSTDATE_ORIG, S_COUNTRY_UPPER
				FROM DIR_QUERY_FREE WHERE 1=1 $dateCond2
				UNION
				SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID FK_GL_MODULE_ID,
					$column4  ETO_OFR_POSTDATE_ORIG, S_COUNTRY_UPPER
				FROM
				ETO_OFR_FROM_FENQ WHERE 1=1 $dateCond2
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID, $column3 ETO_OFR_POSTDATE_ORIG, FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL WHERE 1=1 $dateCond1 AND FK_GL_MODULE_ID<>'FENQ'
				UNION
				SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID FK_GL_MODULE_ID,
					$column4  ETO_OFR_POSTDATE_ORIG, S_COUNTRY_UPPER
				FROM
				ETO_OFR_FROM_FENQ_ARCH WHERE 1=1 $dateCond2
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID, $column3 ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL_ARCH WHERE 1=1 $dateCond1 AND FK_GL_MODULE_ID<>'FENQ'
				) A GROUP BY ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,$column 
				) B 
				GROUP BY $column,ETO_OFR_POSTDATE_ORIG order by ETO_OFR_POSTDATE_ORIG ASC";
				
			}
		}
		elseif($data =='deletion')
		{
			$deltype=$request->getParam('deltypye','');
			
			$column6=" to_char(ETO_OFR_DELETIONDATE,'HH24')";
            $column7=" to_char(ETO_OFR_FENQ_DATE,'HH24')";
			
			if($deltype =='auto')
			{
				$delCond1=" AND (ETO_OFR_DELETEDBYID <= 0 OR ETO_OFR_DELETEDBYID is NULL) ";
				$delCond2=" AND (ETO_OFR_FENQ_EMP_ID <= 0  OR ETO_OFR_FENQ_EMP_ID is null)";
			}elseif($deltype =='mannual'){
				$delCond1=" AND ETO_OFR_DELETEDBYID > 0 ";
				$delCond2=" AND ETO_OFR_FENQ_EMP_ID > 0";
			}elseif($deltype =='all')
			{
				$delCond1 = $delCond2 = "";
			}

			if($trend !='hourly')
            {
				$column6=" DATE(ETO_OFR_DELETIONDATE)";
				$column7=" DATE(ETO_OFR_FENQ_DATE)";
            }
        
			$datecondd1=$datecondd2='';
			if($trend =='datewise')
			{ 
				$datecondd1 .=" DATE(ETO_OFR_FENQ_DATE) between TO_DATE(:st_date,'DD-MON-YYYY') and TO_DATE(:ed_date,'DD-MON-YYYY') ";
				$datecondd2 .=" DATE(ETO_OFR_DELETIONDATE) between TO_DATE(:st_date,'DD-MON-YYYY') and TO_DATE(:ed_date,'DD-MON-YYYY') ";
			}
			if($trend =='hourly')
			{ 
				$datecondd1 .=" DATE(ETO_OFR_FENQ_DATE) = TO_DATE(:st_date,'DD-MON-YYYY') ";
				$datecondd2 .=" DATE(ETO_OFR_DELETIONDATE) = TO_DATE(:st_date,'DD-MON-YYYY') ";
			}
	      
			if($source =='FENQ')
			{   	  
				$sql="SELECT 
				$column,ETO_OFR_POSTDATE_ORIG,$count_col 
				FROM
				(SELECT
				ETO_OFR_DISPLAY_ID,$column,ETO_OFR_POSTDATE_ORIG,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Non Calling Window' THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1
				WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1 END) FOREIGN_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID='PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1 END) PROCMAT_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID<>'PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1 END) DNC_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1 END) SERVICE_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) NOT IN (11,12,17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1
				WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1 END) MUST_CALL_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1 END) INTENT_COUNT
				FROM (

				SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID FK_GL_MODULE_ID,$column7 ETO_OFR_POSTDATE_ORIG ,S_COUNTRY_UPPER
				FROM ETO_OFR_FROM_FENQ WHERE $datecondd1 $delCond2 AND FK_ETO_OFR_ID IS NULL
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,$column6 ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL WHERE $datecondd2 $delCond1 AND coalesce(FK_GL_MODULE_ID,0)='FENQ'
				UNION
				SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID FK_GL_MODULE_ID,$column7 ETO_OFR_POSTDATE_ORIG, S_COUNTRY_UPPER
				FROM ETO_OFR_FROM_FENQ_ARCH WHERE $datecondd1 $delCond2 AND FK_ETO_OFR_ID IS NULL
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,$column6  ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL_ARCH WHERE $datecondd2 $delCond1 AND coalesce(FK_GL_MODULE_ID,0)='FENQ'

				) A GROUP BY ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,$column 
				) B 

				GROUP BY $column,ETO_OFR_POSTDATE_ORIG order by ETO_OFR_POSTDATE_ORIG ASC";
		
			}		
			elseif($source =='DIRECT')
			{    
				$sql="SELECT 
				$column,ETO_OFR_POSTDATE_ORIG,$count_col 
				FROM
				(SELECT
				ETO_OFR_DISPLAY_ID,$column,ETO_OFR_POSTDATE_ORIG,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Non Calling Window' THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1
				WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1 END) FOREIGN_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID='PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1 END) PROCMAT_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID<>'PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1 END) DNC_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1 END) SERVICE_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) NOT IN (11,12,17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1
				WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1 END) MUST_CALL_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1 END) INTENT_COUNT
				FROM (
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,$column6 ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL WHERE $datecondd2 $delCond1 AND coalesce(FK_GL_MODULE_ID,0)<>'FENQ'
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,$column6  ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL_ARCH WHERE $datecondd2 $delCond1 AND coalesce(FK_GL_MODULE_ID,0)<>'FENQ'

				) A GROUP BY ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,$column 
				)B 

				GROUP BY $column,ETO_OFR_POSTDATE_ORIG order by ETO_OFR_POSTDATE_ORIG ASC";
			}
			elseif($source =='all')
			{ 
				$sql="SELECT 
				$column,ETO_OFR_POSTDATE_ORIG,$count_col 
				FROM
				(SELECT
				ETO_OFR_DISPLAY_ID,$column,ETO_OFR_POSTDATE_ORIG,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Non Calling Window' THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1
				WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 1 END) FOREIGN_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID='PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 1 END) PROCMAT_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Do Not Call' AND FK_GL_MODULE_ID<>'PROCMART' THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 1 END) DNC_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 1 END) SERVICE_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) NOT IN (11,12,17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1
				WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 1 END) MUST_CALL_COUNT,
				COUNT(CASE
				WHEN BL_TYPE=1 AND ETO_OFR_CALL_DISPOSITION_TYPE='Validated' AND coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN BL_TYPE=2 AND coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1
				WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79) THEN 1 END) INTENT_COUNT
				FROM (

				SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID FK_GL_MODULE_ID,$column7 ETO_OFR_POSTDATE_ORIG ,S_COUNTRY_UPPER
				FROM ETO_OFR_FROM_FENQ WHERE $datecondd1 $delCond2 AND FK_ETO_OFR_ID IS NULL
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,$column6 ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL WHERE $datecondd2 $delCond1
				UNION
				SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID FK_GL_MODULE_ID,$column7 ETO_OFR_POSTDATE_ORIG, S_COUNTRY_UPPER
				FROM ETO_OFR_FROM_FENQ_ARCH WHERE $datecondd1 $delCond2 AND FK_ETO_OFR_ID IS NULL
				UNION
				SELECT 2 BL_TYPE,ETO_OFR_DISPLAY_ID,NULL ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,$column6  ETO_OFR_POSTDATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER
				FROM ETO_OFR_TEMP_DEL_ARCH WHERE $datecondd2 $delCond1

				) A GROUP BY ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,$column 
				) B GROUP BY $column,ETO_OFR_POSTDATE_ORIG order by ETO_OFR_POSTDATE_ORIG ASC";
        
			}
		}
		else
		{
			$sqlcond3 =" AND ETO_OFR_APPROV='A'";
				
			$pool = $_REQUEST['pool'];
			if($pool == 'DNC')
			{
				if($country =='india'){
					$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=16 ";
				}
				elseif($country =='foreign'){
					$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=15 ";
				}
				else{
					$sqlcond2 =" AND (coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=16 OR coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=15) ";
				}
				$sqlcond2 .= " AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23)";

			}
			elseif($pool == 'MUSTCALL')
			{
				$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 ";
				if($country =='india'){
					$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 AND ETO_OFR_S_COUNTRY = 'India' ";
				}
				elseif($country =='foreign'){
					$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 AND ETO_OFR_S_COUNTRY <> 'India' ";
				}
				$sqlcond2 .= " AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59)";
			}
			elseif($pool == 'INTENT')
			{
				$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 ";
				if($country =='india'){
					$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 AND ETO_OFR_S_COUNTRY = 'India' ";
				}
				elseif($country =='foreign'){
					$sqlcond2 =" AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 AND ETO_OFR_S_COUNTRY <> 'India' ";
				}
				$sqlcond2 .= " AND coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)";
			}	
			
			if($source =='all' || $source =='DIRECT')
			{     
				$sqlcond2 = substr($sqlcond2, 4);
				$sql="select count(eto_ofr_display_id) CNT,$column,ETO_OFR_POSTDATE_ORIG
				FROM
				(SELECT eto_ofr_display_id,$column,
				$column3 ETO_OFR_POSTDATE_ORIG 
				FROM eto_ofr
				where 
				$sqlcond2
				$sqlcond3
				$sqlcond4
				$dateCond1
				$sqlcond7
				UNION ALL 
				SELECT eto_ofr_display_id,$column,
				$column3 ETO_OFR_POSTDATE_ORIG
				FROM eto_ofr_expired
				where
				$sqlcond2
				$sqlcond3
				$sqlcond4
				$dateCond1
				$sqlcond7
				) OFR
				GROUP BY $column,ETO_OFR_POSTDATE_ORIG 
				order by ETO_OFR_POSTDATE_ORIG ASC";
    
			}
			elseif($source =='FENQ')
			{
				if($trend !='hourly'){
					$column6=" DATE(ETO_OFR_APPROV_DATE_ORIG)";
					$datefencon=" AND DATE(ETO_OFR_APPROV_DATE_ORIG) >= TO_DATE(:st_date,'DD-MON-YYYY') 
					AND DATE(ETO_OFR_APPROV_DATE_ORIG) <= TO_DATE(:ed_date,'DD-MON-YYYY') ";
				}
				else{
					$column6=" to_char(ETO_OFR_APPROV_DATE_ORIG,'HH24')";				
					$datefencon=" AND DATE(ETO_OFR_APPROV_DATE_ORIG) = TO_DATE(:st_date,'DD-MON-YYYY') ";
				}
            
				if($type =='modidwise')
				{
					$column1=" FK_GL_MODULE_ID";
					$column2=" QUERY_MODID";
				}
				else
				{
					$column1=" USER_IDENTIFIER_FLAG";
					$column2=" USER_IDENTIFIER_FLAG";
				}
            
        
        
				$sql="SELECT
						COUNT(ETO_OFR_DISPLAY_ID) CNT,
						$column1,
						ETO_OFR_POSTDATE_ORIG
					FROM (
					SELECT
						DISTINCT ETO_OFR_DISPLAY_ID ,$column2 $column1,ETO_OFR_APPROV_DATE_ORIG ETO_OFR_POSTDATE_ORIG
					FROM
						(SELECT FK_ETO_OFR_ID,$column2,FK_QUERY_ID FROM ETO_OFR_FROM_FENQ 
						UNION all
						SELECT FK_ETO_OFR_ID,$column2,FK_QUERY_ID FROM ETO_OFR_FROM_FENQ_ARCH
						) B,
						(
							SELECT
								ETO_OFR_DISPLAY_ID,$column6 ETO_OFR_APPROV_DATE_ORIG
							FROM
								ETO_OFR
							WHERE
								ETO_OFR_TYP = 'B'
								AND ETO_OFR_APPROV='A'  AND FK_GL_MODULE_ID = 'FENQ'
								$datefencon
								$sqlcond2
							UNION
							SELECT
								ETO_OFR_DISPLAY_ID,$column6 ETO_OFR_APPROV_DATE_ORIG
							FROM
								ETO_OFR_EXPIRED
							WHERE
								ETO_OFR_TYP = 'B'
								AND ETO_OFR_APPROV='A' AND FK_GL_MODULE_ID = 'FENQ'
								$datefencon
								$sqlcond2
						) A
					WHERE
						FK_ETO_OFR_ID= ETO_OFR_DISPLAY_ID
					) B 
					group by $column1,ETO_OFR_POSTDATE_ORIG";
      
	
        
			}
		}    
     
		$bind[':st_date']=$start_date;
		if($trend !='hourly')
		{
			$bind[':ed_date']=$end_date;
		}
	 	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
                while($recResult = $sth->read()){     
                array_push($recData,array_change_key_case($recResult, CASE_UPPER)); 
		}
                return $recData;
	}
   public function ondemandDNC()
   { 
        $model = new GlobalmodelForm();
        $obj_conn = new Globalconnection(); 	
        $dbh = $obj_conn->connect_db_yii('imblR');
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj_conn->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj_conn->connect_db_yii('postgress_web68v'); 
        }
        $country = $_REQUEST['country'];
        $cntryArr = array('india' => 2,'foreign' => 3,'both' => 0);
        $cntryFlag = isset($cntryArr[$country])?$cntryArr[$country]:0;
        $start_date=$_REQUEST['start_date'];
        $end_date=$_REQUEST['end_date'];    
        $request=$_REQUEST['req'];
	$countrycond=$countrycond1='';	
        $pool = $_REQUEST['pool'];
        if($country=='india'){
            $countrycond=" AND FK_GL_COUNTRY_ISO='IN' ";
            $countrycond1=" AND S_COUNTRY_UPPER='IN' ";           
        }elseif($country=='foreign'){
            $countrycond=" AND FK_GL_COUNTRY_ISO<>'IN' ";
            $countrycond1=" AND S_COUNTRY_UPPER<>'IN' ";
        }
        $dispositionId = 16;
        $identifierCond = "(NVL(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23)";
        $identifierCond1 = " AND NVL(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23)";

        $identifierCond_pg = "(coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23)";
        $identifierCond1_pg = " AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23)";

                
        $identifierName = 'DNC_COUNT';

        if($pool == 'MUSTCALL'){
                $dispositionId = 0;
                $identifierCond_pg = "(coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59)";
                $identifierCond1_pg = " AND (coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59)";

                $identifierCond = "(NVL(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59)";
                $identifierCond1_pg = " AND (coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59)";
                $identifierName = 'MUST_CALL_COUNT';
        }elseif($pool == 'INTENT'){
                $dispositionId = 0;
                $identifierCond_pg = "(coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)";
                $identifierCond1_pg = " AND NVL(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)";

                $identifierCond = "(NVL(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)";
                $identifierCond1 = " AND NVL(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)";
                $identifierName = 'INTENT_COUNT';
        }
			
        $sth=$sth_expired='';$sth3='';$sth4='';$sth5='';$sth6='';$sth7='';$sth8='';$sth9='';
		
    if($request==0){
       $sql="SELECT
	  COUNT(DISTINCT eto_ofr_display_id) BL_APRROVED,
	  COUNT(DISTINCT CASE   WHEN coalesce(mcat_isq_avl,0) > 0	    OR coalesce(cat_isq_avl,0)    > 0	    THEN eto_ofr_display_id	  END) isq_avl,
	  COUNT(DISTINCT	  CASE	    WHEN ISQ_FILLED >0	    THEN eto_ofr_display_id	  END) isq_filled_1 ,
	  COUNT(DISTINCT	  CASE	    WHEN ISQ_FILLED >1	    THEN eto_ofr_display_id	  END) isq_filled_2,
	  COUNT(DISTINCT	  CASE	    WHEN ISQ_FILLED >2	    THEN eto_ofr_display_id	  END) isq_filled_3,
	  COUNT(DISTINCT	  CASE	    WHEN ISQ_FILLED >3	    THEN eto_ofr_display_id	  END) isq_filled_4,
	  COUNT(DISTINCT	  CASE	    WHEN ISQ_FILLED >4	    THEN eto_ofr_display_id	  END) isq_filled_5
	FROM
	  (SELECT eto_ofr_display_id,
	    COUNT(mcat_isq_avl.IM_CAT_SPEC_CATEGORY_ID) mcat_isq_avl,
	    COUNT(cat_isq_avl.IM_CAT_SPEC_CATEGORY_ID) cat_isq_avl,
	    COUNT(br.fk_eto_ofr_display_id) isq_filled
	  FROM
	    (SELECT FK_GLCAT_CAT_ID,
	      FK_GLCAT_MCAT_ID,
	      eto_ofr_display_id,
	      TO_CHAR(eto_ofr_approv_date_orig,'dd-Mon-yyyy') APPROV_DATE
	    FROM eto_ofr
	    WHERE DATE(eto_ofr_approv_date_orig) BETWEEN to_date(:st_dt,'DD-MON-YYYY') AND to_date(:ed_dt,'DD-MON-YYYY')
            $countrycond
            AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
		$identifierCond1_pg
	    UNION
	    SELECT FK_GLCAT_CAT_ID,
	      FK_GLCAT_MCAT_ID,
	      eto_ofr_display_id,
	      TO_CHAR(eto_ofr_approv_date_orig,'dd-Mon-yyyy') APPROV_DATE
	    FROM eto_ofr_expired
	    WHERE DATE(eto_ofr_approv_date_orig) BETWEEN to_date(:st_dt,'DD-MON-YYYY') AND to_date(:ed_dt,'DD-MON-YYYY')
	    $countrycond 
	    AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
		$identifierCond1_pg
	    ) OFR
	  LEFT OUTER JOIN eto_attribute br
	  ON OFR.eto_ofr_display_id = br.fk_eto_ofr_display_id
	  LEFT OUTER JOIN
	    ( SELECT DISTINCT IM_CAT_SPEC_CATEGORY_ID,
	      IM_CAT_SPEC_CATEGORY_TYPE
	    FROM im_cat_specification
	    WHERE IM_CAT_SPEC_STATUS       = 1
	    AND IM_CAT_SPEC_CATEGORY_TYPE IS NOT NULL
	    AND IM_CAT_SPEC_CATEGORY_TYPE  = 3
	    ) mcat_isq_avl
	  ON mcat_isq_avl.IM_CAT_SPEC_CATEGORY_ID = OFR.FK_GLCAT_MCAT_ID
	  LEFT OUTER JOIN
	    ( SELECT DISTINCT IM_CAT_SPEC_CATEGORY_ID,
	      IM_CAT_SPEC_CATEGORY_TYPE
	    FROM im_cat_specification
	    WHERE IM_CAT_SPEC_STATUS       = 1
	    AND IM_CAT_SPEC_CATEGORY_TYPE IS NOT NULL
	    AND IM_CAT_SPEC_CATEGORY_TYPE  = 2
	    ) cat_isq_avl
	  ON cat_isq_avl.IM_CAT_SPEC_CATEGORY_ID = OFR.FK_GLCAT_CAT_ID
	  GROUP BY eto_ofr_display_id) A";
	  
	 $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':st_dt'=>$start_date,':ed_dt' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
	 
	 $sql="SELECT
  COUNT(DISTINCT eto_ofr_display_id) TOT_BL_APRROVED,
  SUM(questions) TOT_QUESTION,
  SUM(responses) TOT_RESPONSE
FROM
  ( SELECT DISTINCT eto_ofr_display_id,
    APPROV_DATE,
    CASE
      WHEN COUNT (DISTINCT FK_IM_SPEC_MASTER_ID) > 5
      THEN 5
      ELSE COUNT (DISTINCT FK_IM_SPEC_MASTER_ID)
    END questions,
    COUNT(DISTINCT response) responses
  FROM
    ( SELECT DISTINCT eto_ofr_display_id,
      APPROV_DATE,
      CASE
        WHEN mcat_isq_avl.im_cat_spec_category_id  IS NULL
        THEN cat_isq_avl.im_cat_spec_category_id
        ELSE mcat_isq_avl.im_cat_spec_category_id
      END AS im_cat_spec_category_id,
      CASE
        WHEN mcat_isq_avl.im_cat_spec_category_id  IS NULL
        THEN cat_isq_avl.fk_im_spec_master_id
        ELSE mcat_isq_avl.fk_im_spec_master_id
      END AS fk_im_spec_master_id,
      CASE
        WHEN br.fk_im_spec_master_id         IS NOT NULL
        AND mcat_isq_avl.FK_IM_SPEC_MASTER_ID = br.fk_im_spec_master_id
        OR cat_isq_avl.FK_IM_SPEC_MASTER_ID   = br.fk_im_spec_master_id
        THEN br.fk_im_spec_master_id
        ELSE NULL
      END AS response
    FROM
      (SELECT FK_GLCAT_CAT_ID,
        FK_GLCAT_MCAT_ID,
        eto_ofr_display_id,
        TO_CHAR(eto_ofr_approv_date_orig,'dd-Mon-yyyy') APPROV_DATE
      FROM eto_ofr
      WHERE DATE(eto_ofr_approv_date_orig) BETWEEN to_date(:start_date,'DD-MON-YYYY') AND to_date(:end_date,'DD-MON-YYYY')
      $countrycond 
	  AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	  $identifierCond1_pg
      UNION
      SELECT FK_GLCAT_CAT_ID,
        FK_GLCAT_MCAT_ID,
        eto_ofr_display_id,
        TO_CHAR(eto_ofr_approv_date_orig,'dd-Mon-yyyy') APPROV_DATE
      FROM eto_ofr_expired
      WHERE DATE(eto_ofr_approv_date_orig) BETWEEN to_date(:start_date,'DD-MON-YYYY') AND to_date(:end_date,'DD-MON-YYYY')
      $countrycond 
	  AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	  $identifierCond1_pg
      ) ofr
    LEFT OUTER JOIN eto_attribute br
    ON ofr.eto_ofr_display_id = br.FK_ETO_OFR_DISPLAY_ID
    LEFT OUTER JOIN
      ( SELECT DISTINCT IM_CAT_SPEC_CATEGORY_ID,
        IM_CAT_SPEC_CATEGORY_TYPE,
        fk_im_spec_master_id
      FROM im_cat_specification
      WHERE IM_CAT_SPEC_STATUS       = 1
      AND IM_CAT_SPEC_CATEGORY_TYPE IS NOT NULL
      AND IM_CAT_SPEC_CATEGORY_TYPE  = 3
      ) mcat_isq_avl
    ON mcat_isq_avl.IM_CAT_SPEC_CATEGORY_ID = ofr.FK_GLCAT_MCAT_ID
    LEFT OUTER JOIN
      ( SELECT DISTINCT IM_CAT_SPEC_CATEGORY_ID,
        IM_CAT_SPEC_CATEGORY_TYPE,
        fk_im_spec_master_id
      FROM im_cat_specification
      WHERE IM_CAT_SPEC_STATUS       = 1
      AND IM_CAT_SPEC_CATEGORY_TYPE IS NOT NULL
      AND IM_CAT_SPEC_CATEGORY_TYPE  = 2
      ) cat_isq_avl
    ON cat_isq_avl.IM_CAT_SPEC_CATEGORY_ID = ofr.FK_GLCAT_CAT_ID
    ORDER BY eto_ofr_display_id
    ) A 
  GROUP BY ETO_OFR_DISPLAY_ID,
    APPROV_DATE
   ) B";
  
  $sth3 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':start_date'=>$start_date,':end_date' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
  
    }    
    if($request==1){
$sql="SELECT 
    COUNT(DISTINCT ETO_OFR_DISPLAY_ID) TTL_APPROVAL,
    COUNT (CASE WHEN FK_GL_COUNTRY_ISO='IN' AND BIG_BUYER IS NOT NULL THEN 1 END) BIG_BUYER_APPROVED,
    COUNT (CASE WHEN FK_GL_COUNTRY_ISO='IN' AND BIG_BUYER IS NOT NULL AND (USER_IDENTIFIER_FLAG IS NULL OR USER_IDENTIFIER_FLAG IN(2,3,5,7,8,9)) THEN 1 END) BIG_BUYER_PERSONAL,    
    COUNT (CASE WHEN FK_GL_COUNTRY_ISO='IN' AND BIG_BUYER IS NOT NULL AND USER_IDENTIFIER_FLAG =6 THEN 1 END) BIG_BUYER_COMPANY,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=1 or ETO_ENQ_TYP=3 or ETO_ENQ_TYP=5 THEN ETO_OFR_DISPLAY_ID END)RETAIL,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=3 THEN ETO_OFR_DISPLAY_ID END) MANUAL_RETAIL,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=1 THEN ETO_OFR_DISPLAY_ID END) AOV_AUTO,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=5 THEN ETO_OFR_DISPLAY_ID END) QTY_AUTO,
    COUNT(DISTINCT CASE WHEN coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 THEN ETO_OFR_DISPLAY_ID END) TTL_CALL_APPROVED,
    COUNT(DISTINCT CASE WHEN coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=16 THEN ETO_OFR_DISPLAY_ID END) TTL_DO_NOT_CALL,
    COUNT(DISTINCT CASE WHEN coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=15 THEN ETO_OFR_DISPLAY_ID END) APPROVED_FORIEN,
    COUNT(DISTINCT CASE WHEN TRIM(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated' AND ETO_OFR_VERIFIED = 1 THEN ETO_OFR_DISPLAY_ID END) VERIFIED,
    COUNT(DISTINCT CASE WHEN TRIM(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated' AND ETO_OFR_VERIFIED=2 AND ETO_OFR_CALL_VERIFIED IN (1,2) THEN ETO_OFR_DISPLAY_ID END) VERIFIED_UPDATED,
    COUNT(DISTINCT CASE WHEN FK_GL_COUNTRY_ISO='IN' AND GLUSR_USR_EMAIL is null THEN ETO_OFR_DISPLAY_ID END) APPROVED_WITHOUT_EMAIL,
    COUNT(DISTINCT CASE WHEN FK_GL_COUNTRY_ISO = 'IN' AND ETO_ENQ_TYP IS NOT NULL THEN ETO_OFR_DISPLAY_ID  END) PURPOSE,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 THEN ETO_OFR_DISPLAY_ID end ) LEADS_VERIFIED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 THEN ETO_OFR_DISPLAY_ID end) LEADS_ENRICHED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 AND FK_GL_COUNTRY_ISO ='IN' THEN ETO_OFR_DISPLAY_ID end ) IN_LEADS_VERIFIED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 AND FK_GL_COUNTRY_ISO ='IN' THEN ETO_OFR_DISPLAY_ID end) IN_LEADS_ENRICHED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 AND FK_GL_COUNTRY_ISO !='IN' THEN ETO_OFR_DISPLAY_ID end ) FOR_LEADS_VERIFIED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 AND FK_GL_COUNTRY_ISO !='IN' THEN ETO_OFR_DISPLAY_ID end) FOR_LEADS_ENRICHED_BY_EMAIL,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =3 THEN 1 END) DESC_100,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =2 THEN 1 END) DESC_100_GR,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =7 THEN 1 END) DESC_90DAYS,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =8 THEN 1 END) DESC_ANY1,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =16 THEN 1 END) DESC_ATLEAST_1ISQ,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =19 THEN 1 END) DESC_SUBJECT,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =9 THEN 1 END) BLFFT,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =9 THEN 1 END) REPOST,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =14 THEN 1 END) DNC_SETTING,    
    0  APPROVED_24_MORE,
    0 APPROVED_12_MORE,
    COUNT(DISTINCT FK_ETO_OFR_ID) TOTAL_USOLD,
    COUNT(FK_ETO_OFR_ID) TOTAL_SOLD
FROM
(
SELECT 
    ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG,ETO_ENQ_TYP, ETO_OFR_CALL_DISPOSITION_ID,ETO_OFR_VERIFIED,ETO_OFR_CALL_DISPOSITION_TYPE, ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,  
    (CASE WHEN A.FK_GLUSR_USR_ID IS NOT NULL THEN A.FK_GLUSR_USR_ID END) BIG_BUYER,GLUSR_USR.FK_GL_COUNTRY_ISO,GLUSR_USR_EMAIL,
     DATE(ETO_OFR_APPROV_DATE_ORIG)ETO_OFR_APPROV_DATE_ORIG, ((ETO_OFR_APPROV_DATE_ORIG-ETO_OFR_POSTDATE_ORIG)*24) TIMEDIFF 
FROM ETO_OFR OFR join GLUSR_USR on GLUSR_USR_ID=OFR.FK_GLUSR_USR_ID 
 left outer join IIL_BIG_BUYER_TO_GLUSR A 
ON OFR.FK_GLUSR_USR_ID = A.FK_GLUSR_USR_ID  
WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' 
AND DATE(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:st_dt,'DD-MON-YYYY') 
AND DATE(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:ed_dt,'DD-MON-YYYY')  
AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID $identifierCond1_pg 
UNION  
SELECT 
    ETO_OFR_DISPLAY_ID,  USER_IDENTIFIER_FLAG,ETO_ENQ_TYP,ETO_OFR_CALL_DISPOSITION_ID,ETO_OFR_VERIFIED,ETO_OFR_CALL_DISPOSITION_TYPE, ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,  
    (CASE WHEN A.FK_GLUSR_USR_ID IS NOT NULL THEN A.FK_GLUSR_USR_ID END) BIG_BUYER,GLUSR_USR.FK_GL_COUNTRY_ISO,GLUSR_USR_EMAIL,
     DATE(ETO_OFR_APPROV_DATE_ORIG)ETO_OFR_APPROV_DATE_ORIG, ((ETO_OFR_APPROV_DATE_ORIG-ETO_OFR_POSTDATE_ORIG)*24) TIMEDIFF 
FROM ETO_OFR_EXPIRED OFR join GLUSR_USR on GLUSR_USR_ID=OFR.FK_GLUSR_USR_ID 
 left outer join IIL_BIG_BUYER_TO_GLUSR A 
 ON OFR.FK_GLUSR_USR_ID = A.FK_GLUSR_USR_ID  
WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' 
AND DATE(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:st_dt,'DD-MON-YYYY')
AND DATE(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:ed_dt,'DD-MON-YYYY')
 
AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID $identifierCond1_pg
) A left outer join (SELECT FK_ETO_OFR_ID FROM ETO_LEAD_PUR_HIST WHERE DATE(ETO_PUR_DATE) >= TO_DATE(:st_dt,'DD-MON-YYYY')) ETO_LEAD_PUR_HIST 
on ETO_OFR_DISPLAY_ID=FK_ETO_OFR_ID";
$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':st_dt'=>$start_date,':ed_dt' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
}

if($request ==3)
 { 
$sql="select coalesce(IIL_MASTER_DATA_VALUE_TEXT,'-') REASON,count(1) CNT 
from
(
select eto_ofr_display_id,FK_ETO_OFR_DEL_REASON_CODE del_reason
from eto_ofr_temp_del
WHERE $identifierCond_pg  
OR FK_GL_COUNTRY_ISO not in ('IN','INDIA')) 
AND date(eto_ofr_deletiondate) between date(to_date(:st_date,'DD-MON-YYYY')) 
and date(to_date(:ed_date,'DD-MON-YYYY')) 
$countrycond 
union 
select eto_ofr_display_id,FK_ETO_OFR_DEL_REASON_CODE del_reason
from eto_ofr_temp_del_arch
WHERE  $identifierCond_pg OR FK_GL_COUNTRY_ISO not in ('IN','INDIA'))
AND date(eto_ofr_deletiondate) between date(to_date(:st_date,'DD-MON-YYYY')) and date(to_date(:ed_date,'DD-MON-YYYY'))
$countrycond 
union 
select dir_query_free_refid,coalesce(FENQ_DEL_REASON,FENQ_CALL_DEL_REASON) del_reason
from eto_ofr_from_fenq
	   WHERE $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA'))
AND date(eto_ofr_fenq_date) between date(to_date(:st_date,'DD-MON-YYYY')) and date(to_date(:ed_date,'DD-MON-YYYY')) 
$countrycond1 
union 
select dir_query_free_refid,coalesce(FENQ_DEL_REASON,FENQ_CALL_DEL_REASON) del_reason
from eto_ofr_from_fenq_arch
WHERE $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA'))
AND date(eto_ofr_fenq_date) between date(to_date(:st_date,'DD-MON-YYYY')) and date(to_date(:ed_date,'DD-MON-YYYY'))
$countrycond1) All_leads
left outer join
(SELECT DISTINCT IIL_MASTER_DATA_VALUE, IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID IN (3,4) ) codes
on del_reason::character varying = IIL_MASTER_DATA_VALUE
group by del_reason,IIL_MASTER_DATA_VALUE_TEXT";


$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':st_date'=>$start_date,':ed_date' => $end_date));

$sql="select FK_GL_MODULE_ID,count(1) CNT from
(
select eto_ofr_display_id,FK_GL_MODULE_ID 
from eto_ofr_temp_del WHERE $identifierCond_pg OR FK_GL_COUNTRY_ISO not in ('IN','INDIA'))
AND DATE(eto_ofr_deletiondate) between to_date(:st_date,'DD-MON-YYYY') and to_date(:ed_date,'DD-MON-YYYY') 
$countrycond union select eto_ofr_display_id,FK_GL_MODULE_ID 
from eto_ofr_temp_del_arch WHERE $identifierCond_pg OR FK_GL_COUNTRY_ISO not in ('IN','INDIA'))
AND DATE(eto_ofr_deletiondate) between to_date(:st_date,'DD-MON-YYYY') and to_date(:ed_date,'DD-MON-YYYY')
$countrycond union select dir_query_free_refid,QUERY_MODID 
from eto_ofr_from_fenq WHERE $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA'))
 AND  FK_ETO_OFR_ID  IS NULL
AND date(eto_ofr_fenq_date) between to_date(:st_date,'DD-MON-YYYY') and to_date(:ed_date,'DD-MON-YYYY') 
$countrycond1 union select dir_query_free_refid,QUERY_MODID 
from eto_ofr_from_fenq_arch WHERE $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA'))  AND  FK_ETO_OFR_ID  IS NULL
AND date(eto_ofr_fenq_date) between to_date(:st_date,'DD-MON-YYYY') and to_date(:ed_date,'DD-MON-YYYY')
$countrycond1 
)A group by FK_GL_MODULE_ID";

$sth3 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':st_date'=>$start_date,':ed_date' => $end_date));

$sql="SELECT
                TTL_DELETED,MAN_DELETED,AUTO_DELETED
          FROM
          (
          SELECT
               COUNT(CASE WHEN STATUS=1 THEN 1 END)TTL_DELETED,
               COUNT(CASE WHEN STATUS=1 AND (FK_EMPLOYEEID >0 ) THEN 1 END)MAN_DELETED,
               COUNT(CASE WHEN STATUS=1 AND (FK_EMPLOYEEID <=0 or FK_EMPLOYEEID is null) THEN 1 END)AUTO_DELETED             
                FROM
                (
                      SELECT
                              1 STATUS, ETO_OFR_DELETEDBYID FK_EMPLOYEEID,FK_ETO_OFR_DEL_REASON_CODE
                      FROM ETO_OFR_TEMP_DEL
                      WHERE $identifierCond_pg OR FK_GL_COUNTRY_ISO not in ('IN','INDIA'))
                      AND date(ETO_OFR_DELETIONDATE) between to_date(:start_date,'DD-MON-YYYY') and  to_date(:end_date,'DD-MON-YYYY') 
                      $countrycond     
                      UNION ALL
    SELECT
                              1 STATUS, ETO_OFR_DELETEDBYID FK_EMPLOYEEID, FK_ETO_OFR_DEL_REASON_CODE
                      FROM ETO_OFR_TEMP_DEL_ARCH
                       WHERE $identifierCond_pg OR FK_GL_COUNTRY_ISO not in ('IN','INDIA'))
                      AND date(ETO_OFR_DELETIONDATE) between to_date(:start_date,'DD-MON-YYYY') and  to_date(:end_date,'DD-MON-YYYY')
                      $countrycond      
          UNION ALL
                      SELECT
                              1 STATUS, ETO_OFR_FENQ_EMP_ID FK_EMPLOYEEID,FENQ_CALL_DEL_REASON FK_ETO_OFR_DEL_REASON_CODE
                      FROM ETO_OFR_FROM_FENQ_ARCH
                       WHERE $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA'))
                      AND date(ETO_OFR_FENQ_DATE) between to_date(:start_date,'DD-MON-YYYY') and  to_date(:end_date,'DD-MON-YYYY') 
                      $countrycond1 
                      AND FK_ETO_OFR_ID IS NULL                         
          UNION ALL
                      SELECT
                              1 STATUS, ETO_OFR_FENQ_EMP_ID FK_EMPLOYEEID,FENQ_CALL_DEL_REASON FK_ETO_OFR_DEL_REASON_CODE
                      FROM ETO_OFR_FROM_FENQ
                      WHERE $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA'))
                      AND date(ETO_OFR_FENQ_DATE) between to_date(:start_date,'DD-MON-YYYY') and  to_date(:end_date,'DD-MON-YYYY') 
                      $countrycond1 
                      AND FK_ETO_OFR_ID IS NULL ) A 
          ) B ";

    $sth5 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':start_date'=>$start_date,':end_date' => $end_date));
} 
 if($request ==14)
 { 
     #Total FENQ LEADS Generated 24 hrs (ALL Data)
  
    $con="ROUND((WORK_IN_DATE-POST_IN_DATE)*24*60,2) TIME_DIFF";  
    $sql_4_1="SELECT FK_GL_MODULE_ID, 
COUNT(distinct ofr_id ) TTL_RCV, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<30 THEN ofr_id END) WORKED30, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<15 THEN ofr_id END) WORKED15, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<10 THEN ofr_id END) WORKED10, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<05 THEN ofr_id END) WORKED05 
from ( select date(POST_IN_DATE) POST_IN_DATE, ofr_id, ETO_LEAP_VENDOR_NAME, 
ROUND(((WORK_IN_DATE::date-POST_IN_DATE::date)*24*60),2) TIME_DIFF, 
WORKED_BY, STATUS, FK_GL_MODULE_ID, FK_GL_COUNTRY_ISO 
from
(
select a.*
from 
( SELECT ETO_OFR_DISPLAY_ID as ofr_id, 
ETO_OFR_POSTDATE_ORIG POST_IN_DATE, ETO_OFR_APPROV_DATE_ORIG WORK_IN_DATE, 
coalesce(ETO_OFR_APPROV_BY_ORIG,FK_EMPLOYEE_LOCK_ID) WORKED_BY, 
(case when ETO_OFR_APPROV='W' then 'WAITING' else 'APPROVED' end ) STATUS, 
FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID
 FROM ETO_OFR 
 WHERE date(ETO_OFR_POSTDATE_ORIG) >= date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 AND date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' AND FK_GL_MODULE_ID !='FENQ' 
 AND(case when 1 = 0 then 1 else (case when FK_GL_COUNTRY_ISO = 'IN' then 2 else 3  end) end ) = (case when 1 = 0 then 1 when  1 = 2 then 2 when  1 =3 then 3 end)
 AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=1
 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23) 
 
 UNION 
 
 SELECT ETO_OFR_DISPLAY_ID as ofr_id, ETO_OFR_POSTDATE_ORIG POST_IN_DATE, ETO_OFR_APPROV_DATE_ORIG WORK_IN_DATE, 
 coalesce(ETO_OFR_APPROV_BY_ORIG,FK_EMPLOYEE_ID) WORKED_BY, 
 'EXPIRED' STATUS, FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID 
 FROM ETO_OFR_EXPIRED 
 WHERE date(ETO_OFR_POSTDATE_ORIG)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY'))
 AND 
 date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND FK_GL_MODULE_ID !='FENQ' 
 and (case when 1 = 0 then 1 else  (case when FK_GL_COUNTRY_ISO = 'IN' then 2 else 3  end) end ) = (case when 1 = 0 then 1 when  1 = 2 then 2 when  1 =3 then 3 end)
 AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=1
 AND coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23) 
 
 UNION 
 
 SELECT ETO_OFR_DISPLAY_ID as ofr_id, ETO_OFR_POSTDATE_ORIG POST_IN_DATE, ETO_OFR_DELETIONDATE WORK_IN_DATE, 
 coalesce(ETO_OFR_DELETEDBYID,FK_EMPLOYEE_LOCK_ID) WORKED_BY, 'DELETED' STATUS, FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID 
 FROM ETO_OFR_temp_del WHERE 
 date(ETO_OFR_POSTDATE_ORIG)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 AND date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' 
 AND ETO_OFR_APPROV='W' 
 and FK_GL_MODULE_ID !='FENQ' 
 AND (coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23) OR FK_GL_COUNTRY_ISO not in ('IN','INDIA'))
and (case when 1 = 0 then 1 else  (case when FK_GL_COUNTRY_ISO = 'IN' then 2 else 3  end) end ) = (case when 1 = 0 then 1 when  1 = 2 then 2 when  1 =3 then 3 end)
 
 UNION 
 
 SELECT ETO_OFR_DISPLAY_ID as ofr_id, 
 ETO_OFR_POSTDATE_ORIG POST_IN_DATE, 
 ETO_OFR_DELETIONDATE WORK_IN_DATE, 
 coalesce(ETO_OFR_DELETEDBYID,FK_EMPLOYEE_LOCK_ID) WORKED_BY, 
 'DELETED' STATUS, FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID 
 FROM ETO_OFR_temp_del_arch 
 WHERE date(ETO_OFR_POSTDATE_ORIG)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 AND date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' 
 AND ETO_OFR_APPROV='W' 
 and FK_GL_MODULE_ID !='FENQ' 
 AND (coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23) 
 OR FK_GL_COUNTRY_ISO not in ('IN','INDIA')) AND 
(case when 1 = 0 then 1 else  (case when FK_GL_COUNTRY_ISO = 'IN' then 2 else 3  end) end ) = (case when 1 = 0 then 1 when  1 = 2 then 2 when  1 =3 then 3 end)
 UNION 
 SELECT coalesce(DIR_QUERY_FREE_REFID,FK_QUERY_ID) ofr_id, 
 ETO_OFR_FROM_FENQ_ARCH.date_r POST_IN_DATE, 
 ETO_OFR_FROM_FENQ_ARCH.ETO_OFR_FENQ_DATE WORK_IN_DATE, 
 ETO_OFR_FENQ_EMP_ID WORKED_BY, 
 (case when FK_ETO_OFR_ID is null then 'DELETED' else 'APPROVED' end ) STATUS, 
 (case when  S_COUNTRY_UPPER = 'IN' then 'IN' when S_COUNTRY_UPPER ='INDIA' then 'IN' else 'FR' end ) FK_GL_COUNTRY_ISO, 'FENQ' FK_GL_MODULE_ID 
 from ETO_OFR_FROM_FENQ_ARCH 
 where date(ETO_OFR_FROM_FENQ_ARCH.DATE_R)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 and date(ETO_OFR_FROM_FENQ_ARCH.DATE_R)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND (coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23) OR S_COUNTRY_UPPER not in ('IN','INDIA')) 
 AND (case when 1 = 0 then 1 else  (case when S_COUNTRY_UPPER = 'IN' then 2 else 3  end) end ) = (case when 1 = 0 then 1 when  1 = 2 then 2 when  1 =3 then 3 end) 
 
 UNION 
 SELECT ETO_OFR_DISPLAY_ID ofr_id, DIR_QUERY_FREE.date_r POST_IN_DATE, 
 null WORK_IN_DATE, FK_EMPLOYEEID WORKED_BY, 'WAITING' STATUS,
 (case when  S_COUNTRY_UPPER = 'IN' then 'IN' when S_COUNTRY_UPPER ='INDIA' then 'IN' else 'FR' end) FK_GL_COUNTRY_ISO, 
 'FENQ' FK_GL_MODULE_ID FROM DIR_QUERY_FREE 
 where date(DIR_QUERY_FREE.DATE_R)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 and date(DIR_QUERY_FREE.DATE_R)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND (coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23) OR S_COUNTRY_UPPER not in ('IN','INDIA')) 
 AND (case when 1 = 0 then 1 else  (case when S_COUNTRY_UPPER = 'IN' then 2 else 3  end) end ) = (case when 1 = 0 then 1 when  1 = 2 then 2 when  1 =3 then 3 end)
 )A where FK_GL_COUNTRY_ISO = 'IN') A
 left outer join ETO_LEAP_MIS 
 on A.WORKED_BY=ETO_LEAP_EMP_ID)  X
 GROUP BY FK_GL_MODULE_ID";
    
$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_4_1, array(':STARTDATE_TIME'=>$start_date,':ENDDATE_TIME' => $end_date));



$sql_4_2="SELECT FK_GL_MODULE_ID, 
COUNT(distinct ofr_id ) TTL_RCV, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<30 THEN ofr_id END) WORKED30, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<15 THEN ofr_id END) WORKED15, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<10 THEN ofr_id END) WORKED10, 
COUNT(DISTINCT CASE WHEN STATUS<>'WAITING' AND time_diff<05 THEN ofr_id END) WORKED05 
from ( select date(POST_IN_DATE) POST_IN_DATE, ofr_id, ETO_LEAP_VENDOR_NAME, 
ROUND(((WORK_IN_DATE::date-POST_IN_DATE::date)*24*60),2) TIME_DIFF, 
WORKED_BY, STATUS, FK_GL_MODULE_ID, FK_GL_COUNTRY_ISO 
from
(
select a.*
from 
( SELECT ETO_OFR_DISPLAY_ID as ofr_id, 
ETO_OFR_POSTDATE_ORIG POST_IN_DATE, ETO_OFR_APPROV_DATE_ORIG WORK_IN_DATE, 
coalesce(ETO_OFR_APPROV_BY_ORIG,FK_EMPLOYEE_LOCK_ID) WORKED_BY, 
(case when ETO_OFR_APPROV='W' then 'WAITING' else 'APPROVED' end ) STATUS, 
FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID
 FROM ETO_OFR 
 WHERE date(ETO_OFR_POSTDATE_ORIG) >= date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 AND date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' AND FK_GL_MODULE_ID !='FENQ'  
$countrycond 
 AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID $identifierCond1_pg 
 UNION 
 
 SELECT ETO_OFR_DISPLAY_ID as ofr_id, ETO_OFR_POSTDATE_ORIG POST_IN_DATE, ETO_OFR_APPROV_DATE_ORIG WORK_IN_DATE, 
 coalesce(ETO_OFR_APPROV_BY_ORIG,FK_EMPLOYEE_ID) WORKED_BY, 
 'EXPIRED' STATUS, FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID 
 FROM ETO_OFR_EXPIRED 
 WHERE date(ETO_OFR_POSTDATE_ORIG)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY'))
 AND 
 date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' AND ETO_OFR_APPROV='A' AND FK_GL_MODULE_ID !='FENQ' 
$countrycond AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID $identifierCond1_pg 
 UNION 
  SELECT ETO_OFR_DISPLAY_ID as ofr_id, ETO_OFR_POSTDATE_ORIG POST_IN_DATE, ETO_OFR_DELETIONDATE WORK_IN_DATE, 
 coalesce(ETO_OFR_DELETEDBYID,FK_EMPLOYEE_LOCK_ID) WORKED_BY, 'DELETED' STATUS, FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID 
 FROM ETO_OFR_temp_del WHERE 
 date(ETO_OFR_POSTDATE_ORIG)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 AND date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' 
 AND ETO_OFR_APPROV='W' 
 and FK_GL_MODULE_ID !='FENQ' 
 AND $identifierCond_pg  OR FK_GL_COUNTRY_ISO not in ('IN','INDIA'))
$countrycond  
 UNION  
 SELECT ETO_OFR_DISPLAY_ID as ofr_id, 
 ETO_OFR_POSTDATE_ORIG POST_IN_DATE, 
 ETO_OFR_DELETIONDATE WORK_IN_DATE, 
 coalesce(ETO_OFR_DELETEDBYID,FK_EMPLOYEE_LOCK_ID) WORKED_BY, 
 'DELETED' STATUS, FK_GL_COUNTRY_ISO, 'GEN' FK_GL_MODULE_ID 
 FROM ETO_OFR_temp_del_arch 
 WHERE date(ETO_OFR_POSTDATE_ORIG)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 AND date(ETO_OFR_POSTDATE_ORIG)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND ETO_OFR_TYP = 'B' 
 AND ETO_OFR_APPROV='W' 
 and FK_GL_MODULE_ID !='FENQ' 
 AND $identifierCond_pg  
 OR FK_GL_COUNTRY_ISO not in ('IN','INDIA')) $countrycond 
 UNION 
 SELECT coalesce(DIR_QUERY_FREE_REFID,FK_QUERY_ID) ofr_id, 
 ETO_OFR_FROM_FENQ_ARCH.date_r POST_IN_DATE, 
 ETO_OFR_FROM_FENQ_ARCH.ETO_OFR_FENQ_DATE WORK_IN_DATE, 
 ETO_OFR_FENQ_EMP_ID WORKED_BY, 
 (case when FK_ETO_OFR_ID is null then 'DELETED' else 'APPROVED' end ) STATUS, 
 (case when  S_COUNTRY_UPPER = 'IN' then 'IN' when S_COUNTRY_UPPER ='INDIA' then 'IN' else 'FR' end ) FK_GL_COUNTRY_ISO, 'FENQ' FK_GL_MODULE_ID 
 from ETO_OFR_FROM_FENQ_ARCH 
 where date(ETO_OFR_FROM_FENQ_ARCH.DATE_R)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 and date(ETO_OFR_FROM_FENQ_ARCH.DATE_R)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA')) 
$countrycond1  
 UNION 
 SELECT ETO_OFR_DISPLAY_ID ofr_id, DIR_QUERY_FREE.date_r POST_IN_DATE, 
 null WORK_IN_DATE, FK_EMPLOYEEID WORKED_BY, 'WAITING' STATUS,
 (case when  S_COUNTRY_UPPER = 'IN' then 'IN' when S_COUNTRY_UPPER ='INDIA' then 'IN' else 'FR' end) FK_GL_COUNTRY_ISO, 
 'FENQ' FK_GL_MODULE_ID FROM DIR_QUERY_FREE 
 where date(DIR_QUERY_FREE.DATE_R)>=date(TO_DATE(:STARTDATE_TIME,'DD-MON-YYYY')) 
 and date(DIR_QUERY_FREE.DATE_R)<=date(TO_DATE(:ENDDATE_TIME,'DD-MON-YYYY')) 
 AND $identifierCond_pg OR S_COUNTRY_UPPER not in ('IN','INDIA')) 
 $countrycond1 )A where FK_GL_COUNTRY_ISO = 'IN') A
 left outer join ETO_LEAP_MIS 
 on A.WORKED_BY=ETO_LEAP_EMP_ID)  X
 GROUP BY FK_GL_MODULE_ID";
            

$sth3 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_4_2, array(':STARTDATE_TIME'=>$start_date,':ENDDATE_TIME' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
 }
  if($request ==13)
 { 

#MCAT's selected/Lead approved [India] (ALL Data)

$sql_5="select OFR_MAPPING_COUNT, count(1) cnt from
(
SELECT ETO_OFR_DISPLAY_ID, APPROV_DATE, COUNT(FK_ETO_OFR_ID) OFR_MAPPING_COUNT FROM
(
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR 
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN' 
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
       AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	$countrycond  $identifierCond1_pg
       UNION
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR_EXPIRED
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN'
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
       $countrycond 
       AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	   $identifierCond1_pg
)ETO_OFR,
ETO_OFR_MAPPING
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID
GROUP BY ETO_OFR_DISPLAY_ID,APPROV_DATE
ORDER BY APPROV_DATE,ETO_OFR_DISPLAY_ID 
) A 
group by OFR_MAPPING_COUNT
order by OFR_MAPPING_COUNT";


$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_5, array(':start_date'=>$start_date,':end_date' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));

$sql_5_expired="select OFR_MAPPING_COUNT, count(1) cnt from
(
SELECT ETO_OFR_DISPLAY_ID, APPROV_DATE, COUNT(FK_ETO_OFR_ID) OFR_MAPPING_COUNT FROM
(
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR 
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN' 
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
       $countrycond 
       AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	   $identifierCond1_pg
       UNION
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR_EXPIRED
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN'
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY') 
       $countrycond 
       AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	   $identifierCond1_pg
)ETO_OFR,
ETO_OFR_MAPPING_EXPIRED
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID
GROUP BY ETO_OFR_DISPLAY_ID,APPROV_DATE
ORDER BY APPROV_DATE,ETO_OFR_DISPLAY_ID 
) A 
group by OFR_MAPPING_COUNT
order by OFR_MAPPING_COUNT";

$sth_expired = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_5_expired, array(':start_date'=>$start_date,':end_date' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));

#Auto-Suppliers Selection Count(Total Leads Selected - Manual && Total Leads Selected - Auto) , Paid Free Supplier Selection [India](Suppliers with Credits && Suppliers without Credits),Rejection% of Supplier Displayed(Suppliers Displayed && Suppliers Rejected && Suppliers Displayed - Manual && Suppliers Rejected - Manual)

$sql_14="select
COUNT(DISTINCT ETO_OFR_DISPLAY_ID) LEAD_APPROVED,
COUNT(DISTINCT case when ETO_LEADSUPMAP_TYP = 'M' then ETO_OFR_DISPLAY_ID end) LEAD_APPROVED_manual,
COUNT(DISTINCT case when ETO_LEADSUPMAP_TYP = 'A' then ETO_OFR_DISPLAY_ID end) LEAD_APPROVED_auto,
COUNT(FK_GLUSR_USR_ID) SUP_DISPLAYED,
COUNT(case when ETO_LEADSUPMAP_TYP = 'M' then FK_GLUSR_USR_ID END) SUP_DISPLAYED_manual,
COUNT(CASE WHEN ETO_LEAD_SUPPLIER_RANK >0 and ETO_LEADSUPMAP_TYP = 'M' then FK_GLUSR_USR_ID END)Suppliers_Selected_manual,
COUNT(CASE WHEN ETO_LEAD_SUPPLIER_RANK >0 then FK_GLUSR_USR_ID END)Suppliers_Selected,
COUNT(CASE WHEN ETO_LEAD_SUPPLIER_RANK >0 and GLUSR_ETO_CUST_CREDITS_AV > 0 THEN FK_GLUSR_USR_ID END) With_Credits,
COUNT(CASE WHEN ETO_LEAD_SUPPLIER_RANK >0 and GLUSR_ETO_CUST_CREDITS_AV = 0 THEN FK_GLUSR_USR_ID END) Without_Credits
from
(
    select distinct ETO_OFR_DISPLAY_ID,ETO_OFR_APPROX_ORDER_VALUE,ETO_LEAD_SUPPLIER_RANK,FK_GLUSR_USR_ID,ETO_LEADSUPMAP_TYP
    from
    (
    select ETO_OFR_DISPLAY_ID,ETO_OFR_APPROX_ORDER_VALUE
    FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
    and fk_gl_country_iso = 'IN'
    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MM-YYYY')
    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MM-YYYY')
    AND DECODE(:IN_CNTRY_FLAG, 0, 1, DECODE(FK_GL_COUNTRY_ISO,'IN',2,3)) = DECODE(:IN_CNTRY_FLAG, 0, 1, 2, 2, 3, 3)
    AND NVL(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	$identifierCond1
    UNION
    select ETO_OFR_DISPLAY_ID,ETO_OFR_APPROX_ORDER_VALUE
    FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
    and fk_gl_country_iso = 'IN'
    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MM-YYYY')
    AND TRUNC(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MM-YYYY')
    AND DECODE(:IN_CNTRY_FLAG, 0, 1, DECODE(FK_GL_COUNTRY_ISO,'IN',2,3)) = DECODE(:IN_CNTRY_FLAG, 0, 1, 2, 2, 3, 3)
    AND NVL(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	$identifierCond1
    )ETO_OFR,
    (
      select FK_ETO_OFR_DISPLAY_ID,ETO_LEAD_SUPPLIER_RANK,FK_GLUSR_USR_ID,ETO_LEADSUPMAP_TYP
      from eto_lead_supplier_mapping
      union
      select FK_ETO_OFR_DISPLAY_ID,ETO_LEAD_SUPPLIER_RANK,FK_GLUSR_USR_ID,ETO_LEADSUPMAP_TYP
      from eto_lead_supplier_mapping_exp 
    ) eto_lead_supplier_mapping
    where ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID(+)
),glusr_usr
where FK_GLUSR_USR_ID = GLUSR_USR_ID(+)";


$sth3 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_14, array(':start_date'=>$start_date,':end_date' => $end_date,':IN_CNTRY_FLAG'=>$cntryFlag,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));

  
## Select Supplier Report [India] (0 SUPPLIER && 1-2 SUPPLIER && 3-9 SUPPLIER && 10+ SUPPLIER)

$sql="select sum(SUP_0) SUP_0, sum (SUP_1) + sum(SUP_2) SUP_1_2, sum(SUP_3) + sum(SUP_4) + sum(SUP_5) + sum(SUP_6) + sum(SUP_7) + sum(SUP_8) + sum(SUP_9) SUP_3_9, sum(SUP_10) + sum(SUP_MORE_10) SUP_More_10
from
(
SELECT 
                       APPROV_DATE,
                       COUNT(ETO_OFR_DISPLAY_ID) TOTAL_APPROVED,
                       SUM(CASE WHEN SUPPLIER_CNT=0 THEN 1 ELSE 0 END)SUP_0,
                       SUM(CASE WHEN SUPPLIER_CNT=1 THEN 1 ELSE 0 END)SUP_1,
                       SUM(CASE WHEN SUPPLIER_CNT=2 THEN 1 ELSE 0 END)SUP_2,
                       SUM(CASE WHEN SUPPLIER_CNT=3 THEN 1 ELSE 0 END)SUP_3,
                       SUM(CASE WHEN SUPPLIER_CNT=4 THEN 1 ELSE 0 END)SUP_4,
                       SUM(CASE WHEN SUPPLIER_CNT=5 THEN 1 ELSE 0 END)SUP_5,
                       SUM(CASE WHEN SUPPLIER_CNT=6 THEN 1 ELSE 0 END)SUP_6,
SUM(CASE WHEN SUPPLIER_CNT=7 THEN 1 ELSE 0 END)SUP_7,
SUM(CASE WHEN SUPPLIER_CNT=8 THEN 1 ELSE 0 END)SUP_8,
SUM(CASE WHEN SUPPLIER_CNT=9 THEN 1 ELSE 0 END)SUP_9,
SUM(CASE WHEN SUPPLIER_CNT=10 THEN 1 ELSE 0 END)SUP_10,    
                       SUM(CASE WHEN SUPPLIER_CNT>10 THEN 1 ELSE 0 END)SUP_MORE_10
               FROM
               (
                      
                               SELECT 
                                       ETO_OFR_DISPLAY_ID,Date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE,
COUNT(CASE WHEN coalesce(ETO_LEAD_SUPPLIER_MAPPING.ETO_LEADSUPMAP_PROCESSED,0) <> 9 THEN ETO_LEAD_SUPPLIER_MAPPING.FK_GLUSR_USR_ID END) SUPPLIER_CNT
                     
                               FROM
                                       ETO_OFR left outer join ETO_LEAD_SUPPLIER_MAPPING
                               on 
                                       ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID 
                                       WHERE ETO_OFR_TYP='B'
                                       AND ETO_OFR_APPROV='A'
                                       AND FK_GL_COUNTRY_ISO = 'IN' 
                                       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY') 
                                       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:end_date,'DD-MON-YYYY') 
                                        AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
                                        $identifierCond1_pg
			 GROUP BY date(ETO_OFR_APPROV_DATE_ORIG),ETO_OFR_DISPLAY_ID
                                       
                               UNION
                               SELECT 
                                       ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE,
COUNT(CASE WHEN coalesce(ETO_LEAD_SUPPLIER_MAPPING_EXP.ETO_LEADSUPMAP_PROCESSED,0) <> 9 THEN ETO_LEAD_SUPPLIER_MAPPING_EXP.FK_GLUSR_USR_ID END) SUPPLIER_CNT
                     
                               FROM
                                       ETO_OFR_EXPIRED left outer join ETO_LEAD_SUPPLIER_MAPPING_EXP
                               on 
                                       ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID 
                                       WHERE ETO_OFR_TYP='B'
                                       AND ETO_OFR_APPROV='A'
                                       AND FK_GL_COUNTRY_ISO = 'IN' 
                                       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY') 
                                       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:end_date,'DD-MON-YYYY') 
                                       AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
                                        $identifierCond1_pg
			 GROUP BY date(ETO_OFR_APPROV_DATE_ORIG),ETO_OFR_DISPLAY_ID
                                       
               )A 
               GROUP BY APPROV_DATE
               ORDER BY APPROV_DATE
               )B";
$sth4 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':start_date'=>$start_date,':end_date' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));


$sql="SELECT 
    COUNT(DISTINCT ETO_OFR_DISPLAY_ID) TTL_APPROVAL,
    COUNT (CASE WHEN FK_GL_COUNTRY_ISO='IN' AND BIG_BUYER IS NOT NULL THEN 1 END) BIG_BUYER_APPROVED,
    COUNT (CASE WHEN FK_GL_COUNTRY_ISO='IN' AND BIG_BUYER IS NOT NULL AND (USER_IDENTIFIER_FLAG IS NULL OR USER_IDENTIFIER_FLAG IN(2,3,5,7,8,9)) THEN 1 END) BIG_BUYER_PERSONAL,    
    COUNT (CASE WHEN FK_GL_COUNTRY_ISO='IN' AND BIG_BUYER IS NOT NULL AND USER_IDENTIFIER_FLAG =6 THEN 1 END) BIG_BUYER_COMPANY,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=1 or ETO_ENQ_TYP=3 or ETO_ENQ_TYP=5 THEN ETO_OFR_DISPLAY_ID END)RETAIL,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=3 THEN ETO_OFR_DISPLAY_ID END) MANUAL_RETAIL,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=1 THEN ETO_OFR_DISPLAY_ID END) AOV_AUTO,
    COUNT(DISTINCT CASE WHEN ETO_ENQ_TYP=5 THEN ETO_OFR_DISPLAY_ID END) QTY_AUTO,
    COUNT(DISTINCT CASE WHEN coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=0 THEN ETO_OFR_DISPLAY_ID END) TTL_CALL_APPROVED,
    COUNT(DISTINCT CASE WHEN coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=16 THEN ETO_OFR_DISPLAY_ID END) TTL_DO_NOT_CALL,
    COUNT(DISTINCT CASE WHEN coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=15 THEN ETO_OFR_DISPLAY_ID END) APPROVED_FORIEN,
    COUNT(DISTINCT CASE WHEN TRIM(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated' AND ETO_OFR_VERIFIED = 1 THEN ETO_OFR_DISPLAY_ID END) VERIFIED,
    COUNT(DISTINCT CASE WHEN TRIM(ETO_OFR_CALL_DISPOSITION_TYPE) ='Validated' AND ETO_OFR_VERIFIED=2 AND ETO_OFR_CALL_VERIFIED IN (1,2) THEN ETO_OFR_DISPLAY_ID END) VERIFIED_UPDATED,
    COUNT(DISTINCT CASE WHEN FK_GL_COUNTRY_ISO='IN' AND GLUSR_USR_EMAIL is null THEN ETO_OFR_DISPLAY_ID END) APPROVED_WITHOUT_EMAIL,
    COUNT(DISTINCT CASE WHEN FK_GL_COUNTRY_ISO = 'IN' AND ETO_ENQ_TYP IS NOT NULL THEN ETO_OFR_DISPLAY_ID  END) PURPOSE,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 THEN ETO_OFR_DISPLAY_ID end ) LEADS_VERIFIED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 THEN ETO_OFR_DISPLAY_ID end) LEADS_ENRICHED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 AND FK_GL_COUNTRY_ISO ='IN' THEN ETO_OFR_DISPLAY_ID end ) IN_LEADS_VERIFIED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 AND FK_GL_COUNTRY_ISO ='IN' THEN ETO_OFR_DISPLAY_ID end) IN_LEADS_ENRICHED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=1 AND FK_GL_COUNTRY_ISO !='IN' THEN ETO_OFR_DISPLAY_ID end ) FOR_LEADS_VERIFIED_BY_EMAIL,
    COUNT(CASE WHEN ETO_OFR_EMAIL_VERIFIED=2 AND FK_GL_COUNTRY_ISO !='IN' THEN ETO_OFR_DISPLAY_ID end) FOR_LEADS_ENRICHED_BY_EMAIL,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =3 THEN 1 END) DESC_100,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =2 THEN 1 END) DESC_100_GR,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =7 THEN 1 END) DESC_90DAYS,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =8 THEN 1 END) DESC_ANY1,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =16 THEN 1 END) DESC_ATLEAST_1ISQ,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =19 THEN 1 END) DESC_SUBJECT,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =9 THEN 1 END) BLFFT,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =9 THEN 1 END) REPOST,
    COUNT (CASE WHEN USER_IDENTIFIER_FLAG =14 THEN 1 END) DNC_SETTING,    
    0  APPROVED_24_MORE,
    0 APPROVED_12_MORE,
    COUNT(DISTINCT FK_ETO_OFR_ID) TOTAL_USOLD,
    COUNT(FK_ETO_OFR_ID) TOTAL_SOLD
FROM
(
SELECT 
    ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG,ETO_ENQ_TYP, ETO_OFR_CALL_DISPOSITION_ID,ETO_OFR_VERIFIED,ETO_OFR_CALL_DISPOSITION_TYPE, ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,  
    (CASE WHEN A.FK_GLUSR_USR_ID IS NOT NULL THEN A.FK_GLUSR_USR_ID END) BIG_BUYER,GLUSR_USR.FK_GL_COUNTRY_ISO,GLUSR_USR_EMAIL,
     DATE(ETO_OFR_APPROV_DATE_ORIG)ETO_OFR_APPROV_DATE_ORIG, ((ETO_OFR_APPROV_DATE_ORIG-ETO_OFR_POSTDATE_ORIG)*24) TIMEDIFF 
FROM ETO_OFR OFR join GLUSR_USR on GLUSR_USR_ID=OFR.FK_GLUSR_USR_ID 
 left outer join IIL_BIG_BUYER_TO_GLUSR A 
ON OFR.FK_GLUSR_USR_ID = A.FK_GLUSR_USR_ID  
WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' 
AND DATE(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:st_dt,'DD-MON-YYYY') 
AND DATE(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:ed_dt,'DD-MON-YYYY')  
AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID $identifierCond1_pg 
UNION  
SELECT 
    ETO_OFR_DISPLAY_ID,  USER_IDENTIFIER_FLAG,ETO_ENQ_TYP,ETO_OFR_CALL_DISPOSITION_ID,ETO_OFR_VERIFIED,ETO_OFR_CALL_DISPOSITION_TYPE, ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,  
    (CASE WHEN A.FK_GLUSR_USR_ID IS NOT NULL THEN A.FK_GLUSR_USR_ID END) BIG_BUYER,GLUSR_USR.FK_GL_COUNTRY_ISO,GLUSR_USR_EMAIL,
     DATE(ETO_OFR_APPROV_DATE_ORIG)ETO_OFR_APPROV_DATE_ORIG, ((ETO_OFR_APPROV_DATE_ORIG-ETO_OFR_POSTDATE_ORIG)*24) TIMEDIFF 
FROM ETO_OFR_EXPIRED OFR join GLUSR_USR on GLUSR_USR_ID=OFR.FK_GLUSR_USR_ID 
 left outer join IIL_BIG_BUYER_TO_GLUSR A 
 ON OFR.FK_GLUSR_USR_ID = A.FK_GLUSR_USR_ID  
WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' 
AND DATE(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:st_dt,'DD-MON-YYYY')
AND DATE(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:ed_dt,'DD-MON-YYYY')
 
AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID $identifierCond1_pg
) A left outer join (SELECT FK_ETO_OFR_ID FROM ETO_LEAD_PUR_HIST WHERE DATE(ETO_PUR_DATE) >= TO_DATE(:st_dt,'DD-MON-YYYY')) ETO_LEAD_PUR_HIST 
on ETO_OFR_DISPLAY_ID=FK_ETO_OFR_ID";
$sth6 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':st_dt'=>$start_date,':ed_dt' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
 
$sql="select
        Suppliers,
        count(ETO_OFR_DISPLAY_ID) CNT
        from
        (
        select
        ETO_OFR_DISPLAY_ID,
        COUNT(FK_GLUSR_USR_ID) SUP_DISPLAYED,
        COUNT(CASE WHEN ETO_LEAD_SUPPLIER_RANK >0 and ETO_LEADSUPMAP_TYP = 'A' then FK_GLUSR_USR_ID END)Suppliers
        from
        (
            select distinct ETO_OFR_DISPLAY_ID,ETO_OFR_APPROX_ORDER_VALUE,ETO_LEAD_SUPPLIER_RANK,FK_GLUSR_USR_ID,ETO_LEADSUPMAP_TYP
            from
            (
            select ETO_OFR_DISPLAY_ID,ETO_OFR_APPROX_ORDER_VALUE
            FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
            and fk_gl_country_iso = 'IN'
             AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
            AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
	    AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
		$identifierCond1_pg  
            UNION
            select ETO_OFR_DISPLAY_ID,ETO_OFR_APPROX_ORDER_VALUE
            FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
            and fk_gl_country_iso = 'IN'
             AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
            AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
	    AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
		$identifierCond1_pg  
            )ETO_OFR left outer join 
            (
              select FK_ETO_OFR_DISPLAY_ID,ETO_LEAD_SUPPLIER_RANK,FK_GLUSR_USR_ID,ETO_LEADSUPMAP_TYP
              from eto_lead_supplier_mapping
              union
              select FK_ETO_OFR_DISPLAY_ID,ETO_LEAD_SUPPLIER_RANK,FK_GLUSR_USR_ID,ETO_LEADSUPMAP_TYP
              from eto_lead_supplier_mapping_exp 
            ) eto_lead_supplier_mapping
            on ETO_OFR_DISPLAY_ID = FK_ETO_OFR_DISPLAY_ID
        ) T left outer join glusr_usr
        on FK_GLUSR_USR_ID = GLUSR_USR_ID
        group by ETO_OFR_DISPLAY_ID
        ) A
        where Suppliers in (30,50,75)
        group by Suppliers";

        $sth7 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array(':start_date'=>$start_date,':end_date' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
        
        
               
        $sql_5_2="select count(1) cnt from
(
SELECT ETO_OFR_DISPLAY_ID, APPROV_DATE, COUNT(FK_ETO_OFR_ID) OFR_MAPPING_COUNT FROM
(
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR 
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN' 
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
      $countrycond      
       AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	   $identifierCond1_pg
       UNION
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR_EXPIRED
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN'
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
       $countrycond 
           AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	   $identifierCond1_pg
)ETO_OFR,
ETO_OFR_MAPPING
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID
GROUP BY ETO_OFR_DISPLAY_ID,APPROV_DATE
ORDER BY APPROV_DATE,ETO_OFR_DISPLAY_ID 
) A ";

$sth8= $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_5_2, array(':start_date'=>$start_date,':end_date' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));

$sql_5_2_expired="select count(1) cnt from
(
SELECT ETO_OFR_DISPLAY_ID, APPROV_DATE, COUNT(FK_ETO_OFR_ID) OFR_MAPPING_COUNT FROM
(
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR 
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN' 
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
        $countrycond       
        AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	   $identifierCond1_pg
       UNION
       SELECT ETO_OFR_DISPLAY_ID,date(ETO_OFR_APPROV_DATE_ORIG) APPROV_DATE FROM ETO_OFR_EXPIRED
       WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A'
       and fk_gl_country_iso = 'IN'
       AND date(ETO_OFR_APPROV_DATE_ORIG)>=TO_DATE(:start_date,'DD-MON-YYYY')
       AND date(ETO_OFR_APPROV_DATE_ORIG)<=TO_DATE(:end_date,'DD-MON-YYYY')
        $countrycond       
        AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
	   $identifierCond1_pg
)ETO_OFR,
ETO_OFR_MAPPING_EXPIRED
WHERE ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID
GROUP BY ETO_OFR_DISPLAY_ID,APPROV_DATE
ORDER BY APPROV_DATE,ETO_OFR_DISPLAY_ID 
) A";
 
$sth9 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_5_2_expired, array(':start_date'=>$start_date,':end_date' => $end_date,':IN_CNTRY_FLAG'=>$cntryFlag,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
}    
    
  if($request==15){
	
#Total Enriched Columns Data (ALL)

$sql_8="SELECT 
   SUM(OTHER_DETAIL) OTHER_DETAIL,
   SUM(Application) Application,
   SUM(ApproxOrderValue) ApproxOrderValue,
   SUM(PurchaseFrom) PurchaseFrom,
   SUM(LocationPref) LocationPref,
   SUM(want_to_purchase) want_to_purchase,
   SUM(need_this) need_this,
   SUM(req_frequency) req_frequency
FROM
(
SELECT 
   COUNT(CASE WHEN ETO_OFR_OTHER_DETAIL IS NOT NULL THEN 1 END)OTHER_DETAIL,
   COUNT(CASE WHEN ETO_OFR_REQ_APP_USAGE IS NOT NULL THEN 1 END)Application,
   COUNT(CASE WHEN ETO_OFR_APPROX_ORDER_VALUE IS NOT NULL THEN 1 END)ApproxOrderValue,
   COUNT(CASE WHEN ETO_OFR_PUR_FRM_TBD IS NOT NULL THEN 1 END)PurchaseFrom,
   COUNT(CASE WHEN ETO_OFR_GEOGRAPHY_ID IS NOT NULL THEN 1 END)LocationPref,
   COUNT(CASE WHEN ETO_OFR_REQ_PURCHASE_PERIOD IS NOT NULL THEN 1 END)want_to_purchase,
   COUNT(CASE WHEN ETO_OFR_REQ_TYPE IS NOT NULL THEN 1 END)need_this,
   COUNT(CASE WHEN ETO_OFR_REQ_FREQ IS NOT NULL THEN 1 END)req_frequency
FROM
ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' AND FK_GL_COUNTRY_ISO='IN'
AND date(ETO_OFR_APPROV_DATE_ORIG)>=to_date(:start_date,'DD-MON-YYYY')
AND date(ETO_OFR_APPROV_DATE_ORIG)<=to_date(:end_date,'DD-MON-YYYY')
$countrycond 
AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
$identifierCond1_pg
UNION
SELECT 
   COUNT(CASE WHEN ETO_OFR_OTHER_DETAIL IS NOT NULL THEN 1 END)OTHER_DETAIL,
   COUNT(CASE WHEN ETO_OFR_REQ_APP_USAGE IS NOT NULL THEN 1 END)Application,
   COUNT(CASE WHEN ETO_OFR_APPROX_ORDER_VALUE IS NOT NULL THEN 1 END)ApproxOrderValue,
   COUNT(CASE WHEN ETO_OFR_PUR_FRM_TBD IS NOT NULL THEN 1 END)PurchaseFrom,
   COUNT(CASE WHEN ETO_OFR_GEOGRAPHY_ID IS NOT NULL THEN 1 END)LocationPref,
   COUNT(CASE WHEN ETO_OFR_REQ_PURCHASE_PERIOD IS NOT NULL THEN 1 END)want_to_purchase,
   COUNT(CASE WHEN ETO_OFR_REQ_TYPE IS NOT NULL THEN 1 END)need_this,
   COUNT(CASE WHEN ETO_OFR_REQ_FREQ IS NOT NULL THEN 1 END)req_frequency
FROM
ETO_OFR_EXPIRED WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' AND FK_GL_COUNTRY_ISO='IN'
AND date(ETO_OFR_APPROV_DATE_ORIG)>=to_date(:start_date,'DD-MON-YYYY')
AND date(ETO_OFR_APPROV_DATE_ORIG)<=to_date(:end_date,'DD-MON-YYYY') 
$countrycond  
AND coalesce(ETO_OFR_CALL_DISPOSITION_ID,-999)=:ETO_OFR_CALL_DISPOSITION_ID
$identifierCond1_pg
) A";

$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_8, array(':start_date'=>$start_date,':end_date' => $end_date,':ETO_OFR_CALL_DISPOSITION_ID'=>$dispositionId));
}     
return array($sth,$sth_expired,$sth3,$sth4,$sth5,$sth6,$sth7,$sth8,$sth9);    
}

public function TTSData($request)
	{
		$model = new GlobalmodelForm();
                $conn_obj=new Globalconnection();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
                }
		$trend=$request->getParam('trend','');
		$start_date=$request->getParam('start_date','');
		$end_date=$request->getParam('end_date','');
		$vendor=$request->getParam('vendor','Both');
                $drp_pool=$request->getParam('drp_pool','All');
		$recData='';
                $currentDate = strtoupper(date("d-M-Y"));
                $dtime= strtoupper($start_date);
                $leap_dialer_response='leap_dialer_response_arch';
                $leap_activity_stats='leap_activity_stats_arch';$eto_ofr_from_fenq='eto_ofr_from_fenq_arch';
                if($dtime == $currentDate)
		{ 
                    $leap_dialer_response='leap_dialer_response';
                    $leap_activity_stats='leap_activity_stats';$eto_ofr_from_fenq='eto_ofr_from_fenq';
                }
                $cond=$cond2='';
                if($vendor=='Both'){
                    $cond=" and leap_vendor_name in ('VKALPTTS','COMPETENTTTS')";
                    $cond2=" and eto_leap_vendor_name in ('VKALPINTENT','COMPETENT') ";
                }else{
                    $cond=" and leap_vendor_name='$vendor'";
                    if($vendor=='VKALPTTS'){
                        $cond2=" and eto_leap_vendor_name='VKALPINTENT'";
                    }else{
                      $cond2=" and eto_leap_vendor_name='COMPETENT'";  
                    }                    
                }
                if($drp_pool <>'All'){
                    $cond .=" and skill_pool_id=$drp_pool";
                }
		if($trend =='hourly')
		{ 
                     $sql="select 
                        count(case when call_disposition != 'REMOVE BY LEAP' then 1 end)dialed,
                        count(Case when CALL_DISPOSITION in ('Connected-No Response', 'Connected-Approve', 'Connected-Patched', 'Connected-Delete') then 1 end)
                        connected,
                        count(Case when CALL_DISPOSITION ='Connected-Approve' then 1 end)approved,
                        count(Case when CALL_DISPOSITION ='Connected-Delete' then 1 end)deleted,
                        count(Case when CALL_DISPOSITION ='Connected-Patched' then 1 end)patched,
                        count(Case when CALL_DISPOSITION ='Connected-No Response' then 1 end)no_response,
                        hh  
                        from
                        (
                        select  
                        extract(hour from call_attempt_date)hh,
                        call_disposition 
                        from $leap_dialer_response  
                        where fk_leap_tts_master_id is not null
                        and call_attempt_date is not null 
                        $cond   
                        and date(call_attempt_date) = to_date('$start_date','DD-Mon-YYYY')   
                        )a
                        group by hh having hh>8 and hh<22";
                }else if($trend =='skillpoolwise')
		{
                    $condvendor='';
                    if($vendor<>'Both'){
                        $condvendor=", leap_vendor_name";
                    }
                    $sql="select 
                        count(case when call_disposition != 'REMOVE BY LEAP' then 1 end)dialed,
                        count(Case when CALL_DISPOSITION in ('Connected-No Response', 'Connected-Approve', 'Connected-Patched', 'Connected-Delete') then 1 end)
                        connected,
                        count(Case when CALL_DISPOSITION ='Connected-Approve' then 1 end)approved,
                        count(Case when CALL_DISPOSITION ='Connected-Delete' then 1 end)deleted,
                        count(Case when CALL_DISPOSITION ='Connected-Patched' then 1 end)patched,
                        count(Case when CALL_DISPOSITION ='Connected-No Response' then 1 end)no_response,
                        skill_pool_id,
                        dd$condvendor 
                        from
                        (
                        select leap_vendor_name, date(call_attempt_date) dd,call_disposition,skill_pool_id 
                        from $leap_dialer_response  
                        where fk_leap_tts_master_id is not null
                        and call_attempt_date is not null 
                        $cond  
                        and date(call_attempt_date) between to_date('$start_date','DD-Mon-YYYY')  and to_date('$end_date','DD-Mon-YYYY') 
                        )a
                        group by dd$condvendor,skill_pool_id "; 
		}else{
                    $condvendor=$condvendor2='';
                    if($vendor<>'Both'){
                        $condvendor=", leap_vendor_name";
                        $condvendor2=",eto_leap_vendor_name";
                    }

                    $sql2="select date(ACTIVITY_TIME) dd$condvendor2,
count (distinct(case when fk_eto_ofr_id is not null and ((fenq_del_reason is null ) or (fenq_call_del_reason is null)) then fk_eto_ofr_id end))patch_app
 from 
$leap_activity_stats,$eto_ofr_from_fenq,eto_leap_mis  
where eto_leap_emp_id = fk_employee_id and ACTION = 26 and date(ACTIVITY_TIME) between to_date('$start_date','DD-Mon-YYYY') and to_date('$end_date','DD-Mon-YYYY') 
and FK_ETO_OFR_DISPLAY_ID= dir_query_free_refid 
and user_identifier_flag between 60 and 79 $cond2 
                        group by date(ACTIVITY_TIME)$condvendor2 ";
	 	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql2,array()); 
                $patchapproved=array();
                    while($recResult = $sth->read()){ 
                       // print_r($recResult); 
                        $dates=$recResult['dd'];
                        $patchapproved[$dates] = $recResult['patch_app'];
                    } 
                   //  print_r($patchapproved); 

                    
                     $sql="select count(case when call_disposition != 'REMOVE BY LEAP' then 1 end)dialed,
                        count(Case when CALL_DISPOSITION in ('Connected-No Response', 'Connected-Approve', 'Connected-Patched', 'Connected-Delete') then 1 end)
                        connected,
                        count(Case when CALL_DISPOSITION ='Connected-Approve' then 1 end)approved,
                        count(Case when CALL_DISPOSITION ='Connected-Delete' then 1 end)deleted,
                        count(Case when CALL_DISPOSITION ='Connected-Patched' then 1 end)patched,
                        count(Case when CALL_DISPOSITION ='Connected-No Response' then 1 end)no_response,
                        dd$condvendor 
                        from
                        (
                        select leap_vendor_name, date(call_attempt_date) dd,call_disposition,skill_pool_id 
                        from $leap_dialer_response  
                        where fk_leap_tts_master_id is not null
                        and call_attempt_date is not null 
                        $cond  
                        and date(call_attempt_date) between to_date('$start_date','DD-Mon-YYYY') and to_date('$end_date','DD-Mon-YYYY')  
                        )a
                        group by dd$condvendor ";
                }		
	 	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
               $html_str='';
               if($trend =='hourly')
		{
		$head=array('Hour','Vendor','Skill Pool', 'Dialed', 'Connected', 'Approved','Deleted','Patched','Patched approved','Approval Inc Patch','No Response');                  
               }else{
 		$head=array('Date','Vendor','Skill Pool', 'Dialed', 'Connected', 'Approved','Deleted','Patched','Patched approved','Approval Inc Patch','No Response');                 
               }
		
		echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="100%">';
		$html_str .='<tr>';
		for($i=0;$i<count($head);$i++){
			$html_str .= '<td  style="text-align:center;" bgcolor="#dff8ff" width="8%"><b>'.$head[$i].'</b></td>';
		}
		$i=0;
                $dialed_tot=$connected_tot=$approved_tot=$deleted_tot=$patched_tot=$no_response_tot=$patchapp_tot=$appincpatch_tot=0;

		$html_str .='</tr>';
               
$skillid=array(21=>'Blue Fresh',22=>'Green Fresh',23=>'Yellow Fresh',24=>'Blue Flag',25=>'Green Flag',26=>'Yellow Flag',27=>'Orange Fresh',28=>'Red Fresh');

            if($sth){

                while($recResult = $sth->read()){  
                    $connected_per=$approved_per=$deleted_per=$patched_per=$no_response_per=$appincpatch=0;
                    //echo '<pre>';print_r($recResult);die;
                    $dialed = $recResult['dialed'];                    
                    $connected =$recResult['connected'];
                    if($dialed>0){
                    $connected_per=round($connected*100/$dialed, 2);
                    }
                    $approved = $recResult['approved'];
                    
                    $deleted = $recResult['deleted'] ;
                    
                    $patched= $recResult['patched'];
                    

                    $no_response = $recResult['no_response'] ;
                    if($connected > 0){
                    $approved_per=round($approved*100/$connected, 2);
                    $deleted_per=round($deleted*100/$connected, 2);
                    $patched_per=round($patched*100/$connected, 2);
                    $no_response_per=round($no_response*100/$connected, 2);
                    }
                    $skill_pool_id='All';
                    if($vendor=='Both'){
                        $leap_vendor_name='Both';
                    }else{
                    $leap_vendor_name=@$recResult['leap_vendor_name'];
                    }

                    if($trend =='skillpoolwise')
                        {
                          $recResult['skill_pool_id']=isset($recResult['skill_pool_id'])?$recResult['skill_pool_id']:'';
                             if($skillid[$recResult['skill_pool_id']]!=''){
                            $skill_pool_id  = $skillid[$recResult['skill_pool_id']];
                             }
                        }
                
                    if($trend =='hourly')
                        {
                        if($drp_pool <>'All'){
                            $skill_pool_id  = $skillid[$drp_pool];
                        }
                        $leap_vendor_name=$vendor;
                            $dd=$recResult['hh'];
                            if($dd<10){$dd='0'.$dd;}
                        }else{
                            $dd=$recResult['dd'];                           
                        }
                        $patchapp=0;
                        if($trend =='all')
                        {
                        foreach($patchapproved as $key => $value){
                            if($dd==$key){
                               $patchapp= $value;
                            }
                        }
                        }
                        if($connected>0){
                            $appincpatch= round(((($approved + $patchapp)/$connected)*100),2);
                        }
                      $html_str .= '<tr>'
                              . '<td  style="text-align:center;" >'.$dd.'</td>'
                              . '<td  style="text-align:center;" >'.$leap_vendor_name.'</td>'
                              . '<td  style="text-align:center;" >'.$skill_pool_id.'</td>'
                              . '<td style="text-align:center;" >'.$dialed."</td>"
                              . '<td  style="text-align:center;" >'.$connected.' ('.$connected_per.'% )</td>'
                              . '<td  style="text-align:center;" >'.$approved.' ('.$approved_per.'% )</td>'
                              . '<td  style="text-align:center;" >'.$deleted.' ('.$deleted_per.'% )</td>'
                              . '<td  style="text-align:center;" >'.$patched.' ('.$patched_per.'% )</td>'
                              . '<td  style="text-align:center;" >'.$patchapp.'</td>'                              
                             . '<td  style="text-align:center;" >'.$appincpatch.'% </td>'
                              . '<td  style="text-align:center;" >'.$no_response.' ('.$no_response_per.'% )</td>'
                              . '</tr>';
                            $dialed_tot=$dialed+$dialed_tot;
                            $connected_tot=$connected+$connected_tot;
                            $approved_tot=$approved+$approved_tot;
                            $deleted_tot=$deleted+$deleted_tot;
                            $patched_tot=$patched+$patched_tot;
                            $patchapp_tot=$patchapp+$patchapp_tot;
                            $no_response_tot=$no_response+$no_response_tot;
		            }
            }
                echo $html_str;
                $connected_tot_per=$approved_tot_per=$deleted_tot_per=$patched_tot_per=$no_response_tot_per=0;
                if($dialed_tot>0){
                $connected_tot_per=round($connected_tot*100/$dialed_tot,2);
                }
                if($connected_tot>0){
                $approved_tot_per=round($approved_tot*100/$connected_tot,2);
                $deleted_tot_per=round($deleted_tot*100/$connected_tot,2);
                $patched_tot_per=round($patched_tot*100/$connected_tot,2);
                $no_response_tot_per=round($no_response_tot*100/$connected_tot,2);
                $appincpatch_tot=(($approved_tot+$patchapp_tot)/$connected_tot)*100;

                }
                echo '<tr><td style="text-align:center;" bgcolor="#dff8ff" width="8%" colspan="3"><b>Summary</b></td>'
                        . '<td  style="text-align:center;" bgcolor="#dff8ff">'.$dialed_tot.'</td>'
                . '<td  style="text-align:center;" bgcolor="#dff8ff">'.$connected_tot.' ('.$connected_tot_per.'% )</td>'
                              . '<td  style="text-align:center;" bgcolor="#dff8ff" >'.$approved_tot.' ('.$approved_tot_per.'% )</td>'
                              . '<td  style="text-align:center;" bgcolor="#dff8ff">'.$deleted_tot.' ('.$deleted_tot_per.'% )</td>'
                              . '<td  style="text-align:center;" bgcolor="#dff8ff">'.$patched_tot.' ('.$patched_tot_per.'% )</td>'
              . '<td  style="text-align:center;" bgcolor="#dff8ff">'.$patchapp_tot.'</td>'
                        . '<td  style="text-align:center;" bgcolor="#dff8ff">'.round($appincpatch_tot,2).'% </td>'
                              . '<td  style="text-align:center;" bgcolor="#dff8ff" >'.$no_response_tot.' ('.$no_response_tot_per.'% )</td>'
                              . '</tr></table>';
                die;//return $recData;
	}
        
}   