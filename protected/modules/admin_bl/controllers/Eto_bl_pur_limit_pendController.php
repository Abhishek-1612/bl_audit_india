<?php 
class Eto_bl_pur_limit_pendController extends Controller
{
 public function actionIndex()
   {    
   $emp_id =Yii::app()->session['empid'];
    if(!$emp_id)
    {
            $hostname   = $_SERVER['SERVER_NAME'];
            print "Your are not logged in<BR> Click here to <A
            HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
    }else{
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
            
              $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = '';                
              }            
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
             if($user_view==1){       
                $fetch_cnt = isset($_REQUEST['flag']) ? $_REQUEST['flag'] : 0 ;   
               $obj=new Eto_bl_purchase_limit_pend;
               if(isset($_REQUEST['submit']))
                    {       
                               $obj_conn = new Globalconnection(); 		
                                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                                {
                                    $dbh = $obj_conn->connect_db_oci('postgress_web77v');   
                                }else{
                                    $dbh = $obj_conn->connect_db_oci('postgress_web68v'); 
                                }
                              $obj->showPendingLimitBLPurchase($dbh, '', $fetch_cnt);

                    }else{  
                     $obj->showPendingform();
                    }
               }else
                {
                  echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                }

           }
   }  
}

?>