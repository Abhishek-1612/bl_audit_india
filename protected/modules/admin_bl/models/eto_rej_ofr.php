<?php

class eto_rej_ofr extends CFormModel
{

	public function saveEmpDetails($imenq,$glmodel,$arg,$emp_id,$bothArr)
    {
		$query_id=!empty($bothArr[0]) ?  $bothArr[0] : '';
		$empid=!empty($bothArr[1]) ?  $bothArr[1] : '';
		$sql_check="select count(1) CNT from IIL_ENQ_FEEDBACKS_RESOLUTION where FK_IIL_ENQUIRY_FEEDBACK_ID=:query_id";
		$bind['query_id']=$query_id;

		$sth_check = $glmodel->runSelect(__FILE__, __LINE__, __CLASS__, $imenq, $sql_check, $bind);
		$count_data=$sth_check->read();
		if($count_data['CNT']==0) 
		{     
			
		 if(!empty($query_id)) 
		 {
			 
				
			 $sql="INSERT
					 INTO IIL_ENQ_FEEDBACKS_RESOLUTION
				   (
					 FK_IIL_ENQUIRY_FEEDBACK_ID,
					 IIL_ENQ_FEEDBACKS_DATE,
					 IIL_ENQ_FEEDBACKS_BY_EMPLOYEE
					 )
				   VALUES
				   (
					 $query_id,    
					 SYSDATE,
					 $empid
				   )";
			
			 $sth = $glmodel->ExecQuery(__FILE__, __LINE__, __CLASS__, $imenq, $sql,array());
			//  echo "<pre>";print_r($sth);
			 if($sth) {
			   $glEtoModel = new Globalconnection();   
			   $dbh2=$glEtoModel->connectPostgres_wr();
			   $con=$dbh2;
			   if($con)
			   {
				//    echo "Hi";
				   $sql_inst_acc_log = "INSERT
					 INTO IIL_ENQ_FEEDBACKS_RESOLUTION
				   (
					 FK_IIL_ENQUIRY_FEEDBACK_ID,
					 IIL_ENQ_FEEDBACKS_DATE,
					 IIL_ENQ_FEEDBACKS_BY_EMPLOYEE
					 )
				   VALUES
				   (
					 $1, 
					 now(),
					 $2
				   )";
							   $r=pg_query_params($con,$sql_inst_acc_log,array($query_id,$empid));
							//    echo "<pre>";print_r($r);
							   if($r)  
							   {
								   pg_query($con, 'COMMIT');
							   }
			   }
			 return  'Yes';
			
			 }
			 else {
			 return  'No';
			 }
		 }
	   }else{
		if(!empty($query_id)) {

   
			$bind2=array();
			$sql="UPDATE IIL_ENQ_FEEDBACKS_RESOLUTION
					SET 
					  IIL_ENQ_FEEDBACKS_DATE      =SYSDATE,
					  IIL_ENQ_FEEDBACKS_BY_EMPLOYEE=:EMP_ID
					  where FK_IIL_ENQUIRY_FEEDBACK_ID = :FK_IIL_ENQUIRY_FEEDBACK_ID";
			$bind2[':FK_IIL_ENQUIRY_FEEDBACK_ID']=$query_id;
			$bind2[':EMP_ID']=$empid;
		 
		 $sth = $glmodel->ExecQuery(__FILE__, __LINE__, __CLASS__, $imenq, $sql,$bind2); 
		 if($sth) {
			  $glEtoModel = new Globalconnection();   
		  $dbh2=$glEtoModel->connectPostgres_wr();
		  $con=$dbh2;
		 $sql = "UPDATE IIL_ENQ_FEEDBACKS_RESOLUTION
					SET 
					 
					  IIL_ENQ_FEEDBACKS_DATE      =now(),
					  IIL_ENQ_FEEDBACKS_BY_EMPLOYEE=$1
					  where FK_IIL_ENQUIRY_FEEDBACK_ID = $2";
			$r=pg_query_params($con,$sql,array($empid,$query_id));
			if($r)
			{
					pg_query($con, 'COMMIT');
			}
		   return  'Yes';   
		  
		 }
		 else {
			return  'No';  
		 }
		}

			}

	}
	
	public function getFirstTable($action,$dbh,$dbh1)
    { 
		$obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
        }

   
	 $sql='';
	 $sql="SELECT * from
	 (SELECT FK_GLUSR_USR_ID Supplier_GLID,Rej_cnt_Top20_Yesterday,count(1) Rej_cnt_Top20_30Days     
	 from (
	   SELECT GLID Supplier_GLID,sum(CNT) Rej_cnt_Top20_Yesterday
	   FROM
		   (
			SELECT REJ.FK_GLUSR_USR_ID GLID,
				   count(1) CNT
			FROM   ETO_OFR ofr,
				   ETO_OFR_REJECTED rej,
				   eto_ofr_rej_search_analysis page,
				   (select FK_CUST_TO_SERV_GLUSR_ID,
				   max(CUST_TO_SERV_STARTDATE) CUST_TO_SERV_STARTDATE 
					from   service,cust_to_serv
					where  SERVICE_ID = FK_SERVICE_ID
						 and FK_CUSTTYPE_ID in (1,2,12,10)
						 and FK_CUSTTYPE_WEIGHT<=1000
						 and CUST_TO_SERV_ENABLED=-1
					group by FK_CUST_TO_SERV_GLUSR_ID)A
			WHERE  rej.FK_ETO_OFR_ID = ofr.ETO_OFR_DISPLAY_ID
				   AND DATE(ETO_OFR_REJECT_DT) = DATE(NOW())-1
				   AND rej.FK_GLUSR_USR_ID = A.FK_CUST_TO_SERV_GLUSR_ID
				   AND rej.ETO_OFR_REJECT_REASON in ('1') ";
		if($action == 'great90'){
			$sql .= " AND date(ETO_OFR_REJECT_DT) -  date(CUST_TO_SERV_STARTDATE)>90 ";
		}else{
			$sql .= " AND date(ETO_OFR_REJECT_DT) -  date(CUST_TO_SERV_STARTDATE)<=90 ";
		}
     
		$sql .= " AND ETO_OFR_DISPLAY_POSITION between 1 and 20
		AND page.ETO_OFR_REJECT_SRCH_PAGE = 'relevant'
		AND page.fk_eto_ofr_id=rej.fk_eto_ofr_id
		AND page.fk_glusr_usr_id=rej.fk_glusr_usr_id 
 GROUP BY REJ.FK_GLUSR_USR_ID
 UNION  ALL
 SELECT REJ.FK_GLUSR_USR_ID GLID,
		count(1) CNT
 FROM   ETO_OFR_EXPIRED ofr,
		ETO_OFR_REJECTED rej,
		eto_ofr_rej_search_analysis page,
		(select FK_CUST_TO_SERV_GLUSR_ID,max(CUST_TO_SERV_STARTDATE) CUST_TO_SERV_STARTDATE 
		 from   service,cust_to_serv
		 where  SERVICE_ID = FK_SERVICE_ID
			  and FK_CUSTTYPE_ID in (1,2,12,10)
			  and FK_CUSTTYPE_WEIGHT<=1000
			  and CUST_TO_SERV_ENABLED=-1
		 group by FK_CUST_TO_SERV_GLUSR_ID)A
 WHERE  rej.FK_ETO_OFR_ID = ofr.ETO_OFR_DISPLAY_ID
		AND DATE(ETO_OFR_REJECT_DT) = DATE(NOW())-1
		AND rej.FK_GLUSR_USR_ID = A.FK_CUST_TO_SERV_GLUSR_ID
		AND rej.ETO_OFR_REJECT_REASON in ('1') ";

		if($action == 'great90')
		$sql .= " AND date(ETO_OFR_REJECT_DT) -  date(CUST_TO_SERV_STARTDATE)>90 ";
		else
		$sql .= " AND date(ETO_OFR_REJECT_DT) -  date(CUST_TO_SERV_STARTDATE)<=90 ";	
		$sql .= " AND ETO_OFR_DISPLAY_POSITION between 1 and 20
		AND page.ETO_OFR_REJECT_SRCH_PAGE = 'relevant'
		AND page.fk_eto_ofr_id=rej.fk_eto_ofr_id
		AND page.fk_glusr_usr_id=rej.fk_glusr_usr_id 
		AND ETO_OFR_REJECT_DT < LEAST(ETO_OFR_DELETIONDATE,ETO_OFR_EXP_DATE)
 GROUP BY REJ.FK_GLUSR_USR_ID)eto_ofr_agency_code_tbd
GROUP BY GLID
HAVING sum(CNT)>=3) A,
ETO_OFR_REJECTED REJ
WHERE  A.Supplier_GLID=REJ.FK_GLUSR_USR_ID
  and DATE(ETO_OFR_REJECT_DT) between DATE(NOW())-31 and DATE(NOW())-1
  AND ETO_OFR_REJECT_REASON in ('1')
GROUP BY FK_GLUSR_USR_ID,Rej_cnt_Top20_Yesterday
ORDER BY Rej_cnt_Top20_Yesterday DESC )eto_ofr_approv_by_orig LIMIT 100 ";
	$bind = array();
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind);
   $results =array();
while($results1 = $sth->read()) {
	$results1=array_change_key_case($results1, CASE_UPPER);  
	array_push($results,$results1);                  
}
   


	$output =[];
	foreach($results as $row){
		if(isset($row['SUPPLIER_GLID'])){
			$glmodel = new GlobalmodelForm();
			$sql1 = "select employeeid,employeename
					from
						(
						select distinct iil_enq_feedbacks_by_employee,max(iil_enq_feedbacks_date) 
						from   IIL_ENQ_FEEDBACKS_RESOLUTION
						where fk_iil_enquiry_feedback_id= :glid
						group by iil_enq_feedbacks_by_employee)A,
						Employee
					where employeeid=iil_enq_feedbacks_by_employee
					   and working=-1
					   limit 1";

			$sth1 = $glmodel->runSelect(__FILE__, __LINE__, __CLASS__, $dbh1, $sql1, array("glid"=>$row['SUPPLIER_GLID']));
			$ha = $sth1->readAll();
			$count = count($ha);

			if($ha){
				$row['employeeid'] = $ha[0]['employeeid'];
				$row['employeename'] = $ha[0]['employeename'];
			} 
			$output[]=$row;
			// echo "<pre>";print_r($row);
		}

	}
	// exit;
	$data['data'] = $output;
	return $data;

	}

	public function dropdowndata($dbh)
    {
		$empForBLNI=CommonVariable::get_employee_for_blni(); 
     
        // $sql = "select employeeid,employeename from employee
		// where working=-1
		//   and managerid in (4974,20683)";

		// $sth = $glmodel->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		// $ha = $sth->readAll();
//    echo "<pre>";print_r($ha); exit; 
	
	$dropDown['employee'] = $empForBLNI;
	return $dropDown;

	}
   public function offerdetails($offerid)
   {       
             $sql = "SELECT
             T.ETO_OFR_TITLE,
             T.ETO_OFR_DESC,
             T.ETO_OFR_QTY,
             T.ETO_OFR_CALL_VERIFIED,
             T.ETO_OFR_EMAIL_VERIFIED,
             T.FK_GLUSR_USR_ID,       
             T.ETO_OFR_POSTDATE_ORIG POST_DATE,            
             GLUSR_USR_CITY,GLUSR_USR_STATE,GLUSR_USR_COUNTRYNAME,ETO_OFR_POSTEDBYEMPLOYEE,GL_EMP_NAME
             FROM 
             (
             SELECT
             ETO_OFR_DISPLAY_ID,(case when ETO_OFR_POSTEDBYEMPLOYEE='0' then FK_EMPLOYEE_LOCK_ID 
             when ETO_OFR_POSTEDBYEMPLOYEE='0' then ETO_OFR_POSTEDBYEMPLOYEE end) as ETO_OFR_POSTEDBYEMPLOYEE,
             FK_GLUSR_USR_ID,
             ETO_OFR_TITLE,
             ETO_OFR_DESC,
		ETO_OFR_QTY,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,
             ETO_OFR_GLCAT_MCAT_NAME,
             ETO_OFR_POSTDATE_ORIG
             FROM ETO_OFR
             WHERE eto_ofr_display_id = $offerid 
             UNION ALL 
             SELECT
             ETO_OFR_DISPLAY_ID,(case when ETO_OFR_POSTEDBYEMPLOYEE='0' then FK_EMPLOYEE_LOCK_ID 
             when ETO_OFR_POSTEDBYEMPLOYEE='0' then ETO_OFR_POSTEDBYEMPLOYEE end) as ETO_OFR_POSTEDBYEMPLOYEE,
               FK_GLUSR_USR_ID,
             ETO_OFR_TITLE,
             ETO_OFR_DESC,
             ETO_OFR_QTY,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,
             ETO_OFR_GLCAT_MCAT_NAME,
             ETO_OFR_POSTDATE_ORIG
             FROM ETO_OFR_EXPIRED
             WHERE eto_ofr_display_id = $offerid 
             UNION ALL 
             SELECT
             ETO_OFR_DISPLAY_ID,(case when ETO_OFR_POSTEDBYEMPLOYEE='0' then FK_EMPLOYEE_LOCK_ID 
             when ETO_OFR_POSTEDBYEMPLOYEE='0' then ETO_OFR_POSTEDBYEMPLOYEE end) as ETO_OFR_POSTEDBYEMPLOYEE,
             FK_GLUSR_USR_ID,
             ETO_OFR_TITLE,
             ETO_OFR_DESC,
	     ETO_OFR_QTY,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,
             ETO_OFR_GLCAT_MCAT_NAME,
             ETO_OFR_POSTDATE_ORIG
             FROM ETO_OFR_TEMP_DEL
             WHERE eto_ofr_display_id = $offerid 
             ) T join glusr_usr on T.FK_GLUSR_USR_ID=GLUSR_USR_ID left outer join GL_EMP on ETO_OFR_POSTEDBYEMPLOYEE=GL_EMP_ID              
             ORDER BY ETO_OFR_DISPLAY_ID
             ";
          $model = new GlobalmodelForm();
           $obj = new Globalconnection();
       if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
         $rec = array();
         $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
             
         while($rec1=$sth->read())
            { 
            $rec=array_change_key_case($rec1, CASE_UPPER);
            }
             
             return $rec;
		 }
		 
		 public function mcatData($dbh ,$glid,$sdate,$tdate)
    {
		$obj = new Globalconnection();
		$model = new GlobalmodelForm();
		
		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
        }
   
     $sql='';
     
        $sql = "SELECT MCAT_ID,
		mcat_name,
		ETO_TRD_ALERT_RANK Mcat_Rank,
		
		BLNI_Total,  
		BLNI_Prime,                  
		BLNI_Non_Prime,
		Txn_Total,
		Txn_Prime,
		Txn_Non_Prime
 from
 (
 select MCAT_ID,
		mcat_name,
		ETO_TRD_ALERT_RANK,
		sum(BLNI_Total) BLNI_Total,  
		sum(BLNI_Prime) BLNI_Prime,                  
		sum(BLNI_Non_Prime) BLNI_Non_Prime,
		sum(Txn_Total) Txn_Total,
		sum(Txn_Prime) Txn_Prime,
		sum(Txn_Non_Prime) Txn_Non_Prime
 from
	 (
	   select B.FK_GLCAT_MCAT_ID MCAT_ID,
(select glcat_mcat_name from glcat_mcat where B.FK_GLCAT_MCAT_ID = glcat_mcat_id) mcat_name,
			  ETO_TRD_ALERT_RANK,          
			  (coalesce(BLNI_Non_Prime,0)+coalesce(BLNI_Prime,0)) BLNI_Total,  
			  coalesce(BLNI_Prime,0) BLNI_Prime,                  
			  coalesce(BLNI_Non_Prime,0) BLNI_Non_Prime,
			  0 Txn_Total,
			  0 Txn_Prime,
			  0 Txn_Non_Prime
	   from      
			   (
				select FK_GLCAT_MCAT_ID,ETO_TRD_ALERT_RANK
				from   eto_trd_alert_v2 trd
				where  FK_GLUSR_USR_ID=:USR_ID
			   ) A 
			   right join
			   (
				 select FK_GLCAT_MCAT_ID,
						count(case when PRIME_FLAG='P' then 1 else null end) BLNI_Prime,
						count(case when PRIME_FLAG is NULL then 1 else null end) BLNI_Non_Prime
				 from   (
						  select eto_ofr_mapping.FK_GLCAT_MCAT_ID,
								 case when eto_ofr_mapping.FK_GLCAT_MCAT_ID=eto_ofr_mapping.PRIME_MCAT then 'P' Else  null end Prime_Flag
						  from   eto_ofr_rejected,eto_ofr_mapping  
						  where  eto_ofr_rejected.FK_ETO_OFR_ID=eto_ofr_mapping.FK_ETO_OFR_ID
							 and eto_ofr_rejected.FK_GLUSR_USR_ID = :USR_ID
							 and date(eto_ofr_rejected.ETO_OFR_REJECT_DT) between :sdate and :tdate
							 and eto_ofr_rejected.ETO_OFR_REJECT_REASON in ('1',',1,')
						  union all
						  select mapp.FK_GLCAT_MCAT_ID,
								 case when mapp.FK_GLCAT_MCAT_ID=mapp.PRIME_MCAT then 'P' Else  null end Prime_Flag
						  from   eto_ofr_rejected,eto_ofr_mapping_expired mapp  
						  where  eto_ofr_rejected.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
							 and eto_ofr_rejected.FK_GLUSR_USR_ID = :USR_ID
							 and date(eto_ofr_rejected.ETO_OFR_REJECT_DT) between :sdate and :tdate
							 and eto_ofr_rejected.ETO_OFR_REJECT_REASON in ('1',',1,')
						)abc
				 group by FK_GLCAT_MCAT_ID    
			   ) B
			   on A.FK_GLCAT_MCAT_ID=B.FK_GLCAT_MCAT_ID
	   union all
	   select A.FK_GLCAT_MCAT_ID MCAT_ID,
			  (select glcat_mcat_name from glcat_mcat where A.FK_GLCAT_MCAT_ID = glcat_mcat_id) mcat_name,
			  ETO_TRD_ALERT_RANK,
			  0 BLNI_Total,
			  0 BLNI_Prime,
			  0 BLNI_Non_Prime,            
			  (coalesce(Txn_Non_Prime,0)+coalesce(Txn_Prime,0)) Txn_Total,  
			  coalesce(Txn_Prime,0) Txn_Prime,                  
			  coalesce(Txn_Non_Prime,0) Txn_Non_Prime
	   from      
			   (
				select FK_GLCAT_MCAT_ID,ETO_TRD_ALERT_RANK
				from   eto_trd_alert_v2
				where  FK_GLUSR_USR_ID=:USR_ID
			   ) A
			   left join
			   (
				 select FK_GLCAT_MCAT_ID,
						count(case when PRIME_FLAG='P' then FK_GLCAT_MCAT_ID else null end) Txn_Prime,
						count(case when PRIME_FLAG is NULL then FK_GLCAT_MCAT_ID else null end) Txn_Non_Prime
				 from   (
						  select eto_ofr_mapping.FK_GLCAT_MCAT_ID,
								 case when eto_ofr_mapping.FK_GLCAT_MCAT_ID=eto_ofr_mapping.PRIME_MCAT then 'P' Else  null end Prime_Flag
						  from   eto_lead_pur_hist,eto_ofr_mapping  
						  where  eto_lead_pur_hist.FK_ETO_OFR_ID=eto_ofr_mapping.FK_ETO_OFR_ID
							 and eto_lead_pur_hist.FK_GLUSR_USR_ID = :USR_ID
							 and date(eto_lead_pur_hist.ETO_PUR_DATE) between :sdate and :tdate
						  union all
						  select mapp.FK_GLCAT_MCAT_ID,
								 case when mapp.FK_GLCAT_MCAT_ID=mapp.PRIME_MCAT then 'P' Else  null end Prime_Flag
						  from   eto_lead_pur_hist,eto_ofr_mapping_expired mapp  
						  where  eto_lead_pur_hist.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
							 and eto_lead_pur_hist.FK_GLUSR_USR_ID = :USR_ID and date(eto_lead_pur_hist.ETO_PUR_DATE) between :sdate and :tdate
                       )def
                group by FK_GLCAT_MCAT_ID    
              ) B
              on A.FK_GLCAT_MCAT_ID=B.FK_GLCAT_MCAT_ID
					)final1
				group by MCAT_ID,MCAT_NAME,ETO_TRD_ALERT_RANK
				)final_tab
				where  BLNI_Total>0
				order by BLNI_Total desc";
	$bind[':USR_ID']=$glid;
	$bind[':sdate']=$sdate;
	$bind[':tdate']=$tdate;
	
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind); 
$results =array();
while($results1 = $sth->read()) {
	$results1=array_change_key_case($results1, CASE_UPPER);  
	array_push($results,$results1);                  
} 


	$data['mcatList'] = $results;
	return $data;
	  }

	  public function getNegativeMcats($dbh,$glid)
    {
		$obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
        }
   
     $sql='';
     
        $sql = "SELECT fk_glcat_mcat_id,glcat_mcat_name,
		count(case when flag='NI' and PRIME_FLAG='P' then 1 end)NI_Prime_Count,
	count(case when flag='NI' and PRIME_FLAG is NULL then 1 end)NI_Non_Prime_Count,
	count(case when flag='Txn' and PRIME_FLAG='P' then 1 end)Txn_Prime_Count,
	count(case when flag='Txn' and PRIME_FLAG is NULL then 1 end)Txn_Non_Prime_Count
	from
	(
	select fk_glcat_mcat_id,glcat_mcat_name,'NI' Flag,
	case when mapp.FK_GLCAT_MCAT_ID=mapp.PRIME_MCAT then 'P' Else  null end Prime_Flag
	from   eto_ofr_rejected rej,eto_ofr_mapping mapp,glcat_mcat mcat
	where  rej.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
	and mapp.fk_glcat_mcat_id=mcat.glcat_mcat_id
	and ETO_OFR_REJECT_DT >= date(now())-91 and ETO_OFR_REJECT_DT < date(now())
	and ETO_OFR_REJECT_REASON='1'
	and fk_glusr_usr_id=:USR_ID
	union all
	select fk_glcat_mcat_id,glcat_mcat_name,'NI' Flag,
	case when mapp.FK_GLCAT_MCAT_ID=mapp.PRIME_MCAT then 'P' Else  null end Prime_Flag
	from   eto_ofr_rejected rej,eto_ofr_mapping_expired mapp,glcat_mcat mcat
	where  rej.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
	and mapp.fk_glcat_mcat_id=mcat.glcat_mcat_id
	and ETO_OFR_REJECT_DT >= date(now())-91 and ETO_OFR_REJECT_DT < date(now())
	and ETO_OFR_REJECT_REASON='1'
	and fk_glusr_usr_id=:USR_ID
	union all
	select fk_glcat_mcat_id,glcat_mcat_name,'Txn' Flag,
	case when mapp.FK_GLCAT_MCAT_ID=mapp.PRIME_MCAT then 'P' Else  null end Prime_Flag
	from   eto_lead_pur_hist pur,eto_ofr_mapping mapp,glcat_mcat mcat
	where  pur.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
	and mapp.fk_glcat_mcat_id=mcat.glcat_mcat_id
	and date(eto_pur_date) between date(now())-91 and date(now())-1
	and fk_glusr_usr_id=:USR_ID
	union all
	select fk_glcat_mcat_id,glcat_mcat_name,'Txn' Flag,
	case when mapp.FK_GLCAT_MCAT_ID=mapp.PRIME_MCAT then 'P' Else  null end Prime_Flag
	from   eto_lead_pur_hist pur,eto_ofr_mapping_expired mapp,glcat_mcat mcat
	where  pur.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
	and mapp.fk_glcat_mcat_id=mcat.glcat_mcat_id
	and date(eto_pur_date) between date(now())-91 and date(now())-1
	and fk_glusr_usr_id=:USR_ID
	)A left join
	(select FK_GLCAT_MCAT_ID GLCAT_MCAT_ID from eto_trd_alert_v2 where  FK_GLUSR_USR_ID=:USR_ID
	union all 
	select FK_GLCAT_MCAT_ID GLCAT_MCAT_ID from NEGATIVE_MCAT_FOR_PRODUCTS
	where FK_GLUSR_USR_ID = :USR_ID
	)B
	on A.fk_glcat_mcat_id =B.glcat_mcat_id
	where  B.glcat_mcat_id is null
	group by fk_glcat_mcat_id,glcat_mcat_name order by NI_PRIME_COUNT desc,NI_NON_PRIME_COUNT desc";

	$bind[':USR_ID']=$glid;
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind); 
	$results = array();
	while($results1 = $sth->read()) {
		$results1=array_change_key_case($results1, CASE_UPPER);  
		array_push($results,$results1);                  
	}  
	$data['negMcats'] = $results;
	return $data;

	}

	  public function get_final_disposition_data($cookie_mid, $glmodel, $q)
    {
        // $file1      = '/home/indiamart/public_html/gladminfiles/qrf_final_disposition.json';
        // $json1      = file_get_contents($file1);
        // $modid_data = json_decode($json1, true);
		// $glmodel->p($modid_data);
		$modid_data=CommonVariable::get_final_dispositions(); 
        return $modid_data;
    }
    
    public function get_micro_disposition_data($cookie_mid, $glmodel, $q)
    {
        // $file1      = '/home/indiamart/public_html/gladminfiles/qrf_micro_disposition.json';
        // $json1      = file_get_contents($file1);
        // $modid_data = json_decode($json1, true);
		// $glmodel->p($modid_data);
		$modid_data=CommonVariable::get_micro_dispositions(); 
        return $modid_data;
    }
	  
	  public function offerDetails1($dbh ,$mcatID,$glid,$sdate,$tdate)
    {

		$obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
        }

     $sql='';
     
        $sql = " SELECT distinct
		BL_Offer_ID,
		ETO_OFR_TITLE,
		prime_mcat_name,
		All_mcat_name_grp,
		Rejection_Comment,
		Search_Text,
		Buyer_GLID,
		Buyer_City_Name,
		Matchmaking_MCAT,
		PMCAT_FLAG,
		MCAT_RANK,
		Match_Type,
		Reject_Page,
		Lead_Display_Position,
		City_Type,
		FK_GL_MODULE_ID
 from(
	 select
		BL_Offer_ID,
		ETO_OFR_TITLE,
		prime_mcat_name,
		Rejection_Comment,
		Search_Text,
		Buyer_GLID,
		Buyer_City_Name,
		Rej_mcat_name Matchmaking_MCAT,
		PMCAT_FLAG,
		MCAT_RANK,
		Match_Type,
		Reject_Page,
		Lead_Display_Position,
		City_Type,
		FK_GL_MODULE_ID,
		string_agg(all_mcat_name, ', ' order by all_mcat_name asc) all_mcat_name_grp
	 from
		 (
			 select * from (
		 select distinct rej.FK_ETO_OFR_ID BL_Offer_ID,
				ofr.ETO_OFR_TITLE,
				mapp.prime_mcat,
				(Select glcat_mcat_name from glcat_mcat where glcat_mcat_id=prime_mcat) prime_mcat_name,
				case when mapp.prime_mcat<>mapp.fk_glcat_mcat_id then mapp.fk_glcat_mcat_id else NULL end as All_mcats,
				case when mapp.prime_mcat<>mapp.fk_glcat_mcat_id then
					   (select glcat_mcat_name from glcat_mcat where glcat_mcat_id=mapp.fk_glcat_mcat_id) else NULL end as All_mcat_name,
				mapp.ETO_OFR_CITY_ID_MAPP Buyer_City_ID,
				(select gl_city_name from gl_city where gl_city_id=mapp.ETO_OFR_CITY_ID_MAPP) Buyer_City_Name,
				ofr.FK_GLUSR_USR_ID Buyer_GLID,
				rej.FK_GLUSR_USR_ID Supplier_GLID,
				(select glusr_usr_loc_pref from glusr_usr where GLUSR_USR_ID=rej.FK_GLUSR_USR_ID) Supplier_Loc_Pref,
				date(rej.ETO_OFR_REJECT_DT) Rejection_Date,
				(case when rej.ETO_OFR_REJECT_REASON='1' then 'Wrong Product'
					  when rej.ETO_OFR_REJECT_REASON='3' then 'Specification Mismatch'
					  when rej.ETO_OFR_REJECT_REASON='5' then 'Wrong Location'
					  when rej.ETO_OFR_REJECT_REASON='10' then 'Insufficient Information'
					  when rej.ETO_OFR_REJECT_REASON='11' then 'Retail Lead'
					  when rej.ETO_OFR_REJECT_REASON='7'  then 'Other Reasons' else NULL end)Rejection_Reason,
				rej.ETO_OFR_REJECT_COMMENT Rejection_Comment,
				rej.FK_REJ_MCAT Matchmaking_MCAT,
				(Select glcat_mcat_name from glcat_mcat where glcat_mcat_id=rej.FK_REJ_MCAT) Rej_mcat_name,               
				case when (select GLCAT_MCAT_IS_GENERIC from glcat_mcat where glcat_mcat_id=rej.FK_REJ_MCAT) in (1,9) then 'PMCAT'
					 else 'Non PMCAT' end PMCAT_FLAG,
				rej.ETO_SRCH_TEXT Search_Text,
				rej.MCAT_RANK,
				rej.FK_GL_MODULE_ID,
				(case when rej.OFFER_PRIME_FLAG=1 and rej.SUPPLIER_PRIME_FLAG=1 then 'BL_Prime-Sup_Prime Match'  
					  when rej.OFFER_PRIME_FLAG=1 and rej.SUPPLIER_PRIME_FLAG=0 then 'BL_Prime-Sup_Non Prime Match'
					  when rej.OFFER_PRIME_FLAG=0 and rej.SUPPLIER_PRIME_FLAG=1 then 'BL_Non Prime-Sup_Prime Match'  
					  when rej.OFFER_PRIME_FLAG=0 and rej.SUPPLIER_PRIME_FLAG=0 then 'BL_Non Prime-Sup_Non Prime Match' else NULL end)Match_Type,
				rej.ETO_OFR_DISPLAY_POSITION Lead_Display_Position,
				(case when rej.IS_PREF_LOCATION=0 then 'Normal Cities'
					  when rej.IS_PREF_LOCATION=1 then 'Preferred Cities'
					  when rej.IS_PREF_LOCATION=2 then 'Home Cities'
					  when rej.IS_PREF_LOCATION=3 then 'Cities of Home District'
					  when rej.IS_PREF_LOCATION=4 then 'Cities of Preferred District'
					  when rej.IS_PREF_LOCATION=5 then 'Preferred Country'
					  when rej.IS_PREF_LOCATION=6 then 'Negative Cities' else NULL end)City_Type,
				page.ETO_OFR_REJECT_SRCH_PAGE Reject_Page
		 from   eto_ofr_rejected rej,eto_ofr_rej_search_analysis page,eto_ofr ofr,eto_ofr_mapping mapp,eto_attribute att
		 where date(ETO_OFR_REJECT_DT) between to_date(:sdate,'DD-MON-YYYY') and to_date(:tdate,'DD-MON-YYYY')
		
				and rej.FK_GLUSR_USR_ID=:USR_ID
				and rej.FK_GLUSR_USR_ID=page.FK_GLUSR_USR_ID
				and rej.FK_ETO_OFR_ID=page.FK_ETO_OFR_ID
				and rej.FK_ETO_OFR_ID=ofr.eto_ofr_display_id
				and rej.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
				and att.FK_ETO_OFR_DISPLAY_ID=rej.FK_ETO_OFR_ID
				and rej.FK_REJ_MCAT=:mcatID
		 union all
		 select distinct rej.FK_ETO_OFR_ID BL_Offer_ID,
				ofr.ETO_OFR_TITLE,
				mapp.prime_mcat,
				(Select glcat_mcat_name from glcat_mcat where glcat_mcat_id=prime_mcat) prime_mcat_name,
				case when mapp.prime_mcat<>mapp.fk_glcat_mcat_id then mapp.fk_glcat_mcat_id else NULL end as All_mcats,
				case when mapp.prime_mcat<>mapp.fk_glcat_mcat_id then
					   (select glcat_mcat_name from glcat_mcat where glcat_mcat_id=mapp.fk_glcat_mcat_id) else NULL end as All_mcat_name,
				mapp.ETO_OFR_CITY_ID_MAPP Buyer_City_ID,
				(select gl_city_name from gl_city where gl_city_id=mapp.ETO_OFR_CITY_ID_MAPP) Buyer_City_Name,
				ofr.FK_GLUSR_USR_ID Buyer_GLID,
				rej.FK_GLUSR_USR_ID Supplier_GLID,
				(select glusr_usr_loc_pref from glusr_usr where GLUSR_USR_ID=rej.FK_GLUSR_USR_ID) Supplier_Loc_Pref,
				date(rej.ETO_OFR_REJECT_DT) Rejection_Date,
				(case when rej.ETO_OFR_REJECT_REASON='1' then 'Wrong Product'
					  when rej.ETO_OFR_REJECT_REASON='3' then 'Specification Mismatch'
					  when rej.ETO_OFR_REJECT_REASON='5' then 'Wrong Location'
					  when rej.ETO_OFR_REJECT_REASON='10' then 'Insufficient Information'
					  when rej.ETO_OFR_REJECT_REASON='11' then 'Retail Lead'
					  when rej.ETO_OFR_REJECT_REASON='7'  then 'Other Reasons' else NULL end)Rejection_Reason,
				rej.ETO_OFR_REJECT_COMMENT Rejection_Comment,
				rej.FK_REJ_MCAT Matchmaking_MCAT,
				(Select glcat_mcat_name from glcat_mcat where glcat_mcat_id=rej.FK_REJ_MCAT) Rej_mcat_name,               
				case when (select GLCAT_MCAT_IS_GENERIC from glcat_mcat where glcat_mcat_id=rej.FK_REJ_MCAT) in (1,9) then 'PMCAT'
					 else 'Non PMCAT' end PMCAT_FLAG,
				rej.ETO_SRCH_TEXT Search_Text,
				rej.MCAT_RANK,
				rej.FK_GL_MODULE_ID,
				(case when rej.OFFER_PRIME_FLAG=1 and rej.SUPPLIER_PRIME_FLAG=1 then 'BL_Prime-Sup_Prime Match'  
					  when rej.OFFER_PRIME_FLAG=1 and rej.SUPPLIER_PRIME_FLAG=0 then 'BL_Prime-Sup_Non Prime Match'
					  when rej.OFFER_PRIME_FLAG=0 and rej.SUPPLIER_PRIME_FLAG=1 then 'BL_Non Prime-Sup_Prime Match'  
					  when rej.OFFER_PRIME_FLAG=0 and rej.SUPPLIER_PRIME_FLAG=0 then 'BL_Non Prime-Sup_Non Prime Match' else NULL end)Match_Type,
				rej.ETO_OFR_DISPLAY_POSITION Lead_Display_Position,
				(case when rej.IS_PREF_LOCATION=0 then 'Normal Cities'
					  when rej.IS_PREF_LOCATION=1 then 'Preferred Cities'
					  when rej.IS_PREF_LOCATION=2 then 'Home Cities'
					  when rej.IS_PREF_LOCATION=3 then 'Cities of Home District'
					  when rej.IS_PREF_LOCATION=4 then 'Cities of Preferred District'
					  when rej.IS_PREF_LOCATION=5 then 'Preferred Country'
					  when rej.IS_PREF_LOCATION=6 then 'Negative Cities' else NULL end)City_Type,
				page.ETO_OFR_REJECT_SRCH_PAGE Reject_Page
		 from   eto_ofr_rejected rej,eto_ofr_rej_search_analysis page,eto_ofr_expired ofr,eto_ofr_mapping_expired mapp,eto_attribute att
		 where  date(ETO_OFR_REJECT_DT) between :sdate and :tdate
				and rej.FK_GLUSR_USR_ID=:USR_ID
				and rej.FK_GLUSR_USR_ID=page.FK_GLUSR_USR_ID
				and rej.FK_ETO_OFR_ID=page.FK_ETO_OFR_ID
				and rej.FK_ETO_OFR_ID=ofr.eto_ofr_display_id
				and rej.FK_ETO_OFR_ID=mapp.FK_ETO_OFR_ID
				and att.FK_ETO_OFR_DISPLAY_ID=rej.FK_ETO_OFR_ID
				and rej.FK_REJ_MCAT=:mcatID
				)A
				where all_mcat_name is not null
				) B
			 group by
			BL_Offer_ID,
			ETO_OFR_TITLE,
			prime_mcat_name,
			Rejection_Comment,
			Search_Text,
			Buyer_GLID,
			Buyer_City_Name,
			Rej_mcat_name,
			PMCAT_FLAG,
			MCAT_RANK,
			Match_Type,
			Reject_Page,
			Lead_Display_Position,
			City_Type,
			FK_GL_MODULE_ID
			 )C
 limit 7";
	$bind[':USR_ID']=$glid;
	$bind[':sdate']=$sdate;
	$bind[':tdate']=$tdate;
	$bind[':mcatID']=$mcatID;
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind); 
	$results = array();
	while($results1 = $sth->read()) {
		$results1=array_change_key_case($results1, CASE_UPPER);  
		array_push($results,$results1);                  
	} 
	$data['offerList'] = $results;
	return $data;
      }
         
         
    public function puchasedetails($dbh,$Glusrid,$Mcatid,$PurchaseFlag)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
        }

           $sql='';
           if ($PurchaseFlag == 1)
           {
            $sql = "SELECT PUR_HIST.FK_ETO_OFR_ID OFR_ID,FK_GLCAT_MCAT_ID,ETO_OFR_TITLE TITLE ,ETO_PUR_DATE PURCHASE_DATE ,ETO_OFR_DESC DESCRIPTION,ETO_OFR_QTY
	            FROM
	            (
    		    SELECT FK_ETO_OFR_ID ,ETO_PUR_DATE FROM ETO_LEAD_PUR_HIST WHERE FK_GLUSR_USR_ID  = :USR_ID AND FK_ETO_OFR_ID > -1
	            ) PUR_HIST,
	       (
		SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID ,ETO_OFR_TITLE,ETO_OFR_DESC,ETO_OFR_QTY FROM ETO_OFR
		UNION ALL
		SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID ,ETO_OFR_TITLE,ETO_OFR_DESC,ETO_OFR_QTY FROM ETO_OFR_EXPIRED
		UNION ALL
		SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID ,ETO_OFR_TITLE,ETO_OFR_DESC,ETO_OFR_QTY FROM ETO_OFR_TEMP_DEL
	       ) ETO_OFR_ALL
	      WHERE
	      ETO_OFR_ALL.ETO_OFR_DISPLAY_ID = PUR_HIST.FK_ETO_OFR_ID
	      AND FK_GLCAT_MCAT_ID=:MCAT_ID
              ORDER BY ETO_PUR_DATE DESC";
              $bind[':USR_ID']=$Glusrid;
		$bind[':MCAT_ID']=$Mcatid;
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind);
	    }  
	  elseif ($PurchaseFlag == 2)
         {
            $condition='';
            $start_date=$_REQUEST['start_date'];
            $end_date=$_REQUEST['end_date'];        
            if(isset($_REQUEST['start_date']) && isset($_REQUEST['end_date']))
            {
                    $condition = "  AND date(ETO_OFR_REJECT_DT) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')";
            }else{                        
                echo 'start_date and end_date is missing';exit;
			}

		  $sql = "WITH TT AS
		  (SELECT FK_ETO_OFR_ID,
		  ETO_OFR_REJECT_DT,
								  coalesce(ETO_OFR_REJECT_REASON,
								  (case when
								  (select IIL_MASTER_DATA_VALUE_TEXT
								  from IIL_MASTER_DATA where IIL_MASTER_DATA_VALUE =
								  RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',')
								  and FK_IIL_MASTER_DATA_TYPE_ID=15) is null
								  then
								  RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',')
								  else
								  (select IIL_MASTER_DATA_VALUE_TEXT
								  from IIL_MASTER_DATA
								  where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',')
								  and FK_IIL_MASTER_DATA_TYPE_ID=15
								  )
								  end)) ETO_OFR_REJECT_REASON,
				FK_GL_MODULE_ID SOURCE
		  FROM ETO_OFR_REJECTED
		  WHERE FK_GLUSR_USR_ID = :USR_ID
		  )
		  SELECT MCAT_ID,
		  ETO_OFR_ID,
		  TITLE,
		  REJECT_DT,
		  DETAIL,
		  ETO_OFR_REJECT_REASON,
		  ETO_OFR_QTY,
		  SOURCE
		  FROM
		  (
				SELECT ETO_OFR.FK_GLCAT_MCAT_ID MCAT_ID,
		  ETO_OFR.ETO_OFR_DISPLAY_ID ETO_OFR_ID,
		  ETO_OFR.ETO_OFR_TITLE TITLE,
		  TO_CHAR(ETO_OFR_REJECTED_EMAIL.ETO_OFR_REJECT_DT,'DD-MON-YYYY') REJECT_DT, 
		  ETO_OFR.ETO_OFR_DESC DETAIL,
		  ETO_OFR_REJECT_REASON,
		  ETO_OFR_QTY,
		  FK_GL_MODULE_ID SOURCE
		  FROM ETO_OFR,
		  TT ETO_OFR_REJECTED_EMAIL
		  WHERE ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_OFR_REJECTED_EMAIL.FK_ETO_OFR_ID
		  AND ETO_OFR.FK_GLCAT_MCAT_ID     =:MCAT_ID
		  $condition 
		  UNION ALL
		  SELECT ETO_OFR_EXPIRED.FK_GLCAT_MCAT_ID MCAT_ID,
		  ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID ETO_OFR_ID,
		  ETO_OFR_EXPIRED.ETO_OFR_TITLE TITLE,
		  TO_CHAR(date(ETO_OFR_REJECTED.ETO_OFR_REJECT_DT),'DD-MON-YYYY') REJECT_DT,
		  ETO_OFR_EXPIRED.ETO_OFR_DESC DETAIL,
		  ETO_OFR_REJECT_REASON,
		  ETO_OFR_QTY,
		  FK_GL_MODULE_ID SOURCE
		  FROM ETO_OFR_EXPIRED,
		  TT ETO_OFR_REJECTED
		  WHERE ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_OFR_REJECTED.FK_ETO_OFR_ID
		  AND ETO_OFR_EXPIRED.FK_GLCAT_MCAT_ID     =:MCAT_ID
		  $condition 
		  UNION ALL
		  SELECT ETO_OFR_TEMP_DEL.FK_GLCAT_MCAT_ID MCAT_ID,
		  ETO_OFR_TEMP_DEL.ETO_OFR_DISPLAY_ID ETO_OFR_ID,
		  ETO_OFR_TEMP_DEL.ETO_OFR_TITLE TITLE,
		  TO_CHAR(date(ETO_OFR_REJECTED_MY.ETO_OFR_REJECT_DT),'DD-MON-YYYY') REJECT_DT,
		  ETO_OFR_TEMP_DEL.ETO_OFR_DESC DETAIL,
		  ETO_OFR_REJECT_REASON,
		  ETO_OFR_QTY,
		  FK_GL_MODULE_ID SOURCE
		  FROM ETO_OFR_TEMP_DEL,
		  TT ETO_OFR_REJECTED_MY
		  WHERE ETO_OFR_TEMP_DEL.ETO_OFR_DISPLAY_ID=ETO_OFR_REJECTED_MY.FK_ETO_OFR_ID
		  AND ETO_OFR_TEMP_DEL.FK_GLCAT_MCAT_ID    =:MCAT_ID
		  $condition 		 
		  )a";	

		$bind[':start_date']=$start_date;
		$bind[':end_date']=$end_date;
		$bind[':USR_ID']=$Glusrid;
		$bind[':MCAT_ID']=$Mcatid;
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind);
	}
	
	return $sth;
     }	
	
    public function enabledetails($dbh ,$Glusrid,$EnableFlag)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
		
     $sql='';
     if ($EnableFlag == 1)
      {
        $sql = "SELECT
                GLCAT_MCAT.GLCAT_MCAT_ID,
                GLCAT_MCAT.GLCAT_MCAT_NAME,
		GLCAT_MCAT.GLCAT_MCAT_IS_GENERIC,
                TO_CHAR(ETO_TRD_ALERT_DATE,'DD-MM-YY') ETO_TRD_ALERT_DATE,
                ETO_TRD_ALERT_BY,
                NULL MCATID_LIST
            FROM
                GLCAT_MCAT join 
                ETO_TRD_ALERT_V2 on ETO_TRD_ALERT_V2.FK_GLCAT_MCAT_ID = GLCAT_MCAT.GLCAT_MCAT_ID left outer join 
                GL_EMP on ETO_TRD_ALERT_BY=GL_EMP_ID             
                WHERE ETO_TRD_ALERT_V2.FK_GLUSR_USR_ID=:USR_ID                  
                AND ETO_TRD_ALERT_DISABLED_BY IS NULL
		AND ETO_TRD_ALERT_TYP='B'
		ORDER BY GLCAT_MCAT.GLCAT_MCAT_NAME ";
      }
      if ($EnableFlag == 2)
      {
	$sql = "SELECT
                GLCAT_MCAT.GLCAT_MCAT_ID,
                GLCAT_MCAT.GLCAT_MCAT_NAME,
		GLCAT_MCAT.GLCAT_MCAT_IS_GENERIC,
                TO_CHAR(ETO_TRD_ALERT_DISABLED_ON,'DD-MM-YY') ETO_TRD_ALERT_DATE,
                ETO_TRD_ALERT_DISABLED_BY ETO_TRD_ALERT_BY,
                NULL MCATID_LIST
            FROM GLCAT_MCAT join 
                ETO_TRD_ALERT_V2_ARCH on ETO_TRD_ALERT_V2_ARCH.FK_GLCAT_MCAT_ID = GLCAT_MCAT.GLCAT_MCAT_ID left outer join 
                GL_EMP on ETO_TRD_ALERT_BY=GL_EMP_ID
            WHERE
                ETO_TRD_ALERT_V2_ARCH.FK_GLUSR_USR_ID=:USR_ID                  
                AND ETO_TRD_ALERT_DISABLED_BY IS NOT NULL
		AND ETO_TRD_ALERT_TYP='B'
		ORDER BY GLCAT_MCAT.GLCAT_MCAT_NAME";
        }
		$bind[':USR_ID']=$Glusrid;
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);
	return $sth;

      }
	
     public function productdetails($dbh , $Glusrid)
     {
                $obj_conn = new Globalconnection(); 
                $dbh = $obj_conn->connect_db_oci('imblR');

        $sql='';
         $sql = "SELECT   
		GLCAT_MCAT.GLCAT_MCAT_NAME MCAT_NAME,  
		COUNT(PC_ITEM.PC_ITEM_NAME) PRO_COUNT ,
		GLCAT_MCAT.GLCAT_MCAT_IS_GENERIC,
    	RTRIM(XMLAGG(XMLELEMENT(E, PC_ITEM.PC_ITEM_NAME    || '    ,    ' )).EXTRACT('//text()')) DETAILS
 	FROM   
		PC_CLIENT,  
		PC_ITEM,  
		PC_ITEM_TO_GLCAT_MCAT,  
		GLCAT_MCAT,  
		GLCAT_MCAT_ALLCOUNT C, 
		GLUSR_USR  
	 WHERE   
		PC_CLIENT.PC_CLNT_ID = PC_ITEM.FK_PC_CLNT_ID  
		AND PC_ITEM_TO_GLCAT_MCAT.FK_PC_ITEM_ID = PC_ITEM.PC_ITEM_ID  
		AND PC_ITEM_TO_GLCAT_MCAT.FK_GLCAT_MCAT_ID = GLCAT_MCAT.GLCAT_MCAT_ID  
		AND GLUSR_USR.GLUSR_USR_ID = PC_CLIENT.FK_GLUSR_USR_ID  
		AND PC_CLNT_ENABLED IN ('Y','W','F')  
		AND PC_ITEM_STATUS = 'N'  
		AND PC_ITEM_STATUS_APPROVAL >= 20  
		AND PC_CLIENT.FK_GLUSR_USR_ID = :USR_ID 
		AND C.FK_GLCAT_MCAT_ID = GLCAT_MCAT.GLCAT_MCAT_ID  
		AND DIR_PRD_ISGENERATED = 1 AND PRD_MCAT_ISGENERATED = 1 
	GROUP BY
		GLCAT_MCAT.GLCAT_MCAT_NAME,GLCAT_MCAT.GLCAT_MCAT_IS_GENERIC 
		order by GLCAT_MCAT.GLCAT_MCAT_NAME";
	$sth = oci_parse($dbh,$sql);
	oci_bind_by_name($sth,':USR_ID',$Glusrid);
	oci_execute($sth);
	
	return $sth;

     }
	 
     public function purchasehistory($dbh,$offer_id)
     {
     
       $sql = "SELECT ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID,GLUSR_USR.GLUSR_USR_COMPANYNAME, ETO_LEAD_PUR_HIST.ETO_PUR_DATE FROM 	 
           ETO_LEAD_PUR_HIST,GLUSR_USR WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = GLUSR_USR.GLUSR_USR_ID
		AND ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID=$offer_id";
       
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
	return $sth;
	
     }
     
     
     public function blalertdetails($dbh)
     {
     $sql="SELECT
		A.*,
		(SELECT COUNT(1) FROM ETO_LEAD_PUR_HIST WHERE ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID=A.FK_GLUSR_USR_ID) LEADPUR
		FROM
		(
		     SELECT
			FK_GLUSR_USR_ID,
			GLUSR_ETO_CUST_CREDITS_AV CREDITS_AV ,
			GLUSR_USR_CUSTTYPE_WEIGHT CUSTTYPE_WEIGHT,
			coalesce(GLUSR_USR_URL,'-') USR_URL,
			coalesce(FREESHOWROOM_URL,'-') FREESHOWROOM_URL,
			coalesce(PAIDSHOWROOM_URL,'-') PAIDSHOWROOM_URL,
			COUNT(FK_GLCAT_MCAT_ID) MCATCNT
		     FROM
			ETO_TRD_ALERT_V2,
			GLUSR_USR
		     WHERE
			FK_GLUSR_USR_ID = GLUSR_USR_ID
			AND GLUSR_ETO_CUST_CREDITS_AV > 0
			AND ETO_TRD_ALERT_TYP = 'B'
			AND FK_GL_COUNTRY_ISO='IN'
			AND ETO_TRD_ALERT_DISABLED_BY IS NULL
		     GROUP BY FK_GLUSR_USR_ID , GLUSR_ETO_CUST_CREDITS_AV, GLUSR_USR_CUSTTYPE_WEIGHT, GLUSR_USR_URL, FREESHOWROOM_URL, PAIDSHOWROOM_URL, FK_GL_COUNTRY_ISO
		     HAVING COUNT(FK_GLCAT_MCAT_ID) <= 5
		) A";
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
	
	return $sth;
	
	
     }
     
     public function blgen($dbh)
     {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
        }

     $sql="SELECT GLUSR_USR_ID,
	SUM(CNT) LEADS,
	MCAT_COUNT,
	CREDITS_AVAIL,
	CUST_WEIGHT,
	Coalesce(USR_URL,'-') USR_URL,
	Coalesce(FREEUSR_URL,'-') FREEUSR_URL,
	Coalesce(PAIDUSR_URL,'-') PAIDUSR_URL
	FROM
		( SELECT GLUSR_USR_ID,A.CREDITS_AV CREDITS_AVAIL,A.CUSTTYPE_WEIGHT CUST_WEIGHT,A.MCAT_CNT MCAT_COUNT,
		A.GLUSR_USR_URL USR_URL, A.FREESHOWROOM_URL FREEUSR_URL,A.PAIDSHOWROOM_URL PAIDUSR_URL,
		MCAT_ID,
		Coalesce(CNT,0) cnt
		FROM
			(SELECT *
			FROM
			( SELECT DISTINCT GLUSR_USR_ID,
			FK_GLCAT_MCAT_ID MCAT_ID,
			GLUSR_ETO_CUST_CREDITS_AV CREDITS_AV ,
			GLUSR_USR_CUSTTYPE_WEIGHT CUSTTYPE_WEIGHT,
			GLUSR_USR_URL,
			FREESHOWROOM_URL,
			PAIDSHOWROOM_URL,
			COUNT(FK_GLCAT_MCAT_ID) OVER (PARTITION BY GLUSR_USR_ID) MCAT_CNT
			FROM GLUSR_USR,
			ETO_TRD_ALERT_V2
			WHERE GLUSR_USR_ID =FK_GLUSR_USR_ID
			AND GLUSR_ETO_CUST_CREDITS_AV > 0
			AND ETO_TRD_ALERT_TYP = 'B'
			AND ETO_TRD_ALERT_DISABLED_BY IS NULL
			AND FK_GL_COUNTRY_ISO='IN'
			)
			WHERE MCAT_CNT>5
			)A left outer join 
			(SELECT FK_GLCAT_MCAT_ID,
			COUNT(1) CNT
			FROM
			(SELECT ETO_OFR_DISPLAY_ID
			FROM ETO_OFR
			WHERE ETO_OFR_TYP = 'B'
			AND DATE(ETO_OFR_POSTDATE_ORIG) >= date(now())-30			UNION ALL 
			SELECT ETO_OFR_DISPLAY_ID
			FROM ETO_OFR_EXPIRED
			WHERE ETO_OFR_TYP = 'B'
			AND DATE(ETO_OFR_POSTDATE_ORIG) >= date(now())-30
			),
			ETO_OFR_MAPPING
			WHERE FK_ETO_OFR_ID =ETO_OFR_DISPLAY_ID
			GROUP BY FK_GLCAT_MCAT_ID
			)B
		on A.MCAT_ID=B.FK_GLCAT_MCAT_ID
		)
	GROUP BY GLUSR_USR_ID,CREDITS_AVAIL,CUST_WEIGHT,MCAT_COUNT,USR_URL,FREEUSR_URL,PAIDUSR_URL
	HAVING SUM(cnt)<11";
	$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());
        
        return $sth;
     }
    public function dispHTML($dbh,$sbjVal,$start_date,$end_date)
	{ 
		$obj = new Globalconnection();
		$model = new GlobalmodelForm();
		if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
		{
			$dbh_pg = $obj->connect_db_yii('postgress_web68v');   
		}else{
			$dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
		}
        if($sbjVal=='' || $start_date=='' || $end_date ==''){
            $emp_id =Yii::app()->session['empid'];
            $empemail= Yii::app()->session['empemail'];
            mail("laxmi@indiamart.com","dispHTML Manage Buy Leads >> Not Interested Report","The employee id is $emp_id and the email id is $empemail sbjVal : $sbjVal start_date: $start_date end_date: $end_date");
            echo "Input Parameter missing";exit;        
        }
                
        $time=time();
	$filename="Rejection-Reoprt-".$time.".xls";
        $path=$_SERVER['DOCUMENT_ROOT']."/email-notification/";
        $Excelfile = $path.$filename;
        
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                $fp='';            
        }else{
                $fp = fopen($Excelfile, 'w');
        }
   if($dbh_pg){
	$row=1;

$sql_pur_old = "SELECT
	COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' THEN FK_GL_COUNTRY_ISO END ) INLEADS,
	COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' THEN FK_GL_COUNTRY_ISO END) FRLEADS,
	COUNT(CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' and ETO_LEAD_PUR_POSITION_URL <> 'Search' THEN ETO_LEAD_FK_GL_MODULE_ID END) MY,
	COUNT(CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' and ETO_LEAD_PUR_POSITION_URL = 'Search' THEN ETO_LEAD_FK_GL_MODULE_ID END) AS SEARCH,
	COUNT(CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ETO' THEN ETO_LEAD_FK_GL_MODULE_ID END) ETO,
	COUNT(CASE WHEN ETO_LEAD_PUR_MODE = 'MAIL' THEN ETO_LEAD_PUR_MODE END) EMAIL,
	COUNT(CASE WHEN ETO_LEAD_PUR_MODE = 'MOB' THEN ETO_LEAD_PUR_MODE END) MOBILE_SITE,
	COUNT(CASE WHEN ETO_LEAD_PUR_MODE = 'APP' THEN ETO_LEAD_PUR_MODE END) MOBILE_APP,
	COUNT(CASE WHEN ETO_LEAD_PUR_POSITION_URL = 'Search' THEN ETO_LEAD_PUR_POSITION_URL END) WEB
                FROM(
                    select A.* ,GLUSR_USR.FK_GL_COUNTRY_ISO
                    from
                    (
                    SELECT
                        ETO_OFR.FK_GLUSR_USR_ID,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_MODE,
                        ETO_LEAD_PUR_HIST.ETO_PUR_DATE,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_POSITION_URL,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID
                    FROM
                        ETO_LEAD_PUR_HIST,
                        ETO_OFR
                    WHERE
                        ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
                        AND ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID =ETO_OFR.ETO_OFR_DISPLAY_ID
                    UNION ALL 
                    SELECT
                        ETO_OFR.FK_GLUSR_USR_ID,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_MODE,
                        ETO_LEAD_PUR_HIST.ETO_PUR_DATE,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_POSITION_URL,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID
                    FROM
                        ETO_LEAD_PUR_HIST,
                        ETO_OFR_EXPIRED ETO_OFR
                    WHERE
                        ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
                            AND ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID =ETO_OFR.ETO_OFR_DISPLAY_ID
		   UNION ALL 
                    SELECT
                        ETO_OFR.FK_GLUSR_USR_ID,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_MODE,
                        ETO_LEAD_PUR_HIST.ETO_PUR_DATE,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_POSITION_URL,
                        ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID
                    FROM
                        ETO_LEAD_PUR_HIST,
                        ETO_OFR_TEMP_DEL ETO_OFR
                    WHERE
                        ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID
                        AND ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID =ETO_OFR.ETO_OFR_DISPLAY_ID
                    )A,
                    GLUSR_USR
                    where A.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
                ) TEMP";
			
		$sql_pur="WITH MY_LEAD_PUR_HIST AS
(
SELECT ETO_LEAD_PUR_MODE,
ETO_LEAD_PUR_POSITION_URL,
ETO_LEAD_FK_GL_MODULE_ID,
FK_ETO_OFR_ID
FROM
ETO_LEAD_PUR_HIST
WHERE
FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
AND DATE(ETO_PUR_DATE) BETWEEN TO_DATE(:start_date,'DD-MON-YYYY') AND TO_DATE(:end_date,'DD-MON-YYYY')
)
SELECT
COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' THEN FK_GL_COUNTRY_ISO END ) INLEADS,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' THEN FK_GL_COUNTRY_ISO END) FRLEADS,
COUNT(CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' and ETO_LEAD_PUR_POSITION_URL <> 'Search' THEN ETO_LEAD_FK_GL_MODULE_ID END) MY,
COUNT(CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' and ETO_LEAD_PUR_POSITION_URL = 'Search' THEN ETO_LEAD_FK_GL_MODULE_ID END) AS SEARCH,
COUNT(CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ETO' THEN ETO_LEAD_FK_GL_MODULE_ID END) ETO,
COUNT(CASE WHEN ETO_LEAD_PUR_MODE = 'MAIL' THEN ETO_LEAD_PUR_MODE END) EMAIL,
COUNT(CASE WHEN ETO_LEAD_PUR_MODE = 'MOB' THEN ETO_LEAD_PUR_MODE END) MOBILE_SITE,
COUNT(CASE WHEN ETO_LEAD_PUR_MODE = 'APP' THEN ETO_LEAD_PUR_MODE END) MOBILE_APP,
COUNT(CASE WHEN ETO_LEAD_PUR_POSITION_URL = 'Search' THEN ETO_LEAD_PUR_POSITION_URL END) WEB
FROM(
    SELECT A.* ,GLUSR_USR.FK_GL_COUNTRY_ISO
    FROM
    (
    SELECT
        ETO_OFR.FK_GLUSR_USR_ID,
        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_MODE,
        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_POSITION_URL,
        ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID
    FROM
        MY_LEAD_PUR_HIST ETO_LEAD_PUR_HIST,
        ETO_OFR
    WHERE
        ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID =ETO_OFR.ETO_OFR_DISPLAY_ID
    UNION ALL
    SELECT
        ETO_OFR.FK_GLUSR_USR_ID,
        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_MODE,
        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_POSITION_URL,
        ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID
    FROM
        MY_LEAD_PUR_HIST ETO_LEAD_PUR_HIST,
        ETO_OFR_EXPIRED ETO_OFR
    WHERE
        ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID =ETO_OFR.ETO_OFR_DISPLAY_ID
    UNION ALL
    SELECT
        ETO_OFR.FK_GLUSR_USR_ID,
        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_MODE,
        ETO_LEAD_PUR_HIST.ETO_LEAD_PUR_POSITION_URL,
        ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID
    FROM
        MY_LEAD_PUR_HIST ETO_LEAD_PUR_HIST,
        ETO_OFR_TEMP_DEL ETO_OFR
    WHERE
        ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID =ETO_OFR.ETO_OFR_DISPLAY_ID
    )A,
    GLUSR_USR
    WHERE A.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
) TEMP ";
			
			$bind_pur[':FK_GLUSR_USR_ID']=$sbjVal;
			$bind_pur[':start_date']=$start_date;
			$bind_pur[':end_date']=$end_date;

			$sth_pur = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_pur, $bind_pur);

			 $sql_tot_rej =  "SELECT
			 COUNT(CASE WHEN FK_GL_MODULE_ID='MY' THEN 1 END) MY,
			 COUNT(CASE WHEN FK_GL_MODULE_ID='EMKTG' THEN 1 END) EMAIL,
			 COUNT(CASE WHEN ETO_SRCH_TEXT IS NOT NULL THEN 1 END) search1,
			 COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' THEN 1 END) INLEADS,
			 COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' THEN 1 END) FRLEADS,
			 COUNT(CASE WHEN FK_GL_MODULE_ID in ('FUSION','ANDROID','FUSIONA','FUSIONM','FUSIONI','FUSIONW') THEN 1 END) MOBILE_APP,
			 COUNT(CASE WHEN FK_GL_MODULE_ID = 'IMOB' THEN 1 END) MOBILE_SITE
		 FROM
		 (
	 SELECT GLUSR_USR.FK_GL_COUNTRY_ISO,ETO_OFR_REJECT_DT,ETO_SRCH_TEXT, FK_GL_MODULE_ID
	 FROM(     
		 SELECT
			 ETO_OFR.FK_GLUSR_USR_ID,ETO_SRCH_TEXT,
			 ETO_OFR_REJECT_DT,
			 ETO_OFR_REJECTED.FK_GL_MODULE_ID
		 FROM
			 (SELECT FK_ETO_OFR_ID,ETO_SRCH_TEXT,FK_GLUSR_USR_ID,ETO_OFR_REJECT_DT, FK_GL_MODULE_ID FROM ETO_OFR_REJECTED WHERE FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID) ETO_OFR_REJECTED,
			 ETO_OFR
		 WHERE
			 ETO_OFR_REJECTED.FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
			 AND ETO_OFR_DISPLAY_ID =ETO_OFR_REJECTED.FK_ETO_OFR_ID
		 UNION ALL
		 SELECT
			 ETO_OFR.FK_GLUSR_USR_ID,ETO_SRCH_TEXT,
			 ETO_OFR_REJECT_DT,
			 ETO_OFR_REJECTED.FK_GL_MODULE_ID
		 FROM
			 (SELECT FK_ETO_OFR_ID,ETO_SRCH_TEXT,FK_GLUSR_USR_ID,ETO_OFR_REJECT_DT, FK_GL_MODULE_ID FROM ETO_OFR_REJECTED WHERE FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID) ETO_OFR_REJECTED,
			 ETO_OFR_EXPIRED ETO_OFR
		 WHERE
			 ETO_OFR_REJECTED.FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID
			 AND ETO_OFR_DISPLAY_ID =ETO_OFR_REJECTED.FK_ETO_OFR_ID
		 UNION ALL
		 SELECT
			 ETO_OFR.FK_GLUSR_USR_ID,ETO_SRCH_TEXT,
			 ETO_OFR_REJECT_DT,
			 ETO_OFR_REJECTED.FK_GL_MODULE_ID
		 FROM
			 (SELECT FK_ETO_OFR_ID,ETO_SRCH_TEXT,FK_GLUSR_USR_ID,ETO_OFR_REJECT_DT, FK_GL_MODULE_ID FROM ETO_OFR_REJECTED WHERE FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID) ETO_OFR_REJECTED,
			 ETO_OFR_TEMP_DEL ETO_OFR
		 WHERE
			 ETO_OFR_REJECTED.FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
			 AND ETO_OFR_DISPLAY_ID =ETO_OFR_REJECTED.FK_ETO_OFR_ID
			 )A,
			 GLUSR_USR
		 WHERE
			 A.FK_GLUSR_USR_ID = GLUSR_USR.GLUSR_USR_ID
		 ) Final
		";
			
			$sql_tot_rej .= " WHERE  date(ETO_OFR_REJECT_DT) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')";

			$bind_tot_rej[':FK_GLUSR_USR_ID']=$sbjVal;
			$bind_tot_rej[':start_date']=$start_date;
			$bind_tot_rej[':end_date']=$end_date;

			$sth_tot_rej = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_tot_rej, $bind_tot_rej);
			
			
			
			$sql_sum =$sql_sum_cond ='';
		
			if ( $start_date <> "" && $end_date <> "" )
			{
				$sql_sum_cond = "  date(ETO_OFR_REJECT_DT) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')";
			}
			$sql_sum = " SELECT
			REASON REASON_ID,
			COALESCE((select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA where IIL_MASTER_DATA_VALUE = REASON and FK_IIL_MASTER_DATA_TYPE_ID=15),REASON) REASON,
			SUM(MY) MY,
			SUM(EMAIL) EMAIL,
			SUM(SEARCH1) SEARCH1,
			SUM(INLEADS) INLEADS,
			SUM(FRLEADS) FRLEADS,
			SUM(MOBILE_APP) MOBILE_APP,
			SUM(MOBILE_SITE) MOBILE_SITE
		FROM
			(
			SELECT
				ETO_OFR_REJECTED.REASON,
				COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID='MY' THEN 1 END) MY,
				COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID='EMKTG' THEN 1 END) EMAIL,
				COUNT(CASE WHEN ETO_SRCH_TEXT IS NOT NULL THEN 1 END) SEARCH1,
				COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' THEN FK_GL_COUNTRY_ISO END) INLEADS,
				COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' THEN FK_GL_COUNTRY_ISO END) FRLEADS,
COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID in ('FUSION','ANDROID','FUSIONA','FUSIONM','FUSIONI','FUSIONW') THEN 1 END) MOBILE_APP,
COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID = 'IMOB' THEN 1 END) MOBILE_SITE
			FROM
				(
				SELECT 1 FLAG,FK_ETO_OFR_ID,FK_GLUSR_USR_ID,ETO_SRCH_TEXT,ETO_OFR_REJECT_REASON REASON, FK_GL_MODULE_ID FROM ETO_OFR_REJECTED WHERE
				date(ETO_OFR_REJECT_DT) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')
				AND 
				FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID			
				) ETO_OFR_REJECTED,
				ETO_OFR
			WHERE
				ETO_OFR_REJECTED.FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
				AND ETO_OFR_DISPLAY_ID =ETO_OFR_REJECTED.FK_ETO_OFR_ID
			GROUP BY
				ETO_OFR_REJECTED.REASON
			UNION all
			SELECT
				ETO_OFR_REJECTED.REASON,
				COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID='MY' THEN 1 END) MY,
				COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID='EMKTG' THEN 1 END) EMAIL,
				COUNT(CASE WHEN ETO_SRCH_TEXT IS NOT NULL THEN 1 END) SEARCH1,
				COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' THEN FK_GL_COUNTRY_ISO END) INLEADS,
				COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' THEN FK_GL_COUNTRY_ISO END) FRLEADS,
COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID in ('FUSION','ANDROID','FUSIONA','FUSIONM','FUSIONI','FUSIONW') THEN 1 END) MOBILE_APP,
COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID = 'IMOB' THEN 1 END) MOBILE_SITE
			FROM
				(
				SELECT 1 FLAG,FK_ETO_OFR_ID,FK_GLUSR_USR_ID,ETO_SRCH_TEXT,ETO_OFR_REJECT_REASON REASON, FK_GL_MODULE_ID FROM ETO_OFR_REJECTED WHERE
				date(ETO_OFR_REJECT_DT) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY')
				AND 
				 FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID			
				)
				ETO_OFR_REJECTED,
				ETO_OFR_EXPIRED ETO_OFR
			WHERE
				ETO_OFR_REJECTED.FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID
				AND ETO_OFR_DISPLAY_ID = ETO_OFR_REJECTED.FK_ETO_OFR_ID
			GROUP BY
				ETO_OFR_REJECTED.REASON
			UNION all
			SELECT
				ETO_OFR_REJECTED.REASON,
				COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID='MY' THEN 1 END) MY,
				COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID='EMKTG' THEN 1 END) EMAIL,
				COUNT(CASE WHEN ETO_SRCH_TEXT IS NOT NULL THEN 1 END) SEARCH1,
				COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' THEN FK_GL_COUNTRY_ISO END) INLEADS,
				COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' THEN FK_GL_COUNTRY_ISO END) FRLEADS,
COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID in ('FUSION','ANDROID','FUSIONA','FUSIONM','FUSIONI','FUSIONW') THEN 1 END) MOBILE_APP,
COUNT(CASE WHEN ETO_OFR_REJECTED.FK_GL_MODULE_ID = 'IMOB' THEN 1 END) MOBILE_SITE
			FROM
				(
				SELECT 1 FLAG,FK_ETO_OFR_ID,FK_GLUSR_USR_ID,ETO_SRCH_TEXT,coalesce(ETO_OFR_REJECT_REASON,'0') REASON, FK_GL_MODULE_ID 
				FROM ETO_OFR_REJECTED WHERE
				
				date(ETO_OFR_REJECT_DT) between to_date(:start_date,'DD-MON-YYYY') and to_date(:end_date,'DD-MON-YYYY') AND
				 
				  FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID			
				) ETO_OFR_REJECTED,
				ETO_OFR_TEMP_DEL ETO_OFR
			WHERE
				ETO_OFR_REJECTED.FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID
				AND ETO_OFR_DISPLAY_ID =ETO_OFR_REJECTED.FK_ETO_OFR_ID
			GROUP BY
				ETO_OFR_REJECTED.REASON
			)A
			GROUP BY
				REASON
			ORDER BY
				REASON_ID";
			$bind_sum[':FK_GLUSR_USR_ID']=$sbjVal;
			$bind_sum[':start_date']=$start_date;
			$bind_sum[':end_date']=$end_date;

			$sth_sum = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_sum, $bind_sum);

    $sth_serach = '';
        }
    return array($sth_pur,$sth_tot_rej,$sth_sum,$sth_serach,$fp,$filename);
}
    
  public function show_popup($dbh,$mcatid,$Glusrid)
  {                      
        echo 'This Section has been disabled.';die;       
  }	       
    
    public function dispHTML1($dbh,$start_date,$end_date,$sbjVal)
    {
		$obj = new Globalconnection();	
        $model = new GlobalmodelForm();	
      											
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))	
        {	
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   	
        }else{	
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 	
        }
     $sql = " SELECT A.*,ETO_LEAD_SUPPLIER_MAPPING.FK_ETO_OFR_DISPLAY_ID 
	 FROM (SELECT 
ETO_OFR_REJECTED.*,
ETO_OFR_VERIFIED
 FROM
(
select
ETO_OFR_REJECTED.FK_GL_MODULE_ID FLAG,
FK_ETO_OFR_ID,
FK_GLUSR_USR_ID,
ETO_OFR_REJECT_DT,
TO_CHAR(ETO_OFR_REJECT_DT,'DD-Mon-YYYY') ETO_OFR_REJECT_DT_DISP,
ETO_OFR_REJECT_AUTOSTATUS,
coalesce(ETO_OFR_REJECT_REASON,
case when 
(select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA
where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',')
and FK_IIL_MASTER_DATA_TYPE_ID=15) is null then 
RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') ELSE
(select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') 
and FK_IIL_MASTER_DATA_TYPE_ID=15) END)  AS ETO_OFR_REJECT_REASON,
					   NULL ETO_OFR_MAIL_SENT_DATE,
TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT,TRIM (ETO_SRCH_TEXT) ETO_SRCH_TEXT
FROM
ETO_OFR_REJECTED
where
ETO_OFR_REJECTED.FK_ETO_OFR_ID = :FK_ETO_OFR_ID						
AND ETO_SRCH_TEXT IS NULL
UNION ALL

select
'Search' FLAG,
FK_ETO_OFR_ID,
FK_GLUSR_USR_ID,
ETO_OFR_REJECT_DT,
TO_CHAR(ETO_OFR_REJECT_DT,'DD-Mon-YYYY') ETO_OFR_REJECT_DT_DISP,
ETO_OFR_REJECT_AUTOSTATUS,
coalesce(ETO_OFR_REJECT_REASON,
case WHEN
(select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',')
and FK_IIL_MASTER_DATA_TYPE_ID=15) is null THEN
RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') ELSE
(select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',')
and FK_IIL_MASTER_DATA_TYPE_ID=15) END) AS ETO_OFR_REJECT_REASON,
NULL ETO_OFR_MAIL_SENT_DATE,
TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT,TRIM (ETO_SRCH_TEXT) ETO_SRCH_TEXT
FROM
ETO_OFR_REJECTED
where
ETO_OFR_REJECTED.FK_ETO_OFR_ID = :FK_ETO_OFR_ID						
AND ETO_SRCH_TEXT IS NOT NULL					
) ETO_OFR_REJECTED,
(
select ETO_OFR_VERIFIED,ETO_OFR_DISPLAY_ID from ETO_OFR WHERE ETO_OFR_DISPLAY_ID = :FK_ETO_OFR_ID
union
select ETO_OFR_VERIFIED,ETO_OFR_DISPLAY_ID from ETO_OFR_EXPIRED WHERE ETO_OFR_DISPLAY_ID = :FK_ETO_OFR_ID
union
select ETO_OFR_VERIFIED,ETO_OFR_DISPLAY_ID from ETO_OFR_TEMP_DEL WHERE ETO_OFR_DISPLAY_ID = :FK_ETO_OFR_ID
)
ETO_OFR
WHERE 
ETO_OFR_REJECTED.FK_ETO_OFR_ID=ETO_OFR.ETO_OFR_DISPLAY_ID)A left JOIN ETO_LEAD_SUPPLIER_MAPPING
   ON ETO_LEAD_SUPPLIER_MAPPING.FK_ETO_OFR_DISPLAY_ID=A.FK_ETO_OFR_ID
 AND ETO_LEAD_SUPPLIER_MAPPING.FK_GLUSR_USR_ID=A.FK_GLUSR_USR_ID";
         				 
		if ( $start_date <> "" && $end_date <> "" )
		{
			$sql .= " AND date(ETO_OFR_REJECT_DT) BETWEEN TO_DATE(:start_date,'DD-MON-YYYY') AND TO_DATE(:end_date,'DD-MON-YYYY')  ";
		}
	$sql .= "order by ETO_OFR_REJECT_DT DESC ";			
		$bind[':FK_ETO_OFR_ID']=$sbjVal; 
		$bind[':start_date']=$start_date;
		$bind[':end_date']=$end_date;
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind);	
			return $sth;
    }
    
    public function glusrwise_report($dbh,$sbjVal)
    {$obj = new Globalconnection();	
        $model = new GlobalmodelForm();	
      	$rec= array();										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))	
        {	
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   	
        }else{	
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 	
        }
       
if($dbh_pg){
	    $sql = "SELECT (GLUSR_USR_FIRSTNAME ||' '|| GLUSR_USR_LASTNAME) GLUSR_NAME,
	'+('|| GLUSR_USR_PH_COUNTRY || ')-' || GLUSR_USR_PH_MOBILE AS  GLUSR_MOBILE,
	GLUSR_USR_COMPANYNAME,
	GLUSR_USR_CITY,
	GLUSR_USR_EMAIL,
	GLUSR_USR_COMPID,
	GLUSR_USR_STATE,GLUSR_USR.FK_GL_COUNTRY_ISO,GL_COUNTRY.GL_COUNTRY_NAME,
	coalesce(PAIDSHOWROOM_URL,FREESHOWROOM_URL) as URL,
	GLUSR_USR_ID,
        (GLUSR_USR_ADD1 || GLUSR_USR_ADD2)GLUSR_ADD,GLUSR_USR_ZIP,('+' || glusr_usr_ph_country || '-' || glusr_usr_ph_area || '-' || GLUSR_USR_PH_NUMBER)GLUSR_PH_NUMBER,
	GLUSR_USR_CUSTTYPE_NAME,GLUSR_USR.GLUSR_USR_LOC_PREF,GLUSR_ETO_CUST_CREDITS_AV,
        (CASE WHEN glusr_usr_deduced_loc_pref1=1 then 'Global' 
        WHEN glusr_usr_deduced_loc_pref1=2 then 'India only'
        WHEN glusr_usr_deduced_loc_pref1=3 then 'Foreign only' 
        when glusr_usr_deduced_loc_pref1=4 then 'Local only' 
        when glusr_usr_deduced_loc_pref1=5 then 'Hyperlocal (City+50km)' end) loc_pref1, 
        (CASE WHEN glusr_usr_deduced_loc_pref2=1 then 'Global' 
        WHEN glusr_usr_deduced_loc_pref2=2 then 'India only'
        WHEN glusr_usr_deduced_loc_pref2=3 then 'Foreign only' 
        when glusr_usr_deduced_loc_pref2=4 then 'Local only' 
        when glusr_usr_deduced_loc_pref2=5 then 'Hyperlocal (City+50km)' end) loc_pref2
        
FROM GLUSR_USR join GL_COUNTRY on GLUSR_USR.FK_GL_COUNTRY_ISO=GL_COUNTRY.GL_COUNTRY_ISO left outer join GLUSR_USR_LOC_PREF on GLUSR_USR.GLUSR_USR_ID=GLUSR_USR_LOC_PREF.FK_GLUSR_USR_ID 
	WHERE GLUSR_USR_ID=:FK_GLUSR_USR_ID ";

		$bind[':FK_GLUSR_USR_ID']=$sbjVal; 		
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind);// echo"<pre>";echo $sql1; echo"</pre>";        
		 while($record = $sth->read()) {
				 $rec=array_change_key_case($record, CASE_UPPER);                     
			 } 
                         
		$sql1 = "WITH MY_OFR_REJECTED AS
(
SELECT 1 FLAG,FK_ETO_OFR_ID,ETO_OFR_REJECT_DT FROM ETO_OFR_REJECTED
WHERE FK_GLUSR_USR_ID =  :FK_GLUSR_USR_ID
AND coalesce(FK_GL_MODULE_ID,'XX') IN ('XX','EMKTG')
)
SELECT
COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' THEN FK_GL_COUNTRY_ISO END) INLEADS,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' AND ETO_OFR_REJECT_DT >= NOW() - INTERVAL '7 DAYS' THEN FK_GL_COUNTRY_ISO END ) INLEADS_7,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' AND ETO_OFR_REJECT_DT >= NOW() - INTERVAL '30 DAYS' THEN FK_GL_COUNTRY_ISO END ) INLEADS_30,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO = 'IN' AND ETO_OFR_REJECT_DT >= NOW() - INTERVAL '60 DAYS' THEN FK_GL_COUNTRY_ISO END ) INLEADS_60,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' THEN FK_GL_COUNTRY_ISO END) FRLEADS,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' AND ETO_OFR_REJECT_DT >= NOW() - INTERVAL '7 DAYS' THEN FK_GL_COUNTRY_ISO END ) FRLEADS_7,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' AND ETO_OFR_REJECT_DT >= NOW() - INTERVAL '30 DAYS' THEN FK_GL_COUNTRY_ISO END ) FRLEADS_30,
COUNT(CASE WHEN FK_GL_COUNTRY_ISO <> 'IN' AND ETO_OFR_REJECT_DT >= NOW() - INTERVAL '60 DAYS' THEN FK_GL_COUNTRY_ISO END ) FRLEADS_60
FROM
(
SELECT
FLAG,
FK_GL_COUNTRY_ISO,
ETO_OFR_REJECT_DT
FROM
MY_OFR_REJECTED,
ETO_OFR
WHERE
ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID
UNION ALL
SELECT
FLAG,
FK_GL_COUNTRY_ISO,
ETO_OFR_REJECT_DT
FROM
MY_OFR_REJECTED,
ETO_OFR_EXPIRED ETO_OFR
WHERE
ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID
UNION ALL
SELECT
FLAG,
FK_GL_COUNTRY_ISO,
ETO_OFR_REJECT_DT
FROM
MY_OFR_REJECTED,
ETO_OFR_TEMP_DEL ETO_OFR
WHERE
ETO_OFR_DISPLAY_ID = FK_ETO_OFR_ID
) A";
		$bind1[':FK_GLUSR_USR_ID']=$sbjVal; 		
		$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql1, $bind1);// echo"<pre>";echo $sql1; echo"</pre>";        
		 while($rec1 = $sth1->read()) {
				 $rec1=array_change_key_case($rec1, CASE_UPPER);                     
			 } 
	 
		 return array($rec ,$rec1);
}else{
    echo 'Some Error occured';exit;
}
    }
    
    public function offerwise_report($dbh , $sbjVal)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

    $sql = "SELECT T.*,
            NULL ETO_OFR_GLUSR_USERNAME,
            (SELECT GLUSR_USR_CITY FROM GLUSR_USR WHERE GLUSR_USR_ID=FK_GLUSR_USR_ID) ETO_OFR_LOCATION,
            (SELECT GL_EMP_NAME FROM GL_EMP WHERE GL_EMP_ID=T. FK_EMPLOYEE_ID) NAME_OF_EMPLOYEE,
        (SELECT string_agg(GLCAT_MCAT_NAME,',') FROM (SELECT FK_ETO_OFR_ID,GLCAT_MCAT_NAME FROM
         ETO_OFR_MAPPING,GLCAT_MCAT WHERE FK_GLCAT_MCAT_ID<>PRIME_MCAT
         AND GLCAT_MCAT_ID=FK_GLCAT_MCAT_ID) A 
         WHERE FK_ETO_OFR_ID=$sbjVal
         GROUP BY FK_ETO_OFR_ID) MCAT_NAME,
            (SELECT COUNT(*) FROM ETO_LEAD_PUR_HIST WHERE ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID=T. ETO_OFR_DISPLAY_ID GROUP BY FK_ETO_OFR_ID )TOTAL_PURCHASE
            FROM
                 (
                 SELECT  ETO_OFR_S_PH_MOBILE AS GLUSR_MOBILE,
                 ETO_OFR_TITLE, ETO_OFR_EXP_DATE , ETO_OFR_DESC, ETO_OFR_DISPLAY_ID,ETO_OFR_QTY, ETO_OFR_LAST_UPDATED, 
                 ETO_OFR_POSTDATE_ORIG,ETO_OFR_APPROV_DATE_ORIG,ETO_OFR_QUALITY, ETO_OFR_REFRESHCOUNT, ETO_OFR_S_STATE,ETO_OFR_GL_COUNTRY_NAME,
                 ETO_OFR_GLCAT_MCAT_NAME,FK_GLUSR_USR_ID,ETO_OFR_POSTEDBYEMPLOYEE,FK_EMPLOYEE_ID,ETO_OFR_COMPANYNAME,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED
                 FROM ETO_OFR
                 WHERE ETO_OFR_DISPLAY_ID = $sbjVal
                 UNION ALL 
                 SELECT ETO_OFR_S_PH_MOBILE GLUSR_MOBILE,ETO_OFR_TITLE, ETO_OFR_EXP_DATE , ETO_OFR_DESC, 
                 ETO_OFR_DISPLAY_ID,ETO_OFR_QTY, ETO_OFR_LAST_UPDATED, ETO_OFR_POSTDATE_ORIG,ETO_OFR_APPROV_DATE_ORIG,ETO_OFR_QUALITY, ETO_OFR_REFRESHCOUNT, 
                 ETO_OFR_S_STATE,ETO_OFR_GL_COUNTRY_NAME,ETO_OFR_GLCAT_MCAT_NAME,FK_GLUSR_USR_ID,ETO_OFR_POSTEDBYEMPLOYEE,FK_EMPLOYEE_ID,ETO_OFR_COMPANYNAME,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED
                 FROM ETO_OFR_EXPIRED
                 WHERE ETO_OFR_DISPLAY_ID = $sbjVal
                 UNION ALL 
                 SELECT ETO_OFR_S_PH_MOBILE GLUSR_MOBILE,ETO_OFR_TITLE, ETO_OFR_EXP_DATE , ETO_OFR_DESC, ETO_OFR_DISPLAY_ID,ETO_OFR_QTY, 
                 ETO_OFR_LAST_UPDATED, ETO_OFR_POSTDATE_ORIG,ETO_OFR_APPROV_DATE_ORIG,ETO_OFR_QUALITY, ETO_OFR_REFRESHCOUNT, ETO_OFR_S_STATE,ETO_OFR_GL_COUNTRY_NAME,ETO_OFR_GLCAT_MCAT_NAME,FK_GLUSR_USR_ID,ETO_OFR_POSTEDBYEMPLOYEE,FK_EMPLOYEE_ID,ETO_OFR_COMPANYNAME,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED
                 FROM ETO_OFR_TEMP_DEL
                 WHERE ETO_OFR_DISPLAY_ID = $sbjVal
                 )T";
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
                $rec =array();
                while($results= $sth->read()) {
                        $rec=array_change_key_case($results, CASE_UPPER);  
                }
	      return $rec;
      }
      
	  public function showEmailRelevancyReportnew($dbh)
      {
        $model = new GlobalmodelForm();
         $time=time();
	$filename="BLRejection-Reoprt-".$time.".xls";
        $path=$_SERVER['DOCUMENT_ROOT']."/email-notification/";
        $Excelfile = $path.$filename;
        $obj = new Globalconnection();
        $dbh= $obj->connect_db_yii('postgress_web68v');   
        $cond_negmcat='';
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net'){
                $fp='';            
        }else{
              $fp = fopen($Excelfile, 'w');
        }
       if(isset($_REQUEST['r1']))
	{
        $rejectn_src = $_REQUEST['r1'];
        }
        else
        {$rejectn_src = '';}
        
        if(isset($_REQUEST['r2']))
        {
        $purchase = $_REQUEST['r2'];
        }
        else
        {$purchase = '';}
        
        if(isset($_REQUEST['r3']))
        {$crd_avble = $_REQUEST['r3'];}
        else
        {$crd_avble = '';}
        
        if(isset($_REQUEST['reason']))
	 {
	 $rej_reason = $_REQUEST['reason'];
	 }
	 else {$rej_reason = '';}
	 
	 if(isset($_REQUEST['comment']))
	 {
	 $rej_comment = $_REQUEST['comment'];
	 }
	 else
	 {$rej_comment = '';}
	
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
        $custtype = $_REQUEST['custtype'];
        $cond_custtype=$cond_custtype_join='';
         if($custtype<>'')
	 {      
                if($custtype=='Paid'){
                 $cond_custtype_join = " AND CUSTTYPE_ID=GLUSR_USR_CUSTTYPE_ID AND CUSTTYPE_ID IN(2,15,13,48,10,5,25,27,23,4,12,7,1) ";   
                }elseif($custtype=='Free'){
                 $cond_custtype_join = " AND CUSTTYPE_ID=GLUSR_USR_CUSTTYPE_ID AND PAID=0 ";
                }elseif($custtype=='TSCatalog'){
                 $cond_custtype_join = " AND CUSTTYPE_ID=GLUSR_USR_CUSTTYPE_ID AND CUSTTYPE_ID=1 ";
                 }elseif($custtype=='Star'){
                 $cond_custtype_join = " AND CUSTTYPE_ID=GLUSR_USR_CUSTTYPE_ID AND CUSTTYPE_ID=12 ";
                 }elseif($custtype=='Leader'){
                 $cond_custtype_join = " AND CUSTTYPE_ID=GLUSR_USR_CUSTTYPE_ID AND CUSTTYPE_ID=10 ";
                 }elseif($custtype=='Catalog'){
                 $cond_custtype_join = " AND CUSTTYPE_ID=GLUSR_USR_CUSTTYPE_ID AND CUSTTYPE_ID=2 ";
                 }
                $cond_custtype=",custtype  ";                
	 }
      
   if($dbh)
    {
	$disable  =  $email_comment =  $flag = $con_res = $grp = $comments =  '';
        if ($rej_reason !=  'All')
        {
                $flag="AND ETO_OFR_REJECT_REASON='$rej_reason'";
        }
	
        if ($rej_comment == '1')
	{
	$comments= "AND ETO_OFR_REJECT_COMMENT IS NOT NULL";
        $email_comment= "HAVING SUM(CASE WHEN ETO_OFR_REJECT_COMMENT IS NULL THEN 0 ELSE 1 END)>0";
	}
	if ($rej_comment == '2')
	{
	$comments= "AND ETO_OFR_REJECT_COMMENT IS NULL";
        $email_comment="HAVING SUM(CASE WHEN ETO_OFR_REJECT_COMMENT IS NULL THEN 0 ELSE 1 END)=0";
	}
         $sql="select * from 
(
    SELECT 
    (SELECT COUNT(1) FROM ETO_OFR_REJECTED WHERE FK_GLUSR_USR_ID =T.FK_GLUSR_USR_ID)LEAD_REJ_TILLDATE,
    LEAD_REJ_IN_DUR, LEAD_REJ_IN_DUR_NEG_MCAT, FK_GLUSR_USR_ID,GLUSR_USR_COMPANYNAME,GLUSR_USR_CUSTTYPE_NAME, 
     LEAD_PUR 
    FROM 
    (                  
        SELECT B.FK_GLUSR_USR_ID, LEAD_REJ_IN_DUR, LEAD_REJ_IN_DUR_NEG_MCAT,  GLUSR_USR_COMPANYNAME, GLUSR_USR_CUSTTYPE_NAME, 
        COUNT(CASE WHEN FK_ETO_OFR_ID>-1 THEN 1 END)LEAD_PUR 
        FROM
        (
            SELECT A.FK_GLUSR_USR_ID,  GLUSR_USR_COMPANYNAME, GLUSR_USR_CUSTTYPE_NAME, COUNT(1) LEAD_REJ_IN_DUR, 
            COUNT(B.FK_GLUSR_USR_ID) LEAD_REJ_IN_DUR_NEG_MCAT 
            FROM
            (
                SELECT FK_REJ_MCAT, FK_GLUSR_USR_ID,                                        
                GLUSR_USR_COMPANYNAME, GLUSR_USR_CUSTTYPE_NAME 
                FROM ETO_OFR_REJECTED, 
                GLUSR_USR $cond_custtype 
                WHERE DATE(ETO_OFR_REJECT_DT) >= TO_DATE(:START_DATE,'DD-MON-YYYY')                                        
                AND DATE(ETO_OFR_REJECT_DT) <= TO_DATE(:END_DATE,'DD-MON-YYYY')
                AND GLUSR_USR_ID  = FK_GLUSR_USR_ID    
                $flag $comments  $cond_custtype_join   
            )A LEFT JOIN NEGATIVE_MCAT_FOR_PRODUCTS B
            ON A.FK_GLUSR_USR_ID = B.FK_GLUSR_USR_ID 
            AND A.FK_REJ_MCAT=FK_GLCAT_MCAT_ID
            GROUP BY A.FK_GLUSR_USR_ID,                                        
            GLUSR_USR_COMPANYNAME, GLUSR_USR_CUSTTYPE_NAME
        )B LEFT JOIN ETO_LEAD_PUR_HIST C
        ON B.FK_GLUSR_USR_ID = C.FK_GLUSR_USR_ID
        GROUP BY B.FK_GLUSR_USR_ID, LEAD_REJ_IN_DUR, LEAD_REJ_IN_DUR_NEG_MCAT, GLUSR_USR_COMPANYNAME, GLUSR_USR_CUSTTYPE_NAME
    )T 
) A ORDER BY LEAD_REJ_IN_DUR desc";
	 
//echo " <pre>"; print_r($sql);  echo"</pre>";
$bind=array();
		$bind[':START_DATE']=$start_date;
		$bind[':END_DATE']=$end_date;
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);   	
		return array($sth,$fp,$filename);
            }
	  }
	  
	  
public function summary_relevancy($dbh)
      {
		
		$obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
		}
		
        $rejectn_src = '';
        $service = '';       
   
    if(isset($_REQUEST['r1']))
    {
        $rejectn_src = $_REQUEST['r1'];
    }
   if(!empty($_REQUEST['start_date']))
    $start_date = $_REQUEST['start_date'];
    else
    $start_date='';
    if(!empty($_REQUEST['end_date']))
    $end_date = $_REQUEST['end_date'];
    else
    $end_date='';
        
   
   if($dbh_pg)
    {
        if(isset($_REQUEST['service'])){
                if($_REQUEST['service']=='Catalog'){
                    $service=" AND GLUSR_USR.GLUSR_USR_CUSTTYPE_WEIGHT IN(149,179,199,699,750,1870,2199) ";
                }elseif($_REQUEST['service']=='Buylead'){
                    $service=" AND  GLUSR_USR.GLUSR_USR_CUSTTYPE_WEIGHT IN(1299,1449,2399,3984,3979) ";
                }elseif($_REQUEST['service']=='Free Catalog'){
                    $service=" AND (FCP_FLAG=1 OR GLUSR_USR_CUSTTYPE_WEIGHT IN(1399,1869,1879,1890,1899,3299,3399,3999,4299)) ";
                }                
            }

    $fetch_source = '';
    if($rejectn_src == 'Email')
    {
        $fetch_source = "AND FK_GL_MODULE_ID ='EMKTG' AND ETO_SRCH_TEXT IS NULL ";
    }
        if($rejectn_src == 'MIM')
    {
        $fetch_source = "AND FK_GL_MODULE_ID ='IMOB' AND ETO_SRCH_TEXT IS NULL ";
    }
        if($rejectn_src == 'APP')
    {
        $fetch_source = "AND FK_GL_MODULE_ID IN ('FUSION','ANDROID','FUSIONA','FUSIONM','FUSIONI','FUSIONW') AND ETO_SRCH_TEXT IS NULL ";
    }

    if($rejectn_src == 'MY')
    {
      $fetch_source = " AND FK_GL_MODULE_ID ='MY' AND ETO_SRCH_TEXT IS NULL  ";
    }
    if($rejectn_src == 'Search')
    {
      $fetch_source = " AND ETO_SRCH_TEXT IS NOT NULL ";
    }
   
   if($end_date && $start_date)
   {
	

	$sql = "SELECT   reason reason_id, 
	COALESCE((SELECT iil_master_data_value_text 
							 FROM   iil_master_data 
							 WHERE  iil_master_data_value = reason 
							 AND    fk_iil_master_data_type_id = 15) ,reason)
			 || ' [ ' 
			 || reason 
			 || ' ] ' AS reason, 
	Sum(my)              my, 
	Sum(email)           email, 
	Sum(search1)         search1, 
	Sum(inleads)         inleads, 
	Sum(frleads)         frleads, 
	Sum(mobile_app)      mobile_app, 
	Sum(mobile_site)     mobile_site 
FROM     ( 
			 SELECT   eto_ofr_rejected.reason, 
					  Count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'MY' 
							   AND      eto_srch_text IS NULL THEN 1 
					  END) my, 
					  Count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'EMKTG' THEN 1 
					  END) email, 
					  Count( 
					  CASE 
							   WHEN eto_srch_text IS NOT NULL THEN 1 
					  END) search1, 
					  Count( 
					  CASE 
							   WHEN eto_ofr.fk_gl_country_iso = 'IN' THEN eto_ofr.fk_gl_country_iso
					  END) inleads, 
					  Count( 
					  CASE 
							   WHEN eto_ofr.fk_gl_country_iso <> 'IN' THEN eto_ofr.fk_gl_country_iso
					  END) frleads, 
					  Count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id IN ( 'FUSION', 
																		 'ANDROID', 
																		 'FUSIONA', 
																		 'FUSIONM', 
																		 'FUSIONI', 
																		 'FUSIONW' ) THEN 1
					  END) mobile_app, 
					  Count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'IMOB' THEN 1 
					  END) mobile_site 
			 FROM     ( 
							 SELECT fk_eto_ofr_id, 
									fk_glusr_usr_id, 
									eto_srch_text, 
									Rtrim(Ltrim(eto_ofr_reject_reason, ','), ',') reason, 
									fk_gl_module_id 
							 FROM   eto_ofr_rejected 
							 WHERE  date(eto_ofr_reject_dt) between to_date(:START_DATE,'DD-MON-YYYY') and to_date(:END_DATE,'DD-MON-YYYY') $fetch_source ) eto_ofr_rejected, 
							 
					  eto_ofr, 
					  glusr_usr 
			 WHERE    eto_ofr_display_id = eto_ofr_rejected.fk_eto_ofr_id 
			 AND      glusr_usr.glusr_usr_id = eto_ofr_rejected.fk_glusr_usr_id $service 
			 GROUP BY eto_ofr_rejected.reason 
			 UNION ALL 
			 SELECT   eto_ofr_rejected.reason, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'MY' 
							   AND      eto_srch_text IS NULL THEN 1 
					  END) my, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'EMKTG' THEN 1 
					  END) email, 
					  count( 
					  CASE 
							   WHEN eto_srch_text IS NOT NULL THEN 1 
					  END) search1, 
					  count( 
					  CASE 
							   WHEN eto_ofr.fk_gl_country_iso = 'IN' THEN eto_ofr.fk_gl_country_iso
					  END) inleads, 
					  count( 
					  CASE 
							   WHEN eto_ofr.fk_gl_country_iso <> 'IN' THEN eto_ofr.fk_gl_country_iso
					  END) frleads, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id IN ( 'FUSION', 
																		 'ANDROID', 
																		 'FUSIONA', 
																		 'FUSIONM', 
																		 'FUSIONI', 
																		 'FUSIONW' ) THEN 1
					  END) mobile_app, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'IMOB' THEN 1 
					  END) mobile_site 
			 FROM     ( 
							 SELECT fk_eto_ofr_id, 
									fk_glusr_usr_id, 
									eto_srch_text, 
									rtrim(ltrim(eto_ofr_reject_reason, ','), ',') reason, 
									fk_gl_module_id 
							 FROM   eto_ofr_rejected 
							 WHERE  date(eto_ofr_reject_dt) between to_date(:START_DATE,'DD-MON-YYYY') and to_date(:END_DATE,'DD-MON-YYYY') $fetch_source ) eto_ofr_rejected, 
					  eto_ofr_expired eto_ofr, 
					  glusr_usr 
			 WHERE    eto_ofr_display_id = eto_ofr_rejected.fk_eto_ofr_id 
			 AND      glusr_usr.glusr_usr_id = eto_ofr_rejected.fk_glusr_usr_id $service 
			 GROUP BY eto_ofr_rejected.reason 
			 UNION ALL 
			 SELECT   eto_ofr_rejected.reason, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'MY' 
							   AND      eto_srch_text IS NULL THEN 1 
					  END) my, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'EMKTG' THEN 1 
					  END) email, 
					  count( 
					  CASE 
							   WHEN eto_srch_text IS NOT NULL THEN 1 
					  END) search1, 
					  count( 
					  CASE 
							   WHEN eto_ofr.fk_gl_country_iso = 'IN' THEN eto_ofr.fk_gl_country_iso
					  END) inleads, 
					  count( 
					  CASE 
							   WHEN eto_ofr.fk_gl_country_iso <> 'IN' THEN eto_ofr.fk_gl_country_iso
					  END) frleads, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id IN ( 'FUSION', 
																		 'ANDROID', 
																		 'FUSIONA', 
																		 'FUSIONM', 
																		 'FUSIONI', 
																		 'FUSIONW' ) THEN 1
					  END) mobile_app, 
					  count( 
					  CASE 
							   WHEN eto_ofr_rejected.fk_gl_module_id = 'IMOB' THEN 1 
					  END) mobile_site 
			 FROM     ( 
							 SELECT fk_eto_ofr_id, 
									fk_glusr_usr_id, 
									eto_srch_text, 
									rtrim(ltrim(eto_ofr_reject_reason, ','), ',') reason, 
									fk_gl_module_id 
							 FROM   eto_ofr_rejected 
							 WHERE  date(eto_ofr_reject_dt) between to_date(:START_DATE,'DD-MON-YYYY') and to_date(:END_DATE,'DD-MON-YYYY') $fetch_source ) eto_ofr_rejected, 
					  eto_ofr_temp_del eto_ofr, 
					  glusr_usr 
			 WHERE    eto_ofr_display_id = eto_ofr_rejected.fk_eto_ofr_id 
			 AND      glusr_usr.glusr_usr_id = eto_ofr_rejected.fk_glusr_usr_id $service 
			 GROUP BY eto_ofr_rejected.reason)a 
GROUP BY reason 
ORDER BY reason_id";     

		$bind[':START_DATE']=$start_date;
		$bind[':END_DATE']=$end_date;
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind);   	
		
         return array($sth);
         
         }
         else
         {
          echo "Date Not Specified Correctly";
          exit;
         }
            }       
   
    }
    
    
	public function detaildata($dbh,$sbjVal,$start_date,$end_date){

		$obj = new Globalconnection();
        $model = new GlobalmodelForm();
      										
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh_pg = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh_pg = $obj->connect_db_yii('postgress_web68v'); 
		}

		if($sbjVal=='' || $start_date=='' || $end_date ==''){
				$emp_id =Yii::app()->session['empid'];
				$empemail= Yii::app()->session['empemail'];
				mail("laxmi@indiamart.com","detaildata Manage Buy Leads >> Not Interested Report","The employee id is $emp_id and the email id is $empemail sbjVal : $sbjVal start_date: $start_date end_date: $end_date");
				echo "Input Parameter missing";exit;        
			}
			
		   $rej_my = array();
		$tempdata='';$response ='';
		$timestamp=time();
		$emp = Yii::app()->session['empid']; 
		$filename_out = "/home3/indiamart/public_html/excel_download/bulk_bigbuyer_output/";
		$filename_out .= 'rejection_reoprt_'.$emp.'_'.$timestamp.'.xls';
		$file = fopen($filename_out, 'w');
		
		$condition='';   
		if ($sbjVal <> "" && $start_date <> "" && $end_date <> "" )
		{
			$condition = " AND date(ETO_OFR_REJECT_DT) BETWEEN TO_DATE(:start_date,'DD-MON-YYYY') AND TO_DATE(:end_date,'DD-MON-YYYY')  ";
			
		}else{
			echo 'Input Parameter missing -GLID/Start Date/End Date';exit;
		}
				
		$sql_rejection = "SELECT
					DISTINCT FK_GLCAT_MCAT_ID,				
					SUM(MY) MYLEADS
				FROM
					(
					SELECT
						DISTINCT FK_GLCAT_MCAT_ID,
						0 AS EMAIL,
						COUNT(1) MY
					FROM
						(
						SELECT
							ETO_OFR.FK_GLCAT_MCAT_ID
						FROM
							ETO_OFR,(SELECT FK_ETO_OFR_ID,ETO_OFR_REJECT_DT FROM ETO_OFR_REJECTED WHERE FK_GLUSR_USR_ID = :userid) ETO_OFR_REJECTED_EMAIL
						WHERE
							ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_OFR_REJECTED_EMAIL.FK_ETO_OFR_ID $condition
						UNION ALL
						SELECT
							ETO_OFR_EXPIRED.FK_GLCAT_MCAT_ID
						FROM
							ETO_OFR_EXPIRED,(SELECT FK_ETO_OFR_ID,ETO_OFR_REJECT_DT FROM ETO_OFR_REJECTED WHERE FK_GLUSR_USR_ID = :userid) ETO_OFR_REJECTED
						WHERE
							ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_OFR_REJECTED.FK_ETO_OFR_ID $condition
							
					UNION ALL
					
						SELECT ETO_OFR_TEMP_DEL.FK_GLCAT_MCAT_ID 
						FROM 
						ETO_OFR_TEMP_DEL,(SELECT FK_ETO_OFR_ID,ETO_OFR_REJECT_DT FROM ETO_OFR_REJECTED WHERE FK_GLUSR_USR_ID = :userid)
						 ETO_OFR_REJECTED_MY
						WHERE ETO_OFR_TEMP_DEL.ETO_OFR_DISPLAY_ID=ETO_OFR_REJECTED_MY.FK_ETO_OFR_ID $condition
					
						) A
					GROUP BY
						FK_GLCAT_MCAT_ID
				) B
				GROUP BY
					FK_GLCAT_MCAT_ID";

				
				$bind_rejection[':userid']=$sbjVal;
				$bind_rejection[':start_date']=$start_date;
				$bind_rejection[':end_date']=$end_date;
				$sth_rejection = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql_rejection, $bind_rejection);   
				
				

	 $sql = "with A as
	 (
	 SELECT
	  
	 ETO_SRCH_TEXT,T.FK_ETO_OFR_ID FK_ETO_OFR_ID,
	 ETO_OFR.FK_GLCAT_MCAT_ID MCAT_ID_REJECTED,
	 ETO_OFR.ETO_OFR_GLCAT_MCAT_NAME,
	 ETO_OFR_REJECT_DT_DISP,
	 (case when LEADS_PURCHASED is NULL then '-' else LEADS_PURCHASED::text end) LEADS_PURCHASED,
	 PRD_COUNT,
	 ETO_OFR.ETO_OFR_VERIFIED,
	 FLAG,
	 ETO_OFR_MAIL_SENT_DATE,
	 (case when ETO_OFR_REJECT_REASON is NULL then '' else (case when (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) is NULL then RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') else 
	 (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA
		 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) end) end)  AS ETO_OFR_REJECT_REASON,
	 TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT,
	 FK_REJ_MCAT,ETO_OFR_REJ_TAB_INDEX,
		 (SELECT GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_REJ_MCAT) MCAT_NAME,
	 T.ETO_OFR_REJECT_DT,
	 T.FK_ETO_OFR_DISPLAY_ID,
	 ETO_OFR.FK_GLUSR_USR_ID
		 FROM
	 (
	 SELECT
	 ETO_SRCH_TEXT,ETO_OFR_REJECTED.FK_ETO_OFR_ID , FLAG, ETO_OFR_MAIL_SENT_DATE, 
	 (case when ETO_OFR_REJECT_REASON is NULL then '' else (case when (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) is NULL then RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') else 
	 (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) end) end)  AS ETO_OFR_REJECT_REASON,
	 TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT, FK_REJ_MCAT,ETO_OFR_REJ_TAB_INDEX, MCAT_NAME, ETO_OFR_REJECTED.ETO_OFR_REJECT_DT, 
	 ETO_LEAD_SUPPLIER_MAPPING.FK_ETO_OFR_DISPLAY_ID, ETO_OFR_REJECT_DT_DISP
	 FROM
	 
	 (
	 SELECT
	 ETO_SRCH_TEXT,ETO_OFR_REJECTED.FK_GL_MODULE_ID FLAG, FK_ETO_OFR_ID, FK_GLUSR_USR_ID, ETO_OFR_REJECT_DT, TO_CHAR(ETO_OFR_REJECT_DT,'DD-MON-YYYY') ETO_OFR_REJECT_DT_DISP, 
	 (case when ETO_OFR_REJECT_REASON is NULL then '' else (case when (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) is NULL then RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') else 
	 (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) end) end)  AS ETO_OFR_REJECT_REASON,
	 TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT,FK_REJ_MCAT,ETO_OFR_REJ_TAB_INDEX,
	 (SELECT GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_REJ_MCAT) MCAT_NAME,NULL ETO_OFR_MAIL_SENT_DATE
	 FROM
	 ETO_OFR_REJECTED
	 WHERE
	 ETO_OFR_REJECTED.FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
		 $condition
		 ) ETO_OFR_REJECTED
	  
	 LEFT OUTER JOIN
	  ETO_LEAD_SUPPLIER_MAPPING ON 
	 ETO_OFR_REJECTED.FK_GLUSR_USR_ID = ETO_LEAD_SUPPLIER_MAPPING.FK_GLUSR_USR_ID
	 AND ETO_OFR_REJECTED.FK_ETO_OFR_ID = ETO_LEAD_SUPPLIER_MAPPING.FK_ETO_OFR_DISPLAY_ID
	 )T
	 inner join 
	 ETO_OFR on T.FK_ETO_OFR_ID = ETO_OFR.ETO_OFR_DISPLAY_ID
	 left outer join
	 (SELECT
	 COUNT(1) LEADS_PURCHASED, ETO_OFR_ALL.FK_GLCAT_MCAT_ID MCAT_ID_PURCHASED
	 FROM
	 (
	 SELECT FK_ETO_OFR_ID FROM ETO_LEAD_PUR_HIST WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID AND FK_ETO_OFR_ID > -1
	 ) PUR_HIST,
	 (
	 SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID FROM ETO_OFR
	 UNION ALL 
	 SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED
	 UNION ALL
	 SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID FROM ETO_OFR_TEMP_DEL
	 ) ETO_OFR_ALL
	 WHERE
	 ETO_OFR_ALL.ETO_OFR_DISPLAY_ID = PUR_HIST.FK_ETO_OFR_ID
	 GROUP BY
	 ETO_OFR_ALL.FK_GLCAT_MCAT_ID)PUR_HIST
	 ON ETO_OFR.FK_GLCAT_MCAT_ID
	  = PUR_HIST.MCAT_ID_PURCHASED
	 LEFT OUTER JOIN
	 (SELECT
	 COUNT(1) PRD_COUNT,FK_GLCAT_MCAT_ID P_MCAT_ID
	 FROM
	 PC_ITEM_TO_GLCAT_MCAT,
	 PC_ITEM
	 WHERE
	 PC_ITEM_ID = FK_PC_ITEM_ID
	 AND pc_item_glusr_usr_id = :FK_GLUSR_USR_ID
	 GROUP BY
	 FK_GLCAT_MCAT_ID
	 )PRODUCT
	 ON ETO_OFR.FK_GLCAT_MCAT_ID
	  = PRODUCT.P_MCAT_ID
	 UNION ALL 
	 SELECT
	 ETO_SRCH_TEXT,T.FK_ETO_OFR_ID FK_ETO_OFR_ID,
	 ETO_OFR.FK_GLCAT_MCAT_ID MCAT_ID_REJECTED,
	 ETO_OFR.ETO_OFR_GLCAT_MCAT_NAME,
	 ETO_OFR_REJECT_DT_DISP,
	 (case when LEADS_PURCHASED is NULL then '-' else LEADS_PURCHASED::text end) LEADS_PURCHASED,
	 PRD_COUNT,
	 ETO_OFR.ETO_OFR_VERIFIED,
	 FLAG,
	 ETO_OFR_MAIL_SENT_DATE,
	 (case when ETO_OFR_REJECT_REASON is NULL then '' else (case when (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) is NULL then RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') else 
	 (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) end) end)  AS ETO_OFR_REJECT_REASON,
	 TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT,
	 FK_REJ_MCAT,ETO_OFR_REJ_TAB_INDEX,
	 (SELECT GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_REJ_MCAT) MCAT_NAME,
	 T.ETO_OFR_REJECT_DT,
	 T.FK_ETO_OFR_DISPLAY_ID,
	 ETO_OFR.FK_GLUSR_USR_ID
		 FROM
	 (
	 SELECT
	 ETO_SRCH_TEXT,ETO_OFR_REJECTED.FK_ETO_OFR_ID , FLAG, ETO_OFR_MAIL_SENT_DATE, 
	 (case when ETO_OFR_REJECT_REASON is NULL then '' else (case when (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) is NULL then RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') else 
	 (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) end) end)  AS ETO_OFR_REJECT_REASON,
	 TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT, FK_REJ_MCAT,ETO_OFR_REJ_TAB_INDEX, MCAT_NAME, ETO_OFR_REJECTED.ETO_OFR_REJECT_DT, 
	 ETO_LEAD_SUPPLIER_MAPPING.FK_ETO_OFR_DISPLAY_ID, ETO_OFR_REJECT_DT_DISP
	 FROM
	 
	 (
	 SELECT
	 TRIM (ETO_SRCH_TEXT) ETO_SRCH_TEXT,ETO_OFR_REJECTED.FK_GL_MODULE_ID FLAG, FK_ETO_OFR_ID, FK_GLUSR_USR_ID, ETO_OFR_REJECT_DT, 
	 TO_CHAR(ETO_OFR_REJECT_DT,'DD-MON-YYYY') ETO_OFR_REJECT_DT_DISP,  
	 (case when ETO_OFR_REJECT_REASON is NULL then '' else (case when (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA 
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) is NULL then RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') else 
	 (select IIL_MASTER_DATA_VALUE_TEXT from IIL_MASTER_DATA
	 where IIL_MASTER_DATA_VALUE = RTRIM(LTRIM(ETO_OFR_REJECT_REASON,','),',') and FK_IIL_MASTER_DATA_TYPE_ID=15) end) end)  AS ETO_OFR_REJECT_REASON,
	 TRIM (ETO_OFR_REJECT_COMMENT) ETO_OFR_REJECT_COMMENT,FK_REJ_MCAT,ETO_OFR_REJ_TAB_INDEX,
	 (SELECT GLCAT_MCAT_NAME FROM GLCAT_MCAT WHERE GLCAT_MCAT_ID=FK_REJ_MCAT) MCAT_NAME,NULL ETO_OFR_MAIL_SENT_DATE
	 FROM
	 ETO_OFR_REJECTED
	 WHERE
	 ETO_OFR_REJECTED.FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID
		$condition  
	 ) ETO_OFR_REJECTED
	 left join ETO_LEAD_SUPPLIER_MAPPING
	 ON
	  ETO_OFR_REJECTED.FK_GLUSR_USR_ID = ETO_LEAD_SUPPLIER_MAPPING.FK_GLUSR_USR_ID
	 AND ETO_OFR_REJECTED.FK_ETO_OFR_ID = ETO_LEAD_SUPPLIER_MAPPING.FK_ETO_OFR_DISPLAY_ID
	 )T inner join 
	 ETO_OFR_EXPIRED ETO_OFR
	 ON T.FK_ETO_OFR_ID = ETO_OFR.ETO_OFR_DISPLAY_ID
	 left join
	 (SELECT
	 COUNT(1) LEADS_PURCHASED, ETO_OFR_ALL.FK_GLCAT_MCAT_ID MCAT_ID_PURCHASED
	 FROM
	 (
	 SELECT FK_ETO_OFR_ID FROM ETO_LEAD_PUR_HIST WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID AND FK_ETO_OFR_ID > -1
	 )PUR_HIST,
	 (
	 SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID FROM ETO_OFR
	 UNION ALL 
	 SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED
	 UNION ALL 
	 SELECT ETO_OFR_DISPLAY_ID, FK_GLCAT_MCAT_ID FROM ETO_OFR_TEMP_DEL
	 ) ETO_OFR_ALL
	 WHERE
	 ETO_OFR_ALL.ETO_OFR_DISPLAY_ID = PUR_HIST.FK_ETO_OFR_ID
	 GROUP BY
	 ETO_OFR_ALL.FK_GLCAT_MCAT_ID
	 )PUR_HIST
	 ON ETO_OFR.FK_GLCAT_MCAT_ID
	  = PUR_HIST.MCAT_ID_PURCHASED
	 left join
	 (SELECT
	 COUNT(1) PRD_COUNT,FK_GLCAT_MCAT_ID P_MCAT_ID
	 FROM
	 PC_ITEM_TO_GLCAT_MCAT,
	 PC_ITEM
	 WHERE
	 PC_ITEM_ID = FK_PC_ITEM_ID
	 AND pc_item_glusr_usr_id = :FK_GLUSR_USR_ID
	 GROUP BY
	  FK_GLCAT_MCAT_ID
	 )PRODUCT
	 ON ETO_OFR.FK_GLCAT_MCAT_ID
	  = PRODUCT.P_MCAT_ID
	 )
	 SELECT
	 A.*,
	 (case when ETO_CLICK_SEARCH = 1 then 'SEARCH' else '-' end )REJ_SOURCE,
	 ETO_CLICK_COUNTRY,
	 b.FK_GLCAT_MCAT_ID GLMCAT_ID,
	 b.glcat_mcat_name GLMCAT_ID_NAME,
	 b.GLCAT_MCAT_IS_GENERIC,
	 b.ETO_TRD_ALERT_DISABLED_ON,
	 b.ETO_TRD_ALERT_RANK
	 from
	 A left join
	 (
	 SELECT X.*,null::numeric ETO_CLICK_SEARCH
	 , null ETO_CLICK_COUNTRY
	 FROM
	 (
	 SELECT
		 eto_ofr_mapping.FK_ETO_OFR_ID,
		 eto_trd_alert_v2.FK_GLCAT_MCAT_ID,
		 glcat_mcat.glcat_mcat_name,GLCAT_MCAT_IS_GENERIC,ETO_TRD_ALERT_DISABLED_ON,COALESCE(ETO_TRD_ALERT_RANK,'NA') ETO_TRD_ALERT_RANK,row_number() 
		 over(partition by eto_ofr_mapping.FK_ETO_OFR_ID order by (case when eto_trd_alert_v2.FK_GLCAT_MCAT_ID=PRIME_MCAT then 1 else 2 end)) rn
	 FROM
		 eto_ofr_mapping,
		 eto_trd_alert_v2,
		 glcat_mcat
	 ,A
	 WHERE
		 eto_ofr_mapping.FK_GLCAT_MCAT_ID=eto_trd_alert_v2.FK_GLCAT_MCAT_ID
		 AND eto_trd_alert_v2.FK_GLUSR_USR_ID=:FK_GLUSR_USR_ID
		 and glcat_mcat_id=eto_trd_alert_v2.FK_GLCAT_MCAT_ID
		 AND ETO_TRD_ALERT_TYP='B'
		 AND ETO_TRD_ALERT_DISABLED_BY IS NULL
		 and eto_ofr_mapping.FK_ETO_OFR_ID=A.FK_ETO_OFR_ID
		 UNION ALL  
	 SELECT
		 eto_ofr_mapping_expired.FK_ETO_OFR_ID,
		 eto_trd_alert_v2.FK_GLCAT_MCAT_ID,
		 glcat_mcat.glcat_mcat_name,
		 GLCAT_MCAT_IS_GENERIC,
		 ETO_TRD_ALERT_DISABLED_ON,
		 COALESCE(ETO_TRD_ALERT_RANK,'NA') ETO_TRD_ALERT_RANK,
		 row_number() over(partition BY eto_ofr_mapping_expired.FK_ETO_OFR_ID order by (CASE WHEN eto_trd_alert_v2.FK_GLCAT_MCAT_ID=PRIME_MCAT THEN 1 ELSE 2END)) rn
	 FROM
		 eto_ofr_mapping_expired,eto_trd_alert_v2,glcat_mcat
	 ,A
	 WHERE
		 eto_ofr_mapping_expired.FK_GLCAT_MCAT_ID=eto_trd_alert_v2.FK_GLCAT_MCAT_ID
		 AND eto_trd_alert_v2.FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID
		 AND glcat_mcat_id =eto_trd_alert_v2.FK_GLCAT_MCAT_ID
		 AND ETO_TRD_ALERT_TYP ='B'
		 AND ETO_TRD_ALERT_DISABLED_BY IS NULL
		 and eto_ofr_mapping_expired.FK_ETO_OFR_ID = A.FK_ETO_OFR_ID
	 )X where rn=1
	 )b
	 on A.FK_ETO_OFR_ID = b.FK_ETO_OFR_ID
	 ORDER BY TO_DATE(ETO_OFR_REJECT_DT_DISP,'DD-MON-YYYY') DESC	 
	 ";
	$bind[':FK_GLUSR_USR_ID']=$sbjVal;
	$bind[':start_date']=$start_date;
	$bind[':end_date']=$end_date;
	$sth_list = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, $bind);  
	
							
		   while (  $sql_row =  $sth_rejection->read())
			{
				$sql_row=array_change_key_case($sql_row, CASE_UPPER); 	
				$tempdata = $sql_row['FK_GLCAT_MCAT_ID'];
				$rej_my[$tempdata] = $sql_row['MYLEADS'];
			}
			$response = '<table id="detaildata" class="display" style="width:100%">
				<thead><tr>
					<th align="CENTER" width="6%" >Offer ID</th>
					<th align="CENTER" width="12%" >Prime MCAT Name</th>
					<th align="CENTER" width="12%" >USER MCAT Name (Rank)</th>
					<th align="CENTER" width="9%" >Rejection Date</th>
					<th align="CENTER" width="6%" >Leads Purchased</th>
					<th align="CENTER" width="6%" >Leads Rejected</th>			
					<th align="CENTER" width="5%" >Product Mapped</th>
					<th align="CENTER" width="9%" >Verified / Updated</th>
					<th align="CENTER" width="5%" >Source</th>
					<th align="CENTER" width="8%" >Mail Sent Date/Search Text</th>
					<th align="LEFT" width="15%" >Rejection Reason</th>
					<th align="LEFT" width="7%" >Tab Location</th>
				</TR></thead><tbody>';
				$var =  "Offer ID , Prime MCAT Name ,USER MCAT Name (Rank) ,Rejection Date,Leads Purchased ,Leads Rejected,Product Mapped ,Verified / Updated ,Source ,Mail Sent Date/Search Text ,Rejection Reason ,Tab Location";
				fwrite($file,"$var\n");
				
		$cnt=0;
		$rej_source = array();
			$temp='';
			$row =1;
			$var= '';
			$var1= '';
				if($sth_list){				  
			while ( $rec =  $sth_list->read())
				{
					$rec=array_change_key_case($rec, CASE_UPPER); 
					
					$cnt++;	
					$temp = $rec['FK_ETO_OFR_ID'];
					$rej_source[$temp] = $rec['REJ_SOURCE'];
					
					if(isset($rec['SEARCH']))
					{
					$search_Flag = $rec['SEARCH'];
					}
					else
					{
					$search_Flag = '';
					}
					if(isset($rec['GLMCAT_ID_NAME']))
					{
					$rec['GLMCAT_ID_NAME'] = $rec['GLMCAT_ID_NAME'];
					}
					else
					{$rec['GLMCAT_ID_NAME'] = '';}
					
					if(isset($rec['MCAT_NAME']))
					{
					$rec['MCAT_NAME']=$rec['MCAT_NAME'];
					}
					else
					{
					$rec['MCAT_NAME'] ='';
					}
					if(isset($rec['ETO_OFR_GLCAT_MCAT_NAME']))
					{
					$rec['ETO_OFR_GLCAT_MCAT_NAME']=$rec['ETO_OFR_GLCAT_MCAT_NAME'];
					}
					else
					{$rec['ETO_OFR_GLCAT_MCAT_NAME'] = '';}
					
					if(isset($rec['GLCAT_MCAT_IS_GENERIC']))
					{
					$rec['GLCAT_MCAT_IS_GENERIC']=$rec['GLCAT_MCAT_IS_GENERIC'];
					}
					else{$rec['GLCAT_MCAT_IS_GENERIC'] = '0';}
					
					if(isset($rec['ETO_OFR_REJ_TAB_INDEX']))
					{
					$rec['ETO_OFR_REJ_TAB_INDEX']=$rec['ETO_OFR_REJ_TAB_INDEX'];
					}
					else{$rec['ETO_OFR_REJ_TAB_INDEX'] = '';}
					 $Rej_date=$rec['ETO_OFR_REJECT_DT_DISP'];
					if(isset($rec['FK_ETO_OFR_DISPLAY_ID']))
					{
					$response .= '<TR bgcolor="#FFFFFF" >';
					}
					else
					{
					$response .= '<TR bgcolor="#FFFFFF" >';
					}
					$response .= '<TD ALIGN="CENTER" class="ttext1"><label onclick="javascript:window.open(\'/index.php?r=admin_eto/OfferDetail/editflaggedleads&mid=3424&&offer='.$rec['FK_ETO_OFR_ID'].'&mid=3424\',\'_blank\',\'directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200\')" style=\'color:blue;cursor:pointer\'>'.$rec['FK_ETO_OFR_ID'].'</label></TD>
						<TD ALIGN="LEFT" class="ttext1">'.$rec['ETO_OFR_GLCAT_MCAT_NAME'].'</TD>';
						if(isset($rec['GLMCAT_ID_NAME']) && ($rec['GLCAT_MCAT_IS_GENERIC'] > 0))
						{
							$response .= '<TD ALIGN="LEFT" class="ttext1">'.$rec['GLMCAT_ID_NAME'].'<B> ('.$rec['ETO_TRD_ALERT_RANK'].') </B><span style="color:red;font-weight:bold;">*</span></TD>';
						}
						else
						{
							$response .= '<TD ALIGN="LEFT" class="ttext1">'.$rec['GLMCAT_ID_NAME'].'<B> ('.$rec['ETO_TRD_ALERT_RANK'].') </B></TD>';
						}
						$response .= '<TD ALIGN="CENTER" class="ttext1">'.$rec['ETO_OFR_REJECT_DT_DISP'].'</td><TD ALIGN="CENTER" class="ttext1">';
                                                if(isset( $rec['LEADS_PURCHASED']) && ($rec['LEADS_PURCHASED'] <> '-'))
						 {
						$response .= '<label onclick="javascript:window.open(\'index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&MCAT_ID='.$rec['MCAT_ID_REJECTED'].'&glid='.$sbjVal.'&PurchaseFlag=1\',\'_blank\',\'directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200\')" style=\'color:blue;cursor:pointer\'>'.$rec['LEADS_PURCHASED'].'</label>';
						}
											 
                                                $response .= '</TD><TD ALIGN="CENTER" class="ttext1">';
                                               if(isset( $rec['MCAT_ID_REJECTED']) && ($rec['MCAT_ID_REJECTED'] <> '-'))
						 {
                                                        $response .= '<label onclick="javascript:window.open(\'index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&MCAT_ID='.$rec['MCAT_ID_REJECTED'].'&glid='.$sbjVal.'&PurchaseFlag=2&start_date='.$_REQUEST['start_date'].'&end_date='.$_REQUEST['end_date'].'\',\'_blank\',\'directories=no, status=no, menubar=no, scrollbars=yes, resizable=no,width=600, height=280,top=200,left=200\')" style=\'color:blue;cursor:pointer\'>'.$rej_my[$rec['MCAT_ID_REJECTED']].'</label>';
                                                 }
						$response .= '</TD><TD ALIGN="CENTER" class="ttext1">';
						if(isset( $rec['PRD_COUNT']) && ($rec['PRD_COUNT'] <> ''))
						 {
						 $response .= '<a href="javascript:win_detail(\'index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439&showproduct=1&mcatid='.$rec['MCAT_ID_REJECTED'].'&glusrid='.$sbjVal.'\')">'.$rec['PRD_COUNT'].'</a>';
											 }
						$response .= '</TD><TD ALIGN="LEFT" class="ttext1">';
						if($rec['ETO_OFR_VERIFIED'] ==2)
						{	$rec['ETO_OFR_VERIFIED']='Verified & Updated';
							$response .= '<span class="vlogoB"><SPAN CLASS="vlogo g9 bo d1">Verified &amp; Updated</SPAN></SPAN>';	
						}
						elseif($rec['ETO_OFR_VERIFIED']==1)
						{
							$response .= '<span class="vlogoB"><SPAN CLASS="vlogo g9 bo d1">Verified</SPAN></SPAN>';
							$rec['ETO_OFR_VERIFIED']='Verified';
						}
						elseif($rec['ETO_OFR_VERIFIED']==3)
						{
							$response .= '<span class="vlogoB"><SPAN CLASS="vlogo g9 bo d1">Updated</SPAN></SPAN>';
							$rec['ETO_OFR_VERIFIED']='Updated';
						}
						else
						{
							$rec['ETO_OFR_VERIFIED']=' ';
						}
						if(isset($rec['ETO_OFR_MAIL_SENT_DATE']))
							{$maildate=$rec['ETO_OFR_MAIL_SENT_DATE'];}
							else
							{$maildate = '';}
						if ($search_Flag != '')
						{
							$rec['FLAG']='Search';
							$maildate=$search_Flag;
						}
						$maildate .=isset($rec['ETO_SRCH_TEXT'])?$rec['ETO_SRCH_TEXT']:'';
						if(isset($rec['FK_ETO_OFR_DISPLAY_ID']))
						{
							$response .= '</TD><TD ALIGN="CENTER" class="ttext1">'.$rec['FLAG'].'<span style="color:red;font-weight:bold;">#</span></TD>';
						}
						else
						{
							$response .= '</TD><TD ALIGN="CENTER" class="ttext1">'.$rec['FLAG'].'</TD>';
						}
						$response .='<TD ALIGN="CENTER" class="ttext1">'.$maildate.'</TD>';
						if(isset($rec['ETO_OFR_REJECT_COMMENT']))
						{
						$response .='<TD ALIGN="LEFT" style="background-color: #FFF7C9;" class="ttext1 commented"><a class="info">'.$rec['ETO_OFR_REJECT_REASON'].'<br> <strong>'.$rec['MCAT_NAME'].' </strong>
						<div style="background-color: #FFEECA;word-wrap:break-word;"><u>Comment</u>:<br><br>'.$rec['ETO_OFR_REJECT_COMMENT'].'<br></div></a></TD>';
						}
						else
						{
						$response .= '<TD ALIGN="LEFT" class="ttext1" >'.$rec['ETO_OFR_REJECT_REASON'].' <br> <strong>'.$rec['MCAT_NAME'].' </strong></TD>';
						}
						$response .= '<TD ALIGN="CENTER" class="ttext1">'.$rec['ETO_OFR_REJ_TAB_INDEX'].'</TD>
					</TR>';
					
					 $var1 = ''.$rec['FK_ETO_OFR_ID'].','. $rec['ETO_OFR_GLCAT_MCAT_NAME'].','.$rec['GLMCAT_ID_NAME'].' ('.$rec['ETO_TRD_ALERT_RANK'].') ,'.$rec['ETO_OFR_REJECT_DT_DISP'].','.$rec['LEADS_PURCHASED'].','.$rej_my[$rec['MCAT_ID_REJECTED']].','.$rec['PRD_COUNT'].','.$rec['ETO_OFR_VERIFIED'].','.$rec['FLAG'].','.$maildate.','.$rec['ETO_OFR_REJECT_REASON'].','.$rec['ETO_OFR_REJ_TAB_INDEX'].'';
					fwrite($file,"$var1\n");		      
				$row++;	
			}
		}
			$response .='<div style="font-size:15px;font-family:arial;color:blue;" align="center"><b>'.$cnt.' Records Found </b></div>';
			$response .='</tbody></TABLE>';
                        if($row > 1)
			{
                        $response .= '</table></div>'
                                . '<div align="center"><A HREF="/index.php?r=admin_bl/Eto_rej_ofr/excelExport&mid=3439&filename='.$filename_out.'" '
                                . 'style="font-family:arial;font-size:16px;font-weight:bold">CLICK HERE TO DOWNLOAD ALL RECORDS</A></div></body></html>';
			}
			else
			{
				$response .='<div style="color:#FF0000;font-size:18px;font-family:arial" align="center">Sorry! 0 Records Found</div>';
			}echo $response;
			die;
	}    
		
        public function topmcatrejected(){
                $model = new GlobalmodelForm();
                $conn_obj=new Globalconnection();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
                }else{
                    $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
                }
		$start_date=$_REQUEST['start_date'];
		$end_date=$_REQUEST['end_date'];

            $sql="select * from (select fk_glcat_mcat_id,eto_ofr_glcat_mcat_name, count(eto_ofr_reject_id) cnt 
from
(
select b.fk_glcat_cat_id,b.eto_ofr_glcat_cat_name,b.eto_ofr_glcat_mcat_name,eto_ofr_reject_id,fk_glcat_mcat_id
from eto_ofr_rejected a,
    eto_ofr b
where date(eto_ofr_reject_dt) between '$start_date' and '$end_date' 
and a.fk_eto_ofr_id = b.eto_ofr_display_id
and eto_ofr_reject_reason ='1'
union
 
select b.fk_glcat_cat_id,b.eto_ofr_glcat_cat_name,b.eto_ofr_glcat_mcat_name,eto_ofr_reject_id,fk_glcat_mcat_id
from eto_ofr_rejected a,
    eto_ofr_expired b
where date(eto_ofr_reject_dt) between '$start_date' and '$end_date'
and a.fk_eto_ofr_id = b.eto_ofr_display_id
and eto_ofr_reject_reason ='1'
)A
group by fk_glcat_cat_id,eto_ofr_glcat_cat_name,eto_ofr_glcat_mcat_name,fk_glcat_mcat_id
order by cnt desc ) A limit 50 ";
              $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
		$head=array('Mcat ID','Mcat Name','Count');
		$html_str='';

		echo '<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" width="100%">';
		$html_str .='<tr>';
		for($i=0;$i<count($head);$i++){
			$html_str .= '<td  style="text-align:center;" bgcolor="#dff8ff" width="8%"><b>'.$head[$i].'</b></td>';
		}

            while($recResult = $sth->read()){  
                    //print_r($recResult);
                    $fk_glcat_mcat_id = $recResult['fk_glcat_mcat_id'];
                    $eto_ofr_glcat_mcat_name = $recResult['eto_ofr_glcat_mcat_name'];  
                    $cnt=$recResult['cnt'];
                    $html_str .= '<tr>'
                              . '<td  style="text-align:center;" >'.$fk_glcat_mcat_id.'</td>'
                              . '<td  style="text-align:center;" >'.$eto_ofr_glcat_mcat_name.'</td>'
                              . '<td  style="text-align:center;" >'.$cnt.'</td>'
                            . '</tr>';
                      
            }
            echo $html_str.'</table>';
        }
        }
	?>