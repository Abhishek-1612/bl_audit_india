<?php 
error_reporting(1);

class Pnscall_fallbackController extends Controller
{
    public $obj = '';
    public function init(){
        $this->obj=new pnscall_fallback();
    }
 public function actionIndex()
 {                                  
      if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Add'))
         {       
                echo $status=$this->obj->add_data($_REQUEST);
                die;
         }elseif((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Update'))
         {       echo $status=$this->obj->save_data($_REQUEST); 
                die;
         }elseif((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Delete'))
         {       echo $status=$this->obj->delete_data($_REQUEST); 
                die;
         }elseif((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Disable'))
         {       echo $status=$this->obj->disable_data($_REQUEST); 
                die;
         }elseif((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Enable'))
         {       echo $status=$this->obj->enable_data($_REQUEST); 
                die;
         }
        $emp_id =Yii::app()->session['empid'];    
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        if($emp_id)
        {
            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD']= '';
            }
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
            $user_edit =isset($user_permissions['TOEDIT']) ? $user_permissions['TOEDIT'] : '';
           $user_add = isset($user_permissions['TOADD']) ? $user_permissions['TOADD'] : '';

            if($user_view==1)
            {
              $resultArr_deleted=$resultArr='';$status='';
               $cookie_mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';  
                     if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Search'))
                     {
                       $resultArr=$this->obj->show_data('active');
                       $resultArr_deleted=$this->obj->show_data('deleted');
                     }
                 $this->render('add_edit_form', array("resultArr_deleted"=>$resultArr_deleted,"resultArr"=>$resultArr,"cookie_mid"=>$cookie_mid,"user_edit"=>$user_edit,"user_add"=>$user_add));
            }else
            {
              echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
            }
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
                $start_date=strtoupper(date("d-M-Y"));
		  $message='';
		  $obj =new pnscall_fallback;		
                   if(isset($_REQUEST['search']))
                   {        
                     $rtype=isset($_REQUEST['rtype'])?$_REQUEST['rtype']:''; 
                      if($rtype=='C'){ 
                        $data=$obj->report($_REQUEST);
                      }else{
                        $data=$obj->report_response($_REQUEST);                         
                      }                      
                      echo $data;die;                   
                  }else{
                       $this->render('report',array('start_date'=>$start_date,'message'=>$message));
                   }
                }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
                }
	}        
 }

?>