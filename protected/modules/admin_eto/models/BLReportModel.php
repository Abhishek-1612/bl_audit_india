<?php

class BLReportModel extends CFormModel
{
    public function get_report_header_data($id,$user_cred,$BLDisplayStatus)
    {
        $slab_range = $this->get_tov_range($id);

        if(!empty($BLDisplayStatus)){
            if($BLDisplayStatus){
                $BLDisplayStatus = "ML Based"; 
            }
            else{
                $BLDisplayStatus = "Grid Based";
            }
        }
        else{
            $BLDisplayStatus = "Grid Based";
        }
        if(empty($user_cred)){
            $user_cred['GLUSR_USR_COMPANYNAME'] = "";
            $user_cred['GLUSR_USR_CUSTTYPE_NAME'] = "";
            $user_cred['GLUSR_USR_STATE'] = "";    
        }
        if(!array_key_exists("GLUSR_USR_COMPANYNAME",$user_cred))$user_cred["GLUSR_USR_COMPANYNAME"]="";
        if(!array_key_exists("GLUSR_USR_CUSTTYPE_NAME",$user_cred))$user_cred["GLUSR_USR_CUSTTYPE_NAME"]="";
        if(!array_key_exists("GLUSR_USR_STATE",$user_cred))$user_cred["GLUSR_USR_STATE"]="";


        $retailer_type = $this->get_retailer_type($id);
        // print_r($retailer_type);

        $location_preference = $this->get_location_preference($id);
        
        $html = "<table style='border-collapse: collapse;' width='100%' cellspacing='0' cellpadding='4' bordercolor='#bedaff' border='1' class='table'>
        <thead>
        </thead>
        <tbody>
            <tr>
                <th style='background-color:#d6dde2;width:200px;' scope='row'>Company Name:</th>
                <td>$user_cred[GLUSR_USR_COMPANYNAME]</td>
                <th style='background-color:#d6dde2;width:200px;' scope='row'>Custtype Name:</th>
                <td>$user_cred[GLUSR_USR_CUSTTYPE_NAME]</td>
                <th style='background-color:#d6dde2;width:200px;' scope='row'>State:</th>
                <td>$user_cred[GLUSR_USR_STATE]</td>
            </tr>
            <tr>
                <th style='background-color:#d6dde2;width:200px;' scope='row'>BL Display:</th>
                <td>$BLDisplayStatus</td>
            </tr>
        </tbody>
        </table>
        <table class='table'>
            <thead>
                <tr>
                <th colspan='6' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Location Preference: $location_preference<input type='button' name='show-btn' id='locPrefBtn' value='Show more..'></div></th>
                </tr>
            </thead>
            <tbody id='prefBody'>
            </tbody>
        </table>
        <table class='table'>
            <thead>
                <tr>
                <th colspan='2' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Negative Locations <input type='button' name='show-btn' id='negLocBtn' value='Show more..'></div></th>
                </tr>
            </thead>
            <tbody id='negLocBody'>
            </tbody>
        </table>
        <table class='table'>
            <thead>
                <tr>
                <th colspan='4' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Preferred Location  <input type='button' name='show-btn' id='prefLocBtn' value='Show more..'></div></th>
                </tr>
            </thead>

            <tbody id='prefLocBody'>
            </tbody>
        </table>

        <table class='table'>
            <thead>
                <tr>
                <th colspan='4' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Preferred TOV: $slab_range <input type='button' name='show-btn' id='prefTOVBtn' value='Show more..'></div></th>    
                </tr>
            </thead>
            
            <tbody id='prefTOVBody'>
            </tbody>
        </table>

        <table class='table'>
            <thead>
                <tr>
                <th colspan='5' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>TOV Slab <input type='button' name='show-btn' id='TOVSlabsBtn' value='Show more..'></div></th>
                </tr>   
            </thead>
            
            <tbody id='TOVSlabsBody'>
            </tbody>
        </table>
        <table class='table'>
            <thead>
                <tr>
                <th colspan='5' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Preferred Categories <input type='button' name='show-btn' id='prefCatBtn' value='Show more..'></div></th>
                </tr>
            </thead>
            
            <tbody id='prefCatBody'>
            </tbody>
        </table>
        <table class='table'>
            <thead>
                <tr>
                <th colspan='5' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Business Type: $retailer_type <input type='button' name='show-btn' id='busTypeBtn' value='Show more..'></div></th>
                </tr>
            </thead>
            
            <tbody id='busTypeBody'>
            </tbody>
        </table>
        <table class='table'>
        <thead>
            <tr>
            <th colspan='5' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Mcat wise Call Backs <input type='button' name='show-btn' id='mcatwiseBtn' value='Show more..'></div></th>
            </tr>
        </thead>
        
        <tbody id='mcatwiseBody'>
        </tbody>
    </table>
    <table class='table'>
        <thead>
            <tr>
            <th colspan='5' style='width:200px;' scope='col'><div style='display:flex;justify-content:space-between;padding:0 40px 0 40px;align-items:center;'>Mcat wise Replies <input type='button' name='show-btn' id='mcatwiserepliesBtn' value='Show more..'></div></th>
            </tr>
        </thead>
        
        <tbody id='mcatwiserepliesBody'>
        </tbody>
    </table>
    
    " ;
        return $html;
    }

    public function get_tov_range($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql="SELECT EXISTS (
            SELECT FROM information_schema.tables 
            WHERE table_name   = 'bl_display_order_filter_data'
            );"; 

        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
            
        $check_table = $sth->read();
        
        if($check_table['exists']){
            $sql = "SELECT eto_ofr_approx_order_val_mapp from bl_display_order_filter_data where fk_glusr_usr_id =$id";
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());

            $flag = $sth->read();
            $flag = $flag['eto_ofr_approx_order_val_mapp'];
            if($flag){
                $value =(int) $flag;
                
                if($value == 100){
                    return 'Upto 1000';
                }elseif($value == 200){
                    return '1000-3000';
                }elseif($value == 300){
                    return '3000-10000';
                }elseif($value == 400){
                    return '10000-20000';
                }elseif($value == 500){
                    return '20000-50000';
                }elseif($value == 600){
                    return'50000-1L';    
                }elseif($value == 700){
                    return'1L-2L';
                }elseif($value == 800){
                    return'2L-5L';
                }elseif($value == 900){
                    return'5L-10L';
                }elseif($value >= 1000){
                    return'10L-20L';
                }elseif($value >= 1100){
                    return'20L-50L';
                }elseif($value == 1200){
                    return'50L-1 Cr';
                }elseif($value == 1300){
                    return'Above 1 Cr';
                }
            }
            else return null;

        }
        
    }
    
    public function get_location_preference($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        $sql = "SELECT glusr_usr_deduced_loc_pref1 from glusr_usr_loc_pref where fk_glusr_usr_id=$id";

        $data = [];
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
      
        while($rec = $sth->read()) {
            $data = $rec['glusr_usr_deduced_loc_pref1'];
        }
        $preference = [
            1 => 'Global',
            2 => 'India',
            3 => 'Foreign',
            4 => 'Local',
            9 => 'Hyperlocal'
        ];
        
        if(!$data){
            echo null;
        }
       else return $preference[$data];
    }
    public function get_local_preference_count_total($id){
       
        
        $obj = new Globalconnection();
        $arr = array();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        $sql = "SELECT
        
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' THEN 1 ELSE NULL END ) TXN_FROM_MY,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MOB') THEN 1 ELSE NULL END ) TXN_FROM_MOBILESITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAIL') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD') THEN 1 ELSE NULL END ) TXN_FROM_EMAIL,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAILMOB') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD') THEN 1 ELSE NULL END) TXN_FROM_MAILMOB,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ANDROID' THEN 1 ELSE NULL END ) TXN_FROM_ANDROID,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('Notif') THEN 1 ELSE NULL END ) TXN_FROM_APPNOTIF,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID IN ('IOS') THEN 1 ELSE NULL END ) TXN_IOS,
        
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ETO' THEN 1 ELSE NULL END) TXN_FROM_ETO,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('WEB') AND ETO_LEAD_FK_GL_MODULE_ID NOT IN ('MY','ETO','HELLOTD') THEN 1 ELSE NULL END) TXN_FROM_OTHERWEB,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID = 'IMOB' THEN 1 ELSE NULL end ) TXN_FROM_SMS_MSITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID <> 'IMOB' THEN 1 ELSE NULL end) TXN_FROM_SMS_APP
        FROM
        (
        SELECT ETO_LEAD_PUR_MODE , ETO_LEAD_FK_GL_MODULE_ID , FK_ETO_OFR_ID
        From
           iil_LEAD_PUR_HIST
        WHERE
           date(eto_pur_date) >= (date(now()) - 90)
           AND FK_ETO_OFR_ID > 0
         
           AND ETO_LEAD_PUR_TYPE = 'B'
           and fk_glusr_usr_id=$id
        UNION ALL
        SELECT ETO_LEAD_PUR_MODE , ETO_LEAD_FK_GL_MODULE_ID , FK_ETO_OFR_ID
        From
           ETO_LEAD_PUR_HIST
        WHERE
           
           date(eto_pur_date) >= (date(now()) - 90)
           AND FK_ETO_OFR_ID > 0
         
           AND ETO_LEAD_PUR_TYPE = 'B'
           and fk_glusr_usr_id=$id
        )A
        ";
        $data = [];
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql,array());
        while($rec = $sth->read()) {
            $data = $rec;
        }
        if(!$data){
            $data =[
          
            'txn_from_my' => "",
            'txn_from_mobilesite' => "",
            'txn_from_email' => "",
            'txn_from_mailmob' => "",
            'txn_from_android' => "",
            'txn_from_appnotif' => "",
            'txn_ios' => "",
            'txn_from_eto' => "",
            'txn_from_otherweb' => "",
            'txn_from_sms_msite' => "",
            'txn_from_sms_app' => "" ];
            return $data;
        }
        return $data;
    }

    function get_indian_txn_count($id){
        // $obj = $this->db_setup(); 
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
              
        $sql = "SELECT
       
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' THEN 1 ELSE NULL END ) TXN_FROM_MY,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MOB') THEN 1 ELSE NULL END ) TXN_FROM_MOBILESITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAIL') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD') THEN 1 ELSE NULL END ) TXN_FROM_EMAIL,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAILMOB') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD') THEN 1 ELSE NULL END) TXN_FROM_MAILMOB,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ANDROID' THEN 1 ELSE NULL END ) TXN_FROM_ANDROID,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('Notif') THEN 1 ELSE NULL END ) TXN_FROM_APPNOTIF,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID IN ('IOS') THEN 1 ELSE NULL END ) TXN_IOS,
        
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ETO' THEN 1 ELSE NULL END) TXN_FROM_ETO,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('WEB') AND ETO_LEAD_FK_GL_MODULE_ID NOT IN ('MY','ETO','HELLOTD') THEN 1 ELSE NULL END) TXN_FROM_OTHERWEB,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID = 'IMOB' THEN 1 ELSE NULL end ) TXN_FROM_SMS_MSITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID <> 'IMOB' THEN 1 ELSE NULL end) TXN_FROM_SMS_APP
        FROM
        (
        SELECT ETO_LEAD_PUR_MODE , ETO_LEAD_FK_GL_MODULE_ID , FK_ETO_OFR_ID
        From
           ETO_LEAD_PUR_HIST
        WHERE
           date(eto_pur_date) >= (date(now()) - 90)
           AND FK_ETO_OFR_ID > 0
           AND ETO_LEAD_PUR_TYPE = 'B'
           and fk_glusr_usr_id=$id
        )A
        ";
        $data = [];
        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
        while ($rec = $sth->read()) {
            $data = $rec;
        }
        if(!$data){
            $data =[
            
            'txn_from_my' => "",
            'txn_from_mobilesite' => "",
            'txn_from_email' => "",
            'txn_from_mailmob' => "",
            'txn_from_android' => "",
            'txn_from_appnotif' => "",
            'txn_ios' => "",
            'txn_from_eto' => "",
            'txn_from_otherweb' => "",
            'txn_from_sms_msite' => "",
            'txn_from_sms_app' => "" ];
            return $data;
        }
        return $data;
    }

    function get_foreign_txn_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
              
        $sql ="SELECT
        
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' THEN 1 ELSE NULL END ) TXN_FROM_MY,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MOB') THEN 1 ELSE NULL END ) TXN_FROM_MOBILESITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAIL') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD') THEN 1 ELSE NULL END ) TXN_FROM_EMAIL,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAILMOB') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD') THEN 1 ELSE NULL END) TXN_FROM_MAILMOB,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ANDROID' THEN 1 ELSE NULL END ) TXN_FROM_ANDROID,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('Notif') THEN 1 ELSE NULL END ) TXN_FROM_APPNOTIF,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID IN ('IOS') THEN 1 ELSE NULL END ) TXN_IOS,
        
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ETO' THEN 1 ELSE NULL END) TXN_FROM_ETO,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('WEB') AND ETO_LEAD_FK_GL_MODULE_ID NOT IN ('MY','ETO','HELLOTD') THEN 1 ELSE NULL END) TXN_FROM_OTHERWEB,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID = 'IMOB' THEN 1 ELSE NULL end ) TXN_FROM_SMS_MSITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID <> 'IMOB' THEN 1 ELSE NULL end) TXN_FROM_SMS_APP
        FROM
        (
        SELECT ETO_LEAD_PUR_MODE , ETO_LEAD_FK_GL_MODULE_ID , FK_ETO_OFR_ID
        From
           iil_LEAD_PUR_HIST
        WHERE

           date(eto_pur_date) >= (date(now()) - 90)
           AND FK_ETO_OFR_ID > 0
           AND ETO_LEAD_PUR_TYPE = 'B'
           and fk_glusr_usr_id=$id
        )A
        ";

        $data = [];
        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
        
        while ($rec=$sth->read()) {
            $data =$rec;
        }
        if(!$data){
            $data =[
         
            'txn_from_my' => "",
            'txn_from_mobilesite' => "",
            'txn_from_email' => "",
            'txn_from_mailmob' => "",
            'txn_from_android' => "",
            'txn_from_appnotif' => "",
            'txn_ios' => "",
            'txn_from_eto' => "",
            'txn_from_otherweb' => "",
            'txn_from_sms_msite' => "",
            'txn_from_sms_app' => "" ];
            return $data;
        }

        return $data;
    }

    function get_local_txn_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
              
        $sql = "SELECT
         
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' and dis <=250 THEN 1 ELSE NULL END ) TXN_FROM_MY,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MOB')  and dis <=250 THEN 1 ELSE NULL END ) TXN_FROM_MOBILESITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAIL') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD')  and dis <=250 THEN 1 ELSE NULL END ) TXN_FROM_EMAIL,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAILMOB') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD')  and dis <=250 THEN 1 ELSE NULL END) TXN_FROM_MAILMOB,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ANDROID'  and dis <=250 THEN 1 ELSE NULL END ) TXN_FROM_ANDROID,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('Notif')  and dis <=250 THEN 1 ELSE NULL END ) TXN_FROM_APPNOTIF,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID IN ('IOS')  and dis <=250 THEN 1 ELSE NULL END ) TXN_IOS,
        
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ETO'  and dis <=250 THEN 1 ELSE NULL END) TXN_FROM_ETO,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('WEB') AND ETO_LEAD_FK_GL_MODULE_ID NOT IN ('MY','ETO','HELLOTD')  and dis <=250 THEN 1 ELSE NULL END) TXN_FROM_OTHERWEB,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID = 'IMOB'  and dis <=250 THEN 1 ELSE NULL end ) TXN_FROM_SMS_MSITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID <> 'IMOB'  and dis <=250 THEN 1 ELSE NULL end) TXN_FROM_SMS_APP
                FROM
                (
                select  
                b.eto_lead_pur_id,
                b.fk_eto_ofr_id,
                b.ETO_PUR_DATE,
                b.FK_GLUSR_USR_ID seller_id,
                SUP.fk_gl_city_id sup_city,
                ETO_OFR_GLUSR_USR_ID buyer_id,
                sup.glusr_usr_city,
                buyer.glusr_usr_city,	
                buyer.fk_gl_city_id,
                a.distance_city dis,
                ETO_LEAD_PUR_MODE, 
                ETO_LEAD_FK_GL_MODULE_ID 
                from
                ETO_LEAD_PUR_HIST b, GLUSR_USR SUP, GLUSR_USR BUYER, gl_city_distance_mvy a
                WHERE
                eto_lead_pur_type='B'
                and date(eto_pur_date) >= (date(now()) - 90)
                AND b.FK_ETO_OFR_ID > 0
               
                AND SUP.GLUSR_USR_ID  = b.FK_GLUSR_USR_ID
                and b.FK_GLUSR_USR_ID = $id
                AND BUYER.GLUSR_USR_ID  = b.ETO_OFR_GLUSR_USR_ID
                and SUP.fk_gl_city_id = a.to_city_id
                and buyer.fk_gl_city_id = a.from_city_id
                    union all
                    select  
                b.eto_lead_pur_id,
                b.fk_eto_ofr_id,
                b.ETO_PUR_DATE,
                b.FK_GLUSR_USR_ID seller_id,
                SUP.fk_gl_city_id sup_city,
                ETO_OFR_GLUSR_USR_ID buyer_id,
                sup.glusr_usr_city,
                buyer.glusr_usr_city,	
                buyer.fk_gl_city_id,
                a.distance_city dis,
                ETO_LEAD_PUR_MODE, 
                ETO_LEAD_FK_GL_MODULE_ID
                from
                iil_LEAD_PUR_HIST b, GLUSR_USR SUP, GLUSR_USR BUYER, gl_city_distance_mvy a
                WHERE
                eto_lead_pur_type='B'
                and date(eto_pur_date) >= (date(now()) - 90)
                AND b.FK_ETO_OFR_ID > 0
               
                AND SUP.GLUSR_USR_ID  = b.FK_GLUSR_USR_ID
                and b.FK_GLUSR_USR_ID = $id
                AND BUYER.GLUSR_USR_ID  = b.ETO_OFR_GLUSR_USR_ID
                and SUP.fk_gl_city_id = a.from_city_id
                and buyer.fk_gl_city_id = a.to_city_id
                )A
        ";

        $data = [];
        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }

        if(!$data){
            $data =[
            
            'txn_from_my' => "",
            'txn_from_mobilesite' => "",
            'txn_from_email' => "",
            'txn_from_mailmob' => "",
            'txn_from_android' => "",
            'txn_from_appnotif' => "",
            'txn_ios' => "",
            'txn_from_eto' => "",
            'txn_from_otherweb' => "",
            'txn_from_sms_msite' => "",
            'txn_from_sms_app' => "" ];
            return $data;
        }

        return $data;
    }

    function get_hyperlocal_txn_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    
        $sql = "SELECT
         
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'MY' and dis <=50 THEN 1 ELSE NULL END ) TXN_FROM_MY,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MOB')  and dis <=50 THEN 1 ELSE NULL END ) TXN_FROM_MOBILESITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAIL') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD')  and dis <=50 THEN 1 ELSE NULL END ) TXN_FROM_EMAIL,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('MAILMOB') AND ETO_LEAD_FK_GL_MODULE_ID IN ('AUTOINST','EMORNING','WITHINST','LEVENING','MORNING','INSTANT','HELLOTD')  and dis <=50 THEN 1 ELSE NULL END) TXN_FROM_MAILMOB,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ANDROID'  and dis <=50 THEN 1 ELSE NULL END ) TXN_FROM_ANDROID,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('Notif')  and dis <=50 THEN 1 ELSE NULL END ) TXN_FROM_APPNOTIF,
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID IN ('IOS')  and dis <=50 THEN 1 ELSE NULL END ) TXN_IOS,
        
                COUNT( CASE WHEN ETO_LEAD_FK_GL_MODULE_ID = 'ETO'  and dis <=50 THEN 1 ELSE NULL END) TXN_FROM_ETO,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('WEB') AND ETO_LEAD_FK_GL_MODULE_ID NOT IN ('MY','ETO','HELLOTD')  and dis <=50 THEN 1 ELSE NULL END) TXN_FROM_OTHERWEB,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID = 'IMOB'  and dis <=50 THEN 1 ELSE NULL end ) TXN_FROM_SMS_MSITE,
                COUNT( CASE WHEN ETO_LEAD_PUR_MODE IN ('SMS') AND ETO_LEAD_FK_GL_MODULE_ID <> 'IMOB'  and dis <=50 THEN 1 ELSE NULL end) TXN_FROM_SMS_APP
        FROM
                (
                select  
                b.eto_lead_pur_id,
                b.fk_eto_ofr_id,
                b.ETO_PUR_DATE,
                b.FK_GLUSR_USR_ID seller_id,
                SUP.fk_gl_city_id sup_city,
                ETO_OFR_GLUSR_USR_ID buyer_id,
                sup.glusr_usr_city,
                buyer.glusr_usr_city,	
                buyer.fk_gl_city_id,
                a.distance_city dis,
                ETO_LEAD_PUR_MODE, 
                ETO_LEAD_FK_GL_MODULE_ID 
                from
                ETO_LEAD_PUR_HIST b, GLUSR_USR SUP, GLUSR_USR BUYER, gl_city_distance_mvy a
                WHERE
                eto_lead_pur_type='B'
                and date(eto_pur_date) >= (date(now()) - 90)
                AND b.FK_ETO_OFR_ID > 0
              
                AND SUP.GLUSR_USR_ID  = b.FK_GLUSR_USR_ID
                and b.FK_GLUSR_USR_ID = $id
                AND BUYER.GLUSR_USR_ID  = b.ETO_OFR_GLUSR_USR_ID
                and SUP.fk_gl_city_id = a.to_city_id
                and buyer.fk_gl_city_id = a.from_city_id
                    union all
                    select  
                b.eto_lead_pur_id,
                b.fk_eto_ofr_id,
                b.ETO_PUR_DATE,
                b.FK_GLUSR_USR_ID seller_id,
                SUP.fk_gl_city_id sup_city,
                ETO_OFR_GLUSR_USR_ID buyer_id,
                sup.glusr_usr_city,
                buyer.glusr_usr_city,	
                buyer.fk_gl_city_id,
                a.distance_city dis,
                ETO_LEAD_PUR_MODE, 
                ETO_LEAD_FK_GL_MODULE_ID
                from
                iil_LEAD_PUR_HIST b, GLUSR_USR SUP, GLUSR_USR BUYER, gl_city_distance_mvy a
                WHERE
                eto_lead_pur_type='B'
                and date(eto_pur_date) >= (date(now()) - 90)
                AND b.FK_ETO_OFR_ID > 0
              
                AND SUP.GLUSR_USR_ID  = b.FK_GLUSR_USR_ID
                and b.FK_GLUSR_USR_ID = $id
                AND BUYER.GLUSR_USR_ID  = b.ETO_OFR_GLUSR_USR_ID
                and SUP.fk_gl_city_id = a.from_city_id
                and buyer.fk_gl_city_id = a.to_city_id
                )A
        "; 

        $data = [];
        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        };
        if(!$data){
            $data =[
            
            'txn_from_my' => "",
            'txn_from_mobilesite' => "",
            'txn_from_email' => "",
            'txn_from_mailmob' => "",
            'txn_from_android' => "",
            'txn_from_appnotif' => "",
            'txn_ios' => "",
            'txn_from_eto' => "",
            'txn_from_otherweb' => "",
            'txn_from_sms_msite' => "",
            'txn_from_sms_app' => "" ];
            return $data;
        }
        
        return $data;
    }

    public function get_city_name($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT  gl_city_name  from
        (select glusr_usr_id, city_id,  cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '0'
        and cs_is_enable = '-1'
        and glusr_usr_id =$id) a, 
        (select gl_city_id , gl_city_name from gl_city) b
        where a.city_id = b.gl_city_id 
        group by  gl_city_name
        ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            array_push($data,$rec['gl_city_name']);
        }
       
        if(!$data){
            echo "no data";
            echo "<button id='removeEle'>Hide..</button>";
            die;
        };
        return $data;

    } 
    public function get_country_name($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT gl_country_name   from
        (select glusr_usr_id, 	fk_gl_country_iso ,  cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '1'
        and cs_is_enable = '-1'
        and glusr_usr_id =$id) a, 
        (select gl_country_iso, gl_country_name from gl_country) b
        where a.fk_gl_country_iso = b.gl_country_iso
        group by gl_country_name 
        ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            array_push($data,$rec['gl_country_name']);
        }
        if(!$data){
            echo "no data";
            echo "<button id='removeEle'>Hide..</button>";
            die;
        };
        return $data;
    } 

    public function get_city_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT count(distinct gl_city_id)  from
        (select glusr_usr_id, city_id,  cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '0'
        and cs_is_enable = '-1'
        and glusr_usr_id =$id) a, 
        (select gl_city_id , gl_city_name from gl_city) b
        where a.city_id = b.gl_city_id   
        ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        if($data)return $data;
        return $data;
    }
    public function get_district_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT count( distinct gl_city_name) from
        (select glusr_usr_id, city_id, fk_gl_districts_id,   cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '2'
        and cs_is_enable is null
        and glusr_usr_id =$id) a, 
        (select gl_city_id , gl_city_district_hq, gl_city_name from gl_city
        where  gl_city_id= gl_city_district_hq) b
        where a.fk_gl_districts_id= b.gl_city_id 
             
        ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        return $data;
    }

    public function get_state_count($id){
        
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT count(distinct gl_state_name) from
        (select glusr_usr_id, fk_gl_state_id  , cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '3'
        and cs_is_enable is null
        and glusr_usr_id =$id) a, 
        (select  gl_state_id, gl_state_name  from gl_state) b
        where a.fk_gl_state_id= b.gl_state_id";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        return $data;
    }

    public function get_preferred_location_city_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT count(distinct gl_city_id)  from
        (select glusr_usr_id, city_id,  cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '0'
        and cs_is_enable is null
        and glusr_usr_id =$id) a, 
        (select gl_city_id , gl_city_name from gl_city) b
        where a.city_id = b.gl_city_id
        ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        return $data;
    } 

    public function get_preferred_city_names($id)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql ="with reject_ofr_ids as (
            select fk_eto_ofr_id from eto_ofr_rejected where date(eto_ofr_reject_dt) >= (date(now()) - 60) and  fk_glusr_usr_id =  $id
            )
            
            select e.City_Name, e.Two_Months_Txn, e.Six_Months_Txn,  (case when f.Two_Months_rej is null then 0 else f.Two_Months_rej end) Two_Months_rej from 
            (
                
            select  c.City_Name, Two_Months_Txn, (case when d.cnt is null then 0 else d.cnt end) Six_Months_Txn from (
            (select a.city_name City_Name,  (case when cnt is null then 0 else cnt end) Two_Months_Txn from
            (select   distinct (select gl_city_name from gl_city where gl_city_id = city_id) city_name from eto_glusr_pref_city where pref_type = 0 and cs_is_enable is null and glusr_usr_id =  $id) a
            left join
            (select (select glusr_usr_city from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) city_name, count(1) cnt from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 60) and fk_glusr_usr_id =  $id group by city_name) b
            on lower(a.city_name) = lower(b.city_name) ) c
            left join 
            (select (select glusr_usr_city from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) city_name, count(1) cnt from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 180) and fk_glusr_usr_id =  $id group by city_name) d
            on  lower(c.City_Name) = lower( d.city_name))
                
            ) e
            left join
            (
            select (select gl_city_name from gl_city where gl_city_id = eto_ofr_city_id) rej_city_name, count (1) Two_Months_rej  from (
            select eto_ofr_display_id, eto_ofr_city_id from reject_ofr_ids inner join eto_ofr on fk_eto_ofr_id = eto_ofr_display_id
            union 
            select eto_ofr_display_id, eto_ofr_city_id from reject_ofr_ids inner join eto_ofr_expired on fk_eto_ofr_id = eto_ofr_display_id
            ) a  group by rej_city_name ) f
            on e.City_Name = f.rej_city_name";

        $data = [];   
        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
           if($sth){
        while ($rec = $sth->read()) {
            array_push($data,$rec);
        }
    }
        if(!$data){
            echo"no data";
            echo "<button id='removeEle'>Hide..</button>";
            die;
        } 
        else return $data;
    }

    public function get_preferred_country_names($id){
        
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql ="with 
        my_six_months_txn as (
            
        select	 country_iso, count(1) cnt from (
        select (select fk_gl_country_iso from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) country_iso, fk_eto_ofr_id from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 180) and fk_glusr_usr_id = $id 
        union all
        select (select fk_gl_country_iso from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) country_iso, fk_eto_ofr_id from iil_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 180) and fk_glusr_usr_id =  $id 
        ) a group by country_iso 
            
        ),
        my_three_months_txn as (
        
        select	 country_iso, count(1) cnt from (
        select (select fk_gl_country_iso from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) country_iso, fk_eto_ofr_id from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 90) and fk_glusr_usr_id =  $id
        union all
        select (select fk_gl_country_iso from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) country_iso, fk_eto_ofr_id from iil_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 90) and fk_glusr_usr_id =  $id 
        ) a group by country_iso 
        
        ),
        
        my_two_months_txn as (
            
        select	 country_iso, count(1) cnt from (
        select (select fk_gl_country_iso from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) country_iso, fk_eto_ofr_id from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 60) and fk_glusr_usr_id =   $id 
        union all
        select (select fk_gl_country_iso from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) country_iso, fk_eto_ofr_id from iil_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 60) and fk_glusr_usr_id =   $id
        )a group by country_iso 
            
        ),
        
        my_three_months_ni as (
            
        select fk_gl_country_iso country_iso , count (1) cnt  from (
        select eto_ofr_display_id, fk_gl_country_iso from
        (select fk_eto_ofr_id from eto_ofr_rejected where date(eto_ofr_reject_dt) >= (date(now()) - 90) and  fk_glusr_usr_id =   $id) a 
        inner join 
        eto_ofr 
        on fk_eto_ofr_id = eto_ofr_display_id
        union all 
        select eto_ofr_display_id, fk_gl_country_iso from 
        (select fk_eto_ofr_id from eto_ofr_rejected where date(eto_ofr_reject_dt) >= (date(now()) - 90) and  fk_glusr_usr_id =   $id) a
        inner join 
        eto_ofr_expired 
        on fk_eto_ofr_id = eto_ofr_display_id
        ) a  group by fk_gl_country_iso	
            
        ),
        
        my_pref_countries as 
        (
        select  fk_gl_country_iso   from eto_glusr_pref_city where pref_type = 1 and cs_is_enable is null and glusr_usr_id =  $id
        )
        
        select (select gl_country_name from gl_country where gl_country_iso = fk_gl_country_iso) Country_Name, 
        (case when my_two_months_txn.cnt is null then 0 else my_two_months_txn.cnt end) Two_Months_Txn,
        (case when my_three_months_txn.cnt is null then 0 else my_three_months_txn.cnt end) Three_Months_Txn,
        (case when my_six_months_txn.cnt is null then 0 else my_six_months_txn.cnt end) Six_Months_Txn,
        (case when my_three_months_ni.cnt is null then 0 else my_three_months_ni.cnt end) three_Months_ni
        from 
        my_pref_countries
        left join
        my_two_months_txn
        on fk_gl_country_iso = my_two_months_txn.country_iso
        left join
        my_three_months_txn
        on fk_gl_country_iso = my_three_months_txn.country_iso
        left join
        my_six_months_txn
        on fk_gl_country_iso = my_six_months_txn.country_iso
        left join
        my_three_months_ni
        on fk_gl_country_iso = my_three_months_ni.country_iso
        order by Six_Months_Txn desc
       ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            array_push($data,$rec);
        }
        if(!$data){
            echo"no data";
            echo "<button id='removeEle'>Hide..</button>";
            die;
        } 
        else return $data;
    }

    public function get_preferred_district_names($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
        $sql="select a.district_name, Two_Months_Txn, (case when cnt is null then 0 else cnt end) Six_Months_Txn from
        (select b.district_name, (case when cnt is null then 0 else cnt end) Two_Months_Txn from 
        (select gl_city_name from gl_city  where   gl_city_id  in (select fk_gl_districts_id from eto_glusr_pref_city where pref_type = 2 and cs_is_enable is null and glusr_usr_id =  $id)) a
        left join
        (select (select gl_city_name from gl_city where gl_city_id = b.gl_city_district_hq) district_name , sum(cnt) cnt from
        (select distinct (select fk_gl_city_id from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) city_id , count(1) cnt from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 60) and fk_glusr_usr_id =  $id group by city_id) a
        inner join 
        gl_city b
        on a.city_id = b.gl_city_id where gl_city_district_hq is not null  group by gl_city_district_hq) b
        on a.gl_city_name = b.district_name order by b.district_name)a
        left  join
        (select (select gl_city_name from gl_city where gl_city_id = b.gl_city_district_hq) district_name , sum(cnt) cnt from
        (select distinct (select fk_gl_city_id from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) city_id , count(1) cnt from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 180) and fk_glusr_usr_id =  $id group by city_id) a
        inner join 
        gl_city b
        on a.city_id = b.gl_city_id where gl_city_district_hq is not null  group by gl_city_district_hq) b
        on a.district_name = b.district_name";
        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            array_push($data,$rec);
        }

        if(!$data){
            echo"no data";
            echo "<button id='removeEle'>Hide..</button>";
            die;
        } 
        else return $data;
    }
    public function get_preferred_state_names($id){

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "select c.state_name, c.Two_Months_Txn, (case when d.cnt is null then 0 else d.cnt end) Six_Months_Txn from 
        (select a.state_name State_Name,  (case when cnt is null then 0 else cnt end) Two_Months_Txn from
        (select   distinct (select gl_state_name from gl_state where gl_state_id = fk_gl_state_id) state_name from eto_glusr_pref_city where pref_type = 3 and cs_is_enable is null and glusr_usr_id =  $id) a
        left join
        (select (select glusr_usr_state from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) state_name, count(1) cnt from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 60) and fk_glusr_usr_id =  $id group by state_name) b
        on lower(a.state_name) = lower(b.state_name) )c
        left join 
        (select (select glusr_usr_state from glusr_usr  where glusr_usr_id = eto_ofr_glusr_usr_id ) state_name, count(1) cnt from eto_lead_pur_hist where  fk_eto_ofr_id >0 and date(eto_pur_date) >= (date(now()) - 180) and fk_glusr_usr_id =  $id group by state_name) d
        on  lower(c.State_Name) = lower( d.State_Name)             
        ";
         $data = [];

         $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
 
         while ($rec = $sth->read()) {
             array_push($data,$rec);
         }
         if(!$data){
             echo"no data";
             echo "<button id='removeEle'>Hide..</button>";
             die;
         } 
         else return $data;
    }

    public function get_preferred_location_country_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT count( distinct gl_country_name) from
        (select glusr_usr_id, fk_gl_country_iso,   cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '1'
        and cs_is_enable is null
        and glusr_usr_id =$id) a, 
        (select  
        gl_country_iso, gl_country_name from gl_country) b
        where a.fk_gl_country_iso= b.gl_country_iso
        ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        return $data;
    } 
    
    function get_country_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT count(gl_country_name )  from
        (select glusr_usr_id, 	fk_gl_country_iso ,  cs_is_enable, pref_type  from eto_glusr_pref_city
        where pref_type = '1'
        and cs_is_enable = '-1'
        and glusr_usr_id =$id) a, 
        (select gl_country_iso, gl_country_name from gl_country) b
        where a.fk_gl_country_iso = b.gl_country_iso       
        ";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        return $data;

    }

    public function total_txn_in_days($id){

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT
        COUNT(1) TOTAL_TRANS 
        FROM
        (
        SELECT ETO_LEAD_PUR_MODE , ETO_LEAD_FK_GL_MODULE_ID , FK_ETO_OFR_ID
        From
           iil_LEAD_PUR_HIST
        WHERE
           date(eto_pur_date) >= (date(now()) - 90)
           AND FK_ETO_OFR_ID > 0
        
           AND ETO_LEAD_PUR_TYPE = 'B'
           and fk_glusr_usr_id=$id
        UNION ALL
        SELECT ETO_LEAD_PUR_MODE , ETO_LEAD_FK_GL_MODULE_ID , FK_ETO_OFR_ID
        From
           ETO_LEAD_PUR_HIST
        WHERE
        
           date(eto_pur_date) >= (date(now()) - 90)
           AND FK_ETO_OFR_ID > 0
         
           AND ETO_LEAD_PUR_TYPE = 'B'
           and fk_glusr_usr_id=$id
        )A";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        if(!$data) return null;
        return $data;
     } 

     public function total_txns_in_days($id){
        
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }


         $sql= "SELECT usr,
           eto_ofr_approx_order_val_mapp,
          count(1) AS tot_data
         FROM ( 
             SELECT DISTINCT b.fk_eto_ofr_id,
              b.fk_glusr_usr_id usr,
              eto_ofr_approx_order_val_mapp
            FROM eto_ofr_mapping a,
             eto_lead_pur_hist b,
             eto_attribute
           WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
             and b.fk_eto_ofr_id=fk_eto_ofr_display_id
             and fk_im_spec_master_desc<>'Probable Unit Price'
           AND eto_ofr_approx_order_val_mapp IS NOT NULL 
          AND date(b.eto_pur_date) >= (date(now()) - 90)
             and fk_glusr_usr_id=$id
             union all
             SELECT DISTINCT b.fk_eto_ofr_id,
              b.fk_glusr_usr_id usr,
              eto_ofr_approx_order_val_mapp
            FROM eto_ofr_mapping_expired a,
             eto_lead_pur_hist b,
             eto_attribute
           WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
             and b.fk_eto_ofr_id=fk_eto_ofr_display_id
             and fk_im_spec_master_desc<>'Probable Unit Price'
           AND eto_ofr_approx_order_val_mapp IS NOT NULL 
          AND date(b.eto_pur_date) >= (date(now()) - 90)
             and fk_glusr_usr_id=$id
             union all
             SELECT DISTINCT b.fk_eto_ofr_id,
              b.fk_glusr_usr_id usr,
              eto_ofr_approx_order_val_mapp
            FROM eto_ofr_mapping a,
             iil_lead_pur_hist b,
             eto_attribute
           WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
             and b.fk_eto_ofr_id=fk_eto_ofr_display_id
             and fk_im_spec_master_desc<>'Probable Unit Price'
          AND date(b.eto_pur_date) >= (date(now()) - 90)
             and fk_glusr_usr_id=$id
             union all
             SELECT DISTINCT b.fk_eto_ofr_id,
              b.fk_glusr_usr_id usr,
              eto_ofr_approx_order_val_mapp
            FROM eto_ofr_mapping_expired a,
             iil_lead_pur_hist b,
             eto_attribute
           WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
             and b.fk_eto_ofr_id=fk_eto_ofr_display_id
             and fk_im_spec_master_desc<>'Probable Unit Price'
           AND eto_ofr_approx_order_val_mapp IS NOT NULL 
          AND date(b.eto_pur_date) >= (date(now()) - 90)
             and fk_glusr_usr_id=$id
             )s
             group by usr, eto_ofr_approx_order_val_mapp
             ";

            $data = [];

            $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

            while ($rec = $sth->read()) {
                $data = $rec;
            }
            if($data)return $data;
            else return null;
            
     }

     public function get_TOV_slab($id){

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
       

       

        $sql = "SELECT usr,
          eto_ofr_approx_order_val_mapp,
         count(1) AS tot_data
        FROM ( 
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr,
             eto_ofr_approx_order_val_mapp
           FROM eto_ofr_mapping a,
            eto_lead_pur_hist b,
            eto_attribute
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
            and b.fk_eto_ofr_id=fk_eto_ofr_display_id
            and fk_im_spec_master_desc<>'Probable Unit Price'
          AND eto_ofr_approx_order_val_mapp IS NOT NULL 
         AND date(b.eto_pur_date) >= (date(now()) - 90)
            and fk_glusr_usr_id=$id
            union all
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr,
             eto_ofr_approx_order_val_mapp
           FROM eto_ofr_mapping_expired a,
            eto_lead_pur_hist b,
            eto_attribute
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
            and b.fk_eto_ofr_id=fk_eto_ofr_display_id
            and fk_im_spec_master_desc<>'Probable Unit Price'
          AND eto_ofr_approx_order_val_mapp IS NOT NULL 
         AND date(b.eto_pur_date) >= (date(now()) - 90)
            and fk_glusr_usr_id=$id
            union all
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr,
             eto_ofr_approx_order_val_mapp
           FROM eto_ofr_mapping a,
            iil_lead_pur_hist b,
            eto_attribute
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
            and b.fk_eto_ofr_id=fk_eto_ofr_display_id
            and fk_im_spec_master_desc<>'Probable Unit Price'
         AND date(b.eto_pur_date) >= (date(now()) - 90)
            and fk_glusr_usr_id=$id
            union all
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr,
             eto_ofr_approx_order_val_mapp
           FROM eto_ofr_mapping_expired a,
            iil_lead_pur_hist b,
            eto_attribute
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id 
            and b.fk_eto_ofr_id=fk_eto_ofr_display_id
            and fk_im_spec_master_desc<>'Probable Unit Price'
          AND eto_ofr_approx_order_val_mapp IS NOT NULL 
         AND date(b.eto_pur_date) >= (date(now()) - 90)
            and fk_glusr_usr_id=$id
            )s
            group by usr, eto_ofr_approx_order_val_mapp
                       
            "; 

            $data = [];

            $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

            while ($rec = $sth->read()) {
                array_push($data,$rec);
            }
            if($data)return $data;
            else return null;
    }

    public function get_preferred_cat_count($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();

        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
        $sql = "SELECT eto_trd_alert_rank, count(1) from eto_trd_alert_v2 where fk_glusr_usr_id=$id
        group by eto_trd_alert_rank";

        $data =new ArrayObject(array());

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data->append($rec);
        }
        $array =(array) $data;
        if($array)return $array;
        else return null;
    }

    public function get_mcat_wise_txn($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();

        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
        
        $sql = "SELECT  eto_trd_alert_rank,glcat_mcat_name, count(1)c
        from
        (
        select * from 
        (
        SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr, prime_mcat
           FROM eto_ofr_mapping a,
            ETO_lead_pur_hist b
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
             AND date(b.eto_pur_date) >= (date(now()) - 90)
            and b.fk_glusr_usr_id=$id
            union all
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr, prime_mcat
           FROM eto_ofr_mapping_expired a,
            ETO_lead_pur_hist b
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
             AND date(b.eto_pur_date) >= (date(now()) - 90)
            and b.fk_glusr_usr_id=$id
            union all
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr, prime_mcat
           FROM eto_ofr_mapping a,
            iil_lead_pur_hist b
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
             AND date(b.eto_pur_date) >= (date(now()) - 90)
            and b.fk_glusr_usr_id=$id
            union all
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr, prime_mcat
           FROM eto_ofr_mapping_expired a,
            iil_lead_pur_hist b
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
             AND date(b.eto_pur_date) >= (date(now()) - 90)
            and b.fk_glusr_usr_id=$id
            )a,
        (
            select fk_glcat_mcat_id, eto_trd_alert_rank , glcat_mcat_name from eto_trd_alert_v2
            where fk_glusr_usr_id=$id
            )b
        where fk_glcat_mcat_id=prime_mcat
            )g
            group by  eto_trd_alert_rank,glcat_mcat_name
            order by c desc;
        "; 

        $data =[];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            array_push($data,$rec);
        }

        if($data)return $data;
        else return null;

    }

    public function get_mcat_wise_wp_ni($id)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();

        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT  eto_trd_alert_rank,glcat_mcat_name, count(1)c
        from
        (
        select * from 
        (
        SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr, prime_mcat
           FROM eto_ofr_mapping a,
            ETO_OFR_REJECTED b
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
             AND date(b.eto_ofr_reject_dt) >= (date(now()) - 90)
            and b.fk_glusr_usr_id=$id
            and b.eto_ofr_reject_reason='1'
            
            union all
            SELECT DISTINCT b.fk_eto_ofr_id,
             b.fk_glusr_usr_id usr, prime_mcat
           FROM eto_ofr_mapping_expired a,
             ETO_OFR_REJECTED b
          WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
             AND date(b.eto_ofr_reject_dt) >= (date(now()) - 90)
            and b.fk_glusr_usr_id=$id
            and b.eto_ofr_reject_reason='1'
            )a,
        (
            select fk_glcat_mcat_id, eto_trd_alert_rank , glcat_mcat_name from eto_trd_alert_v2
            where fk_glusr_usr_id=$id
            )b
        where fk_glcat_mcat_id=prime_mcat
            )g
            group by  eto_trd_alert_rank,glcat_mcat_name
            order by c desc;
            ";

        $data =[];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            array_push($data,$rec);
        }

        if($data)return $data;
        else return null;
    }

    public function txns_on_retail_leads($id){
        
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
        $sql = "SELECT  count(1)
        from
        (
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
         )d";
        
        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }

        if($data)return $data;
        else return null;
    }


    public function retail_ni($id){
    
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql="SELECT  count(1)
        from eto_ofr_rejected 
        where fk_glusr_usr_id=$id
        and eto_ofr_reject_reason='11'
        AND date(eto_ofr_reject_dt) >= (date(now()) - 180)";
        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
    
        if($data)return $data;
        else return null;
    }

    public function txns_on_non_retail_leads($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        
        $sql ="SELECT  count(1)
        from
        (
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
            )d";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        
        if($data)return $data;
        else return null;
    }

    public function txns_on_hyper_local_retail_leads($id)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
        $sql = "SELECT  count(1)
        from
        (
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 180)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
            )d"; 
        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }

        if($data)return $data;
        else return null;

    }

    public function txns_on_hyper_local_retail_leads_50_km($id)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT
        COUNT(case when dis <=50 then 1 end) TOTAL_TRANS 
        FROM
        (
        select  
        b.eto_lead_pur_id,
        b.fk_eto_ofr_id,
        b.ETO_PUR_DATE,
        b.FK_GLUSR_USR_ID seller_id,
        SUP.fk_gl_city_id sup_city,
        ETO_OFR_GLUSR_USR_ID buyer_id,
        sup.glusr_usr_city,
        buyer.glusr_usr_city,	
        buyer.fk_gl_city_id,
        a.distance_city dis,
        d.eto_enq_typ ,
        d.eto_ofr_display_id,
        ETO_LEAD_PUR_MODE, 
        ETO_LEAD_FK_GL_MODULE_ID 
        from
           ETO_LEAD_PUR_HIST b, GLUSR_USR SUP, GLUSR_USR BUYER, gl_city_distance_mvy a , eto_ofr_expired d
        WHERE
         eto_lead_pur_type='B'
         and date(eto_pur_date) >= (date(now()) - 180)
           AND b.FK_ETO_OFR_ID > 0
           AND SUP.GLUSR_USR_ID  = b.FK_GLUSR_USR_ID
           and b.FK_GLUSR_USR_ID = $id
           AND BUYER.GLUSR_USR_ID  = b.ETO_OFR_GLUSR_USR_ID
           and SUP.fk_gl_city_id = a.to_city_id
           and buyer.fk_gl_city_id = a.from_city_id
        and  b.FK_ETO_OFR_ID = d.eto_ofr_display_id
        and  eto_enq_typ in (1,3,5,6)
            union all
            select  
        b.eto_lead_pur_id,
        b.fk_eto_ofr_id,
        b.ETO_PUR_DATE,
        b.FK_GLUSR_USR_ID seller_id,
        SUP.fk_gl_city_id sup_city,
        ETO_OFR_GLUSR_USR_ID buyer_id,
        sup.glusr_usr_city,
        buyer.glusr_usr_city,	
        buyer.fk_gl_city_id,
        a.distance_city dis,
        d.eto_enq_typ ,
        d.eto_ofr_display_id,
        ETO_LEAD_PUR_MODE, 
        ETO_LEAD_FK_GL_MODULE_ID
        from
           iil_LEAD_PUR_HIST b, GLUSR_USR SUP, GLUSR_USR BUYER, gl_city_distance_mvy a, eto_ofr_expired d
        WHERE
         eto_lead_pur_type='B'
         and date(eto_pur_date) >= (date(now()) - 180)
           AND b.FK_ETO_OFR_ID > 0
           AND SUP.GLUSR_USR_ID  = b.FK_GLUSR_USR_ID
           and b.FK_GLUSR_USR_ID = $id
           AND BUYER.GLUSR_USR_ID  = b.ETO_OFR_GLUSR_USR_ID
           and SUP.fk_gl_city_id = a.from_city_id
           and buyer.fk_gl_city_id = a.to_city_id
        and  b.FK_ETO_OFR_ID = d.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        )A";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }

        if($data)return $data;
        else return null;
    }

    public function hyper_retail_ni($id)
    {
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT  count(1)
        from eto_ofr_rejected 
        where fk_glusr_usr_id=$id
        and eto_ofr_reject_reason='11'
        AND date(eto_ofr_reject_dt) >= (date(now()) - 180)";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        if($data)return $data;
        else return null;

    }

    public function non_retail_ni($id){

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT  count(1)
        from eto_ofr_rejected 
        where fk_glusr_usr_id=$id
        and eto_ofr_reject_reason='11'
        AND date(eto_ofr_reject_dt) >= (date(now()) - 180)";

        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

        while ($rec = $sth->read()) {
            $data = $rec;
        }
        if($data)return $data;
        else return null;
    }

    public function get_retailer_type($id){

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql = "SELECT fk_bl_disp_exception_reason_id from bl_display_exception where eto_rejection_master_user_id=$id";
        $data = [];

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
        
        while ($rec = $sth->read()) {
            $data = $rec['fk_bl_disp_exception_reason_id'];  
        }
        $decoded = [
            0 => "na",
            1 => "non-retailer",
            2 => "Hyperlocal retailer",
            3 => "Deemed retailer" 
        ];
        if(!$data || $data > 3 || $data < 0 ) return "na"; 
        else return $decoded[$data];   
    }

    public function get_retail_txn_30_days($id){

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }

        $sql="SELECT  count(1)
        from
        (
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 30)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        eto_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 30)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 30)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
        union all
        select eto_pur_date, a.fk_glusr_usr_id, fk_eto_ofr_id from
        iil_lead_pur_hist a,eto_ofr_expired c
        where 
        a.fk_eto_ofr_id=c.eto_ofr_display_id
        and eto_enq_typ in (1,3,5,6)
        AND date(eto_pur_date) >= (date(now()) - 30)
        and fk_eto_ofr_id>0
        and eto_lead_pur_type='B'
        and a.fk_glusr_usr_id=$id
            )d";
     $data = [];

     $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());

     while ($rec = $sth->read()) {
         $data = $rec;
     }

     if($data) return $data;
     else return null;
    }

    public function get_retail_txn_30_days_50_km($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }


    }

    public function McatwisecallbackData($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    $sql= "select (select glcat_mcat_name from glcat_mcat where glcat_mcat_id  = fk_glcat_mcat_id) mcat_name, count_60  , count_90  , count_180 , count_1yr, counts_120_P, counts_60_P  from(
        (select  fk_glcat_mcat_id , count_60  , count_90  , count_180 , count_1yr  , 0 as counts_120_P, 0 as counts_60_P from callback_txn_4abc_rank  where fk_glusr_usr_id in ($id))
        union
        (select  fk_glcat_mcat_id, 0 as count_60 , 0 as count_90 , 0 as count_180 , 0 as count_1yr, counts counts_120_P, count_60 counts_60_P  from callback_txn_4d_rank where fk_glusr_usr_id in ($id)
        ) )a";
     

        $data = array();

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
         if($sth){
        while ($rec = $sth->readAll()) {
            $data = $rec;
        }
       }
        if($data)return $data;
        else return null;
    }

    public function McatwiseRepliesData($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    $sql= "select (select glcat_mcat_name from glcat_mcat where glcat_mcat_id  = fk_glcat_mcat_id) mcat_name, count_60_3_reply , count_90_3_reply  , count_180_3_reply , count_1yr_2_reply  ,counts_120_P, counts_60_P from(
        (select  fk_glcat_mcat_id , count_60_3_reply , count_90_3_reply  , count_180_3_reply , count_1yr_2_reply  , 0 as counts_120_P, 0 as counts_60_P from reply_txn_4abc_rank  where fk_glusr_usr_id in ($id))
        union
        (select  fk_glcat_mcat_id, 0 as count_60_3_reply , 0 as count_90_3_reply , 0 as count_180_3_reply, 0 as count_1yr_2_reply, counts counts_120_P, count_60 counts_60_P  from reply_txn_4d_rank where fk_glusr_usr_id in ($id)
        ) )a";
     

        $data = array();

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
         if($sth){
        while ($rec = $sth->readAll()) {
            $data = $rec;
          }
         }

        if($data)return $data;
        else return null;
    }
    public function PreferredCat_AData($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    $sql= "with my_a_rank_mcats as (
        select fk_glcat_mcat_id, eto_trd_alert_rank , glcat_mcat_name from eto_trd_alert_v2
        where fk_glusr_usr_id=$id
        and eto_trd_alert_rank = 'A' 
    ),
    my_two_months_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Txn
    from	
    my_a_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
        
        
    ), 
    my_four_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Four_Months_Txn
    from	
    my_a_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_six_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Six_Months_Txn
    from	
    my_a_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_one_year_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) One_Year_Txn
    from	
    my_a_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
    ),
    my_two_months_ni
    as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Ni
    from	
    my_a_rank_mcats
    left join 
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and eto_ofr_reject_reason = '1'
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id  and eto_ofr_reject_reason = '1'
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    ),
    my_pos_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_positive_qrf
    from	
    my_a_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	 
         
         
    ),
    my_neg_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_negative_qrf
    from	
    my_a_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	  
    ) select 
    my_two_months_txn.glcat_mcat_name, 
    Two_Months_Txn, 
    Four_Months_Txn,
    Six_Months_Txn,
    One_Year_Txn,
    Two_Months_Ni,
    Two_Months_Positive_qrf,
    Two_Months_negative_qrf
    from 
    my_two_months_txn 
    inner join
    my_four_months_txn 
    on my_two_months_txn.glcat_mcat_name  = my_four_months_txn.glcat_mcat_name 
    inner join my_six_months_txn 
    on  my_two_months_txn.glcat_mcat_name  = my_six_months_txn.glcat_mcat_name
    inner join my_one_year_txn
    on  my_two_months_txn.glcat_mcat_name  = my_one_year_txn.glcat_mcat_name 
    inner join my_two_months_ni
    on  my_two_months_txn.glcat_mcat_name  = my_two_months_ni.glcat_mcat_name 
    inner join my_pos_qrf
    on my_two_months_txn.glcat_mcat_name  = my_pos_qrf.glcat_mcat_name 
    inner join my_neg_qrf
    on my_two_months_txn.glcat_mcat_name  = my_neg_qrf.glcat_mcat_name";
     

        $data = array();

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
         if($sth){
        while ($rec = $sth->readAll()) {
            $data = $rec;
        }
    }
        if($data)return $data;
        else return null;
    }

    public function PreferredCat_BData($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    $sql= "with my_b_rank_mcats as (
        select fk_glcat_mcat_id, eto_trd_alert_rank , glcat_mcat_name from eto_trd_alert_v2
        where fk_glusr_usr_id=$id
        and eto_trd_alert_rank = 'B' 
    ),
    my_two_months_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Txn
    from	
    my_b_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
        
        
    ), 
    my_four_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Four_Months_Txn
    from	
    my_b_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_six_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Six_Months_Txn
    from	
    my_b_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_one_year_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) One_Year_Txn
    from	
    my_b_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
    ),
    my_two_months_ni
    as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Ni
    from	
    my_b_rank_mcats
    left join 
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and eto_ofr_reject_reason = '1'
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id  and eto_ofr_reject_reason = '1'
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    ),
    my_pos_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_positive_qrf
    from	
    my_b_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	 
         
         
    ),
    my_neg_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_negative_qrf
    from	
    my_b_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	  
    ) select 
    my_two_months_txn.glcat_mcat_name, 
    Two_Months_Txn, 
    Four_Months_Txn,
    Six_Months_Txn,
    One_Year_Txn,
    Two_Months_Ni,
    Two_Months_Positive_qrf,
    Two_Months_negative_qrf
    from 
    my_two_months_txn 
    inner join
    my_four_months_txn 
    on my_two_months_txn.glcat_mcat_name  = my_four_months_txn.glcat_mcat_name 
    inner join my_six_months_txn 
    on  my_two_months_txn.glcat_mcat_name  = my_six_months_txn.glcat_mcat_name
    inner join my_one_year_txn
    on  my_two_months_txn.glcat_mcat_name  = my_one_year_txn.glcat_mcat_name 
    inner join my_two_months_ni
    on  my_two_months_txn.glcat_mcat_name  = my_two_months_ni.glcat_mcat_name 
    inner join my_pos_qrf
    on my_two_months_txn.glcat_mcat_name  = my_pos_qrf.glcat_mcat_name 
    inner join my_neg_qrf
    on my_two_months_txn.glcat_mcat_name  = my_neg_qrf.glcat_mcat_name";
     

        $data = array();

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
         if($sth){
        while ($rec = $sth->readAll()) {
            $data = $rec;
        }
    }
        if($data)return $data;
        else return null;
    }

    public function PreferredCat_CData($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    $sql= "with my_c_rank_mcats as (
        select fk_glcat_mcat_id, eto_trd_alert_rank , glcat_mcat_name from eto_trd_alert_v2
        where fk_glusr_usr_id=$id
        and eto_trd_alert_rank = 'C' 
    ),
    my_two_months_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Txn
    from	
    my_c_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
        
        
    ), 
    my_four_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Four_Months_Txn
    from	
    my_c_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_six_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Six_Months_Txn
    from	
    my_c_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_one_year_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) One_Year_Txn
    from	
    my_c_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
    ),
    my_two_months_ni
    as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Ni
    from	
    my_c_rank_mcats
    left join 
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and eto_ofr_reject_reason = '1'
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id  and eto_ofr_reject_reason = '1'
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    ),
    my_pos_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_positive_qrf
    from	
    my_c_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	 
         
         
    ),
    my_neg_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_negative_qrf
    from	
    my_c_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	  
    ) select 
    my_two_months_txn.glcat_mcat_name, 
    Two_Months_Txn, 
    Four_Months_Txn,
    Six_Months_Txn,
    One_Year_Txn,
    Two_Months_Ni,
    Two_Months_Positive_qrf,
    Two_Months_negative_qrf
    from 
    my_two_months_txn 
    inner join
    my_four_months_txn 
    on my_two_months_txn.glcat_mcat_name  = my_four_months_txn.glcat_mcat_name 
    inner join my_six_months_txn 
    on  my_two_months_txn.glcat_mcat_name  = my_six_months_txn.glcat_mcat_name
    inner join my_one_year_txn
    on  my_two_months_txn.glcat_mcat_name  = my_one_year_txn.glcat_mcat_name 
    inner join my_two_months_ni
    on  my_two_months_txn.glcat_mcat_name  = my_two_months_ni.glcat_mcat_name 
    inner join my_pos_qrf
    on my_two_months_txn.glcat_mcat_name  = my_pos_qrf.glcat_mcat_name 
    inner join my_neg_qrf
    on my_two_months_txn.glcat_mcat_name  = my_neg_qrf.glcat_mcat_name"	;
     

        $data = array();

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
         if($sth){
        while ($rec = $sth->readAll()) {
            $data = $rec;
        }
    }
        if($data)return $data;
        else return null;
    }

    public function PreferredCat_DData($id){
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
    $sql= "with my_d_rank_mcats as (
        select fk_glcat_mcat_id, eto_trd_alert_rank , glcat_mcat_name from eto_trd_alert_v2
        where fk_glusr_usr_id=$id
        and eto_trd_alert_rank = 'D' 
    ),
    my_two_months_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Txn
    from	
    my_d_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
        
        
    ), 
    my_four_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Four_Months_Txn
    from	
    my_d_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 120)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_six_months_txn as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Six_Months_Txn
    from	
    my_d_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 180)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    
    ), 
    my_one_year_txn as (
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) One_Year_Txn
    from	
    my_d_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,b.fk_glusr_usr_id usr, prime_mcat FROM eto_ofr_mapping a, ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        ETO_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_lead_pur_hist b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_pur_date) >= (date(now()) - 360)
        and b.fk_glusr_usr_id=$id
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat	
    ),
    my_two_months_ni
    as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_Ni
    from	
    my_d_rank_mcats
    left join 
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and eto_ofr_reject_reason = '1'
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        eto_ofr_rejected b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.eto_ofr_reject_dt) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id  and eto_ofr_reject_reason = '1'
        
    )a group by prime_mcat) a
        
    on 	fk_glcat_mcat_id=prime_mcat
    ),
    my_pos_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_positive_qrf
    from	
    my_d_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	 
         
         
    ),
    my_neg_qrf
     as (
    
    select   glcat_mcat_name, (case when cnt is null then 0 else cnt end) Two_Months_negative_qrf
    from	
    my_d_rank_mcats
    left join 	
    (select prime_mcat, count(1) cnt from
    (
    SELECT DISTINCT b.fk_eto_ofr_id,
        b.fk_glusr_usr_id usr, 
        prime_mcat 
        FROM eto_ofr_mapping a, iil_enquiry_feedbacks b
      WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        union all
        SELECT DISTINCT b.fk_eto_ofr_id,
         b.fk_glusr_usr_id usr, prime_mcat
       FROM eto_ofr_mapping_expired a,
        iil_enquiry_feedbacks b
        WHERE b.fk_eto_ofr_id = A.fk_eto_ofr_id
         AND date(b.iil_enquiry_feedbacks_date) >= (date(now()) - 60)
        and b.fk_glusr_usr_id=$id and fk_enquiry_relevancy_id = 0 and fk_enquiry_irl_reason_id = 1
        
    )a group by prime_mcat) a	
    on 	fk_glcat_mcat_id=prime_mcat	  
    ) select 
    my_two_months_txn.glcat_mcat_name, 
    Two_Months_Txn, 
    Four_Months_Txn,
    Six_Months_Txn,
    One_Year_Txn,
    Two_Months_Ni,
    Two_Months_Positive_qrf,
    Two_Months_negative_qrf
    from 
    my_two_months_txn 
    inner join
    my_four_months_txn 
    on my_two_months_txn.glcat_mcat_name  = my_four_months_txn.glcat_mcat_name 
    inner join my_six_months_txn 
    on  my_two_months_txn.glcat_mcat_name  = my_six_months_txn.glcat_mcat_name
    inner join my_one_year_txn
    on  my_two_months_txn.glcat_mcat_name  = my_one_year_txn.glcat_mcat_name 
    inner join my_two_months_ni
    on  my_two_months_txn.glcat_mcat_name  = my_two_months_ni.glcat_mcat_name 
    inner join my_pos_qrf
    on my_two_months_txn.glcat_mcat_name  = my_pos_qrf.glcat_mcat_name 
    inner join my_neg_qrf
    on my_two_months_txn.glcat_mcat_name  = my_neg_qrf.glcat_mcat_name";
     

        $data = array();

        $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
         if($sth){
        while ($rec = $sth->readAll()) {
            $data = $rec;
        }
    }
        if($data)return $data;
        else return null;
    }
}