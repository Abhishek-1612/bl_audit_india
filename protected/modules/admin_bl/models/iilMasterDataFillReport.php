<?php
class iilMasterDataFillReport extends CFormModel
{
	public $connection;
	public function __construct($postdata = array())
	{
		$this->connection=Yii::app()->dbora9mesh;
	}
	public function getDDL()
	{
		try
		{
			$sql = "SELECT IIL_MASTER_DATA_TYPE_ID,IIL_MASTER_DATA_TYPE_TABLE,IIL_MASTER_DATA_TYPE_COLUMN FROM IIL_MASTER_DATA_TYPE ORDER BY IIL_MASTER_DATA_TYPE_TABLE";
			$sth=$this->connection->createCommand($sql);
			$dataReader=$sth->query();
			$dataDDL=$dataReader->readAll();
			return $dataDDL;
		}
		catch(Exception $e)
		{
			$to      = 'akshay.garg@indiamart.com';
			$subject = 'Error in  Query Execution';
			$message = "Query Used -: $sql \r\n\r\nError Detail -:\r\n . $e ";
			$headers = 'From: akshay.garg@indiamart.com' . "\r\n";
			$headers .= "Cc: rohitarora@indiamart.com" . "\r\n";
			mail($to, $subject, $message, $headers);
			return 0;
		}

	}
	public function getEmpName($emp)
	{
		try
		{
			$sql="select (GL_EMP_NAME||'['||GL_EMP_ID||']') EMP from gl_emp where GL_EMP_ID =:EMPID";
			$sth = $this->connection->createCommand($sql);
			$sth->bindParam(':EMPID', $emp);
			$dataReader=$sth->query();
			$empName=$dataReader->readAll();
			return ($empName[0]{'EMP'});
		}
		catch(Exception $e)
		{
			$to      = 'akshay.garg@indiamart.com';
			$subject = 'Error in  Query Execution';
			$message = "Query Used -: $sql \r\n\r\nError Detail -:\r\n . $e ";
			$headers = 'From: akshay.garg@indiamart.com' . "\r\n";
			$headers .= "Cc: rohitarora@indiamart.com" . "\r\n";
			mail($to, $subject, $message, $headers);
			return 0;
		}
	}
	public function insertTableData($emp_name)
	{
		try
		{
			$sql="INSERT INTO IIL_MASTER_DATA_TYPE(
			IIL_MASTER_DATA_TYPE_TABLE,
			IIL_MASTER_DATA_TYPE_COLUMN,
			IIL_MASTER_DATA_TYPE_COMMENTS,
			IIL_MASTER_DATA_TYPE_ADDEDON,
			IIL_MASTER_DATA_TYPE_ADDEDBY,
			IIL_MASTER_DATA_TYPE_TAB_DESC,
			IIL_MASTER_DATA_TYPE_TAB_USAGE,
			IIL_MASTER_DATA_TYPE_TYPE
			) values(
			:IIL_MASTER_DATA_TYPE_TABLE,
			:IIL_MASTER_DATA_TYPE_COLUMN,
			:IIL_MASTER_DATA_TYPE_COMMENTS,
			SYSDATE,
			:IIL_MASTER_DATA_TYPE_ADDEDBY,
			:IIL_MASTER_DATA_TYPE_TAB_DESC,
			:IIL_MASTER_DATA_TYPE_TAB_USAGE,
			:IIL_MASTER_DATA_TYPE_TYPE
			)";

			$sth = $this->connection->createCommand($sql);
			$sth->bindParam(':IIL_MASTER_DATA_TYPE_TABLE',$_REQUEST['iilMasterDataTypeTableName']);
			$sth->bindParam(':IIL_MASTER_DATA_TYPE_COLUMN',$_REQUEST['iilMasterDataTypeColumnName']);
			$sth->bindParam(':IIL_MASTER_DATA_TYPE_COMMENTS',$_REQUEST['iilMasterDataTypeComment']);
			$sth->bindParam(':IIL_MASTER_DATA_TYPE_ADDEDBY',$emp_name);
			$sth->bindParam(':IIL_MASTER_DATA_TYPE_TAB_DESC',$_REQUEST['iilMasterDataTypeDesc']);
			$sth->bindParam(':IIL_MASTER_DATA_TYPE_TAB_USAGE',$_REQUEST['iilMasterDataTypeUsage']);
			$sth->bindParam(':IIL_MASTER_DATA_TYPE_TYPE',$_REQUEST['iilMasterDataTypeSelect']);
			$dataReader=$sth->query();
		}
		catch(Exception $e)
		{
			$to      = 'akshay.garg@indiamart.com';
			$subject = 'Error in  Query Execution';
			$message = "Query Used -: $sql \r\n\r\nError Detail -:\r\n . $e ";
			$headers = 'From: akshay.garg@indiamart.com' . "\r\n";
			$headers .= "Cc: rohitarora@indiamart.com" . "\r\n";
			mail($to, $subject, $message, $headers);
		}
	}
	public function insertFlagsData($emp_name)
	{
		try
		{
			
			$sql="INSERT INTO IIL_MASTER_DATA(
			FK_IIL_MASTER_DATA_TYPE_ID,
			IIL_MASTER_DATA_VALUE,
			IIL_MASTER_DATA_VALUE_TEXT,
			IIL_MASTER_DATA_ADDEDON,
			IIL_MASTER_DATA_ADDEDBY,
			IIL_MASTER_DATA_IS_ACTIVE,
			IIL_MASTER_DATA_VALUE_LRG_TEXT
			) values(
			:FK_IIL_MASTER_DATA_TYPE_ID,
			:IIL_MASTER_DATA_VALUE,
			:IIL_MASTER_DATA_VALUE_TEXT,
			SYSDATE,
			:IIL_MASTER_DATA_ADDEDBY,
			-1,
			:IIL_MASTER_DATA_VALUE_LRG_TEXT
			)";

			$sth = $this->connection->createCommand($sql);
			$sth->bindParam(':FK_IIL_MASTER_DATA_TYPE_ID',$_REQUEST['iilMasterFlagDataFK']);
			$sth->bindParam(':IIL_MASTER_DATA_VALUE',$_REQUEST['iilMasterDataValue']);
			$sth->bindParam(':IIL_MASTER_DATA_VALUE_TEXT',$_REQUEST['iilMasterDataValuetext']);
			$sth->bindParam(':IIL_MASTER_DATA_ADDEDBY',$emp_name);
			$sth->bindParam(':IIL_MASTER_DATA_VALUE_LRG_TEXT',$_REQUEST['iilMasterDataDesc']);
			$dataReader=$sth->query();
		}
		catch(Exception $e)
		{
			$to      = 'akshay.garg@indiamart.com';
			$subject = 'Error in  Query Execution';
			$message = "Query Used -: $sql \r\n\r\nError Detail -:\r\n . $e ";
			$headers = 'From: akshay.garg@indiamart.com' . "\r\n";
			$headers .= "Cc: rohitarora@indiamart.com" . "\r\n";
			mail($to, $subject, $message, $headers);
		}
	}
}
?>