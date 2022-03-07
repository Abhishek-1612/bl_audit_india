<?php

class LeapDowntimeTrackerController extends Controller
{
   	public function actionEntryForm() 
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
                $start_date=strtoupper(date("d-M-Y"));
		  $message='';
		  $obj =new LeapDowntimeTrackerModel;		
		  if(isset($_REQUEST['save']))
                   {                      	
                      $message=$offerArr=$obj->save_audit_details($_REQUEST);                      
                      $this->render('/leapdowntimetracker/ldt_auditscreen',array('start_date'=>$start_date,'allVenders'=>$allVenders,'message'=>$message));                      
		   }else{
                       $this->render('/leapdowntimetracker/ldt_auditscreen',array('start_date'=>$start_date,'allVenders'=>$allVenders,'message'=>$message));
                   }
                }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                } 
	}
        
        public function actionApprovalForm() 
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
		 $allVenders=CommonVariable::get_active_vendor_list();   	//array('ALL','RADIATEPNSMRK','COMPETENT','COGENT','COGENTBRB','COGENTDNC','COGENTINBOUND','COGENTINTENT','COGENTPNS','DDN','ILEAD','KOCHARTECH','KOCHARTECHCHN','KOCHARTECHDNC','KOCHARTECHLDH','NOIDA','PROCMART','RADIATE','RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','VKALP','VKALPDNC');
                 $start_date=strtoupper(date("d-M-Y"));
		  $message='';
		  $obj =new LeapDowntimeTrackerModel;		
                   if(isset($_REQUEST['search']))
                   { 
                      $data=$offerArr=$obj->show_audit_detail($_REQUEST);                      
                      echo $data;die;                   
                  }elseif(isset($_REQUEST['update']))
                   {                      	
                      $message=$offerArr=$obj->UpdateAudit($_REQUEST); 
                      echo $message;die;
                      $this->render('/leapdowntimetracker/ldt_approvalscreen',array('start_date'=>$start_date,'allVenders'=>$allVenders,'message'=>$message));                      
		   }else{
                       $this->render('/leapdowntimetracker/ldt_approvalscreen',array('start_date'=>$start_date,'allVenders'=>$allVenders,'message'=>$message));
                   }
                }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }
	}
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
		$allVenders=CommonVariable::get_active_vendor_list();   	//array('ALL','RADIATEPNSMRK','COMPETENT','COGENT','COGENTBRB','COGENTDNC','COGENTINBOUND','COGENTINTENT','COGENTPNS','DDN','ILEAD','KOCHARTECH','KOCHARTECHCHN','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','NOIDA','PROCMART','RADIATE','RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT','VKALP','VKALPDNC');
                $start_date=strtoupper(date("d-M-Y"));
		  $message='';
		  $obj =new LeapDowntimeTrackerModel;		
                   if(isset($_REQUEST['search']))
                   {                      	
                      $data=$offerArr=$obj->audit_report($_REQUEST);                      
                      echo $data;die;                   
                  }else{
                       $this->render('/leapdowntimetracker/ldt_report',array('start_date'=>$start_date,'allVenders'=>$allVenders,'message'=>$message));
                   }
                }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }
	}
        
        //test
        public function actionFlaggedBanKeyword() 
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
                $start_date=strtoupper(date("d-M-Y"));
                $end_date=strtoupper(date("d-M-Y"));
		  $obj =new LeapDowntimeTrackerModel;	
                   if(isset($_REQUEST['search']))
                   {  
                      $offerArr=$obj->banned_count($_REQUEST);  
                  }elseif(isset($_REQUEST['detail'])){
                        $detail=$obj->banned_report($_REQUEST);  
                  }
                  else{
                       $this->render('/leapdowntimetracker/ldt_report_new',array('start_date'=>$start_date,'end_date'=>$end_date));
                   }
            }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }       
	}
}