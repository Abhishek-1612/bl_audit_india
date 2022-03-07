<?php 
class Eto_bl_pur_limitController extends Controller
{
 public function actionIndex()
   {
  
    $loginPath  = $_SERVER['ADMIN_URL'];
  
    $emp_id =Yii::app()->session['empid'];
      
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $model = new GlobalmodelForm();
        $user_permissions = $model->checklogin('',$mid,$emp_id);
        $user_view = $user_permissions['TOVIEW'];
	$user_edit = $user_permissions['TOEDIT'];
     
	if(!$emp_id)
		{
			print "Your are not logged in<BR> Click here to <A
			HREF='/index.php?action=admin'>login</A><BR>";
		}else
            { 
            $obj = new Eto_bl_purchase_limitPG;
          
          $_REQUEST['emp_id']=$emp_id;
	  $err_msg='';
	    
		if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'purchase')
		{	  

                    $_REQUEST['action'] = 'detail';
                    $obj->showDailyLimitPurchaseForm(__FILE__, __LINE__,'',$err_msg,'',$user_view,$user_edit);
		}
		else
		{   
			$gluserid=isset($_REQUEST['gluserid']) ? $_REQUEST['gluserid'] : '';
			$gluserid=preg_replace('/^\s+|\s+$/','',$gluserid);
			if(isset($_REQUEST['email']) && $_REQUEST['email'] == '' && isset($_REQUEST['gluserid']) && $_REQUEST['gluserid'] == '' && isset($_REQUEST['comp']) && $_REQUEST['comp'] == '')
			{
				$err_msg='<font  face="arial" size="2" color="RED"> <b>&nbsp;Please enter any one of the E-Mail ID, Gluser ID or Company</b></font>';
				if (isset($_REQUEST['action']))
				{
				$_REQUEST['action']=='';
				}
			}
			elseif(isset($_REQUEST['email']) && $_REQUEST['email'] != '' && isset($_REQUEST['gluserid']) && $_REQUEST['gluserid'] != '' && isset($_REQUEST['comp']) && $_REQUEST['comp'] != '')
			{
				$err_msg='<font  face="arial" size="2" color="RED"> <b>&nbsp;Enter any one of the options.</b></font>';
				if (isset($_REQUEST['action']))
				{
				$_REQUEST['action']=='' ;
				}
			}
			elseif($gluserid && preg_match('/\D+/',$gluserid))
			{
				$err_msg='<font  face="arial" size="2" color="RED"> <b>&nbsp;GlUser ID should be Numeric</b></font>';
				if ($_REQUEST['action'])
				{
				$_REQUEST['action']== '';
				}
			}
		$obj->showDailyLimitPurchaseForm(__FILE__, __LINE__,'',$err_msg,'',$user_view,$user_edit);
		}
   
   }
   }

   public function actionleadpurchased()
   {
        echo "This Module has been disabled. Please contact GLAdmin Team";
        exit;
   }
   
   
   
    public function actionfrauddetails()
   {
        echo "This Module has been disabled. Please contact GLAdmin Team";
        exit;
   }
}   


?>
