<?php 
class AddvendorController extends Controller
{
	public $allVenders=array();
        public $leapMisEmp = array();
        public function init(){
		$this->leapMisEmp = array(29545,36924,22970,86692,86689,85361,85945,5096,26564,32016,84844,84873,30314,61154,77082,71355,68305,76028,65677,67422,71116,67572,60437,43894,62902,24766,61721,62129,56333,58511,56576,69053,58159,34058,21875,6251,46480,23015,49465,37686,35740,22288,32236,3664,40208,40207,40022,35422,3575,21870,33403,33402,37642,45528,48862,38628,40399,48880,75532,86777,5096,23293);
	 	$this->allVenders=CommonVariable::get_active_vendor_list();
        }
	
	public function actionVendorLeapMis(){
	    $succMsg = ''; $errMsg = ''; $showForm = 1;
	    $request = Yii::app()->request;
	    $empId = Yii::app()->session['empid'];
            if($empId){
			$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
			
			$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
			if(empty($user_permissions)){
			$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
			}
			
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
	
		if($user_view ==1){
	    if(!in_array($empId,$this->leapMisEmp)){
		$errMsg = "Permission Denied";
		$showForm = 0;
	    } else{
		if(Yii::app()->request->isPostRequest){
			$action = $request->getParam("action",'');
                        $leapdashboardModel =  new LeapDashboardModel();
						
			if($action == "getempdetail"){
				$empDetArr = $leapdashboardModel->getEmpDetail($request);// echo '<pre>';print_r($empDetArr);
				$msg = "";
				if(empty($empDetArr)){
					$msg = "Employee Not Found";
				}
					$empDet['emp_name'] =isset($empDetArr['GL_EMP_NAME'])?$empDetArr['GL_EMP_NAME']:'';
					$empDet['emp_email'] = isset($empDetArr['GL_EMP_EMAIL'])?$empDetArr['GL_EMP_EMAIL']:'';
					
					$empDet['emp_level'] = isset($empDetArr['ETO_LEAP_EMP_LEVEL'])?$empDetArr['ETO_LEAP_EMP_LEVEL']:'';
					$empDet['is_working'] = isset($empDetArr['ETO_LEAP_EMP_IS_ACTIVE'])?$empDetArr['ETO_LEAP_EMP_IS_ACTIVE']:'';
                                        $empDet['vendor_emp_id'] = isset($empDetArr['VENDOR_EMPLOYEE_ID'])?$empDetArr['VENDOR_EMPLOYEE_ID']:'';
                                        $shift_time = isset($empDetArr['SHIFT_TIME'])?$empDetArr['SHIFT_TIME']:'';
                                        $vendor_id = isset($empDetArr['FK_ETO_LEAP_VENDOR_ID'])?$empDetArr['FK_ETO_LEAP_VENDOR_ID']:'';
                                        $empDet['vendor_name'] = isset($empDetArr['ETO_LEAP_VENDOR_NAME'])?$empDetArr['ETO_LEAP_VENDOR_NAME']:'';
                                        $empDet['vendor_name']=$vendor_id. "|".$empDet['vendor_name'];
                                        $empDet['emp_skill_level'] = isset($empDetArr['ETO_LEAP_EMP_SKILL_LEVEL'])?$empDetArr['ETO_LEAP_EMP_SKILL_LEVEL']:'';
                                        $empDet['certification_date'] = isset($empDetArr['CERTIFICATION_DATE'])?$empDetArr['CERTIFICATION_DATE']:'';
										$empDet['extension_no'] = isset($empDetArr['ETO_LEAP_EMP_EXT_NUM'])?$empDetArr['ETO_LEAP_EMP_EXT_NUM']:'';
                                        $arrshift_time=array();
                                        $arrshift_time=explode('-', $shift_time);
					
                                        $empDet['st1'] = isset($arrshift_time[0])?$arrshift_time[0]:'';
                                        $empDet['st2'] = isset($arrshift_time[1])?$arrshift_time[1]:'';
					$empDet['errmsg'] = $msg;
					$res = json_encode($empDet);
					echo $res;exit;	
			}
			
			$isUpdate = $request->getParam("isUpdate",'');
			if(!empty($isUpdate)){
				$Status = $leapdashboardModel->updateVendorLeapMis($request);		
			}
		  	else{
		  		$Status =$leapdashboardModel->addVendorLeapMis($request);
		  		}
		  if(isset($Status['status']) && $Status['status'] == "Success"){
		      $succMsg = $Status['msg'];
		  } else if(isset($Status['status']) && $Status['status'] == "Fail"){
		      $errMsg = $Status['msg'];
		  }
		}
	    }
	  //  print_r($succMsg);
		//exit;
	    $this->render('/admineto/vendorleapmis',array('succMsg' => $succMsg,'errMsg' => $errMsg,'showForm' => $showForm,'allVenders'=>$this->allVenders));
			}
			else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
					exit;
					}
				}else{
					echo "<b style='font-size:15px;color:red;padding-left:20px'>You are not logged in<b>";
					exit;
				}
	}	 
        
         public function actionChangeagent() {
            $request = Yii::app()->request;
            $actionVal = $request->getParam("action",'');
            $vendorArr = array();		
            $empId = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
			
			$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
			
				if(empty($user_permissions)){ 
					$user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] =''; 
				}
			
			
			$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : ''; 
			
            if($user_view==1){		 
                $leapdashboardModel =  new LeapDashboardModel();
		$vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
		$permision = $vendorRe['permision'];
		$vendorArr = $vendorRe['vendorArr'];
		
                    if($actionVal == 'showch')
                    {
                            $vendor = $request->getParam("vendor");
                            $agentstatus = $request->getParam("agentstatus");
                            if($agentstatus==''){
                                $agentstatus='Active';
                            }
                            $this->render("/admineto/changeagent",array('vendorArr' => $vendorArr,'action' => 'showch','vendor'=>$vendor,'agentstatus'=>$agentstatus));
                            exit;
                    }
                    else if($actionVal == 'save')
                    {
                            $vendor = $request->getParam("vendor");
                            $agentstatus = $request->getParam("agentstatus");
                            $re = $leapdashboardModel->saveAgentName($request,$empId);
                            $displayAgentInfo = $leapdashboardModel->displayAgentInfo($request,$vendorArr);
                            $this->render("/admineto/changeagent",array('succMsg'=>$re,'result' => $displayAgentInfo,'vendorArr' => $vendorArr,'vendor' => $vendor,'action' => 'ch','agentstatus'=>$agentstatus));
                            exit;
                    }else {
                           $vendor = $request->getParam("vendor");
                            $agentstatus = $request->getParam("agentstatus");
                            $displayAgentInfo = $leapdashboardModel->displayAgentInfo($request,$vendorArr);
                            $this->render("/admineto/changeagent",array('result' => $displayAgentInfo,'action' => 'ch','vendorArr' => $vendorArr,'vendor' => $vendor,'agentstatus'=>$agentstatus));
                            exit;                     
                    }			
		}else{
                    echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                          exit;
                }
	}

 public function actionApprovalpgdata()
    {
		$res = array();
		$model = new GlobalmodelForm();
		$obj = new Globalconnection();
		$dbh = $obj->connect_approvalpg();

		$sql = "SELECT * FROM gladm_modules limit 10 ";
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		$res = $sth->readAll();
       echo '<pre>'; print_r($res);

       
       		$sql = "SELECT * FROM EMPLOYEE_MANAGER limit 20 ";
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		$res = $sth->readAll();
       echo '<pre>'; print_r($res);
       
       $sql = "SELECT * FROM GLADMIN_SCREEN_DOCS limit 10";
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		$res = $sth->readAll();
       echo '<pre>'; print_r($res);

       
       

    }

	
}