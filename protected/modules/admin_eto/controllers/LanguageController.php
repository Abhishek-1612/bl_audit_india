<?php
class LanguageController extends Controller
{
    public $obj = '';       
    public $leapMisEmp = array();

    public function init(){
        $this->obj=new Langmodel();
        $this->leapMisEmp = array(71355,84844,84873,30314,61154,76028,65677,67422,71116,67572,60437,43894,62902,24766,61721,62129,56333,58511,56576,69053,58159,34058,21875,6251,46480,23015,49465,37686,35740,22288,32236,3664,40208,40207,40022,35422,3575,21870,33403,33402,37642,45528,48862,38628,40399,48880,75532,86777,23293);
    }
    
 public function actionIndex()
 {       
    $emp_id =Yii::app()->session['empid'];    

     if(!in_array($emp_id,$this->leapMisEmp)){
		echo "Permission Denied";die;
	    } else{
	
      if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Save'))
         {       
              echo $status=$this->obj->save_data($_REQUEST); 
                die;
         }
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
              $resultArr='';$status='';
               $cookie_mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';  
                     if((isset($_REQUEST['action']) && $_REQUEST['action']  == 'Search'))
                     {
                       $resultArr=$this->obj->show_data();
                     }
                 $this->render('languageview', array("resultArr"=>$resultArr,"cookie_mid"=>$cookie_mid));
            }else
            {
              echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
            }
        }
            }
 }
}

?>