<?php
class Consumptionreport extends CFormModel
{
    public function getBlConsumptionData($request)
    {
        $result=$bind=array();
        $emp_id =Yii::app()->session['empid'];
                $dateClause = '';
                $opt=isset($_REQUEST['opt']) ? $_REQUEST['opt'] : 'Datewise';
                $start_date = $request->getParam('start_date','');
                $end_date = $request->getParam('end_date','');
                $s1 = strtotime($start_date);
                $t1 = strtotime(date("d-M-Y"));
                $e1 = strtotime($end_date);
                $t2 = strtotime(date("d-M-Y"));               
                
                $obj = new Globalconnection();
                $GlobalmodelForm= new GlobalmodelForm();
                $bind=array();
                if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                {
                    $dbh = $obj->connect_db_yii('postgress_web77v');   
                }else{
                    $dbh = $obj->connect_db_yii('postgress_web68v'); 
                }
                
if($opt=='Hourly')
    {
       $bind[':IN_DATE']=$start_date; 
        
$sql =  "SELECT To_char(eto_pur_date, 'HH24')                    ETO_PUR_DATE, 
       Count(eto_lead_pur_id)                           LEAD_SOLD, 
       Count(DISTINCT fk_eto_ofr_id)                    LEAD_SOLD_UNIQUE, 
       Sum(eto_credits_used)                            CREDITUSED, 
       Sum(my_count)                                    MY_CNT, 
       Sum(eto_count)                                   ETO_CNT, 
       Sum(htd_count)                                   HTD_CNT, 
       Sum(ffext_count)                                 FFEXT_CNT, 
       Sum(mail_count)                                  MAIL_COUNT, 
       Sum(mail_count_emor)                             MAIL_COUNT_EMOR, 
       Sum(mail_count_mor)                              MAIL_COUNT_MOR, 
       Sum(mail_count_leve)                             MAIL_COUNT_LEVE, 
       Sum(autoinst)                                    AUTOINST_CNT, 
       Sum(mail_count_inst)                             MAIL_COUNT_INST, 
       Sum(mail_count_withinst)                         MAIL_COUNT_WITHINST, 
       ( Sum(mail_count) - Sum(mail_count_emor) - Sum(mail_count_mor) - Sum( 
           mail_count_leve) - Sum(autoinst) - Sum(mail_count_inst) - Sum( 
           mail_count_withinst) - Sum(htd_mail_count) ) OTHERS, 
       Sum(htd_mail_count)                              HTD_CNT_MAIL, 
       Sum(mailmob)                                     MAIL_COUNT_MAILMOB, 
       Sum(email_app)                                   EMAIL_APP_CNT, 
       Sum(email_mob)                                   EMAIL_MOB_CNT, 
       Sum(email_my)                                    EMAIL_MY_CNT, 
       Sum(app)                                         APP_CNT, 
       Sum(app_email)                                   APP_EMAIL_CNT, 
       Sum(android)                                     ANDROID_CNT, 
       Sum(android_sms)                                 ANDROID_SMS_CNT, 
       Sum(mob_count)                                   MOB_COUNT, 
       Sum(imob_sms)                                    IMOB_SMS_CNT 
FROM   (
			SELECT ETO_LEAD_PUR_HIST.eto_lead_pur_id, 
               ETO_LEAD_PUR_HIST.eto_credits_used, 
               CASE 
                 WHEN eto_lead_pur_mode = 'WEB' 
                      AND eto_lead_fk_gl_module_id IN ( 
                          'WEBERP', 'TDR', 'GLADMIN', 'EMKTG', 
                          'HELLOTD', 'MY', 'TACTIVE', 'TMRNG', 
                          'TEVNG', 'TMIDDAY', 'BigBuyer', 'ETO' ) 
               THEN 1 
                 ELSE 0 
               END                            AS WEB_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'MY' THEN 1 
                 ELSE 0 
               END                            AS MY_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'ETO' THEN 1 
                 ELSE 0 
               END                            AS ETO_COUNT, 
               CASE 
                 WHEN eto_lead_pur_mode = 'WEB' 
                      AND eto_lead_fk_gl_module_id = 'HELLOTD' THEN 1 
                 ELSE 0 
               END                            AS HTD_COUNT, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'MAILMOB' 
                         OR eto_lead_pur_mode = 'MAIL' ) 
                      AND eto_lead_fk_gl_module_id = 'HELLOTD' THEN 1 
                 ELSE 0 
               END                            AS HTD_MAIL_COUNT, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'MAILMOB' 
                         OR eto_lead_pur_mode = 'MAIL' ) 
                      AND eto_lead_fk_gl_module_id IN( 
                          'AUTOINST', 'EMKTG', 'EMORNING', 
                          'WITHINST', 
                          'LEVENING', 'MORNING', 'INSTANT' 
                          , 
                          'HELLOTD' ) THEN 1 
                 ELSE 0 
               END                            MAIL_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'EMORNING' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_EMOR, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'MORNING' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_MOR, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'LEVENING' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_LEVE, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'INSTANT' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_INST, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'WITHINST' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_WITHINST, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_fk_gl_module_id IN( 
                          'AUTOINST', 'EMKTG', 'EMORNING', 
                          'WITHINST', 
                          'LEVENING', 'MORNING', 'INSTANT' 
                          , 
                          'HELLOTD' ) THEN 1 
                 ELSE 0 
               END                            AS MAILMOB, 
               ETO_LEAD_PUR_HIST.fk_eto_ofr_id, 
               ETO_LEAD_PUR_HIST.eto_pur_date ETO_PUR_DATE, 
               ETO_LEAD_PUR_HIST.fk_glusr_usr_id, 
               ETO_LEAD_PUR_HIST.eto_lead_pur_mode, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'MOB' 
                        AND eto_lead_fk_gl_module_id = 'IMOB' ) THEN 1 
                 ELSE 0 
               END                            AS MOB_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'FFEXT' THEN 1 
                 ELSE 0 
               END                            AS FFEXT_COUNT, 
               CASE 
                 WHEN eto_lead_pur_mode = 'SMS' 
                      AND eto_lead_fk_gl_module_id = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            ANDROID_SMS, 
               CASE 
                 WHEN eto_lead_pur_mode = 'SMS' 
                      AND eto_lead_fk_gl_module_id = 'IMOB' THEN 1 
                 ELSE 0 
               END                            IMOB_SMS, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'APP' 
                         OR eto_lead_pur_mode = 'APPS' ) 
                      AND eto_lead_fk_gl_module_id <> 'IOS' THEN 1 
                 ELSE 0 
               END                            ANDROID, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'AUTOINST' THEN 1 
                 ELSE 0 
               END                            AUTOINST, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_fk_gl_module_id = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            EMAIL_APP, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_fk_gl_module_id = 'IMOB' THEN 1 
                 ELSE 0 
               END                            EMAIL_MOB, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAIL' 
                      AND eto_lead_fk_gl_module_id = 'MY' THEN 1 
                 ELSE 0 
               END                            EMAIL_MY, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_pur_position_url = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            APP_EMAIL, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'ANDROID' 
                       OR eto_lead_pur_position_url = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            APP 
        FROM   (
					SELECT eto_lead_pur_id, 
                       eto_credits_used, 
                       eto_lead_pur_mode, 
                       eto_lead_fk_gl_module_id, 
                       fk_eto_ofr_id, 
                       eto_pur_date, 
                       fk_glusr_usr_id, 
                       eto_lead_pur_position_url 
                FROM   eto_lead_pur_hist ETO_LEAD_PUR_HIST 
                WHERE  Date(ETO_LEAD_PUR_HIST.eto_pur_date) = :IN_DATE
                       AND fk_eto_ofr_id > 0 
                       AND eto_lead_pur_type = 'B' 
                UNION ALL 
                SELECT eto_lead_pur_id, 
                       eto_credits_used, 
                       eto_lead_pur_mode, 
                       eto_lead_fk_gl_module_id, 
                       fk_eto_ofr_id, 
                       eto_pur_date, 
                       fk_glusr_usr_id, 
                       eto_lead_pur_position_url 
                FROM   iil_lead_pur_hist ETO_LEAD_PUR_HIST 
                WHERE  Date(ETO_LEAD_PUR_HIST.eto_pur_date) = :IN_DATE
                       AND fk_eto_ofr_id > 0 
                       AND eto_lead_pur_type = 'B'
			)ETO_LEAD_PUR_HIST
	) A GROUP  BY To_char(eto_pur_date, 'HH24')";
	$sth = $GlobalmodelForm->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;       
        
   $result = $sth->readAll();    
}
else{
    $bind[':IN_DATE']=$start_date;
   $bind[':END_DATE']=$end_date;
                        
    $sql =  "SELECT To_char(eto_pur_date, 'DD-MON-YYYY')             ETO_PUR_DATE, 
       Count(eto_lead_pur_id)                           LEAD_SOLD, 
       Count(DISTINCT fk_eto_ofr_id)                    LEAD_SOLD_UNIQUE, 
       Sum(eto_credits_used)                            CREDITUSED, 
       Sum(my_count)                                    MY_CNT, 
       Sum(eto_count)                                   ETO_CNT, 
       Sum(htd_count)                                   HTD_CNT, 
       Sum(ffext_count)                                 FFEXT_CNT, 
       Sum(mail_count)                                  MAIL_COUNT, 
       Sum(mail_count_emor)                             MAIL_COUNT_EMOR, 
       Sum(mail_count_mor)                              MAIL_COUNT_MOR, 
       Sum(mail_count_leve)                             MAIL_COUNT_LEVE, 
       Sum(autoinst)                                    AUTOINST_CNT, 
       Sum(mail_count_inst)                             MAIL_COUNT_INST, 
       Sum(mail_count_withinst)                         MAIL_COUNT_WITHINST, 
       ( Sum(mail_count) - Sum(mail_count_emor) - Sum(mail_count_mor) - Sum( 
           mail_count_leve) - Sum(autoinst) - Sum(mail_count_inst) - Sum( 
           mail_count_withinst) - Sum(htd_mail_count) ) OTHERS, 
       Sum(htd_mail_count)                              HTD_CNT_MAIL, 
       Sum(mailmob)                                     MAIL_COUNT_MAILMOB, 
       Sum(email_app)                                   EMAIL_APP_CNT, 
       Sum(email_mob)                                   EMAIL_MOB_CNT, 
       Sum(email_my)                                    EMAIL_MY_CNT, 
       Sum(app)                                         APP_CNT, 
       Sum(app_email)                                   APP_EMAIL_CNT, 
       Sum(android)                                     ANDROID_CNT, 
       Sum(android_sms)                                 ANDROID_SMS_CNT, 
       Sum(mob_count)                                   MOB_COUNT, 
       Sum(imob_sms)                                    IMOB_SMS_CNT 
FROM   (
			SELECT ETO_LEAD_PUR_HIST.eto_lead_pur_id, 
               ETO_LEAD_PUR_HIST.eto_credits_used, 
               CASE 
                 WHEN eto_lead_pur_mode = 'WEB' 
                      AND eto_lead_fk_gl_module_id IN ( 
                          'WEBERP', 'TDR', 'GLADMIN', 'EMKTG', 
                          'HELLOTD', 'MY', 'TACTIVE', 'TMRNG', 
                          'TEVNG', 'TMIDDAY', 'BigBuyer', 'ETO' ) 
               THEN 1 
                 ELSE 0 
               END                            AS WEB_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'MY' THEN 1 
                 ELSE 0 
               END                            AS MY_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'ETO' THEN 1 
                 ELSE 0 
               END                            AS ETO_COUNT, 
               CASE 
                 WHEN eto_lead_pur_mode = 'WEB' 
                      AND eto_lead_fk_gl_module_id = 'HELLOTD' THEN 1 
                 ELSE 0 
               END                            AS HTD_COUNT, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'MAILMOB' 
                         OR eto_lead_pur_mode = 'MAIL' ) 
                      AND eto_lead_fk_gl_module_id = 'HELLOTD' THEN 1 
                 ELSE 0 
               END                            AS HTD_MAIL_COUNT, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'MAILMOB' 
                         OR eto_lead_pur_mode = 'MAIL' ) 
                      AND eto_lead_fk_gl_module_id IN( 
                          'AUTOINST', 'EMKTG', 'EMORNING', 
                          'WITHINST', 
                          'LEVENING', 'MORNING', 'INSTANT' 
                          , 
                          'HELLOTD' ) THEN 1 
                 ELSE 0 
               END                            MAIL_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'EMORNING' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_EMOR, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'MORNING' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_MOR, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'LEVENING' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_LEVE, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'INSTANT' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_INST, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'WITHINST' THEN 1 
                 ELSE 0 
               END                            AS MAIL_COUNT_WITHINST, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_fk_gl_module_id IN( 
                          'AUTOINST', 'EMKTG', 'EMORNING', 
                          'WITHINST', 
                          'LEVENING', 'MORNING', 'INSTANT' 
                          , 
                          'HELLOTD' ) THEN 1 
                 ELSE 0 
               END                            AS MAILMOB, 
               ETO_LEAD_PUR_HIST.fk_eto_ofr_id, 
               ETO_LEAD_PUR_HIST.eto_pur_date ETO_PUR_DATE, 
               ETO_LEAD_PUR_HIST.fk_glusr_usr_id, 
               ETO_LEAD_PUR_HIST.eto_lead_pur_mode, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'MOB' 
                        AND eto_lead_fk_gl_module_id = 'IMOB' ) THEN 1 
                 ELSE 0 
               END                            AS MOB_COUNT, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'FFEXT' THEN 1 
                 ELSE 0 
               END                            AS FFEXT_COUNT, 
               CASE 
                 WHEN eto_lead_pur_mode = 'SMS' 
                      AND eto_lead_fk_gl_module_id = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            ANDROID_SMS, 
               CASE 
                 WHEN eto_lead_pur_mode = 'SMS' 
                      AND eto_lead_fk_gl_module_id = 'IMOB' THEN 1 
                 ELSE 0 
               END                            IMOB_SMS, 
               CASE 
                 WHEN ( eto_lead_pur_mode = 'APP' 
                         OR eto_lead_pur_mode = 'APPS' ) 
                      AND eto_lead_fk_gl_module_id <> 'IOS' THEN 1 
                 ELSE 0 
               END                            ANDROID, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'AUTOINST' THEN 1 
                 ELSE 0 
               END                            AUTOINST, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_fk_gl_module_id = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            EMAIL_APP, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_fk_gl_module_id = 'IMOB' THEN 1 
                 ELSE 0 
               END                            EMAIL_MOB, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAIL' 
                      AND eto_lead_fk_gl_module_id = 'MY' THEN 1 
                 ELSE 0 
               END                            EMAIL_MY, 
               CASE 
                 WHEN eto_lead_pur_mode = 'MAILMOB' 
                      AND eto_lead_pur_position_url = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            APP_EMAIL, 
               CASE 
                 WHEN eto_lead_fk_gl_module_id = 'ANDROID' 
                       OR eto_lead_pur_position_url = 'ANDROID' THEN 1 
                 ELSE 0 
               END                            APP 
        FROM   
			(
				SELECT eto_lead_pur_id, 
                       eto_credits_used, 
                       eto_lead_pur_mode, 
                       eto_lead_fk_gl_module_id, 
                       fk_eto_ofr_id, 
                       eto_pur_date, 
                       fk_glusr_usr_id, 
                       eto_lead_pur_position_url 
                FROM   eto_lead_pur_hist ETO_LEAD_PUR_HIST 
                WHERE  Date(ETO_LEAD_PUR_HIST.eto_pur_date) >= :IN_DATE
                       AND Date(ETO_LEAD_PUR_HIST.eto_pur_date) <= :END_DATE
                       AND fk_eto_ofr_id > 0 
                       AND eto_lead_pur_type = 'B' 
                UNION ALL 
                SELECT eto_lead_pur_id, 
                       eto_credits_used, 
                       eto_lead_pur_mode, 
                       eto_lead_fk_gl_module_id, 
                       fk_eto_ofr_id, 
                       eto_pur_date, 
                       fk_glusr_usr_id, 
                       eto_lead_pur_position_url 
                FROM   iil_lead_pur_hist ETO_LEAD_PUR_HIST 
                WHERE  Date(ETO_LEAD_PUR_HIST.eto_pur_date) >= :IN_DATE
                       AND Date(ETO_LEAD_PUR_HIST.eto_pur_date) <= :END_DATE
                       AND fk_eto_ofr_id > 0 
                       AND eto_lead_pur_type = 'B'
			)ETO_LEAD_PUR_HIST
	) A GROUP  BY To_char(eto_pur_date, 'DD-MON-YYYY')";
$sth = $GlobalmodelForm->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);
    $result = $sth->readAll();
}
return $result;
}

}

?>