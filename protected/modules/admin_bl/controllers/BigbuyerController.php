<?php
class BigbuyerController extends Controller
{
    public $objBigbuyer = '';
    public $dbh='';
    public $etomodel='';
    public $postgre='';
    public function init(){
         $this->etomodel =  new AdminEtoModelForm(); 
            $this->objBigbuyer=new Bigbuyer;
            $this->dbh=$this->etomodel->connectImblrDb();
            $this->postgre=0;
    }
public function actionbig_buyer_report()
	{  
    
		$hostname=$_SERVER['SERVER_NAME'];
        $emp_id = Yii::app()->session['empid'];
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';  
		
				$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

				if(empty($user_permissions)){ 
					$user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TOADD']= $user_permissions['TOUPDATE']=''; 
				}
			 

        

		if(!$emp_id)
		{
            print "Your are not logged in<BR> Please login again"; exit;
		}else
                   { 
                        $mid = $_REQUEST["mid"];
                        $_REQUEST['emp_id']=$emp_id;
                        $model = new GlobalmodelForm();
                        $dbh1 ='';
                        $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                         $user_view = $user_permissions['TOVIEW'];	
                        if($user_view==1)
                        {
                           if(isset($_REQUEST['Get_Data']) || isset($_REQUEST['pg']))
                           {
                                $data[]=array();
                                $data['pg']=isset($_REQUEST['pg'])?$_REQUEST['pg']:'';
				  $bb_data = $this->objBigbuyer->report($this->dbh,$_REQUEST);
				  $data=array('rec'=>$bb_data['rec'],'count'=>$bb_data['count'],'mid'=>$mid);
                                $this->render('big_buyer',array('data'=>$data));
			    }
			    else
			      {
			        $data=array('mid'=>$mid);
                                $this->render('big_buyer',array('data'=>$data));
				}
                        }else{
                            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                            exit;
                        }
		     }
           }
           
        public function actionorg_search()
	{    
	        
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
            print "Your are not logged in<BR> Please login again"; exit;
		}else
                   {  
                        $mid = $_REQUEST["mid"];
                        $_REQUEST['emp_id']=$emp_id;
                        $model = new GlobalmodelForm();
                        $dbh1 = '';
                        $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                        $user_view = $user_permissions['TOVIEW']; 
                        if($user_view==1)
                         {
                           if(isset($_REQUEST['Get_Dataa']) || isset($_REQUEST['search_text']))
                           {
                             
                              if(isset($_REQUEST['search_text']))
                                 {  $data=array('search_text'=>$_REQUEST['search_text']);                                     
                                    $bb_data = $this->objBigbuyer->org_name_search($this->dbh,$data);                            
				  } 
			      
                           $bb_data['count']=300;
 				  $data=array('rec'=>$bb_data['rec'],'count'=>$bb_data['count'],'mid'=>$mid,'search_text'=>$_REQUEST['search_text']);
                                 $this->render('big_buyer',array('data'=>$data));
			    }
			    else
			      {
			        $data=array('mid'=>$mid);
				if($this->postgre>0){
                                       $this->render('big_buyer_pg',array('data'=>$data));
                                  }else{
                                       $this->render('big_buyer',array('data'=>$data));
                                  }
                              }
                         }
                    else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }  
	
                   }
}
             public function actiondomain_search()
	{     
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{  
            print "Your are not logged in<BR> Please login again"; exit;
		}
                   else
                   {   
                    $mid = $_REQUEST["mid"];
                    $_REQUEST['emp_id']=$emp_id;
                    $model = new GlobalmodelForm();
                    $dbh1 = '';
                    $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                    $user_view = $user_permissions['TOVIEW']; 			  
                    if($user_view==1)
                     {
                       if(isset($_REQUEST['Get_Dataaa']) || isset($_REQUEST['search_domain']))
                       {
                           if(isset($_REQUEST['search_domain']))
                             {  $data=array('search_domain'=>$_REQUEST['search_domain']); 	                                  
                                $bb_data = $this->objBigbuyer->domain_name_search($this->dbh,$data);
                            } 
                            $bb_data['count']=300;
                            $data=array('rec'=>$bb_data['rec'],'count'=>$bb_data['count'],'mid'=>$mid,'search_domain'=>$_REQUEST['search_domain']);
                            $this->render('big_buyer',array('data'=>$data));                                  
                        }
                        else
                          {
                            $data=array('mid'=>$mid);
                            $this->render('big_buyer',array('data'=>$data));                                  
                            }                           
                   }                         
                   else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
                 }
           }
         
           public function actionbig_buyer_org()
	{   
	     
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{  
            print "Your are not logged in<BR> Please login again"; exit;
		}
                   else
                   {     
                       $_REQUEST['emp_id']= $emp_id;
                        $mid = $_REQUEST["mid"];
                        $_REQUEST['emp_id']=$emp_id;
                        $model = new GlobalmodelForm();
                        $dbh1 = $model->connect_db();
                        $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
			 $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                        if($user_view == 1){
                        if(isset($_REQUEST['orgid']))
                         {  $data=array('orgid'=>$_REQUEST['orgid']);                                   
                            $bb_data = $this->objBigbuyer->report1($this->dbh,$data);
                         }
                        $data=array('rec'=>$bb_data['rec'],'rec2'=>$bb_data['rec2'],'rec3'=>$bb_data['rec3'],'rec31'=>$bb_data['rec31'],'rec4'=>$bb_data['rec4'],'rec5'=>$bb_data['rec5'],'rec6'=>$bb_data['rec6'],'rec51'=>$bb_data['rec51'],'rec61'=>$bb_data['rec61'],'rec7'=>$bb_data['rec7'],'rec8'=>$bb_data['rec8'],'count'=>$bb_data['count'],'mid'=>$mid,'orgid'=>$_REQUEST['orgid']);
                        $this->render('big_buyer1',array('data'=>$data));
                         }  else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                        }
                   }
           }
           public function actionbig_buyer_search()
           {    
		$hostname=$_SERVER['SERVER_NAME'];
        $emp_id = Yii::app()->session['empid'];
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';  
		
				$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

				if(empty($user_permissions)){ 
					$user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TOADD']= $user_permissions['TOUPDATE']=''; 
				}
			  



		if(!$emp_id)
		{
            print "Your are not logged in<BR> Please login again"; exit;
		}
                   else
                   {     $_REQUEST['emp_id']= $emp_id;
	         	    $mid = $_REQUEST["mid"];
		            $_REQUEST['emp_id']=$emp_id;
		            $model = new GlobalmodelForm();
 		            $dbh1 = '';
		            $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                             $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                            if($user_view == 1)
                                {
			    if (!isset($_REQUEST['searchby']))
				$_REQUEST['searchby']='';
                      
			    if(isset($_REQUEST['bb_domain']))
			      {  $data=array('bb_domain'=>$_REQUEST['bb_domain'],'searchby'=>$_REQUEST['searchby']); 			     
				 $bb_data = $this->objBigbuyer->bb_search($this->dbh,$data);                           
                  $data=array('rec'=>$bb_data['rec'],'bb_domain'=>$_REQUEST['bb_domain'],'searchby'=>$_REQUEST['searchby'],'mid'=>$mid);
                
                       
                       $data['totcount'] =$bb_data['rec']['totcount'];
                    
                    
				  $this->render('big_buyer_search',array('data'=>$data));
                       
			      } 
			      else 
			      {
			       $data=array('mid'=>$mid);
				$this->render('big_buyer_search',array('data'=>$data));				
                              }
                    } else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
           }
           }  
           
         public function actionbig_buyer_active_user()
	{   
             
	        
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
            print "Your are not logged in<BR> Please login again"; exit;
		}
                   else
                   {     $_REQUEST['emp_id']= $emp_id;
                     
                     
	         	    $mid = $_REQUEST["mid"];
		            $_REQUEST['emp_id']=$emp_id;
		            $model = new GlobalmodelForm();
 		            $dbh1 = '';
		            $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                     $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {
                         if(isset($_REQUEST['orgid']))
                          {  $data=array('orgid'=>$_REQUEST['orgid'],'month_data'=>$_REQUEST['month_data']);                                                
                           $bb_data = $this->objBigbuyer->active_user($this->dbh,$data);
                          } 
                         
                           $data=array('rec'=>$bb_data['rec'],'mid'=>$mid,'month_data'=>$_REQUEST['month_data']);
  			   $this->render('big_buyer2',array('data'=>$data));
                      }else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
           }   
        }  
           
         public function actionbigbuyerPdf()
	{
	  
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
            print "Your are not logged in<BR> Please login again"; exit;
		}
                   else
                   {   
	         	    $mid = $_REQUEST["mid"];
		            $_REQUEST['emp_id']=$emp_id;
		            $model = new GlobalmodelForm();
 		            $dbh1 = '';
		            $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                             $user_view = $user_permissions['TOVIEW']; 			    
			$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                        if($user_view == 1)
                        {  
                        $_REQUEST['emp_id']= $emp_id;
                           if(isset($_REQUEST['orgid']) || isset($_REQUEST['orgid']))
                           {
                              $data=array('orgid'=>$_REQUEST['orgid']);                               
                              $bb_data = $this->objBigbuyer->bigbuyerPdfReport($this->dbh,$data);
                              $bb_data1 = $this->objBigbuyer->report1($this->dbh,$data);
                              
 			      $data=array('dbh'=>$this->dbh,'rec'=>$bb_data['rec'],'rec2'=>$bb_data1['rec2'],'rec3'=>$bb_data1['rec3'],'reclogo'=>$bb_data['reclogo'],'rec_bbinfo'=>$bb_data['rec_bbinfo'],'glcnt'=>$bb_data1['count']);
 			      $this->render('big_buyer_pdf',array('data'=>$data));
			    
                           }
                           
		     } else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
                   }   
           }
           
     public function actionbigbuyerPdf1()
	{
                $hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
            print "Your are not logged in<BR> Please login again"; exit;
		}
                   else
                   {    $mid = $_REQUEST["mid"];
                        $_REQUEST['emp_id']=$emp_id;
                        $model = new GlobalmodelForm();
                        $dbh1 = '';
                        $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                         $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {
                        $_REQUEST['emp_id']= $emp_id;
                           if(isset($_REQUEST['orgid']) || isset($_REQUEST['orgid']))
                           {
                              $data=array('orgid'=>$_REQUEST['orgid']);                              
                              $bb_data = $this->objBigbuyer->bigbuyerPdfReport($this->dbh,$data);
                              $bb_data1 = $this->objBigbuyer->report1($this->dbh,$data);
                              if($this->postgre>0){
                                  $dbtype='PG';
                              }else{
                                  $dbtype='ORA';
                              }
 			      $data=array('dbh'=>$this->dbh,'rec'=>$bb_data['rec'],'rec9'=>$bb_data1['rec9'],'rec10'=>$bb_data1['rec10'],'rec2'=>$bb_data1['rec2'],'rec3'=>$bb_data1['rec3'],'rec61'=>$bb_data1['rec61'],'reclogo'=>$bb_data['reclogo'],'rec_bbinfo'=>$bb_data['rec_bbinfo'],'glcnt'=>$bb_data1['count']);
 			      $this->render('bigbuyerpdfprec',array('data'=>$data,'dbtype'=>$dbtype));
			    
                           }
                        }else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                        }
		     }
           }
  public function actionbigbuyer_glusr()
{
		$dbh_mesh=$this->etomodel->connectMeshrDb();  
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
            print "Your are not logged in<BR> Please login again"; exit;
		}
                   else
                   {
                     $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {
	         	    $mid = $_REQUEST["mid"];
		            $_REQUEST['emp_id']=$emp_id;
		            $model = new GlobalmodelForm();
 		            $dbh1 = $model->connect_db();
		            $user_permissions = $model->checklogin($dbh1,$mid,$emp_id);
                             $user_view = $user_permissions['TOVIEW']; 
			    
                        $_REQUEST['emp_id']= $emp_id;
                           if(isset($_REQUEST['FK_GLUSR_USR_ID'])) 
                           {
//                            $test = $_REQUEST['FK_GLUSR_USR_ID'];
//                            echo $test;
                              $data=array('FK_GLUSR_USR_ID'=>$_REQUEST['FK_GLUSR_USR_ID']); 			     
                              $bb_data = $this->objBigbuyer->bigbuyerReport_glusr($this->dbh,$data,$dbh_mesh);

                              $bb_latestbl = $this->objBigbuyer->latestBL($this->dbh,$data,'3');
                              $bb_product_sell = $this->objBigbuyer->getProductListByGLID($_REQUEST['FK_GLUSR_USR_ID'],0,20);
                              $bb_feedback = $this->objBigbuyer->feedbackByGLID($this->dbh,$data);
                              $data=array('dbh'=>$this->dbh,'rec'=>$bb_data['rec'],'rec_glinfo'=>$bb_data['rec_glinfo'],'reclogo'=>$bb_data['reclogo'],'rec_bbinfo'=>$bb_data['rec_bbinfo'],'bb_latestbl'=>$bb_latestbl,'dbh'=>$this->dbh,'feedback'=>$bb_feedback,'rec_product_buy'=>$bb_data['rec_product_buy'],'bb_product_sell' => $bb_product_sell,'sth_top_mcat'=>$bb_data['sth_top_mcat'],'ordervalue'=>$bb_data['ordervalue'],'supp_intro'=>$bb_data['supp_intro']);
 			      if($this->postgre>0){
                                    $this->render('bigbuyer_glusr_score_pg',array('data'=>$data));
                              }else{
                                   $this->render('bigbuyer_glusr_score',array('data'=>$data));
                              }
			    
                           } 
                         }
		     }
}           

 public function actionRemoveExcel() {
        $upload_path      = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/";
        $file_name        = !empty($_GET['excel'])?$_GET['excel']:'';
        $uploadfile       = $upload_path . $file_name;
        @unlink($uploadfile);
    }

 public function actionBulkmgr() {    
     
    
        $mid    = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $empid  = Yii::app()->session['empid'];
        
				$user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empid);

				if(empty($user_permissions)){ 
					$user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TOADD']= $user_permissions['TOUPDATE']=''; 
				}
			      
        $process_time = "PROCESS START TIME => " . date("F j, Y, g:i a"); 
        $model = new GlobalmodelForm();
        $dbh_mesh = '';
        $model_Bulkdata = new Bulkbigbuyer_upload();
        $mid              = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';		        
        $empid            = Yii::app()->session['empid'];
        
        
        $cookie_mid       = $mid;
        $user_permissions = $model->checklogin($dbh_mesh, $mid, $empid);
        $user_edit        = $user_permissions['TOEDIT'];
        $user_download    = $user_permissions['TODOWNLOAD'];
        $user_del         = $user_permissions['TODELETE'];       
        $filepath = isset($_REQUEST['r']) ? $_REQUEST['r'] : '';
        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        if($user_view == 1)
            {
        $domain_serv = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
        $pass_file         = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : '';       
       
        
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Upload') {
            $model_Bulkdata->show_html_mgr($cookie_mid, $domain_serv);
            $uploaded_filename = $model_Bulkdata->upload_mgr($empid,$cookie_mid);            
            $model_Bulkdata->Process_mgr($empid,'excel', $cookie_mid, $user_del, $user_download, $uploaded_filename,$process_time);

        } else if (isset($_REQUEST['action1']) && $_REQUEST['action1'] == 'Process') { 
            $model_Bulkdata->show_html_mgr($cookie_mid, $domain_serv);            
            $model_Bulkdata->Process_mgr($empid,'excel_data', $cookie_mid, $user_del, $user_download, $pass_file,$process_time);            
        }  else {     
            $model_Bulkdata->show_html_mgr($cookie_mid, $domain_serv);
            
            print <<<as
<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true</script>
as;
        }
       $model_Bulkdata->showInst();
 } else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    } 
    }


}
?>
