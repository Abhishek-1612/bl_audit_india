<?php
class IilmasterdatafillController extends Controller
{
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
                         $iildatafill = new Iilmasterdatafill();
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
                          $iildatafill = new Iilmasterdatafill();
                          $iildatafilldata=$iildatafill->iil_master_update($dbh,$emp_id);
                          $data=array('errorMsg'=>$iildatafilldata['errorMsg'],'sthfetch1'=>$iildatafilldata['sthfetch1'],'recfetch2'=>$iildatafilldata['recfetch2'],'recfetch'=>$iildatafilldata['recfetch'],'REC'=>$iildatafilldata['REC'],'sth1'=>$iildatafilldata['sth1'],'status_update'=>$iildatafilldata['status_update']);
                          $this->render('iil_master_update',array('data'=>$data));
                  }
           }
}
?>