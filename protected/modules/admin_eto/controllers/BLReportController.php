<?php
class BLReportController extends Controller
{
    public function actionReport()
    {
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
           //put your code here
           $this->render('/BLReportCard/GLUserSearchId');
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }

    // This function is called within the controller
    public function get_total($total_arr,$action_arr){

        $total = array_sum($total_arr);
        $req_total = array_sum($action_arr);
        if ($total != 0){
            return (round($req_total/$total * 100,1));
        }
        else return 0;
    }

    public function BLDisplayController($id){
        $check = $id;
        $file = "js/ml_seller.csv";
        $status = false;
        if(file_exists($file)){
            $open = fopen($file, "r");
            if($open)
            {        
                while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
                {
                    if($check ===(int) $data[0])
                    {
                        $status = true;
                        break;
                    }   
                }
                fclose($open);
                if($status)return true;
                else return false;
            }
        }
        else{
            echo "no file is there";
        }
    }
    
    public function actionReportHeader(){
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
        $user_view =1;
        if($user_view==1){    
           //put your code here
            $id = (int)$_REQUEST['id'];
            $BLDisplayStatus = $this->BLDisplayController($id);
            $conn = new GlobalmodelForm;
            $user_data = $conn->get_glusr_detail($id,"ALL");
            $obj =new BLReportModel;
            $html = $obj->get_report_header_data($id,$user_data,$BLDisplayStatus); 
            echo $html;
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }

    public function actionLocationPreference(){
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
           //put your code here
           $id = (int) $_REQUEST['glid'];
           $obj =new BLReportModel;
           $data_total_tx_90 =$obj->get_local_preference_count_total($id);
           if(empty($data_total_tx_90)){
                $data_total_tx_90['total_trans'] =0;
                $data_total_tx_90['txn_from_my'] =0;
                $data_total_tx_90['txn_from_mobilesite'] =0;
                $data_total_tx_90['txn_from_email'] =0;
                $data_total_tx_90['txn_from_mailmob'] =0;
                $data_total_tx_90['txn_from_android'] =0;
                $data_total_tx_90['txn_from_appnotif'] =0;
                $data_total_tx_90['txn_ios'] =0;
                $data_total_tx_90['txn_from_eto'] =0;
                $data_total_tx_90['txn_from_otherweb'] =0;
                $data_total_tx_90['txn_from_sms_msite'] =0;
                $data_total_tx_90['txn_from_sms_app'] =0;
           };
           $data_indian_tx_90 = $obj->get_indian_txn_count($id);
           if(empty($data_indian_tx_90)){
               $data_indian_tx_90['total_trans'] =0;
               $data_indian_tx_90['txn_from_my'] =0;
               $data_indian_tx_90['txn_from_mobilesite'] =0;
               $data_indian_tx_90['txn_from_email'] =0;
               $data_indian_tx_90['txn_from_mailmob'] =0;
               $data_indian_tx_90['txn_from_android'] =0;
               $data_indian_tx_90['txn_from_appnotif'] =0;
               $data_indian_tx_90['txn_ios'] =0;
               $data_indian_tx_90['txn_from_eto'] =0;
               $data_indian_tx_90['txn_from_otherweb'] =0;
               $data_indian_tx_90['txn_from_sms_msite'] =0;
               $data_indian_tx_90['txn_from_sms_app'] =0;
          };
           $data_foreign_tx_90 = $obj->get_foreign_txn_count($id);
           if(empty($data_foreign_tx_90)){
               $data_foreign_tx_90['total_trans'] =0;
               $data_foreign_tx_90['txn_from_my'] =0;
               $data_foreign_tx_90['txn_from_mobilesite'] =0;
               $data_foreign_tx_90['txn_from_email'] =0;
               $data_foreign_tx_90['txn_from_mailmob'] =0;
               $data_foreign_tx_90['txn_from_android'] =0;
               $data_foreign_tx_90['txn_from_appnotif'] =0;
               $data_foreign_tx_90['txn_ios'] =0;
               $data_foreign_tx_90['txn_from_eto'] =0;
               $data_foreign_tx_90['txn_from_otherweb'] =0;
               $data_foreign_tx_90['txn_from_sms_msite'] =0;
               $data_foreign_tx_90['txn_from_sms_app'] =0;
          };
           $data_local_tx_90 = $obj->get_local_txn_count($id);
           if(empty($data_local_tx_90)){
               $data_local_tx_90['total_trans'] =0;
               $data_local_tx_90['txn_from_my'] =0;
               $data_local_tx_90['txn_from_mobilesite'] =0;
               $data_local_tx_90['txn_from_email'] =0;
               $data_local_tx_90['txn_from_mailmob'] =0;
               $data_local_tx_90['txn_from_android'] =0;
               $data_local_tx_90['txn_from_appnotif'] =0;
               $data_local_tx_90['txn_ios'] =0;
               $data_local_tx_90['txn_from_eto'] =0;
               $data_local_tx_90['txn_from_otherweb'] =0;
               $data_local_tx_90['txn_from_sms_msite'] =0;
               $data_local_tx_90['txn_from_sms_app'] =0;
          };
           $data_hyperlocal_tx_90 = $obj->get_hyperlocal_txn_count($id);
           if(empty($data_hyperlocal_tx_90)){
               $data_hyperlocal_tx_90['total_trans'] =0;
               $data_hyperlocal_tx_90['txn_from_my'] =0;
               $data_hyperlocal_tx_90['txn_from_mobilesite'] =0;
               $data_hyperlocal_tx_90['txn_from_email'] =0;
               $data_hyperlocal_tx_90['txn_from_mailmob'] =0;
               $data_hyperlocal_tx_90['txn_from_android'] =0;
               $data_hyperlocal_tx_90['txn_from_appnotif'] =0;
               $data_hyperlocal_tx_90['txn_ios'] =0;
               $data_hyperlocal_tx_90['txn_from_eto'] =0;
               $data_hyperlocal_tx_90['txn_from_otherweb'] =0;
               $data_hyperlocal_tx_90['txn_from_sms_msite'] =0;
               $data_hyperlocal_tx_90['txn_from_sms_app'] =0;
          };
   
           $percentage_txns_india = $this->get_total($data_total_tx_90,$data_indian_tx_90);
           $percentage_txns_foriegn = $this->get_total($data_total_tx_90,$data_foreign_tx_90);
           $percentage_txns_local = $this->get_total($data_indian_tx_90,$data_local_tx_90);
           $percentage_txns_hyperlocal = $this->get_total($data_indian_tx_90,$data_hyperlocal_tx_90);
   
           $html = "
               <tr>
                   <th scope='row'>Platform</th>
                   <th>Total Tx (90 Days)</th>
                   <th>India Txn (90 Days)</th>
                   <th>Foriegn Txn (90 Days)</th>
                   <th>Local(<=250KM) Txn (90 Days)</th>
                   <th>Hyperlocal (<=50KM) Txn (90 Days)</th>
               </tr>
               <tr>
                   <th scope='row'>Seller IM</th>
                   <td>".(!empty($data_total_tx_90["txn_from_my"])?$data_total_tx_90["txn_from_my"]:0)."</td>
                   <td>".(!empty($data_indian_tx_90["txn_from_my"])?$data_indian_tx_90["txn_from_my"]:0)."</td>
                   <td>".(!empty($data_foreign_tx_90["txn_from_my"])?$data_foreign_tx_90["txn_from_my"]:0)."</td>
                   <td>".(!empty($data_local_tx_90["txn_from_my"])?$data_local_tx_90["txn_from_my"]:0)."</td>
                   <td>".(!empty($data_hyperlocal_tx_90["txn_from_my"])?$data_hyperlocal_tx_90["txn_from_my"]:0)."</td>
               </tr>
               <tr>
                   <th scope='row'>Android</th>
                   <td>".(!empty($data_total_tx_90["txn_from_android"])?$data_total_tx_90["txn_from_android"]:0)."</td>
                   <td>".(!empty($data_indian_tx_90["txn_from_android"])?$data_indian_tx_90["txn_from_android"]:0)."</td>
                   <td>".(!empty($data_foreign_tx_90["txn_from_android"])?$data_foreign_tx_90["txn_from_android"]:0)."</td>
                   <td>".(!empty($data_local_tx_90["txn_from_android"])?$data_local_tx_90["txn_from_android"]:0)."</td>
                   <td>".(!empty($data_hyperlocal_tx_90["txn_from_android"])?$data_hyperlocal_tx_90["txn_from_android"]:0)."</td>
                 
               </tr>
               <tr>
                   <th scope='row'>iOS</th>
                   <td>".(!empty($data_total_tx_90["txn_ios"])?$data_total_tx_90["txn_ios"]:0)."</td>
                   <td>".(!empty($data_indian_tx_90["txn_ios"])?$data_indian_tx_90["txn_ios"]:0)."</td>
                   <td>".(!empty($data_foreign_tx_90["txn_ios"])?$data_foreign_tx_90["txn_ios"]:0)."</td>
                   <td>".(!empty($data_local_tx_90["txn_ios"])?$data_local_tx_90["txn_ios"]:0)."</td>
                   <td>".(!empty($data_hyperlocal_tx_90["txn_ios"])?$data_hyperlocal_tx_90["txn_ios"]:0)."</td>
                   
               </tr>
               <tr>
                   <th scope='row'>Email</th>
                   <td>".(!empty($data_total_tx_90["txn_from_email"])?$data_total_tx_90["txn_from_email"]:0)."</td>
                   <td>".(!empty($data_indian_tx_90["txn_from_email"])?$data_indian_tx_90["txn_from_email"]:0)."</td>
                   <td>".(!empty($data_foreign_tx_90["txn_from_email"])?$data_foreign_tx_90["txn_from_email"]:0)."</td>
                   <td>".(!empty($data_local_tx_90["txn_from_email"])?$data_local_tx_90["txn_from_email"]:0)."</td>
                   <td>".(!empty($data_hyperlocal_tx_90["txn_from_email"])?$data_hyperlocal_tx_90["txn_from_email"]:0)."</td>
                  
               </tr>
               <tr>
                   <th scope='row'>IMOB</th>
                   <td>".(!empty($data_total_tx_90["txn_from_mobilesite"])?$data_total_tx_90["txn_from_mobilesite"]:0)."</td>
                   <td>".(!empty($data_indian_tx_90["txn_from_mobilesite"])?$data_indian_tx_90["txn_from_mobilesite"]:0)."</td>
                   <td>".(!empty($data_foreign_tx_90["txn_from_mobilesite"])?$data_foreign_tx_90["txn_from_mobilesite"]:0)."</td>
                   <td>".(!empty($data_local_tx_90["txn_from_mobilesite"])?$data_local_tx_90["txn_from_mobilesite"]:0)."</td>
                   <td>".(!empty($data_hyperlocal_tx_90["txn_from_mobilesite"])?$data_hyperlocal_tx_90["txn_from_mobilesite"]:0)."</td>
               </tr>
               <tr>
                   <th scope='row'>Notification</th>
                   <td>".(!empty($data_total_tx_90["txn_from_appnotif"])?$data_total_tx_90["txn_from_appnotif"]:0)."</td>
                   <td>".(!empty($data_indian_tx_90["txn_from_appnotif"])?$data_indian_tx_90["txn_from_appnotif"]:0)."</td>
                   <td>".(!empty($data_foreign_tx_90["txn_from_appnotif"])?$data_foreign_tx_90["txn_from_appnotif"]:0)."</td>
                   <td>".(!empty($data_local_tx_90["txn_from_appnotif"])?$data_local_tx_90["txn_from_appnotif"]:0)."</td>
                   <td>".(!empty($data_hyperlocal_tx_90["txn_from_appnotif"])?$data_hyperlocal_tx_90["txn_from_appnotif"]:0)."</td>
               </tr>
               <tr>
                   <th scope='row'>Txn %</th>
                   <td>100%</td>
                   <td>$percentage_txns_india %</td>
                   <td>$percentage_txns_foriegn %</td>
                   <td>$percentage_txns_local %</td>
                   <td>$percentage_txns_hyperlocal %</td>
               </tr>
           ";
           echo $html;
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }

    public function actionPreferredLocation(){
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
           //put your code here
            $id = (int)$_REQUEST['glid'];
            $obj = new BLReportModel;
            // $city_name = $obj->get_preferred_location_city_name($id);
            // $country_name = $obj->get_preferred_location_country_name($id);
            
            $district_count = $obj->get_district_count($id);
            if(empty($district_count))$district_count['count']=0;
            
            $state_count = $obj->get_state_count($id);
            if(empty($state_count))$state_count['count']=0;
            
            $city_count = $obj->get_preferred_location_city_count($id);
            if(empty($city_count))$city_count['count']=0;

            $country_count = $obj->get_preferred_location_country_count($id);
            if(empty($country_count))$country_count['count']=0;
            
            if($district_count['count'] == 0)$district_add_state = "Disabled";
            else $district_add_state = ""; 
            if($state_count['count'] == 0)$state_add_state = "Disabled";
            else $state_add_state = ""; 
            if($city_count['count'] == 0)$city_add_state = "Disabled";
            else $city_add_state = ""; 
            if($country_count['count'] == 0)$country_add_state = "Disabled";
            else $country_add_state = ""; 
            
            $html = "
            <tr>
                <th scope='row'>City</th>
                <th scope='row'>District</th>
                <th scope='row'>State</th>
                <th scope='row'>Country</th>
            </tr>
            <tr>
                <td style='cursor:pointer;' id='prefLocCityCount'>
                    <div>".(!empty($city_count['count'])?$city_count['count']:0)."<button id='prefCityNames' class='add_clickable $city_add_state' $city_add_state>(+)</button></div>
                    <div id='prefNamesListCity'></div>
                </td>
                <td>
                    <div>".(!empty($district_count['count'])?$district_count['count']:0)."<button id='prefDistNames' class='add_clickable $district_add_state' $district_add_state>(+)</button></div>
                    <div id='prefNamesListDistrict'></div>
                </td>
                <td>
                    <div>".(!empty($state_count['count'])?$state_count['count']:0)."<button id='prefStateNames' class='add_clickable $state_add_state' $state_add_state>(+)</button></div>
                    <div id='prefNamesListState'></div>
                </td>
                <td style='cursor:pointer;' id='prefLocCountryCount'>
                    <div>".(!empty($country_count['count'])?$country_count['count']:0)."<button id='prefCountryNames' class='add_clickable $country_add_state' $country_add_state>(+)</button></div>
                    <div id='prefNamesListCountry'></div>
                </td>
            </tr>
        ";
            echo $html;
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
        

    }

    public function actionPreferredStateNames(){
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
           //put your code here
            $id =(int) $_REQUEST['glid'];
            $obj = new BLReportModel;
            $state_data = $obj->get_preferred_state_names($id);
            if(!empty($state_data))
            {
                echo "<div><p style='margin:5px 0 0 0;font-weight:bold;'>Details</p></div>";
                echo "<table>
                <tr>
                    <th>State name</th>
                    <th>2 Months Txn</th>
                    <th>6 Months Txn</th>
                </tr>";
                foreach ($state_data as $data) {
                        echo "
                        <tr>
                        <td>".(!empty($data['state_name'])?$data['state_name']:'')."</td>
                        <td>".(!empty($data['two_months_txn'])?$data['two_months_txn']:0)."</td>
                        <td>".(!empty($data['six_months_txn'])?$data['six_months_txn']:0)."</td>
                        </tr>";
                    }
                echo "</table>";
            
                echo "<button id='removeEle'>Hide..</button>";
            }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }

    public function actionPreferredCityNames(){
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
           //put your code here
            $id = (int)$_REQUEST['glid'];
            $obj = new BLReportModel;
            $city_data = $obj->get_preferred_city_names($id);
            if(!empty($city_data))
            {
                echo "<div><p style='margin:5px 0 0 0;font-weight:bold;'>Details</p></div>";
                echo "<table>
                <tr>
                    <th>City Name</th>
                    <th>2 Months Txn </th>
                    <th>6 Months Txn </th>
                    <th>Wrong Location NI ( 2 Months) </th>
                </tr>";
                foreach ($city_data as $data) {
                        echo "
                        <tr>
                        <td>".(!empty($data['city_name'])?$data['city_name']:'')."</td>
                        <td>".(!empty($data['two_months_txn'])?$data['two_months_txn']:0)."</td>
                        <td>".(!empty($data['six_months_txn'])?$data['six_months_txn']:0)."</td>
                        <td>".(!empty($data['two_months_rej'])?$data['two_months_rej']:0)."</td>
                        </tr>";
                    }
                echo "</table>";
            
                echo "<button id='removeEle'>Hide..</button>";
            }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
        
    }
    public function actionPreferredDistrictNames(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           $district_data = $obj->get_preferred_district_names($id);
           if(!empty($district_data))
           {
               echo "<div><p style='margin:5px 0 0 0;font-weight:bold;'>Details</p></div>";
               echo "<table>
               <tr>
                   <th>District Name </th>
                   <th>2 Months Txn</th>
                   <th>6 Months Txn</th>
               </tr>";
               foreach ($district_data as $data) {
                       echo "
                       <tr>
                       <td>".(!empty($data['district_name'])?$data['district_name']:'')."</td>
                       <td>".(!empty($data['two_months_txn'])?$data['two_months_txn']:0)."</td>
                       <td>".(!empty($data['six_months_txn'])?$data['six_months_txn']:0)."</td>
                       </tr>";
                   }
               echo "</table>";
           
               echo "<button id='removeEle'>Hide..</button>";
           }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }

    public function actionPreferredCountryNames(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           $country_data = $obj->get_preferred_country_names($id);
           if(!empty($country_data))
           {
               echo "<div><p style='margin:5px 0 0 0;font-weight:bold;'>Details</p></div>";
               echo "<table>
               <tr>
                   <th>Country Name </th>
                   <th>2 Months Txn</th>
                   <th>3 Months Txn</th>
                   <th>6 Months Txn </th>
                   <th>Wrong Location NI ( 90 Days) </th>
               </tr>";
               foreach ($country_data as $data) {
                       echo "
                       <tr>
                       <td>".(!empty($data['country_name'])?$data['country_name']:'')."</td>
                       <td>".(!empty($data['two_months_txn'])?$data['two_months_txn']:0)."</td>
                       <td>".(!empty($data['three_months_txn'])?$data['three_months_txn']:0)."</td>
                       <td>".(!empty($data['six_months_txn'])?$data['six_months_txn']:0)."</td>
                       <td>".(!empty($data['three_months_ni'])?$data['three_months_ni']:0)."</td>
                       </tr>";
                   }
               echo "</table>";
           
               echo "<button id='removeEle'>Hide..</button>";
           }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }


    public function actionNegativeLocations(){
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
           //put your code here
           $id = (int)$_REQUEST['glid'];
           $obj = new BLReportModel;
          
           $city_count = $obj->get_city_count($id);
           if(empty($city_count))$city_count['count']=0;
           $country_count = $obj->get_country_count($id);
           if(empty($country_count))$country_count['count']=0;
   
           if ($city_count['count'] == 0)$city_add_state = "Disabled";
           else $city_add_state = ""; 
      
           if ($country_count['count'] == 0)$country_add_state = "Disabled";
           else $country_add_state = "";    
           $html = "
           <tr>
               <th scope='row'>City</th>
               <th scope='row'>Country</th>
           </tr>
           <tr>
               <td scope='row'>
                   <div>".(!empty($city_count["count"])?$city_count["count"]:0)." <button id='negCityNames' class='add_clickable $city_add_state' $city_add_state >(+)</button></div>
                   <div id='negativeNamesCity'></div>
               </td>
               <td scope='row'>
                   <div>".(!empty($country_count["count"])?$country_count["count"]:0)." <button id='negCountryNames' class='add_clickable $country_add_state'$country_add_state>(+)</button> </div>
                   <div id='negativeNamesCountry'></div>
               </td>
           </tr>
           
          
           ";
   
           echo $html;
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
    }

    public function actionNegativeCityNames(){
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
           //put your code here
            $id = (int)$_REQUEST['glid'];
            $obj = new BLReportModel;
            $city_name = $obj->get_city_name($id);
            echo "<div><p style='margin:5px 0 0 0;font-weight:bold;'>City Names:</p></div>";
            foreach ($city_name as $city) {
                echo "<div><p style='margin:5px 0 0 0;'>$city</p></div>";
            }
            echo "<button id='removeEle'>Hide..</button>";
            }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
        
    }

    public function actionNegativeCountryNames(){
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
           //put your code here
           $id = (int)$_REQUEST['glid'];
           $obj = new BLReportModel;
           $country_name = $obj->get_country_name($id);
           echo "<div><p style='margin:5px 0 0 0;font-weight:bold;'>country Names:</p></div>";
           foreach ($country_name as $country) {
               echo "<div><p style='margin:5px 0 0 0;'>$country</p></div>";
           }
           echo "<button id='removeEle'>Hide..</button>";
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }

    public function actionPreferredTOV(){
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
           //put your code here
           $id = (int)$_REQUEST['glid'];
           $obj =new BLReportModel;
           $data = $obj->get_TOV_slab($id);
           $slabVal = $this->slabAnalyser($data);
           $total = array_sum($slabVal);
           $txn_count = $obj->total_txn_in_days($id);
           if(empty($txn_count))$txn_count['total_trans']=0;
   
           $txns_count = $obj->total_txns_in_days($id);
           if(empty($txns_count))$txns_count['tot_data']=0;
           
           if( $txn_count['total_trans'] > 0){
               $trans_percent = round(($total / $txn_count['total_trans']) * 100,1); 
           }else $trans_percent=0;
           
           $html = "
           <tr>
               <th scope='row'>Total Txn in 90 Days</th>
               <th scope='row'>Total TOV Txn in 90 Days</th>
               <th scope='row'>%</th>
           </tr>
           <tr>
               <td scope='row'>$txn_count[total_trans]</td>
               <td scope='row'>$total</td>
               <td scope='row'>$trans_percent</td>
           </tr>
           ";
           echo $html;
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }

    }
    

    public function slabAnalyser($arr){
        $result = [];
        $result['Upto 1000'] = 0;
        $result['1000-3000'] = 0;
        $result['3000-10000'] = 0;
        $result['10000-20000'] = 0;
        $result['20000-50000'] = 0;
        $result['50000-1L'] = 0;
        $result['1L-2L'] = 0;
        $result['2L-5L'] = 0;
        $result['5L-10L'] = 0;
        $result['10L-20L'] = 0;
        $result['20L-50L'] = 0;
        $result['50L-1 Cr'] = 0;
        $result['Above 1 Cr'] = 0;
        if(!empty($arr)){
            foreach($arr as $val){
                $value = (int) $val['eto_ofr_approx_order_val_mapp'];
                $val['tot_data'] = !empty($val['tot_data'])?$val['tot_data']:0;
                if($value == 100){
                    $result['Upto 1000'] = $val['tot_data'];
                }elseif($value == 200){
                    $result['1000-3000'] = $val['tot_data'];
                }elseif($value == 300){
                    $result['3000-10000'] = $val['tot_data'];
                }elseif($value == 400){
                    $result['10000-20000'] = $val['tot_data'];
                }elseif($value == 500){
                    $result['20000-50000'] = $val['tot_data'];
                }elseif($value == 600){
                    $result['50000-1L'] = $val['tot_data'];    
                }elseif($value == 700){
                    $result['1L-2L'] = $val['tot_data'];
                }elseif($value == 800){
                    $result['2L-5L'] = $val['tot_data'];
                }elseif($value == 900){
                    $result['5L-10L'] = $val['tot_data'];
                }elseif($value >= 1000){
                    $result['10L-20L'] = $val['tot_data'];
                }elseif($value >= 1100){
                    $result['20L-50L'] = $val['tot_data'];
                }elseif($value == 1200){
                    $result['50L-1 Cr'] = $val['tot_data'];
                }elseif($value == 1300){
                    $result['Above 1 Cr'] =$val['tot_data'];
                }
            }return $result;
        }else return $result;
    }


    public function CumulativePercentage($tot,$cumulate){
        
        if($tot != 0){
            
            $percent = ($cumulate/$tot) * 100;      
            return round($percent,1);
        }else{
            return 0;
        }
    }
    
    public function actionTOVSlabs(){
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
           //put your code here
           $id = (int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           $data = $obj->get_TOV_slab($id);
           $slabVal = $this->slabAnalyser($data);
           $total = array_sum($slabVal);
           $cumulative = 0;
           $html = "
               <tr>
                   <th scope='row'>TOV Slabs</th>
                   <th scope='row'>Txn with TOV </br> (90 Days)</th>
                   <th scope='row'>Cumulative Txn</th>
                   <th scope='row'>Cumulative %</th>
                   <th scope='row'>Reverse Cumulative</th>
               </tr>
               <tr>
                   <td>Upto 1000</td>
                   <td>".$slabVal['Upto 1000']."</td>
                   <td>".($cumulative+=$slabVal['Upto 1000'])."</td>
                   <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>1000-3000</td>
                   <td>".$slabVal['1000-3000']."</td>
                   <td>".($cumulative+=$slabVal['1000-3000'])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>3000-10000</td>
                   <td>".$slabVal['3000-10000']."</td>
                   <td>".($cumulative+=$slabVal['3000-10000'])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>10000-20000</td>
                   <td>".$slabVal['10000-20000']."</td>
                   <td>".($cumulative+=$slabVal['10000-20000'])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>20000-50000</td>
                   <td>".$slabVal["20000-50000"]."</td>
                   <td>".($cumulative+=$slabVal["20000-50000"])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>50000-1L</td>
                   <td>".$slabVal["50000-1L"]."</td>
                   <td>".($cumulative+=$slabVal["50000-1L"])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>1L-2L</td>
                   <td>".$slabVal["1L-2L"]."</td>
                   <td>".($cumulative+=$slabVal["1L-2L"])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>2L-5L</td>
                   <td>".$slabVal["2L-5L"]."</td>
                   <td>".($cumulative+=$slabVal["2L-5L"])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>5L-10L</td>
                   <td>".
                   $slabVal["5L-10L"]
                   ."</td>
                   <td>".($cumulative+=$slabVal["5L-10L"])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>10L-20L</td>
                   <td>".$slabVal['10L-20L']."</td>
                   <td>".($cumulative+=$slabVal['10L-20L'])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>20L-50L</td>
                   <td>".
                   $slabVal['20L-50L']
                   ."</td>
                   <td>".($cumulative+=$slabVal['20L-50L'])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>50L-1 Cr</td>
                   <td>".$slabVal["50L-1 Cr"]."</td>
                   <td>".($cumulative+=$slabVal["50L-1 Cr"])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <td>Above 1 Cr</td>
                   <td>".
                   $slabVal["Above 1 Cr"]
                   ."</td>
                   <td>".($cumulative+=$slabVal["Above 1 Cr"])."</td>
                    <td>".$this->CumulativePercentage($total,$cumulative)."%</td>
                   <td>".(round(100-$this->CumulativePercentage($total,$cumulative),1))."%</td>
               </tr>
               <tr>
                   <th>Total</th>
                   <td>$total<td>
               </tr>
              
           ";
           echo $html;
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
      

    }

    public function actionPreferredCategories(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
            $obj = new BLReportModel;

            $preferred_cat = $obj->get_preferred_cat_count($id);
            
            $mcat_wise_txn = $obj->get_mcat_wise_txn($id);
            // var_dump($mcat_wise_txn);
            // die;
            $mcat_wise_wp_ni = $obj->get_mcat_wise_wp_ni($id);
         
            if($preferred_cat){
                usort($preferred_cat,function($x,$y){
                    if($x['eto_trd_alert_rank']>$y['eto_trd_alert_rank']) return true;
                    elseif ($x['eto_trd_alert_rank']<$y['eto_trd_alert_rank']) return false;
                    else return 0;
                });
                $preferred_cat_a = "Disabled";
                $preferred_cat_b = "Disabled";
                $preferred_cat_c = "Disabled";
                $preferred_cat_d = "Disabled";
                $r1=$r2=$r3=$r4='';
                if(isset($preferred_cat[0]['count']) && isset($preferred_cat[0]['eto_trd_alert_rank'])){
                    $r1=$preferred_cat[0]['eto_trd_alert_rank'];
                if($preferred_cat[0]['count'] == 0) $preferred_cat_a = "Disabled";
                else $preferred_cat_a = ""; 
                }if(isset($preferred_cat[1]['count']) && isset($preferred_cat[1]['eto_trd_alert_rank'])){
                    $r2=$preferred_cat[1]['eto_trd_alert_rank'];
                if($preferred_cat[1]['count'] == 0) $preferred_cat_b = "Disabled";
                else $preferred_cat_b= ""; 
                }if(isset($preferred_cat[2]['count']) && isset($preferred_cat[2]['eto_trd_alert_rank'])){
                    $r3=$preferred_cat[2]['eto_trd_alert_rank'];
                if($preferred_cat[2]['count'] == 0) $preferred_cat_c = "Disabled";
                else $preferred_cat_c = ""; 
                }if(isset($preferred_cat[3]['count']) && isset($preferred_cat[3]['eto_trd_alert_rank'])){
                    $r4=$preferred_cat[3]['eto_trd_alert_rank'];
                if($preferred_cat[3]['count'] == 0) $preferred_cat_d = "Disabled";
                else $preferred_cat_d = "";
                }

                echo " <table><tr>";
                foreach ($preferred_cat as $key => $value) {
                    echo "<td scope='row'>".(!empty($value['eto_trd_alert_rank'])?$value['eto_trd_alert_rank']:0)."</td>";
                }
                echo "</tr>";
                echo "<tr>";
                   echo" <td style='cursor:pointer;' id='prefcatCount1'>
                    <div>".(!empty($preferred_cat[0]['count'])?$preferred_cat[0]['count']:0)."<button id='prefcatCountbutton".$r1."' class='add_clickable $preferred_cat_a' $preferred_cat_a>(+)</button></div>
                    <div id='prefcatList".$r1."'></div>
                </td>
                <td style='cursor:pointer;' id='prefcatCount2'>
                    <div>".(!empty($preferred_cat[1]['count'])?$preferred_cat[1]['count']:0)."<button id='prefcatCountbutton".$r2."'  class='add_clickable $preferred_cat_b' $preferred_cat_b>(+)</button></div>
                    <div id='prefcatList".$r2."'></div>
                </td>
                <td style='cursor:pointer;' id='prefcatCount3'>
                    <div>".(!empty($preferred_cat[2]['count'])?$preferred_cat[2]['count']:0)."<button id='prefcatCountbutton".$r3."'  class='add_clickable $preferred_cat_c' $preferred_cat_c>(+)</button></div>
                    <div id='prefcatList".$r3."'></div>
                </td>
                <td style='cursor:pointer;' id='prefcatCount4'>
                    <div>".(!empty($preferred_cat[3]['count'])?$preferred_cat[3]['count']:0)."<button id='prefcatCountbutton".$r4."'  class='add_clickable $preferred_cat_d' $preferred_cat_d>(+)</button></div>
                    <div id='prefcatList".$r4."'></div>
                </td>
                ";
                  //  echo "<td scope='row'>".(!empty($value['count'])?$value['count']:0)."</td>";
                echo "</tr></table>";
            }
      
              
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
        
    }

  

    public function actionBusinessType(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           
   
           $txn_retail_leads = $obj->txns_on_retail_leads($id);
           $txn_non_retail_leads = $obj->txns_on_non_retail_leads($id);
           $txn_hyper_retail_leads = $obj->txns_on_hyper_local_retail_leads($id);
           $txn_hyper_retail_leads_50_km = $obj->txns_on_hyper_local_retail_leads_50_km($id);
           $retailer_type = strtolower($obj->get_retailer_type($id));
   
           $retail_ni = $obj->retail_ni($id);
           if(!$retail_ni['count'])$retail_ni['count']=0;
   
           $non_retail_ni = $obj->non_retail_ni($id);    
           if(!$non_retail_ni['count'])$non_retail_ni['count'] = 0;
   
           $hyper_retail_ni = $obj->hyper_retail_ni($id);
           if(!$hyper_retail_ni['count'])$hyper_retail_ni['count'] = 0;
   
           if($txn_retail_leads['count'] != 0 && $txn_retail_leads['count']){
               $percentage_retail_bl = ($retail_ni['count'] /$txn_retail_leads['count'])*100; 
           }else {
               $percentage_retail_bl = 0;
               $txn_retail_leads['count'] = 0;
           }
   
           if($txn_hyper_retail_leads['count'] != 0 && $txn_hyper_retail_leads['count']){
               $percentage_hyper_retail_bl = ($hyper_retail_ni['count'] /$txn_hyper_retail_leads['count'])*100; 
           }else {
               $percentage_hyper_retail_bl = 0;
               $txn_hyper_retail_leads['count'] = 0;
           }
   
           if($txn_non_retail_leads['count'] != 0 && $txn_non_retail_leads['count']){
               $percentage_non_retail_bl = ($non_retail_ni['count'] /$txn_retail_leads['count'])*100; 
           }else {
               $percentage_non_retail_bl = 0;
               $txn_non_retail_leads['count'] = 0;
           }
   
           if($retailer_type == "deemed retailer"){
               echo "
               <tr style='background-color:#d6dde2;'><td></td><th>Deemed Retailer</th><td></td></tr>
               <tr>
                   <th scope='row'>Txn on Retail Leads (180 Days)</th>
                   <th scope='row'>Retail NI (180 Days)</th>
                   <th scope='row'>Retail NI / Retail BL Txn</th>
               </tr>
               <tr>
                   <td scope='row'>$txn_retail_leads[count]</td>
                   <td scope='row'>$retail_ni[count]</td>
                   <td scope='row'>$percentage_retail_bl %</td>
               </tr>";
           }elseif($retailer_type == "non-retailer"){
               echo"
               <tr style='background-color:#d6dde2;'><td></td><th>Non retailer</th><td></td></tr>
               <tr>
                   <th scope='row'>Txn on Retail Leads (180 Days)</th>
                   <th scope='row'>Retail NI (180 Days)</th>
                   <th scope='row'>Retail NI / Retail BL Txn</th>
               </tr>
               <tr>
                   <td scope='row'>$txn_non_retail_leads[count]</td>
                   <td scope='row'>$non_retail_ni[count]</td>
                   <td scope='row'>$percentage_non_retail_bl %</td>
               </tr>
               ";
               
           }elseif($retailer_type == "hyperlocal retailer"){
               echo "
               <tr style='background-color:#d6dde2;'><th colspan='5'>Hyper Local Retailer</th></tr>
               <tr>
                   <td scope='row'>Retail Txn (180 Days)</td>
                   <td scope='row'>Retail Txn (180 Days) within 50 KM</td>
                   <td scope='row'>Retail NI (180 days)</td>
                   <td scope='row'>Retail NI / Retail BL Txn</td>
               </tr>
               <tr>
                   <td scope='row'>$txn_hyper_retail_leads[count]</td>
                   <td scope='row'>".(!empty($txn_hyper_retail_leads_50_km["total_trans"])?$txn_hyper_retail_leads_50_km["total_trans"]:0)."</td>                
                   <td scope='row'>$hyper_retail_ni[count]</td>
                   <td scope='row'>$percentage_hyper_retail_bl %</td>
               </tr>
               ";
           }else{
               echo "";
           }   
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }

    public function actionMcatwiseCallBack(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           
           $data=$obj->McatwisecallbackData($id);
           if(!empty($data)){
            echo "<table>
           <tr>
               <th scope='row'>Mcat Name</th>
               <th scope='row'>60 Days</th>
               <th scope='row'>90 Days</th>
               <th scope='row'>180 Days</th>
               <th scope='row'>1 Year</th>
               <th scope='row'>60 Days (P)</th>
               <th scope='row'>120 Days (P)</th>
           </tr>";
           for($i=0;$i<sizeof($data);$i++){
            echo"<tr>
               <td scope='row'>".(!empty($data[$i]['mcat_name'])?$data[$i]['mcat_name']:'')."</td>
               <td scope='row'>".(!empty($data[$i]['count_60'])?$data[$i]['count_60']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['count_90'])?$data[$i]['count_90']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['count_180'])?$data[$i]['count_180']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['count_1yr'])?$data[$i]['count_1yr']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['counts_120_p'])?$data[$i]['counts_120_p']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['counts_60_p'])?$data[$i]['counts_60_p']:0)."</td>
           </tr>";
           }
           echo "</table>";
        }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }


    public function actionMcatwiseReplies(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           
           $data=$obj->McatwiseRepliesData($id);
           if(!empty($data)){
            echo "<table>
           <tr>
               <th scope='row'>Mcat Name</th>
               <th scope='row'>60 Days-3 reply</th>
               <th scope='row'>90 Days-3 replies</th>
               <th scope='row'>180 Days-3 reply</th>
               <th scope='row'>1 Year-2 reply</th>
               <th scope='row'>60 Days (P)</th>
               <th scope='row'>120 Days (P)</th>
           </tr>";
           for($i=0;$i<sizeof($data);$i++){
           echo"
           <tr>
           <td scope='row'>".(!empty($data[$i]['mcat_name'])?$data[$i]['mcat_name']:'')."</td>
           <td scope='row'>".(!empty($data[$i]['count_60_3_reply'])?$data[$i]['count_60_3_reply']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['count_90_3_reply'])?$data[$i]['count_90_3_reply']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['count_180_3_reply'])?$data[$i]['count_180_3_reply']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['count_1yr_2_reply'])?$data[$i]['count_1yr_2_reply']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['counts_120_p'])?$data[$i]['counts_120_p']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['counts_60_p'])?$data[$i]['counts_60_p']:0)."</td>
           </tr>";
           }
           echo "</table>";
        }
    }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }
    public function actionPreferredCat_A(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           
           $data=$obj->PreferredCat_AData($id);
           if(!empty($data)){
           echo "<table>
           <tr>
               <th scope='row'>Mcat Name</th>
               <th scope='row'>2 Months Txn</th>
               <th scope='row'>4 Months Txn</th>
               <th scope='row'>6 Months Txn</th>
               <th scope='row'>1 Year  Txn</th>
               <th scope='row'>Wrong Product NI 2 Months (Prime)</th>
               <th scope='row'>Relevant QRF( 2 Months) </th>
               <th scope='row'> Wrong Product QRF(2 Months) </th>
           </tr>";
           for($i=0;$i<sizeof($data);$i++){
           echo"
           <tr>
           <td scope='row'>".(!empty($data[$i]['glcat_mcat_name'])?$data[$i]['glcat_mcat_name']:'')."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_txn'])?$data[$i]['two_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['four_months_txn'])?$data[$i]['four_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['six_months_txn'])?$data[$i]['six_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['one_year_txn'])?$data[$i]['one_year_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_ni'])?$data[$i]['two_months_ni']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_positive_qrf'])?$data[$i]['two_months_positive_qrf']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_negative_qrf'])?$data[$i]['two_months_negative_qrf']:0)."</td>
           </tr>";
           }
           echo "</table>";
           
           echo "<button id='removeEle'>Hide..</button>";
        }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }

    public function actionPreferredCat_B(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           
           $data=$obj->PreferredCat_BData($id);
           if(!empty($data)){
           echo "<table>
           <tr>
               <th scope='row'>Mcat Name</th>
               <th scope='row'>2 Months Txn</th>
               <th scope='row'>4 Months Txn</th>
               <th scope='row'>6 Months Txn</th>
               <th scope='row'>1 Year  Txn</th>
               <th scope='row'>Wrong Product NI 2 Months (Prime)</th>
               <th scope='row'>Relevant QRF( 2 Months) </th>
               <th scope='row'> Wrong Product QRF(2 Months) </th>
           </tr>";
           for($i=0;$i<sizeof($data);$i++){
           echo"<tr>
           <td scope='row'>".(!empty($data[$i]['glcat_mcat_name'])?$data[$i]['glcat_mcat_name']:'')."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_txn'])?$data[$i]['two_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['four_months_txn'])?$data[$i]['four_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['six_months_txn'])?$data[$i]['six_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['one_year_txn'])?$data[$i]['one_year_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_ni'])?$data[$i]['two_months_ni']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_positive_qrf'])?$data[$i]['two_months_positive_qrf']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_negative_qrf'])?$data[$i]['two_months_negative_qrf']:0)."</td>
       </tr>";
           }
           echo "</table>";
           
           echo "<button id='removeEle'>Hide..</button>";
        }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }
    public function actionPreferredCat_C(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           
           $data=$obj->PreferredCat_CData($id);
           if(!empty($data)){
           echo "<table>
           <tr>
               <th scope='row'>Mcat Name</th>
               <th scope='row'>2 Months Txn</th>
               <th scope='row'>4 Months Txn</th>
               <th scope='row'>6 Months Txn</th>
               <th scope='row'>1 Year  Txn</th>
               <th scope='row'>Wrong Product NI 2 Months (Prime)</th>
               <th scope='row'>Relevant QRF( 2 Months) </th>
               <th scope='row'> Wrong Product QRF(2 Months) </th>
           </tr>";
           for($i=0;$i<sizeof($data);$i++){
           echo"<tr>
           <td scope='row'>".(!empty($data[$i]['glcat_mcat_name'])?$data[$i]['glcat_mcat_name']:'')."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_txn'])?$data[$i]['two_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['four_months_txn'])?$data[$i]['four_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['six_months_txn'])?$data[$i]['six_months_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['one_year_txn'])?$data[$i]['one_year_txn']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_ni'])?$data[$i]['two_months_ni']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_positive_qrf'])?$data[$i]['two_months_positive_qrf']:0)."</td>
           <td scope='row'>".(!empty($data[$i]['two_months_negative_qrf'])?$data[$i]['two_months_negative_qrf']:0)."</td>
       </tr>";
           }
           echo "</table>";
           
           echo "<button id='removeEle'>Hide..</button>";
        }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        }
       
    }
    public function actionPreferredCat_D(){
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
           //put your code here
           $id =(int) $_REQUEST['glid'];
           $obj = new BLReportModel;
           
           $data=$obj->PreferredCat_DData($id);
           if(!empty($data)){
           echo "<table>
           <tr>
               <th scope='row'>Mcat Name</th>
               <th scope='row'>2 Months Txn</th>
               <th scope='row'>4 Months Txn</th>
               <th scope='row'>6 Months Txn</th>
               <th scope='row'>1 Year  Txn</th>
               <th scope='row'>Wrong Product NI 2 Months (Prime)</th>
               <th scope='row'>Relevant QRF( 2 Months) </th>
               <th scope='row'> Wrong Product QRF(2 Months) </th>
           </tr>";
           for($i=0;$i<sizeof($data);$i++){
           echo"
           <tr>
               <td scope='row'>".(!empty($data[$i]['glcat_mcat_name'])?$data[$i]['glcat_mcat_name']:'')."</td>
               <td scope='row'>".(!empty($data[$i]['two_months_txn'])?$data[$i]['two_months_txn']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['four_months_txn'])?$data[$i]['four_months_txn']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['six_months_txn'])?$data[$i]['six_months_txn']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['one_year_txn'])?$data[$i]['one_year_txn']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['two_months_ni'])?$data[$i]['two_months_ni']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['two_months_positive_qrf'])?$data[$i]['two_months_positive_qrf']:0)."</td>
               <td scope='row'>".(!empty($data[$i]['two_months_negative_qrf'])?$data[$i]['two_months_negative_qrf']:0)."</td>
           </tr>";
           }
           echo "</table>";
           
           echo "<button id='removeEle'>Hide..</button>";
        }
        }
        else{
            echo "<b style='font-size:15px;color:red;padding-left:20px'>You don't have permission to view<b>";exit;
        } 
    }
}