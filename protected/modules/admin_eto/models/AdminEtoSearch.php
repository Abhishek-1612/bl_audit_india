<?php
include('/usr/local/bin/vendor/autoload.php');
use Aws\S3\S3Client;    
class AdminEtoSearch extends CFormModel{
    
public function showAdvSearchResultPG($request,$emp_id,$model,$statusDesc,$userStatusDesc,$start,$lvl_code,$adm_lvl,$status) {
	$conn_obj=new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $conn_obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
        }
  	    $offersPerPage= 25; 
 	    $result_type=$cond_dir=$cond=$cond_fenq='';
  	    $sql_total=$mcat_table=$mcat_table_expired='';
        $bindParam = array();
        $critHash= array(); 
        $critHash['memmail']=$memmail = $request->getParam('memmail','');	
        $critHash['mem']=$mem = $request->getParam('mem','');  
        $critHash['offer']=$offer = $request->getParam('offer',0);  	
        $critHash['memmobile']=$memmobile = $request->getParam('memmobile','');
        $critHash['ph_country']=$ph_country = $request->getParam('ph_country','');
        $critHash['mcat_id']=$mcat_id =$request->getParam('mcat_id',0);
        $critHash['mcat_name']=$mcat_name =$request->getParam('mcat_name','');
        if($mcat_id>0){
        $critHash['status']=$status = $request->getParam('status','L');
        }else{
        $critHash['status']=$status = '';
        }
  	$page = $request->getParam('page','');
  	$jump = $request->getParam('jump','');
  	$start = $request->getParam('start',0);
  	if(!empty($page) && !empty($jump)){
		$start = ($page*$offersPerPage)-$offersPerPage;
  	}
  	$flagError=0; $errArr= array();	
	$memmail = $request->getParam('memmail','');
	
            if (empty($mem) && empty($memmail) && empty($offer)  && empty($memmobile) && empty($mcat_id)) {
                    array_push($errArr,"Enter Offer ID or Member ID or Member Email or Member Mobile or Mcat ID");
                    $flagError=1;
            }      
            if (!empty($offer) && !preg_match('/^\d+$/',$offer)) {
                    array_push($errArr,"Invalid offer ID");
                    $flagError=1;
            }
            if (!empty($mem) && !preg_match('/^\d+$/',$mem)) {
                    array_push($errArr,"Invalid Member ID");
                    $flagError=1;
            }
            if (!empty($memmobile) && !preg_match('/^\d+$/',$memmobile)) {
                    array_push($errArr,"Invalid Mobile Number");
                    $flagError=1;
            } 
        
if(!empty($offer) || !empty($mem) || !empty($memmobile) || !empty($memmail))
{
  $mcat_id='';  
}
  if ($flagError != 1) {
if(!empty($mcat_id)){
            if($status=='L'){
                $whereCond = "  ETO_OFR_MAPPING.FK_ETO_OFR_ID= ETO_OFR.ETO_OFR_DISPLAY_ID AND ETO_OFR_MAPPING.FK_GLCAT_MCAT_ID=:mcat_id"; 
                $mcat_table='ETO_OFR_MAPPING';
                $bindParam[':mcat_id'] = $mcat_id;
            }else{
                $mcat_table='ETO_OFR_MAPPING_EXPIRED';                
                $whereCond_expired = "  ETO_OFR_MAPPING_EXPIRED.FK_ETO_OFR_ID= ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID AND ETO_OFR_MAPPING_EXPIRED.FK_GLCAT_MCAT_ID=:mcat_id";               
                $bindParam[':mcat_id'] = $mcat_id;
            }
     }elseif(!empty($offer)){
     		$bindParam[':offer'] = $offer;
                $whereCond = "  ETO_OFR.ETO_OFR_DISPLAY_ID=:offer";  
                $whereDirCond = "  DIR_QUERY_FREE.ETO_OFR_DISPLAY_ID=:offer";
                $whereCond_expired = "  ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID=:offer";
                $whereCond_del = "  ETO_OFR_TEMP_DEL.ETO_OFR_DISPLAY_ID=:offer";
                $whereCond_fenq = "  eto_ofr_from_fenq.DIR_QUERY_FREE_REFID=:offer"; 
     }elseif(!empty($mem)){
     		$whereCond = "  ETO_OFR.FK_GLUSR_USR_ID=:mem";  
                $whereDirCond = "  DIR_QUERY_FREE.FK_GLUSR_USR_ID=:mem";
                $whereCond_expired = "  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=:mem";
                $whereCond_del = "  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=:mem";
                $whereCond_fenq = "  eto_ofr_from_fenq.FK_GLUSR_USR_ID=:mem"; 
		$bindParam[':mem'] = $mem;
     }elseif(!empty($memmail)){
     		$whereCond = "  GLUSR_USR.GLUSR_USR_EMAIL=:memmail";  
                $whereDirCond = "  GLUSR_USR.GLUSR_USR_EMAIL=:memmail";
                $whereCond_expired = "  GLUSR_USR.GLUSR_USR_EMAIL=:memmail";
                $whereCond_del = "  GLUSR_USR.GLUSR_USR_EMAIL=:memmail";
                $whereCond_fenq = "  GLUSR_USR.GLUSR_USR_EMAIL=:memmail";
		$bindParam[':memmail'] = $memmail;
     }elseif(!empty($memmobile)){
            if($ph_country=='IN')
            {                   
                    $whereCond = "  GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR_PH_COUNTRY='91'";
                    $whereDirCond = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91'";
                    $whereCond_expired = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile  AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91'";
                    $whereCond_del = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91'";
                    $whereCond_fenq = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91'";  
                    $bindParam[':memmobile'] =$memmobile;
            }else{                   
                    $whereCond = "  GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR_PH_COUNTRY<>'91'";
                    $whereDirCond = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY<>'91'";
                    $whereCond_expired = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile  AND GLUSR_USR.GLUSR_USR_PH_COUNTRY<>'91'";
                    $whereCond_del = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY<>'91'";
                    $whereCond_fenq = "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY<>'91'";
                    $bindParam[':memmobile'] = $memmobile;
            }
     }
         
 
         if(!empty($mcat_id)){              
                if($status=='L'){
                    $sql_total = "Select COUNT(ETO_OFR_ID) CNT from ETO_OFR, $mcat_table WHERE ETO_OFR.ETO_OFR_DISPLAY_ID=FK_ETO_OFR_ID and $whereCond";
                }else{
                     $sql_total = "Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_EXPIRED, $mcat_table WHERE ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID=FK_ETO_OFR_ID and $whereCond_expired";					
                }
        }elseif(!empty($offer)){
             $sql_total = "SELECT SUM(CNT) CNT FROM 
                ( 
                Select COUNT(ETO_OFR_ID) CNT from ETO_OFR  WHERE  $whereCond  
                UNION ALL 
                Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_EXPIRED WHERE  $whereCond_expired  
                UNION ALL 
                Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_TEMP_DEL WHERE  $whereCond_del  
                UNION ALL 
                Select COUNT(ETO_OFR_ID) CNT from DIR_QUERY_FREE WHERE DIR_QUERY_FREE.DIR_QUERY_FREE_BL_TYP IN (1,2) and $whereDirCond 
                UNION ALL
                Select COUNT(DIR_QUERY_FREE_REFID) CNT from eto_ofr_from_fenq WHERE FK_ETO_OFR_ID is null and $whereCond_fenq
                    ) A";                
        }else if(!empty($mem)){
			  if(isset($_REQUEST['do']) && $_REQUEST['do']=='livelead')
			  {
			    $sql_total = "Select COUNT(ETO_OFR_ID) CNT from ETO_OFR WHERE $whereCond  ";
			  }
			  else if(isset($_REQUEST['EXPDELLEAD']) && $_REQUEST['EXPDELLEAD']=='EXPLEAD')
			  {
			    $sql_total = "Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_EXPIRED WHERE $whereCond_expired  ";
			  }
			  else if(isset($_REQUEST['EXPDELLEAD']) && $_REQUEST['EXPDELLEAD']=='DELLEAD')
			  {
			    $sql_total = "SELECT SUM(CNT) CNT FROM 
			      ( 
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_TEMP_DEL WHERE $whereCond_del 
			      UNION ALL 
			      Select COUNT(DIR_QUERY_FREE_REFID) CNT from eto_ofr_from_fenq WHERE FK_ETO_OFR_ID is null and $whereCond_fenq 
                            ) A";                       
			  }
			  else
			  {
			  $sql_total = "SELECT SUM(CNT) CNT FROM 
			      ( 
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR  WHERE $whereCond 
			      UNION ALL 
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_EXPIRED WHERE $whereCond_expired 
			      UNION ALL 
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_TEMP_DEL WHERE $whereCond_del 
			      UNION ALL 
			      Select COUNT(ETO_OFR_ID) CNT from DIR_QUERY_FREE WHERE DIR_QUERY_FREE.DIR_QUERY_FREE_BL_TYP IN (1,2) and $whereDirCond 
			      UNION ALL
			      Select COUNT(DIR_QUERY_FREE_REFID) CNT from eto_ofr_from_fenq WHERE FK_ETO_OFR_ID is null and $whereCond_fenq 
                      ) A";
			    }  
        }elseif(!empty($memmail)){ 
            $sql_total = "SELECT SUM(CNT) CNT FROM 
			      ( 
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR,GLUSR_USR  WHERE ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND $whereCond 
			      UNION ALL  
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_EXPIRED,GLUSR_USR WHERE ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND $whereCond_expired 
			      UNION ALL  
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_TEMP_DEL,GLUSR_USR  WHERE ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND $whereCond_del 
			      UNION ALL 
			      Select COUNT(ETO_OFR_ID) CNT from DIR_QUERY_FREE,GLUSR_USR WHERE DIR_QUERY_FREE.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND DIR_QUERY_FREE.DIR_QUERY_FREE_BL_TYP IN (1,2) and $whereDirCond 
			      UNION ALL 
			      Select COUNT(DIR_QUERY_FREE_REFID) CNT from eto_ofr_from_fenq,GLUSR_USR WHERE  eto_ofr_from_fenq.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID and $whereCond 
                      ) A";
            
        }elseif(!empty($memmobile)){			  
			  $sql_total = "SELECT SUM(CNT) CNT FROM 
			      ( 
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR,GLUSR_USR  WHERE ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND $whereCond 
			      UNION ALL  
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_EXPIRED,GLUSR_USR WHERE ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND $whereCond_expired 
			      UNION ALL  
			      Select COUNT(ETO_OFR_ID) CNT from ETO_OFR_TEMP_DEL,GLUSR_USR  WHERE ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND $whereCond_del 
			      UNION ALL 
			      Select COUNT(ETO_OFR_ID) CNT from DIR_QUERY_FREE,GLUSR_USR WHERE DIR_QUERY_FREE.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID AND DIR_QUERY_FREE.DIR_QUERY_FREE_BL_TYP IN (1,2) and $whereDirCond 
			      UNION ALL 
			      Select COUNT(DIR_QUERY_FREE_REFID) CNT from eto_ofr_from_fenq,GLUSR_USR WHERE  eto_ofr_from_fenq.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID and $whereCond 
                      ) A";
                          
       }
		$sth_total = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql_total,$bindParam);      
		$totalOffers = $sth_total->read();//print_r($totalOffers);
		$totalOffers = intval($totalOffers["cnt"]);
		if ($start > $totalOffers) {
		   $start=0;
		}
		if ($start < 0) {
		   $start=0;
		}
		$sql='';       
		$last= $start + $offersPerPage ;
		$start1 = $start+1;
	   
	   	$bindParam[':start1'] = $start1;
	   	$bindParam[':last'] = $last;
        if(!empty($mcat_id)){   
             if($status=='L'){
                 $sql = "select temp.* from (
                select eto1.*, ROW_NUMber() over (order by ETO_OFR_ID DESC)AS RNUM from (
                SELECT eto.* from (
                Select 
                    ETO_OFR_APPROV OFR_STATUS,ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
                    ETO_OFR_DESC,FK_GLUSR_USR_ID,
                    GLUSR_USR_APPROV,ETO_OFR_APPROV,
                    (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=ETO_OFR.FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                    GLCAT_CAT_NAME,
                    (CASE 
                            WHEN ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN'  THEN 'FOREIGN' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
                              ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                    (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                    ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME ,
                    (case when FK_GL_MODULE_ID='FENQ' THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                    3 TABLE_TYP,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG 
                from 
                    ETO_OFR join $mcat_table on ETO_OFR_DISPLAY_ID=FK_ETO_OFR_ID 
                    join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                    left outer join GLCAT_CAT on ETO_OFR.FK_GLCAT_CAT_ID=GLCAT_CAT.GLCAT_CAT_ID 
                    left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                    where $whereCond  
                ) eto  ORDER BY ETO_OFR_ID DESC 
                ) eto1 ) temp where RNUM between :start1 and :last "; 
             }else{
                 $sql = "select temp.* from (
                select eto1.*, ROW_NUMber() over (order by ETO_OFR_ID DESC)AS RNUM from (
                SELECT eto.* from (
                Select 
                    'E' OFR_STATUS,ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
                    ETO_OFR_DESC,FK_GLUSR_USR_ID,
                    GLUSR_USR_APPROV,ETO_OFR_APPROV,
                    (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=ETO_OFR_EXPIRED.FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                    GLCAT_CAT_NAME,
                    (CASE 
                            WHEN ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN'  THEN 'FOREIGN' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
                              ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                    (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                    ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME ,
                    (case when FK_GL_MODULE_ID='FENQ' THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                    3 TABLE_TYP,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG 
                from 
                    ETO_OFR_EXPIRED join $mcat_table on ETO_OFR_DISPLAY_ID=FK_ETO_OFR_ID 
                    join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                    left outer join GLCAT_CAT on ETO_OFR_EXPIRED.FK_GLCAT_CAT_ID=GLCAT_CAT.GLCAT_CAT_ID 
                    left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                    where $whereCond_expired  
                ) eto  ORDER BY ETO_OFR_ID DESC 
                ) eto1 ) temp where RNUM between :start1 and :last "; 
             }
        }elseif(isset($_REQUEST['EXPDELLEAD']) && $_REQUEST['EXPDELLEAD']=='EXPLEAD'){
			    $sql = "
			      select temp.* from (
				      select eto1.*, ROW_NUMber() over (order by ETO_OFR_ID DESC)AS RNUM from (
				      SELECT eto.* from (
				      
				      Select 
					  'E' OFR_STATUS, ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,
                                          TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE, ETO_OFR_DESC,FK_GLUSR_USR_ID,
                                          GLUSR_USR_APPROV,
                                          ETO_OFR_APPROV,
                                          (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                                          GLCAT_CAT_NAME,
                                        (CASE 
                                          WHEN ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN'  THEN 'FOREIGN' 
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
                                          ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                                            (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                                            ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,
                                            (case when FK_GL_MODULE_ID='FENQ' THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                                            3 TABLE_TYP,
                                            TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                                            TO_CHAR(ETO_OFR_APPROV_DATE_ORIG, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG  
				      from 
					 ETO_OFR_EXPIRED  
                                        join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                                        left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                                        left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID
					where  $whereCond_expired  
				    ) eto  ORDER BY ETO_OFR_ID DESC 
				      ) eto1 ) temp where RNUM between :start1 and :last 
				";
			  }
	else if(isset($_REQUEST['EXPDELLEAD']) && $_REQUEST['EXPDELLEAD']=='DELLEAD')
			  {
			  $sql = "select temp.* from (
                select eto1.*, ROW_NUMber() over (order by ETO_OFR_ID DESC)AS RNUM from (
                SELECT eto.* from (
             
                    Select 
                         'D' OFR_STATUS, ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE, ETO_OFR_DESC,
                         FK_GLUSR_USR_ID,
                         GLUSR_USR_APPROV,ETO_OFR_APPROV,
                         (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                          GLCAT_CAT_NAME,
                          (CASE 
                        WHEN ETO_OFR_TEMP_DEL.FK_GL_COUNTRY_ISO <> 'IN'  THEN 'FOREIGN' 
                        WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                        WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                        WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                        WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                        WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                        WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
                        ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                        (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID ) ETO_LEAP_VENDOR_NAME,
                        ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,'DIRECT' AS SOURCE,
                        3 TABLE_TYP,
                        TO_CHAR(ETO_OFR_DELETIONDATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                        TO_CHAR(ETO_OFR_DELETIONDATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG  
                    from 
                        ETO_OFR_TEMP_DEL
                        join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                        left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                        left outer join GL_EMP on ETO_OFR_DELETEDBYID = GL_EMP_ID
                        where $whereCond_del   
                UNION ALL 
                Select  'D'  OFR_STATUS ,
			    DIR_QUERY_FREE_REFID ETO_OFR_ID,
			    NULL ETO_OFR_TYP,
			    NULL ETO_OFR_TITLE,
			    TO_CHAR(DATE_R,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
			    MESSAGE ETO_FOR_DESC,
			    FK_GLUSR_USR_ID,
			    GLUSR_USR_APPROV,
			    NULL ETO_OFR_APPROV,			    
			    (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=DIR_QUERY_MCATID) GLCAT_MCAT_NAME,
			   (SELECT GLCAT_CAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=DIR_QUERY_CATID) ETO_OFR_GLCAT_CAT_NAME, (CASE 
                                  WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 'FOREIGN'
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
				  WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST'
				  ELSE 'Must Call' END) POOL_TYPE,QUERY_MODID FK_GL_MODULE_ID,
                            (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID ) ETO_LEAP_VENDOR_NAME,
                            FENQ_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,'FENQ' AS SOURCE,
                            3 TABLE_TYP,
                            TO_CHAR(ETO_OFR_FENQ_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                            TO_CHAR(ETO_OFR_FENQ_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG 
                from 
                    eto_ofr_from_fenq 
                    join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                    left outer join GLCAT_CAT on DIR_QUERY_CATID=GLCAT_CAT_ID 
                    left outer join GL_EMP on ETO_OFR_FENQ_EMP_ID = GL_EMP_ID                    
                    where FK_ETO_OFR_ID is null
                    and $whereCond_fenq                   
                ) eto  ORDER BY ETO_OFR_ID DESC 
                ) eto1 ) temp where RNUM between :start1 and :last ";    
        }else if($status=='W'){
                    $sql = "select temp.* from (
                select eto1.*, ROW_NUMber() over (order by ETO_OFR_ID DESC)AS RNUM from (
                SELECT eto.* from (
                Select  
                        'W' OFR_STATUS,ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,SUBJECT ETO_OFR_TITLE,TO_CHAR(DATE_R,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
                        MESSAGE ETO_FOR_DESC,FK_GLUSR_USR_ID,GLUSR_USR_APPROV,ETO_OFR_APPROV,
                         (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=DIR_QUERY_MCATID) GLCAT_MCAT_NAME,
                        ETO_OFR_GLCAT_CAT_NAME,
               (CASE 
                                  WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 'FOREIGN'
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
				  WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST'
				  ELSE 'Must Call' END) POOL_TYPE,
                                  (CASE WHEN DIR_QUERY_FREE_BL_TYP=2 THEN 'FENQ - '||QUERY_MODID ELSE QUERY_MODID END) FK_GL_MODULE_ID, 
                                (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                                ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL,GL_EMP_NAME ,(CASE WHEN DIR_QUERY_FREE_BL_TYP=2 THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                                CASE WHEN DIR_QUERY_FREE_BL_TYP = 1 THEN 1 ELSE 2 END TABLE_TYP,
                                TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                                TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG  
                from DIR_QUERY_FREE 
                          join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                             left outer join GLCAT_CAT on DIR_QUERY_CATID=GLCAT_CAT_ID 
                             left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                    where DIR_QUERY_FREE_BL_TYP IN (1,2) and $whereDirCond  
                ) eto  ORDER BY ETO_OFR_ID DESC 
                ) eto1 )temp where RNUM between :start1 and :last ";            
	}elseif(isset($_REQUEST['do']) && $_REQUEST['do']=='livelead'){
	$sql = "select temp.* from (
                select eto1.*, ROW_NUMber() over (order by ETO_OFR_ID DESC)AS RNUM from (
                SELECT eto.* from (
                Select 
                    ETO_OFR_APPROV OFR_STATUS,ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
                    ETO_OFR_DESC,FK_GLUSR_USR_ID,
                    GLUSR_USR_COMPANYNAME,GLUSR_USR_APPROV,ETO_OFR_GL_COUNTRY_NAME AS GL_COUNTRY_NAME,ETO_OFR_APPROV,
                    (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                    GLCAT_CAT_NAME,
                    (CASE 
                            WHEN ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN'  THEN 'FOREIGN' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
                              ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                    (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                    ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME ,
                    (case when FK_GL_MODULE_ID='FENQ' THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                    3 TABLE_TYP,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG 
                from 
                     ETO_OFR 
                    join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                    left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                    left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                    where $whereCond  
                ) eto  ORDER BY ETO_OFR_ID DESC 
                ) eto1 ) temp where RNUM between :start1 and :last "; 
            
        }        
        else	{		 
        $sql = "select temp.* from (
                select eto1.*, ROW_NUMber() over (order by ETO_OFR_ID DESC)AS RNUM from (
                SELECT eto.* from (
                Select 
                   ETO_OFR_APPROV OFR_STATUS,ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,ETO_OFR_DESC,
                   FK_GLUSR_USR_ID,
                    GLUSR_USR_APPROV,ETO_OFR_APPROV,
                    (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=ETO_OFR.FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                    GLCAT_CAT_NAME,
                    (CASE 
                                  WHEN ETO_OFR.FK_GL_COUNTRY_ISO <> 'IN' THEN 'FOREIGN' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (13,15) THEN 'PROCMART'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'SERVICE-Must'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                    (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                    ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME ,
                    (case when FK_GL_MODULE_ID='FENQ' THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                    3 TABLE_TYP,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG  
                FROM  
                            ETO_OFR 
                            join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                            left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                            left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                    where $whereCond    
                UNION ALL 
                Select 
                    'E' OFR_STATUS, ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE, ETO_OFR_DESC,
                    FK_GLUSR_USR_ID,
                    GLUSR_USR_APPROV,ETO_OFR_APPROV,
                     (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) 
                     GLCAT_MCAT_NAME,
                     GLCAT_CAT_NAME,
                    (CASE 
                                  WHEN ETO_OFR_EXPIRED.FK_GL_COUNTRY_ISO <> 'IN' THEN 'FOREIGN' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (13,15) THEN 'PROCMART'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'SERVICE-Must'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                    (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                    ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,
                    (case when FK_GL_MODULE_ID='FENQ' THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                    3 TABLE_TYP,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                    TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG 
                from 
                   ETO_OFR_EXPIRED  
                    join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                    left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                    left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                    where $whereCond_expired  
                UNION ALL 
                    Select 
                         'D' OFR_STATUS, ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE, ETO_OFR_DESC,
                         FK_GLUSR_USR_ID,
                         GLUSR_USR_APPROV,
                         ETO_OFR_APPROV,
                          (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                         GLCAT_CAT_NAME, 
                         (CASE 
                                  WHEN ETO_OFR_TEMP_DEL.FK_GL_COUNTRY_ISO <> 'IN' THEN 'FOREIGN' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (13,15) THEN 'PROCMART'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'SERVICE-Must'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                                (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID ) ETO_LEAP_VENDOR_NAME,
                                ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,'DIRECT' AS SOURCE,
                                3 TABLE_TYP,
                                TO_CHAR(ETO_OFR_DELETIONDATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                                TO_CHAR(ETO_OFR_DELETIONDATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG  
                   from ETO_OFR_TEMP_DEL
                        join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                            left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                            left outer join GL_EMP on ETO_OFR_DELETEDBYID = GL_EMP_ID  
                        where $whereCond_del         
                UNION 
                Select  
                        'W' OFR_STATUS,ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,SUBJECT ETO_OFR_TITLE,TO_CHAR(DATE_R,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
                        MESSAGE ETO_FOR_DESC,FK_GLUSR_USR_ID,GLUSR_USR_APPROV,ETO_OFR_APPROV,
                         (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=DIR_QUERY_MCATID) GLCAT_MCAT_NAME,
                        ETO_OFR_GLCAT_CAT_NAME,
               (CASE 
                                  WHEN S_COUNTRY_UPPER NOT IN ('INDIA','IN') THEN 'FOREIGN'
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
				  WHEN S_COUNTRY_UPPER IN ('INDIA','IN') AND coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST'
				  ELSE 'Must Call' END) POOL_TYPE,
                                  (CASE WHEN DIR_QUERY_FREE_BL_TYP=2 THEN 'FENQ - '||QUERY_MODID ELSE QUERY_MODID END) FK_GL_MODULE_ID, 
                                (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                                ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL,GL_EMP_NAME ,(CASE WHEN DIR_QUERY_FREE_BL_TYP=2 THEN 'FENQ' ELSE 'DIRECT' END) AS SOURCE,
                                CASE WHEN DIR_QUERY_FREE_BL_TYP = 1 THEN 1 ELSE 2 END TABLE_TYP,
                                TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                                TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG  
                from DIR_QUERY_FREE 
                          join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                             left outer join GLCAT_CAT on DIR_QUERY_CATID=GLCAT_CAT_ID 
                             left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                    where DIR_QUERY_FREE_BL_TYP IN (1,2) and $whereDirCond     
                UNION
                Select  'D' OFR_STATUS ,
			    DIR_QUERY_FREE_REFID ETO_OFR_ID,
			    NULL ETO_OFR_TYP,
			    NULL ETO_OFR_TITLE,
			    TO_CHAR(DATE_R,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
			    MESSAGE ETO_FOR_DESC,
			    FK_GLUSR_USR_ID,
			    GLUSR_USR_APPROV,    
			    NULL ETO_OFR_APPROV,			    
			    (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=DIR_QUERY_MCATID) GLCAT_MCAT_NAME,
			    (SELECT GLCAT_CAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=DIR_QUERY_CATID) ETO_OFR_GLCAT_CAT_NAME,                            
                            (CASE 
                                  WHEN S_COUNTRY_UPPER <> 'IN'  THEN 'FOREIGN' 
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                                  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
				  WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
				  ELSE 'Must Call' END) POOL_TYPE,QUERY_MODID FK_GL_MODULE_ID,
                            (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID ) ETO_LEAP_VENDOR_NAME,
                            FENQ_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,'FENQ' AS SOURCE,
                            3 TABLE_TYP,
                            TO_CHAR(ETO_OFR_FENQ_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE,
                            TO_CHAR(ETO_OFR_FENQ_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE_ORIG 
                from 
                    eto_ofr_from_fenq 
                    join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                    left join GLCAT_CAT on DIR_QUERY_CATID = GLCAT_CAT_ID 
                    left join GL_EMP on ETO_OFR_FENQ_EMP_ID = GL_EMP_ID 
                WHERE  FK_ETO_OFR_ID IS NULL
                    and $whereCond_fenq                   
                ) eto  ORDER BY ETO_OFR_ID DESC 
                ) eto1 )temp where RNUM between :start1 and :last ";      
         }     
             
            $rec = array();
            print_r($sql);
            $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,$bindParam);    
       while($recResult = $sth->read()){                
                array_push($rec,array_change_key_case($recResult, CASE_UPPER)); 
		}

        $recordingUrl='';
        for($i=0;$i<count($rec);$i++){
            if(isset($rec[$i]['CALL_RECORDING_URL']) && $rec[$i]['CALL_RECORDING_URL']!=''){
                $rec[$i]['CALL_RECORDING_URL']=$this->generateSignedURLAWS($rec[$i]['CALL_RECORDING_URL']);
           }
        }
	if(!empty($offer))
	  {
	  $result_type='Offer_Found';
	  }
	//echo $sql;print_r($recResult);//die;
        $totalRows=count($rec);        
      
   	$totalPages= $totalOffers / $offersPerPage;
      if (($totalOffers % $offersPerPage) > 0) {
         $totalPages = intval(++$totalPages);
      } else {
         $totalPages = intval($totalPages);
      }

      $curPage = $start/$offersPerPage;
      $curPage = intval(++$curPage);
  }
     return array(
			'flagError' => $flagError,
			'errArr' => $errArr,
			'rec'=> $rec,
			'totalOffers' => $totalOffers,
			'totalRows' => $totalRows,
			'offersPerPage' => $offersPerPage,
			'critHash' => $critHash,
			'start' => $start,
			'curPage' => $curPage,
			'status' => 'ALL',
			'totalPages' => $totalPages,
			'last' => $last,
			'result_type'=>$result_type
		);
	}
  
public function showAdvSearchResultFenqPG($request) {
 	$conn_obj=new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
        }
        $model= new GlobalmodelForm();
        $critHash['memmail']=$memmail = $request->getParam('memmail','');	
        $critHash['mem']=$mem = $request->getParam('mem','');  
        $critHash['offer']=$offer = $request->getParam('offer',0);
  	    $critHash['memmobile']=$memmobile = $request->getParam('memmobile','');
        $critHash['ph_country']=$ph_country = $request->getParam('ph_country','');
        $critHash['status']=$status = $request->getParam('status','D');  
	    $memmail = $request->getParam('memmail','');
        $bindParam=$rec=array();
        $whereCond_expired='';
        if($status=='E'){
                    if(!empty($offer)){
                           $whereCond_expired= "  ETO_OFR_EXPIRED_ARCH.ETO_OFR_DISPLAY_ID=:offer"; 
                           $bindParam[':offer'] = $offer;
                    }elseif(!empty($mem)){
                        $whereCond_expired= "  ETO_OFR_EXPIRED_ARCH.FK_GLUSR_USR_ID=:mem"; 
                        $bindParam[':mem'] = $mem;
                    }elseif(!empty($memmail)){
                               $whereCond_expired= "  GLUSR_USR.GLUSR_USR_EMAIL=:memmail";
                               $bindParam[':memmail'] = $memmail;     
                    }elseif(!empty($memmobile)){
                        if($ph_country=='IN')
                        {
                            $whereCond_expired="  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91'";  
                            $bindParam[':memmobile'] = $memmobile;
                        }
                        else
                        {
                            $whereCond_expired= "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY<>'91'";  
                            $bindParam[':memmobile'] =$memmobile;
                        }
                    } 

                   
                  if($whereCond_expired<>''){
                        $sql = "Select 
                                        'E' OFR_STATUS, ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE, ETO_OFR_DESC,FK_GLUSR_USR_ID,
                                        GLUSR_USR_APPROV,
                                        ETO_OFR_APPROV,
                                         (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME,
                                        
                                        GLCAT_CAT_NAME, 
                                        (CASE 
                                          WHEN ETO_OFR_EXPIRED_ARCH.FK_GL_COUNTRY_ISO <> 'IN'  THEN 'FOREIGN' 
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                                          WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
                                            ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                                        (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_APPROV_BY_ORIG ) ETO_LEAP_VENDOR_NAME,
                                        ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL,
                                        GL_EMP_NAME,'DIRECT' AS SOURCE,
                                        3 TABLE_TYP,
                                        TO_CHAR(ETO_OFR_APPROV_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE   
                                   from 
                                    ETO_OFR_EXPIRED_ARCH  
                                     join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                                     left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                                     left outer join GL_EMP on ETO_OFR_APPROV_BY_ORIG = GL_EMP_ID 
                                    where 
                                       $whereCond_expired               
                               ORDER BY ETO_OFR_ID DESC";
                      $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,$bindParam);
                      while($recResult = $sth->read()){
                            array_push($rec,array_change_key_case($recResult, CASE_UPPER)); 
                        }

            }
            }
            else{
                    if(!empty($offer)){
                           $whereCond_del= "  ETO_OFR_TEMP_DEL_ARCH.ETO_OFR_DISPLAY_ID=:offer";  
                           $whereCond_fenq = " and ETO_OFR_FROM_FENQ_ARCH.DIR_QUERY_FREE_REFID=:offer"; 
                           $bindParam[':offer'] = $offer;

                    }elseif(!empty($mem)){
                        $whereCond_del = "  ETO_OFR_TEMP_DEL_ARCH.FK_GLUSR_USR_ID=:mem";  
                        $whereCond_fenq = "AND ETO_OFR_FROM_FENQ_ARCH.FK_GLUSR_USR_ID=:mem";        
                        $bindParam[':mem'] = $mem;
                    }elseif(!empty($memmail)){
                               $whereCond_fenq= " AND GLUSR_USR.GLUSR_USR_EMAIL=:memmail";
                               $whereCond_del= "  GLUSR_USR.GLUSR_USR_EMAIL=:memmail";
                               $bindParam[':memmail'] = $memmail;     
                    }elseif(!empty($memmobile)){
                              if($ph_country=='IN')
                              {
                               $whereCond_fenq= " AND GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91'"; 
                               $whereCond_del= "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91'"; 
                               $bindParam[':memmobile'] = $memmobile;

                          }
                          else
                          {
                               $whereCond_fenq= " AND GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY<>'91'";  
                               $whereCond_del= "  GLUSR_USR.GLUSR_USR_PH_MOBILE=:memmobile AND GLUSR_USR.GLUSR_USR_PH_COUNTRY<>'91'";  
                               $bindParam[':memmobile'] =$memmobile;

                          }
                    } 

                     
                  if($whereCond_del<>''){
                        $sql = "SELECT eto.* from (
                                   Select 
                                        'D' OFR_STATUS, ETO_OFR_DISPLAY_ID ETO_OFR_ID,ETO_OFR_TYP,ETO_OFR_TITLE,TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE, 
                                        ETO_OFR_DESC,FK_GLUSR_USR_ID,
                                        GLUSR_USR_APPROV,
                                        ETO_OFR_APPROV,
                                         (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT 
                                         WHERE GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) GLCAT_MCAT_NAME, 
                                        GLCAT_CAT_NAME, 
                                       (CASE 
                                            WHEN ETO_OFR_TEMP_DEL_ARCH.FK_GL_COUNTRY_ISO <> 'IN' THEN 'FOREIGN' 
                                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC' 
                                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (13,15) THEN 'PROCMART'
                                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'SERVICE-Must'
                                            WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                                            ELSE 'Must Call' END) POOL_TYPE,FK_GL_MODULE_ID,
                                               (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_DELETEDBYID ) ETO_LEAP_VENDOR_NAME,
                                               ETO_OFR_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,'DIRECT' AS SOURCE,
                                               3 TABLE_TYP,
                                               TO_CHAR(ETO_OFR_DELETIONDATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE  
                                        from ETO_OFR_TEMP_DEL_ARCH
                                        join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                                         left outer join GLCAT_CAT on FK_GLCAT_CAT_ID=GLCAT_CAT_ID 
                                         left outer join GL_EMP on ETO_OFR_DELETEDBYID = GL_EMP_ID  
                                     where
                                        $whereCond_del 
                               UNION ALL 
                               Select  'D' OFR_STATUS ,
                                           DIR_QUERY_FREE_REFID ETO_OFR_ID,
                                           NULL ETO_OFR_TYP,
                                           NULL ETO_OFR_TITLE,
                                           TO_CHAR(DATE_R,'DD-Mon-yyyy HH:MI:SS AM') AS OFFER_DATE,
                                           MESSAGE ETO_FOR_DESC,
                                           FK_GLUSR_USR_ID,
                                           GLUSR_USR_APPROV,
                                           NULL ETO_OFR_APPROV,			    
                                           (SELECT concat(GLCAT_MCAT_NAME,(case when GLCAT_MCAT_IS_GENERIC= 1 then '<B> [ PMCAT ]</B>' else '' end ))  FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=DIR_QUERY_MCATID) GLCAT_MCAT_NAME,
                                          (SELECT GLCAT_CAT_NAME FROM GLCAT_CAT WHERE GLCAT_CAT_ID=DIR_QUERY_CATID) ETO_OFR_GLCAT_CAT_NAME,                            
                                          (CASE 
                                                 WHEN S_COUNTRY_UPPER <> 'IN'  THEN 'FOREIGN' 
                                                 WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (90,91) THEN 'Service-DNC'  
                                                 WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,5,6,19,21,80,81,82,83,84,85,86,87,88,89,92,93,94,95,96,97,98,99) THEN 'DNC' 
                                                 WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(13,15) THEN 'PROCMART'
                                                 WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59) THEN 'Must Call' 
                                                 WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN(17,18,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)  THEN 'Intent'
                                                 WHEN coalesce(USER_IDENTIFIER_FLAG,0) IN (11,12) THEN 'Service-MUST' 
                                                 ELSE 'Must Call' END) POOL_TYPE,QUERY_MODID FK_GL_MODULE_ID,
                                           (SELECT ETO_LEAP_VENDOR_NAME FROM eto_leap_mis WHERE  ETO_LEAP_EMP_ID = ETO_OFR_FENQ_EMP_ID ) ETO_LEAP_VENDOR_NAME,
                                           FENQ_CALL_RECORDING_URL CALL_RECORDING_URL, GL_EMP_NAME,'FENQ' AS SOURCE,
                                           3 TABLE_TYP,
                                           TO_CHAR(ETO_OFR_FENQ_DATE, 'DD-Mon-yyyy HH:MI:SS AM') APPROV_DATE   
                               from 
                                        eto_ofr_from_fenq_arch 
                                        join GLUSR_USR on FK_GLUSR_USR_ID=GLUSR_USR_ID 
                                        left join GLCAT_CAT on DIR_QUERY_CATID = GLCAT_CAT_ID 
                                        left join GL_EMP on ETO_OFR_FENQ_EMP_ID = GL_EMP_ID 
                                    WHERE  FK_ETO_OFR_ID IS NULL
                                     $whereCond_fenq                 
                               ) eto  ORDER BY ETO_OFR_ID DESC";     

                      $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,$bindParam);
                       while($recResult = $sth->read()){
                       array_push($rec,array_change_key_case($recResult, CASE_UPPER)); 
                        }
     
            }
        }
    
        return array(			
                'rec'=> $rec			
        );
	}
    public function generateSignedURLAWS($fileUrl,$bucketName="leapcallrecords",$expiry="+24 hour")
    {
     //Final Url to Return
    $signedUrl="";
  
   if($fileUrl == "" || strpos(strtolower($fileUrl),$bucketName)===FALSE)
   {
   return $fileUrl;
    }
  
   if(strpos(strtolower($fileUrl),$bucketName)!==FALSE)
    {
      $fileUrl = substr($fileUrl,strpos(strtolower($fileUrl),$bucketName)+strlen($bucketName)+1);
    }
  
          //The AWS inbuilt class configuration
              $client = new Aws\S3\S3Client([
                 'version'     => 'latest',
                 'region'      => 'ap-south-1',
                 'credentials' => [
              'key'      => 'AKIAWRA3N7CHVOMW3XGY',
                 'secret'   => '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',
              ]
          ]);
  
         //The AWS inbuilt class command method configuration 
             $cmd = $client->getCommand('GetObject', [
            'Bucket' => 'leapcallrecords',
             'Key'    => $fileUrl
          ]);
  
      //The AWS inbuilt PresignedRequest method invocation 
      $signedUrlObj = $client->createPresignedRequest($cmd, $expiry);
  
     //Fetching of signed url
     $signedUrl = $signedUrlObj->getUri();
      return $signedUrl;
      }

}