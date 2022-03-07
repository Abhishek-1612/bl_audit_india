<?php
class Reports3Controller extends Controller
{
   public function actionIndex()
   {  
            $modid='';
            $submodid='';
            $start_date = isset($_REQUEST['start_date']) ? $_REQUEST['start_date']:'';
            $end_date =  isset($_REQUEST['end_date']) ? $_REQUEST['end_date']:'';
            $bl_tender_rep='';
            $tdr_pur_rep='';
            $bl_tracking_rep='';
            $bl_report='';
            if(isset($_REQUEST['bl_report']))
            {
            $bl_report=$_REQUEST['bl_report'];
            }
          
          if(isset($_REQUEST['bl_tender_rep']))
           {
          $bl_tender_rep = $_REQUEST['bl_tender_rep'];
           }
          if(isset($_REQUEST['tdr_pur_rep']))
           {
           $tdr_pur_rep=$_REQUEST['tdr_pur_rep'];
           }
           
          if(isset($_REQUEST['bl_tracking_rep']))
           {
            $bl_tracking_rep=$_REQUEST['bl_tracking_rep'];
           }
           
           
           if(isset($_REQUEST['modid']))
           {
            $modid=$_REQUEST['modid'];
           }
           
           if(isset($_REQUEST['submodid']))
           {
           $submodid=$_REQUEST['submodid'];
           }
          $xyz=array('start_date'=>$start_date,'end_date'=>$end_date);	 
	  
	$conn_obj=new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $conn_obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $conn_obj->connect_db_yii('postgress_web68v'); 
        }
  if($dbh)
  {$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		 $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
		 if(!$emp_id)
                    {
                            $hostname   = $_SERVER['SERVER_NAME'];
                            print "Your are not logged in<BR> Click here to <A
                            HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
                    }else{
                            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
                            
                               $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

                                if(empty($user_permissions))
                                { 
                                    $user_permissions['TOVIEW'] = ''; 
                                }                            
			    $Report3=new Report3;	
			  if(isset($bl_report) &&  $bl_report =='bl_report' && $_REQUEST['action'] == 'get_cons_rpt')
			  {
		           echo 'This Option has been disabled. Please contact GLADMIN Team'; exit;		    
			  }   
	                  elseif(isset($bl_tracking_rep) && $bl_tracking_rep=='bl_tracking_rep' && $_REQUEST['action'] == 'get_cons_rpt')
                          {		          
                              echo 'This Option has been disabled. Please contact GLADMIN Team'; exit;	
                          }                     
			 elseif(isset($bl_tender_rep) && $bl_tender_rep == 'bl_tender_rep' && $_REQUEST['action'] == 'get_cons_rpt')
		         {
		         
	         	  $rec=$Report3->showConsumptionForm('',$modid,$submodid);
	         	  $this->render('Report3view',array('rec'=>$rec,'xyz'=>$xyz,'bl_tracking_rep'=>$bl_tracking_rep,'tdr_pur_rep'=>$tdr_pur_rep,'bl_tender_rep'=>$bl_tender_rep,'bl_report'=>$bl_report,'modid'=>$modid,'submodid'=>$submodid));
	         	 
	         	  $res=$Report3->BlTenderReport($dbh,$xyz,$bl_tender_rep);
	         	  $result=$res[0];
	         	  $tot_uniq_cnts=$res[1];
	         	  $this->render('Report33view',array('result'=>$result,'tot_uniq_cnts'=>$tot_uniq_cnts));
		       
		         }
		         elseif(isset($tdr_pur_rep) && $tdr_pur_rep == 'tdr_pur_rep' && $_REQUEST['action'] == 'get_cons_rpt')
		         {		          
		          $rec=$Report3->showConsumptionForm('',$modid,$submodid);	         	  
	         	  $this->render('Report3view',array('rec'=>$rec,'xyz'=>$xyz,'bl_tracking_rep'=>$bl_tracking_rep,'tdr_pur_rep'=>$tdr_pur_rep,'bl_tender_rep'=>$bl_tender_rep,'bl_report'=>$bl_report,'modid'=>$modid,'submodid'=>$submodid));
	         	  $result=$Report3->tenderPurchaseReport($dbh,$xyz,$tdr_pur_rep);
	         	  $this->render('Report34view',array('result'=>$result));
	         	 }elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_cons_rpt'){	
 				$rec=$Report3->showConsumptionForm('',$modid,$submodid);
				$this->render('Report3view',array('rec'=>$rec,'xyz'=>$xyz,'modid'=>$modid,'submodid'=>$submodid));	
				$result= $Report3->showConsumptionReport($dbh);
                               $rec=$result[0]; 		       
				$new_rec2=$result[1];				
				$array1=$result[2];			
				$appv_lead=$result[3];
				$appv_lead_orig=$result[4];
				$unique_lead_sold=$result[5];
				$unique_glusr=$result[6];								
                                $nonretail_lead=$result[7];                                  
				$this->render('Report31view',array('rec'=>$rec,'new_rec2'=>$new_rec2,'array1'=>$array1,'appv_lead'=>$appv_lead,'appv_lead_orig'=>$appv_lead_orig,'unique_lead_sold'=>$unique_lead_sold,'unique_glusr'=>$unique_glusr,'nonretail_lead' =>$nonretail_lead));
			    }		
			    else
			    {
			    $rec=$Report3->showConsumptionForm('',$modid,$submodid);			    
			    $this->render('Report3view',array('rec'=>$rec,'modid'=>$modid,'submodid'=>$submodid));
			    }
               }
	}	
}

public function actionBlconsumptiondemand()
{
	$empId = Yii::app()->session['empid'];
      mail("laxmi@indiamart.com","actionBlconsumptiondemand","$empId");
    exit;
}

public function actionblConsumptionReport()
{
	$empId = Yii::app()->session['empid'];
      mail("laxmi@indiamart.com","actionblConsumptionReport","$empId");
    exit;
}
 public function actionIMAdvantage()
   {
      $empId = Yii::app()->session['empid'];
      mail("laxmi@indiamart.com","actionIMAdvantage","$empId");
    exit;
   }
   
   
}

?>