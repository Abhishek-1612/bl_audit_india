<?php 
class LeapMLReportController extends Controller
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
                $user_view =isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : ''; 
                if($user_view==1){
		  $start_date=strtoupper(date("d-M-Y"));
		  $message='';
		  $obj =new LeapMLReportModel;		
                   if(isset($_REQUEST['search']))
                   {     
                            $data=$obj->blsearch_tov_report($_REQUEST); 
                            echo $data;die;  
                                                              
                  }else{
                       $this->render('/leapmlreport/blsearch',array('start_date'=>$start_date,'message'=>$message));
                   }
                }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }
	} 
        
    public function actionMcatreport() 
    {       
        $emp_id =   Yii::app()->session['empid'];
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
            $user_view =isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : ''; 
            if($user_view==1){
            $start_date=strtoupper(date("d-M-Y"));
              $message='';
              $obj =new LeapMLReportModel;		
               if(isset($_REQUEST['search']))
               {     
                       $data=$obj->mcatsearch_tov_report($_REQUEST); 
                        echo $data;die;  

              }elseif(isset($_REQUEST['showprice'])){
                $obj->callMcatPriceAPI($_REQUEST);
                die; 
              }elseif(isset($_REQUEST['showkpis']))
               {     
                       $data=$obj->showkpis($_REQUEST); 
                        echo $data;die;  

              }else{
                   $this->render('/leapmlreport/mcatsearch',array('start_date'=>$start_date,'message'=>$message));
               }
            }else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
            }
    } 
    public function actionSaveaudit(){
        {      
                $emp_id =     Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
               if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
                $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{  
                $obj =new LeapMLReportModel;
                echo $dataArr=$obj->save_audit_details();   
                exit;                   
	
        }else{
                     echo "You do not have permission";
                     exit;
                }
        }
    }
    
    public function actionshowretailidentification(){                   
            if(isset(Yii::app()->session['empid']))
                {
                $emp_id =     Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';

                 $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{  

                    if(isset($_REQUEST['offerid']) && is_numeric($_REQUEST['offerid']) && $_REQUEST['offerid']>0){
                        $obj =new LeapMLReportModel;
                        echo $fcpdetail = $obj->showretailidentification($_REQUEST['offerid']);
                        exit;
                    }
                }else{
                    echo "You do not have permission";
                     exit;
                }
                }else{
                    echo "You are not logged in";
                    exit;
            }
        }
    public function actionAuditmis() 
    {       
        $emp_id =    Yii::app()->session['empid'];
        
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

            $user_view =isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : ''; 
            if($user_view==1){
            $start_date=strtoupper(date("d-M-Y"));
              $message='';
              $obj =new LeapMLReportModel;		
               if(isset($_REQUEST['audit_usage']))
               {     
                       $data=$obj->usage_audit_report($_REQUEST); 

                        echo $data;die;  

              }    else if(isset($_REQUEST['audit_tov']))
              {     
                      $data=$obj->tov_audit_report($_REQUEST); 

                       echo $data;die;  

             } else if(isset($_REQUEST['audit_retail']))
             {     
                     $data=$obj->retail_audit_report($_REQUEST); 

                      echo $data;die;  

            }
              elseif(isset($_REQUEST['mcataudit'])){
                $obj->mcataudit_report($_REQUEST);
                die; 
              }elseif(isset($_REQUEST['detailed']))
               {     
                       $data=$obj->detailaudit_report($_REQUEST); 
                        echo $data;die;  

              }else{
                   $this->render('/leapmlreport/auditmis',array('start_date'=>$start_date,'message'=>$message));
               }
            }else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
            }
    } 
    
        
}
