<?php 
class AddnumberController extends Controller
{
	public $allVenders=array();
        public $leapMisEmp = array();
        public function init(){
		$this->leapMisEmp = array(3575,67422,64382,58159,58511,62129,51107,67572,75532);
	 	$this->allVenders=CommonVariable::get_active_vendor_name();  
        }
	
	public function actionLeapNumber(){
		
        $hostname=$_SERVER['SERVER_NAME'];
	    $succMsg = ''; $errMsg = ''; $showForm = 1;
	    $request = Yii::app()->request;
		$empId = Yii::app()->session['empid'];
		
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';  
            
				$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);

				if(empty($user_permissions)){ 
					$user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TOADD']= $user_permissions['TOUPDATE']=''; 
				}      
			$user_update=isset($user_permissions['TOUPDATE']) ? $user_permissions['TOUPDATE'] : '';
			$user_edit =isset($user_permissions['TOEDIT']) ? $user_permissions['TOEDIT'] : '';
			$user_add = isset($user_permissions['TOADD']) ? $user_permissions['TOADD'] : '';
			$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : ''; 
			
            if($user_view==1){
                $cookie_mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
            if(!$empId)
		{
			print "Your are not logged in<BR> Click here to <A
                          HREF='http://$hostname'>login</A><BR>";
		}
                else
                {
	    if(!in_array($empId,$this->leapMisEmp)){
		$errMsg = "Permission Denied";
		$showForm = 0;
	    } else{
		if(Yii::app()->request->isPostRequest){
			$action = $request->getParam("action",'');
                        $leapdashboardModel =  new LeapDashboardModel();
			if($action == "getphonenumber"){
				$empDetArr = $leapdashboardModel->getNumberDetail($request);
				$msg = "";
				if(empty($empDetArr)){
                                    
					$msg = "Phone Number Not Found";
				}
					$empDet['number'] =isset($empDetArr['CALL_CENTER_NUMBER'])?$empDetArr['CALL_CENTER_NUMBER']:'';
					$empDet['vendor_type'] = isset($empDetArr['CALL_NUMBER_VENDOR_TYPE'])?$empDetArr['CALL_NUMBER_VENDOR_TYPE']:'';
					$empDet['vendor_name'] = isset($empDetArr['CALL_NUMBER_VENDOR_NAME'])?$empDetArr['CALL_NUMBER_VENDOR_NAME']:'';
					$empDet['status'] = isset($empDetArr['CALL_NUMBER_STATUS'])?$empDetArr['CALL_NUMBER_STATUS']:'';
					$empDet['channel'] = isset($empDetArr['CALL_NUMBER_CHANNEL'])?$empDetArr['CALL_NUMBER_CHANNEL']:'';
					$empDet['serviceprovider'] = isset($empDetArr['CALL_NUMBER_SERV_PROVIDER'])?$empDetArr['CALL_NUMBER_SERV_PROVIDER']:'';
					$empDet['numberowner'] = isset($empDetArr['CALL_NUMBER_VENDOR_OWNERSHIP'])?$empDetArr['CALL_NUMBER_VENDOR_OWNERSHIP']:'';
					$empDet['errmsg'] = $msg;

				
					$res = json_encode($empDet);
					echo $res;exit;	
			}
			$isUpdate = $request->getParam("isUpdate",'');
			if(!empty($isUpdate)){
				$Status = $leapdashboardModel->updatenumber($request,$empId);		
			}
		  	else{
		  		$Status =$leapdashboardModel->addnumber($request,$empId);
		  		}
		  if(isset($Status['status']) && $Status['status'] == "Success"){
		      $succMsg = $Status['msg'];
		  } else if(isset($Status['status']) && $Status['status'] == "Fail"){
		      $errMsg = $Status['msg'];
		  }
		}
	    }
	    
	    $this->render('/admineto/Addnumber',array('succMsg' => $succMsg,'errMsg' => $errMsg,'showForm' => $showForm,"cookie_mid"=>$cookie_mid,'allVenders'=>$this->allVenders));
	}
        }
        else{
                    echo "You don't have permission to view";
                          exit;
                }
}

}