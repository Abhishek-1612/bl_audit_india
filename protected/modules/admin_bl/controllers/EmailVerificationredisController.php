<?php
class EmailVerificationredisController extends Controller{
    function actionIndex(){
        
        
        $objEmail=new EmailVerificationredis();
        $model            = new GlobalmodelForm();
        $dbh=$model->connect_db();
        $param=$_REQUEST;
        $empid=  Yii::app()->session['empid'];
        $param['empid']=$empid;
        $mid=isset($_REQUEST['mid'])?$_REQUEST['mid']:'';
        $user_permissions = $model->checklogin($dbh, $mid, $empid);
        $arrParam=array('param'=>$param);
        if(isset($user_permissions['TOEDIT']) && $user_permissions['TOEDIT']==1){
        if(isset($_REQUEST['testmailer']) && $_REQUEST['testmailer'] == 'yes'){
             
                $filename1=$objEmail->sendTestingMail($_REQUEST);
        }
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Upload') {
               
                
                $user_del=1;
                list($msg,$file_name) = $objEmail->uploadExcel($arrParam,$user_del);
                

                $arrParam['param']['msg']             =$msg;
                $arrParam['param']['file_name']       =$file_name;
                $this->render('interfaceForMailer',$arrParam);
              
            }
            elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'remove') {
                
                $user_del=$user_permissions['TODELETE']=1;;
                if($user_del){
                $upload_path      = "/home3/indiamart/public_html/excel_upload/pns_setting_update/";
                $file_name        = !empty($_REQUEST['excel'])?$_REQUEST['excel']:'';
                $msg=$objEmail->removefile($upload_path,$file_name);
                 
                
                }
                
            }
            elseif (isset($_REQUEST['action1']) && $_REQUEST['action1'] == 'Process'){
                
                //echo 'inside process';print_r($_REQUEST);die;
                $file_name=!empty($_REQUEST['file'])?$_REQUEST['file']:'';
                $filepath_upload   = '/home3/indiamart/public_html/excel_upload/pns_setting_update/';
                $filepath_download = '/home3/indiamart/public_html/excel_download/pns_setting_update/';
                if($file_name!=''){
                list($msg)=$m1->processBulk($filepath_upload,$file_name,$filepath_download);
                $req['errormsg']=$msg;
                echo $req['errormsg'];
                }
                else{
                    echo 'No file to upload';
                }
            }
            else{
                $this->render('interfaceForMailer',$arrParam);
            }
            if (isset($_REQUEST['submit']) && $_REQUEST['submit']=='Submit'){
                $ExcelArr=$objEmail->processExecl($_REQUEST);
                $param=$_REQUEST;
                $param['ExcelArr']=$ExcelArr;
                list($filename1,$file_return)=$objEmail->mailerConent($param);
                $objEmail->DownloadExcel($filename1);
                 $objEmail->setDataRedis($ExcelArr,$file_return);
                
            }
            
            
        }
        else{
            echo "NOT AUTHORIZED USER";
        }
            
           
            
        
        
    }
    function actionuploadExcel(){
        
        $objEmail=new EmailVerificationredis();
        $objEmail->uploadXCEL();
        
        if(!empty($_FILE)){echo 'file';print_r($_FILE);die;}
        Yii::import('ext.phpexcelreader.JPhpExcelReader');
        $model        = new GlobalmodelForm();
        $folder='/home3/indiamart/public_html/excel_upload/service_excel_upload/';
    }
    
    
}

