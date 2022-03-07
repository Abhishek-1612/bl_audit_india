<?php
class Reports1Controller extends Controller
{
public function actioneto_bl_com()
	{   

		$email='';
		$mid1 = '';
		$gluserID='';
		$glusr_data='';$user_permissions=array();
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];

		if(!$emp_id)
		{
			print "Your are not logged in";exit;
		} else
                   { 
                    $dbtype='';
                    $obj = new Globalconnection();                   
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                            $dbh = $obj->connect_db_yii('postgress_web77v');   
                        }else{
                            $dbh = $obj->connect_db_yii('postgress_web68v'); 
                        }
                        $obj_etoblcom= new EtoblcomPG;
                   
                    
                    $_REQUEST['emp_id']= $emp_id;
                    $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                        if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"])) 
                        { if(!empty($_REQUEST["mid"]))
         		  {	         	   
		            $_REQUEST['emp_id']=$emp_id;
		            $model = new GlobalmodelForm();
 		            $user_permissions = $model->checklogin('',$mid,$emp_id);
                            }
			if(isset($_REQUEST['showall']) && $_REQUEST['showall']==1)
			{	$MSG_ID=$_REQUEST['mid1'];			        
	                        $emp_id=$_REQUEST['emp_id'];
	                        $updateStatus=$_REQUEST['updateStatus'];
			        $data1=array('mid1'=>$MSG_ID,'emp_id'=>$emp_id,'updateStatus'=>$updateStatus);	
                                $etoblcom = $obj_etoblcom->allData($dbh,$data1);
			        $result=array('mid'=> $_REQUEST["mid"],'SERVER_NAME'=>$_SERVER['SERVER_NAME'],'emp_id'=>$emp_id,'ID_FULL'=>$etoblcom['ID_FULL'],'MSG_ID'=>$etoblcom['MSG_ID'],'ID_MINI'=>$etoblcom['ID_MINI'],'ID_EMAIL'=>$etoblcom['ID_EMAIL'],'ID_MAIL'=>$etoblcom['ID_MAIL'],'ID_SMS'=>$etoblcom['ID_SMS'],'ID_APP'=>$etoblcom['ID_APP'],'arr'=>$etoblcom['arr'],'typehash'=>$etoblcom['typehash'],'purposehash'=>$etoblcom['purposehash'],'htmlhash'=>$etoblcom['htmlhash'],'updateStatus'=>$updateStatus);
                                $this->render('eto-bl-com3',array('result'=>$result));
			}
			elseif(isset($_REQUEST['getHtml']) && $_REQUEST['getHtml'] == 1)
			{
				
				$MSG_ID=$_REQUEST['msg_id'];
                                $etoblcom = $obj_etoblcom->getHtml($dbh,$MSG_ID);                                			        
			        echo $etoblcom;
			}
			elseif(isset($_REQUEST['updatedata']) && $_REQUEST['updatedata'] == 'Update')
			{
			    $updateStatus=$_REQUEST['updateStatus'];
		            $MSG_ID=$_REQUEST['main_id'];
			    $M_ID_FULL=$_REQUEST["M_ID_FULL_BANNER$MSG_ID"];
			    $M_ID_MAIL=$_REQUEST["M_ID_MAIL_BANNER$MSG_ID"];
			    $M_ID_MINI=$_REQUEST["M_ID_MINI_BANNER$MSG_ID"];
			    $M_ID_EMAIL=$_REQUEST["M_ID_EMAIL$MSG_ID"];
			    $M_ID_SMS=$_REQUEST["M_ID_SMS$MSG_ID"];
			    $M_ID_APP_NOTIFICATION=$_REQUEST["M_ID_APP_NOTIFICATION$MSG_ID"];
	                    $emp_id=$_REQUEST['emp_id'];
	                    $data2=array('updateStatus'=>$updateStatus,'emp_id'=>$emp_id,'MSG_ID'=>$MSG_ID,'M_ID_FULL'=>$M_ID_FULL,'M_ID_MAIL'=>$M_ID_MAIL,'M_ID_MINI'=>$M_ID_MINI,'M_ID_EMAIL'=>$M_ID_EMAIL,'M_ID_SMS'=>$M_ID_SMS,'M_ID_APP_NOTIFICATION'=>$M_ID_APP_NOTIFICATION,'emp_id'=>$emp_id);
			   
                            $etoblcom = $obj_etoblcom->updateData($dbh,$data2);			    
                            $data1=array('mid1'=>$MSG_ID,'emp_id'=>$emp_id,'updateStatus'=>$etoblcom['updateStatus']);			   
                            $etoblcom4 = $obj_etoblcom->allData($dbh,$data1);
			    $result=array('mid'=> $_REQUEST["mid"],'SERVER_NAME'=>$_SERVER['SERVER_NAME'],'emp_id'=>$emp_id,'updateStatus'=>$etoblcom['updateStatus'],'ID_FULL'=>$etoblcom4['ID_FULL'],'MSG_ID'=>$etoblcom4['MSG_ID'],'ID_MINI'=>$etoblcom4['ID_MINI'],'ID_EMAIL'=>$etoblcom4['ID_EMAIL'],'ID_MAIL'=>$etoblcom4['ID_MAIL'],'ID_SMS'=>$etoblcom4['ID_SMS'],'ID_APP'=>$etoblcom4['ID_APP'],'arr'=>$etoblcom4['arr'],'typehash'=>$etoblcom4['typehash'],'purposehash'=>$etoblcom4['purposehash'],'htmlhash'=>$etoblcom4['htmlhash']);
                            $this->render('eto-bl-com3',array('result'=>$result));
			}
			else 
		        {  
                            if(!isset($_REQUEST['getdata'])) 
                            {
                                $getdata1=0;			 
                                $data= array('SERVER_NAME'=>$_SERVER['SERVER_NAME'],'getdata'=>$getdata1);
                                $etoblcom = $obj_etoblcom->dispForm_com1($dbh,$data);
                                $result=array('user_edit'=>$user_permissions['TOEDIT'],'mid'=> $_REQUEST["mid"],'SERVER_NAME'=>$_SERVER['SERVER_NAME'],'arr_cust_segment'=>$etoblcom['arr_cust_segment'],'arr_fc_status'=>$etoblcom['arr_fc_status'],'arr_consume'=>$etoblcom['arr_consume'],'arr_date_slab'=>$etoblcom['arr_date_slab'],'arr_av_credit'=>$etoblcom['arr_av_credit'],'arr_purpose'=>$etoblcom['arr_purpose'],'getdata'=>$getdata1);		  
                                $this->render('eto-bl-com1',array('result'=>$result));
                             }
                             else
                             {
                                $data= array('SERVER_NAME'=>$_SERVER['SERVER_NAME'],'IIL_CR_CUST_SEGMENT_DESC'=>$_REQUEST['IIL_CR_CUST_SEGMENT_DESC'],'IIL_CR_COM_FC_STATUS_DESC'=>$_REQUEST['IIL_CR_COM_FC_STATUS_DESC'],'IIL_CR_COM_CONSUME_DESC'=>$_REQUEST['IIL_CR_COM_CONSUME_DESC'],'IIL_CR_COM_DATE_SLAB_DESC'=>$_REQUEST['IIL_CR_COM_DATE_SLAB_DESC'],'IIL_CR_AV_CREDIT_SLAB_DESC'=>$_REQUEST['IIL_CR_AV_CREDIT_SLAB_DESC'],'IIL_CR_COM_PURPOSE'=>$_REQUEST['IIL_CR_COM_PURPOSE']);
                                $getdata1=$_REQUEST['getdata']||0;
                                $etoblcom = $obj_etoblcom->dispForm($dbh,$data);//print_r($etoblcom);die;
                                $result=array('user_edit'=>$user_permissions['TOEDIT'],'mid'=> $_REQUEST["mid"],'SERVER_NAME'=>$_SERVER['SERVER_NAME'],'IIL_CR_CUST_SEGMENT_DESC'=>$_REQUEST['IIL_CR_CUST_SEGMENT_DESC'],'IIL_CR_COM_FC_STATUS_DESC'=>$_REQUEST['IIL_CR_COM_FC_STATUS_DESC'],'IIL_CR_COM_CONSUME_DESC'=>$_REQUEST['IIL_CR_COM_CONSUME_DESC'],'IIL_CR_COM_DATE_SLAB_DESC'=>$_REQUEST['IIL_CR_COM_DATE_SLAB_DESC'],'IIL_CR_AV_CREDIT_SLAB_DESC'=>$_REQUEST['IIL_CR_AV_CREDIT_SLAB_DESC'],'IIL_CR_COM_PURPOSE'=>$_REQUEST['IIL_CR_COM_PURPOSE'],'arr_cust_segment'=>$etoblcom['arr_cust_segment'],'arr_fc_status'=>$etoblcom['arr_fc_status'],'arr_consume'=>$etoblcom['arr_consume'],'arr_date_slab'=>$etoblcom['arr_date_slab'],'arr_av_credit'=>$etoblcom['arr_av_credit'],'arr_purpose'=>$etoblcom['arr_purpose'],'rec1'=>$etoblcom['rec1'],'getdata'=>$_REQUEST['getdata'],'dbtype'=>$dbtype);		  
                                $this->render('eto-bl-com',array('result'=>$result,'dbtype'=>$dbtype));
                             }
		        }
		        }		        
		       }                       
		     }
	  
	public function actioneto_bl_com_msg()
	{
		$email='';
		$gluserID='';
		$glusr_data='';
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = isset(Yii::app()->session['empid'])?Yii::app()->session['empid']:'';
		if(!$emp_id)
		{
			print "Your are not logged in";exit;
		}  
	        else
	        {                    
                    $dbtype='';
                    $obj = new Globalconnection();                   
                        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                        {
                            $dbh = $obj->connect_db_yii('postgress_web77v');   
                        }else{
                            $dbh = $obj->connect_db_yii('postgress_web68v'); 
                        }
                        $obj_Etoblcommsg= new EtoblcommsgPG;
                    
                    $_REQUEST['emp_id']= $emp_id;
                    if(isset($_REQUEST["mid"]) && !empty($_REQUEST["mid"])) 
                    {
	           if(!empty($_REQUEST["mid"]))
         		  {
	         	    $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
		            $_REQUEST['emp_id']=$emp_id;
		            $model = new GlobalmodelForm(); 		            
		            $user_permissions = $model->checklogin('',$mid,$emp_id);                           
		         }
	                 $_REQUEST['emp_id']= $emp_id;
	                  
		        if(isset($_REQUEST['showall']) && $_REQUEST['showall'] ==1)
			{       $MSG_ID=isset($_REQUEST['mid1'])?$_REQUEST['mid1']:'';
			        $emp_id=isset($_REQUEST['emp_id'])?$_REQUEST['emp_id']:'';
	                        $updateStatus=isset($_REQUEST['updateStatus'])?$_REQUEST['updateStatus']:'';
			        $data1=array('mid1'=>$MSG_ID,'emp_id'=>$emp_id,'updateStatus'=>$updateStatus);
			        $etoblmsg1 = $obj_Etoblcommsg->allData($dbh,$data1);
			        $data=array('mid'=> $_REQUEST["mid"],'SERVER_NAME'=>$_SERVER['SERVER_NAME'],'updateStatus'=>$updateStatus,'MSG_ID'=>$_REQUEST['mid1'],'emp_id'=>$_REQUEST['emp_id'],'rec1'=>$etoblmsg1['rec1']);		  
			        $this->render('eto-bl-com-msg3',array('data'=>$data));
			   }
			elseif(isset($_REQUEST['new']) && $_REQUEST['new'] ==1)
			{        $data=array('mid'=> $_REQUEST["mid"]);
				$this->render('eto-bl-com-msg2',array('data'=>$data));
			}
			elseif(isset($_REQUEST['insertnew']) && $_REQUEST['insertnew'] ==1)
			{       
			  
                               $data1=array('msg_id'=>$_REQUEST['msg_id'],'msg'=>$_REQUEST['msg'],'mailctg'=>$_REQUEST['mailctg'],'purpose'=>$_REQUEST['purpose'],'html1'=>$_REQUEST['html1'],'html2'=>$_REQUEST['html2'],'html3'=>$_REQUEST['html3'],'msg_type'=>$_REQUEST['msg_type']);
			       $etoblmsg1 = $obj_Etoblcommsg->insertNewMsg($dbh,$data1);
				
			}
			elseif(isset($_REQUEST['updateHTML']) && $_REQUEST['updateHTML'] ==1 )
			{  
			       $data1=array('mid1'=>$_REQUEST['mid1'],'new_msg'=>$_REQUEST['new_msg'],'new_category'=>$_REQUEST['new_category'],'new_html1'=>$_REQUEST['new_html1'],'new_html2'=>$_REQUEST['new_html2'],'new_html3'=>$_REQUEST['new_html3']);
			        $etoblmsg3 = $obj_Etoblcommsg->updateMsgData($dbh,$data1);
			        $data2=array('mid1'=>$_REQUEST['mid1'],$emp_id=$_REQUEST['emp_id'],'updateStatus'=>$etoblmsg3['updateStatus']);
			        $etoblmsg1 = $obj_Etoblcommsg->allData($dbh,$data2);
			        $data=array('mid'=> $_REQUEST["mid"],'SERVER_NAME'=>$_SERVER['SERVER_NAME'],'updateStatus'=>$etoblmsg3['updateStatus'],'MSG_ID'=>$_REQUEST['mid1'],'emp_id'=>$_REQUEST['emp_id'],'rec1'=>$etoblmsg1['rec1']);		  
			        $this->render('eto-bl-com-msg3',array('data'=>$data));
		        }else
			{
                            if(!isset($_REQUEST['getdata'])) 
                            {
                              $getdata1=0;			 
                              $data1= array('SERVER_NAME'=>$_SERVER['SERVER_NAME'],'getdata'=>$getdata1);			  
                              $etoblmsg1 = $obj_Etoblcommsg->dispForm1($dbh,$data1);			 
                              $data=array('user_add'=> $user_permissions['TOADD'],'mid'=> $_REQUEST["mid"],'arr_msg_id'=>$etoblmsg1['arr_msg_id'],'arr_purpose'=>$etoblmsg1['arr_purpose'],'arr_msg_type'=>$etoblmsg1['arr_msg_type']);
                              $this->render('eto-bl-com-msg',array('data'=>$data));
                            }else
                             {
                                 $data1= array('SERVER_NAME'=>$_SERVER['SERVER_NAME'],'getdata'=>$_REQUEST['getdata'],'IIL_CR_COM_MESSAGE_ID'=>$_REQUEST['IIL_CR_COM_MESSAGE_ID'],'IIL_CR_COM_MESSAGE_TYPE'=>$_REQUEST['IIL_CR_COM_MESSAGE_TYPE'],'IIL_CR_COM_PURPOSE'=>$_REQUEST['IIL_CR_COM_PURPOSE']);
                                 $getdata1=$_REQUEST['getdata']||0;			  
                                 $etoblmsg1 = $obj_Etoblcommsg->dispForm($dbh,$data1);			 
                                 $data=array( 'user_add'=> $user_permissions['TOADD'],'mid'=> $_REQUEST["mid"],'getdata'=>$_REQUEST['getdata'],'rec1'=>$etoblmsg1['rec1'],'IIL_CR_COM_MESSAGE_ID'=>$_REQUEST['IIL_CR_COM_MESSAGE_ID'],'IIL_CR_COM_MESSAGE_TYPE'=>$_REQUEST['IIL_CR_COM_MESSAGE_TYPE'],'IIL_CR_COM_PURPOSE'=>$_REQUEST['IIL_CR_COM_PURPOSE'],'arr_msg_id'=>$etoblmsg1['arr_msg_id'],'arr_purpose'=>$etoblmsg1['arr_purpose'],'arr_msg_type'=>$etoblmsg1['arr_msg_type']);
                                 $this->render('eto-bl-com-msg1',array('data'=>$data,'dbtype'=>$dbtype));
                             }
			}
	        }
    }
}
}
?>