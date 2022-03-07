<?php 
class DNCBillingController extends Controller
{
	public function actionIndex() 
	{ 
            
        $emp_id = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                
        $response='';
        if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
        
            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id); 

            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = '';
                $user_permissions['TOEDIT']= '';
                $user_permissions['TOADD']= '';
            }
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
            $user_edit =isset($user_permissions['TOEDIT']) ? $user_permissions['TOEDIT'] : '';
            $user_add = isset($user_permissions['TOADD']) ? $user_permissions['TOADD'] : '';
        
     if($user_view==1)
      {
		 $obj =new DNCBillingModel;
                 $leapdashboardModel =  new LeapDashboardModel();
                 $request = Yii::app()->request;
		 $vendorRe = $leapdashboardModel->getLeapVendor_list($request,$emp_id);
                $vendor = !empty($request->getParam("vendor")) ? $request->getParam("vendor") : 'ALL';
                $vendorArr = $vendorRe['vendorArr'];
                unset($vendorArr['0']);
                 if(isset($_REQUEST['search'])){ 
                    $response= $obj->search($user_add,$user_edit);
                    $this->render('/dncbilling/billingscreen',array('response'=>$response,'vendorArr'=>$vendorArr,'vendor'=>$vendor,'user_edit'=>$user_edit));
                }else{
                    $this->render('/dncbilling/billingscreen',array('response'=>$response,'vendorArr'=>$vendorArr,'vendor'=>$vendor,'user_edit'=>$user_edit));
                }
      }else{
          echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
      }
	}
	public function actionBilledit() 
	{
	$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
       if(!$emp_id){
          echo 'Please login again';
          exit;
        }
	$message='';
	$obj =new DNCBillingModel;	   
        $bid=isset($_REQUEST['bid']) ? $_REQUEST['bid'] : '';
                     if(isset($_REQUEST['action']))
                    {
                     echo $message=$obj->save_bill_details();                      
                    }
                    die;
                  
	}

}