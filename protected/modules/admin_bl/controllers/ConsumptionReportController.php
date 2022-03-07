<?php
class ConsumptionReportController extends Controller
{
public function actionblConsumptionReport()
{    $data=array();
    $emp_id =Yii::app()->session['empid'];
         $request = Yii::app()->request;        
        if(!$emp_id)
		{
                        $hostname   = $_SERVER['SERVER_NAME'];
			print "Your are not logged in<BR> Click here to <A
			HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}else            
                    {
                            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
                            $mid_list = Yii::app()->session['mid_list'];
                            $user_permissions = array();
                            if (!empty($mid_list)) {
                            foreach ($mid_list as $key => $val) {
                                if ($key == $mid)
                                { 
                                    $user_permissions = $val;             
                                }
                            }
                            if(empty($user_permissions))
                            { 
                                $user_permissions['TOVIEW'] = ''; 
                            }

                            }
                        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                        if($user_view==1){
                            if(@$_REQUEST['action'] == 'display'){
                                $Report=new Consumptionreport;
                                $request = Yii::app()->request;
                                $data = $Report->getBlConsumptionData($request);
                            }

                            $this->render('blconsumptiondefault',array('data'=>$data)); 
                        }else
                        {
                          echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        }
                    }
}
}
?>