<?php 
class LeapCallReportController extends Controller
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
                  $allVenders=CommonVariable::get_active_vendor_list();   	
		  $start_date=$end_date=strtoupper(date("d-M-Y"));
		  $message='';
		  $obj =new LeapCallReportModel;		
                   if(isset($_REQUEST['search']))
                   {                      	
                      $data=$obj->call_report($_REQUEST);                      
                      echo $data;die;                   
                  }else{
                       $this->render('/leapcallreport/report',array('start_date'=>$start_date,'end_date'=>$end_date,'message'=>$message,'allVenders'=>$allVenders));
                   }
                }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }
	}     
public function actionTrainingReport() 
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
                    $leapdashboardModel =  new LeapDashboardModel();
                    $request = Yii::app()->request;
                    $vendorRe = $leapdashboardModel->getLeapVendor_list($request,$emp_id);
                    $permision = $vendorRe['permision'];
		    $vendorArr = $vendorRe['vendorArr'];
                
		  $start_date=$end_date=strtoupper(date("d-M-Y"));
		  $message='';
		  $obj =new LeapCallReportModel;		
                  if(isset($_REQUEST['quality']))
                   {                      	
                        $action="submit_dump";
                        $start_date=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:'';
                        $end_date=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:'';
                        $vendor_approve=isset($_REQUEST['vendor_approve'])?$_REQUEST['vendor_approve']:'';
                        $vendor_audit=isset($_REQUEST['vendor_audit'])?$_REQUEST['vendor_audit']:'';
                        $AssociateId=isset($_REQUEST['att_id'])?$_REQUEST['att_id']:'';
                        $pre=isset($_REQUEST['dateflag'])?$_REQUEST['dateflag']:'1';
                        $dataArr=$obj->auditForm_v1_Mis($pre,$start_date,$vendor_approve,$vendor_audit,$AssociateId);
                        $this->render('/audit/audit_mis7',array('dataArr'=>$dataArr,'start_date'=>$start_date,'end_date'=>$end_date,'AssociateId'=>$AssociateId,'pre'=>$pre));
                    die;
                   }else if(isset($_REQUEST['training'])){
                      $data=$obj->training_report($_REQUEST);                      
                      echo $data;die;                   

                   }else if(isset($_REQUEST['search']))
                   {                      	
                      $data=$obj->training_report_summary($_REQUEST);                      
                      echo $data;die;                   
                  }else{
                       $this->render('/leapcallreport/trainingreport',array('start_date'=>$start_date,'end_date'=>$end_date,'message'=>$message,'vendorArr'=>$vendorArr));
                   }
                }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }
	}
        
                }