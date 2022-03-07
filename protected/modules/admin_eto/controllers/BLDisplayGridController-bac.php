<?php 
class BLDisplayGridController extends Controller
{
    public function actionIndex()
    {  // print_r($_REQUEST);
        $empid =Yii::app()->session['empid'];
        if(!$empid)
        {
            $hostname   = $_SERVER['SERVER_NAME'];
            print "Your are not logged in<BR> Click here to <A
                HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
        }else
        {
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
           /*     $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
            * 
            */		
	    $user_view =1;// isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
            $user_download   = 1;//=isset($user_permissions['TODOWNLOAD']) ? $user_permissions['TODOWNLOAD'] : '';
            $user_del         =1;// isset($user_permissions['TODELETE']) ? $user_permissions['TODELETE'] : '';
            if($user_view ==1)
            {
                $model = new BLDisplayGridForm();

                $process_time =  date("F j, Y, g:i a");

                $domain_serv = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
                $pass_file         = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : '';                
                $pass_file_name    = isset($_REQUEST['excel_name']) ? $_REQUEST['excel_name'] : '';
                $uploaded_filename = '';
                $model->show_html($mid, $domain_serv);

                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Upload') {
                    $uploaded_filename = $model->upload($empid,$mid);
                    $model->Process($empid,'excel', $mid, $user_del, $user_download, $uploaded_filename,$process_time);
                    die;
                } else if (isset($_REQUEST['action1']) && $_REQUEST['action1'] == 'Process') {
                    $model->Process($empid,'excel_data', $mid, $user_del, $user_download, $pass_file,$process_time);
                } else if ($pass_file_name != '' || $pass_file != '') {                    
                            $file_path = '/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/' . $pass_file;                            
                            if (file_exists("$file_path")) {
                                unlink("$file_path");
                            }            
                        }

            }else
            {
                echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
            }
        }
    }

    public function actionRemoveExcel() {
        $upload_path      = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/";
        $file_name        = !empty($_GET['excel'])?$_GET['excel']:'';
        $uploadfile       = $upload_path . $file_name;
        @unlink($uploadfile);
    }
     public function actionDownloadwithdb() 
	{
		$empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}  
               /* $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
                * 
                */		
		$user_view =1;// isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
                if($user_view==1){
                $request = Yii::app()->request;
                $currentDate = date("d-m-Y");

                $start_date= $request->getParam('start_date','');
		$start_date = (!empty($start_date)?$start_date:(!empty($currentDate)?$currentDate: ''));		
		$start_date = strtoupper(date("d-M-Y",strtotime($start_date)));
		$end_date=$request->getParam('start_date','');
                $end_date = (!empty($end_date)?$end_date:(!empty($currentDate)?$currentDate: ''));		
		$end_date = strtoupper(date("d-M-Y",strtotime($end_date)));

                $dataArr=array();
               
		  $obj =new BLDisplayGridForm;	
                  if(isset($_REQUEST['submit_view']))
                   {
                         $dataArr=$obj->downloadWithDb($start_date);  
                   }else{
                          $this->render('/bldisplaygrid/downloaddata',array('start_date'=>$start_date,'end_date'=>$end_date));                      
                   }  
                }else{
                    echo "You do not have permission";
                    exit;
                }
	}  
	public function actionGethist()
        {
                $empId = Yii::app()->session['empid'];
		$mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
                if(!$empId)
		{
			print "You are not logged in";
                        exit;
		}  
              /*  $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $empId);
		if(empty($user_permissions))
		{
		$user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
		}
               * 
               */		
		$user_view = 1;//isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';  
                if($user_view==1){

                  if(isset($_REQUEST['submit_view']))
                   {
                        $obj =new BLDisplayGridForm;
                        echo $resp= $obj->gethistory();die;
                   }else{
                        $this->render('/bldisplaygrid/gridhist',array());                      
                   } 
                }else{
                    echo "You do not have permission";
                    exit;
                }
        }
}
