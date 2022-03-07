
<?php
error_reporting(1);
class DWHConnectController extends Controller
{
    public function actiondwhconnect($query)
    {
        $server = 'sqlserver-eus-prod-01.database.windows.net';
        $user = 'gladmin';
        $pass = 'Imgl!31025';
        $database = 'DATAWAREHOUSE-EUS-PROD-01';
        $pdo = '';
        try {
            $pdo = new \PDO(
                sprintf(
                    "dblib:host=%s;dbname=%s",
                    $server,
                    $database
                ),
                $user,
                $pass
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "There was a problem connecting. " . $e->getMessage();
        }


        //          $dwhConn = $this->connectDWH();
        $statement = $pdo->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<pre>";
        print_r($results);
        echo "</pre>";
        exit;
    }
    public function checkPGConnection() // PG Database connection function
    {
        $host_name = $_SERVER['SERVER_NAME'];
        $dbmodel   = new Globalconnection();
        if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
            $dbhpg_b2bsearch = $dbmodel->connect_db_yii('postgress_web77v');
        } else {
            $dbhpg_b2bsearch = $dbmodel->connect_db_yii('postgress_stdprd');

            // $dbhpg_b2bsearch = pg_pconnect("host=162.217.98.43 port=5432 dbname=b2bsrch user=impglst password=impglst4iil");
        }
        return $dbhpg_b2bsearch;
    }
    public function checkb2bsearch() // PG Database connection function
    {
        $host_name = $_SERVER['SERVER_NAME'];
        $dbmodel   = new Globalconnection();
        if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
            $dbhpg_b2bsearch = $dbmodel->connect_db_yii('postgress_devstdprd');
        } else {
            $dbhpg_b2bsearch = $dbmodel->connect_db_yii('postgress_stdprd');
            // $dbhpg_b2bsearch = pg_pconnect("host=162.217.98.43 port=5432 dbname=b2bsrch user=impglst password=impglst4iil");
        }
        return $dbhpg_b2bsearch;
    }
    public function connect_approvalpg()
    {
        $dbh = '';
        $host_name = $_SERVER['SERVER_NAME'];
        $obj = new Globalconnection();
        if ($host_name == 'dev-gladmin.intermesh.net' ||  $host_name == 'stg-gladmin.intermesh.net') {
            $dbh = $obj->connect_db_yii('postgress_devapproval');
        } else {
            $dbh = $obj->connect_db_yii('postgress_approval');
        }
        return $dbh;
    }
    public function connect_imbuyreq()
    {
        $dbh = '';
        $host_name = $_SERVER['SERVER_NAME'];
        $obj = new Globalconnection();
        if (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')) {
            $dbh = $obj->connect_db_yii('postgress_web77v');
        } else {
            $dbh = $obj->connect_db_yii('postgress_web68v');
        }
        return $dbh;
    }

    public function actionAppPGquery2()
    {
        echo '<form method="GET" action="https://dev-gladmin.intermesh.net/index?r=admin_eto/DWHConnect/AppPGquery&mid=46&sql">
        <input  type = "text" id="sql" >
       
        </form>';
    }

    public function actionAppPGquery()
    {

        echo "<style>
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
         td,th {
          padding: 2px ;
        }
        </style>";
        $table = 'glusr_usr_privacy_setting';
        $model = new GlobalmodelForm();
        $obj = new Globalconnection();
        // $dbh   = $model->connect_db(); //change you db connection here
          $dbh   =$this->connect_approvalpg();
        //   $dbh   =$this->checkb2bsearch();
        $altname = "Single Use Catheter";
        $bind = array(':kwdID' => 1254);
        $mcat_id = 142257;
        // $dbh = $this->connect_approvalpg();
        $query = "update  Glcat_cat_assignee set Glcat_cat_assignedto = 64833 where fk_cat_relation_id not in (1)";
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $query, array());
        // $result = $sth->readAll();
        // $fields_num = count($result[0]);
        echo "<h3>Table: {$table}</h3>";
        echo "<p>Query:<pre> {$query}</pre></p>";
        echo "<table><tr>";
        // printing table headers
        // for($i=0; $i<$fields_num; $i++)  
        // {
        //     $field = ($result);
        //     echo "<td>{$field->name}</td>";
        // }
        echo "</tr>\n";
        // printing table rows
        $i = 0;
        while ($row = $sth->read()) {
            if ($i == 0) {
                foreach ($row as $key => $value) {
                    echo "<th >$key</th>";
                }
                $i++;
            }

            echo "<tr>";

            // $row is array... foreach( .. ) puts every element
            // of $row to $cell variable
            foreach ($row as $cell)
                echo "<td>$cell</td>";

            echo "</tr>\n";
        }
    }
    public function actionWeberp()
    {
        $ak = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
        echo "ak is[$ak]:";
    }
    public function actionMailtrail()
    {
        $empid    = Yii::app()->session['empid'];
        $host_name = $_SERVER['SERVER_NAME'];
        $AK = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
        if ($host_name == 'dev-gladmin.intermesh.net') {
            $serviceurlPRD = "https://stg-merp.intermesh.net/index.php/gladmin/GLAdmin/gladminservice?glid=$glusr_id&empid=$empid&AK=$AK&type=mailtrail";
        } else if ($host_name == 'stg-gladmin.intermesh.net') {
            $serviceurlPRD = "https://stg-merp.intermesh.net/index.php/gladmin/GLAdmin/gladminservice?glid=$glusr_id&empid=$empid&AK=$AK&type=mailtrail";
        } else {
            $serviceurlPRD = "https://merp.intermesh.net/index.php/gladmin/GLAdmin/gladminservice?glid=$glusr_id&empid=$empid&AK=$AK&type=mailtrail";
        }
        $service_model = new ServiceGlobalModelForm();
        $rej_mailer = $service_model->mapiService('MERP_CCDETAIL', $serviceurlPRD, array(), 'No');
        print_r($rej_mailer);
    }
    public function actionDuse()
    {
        $emp_id = Yii::app()->session['empid'];
        $emp_name = Yii::app()->session['empname'];
        $model = new GlobalmodelForm();
        $ref = $model->Geo_IP();
        $remote_host = $ref['remote'];
        $country_name = $ref['country'];
        $cat_id = 598;
        $cat_assigned = 32689;
        $cat_assigned_old = 32689;
        $status = 0;
        $relation = 1;
        $start_date = '05-JAN-21';
        $end_date ='08-JAN-21';
        $hod = 32689;
        $param = array(
            'ACTION' => 'UPDATE',
            'CAT_ID' => trim($cat_id),
            'CAT_ASSIGNED' => trim($cat_assigned_old),
            'CAT_HOD' => trim($hod),
            'RELATION_ID' => trim($relation),
            'STATUS' => trim($status),
            'VALIDATION_KEY' => 'e02a3fab4c6c735015b9b4f4a1eb4e3c',
            'UPDATEDBY' => $emp_name,
            'UPDATEDBY_ID' => $emp_id,
            'UPDATEDSCREEN' => 'Gladmin(Manage Category Ownership Screen)',
            'serviceurl' => 'imcat/cat_assign',
            'IP' => $remote_host,
            'IP_COUNTRY' => $country_name
            
        );
        $param['START_DATE'] = $start_date;
        $param['END_DATE'] = $end_date;

        $service_model = new ServiceGlobalModelForm();
        $result = $service_model->wapiServiceOpAPI($param);
    }
}
?> 
