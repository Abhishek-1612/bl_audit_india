<?php
//error_reporting(0);
class Attribute_dataController extends Controller
{
 public function actionIndex()
 {     
     echo 'Report has been disabled';exit;
 }
 /*############################ Additon OF Bulk Upload of ISQ ############################*/
  
 
  public function actionBulkBBAdd() { 
  $empid            = Yii::app()->session['empid'];
    if(!$empid)
    {
        print "Your are not logged in<BR> Please login again"; exit;
    }       
     else
     {
            $mid              = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
            $mid_list = Yii::app()->session['mid_list'];
            $user_permissions = array();
            if (!empty($mid_list)) {
            foreach ($mid_list as $key => $val) {
                if ($key == $mid)
                { 
                    $user_permissions = $val;             
                }
            }
            }
            if(empty($user_permissions))
            { 
                $user_permissions['TOEDIT']= '';
            }

        $user_edit= array(27,3575,33301,51394,29092,37642,51687,55983,53236,53209,35611,61154,53298,61179,56863,52102,57681,56979,39545);
       
        if(in_array($empid,$user_edit))
         {
       $user_del=1;$user_download=1;
        $process_time = "PROCESS START TIME => " . date("F j, Y, g:i a");        
        $model_Bulkdata=new attribute_data();
       
        $domain_serv = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
        $pass_file         = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : '';  
        
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Upload') {           
            $model_Bulkdata->show_html($mid, $domain_serv);
            $uploaded_filename = $model_Bulkdata->upload($empid,$mid);            
            $model_Bulkdata->Process($empid,'excel', $mid, $user_del, $user_download, $uploaded_filename,$process_time);

        } elseif(isset($_REQUEST['action1']) && $_REQUEST['action1'] == 'Process') { 
            $model_Bulkdata->show_html($mid, $domain_serv);            
            $model_Bulkdata->Process($empid,'excel_data', $mid, $user_del, $user_download, $pass_file,$process_time);            
        }  else {     
            $model_Bulkdata->show_html($mid, $domain_serv);
            
            print <<<as
<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true</script>
as;
        }
       $model_Bulkdata->showInst();
       
     }else{
         echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to Upload Data<b>";
     } 
     }  
    }

 public function actionRemoveExcel() {
        $upload_path      = "/home3/indiamart/public_html/excel_upload/bulk_bigbuyer_input/";
        $file_name        = !empty($_GET['excel'])?$_GET['excel']:'';
        $uploadfile       = $upload_path . $file_name;
        @unlink($uploadfile);
    }

    
}

?>