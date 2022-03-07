<?php
class TemplateController extends Controller
{
	public function actionIndex()
	{
		$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
		if(!$emp_id){
			print "Your are not logged in";
			exit;
		}
		else
		{
			if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"]))
			{

				if(!empty($_REQUEST["mid"]))
				{
					$mid = $_REQUEST["mid"];
					$_REQUEST['emp_id']=$emp_id;
					$model = new GlobalmodelForm();
					$dbh1 ='';
					$user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
					$field_permissions = $model->CheckFieldPermission('',$mid,$emp_id);
					// if ($emp_id == 68244 || $emp_id == 72208)
					// {
					// 	echo "<pre>";
					// 	print_r($field_permissions);
					// 	// exit;
					// }
					// else
					// {
					// 	echo "Module is under Development";
					// 	exit();
					// }
					$approve_show = (isset($field_permissions['IIL_TEMPLATE_MESSAGE']['IIL_TEMPLATE_STATUS']) && ($field_permissions['IIL_TEMPLATE_MESSAGE']['IIL_TEMPLATE_STATUS'] != 'readonly')) ? 1:0;
				}
				$template_model_obj= new TemplateModel();

				if($user_permissions['TOVIEW'] == 1)
				{
					$mid = $_REQUEST["mid"];
					$model = new GlobalmodelForm();
					$dbh1 ='';
					$user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
					$user_permissions['TOADD'] = 1;
					$template_model_obj = new TemplateModel();
					$moduleID = isset($_REQUEST['moduleID']) ? $_REQUEST['moduleID'] : '';
					$auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
					// echo "--".$auth_key."--";
					$give_process_data = array(
						'emp_id' => $emp_id,
						'moduleid' => $moduleID
					);
					$processnames_data = array();
					if ($moduleID != '')
					{
						$processnames_data = $template_model_obj->processnames($give_process_data);
					}

					$give_module_data = array(
						'emp_id' => $emp_id
					);
					$modulenames_data = $template_model_obj->modulenames($give_module_data);
					$this->renderPartial('TemplateMainScreen', array('module_data'=>$modulenames_data,'module_data_selected'=>$moduleID,'process_data'=>$processnames_data,'mid'=>$_REQUEST['mid'],'edit_permission'=>$user_permissions['TOEDIT'],'approve_show'=>$approve_show));
				}
				else
				{
					echo "You dont have permissions to view this section";
					exit();
				}
			}
			else
			{
				echo "MID Missing";
				exit();
			}
		}
	}
	public function actionShowTemplateList()
	{
		$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
		if(!$emp_id){
			print "Your are not logged in";
			exit;
		}
		else
		{
			$auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
			// echo "--".$auth_key."--";
			if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"]))
			{
				if(!empty($_REQUEST["mid"]))
				{
					$mid = $_REQUEST["mid"];
					$_REQUEST['emp_id']=$emp_id;
					$model = new GlobalmodelForm();
					$dbh1 ='';
					$user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
					$field_permissions = $model->CheckFieldPermission('',$mid,$emp_id);
					// if ($emp_id == 68244)
					// {
					// 	echo "<pre>";
					// 	print_r($field_permissions);
					// 	// exit;
					// }
					$approve_show = (isset($field_permissions['IIL_TEMPLATE_MESSAGE']['IIL_TEMPLATE_STATUS']) && ($field_permissions['IIL_TEMPLATE_MESSAGE']['IIL_TEMPLATE_STATUS'] != 'readonly')) ? 1:0;
				}
				$template_model_obj= new TemplateModel();

				if($user_permissions['TOVIEW'] == 1)
				{
					if(isset($_REQUEST['psearchtype']) && isset($_REQUEST['msearchtype']))
					{
						// template data
							$processID = isset($_REQUEST['psearchtype']) ? $_REQUEST['psearchtype'] : '';
							$data1=array('procId'=>$processID,'emp_id'=>$emp_id);
							$templates_data = array();
							if ($processID != '')
							{
								$templates_data = $template_model_obj->templatenames($data1);
							}
						// process data
							$moduleID = isset($_REQUEST['msearchtype']) ? $_REQUEST['msearchtype'] : '';
							$give_process_data = array('emp_id' => $emp_id, 'moduleid' => $moduleID );
							$processnames_data = array();
							if ($moduleID != '')
							{
								$processnames_data = $template_model_obj->processnames($give_process_data);
							}
						// module data
							$give_module_data = array(
								'emp_id' => $emp_id
							);
							$modulenames_data = $template_model_obj->modulenames($give_module_data);

						$this->renderPartial('TemplateMainScreen', array('module_data'=>$modulenames_data,'module_data_selected'=>$moduleID,'process_data'=>$processnames_data,'edit_permission'=>$user_permissions['TOEDIT'],'approve_show'=>$approve_show,'process_data_selected'=>$processID,'templates_data'=>$templates_data,'model_object'=>$template_model_obj,'mid'=>$_REQUEST['mid']));
					}
					else
					{
						$give_module_data = array(
							'emp_id' => $emp_id
						);
						$modulenames_data = $template_model_obj->modulenames($give_module_data);
						$moduleID = isset($_REQUEST['moduleID']) ? $_REQUEST['moduleID'] : '';
						$this->renderPartial('TemplateMainScreen', array('module_data'=>$modulenames_data,'module_data_selected'=>$moduleID,'process_data'=>array(),'mid'=>$_REQUEST['mid'],'edit_permission'=>$user_permissions['TOEDIT'],'approve_show'=>$approve_show));
						echo "<center>Module ID or Process ID Missing - Choose a Module/Process.</center>";
						exit();
					}
				}
				else
				{
					echo "You dont have permissions to view this section";
					exit();
				}
			}
  		}
	}
	public function actionShowTemplate()
	{
		$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
		if(!$emp_id){
			print "Your are not logged in";
			exit;
		}
		else
		{
			$auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
			// echo "--".$auth_key."--";
			if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"]))
			{
				if(!empty($_REQUEST["mid"]))
				{
					$mid = $_REQUEST["mid"];
					$_REQUEST['emp_id']=$emp_id;
					$model = new GlobalmodelForm();
					$dbh1 ='';
					$user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
					// $user_permissions['TOADD'] = 1;
					// $user_permissions['TOVIEW'] = 1;
				}
				$template_model_obj= new TemplateModel();
				if($user_permissions['TOVIEW'] == 1)
				{
					if(isset($_REQUEST['processID']) && isset($_REQUEST['templateID']))
					{
						$processID = isset($_REQUEST['processID']) ? $_REQUEST['processID'] : '';
						$templateID = isset($_REQUEST['templateID']) ? $_REQUEST['templateID'] : '';
						$data1=array('procId'=>$processID,'emp_id'=>$emp_id);
						$templates_data = array();
						$html = '';
						if ($processID != '')
						{
							$templates_data = $template_model_obj->templatenames($data1);
						}
						if ($templates_data != array() && is_array($templates_data))
						{
							foreach ($templates_data as $key => $value)
							{
								if ($value['id'] == $templateID)
								{
									$html = $value['html'];
									break;
								}
							}
						}
						// echo "<pre>";
						// print_r($templates_data);
						// exit();
						echo rawurldecode($html);
					}
					else
					{
						echo "Process ID or Template ID Missing";
						exit();
					}
				}
				else
				{
					echo "You dont have permissions to view this section";
					exit();
				}
			}
  	}
	}
	public function actionUpdateTemplate()
	{
		$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
		if(!$emp_id){
			print "Your are not logged in";
			exit;
		}
		else
		{
			$auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
			// echo "--".$auth_key."--";
			if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"]))
			{
				if(!empty($_REQUEST["mid"]))
				{
					$mid = $_REQUEST["mid"];
					$_REQUEST['emp_id']=$emp_id;
					$model = new GlobalmodelForm();
					$dbh1 ='';
					$user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
					// $user_permissions['TOADD'] = 1;
					// $user_permissions['TOEDIT'] = 1;
				}
				$template_model_obj= new TemplateModel();
				// print_r($_REQUEST);
				// print_r($_POST);
				// exit();
				$user_permissions['TOEDIT'] = 1;
				if ($user_permissions['TOEDIT'] == 1)
				{
					if(isset($_REQUEST['processID']) && isset($_REQUEST['templateID']) && isset($_REQUEST['moduleID']))
					{
						// template data
						// echo "inside if";
						$processID = isset($_REQUEST['processID']) ? $_REQUEST['processID'] : '';
						$templateID = isset($_REQUEST['templateID']) ? $_REQUEST['templateID'] : '';
						$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
						$htmlval = isset($_REQUEST['htmlval']) ? $_REQUEST['htmlval'] : '';
						$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : '';
						$fromName = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';
						$fromEmail = isset($_REQUEST['fromEmail']) ? $_REQUEST['fromEmail'] : '';
						$shortName = isset($_REQUEST['shortName']) ? $_REQUEST['shortName'] : '';
						$category = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
						$purpose = isset($_REQUEST['purpose']) ? $_REQUEST['purpose'] : '';
						$moduleID = isset($_REQUEST['moduleID']) ? $_REQUEST['moduleID'] : '';
						$data1=array(
							'processID'=>$processID,
							'moduleID'=>$moduleID,
							'templateID'=>$templateID,
							'act'=>$act,
							'htmlval'=>$htmlval,
							'subject'=>$subject,
							'from'=>$fromName,
							'fromEmail'=>$fromEmail,
							'shortName'=>$shortName,
							'category'=>$category,
							'purpose'=>$purpose,
							'emp_id'=>$emp_id
						);
						$writeTemplateResponse = array();
						$html = '';
						if ($processID != '')
						{
							$writeTemplateResponse = $template_model_obj->templateUPDATE($data1);
						}
						if ($writeTemplateResponse != array())
						{
							$a = '';
							$a = $writeTemplateResponse;
							// echo json_encode($a);
							// print_r($a);
							// return;
							if ($a['Code'] == 200)
							{
								echo json_encode($a['Message']);
								return;
							}
							else
							{
								echo json_encode("Could not update");
								return;
							}
							// exit();
						}
						else
						{
							echo json_encode("Error in Service Response");
							return;
						}
						// echo $html;
					}
					else
					{
						echo "Modulue ID or Process ID or Template ID Missing";
						exit();
					}
				}
				else
				{
					echo json_encode("You don't have permission to ADD/EDIT Templates");
					// exit();
					return;
				}
			}
			else
			{
				echo json_encode("MID Missing");
				// exit();
				return;
			}
  	}
	}
	public function actionADDTemplate()
	{
		// print_r($_REQUEST);
		// exit();
		$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
		if(!$emp_id){
			print "Your are not logged in";
			exit;
		}
		else
		{
			$auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
			// echo "--".$auth_key."--";
			if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"]))
			{
				if(!empty($_REQUEST["mid"]))
				{
					$mid = $_REQUEST["mid"];
					$_REQUEST['emp_id']=$emp_id;
					$model = new GlobalmodelForm();
					$dbh1 ='';
					$user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
					// $user_permissions['TOADD'] = 1;
					// $user_permissions['TOEDIT'] = 1;
				}
				$template_model_obj= new TemplateModel();
				// print_r($_REQUEST);
				// print_r($_POST);
				// exit();
				$user_permissions['TOEDIT'] = 1;
				if ($user_permissions['TOEDIT'] == 1)
				{
					if(isset($_REQUEST['processID']) && isset($_REQUEST['moduleID']))
					{
						// template data
						// echo "inside if";
						$processID = isset($_REQUEST['processID']) ? $_REQUEST['processID'] : '';
						// $templateID = isset($_REQUEST['templateID']) ? $_REQUEST['templateID'] : '';
						$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
						$htmlval = isset($_REQUEST['htmlval']) ? $_REQUEST['htmlval'] : '';
						$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : '';
						$fromName = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';
						$fromEmail = isset($_REQUEST['fromEmail']) ? $_REQUEST['fromEmail'] : '';
						$shortName = isset($_REQUEST['shortName']) ? $_REQUEST['shortName'] : '';
						$category = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
						$purpose = isset($_REQUEST['purpose']) ? $_REQUEST['purpose'] : '';
						$moduleID = isset($_REQUEST['moduleID']) ? $_REQUEST['moduleID'] : '';
						$data1=array(
							'processID'=>$processID,
							'moduleID'=>$moduleID,
							// 'templateID'=>$templateID,
							'act'=>$act,
							'htmlval'=>$htmlval,
							'subject'=>$subject,
							'from'=>$fromName,
							'fromEmail'=>$fromEmail,
							'shortName'=>$shortName,
							'category'=>$category,
							'purpose'=>$purpose,
							'emp_id'=>$emp_id
						);
						$writeTemplateResponse = array();
						$html = '';
						if ($processID != '')
						{
							$writeTemplateResponse = $template_model_obj->templateADD($data1);
						}
						if ($writeTemplateResponse != array())
						{
							$a = '';
							$a = $writeTemplateResponse;
							// echo json_encode($a);
							// print_r($a);
							// exit();
							if ($a['Code'] == 200)
							{
								echo json_encode($a['Message']);
								return;
							}
							else
							{
								echo json_encode("Could not create new template");
								return;
							}
							// exit();
						}
						else
						{
							echo json_encode("Error in Service Response");
							// echo json_encode($writeTemplateResponse);
							return;
						}
						// echo $html;
					}
					else
					{
						echo "Modulue ID or Process ID Missing";
						exit();
					}
				}
				else
				{
					echo json_encode("You don't have permission to ADD/EDIT Templates");
					// exit();
					return;
				}
			}
			else
			{
				echo json_encode("MID Missing");
				// exit();
				return;
			}
    	}
	}
	public function actionApproveTemplate()
	{
		$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
		if(!$emp_id){
			print "Your are not logged in";
			exit;
		}
		else
		{
			$auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
			// echo "--".$auth_key."--";
			if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"]))
			{
				if(!empty($_REQUEST["mid"]))
				{
					$mid = $_REQUEST["mid"];
					$_REQUEST['emp_id']=$emp_id;
					$model = new GlobalmodelForm();
					$dbh1 ='';
					$user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
					$field_permissions = $model->CheckFieldPermission('',$mid,$emp_id);
          $approve_show = (isset($field_permissions['IIL_TEMPLATE_MESSAGE']['IIL_TEMPLATE_STATUS']) && ($field_permissions['IIL_TEMPLATE_MESSAGE']['IIL_TEMPLATE_STATUS'] != 'readonly')) ? 1:0;
				}
				$template_model_obj= new TemplateModel();
				// print_r($_REQUEST);
				// print_r($_POST);
				// exit();
				if (($user_permissions['TOEDIT'] == 1) && ($approve_show == 1))
				{
					if(isset($_REQUEST['processID']) && isset($_REQUEST['templateID']) && isset($_REQUEST['moduleID']))
					{
						// template data
						// echo "inside if";
						$processID = isset($_REQUEST['processID']) ? $_REQUEST['processID'] : '';
						$templateID = isset($_REQUEST['templateID']) ? $_REQUEST['templateID'] : '';
						$act = isset($_REQUEST['act']) ? $_REQUEST['act'] : '';
						$htmlval = isset($_REQUEST['htmlval']) ? $_REQUEST['htmlval'] : '';
						$subject = isset($_REQUEST['subject']) ? $_REQUEST['subject'] : '';
						$fromEmail = isset($_REQUEST['fromEmail']) ? $_REQUEST['fromEmail'] : '';
						$shortName = isset($_REQUEST['shortName']) ? $_REQUEST['shortName'] : '';
						$category = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
						$purpose = isset($_REQUEST['purpose']) ? $_REQUEST['purpose'] : '';
						$moduleID = isset($_REQUEST['moduleID']) ? $_REQUEST['moduleID'] : '';
						$data1=array(
							'processID'=>$processID,
							'moduleID'=>$moduleID,
							'templateID'=>$templateID,
							'act'=>$act,
							'htmlval'=>$htmlval,
							'subject'=>$subject,
							'fromEmail'=>$fromEmail,
							'shortName'=>$shortName,
							'category'=>$category,
							'purpose'=>$purpose,
							'emp_id'=>$emp_id
						);
						$writeTemplateResponse = array();
						$html = '';
						if ($processID != '')
						{
							$writeTemplateResponse = $template_model_obj->templateAPPROVE($data1);
						}
						if ($writeTemplateResponse != array())
						{
							$a = '';
							$a = $writeTemplateResponse;
							// echo json_encode($a);
							// print_r($a);
							// return;
							if ($a['Code'] == 200)
							{
								echo json_encode($a['Message']);
								return;
							}
							else
							{
								echo json_encode("Could not update");
								return;
							}
							// exit();
						}
						else
						{
							echo json_encode("Error in Service Response");
							return;
						}
						// echo $html;
					}

					else
					{
						echo "Modulue ID or Process ID or Template ID Missing";
						exit();
					}
				}
				else
				{
					echo json_encode("You don't have permission to APPROVE Templates");
					// exit();
					return;
				}
			}
			else
			{
				echo json_encode("MID Missing");
				// exit();
				return;
			}
  	}
	}
	public function actiontemplate()
	{
		echo "<span style='color:RED;''><center><B>URL Changed - Contact GLADMIN<B><center></span>";
		exit();
	}
	public function actionCentralizedEmail()
	{
		$model = new TestingModel;
		$testout = $model->test(array());
		exit;
	}
}
?>
