<?php

class BulkISQEditController extends Controller 
{
    public function actionIndex() 
	{ 
        $empid =Yii::app()->session['empid'];
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
       
				$model_Bulkdata = new BulkISQEditForm();
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
					$model_Bulkdata->Process($empid,'excel', $cookie_mid, $user_del, $user_download, $uploaded_filename,$process_time,$dbh_mesh);

				} 
				else if (isset($_REQUEST['action1']) && ($_REQUEST['action1'] == 'Process'))
				{ 
					$dbh_mesh        = $model->connect_oracledb('meshr');
					if (!$dbh_mesh) {
						$model->print_oracle_error(__FILE__, __LINE__, "Cant connect to database", "", "$DBI::errstr");
						exit;
					}
					$model_Bulkdata->Process($empid,'excel_data', $cookie_mid, $user_del, $user_download, $pass_file,$process_time,$dbh_mesh);    
				}
				$model_Bulkdata->showInst();
			} else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
			}
		}                     
    }   
	
	public function actionUpdate() 
	{ 
        $empid =Yii::app()->session['empid'];
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
       
				$model_Bulkdata = new BulkISQEditFormUpdation();
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
					$model_Bulkdata->Process($empid,'excel', $cookie_mid, $user_del, $user_download, $uploaded_filename,$process_time,$dbh_mesh);

				} 
				else if (isset($_REQUEST['action1']) && ($_REQUEST['action1'] == 'Process'))
				{ 
					$dbh_mesh        = $model->connect_oracledb('meshr');
					if (!$dbh_mesh) {
						$model->print_oracle_error(__FILE__, __LINE__, "Cant connect to database", "", "$DBI::errstr");
						exit;
					}
					$model_Bulkdata->Process($empid,'excel_data', $cookie_mid, $user_del, $user_download, $pass_file,$process_time,$dbh_mesh);    
				}
				$model_Bulkdata->showInst();
			} else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
			}
		}                     
    }
	
	public function actionexcelExport()
	{
		$screen = isset($_REQUEST['screen']) ? $_REQUEST['screen'] : '';
		$file = ($screen == 1) ? "ISQMASTERSHEET.xls" : 'ProcessedFileISQBulkEdit.csv';
		$fileType = ($screen == 1) ? "application/ms-excel" : "text/csv";
		
		$filename_return = isset($_REQUEST['filename']) ? $_REQUEST['filename'] : '';
		if($filename_return != '')
		{
			$data = file_get_contents($filename_return);
				   
			header("Content-Disposition: attachment; filename=\"$file\"");
			header("Content-Type: \"$fileType\"; charset=utf-8");
			echo $data;
		}	
	}
	
	public function actionAdd() 
	{ 
		$empid            = Yii::app()->session['empid'];
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
			$mid              = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
			$mid_list = Yii::app()->session['mid_list'];
			$user_permissions = array();
			
			if (!empty($mid_list)) 
			{
				foreach ($mid_list as $key => $val) 
				{
					if ($key == $mid){ 
						$user_permissions = $val;             
					}
				}
			}
			
			$user_edit= isset($user_permissions['TOEDIT']) ? $user_permissions['TOEDIT'] : ''; 
                        $user_del= isset($user_permissions['TODELETE']) ? $user_permissions['TODELETE'] : ''; 
                        $user_download= isset($user_permissions['TODOWNLOAD']) ? $user_permissions['TODOWNLOAD'] : ''; 
			if($user_edit==1)
			{
				
				$process_time = "PROCESS START TIME => " . date("F j, Y, g:i:s a");
				$BulkISQAddForm=new BulkISQAddForm();
				$domain_serv = 'http://utils.gladmin.intermesh.net';

				if (($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') or ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')) {
					$domain_serv = '';
				} 
				$pass_file         = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : '';  

				if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Upload') 
				{           
					$BulkISQAddForm->show_html($mid, $domain_serv);
					$uploaded_filename = $BulkISQAddForm->upload($empid,$mid);            
				} 
				elseif(isset($_REQUEST['action1']) && $_REQUEST['action1'] == 'Process') 
				{ 
					$BulkISQAddForm->show_html($mid, $domain_serv);            
					$BulkISQAddForm->Process($empid,$empname,$empmail,'excel_data', $mid, $user_del, $user_download, $pass_file,$process_time);            
				}  
				else 
				{     
					$BulkISQAddForm->show_html($mid, $domain_serv);
					print <<<as
					<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true</script>
as;
				}
				$BulkISQAddForm->showInst();
			}
			else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to Upload Data. Please contact GLAdmin team<b>";
			} 
		}  
    }

	public function actionOptionData() 
	{ 
        $empid =Yii::app()->session['empid'];
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
       
				$BulkISQOptionDataForm = new BulkISQOptionDataForm();
				$mid              = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
				$empid            = Yii::app()->session['empid'];
				$cookie_mid       = $mid;
				$domain_serv = 'http://utils.gladmin.intermesh.net';
        
				$pass_file         = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : '';    
				
				$BulkISQOptionDataForm->show_html($cookie_mid, $domain_serv);

				if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'Upload')) 
				{ 
					$uploaded_filename = $BulkISQOptionDataForm->upload($empid,$cookie_mid);
					$dbh_mesh        = $model->connect_oracledb('meshr');
					if (!$dbh_mesh) {
						$model->print_oracle_error(__FILE__, __LINE__, "Cant connect to database", "", "$DBI::errstr");
						exit;
					}
					$BulkISQOptionDataForm->Process($empid,'excel', $cookie_mid, $user_del, $user_download, $uploaded_filename,$process_time,$dbh_mesh);
				} 
				else if (isset($_REQUEST['action1']) && ($_REQUEST['action1'] == 'Process'))
				{ 
					$dbh_mesh        = $model->connect_oracledb('meshr');
					if (!$dbh_mesh) {
						$model->print_oracle_error(__FILE__, __LINE__, "Cant connect to database", "", "$DBI::errstr");
						exit;
					}
					$BulkISQOptionDataForm->Process($empid,'excel_data', $cookie_mid, $user_del, $user_download, $pass_file,$process_time,$dbh_mesh);    
				}
				$BulkISQOptionDataForm->showInst();
			} else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
			}
		}                     
    }
	
	public function actionOptionUpdate() 
	{ 
        $empid =Yii::app()->session['empid'];
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
       
				$model_Bulkdata = new BulkISQOptionEditForm();
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
					$model_Bulkdata->Process($empid,'excel', $cookie_mid, $user_del, $user_download, $uploaded_filename,$process_time,$dbh_mesh);

				} 
				else if (isset($_REQUEST['action1']) && ($_REQUEST['action1'] == 'Process'))
				{ 
					$dbh_mesh        = $model->connect_oracledb('meshr');
					if (!$dbh_mesh) {
						$model->print_oracle_error(__FILE__, __LINE__, "Cant connect to database", "", "$DBI::errstr");
						exit;
					}
					$model_Bulkdata->Process($empid,'excel_data', $cookie_mid, $user_del, $user_download, $pass_file,$process_time,$dbh_mesh);    
				}
				$model_Bulkdata->showInst();
			} else{
				echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
			}
		}                     
    }

	public function actionRemoveExcel() 
	{
        $upload_path      = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/";
        $file_name        = !empty($_GET['excel'])?$_GET['excel']:'';
        $uploadfile       = $upload_path . $file_name;
        @unlink($uploadfile);
    }
}