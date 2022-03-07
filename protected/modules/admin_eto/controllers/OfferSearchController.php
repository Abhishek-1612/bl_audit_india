<?php 
class OfferSearchController extends Controller
{
	
	public function actionofrSearch(){
                        echo 'screen stopped';

            $empId = Yii::app()->session['empid'];                
            if($empId > 0){
	       if(isset($_REQUEST['mem']) and !empty($_REQUEST['mem']) and $_REQUEST['mem']>0 and isset($_REQUEST['Product'])&& $_REQUEST['Product']=='detail')
		{
                  $data=$etoModel->producDetail($_REQUEST['mem']);
		  $this->render("/admineto/productWebuy",array('data'=>$data));
		  die;
		}
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
                $user_permissions=  GL_LoginValidation::CheckModulePermission($mid, $empId);
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
                $vendor_name='';$subCategory=array();$temp_group=array();
                $etoModel =  new AdminEtoForm();
                $adminEtoSearch=new AdminEtoSearch();
		if($empId){
                    $arr_lvl_code = $etoModel->getLeapEmpLVL($empId);             
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
		  $data=$etoModel->supplier_connected('');
		  $this->render('/admineto/postedreport',array('data'=>$data));
		 //var_dump($data);
		 die;
		}
		$start = isset($params['start'])?$params['start']:'';
          $reArr = array(
		"vendor_name"=>$vendor_name,
              "param"=>$_REQUEST);		
		$this->render("/admineto/ofrsearch",$reArr);
                
                
          if($request->getParam("go") || $request->getParam("action")){ 
                       $callfrom='adv_search';
                       $stype = $request->getParam('stype','');
                       $glModel =  new GlobalmodelForm();
                      if($stype =='ADV' || trim($request->getParam('mem','')) !='' || trim($request->getParam('offer',0)) > 0 || trim($request->getParam('memmail','')) !='' || trim($request->getParam('memmobile',0)) > 0 || trim($request->getParam('mcat_id',0)) >0) {
                          $result =  $adminEtoSearch->showAdvSearchResult($request,$empId,$glModel,'','',$start,$lvl_code,$adm_lvl,$status);
                       }
                       else{                       
                           $result =  $adminEtoSearch->showSearchResult($request,$empId,$glModel,'','',$start,$lvl_code,$adm_lvl,$status);
                       }
                       
                      $conncetedcount=array();
                      $conncetedcount=$etoModel->supplier_connected($result['rec']);
                      $recResult = $result['rec'];                      
                      $statusDesc = array(
					'W'=>'Waiting',
					'A'=>'Approved'	
                        );
                        $userStatusDesc = array(
                                                'W'=>'Waiting',
                                                'A'=>'Approved',
                                                'D'=>'Disabled',
                                                'M'=>'Error Disabled'
                        );
                       $this->render('/admineto/buyleads',array(
			'result'=>$result,
			'userStatusDesc'=>$userStatusDesc,
			'statusDesc' => $statusDesc,
			'lvl_code' => $lvl_code,			
                         'callfrom'=>$callfrom,
			'conncetedcount'=>$conncetedcount,
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
                        echo 'screen stopped';

            $request = Yii::app()->request;	
            $empId = Yii::app()->session['empid'];                
            if($empId > 0){	       
                $lvl_code=''; 
                $etoModel =  new AdminEtoForm();
                $adminEtoSearch=new AdminEtoSearch();
		if($empId){
                    $arr_lvl_code = $etoModel->getLeapEmpLVL($empId);             
                    if(isset($arr_lvl_code['ETO_LEAP_EMP_LEVEL']) && $arr_lvl_code['ETO_LEAP_EMP_LEVEL'] >= 2){
                                    $lvl_code='E';
                        }elseif(isset($arr_lvl_code['ETO_LEAP_VENDOR_NAME']) && ($arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'NOIDA' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'DDN' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'KOCHARTECHLDH' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'COGENTINBOUND' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEPNSTOBL' || $arr_lvl_code['ETO_LEAP_VENDOR_NAME'] == 'RADIATEINTENT')){                                       
                                    $lvl_code='V';                                        
                        }
                }	
                
                if(trim($request->getParam('mem','')) !='' || trim($request->getParam('offer',0)) > 0 || trim($request->getParam('memmail','')) !='' || trim($request->getParam('memmobile',0)) > 0 || trim($request->getParam('mcat_id',0)) > 0) {
                                $result =  $adminEtoSearch->showAdvSearchResultFenq($request);  
                                $statusDesc = array(
					'W'=>'Waiting',
					'A'=>'Approved'	
                        );
                        $userStatusDesc = array(
                                                'W'=>'Waiting',
                                                'A'=>'Approved',
                                                'D'=>'Disabled',
                                                'M'=>'Error Disabled'
                        );
                                 $this->render('/admineto/buyleads_arch',array(
                                  'result'=>$result,
                                  'userStatusDesc'=>$userStatusDesc,
                                   'statusDesc' => $statusDesc,
                                   'lvl_code'=>$lvl_code,
                                  )
                          );exit;
          }
        }else{
            echo "You are not logged in";
            exit;
        }  
	}

}