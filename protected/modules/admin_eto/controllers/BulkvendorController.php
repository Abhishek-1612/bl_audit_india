<?php 
class BulkvendorController extends Controller
{
        public $leapMisEmp = array();
    	public function init(){
           $this->leapMisEmp = array(3575,71355,74357,5096,86777,23293);
        }
  public function actionIndex()
    {
        $empid =Yii::app()->session['empid'];
        if(!$empid)
        {
            $hostname   = $_SERVER['SERVER_NAME'];
            print "Your are not logged in<BR> Click here to <A
                HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
        }else
        {
           if(!in_array($empid,$this->leapMisEmp)){
		echo "Permission Denied";die;
	    } else{
                
            $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
            $user_view =1;
            if($user_view ==1)
            {
                $model = new BulkvendorForm();

                $process_time =  date("F j, Y, g:i a");

                $domain_serv = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : ''; 
                $pass_file         = isset($_REQUEST['excel']) ? $_REQUEST['excel'] : '';

                $model->show_html($mid, $domain_serv);

                if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'Upload') {
                    $uploaded_filename = $model->upload($empid,$mid);
                    $model->Process($empid,'excel', $mid, $user_view, $user_view, $uploaded_filename,$process_time);

                } else if (isset($_REQUEST['action1']) && $_REQUEST['action1'] == 'Process') {
                    $model->Process($empid,'excel_data', $mid, $user_view, $user_view, $pass_file,$process_time);
                }
                else {
                    print <<<as
<script language="JavaScript" type="text/javascript">document.getElementById('disable').disabled=true</script>
as;
                }

                $model->showInst();
            }else
            {
                echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
            }
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