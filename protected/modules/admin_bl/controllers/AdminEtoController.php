<?php
class adminEtoController extends BlController
{
	public function actionEtoSearch()
	{
		$this->render('EtoSearch');
	}
	public function actionEtoUserResp()
	{
		$this->render('EtoUserResp');
	}
	public function actionEventNotification()
	{
		$this->render('EventNotification');
	}
	public function actionadminContact()
	{
		$this->render('adminContact');
	}

}
