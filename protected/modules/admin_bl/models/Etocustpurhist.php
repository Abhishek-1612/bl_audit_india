<?php
class Etocustpurhist extends CFormModel
{
     public function report($dbh,$conn_main_db,$data)
    { 
    $rec1=array();
    $start_date=$data['from_date'];
    $end_date=$data['to_date'];
    $emp_id=$data['emp_id'];
   // echo 'from date'.$start_date.'to date'.$end_date;
   // $sql="SELECT * FROM ETO_CUST_PURCHASE_HIST WHERE TRUNC(ETO_CUST_PURCHASE_DATE) BETWEEN '".$start_date."' AND '".$end_date."' ORDER BY ETO_CUST_PURCHASE_DATE DESC";
    if(!isset($data['pg']))
    {
     $start=0;
     $end=100;
    }
    else
    {
      if($data['pg']==1)
      {
         $start=0;
         $end=100;
      }
      else
       {  $start=($data['pg']-1)*100+1;
          $end=($data['pg'])*100; 
        }  
    }
 
 
   $sql1="SELECT COUNT(1) AS CNT
          FROM ETO_CUST_PURCHASE_HIST h,
              GLUSR_USR g,
               ACTIVE_FCP_DETAILS f,CUSTTYPE 
    WHERE g.GLUSR_USR_ID                 =h.FK_GLUSR_USR_ID  AND g.GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID(+) 
    AND h.FK_GLUSR_USR_ID                = f.FK_GLUSR_USR_ID(+)
    AND ((h.ETO_CUST_PURCHASE_CREDITS=200 AND h.ETO_CUST_PURCHASE_DATE >=TO_DATE('01-Jul-15') ) OR (h.ETO_CUST_PURCHASE_CREDITS=20 AND h.ETO_CUST_PURCHASE_DATE < TO_DATE('01-Jul-15')))
    AND g.FK_GL_COUNTRY_ISO              ='IN'
    AND (f.PRIORITY_RANGE               IS NULL
    OR f.PRIORITY_RANGE                 <> .9)
    AND (g.GLUSR_USR_LISTING_STATUS     IS NULL
    OR g.GLUSR_USR_LISTING_STATUS       = 'NFL')
    AND g.GLUSR_USR_CUSTTYPE_ID IN(14,16,17,18,19,20,23,24,25,26,27,7,4,6,9,5,8,11,13,22,21) and g.GLUSR_USR_CUSTTYPE_ID not in (7,13) 
    AND TRUNC(h.ETO_CUST_PURCHASE_DATE) BETWEEN '".$start_date."' AND '".$end_date."' ";
    $sth1=oci_parse($dbh,$sql1);
    oci_execute($sth1);
    $count1=oci_fetch_assoc($sth1);
    $count=$count1['CNT'];
    if(0)
    {
//  $sql="SELECT * FROM 
// (
//  SELECT A.*,ROWNUM RN 
//     FROM
//      (  SELECT h.ETO_CUST_ORDER_ID,
//         h.FK_GLUSR_USR_ID,
//         h.ETO_CUST_PURCHASE_DATE,
//         h.ETO_CUST_PURCHASE_CREDITS,
//         g.GLUSR_USR_EMAIL,
//         g.GLUSR_USR_EMAIL_ALT,
//         g.GLUSR_USR_PH_MOBILE,
//         h.ETO_CUST_GLUSR_ORGANIZATION,
//         h.ETO_CUST_PURCHASE_CUSTTYPE,
//         g.GLUSR_USR_LISTING_STATUS,        
//         CASE f.PRIORITY_RANGE
//         WHEN .9 THEN 'A'
//         WHEN .8 THEN 'B'
//         WHEN .7 THEN 'C'
//         WHEN .6 THEN 'D'
//         ELSE ' '
//         END PRIORITY_RANGE
//         FROM 
//             ETO_CUST_PURCHASE_HIST h JOIN GLUSR_USR g ON g.GLUSR_USR_ID=h.FK_GLUSR_USR_ID 
//             FULL OUTER JOIN ACTIVE_FCP_DETAILS f ON h.FK_GLUSR_USR_ID= f.FK_GLUSR_USR_ID
//             WHERE 
//             h.ETO_CUST_PURCHASE_CREDITS=20 AND (f.PRIORITY_RANGE IS NULL OR f.PRIORITY_RANGE <> .9) 
//             AND TRUNC(h.ETO_CUST_PURCHASE_DATE) BETWEEN '".$start_date."' AND '".$end_date."' 
//           ORDER BY 
//           ETO_CUST_PURCHASE_DATE DESC
//         )A 
//     )
//    WHERE RN >= $start AND RN <= $end";
}
   
  $sql="SELECT *
FROM
  (SELECT A.*,
    ROWNUM RN
  FROM
    (SELECT h.ETO_CUST_ORDER_ID,
      h.FK_GLUSR_USR_ID,
      h.ETO_CUST_PURCHASE_DATE,
      h.ETO_CUST_PURCHASE_CREDITS,
      g.GLUSR_USR_EMAIL,
      g.GLUSR_USR_EMAIL_ALT,
      g.GLUSR_USR_PH_MOBILE,
      h.ETO_CUST_GLUSR_ORGANIZATION,
      h.ETO_CUST_PURCHASE_CUSTTYPE,
      g.GLUSR_USR_LISTING_STATUS,
      CASE f.PRIORITY_RANGE
        WHEN .9
        THEN 'A'
        WHEN .8
        THEN 'B'
        WHEN .7
        THEN 'C'
        WHEN .6
        THEN 'D'
        ELSE ' '
      END PRIORITY_RANGE
    FROM ETO_CUST_PURCHASE_HIST h,
      GLUSR_USR g,
      ACTIVE_FCP_DETAILS f,CUSTTYPE 
    WHERE g.GLUSR_USR_ID                 =h.FK_GLUSR_USR_ID AND g.GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID(+)  
    AND h.FK_GLUSR_USR_ID                = f.FK_GLUSR_USR_ID(+)
    AND ((h.ETO_CUST_PURCHASE_CREDITS=200 AND h.ETO_CUST_PURCHASE_DATE >=TO_DATE('01-Jul-15') ) OR (h.ETO_CUST_PURCHASE_CREDITS=20 AND h.ETO_CUST_PURCHASE_DATE < TO_DATE('01-Jul-15')))
    AND g.FK_GL_COUNTRY_ISO              ='IN'
    AND (f.PRIORITY_RANGE               IS NULL
    OR f.PRIORITY_RANGE                 <> .9)
    AND (g.GLUSR_USR_LISTING_STATUS     IS NULL
    OR g.GLUSR_USR_LISTING_STATUS       = 'NFL')
    AND g.GLUSR_USR_CUSTTYPE_ID IN(14,16,17,18,19,20,23,24,25,26,27,7,4,6,9,5,8,11,13,22,21) and g.GLUSR_USR_CUSTTYPE_ID not in (7,13)
    AND TRUNC(h.ETO_CUST_PURCHASE_DATE) BETWEEN '".$start_date."' AND '".$end_date."'
    AND h.FK_GLUSR_USR_ID NOT IN(
				SELECT FK_GLUSR_USR_ID
				FROM GLUSR_USR_PRIVACY_SETTING
				WHERE FK_MY_PRIVACY_SETTING_ID=48
				)
    ORDER BY ETO_CUST_PURCHASE_DATE DESC
    )A
  )
WHERE RN >= $start
AND RN   <= $end";
    
   $sth=oci_parse($dbh,$sql);
    /*oci_bind_by_name($sth,':START',$start_date);
    oci_bind_by_name($sth,':END',$end_date);
    */
    oci_execute($sth);  
//     $nrows=oci_fetch_all($sth,$rec);
    
    $rec=array();
    
    while(($row= oci_fetch_assoc($sth)) != false)
    {
        array_unshift($rec,$row);   
    }
    
    $count_nfl=count($rec); 
    
    $sql_check_proforma="select PROFORMA_GLUSR_USR_ID from proforma WHERE PROFORMA_ISSUEDATE between sysdate-90 and sysdate";
    $command_proforma=oci_parse($conn_main_db,$sql_check_proforma);
    oci_execute($command_proforma);

   $glid_list_exclude=array();
    
    while(($row_glid = oci_fetch_assoc($command_proforma)) != false)
    {
        array_unshift($glid_list_exclude,$row_glid['PROFORMA_GLUSR_USR_ID']);
    }
    
    for($i=0;$i<$count_nfl;$i++)
    {
        if(in_array($rec[$i]["FK_GLUSR_USR_ID"],$glid_list_exclude))
        {
            unset($rec[$i]);
        }
    }
    /********************************COMMENT**********************************************/
    if(0)
    {
    
    $count_nfl=count($rec);
    
    $flag=array();
    for($i=0;$i<$count;$i++)
    {
        $flag[$i]=0;
    }
     for($i=0;$i<$count_nfl;$i++)
    {
        if(!in_array($rec["FK_GLUSR_USR_ID"][$i],$glid_list_exclude))
        {
             $flag[$i]=1;   
        }
    }
    for($i=0;$i<$count_nfl;$i++)
    {
        if($flag[$i]==1)
        {
	    foreach($rec as $key=>$value)
	    {
	        unset($key[$i]);
	    }
	}
    }
    
    echo "<pre>";
//     print_r($glid_list_exclude);
    
    $queue_record=array();
    
    while(($row = oci_fetch_assoc($sth)) != false)
    {
         array_unshift($queue_record,$row);
    }
//     print_r($queue_record);
   //var_dump($rec);
    $count_nfl=count($queue_record);
    
    for($i=0;$i<$count_nfl;$i++)
    {
        if(in_array($queue_record[$i]["FK_GLUSR_USR_ID"],$glid_list_exclude))
        {
             unset($queue_record[$i]);   
        }
    }
}/**********************COMMENT END***************************/
//    print_r($queue_record);
   
   return array('rec'=>$rec,'count'=>$count);
   }
   public function ExportExcel1($dbh,$conn_main_db,$data)
   {
           
                    $d1 = array();
                    $d2 = array();
                    $d3 = array();
                    $header = array();
                    $data1 = '';
                    $rec1=array();
                    $start_date=$data['from_date'];
                    $end_date=$data['to_date'];
                    $sql="    SELECT h.ETO_CUST_ORDER_ID,
        h.FK_GLUSR_USR_ID,
        h.ETO_CUST_PURCHASE_DATE,
        h.ETO_CUST_PURCHASE_CREDITS,
        g.GLUSR_USR_EMAIL,
        g.GLUSR_USR_EMAIL_ALT,
        g.GLUSR_USR_PH_MOBILE,
        h.ETO_CUST_GLUSR_ORGANIZATION,
        h.ETO_CUST_PURCHASE_CUSTTYPE,
        g.GLUSR_USR_LISTING_STATUS,        
        CASE f.PRIORITY_RANGE
        WHEN .9 THEN 'A'
        WHEN .8 THEN 'B'
        WHEN .7 THEN 'C'
        WHEN .6 THEN 'D'
        ELSE ' '
        END PRIORITY_RANGE
FROM 
    ETO_CUST_PURCHASE_HIST h,
    GLUSR_USR g,
    ACTIVE_FCP_DETAILS f,CUSTTYPE 
WHERE
    g.GLUSR_USR_ID=h.FK_GLUSR_USR_ID  AND g.GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID(+)  
    AND h.FK_GLUSR_USR_ID= f.FK_GLUSR_USR_ID(+) 
    AND ((h.ETO_CUST_PURCHASE_CREDITS=200 AND h.ETO_CUST_PURCHASE_DATE >=TO_DATE('01-Jul-15') ) OR (h.ETO_CUST_PURCHASE_CREDITS=20 AND h.ETO_CUST_PURCHASE_DATE < TO_DATE('01-Jul-15')))
    AND g.FK_GL_COUNTRY_ISO='IN' 
    AND (f.PRIORITY_RANGE IS NULL OR f.PRIORITY_RANGE <> .9)
    AND (g.GLUSR_USR_LISTING_STATUS IS NULL OR g.GLUSR_USR_LISTING_STATUS = 'NFL')
    AND g.GLUSR_USR_CUSTTYPE_ID IN(14,16,17,18,19,20,23,24,25,26,27,7,4,6,9,5,8,11,13,22,21) and g.GLUSR_USR_CUSTTYPE_ID not in (7,13)
   AND TRUNC(h.ETO_CUST_PURCHASE_DATE) BETWEEN '".$start_date."' AND '".$end_date."' 
   AND h.FK_GLUSR_USR_ID NOT IN(
				SELECT FK_GLUSR_USR_ID
				FROM GLUSR_USR_PRIVACY_SETTING
				WHERE FK_MY_PRIVACY_SETTING_ID=48
				)
    ORDER BY ETO_CUST_PURCHASE_DATE DESC";

                    $sth=oci_parse($dbh,$sql);
                    oci_execute($sth);
                    $rec=array();
    
		    while(($row= oci_fetch_assoc($sth)) != false)
		    {
			array_unshift($rec,$row);   
		    }
    
		    $count_nfl=count($rec);
		    
		     $sql_check_proforma="select PROFORMA_GLUSR_USR_ID from proforma WHERE PROFORMA_ISSUEDATE between sysdate-90 and sysdate";
		    $command_proforma=oci_parse($conn_main_db,$sql_check_proforma);
		    oci_execute($command_proforma);

		    $glid_list_exclude=array();
    
		    while(($row_glid = oci_fetch_assoc($command_proforma)) != false)
		    {
		      array_unshift($glid_list_exclude,$row_glid['PROFORMA_GLUSR_USR_ID']);
		    }
    
		    for($i=0;$i<$count_nfl;$i++)
		    {
			if(in_array($rec[$i]["FK_GLUSR_USR_ID"],$glid_list_exclude))
			{
			    unset($rec[$i]);
			}
		    }

                            array_push($rec, $header);

                            foreach ($rec as $i)
                            {
                                    $d3 = array_values($i);
                                    $d3 = preg_replace('/\'/', '', $d3);
                                    array_push($d2, $d3);
                            }


                            if(empty($d2))
                            {
                                    $d2 =array('No records found', 'Please Try Again !!');
                            }

                            Yii::import('application.extensions.phpexcel.JPhpExcel');
                            $xls = new JPhpExcel('UTF-8', false, 'Purchase History');
                            $xls->addArray($d2);
                            $xls->generateXML('purchase_history');
                            
    
    }
   
   
   }


?>