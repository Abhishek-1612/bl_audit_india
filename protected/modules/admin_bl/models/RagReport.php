<?php

class RagReport extends CFormModel
{
   
	public function RagData($request)
	{
		$model = new GlobalmodelForm();
		$obj_conn = new Globalconnection(); 	
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                    {
                        $dbh = $obj_conn->connect_db_yii('postgress_web68v');   
                    }else{
                        $dbh = $obj_conn->connect_db_yii('postgress_web68v'); 
                    }		$data=$request->getParam('data','');
		$type=$request->getParam('type','');
		$sqlcond2='';
		$start_date=$request->getParam('start_date','');
		$end_date=$request->getParam('end_date','');
		$source=$request->getParam('source','');
		$pool=$request->getParam('pool','');
			if($pool == 'DNC')
			{	
				$sqlcond2 .= " AND COALESCE(USER_IDENTIFIER_FLAG,0) IN (2,3,5,6,7,8,9,10,14,16,19,21,22,23)";
			}
			elseif($pool == 'MUSTCALL')
			{
				$sqlcond2 .= " AND COALESCE(USER_IDENTIFIER_FLAG,0) IN (0,1,20,24,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59)";
			}
			elseif($pool == 'INTENT')
			{
				$sqlcond2 .= " AND COALESCE(USER_IDENTIFIER_FLAG,0) IN (17,18,19,20,23,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79)";
			}
		if($data =='generation')
		{
				$sql="SELECT TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') ETO_OFR_POSTDATE_ORIG,
                                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(1,4,7,31,21,11) THEN 1 ELSE NULL END )) RED,
                                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(2,5,8) THEN 1 ELSE NULL END )) AMBER,
                                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(3,6,9,34,24,14) THEN 1 ELSE NULL END )) GREEN,
                                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(12,22,32) THEN 1 ELSE NULL END )) ORANGE,
                                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(13,23,33) THEN 1 ELSE NULL END )) YELLOW,
                                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(15,25,35) THEN 1 ELSE NULL END )) BLUE,
                                        COUNT(1) TOTAL 
                                        FROM
                                        (
                                        SELECT 1
                                        BL_TYPE,ETO_OFR_DISPLAY_ID,
                                        ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,
                                        FK_GL_MODULE_ID,date(ETO_OFR_POSTDATE_ORIG) ETO_OFR_POSTDATE_ORIG,ETO_OFR_APPROV_DATE_ORIG,
                                        FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                                        RAG_SCORE_TOTAL 

                                        FROM ETO_OFR
                                        WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN
                                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND FK_GL_MODULE_ID<>'FENQ' AND
                                        RAG_SCORE_TOTAL IS NOT NULL 
                                       $sqlcond2
                                        UNION
                                        SELECT 1
                                        BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,
                                        FK_GL_MODULE_ID,date(ETO_OFR_POSTDATE_ORIG) ETO_OFR_POSTDATE_ORIG,ETO_OFR_APPROV_DATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                                        RAG_SCORE_TOTAL 
                                        FROM ETO_OFR_EXPIRED
                                        WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN
                                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND FK_GL_MODULE_ID<>'FENQ' AND
                                        RAG_SCORE_TOTAL IS NOT NULL 
                                       $sqlcond2 
                                        UNION
                                        SELECT 2
                                        BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,
                                        QUERY_MODID FK_GL_MODULE_ID,date(DATE_R) ETO_OFR_POSTDATE_ORIG,NULL
                                        ETO_OFR_APPROV_DATE_ORIG, S_COUNTRY_UPPER,
                                        RAG_SCORE_TOTAL 
                                        FROM DIR_QUERY_FREE WHERE date(DATE_R) BETWEEN
                                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND RAG_SCORE_TOTAL IS NOT NULL 
                                       $sqlcond2 
                                        UNION
                                        SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL
                                        ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID
                                        FK_GL_MODULE_ID,date(DATE_R) ETO_OFR_POSTDATE_ORIG, ETO_OFR_FENQ_DATE
                                        ETO_OFR_APPROV_DATE_ORIG ,S_COUNTRY_UPPER,
                                        RAG_SCORE_TOTAL
                                        FROM
                                        ETO_OFR_FROM_FENQ WHERE date(DATE_R) BETWEEN
                                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND RAG_SCORE_TOTAL IS NOT NULL 
                                        $sqlcond2 
                                        UNION 
                                        SELECT 2
                                        BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG
                                        ,FK_GL_MODULE_ID ,date(ETO_OFR_POSTDATE_ORIG) ETO_OFR_POSTDATE_ORIG,ETO_OFR_DELETIONDATE
                                        ETO_OFR_APPROV_DATE_ORIG, FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                                        RAG_SCORE_TOTAL 
                                        FROM ETO_OFR_TEMP_DEL WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN
                                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND FK_GL_MODULE_ID<>'FENQ' AND
                                        RAG_SCORE_TOTAL IS NOT NULL 
                                        $sqlcond2 
                                        UNION
                                        SELECT 2 BL_TYPE,DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID,NULL
                                        ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,QUERY_MODID
                                        FK_GL_MODULE_ID,date(DATE_R) ETO_OFR_POSTDATE_ORIG, ETO_OFR_FENQ_DATE
                                        ETO_OFR_APPROV_DATE_ORIG ,S_COUNTRY_UPPER,
                                        RAG_SCORE_TOTAL 
                                        FROM
                                        ETO_OFR_FROM_FENQ_ARCH WHERE date(DATE_R) BETWEEN
                                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND RAG_SCORE_TOTAL IS NOT NULL 
                                        $sqlcond2 
                                        UNION
                                        SELECT 2
                                        BL_TYPE,ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG
                                        ,FK_GL_MODULE_ID ,date(ETO_OFR_POSTDATE_ORIG) ETO_OFR_POSTDATE_ORIG, ETO_OFR_DELETIONDATE
                                        ETO_OFR_APPROV_DATE_ORIG,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                                        RAG_SCORE_TOTAL 
                                        FROM ETO_OFR_TEMP_DEL_ARCH WHERE date(ETO_OFR_POSTDATE_ORIG) BETWEEN TO_DATE(:START_DATE,'DD-MON-YYYY') 
                                        AND TO_DATE(:END_DATE,'DD-MON-YYYY') 
                                        AND FK_GL_MODULE_ID<>'FENQ' AND
                                        RAG_SCORE_TOTAL IS NOT NULL 
                                        $sqlcond2 
                                        ) A 
                                        GROUP BY ETO_OFR_POSTDATE_ORIG ORDER BY ETO_OFR_POSTDATE_ORIG ASC";
				
			
		}
		elseif($data =='approval')
		{
			  
			$sql="SELECT TO_CHAR(ETO_OFR_APPROV_DATE_ORIG,'DD-Mon-YYYY') ETO_OFR_APPROV_DATE_ORIG,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(1,4,7,31,21,11) THEN 1 ELSE NULL END )) RED,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(2,5,8) THEN 1 ELSE NULL END )) AMBER,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(3,6,9,34,24,14) THEN 1 ELSE NULL END )) GREEN,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(12,22,32) THEN 1 ELSE NULL END )) ORANGE,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(13,23,33) THEN 1 ELSE NULL END )) YELLOW,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(15,25,35) THEN 1 ELSE NULL END )) BLUE,
                        COUNT(1) TOTAL 
                        FROM
                        (
                        SELECT
                        ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                        RAG_SCORE_TOTAL,date(ETO_OFR_APPROV_DATE_ORIG) ETO_OFR_APPROV_DATE_ORIG 
                        FROM ETO_OFR
                        WHERE date(ETO_OFR_APPROV_DATE_ORIG) BETWEEN
                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND TO_DATE(:END_DATE,'DD-MON-YYYY') AND ETO_OFR_APPROV='A' AND
                        RAG_SCORE_TOTAL IS NOT NULL 
                        $sqlcond2 
                        UNION
                        SELECT
                        ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                        RAG_SCORE_TOTAL,date(ETO_OFR_APPROV_DATE_ORIG)  ETO_OFR_APPROV_DATE_ORIG 
                        FROM ETO_OFR_EXPIRED
                        WHERE date(ETO_OFR_APPROV_DATE_ORIG) BETWEEN
                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND ETO_OFR_APPROV='A' AND  RAG_SCORE_TOTAL IS NOT NULL 
                        $sqlcond2 
                        ) A 
                        GROUP BY ETO_OFR_APPROV_DATE_ORIG ORDER BY ETO_OFR_APPROV_DATE_ORIG ASC";
			
		}
                elseif($data =='deletion')
		{
			  
			$sql="SELECT TO_CHAR(DATE_R,'DD-Mon-YYYY') DATE_R,
                            COUNT((CASE WHEN RAG_SCORE_TOTAL IN(1,4,7,31,21,11) THEN 1 ELSE NULL END )) RED,
                            COUNT((CASE WHEN RAG_SCORE_TOTAL IN(2,5,8) THEN 1 ELSE NULL END )) AMBER,
                            COUNT((CASE WHEN RAG_SCORE_TOTAL IN(3,6,9,34,24,14) THEN 1 ELSE NULL END )) GREEN,
                            COUNT((CASE WHEN RAG_SCORE_TOTAL IN(12,22,32) THEN 1 ELSE NULL END )) ORANGE,
                            COUNT((CASE WHEN RAG_SCORE_TOTAL IN(13,23,33) THEN 1 ELSE NULL END )) YELLOW,
                            COUNT((CASE WHEN RAG_SCORE_TOTAL IN(15,25,35) THEN 1 ELSE NULL END )) BLUE,
                            COUNT(1) TOTAL 
                            FROM
                            (
                            SELECT ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG,
                            RAG_SCORE_TOTAL,date(ETO_OFR_DELETIONDATE) DATE_R 
                            FROM ETO_OFR_TEMP_DEL
                            WHERE date(ETO_OFR_DELETIONDATE)BETWEEN TO_DATE(:START_DATE,
                            'DD-MON-YYYY')AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                             AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG,
                            RAG_SCORE_TOTAL,date(ETO_OFR_DELETIONDATE) DATE_R 
                            FROM ETO_OFR_TEMP_DEL_ARCH
                            WHERE date(ETO_OFR_DELETIONDATE)BETWEEN TO_DATE(:START_DATE,
                            'DD-MON-YYYY')AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG,
                            RAG_SCORE_TOTAL,date(ETO_OFR_FENQ_DATE) DATE_R 
                            FROM ETO_OFR_FROM_FENQ
                            WHERE date(ETO_OFR_FENQ_DATE) BETWEEN TO_DATE(:START_DATE,
                            'DD-MON-YYYY')AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, USER_IDENTIFIER_FLAG,
                            RAG_SCORE_TOTAL,date(ETO_OFR_FENQ_DATE) DATE_R 
                            FROM ETO_OFR_FROM_FENQ_ARCH
                            WHERE date(ETO_OFR_FENQ_DATE) BETWEEN TO_DATE(:START_DATE,
                            'DD-MON-YYYY')AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2
                            ) A 
                            GROUP BY DATE_R ORDER BY DATE_R ASC";

		} 
                elseif($data =='Timeliness')
		{
			  
                        $sql="select TO_CHAR(P_DATE,'DD-Mon-YYYY') P_DATE,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(1,4,7,31,21,11) THEN GEN_COUNT ELSE 0 END )) RED_GEN,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(2,5,8) THEN GEN_COUNT ELSE 0 END )) AMBER_GEN,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(3,6,9,34,24,14) THEN GEN_COUNT ELSE 0 END )) GREEN_GEN,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(12,22,32) THEN GEN_COUNT ELSE 0 END )) ORANGE_GEN,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(13,23,33) THEN GEN_COUNT ELSE 0 END )) YELLOW_GEN,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(15,25,35) THEN GEN_COUNT ELSE 0 END )) BLUE_GEN,

                            sum((CASE WHEN RAG_SCORE_TOTAL IN(1,4,7,31,21,11) THEN APP_DEL ELSE 0 END )) RED_APP,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(2,5,8) THEN APP_DEL ELSE 0 END )) AMBER_APP,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(3,6,9,34,24,14) THEN APP_DEL ELSE 0 END )) GREEN_APP,

                            sum((CASE WHEN RAG_SCORE_TOTAL IN(12,22,32) THEN APP_DEL ELSE 0 END )) ORANGE_APP,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(13,23,33) THEN APP_DEL ELSE 0 END )) YELLOW_APP,
                            sum((CASE WHEN RAG_SCORE_TOTAL IN(15,25,35) THEN APP_DEL ELSE 0 END )) BLUE_APP,
                            sum(GEN_COUNT) TOTAL_GEN ,
                            sum(APP_DEL) TOTAL_APP,
                            ROUND((sum(APP_DEL) /sum(GEN_COUNT))*100,2) TIMELINESS 
                            FROM
                            (
                            select P_DATE,RAG_SCORE_TOTAL, count(1) GEN_COUNT, 
                            sum(case when (ACTION = 4 or ACTION = 5) AND minss <= 15 then 1 else 0 end) APP_DEL,
                            sum(case when ACTION = 5 AND minss <= 15 then 1 else 0 end) APP_CNT,
                            sum(case when ACTION = 4 AND minss <= 15 then 1 else 0 end) DEL_CNT
                            FROM
                            (
                            SELECT to_char(P_DATE, 'HH24') HR,date(P_DATE) P_DATE, RAG_SCORE_TOTAL, ACTION, 
                            (DATE_PART('day', A_DATE::TIMESTAMP - P_DATE::TIMESTAMP) * 24 + 
                            DATE_PART('hour', A_DATE::TIMESTAMP - P_DATE::TIMESTAMP)) * 60 + 
                            DATE_PART('minute', A_DATE::TIMESTAMP - P_DATE::TIMESTAMP) minss 
                            FROM
                            (
                            SELECT ETO_OFR_DISPLAY_ID, RAG_SCORE_TOTAL,
                            ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_APPROV_DATE A_DATE, 5 AS ACTION,
                            FK_GLUSR_USR_ID, USER_IDENTIFIER_FLAG
                            FROM ETO_OFR
                            WHERE date(ETO_OFR_POSTDATE_ORIG)BETWEEN TO_DATE(:START_DATE, 'DD-MON-YYYY')
                            AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND FK_GL_MODULE_ID <> 'FENQ' AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT ETO_OFR_DISPLAY_ID, RAG_SCORE_TOTAL,
                            ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_APPROV_DATE A_DATE, 5 AS ACTION,
                            FK_GLUSR_USR_ID, USER_IDENTIFIER_FLAG
                            FROM ETO_OFR_EXPIRED  
                            WHERE date(ETO_OFR_POSTDATE_ORIG)BETWEEN TO_DATE(:START_DATE, 'DD-MON-YYYY')
                            AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND FK_GL_MODULE_ID <> 'FENQ' AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2
                            UNION
                            SELECT ETO_OFR_DISPLAY_ID, RAG_SCORE_TOTAL,
                            ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_DELETIONDATE A_DATE, 4 AS ACTION,
                            FK_GLUSR_USR_ID, USER_IDENTIFIER_FLAG
                            FROM ETO_OFR_TEMP_DEL
                            WHERE date(ETO_OFR_POSTDATE_ORIG)BETWEEN TO_DATE(:START_DATE, 'DD-MON-YYYY')
                            AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND FK_GL_MODULE_ID <> 'FENQ' AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT ETO_OFR_DISPLAY_ID, RAG_SCORE_TOTAL,
                            ETO_OFR_POSTDATE_ORIG P_DATE, ETO_OFR_DELETIONDATE A_DATE, 4 AS ACTION,
                            FK_GLUSR_USR_ID, USER_IDENTIFIER_FLAG
                            FROM ETO_OFR_TEMP_DEL_ARCH
                            WHERE date(ETO_OFR_POSTDATE_ORIG)BETWEEN TO_DATE(:START_DATE, 'DD-MON-YYYY')
                            AND TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND FK_GL_MODULE_ID <> 'FENQ' AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, RAG_SCORE_TOTAL,
                            DATE_R P_DATE, ETO_OFR_FENQ_DATE A_DATE, (case when fk_eto_ofr_id is null then 4 else 5
                            end) AS ACTION, FK_GLUSR_USR_ID, USER_IDENTIFIER_FLAG
                            FROM ETO_OFR_FROM_FENQ
                            WHERE date(DATE_R)BETWEEN TO_DATE(:START_DATE, 'DD-MON-YYYY') AND
                            TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT DIR_QUERY_FREE_REFID ETO_OFR_DISPLAY_ID, RAG_SCORE_TOTAL,
                            DATE_R P_DATE, ETO_OFR_FENQ_DATE A_DATE, (case when fk_eto_ofr_id is null then 4 else 5
                            end) AS ACTION, FK_GLUSR_USR_ID, USER_IDENTIFIER_FLAG
                            FROM ETO_OFR_FROM_FENQ_ARCH
                            WHERE date(DATE_R)BETWEEN TO_DATE(:START_DATE, 'DD-MON-YYYY') AND
                            TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            UNION
                            SELECT ETO_OFR_DISPLAY_ID, RAG_SCORE_TOTAL,
                            DATE_R P_DATE, (NOW() + interval '1 day') AS A_DATE , 0 AS ACTION, FK_GLUSR_USR_ID,
                            USER_IDENTIFIER_FLAG
                            FROM DIR_QUERY_FREE WHERE date(DATE_R)BETWEEN TO_DATE(:START_DATE, 'DD-MON-YYYY') AND
                            TO_DATE(:END_DATE, 'DD-MON-YYYY')
                            AND RAG_SCORE_TOTAL IS NOT NULL 
                            $sqlcond2 
                            ) B 
                            ) GEN
                            where GEN.HR::NUMERIC > 9 and GEN.HR::NUMERIC < 20
                            group by P_DATE,RAG_SCORE_TOTAL
                            ) A 
                            group by P_DATE ";
			
		}
                elseif($data =='81-Combination')
		{
			  
			$sql="SELECT TO_CHAR(ETO_OFR_APPROV_DATE_ORIG,'DD-Mon-YYYY') ETO_OFR_APPROV_DATE_ORIG,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(1,4,7,31,21,11) THEN 1 ELSE NULL END )) RED,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(2,5,8) THEN 1 ELSE NULL END )) AMBER,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(3,6,9,34,24,14) THEN 1 ELSE NULL END )) GREEN,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(12,22,32) THEN 1 ELSE NULL END )) ORANGE,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(13,23,33) THEN 1 ELSE NULL END )) YELLOW,
                        COUNT((CASE WHEN RAG_SCORE_TOTAL IN(15,25,35) THEN 1 ELSE NULL END )) BLUE,
                        COUNT(1) TOTAL 
                        FROM
                        (
                        SELECT
                        ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                        RAG_SCORE_TOTAL,date(ETO_OFR_APPROV_DATE_ORIG) ETO_OFR_APPROV_DATE_ORIG 
                        FROM ETO_OFR
                        WHERE date(ETO_OFR_APPROV_DATE_ORIG) BETWEEN
                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND TO_DATE(:END_DATE,'DD-MON-YYYY') AND ETO_OFR_APPROV='A' AND
                        RAG_SCORE_TOTAL IS NOT NULL 
                        $sqlcond2 
                        UNION
                        SELECT
                        ETO_OFR_DISPLAY_ID,ETO_OFR_CALL_DISPOSITION_TYPE,USER_IDENTIFIER_FLAG,FK_GL_MODULE_ID,FK_GL_COUNTRY_ISO S_COUNTRY_UPPER,
                        RAG_SCORE_TOTAL,date(ETO_OFR_APPROV_DATE_ORIG)  ETO_OFR_APPROV_DATE_ORIG 
                        FROM ETO_OFR_EXPIRED
                        WHERE date(ETO_OFR_APPROV_DATE_ORIG) BETWEEN
                        TO_DATE(:START_DATE,'DD-MON-YYYY') AND
                        TO_DATE(:END_DATE,'DD-MON-YYYY') AND ETO_OFR_APPROV='A' AND  RAG_SCORE_TOTAL IS NOT NULL 
                        $sqlcond2 
                        ) A 
                        GROUP BY ETO_OFR_APPROV_DATE_ORIG ORDER BY ETO_OFR_APPROV_DATE_ORIG ASC";
			
		}
		$bind[':START_DATE']=$start_date;
		$bind[':END_DATE']=$end_date;
		
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,$bind);
		$recData=$sth->readAll();
		return $recData;
	}  
   
   
   
}   