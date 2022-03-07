<?php 
class Req_over_reportController extends Controller
{
 public function actionIndex()
   {
   
   
    $hostname=$_SERVER['SERVER_NAME'];
    $emp_id =Yii::app()->session['empid'];
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $model = new GlobalmodelForm();
        $dbh1 = $model->connect_db();
        $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
        $user_view = $user_permissions['TOVIEW'];
    
             if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
			HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{
		$this->render('req_over_report');
   
                }

}
}

?>