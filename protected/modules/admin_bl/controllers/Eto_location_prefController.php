<?php
class Eto_location_prefController extends Controller
{

   public function actionIndex()
   { 
    $emp_id =Yii::app()->session['empid'];
    if(!$emp_id)
		{
                        $hostname=$_SERVER['SERVER_NAME'];
			print "Your are not logged in<BR> Click here to <A
			HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{
                 $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : ''; 
                 $mid_list = Yii::app()->session['mid_list'];
                        $user_permissions = array();
                        if (!empty($mid_list)) {
                           foreach ($mid_list as $key => $val) {
                               if ($key == $mid) {
                                   $user_permissions = $val;
                               }
                           }
                           if(empty($user_permissions)){
                               $user_permissions['TOVIEW'] = '';
                           }
                       }
                       
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                if($user_view==1){  
                    $obj1=new Eto_location_pref;
                        if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'glusr_wise_locpref_rpt')
                        {
                                $obj1->showLocationPrefrencesReport_Glusr_Wise('',$emp_id);

                        }
                        elseif(isset($_REQUEST['redirect']))
                        {
                                $obj1->showLocationPrefrencesReport_Glusr_Wise('',$emp_id);
                        }
                        elseif(isset($_REQUEST['nulllocpref']) && $_REQUEST['nulllocpref'] == '1')
                        {
                                $obj1->NullLocPref('',$emp_id);
                        }
                        else
                        {
                                $obj1->showLocationPrefrencesForm('',$emp_id);
                        }
                }else{
                     echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
            }
 
 }
 
 
}