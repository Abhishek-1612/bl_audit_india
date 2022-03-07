<?php
class Retail_markingController extends Controller
{
    public $obj = '';
    public function init(){
        $this->obj=new retail_marking();
    }
 public function actionIndex()
 {    
      if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Add'))
         {       
                echo $status=$this->obj->add_retail_data($_REQUEST);
                die;
         }elseif((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Update'))
         {       echo $status=$this->obj->save_retail_data($_REQUEST); 
                die;
         }
     
      
      $emp_id =Yii::app()->session['empid'];    
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        if(!$emp_id)
        {
            $hostname   = $_SERVER['SERVER_NAME'];
            print "Your are not logged in<BR> Click here to <A
            HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
        }
       
     else
     {
            
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
       $resultArr='';$status='';
        $glunitlistall=array();
        $mcatName=isset($_REQUEST['mcat_name']) ? $_REQUEST['mcat_name'] : '';
        $mcat_id=isset($_REQUEST['mcatid_sel']) ? $_REQUEST['mcatid_sel'] : '';
        $cookie_mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
       
         if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Search'))
         {       
                $resultArr=$this->obj->show_retail_data($mcat_id); 
         }
         $glunitlist=$this->obj->glunitlist($mcat_id);
         $glunitlistall=$this->obj->glunitlistall();
          $this->render('add_edit_form', array("glunitlist"=>$glunitlist,"glunitlistall"=>$glunitlistall,"mcat_id"=>$mcat_id,"resultArr"=>$resultArr,"cookie_mid"=>$cookie_mid,"user_edit"=>$user_edit,"user_add"=>$user_add,"mcatName"=>$mcatName));
        
   }    
   else
   {
     echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
   }
   }
 }

 }

?>