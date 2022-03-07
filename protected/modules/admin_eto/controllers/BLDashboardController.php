<?php 

class BLDashboardController extends Controller
{
   
    public function actionHourlydata()
	{
					echo 'Report has been moved in Leap CRM';exit;

    }
    
    public function actionLeapDashboard() {            
		
    $loginPath = $_SERVER['SERVER_NAME'];
    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
    $emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
    if($emp_id>0){
        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
        if($user_view==1)
        {
        $allVenders=array('COGENT','COGENTBRB','COGENTDNC','COGENTINBOUND','COGENTINTENT','COGENTPNS','DDN','ILEAD','KOCHARTECH','KOCHARTECHCHN','KOCHARTECHDNC','KOCHARTECHLDH','KOCHARTECHINTENT','NOIDA','PROCMART','VKALP','VKALPDNC','RADIATE','RADIATEDNC','RADIATEPNSTOBL','RADIATEINTENT');

		$valid = 0;		
		$request = Yii::app()->request;
		$actionVal = $request->getParam("action",'');
		$months = array('01' => "JAN",'02' => "FEB",'03' => "MAR",'04' => "APR",'05' => "MAY",'06' => "JUN", '07' => "JUL",'08' => "AUG",'09' => "SEP",'10' => "OCT",'11' => "NOV",'12' => "DEC");
		$monthsStr = array("JAN"=>'01',"FEB"=>'02',"MAR"=>'03',"APR"=>'04',"MAY"=>'05',"JUN" =>'06',"JUL" =>'07',"AUG"=>'08',"SEP" =>'09',"OCT"=>'10',"NOV"=>'11',"DEC"=>'12');
		$permision = 0;
		$vendorArr = array();
		
                $empId = Yii::app()->session['empid'];
                if(!empty($empId)) {
			$valid = 1;
		}
		$vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
		$permision = $vendorRe['permision'];
		$vendorArr = $vendorRe['vendorArr'];
		if($actionVal == 'generate')
		{
                        $rtype = $request->getParam('rtype','D');                    
                        if($rtype=='PMCAT'){
                            $displayTotalData = $leapdashboardModel->PMCAT($request,$vendorRe);
                        }elseif($rtype=='SUPPLIER'){
                            $displayTotalData = $leapdashboardModel->supplier_search_keyword($request,$vendorRe);
                        }elseif($rtype=='ISQFEEDBACK'){
                            $displayTotalData = $leapdashboardModel->ISQfeedback($request,$vendorRe);
                        }elseif($rtype=='FEEDBACK'){
                            $displayTotalData = $leapdashboardModel->feedback($request,$vendorRe);
                        }elseif($rtype=='TL'){
                            $displayTotalData = $leapdashboardModel->tlWiseDetail($request,$vendorRe);
                        }elseif($rtype=='AON'){ 
                            $displayTotalData = $leapdashboardModel->aonWiseDetail($request,$vendorRe,$empId);
                        }
                        elseif($rtype=='ISQ'){
                           $displayTotalData = $leapdashboardModel->isqWiseDetail($request,$vendorRe,$empId);
                       }
                       elseif($rtype=='ISQFILLRATE'){
                          $displayTotalData = $leapdashboardModel->isqfillrate($request,$vendorRe,$empId);
                       }
                       elseif($rtype=='TOP'){
                           $displayTotalData = $leapdashboardModel->topPerformerDetail($request);
                       }
                       elseif($rtype=='CONTACT')
                       {
                         $displayTotalData = $leapdashboardModel->ContactDetail($request);
                       }
                       elseif($rtype=='PRODUCT')
                       {
                       $displayTotalData = $leapdashboardModel->ProductDetail($request);
                       }
                       else
                        {
			$displayTotalData = $leapdashboardModel->displayTotal($request,$vendorRe,$empId);
                       }			
			echo $displayTotalData;
			exit;
		} else if($actionVal == 'empwisedetail')
		{
			$displayEmpWiseData = $leapdashboardModel->empWiseDetail($request,$vendorRe);
			echo $displayEmpWiseData;
			exit;
		}
		else if($actionVal == 'empwiseIsqdetail')
		{
			$displayEmpWiseIsqData = $leapdashboardModel->empWiseIsqDetail($request,$vendorRe);
			echo $displayEmpWiseIsqData;
			exit;
		}
		else if($actionVal == 'empwisedd')
		{
			$displayEmpWiseDelData = $leapdashboardModel->empWiseDeletionDump($request,$vendorRe);
			$this->render("/admineto/empwisedeldump",array("result"=> $displayEmpWiseDelData));
			exit;
		}
		else if($actionVal == 'empwisead')
		{
			$displayEmpWiseAppData = $leapdashboardModel->empWiseApprovalDump($request,$vendorRe);
			$this->render("/admineto/empwiseappdump",array("result"=> $displayEmpWiseAppData));
			exit;
		}
		else if($actionVal == 'export')
		{
			$exportApproval = $leapdashboardModel->exportToExcelApp($request);
			exit;
		}
		else if($actionVal == 'export')
		{
			$exportApproval = $leapdashboardModel->exportToExcelApp($request);
			exit;
		}
		else if($actionVal == 'exportdel')
		{
			$exportDel = $leapdashboardModel->exportToExcelDel($request);
			exit;
		}
		else if($actionVal == 'exportNT')
		{       
			$exportDel = $leapdashboardModel->exportToExcelNT($request);
			exit;
		}
                else if($actionVal == 'exportAUTO')
		{       
			$exportDel = $leapdashboardModel->exportToExcelAUTO($request);
			exit;
		}
                else if($actionVal == 'exportFeedback')
		{       
			$exportDel = $leapdashboardModel->feedbackdetail($request,'export');
			exit;
		}
                else if($actionVal == 'feedbackdetail')
		{       
			$arr = $leapdashboardModel->feedbackdetail($request,'report');
			$this->render("/admineto/feedbackdump",array('result'=>$arr));
			exit;
		}
                else if($actionVal == 'exportisqfeedback')
		{       
			$exportDel = $leapdashboardModel->ISQfeedbackdetail($request,'export');
			exit;
		}
                else if($actionVal == 'isqfeedbackdetail')
		{       
			$arr = $leapdashboardModel->ISQfeedbackdetail($request,'report');
			$this->render("/admineto/isqfeedbackdump",array('result'=>$arr));
			exit;
		}
                else if($actionVal == 'exportSupplier')
		{       
			$arr = $leapdashboardModel->supplierdetail_agent($request,'export');
                        exit;
		}
                else if($actionVal == 'exportpmcat')
		{       
			$arr = $leapdashboardModel->pmcat_agent($request,'export');
                        exit;
		}
                else if($actionVal == 'exportisqfillrate')
		{       
			$arr = $leapdashboardModel->isqfillrate_agent($request,'export');                        
			exit;
		}                
                else if($actionVal == 'supplierdetail_tl')
		{       
			$arr = $leapdashboardModel->supplier_search_keyword_tl($request,'report');
			exit;
		}
                else if($actionVal == 'PMCAT_tl')
		{       
			$arr = $leapdashboardModel->PMCAT_tl($request,'report');
			exit;
		}
                else if($actionVal == 'isqfillrate_tl')
		{       
			 $leapdashboardModel->isqfillrate_tl($request,'report');
                         exit;
		}
                else if($actionVal == 'isqfillrate_agent')
		{       
			$arr = $leapdashboardModel->isqfillrate_agent($request,'report');
			$this->render("/admineto/isqfillratedump",array('result'=>$arr));
			exit;
		}
                else if($actionVal == 'PMCAT_agent')
		{      
			$result=$leapdashboardModel->pmcat_agent($request,'report');
                        $this->render("/admineto/pmcatdump",array('result'=>$result));
			exit;
		}
                else if($actionVal == 'supplierdetail_agent')
		{       
			$arr = $leapdashboardModel->supplierdetail_agent($request,'report');
                        $this->render("/admineto/supplierdump",array('result'=>$arr));
			exit;
		}
		if($actionVal == "tlwiseflaggeddata"){
			$flaggedPendingData = $leapdashboardModel->FlaggedPendingData($permision,$vendorArr);	
			echo 	$flaggedPendingData;
			exit;
		} else if($actionVal == 'showch')
		{
			$vendor = $request->getParam("vendor");
                        $agentstatus = $request->getParam("agentstatus");
                        if($agentstatus==''){
                            $agentstatus='Active';
                        }
			$this->render("/admineto/changeagent",array('vendorArr' => $vendorArr,'action' => 'showch','vendor'=>$vendor,'agentstatus'=>$agentstatus));
			exit;
		}
		else if($actionVal == 'ch')
		{
			$vendor = $request->getParam("vendor");
                        $agentstatus = $request->getParam("agentstatus");
			$displayAgentInfo = $leapdashboardModel->displayAgentInfo($request,$vendorArr);
			$this->render("/admineto/changeagent",array('result' => $displayAgentInfo,'action' => 'ch','vendorArr' => $vendorArr,'vendor' => $vendor,'agentstatus'=>$agentstatus));
			exit;
		}else if($actionVal == 'save')
		{
			$vendor = $request->getParam("vendor");
                        $agentstatus = $request->getParam("agentstatus");
			$re = $leapdashboardModel->saveAgentName($request,$empId);
			$displayAgentInfo = $leapdashboardModel->displayAgentInfo($request,$vendorArr);
			$this->render("/admineto/changeagent",array('succMsg'=>$re,'result' => $displayAgentInfo,'vendorArr' => $vendorArr,'vendor' => $vendor,'action' => 'ch','agentstatus'=>$agentstatus));
			exit;
		}
		else if($actionVal == 'NT')
		{		      
			$arr = $leapdashboardModel->ntDump($request,$vendorRe);
			$sth=$arr[0];
			$main_array=$arr[1];
			$days=$arr[2];
			
			$this->render("/admineto/ntreport",array('sth'=>$sth,'request'=>$request,'main_array'=>$main_array,'days'=>$days));
			exit;		
		}
                else if($actionVal == 'AUTO')
		{		      
			$arr = $leapdashboardModel->autoDump($request,$vendorRe);
			$sth=$arr[0];			
			$this->render("/admineto/autoreport",array('sth'=>$sth,'request'=>$request));
			exit;		
		}
		else if($actionVal == 'hourlydata')
		{
                    echo 'This is Incorrect URL. Please use New URL to view Associate Performance Details<br> ';exit;	
		}		
		else {
                   $showForm = $leapdashboardModel->showForm($request,$vendorRe); 
		}		
	       $returnArray = array(
				"loginPath" => $loginPath,		
				"valid" => $valid,		
				"vendorArr" => $vendorArr,		
				"permision" => $permision,		
				"showForm" => $showForm,
				"allVenders"=>$allVenders
			);
		$this->render("/admineto/leapapprovaldashboard",$returnArray);
	}else{
              echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
              exit;
            }
        }else{
            echo "Please login again";
            exit;
        }     
}      
 public function actionTopperformer(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
            $emp_id = isset(Yii::app()->session['empid']) ? Yii::app()->session['empid'] : '';
            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
            if($user_view==1)
            {       
                $request = Yii::app()->request;
                $leapdashboardModel =  new LeapDashboardModel();
                echo $displayTotalData = $leapdashboardModel->topPerformerDetail($request);
            }else
                {
              echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
              exit;
            }
     }else{
            echo "<Please login again";
            exit;
        } 
 }       
  public function actionPmcat(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            echo $displayTotalData = $leapdashboardModel->PMCAT($request);
        }else{
          echo "You are not logged in";
          exit;
        }
  } 
  public function actionPmcat_tl(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            echo $displayTotalData = $leapdashboardModel->PMCAT_tl($request,'report');
        }else{
          echo "You are not logged in";
          exit;
        }
  } 
   public function actionPmcat_agent(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            echo $displayTotalData = $leapdashboardModel->pmcat_agent($request,'report');
            $this->render("/admineto/pmcatdump",array('result'=>$result));
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  } 
 public function actionFCPAttribute(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            echo $displayTotalData = $leapdashboardModel->FCPAttribute($request);
        }else{
          echo "You are not logged in";
          exit;
        }
  } 
 public function actionSupplier(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            echo $displayTotalData = $leapdashboardModel->supplier_search_keyword($request);
        }else{
          echo "You are not logged in";
          exit;
        }
  } 
 public function actionFcp(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            echo $displayTotalData = $leapdashboardModel->FCP($request);
        }else{
          echo "You are not logged in";
          exit;
        }
  }
   public function actionIsqfillrate(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->isqfillrate($request);
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionIsqfillrate_tl(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->isqfillrate_tl($request,'report',$empId);
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionIsqfillrate_agent(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->isqfillrate_agent($request,'report');
            $this->render("/admineto/isqfillratedump",array('result'=>$arr));
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionExportisqfillrate(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->isqfillrate_agent($request,'export');    
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionSupplierdetail_agent(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->supplierdetail_agent($request,'report');
            $this->render("/admineto/supplierdump",array('result'=>$arr));
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionExportSupplier(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->supplierdetail_agent($request,'export');
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  
  public function actionFeedback(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->feedback($request);
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionExportFeedback(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->feedbackdetail($request,'export');
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionFeedbackdetail(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->feedbackdetail($request,'report');
            $this->render("/admineto/feedbackdump",array('result'=>$arr));
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionIsqfeedback(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->ISQfeedback($request);
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionExportisqfeedback(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {			
            $request = Yii::app()->request;                       
            $leapdashboardModel =  new LeapDashboardModel();
            $leapdashboardModel->ISQfeedbackdetail($request,'export');
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  
   public function actionTlwiseflaggeddata(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel();
            $permision = 0;
            $vendorArr = array();	
            $request = Yii::app()->request;   
            $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
            $permision = $vendorRe['permision'];
            $vendorArr = $vendorRe['vendorArr'];
            $flaggedPendingData = $leapdashboardModel->FlaggedPendingData($permision,$vendorArr);	
            echo $flaggedPendingData;
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
   public function actionTl(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel();
            $permision = 0;
            $vendorArr = array();	
            $request = Yii::app()->request;   
            $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);           
            $flaggedPendingData = $leapdashboardModel->tlWiseDetail($request,$vendorRe);
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionAon(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel();
            $request = Yii::app()->request;   
            $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);           
            $flaggedPendingData = $leapdashboardModel->aonWiseDetail($request,$vendorRe,$empId);
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionProduct(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel();   
            $request = Yii::app()->request;   
            echo $flaggedPendingData = $leapdashboardModel->ProductDetail($request);
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionContact(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel();   
            $request = Yii::app()->request;   
            echo $flaggedPendingData = $leapdashboardModel->ContactDetail($request);
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionSupplierdetail_tl(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel(); 
            $request = Yii::app()->request;   
            $arr = $leapdashboardModel->supplier_search_keyword_tl($request,'report');
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionEmpwisedetail(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel(); 
            $request = Yii::app()->request;   
            $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
            echo $arr = $leapdashboardModel->empWiseDetail($request,$vendorRe);
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionEmpwisedd(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel(); 
            $request = Yii::app()->request;   
            $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
            $displayEmpWiseDelData = $leapdashboardModel->empWiseDeletionDump($request,$vendorRe);
            $this->render("/admineto/empwisedeldump",array("result"=> $displayEmpWiseDelData));
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
  public function actionEmpwisead(){
      $empId =Yii::app()->session['empid'];	
        if($empId > 0) {	
            $leapdashboardModel =  new LeapDashboardModel(); 
            $request = Yii::app()->request;   
            $vendorRe = $leapdashboardModel->getLeapVendor($request,$empId);
            echo $arr = $leapdashboardModel->empWiseApprovalDump($request,$vendorRe);
            $this->render("/admineto/empwiseappdump",array("result"=> $displayEmpWiseAppData));
            exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }
public function actionPpp() { 
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                $leapdashboardModel =  new LeapDashboardModel(); 
                $displayreportemp = $leapdashboardModel->ppp($request);		
		echo $displayreportemp;		
		exit;
                }else{
                echo "You are not logged in";
                exit;
            }  
	}
        
        public function actionPppemp() {  
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                $leapdashboardModel =  new LeapDashboardModel(); 
                $displayreportemp = $leapdashboardModel->pppemp($request);		
		echo $displayreportemp;		
		exit;
            }else{
            echo "You are not logged in";
            exit;
            }  
	}
       
}
