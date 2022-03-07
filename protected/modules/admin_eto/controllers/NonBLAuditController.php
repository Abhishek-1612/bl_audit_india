<?php 
class NonBLAuditController extends Controller
{
	public function actionIndex() 
	{ 
		$emp_id = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $auditors_name='';
                if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
		  $offerArr=array();$auditArr=array(); 
		  $obj =new NonBLAuditModel();
                  $objauditmodel=new AuditModel();
                  $etoModel =  new AdminEtoForm();
		  $callrecordid=isset($_REQUEST['callrecordid']) ? $_REQUEST['callrecordid'] : ''; 
		   if(isset($_REQUEST['search']) || isset($_REQUEST['reaudit']))
                   {  
                    $arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id); 
                    $v_name=isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])?$arr_lvl_code['ETO_LEAP_VENDOR_NAME']:'';
                    if( $v_name == ''){
                        echo "Employee  $emp_id does not exist."; exit;
                    }
  
                    $offerArr=$obj->callDetail($callrecordid); 
                    $auditArr=$objauditmodel->show_audit_question('NONBL'); //echo '<pre>';print_r($auditArr);
                    $this->render('/nonblaudit/auditform',array('offerArr'=>$offerArr,'auditArr'=>$auditArr,'callrecordid'=>$callrecordid,'v_name'=>$v_name));
                   }else if(isset($_REQUEST['save']))
                   {      
                      $selcallrecordid=isset($_REQUEST['selcallrecordid']) ? $_REQUEST['selcallrecordid'] : ''; 
                      $offerArr=$obj->callDetail($selcallrecordid);
                      $auditArr=$objauditmodel->show_audit_question('NONBL');
                      $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=$_REQUEST['v_name'];
                      $offerArr['ASSOC_NAME']=$_REQUEST['assoc_name'];
		      $errormessage=$offerArr=$objauditmodel->save_audit_details(0,$auditArr,$selcallrecordid,$offerArr,$arr_lvl_code);
                      if($errormessage==''){
                          $message="Audit Record saved successfully for Call Record Id-".$selcallrecordid;
                         $this->render('/nonblaudit/auditform',array('message'=>$message,'callrecordid'=>''));
                      }else{
                          $this->render('/nonblaudit/auditform',array('offerArr'=>$offerArr,'auditArr'=>$auditArr,'callrecordid'=>$callrecordid,"message"=>$errormessage));
                      }
		   }else{
                       $this->render('/nonblaudit/auditform',array('offerArr'=>$offerArr,'callrecordid'=>$callrecordid));
                   }
	}       
        
      public function actionSampling() 
	{
		$empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}                
                $currentDate = date("d-m-Y");
                $request = Yii::app()->request;
                $start_date= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));		
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$bucket=$mailoption='';
                $dataArr=array();               
		  $obj =new NonBLAuditModel();	
                  $maxrecords= $request->getParam("maxrecords",10);
                  $action="submit_view";
                 $vendor_approve = !empty($request->getParam("vendor_approve")) ? $request->getParam("vendor_approve") : 'ALL';

                   if(isset($_REQUEST['submit_send']))
                   {
                       $action="submit_send";
                        $dataArr=$obj->nonblauditSample($request,$action);
                       exit;
                   }elseif(isset($_REQUEST['submit_view']))
                   {
                        $dataArr=$obj->nonblauditSample($request,$action);   
                       exit;
                   }else{
                        $leapdashboardModel =  new LeapDashboardModel();
                        $vendorRe = $leapdashboardModel->getLeapVendor_list($request,$empId);
                        $allVenders=$leapdashboardModel->allvendernames();

                        $permision = $vendorRe['permision'];
                        $vendorArr = $vendorRe['vendorArr'];
                        $this->render('/nonblaudit/sampling',array('vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'allVenders'=>$allVenders,'dataArr'=>$dataArr,'start_date'=>$start_date,'bucket'=>$bucket,'maxrecords'=>$maxrecords,'mailoption'=>$mailoption));
                        
                   }                   
	}  
public function actionAuditcheck() 
	{
                    $obj =new NonBLAuditModel;
                    $etoModel =  new AdminEtoForm();
                    $emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
                    if(!$emp_id){
                      echo 'Please login again';
                      exit;
                    }
                    $arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id);
                    $offer_id=$_REQUEST['callrecordid'];                    
                    $vendor_check='';
                    if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])){
                        $vendor_check=$arr_lvl_code['ETO_LEAP_VENDOR_NAME'];
                    }
                    
                    $response=$obj->check_audit_offer($offer_id,$vendor_check);                   
                    $this->renderPartial('/audit/checkaudit', array('response'=>$response));
	}
 public function actionMis() 
	{
		$empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}
                
                $currentDate = date("d-m-Y");
                $request = Yii::app()->request;
                $start_date=$start_date1= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
		
		$end_date=$end_date1= $request->getParam('end_date','');
		$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
                $dataArr=array();
                
                $obj =new AuditModel;	
                $leapdashboardModel =  new LeapDashboardModel();
                $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
                $vendor_approve = !empty($request->getParam("vendor_approve")) ? $request->getParam("vendor_approve") : 'ALL';
                $vendor_audit = $request->getParam("vendor_audit");
                $auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
                $permision = $vendorRe['permision'];
                $vendorArr = $vendorRe['vendorArr'];
                $AssociateId='';
                $first = new DateTime($start_date1);
		$second = new DateTime($end_date1);
		$interval = $second->diff($first);
		$interval=$interval->format('%a total days');
                if($vendor_audit<>'ALL'){
                    $noofdays=7;
                }else{
                    $noofdays=2;
                }
                   if(isset($_REQUEST['export_dump']) && $interval <=$noofdays)
                   {
                       $action="exportEXL";
                       $dataArr=$obj->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId); 
                       exit;
                   }elseif(isset($_REQUEST['submit_dump']) && $interval <=$noofdays)
                   {
                       $action="submit_dump";
                       $dataArr=$obj->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId); 
                      
                   }
                    $this->render('/nonblaudit/auditmis',array('dataArr'=>$dataArr,'start_date'=>$start_date,'end_date'=>$end_date,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_audit'=>$vendor_audit,'interval'=>$interval,'permision'=>$permision));
	}
 public function actionAuditedit() 
	{
	$call_id=isset($_REQUEST['call_id']) ? $_REQUEST['call_id'] : '';
	$auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
	$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
        $qtype=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
        if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
	$message='';
	$action='';
        $obj =new AuditModel;	   
                    $objnonbl =new NonBLAuditModel();
                    $offerArr=$objnonbl->callDetail($call_id); 
                    $auditArr=$obj->show_audit_question($qtype);       
                    if(isset($_REQUEST['save']) && isset($auditArr['quesArr']))
                    {
                      $message=$objnonbl->save_audit_edit_details(0,$auditArr,$call_id,$auditId,$offerArr);                      
                    }                   
                     $AssociateId='';
                     $dataArr=$obj->auditDump(0,'','',$action,'','',$auditId,$AssociateId); 
                    // echo '<pre>'; print_r($offerArr);                    print_r($dataArr);
                    $vendor_audit=isset($vendor_audit)?$vendor_audit:'';
                    $vendor_approve=isset($vendor_approve)?$vendor_approve:'';
                    $start_date=isset($start_date)?$start_date:'';
                    $end_date=isset($end_date)?$end_date:'';
                     $this->render('/nonblaudit/auditscreenedit',array('offerArr'=>$offerArr,'auditArr'=>$auditArr,'call_id'=>$call_id,'message'=>$message,'dataArr'=>$dataArr,'auditId'=>$auditId,'vendor_audit'=>$vendor_audit,'vendor_approve'=>$vendor_approve,'start_date'=>$start_date,'end_date'=>$end_date));
	
	}
public function actionShowragscale(){
       $raghtml=$dbh=$dbh_ml='';
         if(isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid']>0){   
             $obj = new Globalconnection();
            $model = new GlobalmodelForm();
            if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
            {
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
                $dbh_ml = $obj->connect_db_yii('postgress_web68v'); 
            }else{
                $dbh = $obj->connect_db_yii('postgress_web68v'); 
                $dbh_ml = $obj->connect_db_yii('postgress_web54v'); 
            } 
           
            if($dbh){
                $desc = array('1'=>'Red','6'=>'Red','2'=>'Orange','7'=>'Orange','3'=>'Yellow','8'=>'Yellow','4'=>'Green','9'=>'Green','5'=>'Blue','10'=>'Blue');                
                $desc2 = array('15'=>'Blue','25'=>'Blue','35'=>'Blue','12'=>'Orange','22'=>'Orange','32'=>'Orange','13'=>'Yellow','23'=>'Yellow','33'=>'Yellow','14'=>'Green','24'=>'Green','34'=>'Green','11'=>'Red','21'=>'Red','31'=>'Red');                
                
                $sql="select sold_rag_score_final,approv_rag_score from ETO_OFR_RAG_SCORES where eto_offer_display_id= :ETO_OFR_DISPLAY_ID";
                $bind[':ETO_OFR_DISPLAY_ID']=$_REQUEST['offerid']; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                while($rec = $sth->read()) {//print_r($rec);//die;
                        $sold_rag_score_final=isset($rec['sold_rag_score_final'])?$rec['sold_rag_score_final']:'';
                        $approv_rag_score=isset($rec['approv_rag_score'])?$rec['approv_rag_score']:'';                        
                       $raghtml .= '<tr><td>Sold RAG</td><td style="color:'.@$desc2[$sold_rag_score_final].'">'.@$desc2[$sold_rag_score_final].'</td></tr>';
                                              
                       $raghtml .=   '<tr><td>Approval RAG</td><td style="color:'.@$desc[$approv_rag_score].'">'.@$desc[$approv_rag_score].'</td></tr>';
                         
                       
                } 
            }
          
            if($dbh_ml){
                $sql="select output,bl_app_probability from leap_saleability_model_log where eto_ofr_display_id= :ETO_OFR_DISPLAY_ID";
                $bind[':ETO_OFR_DISPLAY_ID']=$_REQUEST['offerid']; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_ml, $sql, $bind);//echo $sql;        
                while($rec = $sth->read()) {
                    $raghtml .= '<tr><td>Sold Probability </td><td>'.@$rec['output'].'</td></tr>';
                    $raghtml .= '<tr><td>Approval  Probability</td><td>'.@$rec['bl_app_probability'].'</td></tr>';
                       
                }
            }
        }
        if($raghtml<>''){
            $raghtml ='<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">'.$raghtml.'</table>';
        }
    echo $raghtml; 
  }
  
public function actionTestPGOCI() {
        $param = array('_sglid'=>$_REQUEST['_sglid'],'_bglid'=>$_REQUEST['_bglid'],'_oid'=>$_REQUEST['_oid']);
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') {
            $url = "https://dev-paywith.indiamart.com/index.php?r=invoice/wserve/_infoDet";
        } else {
            $url = "https://paywith.indiamart.com/index.php?r=invoice/wserve/_infoDet";
        }
            $cSession = curl_init();
            curl_setopt($cSession, CURLOPT_URL, $url);
            curl_setopt($cSession, CURLOPT_POST, true);
            curl_setopt($cSession, CURLOPT_POSTFIELDS, $param);
            curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($cSession);
           echo $httpcode = curl_getinfo($cSession, CURLINFO_HTTP_CODE);
            $result = json_decode($response, true);
	    echo '<pre>';print_r($result);
    }
    
}