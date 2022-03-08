<?php
class GlobalmodelForm extends CFormModel {
    public $IS_ADULT;
    public $searchid;
    public $edit;
    public $ID;
    public $APPROV;
    public $str_add1;
    public $str_add2;
    public $website;
    public $city_others;
    public $prd_listing;
    public $prd_sell;
    /**
     * Declares the validation rules.
     */
    public function p($value) {
        echo '<pre>';
        print_r($value);
        exit();
    }
    public function pe($value) {
        echo '<pre>';
        print_r($value);
    }
    public function connect_db() { //userapproval
        $obj = new Globalconnection();
        return $obj->connect_db_mesh();
    }
    public function connect_oracledb($db) {
        $obj = new Globalconnection();
        return $obj->connect_oracledb($db);
    }
    public function connect_db_oci() {
        $obj = new Globalconnection();
        return $obj->connect_db_oci('mesh');
    }
    public function connect_db_oci_main() {
        $obj = new Globalconnection();
        return $obj->connect_db_oci('main');
    }
    public function Sendmail($file_name, $lineno, $to, $from, $cc, $subject, $message, $sender_name) {
        $host_name = $_SERVER['SERVER_NAME'];
        if ($host_name == 'dev-gladmin.intermesh.net' or $host_name == 'stg-gladmin.intermesh.net') {
            echo $message;
        } else {
            if (empty($sender_name)) $sender_name = 'Gladmin-Team';
            if (empty($from)) $from = 'gladmin-team@indiamart.com';
            if (empty($to)) $to = 'gladmin-team@indiamart.com';
            $headers = "From:" . $sender_name . "<" . $from . ">\n" . "Reply-To:$to\n" . "Cc:$cc\n" . "MIME-Version: 1.0 \n" . "Content-type: text/plain; charset=UTF-8";
            mail($to, $subject, $message, $headers);
        }
    }
    public function send_oracle_error($file_name, $lineno, $class, $users_message, $error, $oracle_query, $to, $from, $cc, $subject, $sender_name) {
        $message = "DATABASE ERROR\n\n";
        $message.= "File Name	          :  $file_name\n";
        $message.= "Line Number          :  $lineno\n";
        $message.= "Querystring          : " . getenv('QUERY_STRING') . "\n";
        $message.= "User Message         :  $users_message\n";
        $message.= "DB Error Message :  $error\n";
        $message.= "DB Error Query   :  $oracle_query\n";
        $message.= "====================================\n";
        $message.= "IP Address	          : " . getenv('HTTP_X_FORWARDED_FOR') . "\n";
        $message.= "Browser	          : " . getenv('HTTP_USER_AGENT') . "\n";
        $message.= "Referer	          : " . getenv('HTTP_REFERER') . "\n";
        $message.= "Request_Url          : " . getenv('request_URI') . "\n";
        $message.= "Script_Filename      :" . getenv('SCRIPT_FILENAME') . "\n";
        $message.= "====================================\n";
        $this->Sendmail($file_name, $lineno, $to, $from, $cc, $subject, $message, $sender_name);
    }
    public function print_oracle_error($class, $file_name, $lineno, $users_message, $error, $oracle_query) {
        $this->send_oracle_error($file_name, $lineno, $class, $users_message, $error, $oracle_query, '', '', '', 'Database Could Not Be Connected', '');
        $this->printError('Database Could Not Be Connected', $users_message);
        exit;
    }
    public function printError($message, $dbName) {
        if (empty($dbName)) $dbName = 'Oracle';
        $databaseName = "Database Name = " . $dbName;
        $errorArray = array("DATABASE ERROR", "Can't Prepare the Database", "Can't Execute the SQL Statement", "Database Connectivity Failed!");
        $error = $errorArray[0];
        if (preg_match("/failed to open/", $message)) {
            $error = $errorArray[1];
        } elseif (preg_match("/failed to execute/", $message)) {
            $error = $errorArray[2];
        } elseif (preg_match("/Could not connect to ORACLE/", $message)) {
            $error = $errorArray[3];
        }
        echo '<B style=font-size:13px;color:#FF0000;padding-left:8px>' . $error . ' - ' . $databaseName . '</B>';
        exit;
    }
    public function oracle_error_message_modified($class, $error) {
        $oracle_error_message_modified = '';
        $oracle_error_message = $error;
        if (preg_match("/ORA-01017: invalid username\/password/is", $oracle_error_message, $matches)) {
            $oarcle_error_message_modified = 'Invalid UserName/Password.';
        } elseif (preg_match("/ORA-00001: unique constraint \((.*?)\.(.*?)\)/is", $oracle_error_message, $matches)) {
            $oracle_error_message_modified = 'Unique Constraint Violated on ' . $_2;
        } elseif (preg_match("/ORA-00942: table or view does not exist /is", $oracle_error_message, $matches)) {
            $oracle_error_message_modified = 'Table does not exists.';
        } elseif (preg_match("/ORA-01034: ORACLE not available/is", $oracle_error_message, $matches)) {
            $oracle_error_message_modified = 'ORACLE not available.';
        } elseif (preg_match("/ORA-00904: invalid column name/is", $oracle_error_message, $matches)) {
            $oracle_error_message_modified = 'Invalid Column Name.';
        } else {
            $oracle_error_message_modified = "Sorry, your request could not be processed because the database is down for maintenance purposes. Please try again after some time.";
        }
        return ($oracle_error_message_modified);
    }
    public function replace_nohtml($data) {
        if ($data) {
            preg_replace('s/\>/\&gt', '', $data);
            preg_replace('s/\>/\&lt', '', $data);
            preg_replace(' s/\"/\&quot', '', $data);
            return ($data);
        } else {
            return 0;
        }
    }
//     public function GetSalute_bootstrap($selected) {
//         $readonly = '';
//         $selected = preg_replace('/\s+/', "", $selected);
//         $select = '<SELECT NAME="salute" ID="salute"  class="input-mini">';
//         if ($selected == "Ms.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms." SELECTED>Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= 'OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mr.") {
//             $select.= '<OPTION VALUE="Mr." SELECTED>Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mrs.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs."  SELECTED>Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Dr.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr." SELECTED>Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE="" SELECTED></OPTION>';
//         }
//         $select.= '</select>';
//         return $select;
//     }
//     public function GetCSalute_bootstrap($selected) {
//         $readonly = '';
//         $selected = preg_replace('/\s+/', "", $selected);
//         $select = '<SELECT NAME="csalute"  ID="salute"  class="input-mini">';
//         if ($selected == "Ms.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms." SELECTED>Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= 'OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mr.") {
//             $select.= '<OPTION VALUE="Mr." SELECTED>Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mrs.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs."  SELECTED>Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Dr.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr." SELECTED>Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE="" SELECTED></OPTION>';
//         }
//         $select.= '</select>';
//         return $select;
//     }
    public function GetSalute($selected) {//production
        $readonly = '';
        $selected = preg_replace('/\s+/', "", $selected);
        $select = '<SELECT ID="salute" NAME="salute">';
        if ($selected == "Ms.") {
            $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
            $select.= '<OPTION VALUE="Ms." SELECTED>Ms. </OPTION>';
            $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
            $select.= 'OPTION VALUE="Dr.">Dr. </OPTION>';
            $select.= '<OPTION VALUE=""></OPTION>';
        } else if ($selected == "Mr.") {
            $select.= '<OPTION VALUE="Mr." SELECTED>Mr. </OPTION>';
            $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
            $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
            $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
            $select.= '<OPTION VALUE=""></OPTION>';
        } else if ($selected == "Mrs.") {
            $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
            $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
            $select.= '<OPTION VALUE="Mrs."  SELECTED>Mrs. </OPTION>';
            $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
            $select.= '<OPTION VALUE=""></OPTION>';
        } else if ($selected == "Dr.") {
            $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
            $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
            $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
            $select.= '<OPTION VALUE="Dr." SELECTED>Dr. </OPTION>';
            $select.= '<OPTION VALUE=""></OPTION>';
        } else {
            $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
            $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
            $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
            $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
            $select.= '<OPTION VALUE="" SELECTED></OPTION>';
        }
        $select.= '</select>';
        return $select;
    }
//     public function GetCSalute($selected) {
//         $readonly = '';
//         $selected = preg_replace('/\s+/', "", $selected);
//         $select = '<SELECT NAME="csalute">';
//         if ($selected == "Ms.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms." SELECTED>Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= 'OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mr.") {
//             $select.= '<OPTION VALUE="Mr." SELECTED>Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mrs.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs."  SELECTED>Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Dr.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr." SELECTED>Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE="" SELECTED></OPTION>';
//         }
//         $select.= '</select>';
//         return $select;
//     }
    public function GetCountryWithPhCode($file_name, $lineno, $dbh, $country) {
        $st = "SELECT * FROM GL_COUNTRY ORDER BY GL_COUNTRY_NAME";
        $sql_handler = $dbh->createCommand($st);
        $list = $sql_handler->query();
        $select = 0;
        $count = 1;
        $phcode_arr;
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : '';
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        if ($list) {
            $phcode_arr = 'var phonecode = new Array();';
            $phcode_arr.= '\n phonecode[0] = ""; \n ';
            if ($company == 'readonly') {
                $tr1.= '<SELECT readonly onfocus="this.blur()" style="pointer-events: none;" NAME=\"country\" onChange=\"check_country()\">';
            } else {
                $tr1.= '<SELECT NAME=\"country\" onChange=\"check_country()\">';
            }
            $select.= '<OPTION VALUE=\"0\">---Choose One---</OPTION>';
            while ($h = $list->read()) {
                $value = $h['GL_COUNTRY_ISO'];
                $name = $h['GL_COUNTRY_NAME'];
                if (!empty($h['GL_COUNTRY_PHONECODE'])) {
                    $code = $h['GL_COUNTRY_PHONECODE'];
                } else {
                    $code = '';
                }
                $phcode_arr.= "phonecode[$count] =" . $code . '; \n';
                $count++;
                if ($country == $value) {
                    $select.= '<OPTION VALUE=' . $value . 'SELECTED>' . $name . '</OPTION>';
                } else {
                    $select.= '<OPTION VALUE=' . $value . '>' . $name . '</OPTION>';
                }
            }
            $select.= '</SELECT>';
            $select.= '<INPUT TYPE=\"HIDDEN\" NAME=\"sel_country\" value=' . $country . '>';
            $h['select'] = $select;
            $h['phcode_arr'] = $phcode_arr;
        }
        return $h;
    }
    public function GetBizNatureGlusr_bootstrap($biz) {
        $readonly = '';
        if (isset($biz)) {
            $biz1 = $biz;
        } else {
            $biz1 = '';
        }
        $keywords = preg_split("/,/", $biz1);
        $list = CommonVariable::GetPrimaryBizNature_values();
        $select = '';
        $tr = '';
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : '';
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        if ($list) {
            $i = 1;
            $tr1 = '<tr>';
            foreach ($list as $key => $value) {
                if (preg_grep("/^$key/", $keywords)) {
                    if ($company == 'readonly') {
                        $tr1.= '<TD nowrap><INPUT readonly onfocus="this.blur()" style="pointer-events: none;" TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '" CHECKED> ' . $value . '</TD>';
                    } else {
                        $tr1.= '<TD nowrap><INPUT TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '" CHECKED> ' . $value . '</TD>';
                    }
                } else {
                    if ($company == 'readonly') {
                        $tr1.= '<TD nowrap><INPUT readonly onfocus="this.blur()" style="pointer-events: none;" TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '"> ' . $value . '</TD>';
                    } else {
                        $tr1.= '<TD nowrap><INPUT TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '"> ' . $value . '</TD>';
                    }
                }
                if ($i % 3 == 0) {
                    $i = 0;
                    $tr1.= '</tr><tr>';
                }
                $i++;
            }
            $tr1.= '</tr>';
        }
        return $tr1;
    }
    public function GetBizNatureGlusr($biz) {
        $readonly = '';
        if (isset($biz)) {
            $biz1 = $biz;
        } else {
            $biz1 = '';
        }
        $keywords = preg_split("/,/", $biz1);
        $list = CommonVariable::GetPrimaryBizNature_values();
        $select = '';
        $tr = '';
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : '';
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        if ($list) {
            $i = 1;
            $count = 14;
            foreach ($list as $key => $value) {
                $width = '';
                if (preg_grep("/^$key/", $keywords)) {
                    if ($company == 'readonly') {
                        $select.= '<TD nowrap><INPUT readonly onfocus="this.blur()" style="pointer-events: none;" TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '" CHECKED> ' . $value . '</TD>';
                    } else {
                        $select.= '<TD nowrap><INPUT TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '" CHECKED> ' . $value . '</TD>';
                    }
                } else {
                    if ($company == 'readonly') {
                        $select.= '<TD nowrap><INPUT readonly onfocus="this.blur()" style="pointer-events: none;" TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '"> ' . $value . '</TD>';
                    } else {
                        $select.= '<TD nowrap><INPUT TYPE="CHECKBOX" NAME="biz[]" value="' . $key . '"> ' . $value . '</TD>';
                    }
                }
                if ($i % 4 == 0) {
                    $tr.= '<tr>' . $select . '</tr>';
                    $select = '';
                } else if ($i % 4 == 3 && $i == $count) {
                    $tr.= '<tr>' . $select . '<TD></td></tr>';
                    $select = "";
                } else if ($i % 4 == 2 && $i == $count) {
                    $tr.= '<tr>' . $select . '<TD></td><TD></td></tr>';
                    $select = '';
                } else if ($i % 4 == 1 && $i == $count) {
                    $tr.= '<tr>' . $select . '<TD></td><TD></td><TD></td></tr>';
                    $select = '';
                }
                $i++;
            }
        }
        return $tr;
    }
//     public function GetModName($file_no, $lineno, $dbh, $modid) {
//         $st = "SELECT GL_MODULE_NAME FROM GL_MODULE WHERE GL_MODULE_ID=UPPER(:mid)";
//         $sql_handler = $dbh->createCommand($st);
//         $sql_handler->bindValue(":mid", $modid);
//         $list = $sql_handler->query();
//         $data = $list->read();
//         return $data['GL_MODULE_NAME'];
//     }
    public function ShowClient($cust_wt) {//Searchbyuser
        if ($cust_wt == 5) {
            $r = '[<FONT COLOR=BLUE>MKTP</FONT>]';
        } else {
            $r = '[<FONT COLOR=BLUE>CLIENT</FONT>]';
        }
        return $r;
    }
    public function Privacy_Warning($file_no, $lineno, $dbh, $gl_id, $privacy_id) {
        $comnt = '';
        $st = 'SELECT count(1) CNT FROM GLUSR_USR_PRIVACY_SETTING WHERE FK_GLUSR_USR_ID =:FK_GLUSR_USR_ID AND FK_MY_PRIVACY_SETTING_ID=:FK_MY_PRIVACY_SETTING_ID';
        $sql_handler = $dbh->createCommand($st);
        $sql_handler->bindValue(":FK_MY_PRIVACY_SETTING_ID", $privacy_id);
        $sql_handler->bindValue(":FK_GLUSR_USR_ID", $gl_id);
        $list = $sql_handler->query();
        $data = $list->read();
        if (!empty($data['CNT'])) {
            $count = $data['CNT'];
            $comnt = 'Client has DISABLED modification on his catalog. Please contact client before making any modification.';
        }
        return $comnt;
    }
    public function SendHtmlMail($file_name, $lineno, $to, $from, $cc, $subject, $message, $sender_name) {
        $host_name = $_SERVER['SERVER_NAME'];
        if ($host_name == 'dev-gladmin.intermesh.net' or $host_name == 'stg-gladmin.intermesh.net') {
            $to = 'gladmin-team@indiamart.com';
        }
        $headers = "From:$from \n" . "Reply-To:$to\n" . "Cc:$cc\n" . "MIME-Version: 1.0 \n" . "Content-type: text/html; charset=UTF-8";
        mail($to, $subject, $message, $headers);
    }
    public function readfile($class, $file_name, $path) {
        if (file_exists($file_name)) {
            $file = fopen($path, 'r');
            while (!feof($file)) {
                $data = fgets($file);
                echo $data;
            }
            fclose($file);
        } else {
            echo 'Could Not open file.' . $file_name;
        }
    }
    function GetUsrStatus($class, $file_name, $lineno, $dbh, $usr_oremail, $isuserid)
    {//glprofileform
        if (empty($isuserid)) {
            $isuserid = 0;
        }
        $st = "";
        if (!empty($isuserid)) {
            $st = "SELECT GLUSR_USR_APPROV, GLUSR_USR_MODIFYSTATUS, GLUSR_USR_TOFREELIST FROM GLUSR_USR WHERE GLUSR_USR_ID=:usr";
        } else {
            $st = "SELECT GLUSR_USR_APPROV, GLUSR_USR_MODIFYSTATUS, GLUSR_USR_TOFREELIST FROM GLUSR_USR WHERE GLUSR_USR_EMAIL_DUP=UPPER(:usr)";
        }
        $sth = $dbh->createCommand($st);
        $sth->bindValue(':usr', $usr_oremail);
        $list = $sth->query();
        $h = $list->read();
        if (!isset($h['GLUSR_USR_APPROV'])) {
            $h['GLUSR_USR_APPROV'] = '';
        }
        if (!isset($h['GLUSR_USR_MODIFYSTATUS'])) {
            $h['GLUSR_USR_MODIFYSTATUS'] = '';
        }
        if (!isset($h['GLUSR_USR_TOFREELIST'])) {
            $h['GLUSR_USR_TOFREELIST'] = '';
        }
        return $h;
    }
    public function Insert_StatusHistory($file_name, $lineno, $dbh, $uid, $emp_id, $app, $old_app, $mod_apptofreelist, $old_apptofreelist) {// userd in GlMyProfileForm
        $st1 = "INSERT INTO GLUSR_STATUSHISTORY VALUES ('', :uid1, :emp_id, :app,
	SYSDATE,:old_app, :mod_apptofreelist, :old_apptofreelist)";
        $sth = $dbh->createCommand($st1);
        $sth->bindValue(':uid1', $uid);
        $sth->bindValue(':emp_id', $emp_id);
        $sth->bindValue(':app', $app);
        $sth->bindValue(':old_app', $old_app);
        $sth->bindValue(':mod_apptofreelist', $mod_apptofreelist);
        $sth->bindValue(':old_apptofreelist', $old_apptofreelist);
        $sth->execute();
    }
    // Function CheckUniqueByID($file_name, $lineno, $dbh, $table, $field, $value, $usrid) { //userapproval
    //     $st = "SELECT GLUSR_USR_ID FROM $table where $field = :value AND GLUSR_USR_ID<>UPPER(:usrid)";
    //     $sth = $dbh->createCommand($st);
    //     $sth->bindValue(':value', $value);
    //     $sth->bindValue(':usrid', $usrid);
    //     $list = $sth->query();
    //     $h = $list->read();
    //     if ($h) {
    //         $row = $h;
    //         if ($row) {
    //             return 1;
    //         } else {
    //             return 0;
    //         }
    //     } else {
    //         return 0;
    //     }
    // }
    Function ValidateEmail($email) { //userapproval
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please enter your correct E-mail ID.";
        } else {
            $email_err = 0;
        }
    }
    // Function ApproveUsr($class_name, $file_name, $lineno, $dbh, $id, $app, $admincomment, $emp_id) //userapproval
    // {
    //     $data = $_REQUEST;
    //     $args = array();
    //     $updatedby = '';
    //     $h1 = array();
    //     $h1['GL_EMP_NAME'] = $this->getEmpName($dbh, $emp_id);
    //     $updatedby = "'" . $h1['GL_EMP_NAME'] . "'";
    //     $geo_ip = $this->Geo_IP();
    //     $remote_host = $geo_ip['remote'];
    //     $country_name = $geo_ip['country'];
    //     $updatedusing = 'Gladmin';
    //     if ($app == 'D') {
    //         $args['APPROV_REASON'] = $data['editb'];
    //     }
    //     $ct = 0;
    //     $MO = 'F';
    //     $args['VALIDATION_KEY'] = 'e02a3fab4c6c735015b9b4f4a1eb4e3c';
    //     $args['UPDATEDBY'] = $updatedby;
    //     $args['UPDATEDUSING'] = 'Gladmin';
    //     $args['IP'] = $remote_host;
    //     $args['IP_COUNTRY'] = $country_name;
    //     $args['HIST_COMMENTS'] = $admincomment;
    //     $args['USR_ID'] = $id;
    //     $args['APPROV'] = $app;
    //     $args['MODIFYSTATUS'] = $MO;
    //     $args['FORCEDLOGOFF_COUNT'] = $ct;
    //     $args['LASTMODIFIED'] = 'SYSDATE';
    //     $args['serviceurl'] = 'user/update';
    //     $serv_model = new ServiceGlobalModelForm();
    //     $serviceResponse = $serv_model->wapiServiceAPI($args);
    //     if ($admincomment) {
    //         $admincomment = preg_replace('/!@!/', '\n', $admincomment);
    //     }
    // }
    public function Geo_IP() { //userapproval
        $host_name = $_SERVER['SERVER_NAME'];
        $serv_model = new ServiceGlobalModelForm();
        $curl = 'http://geoip.imimg.com/api/location.php';
        $ip = $country = $test = '';
        if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
            $ip_combine = $_SERVER['HTTP_X_FORWARDED_FOR'];
            $ip_combine = !empty($ip_combine) ? explode(',', $ip_combine) : '';
            $ip_com = !empty($ip_combine[1]) ? $ip_combine[1] : $ip_combine[0];
            $ip = !empty($ip_com) ? trim($ip_com) : '';
        } else {
            $ip = $_SERVER['GEOIP_ADDR'];
        }
        $ipdata = array('token' => 'imobile@15061981', 'modid' => 'GLADMIN', 'iplist' => $ip);
        $response = $serv_model->mapiService('GEOIP', $curl, $ipdata, $jsonRequired = 'No');
        $location = isset($response['Response']['Data']['geoip_ipaddress'])?$response['Response']['Data']['geoip_ipaddress']:'';
        $country = isset($response['Response']['Data']['geoip_countryname'])?$response['Response']['Data']['geoip_countryname']:'';
        if (is_array($response)){
            $test = json_encode($response, true);
        }
        $ipdatatest = json_encode($ipdata, true);
        if (empty($country)) {
            mail('priya.goel@indiamart.com', "GEO API test", "Empty data from GeoIP => Response => $test Request $ipdatatest");
            $result = "N/A";
            $location = Yii::app()->geoip->lookupLocation($ip);
            $country = isset($location->countryName) ? $location->countryName : 'India';
        }
        $return_geoip = array();
        $return_geoip['remote'] = $ip;
        $return_geoip['country'] = $country;
        return $return_geoip;
    }
    public function CheckDropDown($f, $d) {
        $message;
        $select = 0;
        $k = 0;
        $join_message;
        foreach ($d as $k) {
            if (($f[$k] == "0") || !($f[$k])) {
                $message = $d[$k];
                push($join_message, $message);
                $select = 1;
            }
        }
        if ($select == "1") {
            if ($join_message == 0) {
                $message = '<FONT COLOR="#FF0000"><B>The following required fields were left unselected:<BR><BR>Error: $join_message[0]<BR><BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT>';
            } else if ($join_message > 0) {
                $message = '<FONT COLOR="#FF0000"><B>The following required fields were left unselected:<BR><BR>';
                $k;
                $count = 1;
                foreach ($join_message as $k) {
                    $message.= 'Field $count:' . $k . '<BR>';
                    $count++;
                }
                $message.= '<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT>';
            } else {
                $message = "";
            }
        } else {
            $message = "";
        }
        return $message;
    }
    public function CheckBlankFields($f, $arr, $b) {
        $message;
        $blank = 0;
        $k = 0;
        $join_message = array();
        foreach ($arr as $k) {
            if ((preg_match("/^\s+$/", $f[$k]) || (strlen($f[$k]) == 0) || empty($f[$k]))) {
                $message = $b[$k];
                array_push($join_message, $message);
                $blank = 1;
            }
        }
        if ($blank == 1) {
            if ($join_message[0] == 0) {
                $message = '<FONT COLOR="#FF0000"><B>Following field is left blank:<BR><BR>Error:' . $join_message[0] . '<BR><BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT>';
            } elseif ($join_message[0] > 0) {
                $message = '<FONT COLOR="#FF0000"><B>Following fields were left blank:<BR><BR>';
                $k;
                $count = 1;
                foreach ($join_message as $k) {
                    $message.= 'Field $count: $k <BR>';
                    $count++;
                }
                $message.= '<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT>';
            } else {
                $message = "";
            }
        } else {
            $message = "";
        }
        return $message;
    }
    // public function Partial_Update($dbh, $form)
    // {
    //     $form['id'] = intval($form['id']);
    //     $bind2 = array();
    //     $class = '';
    //     $file_name = '';
    //     $lineno = '';
    //     $stateid = '';
    //     $cityid = '';
    //     $updatedby = '';
    //     $text_value = '';
    //     $fcp_text_value = '';
    //     $cond_value = '';
    //     $fcp_flag_new_value = '';
    //     $fcp_flag_old_value = '';
    //     $fcp_flag_ht_new_value = '';
    //     $fcp_flag_ht_old_value = '';
    //     $fcp_ht_text_value = '';
    //     $cond_ht_value = '';
    //     $show_text_value1 = '';
    //     $show_text_ht_value1 = '';
    //     $show_all_value = '';
    //     $sep1 = '';
    //     $sep2 = '';
    //     $sep3 = '';
    //     $report = '';
    //     $bind_st = array();
    //     if (isset($_SERVER['SCRIPT_NAME'])) {
    //         $updated_url = $_SERVER['SCRIPT_NAME'];
    //     } else {
    //         $updated_url = '';
    //     }
    //     if (isset($form['city_corr_report'])) {
    //         $city_corr_report = $form['city_corr_report'];
    //     } else {
    //         $city_corr_report = 0;
    //     }
    //     if (isset($form['mobile_corr_report'])) {
    //         $mobile_corr_report = $form['mobile_corr_report'];
    //     } else {
    //         $mobile_corr_report = 0;
    //     }
    //     if (isset($form['phone_corr_report'])) {
    //         $phone_corr_report = $form['phone_corr_report'];
    //     } else {
    //         $phone_corr_report = 0;
    //     }
    //     if (isset($form['mod_flag'])) {
    //         $mod_flag = $form['mod_flag'];
    //     } else {
    //         $mod_flag = 0;
    //     }
    //     if (isset($form['pin_corr_report'])) {
    //         $pin_corr_report = $form['pin_corr_report'];
    //     } else {
    //         $pin_corr_report = 0;
    //     }
    //     if (!empty($form['frlclient'])) {
    //         $frlclient = $form['frlclient'];
    //     } else {
    //         $frlclient = 0;
    //     }
    //     if (empty($form['admincomment'])) {
    //         $form['admincomment'] = '';
    //     }
    //     if (empty($form['comment_suggested'])) {
    //         $form['comment_suggested'] = '';
    //     }
    //     if (isset($form['loc_type'])) {
    //         $locat_pref = $form['loc_type'];
    //     } else {
    //         $locat_pref = '';
    //     }
    //     $eto_mob_phn_corr = '';
    //     $modified_nfl_client = '';
    //     $modified_tfl_client = '';
    //     $modified_lst_client = '';
    //     $modified_nfl_client_foreign = '';
    //     $modified_imfcp = '';
    //     $sms_bounce_report = '';
    //     if (isset($form['modified_nfl_client_foreign'])) {
    //         $modified_nfl_client_foreign = $form['modified_nfl_client_foreign'];
    //     }
    //     if (isset($form['modified_imfcp'])) {
    //         $modified_imfcp = $form['modified_imfcp'];
    //     }
    //     if (isset($form['eto_mob_phn_corr'])) {
    //         $eto_mob_phn_corr = $form['eto_mob_phn_corr'];
    //     }
    //     if (isset($form['modified_nfl_client'])) {
    //         $modified_nfl_client = $form['modified_nfl_client'];
    //     }
    //     if (isset($form['modified_tfl_client'])) {
    //         $modified_tfl_client = $form['modified_tfl_client'];
    //     }
    //     if (isset($form['sms_bounce_report'])) {
    //         $sms_bounce_report = $form['sms_bounce_report'];
    //     }
    //     $nflreason = !empty($form['nflreason']) ? $form['nflreason'] : '';
    //     $upd_using = '';
    //     if ($modified_nfl_client_foreign == 1) {
    //         $report = 'Gladmin (NFL/LST/TFL [Foreign])';
    //         $updated_url.= '?action=_1edit_usr&app=A&modified_nfl_client_foreign=1';
    //         $upd_using = 'Gladmin (NFL/LST/TFL [Foreign])';
    //     }
    //     if ($modified_imfcp == 1) {
    //         $report = 'Gladmin (IMFCP [India])';
    //         $updated_url.= '?action=_1edit_usr&app=A&modified_imfcp=1';
    //         $upd_using = 'Gladmin (IMFCP [India])';
    //     }
    //     if ($city_corr_report == 1) {
    //         $report = 'Gladmin (City Correction Report)';
    //         $updated_url.= '?action=_1edit_usr&app=A&city_corr_report=1';
    //         $upd_using = 'Gladmin(City/Pin-City)';
    //     } else if ($mobile_corr_report == 1) {
    //         $report = 'Gladmin (Mobile Correction Report)';
    //         $updated_url.= '?action=_1edit_usr&app=A&mobile_corr_report=1';
    //         $upd_using = 'Gladmin(Mobile/phone/Name-Mobile Correction)';
    //     } else if ($phone_corr_report == 1) {
    //         $report = 'Gladmin (phone Correction Report)';
    //         $updated_url.= '?action=_1edit_usr&app=A&phone_corr_report=1';
    //         $upd_using = 'Gladmin(Mobile/phone/Name-phone Correction)';
    //     } else if ($pin_corr_report == 1) {
    //         $report = 'Gladmin (Pin Correction Report)';
    //         $updated_url.= '?action=_1edit_usr&app=A&pin_corr_report=1';
    //         $upd_using = 'Gladmin(City/Pin-Pin Code)';
    //     } else if ($frlclient == 1) {
    //         if ($form['frl_screen'] == "new") {
    //             $report = 'Gladmin (FRL Client Report New)';
    //             $updated_url.= '?action=_1edit_usr&app=A&frlclient=1&frl_screen=new';
    //             $upd_using = 'Gladmin(FRL Clients New)';
    //         } else if ($form['frl_screen'] == "modified") {
    //             $report = 'Gladmin (FRL Client Report Modified)';
    //             $updated_url.= '?action=_1edit_usr&app=A&frlclient=1&frl_screen=modified';
    //             $upd_using = 'Gladmin(FRL Clients Modified)';
    //         }
    //     } else if ($modified_nfl_client == 1) {
    //         $report = 'Gladmin (NFL Client Report)';
    //         $updated_url.= '?action=_1edit_usr&app=A&modified_nfl_client=1';
    //         if ($form['ciso'] == 'other') {
    //             $upd_using = 'Gladmin(Modified Users[Foreign]-NFL[F])';
    //         } else {
    //             $upd_using = 'Gladmin(Modified Users[India]-NFL)';
    //         }
    //     } else if ($form['client'] == 1) {
    //         if ($form['dncclient'] == 1) {
    //             $report = 'Gladmin (Modified Client Report-DNC)';
    //             $updated_url.= '?action=_1edit_usr&app=A&client=1';
    //             $upd_using = 'Gladmin(Modified Client-DNC)';
    //         } else {
    //             $report = 'Gladmin (Modified Client Report-Non DNC)';
    //             $updated_url.= '?action=_1edit_usr&app=A&client=1';
    //             $upd_using = 'Gladmin(Modified Client-Non DNC)';
    //         }
    //     }
    //     $glusr_updatedby_name = '';
    //     $glusr_updatedby_id = '';
    //     $id = $form['employee_id'];
    //     $h1 = array();
    //     $h1['GL_EMP_NAME'] = $this->getEmpName($dbh, $id);
    //     $h1['GL_EMP_ID'] = $id;
    //     if (!empty($h1)) {
    //         if (!empty($h1['GL_EMP_NAME'])) {
    //             $glusr_updatedby_name = $h1['GL_EMP_NAME'];
    //         } else {
    //             $glusr_updatedby_name = '';
    //         }
    //         if (!empty($h1['GL_EMP_ID'])) {
    //             $glusr_updatedby_id = $h1['GL_EMP_ID'];
    //         } else {
    //             $glusr_updatedby_id = '';
    //         }
    //         $updatedby = $h1['GL_EMP_NAME'] . "(" . $h1['GL_EMP_ID'] . ")";
    //     }
    //     $geo_data = $this->Geo_IP();
    //     $remote_host = $geo_data['remote'];
    //     $country_name = $geo_data['country'];
    //     $updatedusing = 'Gladmin';
    //     if (!empty($form['state'])) {
    //         $stateid = $form['state'];
    //     }
    //     if (!empty($form['city'])) {
    //         $cityid = $form['city'];
    //     }
    //     if (!empty($form['fcp_flag_new'])) {
    //         $form['fcp_flag_new'] = $form['fcp_flag_new'];
    //     } else {
    //         $form['fcp_flag_new'] = '';
    //     }
    //     if (!empty($form['fcp_flag_ht_new'])) {
    //         $form['fcp_flag_ht_new'] = $form['fcp_flag_ht_new'];
    //     } else {
    //         $form['fcp_flag_ht_new'] = '';
    //     }
    //     if ($form['fcp_flag_new'] == '') {
    //         $form['fcp_flag_new'] = 0;
    //     }
    //     if ($form['fcp_flag_ht_new'] == '') {
    //         $form['fcp_flag_ht_new'] = 0;
    //     }
    //     if (!empty($form['admincomment'])) {
    //         $form['admincomment'] = preg_replace('/!@!/', '\n', $form['admincomment']);
    //     }
    //     if (isset($form['ph_country'])) {
    //         $form['ph_country'] = preg_replace('/^[\+0]+/', '', $form['ph_country']);
    //     }
    //     if (isset($form['fax_country'])) {
    //         $form['fax_country'] = preg_replace('/^[\+0]+/', '', $form['fax_country']);
    //     }
    //     if (isset($form['ph_country2'])) {
    //         $form['ph_country2'] = preg_replace('/^[\+0]+/', '', $form['ph_country2']);
    //     }
    //     if (isset($form['mob_country'])) {
    //         $form['mob_country'] = preg_replace('/^[\+0]+/', '', $form['mob_country']);
    //     }
    //     if (isset($form['alt_mob_country'])) {
    //         $form['alt_mob_country'] = preg_replace('/^[\+0]+/', '', $form['alt_mob_country']);
    //     }
    //     if (!empty($form['zip'])) {
    //         $form['zip'] = substr($form['zip'], 0, 11);
    //     }
    //     $check = 0;
    //     $param_list = array();
    //     $param_list['GLUSR_USR_ID'] = $form['id'];
    //     if (!empty($form['first_name'])) {
    //         $param_list['GLUSR_USR_FIRSTNAME'] = $form['first_name'];
    //     }
    //     if (!empty($form['last_name'])) {
    //         $param_list['GLUSR_USR_LASTNAME'] = $form['last_name'];
    //     } else {
    //         $param_list['GLUSR_USR_LASTNAME'] = '';
    //     }
    //     if (!empty($form['email'])) {
    //         $email_dup = strtoupper($form['email']);
    //         $param_list['GLUSR_USR_EMAIL_DUP'] = $email_dup;
    //     }
    //     if (!empty($form['designation'])) {
    //         $param_list['GLUSR_USR_DESIGNATION'] = $form['designation'];
    //     } else {
    //         $param_list['GLUSR_USR_DESIGNATION'] = '';
    //     }
    //     if (!empty($form['comp_name'])) {
    //         $param_list['GLUSR_USR_COMPANYNAME'] = $form['comp_name'];
    //     } else {
    //         $param_list['GLUSR_USR_COMPANYNAME'] = '';
    //     }
    //     if (!empty($form['str_add1'])) {
    //         $param_list['GLUSR_USR_ADD1'] = $form['str_add1'];
    //     } else {
    //         $param_list['GLUSR_USR_ADD1'] = '';
    //     }
    //     if (!empty($form['str_add2'])) {
    //         $param_list['GLUSR_USR_ADD2'] = $form['str_add2'];
    //     } else {
    //         $param_list['GLUSR_USR_ADD2'] = '';
    //     }
    //     if (!empty($form['country'])) {
    //         $param_list['FK_GL_COUNTRY_ISO'] = $form['country'];
    //     }
    //     if (!empty($form['zip'])) {
    //         $param_list['GLUSR_USR_ZIP'] = $form['zip'];
    //     } else {
    //         $param_list['GLUSR_USR_ZIP'] = '';
    //     }
    //     if (!empty($form['ph_country'])) {
    //         $param_list['GLUSR_USR_PH_COUNTRY'] = $form['ph_country'];
    //     }
    //     if (!empty($form['ph_area'])) {
    //         $param_list['GLUSR_USR_PH_AREA'] = $form['ph_area'];
    //     } else {
    //         $param_list['GLUSR_USR_PH_AREA'] = '';
    //     }
    //     if (!empty($form['ph_no']) and is_numeric($form['ph_no'])) {
    //         $param_list['GLUSR_USR_PH_NUMBER'] = $form['ph_no'];
    //     } else {
    //         $param_list['GLUSR_USR_PH_NUMBER'] = '';
    //     }
    //     if (!empty($form['mobile'])) {
    //         $param_list['GLUSR_USR_PH_MOBILE'] = $form['mobile'];
    //     } else {
    //         $param_list['GLUSR_USR_PH_MOBILE'] = '';
    //     }
    //     if (!empty($form['website'])) {
    //         $param_list['GLUSR_USR_URL'] = $form['website'];
    //     } else {
    //         $param_list['GLUSR_USR_URL'] = '';
    //     }
    //     if (!empty($form['fax_country'])) {
    //         $param_list['GLUSR_USR_FAX_COUNTRY'] = $form['fax_country'];
    //     } else {
    //         $param_list['GLUSR_USR_FAX_COUNTRY'] = '';
    //     }
    //     if (!empty($form['fax_area'])) {
    //         $param_list['GLUSR_USR_FAX_AREA'] = $form['fax_area'];
    //     } else {
    //         $param_list['GLUSR_USR_FAX_AREA'] = '';
    //     }
    //     if (!empty($form['fax_no'])) {
    //         $param_list['GLUSR_USR_FAX_NUMBER'] = $form['fax_no'];
    //     } else {
    //         $param_list['GLUSR_USR_FAX_NUMBER'] = '';
    //     }
    //     if (!empty($form['ph_country2'])) {
    //         $param_list['GLUSR_USR_PH_COUNTRY'] = $form['ph_country2'];
    //     }
    //     if (!empty($form['ph_area2'])) {
    //         $param_list['GLUSR_USR_PH2_AREA'] = $form['ph_area2'];
    //     } else {
    //         $param_list['GLUSR_USR_PH2_AREA'] = '';
    //     }
    //     if (!empty($form['ph_no2']) and is_numeric($form['ph_no2'])) {
    //         $param_list['GLUSR_USR_PH2_NUMBER'] = $form['ph_no2'];
    //     } else {
    //         $param_list['GLUSR_USR_PH2_NUMBER'] = '';
    //     }
    //     if (!empty($form['email2'])) {
    //         $param_list['GLUSR_USR_EMAIL_ALT'] = $form['email2'];
    //     } else {
    //         $param_list['GLUSR_USR_EMAIL_ALT'] = '';
    //     }
    //     if (!empty($form['mobile_country'])) {
    //         $param_list['GLUSR_USR_MOBILE_COUNTRY'] = $form['mobile_country'];
    //     }
    //     if (!empty($form['alt_mobile_country'])) {
    //         $param_list['GLUSR_USR_MOBILE_COUNTRY'] = $form['alt_mobile_country'];
    //     }
    //     if (!empty($form['alternate_mobile'])) {
    //         $param_list['GLUSR_USR_PH_MOBILE_ALT'] = $form['alternate_mobile'];
    //     } else {
    //         $param_list['GLUSR_USR_PH_MOBILE_ALT'] = '';
    //     }
    //     if (!empty($form['COUNTRYNAME'])) {
    //         $st.= "GLUSR_USR_COUNTRYNAME=:COUNTRYNAME, ";
    //         $bind_st[':COUNTRYNAME'] = $form['COUNTRYNAME'];
    //         $param_list['GLUSR_USR_COUNTRYNAME'] = $form['COUNTRYNAME'];
    //     }
    //     if (!empty($form['parent_id'])) {
    //         $form['parent_id'] = $form['parent_id'];
    //     } else {
    //         $form['parent_id'] = '';
    //     }
    //     if (!empty($form['editb'])) {
    //         $form['editb'] = $form['editb'];
    //     } else {
    //         $form['editb'] = '';
    //     }
    //     if (($form['parent_id']) && (preg_match('/^Approve not to freelist$/', $form['editb']) || preg_match('/^Approve to freelist$/', $form['editb']) || preg_match('/^Approve-NFL$/', $form['editb']) || preg_match('/^Approve-DNF$/', $form['editb']) || preg_match('/^Approve-UNF$/', $form['editb']))) {
    //         $param_list['FK_PARENT_GLUSR_ID'] = '';
    //     }
    //     if (!empty($form['cfirst_name'])) {
    //         $param_list['GLUSR_USR_CFIRSTNAME'] = $form['cfirst_name'];
    //     } else {
    //         $param_list['GLUSR_USR_CFIRSTNAME'] = '';
    //     }
    //     if (!empty($form['clast_name'])) {
    //         $param_list['GLUSR_USR_CLASTNAME'] = $form['clast_name'];
    //     } else {
    //         $param_list['GLUSR_USR_CLASTNAME'] = '';
    //     }
    //     if (!empty($form['state'])) {
    //         $param_list['FK_GL_STATE_ID'] = intval($form['state']);
    //         $param_list['GLUSR_USR_STATE_OTHERS'] = '';
    //     } else {
    //         $param_list['GLUSR_USR_STATE_OTHERS'] = $form['state_others'];
    //         $param_list['FK_GL_STATE_ID'] = '';
    //         $param_list['GLUSR_USR_STATE'] = '';
    //     }
    //     if (!empty($form['city'])) {
    //         $cityidd = intval($form['city']);
    //         $param_list['FK_GL_CITY_ID'] = $cityidd;
    //         $param_list['GLUSR_USR_CITY_OTHERS'] = '';
    //     } else {
    //         $param_list['FK_GL_CITY_ID'] = '';
    //         $param_list['GLUSR_USR_CITY'] = '';
    //         $param_list['GLUSR_USR_CITY_OTHERS'] = $form['city_others'];
    //     }
    //     if ((($form['fcp_flag_new']) and ($form['fcp_flag_new'] != 3)) and (($form['fcp_flag']) and ($form['fcp_flag'] == 3))) {
    //         $fcp_flag_new_value = $form['fcp_flag'];
    //         $fcp_flag_old_value = ' (' . $form['fcp_flag_new'] . ')';
    //         if ($form['fcp_flag_new'] == 0) {
    //             $cond_value = 'Waiting';
    //         } else if ($form['fcp_flag_new'] == 1) {
    //             $cond_value = 'Approve';
    //         } else if ($form['fcp_flag_new'] == 2) {
    //             $cond_value = 'Disabled';
    //         }
    //         $fcp_text_value.= 'SET FCP FLAG FROM  ' . $cond_value . $fcp_flag_old_value . '  TO Manually Disabled (' . $fcp_flag_new_value . ')';
    //         $param_list['FCP_FLAG'] = $form['fcp_flag'];
    //         $param_list['FREESHOWROOM_URL'] = '';
    //     } else if (($form['fcp_flag_new'] == 3) and ($form['fcp_flag'] == 'w')) {
    //         $fcp_text_value.= 'SET FCP FLAG FROM Manually Disabled (3) to Waiting (0)';
    //         $param_list['FCP_FLAG'] = 0;
    //     }
    //     if (($form['fcp_flag_ht_new'] and $form['fcp_flag_ht_new'] != 3) and ($form['fcp_flag_ht'] and $form['fcp_flag_ht'] == 3)) {
    //         $fcp_flag_ht_new_value = $form['fcp_flag_ht'];
    //         $fcp_flag_ht_old_value = ' (' . $form['fcp_flag_ht_new'] . ')';
    //         if ($form['fcp_flag_ht_new'] == 0) {
    //             $cond_ht_value = 'Waiting';
    //         } else if ($form['fcp_flag_ht_new'] == 1) {
    //             $cond_ht_value = 'Approve';
    //         } else if ($form['fcp_flag_ht_new'] == 2) {
    //             $cond_ht_value = 'Disabled';
    //         }
    //         $fcp_ht_text_value.= 'SET FCP FLAG HT FROM  ' . $cond_ht_value . $fcp_flag_ht_old_value . ' to Manually Disabled (' . $fcp_flag_ht_new_value . ')';
    //         $param_list['FCP_FLAG_HT'] = $form['fcp_flag_ht'];
    //     } else if (($form['fcp_flag_ht_new'] == 3) and ($form['fcp_flag_ht'] == 'w')) {
    //         $param_list['FCP_FLAG_HT'] = 0;
    //         $fcp_ht_text_value.= 'SET FCP FLAG HT FROM Manually Disabled (3) to Waiting (0)';
    //     }
    //     if (isset($form['admincomment'])) {
    //         $show_all_value = substr($form['admincomment'], 0, 255);
    //         $sep1 = ' ## ';
    //     }
    //     if ($fcp_text_value) {
    //         $show_all_value.= $sep1 . $fcp_text_value;
    //         $sep2 = ' ## ';
    //     }
    //     if ($fcp_ht_text_value) {
    //         if ($sep1 or $sep2) {
    //             $sep3 = ' ## ';
    //         }
    //         $show_all_value.= $sep3 . $fcp_ht_text_value;
    //     }
    //     if (($form['parent_id']) && (preg_match('/^Approve not to freelist$/', $form['editb']) || preg_match('/^Approve to freelist$/', $form['editb']) || preg_match('/^Approve-NFL$/', $form['editb']) || preg_match('/^Approve-DNF$/', $form['editb']) || preg_match('/^Approve-UNF$/', $form['editb']))) {
    //         $form['DUP_COMMENT'] = $form['DUP_COMMENT'] || '';
    //         if (!empty($form['DUP_COMMENT'])) {
    //             $form['DUP_COMMENT'] = $form['DUP_COMMENT'];
    //         }
    //         if (!empty($form['DUP_COMMENT'])) {
    //             $show_all_value.= "REMOVE DDUP-" . $form['DUP_COMMENT'];
    //             $show_all_value = substr($show_all_value, 0, 255);
    //         }
    //     }
    //     $updatedby_agency = "-";
    //     if (!empty($show_all_value)) {
    //         $param_list['GLUSR_USR_HIST_COMMENTS'] = $show_all_value;
    //     } else {
    //         $param_list['GLUSR_USR_HIST_COMMENTS'] = '';
    //     }
    //     $param_list['GLUSR_USR_LASTMODIFIED'] = 'SYSDATE';
    //     $param_list['GLUSR_USR_UPDATEDBY'] = $updatedby;
    //     $param_list['GLUSR_USR_UPDATEDBY_ID'] = $id;
    //     $param_list['GLUSR_USR_UPDATEDBY_AGENCY'] = $updatedby_agency;
    //     $param_list['GLUSR_USR_UPDATEDBY_URL'] = $updated_url;
    //     $param_list['GLUSR_USR_UPDATESCREEN'] = $report;
    //     $param_list['GLUSR_USR_UPDATEDUSING'] = $upd_using;
    //     $param_list['GLUSR_USR_IP'] = $remote_host;
    //     $param_list['GLUSR_USR_IP_COUNTRY'] = $country_name;
    //     $mod_app_tofreelist = '';
    //     $listing_status = '';
    //     if (($form['editb'] != "Disable With Mail") and ($form['editb'] != "Save")) {
    //         $param_list['GLUSR_USR_APPROV'] = $form['approve'];
    //         if (preg_match('/^Approve to freelist$/', $form['editb'])) {
    //             $param_list['GLUSR_USR_TOFREELIST'] = 1;
    //             $param_list['GLUSR_USR_LISTING_STATUS'] = 'TFL';
    //             $mod_app_tofreelist = 1;
    //             $listing_status = 'TFL';
    //             $nflreason = '';
    //         } else if (preg_match('/^Approve not to freelist$/', $form['editb'])) {
    //             $param_list['GLUSR_USR_TOFREELIST'] = 0;
    //             $param_list['GLUSR_USR_LISTING_STATUS'] = 'NFL';
    //             $mod_app_tofreelist = 0;
    //             $listing_status = 'NFL';
    //             $bind2['LISTING_REASON'] = $nflreason;
    //         } else if (preg_match('/^Approve-NFL$/', $form['editb'])) {
    //             $param_list['GLUSR_USR_TOFREELIST'] = 0;
    //             $param_list['GLUSR_USR_LISTING_STATUS'] = 'NFL';
    //             $mod_app_tofreelist = 0;
    //             $listing_status = 'NFL';
    //             $bind2['LISTING_REASON'] = $nflreason;
    //         } else if (preg_match('/^Approve-DNF$/', $form['editb'])) {
    //             $param_list['GLUSR_USR_TOFREELIST'] = 0;
    //             $param_list['GLUSR_USR_LISTING_STATUS'] = 'DNF';
    //             $mod_app_tofreelist = 0;
    //             $listing_status = 'DNF';
    //         } else if (preg_match('/^Approve-UNF$/', $form['editb'])) {
    //             $param_list['GLUSR_USR_TOFREELIST'] = 0;
    //             $param_list['GLUSR_USR_LISTING_STATUS'] = 'UNF';
    //             $mod_app_tofreelist = 0;
    //             $listing_status = 'UNF';
    //         }
    //     }
    //     $check = 1;
    //     $param_list['GLUSR_USR_MODIFYSTATUS'] = 'F';
    //     $param_list_count = count($param_list);
    //     $arr_param = array();
    //     $i = 0;
    //     $send = array("USR_ID" => "GLUSR_USR_ID", "FIRSTNAME" => "GLUSR_USR_FIRSTNAME", "LASTNAME" => "GLUSR_USR_LASTNAME", "EMAIL" => "GLUSR_USR_EMAIL", "COMPANYNAME" => "GLUSR_USR_COMPANYNAME", "ADD1" => "GLUSR_USR_ADD1", "ADD2" => "GLUSR_USR_ADD2", "CITY" => "GLUSR_USR_CITY", "STATE" => "GLUSR_USR_STATE", "FK_GL_COUNTRY_ISO" => "FK_GL_COUNTRY_ISO", "ZIP" => "GLUSR_USR_ZIP", "PH_COUNTRY" => "GLUSR_USR_PH_COUNTRY", "PH_AREA" => "GLUSR_USR_PH_AREA", "PH_NUMBER" => "GLUSR_USR_PH_NUMBER", "PH_MOBILE" => "GLUSR_USR_PH_MOBILE", "FAX_COUNTRY" => "GLUSR_USR_FAX_COUNTRY", "FAX_AREA" => "GLUSR_USR_FAX_AREA", "FAX_NUMBER" => "GLUSR_USR_FAX_NUMBER", "DESIGNATION" => "GLUSR_USR_DESIGNATION", "FK_GLUSR_BIZ_ID" => "FK_GLUSR_BIZ_ID", "PH2_COUNTRY" => "GLUSR_USR_PH_COUNTRY", "PH2_AREA" => "GLUSR_USR_PH2_AREA", "PH2_NUMBER" => "GLUSR_USR_PH2_NUMBER", "EMAIL_ALT" => "GLUSR_USR_EMAIL_ALT", "STATE_OTHERS" => "GLUSR_USR_STATE_OTHERS", "CITY_OTHERS" => "GLUSR_USR_CITY_OTHERS", "PH_MOBILE_ALT" => "GLUSR_USR_PH_MOBILE_ALT", "FAX2_NUMBER" => "GLUSR_USR_FAX2_NUMBER", "MOBILE_COUNTRY" => "GLUSR_USR_MOBILE_COUNTRY", "ALT_MOBILE_COUNTRY" => "GLUSR_USR_MOBILE_COUNTRY", "FAX2_AREA" => "GLUSR_USR_FAX2_AREA", "URL" => "GLUSR_USR_URL", "FK_GL_CITY_ID" => "FK_GL_CITY_ID", "FK_GL_STATE_ID" => "FK_GL_STATE_ID", "FK_PBIZ_ID" => "FK_GLUSR_USR_PBIZ_ID", "UPDATESCREEN" => "GLUSR_USR_UPDATESCREEN", "UPDATEMODID" => "GLUSR_USR_UPDATEMODID", "UPDATEDBY_ID" => "GLUSR_USR_UPDATEDBY_ID", "UPDATEDBY_AGENCY" => "GLUSR_USR_UPDATEDBY_AGENCY", "UPDATEDBY_URL" => "GLUSR_USR_UPDATEDBY_URL", "CFIRSTNAME" => "GLUSR_USR_CFIRSTNAME", "CLASTNAME" => "GLUSR_USR_CLASTNAME", "APPROV" => "GLUSR_USR_APPROV", "LISTING_STATUS" => "GLUSR_USR_LISTING_STATUS", "MODIFYSTATUS" => "GLUSR_USR_MODIFYSTATUS", "UPDATEDBY" => "GLUSR_USR_UPDATEDBY", "IP" => "GLUSR_USR_IP", "IP_COUNTRY" => "GLUSR_USR_IP_COUNTRY", "TOFREELIST" => "GLUSR_USR_TOFREELIST", "EMAIL_DUP" => "GLUSR_USR_EMAIL_DUP", "HIST_COMMENTS" => "GLUSR_USR_HIST_COMMENTS", "UPDATEDUSING" => "GLUSR_USR_UPDATEDUSING", "EMAIL" => "GLUSR_USR_EMAIL");
    //     foreach ($send as $key => $val) {
    //         foreach ($param_list as $k => $v) {
    //             if ($k == $val) {
    //                 $bind2[$key] = $v;
    //             }
    //         }
    //     }
    //     $updated_using = !empty($bind2['UPDATEDUSING']) ? $bind2['UPDATEDUSING'] : '';
    //     $modified_status = !empty($bind2['MODIFYSTATUS']) ? $bind2['MODIFYSTATUS'] : '';
    //     $listing_status = !empty($bind2['LISTING_STATUS']) ? $bind2['LISTING_STATUS'] : '';
    //     $gluser_id = !empty($form['id']) ? $form['id'] : '';
    //     $approve_status = !empty($form['approve']) ? $form['approve'] : '';
    //     $bind2['LASTMODIFIED'] = 'SYSDATE';
    //     $bind2['VALIDATION_KEY'] = 'e02a3fab4c6c735015b9b4f4a1eb4e3c';
    //     $bind2['LANDMARK'] = $form['landmark'];
    //     $bind2['LOCALITY'] = $form['locality'];
    //     $bind2['EMAIL'] = strtolower(trim($form['email']));
    //     $bind2['serviceurl'] = 'user/update';
    //     $approve = $form['approve'];
    //     if (!empty($form['approve']) && $form['approve'] == 'D') {
    //         $bind2['APPROV_REASON'] = $form['editb'];
    //     }
    //     $serv_model = new ServiceGlobalModelForm();
    //     $serviceResponse = $serv_model->wapiServiceAPI($bind2);
    //     $moduleID = !empty($form['mid']) ? $form['mid'] : '';
    //     if ($serviceResponse == 1) {
    //         // change for User Approval JIRA: GLADMINGEN-3697
    //         $gst = !empty($_REQUEST['gst']) ? $_REQUEST['gst'] : '';
    //         if ($modified_nfl_client == 1) {
    //             $moduleID = !empty($form['mid']) ? $form['mid'] : '';
    //             if (!empty($moduleID) && ($moduleID == 49)) {
    //                 if (!empty($form['mobile']) && !empty($nflreason) && ($nflreason == 'Invalid / Incomplete Address' || $nflreason == 'Generic / Invalid Company Name')) {
    //                     $data_android = array();
    //                     $data_android['glusrid'] = $form['id'];
    //                     $data_android['mobile'] = !empty($form['mobile']) ? $form['mobile'] : '';
    //                     $data_android['listing_source'] = 'GLUSR_REJECTED';
    //                     // $data_android['modid'] = 'GLADMIN';
    //                     // $data_android['VALIDATION_KEY'] = 'e02a3fab4c6c735015b9b4f4a1eb4e3c';
    //                     // $data_android['serviceurl'] = 'seller_activity';
    //                     // $serviceResponse = $serv_model->wapiServiceAPI($data_android);
    //                     $data_android['approve'] = $form['approve'];
    //                     $dbRes = $this->doSellerActivity($data_android);
    //                 }
    //             }
    //             //                 else {
    //             //                     mail("rajeevkumar@indiamart.com", "Call Seller Activity Service", "Module ID:" . $moduleID);
    //             //                 }

    //         }
    //         // change for User Approval JIRA: GLADMINGEN-3697  ends
    //         $is_gst = !empty($_REQUEST['gst_check']) ? $_REQUEST['gst_check'] : '';
    //         $gst = !empty($_REQUEST['gst']) ? $_REQUEST['gst'] : '';
    //         $pan_no = !empty($_REQUEST['pan_no']) ? $_REQUEST['pan_no'] : '';
    //         $verifiedby_agency = 'online';
    //         $comment = 'Following Data Has Been Verified Through User Approval Process';
    //         $report = 'User Approval Screen';
    //         if (!empty($gst) && !empty($form['id'])) {
    //             $args1 = array();
    //             $args1['glusridval'] = $form['id'];
    //             $gst = strtoupper($gst);
    //             $args1['GST'] = $gst;
    //             if (isset($pan_no)) {
    //                 $pan_no = strtoupper($pan_no);
    //                 $args['pan_no'] = isset($pan_no) ? $pan_no : '';
    //             }
    //             $args1['updatedby'] = $updatedby;
    //             $args1['updatedbyId'] = $id;
    //             $args1['updatedbyScreen'] = $report;
    //             $args1['userIp'] = $remote_host;
    //             $args1['userIpCoun'] = $country_name;
    //             $args1['VALIDATION_KEY'] = 'e02a3fab4c6c735015b9b4f4a1eb4e3c';
    //             $args1['type'] = 'CompRgst';
    //             $args1['serviceurl'] = 'details';
    //             $output1 = $serv_model->wapiServiceAPI($args1);
    //             if ($output1 == 1) {
    //                 if ($is_gst == 'gst_check') {
    //                     $param1 = array();
    //                     $param1['VALIDATION_KEY'] = 'e02a3fab4c6c735015b9b4f4a1eb4e3c';
    //                     $param1['action_flag'] = 'SP_BULK_VERIFY_ATTRIBUTE';
    //                     $param1['GLUSR_USR_ID'] = $form['id'];
    //                     $param1['ATTRIBUTE_ID'] = 2106;
    //                     $param1['ATTRIBUTE_VALUE'] = $gst;
    //                     $param1['VERIFIED_BY_ID'] = - 1;
    //                     $param1['VERIFIED_BY_NAME'] = $updatedby;
    //                     $param1['VERIFIED_BY_AGENCY'] = $verifiedby_agency;
    //                     $param1['VERIFIED_BY_SCREEN'] = $report;
    //                     $param1['VERIFIED_URL'] = NULL;
    //                     $param1['VERIFIED_IP'] = $remote_host;
    //                     $param1['VERIFIED_IP_COUNTRY'] = $country_name;
    //                     $param1['VERIFIED_COMMENTS'] = $comment;
    //                     $param1['VERIFIED_AUTHCODE'] = NULL;
    //                     $param1['serviceurl'] = 'user/verification';
    //                     $sth2 = $serv_model->wapiServiceAPI($param1);
    //                     if ($sth2 == 1) {
    //                     } else {
    //                         $cc = '';
    //                         $to = 'kajal@indiamart.com';
    //                         $from = 'gladmin-team@indiamart.com';
    //                         $glusr_id = !empty($form['id']) ? $form['id'] : '';
    //                         $headers = "From:$from \n" . "Reply-To:$to\n" . "Cc:$cc\n" . "MIME-Version: 1.0 \n" . "Content-type: text/html; charset=UTF-8";
    //                         mail($to, "Error From Gl-Details GST Verification -$report : $glusr_id", $output1, $headers);
    //                         exit;
    //                     }
    //                 }
    //             }
    //         }
    //         $bind2 = array();
    //         $id = $form['id'];
    //         if (!empty($id)) {
    //             $sql_change_flag = "UPDATE GLUSR_USR_APPROVAL_MASTER SET GLUSR_APP_STATUS='D',GLUSR_APP_UPDATE_DATE = sysdate WHERE FK_GLUSR_USR_ID=:GLUSR_USR_ID";
    //             $bind2[':GLUSR_USR_ID'] = $id;
    //             $sth = $this->ExecQuery(__FILE__, __LINE__, __CLASS__, $dbh, $sql_change_flag, $bind2);
    //         }
    //     }
    //     if ((!empty($form['city_corr_report'])) && ($form['city_corr_report'] == 1)) {
    //         $city_query = "UPDATE GLUSR_USR_CITY_CORRECTION SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //         $city_sth = $dbh->createCommand($city_query);
    //         $city_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //         $city_sth->execute();
    //     }
    //     /*if ((!empty($form['city_corr_nfl_report'])) and ($form['city_corr_nfl_report'] == 1)) {
    //         $weberp_comment = '';
    //         $glusr_exception_values = '';
    //         $total_count1 = '';
    //         $bind = '';
    //         $bind_value = '';
    //         $city_query_nfl = "UPDATE GLUSR_USR_CITY_CORRECTION_NFL SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //         $city_sth_nfl = $dbh->createCommand($city_query_nfl);
    //         $city_sth_nfl->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //         $city_sth_nfl->execute();
    //         $sql_dual = "select TO_CHAR(sysdate, 'DD MON YYYY HH24:MI:SS') AS MYDATE from dual";
    //         $sth_dual = $dbh->createCommand($sql_dual);
    //         $list = $sth_dual->query();
    //         $hnew_dual = $list->read();
    //         $date_time = $hnew_dual['MYDATE'];
    //         if (!empty($form['comment'])) {
    //             $comment = $form['comment'];
    //         } else {
    //             $comment = '';
    //         }
    //         if (!empty($form['admincomment'])) {
    //             $admincomment = $form['admincomment'];
    //         } else {
    //             $admincomment = '';
    //         }
    //         if ($comment != '') {
    //             $glusr_exception_values = 'City Unknown';
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nSuggestion Comment:$glusr_exception_values\n";
    //         } else if ($admincomment != '' and $comment == '') {
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nAdmin Comment:$admincomment\n";
    //         }
    //         if ($comment != '' or $admincomment or '') {
    //             //********************************************************STS Update Service********************************************
    //             $empid = Yii::app()->session['empid'];
    //             $empname = Yii::app()->session['empname'];
    //             $empemail = Yii::app()->session['empemail'];
    //             $comment = "GST is Approved." . "\n Basis:" . isset($weberp_comment) ? $weberp_comment : '';
    //             $param = array();
    //             $param['glid'] = $glusr_id;
    //             $param['comment'] = $comment;
    //             $param['mail_from'] = $empemail;
    //             $param['mail_from_name'] = $empname;
    //             $param['updated_by'] = $empname;
    //             $param['modid'] = 'GLADMIN';
    //             $param['module_name'] = 'GLADMIN';
    //             $param['showdata'] = 1;
    //             $param['source_fns'] = 946;
    //             $param['subject'] = 'Testing';
    //             $host_name = $_SERVER['SERVER_NAME'];
    //             if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //                 $curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             } else {
    //                 $curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             }
    //             $response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
    //             $code = isset($response['status']) ? $response['status'] : '';
    //             $message = isset($response['message']) ? $response['message'] : '';
    //             if ($empid == 67422 || $empid == 63228) {
    //                 echo "successful Weberp History" . $code;
    //                 print_r($response);
    //             }
    //             if ($code == 200) {
    //                 return;
    //             }
    //             //****************************************************end*********************************************************
    //             if ($comment != '') {
    //                 $mobile_insert = "INSERT INTO GLUSR_EXCEPTION_REPORT (FK_GLUSR_USR_ID,GLUSR_EXCEPTION_VALUES,GLUSR_EXCEPTION_ID,GLUSR_EXCEPTION_DATE,GLUSR_EXCEPTION_UPDATE_FLAG) VALUES(:FK_GLUSR_USR_ID,:GLUSR_EXCEPTION_VALUES,:GLUSR_EXCEPTION_ID,SYSDATE,'N')";
    //                 $mobile_sth = $dbh->createCommand($mobile_insert);
    //                 $mobile_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_VALUES", $glusr_exception_values);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_ID", $comment);
    //                 $mobile_sth->execute();
    //             }
    //         }
    //     }*/
    //     if ((!empty($form['mobile_corr_report'])) and ($form['mobile_corr_report'] == 1)) {
    //         $mobile_query = "UPDATE GLUSR_USR_MOBILE_CORRECTION SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //         $mobile = $dbh->createCommand($mobile_query);
    //         $mobile->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //         $mobile->execute();
    //     }
    //     // if ((!empty($form['mobile_corr_report_nfl'])) and ($form['mobile_corr_report_nfl'] == 1)) {
    //     //     $mobile_query = "UPDATE GLUSR_USR_MOB_CORRECTION_NFL SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //     //     $mobile = $dbh->createCommand($mobile_query);
    //     //     $mobile->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //     //     $mobile->execute();
    //     // }
    //     // if ((!empty($form['sms_bounce_report'])) and ($form['sms_bounce_report'] == 1)) {
    //     //     $mobile_query = "UPDATE GLUSR_SMS_BOUNCE_CORRECTION SET IS_PROCESSED = 1 WHERE GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //     //     $mobile = $dbh->createCommand($mobile_query);
    //     //     $mobile->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //     //     $mobile->execute();
    //     // }
    //     /*if ((!empty($form['mobile_corr_report_blank_paid'])) and ($form['mobile_corr_report_blank_paid'] == 1)) {
    //         $weberp_comment = '';
    //         $glusr_exception_values = '';
    //         $total_count1 = '';
    //         $bind = '';
    //         $bind_value = '';
    //         $mobile_query = "UPDATE GLUSR_MOBILE_BLANK_CORRECTION SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //         $mobile = $dbh->createCommand($mobile_query);
    //         $mobile->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //         $mobile->execute();
    //         $date_time = date("d M Y h:i:s");
    //         if (!empty($form['comment'])) {
    //             $comment = $form['comment'];
    //         } else {
    //             $comment = '';
    //         }
    //         if (!empty($form['admincomment'])) {
    //             $admincomment = $form['admincomment'];
    //         } else {
    //             $admincomment = '';
    //         }
    //         if ($comment != '') {
    //             $glusr_exception_values = 'Client does not want to share Mobile Number';
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nSuggestion Comment:$glusr_exception_values\n";
    //         } else if ($admincomment != '' and $comment == '') {
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nAdmin Comment:$admincomment\n";
    //         }
    //         if ($comment != '' || $admincomment != '') {
    //             //********************************************************STS Update Service********************************************
    //             $empid = Yii::app()->session['empid'];
    //             $empname = Yii::app()->session['empname'];
    //             $empemail = Yii::app()->session['empemail'];
    //             $comment = "GST is Approved." . "\n Basis:" . isset($weberp_comment) ? $weberp_comment : '';
    //             $param = array();
    //             $param['glid'] = $glusr_id;
    //             $param['comment'] = $comment;
    //             $param['mail_from'] = $empemail;
    //             $param['mail_from_name'] = $empname;
    //             $param['updated_by'] = $empname;
    //             $param['modid'] = 'GLADMIN';
    //             $param['module_name'] = 'GLADMIN';
    //             $param['showdata'] = 1;
    //             $param['source_fns'] = 946;
    //             $param['subject'] = 'Testing';
    //             $host_name = $_SERVER['SERVER_NAME'];
    //             if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //                 $curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             } else {
    //                 $curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             }
    //             $response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
    //             $code = isset($response['status']) ? $response['status'] : '';
    //             $message = isset($response['message']) ? $response['message'] : '';
    //             if ($empid == 67422 || $empid == 63228) {
    //                 echo "successful Weberp History" . $code;
    //                 print_r($response);
    //             }
    //             if ($code == 200) {
    //                 return;
    //             }
    //             //****************************************************end*********************************************************
    //             if ($comment != '') {
    //                 $mobile_insert = "INSERT INTO GLUSR_EXCEPTION_REPORT (FK_GLUSR_USR_ID,GLUSR_EXCEPTION_VALUES,GLUSR_EXCEPTION_ID,GLUSR_EXCEPTION_DATE,GLUSR_EXCEPTION_UPDATE_FLAG) VALUES(:FK_GLUSR_USR_ID,:GLUSR_EXCEPTION_VALUES,:GLUSR_EXCEPTION_ID,SYSDATE,'N')";
    //                 $mobile_sth = $dbh->createCommand($mobile_insert);
    //                 $mobile_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_VALUES", $glusr_exception_values);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_ID", $comment);
    //                 $mobile_sth->execute();
    //             }
    //         }
    //     }*/
    //     if ((!empty($form['name_dont_show_paid'])) and ($form['name_dont_show_paid'] == 1)) {
    //         $weberp_comment = '';
    //         $glusr_exception_values = '';
    //         $total_count1 = '';
    //         $bind = '';
    //         $bind_value = '';
    //         $name_query = "UPDATE GLUSR_NO_NAME_CORRECTION SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //         $name = $dbh->createCommand($name_query);
    //         $name->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //         $name->execute();
    //         $date_time = date("d-M-Y h:i:s");
    //         if (!empty($form['comment1'])) {
    //             $comment1 = $form['comment1'];
    //         } else {
    //             $comment1 = '';
    //         }
    //         if (!empty($form['admincomment'])) {
    //             $admincomment = $form['admincomment'];
    //         } else {
    //             $admincomment = '';
    //         }
    //         if ($comment1 != '') {
    //             $glusr_exception_values = 'Client does not want to share his name';
    //             $weberp_comment = '$date_time Updated By $updatedby Through Gladmin Module\nSuggestion Comment:$glusr_exception_values\n';
    //         } else if ($admincomment != '' and $comment1 == '') {
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nAdmin Comment:$admincomment\n";
    //         }
    //         if ($comment1 != '' or $admincomment != '') {
    //             //********************************************************STS Update Service********************************************
    //             $empid = Yii::app()->session['empid'];
    //             $empname = Yii::app()->session['empname'];
    //             $empemail = Yii::app()->session['empemail'];
    //             $comment = "GST is Approved." . "\n Basis:" . isset($weberp_comment) ? $weberp_comment : '';
    //             $param = array();
    //             $param['glid'] = $glusr_id;
    //             $param['comment'] = $comment;
    //             $param['mail_from'] = $empemail;
    //             $param['mail_from_name'] = $empname;
    //             $param['updated_by'] = $empname;
    //             $param['modid'] = 'GLADMIN';
    //             $param['module_name'] = 'GLADMIN';
    //             $param['showdata'] = 1;
    //             $param['source_fns'] = 946;
    //             $param['subject'] = 'Testing';
    //             $host_name = $_SERVER['SERVER_NAME'];
    //             if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //                 $curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             } else {
    //                 $curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             }
    //             $response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
    //             $code = isset($response['status']) ? $response['status'] : '';
    //             $message = isset($response['message']) ? $response['message'] : '';
    //             if ($empid == 67422 || $empid == 63228) {
    //                 echo "successful Weberp History" . $code;
    //                 print_r($response);
    //             }
    //             if ($code == 200) {
    //                 return;
    //             }
    //             //****************************************************end*********************************************************
    //             if ($comment1 != '') {
    //                 $mobile_insert = "INSERT INTO GLUSR_EXCEPTION_REPORT (FK_GLUSR_USR_ID,GLUSR_EXCEPTION_VALUES,GLUSR_EXCEPTION_ID,GLUSR_EXCEPTION_DATE,GLUSR_EXCEPTION_UPDATE_FLAG) VALUES(:FK_GLUSR_USR_ID,:GLUSR_EXCEPTION_VALUES,:GLUSR_EXCEPTION_ID,SYSDATE,'N')";
    //                 $mobile_sth = $dbh->createCommand($mobile_insert);
    //                 $mobile_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_VALUES", $glusr_exception_values);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_ID", $comment1);
    //                 $mobile_sth->execute();
    //             }
    //         }
    //     }
    //     if ((!empty($form['phone_corr_report'])) and ($form['phone_corr_report'] == 1)) {
    //         $mobile_query = "UPDATE GLUSR_USR_phone_CORRECTION SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //         $mobile = $dbh->createCommand($mobile_query);
    //         $mobile->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //         $mobile->execute();
    //     }
    //     // if ((!empty($form['phone_corr_report_nfl'])) and ($form['phone_corr_report_nfl'] == 1)) {
    //     //     $mobile_query = "UPDATE GLUSR_USR_phone_CORRECTION_NFL SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //     //     $mobile = $dbh->createCommand($mobile_query);
    //     //     $mobile->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //     //     $mobile->execute();
    //     // }
    //     if ((!empty($form['pin_corr_report'])) and ($form['pin_corr_report'] == 1)) {
    //         $pin_query = "DELETE FROM GLUSR_USR_PIN_CORRECTION WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID AND CONTACT_TYPE='Z'";
    //         $pin = $dbh->createCommand($pin_query);
    //         $pin->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //         $pin->execute();
    //     }
    //     // if ((!empty($form['pin_corr_report_ip'])) and ($form['pin_corr_report_ip'] == 1)) {
    //     //     $pin_query = "DELETE FROM GLUSR_PIN_INDIAPOST_CORRECTION WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID AND CONTACT_TYPE='Z'";
    //     //     $pin = $dbh->createCommand($pin_query);
    //     //     $pin->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //     //     $pin->execute();
    //     // }
    //     // if ((!empty($form['eto_offer_report'])) and ($form['eto_offer_report'] == 1)) {
    //     //     $eto_offer_query = "UPDATE GLUSR_ETO_OFFER_CORR SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //     //     $eto_offer_sth = $dbh->createCommand($eto_offer_query);
    //     //     $eto_offer_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //     //     $eto_offer_sth->execute();
    //     // }
    //     // if ((!empty($form['eto_mob_phn_corr'])) and ($form['eto_mob_phn_corr'] == 1)) {
    //     //     $eto_offer_query = "UPDATE GLUSR_ETO_MOB_PHN_CORR SET ISPROCESSED = 1 WHERE FK_GLUSR_USR_ID = :FK_GLUSR_USR_ID";
    //     //     $eto_offer_sth = $dbh->createCommand($eto_offer_query);
    //     //     $eto_offer_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //     //     $eto_offer_sth->execute();
    //     // }
    //     if (((!empty($form['frlclient'])) and ($form['frlclient'] == 1)) and (($form['admincomment'] != '') or ($form['comment_suggested'] != ''))) {
    //         $weberp_comment = '';
    //         $glusr_exception_id = '';
    //         $glusr_exception_values = '';
    //         $suggestion_comment = '';
    //         $total_count1 = '';
    //         $suggestion_Dropdown = array();
    //         $date = date("d-M-Y H:i:s");
    //         $date_time = $date;
    //         $comment_suggested = $form['comment_suggested'];
    //         $admincomment = $form['admincomment'];
    //         $bind = '';
    //         $descriptive_cmnt = '';
    //         if (preg_match('/^Approve not to freelist$/', $form['editb']) or preg_match('/^Approve-NFL$/', $form['editb']) || preg_match('/^Approve-DNF$/', $form['editb']) || preg_match('/^Approve-UNF$/', $form['editb'])) {
    //             $descriptive_cmnt = "Kindly issue a ticket with required/requested information to get the company freelisted";
    //         }
    //         if ($comment_suggested != '') {
    //             if ($form['suggestion_comment_value'] != '') {
    //                 $glusr_exception_values = $form['suggestion_comment_value'];
    //                 $glusr_exception_id = $comment_suggested;
    //             } else {
    //                 $suggestion_Dropdown = explode("##", $comment_suggested);
    //                 $glusr_exception_id = $suggestion_Dropdown[0];
    //                 $glusr_exception_values = $suggestion_Dropdown[1];
    //             }
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nFreelisting request Not Approved Due to:$glusr_exception_values, $descriptive_cmnt\n";
    //         } else {
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nAdmin Comment:$admincomment\n$descriptive_cmnt\n";
    //         }
    //         if ($comment_suggested != '') {
    //             $sql_count1 = "SELECT COUNT(1) CNT FROM GLUSR_EXCEPTION_REPORT WHERE FK_GLUSR_USR_ID = :IILGlusrid AND GLUSR_EXCEPTION_ID = :EXCEPTION_ID AND TO_DATE(GLUSR_EXCEPTION_DATE,'DD-MON-YY') = TO_DATE(SYSDATE,'DD-MON-YY')";
    //             $sth_count1 = $dbh->createCommand($sql_count1);
    //             $sth_count1->bindValue(":IILGlusrid", $form['id']);
    //             $sth_count1->bindValue(":EXCEPTION_ID", $glusr_exception_id);
    //             $list = $sth_count1->query();
    //             $data = $list->read();
    //             $total_count1 = $data['CNT'];
    //         }
    //         if ($total_count1 == 0 or $admincomment != '') {
    //             //********************************************************STS Update Service********************************************
    //             $empid = Yii::app()->session['empid'];
    //             $empname = Yii::app()->session['empname'];
    //             $empemail = Yii::app()->session['empemail'];
    //             $comment = "GST is Approved." . "\n Basis:" . isset($weberp_comment) ? $weberp_comment : '';
    //             $param = array();
    //             $param['glid'] = $glusr_id;
    //             $param['comment'] = $comment;
    //             $param['mail_from'] = $empemail;
    //             $param['mail_from_name'] = $empname;
    //             $param['updated_by'] = $empname;
    //             $param['modid'] = 'GLADMIN';
    //             $param['module_name'] = 'GLADMIN';
    //             $param['showdata'] = 1;
    //             $param['source_fns'] = 946;
    //             $param['subject'] = 'Testing';
    //             $host_name = $_SERVER['SERVER_NAME'];
    //             if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //                 $curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             } else {
    //                 $curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             }
    //             $response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
    //             $code = isset($response['status']) ? $response['status'] : '';
    //             $message = isset($response['message']) ? $response['message'] : '';
    //             if ($empid == 67422 || $empid == 63228) {
    //                 echo "successful Weberp History" . $code;
    //                 print_r($response);
    //             }
    //             if ($code == 200) {
    //                 return;
    //             }
    //             //****************************************************end*********************************************************
    //             if ($comment_suggested != '') {
    //                 $mobile_insert = "INSERT INTO GLUSR_EXCEPTION_REPORT (FK_GLUSR_USR_ID,GLUSR_EXCEPTION_VALUES,GLUSR_EXCEPTION_ID,GLUSR_EXCEPTION_DATE,GLUSR_EXCEPTION_UPDATE_FLAG) VALUES(:FK_GLUSR_USR_ID,:GLUSR_EXCEPTION_VALUES,:GLUSR_EXCEPTION_ID,SYSDATE,'N')";
    //                 $mobile_sth = $dbh->createCommand($mobile_insert);
    //                 $mobile_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_VALUES", $glusr_exception_values);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_ID", $glusr_exception_id);
    //                 $mobile_sth->execute();
    //             }
    //         }
    //     }
    //     if (((!empty($form['tfrclient'])) and ($form['tfrclient'] == 1)) and (($form['admincomment'] != '') or ($form['comment_suggested'] != ''))) {
    //         $weberp_comment = '';
    //         $glusr_exception_id = '';
    //         $glusr_exception_values = '';
    //         $suggestion_comment = '';
    //         $total_count1 = '';
    //         $suggestion_Dropdown = array();
    //         $date_time = date("d-M-Y h:i:s");
    //         if (!empty($form['comment_suggested'])) {
    //             $comment_suggested = $form['comment_suggested'];
    //         } else {
    //             $comment_suggested = '';
    //         }
    //         if (!empty($form['admincomment'])) {
    //             $admincomment = $form['admincomment'];
    //         } else {
    //             $admincomment = '';
    //         }
    //         $bind = '';
    //         if ($comment_suggested != '') {
    //             if ($form['suggestion_comment_value'] != '') {
    //                 $glusr_exception_values = $form['suggestion_comment_value'];
    //                 $glusr_exception_id = $comment_suggested;
    //             } else {
    //                 $suggestion_Dropdown = explode("##", $comment_suggested);
    //                 $glusr_exception_id = $suggestion_Dropdown[0];
    //                 $glusr_exception_values = $suggestion_Dropdown[1];
    //             }
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nSuggestion Comment:$glusr_exception_values\n";
    //         } else {
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nAdmin Comment:$admincomment\n";
    //         }
    //         if ($comment_suggested != '') {
    //             $sql_count1 = "SELECT COUNT(1) CNT FROM GLUSR_EXCEPTION_REPORT WHERE FK_GLUSR_USR_ID = :IILGlusrid AND GLUSR_EXCEPTION_ID = :EXCEPTION_ID AND TO_DATE(GLUSR_EXCEPTION_DATE,'DD-MON-YY') = TO_DATE(SYSDATE,'DD-MON-YY')";
    //             $sth_count1 = $dbh->createCommand($sql_count1);
    //             $sth_count1->bindValue(":IILGlusrid", $form['id']);
    //             $sth_count1->bindValue(":EXCEPTION_ID", $glusr_exception_id);
    //             $list = $sth_count1->query();
    //             $data = $list->read();
    //             $total_count1 = $data['CNT'];
    //         }
    //         if ($total_count1 == 0 || $admincomment != '') {
    //             //********************************************************STS Update Service********************************************
    //             $empid = Yii::app()->session['empid'];
    //             $empname = Yii::app()->session['empname'];
    //             $empemail = Yii::app()->session['empemail'];
    //             $comment = "GST is Approved." . "\n Basis:" . isset($weberp_comment) ? $weberp_comment : '';
    //             $param = array();
    //             $param['glid'] = $glusr_id;
    //             $param['comment'] = $comment;
    //             $param['mail_from'] = $empemail;
    //             $param['mail_from_name'] = $empname;
    //             $param['updated_by'] = $empname;
    //             $param['modid'] = 'GLADMIN';
    //             $param['module_name'] = 'GLADMIN';
    //             $param['showdata'] = 1;
    //             $param['source_fns'] = 946;
    //             $param['subject'] = 'Testing';
    //             $host_name = $_SERVER['SERVER_NAME'];
    //             if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //                 $curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             } else {
    //                 $curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             }
    //             $response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
    //             $code = isset($response['status']) ? $response['status'] : '';
    //             $message = isset($response['message']) ? $response['message'] : '';
    //             if ($empid == 67422 || $empid == 63228) {
    //                 echo "successful Weberp History" . $code;
    //                 print_r($response);
    //             }
    //             if ($code == 200) {
    //                 return;
    //             }
    //             //****************************************************end*********************************************************
    //             if ($comment_suggested != '') {
    //                 $mobile_insert = "INSERT INTO GLUSR_EXCEPTION_REPORT (FK_GLUSR_USR_ID,GLUSR_EXCEPTION_VALUES,GLUSR_EXCEPTION_ID,GLUSR_EXCEPTION_DATE,GLUSR_EXCEPTION_UPDATE_FLAG) VALUES(:FK_GLUSR_USR_ID,:GLUSR_EXCEPTION_VALUES,:GLUSR_EXCEPTION_ID,SYSDATE,'N')";
    //                 $mobile_sth = $dbh->createCommand($mobile_insert);
    //                 $mobile_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_VALUES", $glusr_exception_values);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_ID", $glusr_exception_id);
    //                 $mobile_sth->execute();
    //             }
    //         }
    //     }
    //     if (((!empty($form['client'])) and ($form['client'] == 1)) and (($form['admincomment'] != '') or ($form['comment_suggested'] != ''))) {
    //         $weberp_comment = '';
    //         $glusr_exception_id = '';
    //         $glusr_exception_values = '';
    //         $suggestion_comment = '';
    //         $total_count1 = '';
    //         $suggestion_Dropdown = array();
    //         $date_time = date("d-M-Y h:i:s");
    //         $comment_suggested = $form['comment_suggested'] || '';
    //         $admincomment = $form['admincomment'];
    //         $bind = '';
    //         if ($comment_suggested != '') {
    //             if ($form['suggestion_comment_value'] != '') {
    //                 $glusr_exception_values = $form['suggestion_comment_value'];
    //                 $glusr_exception_id = $comment_suggested;
    //             } else {
    //                 $suggestion_Dropdown = explode("##", $comment_suggested);
    //                 $glusr_exception_id = !empty($suggestion_Dropdown[0]) ? $suggestion_Dropdown[0] : '';
    //                 $glusr_exception_values = !empty($suggestion_Dropdown[1]) ? $suggestion_Dropdown[1] : '';
    //             }
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nSuggestion Comment:$glusr_exception_values\n";
    //         } else {
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nAdmin Comment:$admincomment\n";
    //         }
    //         if ($comment_suggested != '') {
    //             $sql_count1 = "SELECT COUNT(1) CNT FROM GLUSR_EXCEPTION_REPORT WHERE FK_GLUSR_USR_ID = :IILGlusrid AND GLUSR_EXCEPTION_ID = :EXCEPTION_ID AND TO_DATE(GLUSR_EXCEPTION_DATE,'DD-MON-YY') = TO_DATE(SYSDATE,'DD-MON-YY')";
    //             $sth_count1 = $dbh->createCommand($sql_count1);
    //             $sth_count1->bindValue(":IILGlusrid", $form['id']);
    //             $sth_count1->bindValue(":EXCEPTION_ID", $glusr_exception_id);
    //             $list = $sth_count1->query();
    //             $data = $list->read();
    //             $total_count1 = $data['CNT'];
    //         }
    //         if ($total_count1 == 0 or $admincomment != '') {
    //             //********************************************************STS Update Service********************************************
    //             $empid = Yii::app()->session['empid'];
    //             $empname = Yii::app()->session['empname'];
    //             $empemail = Yii::app()->session['empemail'];
    //             $comment = "GST is Approved." . "\n Basis:" . isset($weberp_comment) ? $weberp_comment : '';
    //             $param = array();
    //             $param['glid'] = $glusr_id;
    //             $param['comment'] = $comment;
    //             $param['mail_from'] = $empemail;
    //             $param['mail_from_name'] = $empname;
    //             $param['updated_by'] = $empname;
    //             $param['modid'] = 'GLADMIN';
    //             $param['module_name'] = 'GLADMIN';
    //             $param['showdata'] = 1;
    //             $param['source_fns'] = 946;
    //             $param['subject'] = 'Testing';
    //             $host_name = $_SERVER['SERVER_NAME'];
    //             if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //                 $curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             } else {
    //                 $curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             }
    //             $response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
    //             $code = isset($response['status']) ? $response['status'] : '';
    //             $message = isset($response['message']) ? $response['message'] : '';
    //             if ($empid == 67422 || $empid == 63228) {
    //                 echo "successful Weberp History" . $code;
    //                 print_r($response);
    //             }
    //             if ($code == 200) {
    //                 return;
    //             }
    //             //****************************************************end*********************************************************
    //             if ($comment_suggested != '') {
    //                 $mobile_insert = "INSERT INTO GLUSR_EXCEPTION_REPORT (FK_GLUSR_USR_ID,GLUSR_EXCEPTION_VALUES,GLUSR_EXCEPTION_ID,GLUSR_EXCEPTION_DATE,GLUSR_EXCEPTION_UPDATE_FLAG) VALUES(:FK_GLUSR_USR_ID,:GLUSR_EXCEPTION_VALUES,:GLUSR_EXCEPTION_ID,SYSDATE,'N')";
    //                 $mobile_sth = $dbh->createCommand($mobile_insert);
    //                 $mobile_sth->bindValue(":FK_GLUSR_USR_ID", $form['id']);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_VALUES", $glusr_exception_values);
    //                 $mobile_sth->bindValue(":GLUSR_EXCEPTION_ID", $glusr_exception_id);
    //                 $mobile_sth->execute();
    //             }
    //         }
    //     }
    //     if (((!empty($form['dis_clnt_fcp2_flag'])) and ($form['dis_clnt_fcp2_flag'] == 1)) and (($form['admincomment'] != '') or ($form['comment_suggested'] != ''))) {
    //         $weberp_comment = '';
    //         $glusr_exception_id = '';
    //         $glusr_exception_values = '';
    //         $suggestion_comment = '';
    //         $total_count1 = '';
    //         $suggestion_Dropdown = array();
    //         $date_time = date("d-M-Y h:i:s");
    //         if (!empty($form['comment_suggested'])) {
    //             $comment_suggested = $form['comment_suggested'];
    //         } else {
    //             $comment_suggested = '';
    //         }
    //         if (!empty($form['admincomment'])) {
    //             $admincomment = $form['admincomment'];
    //         } else {
    //             $admincomment = '';
    //         }
    //         $bind = '';
    //         if ($comment_suggested != '') {
    //             if ($form['suggestion_comment_value'] != '') {
    //                 $glusr_exception_values = $form['suggestion_comment_value'];
    //                 $glusr_exception_id = $comment_suggested;
    //             } else {
    //                 $suggestion_Dropdown = explode('##', $comment_suggested);
    //                 $glusr_exception_id = $suggestion_Dropdown[0];
    //                 $glusr_exception_values = $suggestion_Dropdown[1];
    //             }
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nSuggestion Comment:$glusr_exception_values\n";
    //         } else {
    //             $weberp_comment = "$date_time Updated By $updatedby Through Gladmin Module\nAdmin Comment:$admincomment\n";
    //         }
    //         if ($comment_suggested != '') {
    //             $sql_count1 = "SELECT COUNT(1) CNT FROM GLUSR_EXCEPTION_REPORT WHERE FK_GLUSR_USR_ID = :IILGlusrid AND GLUSR_EXCEPTION_ID = :EXCEPTION_ID AND TO_DATE(GLUSR_EXCEPTION_DATE,'DD-MON-YY') = TO_DATE(SYSDATE,'DD-MON-YY')";
    //             $sth_count1 = $dbh->createCommand($sql_count1);
    //             $sth_count1->bindValue(":IILGlusrid", $form['id']);
    //             $sth_count1->bindValue(":EXCEPTION_ID", $glusr_exception_id);
    //             $list = $sth_count1->query();
    //             $data = $list->read();
    //             $total_count1 = $data['CNT'];
    //             $sth_count1->finish();
    //         }
    //         if ($total_count1 == 0 or $admincomment != '') {
    //             //********************************************************STS Update Service********************************************
    //             $empid = Yii::app()->session['empid'];
    //             $empname = Yii::app()->session['empname'];
    //             $empemail = Yii::app()->session['empemail'];
    //             $comment = "GST is Approved." . "\n Basis:" . isset($weberp_comment) ? $weberp_comment : '';
    //             $param = array();
    //             $param['glid'] = $glusr_id;
    //             $param['comment'] = $comment;
    //             $param['mail_from'] = $empemail;
    //             $param['mail_from_name'] = $empname;
    //             $param['updated_by'] = $empname;
    //             $param['modid'] = 'GLADMIN';
    //             $param['module_name'] = 'GLADMIN';
    //             $param['showdata'] = 1;
    //             $param['source_fns'] = 946;
    //             $param['subject'] = 'Testing';
    //             $host_name = $_SERVER['SERVER_NAME'];
    //             if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //                 $curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             } else {
    //                 $curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
    //             }
    //             $response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
    //             $code = isset($response['status']) ? $response['status'] : '';
    //             $message = isset($response['message']) ? $response['message'] : '';
    //             if ($empid == 67422 || $empid == 63228) {
    //                 echo "successful Weberp History" . $code;
    //                 print_r($response);
    //             }
    //             if ($code == 200) {
    //                 return;
    //             }
    //             //****************************************************end*********************************************************

    //         }
    //     }
    //     $arr = array();
    //     $k = $a = $y = $x = '';
    //     $val = array();
    //     $sth_item = '';
    //     $count = 0;
    //     $wrt_xml = '';
    //     $name = '';
    //     $history = '';
    //     ksort($form);
    //     $glusr_history = '';
    //     $ha;
    //     if (!empty($check)) {
    //         $h = $this->GetUsrStatus(__CLASS__, __FILE__, __LINE__, $dbh, $form['id'], 1);
    //         if (!empty($h['GLUSR_USR_APPROV'])) {
    //             $old_status = $h['GLUSR_USR_APPROV'];
    //         } else {
    //             $old_status = '';
    //         }
    //         if (!empty($h['GLUSR_USR_TOFREELIST'])) {
    //             $old_app_tofreelist = $h['GLUSR_USR_TOFREELIST'];
    //         } else {
    //             $old_app_tofreelist = '';
    //         }
    //     }
    //     if ($serviceResponse == 1) {
    //         return 1;
    //     }
    // }
    // public function doSellerActivity($params) {
    //     $response = array();
    //     $modid = '';
    //     $gate = '';
    //     $execution = 0;
    //     $data_status = 0;
    //     if (is_array($params)) {
    //         $glusrid = isset($params['glusrid']) ? $params['glusrid'] : '';
    //         $mobile = isset($params['mobile']) ? $params['mobile'] : '';
    //         $listing_source = isset($params['listing_source']) ? $params['listing_source'] : '';
    //         $approve = isset($params['approve']) ? $params['approve'] : '';
    //         $host_name = $_SERVER['SERVER_NAME'];
    //         $m2 = new Globalconnection();
    //         // if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //         //     $dbh_pg = $m2->connect_db_yii('postgress_web226v');
    //         // } else {
    //         //     $dbh_pg = $m2->connect_db_yii('postgress_web205v');
    //         // }
    //         if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
    //             $dbh_pg1 = $m2->connect_db_yii('postgress_devapproval');
    //         } else {
    //             $dbh_pg1 = $m2->connect_db_yii('postgress_approval');
    //         }
    //         if ($mobile == "") {
    //             echo "Mobile is not present. PLEASE CONTACT GLADMIN TEAM";
    //             exit;
    //         }
    //         if ($listing_source == "GLUSR_REJECTED" && $approve != 'D') {
    //             $bind = array();
    //             $sql = "select fcp_data_search_glusr_id,fcp_data_status,fcp_data_process_date from fcp_data_log where fcp_data_ph_mobile = :mobile";
    //             $bind[':mobile'] = $mobile;
    //             $sth2 = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_pg1, $sql, $bind);
    //             $result = $sth2->read();
    //             $query = '';
    //             $bind_array = array();
    //             if (!$result) {
    //                 $bind1 = array();
    //                 $query = $sql = "insert into fcp_data_log (fcp_data_search_glusr_id,fcp_data_ph_mobile,fcp_data_data_source,fcp_data_date,fcp_data_status) values (:glusrid,:mobile,:listing_source,:date,:data_status)";
    //                 $bind1[':glusrid'] = $glusrid;
    //                 $bind1[':mobile'] = $mobile;
    //                 $bind1[':listing_source'] = $listing_source;
    //                 $bind1[':date'] = date("Y-m-d H:i:s");
    //                 $bind1[':data_status'] = $data_status;
    //                 $bind_array = $bind1;
    //                 $result = $this->ExecQuery(__FILE__, __LINE__, __CLASS__, $dbh_pg1, $sql, $bind1);
    //                 $execution = 1;
    //             } else {
    //                 $bind2 = array();
    //                 $fcp_data_status = isset($result['fcp_data_status']) ? $result['fcp_data_status'] : 0;
    //                 $fcp_data_process_date = !empty($result['fcp_data_process_date']) ? $result['fcp_data_process_date'] : '';
    //                 $date1 = date_create($fcp_data_process_date);
    //                 $date2 = date_create(date("Y-m-d"));
    //                 $diff = date_diff($date2, $date1);
    //                 $days = $diff->format("%a");
    //                 if ($days < 30) {
    //                     $execution = 0;
    //                 } else {
    //                     $query = $sql = "update fcp_data_log set fcp_data_ph_mobile = :mobile,fcp_data_data_source = :listing_source,fcp_data_date = :date ,fcp_data_status = :data_status where fcp_data_ph_mobile = :mobile";
    //                     $bind2[':glusrid'] = $glusrid;
    //                     $bind2[':mobile'] = $mobile;
    //                     $bind2[':listing_source'] = $listing_source;
    //                     $bind2[':date'] = date("Y-m-d H:i:s");
    //                     $bind2[':data_status'] = $fcp_data_status;
    //                     $bind_array = $bind2;
    //                     $result = $this->ExecQuery(__FILE__, __LINE__, __CLASS__, $dbh_pg1, $sql, $bind2);
    //                     $execution = 1;
    //                 }
    //             }
    //         }
    //     }
    //     return $execution;
    // }
    public function new_recent_history($glusr_id) //userapproval
    {
        $glusr_history = $html = $cur_history = $row = $transaction_type_privious = $changed_field_list = '';
        $changed_field = array(
          'GLUSR_USR_COUNTRYNAME' => 'Country',
          'Mobile' => 'Phone_Number',
          'Mobile 2 Number' => 'Mobile_2_Number',
          'e-Mail 3' => 'E-mail2',
          'e-Mail 4' => 'E-mail3',
          'Phone 3 Number' => '',
          'Fax 2 Number' => 'Alternate Fax',
          'Mobile 3 Number' => 'Mobile_3_Number',
          'Mobile 4 Number' => 'Mobile_4_Number',
          'Phone 4 Number' => '',
          'First Name' => 'First Name',
          'Last Name' => 'Last Name',
          'Company Name' => 'Company Name',
          'Address Line 1' => 'Address',
          'Address Line 2' => 'Address',
          'Zip' => 'Zip/Postal Code',
          'Phone Number' => 'Phone_Number',
          'Fax Number' => '',
          'Designation' => 'Designation',
          'Alternate Website' => 'Website',
          'GLUSR_USR_CFIRSTNAME ' => 'CEO First Name',
          'GLUSR_USR_CLASTNAME' => 'CEO First Name',
          'Phone2 Number' => '',
          'e-Mail 2' => 'Alternate Email',
          'Village or Town' => 'Village/Town',
          'Legal Status' => 'ownerselect',
          'Business Type IDs' => 'Nature of biz',
          'Quality Policy' => 'Quality policy',
          'GLUSR_USR_INFRASTRUCTURE' => 'Factory & Infrastructure',
          'GLUSR_USR_TRADEMEMBERSHIP' => 'Trade Membership',
          'Additional Contact Name' => 'Contact Name',
          'Number of Employees' => 'No. of Employee',
          'Year of Establishment' => 'Year of Estb.',
          'Turnover' => 'Turnover changed',
          'Company Description' => 'Company Description',
          'GLUSR_USR_SELLINTEREST' => 'Product Profile',
          'Product' => 'Add Your Products / Services'
        );
        $glusr_id = intval($glusr_id);
        $CUR_result = '';
        $in_vis = - 1;
        // echo "new_recent_historynew_recent_historynew_recent_historynew_recent_history";
        // $obj = new Globalconnection();
        // $c = $obj->connect_db_oci_mesh();
        // $cur_history = oci_new_cursor($c);
        // $sql = "CALL PCK_GL_HISTORY.SP_SHOW_LATEST_HISTORY(:GLUSR_ID, :CUR_HISTORY, :IN_VISIBILITY)";
        // $s = oci_parse($c, $sql);
        // oci_bind_by_name($s, ":GLUSR_ID", $glusr_id);
        // oci_bind_by_name($s, ":CUR_HISTORY", $cur_history, 0, OCI_B_CURSOR);
        // oci_bind_by_name($s, ":IN_VISIBILITY", $in_vis);
        // oci_execute($s);
        // oci_execute($cur_history);
        $column_id = 0;
        $serv_model = new ServiceGlobalModelForm;
        $host_name = $_SERVER['SERVER_NAME'];
        if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
            $url = 'http://stg-mapi.indiamart.com/wservce/users/History/';
        } else {
            $url = 'http://users.imutils.com/wservce/users/History/';
        }
        $params = array();
        $params['token'] = 'imobile@15061981';
        $params['modid'] = 'Gladmin';
        $params['hist_type'] = 'G';
        $params['glusrid'] = $glusr_id;
        $params['column_id'] = $column_id;
        // $params['transaction_id'] = $transaction_id;
        $params['hist_action'] = 'latest';
        $params['hist_flag'] = 'latest';
        $serviceoutput = $serv_model->mapiService('HISTORYDETAILS', $url, $params, 'No');
        // echo "<pre>";
        // print_r($serviceoutput);
        // exit;
        $histdata = (isset($serviceoutput['Response']['Data']) && is_array($serviceoutput['Response']['Data']) && ($serviceoutput['Response']['Data'] != array())) ? $serviceoutput['Response']['Data'] : array();
        $count = 0;
        $count1 = 0;
        $frst_count = 0;
        // while ($r = oci_fetch_row($cur_history))
        if ($histdata != array())
        {
          foreach ($histdata as $r)
          {
              $date_arr = array();
              $fk_glusr_usr_id = $fk_gl_attribute_id = $gl_attribute_column_name = $attr_name = $gl_history_old_value = $gl_history_new_value = $gl_history_update_date = $gl_history_update_time = $gl_history_updated_by_id = $gl_history_updated_by_name = $gl_history_updated_by_agency = $gl_history_updated_by_screen = $gl_history_updated_url = $gl_history_updated_ip = $gl_history_updated_ip_country = $gl_history_comments = $gl_history_transaction_type = $gl_history_transaction_id = '';
              $row1 = array();
              $row1 = $r;
              if (isset($row1[0])) {
                  $fk_glusr_usr_id = $row1[0];
              }
              if (isset($row1[1])) {
                  $fk_gl_attribute_id = $row1[1];
              }
              if (isset($row1[2])) {
                  $gl_attribute_column_name = $row1[2];
              }
              if (isset($row1[3])) {
                  $attr_name = $row1[3];
              }
              if (isset($row1[4])) {
                  $gl_history_old_value = $row1[4];
              }
              if (isset($row1[5])) {
                  $gl_history_new_value = $row1[5];
              }
              if (isset($row1[6])) {
                  $gl_history_update_date = $row1[6];
              }
              if (isset($row1[7])) {
                  $gl_history_update_time = $row1[7];
              }
              if (isset($row1[8])) {
                  $gl_history_updated_by_id = $row1[8];
              }
              if (isset($row1[9])) {
                  $gl_history_updated_by_name = $row1[9];
              }
              if (isset($row1[10])) {
                  $gl_history_updated_by_agency = $row1[10];
              }
              if (isset($row1[11])) {
                  $gl_history_updated_by_screen = $row1[11];
              }
              if (isset($row1[12])) {
                  $gl_history_updated_url = $row1[12];
              }
              if (isset($row1[13])) {
                  $gl_history_updated_ip = $row1[13];
              }
              if (isset($row1[14])) {
                  $gl_history_updated_ip_country = $row1[14];
              }
              if (isset($row1[15])) {
                  $gl_history_comments = $row1[15];
              }
              if (isset($row1[16])) {
                  $gl_history_transaction_type = $row1[16];
              }
              if (isset($row1[17])) {
                  $gl_history_transaction_id = $row1[17];
              }
              if (!$gl_history_old_value) {
                  $gl_history_old_value = '';
              }
              if (!$gl_history_new_value) {
                  $gl_history_new_value = '';
              }
              $comnt = '';
              if (isset($gl_history_comments)) {
                  if ($gl_history_comments != 'N/A' && $gl_history_comments != '') {
                      $comnt = "<tr><td colspan='4'>$gl_history_comments</td></tr>";
                  }
              }
              if (isset($gl_history_updated_by_screen)) {
                  if ($gl_history_updated_by_screen == 'N/A') {
                      $gl_history_updated_by_screen = $gl_history_updated_url;
                  }
              }
              if (isset($fk_gl_attribute_id)) {
                  if ($fk_gl_attribute_id == '104') {
                      if ($gl_history_old_value != '') {
                          $gl_history_old_value = '---Not Shown here---';
                      }
                      if ($gl_history_new_value != '') {
                          $gl_history_new_value = '---Not Shown here---';
                      }
                  }
              }
              if (isset($gl_history_transaction_type)) {
                  if ($gl_history_transaction_type == 'U' || $gl_history_transaction_type == '') {
                      $gl_history_transaction_type = 'Updated By';
                  } else if ($gl_history_transaction_type == 'I') {
                      $gl_history_transaction_type = 'Insert By';
                  } else if ($gl_history_transaction_type == 'V') {
                      $gl_history_transaction_type = 'Verified By';
                  } else if ($gl_history_transaction_type == 'D') {
                      $gl_history_transaction_type = 'Deleted By';
                  } else if ($gl_history_transaction_type == 'W') {
                      $gl_history_transaction_type = 'Unverified By';
                  } else if ($gl_history_transaction_type == 'A') {
                      $gl_history_transaction_type = 'Attempted By';
                  } else if ($gl_history_transaction_type == 'T') {
                      $gl_history_transaction_type = 'Tactical Verified By';
                  }
              }
              $date_time = $gl_history_update_time;
              $final_date_time = '';
              $final_date_time = $gl_history_update_time;
              if (isset($changed_field[$attr_name])) {
                  $changed_field_list.= $changed_field[$attr_name] . "##";
              }
              if (preg_match('/product/', $attr_name)) {
                  $changed_field_list.= "Add Your Products / Services##";
              }
              if ($attr_name != 'GLUSR_USR_UPDATEDBY' && $attr_name != 'GLUSR_USR_LASTMODIFIED' && $attr_name != 'GLUSR_USR_IP' && $attr_name != 'GLUSR_USR_UPDATEDBY_ID' && $attr_name != 'GLUSR_USR_IP_COUNTRY' && $attr_name != 'GLUSR_USR_UPDATESCREEN' && $attr_name != 'GLUSR_USR_UPDATEDUSING' && $attr_name != 'GLUSR_USR_UPDATEDBY_URL') {
                  if ($gl_history_transaction_id == $transaction_type_privious) {
                      $count = 0;
                      $count1++;
                      $html.= "<tr><td>$count1.</td>";
                      $html.= "<td>$attr_name</td>";
                      $html.= "<td>$gl_history_old_value</td>";
                      $html.= "<td>$gl_history_new_value</td></tr>";
                  } else {
                      $count = 1;
                      $count1 = 1;
                      if ($html != '') {
                          $html.= "</table>";
                      }
                      if ($count == 1) {
                          $html.= '<table class="table table-bordered" width="100%" bgcolor="#FAFEFF">';
                      }
                      if ($gl_history_updated_ip == 'N/A') {
                          $html.= "<tr><td colspan='4'>$gl_history_transaction_type : $gl_history_updated_by_name on $final_date_time using $gl_history_updated_by_screen</td></tr>$comnt";
                          if ($fk_gl_attribute_id == '1298' && $gl_history_old_value == '' && $gl_history_new_value == '') {
                          } else {
                              $html.= "<tr bgcolor='#f1f1f1'><td width='10%'><b>S.No.</b></td><td width='30%'><b>Changed Data</b></td><td width='30%'><b>Old Value</b></td><td width='30%'><b>New Value</b></td></tr><tr><td>$count.</td><td>$attr_name</td><td>$gl_history_old_value</td><td>$gl_history_new_value</td></tr>";
                          }
                      } else {
                          $html.= "<tr><td colspan='4'>$gl_history_transaction_type : $gl_history_updated_by_name on $final_date_time from $gl_history_updated_ip [$gl_history_updated_ip_country] using $gl_history_updated_by_screen</td></tr>$comnt";
                          if ($fk_gl_attribute_id == '1298' && $gl_history_old_value == '' && $gl_history_new_value == '') {
                          } else {
                              $html.= "<tr bgcolor='#f1f1f1'><td width='10%'><b>S.No.</b></td><td width='30%'><b>Changed Data</b></td><td width='30%'><b>Old Value</b></td><td width='30%'><b>New Value</b></td></tr><tr><td>$count.</td><td>$attr_name</td><td>$gl_history_old_value</td><td>$gl_history_new_value</td></tr>";
                          }
                      }
                      $count = 0;
                  }
                  $transaction_type_privious = $gl_history_transaction_id;
              }
          }
        }

        if ($html) {
        } else {
            $html = '<div align="center"><br><br><b>RECENT HISTORY NOT AVAILABLE . REFER TO COMPLETE GLUSR HISTORY FOR OLDER HISTORY</b></div>';
        }
        if ($changed_field_list != '') {
            $changed_field_list = substr($changed_field_list, 0, -2);
        }
        $ret_fld['html'] = $html;
        $ret_fld['changed_field_list'] = $changed_field_list;
        return $ret_fld;
    }
    public function ShowEdit($form, $user_permissions) //Searchbyuser
    { 
        $return = array();
        $eid = Yii::app()->session['empid'];
        $GLUSR_BUYPRD_NAME = '';
        $moduleId = $form['mid'];
        $gotostr = '';
        $fcpurlht_flag;
        if (isset($form['fcpurlht'])) {
            $fcpurlht_flag = $form['fcpurlht'];
        } else {
            $fcpurlht_flag = '';
        }
        if (isset($form['screen_change'])) {
            $screen_change = $form['screen_change'];
        } else {
            $screen_change = 0;
        }
        if (isset($form['single_screen'])) {
            $single_screen = $form['single_screen'];
        } else {
            $single_screen = 0;
        }
        $dis_clnt_fcp2_flag = '';
        if (isset($form['rpt_typ'])) {
            $dis_clnt_fcp2_flag = $form['rpt_typ'];
        } else {
            $dis_clnt_fcp2_flag = 0;
        }
        if (isset($form['action_file'])) {
            $action_file = $form['action_file'];
        } else {
            $action_file = "/index.php?r=admin_glusr/MultipleScreen/index";
        }
        if (isset($form['view_rownumber'])) {
            if (!empty($form['view_rownumber'])) {
                $form['view_rownumber'] = $form['view_rownumber'];
            } else {
                $form['view_rownumber'] = 1;
            }
        } else {
            $form['view_rownumber'] = 1;
        }
        if (isset($form['view_count'])) {
            if (!empty($form['view_count'])) {
                $form['view_count'] = $form['view_count'];
            } else {
                $form['view_count'] = '';
            }
        } else {
            $form['view_count'] = '';
        }
        $t_name = '';
        $table = '';
        $ha = '';
        $records = '';
        $gotostr = '';
        $mod_Status_Client = '';
        $is_client = '';
        $cust_type = '';
        $ci_st_query = '';
        $order_by = '';
        $site_url = $_SERVER['SERVER_NAME'];
        $CURRENT_DOMAIN = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] != '' ? $_SERVER['UTILS_URL'] : '';
        if (!empty($form['id'])) {
            $ha = $this->get_glusr_detail($form['id'], 'ALL');
            if (empty($ha) || empty($ha['GLUSR_USR_ID'])) {
                echo '<div class="container"><span style="color:red" align="center">No Records Found</span> <br/><br/><input type="button" onClick="javascript:history.go(-1)" value="Back"></input></div>';
                exit;
            }
            $total = "";
            $itno = '';
            $st2 = '';
            $records = "";
            $dt = '';
            $dt['view_rownum'] = $itno;
            $dt['view_count'] = $total;
            $dt['glid'] = $form['id'];
            $dt['records'] = "";
            $a = $form['app'];
            $id = $form['id'];
            $vcount = $form['view_count'];
            $vrownum = $form['view_rownumber'];
        }
        $record_val = '';
        $gotolink = "<FONT SIZE=-2 FACE=verdana,arialarial><B>Jump to: </B><SELECT NAME=searchby class=span2><OPTION VALUE=id>User Id</OPTION><OPTION VALUE=email>Email</OPTION>$record_val</SELECT>
        <INPUT TYPE=TEXT NAME=searchstr SIZE=7 MAXLENGTH=100 class=input-small search-query>
        <INPUT TYPE=SUBMIT NAME=search VALUE=Go STYLE=height:23px;font-size:8px;>";
        $city_name = $state_name = '';
        $state_others = '';
        $city_others = '';
        if ($ha) {
            if (!empty($ha['GLUSR_USR_PH_COUNTRY'])) $ha['GLUSR_USR_PH_COUNTRY'] = preg_replace('/\s+/', '', $ha['GLUSR_USR_PH_COUNTRY']);
            if (!empty($ha['GLUSR_USR_FAX_COUNTRY'])) $ha['GLUSR_USR_FAX_COUNTRY'] = preg_replace('/\s+/', '', $ha['GLUSR_USR_FAX_COUNTRY']);
            if (!empty($ha['GLUSR_USR_MOBILE_COUNTRY'])) $ha['GLUSR_USR_MOBILE_COUNTRY'] = preg_replace('/\s+/', '', $ha['GLUSR_USR_MOBILE_COUNTRY']);
            if (!empty($ha['GL_COUNTRY_PHONECODE'])) {
                $ha['GLUSR_USR_FAX_COUNTRY'] = $ha['GL_COUNTRY_PHONECODE'];
                $ha['GLUSR_USR_PH_COUNTRY'] = $ha['GL_COUNTRY_PHONECODE'];
                $ha['GLUSR_USR_MOBILE_COUNTRY'] = $ha['GL_COUNTRY_PHONECODE'];
            }
            if (isset($ha['GLUSR_USR_CITY'])) {
                if (!empty($ha['GLUSR_USR_CITY'])) {
                    $city_name = $ha['GLUSR_USR_CITY'];
                } else if (isset($ha['GLUSR_USR_CITY_OTHERS'])) {
                    $city_name = $ha['GLUSR_USR_CITY_OTHERS'];
                }
            } else {
                if (empty($city_name)) {
                    if (isset($ha['GLUSR_USR_CITY_OTHERS'])) {
                        $city_name = $ha['GLUSR_USR_CITY_OTHERS'];
                    }
                }
            }
            $return['district'] = isset($ha['GLUSR_USR_DISTRICT']) ? $ha['GLUSR_USR_DISTRICT'] : '';
            $return['locality'] = isset($ha['GLUSR_USR_LOCALITY']) ? $ha['GLUSR_USR_LOCALITY'] : '';
            $return['landmark'] = isset($ha['GLUSR_USR_LANDMARK']) ? $ha['GLUSR_USR_LANDMARK'] : '';
            if (isset($ha['GLUSR_USR_STATE'])) {
                if (!empty($ha['GLUSR_USR_STATE'])) {
                    $state_name = $ha['GLUSR_USR_STATE'];
                } else if (isset($ha['GLUSR_USR_STATE_OTHERS'])) {
                    $state_name = $ha['GLUSR_USR_STATE_OTHERS'];
                }
            } else {
                if (empty($state_name)) {
                    if (isset($ha['GLUSR_USR_STATE_OTHERS'])) {
                        $state_name = $ha['GLUSR_USR_STATE_OTHERS'];
                    }
                }
            }
            if (!empty($ha['GLUSR_USR_IPADDRESS'])) {
                $ip = $ha['GLUSR_USR_IPADDRESS'];
                if (preg_match("/,/", $ip)) {
                    $ar = explode(",", $ip);
                    $ip = end($ar);
                }
                $return['ip_acc_country'] = '';
            } else {
                $return['ip_acc_country'] = '';
            }
            $return['city'] = $city_name;
            $return['state'] = $state_name;
            // $is_client = $cust_type = $total = $cust_type_wt = '';
            // if (!empty($ha['GLUSR_USR_ID'])) {
            //     $arr = $this->IsClient(__FILE__, __LINE__, $dbh, $ha['GLUSR_USR_ID']); // to be replaced by service filed kajal
            //     $total = $arr['total'];
            //     $cust_type_wt = $arr['custtype_weight'];
            // }
            $return['isclient'] = isset($ha['IS_PAID']) ? $ha['IS_PAID'] : 0;
            // $return['custtype_weight'] = isset($ha['GLUSR_USR_CUSTTYPE_WEIGHT']) ? $ha['GLUSR_USR_CUSTTYPE_WEIGHT'] : '';
            // $return['gl_cust_wt'] = isset($ha['GLUSR_USR_CUSTTYPE_WEIGHT']) ? $ha['GLUSR_USR_CUSTTYPE_WEIGHT'] : '';
            $return['GLUSR_BADURL_STATUS'] = '';
            if (!isset($ha['FK_GL_CITY_ID'])) {
                $return['city_others'] = '(Others)';
            } else {
                $return['city_others'] = '';
            }
            if (!isset($ha['FK_GL_STATE_ID'])) {
                $return['state_others'] = '(Others)';
            } else {
                $return['state_others'] = '';
            }
            $glusrId = !empty($ha['GLUSR_USR_ID']) ? $ha['GLUSR_USR_ID'] : '';
            $skipThisTophonePool = 0;
            $ha_sugg = '';
            $vendor_entry = '';
            if (isset($ha['GLUSR_USR_IS_VENDOR_ENTRY'])) {
                if ($ha['GLUSR_USR_IS_VENDOR_ENTRY'] != 0) {
                    $vendor_entry = 'Vendor';
                } else {
                    $vendor_entry = 'Self';
                }
            } else {
                $vendor_entry = 'Self';
            }
            if (isset($ha['GLUSR_USR_URL'])) {
                $ha['GLUSR_USR_URL'] = $ha['GLUSR_USR_URL'];
            } else {
                $ha['GLUSR_USR_URL'] = '';
            }
            if (isset($ha['GLUSR_BADURL_STATUS'])) {
                $ha['GLUSR_BADURL_STATUS'] = $ha['GLUSR_BADURL_STATUS'];
            } else {
                $ha['GLUSR_BADURL_STATUS'] = '';
            }
            if (!$ha['GLUSR_USR_URL'] || $ha['GLUSR_BADURL_STATUS'] = "/\(\)/)") {
                $ha['GLUSR_BADURL_STATUS'] = '';
            }
            $dup_comp = '';
            if (isset($ha['FK_PARENT_GLUSR_ID'])) {
                $parent_glusr_id = $ha['FK_PARENT_GLUSR_ID'];
            } else {
                $parent_glusr_id = '';
            }
            if (($parent_glusr_id != '') and ($glusrId != $parent_glusr_id)) {
                $dup_comp = "Duplicate Company";
                $return['dup_company'] = $dup_comp;
            } else {
                $return['dup_company'] = $dup_comp;
            }
            $adult_type = '';
            if (isset($ha['GLUSR_USR_ADULT_FLAG'])) {
                $adult_type = $ha['GLUSR_USR_ADULT_FLAG'];
                $return['adult_flag'] = $adult_type;
            } else {
                $adult_type = '';
                $return['adult_flag'] = $adult_type;
            }
            $processed_date = '';
            $processed_by = '';
            $dup_fields = '';
            $dup_fld = '';
            $showddup = '';
            $dup_field_exist = '';
            $gl_cust_wt = '';
            $message = '';
            $fk_parent_id = $parent_glusr_id;
            if (isset($ha['GLUSR_USR_CUSTTYPE_ID'])) {
                $gl_cust_wt = $ha['GLUSR_USR_CUSTTYPE_ID'];
            } else {
                $gl_cust_wt = 9;
            }
            if (isset($ha['GLUSR_USR_CUSTTYPE_NAME'])) {
                $gl_cust_wt_name = $ha['GLUSR_USR_CUSTTYPE_NAME'];
            } else {
                $gl_cust_wt_name = 'N/A';
            }
        }
        $paid_or_free = '';
        if (!empty($ha['GLUSR_USR_ID'])) {
            // to show parent data
            if ($fk_parent_id == 0) {
                $return['IS_PARENT'] = 1;
            } else {
                $return['IS_PARENT'] = 0;
            }
            $return['GLUSR_USR_ID'] = $ha['GLUSR_USR_ID'];
            $return['first_name'] = ucwords(!empty($ha['GLUSR_USR_FIRSTNAME']) ? $ha['GLUSR_USR_FIRSTNAME'] : '');
            $return['custtype_id'] = $gl_cust_wt;
            $return['parent_custtype_weight'] = $gl_cust_wt;
            $return['custtype_weight_name'] = $gl_cust_wt_name;
            $return['gotostr'] = $gotostr;
        }
        if (isset($ha['GLUSR_USR_LASTNAME'])) {
            $return['last_name'] = ucwords($ha['GLUSR_USR_LASTNAME']);
        } else {
            $return['last_name'] = '';
        }
        if (isset($ha['GLUSR_USR_CFIRSTNAME'])) {
            $return['cfirst_name'] = ucwords($ha['GLUSR_USR_CFIRSTNAME']);
        } else {
            $return['cfirst_name'] = '';
        }
        if (isset($ha['GLUSR_USR_CLASTNAME'])) {
            $return['clast_name'] = ucwords($ha['GLUSR_USR_CLASTNAME']);
        } else {
            $return['clast_name'] = '';
        }
        if (isset($ha['GLUSR_USR_DESIGNATION'])) {
            $return['designation'] = ucwords($ha['GLUSR_USR_DESIGNATION']);
        } else {
            $return['designation'] = '';
        }
        if (isset($ha['GLUSR_USR_COMPANYNAME'])) {
            $return['comp_name'] = $ha['GLUSR_USR_COMPANYNAME'];
        } else {
            $return['comp_name'] = '';
        }
        $return['email'] = !empty($ha['GLUSR_USR_EMAIL']) ? $ha['GLUSR_USR_EMAIL'] : '';
        if (!empty($paid_or_free)) {
            $return['paid_or_free'] = $paid_or_free;
        } else {
            $return['paid_or_free'] = '';
        }
        if (isset($ha['GLUSR_USR_ADD1'])) {
            $return['str_add1'] = $ha['GLUSR_USR_ADD1'];
        } else {
            $return['str_add1'] = '';
        }
        if (isset($ha['GLUSR_USR_ADD2'])) {
            $return['str_add2'] = $ha['GLUSR_USR_ADD2'];
        } else {
            $return['str_add2'] = '';
        }
        if (isset($ha['FK_GL_CITY_ID'])) {
            $return['cityid'] = $ha['FK_GL_CITY_ID'];
        } else {
            $return['cityid'] = '';
        }
        if (isset($ha['FK_GL_STATE_ID'])) {
            $return['stateid'] = $ha['FK_GL_STATE_ID'];
        } else {
            $return['stateid'] = '';
        }
        if (isset($ha['GLUSR_USR_ZIP'])) {
            $return['zip'] = $ha['GLUSR_USR_ZIP'];
        } else {
            $return['zip'] = '';
        }
        if (isset($ha['GLUSR_USR_PH_COUNTRY'])) {
            $return['ph_country'] = $ha['GLUSR_USR_PH_COUNTRY'];
        } else {
            $return['ph_country'] = '';
        }
        if (isset($ha['GLUSR_USR_PH_AREA'])) {
            $return['ph_area'] = $ha['GLUSR_USR_PH_AREA'];
        } else {
            $return['ph_area'] = '';
        }
        if (isset($ha['GLUSR_USR_PH_NUMBER'])) {
            $return['ph_no'] = $ha['GLUSR_USR_PH_NUMBER'];
        } else {
            $return['ph_no'] = '';
        }
        if (isset($ha['GLUSR_USR_IM_GSM'])) {
            $return['ph_pns'] = $ha['GLUSR_USR_IM_GSM'];
        } else {
            $return['ph_pns'] = '';
        }
        if (isset($ha['GLUSR_USR_FAX_COUNTRY'])) {
            $return['fax_country'] = $ha['GLUSR_USR_FAX_COUNTRY'];
        } else {
            $return['fax_country'] = '';
        }
        if (isset($ha['GLUSR_USR_FAX_AREA'])) {
            $return['fax_area'] = $ha['GLUSR_USR_FAX_AREA'];
        } else {
            $return['fax_area'] = '';
        }
        if (isset($ha['GLUSR_USR_FAX_NUMBER'])) {
            $return['fax_no'] = $ha['GLUSR_USR_FAX_NUMBER'];
        } else {
            $return['fax_no'] = '';
        }
        if (isset($ha['GLUSR_USR_PH_MOBILE'])) {
            $return['mobile'] = $ha['GLUSR_USR_PH_MOBILE'];
        } else {
            $return['mobile'] = '';
        }
        if (isset($ha['GLUSR_USR_URL'])) {
            $return['website'] = $ha['GLUSR_USR_URL'];
        } else {
            $return['website'] = '';
        }
        if (isset($ha['GLUSR_USR_COMPANY_DESC'])) {
            $return['company_description'] = $ha['GLUSR_USR_COMPANY_DESC'];
        } else {
            $return['company_description'] = '';
        }
        if (isset($ha['GLUSR_USR_SELLINTEREST'])) {
            $p_sell = $this->ProcessTinyMCE($ha['GLUSR_USR_SELLINTEREST']);
            $return['prd_sell'] = $p_sell;
        } else {
            $return['prd_sell'] = '';
        }
        if (isset($ha['GLUSR_USR_COMPANY_DESC'])) {
            $return['company_description'] = $ha['GLUSR_USR_COMPANY_DESC'];
        } else {
            $return['company_description'] = '';
        }
        if (isset($ha['GLUSR_USR_BUYINTEREST'])) {
            $return['prd_buy'] = $ha['GLUSR_USR_BUYINTEREST'];
        } else {
            $return['prd_buy'] = '';
        }
        if (isset($ha['GLUSR_USR_EMAIL_ALT'])) {
            $return['email2'] = $ha['GLUSR_USR_EMAIL_ALT'];
        } else {
            $return['email2'] = '';
        }
        if (isset($ha['PAIDSHOWROOM_URL'])) {
            $return['paidurl'] = $ha['PAIDSHOWROOM_URL'];
        } else {
            $return['paidurl'] = '';
        }
        if (isset($ha['GLUSR_USR_PH_COUNTRY'])) {
            $return['ph_country2'] = $ha['GLUSR_USR_PH_COUNTRY'];
        } else {
            $return['ph_country2'] = '';
        }
        if (isset($ha['GLUSR_USR_PH2_AREA'])) {
            $return['ph_area2'] = $ha['GLUSR_USR_PH2_AREA'];
        } else {
            $return['ph_area2'] = '';
        }
        if (isset($ha['GLUSR_USR_PH2_NUMBER'])) {
            $return['ph_no2'] = $ha['GLUSR_USR_PH2_NUMBER'];
        } else {
            $return['ph_no2'] = '';
        }
        if (isset($ha['FREESHOWROOM_URL'])) {
            $return['free_url'] = $ha['FREESHOWROOM_URL'];
        } else {
            $return['free_url'] = '';
        }
        if (isset($ha['FREESHOWROOM_URL_HT'])) {
            $return['free_ht'] = $ha['FREESHOWROOM_URL_HT'];
        } else {
            $return['free_ht'] = '';
        }
        if (isset($ha['FCP_FLAG'])) {
            $return['fcp_flag'] = $ha['FCP_FLAG'];
        } else {
            $return['fcp_flag'] = '';
            $ha['FCP_FLAG'] = '';
        }
        if (isset($ha['FCP_FLAG_HT'])) {
            $return['fcp_flag_ht'] = $ha['FCP_FLAG_HT'];
        } else {
            $return['fcp_flag_ht'] = '';
            $ha['FCP_FLAG_HT'] = '';
        }
        if (isset($ha['GLUSR_USR_ADD_CONTACTNAME'])) {
            $return['contactname'] = $ha['GLUSR_USR_ADD_CONTACTNAME'];
        } else {
            $return['contactname'] = '';
        }
        if (isset($ha['GLUSR_USR_FAX2_NUMBER'])) {
            $return['alternate_fax'] = $ha['GLUSR_USR_FAX2_NUMBER'];
        } else {
            $return['alternate_fax'] = '';
        }
        if (isset($ha['GLUSR_USR_FAX2_AREA'])) {
            $return['fax2_area'] = $ha['GLUSR_USR_FAX2_AREA'];
        } else {
            $return['fax2_area'] = '';
        }
        if (isset($ha['GLUSR_USR_PH_MOBILE_ALT'])) {
            $return['alternate_mobile'] = $ha['GLUSR_USR_PH_MOBILE_ALT'];
        } else {
            $return['alternate_mobile'] = '';
        }
        if (isset($ha['FREESHOWROOM_ALIAS_HT'])) {
            $return['change_alias_ht'] = $ha['FREESHOWROOM_ALIAS_HT'];
        } else {
            $return['change_alias_ht'] = '';
        }
        if (isset($ha['GLUSR_USR_SKYPE'])) {
            $return['glusr_skype'] = $ha['GLUSR_USR_SKYPE'];
        } else {
            $return['glusr_skype'] = '';
        }
        if (isset($ha['GLUSR_USR_OLD_PAID_URL'])) {
            $return['old_paid_url'] = $ha['GLUSR_USR_OLD_PAID_URL'];
        } else {
            $return['old_paid_url'] = '';
        }
        if (isset($ha['FREESHOWROOM_ALIAS_IM'])) {
            $return['indiamart_alias'] = $ha['FREESHOWROOM_ALIAS_IM'];
        } else {
            $return['indiamart_alias'] = '';
        }
        if (isset($ha['GLUSR_USR_IS_VENDOR_ENTRY'])) {
            $return['vendor_entry'] = $vendor_entry;
        } else {
            $return['vendor_entry'] = '';
        }
        if (isset($ha['GLUSR_USR_ADULT_FLAG'])) {
            $return['is_adult_flag'] = $adult_type;
        } else {
            $return['is_adult_flag'] = '';
        }
        if (isset($ha['GLUSR_USR_MOBILE_COUNTRY'])) {
            $return['mob_country'] = $ha['GLUSR_USR_MOBILE_COUNTRY'];
        } else {
            $return['mob_country'] = '';
        }
        if (isset($ha['GLUSR_USR_MOBILE_COUNTRY'])) {
            $return['alt_mob_country'] = $ha['GLUSR_USR_MOBILE_COUNTRY'];
        } else {
            $return['alt_mob_country'] = '';
        }
        if (isset($ha['GLUSR_USR_PH_COUNTRY'])) {
            $return['ph_country2'] = $ha['GLUSR_USR_PH_COUNTRY'];
        } else {
            $return['ph_country2'] = '';
        }
        if (isset($ha['GLUSR_USR_PH4_AREA'])) {
            $return['ph_area4'] = $ha['GLUSR_USR_PH4_AREA'];
        } else {
            $return['ph_area4'] = '';
        }
        if (isset($ha['FK_PARENT_GLUSR_ID'])) {
            $return['fk_glusr_parent_id'] = $ha['FK_PARENT_GLUSR_ID'];
        } else {
            $return['fk_glusr_parent_id'] = '';
        }
        if (isset($ha['GLUSR_USR_IM_GSM'])) {
            $return['ph_pns'] = $ha['GLUSR_USR_IM_GSM'];
        } else {
            $return['ph_pns'] = '';
        }
        if (isset($ha['GLUSR_USR_QUALITY'])) {
            $return['quality'] = $ha['GLUSR_USR_QUALITY'];
        } else {
            $return['quality'] = '';
        }
        if (isset($ha['GLUSR_USR_INFRASTRUCTURE'])) {
            $return['usr_infrastructure'] = $ha['GLUSR_USR_INFRASTRUCTURE'];
        } else {
            $return['usr_infrastructure'] = '';
        }
        if (isset($ha['GLUSR_USR_TRADEMEMBERSHIP'])) {
            $return['usr_trademembership'] = $ha['GLUSR_USR_TRADEMEMBERSHIP'];
        } else {
            $return['usr_trademembership'] = '';
        }
        if (isset($ha['GLUSR_USR_LISTING_SOURCE'])) {
            $return['listing_source'] = $ha['GLUSR_USR_LISTING_SOURCE'];
        } else {
            $return['listing_source'] = '';
        }
        if (isset($ha['GLUSR_USR_LISTING_ISHOTEL'])) {
            $return['listing_ishotel'] = $ha['GLUSR_USR_LISTING_ISHOTEL'];
        } else {
            $return['listing_ishotel'] = '';
        }
        if (isset($ha['GLUSR_USR_ISO9000'])) {
            $return['iso9000_certified'] = $ha['GLUSR_USR_ISO9000'];
        } else {
            $return['iso9000_certified'] = '';
        }
        if (isset($ha['GLUSR_USR_ISO14000'])) {
            $return['iso14000_certified'] = $ha['GLUSR_USR_ISO14000'];
        } else {
            $return['iso14000_certified'] = '';
        }
        if (isset($skipThisTophonePool)) {
            $return['skipThisTophonePool'] = $skipThisTophonePool;
        } else {
            $return['skipThisTophonePool'] = 0;
        }
        $fcp_flag = '';
        $fcp_flag_ht = '';
        if ($ha['FCP_FLAG'] == 1) {
            $fcp_flag = "&nbsp;<font color=green>Active</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=red>Manually Disable</font><input name=fcp_flag value=3 type=checkbox>";
        } else if ($ha['FCP_FLAG'] == 3) {
            $fcp_flag = "&nbsp;<font color=red>Manually Disabled</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=green>Activate</font><input name=fcp_flag value=w type=checkbox valign=bottom>";
        } else if ($ha['FCP_FLAG'] == 2) {
            $fcp_flag = "&nbsp;<font color=red>Disabled</font>";
        } else if ($ha['FCP_FLAG'] == 4) {
            $fcp_flag = "&nbsp;<font color=red>Email Disabled</font><input name=fcp_flag value=3 type=checkbox>";
        } else {
            $fcp_flag = "&nbsp;<font color=0000FF>Waiting</font>";
        }
        if ($ha['FCP_FLAG_HT'] == 1) {
            $fcp_flag_ht = "&nbsp;<font color=green>Active</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=red>Manually Disable</font><input name=fcp_flag_ht value=3 type=checkbox>";
        } else if ($ha['FCP_FLAG_HT'] == 3) {
            $fcp_flag_ht = "&nbsp;<font color=red>Manually Disabled</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=green>Activate</font><input name=fcp_flag_ht value=w type=checkbox valign=bottom>";
        } else if ($ha['FCP_FLAG_HT'] == 2) {
            $fcp_flag_ht = "&nbsp;<font color=red>Disabled</font>";
        } else {
            $fcp_flag_ht = "&nbsp;<font color=0000FF>Waiting</font>";
        }
        $return['emp_id'] = Yii::app()->session['empid'];
        if (isset($ha['FK_GLUSR_BIZ_IDS'])) {
            $biznature = $this->GetBizNatureGlusr_bootstrap($ha['FK_GLUSR_BIZ_IDS']);
            $return['biznature'] = $biznature;
        } else {
            $biznature = $this->GetBizNatureGlusr_bootstrap(0);
            $return['biznature'] = $biznature;
        }
        if (isset($ha['FK_GL_COUNTRY_ISO'])) {
            $return['fk_gl_country_iso'] = $ha['FK_GL_COUNTRY_ISO'];
        } else {
            $return['fk_gl_country_iso'] = '';
        }
        if (isset($ha['GLUSR_USR_COUNTRYNAME'])) {
            $return['glusr_usr_countryname'] = $ha['GLUSR_USR_COUNTRYNAME'];
        } else {
            $return['glusr_usr_countryname'] = '';
        }
        if (isset($ha_sugg)) {
            $return['select_sugg_value'] = $ha_sugg;
        } else {
            $return['select_sugg_value'] = '';
        }
        if (isset($screen_change)) {
            $return['screen_change'] = $screen_change;
        } else {
            $return['screen_change'] = '';
        }
        $gluserID_cr = isset($form['id']) ? $form['id'] : '';
        $serv_model = new ServiceGlobalModelForm();
        if ($gluserID_cr > 0) {
            if (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net')) {
                $url = "http://dev-mapi.indiamart.com/wservce/users/credit/";
            } else {
                $url = "http://mapi.indiamart.com/wservce/users/credit/";
            }
            $content = array('token' => 'imobile@15061981', 'modid' => 'GLADMIN', 'glusrid' => $gluserID_cr);
            $data_string = http_build_query($content);
            $eto_cust_credits_av_arr = $serv_model->mapiService('CREDIT', $url, $data_string, 'No');
            if (isset($eto_cust_credits_av_arr['RESPONSE'])) {
                $eto_cust_credits = isset($eto_cust_credits_av_arr['RESPONSE']['DATA1']) ? $eto_cust_credits_av_arr['RESPONSE']['DATA1'] : '';
                $return['GLUSR_ETO_CUST_CREDITS_AV'] = isset($eto_cust_credits['bl_purchase_count']) ? $eto_cust_credits['bl_purchase_count'] : 0;
            } else {
                $return['GLUSR_ETO_CUST_CREDITS_AV'] = 0;
            }
        }
        if (isset($ha['FK_GLUSR_NOOF_EMP_ID'])) {
            $return['fk_glusr_noof_emp_id'] = $ha['FK_GLUSR_NOOF_EMP_ID'];
        } else {
            $return['fk_glusr_noof_emp_id'] = '';
        }
        if (isset($ha['FK_GLUSR_TURNOVER_ID'])) {
            $return['fk_glusr_turnover_id'] = $ha['FK_GLUSR_TURNOVER_ID'];
        } else {
            $return['fk_glusr_turnover_id'] = '';
        }
        if (isset($ha['FK_GL_LEGAL_STATUS_ID'])) {
            $return['fk_gl_legal_status_id'] = $ha['FK_GL_LEGAL_STATUS_ID'];
        } else {
            $return['fk_gl_legal_status_id'] = '';
        }
        if (isset($ha['FK_GLUSR_BIZ_IDS'])) {
            $return['biz_id'] = $ha['FK_GLUSR_BIZ_IDS'];
        } else {
            $return['biz_id'] = '';
        }
        if (isset($ha['GLUSR_USR_LOC_PREF'])) {
            $return['loctype'] = $ha['GLUSR_USR_LOC_PREF'];
        } else {
            $return['loctype'] = '';
        }
        $return['more_info'] = '';
        $return['view_log'] = ''; // not in use variable
        if (isset($dis_clnt_fcp2_flag)) {
            $return['dis_clnt_fcp2_flag'] = $dis_clnt_fcp2_flag;
        } else {
            $return['dis_clnt_fcp2_flag'] = '';
        }
        if (isset($processed_date)) {
            $return['processed_date'] = $processed_date;
        } else {
            $return['processed_date'] = '';
        }
        if (isset($processed_by)) {
            $return['processed_by'] = $processed_by;
        } else {
            $return['processed_by'] = '';
        }
        if (isset($dup_fields)) {
            $return['dup_fields'] = $dup_fields;
        } else {
            $return['dup_fields'] = '';
        }
        if (isset($dup_field_exist)) {
            $return['dup_field_exist'] = $dup_field_exist;
        } else {
            $return['dup_field_exist'] = '';
        }
        if (isset($showddup)) {
            $return['showddup'] = $showddup;
        } else {
            $return['showddup'] = '';
        }
        if (isset($ha['country_text_name'])) {
            $return['country_text_name'] = $ha['GLUSR_USR_COUNTRYNAME'];
        } else {
            $return['country_text_name'] = '';
        }
        if (!empty($CURRENT_DOMAIN)) {
            $return['current_domain'] = $CURRENT_DOMAIN;
        } else {
            $return['current_domain'] = '';
        }
        if (isset($ha['admincomment'])) {
            if (!empty($ha['admincomment'])) {
                $admincomment = $ha['admincomment'];
                $return['admincomment'] = $admincomment;
            } else {
                $admincomment = '';
                $return['admincomment'] = $admincomment;
            }
        } else {
            $admincomment = '';
            $return['admincomment'] = $admincomment;
        }
        if (!isset($ha['GLUSR_USR_FORCEDLOGOFF_COUNT'])) {
            $ha['GLUSR_USR_FORCEDLOGOFF_COUNT'] = '';
        }
        $return['glusr_usr_forcedlogoff_count'] = $ha['GLUSR_USR_FORCEDLOGOFF_COUNT'];
        $ha['GLUSR_USR_APPROV'] = !empty($ha['GLUSR_USR_APPROV']) ? $ha['GLUSR_USR_APPROV'] : '';
        if ($ha['GLUSR_USR_APPROV'] == 'A' and !empty($ha['GLUSR_USR_LISTING_STATUS']) and $ha['GLUSR_USR_LISTING_STATUS'] != '') {
            if (isset($ha['GLUSR_USR_MODIFYSTATUS'])) {
                if ($ha['GLUSR_USR_MODIFYSTATUS'] == 'T') {
                    $approv = "Approved -" . $ha['GLUSR_USR_LISTING_STATUS'] . "(M)";
                } else {
                    $approv = "Approved -" . $ha['GLUSR_USR_LISTING_STATUS'];
                }
            } else {
                $approv = "Approved -" . $ha['GLUSR_USR_LISTING_STATUS'];
            }
        } else if ($ha['GLUSR_USR_APPROV'] == 'A' and !empty($ha['GLUSR_USR_TOFREELIST']) and $ha['GLUSR_USR_TOFREELIST'] == 1) {
            if ($ha['GLUSR_USR_MODIFYSTATUS'] == 'T') {
                $approv = "Approved - TFL(M)";
            } else {
                $approv = "Approved - TFL";
            }
        } else if ($ha['GLUSR_USR_APPROV'] == 'A' and !empty($ha['GLUSR_USR_TOFREELIST']) and $ha['GLUSR_USR_TOFREELIST'] == 0) {
            if ($ha['GLUSR_USR_MODIFYSTATUS'] == 'T') {
                $approv = "Approved - NFL(M)";
            } else {
                $approv = "Approved - NFL";
            }
        } else if ($ha['GLUSR_USR_APPROV'] == 'A') {
            if ($ha['GLUSR_USR_MODIFYSTATUS'] == 'T') {
                $approv = "Approved(M)";
            } else {
                $approv = "Approved";
            }
        } else if ($ha['GLUSR_USR_APPROV'] == 'D') {
            $approv = "Disabled";
        } else if ($ha['GLUSR_USR_APPROV'] == 'M') {
            $approv = "Error Disabled";
        } else {
            $approv = "Waiting";
        }
        $turnover = '';
        $role = '';
        $noofemp = '';
        $market_type = '';
        if (isset($ha['FK_GLUSR_TURNOVER_ID'])) {
            $ha['FK_GLUSR_TURNOVER_ID'] = $ha['FK_GLUSR_TURNOVER_ID'];
            $turnover = $this->GetTurnover($ha['FK_GLUSR_TURNOVER_ID']);
            $return['turnover'] = $turnover;
        } else {
            $ha['FK_GLUSR_TURNOVER_ID'] = '';
            $turnover = $this->GetTurnover(0);
            $return['turnover'] = $turnover;
        }
        if (isset($ha['FK_GLUSR_NOOF_EMP_ID'])) {
            $ha['FK_GLUSR_NOOF_EMP_ID'] = $ha['FK_GLUSR_NOOF_EMP_ID'];
            $noofemp = $this->GetNoofEmp($ha['FK_GLUSR_NOOF_EMP_ID']);
            $return['noofemp'] = $noofemp;
        } else {
            $ha['FK_GLUSR_NOOF_EMP_ID'] = '';
            $noofemp = $this->GetNoofEmp(0);
            $return['noofemp'] = $noofemp;
        }
        if (isset($ha['FK_GLUSR_BIZ_IDS'])) {
            $ha['FK_GLUSR_BIZ_IDS'] = $ha['FK_GLUSR_BIZ_IDS'];
            $biznature = $this->GetBizNatureGlusr($ha['FK_GLUSR_BIZ_IDS']);
            $return['biznature'] = $biznature;
        } else {
            $ha['FK_GLUSR_BIZ_IDS'] = '';
            $biznature = $this->GetBizNatureGlusr(0);
            $return['biznature'] = $biznature;
        }
        if (isset($ha['GLUSR_USR_MODIFYSTATUS'])) {
            $return['GLUSR_USR_MODIFYSTATUS'] = $ha['GLUSR_USR_MODIFYSTATUS'];
        } else {
            $return['GLUSR_USR_MODIFYSTATUS'] = '';
        }
        $return['FK_GLUSR_BIZ_IDS'] = $ha['FK_GLUSR_BIZ_IDS'];
        $app = '';
        $API = 0;
        $app = $ha['GLUSR_USR_APPROV'];
        $r = $date = '';
        $message;
        $glusrId = !empty($ha['GLUSR_USR_ID']) ? $ha['GLUSR_USR_ID'] : '';
        $ak_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
        $DISABLE_ERRMSG = '';
        $disable_date = '';
        // if (!empty($ha['GLUSR_USR_ID']) && ($ak_key != '')) {
        //     $env = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
        //     if ($env == 'dev-gladmin.intermesh.net' || $env == 'stg-gladmin.intermesh.net') {
        //         $curl = "http://162.217.96.117:9090/list/";
        //     } else {
        //         $curl = "http://redis13-dl.intermesh.net:9090/list/";
        //     }
        //     $ipdata = "value=$glusrId&valueType=glidsuspected&modid=GLADMIN&emp_id=$eid&return_data=0&exceptionHandling=true&ga=0";
        //     $response = $serv_model->mapiService('GraphDb_list', $curl, $ipdata, $jsonRequired = 'No');
        //     $Suspected = isset($response['Suspected']) ? $response['Suspected'] : '';
        //     if ($Suspected == 'Yes') {
        //         $message = "<FONT SIZE=-1>(High Risk Suspected User as per Graph DB)</FONT>";
        //         $API = 1;
        //     } else {
        //         $ipdata = "value=$glusrId&valueType=glidsuspected&modid=GLADMIN&emp_id=$eid&return_data=0&exceptionHandling=true&ga=2";
        //         $response = $serv_model->mapiService('GraphDb_list', $curl, $ipdata, $jsonRequired = 'No');
        //         $Suspected = isset($response['Suspected']) ? $response['Suspected'] : '';
        //         if ($Suspected == 'Yes') {
        //             $message = "<FONT SIZE=-1>(Medium Risk Suspected User as per Graph DB)</FONT>";
        //             $API = 2;
        //         } else {
        //             $ipdata = "value=$glusrId&valueType=glidsuspected&modid=GLADMIN&emp_id=$eid&return_data=0&exceptionHandling=true&ga=1";
        //             $response = $serv_model->mapiService('GraphDb_list', $curl, $ipdata, $jsonRequired = 'No');
        //             $Suspected = isset($response['Suspected']) ? $response['Suspected'] : '';
        //             if ($Suspected == 'Yes') {
        //                 $message = "<FONT SIZE=-1>(Low Risk Suspected User as per Graph DB)</FONT>";
        //                 $API = 3;
        //             }
        //         }
        //     }
        // }
        if ($ha['GLUSR_USR_APPROV'] == "D" && !empty($ha['GLUSR_USR_ID'])) {
            $disable_date = 'N/A';
            $glusr_disable = isset($ha['GLUSR_DISABLED_REASON']) ? $ha['GLUSR_DISABLED_REASON'] : '';
            $glusr_disable = json_decode($glusr_disable, true);
            $glusr_disable_msg = !empty($glusr_disable['GLUSR_DISABLE_ERRMSG_VALUE']) ? $glusr_disable['GLUSR_DISABLE_ERRMSG_VALUE'] : '';
            $glusr_disable_date = !empty($glusr_disable['GLUSR_DISABLE_ERRMSG_DATE']) ? $glusr_disable['GLUSR_DISABLE_ERRMSG_DATE'] : '';
            if ($glusr_disable_date) {
                $disable_date = strtoupper(date("d-M-y", strtotime($glusr_disable_date)));
            }
            $DISABLE_ERRMSG = strtoupper($glusr_disable_msg);
            // if ($Suspected == 'Yes' && $API == 1) {
            //     $message = "<FONT SIZE=-1><B>Disabled on <FONT COLOR=BLUE>$disable_date</FONT> : $DISABLE_ERRMSG</B></FONT>&nbsp;&nbsp;(High Risk Suspected User as per Graph DB)";
            // } elseif ($Suspected == 'Yes' && $API == 2) {
            //     $message = "<FONT SIZE=-1><B>Disabled on <FONT COLOR=BLUE>$disable_date</FONT> : $DISABLE_ERRMSG</B></FONT>&nbsp;&nbsp;(Medium Risk Suspected User as per Graph DB)";
            // } elseif ($Suspected == 'Yes' && $API == 3) {
            //     $message = "<FONT SIZE=-1><B>Disabled on <FONT COLOR=BLUE>$disable_date</FONT> : $DISABLE_ERRMSG</B></FONT>&nbsp;&nbsp;(Low Risk Suspected User as per Graph DB)";
            // } else {
            //     $message = "<FONT SIZE=-1><B>Disabled on <FONT COLOR=BLUE>$disable_date</FONT> : $DISABLE_ERRMSG</B></FONT>";
            // }

            $message = $DISABLE_ERRMSG;
        }
        if (!empty($ha['GLUSR_USR_MODID'])) {
            $return['mod_name'] = $ha['GLUSR_USR_MODID'];
        } else {
            $return['mod_name'] = '';
        }
        // company freeze due to GST**************************************
        $gst_verify = '';
        $cin_verify = '';
        $gst_verified = '';
        $gst_verified_date = '';
        $cin_verified = '';
        $cin_verified_date = '';
        $serv_model = new ServiceGlobalModelForm();
        $verification_detail = $serv_model->get_verification_details($glusrId, '2106,346');
        if (!empty($verification_detail['RESPONSE']['Data'])) {
            $gst_verified = isset($verification_detail['RESPONSE']['Data'][2106]['Status']) ? $verification_detail['RESPONSE']['Data'][2106]['Status'] : '';
            $gst_detail = isset($verification_detail['RESPONSE']['Data'][2106]['Detail']) ? $verification_detail['RESPONSE']['Data'][2106]['Detail'] : '';
            $gst_verified_date = isset($verification_detail['RESPONSE']['Data'][2106]['User_verification_date']) ? $verification_detail['RESPONSE']['Data'][2106]['User_verification_date'] : '';
            $cin_verified = isset($verification_detail['RESPONSE']['Data'][346]['Status']) ? $verification_detail['RESPONSE']['Data'][346]['Status'] : '';
            $cin_detail = isset($verification_detail['RESPONSE']['Data'][346]['Detail']) ? $verification_detail['RESPONSE']['Data'][346]['Detail'] : '';
            $cin_verified_date = isset($verification_detail['RESPONSE']['Data'][346]['User_verification_date']) ? $verification_detail['RESPONSE']['Data'][346]['User_verification_date'] : '';
        }
        if ($eid == 63228 || $eid == 48172) {
            echo "gst verified date================" . $gst_verified_date;
            echo "===cin verified date================" . $cin_verified_date;
        }
        if ($gst_verified == 'Verified' /*&& !empty($gst_verified_date)*/) {
            $gst_verify = 1;
        } else {
            $gst_verify = 0;
        }
        if ($cin_verified == 'Verified' && !empty($cin_verified_date)) {
            $cin_verify = 1;
        } else {
            $cin_verify = 0;
        }
        if (isset($ha['FK_GL_LEGAL_STATUS_ID'])) {
            $return['gst_verify'] = $gst_verify;
            $ha['FK_GL_LEGAL_STATUS_ID'] = $ha['FK_GL_LEGAL_STATUS_ID'];
            $return['cin_verify'] = $cin_verify;
            $ownership = $this->GetOwnership($ha['FK_GL_LEGAL_STATUS_ID'], $gst_verify, $cin_verify);
            $return['ownership'] = $ownership;
        } else {
            $ownership = '';
            $ownership = $this->GetOwnership(0, 0, 0);
            $return['ownership'] = $ownership;
        }
        $return['gst_verify'] = $gst_verify;
        $return['cin_verify'] = $cin_verify;
        // $show_client = "";
        // $is_client = isset($total) ? $total : '';
        // if (!empty($is_client)) {
        //     $show_client = $this->ShowClient($cust_type_wt);
        // }
        $status_history1 = '';
        $history_html = '';
        $returnfields = '';
        $glusr_usr_iso = !empty($ha['FK_GL_COUNTRY_ISO']) ? $ha['FK_GL_COUNTRY_ISO'] : '';
        if (isset($ha['GLUSR_USR_COUNTRYNAME'])) {
            $glusr_country_name = $ha['GLUSR_USR_COUNTRYNAME'];
        }
        $select_country = '';
        $yearlist = '';
        $select_PNS = '';
        $return['DISABLE_ERRMSG'] = $DISABLE_ERRMSG;
        $return['disable_date'] = $disable_date;
        $return['approve'] = $approv;
        $return['approve_status'] = $approv;
        $return['hidden_listing_status'] = $approv;
        if (!empty($show_client)) {
            $return['client'] = $show_client;
        } else {
            $return['client'] = '';
        }
        if (isset($ha['GLUSR_USR_IM_GSM'])) {
            $return['PNS'] = $ha['GLUSR_USR_IM_GSM'];
            $return['select_PNS'] = '';
        } else {
            $return['PNS'] = '';
            $select_PNS = "Select from Pool";
            $return['select_PNS'] = $select_PNS;
        }
        if (isset($ha['FK_GLUSR_USR_PBIZ_ID'])) {
            $ha['FK_GLUSR_USR_PBIZ_ID'] = $ha['FK_GLUSR_USR_PBIZ_ID'];
            $p_biz_del = $this->GetPrimaryBizNature($ha['FK_GLUSR_USR_PBIZ_ID']);
            $return['p_biz_del'] = $p_biz_del;
        } else {
            $ha['FK_GLUSR_USR_PBIZ_ID'] = '';
            $p_biz_del = $this->GetPrimaryBizNature(0);
            $return['p_biz_del'] = $p_biz_del;
        }
        $return['PBIZ_ID'] = (isset($ha['FK_GLUSR_USR_PBIZ_ID'])) ? $ha['FK_GLUSR_USR_PBIZ_ID'] : '';
        $curyear = date("Y");
        $yearlist = '';
        $yrr = 0;
        if (isset($ha['GLUSR_USR_YEAR_OF_ESTB'])) {
            $yrr = $ha['GLUSR_USR_YEAR_OF_ESTB'];
        } else {
            $yrr = 0;
        }
        $YEAR_OF_ESTB = $yrr;
        for ($y = 1800;$y <= $curyear;$y++) {
            if ($y == $yrr) {
                $yearlist.= "<option value=$y selected>$y</option>";
            } else {
                $yearlist.= "<option value=$y>$y</option>";
            }
        }
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : ''; //nikhil
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        if ($company == 'readonly') {
            $yearlist = "<select $YEAR_OF_ESTB readonly onfocus='this.blur()' style='pointer-events: none;' name=year_estb  id=year_estb onchange=document.getElementById('year_of_estb_span').innerHTML=''><option value=''>Select Year</option>$yearlist</select>";
        } else {
            $yearlist = "<select $YEAR_OF_ESTB name=year_estb  id=year_estb onchange=document.getElementById('year_of_estb_span').innerHTML=''><option value=''>Select Year</option>$yearlist</select>";
        }
        $return['yearlist'] = $yearlist;
        $comnt = '';
        if (!empty($ha['GLUSR_USR_ID'])) {
            $catalog_privacy = $serv_model->get_privacy_warning_data($ha['GLUSR_USR_ID']);
            if (!empty($catalog_privacy['MY_PRIVACY_SETTING_ID']) && $catalog_privacy['MY_PRIVACY_SETTING_ID'] == 24 && $catalog_privacy['ISENABLE'] == 'Disabled') {
                $comnt = 'Client has DISABLED modification on his catalog. Please contact client before making any modification.';
            }
            $return['catalog_privacy'] = $comnt;
        }
        if ($screen_change == 1) {
            $html_page = 'index-full-info.php';
        }
        $return['fcp_flag_show'] = $fcp_flag;
        $return['fcp_flag_ht_show'] = $fcp_flag_ht;
        $return['verified_business_buyer_flag'] = isset($ha['VERIFIED_BUSINESS_BUYER_FLAG']) ? $ha['VERIFIED_BUSINESS_BUYER_FLAG'] : 'NA';
        $return['city_id_for_check'] = isset($ha['FK_GL_CITY_ID']) && $ha['FK_GL_CITY_ID']!='' ? $ha['FK_GL_CITY_ID'] : 0;
        $return['dt'] = isset($dt) ? $dt : '';
        $glid = !empty($ha['GLUSR_USR_ID']) ? $ha['GLUSR_USR_ID'] : '';
        $priority_range = !empty($ha['PRIORITY_RANGE']) ? $ha['PRIORITY_RANGE'] : '';
        if ($priority_range == 0.9) {
            $fcp_rank = 'A';
        } else if ($priority_range == 0.8) {
            $fcp_rank = 'B';
        } else if ($priority_range == 0.7) {
            $fcp_rank = 'C';
        } else if ($priority_range == 0.6) {
            $fcp_rank = 'D';
        } else {
            $fcp_rank = 'N/A';
        }
        $hist_para = $this->new_recent_history($glid);
        $return['fcp_rank'] = $fcp_rank;
        $return['html'] = $hist_para['html'];
        $return['changed_field_list'] = $hist_para['changed_field_list'];
        $return['message'] = isset($message) ? $message : '';
        $return['fcpurlht_flag'] = $fcpurlht_flag;
        $return['app'] = $app;
        if (isset($_REQUEST['screen_change'])) {
            $return['screen_change'] = $_REQUEST['screen_change'];
        } else {
            $return['screen_change'] = '';
        }
        if (!empty($return['email'])) {
            $email_api_status = '';
            $return['emailval1'] = $email_api_status;
        }
        if (!empty($return['email2'])) {
            $email_api_status = '';
            $return['emailval2'] = $email_api_status;
        }
        $return['is_paid'] = !empty($ha['IS_PAID']) ? $ha['IS_PAID'] : '';
        unset($ha);
        return $return;
    }
    public function getEmpName($dbh, $empid) {
        $emp_name = '';
        $emp_id = Yii::app()->session['empid'];
        if ($emp_id == $empid) {
            $emp_name = Yii::app()->session['empname'];
        }
        if (($emp_id != $empid) || empty($emp_name)) {
            $sql = "SELECT GL_EMP_NAME FROM GL_EMP WHERE GL_EMP_ID=:EMP_ID AND GL_EMP_WORKING=-1";
            $sth = $dbh->createCommand($sql);
            $sth->bindValue(":EMP_ID", $empid);
            $d = $sth->query();
            $ha = $d->read();
            $db_emp_name = $ha['GL_EMP_NAME'];
            if (empty($emp_name)) {
                Yii::app()->session['empname'] = $db_emp_name;
            }
            $emp_name = $db_emp_name;
        }
        return $emp_name;
    }
    public function GetTurnover($turnover) {
        if (empty($turnover)) {
            $turnover = 0;
        }
        $readonly = '';
        $readonly = ($readonly == "readonly") ? "disabled" : "";
        $d = CommonVariable::get_turnover_values();
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : ''; //nikhil
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        $select = '';
        if ($d) {
            if ($company == 'readonly') {
                $select = '<SELECT readonly onfocus="this.blur()" CLASS="ldes" SIZE="1" NAME="turnover"  style="pointer-events: none;" id="turnover"' . $readonly . " onblur='if(this.value){
                document.ModReg.Ownership_check.disabled=false;} else { document.ModReg.Ownership_check.disabled=true;
                }' onchange='document.getElementById('turnover_span').innerHTML='';'>";
            } else {
                $select = '<SELECT NAME="turnover" id="turnover"' . $readonly;
            }
            $select.= "<OPTION VALUE=''>---Choose One---</OPTION>";
            foreach ($d as $key => $value) {
                if ($turnover == $key) {
                    $select.= "<OPTION VALUE=$key selected>$value</OPTION>";
                } else {
                    $select.= "<OPTION VALUE=$key>$value</OPTION>";
                }
            }
            $select.= "</SELECT>";
        }
        return $select;
    }
    public function GetUsrTyp_DD($typical) {
        if (empty($typical)) {
            $typical = '';
        }
        $select = '';
        $select = "<SELECT  NAME=role>";
        $select.= "<OPTION VALUE=''>---Choose One---</OPTION>";
        if ($typical == 'B') {
            $select.= "
		<OPTION VALUE=B SELECTED>Buyer</OPTION>
		<OPTION VALUE=S>Seller</OPTION>
		<OPTION VALUE=A>Both</OPTION>
		";
        } else if ($typical == 'S') {
            $select.= "
		<OPTION VALUE=B>Buyer</OPTION>
		<OPTION VALUE=S SELECTED>Seller</OPTION>
		<OPTION VALUE=A>Both</OPTION>
		";
        } else if ($typical == 'A') {
            $select.= "
		<OPTION VALUE=B>Buyer</OPTION>
		<OPTION VALUE=S>Seller</OPTION>
		<OPTION VALUE=A SELECTED>Both</OPTION>
		";
        } else {
            $select.= "
		<OPTION VALUE=B>Buyer</OPTION>
		<OPTION VALUE=S>Seller</OPTION>
		<OPTION VALUE=A>Both</OPTION>
		";
        }
        $select.= "</SELECT>";
        return $select;
    }
    public function GetNoofEmp($noof) {
        if (empty($readonly)) {
            $readonly = '';
        }
        $readonly = ($readonly == "readonly") ? "disabled" : "";
        $d = CommonVariable::get_noof_values();
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : ''; //nikhil
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        $select = '';
        if ($d) {
            if ($company == 'readonly') {
                $select = '<SELECT readonly onfocus="this.blur()" CLASS="ldes" SIZE="1" NAME="noof_emp"  style="pointer-events: none;" id="noof_emp"' . $readonly . " onblur='if(this.value){
                document.ModReg.Ownership_check.disabled=false;} else { document.ModReg.Ownership_check.disabled=true;
                }' onchange='document.getElementById('noof_emp_span').innerHTML='';'>";
            } else {
                $select = '<SELECT NAME="noof_emp" id="noof_emp"' . $readonly . " onblur='if(this.value){
                    document.ModReg.Ownership_check.disabled=false;} else { document.ModReg.Ownership_check.disabled=true;
                    }' onchange='document.getElementById('noof_emp_span').innerHTML='';'>";
            }
            $select.= "<OPTION VALUE=''>---Choose One---</OPTION>";
            foreach ($d as $key => $value) {
                if ($noof == $key) {
                    $select.= "<OPTION VALUE=$key selected>$value</OPTION>";
                } else {
                    $select.= "<OPTION VALUE=$key>$value</OPTION>";
                }
            }
            $select.= "</SELECT>";
        }
        return $select;
    }
    public function GetOwnerShip($ownership, $gst_verify, $cin_verify) {
        if (empty($ownership)) {
            $ownership = 0;
        }
        if (empty($readonly)) {
            $readonly = '';
        }
        $readonly = ($readonly == "readonly") ? "disabled" : "";
        $d = CommonVariable::GetOwnerShip_values();
        $select = $gst_permission = '';
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : ''; //nikhil
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        if ($fld_permission && $fld_permission!=array()) {
            $gst_arr = !empty($fld_permission['GLUSR_USR_COMP_REGISTRATIONS']['GST']) ? $fld_permission['GLUSR_USR_COMP_REGISTRATIONS']['GST'] : '';
            $gst_permission = isset($gst_arr) && $gst_arr == 'readonly' ? '0' : '1';
        }
        if ($d) {
            if ($company == 'readonly') {
                $select = '<SELECT readonly CLASS="ldes" SIZE="1" NAME="legal_status_id"  style="pointer-events: none;" id="legal_status_id"' . $readonly . " onblur='if(this.value){
                    document.ModReg.Ownership_check.disabled=false;} else { document.ModReg.Ownership_check.disabled=true;
                    }' onchange='document.getElementById('ownership_span').innerHTML='';'>";
            } else {
                if (($gst_permission != 1 && ((!empty($gst_verify) && $gst_verify == 1) || (!empty($cin_verify) && $cin_verify == 1)))) {
                    $select = '<SELECT readonly CLASS="ldes" SIZE="1" NAME="legal_status_id"  style="pointer-events: none;" id="legal_status_id"' . $readonly . " onblur='if(this.value){
                    document.ModReg.Ownership_check.disabled=false;} else { document.ModReg.Ownership_check.disabled=true;
                    }' onchange='document.getElementById('ownership_span').innerHTML='';'>";
                } else {
                    $select = '<SELECT CLASS="ldes" SIZE="1" NAME="legal_status_id" id="legal_status_id"' . $readonly . " onblur='if(this.value){
                        document.ModReg.Ownership_check.disabled=false;} else { document.ModReg.Ownership_check.disabled=true;
                        }' onchange='document.getElementById('ownership_span').innerHTML='';'>";
                }
            }
            $select.= "<OPTION VALUE=''>---Choose One---</OPTION>";
            foreach ($d as $key => $value) {
                if ($key == $ownership) {
                    $select.= "<OPTION VALUE=$key selected>$value</OPTION>";
                } else {
                    $select.= "<OPTION VALUE=$key>$value</OPTION>";
                }
            }
        }
        $select.= "</SELECT>";
        return $select;
    }
    public function GetMarketType($dbh, $market) {
        $readonly = '';
        if (isset($market)) {
            $mar = $market;
        } else {
            $mar = '';
        }
        $keywords = preg_split("/,/", $market);
        $st = "SELECT GLUSR_MARKETS_ID,GLUSR_MARKETS_TYPE,GLUSR_MARKETS_VALUE,(SELECT count(1) as count FROM GLUSR_MARKETS) count FROM GLUSR_MARKETS ORDER BY GLUSR_MARKETS_ID";
        $sth = $dbh->createCommand($st);
        $d = $sth->query();
        $select = '';
        $tr = '';
        if ($d) {
            $i = 1;
            while ($h = $d->read()) {
                $value = $h['GLUSR_MARKETS_ID'];
                $name = $h['GLUSR_MARKETS_TYPE'];
                $val = $h['GLUSR_MARKETS_VALUE'];
                $count = $h['COUNT'];
                $width = '';
                if ($i == 1) {
                    $width = "colspan=1";
                } else if ($i == 2) {
                    $width = "colspan=1";
                } else if ($i % 3 == 0) {
                    $width = "colspan=2";
                }
                if (preg_grep("/^$value$/", $keywords)) {
                    $select.= '<TD HEIGHT="20"' . $width . '><INPUT TYPE="CHECKBOX" NAME="market_type[]" value="' . $value . '" CHECKED' . $readonly . ">&nbsp;" . $name . "</TD>";
                } else {
                    $select.= '<TD HEIGHT="20"' . $width . '><INPUT TYPE="CHECKBOX"  NAME="market_type[]" value="' . $value . '"' . $readonly . ">&nbsp;" . $name . "</TD>";
                }
                if ($i % 3 == 0) {
                    $tr.= "<tr>" . $select . "</tr>";
                    $select = "";
                } else if ($i % 3 == 2 && $i == $count) {
                    $tr.= "<tr>" . $select . "<TD></td></tr>";
                    $select = "";
                } else if ($i % 3 == 1 && $i == $count) {
                    $tr.= "<tr>" . $select . "<TD></td><TD></td></tr>";
                    $select = "";
                }
                $i++;
            }
        }
        return $tr;
    }
    public function GetCity($file, $line, $dbh, $city_id) {
        $st = "SELECT GL_CITY_NAME FROM GL_CITY WHERE GL_CITY_ID=:city_id";
        $sth = $dbh->createCommand($st);
        $sth->bindValue(':city_id', $city_id);
        $sth = $sth->query();
        $city_name;
        if (!empty($sth)) {
            $city_name = $sth->read();
            $city_name = $city_name['GL_CITY_NAME'];
        }
        return $city_name;
    }
    public function GetState($file, $line, $dbh, $state_id) {
        $st = "SELECT GL_STATE_NAME FROM GL_STATE WHERE GL_STATE_ID=:state_id";
        $sth = $dbh->createCommand($st);
        $sth->bindValue(':state_id', $state_id);
        $sth = $sth->query();
        $state_name;
        if (!empty($sth)) {
            $state_name = $sth->read();
            $state_name = $state_name['GL_STATE_NAME'];
        }
        return $state_name;
    }
    public function call_sellprod($glid) {
        $row1 = '';
        $CUR_result = '';
        $products_hash = array();
        $all_products = '';
        $row = '';
        $returnValue = '';
        $dbh = $this->connect_db();
        if (!$dbh) {
            $this->print_oracle_error($file_name, $lineno, "Cant connect to database", "ORACLE could not be connected", "$DBI::errstr");
        }
        $c = $dbh;
        $sql = "SELECT STR_PRODUCTS
		FROM
			(
				SELECT
					'***'||LISTAGG(PC_ITEM_ID||'@#@'||PC_ITEM_NAME,'***') WITHIN GROUP (ORDER BY 1)||'***' STR_PRODUCTS
				FROM
					(
						SELECT
							PC_ITEM_ID,
							PC_ITEM_NAME
						FROM
							PC_ITEM,
							(
                                SELECT
                                    PC_CLNT_ID
                                FROM
                                    PC_CLIENT
                                WHERE
                                    FK_GLUSR_USR_ID=:glid
                                    AND PC_CLNT_ENABLED IN ('F', 'Y')
                                    AND ROWNUM < 2
                            )PC_CLIENT,
							GLUSR_USR
						WHERE
							PC_CLNT_ID = FK_PC_CLNT_ID
							AND GLUSR_USR_ID = :glid
                            AND PC_ITEM_STATUS_APPROVAL >= 10
                            AND UPPER(PC_ITEM_NAME)=REPLACE(REPLACE(REPLACE(UPPER(PC_ITEM_DESC_SMALL), '<P>',''),'</P>',''),'&AMP;;','&')
                            AND PC_ITEM_IMG_SMALL_ISDEFAULT=0
						ORDER BY
							PC_ITEM_MODIFIEDDATE DESC
					)
				WHERE
					ROWNUM < 21
			)";
        $sth = $this->runSelect(__FILE__, __LINE__, __CLASS__, $c, $sql, array(':glid' => $glid));
        $ha_prd = $sth->read();
        $returnValue = isset($ha_prd['STR_PRODUCTS']) ? $ha_prd['STR_PRODUCTS'] : '';
        $row = preg_split("/@#@/", $returnValue);
        $h = '';
        $g = array();
        $i = 0;
        foreach ($row as $k => $val) {
            $h = explode("***", $val);
            $g[$i] = $h[0];
            $i++;
        }
        $f = '';
        foreach ($g as $c => $d) {
            if (!empty($d)) {
                $f.= $d . ",";
            } else {
                $f = '';
            }
        }
        if (!empty($f)) {
            $f = substr_replace($f, ".", -1);
        } else {
            $f = '';
        }
        return $f;
    }
    public function primaryMail_Change_Mailer($full_name, $new_mail, $old_mail, $other_mails, $salute_less_name, $country_iso) {
        $subject = "Your New Login Details at IndiaMART.com";
        $message = '
		<html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Primary Email Change</title>
            </head>
            <body>
            <table style="max-width:600px; " align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td valign="top">
            <table style="text-align:left" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td style="width:100%; border:1px solid #dddddd;" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                    <td style=" width:100%; border-bottom:3px solid #2e3192; padding:5px 10px 5px 10px;" height="60" width="100%"><img style="vertical-align:middle; display:block" src="https://www.indiamart.com/newsletters/mailer/images/indiamart-logo-mt.jpg" alt="IndiaMART" border="0" height="40" width="201"></td>
                    </tr>
                </tbody>
                </table></td>
            </tr>

                            <!-- Top Title heading Start Here -->
            <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:9px 9px 9px 9px; " width="100%">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                        <tr>
                        <td style="width:100%; background:#2e3192; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#fff; font-weight:bold; text-align:center; padding:5px 0 5px 0" valign="top" width="100%">Your New Login Detail at IndiaMART.com

                        </td>
                        </tr>
                        </tbody>
                        </table>
                    </td>
                </tr>
            <!-- Top Title heading End Here -->
            <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:10px 9px 9px 9px;padding-top:0;padding-bottom:4px;margin-top:-3px; " width="100%">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>

            <tr>
            <td style="font-family:Arial; font-size:15px;padding-top:10px;" width="100%">
            <span style="color:#000000;font-weight:bold;font-size:14px;">Dear</span> <span style="font-size:14px;font-weight:bold;">' . $full_name . ',</span><br>
            <div style="font-size:13px;float:left;padding-top:10px;line-height:18px;">
            As per your request, IndiaMART support team has successfully updated your Primary E-Mail/Login ID.<br>
            Please find below your changed contact details:
            </div>
            </td>
            </tr> </tbody></table>    </td>
            </tr>
            <tr>
                <td style="width:100%; padding:9px 9px 9px 9px;" valign="top" width="50%">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody><tr>
                                    <td style="width:100%; padding:5px 3px; border:1px solid #d4d4d4;  background-color:#f0f0f0; padding:0 0 0 0; " valign="top">

                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tbody><tr>
                                                    <td style="padding:5px 10px 5px 10px">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-size:13px; line-height:18px; font-family:Arial;padding:5px 5px 10px 6px; ">
            <b>Old Login Email:</b> <a href="#" value="" target="_blank" style="color:#2e3192; text-decoration:none">' . $old_mail . '</a></td></tr>
            <tr>
                                                            <td style="font-size:13px; line-height:18px; font-family:Arial;padding:0px 0 10px 6px; ">
            <b>New Login Email:</b> <a href="#" style="text-decoration:none; color:#2e3192;" target="_blank">' . $new_mail . '</a>
            </td>
            </tr>
            </tbody></table>                                            </td>
            </tr>
            </tbody></table>
                                                                    </td>
                                                                    </tr>
                </tbody></table>
                <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:000; line-height:18px;" valign="top"> </td>
                </tr>


                <tr>
                <td style="width:100%; padding:9px 9px 9px 9px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:000; line-height:18px;border-top:1px solid #d4d4d4;" valign="top">For any query or clarification, please feel free to contact us and we will be glad to assist you. </td>
                </tr>
            <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:9px 9px 9px 9px; " width="100%">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; line-height:18px; padding-bottom:9px">Warm Regards,<br>
                Team IndiaMART</td>
                </tr>
                </tbody></table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#fff; border:1px solid #d1d1d1; text-align:center; " valign="top" width="100%">
                <table style="background:#eee; border-bottom:1px solid #d1d1d1;" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#2e3192; text-align:left; padding:7px 5px 7px 5px; background:#eee; font-weight:bold; ">Happy to Help</td>
            </tr>
            </tbody></table>
                <table style="" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                    <td style="width:100%;font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; color:#000; padding:5px;  text-align:left;" width="50%"><strong>Email:</strong>
                    <a href="mailto:customercare@indiamart.com" style="color:#444">customercare@indiamart.com</a></td>
                    </tr>
                    <tr>
                    <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; color:#000;  padding:5px;  text-align:left;" width="100%">
                    <strong>Toll Free:</strong>

		<span style="color:#444">';
        if ($country_iso == "IN") {
            $message.= '<a style="color:#444;text-decoration:none;" href="tel:18002004444">1800-200-4444</a>';
        } else {
            $message.= '<a style="color:#444;text-decoration:none;" href="tel:919696969696">+(91)-9696969696</a>';
        }
        $message.= '
                    </span>    </td>
                            </tr>
                    </tbody></table>    </td>
                        </tr>
                        </tbody></table>    </td>
                    </tr>
                    </tbody></table>
                    </td>
                    </tr>
                    </tbody></table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td style=" font-family:Arial, Helvetica, sans-serif; font-size:10px; text-align:center; color:#737373; padding:5px 0 0 0 " valign="top">IndiaMART InterMESH Ltd. Advant Navis Business Park, 7th &amp; 8th Floor, Sector - 142, Noida, UP</td>
                    </tr>
                    </tbody></table>
                    </td>
                    </tr>
                    </tbody></table>
                    </body></html>';
        $from_name = 'IndiaMART.com';
        $from = 'customercare@indiamart.com';
        $to_name = $salute_less_name;
        $to = $new_mail;
        $to_name = $salute_less_name;
        $return = "Success";
        $usrName = "myimmails@indiamart.com";
        $pass = "motherindia12";
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' or $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') {
            $to = 'gladmin-team@indiamart.com';
        }
        if ($to && preg_match("/,/", $to)) {
            $toarr = explode(',', $to);
        } else {
            $toarr[0] = $to;
        }
        $url = 'https://api.sendgrid.com/';
        $user = $usrName;
        $pass = $pass;
        $json_string = array('to' => $toarr, 'category' => 'Primary Email Change Gladmin');
        $params = array('api_user' => $user, 'api_key' => $pass, 'x-smtpapi' => json_encode($json_string), 'to' => 'example3@sendgrid.com', 'subject' => $subject, 'html' => $message, 'from' => $from, 'fromname' => $from_name);
        $request = $url . 'api/mail.send.json';
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        curl_close($session);
        $subject = "Your New Login Details at IndiaMART.com";
        $message = '
		<html>
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Primary Email Change</title>
            </head>
            <body>
            <table style="max-width:600px; " align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td valign="top">
            <table style="text-align:left" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td style="width:100%; border:1px solid #dddddd;" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                    <tr>
                    <td style=" width:100%; border-bottom:3px solid #2e3192; padding:5px 10px 5px 10px;" height="60" width="100%"><img style="vertical-align:middle; display:block" src="https://www.indiamart.com/newsletters/mailer/images/indiamart-logo-mt.jpg" alt="IndiaMART" border="0" height="40" width="201"></td>
                    </tr>
                </tbody>
                </table></td>
            </tr>

                            <!-- Top Title heading Start Here -->
            <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:9px 9px 9px 9px; " width="100%">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                        <tr>
                        <td style="width:100%; background:#2e3192; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#fff; font-weight:bold; text-align:center; padding:5px 0 5px 0" valign="top" width="100%">Your New Login Detail at IndiaMART.com

                        </td>
                        </tr>
                        </tbody>
                        </table>

                    </td>
                </tr>
            <!-- Top Title heading End Here -->
            <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:10px 9px 9px 9px;padding-top:0;padding-bottom:4px;margin-top:-3px; " width="100%">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>

            <tr>
            <td style="font-family:Arial; font-size:15px;padding-top:10px;" width="100%">
            <span style="color:#000000;font-weight:bold;font-size:14px;">Dear</span> <span style="font-size:14px;font-weight:bold;">' . $full_name . ',</span><br>
            <div style="font-size:13px;float:left;padding-top:10px;line-height:18px;">
            As per your request, IndiaMART support team has successfully updated your Primary E-Mail/Login ID.<br>
            Please find below your changed contact details:
            </div>
            </td>
            </tr> </tbody></table>    </td>
            </tr>
            <tr>
                <td style="width:100%; padding:9px 9px 9px 9px;" valign="top" width="50%">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody><tr>
                                    <td style="width:100%; padding:5px 3px; border:1px solid #d4d4d4;  background-color:#f0f0f0; padding:0 0 0 0; " valign="top">

                                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tbody><tr>
                                                    <td style="padding:5px 10px 5px 10px">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                        <tr>
                                                            <td style="font-size:13px; line-height:18px; font-family:Arial;padding:5px 5px 10px 6px; ">
            <b>Old Login Email:</b> <a href="#" value="" target="_blank" style="color:#2e3192; text-decoration:none">' . $old_mail . '</a></td></tr>
            <tr>
                                                            <td style="font-size:13px; line-height:18px; font-family:Arial;padding:0px 0 10px 6px; ">
            <b>New Login Email:</b> <a href="#" style="text-decoration:none; color:#2e3192;" target="_blank">' . $new_mail . '</a>
            </td>
            </tr>
            </tbody></table>                                            </td>
            </tr>
            </tbody></table>
                                                                    </td>
                                                                    </tr>
                </tbody></table>
                <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:000; line-height:18px;" valign="top"> </td>
                </tr>


                <tr>
                <td style="width:100%; padding:9px 9px 9px 9px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:000; line-height:18px;border-top:1px solid #d4d4d4;" valign="top">For any query or clarification, please feel free to contact us and we will be glad to assist you. </td>
                </tr>
            <tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:9px 9px 9px 9px; " width="100%">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
                <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; line-height:18px; padding-bottom:9px">Warm Regards,<br>
                Team IndiaMART</td>
                </tr>
                </tbody></table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody><tr>
            <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#fff; border:1px solid #d1d1d1; text-align:center; " valign="top" width="100%">
                <table style="background:#eee; border-bottom:1px solid #d1d1d1;" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#2e3192; text-align:left; padding:7px 5px 7px 5px; background:#eee; font-weight:bold; ">Happy to Help</td>
            </tr>
            </tbody></table>
                <table style="" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tbody><tr>
                    <td style="width:100%;font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; color:#000; padding:5px;  text-align:left;" width="50%"><strong>Email:</strong>
                    <a href="mailto:customercare@indiamart.com" style="color:#444">customercare@indiamart.com</a></td>
                    </tr>
                    <tr>
                    <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; color:#000;  padding:5px;  text-align:left;" width="100%">
                    <strong>Toll Free:</strong>

                    <span style="color:#444">';
        if ($country_iso == "IN") {
            $message.= '<a style="color:#444;text-decoration:none;" href="tel:18002004444">1800-200-4444</a>';
        } else {
            $message.= '<a style="color:#444;text-decoration:none;" href="tel:919696969696">+(91)-9696969696</a>';
        }
        $message.= '
                    </span>    </td>
                            </tr>
                    </tbody></table>    </td>
                        </tr>
                        </tbody></table>    </td>
                    </tr>
                    </tbody></table>
                    </td>
                    </tr>
                    </tbody></table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td style=" font-family:Arial, Helvetica, sans-serif; font-size:10px; text-align:center; color:#737373; padding:5px 0 0 0 " valign="top">IndiaMART InterMESH Ltd. Advant Navis Business Park, 7th &amp; 8th Floor, Sector - 142, Noida, UP</td>
                    </tr>
                    </tbody></table>
                    </td>
                    </tr>
                    </tbody></table>
                    </body></html>';
        $from_name = 'IndiaMART.com';
        $from = 'customercare@indiamart.com';
        $to_name = $salute_less_name;
        $to = $new_mail;
        $to_name = $salute_less_name;
        $return = "Success";
        $usrName = "myimmails@indiamart.com";
        $pass = "motherindia12";
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' or $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') {
            $to = 'gladmin-team@indiamart.com';
        }
        if ($to && preg_match("/,/", $to)) {
            $toarr = explode(',', $to);
        } else {
            $toarr[0] = $to;
        }
        $url = 'https://api.sendgrid.com/';
        $user = $usrName;
        $pass = $pass;
        $json_string = array('to' => $toarr, 'category' => 'Primary Email Change Gladmin');
        $params = array('api_user' => $user, 'api_key' => $pass, 'x-smtpapi' => json_encode($json_string), 'to' => 'example3@sendgrid.com', 'subject' => $subject, 'html' => $message, 'from' => $from, 'fromname' => $from_name);
        $request = $url . 'api/mail.send.json';
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        curl_close($session);
    }
    public function contact_Details_Mailer($full_name, $new_mail, $other_mails, $salute_less_name, $table_html, $glusrId, $form, $country_iso) {
        $subject = "Your Updated Contact Details at IndiaMART";
        $loginPath = $_SERVER['SERVER_NAME'];
        if ($loginPath == 'dev-gladmin.intermesh.net' or $loginPath == 'stg-gladmin.intermesh.net') {
            $new_mail = 'gladmin-team@indiamart.com';
            $other_mails = '';
        }
        $date = date("d-m-Y");
        $mobile = strtolower($form['mobile']);
        $form['mobile_changed'] = !empty($form['mobile_changed']) ? $form['mobile_changed'] : '';
        $change_mobile = '';
        $redirect_login_link = '';
        $server = 'my.indiamart.com';
        if ($_SERVER['HTTP_HOST'] != 'gladmin.intermesh.net') {
            $server = 'stg-my.indiamart.com';
            $createfree = 'dev-fcp.';
        }
        if ($form['mobile_verified'] != 1 || $form['mobile_changed'] == 1) {
            $change_mobile = '
                            <table width="100%">
                                <tr>
                                    <td>
                                        <center><b><span style="font-size:15px;color:#990000">Your Mobile Number <span style="font-weight:bold;color:#000000">' . $mobile . '</span> is not verified with us.</span></b></center>
                                    </td>
                                </tr>
                            </table>';
            $txt_c = 'Click here to Verify your mobile';
            $redirect_link = urlencode("http://$server/cgi/my-contact-verify.mp?utm_source=Contactchangemail&amp;utm_medium=email&amp;utm_campaign=Contactchange-Gladmin-VM");
        } else {
            $txt_c = 'View Contact Details';
            $redirect_link = urlencode("http://$server/cgi/my-contactdetail.mp?utm_source=Contactchangemail&amp;utm_medium=email&amp;utm_campaign=Contactchange-Gladmin-Login");
        }
        $currdate = getdate();
        $date1 = $currdate['year'] . '-' . $currdate['mon'] . '-' . $currdate['mday'] . '-' . $currdate['hours'] . '-' . $currdate['minutes'] . '-' . $currdate['seconds'];
        $en_datetime = $this->RC4($date1);
        $date_en = base64_encode($en_datetime);
        $date_en = urlencode($date_en);
        $age = $this->RC4('7');
        $age_en = base64_encode($age);
        $age_en = urlencode($age_en);
        $email = $form['email'];
        $s_email = $this->RC4($email);
        $s_email_en = base64_encode($s_email);
        $s_email_en = urlencode($s_email_en);
        $id = $this->RC4($glusrId);
        $id = base64_encode($id);
        $message = '
                    <html xmlns="http://www.w3.org/1999/xhtml"><head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Template One</title>
                    </head>
                    <body>
                    <table style="max-width:600px; " align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td valign="top">
                    <table style="text-align:left" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td style="width:100%; border:1px solid #dddddd;" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                            <td style=" width:100%; border-bottom:3px solid #2e3192; padding:5px 10px 5px 10px;" height="60" width="100%"><img style="vertical-align:middle; display:block" src="https://www.indiamart.com/newsletters/mailer/images/indiamart-logo-mt.jpg" alt="IndiaMART" border="0" height="40" width="201"></td>
                            </tr>
                        </tbody>
                        </table></td>
                    </tr>
                    <tr>
                        <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:9px 9px 9px 9px; " width="100%">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody><tr>
                                            <td style="width:100%; background:#2e3192; font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#fff; font-weight:bold; text-align:center; padding:5px 0 5px 0" valign="top" width="100%">Your contact details have been updated </td>
                                        </tr>
                                        </tbody></table>    </td>
                    </tr>


                    <tr>
                        <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:10px 9px 9px 9px;padding-top:1px;padding-bottom:4px; " width="100%">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tbody>
                    <tr>
                    <td style="font-family:Arial; font-size:15px;padding-top:3px;" width="100%"> <span style="color:#000000;font-weight:bold;font-size:14px;">Dear</span> <span style="font-size:14px;font-weight:bold;"> ' . $full_name . ',</span><br> <div style="font-size:13px;float:left;margin-top:4px;">As per your request, IndiaMART support team has successfully updated your contact details listed with IndiaMART.com.
                    Please find below your changed contact details:</div>
                    </td>
                    </tr>
                    </tbody></table></td></tr>

                    <tr>
                    <td style="padding:10px;font-size:13px;font-family:arial;padding-bottom:0;">Please find the updated contact details</td>
                    </tr>
                    ' . $table_html . '
                    ' . $change_mobile . '
                    <tr>
                        <td style="width:100%; padding:9px 9px 9px 9px;padding-bottom:6px;" valign="top">
                        <table style="" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody><tr>
                                <td style="padding:0 0 0 0" valign="top" width="100%"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody><tr>
                                    <td style="padding-right:10px;line-height:18px;color:#000;font-size:13px;font-family:Arial,Helvetica, sans-serif;font-weight:bold;" valign="top" width="100%">


                    <table style="max-width:270px;" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                        <td style="padding:5px 0 5px 0"><table style="border:#3237e7 1px solid; margin-bottom:3px;border-radius:3px" align="center" bgcolor="#2e3192" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                <td style="border-top:1px solid #777bff; height:40px" width="100%">
                                                    <div style="width:100%" align="center">
                                                        <a href="http://' . $server . '/index_verify.mp?em=' . $s_email_en . '&dt=' . $date_en . '&age=' . $age_en . '&av=true&mt=0&redirect=' . $redirect_link . '" style="text-decoration:none;color:#ffffff;font-size:16px;font-weight:bold;font-family:arial;min-height:30px;padding-top:11px;display:inline-block" target="_blank">' . $txt_c . '<br>
                                                            </a></div></td>
                                                </tr>
                                            </tbody>
                                        </table></td>
                                        </tr>
                                    </tbody>
                                </table>
                    </td>
                                    </tr>
                                    <tr> </tr>
                                </tbody></table></td>
                            </tr>
                        </tbody></table></td>
                        </tr>

                        <tr>
                        <td style="width:100%;" valign="top">
                        </td>
                        </tr>
                    <tr>
                        <td style="width:100%;font-family:
                    Arial, Helvetica, sans-serif; font-size:13px; color:000; line-height:18px;" valign="top"> </td>
                        </tr>
                    <tr>
                        <td style="width:100%;  border-top:1px solid #d4d4d4;padding:9px 9px 9px 9px; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:000; line-height:18px;" valign="top">For any query or clarification, please feel free to contact us and we will be glad to assist you. </td>
                        </tr>
                    <tr>
                        <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:9px 9px 9px 9px; " width="100%">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                        <td style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#000; line-height:18px; padding-bottom:9px">Warm Regards,<br>
                        Team IndiaMART</td>
                        </tr>
                        </tbody></table>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                    <td style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#fff; border:1px solid #d1d1d1; text-align:center; " valign="top" width="100%">
                        <table style="background:#eee; border-bottom:1px solid #d1d1d1;" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody><tr>
                        <td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#2e3192; text-align:left; padding:7px 5px 7px 5px; background:#eee; font-weight:bold; ">Happy to Help</td>
                    </tr>
                    </tbody></table>
                        <table style="" border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td style="width:100%;font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; color:#000; padding:5px;  text-align:left;" width="50%"><strong>Email: </strong>
                        <a href="mailto:customercare@indiamart.com" style="color:#444">customercare@indiamart.com</a></td>

                        </tr>
                        <tr>
                            <td style="width:100%;font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; color:#000; padding:5px;  text-align:left; " width="50%">
                            <strong>Toll Free:</strong>
                    <span style="color:#444">';
        if ($country_iso == "IN") {
            $message.= '<a style="color:#444;text-decoration:none;" href="tel:18002004444">1800-200-4444</a>';
        } else {
            $message.= '<a style="color:#444;text-decoration:none;" href="tel:919696969696">+(91)-9696969696</a>';
        }
        $message.= '
                    </span>  </td>
                    </tr>
                    </tbody></table>    </td>
                        </tr>
                        </tbody></table>    </td>
                    </tr>
                    </tbody></table>
                    </td>
                    </tr>
                    </tbody></table>
                    <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td style=" font-family:Arial, Helvetica, sans-serif; font-size:10px; text-align:center; color:#737373; padding:5px 0 0 0 " valign="top">IndiaMART InterMESH Ltd. Advant Navis Business Park, 7th &amp; 8th Floor, Sector - 142, Noida, UP</td>
                    </tr>
                    </tbody></table>
                    </td>
                    </tr>
                    </tbody></table>
                    </body></html>';
        $mime_header = "Content-type: text/html\n\n";
        $to = $new_mail;
        $cc = '';
        $to_name = $salute_less_name;
        $from_name = 'IndiaMART.com';
        $from = 'customercare@indiamart.com';
        $return = 'Success';
        $toArr = preg_split('/,/', $to);
        $ccArr = preg_split('/,/', $cc);
        $return = "Success";
        $usrName = "myimmails@indiamart.com";
        $pass = "motherindia12";
        if ($to && preg_match("/,/", $to)) {
            $toarr = explode(',', $to);
        } else {
            $toarr[0] = $to;
        }
        $url = 'https://api.sendgrid.com/';
        $user = $usrName;
        $pass = $pass;
        $json_string = array('to' => $toarr, 'category' => 'Contact Details Change Gladmin');
        $params = array('api_user' => $user, 'api_key' => $pass, 'x-smtpapi' => json_encode($json_string), 'to' => 'example3@sendgrid.com', 'subject' => $subject, 'html' => $message, 'from' => $from, 'fromname' => $from_name);
        $request = $url . 'api/mail.send.json';
        $session = curl_init($request);
        curl_setopt($session, CURLOPT_POST, true);
        curl_setopt($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($session);
        curl_close($session);
        return $return;
    }
    public function CheckFieldPermission($dbh = '', $moduleId, $empid) {
        $data = GL_LoginValidation::CheckFieldPermission($moduleId, $empid);
        return $data;
    }
    public function CheckFieldPermissionold($dbh = '', $moduleId, $empid) {
        $field_permissions_session = Yii::app()->session['field_permissions'];
        $data = '';
        if (!empty($field_permissions_session)) {
            foreach ($field_permissions_session as $key => $val) {
                if ($key == $moduleId) {
                    $data = $val;
                    break;
                }
            }
        }
        $field_permission = array();
        if (!empty($data)) {
            foreach ($data as $d) {
                $table = !empty($d['gl_attribute_table_name']) ? trim($d['gl_attribute_table_name']) : '';
                $field = !empty($d['gl_attribute_column_name']) ? trim($d['gl_attribute_column_name']) : '';
                $perm = !empty($d['perm']) ? trim($d['perm']) : '';
                if ($perm == 'readwrite') $perm = '';
                $field_permission[$table][$field] = $perm;
            }
        }
        unset($field_permissions_session);
        unset($data);
        return $field_permission;
    }
    public function IsClientPg($file_name, $lineno, $dbh_pg, $usrid) {
        $usrid = $usrid;
        $h = "";
        $total_count = '';
        $cust_type = '';
        $sql_handler = '';
        $data = '';
        if ($usrid) {
            $bind = array();
            $st = "SELECT COUNT(1) TOTAL
                              FROM GLUSR_USR,
                                CUSTTYPE
                              WHERE COALESCE(GLUSR_USR_CUSTTYPE_ID,9) = CUSTTYPE_ID
                              AND PAID                           =-1
                              AND GLUSR_USR_ID                   =$1
                              GROUP BY GLUSR_USR_CUSTTYPE_ID";
            $bind = array($usrid);
            $data = $this->ExecQueryPg(__FILE__, __LINE__, __CLASS__, $dbh_pg, $st, $bind);
            // $data = $list->read();
            if (is_array($data)) {
                $data = array_change_key_case($data, CASE_UPPER);
            } else {
                $data = array();
            }
            // echo "<pre>";
            // print_r($data);
            // echo "</pre>";
            // exit;
            $h['total'] = isset($data['TOTAL'])?$data['TOTAL']:0;
        }
        return ($h);
    }
    public function IsClient($file_name, $lineno, $dbh, $usrid) {
        $usrid = $usrid;
        $h = "";
        $total_count = '';
        $cust_type = '';
        $sql_handler = '';
        $data = '';
        if ($usrid) {
            $st = "SELECT COUNT(1) TOTAL,
                                GLUSR_USR_CUSTTYPE_ID
                              FROM GLUSR_USR,
                                CUSTTYPE
                              WHERE NVL(GLUSR_USR_CUSTTYPE_ID,9) = CUSTTYPE_ID
                              AND PAID                           =-1
                              AND GLUSR_USR_ID                   =:usrid
                              GROUP BY GLUSR_USR_CUSTTYPE_ID";
            $list = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $st, array(":usrid" => $usrid));
            $data = $list->read();
            $h['total'] = $data['TOTAL'];
            $h['custtype_weight'] = $data['GLUSR_USR_CUSTTYPE_ID'];
        }
        return ($h);
    }
    public function Check_pin_value($city, $zip) //pia
    {
        $dbh_meshr = $this->connect_oracledb('meshr');
        $h = "";
        $total_count = '';
        $cust_type = '';
        $sql_handler = '';
        $data = '';
        $bind = array();
        if (!empty($city) && !empty($zip)) {
            $st = "select count(1) as TOTAL from gl_pincode_area_lat_long where GL_PIN_CODE_CITY_ID=:CITY_ID and to_char(GL_PIN_CODE) = :PIN_NO";
            $bind[':CITY_ID'] = $city;
            $bind[':PIN_NO'] = $zip;
            $sql_sth = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_meshr, $st, $bind);
            $data = $sql_sth->read();
            $pin = $data['TOTAL'];
            return $pin;
        } else {
            return -1;
        }
    }
    public function ProcessTinyMCE($txt) { //userapproval
        if ($txt) {
            $txt = preg_replace("/\&amp;/", "&", $txt);
            $txt = preg_replace("/\&amp;/", "&", $txt);
            $txt = preg_replace("/\&lt;/", "<", $txt);
            $txt = preg_replace("/\&gt;/", ">", $txt);
            $txt = preg_replace("/\&nbsp;/", " ", $txt);
            $txt = preg_replace("/\s+/", " ", $txt);
            $txt = preg_replace("/<br>/", "<br \/>", $txt);
            $txt = preg_replace("/<br >/", "<br \/>", $txt);
            $txt = preg_replace("/<br\/>/", "<br \/>", $txt);
            $txt = preg_replace("/^\s|\s$/", "", $txt);
            $txt = preg_replace("/^(<br\s\/>\s*)+/", "", $txt);
            $txt = preg_replace("/(\s*<br\s\/>)+$/", "", $txt);
        }
        return $txt;
    }
    public function Get_Link_Name($file, $line, $cookie_mid, $dbh) {
        $midid = $cookie_mid;
        $mid_name = Yii::app()->session['mid_list'][$midid]['GLADM_MOD_NAME'];
        return $mid_name;
    }
    public function runSelect($file_name, $lineno, $class, $dbh, $st, $aa) { //userapproval
        // echo "<pre>";echo "<hr>"; echo $st; echo "<hr>";
        $sth_sql = '';
        $ha = '';
        $message = "\n\n\n";
        $empid = Yii::app()->session['empid'];
        if ($empid == 31688 || $empid == 747978 || $empid == 27297) {
            echo "<hr>RunSelct QUERY=>$st\n---INPUT";
            // echo "<pre>";
            print_r($aa);
            // echo "</pre>";
        }
        if ($empid == 682444 || $empid == 747978 || $empid == 24728 || $empid == 87516)
        {
          echo "<hr><pre>QUERY=>$st\n---<br>INPUT<br>";
          // echo "<pre>";
          print_r($aa);
          echo "</pre>";
        //   exit;
        }
        if(isset($dbh->{'connectionString'}) && $dbh->{'connectionString'} != "" && (preg_match("/imbuyreq/i", $dbh->{'connectionString'})) > 0 ){
            try{
                $sth_sql = $dbh->createCommand("SET statement_timeout=120000;");
                $ha = $sth_sql->query();
            } catch(Exception $e) {
            }
        }
        
        if (($dbh) && ($st)) {
            try {
                $sth_sql = $dbh->createCommand($st);
                foreach ($aa as $key => $value) {
                    $message.= "$key" . '=' . $value . "\n";
                    $sth_sql->bindValue($key, $value);
                }
                $ha = $sth_sql->query();
                return $ha;
            }
            catch(Exception $e) {
                $mailId = "gladmin-team@indiamart.com";
                $prepareError = "Can't prepare the database";
                $executeError = "Can't execute the database";
                $dbName = $dbh->{'connectionString'};
                $dbName = str_replace("oci:dbname=", "", $dbName);
                $a = explode(';', $dbName);
                if(isset($a[2])){
                    $dbName = $a[2];
                }
                if (!$sth_sql) {
                    $this->send_oracle_error($file_name, $lineno, $class, $prepareError, $e, $st . $message, $mailId, $mailId, $mailId, "Oracle Error from " . getenv('HTTP_HOST'), "Gladmin Team");
                    $this->printError($e, $dbName);
                }
                if (!$ha) {
                    $this->send_oracle_error($file_name, $lineno, $class, $executeError, $e, $st . $message, $mailId, $mailId, $mailId, "Oracle Error from " . getenv('HTTP_HOST'), "Gladmin Team");
                    $this->printError($e, $dbName);
                }
            }
        }
    }
    public function ExecQuery($file_name, $lineno, $class, $dbh, $st, $aa) {
        $sth_sql = '';
        $ha = '';
        $message = "\n\n\n";
        $empid = Yii::app()->session['empid'];
        if ($empid == 31688 || $empid == 747978 || $empid == 682444 || $empid == 87516 || $empid == 24728) {
            echo "<hr>QUERY=>$st\n---INPUT";
            // echo "<pre>";
            print_r($aa);
            // echo "</pre>";
        }
        if (($dbh) && ($st)) {
            try {
                $sth_sql = $dbh->createCommand($st);
                foreach ($aa as $key => $value) {
                    $message.= "$key" . '=' . $value . "\n";
                    $sth_sql->bindValue($key, $value);
                }
                $ha = $sth_sql->execute();
                return $ha;
            }
            catch(Exception $e) {
                if (!$sth_sql) {
                    $this->send_oracle_error($file_name, $lineno, $class, "Can't prepare the database", $e, $st . $message, "gladmin-team@indiamart.com", "gladmin-team@indiamart.com", "gladmin-team@indiamart.com", "Oracle Error from " . getenv('HTTP_HOST'), "Gladmin Team");
                    exit;
                }
                if (!$ha) {
                    $this->send_oracle_error($file_name, $lineno, $class, "Can't execute the database", $e, $st . $message, "gladmin-team@indiamart.com", "gladmin-team@indiamart.com", "gladmin-team@indiamart.com", "Oracle Error from " . getenv('HTTP_HOST'), "Gladmin Team");
                    exit;
                }
            }
        }
    }
    public function ExecQueryPg($file_name, $lineno, $class, $dbh, $query, $input, $data=array()) { // userapproval
    
    //echo "\n In ExecQueryPg";
    // $StartTime = microtime(true);
    
        $sth = '';
        $new_id = array();
        $message = "\n\n\n";
        $mess = '';
        $empid = Yii::app()->session['empid'];
        if ($empid == 31688 || $empid == 747978 || $empid == 24728) {
            echo "<hr>ExecQueryPg QUERY=>$query\n---INPUT";
            // echo "<pre>";
            print_r($input);
            // echo "</pre>";
        }
        if ($empid == 682444 || $empid == 747978 || $empid == 87516)
        {
          echo "<pre><hr>QUERY=>$query\n---INPUT";
          print_r($input);
          echo "</pre><br>-------<br>";
          // print_r($data);
          // exit;
        }
        if(strpos($query,'FCP_DATA_LOG') || strpos($query,'fcp_data_log')){
            $data = implode(",", $input);
            $mess.= "\nQUERY=>$query\n---INPUT=>".$data;
        }
        $this->error_handler();
        if ($dbh && $query) {
            try {
                $bind = (!empty($input)) ? array_map(function ($value) {
                    return $value === '' ? NULL : $value;
                }, $input) : array();
                $sth = pg_query_params($dbh, $query, $bind);
                $new_id = array();//= pg_fetch_all($sth);
                if(isset($data['multiple_rows']) && $data['multiple_rows'] == 1)
                {
                  // if ($empid == 682444)
                  // {echo 1212121;exit;}
                  $new_id = pg_fetch_all($sth);
                }
                else
                {
                  // if ($empid == 682444)
                  // {echo 343434344;exit;}
                  $new_id = pg_fetch_array($sth);
                }

                // $today_date = date("Y-m-d");
                // $EndTime = microtime(true);
                // $timediff= round($EndTime - $StartTime,3)*1000;

                //  $mess .= "Total time taken in execution $timediff";
        
                // echo "\n Out ExecQueryPg= $timediff milliseconds";
                
                // if(!empty($mess)){
                //     mail("shashank.shukla@indiamart.com,priya.goel@indiamart.com", "Testing for FCP_DATA_LOG table for $today_date", "msg=$mess");
                // }
                
                // if ($empid == 682444 || $empid == 747978)
                // {
                //     echo "<pre><hr>QUERY=>$query\n---INPUT";
                //     print_r($input);
                //     echo "</pre><br>-------<br>";
                //     // print_r($data);
                //     // exit;
                // }
        
                return $new_id;
            }
            catch(Exception $e) {
                if (!$sth) {
                    $this->send_oracle_error($file_name, $lineno, $class, "Can't prepare the database", $e, $query . $message, "gladmin-team@indiamart.com", "gladmin-team@indiamart.com", "gladmin-team@indiamart.com", "Posgres Error from " . getenv('HTTP_HOST'), "Gladmin Team");
                    exit;
                }
            }
        }
        
    }
    public function getUserDetails($file_name, $lineno, $dbh, $usr, $idname) {
        $idname = isset($idname) ? $idname : 0;
        $sql = '';
        $ha = '';
        $hash = array();
        $hash_name = array('GLUSR_USR_ID' => 'id', 'GLUSR_USR_FIRSTNAME' => 'first_name', 'GLUSR_USR_LASTNAME' => 'last_name', 'GLUSR_USR_EMAIL' => 'email', 'GLUSR_USR_COMPANYNAME' => 'company_name', 'GLUSR_USR_ADD1' => 'add1', 'GLUSR_USR_ADD2' => 'add2', 'GLUSR_USR_CITY' => 'city', 'GLUSR_USR_STATE' => 'state', 'GL_COUNTRY_NAME' => 'country', 'GL_COUNTRY_ISO' => 'country_iso', 'GLUSR_USR_ZIP' => 'zip', 'GLUSR_USR_PH_COUNTRY' => 'ph_country', 'GLUSR_USR_PH_AREA' => 'ph_area', 'GLUSR_USR_PH_NUMBER' => 'ph_no', 'GLUSR_USR_PH_MOBILE' => 'mobile', 'GLUSR_USR_FAX_COUNTRY' => 'fax_country', 'GLUSR_USR_FAX_AREA' => 'fax_area', 'GLUSR_USR_FAX_NUMBER' => 'fax_no', 'FK_GLUSR_NOOF_EMP_ID' => 'noof_emp_id', 'GL_NOOF_EMP_VAL' => 'employees', 'GLUSR_USR_YEAR_OF_ESTB' => 'established', 'FK_GLUSR_TURNOVER_ID' => 'turnover_id', 'GL_TURNOVER_VAL' => 'turnover', 'GLUSR_USR_COMPANY_DESC' => 'company_description', 'GLUSR_USR_MEMBERSINCE' => 'membersince', 'GLUSR_USR_APPROV' => 'approv', 'GLUSR_USR_DESIGNATION' => 'designation', 'GLUSR_USR_URL' => 'url', 'GL_BIZ_TYPE' => 'biz_type', 'GLUSR_USR_CFIRSTNAME' => 'cfirst_name', 'GLUSR_USR_CLASTNAME' => 'clast_name', 'GLUSR_USR_SELLINTEREST' => 'prd_sell', 'GLUSR_USR_BUYINTEREST' => 'prd_buy', 'FK_GL_CITY_ID' => 'cityid', 'FK_GL_STATE_ID' => 'stateid', 'GLUSR_USR_PH2_COUNTRY' => 'ph_country2', 'GLUSR_USR_PH2_AREA' => 'ph_area2', 'GLUSR_USR_PH2_NUMBER' => 'ph_no2', 'GLUSR_USR_EMAIL_ALT' => 'email2', 'GLUSR_USR_MODIFYSTATUS' => 'modifystatus', 'GLUSR_USR_NOSPAMCHECK' => 'nospamcheck', 'FREESHOWROOM_URL' => 'fcpurl', 'FCP_FLAG' => 'fcp_flag', 'PAIDSHOWROOM_URL' => 'paidurl', 'FK_GL_LEGAL_STATUS_ID' => 'legal_status_id', 'GL_LEGAL_STATUS_VAL' => 'legal_status_val', 'GLUSR_USR_SKYPE' => 'usr_skype_id', 'GLUSR_USR_BUSINESS_TYPE' => 'usr_business_type', 'GLUSR_USR_COMP_LOGO_IMG' => 'usr_comp_logo_img', 'GLUSR_USR_TOFREELIST' => 'usr_tofreelist', 'GLUSR_ETO_CUST_LAST_PUR_DATE' => 'eto_cust_last_pur_date', 'GLUSR_ETO_CUST_CREDITS_AV' => 'eto_cust_credits_av', 'GLUSR_ETO_CUST_CREDITS_TOTAL' => 'eto_cust_credits_total', 'FK_GLUSR_BIZ_IDS' => 'biz_ids', 'GLUSR_USR_QUALITY' => 'quality', 'GLUSR_USR_INFRASTRUCTURE' => 'usr_infrastructure', 'GLUSR_USR_TRADEMEMBERSHIP' => 'usr_trademembership', 'FK_GLUSR_USR_MARKETS_IDS' => 'market_type', 'GLUSR_USR_COUNTRYNAME' => 'country_name', 'GLUSR_USR_PH_MOBILE_ALT' => 'mobile2', 'GLUSR_USR_LISTING_STATUS' => 'listing_status', 'GLUSR_USR_PAID_SERV' => 'usr_paid_serv', 'GLUSR_USR_LOGINCOUNT' => 'logincount', 'FREESHOWROOM_ALIAS_IM' => 'freeshowroom_alias_im', 'GLUSR_USR_STATE_OTHERS' => 'glusr_usr_state_others');
        //         $hash_name = array('GLUSR_USR_ID' => 'id', 'GLUSR_USR_FIRSTNAME' => 'first_name', 'GLUSR_USR_LASTNAME' => 'last_name', 'GLUSR_USR_EMAIL' => 'email', 'GLUSR_USR_COMPANYNAME' => 'company_name', 'GLUSR_USR_ADD1' => 'add1', 'GLUSR_USR_ADD2' => 'add2', 'GLUSR_USR_CITY' => 'city', 'GLUSR_USR_STATE' => 'state', 'GL_COUNTRY_NAME' => 'country', 'GL_COUNTRY_ISO' => 'country_iso', 'GLUSR_USR_ZIP' => 'zip', 'GLUSR_USR_PH_COUNTRY' => 'ph_country', 'GLUSR_USR_PH_AREA' => 'ph_area', 'GLUSR_USR_PH_NUMBER' => 'ph_no', 'GLUSR_USR_PH_MOBILE' => 'mobile', 'GLUSR_USR_FAX_COUNTRY' => 'fax_country', 'GLUSR_USR_FAX_AREA' => 'fax_area', 'GLUSR_USR_FAX_NUMBER' => 'fax_no', 'FK_GLUSR_NOOF_EMP_ID' => 'noof_emp_id', 'GL_NOOF_EMP_VAL' => 'employees', 'GLUSR_USR_YEAR_OF_ESTB' => 'established', 'FK_GLUSR_TURNOVER_ID' => 'turnover_id', 'GL_TURNOVER_VAL' => 'turnover', 'GLUSR_USR_COMPANY_DESC' => 'company_description', 'GLUSR_USR_MEMBERSINCE' => 'membersince', 'GLUSR_USR_APPROV' => 'approv', 'GLUSR_USR_DESIGNATION' => 'designation', 'GLUSR_USR_URL' => 'url', 'GL_BIZ_TYPE' => 'biz_type', 'GLUSR_USR_CFIRSTNAME' => 'cfirst_name', 'GLUSR_USR_CLASTNAME' => 'clast_name', 'GLUSR_USR_SELLINTEREST' => 'prd_sell', 'GLUSR_USR_BUYINTEREST' => 'prd_buy', 'FK_GL_CITY_ID' => 'cityid', 'FK_GL_STATE_ID' => 'stateid', 'GLUSR_USR_PH2_COUNTRY' => 'ph_country2', 'GLUSR_USR_PH2_AREA' => 'ph_area2', 'GLUSR_USR_PH2_NUMBER' => 'ph_no2', 'GLUSR_USR_EMAIL_ALT' => 'email2', 'GLUSR_USR_MODIFYSTATUS' => 'modifystatus', 'GLUSR_USR_NOSPAMCHECK' => 'nospamcheck', 'FREESHOWROOM_URL' => 'fcpurl', 'FCP_FLAG' => 'fcp_flag', 'PAIDSHOWROOM_URL' => 'paidurl', 'FK_GL_LEGAL_STATUS_ID' => 'legal_status_id', 'GL_LEGAL_STATUS_VAL' => 'legal_status_val', 'GLUSR_USR_SKYPE' => 'usr_skype_id', 'GLUSR_USR_BUSINESS_TYPE' => 'usr_business_type', 'GLUSR_USR_COMP_LOGO_IMG' => 'usr_comp_logo_img', 'GLUSR_USR_TOFREELIST' => 'usr_tofreelist', 'GLUSR_ETO_CUST_LAST_PUR_DATE' => 'eto_cust_last_pur_date', 'GLUSR_ETO_CUST_CREDITS_AV' => 'eto_cust_credits_av', 'GLUSR_ETO_CUST_CREDITS_TOTAL' => 'eto_cust_credits_total', 'FK_GLUSR_BIZ_IDS' => 'biz_ids', 'GLUSR_USR_QUALITY' => 'quality', 'GLUSR_USR_INFRASTRUCTURE' => 'usr_infrastructure', 'GLUSR_USR_TRADEMEMBERSHIP' => 'usr_trademembership', 'GLUSR_USR_COUNTRYNAME' => 'country_name', 'GLUSR_USR_PH_MOBILE_ALT' => 'mobile2', 'GLUSR_USR_LISTING_STATUS' => 'listing_status', 'GLUSR_USR_PAID_SERV' => 'usr_paid_serv', 'GLUSR_USR_LOGINCOUNT' => 'logincount', 'FREESHOWROOM_ALIAS_IM' => 'freeshowroom_alias_im', 'GLUSR_USR_STATE_OTHERS' => 'glusr_usr_state_others');
        if ($idname == 0) {
            $sql = "Select * from GLUSR_USR,GL_TURNOVER,GL_COUNTRY, GL_NOOF_EMP, GL_BIZ,GL_LEGAL_STATUS  where
		GLUSR_USR.FK_GLUSR_TURNOVER_ID=GL_TURNOVER.GL_TURNOVER_ID(+) AND
		GLUSR_USR.FK_GL_COUNTRY_ISO=GL_COUNTRY.GL_COUNTRY_ISO AND
		GLUSR_USR.FK_GLUSR_NOOF_EMP_ID= GL_NOOF_EMP.GL_NOOF_EMP_ID(+) AND
		GLUSR_USR.FK_GLUSR_BIZ_ID = GL_BIZ.GL_BIZ_ID(+) AND
		GLUSR_USR.FK_GL_LEGAL_STATUS_ID = GL_LEGAL_STATUS.GL_LEGAL_STATUS_ID(+) AND
		GLUSR_USR_ID=:usr";
        } else {
            $sql = "Select * from GLUSR_USR,GL_TURNOVER,GL_COUNTRY, GL_NOOF_EMP, GL_BIZ,GL_LEGAL_STATUS where
		GLUSR_USR.FK_GLUSR_TURNOVER_ID=GL_TURNOVER.GL_TURNOVER_ID(+) AND
		GLUSR_USR.FK_GL_COUNTRY_ISO=GL_COUNTRY.GL_COUNTRY_ISO AND
		GLUSR_USR.FK_GLUSR_NOOF_EMP_ID= GL_NOOF_EMP.GL_NOOF_EMP_ID(+) AND
		GLUSR_USR.FK_GLUSR_BIZ_ID = GL_BIZ.GL_BIZ_ID(+) AND
		GLUSR_USR.FK_GL_LEGAL_STATUS_ID = GL_LEGAL_STATUS.GL_LEGAL_STATUS_ID(+) AND
		GLUSR_USR_EMAIL_DUP=UPPER(:usr)";
        }
        $sth = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":usr" => $usr));
        if ($sth) {
            $ha = $sth->read();
            $city_name = $state_name = '';
            if (isset($ha['FK_GL_CITY_ID'])) {
                $city_name = $this->GetCity($file_name, $lineno, $dbh, $ha['FK_GL_CITY_ID']);
            } else {
                if (isset($ha['GLUSR_USR_CITY_OTHERS'])) {
                    $city_name = $ha['GLUSR_USR_CITY_OTHERS'];
                }
            }
            if (isset($ha['FK_GL_STATE_ID'])) {
                $state_name = $this->GetState($file_name, $lineno, $dbh, $ha['FK_GL_STATE_ID']);
            } else {
                if (isset($ha['GLUSR_USR_STATE_OTHERS'])) {
                    $state_name = $ha['GLUSR_USR_STATE_OTHERS'];
                }
            }
            $ha['GLUSR_USR_CITY_OTHERS'] = $city_name;
            $ha['GLUSR_USR_STATE_OTHERS'] = $state_name;
            foreach ($hash_name as $key => $value) {
                if (!isset($ha[$key])) {
                    $hash[$value] = '';
                } else {
                    $hash[$value] = $ha[$key];
                }
            }
        }
        return $hash;
    }
    public function GetEmpNameForManager($file_name, $lineno, $dbh, $manager_id, $emp_name, $emp_type) {
        if (empty($emp_type)) {
            $emp_type = '';
        }
        $emp_name = $emp_name || '';
        $typecond = '';
        if ($emp_type != '') {
            $typecond = " AND GL_EMP_ACCESS_TYPE='$emp_type'";
        }
        $st = "SELECT * FROM GL_EMP WHERE GL_EMP_WORKING=-1 AND GL_EMP_MANAGERID = $manager_id " . $typecond . " ORDER BY GL_EMP_NAME";
        $sth = $dbh->createCommand($st);
        $sth1 = $sth->query();
        $select = '';
        if ($sth1) {
            $select = '<SELECT  NAME="emp_name">';
            $select.= '<OPTION VALUE="0">---------------------------Choose One---------------------------</OPTION>';
            while ($h = $sth1->read()) {
                $value = $h['GL_EMP_ID'];
                $name = $h['GL_EMP_NAME'];
                if ($value == $emp_name) {
                    $select.= "<OPTION VALUE='$value' SELECTED>$name($value)</OPTION>";
                } else {
                    $select.= "<OPTION VALUE='$value'>$name($value)</OPTION>";
                }
            }
            $select.= "</SELECT>";
        }
        return $select;
    }
    public function GetEmpNameForManagerPG($file_name, $lineno, $dbh, $manager_id, $emp_name, $emp_type) {
        if (empty($emp_type)) {
            $emp_type = '';
        }
        $emp_name = $emp_name || '';
        $typecond = '';
        if ($emp_type != '') {
            $typecond = " AND employee_weberp_access_type='$emp_type'";
        }
        $st = "With tab as
        (
            SELECT
                managerid
            FROM   employee
            WHERE  employeeid = $manager_id
        )
        SELECT * FROM EMPLOYEE WHERE working=-1 AND managerid IN (SELECT managerid FROM tab) " . $typecond . " ORDER BY employeename";
        $sth = $this->ExecQueryPg(__FILE__, __LINE__, __CLASS__, $dbh, $st, array(),array('multiple_rows'=>1));
        $sth1 = $sth;
        // $sth = $dbh->createCommand($st);
        // $sth1 = $sth->query();
        // echo "<pre>";
        // print_r($sth1);
        // echo "</pre>";
        // exit;
        $select = '';
        if ($sth1) {
            $select = '<SELECT  id="emp_name_drop" NAME="emp_name_drop" onchange="empdetailsforEmpR()">';
            $select.= '<OPTION VALUE="0">---------------------------Choose One---------------------------</OPTION>';
            foreach ($sth1 as $h/*$h = $sth1->read()*/) {
                $value = $h['employeeid'];
                $name = $h['employeename'];
                if ($value == $emp_name) {
                    $select.= "<OPTION VALUE='$value' SELECTED>$name($value)</OPTION>";
                } else {
                    $select.= "<OPTION VALUE='$value'>$name($value)</OPTION>";
                }
            }
            $select.= "</SELECT>";
        }
        return $select;
    }
    public function JQuery() {
        return '<script type="text/javascript" src="//gladmin.intermesh.net/assets/36364300/jquery.js"></script>';
    }
    public function GetHistoryParam($dbh, $comment, $screen, $agency) {
        $empid = Yii::app()->session['empid'];
        $empname = $this->getEmpName($dbh, $empid);
        $user = '';
        if ($empname) {
            $user = "$empname ($empid)";
        }
        $ref = $this->Geo_IP();
        $remote_host = $ref['remote'];
        $country_name = $ref['country'];
        $url = isset($_REQUEST['REQUEST_URI']) ? $_REQUEST['REQUEST_URI'] : '';
        $url = substr($url, 0, 100);
        $histref = array('updatedBy' => $user, 'updatedbyId' => $empid, 'userIp' => $remote_host, 'userIpCoun' => $country_name, 'updatedbyFlag' => '', 'histComment' => $comment, 'updatedbyScreen' => $screen, 'updatedbyUrl' => $url, 'updatedbyAgency' => $agency);
        return $histref;
    }
    public function ret_empname($dbh, $empid) {
        $retval = '';
        $retval = $this->getEmpName($dbh, $empid);
        return $retval;
    }
    public function ret_name($dbh, $act, $id) {
        $retval = '';
        $query1 = "SELECT GLMETANAME FROM GLMETA_HISTORY where ACTION_TYPE=:ACTION_TYPE and GLMETAID=:GLMETAID and rownum =1 order by CREATIONDATE DESC";
        $result1 = $dbh->createCommand($query1);
        $result1->bindValue(":ACTION_TYPE", $act);
        $result1->bindValue(":GLMETAID", $id);
        $result1 = $result1->query();
        $retval = $result1->read();
        $retval = $retval['GLMETANAME'];
        return $retval;
    }
    public function abc($userid, $regionid) {
        print $userid;
        print $regionid;
        $usertype1 = '';
        if (($userid == 'BIZ') && ($regionid == 'FOR')) {
            $usertype1 = 'DIR_BIZ_FOR';
        }
        if (($userid == 'BIZ') && ($regionid == 'IND')) {
            $usertype1 = 'DIR_BIZ_IND';
        }
        if (($userid == 'BUY') && ($regionid == 'FOR')) {
            $usertype1 = 'DIR_BUY_FOR';
        }
        if (($userid == 'BUY') && ($regionid == 'IND')) {
            $usertype1 = 'DIR_BUY_IND';
        }
        if (($userid == 'SEL') && ($regionid == 'FOR')) {
            $usertype1 = 'DIR_SEL_FOR';
        }
        if (($userid == 'SEL') && ($regionid == 'IND')) {
            $usertype1 = 'DIR_SEL_IND';
        }
        if (($userid == 'NAP') && ($regionid == 'FOR')) {
            $usertype1 = 'DIR_NAP_FOR';
        }
        if (($userid == 'NAP') && ($regionid == 'IND')) {
            $usertype1 = 'DIR_NAP_IND';
        }
        if (($userid == 'NAP') && ($regionid == 'NAP')) {
            $usertype1 = 'CTL_NAP_NAP';
        }
        if (($userid == 'BIZ') && ($regionid == 'NAP')) {
            $usertype1 = 'ETO_BIZ_NAP';
        }
        if (($userid == 'BUY') && ($regionid == 'NAP')) {
            $usertype1 = 'ETO_BUY_NAP';
        }
        if (($userid == 'NAP') && ($regionid == 'NAP')) {
            echo "in nap";
            $usertype1 = 'ETO_NAP_NAP';
        }
        if (($userid == 'SEL') && ($regionid == 'NAP')) {
            $usertype1 = 'ETO_SEL_NAP';
        }
        if (($userid == 'SEL') && ($regionid == 'IND')) {
            $usertype1 = 'INE_SEL_IND';
        }
        if (($userid == 'NAP') && ($regionid == 'NAP')) {
            $usertype1 = 'TDR_NAP_NAP';
        }
        if (($userid == 'NAP') && ($regionid == 'NAP')) {
            $usertype1 = 'IIND_NAP_NAP';
        }
        $userval = array();
        $userval[0] = 'Foreign All Users';
        $userval[1] = 'Foreign Exporters (Sellers)';
        $userval[2] = 'Foreign Importers (Buyers)';
        $userval[3] = 'Foreign Services (Business)';
        $userval[4] = 'Indian All Users';
        $userval[5] = 'Indian Exporters (Sellers)';
        $userval[6] = 'Indian Importers (Buyers)';
        $userval[7] = 'Indian Services (Business)';
        $userval[8] = 'Business Catalogs';
        $userval[9] = 'All Region All Users (All Offers)';
        $userval[10] = 'All Region Business (BIZ Meta)';
        $userval[11] = 'All Region Buyers (BUY Meta)';
        $userval[12] = 'All Region Sellers (SELL Meta)';
        $userval[13] = 'Indian Sellers';
        $userval[14] = 'All Region All Users';
        $userval[15] = 'All Region All Users';
        $usertype = array();
        $usertype[0] = 'DIR_NAP_FOR';
        $usertype[1] = 'DIR_SEL_FOR';
        $usertype[2] = 'DIR_BUY_FOR';
        $usertype[3] = 'DIR_BIZ_FOR';
        $usertype[4] = 'DIR_NAP_IND';
        $usertype[5] = 'DIR_SEL_IND';
        $usertype[6] = 'DIR_BUY_IND';
        $usertype[7] = 'DIR_BIZ_IND';
        $usertype[8] = 'CTL_NAP_NAP';
        $usertype[9] = 'ETO_NAP_NAP';
        $usertype[10] = 'ETO_BIZ_NAP';
        $usertype[11] = 'ETO_BUY_NAP';
        $usertype[12] = 'ETO_SEL_NAP';
        $usertype[13] = 'INE_SEL_IND';
        $usertype[14] = 'IIND_NAP_NAP';
        $usertype[15] = 'TDR_NAP_NAP';
        $uservalname = '';
        $s = 0;
        for ($s = 0;$s <= 15;$s++) {
            if ($usertype1 == $usertype[$s]) {
                $uservalname = $userval[$s];
            }
        }
        return $uservalname;
    }
    public function GetPrimaryBizNature($pbiz) {
        $select = '';
        $d = CommonVariable::GetBizNature_values();
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : ''; //nikhil
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        $select = "<SELECT  NAME=primary_biz id=primary_biz>";
        if ($d) {
            if ($company == 'readonly') {
                $select = "<SELECT  readonly onfocus='this.blur()' style='pointer-events: none;' STYLE=\"width:220px\" NAME=\"primary_biz\" id=\"primary_biz\" onblur='if(this.value){
                    document.ModReg.Ownership_check.disabled=false;} else { document.ModReg.Ownership_check.disabled=true;
                    }' onchange='document.getElementById('primary_biz_span').innerHTML='';'>";
            } else {
                $select = "<SELECT  STYLE=\"width:220px\" NAME=\"primary_biz\" id=\"primary_biz\">";
            }
            $select.= "<OPTION VALUE=\"\">---Choose One---</OPTION>";
            foreach ($d as $key => $value) {
                if ($pbiz == $key) {
                    $select.= "<OPTION VALUE=$key selected>$value</OPTION>";
                } else {
                    $select.= "<OPTION VALUE=$key>$value</OPTION>";

                }
            }
            $select.= "</SELECT>";
        }
        return $select;
    }

    public function GetPrimaryBizNature_FCP($pbiz)
    {
        $select = '';
        $d = CommonVariable::GetBizNature_values();
        $mid = !empty($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
        $emp_id = Yii::app()->session['empid'];
        $fld_permission = $this->CheckFieldPermission('', $mid, $emp_id);
        $company_arr = !empty($fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME']) ? $fld_permission['GLUSR_USR']['GLUSR_USR_COMPANYNAME'] : '';
        $company = isset($company_arr) && $company_arr == 'readonly' ? 'readonly' : '';
        $select = "<SELECT  NAME=primary_biz id=primary_biz class='form-control'>";
        if ($d)
        {
            if ($company == 'readonly')
            {
                $select = "<SELECT class='form-control' readonly style='pointer-events: none;' STYLE=\"width:220px; margin-left:10px; font-size:13px; font-weight:500;\" NAME=\"primary_biz\" id=\"primary_biz\">";
            }
            else
            {
                $select = '<SELECT class="form-control" STYLE="width:220px; margin-left:10px; font-size:13px; font-weight:500;" NAME="primary_biz" id="primary_biz" onblur="if(this.value){document.ModReg1.primary_biz_check.disabled=false;
                     $(\'#primary_biz_check1\').show();} else { document.ModReg1.primary_biz_check.disabled=true;};">';
            }
            $select .= "<OPTION VALUE=\"\"style='font-weight:500; font-size:13px;' >---Choose One---</OPTION>";
            foreach ($d as $key => $value)
            {
                if ($pbiz == $key)
                {
                    $select .= "<OPTION VALUE=$key selected style='font-weight:500; font-size:13px;'>$value</OPTION>";
                }
                else
                {
                    $select .= "<OPTION VALUE=$key style='font-weight:500; font-size:13px;'>$value</OPTION>";

                }
            }
            $select .= "</SELECT>";
        }
        return $select;
    }



    public function GetPrimaryBizNature_Supp($pbiz) {
        $select = '';
        $arr = array('10', '20', '30', '190', '40', '50', '200');
        $dbh = $this->connect_db();
        $st = "SELECT GL_PRIMARY_BIZ_ID,GL_PRIMARY_BIZ_TYPE,GL_PRIMARY_BIZ_SORTORD,(SELECT count(1) as count FROM GL_PRIMARY_BIZ WHERE GL_PRIMARY_BIZ_ID >=10) count FROM GL_PRIMARY_BIZ WHERE GL_PRIMARY_BIZ_ID >=10 ORDER BY GL_PRIMARY_BIZ_SORTORD";
        $sth = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $st, array());
        if ($sth) {
            $select = '
                    <SELECT  STYLE="width:260px" NAME="primary_biz" id="primary_biz" onblur="if(this.value){
                                    document.ModReg.pbiz_check.disabled=false;} else { document.ModReg.pbiz_check.disabled=true;
                                    } "  onchange="document.getElementById("pbiz_span").innerHTML="";" >';
            $select.= "<OPTION VALUE=\"\">---Choose One---</OPTION>";
            while ($h = $sth->read()) {
                $value = isset($h['GL_PRIMARY_BIZ_ID']) ? $h['GL_PRIMARY_BIZ_ID'] : '';
                $name = isset($h['GL_PRIMARY_BIZ_TYPE']) ? $h['GL_PRIMARY_BIZ_TYPE'] : '';
                if ($pbiz == $value) {
                    $select.= "<OPTION VALUE=\"$value\" SELECTED>$name</OPTION>";
                } else {
                    $select.= "<OPTION VALUE=\"$value\">$name</OPTION>";

                }
            }
            $select.= "</SELECT>";
        }
        return $select;
    }
    public function GetMainPcid($dbh, $glusridval) {
        $sql = "SELECT PC_CLNT_ID,PC_CLNT_ENABLED,PC_CLNT_TYPE FROM PC_CLIENT WHERE (FK_GLUSR_USR_ID = :GLUSRID AND PC_CLNT_ENABLED IN ('Y','F') AND MIGRATED = 1) OR (FK_GLUSR_USR_ID = :GLUSRID AND PC_CLNT_ENABLED = 'T' AND MIGRATED = 1 AND FK_CUST_TO_SERV_ID IS NOT NULL)";
        $sth = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(':GLUSRID' => $glusridval));
        $ha = $sth->read();
        $main_pcid = isset($ha['PC_CLNT_ID']) ? $ha['PC_CLNT_ID'] : 0;

        if ($main_pcid == 0) {
            echo "PCID not found!!!";
            exit;
        }
        return $main_pcid;
    }
//     public function GetSalute_new($selected) {
//         $readonly = '';
//         $selected = preg_replace('/\s+/', "", $selected);
//         $select = '<SELECT ID="salute" NAME="salute" class="input-mini">';
//         if ($selected == "Ms.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms." SELECTED>Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= 'OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mr.") {
//             $select.= '<OPTION VALUE="Mr." SELECTED>Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mrs.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs."  SELECTED>Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Dr.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr." SELECTED>Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE="" SELECTED></OPTION>';
//         }
//         $select.= '</select>';
//         return $select;
//     }
//     public function GetCSalute_new($selected) {
//         $readonly = '';
//         $selected = preg_replace('/\s+/', "", $selected);
//         $select = '<SELECT NAME="csalute" class="input-mini">';
//         if ($selected == "Ms.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms." SELECTED>Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= 'OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mr.") {
//             $select.= '<OPTION VALUE="Mr." SELECTED>Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Mrs.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs."  SELECTED>Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else if ($selected == "Dr.") {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr." SELECTED>Dr. </OPTION>';
//             $select.= '<OPTION VALUE=""></OPTION>';
//         } else {
//             $select.= '<OPTION VALUE="Mr.">Mr. </OPTION>';
//             $select.= '<OPTION VALUE="Ms.">Ms. </OPTION>';
//             $select.= '<OPTION VALUE="Mrs.">Mrs. </OPTION>';
//             $select.= '<OPTION VALUE="Dr.">Dr. </OPTION>';
//             $select.= '<OPTION VALUE="" SELECTED></OPTION>';
//         }
//         $select.= '</select>';
//         return $select;
//     }
    public function GetFcpRank($dbh, $glid) //search by user
    {
        $sql_log = "SELECT DECODE(PRIORITY_RANGE, 0.7, 'C', 0.8, 'B', 0.9, 'A',0.6, 'D','N/A') PRIORITY_RANGE from ACTIVE_FCP_DETAILS where FK_GLUSR_USR_ID=:GLID";
        $sth3 = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_log, array(':GLID' => $glid));
        $ha = $sth3->read();
        $fcp_rank = isset($ha['PRIORITY_RANGE']) ? $ha['PRIORITY_RANGE'] : 'N/A';
        return $fcp_rank;
    }
    public function RC4($str) {
        $key = '1996c39iil';
        $s = array();
        for ($i = 0;$i < 256;$i++) {
            $s[$i] = $i;
        }
        $j = 0;
        for ($i = 0;$i < 256;$i++) {
            $j = ($j + $s[$i] + ord($key[$i % strlen($key) ])) % 256;
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
        }
        $i = 0;
        $j = 0;
        $res = '';
        for ($y = 0;$y < strlen($str);$y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
            $res.= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
        }
        return $res;
    }
    //update by pia goel
    //avoid the user to do the work in moddule with different ids
    public function checkmid($mid, $filepath) {
        $host_name = $_SERVER['SERVER_NAME'];
        $AdmPcat = new AdminApprovalForm();
        if ($host_name == 'dev-gladmin.intermesh.net' or $host_name == 'stg-gladmin.intermesh.net') {
            $dbh = $this->connect_db();
        } else {
            $dbh = $this->connect_db();
        }
        if (!$dbh) {
            $AdmPcat->show_error(__FILE__, __LINE__, "Database Connection Error", "Cant connect to Database", 0, $header_sent);
            exit;
        }
        if ($filepath and $mid) {
            $st = "select gladm_mod_id from gladm_modules where UPPER(gladm_mod_flname) like UPPER('%'||:FILEPATH||'%')";
            $sth = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $st, array(':FILEPATH' => $filepath));
            $data = $sth->readAll();
            $mid_db = $data[0]['GLADM_MOD_ID'];
            if ($mid == $mid_db) {
                return 1;
            } else {
                Yii::app()->controller->redirect(array("/DashBoard/display"));
            }
        } else {
            Yii::app()->controller->redirect(array("/DashBoard/display"));
        }
        return 0;
    }
    public function purge_url($url) {
        return 1;
    }
//     public function check_existing_email($email, $glid, $dbh, $model) {
//         if (!empty($email)) {
//             if (!empty($glid) && !empty($email)) {
//                 if (strpos($email, 'gmail.com')) {
//                     $sql = "SELECT FK_GLUSR_USR_ID,REPLACE(FK_GLUSR_USR_EMAIL_DUP,'.','') WITHOUTDOT_EMAIL FROM GLUSR_USR_GMAIL_USERS WHERE REPLACE(FK_GLUSR_USR_EMAIL_DUP,'.','')=upper(replace('$email','.','')) AND FK_GLUSR_USR_ID<> $glid";
//                     $h = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
//                     $r = $h->read();
//                     $count = count($r['FK_GLUSR_USR_ID']);
//                     if ($count > 0) {
//                         return "Error";
//                     } else {
//                         return "Ok";
//                     }
//                 }
//             }
//             if (!empty($glid) && !empty($email)) {
//                 $sql = "select count(1) AS C from glusr_usr where GLUSR_USR_EMAIL_DUP=UPPER('$email') and glusr_usr_id <> $glid";
//                 $h = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
//                 $r = $h->readAll();
//                 $count = $r[0]['C'];
//                 if ($count > 0) {
//                     return "Error";
//                 } else {
//                     return "Ok";
//                 }
//             }
//         }
//     }
    public function get_All_Groups($pcid, $dbh, $model) {
        $dbh_oci = $model->connect_db_oci();
        list($total_recs, $debug_msg, $err_pos) = array('', '', '', '');
        $rec_prd = oci_new_cursor($dbh_oci);
        #call oracle procedure
        $sql = 'BEGIN PCK_PC_GROUPS.GET_ALL_GROUPS(:pcid, :cur_groups, :total_recs, :debug_msg, :err_pos); END;';
        $sth_sql = oci_parse($dbh_oci, $sql);
        oci_bind_by_name($sth_sql, ":pcid", $pcid, 100);
        oci_bind_by_name($sth_sql, ":cur_groups", $rec_prd, 0, OCI_B_CURSOR);
        oci_bind_by_name($sth_sql, ":total_recs", $total_recs, 5000);
        oci_bind_by_name($sth_sql, ":debug_msg", $debug_msg, 5000);
        oci_bind_by_name($sth_sql, ":err_pos", $err_pos, 5000);
        oci_execute($sth_sql);
        oci_execute($rec_prd);
        oci_fetch_all($rec_prd, $rec_prd, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        $hash_to_pass = array('pcid' => $pcid, 'groups' => $rec_prd, 'totalrow' => $total_recs, 'debug_msg' => $debug_msg, 'err_pos' => $err_pos);
        return $hash_to_pass;
    }
    public function get_All_PcClntID($glid, $dbh, $glmodel, $SCREEN) {
        $dbh_oci = $this->connect_db_oci();
        $emp_id = Yii::app()->session['empid'];
        $ref = $glmodel->Geo_IP();
        $empname = $glmodel->getEmpName($dbh, $emp_id);
        $updatedby = "$empname ($emp_id)";
        $empname = $empname;
        $remote_host = $ref['remote'];
        $country_name = $ref['country'];
        $empid = $emp_id;
        $user = $empname;
        $pc_template_style_id = ''; //----------------PROVIDED BY JATIN -------------------
        $sql_pcid = "SELECT PC_CLNT_ID
            FROM
            (
                SELECT PC_CLNT_ID FROM PC_CLIENT
                WHERE
                (FK_GLUSR_USR_ID = $glid AND PC_CLNT_ENABLED='F')
                OR
                (FK_GLUSR_USR_ID = $glid AND PC_CLNT_TYPE IN ('a','b','d','e','f','g','h','i') AND MIGRATED = 1 AND PC_CLNT_ENABLED='Y')
                OR
                (FK_GLUSR_USR_ID = $glid AND PC_CLNT_TYPE IN ('a','b','d','e','f','g','h','i') AND MIGRATED = 1 AND PC_CLNT_ENABLED='T'
                AND FK_CUST_TO_SERV_ID IS NULL)
                OR
                (FK_GLUSR_USR_ID = $glid AND PC_CLNT_TYPE = 'N' AND PC_CLNT_ENABLED='Y')
                OR
                (FK_GLUSR_USR_ID = $glid AND PC_CLNT_TYPE = 'W' AND PC_CLNT_ENABLED='Y')
                ORDER BY 1
            ) WHERE ROWNUM < 2";
        $sth_pcid = $glmodel->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_pcid, array());
        $ha_pcid = $sth_pcid->read();
        $pcid = !empty($ha_pcid) ? $ha_pcid['PC_CLNT_ID'] : "0";
        $SCREEN = 'IMFCP MERP FOS Form';
        if ($pcid == 0) {
            $sql = "BEGIN SP_PC_CLNT_CREATE (:PC_CLNT_HOME , :GLUSR_ID, :PC_CLNT_TYPE, :PC_CLNT_ENABLED , :PC_CLNT_TMPL_PATH, :PC_TEMPLATE_STYLE_ID, :PC_CLNT_ID, NULL, NULL ,:UPDATED_ID, :UPDATED_NAME, :UPDATED_SCREEN , :IP, :IP_COUNTRY, :HIST); END;";
            $sth_sql = oci_parse($dbh_oci, $sql);
            $x = 'x';
            $f = 'F';
            $b = '';
            oci_bind_by_name($sth_sql, ':PC_CLNT_HOME', $glid);
            oci_bind_by_name($sth_sql, ':GLUSR_ID', $glid);
            oci_bind_by_name($sth_sql, ':PC_CLNT_TYPE', $x);
            oci_bind_by_name($sth_sql, ':PC_CLNT_ENABLED', $f);
            oci_bind_by_name($sth_sql, ':PC_CLNT_TMPL_PATH', $b);
            oci_bind_by_name($sth_sql, ':PC_TEMPLATE_STYLE_ID', $pc_template_style_id);
            oci_bind_by_name($sth_sql, ':PC_CLNT_ID', $pcid, 10);
            oci_bind_by_name($sth_sql, ':UPDATED_ID', $empid);
            oci_bind_by_name($sth_sql, ':UPDATED_NAME', $user);
            oci_bind_by_name($sth_sql, ':UPDATED_SCREEN', $SCREEN);
            oci_bind_by_name($sth_sql, ':IP', $remote_host);
            oci_bind_by_name($sth_sql, ':IP_COUNTRY', $country_name);
            oci_bind_by_name($sth_sql, ':HIST', $SCREEN);
            try {
                oci_execute($sth_sql);
                return $pcid;
            }
            catch(Exception $e) {
                $glmodel->send_oracle_error(__FILE__, __LINE__, __CLASS__, "Can't execute the database", $e, $sql, "gladmin-team\@indiamart.com", "gladmin-team\@indiamart.com", "", "Oracle Error from " . getenv('HTTP_HOST'), "Gladmin Team");
                exit;
            }
        } else {
            return $pcid;
        }
    }
    public function get_pc_detail_by_id($item_id) {
        if ($item_id == 'undefined' || empty($item_id)) return 'error';
        $data = array('item_id' => $item_id, 'token' => 'imobile@15061981', 'modid' => 'GLADMIN', 'flag' => 1);
        $host_name = $_SERVER['SERVER_NAME'];
        $empid = Yii::app()->session['empid'];
        if ($host_name == 'dev-gladmin.intermesh.net') {
            if ($empid == 36387 || $empid == 53209 || $empid == 1563) {
                $url = 'http://stg-users.imutils.com/wservce/products/detail/';
            } else {
                $url = 'http://stg-mapi.indiamart.com/wservce/products/detail/';
            }
        } elseif ($host_name == 'stg-gladmin.intermesh.net') {
            if ($empid == 36387 || $empid == 53209) {
                $url = 'http://stg-mapi.indiamart.com/wservce/products/detail/';
            } else {
                $url = 'http://stg-mapi.indiamart.com/wservce/products/detail/';
            }
        } else {
            $url = 'http://mapi.indiamart.com/wservce/products/detail/';
        }
        $serv_model = new ServiceGlobalModelForm();
        $prddata = $serv_model->mapiService('PRODUCTDETAILS', $url, $data, 'No');
        return $prddata;
    }
    public function get_glusr_detail($glid, $serv_type = '') { //userapproval
        if ($serv_type == 'ALL') {
            $data = array('glusrid' => $glid, 'token' => 'imobile@15061981', 'modid' => 'GLADMIN', 'others' => 'ALL');
        } else {
            $data = array('glusrid' => $glid, 'token' => 'imobile@15061981', 'modid' => 'GLADMIN');
        }
        $host_name = $_SERVER['SERVER_NAME'];
        if ($host_name == 'dev-gladmin.intermesh.net') {
            $url = 'http://stg-mapi.indiamart.com/wservce/users/detail/';
        } elseif ($host_name == 'stg-gladmin.intermesh.net') {
            $url = 'http://stg-mapi.indiamart.com/wservce/users/detail/';
        } else {
            $url = 'http://mapi.indiamart.com/wservce/users/detail/';
        }
        // if (is_numeric($glid))
        // echo "numeric - ".$glid;
        // if (strlen($glid) < 11)
        // echo "<11 - ".$glid;
        if (is_numeric($glid) && strlen($glid) < 11) {
            $serv_model = new ServiceGlobalModelForm();
            $glusrdata_from_serv = $serv_model->mapiService('USERDETAILS', $url, $data, 'No');
        } else {
            $glusrdata_from_serv = array("Status" => "404", "Message" => "connection failure", "Error" => "Gluserid $glid is invalid");
        }
        $glusrdata = !empty($glusrdata_from_serv) ? array_change_key_case($glusrdata_from_serv, CASE_UPPER) : array();
        return $glusrdata;
    }
    public function cassndraconnection() {
        $session = '';
        $host_name = $_SERVER['SERVER_NAME'];
        if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
            $cluster = Cassandra::cluster()->withContactPoints('34.67.229.182','35.225.142.77','104.198.151.210')->withPort(9042)->withCredentials("cassandra", "cassandra")->withPersistentSessions(true)->withDefaultConsistency(Cassandra::CONSISTENCY_LOCAL_ONE)->withDatacenterAwareRoundRobinLoadBalancingPolicy("GCP2", 0, false)->build();
            $session = $cluster->connect('im_cass_mesh');
        } else {
            $cluster = Cassandra::cluster()->withContactPoints('172.31.48.77','172.31.48.158','172.31.48.78','172.31.48.159')->withPort(9042)->withCredentials("indiamart", "cas212clkstm")->withPersistentSessions(true)->withDefaultConsistency(Cassandra::CONSISTENCY_ONE)->withDatacenterAwareRoundRobinLoadBalancingPolicy("DC2", 0, false)->build();
            $session = $cluster->connect('im_cass_mesh');
        }
        return $session;
    }
    public function get_custtype_data($cust_id) {
        $dbh = $this->connect_oracledb('mesh');
        $sql = "SELECT * FROM CUSTTYPE WHERE CUSTTYPE_ID=:id";
        $sth1 = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":id" => $cust_id));
        $h = $sth1->read();
        return $h;
    }
    public function get_gluser_info($glids, $dbh, $model, $screenName) {
        $dbh = $this->connect_oracledb('meshr');
        $sql = "SELECT GLUSR_USR_ID,PAIDSHOWROOM_URL,FREESHOWROOM_URL FROM GLUSR_USR WHERE GLUSR_USR_ID in ($glids)";
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
        $url_gl_array = array();
        $url_gl = $sth->readAll();
        foreach ($url_gl as $val) {
            $url_gl_array[$val['GLUSR_USR_ID']] = $val;
        }
        return $url_gl_array;
    }
    public function checklogin($dbh, $mid, $empid) //live  on 4 apr'19 //userapproval
    {
        $data = GL_LoginValidation::CheckModulePermission($mid, $empid);
        return $data;
    }
    public function getSubmodule($mid) {
        $midarr = array();
        $midarr['46'] = array('index.php?r=admin_glusr/GlusrHistory/GlusrHistory', 'index.php?r=admin_glusr/GlusrHistory/GlusrHistoryFieldRadios', 'index.php?r=admin_glusr/MultipleScreen/Search', 'index.php?r=admin_glusr/MultipleScreen/SMSlog', 'index.php?r=admin_glusr/Registration/index', 'index.php?r=admin_glusr/MultipleScreen/viewlog', 'index.php?r=admin_glusr/Applog/Applog', 'index.php?r=admin_glusr/SpecialGlusrFunction/MobileUnverify', 'index.php?r=admin_glusr/UserApproval/Eprd', 'index.php?r=admin_glusr/MultipleScreen/moreinfo');
        $midarr['2822'] = array('index.php?r=admin_glusr/VisitingCard/UploadCard');
        $midarr['3579'] = array('index.php?r=admin_glusr/CallURL/DisplayProducts');
        $midarr['3580'] = array('index.php?r=admin_products/VideoUrlApproval/Update_data');
        $result = !empty($midarr[$mid]) ? $midarr[$mid] : array();
        return $result;
    }
    public function vc_service($glid) {
        $data = array('glusrid' => $glid, 'token' => 'imobile@15061981', 'modid' => 'GLADMIN');
        $host_name = $_SERVER['SERVER_NAME'];
        if ($host_name == 'dev-gladmin.intermesh.net') {
            $url = 'http://stg-mapi.indiamart.com/wservce/vcard/display/';
        } else if ($host_name == 'stg-gladmin.intermesh.net') {
            $url = 'http://stg-mapi.indiamart.com/wservce/vcard/display/';
        } else {
            $url = 'http://mapi.indiamart.com/wservce/vcard/display/';
        }
        $serv_model = new ServiceGlobalModelForm();
        $glusrdata_from_serv = $serv_model->mapiService('VCDISPLAY', $url, $data, 'No');
        $glusrdata = !empty($glusrdata_from_serv) ? array_change_key_case($glusrdata_from_serv, CASE_UPPER) : array();
        $empid = Yii::app()->session['empid'];
        if (!empty($_GET['ppp'])) {
            $this->pe($glusrdata_from_serv);
            $this->p($glusrdata);
        }
        $mdata = !empty($glusrdata['RESPONSE']['Data']) ? $glusrdata['RESPONSE']['Data'] : '';
        $main_data = array();
        $latest_vc_id = '';
        if (!empty($mdata)) {
            $latest_vc_id = max(array_keys($mdata));
            $mdata = array_change_key_case($mdata, CASE_UPPER);
            foreach ($mdata as $key => $d) {
                $d = array_change_key_case($d, CASE_UPPER);
                if ($d['APPROV_STATUS'] == 'P') {
                    $main_data = $d;
                }
            }
            // if (empty($main_data)) {
            //     foreach ($mdata as $key => $d) {
            //         $d = array_change_key_case($d, CASE_UPPER);
            //         if ($d['APPROV_STATUS'] == 'A') {
            //             $main_data = $d;
            //         }
            //     }
            // }
            // if (empty($main_data)) {
            //     foreach ($mdata as $key => $d) {
            //         $d = array_change_key_case($d, CASE_UPPER);
            //         if ($d['APPROV_STATUS'] == 'R') {
            //             $main_data = $d;
            //         }
            //     }
            // }
            if (empty($main_data)) {
                    $main_data = $mdata[$latest_vc_id];
                    $main_data = array_change_key_case($main_data, CASE_UPPER);
            }
        }
        return $main_data;
    }
    public function Download_processed($dir, $filename) {
        $filepath = $dir;
        header("Cache-control: private");
        header("Content-type: application/force-download");
        header("Content-transfer-encoding: binary\n");
        header("Content-disposition: attachment; filename=\"$filename\"");
        header("Content-Length: " . filesize($filepath));
        readfile($filepath);
        exit;
    }
    public function GetEmpDetail($empid) //to convert priya
    {
        $execute_query = 0;
        $emp_id = Yii::app()->session['empid'];
        $managerid = '';
        if ($emp_id == $empid) {
            $ha = array();
            $ha['empid'] = $emp_id;
            $ha['access_type'] = (string)Yii::app()->request->cookies['GL_EMP_ACCESS_TYPE'];
            $ha['empmail'] = Yii::app()->session['empemail'];
            $ha['empname'] = Yii::app()->session['empname'];
            $ha['managerid'] = $managerid = Yii::app()->session['GL_EMP_MANAGERID'];
            $ha['emptype'] = Yii::app()->session['EMP_TYPE'];
            $ha['mgr_mgr_emp_id'] = Yii::app()->session['MGR_MGR_EMP_ID'];
            if (empty($ha['managerid'])) {
                $execute_query = 1;
            } else {
                $execute_query = 0;
            }
        } else {
            $execute_query = 1;
        }
        if ($execute_query == 1) {
            $dbh_mesh = $this->connect_db();
            $user = '';
            $sql_check = "SELECT
                            EMP.GL_EMP_ACCESS_TYPE,
                            EMP.GL_EMP_EMAIL,
                            EMP.GL_EMP_NAME,
                            EMP.GL_EMP_MANAGERID,
                            DECODE(EMP.GL_EMP_ACCESS_TYPE,'R','Y','N') AS EMP_TYPE,
                            MGR.GL_EMP_MANAGERID MGR_MGR_EMP_ID
                        FROM
                        GL_EMP EMP,GL_EMP MGR
                        WHERE
                        EMP.GL_EMP_MANAGERID= MGR.GL_EMP_ID
                        AND EMP.GL_EMP_ID =:EMP_ID";
            $sth = $this->runSelect(__FILE__, __LINE__, __CLASS__, $dbh_mesh, $sql_check, array(":EMP_ID" => $empid));
            $access_type = '';
            $empmail = '';
            $empname = '';
            while ($h = $sth->read()) {
                if (isset($h['GL_EMP_ACCESS_TYPE'])) {
                    $ha['access_type'] = $h['GL_EMP_ACCESS_TYPE'];
                } else {
                    $ha['access_type'] = '';
                }
                if (isset($h['GL_EMP_EMAIL'])) {
                    $ha['empmail'] = $h['GL_EMP_EMAIL'];
                } else {
                    $ha['empmail'] = '';
                }
                if (isset($h['GL_EMP_NAME'])) {
                    $ha['empname'] = $h['GL_EMP_NAME'];
                } else {
                    $ha['empname'] = '';
                }
                if (isset($h['GL_EMP_MANAGERID'])) {
                    $ha['managerid'] = $h['GL_EMP_MANAGERID'];
                } else {
                    $ha['managerid'] = '';
                }
                if (isset($h['EMP_TYPE'])) {
                    $ha['emptype'] = $h['EMP_TYPE'];
                } else {
                    $ha['emptype'] = '';
                }
                if (isset($h['MGR_MGR_EMP_ID'])) {
                    $ha['mgr_mgr_emp_id'] = $h['MGR_MGR_EMP_ID'];
                } else {
                    $ha['mgr_mgr_emp_id'] = '';
                }
            }
            $ha['empid'] = $empid;
        }
        return $ha;
    }
    public function mailForXlsAttachment($filename_return, $excelfile_download, $email, $sub) {
        $file_size = filesize($excelfile_download);
        $handle = fopen($excelfile_download, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $name = basename($excelfile_download);
        $file_size = filesize($excelfile_download);
        $handle = fopen($excelfile_download, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $content = chunk_split(base64_encode($content));
        $uid = md5(uniqid(time()));
        $name = basename($excelfile_download);
        $header = "From: Gladmin-Team <gladmin-team@indiamart.com>\r\n";
        $header.= "Cc: gladmin-team@indiamart.com \r\n";
        $header.= "Reply-To: " . $email . "\r\n";
        $header.= "MIME-Version: 1.0\r\n";
        $header.= "Content-Type: multipart/mixed; boundary=\"" . $uid . "\"\r\n\r\n";
        $message = "This is a multi-part message in MIME format.\r\n";
        $message.= "--" . $uid . "\r\n";
        $message.= "Content-type:text/plain; charset=iso-8859-1\r\n";
        $message.= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $message.= "--" . $uid . "\r\n";
        $message.= "Content-Type: application/ms-excel; name=\"" . $filename_return . "\"\r\n";
        $message.= "Content-Transfer-Encoding: base64\r\n";
        $message.= "Content-Disposition: attachment; filename=\"" . $filename_return . "\"\r\n\r\n";
        $message.= $content . "\r\n\r\n";
        $message.= "--" . $uid . "--";
        if (mail($email, $sub, $message, $header)) {
            unlink($excelfile_download);
        } else echo "mail send ... ERROR!";
    }
    function db_connect_pgdimenq() {
        $db = 'host=52.44.107.227;port=5444;dbname=edb';
        $username = 'indiamart';
        $pwd = '';
        $conn_string = "$db $username $pwd";

        $dbconn4 = pg_connect("host=52.44.107.227 port=5444 dbname=edb user=indiamart password=''");
        return $dbconn4;
    }
    public function IS_POSTGRE() {
        $postgre = 0;
        if (isset($_SERVER['POSTGRE']) && ($_SERVER['POSTGRE'] == 1 || $_SERVER['POSTGRE'] == 2)) {
            $postgre = $_SERVER['POSTGRE'];
        }
        return $postgre;
    }
    public function error_handler() {
        set_error_handler(function ($errno, $errstr, $errfile, $errline, array $errcontext) {
            // error was suppressed with the @-operator
            if (0 === error_reporting()) {
                return false;
            }
            throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }
    public function writeFilePermission($flname) {
        $date = date("Y_m_d");
        $logfile = $flname . "_" . $date . ".log";
        if ($_SERVER["SERVER_NAME"] == 'dev-gladmin.intermesh.net') {
            $folderPath = '/home3/indiamart/public_html/dev-gladmin/protected/runtime/' . $logfile;
        } elseif ($_SERVER["SERVER_NAME"] == 'stg-gladmin.intermesh.net') {
            $folderPath = '/home3/indiamart/public_html/dev-gladmin/protected/runtime/' . $logfile;
        } else {
            $folderPath = '/home3/indiamart/public_html/gladmin/protected/runtime/' . $logfile;
        }
        if (!file_exists($folderPath)) {
            $handle = fopen($folderPath, "w") or die("can't open file");
        }
        $handle = fopen($folderPath, 'a') or die('Cannot open file:  ' . $folderPath);
        return $handle;
    }
    public function writeFailIntoFile($inputData, $outputData, $screen_msg) {
        $dateAndTime = date('Y-m-d h:i:s');
        $loggingParams = "MESSAGE: $screen_msg; DATE_AND_TIME : $dateAndTime; INPUT_PARAMS : $inputData; OUTPUT_PARAMS : $outputData;";
        $loggingParams.= "\n";
        return $loggingParams;
    }
    public function pg_b2bsearch() {
        $host_name = $_SERVER['SERVER_NAME'];
        if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
            $dbhpg_b2bsearch = pg_pconnect("host=162.217.98.43 port=5432 dbname=b2bsrch user=impglst password=impglst4iil");
        } else {
            $dbhpg_b2bsearch = pg_pconnect("host=35.225.177.70 port=5432 dbname=b2bsrch user=impglst password=impglst4iil");
        }
        return $dbhpg_b2bsearch;
    }
    public function connect_pgdb($dbname) // to be removed
    {
        $connection = '';
        if ($_SERVER['SERVER_NAME'] == 'dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] == 'stg-gladmin.intermesh.net') {
            $dbname = 'pgsql:host=63.251.238.78;port=5444;dbname=edb';
            $username = 'indiamart';
            $pass = '';
            Yii::app()->setComponent('edbmain', array('class' => 'CDbConnection', 'emulatePrepare' => true, 'connectionString' => $dbname, 'username' => $username, 'password' => $pass, 'charset' => 'UTF8'));
            try {
                $connection = Yii::app()->edbmain;
                if ($connection) {
                    return $connection;
                } else {
                    $dbname_failover = 'pgsql:host=63.251.238.79;port=5444;dbname=edb';
                    Yii::app()->setComponent('edbmain', array('class' => 'CDbConnection', 'emulatePrepare' => true, 'connectionString' => $dbname_failover, 'username' => $username, 'password' => $pass, 'charset' => 'UTF8', 'persistent' => true, 'autoConnect' => false));
                    $connection = Yii::app()->edbmain;
                    return $connection;
                }
            }
            catch(Exception $e) {
                return 0;
            }
            return $connection;
        } else {
            $dbname = 'pgsql:host=63.251.238.77;port=5444;dbname=edb';
            $username = 'indiamart';
            $pass = 'blalrtdb4iil';
            Yii::app()->setComponent('edbmain', array('class' => 'CDbConnection', 'emulatePrepare' => true, 'connectionString' => $dbname, 'username' => $username, 'password' => $pass, 'charset' => 'UTF8', 'persistent' => true, 'autoConnect' => false));
            try {
                $connection = Yii::app()->edbmain;
                if ($connection) {
                    return $connection;
                }
            }
            catch(Exception $e) {
                return 0;
            }
            return $connection;
        }
    }
    public function connect_pg() {
        $con = '';
        try {
            $host_name = $_SERVER['SERVER_NAME'];
            if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
                $con = pg_pconnect("host=162.217.96.126 port=5433 dbname=mesh_glusr user=indiamart password=indiamart");
            } else {
                $con = pg_pconnect("host=db205v.intermesh.net port=5432 dbname=mesh_glusr user=postgres password=postgres");
            }
            if ($con) {
                return $con;
            } else {
                $this->print_oracle_error(__CLASS__, __FILE__, __LINE__, "Can't connect to the Postgres", '', '');
                exit;
                return 0;
            }
        }
        catch(Exception $e) {
            $this->print_oracle_error(__CLASS__, __FILE__, __LINE__, "Cant connect to Postgres database", "Could not connect to Postgres", "");
            exit;
        }
    }
    public function check_login_session($emp_id) {
        $mid = isset($_REQUEST["mid"]) ? $_REQUEST["mid"] : '';
        return $this->checklogin('', $mid, $emp_id);
    }
    public function printTrackGACode($action) {
        $action = isset($action) && $action != '' ? $action : '';
        $pageViewURL = '';
        if (isset($_REQUEST['r']) && $_REQUEST['r'] != '') {
            $pageViewURL = '/index.php?r=' . $_REQUEST['r'] . '&mid=' . $_REQUEST['mid'];
            if (isset($_REQUEST['' . $action . '']) && $_REQUEST['' . $action . ''] != '') {
                $pageViewURL = $pageViewURL . '&' . $action . '=' . $_REQUEST['' . $action . ''];
            }
        }
        $trackCode = "
                    <!--google analytics async code start-->
                    <script type='text/javascript'>
                    var _gaq = _gaq || [];
                    _gaq.push(['_setAccount', 'UA-28761981-2']);
                    _gaq.push(['_setDomainName', '.intermesh.net']);
                    _gaq.push(['_setSiteSpeedSampleRate', 10]);
                    _gaq.push(['_trackPageview','{" . $pageViewURL . "}']);
                    (function() {
                        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
                    })();
                    </script>
                    <!--google analytics async code end-->";
        return $trackCode;
    }
    public function check_email_via_api($ss, $data = null) { //userapproval
        return "<span class=\"ok_n\">Valid</span>";
        exit;
    }
    public function mapi2Service($cbName, $serviceUrl) {
        $empid = Yii::app()->session['empid'];
        if (empty($empid)) {
            Yii::app()->session['Error'] = "Authentication Failed. Please try again.";
            echo "<script> window.top.location.href='/';  </script>";
            exit;
        }
        $check_availability = 1;
        $apcu_avl = 0;
        if (extension_loaded('APCu')) {
            $CircuitB = new CBFunctions();
            $check_availability = $CircuitB->IsSeerviceAvailable($cbName);
            $apcu_avl = 1;
        }
        if (isset($_REQUEST['debug']) && $_REQUEST['debug'] == 1) echo "\n <br>check_availability => $check_availability\n";
        if ($check_availability == 1) {
            if (isset($_REQUEST['debug']) && $_REQUEST['debug'] == 1) echo "--Service connection--";
            // Circuit Breaker is in closed State.
            $timeout = 2;
            $conect_timeout = 2;
            if ($cbName == "Bizfeed_Recom_Mcat" /*|| $cbName == 'Bizfeed_CatalogData'*/)
            {
              $timeout = 10;
              $conect_timeout = 10;
            }
            try {
                $auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
                $data = array();

                // if($cbName != 'Bizfeed_CatalogData') {
                //     $data['AK'] = $auth_key;
                // }
                $data['AK'] = $auth_key;
                $cSession = curl_init();
                $options = array(CURLOPT_URL => $serviceUrl, CURLOPT_RETURNTRANSFER => true, CURLOPT_HEADER => false, CURLOPT_CONNECTTIMEOUT => $conect_timeout, CURLOPT_TIMEOUT => $timeout, CURLOPT_POSTFIELDS => $data);
                curl_setopt_array($cSession, $options);

                // if($cbName == 'Bizfeed_CatalogData') {
                //     $username = 'admin';
                //     $password = 'admin';
                //     curl_setopt($cSession, CURLOPT_USERPWD, $username . ":" . $password);
                // }

                $response = curl_exec($cSession);
                $curl_info = curl_getinfo($cSession);
                $curl_info_json = json_encode($curl_info, true);
                $httpcode = curl_getinfo($cSession, CURLINFO_HTTP_CODE);
                //                 $curl_errno = curl_errno($cSession);
                //                 $curl_error = curl_error($cSession);
                //                 if ($httpcode != 200) {
                //                     $curlinfo = curl_getinfo($cSession);
                //                     $curlinfo['CURL_ERR_NO'] = $curl_errno;
                //                     $curlinfo['CURL_ERR_MSG'] = $curl_error;
                //                     $kibana['MAPI_CURL_INFO'] = $curlinfo;
                //                 }
                // if ($empid == 87516 && $cbName == 'Bizfeed_CatalogData') {
                //     echo "<pre>----------";
                //     $print_data = json_encode($data);
                //     echo " <hr>cbName => $cbName  <br> Service url => $serviceUrl <br> Input data => $print_data <br> empid => $empid <br> info $curl_info_json <br> connect_timeout $conect_timeout &  timeout $timeout<br> Output => $response <br> <hr>";
                //     echo $response;
                //     print_r($response);
                //     echo "+++++++++</pre>";
                // }

                $print_data = json_encode($data);
                curl_close($cSession);
                if(!empty($cbName) && $cbName == 'Bizfeed_GetActivity'){
                    $result = json_decode($response, true);
                    return $result;
                }

                // if(!empty($cbName) && $cbName == 'Bizfeed_CatalogData'){
                //     $result = json_decode($response, true);
                //     return $result;
                // }

                if ($empid == 31688 || $empid == 75299  || $empid == 747978 || $empid == 682444) {
                    echo " cbName => $cbName ";
                }
                if (isset($_REQUEST['debug']) && $_REQUEST['debug'] == 2 && ($empid == 31688 || $empid == 747978 || $empid == 682444 || $empid == 87516)) {
                    echo " <hr>cbName => $cbName  <br> Service url => $serviceUrl <br> Input data => $print_data <br> empid => $empid <br> info $curl_info_json <br> connect_timeout $conect_timeout &  timeout $timeout<br> Output => $response <hr>";
                }
                if ($apcu_avl == 1) {
                    if (preg_match('/^5/', $httpcode) || $httpcode == 0) {
                        $check_availability = $CircuitB->GenerateFailure($cbName);
                        echo "Service $cbName is Unavailable. Please try again.";
                        return 0;
                    } else {
                        $check_availability = 1; //success
                        $result = json_decode($response, true);
                        // echo "<pre>";
                        // print_r($result);
                        // exit;
                        $jsn = '';
                        switch (json_last_error()) {
                            case JSON_ERROR_DEPTH:
                                $jsn = 'Maximum stack depth exceeded';
                            break;
                            case JSON_ERROR_STATE_MISMATCH:
                                $jsn = 'Underflow or the modes mismatch';
                            break;
                            case JSON_ERROR_CTRL_CHAR:
                                $jsn = 'Unexpected control character found';
                            break;
                            case JSON_ERROR_SYNTAX:
                                $jsn = 'Syntax error, malformed JSON';
                            break;
                            case JSON_ERROR_UTF8:
                                $jsn = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                            break;
                        }
                        if ($jsn) echo "<div style='font-size:15px;color:bLUE;margin:10px;font-family:icon;font-weight:bold'>Read Failed via MAPI Service :
                        <font style = 'size:12px;color:#FF0000'>$jsn</font>
                        </div>";
                        if ($result && isset($result['CODE']) && (($result['CODE'] == '400') || ($result['CODE'] == '402'))) {
                            echo "Authentication Failed. Please try again.";
                            //                             $arr = debug_backtrace();
                            //                             $array = array();
                            //                             $array['Current_File'] = __FILE__;
                            //                             $array['Current_Line'] = __LINE__;
                            //                             $array['Current_Method'] = __METHOD__;
                            //                             foreach ($arr as $key => $val) {
                            //                                 $array['Backtrace'][$key]['File'] = $val['file'];
                            //                                 $array['Backtrace'][$key]['Line'] = $val['line'];
                            //                             }
                            //                             $json = json_encode($array);
                            Yii::app()->session['Error'] = "Authentication Failed. Please try again.";
                            echo "<script> window.top.location.href='/';  </script>";
                            exit;
                        } else {
                            return $result;
                        }
                    }
                }
                if (isset($_REQUEST['debug']) && $_REQUEST['debug'] == 1) echo '<B style=font-size:13px;color:#FF0000;padding-left:8px>Success ' . $cbName . '</B>';
            }
            catch(Exception $e) {
                if (isset($_REQUEST['debug']) && $_REQUEST['debug'] == 1) echo "message " . $e->getMessage() . "<br>";
                if ($apcu_avl == 1) {
                    $check_availability = $CircuitB->GenerateFailure($cbName);
                    echo "Service $cbName is Unavailable. Please try again.";
                    return 0;
                }
            }
        } else {
            if (isset($_REQUEST['debug']) && $_REQUEST['debug'] == 1) echo "--do not make db connection--";
            return 0;
        }
    }
    public function xlexport($datatoexport, $filepath, $filename) {
        $srting = '';
        if (!empty($datatoexport)) {
            $d1 = array();
            $datafinal = array();
            $header = array();
            $d1 = current($datatoexport);
            $header = array_change_key_case(array_keys($d1), CASE_UPPER);
            unset($d1);
            array_push($datafinal, $header);
            foreach ($datatoexport as $key => $val) {
                $d2 = array();
                foreach ($val as $key1 => $val1) {
                    $type = gettype($val1);
                    if ($type == 'string') {
                        $a = strip_tags($val1);
                        $a = str_replace('"', '', $a);
                        $a = str_replace(',', '', $a);
                        $a = str_replace(';', '', $a);
                        $a = str_replace("/\t/", '', $a);
                        $a = str_replace("/\n/", '', $a);
                        $a = preg_replace('/\s\s+/', ' ', $a);
                        $d2[] = str_replace("/\/", '', $a);
                    } else {
                        $d2[] = $val1;
                    }
                }
                array_push($datafinal, $d2);
            }
            unset($datatoexport);
            foreach ($datafinal as $key => $val) {
                foreach ($val as $key1 => $val1) {
                    $srting.= $val1 . " \t";
                }
                $srting.= " \n";
            }
            unset($datafinal);
        } else {
            $srting = "No records found. Please Try Again !!";
        }
        $FILE = fopen($filepath, "w");
        fwrite($FILE, $srting);
        fclose($FILE);
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");
        echo $srting;
        exit();
    }
}
?>
