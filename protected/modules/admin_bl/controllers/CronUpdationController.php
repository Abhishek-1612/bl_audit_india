<?php
ini_set('track_errors', 1);
class CronUpdationController extends Controller 
{ 
public function actionIndex() 
{
	$start = (float) array_sum(explode(' ', microtime()));			
	$objRead=fopen('/home/indiamart/public_html/dev-gladmin/cron/export_both_test.csv',"r");
	$emp_id = 1563;
	$empName='Ramu Lath';
	$histip = $_SERVER['REMOTE_ADDR'];
	$reponse ='';
	$url="http://stg-service.intermesh.net/imspec/master";
	$gladminip="63.251.238.84";
	$catType = array(3);
	$status = array(1);
	$screen = "Bulk ISQ Addition Script";
	
	while(!feof($objRead))
	{
		$message = '';
		$QuesMasterId = array();
		$data = fgetcsv($objRead);
		
		$catId = isset($data[0]) ? $data[0] : 0;
		$isPorS = isset($data[1]) ? $data[1] : '';

		if($catId != 0 && $isPorS != '')
		{
			$content = array(
				"VALIDATION_KEY" => "e02a3fab4c6c735015b9b4f4a1eb4e3c",
				"ip" => $gladminip,
				"UPDATED_IP"=>$histip,
				"UPDATESCREEN"=>$screen,
				"HIST_COMMENTS"=>"New Questions Added by $empName($emp_id)",
				"UPDATEDBY"=>$empName,
				"UPDATEDBY_ID"=>$emp_id,
				"action"=>"IM_SPECIFICATION_MASTER",
				"MASTER_DESC"=>array("Why do you need this"),
				"MASTER_FULL_DESC"=>array(),
				"MASTER_TYPE"=>array(2),
				"MASTER_BUYER_SELLER"=>array(1),
				"AFFIX_TYPE"=> array(),
				"DESC_WITH_AFFIX"=>array()
			);
			
			$json_data = json_encode($content);
			
			echo "ist level";
			echo '<pre>';
			print_r($content);

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_POST, count($json_data));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
			$output=curl_exec($ch);
			$curl_errno = curl_errno($ch);
			$curl_error = curl_error($ch);
			curl_close($ch);
			
				echo "ist level";
			echo '<pre>';
			print_r($output);
die;
			if ($curl_errno > 0)
			{
				$msg = "Reason = ".$curl_errno."\nOutput = ".$curl_error."\nJSON DATA =".$json_data;
				mail("gladmin-team@indiamart.com","gladmin :Add ISQ Service Error(IM_SPECIFICATION_MASTER) in Bulk Addition Script",$msg);
			}
			else
			{        
				$output = json_decode($output, true);
				$updateFlag = $output['CODE'];
				if($updateFlag != "200")
				{  
					$op=implode('-',$output);
					$msg = "Reason = ".$curl_errno."\nOutput = ".$curl_error."\nJSON DATA =".$json_data."\n Response = ". $op;
					mail('gladmin-team@indiamart.com',"gladmin :Add ISQ Service Error(IM_SPECIFICATION_MASTER) in Bulk Addition Script",$msg);
				}
				else
				{
				  //Insert into IM_CAT_SPECIFICATION
					$masterId=$output['ID_STRING'];   //Given by above Service
					$masterId=substr_replace($masterId,"", -1);
					$QuesMasterId=explode(',',$masterId);
				}
			}  
		
			if(!empty($QuesMasterId))
			{				
				$content = array(
					"VALIDATION_KEY" => "e02a3fab4c6c735015b9b4f4a1eb4e3c",
					"ip" => $gladminip,
					"UPDATED_IP"=>$histip,
					"UPDATESCREEN"=>$screen,
					"HIST_COMMENTS"=>"New Questions Added by $empName($emp_id)",
					"UPDATEDBY"=>$empName,
					"UPDATEDBY_ID"=>$emp_id,
					"action"=>"IM_CAT_SPECIFICATION",
					"SPEC_MASTER_ID"=>$QuesMasterId,
					"SPEC_CATEGORY_ID"=>array($catId),
					"CATEGORY_TYPE"=>array(3),
					"PRIORITY"=>array("-100"),
					"STATUS"=>array(1),
					"SUP_PRIORITY"=>array("-100")
				);

				$json_data = json_encode($content);
				
						echo "IInd level";
			echo '<pre>';
			print_r($content);

				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POST, count($json_data));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
				$output=curl_exec($ch);
				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);
				curl_close($ch);
				
					echo "IInd level";
			echo '<pre>';
			print_r($output);
				   
				if ($curl_errno > 0)
				{
					$msg = "Reason = ".$curl_errno."\nOutput = ".$curl_error."\nJSON DATA =".$json_data;
					mail("gladmin-team@indiamart.com","gladmin :Add ISQ Service Error(IM_CAT_SPECIFICATION) in Bulk Addition Script",$msg);
				}
				else
				{  
					$output = json_decode($output, true);
					$updateFlag = $output['CODE'];
					if($updateFlag != "200")
					{
						$op=implode('-',$output);
						$msg = "Reason = ".$curl_errno."\nOutput = ".$curl_error."\nJSON DATA =".$json_data."\n Response = ". $op;
						mail('gladmin-team@indiamart.com',"gladmin :Add ISQ Service Error(IM_CAT_SPECIFICATION) in Bulk Addition Script",$msg);
					}
					else{          
						$message="SUCCESS";           
					}     
				}
				
			}
			
			if($message =='SUCCESS')
			{
				$masterId = $QuesMasterId[0];
				if($isPorS == 'P')
				{
					$QuesMasterIdArray = array($masterId,$masterId,$masterId);
					$optionValArray = array("For Reselling","For Business Use","For Personal Use");
					$optionStatusArray = array(1,1,1);
					$optionBSArray = array(0,0,0);
					$optionPriArray = array(1,2,3);
					$QuestypeArray = array(2,2,2);
				}
				else
				{
					$QuesMasterIdArray = array($masterId,$masterId);
					$optionValArray = array("For Business Use","For Personal Use");
					$optionStatusArray = array(1,1);
					$optionBSArray = array(0,0);
					$optionPriArray = array(1,2);
					$QuestypeArray = array(2,2);
				}
				
				$content = array(
					"VALIDATION_KEY" => "e02a3fab4c6c735015b9b4f4a1eb4e3c",
					"ip" => $gladminip,
					"UPDATED_IP"=>$histip,
					"UPDATESCREEN"=>$screen,
					"HIST_COMMENTS"=>"New Questions Added by $empName($emp_id)",
					"UPDATEDBY"=>$empName,
					"UPDATEDBY_ID"=>$emp_id,
					"action"=>"IM_SPECIFICATION_OPTIONS",
					"MASTER_ID"=>$QuesMasterIdArray,
					"OPTIONS_DESC"=>$optionValArray,
					"OPTIONS_STATUS"=>$optionStatusArray,
					"MASTER_TYPE"=>$QuestypeArray,
					"OPT_SUP_PRIORITY"=>$optionPriArray,
					"OPT_BUYER_SELLER"=>$optionBSArray
				);
				
				$json_data = json_encode($content);

					echo "iiird level";
			echo '<pre>';
			print_r($content);
				
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_HEADER, false);
				curl_setopt($ch, CURLOPT_POST, count($json_data));
				curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
				$output=curl_exec($ch);

				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);
				curl_close($ch);
				
					echo "iiird level";
			echo '<pre>';
			print_r($output);
			
				if ($curl_errno > 0){
					$msg = "Reason = ".$curl_errno."\nOutput = ".$curl_error."\nJSON DATA =".$json_data;
					mail("gladmin-team@indiamart.com","gladmin :Add ISQ Service Error(IM_SPECIFICATION_OPTIONS) in Bulk Addition Script",$msg);
				}
				else
				{
					$output = json_decode($output, true);
					$updateFlag = $output['CODE'];
					if($updateFlag != "200")
					{
						$op=implode('-',$output);
						$msg = "Reason = ".$curl_errno."\nOutput = ".$curl_error."\nJSON DATA =".$json_data."\n Response = ". $op;
						mail('gladmin-team@indiamart.com',"gladmin :Add ISQ Service Error(IM_SPECIFICATION_OPTIONS) in Bulk Addition Script",$msg);
					}
					else
					{
						$message="SUCCESS";
					}
				}	
			}
		}
	}
}
}	
?>