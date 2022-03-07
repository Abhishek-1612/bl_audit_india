<?php

class Eto_rej_ofrController extends Controller
{

  public function actionless90Days(){
    
    $emp_id =Yii::app()->session['empid'];      
    $obj_conn = new Globalconnection(); 
    if(!$emp_id)
  {
                      $hostname   = $_SERVER['SERVER_NAME'];
    print "Your are not logged in<BR> Click here to <A
    HREF='/index.php?action=admin'>login</A><BR>";
  }
  
   else
   {
          $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
          $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

          if(empty($user_permissions))
          { 
              $user_permissions['TOVIEW'] = ''; 
            }

          
          $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
   if($user_view==1)
    {
    $action = $_REQUEST['action'];
      $obj = new eto_rej_ofr();
      $obj_conn = new Globalconnection(); 
      $host_name = $_SERVER['SERVER_NAME'];	
          

      if ($host_name == 'dev-gladmin.intermesh.net'||  $host_name == 'stg-gladmin.intermesh.net')
      {    
      $dbh1 = $obj_conn->connect_db_yii('postgress_web77v');
      }
      else
      {
      $dbh1 = $obj_conn->connect_db_yii('postgress_web50v');
      }
      $dropDown = $obj->dropdowndata($dbh1);
      $data = $obj->getFirstTable($action,'',$dbh1);
      $this->render('mainPage',array('data'=>$data,'dropDown'=>$dropDown));
         
    }
  }
      }

      public function actionUpdateEmp(){
        $selectArr = $_REQUEST['selectArr'];
        // echo "<pre>";print_r($selectArr);exit;
        // $empid = $_REQUEST['empid'];
        $glmodel = new GlobalmodelForm();
        $imenq = $glmodel->connect_oracledb('imenq');
        $emp_id    = Yii::app()->session['empid'];
        $obj = new eto_rej_ofr();
        foreach($selectArr as $arr)
        {
          $bothArr = explode('-',$arr);
          $data = $obj->saveEmpDetails($imenq,$glmodel,$_REQUEST,$emp_id,$bothArr);
        }
        // $data = $obj->saveEmpDetails($imenq,$glmodel,$_REQUEST,$emp_id);
        if($data=='Yes'){
          echo "Yes";
        }else{
          echo "no";
        }
      }

public function actionSummary(){ 
     $emp_id =Yii::app()->session['empid'];      
      if(!$emp_id)
		{
                        $hostname   = $_SERVER['SERVER_NAME'];
			print "Your are not logged in<BR> Click here to <A
			HREF='/index.php?action=admin'>login</A><BR>";
		}
		
     else
     {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = ''; 
              }

            
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
     if($user_view==1)
      {
         
         $sth_tot_rej = array();  
            $submit=0;  

        $loginPath  = $_SERVER['ADMIN_URL'];
      $hostname   = $_SERVER['SERVER_NAME'];
                 $dbtype='';    
                 $obj = new eto_rej_ofr;
                        if(isset($_REQUEST['Summary']))
			  {
                                 
				 $data = $obj->summary_relevancy('');
				 $sth = $data[0];				
                            $this->render('relevancy_summary',array("submit"=>$submit,"sth"=>$sth,'dbtype'=>$dbtype)); 
			  }else{
                            $this->render('relevancy_summary',array('dbtype'=>$dbtype)); 
                          }
                                  
     }
     
     }
}

public function actionIndex()
   {        
    die('work');
     $emp_id =Yii::app()->session['empid'];
      if(!$emp_id)
		{
                        $hostname   = $_SERVER['SERVER_NAME'];
			print "Your are not logged in<BR> Click here to <A
			HREF='/index.php?action=admin'>login</A><BR>";
		}else
            {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     

              $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = ''; 
              }

                    
       $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        if($user_view==1)
         {      
                 $dbtype='';
                 $obj = new eto_rej_ofr;
                 if(isset($_REQUEST['offerid']))
                {
                          $offerid = $_REQUEST['offerid'];
                          if($offerid>0){
                          $rec = $obj->offerdetails($offerid);
                          $this->render('offerdetails',array('rec'=>$rec));
                          }else{
                              echo 'Invalid Offer ID';exit;
                          }
                }elseif(isset($_REQUEST['PurchaseFlag']) && ($_REQUEST['PurchaseFlag'] == '1' || $_REQUEST['PurchaseFlag'] == '2'))
                {
                            $Glusrid      = $_REQUEST['glid'];
                            $Mcatid       = $_REQUEST['MCAT_ID'];
                            $PurchaseFlag = $_REQUEST['PurchaseFlag'];
                            if($Glusrid >0 && $Mcatid>0){
                                 $sth = $obj->puchasedetails('',$Glusrid,$Mcatid,$PurchaseFlag);
                                $this->render('puchasedetails',array('sth'=>$sth,'PurchaseFlag'=>$PurchaseFlag,'dbtype'=>$dbtype));
                            }else{
                                echo 'Invalid GL ID';exit;
                            }
                        }
                        elseif(isset($_REQUEST['enableFlag']) && ($_REQUEST['enableFlag'] == '1' || $_REQUEST['enableFlag'] == '2'))
                        {
                                 $Glusrid      = $_REQUEST['glid'];
                                 if($Glusrid >0){
                                    $EnableFlag   = $_REQUEST['enableFlag'];
                                    $sth = $obj->enabledetails('',$Glusrid,$EnableFlag);
                                    $this->render('enabledetails',array('sth'=>$sth,"EnableFlag"=>$EnableFlag,'dbtype'=>$dbtype));
                                 }else{
                                      echo 'Invalid GL ID';exit;
                                 }
                        }
                        elseif(isset($_REQUEST['productFlag']) && $_REQUEST['productFlag'] == '1')
                        {
                                 $Glusrid      = $_REQUEST['glid'];
                                 if($Glusrid >0){
                                 $sth = $obj->productdetails('',$Glusrid);
                                 $this->render('productdetails',array('sth'=>$sth,'dbtype'=>$dbtype));
                                 }else{
                                      echo 'Invalid GL ID';exit;
                                 }
                        }
                        elseif(isset($_REQUEST['pur_count']) && $_REQUEST['pur_count'] == '1')
                        {
                                 $offer_id     = $_REQUEST['offer_id'];
                                    if($offer_id >0){
                                        $sth = $obj->purchasehistory('',$offer_id);
                                        $this->render('purchasehistory',array('sth'=>$sth,'dbtype'=>$dbtype));
                                    }else{
                                        echo 'Invalid offer ID';exit;
                                    }
                        }
                        elseif(isset($_REQUEST['blalrtcat']) && $_REQUEST['blalrtcat'] == '1')
                        {

                                 $sth = $obj->blalertdetails('');
                                 $this->render('blalertdetails',array("sth"=>$sth,'dbtype'=>$dbtype));

                        }
                        elseif(isset($_REQUEST['blgen']) && $_REQUEST['blgen'] == '1')
                        {

                                $sth = $obj->blgen('');
                                 $this->render('blgen',array("sth"=>$sth,'dbtype'=>$dbtype));

                        }
                        elseif(isset($_REQUEST['showproduct']) && $_REQUEST['showproduct']==1)
                        {

                            $Glusrid      = $_REQUEST['glusrid'];
                            $Mcatid       = $_REQUEST['mcatid'];
                            if($Glusrid >0 && $Mcatid>0){
                                $sth_list=$obj->show_popup('',$Mcatid,$Glusrid);
                                $sth_list=$sth_list[0];
                                $this->render('dispHTML2',array('sth_list'=>$sth_list,'Glusrid'=>$Glusrid,'Mcatid'=>$Mcatid,'dbtype'=>$dbtype));
                            }else{
                                echo 'Invalid GL.MCAT ID';exit;
                            }
                        }
                        else
                        {
                                 $sbjVal = '';
                                 $sbjFrmdays ='';
                                 $Frmdetail='';
                                 $anyError = '';
                                 $ValErr = '';
                                 $err = '';
                                 $sbjVal2 = '';                                 
                                 $anyError2 = '';
                                 $ValErr2 = '';
                                 $err2 = '';
                                 $action = '';
                                 $mcatList = [];

                                if(isset($_REQUEST['fromdays']))
                                  {$sbjFrmdays = $_REQUEST['fromdays'];}
                                else
                                  {$sbjFrmdays = '';}

                                if(isset($_REQUEST['action']))
                                  {$action = $_REQUEST['action'];}
                                else
                                  {$action = '';}



                                if(isset($_REQUEST['report']))
                                  {$sbjVal = $_REQUEST['report'];}
                                else
                                  {$sbjVal = '';}


                                $sbjFrmdays2 = $sbjFrmdays;
                                $sbjVal2 = $sbjVal;
                               if(isset($_REQUEST['detail']))
                                  {$Frmdetail=$_REQUEST['detail'];}
                                else
                                  {$Frmdetail = '';}

                //  echo $Frmdetail;
                              if ($Frmdetail == 1)
                                {
                              if(isset($_REQUEST['genmis']))
                                 {
                                    $anyError = "false";
                                    $ValErr = "false";
                                    if ($sbjVal == "")
                                      {
                                        $ValErr = "true";
                                        $anyError = "true";
                                        $err="Please Enter a GlUsr ID";
                                      }

                                    if ($sbjVal == "")
                                      {      
                                          if(!preg_match('/^\d+$/',$sbjVal,$match))
                                            {
                                            $ValErr = "true";
                                            $anyError = "true";
                                            $err="GlUsr ID must be Numeric";
                                            $sbjVal = $_REQUEST['report'];
                                            }
                                      }
                                  }
                                 }
                              elseif($Frmdetail == 2)
                              {
                              if(isset($_REQUEST['genmis']))
                                {
                                  $anyError2 = "false";
                                  $ValErr2 = "false";
                                  if ($sbjVal2 == "")
                                    {
                                        $ValErr2 = "true";
                                        $anyError2 = "true";
                                        $err2="Please Enter a Offer ID";
                                    }
                                if ($sbjVal2 == "")
                                  {       if(!preg_match('/^\d+$/',$sbjVal2,$match))
                                        {
                                        $ValErr2 = "true";
                                        $anyError2 = "true";
                                        $err2="Offer ID must be Numeric";
                                        $sbjVal2 = $_REQUEST['report'];
                                        }
                                  }
                                }
                               }
		
                   
		 $rec ='';
		 $rec1 = '';
		 $sth_pur = '';
		 $sth_tot_rej = '';
		 $sth_sum = '';
		 $sth_rejection = '';
		 $sth_lis= '';
		 $serach = '';
		 $sth = '';
		 $sth_list = '';
		 $sth_serach='';
		 $sth1 = '';
		 $fp = '';
		 $filename = '';
                    $request = Yii::app()->request;
                    $start_date= $request->getParam('start_date','');
                    $end_date= $request->getParam('end_date','');

		   if ($Frmdetail == 1)
		    {
			    if(isset($_REQUEST['report']))
			    {
				    $sbjVal = $_REQUEST['report'];
				    $data = $obj->glusrwise_report('',$sbjVal,$emp_id);
				    $rec = $data[0];
				    $rec1 = $data[1];
			    
			    }
		    }
		  if ($Frmdetail == 2)
		    {
			    if($_REQUEST['report'])
			    {
				    $sbjVal = $_REQUEST['report'];
				    $rec = $obj->offerwise_report('',$sbjVal);
			    
			    }
		    }
		    
		    if(isset($_REQUEST['relevant']))
			  {
				 $data = $obj->showEmailRelevancyReportnew('');
				 $sth1 = $data[0];
				 $fp = $data[1];
				 $filename = $data[2];
			  }
			  
	            if ($anyError == "false")
	            {   
                         if($sbjVal=='' || $start_date=='' || $end_date ==''){
                            $emp_id =Yii::app()->session['empid'];
                            $empemail= Yii::app()->session['empemail'];
                            mail("laxmi@indiamart.com","dispHTML Manage Buy Leads >> Not Interested Report Value Missing","The employee id is $emp_id and the email id is $empemail sbjVal : $sbjVal start_date: $start_date end_date: $end_date");
                            echo "Input Parameter missing";exit;        
                        }
                        
                  
	                 $data = $obj->dispHTML('',$sbjVal,$start_date,$end_date);	                
	                 
	                 $sth_pur = $data[0];
	                 $sth_tot_rej = $data[1];
	                 $sth_sum = $data[2];
	                 
	                 $sth_serach = $data[3];
	                 $fp = $data[4];
	                 $filename = $data[5];
	            }
	            
	            if ($anyError2 == "false")
	            {  
                        if($sbjVal=='' || $start_date=='' || $end_date ==''){
                            $emp_id =Yii::app()->session['empid'];
                            $empemail= Yii::app()->session['empemail'];
                            mail("laxmi@indiamart.com","dispHTML Manage Buy Leads >> Not Interested Report Value Missing anyError2","The employee id is $emp_id and the email id is $empemail sbjVal : $sbjVal start_date: $start_date end_date: $end_date");
                            echo "Input Parameter missing";exit;        
                        }
	               $sth = $obj->dispHTML1('',$start_date,$end_date,$sbjVal);
              }
            	    $this->render('dispHTML' ,array("mcatList" => $mcatList,"action"=>$action ,"sbjVal"=>$sbjVal ,"sbjFrmdays"=>$sbjFrmdays,
                        "Frmdetail"=>$Frmdetail, "anyError"=>$anyError ,"ValErr"=>$ValErr,"err"=>$err,"sbjVal2"=>$sbjVal2,"sbjFrmdays2"=>$sbjFrmdays2,
                        "anyError2"=>$anyError2 , "ValErr2"=>$ValErr2,"err2"=>$err2,"rec"=>$rec,"rec1"=>$rec1,"emp_id"=>$emp_id,"sth_pur"=>$sth_pur
                            ,"sth_tot_rej"=>$sth_tot_rej,"sth_sum"=>$sth_sum,"sth_serach"=>$sth_serach,"sth"=>$sth ,"sth1"=>$sth1,"fp"=>$fp,"filename"=>$filename,'dbtype'=>$dbtype));
              
	}
	
      }        
   }
   }

 public function actioninitialMcats(){
  $emp_id =Yii::app()->session['empid'];      
        if(!$emp_id)
      {
                       
        print "Your are not logged in<BR> Click here to <A
        HREF='/index.php?action=admin'>login</A><BR>";
      }

      else
      {
              $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
              $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

              if(empty($user_permissions))
              { 
                  $user_permissions['TOVIEW'] = ''; 
                }

              
              $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
      if($user_view==1)
        {       
          $q = $_REQUEST;
          $glmodel= new GlobalmodelForm(); 
          if (!empty($_REQUEST['mid'])) {
            $cookie_mid = $_REQUEST['mid'];
            $arr['mid'] = $cookie_mid;
          } else {
              $cookie_mid = '';
          }
        $obj = new eto_rej_ofr();
        $sbjVal = $_REQUEST['glid'];
        $start_date = $_REQUEST['sdate'];
        $end_date = $_REQUEST['tdate'];
        $action = $_REQUEST['action'];
        $mcatList = $obj->mcatData('',$sbjVal,$start_date,$end_date);
        $final_disp=$obj->get_final_disposition_data($cookie_mid, $glmodel, $q);
        $arr['final_disp']=$final_disp;
          $this->render('initialMcat' ,array('arr' => $arr,"mcatList" => $mcatList,"action"=>$action ,"sbjVal"=>$sbjVal));
        }
      }
      }

   public function actionofferDetails1()
   { 
    $emp_id =Yii::app()->session['empid'];      
    if(!$emp_id)
  {
                     
    print "Your are not logged in<BR> Click here to <A
    HREF='/index.php?action=admin'>login</A><BR>";
  }
  
   else
   {
          $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
          $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

          if(empty($user_permissions))
          { 
              $user_permissions['TOVIEW'] = ''; 
            }

          
          $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
   if($user_view==1)
    {       
    $obj = new eto_rej_ofr();
    $mcatid = $_REQUEST['mcatid'];
    $glid = $_REQUEST['glid'];
    $sdate = $_REQUEST['sdate'];
    $tdate = $_REQUEST['tdate'];
    $offerList = $obj->offerDetails1('',$mcatid,$glid,$sdate,$tdate);
    $this->render('offerData' ,array("offerList" => $offerList,"mcatid"=> $mcatid));
    }
  }
 
   }


   public function actiongetNegativeMcats()
   {  
    $emp_id =Yii::app()->session['empid'];      
    if(!$emp_id)
  {
                      
    print "Your are not logged in<BR> Click here to <A
    HREF='/index.php?action=admin'>login</A><BR>";
  }
  
   else
   {
          $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
          $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

          if(empty($user_permissions))
          { 
              $user_permissions['TOVIEW'] = ''; 
            }

          
          $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
   if($user_view==1)
    {

    $obj = new eto_rej_ofr();
    $glid = $_REQUEST['glid'];
    $negMcats = $obj->getNegativeMcats('',$glid);
    $this->render('negativeMcats' ,array("negMcats" => $negMcats));
    // exit;
  }
}
   }

   public function actionsaveNegativeMcats()
   {  
    $glid = isset($_REQUEST['glid'])?$_REQUEST['glid']:'';
    $mcatList = isset($_REQUEST['mcatList'])?$_REQUEST['mcatList']:'';
    $mcatsList = explode(',',$mcatList);
    $ServiceGlobalModelForm=new ServiceGlobalModelForm();
    $glmodel     = new GlobalmodelForm();
    $string= '';
    if(isset($glid)){
    foreach($mcatsList as $mrow){

      $url="http://mapi.indiamart.com/wservce/products/Userlisting/";
      $data = array( 'token' => 'imobile@15061981','mod_id' => 'GLADMIN','gluserid' => $glid ,'input_mcat_id' => $mrow);
                    
      $response=$ServiceGlobalModelForm->mapiService('USERLISTING',$url,$data,'No'); 
      //  echo "<pre>";print_r($response);exit; 
      $prddata = (array) $response;
      $string .=$mrow."##".count($prddata)."$$$";
     
     if(count($prddata) > 0){
        print trim('Dont Mark');
        exit;
     }    

    
    $geo_ip       = $glmodel->Geo_IP();
    $remote_host  = isset($geo_ip['remote']) ? $geo_ip['remote'] : '';
    $country_name = isset($geo_ip['country']) ? $geo_ip['country'] : '';
    
    // $mcat_id = '';
    $empid =Yii::app()->session['empid'];
    if (isset(Yii::app()->session['empname'])) {          
      $updatedby = Yii::app()->session['empname'];
    }


    $comments = 'BLNI Screen(Feedback)';
                $service_arr['action_flag']         ='I';
                $service_arr['mcat_id']          = $mrow; //mcatid
                $service_arr['GLUSR_USR_ID']     = $glid;        //glusrid top
                $service_arr['UPDATEDBY']        = $updatedby;        
                $service_arr['UPDATEDBY_ID']     = $empid;
                $service_arr['UPDATE_URL']       = 'gladmin.intermesh.net/index.php?r=admin_bl/Eto_rej_ofr/Index&mid=3439';
                $service_arr['IP']               = $remote_host;
                $service_arr['IP_COUNTRY']       = $country_name;
                $service_arr['MODULE']           = 'BLNI Screen(Feedback)';
                $service_arr['UPDATEDUSING']     = 'BLNI Screen(Feedback)';
                $service_arr['COMMENTS']         = $comments;
                $service_arr['HIST_COMMENT']     = "Updated through new BLNI screen";   
                $service_arr['empid']            = $empid;            
                $service_arr['VALIDATION_KEY']   = 'e02a3fab4c6c735015b9b4f4a1eb4e3c';
                $service_arr['serviceurl']         ='negative/mcat';
                $serv_model =new ServiceGlobalModelForm();
                $sth2=$serv_model->wapiServiceAPI($service_arr);
                $varOutput = $sth2;
  }
  if($sth2 == 1){
    print 'Yes';
  }else{
    print 'No';
  }
}
  

   }

   public function actionsaveCallUpdate(){
    $obj_conn = new Globalconnection(); 
    $glid = $_REQUEST['glid'];
    $final = 0;
    $micro = 0;
    $empid =Yii::app()->session['empid'];
    $radioValue = isset($_REQUEST['radioValue'])?$_REQUEST['radioValue']:'';
    if($radioValue = 'callAnswered'){
      $comment1 = 'Call Answered';
    }else{
      $comment1 = 'Call not Answered';
    }
    $glmodel = new GlobalmodelForm();  
    $imenq = $glmodel->connect_oracledb('imenq');
    $sql="INSERT
        INTO IIL_ENQ_FEEDBACKS_RESOLUTION
    (
      FK_IIL_ENQUIRY_FEEDBACK_ID,
      FK_ENQ_FINAL_DISPOSITIONS_ID,
      FK_ENQ_MICRO_DISPOSITIONS_ID,
      DISPOSITION_COMMENTS,
      IIL_ENQ_FEEDBACKS_DATE,
      IIL_ENQ_FEEDBACKS_BY_EMPLOYEE
      )
    VALUES
    (
      $glid,                   
      $final,
      $micro,
      '$comment1',
      SYSDATE,
      $empid
    )";
   
    $sth = $glmodel->ExecQuery(__FILE__, __LINE__, __CLASS__, $imenq, $sql,array());
    if($sth) {
      $dbh2=$obj_conn->connectPostgres_wr();
      $con=$dbh2;
      if($con)
      {
          $sql_inst_acc_log = "INSERT
            INTO IIL_ENQ_FEEDBACKS_RESOLUTION
            (
              FK_IIL_ENQUIRY_FEEDBACK_ID,
              FK_ENQ_FINAL_DISPOSITIONS_ID,
              FK_ENQ_MICRO_DISPOSITIONS_ID,
              DISPOSITION_COMMENTS,
              IIL_ENQ_FEEDBACKS_DATE,
              IIL_ENQ_FEEDBACKS_BY_EMPLOYEE
              )
            VALUES
            (
              $1,                   
              $2,
              $3,
              $4,
              now(),
              $5
            )";
                          $r=pg_query_params($con,$sql_inst_acc_log,array($glid,$final,$micro,"$comment1",$empid));
                          if($r)  
                          {
                              pg_query($con, 'COMMIT');
                              echo  'Yes';
      exit;
                          }else{
                            echo  'No';  exit;
                          }
          }
      echo  'Yes';
      exit;
        }
        else {
      echo  'No';  exit;
        }
   }

   public function actionsaveCaseClosure(){

    //echo "<pre>";print_r($_REQUEST);exit;
    $mcatid = $_REQUEST['mcatid'];
    $glid = $_REQUEST['glid'];
    $final = $_REQUEST['final'];
    $micro = $_REQUEST['micro'];
    $comment = $_REQUEST['comment'];
    $comment=str_replace("'", "''", $comment);
    $stringMcatid = strval($mcatid);
    $comment1 =  "Mcat Id:".$stringMcatid.'\n Comment:'.$comment;
    $empid =Yii::app()->session['empid'];  
      $objcon = new Globalconnection();   
      $con=$objcon->connectPostgres_wr();
      if($con)
      {
          $sql_inst_acc_log = "INSERT
            INTO IIL_ENQ_FEEDBACKS_RESOLUTION
            (
              FK_IIL_ENQUIRY_FEEDBACK_ID,
              FK_ENQ_FINAL_DISPOSITIONS_ID,
              FK_ENQ_MICRO_DISPOSITIONS_ID,
              DISPOSITION_COMMENTS,
              IIL_ENQ_FEEDBACKS_DATE,
              IIL_ENQ_FEEDBACKS_BY_EMPLOYEE
              )
            VALUES
            (
              $1,                   
              $2,
              $3,
              $4,
              now(),
              $5
            )";
                          $r=pg_query_params($con,$sql_inst_acc_log,array($glid,$final,$micro,"$comment1",$empid));
                          if($r)  
                          {
                              pg_query($con, 'COMMIT');
                              echo  'Yes';
      exit;
                          }else{
                            echo  'No';  exit;
                          }
          }
      echo  'Yes';
      exit;        
}  
   
 public function actionRelevancyreport(){ 
    $emp_id =Yii::app()->session['empid']; 
    if(!$emp_id)
    {
            print "Your are not logged in<BR> Click here to <A
            HREF='/index.php?action=admin'>login</A><BR>";
    }else{
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : ''; 
            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = ''; 
             }
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
     if($user_view==1)
      {
                        $obj = new eto_rej_ofr;
                        if(isset($_REQUEST['Submit']))
			  {
                                 
				 $data = $obj->showEmailRelevancyReportnew('');
				 $sth1 = $data[0];
				 $fp = $data[1];
				 $filename = $data[2];						
                            $this->render('relevancyreport',array("sth1"=>$sth1,"fp"=>$fp,"filename"=>$filename)); 
			  }else{
                            $this->render('relevancyreport',array()); 
                          }
      }
     
     }
}
 
public function actionBlgen(){ 
     $emp_id =Yii::app()->session['empid']; 
      if(!$emp_id)
		{
                      
			print "Your are not logged in<BR> Click here to <A
			HREF='/index.php?action=admin'>login</A><BR>";
		}		
     else
     {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
            
              $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = ''; 
              }

            
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
     if($user_view==1)
      {
                        $obj = new eto_rej_ofr;
                        $sth = $obj->blgen('');
                        $this->render('blgen',array("sth"=>$sth));
                                 
     }
     
     }
}

public function actionBlalrtcat(){ 
     $emp_id =Yii::app()->session['empid']; 
      if(!$emp_id)
		{
                        
			print "Your are not logged in<BR> Click here to <A
			HREF='/index.php?action=admin'>login</A><BR>";
		}		
     else
     {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
            
              $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = ''; 
              }

            
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
     if($user_view==1)
      {
                        $obj = new eto_rej_ofr;
                        $sth = $obj->blalertdetails('');
                        $this->render('blalertdetails',array("sth"=>$sth));
                                  
     }
     
     }
}


public function actionDetaildata()
   {        
     $emp_id =Yii::app()->session['empid'];
      if(!$emp_id)
		{
                      
			print "Your are not logged in<BR> Click here to <A
			HREF='/index.php?action=admin'>login</A><BR>";
		}else
            {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
            
              $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);

            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = ''; 
              }

                    
        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
       
        if($user_view==1){            
                   $obj = new eto_rej_ofr;
                    $request = Yii::app()->request;
                    $start_date= $request->getParam('start_date','');
                    $end_date= $request->getParam('end_date','');
                    $sbjVal = $_REQUEST['report'];
                    if($start_date <>'' && $end_date <>'' && $sbjVal <>''){
                        $data = $obj->detaildata('',$sbjVal,$start_date,$end_date);exit;
                    }
             
        }
    }
   }
   
public function actionexcelExport()
	{
                $timestamp=time();
                $emp = Yii::app()->session['empid']; 
		$file =  'rejection_reoprt_'.$emp.'_'.$timestamp.'.xls';
		$fileType = "application/ms-excel";
		
		$filename_return = isset($_REQUEST['filename']) ? $_REQUEST['filename'] : '';
		if($filename_return != '')
		{
			$data = file_get_contents($filename_return);				   
			header("Content-Disposition: attachment; filename=\"$file\"");
			header("Content-Type: \"$fileType\"; charset=utf-8");
			echo $data;
		}	
	}
 public function actionTopmcatreport(){
     $emp_id =Yii::app()->session['empid']; 
    if(!$emp_id)
    {
            print "Your are not logged in<BR> Click here to <A
            HREF='/index.php?action=admin'>login</A><BR>";
    }else{
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : ''; 
            $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
            if(empty($user_permissions))
            { 
                $user_permissions['TOVIEW'] = ''; 
             }
            $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
     if($user_view==1)
      {
                        $obj = new eto_rej_ofr;
                        $request = Yii::app()->request;
                        if(isset($_REQUEST['action']))
			  {
                                 
				 $data = $obj->topmcatrejected();
                                 die;
			  }else{
                                $currentDate = date("d-m-Y", strtotime(' -1 day'));
                                $currentDate7 = date("d-m-Y", strtotime(' -7 day'));
				$start_date=$start_date1= $request->getParam('start_date','');
				$start_date = (!empty($start_date)?$start_date:(!empty($currentDate7)?$currentDate7: ''));
				$end_date=$end_date1= $request->getParam('end_date','');
				$end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));
				$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
				$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));
				
                            $this->render('topmcatreport',array('start_date'=>$start_date,'end_date'=>$end_date)); 
                          }
      }
     
     }
   
}
        
}



?>