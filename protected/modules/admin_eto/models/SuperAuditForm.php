<?php
class SuperAuditForm extends CFormModel{
    public function editOffer($request,$emp_id,$path,$statusDesc,$userStatusDesc,$mesg,$flagError,$old_offerid,$model) {
        $legalStatus = $ofrDataArr=array();
        $tableflag=$tablename=$userDet = $userDetail='' ; 
        $postParamArr['arc'] = $arc = $request->getParam('arc','');
        $postParamArr['offerID'] = $offerID= $old_offerid;
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
                if(empty($status)){
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
                        print_r($statusArr1);
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
                               (SELECT ETO_LEAP_VENDOR_NAME || case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                               (select gl_emp_name from gl_emp,eto_leap_mis WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) LEADER_NAME,
                               (select extract(day from DATE_R- ETO_LEAP_AGENT_JOINING_DATE) from eto_leap_mis WHERE ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) ASSOCIATE_VINTAGE,
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
                         (CASE WHEN ETO_OFR_FENQ_EMP_ID < 0 THEN 'Auto Delete' ELSE (SELECT ETO_LEAP_VENDOR_NAME || (case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END) FROM eto_leap_mis WHERE ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID ) END)  ETO_LEAP_VENDOR_NAME,
                         (select gl_emp_name from gl_emp,eto_leap_mis WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID) LEADER_NAME,
                          (select extract(day from ETO_OFR_FENQ_DATE- ETO_LEAP_AGENT_JOINING_DATE) from eto_leap_mis WHERE ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID) ASSOCIATE_VINTAGE,
                        (CASE WHEN USER_IDENTIFIER_FLAG IN(24,38,60,92,93) THEN 'Yes' ELSE 'No' END) AOV_FLAG,
                         (CASE WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '1' then 'RED' 
                            WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '2' then 'ORANGE' 
                            WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '3' then 'YELLOW'  
                            WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '4' then 'GREEN' 
                            WHEN RIGHT(RAG_SCORE_TOTAL::TEXT, 1) = '5' then 'BLUE' END) RAG_SCORE,
                         NULL ETO_OFR_CALL_VERIFIED,NULL ETO_OFR_EMAIL_VERIFIED,NULL ETO_OFR_ONLINE_VERIFIED,
                        (SELECT IIL_MASTER_DATA_VALUE_TEXT FROM IIL_MASTER_DATA WHERE FK_IIL_MASTER_DATA_TYPE_ID=3 and IIL_MASTER_DATA_VALUE=Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON)::text) ||'('|| Coalesce(FENQ_CALL_DEL_REASON,FENQ_DEL_REASON) ||')' CALL_DEL_REASON,
                        DIR_QUERY_FREE_LATITUDE ETO_OFR_LATITUDE, DIR_QUERY_FREE_LONGITUDE ETO_OFR_LONGITUDE  
                    FROM $tableName left join GLCAT_CAT on DIR_QUERY_CATID = GLCAT_CAT_ID 
                        left join GL_EMP on ETO_OFR_FENQ_EMP_ID = GL_EMP_ID 
                WHERE DIR_QUERY_FREE_REFID= :offerID AND FK_ETO_OFR_ID IS NULL";
                        
              }else{		    
                    if($tableName=='ETO_OFR_TEMP_DEL' or $tableName=='ETO_OFR_TEMP_DEL_ARCH'){
                    $tem_condition=  "(CASE WHEN ETO_OFR_DELETEDBYID < 0 THEN 'Auto Delete' ELSE (SELECT ETO_LEAP_VENDOR_NAME || (case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END) FROM eto_leap_mis WHERE ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID ) END)  ETO_LEAP_VENDOR_NAME, 
                        (select gl_emp_name from gl_emp,eto_leap_mis WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID) LEADER_NAME,
                        (select extract(day from ETO_OFR_DELETIONDATE- ETO_LEAP_AGENT_JOINING_DATE)  from eto_leap_mis WHERE ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID) ASSOCIATE_VINTAGE,
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
                    $tem_condition=" (SELECT ETO_LEAP_VENDOR_NAME || (case when ETO_LEAP_EMP_IS_ACTIVE=-1 then '|Active' else '|In-Active' END) FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                                  (select gl_emp_name from gl_emp,eto_leap_mis WHERE gl_emp_id=ETO_LEAP_TL_ID AND ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) LEADER_NAME,
                                  (select extract(day from ETO_OFR_APPROV_DATE- ETO_LEAP_AGENT_JOINING_DATE)  from eto_leap_mis WHERE ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG) ASSOCIATE_VINTAGE,
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
               echo "<div><b style='font-size:15px;color:red;padding-left:20px'>Error in GL Detail Service for GLID: $glusrid</b></div>";  
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
    "origModid" => $origModid,			
    "postParamArr" => $postParamArr,			
    "userDetail" => $userDetail,
    "legalStatus" => $legalStatus,
    "userDet" => $userDet,
    "mcat_id"=>$mcat_id,
    "lead_type"=>$lead_type,
    "pool_type"=>$pool_type,
    "ps_type"=>$ps_type,
    "tableflag"=>$tableflag
);

        return $returnArr;		
        }
}
public function get_glusr_detail($glid, $serv_type = '') { //userapproval
 
    if ($serv_type == 'ALL') {
        $data = array('glusrid' => $glid, 'token' => 'imobile@15061981', 'modid' => 'GLADMIN', 'others' => 'ALL');
    
    } else {
        $data = array('glusrid' => $glid, 'token' => 'imobile@15061981', 'modid' => 'GLADMIN');
    }
    $host_name = $_SERVER['SERVER_NAME'];
    if ($host_name == 'dev-gladmin.intermesh.net') {
        $url = 'http://stg-mapi.indiamart.com/wservce/users/detail/';
    } elseif ($host_name == 'stg-gladmin.intermesh.net') {
        $url = 'http://stg-mapi.indiamart.com/wservce/users/detail/';
    } else {
        $url = 'http://mapi.indiamart.com/wservce/users/detail/';
    }
  
    if (is_numeric($glid) && strlen($glid) < 11) {
        $serv_model = new ServiceGlobalModelForm();
        $glusrdata_from_serv = $serv_model->mapiService('USERDETAILS', $url, $data, 'No');
        print_r($glusrdata_from_serv);
        exit;
    } else {
        $glusrdata_from_serv = array("Status" => "404", "Message" => "connection failure", "Error" => "Gluserid $glid is invalid");
    }
    $glusrdata = !empty($glusrdata_from_serv) ? array_change_key_case($glusrdata_from_serv, CASE_UPPER) : array();
    return $glusrdata;
}
public function offerDetail($offerID) {
    
    $getOfferDetails = array();$offerhtml=array();             
    if (($_SERVER["SERVER_NAME"] == 'dev-gladmin.intermesh.net') || ($_SERVER["HTTP_X_FORWARDED_SERVER"] == 'stg-gladmin.intermesh.net')){
        $url= 'http://dev-mapi.indiamart.com/wservce/buyleads/detail/?offer='.$offerID.'&token=imobile@15061981&offer_type=B&modid=GLADMIN&buyer_response=2'; //http://dev-mapi.indiamart.com/wservce/buylead/BuyleadDisplay/
    }else{
        $url='http://leads.imutils.com/wservce/buyleads/detail/?offer='.$offerID.'&token=imobile@15061981&offer_type=B&modid=GLADMIN&buyer_response=2';
    } 
    $serv_model= new ServiceGlobalModelForm(); 
    $cSession = curl_init();
    curl_setopt($cSession,CURLOPT_URL,$url);
    curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($cSession,CURLOPT_HEADER, false);          
    $response=curl_exec($cSession);
    $curl_info= curl_getinfo($cSession);
    $curl_info_json = json_encode($curl_info, true);       
    $result = json_decode($response,true);  
    $result['RESPONSE']['DATA']=isset($result['RESPONSE']['DATA'])?$result['RESPONSE']['DATA']:array(); 
 
   // print_r($result);
   // exit;
    if(isset($result['RESPONSE']['CODE']) && $result['RESPONSE']['CODE']!=200){
        $aaa = '<div style="color:red;text-align:center;">' . $result['RESPONSE']['MESSAGE'] . '</div>';
        return $aaa;
    }
     $getOfferDetails=isset($result['RESPONSE']['DATA'])?$result['RESPONSE']['DATA']:array();   
     
    $getOfferDetails['ETO_OFR_QTY'] =isset($getOfferDetails['ETO_OFR_QTY'])?$getOfferDetails['ETO_OFR_QTY']:"";
    $getOfferDetails['ETO_OFR_DESC'] =isset($getOfferDetails['ETO_OFR_DESC'])?$getOfferDetails['ETO_OFR_DESC']:"";
    $getOfferDetails['ENRICHMENTINFO'] =isset($getOfferDetails['ENRICHMENTINFO'])?$getOfferDetails['ENRICHMENTINFO']:"";
    $getOfferDetails['ADDITIONALINFO'] =isset($getOfferDetails['ADDITIONALINFO'])?$getOfferDetails['ADDITIONALINFO']:"";

//print_r($getOfferDetails);
//exit;
    
if (count($getOfferDetails) > 0){   
 
if ($getOfferDetails['ETO_OFR_QTY'] != ""){
   $offerhtml['Quantity']=$getOfferDetails['ETO_OFR_QTY'];
}

$if_same_key=array();
$additionalinfo_format='';

if(isset($getOfferDetails['ENRICHMENTINFO']) && $getOfferDetails['ENRICHMENTINFO']!='')
{
    
    $ISQ_QUE_ANS = json_decode($getOfferDetails['ENRICHMENTINFO'], true);
foreach($ISQ_QUE_ANS as $k=>$v){
    if((int)$k==0){
        foreach($v as $k0=>$v0){
            foreach($v0 as $k00=>$v00){
                $offerhtml[$k00]=$v00;
               
            }				
        }
    }else{
        continue;
    }
}
foreach($ISQ_QUE_ANS as $k=>$v)
{
    if((int)$k!=0){
        foreach($v as $k1=>$v1){
            $dkey=$v1['DESC'];
            $dval=$v1['RESPONSE'];
            $offerhtml[$dkey]=$dval;
        }
    }else{
        continue;
    }
}
    foreach($if_same_key as $kk=>$vv)
    {
        $vv=array_unique($vv);
        $vv=implode(',',$vv);
        if($kk == 'Approximate Order Value')
        {
            $kk = 'Approx. Order Value';
        }
        $offerhtml[$kk]=$vv;
    }
   
}

if(isset($getOfferDetails['ADDITIONALINFO']) && $getOfferDetails['ADDITIONALINFO']!='')
{
$offerhtml['ADDITIONAL INFO']=$getOfferDetails['ADDITIONALINFO'];
}


} 

return $offerhtml;
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
                FK_GLCAT_CAT_ID, FK_GLCAT_MCAT_ID, GLCAT_GRP_ID, GLCAT_GRP_NAME, GLCAT_CAT_ID, GLCAT_CAT_NAME, GLCAT_MCAT_NAME,GLCAT_MCAT_IS_GENERIC, PRIME_MCAT,GLCAT_MCAT_IS_BUSINESS_TYPE 
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
    $sqlmcat_mondatory = "select gl_profile_old_value,gl_profile_new_value from bl_profile_enrichment where fk_gl_attribute_id=228 and eto_ofr_display_id = :OFFER_ID ";
      $sthmcat_mondatory = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sqlmcat_mondatory,array(':OFFER_ID'=>$offerID));
      $recmcat_mondatory=array();
      while ($recmcat_row = $sthmcat_mondatory->read())
        {
                array_push($recmcat_mondatory,$recmcat_row);
        }
        return array(
            "arrmap" => $arr_map,
            "recmcat_mondatory"=>$recmcat_mondatory
        );
}

public function get_auditor_details($offerID){

    $obj = new Globalconnection();
    $dbh_pg = $obj->connect_approvalpg();
    $model = new GlobalmodelForm();
    $auditor='';
   $sql= "select task_assignedto_empid from freelance_task_details where task_ref_id= $offerID";
   $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());
   while($res = $sth1->read()){
       if(!empty($res)){
           $auditor=$res['task_assignedto_empid'];
       }
   }
    return $auditor;
}
public function error_details($offerID, $job_type_id,$auditor){
    $obj = new Globalconnection();
    $model = new GlobalmodelForm();
    $retArr=array();
   $temparr=array();
    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
    {
        $dbh = $obj->connect_db_yii('postgress_web77v');   
    }else{
        $dbh = $obj->connect_db_yii('postgress_web68v'); 
    } 
    if ($job_type_id == 13){
        $type= 'c.QUESTION_TYPE =10';
    } 
    else if ($job_type_id == 15){
        $type= 'c.QUESTION_TYPE =11';
    }
    else if ($job_type_id == 14){
        $type= 'c.QUESTION_TYPE =3';
    } 
    else if ($job_type_id == 11 || $job_type_id == 12){
        $type= 'c.QUESTION_TYPE =9';
    }
    else {
        $type= 'c.QUESTION_TYPE IN(5,6,7,8)';
    }
    if($offerID != '' && $auditor != '' ){

    $sql= " SELECT BL_AUDIT_RESPONSE_ID,   c.question_text as ques, a.bl_audit_response_emp_id as emp,

    FK_ETO_OFR_DISPLAY_ID,
  
  d.BL_AUDIT_QUES_OPT_ID,BL_AUDIT_QUES_OPT_DESC, REMARKS
  
       FROM BL_AUDIT_RESPONSE a,  
  
       BL_AUDIT_RESPONSE_DETAIL b,
  
  BL_AUDIT_QUESTION c ,
       BL_AUDIT_QUES_OPT d
  
    WHERE a.BL_AUDIT_RESPONSE_ID=b.FK_BL_AUDIT_RESPONSE_ID and fk_eto_ofr_display_id= $offerID and a.bl_audit_response_emp_id=$auditor
  and d.BL_AUDIT_QUES_OPT_ID = b.FK_BL_AUDIT_QUES_OPT_ID 
  
  and QUESTION_ID = b.FK_QUESTION_ID AND  $type  "; 
    
  $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
   
 
  while($errArr1 = $sth1->read()){
    if(!empty($errArr1)){
      $temparr['task_audit_id']=$errArr1['bl_audit_response_id'];
      $temparr['error_marked']=$errArr1 ['bl_audit_ques_opt_desc'];
      $temparr['remark']=$errArr1['remarks'];
      $temparr['ques']=$errArr1['ques'];
      array_push($retArr, $temparr);
    }
  }
}

    return($retArr);
}
public function gettaskauditid($offerID,$auditor){
    $obj = new Globalconnection();
    $model = new GlobalmodelForm();
    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
    {
        $dbh = $obj->connect_db_yii('postgress_web77v');   
    }else{
        $dbh = $obj->connect_db_yii('postgress_web68v'); 
    } 
    if($offerID != '' && $auditor != '' ){
 $sql1="select BL_AUDIT_RESPONSE_ID from BL_AUDIT_RESPONSE where fk_eto_ofr_display_id= $offerID and bl_audit_response_emp_id=$auditor ";
 $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, array());
 $retArr=array();
 while($errArr = $sth->read()){
    $errArr=array_change_key_case($errArr, CASE_UPPER);
    $temparr['task_audit_id']=$errArr['BL_AUDIT_RESPONSE_ID'];
    array_push($retArr, $temparr);
 }
}
 return($retArr);
}
public function taskdata($offerId){
    $obj = new Globalconnection();
    $dbh_pg = $obj->connect_approvalpg();
    $model = new GlobalmodelForm();
    $temparr=array();
    $query = "select TASK_DETAIL_ID, fk_job_type_id, ( SELECT task_audit_id FROM Freelance_TASK_AUDIT WHERE fk_task_detail_id=task_detail_id limit 1 ) from Freelance_TASK_DETAILS,Freelance_JOB_Master where 
    job_master_id=fk_job_master_id and TASK_REF_ID= $offerId and fk_job_type_id in(9,10,11,12,13,14,15)
    ";
    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $query, array());
    $res1 = $sth->readAll();
  
    if(!empty($res1)){
        $temparr['audit_id']=$res1[0]['task_audit_id'];
        $temparr['jobtype']=$res1[0]['fk_job_type_id'];
        $temparr['task_detail_id']=$res1[0]['task_detail_id'];
      }
     
      return $temparr;
}
public function callDetail($callrecordid)
{ 
    $sql = "select fk_leap_call_records_id,entered_on ,call_disposition_reason,disposition_remarks,eto_leap_vendor_name,
    call_recording_url,ETO_LEAP_EMP_NAME || '(' ||  ETO_LEAP_EMP_ID  || ')'  ASSOC_NAME,fk_glusr_usr_id 
from leap_call_transfer_records,eto_leap_mis ELM where call_disposition_reason <>211 and fk_employeeid = ELM.ETO_LEAP_EMP_ID and fk_leap_call_records_id=$callrecordid  ";

                 $rec=array(); $dbh='';                
                $model = new GlobalmodelForm();
                $obj = new Globalconnection();
if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
{
    $dbh = $obj->connect_db_yii('postgress_web77v');   
}else{
    $dbh = $obj->connect_db_yii('postgress_web68v'); 
}
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());//echo $sql;        
                $rec = $sth->read();																																																															
                
    return $rec;		
}

public function error_disposition($job_type_id){
    $sql=" select task_disposition_id, task_disposition_val from freelance_task_dispositions where fk_job_type_id=$job_type_id" ;
    $obj = new Globalconnection();
    $dbh_pg = $obj->connect_approvalpg();
    $model = new GlobalmodelForm();
    $temparr=array();
    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());
   // $d= $sth->read();
    //print_r($d);
   // exit;
   $i=0;
    while($arr = $sth->read()){
        if(!empty($arr)){
        $temparr[$i]['task_disposition_id']=$arr['task_disposition_id'];
        $temparr[$i]['task_disposition_val']=$arr['task_disposition_val'];
        $i++;
        }
    }
    return $temparr;
}
public function saveaudit(){
    $obj = new Globalconnection();
    $dbh_pg = $obj->connect_approvalpg();
    $model = new GlobalmodelForm();
    $task_id = "";
  //  $empId = $_REQUEST['empid'];
  $empId=Yii::app()->session['empid'];
    $jobtype_data=array();  
    $task_detail_i="";
        if(!isset($_REQUEST['status_disposition'])){
            $msg =  "Invalid Input!!";
            echo '<div style="color:red;text-align:center;">' . $msg . '</div>';  
            exit;          
        } 
        if(isset($_REQUEST['task_id'])){
     $task_detail_id=$_REQUEST['task_id'];
        }

        $msg = "Audit details have been saved successfully";
            $task_id =  isset($_REQUEST['offerID'])?$_REQUEST['offerID']:'';
            $reject_reason = "";
            $remarks="";
            
                $reject_reason = isset($_REQUEST['remarks'])?($_REQUEST['remarks']):'';
                $reason_id = isset($_REQUEST['reason'])?($_REQUEST['reason']):'';
                $status = isset($_REQUEST['status_disposition'])?($_REQUEST['status_disposition']):''; 
     
    if($task_detail_id>0 && $status!=''){
       if($status == 2){
    $query = "insert into Freelance_TASK_AUDIT 
        (fk_task_detail_id, TASK_Audited_DATE, task_audited_by_empid, TASK_Audited_Status,task_audited_reason, fk_task_disposition_id)
        values ( $task_detail_id, CURRENT_TIMESTAMP,$empId , $status, '$reject_reason', $reason_id )";
       }
       else{
        $query = "insert into Freelance_TASK_AUDIT 
        (fk_task_detail_id, TASK_Audited_DATE, task_audited_by_empid, TASK_Audited_Status,task_audited_reason)
        values ( $task_detail_id, CURRENT_TIMESTAMP, $empId , $status, '$reject_reason')"; 
       }
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $query, array());
        $res1 = $sth->readAll();
    }     
        if (isset($msg) && $msg != ''){
        echo '<div style="color:green;text-align:center;">' . $msg.'&nbsp&nbsp'.$task_detail_id . '</div>';
        }
}
public function saveaudit1(){
    $obj = new Globalconnection();
    $dbh_pg = $obj->connect_approvalpg();
    $model = new GlobalmodelForm();
    $task_id = "";
  //  $empId = $_REQUEST['empid'];
  $empId=Yii::app()->session['empid'];
    $jobtype_data=array();  
    $task_detail_i="";

        if(isset($_REQUEST['task_id'])){
     $task_detail_id=$_REQUEST['task_id'];
        }
         if(isset($_REQUEST['save_close']) || isset($_REQUEST['save'])){
            $msg = "Audit details have been saved successfully";
         }
         else{
             $msg="Can't be saved";
             die;
         }
            $task_id =  isset($_REQUEST['offerID'])?$_REQUEST['offerID']:'';
            $reject_reason = "";
            $remarks="";
            
                $reject_reason = isset($_REQUEST['remarks'])?($_REQUEST['remarks']):'';
                $reason_id = isset($_REQUEST['reason'])?($_REQUEST['reason']):'';
                $status = isset($_REQUEST['status_disposition'])?($_REQUEST['status_disposition']):''; 
     
    if($task_detail_id>0 && $status!=''){
       if($status == 2){
    $query = "insert into Freelance_TASK_AUDIT 
        (fk_task_detail_id, TASK_Audited_DATE, task_audited_by_empid, TASK_Audited_Status,task_audited_reason, fk_task_disposition_id)
        values ( $task_detail_id, CURRENT_TIMESTAMP,$empId , $status, '$reject_reason', $reason_id )";
       }
       else{
        $query = "insert into Freelance_TASK_AUDIT 
        (fk_task_detail_id, TASK_Audited_DATE, task_audited_by_empid, TASK_Audited_Status,task_audited_reason)
        values ( $task_detail_id, CURRENT_TIMESTAMP, $empId , $status, '$reject_reason')"; 
       }
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $query, array());
        $res1 = $sth->readAll();
    }     
       
        $returnarr=array(
          'msg'=>$msg,
          'task_detail_id'=>$task_detail_id
        );
        return $returnarr;
}
public function get_details($offerID,$task_detail_id){
    $obj = new Globalconnection();
    $dbh_pg = $obj->connect_approvalpg();
    $model = new GlobalmodelForm();
  $empId=Yii::app()->session['empid'];
  $sql="select task_audited_status,task_audited_reason,fk_task_disposition_id from  Freelance_TASK_AUDIT where fk_task_detail_id=$task_detail_id ";
  $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());
  $temparr=array();
  while($arr = $sth->read()){
    if(!empty($arr)){
    $temparr['task_audited_status']=$arr['task_audited_status'];
    $temparr['task_audited_reason']=$arr['task_audited_reason']; 
    $temparr['fk_task_disposition_id']=$arr['fk_task_disposition_id']; 
    }
}

return $temparr;
}
public function update_audit(){
    $obj = new Globalconnection();
    $dbh_pg = $obj->connect_approvalpg();
    $model = new GlobalmodelForm();
    $task_id = "";
  //  $empId = $_REQUEST['empid'];
  $empId=Yii::app()->session['empid'];
  $empname=Yii::app()->session['empname'];
    $jobtype_data=array();  
    $task_detail_i="";
        if(!isset($_REQUEST['status_disposition'])){
            $msg =  "Invalid Input";
            echo '<div style="color:red;text-align:center;">' . $msg . '</div>';        
            exit;     
        } 
        if(isset($_REQUEST['task_id'])){
     $task_detail_id=$_REQUEST['task_id'];
        }
        $msg = "Audit details have been updated successfully";
            $task_id =  isset($_REQUEST['offerID'])?$_REQUEST['offerID']:'';
            $remarks="";
            
                $new_remarks = isset($_REQUEST['remarks'])?($_REQUEST['remarks']):'';
                $old_remarks= isset($_REQUEST['old_remarks'])?($_REQUEST['old_remarks']):'';
                $reason_id = isset($_REQUEST['reason'])?($_REQUEST['reason']):'';
                $status = isset($_REQUEST['status_disposition'])?($_REQUEST['status_disposition']):'';
                $reject_reason = 'Updated By'.'   '.$empname.'('.$empId.') on'.'   '.date('Y/m/d H:i:s'). ' '.$new_remarks.$old_remarks; 
    if($task_detail_id>0){
      if($status ==2){ // from correct to wrong
    $query = " UPDATE Freelance_TASK_AUDIT 
        SET  TASK_Audited_Status= '$status',task_audited_reason= '$reject_reason', fk_task_disposition_id=$reason_id 
        WHERE  fk_task_detail_id=$task_detail_id";
      } 
     else if($status == 1){ // from wrong to correct
        $query = " UPDATE Freelance_TASK_AUDIT 
            SET  TASK_Audited_Status= '$status',task_audited_reason= '$reject_reason' , fk_task_disposition_id= null
            WHERE  fk_task_detail_id=$task_detail_id";
          } 
     else{  $query = " UPDATE Freelance_TASK_AUDIT 
       task_audited_reason= '$reject_reason', fk_task_disposition_id=$reason_id 
        WHERE  fk_task_detail_id=$task_detail_id";
          }
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $query, array());
        $res1 = $sth->readAll();
    }     
        if (isset($msg) && $msg != ''){
        echo '<div style="color:green;text-align:center;">' . $msg.'&nbsp&nbsp'.$task_detail_id . '</div>';
        }
}
public function super_audit_summary($request){
    $emp_id=Yii::app()->session['empid'];
    $start_date=isset($request['start_date'])?$request['start_date']:'';
    $end_date=isset($request['end_date'])?$request['end_date']:'';
    $sql= "select task_audited_status,task_disposition_val,count(task_audit_id) from freelance_job_master

    join freelance_task_details on job_master_id=fk_job_master_id
    
    join freelance_task_audit on task_detail_id=fk_task_detail_id
    
    left join freelance_task_dispositions on freelance_task_audit .fk_task_disposition_id=freelance_task_dispositions.task_disposition_id
    
    where freelance_job_master.fk_job_type_id in(9,10,11,12,13,14,15)
    
    and date(task_audited_date ) between to_date('$start_date','DD-MON-YYYY') and to_date('$end_date','DD-MON-YYYY') group by task_audited_status,task_disposition_val ";

    $obj = new Globalconnection();
    $model = new GlobalmodelForm();
    $dbh_pg = $obj->connect_approvalpg(); 
    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());
    $u1=$u2=$u3=$u4=$u5=$tot1=$nok=0;
    $filepath_download = $_SERVER['DOCUMENT_ROOT'];
    $filepath_download .=  '/gl_global_upload/';
    $emp_id=Yii::app()->session['empid'];
    $timestamp=$emp_id."-".date("F-j-Y")."-".time();
    $filename_return="super_audit_summary_$timestamp.xls";
    $file_return = $filepath_download.$filename_return;
    $FILE = fopen($file_return, "w");
    $print_data="Super Audit Summary\t $start_date - $end_date\n";
    fwrite($FILE, $print_data);
    while($row = $sth->read()) {
        $att=$row['task_disposition_val'];
        $att_st=$row['task_audited_status'];
        if( ($att=='Error Available but not Marked') && ($att_st=='2')){
            $u1=$row['count'];
         }
        if( ($att=='Error Marked in Wrong Disposition') && ($att_st=='2')){
            $u2=$row['count'];
         }
         if( ($att=='Single Error Marked in Multiple Error Case') && ($att_st=='2')){
            $u3=$row['count'];
         }
         if( ($att=='Wrong Error Marked') && ($att_st=='2')){
            $u4=$row['count'];
         }
         if($att_st=='1' ){
            $u5=$row['count'];
         }
    }
    $tot1=$u2 + $u3 + $u4 +$u5 +$u1;
    if($tot1 != 0){
        $quality= round((($u5/$tot1)*100),2); 
    }
    else{
        $quality= '';
    }
    $nok= $u3 + $u4 + $u2 + $u1; 
    fwrite($FILE, "Total Super Audit Count \t $tot1\t\n");
    fwrite($FILE, "Quality %\t $quality\t\n");
    fwrite($FILE, "OK Cases\t $u5\t\n");
    fwrite($FILE, "Not OK Cases\t $nok\n");
    fwrite($FILE, "Error Available but not Marked \t $u1\t\n");
    fwrite($FILE, "Error Marked in Wrong Disposition\t $u2\t\n");
    fwrite($FILE, "Single Error Marked in Multiple Error Case\t $u3\t\n");
    fwrite($FILE, "Wrong Error Marked\t $u4\n");  
    fclose($FILE);

    echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr>'
    . '<td style="background:#8cc1e2;padding:4px;font-weight:bold;"'
. 'align="center"> Super Audit Summary </td><td style="background:#8cc1e2;padding:4px;font-weight:bold;">'.$start_date.' - '.$end_date.' </td>'
            . '</tr>'
            . '<TR><TD>Total Super Audit Count</td><TD>'.$tot1.'</td></tr>'
            . '<tr><td>Quality (Accuracy)% </td><td>'.$quality.'</td></tr>'
            . '<tr><td class="correct">OK Cases </td><td class="correct">'.$u5.'</td></tr>'
            . '<tr><td class="error">Not OK Cases  </td><td class="error">'.$nok.'</td></tr>'
            . '<tr><td style="font-style:italic;" align="right">Error Available but not Marked</td><td>'.$u1.'</td></tr>'
            . '<tr><td style="font-style:italic;" align="right">Error Marked in Wrong Disposition</td><td>'.$u2.'</td></tr>'
            . '<tr><td style="font-style:italic;" align="right">Single Error Marked in Multiple Error Case</td><td>'.$u3.'</td></tr>'
            . '<tr><td style="font-style:italic;" align="right">Wrong Error Marked</td><td>'.$u4.'</td></tr></table>'
            . '<div style="padding:4px;font-weight:bold;text-align:center;"><a href="/gl_global_upload/'.$filename_return.'">Click to Download</a></div>';


$sql1="select task_assignedto_empid,employeename,

count(case when task_audited_status=1 then 1 end) accept_cnt,

count(case when task_audited_status=2 then 1 end) reject_cnt,

count(task_audit_id)

from freelance_job_master

join freelance_task_details on job_master_id=fk_job_master_id

join freelance_task_audit on task_detail_id=fk_task_detail_id
join employee on task_assignedto_empid=employeeid

where freelance_job_master.fk_job_type_id in(9,10,11,12,13,14,15)

and date(task_audited_date ) between to_date('$start_date','DD-MON-YYYY') and to_date('$end_date','DD-MON-YYYY') group by task_assignedto_empid,employeename

";
$dbh_pg = $obj->connect_approvalpg(); 
$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql1, array());
            $filepath_download1 = $_SERVER['DOCUMENT_ROOT'];
            $filepath_download1 .=  '/gl_global_upload/';
            $emp_id=Yii::app()->session['empid'];
            $timestamp=$emp_id."-".date("F-j-Y")."-".time();
            $filename_return1="super_audit_assoc_quality_$timestamp.xls";
            $file_return1 = $filepath_download1.$filename_return1;
            $FILE1 = fopen($file_return1, "w");
            $print_data1="Associate Name\t Quality\n";
            fwrite($FILE1, $print_data1);
          
            echo '<table  border="1" cellpadding="0" cellspacing="1" width="100%" align="center"><tr>'
            . '<td style="background:#8cc1e2;padding:4px;font-weight:bold;"'
            . 'align="center"> Associate wise quality </td><td style="background:#8cc1e2;padding:4px;font-weight:bold;">'.$start_date.' - '.$end_date.' </td>'
            . '</tr>';
            while($row = $sth->read()) { 
                $tot= $row['count'];
                $accept_cnt=$row['accept_cnt'];
                $assoc_name= $row['employeename'];
                $quality1= round((($accept_cnt/$tot)*100),2);
                echo '<TR style="font-style:italic;background:#CDCDCD;"><TD>'.$assoc_name.'</td><TD>'.$quality1.'%</td></tr>';
                fwrite($FILE1, " $assoc_name\t $quality1 \n");
            }
            fclose($FILE1);
            echo '</table>'
            . '<div style="padding:4px;font-weight:bold;text-align:center;"><a href="/gl_global_upload/'.$filename_return1.'">Click to Download</a></div>';

}
public function super_audit_report($request){
    $emp_id=Yii::app()->session['empid'];
    $start_date=isset($request['start_date'])?$request['start_date']:'';
    $end_date=isset($request['end_date'])?$request['end_date']:'';
    $sql= "select task_audited_by_empid,TASK_Audited_DATE, ( select employeename as super_auditor_name from employee where employeeid=task_audited_by_empid),
    task_audit_id,	Freelance_JOB_Master.fk_job_type_id as job_type_id, TASK_REF_ID,employeename as auditor_name, task_audited_status,task_disposition_val,TASK_Audited_reason,TASK_ASSIGNEDTO_EMPID,task_score from freelance_job_master
    
    join freelance_task_details on job_master_id=fk_job_master_id
    join employee on employee.employeeid =Freelance_TASK_DETAILS.TASK_ASSIGNEDTO_EMPID
    join freelance_task_audit on task_detail_id=fk_task_detail_id
    
    left join freelance_task_dispositions on freelance_task_audit .fk_task_disposition_id=freelance_task_dispositions.task_disposition_id
    
    where freelance_job_master.fk_job_type_id in(9,10,11,12,13,14,15)
    
    and date(task_audited_date ) between to_date('$start_date','DD-MON-YYYY') and to_date('$end_date','DD-MON-YYYY')";
    $obj = new Globalconnection();
    $model = new GlobalmodelForm();
    $dbh_pg = $obj->connect_approvalpg(); 
    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());
    $d1=array();
    $t1=$t2=$t3=$r1=$r2=$r3=$u1=$u2=$u3=0;
    $tr='';
    $cnt=1;
    while($row = $sth->read()){
         $d1[$cnt][0]=$row['task_audited_by_empid'];
         $d1[$cnt][1]=$row['task_audited_date'];
         $d1[$cnt][2]=$row['task_audit_id'];
         $d1[$cnt][3]=$row['job_type_id'];
         $d1[$cnt][4]=$row['task_ref_id'];
         $d1[$cnt][5]=$row['task_audited_status'];
         $d1[$cnt][6]=$row['task_disposition_val'];
         $d1[$cnt][7]=$row['task_audited_reason'];
         $d1[$cnt][8]=$row['task_assignedto_empid'];
         $d1[$cnt][9]=$row['task_score'];
         $d1[$cnt][10]=$row['super_auditor_name'];
         $d1[$cnt][11]=$row['auditor_name'];        
         $cnt++;
    }
    $filepath_download = $_SERVER['DOCUMENT_ROOT'];
    $filepath_download .=  '/gl_global_upload/';
    $emp_id=Yii::app()->session['empid'];
    $timestamp=$emp_id."-".date("F-j-Y")."-".time();
    $filename_return="super_audit_report_$timestamp.xls";
    $file_return = $filepath_download.$filename_return;
    $FILE = fopen($file_return, "w");
    $print_data="Super Audit By\t Super Audit Date\t  Super Audit ID\t Job Type\t Offer ID\t Super Audit Score\t Error Disposition\t Super Auditor Remark\t Auditor Name\t Audit lead Score\t \n";
    fwrite($FILE, $print_data);
    $job= array(
        "9" => "Connect Pool Approved BuyLead", 
        "10" => "DNC Pool Approved BuyLead",
    "11" => "Connect Pool Deletion BuyLead",
    "12" => "DNC Pool Deletion BuyLead",
        "13" => "FLPNS (Non BL)",
        "14" => "DNC Pool Reviewed BuyLead",
        "15" => "DNC Pool Fully Auto",
        );
        $super_audit=array("0"=>"NOT OK","1"=>"OK" ,"2"=>"NOT OK");
        $audit=array("1"=>"PASS" ,"0"=>"FAIL");
   
                   for($i=1;$i<=count($d1);$i++){ 
                       $super_auditor=$d1[$i][0];
                       $auditor=$d1[$i][8];
                       if($d1[$i][10]<>''){
                        $super_auditor=$d1[$i][10].'<br>'.'('.$d1[$i][0].')';
                         }
                       if($d1[$i][11]<>''){
                        $auditor=$d1[$i][11].'<br>'.' ('.$d1[$i][8].')';
                        }
                        if(isset($d1[$i][9])){
                            $a_score=$audit[$d1[$i][9]];
                        }
                        else{
                            $a_score=$d1[$i][9]; 
                        }
                      $tr .= '<tr><td>'.trim($super_auditor).'</td><td>'.date_format(new DateTime($d1[$i][1]),"Y-m-d H:i:s").'</td>'
                           . '<td><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/SuperAuditEdit&action=edit&offerID='.$d1[$i][4].'\',\'_blank\',\'scrollbars=yes,width=1500, height=800\');" style="text-decoration:none;color:#0000ff;">' . $d1[$i][2] . '</a></td><td>'.trim($job[$d1[$i][3]]).'</td>'
                           . '<td>'.$d1[$i][4].'</td>'
                           . '<td>'.trim($super_audit[$d1[$i][5]]).'</td><td>'.trim($d1[$i][6]).'</td><td>'.trim($d1[$i][7]).'</td>'
                           . '<td>'.trim($auditor).'</td><td>'.trim($a_score).'</td></tr>';
                           $s_r=trim(preg_replace('/\s+/', ' ',$d1[$i][7] ));
                    $a1=trim($d1[$i][10].'('.$d1[$i][0].')');
                    $a2=date_format(new DateTime($d1[$i][1]),"Y-m-d H:i:s");
                    $a3=$d1[$i][2];
                    $a4=trim($job[$d1[$i][3]]);
                    $a5=$d1[$i][4];
                    $a6=trim($super_audit[$d1[$i][5]]);
                    $a7=trim($d1[$i][6]);
                    $a8=$s_r;
                    $a9=trim($d1[$i][11].' ('.$d1[$i][8].')');
                    $a10=trim($a_score);
                fwrite($FILE, "$a1 \t $a2\t $a3\t $a4\t $a5\t $a6\t $a7\t $a8\t $a9 \t $a10\n");
               }
       fclose($FILE);
       echo '<br><table id="examplep" class="display cell-border" style="width:100%">
       <thead><tr> <th scope="col" class="no-sort">Super Audit By</th>'
                     . '<th scope="col" class="no-sort">Super Audit Date</td>'
                     . '<th scope="col" class="no-sort">Super Audit ID</td>'
                     . '<th scope="col" class="no-sort">Job Type</td>'
                     . '<th scope="col" class="no-sort">Offer ID</td>'
                     . '<th scope="col" class="no-sort">Super Audit Score</td>'
                     . '<th scope="col" class="no-sort">Error Disposition</td>'
                     . '<th scope="col" class="no-sort">Super Auditor Remark</td>'
                     . '<th scope="col" class="no-sort">Auditor Name</td>'
                     . '<th scope="col" class="no-sort">Audit lead Score</td></tr></thead>'.$tr. '</table>'
                     . '<div style="padding:4px;font-weight:bold;text-align:center;"><a href="/gl_global_upload/'.$filename_return.'">Click to Download</a></div>';
}

public function super_audit_detailed_report($request){
    $emp_id=Yii::app()->session['empid'];
    $start_date=isset($request['start_date'])?$request['start_date']:'';
    $end_date=isset($request['end_date'])?$request['end_date']:'';
    $sql= "select task_audited_by_empid,TASK_Audited_DATE, ( select employeename as super_auditor_name from employee where employeeid=task_audited_by_empid),
    task_audit_id,	Freelance_JOB_Master.fk_job_type_id as job_type_id, TASK_REF_ID,employeename as auditor_name, task_audited_status,task_disposition_val,TASK_Audited_reason,TASK_ASSIGNEDTO_EMPID,task_score from freelance_job_master
    
    join freelance_task_details on job_master_id=fk_job_master_id
    join employee on employee.employeeid =Freelance_TASK_DETAILS.TASK_ASSIGNEDTO_EMPID
    join freelance_task_audit on task_detail_id=fk_task_detail_id
    
    left join freelance_task_dispositions on freelance_task_audit .fk_task_disposition_id=freelance_task_dispositions.task_disposition_id
    
    where freelance_job_master.fk_job_type_id in(9,10,11,12,13,14,15)
    
    and date(task_audited_date ) between to_date('$start_date','DD-MON-YYYY') and to_date('$end_date','DD-MON-YYYY')";
    $obj = new Globalconnection();
    $model = new GlobalmodelForm();
    $dbh_pg = $obj->connect_approvalpg(); 
    $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());
    $d1=array();
    $t1=$t2=$t3=$r1=$r2=$r3=$u1=$u2=$u3=0;
    $tr='';
    $cnt=1;
    $Array=array();
    while($row = $sth->read()){
         $d1[$cnt][0]=$row['task_audited_by_empid'];
         $d1[$cnt][1]=$row['task_audited_date'];
         $d1[$cnt][2]=$row['task_audit_id'];
         $d1[$cnt][3]=$row['job_type_id'];
         $d1[$cnt][4]=$row['task_ref_id'];
         $Array[$cnt]=$row['task_ref_id'];
         $d1[$cnt][5]=$row['task_audited_status'];
         $d1[$cnt][6]=$row['task_disposition_val'];
         $d1[$cnt][7]=$row['task_audited_reason'];
         $d1[$cnt][8]=$row['task_assignedto_empid'];
         $d1[$cnt][9]=$row['task_score'];
         $d1[$cnt][10]=$row['super_auditor_name'];
         $d1[$cnt][11]=$row['auditor_name'];        
         $cnt++;
    }
    
    $List = implode(',', $Array);
   
    if(empty($List)){
        echo "<script>alert('NO RECORDS FOUND!!')</script>";
        exit;
    }
    $sql1= " SELECT BL_AUDIT_RESPONSE_ID,  c.question_text as ques,a.bl_audit_response_emp_id as emp,
    FK_ETO_OFR_DISPLAY_ID,
  
  d.BL_AUDIT_QUES_OPT_ID,BL_AUDIT_QUES_OPT_DESC, REMARKS
  
       FROM BL_AUDIT_RESPONSE a,  
  
       BL_AUDIT_RESPONSE_DETAIL b,
  
  BL_AUDIT_QUESTION c ,
  
       BL_AUDIT_QUES_OPT d
  
    WHERE a.BL_AUDIT_RESPONSE_ID=b.FK_BL_AUDIT_RESPONSE_ID and fk_eto_ofr_display_id in ($List)
  and d.BL_AUDIT_QUES_OPT_ID = b.FK_BL_AUDIT_QUES_OPT_ID
  
  and QUESTION_ID = b.FK_QUESTION_ID AND c.QUESTION_TYPE IN(5,6,7,8,3,9,10,11) "; 

if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
{
    $dbh = $obj->connect_db_yii('postgress_web77v');   
}else{
    $dbh = $obj->connect_db_yii('postgress_web68v'); 
} 
    $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, array());
    $c=1;
    $b=array();
    while($row = $sth1->read()){
        if(!empty($row)){
        $b[$c][0]=$row['bl_audit_ques_opt_desc'];
        $b[$c][1]=$row['remarks'];
        $b[$c][2]=$row['fk_eto_ofr_display_id'];
        $b[$c][3]=$row['ques'];
        $b[$c][4]=$row['emp'];
        }
        $c++;
    }
    $filepath_download = $_SERVER['DOCUMENT_ROOT'];
    $filepath_download .=  '/gl_global_upload/';
    $emp_id=Yii::app()->session['empid'];
    $timestamp=$emp_id."-".date("F-j-Y")."-".time();
    $filename_return="super_audit_detailed_report_$timestamp.xls";
    $file_return = $filepath_download.$filename_return;
    $FILE = fopen($file_return, "w");
    $print_data="Super Audit By\t Super Audit Date\t  Super Audit ID\t Job Type\t Offer ID\t Super Audit Score\t Error Disposition\t Super Auditor Remark\t Auditor Name\t Audit Error Disposition\t Auditor Remark\t Audit lead Score\t \n";
    fwrite($FILE, $print_data);
    $job= array(
        "9" => "Connect Pool Approved BuyLead", 
        "10" => "DNC Pool Approved BuyLead",
    "11" => "Connect Pool Deletion BuyLead",
    "12" => "DNC Pool Deletion BuyLead",
        "13" => "FLPNS (Non BL)",
        "14" => "DNC Pool Reviewed BuyLead",
        "15" => "DNC Pool Fully Auto",
        );
        $super_audit=array("0"=>"NOT OK","1"=>"OK" ,"2"=>"NOT OK");
        $audit=array("1"=>"PASS" ,"0"=>"FAIL");
       
                   for($i=1;$i<=count($d1);$i++){ 
                    $super_auditor=$d1[$i][0];	
                    $auditor=$d1[$i][8];	
                    if($d1[$i][10]<>''){	
                     $super_auditor=$d1[$i][10].'<br>'.'('.$d1[$i][0].')';	
                      }	
                    if($d1[$i][11]<>''){	
                     $auditor=$d1[$i][11].'<br>'.' ('.$d1[$i][8].')';	
                     }
                       $arr=array();
                        for($j=1;$j<=count($b);$j++){
                             if(($b[$j][2]==$d1[$i][4]) && ($b[$j][4]==$d1[$i][8]) && ($b[$j][0]<>'Pass')){
                                 if($d1[$i][3]==13){
                                 $error_value=$b[$j][3]. "-" .$b[$j][0];
                                 }
                                 else{
                                    $error_value= $b[$j][0];
                                 }
                                 array_push($arr,$error_value);
                             }
                             
                         }
                         $arr1=array();
                         for($j=1;$j<=count($b);$j++){
                            if($b[$j][2]==$d1[$i][4] && ($b[$j][4]==$d1[$i][8])){
                                array_push($arr1,$b[$j][1]);
                            }
                        
                        }
                          if(empty($arr1)){
                              $arr1[0]='';
                          }
                          $errors=implode(',', $arr);
                          if(isset($d1[$i][9])){
                            $a_score=$audit[$d1[$i][9]];
                        }
                        else{
                            $a_score=$d1[$i][9]; 
                        }
                      $tr .= '<tr><td>'.trim($super_auditor).'</td><td>'.date_format(new DateTime($d1[$i][1]),"Y-m-d H:i:s").'</td>'
                           . '<td><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/auditEto/SuperAuditEdit&action=edit&offerID='.$d1[$i][4].'\',\'_blank\',\'scrollbars=yes,width=1500, height=800\');" style="text-decoration:none;color:#0000ff;">' . $d1[$i][2] . '</a></td><td>'.$job[$d1[$i][3]].'</td>'
                           . '<td>'.$d1[$i][4].'</td>'
                           . '<td>'.trim($super_audit[$d1[$i][5]]).'</td><td>'.trim($d1[$i][6]).'</td><td>'.trim($d1[$i][7]).'</td>'
                           . '<td>'.trim($auditor).'</td><td>'.trim($errors).'</td><td>'.trim($arr1[0]).'</td><td>'.trim($a_score).'</td></tr>';
                           $s_r=trim(preg_replace('/\s+/', ' ',$d1[$i][7] ));
                           $a_r=trim(preg_replace('/\s+/', ' ',$arr1[0]));
                    $a1=trim($d1[$i][10].'('.$d1[$i][0].')');
                    $a12=$d1[$i][2];
                    $a2=date_format(new DateTime($d1[$i][1]),"Y-m-d H:i:s");
                    $a3=isset($job[$d1[$i][3]])?$job[$d1[$i][3]]:'';
                    $a4=$d1[$i][4];
                    $a5=$super_audit[$d1[$i][5]];
                    $a6=$d1[$i][6];
                    $a7=$s_r;
                    $a8=trim($d1[$i][11].' ('.$d1[$i][8].')');
                    $a9=trim($a_score);
                    $a10=trim($errors);
                    $a11=$a_r;
                fwrite($FILE, "$a1 \t $a2\t $a12\t $a3\t $a4\t $a5\t $a6\t $a7\t $a8\t $a10\t $a11\t $a9 \n");
               }
       fclose($FILE);
       echo '<br><table id="example" class="display cell-border" style="width:100%">
       <thead><tr> <th scope="col" class="no-sort">Super Audit By</th>'
                     . '<th scope="col" class="no-sort">Super Audit Date</td>'
                     . '<th scope="col" class="no-sort">Super Audit ID</td>'
                     . '<th scope="col" class="no-sort">Job Type</td>'
                     . '<th scope="col" class="no-sort">Offer ID</td>'
                     . '<th scope="col" class="no-sort">Super Audit Score</td>'
                     . '<th scope="col" class="no-sort">Error Disposition</td>'
                     . '<th scope="col" class="no-sort">Super Auditor Remark</td>'
                     . '<th scope="col" class="no-sort">Auditor Name</td>'
                     . '<th scope="col" class="no-sort">Audit Error Disposition</td>'
                     . '<th scope="col" class="no-sort">Auditor Remark</td>'
                     . '<th scope="col" class="no-sort">Audit lead Score</td></tr></thead>'.$tr. '</table>'
                     . '<div style="padding:4px;font-weight:bold;text-align:center;"><a href="/gl_global_upload/'.$filename_return.'">Click to Download</a></div>';
}
private $queue_in = array(
    'current_date'=>"",
    'day1' => array('empid'=>"" ,'jobwise'=>array('9'=>array('DATA'=>"", 'REMCOUNT' => 0,'TOTCOUNT' => 0),'10'=>array('DATA'=>"", 'REMCOUNT' => 0,'TOTCOUNT' => 0),'11'=>array('DATA'=>"", 'REMCOUNT' => 0,'TOTCOUNT' => 0),'12'=>array('DATA'=>"", 'REMCOUNT' => 0,'TOTCOUNT' => 0),
    '13'=>array('DATA'=>"", 'REMCOUNT' => 0,'TOTCOUNT' => 0),'14'=>array('DATA'=>"", 'REMCOUNT' => 0,'TOTCOUNT' => 0),'15'=>array('DATA'=>"", 'REMCOUNT' => 0,'TOTCOUNT' => 0)))
);
private $queue_out = array(
    'day1' => array('empid'=>"" ,'jobwise'=>array('9'=>array('DATA'=>"", 'TOTCOUNT' => 0),'10'=>array('DATA'=>"", 'TOTCOUNT' => 0),'11'=>array('DATA'=>"", 'TOTCOUNT' => 0),'12'=>array('DATA'=>"", 'TOTCOUNT' => 0),
    '13'=>array('DATA'=>"", 'TOTCOUNT' => 0),'14'=>array('DATA'=>"", 'TOTCOUNT' => 0),'15'=>array('DATA'=>"", 'TOTCOUNT' => 0)))
);
private $mailMsg ="";

public function super_audit_fetch_sample($request){
    $start_date=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:'';
    $end_date=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:'';
    $current_date=isset($_REQUEST['date'])?$_REQUEST['date']:'';
    $current_month=isset($_REQUEST['month'])?$_REQUEST['month']:'';
    $conn = $this->connectRedis();
    $old_date=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE','current_date');
    $old_month=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE','current_month');
    $remTasks=array();
    $flag=0;
    $datecheck=0;
    for($i=9;$i<=15;$i++){
    $remTasks[$i]=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE','RemTasks'.$i);
    }
    if($current_date != $old_date){
        $datecheck=1;
    }
    if($remTasks[9]==0 && $remTasks[10]==0 && $remTasks[11]==0 && $remTasks[12]==0 && $remTasks[13]==0 && $remTasks[14]==0 && $remTasks[15]==0){
         $flag=1;
    }

    if($datecheck==1 || $flag == 1 ){ // $flag=1
        $this->queue_in['current_date']=$current_date;
        $this->queue_in['current_month']=$current_month;
    if($start_date!='' && $end_date !=''){
    $sql=" select J.task_assignedto_empid,
    J.fk_job_type_id,
    J.sample,
    J.Total_Quality,
    J.Approved_Quality,
    J.Pass_Task,
    J.Fail_Task,
    round((cast(J.Approved_Quality as decimal)/J.Total_Quality)*100,2) Quality_Slab_report,
    (case when J.Total_Quality <> 0 and round((cast(J.Approved_Quality as decimal)/J.Total_Quality)*100,2) >= 90.00 then cast(0.15*J.sample as text) || ' consider 0.15' 
          else cast(0.2*J.sample as text) || ' consider 0.20' end) Quality_Slab,
     (case when J.Total_Quality <> 0 and round((cast(J.Approved_Quality as decimal)/J.Total_Quality)*100,2) >= 90.00 then 
                (case when cast(0.15*J.sample as integer) >= 5 and J.sample >= 5 then cast(0.15*J.sample as integer)
                      when cast(0.15*J.sample as integer) < 5 and J.sample >= 5 then 	5
                      else J.sample
                 end)
           else (case when cast(0.20*J.sample as integer) >= 5 and J.sample >= 5 then cast(0.20*J.sample as integer)
                      when cast(0.20*J.sample as integer) < 5 and J.sample >= 5 then 	5
                      else J.sample
                 end) 
     end) Total_Sample,
    (case when J.Total_Quality = 0 then -1 
           -- above 90%    
          when J.Total_Quality <> 0 and round((cast(J.Approved_Quality as decimal)/J.Total_Quality)*100,2) >= 90.00 then 
               (case when cast(0.15*J.sample as integer) >= 5 and J.sample >= 5 then 
                           -- both are balanced 				   
                          ( case when (cast(0.60*cast(0.15*J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(0.15*J.sample as integer)as integer) <= J.Fail_Task) then cast(0.60*cast(0.15*J.sample as integer)as integer) 
                                 when (cast(0.60*cast(0.15*J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(0.15*J.sample as integer)as integer) > J.Fail_Task) then cast(0.60*cast(0.15*J.sample as integer)as integer) + (cast(0.40*cast(0.15*J.sample as integer)as integer) - J.Fail_Task)
                                 else  J.Pass_Task  end ) 
                           -- anyone is not balanced		 
                     when cast(0.15*J.sample as integer) < 5 and J.sample >= 5 then 
                           ( case when (cast(0.60*cast(5 as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) <= J.Fail_Task) then cast(0.60*cast(5 as integer)as integer) 
                                  when (cast(0.60*cast(5 as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) > J.Fail_Task) then cast(0.60*cast(5 as integer)as integer) + (cast(0.40*cast(5 as integer)as integer) - J.Fail_Task)
                                 else  J.Pass_Task  end )  
                         -- both not balanced									 
                     else
                         ( case when (cast(0.60*cast(J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) <= J.Fail_Task) then cast(0.60*cast(J.sample as integer)as integer) 
                                  when (cast(0.60*cast(J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) > J.Fail_Task) then cast(0.60*cast(J.sample as integer)as integer) + (cast(0.40*cast(J.sample as integer)as integer) - J.Fail_Task)
                                 else  J.Pass_Task  end )			 
                 end)
            ---below 90%		 
            else    
               (case when cast(0.20*J.sample as integer) >= 5 and J.sample >= 5 then   
                          ( case when (cast(0.60*cast(0.20*J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(0.20*J.sample as integer)as integer) <= J.Fail_Task) then cast(0.60*cast(0.20*J.sample as integer)as integer) 
                                 when (cast(0.60*cast(0.20*J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(0.20*J.sample as integer)as integer) > J.Fail_Task) then cast(0.60*cast(0.20*J.sample as integer)as integer) + (cast(0.40*cast(0.20*J.sample as integer)as integer) - J.Fail_Task)
                                 else  J.Pass_Task  end ) 
                     when cast(0.20*J.sample as integer) < 5 and J.sample >= 5 then 
                           ( case when (cast(0.60*cast(5 as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) <= J.Fail_Task) then cast(0.60*cast(5 as integer)as integer) 
                                  when (cast(0.60*cast(5 as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) > J.Fail_Task) then cast(0.60*cast(5 as integer)as integer) + (cast(0.40*cast(5 as integer)as integer) - J.Fail_Task)
                                 else  J.Pass_Task  end )    
                     else
                         ( case when (cast(0.60*cast(J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) <= J.Fail_Task) then cast(0.60*cast(J.sample as integer)as integer) 
                                  when (cast(0.60*cast(J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) > J.Fail_Task) then cast(0.60*cast(J.sample as integer)as integer) + (cast(0.40*cast(J.sample as integer)as integer) - J.Fail_Task)
                                 else  J.Pass_Task  end )			 
                 end)			  
    end) PASS,
    (case when J.Total_Quality = 0 then -1
          --above 90%
          when J.Total_Quality <> 0 and round((cast(J.Approved_Quality as decimal)/J.Total_Quality)*100,2) >= 90.00 then 
               (case when cast(0.15*J.sample as integer) >= 5 and J.sample >= 5 then   
                          ( case when (cast(0.60*cast(0.15*J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(0.15*J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(0.15*J.sample as integer)as integer) 
                                 when (cast(0.60*cast(0.15*J.sample as integer)as integer) > J.Pass_Task ) and (cast(0.40*cast(0.15*J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(0.15*J.sample as integer)as integer) + (cast(0.60*cast(0.15*J.sample as integer)as integer) - J.Pass_Task)
                                 else  J.Fail_Task  end ) 
                     when cast(0.15*J.sample as integer) < 5 and J.sample >= 5 then 
                           ( case when (cast(0.60*cast(5 as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(5 as integer)as integer) 
                                  when (cast(0.60*cast(5 as integer)as integer) > J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(5 as integer)as integer) + (cast(0.60*cast(5 as integer)as integer) - J.Pass_Task)
                                 else  J.Fail_Task end )    
                     else
                         ( case when (cast(0.60*cast(J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(J.sample as integer)as integer) 
                                  when (cast(0.60*cast(J.sample as integer)as integer) > J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(J.sample as integer)as integer) + (cast(0.60*cast(J.sample as integer)as integer) - J.Pass_Task)
                                 else  J.Fail_Task  end ) 
                 end)	
          ---below 90%
         else 
               (case when cast(0.20*J.sample as integer) >= 5 and J.sample >= 5 then   
                          ( case when (cast(0.60*cast(0.20*J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(0.20*J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(0.20*J.sample as integer)as integer) 
                                 when (cast(0.60*cast(0.20*J.sample as integer)as integer) > J.Pass_Task ) and (cast(0.40*cast(0.20*J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(0.20*J.sample as integer)as integer) + (cast(0.60*cast(0.20*J.sample as integer)as integer) - J.Pass_Task)
                                 else  J.Fail_Task  end ) 
                     when cast(0.20*J.sample as integer) < 5 and J.sample >= 5 then 
                           ( case when (cast(0.60*cast(5 as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(5 as integer)as integer) 
                                  when (cast(0.60*cast(5 as integer)as integer) > J.Pass_Task ) and (cast(0.40*cast(5 as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(5 as integer)as integer) + (cast(0.60*cast(5 as integer)as integer) - J.Pass_Task)
                                 else  J.Fail_Task end )    
                     else
                         ( case when (cast(0.60*cast(J.sample as integer)as integer) <= J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(J.sample as integer)as integer) 
                                  when (cast(0.60*cast(J.sample as integer)as integer) > J.Pass_Task ) and (cast(0.40*cast(J.sample as integer)as integer) <= J.Fail_Task) then cast(0.40*cast(J.sample as integer)as integer) + (cast(0.60*cast(J.sample as integer)as integer) - J.Pass_Task)
                                 else  J.Fail_Task  end )
                end)
    end) FAIL
from
(select H.task_assignedto_empid,
    H.fk_job_type_id,
    H.sample,
    (case when G.Total_Quality_Sample is null then 100 else G.Total_Quality_Sample end) Total_Quality,
    (case when G.Total_Quality_Sample is null then 80 else G.Approved_Quality_Sample end) Approved_Quality,
    H.Pass_Task,
    H.Fail_Task
from		
(select B.task_assignedto_empid , A.fk_job_type_id , COALESCE(count(B.task_ref_id ),0) sample , 
    sum( case when B.task_score = 1 then 1 else 0 end) Pass_Task,
    sum( case when B.task_score = 0 then 1 else 0 end) Fail_Task
from freelance_job_master A, freelance_task_details B
 where   A.job_master_id = B.fk_job_master_id
         and A.fk_job_type_id >= 9
         and A.fk_job_type_id <= 15
        --and B.task_assignedto_empid = 990000079
         and B.task_completion_date ::date between  '$start_date'::date and '$end_date'::date
 group by B.task_assignedto_empid, A.fk_job_type_id) H 
left join
(select task_assignedto_empid,
             sum(case when task_audited_status = 1 then 1 end) Approved_Quality_Sample,
             count(1) Total_Quality_Sample
                from freelance_task_audit E ,freelance_task_details F , freelance_job_master I   
                     where F.task_detail_id = E.fk_task_detail_id 
                           and F.fk_job_master_id = I.job_master_id
                            and I.fk_job_type_id >= 9
                            and I.fk_job_type_id <= 15
                            --and F.task_assignedto_empid = 990000079
                            and E.task_audited_date::date >= ('$start_date'::date  - interval '28 days')::date
                            and E.task_audited_date::date < '$end_date' ::date
                            --and E.task_audited_date::date >= '2021-06-09'::date
                            --and E.task_audited_date::date <= '2021-07-07'::date
        group by task_assignedto_empid) G on  G.task_assignedto_empid = H.task_assignedto_empid ) J order by J.task_assignedto_empid
";

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        $dbh_pg = $obj->connect_approvalpg(); 
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array()); 
        $temparr=array();     
        $i=0;
        while($row=$sth->read()){
               $temparr[$i]['task_assignedto_empid']= isset($row['task_assignedto_empid']) ? ($row['task_assignedto_empid']) : 0;
                $temparr[$i]['job_type']= isset($row['fk_job_type_id']) ? ($row['fk_job_type_id']) : 0;
                $temparr[$i]['total_sample']=isset($row['total_sample']) ? ($row['total_sample']) : 0;
                $temparr[$i]['pass']=isset($row['pass']) ? ($row['pass']) : 0;
                $temparr[$i]['fail']=isset($row['fail']) ? ($row['fail']) : 0;
                $i++;
        }
        $total_ofr_ids=array('day1'=>array('9'=>0,'10'=>0,'11'=>0,'12'=>0,'13'=>0,'14'=>0,'15'=>0));
        for($i=0;$i<count($temparr);$i++){  
            $job=isset($temparr[$i]['job_type'])?$temparr[$i]['job_type']:0;
            $emp=isset($temparr[$i]['task_assignedto_empid'])?$temparr[$i]['task_assignedto_empid']:0;
            $pass=isset($temparr[$i]['pass'])?$temparr[$i]['pass']:0;
            $fail=isset($temparr[$i]['fail'])?$temparr[$i]['fail']:0;         
            $sql="SELECT   task_ref_id,task_score,FK_JOB_TYPE_ID from freelance_job_master
            join freelance_task_details on job_master_id=fk_job_master_id where task_assignedto_empid=$emp and fk_job_type_id=$job and task_completion_date::date between  '$start_date'::date and '$end_date'::date and task_status=2  and task_score=1 limit $pass
             ";
            $res = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array()); 
           if($res){
            while($row = $res->read())
			{
				$ofrId =  isset($row['task_ref_id']) ? ($row['task_ref_id']) : 0;
				$this->queue_in['day1']['jobwise'][$job]['DATA']  .= $ofrId.","; 
				$this->queue_in['day1']['jobwise'][$job]['TOTCOUNT'] ++;
                $this->queue_in['day1']['jobwise'][$job]['REMCOUNT'] ++;
				$total_ofr_ids['day1'][$job]++;
			}

		    }
        $sql="SELECT   task_ref_id,task_score,FK_JOB_TYPE_ID from freelance_job_master
        join freelance_task_details on job_master_id=fk_job_master_id where task_assignedto_empid=$emp and fk_job_type_id=$job and task_completion_date::date between  '$start_date'::date and '$end_date'::date and task_status=2  and task_score=0 limit $fail
         ";
          $res1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array()); 
          if($res1){
           while($row = $res1->read())
           {
               $ofrId =  isset($row['task_ref_id']) ? ($row['task_ref_id']) : 0;
               $this->queue_in['day1']['jobwise'][$job]['DATA']  .= $ofrId.","; 
               $this->queue_in['day1']['jobwise'][$job]['TOTCOUNT'] ++;
               $this->queue_in['day1']['jobwise'][$job]['REMCOUNT'] ++;
               $total_ofr_ids['day1'][$job]++;
           }
           }
           }
             $this->insertIntoHash($start_date,$end_date);
            mail('mohit.chopra@indiamart.com,saylee.shetty@indiamart.com,Shreya.bose@indiamart.com,Manoj.pandey@indiamart.com,kumar.praveen3@indiamart.com,balajee@indiamart.com', 'Super Audit data', $this->mailMsg);
            //mail('arora.akshita@indiamart.com', 'Super Audit data', $this->mailMsg);
   }
   else{
       echo"You have entered invalid date!";
       exit;
   }
 }

   //exit;
           $job_name= array(
            "9" => "Connect Pool Approved BuyLead", 
            "10" => "DNC Pool Approved BuyLead",
        "11" => "Connect Pool Deletion BuyLead",
        "12" => "DNC Pool Deletion BuyLead",
            "13" => "FLPNS (Non BL)",
            "14" => "DNC Pool Reviewed BuyLead",
            "15" => "DNC Pool Fully Auto",
            );

            $oid=array();
            $remcount=array();
            $j=0;
            for($i=9;$i<=15;$i++){
                $totalofr[$j]=$this->GetTotalOfr($i,'day1');
                $oid[$j]=$this->GetFirstIdFromRedis($i,'day1');
                $remcount[$j]=$this->GetCountOfRemIds($i,'day1');
                $j++;
           }
            //exit;
           echo' <div style="width: 100%;padding-right: 15px;padding-left: 15px;margin-right: auto;margin-left: auto;">
           <table id="table" align="center" style="width:100%;border-collapse:collapse;color: #212529;border-radius: 10px;margin-bottom: 0px;border-spacing: 2px;
           border-color: grey;--font-family-sans-serif: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
           --font-family-monospace: SFMono-Regular,Menlo,Monaco,Consolas,"Liberation Mono","Courier New",monospace;"> <thead> <tr style="margin: 10px;color: #1d7ec5;
           font-size: 22px;font-weight: 700;" align="center" colspan="4"> <thead> 
           <tr style="background-color:white;font-weight: bold;line-height: 1.5;font-size: 17px;text-align:center;padding:.75rem;color: #211E97; "> <th> Job Type </th><th> Total Buylead count</th><th> Remaining BuyLead Count </th> <th>Action </th></tr>
           </thead>
           <tbody style="font-size: 1rem;border-spacing: 2px;font-weight: 500;line-height: 1.5;" align="center"> 
           <tr> <td style="font-size:17px;"> '.$job_name['9'].'</td><td style="font-size:17px;"> '.$totalofr[0].' </td><td style="font-size:17px;"> '.$remcount[0].'</td><td> <span><a target="_blank" href="/index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=audit&offerID='.$oid[0].'" > Perform Super Audit </a> </span></td></tr>
           <tr> <td style="font-size:17px;">'.$job_name['11'].' </td><td style="font-size:17px;">'.$totalofr[2].' </td><td style="font-size:17px;">'.$remcount[2].' </td><td> <span><a target="_blank" href="/index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=audit&offerID='.$oid[2].'"> Perform Super Audit </a> </span> </td></tr>
           <tr> <td style="font-size:17px;">'.$job_name['13'].' </td><td style="font-size:17px;"> '.$totalofr[4].' </td><td style="font-size:17px;">'.$remcount[4].' </td><td> <span><a target="_blank" href="/index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=audit&offerID='.$oid[4].'"> Perform Super Audit </a> </span></td></tr>           
           <tr> <td style="font-size:17px;">'.$job_name['10'].' </td><td style="font-size:17px;">'.$totalofr[1].' </td><td style="font-size:17px;"> '.$remcount[1].'</td><td> <span><a target="_blank" href="/index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=audit&offerID='.$oid[1].'" > Perform Super Audit </a> </span> </td></tr>
           <tr> <td style="font-size:17px;">'.$job_name['12'].' </td><td style="font-size:17px;"> '.$totalofr[3].'</td><td style="font-size:17px;">'.$remcount[3].' </td><td> <span><a target="_blank" href="/index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=audit&offerID='.$oid[3].'"> Perform Super Audit </a> </span> </td></tr>
           <tr> <td style="font-size:17px;">'.$job_name['14'].' </td><td style="font-size:17px;"> '.$totalofr[5].' </td><td style="font-size:17px;"> '.$remcount[5].'</td><td> <span><a target="_blank" href="/index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=audit&offerID='.$oid[5].'"> Perform Super Audit </a> </span> </td></tr>
           <tr> <td style="font-size:17px;">'.$job_name['15'].' </td><td style="font-size:17px;"> '.$totalofr[6].' </td><td style="font-size:17px;"> '.$remcount[6].'</td><td> <span><a target="_blank" href="/index.php?r=admin_eto/auditEto/SuperAuditDashboard&mid=3934&action=audit&offerID='.$oid[6].'"> Perform Super Audit </a> </span></td></tr> 
           </tbody> </table></div><br>';   
        } 

        public function connectRedis()
        {
            $server = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
            $mid = isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
            $redis = '';
            try {
                $obj = new Globalconnection();
                $redis = $obj->GetRedisConn();
                return $redis;
            } catch (Exception $e) {
                echo "<div style='text-align: center; margin-top: 20%;'>
                <hr>Connection Error: Please Contact Gladmin.
                    Click to Open <a href='/index.php?r=admin_marketplace/Freelance/ShowJobs&mid=$mid'>Job Dashboard</a>
                <hr></div>";
                $msg =  $e->getMessage();
                mail("laxmi@indiamart.com", "JOBTASKS - Couldn't connected to Redis ", $msg);
                exit;
            }
        }
        public $redis;
        public function insertIntoHash($start_date,$end_date)
        {
            $this->redis = $this->connectRedis();
            $this->redis->DEL("SUPERAUDIT_IN_DAY1_QUEUE");
            $this->redis->DEL("SUPERAUDIT_OUT_DAY1_QUEUE");
            $this->redis->HSET("SUPERAUDIT_IN_DAY1_QUEUE","current_date",$this->queue_in['current_date']);
            $this->redis->HSET("SUPERAUDIT_IN_DAY1_QUEUE","current_month",$this->queue_in['current_month']);
            for($i=9;$i<=15;$i++){
            $temparr=array();
            $this->queue_in['day1']['jobwise'][$i]['DATA']=  rtrim($this->queue_in['day1']['jobwise'][$i]['DATA'],",");
            $AuditorList=array();
            $offeridArr=array();
            $temparr=array();
            $temparr=explode(",",$this->queue_in['day1']['jobwise'][$i]['DATA']);
            shuffle($temparr);
            $tempstr=implode(",",$temparr);
            $AuditorList=$this->GetAuditorName($tempstr,$start_date,$end_date);
            $noOfIds=$this->queue_in['day1']['jobwise'][$i]['TOTCOUNT'];
            $this->mailMsg .= "JobType:".$i."\n";
            for($j=0;$j<$noOfIds;$j++){
            $offeridArr[$j]=$AuditorList[$j]['offer_id'];
            $this->mailMsg .= "Offer Id:".$AuditorList[$j]['offer_id'].",Auditor:".$AuditorList[$j]['auditor_name']."\n";
            }
            $this->mailMsg .="Total:" .$this->queue_in['day1']['jobwise'][$i]['TOTCOUNT']."\n"; 
            $this->mailMsg .="==========================================================="."\n";
            $finalstr=implode(",",$offeridArr);
            $this->redis->HSET("SUPERAUDIT_IN_DAY1_QUEUE","Tasks".$i,$finalstr);
            $this->redis->HSET("SUPERAUDIT_IN_DAY1_QUEUE","RemTasks".$i,$this->queue_in['day1']['jobwise'][$i]['REMCOUNT'] );
            $this->redis->HSET("SUPERAUDIT_IN_DAY1_QUEUE","TotTasks".$i,$this->queue_in['day1']['jobwise'][$i]['TOTCOUNT'] );
            }
        }

        public function GetAuditorName($offerids,$start_date,$end_date){
            //print_r($offerids);
            $obj = new Globalconnection();
           $model = new GlobalmodelForm();
           $dbh_pg = $obj->connect_approvalpg(); 
           if($offerids){
             $sql="SELECT   task_ref_id,task_assignedto_empid, employeename from 
             freelance_task_details join employee on task_assignedto_empid= employeeid 
             where task_ref_id in ($offerids) and task_completion_date::date between  '$start_date'::date and '$end_date'::date  order by task_ref_id ";
               $res = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array()); 
               $i=0;
               while($row=$res->read()){
                   $temp[$i]['auditor_name']=$row['employeename'];
                   $temp[$i]['offer_id']=$row['task_ref_id'];
                   $i++;
               }
            }
            else{
                echo "No offer ids for the current date range!";
                exit;
            }
               return $temp;

        }
        public function GetTotalOfr($job_type_id,$dayno){
            $conn = $this->connectRedis();
            $count=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE',"TotTasks".$job_type_id);
            return $count;
        }
        public function GetFirstIdFromRedis($job_type_id,$dayno)
        {
            $conn = $this->connectRedis();
            $job_type='Tasks'.$job_type_id;
            $res=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE',$job_type);
            $idsarr=array();
            if($res != "" ) 
            {
             $resarr=explode(",",$res);
             $count= count($resarr);
                if(($count >0) && ($count <=1))
                {
                    $idslist =$res;
                    $idsarr=explode(",",$idslist);
                    $leftbls="";
                }
                else
                {
                    $idsarr= array_slice($resarr,0,1);
                    $idslist    = implode(',', $idsarr);
                }

              }  
      if (empty($idsarr)) {
           $cookie_mid = $_REQUEST['mid'];
          //       echo "<div style='text-align: center; margin-top: 20%;'>
        //       <hr>All the Buyleads of this job are done. Please go to jobs Dashboard to start a new job.
       //       <hr></div>";
        //    exit;
          return 0;
        }
        else
        {
            $idslist = trim($idslist, ',');
        }
        return $idslist;
        }

    public function PutIdInOutQueue($job_type){
        $conn = $this->connectRedis();
        $res=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE','Tasks'.$job_type);
   
         $resarr=explode(",",$res);
         $count= count($resarr);
         $idslist="";
         $idsarr=array();
         $leftbls="";
         if(($count >0) && ($count <=1))
         {
             $idslist =$res;
             $idsarr=explode(",",$idslist);
             $leftbls="";
             $leftcount=0;
         }
         else
         {
            $idsarr= array_slice($resarr,0,1);
            $leftbls= array_slice($resarr,1,$count-1);
            $leftcount=count($leftbls);
            $idslist    = implode(',', $idsarr);
            $leftbls    = implode(',', $leftbls);
         
         }
        
         $leftbls = trim($leftbls, ',');
         $idslist = trim($idslist, ',');
        
       $conn->HSET('SUPERAUDIT_IN_DAY1_QUEUE', 'Tasks'.$job_type, "$leftbls");
        $conn->HSET('SUPERAUDIT_IN_DAY1_QUEUE', 'RemTasks'.$job_type, "$leftcount");
        $this->queue_out['day1']['jobwise'][$job_type]['DATA'].= $idslist; 
        $out= $conn->HGET('SUPERAUDIT_OUT_DAY1_QUEUE','Tasks'.$job_type);
        if($out==''){
        $conn->HSET("SUPERAUDIT_OUT_DAY1_QUEUE",'Tasks'.$job_type,$this->queue_out['day1']['jobwise'][$job_type]['DATA'] );
        }
        else{
        $out= $conn->HGET('SUPERAUDIT_OUT_DAY1_QUEUE','Tasks'.$job_type);
        $outarr=explode(",",$out);
        array_push($outarr,$idslist);
        $outlist=implode(",",$outarr);
        $outlist = trim($outlist, ',');
        $conn->HSET("SUPERAUDIT_OUT_DAY1_QUEUE","Tasks".$job_type,"$outlist" );
        }
    }

    public function RemoveIdfromOutQueue($job_type){
        $conn = $this->connectRedis();
        $res=$conn->HGET('SUPERAUDIT_OUT_DAY1_QUEUE','Tasks'.$job_type);// echo '<pre>';print_r($res);
            $resarr=explode(",",$res);
            $count= count($resarr);
            $idslist="";
            $idsarr=array();
            $leftbls="";
            if(($count >0) && ($count <=1))
            {
                $idslist =$res;
                $idsarr=explode(",",$idslist);
                $leftbls="";
            }
            else
            {
                $idsarr= array_slice($resarr,$count-1,1);
                $leftbls= array_slice($resarr,0,$count-1);
                $idslist    = implode(',', $idsarr);
                $leftbls    = implode(',', $leftbls);
            }
            $leftbls = trim($leftbls, ',');
        $this->queue_out['day1']['jobwise'][$job_type]['DATA']  = $leftbls; 
        $conn->HSET("SUPERAUDIT_OUT_DAY1_QUEUE","Tasks".$job_type,"$leftbls");
    }
    public function GetCountOfRemIds($job_type_id,$dayno)
    {
        $conn = $this->connectRedis();
        $count=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE',"RemTasks".$job_type_id);
        return $count;
    }
    public function RemovefromInQueue($job_type_id){
        $conn = $this->connectRedis();
        $res=$conn->HGET('SUPERAUDIT_IN_DAY1_QUEUE',"Tasks".$job_type_id);
        $resarr=explode(",",$res);
            $count= count($resarr);
            $idslist="";
            $idsarr=array();
            $leftbls="";
            if(($count >0) && ($count <=1))
            {
                $idslist =$res;
                $idsarr=explode(",",$idslist);
                $leftbls="";
                $leftcount=0;
            }
            else
            {
                $idsarr= array_slice($resarr,0,1);
                $leftbls= array_slice($resarr,1,$count-1);
                $leftcount=count($leftbls);
                $idslist    = implode(',', $idsarr);
                $leftbls    = implode(',', $leftbls);
            }
            $leftbls = trim($leftbls, ',');
            $conn->HSET('SUPERAUDIT_IN_DAY1_QUEUE', 'Tasks'.$job_type_id, "$leftbls");
            $conn->HSET('SUPERAUDIT_IN_DAY1_QUEUE', 'RemTasks'.$job_type_id, "$leftcount");
    }
    }