<?php 
class Contact_detailsController extends Controller
{
public function ActionDetails() 
{ 
    $path = $_SERVER['SERVER_NAME'];
    $obj=new SuperAuditForm();
    $request = Yii::app()->request;
    $offerid=isset($_REQUEST["offerID"]) ? $_REQUEST["offerID"] : '';
    $statusDesc = array('W' => 'Waiting', 'A' => 'Approved');
    $userStatusDesc = array('W' => 'Waiting', 'A' => 'Approved', 'D' => 'Disabled', 'M' => 'Error Disabled');
    $glModel = new GlobalmodelForm();
    $mid =isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
    $jobtype=$obj->taskdata($offerid);
    $job_type_id= $jobtype['jobtype'];
    $task_detail_id=$jobtype['task_detail_id'];
    if($action == 'posted')
    {   
        $resultData = $obj->editOffer($request, '', $path, $statusDesc, $userStatusDesc, '', '', $offerid, $glModel);
        $rec = $resultData['rec'];
        $ofrStatus = isset($resultData['status']) ? $resultData['status'] : '';
        $status_check = isset($resultData['status']) ? $resultData['status'] : '';
        $arr_map_ref = $obj->getCatMcatDetail($offerid, $glModel, $ofrStatus);
        $returnArr = array( 'result' => $resultData,  'status_check'=>$status_check,'jobtype'=>$jobtype,'arr_map_ref' => $arr_map_ref);
        $this->render('/audit/posted_details',$returnArr);  
    }
    if($action == 'contact')
    {   
        $resultData = $obj->editOffer($request, '', $path, $statusDesc, $userStatusDesc, '', '', $offerid, $glModel);
        $rec = $resultData['rec'];
        $ofrStatus = isset($resultData['status']) ? $resultData['status'] : '';
        $status_check = isset($resultData['status']) ? $resultData['status'] : '';
        $arr_map_ref = $obj->getCatMcatDetail($offerid, $glModel, $ofrStatus);
        $returnArr = array( 'result' => $resultData,  'status_check'=>$status_check,'jobtype'=>$jobtype,'arr_map_ref' => $arr_map_ref);
        $this->render('/audit/contact_glusr',$returnArr);  
    }
}


}
?>