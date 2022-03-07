<?php

class Admin_blModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin_bl.models.*',
			'admin_bl.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
/*	public function shilpi()
	{
		Yii::app()->controller->module->redirect(array("UserApproval/shilpi1"));
		echo "shilpi";
	}*/
}