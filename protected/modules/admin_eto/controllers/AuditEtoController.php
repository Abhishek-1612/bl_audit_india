<?php 
ini_set('memory_limit','-1');
class AuditEtoController extends Controller
{
	public function actionIndex() 
	{ 
		$emp_id = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $auditors_name='';
                if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
		  $offerArr=array();$auditArr=array(); 
                  $feedbackcount=array();
		  $obj =new AuditModel;
                  $etoModel =  new AdminEtoForm();
                  $vendorArr = array();
		  $offerID=isset($_REQUEST['offerID']) ? $_REQUEST['offerID'] : ''; 
		  $arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id); 
                  $v_name=isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])?$arr_lvl_code['ETO_LEAP_VENDOR_NAME']:'';
                 // if( $v_name == ''){
               //     echo"Employee  $emp_id does not exist."; exit;
              //  }
                  $stype=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
		   if(isset($_REQUEST['search']) || isset($_REQUEST['reaudit']))
                   {                    
                    $offerArr=$obj->auditDetail(0,$offerID); 
                     $approved_by=isset($offerArr['ETO_LEAP_EMP_ID'])?$offerArr['ETO_LEAP_EMP_ID']:'';
                        if($stype=='BAN'){
                            $qtype='BAN';
                        }elseif($approved_by==-11){
                            $qtype='R';
                        }else{
                            $qtype='D';
                        }
                    if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ((($approved_by ==-11) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'VKALPREVIEW')) || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN')){
                                if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN')){
                                    $feedbackcount=$obj->feedbackcount($offerID);
                                }
                                $auditArr=$obj->show_audit_question($qtype); 
                                $auditors_name=Yii::app()->session['empname'];
                    }elseif(!isset($_REQUEST['reaudit']) && isset($offerArr['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME']==$offerArr['ETO_LEAP_VENDOR_NAME'])) {
                            if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN')){
                                    $feedbackcount=$obj->feedbackcount($offerID);
                                }
                            $auditArr=$obj->show_audit_question($qtype);
                            $auditors_name=Yii::app()->session['empname'];
                    }else{
                        $auditArr['errMsg']='You are not authorised to Audit this Buylead';
                    } 
                    $this->render('/audit/auditscreen',array('offerArr'=>$offerArr,'auditArr'=>$auditArr,'offerID'=>$offerID,'auditors_name'=>$auditors_name,'message'=>'','v_name'=>$v_name,'feedbackcount'=>$feedbackcount,'vendorArr'=>$vendorArr));
                   }else if(isset($_REQUEST['save']))
                   {
                      	
                      $offerID=isset($_REQUEST['selofferID']) ? $_REQUEST['selofferID'] : ''; 
                      $auditors_name=isset($_REQUEST['auditors_name']) ? $_REQUEST['auditors_name'] : ''; 
                      $offerArr=$obj->auditDetail(0,$offerID);
                       $approved_by=isset($offerArr['ETO_LEAP_EMP_ID'])?$offerArr['ETO_LEAP_EMP_ID']:'';
                        if($stype=='BAN'){
                            $qtype='BAN';
                        }elseif($approved_by==-11){
                            $qtype='R';
                        }else{
                            $qtype='D';
                        }
                        $auditArr=$obj->show_audit_question($qtype);
		      $errormessage=$offerArr=$obj->save_audit_details(0,$auditArr,$offerID,$offerArr,$arr_lvl_code);
                      if($errormessage==''){
                          $message="Audit Record saved successfully for Offer-".$offerID;
                         $this->render('/audit/auditscreen',array('message'=>$message,'offerID'=>''));
                      }else{
                          $this->render('/audit/auditscreen',array('offerArr'=>$offerArr,'auditArr'=>$auditArr,'offerID'=>$offerID,'auditors_name'=>$auditors_name,"message"=>$errormessage,'v_name'=>$v_name));
                      }
		   }else{
                       $this->render('/audit/auditscreen',array('offerArr'=>$offerArr,'offerID'=>$offerID));
                   }
	}
        
        
        public function actionMis() 
	{
		$empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}
                
                $currentDate = date("d-m-Y");
                $request = Yii::app()->request;
                $start_date=$start_date1= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
		
		$end_date=$end_date1= $request->getParam('end_date','');
		$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
                $dataArr=array();
                
                $obj =new AuditModel;	
                $leapdashboardModel =  new LeapDashboardModel();
                $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
                $vendor_approve = !empty($request->getParam("vendor_approve")) ? $request->getParam("vendor_approve") : 'ALL';
                $vendor_audit = $request->getParam("vendor_audit");
                $auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
                $permision = $vendorRe['permision'];
                $vendorArr = $vendorRe['vendorArr'];
                $AssociateId='';
                $first = new DateTime($start_date1);
		$second = new DateTime($end_date1);
		$interval = $second->diff($first);
		$interval=$interval->format('%a total days');
                if($vendor_audit<>'ALL'){
                    $noofdays=7;
                }else{
                    $noofdays=2;
                }
                   if(isset($_REQUEST['export_dump']) && $interval <=$noofdays)
                   {
                       $action="exportEXL";
                       $dataArr=$obj->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId); 
                       exit;
                   }elseif(isset($_REQUEST['submit_dump']) && $interval <=$noofdays)
                   {
                       $action="submit_dump";
                       $dataArr=$obj->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId); 
                      
                   }
                    $this->render('/audit/auditscreen',array('dataArr'=>$dataArr,'start_date'=>$start_date,'end_date'=>$end_date,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_audit'=>$vendor_audit,'interval'=>$interval,'permision'=>$permision));
	}
        
        
      public function actionSampling() 
	{
		$empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $tljson='';
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}                
                $currentDate = date("d-m-Y");
                $request = Yii::app()->request;
                $start_date= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));		
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		
                $dataArr=array();
               
		  $obj =new AuditModel;	
                  $etoModel =  new AdminEtoForm();
                  $leapdashboardModel =  new LeapDashboardModel();
                  $vendorRe = $leapdashboardModel->getLeapVendor_list($request,$empId);
                  $allVenders=$leapdashboardModel->allvendernames();
                  $arr_lvl_code = $etoModel->getLeapEmpLVL($empId);
                 
                  $permision = $vendorRe['permision'];
		  $vendorArr = $vendorRe['vendorArr'];
                  $vendor_approval = $request->getParam("vendor_approval",'');
                  $bucket = $request->getParam("bucket",'ALL');
                  $mailoption=$request->getParam("mailoption",'Both');
                  $maxrecords= $request->getParam("maxrecords",10);
                  $tlid= $request->getParam("tlselect",0);
                  $agentid= $request->getParam("agentselect",0);
                  $stype=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
                   if(isset($_REQUEST['submit_send']))
                   {
                       $action="submit_send";
                       if($stype=='R'){
                          echo $dataArr=$obj->reviewauditSample($request,$action,$vendor_approval,$mailoption);
                       }elseif($stype=='DNC'){
                          echo $dataArr=$obj->dncflag_auditSample($request,$action,$vendor_approval,$mailoption);
                       }elseif($stype=='BAN'){                            
                          echo $dataArr=$obj->ban_auditSample($request,$action,$vendor_approval,$mailoption);
                       }else{
                         $dataArr=$obj->auditSample($empId,$start_date,$maxrecords,$vendor_approval,$tlid,$agentid,$bucket,$action,$vendorArr,$mailoption);
                         $obj->printsample($dataArr); 
                       }                         
                       exit;
                   }elseif(isset($_REQUEST['submit_view']))
                   {
                       $action="submit_view";
                        if($stype=='R'){                            
                          echo $dataArr=$obj->reviewauditSample($request,$action,$vendor_approval,$mailoption);
                        }elseif($stype=='DNC'){                            
                          echo $dataArr=$obj->dncflag_auditSample($request,$action,$vendor_approval,$mailoption);
                       }elseif($stype=='BAN'){                            
                          echo $dataArr=$obj->ban_auditSample($request,$action,$vendor_approval,$mailoption);
                       }else{
                         $dataArr=$obj->auditSample($empId,$start_date,$maxrecords,$vendor_approval,$tlid,$agentid,$bucket,$action,$vendorArr,$mailoption);   
                         
                         $obj->printsample($dataArr);
                       }
                       exit;
                   }else{
                        if(isset($_REQUEST['tabselect'])){
                           $this->render('/audit/auditscreen',array('allVenders'=>$allVenders,'dataArr'=>$dataArr,'start_date'=>$start_date,'vendorArr'=>$vendorArr,'vendor_approval'=>$vendor_approval,'tlid'=>$tlid,'agentid'=>$agentid,'bucket'=>$bucket,'maxrecords'=>$maxrecords,'mailoption'=>$mailoption,'tljson'=>$tljson,'arr_lvl_code'=>$arr_lvl_code));
                        }else{
                          $this->render('/audit/sampling',array('allVenders'=>$allVenders,'dataArr'=>$dataArr,'start_date'=>$start_date,'vendorArr'=>$vendorArr,'vendor_approval'=>$vendor_approval,'tlid'=>$tlid,'agentid'=>$agentid,'bucket'=>$bucket,'maxrecords'=>$maxrecords,'mailoption'=>$mailoption,'tljson'=>$tljson,'arr_lvl_code'=>$arr_lvl_code));
                        }
                   }                   
	}  
	
	public function actionAuditedit() 
	{
	$start_date=isset($_REQUEST['sd']) ? $_REQUEST['sd'] : '';
	$end_date=isset($_REQUEST['ed']) ? $_REQUEST['ed'] : '';
	$vendor_approve=isset($_REQUEST['ven_app']) ? $_REQUEST['ven_app'] : '';
	$vendor_audit=isset($_REQUEST['ven_audit']) ? $_REQUEST['ven_audit'] : '';
	$offerID=isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
	$auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
	$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
        $qtype=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : 'D';
        if($auditId < 79794){
            $qtype='D';
        }
        if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
	$message='';
	$action='';
	$auditors_name='';
        $obj =new AuditModel;	   
        $etoModel =  new AdminEtoForm();
                    $arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id);
                    $v_name=isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])?$arr_lvl_code['ETO_LEAP_VENDOR_NAME']:'';

                        $offerArr=$obj->auditDetail(0,$offerID);                    
                    
                    if($v_name == 'NOIDA' || $v_name== 'DDN'){
                        $auditArr=$obj->show_audit_question($qtype);       
                        $auditors_name=Yii::app()->session['empname'];
                    }elseif(isset($offerArr['ETO_LEAP_VENDOR_NAME']) && ($v_name==$offerArr['ETO_LEAP_VENDOR_NAME'])) {
                        $auditArr=$obj->show_audit_question($qtype);
                        $auditors_name=Yii::app()->session['empname'];
                    }else{
                        $auditArr['errMsg']='You are not authorised to Re-audit this Buylead';
                    }
                    if(isset($_REQUEST['save']) && isset($auditArr['quesArr']))
                    {
                      $message=$obj->save_audit_edit_details(0,$auditArr,$offerID,$auditId,$offerArr);                      
                    }
                     $AssociateId='';
                     $dataArr=$obj->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId);   
                      $this->render('/audit/auditscreenedit',array('offerArr'=>$offerArr,'auditArr'=>$auditArr,'offerID'=>$offerID,'auditors_name'=>$auditors_name,'message'=>$message,'dataArr'=>$dataArr,'auditId'=>$auditId,'vendor_audit'=>$vendor_audit,'vendor_approve'=>$vendor_approve,'start_date'=>$start_date,'end_date'=>$end_date));
	
	}
	
	public function actionAuditcheck() 
	{
                    $obj =new AuditModel;
                    $etoModel =  new AdminEtoForm();
                    $emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
                    if(!$emp_id){
                      echo 'Please login again';
                      exit;
                    }
                    $arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id);
                    $offer_id=$_REQUEST['offerID'];                    
                    $vendor_check='';
                    if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])){
                        $vendor_check=$arr_lvl_code['ETO_LEAP_VENDOR_NAME'];
                    }
                    
                    $response=$obj->check_audit_offer($offer_id,$vendor_check);                   
                    $this->renderPartial('/audit/checkaudit', array('response'=>$response));
	}
	
	public function actionReports() 
	{     
	        
	        $start_date1= isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
		$end_date1= isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : '';
		$tabselect=isset($_REQUEST['tabselect']) ? $_REQUEST['tabselect'] : '';
                $trend=isset($_REQUEST['trend']) ? $_REQUEST['trend'] : '';
		$first = new DateTime($start_date1);
		$second = new DateTime($end_date1);
		$interval = $second->diff($first);
		$interval=$interval->format('%a total days');
	        $empId = Yii::app()->session['empid'];
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}
	        $obj =new AuditModel;
                $leapdashboardModel =  new LeapDashboardModel();
	        $request = Yii::app()->request;
	        $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
	        $currentDate = date("d-m-Y");
                $start_date= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
		$vendorArr = $vendorRe['vendorArr'];
		$end_date= $request->getParam('end_date','');
		$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
		$vendor_approve =!empty($request->getParam("vendor_approve")) ? $request->getParam("vendor_approve") : 'ALL';
                $vendor_audit = $request->getParam("vendor_audit");
                $dataArr=array();
                $action='';
                $auditId='';
                $rec2='';
                $rec3='';
                $rec4='';
                $rec5='';
                $AssociateId='';
                
                if(isset($_REQUEST['submit_dump']) && $interval <=7 && $trend=='daily')
                   {
                     $dataArr=$obj->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId);
                     list($rec2,$rec3,$rec4,$rec5)=$obj->Reports(0,$start_date,$end_date,$vendor_approve,$vendor_audit);
                   }
                   elseif($tabselect==5 && $trend=='monthly' && $interval <=7)
                   {
                   $dataArr=$obj->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId);
                   list($rec2,$rec3,$rec4,$rec5)=$obj->Reports(0,$start_date,$end_date,$vendor_approve,$vendor_audit);
                   }
                   elseif(isset($_REQUEST['submit_dump']) && $trend=='tni' && $interval <=7)
                   {
                      $dataArr=$obj->TNI_Identifier(0,$start_date,$end_date,$vendor_approve,$vendor_audit);                     
                   }
                   
                   
	        $this->render('/audit/auditscreen',array('start_date'=>$start_date,'end_date'=>$end_date,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_audit'=>$vendor_audit,'dataArr'=>$dataArr,'rec2'=>$rec2,'rec3'=>$rec3,'rec4'=>$rec4,'rec5'=>$rec5,'interval'=>$interval));
	     
	}
	
	public function actionRebuttal() 
	{
	  $empId = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
            if(!$empId){
              echo 'Please login again';
              exit;
            }
	  $request = Yii::app()->request;
	  $auditId=isset($_REQUEST['audit_id1']) ? $_REQUEST['audit_id1'] : ''; 
	  $OfferId=isset($_REQUEST['offer_id1']) ? $_REQUEST['offer_id1'] : '';
	  $status=isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
	  $div_id=isset($_REQUEST['div_id']) ? $_REQUEST['div_id'] : '';
	  $remarks=isset($_REQUEST['remarks']) ? $_REQUEST['remarks'] : '';
	 
	  $obj =new AuditModel;
          $etoModel =  new AdminEtoForm();
	  $auditArr=array();
	  $auditArr['errMsg']='You are not authorised to Raise the Rebuttal';
	  if(empty($remarks))
	  {
	  $arr_lvl_code = $etoModel->getLeapEmpLVL($empId); 
	  $offerArr=$obj->auditDetail(0,$OfferId);  
	  $approved_by=isset($offerArr['ETO_LEAP_EMP_ID'])?$offerArr['ETO_LEAP_EMP_ID']:'';
          
	  if((isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN')) || ($arr_lvl_code['ETO_LEAP_VENDOR_NAME']==$offerArr['ETO_LEAP_VENDOR_NAME']) ||  ($arr_lvl_code['ETO_LEAP_VENDOR_NAME']== 'VKALPREVIEW' && $approved_by==-11))
	  {
	 
	    $auditArr['errMsg']='';
	  }
	    else
	    {
	      $auditArr['errMsg']='You are not authorised to Raise the Rebuttal';
	    }
	  }
	  else
	  {
	  if(empty($status))
	  {
	   $obj->RaiseRebuttal(0,$auditId,$OfferId,$remarks,$div_id);
	  }
	  else
	  {
	   $obj->UpdateRebuttal(0,$auditId,$OfferId,$remarks,$div_id,$status);
	  }
	  }
	  $this->render('/audit/rebuttalscreen',array('auditId'=>$auditId,'OfferId'=>$OfferId,'auditArr'=>$auditArr,'div_id'=>$div_id));
	
	}
	
   public function actionRebuttalMis()
   {
                $request = Yii::app()->request;
                $currentDate = date("d-m-Y");
                $start_date= $request->getParam('start_date','');
                $is_archive=$request->getParam('is_archive','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
		$end_date= $request->getParam('end_date','');
		$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
		$status=isset($_REQUEST['status']) ? $_REQUEST['status'] : '';
		$empId = Yii::app()->session['empid'];
                if(!$empId)
		{
			echo "You are not logged in";
                        exit;
		}
                $obj =new AuditModel;
                $leapdashboardModel =  new LeapDashboardModel();
		$vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
                $vendor_approve = !empty($request->getParam("vendor_approve")) ? $request->getParam("vendor_approve") : 'ALL';
                $vendor_raised = $request->getParam("vendor_rebuttal");
                $auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
		$permision = $vendorRe['permision'];
		$vendorArr = $vendorRe['vendorArr'];
		$rec1='';
		$action='';
		if(isset($_REQUEST['export_dump']))
                   {
                       $action="exportEXL";
                       $dataArr=$obj->RebuttalMis(0,$start_date,$end_date,$status,$action,$vendor_approve,$vendor_raised,$is_archive); 
                       
                       exit;
                   }
		if(isset($_REQUEST['submit_dump']))
                   {
                       $action="submit_dump";
                       $rec1=$obj->RebuttalMis(0,$start_date,$end_date,$status,$action,$vendor_approve,$vendor_raised,$is_archive); 
                   }
                  if(isset($_REQUEST['submit_summary']))
                   {
                       $action="submit_dump";
                       $rec1=$obj->RebuttalSummary(0,$start_date,$end_date,$status,$action,$vendor_approve,$vendor_raised,$is_archive); 
                   }

     if(isset($_REQUEST['tabselect'])){
        $this->render('/audit/auditscreen',array('start_date'=>$start_date,'end_date'=>$end_date,'rec1'=>$rec1,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_raised'=>$vendor_raised));
     }else{
        $this->render('/audit/rebuttalmis',array('start_date'=>$start_date,'end_date'=>$end_date,'rec1'=>$rec1,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_raised'=>$vendor_raised));
     }
   }

    
   public function actionTLlist()
    {
            $glmodel = new GlobalmodelForm();
            $obj_audit =new AuditModel;
            $vendor_name=isset($_REQUEST['audit_id1']) ? $_REQUEST['audit_id1'] : ''; 
            if($vendor_name<>''){
            $obj_audit->getTLList(0,$vendor_name);
            }
            exit;
    }  
   public function actionAgentlist()
    {
            $glmodel = new GlobalmodelForm();
            $obj_audit =new AuditModel;
            $tlid=isset($_REQUEST['tl_id']) ? $_REQUEST['tl_id'] : '';
            if($tlid>0){
            $obj_audit->getAgentlist(0,$tlid);
            }
            exit;
    }
    
    public function actionNewfilter()
    {
      $vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';
      $leader=isset($_REQUEST['leader']) ? $_REQUEST['leader'] : '';
      $qa=isset($_REQUEST['qa']) ? $_REQUEST['qa'] : '';
      $agent=isset($_REQUEST['agent']) ? $_REQUEST['agent'] : '';
       $obj_audit =new AuditModel;
       $obj_audit->Newfilter(0,$vendor,$leader,$qa,$agent);
      exit;
      
    }
    public function actionTestpg()
    {
         $model = new GlobalmodelForm();
         $obj = new Globalconnection();
         $sql="SELECT * FROM bl_audit_response where fk_eto_ofr_display_id= 56510980459 ";
        // $sql="SELECT * FROM BL_AUDIT_RESPONSE a, BL_AUDIT_RESPONSE_DETAIL b "
         //        . "WHERE a.BL_AUDIT_RESPONSE_ID=b.FK_BL_AUDIT_RESPONSE_ID and b.FK_BL_AUDIT_RESPONSE_ID=977653";
           $dbh_pg = $obj->connect_db_yii('postgress_web68v');
           if($dbh_pg){
               echo 'connected';
           }
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());     
            while($rec = $sth->read()) {
               $rec1=array_change_key_case($rec, CASE_UPPER);   
               echo '<pre>'; print_r($rec1);echo '</pre>';
            }die;
            }
   
public function actionBanAudit() 
{ 
		$emp_id = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                $auditors_name='';
                if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
		  $offerArr=array();$auditArr=array(); 
                  $feedbackcount=array();
		  $obj =new AuditModel;
                  $etoModel =  new AdminEtoForm();
		  $offerID=isset($_REQUEST['offerID']) ? $_REQUEST['offerID'] : ''; 
                  if($offerID>0){
		  $arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id); 
                  $v_name= isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) ? $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] :'';
                  $response=$obj->check_audit_offer($offerID,$v_name); 
                  $temo1=explode("#",$response);   
                  $temo=str_replace('NA','',$temo1[1]);
                  $patt = '/DDN|NOIDA/';
                  if($temo<>""){
                    if(preg_match($patt,$temo)){
                        $res = str_replace("DDN-", "",$temo);
                        $res1 =str_replace("NOIDA-", "",$res);
                        $this->renderPartial('/audit/checkaudit', array('response'=>$res1)); 
                    }else{
                        $this->renderPartial('/audit/checkaudit', array('response'=>$temo)); 
                        exit;
                    }                    
                  }
                  $offerArr=$obj->auditDetail(0,$offerID); 
                 $qtype='BAN';                        
                if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN') || ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COMPETENT')){
                            $auditArr=$obj->show_audit_question($qtype); 
                            $auditors_name=Yii::app()->session['empname'];
                 }else{
                    $auditArr['errMsg']='You are not authorised to Audit this Buylead';
                } 
                $this->render('/audit/auditscreen',array('offerArr'=>$offerArr,'auditArr'=>$auditArr,'offerID'=>$offerID,'auditors_name'=>$auditors_name,'message'=>'','v_name'=>$v_name,'feedbackcount'=>$feedbackcount));
    } 
}

public function actionAuditForm()
    {
        // echo $optionvalues;
        $empId        = Yii::app()->session['empid'];
        $mid           = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $auditors_name = '';
        if (!$empId) {
            print "You are not logged in";
            exit;
        }
        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
        if(empty($user_permissions))
        {
        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
        }

        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
        if($user_view ==1)
        {
        $offerdetHTML  = '';
        $offerArr      = array();
        $auditArr      = array();
        $obj           = new AuditModel;
        $etoModel      = new AdminEtoForm();
        $offerID       = isset($_REQUEST['offerID']) ? $_REQUEST['offerID'] : '';
        $arr_lvl_code  = $etoModel->getLeapEmpLVL($empId);
        $v_name        =  isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) ? $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] :'';
        $qtype         = 'ADV';
        
        
        if (isset($_REQUEST['search']) || isset($_REQUEST['reaudit'])) {
            $offerArr     = $obj->auditDetail('', $offerID);
            $offerdetHTML = $obj->offerDetail($offerID);
            //calling history of mapped mcat
            $status       = isset($offerArr['TBL_STATUS'])?$offerArr['TBL_STATUS']:'';
            $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerID, $status);   
            $auditArr      = $obj->show_audit_question($qtype);
            $auditors_name = Yii::app()->session['empname'];
            
            $this->render('/audit/auditscreen_v1', array(
                'offerdetHTML' => $offerdetHTML,
                'offerArr' => $offerArr,
                'auditArr' => $auditArr,
                'offerID' => $offerID,
                'auditors_name' => $auditors_name,
                'message' => '',
                'v_name' => $v_name,
                'mappedMcat' =>$mappedMcat  //passed mapped Mcat Array 
            ));
            
         } else if (isset($_REQUEST['save'])) {
            $offerID       = isset($_REQUEST['selofferID']) ? $_REQUEST['selofferID'] : '';   
            $offerArr     = $obj->auditDetail('', $offerID);     
            $errormessage = $offerArr = $obj->save_audit_details_v1($offerID, $auditArr,$offerArr,$arr_lvl_code);
            if ($errormessage == '') {
                echo $message = "Audit Record saved successfully for Offer-" . $offerID;                
            } else {
                echo $errormessage;
            }
            die;
        } else {
            $this->render('/audit/auditscreen_v1', array(
                'offerArr' => $offerArr,
                'offerID' => $offerID
            ));
        }
    }else{
                 echo "You do not have permission";
                 exit;
            }
    }        
    
 public function actionSearchmcat()
    {
        $obj = new AuditModel;
        $obj->getsuggestedmcat();        
        exit();
        
    }


    public function actionAuditForm_v1_Mis() 
	{
		$empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                
        if(!$empId){
			print "You are not logged in";
            exit;
        }
		$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
        if(empty($user_permissions)){
            $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
        }
        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
        if($user_view ==1)
        {  
            $currentDate = date("d-m-Y");
            $request = Yii::app()->request;
            $start_date=$start_date1= $request->getParam('start_date','');
            $start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));
            $end_date=$end_date1= $request->getParam('end_date','');
            $end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
            $start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
            $end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
            $dataArr=array();
            $obj =new AuditModel_v1;	
            $leapdashboardModel =  new LeapDashboardModel();
            $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
            $bucket = $request->getParam("bucket",'ALL');
            $mailoption=$request->getParam("mailoption",'Both');
            $vendor_approve = !empty($request->getParam("vendor_approve")) ? $request->getParam("vendor_approve") : 'ALL';
            $vendor_audit = $request->getParam("vendor_audit");
            $auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
            $permision = $vendorRe['permision'];
            $vendorArr = $vendorRe['vendorArr'];
            $maxrecords= $request->getParam("maxrecords",10);
            $AssociateId='';
            $first = new DateTime($start_date1);
            $second = new DateTime($end_date1);
            $interval = $second->diff($first);
            $interval=$interval->format('%a total days');
            if($vendor_audit<>'ALL'){
                $noofdays=7;
            }else{
                $noofdays=2;
            }
            $stype=isset($_REQUEST['stype']) ? $_REQUEST['stype'] : '';
            if($stype=='AUTO'){
                $objAuditModel=new AuditModel();
                if(isset($_REQUEST['export_dump']) && $interval <=$noofdays)
                   {
                       $action="exportEXL";
                       $dataArr=$objAuditModel->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId); 
                       exit;
                   }elseif(isset($_REQUEST['submit_dump']) && $interval <=$noofdays)
                   {
                       $action="submit_dump";
                       $dataArr=$objAuditModel->auditDump(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId);                      
                   }
               $this->render('/audit/auditscreen_v1_mis',array('dataArr'=>$dataArr,'start_date'=>$start_date,'end_date'=>$end_date,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_audit'=>$vendor_audit,'interval'=>$interval,'permision'=>$permision,'bucket'=>$bucket,'mailoption'=>$mailoption,'maxrecords'=>$maxrecords));

            }else{
                if(isset($_REQUEST['export_dump']) && $interval <=$noofdays)
                {
                    $action="exportEXL";
                    $dataArr=$obj->auditForm_v1_Mis(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId); 
                    exit;
                }elseif(isset($_REQUEST['submit_dump']) && $interval <=$noofdays)
                {
                    $action="submit_dump";
                    $dataArr=$obj->auditForm_v1_Mis(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId);                     
                }
                $this->render('/audit/auditscreen_v1_mis',array('dataArr'=>$dataArr,'start_date'=>$start_date,'end_date'=>$end_date,'vendorArr'=>$vendorArr,'vendor_approve'=>$vendor_approve,'vendor_audit'=>$vendor_audit,'interval'=>$interval,'permision'=>$permision,'bucket'=>$bucket,'mailoption'=>$mailoption,'maxrecords'=>$maxrecords));
            }   
        }else
        {
            echo "You do not have permission";
            exit;

        }
    }
    
    public function actionAuditedit_v1() 
	{ 
    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : ''; 
	$start_date=isset($_REQUEST['sd']) ? $_REQUEST['sd'] : '';
	$end_date=isset($_REQUEST['ed']) ? $_REQUEST['ed'] : '';
	$vendor_approve=isset($_REQUEST['ven_app']) ? $_REQUEST['ven_app'] : '';
	$vendor_audit=isset($_REQUEST['ven_audit']) ? $_REQUEST['ven_audit'] : '';
	$offerID=isset($_REQUEST['offer_id']) ? $_REQUEST['offer_id'] : '';
	$auditId=isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
	$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
    $qtype         = 'ADV';
        if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
        }
    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
    if(empty($user_permissions)){
        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
    }
    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
    if($user_view ==1)
    {
        $action='';
        $auditors_name='';
        $obj =new AuditModel;	
        $obj1 =new AuditModel_v1;	
        $etoModel =  new AdminEtoForm();
        $arr_lvl_code = $etoModel->getLeapEmpLVL($emp_id); 
        $offerArr=$obj->auditDetail(0,$offerID);      
              
        if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN')){
            $auditArr=$obj->show_audit_question($qtype);  
            $auditors_name=Yii::app()->session['empname'];
        }elseif(isset($offerArr['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME']==$offerArr['ETO_LEAP_VENDOR_NAME'])) {
            $auditArr=$obj->show_audit_question($qtype);
            $auditors_name=Yii::app()->session['empname'];
        }else{
            $auditArr['errMsg']='You are not authorised to Re-audit this Buylead';
        }
        if(isset($_REQUEST['save']) && isset($auditArr['quesArr']))
        {
            $message=$obj->save_audit_edit_details(0,$auditArr,$offerID,$auditId,$offerArr);                      
        }
        $AssociateId='';
        $dataArr=$obj1->auditDump_v1(0,$start_date,$end_date,$action,$vendor_approve,$vendor_audit,$auditId,$AssociateId);   

        $this->render('/audit/auditscreen_v1_edit', array(
            'dataArr' => $dataArr,
            'offerArr' => $offerArr,
            'auditArr' => $auditArr,
            'offerID' => $offerID,
            'auditors_name' => $auditors_name,
            'message' => '',
            'v_name' => '',
            'mappedMcat' =>''  //passed mapped Mcat Array 
        ));        
    }
    else
    {
        echo "You do not have permission";
        exit;

    }
}
public function actionAuditForm_edit()
    {
        // // echo $optionvalues;
        // echo"<pre>";
        // print_r($_REQUEST);
        $empId        = Yii::app()->session['empid'];
        $mid           = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $auditors_name = '';
        if (!$empId) {
            print "You are not logged in";
            exit;
        }
        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
        if(empty($user_permissions))
        {
        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
        }

        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
        if($user_view ==1)
        {
        $offerdetHTML  = '';
        $offerArr      = array();
        $auditArr      = array();
        $obj           = new AuditModel;
        $etoModel      = new AdminEtoForm();
        $offerID       = isset($_REQUEST['offerID']) ? $_REQUEST['offerID'] : '';
        $audit_id       = isset($_REQUEST['audit_id']) ? $_REQUEST['audit_id'] : '';
        $arr_lvl_code  = $etoModel->getLeapEmpLVL($empId);
        $v_name        = isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) ? $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] :'';
        $qtype         = 'ADV';
        
        
        if (isset($_REQUEST['search']) || isset($_REQUEST['reaudit'])) {
            $offerArr     = $obj->auditDetail('', $offerID);
            $offerdetHTML = $obj->offerDetail($offerID);
            //calling history of mapped mcat
            $status       = isset($offerArr['TBL_STATUS'])?$offerArr['TBL_STATUS']:'';
            $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerID, $status);   
            $auditArr      = $obj->show_audit_question($qtype);
            $auditors_name = Yii::app()->session['empname'];
            
            $this->render('/audit/auditscreen_v1', array(
                'offerdetHTML' => $offerdetHTML,
                'offerArr' => $offerArr,
                'auditArr' => $auditArr,
                'offerID' => $offerID,
                'auditors_name' => $auditors_name,
                'message' => '',
                'audit_id'=>$audit_id,
                'v_name' => $v_name,
                'mappedMcat' =>$mappedMcat  //passed mapped Mcat Array 
            ));
            
         } else if (isset($_REQUEST['save'])) {

            $offerID = isset($_REQUEST['selofferID']) ? $_REQUEST['selofferID'] : '';     
            $offerArr     = $obj->auditDetail('', $offerID);       
            $errormessage =  $obj->save_audit_edit_v1($offerID, $auditArr, $audit_id , $offerArr);
            if ($errormessage == '') {
                echo $message = "Audit Record saved successfully for Offer-" . $offerID;                
            } else {
                echo $errormessage;
            }
            die;
        } else {
            $this->render('/audit/auditscreen_v1', array(
                'offerArr' => $offerArr,
                'offerID' => $offerID
            ));
        }
    }else{
                 echo "You do not have permission";
                 exit;
            }
    } 
    
    public function actionGuidelines() 
	{ 
		$emp_id = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                if(!$emp_id)
		{
			print "You are not logged in";
                        exit;
		}
     if(isset($_REQUEST['tabselect'])){
        $this->render('/audit/auditscreen',array());
     }else{
        $this->render('/audit/guidelines',array());
     }
}

public function actionAutoAudit() 
{ 
		
        // echo $optionvalues;
        $empId        = Yii::app()->session['empid'];
        $mid           = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $auditors_name = '';
        if (!$empId) {
            print "You are not logged in";
            exit;
        }
        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
        if(empty($user_permissions))
        {
        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
        }

        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
        if($user_view ==1)
        {
        $offerdetHTML  = '';
        $offerArr      = array();
        $auditArr      = array();
        $obj           = new AuditModel;
        $etoModel      = new AdminEtoForm();
        $offerID       = isset($_REQUEST['offerID']) ? $_REQUEST['offerID'] : '';
        $arr_lvl_code  = $etoModel->getLeapEmpLVL($empId);
        $v_name        =  isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) ? $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] :'';       
        
        if (isset($_REQUEST['search']) || isset($_REQUEST['reaudit'])) {
            $offerArr     = $obj->auditDetail('', $offerID);
            $approved_by=isset($offerArr['ETO_LEAP_EMP_ID'])?$offerArr['ETO_LEAP_EMP_ID']:'';
            if($approved_by<>-14){
                 echo 'Incorrect Offer ID. Please select any Fully Auto Approved Offer ID';exit;
             }

            $offerdetHTML = $obj->offerDetail($offerID);
            //calling history of mapped mcat
            $status       = isset($offerArr['TBL_STATUS'])?$offerArr['TBL_STATUS']:'';
            $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerID, $status);   
            $auditArr      = $obj->show_audit_question('AUTO');
            $auditors_name = Yii::app()->session['empname'];
           // print_r($auditArr);
            $this->render('/audit/autoauditform', array(
                'offerdetHTML' => $offerdetHTML,
                'offerArr' => $offerArr,
                'auditArr' => $auditArr,
                'offerID' => $offerID,
                'auditors_name' => $auditors_name,
                'message' => '',
                'v_name' => $v_name,
                'mappedMcat' =>$mappedMcat,  //passed mapped Mcat Array 
                'job_id'=>'',
                'job_type_id'=>''
            ));
            
         } else if (isset($_REQUEST['save'])) {
            $offerID       = isset($_REQUEST['selofferID']) ? $_REQUEST['selofferID'] : '';   
            $offerArr     = $obj->auditDetail('', $offerID); 
            $auditArr      = $obj->show_audit_question('AUTO'); 
            $errormessage=$obj->save_audit_details(0,$auditArr,$offerID,$offerArr,$arr_lvl_code);
            if ($errormessage == '') {
                echo $message = "Audit Record saved successfully for Offer-" . $offerID;                
            } else {
                echo $errormessage;
            }
            die;
        } else {
            $this->render('/audit/autoauditform', array(
                'offerArr' => $offerArr,
                'offerID' => $offerID
            ));
        }
    }else{
                 echo "You do not have permission";
                 exit;
            }
    }        
    
 public function actionUpdatetasktype()
    {
        $obj = new Globalconnection();
        $dbh_pg = $obj->connect_approvalpg();
        $model = new GlobalmodelForm();
        $query="SELECT	* 	
			 FROM freelance_vendor_work_stats		
		  where 
                  FK_ETO_LEAP_EMP_ID =6078 and DATE(ENTERED_ON) BETWEEN TO_DATE('07-04-2021','DD-MM-YYYY') AND TO_DATE('08-04-2021','DD-MM-YYYY') 		
";    
        
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $query, array());
        $res = $sth->readAll();
echo '==========================<pre>';print_r($res);

          $query="SELECT
			   count(TASK_REF_ID) total_product
			   FROM Freelance_TASK_DETAILS  
			   WHERE task_assignedto_empid=6078 "
                        . "and date(task_completion_date)= date(now()) and task_status=2 ";
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $query, array());
        $res = $sth->readAll();
echo '=====================<pre>';print_r($res);
  }
  
   public function actionRebuttaldatacorrect()
    {
        $obj           = new AuditModel;
        $auditId=1683405;
        echo $obj->acceptrebuttal($auditId);
  }
  public function ActionSuperAudit(){
    $statusDesc = array('W' => 'Waiting', 'A' => 'Approved');
    $userStatusDesc = array('W' => 'Waiting', 'A' => 'Approved', 'D' => 'Disabled', 'M' => 'Error Disabled');
    $glModel = new GlobalmodelForm();
    $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
     $resultData = array();
     $arr_map_ref = array();
     $approvPermit = 'N';
     $request = Yii::app()->request;
     $offerid=isset($_REQUEST["offerID"]) ? $_REQUEST["offerID"] : '';
     $valid = 0;
     $lvl_code = '';
     $vendor_name = '';
     $empId = Yii::app()->session['empid'];
     $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
     $obj=new SuperAuditForm();
      if (!$empId) {
           print "You are not logged in";
       exit;
      }
      $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
        if(empty($user_permissions))
        {
        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
        }

        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
       if($user_view ==1)
        {
             $path = $_SERVER['SERVER_NAME'];
             $prev_vendor_name = '';
             $status_check = '';
             $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
             if(isset($_POST['save'])){
              $obj=new SuperAuditForm();
              $obj->saveaudit();
             }
             else{
             if ($action == 'audit') {
                 if (!empty($offerid) && is_numeric($offerid)) {
                   $etoModel=new AdminEtoForm();
                   $jobtype=$obj->taskdata($offerid);
                   if(empty($jobtype)){
                        echo "Offer ID not found!";
                        exit;
                   }
                   $job_type_id= isset($jobtype['jobtype'])?$jobtype['jobtype']:'';
                   $task_detail_id=isset($jobtype['task_detail_id'])?$jobtype['task_detail_id']:'';
                   if ($jobtype['audit_id'] != ''){
                       $msg1="Super Audit already saved with Task Audit ID:";
                       echo '<div style="color:green;text-align:center;" >'. $msg1 .'&nbsp&nbsp'.$task_detail_id .'</div>';
                       exit;
                   }
                   if($job_type_id !=13){
                     $resultData = $obj->editOffer($request, '', $path, $statusDesc, $userStatusDesc, '', '', $offerid, $glModel);// only for 9,10,11, 12,14,15 for 13 call calldetail
                     $ofrStatus = isset($resultData['status']) ? $resultData['status'] : '';
                     $status_check = isset($resultData['status']) ? $resultData['status'] : '';
                     $rec = $resultData['rec'];
                     $auditor_name=$obj->get_auditor_details($offerid);
                     $error= $obj->error_details($offerid,$job_type_id,$auditor_name);
                     $task_id=$obj->gettaskauditid($offerid,$auditor_name);
                     $offerdetHTML = $obj->offerDetail($offerid);
                     $arr_map_ref = $obj->getCatMcatDetail($offerid, $glModel, $ofrStatus);
                     $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerid, $ofrStatus);  
                     $disp_arr=$obj->error_disposition($job_type_id);
                   $returnArr = array( 'result' => $resultData,'disp_arr' =>$disp_arr,'task_id'=>$task_id,'error'=>$error,'jobtype'=>$jobtype, 'offerdetHTML' => $offerdetHTML,'statusDesc' => $statusDesc, 'arr_map_ref' => $arr_map_ref,'userStatusDesc' => $userStatusDesc,  'status_check'=>$status_check,  'mappedMcat' =>$mappedMcat,'mid'=>$mid/*, 'offerdetHTML' => $offerdetHTML, 'transactiondetHTML' => $transactiondetHTML, 'BuyersDetailsHtml' => $BuyersDetailsHtml*/);
                   $this->render('/audit/superaudit',$returnArr);
                   }
                   else {

                       $offerArr=$obj->callDetail($offerid);  
                       $auditor_name=$obj->get_auditor_details($offerid);
                       $error= $obj->error_details($offerid,$job_type_id,$auditor_name); 
                       $disp_arr=$obj->error_disposition($job_type_id);
                       $task_id=$obj->gettaskauditid($offerid,$auditor_name);
                       $returnArr=array("offerArr"=> $offerArr, "error"=>$error,'task_id'=>$task_id,"jobtype"=>$jobtype,'disp_arr' =>$disp_arr);
                       $this->render('/audit/superaudit',$returnArr);
                   }
                   }
                   
       }
       }
    }else{
      echo "You do not have permission";
       exit;
   }
       }
   

      public function ActionSuperAuditMis(){
           $empId = Yii::app()->session['empid'];
           $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
          if(!$empId){
             print "You are not logged in";
              exit;
          }
          $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
          if(empty($user_permissions))
          {
          $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
          }
  
          $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
          if($user_view ==1)
         {
           $obj=new SuperAuditForm();
           $start_date=strtoupper(date("d-M-Y"));
           $message='';
           if(isset($_REQUEST['audit_summary']))
           {     
                   $data=$obj->super_audit_summary($_REQUEST); 
   
                    echo $data;die;  
   
          } 
          else if(isset($_REQUEST['audit_report']))
           {     
                   $data=$obj->super_audit_report($_REQUEST); 
   
                    echo $data;die;  
   
          } 
         else  if(isset($_REQUEST['audit_detail']))
           {     
                   $data=$obj->super_audit_detailed_report($_REQUEST); 
   
                    echo $data;die;  
   
          } 
          else{ $this->render('/audit/superauditMis',array('start_date'=>$start_date,'message'=>$message));
          }
       }else{
            echo "You do not have permission";
            exit;
       }
       }
     
      
    public function ActionSuperAuditEdit(){
        $statusDesc = array('W' => 'Waiting', 'A' => 'Approved');
        $userStatusDesc = array('W' => 'Waiting', 'A' => 'Approved', 'D' => 'Disabled', 'M' => 'Error Disabled');
        $glModel = new GlobalmodelForm();
         $resultData = array();
         $arr_map_ref = array();
         $approvPermit = 'N';
         $request = Yii::app()->request;
         $offerid=isset($_REQUEST["offerID"]) ? $_REQUEST["offerID"] : '';
         $valid = 0;
         $lvl_code = '';
         $vendor_name = '';
         $empId = Yii::app()->session['empid'];
         $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
         $obj=new SuperAuditForm();
          if (!$empId) {
               print "You are not logged in";
           exit;
          }
                 $path = $_SERVER['SERVER_NAME'];
                 $status_check = '';
                 $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
                 if(isset($_POST['save'])){
                    $obj=new SuperAuditForm();
                    $obj->update_audit();
                   }
                   else{
                 if ($action == 'edit') {
                     if (!empty($offerid) && is_numeric($offerid)) {
                       $etoModel=new AdminEtoForm();
                       $jobtype=$obj->taskdata($offerid);
                       $job_type_id= isset($jobtype['jobtype'])?$jobtype['jobtype']:'';
                       $task_detail_id=isset($jobtype['task_detail_id'])?$jobtype['task_detail_id']:'';
                       
                       if($job_type_id !=13){
                         $resultData = $obj->editOffer($request, '', $path, $statusDesc, $userStatusDesc, '', '', $offerid, $glModel);// only for 9,10,11, 12,14,15 for 13 call calldetail
                         $ofrStatus = isset($resultData['status']) ? $resultData['status'] : '';
                         $status_check = isset($resultData['status']) ? $resultData['status'] : '';
                         $rec = $resultData['rec'];
                         $auditor_name=$obj->get_auditor_details($offerid);
                         $error= $obj->error_details($offerid,$job_type_id,$auditor_name);
                         $task_id=$obj->gettaskauditid($offerid,$auditor_name);
                         $offerdetHTML = $obj->offerDetail($offerid);
                         $arr_map_ref = $obj->getCatMcatDetail($offerid, $glModel, $ofrStatus);
                         $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerid, $ofrStatus);  
                         $disp_arr=$obj->error_disposition($job_type_id);
                         $db_details=$obj->get_details($offerid,$task_detail_id);
                       $returnArr = array( 'result' => $resultData,'disp_arr' =>$disp_arr,'task_id'=>$task_id,'db_details'=>$db_details,'error'=>$error,'jobtype'=>$jobtype, 'offerdetHTML' => $offerdetHTML,'statusDesc' => $statusDesc, 'arr_map_ref' => $arr_map_ref,'userStatusDesc' => $userStatusDesc,  'status_check'=>$status_check,  'mappedMcat' =>$mappedMcat,'mid'=>$mid/*, 'offerdetHTML' => $offerdetHTML, 'transactiondetHTML' => $transactiondetHTML, 'BuyersDetailsHtml' => $BuyersDetailsHtml*/);
                       $this->render('/audit/superauditedit',$returnArr);
                       }
                       else {
    
                           $offerArr=$obj->callDetail($offerid);  
                           $auditor_name=$obj->get_auditor_details($offerid);
                           $error= $obj->error_details($offerid,$job_type_id,$auditor_name); 
                           $disp_arr=$obj->error_disposition($job_type_id);
                           $task_id=$obj->gettaskauditid($offerid,$auditor_name);
                           $db_details=$obj->get_details($offerid,$task_detail_id);
                           $returnArr=array("offerArr"=> $offerArr, "error"=>$error,'task_id'=>$task_id,'db_details'=>$db_details,"jobtype"=>$jobtype,'disp_arr' =>$disp_arr);
                           $this->render('/audit/superauditedit',$returnArr);
                       }
                       }
            }
           
        }
    }

    public function ActionSuperAuditDashboard(){
        $statusDesc = array('W' => 'Waiting', 'A' => 'Approved');
        $userStatusDesc = array('W' => 'Waiting', 'A' => 'Approved', 'D' => 'Disabled', 'M' => 'Error Disabled');
        $glModel = new GlobalmodelForm();
        $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
         $resultData = array();
         $arr_map_ref = array();
         $approvPermit = 'N';
         $request = Yii::app()->request;
         $offer=isset($_REQUEST["offerID"]) ? $_REQUEST["offerID"] : '';
         $valid = 0;
         $lvl_code = '';
         $vendor_name = '';
         $empId = Yii::app()->session['empid'];
         $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
            $empId = Yii::app()->session['empid'];
           if(!$empId){
              print "You are not logged in";
               exit;
           }
           $obj=new SuperAuditForm();
           $start_date=strtoupper(date("d-M-Y"));
           $path = $_SERVER['SERVER_NAME'];
            $prev_vendor_name = '';
            $status_check = '';
            $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
            
            if ($action == 'audit') 
        {
                
                $flag=0;
                $offerid='';
                $etoModel=new AdminEtoForm();
                $jobtype=$obj->taskdata($offer);
                          if(empty($jobtype)){
                               echo "Offer ID not found!";
                               exit;
                          }
                          $job_type_id= isset($jobtype['jobtype'])?$jobtype['jobtype']:'';
                          $task_detail_id=isset($jobtype['task_detail_id'])?$jobtype['task_detail_id']:'';
            
                if (!empty($offer) && is_numeric($offer) && $offer!=0)
             {
                  $auditid=$jobtype['audit_id'];
                  if(isset($_POST['save_close']) || isset($_POST['save'])){
                      $flag=1;
                  }
                  if($flag == 0){
                  while($auditid !='' ){
                    $obj->RemovefromInQueue($job_type_id);
                    $jobid=$job_type_id;
                    $nexofr=$obj->GetFirstIdFromRedis($jobid,'day1');
                    if($nexofr != ''){
                    $jobtype=$obj->taskdata($nexofr);
                    $offer=$nexofr;
                    $auditid=$jobtype['audit_id'];
                             }
                    else{
                        echo 'Super Audit already saved for all Offer Ids! <div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                        . '<a href="/index.php?r=admin_eto/AuditEto/SuperAuditDashboard&mid=3934">Back to Super Audit Dashboard</a></div>';die; 
                        }
                     }
                    }
                    $savedet=array();
        if($job_type_id !=13){
                        if(isset($_POST['save']) || isset($_POST['save_close'])){
                            $obj=new SuperAuditForm();
                             $savedet=$obj->saveaudit1();
                         if(isset($_POST['save'])){
                         $jobid=$_POST['job_id'];//job type
                         echo'<div align="center"><span style="font-weight:bold;font-size:16px;color:green;">'.$savedet['msg'].'-'.$_POST['offer_id'].'</span></div>';
                         $obj->RemoveIdfromOutQueue($jobid); // remove the saved id from out queue
                         }
                        if(isset($_POST['save_close'])){
                            $flag=1;
                            $jobid=$_POST['job_id'];
                            $obj->RemoveIdfromOutQueue($jobid); // remove the saved id from out queue
                            echo '<h1 align="center">THANK YOU</h1>'
                               . '<div align="center"><span style="font-weight:bold;font-size:16px;">'
                            . $savedet['msg'].'-'.$_POST['offer_id'].'</span></div><br/><br/><div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                            . '<a href="/index.php?r=admin_eto/AuditEto/SuperAuditDashboard&mid=3934">Back to Super Audit Dashboard</a></div>';die;  
                            }
                        }
                        if(isset($_POST['save'])){
                            $nexofr=$obj->GetFirstIdFromRedis($jobid,'day1');// next ofr to be audited take from in queue
                            $jobtype=$obj->taskdata($nexofr);
                            $job_type_id= isset($jobtype['jobtype'])?$jobtype['jobtype']:'';
                            $task_detail_id=isset($jobtype['task_detail_id'])?$jobtype['task_detail_id']:'';
                            $offerid=$nexofr;
                            if($offerid==0){
                                echo"No more Buyleads of this job are left for Super Audit.";
                                exit;
                            }
                            $auditid=$jobtype['audit_id'];
                            while($auditid !='' ){
                                $obj->RemovefromInQueue($job_type_id);
                                $jobid=$job_type_id;
                                $nexofr=$obj->GetFirstIdFromRedis($jobid,'day1');
                                if($nexofr != ''){
                                $jobtype=$obj->taskdata($nexofr);
                                $auditid=$jobtype['audit_id'];
                                $offerid=$nexofr;
                                }
                                else{
                                    echo 'Super Audit already saved for all Offer Ids in this job type! <div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                                    . '<a href="/index.php?r=admin_eto/AuditEto/SuperAuditDashboard&mid=3934">Back to Super Audit Dashboard</a></div>';die; 
                                }
                              }
                              
                        }
                        else{
                            $offerid=$offer;
                        } 
                        $obj->PutIdInOutQueue($job_type_id);
                        $resultData = $obj->editOffer($request, '', $path, $statusDesc, $userStatusDesc, '', '', $offerid, $glModel);// only for 9,10,11, 12,14,15 for 13 call calldetail
                        $ofrStatus = isset($resultData['status']) ? $resultData['status'] : '';
                        $status_check = isset($resultData['status']) ? $resultData['status'] : '';
                        $rec = $resultData['rec'];
                        $auditor_name=$obj->get_auditor_details($offerid);
                        $error= $obj->error_details($offerid,$job_type_id,$auditor_name);
                        $task_id=$obj->gettaskauditid($offerid,$auditor_name);
                        $offerdetHTML = $obj->offerDetail($offerid);
                        $arr_map_ref = $obj->getCatMcatDetail($offerid, $glModel, $ofrStatus);
                        $mappedMcat   = $etoModel->histOfrMapmcat_audit($offerid, $ofrStatus);  
                        $disp_arr=$obj->error_disposition($job_type_id);
                      $returnArr = array( 'result' => $resultData,'disp_arr' =>$disp_arr,'offerid'=>$offerid,'task_id'=>$task_id,'error'=>$error,'jobtype'=>$jobtype, 'offerdetHTML' => $offerdetHTML,'statusDesc' => $statusDesc, 'arr_map_ref' => $arr_map_ref,'userStatusDesc' => $userStatusDesc,  'status_check'=>$status_check,  'mappedMcat' =>$mappedMcat,'mid'=>$mid/*, 'offerdetHTML' => $offerdetHTML, 'transactiondetHTML' => $transactiondetHTML, 'BuyersDetailsHtml' => $BuyersDetailsHtml*/);
                      $this->render('/audit/superAudit_test_dashboard',$returnArr);
                    }
         else{
                      if(isset($_POST['save']) || isset($_POST['save_close'])){
                        $obj=new SuperAuditForm();
                         $savedet=$obj->saveaudit1();
                     if(isset($_POST['save'])){
                     $jobid=$_POST['job_id'];//job type
                     echo'<div align="center"><span style="font-weight:bold;font-size:16px;color:green;">'.$savedet['msg'].'-'.$_POST['offer_id'].'</span></div>';
                     $obj->RemoveIdfromOutQueue($jobid); // remove the saved id from out queue
                     //$offerid=$obj->GetFirstIdFromRedis($jobid,'day1');// next ofr to be audited take from in queue
                     }
                    if(isset($_POST['save_close'])){
                        $jobid=$_POST['job_id'];
                        $obj->RemoveIdfromOutQueue($jobid); // remove the saved id from out queue
                        echo '<h1 align="center">THANK YOU</h1>'
                           . '<div align="center"><span style="font-weight:bold;font-size:16px;">'
                        . $savedet['msg'].'-'.$_POST['offer_id'].'</span></div><br/><br/><div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                        . '<a href="/index.php?r=admin_eto/AuditEto/SuperAuditDashboard&mid=3934">Back to Super Audit Dashboard</a></div>';die;  
                        }
                    }
                    if(isset($_POST['save'])){
                        $nexofr=$obj->GetFirstIdFromRedis($jobid,'day1');// next ofr to be audited take from in queue
                        $jobtype=$obj->taskdata($nexofr);
                        $job_type_id= isset($jobtype['jobtype'])?$jobtype['jobtype']:'';
                        $task_detail_id=isset($jobtype['task_detail_id'])?$jobtype['task_detail_id']:'';
                        $offerid=$nexofr;
                        if($offerid==0){
                            echo"No more Buyleads of this job are left for Super Audit.";
                            exit;
                        }
                        $auditid=$jobtype['audit_id'];
                        while($auditid !='' ){
                            $obj->RemovefromInQueue($job_type_id);
                            $jobid=$job_type_id;
                            $nexofr=$obj->GetFirstIdFromRedis($jobid,'day1');
                            if($nexofr != ''){
                            $jobtype=$obj->taskdata($nexofr);
                            $auditid=$jobtype['audit_id'];
                            $offerid=$nexofr;
                            }
                            else{
                                echo 'Super Audit already saved for all Offer Ids in this job type! <div align="center" style="font-weight:bold;color:#006ecd;font-size:18px;">'
                                . '<a href="/index.php?r=admin_eto/AuditEto/SuperAuditDashboard&mid=3934">Back to Super Audit Dashboard</a></div>';die; 
                            }
                          }
                          
                    }
                    else{
                        $offerid=$offer;
                    }   
                              $offerArr=$obj->callDetail($offerid);  
                              $obj->PutIdInOutQueue($job_type_id);
                              $auditor_name=$obj->get_auditor_details($offerid);
                              $error= $obj->error_details($offerid,$job_type_id,$auditor_name); 
                              $disp_arr=$obj->error_disposition($job_type_id);
                              $task_id=$obj->gettaskauditid($offerid,$auditor_name);
                              $returnArr=array("offerArr"=> $offerArr, 'offerid'=>$offerid,"error"=>$error,'task_id'=>$task_id,"jobtype"=>$jobtype,'disp_arr' =>$disp_arr);
                              $this->render('/audit/superAudit_test_dashboard',$returnArr);
             }
            
         }  
             else
    
             {  echo"No more Buyleads of this job are left for Super Audit.";
                exit;
             }
            
        }
            else if($action=='fetch_sample'){ 
                $obj->super_audit_fetch_sample($request);
                      
            }
            else{
                $this->render('/audit/superauditDashboard',array('start_date'=>$start_date));
            }
             
        
    }
    
    public $redis;
    public function ActionQueueData()
    {
        $this->redis = $this->connectRedis();
        $result = $this->redis->HGETALL('SUPERAUDIT_IN_DAY1_QUEUE');
        $result1 = $this->redis->HGETALL('SUPERAUDIT_OUT_DAY1_QUEUE');
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        echo "<pre>";
        print_r($result1);
        echo "</pre>";
        // }else{
        //     echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission of this Hash Map  <b>";
        // }
        exit;
    }
    public function connectRedis()
    {
        $server = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
        $mid = isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $redis = '';
        try {
            $obj = new Globalconnection();
            $redis = $obj->GetRedisConn();
            return $redis;
        } catch (Exception $e) {
            echo "<div style='text-align: center; margin-top: 20%;'>
            <hr>Connection Error: Please Contact Gladmin.
                Click to Open <a href='/index.php?r=admin_marketplace/Freelance/ShowJobs&mid=$mid'>Job Dashboard</a>
            <hr></div>";
            $msg =  $e->getMessage();
            mail("laxmi@indiamart.com", "JOBTASKS - Couldn't connected to Redis ", $msg);
            exit;
        }
    }
}