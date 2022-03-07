<?php

class IntentReportController extends Controller
{

    public function actionIndex()
    {
        $this->render('/DIRView/DIRView');
    }


    public function actionIntentReport()
    {


        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
        if(empty($user_permissions))
        {
            $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
        }
        $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
       
        if($user_view==1){

            $model = new DIRModel;
            $sqlModel = new QueryModel;
            $select = $_REQUEST['select'] == 0 ?null:$_REQUEST['select']-1;
            $condition = $this->conditionForQuery($_REQUEST['type'],$select);
            $query = $sqlModel->queryStore($_REQUEST['trend'],$_REQUEST['data'],$_REQUEST['type'],$_REQUEST['start_date'],$_REQUEST['end_date'],$condition);

            if($_REQUEST['trend']==='generation'&&$_REQUEST['data']==='hourly'&&($_REQUEST['type']==='intent-type-wise'||$_REQUEST['type']==='rag-wise'))
            {
                echo "<div style='width:100%;display:flex;align-items:center;justify-content:center;'><img style='width:30%;' src='./gifs/no-data.svg'/></div>";
                exit;
            }

            if($query != ""){
                $data = $model->IntentWise($query,$_REQUEST['data']);
                $this->render('/DIRView/DIRdata',['data'=>$data]);
            }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }


    public function conditionForQuery($type,$cond_num=null){

        $condition = [
            'modid-wise'=>["'IMOB'","'DIR'","'ANDROID'","'IOS'","'FCP'","'PRODDTL'","'IM'","'MY'"],

            'intent-type-wise'=>["'1'","'2'","'11'","'16'","'17'","'18'","'12'","'14'","'3'"],

            'rag-wise'=>["1005,1015,1025","1004, 1014,1024","1003, 1013, 1023","1002, 1012, 1022","1001, 1011, 1021" ],
         ];


        $count = 0;


        if($cond_num > -1)
        {
             return $condition[$type][$cond_num];
        }
        else
        {
             $condition_val ="";
             foreach ($condition[$type] as $value) {
                $count++;
                $condition_val = $condition_val." ".$value;
                if($count < count($condition[$type])) $condition_val = $condition_val.",";
             }
             return $condition_val;
        }
    }


}
