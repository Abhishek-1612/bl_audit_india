<?php
class TemplateModel extends CFormModel
{
	public function modulenames($data)
	{

		// Service Implementation MAPI
		$serv_model = new ServiceGlobalModelForm();
		$param['emp_id'] = isset($data['emp_id']) ? $data['emp_id'] : 0;
		$param['flag'] = 'email';

		$host_name = $_SERVER['SERVER_NAME'];
		if ($host_name == 'dev-gladmin.intermesh.net'){
			$curl = 'http://stg-mapi.indiamart.com/wservce/esn/module/';//http://162.217.96.117:8187/esn/module
		}elseif ($host_name == 'stg-gladmin.intermesh.net') {
			$curl = 'http://stg-mapi.indiamart.com/wservce/esn/module/';
		}else{
			$curl = 'http://users.imutils.com/wservce/esn/module/';
		}
		$response=$serv_model->mapiService('READMODULE',$curl,$param,'No');
		// print_r($response);
		$code=isset($response["Code"])?$response["Code"]:'';
		$data=isset($response["data"])?$response["data"]:'';
		$total=count($data);
		// print_r($data);
		// exit();
		return $data;
	}
	public function processnames($data)
	{
		$moduleid=isset($_REQUEST['moduleid']) ? $_REQUEST['moduleid'] : 1;
		// $end=isset($_REQUEST['end']) ? $_REQUEST['end'] : 10;
		$module_id=isset($_REQUEST['searchtype']) ? $_REQUEST['searchtype'] : '';
		// echo "dispForm<pre>";
		// print_r($data);

		// Service Implementation MAPI
		$serv_model = new ServiceGlobalModelForm();
		$param['emp_id'] = isset($data['emp_id']) ? $data['emp_id'] : 0;
		$param['module'] = isset($data['moduleid']) ? $data['moduleid'] : 0;
		$param['flag'] = 'email';
		$host_name = $_SERVER['SERVER_NAME'];
		if ($host_name == 'dev-gladmin.intermesh.net'){
			$curl = 'http://stg-mapi.indiamart.com/wservce/esn/processes/';//http://162.217.96.117:8187/esn/processes
		}elseif ($host_name == 'stg-gladmin.intermesh.net') {
			$curl = 'http://stg-mapi.indiamart.com/wservce/esn/processes/';
		}else{
			$curl = 'http://users.imutils.com/wservce/esn/processes/';
		}
		$response=$serv_model->mapiService('READPROCESS',$curl,$param,'No');
		// exit();
		// echo "dispForm<pre>";
		// print_r($response);
		$code=isset($response["Code"])?$response["Code"]:'';
		$data=isset($response["data"])?$response["data"]:'';
		// $total=isset($response["DATA"]['total'])?$response["DATA"]['total']:'';
		// print_r($data);
		// exit();
		return $data;
	}
	public function templatenames($data)
	{

		// Service Implementation MAPI
		$serv_model = new ServiceGlobalModelForm();
		$param['emp_id'] = isset($data['emp_id']) ? $data['emp_id'] : 0;
		$param['procId'] = isset($data['procId']) ? $data['procId'] : 0;
		$param['flag'] = 'email';
		$host_name = $_SERVER['SERVER_NAME'];
		if ($host_name == 'dev-gladmin.intermesh.net'){
			$curl = 'http://stg-mapi.indiamart.com/wservce/esn/template/';//http://162.217.96.117:8187/esn/template
		}elseif ($host_name == 'stg-gladmin.intermesh.net') {
			$curl = 'http://stg-mapi.indiamart.com/wservce/esn/template/';
		}else{
			$curl = 'http://users.imutils.com/wservce/esn/template/';
		}
		$response=$serv_model->mapiService('READTEMPLATE',$curl,$param,'No');
		// exit();
		$code=isset($response["Code"])?$response["Code"]:'';
		$data=isset($response["data"])?$response["data"]:'';
		// $total=isset($response["DATA"]['total'])?$response["DATA"]['total']:'';
		// print_r($data);
		// exit();
		return $data;
	}
	public function templateADD($data)
	{

		// Service Implementation MAPI
		$serv_model = new ServiceGlobalModelForm();
		$param['serviceurl'] = 'esn/template';
		$param['emp_id'] = isset($data['emp_id']) ? $data['emp_id'] : 0;
		$param['moduleId'] = isset($data['moduleID']) ? $data['moduleID'] : 0;
		$param['processId'] = isset($data['processID']) ? $data['processID'] : 0;
		$param['purpose'] = isset($data['purpose']) ? $data['purpose'] : '';;
		$param['shortName'] = isset($data['shortName']) ? $data['shortName'] : '';
		$param['fromName'] = isset($data['from']) ? $data['from'] : '';
		$param['fromEmail'] = isset($data['fromEmail']) ? $data['fromEmail'] : '';
		$param['subject'] = isset($data['subject']) ? $data['subject'] : '';
		$param['html'] = rawurlencode(isset($data['htmlval']) ? $data['htmlval'] : '');//isset($data['htmlval']) ? $data['htmlval'] : '';//
		$param['act'] = isset($data['act']) ? $data['act'] : '';
		$param['flag'] = 'email';
		$param['AK'] = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
		// $param['templateId'] = isset($data['templateID']) ? $data['templateID'] : 0;
		$param['category'] = isset($data['category']) ? $data['category'] : '';
		$host_name = $_SERVER['SERVER_NAME'];
		$response=$serv_model->wapiServiceOpAPI($param);//('UPDATETEMPLATE',$curl,$param,'No');
		
		// exit();
		// $response = json_decode($response);
		$code=isset($response["Code"])?$response["Code"]:'';
		$message=isset($response["Message"])?$response["Message"]:'';
		// $total=isset($response["DATA"]['total'])?$response["DATA"]['total']:'';
		// print_r($response);
		// exit();

		return $response;
	}
	public function templateUPDATE($data)
	{

		// Service Implementation MAPI
		$serv_model = new ServiceGlobalModelForm();
		$param['serviceurl'] = 'esn/template';
		$param['emp_id'] = isset($data['emp_id']) ? $data['emp_id'] : 0;
		$param['moduleId'] = isset($data['moduleID']) ? $data['moduleID'] : 0;
		$param['processId'] = isset($data['processID']) ? $data['processID'] : 0;
		$param['purpose'] = isset($data['purpose']) ? $data['purpose'] : '';;
		$param['shortName'] = isset($data['shortName']) ? $data['shortName'] : '';
		$param['fromName'] = isset($data['from']) ? $data['from'] : '';
		$param['fromEmail'] = isset($data['fromEmail']) ? $data['fromEmail'] : '';
		$param['subject'] = isset($data['subject']) ? $data['subject'] : '';
		$param['html'] = rawurlencode(isset($data['htmlval']) ? $data['htmlval'] : '');//isset($data['htmlval']) ? $data['htmlval'] : '';//
		$param['act'] = isset($data['act']) ? $data['act'] : '';
		$param['flag'] = 'email';
		$param['templateId'] = isset($data['templateID']) ? $data['templateID'] : 0;
		$param['category'] = isset($data['category']) ? $data['category'] : '';
		// echo "skdjjvbsklzdjvbkjdfkl";
		// print_r($param);
		// $param['emp_id'] = isset($data['emp_id']) ? $data['emp_id'] : 0;
		// $param['procId'] = isset($data['procId']) ? $data['procId'] : 0;
		$host_name = $_SERVER['SERVER_NAME'];
		$response=$serv_model->wapiServiceOpAPI($param);//('UPDATETEMPLATE',$curl,$param,'No');
		// exit();
		// $response = json_decode($response);
		$code=isset($response["Code"])?$response["Code"]:'';
		$message=isset($response["Message"])?$response["Message"]:'';
		// $total=isset($response["DATA"]['total'])?$response["DATA"]['total']:'';
		// print_r($response);
		// exit();
		return $response;
	}
	public function templateAPPROVE($data)
	{
		// Service Implementation MAPI
		$serv_model = new ServiceGlobalModelForm();
		$param['serviceurl'] = 'esn/template';
		$param['emp_id'] = isset($data['emp_id']) ? $data['emp_id'] : 0;
		$param['moduleId'] = isset($data['moduleID']) ? $data['moduleID'] : 0;
		$param['processId'] = isset($data['processID']) ? $data['processID'] : 0;
		$param['purpose'] = isset($data['purpose']) ? $data['purpose'] : '';;
		$param['shortName'] = isset($data['shortName']) ? $data['shortName'] : '';
		// $param['fromName'] = $processname;
		$param['fromEmail'] = isset($data['fromEmail']) ? $data['fromEmail'] : '';
		$param['subject'] = isset($data['subject']) ? $data['subject'] : '';
		$param['html'] = urlencode(isset($data['htmlval']) ? $data['htmlval'] : '');//isset($data['htmlval']) ? $data['htmlval'] : '';//
		$param['act'] = isset($data['act']) ? $data['act'] : '';
		$param['flag'] = 'email';
		$param['templateId'] = isset($data['templateID']) ? $data['templateID'] : 0;
		$param['category'] = isset($data['category']) ? $data['category'] : '';
		$host_name = $_SERVER['SERVER_NAME'];
		$response=$serv_model->wapiServiceOpAPI($param);//('UPDATETEMPLATE',$curl,$param,'No');
		// exit();
		// $response = json_decode($response);
		$code=isset($response["Code"])?$response["Code"]:'';
		$message=isset($response["Message"])?$response["Message"]:'';
		// $total=isset($response["DATA"]['total'])?$response["DATA"]['total']:'';
		// print_r($response);
		// exit();

		return $response;
	}
}
