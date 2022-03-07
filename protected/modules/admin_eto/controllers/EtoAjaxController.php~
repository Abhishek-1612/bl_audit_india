<?php 
class EtoAjaxController extends Controller
{
	public $ajaxModel;
	public $glModel;
	public function init(){
		$this->ajaxModel = new AdminEtoAjaxModel();	
		$this->glModel =  new GlobalmodelForm();
	}
	
	public function actionGetCityState(){
		die("here");
		$request = Yii::app()->request;
		$params = array();
		//$params['c_iso'] = $request->getParam('C','');
		//$params['s_id'] = $request->getParam('S','');
		$params['action'] = $request->getParam('action','');
		//$params['city'] = $request->getParam('city','');
		//$params['state'] = $request->getParam('state','');
		if($params['action'] == "city"){
			$cityResult = $this->ajaxModel->getCity($params,$this->glModel);
var_dump($cityResult);die;			
			if(!empty($cityResult)){
			    echo $cityResult;
			    exit;
			}
		}
					
	}
	
	public function actionCheckDuplicateMobile(){
		$checkDupMobile = array();
		if(Yii::app()->request->isAjaxRequest){
			$request = Yii::app()->request;
			$param['glusrID'] = $request->getParam('glusrID','');
			$param['glusrPhCntryCode'] = $request->getParam('glusrPhCntryCode','');
			$param['glusrPhMobile'] = $request->getParam('glusrPhMobile','');
			$checkDupMobile = $this->ajaxModel->checkDuplicateMobile($param,$this->glModel);
		}
		echo json_encode($checkDupMobile);
		exit;	
	}
}