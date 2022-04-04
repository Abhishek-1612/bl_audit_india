<?php
class Globalconnection extends CFormModel {
    public $host_name;
    function __construct() {
        $this->host_name = $_SERVER['SERVER_NAME'];

    }
    public function connect_db_yii($db_name, $data = array()) //USE
    {
        $dbh = '';
        $CONN = '';
        if ($db_name == 'postgress_devapproval') $CONN = 'POSGRESS_devapproval';
        elseif ($db_name == 'postgress_approval') $CONN = 'POSGRESS_approval';
        elseif ($db_name == 'postgress_web77v') $CONN = 'POSTGRESS_web77v';
        elseif ($db_name == 'postgress_web68v') $CONN = 'POSTGRESS_web68v';
            try {
                $dbh = $this->make_db_yii($db_name);
                return $dbh;
            }catch(Exception $e) {
            }
    }
    private function make_db_yii($db_name) {
        $dbh = Yii::app()->$db_name; 
        return $dbh;
    }
    public function connect_approvalpg(){
		$dbh = '';     
        if ($this->host_name == 'dev-gladmin.intermesh.net' || $this->host_name == 'stg-gladmin.intermesh.net') {
			$dbh = $this->connect_db_yii('postgress_devapproval');   
		}else{
			$dbh = $this->connect_db_yii('postgress_approval');
		}
		return $dbh;
    }

 
}
?>
