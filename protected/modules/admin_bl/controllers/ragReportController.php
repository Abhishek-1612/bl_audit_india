<?php
class RagReportController extends Controller
{
	public function actionIndex()
	{
		$emp_id =Yii::app()->session['empid'];
		
		if(!$emp_id)
		{
				$hostname   = $_SERVER['SERVER_NAME'];
				print "Your are not logged in<BR> Click here to <A
				HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{
			$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
			$mid_list = Yii::app()->session['mid_list'];
			$user_permissions = array();
			if (!empty($mid_list)) 
			{
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
			
			if($user_view==1)
			{ 
				$request = Yii::app()->request;
				$currentDate = date("d-m-Y");
				$start_date=$start_date1= $request->getParam('start_date','');
				$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
				$end_date=$end_date1= $request->getParam('end_date','');
				$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
				$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
				$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
				$submit= $request->getParam('action','');
				$obj=new RagReport();
				$rec='';
				$recData='';
				list($recData1,$recdata_isq)='';
				$first = new DateTime($start_date1);
				$second = new DateTime($end_date1);
				$interval = $second->diff($first);
				$interval=$interval->format('%a total days');
				if(!empty($submit) && $interval <=31)
				{
				  $recData=$obj->RagData($request);//print_r($recData);//die;
				}
                                
				$this->render('ragreport',array('start_date'=>$start_date,'end_date'=>$end_date,'recData'=>$recData,'interval'=>$interval));
			}  
	   
			else
			{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
			}
		}
	}
 
	
}