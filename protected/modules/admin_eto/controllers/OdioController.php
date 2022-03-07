<?php 
//error_reporting(1);
class OdioController extends Controller
{
        
    public function actionGetresponse(){
        echo '<br><br>';
                echo $webAPI = "http://indiamart.odioiq.com/fetch_response";	
                        echo '<br><br>';

		$headr = array();
                  $offerid = $_GET['offer_id'];   

                $headr[] = 'UNIQUE_ID: '.$offerid;
                $headr[] = 'Content-type: application/json';
                $headr[] = 'Authorization: token74962315bnvtebf@g$hp&huzj!058';

		$ch = curl_init( $webAPI );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr);
              curl_setopt($ch, CURLOPT_POST,true);
                //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                //curl_setopt($ch, CURLOPT_TIMEOUT, 2);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec($ch);
		$curl_errno = curl_errno($ch);
	        
		curl_close($ch);	
		echo "<pre>$result</pre>";
                $time_end = microtime(true);
		
		if ($curl_errno > 0) {
			
			echo "<br> error =>  $curl_error";
		} 
		else {
			echo "<br> output => $output";
		}
		
		
	
	echo "<br />================<br />";
		
		
    }

                public function sendToOdio($resArr){
                        
                      $batchArr = array();
                      $batchArr[] = $resArr;
                      $date = date('dmY');                  
                         $serv_model=new ServiceGlobalModelForm();
                         $offerId=$resArr['offer_id'];
                                $vendorName = isset($resArr['vendor_name']) && !empty($resArr['vendor_name']) ? $resArr['vendor_name'] : "";
                                $recordingArr = $this->getAllCallRecordings($offerId,$vendorName); 
                                $batchArr = array();
                                for ($i=0; $i < count($recordingArr); $i++) 
                               { 
                                       $rand = mt_rand(0,100000);
                                       $resArr["tracking_id"] = $date."".$rand;
                                       $resArr['recording_url_in'] =$recordingArr[$i]["recording_url_in"];
                                       $resArr['recording_url_out'] = $recordingArr[$i]["recording_url_out"];
                                       $dateTime = $recordingArr[$i]["recording_date"];
                                       $tempDate=substr($dateTime,0,10);
                                       $tempTime=substr($dateTime,11);
                                       $resArr['date'] = $tempDate;
                                       $resArr['time'] = $tempTime;
                                       $batchArr[] = $resArr;
                               }
                               if(!count($recordingArr))
                               {
                                    $batchArr =$resArr;
                                }  
                              //  print_r($batchArr);
                                 $webAPI = "http://indiamart.odioiq.com:5002/indiamart";
                                 $serv_model->mapiService('Odioq_send',$webAPI, $batchArr,'Yes');
                                echo "Data Successfully sent to Odio";
                    
                }
               


                public function actionSendodio(){
                    
                        if($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET"){
                                 $offer_ids = $_GET['offer_id'];   
                                $resArr = array();

                            $obj = new Globalconnection();
                            $model = new GlobalmodelForm();

                            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                            {
                                $dbh = $obj->connect_db_yii('postgress_web68v');   
                            }else{
                                $dbh = $obj->connect_db_yii('postgress_web68v'); 
                            }
                                $sql = "          
                                SELECT 
                                E.ETO_OFR_DISPLAY_ID OFR_ID,
                                E.ETO_OFR_CALL_RECORDING_URL AS REC_URL,
                                E.ETO_OFR_TITLE AS OFR_TITLE,
                                E.ETO_OFR_DESC AS OFR_DESC,
                                E.FK_EMPLOYEE_ID AS EMP_ID,
                                E.FK_GLCAT_MCAT_ID AS MCAT_ID,
                                E.ETO_OFR_S_SENDERNAME AS BUYER_NAME,
                                E.FK_GL_MODULE_ID AS BOUND_TYPE,
                                M.ETO_LEAP_EMP_NAME AS AGENT_NAME,
                                M.ETO_LEAP_VENDOR_NAME AS VENDOR_NAME
                                FROM
                                ETO_OFR E,
                                ETO_LEAP_MIS M
                                WHERE
                                M.ETO_LEAP_VENDOR_NAME IN ('COMPETENT','VKALPINTENT','CONNECT_C2C','OAP_PD')
                                AND E.ETO_OFR_CALL_RECORDING_URL IS NOT NULL
                                and E.FK_EMPLOYEE_ID = M.ETO_LEAP_EMP_ID
                                and ETO_OFR_DISPLAY_ID=$offer_ids  
                                UNION
                                ALL
                                SELECT
                                E.ETO_OFR_DISPLAY_ID OFR_ID,
                                E.ETO_OFR_CALL_RECORDING_URL AS REC_URL,
                                E.ETO_OFR_TITLE AS OFR_TITLE,
                                E.ETO_OFR_DESC AS OFR_DESC,
                                E.FK_EMPLOYEE_ID AS EMP_ID,
                                E.FK_GLCAT_MCAT_ID AS MCAT_ID,
                                E.ETO_OFR_S_SENDERNAME AS BUYER_NAME,
                                E.FK_GL_MODULE_ID AS BOUND_TYPE,
                                M.ETO_LEAP_EMP_NAME AS AGENT_NAME,
                                M.ETO_LEAP_VENDOR_NAME AS VENDOR_NAME
                                FROM
                                ETO_OFR_EXPIRED E,
                                ETO_LEAP_MIS M
                                WHERE
                                M.ETO_LEAP_VENDOR_NAME IN ('COMPETENT','VKALPINTENT','CONNECT_C2C','OAP_PD')
                                AND E.ETO_OFR_CALL_RECORDING_URL IS NOT NULL
                                and E.FK_EMPLOYEE_ID = M.ETO_LEAP_EMP_ID
                                and ETO_OFR_DISPLAY_ID =$offer_ids";
                                $resArr=$rec=array();
                                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());//echo $sql;        
                                 while($rec = $sth->read()) {//print_r($rec);
                                        $rec_url = $rec["rec_url"];
                                        $recordingUrlArray = $this->validateCallRecordingURL($rec_url,$rec['vendor_name']);                                                
                                        $resArr['offer_id'] = $rec['ofr_id'];
                                        $resArr['title'] = $rec['ofr_title'];
                                        $resArr['recording_url_in'] =$recordingUrlArray["recording_in"];
                                        $resArr['recording_url_out'] = $recordingUrlArray["recording_out"];
                                        $resArr["mcat_id"] = $rec['mcat_id'];
                                        $resArr["description"] = $rec['ofr_desc'];
                                        $resArr["agent_id"] = $rec['emp_id'];
                                        $resArr["buyer_name"] = $rec['buyer_name'];
                                        $resArr["agent_name"] = $rec['agent_name'];
                                        $resArr["vendor_name"] = $rec['vendor_name'];
                                        $resArr["inbound"] = 0;
                                        if($rec['bound_type'] == 'flpns'){
                                                $resArr["inbound"] = 1;
                                        }
                                        $resArr["call_type"] = 'Dual';
                                        $date = date('dmY');  
                                        $rand = mt_rand(0,100000);
                                       $resArr["tracking_id"] = $date."".$rand;
                                        if(isset($rec['vendor_name']) && ($rec['vendor_name']=='CONNECT_C2C')){
                                                $resArr["call_type"] = 'Stereo';
                                        }
                                    } 
                                if(!$resArr){
                                        echo "Fetch Query Failed";
                                }else{ //print_r($resArr);
                                    $this->sendToOdio($resArr);
                                }
                        }else{
                                echo "Invalid Request Method";
                        }
                }
                public function getAllCallRecordings($offerId,$vendorName)
                {
                        $retArr=array();
                        $obj = new Globalconnection();
                        $model = new GlobalmodelForm();
                        //function to get all call recordings of a offer
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                            $dbh = $obj->connect_db_yii('postgress_web68v');   
                        }else{
                            $dbh = $obj->connect_db_yii('postgress_web68v'); 
                        }
                       $query = "          
                        SELECT LEAP_CALL_RECORDING_URL,TO_CHAR(RECORDING_DATE,'DD-MM-YYYY HH24:MI:SS') RECORDING_DATE FROM LEAP_CALL_RECORDING 
                        WHERE FK_ETO_OFR_DISPLAY_ID = $offerId ORDER BY RECORDING_DATE";                        
                        $result =  $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $query, array());
                        if(!$result)
                        {
                                echo "Leap_call_recording Fetch Query Failed";
                        }
                        else
                        {
                                while($rec = $result->read())
                                {
                                    $rec = array_change_key_case($rec,CASE_UPPER);
                                    if(!empty($rec))
                                    {
                                            $rec_url = $rec["LEAP_CALL_RECORDING_URL"];
                                            $recordingUrlArray = $this->validateCallRecordingURL($rec_url,$vendorName);
                                            $tempArr=array();
                                            $tempArr['recording_url_in'] =$recordingUrlArray["recording_in"];
                                            $tempArr['recording_url_out'] = $recordingUrlArray["recording_out"];
                                            $tempArr['recording_date']=$rec["RECORDING_DATE"];
                                            array_push($retArr, $tempArr);
                                    }
                                }
                                
                        }
                        return $retArr;            
                }

                public function generateSignedURLAWS($fileUrl,$bucketName="leapcallrecords",$expiry="+24 hour")
                {
                 //Final Url to Return
                $signedUrl="";
              
               if($fileUrl == "" || strpos(strtolower($fileUrl),$bucketName)===FALSE)
               {
               return $fileUrl;
                }
              
               if(strpos(strtolower($fileUrl),$bucketName)!==FALSE)
                {
                  $fileUrl = substr($fileUrl,strpos(strtolower($fileUrl),$bucketName)+strlen($bucketName)+1);
                }
              
                      //The AWS inbuilt class configuration
                          $client = new Aws\S3\S3Client([
                             'version'     => 'latest',
                             'region'      => 'ap-south-1',
                             'credentials' => [
                          'key'      => 'AKIAWRA3N7CHVOMW3XGY',
                             'secret'   => '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',
                          ]
                      ]);
              
                     //The AWS inbuilt class command method configuration 
                         $cmd = $client->getCommand('GetObject', [
                        'Bucket' => 'leapcallrecords',
                         'Key'    => $fileUrl
                      ]);
              
                  //The AWS inbuilt PresignedRequest method invocation 
                  $signedUrlObj = $client->createPresignedRequest($cmd, $expiry);
              
                 //Fetching of signed url
                 $signedUrl = $signedUrlObj->getUri();
                return $signedUrl;
                  }       
                  
                public function validateCallRecordingURL($call_url,$vendorName,$bucketName="leapcallrecords"){
                        $recording_url_in=$call_url;
                        $recording_url_out=$call_url;
                       $recording_url = $call_url;
                     if($call_url == "" || strpos(strtolower($call_url),$bucketName)===FALSE)
                     {
                                if ($vendorName == 'COMPETENT' && !empty($call_url)) {
                                        $recording_url = $call_url;
                                        $recording_url = preg_replace('/monitor\/([0-9]*)\//', 'monitor/CHANNELWISE/$1/', $recording_url);
                                        $recording_url_in = str_ireplace(".WAV",".WAV-in.WAV",$recording_url);
                                        $recording_url_out = str_ireplace(".WAV",".WAV-out.WAV",$recording_url);
                                        //return array("recording_in"=>$recording_url_in,"recording_out"=>$recording_url_out);
                                }
                                elseif ($vendorName == 'VKALPINTENT' && !empty($call_url)) {
                                        $recording_url = $call_url;
                                        $recording_url = preg_replace('/monitor\/([0-9]*)\//', 'monitor/channelwise/$1/', $recording_url);
                                        $recording_url_in = str_replace(".WAV",".WAV-in.WAV",$recording_url);
                                        $recording_url_out = str_replace(".WAV",".WAV-out.WAV",$recording_url);
                                        //return array("recording_in"=>$recording_url_in,"recording_out"=>$recording_url_out);
                                }
                                elseif ($vendorName == 'OAP_PD' && !empty($call_url)) {
                                        $recording_url = $call_url;
                                        $recording_url = preg_replace('/monitor\/([0-9]*)\//', 'monitor/channelwise/$1/', $recording_url);
                                        $recording_url_in = str_ireplace(".WAV",".WAV-in.WAV",$recording_url);
                                        $recording_url_out = str_ireplace(".WAV",".WAV-out.WAV",$recording_url);
                                        //return array("recording_in"=>$recording_url_in,"recording_out"=>$recording_url_out);
                                }
                        } 
                                else{
                                        if($vendorName == 'VKALPINTENT' && !empty($call_url))
                             {
                                $recording_url_in=str_replace(".wav","-wav-in.wav",$recording_url);
                                 $recording_url_out=str_replace(".wav","-wav-out.wav",$recording_url);
                                          }
                        else if($vendorName == 'COMPETENT' && !empty($call_url))
                            {
                                                $recording_url_in = str_ireplace(".WAV",".WAV-in.WAV",$recording_url);
                                                $recording_url_out = str_ireplace(".WAV",".WAV-out.WAV",$recording_url);
                             }
                           else if($vendorName == 'OAP_PD' && !empty($call_url))
                           {
                                   $recording_url_in=str_replace(".wav","-wav-in.wav",$recording_url);
                               $recording_url_out=str_replace(".wav","-wav-out.wav",$recording_url);
                                 }
                   }
                
                   $recording_url_in=$this->generateSignedURLAWS($recording_url_in);
                   $recording_url_out=$this->generateSignedURLAWS($recording_url_out);
                   
                     return array("recording_in"=>"$recording_url_in","recording_out"=>"$recording_url_out");
                        }
}