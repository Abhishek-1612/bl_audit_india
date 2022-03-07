<?php 
class iilMasterFlagReport extends CFormModel
{
	
	public function getDDL()
	{
                $glEtoModel = new AdminEtoModelForm();
                $dbh = $glEtoModel->connectMeshrDb();	
                $sql = "select A.*,row_number() over(partition by TABLE_TYPE order by TABLE_TYPE)RN,count(1) over(partition by TABLE_TYPE order by TABLE_TYPE)TOTRN from
                (SELECT distinct IIL_MASTER_DATA_TYPE_TABLE,
                DECODE(lower(IIL_MASTER_DATA_TYPE_COLUMN),'procedure',2,'cron',3,'db object',4,1) TABLE_TYPE
                FROM IIL_MASTER_DATA_TYPE ORDER BY TABLE_TYPE)A";
                $sthfetch = oci_parse($dbh,$sql);
                oci_execute($sthfetch);     
              
                return $sthfetch;		
	}
	public function getdata($tablename)
	{
		$glEtoModel = new AdminEtoModelForm();
                $dbh = $glEtoModel->connectMeshrDb();	
                
			$sql = "
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
                                 AND IIL_MASTER_DATA_TYPE_TABLE = :TABLENAME
                                 ORDER BY IIL_MASTER_DATA_TYPE_COLUMN,IIL_MASTER_DATA_VALUE,IIL_MASTER_DATA_VALUE ASC 
                              ";
			$sthfetch = oci_parse($dbh,$sql);
                        oci_bind_by_name($sthfetch, ':TABLENAME', $tablename);
                        oci_execute($sthfetch);                       
			return $sthfetch;
		
	}
}	
?>
