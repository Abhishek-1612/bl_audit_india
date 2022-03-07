<?php
class ReportsController1 extends Controller
{
public function actionIndex()
{
  echo "called";
}
public function actioneto_bl_com()
	{
		$dbmodel = new BLGlobalmodelForm();
		$dbh = $dbmodel->connect_db();
		$email='';
		$gluserID='';
		$glusr_data='';
		$hostname=$_SERVER['SERVER_NAME'];
		$emp_id = Yii::app()->session['empid'];
		if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
				HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else if(!empty($_REQUEST['action']))
                     {
			$_REQUEST['emp_id']=$emp_id;
			if($_REQUEST['showall']==1)
			{	
				allData($dbh);
			}
			elseif($_REQUEST['getHtml'] == 1)
			{
				getHtml($dbh);
			}
			elseif($_REQUEST['updatedata'] == 'Update')
			{
				updateData($dbh);
			}
	 		else
			{     
			
			  $data= array('SERVER_NAME'=>$_SERVER['SERVER_NAME'],'IIL_CR_CUST_SEGMENT_DESC'=>$_REQUEST['IIL_CR_CUST_SEGMENT_DESC'],'IIL_CR_COM_FC_STATUS_DESC'=>$_REQUEST['IIL_CR_COM_FC_STATUS_DESC'],'IIL_CR_COM_CONSUME_DESC'=>$_REQUEST['IIL_CR_COM_CONSUME_DESC'],'IIL_CR_COM_DATE_SLAB_DESC'=>$_REQUEST['IIL_CR_COM_DATE_SLAB_DESC'],'IIL_CR_AV_CREDIT_SLAB_DESC'=>$_REQUEST['IIL_CR_AV_CREDIT_SLAB_DESC'],'IIL_CR_COM_PURPOSE'=>$_REQUEST['IIL_CR_COM_PURPOSE'],'getdata'=>$_REQUEST['getdata']);
			  $etoblcom1 = new Etoblcom;
			  $etoblcom = $etoblcom1->dispForm($dbh,$data);			 
			$result=array('mywindow'=>$etoblcom['mywindow'],'arr_cust_segment'=>$etoblcom['arr_cust_segment'],'arr_fc_status'=>$etoblcom['arr_fc_status'],'arr_consume'=>$etoblcom['arr_consume'],'arr_date_slab'=>$etoblcom['arr_date_slab'],'arr_av_credit'=>$etoblcom['arr_av_credit'],'arr_purpose'=>$etoblcom['arr_purpose'],'rec1'=>$etoblcom['rec1']);		  
			 $this->render('eto-bl-com',array('result'=>$result));	
			
			}
                       
		      }
		
	  }	
}
?>