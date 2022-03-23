
<?php
class AdminEtoForm extends CFormModel{	
	public function editOffer($request,$emp_id,$path,$statusDesc,$userStatusDesc,$mesg,$flagError,$old_offerid,$model) {
        $legalStatus = $ofrDataArr=array();
        $tableflag=$tablename=$userDet = $userDetail='' ; 
        $postParamArr['arc'] = $arc = $request->getParam('arc','');
        $postParamArr['offerID'] = $offerID= $request->getParam('offer','');
		$postParamArr['user'] = $user= $request->getParam('user','');
		$postParamArr['client'] = $client= $request->getParam('client','');
		$postParamArr['ofrcnt'] = $ofrcnt= $request->getParam('ofrcnt','');
		$postParamArr['S_city'] = $S_city= $request->getParam('S_city','') ;
		$postParamArr['usr_city'] = $usr_city=$request->getParam('usr_city','');
		$postParamArr['usr_cityId'] = $usr_cityId=$request->getParam('usr_cityId','');
		$postParamArr['flag'] = $flag=$request->getParam('flag','');		# Flagged Leads
		$postParamArr['country_iso'] = $country_iso=$request->getParam('country_iso','');
		
		$postParamArr['offerID'] = $offerID = (!empty($offerID))? $offerID:0;
		$flagError = (!empty($flagError))? $flagError:0;
               
		$postParamArr['status'] = $status = $request->getParam('status','');
                $postParamArr['tableflag'] = $tableflag = $request->getParam('tableflag','');
                $obj = new Globalconnection();
                $model = new GlobalmodelForm();

                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }  
              
		if($dbh){			
		if(!$old_offerid){
                    $postParamArr['old_offerid'] = $old_offerid = $request->getParam('oldofferid','');
		}
                if($tableflag=='TA'){
                    $status = $statusArr['STATUS']='D';	              
                    $tableName='ETO_OFR_TEMP_DEL_ARCH';                    
                }elseif($tableflag=='FA'){  
                    $status = $statusArr['STATUS']='D';	
                    $tableName='ETO_OFR_FROM_FENQ_ARCH';   
                }elseif($tableflag=='EOW'){  
                    $status = $statusArr['STATUS']='W';	
                    $tableName='ETO_OFR';   
                }else{ 
                    if($arc == 1){                                                   
                        $tableName='ETO_OFR_TEMP_DEL_ARCH';                       
                        $sqlStatus  = "
                        SELECT 'T' STATUS FROM ETO_OFR_TEMP_DEL_ARCH WHERE ETO_OFR_DISPLAY_ID = :DISPLAY_ID";			
                        $sthStatus = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlStatus,array(":DISPLAY_ID"=>$offerID));
                        $statusArr1 = $sthStatus->read();
                         if($statusArr1){
                            $statusArr=array_change_key_case($statusArr1, CASE_UPPER);
                         }
                        $status = isset($statusArr['STATUS'])?$statusArr['STATUS']:'';	
                        
                        if(empty($status))
                            {   
                                $tableName='ETO_OFR_FROM_FENQ_ARCH';                                 
                                $sqlStatus  = "Select 'T' STATUS FROM ETO_OFR_FROM_FENQ_ARCH WHERE FK_ETO_OFR_ID IS NULL AND DIR_QUERY_FREE_REFID=:DISPLAY_ID";			
                                $sthStatus = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlStatus,array(":DISPLAY_ID"=>$offerID));
                                $statusArr1 = $sthStatus->read();
                                if($statusArr1){
                                    $statusArr=array_change_key_case($statusArr1, CASE_UPPER);
                                }
                                $status = isset($statusArr['STATUS'])?$statusArr['STATUS']:'';
                        } 
                        if(empty($status))
                            {   
                                $tableName='ETO_OFR_EXPIRED_ARCH';                                 
                                $sqlStatus  = "Select 'E' STATUS FROM ETO_OFR_EXPIRED_ARCH WHERE ETO_OFR_DISPLAY_ID=:DISPLAY_ID";			
                                $sthStatus = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlStatus,array(":DISPLAY_ID"=>$offerID));
                                $statusArr1 = $sthStatus->read();
                                if($statusArr1){
                                $statusArr=array_change_key_case($statusArr1, CASE_UPPER);
                                }
                                $status =isset($statusArr['STATUS'])?$statusArr['STATUS']:'';	
                        } 
                    }else{
                        $sqlStatus  = "
			SELECT (case when ETO_OFR_APPROV ='W' then 'F' ELSE ETO_OFR_APPROV end) STATUS FROM ETO_OFR WHERE ETO_OFR_APPROV IN('P','Q','W','A') AND ETO_OFR_DISPLAY_ID = :DISPLAY_ID
                        UNION ALL
                        SELECT 'W' STATUS FROM DIR_QUERY_FREE WHERE ETO_OFR_DISPLAY_ID = :DISPLAY_ID
                        UNION ALL
			SELECT 'E' STATUS FROM ETO_OFR_EXPIRED WHERE ETO_OFR_DISPLAY_ID = :DISPLAY_ID
                        UNION ALL
			SELECT 'D' STATUS FROM ETO_OFR_TEMP_DEL WHERE ETO_OFR_DISPLAY_ID = :DISPLAY_ID";
                        
			$sthStatus = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlStatus,array(":DISPLAY_ID"=>$offerID));
			$statusArr1 = $sthStatus->read();
            if($statusArr1){
                $statusArr=array_change_key_case($statusArr1, CASE_UPPER);
            }
			$status = isset($statusArr['STATUS'])?$statusArr['STATUS']:'';	
			$stsArr = array(
                        'F' => 'ETO_OFR',
                        'P' => 'ETO_OFR',
                        'Q' => 'ETO_OFR',
                        'W' => 'DIR_QUERY_FREE',
                        'A' => 'ETO_OFR',
                        'E' => 'ETO_OFR_EXPIRED',
                        'D' => 'ETO_OFR_TEMP_DEL',                       
                        );

                        $tableName = isset($stsArr[$status])?$stsArr[$status]:'ETO_OFR';
                        if(empty($status))
                        {       $tableName='ETO_OFR_FROM_FENQ';
                                $sqlStatus  = "Select 'D' STATUS FROM ETO_OFR_FROM_FENQ WHERE FK_ETO_OFR_ID IS NULL AND DIR_QUERY_FREE_REFID=:DISPLAY_ID";
                                $sthStatus = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlStatus,array(":DISPLAY_ID"=>$offerID));
                                $statusArr1 = $sthStatus->read();
                                if($statusArr1){
                                $statusArr=array_change_key_case($statusArr1, CASE_UPPER);
                                }
                                $status = isset($statusArr['STATUS'])?$statusArr['STATUS']:'';	
                        }
                    } 
                    $postParamArr['status'] = $status;
                }
              if($tableName == 'DIR_QUERY_FREE'){
			$sql1 = "select x.* 
                                from(
                                   SELECT 
                                      DIR_QUERY_FREE_BL_TYP,
                                      CASE WHEN DIR_QUERY_FREE_BL_TYP = 1 THEN 1 ELSE 2 END TABLE_TYP,
                                      ETO_OFR_DISPLAY_ID ETO_OFR_ID, FK_GLUSR_USR_ID, 
                                      0 ETO_OFR_VERIFIED,ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, 
                                      ETO_OFR_TYP, SUBJECT ETO_OFR_TITLE,
                                      TO_CHAR(ETO_OFR_DATE, 'DD-Mon-yyyy HH:MI:SS AM') OFFER_DATE,
                                      TO_CHAR(ETO_OFR_EXP_DATE,'DD-Mon-yyyy HH:MI:SS AM') AS EXP_DATE,
                                      TO_CHAR(ETO_OFR_DELETIONDATE,'DD-Mon-yyyy HH:MI:SS AM') AS EXPIRED_ON_DATE,
                                      TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                                      MESSAGE ETO_OFR_DESC, 0 ETO_OFR_QLTY, DIR_QUERY_FREE_QTY ETO_OFR_QTY,DIR_QUERY_QTY_UNIT ETO_OFR_QTY_UNIT,
                                      DIR_QUERY_CATID FK_GLCAT_CAT_ID, 
                                      ETO_OFR_APPROV, 
                                      TO_CHAR(DATE_R, 'DD-Mon-yyyy HH:MI:SS AM') POST_DATE_ORIG,
                                      S_COUNTRY_RATING ETO_OFR_QUALITY,
                                      ACTION_BY_EMP_ID AS POSTEDBYEMPLOYEE_NAME,
                                      (CASE WHEN DIR_QUERY_FREE_BL_TYP=2 THEN 'FENQ - '||QUERY_MODID ELSE QUERY_MODID END) FK_GL_MODULE_ID,
                                       CASE WHEN QUERY_MODID = 'ETO' then 'https://trade.indiamart.com/' else QUERY_REFERENCE_URL end as ETO_OFR_PAGE_REFERRER,
                                      SENDERNAME ETO_OFR_S_SENDERNAME,
                                      S_ORGANIZATION ETO_OFR_S_ORGANIZATION, 0 ETO_OFR_S_DESIGNATION, S_STREETADDRESS ETO_OFR_S_STREETADDRESS,
                                      S_CITY ETO_OFR_S_CITY, S_STATE ETO_OFR_S_STATE, S_ZIP ETO_OFR_S_ZIP, S_COUNTRY ETO_OFR_S_COUNTRY,
                                      DIR_QUERY_S_PH_COUNTRY ETO_OFR_S_PH_COUNTRY, DIR_QUERY_S_PH_AREA ETO_OFR_S_PH_AREA,
                                      S_PHONE ETO_OFR_S_PH_NUMBER,DIR_QUERY_S_IP ETO_OFR_S_IP,S_IP_COUNTRY ETO_OFR_S_IP_COUNTRY,
                                      S_MOBILE ETO_OFR_S_PH_MOBILE, DIR_QUERY_S_URL ETO_OFR_S_URL, 
                                          case when DIR_QUERY_MCATID IS NULL then NULL ELSE (SELECT GLCAT_MCAT_NAME || (CASE WHEN GLCAT_MCAT_IS_GENERIC = 1 THEN ' ( Generic )' else '' end) GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID = DIR_QUERY_MCATID) END GLCAT_MCAT_NAME,
                                      GLCAT_CAT_NAME, DIR_QUERY_MCATID FK_GLCAT_MCAT_ID, 
                                      'General' LEAD_TYPE,
                                      NULL PS_TYPE,
                                      (CASE 
                                       WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 'FOREIGN'
                                       WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                       WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' 
                                       WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                                       WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND Coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                                       WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                                       WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST'
                                       ELSE 'Must Call' END) POOL_TYPE,                                 
                                               eto_ofr_gl_country_name,
                                       (SELECT ETO_LEAP_VENDOR_NAME || case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END FROM eto_leap_mis_interim WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                                       (select gl_emp_name from gl_emp,eto_leap_mis_interim WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) LEADER_NAME,
                                       (select extract(day from DATE_R- ETO_LEAP_AGENT_JOINING_DATE) from eto_leap_mis_interim WHERE ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) ASSOCIATE_VINTAGE,
                                       (CASE WHEN USER_IDENTIFIER_FLAG IN(24,38,60,92,93) THEN 'Yes' ELSE 'No' END) AOV_FLAG,
                                       (CASE WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '1' then 'RED' 
                                        WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '2' then 'ORANGE' 
                                        WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '3' then 'YELLOW'  
                                        WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '4' then 'GREEN' 
                                        WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '5' then 'BLUE' END) RAG_SCORE,
                                       NULL ETO_OFR_CALL_VERIFIED,NULL ETO_OFR_EMAIL_VERIFIED,NULL ETO_OFR_ONLINE_VERIFIED,
                                               NULL CALL_DEL_REASON,
                                       DIR_QUERY_FREE_LATITUDE ETO_OFR_LATITUDE, DIR_QUERY_FREE_LONGITUDE ETO_OFR_LONGITUDE 
                                   FROM $tableName left join GLCAT_CAT on DIR_QUERY_CATID = GLCAT_CAT_ID
                                   WHERE DIR_QUERY_FREE_BL_TYP IN (1,2) 
                                   AND ETO_OFR_DISPLAY_ID = :offerID
                                           )x";                               
		}else if($tableName=='ETO_OFR_FROM_FENQ' or $tableName=='ETO_OFR_FROM_FENQ_ARCH')
		{	
		 $sql1="SELECT DIR_QUERY_FREE_REFID ETO_OFR_ID, 
                                3 TABLE_TYP, 
                                FK_GLUSR_USR_ID, 
                                FENQ_IS_REVIEWED ETO_OFR_VERIFIED, 
                                FENQ_CALL_RECORDING_URL CALL_RECORDING_URL, 
                                QUERYTYPE ETO_OFR_TYP,
                                NULL ETO_OFR_TITLE,
                                TO_CHAR(DATE_R, 'DD-Mon-yyyy HH:MI:SS AM') OFFER_DATE,
                                NULL EXP_DATE,
                                TO_CHAR(ETO_OFR_FENQ_DATE,'DD-Mon-yyyy HH:MI:SS AM') AS EXPIRED_ON_DATE,
                                NULL APPROV_DATE,
                                MESSAGE ETO_OFR_DESC, 
                                NULL ETO_OFR_QLTY,
                                DIR_QUERY_FREE_QTY ETO_OFR_QTY,
                                NULL ETO_OFR_QTY_UNIT, 
                                DIR_QUERY_CATID FK_GLCAT_CAT_ID, 
                                NULL ETO_OFR_APPROV, 
                                TO_CHAR(DATE_R, 'DD-Mon-yyyy HH:MI:SS AM') POST_DATE_ORIG,
                                NULL ETO_OFR_REFRESHCOUNT,
                                NULL ETO_OFR_QUALITY,
                                FK_EMPLOYEEID AS POSTEDBYEMPLOYEE_NAME,'FENQ - '||QUERY_MODID FK_GL_MODULE_ID, 
                                CASE WHEN QUERY_MODID = 'ETO' then 'https://trade.indiamart.com/' else QUERY_REFERENCE_URL end as ETO_OFR_PAGE_REFERRER,
                                SENDERNAME ETO_OFR_S_SENDERNAME,
                                S_ORGANIZATION ETO_OFR_S_ORGANIZATION, 
                                S_DESIGNATION ETO_OFR_S_DESIGNATION, 
                                S_STREETADDRESS ETO_OFR_S_STREETADDRESS, 
                                S_CITY ETO_OFR_S_CITY,
                                S_STATE ETO_OFR_S_STATE, 
                                S_ZIP ETO_OFR_S_ZIP, 
                                S_COUNTRY ETO_OFR_S_COUNTRY,
                                NULL ETO_OFR_S_PH_COUNTRY, 
                                NULL ETO_OFR_S_PH_AREA, 
                                S_PHONE ETO_OFR_S_PH_NUMBER, 
                                DIR_QUERY_S_IP ETO_OFR_S_IP,
                                S_IP_COUNTRY ETO_OFR_S_IP_COUNTRY,
                                S_PHONE ETO_OFR_S_PH_MOBILE, 
                                NULL ETO_OFR_S_URL, 
                                case when DIR_QUERY_MCATID IS NULL then NULL ELSE (SELECT GLCAT_MCAT_NAME || (CASE WHEN GLCAT_MCAT_IS_GENERIC = 1 THEN ' ( Generic )' else '' end) GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID = DIR_QUERY_MCATID) END GLCAT_MCAT_NAME,
                                GLCAT_CAT_NAME, GL_EMP_NAME,
                                FK_EMPLOYEEID GL_EMP_ID,
                                DIR_QUERY_MCATID FK_GLCAT_MCAT_ID, 
                                'General' LEAD_TYPE,
                                NULL PS_TYPE,
                                (CASE 
                                  WHEN S_COUNTRY_UPPER <> 'IN'  THEN 'FOREIGN' 
                                  WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                                  WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
				  WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  WHEN Coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
				  ELSE 'Must Call' END) POOL_TYPE,
                                S_COUNTRY_UPPER ETO_OFR_GL_COUNTRY_NAME ,
                                 (CASE WHEN ETO_OFR_FENQ_EMP_ID < 0 THEN 'Auto Delete' ELSE (SELECT ETO_LEAP_VENDOR_NAME || (case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END) FROM eto_leap_mis_interim WHERE ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID ) END)  ETO_LEAP_VENDOR_NAME,
                                 (select gl_emp_name from gl_emp,eto_leap_mis_interim WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID) LEADER_NAME,
                                  (select extract(day from ETO_OFR_FENQ_DATE- ETO_LEAP_AGENT_JOINING_DATE) from eto_leap_mis_interim WHERE ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID) ASSOCIATE_VINTAGE,
                                (CASE WHEN USER_IDENTIFIER_FLAG IN(24,38,60,92,93) THEN 'Yes' ELSE 'No' END) AOV_FLAG,
                                 (CASE WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '1' then 'RED' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '2' then 'ORANGE' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '3' then 'YELLOW'  
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '4' then 'GREEN' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '5' then 'BLUE' END) RAG_SCORE,
                                 NULL ETO_OFR_CALL_VERIFIED,NULL ETO_OFR_EMAIL_VERIFIED,NULL ETO_OFR_ONLINE_VERIFIED,
                                Coalesce((SELECT IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=3 
                                and IIL_MASTER_DATA_VALUE=Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON)::text),'') 
                                ||'('|| Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON) ||')' CALL_DEL_REASON,
                                DIR_QUERY_FREE_LATITUDE ETO_OFR_LATITUDE, DIR_QUERY_FREE_LONGITUDE ETO_OFR_LONGITUDE  
                            FROM $tableName left join GLCAT_CAT on DIR_QUERY_CATID = GLCAT_CAT_ID 
                                left join GL_EMP on ETO_OFR_FENQ_EMP_ID = GL_EMP_ID 
                        WHERE DIR_QUERY_FREE_REFID= :offerID AND FK_ETO_OFR_ID IS NULL";
                                
                      }else{		    
                            if($tableName=='ETO_OFR_TEMP_DEL' or $tableName=='ETO_OFR_TEMP_DEL_ARCH'){
                            $tem_condition=  "(CASE WHEN ETO_OFR_DELETEDBYID < 0 THEN 'Auto Delete' ELSE (SELECT ETO_LEAP_VENDOR_NAME || (case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END) FROM eto_leap_mis_interim WHERE ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID ) END)  ETO_LEAP_VENDOR_NAME, 
                                (select gl_emp_name from gl_emp,eto_leap_mis_interim WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID) LEADER_NAME,
                                (select extract(day from ETO_OFR_DELETIONDATE- ETO_LEAP_AGENT_JOINING_DATE)  from eto_leap_mis_interim WHERE ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID) ASSOCIATE_VINTAGE,
                                (CASE WHEN USER_IDENTIFIER_FLAG IN(24,38,60,92,93) THEN 'Yes' ELSE 'No' END) AOV_FLAG,
                                (CASE WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '1' then 'RED' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '2' then 'ORANGE' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '3' then 'YELLOW'  
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '4' then 'GREEN' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '5' then 'BLUE' END) RAG_SCORE,
                                 NULL ETO_OFR_CALL_VERIFIED,NULL ETO_OFR_EMAIL_VERIFIED,NULL ETO_OFR_ONLINE_VERIFIED,
                                ETO_OFR_HIST_COMMENTS||'('|| FK_ETO_OFR_DEL_REASON_CODE ||')' CALL_DEL_REASON,
                                 ETO_OFR_LATITUDE,ETO_OFR_LONGITUDE 
                                  FROM ".$tableName." left join GLCAT_CAT on FK_GLCAT_CAT_ID = GLCAT_CAT_ID 
                                left join GL_EMP on ETO_OFR_DELETEDBYID = GL_EMP_ID 
                                 WHERE ETO_OFR_DISPLAY_ID= :offerID ";
                            } else{                                
                            $tem_condition=" (SELECT ETO_LEAP_VENDOR_NAME || (case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END) FROM eto_leap_mis_interim WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                                          (select gl_emp_name from gl_emp,eto_leap_mis_interim WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) LEADER_NAME,
                                          (select extract(day from ETO_OFR_APPROV_DATE- ETO_LEAP_AGENT_JOINING_DATE)  from eto_leap_mis_interim WHERE ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) ASSOCIATE_VINTAGE,
                                          (CASE WHEN USER_IDENTIFIER_FLAG IN(24,38,60,92,93) THEN 'Yes' ELSE 'No' END) AOV_FLAG,
                                 (CASE WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '1' then 'RED' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '2' then 'ORANGE' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '3' then 'YELLOW'  
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '4' then 'GREEN' 
                                    WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '5' then 'BLUE' END) RAG_SCORE,
                                 ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED,
                                 NULL CALL_DEL_REASON,ETO_OFR_LATITUDE,ETO_OFR_LONGITUDE   
                                 FROM ".$tableName." left join GLCAT_CAT on FK_GLCAT_CAT_ID = GLCAT_CAT_ID 
                                left join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                                 WHERE ETO_OFR_DISPLAY_ID= :offerID ";
                            }
                                 $sql1 = "
                                 SELECT 
				ETO_OFR_DISPLAY_ID ETO_OFR_ID, 
				3 TABLE_TYP, FK_GLUSR_USR_ID, 
                                ETO_OFR_VERIFIED, ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, 
                                ETO_OFR_TYP, ETO_OFR_TITLE, TO_CHAR(ETO_OFR_DATE, 'DD-Mon-yyyy HH:MI:SS AM') OFFER_DATE,
                                TO_CHAR(ETO_OFR_EXP_DATE,'DD-Mon-yyyy HH:MI:SS AM') EXP_DATE,
                                TO_CHAR(ETO_OFR_DELETIONDATE,'DD-Mon-yyyy HH:MI:SS AM') AS EXPIRED_ON_DATE,
                                TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                                ETO_OFR_DESC, ETO_OFR_QLTY, ETO_OFR_QTY,ETO_OFR_QTY_UNIT, FK_GLCAT_CAT_ID, 
                                ETO_OFR_APPROV, TO_CHAR(ETO_OFR_POSTDATE_ORIG, 'DD-Mon-yyyy HH:MI:SS AM') POST_DATE_ORIG,
                                ETO_OFR_REFRESHCOUNT,ETO_OFR_QUALITY,
                                ETO_OFR_POSTEDBYEMPLOYEE AS POSTEDBYEMPLOYEE_NAME, FK_GL_MODULE_ID,
                                CASE WHEN FK_GL_MODULE_ID = 'ETO' then 'https://trade.indiamart.com/' else ETO_OFR_PAGE_REFERRER end as ETO_OFR_PAGE_REFERRER  ,
                                ETO_OFR_S_SENDERNAME, ETO_OFR_S_ORGANIZATION, ETO_OFR_S_DESIGNATION, ETO_OFR_S_STREETADDRESS, ETO_OFR_S_CITY, ETO_OFR_S_STATE, ETO_OFR_S_ZIP, ETO_OFR_S_COUNTRY, ETO_OFR_S_PH_COUNTRY, ETO_OFR_S_PH_AREA, ETO_OFR_S_PH_NUMBER, 
                                ETO_OFR_S_IP,ETO_OFR_S_IP_COUNTRY, ETO_OFR_S_PH_MOBILE, ETO_OFR_S_URL, 
                                case when FK_GLCAT_MCAT_ID IS NULL then NULL ELSE (SELECT GLCAT_MCAT_NAME || (CASE WHEN GLCAT_MCAT_IS_GENERIC = 1 THEN ' ( Generic )' else '' end) GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID) END GLCAT_MCAT_NAME, 
                                GLCAT_CAT_NAME, GL_EMP_NAME,GL_EMP_ID, FK_GLCAT_MCAT_ID, 
                                (CASE WHEN ETO_ENQ_TYP IN (1,3,5,6) THEN 'Yes' WHEN ETO_ENQ_TYP IN(2,4) THEN 'No' ELSE 'NA' END) LEAD_TYPE,
                                (CASE WHEN ETO_OFR_PROD_SERV='P'
                                            THEN 'Product'
                                      WHEN ETO_OFR_PROD_SERV='S'
                                            THEN 'Service'
                                      ELSE NULL      
                                 END
                                 ) PS_TYPE,
                                (CASE 
                                  WHEN $tableName.FK_GL_COUNTRY_ISO <> 'IN' THEN 'FOREIGN' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (13,15) THEN 'PROCMART'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'SERVICE-Must'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  ELSE 'Must Call' END) POOL_TYPE,
                                ETO_OFR_GL_COUNTRY_NAME ,
                                $tem_condition
                                ";
			}
                        
                                    
		$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, array(":offerID" => $offerID));
		$ofrDataArr1 = $sth1->read();
                if($ofrDataArr1){
                $ofrDataArr=array_change_key_case($ofrDataArr1, CASE_UPPER);
                }
                $empId = Yii::app()->session['empid'];
               // if($empId==3575){
                //    echo $tableName.$sql1; 
                //    print_r($ofrDataArr);
                //}
		$postParamArr['mcatmapping'] = $mcatmapping = $request->getParam('mcatmapping','Y');
                $start=0;
		$postParamArr['userStatus'] =  $userStatus = 'W';                
		$postParamArr['ofrtype'] = $ofrtype = $request->getParam('ofrtype','');	
		$ofrmodid =  isset($ofrDataArr['FK_GL_MODULE_ID'])?$ofrDataArr['FK_GL_MODULE_ID']:'';
		$glusrid = isset($ofrDataArr['FK_GLUSR_USR_ID'])?$ofrDataArr['FK_GLUSR_USR_ID']:'';
		$origModid = isset($ofrDataArr['FK_GL_MODULE_ID'])?$ofrDataArr['FK_GL_MODULE_ID']:'';
		$userStatus = isset($ofrDataArr['ETO_OFR_APPROV'])?$ofrDataArr['ETO_OFR_APPROV']:$userStatus;
		$mcat_id=isset($ofrDataArr['FK_GLCAT_MCAT_ID'])?$ofrDataArr['FK_GLCAT_MCAT_ID']:'';
                $lead_type=isset($ofrDataArr['LEAD_TYPE'])?$ofrDataArr['LEAD_TYPE']:'';
                $pool_type=isset($ofrDataArr['POOL_TYPE'])?$ofrDataArr['POOL_TYPE']:'';
                $ps_type=isset($ofrDataArr['PS_TYPE'])?$ofrDataArr['PS_TYPE']:'';
                if($tableName=='ETO_OFR'){
                    $liveofrstatus = isset($ofrDataArr['ETO_OFR_APPROV'])?$ofrDataArr['ETO_OFR_APPROV']:'';
                    if($liveofrstatus=='W'){
                        $status = $statusArr['STATUS']='F';  
                    }else{
                       $status = $statusArr['STATUS']= $liveofrstatus;
                    }
                }
		if($ofrmodid == 'FENQ')
		{ 
                        $sqlFenq= "SELECT QUERY_MODID FROM ETO_OFR_FROM_FENQ WHERE FK_ETO_OFR_ID = :OFFER_ID";                    		
                        $sthFenq = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sqlFenq, array(':OFFER_ID'=> $offerID));
                        $haFenq1 = $sthFenq->read();	
                        if($haFenq1){
                        $haFenq=array_change_key_case($haFenq1, CASE_UPPER);
                        }
                        if(isset($haFenq['QUERY_MODID'])){
                            $origModid = isset($haFenq['QUERY_MODID']) ? "FENQ - ".$haFenq['QUERY_MODID'] : 'FENQ';
                    }else{
                         $sqlFenq= "SELECT QUERY_MODID
                           FROM ETO_OFR_FROM_FENQ_ARCH WHERE FK_ETO_OFR_ID = :OFFER_ID";                    		
                        $sthFenq = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sqlFenq, array(':OFFER_ID'=> $offerID));
                        $haFenq1 = $sthFenq->read();                        
                        if($haFenq1){
                        $haFenq=array_change_key_case($haFenq1, CASE_UPPER);
                        }
                        $origModid = isset($haFenq['QUERY_MODID']) ? "FENQ - ".$haFenq['QUERY_MODID'] : 'FENQ';
                    }
		}
		$isClient = '';				
		$email= isset($ofrDataArr['GLUSR_USR_EMAIL'])? trim($ofrDataArr['GLUSR_USR_EMAIL']) :'';
		$domain_val = '';
		$correct_domain = $incorrect_domain='';
		if(!empty($email)){
			$email = preg_replace('/\s/',"",$email);		
                    $domain = split('/\@/', $email );
                    $domain1 = split('/\./', $domain[1]);
                    $domain_val = $domain1[0];
                 }
               if($glusrid > 0){
                    $userDet = $model->get_glusr_detail($glusrid,'ALL');
                    if(empty($userDet['GLUSR_USR_ID'])){
                       echo "<div><b style='font-size:15px;color:red;padding-left:20px'>Error in GL Detail Service for GLID: $glusrid</b></div>";exit;  
                    }
               }
              
               $show_client1 = $isClient ='';
               $cust_w=isset($userDet['GLUSR_USR_CUSTTYPE_WEIGHT'])?$userDet['GLUSR_USR_CUSTTYPE_WEIGHT']:'';                
               if($cust_w==3999){
                   $show_client1 = "[ Demoted FCP ]"; 
               }elseif(isset($userDet['IS_PAID']) && $userDet['IS_PAID']==1){
                        $isClient=1;
			$show_client1 = "[ CLIENT ]";
		}
              $returnArr = array(
			"rec"=>$ofrDataArr,
			"start" => $start,
			"mcatmapping" => $mcatmapping,
			"status" => $status,
			"mesg" => $mesg,
			"show_client1" => $show_client1,			
			"origModid" => $origModid,			
			"postParamArr" => $postParamArr,			
			"userDetail" => $userDetail,
			"correct_domain" => $correct_domain,
			"domain_val" => $domain_val,
			"legalStatus" => $legalStatus,
			"userDet" => $userDet,
			"is_client1" => $isClient,
			"mcat_id"=>$mcat_id,
			"lead_type"=>$lead_type,
			"pool_type"=>$pool_type,
			"ps_type"=>$ps_type,
			"tableflag"=>$tableflag
		);
                return $returnArr;		
                }
	}
	
	public function getleaddetail($model,$offerID,$glusrid,$opt){
                $obj = new Globalconnection();
                $model = new GlobalmodelForm();

                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
              
             $totalApprovOffers=$totalWaitingOffers=$totalDeletedOffers=$totalExpiredOffers=0;                 
            $sqlCntWaiting = "SELECT STATUS,count(OFR_ID) CNT 
                FROM (
                SELECT 'W' STATUS,ETO_OFR_ID OFR_ID FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='W' AND  FK_GLUSR_USR_ID= :usr_id
                UNION ALL 
                SELECT 'W' STATUS,QUERY_ID OFR_ID FROM	DIR_QUERY_FREE WHERE FK_GLUSR_USR_ID= :usr_id
                UNION ALL 
                select 'L' STATUS,ETO_OFR_ID OFR_ID  from eto_ofr where eto_ofr_typ='B' and eto_ofr_approv='A' and  fk_glusr_usr_id=:usr_id
                UNION ALL 
                SELECT 'EXP' STATUS, ETO_OFR_ID  OFR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP='B'  AND  FK_GLUSR_USR_ID= :usr_id
                UNION ALL 
                SELECT 'DEL' STATUS, ETO_OFR_ID OFR_ID from ETO_OFR_TEMP_DEL WHERE FK_GLUSR_USR_ID= :usr_id
                UNION ALL 
                SELECT 'DEL' STATUS ,DIR_QUERY_FREE_REFID OFR_ID  from eto_ofr_from_fenq WHERE FK_ETO_OFR_ID is null and FK_GLUSR_USR_ID= :usr_id
                ) TEMP  		 
                group by STATUS "; 
            
            $sthCntWaiting = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sqlCntWaiting, array(':usr_id' => $glusrid));
            while($data1 = $sthCntWaiting->read()) 
            {
                if($data1){
                    $data=array_change_key_case($data1, CASE_UPPER);
                }
                if(isset($data["STATUS"])){
                    if($data["STATUS"]=='W'){
                        $totalWaitingOffers=$data["CNT"];
                    }
                    if($data["STATUS"]=='L'){
                        $totalApprovOffers=$data["CNT"];
                    }
                    if($data["STATUS"]=='EXP'){
                        $totalExpiredOffers=$data["CNT"];
                    }
                    if($data["STATUS"]=='DEL'){
                        $totalDeletedOffers=$data["CNT"];
                    }
                }
            }
if($totalApprovOffers!=0)
$getBuyOfferCount = '&nbsp;&nbsp;<FONT SIZE="-1" COLOR="#FF0000"><A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=etosearch&mid=3424&mem='.$glusrid.'&do=livelead&type=B&status=A" target="_blank">'.$totalApprovOffers.'</A></FONT>';
else
$getBuyOfferCount = '&nbsp;&nbsp;<FONT SIZE="-1" COLOR="#FF0000">0</FONT>';

if($totalWaitingOffers!=0)
$getBuyOfferCount1 =  '<FONT SIZE="-1" COLOR="#FF0000"><A HREF="/index.php?r=admin_eto/AdminEto/buyleads&action=etosearch&mid=3424&mem='.$glusrid.'&do=livelead&type=B&status=W" target="_blank">'.$totalWaitingOffers.'</A></FONT>';
else
$getBuyOfferCount1 = '&nbsp;&nbsp;<FONT SIZE="-1" COLOR="#FF0000">0</FONT>';

if($totalExpiredOffers!=0)
$getBuyOfferCount2 =  '<FONT SIZE="-1" COLOR="#FF0000"><A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=go&mid=3424&mem='.$glusrid.'&EXPDELLEAD=EXPLEAD" target="_blank">'.$totalExpiredOffers.'</A></FONT>';
else
$getBuyOfferCount2 = '&nbsp;&nbsp;<FONT SIZE="-1" COLOR="#FF0000">0</FONT>';

 if($totalDeletedOffers!=0)
$getBuyOfferCount3 =  '<FONT SIZE="-1" COLOR="#FF0000"><A HREF="/index.php?r=admin_eto/AdminEto/ofrsearch&action=go&mid=3424&mem='.$glusrid.'&EXPDELLEAD=DELLEAD" target="_blank">'.$totalDeletedOffers.'</A></FONT>';
else
$getBuyOfferCount3 = '&nbsp;&nbsp;<FONT SIZE="-1" COLOR="#FF0000">0</FONT>';
                echo '<span style="color:#999999;font-size:11px;">&#9658;</span>&nbsp;Buy Leads ( Live / Waiting ) :'.$getBuyOfferCount." / ".$getBuyOfferCount1.'<br>
		<span style="color:#999999;font-size:11px;">&#9658;</span>&nbsp;Buy Leads ( Expired / Deleted ) :'.$getBuyOfferCount2." / ".$getBuyOfferCount3.'<br>';
        }
	public function getCatMcatDetail($offerID,$model,$ofrStatus) {
		$obj = new Globalconnection();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                    {
                        $dbh = $obj->connect_db_yii('postgress_web77v');   
                    }else{
                        $dbh = $obj->connect_db_yii('postgress_web68v'); 
                    }
		$arr_map = array();
		$table = ($ofrStatus == 'E')?'ETO_OFR_MAPPING_EXPIRED' :'ETO_OFR_MAPPING';
		$sql_map = "SELECT
                    FK_GLCAT_CAT_ID, FK_GLCAT_MCAT_ID, GLCAT_GRP_ID, GLCAT_GRP_NAME, GLCAT_CAT_ID, GLCAT_CAT_NAME, GLCAT_MCAT_NAME, PRIME_MCAT,GLCAT_MCAT_IS_BUSINESS_TYPE 
                    FROM
                    (
                    SELECT FK_GLCAT_CAT_ID, FK_GLCAT_MCAT_ID, FK_GLCAT_GRP_ID, PRIME_MCAT FROM $table WHERE FK_ETO_OFR_ID = :OFFERID
                    )ETO_OFR_MAPPING join GLCAT_CAT
                    on GLCAT_CAT_ID = FK_GLCAT_CAT_ID
                    join GLCAT_GRP on FK_GLCAT_GRP_ID = GLCAT_GRP_ID
                    left join GLCAT_MCAT on GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID
                    ORDER BY FK_GLCAT_MCAT_ID";
		$sth_map = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_map, array(':OFFERID' => $offerID));
		while($rec = $sth_map->read()) {
                        $rec_map=array_change_key_case($rec, CASE_UPPER);     
			array_push($arr_map, $rec_map);
		}
			return $arr_map;
	}
	/* ##### Save Offer ##### */	
	public function saveOffer($emp_id,$model) {
        $emp_id = Yii::app()->session['empid'];     
			$obj = new Globalconnection();
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                            $dbh = $obj->connect_db_yii('postgress_web77v');   
                        }else{
                            $dbh = $obj->connect_db_yii('postgress_web68v'); 
                        }
            
			$request = Yii::app()->request;			
		 	$clientType = $request->getParam('client','');
		 	$user= $request->getParam('user','');
			$status = $request->getParam('status','');
			$status = ($status == 'F')?'W':$status;
			$newStatus = $request->getParam('newStatus','');
		 	$flagApprovMail=0;
			$glusr_id = $request->getParam('glid','');
			$ofrtype = $request->getParam('ofrtype','');
			$ofrcnt = $request->getParam('ofrcnt','');
			$offerID = $request->getParam('offer','');			
			$param = $this->parseEditParam($request);
			$Flagval = $request->getParam('flagval','');
			$bltype = $request->getParam('bltype','');
			if (!empty($Flagval) && $Flagval != '') {
					$param['flagval'] = $Flagval;
			}
			if (!empty($newStatus) && $newStatus != '') {
				$param['approv'] = $newStatus;
			}
             if($param['approv'] == '' && $status == 'A')    {
                $param['approv']='A';
             }       
			$param['cat'] = $request->getParam('cat','');
			if(isset($param['approv']) && $param['approv'] == 'A') {
				$flagApprovMail = 1;
				$param['approv_mail'] = $flagApprovMail;
			}
                   //exit;    
                   if ($emp_id== 86777){
                    echo "<pre>";
                       print_r($request);
                       print_r($param);
                       echo "</pre>";
                   } 
                        $result = $this->updateOffer($request,$dbh,$emp_id,$offerID,$status,$param,$model);
                        
			$sqlSupMap = "SELECT COUNT(1) CNT FROM ETO_LEAD_SUPPLIER_MAPPING WHERE FK_ETO_OFR_DISPLAY_ID = :OFFERID AND ETO_LEADSUPMAP_PROCESSED=8";
			$sth = $model->runSelect(__FILE__,__TYPE__,__CLASS__,$dbh,$sqlSupMap,array(":OFFERID" => $offerID));
                         while($sup1 = $sth->read()) {
                                 $sup=array_change_key_case($sup1, CASE_UPPER);
                                if(isset($sup['CNT']) && $sup['CNT'] == 0 && $flagApprovMail == 1){
                                        //$re = $this->sendApproveMail($dbh,$offerID,$model);	
                                }
                           }
                           if ($emp_id== 86777){
                            print_r($result);
                        } 
                        return $result;
	}
	
	public function parseEditParam($request) {
		$title = $request->getParam('title','');
		$desc = $request->getParam('desc','');
		
		
		$qty = $request->getParam('qty','');
		$qtyUnit = $request->getParam('qty_list_val','');
		$qtyUnitOther = $request->getParam('ETO_OFR_QTY_UNIT_OTHER','');
		
		$verify = $request->getParam('verify','');
		if(!empty($title)){
			$title = substr($title,0,100);
			$otitle = preg_replace("/\'/","''",$title);
			$title = preg_replace("/&nbsp;/"," ",$title);
			if(preg_match('/%u([0-9A-F]+)/', $title)){
				$title = preg_replace('/%u([0-9A-F]+)/', ' ', $title);
			}
			$title = htmlspecialchars_decode($title);
		}
		if (!empty($desc)) {
				$desc = preg_replace("/<br \/>/","\n",$desc);
			    $desc = preg_replace("/(\n){2,}/","\n\n",$desc);
			    $desc = preg_replace("/\?/"," ",$desc);
			    $desc = preg_replace('/[^A-Za-z0-9 !@#$%^&*().]\'/u','', strip_tags($desc));
			    $desc = preg_replace("/&lsquo/"," ",$desc);
			    $desc = preg_replace("/&ldquo/"," ",$desc);
			    $desc = preg_replace("/&rdquo/"," ",$desc);			    
			    $desc = preg_replace("/&rsquo/"," ",$desc);			    
			    $desc = preg_replace("/&nbsp;/"," ",$desc);			    	    
	    
			    
			    if(preg_match('/%u([0-9A-F]+)/', $desc)){
					$desc = preg_replace('/%u([0-9A-F]+)/', ' ', $desc);
			    }	    
			    $desc = htmlspecialchars_decode($desc);
			    $desc = preg_replace("/'/","''",$desc);
			    $desc = trim($desc);

			    $desc = substr($desc,0,3990);
		}
		$qty = substr($qty,0,30);
		$returnArr = array(
			'title' => $title,		
			'desc' => $desc,		
			'qty' => $qty,		
			'qty_list_val' => $qtyUnit,		
			'ETO_OFR_QTY_UNIT_OTHER' => $qtyUnitOther,		
			'verify' => $verify,		
		);
		return $returnArr;
	}
	
	public function updateOffer($request,$dbh,$emp_id,$offerID,$status,$param,$model) {
                $obj = new Globalconnection();
                $emp_id = Yii::app()->session['empid'];
                $dbhW= $obj->connectPostgres_wrt();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh_pgr = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh_pgr = $obj->connect_db_yii('postgress_web68v'); 
                }
         
		$updateFieldsArr = array();
		$upd_modid = $request->getParam('upd_modid','');
		$sourceId = $request->getParam('sourceId','');
		$sourceName= $request->getParam('enq_source','');
		$blType= $request->getParam('bltype','');
		$param['mcat'] = $request->getParam('mcat','');
		$param['PmcatId'] = $request->getParam('PmcatId','');
		$param['oldPmcatId'] = $request->getParam('oldPmcatId','');
		$mcatchanged = $request->getParam('mcatchanged','');
		$sucessArray = array();	
		$fieldName = array('title'=>'ETO_OFR_TITLE',
			'desc'=>'ETO_OFR_DESC',
			'spec'=>'ETO_OFR_SPEC',
			'qlty'=>'ETO_OFR_QLTY',
			'qty'=>'ETO_OFR_QTY',
			'qty_list_val'=>'ETO_OFR_QTY_UNIT',
			'pay'=>'ETO_OFR_PAY_TERM',
			'supply'=>'ETO_OFR_SUPPLY_TERM',
			'approv'=>'ETO_OFR_APPROV',
			'cat'=>'FK_GLCAT_CAT_ID',
			'type'=>'ETO_OFR_TYP',
			'ofr_quality'=>'ETO_OFR_QUALITY',
			'mcat'=>'FK_GLCAT_MCAT_ID',
			'keywords'=>'ETO_OFR_KEYWORDS',
			'updateby'=>'ETO_OFR_HIST_BY',
			'updateusing'=>'ETO_OFR_HIST_USING',
			'updateipcountry'=>'ETO_OFR_HIST_IP_COUNTRY',
			'updatecomments'=>'ETO_OFR_HIST_COMMENTS',
			'updateip'=>'ETO_OFR_HIST_IP',
			'updateref'=>'ETO_OFR_HIST_REF',
			'updateempid'=>'ETO_OFR_HIST_EMP_ID',
			'updateusrid'=>'ETO_OFR_HIST_USR_ID',
			'updatetyp'=>'ETO_OFR_HIST_TYP',
			'flagval'=>'ETO_OFR_IS_FLAGGED');

		$fieldsArr= array();
		$histipcountry = 'India';
		$histip = $_SERVER['REMOTE_ADDR'];
		//exit;
		$emp_name = Yii::app()->session['empname'];
		/* ######## Emp Name ########## */
		$param['updateby']= $emp_name;
		$param['updateusing']= 'Gladmin';
		$param['updatecomments']= !empty($mcatchanged)?'Manual Mcat Mapping':'Offer Updated';
		$param['updateipcountry']= $histipcountry;
		$param['updateip']= $histip;
		$param['updateempid']= $emp_id;
		$param['updateref']= '';
		$param['updateusrid']= '';
		$param['updatetyp'] = 'U';
		$param['cat'] = isset($param['cat'])?$param['cat']:-1;
		$sysdate = 'SYSDATE';
                if ($_REQUEST['approv'] == 'A') {
				$sqlred="SELECT ETO_OFR_TITLE,ETO_OFR_DESC FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID = :OFFERID";							
				$sthCheck = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pgr, $sqlred, array(':OFFERID' => $offerID));
				$recredis = $sthCheck->read();
                                if($recredis){
                                   $rstatus= $this->Redismlbl($request,$offerID,$recredis);
                                }
                }
          
                $param['approv']=isset($param['approv'])?$param['approv']:'';
                if (($param['approv'] == 'A') || ($mcatchanged == 1)) {
			$fieldName['emp_id']='FK_EMPLOYEE_ID';
			$fieldName['approv_date']='ETO_OFR_APPROV_DATE';
			//$fieldName['eto_ofr_date']='ETO_OFR_DATE';
			$param['emp_id'] =$emp_id;
			$param['approv_date'] = $sysdate;
			$param['eto_ofr_date'] = $sysdate;
			$status = $this->catMcatMapping('','',$model, $offerID, $param['cat'], $param['mcat'], $param['PmcatId'], $emp_id);		
                }
            
		$param['mcat'] = $param['PmcatId'];
		$param['verifiedby'] = $emp_id;
		if ($param['verify'] != 1) {
			$param['verify'] = 0;
		}
		$param['mcat'] = $param['PmcatId'];
		$param['verifiedby'] = $emp_id;
		if ($param['verify'] != 1) {
			$param['verify'] = 0;
		}
        if ($emp_id== 86777){
            echo "at line 732";
                echo "<pre>";
               print_r($param);
               echo "</pre>";
           } 
		if(!empty($param['flagval']) && $param['flagval'] != 1) { //In case of flag other than mcat na
            if ($emp_id== 86777){
                echo "at 739";
               } 
			if($blType == 2){
                
				 $sqlPg = "UPDATE 
                                                DIR_QUERY_FREE
                                        SET ETO_OFR_IS_FLAGGED = $1, ETO_OFR_HIST_BY = $2, ETO_OFR_HIST_USING = 'Gladmin',
                                        ETO_OFR_HIST_COMMENTS = 'Offer Updated', ETO_OFR_HIST_IP_COUNTRY = 'India', ETO_OFR_HIST_IP = $3,
                                           FK_EMPLOYEEID= $2, ETO_OFR_HIST_TYP = 'U' WHERE ETO_OFR_DISPLAY_ID = $4";

                                $params=array($param['flagval'],$emp_id,$histip,$offerID);
                                $sthCheck1 = pg_query_params($dbhW,$sqlPg,$params);
                                 if(!$sthCheck1){
                                    $e = pg_last_error($dbhW);
                                    mail("arora.akshita@indiamart.com","PG-Error update Offer function..at fail", 'Query===='.$sthCheck1.'===== offerID=='.$offerID.'====At line no - 753===');	
                                }
                                if ($emp_id== 86777){
                                    echo "at 756";
                                    echo "<pre>";
                                    print_r($sthCheck1);
                                    print_r($e);
                                    echo "</pre>";
                                   } 	
			} else {
			} 
			// PG Block Starts Here
                        if($blType == 2)
                        {   
                        }else{
                            
                            if ($emp_id== 86777){
                                echo "at 770";
                           } 
                         
                                        $flagval=$param['flagval'];
                                        $sqlPg = "UPDATE 
                                                        ETO_OFR 
                                                SET 
                                                        ETO_OFR_IS_FLAGGED = $1, ETO_OFR_HIST_BY = $2, ETO_OFR_HIST_USING = 'Gladmin',
                                                        ETO_OFR_HIST_COMMENTS = 'Offer Updated', ETO_OFR_HIST_IP_COUNTRY = 'India', ETO_OFR_HIST_IP = $3,
                                                   ETO_OFR_HIST_EMP_ID= $2, ETO_OFR_HIST_TYP = 'U' WHERE ETO_OFR_DISPLAY_ID = $4";

                                        $params=array($flagval,$emp_id,$histip,$offerID);
                                $sthCheck1 = pg_query_params($dbhW,$sqlPg,$params);
                                if(!$sthCheck1){
                                    $e = pg_last_error($dbhW); 
                                     mail("arora.akshita@indiamart.com","PG-Error update Offer function..at fail", 'Query===='.$sthCheck1.'===== offerID=='.$offerID.'====At line no - 784===');	

                                }
                                if ($emp_id== 86777){
                                    echo "at 789";
                                    echo "<pre>";
                                    print_r($sthCheck1);
                                    print_r($e);
                                    echo "</pre>";
                                   } 	  
                        }
                        return array("status"=>"SUCCESS","msg" => "UPDATED");			
			// PG Block Ends Here
		} 
         else 	//In case of MCAT NA
		{	 
			if(!empty($param['flagval']) && $param['flagval'] == 1){
				if ($emp_id== 86777){
                    echo "at 803";
                   } 
				// PG Block Starts Here
				try{
					$sqlMcatFlag = "UPDATE ETO_OFR SET ";
					$updateFieldsArr=array();
					foreach ($fieldName as $fKey => $fRow)
					{
						if(isset($param[$fKey]))
						{
							if($fKey == 'approv_date'){
								$fieldArr = $fRow." = now()";			
							}
							else if($fKey == 'qty_list_val' && $param[$fKey] == "Others"){
								$fieldArr = $fRow." = '".$param['ETO_OFR_QTY_UNIT_OTHER']."'";				
							}
							else{																							
								$value = $param[$fKey];
								if($value == ''){
									$fieldArr = $fRow." = NULL";
								}
								else{
									$fieldArr = $fRow." = '".$value."'";
								}
								
							}
							array_push($updateFieldsArr,$fieldArr);				
						}         						
					}  
					$updateFieldsArr = implode(',', $updateFieldsArr);
					$sqlMcatFlag .= $updateFieldsArr. " WHERE ETO_OFR_DISPLAY_ID = $1";
					$params=array($offerID);
					$sqlMcatFlag = preg_replace("/''/","NULL", $sqlMcatFlag);
					
					$sthMcatFlag = pg_query_params($dbhW, $sqlMcatFlag,$params); 					
                    if ($emp_id== 86777){
                        echo "at 839";
                        echo "<pre>";
                        print_r($sthMcatFlag);
                        echo "</pre>";
                       }            
                                        if(!($sthMcatFlag)){
                                            $e = pg_last_error($dbhW);
                                        }else{
                                          $sucessArray = array("status"=>"SUCCESS","msg" => "This Offer has been successfully Updated");
                                          $this->syncEtoOfrVerifiedFlg('' ,'',$offerID,$model, 1);
                                        }
				}catch(Exception $e){
					mail("gladmin-team@indiamart.com","PG-Error update Offer function", 'Query===='.$sqlMcatFlag.'===== offerID=='.$offerID.'====At line no - 846');	
				}
				// PG Block Ends Here	
                if ($emp_id== 86777){
                    echo "at 854";
                    echo "<pre>";
                    print_r($sucessArray);
                    echo "</pre>";
                   }      
				return $sucessArray;
			} 
			else 
			{ //Normal approval * Code Added By Puneet for Auto BL Approval *
   
                            if($offerID==''){
                                $emp_id = Yii::app()->session['empid'];
                               die;
                                 }
				$paramsPg = $param;
				$sqlCheck = "SELECT 1 FLAG, ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG, ETO_OFR_ONLINE_VERIFIED FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID = :OFFERID
                                            UNION ALL 
                                            SELECT CASE WHEN DIR_QUERY_FREE_BL_TYP = 1 THEN 2 ELSE 3 END FLAG, ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG, DIR_QUERY_ENRICHED_STATUS FROM DIR_QUERY_FREE WHERE ETO_OFR_DISPLAY_ID = :OFFERID
					";
							
				$sthCheck = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pgr, $sqlCheck, array(':OFFERID' => $offerID));
				$recCheck1 = $sthCheck->read();
                                if($recCheck1){
                                    $recCheck=array_change_key_case($recCheck1, CASE_UPPER);
                                }
                               
				$tableStatus = isset($recCheck['FLAG'])?$recCheck['FLAG']:'';
				$userIdentFlag= isset($recCheck['USER_IDENTIFIER_FLAG'])?$recCheck['USER_IDENTIFIER_FLAG']:'';
				$online_verified= isset($recCheck['ETO_OFR_ONLINE_VERIFIED'])?$recCheck['ETO_OFR_ONLINE_VERIFIED']:'';			
				if($tableStatus == 1) 
				{
					$sqlApprov = "UPDATE ETO_OFR SET ";
					if($param['cat'] == '' || $param['cat'] == -1) {
						return array("status"=>"FAIL","msg" => 'Record Could Not Be Updated Due to Invalid Category');
					} 
					else
					{
						foreach ($fieldName as $fKey => $fRow)
						{ 
                         
							if(isset($param[$fKey]))
							{
								if($fKey == 'title' || $fKey == 'qty_list_val'){
									$param[$fKey] = preg_replace("/\'/","''",$param[$fKey]);
									$param[$fKey] = preg_replace("/&nbsp;/"," ",$param[$fKey]);
								}
								if($fKey == 'desc'){

                                    if ($emp_id== 86777){
                                        $param[$fKey] =pg_escape_string($param[$fKey]);
                                }
                                else{
                                    $param[$fKey] = preg_replace("/&nbsp;/"," ",$param[$fKey]);
                                }
								}
								if($fKey == 'approv_date'){
                               
									$fieldArr = $fRow." = SYSDATE";			
								} else if($fKey == 'qty_list_val' && $param[$fKey] == "Others"){
                            
									$qty_other = preg_replace("/\'/","''",$param['ETO_OFR_QTY_UNIT_OTHER']);
									$fieldArr = $fRow." = '".$qty_other."'";
								}
								else{
                                 
									$fieldArr = $fRow." = '".$param[$fKey]."'";
								}					
								array_push($updateFieldsArr,$fieldArr);				
							}
						}
				          

						$updateFieldsArr = implode(',', $updateFieldsArr);
                        
						$sqlApprov .= $updateFieldsArr. " WHERE ETO_OFR_DISPLAY_ID = :OFFERID";
						// PG Block Starts Here
                        if ($emp_id== 86777){
                            echo "at 927";
                            echo "before try ";
                            echo "<pre>";
                            print_r($updateFieldsArr);
                            print_r($sqlApprov);
                            echo "</pre>";
                           }      
						try{
							$sqlApprov = "UPDATE ETO_OFR SET ";
							$updateFieldsArr=array();
							foreach ($fieldName as $fKey => $fRow)
							{
								if(isset($paramsPg[$fKey]))
								{
									if($fKey == 'title' || $fKey == 'qty_list_val'){
										$paramsPg[$fKey] = preg_replace("/\'/","''",$paramsPg[$fKey]);
										$paramsPg[$fKey] = preg_replace("/&nbsp;/"," ",$paramsPg[$fKey]);
									}
									if($fKey == 'desc'){
                                        if ($emp_id== 86777){
                                            $paramsPg[$fKey] =pg_escape_string($paramsPg[$fKey]);
                                        }

                                        else{
										$paramsPg[$fKey] = preg_replace("/&nbsp;/"," ",$paramsPg[$fKey]);
                                        }
									}
									if($fKey == 'approv_date'){
										$fieldArr = $fRow." = now()";			
									} else if($fKey == 'qty_list_val' && $paramsPg[$fKey] == "Others"){
										$qty_other = preg_replace("/\'/","''",$paramsPg['ETO_OFR_QTY_UNIT_OTHER']);
										$fieldArr = $fRow." = '".$qty_other."'";
									}
									else{
										$value = $paramsPg[$fKey];
										if($value == ''){
											$fieldArr = $fRow." = NULL";
										}
										else{
											$fieldArr = $fRow." = '".$value."'";
										}
									}					
									array_push($updateFieldsArr,$fieldArr);				
								}
							}
							$updateFieldsArr = implode(',', $updateFieldsArr);
							$sqlApprov .= $updateFieldsArr. " WHERE ETO_OFR_DISPLAY_ID = $1";
							$params=array($offerID);
                            if ($emp_id== 86777){
                                echo "at 981 ";
                            echo "after try ";
                            echo "<pre>";
                            print_r($updateFieldsArr);
                            print_r($sqlApprov);
                            echo "</pre>";
                           }     
							$sthApprov = pg_query_params($dbhW, $sqlApprov,$params);
                            if ($emp_id== 86777){
                                echo "at 990";
                                echo "<pre>";
                                print_r($params);
                                print_r($sthApprov);
                                echo "</pre>";
                               }           
                            if(!($sthApprov)){
                                $e = pg_last_error($dbhW);
                                if ($emp_id== 86777){
                                    echo "at 999";
                                    echo "<pre>";
                                    print_r($e);
                                    echo "</pre>";
                                   }           
                                mail("arora.akshita@indiamart.com","PG-Error update Offer function..at fail", 'Query===='.$sqlApprov.'===== offerID=='.$offerID.'====At line no - 1004===');	
                            }else{
                                mail("arora.akshita@indiamart.com","PG-Error update Offer function..at success", 'Query===='.$sqlApprov.'===== offerID=='.$offerID.'====At line no - 1006===');	
                              $sucessArray = array("status"=>"SUCCESS","msg" => "This Offer has been successfully Updated");
                              $this->syncEtoOfrVerifiedFlg('' ,'',$offerID,$model, 1);
                            }	
						}catch(Exception $e){
                            if ($emp_id== 86777){
                                echo "at 1012";
                                echo "<pre>";
                                print_r($e);
                                echo "</pre>";
                               }           
							mail("gladmin-team@indiamart.com","PG-Error update Offer function", 'Query===='.$sqlApprov.'===== offerID=='.$offerID.'====At line no - 1017');	
						}
                        if ($emp_id== 86777){
                            echo "at 1020";
                            echo "<pre>";
                            print_r($sucessArray);
                            echo "</pre>";
                           }      
						return $sucessArray;
					}
				} 
			}
		}
    }
	public function syncEtoOfrVerifiedFlg($dbhOciImbl ,$dbhOciImblAlert, $ofrID , $model,$pgWrite=0) 
	{
                $obj = new Globalconnection();
                $emp_id = Yii::app()->session['empid'];
		$dbhW = $obj->connectPostgres_wrt();
                $model = new GlobalmodelForm();
                 if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                    {
                        $dbh_pg = $obj->connect_db_yii('postgress_web77v');   
                    }else{
                        $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
                    }
		
		$success = array();
		if(empty($ofrID)){
			exit;	
		}

		$sql_verify = " 
		SELECT
                    GREATEST(COALESCE(ETO_OFR_ONLINE_VERIFIED,0),COALESCE(ETO_OFR_CALL_VERIFIED,0),COALESCE(ETO_OFR_EMAIL_VERIFIED,0)) VERIFY_FLG,
                    ETO_OFR_ONLINE_VERIFIED,
                    ETO_OFR_CALL_VERIFIED,
                    ETO_OFR_EMAIL_VERIFIED,
                    ETO_ENQ_TYP,
                    USER_IDENTIFIER_FLAG,
                    ETO_OFR_VERIFIED,
                    FK_GL_COUNTRY_ISO,
                    FK_GLUSR_USR_ID,
                    TO_CHAR(ETO_OFR_DATE,'DD-MM-YYYY HH24:MI:SS') ETO_OFR_DATE,
                    ETO_OFR_CITY_ID,
                    ETO_OFR_TITLE,
                    ETO_OFR_DESC,
                    ETO_OFR_GLCAT_MCAT_NAME,
                    ETO_OFR_SMALL_IMAGE,
                    ETO_OFR_LARGE_IMAGE,
                    ETO_OFR_DOC_PATH,
                    FK_ETO_OFR_TYPE_ID,
                    ETO_OFR_ATTACHMENT_IS_EXIST,
                    FK_GLCAT_CAT_ID,
                    (Select gl_city_district_hq from gl_city where gl_city_id=ETO_OFR_CITY_ID) DISTRICT_ID
                    FROM ETO_OFR
                    WHERE ETO_OFR_DISPLAY_ID = :OFFERID";
                
                    $bind[':OFFERID']=$ofrID; 
                   
                    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_verify, $bind);//echo $sql;        
                    $rec_pg = $sth->read();
                    $rec=array_change_key_case($rec_pg, CASE_UPPER);                     
                    if ($emp_id== 86777){
                        echo "at 1081";
                        echo "<pre>";
                        print_r($rec);
                        echo "</pre>";
                       }      
                $verify_flg= isset($rec['VERIFY_FLG'])?$rec['VERIFY_FLG']:'';
                $online_flg= isset($rec['ETO_OFR_ONLINE_VERIFIED'])?$rec['ETO_OFR_ONLINE_VERIFIED']:'';
                $call_flg= isset($rec['ETO_OFR_CALL_VERIFIED'])?$rec['ETO_OFR_CALL_VERIFIED']:'';
		$email_flgg= isset($rec['ETO_OFR_EMAIL_VERIFIED'])?$rec['ETO_OFR_EMAIL_VERIFIED']:'';
                $verify_code = '';
                if($verify_flg == 1) {
                        $verify_code=1;
                }
                if($verify_flg == 2) {
                        if(!empty($email_flg) || !empty($call_flg))		{
                                $verify_code=2;
                        } else {
                                $verify_code=3;
                        }
                }
                if($verify_flg == 3) {
                        if($email_flg) {
                                $verify_code=2;
                        } else {
                                $verify_code=3;
                        }
                }
                $this->mapping_additional($ofrID,$rec,'','',$dbhW); 
                if($response_msg=='Success'){
                   $success = array("status"=>"SUCCESS","msg" => "Update Success");	 
                }
                
                if($verify_code) 
				{
                    if ($emp_id== 86777){
                        echo "at 1116";
                        echo "<pre>";
                        print_r($verify_code);
                        echo "</pre>";
                       }    
					try{
					// PG Block starts Here
							$sql_flg = "UPDATE ETO_OFR SET ETO_OFR_VERIFIED = $2,ETO_OFR_VERIFIED_ON=CURRENT_DATE where ETO_OFR_DISPLAY_ID=$1";
							$verify_codeValue = ($verify_code !='') ?  $verify_code : 'NULL';
							$params=array($ofrID,$verify_codeValue);
							$sth_flg = pg_query_params($dbhW, $sql_flg,$params);   
							if($sth_flg){			
								$success =  array("status"=>"SUCCESS","msg" => "Update Success");					
							} else{
								$success =  array("status"=>"FAIL","msg" => "PG- Record could not be update");
							} 
					}catch(Exception $e){						
					}
					// PG Block Ends Here			
                } else{
					$success =  array("status"=>"FAIL","msg" => "ORA- Record could not be update");	                
                } 
                if ($emp_id== 86777){
                    echo "at 1139";
                    echo "<pre>";
                    print_r($success);
                    echo "</pre>";
                   }           
	return $success;
	}

public function mapping_additional($ofrID,$rec,$imblcon,$conIMALRT,$con_pgre){
    $usr_ind_flg = isset($rec['USER_IDENTIFIER_FLAG']) ? $rec['USER_IDENTIFIER_FLAG'] : '';
    $ofr_verif = isset($rec['ETO_OFR_VERIFIED']) && !empty($rec['ETO_OFR_VERIFIED']) ? $rec['ETO_OFR_VERIFIED'] : '';
    $gl_cnt_iso = isset($rec['FK_GL_COUNTRY_ISO']) && !empty($rec['FK_GL_COUNTRY_ISO']) ? $rec['FK_GL_COUNTRY_ISO'] : '';
    $gl_usr_id = isset($rec['FK_GLUSR_USR_ID']) && !empty($rec['FK_GLUSR_USR_ID']) ? $rec['FK_GLUSR_USR_ID'] : '';
    $ofr_date = isset($rec['ETO_OFR_DATE']) && !empty($rec['ETO_OFR_DATE']) ? $rec['ETO_OFR_DATE'] : '';
    $district_id = isset($rec['DISTRICT_ID']) && !empty($rec['DISTRICT_ID']) ? $rec['DISTRICT_ID'] : '';
    
    $ofr_date_array=explode(" ",$ofr_date);
    $ofr_date_arr=explode("-",$ofr_date_array[0]);
    $ofr_date_soa=$ofr_date_arr[2].$ofr_date_arr[1].$ofr_date_arr[0];    
    $ofr_time_str=$ofr_date_soa.str_replace(":","",$ofr_date_array[1]) ;
    $response_msg='';
                        $ofr_city = isset($rec['ETO_OFR_CITY_ID']) && !empty($rec['ETO_OFR_CITY_ID']) ? $rec['ETO_OFR_CITY_ID'] : ''; 
                        $param['token']	='imobile1@15061981';
                        $param['modid']	='GLADMIN';
                        $param['FK_ETO_OFR_ID']=$ofrID;                        
                        $param['action']='Update';
                        $param['USER_IDENTIFIER_FLAG_MAPP']=$usr_ind_flg;
                        $param['ETO_OFR_VERIFIED_MAPP']=$ofr_verif;
                        $param['FK_GL_COUNTRY_ISO_MAPP']=$gl_cnt_iso;
                        $param['ETO_OFR_DATE_MAPP']=$ofr_time_str;
                        $param['ETO_OFR_CITY_ID_MAPP']=$ofr_city;
                        $param['FK_GLUSR_USR_ID_MAPP']=$gl_usr_id;
                        $param['FK_GL_DISTRICTS_ID']=$district_id;
                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                                $curl = 'http://dev-leads.imutils.com/wservce/leads/ofrmapping/';
                                }else{                        
                                $curl = 'http://leads.imutils.com/wservce/leads/ofrmapping/';
                                }
                        $serv_model =new ServiceGlobalModelForm();
                        $response=$serv_model->mapiService('OFRMAPPING',$curl,$param,'Yes');
                        
                        if($response['Response']['Code']==200){
                             $response_msg="Success";
                        }else{
                            $input = json_encode($param);
                            $output = json_encode($response);
                            $response_msg="Some Error occured";
                        }
    return $response_msg;
}       


public function manualMcat($empId,$model){    	
    	$obj = new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        $request = Yii::app()->request;
    	$ss = $request->getParam('item_name');
    	$search_string = $request->getParam('escaped_item_name');
    	$rec_prd;
    	$rec_prd_more;
    	$rec_comp;
    	$rec_city;
    	$rec_grp;
    	$rec_subcat;
    	$rec_mcat;
    	$totalRecsSearched;
    	$debug_msg;
    	$mcat;
    	$result = array();        
        $ss = strtoupper($ss);
        $ss = trim($ss);
	if($dbh)
	{
		$dataArr = array();
		$counter = 0;
		$count = 0;
		$table = '';
		$tr = '';		
		$sql2 = "SELECT GLCAT_MCAT_NAME,GLCAT_MCAT_ID FROM GLCAT_MCAT WHERE UPPER(GLCAT_MCAT_NAME) = :item_ss AND GLCAT_MCAT_DELETE_STATUS <> 1 ";
		$sth2 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql2, array(":item_ss" => $ss));
			while($mcat_name_id = $sth2->read()) {
                               $mcat_name_id=array_change_key_case($mcat_name_id, CASE_UPPER);   
				array_push($dataArr,$mcat_name_id['GLCAT_MCAT_ID']);
			}
		
		$sql1 = "SELECT GLCAT_MCAT_NAME,GLCAT_MCAT_ID FROM GLCAT_MCAT WHERE UPPER(GLCAT_MCAT_NAME) LIKE '%' ||:item_ss || '%' AND GLCAT_MCAT_DELETE_STATUS <> 1 ORDER BY GLCAT_MCAT_NAME";
		$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, array(":item_ss" => $ss));
				while($mcat_name_id = $sth1->read()) {
                                       $mcat_name_id=array_change_key_case($mcat_name_id, CASE_UPPER);  
					if(!in_array($mcat_name_id['GLCAT_MCAT_ID'],$dataArr)){
					array_push($dataArr,$mcat_name_id['GLCAT_MCAT_ID']);			
				}
			}
		
		$rec_mcat2='';
		$dataHash='';
		$search_string = trim($search_string);
		
		$rel_url = "/tools/related_info?q=".$search_string."&source=gladmin.offer.mapping";
		$service_model = new ServiceGlobalModelForm();
        $dataHash = $service_model->searchApiService($rel_url, '', 'MCAT_SEARCH');
                
		if(!empty($dataHash))
		{
			$rec_mcat2 = $dataHash['guess']['mcats'];
		}
		
		$mcat = $rec_mcat2;
		$mcat_len = count($mcat);
		
		for($i=0; $i<$mcat_len; $i=$i+2)
		{
			$mcat_id = $mcat[$i];
			 
			if(!in_array($mcat_id,$dataArr)){
				array_push($dataArr,$mcat_id);			
			}
		}

		foreach ($dataArr as $k=>$dataRow)
		{
		
			if(isset($dataRow) && $dataRow > 0)
			
			{				
				
				$mcatid = $dataRow;
				$sql = "SELECT GLCAT_GRP_ID AS GRP_ID, GLCAT_GRP_NAME AS GRP_NAME,GLCAT_CAT_ID AS CAT_ID,
                                    GLCAT_CAT.GLCAT_CAT_NAME CAT_NAME,
                            GLCAT_MCAT_NAME AS MCAT_NAME, GLCAT_MCAT_ID AS MCAT_ID, GLCAT_MCAT_ADULT_FLAG, 3 AS FLAG FROM GLCAT_GRP,GLCAT_GRP_TO_CAT,GLCAT_CAT, GLCAT_MCAT, GLCAT_CAT_TO_MCAT, GLCAT_MCAT_ALLCOUNT
                            WHERE GLCAT_GRP_TO_CAT.FK_GLCAT_CAT_ID=GLCAT_CAT.GLCAT_CAT_ID AND GLCAT_GRP_TO_CAT.FK_GLCAT_GRP_ID = GLCAT_GRP.GLCAT_GRP_ID
                            AND GLCAT_CAT_TO_MCAT.FK_GLCAT_MCAT_ID = GLCAT_MCAT_ID AND GLCAT_MCAT_ALLCOUNT.FK_GLCAT_MCAT_ID = GLCAT_MCAT_ID
                            AND GLCAT_CAT_TO_MCAT.FK_GLCAT_CAT_ID = GLCAT_CAT.GLCAT_CAT_ID AND GLCAT_CAT_TO_MCAT.ISPRIME = -1
                            AND GLCAT_GRP_TO_CAT.ISPRIMEGRP = -1 AND PRD_MCAT_ISGENERATED = 1 AND GLCAT_MCAT.GLCAT_MCAT_DELETE_STATUS <> 1
                            AND GLCAT_MCAT_ID=:MCAT_ID";
				$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":MCAT_ID" => $mcatid));
				$currHa = $sth->read();
				
				if($currHa){
                                        $currHa=array_change_key_case($currHa, CASE_UPPER);  
					$ha[] = $currHa;			
					$mcatAdultFlag = isset($ha['GLCAT_MCAT_ADULT_FLAG'])?$ha['GLCAT_MCAT_ADULT_FLAG']: '';
					$result = array(
										'ha' => $ha,
										'mcat' => $mcat
									//'mcatAdultFlag' => $mcatAdultFlag
								);
				}
			}
			$counter++;
			$count++;
			 if($count == 10)
			{
				break;
			} 
				
		}
                $ss = strtolower($ss);
		if(empty($result)){
					$dataMsg = json_encode($dataArr);
					$dataHashMsg = json_encode($dataHash);
					$search_stringMsg = $search_string;
					$ssMsg = $ss;
		}
		
		return $result;
	}
	}
	
	public function getManualMcatList($model)
	{
		
		$obj = new Globalconnection();
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
		$request = Yii::app()->request;
		
		$catId = $request->getParam("catid",0);
		$memId = $request->getParam("memid",0);
		$mcatId = $request->getParam("mcatid",0);
		$buyerID = $request->getParam("buyerID",0);
		$primeMcat = $request->getParam("primeMcat",0);
		$checkMcatID = $request->getParam("id",0);
		
		if(!empty($mcatId))
		{
			$sql="SELECT COUNT(1) CNT FROM GLCAT_MCAT WHERE GLCAT_MCAT_IS_GENERIC = 1 AND GLCAT_MCAT_ID = :MCATID";
			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":MCATID" => $mcatId));
			$rec = $sth->read();			
			if($rec['cnt'] > 0)	#Generic Mcat
			{
                            $sql1="SELECT COUNT(1) CNT FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' AND FK_GLCAT_MCAT_ID = :MCATID AND FK_GLUSR_USR_ID = :USR_ID";
                            $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, array(":MCATID" => $mcatId,":USR_ID" => $buyerID));
                            $rec1 = $sth1->read();
				if($rec1['cnt'] > 0)
				{
					echo '7';
				} else
				{
					echo '1';
				}
			} else{ 
                            $sql1="SELECT COUNT(1) CNT FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' AND FK_GLCAT_MCAT_ID = :MCATID AND FK_GLUSR_USR_ID = :USR_ID";
                            $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, array(":MCATID" => $mcatId,":USR_ID" => $buyerID));
                            $rec1 = $sth1->read();
                            if($rec1['cnt'] > 0) { 
				echo '6';
                            }  else
                            {
                                   echo '0';
                            }
                        }
	} else if(!empty($primeMcat))
	{
		$primeMcat0 = $request->getParam("primeMcat0",0);
		$primeMcat1 = $request->getParam("primeMcat1",0);
		$sql="SELECT COUNT(1) CNT FROM GLCAT_MCAT WHERE GLCAT_MCAT_IS_GENERIC = 1";

		if(!empty($primeMcat1) && $primeMcat1 > 0)
		{
			$sql .=" AND GLCAT_MCAT_ID IN (".$primeMcat0.", ".$primeMcat1.")";
		}
		else
		{
			$sql .=" AND GLCAT_MCAT_ID = ".$primeMcat0;			
		}		
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		$rec = $sth->read();
		$sql1="SELECT COUNT(1) CNT FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' AND FK_GLCAT_MCAT_ID = :MCATID AND FK_GLUSR_USR_ID = :USR_ID";
		
		$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, array(":MCATID" => $checkMcatID,":USR_ID" => $buyerID));
		$rec1 = $sth1->read();
		if($rec['cnt'] == 2 && $rec1['cnt'] > 0)
		{
			echo '8';
		}
		elseif($rec['cnt'] == 2)
		{			
			echo '2';
		}
		elseif($rec['cnt'] == 1 && $rec1['cnt'] > 0)
		{
			echo '7';
		}
		elseif($rec['cnt'] == 1)		
		{		
			echo '1';
		}
		elseif($rec1['cnt'] > 0)		
		{		
			echo '6';
		}
		else
		{		
			echo '0';		
		}
	}
}


	public function showOfferDelReasons($model,$request) {
		$result =''; 
		$fromAnchor = $request->getParam('fromanchor',0) ;
		$redirectURL = $request->getParam('url','') ;
		
		$result_value=CommonVariable::get_delete_reasons();
		$serial=CommonVariable::get_serial();
        if(!empty($result_value)){
		foreach($result_value as $key=>$value)
		  {
            if (array_key_exists($key,$serial)){
			$result['reject_reason_all'][$serial[$key]]["value"] = $key;
			$result['reject_reason_all'][$serial[$key]]['text'] = $value;
            }
		}
        }
		return array(
			"result"=> $result,
			"redirectURL" => $redirectURL,
			"fromAnchor" => $fromAnchor 
		);
	}
	
	public function delRec($model,$request,$emp_id,$offerID)
	{
		$histcomments = '';
                $obj = new Globalconnection();
		$dbhW = $obj->connectPostgres_wrt();
		$dbhpg = $obj->connect_db_yii('postgress_web68v');  
                
		$offerID= empty($offerID)?$request->getParam("offer",0):$offerID;
		$status= $request->getParam("status",'');
                $emp_name = Yii::app()->session['empname'];
		$delmail= $request->getParam("delmail",'');	
		//######## offer Status ##########
  		$sql = "SELECT ETO_OFR_APPROV FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID = :offer";  
                $bind[':offer']=$offerID; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbhpg, $sql, $bind);//echo $sql;        
                $rec = $sth->read();
                $rec=array_change_key_case($rec, CASE_UPPER);
		$status = $rec['ETO_OFR_APPROV'];                
		$status = (!empty($status))?$status:'W';
	  	$mesg='';
		
		if ($offerID !=0) 
		{	
	    	$Flagval=$request->getParam('flagval','');
			if(!empty($Flagval))
			{	
					// PG block starts Here
					$sql_update = "update ETO_OFR SET ETO_OFR_IS_FLAGGED = $1 WHERE ETO_OFR_DISPLAY_ID=$2";
					$Flagvalue = ($Flagval !='') ?  $Flagval : 'NULL';
					$params=array($Flagvalue,$offerID);
					$sth_update = pg_query($dbhW,$sql_update); 
                                        if(!$sth_update){
                                            pg_query($dbhW,"ROLLBACK;");                                                                
                                            $e = pg_last_error($dbhW);
                                            pg_query($dbhW, "END;");
                                        }else{
                                            pg_query($dbhW,"END;");                                                                
                                        } 
					// PG block Ends Here
			} 
			else 
			{
				$reasonCode = $request->getParam('reason',0);	
				if(!empty($reasonCode)) {
                                    $result_value=CommonVariable::get_delete_reasons();
                                    foreach($result_value as $key=>$value)
                                      {
                                        if($reasonCode==$key){                                           
                                           $histcomments = $value;
                                        }
                                    }                                    
				}
		    	if($status == 'W')
		    	{
                                         if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                                            {
                                                $dbh_pgr = $obj->connect_db_yii('postgress_web68v');   
                                            }else{
                                                $dbh_pgr = $obj->connect_db_yii('postgress_web68v'); 
                                            }
                                        $glmodel = new GlobalmodelForm();
					$sqlTableCheck = "
					SELECT 1 FLAG, FK_GLUSR_USR_ID,QUERY_MODID MOD_ID,NULL OFR_DATE FROM DIR_QUERY_FREE WHERE ETO_OFR_DISPLAY_ID = :OFFERID
					UNION ALL 
					SELECT 2 FLAG, FK_GLUSR_USR_ID,FK_GL_MODULE_ID MOD_ID,TO_CHAR(ETO_OFR_DATE,'DD-MM-YYYY') OFR_DATE FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID = :OFFERID ";
					$sthCheck = $glmodel->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pgr, $sqlTableCheck, array(':OFFERID' => $offerID));
                                        $recCheck1 = $sthCheck->read();
                                        if($recCheck1){
                                        $recTableCheck=array_change_key_case($recCheck1, CASE_UPPER);
                                        }
                                        $blmodid=isset($recTableCheck['MOD_ID'])?$recTableCheck['MOD_ID']:''; 
                                        $bldate=isset($recTableCheck['OFR_DATE'])?$recTableCheck['OFR_DATE']:'';
                                        $cudate= date("d-m-Y");
                                       
                                         if(($blmodid=='FENQ') && ($bldate==$cudate)){      
                                                            // PG Block Starts Here
                                                            pg_query($dbhW,"SET statement_timeout = 2000;");
                                                            pg_query($dbhW,'BEGIN');
                                                            $sql_fenq1 = "UPDATE ETO_OFR_FROM_FENQ SET FK_ETO_OFR_ID = NULL,FENQ_DEL_REASON=$2 WHERE DIR_QUERY_FREE_REFID =$1";
                                                            $params1 = array($offerID,$reasonCode);	
                                                            
                                                            $sql_fenq2 = "DELETE FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID =$1";
                                                            $params2 = array($offerID);	
                                                            
                                                            $sthCheck1 = pg_query_params($dbhW,$sql_fenq1, $params1);
                                                            $sthCheck2 = pg_query_params($dbhW,$sql_fenq2, $params2);	
                                                            
                                                            if(!($sthCheck1 && $sthCheck2)){
                                                                pg_query($dbhW,"ROLLBACK;");                                                                
                                                                $e = pg_last_error($dbhW);
                                                                pg_query($dbhW, "END;");
                                                            }else{
                                                                pg_query($dbhW,"END;");                                                                
                                                            } 
                                                            // PG Block Ends Here                                                            
                                                     
                                        }else{
                                            $enqTyp = $recTableCheck['FLAG'];
                                            $usrID = $recTableCheck['FK_GLUSR_USR_ID'];
                                            $histcomments = empty($histcomments)?"Offer Rejected":$histcomments;		    
                                            $histip = '';			
                                            $histipcountry = '';			
                                            $histref = '';			
                                            $histmodid = '';			
                                            $histusrid = '';			
                                            $histusing = 'Gladmin';			
                                            $deletedByEmpId=$histempid = $emp_id;
                                            $ofrDelFlag = '';
                                            $lockID='';$call_del_url='';$deletedAgainst = '';
                                            if($enqTyp == 1)
                                            {   
                                                        $sqlPg = "
                                                        SELECT DIR_QUERY_FREE_BL_TYP STATUS,ETO_OFR_ID, DIR_QUERY_PROD_SERV, DIR_QUERY_CATID , TO_CHAR(ETO_OFR_DATE,'DD-MM-YYYY HH24:MI:SS')ETO_OFR_DATE,
                                                        TO_CHAR(ETO_OFR_EXP_DATE,'DD-MM-YYYY HH24:MI:SS')ETO_OFR_EXP_DATE, MESSAGE, DIR_QUERY_FREE_QTY, FK_GLUSR_USR_ID,SENDEREMAIL,
                                                        FK_EMPLOYEEID, DIR_QUERY_MCATID, TO_CHAR(DATE_R,'DD-MM-YYYY HH24:MI:SS')DATE_R, ACTION_BY_EMP_ID,S_COUNTRY_RATING, QUERY_MODID, QUERY_REFERENCE_URL, 
                                                        DIR_QUERY_S_IP, S_IP_COUNTRY, SENDERNAME, S_ORGANIZATION, S_DESIGNATION, S_STREETADDRESS, S_CITY, S_STATE, S_ZIP,S_COUNTRY, DIR_QUERY_S_PH_COUNTRY, 
                                                        DIR_QUERY_S_PH_AREA, S_PHONE, S_MOBILE, DIR_QUERY_S_URL, FK_GL_COUNTRY_ISO, ETO_OFR_GL_COUNTRY_NAME, ETO_OFR_GL_COUNTRY_FLAG, ETO_OFR_DISPLAY_ID,
                                                        ETO_OFR_GLCAT_CAT_NAME, ETO_OFR_GLCAT_MCAT_NAME, TO_CHAR(QUERY_LOCK_DATE,'DD-MM-YYYY HH24:MI:SS')QUERY_LOCK_DATE, FK_ETO_AFL_ID, FK_ETO_AFL_WEBSITE_ID,
                                                        DIR_QUERY_REQ_FREQUENCY, DIR_QUERY_REQ_PURPOSE, DIR_QUERY_REQ_GEOGRAPHY_ID, DIR_QUERY_REQ_APP_USAGE,DIR_QUERY_REQ_APRX_ORDER_VALUE, DIR_QUERY_REQ_GEO_CITY1_ID, 
                                                        DIR_QUERY_REQ_GEO_CITY2_ID, DIR_QUERY_REQ_GEO_CITY3_ID, DIR_QUERY_REQ_DESTINATION_PORT, DIR_QUERY_REQ_PAYMENT_MODE, DIR_QUERY_REQ_SHIPMENT_MODE,
                                                        DIR_QUERY_ENRICHED_STATUS,DIR_QUERY_OTHER_DETAIL, DIR_QUERY_SMALL_IMAGE, DIR_QUERY_MEDIUM_IMAGE, DIR_QUERY_LARGE_IMAGE, DIR_QUERY_ORIGINAL_IMAGE, 
                                                        DIR_QUERY_SMALL_IMAGE_WH , DIR_QUERY_MEDIUM_IMAGE_WH, DIR_QUERY_LARGE_IMAGE_WH, DIR_QUERY_ORIGINAL_IMAGE_WH,DIR_QUERY_DOC_PATH, USER_IDENTIFIER_FLAG, 
                                                        ETO_OFR_IS_FLAGGED, DIR_QUERY_FREE_PROCESSED,DIR_QUERY_QTY_UNIT, DIR_QUERY_FREE_LATITUDE, DIR_QUERY_FREE_LONGITUDE,FK_ETO_OFR_TYPE_ID,DIR_QUERY_LOGIN_MODE,
                                                        ETO_OFR_ATTACHMENT_IS_EXIST,ETO_OFR_DISPLAY_TYPE, RAG_SCORE_TOTAL,QUERY_ID,SUBJECT,ENQUIRY_SMS_ID,FK_TRAFFIC_SOURCE_ID,S_COUNTRY_UPPER,QUERY_REF_CURRENT_URL 
                                                        FROM DIR_QUERY_FREE WHERE ETO_OFR_DISPLAY_ID =:OFFERID";

                                                        $sth = $glmodel->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pgr, $sqlPg, array(':OFFERID' => $offerID));
                                                        $row = $sth->read();                                                        
                                                                $rec = array_change_key_case($row,CASE_UPPER); 
                                                                $STATUS = isset($rec['STATUS']) ? $rec['STATUS'] : '';
                                                                $ETO_OFR_ID = isset($rec['ETO_OFR_ID']) ? $rec['ETO_OFR_ID'] : '';
                                                                $DIR_QUERY_PROD_SERV = isset($rec['DIR_QUERY_PROD_SERV']) ? $rec['DIR_QUERY_PROD_SERV'] : '';
                                                                $DIR_QUERY_CATID = isset($rec['DIR_QUERY_CATID']) ? $rec['DIR_QUERY_CATID'] : '';
                                                                $ETO_OFR_DATE = isset($rec['ETO_OFR_DATE']) ? $rec['ETO_OFR_DATE'] : '';
                                                                $ETO_OFR_EXP_DATE = isset($rec['ETO_OFR_EXP_DATE']) ? $rec['ETO_OFR_EXP_DATE'] : '';
                                                                $MESSAGE = isset($rec['MESSAGE']) ? $rec['MESSAGE'] : '';
                                                                $DIR_QUERY_FREE_QTY = isset($rec['DIR_QUERY_FREE_QTY']) ? $rec['DIR_QUERY_FREE_QTY'] : '';
                                                                $FK_GLUSR_USR_ID = isset($rec['FK_GLUSR_USR_ID']) ? $rec['FK_GLUSR_USR_ID'] : '';
                                                                $SENDEREMAIL = isset($rec['SENDEREMAIL']) ? $rec['SENDEREMAIL'] : '';
                                                                $FK_EMPLOYEEID = isset($rec['FK_EMPLOYEEID']) ? $rec['FK_EMPLOYEEID'] : '';
                                                                $DIR_QUERY_MCATID = isset($rec['DIR_QUERY_MCATID']) ? $rec['DIR_QUERY_MCATID'] : '';
                                                                $DATE_R = isset($rec['DATE_R']) ? $rec['DATE_R'] : '';
                                                                $ACTION_BY_EMP_ID = isset($rec['ACTION_BY_EMP_ID']) ? $rec['ACTION_BY_EMP_ID'] : '';
                                                                $S_COUNTRY_RATING = isset($rec['S_COUNTRY_RATING']) ? $rec['S_COUNTRY_RATING'] : '';
                                                                $QUERY_MODID = isset($rec['QUERY_MODID']) ? $rec['QUERY_MODID'] : '';
                                                                $QUERY_REFERENCE_URL = isset($rec['QUERY_REFERENCE_URL']) ? $rec['QUERY_REFERENCE_URL'] : '';
                                                                $DIR_QUERY_S_IP = isset($rec['DIR_QUERY_S_IP']) ? $rec['DIR_QUERY_S_IP'] : '';
                                                                $S_IP_COUNTRY = isset($rec['S_IP_COUNTRY']) ? $rec['S_IP_COUNTRY'] : '';
                                                                $SENDERNAME = isset($rec['SENDERNAME']) ? $rec['SENDERNAME'] : '';
                                                                $S_ORGANIZATION = isset($rec['S_ORGANIZATION']) ? $rec['S_ORGANIZATION'] : '';
                                                                $S_DESIGNATION = isset($rec['S_DESIGNATION']) ? $rec['S_DESIGNATION'] : '';
                                                                $S_STREETADDRESS = isset($rec['S_STREETADDRESS']) ? $rec['S_STREETADDRESS'] : '';
                                                                $S_CITY = isset($rec['S_CITY']) ? $rec['S_CITY'] : '';
                                                                $S_STATE = isset($rec['S_STATE']) ? $rec['S_STATE'] : '';
                                                                $S_ZIP = isset($rec['S_ZIP']) ? $rec['S_ZIP'] : '';
                                                                $S_COUNTRY = isset($rec['S_COUNTRY']) ? $rec['S_COUNTRY'] : '';
                                                                $DIR_QUERY_S_PH_COUNTRY = isset($rec['DIR_QUERY_S_PH_COUNTRY']) ? $rec['DIR_QUERY_S_PH_COUNTRY'] : '';
                                                                $DIR_QUERY_S_PH_AREA = isset($rec['DIR_QUERY_S_PH_AREA']) ? $rec['DIR_QUERY_S_PH_AREA'] : '';
                                                                $S_PHONE = isset($rec['S_PHONE']) ? $rec['S_PHONE'] : '';
                                                                $S_MOBILE = isset($rec['S_MOBILE']) ? $rec['S_MOBILE'] : '';
                                                                $DIR_QUERY_S_URL = isset($rec['DIR_QUERY_S_URL']) ? $rec['DIR_QUERY_S_URL'] : '';
                                                                $FK_GL_COUNTRY_ISO = isset($rec['FK_GL_COUNTRY_ISO']) ? $rec['FK_GL_COUNTRY_ISO'] : '';
                                                                $ETO_OFR_GL_COUNTRY_NAME = isset($rec['ETO_OFR_GL_COUNTRY_NAME']) ? $rec['ETO_OFR_GL_COUNTRY_NAME'] : '';
                                                                $ETO_OFR_GL_COUNTRY_FLAG = isset($rec['ETO_OFR_GL_COUNTRY_FLAG']) ? $rec['ETO_OFR_GL_COUNTRY_FLAG'] : '';
                                                                $ETO_OFR_DISPLAY_ID = isset($rec['ETO_OFR_DISPLAY_ID']) ? $rec['ETO_OFR_DISPLAY_ID'] : '';
                                                                $ETO_OFR_GLCAT_CAT_NAME = isset($rec['ETO_OFR_GLCAT_CAT_NAME']) ? $rec['ETO_OFR_GLCAT_CAT_NAME'] : '';
                                                                $ETO_OFR_GLCAT_MCAT_NAME = isset($rec['ETO_OFR_GLCAT_MCAT_NAME']) ? $rec['ETO_OFR_GLCAT_MCAT_NAME'] : '';
                                                                $QUERY_LOCK_DATE = isset($rec['QUERY_LOCK_DATE']) ? $rec['QUERY_LOCK_DATE'] : '';
                                                                $FK_ETO_AFL_ID = isset($rec['FK_ETO_AFL_ID']) ? $rec['FK_ETO_AFL_ID'] : '';
                                                                $FK_ETO_AFL_WEBSITE_ID = isset($rec['FK_ETO_AFL_WEBSITE_ID']) ? $rec['FK_ETO_AFL_WEBSITE_ID'] : '';
                                                                $DIR_QUERY_REQ_FREQUENCY = isset($rec['DIR_QUERY_REQ_FREQUENCY']) ? $rec['DIR_QUERY_REQ_FREQUENCY'] : '';
                                                                $DIR_QUERY_REQ_PURPOSE = isset($rec['DIR_QUERY_REQ_PURPOSE']) ? $rec['DIR_QUERY_REQ_PURPOSE'] : '';
                                                                $DIR_QUERY_REQ_GEOGRAPHY_ID = isset($rec['DIR_QUERY_REQ_GEOGRAPHY_ID']) ? $rec['DIR_QUERY_REQ_GEOGRAPHY_ID'] : '';
                                                                $DIR_QUERY_REQ_APP_USAGE = isset($rec['DIR_QUERY_REQ_APP_USAGE']) ? $rec['DIR_QUERY_REQ_APP_USAGE'] : '';
                                                                $DIR_QUERY_REQ_APRX_ORDER_VALUE = isset($rec['DIR_QUERY_REQ_APRX_ORDER_VALUE']) ? $rec['DIR_QUERY_REQ_APRX_ORDER_VALUE'] : '';
                                                                $DIR_QUERY_REQ_GEO_CITY1_ID = isset($rec['DIR_QUERY_REQ_GEO_CITY1_ID']) ? $rec['DIR_QUERY_REQ_GEO_CITY1_ID'] : '';
                                                                $DIR_QUERY_REQ_GEO_CITY2_ID = isset($rec['DIR_QUERY_REQ_GEO_CITY2_ID']) ? $rec['DIR_QUERY_REQ_GEO_CITY2_ID'] : '';
                                                                $DIR_QUERY_REQ_GEO_CITY3_ID = isset($rec['DIR_QUERY_REQ_GEO_CITY3_ID']) ? $rec['DIR_QUERY_REQ_GEO_CITY3_ID'] : '';
                                                                $DIR_QUERY_REQ_DESTINATION_PORT = isset($rec['DIR_QUERY_REQ_DESTINATION_PORT']) ? $rec['DIR_QUERY_REQ_DESTINATION_PORT'] : '';
                                                                $DIR_QUERY_REQ_PAYMENT_MODE = isset($rec['DIR_QUERY_REQ_PAYMENT_MODE']) ? $rec['DIR_QUERY_REQ_PAYMENT_MODE'] : '';
                                                                $DIR_QUERY_REQ_SHIPMENT_MODE = isset($rec['DIR_QUERY_REQ_SHIPMENT_MODE']) ? $rec['DIR_QUERY_REQ_SHIPMENT_MODE'] : '';
                                                                $DIR_QUERY_ENRICHED_STATUS = isset($rec['DIR_QUERY_ENRICHED_STATUS']) ? $rec['DIR_QUERY_ENRICHED_STATUS'] : '';
                                                                $DIR_QUERY_OTHER_DETAIL = isset($rec['DIR_QUERY_OTHER_DETAIL']) ? $rec['DIR_QUERY_OTHER_DETAIL'] : '';
                                                                $DIR_QUERY_SMALL_IMAGE = isset($rec['DIR_QUERY_SMALL_IMAGE']) ? $rec['DIR_QUERY_SMALL_IMAGE'] : '';
                                                                $DIR_QUERY_MEDIUM_IMAGE = isset($rec['DIR_QUERY_MEDIUM_IMAGE']) ? $rec['DIR_QUERY_MEDIUM_IMAGE'] : '';
                                                                $DIR_QUERY_LARGE_IMAGE = isset($rec['DIR_QUERY_LARGE_IMAGE']) ? $rec['DIR_QUERY_LARGE_IMAGE'] : '';
                                                                $DIR_QUERY_ORIGINAL_IMAGE = isset($rec['DIR_QUERY_ORIGINAL_IMAGE']) ? $rec['DIR_QUERY_ORIGINAL_IMAGE'] : '';
                                                                $DIR_QUERY_SMALL_IMAGE_WH = isset($rec['DIR_QUERY_SMALL_IMAGE_WH']) ? $rec['DIR_QUERY_SMALL_IMAGE_WH'] : '';
                                                                $DIR_QUERY_MEDIUM_IMAGE_WH = isset($rec['DIR_QUERY_MEDIUM_IMAGE_WH']) ? $rec['DIR_QUERY_MEDIUM_IMAGE_WH'] : '';
                                                                $DIR_QUERY_LARGE_IMAGE_WH = isset($rec['DIR_QUERY_LARGE_IMAGE_WH']) ? $rec['DIR_QUERY_LARGE_IMAGE_WH'] : '';
                                                                $DIR_QUERY_ORIGINAL_IMAGE_WH = isset($rec['DIR_QUERY_ORIGINAL_IMAGE_WH']) ? $rec['DIR_QUERY_ORIGINAL_IMAGE_WH'] : '';
                                                                $DIR_QUERY_DOC_PATH = isset($rec['DIR_QUERY_DOC_PATH']) ? $rec['DIR_QUERY_DOC_PATH'] : '';
                                                                $USER_IDENTIFIER_FLAG = isset($rec['USER_IDENTIFIER_FLAG']) ? $rec['USER_IDENTIFIER_FLAG'] : '';
                                                                $ETO_OFR_IS_FLAGGED = isset($rec['ETO_OFR_IS_FLAGGED']) ? $rec['ETO_OFR_IS_FLAGGED'] : '';
                                                                $DIR_QUERY_FREE_PROCESSED = isset($rec['DIR_QUERY_FREE_PROCESSED']) ? $rec['DIR_QUERY_FREE_PROCESSED'] : '';
                                                                $DIR_QUERY_QTY_UNIT = isset($rec['DIR_QUERY_QTY_UNIT']) ? $rec['DIR_QUERY_QTY_UNIT'] : '';
                                                                $DIR_QUERY_FREE_LATITUDE = isset($rec['DIR_QUERY_FREE_LATITUDE']) ? $rec['DIR_QUERY_FREE_LATITUDE'] : '';
                                                                $DIR_QUERY_FREE_LONGITUDE = isset($rec['DIR_QUERY_FREE_LONGITUDE']) ? $rec['DIR_QUERY_FREE_LONGITUDE'] : '';
                                                                $FK_ETO_OFR_TYPE_ID = isset($rec['FK_ETO_OFR_TYPE_ID']) ? $rec['FK_ETO_OFR_TYPE_ID'] : '';
                                                                $DIR_QUERY_LOGIN_MODE = isset($rec['DIR_QUERY_LOGIN_MODE']) ? $rec['DIR_QUERY_LOGIN_MODE'] : '';
                                                                $ETO_OFR_ATTACHMENT_IS_EXIST = isset($rec['ETO_OFR_ATTACHMENT_IS_EXIST']) ? $rec['ETO_OFR_ATTACHMENT_IS_EXIST'] : '';
                                                                $ETO_OFR_DISPLAY_TYPE = isset($rec['ETO_OFR_DISPLAY_TYPE']) ? $rec['ETO_OFR_DISPLAY_TYPE'] : '';
                                                                $RAG_SCORE_TOTAL = isset($rec['RAG_SCORE_TOTAL']) ? $rec['RAG_SCORE_TOTAL'] : '';
                                                                $QUERY_ID = isset($rec['QUERY_ID']) ? $rec['QUERY_ID'] : '';
                                                                $SUBJECT = isset($rec['SUBJECT']) ? $rec['SUBJECT'] : '';
                                                                $ENQUIRY_SMS_ID = isset($rec['ENQUIRY_SMS_ID']) ? $rec['ENQUIRY_SMS_ID'] : '';
                                                                $FK_TRAFFIC_SOURCE_ID = isset($rec['FK_TRAFFIC_SOURCE_ID']) ? $rec['FK_TRAFFIC_SOURCE_ID'] : '';
                                                                $S_COUNTRY_UPPER = isset($rec['S_COUNTRY_UPPER']) ? $rec['S_COUNTRY_UPPER'] : '';
                                                                $QUERY_REF_CURRENT_URL = isset($rec['QUERY_REF_CURRENT_URL']) ? $rec['QUERY_REF_CURRENT_URL'] : '';		

                                                                if(strlen($SUBJECT) > 100){
                                                                        $SUBJECT = substr($SUBJECT, 0, 99);
                                                                }                                                                
                                                                pg_query($dbhW,"SET statement_timeout = 10000;");
                                                                pg_query($dbhW,"BEGIN");
                                                                $pgQuery1 = "INSERT INTO ETO_OFR_TEMP_DEL
                                                                (
                                                                FK_ETO_OFR_DEL_REASON_CODE, ETO_OFR_ID, ETO_OFR_TYP, ETO_OFR_PROD_SERV, FK_GLCAT_CAT_ID, ETO_OFR_TITLE, ETO_OFR_DATE, ETO_OFR_EXP_DATE, ETO_OFR_DESC, ETO_OFR_QTY, FK_GL_CONTINENT_ID, FK_GLUSR_USR_ID, ETO_OFR_HIT, ETO_OFR_RESPONSE, ETO_OFR_APPROV, FK_EMPLOYEE_ID, FK_GLCAT_MCAT_ID, ETO_OFR_POSTDATE_ORIG,
                                                                ETO_OFR_DELETIONDATE, ETO_OFR_DELBYADMINORUSER, ETO_OFR_DELETEDBYID, ETO_OFR_POSTEDBYEMPLOYEE, ETO_OFR_QUALITY, FK_GL_MODULE_ID, ETO_OFR_PAGE_REFERRER, ETO_OFR_S_IP, ETO_OFR_S_IP_COUNTRY, ETO_OFR_S_SENDERNAME, ETO_OFR_S_ORGANIZATION, ETO_OFR_S_DESIGNATION, ETO_OFR_S_STREETADDRESS, ETO_OFR_S_CITY, ETO_OFR_S_STATE, ETO_OFR_S_ZIP, ETO_OFR_S_COUNTRY, ETO_OFR_S_PH_COUNTRY, ETO_OFR_S_PH_AREA, ETO_OFR_S_PH_NUMBER, ETO_OFR_S_PH_MOBILE, ETO_OFR_S_URL, FK_GL_COUNTRY_ISO, ETO_OFR_GL_COUNTRY_NAME, ETO_OFR_GL_COUNTRY_FLAG, ETO_OFR_DISPLAY_ID, ETO_OFR_GLCAT_CAT_NAME, ETO_OFR_GLCAT_MCAT_NAME, QUERY_LOCK_DATE, ETO_OFR_HIST_BY, ETO_OFR_HIST_USING, ETO_OFR_HIST_COMMENTS, ETO_OFR_HIST_REF, ETO_OFR_HIST_EMP_ID, ETO_OFR_HIST_USR_ID, FK_ETO_AFL_ID, FK_ETO_AFL_WEBSITE_ID, FK_EMPLOYEE_LOCK_ID, ETO_OFR_CALL_RECORDING_URL, ETO_OFR_REQ_FREQ, ETO_OFR_REQ_TYPE, ETO_OFR_GEOGRAPHY_ID, ETO_OFR_REQ_APP_USAGE, ETO_OFR_APPROX_ORDER_VALUE, ETO_OFR_GEO_CITY1_ID, ETO_OFR_GEO_CITY2_ID, ETO_OFR_GEO_CITY3_ID, ETO_OFR_REQ_DESTINATION_PORT, ETO_OFR_REQ_PAYMENT_MODE, ETO_OFR_REQ_SHIPMENT_MODE, ETO_OFR_ONLINE_VERIFIED,ETO_OFR_OTHER_DETAIL, ETO_OFR_SMALL_IMAGE, ETO_OFR_MEDIUM_IMAGE, 
                                                                ETO_OFR_LARGE_IMAGE, ETO_OFR_ORIGINAL_IMAGE, ETO_OFR_SMALL_IMAGE_WH , ETO_OFR_MEDIUM_IMAGE_WH, ETO_OFR_LARGE_IMAGE_WH, ETO_OFR_ORIGINAL_IMAGE_WH, 
                                                                ETO_OFR_DOC_PATH, ETO_OFR_DELETED_AGAINST, USER_IDENTIFIER_FLAG, ETO_OFR_IS_FLAGGED, ETO_OFR_PROCESSED ,ETO_OFR_QTY_UNIT, ETO_OFR_LATITUDE, ETO_OFR_LONGITUDE,FK_ETO_OFR_TYPE_ID,
                                                                ETO_OFR_LOGIN_MODE,ETO_OFR_ATTACHMENT_IS_EXIST,ETO_OFR_DISPLAY_TYPE, RAG_SCORE_TOTAL,FK_TRAFFIC_SOURCE_ID) VALUES($1,$2,'B',COALESCE($3,'P'),$4,$5,to_timestamp($6,'DD-MM-YYYY HH24:MI:SS'),to_timestamp($7,'DD-MM-YYYY HH24:MI:SS'),$8,$9,'1',$10,0,0,'$eto_ofr_approv',$11,$12,to_timestamp($13,'DD-MM-YYYY HH24:MI:SS'),NOW(),$14,$15,$16,$17,$18,$19,$20,$21,$22,$23,$24,$25,$26,$27,$28,$29,$30,$31,$32,$33,$34,$35,$36,$37,$38,$39,$40,to_timestamp($41,'DD-MM-YYYY HH24:MI:SS'),$42,$43,$44,$45,$46,$47,$48,$49,$50,$51,$52,$53,$54,$55,$56,$57,$58,$59,$60,$61,$62,$63,$64,$65,$66,$67,$68,$69,$70,$71,$72,$73,$74,$75,$76,$77,$78,$79,$80,$81,$82,$83,$84,$85,$86)";

                                                                $param = array($reasonCode, $ETO_OFR_ID, $DIR_QUERY_PROD_SERV, $DIR_QUERY_CATID, $SUBJECT , $ETO_OFR_DATE,
                                                                $ETO_OFR_EXP_DATE, $MESSAGE, $DIR_QUERY_FREE_QTY, $FK_GLUSR_USR_ID, $FK_EMPLOYEEID, $DIR_QUERY_MCATID, $DATE_R, $ofrDelFlag, $deletedByEmpId, $ACTION_BY_EMP_ID,$S_COUNTRY_RATING, $QUERY_MODID, $QUERY_REFERENCE_URL, $DIR_QUERY_S_IP, $S_IP_COUNTRY, $SENDERNAME, $S_ORGANIZATION, $S_DESIGNATION, $S_STREETADDRESS, $S_CITY, $S_STATE, $S_ZIP,$S_COUNTRY, $DIR_QUERY_S_PH_COUNTRY, $DIR_QUERY_S_PH_AREA, $S_PHONE, $S_MOBILE, $DIR_QUERY_S_URL, $FK_GL_COUNTRY_ISO, $ETO_OFR_GL_COUNTRY_NAME, $ETO_OFR_GL_COUNTRY_FLAG, $ETO_OFR_DISPLAY_ID, $ETO_OFR_GLCAT_CAT_NAME, $ETO_OFR_GLCAT_MCAT_NAME, $QUERY_LOCK_DATE, $emp_name,
                                                                $histusing, $histcomments, $histref, $deletedByEmpId, $histusrid, $FK_ETO_AFL_ID, $FK_ETO_AFL_WEBSITE_ID,
                                                                $lockID,$call_del_url,$DIR_QUERY_REQ_FREQUENCY, $DIR_QUERY_REQ_PURPOSE, $DIR_QUERY_REQ_GEOGRAPHY_ID,$DIR_QUERY_REQ_APP_USAGE,$DIR_QUERY_REQ_APRX_ORDER_VALUE, $DIR_QUERY_REQ_GEO_CITY1_ID, $DIR_QUERY_REQ_GEO_CITY2_ID, $DIR_QUERY_REQ_GEO_CITY3_ID, $DIR_QUERY_REQ_DESTINATION_PORT, $DIR_QUERY_REQ_PAYMENT_MODE, $DIR_QUERY_REQ_SHIPMENT_MODE,$DIR_QUERY_ENRICHED_STATUS,$DIR_QUERY_OTHER_DETAIL, $DIR_QUERY_SMALL_IMAGE, $DIR_QUERY_MEDIUM_IMAGE, $DIR_QUERY_LARGE_IMAGE, $DIR_QUERY_ORIGINAL_IMAGE, $DIR_QUERY_SMALL_IMAGE_WH , $DIR_QUERY_MEDIUM_IMAGE_WH, $DIR_QUERY_LARGE_IMAGE_WH, $DIR_QUERY_ORIGINAL_IMAGE_WH,
                                                                $DIR_QUERY_DOC_PATH, $deletedAgainst,$USER_IDENTIFIER_FLAG,$ETO_OFR_IS_FLAGGED,$DIR_QUERY_FREE_PROCESSED,$DIR_QUERY_QTY_UNIT,$DIR_QUERY_FREE_LATITUDE,$DIR_QUERY_FREE_LONGITUDE,$FK_ETO_OFR_TYPE_ID,$DIR_QUERY_LOGIN_MODE,$ETO_OFR_ATTACHMENT_IS_EXIST,$ETO_OFR_DISPLAY_TYPE,$RAG_SCORE_TOTAL,$FK_TRAFFIC_SOURCE_ID);
                                                                $paramArr1 = array_map(function($value) { return $value === "" ? NULL : $value; }, $param);
                                                                $result1 = pg_query_params($dbhW,$pgQuery1,$paramArr1);
                                                                $e = pg_last_error($dbhW);
                                                                $queryPg2 = "DELETE FROM DIR_QUERY_FREE WHERE ETO_OFR_DISPLAY_ID = $1;";
                                                                $param = array($offerID);
                                                                $paramArr2 = array_map(function($value) { return $value === "" ? NULL : $value; }, $param);
                                                                $result2 = pg_query_params($dbhW,$queryPg2,$paramArr2);
                                                                if(!($result1 && $result2)){
                                                                        pg_query($dbhW,"ROLLBACK");
                                                                        pg_query($dbhW, "END");
                                                                        $e .= pg_last_error($dbhW);
                                                                        $err = "glusrid : ".$usrID."empid : ".$deletedByEmpId."queryid : ".$QUERY_ID."\n\nError MSG = ".$e."\n\nInsertion Query";
                                                                        $isDeleted='FAILED';
                                                                }else{
                                                                        pg_query($dbhW,"END;");
                                                                        $isDeleted='SUCCESS';
                                                                        }
                                                                }
                                            else if($enqTyp == 2)
                                            {						
						try{
						// PG Block Starts Here
                                                    $sql_temp_del1 = "INSERT INTO ETO_OFR_TEMP_DEL(FK_ETO_OFR_DEL_REASON_CODE, ETO_OFR_ID,USER_IDENTIFIER_FLAG,RAG_SCORE_TOTAL, ETO_OFR_TYP, ETO_OFR_PROD_SERV, FK_GLCAT_CAT_ID, ETO_OFR_TITLE,
                                                        ETO_OFR_DATE, ETO_OFR_EXP_DATE, ETO_OFR_DESC, ETO_OFR_SPEC, ETO_OFR_QTY, FK_GL_CONTINENT_ID, ETO_OFR_PAY_TERM,
                                                        ETO_OFR_SUPPLY_TERM, FK_GLUSR_USR_ID, ETO_OFR_HIT, ETO_OFR_RESPONSE, ETO_OFR_APPROV, ETO_OFR_QLTY, FK_EMPLOYEE_ID,
                                                        ETO_OFR_APPROV_DATE, ETO_OFR_REMOVE, ETO_OFR_KEYWORDS, FK_GLCAT_MCAT_ID,
                                                        ETO_OFR_IMAGE_PATH1, ETO_OFR_IMAGE_PATH2, ETO_OFR_IMAGE_PATH3, ETO_OFR_POSTDATE_ORIG, ETO_OFR_REFRESHCOUNT,
                                                        ETO_OFR_DELETIONDATE, ETO_OFR_DELBYADMINORUSER, ETO_OFR_DELETEDBYID, ETO_OFR_POSTEDBYEMPLOYEE, ETO_MAX_REPONSES, ETO_OFR_QUALITY, FK_GL_MODULE_ID, ETO_OFR_PAGE_REFERRER,
                                                        ETO_OFR_S_IP, ETO_OFR_S_IP_COUNTRY, ETO_OFR_S_SENDERNAME, ETO_OFR_S_ORGANIZATION, ETO_OFR_S_DESIGNATION,
                                                        ETO_OFR_S_STREETADDRESS, ETO_OFR_S_CITY, ETO_OFR_S_STATE, ETO_OFR_S_ZIP, ETO_OFR_S_COUNTRY, ETO_OFR_S_PH_COUNTRY,
                                                        ETO_OFR_S_PH_AREA, ETO_OFR_S_PH_NUMBER, ETO_OFR_S_PH_MOBILE,
                                                         ETO_OFR_S_URL, FK_GL_COUNTRY_ISO, ETO_OFR_GL_COUNTRY_NAME,
                                                        ETO_OFR_GL_COUNTRY_FLAG,
                                                          ETO_OFR_RENEWCOUNT, ETO_OFR_DISPLAY_ID, ETO_OFR_GLCAT_CAT_NAME, ETO_OFR_GLCAT_MCAT_NAME, 
                                                          ETO_OFR_HIST_BY, ETO_OFR_HIST_USING,
                                                         ETO_OFR_HIST_IP_COUNTRY, ETO_OFR_HIST_COMMENTS, ETO_OFR_HIST_IP, ETO_OFR_HIST_REF, ETO_OFR_HIST_MODID, ETO_OFR_HIST_EMP_ID, ETO_OFR_HIST_USR_ID,
                                                          FK_ETO_AFL_ID, FK_ETO_AFL_WEBSITE_ID,ETO_OFR_REQ_FREQ, ETO_OFR_REQ_TYPE, ETO_OFR_GEOGRAPHY_ID, ETO_OFR_GEOGRAPHY_NAME,
                                                         ETO_OFR_REQ_APP_USAGE, ETO_OFR_APPROX_ORDER_VALUE, ETO_OFR_REQ_PURCHASE_PERIOD, ETO_OFR_GEO_CITY1_ID,
                                                         ETO_OFR_GEO_CITY2_ID, ETO_OFR_GEO_CITY3_ID, ETO_OFR_REQ_DESTINATION_PORT, ETO_OFR_REQ_PAYMENT_MODE, ETO_OFR_REQ_SHIPMENT_MODE, ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED,
                                                         ETO_OFR_OTHER_DETAIL,ETO_OFR_EMAIL_VERIFIED_DATE, ETO_OFR_EMAIL_UPDATE_DATE,ETO_OFR_CALL_DISPOSITION_TYPE,ETO_OFR_CALL_RECORDING_URL)
                                                          SELECT $2, ETO_OFR_ID,USER_IDENTIFIER_FLAG,RAG_SCORE_TOTAL,
                                                          ETO_OFR_TYP, ETO_OFR_PROD_SERV, FK_GLCAT_CAT_ID, ETO_OFR_TITLE, ETO_OFR_DATE, ETO_OFR_EXP_DATE, ETO_OFR_DESC,
                                                         ETO_OFR_SPEC, ETO_OFR_QTY, FK_GL_CONTINENT_ID, ETO_OFR_PAY_TERM, ETO_OFR_SUPPLY_TERM, FK_GLUSR_USR_ID, ETO_OFR_HIT,
                                                         ETO_OFR_RESPONSE, ETO_OFR_APPROV, ETO_OFR_QLTY, FK_EMPLOYEE_ID, ETO_OFR_APPROV_DATE, ETO_OFR_REMOVE, ETO_OFR_KEYWORDS,
                                                         FK_GLCAT_MCAT_ID, ETO_OFR_IMAGE_PATH1, ETO_OFR_IMAGE_PATH2, ETO_OFR_IMAGE_PATH3,
                                                         ETO_OFR_POSTDATE_ORIG, ETO_OFR_REFRESHCOUNT, CURRENT_DATE, 1, $3, ETO_OFR_POSTEDBYEMPLOYEE, ETO_MAX_REPONSES,
                                                         ETO_OFR_QUALITY, FK_GL_MODULE_ID, ETO_OFR_PAGE_REFERRER, ETO_OFR_S_IP,
                                                         ETO_OFR_S_IP_COUNTRY, ETO_OFR_S_SENDERNAME, ETO_OFR_S_ORGANIZATION, ETO_OFR_S_DESIGNATION, ETO_OFR_S_STREETADDRESS,
                                                         ETO_OFR_S_CITY, ETO_OFR_S_STATE, ETO_OFR_S_ZIP, ETO_OFR_S_COUNTRY, ETO_OFR_S_PH_COUNTRY, ETO_OFR_S_PH_AREA,
                                                         ETO_OFR_S_PH_NUMBER, ETO_OFR_S_PH_MOBILE, ETO_OFR_S_URL,
                                                         FK_GL_COUNTRY_ISO, ETO_OFR_GL_COUNTRY_NAME, ETO_OFR_GL_COUNTRY_FLAG, ETO_OFR_RENEWCOUNT, ETO_OFR_DISPLAY_ID, ETO_OFR_GLCAT_CAT_NAME, ETO_OFR_GLCAT_MCAT_NAME,
                                                         $4, $5, $6, $7, $8, $9, $10, $3,$11,FK_ETO_AFL_ID, FK_ETO_AFL_WEBSITE_ID,ETO_OFR_REQ_FREQ, ETO_OFR_REQ_TYPE, ETO_OFR_GEOGRAPHY_ID,
                                                         ETO_OFR_GEOGRAPHY_NAME, ETO_OFR_REQ_APP_USAGE, ETO_OFR_APPROX_ORDER_VALUE, ETO_OFR_REQ_PURCHASE_PERIOD,
                                                         ETO_OFR_GEO_CITY1_ID, ETO_OFR_GEO_CITY2_ID, ETO_OFR_GEO_CITY3_ID, ETO_OFR_REQ_DESTINATION_PORT,
                                                         ETO_OFR_REQ_PAYMENT_MODE, ETO_OFR_REQ_SHIPMENT_MODE, ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,
                                                        ETO_OFR_ONLINE_VERIFIED,ETO_OFR_OTHER_DETAIL,ETO_OFR_EMAIL_VERIFIED_DATE, ETO_OFR_EMAIL_UPDATE_DATE,ETO_OFR_CALL_DISPOSITION_TYPE,ETO_OFR_CALL_RECORDING_URL 
                                                        FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID =$1;";
                                                       $sql_temp_del2 = "DELETE FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID =$1;";
							pg_query($dbhW,"BEGIN;");                                                        
                                                        $emp_name="'".$emp_name."'";
                                                        $histusing="'".$histusing."'";
                                                        $histipcountry="'".$histipcountry."'";
                                                        $histcomments="'".$histcomments."'";
                                                        $histref="'".$histref."'"; 
                                                        $histip="'".$histip."'";
                                                        if(empty($histusrid))
                                                        $histusrid=0;
                                                        $params1=array($offerID,$reasonCode,$emp_id,$emp_name,$histusing,$histipcountry,$histcomments,$histip,$histref,$histmodid,$histusrid);
                                                        $sth_temp_del1 = pg_query_params($dbhW, $sql_temp_del1,$params1);
                                                        
                                                        $params2=array($offerID);
                                                        $sth_temp_del2 = pg_query_params($dbhW, $sql_temp_del2,$params2);
                                                        if($sth_temp_del1){
                                                            $e = pg_last_error($dbhW);                                                              
                                                        }
                                                        if($sth_temp_del1 && $sth_temp_del2){
                                                            pg_query($dbhW,"COMMIT;");  
                                                        }else{
                                                            pg_query($dbhW,"ROLLBACK;"); 
                                                            $e = pg_last_error($dbhW);
                                                        }
                                                        pg_query($dbhW,"END;");                                      							
						// PG Block Ends Here
						}catch(Exception $e){					
						}						
					}				
                                        }                                        
                                } 
				else 
				{
					$histip=$histipcountry=$histref=$histmodid=$histusrid = '';
					$histusing = 'Gladmin';
					$histcomments = empty($histcomments)?"Offer Expired":$histcomments;
					$histempid = $emp_id;
					$offer = $errorCode= $errorMsg=$sql = $sth = '';
                                        $histip=$_SERVER['REMOTE_ADDR'];
                                        $histipcountry='India';
                                        $histmodid='GLADMIN';
                                        try{
						 // new code                                                
                                                $sql = "SELECT * from PROC_ETO_DELETE($offerID,null,$emp_id,'$emp_name','$histusing','$histipcountry','$histcomments','$histip',null,'$histmodid',$emp_id,null,$reasonCode);";
                                                 $sth=pg_query($dbhW,$sql);                                                
                                                // new code end 
                                               if(!$sth){                                                        
                                                        echo $e = pg_last_error($dbhW);
						}                                               
                                                
                                               // PG Block Ends Here
					}catch(Eception $e){}
				}
				$result = "Record Deleted";
				if(!empty($delmail)){
					$re = $this->sendDeleteMail($dbhpg,$offerID,$model,$reasonCode,$status);			  
				}
                           
				if($reasonCode==11) {
					$this->sendmail_mcatna_del($dbhpg,$offerID,$status);                              
				}
			}                      
		}die;
		//return $result;
	}
	
	public function sendDeleteMail($dbh,$offerID,$model,$del_reason,$status) 
	 {
	 	$rec1=ARRAY();$ofr_typ = '';
			$myImUrl = 'my';
			$ofr_desc = '';
			$ofr_title_flag = 0;
			$tollfree = '09696969696';
			$glusrEmail = '';
			$glusrEmailAlt = '';
		if(isset($offerID) && !empty($offerID))
		{
			
		if($status == 'W'){
			$tblName = 'ETO_OFR_TEMP_DEL';		
		} else {
			$tblName = 'ETO_OFR_EXPIRED';		
		}
  		$sql = "SELECT ETO_OFR_TYP, ETO_OFR_TITLE, ETO_OFR_DESC, GLUSR_USR_FIRSTNAME, GLUSR_USR_LASTNAME, GLUSR_USR_EMAIL, GLUSR_USR_EMAIL_ALT, GLUSR_USR.FK_GL_COUNTRY_ISO COUNTRY_ISO 
  		FROM ".$tblName.", GLUSR_USR 
  		WHERE ".$tblName.".FK_GLUSR_USR_ID = GLUSR_USR.GLUSR_USR_ID AND ETO_OFR_DISPLAY_ID = :offerID";
                $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":offerID" => $offerID));
		$ofrDataArr1 = $sth1->read();
                if($ofrDataArr1){
                $rec1=array_change_key_case($ofrDataArr1, CASE_UPPER);
                }
                
		$sql2 = "SELECT IIL_MASTER_DATA_VALUE_LRG_TEXT from IIL_MASTER_DATA ";
				                
            	if(isset($del_reason) && !empty($del_reason) && ($del_reason == 15 || $del_reason == 24))  {
            		$sql2 .=" WHERE FK_IIL_MASTER_DATA_TYPE_ID = 4 and IIL_MASTER_DATA_VALUE = :DEL_REASON";
            	} 
            	else if(isset($del_reason) && !empty($del_reason) && $call_del_url == '' )
                {
                        $sql2 .=" WHERE FK_IIL_MASTER_DATA_TYPE_ID = 3 and IIL_MASTER_DATA_VALUE = :DEL_REASON";	
                }
                else if(isset($del_reason) && !empty($del_reason) && !empty($call_del_url))
                {
                        $sql2 .=" WHERE FK_IIL_MASTER_DATA_TYPE_ID = 4 and IIL_MASTER_DATA_VALUE = :DEL_REASON";
                }
                $sth2 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql2, array(":offerID" => $offerID));
		$rec2 = $sth2->read();
		$delReasonLrgText = $rec2['iil_master_data_value_lrg_text'];	
		if($del_reason == 7)
		{
			$delReasonLrgText = '' ;
		}		
		if(isset($delReasonLrgText) && !empty($delReasonLrgText))
                {                	
                        $ofr_typ = $rec1['ETO_OFR_TYP'];
                        $ofr_desc = $rec1['ETO_OFR_DESC'];
			$ofr_title = ucwords(trim($rec1['ETO_OFR_TITLE']));	
                        
                        $glusrEmail = $rec1['GLUSR_USR_EMAIL'];
                        $glusrEmailAlt = $rec1['GLUSR_USR_EMAIL_ALT'];	
                        if(empty($glusrEmail))
                        {                                
                                goto DELETION_MAIL;
                        }

                        $buyerCntyISO=$rec1['COUNTRY_ISO'];
			if($rec1['COUNTRY_ISO'] != 'IN')
			{
                        	$tollfree='+91 9696969696';
			}
			
			$curDate = date('Y-m-d-H-i-s',time());
			
			
			
			$encMail = $this->convertUsingRC4($glusrEmail);
			$encMail = base64_encode($encMail);
			$encMail = urlencode($encMail);
			$age = 15;
			$encDate= $this->convertUsingRC4($curDate);
			$encDate= base64_encode($encDate);
			$encDate= urlencode($encDate);
			
			$encAge= $this->convertUsingRC4($age);
			$encAge= base64_encode($encAge);
			$encAge= urlencode($encAge);
			
			$redirectUrl = "/blgen/postbl/?utm_source=BLRejectM&utm_medium=email&utm_campaign=BL_Gen";
			$encRedirectUrl = urlencode($redirectUrl);
			$encURL = "http://".$myImUrl.".indiamart.com/index_verify.mp?em=".$encMail."&utm_source=BLRejectM&utm_medium=email&utm_campaign=BL_Gen&dt=".$encDate."&age=".$encAge."&av=true&mt=0&redirect=".$encRedirectUrl;
			
			$url = "http://".$myImUrl.".indiamart.com/blgen/postbl/?utm_source=BLRejectM&utm_medium=email&utm_campaign=BL_Gen";
			
			##link for on similar ofr case###
			$encUrlManageBuyRequirement = "http://".$myImUrl.".indiamart.com/index_verify.mp?em=".$encMail."&modid=MY&status=L&dt=".$encDate."&age=".$encAge."&av=true&mt=0&redirect=/blgen/managebl/";
			
			$UrlManageBuyRequirement = "http://".$myImUrl.".indiamart.com/blgen/managebl/?id=".$glusrEmail;
			$bottonMsg = "Yes, I Want to Send New Buy Requirement";
			$heading = "Your Buy Requirement has not been Approved";
         
			$buyerEmails = array($glusrEmail);                       
			$categoriesIN = array("BL Rejection- India");
			$categoriesFOR = array("BL Rejection- Foreign");
			$categoryCnt = 0;
			if(!empty($glusrEmailAlt)) {
				array_push($buyerEmails, $glusrEmailAlt);
				array_push($categoriesIN, "BL Rejection- India-ALT");
				array_push($categoriesFOR, "BL Rejection- Foreign-ALT");
			}             
			$glusrFirstName = $rec1['GLUSR_USR_FIRSTNAME'];
			$glusrLastName = $rec1['GLUSR_USR_LASTNAME'];
			$arr_Len = count($buyerEmails); 
                                
			$reasonText='';
			//New rejection mail format starts		
			if($del_reason == 3 || $del_reason == 14 || $del_reason == 10)	{
			if(preg_match('/^[-]?\d+$/',$ofr_title) && $ofr_title < 0)
                                {
				  $ofr_title_flag=1;	
                                }
				if($del_reason == 3){
					$ofrTitle = ($ofr_title_flag == 1)?ucwords(substr($ofr_desc,0,30)):$ofr_title;
					$reasonText = 'Your requirement for "'.$ofrTitle.'" is not approved. Information provided is not sufficient for suppliers to respond.';
					$msgText1 = 'We request you to please submit your purchase requirement in detail. Please refer guidelines below.';				
				} else if($del_reason == 10){
					$ofrTitle = ($ofr_title_flag == 1)?ucwords(substr($ofr_desc,0,50)):$ofr_title;
					$reasonText = 'Your requirement for "'.$ofrTitle.'" is not approved as <strong>contact details provided by you are incorrect</strong>.';
					$msgText1 = 'We suggest you to share correct mobile/phone numbers for suppliers to respond.';
				}	else if($del_reason == 14){
					$ofrTitle = ($ofr_title_flag == 1)?ucwords(substr($ofr_desc,0,70)):$ofr_title;
					$reasonText = 'Your requirement for "'.$ofrTitle.'" is not approved as you have submitted a <strong>sell offer</strong>.';
					$msgText1 = 'In case you are looking to purchase any product/service, kindly post your  buy requirement and receive quotes.';
				}
				$bottonMsg = 'Post New Buy Requirement<br><span style="font-size:13px; color:#444343 ;"> & Receive Quotes</span>';
				
				
			} else{
				if($del_reason == 1)
                        {
                                $bottonMsg = "Click here to Send your new Buy Requirement";
                                $reasonText = "One of Your Similar Buy Requirement for ".$ofr_title." is already visible on IndiaMART";

                                if(preg_match('/^[-]?\d+$/',$ofr_title) && $ofr_title < 0)
                                {
					$ofr_title_flag=1;
                                        $reasonText = "One of Your Similar Buy Requirement is already visible on IndiaMART";
                                }  
                        }			
			
			}		
                        if(!empty($glusrEmail))
                        {
                                foreach($buyerEmails as $buyerEmailID)
                                {
                                	if($del_reason == 14 || $del_reason == 10 || $del_reason == 3){
						$msg_text = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
						<html xmlns="http://www.w3.org/1999/xhtml">
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						</head><body><table cellpadding="0" cellspacing="0" width="100%"><tr><td><div style="max-width:600px;border:4px solid #ECEAEA;padding:5px"><table width="100%"><tr><td width="50%"><img src=" https://www.indiamart.com/newsletters/mailer/images/indiamart-logo-mt.jpg " alt="IndiaMart" style="width:66%; min-width:140px" /></td><td width="50%"  align="right">
						<a href="https://www.indiamart.com/mobile/"><img src="https://www.indiamart.com/newsletters/mailer/images/market-on-thego.jpg" alt="" style="width:57%; min-width:120px"/></a></td></tr></table>';
						$msg_text .= '<div style="margin-top:5px;padding-left:10px;padding-right:10px;border:3px solid #2e3192;background:#2e3192;font:bold 14px arial;color:#ffffff;line-height:25px;text-align:center">Your Buy Requirement has not been Approved</div>';
						$msg_text .= '<div style="font:13px arial;text-align:left;color:#000000;line-height:18px; padding:5px 0px 5px 2px"><div style="font-family:Arial, Helvetica, sans-serif; font-size:13px;  padding:10px 0px 15px 0px;">Dear '.$glusrFirstName." " .$glusrLastName.',</div>';
						$msg_text .= '<div style=" line-height:23px; font-size:13px">'.$reasonText.'</div>';
						$msg_text .= '<div style=" padding:0px 0px 15px 0px; font-family: arial  "> </div>'.$msgText1;
						$msg_text .= '<div style="width:100%; text-align:center "><div style="display:inline-block;vertical-align:top;margin-top:25px;padding :15px 0px 5px 0px;">';
						
						if($buyerEmailID == $glusrEmail) {					
						  $msg_text .= '<a style="text-decoration:none;text-align:center; font-weight:bold;padding:8px;display:inline-block; line-height:18px ;  font-size:15px; background:-webkit-gradient(linear,left top,left bottom,from(#fbcb3e),to(#fba91a));background:-moz-linear-gradient(top,#fbcb3e ,#fba91a );background:#fba91a   ;background-image: -o-linear-gradient(bottom,#fbcb3e  0%,#fba91a  100%);background-image: -moz-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: -webkit-linear-gradient(bottom,#fbcb3e  0%,#fba91a    100%);
						background-image: -ms-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: linear-gradient(to bottom,#fbcb3e  0%,#fba91a  100%); color:#000000; text-shadow:1px 1px 1px #ffffff; border-radius:6px; padding:10px 0px; border:1px solid #F0A212; width:218px" href="'.$encURL.'" target="_blank">Post New Buy Requirement  <br/> <span style="font-size:13px; color:#444343 ;"> &amp; Receive Quotes</span> </a>
						</div>';
					} else {
                                                $msg_text .= '<a style="text-decoration:none;text-align:center; font-weight:bold;padding:8px;display:inline-block; line-height:18px ;  font-size:15px; background:-webkit-gradient(linear,left top,left bottom,from(#fbcb3e),to(#fba91a));background:-moz-linear-gradient(top,#fbcb3e ,#fba91a );background:#fba91a   ;background-image: -o-linear-gradient(bottom,#fbcb3e  0%,#fba91a  100%);background-image: -moz-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: -webkit-linear-gradient(bottom,#fbcb3e  0%,#fba91a    100%);
						background-image: -ms-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: linear-gradient(to bottom,#fbcb3e  0%,#fba91a  100%); color:#000000; text-shadow:1px 1px 1px #ffffff; border-radius:6px; padding:10px 0px; border:1px solid #F0A212; width:218px" href="'.$url.'" target="_blank">Post New Buy Requirement  <br/> <span style="font-size:13px; color:#444343 ;"> &amp; Receive Quotes</span> </a>
						</div>';
					}
					$imgUrl = ($_SERVER['SERVER_NAME'] == 'dev-leap.intermesh.net')?"http://dev-leap.intermesh.net":"http://leap.intermesh.net";
					$msg_text .= '<div style="font-size:19px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;  color:#2E3192; margin-bottom:4px; margin-top:15px; padding:6px 3px; text-align:left; border-bottom: 1px dotted #cccccc;   ">Guidelines for posting Buy Requirement</div>
					<div style="width:98%; padding:5px 5px 10px 5px;">
					<table cellpadding="0" cellspacing="0" width="100%"  >
					<tr>
					<td width="15%" style="font-size:17px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:right;   padding-top:4px; padding-right:11px; padding-bottom:12px; padding-left:0px; text-align:right"><img src="'.$imgUrl.'/public/images/icon1.jpg"  /></td>
					<td width="85%" align="left" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;   border-bottom:1px dashed #cccccc">Give detailed description of your buy requirement to get best quotes.<br />
					<span style="font-size:12px; font-weight:normal; color:#000000">(Provide Product Features, Product Quantity, Preferred location, Price Range etc.)</span></td>
					</tr>
					<tr>
					<td width="15%" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;   padding:16px 13px 15px 0px; text-align:right"><img src="'.$imgUrl.'/public/images/icon4.jpg" alt=""  /></td>
					<td width="85%" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;   text-align:left;border-bottom:1px dashed #cccccc">Attach pictures to provide better understanding of your product.<br /> </td>
					</tr>
					<tr>
					<td width="15%" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; padding:12px 21px 12px 0px; text-align:right"><img src="'.$imgUrl.'/public/images/icon2.jpg"  alt="" /></td>
					<td width="85%" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;  text-align:left;border-bottom:1px dashed #cccccc">Enter   valid contact number for buyers to contact you.<br /> </td>
					</tr>
					<tr>
					<td width="15%" style="font-size:17px; font-family:Arial, Helvetica, sans-serif;   padding:15px 20px 16px 0px; text-align:right"><img src="'.$imgUrl.'/public/images/icon3.jpg"  alt="" /></td>
					<td width="85%" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;  text-align:left; border-bottom:1px dashed #cccccc">Provide active email address to receive free quotes from suppliers.<br /> </td>
					</tr>
					</table></div>
					</div>';
					if($buyerEmailID == $glusrEmail) {
					  $msg_text .= '<div style="display:inline-block;  vertical-align:top; margin:25px 0px 15px 0px;   padding :0px 0px 10px 0px; text-align:center; width:100% "><a style="text-decoration:none;text-align:center;color:#000000;font-weight:bold;padding:8px;display:inline-block; line-height:18px ;  font-size:15px; background:-webkit-gradient(linear,left top,left bottom,from(#fbcb3e),to(#fba91a  ));background:-moz-linear-gradient(top,#fbcb3e ,#fba91a  );background:#fba91a  ;background-image: -o-linear-gradient(bottom,#fbcb3e  0%,#fba91a  100%);background-image: -moz-linear-gradient(bottom,#fbcb3e  0%,#fba91a    100%);background-image: -webkit-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);
					  background-image: -ms-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: linear-gradient(to bottom,#fbcb3e  0%,#fba91a   100%); color:#000000; text-shadow:1px 1px 1px #ffffff; border-radius:6px; padding:10px 0px; border:1px solid #F0A212; width:218px" href="'.$encURL.'" target="_blank">Post New Buy Requirement  <br/> <span style="font-size:13px; color:#444343 ;"> &amp; Receive Quotes</span> </a>
					  </div>';
					} else {
					  $msg_text .= '<div style="display:inline-block;  vertical-align:top; margin:25px 0px 15px 0px;   padding :0px 0px 10px 0px; text-align:center; width:100% "><a style="text-decoration:none;text-align:center;color:#000000;font-weight:bold;padding:8px;display:inline-block; line-height:18px ;  font-size:15px; background:-webkit-gradient(linear,left top,left bottom,from(#fbcb3e),to(#fba91a  ));background:-moz-linear-gradient(top,#fbcb3e ,#fba91a  );background:#fba91a  ;background-image: -o-linear-gradient(bottom,#fbcb3e  0%,#fba91a  100%);background-image: -moz-linear-gradient(bottom,#fbcb3e  0%,#fba91a    100%);background-image: -webkit-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);
					  background-image: -ms-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: linear-gradient(to bottom,#fbcb3e  0%,#fba91a   100%); color:#000000; text-shadow:1px 1px 1px #ffffff; border-radius:6px; padding:10px 0px; border:1px solid #F0A212; width:218px" href="'.$url.'" target="_blank">Post New Buy Requirement  <br/> <span style="font-size:13px; color:#444343 ;"> &amp; Receive Quotes</span> </a>
					  </div>';
					}
					$msg_text .= '<div style="color:#333333;font-size:13px arial;line-height:18px">';	
					$msg_text .= '<div style="padding:5px 0px 5px 0px">
					<table style="font-size:13px;border:1px solid #d4d4d4;text-align:left" bgcolor="d4d4d4" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody><tr> <td style="background:#f0f0f0;color:#2e3192;font-weight:bold;padding-left:4px;line-height:24px;border-bottom:1px solid #d4d4d4" colspan="2">Happy to Help </td>
					</tr> <tr><td style="padding:5px 0px 5px 4px" bgcolor="#FFFFFF" width="70%"> <strong>Email:</strong><span style="color:#444"> <a href="mailto:buyershelp@indiamart.com" target="_blank" rel="nofollow">buyershelp@indiamart.com</a></span></td></tr> <tr><td style="padding:0px 0px 0px 4px" bgcolor="#FFFFFF"> <strong>Call Us: </strong>
					<a href="tel:'.$tollfree.'" style="text-decoration:none;color:#000000" target="_blank" title="CLICK TO DIAL - Mobile Only">'.$tollfree.'</a>
					</td> </tr> </tbody></table></div>';
					if($buyerEmailID == $glusrEmail && $arr_Len>1) {
					  $msg_text .='<div style="margin-top:5px;color:#000000;font:11px arial;text-align:center;line-height:14px">
					  This mail has also been sent to your alternate '; 
					  if($arr_Len>2) { 
					    $msg_text .='emails '; 
					  }  else{
					  $msg_text .='email ';
					  }
					  $buyerAltEmails = '';
					  foreach($buyerEmails as $userEmail)
					  {
					    if($userEmail != $glusrEmail) {
					      $buyerAltEmails .= $userEmail;
					      break;
					  }
				}
		$msg_text.= ' '.$buyerAltEmails.' </div>';
	}
	$msg_text.= '<div style="margin-top:5px;color:#737373;font:9px arial;text-align:center;line-height:14px">Disclaimer: IndiaMART is an intermediary & has no direct involvement in any transaction between buyers & suppliers.</div>';
	$msg_text.= '<div style="border-top:1px solid #a3a3a3;margin-bottom:10px"></div>
    <table style="width:100%" cellpadding="0" cellspacing="0" border="0"><tbody><tr><td style="font-size:10px;color:#737373;font-family:arial;text-align:center;line-height:14px;margin-bottom:5px" width="100%">IndiaMART InterMESH Ltd.Advant Navis Business Park, Plot no.7, 7th &amp; 8th Floor, Sector-142, Noida, UP</td></tr></tbody></table> </div></div>';
		$msg_text.= '</td></tr></table> 
		</html>';
		//<div style="max-width:600px; padding:5px; font-family:arial; font-size:13px; text-align:center">If you\'d like to unsubcribe and stop receiving this emails <a href="" style="text-decoration:none;  ">click here</a></div> (after table close)
	} else{
                                		$msg_text='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				</head>
				<body>
				<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
				    <td><div style="max-width:600px;border:1px solid #e0e0e0;padding:5px">
					<table width="100%">
					    <tr>
						<td width="50%">
						<img src=" https://www.indiamart.com/newsletters/mailer/images/indiamart-logo-mt.jpg " style="width:66%; min-width:140px" alt="indiamart" title="IndiaMART"/></td> 
						<td width="50%" align="right">
						<a href="https://www.indiamart.com/mobile/"><img src="https://www.indiamart.com/newsletters/mailer/images/market-on-thego.jpg"  style="width:57%; min-width:120px"/></a></td>
					    </tr>
					</table>
					<div style="margin-top:5px;padding-left:10px;padding-right:10px;border:3px solid #2e3192;background:#2e3192;font:bold 14px arial;color:#ffffff;line-height:25px;text-align:center">Your Buy Requirement has not been Approved</div>
					<div style="font:13px arial;text-align:left;color:#000000;line-height:18px; padding:5px">
 					<div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:bold; padding:10px 0px 10px 0px">Dear '. $glusrFirstName." ". $glusrLastName.',</div>';
 					if($del_reason == 1)
					{
						$msg_text .='<div style=" line-height:18px; font-size:14px;; font-weight:bold;">'.$reasonText.'</div>
						<div style=" padding:0px 5px 20px 0px;">      
 				    		<div style="display:block; vertical-align:top; padding-top:10px; color:#000000 ">So this Buy Requirement has not been approved.';
						if($buyerEmailID == $glusrEmail)
                                                {
                                                        $msg_text.=' <a target="_blank" style="text-decoration:none;color:#1155CC" href="'.$encUrlManageBuyRequirement.'">Click here</a> to view your similar offer.';
                                                }
						else
						{
							$msg_text.=' <a target="_blank" style="text-decoration:none;color:#1155CC" href="'.$UrlManageBuyRequirement.'">Click here</a> to view your similar offer.';
						}
						$msg_text.='</div></div>';
					}
					else
					{
						if(preg_match('/^[-]?\d+$/',$ofr_title) && $ofr_title < 0)
                                                {
							$ofr_title_flag=1;
                                                        $msg_text .= '<div style=" padding:0px 5px 0px 0px;  ">       
                                                        <div style="display:block; vertical-align:top; padding-top:10px; color:#000000 ">
                                                        <strong>Requirement Details : </strong> '.$ofr_desc.'</div>
                                                        </div>';
                                                }
						else
						{
                                			$msg_text.='<div style=" line-height:18px; font-size:13px"> Your requirement of <strong>"'.$ofr_title.'"</strong> is not approved.</div>
							<div style=" padding:0px 5px 0px 0px;">      
 				    			<div style="display:block; vertical-align:top; padding-top:10px; color:#000000 "><strong>Requirement for: </strong> '.$ofr_title.'</div>
							</div>';
                                		}
						$msg_text.='<div style=" padding:0px 5px 20px 0px;  ">       
 						<div style="display:block; vertical-align:top; padding-top:10px;font-weight:bold; color:#000000 ">Reason: </div>
  						<div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; padding-top:5px; text-align:justify">'.$rec2['iil_master_data_value_lrg_text'].'</div>
						</div>';
					}
					$msg_text.=' <div style="width:100%; text-align:center ">
					<div style="display:inline-block; vertical-align:top; margin:0px 20px; padding :0px 0px 10px 0px; ">';

					if($buyerEmailID == $glusrEmail)
					{						
                                                $msg_text.='<a style="text-decoration:none;text-align:center;color:#000000;font-weight:bold;padding:8px;display:inline-block; line-height:18px ;  font-size:15px; background:-webkit-gradient(linear,left top,left bottom,from(#fbcb3e),to(#fba91a  ));background:-moz-linear-gradient(top,#fbcb3e ,#fba91a  );background:#fba91a  ;background-image: -o-linear-gradient(bottom,#fbcb3e  0%,#fba91a  100%);background-image: -moz-linear-gradient(bottom,#fbcb3e  0%,#fba91a    100%);background-image: -webkit-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);
					  background-image: -ms-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: linear-gradient(to bottom,#fbcb3e  0%,#fba91a   100%); color:#000000; text-shadow:1px 1px 1px #ffffff; border-radius:6px; padding:10px 0px; border:1px solid #F0A212; width:345px" href="'.$encURL.'" target="_blank">'.$bottonMsg.' &raquo;</a></div>';
					}
					else
					{
						$msg_text.='<a style="text-decoration:none;text-align:center;color:#000000;font-weight:bold;padding:8px;display:inline-block; line-height:18px ;  font-size:15px; background:-webkit-gradient(linear,left top,left bottom,from(#fbcb3e),to(#fba91a  ));background:-moz-linear-gradient(top,#fbcb3e ,#fba91a  );background:#fba91a  ;background-image: -o-linear-gradient(bottom,#fbcb3e  0%,#fba91a  100%);background-image: -moz-linear-gradient(bottom,#fbcb3e  0%,#fba91a    100%);background-image: -webkit-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);
					  background-image: -ms-linear-gradient(bottom,#fbcb3e  0%,#fba91a   100%);background-image: linear-gradient(to bottom,#fbcb3e  0%,#fba91a   100%); color:#000000; text-shadow:1px 1px 1px #ffffff; border-radius:6px; padding:10px 0px; border:1px solid #F0A212; width:345px" href="'.$url.'" target="_blank">'.$bottonMsg.' &raquo;</a></div>';
					}
					$msg_text.='</div>';

					
					$msg_text.='<div style="padding:5px 0px 5px 0px">
					<table style="font-size:13px;border:1px solid #d4d4d4;text-align:left" bgcolor="d4d4d4" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody><tr> <td style="background:#f0f0f0;color:#2e3192;font-weight:bold;padding-left:4px;line-height:24px;border-bottom:1px solid #d4d4d4" colspan="2">Happy to Help </td>
					</tr> <tr><td style="padding:5px 0px 5px 4px" bgcolor="#FFFFFF" width="70%"> <strong>Email:</strong><span style="color:#444"> <a rel="nofollow" href="mailto:buyershelp@indiamart.com" target="_blank">buyershelp@indiamart.com</a></span></td></tr> <tr><td style="padding:0px 0px 0px 4px" bgcolor="#FFFFFF"> <strong>Call Us: </strong>
					<a href="tel:'.$tollfree.'" style="text-decoration:none;color:#000000" target="_blank" title="CLICK TO DIAL - Mobile Only">'.$tollfree.'</a>
					</td> </tr> </tbody></table></div>';

					if($buyerEmailID == $glusrEmail && $arr_Len>1)
                                        {
                                                $msg_text.='<div style="margin-top:5px;color:#000;font:11px arial;text-align:center;line-height:14px"><b>Note:</b> This mail has also been sent to your alternate ';
                                                if($arr_Len>2)
                                                {
                                                $msg_text.='emails ';
                                                }
                                                else{
                                                $msg_text.='email ';
                                                }
                                                $buyerAltEmails = '';
                                                foreach($buyerEmails as $userEmail)
                                                {
                                                        if($userEmail != $glusrEmail)
                                                        {
                                                                $buyerAltEmails .= $userEmail;
                                                                break;
                                                        }
                                                }                                        
                                                
                                                $msg_text.='<span style="text-decoration:none;">'.$buyerAltEmails.'</span>
						</div>';
                                        }

					$msg_text.='<div style="margin-top:5px;color:#737373;font:9px arial;text-align:center;line-height:14px">Disclaimer: IndiaMART is an intermediary &amp; has no direct involvement in any transaction between buyers &amp; suppliers.</div>
    					<div style="border-top:1px solid #a3a3a3;margin-bottom:10px"></div>
    					<table style="width:100%" cellpadding="0" cellspacing="0" border="0">
					<tbody><tr>
					    <td style="font-size:10px;color:#737373;font-family:arial;text-align:center;line-height:14px;margin-bottom:5px" width="100%">IndiaMART InterMESH Ltd.Advant Navis Business Park, Plot no.7, 7th &amp; 8th Floor, Sector-142, Noida, UP</td>
					</tr></tbody>
					</table><p></p>
					</div>
				</div>
 				</td></tr></table>
				</body>
				</html>';

                                
				}
				
				$message_text='Dear '.$glusrFirstName." " .$glusrLastName.',
        
                                We kindly inform you that your buy requirement has not been approved as per below details:';
        
                                if($ofr_title_flag == 1)
                                {
                                $message_text.='
        
                                Requirement Details:'.
                                $rec1['ETO_OFR_DESC'];
                                }
                                else
                                {
                                $message_text.='
        
                                Requirement for: '.$ofr_title;
                                }
                                $message_text.='
        
                                Reason: '.$rec2['iil_master_data_value_lrg_text'].'
        
                                You may use the below link to Send a New Buy Requirement
        
                                http://'.$myImUrl.'.indiamart.com/blgen/postbl/?utm_source=BLRejectM&utm_medium=email&utm_campaign=BL_Gen
                                (Note: If you are unable to click on the above link, simply copy and paste the link into the address bar of the web browser window.)
        
                                For assistance, please contact:
        
                                IndiaMART Buyer\'s Helpdesk
                                Email: buyershelp@indiamart.com | Call Us: '.$tollfree;
					
					
					
                                $to="$buyerEmailID";
                                $from="buyershelp@indiamart.com";
                                $sub='';
                                if($ofr_title_flag == 1)
                                {
                                        $sub='Your Buy Requirement on IndiaMART';
                                }
                                else
                                {
                                        $sub='Your Buy Requirement for '.$ofr_title;
                                }
                                $cc='';
                              
                                $message=$msg_text;
                                $from_name="IndiaMART Buyers HelpDesk";
                                $mime_header="Content-type: text/html\n\n";
                                $bouncemail='';
                                $category = (($buyerCntyISO == 'IN') ? $categoriesIN[$categoryCnt] : $categoriesFOR[$categoryCnt]);
                                $unique_args='';
				$sendGridCategory= 'X-SMTPAPI: {"category":"'. $category.'"}';
                                                                
                                $sendmailArr = array(
                                        'to' => $to,
                                        'from' => $from,
                                        'cc' => $cc,
                                        'sub' => $sub,
                                        'message' => $message,
                                        'from_name' => $from_name,
                                        'replyto' => 'buyershelp+bldeletion@indiamart.com',
                                        'host' => 'ucexhelva2.smtp.sendgrid.net',
                                        'username' => 'rajkamal+BLBuyers@indiamart.com',
                                        'pass' => 'enqmart142',
                                        //'category' => $category,
                                        'message_text' => $message_text,
                                        'unique_args' => $sendGridCategory
                                );                                
                                $this->SendGridMail($sendmailArr);                                 	
                                
                                $categoryCnt++;
                                }
                        }
                }
   } 
DELETION_MAIL:
} 
	
    public function histOfrMapDet($request,$model,$status_type,$status_disp) {
        $obj = new Globalconnection();   
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net'||  $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')
        {    
                $dbh = $obj->connect_db_yii('postgress_web68v');
        }else{
                $dbh = $obj->connect_db_yii('postgress_web68v');
        }

        $start_date = $request->getParam('start_date','');
        $end_date = $request->getParam('end_date','');        
        $offer = $request->getParam('offer',0);
        $status=$request->getParam('status','');
	$MissingNameArray=$recmcat_mondatory = $MissingNameGlid=array();
	$temp=0;
        $status_type='';
        if($status=='') {
             echo 'Invalid Status';exit;
         }
        if($status=='A' || $status=='F' || $status=='P' || $status=='Q'){
            $status_type='L';
        }
        $ofrtable = (!empty($status_type) && $status_type == 'L') ? 'ETO_OFR' : 'ETO_OFR_EXPIRED';
        $supptable = (!empty($status_type) && $status_type == 'L') ? 'ETO_LEAD_SUPPLIER_MAPPING' : 'ETO_LEAD_SUPPLIER_MAPPING_EXP';    
        $auto_mcat_selectiontable = (!empty($status_type) && $status_type == 'L') ? 'ETO_AUTO_MCAT_SELECTION' : 'ETO_AUTO_MCAT_SELECTION_EXP';
        $mcat_selectiontable = (!empty($status_type) && $status_type == 'L') ? 'ETO_OFR_MAPPING' : 'ETO_OFR_MAPPING_EXPIRED';
        
        $sqlStatus= "SELECT ETO_OFR_TITLE,TO_CHAR(ETO_OFR_DELETIONDATE,'YYYY-MM-DD') ETO_OFR_DELETIONDATE FROM ".$ofrtable." WHERE ETO_OFR_DISPLAY_ID=:OFR";
       
        $sthStatus = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sqlStatus, array(':OFR'=>$offer));
        $recStatus=$sthStatus->read();
        $ofrtitle=$recStatus['eto_ofr_title'];
        $sqlMap = "SELECT TO_CHAR(ETO_OFR_MAPPING_DATE, 'DD-Mon-yyyy HH:MI:SS AM') AS ETO_OFR_MAPPING_DATE,
                FK_ETO_OFR_ID,GLCAT_MCAT_ID,GLCAT_MCAT_NAME,GL_EMP_ID,GL_EMP_NAME,
(case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) || (CASE WHEN PRIME_MCAT = GLCAT_MCAT_ID THEN ' [Prime]' ELSE '' END) || (CASE WHEN ((PRIME_MCAT = GLCAT_MCAT_ID) AND (GLCAT_MCAT_IS_BUSINESS_TYPE=1)) THEN '[Business MCAT]' else '' end) IS_GENERIC,                
PRIME_MCAT,GLCAT_MCAT_IS_BUSINESS_TYPE  
                FROM ".$mcat_selectiontable."  ,
                    GLCAT_MCAT,GL_EMP 
                WHERE FK_ETO_OFR_ID = :OFFER_ID
                    AND GL_EMP_ID = FK_EMPLOYEE_ID 
                    AND GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID 
                ORDER BY 2";
          $sthMap = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlMap,array(':OFFER_ID'=>$offer));

        $sqlMap1_old = "SELECT
                    DATE(ETO_OFR_HIST_DATE) ETO_OFR_HIST_DATE,FK_ETO_OFR_ID,
                    ETO_OFR_HIST_NEW_VAL,GLCAT_MCAT_NAME,
                    ETO_OFR_HIST_EMP_ID,ETO_OFR_HIST_COMMENTS,
                    GL_EMP_NAME,(case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) IS_GENERIC,GLCAT_MCAT_IS_BUSINESS_TYPE FROM
                    (select ETO_OFR_HIST_ID,ETO_OFR_HIST_DATE,FK_ETO_OFR_ID,ETO_OFR_HIST_EMP_ID,
                    ETO_OFR_HIST_COMMENTS from ETO_OFR_HIST_MAIN 
                    where 
                    FK_ETO_OFR_ID=:OFFER_ID
                    and ETO_OFR_HIST_COMMENTS = 'Manual Mcat Mapping'
                    )OFR_HIST_MAIN join GL_EMP on ETO_OFR_HIST_EMP_ID = GL_EMP_id
                    left join eto_ofr_hist_detail on ETO_OFR_HIST_ID = FK_ETO_OFR_HIST_ID
                    join GLCAT_MCAT on ETO_OFR_HIST_NEW_VAL::numeric = GLCAT_MCAT_ID
                where 
                eto_ofr_hist_field = 'FK_GLCAT_MCAT_ID' ";
        $sqlMap1 = "SELECT
DATE(ETO_OFR_HIST_DATE) ETO_OFR_HIST_DATE,FK_ETO_OFR_ID,
ETO_OFR_HIST_NEW_VAL,GLCAT_MCAT_NAME,
ETO_OFR_HIST_EMP_ID,ETO_OFR_HIST_COMMENTS,
GL_EMP_NAME,(case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) IS_GENERIC,GLCAT_MCAT_IS_BUSINESS_TYPE FROM
(
select ETO_OFR_HIST_ID,ETO_OFR_HIST_DATE,FK_ETO_OFR_ID,ETO_OFR_HIST_EMP_ID,
ETO_OFR_HIST_COMMENTS from ETO_OFR_HIST_MAIN
where FK_ETO_OFR_ID=:OFFER_ID 
and ETO_OFR_HIST_COMMENTS = 'Manual Mcat Mapping'
)OFR_HIST_MAIN join GL_EMP on ETO_OFR_HIST_EMP_ID = GL_EMP_id
left join eto_ofr_hist_detail on ETO_OFR_HIST_ID = FK_ETO_OFR_HIST_ID
join GLCAT_MCAT on ETO_OFR_HIST_NEW_VAL::numeric = GLCAT_MCAT_ID
where
eto_ofr_hist_field = 'FK_GLCAT_MCAT_ID'
union all 
SELECT
DATE(ETO_OFR_HIST_DATE) ETO_OFR_HIST_DATE,FK_ETO_OFR_ID,
ETO_OFR_HIST_NEW_VAL,GLCAT_MCAT_NAME,
ETO_OFR_HIST_EMP_ID,ETO_OFR_HIST_COMMENTS,
GL_EMP_NAME,(case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) IS_GENERIC,GLCAT_MCAT_IS_BUSINESS_TYPE FROM
(
select ETO_OFR_HIST_ID,ETO_OFR_HIST_DATE,FK_ETO_OFR_ID,ETO_OFR_HIST_EMP_ID,
ETO_OFR_HIST_COMMENTS from ETO_OFR_HIST_MAIN_arch
where FK_ETO_OFR_ID=:OFFER_ID 
and ETO_OFR_HIST_COMMENTS = 'Manual Mcat Mapping'
)OFR_HIST_MAIN join GL_EMP on ETO_OFR_HIST_EMP_ID = GL_EMP_id
left join eto_ofr_hist_detail_arch on ETO_OFR_HIST_ID = FK_ETO_OFR_HIST_ID
join GLCAT_MCAT on ETO_OFR_HIST_NEW_VAL::numeric = GLCAT_MCAT_ID
where
eto_ofr_hist_field = 'FK_GLCAT_MCAT_ID' ";
         $sthMap1 = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlMap1,array(':OFFER_ID'=>$offer));
        $recMap1 = $sthMap1->read();
        $recMapResult = array();
        while ($recp = $sthMap->read())
        {
            $rec=array_change_key_case($recp, CASE_UPPER);       
            array_push($recMapResult,$rec);
        }
        $sqlNotMap = "SELECT GLCAT_MCAT_ID, GLCAT_MCAT_NAME, coalesce(GL_EMP_ID,FK_GL_EMP_ID) GL_EMP_ID,(case when GL_EMP_NAME is NULL then 'Auto Agent' else GL_EMP_NAME end) GL_EMP_NAME, 
            TO_CHAR(ETO_AUTO_MCAT_SELECTION_DATE, 'DD-Mon-yyyy HH:MI:SS AM') AS ETO_AUTO_MCAT_SELECTION_DATE,coalesce(ETO_AUTO_MCAT_RANK,999) ETO_AUTO_MCAT_RANK,
            (case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) IS_GENERIC,GLCAT_MCAT_IS_BUSINESS_TYPE,
            (CASE WHEN MCAT_RELEVANCY_SCORE='1' THEN 'High' WHEN MCAT_RELEVANCY_SCORE='2' THEN 'Medium' WHEN MCAT_RELEVANCY_SCORE='3' THEN 'Low' ELSE 'NA' END) 
            MCAT_RELEVANCY_SCORE
            FROM
            (select FK_GLCAT_MCAT_ID,FK_GL_EMP_ID,ETO_AUTO_MCAT_SELECTION_DATE,ETO_AUTO_MCAT_RANK,MCAT_RELEVANCY_SCORE from $auto_mcat_selectiontable where FK_ETO_OFR_ID = :OFFER_ID
            ) AUTO_MCAT_SELECTIONTABLE join GLCAT_MCAT
            ON GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID
            left join GL_EMP on FK_GL_EMP_ID = GL_EMP_ID
            ORDER BY 6, FK_GL_EMP_ID";

     
      $sthNotMap = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlNotMap,array(':OFFER_ID'=>$offer));
      $recNotMapResult = array();
      while ($recNotMapp = $sthNotMap->read())
        {
                $recNotMap=array_change_key_case($recNotMapp, CASE_UPPER); 
                array_push($recNotMapResult,$recNotMap);
        }
$sql="SELECT GLUSR_USR_ID, GLUSR_COMPANY, GLUSR_USR_CITY, GLUSR_USR_LOC_PREF, GLUSR_USR_URL, ETO_LEAD_SEARCH_KEYWORD, ETO_LEAD_SUPPLIER_RANK,
(CASE WHEN SD_DISPLAY_ID=1 THEN 'Virtual Product' WHEN SD_DISPLAY_ID=2 THEN 'BL Product' || ' ( ' || BL_PRODUCT_DISPLAY_ID || ' )'
ELSE (SELECT COALESCE(PC_ITEM_DISPLAY_NAME,PC_ITEM_NAME) FROM
PC_ITEM left outer join PC_ITEM_EXT on PC_ITEM_ID=FK_PC_ITEM_ID WHERE PC_ITEM_DISPLAY_ID=SD_DISPLAY_ID limit 1)
END) ITEM_OFR_NAME
,MOBILE,SUPPLIER_TYPE,NOB_SUPPLIER_TYPE,SD_DISPLAY_ID,ETO_LEADSUPMAP_TYP,ETO_LEAD_SUPPLIER_DIST, PRODUCT_ACCURACY_SCORE,
(SELECT glusr_usr_deduced_loc_pref1 from glusr_usr_loc_pref where FK_GLUSR_USR_ID=GLUSR_USR_ID) deduced_loc
FROM
(
SELECT GLUSR_USR_ID, LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY, GLUSR_USR_CITY,
(CASE WHEN GLUSR_USR_LOC_PREF='1' THEN 'Global' ELSE (CASE WHEN GLUSR_USR_LOC_PREF='2' THEN 'India Only' ELSE (CASE WHEN GLUSR_USR_LOC_PREF='3' THEN 'Foreign Only'
ELSE (CASE WHEN GLUSR_USR_LOC_PREF='4' THEN 'Local Only' ELSE 'NA' END) END ) END )END) GLUSR_USR_LOC_PREF,
COALESCE(GLUSR_USR.PAIDSHOWROOM_URL,GLUSR_USR.FREESHOWROOM_URL, GLUSR_USR.GLUSR_USR_URL) GLUSR_USR_URL, ETO_LEAD_SEARCH_KEYWORD, ETO_LEAD_SUPPLIER_RANK,
null OFR_TITLE,
(CASE WHEN LTRIM(GLUSR_USR_PH_MOBILE) IS NULL THEN NULL ELSE '+(' || GLUSR_USR_PH_COUNTRY || ')-' || GLUSR_USR_PH_MOBILE END) MOBILE,
((CASE WHEN PAID=-1 THEN 'Paid'
WHEN CUSTTYPE_ID=14 THEN 'V-FCP'
ELSE 'Others'
END)||' ['||CUSTTYPE_NAME ||']'
) SUPPLIER_TYPE,
GL_PRIMARY_BIZ_TYPE NOB_SUPPLIER_TYPE,
SD_DISPLAY_ID,ETO_LEADSUPMAP_TYP,ETO_LEAD_SUPPLIER_DIST, PRODUCT_ACCURACY_SCORE, BL_PRODUCT_DISPLAY_ID
FROM ".$supptable." INNER JOIN GLUSR_USR ON FK_GLUSR_USR_ID =GLUSR_USR_ID
AND FK_ETO_OFR_DISPLAY_ID = :OFR_ID
LEFT JOIN CUSTTYPE ON GLUSR_USR.GLUSR_USR_CUSTTYPE_ID=CUSTTYPE.CUSTTYPE_ID
LEFT JOIN GL_PRIMARY_BIZ ON GLUSR_USR.FK_GLUSR_USR_PBIZ_ID=GL_PRIMARY_BIZ.GL_PRIMARY_BIZ_ID
ORDER BY ABS(ETO_LEAD_SUPPLIER_RANK)
) A";

       $sql_old="SELECT GLUSR_USR_ID, GLUSR_COMPANY, GLUSR_USR_CITY, GLUSR_USR_LOC_PREF, GLUSR_USR_URL, ETO_LEAD_SEARCH_KEYWORD, ETO_LEAD_SUPPLIER_RANK,
            (CASE WHEN SD_DISPLAY_ID=1 THEN 'Virtual Product' WHEN SD_DISPLAY_ID=2 THEN 'BL Product' || ' ( ' || BL_PRODUCT_DISPLAY_ID || ' )' 
            ELSE (SELECT COALESCE(PC_ITEM_DISPLAY_NAME,PC_ITEM_NAME) FROM 
            PC_ITEM left outer join PC_ITEM_EXT on PC_ITEM_ID=FK_PC_ITEM_ID WHERE PC_ITEM_DISPLAY_ID=SD_DISPLAY_ID limit 1)
            END) ITEM_OFR_NAME
            ,MOBILE,SUPPLIER_TYPE,NOB_SUPPLIER_TYPE,SD_DISPLAY_ID,ETO_LEADSUPMAP_TYP,ETO_LEAD_SUPPLIER_DIST, PRODUCT_ACCURACY_SCORE,
             (SELECT glusr_usr_deduced_loc_pref1 from glusr_usr_loc_pref where FK_GLUSR_USR_ID=GLUSR_USR_ID) deduced_loc 
            FROM
            (
            SELECT GLUSR_USR_ID, LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY, GLUSR_USR_CITY,
            (CASE WHEN GLUSR_USR_LOC_PREF='1' THEN 'Global' ELSE (CASE WHEN GLUSR_USR_LOC_PREF='2' THEN 'India Only' ELSE (CASE WHEN GLUSR_USR_LOC_PREF='3' THEN 'Foreign Only'
            ELSE (CASE WHEN GLUSR_USR_LOC_PREF='4' THEN 'Local Only' ELSE 'NA' END) END ) END )END) GLUSR_USR_LOC_PREF,
            COALESCE(GLUSR_USR.PAIDSHOWROOM_URL,GLUSR_USR.FREESHOWROOM_URL, GLUSR_USR.GLUSR_USR_URL) GLUSR_USR_URL, ETO_LEAD_SEARCH_KEYWORD, ETO_LEAD_SUPPLIER_RANK,
            null OFR_TITLE,
            (CASE WHEN LTRIM(GLUSR_USR_PH_MOBILE) IS NULL THEN NULL ELSE '+(' || GLUSR_USR_PH_COUNTRY || ')-' || GLUSR_USR_PH_MOBILE END) MOBILE,
            (SELECT (CASE WHEN PAID=-1 THEN 'Paid'
            WHEN CUSTTYPE_ID=14 THEN 'V-FCP'
            ELSE 'Others'
            END)||' ['||CUSTTYPE_NAME ||']'
            FROM CUSTTYPE WHERE GLUSR_USR.GLUSR_USR_CUSTTYPE_ID=CUSTTYPE.CUSTTYPE_ID) SUPPLIER_TYPE,
            (SELECT GL_PRIMARY_BIZ_TYPE FROM GL_PRIMARY_BIZ WHERE GLUSR_USR.FK_GLUSR_USR_PBIZ_ID=GL_PRIMARY_BIZ.GL_PRIMARY_BIZ_ID)NOB_SUPPLIER_TYPE,
            SD_DISPLAY_ID,ETO_LEADSUPMAP_TYP,ETO_LEAD_SUPPLIER_DIST, PRODUCT_ACCURACY_SCORE, BL_PRODUCT_DISPLAY_ID 
            FROM ".$supptable." INNER JOIN GLUSR_USR ON FK_GLUSR_USR_ID =GLUSR_USR_ID
            AND FK_ETO_OFR_DISPLAY_ID = :OFR_ID 
            ORDER BY ABS(ETO_LEAD_SUPPLIER_RANK)
            ) A";	

    $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array(":OFR_ID" => $offer));    

$hash = $moredetail=$productlistingdetail=$solr_result=array();$i=1;$rel='';   
    while($rec = $sth->read()){  
        $SD_DISPLAY_ID=isset($rec['sd_display_id']) ? $rec['sd_display_id'] : 0;         
        $hash["GLUSR_USR".$i.""]["SD_DISPLAY_ID"] =$SD_DISPLAY_ID;

         if(isset($_REQUEST['pl']) && $_REQUEST['pl']=='yes'){
                     if($i==1){
                            $solr_result=$this->getmoredetail($rec['eto_lead_search_keyword']);
                             $productlisting= $this->showSearchListingData($solr_result);
                             $productlistingdetail=$productlisting['list'];
                             $rel=$productlisting['rel'];
                        }
                        if(isset($productlistingdetail[$SD_DISPLAY_ID]))                
                               { 

                                       $hash["GLUSR_USR".$i.""]["QUALITY_SCORE"] = isset($productlistingdetail[$SD_DISPLAY_ID]['QUALITY_SCORE'])?$productlistingdetail[$SD_DISPLAY_ID]['QUALITY_SCORE']:'';
                                       $hash["GLUSR_USR".$i.""]["PRIME"] = isset($productlistingdetail[$SD_DISPLAY_ID]['PRIME'])?$productlistingdetail[$SD_DISPLAY_ID]['PRIME']:'';
                                       $hash["GLUSR_USR".$i.""]["DISTANCE"] = isset($productlistingdetail[$SD_DISPLAY_ID]['DISTANCE'])?$productlistingdetail[$SD_DISPLAY_ID]['DISTANCE']:'';
                                       $hash["GLUSR_USR".$i.""]["RANK"] = isset($productlistingdetail[$SD_DISPLAY_ID]['RANK'])?$productlistingdetail[$SD_DISPLAY_ID]['RANK']:'';
                                       $hash["GLUSR_USR".$i.""]["MCATID_NAMES"]  = isset($productlistingdetail[$SD_DISPLAY_ID]['MCATID_NAME'])?$productlistingdetail[$SD_DISPLAY_ID]['MCATID_NAME']:'';
                                       $hash["GLUSR_USR".$i.""]["KWD_PREM"] = isset($productlistingdetail[$SD_DISPLAY_ID]['KWD_PREM'])?$productlistingdetail[$SD_DISPLAY_ID]['KWD_PREM']:'';
                                       $ALLCITY = isset($productlistingdetail[$SD_DISPLAY_ID]['ALLCITY'])?$productlistingdetail[$SD_DISPLAY_ID]['ALLCITY']:array();
                                       $pref_country = implode(", ", $ALLCITY);
                                       $hash["GLUSR_USR".$i.""]["ALLCITY"] = $pref_country;                       
                                }
         }
        
        $hash["GLUSR_USR".$i.""]["GLUSR_USR_ID"] = isset($rec['glusr_usr_id'])?$rec['glusr_usr_id']: '';
        $hash["GLUSR_USR".$i.""]["GLUSR_COMPANY"] = isset($rec['glusr_company'])? $rec['glusr_company']: ''; 
        $hash["GLUSR_USR".$i.""]["MOBILE"] = isset($rec['mobile'])? $rec['mobile']: '';
        $hash["GLUSR_USR".$i.""]["GLUSR_USR_URL"] = isset($rec['glusr_usr_url'])?$rec['glusr_usr_url']:'';
        $hash["GLUSR_USR".$i.""]["GLUSR_USR_CITY"] = isset($rec['glusr_usr_city']) ?$rec['glusr_usr_city']:'';
        $hash["GLUSR_USR".$i.""]["DEDUCED_LOC"] = isset($rec['deduced_loc'])?$rec['deduced_loc']:'';
        $hash["GLUSR_USR".$i.""]["GLUSR_USR_LOC_PREF"] = isset($rec['glusr_usr_loc_pref'])?$rec['glusr_usr_loc_pref']:'';

        $hash["GLUSR_USR".$i.""]["ITEM_OFR_NAME"] = isset($rec['item_ofr_name'])?$rec['item_ofr_name']:'';
        $hash["GLUSR_USR".$i.""]["ETO_OFR_TITLE"] = $ofrtitle;
        $hash["GLUSR_USR".$i.""]["SEARCH_KEYWORD"] = isset($rec['eto_lead_search_keyword'])?$rec['eto_lead_search_keyword']:'';
        $hash["GLUSR_USR".$i.""]["SUPPLIER_RANK"] = isset($rec['eto_lead_supplier_rank'])?$rec['eto_lead_supplier_rank']:'';
        $hash["GLUSR_USR".$i.""]["SUPPLIER_TYPE"] = isset($rec['supplier_type'])?$rec['supplier_type']:'';
        $hash["GLUSR_USR".$i.""]["NOB_SUPPLIER_TYPE"] = isset($rec['nob_supplier_type'])?$rec['nob_supplier_type']:'';
        $hash["GLUSR_USR".$i.""]["ETO_LEADSUPMAP_TYP"] = isset($rec['eto_leadsupmap_typ'])?$rec['eto_leadsupmap_typ']:'';       
        $hash["GLUSR_USR".$i.""]["DISTANCE"] = isset($rec['eto_lead_supplier_dist'])?$rec['eto_lead_supplier_dist']:'';
        $hash["GLUSR_USR".$i.""]["QUALITY_SCORE"] = isset($rec['product_accuracy_score'])?$rec['product_accuracy_score']:'';  
              
        $i++;
    }
          
      $sqlmcat_mondatory = "select gl_profile_new_value,gl_profile_old_value from bl_profile_enrichment where fk_gl_attribute_id=228 and eto_ofr_display_id = :OFFER_ID ";
      $sthmcat_mondatory = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlmcat_mondatory,array(':OFFER_ID'=>$offer));
      
      while ($recmcat_row = $sthmcat_mondatory->read())
        {
                array_push($recmcat_mondatory,$recmcat_row);
        }
     return array(
        "hash" => $hash,
        "recNotMapResult" => $recNotMapResult,
        "recMap1" => $recMap1,
        "recMapResult" => $recMapResult,
        "MissingNameArray"=>$MissingNameArray,
        "relcat"=>$rel,"recmcat_mondatory"=>$recmcat_mondatory
    );
    //#### Selected Mcats Details ####
}

public function getmoredetail($searchkey) {
            $emp_name = Yii::app()->session['empname'];
            $empid = Yii::app()->session['empid'];
            $server='';
            $param_ref['q'] = preg_replace("/\+|%20/"," ",$searchkey);
            $param_ref['source'] = 'gladmin.debug.screen';
            $webservice_params = $this->create_webservice_url_params($param_ref);
            $web_service_url ="/search/ims?".http_build_query($webservice_params);
            $service_model = new ServiceGlobalModelForm();
            $response = $service_model->searchApiService($web_service_url, ['shall_return_json' => 1]);
            if (is_string($response)) {
                $response =json_decode($response, true); 
            }
            return $response;
}



 public function showSearchListingData($inputHash)
        {
                 
                 $total_result=isset($inputHash['total_results']) ? $inputHash['total_results'] : '';                
                 $result=array();
                 $live_mcats = isset($inputHash['guess']['guess']['live_mcats'])?$inputHash['guess']['guess']['live_mcats']:'';
                 $top_live_mcatname = isset($live_mcats[0]['name']) ? $live_mcats[0]['name'] : '';
                 $top_live_mcatid = isset($live_mcats[0]['id']) ? $live_mcats[0]['id'] : 0;
                 
                 $topmost_mcats = isset($inputHash['guess']['guess']['topmost_mcat'])?$inputHash['guess']['guess']['topmost_mcat']:'';
                 $topmost_mcatname = isset($topmost_mcats['name']) ? $topmost_mcats['name'] : '';
                 $topmost_mcatid = isset($topmost_mcats['id']) ? $topmost_mcats['id'] : 0;                 
                if(isset($total_result) && $total_result > 0)
                {
                         $relatedMcat='';
                         if($top_live_mcatname !='')
                         {
                             $td=$color=''; 
                                $i=0;
                                foreach($live_mcats as $key=>$val)
                                {
                                        $related_mcatname = isset($live_mcats[$i]['name']) ? $live_mcats[$i]['name'] : '';
                                        $related_mcatid = isset($live_mcats[$i]['id']) ? $live_mcats[$i]['id'] : 0;
                                        $related_accuracy = isset($live_mcats[$i]['mcat_accuracy_level']) ? ', '.$live_mcats[$i]['mcat_accuracy_level'] : '';
                                        $frequency = isset($live_mcats[$i]['frequency']) ? ', '.$live_mcats[$i]['frequency'] : '';

                                        if($related_mcatname == $topmost_mcatname)
                                        {
                                            $color='color:green;';    
                                        }
                                        $td .='<td style="font-family: ms sans serif,verdana;font-size: 12px;line-height: 17px;padding:2px;'.$color.'">'.$related_mcatname.' ('.$related_mcatid.')'.$related_accuracy.''.$frequency.'</td>';
                                        $color=''; 
                                        $i++;
                                }
                                $relatedMcatHtml ='<table style="font-family: ms sans serif,verdana;font-size: 12px;line-height: 17px;padding:2px;border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="2" cellspacing="0" width="100%"><tr style="background: white;"><td style="padding:4px;background-color: #ccccff;font-weight:bold;color: #000;" align="center">Related Mcats</td>'.$td.'</tr></table>';
                                $result['rel']=$relatedMcatHtml;
                                $result['list']=$this->searchListingData($inputHash,$topmost_mcatid);        
                                return $result;                         
                         }             
                }
               
        }
        public function searchListingData($solrResult,$topmost_mcatid)
        {
                
               $mcat_name_id_list=$mcat_rank=$prime_mcat=$premium_lis='';
                $pos = 0;  
               $result_array=array();
                foreach($solrResult['results'] as $key=>$val)
                {
                    $pos++;                    
                      $mcat_name_id_list=$pref_city=''; 
                      $displayId = isset($val['fields']['displayid']) && $val['fields']['displayid'] != '' ? $val['fields']['displayid'] : '';
                       
                        $mcatid_name = isset($val['fields']['categoryinfo']) && $val['fields']['categoryinfo'] != '' ? $val['fields']['categoryinfo'] : '';
                        if(count($mcatid_name) > 0)
                        {
                                $mcat_name_id_list = $this->getMcatNameID($mcatid_name);
                        }
                          $result_array[$displayId]['MCATID_NAME'] = $mcat_name_id_list;
                          
                         $result_array[$displayId]['MCAT_IDLIST'] = isset($val['fields']['mcatidWithRank']) && $val['fields']['mcatidWithRank'] != '' ? $val['fields']['mcatidWithRank'] : '';
                         list($mcat_rank,$prime_mcat,$premium_lis) = $this->getSearchMcatDetails($result_array[$displayId]['MCAT_IDLIST'] ,$topmost_mcatid);
                         $kwd_prem = isset($val['fields']['premium_listing']) && $val['fields']['premium_listing'] != '' ? $val['fields']['premium_listing'] : '';
                        if($kwd_prem != '')
                        {
                              $kwd_prem = $kwd_prem.' , '.$premium_lis;   
                        }
                        else
                        {
                              $kwd_prem = $premium_lis;
                        }
                         $result_array[$displayId]['KWD_PREM'] =$kwd_prem;
                         $result_array[$displayId]['QUALITY_SCORE'] = isset($val['fields']['productqualityscore']) && $val['fields']['productqualityscore'] != '' ? $val['fields']['productqualityscore'] : '';
                         $result_array[$displayId]['RANK'] = $mcat_rank;
                         $result_array[$displayId]['PRIME'] = $prime_mcat;
                         $result_array[$displayId]['DISTANCE'] = isset($val['fields']['distance']) && $val['fields']['distance'] != '' ? round($val['fields']['distance'],2) : 0;
                        if(isset($val['fields']['bllocpref']) && (is_array($val['fields']['bllocpref'])))
                        {
                                 $result_array[$displayId]['CNTRYQ'] = $val['fields']['bllocpref'];				
                        }		
 			if(isset($val['fields']['prefcity']) && (is_array($val['fields']['prefcity'])))
                        {
                               $result_array[$displayId]['ALLCITY'] = $val['fields']['prefcity']; 
                        } 
                        
                }
                return  $result_array;
        }
        
        public function getSearchMcatDetails($mcat_idlist,$topmost_mcatid)
        {
                $rank ='NA';
                $prem_ser='NA';
                $prime= 'Secondary';
                if (is_array($mcat_idlist))
                {
                    foreach($mcat_idlist as $values)
                    {
                            if (!is_numeric($values)) 
                            {
                                    if(preg_match('/'.$topmost_mcatid.'/',$values))
                                    {
                                            if(preg_match('/A|B|C|D/',$values))
                                            {
                                                preg_match('/(\d+)(\w+)/', $values, $matches); 
                                                $rank =$matches[2];
                                            }
                                            if(preg_match('/LS|SS/',$values))
                                            {
                                                preg_match('/(\d+)(\w+)/', $values, $matches); 
                                                $prem_ser =$matches[2];
                                            }
                                            if(preg_match('/P/',$values))
                                            {
                                                preg_match('/(\d+)(\w)/', $values, $matches); 
                                                $prime =(isset($matches[2]) && ($matches[2] == 'P'))?'Primary':'';
                                            }
                                    }
                            }
                    }
                }
                return array($rank,$prime,$prem_ser);
        }
            
        
        public function getMcatNameID($mcat_list)
        {
                $mcat_val='';
                $final_val='';
                if (is_array($mcat_list))
                {
                    foreach($mcat_list as $values)
                    {
                        if(count($values)> 0)
                        {
                                $mcatdetails = explode("|",$values);
                                if($mcatdetails[0]!='' && $mcatdetails[1]!='')
                                {
                                    $mcat_val .= $mcatdetails[1].' ('.$mcatdetails[0].'), ';
                                }
                        }
                    }
                }
                $final_val = preg_replace("/,\s+$/","",$mcat_val);                
                return $final_val;
        }
      
     public  function managecitycountry($country_iso_val,$cntry,$pos,$flag){
    
                                asort($cntry);
				$countcountry =  count($cntry);
 				$country_iso_vals = strtoupper($country_iso_val);
 				
				if($country_iso_val == ''){
					$fivecountry = array_slice($cntry, 0, 5);			
					$pref_country = implode("<br>", $fivecountry);
					$showmorecountry = array_slice($cntry, 5, $countcountry);
					if($showmorecountry !=''){
                                                $pref_countryshowmore = implode("<br>", $showmorecountry);
                                                if($flag == 'country'){
                                                    $htmldiv =  "<div id = 'morecountry_$pos' name = 'more' value ='".$pref_countryshowmore."'></div>";
                                                }
                                                if($flag == 'city'){
                                                    $htmldiv =  "<div id = 'morecity_$pos' name = 'more' value ='".$pref_countryshowmore."'></div>";
                                                }
                                            }
				}

                                
                                if($country_iso_vals !=''){
                                    if($flag == 'city'){
                                        $country_iso_vals = ucwords($country_iso_val);
                                    }
                                    
                                    if($flag == 'country'){
                                        $country_iso_vals = strtoupper($country_iso_val);
                                    }
                                       					
                                        if (in_array($country_iso_vals,$cntry))
                                                {					
                                                    if (($key = array_search($country_iso_vals, $cntry)) !== false) {
                                                        unset($cntry[$key]);
                                                    }
                                                    $fivecountry = array_slice($cntry, 0, 4);					
                                                    array_unshift($fivecountry, "<B>".$country_iso_vals."</B>");					
                                                    $pref_country = implode("<br>", $fivecountry); 
                                                    
                                                    $showmorecountry = array_slice($cntry, 4, $countcountry);
                                                    if($showmorecountry !=''){                                                      
                                                        $pref_countryshowmore = implode("<br>", $showmorecountry);
                                                        if($flag == 'country'){
                                                            $htmldiv =  "<div id = 'morecountry_$pos' name = 'more' value ='".$pref_countryshowmore."'></div>";
                                                        }
                                                        if($flag == 'city'){
                                                            $htmldiv =  "<div id = 'morecity_$pos' name = 'more' value ='".$pref_countryshowmore."'></div>";
                                                        }
                                                    }
                                                } else{
                                                    $fivecountry2 = array_slice($cntry, 0, 5);                                                   
                                                    $pref_country = implode("<br>", $fivecountry2);
                                                    $showmorecountry = array_slice($cntry, 5, $countcountry);
                                                    if($showmorecountry !=''){
                                                        $pref_countryshowmore = implode("<br>", $showmorecountry);
                                                        //$htmldiv = "<div id = 'morecountry_$pos' name = 'more' value ='".$pref_countryshowmore."'></div>";
                                                       if($flag == 'country'){
                                                            $htmldiv =  "<div id = 'morecountry_$pos' name = 'more' value ='".$pref_countryshowmore."'></div>";
                                                        }
                                                        if($flag == 'city'){
                                                            $htmldiv =  "<div id = 'morecity_$pos' name = 'more' value ='".$pref_countryshowmore."'></div>";
                                                        }
                                                    }
                                                }
                                        
				}
				 return array('value1' => $pref_country, 'value2' => $htmldiv);
               
	}
        
     public function create_webservice_url_params($parameters_hash)
    {
            $array= array();
            $key_arr = array_keys($parameters_hash);
            for($i=0; $i<count($key_arr);$i++)
            {
                    if(is_array($parameters_hash[$key_arr[$i]]) && (!is_int(key($parameters_hash[$key_arr[$i]]))))
                    {
                            $return_arr_ref = $this->create_webservice_url_params($parameters_hash[$key_arr[$i]]);
                            foreach($return_arr_ref as $key => $value)
                            {
                                    $array[$key_arr[$i].'.'.$key] = $value;
                            }
                    }
                    else
                    {

                            if(is_array($parameters_hash[$key_arr[$i]]) && is_int(key($parameters_hash[$key_arr[$i]])))
                            {
                                    $value = join('|',array_values($parameters_hash[$key_arr[$i]]));
                                    $array[$key_arr[$i]] = $value;
                            }
                            else
                            {
                                    $array[$key_arr[$i]] = $parameters_hash[$key_arr[$i]];
                            }
                    }
            }
            return $array;
    }    
	public function delMulRecord($model,$request,$empId){
		$del_offers = $request->getParam('delmulOfrs');
		$del_offersArr = $request->getParam('delmuloffersArr');
		if(strpos($del_offersArr, ',')){
			$delOffers = preg_split('/,/', $del_offersArr);
		} else{
			$delOffers = $del_offers;	
		}
		if(is_array($delOffers)){
			foreach($delOffers as $k=>$row){
			$this->delRec($model,$request,$empId,$row);
			}	
		} else{
				$this->delRec($model,$request,$empId,$del_offers);
		}
	}

	public function saveGlUsrDetails($request,$model,$empId) 
	{
		
		$obj = new Globalconnection();
		$dbhW = $obj->connectPostgres_wrt();
		$updatedby = Yii::app()->session['empname'];
		$count = 0;	
		
		$glusr_id = $request->getParam('glusr_id','');
		$fname = $request->getParam('txtfname','');
		$lname = $request->getParam('txtlname','');
		$email = $request->getParam('email','');
		$altemail = $request->getParam('alt_email','');
		$desig = $request->getParam('desi','');
		$company = $request->getParam('company','');
		$countryISO = $request->getParam('country_iso','');
		$state = $request->getParam('state_others','');
		$city = $request->getParam('city_others','');
		$add1 = $request->getParam('Address1','');
		$add2 = $request->getParam('Address2','');
		$pin = $request->getParam('Pin','');
		$phCountry = $request->getParam('ph_country','');
		$phArea = $request->getParam('ph_area','');
		$phone = $request->getParam('Ph_phone','');
		$phCountry2 = $request->getParam('ph_country2','');
		$phArea2 = $request->getParam('ph_area2','');
		$phone1 = $request->getParam('Ph_phone1','');
		$mobile1 = $request->getParam('mobile1','');
		$mobile2 = $request->getParam('mobile2','');
		$fax_country = $request->getParam('fax_country','');
		$fax_area = $request->getParam('fax_area','');
		$url = $request->getParam('url','');
		$cityID = $request->getParam('city','');
		$stateID = $request->getParam('state','');
		$legalStatusID = $request->getParam('legal_status_id','');
		$country_name = "India";
		$remote_host = $_SERVER['REMOTE_ADDR']; 
		$suceess = array();
		if(!empty($glusr_id))
		{
			
				$content["USR_ID"]= $glusr_id;
				$content["VALIDATION_KEY"]= 'c5a1c52d8cc7beec3b72f4632f31ce1c';
                                $content["FIRSTNAME"]=  $fname;
                                $content["LASTNAME"]=  $lname;		
                                $content["EMAIL_ALT"]=  $altemail; 
				$content["DESIGNATION"]=  $desig;                          
                                $content["COMPANYNAME"]=  $company;
                                $content["FK_GL_COUNTRY_ISO"]=  $countryISO;
                                $content["STATE"]=  $state;                                
                                $content["CITY"]=  $city;
				$content["ADD1"]=  $add1;
				$content["ADD2"]=  $add2;
				$content["ZIP"]=  $pin;
                                $content["PH_COUNTRY"]= $phCountry;
                                $content["PH_AREA"]=  $phArea;
                                $content["PH_NUMBER"] = $phone;
                                $content["PH2_COUNTRY"] =$phCountry2;
                                $content["PH2_AREA"] = $phArea2;
                                $content["PH2_NUMBER"] = $phone1;
                                $content["PH_MOBILE"] = $mobile1;
                                $content["PH_MOBILE_ALT"] = $mobile2;             
                                $content["URL"] = $url;
                                $content["FK_GL_CITY_ID"] = $cityID;
                                $content["FK_GL_STATE_ID"] = $stateID;
                                $content["FK_GL_LEGAL_STATUS_ID"] = $legalStatusID;
				$content["UPDATESCREEN"]	= 'Gladmin Buy Lead Search';
                                $content["UPDATEDBY"] = $updatedby;
                                $content["UPDATEDBY_ID"] = $empId;
                                $content["UPDATEDUSING"] ='Gladmin Buy Lead Search';
                                $content["IP"] =	$remote_host;
                                $content["IP_COUNTRY"] =	$country_name;
                                $content["HIST_COMMENTS"]	='UPDATED FROM Glamin BL Approval Screen';
                                $content["LASTMODIFIED"]= "SYSDATE";	
                                $content["serviceurl"]= "user/update";
					
			
                        $objservice=new ServiceGlobalModelForm();
                        $sth2_user_update = $objservice->wapiServiceAPI($content);
                        
			if($sth2_user_update) 
			{
			
				$ofrCountryName = $request->getParam('country_name','');
				try{				
					$sql_eto_ofr = "UPDATE
						ETO_OFR
					SET
						ETO_OFR_GL_COUNTRY_NAME = $1,
					ETO_OFR_HIST_BY = $2,
					ETO_OFR_HIST_EMP_ID = $3,
					ETO_OFR_HIST_IP_COUNTRY = $4,
					ETO_OFR_HIST_IP = $5,
					ETO_OFR_HIST_USING = 'From General Buy Leads Approval Screen',
					ETO_OFR_HIST_COMMENTS = 'Offer Location Field Updated'
					WHERE FK_GLUSR_USR_ID =$6
					AND
					(
					 ETO_OFR_GL_COUNTRY_NAME != $1 OR ETO_OFR_GL_COUNTRY_NAME IS NULL 
					)";                        
					$params=array($ofrCountryName, $updatedby, $empId, $country_name, $remote_host, $glusr_id);
					$sth=  pg_query_params($dbhW,$sth_eto_ofralrt,$params);					
				}catch(Exception $e){}				
				$count++;
			} else {
				return "FAIL";
			}	
		}	
	}
	
	public function showPrevCallData($request,$param,$model){
		$poolFlag = 0;$poolCount = '';
		$result = array();
		$start='';
		$totalOffers='';
		$poolData =$rec= array();
		$obj = new Globalconnection();
               if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
		$offerId = isset($param['offerId'])?$param['offerId']:'';
		$empid = isset($param['empid'])?$param['empid']:0;
		$allowPrem = isset($param['allowPrem'])?$param['allowPrem']:'';
		$param['bl_wait_pool_id'] = $request->getParam('bl_wait_pool_id',0);
		$status = $param['status'] = $request->getParam('status','A');
		$blType = $param['bltype'] = $request->getParam('bltype',1);
		$tableType = $param['tabletype'] = $request->getParam('tabletype',3);
		$param['move'] = $request->getParam('move','');
		$param['cont'] = $request->getParam('cont','');
		if(!empty($param['cont']))
		{
			$param['move'] = 'next';
		}
		
		if(!empty($param['bl_wait_pool_id']) || $param['status'] == 'E'){
					$poolFlag = 1;
					$poolData = $this->callVerify($dbh,$param,$model);
					$offerId = isset($poolData['offerId'])?$poolData['offerId']:'';
					$start = isset($poolData['start'])?$poolData['start']:'';
					$totalOffers = isset($poolData['totalOffers'])?$poolData['totalOffers']:'';
		}
		if(!empty($param['bl_wait_pool_id'])){
			$sqlPoolCnt = "SELECT COUNT(1) POOLCNT FROM ETO_OFR, ETO_OFR_CALL_VERIFIED 
					WHERE
					ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID 
					AND ETO_OFR_APPROV='A'";
			if($param['bl_wait_pool_id'] >= 1 && $param['bl_wait_pool_id'] <= 6) {
					$sqlPoolCnt.= " AND ETO_OFR.ETO_OFR_BUY_WAITING_POOL_ID IS NOT NULL ";
			} else if($param['bl_wait_pool_id'] == -1) {
					$sqlPoolCnt.=" AND ETO_OFR.ETO_OFR_BUY_WAITING_POOL_ID IS NULL ";
			}		
			$sthPoolCnt = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlPoolCnt,array());
			$recPoolCnt = $sthPoolCnt->read();
			$poolCount = isset($recPoolCnt['poolcnt'])?$recPoolCnt['poolcnt']:'';
		} else if($param['status'] == 'E'){
			$sqlPoolCnt = "SELECT COUNT(1) POOLCNT FROM ETO_OFR_EXPIRED, ETO_OFR_CALL_VERIFIED 
					WHERE
					ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID 
					";		
			$sthPoolCnt = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlPoolCnt,array());
			$recPoolCnt = $sthPoolCnt->read();
			$poolCount = isset($recPoolCnt['poolcnt'])?$recPoolCnt['poolcnt']:'';		
		}
                
		if($tableType == 1 or $tableType == 2)
		{
		    $sql = "
		    SELECT
			SUBJECT ETO_OFR_TITLE,MESSAGE ETO_OFR_DESC,DIR_QUERY_FREE_QTY ETO_OFR_QTY,DIR_QUERY_QTY_UNIT ETO_OFR_QTY_UNIT,
			3 STATUS,DIR_QUERY_REQ_GEOGRAPHY_ID ETO_OFR_GEOGRAPHY_ID,DIR_QUERY_REQ_APP_USAGE ETO_OFR_REQ_APP_USAGE,
			DIR_QUERY_REQ_APRX_ORDER_VALUE ETO_OFR_APPROX_ORDER_VALUE,DIR_QUERY_CURRENCY_ID ETO_OFR_CURRENCY_ID,
			FK_GL_COUNTRY_ISO,0 ORDR_VL_STATUS,DIR_QUERY_REQ_PURCHASE_PERIOD ETO_OFR_REQ_PURCHASE_PERIOD,
			DIR_QUERY_REQ_GEO_CITY1_ID ETO_OFR_GEO_CITY1_ID,
			DIR_QUERY_REQ_GEO_CITY2_ID ETO_OFR_GEO_CITY2_ID,DIR_QUERY_REQ_GEO_CITY3_ID ETO_OFR_GEO_CITY3_ID,
			DIR_QUERY_REQ_DESTINATION_PORT ETO_OFR_REQ_DESTINATION_PORT,
			DIR_QUERY_REQ_PAYMENT_MODE ETO_OFR_REQ_PAYMENT_MODE,DIR_QUERY_REQ_SHIPMENT_MODE ETO_OFR_REQ_SHIPMENT_MODE,
			ETO_OFR_CALL_VERIFIED,0 ETO_OFR_EMAIL_VERIFIED, DIR_QUERY_ENRICHED_STATUS ETO_OFR_ONLINE_VERIFIED,
			DIR_QUERY_OTHER_DETAIL ETO_OFR_OTHER_DETAIL,
			DIR_QUERY_REQ_FREQUENCY ETO_OFR_REQ_FREQ,DIR_QUERY_REQ_PURPOSE ETO_OFR_REQ_TYPE,
			ETO_ENQ_TYP,ETO_ENQ_PURPOSE, DIR_QUERY_MCATID FK_GLCAT_MCAT_ID,ETO_OFR_APPROV_BY_ORIG EMP_ID
		    FROM DIR_QUERY_FREE
		    WHERE ETO_OFR_DISPLAY_ID= :OFFERID ";		
		} 
		else if($tableType == 3)
		{
		    $sql = "
		    SELECT
			ETO_OFR_TITLE,ETO_OFR_DESC,ETO_OFR_QTY,ETO_OFR_QTY_UNIT,1 STATUS,ETO_OFR_GEOGRAPHY_ID,ETO_OFR_REQ_APP_USAGE,ETO_OFR_APPROX_ORDER_VALUE,ETO_OFR_CURRENCY_ID,FK_GL_COUNTRY_ISO,
                        1 ORDR_VL_STATUS,ETO_OFR_REQ_PURCHASE_PERIOD,ETO_OFR_GEO_CITY1_ID,
			ETO_OFR_GEO_CITY2_ID,ETO_OFR_GEO_CITY3_ID,ETO_OFR_REQ_DESTINATION_PORT,ETO_OFR_REQ_PAYMENT_MODE,ETO_OFR_REQ_SHIPMENT_MODE,ETO_OFR_CALL_VERIFIED,
			ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED,ETO_OFR_OTHER_DETAIL,ETO_OFR_REQ_FREQ,ETO_OFR_REQ_TYPE,ETO_ENQ_TYP,ETO_ENQ_PURPOSE,FK_GLCAT_MCAT_ID,ETO_OFR_APPROV_BY_ORIG EMP_ID
		    FROM ETO_OFR
		    WHERE ETO_OFR_DISPLAY_ID= :OFFERID
		    UNION ALL 
		    SELECT
			ETO_OFR_TITLE,ETO_OFR_DESC,ETO_OFR_QTY,ETO_OFR_QTY_UNIT,2 STATUS,ETO_OFR_GEOGRAPHY_ID,ETO_OFR_REQ_APP_USAGE,ETO_OFR_APPROX_ORDER_VALUE,ETO_OFR_CURRENCY_ID,FK_GL_COUNTRY_ISO,
                        1 ORDR_VL_STATUS,
			ETO_OFR_REQ_PURCHASE_PERIOD,ETO_OFR_GEO_CITY1_ID,ETO_OFR_GEO_CITY2_ID,ETO_OFR_GEO_CITY3_ID,ETO_OFR_REQ_DESTINATION_PORT,ETO_OFR_REQ_PAYMENT_MODE,ETO_OFR_REQ_SHIPMENT_MODE,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,
			ETO_OFR_ONLINE_VERIFIED,ETO_OFR_OTHER_DETAIL,ETO_OFR_REQ_FREQ,ETO_OFR_REQ_TYPE,ETO_ENQ_TYP,ETO_ENQ_PURPOSE,FK_GLCAT_MCAT_ID,ETO_OFR_APPROV_BY_ORIG EMP_ID 
		    FROM ETO_OFR_EXPIRED
		    WHERE ETO_OFR_DISPLAY_ID= :OFFERID
		    UNION ALL 
		    SELECT
			ETO_OFR_TITLE,ETO_OFR_DESC,ETO_OFR_QTY,ETO_OFR_QTY_UNIT,4 STATUS,ETO_OFR_GEOGRAPHY_ID,ETO_OFR_REQ_APP_USAGE,ETO_OFR_APPROX_ORDER_VALUE,ETO_OFR_CURRENCY_ID,FK_GL_COUNTRY_ISO,
                        1 ORDR_VL_STATUS,
			ETO_OFR_REQ_PURCHASE_PERIOD,ETO_OFR_GEO_CITY1_ID,ETO_OFR_GEO_CITY2_ID,ETO_OFR_GEO_CITY3_ID,ETO_OFR_REQ_DESTINATION_PORT,ETO_OFR_REQ_PAYMENT_MODE,ETO_OFR_REQ_SHIPMENT_MODE,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,
			ETO_OFR_ONLINE_VERIFIED,ETO_OFR_OTHER_DETAIL,ETO_OFR_REQ_FREQ,ETO_OFR_REQ_TYPE,ETO_ENQ_TYP,ETO_ENQ_PURPOSE,FK_GLCAT_MCAT_ID,ETO_OFR_DELETEDBYID EMP_ID
		    FROM ETO_OFR_TEMP_DEL
		    WHERE ETO_OFR_DISPLAY_ID= :OFFERID";
		}
		$sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array(':OFFERID'=>$offerId));
                
		$rec1 = $sth->read();
                if($rec1){
                    $rec=array_change_key_case($rec1, CASE_UPPER); 
                }
                
		$ofrStatus = isset($rec['STATUS'])?$rec['STATUS']:'';
		$sql1 = '';
		if($ofrStatus == 2) {
	 		$sql1 = "SELECT
	 			GLUSR_USR.FK_GL_COUNTRY_ISO as FK_GL_COUNTRY_ISO, GLUSR_USR_COUNTRYNAME
	 		FROM
	 			ETO_OFR_EXPIRED,GLUSR_USR 
	 		WHERE
	 		FK_GLUSR_USR_ID=GLUSR_USR_ID AND ETO_OFR_DISPLAY_ID=:OFFERID ";
		} else if($ofrStatus == 3){
			$sql1 = "SELECT
				GLUSR_USR.FK_GL_COUNTRY_ISO as FK_GL_COUNTRY_ISO, GLUSR_USR_COUNTRYNAME
			FROM 
				DIR_QUERY_FREE,GLUSR_USR 
			WHERE
			FK_GLUSR_USR_ID=GLUSR_USR_ID AND ETO_OFR_DISPLAY_ID=:OFFERID ";
		} else if($ofrStatus == 4){
			$sql1 = "SELECT
				GLUSR_USR.FK_GL_COUNTRY_ISO as FK_GL_COUNTRY_ISO, GLUSR_USR_COUNTRYNAME
			FROM 
				ETO_OFR_TEMP_DEL,GLUSR_USR 
			WHERE
			FK_GLUSR_USR_ID=GLUSR_USR_ID AND ETO_OFR_DISPLAY_ID=:OFFERID ";
		} else {
			$sql1 = "SELECT
				GLUSR_USR.FK_GL_COUNTRY_ISO as FK_GL_COUNTRY_ISO, GLUSR_USR_COUNTRYNAME
			FROM 
				ETO_OFR,GLUSR_USR 
			WHERE
			FK_GLUSR_USR_ID=GLUSR_USR_ID AND ETO_OFR_DISPLAY_ID=:OFFERID ";
		}
		$sth1 = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql1,array(':OFFERID'=>$offerId));
		$rec1 = $sth1->read();
        if($rec1){
            $rec_c=array_change_key_case($rec1, CASE_UPPER);
        }
		$cntry_iso = isset($rec_c['FK_GL_COUNTRY_ISO'])?$rec_c['FK_GL_COUNTRY_ISO']:'';
		$cntry_name1 = isset($rec_c['GLUSR_USR_COUNTRYNAME'])?$rec_c['GLUSR_USR_COUNTRYNAME']:'';		

		if($rec && !empty($ofrStatus)) {
                    
			$mysql = "SELECT
				GL_CITY_NAME, GL_STATE_NAME
			FROM
				GL_CITY,GL_STATE
			WHERE
				FK_GL_STATE_ID = GL_STATE_ID AND GL_CITY_ID = :city_id";
			$sth_sql='';
			$rec_sql='';
			$city_id='';
			$loc_city1 = isset($rec['ETO_OFR_GEO_CITY1_ID'])?$rec['ETO_OFR_GEO_CITY1_ID']:'';
			$loc_city2 = isset($rec['ETO_OFR_GEO_CITY2_ID'])?$rec['ETO_OFR_GEO_CITY2_ID']:'';
			$loc_city3 = isset($rec['ETO_OFR_GEO_CITY3_ID'])?$rec['ETO_OFR_GEO_CITY3_ID']:'';
			
			$loc_city1_name = $loc_city2_name = $loc_city3_name = $loc_state1_name = $loc_state2_name = $loc_state3_name = '';
			$cityArr = array();
			if(!empty($loc_city1)) {
				$city_id = $loc_city1;
				$bindParam1[':city_id'] = $city_id;
				$sth_sql = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$mysql,$bindParam1);
				$rec_sql = $sth_sql->read() ;
				$loc_city1_name = isset($rec_sql['gl_city_name'])?$rec_sql['gl_city_name']:'';
				$loc_state1_name = isset($rec_sql['gl_state_name'])?$rec_sql['gl_state_name']:'';
			}
			if(!empty($loc_city2)) {	
				$city_id=$loc_city2;
				$bindParam2[':city_id'] = $city_id;
				$sth_sql = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$mysql,$bindParam2);
				
				$rec_sql = $sth_sql->read();
				$loc_city2_name = isset($rec_sql['gl_city_name'])?$rec_sql['gl_city_name']: '';
				$loc_state2_name = isset($rec_sql['gl_state_name'])?$rec_sql['gl_state_name']:'';
			}
			if($loc_city3)
			{
				$city_id = $loc_city3;
				$bindParam2[':city_id'] = $city_id;
				$sth_sql = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$mysql,$bindParam2);
				
				$rec_sql = $sth_sql->read();
				$loc_city3_name = isset($rec_sql['gl_city_name'])?$rec_sql['gl_city_name']:'';
				$loc_state3_name = isset($rec_sql['gl_state_name'])?$rec_sql['gl_state_name']:'';
			}
			$cityArr = array(
					"loc_city1_name" => $loc_city1_name,
					"loc_state1_name" =>$loc_state1_name,
					"loc_city2_name" => $loc_city2_name,
					"loc_state2_name" => $loc_state2_name,
					"loc_city3_name" => $loc_city3_name,
					"loc_state3_name" => $loc_state3_name,
					"loc_city1" => $loc_city1,
					"loc_city2" => $loc_city2,
					"loc_city3" => $loc_city3,
			);
		
		$result = array(
			"offerId" => $offerId,
			"ofrStatus" => $ofrStatus,
			"cntry_iso" => $cntry_iso,
			"cntry_name1" => $cntry_name1,
			"cityArr" => $cityArr,
			"rec" => $rec,
			"poolData" => $poolData,
			"poolFlag" => $poolFlag,
			"status" => $param['status'],
			"bl_wait_pool_id" => $param['bl_wait_pool_id'],
			"poolCount" => $poolCount,
			"start" => $start,
			"totalOffers" => $totalOffers,
			"blType" => $blType,
			"tableType" => $tableType,
		);
	}
	return $result;
	}
	
    public function updateCallData($request,$model,$resultArr,$mcat_id) 
    {
            $obj = new Globalconnection();
            $dbhW = $obj->connectPostgres_wrt();
            $fieldsArr = array();
            $ofrId = $request->getParam('offer',0);
            $bl_wait_pool_id = $request->getParam('bl_wait_pool_id','');
            $status = $request->getParam('status','');
            $blType = $request->getParam('bltype','1');
            $tableType = $request->getParam('tabletype','3');
            $delcallverify = $request->getParam('delcallverify','');
            $update_enrichdetail = '';$delQuery = "";$enrichFlag = 0;
            $blType = (empty($tableType) || $tableType == 3) ? 1 : 2;

            $empId = Yii::app()->session['empid'];
            if(!empty($empId) && $empId > 0){
		if($status != 'E' && empty($delcallverify)){
		$tableName = array(
			1 => 'ETO_OFR',
			2 => 'DIR_QUERY_FREE'		
		);
		$tableName = $tableName[$blType];
		$update_enrichdetail = "UPDATE $tableName SET ";
		if(isset($_REQUEST['order_value_original']) and isset($_REQUEST['ETO_OFR_APPROX_ORDER_VALUE']) and !empty($_REQUEST['order_value_original']) and ($_REQUEST['ETO_OFR_APPROX_ORDER_VALUE']=='--Select Order Value--' or empty($_REQUEST['ETO_OFR_APPROX_ORDER_VALUE'])))
		{
		$fieldName = array(
			1 => array('ETO_OFR_REQ_APP_USAGE'=>'ETO_OFR_REQ_APP_USAGE',
			'ETO_OFR_OTHER_DETAIL'=>'ETO_OFR_OTHER_DETAIL',
			'ETO_OFR_GEOGRAPHY_ID'=>'ETO_OFR_GEOGRAPHY_ID',
			'ETO_OFR_REQ_PURCHASE_PERIOD'=>'ETO_OFR_REQ_PURCHASE_PERIOD',
			'ETO_OFR_REQ_TYPE'=>'ETO_OFR_REQ_TYPE',
			'ETO_OFR_REQ_FREQ'=>'ETO_OFR_REQ_FREQ',
			'ETO_ENQ_PURPOSE'=>'ETO_ENQ_PURPOSE',
			'ETO_ENQ_TYP'=>'ETO_ENQ_TYP',
			'ETO_OFR_REQ_DESTINATION_PORT'=>'ETO_OFR_REQ_DESTINATION_PORT',
			'ETO_OFR_REQ_SHIPMENT_MODE'=>'ETO_OFR_REQ_SHIPMENT_MODE',
			'ETO_OFR_REQ_PAYMENT_MODE'=>'ETO_OFR_REQ_PAYMENT_MODE',),
			
			2 => array('ETO_OFR_REQ_APP_USAGE'=>'DIR_QUERY_REQ_APP_USAGE',
			'ETO_OFR_OTHER_DETAIL'=>'DIR_QUERY_OTHER_DETAIL',
			'ETO_OFR_APPROX_ORDER_VALUE'=>'ETO_OFR_APPROX_ORDER_VAL_ORIG',
			'ETO_OFR_CURRENCY_ID'=>'DIR_QUERY_CURRENCY_ID',
			'ETO_OFR_GEOGRAPHY_ID'=>'DIR_QUERY_REQ_GEOGRAPHY_ID',
			'ETO_OFR_REQ_PURCHASE_PERIOD'=>'DIR_QUERY_REQ_PURCHASE_PERIOD',
			'ETO_OFR_REQ_TYPE'=>'DIR_QUERY_REQ_PURPOSE',
			'ETO_OFR_REQ_FREQ'=>'DIR_QUERY_REQ_FREQUENCY',
			'ETO_ENQ_PURPOSE'=>'ETO_ENQ_PURPOSE',
			'ETO_ENQ_TYP'=>'ETO_ENQ_TYP',
			'ETO_OFR_REQ_DESTINATION_PORT'=>'DIR_QUERY_REQ_DESTINATION_PORT',
			'ETO_OFR_REQ_SHIPMENT_MODE'=>'DIR_QUERY_REQ_SHIPMENT_MODE',
			'ETO_OFR_REQ_PAYMENT_MODE'=>'DIR_QUERY_REQ_PAYMENT_MODE',)
		);
		}
		else
		{
		$fieldName = array(
			1 => array('ETO_OFR_REQ_APP_USAGE'=>'ETO_OFR_REQ_APP_USAGE',
			'ETO_OFR_OTHER_DETAIL'=>'ETO_OFR_OTHER_DETAIL',
			'ETO_OFR_APPROX_ORDER_VALUE'=>'ETO_OFR_APPROX_ORDER_VALUE',
			'ETO_OFR_CURRENCY_ID'=>'ETO_OFR_CURRENCY_ID',
			'ETO_OFR_GEOGRAPHY_ID'=>'ETO_OFR_GEOGRAPHY_ID',
			'ETO_OFR_REQ_PURCHASE_PERIOD'=>'ETO_OFR_REQ_PURCHASE_PERIOD',
			'ETO_OFR_REQ_TYPE'=>'ETO_OFR_REQ_TYPE',
			'ETO_OFR_REQ_FREQ'=>'ETO_OFR_REQ_FREQ',
			'ETO_ENQ_PURPOSE'=>'ETO_ENQ_PURPOSE',
			'ETO_ENQ_TYP'=>'ETO_ENQ_TYP',
			'ETO_OFR_REQ_DESTINATION_PORT'=>'ETO_OFR_REQ_DESTINATION_PORT',
			'ETO_OFR_REQ_SHIPMENT_MODE'=>'ETO_OFR_REQ_SHIPMENT_MODE',
			'ETO_OFR_REQ_PAYMENT_MODE'=>'ETO_OFR_REQ_PAYMENT_MODE',),
			
			2 => array('ETO_OFR_REQ_APP_USAGE'=>'DIR_QUERY_REQ_APP_USAGE',
			'ETO_OFR_OTHER_DETAIL'=>'DIR_QUERY_OTHER_DETAIL',
			'ETO_OFR_APPROX_ORDER_VALUE'=>'ETO_OFR_APPROX_ORDER_VAL_ORIG',
			'ETO_OFR_CURRENCY_ID'=>'DIR_QUERY_CURRENCY_ID',
			'ETO_OFR_GEOGRAPHY_ID'=>'DIR_QUERY_REQ_GEOGRAPHY_ID',
			'ETO_OFR_REQ_PURCHASE_PERIOD'=>'DIR_QUERY_REQ_PURCHASE_PERIOD',
			'ETO_OFR_REQ_TYPE'=>'DIR_QUERY_REQ_PURPOSE',
			'ETO_OFR_REQ_FREQ'=>'DIR_QUERY_REQ_FREQUENCY',
			'ETO_ENQ_PURPOSE'=>'ETO_ENQ_PURPOSE',
			'ETO_ENQ_TYP'=>'ETO_ENQ_TYP',
			'ETO_OFR_REQ_DESTINATION_PORT'=>'DIR_QUERY_REQ_DESTINATION_PORT',
			'ETO_OFR_REQ_SHIPMENT_MODE'=>'DIR_QUERY_REQ_SHIPMENT_MODE',
			'ETO_OFR_REQ_PAYMENT_MODE'=>'DIR_QUERY_REQ_PAYMENT_MODE',)
		);
		
		}
		$fieldName1 = array(
		1 => array('city1'=>'ETO_OFR_GEO_CITY1_ID',
			'city2'=>'ETO_OFR_GEO_CITY2_ID',
			'city3'=>'ETO_OFR_GEO_CITY3_ID'),
		2 => array('city1'=>'DIR_QUERY_REQ_GEO_CITY1_ID',
			'city2'=>'DIR_QUERY_REQ_GEO_CITY2_ID',
			'city3'=>'DIR_QUERY_REQ_GEO_CITY3_ID')
		);
			$quantFieldName = array(
				1 => array('ETO_OFR_TITLE'=>'ETO_OFR_TITLE',
				'ETO_OFR_DESC'=>'ETO_OFR_DESC',
				'ETO_OFR_QTY'=>'ETO_OFR_QTY',
				'ETO_OFR_QTY_UNIT'=>'ETO_OFR_QTY_UNIT',), 
				2 => array('ETO_OFR_TITLE'=>'SUBJECT',
				'ETO_OFR_DESC'=>'MESSAGE',
				'ETO_OFR_QTY'=>'DIR_QUERY_FREE_QTY',
				'ETO_OFR_QTY_UNIT'=>'DIR_QUERY_QTY_UNIT',)
			);
			
		
			$fieldName = $fieldName[$blType];
			$fieldName1 = $fieldName1[$blType];
			$quantFieldName = $quantFieldName[$blType];
			foreach ($fieldName as $keys=>$val) {
			$var1 = $request->getParam($keys);
			$var1 = preg_replace("/'/","''", $var1);
			if(!empty($var1)){			
				$enrichFlag = 1;
			}			
			//$var1 =~ s/^\s+|\s+$//g;
			if($keys == 'ETO_OFR_REQ_FREQ' && $var1 == 2){
					$var1 = $request->getParam('reg_req_list');		
				}
			array_push($fieldsArr," ".$fieldName[$keys] ."='".$var1."'");
				if($keys == 'ETO_OFR_GEOGRAPHY_ID')
				{
					foreach ($fieldName1 as $k1 => $r1) 
						{
						$var = $request->getParam($k1);
						$var = preg_replace("/'/","''", $var);
						array_push($fieldsArr," ".$fieldName1[$k1]."='".$var."'");
					}
				}
				
			}
			$qtyOther = $request->getParam('ETO_OFR_QTY_UNIT_OTHER','');
			
			$emailVerified = "";
		if(!empty($bl_wait_pool_id)) {
			$qtyUnit = $request->getParam('ETO_OFR_QTY_UNIT',''); $qtyUnit = trim($qtyUnit);
			$qty = $request->getParam('ETO_OFR_QTY','');				$qty = trim($qty);

					foreach ($quantFieldName as $q1 => $rQ1) 
					{
						$var1 = $request->getParam($q1);
						if($q1 == 'ETO_OFR_QTY_UNIT' && $var1 == 'Others'){
							$var1 = $qtyOther;					
						}
						$var1 = preg_replace("/'/","''", $var1);
						$var1 = trim($var1);
						array_push($fieldsArr," ".$quantFieldName[$q1]."='".$var1."'");
					}
					if($enrichFlag == 1){
						$emailVerified = " , ETO_OFR_EMAIL_VERIFIED = 2 , ETO_OFR_EMAIL_UPDATE_DATE = SYSDATE ";
					}
		}
	
	$empName =Yii::app()->session['empname'];
	
	$fields =  join(',',$fieldsArr);
	$histFields = ", ETO_OFR_HIST_BY = '$empName' ,ETO_OFR_HIST_USING = 'GLAdmin - Update Enrichment Details',
	ETO_OFR_HIST_IP_COUNTRY = 'India',ETO_OFR_HIST_IP = '', ETO_OFR_HIST_EMP_ID=$empId ";
	$update_enrichdetail  .= " ".$fields.$histFields.$emailVerified." where ETO_OFR_DISPLAY_ID=".$ofrId.";";
	}
        
	try{
		$sth_sql = pg_query($dbhW,$update_enrichdetail); 
                if($delQuery<>''){
                    $sth_sql = pg_query($dbhW,$delQuery); 
                }
	}catch(Exception $e){}
	##Set ISQ Service
	
	$arrayQid=array();
	$arrayQdesc=array();
	$arrayBresponce=array();
	$arrayOptionid=array();
	
        $flag=isset($_REQUEST['flag']) ? $_REQUEST['flag'] : '';
        
        $quantity_masterId=isset($_REQUEST['quantity_masterId']) ? $_REQUEST['quantity_masterId'] : '';
        if(!empty($quantity_masterId))
        {
         $quantity_optionId=isset($_REQUEST['quantity_optionId']) ? $_REQUEST['quantity_optionId'] : '';
         $quantity_ques_desc='Quantity';
         $quantity_ans=isset($_REQUEST["ques$quantity_masterId"]) ? $_REQUEST["ques$quantity_masterId"] : '';
         
         array_push($arrayQid,$quantity_masterId);
         array_push($arrayQdesc,$quantity_ques_desc);
         array_push($arrayBresponce,$quantity_ans);
         array_push($arrayOptionid,$quantity_optionId);
        }
        
        $quantityUnit_masterId=isset($_REQUEST['quantityUnit_masterId']) ? $_REQUEST['quantityUnit_masterId'] : '';
        if(!empty($quantityUnit_masterId))
        {
          $quantityUnit_ans=isset($_REQUEST["ques$quantityUnit_masterId"]) ? $_REQUEST["ques$quantityUnit_masterId"] : '';
          $quantity_quesUnit_desc='Quantity Unit';
          $quantityUnit_ans=explode(';',$quantityUnit_ans);
           
         array_push($arrayQid,$quantityUnit_masterId);
         array_push($arrayQdesc,$quantity_quesUnit_desc);
         array_push($arrayBresponce,$quantityUnit_ans[0]);
         array_push($arrayOptionid,$quantityUnit_ans[1]);
        }
        
        $productapp_masterid=isset($_REQUEST['productapp_masterid']) ? $_REQUEST['productapp_masterid'] : '';
        if(!empty($productapp_masterid))
        {
        $productapp_optionId=isset($_REQUEST['productapp_responseId']) ? $_REQUEST['productapp_responseId'] : '';
        $productapp_quesdesc='Usage/Application';
        $Usageapp_ans=isset($_REQUEST["ques$productapp_masterid"]) ? $_REQUEST["ques$productapp_masterid"] : '';
         
         array_push($arrayQid,$productapp_masterid);
         array_push($arrayQdesc,$productapp_quesdesc);
         array_push($arrayBresponce,$Usageapp_ans);
         array_push($arrayOptionid,$productapp_optionId);
        }
        
        $approx_order_masterid=isset($_REQUEST['approx_order_masterid']) ? $_REQUEST['approx_order_masterid'] : '';
        
        if(!empty($approx_order_masterid))
        {
          $approx_order_valueIn=array('100.0'=>'Upto 1,000','200.0'=>'1,000 to 3,000','300.0'=>'3,000 to 10,000','400.0'=>'10,000 to 20,000','500.0'=>'20,000 to 50,000','600.0'=>'50,000 to 1 Lakh','700.0'=>'1 to 2 Lakh','800.0'=>'2 to 5 Lakh','900.0'=>'5 to 10 Lakh','1000.0'=>'10 to 20 Lakh','1100.0'=>'20 to 50 Lakh','1200.0'=>'50 Lakh to 1 Crore','1300.0'=>'More than 1 Crore','100'=>'Upto 1,000','200'=>'1,000 to 3,000','300'=>'3,000 to 10,000','400'=>'10,000 to 20,000','500'=>'20,000 to 50,000','600'=>'50,000 to 1 Lakh','700'=>'1 to 2 Lakh','800'=>'2 to 5 Lakh','900'=>'5 to 10 Lakh','1000'=>'10 to 20 Lakh','1100'=>'20 to 50 Lakh','1200'=>'50 Lakh to 1 Crore','1300'=>'More than 1 Crore');
	  $approx_order_valuefrn=array('100.0'=>'Upto 1,000','200.0'=>'1,000 to 3,000','300.0'=>'3,000 to 10,000','400.0'=>'10,000 to 20,000','500.0'=>'20,000 to 50,000','600.0'=>'50000 to 0.1 Million','700.0'=>'0.1 to 0.2 Million','800.0'=>'0.2 to 0.5 Million','900.0'=>'0.5 to 1 Million','1000.0'=>'1 to 2 Million','1100.0'=>'2 to 5 Million','1200.0'=>'5 to 10 Million','1300.0'=>'More than 10 Million','100'=>'Upto 1,000','200'=>'1,000 to 3,000','300'=>'3,000 to 10,000','400'=>'10,000 to 20,000','500'=>'20,000 to 50,000','600'=>'50000 to 0.1 Million','700'=>'0.1 to 0.2 Million','800'=>'0.2 to 0.5 Million','900'=>'0.5 to 1 Million','1000'=>'1 to 2 Million','1100'=>'2 to 5 Million','1200'=>'5 to 10 Million','1300'=>'More than 10 Million');
	 
	 $approx_order_ans=isset($_REQUEST["ques$approx_order_masterid"]) ? $_REQUEST["ques$approx_order_masterid"] : '';
          $approx_order_ans=explode(';',$approx_order_ans);
			    if($approx_order_ans[1]=='IN')
			    {
			     $answers3=$approx_order_valueIn[$approx_order_ans[0]];
			    }
			    else
			    {
			     $answers3=$approx_order_valuefrn[$approx_order_ans[0]];
			    }
			    
	 $approx_order_ques_desc='Approximate Order Value';		    
         array_push($arrayQid,$approx_order_masterid);
         array_push($arrayQdesc,$approx_order_ques_desc);
         array_push($arrayBresponce,$answers3);
         array_push($arrayOptionid,$approx_order_ans[2]);			    
			    
        }
        
        $currencyMasterId=isset($_REQUEST['currencyMasterId']) ? $_REQUEST['currencyMasterId'] : '';
        if(!empty($currencyMasterId))
        {
         $currencyArr=array('1'=>'INR','1.0'=>'INR','2'=>'USD','2.0'=>'USD','3'=>'GBP','3.0'=>'GBP','4'=>'EUR','4.0'=>'EUR','5'=>'AUD','5.0'=>'AUD','6'=>'CAD','6.0'=>'CAD','7'=>'CHF','7.0'=>'CHF','8'=>'PY','8.0'=>'PY','9'=>'HKD','9.0'=>'HKD','10'=>'NZD','10.0'=>'NZD','11'=>'SGD','11.0'=>'SGD','12'=>'NTD','12.0'=>'NTD','13'=>'RMB','13.0'=>'RMB');
         
         $currency_ans=isset($_REQUEST["ques$currencyMasterId"]) ? $_REQUEST["ques$currencyMasterId"] : '';
         $currency_ans=explode(';',$currency_ans);
         $currency_ques_desc='Currency';
         array_push($arrayQid,$currencyMasterId);
         array_push($arrayQdesc,$currency_ques_desc);
         array_push($arrayBresponce,$currencyArr[$currency_ans[0]]);
         array_push($arrayOptionid,$currency_ans[1]);
         
        }
		
		$ques_size=isset($_REQUEST['ques_size']) ? $_REQUEST['ques_size'] : 0;
		$uniqueNess=isset($_REQUEST['uniqueNess']) ? $_REQUEST['uniqueNess'] : 0;

		$qIds=isset($_REQUEST['quesIds']) ? $_REQUEST['quesIds'] : '';	
		$qIdsCountArray = array_count_values(explode(',', $qIds));
		$customISQCnt = isset($qIdsCountArray['-1'])? $qIdsCountArray['-1'] : 0;
		$customISQCounter = 0;
		for($i=1;$i<=$ques_size;$i++)
		{
			$type=isset($_REQUEST["ques_type_$i"]) ? $_REQUEST["ques_type_$i"] : '';
			$ques_master_id=isset($_REQUEST["ques_master_id_$i"]) ? $_REQUEST["ques_master_id_$i"] : '';
			$ques_desc=isset($_REQUEST["ques_desc_$i"]) ? $_REQUEST["ques_desc_$i"] : '';

			$index = 0;

			if($uniqueNess == "Same"){
			$index = $i-1;
			}elseif($uniqueNess == "Mixed"){
				if($ques_master_id == -1){
					if($customISQCnt > 1){
						$index = $customISQCounter;
						$customISQCounter++;
					}	
				}
			}

			if($type ==1)
			{	
				$ans=isset($_REQUEST["ques$ques_master_id"]["$index"]) ? $_REQUEST["ques$ques_master_id"]["$index"] : '';
				$opt_id=isset($_REQUEST["ques_options_id_$i"]) ? $_REQUEST["ques_options_id_$i"] : '';

				array_push($arrayQid,$ques_master_id);
				array_push($arrayQdesc,$ques_desc);
				array_push($arrayBresponce,$ans);
				array_push($arrayOptionid,$opt_id);
			}

			if($type==2 || $type==3)
			{
				$ans=isset($_REQUEST["ques$ques_master_id"][$index]) ? $_REQUEST["ques$ques_master_id"][$index] : '';
				$ans=explode(';',$ans);

				array_push($arrayQid,$ques_master_id);
				array_push($arrayQdesc,$ques_desc);
				array_push($arrayBresponce,$ans[0]);
				array_push($arrayOptionid,$ans[1]);
			}

			if($type ==4)
			{			
				$othersOptionId = isset($_REQUEST["othersOptionId_$i"]) ? $_REQUEST["othersOptionId_$i"] : '';		
				$othersValue = isset($_REQUEST["others_$i"]) ? $_REQUEST["others_$i"]: '';	

				$opt_size=isset($_REQUEST["total_opt_$i"]) ? $_REQUEST["total_opt_$i"] : 0;
				$ques_master_id=isset($_REQUEST["ques_master_id_$i"]) ? $_REQUEST["ques_master_id_$i"] : '';
				$ques_desc=isset($_REQUEST["ques_desc_$i"]) ? $_REQUEST["ques_desc_$i"] : '';
				$ans=isset($_REQUEST["check_opt_$i"]) ? $_REQUEST["check_opt_$i"] : array();
				$array_termp=array();
				foreach($ans as $temp)
				{
					$temp1=explode(';',$temp);
					$array_termp[$temp1[1]]=$temp1[0];
				}

				for($j=1;$j<=$opt_size;$j++)
				{
					$opt_id=isset($_REQUEST["checkbox_opt_$i"."_$j"]) ? $_REQUEST["checkbox_opt_$i"."_$j"] : '';

					array_push($arrayQid,$ques_master_id);
					array_push($arrayQdesc,$ques_desc);
					if(array_key_exists($opt_id,$array_termp))
					{
						if($othersOptionId != $opt_id){
							array_push($arrayBresponce,$array_termp[$opt_id]);
						}
						else{
							$arrTempValue = $array_termp[$opt_id];
							$othersResp = ($othersValue != '' ? $othersValue: $arrTempValue);
							array_push($arrayBresponce,$othersResp);
						}			
					}
					else
					{
						array_push($arrayBresponce,"");
					}
					array_push($arrayOptionid,$opt_id);
				}	    
			}
		}
       

	if($flag)
	{
	$update=1;
	}
	else
	{
	$update=0;
	}
	if(!empty($arrayQid))
	{
	if($mcat_id >0){
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
	{
	  $url="http://stg-service.intermesh.net/blsetisq";
               }else
	{
          $url="http://leads.imutils.com/wservce/leads/blsetisq/";  
	}
	$content = array(
		"VALIDATION_KEY" => "3245abd21ccaf37b137062f7ccc81269",
		"UPDATEDBY" => "ISQ",
		"UPDBY_NAME"=>$empName,
		"UPDBY_ID"=>$empId,
		"ofr_id"=>$ofrId,
		"q_id"=>$arrayQid,
		"q_desc"=>$arrayQdesc,
		"b_response"=>$arrayBresponce,
		"b_id"=>$arrayOptionid,
		"mcat_id"=>$mcat_id,
		"UPDATESCREEN"=>'GLAdmin (Edit BL ISQ screen)',
		"update"=>$update
	);
               $ServiceGlobalModelForm = new ServiceGlobalModelForm();
               $dataHash = $ServiceGlobalModelForm->mapiService('BLGETISQ',$url,$content);                
                if(!empty($dataHash) && $dataHash['CODE'] == 200)
                 {
                   if($status != 'E' && !empty($delcallverify) && $blType != 2){
                       $this->syncEtoOfrVerifiedFlg('' ,'',$ofrId,$model);
                     }
                       return "SUCCESS";

                 }
                elseif(!empty($dataHash) && $dataHash['CODE'] != 200)
                {
                        $http_status=$dataHash['CODE'];
                        $msg=$url." Patameter- offerid:$ofrId and mcatid:$mcat_id CODE:".$http_status;
             }
	
	}
	}
        }
}

	
	public function callVerify($dbh,$param,$model){
		$offerId = $param['offerId'];
		$bl_wait_pool_id = $param['bl_wait_pool_id'];
		$status = $param['status'];
		$move = $param['move'];
		$eto_ofr = 'ETO_OFR';
		
		if(!empty($status) && $status == 'E') {
			$eto_ofr='ETO_OFR_EXPIRED';
		}
		$main_sql= 'SELECT ';
		
		$main_sql1=$main_sql;
		$bindParam = array();
		$bindParam1 = array();
		$bindParam2 = array();
		
		$countCond = '';
		if($move == 'next'){
			$main_sql.= 'MAX(ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID)';
			$main_sql1.= 'MIN(ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID)';
		} else if($move == 'prev'){
			$main_sql.= 'MIN(ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID)';
		} else if($move == 'first'){
			$main_sql.= 'MAX(ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID)';
		} else if($move == 'last'){
			$main_sql.= 'MIN(ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID)';
		}else if($move == 'same'){
			$main_sql.= 'ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID';
		}else {
			$main_sql.= 'MAX(ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID)';
		}
		$main_sql.= " OFRID FROM ETO_OFR_CALL_VERIFIED, $eto_ofr";
		$main_sql1.= " OFRID FROM ETO_OFR_CALL_VERIFIED, $eto_ofr";
		
		if(!empty($offerId) && ($move == 'next'))
		{
			$main_sql.= " WHERE ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID < :offerId AND ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = ".$eto_ofr.".ETO_OFR_DISPLAY_ID";
			$main_sql1.= " WHERE ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID > :offerId AND ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = ".$eto_ofr.".ETO_OFR_DISPLAY_ID";
			$bindParam[':offerId'] = $offerId;
			$bindParam1[':offerId'] = $offerId;
		} else if(!empty($offerId) && ($move == 'prev'))
		{
			$main_sql.= " WHERE ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID > $offerId AND ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = ".$eto_ofr.".ETO_OFR_DISPLAY_ID";
			$bindParam[':offerId'] = $offerId;
		} else if(!empty($offerId) && ($move == 'same'))
		{
			$main_sql.= " WHERE ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = $offerId AND ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = ".$eto_ofr.".ETO_OFR_DISPLAY_ID";
			$bindParam[':offerId'] = $offerId;
		} else{
			$main_sql.= " WHERE ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = ".$eto_ofr.".ETO_OFR_DISPLAY_ID";
		}
		if($status && $status != 'E')	 {
			$main_sql.= " AND ".$eto_ofr.".ETO_OFR_APPROV =:status";
			$main_sql1.= " AND ".$eto_ofr.".ETO_OFR_APPROV =:status";
			$countCond.= " AND ".$eto_ofr.".ETO_OFR_APPROV =:status";
			
			$bindParam[':status'] = '"'.$status.'"';
			$bindParam1[':status'] = '"'.$status.'"';
			$bindParam2[':status'] = '"'.$status.'"';
		}
		
		if(!empty($bl_wait_pool_id) && $bl_wait_pool_id >= 1 && $bl_wait_pool_id <= 6) {
			$main_sql.= " AND ".$eto_ofr.".ETO_OFR_BUY_WAITING_POOL_ID IS NOT NULL ";
			$main_sql1.=" AND ".$eto_ofr.".ETO_OFR_BUY_WAITING_POOL_ID IS NOT NULL ";
			$countCond.=" AND ".$eto_ofr.".ETO_OFR_BUY_WAITING_POOL_ID IS NOT NULL ";
		} else if(!empty($bl_wait_pool_id) && $bl_wait_pool_id == -1) {
			$main_sql.=" AND ".$eto_ofr.".ETO_OFR_BUY_WAITING_POOL_ID IS NULL ";
			$main_sql1.=" AND ".$eto_ofr.".ETO_OFR_BUY_WAITING_POOL_ID IS NULL ";
			$countCond.=" AND ".$eto_ofr.".ETO_OFR_BUY_WAITING_POOL_ID IS NULL ";
		}
		$sth_main = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$main_sql,$bindParam);
		$offerId1 = 0;
		while($rec_main = $sth_main->read()){
			$offerId1 = isset($rec_main['ofrid'])?$rec_main['ofrid']:0;
		}
		$offerId = $offerId1;
		
		if(empty($offerId))  {
			if($move == 'next') {			
				$sth_main1 = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$main_sql1,$bindParam1);
				$ofrId=0;
				while($rec_main1 = $sth_main1->read()) {
					$ofrId = isset($rec_main1['ofrid'])?$rec_main1['ofrid']:0;
				} 
				$offerId=$ofrId;
			} 
			if (empty($offerId))  { 
				echo "No Offer Found";
				exit;
			}
		}
		$bindParam2[':offerId'] = $offerId;
		$sql_start= "SELECT COUNT(distinct ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID) ST 
			FROM 
		ETO_OFR_CALL_VERIFIED, $eto_ofr 
			WHERE 
		ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID > :offerId AND ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = ".$eto_ofr.".ETO_OFR_DISPLAY_ID".$countCond;
			
		$sth_start = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql_start,$bindParam2);
		$rec_start = $sth_start->read();                
		$start = isset($rec_start['st'])?$rec_start['st']:0;
		
		unset($bindParam2[':offerId']);
		$sql_count= " SELECT COUNT(DISTINCT ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID) TOT 
			FROM 
		ETO_OFR_CALL_VERIFIED, $eto_ofr 
			WHERE 
		ETO_OFR_CALL_VERIFIED.ETO_OFR_DISPLAY_ID = ".$eto_ofr.".ETO_OFR_DISPLAY_ID".$countCond;
			
		$sth_count = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql_count,$bindParam2);
		$rec_count = $sth_count->read();
		$totalOffers = isset($rec_count['tot'])?$rec_count['tot']:0;
		
		$sql_verify = "
	SELECT
                ETO_OFR_DISPLAY_ID,
                ETO_OFR_TITLE_UPDATED TITLE_UPDATED,
                ETO_OFR_DESC_UPDATED DESC_UPDATED,
                ETO_OFR_QTY_UPDATED QTY_UPDATED,		
                ETO_OFR_REQ_FREQ REQ_FREQ_UPDATED,
                ETO_OFR_REQ_TYPE_PERIOD REQ_FREQUENCY_UPDATED,
                ETO_OFR_REQ_TYPE REQ_TYPE_UPDATED,
                ETO_OFR_ENQ_TYPE ENQ_TYPE_UPDATED,                
                ETO_OFR_PAY_TERM_UPDATED PAY_TERM_UPDATED,
                ETO_OFR_SHIPP_TERM SHIP_TERM_UPDATED,
		ETO_OFR_PREF_DEST_PORT DEST_PORT_UPDATED,
                ETO_OFR_OTHR_DETAIL OTHER_DETAILS_UPDATED,
                ETO_OFR_REQ_APP REQ_APP_UPDATED,
		ETO_OFR_GEOGRAPHY_ID GEOGRAPHY_ID_UPDATED,
                ETO_OFR_LOCPREF_CITY1_ID CITY1_UPDATED, 
                ETO_OFR_LOCPREF_CITY2_ID CITY2_UPDATED,
                ETO_OFR_LOCPREF_CITY3_ID CITY3_UPDATED
        FROM
                ETO_OFR_CALL_VERIFIED
        WHERE 
		ETO_OFR_DISPLAY_ID = :offerId";
	$sql_verify.= " AND ROWNUM < 2";

	$sth_verify = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql_verify,array(':offerId' => $offerId));
	$rec_verify = "";
	$rec_verify1=$sth_verify->read();
	if($rec_verify1){
            $rec_verify=array_change_key_case($rec_verify1, CASE_UPPER); 
        }
	$returnArr = array(
		"offerId" => $offerId,
		"start" => $start,
		"totalOffers" => $totalOffers,
		"rec_verify" => $rec_verify
			
	);	
	return $returnArr;
	}
	
      public function catMcatMapping($dbh,$dbh_mainAlrt,$model,$offerID,$new_catID,$new_mcats,$prime_mcat,$emp_id)
	{     
        $obj = new Globalconnection();
        $dbhpg = $obj->connect_db_yii('postgress_web68v');      
	$del_flag = 0; $map_flag = 1; $status = 0;
	$old_cats = ''; $old_mcats = '';$old_prime_mcat = '';
	$queryVal1= "Offer=$offerID\nnew_catID=$new_catID\nnew_mcats=$new_mcats\nprime_mcat=$prime_mcat\nmap_flag=$map_flag\ndel_flag=$del_flag\nemp_id=$emp_id";
        
	$new_mcats = preg_replace('/\s/', '', $new_mcats);
        
	if(!empty($new_mcats)) {
		$new_catID = '';
		$prime_mcat = ($prime_mcat == 0)?$new_mcats:$prime_mcat;
	}

		$sql = "SELECT
                    COUNT(1) CNT,
                    string_agg(FK_GLCAT_CAT_ID::text,',') OLD_CAT_IDS,
                    string_agg(FK_GLCAT_MCAT_ID::text,',') OLD_MCAT_IDS,
                    MAX(PRIME_MCAT) OLD_PRIME_MCAT
                    FROM
                    ETO_OFR_MAPPING
                    WHERE
                    FK_ETO_OFR_ID = :offerID
                    GROUP BY
                    FK_ETO_OFR_ID";
		$sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbhpg,$sql,array(':offerID' => $offerID));
		$mapExist = $sth->read();
		

	if(!empty($mapExist))
	{
		$old_cats = isset($mapExist['old_cat_ids'])?$mapExist['old_cat_ids']:'';
		$old_mcats = isset($mapExist['old_mcat_ids'])?$mapExist['old_mcat_ids']:'';
		$old_prime_mcat = isset($mapExist['old_prime_mcat'])?$mapExist['old_prime_mcat']: '';

		if(!empty($old_mcats))
		{
			$del_flag = 1;
			if(!empty($new_mcats))
			{
				$newM = preg_split('/,/',$new_mcats);
				$oldM = preg_split('/,/',$old_mcats);				
				$len1 = count($newM);  $len2 = count($oldM);  $diff = 0;

				if($len1 != $len2)
				{
					$diff = 1;
				}
				else
				{
					$diff = array_merge(array_diff($newM, $oldM), array_diff($oldM, $newM));
					$diff = count($diff);
				}
				$map_flag = ($diff == 0)?0:$map_flag;

				if($map_flag == 0 && $old_prime_mcat == $prime_mcat)
				{
					$prime_mcat = 0;
				}
			}
		}
		else if(!empty($new_mcats))
		{
			$del_flag = 1;
		}
		else if(!empty($old_cats))
		{
			$del_flag = 1;
			$map_flag = ($old_cats == $new_catID)?0:$map_flag;
		}
		$del_flag = ($map_flag == 0)?0 : $del_flag;
	}

                        $param['token']	='imobile1@15061981';
                        $param['modid']	='GLADMIN';
                        $param['FK_ETO_OFR_ID']=$offerID;
                        $param['ADD_CAT_ID']=$new_catID;                        
                        $param['ADD_MCAT_IDS']=$new_mcats;
                        $param['NEW_PRIME_MCAT']=$prime_mcat;
                        $param['MAP_FLAG']=$map_flag;
                        $param['DEL_FLAG']=$del_flag;
                        $param['EMPID']=$emp_id;
                        $param['STATUS']=$status;
                        $param['action']='PROC_CALL';
                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                                $curl = 'http://dev-leads.imutils.com/wservce/leads/ofrmapping/';
                                }else{                        
                                $curl = 'http://leads.imutils.com/wservce/leads/ofrmapping/';
                                }
                        $serv_model =new ServiceGlobalModelForm();
                        $response=$serv_model->mapiService('OFRMAPPING',$curl,$param,'Yes');
                         $empId = Yii::app()->session['empid'];
		
                        if($response['Response']['Code']==200){
                            $response="Success";
                        }else{
                             $input = http_build_query($param);
                             $output = json_encode($response);
                            $response="Some Error occured";
                        }				
			return $status;
	}
	
	public function getManualGroupList($model)
	{
	$request = Yii::app()->request;
	$obj = new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
	$grpid = $request->getParam('grpid',0);
	$catid = $request->getParam('catid',0);

	if(!empty($catid))
        {
                $sql = "SELECT GLCAT_MCAT_ID, GLCAT_MCAT_NAME FROM GLCAT_CAT_TO_MCAT, GLCAT_MCAT WHERE FK_GLCAT_MCAT_ID = GLCAT_MCAT_ID AND FK_GLCAT_CAT_ID = :CAT_ID ORDER BY GLCAT_MCAT_NAME";		
		$sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array(":CAT_ID" => $catid));
                $x='';
                $count=0;
		while($h = $sth->read() )               
                {
                        $count++;
                        $h=array_change_key_case($h, CASE_UPPER);	

                        $gl_cat_mcat_name=$h['GLCAT_MCAT_NAME'];
			$gl_cat_mcat_name = preg_replace("/\'/", "\\'", $gl_cat_mcat_name);
                        
                        $x.='<INPUT TYPE="radio" NAME="mcat" VALUE="'.$h['GLCAT_MCAT_ID'].'" onclick="return display(\''.$gl_cat_mcat_name.'\',\''.$h['GLCAT_MCAT_ID'].'\')">'.$h['GLCAT_MCAT_NAME'].'<br>';
                }
                $x.='<INPUT TYPE="radio" NAME="mcat" VALUE="" onclick="return display(\'\',\'\')">Others<br>';                
                echo $x.'###'.$count;
        }
	elseif(!empty($grpid))
        {
                $sql = "Select distinct GLMETA_DISTINCT.FK_GLCAT_CAT_ID,GLMETA_DISTINCT_VAL DISPLAY_NAME,(SELECT count(FK_GLCAT_MCAT_ID) FROM GLCAT_CAT_TO_MCAT,GLCAT_MCAT WHERE GLCAT_CAT_TO_MCAT.FK_GLCAT_CAT_ID = GLMETA_DISTINCT.FK_GLCAT_CAT_ID AND GLCAT_MCAT_IS_HOT=-1 and FK_GLCAT_MCAT_ID=GLCAT_MCAT_ID) AS MCAT_COUNT from GLMETA_DISTINCT,GLCAT_GRP_TO_CAT where GLCAT_GRP_TO_CAT.FK_GLCAT_GRP_ID= :GRP_ID and GLMETA_DISTINCT.FK_GLCAT_CAT_ID=GLCAT_GRP_TO_CAT.FK_GLCAT_CAT_ID and FK_GLCAT_LVL_ID='CAT' and FK_GLMETA_TYP_ID='DNME' and FK_GL_MODULE='ETO' order by DISPLAY_NAME";
		$sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array(":GRP_ID" => $grpid));

		
                $y='';
		while($h = $sth->read())                
                {
                $h=array_change_key_case($h, CASE_UPPER);
                $y.='<OPTION VALUE="'.$h['FK_GLCAT_CAT_ID'].'" ONCLICK= "javascript:mcatajaxFunction(\''.$h['FK_GLCAT_CAT_ID'].'\')">'.$h['DISPLAY_NAME'].'</OPTION>';
                }
                                        
                echo $y;
        }
	else
        {                
                $sql = "Select distinct GLMETA_DISTINCT.FK_GLCAT_GRP_ID AS GRP_ID, GLMETA_DISTINCT_VAL DISPLAY_NAME from GLMETA_DISTINCT,GLCAT_GRP_TO_CAT where GLMETA_DISTINCT.FK_GLCAT_GRP_ID=GLCAT_GRP_TO_CAT.FK_GLCAT_GRP_ID and FK_GLCAT_LVL_ID='GRP' and FK_GLMETA_TYP_ID='SNME' and FK_GL_MODULE='ETO' order by DISPLAY_NAME";
		$sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
		
                
                $x='';
		while($h = $sth->read())                
                {    
                        $h=array_change_key_case($h, CASE_UPPER);
                        $x.='<OPTION VALUE="'.$h['GRP_ID'].'" onclick ="javascript:catajaxFunction('.$h['GRP_ID'].'); ">'.$h['DISPLAY_NAME'].'</OPTION>';
                }

                echo $x;
        }
}

	public function histFENQOfrAllDet($glmodel) {
		$obj = new Globalconnection();
                if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net'||  $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')
                {    
                    $dbh = $obj->connect_db_yii('postgress_web68v');
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v');
                }
		$request = Yii::app()->request;	
		$offer = $request->getParam('offer',0);	
		$receiverID = $origMODID='';

		$sql = "
	SELECT 
                coalesce(FK_QUERY_ID,ENQUIRY_SMS_ID) ENQ_ID,
                (CASE WHEN FK_QUERY_ID IS NULL THEN 'SMS' ELSE 'WEB' END) ENQ_TYP,		
                DATE_R,
                QUERY_MODID, FK_GLUSR_USR_ID, MESSAGE, SENDEREMAIL, SENDERNAME, S_ORGANIZATION, S_DESIGNATION, S_STREETADDRESS,
                S_CITY, S_STATE, S_ZIP, S_COUNTRY, S_PHONE,  DIR_QUERY_REQ_APRX_ORDER_VALUE, DIR_QUERY_REQ_APP_USAGE,
                (CASE WHEN DIR_QUERY_REQ_PURCHASE_PERIOD=1 then 'Immediate' 
                WHEN DIR_QUERY_REQ_PURCHASE_PERIOD=2 THEN 'Within 15 Days'
                WHEN DIR_QUERY_REQ_PURCHASE_PERIOD=3 Then 'Within 1 Month' ELSE NULL END) DIR_QUERY_REQ_PURCHASE_PERIOD,                 
                (CASE WHEN DIR_QUERY_REQ_PURPOSE=1 then 'For Reselling' 
                WHEN DIR_QUERY_REQ_PURPOSE=2 then 'For Your End Use' 
                WHEN DIR_QUERY_REQ_PURPOSE=3 then 'As Raw Material' ELSE NULL END) DIR_QUERY_REQ_PURPOSE,                 
                (CASE WHEN DIR_QUERY_REQ_FREQUENCY=1 then 'One Time Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=2 then 'Regular Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=3 then 'Daily Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=4 then 'Weekly Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=5 then 'Monthly Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=6 then 'Quarterly Requirement'
                WHEN DIR_QUERY_REQ_FREQUENCY=7 then 'Half Yearly Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=8 then 'Yearly Requirement'
                ELSE NULL END) DIR_QUERY_REQ_FREQUENCY, 
		DIR_QUERY_REQ_GEOGRAPHY_ID,
                DIR_QUERY_REQ_GEO_CITY1_ID, DIR_QUERY_REQ_GEO_CITY2_ID, DIR_QUERY_REQ_GEO_CITY3_ID 
        FROM	ETO_OFR_FROM_FENQ 
        WHERE 	FK_ETO_OFR_ID =$offer 
        UNION ALL 
        SELECT 
                coalesce(FK_QUERY_ID,ENQUIRY_SMS_ID) ENQ_ID,
                (CASE WHEN FK_QUERY_ID IS NULL THEN 'SMS' ELSE 'WEB' END) ENQ_TYP,		
                DATE_R,
                QUERY_MODID, FK_GLUSR_USR_ID, MESSAGE, SENDEREMAIL, SENDERNAME, S_ORGANIZATION, S_DESIGNATION, S_STREETADDRESS,
                S_CITY, S_STATE, S_ZIP, S_COUNTRY, S_PHONE,  DIR_QUERY_REQ_APRX_ORDER_VALUE, DIR_QUERY_REQ_APP_USAGE,
                (CASE WHEN DIR_QUERY_REQ_PURCHASE_PERIOD=1 then 'Immediate' 
                WHEN DIR_QUERY_REQ_PURCHASE_PERIOD=2 THEN 'Within 15 Days'
                WHEN DIR_QUERY_REQ_PURCHASE_PERIOD=3 Then 'Within 1 Month' ELSE NULL END) DIR_QUERY_REQ_PURCHASE_PERIOD,                 
                (CASE WHEN DIR_QUERY_REQ_PURPOSE=1 then 'For Reselling' 
                WHEN DIR_QUERY_REQ_PURPOSE=2 then 'For Your End Use' 
                WHEN DIR_QUERY_REQ_PURPOSE=3 then 'As Raw Material' ELSE NULL END) DIR_QUERY_REQ_PURPOSE,                 
                (CASE WHEN DIR_QUERY_REQ_FREQUENCY=1 then 'One Time Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=2 then 'Regular Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=3 then 'Daily Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=4 then 'Weekly Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=5 then 'Monthly Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=6 then 'Quarterly Requirement'
                WHEN DIR_QUERY_REQ_FREQUENCY=7 then 'Half Yearly Requirement' 
                WHEN DIR_QUERY_REQ_FREQUENCY=8 then 'Yearly Requirement'
                ELSE NULL END) DIR_QUERY_REQ_FREQUENCY, 
		DIR_QUERY_REQ_GEOGRAPHY_ID,
                DIR_QUERY_REQ_GEO_CITY1_ID, DIR_QUERY_REQ_GEO_CITY2_ID, DIR_QUERY_REQ_GEO_CITY3_ID 
        FROM	ETO_OFR_FROM_FENQ_ARCH 
        WHERE 	FK_ETO_OFR_ID = $offer";
		$sth = $glmodel->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
        $rec = $sth->read();
        $rec = isset($rec)?$rec:array();
        if(!empty($rec)){
            $rec=array_change_key_case($rec, CASE_UPPER);	
        }
                
                
		$queryID = isset($rec['ENQ_ID'])?$rec['ENQ_ID'] : '';
		$sql_enq = '';
                
		if(!empty($queryID)){
			  if($rec['ENQ_TYP'] == 'WEB'){
					$sql_enq = "SELECT QUERY_RCV_GLUSR_USR_ID RCV_GLUSR_ID,NULL MODID FROM DIR_QUERY WHERE QUERY_ID = :ENQ_ID";
			  } else{
					if($rec['QUERY_MODID'] == "INTENT"){
						$sql_enq = "SELECT INTEREST_RCV_GLUSR_ID RCV_GLUSR_ID,IIL_ENQ_INTEREST_MODID MODID FROM IIL_ENQUIRY_INTEREST_ARCH WHERE IIL_ENQ_INTEREST_FENQ_ID = :ENQ_ID";				
					}else if($rec['QUERY_MODID'] == "CINTENT"){
						$sql_enq = "SELECT ETO_C2C_INTENT_RECV_GLUSR_ID RCV_GLUSR_ID,NULL MODID FROM ETO_C2C_INTENT WHERE ETO_C2C_INTENT_FENQ_ID= :ENQ_ID";				
					}  
			  }
		if(!empty($sql_enq)){
		if($rec['QUERY_MODID'] =="INTENT"){
					$sth_enq = $glmodel->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql_enq,array(':ENQ_ID'=>$queryID));		
			}
			else if($rec['QUERY_MODID'] == "CINTENT"){
					$sth_enq = $glmodel->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql_enq,array(':ENQ_ID'=>$queryID));		
			}else{
                            if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net'||  $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')
				{    
                                        $dbh_enq = $obj->connect_db_yii('postgress_web77v');
                                }else{
					$dbh_enq = $obj->connect_db_yii('postgress_web39v');
				}
                            $sth_enq = $glmodel->runSelect(__FILE__,__LINE__,__CLASS__,$dbh_enq,$sql_enq,array(':ENQ_ID'=>$queryID));	
			}
			$response = $sth_enq->read();
                        $rec_enq=array();
			if(gettype($response)=='array'){
				$rec_enq=array_change_key_case($response, CASE_UPPER);	
			}
			$receiverID = isset($rec_enq['RCV_GLUSR_ID'])?$rec_enq['RCV_GLUSR_ID'] : '';	
                        $origMODID = isset($rec_enq['MODID'])?$rec_enq['MODID'] : '';			  
		}
		}
		$returnArr = array(
			'receiverID' => $receiverID,
			'queryID' => $queryID,
			'rec' => $rec,
			'offer' => $offer,
                        'origMODID' => $origMODID,
		);
		return $returnArr;
	}
	
	
	public function sendApproveMail($dbh,$offerID,$glmodel)
{
	 $tollfree='09696969696';
	$addtolinks="&utm_source=buyershelp&utm_medium=email&utm_campaign=ofrapproval";

	$loginPath = $_SERVER['ADMIN_URL'];
	
	$sysDateFull = date("Ymd",strtotime(date("Y-m-d")."+10 days"));
	$buyerReUpdUrl = $offerID.'-'.$sysDateFull;
	$buyerReUpdUrl= $this->convertUsingRC4($buyerReUpdUrl);
	$buyerReUpdUrl= base64_encode($buyerReUpdUrl);
	$myImUrl = 'my';
	
	$buyerReUpdUrl_text='';
	
	$buyerEmailAlt='';
	$buyerEmails = array();
	$categoriesIN = array("BL Approval- India");
	$categoriesFOR = array("BL Approval- Foreign");
	$categoryCnt = 0;
	
	$sql1="
	    SELECT ETO_OFR_TYP, ETO_OFR_TITLE, GLUSR_USR_ID, GLUSR_USR_FIRSTNAME, GLUSR_USR_LASTNAME, 
	    GLUSR_USR_EMAIL, GLUSR_USR_EMAIL_ALT, GLUSR_USR.FK_GL_COUNTRY_ISO COUNTRY_ISO
	    FROM ETO_OFR,GLUSR_USR 
	    WHERE ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID 
	    AND ETO_OFR_DISPLAY_ID = :ofr_id";
	    
	    $sth = $glmodel->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql1,array(':ofr_id'=>$offerID));
		
	    $rec = $sth->read();
	    $rec1=array_change_key_case($rec, CASE_UPPER);
	    $offerTitle = $rec1['ETO_OFR_TITLE'];
	    $buyer_glusr_id = $rec1['GLUSR_USR_ID'];
	    $glusrFirstName = isset($rec1['GLUSR_USR_FIRSTNAME']) && !empty($rec1['GLUSR_USR_FIRSTNAME']) ? $rec1['GLUSR_USR_FIRSTNAME'] : '';
	    $glusrMiddleName = '';
	    $glusrLastName = isset($rec1['GLUSR_USR_LASTNAME']) && !empty($rec1['GLUSR_USR_LASTNAME']) ? $rec1['GLUSR_USR_LASTNAME'] : '';
	    
	    $buyerName= $glusrFirstName." ".$glusrMiddleName." ".$glusrLastName;
	    $buyer_email = isset($rec1['GLUSR_USR_EMAIL']) && !empty($rec1['GLUSR_USR_EMAIL']) ? $rec1['GLUSR_USR_EMAIL'] : '';

	    if(empty($buyer_email))
	    {
		goto DEV;
	    }


	    $buyerEmailAlt = isset($rec1['GLUSR_USR_EMAIL_ALT']) && !empty($rec1['GLUSR_USR_EMAIL_ALT']) ? $rec1['GLUSR_USR_EMAIL_ALT'] : '';
	
	    $buyerCntyISO = isset($rec1['COUNTRY_ISO']) && !empty($rec1['COUNTRY_ISO']) ? $rec1['COUNTRY_ISO'] : '';

	    $buyerEmails[] = $buyer_email;
	    if(!empty($buyerEmailAlt))
	    {
		array_push($buyerEmails, $buyerEmailAlt);
		array_push($categoriesIN, "BL Approval- India-ALT");
		array_push($categoriesFOR, "BL Approval- Foreign-ALT");
	    }
	
	$buyerReUpdUrl_text="http://".$myImUrl.".indiamart.com/cgi/eto-reupd-buyer.mp?offerid=".$buyerReUpdUrl;
	$buyerReUpdUrl = "http://".$myImUrl.".indiamart.com/cgi/eto-reupd-buyer.mp?offerid=".$buyerReUpdUrl."&z=".$buyer_glusr_id.$addtolinks;

	if($buyerCntyISO != 'IN'){
	    $tollfree='+91 9696969696';
	}

	$message='
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	    <META http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
	    <div>
	    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-radius:6px;background-color:#fff">
	    <tbody>
	    <tr>
		<td valign="bottom" style="padding:3px 0 0px 0px;border-bottom:1px solid #eeeeee">
   		<img align="right" src="https://trade.indiamart.com/gifs/indiamart-logo-m.png" alt="indiamart" width="100" height="27" border="0" title="IndiaMART">
		<span style="font-size:14px;font-family:arial;color:#333333;text-align:left;line-height:27px">Dear '.$buyerName.' </span>
		</td>
	    </tr>
	    <tr>
		<td valign="top" style="font-family:arial;color:#333333;padding:10px 0px 0px 0px;text-align:left;font-size:22px;font-weight:bold"> Your Buy Requirement is now Visible Online
	    	</td>
	    </tr>
            <tr>
		<td style="padding:12px 0px 0px 0px;margin:0px 0;font-size:14px;text-align:left;font-family:arial;color:#333333">
		<span style="font-weight:bold;font-size:14px">Requirement for :</span>
		<span style="display:inline-block;font-size:14px">
		<a href="https://trade.indiamart.com/details.mp?offer='.$offerID.'" style="text-decoration:none"> '.$offerTitle.'</a>
		</span>
		</td>
	    </tr>';

	$message_text='Dear '.$buyerName.'

Your Buy Requirement is now Visible Online at Indiamart.com!

Requirement for:	'.$offerTitle

;
	$message.= '
	    <tr>
	    	<td valign="top" style="font-family:arial;color:#333333;padding:15px 0px 0px 0px;font-size:14px">
		Meanwhile, increase your chances of finding more suppliers by verifying and enhancing your requirement and earn the Verified &amp; Updated badge.
		</td>
	    </tr>
	    <tr>
		<td valign="top" style="font-family:arial;color:#333333;text-align:left;padding:13px 0px 0px 0px;font-size:15px">
		<a style="text-decoration:none;color:#ffffff;font-size:15px;font-weight:bold;margin:5px 5px 0 0;padding:6px 8px;border:0;border-radius:4px;vertical-align:top;display:inline-block;background-color:#336699;font-family:arial;text-align:left" href="'.$buyerReUpdUrl.'">Yes, I Want to Verify &amp; Enhance My Buy Requirement </a>
 		</td>
	    </tr>
 	    <tr>
		<td valign="top" style="font-family:arial;color:#333333;padding:18px 0px 0px 0px;font-size:14px">
		For assistance, please contact: 
	    	</td>
	    </tr>
 	    <tr>
		<td valign="top" style="font-family:arial;color:#333333;padding:15px 0px 0px 0px;font-size:14px">
		IndiaMART Buyer&#39;s Helpdesk
		</td>
	    </tr>
 	    <tr>
		<td valign="top" style="font-family:arial;color:#333333;padding:0px 0px 15px 0px;font-size:14px">
		<span style="display:inline-block;font-size:14px">
		Email: <a href="mailto:buyershelp@indiamart.com" style="text-decoration:none;color:#0000ff;padding-right:25px" target="_blank">
		buyershelp@indiamart.com </a>
		</span>
		<span style="display:inline-block;font-size:14px">Call Us: '.$tollfree.'</span>
		</td>
	    </tr>
	    </tbody>
	    </table>
	    </div>
	</body>
	</html>';
	$message_text.='Meanwhile, increase your chances of finding more suppliers by verifying and enhancing your requirement (link give below) and earn the Verified & Updated badge.

Yes, I Want to Verify & Enhance My Buy Requirement'.
$buyerReUpdUrl_text.'
Note: If you are unable to click on the above link, simply copy and paste the link into the address bar of the web browser window.


For assistance, please contact:
IndiaMART Buyer\'s Helpdesk
Email: buyershelp@indiamart.com   Call Us: '.$tollfree;

	$to ='';
	$from="buyershelp@indiamart.com";
	$sub='Your Buy Requirement for "'.$offerTitle.'"';
	$cc='';
	$from_name="IndiaMART Buyers HelpDesk";
	$mime_header="Content-type: text/html\n\n";
	$bouncemail='';
	$category='';
	$date=date('d-m-Y',time());	

	 foreach($buyerEmails as $BuyerEmailID)
	{
		$to = $BuyerEmailID;
		$category = (($buyerCntyISO == 'IN') ? $categoriesIN[$categoryCnt] : $categoriesFOR[$categoryCnt]);
		$sendGridCategory = '';
		$filter = '';
		$filter = ',"unique_args" : {"sentdate" : "'.$date.'" ,"iilglusrid": "'.$buyer_glusr_id.'" ,"offerid": "'.$offerID.'"}';
		$sendGridCategory= 'X-SMTPAPI: {"category":"'. $category.'"' . $filter .'}';
		//$tempMsg = "<html><head></head><body><h1>my test message</h1><input type='submit' value='submit'></input></body></html";
		$sendmailArr = array(
                        'to' => $to,
                       'from' => $from,
                        'cc' => $cc,
                        'sub' => $sub,
                        'message' => $message,
                        'from_name' => $from_name,
                        'replyto' => 'buyershelp+blapproval@indiamart.com',
                        'host' => 'ucexhelva2.smtp.sendgrid.net',
                        'username' => 'rajkamal+BLBuyers@indiamart.com',
                        'pass' => 'enqmart142',
                        'message_text' => $message_text,
                        'unique_args' => $sendGridCategory							
                );
                
                $this->SendGridMail($sendmailArr);
		$categoryCnt++;
	} 

	DEV: 
}

public function convertUsingRC4($str)
{
	$key= '1996c39iil';
    $s = array();
    for ($i = 0; $i < 256; $i++) {
        $s[$i] = $i;
    }
    $j = 0;
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
        $x = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $x;
    }
    $i = 0;
    $j = 0;
    $res = '';
    for ($y = 0; $y < strlen($str); $y++) {
        $i = ($i + 1) % 256;
        $j = ($j + $s[$i]) % 256;
        $x = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $x;
        $res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
    }
    return $res;
}

function SendGridMail($sendmailArr)
{	
	$sendGridCategory = isset($sendmailArr['unique_args'])?$sendmailArr['unique_args']:'';
      
      	Yii::import('application.extensions.phpmailer.JPhpMailer');
      	$mail = new JPhpMailer;
      	$mail->isSMTP();
      	$mail->Host = $sendmailArr['host']; ///'ucexhelva2.smtp.sendgrid.net';
      	$mail->SMTPAuth = true;
      	$mail->Username = $sendmailArr['username'];
      	$mail->Password = $sendmailArr['pass'];
      	$mail->SMTPSecure = 'tls';
      	$mail->Port = 587;

      	$mail->From = $sendmailArr['from'];
      	$mail->FromName = $sendmailArr['from_name'];
      	$mail->addAddress($sendmailArr['to']);
      	$mail->addReplyTo($sendmailArr['replyto'], 'Buyers Help');
      	$mail->isHTML(true);
      	$mail->Subject = $sendmailArr['sub'];
      	$mail->Body    = $sendmailArr['message'];
      	if(!empty($sendGridCategory)){
      		$mail->AddCustomHeader($sendGridCategory);
      	}
         $mailParams = json_encode($sendmailArr);        
      	if(!$mail->send()) {
          	return false;
          	//mail("puneet.khandelwal@indiamart.com","Error in Mail Sending",$err." Mail Parameters = ".$mailParams);
      	}
}

	
	
	public function getGenericMcatReport($request){
		$sid = 'meshr';
		$start_date = '';
		$end_date = '';
		$bdate_day = $request->getParam("bdate_day",'');
		$bdate_month = $request->getParam("bdate_month",'');
		$bdate_year = $request->getParam("bdate_year",'');
		$adate_day = $request->getParam("adate_day",'');
		$adate_month = $request->getParam("adate_month",'');
		$adate_year = $request->getParam("adate_year",'');
		if(!empty($bdate_day) && !empty($bdate_month) && !empty($bdate_year) && !empty($adate_day) && !empty($adate_month) && !empty($adate_month))
		{
			$start_date = $bdate_day."-".$bdate_month."-".$bdate_year;
			$end_date = $adate_day."-".$adate_month."-".$adate_year;
		}
		if($start_date == $end_date)
		{
			$sid = 'mesh';
		}	
		if($_SERVER['MY_COUNTRY'] == 'INDIA'  || $_SERVER['MY_COUNTRY'] == 'INDIA2')
		{
			$sid='mart';
		}
	}
	
	public function showGenericMcatMIS($request) {
			$fields = array('adate_day','adate_month','adate_year','bdate_day','bdate_month','bdate_year','modid','client','source');
			$param = array();
			foreach ($fields as $row) 
			{
     			if ($request->getParam($row)) {
        			$param[$row] = $request->getParam($row);
     			} else {
      	  		$param[$row] = '';
     			}
  			}
			$reArr = array("param" => $param);
			return $reArr;	
		
	}

	public function showGenericMcatInfo($request) {
            echo "Please contact GLADMIN team";
		exit;
	}
	public function getEmpDetail($request,$model){
			$na = $request->getParam("str");
			$type = $request->getParam("typ");
			$na = strtoupper($na);
			$str = "";
                        $conn_obj=new Globalconnection();
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                            $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
                        }else{
                            $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
                        }
			$sql = "select GL_EMP_NAME,GL_EMP_ID from GL_EMP where UPPER(GL_EMP_NAME) like'$na%'";
			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());			
			while($row = $sth->read()) {				
				$str.="<div class='norm' onclick='return selc(\"".$row['gl_emp_name']."\",\"".$row['gl_emp_id']."\",\"".$type."\")'>".$row['gl_emp_name']."(".$row['gl_emp_id'].")</div>";
			}
			
			return $str;
	}	
	public function getIndustrySpecQuesDetails($request,$mcat_id)
    {
        $offerId=$request->getParam('offer');
        $type = 3;
        $errMsg = '';
        $flag='';
        $quesArr = $resultArr=array();
        $buyerRespArr = array();
        if(empty($offerId) || empty($mcat_id))
		{
            $errMsg = "Offer Id /MCAT ID Empty";
        } else 
		{        
			if($mcat_id>0)
			{	
				if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net'))
				{
					$Isq_service= "http://stg-mapi.indiamart.com/wservce/buyleads/getISQ/modid/GLADMIN/token/imobile@15061981/mcatid/$mcat_id/cat_type/$type/ofrid/$offerId/edit/1/fixed_attr/1/format/1/isq_format/1/generic_flag/1/";
				}
				elseif(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
				{
					$Isq_service= "http://stg-mapi.indiamart.com/wservce/buyleads/getISQ/modid/GLADMIN/token/imobile@15061981/mcatid/$mcat_id/cat_type/$type/ofrid/$offerId/edit/1/fixed_attr/1/format/1/isq_format/1/generic_flag/1/";
				}
				else
				{
					$Isq_service= "http://mapi.indiamart.com/wservce/buyleads/getISQ/modid/GLADMIN/token/imobile@15061981/mcatid/$mcat_id/cat_type/$type/ofrid/$offerId/edit/1/fixed_attr/1/format/1/isq_format/1/generic_flag/1/";
				}
                               $ServiceGlobalModelForm = new ServiceGlobalModelForm();
                                $dataHash = $ServiceGlobalModelForm->mapiService('BLGETISQ',$Isq_service,array());
				
				if (!is_array($dataHash)) {		      
					//mail("gladmin-team@indiamart.com","ISQ details through web service failed in Admin Eto","Mapi Server Connectivity Issue\nService URL:- $Isq_service");
				} 
				else 
				{
					if(!empty($dataHash) && $dataHash['RESPONSE']['CODE'] == 200)
					{
						$quesArr=$dataHash['RESPONSE']['DATA'];
                        if(array_key_exists(0,$dataHash['RESPONSE']['DATA'])){
						if(array_key_exists('ISQ_RESPONSE_ID',$dataHash['RESPONSE']['DATA'][0]))
						{
							$flag=1;
						}
                    }
					}
					elseif(!empty($dataHash) && $dataHash['RESPONSE']['CODE'] != 200)
					{

						$returnString=$dataHash['RESPONSE']['MESSAGE'];
						$http_status=$dataHash['RESPONSE']['CODE'];
						$msg="offerid:$offerId,mcat_id:$mcat_id,Status:$http_status ,Return_msg:$returnString";
						//mail("gladmin-team@indiamart.com","gladmin :GET ISQ Service Error in Enrichment page",$msg);

					}
                                        $empId = Yii::app()->session['empid'];
				}  
			}
			$resultArr = array('errMsg'=>$errMsg,'quesArr' => $quesArr,'flag'=>$flag);
		}        
		return $resultArr;
    }


        public function multipleattachment($offer) 
	{ 
            $atttachsth=array();
	               $obj = new Globalconnection();
                       $model = new GlobalmodelForm();    
                       $dbh = $obj->connect_db_yii('postgress_web68v'); 
	               $sql = "select ETO_OFR_ATTACH_IMG_ORIG,ETO_OFR_ATTACHMENT_ID,ETO_OFR_ATTACHEMENT_STATUS,ETO_OFR_ATTACH_TYPE,ETO_OFR_ATTACH_DOC_PATH  from ETO_OFR_ATTACHMENT where FK_ETO_OFR_DISPLAY_ID=:FK_ETO_OFR_DISPLAY_ID";
               $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array('FK_ETO_OFR_DISPLAY_ID'=>$offer));//echo $sql;     
                         while($rec = $sth->read()) {
                             $atttachsth=array_change_key_case($rec, CASE_UPPER); 
                         }
                       //  print_r($stmt);
                     //    exit;
                        return $sth;
	}
        
        public function multipleattachment_del($offerID,$attach_id)
	{   	if($offerID > 0)
		{			
                        $param['token']	='imobile1@15061981';
                        $param['modid']	='GLADMIN';
                        $param['DISPLAY_ID']=$offerID;                        
                        $param['ATTACHMENT_ID']=$attach_id;
                        $param['action']='Update';
                        $param['STATUS']=0;
                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                                $curl = 'http://dev-leads.imutils.com/wservce/leads/setattachment/';
                                }else{                        
                                $curl = 'http://leads.imutils.com/wservce/leads/setattachment/';
                                }
                        $serv_model =new ServiceGlobalModelForm();
                        $response=$serv_model->mapiService('OFRATTACHMENT',$curl,$param,'No');
                       //  if($empId==3575){
                        //    echo '<pre>';print_r($param);print_r($response);die;
                        //    }
                        if($response['Response']['Code']==200){
                            $response="Success";
                        }else{
                            $response="Some Error occured";
                        }
			
		}
		die;
    }
    
    public function NOB($offerId)
           {
            $NOBArr=array();
            $obj = new Globalconnection();
            $model = new GlobalmodelForm();    
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
            {
                $dbh = $obj->connect_db_yii('postgress_web68v');   
            }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
            }
           
          $sql = 'SELECT RFQ_TO_SUPPLIER_NOB_ID, RFQ_TO_SUPPLIER_NOB_TYPE, FK_RFQ_TO_SUPPLIER_BIZ_ID
	  FROM RFQ_TO_SUPPLIER_NOB WHERE RFQ_TO_SUPPLIER_NOB_REFID = :OFFER_ID';
          $bind[':OFFER_ID']=$offerId; 
           $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
           while($rec = $sth->read()) {
                $NOBArr=array_change_key_case($rec, CASE_UPPER); 
           }
            return $NOBArr;
           }   
           
   
 public function NOB_UPDATE($OFFERID,$NOBVal,$modid)
  {  
     $NOBArr=array();
     $empId = Yii::app()->session['empid'];
     if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                $curl = 'http://dev-leads.imutils.com/wservce/leads/setnob/';
                }else{                        
                $curl = 'http://leads.imutils.com/wservce/leads/setnob/';
                }
        $response='';
        $serv_model =new ServiceGlobalModelForm();
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();    
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
            {
                $dbh = $obj->connect_db_yii('postgress_web68v');   
            }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
            }
           
          $sql = 'SELECT RFQ_TO_SUPPLIER_NOB_ID, RFQ_TO_SUPPLIER_NOB_TYPE, FK_RFQ_TO_SUPPLIER_BIZ_ID
	  FROM RFQ_TO_SUPPLIER_NOB WHERE RFQ_TO_SUPPLIER_NOB_REFID = :OFFER_ID';
          $bind[':OFFER_ID']=$OFFERID; 
           $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
           while($rec = $sth->read()) {
                $NOBArr=array_change_key_case($rec, CASE_UPPER); 
           }
        $NOBId = $NOBArr['RFQ_TO_SUPPLIER_NOB_ID'];
        $supplierNOBType = $NOBArr['RFQ_TO_SUPPLIER_NOB_TYPE'];

if(!empty($NOBVal)){
            if(!empty($NOBId)){
                        $param['token']	='imobile1@15061981';
                        $param['modid']	='GLADMIN';
                        $param['NOB_REFID']=$OFFERID;                        
                        $param['NOB_ID']=$NOBId;
                        $param['TYPE']=$supplierNOBType; 
                        $param['SUPPLIER_BIZ_ID']=$NOBVal;
                        $param['action']='Update';  
                        $response=$serv_model->mapiService('OFRNOB',$curl,$param,'No');
                        
                        if($response['Response']['Code']==200){
                            $response="Success";
                        }else{
                            $response="Some Error occured";
                            $input = json_encode($param);
                            $output = json_encode($response);
                        }
            } else {
                if($modid == 'FENQ')
                {
                $supplierNOBType='E';
                }
                else
                {
                $supplierNOBType='B';
                }
                    $param['token']	='imobile1@15061981';
                    $param['modid']	='GLADMIN';
                    $param['NOB_REFID']=$OFFERID;                        
                    $param['TYPE']=$supplierNOBType; 
                    $param['SUPPLIER_BIZ_ID']=$NOBVal;
                    $param['action']='Insert';
                    $response=$serv_model->mapiService('OFRNOB',$curl,$param,'No');
                   
                    if($response['Response']['Code']==200){
                        $response="Success";
                    }else{
                        $response="Some Error occured";
                        $input = json_encode($param);
                        $output = json_encode($response);
                    }
            }            
} else {
        if(!empty($NOBId)){       
                        $param['token']	='imobile1@15061981';
                        $param['modid']	='GLADMIN';
                        $param['NOB_REFID']=$OFFERID;                        
                        $param['NOB_ID']=$NOBId;
                        $param['action']='Delete'; 
                        $response=$serv_model->mapiService('OFRNOB',$curl,$param,'No');                     
                        if($response['Response']['Code']==200){
                            $response="Success";
                        }else{
                           $response="Some Error occured";
                            $input = json_encode($param);
                            $output = json_encode($response);
                        }
                    }
            }
    // echo $response;die;       
}  
    
    public function pushProductOnTop($empId) 
	{   
		$request = Yii::app()->request;	
		$offerID = $request->getParam('offer','');
		$emp_name = Yii::app()->session['empname'];
                
		if($offerID > 0)
		{
			$histipcountry='India';
			$histusing = 'Gladmin';
			$histcomments='Push to Top';
			$histmodid='Gladmin';
			$histref='';
			$histip=$_SERVER['SERVER_ADDR'];
			
                        $param['token']	='imobile1@15061981';
                        $param['modid']	='GLADMIN';
                        $param['offerid']=$offerID;;
                        $param['histby']=$emp_name;
                        $param['histusing']=$histusing;
                        $param['histipcountry']=$histipcountry;
                        $param['histcomments']=$histcomments;
                        $param['histip']=$histip;
                        $param['histref']=$histref;
                        $param['histmodid']=$histmodid;
                        $param['histempid']=$empId;
                       // $param['histusrid']=$_REQUEST['glid'];
                        $param['glusrid']=$_REQUEST['glid'];
                        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                                $curl = 'http://dev-leads.imutils.com/wservce/buyleads/pushtotop/';
                                }else{                        
                                $curl = 'http://leads.imutils.com/wservce/buyleads/pushtotop/';
                                }
                        $serv_model =new ServiceGlobalModelForm();
                        $response=$serv_model->mapiService('PUSHTOTOP',$curl,$param,'No');
                        
                        $input = json_encode($param);
                        $output = json_encode($response);
                        if($response['Response']['Code']==200){
                            $response="Success";
                        }else{
                            $response="Some Error occured";
                        }
			
		}
		return 0;
    }
    
	public function producDetail($glusrid)
    {
        $dom = (($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') ) ? "http://stg-mapi.indiamart.com/wservce/products/webuy/?" : "http://mapi.indiamart.com/wservce/products/webuy/";
		
		$content = array();
		$content=array(
			'token'=>'imobile@15061981',
			'modid'=>'GLADMIN',
			'glusrid'=>$glusrid,
            'organic'=>1,
		);
		$ServiceGlobalModelForm = new ServiceGlobalModelForm();
		$organic = $ServiceGlobalModelForm->mapiService('PRODUCTWEBUY',$dom,$content,'No');

		if (!is_array($organic)) {	      
			//mail("gladmin-team@indiamart.com","PRODUCTWEBUY web service failed in OFR Search Screen","Mapi Server Connectivity Issue\nService URL:- $dom\n\n");
			die;
		}
		 
		return array('blenquiry'=>$blenquiry["Response"]["Data"],'organic'=>$organic["Response"]["Data"]);
    }
    
    public function get_vendor_data($empId)
    {
    $obj = new Globalconnection();
    $model = new GlobalmodelForm();
    $vendorName='';
    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
    {
        $dbh = $obj->connect_db_yii('postgress_web68v');   
    }else{
        $dbh = $obj->connect_db_yii('postgress_web68v'); 
    }
    $sql = "select ETO_LEAP_VENDOR_NAME from eto_leap_mis_interim where ETO_LEAP_EMP_ID=:ETO_LEAP_EMP_ID";
        $bind[':EMP_ID']=$empId; 
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
        while($rec = $sth->read()) {
                $returnArr=array_change_key_case($rec, CASE_UPPER);     
                $vendorName = isset($returnArr['ETO_LEAP_VENDOR_NAME'])?$returnArr['ETO_LEAP_VENDOR_NAME'] :'';
                return $vendorName;
           }
    
    }
    
  public function sendmail_mcatna_del($dbh,$offerID,$status) {
         $model = new GlobalmodelForm();
        if($status == 'W'){
            $tblName = 'ETO_OFR_TEMP_DEL';       
        } else {
            $tblName = 'ETO_OFR_EXPIRED';       
        }
           
          $sql = "SELECT TO_CHAR(ETO_OFR_POSTDATE_ORIG, 'DD-Mon-yyyy HH:MI:SS AM') POST_DATE_ORIG,
                    TO_CHAR(NOW(), 'DD-Mon-yyyy HH:MI:SS AM') DEL_DATE_ORIG,
                    ETO_OFR_TITLE, ETO_OFR_DESC 
          FROM ".$tblName.", GLUSR_USR
          WHERE ".$tblName.".FK_GLUSR_USR_ID = GLUSR_USR.GLUSR_USR_ID AND ETO_OFR_DISPLAY_ID = :offerID";
        $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":offerID" => $offerID));
	$rec1 = $sth1->read();
        ##Wrting Data in xls File  Start           
 	
      $txt='';
      $date_time = strtoupper(date("M_Y"));
      $name=$date_time."_LEAP_MCAT_NA.txt";
      $filename_input   = "/home3/indiamart/public_html/excel_upload/mcat_na/$name";
      $fp = fopen($filename_input, 'a');
      $txt .=$offerID.'##'.$rec1['post_date_orig'].'##'.$rec1['del_date_orig'].'##'.$rec1['eto_ofr_title'].'##'.$rec1['eto_ofr_desc']."@@";
      fwrite($fp, $txt);
      fclose($fp);
      chmod($filename_input, 0755);
      
      ##Wrting Data in xls File  ENd    
   }
   
   public function histOfrLocking($approveDate,$deleteDate,$offerId)
   {
     
     $approveDateArray = explode(" ", $approveDate);
     $approvedate=$approveDateArray[0];
     $deleteDateArray = explode(" ", $deleteDate);
     $deleteDate=$deleteDateArray[0];
     $currentDate=date("d-M-Y");
     $rec_array=array();
     $obj = new Globalconnection();
     $model = new GlobalmodelForm();
      										
if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
{
    $dbh = $obj->connect_db_yii('postgress_web68v');   
}else{
    $dbh = $obj->connect_db_yii('postgress_web68v'); 
}
if($offerId>0){   
     $bind[':offer']=$offerId; 
     $i=0;
     if(($approvedate !='' && $approvedate != $currentDate) || ($deleteDate != '' && $deleteDate != $currentDate))
     {      
      $sql="SELECT B.FK_ETO_OFR_DISPLAY_ID,
	    TO_CHAR(B.ACTIVITY_TIME,'dd-Mon-yyyy hh12:mi:ss AM') ACTIVITY_TIME,
	    B.FK_EMPLOYEE_ID,
	    B.ACTION,
	    A.ETO_LEAP_EMP_NAME
	  FROM eto_Leap_mis A ,
	    LEAP_ACTIVITY_STATS_ARCH B
	  WHERE A.ETO_LEAP_EMP_ID    =B.FK_EMPLOYEE_ID
	  AND B.FK_ETO_OFR_DISPLAY_ID=:offer
	  ORDER BY B.ACTIVITY_TIME DESC";       
            
     }
     else
     {
        $sql="select B.*,A.ETO_LEAP_EMP_NAME from (
            SELECT FK_ETO_OFR_DISPLAY_ID,
	    TO_CHAR(ACTIVITY_TIME,'dd-Mon-yyyy hh12:mi:ss AM') ACTIVITY_TIME,
	    FK_EMPLOYEE_ID,
	    ACTION 	    
	  FROM LEAP_ACTIVITY_STATS 
	  WHERE 
	  FK_ETO_OFR_DISPLAY_ID=:offer
	  UNION  
          SELECT FK_ETO_OFR_DISPLAY_ID,
	    TO_CHAR(ACTIVITY_TIME,'dd-Mon-yyyy hh12:mi:ss AM') ACTIVITY_TIME,
	    FK_EMPLOYEE_ID,
	    ACTION
	  FROM LEAP_ACTIVITY_STATS_ARCH 
	  WHERE FK_ETO_OFR_DISPLAY_ID=:offer 
	  ) B , eto_Leap_mis A where A.ETO_LEAP_EMP_ID    =B.FK_EMPLOYEE_ID 
        ORDER BY B.ACTIVITY_TIME DESC
        ";		    
     } 
     $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
        while($rec = $sth->read()) {
               $rec_array[$i]['FK_ETO_OFR_DISPLAY_ID']=$rec['fk_eto_ofr_display_id'];
               $rec_array[$i]['ACTIVITY_TIME']=$rec['activity_time'];
               $rec_array[$i]['FK_EMPLOYEE_ID']=$rec['fk_employee_id'];
               $rec_array[$i]['ACTION']=$rec['action'];
               $rec_array[$i]['ETO_LEAP_EMP_NAME']=$rec['eto_leap_emp_name'];
               $i++;
           }   
    }
return $rec_array;
}
   
	
	public function getMasterValues($model){
			$currencyIN = array();
			$currencyFR = array();
			$timePeriod = array();
			$reqReason = array();
			$obj = new Globalconnection();
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                            $dbh = $obj->connect_db_yii('postgress_web68v');   
                        }else{
                            $dbh = $obj->connect_db_yii('postgress_web68v'); 
                        }
			$sql_en = " SELECT
                        IIL_MASTER_DATA_VALUE, IIL_MASTER_DATA_VALUE_TEXT, FK_IIL_MASTER_DATA_TYPE_ID,
                        CASE WHEN FK_IIL_MASTER_DATA_TYPE_ID = 3 THEN DECODE(IIL_MASTER_DATA_VALUE,1,1,3,2,33,3,19,4,14,5,21,6,10,7,31,8,29,9,7,10,8,11,17,12,16,13,23,14,34,15)
                        WHEN FK_IIL_MASTER_DATA_TYPE_ID = 4 THEN
                        DECODE(IIL_MASTER_DATA_VALUE,15,1,10,2,24,3,14,4,9,5,18,6,8,7,21,8,34,9)
                        WHEN FK_IIL_MASTER_DATA_TYPE_ID = 8 THEN
                        DECODE(IIL_MASTER_DATA_VALUE,1,3, DECODE(IIL_MASTER_DATA_VALUE,2,1,DECODE(IIL_MASTER_DATA_VALUE,3,2,4)))
                        ELSE NULL END SERIAL
                FROM IIL_MASTER_DATA
                WHERE IIL_MASTER_DATA_IS_ACTIVE = -1 AND FK_IIL_MASTER_DATA_TYPE_ID IN (3,4,5,7,8,9,10,17,18)
                ORDER BY FK_IIL_MASTER_DATA_TYPE_ID, SERIAL, IIL_MASTER_DATA_VALUE
                ";
			$sth_en = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_en,array());
			while($rec = $sth_en->read()) {
					if($rec['fk_iil_master_data_type_id'] == '7')
                {					    
                        $id = $rec['iil_master_data_value'];
                        if($id != '14'){
                        	array_push($currencyIN, $rec);
                        }
                        if($id == '1'){
                        	array_push($currencyFR, $rec);
                        }
                }
                if($rec['fk_iil_master_data_type_id'] == 9)
                {			    
                        array_push($timePeriod,$rec);
                }
                if($rec['fk_iil_master_data_type_id'] == 10)
                {			    
                        $reqReason[$rec['iil_master_data_value']] = $rec['iil_master_data_value_text'];
                }
                if($rec['fk_iil_master_data_type_id'] == '17')
                {			    
                        $id = isset($rec['iil_master_data_value'])? $rec['iil_master_data_value']:'';
                        $shipmentMode[$id] = $rec['iil_master_data_value_text'];
                }
                if($rec['fk_iil_master_data_type_id'] == '18')
                {		    
                        $id = isset($rec['iil_master_data_value'])? $rec['iil_master_data_value']:'';
                        $paymentMode[$id] = $rec['iil_master_data_value_text'];
                }
			}	
			$sqlReqFreq = "SELECT IIL_MASTER_DATA_VALUE_TEXT, FK_IIL_MASTER_DATA_TYPE_ID, IIL_MASTER_DATA_VALUE FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID = 11 AND IIL_MASTER_DATA_VALUE IN (1,2) ORDER BY FK_IIL_MASTER_DATA_TYPE_ID";
			$sthReqFreq = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sqlReqFreq,array());

         while($h = $sthReqFreq->read()) 
         {	 	
                $id = $h['iil_master_data_value'];
                $reqFreq[$id] = $h['iil_master_data_value_text'];
	 		}
			$returnArr = array(
					'currencyIN' => $currencyIN,
					'currencyFR' => $currencyFR,
					'timePeriod' => $timePeriod,
					'reqReason' => $reqReason,
					'reqFreq' => $reqFreq,
					'shipmentMode' => $shipmentMode,
					'paymentMode' => $paymentMode,
			);		
			return $returnArr ;
	}
	   
   
   
   public function getLeapEmpLVL($empId){ 
       $empDet=array();
        if(!empty($empId)){  
            $obj = new Globalconnection();
            $model = new GlobalmodelForm();
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
            {
               $dbh = $obj->connect_db_yii('postgress_web77v');   
            }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
            }
           // exit;
            if($dbh){
                 $sql = "SELECT ETO_LEAP_EMP_LEVEL,ETO_LEAP_VENDOR_NAME,ETO_LEAP_EMP_IS_ACTIVE FROM eto_leap_mis_interim where 	
                 ETO_LEAP_EMP_ID=:EMP_ID";           
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array(':EMP_ID'=>$empId));
                while($rec1 = $sth->read()){
                        $empDet=array_change_key_case($rec1, CASE_UPPER);                     
                  }
            }           
            return $empDet;
        }
    }
    public function banned_keywords()
	{
	 $obj = new Globalconnection();
          $banned_data=array();

        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_oci('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_oci('postgress_web68v'); 
        }
         if($dbh){
            $sql="SELECT LOWER(RESERVED_KEYWORDS) RESERVED_KEYWORDS
                  FROM GL_RESERVED_KEYWORDS_TYPE,GL_RESERVED_KEYWORDS    
                  WHERE GL_RESERVED_KEYWORDS_TYPEID=FK_GL_RESERVED_KEYWORDS_TYPEID 
                  AND GL_RESERVED_KEYWORDS_TYPEID != 2
                  AND RESERVED_KEYWORDS_TYPE NOT IN ('City','URL Restriction','Title Restrictions','Tour & Travel Enquiry','Job Enquiry','Generic Content Restrictions','Country')
                  ORDER BY RESERVED_KEYWORDS_TYPE,RESERVED_KEYWORDS
                 ";
                 $sth=pg_query($dbh,$sql);
                 $banned_data=pg_fetch_all($sth);
                 return json_encode($banned_data['reserved_keywords']);
          }
	}
        
        public function callMade30Days($request){
			$offerId = $request->getParam("offerid");
			$glusrid = $request->getParam("glusrid",'');
			$returnHtml = array();
			$obj = new Globalconnection();
                        $dbh=$obj->connect_db_oci('postgress_web68v');
		
			if($dbh && !empty($glusrid)){
				$sql = "SELECT TO_CHAR(MAX(A.ETO_OFR_APPROV_DATE_ORIG),'DD-MON-YYYY') LAST_CALL_ON,MIN((TRUNC(SYSDATE) - TRUNC(A.ETO_OFR_APPROV_DATE_ORIG))) LAST_CALL_ON_DAYS
							FROM (
      								SELECT ETO_OFR_APPROV_DATE_ORIG,FK_GLUSR_USR_ID FROM ETO_OFR WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' AND ETO_OFR_CALL_DISPOSITION_ID = 0 AND ETO_OFR_CALL_RECORDING_URL IS NOT NULL AND FK_GLUSR_USR_ID=$1 AND ETO_OFR_DISPLAY_ID != $2
							UNION ALL
     									SELECT ETO_OFR_APPROV_DATE_ORIG,FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED WHERE ETO_OFR_TYP='B' AND ETO_OFR_APPROV='A' AND ETO_OFR_CALL_DISPOSITION_ID = 0 AND ETO_OFR_CALL_RECORDING_URL IS NOT NULL AND FK_GLUSR_USR_ID=$1 AND ETO_OFR_DISPLAY_ID != $2
     								)A,
  									(
      								SELECT ETO_OFR_APPROV_DATE_ORIG,FK_GLUSR_USR_ID	FROM ETO_OFR WHERE ETO_OFR_DISPLAY_ID =$2
							UNION ALL
      								SELECT ETO_OFR_APPROV_DATE_ORIG,FK_GLUSR_USR_ID FROM ETO_OFR_EXPIRED	WHERE ETO_OFR_DISPLAY_ID =$2
      							)B
      					WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID";
				
				$params=array($glusrid,$offerId);
                                $sth = pg_query_params($dbh,$sql,$params);
				$rec = pg_fetch_array($sth);
				$rec=array_change_key_case($rec, CASE_UPPER);                                  
				$returnHtml['lastCallDate'] = isset($rec['LAST_CALL_ON']) ? $rec['LAST_CALL_ON'] : '';
				$returnHtml['lastCallDays'] = isset($rec['LAST_CALL_ON_DAYS']) ? $rec['LAST_CALL_ON_DAYS'] : -1;	
			}
			
			if(!empty($returnHtml['lastCallDate']) && $returnHtml['lastCallDays'] <= 30) 
    		{
    			echo '<div class="col-md-12" name="lastcallmade" id="lastcallmade" style="line-height:30px;color:#ff;display:block;">
	    		<table cellspacing="0" cellpadding="0" width="100%" border="0" style="background-color:honeydew; height:8px;">
            <tbody>
	    		<tr>
        		<td width="100%" align="center" style="font-size:12px; font-weight:bold; color:#green;&quot; ">Contact details are verified in last 30 days.</td>
	    		</tr>
            </tbody>
            </table>
				</div>';
			} else if(!empty($returnHtml['lastCallDate'])){
					echo '<div class="col-md-12" name="lastcallmade" id="lastcallmade" style="line-height:30px;color:#ff;display:block;">
	    		<table cellspacing="0" cellpadding="0" width="100%" border="0" style="background-color:#FFDEDB; height:8px;">
            <tbody>
	    		<tr>
        		<td width="100%" align="center" style="font-size:12px; font-weight:bold; color:#F23F3F;&quot; ">Contact details are verified on '.$returnHtml['lastCallDate'].'</td>
	    		</tr>
            </tbody>
            </table>
				</div>';		
			}
			exit;
	}
public function history_isq1_pg($offer_id)
   {
		$obj = new Globalconnection();
		$dbh = $obj->connect_db_yii('postgress_web215v');
		$model = new GlobalmodelForm();
		if(!$dbh)
		{
			echo "Not connected to PG database!!!";
			die;
		}
		else
		{
		$result =array();
	 
		$sql = "select * 
		from 
		(SELECT 
		ETO_ATR_HIST_ID ETO_OFR_HIST_ID, 
		ETO_ATR_HIST_UPD_TIME, 
		ETO_ATR_HIST_UPD_DATE,
		'ISQ' ATYPE,
		ETO_ATR_HIST_TYPE, 
		ETO_ATR_HIST_UPDBY_NAME,
		ETO_ATR_HIST_UPDBY_ID, 
		ETO_ATR_HIST_UPDBY_SCREEN,
		ETO_ATR_COLUMN_VALUE,
		ETO_ATR_HIST_OLD_VALUE, 
		ETO_ATR_HIST_NEW_VALUE, 
		TO_CHAR(ETO_ATR_HIST_UPD_TIME, 'ddth Mon yyyy HH24:MI:ss') ETO_OFR_HIST_DATE_SORT,
		TO_CHAR(ETO_ATR_HIST_UPD_TIME,'dd-MON-YYYY HH12:MI:SS AM') ETO_ATR_HIST_UPD_TIME_DIS
		FROM ETO_ATTRIBUTE_HISTORY 
		WHERE FK_ETO_OFR_DISPLAY_ID =$offer_id
		AND date(ETO_ATR_HIST_UPD_DATE) < date(now())-15
		) a
		ORDER BY ETO_OFR_HIST_ID DESC";

		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());

				while ($ha = $sth->read()) {
					$rec=array_change_key_case($ha,CASE_UPPER);
						array_push($result,$rec);
				}
	}
	
	
		return $result;
	}	
 public function history_isq($offer_id) {
    $result = array();
    $obj = new Globalconnection();   
    $model = new GlobalmodelForm();
    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v');
                }
   
    if(!empty($offer_id) && $offer_id > 0 && preg_match("/^\d+$/",$offer_id)) {
        $sql="select * 
		from 
		(SELECT 
		ETO_ATR_HIST_ID ETO_OFR_HIST_ID, 
		ETO_ATR_HIST_UPD_TIME, 
		ETO_ATR_HIST_UPD_DATE,
		'ISQ' ATYPE,
		ETO_ATR_HIST_TYPE, 
		ETO_ATR_HIST_UPDBY_NAME,
		ETO_ATR_HIST_UPDBY_ID, 
		ETO_ATR_HIST_UPDBY_SCREEN,
		ETO_ATR_COLUMN_VALUE,
		ETO_ATR_HIST_OLD_VALUE, 
		ETO_ATR_HIST_NEW_VALUE, 
		TO_CHAR(ETO_ATR_HIST_UPD_TIME, 'ddth Mon yyyy HH24:MI:ss') ETO_OFR_HIST_DATE_SORT,
		TO_CHAR(ETO_ATR_HIST_UPD_TIME,'dd-MON-YYYY HH12:MI:SS AM') ETO_ATR_HIST_UPD_TIME_DIS
		FROM ETO_ATTRIBUTE_HISTORY 
		WHERE FK_ETO_OFR_DISPLAY_ID =$offer_id
		
		) a
		ORDER BY ETO_OFR_HIST_ID DESC";

     $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());

            while ($rec = $sth->read()) {
                    $rec1=array_change_key_case($rec, CASE_UPPER);
                    array_push($result,$rec1);
            }
            
          // 1 day old hist
            $dbh = $obj->connect_db_yii('postgress_web215v');
            $sql = "select * 
		from 
		(SELECT 
		ETO_ATR_HIST_ID ETO_OFR_HIST_ID, 
		ETO_ATR_HIST_UPD_TIME, 
		ETO_ATR_HIST_UPD_DATE,
		'ISQ' ATYPE,
		ETO_ATR_HIST_TYPE, 
		ETO_ATR_HIST_UPDBY_NAME,
		ETO_ATR_HIST_UPDBY_ID, 
		ETO_ATR_HIST_UPDBY_SCREEN,
		ETO_ATR_COLUMN_VALUE,
		ETO_ATR_HIST_OLD_VALUE, 
		ETO_ATR_HIST_NEW_VALUE, 
		TO_CHAR(ETO_ATR_HIST_UPD_TIME, 'ddth Mon yyyy HH24:MI:ss') ETO_OFR_HIST_DATE_SORT,
		TO_CHAR(ETO_ATR_HIST_UPD_TIME,'dd-MON-YYYY HH12:MI:SS AM') ETO_ATR_HIST_UPD_TIME_DIS
		FROM ETO_ATTRIBUTE_HISTORY 
		WHERE FK_ETO_OFR_DISPLAY_ID =$offer_id
		AND date(ETO_ATR_HIST_UPD_DATE) = date(now())
		) a
		ORDER BY ETO_OFR_HIST_ID DESC";  
     
//      $sth = pg_query($dbh, $sql); 
     $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());

            while ($rec = $sth->read()) {
                    $rec1=array_change_key_case($rec, CASE_UPPER);
                    array_push($result,$rec1);
            }
            
        }
        else{
            echo '<div align="center" style="font-family:arial; font-size: 14px; font-weight: bold;"><font color="red">Sorry, Please enter Valid Offer ID</font></div>';
        exit;
        }
    return $result;
    }   
    


 public function feedback($offer){
    $sql = "select 
BUYER_REQ_OVR_OFR_DISPLAY_ID,
IIL_NPS_SCORE ,
IIL_NPS_COMMENT,
BUYER_REQ_OVR_MEDIUM_TYPE,
BUYER_REQ_OVER_RECV_DAY,
BUYER_REQ_OVER_DATE,
FEEDBACK_RECEIVED_MEDIUM,
FEEDBACK_RECEIVED_MODE,
(CASE WHEN BUYER_FEEDBACK_FLAG = 1 AND FEEDBACK_RECEIVED ='In Negotiation - Click' THEN 'In Negotiation - Submit' ELSE FEEDBACK_RECEIVED END) FEEDBACK_RECEIVED,
BUYER_REQ_OVR_SUP_GLUSR_ID,BUYER_REQ_OVR_POST_FLAG,
BUYER_FEEDBACK_FLAG,
BUYER_REQ_OVR_POST_OTHR || ' '|| BUYER_REQ_OVR_OTHR_SUP_DET AS BUYER_REQ_OVR_POST_OTHR,
STRING_AGG(FK_GLUSR_USR_ID::CHAR,', ') SUPP_CONNECTED 
from (
SELECT 
BUYER_REQ_OVR_ID,
BUYER_REQ_OVR_OFR_DISPLAY_ID,
IIL_NPS_SCORE ,
IIL_NPS_COMMENT,
BUYER_REQ_OVR_MEDIUM_TYPE,
BUYER_REQ_OVER_RECV_DAY,
BUYER_REQ_OVER_DATE,
(CASE WHEN BUYER_REQ_OVR_MEDIUM_TYPE='LEAP' then 'From Leap Call'
WHEN BUYER_REQ_OVR_MEDIUM_TYPE='MY' then 'From MY Team'
WHEN BUYER_REQ_OVR_MEDIUM_TYPE='EMKTG' AND BUYER_REQ_OVER_RECV_DAY = 0 then  'From ASTBUY Mailer'
WHEN (BUYER_REQ_OVR_MEDIUM_TYPE = 'EMKTG' OR BUYER_REQ_OVR_MEDIUM_TYPE is null) and BUYER_REQ_OVER_RECV_DAY <> 0 then 'From Feedback Mailer'
ELSE '' END) FEEDBACK_RECEIVED_MEDIUM,

(CASE
WHEN (BUYER_REQ_OVR_ENQ_TYP IS NULL OR BUYER_REQ_OVR_ENQ_TYP=0) then 'Feedback received through Mail'
WHEN BUYER_REQ_OVR_ENQ_TYP=1 then  'Feedback received through SMS'
WHEN BUYER_REQ_OVR_ENQ_TYP=2 then  'Feedback received through Notification'
ELSE '' END) FEEDBACK_RECEIVED_MODE,
(CASE 
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =111 THEN 'Completed through IndiaMART Supplier - Click'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-1  THEN 'Completed through IndiaMART Supplier - Click (Submit without selection)'
WHEN BUYER_REQ_OVR_BUY_GLUSR_ID IS NOT NULL THEN 'Completed through IndiaMART Supplier - Submit '
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-111 THEN 'Completed through IndiaMART Supplier - Submit  (Doesnot remember supplier name)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =222  THEN 'Completed through Other Supplier - Click'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = -1 THEN 'Completed through Other Supplier - Submit (Submit without selection of reason)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and (BUYER_REQ_OVR_POST_FLAG = 0 or BUYER_REQ_OVR_POST_FLAG is null) THEN 'Completed through Other Supplier - Submit ' 
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = 1  THEN 'Completed through Other Supplier - Submit (Prices are too high)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = 2  THEN ' Completed through Other Supplier - Submit (Supplier did not deal in your requirement)' 
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = 3  THEN ' Completed through Other Supplier - Submit (Supplier did not deal in small quantity)' 
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = 4  THEN 'Completed through Other Supplier - Submit (Supplier did not respond on the phone)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = 5  THEN 'Completed through Other Supplier - Submit  (Supplier did not send the quotations)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = 6  THEN 'Completed through Other Supplier - Submit (Supplier did not deal in local area)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-999 and BUYER_REQ_OVR_POST_FLAG = 7  THEN 'Completed through Other Supplier - Submit (Other reason)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-555 THEN 'In Negotiation - Click' 
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-777 THEN 'OTHER REASONS'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and  BUYER_REQ_OVR_POST_FLAG = null THEN 'Requirement Postponed - Click'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and  BUYER_REQ_OVR_POST_FLAG = -1 THEN 'Requirement Postponed - Submit (Submit without selection of reason)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and BUYER_REQ_OVR_POST_FLAG =  0  THEN 'Requirement Postponed - Submit '
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and  BUYER_REQ_OVR_POST_FLAG = 1  THEN 'Requirement Postponed - Submit (You wanted price and quotation only)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and  BUYER_REQ_OVR_POST_FLAG = 2  THEN 'Requirement Postponed - Submit (Supplier is taking too much time to respond)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and  BUYER_REQ_OVR_POST_FLAG = 3  THEN 'Requirement Postponed - Submit (Prices are too high)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and  BUYER_REQ_OVR_POST_FLAG = 4  THEN 'Requirement Postponed - Submit (Response awaited from your customer)'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-888 and  BUYER_REQ_OVR_POST_FLAG = 5  THEN 'Requirement Postponed - Submit (Other reasons) '
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =444  THEN 'Suppliers not responding - Click'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-444  THEN 'Supplier not responding - Submit '
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =333  THEN 'Need More Suppliers - Click'
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-333 and BUYER_REQ_OVER_RECV_PTT = 1  THEN 'Need More Suppliers - Submit (Insta-Astbuy done) '
WHEN BUYER_REQ_OVR_SUP_GLUSR_ID =-333 and BUYER_REQ_OVER_RECV_PTT <> 1  THEN 'Need More Suppliers - Submit (Insta-Astbuy not done)'
ELSE '' END) FEEDBACK_RECEIVED , BUYER_REQ_OVR_SUP_GLUSR_ID,BUYER_REQ_OVR_POST_FLAG,BUYER_REQ_OVR_POST_OTHR , BUYER_REQ_OVR_OTHR_SUP_DET   

from buyer_requirement_over over left join IIL_NPS on FK_BUYER_NPS_ID=IIL_NPS_ID 
where BUYER_REQ_OVR_OFR_DISPLAY_ID=$offer
) A left join BUYER_FEEDBACK_CONTACTED_SUPP on 
BUYER_REQ_OVR_ID=BUYER_FEEDBACK_CONTACTED_SUPP.FK_BUYER_REQ_OVR_ID
GROUP BY BUYER_REQ_OVR_OFR_DISPLAY_ID,
IIL_NPS_SCORE ,
IIL_NPS_COMMENT,
BUYER_REQ_OVR_MEDIUM_TYPE,
BUYER_REQ_OVER_RECV_DAY,
BUYER_REQ_OVER_DATE,
FEEDBACK_RECEIVED_MEDIUM,
FEEDBACK_RECEIVED_MODE,
FEEDBACK_RECEIVED, 
BUYER_REQ_OVR_SUP_GLUSR_ID,
BUYER_REQ_OVR_POST_FLAG,
BUYER_FEEDBACK_FLAG,
BUYER_REQ_OVR_POST_OTHR,
BUYER_REQ_OVR_OTHR_SUP_DET";

    $bind=array();$i=0;
    $obj = new Globalconnection();                   
    $model = new GlobalmodelForm();
    
    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v');
   } 

			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                        while($value = $sth->read()) {
                                $tr .= '<tr><td width="10%"><b>Offer ID</b></td><td width="90%">'.$value['buyer_req_ovr_ofr_display_id'].'</td></tr>
                                    <tr><td width="10%"><b>Feedback Received Day</b></td><td width="90%">'.$value['buyer_req_over_recv_day'].'</td></tr>
                                    <tr><td width="10%"><b>Feedback Received Date</b></td><td width="90%">'.$value['buyer_req_over_date'].'</td></tr>
                                    <tr><td width="10%"><b>Feedback Source</b></td><td width="90%">'.$value['feedback_received_medium'].'</td></tr>
                                    <tr><td width="10%"><b>Feedback Mode</b></td><td width="90%">'.$value['feedback_received_mode'].'</td></tr>
                                    <tr><td width="10%"><b>Feedback</b></td><td width="90%">'.$value['feedback_received'].'</td></tr>
                                    <tr><td width="10%"><b>Feedback Comments</b></td><td width="90%">'.$value['buyer_req_ovr_post_othr'].'</td></tr>
                                    <tr><td width="10%"><b>Supplier Selected</b></td><td width="90%">'.$value['supp_connected'].'</td></tr>    
                                    <tr><td width="10%"><b>NPS</b></td><td width="90%">'.$value['iil_nps_score'].'</td></tr>
                                    <tr><td width="10%"><b>NPS Comment</b></td><td width="90%">'.$value['iil_nps_comment'].'</td></tr>';
                                $i=1;
                           }			
    
    echo '<div align="center"><b>Feedback Details</b></div></br>';
    echo '<table align="center" cellspacing="0" cellpadding="2" border="1"  width="100%" style="font-family: arial; font-size: 12px;">';
 
if($i==0){
    echo '<tr><td align="center" width="100%" >No Feedback Received';
}else{
   echo $tr; 
}
echo '</table> <br>';
exit;   
} 

   public function histOfrAllDet_pg($request,$model,$status_type,$status_disp,$histid) {
    
    $obj = new Globalconnection();   
    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v');
                }
    $offer = $request->getParam('offer',0);    
      $field_disp = array('ETO_OFR_TYP' => 'Offer Type','ETO_OFR_PROD_SERV'=>'Service','FK_GLCAT_CAT_ID'=>'Category ID','ETO_OFR_TITLE'=>'Title','ETO_OFR_DATE'=>'Refresh Date','ETO_OFR_EXP_DATE'=>'Expiry Date','ETO_OFR_DESC'=>'Description','ETO_OFR_SPEC'=>'Specification','ETO_OFR_QTY'=>'Quantity','ETO_OFR_QTY_UNIT'=>'Quantity Unit','FK_GL_CONTINENT_ID'=>'Continent ID','ETO_OFR_PAY_TERM'=>'Payment Term','ETO_OFR_SUPPLY_TERM'=>'Supply Term','ETO_OFR_APPROV'=>'Approved Type','ETO_OFR_QLTY'=>'QLTY','FK_EMPLOYEE_ID'=>'Emp ID','ETO_OFR_APPROV_DATE'=>'Approved Date','ETO_OFR_KEYWORDS'=>'Keywords','FK_GLCAT_MCAT_ID'=>'MCAT ID','ETO_OFR_IMAGE_PATH1'=>'Image Path1','ETO_OFR_IMAGE_PATH2'=>'Image Path2','ETO_OFR_IMAGE_PATH3'=>'Image Path3','ETO_OFR_QUALITY'=>'Quality','FK_GL_MODULE_ID'=>'Module ID','ETO_OFR_PAGE_REFERRER'=>'Page Referer','ETO_OFR_S_IP'=>'Sender IP','ETO_OFR_S_IP_COUNTRY'=>'Sender IP Country Name','ETO_OFR_S_SENDERNAME'=>'Sender Name','ETO_OFR_S_ORGANIZATION'=>'Sender Company Name','ETO_OFR_S_DESIGNATION'=>'Sender Designation','ETO_OFR_S_STREETADDRESS'=>'Sender Address','ETO_OFR_S_CITY'=>'Sender City','ETO_OFR_S_STATE'=>'Sender State','ETO_OFR_S_ZIP'=>'Sender Zip Code','ETO_OFR_S_COUNTRY'=>'Sender Country Name' ,'ETO_OFR_S_PH_COUNTRY'=>'Sender Phone Country ID','ETO_OFR_S_PH_AREA'=>'Sender Phone Area','ETO_OFR_S_PH_NUMBER'=>'Sender Phone Number','ETO_OFR_S_PH_MOBILE'=>'Sender Mobile Number','ETO_OFR_S_URL'=>'Sender URL','FK_GL_COUNTRY_ISO'=>'Country ISO','ETO_OFR_GL_COUNTRY_NAME'=>'Country Name','ETO_OFR_GL_COUNTRY_FLAG'=>'Country Flag','ETO_OFR_GLCAT_CAT_NAME'=>'Category Name','ETO_OFR_GLCAT_MCAT_NAME'=>'MCAT Name','ETO_OFR_RESPONSE'=>'Response Count','ETO_OFR_HIT'=>'Hit Count','ETO_OFR_IS_FLAGGED'=>'IS_FLAGGED',
      'ETO_OFR_GEOGRAPHY_ID' => 'Geography',
      'ETO_OFR_REQ_APP_USAGE'  => 'Req app usage',               
      'ETO_OFR_APPROX_ORDER_VALUE' => 'Approx Order Value',            
      'ETO_OFR_REQ_PURCHASE_PERIOD'  => 'Purchase Period',              
      'ETO_OFR_GEO_CITY1_ID' =>  'City1 Id',            
      'ETO_OFR_GEO_CITY2_ID' =>  'City2 Id',                   
      'ETO_OFR_GEO_CITY3_ID' =>  'City3 Id',                    
      'ETO_OFR_REQ_DESTINATION_PORT' => 'Destination Port',          
      'ETO_OFR_REQ_PAYMENT_MODE' =>  'Payment Mode',                 
      'ETO_OFR_REQ_SHIPMENT_MODE' => 'Shipment Mode',                 
      'ETO_OFR_CALL_VERIFIED'  =>  'Call Verified Flag',                   
      'ETO_OFR_EMAIL_VERIFIED' =>  'Email Verified Flag',                   
      'ETO_OFR_ONLINE_VERIFIED' => 'Online Verified Flag',                  
      'ETO_OFR_OTHER_DETAIL' =>  'Other Details',                     
      'ETO_OFR_REQ_TYPE' =>  'Requirement Type',
      'ETO_OFR_ENQ_TYP' =>  'Enquiry Type',
      'ETO_OFR_REQ_FREQ' => 'Requirement Frequency',
      'ETO_OFR_ORIGINAL_IMAGE' => 'Attachment',
      'ETO_OFR_GLUSR_USERNAME' => 'User Name',
      'ETO_OFR_COMPANYNAME' => 'Company Name',
      'ETO_OFR_GLUSR_DISP_URL' => 'Url',
      'ETO_OFR_LOCATION' => 'Location',
      'ETO_ENQ_PURPOSE' => 'Enquiry Purpose',
      'ETO_ENQ_TYP' => 'Enquiry Type',
      'ETO_OFR_CURRENCY_ID' => 'Currency',
      'USER_IDENTIFIER_FLAG' => 'User Identifier Flag',
    'DIR_QUERY_MCATID'=>'MCAT ID',
    'DIR_QUERY_CATID'=> 'Category ID',
    'ETO_OFR_MODREFID'=> 'MODREFID',
    'ETO_OFR_MODREF_DISPNAME'=>'MODREF_DISPNAME',
    'RAG_SCORE_TOTAL'=>'Rag Score' 
      );
      $condition='';
      if(!empty($histid) && $histid > 0 && preg_match("/^\d+$/",$histid)) {
         $condition= " AND ETO_OFR_HIST_ID < ".$histid;
      }
    
    if(!empty($offer) && $offer > 0 && preg_match("/^\d+$/",$offer)) {
    $sql = "Select    
    Eto_Ofr_Hist_Id,
    Eto_Ofr_Hist_Date,
    (TO_CHAR(ETO_OFR_HIST_DATE, 'ddth Mon yyyy HH24:MI:ss')) ETO_OFR_HIST_DATE_SORT,
    'OFFER' ATYPE,
    To_Char(Eto_Ofr_Hist_Date, 'DD-MON-yyyy HH:MI:SS AM') Eto_Ofr_Hist_Date_Disp,  
    Eto_Ofr_Hist_Emp_Id,
    Eto_Ofr_Hist_Usr_Id,Eto_Ofr_Hist_By,
    Eto_Ofr_Hist_Using  || ' [IP-' || eto_ofr_hist_ip  || ']' AS Eto_Ofr_Hist_Using,
    Eto_Ofr_Hist_Ip_Country,
    Eto_Ofr_Hist_Comments,
    Eto_Ofr_Hist_Ip,
    Eto_Ofr_Hist_Typ,
    Eto_Ofr_Hist_Approv_Flag,
    Eto_Ofr_Hist_Field,
    ( CASE Eto_Ofr_Hist_Field
        WHEN 'FK_GLCAT_MCAT_ID' THEN ETO_OFR_HIST_OLD_VAL || (SELECT (case GLCAT_MCAT_IS_GENERIC when 1 then ' - PMCAT' else '' end) FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'USER_IDENTIFIER_FLAG' THEN ETO_OFR_HIST_OLD_VAL || coalesce((SELECT ' | ' || IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=107 and IIL_MASTER_DATA_VALUE=ETO_OFR_HIST_OLD_VAL),'')
        WHEN 'ETO_OFR_GEO_CITY1_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'ETO_OFR_GEO_CITY2_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'ETO_OFR_GEO_CITY3_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'ETO_OFR_REQ_PURCHASE_PERIOD' THEN (case cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) when 1 then 'Immediate' when 2 then 'Within 15 Days' when 3 then 'Within 30 Days' when 4 then'After 1 Month' end)
        WHEN 'ETO_OFR_GEOGRAPHY_ID' THEN (case cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) when 1 then 'Local Only' when 2 then 'Anywhere in India' when 3 then ' Global' when 4 then 'Specific Cities' end)
        WHEN 'ETO_OFR_REQ_FREQ' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'One Time Requirement' WHEN 2 THEN 'Regular Requirement' WHEN 3 THEN 'Regular Requirement-Daily' WHEN 4 THEN 'Regular Requirement-Weekly' WHEN 5 THEN 'Regular Requirement-Monthly' WHEN 6 THEN 'Regular Requirement-Quarterly' WHEN 7 THEN 'Regular Requirement-Half Yearly' WHEN 8 THEN 'Regular Requirement-Yearly' END)
        WHEN 'ETO_OFR_REQ_TYPE' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'For Reselling' WHEN 2 THEN 'For Your End Use' WHEN 3 THEN 'As Raw Material' END)
        WHEN 'ETO_ENQ_PURPOSE' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'To Make Purchase' WHEN 2 THEN 'To Know Price Only' END)
        WHEN 'ETO_ENQ_TYP' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'Manual Retail | ' WHEN 2 THEN 'Bulk | ' WHEN 3 THEN 'Auto Retail-Order value | ' WHEN 4 THEN 'Bulk | ' WHEN 5 THEN 'Auto Retail- Quantity | ' when 6 then 'Retail - basis Retail NI | ' END) || ETO_OFR_HIST_OLD_VAL
        WHEN 'ETO_OFR_CURRENCY_ID' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'INR - Indian Rupee' WHEN 2 THEN 'USD - U.S Dollar' WHEN 3 THEN 'GBP - Pound Sterling' WHEN 4 THEN 'EUR - Euro' WHEN 5 THEN 'AUD - Australian Dollar' WHEN 6 THEN 'CAD - Canadian Dollar' WHEN 7 THEN 'CHF - Swiss Franc' WHEN 8 THEN 'PY - Japanese Yen' WHEN 9 THEN 'HKD - Hong Kong Dollar' WHEN 10 THEN 'NZD - New Zealand Dollar' WHEN 11 THEN 'SGD - Singapore Dollar' WHEN 12 THEN 'NTD - Taiwan Dollar' WHEN 13 THEN 'RMB - Renminbi' END)
        ELSE ETO_OFR_HIST_OLD_VAL
    END    )ETO_OFR_HIST_OLD_VAL,
    ( CASE Eto_Ofr_Hist_Field
        WHEN 'FK_GLCAT_MCAT_ID' THEN ETO_OFR_HIST_NEW_VAL || (SELECT (case GLCAT_MCAT_IS_GENERIC when 1 then ' - PMCAT' else '' end) FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        when 'ETO_OFR_GEO_CITY1_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        when 'ETO_OFR_GEO_CITY2_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        WHEN 'ETO_OFR_GEO_CITY3_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        WHEN 'ETO_OFR_REQ_PURCHASE_PERIOD' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'Immediate' WHEN 2 THEN 'Within 15 Days' WHEN 3 THEN 'Within 30 Days' WHEN 4 THEN 'After 1 Month' END)
        WHEN 'ETO_OFR_GEOGRAPHY_ID' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'Local Only' WHEN 2 THEN 'Anywhere in India' WHEN 3 THEN ' Global' WHEN 4 THEN 'Specific Cities' END)
        WHEN 'ETO_OFR_REQ_FREQ' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'One Time Requirement' WHEN 2 THEN 'Regular Requirement' WHEN 3 THEN 'Regular Requirement-Daily' WHEN 4 THEN 'Regular Requirement-Weekly' WHEN 5 THEN 'Regular Requirement-Monthly' WHEN 6 THEN 'Regular Requirement-Quarterly' WHEN 7 THEN 'Regular Requirement-Half Yearly' WHEN 8 THEN 'Regular Requirement-Yearly' END)
        WHEN 'ETO_OFR_REQ_TYPE' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'For Reselling' WHEN 2 THEN 'For Your End Use' WHEN 3 THEN 'As Raw Material' END)
        WHEN 'ETO_ENQ_PURPOSE' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'To Make Purchase' WHEN 2 THEN 'To Know Price Only' END)
        WHEN 'ETO_ENQ_TYP' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'Manual Retail | ' WHEN 2 THEN 'Bulk |' WHEN 3 THEN 'Auto Retail-Order value | ' WHEN 4 THEN 'Bulk | ' WHEN 5 THEN 'Auto Retail- Quantity |'  when 6 then 'Retail - basis Retail NI | ' end) || ETO_OFR_HIST_NEW_VAL
        WHEN 'ETO_OFR_CURRENCY_ID' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'INR - Indian Rupee' WHEN 2 THEN 'USD - U.S Dollar' WHEN 3 THEN 'GBP - Pound Sterling' WHEN 4 THEN 'EUR - Euro' WHEN 5 THEN 'AUD - Australian Dollar' WHEN 6 THEN 'CAD - Canadian Dollar' WHEN 7 THEN 'CHF - Swiss Franc' WHEN 8 THEN 'PY - Japanese Yen' WHEN 9 THEN 'HKD - Hong Kong Dollar' WHEN 10 THEN 'NZD - New Zealand Dollar' WHEN 11 THEN 'SGD - Singapore Dollar' WHEN 12 THEN 'NTD - Taiwan Dollar' WHEN 13 THEN 'RMB - Renminbi' END)
        when 'ETO_OFR_APPROX_ORDER_VALUE'  THEN  
                          (CASE WHEN (ETO_OFR_HIST_NEW_VAL ~ '^[0-9]+$') AND ETO_OFR_HIST_USING='Buy Lead Approval Form'
                                     THEN ( CASE WHEN FK_GL_COUNTRY_ISO='IN'
                                                     THEN coalesce(( SELECT INDIAN_VALUE  FROM BL_VALUE_RANGE WHERE BL_VALUE_RANGE_ID= cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric)),'')
                                                 ELSE     coalesce((SELECT FOREIGN_VALUE FROM BL_VALUE_RANGE WHERE BL_VALUE_RANGE_ID= cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric)),'')

END
                                           )
                                 ELSE ETO_OFR_HIST_NEW_VAL
                            END)                           
        WHEN 'USER_IDENTIFIER_FLAG'  THEN  ETO_OFR_HIST_NEW_VAL || coalesce((SELECT ' | ' || IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=107 and IIL_MASTER_DATA_VALUE=ETO_OFR_HIST_NEW_VAL),'')
        ELSE ETO_OFR_HIST_NEW_VAL
        END )ETO_OFR_HIST_NEW_VAL,
        FK_ETO_OFR_ID
FROM
    ETO_OFR_HIST_MAIN left outer join ETO_OFR_HIST_DETAIL on ETO_OFR_HIST_ID = FK_ETO_OFR_HIST_ID  
WHERE    
     FK_ETO_OFR_ID =$offer $condition AND to_char(ETO_OFR_HIST_DATE,'yyyy-mm-dd') = date(now())::text";  
     
//      $sth = pg_query($dbh, $sql); 
     $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());

            while ($rec = $sth->read()) {
                    $rec=array_change_key_case($rec, CASE_UPPER);
                    array_push($result,$rec);
            }
          // 1 day old hist
            
            $dbh = $obj->connect_db_yii('postgress_web215v');
            $sql = "Select    
    Eto_Ofr_Hist_Id,
    Eto_Ofr_Hist_Date,
    (TO_CHAR(ETO_OFR_HIST_DATE, 'ddth Mon yyyy HH24:MI:ss')) ETO_OFR_HIST_DATE_SORT,
    'OFFER' ATYPE,
    To_Char(Eto_Ofr_Hist_Date, 'DD-MON-yyyy HH:MI:SS AM') Eto_Ofr_Hist_Date_Disp,  
    Eto_Ofr_Hist_Emp_Id,
    Eto_Ofr_Hist_Usr_Id,Eto_Ofr_Hist_By,
    Eto_Ofr_Hist_Using  || ' [IP-' || eto_ofr_hist_ip  || ']' AS Eto_Ofr_Hist_Using,
    Eto_Ofr_Hist_Ip_Country,
    Eto_Ofr_Hist_Comments,
    Eto_Ofr_Hist_Ip,
    Eto_Ofr_Hist_Typ,
    Eto_Ofr_Hist_Approv_Flag,
    Eto_Ofr_Hist_Field,
    ( CASE Eto_Ofr_Hist_Field
        WHEN 'FK_GLCAT_MCAT_ID' THEN ETO_OFR_HIST_OLD_VAL || (SELECT (case GLCAT_MCAT_IS_GENERIC when 1 then ' - PMCAT' else '' end) FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'USER_IDENTIFIER_FLAG' THEN ETO_OFR_HIST_OLD_VAL || coalesce((SELECT ' | ' || IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=107 and IIL_MASTER_DATA_VALUE=ETO_OFR_HIST_OLD_VAL),'')
        WHEN 'ETO_OFR_GEO_CITY1_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'ETO_OFR_GEO_CITY2_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'ETO_OFR_GEO_CITY3_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric))
        WHEN 'ETO_OFR_REQ_PURCHASE_PERIOD' THEN (case cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) when 1 then 'Immediate' when 2 then 'Within 15 Days' when 3 then 'Within 30 Days' when 4 then'After 1 Month' end)
        WHEN 'ETO_OFR_GEOGRAPHY_ID' THEN (case cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) when 1 then 'Local Only' when 2 then 'Anywhere in India' when 3 then ' Global' when 4 then 'Specific Cities' end)
        WHEN 'ETO_OFR_REQ_FREQ' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'One Time Requirement' WHEN 2 THEN 'Regular Requirement' WHEN 3 THEN 'Regular Requirement-Daily' WHEN 4 THEN 'Regular Requirement-Weekly' WHEN 5 THEN 'Regular Requirement-Monthly' WHEN 6 THEN 'Regular Requirement-Quarterly' WHEN 7 THEN 'Regular Requirement-Half Yearly' WHEN 8 THEN 'Regular Requirement-Yearly' END)
        WHEN 'ETO_OFR_REQ_TYPE' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'For Reselling' WHEN 2 THEN 'For Your End Use' WHEN 3 THEN 'As Raw Material' END)
        WHEN 'ETO_ENQ_PURPOSE' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'To Make Purchase' WHEN 2 THEN 'To Know Price Only' END)
        WHEN 'ETO_ENQ_TYP' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'Manual Retail | ' WHEN 2 THEN 'Bulk | ' WHEN 3 THEN 'Auto Retail-Order value | ' WHEN 4 THEN 'Bulk | ' WHEN 5 THEN 'Auto Retail- Quantity | '  when 6 then 'Retail - basis Retail NI | '  END) || ETO_OFR_HIST_OLD_VAL
        WHEN 'ETO_OFR_CURRENCY_ID' THEN (CASE cast(nullif(ETO_OFR_HIST_OLD_VAL,'') as numeric) WHEN 1 THEN 'INR - Indian Rupee' WHEN 2 THEN 'USD - U.S Dollar' WHEN 3 THEN 'GBP - Pound Sterling' WHEN 4 THEN 'EUR - Euro' WHEN 5 THEN 'AUD - Australian Dollar' WHEN 6 THEN 'CAD - Canadian Dollar' WHEN 7 THEN 'CHF - Swiss Franc' WHEN 8 THEN 'PY - Japanese Yen' WHEN 9 THEN 'HKD - Hong Kong Dollar' WHEN 10 THEN 'NZD - New Zealand Dollar' WHEN 11 THEN 'SGD - Singapore Dollar' WHEN 12 THEN 'NTD - Taiwan Dollar' WHEN 13 THEN 'RMB - Renminbi' END)
        ELSE ETO_OFR_HIST_OLD_VAL
    END    )ETO_OFR_HIST_OLD_VAL,
    ( CASE Eto_Ofr_Hist_Field
        WHEN 'FK_GLCAT_MCAT_ID' THEN ETO_OFR_HIST_NEW_VAL || (SELECT (case GLCAT_MCAT_IS_GENERIC when 1 then ' - PMCAT' else '' end) FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        when 'ETO_OFR_GEO_CITY1_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        when 'ETO_OFR_GEO_CITY2_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        WHEN 'ETO_OFR_GEO_CITY3_ID' THEN (select GL_CITY_NAME from GL_CITY where GL_CITY_ID = cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric))
        WHEN 'ETO_OFR_REQ_PURCHASE_PERIOD' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'Immediate' WHEN 2 THEN 'Within 15 Days' WHEN 3 THEN 'Within 30 Days' WHEN 4 THEN 'After 1 Month' END)
        WHEN 'ETO_OFR_GEOGRAPHY_ID' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'Local Only' WHEN 2 THEN 'Anywhere in India' WHEN 3 THEN ' Global' WHEN 4 THEN 'Specific Cities' END)
        WHEN 'ETO_OFR_REQ_FREQ' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'One Time Requirement' WHEN 2 THEN 'Regular Requirement' WHEN 3 THEN 'Regular Requirement-Daily' WHEN 4 THEN 'Regular Requirement-Weekly' WHEN 5 THEN 'Regular Requirement-Monthly' WHEN 6 THEN 'Regular Requirement-Quarterly' WHEN 7 THEN 'Regular Requirement-Half Yearly' WHEN 8 THEN 'Regular Requirement-Yearly' END)
        WHEN 'ETO_OFR_REQ_TYPE' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'For Reselling' WHEN 2 THEN 'For Your End Use' WHEN 3 THEN 'As Raw Material' END)
        WHEN 'ETO_ENQ_PURPOSE' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'To Make Purchase' WHEN 2 THEN 'To Know Price Only' END)
        WHEN 'ETO_ENQ_TYP' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'Manual Retail | ' WHEN 2 THEN 'Bulk |' WHEN 3 THEN 'Auto Retail-Order value | ' WHEN 4 THEN 'Bulk | ' WHEN 5 THEN 'Auto Retail- Quantity |'  when 6 then 'Retail - basis Retail NI | ' end) || ETO_OFR_HIST_NEW_VAL
        WHEN 'ETO_OFR_CURRENCY_ID' THEN (CASE cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric) WHEN 1 THEN 'INR - Indian Rupee' WHEN 2 THEN 'USD - U.S Dollar' WHEN 3 THEN 'GBP - Pound Sterling' WHEN 4 THEN 'EUR - Euro' WHEN 5 THEN 'AUD - Australian Dollar' WHEN 6 THEN 'CAD - Canadian Dollar' WHEN 7 THEN 'CHF - Swiss Franc' WHEN 8 THEN 'PY - Japanese Yen' WHEN 9 THEN 'HKD - Hong Kong Dollar' WHEN 10 THEN 'NZD - New Zealand Dollar' WHEN 11 THEN 'SGD - Singapore Dollar' WHEN 12 THEN 'NTD - Taiwan Dollar' WHEN 13 THEN 'RMB - Renminbi' END)
        when 'ETO_OFR_APPROX_ORDER_VALUE'  THEN  
                          (CASE WHEN (ETO_OFR_HIST_NEW_VAL ~ '^[0-9]+$') AND ETO_OFR_HIST_USING='Buy Lead Approval Form'
                                     THEN ( CASE WHEN FK_GL_COUNTRY_ISO='IN'
                                                     THEN coalesce(( SELECT INDIAN_VALUE  FROM BL_VALUE_RANGE WHERE BL_VALUE_RANGE_ID= cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric)),'')
                                                 ELSE     coalesce((SELECT FOREIGN_VALUE FROM BL_VALUE_RANGE WHERE BL_VALUE_RANGE_ID= cast(nullif(ETO_OFR_HIST_NEW_VAL,'') as numeric)),'')

                                            END
                                           )
                                 ELSE ETO_OFR_HIST_NEW_VAL
                            END)                           
        WHEN 'USER_IDENTIFIER_FLAG'  THEN  ETO_OFR_HIST_NEW_VAL || coalesce((SELECT ' | ' || IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=107 and IIL_MASTER_DATA_VALUE=ETO_OFR_HIST_NEW_VAL),'')
        ELSE ETO_OFR_HIST_NEW_VAL
        END )ETO_OFR_HIST_NEW_VAL,
        FK_ETO_OFR_ID
FROM
    ETO_OFR_HIST_MAIN left outer join ETO_OFR_HIST_DETAIL on ETO_OFR_HIST_ID = FK_ETO_OFR_HIST_ID  
WHERE    
     FK_ETO_OFR_ID =$offer $condition";  
     
//      $sth = pg_query($dbh, $sql); 
     $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());

            while ($rec = $sth->read()) {
                    $rec=array_change_key_case($rec, CASE_UPPER);
                    array_push($result,$rec);
            }
            
        }
        else{
            echo '<div align="center" style="font-family:arial; font-size: 14px; font-weight: bold;"><font color="red">Sorry, Please enter Valid Offer ID</font></div>';
        exit;
        }
        
    return array("result"=>$result,"field_disp"=>$field_disp);
    }   
    
    
 public function FCPDetail($offerid)
{
     $newval=$oldval='';
     try{
	$obj = new Globalconnection();  
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v');
                }
            if($dbh){
                $model = new GlobalmodelForm();
		$sql = "SELECT eto_ofr_display_id,gl_profile_old_value,gl_profile_new_value FROM BL_PROFILE_ENRICHMENT where fk_module_name = 'LEAP CRM' AND ETO_OFR_DISPLAY_ID=$offerid AND FK_GL_ATTRIBUTE_ID =-1 ";
                $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
                while ($temp = $sth->read())
		{ 
			$oldval = (@$temp['gl_profile_old_value'] == 1) ? 'Applicable' : 'Not Applicable';

			if(@$temp['gl_profile_new_value'] == 1){
				$newval .= '(<span  style="text-align:center;color:green" bgcolor="#dff8ff" width="12%">FCP - '.$oldval.' and Created for Offer-'.$temp['eto_ofr_display_id'].'</span>)';
}
			elseif(@$temp['gl_profile_new_value'] == 2){
				$newval .= '(<span  style="text-align:center;color:red" bgcolor="#dff8ff" width="12%">FCP - '.$oldval.' but Not Created  for Offer-'.$temp['eto_ofr_display_id'].'</span>)';
			}else{
				$newval .= '(<span  style="text-align:center;" bgcolor="#dff8ff" width="12%">FCP - Creation Not Applicatble for Offer-'.$temp['eto_ofr_display_id'].'</span>)';
			}                        
                }
        }
        } catch (Exception $ex) {

        } 
        if($newval==''){
            $newval='No Data Found for FCP';
        }
	return $newval;
}   
      public function showproduct($gluserid)
    {
          $item_name='';  
          $url="http://mapi.indiamart.com/wservce/products/Userlisting/";
          $content = array(
                            'token' =>'imobile@15061981',
                            'ordering' =>1,
                            'status'=>'ALL',
                            'modid'=>'GLADMIN',
                            'glusrid' => $gluserid
                            );
                            // $data_string = http_build_query($content);
          
          $ServiceGlobalModelForm=new ServiceGlobalModelForm();
          $response=$ServiceGlobalModelForm->mapiService('USERLISTING',$url,$content,'No');  
	  $prddata = (array) $response;
            $i=0;
             $item_name = '<table align="center" border="1" cellpadding="1" cellspacing="0" width="100%"><tr><td style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">SN</td><td style="font-family: arial; font-size: 14px; font-weight: bold;" align="center" bgcolor="#eaeaea" height="30">Item Name</td></tr>';
            foreach($prddata as $val)
            {  $i++;
                if(isset($val['ITEM_NAME'])){
                    $item_name .= '<tr><td align="center">'.$i.'</td><td align="left" style="font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}"> '.$val['ITEM_NAME'].'</td></tr>';
                }               
            }
            $item_name .= '</table>';
    return $item_name;
}

  
    public function multiplecallrecord($offer) 
	{  
                        $atttach=array();
	                $obj = new Globalconnection();
                        $model = new GlobalmodelForm();
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                                $dbh = $obj->connect_db_yii('postgress_web77v');   
                        }else{
                                $dbh = $obj->connect_db_yii('postgress_web68v'); 
                        }                    
                        if($dbh && $offer>0){
                            $sql = "SELECT to_char(RECORDING_DATE,'dd-Mon-YYYY HH:MI:SSAM') RECORDING_DATE,LEAP_CALL_RECORDING_URL FROM LEAP_CALL_RECORDING WHERE FK_ETO_OFR_DISPLAY_ID=:FK_ETO_OFR_DISPLAY_ID";		
                            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(':FK_ETO_OFR_DISPLAY_ID'=>$offer));//echo $sql;        
                            while($rec = $sth->read()) {
                                    $atttachsth=array_change_key_case($rec, CASE_UPPER);   
                                    array_push($atttach,$atttachsth);
                           }
                        } 
                        return $atttach;
	}          
    public function multiplecallrecord_c2c($glid,$ofrdate) 
	{          
                   $arravendor=array('COMPETENT'=>226719,'VKALP'=>226720,'LIVE DIGITAL'=>226721,'KOCHARTECH'=>226722);
                   $atttach=array();  
                    if($glid>0){
                         $obj = new Globalconnection();
                        $model = new GlobalmodelForm();
                        $dbh='';
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                                $dbh = $obj->connect_db_yii('postgress_web77v');   
                        }else{
                                $dbh = $obj->connect_db_yii('postgress_web68v'); 
                        }
                    if($dbh && ($glid > 0) && ($ofrdate<>'')){
                    $sql = "SELECT to_char(ENTERED_ON,'dd-Mon-YYYY HH:MI:SSAM') RECORDING_DATE,CALL_RECORDING_URL LEAP_CALL_RECORDING_URL,REF_NO,VENDOR FROM CLICK_TO_CALL WHERE FK_GLUSR_USR_ID=:USR_ID AND date(ENTERED_ON)=to_date(:ENTERED_ON,'DD-MON-YYYY') ";		
                    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(':USR_ID'=>$glid,':ENTERED_ON'=>$ofrdate));//echo $sql;        
                        while($rec = $sth->read()) {
                                $atttachsth=array_change_key_case($rec, CASE_UPPER);
                                foreach($arravendor as $key=>$value){
                                   if($atttachsth['REF_NO']==$value){
                                        array_push($atttach,$atttachsth);
                                    }  
                                }                               
                       }
                    }
            }                    
           return $atttach;
	}          
    public function push_offerid($offerid,$pmcatid)
            {
    include('/usr/local/php/lib/php-resque-ex/vendor/autoload.php');
    
        $queuename1 = 'LeapDataInsertionQueue2';
        $queuename2 = 'LeapDataInsertionQueue3';
        
          if ($_SERVER['HTTP_HOST'] == 'dev-gladmin.intermesh.net' || $_SERVER['HTTP_HOST'] == 'stg-gladmin.intermesh.net')
          {
                $queuename1 = 'LeapDataInsertionQueue2';
                $queuename2 = 'LeapDataInsertionQueue3';
                 Resque::setBackend('63.251.115.228:6379');
          }
          else {
                $queuename1 = 'LeapDataInsertionQueue2';
                $queuename2 = 'LeapDataInsertionQueue3';
                Resque::setBackend('206.191.151.230:6379');
          }
                 
          
         $args = array(
                 'OFFERID' => $offerid,
                 'PRIMEMCAT' =>$pmcatid,
                 'ENQTYPE' => 'B',
                 'SOURCE' => 'GLADMIN'
                 );
         
                print_r($args);
                if($args['OFFERID']%2==0){
                $set = Resque::enqueue($queuename1 ,'LeapDataInsertionQueue', $args);
                }
                else{
                   $set = Resque::enqueue($queuename2 ,'LeapDataInsertionQueue', $args);
                }die;
                //return $set;
            }

 public function citydetail($glid){ 
    
		$obj = new Globalconnection();    
                $model = new GlobalmodelForm();

                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }		
                $result ='';	 
		$sql = "select gl_city_name from eto_glusr_pref_city,gl_city where city_id=gl_city_id and glusr_usr_id=:GLUSR_USR_ID";
                $bind[':GLUSR_USR_ID']=$glid; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                while($val = $sth->read()) {
			$result .=$val['gl_city_name'].', ';
                   }	
                if($result<>''){
                    $result=rtrim($result,', ');
                }else{
                    $result='No Record found for GLID-'.$glid;
                }
                 echo $result;
		die;
	}


public function unrealistictov($offerid){
        $newval='';
	$bind[':ETO_OFR_DISPLAY_ID']=$offerid; 
        $type =isset($_REQUEST["type"]) ? $_REQUEST["type"] : '';
        
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
                $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        if($type=='usage'){
            if($dbh){
            $sql = "SELECT gl_profile_old_value FROM bl_profile_enrichment where fk_gl_attribute_id = 230 and  eto_ofr_display_id =:ETO_OFR_DISPLAY_ID ";
	    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
             while($temp = $sth->read()) {
               $newval .= '<span  style="text-align:center;color:black">Removed by Leap : Removed Usage -'.@$temp['gl_profile_old_value'].'</span>';
            }
        }
        if($newval==''){
                $newval .= '<span  style="text-align:center;color:black">Not removed by Leap</span>';
        }
        }else{
            if($dbh){
            $sql = "SELECT gl_profile_old_value,gl_profile_new_value FROM bl_profile_enrichment where fk_gl_attribute_id = 231 and  eto_ofr_display_id =:ETO_OFR_DISPLAY_ID ";
	    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
            while($temp = $sth->read()) {
                $newval .= '<span  style="text-align:center;color:black">Removed by Leap : Old TOV - '.@$temp['gl_profile_old_value'].', New TOV - '.@$temp['gl_profile_new_value'].' </span>';
            }
            }
            if($newval==''){
                    $newval .= '<span  style="text-align:center;color:black">Not Removed by Leap</span>';
            }
        }
        return $newval;
}

public function unrealisticquantity($offerid){
        $newval='';
	$bind[':ETO_OFR_DISPLAY_ID']=$offerid; 
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
                $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        if($dbh){
            $sql = "SELECT count(1) CNT FROM bl_profile_enrichment where fk_gl_attribute_id = 229 and  eto_ofr_display_id =:ETO_OFR_DISPLAY_ID ";
           	
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
             while($temp = $sth->read()) {
                     if($temp['cnt'] > 0){//Removed by LEAP
                            $newval .= '<span  style="text-align:center;color:black">Removed by LEAP</span>';
                            }
            }
        }
        if($newval==''){
                $newval .= '<span  style="text-align:center;color:black">Not Removed by LEAP</span>';
        }
        return $newval;
}


public function autoapprove($offerId){
    $temp=array();
    if($offerId>0){	

			$sql="WITH tbl AS
			(SELECT TO_CHAR(GL_PROFILE_AUDIT_DATE,'DD-MON-YYYY HH24:MI:SS') AS AUDIT_DATE ,
			  EMP.ETO_LEAP_EMP_ID,
			  TO_CHAR(GL_PROFILE_ENRICHMENT_DATE,'DD-MON-YYYY HH24:MI:SS') AS GL_PROFILE_ENRICHMENT_DATE ,
			  ETO_LEAP_TL_ID,GL_PROFILE_AUDIT_BY,
			  EMP.ETO_LEAP_EMP_NAME,
			  ETO_OFR_DISPLAY_ID,
			  SCREEN_NAME,
				CASE WHEN (GL_PROFILE_AUDIT_STATUS = '1')THEN 'Reviewed'
					WHEN (GL_PROFILE_AUDIT_STATUS = '3')THEN 'Reposted'
					WHEN (GL_PROFILE_AUDIT_STATUS = '0')THEN 'Reviewed'
					WHEN (GL_PROFILE_AUDIT_BY = '-1' AND GL_PROFILE_AUDIT_STATUS = '2') THEN  'Expired before Review'
					WHEN (GL_PROFILE_AUDIT_STATUS = '2') THEN 'Expired'
			ELSE NULL END STATUS,
				CASE
					WHEN (GL_PROFILE_AUDIT_STATUS = 0)THEN 'No Change'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1000')THEN 'Title'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0100')THEN 'Mcat'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0010')THEN 'Description'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0001')THEN 'ISQ'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1100')THEN 'Title,Mcat'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1010')THEN 'Title,Description'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1001')THEN 'Title,ISQ'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0110')THEN 'Mcat,Description'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0101')THEN 'Mcat,ISQ'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0011')THEN 'Description,ISQ'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1110')THEN 'Title,Mcat,Description'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '0111')THEN 'Mcat,Description,ISQ'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1011')THEN 'Title,Description,ISQ'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1101')THEN 'Title,Mcat,ISQ'
					WHEN (GL_PROFILE_AUDIT_STATUS = 1 AND GL_PROFILE_NEW_VALUE = '1111')THEN 'Title,Mcat,Description,Isq'
					WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '3') THEN 'Exp-Invalid Description'
					WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '14') THEN 'Exp-Is a Supplier'
					WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '10') THEN 'Exp-Wrong Contact details'
					WHEN (GL_PROFILE_AUDIT_STATUS = 2 AND GL_PROFILE_NEW_VALUE = '73') THEN 'Exp-Wrong Search Keyword'
					WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '3') THEN 'Re-Invalid Description'
					WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '14') THEN 'Re-Is a Supplier'
					WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '10') THEN 'Re-Wrong Contact details'
					WHEN (GL_PROFILE_AUDIT_STATUS = 3 AND GL_PROFILE_NEW_VALUE = '73') THEN 'Re-Wrong Search Keyword'
				END CHANGE_MADE,FK_GL_ATTRIBUTE_ID 
				FROM BL_PROFILE_ENRICHMENT
				LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM EMP
				ON GL_PROFILE_AUDIT_BY=EMP.ETO_LEAP_EMP_ID
				WHERE (FK_GL_ATTRIBUTE_ID=222 OR FK_GL_ATTRIBUTE_ID=227)
				AND ETO_OFR_DISPLAY_ID=:ETO_OFR_DISPLAY_ID 
				ORDER BY GL_PROFILE_AUDIT_DATE
				)
			SELECT AUDIT_DATE,GL_PROFILE_ENRICHMENT_DATE,GL_PROFILE_AUDIT_BY,
				tbl.ETO_LEAP_EMP_ID EMP_ID,tbl.ETO_LEAP_EMP_NAME EMP_NAME,SCREEN_NAME,
				ETO_OFR_DISPLAY_ID,STATUS,CHANGE_MADE,FK_GL_ATTRIBUTE_ID 
				FROM tbl LEFT OUTER JOIN ETO_LEAP_MIS_INTERIM TL
				ON tbl.ETO_LEAP_TL_ID = TL.ETO_LEAP_EMP_ID";

		    $bind[':ETO_OFR_DISPLAY_ID']=$offerId; 
                    $obj = new Globalconnection();
                    $model = new GlobalmodelForm();
					if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
					{
						$dbh = $obj->connect_db_yii('postgress_web77v');   
					}else{
						$dbh = $obj->connect_db_yii('postgress_web68v'); 
					}
					
                    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                     while($rec = $sth->read()) {
                             $temp=array_change_key_case($rec, CASE_UPPER);                     
                    }
			
            }
            return $temp;
        }
        
  public function getragdetail(){
      $raghtml=$dbh='';
         if(isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid']>0){   
             $obj = new Globalconnection();
            $model = new GlobalmodelForm();
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
            {
                $dbh = $obj->connect_db_yii('postgress_web77v');   
            }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
            }    
            if($dbh){
                $desc = array('1'=>'Low','2'=>'Medium','3'=>'High','4'=>'Low','5'=>'Medium','6'=>'High','7'=>'Low','8'=>'Medium','9'=>'High');                
                $sql="select mcat_aov_flag,mcat_tier_sold_flag,fk_iil_enterprise_type_id,intent_score,rag_score_total from ETO_OFR_RAG_SCORES where eto_offer_display_id= :ETO_OFR_DISPLAY_ID";
                $bind[':ETO_OFR_DISPLAY_ID']=$_REQUEST['offerid']; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                while($rec = $sth->read()) {//print_r($rec);//die;
                        $aovflag=isset($rec['mcat_aov_flag'])?$rec['mcat_aov_flag']:'';
                        $sold_flag=isset($rec['mcat_tier_sold_flag'])?$rec['mcat_tier_sold_flag']:'';
                        $type_flag=isset($rec['fk_iil_enterprise_type_id'])?$rec['fk_iil_enterprise_type_id']:'';
                        $intent_score=isset($rec['intent_score'])?$rec['intent_score']:'';
                        $ragscoretotal=isset($rec['rag_score_total'])?$rec['rag_score_total']:''; 
                        
                       $raghtml = '<br><span style="color:#999999;font-size:11px;">&#9658;</span>&nbsp;MCAT_TOV :&nbsp;&nbsp;';
                       if($aovflag!=0){
                       $raghtml .= '<span style="color:#000090;font-size:12px;">&nbsp;'.$aovflag.' ['.@$desc[$aovflag].']</span>';
                       }
                       
                       $raghtml .=   '<br><span style="color:#999999;font-size:11px;">&#9658;</span>&nbsp;MCAT_Tier_Sold :&nbsp;&nbsp;';
                       if($sold_flag!=0){
                       $raghtml .=   '<span style="color:#000090;font-size:12px;">&nbsp;'.$sold_flag.' ['.@$desc[$sold_flag].']</span>';
                       }
                       
                       $raghtml .=   '<br><span style="color:#999999;font-size:11px;">&#9658;</span>&nbsp;Buyer_Type :&nbsp;&nbsp;';
                       if($type_flag!=0){
                       $raghtml .=   '<span style="color:#000090;font-size:12px;">&nbsp;'.$type_flag.' ['.@$desc[$type_flag].']</span>';
                       }
                       
                       $raghtml .=   '<br><span style="color:#999999;font-size:11px;">&#9658;</span>&nbsp;Intent Score :&nbsp;&nbsp;';
                       if($intent_score!=0){
                       $raghtml .=   '<span style="color:#000090;font-size:12px;">&nbsp;'.$intent_score.' ['.@$desc[$intent_score].']</span>';
                       }
                       
                       $raghtml .=   '<br><span style="color:#999999;font-size:11px;">&#9658;</span>&nbsp;Rag total Score :&nbsp;&nbsp;';
                       if($ragscoretotal!=0){
                       $raghtml .=   '<span style="color:#000090;font-size:12px;">&nbsp;'.$ragscoretotal.' ['.@$desc[$ragscoretotal].']</span';
                       }                
                } 
            }
        }
    return $raghtml;    
  }
  
  
   public function histOfrMapmcat($offer , $status ) {
        $obj = new Globalconnection();   
        $model = new GlobalmodelForm();
        $dbh = $obj->connect_db_yii('postgress_web68v');     
        $request = Yii::app()->request;
         if($status=='A' || $status=='F' || $status=='P' || $status=='Q'){
            $status_type='L';
        }
        $auto_mcat_selectiontable = (!empty($status_type) && $status_type == 'L') ? 'ETO_AUTO_MCAT_SELECTION' : 'ETO_AUTO_MCAT_SELECTION_EXP';
        $mcat_selectiontable = (!empty($status_type) && $status_type == 'L') ? 'ETO_OFR_MAPPING' : 'ETO_OFR_MAPPING_EXPIRED';
        $sqlMap = "SELECT
                            TO_CHAR(ETO_OFR_MAPPING_DATE, 'DD-Mon-yyyy HH:MI:SS AM') AS ETO_OFR_MAPPING_DATE,
                            FK_ETO_OFR_ID,
                            GLCAT_MCAT_ID,
                            GLCAT_MCAT_NAME,
                            GL_EMP_ID,
                            GL_EMP_NAME,(case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) || (CASE WHEN PRIME_MCAT = GLCAT_MCAT_ID  THEN ' [Prime]' ELSE '' END) IS_GENERIC,PRIME_MCAT  
                         FROM
                            ".$mcat_selectiontable." ,
                             GLCAT_MCAT,
                             GL_EMP
                        WHERE
                            FK_ETO_OFR_ID = :OFFER_ID
                            AND GL_EMP_ID = FK_EMPLOYEE_ID   
                            AND GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID   
                            ORDER BY 2
            ";
        $sthMap = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlMap,array(':OFFER_ID'=>$offer));
        $recMapResult = array();
        while ($rec_t = $sthMap->read())
        {
            $rec=array_change_key_case($rec_t, CASE_UPPER);    
            array_push($recMapResult,$rec);
        }	

     $sqlNotMap = "SELECT GLCAT_MCAT_ID, GLCAT_MCAT_NAME, coalesce(GL_EMP_ID,FK_GL_EMP_ID) GL_EMP_ID,(case when GL_EMP_NAME is NULL then 'Auto Agent' else GL_EMP_NAME end) GL_EMP_NAME, TO_CHAR(ETO_AUTO_MCAT_SELECTION_DATE, 'DD-Mon-yyyy HH:MI:SS AM') AS ETO_AUTO_MCAT_SELECTION_DATE,coalesce(ETO_AUTO_MCAT_RANK,999) ETO_AUTO_MCAT_RANK,(case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) IS_GENERIC,
            (CASE WHEN MCAT_RELEVANCY_SCORE='1' THEN 'High' WHEN MCAT_RELEVANCY_SCORE='2' THEN 'Medium' WHEN MCAT_RELEVANCY_SCORE='3' THEN 'Low' ELSE 'NA' END) MCAT_RELEVANCY_SCORE
            FROM
            (select FK_GLCAT_MCAT_ID,FK_GL_EMP_ID,ETO_AUTO_MCAT_SELECTION_DATE,ETO_AUTO_MCAT_RANK,MCAT_RELEVANCY_SCORE from $auto_mcat_selectiontable where FK_ETO_OFR_ID = :OFFER_ID
            ) AUTO_MCAT_SELECTION join GLCAT_MCAT
            ON GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID
            left join GL_EMP on FK_GL_EMP_ID = GL_EMP_ID
            ORDER BY 6, FK_GL_EMP_ID";
     
     
      $sthNotMap = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlNotMap,array(':OFFER_ID'=>$offer));
      $recNotMapResult = array();
      while ($recNotMap = $sthNotMap->read())
        {
            $recNotMap1=array_change_key_case($recNotMap, CASE_UPPER); 
            array_push($recNotMapResult,$recNotMap1);
        }
		

    
   // print_r($hash);    
    return array(
        "recNotMapResult" => $recNotMapResult,
        "recMapResult" => $recMapResult,
      
    );
    //#### Selected Mcats Details ####
}

public function histOfrMapmcat_audit($offer , $status_type ) {
        $obj = new Globalconnection();   
	$model = new GlobalmodelForm();
    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
    {
        $dbh = $obj->connect_db_yii('postgress_web77v');   
    }else{
        $dbh = $obj->connect_db_yii('postgress_web68v'); 
    }  
	$auto_mcat_selectiontable = (!empty($status_type) && $status_type == 'L') ? 'ETO_AUTO_MCAT_SELECTION' : 'ETO_AUTO_MCAT_SELECTION_EXP';
	$mcat_selectiontable = (!empty($status_type) && $status_type == 'L') ? 'ETO_OFR_MAPPING' : 'ETO_OFR_MAPPING_EXPIRED';
	$sqlMap = "SELECT
						TO_CHAR(ETO_OFR_MAPPING_DATE, 'DD-Mon-yyyy HH:MI:SS AM') AS ETO_OFR_MAPPING_DATE,
						FK_ETO_OFR_ID,
						GLCAT_MCAT_ID,
						GLCAT_MCAT_NAME,
						GL_EMP_ID,
						GL_EMP_NAME,(case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) || (CASE WHEN PRIME_MCAT = GLCAT_MCAT_ID  THEN ' [Prime]' ELSE '' END) IS_GENERIC,PRIME_MCAT  
					 FROM
						".$mcat_selectiontable." ,
						 GLCAT_MCAT,
						 GL_EMP
					WHERE
						FK_ETO_OFR_ID = :OFFER_ID
						AND GL_EMP_ID = FK_EMPLOYEE_ID   
						AND GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID   
						ORDER BY 2
		";
	  $sthMap = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlMap,array(':OFFER_ID'=>$offer));
	$recMapResult = array();
	while ($rec = $sthMap->read())
	{       
                $rec1=array_change_key_case($rec, CASE_UPPER); 
		array_push($recMapResult,$rec1);
	}
	   $sqlNotMap = "SELECT GLCAT_CAT_NAME,FK_GLCAT_CAT_ID, GLCAT_MCAT_ID, GLCAT_MCAT_NAME, GL_EMP_ID,GL_EMP_NAME, 
               TO_CHAR(ETO_AUTO_MCAT_SELECTION_DATE, 'DD-Mon-yyyy HH:MI:SS AM') AS ETO_AUTO_MCAT_SELECTION_DATE,coalesce(ETO_AUTO_MCAT_RANK,999) ETO_AUTO_MCAT_RANK,
               (case when GLCAT_MCAT_IS_GENERIC=1 then ' [PMCAT]' else '' end) IS_GENERIC,
            (CASE WHEN MCAT_RELEVANCY_SCORE='1' THEN 'High' WHEN MCAT_RELEVANCY_SCORE='2' THEN 'Medium' WHEN MCAT_RELEVANCY_SCORE='3' THEN 'Low' ELSE 'NA' END) MCAT_RELEVANCY_SCORE
            FROM
            (select FK_GLCAT_MCAT_ID,FK_GL_EMP_ID,ETO_AUTO_MCAT_SELECTION_DATE,ETO_AUTO_MCAT_RANK,MCAT_RELEVANCY_SCORE from $auto_mcat_selectiontable where 
            FK_ETO_OFR_ID = :OFFER_ID 
            ) AUTO_MCAT_SELECTION join GLCAT_MCAT ON GLCAT_MCAT_ID = FK_GLCAT_MCAT_ID
            left join GL_EMP on FK_GL_EMP_ID = GL_EMP_ID 
            left join GLCAT_CAT_TO_MCAT on GLCAT_MCAT_ID = GLCAT_CAT_TO_MCAT.FK_GLCAT_MCAT_ID 
            left join GLCAT_CAT on GLCAT_CAT.GLCAT_CAT_ID=FK_GLCAT_CAT_ID             
            ORDER BY 10, FK_GL_EMP_ID";
        
        
        $sthNotMap = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlNotMap,array(':OFFER_ID'=>$offer));

  $recNotMapResult = array();
  while ($recNotMap = $sthNotMap->read())
	{
                $recNotMap1=array_change_key_case($recNotMap, CASE_UPPER); 
		array_push($recNotMapResult,$recNotMap1);
	}

	$sqlsearchkeyword = "SELECT DISTINCT ETO_LEAD_SEARCH_KEYWORD FROM ETO_LEAD_SUPPLIER_MAPPING WHERE FK_ETO_OFR_DISPLAY_ID = :OFFER_ID";
  $searchkey = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlsearchkeyword,array(':OFFER_ID'=>$offer));
  $searchkeyword = $searchkey->read();
   $emp_id = Yii::app()->session['empid'];
   
return array(
	"recNotMapResult" => $recNotMapResult,
	"recMapResult" => $recMapResult,
	"searchkeyword" =>$searchkeyword  
);
//#### Selected Mcats Details ####
}

public function bandetail($offerid){
        $newval=array();
	$bind[':ETO_OFR_DISPLAY_ID']=$offerid; 
        $status_check =isset($_REQUEST["status_check"]) ? $_REQUEST["status_check"] : '';
        
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
                $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
            if($dbh){
            $sql = "SELECT gl_profile_updated_by_id,gl_profile_audit_by,
                  CASE  WHEN(((gl_profile_audit_status='1') AND (gl_profile_audit_by <> -444))) THEN 'Deleted'
                          WHEN(gl_profile_audit_status='2') THEN 'Approved'
                          WHEN(gl_profile_audit_status='0' OR gl_profile_audit_status IS NULL) THEN 'Expired' 
                          WHEN gl_profile_audit_by=-444 THEN 'Pending' END Actions FROM bl_profile_enrichment where fk_gl_attribute_id = 223 and  eto_ofr_display_id =:ETO_OFR_DISPLAY_ID ";
	    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
            $newval = $sth->read();
            }
        return $newval;
}
public function showragscale(){
      $raghtml=$dbh=$dbh_ml='';
         if(isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid']>0){   
             $obj = new Globalconnection();
            $model = new GlobalmodelForm();
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
            {
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
                $dbh_ml = $obj->connect_db_yii('postgress_web68v'); 
            }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
                $dbh_ml = $obj->connect_db_yii('postgress_web54v'); 
            } 
           
            if($dbh){
                $desc = array('1'=>'Red','6'=>'Red','2'=>'Orange','7'=>'Orange','3'=>'Yellow','8'=>'Yellow','4'=>'Green','9'=>'Green','5'=>'Blue','10'=>'Blue');                
                $desc2 = array('15'=>'Blue','25'=>'Blue','35'=>'Blue','12'=>'Orange','22'=>'Orange','32'=>'Orange','13'=>'Yellow','23'=>'Yellow','33'=>'Yellow','14'=>'Green','24'=>'Green','34'=>'Green','11'=>'Red','21'=>'Red','31'=>'Red');                
                
                $sql="select sold_rag_score_final,approv_rag_score from ETO_OFR_RAG_SCORES where eto_offer_display_id= :ETO_OFR_DISPLAY_ID";
                $bind[':ETO_OFR_DISPLAY_ID']=$_REQUEST['offerid']; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                while($rec = $sth->read()) {//print_r($rec);//die;
                        $sold_rag_score_final=isset($rec['sold_rag_score_final'])?$rec['sold_rag_score_final']:'';
                        $approv_rag_score=isset($rec['approv_rag_score'])?$rec['approv_rag_score']:'';                        
                       $raghtml .= '<tr><td>Sold RAG</td><td style="color:'.@$desc2[$sold_rag_score_final].'">'.@$desc2[$sold_rag_score_final].'</td></tr>';
                                              
                       $raghtml .= '<tr><td>Approval RAG</td><td style="color:'.@$desc[$approv_rag_score].'">'.@$desc[$approv_rag_score].'</td></tr>';
                         
                       
                } 
            }
          
            if($dbh_ml){
                $sql="select output,bl_app_probability from leap_saleability_model_log where eto_ofr_display_id= :ETO_OFR_DISPLAY_ID";
                $bind[':ETO_OFR_DISPLAY_ID']=$_REQUEST['offerid']; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_ml, $sql, $bind);//echo $sql;        
                while($rec = $sth->read()) {
                    $raghtml .= '<tr><td>Sold Probability </td><td>'.@$rec['output'].'</td></tr>';
                    $raghtml .= '<tr><td>Approval  Probability</td><td>'.@$rec['bl_app_probability'].'</td></tr>';
                       
                }
            }
        }
        if($raghtml<>''){
            $raghtml ='<table style="border-collapse:collapse;" width="100%" cellspacing="0" cellpadding="5" bordercolor="#ebebeb" border="1">'.$raghtml.'</table>';
        }
    return $raghtml;   
  }
public function isqautofill($offerid){
        $newval='';
	$bind[':ETO_OFR_DISPLAY_ID']=$offerid; 
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        $dbh = $obj->connect_db_yii('postgress_web68v'); 
        if($dbh){
            $sql = "SELECT count(1) CNT FROM bl_profile_enrichment where fk_gl_attribute_id = 237 and gl_profile_new_value = '1' and  eto_ofr_display_id =:ETO_OFR_DISPLAY_ID ";
           	
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
             while($temp = $sth->read()) {
                    if($temp['cnt'] > 0){//Removed by LEAP
                        $newval .= '<span  style="text-align:center;color:green">(Auto filled)</span>';
                    }
            }
        }
        return $newval;
}
public function Redismlbl($request,$offer_id,$rec)
    {
    $response='';
        $old_title=$rec['eto_ofr_title'];
        $old_desc=$rec['eto_ofr_desc'];
                $title = $request->getParam('title','');
		$desc = $request->getParam('desc','');
		if(!empty($title)){
			$title = substr($title,0,100);
			$title = preg_replace("/\'/","''",$title);
			$title = preg_replace("/&nbsp;/"," ",$title);
			if(preg_match('/%u([0-9A-F]+)/', $title)){
				$title = preg_replace('/%u([0-9A-F]+)/', ' ', $title);
			}
			$title = htmlspecialchars_decode($title);
		}
		if (!empty($desc)) {
		            $desc = preg_replace("/<br \/>/","\n",$desc);
			    $desc = preg_replace("/(\n){2,}/","\n\n",$desc);
			    $desc = preg_replace("/\?/"," ",$desc);
			    $desc = preg_replace('/[^A-Za-z0-9 !@#$%^&*().]\'/u','', strip_tags($desc));
			    $desc = preg_replace("/&lsquo/"," ",$desc);
			    $desc = preg_replace("/&ldquo/"," ",$desc);
			    $desc = preg_replace("/&rdquo/"," ",$desc);			    
			    $desc = preg_replace("/&rsquo/"," ",$desc);			    
			    $desc = preg_replace("/&nbsp;/"," ",$desc);			    	    
	    
			    
			    if(preg_match('/%u([0-9A-F]+)/', $desc)){
					$desc = preg_replace('/%u([0-9A-F]+)/', ' ', $desc);
			    }	    
			    $desc = htmlspecialchars_decode($desc);
			    $desc = preg_replace("/'/","''",$desc);
			    $desc = trim($desc);

			    $desc = substr($desc,0,3990);
		}

        if(($old_title != $title) || ($old_desc != $desc)){          

	if(isset($_SERVER['SERVER_NAME']) && (($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') ||  ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') ))
		{ 
			$ip = "dev-ml-pub-api.intermesh.net:8082";
                }
		else
		{ 
			$ip = "ml-pub-api.intermesh.net:8082";
		}
		$data=array();
		$updatedData = array();
		$tempData = array();
		$data['ETO_OFR_DISPLAY_ID'] = $offer_id;
		if($old_title != $title)
		{
			$tempData['VALUE_CHANGED'] = 'ETO_OFR_TITLE';
			$tempData['OLD_VALUE'] = $old_title;
			$tempData['NEW_VALUE'] = $title;
			array_push($updatedData,$tempData);
		}
		if($old_desc != $desc)
		{
			$tempData['VALUE_CHANGED'] = 'ETO_OFR_DESCRIPTION';
			$tempData['OLD_VALUE'] = $old_desc;
			$tempData['NEW_VALUE'] = $desc;
			array_push($updatedData,$tempData);
		}
		$data['DATA'] = $updatedData;
		$data['mod_id'] = 'GLADMIN';
		$qname = "ETO_OFR_DETAILS_MODIFY_QUEUE";
		$dataJson = json_encode($data);

			$rid = uniqid();
			$rmq_url = "http://".$ip."/rmq/publish";
			$content = array(
				"qname" => $qname,
				"rservice" => "GLADMIN",	
				"rid" => $rid,
				"msg" => $dataJson
			);

    try
    {
             //$serv_model=new ServiceGlobalModelForm();
            // $dataHash = $serv_model->mapiService('BLMLRMQ',$rmq_url,$content,'No');

            $ch = curl_init($rmq_url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

            $json_response = curl_exec($ch);
          //  print curl_error($ch);
            
            $curl_info = curl_getinfo($ch);
            $response = json_decode($json_response, true);
        if(isset($response['status']) && $response['status'] == 'Success')
        {
                $response = 'INSERT SUCCESS';
        } 
        else 
        {
            $response = 'INSERT Error';
        }
    }
    catch(Exception $e) 
    {
        $response = 'INSERT FAILURE - Exception: ' . $e->getMessage();
        $error=$e->getMessage();
    }
        return $response;
    }
}
    
}