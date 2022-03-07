<?php
class BulkISQAddController extends Controller 
{
    public function actionIndex() 
	{ 
        $empid =Yii::app()->session['empid'];
        $empname=Yii::app()->session['empname'];
        $empmail= Yii::app()->session['empemail']; 
		if(!$empid)
		{
			$hostname   = $_SERVER['SERVER_NAME'];
			print "Your are not logged in<BR> Click here to <A
			HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
		}
		else
		{
			$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';     
			$mid_list = Yii::app()->session['mid_list'];
			$user_permissions = array();
			if (!empty($mid_list)) {
				foreach ($mid_list as $key => $val) {
					if ($key == $mid)
					{
						$user_permissions = $val;             
					}
				}
				if(empty($user_permissions))
				{
					$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TODOWNLOAD'] =$user_permissions['TODELETE']='';
				}
			}
			$user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
			$user_edit        = isset($user_permissions['TOEDIT']) ? $user_permissions['TOEDIT'] : '';
			$user_download    = isset($user_permissions['TODOWNLOAD']) ? $user_permissions['TODOWNLOAD'] : '';
			$user_del    = isset($user_permissions['TODELETE']) ? $user_permissions['TODELETE'] : '';
			
			if($user_view ==1)
			{
				$process_time =  date("F j, Y, g:i:s a"); 
				$model = new GlobalmodelForm();
      
				$model_Bulkdata = new BulkISQAddForm();
				$mid              = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
				$empid            = Yii::app()->session['empid'];
				$cookie_mid       = $mid;
				$domain_serv = 'http://utils.gladmin.intermesh.net';
        
				$pass_file         = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : '';    
				
				$model_Bulkdata->show_html($cookie_mid, $domain_serv);

				if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Upload')) 
				{ 
					$uploaded_filename = $model_Bulkdata->upload($empid,$cookie_mid);
					$dbh_mesh        = $model->connect_oracledb('meshr');
					if (!$dbh_mesh) {
						$model->print_oracle_error(__FILE__, __LINE__, "Cant connect to database", "", "$DBI::errstr");
						exit;
					}
					$model_Bulkdata->Process($empid,$empname,$empmail,'excel', $cookie_mid, $user_del, $user_download, $uploaded_filename,$process_time,$dbh_mesh);

				} 
				else if (isset($_REQUEST['action1']) && ($_REQUEST['action1'] == 'Process'))
				{ 
					$dbh_mesh        = $model->connect_oracledb('meshr');
					if (!$dbh_mesh) {
						$model->print_oracle_error(__FILE__, __LINE__, "Cant connect to database", "", "$DBI::errstr");
						exit;
					}
					$model_Bulkdata->Process($empid,$empname,$empmail,'excel_data', $cookie_mid, $user_del, $user_download, $pass_file,$process_time,$dbh_mesh);    
				}
				$model_Bulkdata->showInst();
			} else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
			}
		}                     
    }
}
?>	