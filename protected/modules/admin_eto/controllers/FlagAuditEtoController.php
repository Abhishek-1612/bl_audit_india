<?php 
        error_reporting(1);
        $_SERVER['SERVER_NAME'] = 'gladmin.intermesh.net';
        
        class FlagAuditEtoController extends Controller
        {
                public function actionSampling() 
                {       
                        
                        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                        $empId = Yii::app()->session['empid'];
                        $tljson='';
                        $empId = '91476'; // Testing
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
                        $user_view =1; // Testing
                        if($user_view ==1)
                        {                
                                $currentDate = date("d-m-Y");
                                $request = Yii::app()->request;
                                $start_date= $request->getParam('start_date','');
                                $start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));		
                                $start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
                                $dataArr=array();
                                $dataArr1=array();
                                $obj = new FlagAuditModel;
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
                                        $dataArr=$obj->testData1($empId,$start_date,'',$maxrecords,$vendor_approval,$agentid,$bucket,$action,$vendorArr,'');
                                        // $dataArr=$obj->auditSample($empId,$start_date,'',$maxrecords,$vendor_approval,$agentid,$bucket,$action,$vendorArr,'');
                                        if(empty($dataArr)){
                                                echo "<br> <center>No Data Found</center>";
                                                exit;
                                        }else{
                                                // echo "<pre>";print_r($dataArr);die('data found');
                                                $this->render('/flagaudit/ajaxFlagData',['data' => $dataArr]);
                                                exit;
                                        }
                                         
                                        //$obj->printsample($dataArr);//,$dataArr1);

                                }else{
                                        $this->render('/flagaudit/flagaudit',array('allVenders'=>$allVenders,'dataArr'=>$dataArr,'start_date'=>$start_date,'vendorArr'=>$vendorArr,'vendor_approval'=>$vendor_approval,'agentid'=>$agentid,'bucket'=>$bucket,'maxrecords'=>$maxrecords,'arr_lvl_code'=>$arr_lvl_code));
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
                        $empId = '91476'; // Testing
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
                                $obj =new FlagAuditModel;
                                echo $dataArr=$obj->save_audit_details();   
                                exit;                   
                        }else{
                                echo "You do not have permission";
                                exit;
                        }
                }
        }
