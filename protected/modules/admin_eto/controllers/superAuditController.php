<?php
class SuperAuditController extends Controller
{
    public function actionIndex()
    {
        print "HellO Audit";  exit;
        //print_r($_REQUEST);
        
        //$empId = Yii::app()->session['empid'];
     //   if ($empId > 0) {

         //   $model = new GlobalmodelForm();
         //   $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
       //     $user_permissions = $model->checklogin('', $mid, $empId);
          //  $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
            //$user_view=1;
            
          //  if ($user_view == 1) {
              /*  $JobAuditModel = new JobAuditModel();
                

                $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
                if ($action == 'getFreelanceProductDetail') {
                    //$JobAuditModel = new JobAuditModel();
                    $res = $JobAuditModel->JobAudit();
                    $this->render('/freelance/JobAuditview', array('res' => $res));
                    //echo json_encode($res);
                    return;
                }else if ($action == 'getFreelanceProductDetailFetch') {
                    //$JobAuditModel = new JobAuditModel();
                    $res = $JobAuditModel->JobAuditFetch();
                    //$this->render('/freelance/JobAuditview', array('res' => $res));
                    echo json_encode($res);
                    return;
                } else if ($action == 'saveAuditDetail') {
                    //$JobAuditModel = new JobAuditModel();
                    $res = $JobAuditModel->SaveJobAudit();
                    echo json_encode($res);
                    return;
                    
                }  else if ($action == 'saveAuditDetailAll') {
                    //$JobAuditModel = new JobAuditModel();
                    $res = $JobAuditModel->SaveJobAuditAll();
                    $res1 = $JobAuditModel->JobAuditFetch();
                    $res1['message'] = $res['message'];
                    //print_r($res1);
                    //print_r($res1);
                    echo json_encode($res1);
                    return;
                    
                } else if ($action == 'auditOk') {
                    //$JobAuditModel = new JobAuditModel();
                    $res = $JobAuditModel->auditOk();
                    echo json_encode($res);
                    return;
                }                
          //  } else {
           //     echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission of this screen <b>";
            //    exit;
          //  }
        //} else {
        //    echo "<b style='font-size:15px;color:red;padding-left:20px'>Please Login again <b>";
       //     exit;
       // }*/
    }    
}
