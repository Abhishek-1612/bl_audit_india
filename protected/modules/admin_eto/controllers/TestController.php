<?php 
error_reporting(1);

class TestController extends Controller
{
	
	public function actionPro(){
	    
            $res=array();
			$model = new GlobalmodelForm(); 
			$obj = new Globalconnection();
			$dbh = $obj->connect_approvalpg();
			  echo $emp=990001016;
                          $start_date='30-01-2021';
                          $end_date='01-02-2021';

			   echo $sql="SELECT
			   count(TASK_REF_ID) total_product
			   FROM Freelance_TASK_DETAILS  
			   WHERE
                date(task_completion_date)= date(now()) and task_status=2 and task_assignedto_empid = 990001016";

               // and task_assignedto_empid = 990001016 and task_status=2
                
			   $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
		         	   
				$res=$sth->readAll();
				
			    echo '<pre>view details'; var_dump($res);
			echo $sql="SELECT
			TO_CHAR(ENTERED_ON, 'DD-MON-YYYY') ENTERED_ON_CH,
			sum(total_tasks_closed) total_task
			FROM freelance_vendor_work_stats  
			WHERE FK_ETO_LEAP_EMP_ID = 990001016  
			AND DATE(ENTERED_ON) BETWEEN TO_DATE('$start_date', 'DD-MM-YYYY') AND TO_DATE('$end_date', 'DD-MM-YYYY')
			group BY FK_ETO_LEAP_EMP_ID,ENTERED_ON";

			 
			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
					 
			$res=$sth->readAll();
                        echo 'view details';var_dump($res); 

                        echo $sql="SELECT
			TO_CHAR(ENTERED_ON, 'DD-MON-YYYY') ENTERED_ON_CH,
			JOB_TYPE_NAME,
			total_tasks_closed,
			total_payout
			
			FROM freelance_vendor_work_stats,Freelance_JOB_TYPES
			WHERE FK_JOB_TYPE_ID=JOB_TYPE_ID
			and FK_ETO_LEAP_EMP_ID = 990001016  
			AND DATE(ENTERED_ON) BETWEEN TO_DATE('$start_date', 'DD-MM-YYYY') AND TO_DATE('$end_date', 'DD-MM-YYYY')
			--AND FK_JOB_TYPE_ID=1
			ORDER BY 1";

			 
			$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
					 
			 $res=$sth->readAll();
			 echo 'view details';var_dump($res); 
                          

			
        }	 
    
	
}
