<?php
//error_reporting(1);
class AdminEtoController extends Controller
{
	public $statusDesc = array();
	public $userStatusDesc = array();
	public $model = '';
	public $etoModel = '';
	public $glModel = '';
	public $approvPermit = array();
	public $qtyList = array();
	public $qtyListOther = array();
	public $leapMisEmp = array();
	public $leapdashboardModel = array();
	public $use_posgre=0;
    public $adminEtoSearch = '';
	public $allVenders=array();
	public function init(){
		$this->statusDesc = array(
			'W'=>'Waiting',
			'A'=>'Approved'	
		);
	 	$this->userStatusDesc = array(
					'W'=>'Waiting',
					'A'=>'Approved',
					'D'=>'Disabled',
					'M'=>'Error Disabled'
		);
                            
                $this->use_posgre=0;
                $this->etoModel =  new AdminEtoForm();
                $this->leapdashboardModel =  new LeapDashboardModel();
                $this->adminEtoSearch=new AdminEtoSearch();
                
                $this->model =  new AdminEtoModelForm();
		$this->glModel =  new GlobalmodelForm();
		$this->qtyList = array("Kilogram","Metric Tons","Nos","Pieces","Tons");
	 	$this->qtyListOther = array("20' Container","40' Container","Bags","Barrel","Bottles","Boxes","Bushel","Cartons","Dozens","Foot","Gallon","Grams","Hectare","Kilogram","Kilometer","Litres","Long Ton","Meter","Metric Tons","Nos","Ounce","Packets","Packs","Pairs","Pieces","Pound","Reams","Rolls","Sets","Sheets","Short Ton","Square Feet","Square Meters","Tons","Units","Others");
	 	$this->leapMisEmp = array(29545,36924,22970,86692,86689,85361,85945,5096,26564,32016,84844,84873,30314,61154,77082,71355,76028,67422,71116,65677,67572,60437,43894,61721,62129,56333,58511,56576,69053,58159,34058,21875,6251,46480,23015,49465,37686,35740,22288,32236,3664,40208,40207,40022,35422,3575,21870,33403,33402,37642,45528,48862,38628,40399,48880);
	 	$this->allVenders=  CommonVariable::get_active_vendor_name();  
                }
	
	public function actionIndex() {
 		echo 'Please contact to Gladmin team';
                exit;
	}
	
	
	public function actionRightIndex() {
		echo 'Please contact to Gladmin team';
                exit;
	}
	
	
	public function actionRightFrame() {
		echo 'Please contact to Gladmin team';
                exit;
	}
	
	public function getEmpIdLVLCode($q) {
		$data = array();
		$empId = Yii::app()->session['empid'];
		if($empId){			
			$data = $this->model->getLVLCode($q,$empId,$this->glModel);
                        return array("data"=>$data,"empId"=>$empId);
		}else{
                    echo "You are not logged in";
                    exit;
                }
		
	}
	
public function actionLeapFlagged(){

        $flaggedLeads = array();		
        $empId = Yii::app()->session['empid'];			
        if($empId) {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
            		
			$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);

		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{
                        $param['action'] = Yii::app()->request->getParam('action');		
                        if($param['action'] == "flaggedmcatna"){
                                $adminEto_report = new Eto_report();
                                $flaggedLeads = $adminEto_report->getFlaggedLeads($this->glModel);
                        }
                        $result = array(
                                "flaggedLeads" => $flaggedLeads	
                        );
                        $this->render("/admineto/leapflagged",$result);	
                }else{
                     echo "You do not have permission";
                     exit;
                }
                }else{
                    echo "You are not logged in";
                    exit;
                }
	}

	
	
	public function actionEditFlaggedLeads() {
            echo 'This is Incorrect URL. Please use below Nevigation to view Offer Details<br> '
            . 'Manage Buy Leads  >> Buy Lead Reports >> Buy Lead Search';exit;	
	}
	
	public function actionSetFlag(){
	
	        $q = $_REQUEST;
		$updateFlag = '';
		$lvl_code='';               
                $empId = Yii::app()->session['empid'];	
		if($empId){
                        if(isset($_REQUEST['pushtotop']) && $_REQUEST['pushtotop']=='Push to Top')
                        {
                          $pushed = $this->etoModel->pushProductOnTop($empId);
                        }  		
			$updateFlag = $this->etoModel->saveOffer($empId,$this->glModel);
			if($updateFlag["status"] == "SUCCESS"){
				echo $updateFlag["msg"];				
                                $param['action'] =$_REQUEST['action'];
                                $param['offer'] = $_REQUEST['offer'];
                                 $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId); 
                                  if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                        $lvl_code='E';
                                    }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                         $lvl_code='V';                                        
                                    }
                                    if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])){
                                      $vendor_name=$arr_lvl_code['ETO_LEAP_VENDOR_NAME'];        
                                    }
                                $path = $_SERVER['SERVER_NAME'];
                                $request = Yii::app()->request;
                                $resultData = $this->etoModel->editOffer($request,$empId,$path,$this->statusDesc,$this->userStatusDesc,'','','',$this->glModel);                               
                                $ofrStatus = isset($resultData['status'])?$resultData['status']:'';
                                $arr_map_ref = $this->etoModel->getCatMcatDetail($param['offer'],$this->glModel,$ofrStatus);
                        
                       $returnArr = array(		
                        "lvl_code"=>  $lvl_code,
                        "valid"=>1,
                        'result'=> $resultData,
                        'arr_map_ref' => $arr_map_ref,
                        'offerID' => $param['offer'],
                        'emp_id' => $empId,
                        'statusDesc' => $this->statusDesc,
                        'userStatusDesc' => $this->userStatusDesc,
                        'qtyListOther' => $this->qtyListOther,
                        'qtyList' => $this->qtyList,
                        'approvPermit' => 'E',
                        'vendor_name'=>$vendor_name,
                        'fcpdetail'=> '',
                         'arr_lvl_code'=>  $arr_lvl_code
                        );				
                        $this->render("/admineto/editflaggedleads",$returnArr);
			} else {
				return $updateFlag["msg"];	
			}
                }	
		
	}
	
	public function actionSearchManualMcat(){
            $empId = Yii::app()->session['empid'];
            if($empId > 0){
                    $q = $_REQUEST;
                    $updateFlag = '';
                    $empId = Yii::app()->session['empid'];	
                    $manualMcatResult = $this->etoModel->manualMcat($empId,$this->glModel);	
                    $this->render("/admineto/searchmanualmcat",array("manualMcatResult"=>$manualMcatResult));
            }else{
                echo "You are not logged in";
                exit;
            }
	}
	
	public function actionGetCatOffers(){
             $empId = Yii::app()->session['empid'];
            if($empId > 0){
                $manualMcatResult = $this->etoModel->getManualMcatList($this->glModel);	
                die;
            }else{
                echo "You are not logged in";
                exit;
            }
	}
	
	public function actionShowOffersDelReason(){
            $empId = Yii::app()->session['empid'];
            if($empId > 0){
		$request = Yii::app()->request;		
		$button = $request->getParam("button",'');
		
		$deleteResonResult = $this->etoModel->showOfferDelReasons($this->glModel,$request);
		$result = $deleteResonResult['result'];
		$fromAnchor = $deleteResonResult['fromAnchor'];
		$redirectURL = $deleteResonResult['redirectURL'];
		$this->render("/admineto/showofferdelreasons",array("deleteResonResult"=>$result,'button' => $button,"fromAnchor" => $fromAnchor,"redirectURL" => $redirectURL));
            }else{
                echo "You are not logged in";
                exit;
            }
                
        }
	
	public function actionDeleteSilent(){
             $empId = Yii::app()->session['empid'];
             if($empId > 0){
		$request = Yii::app()->request;
		$empId =Yii::app()->session['empid'];	
		if($empId){
                    echo $deleted = $this->etoModel->delRec($this->glModel,$request,$empId,'');	
                    exit;           
                }
            }else{
                echo "You are not logged in";
                exit;
            }
	}
	
	public function actionofrSearch(){
            $empId = Yii::app()->session['empid']; 
			if($empId > 0){
	       if(isset($_REQUEST['mem']) and !empty($_REQUEST['mem']) and $_REQUEST['mem']>0 and isset($_REQUEST['Product'])&& $_REQUEST['Product']=='detail')
		{
                  $data=$this->etoModel->producDetail($_REQUEST['mem']);
		  $this->render("/admineto/productWebuy",array('data'=>$data));
		  die;
		}
		
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
		$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);

		if(empty($user_permissions))
		{
			$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{
	    	$request = Yii::app()->request;
			$status = $request->getParam('status','');   
                $lvl_code='';
                $adm_lvl='';
                $vendor_name='';
		if($empId){
                    $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND'  || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                        if(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME'])){
                           $vendor_name=$arr_lvl_code['ETO_LEAP_VENDOR_NAME'];  
                        }                        
                }	        
		if(isset($_REQUEST['ofereportid']))
		{
		die;
		}
		$start = isset($params['start'])?$params['start']:'';
                $reArr = array(
		"vendor_name"=>$vendor_name,
                "param"=>$_REQUEST);		
		$this->render("/admineto/ofrsearch",$reArr);
                
                
          if($request->getParam("go") || $request->getParam("action")){ 
                    $callfrom='adv_search';            
                     $result =  $this->adminEtoSearch->showAdvSearchResultPG($request,$empId,$this->glModel,$this->statusDesc,$this->userStatusDesc,$start,$lvl_code,$adm_lvl,$status);
                       $this->render('/admineto/buyleads',array(
			'result'=>$result,
			'userStatusDesc'=>$this->userStatusDesc,
			'statusDesc' => $this->statusDesc,
			'lvl_code' => $lvl_code,			
                         'callfrom'=>$callfrom,
			'conncetedcount'=>array(),
			'empId'=>$empId
			)
		);exit;
	  } 
	}
	else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
	}    
}else{
            echo "You are not logged in";
            exit;
        } 	
}

        public function actionofrSearcharch(){
            $request = Yii::app()->request;	
            $empId = Yii::app()->session['empid'];                
            if($empId > 0){	       
                $lvl_code='';                
		if($empId){
                    $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                }	
                        if(trim($request->getParam('mem','')) !='' || trim($request->getParam('offer',0)) > 0 || trim($request->getParam('memmail','')) !='' || trim($request->getParam('memmobile',0)) > 0 || trim($request->getParam('mcat_id',0)) > 0) {
                            $result =  $this->adminEtoSearch->showAdvSearchResultFenqPG($request);
                                 $this->render('/admineto/buyleads_arch',array(
                                  'result'=>$result,
                                  'userStatusDesc'=>$this->userStatusDesc,
                                   'statusDesc' => $this->statusDesc,
                                   'lvl_code'=>$lvl_code,
                                  )
                          );exit;
          }
        }else{
            echo "You are not logged in";
            exit;
        }  
	}

	public function actionEtoHistory(){
	 echo 'This is Incorrect URL. Please use below Nevigation to view Offer Details<br> '
            . 'Manage Buy Leads  >> Buy Lead Reports >> Buy Lead Search';exit;		
	}
	
        public function actionFeedback(){	
		$returnResult = array();
		$offer = $_REQUEST['offer'];		
		$empId = Yii::app()->session['empid'];
            if($empId > 0){
                    if($offer > 0)
                    {
                        $sth = $this->etoModel->feedback($offer);
exit;                    } 
                    else
                    {
                        echo 'Invalid Offer Id';exit;
                    }                
            }else{
                echo "You are not logged in";
                exit;
            }  
	}
	
	public function actionBuyLeads() {
            $params = $_REQUEST;		
            $empId = Yii::app()->session['empid'];
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
		$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);

		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		
            if(($empId > 0) && ($user_view ==1)){		
		$request = Yii::app()->request;
		$status = $request->getParam('status','');                
                $lvl_code='';
                $adm_lvl='';                
		if($empId){
                    $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                }
                
		$start = isset($params['start'])?$params['start']:'';
  		
		if((isset($params['do']) && $params['do'] == 'livelead') || isset($params['go'])){
                   $result =  $this->adminEtoSearch->showAdvSearchResultPG($request,$empId,$this->glModel,$this->statusDesc,$this->userStatusDesc,$start,$lvl_code,$adm_lvl,$status);
                }
		$this->render('/admineto/buyleads',array(
			'result'=>$result,
			'userStatusDesc'=>$this->userStatusDesc,
			'statusDesc' => $this->statusDesc,
			'lvl_code' => $lvl_code
			)
		);
            }else{
                echo "You are not logged in";
                exit;
            }  
	}
	public function actionShowDelReason(){
            $empId = Yii::app()->session['empid'];
            if($empId > 0){
		$request = Yii::app()->request;			
		$fromAnchor = $request->getParam('fromanchor',0);
		$redirectURL = $request->getParam('url','');
			
		$button = $request->getParam("button",'');
		
		$deleteResonResult = $this->etoModel->showOfferDelReasons($this->glModel,$request);		
		$result = $deleteResonResult['result'];
		$fromAnchor = $deleteResonResult['fromAnchor'];
		$redirectURL = $deleteResonResult['redirectURL'];
		$this->render("/admineto/offerdelreason",array("deleteResonResult"=>$result,'redirectURL' => $redirectURL,'fromAnchor'=> $fromAnchor,'button' => $button,'fromAnchor'=>$fromAnchor,'redirectURL'=>$redirectURL));
	    }else{
                echo "You are not logged in";
                exit;
            }                  
        }
	
	public function actiondelmulrecord(){
            $empId = Yii::app()->session['empid'];
            if($empId > 0){
		$request = Yii::app()->request;
		$q = $_REQUEST;		
		$start = $request->getParam('start','');
		$delmuloffers = $request->getParam('delmulOfrs','');		
		
                $lvl_code='';
                $adm_lvl='';                
		if($empId){
                    $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                }
                
                
		if(!empty($delmuloffers)){
			$delResult = $this->etoModel->delMulRecord($this->glModel,$request,$empId);
		}
		$status = 'W';               
		$result = $this->adminEtoSearch->showSearchResult($request,$empId,$this->glModel,$this->statusDesc,$this->userStatusDesc,$start,$lvl_code,$adm_lvl,$status);
		$this->render('/admineto/buyleads',array(
			'result'=>$result,
			'userStatusDesc'=>$this->userStatusDesc,
			'statusDesc' => $this->statusDesc,
			'lvl_code' => $lvl_code
			)
		);
            }else{
                echo "You are not logged in";
                exit;
            }
	}
	
	public function actionSaveGlusrDetails() {
            $empId = Yii::app()->session['empid'];
            if($empId > 0){
		$request = Yii::app()->request;
		$q = $_REQUEST;
		$empId = Yii::app()->session['empid'];
                if($empId > 0){
                    $updateResult = $this->etoModel->saveGlUsrDetails($request,$this->glModel,$empId);
                    if($updateResult == "FAIL"){
                            echo "Glusr Updation Failed.";	
                    }else{
                         echo "Glusr Updated Successfully.";	
                    }  
		 $resultData=$arr_map_ref = $arr_lvl_code=array();
                $fcpdetail=$vendor_name=$lvl_code=$approvPermit='';	
               $returnArr = array(		
		"lvl_code"=> $lvl_code,
		"valid"=>0,
		'result'=> $resultData,
		'arr_map_ref' => $arr_map_ref,
		'offerID' =>'' ,
		'emp_id' => $empId,
		'statusDesc' => $this->statusDesc,
		'userStatusDesc' => $this->userStatusDesc,
		'qtyListOther' => $this->qtyListOther,
		'qtyList' => $this->qtyList,
		'approvPermit' => $approvPermit,
		'vendor_name'=>$vendor_name,
                'fcpdetail'=> $fcpdetail,
                 'arr_lvl_code'=>  $arr_lvl_code
		);				
		$this->render("/admineto/editflaggedleads",$returnArr);
                }
            }else{
                echo "You are not logged in";
                exit;
            }    
	}
	
	public function actionViewEditEnrichment(){
            $empId = Yii::app()->session['empid'];
            mail("laxmi@indiamart.com","AdminEtoController : actionViewEditEnrichment Request","The employee id is $empId");
            
            if(isset($_REQUEST['bl_wait_pool_id']) && ($_REQUEST['bl_wait_pool_id']==-1)){
		$empemail= Yii::app()->session['empemail'];
		mail("laxmi@indiamart.com","Pool 7","The employee id is $empId and the email id is $empemail");
		echo "<b style='font-size:15px;color:red;padding-left:20px'>This screen has been disabled. Kindly Contact GLadmin team (gladmin-team@indiamart.com)<b>";exit;
            }
            if(isset($_REQUEST['bl_wait_pool_id']) && ($_REQUEST['bl_wait_pool_id']==1)){
                $empemail= Yii::app()->session['empemail'];
		mail("laxmi@indiamart.com","Pool 1","The employee id is $empId and the email id is $empemail");
		echo "<b style='font-size:15px;color:red;padding-left:20px'>This screen has been disabled. Kindly Contact GLadmin team (gladmin-team@indiamart.com)<b>";exit;
            }  
         
            if($empId > 0){
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
		
			$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);

		if(empty($user_permissions)){
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
			}
		
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{
		$request = Yii::app()->request;		
		$param['offerId'] = $request->getParam('offer',0);
		$param['field'] = $request->getParam('field','');		
                $param['allowPrem'] = 'N';		
		$path = $_SERVER['SERVER_NAME'];		
		$q = $_REQUEST;		
		$valid= 0;
		$lvl_code='';
                $adm_lvl='';               
		if(!empty($empId) && $empId>0) {
                    $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                    $valid = 1;    
                }                
		$permission = $this->model->getEmpAccess($request,$this->glModel,$empId);			
		if(isset($permission['CNT']) && !empty($permission['CNT'])){
			$param['allowPrem'] = 'Y';	
		}
		
		$recvaluerange = $this->model->getApproxOrderValue($this->glModel);
		$recvaluerangeIN = $recvaluerange['recvaluerangeIN'];
		$recvaluerangeFR = $recvaluerange['recvaluerangeFR'];
		$masterValues = $this->model->getMasterValues($this->glModel);
		
      $result = $this->etoModel->showPrevCallData($request,$param,$this->glModel);
      $resultData = $this->etoModel->editOffer($request,$empId,$path,$this->statusDesc,$this->userStatusDesc,'','','',$this->glModel);
      $mcat_id = isset($resultData['mcat_id'])?$resultData['mcat_id']:'';
      $resultArr = $this->etoModel->getIndustrySpecQuesDetails($request,$mcat_id);
   
      $NOBArr = $this->etoModel->NOB($param['offerId']);
       $modid=$_REQUEST['modid'];
  		$this->render("/admineto/vieweditenrichment",array(
  			"valid" => $valid,
  			"result" => $result,
  			"recvaluerangeFR" => $recvaluerangeFR,
  			"recvaluerangeIN" => $recvaluerangeIN,
  			"masterValues" => $masterValues,
  			"allowPrem" => $param['allowPrem'],  			
  			"lvl_code" => $lvl_code,
  			"resultArr"=>$resultArr,
  			"NOBArr"=>$NOBArr,
  			"modid"=>$modid
  			)
  		);
                
	 }else{
		echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
	 }
	}
	else{
            echo "You are not logged in";
            exit;
        }       
	}	
	
	public function actionUpdateCallData(){	
            $empId = Yii::app()->session['empid'];
            if($empId > 0){
			$request = Yii::app()->request;
			$fieldsArr= array();				
			 $path = $_SERVER['SERVER_NAME'];			 
			 $NOBVal=$_REQUEST['NOB'];
			 $OFFERID=$request->getParam('offer',0);
			 
			 $resultData = $this->etoModel->editOffer($request,$empId,$path,$this->statusDesc,$this->userStatusDesc,'','','',$this->glModel);
			 $mcat_id = isset($resultData['mcat_id'])?$resultData['mcat_id']:'';
			 $resultArr = $this->etoModel->getIndustrySpecQuesDetails($request,$mcat_id);
			 $re = $this->etoModel->updateCallData($request,$this->glModel,$resultArr,$mcat_id);
			 $modid=$_REQUEST['modid'];
			 
			 $this->etoModel->NOB_UPDATE($OFFERID,$NOBVal,$modid);			
			$this->redirect(Yii::app()->request->urlReferrer);
        }else{
            echo "You are not logged in";
            exit;
        }                 
	}
	public function actionmanualgrouplist()
	{
		
		$manualMcatResult = $this->etoModel->getManualGroupList($this->glModel);		
	}
	
	public function actionComplaint() {
		
		$complaintResult = $this->etoModel->showAllComplaint($this->glModel);
		$this->render("/admineto/complaint",array('complaintResult' => $complaintResult));
	}
	
	public function actionBlDeleteReason() {
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
			$referalUrl = Yii::app()->request->urlReferrer;
			$delReasons = array();
			$request = Yii::app()->request;
			$q = $_REQUEST;
			$valid= 1;
                        $delReasons = $this->etoModel->showOfferDelReasons($this->glModel,$request);
                        $this->render("/admineto/bldeletereasons",array('referalUrl' => $referalUrl, 'valid' => $valid,'delResult' => $delReasons,'loginPath' => $_SERVER['SERVER_NAME']));
            }else{
                echo "You are not logged in";
                exit;
            }                         
        }
	
	public function actionLeapDashboard() { 
	$empId =Yii::app()->session['empid'];	
    if($empId > 0) {	
    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
            
            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
            if($user_view==1)
            {
		$valid = 0;		
		$request = Yii::app()->request;
		$actionVal = $request->getParam("action",'');
		$permision = 0;
		$vendorArr = array();		
		$valid = 1;	
		$vendorRe = $this->leapdashboardModel->getLeapVendor($request,$empId);
		$permision = $vendorRe['permision'];
		$vendorArr = $vendorRe['vendorArr'];
		

		if($actionVal == 'generate')
		{
                        $rtype = $request->getParam('rtype','D');                    
                       if($rtype=='PMCAT'){
                            $displayTotalData = $this->leapdashboardModel->PMCAT($request,$vendorRe);
                         }elseif($rtype=='ISQFEEDBACK'){
                            $displayTotalData = $this->leapdashboardModel->ISQfeedback($request,$vendorRe);
                        }elseif($rtype=='TL'){
                            $displayTotalData = $this->leapdashboardModel->tlWiseDetail($request,$vendorRe);
                        }elseif($rtype=='AON'){ 
                            $displayTotalData = $this->leapdashboardModel->aonWiseDetail($request,$vendorRe,$empId);
                        }
                        elseif($rtype=='ISQ'){
                           // echo 'Due to heavy query execution time, this option is temporarily disabled till next update.';exit;
                           $displayTotalData = $this->leapdashboardModel->isqWiseDetail($request,$vendorRe,$empId);
                       }
                       elseif($rtype=='ISQFILLRATE'){
                          $displayTotalData = $this->leapdashboardModel->isqfillrate($request,$vendorRe,$empId);
                       }
                     else
                        {
			$displayTotalData = $this->leapdashboardModel->displayTotal($request,$vendorRe,$empId);
                       }			
			echo $displayTotalData;
			
			exit;
		} 
                else if($actionVal == 'empwisedetail')
		{
			$displayEmpWiseData = $this->leapdashboardModel->empWiseDetail($request,$vendorRe);                           
                        echo $displayEmpWiseData;
			exit;
		}
		else if($actionVal=='DNC')		
			{		
			$displayDNC = $this->leapdashboardModel->DNCdetail($request);		
			echo $displayDNC;		
				exit;
		}
                else if($actionVal=='REVIEWPOOL')		
			{		
			$displayreportemp = $this->leapdashboardModel->reviewpooldetailemp($request);		
			echo $displayreportemp;		
				exit;
		}
                else if($actionVal=='REVIEW')		
			{	
			$displayreport = $this->leapdashboardModel->reviewpooldetail($request);		
			echo $displayreport;		
				exit;
			
		}
		else if($actionVal == 'empwiseIsqdetail')
		{
			$displayEmpWiseIsqData = $this->leapdashboardModel->empWiseIsqDetail($request,$vendorRe);
			echo $displayEmpWiseIsqData;
			exit;
		}
		else if($actionVal == 'empwisedd')
		{
			$this->render("/admineto/empwisedeldump",array("request"=> $request));
			exit;
		}
		else if($actionVal == 'empwisead')
		{
			$this->render("/admineto/empwiseappdump",array('request'=>$request));
			exit;
		}else if($actionVal == 'export')
		{
			$exportApproval = $this->leapdashboardModel->exportToExcelApp($request);
			exit;
		}
		else if($actionVal == 'exportdel')
		{
			$exportDel = $this->leapdashboardModel->exportToExcelDel($request);
			exit;
		}
		else if($actionVal == 'exportNT')
		{       
			$exportDel = $this->leapdashboardModel->exportToExcelNT($request);
			exit;
		}
                else if($actionVal == 'exportAUTO')
		{       
			$exportDel = $this->leapdashboardModel->exportToExcelAUTO($request);
			exit;
		}
                else if($actionVal == 'exportisqfeedback')
		{       
			$exportDel = $this->leapdashboardModel->ISQfeedbackdetail($request,'export');
			exit;
		}
                else if($actionVal == 'isqfeedbackdetail')
		{       
			$arr = $this->leapdashboardModel->ISQfeedbackdetail($request,'report');
			$this->render("/admineto/isqfeedbackdump",array('result'=>$arr));
			exit;
		}
                else if($actionVal == 'exportpmcat')
		{       
			$arr = $this->leapdashboardModel->pmcat_agent($request,'export');
                        exit;
		}
                else if($actionVal == 'exportisqfillrate')
		{       
			$arr = $this->leapdashboardModel->isqfillrate_agent($request,'export');                        
			exit;
		}                
                else if($actionVal == 'PMCAT_tl')
		{       
			$arr = $this->leapdashboardModel->PMCAT_tl($request,'report');
			exit;
		}
                else if($actionVal == 'isqfillrate_tl')
		{       
			 $this->leapdashboardModel->isqfillrate_tl($request,'report');
                         exit;
		}
                else if($actionVal == 'isqfillrate_agent')
		{       
			$arr = $this->leapdashboardModel->isqfillrate_agent($request,'report');
			$this->render("/admineto/isqfillratedump",array('result'=>$arr));
			exit;
		}
                else if($actionVal == 'PMCAT_agent')
		{      
			$result=$this->leapdashboardModel->pmcat_agent($request,'report');
                        $this->render("/admineto/pmcatdump",array('result'=>$result));
			exit;
		}
               if($actionVal == "tlwiseflaggeddata"){
			$flaggedPendingData = $this->leapdashboardModel->FlaggedPendingData($permision,$vendorArr);	
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
			$displayAgentInfo = $this->leapdashboardModel->displayAgentInfo($request,$vendorArr);
			$this->render("/admineto/changeagent",array('result' => $displayAgentInfo,'action' => 'ch','vendorArr' => $vendorArr,'vendor' => $vendor,'agentstatus'=>$agentstatus));
			exit;
		}else if($actionVal == 'save')
		{
			$vendor = $request->getParam("vendor");
                        $agentstatus = $request->getParam("agentstatus");
			$re = $this->leapdashboardModel->saveAgentName($request,$empId);
			$displayAgentInfo = $this->leapdashboardModel->displayAgentInfo($request,$vendorArr);
			$this->render("/admineto/changeagent",array('succMsg'=>$re,'result' => $displayAgentInfo,'vendorArr' => $vendorArr,'vendor' => $vendor,'action' => 'ch','agentstatus'=>$agentstatus));
			exit;
		}
		else {
                    $showForm = $this->leapdashboardModel->showForm($request,$vendorRe); 
               }		
	       $returnArray = array(
				"loginPath" =>$_SERVER['SERVER_NAME'],		
				"valid" => $valid,		
				"vendorArr" => $vendorArr,		
				"permision" => $permision,		
				"showForm" => $showForm,
				"allVenders"=> $this->allVenders
			);
		$this->render("/admineto/leapapprovaldashboard",$returnArray);
    }else
    {
      echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
      exit;
    }            
    }else{
        echo "You are not logged in";
        exit;
    } 
} 
        
        public function actionDnccalling() { 
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
		$actionVal = $request->getParam("action",'');
		if($actionVal == 'detail')
		{       
                     $this->leapdashboardModel->DNCCallingdetail($request);
                    exit;
		}else{	      
			$this->leapdashboardModel->DNCCalling($request);
			exit;	
                }
	    }else{
                echo "You are not logged in";
                exit;
            }  	
               
	}
         public function actionreviewpool() {
             $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                $this->leapdashboardModel->reviewpool($request);
                exit;	
            }else{
                echo "You are not logged in";
                exit;
            }      
	}
        public function actionReviewpooldetail() { 
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                $displayreportemp = $this->leapdashboardModel->reviewpooldetail($request);		
		echo $displayreportemp;		
		exit;
                }else{
                echo "You are not logged in";
                exit;
            }  
	}
        
        public function actionReviewpooldetailemp() {  
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                $displayreportemp = $this->leapdashboardModel->reviewpooldetailemp($request);		
		echo $displayreportemp;		
		exit;
            }else{
            echo "You are not logged in";
            exit;
            }  
	}
       
        public function actionpendingreviewpool() { 
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                $this->leapdashboardModel->pendingreviewpool($request);
                exit;	
                }else{
            echo "You are not logged in";
            exit;
            }  
	}
        
        
        public function actionNtDashboard() { 
        $empId =Yii::app()->session['empid'];	
        if($empId > 0){ 
		$request = Yii::app()->request;
		$actionVal = $request->getParam("action",'');
		if($actionVal == 'export')
		{       
			$this->leapdashboardModel->exportToExcelNT($request);
			exit;
		}else{
                		      
			$this->render("/admineto/ntreport",array('request'=>$request));
			exit;		
                }
	}else{
                echo "You are not logged in";
                exit;
        } 		
	}
        
public function actionAutoDashboard() { 
        $empId =Yii::app()->session['empid'];	
        if($empId > 0){
		$request = Yii::app()->request;
		$actionVal = $request->getParam("action",'');
		if($actionVal == 'export')
		{       
			$this->leapdashboardModel->exportToExcelAUTO($request);
			exit;
		}else{
			$this->render("/admineto/autoreport",array('request'=>$request));
			exit;		
                }
		
	}else{
                echo "You are not logged in";
                exit;
        } 		
	}
        
	public function actionEmpAjax(){
        $empId =Yii::app()->session['empid'];	
        if($empId > 0){
			$request = Yii::app()->request;
			$result = $this->etoModel->getEmpDetail($request,$this->glModel);
			echo $result;
			exit;
        }else{
                echo "You are not logged in";
                exit;
        }             
	}
	
	public function actionAdminContact(){
        $empId =Yii::app()->session['empid'];	
        if($empId > 0){    
		$request = Yii::app()->request;
                $glusrid = $request->getParam("mem");
                if($glusrid > 0){
                    $glmodel= new GlobalmodelForm();
                    $userDet = $glmodel->get_glusr_detail($glusrid,'ALL');//print_r($userDet);
                    if(empty($userDet['GLUSR_USR_ID'])){
                       echo "<div><b style='font-size:15px;color:red;padding-left:20px'>Error in GL Detail Service for GLID: $glusrid</b></div>";exit;  
                    }else{
                        $this->render("/admineto/admincontact",array("userDet"=>$userDet));
                    }
               }
        }else{
                echo "You are not logged in";
                exit;
        }                   
	}
        public function actioncallMade30Days(){
        $empId =Yii::app()->session['empid'];	
        if($empId > 0){             
		$request = Yii::app()->request;
		$result = $this->etoModel->callMade30Days($request);
		exit;
        }else{
                echo "You are not logged in";
                exit;
        }                
	}
        
        public function actionTopIndex() {
            echo 'Please contact GLAdmin Team';
            die;		
	}
        
	public function actionPendingData()
	{
		
	  $empId =Yii::app()->session['empid'];	
            if($empId > 0){             
                $request = Yii::app()->request;
		$data=array();
		$rtype = $request->getParam('rtype','D');	
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';	
		$vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : '';	
		
		$dbh1 = '';
		$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId); 
		$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
		$redis=$pend_user=$pend_bl=$pendingtot_pred_sth=$arr_lvl_code='';  
		$mustcall=0;$dntcall=0;$service=0; $foreign=0;  $intentpool=0;$procmartpool=0; 
if($user_view==1)
      {
	

		if($rtype=='Detail')
		{ 
			
		
			$subtype=isset($_REQUEST['subtype']) ? $_REQUEST['subtype'] : '';
			$export=isset($_REQUEST['export']) ? $_REQUEST['export'] : '';
			$vendor=isset($_REQUEST['vendor']) ? $_REQUEST['vendor'] : ''; 
			
			
			$time=isset($_REQUEST['HR']) ? $_REQUEST['HR'] : '';
			$start_date=isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : '';
			$prtype=isset($_REQUEST['prtype']) ? $_REQUEST['prtype'] : '';
			if($export =='yes')
			{
				if($vendor =='BANREVIEW'){
					$data = $this->leapdashboardModel->banned_report($_REQUEST); 
					exit;
				}else
				{
					$data = $this->leapdashboardModel->predictive_rpt_detail($this->use_posgre,$subtype,$vendor,$time,$start_date,$prtype,$export); 
					exit;
				}
			}
			else
			{
				if($vendor =='BANREVIEW'){
					$data = $this->leapdashboardModel->banned_report($_REQUEST);
				$this->render("/admineto/pendingdatadetail",array('data' => $data,'subtype'=>$subtype,'vendor'=>$vendor,'start_date'=>$start_date,'prtype'=>$prtype,'time'=>$time,'mid'=>$mid));
				}
				else{
					$data = $this->leapdashboardModel->predictive_rpt_detail($this->use_posgre,$subtype,$vendor,$time,$start_date,$prtype,$export);
				$this->render("/admineto/pendingdatadetail",array('data' => $data,'subtype'=>$subtype,'vendor'=>$vendor,'start_date'=>$start_date,'prtype'=>$prtype,'time'=>$time,'mid'=>$mid));
				}
			}
		}
		else
		{ 
			if(isset($_REQUEST['btnsubmit']))
			{
				if($rtype=='R'){ 
					$pendingModel =  new PendingreportModel();
					$data = $pendingModel->pending_rag($request);
                                }elseif($rtype=='PT'){ 
					$etoModel =  new AdminEtoForm();
					$arr_lvl_code = $etoModel->getLeapEmpLVL($empId);
					$data = $this->leapdashboardModel->predictive_rpt($this->use_posgre,$request);            
                                }elseif($rtype=='P'){ 
									
					$etoModel =  new AdminEtoForm();
					$arr_lvl_code = $etoModel->getLeapEmpLVL($empId);
					$data = $this->leapdashboardModel->predictive_rpt($this->use_posgre,$request);        
				}elseif($rtype=='T'){ 
					$etoModel =  new AdminEtoForm();
					$arr_lvl_code = $etoModel->getLeapEmpLVL($empId);
					$data = $this->leapdashboardModel->timeliness_rpt(); 
				}elseif($rtype=='RT'){ 
					$etoModel =  new AdminEtoForm();
					$arr_lvl_code = $etoModel->getLeapEmpLVL($empId);
					$data = $this->leapdashboardModel->review_pool_timeliness_rpt();                                         
				}elseif($rtype=='PD')
				{
					$redis = $this->connectRedis();
					$etoModel =  new AdminEtoForm();
					$arr_lvl_code = $etoModel->getLeapEmpLVL($empId);
				}
				else{ 
                                      $data = $this->leapdashboardModel->getLead_dashboard_new($request,$this->glModel); 					
				} 
			}
			$this->render("/admineto/pendingdata",array('data' => $data,'rtype'=>$rtype,'redis'=>$redis,'pend_user'=>$pend_user,'pend_bl'=>$pend_bl,'pendingtot_pred_sth'=>$pendingtot_pred_sth,'arr_lvl_code'=>$arr_lvl_code));
		}   
    }else{
        echo "You do not have permission.";
            exit;
    }        
    }else{
            echo "You are not logged in";
            exit;
    }      
}
   Public function connectRedis()
    {
        $empId =Yii::app()->session['empid'];	
        if($empId > 0){
	$redis='';
	try {
		$obj = new Globalconnection();
		$redis = $obj->GetRedisConnForLeap();
		return $redis;
	} catch (Exception $e) {
		echo "<div style='text-align: center; margin-top: 20%;'>
		<hr>Connection Error: Please Contact Gladmin.
		<hr></div>";
		$msg =  $e->getMessage();
		mail("laxmi@indiamart.com", "JOBTASKS - Couldn't connected to Redis ", $msg);
		exit;
	}
            }else{
                echo "You are not logged in";
                exit;
        } 
        
        }	

  
     public function actionmultipleattachment(){
     $empId =Yii::app()->session['empid'];	
     if($empId > 0){
        $request = Yii::app()->request;
        $param['offerId'] = $request->getParam('offer',0);
	$param['field'] = $request->getParam('field','');
	$param['allowPrem'] = 'N';        
        $permission = $this->model->getEmpAccess($request,$this->glModel,$empId);
        $result = $this->etoModel->showPrevCallData($request,$param,$this->glModel);
		if(isset($permission['CNT']) && !empty($permission['CNT'])){
			$param['allowPrem'] = 'Y';	
		}
     
		$offer=$_REQUEST['offer'];
		$attach_id=isset($_REQUEST['attach_id']) ? $_REQUEST['attach_id'] : '';
		$atttachsth = $this->etoModel->multipleattachment($offer);		
                if($this->use_posgre ==1){
                    $this->render("/admineto/multipleattachment_pg",array('atttachsth'=>$atttachsth,'offer'=>$offer,"result" => $result,"allowPrem" => $param['allowPrem']));
                }else{
		$this->render("/admineto/multipleattachment",array('atttachsth'=>$atttachsth,'offer'=>$offer,"result" => $result,"allowPrem" => $param['allowPrem']));
	}
    }else{
            echo "You are not logged in";
            exit;
    } 
    }
	
public function actionmultipleattachment_del(){
     $empId =Yii::app()->session['empid'];	
     if($empId > 0){
        $request = Yii::app()->request;
        $param['offerId'] = $request->getParam('offer',0);
	$param['field'] = $request->getParam('field','');
	$param['allowPrem'] = 'N';
        $empId = Yii::app()->session['empid'];
        $permission = $this->model->getEmpAccess($request,$this->glModel,$empId);
        $result = $this->etoModel->showPrevCallData($request,$param,$this->glModel);
		if(isset($permission['CNT']) && !empty($permission['CNT'])){
			$param['allowPrem'] = 'Y';	
		}
		$offer=$_REQUEST['offer'];
		$attach_id=isset($_REQUEST['attach_id']) ? $_REQUEST['attach_id'] : '';
		 $this->etoModel->multipleattachment_del($offer,$attach_id);
		 $atttachsth = $this->etoModel->multipleattachment($offer);	
		 $this->render("/admineto/multipleattachment",array('atttachsth'=>$atttachsth,'offer'=>$offer,"result" => $result,"allowPrem" => $param['allowPrem']));
    }else{
            echo "You are not logged in";
            exit;
    } 		 		
}
public function actionBannedeyword()
    {    
    $empId =Yii::app()->session['empid'];   
        if($empId > 0) {
     $data = $this->etoModel->banned_keywords();
     echo $data;
     exit;
     }else{
          echo "You are not logged in";
          exit;
        }
    }
    	

    public function actionAttemptreport(){   
    $empId =Yii::app()->session['empid'];	
     if($empId > 0){
        echo 'Report has been disabled. Please contact GLADMIN Team';die;
    } 
    }
    
    public function actiondownloadmcatna()
    {
     $empId =Yii::app()->session['empid'];	
     if($empId > 0){
      $XLdata[0][0]='Display ID';
      $XLdata[0][2]='DATE RECEIVED';
      $XLdata[0][3]='KEYWORDS';
      $XLdata[0][4]='Source';
      $data=isset($_REQUEST['data']) ? $_REQUEST['data'] : '';
      if($data=='current')
      {
       $date_time = strtoupper(date("M_Y"));
       $name=$date_time."_LEAP_MCAT_NA.txt";
      }
      else
      {
       $date_time = strtoupper(date("M_Y",strtotime("-1 months")));
       $name=$date_time."_LEAP_MCAT_NA.txt";
      }
      $filename_input   = "/home3/indiamart/public_html/excel_upload/mcat_na/$name";
      $myfile = fopen($filename_input, "r") or die("No Data Available for this Month");
      $data= fread($myfile,filesize($filename_input));
      $data=explode('@@',$data);
      for($i=0;$i<count($data)-1;$i++)
      {
       $EachRow=$data[$i];
       $EachRow=explode('##',$EachRow);
       $j=$i+1;
       $XLdata[$j][0]=$EachRow[0];
       $XLdata[$j][1]=$EachRow[2];
       $XLdata[$j][2]=$EachRow[3];
       $XLdata[$j][4]='LEAP';
      }
       Yii::import('application.extensions.phpexcel.JPhpExcel');
                $xls = new JPhpExcel('UTF-8', false, 'MCAT_NA');
                $xls->addArray($XLdata);
                $xls->generateXML('MCAT_NA');
       fclose($myfile);
      exit;
    }else{
    echo "You are not logged in";
    exit;
    } 
    }
public function actionHourlydata() {    
    echo 'Please contact GLAdmin Team';
    die;
}

public function actionempwisedetail(){
      $empId =Yii::app()->session['empid'];   
        if($empId > 0) {   
           $request = Yii::app()->request;
                        $vendor = $request->getParam('vendor','ALL');
                        if($vendor=='CONNECT_C2C' || $vendor=='OAP_PD'){
			$displayEmpWiseData = $this->leapdashboardModel->empWiseDetail_oap($request,'');
                        }else{
			$displayEmpWiseData = $this->leapdashboardModel->empWiseDetail($request,'');                           
                        }
           echo $displayEmpWiseData;
           exit;
        }else{
          echo "You are not logged in";
          exit;
        }
  }       
   public function actionIsqfillrate() { 
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                 echo $displayTotalData = $this->leapdashboardModel->isqfillrate($request,'',$empId);
		exit;
                }else{
                echo "You are not logged in";
                exit;
            }  
	}
   public function actionIsq() { 
            $empId =Yii::app()->session['empid'];	
  	    if($empId > 0) {
		$request = Yii::app()->request;
                echo $displayTotalData = $this->leapdashboardModel->isqWiseDetail($request,'',$empId);
		exit;
                }else{
                echo "You are not logged in";
                exit;
            }  
	}
 public function actionTestpg()
    {
         $model = new GlobalmodelForm();
         $obj = new Globalconnection();
         $dbh_pg = pg_pconnect("34.68.148.19 port=5432 dbname=blhistory user=imbuylead password=blhistdb4iil") or die('cant connnect to postgresql: '.pg_last_error());

           if($dbh_pg){
               echo 'connected';
           }else{
              echo 'not connected';
           }die;
            }
Public function actionRedismlbl()
    {
    $offer_id=12334;
    mail("laxmi@indiamart.com","Redismlbl-test","$offer_id");
    $response='';
        $old_title='test';
        $old_desc='testnew';
                $title = 'title';
		$desc = 'titlenew';
		if(!empty($title)){
			$title = substr($title,0,100);
			$title = preg_replace("/\'/","''",$title);
			$title = preg_replace("/&nbsp;/"," ",$title);
			if(preg_match('/%u([0-9A-F]+)/', $title)){
				$title = preg_replace('/%u([0-9A-F]+)/', ' ', $title);
			}
			$title = htmlspecialchars_decode($title);
		}
		if (!empty($desc)) {
		            $desc = preg_replace("/<br \/>/","\n",$desc);
			    $desc = preg_replace("/(\n){2,}/","\n\n",$desc);
			    $desc = preg_replace("/\?/"," ",$desc);
			    $desc = preg_replace('/[^A-Za-z0-9 !@#$%^&*().]\'/u','', strip_tags($desc));
			    $desc = preg_replace("/&lsquo/"," ",$desc);
			    $desc = preg_replace("/&ldquo/"," ",$desc);
			    $desc = preg_replace("/&rdquo/"," ",$desc);			    
			    $desc = preg_replace("/&rsquo/"," ",$desc);			    
			    $desc = preg_replace("/&nbsp;/"," ",$desc);			    	    
	    
			    
			    if(preg_match('/%u([0-9A-F]+)/', $desc)){
					$desc = preg_replace('/%u([0-9A-F]+)/', ' ', $desc);
			    }	    
			    $desc = htmlspecialchars_decode($desc);
			    $desc = preg_replace("/'/","''",$desc);
			    $desc = trim($desc);

			    $desc = substr($desc,0,3990);
		}

        if(($old_title != $title) || ($old_desc != $desc)){          

	if(isset($_SERVER['SERVER_NAME']) && (($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') ||  ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') ))
		{ 
			$ip = "dev-ml-pub-api.intermesh.net:8082";
                }
		else
		{ 
			$ip = "ml-pub-api.intermesh.net:8082";
		}
		$data=array();
		$updatedData = array();
		$tempData = array();
		$data['ETO_OFR_DISPLAY_ID'] = $offer_id;
		if($old_title != $title)
		{
			$tempData['VALUE_CHANGED'] = 'ETO_OFR_TITLE';
			$tempData['OLD_VALUE'] = $old_title;
			$tempData['NEW_VALUE'] = $title;
			array_push($updatedData,$tempData);
		}
		if($old_desc != $desc)
		{
			$tempData['VALUE_CHANGED'] = 'ETO_OFR_DESCRIPTION';
			$tempData['OLD_VALUE'] = $old_desc;
			$tempData['NEW_VALUE'] = $desc;
			array_push($updatedData,$tempData);
		}
		$data['DATA'] = $updatedData;
		$data['mod_id'] = 'GLADMIN';
		$qname = "ETO_OFR_DETAILS_MODIFY_QUEUE";
		$dataJson = json_encode($data);

			$rid = uniqid();
			$rmq_url = "http://".$ip."/rmq/publish";
			$content = array(
				"qname" => $qname,
				"rservice" => "GLADMIN",	
				"rid" => $rid,
				"msg" => $dataJson
			);

    try
    {
          //  $serv_model=new ServiceGlobalModelForm();
          //   $dataHash = $serv_model->mapiService('Odioiq',$rmq_url,$content,'No');
            $ch = curl_init($rmq_url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);

            $json_response = curl_exec($ch);
            $curl_info = curl_getinfo($ch);

            $response = json_decode($json_response, true);
echo '<pre>';print_r($curl_info);
print_r($content);print_r($response);die;
            $ht=$offer_id.'=='.$rmq_url.'=='.$curl_info['http_code'];
mail("laxmi@indiamart.com","Redismlbl",$ht);
        if(isset($response['status']) && $response['status'] == 'Success')
        {
                $response = 'INSERT SUCCESS';
        } 
        else 
        {
            $response = 'INSERT Error';
        }
    }
    catch(Exception $e) 
    {
        $response = 'INSERT FAILURE - Exception: ' . $e->getMessage();
        $error=$e->getMessage();
        mail("laxmi@indiamart.com","INSERT FAILURE - Exception:","$error ");
    }
        echo  $response;
    }
}
    
            
                       
}