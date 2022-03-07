<?php
class OfferdeleteController extends Controller
{

   public function actionIndex()
   {

	   $offerID = isset($_GET['offerid'])?$_GET['offerid']:'';
	  $service_url = ($_SERVER['SERVER_NAME'] == 'seller.indiamart.com') ? 'http://mapi.indiamart.com/wservce/buyleads/detail/':'http://dev-mapi.indiamart.com/wservce/buyleads/detail/';
			
			
			$start=1;
			$end=1;
			$content=array();
                        
			$content = array(
			
			'offerid' => $offerID,
			'modid' => 'MY',
			'type' => 'Q',
			'token' => 'imobile@15061981',
			'buyer_response' => 1
			
			);
//print_r($content);
			$data_string = http_build_query($content);
			$curl = curl_init($service_url);                                                                     
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			$json_response = curl_exec($curl);
			$status_service = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$status='';
			$res=array();      
			$qresult = array();
			if($status_service == 200)
			{
			$wsresult = json_decode($json_response, true);

			  if(isset($wsresult['RESPONSE']))
			{
			$qresult=$wsresult['RESPONSE'];
				      
			}}
  
	    $res= isset($qresult['DATA'])?$qresult['DATA']:'';
	   
	    if($offerID != '' && $res['FK_ETO_OFR_TYPE_ID'] == 1){
		 $query = "BEGIN PROC_ETO_DELETE(:OFRID); END;";  
		  $stid = oci_parse($dbh, $query);
		  oci_bind_by_name($stid, ":OFRID", $offerID);
		  oci_execute($stid);

	    }
     
    }

  
}


   
   
   
   
   ?>