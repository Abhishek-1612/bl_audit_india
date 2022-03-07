<?php 
error_reporting(1);
class BLNIReportController extends Controller
{    
public function actionReport() 
	{       
	        $emp_id = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                 if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
                $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
                $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

                if(empty($user_permissions))
                {
                $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                }  
                
                             
                $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : ''; 
                if($user_view==1){
                  $request = Yii::app()->request;
                  $message='';
		  $obj =new BLNIReportModel;	
		  $start_date=strtoupper(date("d-M-Y",strtotime("-7 days")));
		  $end_date=strtoupper(date("d-M-Y",strtotime("-1 days")));

                 if(isset($_REQUEST['search']))
                   {      
                        $start_date=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:'';
                        $end_date=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:'';
                        $data=$obj->weekly_report($_REQUEST);                      
                        echo $data;die;                   
                  }else{
                       $this->render('/blnireport/report',array('start_date'=>$start_date,'end_date'=>$end_date,'message'=>$message));
                   }
                }else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }
	}
        
                }