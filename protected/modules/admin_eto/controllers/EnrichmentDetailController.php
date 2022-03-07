<?php  
class EnrichmentDetailController extends Controller
{
	
	public $statusDesc = array();
	public $userStatusDesc = array();
	public $model = '';
	public $etoModel = '';
	public $glModel = '';
	 
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
                 $this->etoModel =  new AdminEtoForm();  
                $this->model =  new AdminEtoModelForm();
		$this->glModel =  new GlobalmodelForm();
	 }
	
public function actionViewEnrichment(){		
		$request = Yii::app()->request;		
		$param['offerId'] = $request->getParam('offer',0);
		$param['field'] = $request->getParam('field','');
		$param['allowPrem'] = 'N';		
		$path = $_SERVER['SERVER_NAME'];
		$valid= 0;
		$lvl_code='';            
                $empId = Yii::app()->session['empid'];
		if(!empty($empId) && $empId > 0) {
                    $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                    $valid = 1;                    
                    $masterValues = $this->model->getMasterValues($this->glModel);
		
      $result = $this->etoModel->showPrevCallData($request,$param,$this->glModel);
      $rec = isset($result['rec'])?$result['rec']:'';
      $approveby=isset($rec['EMP_ID']) ? $rec['EMP_ID'] : '';
      if($approveby == -11){
          $lvl_code='E';
      }
      
      $mcat_id = isset($rec['FK_GLCAT_MCAT_ID'])?$rec['FK_GLCAT_MCAT_ID']:'';
      $resultArr = $this->etoModel->getIndustrySpecQuesDetails($request,$mcat_id); 
      if($empId==3575){echo $mcat_id.'<pre>';
        print_r($resultArr);echo '</pre>';
      }
      $modid=$_REQUEST['modid'];
          
            		$this->render("/admineto/viewenrichmentnew",array(
  			"result" => $result,  			
  			"masterValues" => $masterValues,
  			"lvl_code" => $lvl_code,
  			"resultArr"=>$resultArr,
  			"modid"=>$modid
  			)
  		);     
		
        }else{
            echo "You are not logged in. Please login again";die;
        } 
   }
   
    public function actionUpdateEnrichData(){			
			$request = Yii::app()->request;
			$fieldsArr= array();	
			 $empId =Yii::app()->session['empid'];
			 $path = $_SERVER['SERVER_NAME'];
			 
			 //$NOBVal=$_REQUEST['NOB'];
			 $OFFERID=$request->getParam('offer',0);
			 
			 $resultData = $this->etoModel->editOffer($request,$empId,$path,$this->statusDesc,$this->userStatusDesc,'','','',$this->glModel);
			 $mcat_id = isset($resultData['mcat_id'])?$resultData['mcat_id']:'';
			 $resultArr = $this->etoModel->getIndustrySpecQuesDetails($request,$mcat_id);
                         $enrichform= new EnrichEtoForm();
			 $re = $enrichform->updateCallData($request,$this->glModel,$resultArr,$mcat_id);
			 $modid=$_REQUEST['modid'];
                    // Display data 
                        $param['offerId'] = $request->getParam('offer',0);
                        $param['field'] = $request->getParam('field','');
                        $param['allowPrem'] = 'N';
                
                    $arr_lvl_code = $this->etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                    $valid = 1;
                    $masterValues = $this->model->getMasterValues($this->glModel);
		
                    $result = $this->etoModel->showPrevCallData($request,$param,$this->glModel);
                    $rec = $resultData['rec'];
                    $approveby=isset($rec['GL_EMP_ID']) ? $rec['GL_EMP_ID'] : '';
                    if($approveby == -11){
                        $lvl_code='E';
                    }
                    $modid=$_REQUEST['modid'];

                                      $this->render("/admineto/viewenrichmentnew",array(
                                      "result" => $result,
                                      "masterValues" => $masterValues,
                                      "lvl_code" => $lvl_code,
                                      "resultArr"=>$resultArr,
                                       "modid"=>$modid
                                      )
                              ); 
	}
        
        
        
        
}