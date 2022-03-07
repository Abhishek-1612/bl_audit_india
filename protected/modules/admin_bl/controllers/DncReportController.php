<?php
class DncReportController extends Controller
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
				$obj=new DncReport();
				$rec=$obj->DNCform();
				$recData='';
				list($recData1,$recdata_isq)='';
				$first = new DateTime($start_date1);
				$second = new DateTime($end_date1);
				$interval = $second->diff($first);
				$interval=$interval->format('%a total days');
				if(!empty($submit) && $interval <=31)
				{
				  $recData=$obj->DNCData($request);
				}
				$this->render('dncreport',array('start_date'=>$start_date,'end_date'=>$end_date,'rec'=>$rec,'recData'=>$recData,'interval'=>$interval,'recData1'=>$recData1,'recdata_isq'=>$recdata_isq));
			}  
	   
			else
			{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
			}
		}
	}
 
public function actiondncdemand()
	{        
		$obj = new DncReport;
                $sth=$sth_expired='';$sth3='';$sth4=$sth5=$sth6=$sth7=$sth8=$sth9='';	
		list($sth,$sth_expired,$sth3,$sth4,$sth5,$sth6,$sth7,$sth8,$sth9)=$obj->ondemandDNC();
		
		$this->render('dncdemand',array(                                
                                'sth'=> $sth,
                                'sth_expired'=> $sth_expired,
                                'sth3'=>$sth3,'sth4'=>$sth4,
                                'request'=>$_REQUEST['req'],
                                'sth5'=>$sth5,
                                'sth6'=>$sth6,
                                'sth7'=>$sth7,
                                'sth8'=>$sth8,
                                'sth9'=>$sth9
                                ));
                                
	}	
	public function actionaovReport()
	{
            		echo 'This Report has been disabled. Please contact to GLADMIN Team';exit;

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
				$obj=new AovReport();
				$obj1=new DncReport();
				$rec=$obj1->DNCform();
				$recData = $result = '';
				list($recData1,$recdata_isq)='';
				$first = new DateTime($start_date1);
				$second = new DateTime($end_date1);
				$interval = $second->diff($first);
				$interval=$interval->format('%a total days');
				
				if(!empty($submit) && $interval <=31){
					$recData=$obj->AovData($request);
					$result=$obj->timeliness($request);
				}
			
				$this->render('aovreport',array('start_date'=>$start_date,'end_date'=>$end_date,'rec'=>$rec,'recData'=>$recData,'interval'=>$interval,'recData1'=>$recData1,'recdata_isq'=>$recdata_isq,'result'=>$result));
				
			}  	   
			else
			{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
			}
		}
	}
	
	public function actionaovOndemand()
	{
		$model = new GlobalmodelForm();
		$obj_conn = new Globalconnection(); 
		$obj=new AovReport();
		
        $dbh = $obj_conn->connect_db_yii('imblR');
		$result =array();
		
		$request = Yii::app()->request;
		$trend=$request->getParam('trend','');
		$start_date=$request->getParam('start_date','');
		$end_date=$request->getParam('end_date','');
		$flag=$request->getParam('flag','');
		$req=$request->getParam('req','');
		
		$datediff  = $end_date - $start_date;	
		$currentdate = strtoupper(date("d-M-Y"));

		if($currentdate == $end_date){
			$end_date = strtoupper(date('d-M-Y', strtotime('-1 day', strtotime($currentdate))));
		}

		$counter = ($trend == 'hourly') ? 23 : $datediff;
		if($counter > 0)
		{
			if($req == 1 || $req == 4){
				// $result = $obj->isqData($trend,$start_date,$end_date,$flag,$req,$dbh,$model);	
				$result = array("akshay","sethi");	
			}elseif($req == 2 || $req == 5){
				$result = $obj->indicatorsData($trend,$start_date,$end_date,$flag,$req,$dbh,$model);	
			}
			elseif($req == 3 || $req == 6){
				$result = $obj->quality($trend,$start_date,$end_date,$flag,$req,$dbh,$model);	
			}
			elseif($req == 7){
				$result = $obj->isqGiven($trend,$start_date,$end_date,$flag,$req,$dbh,$model);	
			}
			elseif($req == 8){
				$result = $obj->customISQ($trend,$start_date,$end_date,$flag,$req,$dbh,$model);
			}
			else{
				echo 'NO DATA FOUND';
				exit;
			}
			$this->render('aovdemand',array("result" => $result,"flag"=> $flag,"req"=> $req,"counter"=>$counter,"trend"=>$trend));
		}else{
			echo 'DATA NOT FOUND';
			exit;
		}	
	}
        
public function actionDailyreport()
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
				$obj=new DncdailyReport();
				$recData='';
				list($recData1,$recdata_isq)='';
				$first = new DateTime($start_date1);
				$second = new DateTime($end_date1);
				$interval = $second->diff($first);
				$interval=$interval->format('%a total days');
				if(!empty($submit) && $interval <=31)
				{
				  $recData=$obj->getData($request);
				}
				$this->render('dncdailyreport',array('start_date'=>$start_date,'end_date'=>$end_date,'recData'=>$recData,'interval'=>$interval,'recData1'=>$recData1,'recdata_isq'=>$recdata_isq));
			}  
	   
			else
			{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
			}
		}
	}
        public function actionTts()
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
                        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
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
				$obj=new DncReport();
				$recData='';
				list($recData1,$recdata_isq)='';
				$first = new DateTime($start_date1);
				$second = new DateTime($end_date1);
				$interval = $second->diff($first);
				$interval=$interval->format('%a total days');
				if(!empty($submit) && $interval <=31)
				{
				  $recData=$obj->TTSData($request);
				}else{
				$this->render('ttsreport',array('start_date'=>$start_date,'end_date'=>$end_date,'recData'=>$recData,'interval'=>$interval,'recData1'=>$recData1,'recdata_isq'=>$recdata_isq));
			        }
                                }  
	   
			else
			{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
			}
		}
	}
 
}