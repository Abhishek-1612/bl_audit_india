<?php 

class LeapactivityController extends Controller
{
 public function actionActivitydetail(){
        $response='';
        $empid =Yii::app()->session['empid'];
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empid); 
        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
	
        if($user_view ==1 && $empid > 0)
	{
            if(isset($_POST['Submit'])){
                $start_date =isset($_POST['start_date']) ? $_POST['start_date'] : '';
                $vendor=isset($_POST['vendor']) ? $_POST['vendor'] : '';
                if(($start_date<>'') && ($vendor>0)){
                $Leap_ActivityForm=new Leap_ActivityForm();
                if(($vendor ==29) || ($vendor ==30)){
                    $response =$Leap_ActivityForm->reviewpoolassociateactdetail();
                }else{
                    $response =$Leap_ActivityForm->getassociateactdetail();
                }
                
                }
            }
            $leapdashboardModel =  new LeapDashboardModel();
            $vendorRe = $leapdashboardModel->getLeapVendor_list('',$empid);
            $vendorArr = $vendorRe['vendorArr'];
            $this->render("/admineto/activityagent",array('vendorArr'=>$vendorArr,'response'=>$response));            
        } else{
                echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }

   }

}