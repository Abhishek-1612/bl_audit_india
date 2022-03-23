<?php
error_reporting(1);
class AdminReportController extends Controller
{	
	public function actionLeapActivityStats(){

		$request = Yii::app()->request;
		$etoModel =  new AdminReportModel();
		$action = $request->getParam("action",'show');
		$offerID = '';
		$statsResult='';

		if($action == 'offerwise')
		{	
			echo 'This Option has been disabled. Please contact GLAdmin Team.';
			$empid = Yii::app()->session['empid'];
			mail("laxmi@indiamart.com","actionLeapActivityStats call - offerwise","$empid");
			//$statsResult = $etoModel->getLeapActivityOfrWise($request);
			$offerID = $request->getParam("offerID",'');
		}
		else if($action == 'offerdetail')
		{	
                       $statsResult = $etoModel->getLeapActivityOfrDetail($request);
			$offerID = $request->getParam("offerID",'');
		}
                
		$this->render("/admineto/leapactivity",array(
                	'result' => $statsResult,
			'offerID' => $offerID,
			'action' => $action
                ));
	}	
}