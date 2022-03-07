<?php
class EtoTrackUsr extends CFormModel
{
        public function getCount($glid,$dbh)
        {
                $sql = "
 SELECT
                        B.*,
                        A.CNT
                FROM
                (
                SELECT
                        trunc(ETO_TRACK_DATE) ETO_TRACK_DATE, COUNT(1) CNT
                FROM
                        ETO_TRACK_GLUSR
                WHERE
                        FK_GLUSR_USR_ID=:GLID
                        AND TRUNC(ETO_TRACK_DATE)>=trunc(SYSDATE-30)
                GROUP BY trunc(ETO_TRACK_DATE)
                ) A,
                (
                        SELECT
                                TO_CHAR(LEVEL + TRUNC(sysdate-30) - 1,'dd-Mon-yyyy') DAT
                        FROM
                                DUAL
                        CONNECT BY LEVEL <= TRUNC(sysdate) - TRUNC(sysdate-30)+1
                ) B
                WHERE
                        A.ETO_TRACK_DATE (+) = B.DAT
                order by TO_DATE(B.DAT,'dd-Mon-yyyy')

";
                $sql_rslt = $dbh->createCommand($sql);
                $sql_rslt->bindValue(":GLID",$glid);
                $dataResult=$sql_rslt->query();
                $rec=$dataResult->readAll();
                return $rec;
        }
        public function getOpenClickCount($glid)
        {
		$dbmodel = new BLGlobalmodelForm();
	//	$dbh=$dbmodel->connect_oracledb('ddup');
$dbh=oci_connect('indiamart','ref0cl39','192.170.156.76/ddup');
//print_r($dbh);
                $sql = "
SELECT
                                B.*,
                                A.OPENCNT,
                                A.CLICKCNT
                FROM
                                (
                                SELECT
                                        trunc(IIL_MAIL_EVENT_DATE) IIL_MAIL_EVENT_DATE,
                                        SUM(CASE WHEN
                                        IIL_MAIL_EVENT_TYPE='open'
                                        AND TRUNC(IIL_MAIL_EVENT_DATE)>= trunc(sysdate-30)
                                        THEN 1 
                                        END)OPENCNT,
                                        SUM (CASE WHEN
                                        IIL_MAIL_EVENT_TYPE='click'
                                        and TRUNC(IIL_MAIL_EVENT_DATE)>= trunc(sysdate-30)
                                        THEN 1 END )CLICKCNT
                                FROM IIL_MAIL_EVENTS
                                WHERE IIL_MAIL_EVENT_GLUSER_ID=$glid  --:GLID
                                group by trunc(IIL_MAIL_EVENT_DATE)
                                ) A,
                                (
                                        SELECT
                                                TO_CHAR(LEVEL + TRUNC(sysdate-30) - 1,'dd-Mon-yyyy') DAT
                                        FROM
                                                DUAL
                                        CONNECT BY LEVEL <= TRUNC(sysdate) - TRUNC(sysdate-30)+1
                                ) B
                                WHERE
                                        A.IIL_MAIL_EVENT_DATE (+) = B.DAT
                                order by TO_DATE(B.DAT,'dd-Mon-yyyy')
";
    //            $sql_rslt = $dbh->createCommand($sql);
$sql_rslt=oci_parse($dbh,$sql);
oci_execute($sql_rslt);
//                $sql_rslt->bindValue(":GLID",$glid);
  //              $dataResult=$sql_rslt->query();
//for($i=1;$i<20;$i++)(oci_fetch_array($sql_rslt));//            $rec=$dataResult->readAll();
//$aa= oci_fetch_array($sql_rslt);//            $rec=$dataResult->readAll();
//$aa= oci_fetch_array($sql_rslt);//            $rec=$dataResult->readAll();
//$aa= oci_fetch_array($sql_rslt);//            $rec=$dataResult->readAll();
//print "====>".$aa['OPENCNT']."<<---->".$aa['CLICKCNT']."<<--==>".$aa['DAT'];
oci_close($dbh);                return $sql_rslt;
        }
        public function getLeadViewCount($glid,$dbh)
        {
                $sql = "
		SELECT
                        B.*,
                        A.LEADVIEW_RANGE
                FROM
                                (
                                        SELECT
                                                TRUNC(ETO_LEAD_VIEW_DATE) ETO_LEAD_VIEW_DATE,
                                                COUNT(DISTINCT(
                                                CASE WHEN TRUNC(ETO_LEAD_VIEW_DATE)>=TRUNC(sysdate-30)
                                                THEN 
                                                FK_ETO_OFR_ID
                                                ELSE
                                                NULL END))LEADVIEW_RANGE
                                        FROM ETO_LEAD_VIEW_TRACKING
                                        WHERE FK_GLUSR_USR_ID=:GLID
                                        group by TRUNC(ETO_LEAD_VIEW_DATE)
                                ) A,
                                (
                                        SELECT
                                                TO_CHAR(LEVEL + TRUNC(sysdate-30) - 1,'dd-Mon-yyyy') DAT
                                        FROM
                                                DUAL
                                        CONNECT BY LEVEL <= TRUNC(sysdate) - TRUNC(sysdate-30)+1
                                ) B
                                WHERE
                                        A.ETO_LEAD_VIEW_DATE (+) = B.DAT
                                order by TO_DATE(B.DAT,'dd-Mon-yyyy')
";
                $sql_rslt = $dbh->createCommand($sql);
                $sql_rslt->bindValue(":GLID",$glid);
                $dataResult=$sql_rslt->query();
                $rec=$dataResult->readAll();
                return $rec;
        }
        public function getLeadSentCount($glid)
        {
		$dbmodel = new BLGlobalmodelForm();
		$dbh=$dbmodel->connect_oracledb('meshr');
                $sql = "
		SELECT
                        B.*,
                        A.LEADSENT_CNT
                FROM
                (
                                        select ETO_OFR_USR_SEND_SMS_DATE, count(1) LEADSENT_CNT from
                                        (
                                                select trunc(ETO_OFR_USR_SEND_SMS_DATE) ETO_OFR_USR_SEND_SMS_DATE, FK_ETO_OFR_ID from eto_ofr_usr_send_sms where FK_GLUSR_USR_ID=:GLID and ETO_OFR_USR_ALERT_TYPE = 1 and  trunc(ETO_OFR_USR_SEND_SMS_DATE)>=trunc(sysdate-30)
                                                union
                                                select trunc(ETO_OFR_USR_SEND_SMS_DATE) ETO_OFR_USR_SEND_SMS_DATE, FK_ETO_OFR_ID from eto_ofr_usr_send_sms_arch where FK_GLUSR_USR_ID=:GLID and ETO_OFR_USR_ALERT_TYPE = 1 and  trunc(ETO_OFR_USR_SEND_SMS_DATE)>=trunc(sysdate-30)
                                        ) group by ETO_OFR_USR_SEND_SMS_DATE
                                ) A,
                                (
                                        SELECT
                                                TO_CHAR(LEVEL + TRUNC(sysdate-30) - 1,'dd-Mon-yyyy') DAT
                                        FROM
                                                DUAL
                                        CONNECT BY LEVEL <= TRUNC(sysdate) - TRUNC(sysdate-30)+1
                                ) B
                                WHERE
                                        A.ETO_OFR_USR_SEND_SMS_DATE (+) = B.DAT
                                order by TO_DATE(B.DAT,'dd-Mon-yyyy')
";
                $sql_rslt = $dbh->createCommand($sql);
                $sql_rslt->bindValue(":GLID",$glid);
                $dataResult=$sql_rslt->query();
                $rec=$dataResult->readAll();
                return $rec;
        }
        public function getLandingCount($glid,$dbh)
        {
                $sql = "
			SELECT
                                B.*,
                                A.LANDING_COUNT
                        FROM
                        (
                                SELECT
                                        trunc(ETO_TRACK_DATE) ETO_TRACK_DATE,
                                        COUNT(1) LANDING_COUNT
                                FROM
                                        ETO_TRACK_GLUSR
                                WHERE
                                        FK_GLUSR_USR_ID = :GLID
                                        AND ETO_TRACK_FILE like '%eto-subscription%'
                                        AND TRUNC(ETO_TRACK_DATE) >= TRUNC(sysdate - 30)
                                group by trunc(ETO_TRACK_DATE)
                        ) A,
                        (
                                SELECT
                                        TO_CHAR(LEVEL + TRUNC(sysdate-30) - 1,'dd-Mon-yyyy') DAT
                                FROM
                                        DUAL
                                CONNECT BY LEVEL <= TRUNC(sysdate) - TRUNC(sysdate-30)+1
                        ) B
                        WHERE
                                A.ETO_TRACK_DATE (+) = B.DAT
                        order by TO_DATE(B.DAT,'dd-Mon-yyyy')
";
                $sql_rslt = $dbh->createCommand($sql);
                $sql_rslt->bindValue(":GLID",$glid);
                $dataResult=$sql_rslt->query();
                $rec=$dataResult->readAll();
                return $rec;
        }
        public function getUserAccessCount($mode,$condition,$modid,$start_date,$end_date,$dbh)
        {
//		$dbmodel = new BLGlobalmodelForm();
//		$dbh = $dbmodel->connect_oracledb('meshr');
                $sql="
select     A.*, COUNT(FK_GLUSR_USR_ID) OVER (PARTITION BY FK_GLUSR_USR_ID) TOT
                FROM
                (
                        SELECT
                                /*+(GLUSR_USR GLUSR_USR_ID_PK)*/
                                distinct ETO_TRACK_GLUSR.ETO_TRACK_DATE,
                                ETO_TRACK_GLUSR.FK_GLUSR_USR_ID,
                                ETO_TRACK_GLUSR.FK_ETO_OFR_ID,
                                ETO_TRACK_GLUSR.ETO_TRACK_FILE,
                                GLUSR_USR.GLUSR_ETO_CUST_CREDITS_AV,
                                GLUSR_USR.GLUSR_ETO_CUST_CREDITS_TOTAL,
                                (GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
                                GLUSR_USR.FK_PARENT_GLUSR_ID,
                                GLUSR_USR.GLUSR_USR_FIRSTNAME NAME,
                                GLUSR_USR.GLUSR_USR_COMPANYNAME GLUSR_COMPANY,
                                GLUSR_USR.GLUSR_USR_CITY GLUSR_CITY,
                                DECODE(LTRIM(GLUSR_USR_PH_NUMBER), NULL, NULL, ('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER || DECODE(GLUSR_USR_PH_MOBILE, NULL, NULL,'/ ' || GLUSR_USR_PH_MOBILE || DECODE(GLUSR_USR_PH_MOBILE_ALT, NULL, NULL,'/ ' || GLUSR_USR_PH_MOBILE_ALT)))) GLUSR_PHONE_MOBILE,
                                DECODE
                                (
                                LTRIM(GLUSR_USR_PH_NUMBER), NULL, NULL, ('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER)
                                ) GLUSR_USR_PH_NUMBER1,
                                DECODE(GLUSR_USR_PH_MOBILE, NULL, NULL, GLUSR_USR_PH_MOBILE) GLUSR_USR_PH_MOBILE1,
                                DECODE(GLUSR_USR_PH_MOBILE_ALT, NULL, NULL, GLUSR_USR_PH_MOBILE_ALT) GLUSR_USR_PH_MOBILE_ALT1,
                                GLUSR_USR.GLUSR_USR_COUNTRYNAME GLUSR_COUNTRY,
                                GLUSR_USR.GLUSR_USR_EMAIL,
                                GLUSR_USR_MEMBERSINCE,
                                ETO_TRACK_GLUSR.FK_GL_MODULE_ID,
                                DECODE(FK_COMPANYID, NULL,'N','Y') STS_FLG,
                STS_COMPANY.ASSIGNNAME,
                STS_COMPANY.TELEASSIGN_NAME,
                UPDATIONDATE
		FROM
                                ETO_TRACK_GLUSR, GLUSR_USR ,
                                (
                SELECT
                FK_COMPANYID,
                e1.EMPLOYEENAME ASSIGNNAME,
                e2.EMPLOYEENAME TELEASSIGN_NAME,
                UPDATIONDATE
                FROM
                STS_COMPANY,EMPLOYEE e1,EMPLOYEE e2
                WHERE
                TRUNC(STS_COMPANY.UPDATIONDATE) >= TRUNC(SYSDATE)-30
                AND E1.EMPLOYEEID=ASSIGNEDTO
                AND E2.EMPLOYEEID=TELEASSIGNEDTO
                                ) STS_COMPANY 
                        WHERE
                                GLUSR_USR.GLUSR_USR_ID = ETO_TRACK_GLUSR.FK_GLUSR_USR_ID
                                AND STS_COMPANY.FK_COMPANYID(+)=GLUSR_USR_COMPID
                $condition
                ) A
                ORDER BY NAME, FK_GLUSR_USR_ID, ETO_TRACK_DATE
";
                $sql_rslt = $dbh->createCommand($sql);
		if(!empty($modid) && $modid != '4')
                {
                        $sql_rslt->bindValue(':FK_GL_MODULE_ID',$mode);
                }
                $sql_rslt->bindValue(":START_DATE",$start_date);
                $sql_rslt->bindValue(":END_DATE",$end_date);
                $dataResult=$sql_rslt->query();
                $rec=$dataResult->readAll();
                return $rec;
        }
        public function getLeadViewDateCount($glid,$start_date,$end_date,$dbh)
        {
                $sql="
			SELECT COUNT( DISTINCT(
                        CASE
                        WHEN TRUNC(ETO_LEAD_VIEW_DATE) >=TRUNC(TO_DATE(SYSDATE-7))
                        AND TRUNC(ETO_LEAD_VIEW_DATE) < SYSDATE
                        THEN FK_ETO_OFR_ID ELSE NULL END))LEADVIEW_7DAYS,
                        COUNT(DISTINCT(
                        CASE WHEN TRUNC(ETO_LEAD_VIEW_DATE)>=TRUNC(TO_DATE(:STDATE,'DD-MM-YYYY'))
                        AND TRUNC(ETO_LEAD_VIEW_DATE)<=TRUNC(TO_DATE(:EDDATE,'DD-MM-YYYY'))
                        THEN 
                        FK_ETO_OFR_ID
                        ELSE
                        NULL END))LEADVIEW_RANGE
                        FROM ETO_LEAD_VIEW_TRACKING
                        WHERE FK_GLUSR_USR_ID=:GLID
";
                $sql_rslt = $dbh->createCommand($sql);
                $sql_rslt->bindValue(":STDATE",$start_date);
                $sql_rslt->bindValue(":EDDATE",$end_date);
                $sql_rslt->bindValue(":GLID",$glid);
                $dataResult=$sql_rslt->query();
                $rec=$dataResult->readAll();
                return $rec;
        }
        public function getLandingDateCount($glid,$start_date,$end_date,$dbh)
        {
                $sql="
			SELECT
                                trunc(ETO_TRACK_DATE) ETO_TRACK_DATE,
                                COUNT(1) LANDING_COUNT
                        FROM
                                ETO_TRACK_GLUSR
                        WHERE
                                FK_GLUSR_USR_ID = :GLID
                                AND ETO_TRACK_FILE like '%eto-subscription%'
                                AND TRUNC(ETO_TRACK_DATE) >= TRUNC(TO_DATE(:STDATE,'DD-MM-YYYY'))
                                AND TRUNC(ETO_TRACK_DATE) <= TRUNC(TO_DATE(:EDDATE,'DD-MM-YYYY'))
                                GROUP BY trunc(ETO_TRACK_DATE)
";
                $sql_rslt = $dbh->createCommand($sql);
                $sql_rslt->bindValue(":STDATE",$start_date);
                $sql_rslt->bindValue(":EDDATE",$end_date);
                $sql_rslt->bindValue(":GLID",$glid);
                $dataResult=$sql_rslt->query();
                $rec=$dataResult->readAll();
                return $rec;
        }
}
