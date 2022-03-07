<?php
class Email_validationController extends Controller {
    public function actionIndex() {
        $hostname = $_SERVER['SERVER_NAME'];
        $emp_id = Yii::app()->session['empid'];
        $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        $model = new GlobalmodelForm();
        $dbh1 = $model->connect_db();
        $user_permissions = $model->checklogin($dbh1, $mid, $emp_id);
        $user_view = $user_permissions['TOVIEW'];
        if (!$emp_id) {
            print "Your are not logged in<BR> Click here to <A
			HREF='http://$hostname/index.php?action=admin'>login</A><BR>";
        } else {
            if (isset($_REQUEST['email'])) {
                $email = $_REQUEST['email'];
            } else {
                $email = '';
            }
            if (isset($_REQUEST['frm'])) {
                $frm = $_REQUEST['frm'];
            } else {
                $frm = '';
            }
            if ($email) {
                $this->render('email_validation1', array('email' => $email));
                $obj1 = new Email_validation;
                $array = $obj1->emailStatus($email);
                $message1 = $array[0];
                $message2 = $array[1];
                $message3 = $array[2];
                $message4 = $array[3];
                $this->render('email_validation', array('message1' => $message1, 'message2' => $message2, 'message3' => $message3, 'message4' => $message4, 'email' => $email));
            } else {
                $this->render('email_validation1', array('email' => $email));
                //echo $message6;
                
            }
        }
    }
}
?>