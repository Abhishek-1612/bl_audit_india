<?php
class IIL_Master_FlagController extends Controller
{
	public function actionIndex()
	{
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
                          HREF='https://$hostname/index.php?action=admin'>login</A><BR>";
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
			$model=new IIL_Master_Flag();
			$dataDDL=$model->getDDL();
			if(isset($_REQUEST['tablename']))
			{
				$tabledata=$model->getdata($_REQUEST['tablename']);
			}
			$this->render('iilmasterflag',array('dataDDL'=>$dataDDL,'tabledata'=>$tabledata,'user_add' => $user_add,'user_edit'=>$user_edit));

		}
	}
        
        public function actionadd()
	{  
	       $this->pageTitle='IIL Master Data- Add Screen';
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<br/> Click here to <a
				href='http://$hostname/index.php?action=admin'>login</a><br/>";
		}
                else
                {   
                         $glEtoModel = new AdminEtoModelForm();
                         $dbh = $glEtoModel->connectMeshDb();	
                         $iildatafill = new IIL_Master_Flag();
                         $iildatafilldata=$iildatafill->iil_master_insert($dbh,$emp_id);
                         $data=array('errorMsg'=>$iildatafilldata['errorMsg'],'sth_dtype'=>$iildatafilldata['sth_dtype'],'status_update'=>$iildatafilldata['status_update']);
			 $this->render('iil_master_insert',array('data'=>$data));
                 }
         }
           
        public function actionedit()
	{  
	       
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
                $this->pageTitle='IIL Master Data- Update Screen';
		if(!$emp_id)
		{
			print "Your are not logged in<br/> Click here to <a
				href='http://$hostname/index.php?action=admin'>login</a><br/>";
		}
                else
                {   
                          $glEtoModel = new AdminEtoModelForm();
                          $dbh = $glEtoModel->connectMeshDb();	
                          $iildatafill = new IIL_Master_Flag();
                          $iildatafilldata=$iildatafill->iil_master_update($dbh,$emp_id);
                          $data=array('errorMsg'=>$iildatafilldata['errorMsg'],'sthfetch1'=>$iildatafilldata['sthfetch1'],'recfetch2'=>$iildatafilldata['recfetch2'],'recfetch'=>$iildatafilldata['recfetch'],'REC'=>$iildatafilldata['REC'],'sth1'=>$iildatafilldata['sth1'],'status_update'=>$iildatafilldata['status_update']);
                          $this->render('iil_master_update',array('data'=>$data));
                  }
           }
}
?>