<?php
class GlobalEtoNew extends CFormModel
{
	public function removeUnwantedInfo($str)
	{
		$str = preg_replace("/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)/",' ',$str);//anchor tag remove
		$str = preg_replace("/(<\s*img\b.*?\s*>)/",' ',$str);
		$str = preg_replace('/\n/','<br>\n ',$str);
		$str = preg_replace('/\t/','&nbsp;&nbsp;&nbsp;&nbsp;',$str);
		return $str;

	}
	public function MyportalEnqalert($userID)
	{
		
		$global_model = new BLGlobalmodelForm;
		$dbh	      = $global_model->connect_db();
		if($userID!='')
		{
		$userDet=$global_model->getUserDetails(__FILE__, __LINE__,$dbh,$userID,0);
		$usr_approv_status = !empty($userDet['approv'])? $userDet['approv'] : 'D';
		$pblmy=new PblMy;
		$pblmy->totofferdisplay(__FILE__,$_REQUEST,$dbh,$userDet,$userID);
		}
		else
		{
			echo "Incorrect Glusr ID entered.";
		}
	}
	public function checkEmpStatus($emp_id)
	{
		$isvalid=0;
		$global_model = new BLGlobalmodelForm;
		$dbh	      = $global_model->connect_db();
		$sql="SELECT * FROM GL_EMP WHERE GL_EMP_ID=:emp_id AND GL_EMP_WORKING=-1";
		$sth = $dbh->createCommand($sql);
		$sth->bindValue(":emp_id",$emp_id);
		$dataReader=$sth->query();
		$id_exist=$dataReader->readAll();
		if(!empty($id_exist)){$isvalid=1;}
		return $isvalid;
	}
	// 	public function getdomainname($q,$forwarded_host)
// 	{
// 		
// 		$arr_url = array();
// 		$path = '';
// 		$modid='';
// 	
// 		$ENV['MY_COUNTRY'] = !empty($ENV['MY_COUNTRY']) ? $ENV['MY_COUNTRY'] : "";
// 
// 		if($ENV['MY_COUNTRY'] == 'INDIA')
// 		{
// 			
// 			$arr_url=parse_url($forwarded_host);
// 			if($arr_url[0])
// 			{
// 				$path= "http://".$arr_url[0];
// 			}
// 			else
// 			{
// 				$path= "http://".$ENV['HTTP_HOST'];
// 			}
// 			$path =~ s/\:\d+//;
// 			$q->param('modid','MY');
// 			$modid=$q->param('modid');
// 			return($q,$path,$modid);
// 		}
// 		elsif($ENV{'MY_COUNTRY'} eq 'US')
// 		{
// 			@arr_url=split(/\,/,$forwarded_host);
// 	
// 			if($arr_url[0])
// 			{
// 				$path= qq~http://$arr_url[0]~;
// 			}
// 			else
// 			{
// 				$path= "http://$ENV{'HTTP_HOST'}";
// 			}
// 			$path =~ s/\:\d+//;
// 			if($arr_url[0] !~ /\.indiamart\.com/ig)
// 			{
// 				$q->param('modid','NDTV');
// 				$modid=$q->param('modid');
// 			}
// 			else
// 			{
// 				if($q->param('modid'))
// 				{
// 					$modid=$q->param('modid');
// 				}
// 				else
// 				{
// 					$q->param('modid','MY');
// 					$modid=$q->param('modid');
// 				}
// 			}
// 			return($q,$path,$modid);
// 		}
// 	}

}
?>