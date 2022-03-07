<?php

class OrdersController extends Controller
{
    public function actionOrderList(){
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        
        if(!$emp_id)
            {
                print "You are not logged in";
                    exit;
            }
                   
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    if(empty($user_permissions))
                    {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                    }
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        
        if($user_view==1){   
            $this->render('/OrderNow/OrderNow');
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }

    public function actionGenerateReport(){
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        
        if(!$emp_id)
            {
                print "You are not logged in";
                    exit;
            }
                   
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    if(empty($user_permissions))
                    {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                    }
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        
        if($user_view==1){
            $obj = new OrderNowModel;
            $obj->OrderListGenerator();
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }

    public function actionListPagination(){
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        
        if(!$emp_id)
            {
                print "You are not logged in";
                    exit;
            }
                   
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    if(empty($user_permissions))
                    {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                    }
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        
        if($user_view==1){ 
            $obj = new OrderNowModel;
            $obj->newPageData();
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }
    public function actiongetFullOrderDetailGladmin(){
         $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        
        if(!$emp_id)
            {
                print "You are not logged in";
                    exit;
            }
                   
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    if(empty($user_permissions))
                    {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                    }
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        
        if($user_view==1){ 
            
            
            $obj = new OrderNowModel;
            if(key_exists('oid',$_REQUEST))$data = $obj->OrderReportGeneratorAPI();
            else $data = NULL;
            $this->render('/OrderNow/ReportView',['data'=>$data]);
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }

    public function actiongetOrderDetailGladmin(){
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        
        if(!$emp_id)
            {
                print "You are not logged in";
                    exit;
            }
                   
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    if(empty($user_permissions))
                    {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                    }
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        
        if($user_view==1){ 
            
            
            $obj = new OrderNowModel;
            if(key_exists('oid',$_REQUEST))$data = $obj->OrderReportGeneratorAPI();
            else $data = NULL;
            $this->render('/OrderNow/FullReport',['data'=>$data]);
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }

    public function actionGetOrderDetail(){
        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        
        if(!$emp_id)
            {
                print "You are not logged in";
                    exit;
            }
                   
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    if(empty($user_permissions))
                    {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                    }
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        
        if($user_view==1){ 
            $obj = new OrderNowModel;
            $data = $obj->OrderReportGenerator();
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }

    public function actionCSVListDownloader(){
        $mid = $_REQUEST['mid'];
        $gl_user = $_REQUEST['gl_user'];
        $order_stage= $_REQUEST['order_stage'];
        $start_date=$_REQUEST['start_date'];
        $end_date=$_REQUEST['end_date'];
        $glid=$_REQUEST['glid'];
        $last_value=$_REQUEST['last_value'];

        $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $emp_id = Yii::app()->session['empid'];
        
        if(!$emp_id)
            {
                print "You are not logged in";
                    exit;
            }
                   
                    $user_permissions=GL_LoginValidation::CheckModulePermission($mid, $emp_id);
                    if(empty($user_permissions))
                    {
                        $user_permissions['TOVIEW'] = $user_permissions['TOEDIT']=$user_permissions['TOADD'] =$user_permissions['TODELETE']='';
                    }
                    $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        
        if($user_view==1){ 

        $obj = new OrderNowModel;
        $data = $obj-> OrderListApi($start_date,$end_date,$order_stage,$glid,$gl_user,1,$last_value);
        $data = $data['orderlist'];
        if(is_array($data))$data = json_encode($data);
        echo $data;
         }
        else{
            echo "false";
        }
    }

    public function actionModalCaller(){
        $img =  isset($_REQUEST['img'])?$_REQUEST['img']:'';
        if(strpos($img,"\/"))$img =  str_replace('\/','/',$img);
        if(!strpos($img,'https://')){
            $img =  str_replace('http://','https://',$img);
        }
        echo "<div class='modal active'>
                
                <div style='display:flex;flex-direction:column;' class='img-holder'>
                    <div style='padding:2% 0 2% 80%;'>
                       <div>
                            <button  style='background-color:#E92323;border-radius:50%;' id='btnModalClose'>X</button>
                        </div>
                    </div>
                    <div>
                        <img src='$img'/>
                    </div>
                </div>
        </div>";
    }
}