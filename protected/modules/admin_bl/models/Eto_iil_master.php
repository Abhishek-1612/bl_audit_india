<?php

class Eto_iil_master extends CFormModel
{


public function get_data($dbh,$submit,$tabname1)
{




$sql = "select A.*,row_number() over(partition by TABLE_TYPE order by TABLE_TYPE)RN,count(1) over(partition by TABLE_TYPE order by TABLE_TYPE)TOTRN from
			(SELECT distinct IIL_MASTER_DATA_TYPE_TABLE, 
			DECODE(lower(IIL_MASTER_DATA_TYPE_COLUMN),'procedure',2,'cron',3,'db object',4,1) TABLE_TYPE
			FROM IIL_MASTER_DATA_TYPE ORDER BY TABLE_TYPE)A";
	            
	            
	            $stid = oci_parse($dbh,$sql);
		    oci_execute($stid);
		    oci_fetch_all($stid,$rec);
		   
		  //  oci_fetch_all($stid,$rec);
		  
               if($tabname1=='ETO_OFR')
               {
		$tabname='eto_ofr';
		
		}
		else
		{
		  $tabname=$tabname1;
		}
             
             $sql1 = "SELECT 
                           T.*,
                           (
                           SELECT IIL_MASTER_DATA_TYPE_TAB_DESC FROM (SELECT DISTINCT IIL_MASTER_DATA_TYPE_TABLE,IIL_MASTER_DATA_TYPE_TAB_DESC 
                           FROM IIL_MASTER_DATA_TYPE WHERE IIL_MASTER_DATA_TYPE_TAB_DESC IS NOT NULL)  
                           WHERE IIL_MASTER_DATA_TYPE_TABLE = T.IIL_MASTER_DATA_TYPE_TABLE
                           )IIL_MASTER_DATA_TYPE_TAB_DESC,
                           (
                           SELECT IIL_MASTER_DATA_TYPE_TAB_USAGE FROM (SELECT DISTINCT IIL_MASTER_DATA_TYPE_TABLE,IIL_MASTER_DATA_TYPE_TAB_USAGE 
                           FROM IIL_MASTER_DATA_TYPE WHERE IIL_MASTER_DATA_TYPE_TAB_USAGE IS NOT NULL)  
                           WHERE IIL_MASTER_DATA_TYPE_TABLE = T.IIL_MASTER_DATA_TYPE_TABLE
                           )IIL_MASTER_DATA_TYPE_TAB_USAGE
                         FROM
                              (
                              SELECT 
                                 IIL_MASTER_DATA_TYPE_TABLE,
                                 IIL_MASTER_DATA_TYPE_COLUMN,
                                 IIL_MASTER_DATA_TYPE_COMMENTS,
                                 IIL_MASTER_DATA_VALUE,
                                 IIL_MASTER_DATA_VALUE_TEXT
                              FROM
                                 IIL_MASTER_DATA_TYPE,
                                 IIL_MASTER_DATA
                              WHERE 
                                 IIL_MASTER_DATA_TYPE_ID = FK_IIL_MASTER_DATA_TYPE_ID
                                 AND IIL_MASTER_DATA_TYPE_TABLE =:TABLENAME
                                 ORDER BY IIL_MASTER_DATA_TYPE_COLUMN,IIL_MASTER_DATA_VALUE
                              )T";
                              
		$stid1 = oci_parse($dbh,$sql1);
		oci_bind_by_name($stid1,':TABLENAME',$tabname);
		oci_execute($stid1);
		oci_fetch_all($stid1,$row);
		
		//return $row;






return array($rec,$row);


}

}
   
   
?>