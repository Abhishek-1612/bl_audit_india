<?php 
$_SERVER['SERVER_NAME'] = 'gladmin.intermesh.net';
class BulkAuditEtoController extends Controller
{
        
	public function actionSampling()
        {
                
                $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $empId = Yii::app()->session['empid'];
                $empId = '1234'; // TEsting
                $tljson='';
                if(!$empId)
                {
                print "You are not logged in";
                        exit;
                }
                
                // $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
                if(empty($user_permissions))
                {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                }
                isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                $user_view =1; //testing
                
                if($user_view ==1)
                {                
                $currentDate = date("d-m-Y");
                $request = Yii::app()->request;
                $start_date= $request->getParam('start_date','');
                $start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));		
                $start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
                
                $dataArr=array();  
                $dataArr1=array();            
                $obj = new BulkAuditModel;
                $etoModel =  new AdminEtoForm();
                $leapdashboardModel =  new LeapDashboardModel();
                $vendorRe = $leapdashboardModel->getLeapVendor_list($request,$empId);
                $allVenders=$leapdashboardModel->allvendernames();
                $arr_lvl_code = $etoModel->getLeapEmpLVL($empId);
                $permision = $vendorRe['permision'];
                $vendorArr = $vendorRe['vendorArr'];
                $vendor_approval = $request->getParam("vendor_approval",'');
                $bucket = $request->getParam("bucket",'ALL');
                $maxrecords= $request->getParam("maxrecords",10);
                $agentid= $request->getParam("agentselect",0);
                if(isset($_REQUEST['submit_view']))
                {
                        $action="submit_view";
                        $dataArr=$obj->auditSample($empId,$start_date,'',$maxrecords,$vendor_approval,$agentid,$bucket,$action,$vendorArr,''); 
                        $obj->printsample($dataArr);//,$dataArr1);
                        exit;
                }else{  
                        $this->render('/bulkaudit/delaudit',array('allVenders'=>$allVenders,'dataArr'=>$dataArr,'start_date'=>$start_date,'vendorArr'=>$vendorArr,'vendor_approval'=>$vendor_approval,'agentid'=>$agentid,'bucket'=>$bucket,'maxrecords'=>$maxrecords,'arr_lvl_code'=>$arr_lvl_code));
                }
                }else{
                echo "You do not have permission";
                exit;
                }
        }  
  
      
        public function actionAudit() 
	{      
                $empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $empId = 1234; //Testing
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}
                // $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
		if(empty($user_permissions))
		{
		        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                $user_view = 1; //Testing  
		if($user_view ==1)
		{  
                        $obj =new BulkAuditModel;
                        echo $dataArr=$obj->save_audit_details();   
                        exit;                   
                }else{
                     echo "You do not have permission";
                     exit;
                }
        }
        public function actionAudit_edit() 
	{  
                
                $empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
               if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}
                $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{  
                $obj =new BulkAuditModel;

                $auditid =isset($_REQUEST["auditid"]) ? $_REQUEST["auditid"] : '';
              
                $obj->save_audit_details_Edit($auditid);   

                exit;                   
	
        }else{
                     echo "You do not have permission";
                     exit;
                }
        }


        public function actionAuditMis() 
	{      
                // echo "Hello";die;
		$empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $empId = 12345; //Testing
                
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
                
                $obj =new BulkAuditModel;	
                $leapdashboardModel =  new LeapDashboardModel();
                $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
                $vendor_approve = !empty($request->getParam("vendor_approve")) ? $request->getParam("vendor_approve") : 'ALL'; // deleted by
                $vendor_audit = $request->getParam("vendor_audit");
                $vendor_approval = $request->getParam("vendor_approval",'');
                $deletedReason =  $request->getParam("deletedreasonselect");
                $auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
                $permision = $vendorRe['permision'];
                $vendorArr = $vendorRe['vendorArr'];
                $deleted_by = $request->getParam("vendor_approve",'');
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
                        $dataArr=$obj->auditDump_mis(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId,$deleted_by); 
                        exit;
                }elseif(isset($_REQUEST['submit_dump']) && $interval <=$noofdays)
                {
                        $action="submit_dump";
                        $dataArr=$obj->auditDump_mis(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId,$deleted_by); 
                }
                // echo "<pre>";print_r($dataArr);die;

                $this->render('/bulkaudit/AuditMis',array('dataArr'=>$dataArr,'start_date'=>$start_date,'end_date'=>$end_date,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_approval'=>$vendor_approval, 'vendor_audit'=>$vendor_audit,'interval'=>$interval,'deleted_by'=>$deleted_by,'permision'=>$permision));   
        }
        
        public function actionAuditMis_Edit(){
                $empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $tljson='';
                $empId = 12345; //Testing
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}
                // $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
		if(empty($user_permissions))
		{
		        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		$user_view = 1; //Testing
                if($user_view ==1)
		{                
                        $currentDate = date("d-m-Y");
                        $request = Yii::app()->request;
                        $start_date= $request->getParam('start_date','');
                        $start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));		
                        $start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
                        $end_date= $request->getParam('end_date','');
                        $end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));		
                        $end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
                        $dataArr=array();
                        $auditdet=array();
                        $obj =new BulkAuditModel;
                        $auditId= $request->getParam('auditid','');
                        $offer_id= $request->getParam('offer_id','');
                        $auditdet=$obj->auditdetailbyID($auditId);
                        $delsource=isset($auditdet[0]['DELSOURCE'])?$auditdet[0]['DELSOURCE']:'';
                        $action="";
                        $dataArr=$obj->auditSample($empId,'','','1','','','',$action,'',$delsource); 
                        $this->render('/bulkaudit/delauditedit',array('dataArr'=>$dataArr,'auditdet'=>$auditdet , 'auditid'=>$auditId));
                  
                }else{
                     echo "You do not have permission";
                     exit;
                }
        }
  public function actionTestpg_c1()
    {
         $dbh_pg = pg_pconnect("host=34.134.176.120 port=5432 dbname=imbuyreq user=imalert password=imalertdb4iil") or die('cant connnect to postgresql: '.pg_last_error());
           if($dbh_pg){
               echo 'connected';
           }else{
              echo 'not connected';
           }die;
    }
    public function actionTestpg_c2()
    {
         $dbh_pg = pg_pconnect("host=34.68.231.179 port=5432 dbname=imbuyreq user=gladmin password=gladmin4iil") or die('cant connnect to postgresql: '.pg_last_error());
           if($dbh_pg){
               echo 'connected';
           }else{
              echo 'not connected';
           }die;
    }
     public function actionTestpg_c3()
    {
        
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
                
            $dbh = $obj->connect_db_yii('postgress_web68v');   
            
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
           if($dbh){
               echo 'connected';
           }else{
              echo 'not connected';
           }die;
    }
 
  
     Public function actionRedistest()
    {
        $empId =Yii::app()->session['empid'];	
        if($empId > 0){
	$redis='';
	try {
	      $redis = new Redis();
              	      if($_SERVER['HTTP_HOST'] == 'dev-gladmin.intermesh.net' || $_SERVER['HTTP_HOST'] == 'web222v.intermesh.net' || $_SERVER['HTTP_HOST'] == 'stg-gladmin.intermesh.net')
	      {
		  $redis->connect('63.251.115.228:6379');
}
	      else
	      {

	        $redis->connect('34.69.120.141:5471');
              }
echo $redis_CON_FLAG = $redis->LLEN('LEAP_CALL_USER_FLAG');
	}
	catch (Exception $e) {
		echo "Couldn't connected to Redis";
		echo $e->getMessage();
		exit;
	}
            }else{
                echo "You are not logged in";
                exit;
        } 
        
        }	
  
}
