<?php
class Langmodel extends CFormModel
{
    public function show_data(){
        $empId = $_REQUEST["emp_id"];        
       $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }           
        $empDet=array();
        if(!empty($empId) && $dbh && is_numeric($empId)){
                $sql ="SELECT ETO_LEAP_EMP_ID,eto_leap_emp_name,eto_leap_mis_language_id ,fk_gl_language_id ,language_priority"
                        . " FROM ETO_LEAP_MIS left outer join eto_leap_mis_languages  on ETO_LEAP_EMP_ID= Fk_ETO_LEAP_EMP_ID WHERE ETO_LEAP_EMP_ID = :EMP_ID";
                $bind[':EMP_ID']=$empId; 
                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql;        
                while($rec = $sth->read()) {
                        array_push($empDet,$rec);
                   }
                }
    return $empDet;
}
public function save_data($request)
    {
        $errormessage=$message=$code=$URL='';
        $serv_model =new ServiceGlobalModelForm();
        $param['token']	='imobile1@15061981';
        $param['modid']	='GLADMIN';
        $emp_id =isset($_REQUEST['fk_eto_leap_emp_id'])?$_REQUEST['fk_eto_leap_emp_id']:0;    
if($emp_id >0){
        $param['glusrid']=$emp_id;
	$invoice_array= $_REQUEST['emp_lang_list']; 
        $invoice_array=json_decode($invoice_array,true);
	$param['emp_lang_list']	= json_encode($invoice_array);
            $host_name = $_SERVER['SERVER_NAME'];
            if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
                $URL = 'http://dev-leads.imutils.com/wservce/glreport/elm_language/';
            } else {
                $URL = 'http://leads.imutils.com/wservce/glreport/elm_language/';
            }
 
           // echo $URL;print_r($param);


            $resp = $serv_model->mapiService('LEAPMIS',$URL,$param,'No'); 
            $response=isset($resp['Response'])?$resp['Response']:array();
            $code=isset($response["Code"])?$response["Code"]:'';
            //print_r($response);
//print_r($response);
            $message=isset($response["Message"])?$response["Message"]:'';
            if($code==200){
               $errormessage ='<span style="color:green;">Suceessfully Updated</span>';
               }else{
               $errormessage ='<span style="color:red;">'.$message.'</span>';
               }
}else{
    $errormessage ='<span style="color:red;">Please Login again</span>';
}
           

     return $errormessage;
  }
   
}