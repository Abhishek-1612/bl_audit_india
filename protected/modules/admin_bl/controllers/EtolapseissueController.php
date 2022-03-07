 <?php 
    class EtolapseissueController extends Controller
    {
       
  public function actionlapseissuecredits()
       {   
         $schm='';
         if(isset($_REQUEST['price']))
          $credits = $_REQUEST['price'];
           else
          $credits = 0;
          if(isset($_REQUEST['glusrid']))
         $glusrid = $_REQUEST['glusrid'];
           else
           $glusrid = 0;
          if(isset($_REQUEST['lap_issue']))
           $lapse_issue = $_REQUEST['lap_issue'];
           else
          $lapse_issue = 1;
           $reason = $_REQUEST['reason'];
           if(isset($_REQUEST['pay_site']))
           $pay_site = $_REQUEST['pay_site'];
          else
           $pay_site = 'ETO';
           $status = 0;
           $emp_id = Yii::app()->session['empid'];          
         
           if($lapse_issue == 1)
           {  
                    $Globalinit = new GlobalmodelForm;
                    $return_geoip=$Globalinit->Geo_IP();
                    $remote_host=$return_geoip['remote'];
                    $country_name=$return_geoip['country'];
      
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
              {
                $url="https://stg-mapi.indiamart.com/wservce/buyleads/creditdeduction/";  
              }else
              {
                 $url="https://leads.imutils.com/wservce/buyleads/creditdeduction/"; 
              }
              $lscheme = $_REQUEST['lscheme'];

              if($_REQUEST['ctype']=='F'){
                    $reason = "Export BuyLead balance lapse via Admin - $reason";  
                    $content = array(
                  "glusrid" => $glusrid,
                  'modid'=>'GLADMIN',
                  "token" => "Z2xhZG1pbi5pbmRpYW1hcnQuY29tIyM1NDI1Nw",
                  "history_comments"=>"$reason",
                  "client_ip"=>"$remote_host",
                  "country_name"=>"$country_name",             
                  "credit"=>$credits,
                  "empid"=>$emp_id,
                  "offer_id"=>-1,
                  "schm"=>"$lscheme");
                 }else{
                    $reason = "$reason"; 
                    $content = array(
                  "glusrid" => $glusrid,
                  'modid'=>'GLADMIN',
                  "token" => "Z2xhZG1pbi5pbmRpYW1hcnQuY29tIyM1NDI1Nw",
                  "history_comments"=>"$reason",
                  "client_ip"=>"$remote_host",
                  "country_name"=>"$country_name",             
                  "credit"=>$credits,
                  "empid"=>$emp_id,
                  "offer_id"=>-1,
                  "schm"=>"$lscheme");            
                 }
           
                   $data_string = http_build_query($content);
                    
                    $ServiceGlobalModelForm = new ServiceGlobalModelForm();
		    $response = $ServiceGlobalModelForm->mapiService('CREDITDEDUCTION',$url,$data_string,'No');                     
                         $response1=isset($response['RESPONSE'])?$response['RESPONSE']:''; 
                            if(isset($response1['status']) && $response1['status']=== "success")
                            { 
                                $status="Successfully Lapsed $credits Credits";
                            }
                            else
                            { 
                                if(isset(Yii::app()->session['empid']) && (Yii::app()->session['empid']==3575)){
                                     echo $data_string.'<pre>';print_r($response);
                                 }
                                 $message=isset($response1['message']) ? $response1['message'] :'';
                                $status="Error occured on Lapsed $credits Credits $message";                                                                
                             }
                       
          }
          elseif($lapse_issue == 2)
         {
                 $discnt = $credits*25;
                 if($_REQUEST['ctype']=='F'){
                    $schm=141;
                    $reason = preg_replace("/offer Id/","",$reason);

                    $hist_cmnt = "Export BuyLead balance allocated via Admin - $reason";                         
                 }else{
                    $schm=6;
                    $hist_cmnt = "$reason";                         
                 }

                 $notify='Yes';
 
                if(isset($_REQUEST['order_id']))
                  $ETO_CUST_ORDER_ID = $_REQUEST['order_id'];
                  else
                 $ETO_CUST_ORDER_ID=-1;
                $updated_using = "New Credit Allocation Screen";
        
                          $Globalinit = new GlobalmodelForm;
                          $return_geoip=$Globalinit->Geo_IP();
                          $remote_host=$return_geoip['remote'];
                          $country_name=$return_geoip['country'];
                            
                          $http_status= $this->Credit_allocated_offline($glusrid,$remote_host,$country_name,$credits,$emp_id,$hist_cmnt,$pay_site,$discnt,$schm,$notify,$ETO_CUST_ORDER_ID);
                          if($http_status == 200)
                            {
                                  $status="Successfully Issued $credits Credits";  
                            } 
                            else
                           {
                             $status="Service error:$http_status";
                           }
                 }
         echo $status;
         return $status;  
 }
 
  function Credit_allocated_offline($glusrID,$remote_host,$country_name,$credits,$emp_id,$hist_cmnt,$pay_site,$discnt,$schm,$notify,$ETO_CUST_ORDER_ID)
    {               
      $http_status1=0;         
      $url = (($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') ) ? 
              "http://stg-mapi.indiamart.com/wservce/buyleads/creditallocation/" : "https://leads.imutils.com/wservce/buyleads/creditallocation/";
               $content = array(
               "token" => "Z2xhZG1pbi5pbmRpYW1hcnQuY29tIyM1NDI1Nw",
               "flow_status" => "OFFLINE_USER_PAYMENT_SUCCESS",
               "modid"=>"$pay_site",
               "crd_issu_msg"=>"$hist_cmnt",
               "glusrid"=>"$glusrID",
               "client_ip"=>"$remote_host",
               "country_name"=>"$country_name",
               "credits"=>"$credits",
               "cust_type"=>"Cr. Alloc Screen",
               "empid"=>"$emp_id",
               "discount"=>"$discnt",
               "schm"=>"$schm",
               "notify"=>"$notify",
               "order_id"=>"$ETO_CUST_ORDER_ID"               
       );
                         
                    $data_string = http_build_query($content);      
                    $ServiceGlobalModelForm = new ServiceGlobalModelForm();
		    $response = $ServiceGlobalModelForm->mapiService('CREDITALLOCATION',$url,$data_string,'No');  
                if(isset(Yii::app()->session['empid']) && (Yii::app()->session['empid']==3575)){
                    echo '<pre>';
                    print_r($content);
                    print_r($response);
                }

                    $status=isset($response['status_code'])?$response['status_code']:'';
                    return $status; 
    }
    
 }
  ?>
