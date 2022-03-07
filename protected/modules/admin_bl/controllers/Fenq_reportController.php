<?php
class Fenq_reportController extends Controller
{
   public function actionIndex()
   { 
    $sid = 'meshr';
    $_REQUEST['fenq_table']='ETO_OFR_FROM_FENQ_ARCH';
    $xyz='';
    $obj_conn = new Globalconnection(); 
    $start_date=isset($_REQUEST['start_date'])?$_REQUEST['start_date']:strtoupper(date('d-M-Y'));
    $end_date=isset($_REQUEST['end_date'])?$_REQUEST['end_date']:strtoupper(date('d-M-Y'));
    
    if(isset($_REQUEST['start_date']))
    { 
          if(isset($_REQUEST['report']))
          {
          $report=$_REQUEST['report'];
          }
          else
          {
          $report=1;
          }
          if(isset($_REQUEST['modiddrpdwn']))
          {
          $modiddrpdwn=$_REQUEST['modiddrpdwn'];
          }
          else
          {
          $modiddrpdwn='';
          }
            if(isset($_REQUEST['cntry']))
          {
          $cntry=$_REQUEST['cntry'];
          }
          else
          {
          $cntry='';
          }
          if(isset($_REQUEST['rating']))
         {
           $cntryrating=$_REQUEST['rating'];
          }
          else
          {
           $cntryrating='';
          }
          if(isset($_REQUEST['querytype']))
          {
           $querytype=$_REQUEST['querytype'];
          }
          else
          {
          $querytype=1;
          }

	  $d = explode('-', date("s-i-h-d-m-Y"));
	  $Second = $d[0];
	  $Minute = $d[1];
	  $Hour = $d[2];
	  $Day = $d[3];
	  $Month = $d[4];
	  $Year = $d[5];

	  $cur_date = date("d-m-Y", mktime(0, 0, 0, $Month, $Day, $Year));
    $cur_date = date_create($cur_date);
    $xyz=array('start_date'=>$start_date,'end_date'=>$end_date,'report'=>$report,'modiddrpdwn'=>$modiddrpdwn,'cntry'=>$cntry,'cntryrating'=>$cntryrating,'querytype'=>$querytype);
           
          if(($start_date == $end_date) && ($start_date == $cur_date))
          {
	         $sid = 'mesh';
           $_REQUEST['fenq_table']='ETO_OFR_FROM_FENQ';
          }
         } 
                                 
    $model = new GlobalmodelForm();
      $valid= 0;
      $emp_id=0;
      $hostname=$_SERVER['SERVER_NAME'];
      $emp_id = Yii::app()->session['empid'];
      $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';	     

				$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

				if(empty($user_permissions)){ 
					$user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] =''; 
        }
      
      $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
     
    if( $user_view==1)
    {
    if(!$emp_id)
    {
      print "Your are not logged in<BR> Click here to <AHREF='http://$hostname/index.php?action=admin'>login</A><BR>";
    }
    else
    { 
    $Fenq_model=new Fenq_model;
    if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'generate')
    {       
      $array=$Fenq_model->histFENQResult('',$xyz);
      $str=$array[0];
      $show=$array[1];
      $mesg=$array[2];
      if($show==1)
        {
          $select=$Fenq_model->histFENQForm($xyz);
          $this->render('Fenq_view1',array('select'=>$select,'xyz'=>$xyz,'mesg'=>$mesg));
        }
      else
      {
          $select=$Fenq_model->histFENQForm($xyz);
          $this->render('Fenq_view1',array('select'=>$select,'xyz'=>$xyz));
          $this->render('Fenq_view2',array('str'=>$str));
      }
    }
    else
    {          
      $select=$Fenq_model->histFENQForm($xyz);
      $this->render('Fenq_view1',array('select'=>$select,'xyz'=>$xyz));
    }	
    }
  }
  else{
    echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
    exit;
}
  
}
}
?>