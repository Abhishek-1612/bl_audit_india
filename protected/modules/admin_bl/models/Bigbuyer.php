<?php
class Bigbuyer extends CFormModel
{
     public function report($dbh,$data)
    {putenv("TNS_ADMIN=/etc/oracle");
       putenv("ORACLE_HOME=/usr/lib/oracle/11.2/client64/"); 
    $rec=array();
     // echo 'from date'.$start_date.'to date'.$end_date;
   // $sql="SELECT * FROM ETO_CUST_PURCHASE_HIST WHERE TRUNC(ETO_CUST_PURCHASE_DATE) BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY ETO_CUST_PURCHASE_DATE DESC";
    if(!isset($data['pg']))
    {
     $start=0;
     $end=1000;
    }
    else
    {
      if($data['pg']==1)
      {
         $start=0;
         $end=1000;
      }
      else
       {  $start=($data['pg']-1)*1000+1;
          $end=($data['pg'])*1000; 
        }  
    }
 
 
   $sql1="select
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS,
--IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN
wm_concat(IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN) IIL_BIG_BUYER_EMAIL_DOMAIN,
count(1) over (partition by 'A') AS CNT
from
IIL_BIG_BUYER_ORG,
IIL_BIG_BUYER_EMAIL,
IIL_BIG_BUYER_ORG_TO_EMAIL@meshr
where
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID=IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_ORG_ID
and IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_EMAIL_ID=IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_ID
group by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS
order by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID";
    $sth1=oci_parse($dbh,$sql1);
    oci_execute($sth1);
    $count1=oci_fetch_assoc($sth1);
    $count=$count1['CNT'];
    
  $sql="SELECT * FROM(
  SELECT A.*, ROWNUM RN FROM(
select
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS,
--IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN
--wm_concat(IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN,', ') IIL_BIG_BUYER_EMAIL_DOMAIN
replace(wm_concat(IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN),',',', ') IIL_BIG_BUYER_EMAIL_DOMAIN
from
IIL_BIG_BUYER_ORG,
IIL_BIG_BUYER_EMAIL,
IIL_BIG_BUYER_ORG_TO_EMAIL@meshr
where
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID=IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_ORG_ID
and IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_EMAIL_ID=IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_ID
group by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS
order by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID
)A
)
WHERE RN >=$start AND RN <=$end
";
    
   $sth=oci_parse($dbh,$sql);
    /*oci_bind_by_name($sth,':START',$start_date);
    oci_bind_by_name($sth,':END',$end_date);
    */oci_execute($sth);  
    oci_fetch_all($sth,$rec);
   //var_dump($rec);
   return array('rec'=>$rec,'count'=>$count);
   }

   
   
    public function report1($dbh,$data)
    {
   $oid=$data['orgid'];
  $sql="
select
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN
from
IIL_BIG_BUYER_ORG ,
IIL_BIG_BUYER_EMAIL,
IIL_BIG_BUYER_ORG_TO_EMAIL@meshr
WHERE
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID=IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_ORG_ID
and IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_EMAIL_ID=IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_ID
AND IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID=:OID
order by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID
";
    
   $sth=oci_parse($dbh,$sql);
   oci_bind_by_name($sth,':OID',$oid);
   oci_execute($sth);  
    oci_fetch_all($sth,$rec);
 $rec1=array();
 $sql1="select
  count(distinct FK_GLUSR_USR_ID) as CNT
from
  iil_big_buyer_to_glusr
where
  FK_IIL_BIG_BUYER_ORG_ID =$oid
";
 $sth1=oci_parse($dbh,$sql1);
   oci_execute($sth1);  
   $count1=oci_fetch_assoc($sth1);
    $count=$count1['CNT'];
 
 //////////////////////////////////////////////////////////////////////////////
 $sql2="select
  sum(LEAD_GEN_1M) LEAD_GEN_1M,
  sum(LEAD_GEN_3M) LEAD_GEN_3M,
  sum(LEAD_GEN_6M) LEAD_GEN_6M,
  sum(LEAD_APP_1M) LEAD_APP_1M,
  sum(LEAD_APP_3M) LEAD_APP_3M,
  sum(LEAD_APP_6M) LEAD_APP_6M
from
(
select
  count(case when trunc(DATE_R)>= trunc(sysdate-30) then 1 end) LEAD_GEN_1M,
  count(case when trunc(DATE_R)>= trunc(sysdate-60) then 1 end) LEAD_GEN_3M,
  count(1) LEAD_GEN_6M,
  0 LEAD_APP_1M,
  0 LEAD_APP_3M,
  0 LEAD_APP_6M
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
and trunc(DATE_R)>=trunc(sysdate-180)


union all
select
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) then 1 end) LEAD_GEN_1M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) then 1 end) LEAD_GEN_3M,
  count(1) LEAD_GEN_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) ) and eto_ofr_approv='A' ) then 1 end) LEAD_APP_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) ) and eto_ofr_approv='A' ) then 1 end) LEAD_APP_3M,
  count(case when eto_ofr_approv='A' then 1 end) LEAD_APP_6M
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
union all
select
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) then 1 end) LEAD_GEN_1M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) then 1 end) LEAD_GEN_3M,
  count(1) LEAD_GEN_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) ) and eto_ofr_approv='A' ) then 1 end) LEAD_APP_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) ) and eto_ofr_approv='A' ) then 1 end) LEAD_APP_3M,
  count(case when eto_ofr_approv='A' then 1 end) LEAD_APP_6M
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
union all
select
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) then 1 end) LEAD_GEN_1M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) then 1 end) LEAD_GEN_3M,
  count(1) LEAD_GEN_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) ) and eto_ofr_approv='A' ) then 1 end) LEAD_APP_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) ) and eto_ofr_approv='A' ) then 1 end) LEAD_APP_3M,
  count(case when eto_ofr_approv='A' then 1 end) LEAD_APP_6M
from
  ETO_OFR_TEMP_DEL,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
)";
 $sth2=oci_parse($dbh,$sql2);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth2,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth2);  
    $rec2=array();
    $rec2=oci_fetch_assoc($sth2);
    
 /***********************************************************************/
 /*********************Active Users Generated used in pdf****************/
 /***********************************************************************/
    $sql3="select
  count(distinct case when trunc(DATE_R)>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) ACTIV_1M,
  count(distinct case when trunc(DATE_R)>=trunc(sysdate-90) then FK_GLUSR_USR_ID end) ACTIV_3M,
  count(distinct case when trunc(DATE_R)>=trunc(sysdate-180) then FK_GLUSR_USR_ID end) ACTIV_6M
from
(
select
  DIR_QUERY_FREE.FK_GLUSR_USR_ID,
  DATE_R
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(DATE_R)>=trunc(sysdate-180)
union
select
  ETO_OFR.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
union
select
  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
union
select
  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR_TEMP_DEL,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
)";
   $sth3=oci_parse($dbh,$sql3);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth3,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth3);  
    $rec3=array();
    $rec3=oci_fetch_assoc($sth3);
    
 /***********************************************************************/
 /*********************Active Users on Approval Basis********************/
 /***********************************************************************/
 $sql31="select
  count(distinct case when trunc(DATE_R)>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) ACTIV_1M,
  count(distinct case when trunc(DATE_R)>=trunc(sysdate-90) then FK_GLUSR_USR_ID end) ACTIV_3M,
  count(distinct case when trunc(DATE_R)>=trunc(sysdate-180) then FK_GLUSR_USR_ID end) ACTIV_6M
from
(
select
  DIR_QUERY_FREE.FK_GLUSR_USR_ID,
  DATE_R
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(DATE_R)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
union
select
  ETO_OFR.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
union
select
  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
union
select
  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR_TEMP_DEL,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
)";
   $sth31=oci_parse($dbh,$sql31);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth31,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth31);  
    $rec31=array();
    $rec31=oci_fetch_assoc($sth31);
 /***********************************************************************/   
    $sql4="select
  sum(FULL_FEEDBACK_6M) FULL_FEEDBACK_6M,
  sum(FULL_FEEDBACK_3M) FULL_FEEDBACK_3M,
  sum(FULL_FEEDBACK_1M) FULL_FEEDBACK_1M
from
(
select
  count(1) FULL_FEEDBACK_6M,
  count(case when trunc(date_r)>=trunc(sysdate-90) then 1 end) FULL_FEEDBACK_3M,
  count(case when trunc(date_r)>=trunc(sysdate-30) then 1 end) FULL_FEEDBACK_1M
from
  BUYER_REQUIREMENT_OVER,
  iil_big_buyer_to_glusr,
  dir_query_free
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and DIR_QUERY_FREE.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(DATE_R)>=trunc(sysdate-180)
union all
select
  count(1) FULL_FEEDBACK_6M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90) then 1 end) FULL_FEEDBACK_3M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-30) then 1 end) FULL_FEEDBACK_1M
from
  BUYER_REQUIREMENT_OVER,
  iil_big_buyer_to_glusr,
  eto_ofr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and eto_ofr.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and eto_ofr.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
union all
select
  count(1) FULL_FEEDBACK_6M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90) then 1 end) FULL_FEEDBACK_3M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-30) then 1 end) FULL_FEEDBACK_1M
from
  BUYER_REQUIREMENT_OVER,
  iil_big_buyer_to_glusr,
  eto_ofr_expired
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and eto_ofr_expired.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and eto_ofr_expired.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
union all
select
  count(1) FULL_FEEDBACK_6M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90) then 1 end) FULL_FEEDBACK_3M,
  count(case when trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-30) then 1 end) FULL_FEEDBACK_1M
from
  BUYER_REQUIREMENT_OVER,
  iil_big_buyer_to_glusr,
  eto_ofr_TEMP_DEL
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and eto_ofr_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and eto_ofr_TEMP_DEL.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
)";
$sth4=oci_parse($dbh,$sql4);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth4,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth4);  
    $rec4=array();
    $rec4=oci_fetch_assoc($sth4);
   
   $sql5="select
  count(distinct case when LG_6W>=1 and LG_5W>=1 and LG_4W>=1 and LG_3W>=1 and LG_2W>=1 and LG_1W>=1 then FK_GLUSR_USR_ID end) P_CNT,
  count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M>=3 and LG_2M>=3 and LG_1M>=3) then FK_GLUSR_USR_ID end) G_CNT,
  count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M in (1,2,3) and LG_2M in (1,2,3) and LG_1M in (1,2,3)) then FK_GLUSR_USR_ID end) S_CNT
  from
(
  select
  FK_GLUSR_USR_ID,
  count(case when LEAD_GEN_6W=FK_GLUSR_USR_ID then 1 end) LG_6W,
  count(case when LEAD_GEN_5W=FK_GLUSR_USR_ID then 1 end) LG_5W,
  count(case when LEAD_GEN_4W=FK_GLUSR_USR_ID then 1 end) LG_4W,
  count(case when LEAD_GEN_3W=FK_GLUSR_USR_ID then 1 end) LG_3W,
  count(case when LEAD_GEN_2W=FK_GLUSR_USR_ID then 1 end) LG_2W,
  count(case when LEAD_GEN_1W=FK_GLUSR_USR_ID then 1 end) LG_1W,

  count(case when LEAD_GEN_3M=FK_GLUSR_USR_ID then 1 end) LG_3M,
  count(case when LEAD_GEN_2M=FK_GLUSR_USR_ID then 1 end) LG_2M,
  count(case when LEAD_GEN_1M=FK_GLUSR_USR_ID then 1 end) LG_1M
  from
  (
    select
      FK_GLUSR_USR_ID,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) LEAD_GEN_1M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-60) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-30)then FK_GLUSR_USR_ID end) LEAD_GEN_2M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-90) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-60)then FK_GLUSR_USR_ID end) LEAD_GEN_3M,

      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_1W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-14) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_2W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-21) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-14) then FK_GLUSR_USR_ID end) LEAD_GEN_3W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-28) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-21) then FK_GLUSR_USR_ID end) LEAD_GEN_4W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-35) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-28) then FK_GLUSR_USR_ID end) LEAD_GEN_5W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-42) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-35) then FK_GLUSR_USR_ID end) LEAD_GEN_6W
    from
    (
      select
    eto_ofr_display_id,dir_query_free.FK_GLUSR_USR_ID, DATE_R ETO_OFR_POSTDATE_ORIG
      from 
    dir_query_free,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=dir_query_free.FK_GLUSR_USR_ID
    and trunc(DATE_R)>=trunc(sysdate-90)
      union
      select
    eto_ofr_display_id,eto_ofr.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
      union
      select
    eto_ofr_display_id,eto_ofr_expired.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr_expired,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr_expired.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
      union
      select
    eto_ofr_display_id,eto_ofr_temp_del.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr_temp_del,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr_temp_del.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
    )
  )
  group by FK_GLUSR_USR_ID
)";
$sth5=oci_parse($dbh,$sql5);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth5,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth5);  
    $rec5=array();
    $rec5=oci_fetch_assoc($sth5);
    
    $sql6="select
  count(distinct case when LG_6W>=1 and LG_5W>=1 and LG_4W>=1 and LG_3W>=1 and LG_2W>=1 and LG_1W>=1 then FK_GLUSR_USR_ID end) P_CNT_APP,
  count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M>=3 and LG_2M>=3 and LG_1M>=3) then FK_GLUSR_USR_ID end) G_CNT_APP,
  count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M in (1,2,3) and LG_2M in (1,2,3) and LG_1M in (1,2,3)) then FK_GLUSR_USR_ID end) S_CNT_APP
  from
(
  select
  FK_GLUSR_USR_ID,
  count(case when LEAD_GEN_6W=FK_GLUSR_USR_ID then 1 end) LG_6W,
  count(case when LEAD_GEN_5W=FK_GLUSR_USR_ID then 1 end) LG_5W,
  count(case when LEAD_GEN_4W=FK_GLUSR_USR_ID then 1 end) LG_4W,
  count(case when LEAD_GEN_3W=FK_GLUSR_USR_ID then 1 end) LG_3W,
  count(case when LEAD_GEN_2W=FK_GLUSR_USR_ID then 1 end) LG_2W,
  count(case when LEAD_GEN_1W=FK_GLUSR_USR_ID then 1 end) LG_1W,

  count(case when LEAD_GEN_3M=FK_GLUSR_USR_ID then 1 end) LG_3M,
  count(case when LEAD_GEN_2M=FK_GLUSR_USR_ID then 1 end) LG_2M,
  count(case when LEAD_GEN_1M=FK_GLUSR_USR_ID then 1 end) LG_1M
  from
  (
    select
      FK_GLUSR_USR_ID,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) LEAD_GEN_1M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-60) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-30)then FK_GLUSR_USR_ID end) LEAD_GEN_2M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-90) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-60)then FK_GLUSR_USR_ID end) LEAD_GEN_3M,

      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_1W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-14) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_2W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-21) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-14) then FK_GLUSR_USR_ID end) LEAD_GEN_3W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-28) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-21) then FK_GLUSR_USR_ID end) LEAD_GEN_4W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-35) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-28) then FK_GLUSR_USR_ID end) LEAD_GEN_5W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-42) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-35) then FK_GLUSR_USR_ID end) LEAD_GEN_6W
    from
    (
     
      select
    eto_ofr_display_id,eto_ofr.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
    AND ETO_OFR_APPROV ='A'
      union
      select
    eto_ofr_display_id,eto_ofr_expired.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr_expired,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr_expired.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
    AND ETO_OFR_APPROV ='A'    
     
    )
  )
  group by FK_GLUSR_USR_ID
)";
$sth6=oci_parse($dbh,$sql6);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth6,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth6);  
    $rec6=array();
    $rec6=oci_fetch_assoc($sth6);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
  //  approve

$sql51="
select
  count(distinct case when LG_6W>=1 and LG_5W>=1 and LG_4W>=1 and LG_3W>=1 and LG_2W>=1 and LG_1W>=1 then FK_GLUSR_USR_ID end) P_CNT_APP,
  nvl(sum(         case when LG_6W>=1 and LG_5W>=1 and LG_4W>=1 and LG_3W>=1 and LG_2W>=1 and LG_1W>=1 then 
  (nvl(LG_6W,0)+nvl(LG_5W,0)+nvl(LG_4W,0)+nvl(LG_3W,0)+nvl(LG_2W,0)+nvl(LG_1W,0))
  end),0) P_lead_APP,
  
  
  
  
  count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M>=3 and LG_2M>=3 and LG_1M>=3) then FK_GLUSR_USR_ID end) G_CNT_APP,
  nvl(sum(         case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M>=3 and LG_2M>=3 and LG_1M>=3) then (nvl(LG_3M,0)+nvl(LG_2M,0)+nvl(LG_1M,0)) end),0) G_lead_APP,
  
  
  
  count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M in (1,2,3) and LG_2M in (1,2,3) and LG_1M in (1,2,3)) then FK_GLUSR_USR_ID end) S_CNT_APP,
  nvl(sum(         case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M in (1,2,3) and LG_2M in (1,2,3) and LG_1M in (1,2,3)) then (nvl(LG_3M,0)+nvl(LG_2M,0)+nvl(LG_1M,0)) end),0) S_lead_APP
  
  from
(
  select
  FK_GLUSR_USR_ID,
  count(case when LEAD_GEN_6W=FK_GLUSR_USR_ID then 1 end) LG_6W,
  count(case when LEAD_GEN_5W=FK_GLUSR_USR_ID then 1 end) LG_5W,
  count(case when LEAD_GEN_4W=FK_GLUSR_USR_ID then 1 end) LG_4W,
  count(case when LEAD_GEN_3W=FK_GLUSR_USR_ID then 1 end) LG_3W,
  count(case when LEAD_GEN_2W=FK_GLUSR_USR_ID then 1 end) LG_2W,
  count(case when LEAD_GEN_1W=FK_GLUSR_USR_ID then 1 end) LG_1W,

  count(case when LEAD_GEN_3M=FK_GLUSR_USR_ID then 1 end) LG_3M,
  count(case when LEAD_GEN_2M=FK_GLUSR_USR_ID then 1 end) LG_2M,
  count(case when LEAD_GEN_1M=FK_GLUSR_USR_ID then 1 end) LG_1M
  from
  (
    select
      FK_GLUSR_USR_ID,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) LEAD_GEN_1M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-60) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-30)then FK_GLUSR_USR_ID end) LEAD_GEN_2M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-90) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-60)then FK_GLUSR_USR_ID end) LEAD_GEN_3M,

      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_1W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-14) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_2W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-21) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-14) then FK_GLUSR_USR_ID end) LEAD_GEN_3W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-28) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-21) then FK_GLUSR_USR_ID end) LEAD_GEN_4W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-35) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-28) then FK_GLUSR_USR_ID end) LEAD_GEN_5W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-42) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-35) then FK_GLUSR_USR_ID end) LEAD_GEN_6W
    from
    (
     
      select
    eto_ofr_display_id,eto_ofr.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
    AND ETO_OFR_APPROV ='A'
      union
      select
    eto_ofr_display_id,eto_ofr_expired.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr_expired,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr_expired.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
    AND ETO_OFR_APPROV ='A'    
     
    )
  )
  group by FK_GLUSR_USR_ID
)";
$sth51=oci_parse($dbh,$sql51);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth51,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth51);  
    $rec51=array();
    $rec51=oci_fetch_assoc($sth51);
    
//var_dump($rec51);		
//====================================================================
//generated
//---------------
$sql61="select
   count(distinct case when LG_6W>=1 and LG_5W>=1 and LG_4W>=1 and LG_3W>=1 and LG_2W>=1 and LG_1W>=1 then FK_GLUSR_USR_ID end) P_CNT,
 NVL(sum(         case when LG_6W>=1 and LG_5W>=1 and LG_4W>=1 and LG_3W>=1 and LG_2W>=1 and LG_1W>=1 then (nvl(LG_6W,0)+nvl(LG_5W,0)+nvl(LG_4W,0)+nvl(LG_3W,0)+nvl(LG_2W,0)+nvl(LG_1W,0)) end),0) P_lead_CNT,
 
 
 
 count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M>=3 and LG_2M>=3 and LG_1M>=3) then FK_GLUSR_USR_ID end) G_CNT,
 nvl(sum(         case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M>=3 and LG_2M>=3 and LG_1M>=3) then (nvl(LG_3M,0)+nvl(LG_2M,0)+nvl(LG_1M,0)) end),0) G_lead_CNT,
 
 count(distinct case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M in (1,2,3) and LG_2M in (1,2,3) and LG_1M in (1,2,3)) then FK_GLUSR_USR_ID end) S_CNT,
   nvl(sum(       case when ( (LG_6W=0 or LG_5W=0 or LG_4W=0 or LG_3W=0 or LG_2W=0 or LG_1W=0) and LG_3M in (1,2,3) and LG_2M in (1,2,3) and LG_1M in (1,2,3)) then (nvl(LG_3M,0)+nvl(LG_2M,0)+nvl(LG_1M,0)) end),0) S_lead_CNT
  
  from
(
  select
  FK_GLUSR_USR_ID,
  count(case when LEAD_GEN_6W=FK_GLUSR_USR_ID then 1 end) LG_6W,
  count(case when LEAD_GEN_5W=FK_GLUSR_USR_ID then 1 end) LG_5W,
  count(case when LEAD_GEN_4W=FK_GLUSR_USR_ID then 1 end) LG_4W,
  count(case when LEAD_GEN_3W=FK_GLUSR_USR_ID then 1 end) LG_3W,
  count(case when LEAD_GEN_2W=FK_GLUSR_USR_ID then 1 end) LG_2W,
  count(case when LEAD_GEN_1W=FK_GLUSR_USR_ID then 1 end) LG_1W,

  count(case when LEAD_GEN_3M=FK_GLUSR_USR_ID then 1 end) LG_3M,
  count(case when LEAD_GEN_2M=FK_GLUSR_USR_ID then 1 end) LG_2M,
  count(case when LEAD_GEN_1M=FK_GLUSR_USR_ID then 1 end) LG_1M
  from
  (
    select
      FK_GLUSR_USR_ID,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) LEAD_GEN_1M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-60) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-30)then FK_GLUSR_USR_ID end) LEAD_GEN_2M,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-90) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-60)then FK_GLUSR_USR_ID end) LEAD_GEN_3M,

      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_1W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-14) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-7) then FK_GLUSR_USR_ID end) LEAD_GEN_2W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-21) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-14) then FK_GLUSR_USR_ID end) LEAD_GEN_3W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-28) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-21) then FK_GLUSR_USR_ID end) LEAD_GEN_4W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-35) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-28) then FK_GLUSR_USR_ID end) LEAD_GEN_5W,
      (case when ETO_OFR_POSTDATE_ORIG>=trunc(sysdate-42) and ETO_OFR_POSTDATE_ORIG<trunc(sysdate-35) then FK_GLUSR_USR_ID end) LEAD_GEN_6W
    from
    (
      select
    eto_ofr_display_id,dir_query_free.FK_GLUSR_USR_ID, DATE_R ETO_OFR_POSTDATE_ORIG
      from 
    dir_query_free,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=dir_query_free.FK_GLUSR_USR_ID
    and trunc(DATE_R)>=trunc(sysdate-90)
      union
      select
    eto_ofr_display_id,eto_ofr.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
      union
      select
    eto_ofr_display_id,eto_ofr_expired.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr_expired,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr_expired.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
      union
      select
    eto_ofr_display_id,eto_ofr_temp_del.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG
      from
    eto_ofr_temp_del,
    IIL_BIG_BUYER_TO_GLUSR
      where
    IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
    and IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID=eto_ofr_temp_del.FK_GLUSR_USR_ID
    and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
    )
  )
  group by FK_GLUSR_USR_ID
)";
$sth61=oci_parse($dbh,$sql61);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth61,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth61);  
    $rec61=array();
    $rec61=oci_fetch_assoc($sth61);
//var_dump($rec61);
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $sql7="select

  sum(LEAD_APP_1M) LEAD_APP_1M,
  sum(LEAD_APP_3M) LEAD_APP_3M,
  sum(LEAD_APP_6M) LEAD_APP_6M,
  sum(LEAD_qty_1M) LEAD_qty_1M,
  sum(LEAD_qty_3M) LEAD_qty_3M,
  sum(LEAD_qty_6M) LEAD_qty_6M,
  sum(LEAD_aov_1M) LEAD_aov_1M,
  sum(LEAD_aov_3M) LEAD_aov_3M,
  sum(LEAD_aov_6M) LEAD_aov_6M,
  sum(ETO_OFR_REQ_APP_USAGE_1M) USAGE_1M,
  sum(ETO_OFR_REQ_APP_USAGE_3M) USAGE_3M,
  sum(ETO_OFR_REQ_APP_USAGE_6M) USAGE_6M,
  sum(ETO_OFR_GEOGRAPHY_ID_1m)Location_1m,
  sum(ETO_OFR_GEOGRAPHY_ID_3m)Location_3m,
  sum(ETO_OFR_GEOGRAPHY_ID_6m)Location_6m,
  sum (ETO_OFR_REQ_FREQ_1m)frequency_1m,
  sum (ETO_OFR_REQ_FREQ_3m)frequency_3m,
  sum (ETO_OFR_REQ_FREQ_6m)frequency_6m,
  sum(ETO_OFR_REQ_TYPE_1m)reqtype_1m,
  sum(ETO_OFR_REQ_TYPE_3m)reqtype_3m,
  sum(ETO_OFR_REQ_TYPE_6m)reqtype_6m
   
from
(
select

  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )  ) then 1 end) LEAD_APP_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )  ) then 1 end) LEAD_APP_3M,
  count(case when eto_ofr_approv='A' then 1 end) LEAD_APP_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) ) and  ETO_OFR_QTY is not null  ) then 1 end) LEAD_qty_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_QTY is not null ) then 1 end) LEAD_qty_3M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_QTY is not null  ) then 1 end) LEAD_qty_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE is not null  ) then 1 end) LEAD_aov_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE is not null  ) then 1 end) LEAD_aov_3M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE is not null  ) then 1 end) LEAD_aov_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_REQ_APP_USAGE is not null  ) then 1 end) ETO_OFR_REQ_APP_USAGE_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_REQ_APP_USAGE is not null  ) then 1 end) ETO_OFR_REQ_APP_USAGE_3M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_REQ_APP_USAGE is not null  ) then 1 end) ETO_OFR_REQ_APP_USAGE_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_GEOGRAPHY_ID is not null  ) then 1 end) ETO_OFR_GEOGRAPHY_ID_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_GEOGRAPHY_ID is not null  ) then 1 end) ETO_OFR_GEOGRAPHY_ID_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_GEOGRAPHY_ID is not null  ) then 1 end) ETO_OFR_GEOGRAPHY_ID_6m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_REQ_FREQ is not null  ) then 1 end) ETO_OFR_REQ_FREQ_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_REQ_FREQ is not null  ) then 1 end) ETO_OFR_REQ_FREQ_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_REQ_FREQ is not null  ) then 1 end) ETO_OFR_REQ_FREQ_6m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_REQ_TYPE is not null  ) then 1 end) ETO_OFR_REQ_TYPE_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_REQ_TYPE is not null  ) then 1 end) ETO_OFR_REQ_TYPE_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_REQ_TYPE is not null  ) then 1 end) ETO_OFR_REQ_TYPE_6m
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  and eto_ofr_approv='A'

union all

select
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )  ) then 1 end) LEAD_APP_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )  ) then 1 end) LEAD_APP_3M,
  count(case when eto_ofr_approv='A' then 1 end) LEAD_APP_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) ) and  ETO_OFR_QTY is not null  ) then 1 end) LEAD_qty_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_QTY is not null ) then 1 end) LEAD_qty_3M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_QTY is not null  ) then 1 end) LEAD_qty_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE is not null  ) then 1 end) LEAD_aov_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE is not null  ) then 1 end) LEAD_aov_3M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE is not null  ) then 1 end) LEAD_aov_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_REQ_APP_USAGE is not null  ) then 1 end) ETO_OFR_REQ_APP_USAGE_1M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_REQ_APP_USAGE is not null  ) then 1 end) ETO_OFR_REQ_APP_USAGE_3M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_REQ_APP_USAGE is not null  ) then 1 end) ETO_OFR_REQ_APP_USAGE_6M,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_GEOGRAPHY_ID is not null  ) then 1 end) ETO_OFR_GEOGRAPHY_ID_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_GEOGRAPHY_ID is not null  ) then 1 end) ETO_OFR_GEOGRAPHY_ID_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_GEOGRAPHY_ID is not null  ) then 1 end) ETO_OFR_GEOGRAPHY_ID_6m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_REQ_FREQ is not null  ) then 1 end) ETO_OFR_REQ_FREQ_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_REQ_FREQ is not null  ) then 1 end) ETO_OFR_REQ_FREQ_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_REQ_FREQ is not null  ) then 1 end) ETO_OFR_REQ_FREQ_6m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_REQ_TYPE is not null  ) then 1 end) ETO_OFR_REQ_TYPE_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_REQ_TYPE is not null  ) then 1 end) ETO_OFR_REQ_TYPE_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_REQ_TYPE is not null  ) then 1 end) ETO_OFR_REQ_TYPE_6m

from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  and eto_ofr_approv='A'
 
)";
$sth7=oci_parse($dbh,$sql7);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth7,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth7);  
    $rec7=array();
    $rec7=oci_fetch_assoc($sth7);
      
      $sql8="select

  sum(order_upto_1000_1m) order_upto_1000_1m,
  sum(order_upto_1000_3m) order_upto_1000_3m,
  sum(order_upto_1000_6m) order_upto_1000_6m,
  
  sum(order_upto_1000_3000_1m) order_upto_1000_3000_1m,
  sum(order_upto_1000_3000_3m) order_upto_1000_3000_3m,
  sum(order_upto_1000_3000_6m) order_upto_1000_3000_6m,
  
  sum(order_upto_3000_10000_1m) order_upto_3000_10000_1m,
  sum(order_upto_3000_10000_3m) order_upto_3000_10000_3m,
  sum(order_upto_3000_10000_6m) order_upto_3000_10000_6m,
  
  sum(order_upto_10000_20000_1m) order_upto_10000_20000_1m,
  sum(order_upto_10000_20000_3m) order_upto_10000_20000_3m,
  sum(order_upto_10000_20000_6m) order_upto_10000_20000_6m,
  
  sum(order_upto_20000_50000_1m) order_upto_20000_50000_1m,
  sum(order_upto_20000_50000_3m) order_upto_20000_50000_3m,
  sum(order_upto_20000_50000_6m) order_upto_20000_50000_6m,
  
  
  sum(order_upto_50000_1lakh_1m) order_upto_50000_1lakh_1m,
  sum(order_upto_50000_1lakh_3m) order_upto_50000_1lakh_3m,
  sum(order_upto_50000_1lakh_6m) order_upto_50000_1lakh_6m,
  
  
  sum(order_upto_1_2lakh_1m) order_upto_1_2lakh_1m,
  sum(order_upto_1_2lakh_3m) order_upto_1_2lakh_3m,
  sum(order_upto_1_2lakh_6m) order_upto_1_2lakh_6m,
  
  
 sum(order_upto_2_5lakh_1m) order_upto_2_5lakh_1m, 
 sum(order_upto_2_5lakh_3m) order_upto_2_5lakh_3m, 
 sum(order_upto_2_5lakh_6m) order_upto_2_5lakh_6m, 
 
  sum(order_upto_5_10lakh_1m) order_upto_5_10lakh_1m, 
  sum(order_upto_5_10lakh_3m) order_upto_5_10lakh_3m, 
  sum(order_upto_5_10lakh_6m) order_upto_5_10lakh_6m, 
 
 
 
 sum(order_upto_1_2million_1m) order_upto_1_2million_1m, 
 sum(order_upto_1_2million_3m) order_upto_1_2million_3m, 
 sum(order_upto_1_2million_6m) order_upto_1_2million_6m, 
 
 
 sum(order_upto_2_5million_1m) order_upto_2_5million_1m, 
 sum(order_upto_2_5million_3m) order_upto_2_5million_3m, 
 sum(order_upto_2_5million_6m) order_upto_2_5million_6m, 
 
 
 
 
 sum(order_upto_5_10million_1m) order_upto_5_10million_1m,
 sum(order_upto_5_10million_3m) order_upto_5_10million_3m,
 sum(order_upto_5_10million_6m) order_upto_5_10million_6m,
 
 
 
 sum(order_upto_morethan1cr_1m) order_upto_morethan1cr_1m, 
 sum(order_upto_morethan1cr_3m) order_upto_morethan1cr_3m, 
 sum(order_upto_morethan1cr_6m) order_upto_morethan1cr_6m
   
from
(
select

  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 100  ) then 1 end) order_upto_1000_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE =100  ) then 1 end) order_upto_1000_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE =100 ) then 1 end) order_upto_1000_6m,
  
  
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 200  ) then 1 end) order_upto_1000_3000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 200  ) then 1 end) order_upto_1000_3000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 200  ) then 1 end) order_upto_1000_3000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 300  ) then 1 end) order_upto_3000_10000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 300  ) then 1 end) order_upto_3000_10000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 300  ) then 1 end) order_upto_3000_10000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 400  ) then 1 end) order_upto_10000_20000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 400  ) then 1 end) order_upto_10000_20000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 400  ) then 1 end) order_upto_10000_20000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 500  ) then 1 end) order_upto_20000_50000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 500  ) then 1 end) order_upto_20000_50000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 500  ) then 1 end) order_upto_20000_50000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 600  ) then 1 end) order_upto_50000_1lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 600  ) then 1 end) order_upto_50000_1lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 600  ) then 1 end) order_upto_50000_1lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 700  ) then 1 end) order_upto_1_2lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 700  ) then 1 end) order_upto_1_2lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 700  ) then 1 end) order_upto_1_2lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 800  ) then 1 end) order_upto_2_5lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 800  ) then 1 end) order_upto_2_5lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 800  ) then 1 end) order_upto_2_5lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 900  ) then 1 end) order_upto_5_10lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 900  ) then 1 end) order_upto_5_10lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 900  ) then 1 end) order_upto_5_10lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1000  ) then 1 end) order_upto_1_2million_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1000  ) then 1 end) order_upto_1_2million_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1000  ) then 1 end) order_upto_1_2million_6m,
 
 
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1100  ) then 1 end) order_upto_2_5million_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1100  ) then 1 end) order_upto_2_5million_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1100  ) then 1 end) order_upto_2_5million_6m,
  
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1200  ) then 1 end) order_upto_5_10million_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1200  ) then 1 end) order_upto_5_10million_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1200  ) then 1 end) order_upto_5_10million_6m,
  
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1300  ) then 1 end) order_upto_morethan1cr_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1300  ) then 1 end) order_upto_morethan1cr_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1300  ) then 1 end) order_upto_morethan1cr_6m
  
  
  
  
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  and eto_ofr_approv='A'

union all

select

count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 100  ) then 1 end) order_upto_1000_1m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE =100  ) then 1 end) order_upto_1000_3m,
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE =100 ) then 1 end) order_upto_1000_6m,
  
  
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 200  ) then 1 end) order_upto_1000_3000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 200  ) then 1 end) order_upto_1000_3000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 200  ) then 1 end) order_upto_1000_3000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 300  ) then 1 end) order_upto_3000_10000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 300  ) then 1 end) order_upto_3000_10000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 300  ) then 1 end) order_upto_3000_10000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 400  ) then 1 end) order_upto_10000_20000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 400  ) then 1 end) order_upto_10000_20000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 400  ) then 1 end) order_upto_10000_20000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 500  ) then 1 end) order_upto_20000_50000_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 500  ) then 1 end) order_upto_20000_50000_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 500  ) then 1 end) order_upto_20000_50000_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 600  ) then 1 end) order_upto_50000_1lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 600  ) then 1 end) order_upto_50000_1lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 600  ) then 1 end) order_upto_50000_1lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 700  ) then 1 end) order_upto_1_2lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 700  ) then 1 end) order_upto_1_2lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 700  ) then 1 end) order_upto_1_2lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 800  ) then 1 end) order_upto_2_5lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 800  ) then 1 end) order_upto_2_5lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 800  ) then 1 end) order_upto_2_5lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 900  ) then 1 end) order_upto_5_10lakh_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 900  ) then 1 end) order_upto_5_10lakh_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 900  ) then 1 end) order_upto_5_10lakh_6m,
 
 
 
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1000  ) then 1 end) order_upto_1_2million_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1000  ) then 1 end) order_upto_1_2million_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1000  ) then 1 end) order_upto_1_2million_6m,
 
 
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1100  ) then 1 end) order_upto_2_5million_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1100  ) then 1 end) order_upto_2_5million_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1100  ) then 1 end) order_upto_2_5million_6m,
  
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1200  ) then 1 end) order_upto_5_10million_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1200  ) then 1 end) order_upto_5_10million_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1200  ) then 1 end) order_upto_5_10million_6m,
  
  count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-30) )and ETO_OFR_APPROX_ORDER_VALUE = 1300  ) then 1 end) order_upto_morethan1cr_1m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-90) )and ETO_OFR_APPROX_ORDER_VALUE = 1300  ) then 1 end) order_upto_morethan1cr_3m,
 count(case when ( (trunc(ETO_OFR_POSTDATE_ORIG)>= trunc(sysdate-180) )and ETO_OFR_APPROX_ORDER_VALUE = 1300  ) then 1 end) order_upto_morethan1cr_6m
  
  
  
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  and eto_ofr_approv='A'
 
)";
$sth8=oci_parse($dbh,$sql8);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth8,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth8);  
    $rec8=array();
    $rec8=oci_fetch_assoc($sth8);
 //////////////////////lEAD gEN aPP new PDF////////////////////////
   $sql9="select
  ALL_DATES DATESTRING,
  DATEORDERSTRING,
  NVL(SUM(LEAD_GEN),0) LEAD_GEN,
  NVL(SUM(LEAD_APP),0) LEAD_APP
from
(
select
  TO_CHAR(DATE_R,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  0 LEAD_APP
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
and trunc(DATE_R)>= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
GROUP BY
  TO_CHAR(DATE_R,'Mon-YYYY'),
  TO_CHAR(DATE_R,'YYYYMM')
union all
select
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  COUNT(DECODE(eto_ofr_approv,'A',1,NULL)) LEAD_APP
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG) >= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
GROUP BY
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY'),
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'YYYYMM')
union all
select
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  COUNT(DECODE(eto_ofr_approv,'A',1,NULL)) LEAD_APP
from
  ETO_OFR_EXPIRED ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG) >= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
GROUP BY
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY'),
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'YYYYMM')
union all
select
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  COUNT(DECODE(eto_ofr_approv,'A',1,NULL)) LEAD_APP
from
  ETO_OFR_TEMP_DEL ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG) >= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
GROUP BY
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY')
), 
( SELECT TO_CHAR(TRUNC(ADD_MONTHS(SYSDATE,( 1 - LEVEL )),'MON'),'Mon-YYYY') ALL_DATES, 
TO_CHAR(TRUNC(ADD_MONTHS(SYSDATE,( 1 - LEVEL )),'MON'),'YYYYMM') DATEORDERSTRING FROM DUAL CONNECT BY LEVEL < 13 ) ALL_MONTHS
WHERE ALL_DATES = DATESTRING(+)
GROUP BY
  ALL_DATES,
  DATEORDERSTRING
ORDER BY 2";
$sth9=oci_parse($dbh,$sql9);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth9,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth9);  
    $rec9=array();
    oci_fetch_all($sth9,$rec9);
   //var_dump($rec9);
   //////////////////////Active Users new PDF////////////////////////
   $sql10="SELECT ALL_DATES DATESTRING,DATEORDERSTRINGG,nvl(active_users,0) active_users FROM (select
  TO_CHAR(DATE_R,'Mon-YYYY') DATESTRING,
  TO_CHAR(DATE_R,'YYYYMM') DATEORDERSTRING,
  count(distinct FK_GLUSR_USR_ID ) active_users
from
(
select
  DIR_QUERY_FREE.FK_GLUSR_USR_ID,
  DATE_R
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(DATE_R)>=( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
union
select
  ETO_OFR.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
union
select
  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
union
select
  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG
from
  ETO_OFR_TEMP_DEL,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
)
GROUP BY TO_CHAR(DATE_R,'Mon-YYYY'),
  TO_CHAR(DATE_R,'YYYYMM')
  ),
  
  (SELECT TO_CHAR(TRUNC(ADD_MONTHS(SYSDATE,( 1 - LEVEL )),'MON'),'Mon-YYYY') ALL_DATES,
  TO_CHAR(TRUNC(ADD_MONTHS(SYSDATE,( 1 - LEVEL )),'MON'),'YYYYMM') DATEORDERSTRINGG
FROM DUAL CONNECT BY LEVEL < 13)
WHERE ALL_DATES=DATESTRING(+)

ORDER BY 2
";
$sth10=oci_parse($dbh,$sql10);
    /*oci_bind_by_name($sth,':START',$start_date);
   */ oci_bind_by_name($sth10,':FK_IIL_BIG_BUYER_ORG_ID',$oid);
   oci_execute($sth10);  
    $rec10=array();
    oci_fetch_all($sth10,$rec10);
 /* echo '==========================================================================================================';
  var_dump($rec10); 
  echo '==========================================================================================================';
 */ 
  
  //var_dump($rec2);
 /////////////////////////////////////////////////////////////////////////////
  return array('rec'=>$rec,'rec2'=>$rec2,'rec3'=>$rec3,'rec31'=>$rec31,'rec4'=>$rec4,'rec5'=>$rec5,'rec6'=>$rec6,'rec51'=>$rec51,'rec61'=>$rec61,'rec7'=>$rec7,'rec8'=>$rec8,'rec9'=>$rec9,'rec10'=>$rec10,'count'=>$count);
 
 }

  public function bb_search($dbh,$data)
    { $rec=array();
      $count=array();
     $email_domain=$data['bb_domain'];
     $searchby=$data['searchby'];
     if($searchby=='slgl')
     { $sql="WITH T AS
(
SELECT IIL_BIG_BUYER_EMAIL_ID, IIL_BIG_BUYER_EMAIL_DOMAIN, B.FK_IIL_BIG_BUYER_ORG_ID, FK_GLUSR_USR_ID
FROM IIL_BIG_BUYER_EMAIL, IIL_BIG_BUYER_ORG_TO_EMAIL@MESHR B, IIL_BIG_BUYER_TO_GLUSR C
WHERE IIL_BIG_BUYER_EMAIL_DOMAIN = :IIL_BIG_BUYER_EMAIL_DOMAIN 
AND FK_IIL_BIG_BUYER_EMAIL_ID = IIL_BIG_BUYER_EMAIL_ID AND B.FK_IIL_BIG_BUYER_ORG_ID = C.FK_IIL_BIG_BUYER_ORG_ID
)
SELECT FK_GLUSR_USR_ID GLUSR_USR_ID,
--(CASE WHEN LASTWEEK_BL >= 1 AND LAST2WEEK_BL >= 1 AND LAST3WEEK_BL >= 1 AND LAST4WEEK_BL >=1 AND LAST5WEEK_BL >= 1 AND LAST6WEEK_BL >= 1 THEN 1 ELSE 0 END) PLATINUM,
(CASE WHEN LAST1MONTH_BL>=1 AND LAST2MONTH_BL >=1 AND LAST3MONTH_BL >=1 THEN 1 ELSE 0 END) IIL_BIG_BUYER_EMAIL_DOMAIN
--(CASE WHEN LAST1MONTH_BL>=3 AND LAST2MONTH_BL >=3 AND LAST3MONTH_BL >=3 THEN 1 ELSE 0 END) GOLD
FROM    
(
  SELECT
  FK_GLUSR_USR_ID,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-7) AND TRUNC(SYSDATE) THEN ETO_OFR_DISPLAY_ID END) LASTWEEK_BL,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-14) AND TRUNC(SYSDATE-7) THEN ETO_OFR_DISPLAY_ID END) LAST2WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-21) AND TRUNC(SYSDATE-14) THEN ETO_OFR_DISPLAY_ID END) LAST3WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-28) AND TRUNC(SYSDATE-21) THEN ETO_OFR_DISPLAY_ID END) LAST4WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-35) AND TRUNC(SYSDATE-28) THEN ETO_OFR_DISPLAY_ID END) LAST5WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-42) AND TRUNC(SYSDATE-35) THEN ETO_OFR_DISPLAY_ID END) LAST6WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-30) AND TRUNC(SYSDATE) THEN ETO_OFR_DISPLAY_ID END) LAST1MONTH_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-60) AND TRUNC(SYSDATE-30) THEN ETO_OFR_DISPLAY_ID END) LAST2MONTH_BL,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE-60) THEN ETO_OFR_DISPLAY_ID END) LAST3MONTH_BL
  FROM
  (
    SELECT A.FK_GLUSR_USR_ID,DATE_R ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM DIR_QUERY_FREE A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(DATE_R) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR_EXPIRED A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR_TEMP_DEL A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
  )
  GROUP BY FK_GLUSR_USR_ID
) WHERE LAST1MONTH_BL>=1 AND LAST2MONTH_BL >=1 AND LAST3MONTH_BL >=1
";      
     }
      else if($searchby=='plgl')
      {
      $sql="
WITH T AS
(
SELECT IIL_BIG_BUYER_EMAIL_ID, IIL_BIG_BUYER_EMAIL_DOMAIN, B.FK_IIL_BIG_BUYER_ORG_ID, FK_GLUSR_USR_ID
FROM IIL_BIG_BUYER_EMAIL, IIL_BIG_BUYER_ORG_TO_EMAIL@MESHR B, IIL_BIG_BUYER_TO_GLUSR C
WHERE IIL_BIG_BUYER_EMAIL_DOMAIN = :IIL_BIG_BUYER_EMAIL_DOMAIN 
AND FK_IIL_BIG_BUYER_EMAIL_ID = IIL_BIG_BUYER_EMAIL_ID AND B.FK_IIL_BIG_BUYER_ORG_ID = C.FK_IIL_BIG_BUYER_ORG_ID
)
SELECT FK_GLUSR_USR_ID GLUSR_USR_ID,
(CASE WHEN LASTWEEK_BL >= 1 AND LAST2WEEK_BL >= 1 AND LAST3WEEK_BL >= 1 AND LAST4WEEK_BL >=1 AND LAST5WEEK_BL >= 1 AND LAST6WEEK_BL >= 1 THEN 1 ELSE 0 END) IIL_BIG_BUYER_EMAIL_DOMAIN
--(CASE WHEN LAST1MONTH_BL>=1 AND LAST2MONTH_BL >=1 AND LAST3MONTH_BL >=1 THEN 1 ELSE 0 END) SILVER,
--(CASE WHEN LAST1MONTH_BL>=3 AND LAST2MONTH_BL >=3 AND LAST3MONTH_BL >=3 THEN 1 ELSE 0 END) GOLD
FROM    
(
  SELECT
  FK_GLUSR_USR_ID,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-7) AND TRUNC(SYSDATE) THEN ETO_OFR_DISPLAY_ID END) LASTWEEK_BL,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-14) AND TRUNC(SYSDATE-7) THEN ETO_OFR_DISPLAY_ID END) LAST2WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-21) AND TRUNC(SYSDATE-14) THEN ETO_OFR_DISPLAY_ID END) LAST3WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-28) AND TRUNC(SYSDATE-21) THEN ETO_OFR_DISPLAY_ID END) LAST4WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-35) AND TRUNC(SYSDATE-28) THEN ETO_OFR_DISPLAY_ID END) LAST5WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-42) AND TRUNC(SYSDATE-35) THEN ETO_OFR_DISPLAY_ID END) LAST6WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-30) AND TRUNC(SYSDATE) THEN ETO_OFR_DISPLAY_ID END) LAST1MONTH_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-60) AND TRUNC(SYSDATE-30) THEN ETO_OFR_DISPLAY_ID END) LAST2MONTH_BL,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE-60) THEN ETO_OFR_DISPLAY_ID END) LAST3MONTH_BL
  FROM
  (
    SELECT A.FK_GLUSR_USR_ID,DATE_R ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM DIR_QUERY_FREE A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(DATE_R) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR_EXPIRED A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR_TEMP_DEL A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
  )
  GROUP BY FK_GLUSR_USR_ID
) WHERE LASTWEEK_BL >= 1 AND LAST2WEEK_BL >= 1 AND LAST3WEEK_BL >= 1 AND LAST4WEEK_BL >=1 AND LAST5WEEK_BL >= 1 AND LAST6WEEK_BL >= 1";
      }
      else if($searchby=='gogl')
      {
      $sql="
WITH T AS
(
SELECT IIL_BIG_BUYER_EMAIL_ID, IIL_BIG_BUYER_EMAIL_DOMAIN, B.FK_IIL_BIG_BUYER_ORG_ID, FK_GLUSR_USR_ID
FROM IIL_BIG_BUYER_EMAIL, IIL_BIG_BUYER_ORG_TO_EMAIL@MESHR B, IIL_BIG_BUYER_TO_GLUSR C
WHERE IIL_BIG_BUYER_EMAIL_DOMAIN = :IIL_BIG_BUYER_EMAIL_DOMAIN 
AND FK_IIL_BIG_BUYER_EMAIL_ID = IIL_BIG_BUYER_EMAIL_ID AND B.FK_IIL_BIG_BUYER_ORG_ID = C.FK_IIL_BIG_BUYER_ORG_ID
)
SELECT FK_GLUSR_USR_ID GLUSR_USR_ID,
--(CASE WHEN LASTWEEK_BL >= 1 AND LAST2WEEK_BL >= 1 AND LAST3WEEK_BL >= 1 AND LAST4WEEK_BL >=1 AND LAST5WEEK_BL >= 1 AND LAST6WEEK_BL >= 1 THEN 1 ELSE 0 END) PLATINUM,
--(CASE WHEN LAST1MONTH_BL>=1 AND LAST2MONTH_BL >=1 AND LAST3MONTH_BL >=1 THEN 1 ELSE 0 END) SILVER,
(CASE WHEN LAST1MONTH_BL>=3 AND LAST2MONTH_BL >=3 AND LAST3MONTH_BL >=3 THEN 1 ELSE 0 END) IIL_BIG_BUYER_EMAIL_DOMAIN
FROM    
(
  SELECT
  FK_GLUSR_USR_ID,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-7) AND TRUNC(SYSDATE) THEN ETO_OFR_DISPLAY_ID END) LASTWEEK_BL,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-14) AND TRUNC(SYSDATE-7) THEN ETO_OFR_DISPLAY_ID END) LAST2WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-21) AND TRUNC(SYSDATE-14) THEN ETO_OFR_DISPLAY_ID END) LAST3WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-28) AND TRUNC(SYSDATE-21) THEN ETO_OFR_DISPLAY_ID END) LAST4WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-35) AND TRUNC(SYSDATE-28) THEN ETO_OFR_DISPLAY_ID END) LAST5WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-42) AND TRUNC(SYSDATE-35) THEN ETO_OFR_DISPLAY_ID END) LAST6WEEK_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-30) AND TRUNC(SYSDATE) THEN ETO_OFR_DISPLAY_ID END) LAST1MONTH_BL ,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-60) AND TRUNC(SYSDATE-30) THEN ETO_OFR_DISPLAY_ID END) LAST2MONTH_BL,
  COUNT(CASE WHEN TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE-60) THEN ETO_OFR_DISPLAY_ID END) LAST3MONTH_BL
  FROM
  (
    SELECT A.FK_GLUSR_USR_ID,DATE_R ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM DIR_QUERY_FREE A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(DATE_R) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR_EXPIRED A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
    UNION
    SELECT A.FK_GLUSR_USR_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_DISPLAY_ID FROM ETO_OFR_TEMP_DEL A, T B
    WHERE A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID AND ETO_OFR_TYP='B' AND TRUNC(ETO_OFR_POSTDATE_ORIG) BETWEEN TRUNC(SYSDATE-90) AND TRUNC(SYSDATE)
  )
  GROUP BY FK_GLUSR_USR_ID
) WHERE LAST1MONTH_BL>=3 AND LAST2MONTH_BL >=3 AND LAST3MONTH_BL >=3";
      }
      else
      {
          $sql=" select distinct GLUSR_USR_ID,IIL_BIG_BUYER_EMAIL_DOMAIN from GLUSR_USR,IIL_BIG_BUYER_EMAIL
          where   
           IIL_BIG_BUYER_EMAIL_DOMAIN = :IIL_BIG_BUYER_EMAIL_DOMAIN 
           and IIL_BIG_BUYER_EMAIL_DOMAIN=SUBSTR(GLUSR_USR_EMAIL,INSTR(GLUSR_USR_EMAIL,'@')+1)";

       
      }
      $sth=oci_parse($dbh,$sql);
      oci_bind_by_name($sth,':IIL_BIG_BUYER_EMAIL_DOMAIN',$email_domain);
 
      oci_bind_by_name($sth,':IIL_BIG_BUYER_EMAIL_DOMAIN',$email_domain);
    oci_execute($sth);  
     oci_fetch_all($sth,$rec);  
     
     $count=sizeof($rec['GLUSR_USR_ID']);
      $rec['totcount']=$count; 
    return array('rec'=>$rec);
   }
  public function active_user($dbh,$data)
    {  
    $org_id=$data['orgid'];
   $rec=array();
   ///////////////////////6months////////////
  if(isset($data['month_data']) && $data['month_data']=='6')
{


  $sql="select
  FK_GLUSR_USR_ID,
  count(case when trunc(DATE_R)>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) LEAD_POSTED_1M,
  count(case when trunc(DATE_R)>=trunc(sysdate-30) and ETO_OFR_APPROV='A' then FK_GLUSR_USR_ID end) LEAD_APPROV_1M,
  count(case when trunc(DATE_R)>=trunc(sysdate-90) then FK_GLUSR_USR_ID end) LEAD_POSTED_3M,
  count(case when trunc(DATE_R)>=trunc(sysdate-90) and ETO_OFR_APPROV='A' then FK_GLUSR_USR_ID end) LEAD_APPROV_3M,
  count(case when trunc(DATE_R)>=trunc(sysdate-180) then FK_GLUSR_USR_ID end) LEAD_POSTED_6M,
  count(case when trunc(DATE_R)>=trunc(sysdate-180) and ETO_OFR_APPROV='A' then FK_GLUSR_USR_ID end) LEAD_APPROV_6M
from
(
select
  DIR_QUERY_FREE.FK_GLUSR_USR_ID,
  DATE_R,
  'W' ETO_OFR_APPROV
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(DATE_R)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR_TEMP_DEL,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-180)
  AND ETO_OFR_APPROV ='A'
)
group by FK_GLUSR_USR_ID";
}
 else if(isset($data['month_data']) && $data['month_data']=='3')
{

 ///////////////////////3months////////////
    $sql="select
  FK_GLUSR_USR_ID,
  count(case when trunc(DATE_R)>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) LEAD_POSTED_1M,
  count(case when trunc(DATE_R)>=trunc(sysdate-30) and ETO_OFR_APPROV='A' then FK_GLUSR_USR_ID end) LEAD_APPROV_1M,
  count(case when trunc(DATE_R)>=trunc(sysdate-90) then FK_GLUSR_USR_ID end) LEAD_POSTED_3M,
  count(case when trunc(DATE_R)>=trunc(sysdate-90) and ETO_OFR_APPROV='A' then FK_GLUSR_USR_ID end) LEAD_APPROV_3M
  
from
(
select
  DIR_QUERY_FREE.FK_GLUSR_USR_ID,
  DATE_R,
  'W' ETO_OFR_APPROV
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(DATE_R)>=trunc(sysdate-90)
   AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
   AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
   AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR_TEMP_DEL,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-90)
   AND ETO_OFR_APPROV ='A'
)
group by FK_GLUSR_USR_ID";
}
else if(isset($data['month_data']) && $data['month_data']=='1')
{
   ///////////////////////1months////////////
       $sql="select
  FK_GLUSR_USR_ID,
  count(case when trunc(DATE_R)>=trunc(sysdate-30) then FK_GLUSR_USR_ID end) LEAD_POSTED_1M,
  count(case when trunc(DATE_R)>=trunc(sysdate-30) and ETO_OFR_APPROV='A' then FK_GLUSR_USR_ID end) LEAD_APPROV_1M
 
from
(
select
  DIR_QUERY_FREE.FK_GLUSR_USR_ID,
  DATE_R,
  'W' ETO_OFR_APPROV
from
  DIR_QUERY_FREE,
  iil_big_buyer_to_glusr
where
  iil_big_buyer_to_glusr.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and DIR_QUERY_FREE.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(DATE_R)>=trunc(sysdate-30)
   AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-30)
   AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR_EXPIRED.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR_EXPIRED,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-30)
   AND ETO_OFR_APPROV ='A'
union all
select
  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID,
  ETO_OFR_POSTDATE_ORIG,
  ETO_OFR_APPROV
from
  ETO_OFR_TEMP_DEL,
  IIL_BIG_BUYER_TO_GLUSR
where
  IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID=:FK_IIL_BIG_BUYER_ORG_ID
  and ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=iil_big_buyer_to_glusr.FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-30)
   AND ETO_OFR_APPROV ='A'
)
group by FK_GLUSR_USR_ID";
}
   ////////////////////////////////////////////
   $sth=oci_parse($dbh,$sql);
    oci_bind_by_name($sth,':FK_IIL_BIG_BUYER_ORG_ID',$org_id);
    oci_execute($sth);
    oci_fetch_all($sth,$rec);
   //var_dump($rec);
   
   return array('rec'=>$rec);
   }
 
public function org_name_search($dbh,$data)
    { $rec=array();
     $search_text=$data['search_text'];
  $sql="SELECT * FROM (select
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS,
--IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN
replace(wm_concat(IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN),',',', ') IIL_BIG_BUYER_EMAIL_DOMAIN,
count(1) over (partition by 'A') AS CNT
from
IIL_BIG_BUYER_ORG,
IIL_BIG_BUYER_EMAIL,
IIL_BIG_BUYER_ORG_TO_EMAIL@meshr
where
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID=IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_ORG_ID
and IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_EMAIL_ID=IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_ID
group by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS
order by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID
) WHERE lower(IIL_BIG_BUYER_ORG_NAME) LIKE lower('".$search_text."%')";
    
   $sth=oci_parse($dbh,$sql);
    /*oci_bind_by_name($sth,':START',$start_date);
    oci_bind_by_name($sth,':END',$end_date);
    */oci_execute($sth);  
    oci_fetch_all($sth,$rec);
  // var_dump($rec);
   return array('rec'=>$rec);
   } 
/////////////////////BIG BUYER SEARCH REPORT MODEL////////////////////////
public function domain_name_search($dbh,$data)
    { $rec=array();
     $search_text=$data['search_domain'];
  $sql="SELECT * FROM (select
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS,
--IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN
replace(wm_concat(IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_DOMAIN),',',', ') IIL_BIG_BUYER_EMAIL_DOMAIN,
count(1) over (partition by 'A') AS CNT
from
IIL_BIG_BUYER_ORG,
IIL_BIG_BUYER_EMAIL,
IIL_BIG_BUYER_ORG_TO_EMAIL@meshr
where
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID=IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_ORG_ID
and IIL_BIG_BUYER_ORG_TO_EMAIL.FK_IIL_BIG_BUYER_EMAIL_ID=IIL_BIG_BUYER_EMAIL.IIL_BIG_BUYER_EMAIL_ID
group by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_NAME,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ABBR,
IIL_BIG_BUYER_ORG.FK_GL_COUNTRY_ISO,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_REVENUE_BN_DLR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_SECTOR,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_OPER_CAT,
IIL_BIG_BUYER_ORG.FK_GLCAT_GRP_ID,
IIL_BIG_BUYER_ORG.FK_GLCAT_CAT_ID,
IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ALIAS
order by IIL_BIG_BUYER_ORG.IIL_BIG_BUYER_ORG_ID
) WHERE lower(IIL_BIG_BUYER_EMAIL_DOMAIN) LIKE lower('%".$search_text."%')";
    
   $sth=oci_parse($dbh,$sql);
    /*oci_bind_by_name($sth,':START',$start_date);
    oci_bind_by_name($sth,':END',$end_date);
    */oci_execute($sth);  
    oci_fetch_all($sth,$rec);
  // var_dump($rec);
   return array('rec'=>$rec);
   } 
 
 /////////////////////BIG BUYER PDF MODEL////////////////////////
public function bigbuyerPdfReport($dbh,$data)
    { $rec=array();
    $org_id=$data['orgid'];
    // $search_text=$data['search_domain'];
     $sql="SELECT ETO_OFR.ETO_OFR_ID,
  ETO_OFR.ETO_OFR_DISPLAY_ID,
  ETO_OFR.ETO_OFR_TITLE,
  ETO_OFR.ETO_OFR_DATE,
  ETO_OFR.ETO_OFR_DESC,
  ETO_OFR.ETO_OFR_QTY,
  ETO_OFR.ETO_OFR_QTY_UNIT,
  ETO_OFR.ETO_OFR_S_COUNTRY,
  ETO_OFR.FK_GL_COUNTRY_ISO,
  gl_city.gl_city_name ETO_OFR_LOCATION,
  ETO_OFR.ETO_OFR_GL_COUNTRY_NAME,
  ETO_OFR.ETO_OFR_S_STATE,
  ETO_OFR.ETO_OFR_VERIFIED,
  GLUSR_USR.FK_GL_LEGAL_STATUS_ID,
  TO_CHAR(ETO_OFR.ETO_OFR_DATE,'dd Mon, yyyy') AS OFFER_DATE,
  (TRUNC(sysdate) - TRUNC(ETO_OFR_DATE)) DAY_DIFF_CEIL,
  TO_CHAR(ETO_OFR.ETO_OFR_DATE, 'dd MM yyyy HH24 MI') AS OFR_DATE_HR,
  FLOOR(sysdate  - ETO_OFR.ETO_OFR_DATE) DAY_DIFF,
  FLOOR((sysdate - ETO_OFR.ETO_OFR_DATE)*24) HR_DIFF,
  FLOOR((sysdate - ETO_OFR.ETO_OFR_DATE)*24*60) MIN_DIFF,
  TO_CHAR(ETO_OFR.ETO_OFR_POSTDATE_ORIG,'dd Mon, yyyy') AS ETO_OFR_POSTDATE_ORIG_DISP,
  TO_CHAR(ETO_OFR_POSTDATE_ORIG, 'dd Mon, yyyy') ETO_OFR_POSTDATE_ORIG_DISP_IST,
  ETO_OFR.ETO_OFR_SMALL_IMAGE ETO_OFR_SMALL_IMAGE,
  ETO_OFR.ETO_OFR_LARGE_IMAGE ETO_OFR_LARGE_IMAGE,
  ETO_OFR.ETO_OFR_DOC_PATH ETO_OFR_DOC_PATH ,
  'B' TYPE_BT,
  GLUSR_USR.GLUSR_USR_FIRSTNAME
  ||' '
  || GLUSR_USR.GLUSR_USR_LASTNAME USER_NAME ,
  GLUSR_USR.GLUSR_USR_EMAIL,
  GLUSR_USR.GLUSR_USR_PH_MOBILE,
  GLUSR_USR.GLUSR_USR_PH_COUNTRY,
  GLUSR_USR.GLUSR_USR_PH_AREA,
  GLUSR_USR.GLUSR_USR_PH_MOBILE_ALT,
  GLUSR_USR.GLUSR_USR_ADD1,
  GLUSR_USR.GLUSR_USR_ADD2,
  GLUSR_USR.GLUSR_USR_CITY,
  GLUSR_USR.GLUSR_USR_STATE,
  GLUSR_USR.GLUSR_USR_ZIP,
  GLUSR_USR.GLUSR_USR_DESIGNATION
FROM IIL_BIG_BUYER_TO_GLUSR,
  ETO_OFR,
  GLUSR_USR,
  gl_city
WHERE IIL_BIG_BUYER_TO_GLUSR.FK_IIL_BIG_BUYER_ORG_ID = :IIL_BIG_BUYER_ORG_ID
AND ETO_OFR.eto_ofr_typ                              = 'B'
AND ETO_OFR.eto_ofr_approv                           = 'A'
AND IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID           = ETO_OFR.FK_GLUSR_USR_ID
AND IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID           = GLUSR_USR.GLUSR_USR_ID
AND GLUSR_USR.FK_GL_CITY_ID                          =gl_city.gl_city_id(+) 
AND (ETO_OFR.USER_IDENTIFIER_FLAG                    = 6)
AND ROWNUM                                           < 6
ORDER BY ETO_OFR_DATE DESC";
    
   $sth=oci_parse($dbh,$sql);
   oci_bind_by_name($sth,':IIL_BIG_BUYER_ORG_ID',$org_id);
   oci_execute($sth);  
    oci_fetch_all($sth,$rec);
  //var_dump($rec);
  
  $querylogo = "select BIG_BUYER_LOGO_120X120 from iil_big_buyers_logo where BIG_BUYER_ID = :orgiD";
		$sthlogo   = oci_parse($dbh,$querylogo);
		oci_bind_by_name($sthlogo,':orgiD',$org_id);
		oci_execute($sthlogo);
		$reclogo  = oci_fetch_array($sthlogo, OCI_ASSOC+OCI_RETURN_NULLS);
		$reclogo1=$reclogo['BIG_BUYER_LOGO_120X120'];

  $query = "select IIL_BIG_BUYER_ORG_NAME,IIL_BIG_BUYER_OPER_CAT,IIL_BIG_BUYER_OPER_SECTOR,IIL_BIG_BUYER_ORG_ID from iil_big_buyer_org where IIL_BIG_BUYER_ORG_ID = :orgID";
      $sth   = oci_parse($dbh,$query);
      oci_bind_by_name($sth,':orgID',$org_id);
      oci_execute($sth);
      $rec_bbinfo = oci_fetch_array($sth, OCI_ASSOC+OCI_RETURN_NULLS);
 				
  return array('rec'=>$rec,'reclogo'=>$reclogo1,'rec_bbinfo'=>$rec_bbinfo);
   } 
 
//  public function pdf_create($html, $filename, $paper, $orientation)
//     {
//         require_once("dompdf/dompdf_config.inc.php");
//         spl_autoload_register('DOMPDF_autoload');
// 
//         $dompdf = new DOMPDF();
//         $dompdf->load_html($html);
//         $dompdf->set_paper($paper,$orientation);
//         $dompdf->render();        
//         $dompdf->stream($filename.".pdf");        
//     }
//  
 
 

public function bigbuyerReport_glusr($dbh,$data,$dbh_mesh)
    { $rec=array();
    $fK_GLUSR_USR_ID=$data['FK_GLUSR_USR_ID'];
    // $search_text=$data['search_domain'];
     $sql="select
   ALL_DATES DATESTRING,
  DATEORDERSTRING,
  NVL(SUM(LEAD_GEN),0) LEAD_GEN,
  NVL(SUM(LEAD_APP),0) LEAD_APP
from
(
select
  TO_CHAR(DATE_R,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  0 LEAD_APP
from
  DIR_QUERY_FREE
where
  DIR_QUERY_FREE.FK_GLUSR_USR_ID=:FK_GLUSR_USR_ID
  and  trunc(DATE_R)>= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
GROUP BY
  TO_CHAR(DATE_R,'Mon-YYYY'),
  TO_CHAR(DATE_R,'YYYYMM')
union all
select
 TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  COUNT(DECODE(eto_ofr_approv,'A',1,NULL)) LEAD_APP
from
  ETO_OFR 
where
   ETO_OFR.FK_GLUSR_USR_ID=:FK_GLUSR_USR_ID
   and trunc(ETO_OFR_POSTDATE_ORIG) >= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
GROUP BY
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY'),
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'YYYYMM') 
union all
select
 TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  COUNT(DECODE(eto_ofr_approv,'A',1,NULL)) LEAD_APP
from
  ETO_OFR_EXPIRED
where
   ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=:FK_GLUSR_USR_ID
   and trunc(ETO_OFR_POSTDATE_ORIG) >= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)  
GROUP BY
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY'),
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'YYYYMM') 
union all
select
   TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY') DATESTRING,
  count(1) LEAD_GEN,
  COUNT(DECODE(eto_ofr_approv,'A',1,NULL)) LEAD_APP
from
  ETO_OFR_TEMP_DEL
where
  ETO_OFR_TEMP_DEL.FK_GLUSR_USR_ID=:FK_GLUSR_USR_ID
  and trunc(ETO_OFR_POSTDATE_ORIG) >= ( LAST_DAY( ADD_MONTHS(SYSDATE,-12)) + 1)
  GROUP BY
  TO_CHAR(ETO_OFR_POSTDATE_ORIG,'Mon-YYYY')
  )
,
( SELECT TO_CHAR(TRUNC(ADD_MONTHS(SYSDATE,( 1 - LEVEL )),'MON'),'Mon-YYYY') ALL_DATES, TO_CHAR(TRUNC(ADD_MONTHS(SYSDATE,( 1 - LEVEL )),'MON'),'YYYYMM') DATEORDERSTRING
FROM DUAL CONNECT BY LEVEL < 13 ) ALL_MONTHS
WHERE ALL_DATES = DATESTRING(+)
GROUP BY
  ALL_DATES,
  DATEORDERSTRING
ORDER BY 2";
    
   $sth=oci_parse($dbh,$sql);
   oci_bind_by_name($sth,':FK_GLUSR_USR_ID',$fK_GLUSR_USR_ID);
   oci_execute($sth);  
    oci_fetch_all($sth,$rec);
  //var_dump($rec);

  $query_orgid = "select FK_IIL_BIG_BUYER_ORG_ID from iil_big_buyer_to_glusr where FK_GLUSR_USR_ID=:FK_GLUSR_USR_ID";
		$sth_orgid   = oci_parse($dbh,$query_orgid);
		oci_bind_by_name($sth_orgid,':FK_GLUSR_USR_ID',$fK_GLUSR_USR_ID);
		oci_execute($sth_orgid);
		$recid  = oci_fetch_array($sth_orgid, OCI_ASSOC+OCI_RETURN_NULLS);
		$recid1=$recid['FK_IIL_BIG_BUYER_ORG_ID'];


$query_glinfo = "select GLUSR_USR_FIRSTNAME||' '||GLUSR_USR_MIDDLENAME ||' '||GLUSR_USR_LASTNAME as GLUSR_USR_FIRSTNAME1 ,GLUSR_USR_ADD1,GLUSR_USR_STATE,GLUSR_USR_COUNTRYNAME,TO_CHAR(GLUSR_USR_LASTLOGIN,'dd-Mon-yyyy') GLUSR_USR_LASTLOGIN,(select count(1) from glusr_login_stats where GLUSR_STATS_USER_ID=GLUSR_USR_ID) GLUSR_USR_LOGINCOUNT,FREESHOWROOM_URL,
    DECODE(LTRIM(GLUSR_USR_PH_NUMBER), NULL, NULL, ('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH_AREA, NULL, NULL,'(' || GLUSR_USR_PH_AREA || ')' || '-') || GLUSR_USR_PH_NUMBER )) GLUSR_PHONE1,
    DECODE(LTRIM(GLUSR_USR_PH2_NUMBER), NULL, NULL, ('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || DECODE(GLUSR_USR_PH2_AREA, NULL, NULL,'(' || GLUSR_USR_PH2_AREA || ')' || '-') || GLUSR_USR_PH2_NUMBER )) GLUSR_PHONE2,
                DECODE(GLUSR_USR_PH_MOBILE, NULL, NULL, ('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || GLUSR_USR_PH_MOBILE)) GLUSR_MOBILE1,
                DECODE(GLUSR_USR_PH_MOBILE_ALT, NULL, NULL, ('+' || '(' || GLUSR_USR_PH_COUNTRY || ')' || '-' || GLUSR_USR_PH_MOBILE_ALT)) GLUSR_MOBILE2,
                GLUSR_USR_EMAIL 
                from glusr_usr where GLUSR_USR_ID=:GLUSR_USR_ID";
		$sth_glinfo   = oci_parse($dbh_mesh,$query_glinfo);
		oci_bind_by_name($sth_glinfo,':GLUSR_USR_ID',$fK_GLUSR_USR_ID);
		oci_execute($sth_glinfo);  
                oci_fetch_all($sth_glinfo,$rec_glinfo);


$querylogo = "select BIG_BUYER_LOGO_120X120 from iil_big_buyers_logo where BIG_BUYER_ID = :orgiD";
		$sthlogo   = oci_parse($dbh,$querylogo);
		oci_bind_by_name($sthlogo,':orgiD',$recid1);

		oci_execute($sthlogo);
		$reclogo  = oci_fetch_array($sthlogo, OCI_ASSOC+OCI_RETURN_NULLS);
		$reclogo1=$reclogo['BIG_BUYER_LOGO_120X120'];

  $query = "select IIL_BIG_BUYER_ORG_NAME,IIL_BIG_BUYER_OPER_CAT,IIL_BIG_BUYER_OPER_SECTOR,IIL_BIG_BUYER_ORG_ID,DECODE(IIL_BIG_BUYER_ORG_ALIAS,NULL,'','https://www.indiamart.com/bigbuyer/'|| IIL_BIG_BUYER_ORG_ALIAS || '/') BB_URL from iil_big_buyer_org where IIL_BIG_BUYER_ORG_ID = :orgID";
      $sth   = oci_parse($dbh,$query);

      oci_bind_by_name($sth,':orgID',$recid1);
      oci_execute($sth);
      $rec_bbinfo = oci_fetch_array($sth, OCI_ASSOC+OCI_RETURN_NULLS);
 			
  $sql_product_buy = "SELECT GLUSR_BUYPRD_ID,
					GLUSR_BUYPRD_NAME,
					GLUSR_BUYPRD_APPROX_ORDER,
					GLUSR_BUYPRD_REQ_FREQ,
					GLUSR_BUYPRD_LOC_PREF,
					GLUSR_BUYPRD_LOC_CITY1,
					GLUSR_BUYPRD_LOC_CITY2,
					GLUSR_BUYPRD_LOC_CITY3,
					GLUSR_BUYPRD_QTY 
				FROM
					GLUSR_BUY_PRODUCTS
					WHERE FK_GLUSR_USR_ID=:GLUSR_ID order by GLUSR_BUYPRD_ID DESC";
      $sth = oci_parse($dbh_mesh,$sql_product_buy);
      oci_bind_by_name($sth,':GLUSR_ID',$fK_GLUSR_USR_ID);
      oci_execute($sth);    
//Top 3 Mcat
    $sql_top_mcat = "SELECT (SELECT GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID= FK_GLCAT_MCAT_ID) MCAT_NAME, 
        CNT,
        NVL(LIVE_CNT_MCAT_BL,0) LIVE_CNT_MCAT_BL,
        MCAT_TEMP.FK_GLCAT_MCAT_ID,
        (SELECT COUNT(DISTINCT FK_GLUSR_USR_ID) CNT FROM ETO_TRD_ALERT_V2 WHERE FK_GLCAT_MCAT_ID=MCAT_TEMP.FK_GLCAT_MCAT_ID) CNT_SUPPLIER,
        (SELECT COUNT(DISTINCT ETO_OFR_DISPLAY_ID) CNT FROM ETO_OFR WHERE FK_GLCAT_MCAT_ID=MCAT_TEMP.FK_GLCAT_MCAT_ID) CNT_BL  
  FROM (
  SELECT FK_GLCAT_MCAT_ID,
  COUNT(1) CNT,
  (CASE WHEN FLAG=1 THEN 1 ELSE NULL END) LIVE_CNT_MCAT_BL  
  FROM (
  SELECT 
    1 FLAG,ETO_OFR_DISPLAY_ID,
    FK_GLCAT_MCAT_ID 
  FROM ETO_OFR   
   WHERE ETO_OFR_TYP                 = 'B'  
  AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(SYSDATE-365)
  AND FK_GLUSR_USR_ID=:GLUSR_ID 
  UNION
   SELECT 
    2 FLAG, ETO_OFR_DISPLAY_ID,
    FK_GLCAT_MCAT_ID 
  FROM ETO_OFR_EXPIRED   
   WHERE ETO_OFR_TYP                 = 'B'  
  AND TRUNC(ETO_OFR_POSTDATE_ORIG) >= TRUNC(SYSDATE-365)
  AND FK_GLUSR_USR_ID=:GLUSR_ID 
 
) GROUP BY FK_GLCAT_MCAT_ID,FLAG ORDER BY COUNT(1) DESC
) MCAT_TEMP

";
      $sth_top_mcat = oci_parse($dbh,$sql_top_mcat);
      oci_bind_by_name($sth_top_mcat,':GLUSR_ID',$fK_GLUSR_USR_ID);
      oci_execute($sth_top_mcat);   

      
$query_ordervalue = "select ETO_OFR_APPROX_ORDER_VALUE,ETO_OFR_APPROX_ORDER_VAL_ORIG from (
select ETO_OFR_APPROX_ORDER_VAL_ORIG,ETO_OFR_APPROX_ORDER_VALUE from 
(
select distinct ETO_OFR_APPROX_ORDER_VAL_ORIG,ETO_OFR_APPROX_ORDER_VALUE from ETO_OFR where  ETO_OFR.FK_GLUSR_USR_ID=:GLUSR_ID  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-365)  and eto_ofr_approv='A'  and ETO_OFR_APPROX_ORDER_VALUE is not null and ETO_OFR_APPROX_ORDER_VAL_ORIG IS NOT NULL    
union all
select distinct ETO_OFR_APPROX_ORDER_VAL_ORIG,ETO_OFR_APPROX_ORDER_VALUE from  ETO_OFR_EXPIRED   where  FK_GLUSR_USR_ID=:GLUSR_ID and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-365)  and eto_ofr_approv='A' and ETO_OFR_APPROX_ORDER_VALUE is not null and ETO_OFR_APPROX_ORDER_VAL_ORIG IS NOT NULL  
) ORDER BY ETO_OFR_APPROX_ORDER_VALUE DESC 
) WHERE ROWNUM<4  ";
$sthordervalue   = oci_parse($dbh,$query_ordervalue);
oci_bind_by_name($sthordervalue,':GLUSR_ID',$fK_GLUSR_USR_ID);
oci_execute($sthordervalue);

$supp_intro='';               
$query_supp_intro = "select count(1) CNT from dir_query@enqdbr.intermesh.net where FK_GLUSR_USR_ID = :GLUSR_ID and trunc(DATE_R)>=trunc(DATE_R-365)";
$sthsupp_intro   = oci_parse($dbh,$query_supp_intro);
oci_bind_by_name($sthsupp_intro,':GLUSR_ID',$fK_GLUSR_USR_ID);

oci_execute($sthsupp_intro);
$recsupp_intro = oci_fetch_array($sthsupp_intro, OCI_ASSOC+OCI_RETURN_NULLS);
$supp_intro=$recsupp_intro['CNT'];




                   
  return array('rec'=>$rec,'rec_glinfo' => $rec_glinfo,'reclogo'=>$reclogo,'rec_bbinfo' => $rec_bbinfo,'rec_product_buy'=>$sth,'sth_top_mcat'=>$sth_top_mcat,'ordervalue'=>$sthordervalue,'supp_intro'=>$supp_intro);

   } 
 
//  public function pdf_create($html, $filename, $paper, $orientation)
//     {
//         require_once("dompdf/dompdf_config.inc.php");
//         spl_autoload_register('DOMPDF_autoload');
// 
//         $dompdf = new DOMPDF();
//         $dompdf->load_html($html);
//         $dompdf->set_paper($paper,$orientation);
//         $dompdf->render();        
//         $dompdf->stream($filename.".pdf");        
//     }
//  
 
public function latestBL($dbh,$data,$cnt=5)
    { 
    $rec=array();    
    $sql="SELECT ETO_OFR.ETO_OFR_ID,
  ETO_OFR.ETO_OFR_DISPLAY_ID,
  ETO_OFR.ETO_OFR_TITLE,
  ETO_OFR.ETO_OFR_DATE,
  ETO_OFR.ETO_OFR_DESC,
  ETO_OFR.ETO_OFR_QTY,
  ETO_OFR.ETO_OFR_QTY_UNIT,
  ETO_OFR.ETO_OFR_S_COUNTRY,
  ETO_OFR.FK_GL_COUNTRY_ISO,
  gl_city.gl_city_name ETO_OFR_LOCATION,
  ETO_OFR.ETO_OFR_GL_COUNTRY_NAME,
  ETO_OFR.ETO_OFR_S_STATE,
  ETO_OFR.ETO_OFR_VERIFIED,
  GLUSR_USR.FK_GL_LEGAL_STATUS_ID,
  TO_CHAR(ETO_OFR.ETO_OFR_DATE,'dd Mon, yyyy') AS OFFER_DATE,
  (TRUNC(sysdate) - TRUNC(ETO_OFR_DATE)) DAY_DIFF_CEIL,
  TO_CHAR(ETO_OFR.ETO_OFR_DATE, 'dd MM yyyy HH24 MI') AS OFR_DATE_HR,
  FLOOR(sysdate  - ETO_OFR.ETO_OFR_DATE) DAY_DIFF,
  FLOOR((sysdate - ETO_OFR.ETO_OFR_DATE)*24) HR_DIFF,
  FLOOR((sysdate - ETO_OFR.ETO_OFR_DATE)*24*60) MIN_DIFF,
  TO_CHAR(ETO_OFR.ETO_OFR_POSTDATE_ORIG,'dd Mon, yyyy') AS ETO_OFR_POSTDATE_ORIG_DISP,
  TO_CHAR(ETO_OFR_POSTDATE_ORIG, 'dd Mon, yyyy') ETO_OFR_POSTDATE_ORIG_DISP_IST,
  ETO_OFR.ETO_OFR_SMALL_IMAGE ETO_OFR_SMALL_IMAGE,
  ETO_OFR.ETO_OFR_LARGE_IMAGE ETO_OFR_LARGE_IMAGE,
  ETO_OFR.ETO_OFR_DOC_PATH ETO_OFR_DOC_PATH ,
  'B' TYPE_BT,
  GLUSR_USR.GLUSR_USR_FIRSTNAME
  ||' '
  || GLUSR_USR.GLUSR_USR_LASTNAME USER_NAME ,
  GLUSR_USR.GLUSR_USR_EMAIL,
  GLUSR_USR.GLUSR_USR_PH_MOBILE,
  GLUSR_USR.GLUSR_USR_PH_COUNTRY,
  GLUSR_USR.GLUSR_USR_PH_AREA,
  GLUSR_USR.GLUSR_USR_PH_MOBILE_ALT,
  GLUSR_USR.GLUSR_USR_ADD1,
  GLUSR_USR.GLUSR_USR_ADD2,
  GLUSR_USR.GLUSR_USR_CITY,
  GLUSR_USR.GLUSR_USR_STATE,
  GLUSR_USR.GLUSR_USR_ZIP,
  GLUSR_USR.GLUSR_USR_DESIGNATION
FROM IIL_BIG_BUYER_TO_GLUSR,
  ETO_OFR,
  GLUSR_USR,
  gl_city
WHERE GLUSR_USR.GLUSR_USR_ID = :GLUSR_USR_ID
AND ETO_OFR.eto_ofr_typ                              = 'B'
AND ETO_OFR.eto_ofr_approv                           = 'A'
AND IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID           = ETO_OFR.FK_GLUSR_USR_ID
AND IIL_BIG_BUYER_TO_GLUSR.FK_GLUSR_USR_ID           = GLUSR_USR.GLUSR_USR_ID
AND GLUSR_USR.FK_GL_CITY_ID                          = gl_city.gl_city_id(+)
AND (ETO_OFR.USER_IDENTIFIER_FLAG                    = 6)
AND ROWNUM                                           < :CNT 
ORDER BY ETO_OFR_DATE DESC";
    
   $sth=oci_parse($dbh,$sql);
   oci_bind_by_name($sth,':GLUSR_USR_ID',$data['FK_GLUSR_USR_ID']);
   oci_bind_by_name($sth,':CNT',$cnt);
   oci_execute($sth);  
    oci_fetch_all($sth,$rec);
    return $rec;
    }
    
    
public function feedbackByGLID($dbh,$data){
     /***********************************************************************/   
    $sql="select
  sum(FULL_FEEDBACK_1Y) FULL_FEEDBACK_1Y 
from
(
select
  count(1) FULL_FEEDBACK_1Y    
from
  BUYER_REQUIREMENT_OVER,
  dir_query_free
where
  FK_GLUSR_USR_ID=:GLUSR_USR_ID
  and DIR_QUERY_FREE.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(DATE_R)>=trunc(sysdate-120)
union all
select
  count(1) FULL_FEEDBACK_1Y 
from
  BUYER_REQUIREMENT_OVER,  
  eto_ofr
where
  FK_GLUSR_USR_ID=:GLUSR_USR_ID 
  and eto_ofr.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-120)
union all
select
  count(1) FULL_FEEDBACK_1Y 
from
  BUYER_REQUIREMENT_OVER,
  eto_ofr_expired
where
  FK_GLUSR_USR_ID=:GLUSR_USR_ID
  and eto_ofr_expired.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-120)
union all
select
  count(1) FULL_FEEDBACK_1Y 
from
  BUYER_REQUIREMENT_OVER,
  eto_ofr_TEMP_DEL
where
  FK_GLUSR_USR_ID=:GLUSR_USR_ID
  and eto_ofr_TEMP_DEL.eto_ofr_display_id=BUYER_REQ_OVR_OFR_DISPLAY_ID
  and BUYER_REQ_OVR_SUP_GLUSR_ID not in (111,222,333,-555,-888,-1,-999)
  and NVL(BUYER_REQ_OVR_BUY_TLF_MAPID,0) = 0
  and NVL(BUYER_REQ_OVR_ORIGINAL_ENQID,0)= 0
  and trunc(ETO_OFR_POSTDATE_ORIG)>=trunc(sysdate-120)
)";
        $sth=oci_parse($dbh,$sql);
        oci_bind_by_name($sth,':GLUSR_USR_ID',$data['FK_GLUSR_USR_ID']);
        oci_execute($sth);  
        $rec = oci_fetch_array($sth, OCI_ASSOC+OCI_RETURN_NULLS);
        return $rec;
}   


public function getProductListByGLID($glid, $dataFrom, $dataTo) {
        try {
            if ($glid != "") {
                $ch = curl_init();
                $data = array('gluserid' => $glid,'from' => $dataFrom,'to' => $dataTo,'token' => 'imobile@15061981','mod_id' => 'GLADMIN');  
                curl_setopt($ch, CURLOPT_URL, 'http://mapi.indiamart.com/wservce/products/userlisting/');
                
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                
                curl_setopt($ch, CURLOPT_USERPWD, "admin:admin");                
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
                $response = curl_exec($ch);
                curl_close($ch);
                $dataProvider = (array) json_decode($response, true);
               
                $str_product='';
                
                for($i=0;$i < count($dataProvider);$i++){
                    $str_product .= $i+1 .'- '. $dataProvider[$i]['ITEM_NAME'].'<br>';
                }              
               
                return $str_product;
            }            
        } catch (Exception $e) {
            Yii::log($e->getMessage(), CLogger::LEVEL_ERROR);
        }
}
    
    
    
}


?>