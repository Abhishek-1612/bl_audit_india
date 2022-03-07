<?php

class DncdailyReport extends CFormModel
{
   
	public function getData($request)
	{
		$model = new GlobalmodelForm();
                $conn_obj=new Globalconnection();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
                }
		$start_date=$request->getParam('start_date','');
		$end_date=$request->getParam('start_date','');
                $rtype=$request->getParam('rtype','');

		$recData=array();	
                if($rtype=='gen'){
$sql="SELECT COUNT(1),'Generation - ' || POOL AS POOL 
FROM
(
SELECT ETO_OFR_DISPLAY_ID,
CASE
WHEN (upper(fk_gl_country_iso) <> 'INDIA'
AND upper(fk_gl_country_iso) <> 'IN')
THEN 'DNC_FOREIGN'
WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
THEN 'CONNECT'
ELSE 'DNC'
END POOL,
CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
FK_GL_MODULE_ID MODID,
USER_IDENTIFIER_FLAG
FROM ETO_OFR
WHERE DATE(eto_ofr_postdate_orig) between TO_DATE('$start_date', 'DD-MON-YYYY') AND TO_DATE('$end_date', 'DD-MON-YYYY') 
UNION ALL
SELECT ETO_OFR_DISPLAY_ID,
CASE
WHEN (upper(fk_gl_country_iso) <> 'INDIA'
AND upper(fk_gl_country_iso) <> 'IN')
THEN 'DNC_FOREIGN'
WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
THEN 'CONNECT'
ELSE 'DNC'
END POOL,
CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
FK_GL_MODULE_ID MODID,
USER_IDENTIFIER_FLAG
FROM ETO_OFR_EXPIRED
WHERE ETO_OFR_POSTDATE_ORIG BETWEEN TO_DATE('$start_date', 'DD-MON-YYYY')AND TO_DATE('$end_date', 'DD-MON-YYYY')
UNION ALL
SELECT ETO_OFR_DISPLAY_ID,
CASE
WHEN (upper(fk_gl_country_iso) <> 'INDIA'
AND upper(fk_gl_country_iso) <> 'IN')
THEN 'DNC_FOREIGN'
WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
THEN 'CONNECT'
ELSE 'DNC'
END POOL,
CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
FK_GL_MODULE_ID MODID,
USER_IDENTIFIER_FLAG
FROM ETO_OFR_TEMP_DEL
WHERE ETO_OFR_POSTDATE_ORIG >= TO_DATE('$start_date', 'DD-MON-YYYY') AND ETO_OFR_POSTDATE_ORIG<TO_DATE('$end_date', 'DD-MON-YYYY')
+1
UNION ALL
SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,
CASE
WHEN (upper(s_country_upper) <> 'INDIA'
AND upper(s_country_upper) <> 'IN')
THEN 'DNC_FOREIGN'
WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
THEN 'CONNECT'
ELSE 'DNC'
END POOL,
CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
QUERY_MODID MODID,
USER_IDENTIFIER_FLAG
FROM ETO_OFR_FROM_FENQ
WHERE FK_ETO_OFR_ID IS NULL AND DATE(DATE_R) BETWEEN TO_DATE('$start_date', 'DD-MON-YYYY')AND TO_DATE('$end_date', 'DD-MON-YYYY') 
UNION ALL
SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,
CASE
WHEN (upper(s_country_upper) <> 'INDIA'
AND upper(s_country_upper)   <> 'IN')
THEN 'DNC_FOREIGN'
WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
THEN 'CONNECT'
ELSE 'DNC'
END POOL,
CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
QUERY_MODID MODID,
USER_IDENTIFIER_FLAG
FROM ETO_OFR_FROM_FENQ_ARCH
WHERE FK_ETO_OFR_ID IS NULL  AND  DATE(DATE_R) BETWEEN TO_DATE('$start_date', 'DD-MON-YYYY')AND TO_DATE('$end_date', 'DD-MON-YYYY') 
UNION ALL
SELECT ETO_OFR_DISPLAY_ID,
CASE
WHEN (upper(s_country_upper) <> 'INDIA'
AND upper(s_country_upper) <> 'IN')
THEN 'DNC_FOREIGN'
WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
THEN 'CONNECT'
ELSE 'DNC'
END POOL,
DATE(DATE_R) APP_DATE,
CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
QUERY_MODID MODID,
USER_IDENTIFIER_FLAG
FROM DIR_QUERY_FREE
WHERE DATE(DATE_R) BETWEEN TO_DATE('$start_date', 'DD-MON-YYYY')AND TO_DATE('$end_date', 'DD-MON-YYYY')
) TAB
where POOL IN ('DNC_FOREIGN','DNC')
GROUP BY POOL
ORDER BY POOL"; 
     
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
                while($recResult = $sth->read()){   // print_r($recResult);//die; 
                    array_push($recData,$recResult); 
		}
}else{                
$sql_app="SELECT COUNT(1), 'Approval - ' || POOL  AS POOL
                        FROM
                                (SELECT ETO_OFR_DISPLAY_ID,
                                USER_IDENTIFIER_FLAG,
                                FK_GL_MODULE_ID MODID,
                                CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
                                CASE
                                WHEN (upper(fk_gl_country_iso) <> 'INDIA'
                                AND upper(fk_gl_country_iso) <> 'IN')
                                THEN 'DNC_FOREIGN'
                                WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
                                THEN 'CONNECT'
                                ELSE 'DNC'
                                END POOL
                                FROM ETO_OFR
                                WHERE DATE(ETO_OFR_APPROV_DATE_ORIG) BETWEEN TO_DATE('$start_date', 'DD-MON-YYYY')AND TO_DATE('$end_date', 'DD-MON-YYYY')
                                UNION ALL
                                SELECT ETO_OFR_DISPLAY_ID,
                                USER_IDENTIFIER_FLAG,
                                FK_GL_MODULE_ID MODID,
                                CASE
WHEN RAG_SCORE_TOTAL = 1001
THEN 'RED_NEW'
WHEN RAG_SCORE_TOTAL = 1002
THEN 'ORANGE'
WHEN RAG_SCORE_TOTAL = 1003
THEN 'YELLOW'
WHEN RAG_SCORE_TOTAL = 1004
THEN 'GREEN_NEW'
WHEN COALESCE(RAG_SCORE_TOTAL,0) IN (1005,0)
THEN 'BLUE'
END RAG,
                                CASE
                                WHEN (upper(fk_gl_country_iso) <> 'INDIA'
                                AND upper(fk_gl_country_iso) <> 'IN')
                                THEN 'DNC_FOREIGN'
                                WHEN COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,11,12,20,24,27,28,26,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,98)
                                THEN 'CONNECT'
                                ELSE 'DNC'
                                END POOL
                                FROM ETO_OFR_EXPIRED
                                WHERE DATE(ETO_OFR_APPROV_DATE_ORIG) BETWEEN TO_DATE('$start_date', 'DD-MON-YYYY')AND TO_DATE('$end_date', 'DD-MON-YYYY') 
                                )TAB
             where POOL IN ('DNC_FOREIGN','DNC')
                        GROUP BY POOL                              
                        ORDER BY POOL";                
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_app,array());
               // echo $sql;
                while($recResult = $sth->read()){   // print_r($recResult);//die; 
                    array_push($recData,$recResult); 
		}
}
                return $recData;
	}
  
}   