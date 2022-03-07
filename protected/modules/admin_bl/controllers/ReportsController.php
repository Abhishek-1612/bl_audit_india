<?php

class ReportsController extends Controller
{        

	public function actionIndex()
	{
		echo "called";
		$formmodel = new EmailEventNotificationReport();
		
		$formmodel->display();
// 		$this->render('index');
	}
	public function actionIilMasterFlag()
	{
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
                          HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{
                       
                       $user_view=0;
                       $user_edit=0;
                        
	         	    $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';		           
		            $model = new GlobalmodelForm();
 		            $dbh1 = $model->connect_db();
		            $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);                           
			    $user_add = $user_permissions['TOADD']; 
			    $user_edit = $user_permissions['TOEDIT'];
			$tabledata='';
			$model=new iilMasterFlagReport();
			$dataDDL=$model->getDDL();
			if(isset($_REQUEST['tablename']))
			{
				$tabledata=$model->getdata($_REQUEST['tablename']);
			}
			$this->render('iilMasterFlag',array('dataDDL'=>$dataDDL,'tabledata'=>$tabledata,'user_add' => $user_add,'user_edit'=>$user_edit));

		}
	}

	public function actionblgendetail()
	{
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
			HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{ 	$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
			$mid_list = Yii::app()->session['mid_list'];
			$user_permissions = array();
			if (!empty($mid_list)) {
			foreach ($mid_list as $key => $val) {
				if ($key == $mid)
				{
					$user_permissions = $val;             
				}
			}
			if(empty($user_permissions))
			{
				$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
			}
			}
			$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
		if($user_view ==1)
		{        
			if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'get_weekly_gen_rpt')
			{
				$dbh = '';
				$BLGenDetailModel = new BLGenDetailModel;
				$Ondemand='no';
                                list($sthTotalGen,$sthTotalFenq,$sthFenqApproval,$sthApproval,$sth_mod,$sth_gen_rej,$sthZeroCreadit,$sthTotalRepeat,$sthTotalRepeat3Mon,$sthTotalRepeat12Mon,$sth_adword_only) = $BLGenDetailModel->weeklyshowBLGenerationReport($dbh);
				 $this->render('blgendetailform',array());
                              
                                    $this->render('blgendetailreport',array(                                
                                        'sthTotalGen'=>$sthTotalGen,
                                        'sthTotalFenq'=>$sthTotalFenq,
                                        'sthFenqApproval'=>$sthFenqApproval,
                                        'sthApproval'=>$sthApproval,
                                        'sth_mod'=>$sth_mod,
                                        'sth_gen_rej'=>$sth_gen_rej,
                                        'sthZeroCreadit'=>$sthZeroCreadit,
                                        'sthTotalRepeat'=>$sthTotalRepeat,
                                        'sthTotalRepeat3Mon'=>$sthTotalRepeat3Mon,
                                        'sthTotalRepeat12Mon'=>$sthTotalRepeat12Mon,
                                        'sth_adword_only'=>$sth_adword_only,
                                        'Ondemand'=>$Ondemand,
                                        'sth_mod_direct_gen'=>'',
                                        'sth_mod_fenq_gen'=>'',
                                        'sth_mod_direct_app'=>'',
                                        'sth_mod_fenq_app'=>'',
                                        ));
			}
			else
			{
				$this->render('blgendetailform',array());
			}
		}
		else {
			echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
		 }
		}
	}
	public function actionblgendetaildemand()
	{
	$start_date=$_REQUEST['start_date'];
	$end_date=$_REQUEST['end_date'];
	$Ondemand='yes';        
	$dbh = '';
	$BLGenDetailModel = new BLGenDetailModel;
        $request=$_REQUEST['req'];
	list($sth_mod_direct_gen,$sth_mod_fenq_gen,$sth_mod_direct_app,$sth_mod_fenq_app,$sth_app)=$BLGenDetailModel->weeklyshowBLGenerationDemandReport($dbh,$start_date,$end_date,$request);
	$this->render('blgendetailreport',array( 
                                'Ondemand'=>$Ondemand,
                                'request'=>$request,
                                'sth_mod_direct_gen'=>$sth_mod_direct_gen,
                                'sth_mod_fenq_gen'=>$sth_mod_fenq_gen,
                                'sth_mod_direct_app'=>$sth_mod_direct_app,
                                'sth_mod_fenq_app'=>$sth_mod_fenq_app,$sth_app
                                ));
                                
	}

}