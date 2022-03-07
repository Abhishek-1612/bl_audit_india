<?php
class Eto_iil_masterController extends Controller
{

   public function actionIndex()
   {  

   $glEtoModel = new AdminEtoModelForm();
   $dbh = $glEtoModel->connectMeshrDb();  
  
if($dbh)
{
 $selectopt='';
 $hostname=$_SERVER['SERVER_NAME'];
 $emp_id =Yii::app()->session['empid']; 
 $submit =isset($_REQUEST['submit']);
 if(isset($_REQUEST['tablename'])){
    $selectopt =$_REQUEST['tablename']; 
 }

 
		
		 if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
				HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		
		
		else
		{
		
		
		$obj1=new Eto_iil_master;
		$message=$obj1->get_data($dbh,$submit,$selectopt);
		
		$array1=$message[0];
		$array2=$message[1];
		
		
		
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_cons_rpt')
		{
		$this->render('eto_iil',array('array1'=>$array1,'submit'=>$submit,'selectopt'=>$selectopt));
		
		$this->render('eto_iil1',array('array2'=>$array2,'submit'=>$submit));
		}
		else
		{
                    $this->render('eto_iil',array('array1'=>$array1,'array2'=>$array2,'submit'=>$submit,'selectopt'=>$selectopt));		
		}		
		}
	
}
}
}
   
   ?>