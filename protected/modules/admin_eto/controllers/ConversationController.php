<?php
// error_reporting(1);
class ConversationController extends Controller {
    public function actionIndex() {
        $emp_id = Yii::app()->session['empid'];
        $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        // if (!$emp_id) {
        //     print "You are not logged in";
        //     exit;
        // }
        // $user_permissions = GL_LoginValidation::CheckModulePermission($mid, $emp_id);
        // if (empty($user_permissions)) {
        //     $user_permissions['TOVIEW'] = $user_permissions['TOEDIT'] = $user_permissions['TOADD'] = $user_permissions['TODELETE'] = '';
        // }
        // $user_view = isset($user_permissions['TOVIEW']) ? $user_permissions['TOVIEW'] : '';
        $response = array();
        // if ($user_view == 1 ) {
            $obj = new ConversationModel;
            $start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 1;
            $submit = isset($_REQUEST["submit"]) ? $_REQUEST["submit"] : '';
            if ($submit == "submit") {
               
                $sender_id = isset($_REQUEST["sender_id"]) ? $_REQUEST["sender_id"] : '';
                $receiver_id = isset($_REQUEST["receiver_id"]) ? $_REQUEST["receiver_id"] : '';
                $total_count = isset($_REQUEST["total_count"]) ? $_REQUEST["total_count"] : '';
                $response = $obj->conversationDetails($sender_id, $receiver_id, $total_count , $start);
                if($response['code']!=200){
                  
                    echo'<p style="color:red" align="center">Some Error Occured : '.$response['response'].'</p>';
                    exit;
                }
                if($emp_id==75532){
                    echo"<pre>";
                    print_r($response);
                }
            }
            $this->render("/admineto/Conversation", array('response' => $response , 'start' => $start));
        // } else {
        //     echo "You do not have permission";
        //     exit;
        // }
    }
    public function actionMoreMessages(){
        $obj = new ConversationModel;
         $sender_id = isset($_REQUEST["sender_id"]) ? $_REQUEST["sender_id"] : '';
         $receiver_id = isset($_REQUEST["receiver_id"]) ? $_REQUEST["receiver_id"] : '';
        
         $total_count = isset($_REQUEST["total_count"]) ? $_REQUEST["total_count"] : '';
         $start = isset($_REQUEST["start"]) ? $_REQUEST["start"] : 1;
         $total_count = isset($_REQUEST["total_count"]) ? $_REQUEST["total_count"] : 0;
         $response = $obj->conversationDetails_showmore($sender_id, $receiver_id, $total_count , $start);
            echo json_encode($response);


        
       
        
    }
}
?>
