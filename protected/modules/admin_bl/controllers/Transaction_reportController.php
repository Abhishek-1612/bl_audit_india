<?php 
//error_reporting(1);
class Transaction_reportController extends Controller
{
  public function actionIndex()
   {        
               $emp_id = Yii::app()->session['empid'];			
                if(!$emp_id)
		{
		echo "Please login again";exit;
		}
                else
                {      $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';	
                            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

                           if(empty($user_permissions)){
                               $user_permissions['TOVIEW'] = '';
                           }
                                            
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {     
                            $Transaction_model= new Transaction_model;
                            if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'trans')
			    {			         
			          $this->render('Transaction_view3');
			    }
			    elseif(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'transDetails' || $_REQUEST['action'] == 'purchaselimit'))
                            {    
				  $glusrid =isset($_REQUEST['glusrid']) ? $_REQUEST['glusrid']:'';
				  $email =isset($_REQUEST['email'])? $_REQUEST['email']:'';
				  $year =isset($_REQUEST['year'])? $_REQUEST['year']:'';                                                                   
				  $ondemand = isset($_REQUEST['ondemand']) ? $_REQUEST['ondemand']:'';                                  
				  if($ondemand ==''){
				   $this->render('Transaction_view3');	
                                  }				  
				  list($arr,$userID,$company,$name,$address,$city,$state,$country,$phone,$fax_no,$fax,$mobile,$ph_country,$approv,$color,$serial,$flag,$email,$av_credit,$url,$custtype)=$Transaction_model->transDetails($glusrid,$email,$year,$ondemand);
				  
                                  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'transDetails'){
                                      $this->render('Transaction_ac',array('arr'=>$arr,'userID'=>$userID,'company'=>$company,'name'=>$name,'address'=>$address,'city'=>$city,'state'=>$state,'country'=>$country,'phone'=>$phone,'fax_no'=>$fax_no,'fax'=>$fax,'mobile'=>$mobile,'ph_country'=>$ph_country,'approv'=>$approv,'color'=>$color,'serial'=>$serial,'flag'=>$flag,'email'=>$email,'av_credit'=>$av_credit,'ondemand'=>$ondemand,'url'=>$url,'custtype'=>$custtype));
                                  }else{
                                      $archive=$ondemand;$count=0;
                                      $this->render('Transaction_view2',array('arr'=>$arr,'userID'=>$userID,'company'=>$company,'name'=>$name,'address'=>$address,'city'=>$city,'state'=>$state,'country'=>$country,'phone'=>$phone,'fax_no'=>$fax_no,'fax'=>$fax,'mobile'=>$mobile,'ph_country'=>$ph_country,'approv'=>$approv,'color'=>$color,'serial'=>$serial,'flag'=>$flag,'email'=>$email,'av_credit'=>$av_credit,'archive'=>$archive,'count'=>$count,'url'=>$url,'custtype'=>$custtype));
                                  }
                            }
			 		 
			  elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'glusrpurfrm')
			   {
			          $this->render('Transaction_view5');

			   }
			  else
			   {
				  $_REQUEST['action'] = 'trans';
                                  $this->render('Transaction_view3');
			   } 
                        }
                    else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
}
}  

 public function actionPrefcity()
   {        
               $emp_id = Yii::app()->session['empid'];			
                if($emp_id>0)
		{
		    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';  
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {     
                                $Transaction_model= new Transaction_model;
				$response=$Transaction_model->prefcitydetail();
				$this->render('prefcity',array('response'=>$response));	   
                        }else{
                            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                            exit;
                        }
                }
}  

 public function actionNegativecity()
   {        
                $emp_id = Yii::app()->session['empid'];			
                if($emp_id>0)
		{
		    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);  
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {     
                                $Transaction_model= new Transaction_model;
				$response=$Transaction_model->negativecitydetail();
				$this->render('negativecity',array('response'=>$response));	   
                        }else{
                            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                            exit;
                        }
                }
} 

public function actionPurdetails()
   {        
               $emp_id = Yii::app()->session['empid'];			
                if(!$emp_id)
		{
		echo "Please login again";exit;
		}
                else
                {      $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';	            
                        
                            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

                           if(empty($user_permissions)){
                               $user_permissions['TOVIEW'] = '';
                           }
                                             
                    $user_view =isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {     
                            $Transaction_model= new Transaction_model;
                           if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'purdetails')
			   {     
			          
                                 $glusrid = isset($_REQUEST['gl_id']) ? $_REQUEST['gl_id']:'';  
                                 $days = isset($_REQUEST['fromdays']) ? $_REQUEST['fromdays']:'';  
                                 $archive = isset($_REQUEST['archive']) ? $_REQUEST['archive']:0; 
                                 $count = isset($_REQUEST['count']) ? $_REQUEST['count']:0; 
                                  $av_credit='';
				  if($archive !=1)
				   $this->render('Transaction_view3');	
                                 // $result=$Transaction_model->getdata();die;
				  list($arr,$userID,$company,$name,$address,$city,$state,$country,$phone,$fax_no,$fax,$mobile,$ph_country,
                                          $approv,$color,$serial,$flag,$email,$url,$custtype,$lat,$long)=$Transaction_model->leadpurchaseDetails('',$glusrid,$days,$archive);
				   $this->render('Transaction_view2',array('arr'=>$arr,'userID'=>$userID,'company'=>$company,'name'=>$name,'address'=>$address,'city'=>$city,'state'=>$state,'country'=>$country,'phone'=>$phone,'fax_no'=>$fax_no,'fax'=>$fax,'mobile'=>$mobile,'ph_country'=>$ph_country,'approv'=>$approv,'color'=>$color,'serial'=>$serial,'flag'=>$flag,'email'=>$email,'av_credit'=>$av_credit,'archive'=>$archive,'count'=>$count,'url'=>$url,'custtype'=>$custtype,'lat'=>$lat,'long'=>$long));
                           }else
			   {
				  $_REQUEST['action'] = 'trans';
                                  $this->render('Transaction_view3');
			   } 
                        }
                    else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
}
} 

public function actionPurchasers()
   {        
              $emp_id = Yii::app()->session['empid'];			
                if(!$emp_id)
		{
		echo "Please login again";exit;
		}
                else
                {      $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';	
                            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                           if(empty($user_permissions)){
                               $user_permissions['TOVIEW'] = '';
                           }                                            
                    $user_view =isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {     
                           
                            if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'purchasers_email')  
			    {
				  $email = isset($_REQUEST['email1']) ? $_REQUEST['email1']:''; 
                                  $page_no=isset($_REQUEST['page']) ? $_REQUEST['page'] :0;                                 
                                  $start=$page_no*20+1;
                                  $end=$page_no*20+20;
                                    $Transaction_model= new Transaction_model;
				  $array=$Transaction_model->purchaseDetailsviaemail('',$email,$page_no,$start,$end);
				  $html=$array[0];
				  $c=$array[1];
				  if($c==1)
				  {
				  $this->render('Transaction_view3');
				  $this->render('Transaction_view6',array('html'=>$html));
				  }
			  }
			  elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'purchasers')
			   {      $is_oldData=isset($_REQUEST['is_archive'])?$_REQUEST['is_archive']:'';
			          $this->render('Transaction_view3');                                 
				  $offer = isset($_REQUEST['offer']) ? $_REQUEST['offer'] : 0;                                  
                                  $flag='';
                                    $Transaction_model= new Transaction_model;
				  $res2=$Transaction_model->purchaseDetails('',$offer,$flag,$is_oldData);                                  
				  $p=$res2[0];
				  $html=$res2[1];
                                  $htmlast=$res2[2];
				  if($p==1)
				  {				  
				   $this->render('Transaction_view6',array('html'=>$html,'htmlast'=>$htmlast));
				  }
				  elseif($p==2)
				  {
				   $c=$res2[3];
				   if($c==1)
				   {
				    $this->render('Transaction_view3');
				   }
				  }
			   }
			   elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'purchasers_ph')
			   {
                                 $Transaction_model= new Transaction_model;
                                  $phonewise = isset($_REQUEST['phonewise']) ? $_REQUEST['phonewise']:'';   
			          $phcountry = isset($_REQUEST['phcountry']) ? $_REQUEST['phcountry']:'';   
                                  $page_no = isset($_REQUEST['page']) ? $_REQUEST['page']:0;                                     
                                  $start=$page_no*20+1;
                                  $end=$page_no*20+20;
				  $array=$Transaction_model->phpurchaseDetails('',$phonewise,$phcountry,$page_no,$start,$end);
				  $html=$array[0];
				  $c=$array[1];
				  if($c==1)
				  {
				  $this->render('Transaction_view3');
				  $this->render('Transaction_view6',array('html'=>$html));
				  }
			   }
			  else
			   {
				  $_REQUEST['action'] = 'trans';
                                  $this->render('Transaction_view3');
			   } 
                        }
                    else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
}
}  

public function actionMcatreport()
   {        
              $emp_id = Yii::app()->session['empid'];
              if($emp_id>0){
                           $Transaction_model= new Transaction_model;
               		  echo $html=$Transaction_model->mcatreport();exit;				  
              }else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
} 
public function actionMcatreportdetail()
   {        
              $emp_id = Yii::app()->session['empid'];
              if($emp_id>0){
                           $Transaction_model= new Transaction_model;
               		  echo $html=$Transaction_model->mcatreportdetail();exit;				  
              }else{
                        echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                        exit;
                    }
} 

    public function actionTestpg()
    {die;
         $model = new GlobalmodelForm();
         $obj = new Globalconnection();
         $sql="Select Fk_Glusr_Usr_Id,Added_Date, Comments, Fk_Glcat_Mcat_Id, Fk_Glusr_Usr_Id, Glcat_Mcat_Negative_Id 
            From Negative_Mcat_For_Products where rownum < 20";
         //$sql="SELECT * FROM BL_AUDIT_RESPONSE WHERE FK_ETO_OFR_DISPLAY_ID=31442849863";
            $dbh_pg         = $model->connect_db();           
            if($dbh_pg){
               echo 'connected';
           }
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg, $sql, array());     
            while($rec = $sth->read()) {
               $rec1=array_change_key_case($rec, CASE_UPPER);   
               echo '<pre>'; print_r($rec1);echo '</pre>';
            } 
            die;
    }
    public function actionTestpg1()
    {
        $serv_model =new ServiceGlobalModelForm();
        $data=$serv_model->negative_mcat(5159072,'');        
        print_r($data);
       // $data=Array([Negative_mcats_for_gluser] => Array ( [mcat_id_list] => Array ( [0] => Array ( [mcat_id] => 147723 [negative_id] => 59317 [added_date] => 12-03-2019 [empid] => 1563 ) [1] => Array ( [mcat_id] => 181914 [negative_id] => 5 [added_date] => 12-06-2017 [empid] => 32689 ) [2] => Array ( [mcat_id] => 184422 [negative_id] => 6 [added_date] => 12-06-2017 [empid] => 32689 ) ) ) ) ;
        
        die;
    }

 public function actionNegativecategory()
   {        
                $emp_id = Yii::app()->session['empid'];			
                if($emp_id>0)
		{
		    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);  
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {     
                                $Transaction_model= new Transaction_model;
				 $response=$Transaction_model->Negativecategory();
				$this->render('negativecat',array('response'=>$response));	   
                        }else{
                            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                            exit;
                        }
                }else{
                    echo "<b style='font-size:15px;color:red;padding-left:20px'>Please login again<b>";
                    exit;
                }
} 
 public function actionPreferredcategory()
   {        
                $emp_id = Yii::app()->session['empid'];			
                if($emp_id>0)
		{
		    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);  
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
                    if($user_view == 1)
                        {     
                                $Transaction_model= new Transaction_model;
				$response=$Transaction_model->Preferredcategory();
				$this->render('negativecity',array('response'=>$response));	   
                        }else{
                            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";
                            exit;
                        }
                }
} 

}

?>
