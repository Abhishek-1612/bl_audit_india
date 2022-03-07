<?php  
class AuditFreelanceController extends Controller
{
        public $redis;
	public function actionIndex() 
	{ 
        $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'] ;
        $model = new GlobalmodelForm();
        $user_permissions = $model->checklogin('', $mid, $emp_id);
        $user_view =1; isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        if ($user_view == 1) {
            $job_id       = isset($_REQUEST['job_id']) ? $_REQUEST['job_id'] : '';
            $job_type_id=isset($_REQUEST['job_type_id']) ? $_REQUEST['job_type_id'] : '';
            $objBLFreelanceModel = new BLFreelanceModel();
            $objAuditModel           = new AuditModel;
            $etoModel      = new AdminEtoForm();
            $errormessage=$message='';
            if ($job_id>0 && $job_type_id>0) {
                   if($job_type_id==9 || $job_type_id==11 || $job_type_id==10 || $job_type_id==12 || $job_type_id==13 || $job_type_id==14 ){
                       $quotacheck=$objBLFreelanceModel->check_audit_count($job_type_id,$emp_id);
                        if($quotacheck<>""){
                            echo $quotacheck;die;
                        }
                   }
                $arr_lvl_code  = $etoModel->getLeapEmpLVL($emp_id);
                $v_name        =  isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) ? $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] :'';
                  if($v_name == ''){
                    echo"Employee  $emp_id does not exist."; exit;
                  }

                // Approved BL 
                    $offerdetHTML  = '';
                    $offerArr      = $auditArr      = array();


                            $obj =new timermodelform();                                       //summer
                            $maxmintime=$obj->gettime($job_id);                  //summer
                            $maxlimit = $maxmintime[0]['job_type_max_duration_sec'];            //summer
                            $minlimit = $maxmintime[0]['job_type_min_duration_sec'];            //summer

                       if($job_type_id==9 || $job_type_id==10){
                            if (isset($_REQUEST['save']) || isset($_REQUEST['save_close'])) {
                                $offerID       = isset($_REQUEST['selofferID']) ? $_REQUEST['selofferID'] : '';
                                $errormessage = $objBLFreelanceModel->check_audit_offer_exist($offerID); 
                                if($errormessage==''){
                                $offerArr     = $objAuditModel->auditDetail('auditDetail', $offerID);     
                                $errormessage = $offerArr = $objBLFreelanceModel->save_audit_details_app($offerID, $auditArr,$offerArr,$arr_lvl_code);
                                if ($errormessage == '') {
                                     $errormessage = "Audit Record saved successfully for Offer-" . $offerID;  
                                } 
                                if(isset($_REQUEST['save_close'])){
                                                echo '<h1 align="center">THANK YOU</h1>'
                                    . '<div align="center"><span style="font-weight:bold;font-size:16px;">'
                                                . $errormessage.'</span></div><br/><br/><div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                                                . '<a href="/index.php?r=admin_eto/AuditFreelance/Index&mid='.$mid.'">Back to BL Audit Job Dashboard</a></div>';die;  
                                 }
                                }
                            }
                        $offerID =$objBLFreelanceModel->GetIdFromRedis($job_type_id);
                        $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($offerID, 'WIP',$job_id,'');
                        
                            $qtype         = 'ADV';
                            $offerArr     = $objAuditModel->auditDetail('', $offerID);
                            $associateID=$offerArr['ASSOC_NAME'];
                            $Assoc_name_arr=explode('(',$associateID);
                            $appempid=explode(")",$Assoc_name_arr[1]);
                            $appempid=$appempid[0];
                            if($appempid==$emp_id){
                            $offerID =$objBLFreelanceModel->GetIdFromRedis($job_type_id);
                            $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($offerID, 'WIP',$job_id,'');
                            }

                            $offerdetHTML = $objAuditModel->offerDetail($offerID);
                            //calling history of mapped mcat
                            $status       = isset($offerArr['TBL_STATUS'])?$offerArr['TBL_STATUS']:'';
                            $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerID, $status);   
                            $auditArr      = $objAuditModel->show_audit_question($qtype);
                            $auditors_name = Yii::app()->session['empname'];

                            $mid_for_timer = $mid;                                             //summer

                            $this->render('/audit/freelanceappaudit', array(
                                'offerdetHTML' => $offerdetHTML,
                                'offerArr' => $offerArr,
                                'auditArr' => $auditArr,
                                'offerID' => $offerID,
                                'auditors_name' => $auditors_name,
                                'message' => '',
                                'v_name' => $v_name,
                                'mappedMcat' =>$mappedMcat,  //passed mapped Mcat Array 
                            'job_id'=>$job_id,'job_type_id'=>$job_type_id,'message'=>$errormessage,
                            'maxtimelimit'=>$maxlimit,'mintimelimit'=>$minlimit,'mid_for_timer'=>$mid_for_timer
                            ));

                        }
                                         //Deleted BL Save
                        if($job_type_id==12 || $job_type_id==11){
                                $auditresult='';
                                if (isset($_REQUEST['save']) || isset($_REQUEST['save_close'])) {
                                       $message=$objBLFreelanceModel->save_audit_details_del(); 
                                        if(isset($_REQUEST['save_close'])){
                                                    echo '<h1 align="center">THANK YOU</h1>'
                                        . '<div align="center"><span style="font-weight:bold;font-size:16px;">'
                                                    . $message.'</span></div><br/><br/><div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                                                    . '<a href="/index.php?r=admin_eto/AuditFreelance/Index&mid='.$mid.'">Back to BL Audit Job Dashboard</a></div>';die;  
                                        }
                                    }
                                $offerIDs =$objBLFreelanceModel->GetIdFromRedis($job_type_id);//die;
                                $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($offerIDs, 'WIP',$job_id,'');   
                                 $dataArr=$objBLFreelanceModel->auditSample($offerIDs);

                                 $sampleresult=$objBLFreelanceModel->printsample($dataArr,$job_id,$job_type_id);//,$dataArr1);

                                 $mid_for_timer = $mid;                                             //summer
                                 $this->render('/audit/freelancedelaudit',array('job_id'=>$job_id,'job_type_id'=>$job_type_id,'sampleresult'=>$sampleresult,
                                    'auditresult'=>$auditresult,'message'=>$message,'maxtimelimit'=>$maxlimit,'mintimelimit'=>$minlimit,'mid_for_timer'=>$mid_for_timer));
                        }
                
                //Non BL
                if($job_type_id==13){
                    $score='';
                            $objNonBLAuditModel =new NonBLAuditModel();
                        if (isset($_REQUEST['save']) || isset($_REQUEST['save_close'])) {
                               $selcallrecordid=isset($_REQUEST['callrecordid']) ? $_REQUEST['callrecordid'] : ''; 
                               $errormessage = $objBLFreelanceModel->check_audit_offer_exist($selcallrecordid); 
                               if($errormessage==''){
                               $offerArr=$objNonBLAuditModel->callDetail($selcallrecordid);
                               $auditArr=$objAuditModel->show_audit_question('NONBL');
                               $arr_lvl_code['ETO_LEAP_VENDOR_NAME']=$_REQUEST['v_name'];
                               $offerArr['ASSOC_NAME']=$_REQUEST['assoc_name'];
                               $errorarr=$objBLFreelanceModel->save_audit_details(0,$auditArr,$selcallrecordid,$offerArr,$arr_lvl_code);
                               if($errorarr["errormessage"]==''){
                                   $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($selcallrecordid, 'CLOSE',$job_id,$errorarr["score"]);
                                   $errormessage="Audit Record saved successfully for Call Record Id-".$selcallrecordid;
                               }else{
                                   $errormessage="Some Error occuered for Call Record Id-".$selcallrecordid;                          
                               }
                                if(isset($_REQUEST['save_close'])){
                                            echo '<h1 align="center">THANK YOU</h1>'
                                . '<div align="center"><span style="font-weight:bold;font-size:16px;">'
                                            . $errormessage.'</span></div><br/><br/><div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                                            . '<a href="/index.php?r=admin_eto/AuditFreelance/Index&mid='.$mid.'">Back to BL Audit Job Dashboard</a></div>';die;  
                                 }
                            }
                        }
                            $callrecordid=$objBLFreelanceModel->GetIdFromRedis($job_type_id);
                            $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($callrecordid, 'WIP',$job_id,'');
                             $offerArr=$objNonBLAuditModel->callDetail($callrecordid); 
                             $auditArr=$objAuditModel->show_audit_question('NONBL');// echo '<pre>';print_r($offerArr);

                             $mid_for_timer = $mid;                                             //summer
                        

                             $this->render('/audit/freelancenonblform',array('job_id'=>$job_id,'job_type_id'=>$job_type_id,'offerArr'=>$offerArr,
                                 'auditArr'=>$auditArr,'callrecordid'=>$callrecordid,'v_name'=>$v_name,"message"=>$errormessage,'maxtimelimit'=>$maxlimit,'mintimelimit'=>$minlimit,'mid_for_timer'=>$mid_for_timer));
                           
                }
                //Review BL
                if($job_type_id==14){
                    if (isset($_REQUEST['save']) || isset($_REQUEST['save_close'])) {
                        $selofferID=isset($_REQUEST['selofferID']) ? $_REQUEST['selofferID'] : ''; 
                        $message = $objBLFreelanceModel->check_audit_offer_exist($selofferID); 
                        if($message==''){
                        $auditors_name=isset($_REQUEST['auditors_name']) ? $_REQUEST['auditors_name'] : ''; 
                        $offerArr=$objAuditModel->auditDetail(0,$selofferID);
                        $approved_by=isset($offerArr['ETO_LEAP_EMP_ID'])?$offerArr['ETO_LEAP_EMP_ID']:'';                        
                        $auditArr=$objAuditModel->show_audit_question('R');
                        $errorarr=$objBLFreelanceModel->save_audit_details(0,$auditArr,$selofferID,$offerArr,$arr_lvl_code);
                        if($errorarr["errormessage"]==''){
                            $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($selofferID, 'CLOSE',$job_id,$errorarr["score"]);
                            $message="Audit Record saved successfully for Offer-".$selofferID;
                        }else{
                            $message=$errormessage;
                        }
                        if(isset($_REQUEST['save_close'])){
                                            echo '<h1 align="center">THANK YOU</h1>'
                                . '<div align="center"><span style="font-weight:bold;font-size:16px;">'
                                            . $message.'</span></div><br/><br/><div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                                            . '<a href="/index.php?r=admin_eto/AuditFreelance/Index&mid='.$mid.'">Back to BL Audit Job Dashboard</a></div>';die;  
                     }
                    }
		   }
                    $offerID =$objBLFreelanceModel->GetIdFromRedis($job_type_id);
                    $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($offerID, 'WIP',$job_id,'');

                    $offerArr=$objAuditModel->auditDetail(0,$offerID); 
                     $approved_by=isset($offerArr['ETO_LEAP_EMP_ID'])?$offerArr['ETO_LEAP_EMP_ID']:'';
                    if(isset($offerArr['ETO_LEAP_VENDOR_NAME'])) {
                            $auditArr=$objAuditModel->show_audit_question('R');
                    }else{
                        $auditArr['errMsg']='You are not authorised to Audit this Buylead';
                    } 
                    $auditors_name=Yii::app()->session['empname'];


                    $mid_for_timer = $mid;                                             //summer

                    $this->render('/audit/reviewblform',array('job_id'=>$job_id,'job_type_id'=>$job_type_id,'offerArr'=>$offerArr,
                        'auditArr'=>$auditArr,'offerID'=>$offerID,'auditors_name'=>$auditors_name,'message'=>'','v_name'=>$v_name,
                        'message'=>$message,'maxtimelimit'=>$maxlimit,'mintimelimit'=>$minlimit,'mid_for_timer'=>$mid_for_timer));
            //Auto       
            }elseif($job_type_id==15 || $job_type_id==32 || $job_type_id==33){
                $errormessage='';

                        $auditArr      = $objAuditModel->show_audit_question('AUTO'); 
                        if (isset($_REQUEST['save']) || isset($_REQUEST['save_close'])) {
                            $offerID       = isset($_REQUEST['selofferID']) ? $_REQUEST['selofferID'] : '';   
                          //  $errormessage = $objBLFreelanceModel->check_audit_offer_exist($offerID); 
                          // if($errormessage==''){
                            $offerArr     = $objAuditModel->auditDetail('auditDetail', $offerID);   
                            $errorarr=$objBLFreelanceModel->save_audit_details(0,$auditArr,$offerID,$offerArr,$arr_lvl_code);
                            if ($errorarr["errormessage"] == '') {
                                 $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($offerID, 'CLOSE',$job_id,$errorarr["score"]);
                                 $errormessage = "Audit Record saved successfully for Offer-" . $offerID;  
                            } 
                            if(isset($_REQUEST['save_close'])){
                                            echo '<h1 align="center">THANK YOU</h1>'
                                . '<div align="center"><span style="font-weight:bold;font-size:16px;">'
                                            . $errormessage.'</span></div><br/><br/><div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                                            . '<a href="/index.php?r=admin_eto/AuditFreelance/Index&mid='.$mid.'">Back to BL Audit Job Dashboard</a></div>';die;  
                             }
                      //  }
                        }
                        $offerID =$objBLFreelanceModel->GetIdFromRedis($job_type_id);
                        $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($offerID, 'WIP',$job_id,'');

                        $offerArr     = $objAuditModel->auditDetail('', $offerID);
                        $approved_by=isset($offerArr['ETO_LEAP_EMP_ID'])?$offerArr['ETO_LEAP_EMP_ID']:'';
                        if($approved_by<>-14){
                            $offerID =$objBLFreelanceModel->GetIdFromRedis($job_type_id);
                            $statusupdate = $objBLFreelanceModel->ChangeTaskStatus($offerID, 'WIP',$job_id,'');
                        }

                        $offerdetHTML = $objAuditModel->offerDetail($offerID);
                        //calling history of mapped mcat
                        $status       = isset($offerArr['TBL_STATUS'])?$offerArr['TBL_STATUS']:'';
                        $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerID, $status);   
                        $auditors_name = Yii::app()->session['empname'];


                        
                    $mid_for_timer = $mid;                                              //summer
                        $this->render('/audit/freelanceautoauditform', array(
                            'offerdetHTML' => $offerdetHTML,
                            'offerArr' => $offerArr,
                            'auditArr' => $auditArr,
                            'offerID' => $offerID,
                            'auditors_name' => $auditors_name,
                            'message' => '',
                            'v_name' => $v_name,
                            'mappedMcat' =>$mappedMcat,  //passed mapped Mcat Array 
                            'job_id'=>$job_id,
                            'job_type_id'=>$job_type_id,
                            'message'=>$errormessage,'maxtimelimit'=>$maxlimit,'mintimelimit'=>$minlimit,'mid_for_timer'=>$mid_for_timer
                        ));  
            }            
            }
            else{
                $response = $objBLFreelanceModel->GetAllBLAuditJobs();
                $this->render('/audit/JobListview', array('response'=>$response));
            }
          
        } else {
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission of this Pick Job screen <b>";
        }
        
        }
   public function actionQueueData()
    {
        $this->redis = $this->connectRedis();
        $result = $this->redis->HGETALL('BLJOBTASKS');
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        
        // }else{
        //     echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission of this Hash Map  <b>";
        // }
        exit;
    }

    public function connectRedis()
    {
        $server = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
        $redis = '';
        try {
            $obj = new Globalconnection();
            $redis = $obj->GetRedisConn();
            return $redis;
        } catch (Exception $e) {
            echo "<div style='text-align: center; margin-top: 20%;'>
                        <hr>Redis Queue Error: Please Contact Gladmin
                        <hr></div>";

            $msg =  $e->getMessage();
            mail("laxmi@indiamart.com", "JOBTASKS - Couldn't connected to Redis ", $msg); 
            exit;
        }
    }

 public function actionUpdatetasktype()
    {
		$res = array();
		$model = new GlobalmodelForm();
		$obj = new Globalconnection();
		$dbh = $obj->connect_approvalpg();

		$sql = "SELECT * FROM Freelance_JOB_TYPES ";
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		$res = $sth->readAll();
       echo '<pre>'; print_r($res);

    }
public function actionMis()
{
        $empId = Yii::app()->session['empid']; 
        if($empId>0){
                $empName = Yii::app()->session['empname'];
                $model = new GlobalmodelForm();
                $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $seljob_type =isset($_REQUEST["seljob_type"]) ? $_REQUEST["seljob_type"] : '';
                $rtype =isset($_REQUEST["rtype"]) ? $_REQUEST["rtype"] : '';
                if($rtype=='freelancemgr'){
                    $start_date1 =isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
                    $end_date1 =isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';
                    $start_date = date("d-M-Y", strtotime($start_date1));  
                    $end_date = date("d-M-Y", strtotime($end_date1)); 
                    $first = new DateTime($start_date);
                    $second = new DateTime($end_date);
                    $interval = $second->diff($first);
                    $interval=$interval->format('%a total days');
                    if($interval>7){
                        echo 'Please select max 7 days date range';die;
                    }

                }else{
                  $end_date=  $start_date =isset($_REQUEST['seldate']) ? $_REQUEST['seldate'] : '';
                }

                if ($seljob_type == 9 || $seljob_type == 10) {
                        $objAuditModel =new AuditModel_v1;
                        $stype='';
                        $action="submit_dump";
                        $dataArr=$objAuditModel->auditForm_v1_Mis(0,$start_date,$end_date,$action,'','','','');                     
                        $this->renderPartial('/audit/agentauditmis',array('dataArr'=>$dataArr,'stype'=>$stype,'mid'=>$mid));
                              
              }elseif ($seljob_type == 11 || $seljob_type == 12) { //Deletion
                        $objAuditModel =new BulkAuditModel;
                        $stype='';
                        $action="submit_dump";
                        $dataArr=$objAuditModel->auditDump_mis(0,$start_date,$end_date,$action,'','','',0,'ALL');                    
                        $this->renderPartial('/audit/delmis',array('dataArr'=>$dataArr,'stype'=>$stype,'mid'=>$mid));
                }elseif ($seljob_type == 14) {                //Review BL 
                        $objAuditModel =new AuditModel;
                        $stype='R';
                        $action="submit_dump";
                        $dataArr=$objAuditModel->auditDump(0,$start_date,$end_date,$action,'','','',''); 
                        $this->renderPartial('/audit/agentauditmis',array('dataArr'=>$dataArr,'stype'=>$stype,'mid'=>$mid));
                }elseif ($seljob_type == 13) {                //Non BL
                        $objAuditModel =new AuditModel;
                        $stype='NONBL';
                       $action="submit_dump";
                       $dataArr=$objAuditModel->auditDump(0,$start_date,$end_date,$action,'','','',''); 
                        $this->renderPartial('/audit/agentauditmis',array('dataArr'=>$dataArr,'stype'=>$stype,'mid'=>$mid));
              }elseif ($seljob_type == 15) { //Auto
                        $objAuditModel=new AuditModel();
                        $action="submit_dump";
                        $stype='AUTO';
                        $dataArr=$objAuditModel->auditDump(0,$start_date,$end_date,$action,'','','','');                      
                        $this->renderPartial('/audit/agentauditmis',array('dataArr'=>$dataArr,'stype'=>$stype,'mid'=>$mid));
                }elseif ($seljob_type == 32) { //Auto
                        $objAuditModel=new AuditModel();
                        $action="submit_dump";
                        $stype='AUTO2';
                        $dataArr=$objAuditModel->auditDump(0,$start_date,$end_date,$action,'','','','');                      
                        $this->renderPartial('/audit/agentauditmis',array('dataArr'=>$dataArr,'stype'=>$stype,'mid'=>$mid));
                }elseif ($seljob_type == 33) { //Auto
                    $objAuditModel=new AuditModel();
                    $action="submit_dump";
                    $stype='AUTO3';
                    $dataArr=$objAuditModel->auditDump(0,$start_date,$end_date,$action,'','','','');                      
                    $this->renderPartial('/audit/agentauditmis',array('dataArr'=>$dataArr,'stype'=>$stype,'mid'=>$mid));
            }
    }else{
           echo "<b style='font-size:15px;color:red;padding-left:20px'>Please Login again <b>";exit;
    }
}

public function actionViewredisdata()
    {
        $conn = $this->connectRedis();
       $res=$conn->HGET('BLJOBTASKS','BLJOBTASKS11'); 
       echo 'job-11';
       echo $res;
//die;
    
        $res=$conn->HGET('BLJOBTASKS','BLJOBTASKS9'); 
        echo 'job-9';
        echo $res;
        
        $resarr=array();
        $count=0;
       if($res != "" ) 
       {
        $resarr=explode(",",$res);
        echo $count= count($resarr);
        }
       echo 'Count BLJOBTASKS9- '.$count.'====\n========='; 
       
        $res=$conn->HGET('BLJOBTASKS','BLJOBTASKS10');
        echo 'job-10';
         echo $res;
         $resarr=array();
        $count=0;
       if($res != "" ) 
       {
        $resarr=explode(",",$res);
        $count= count($resarr);
        }
       echo 'Count BLJOBTASKS10- '.$count.'====\n=========';
       
       
       $res=$conn->HGET('BLJOBTASKS','BLJOBTASKS11');
       echo 'job-11';
        echo $res;
$resarr=array();
        $count=0;
       if($res != "" ) 
       {
        $resarr=explode(",",$res);
        $count= count($resarr);
        }
       echo 'Count BLJOBTASKS11- '.$count.'====\n=========';
       
       
$res=$conn->HGET('BLJOBTASKS','BLJOBTASKS12'); 
echo 'job-12';
echo $res;
$resarr=array();
        $count=0;
       if($res != "" ) 
       {
        $resarr=explode(",",$res);
        $count= count($resarr);
        }
       echo 'Count BLJOBTASKS12- '.$count.'====\n=========';
		$res = array();
		$model = new GlobalmodelForm();
		$obj = new Globalconnection();
		$dbh = $obj->connect_approvalpg();

		$sql = "SELECT
			   task_assignedto_empid,fk_job_master_id,count(TASK_REF_ID) total_buylead 
			   FROM Freelance_TASK_DETAILS  
			   WHERE date(task_completion_date)= date(now()) and task_status=2 group by task_assignedto_empid,fk_job_master_id";


		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		$res = $sth->readAll();
           echo '<pre>';print_r($res);
           
           
           $res = array();
		$model = new GlobalmodelForm();
		$obj = new Globalconnection();
		$dbh = $obj->connect_approvalpg();

		$sql = "SELECT
			   *  
			   FROM Freelance_TASK_DETAILS  
			   WHERE fk_job_master_id=11155";


		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
		$res = $sth->readAll();
           echo 'data <pre>';print_r($res);
    }
}