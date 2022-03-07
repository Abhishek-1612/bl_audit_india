<?php
class EtoblcomPG extends CFormModel
{
// PG Code
public function dispForm($dbh,$data)
{
    
	 $arr_cust_segment = array();
	 $arr_fc_status = array();
	 $arr_consume = array();
	 $arr_date_slab = array();
	 $arr_av_credit = array();
	 $arr_purpose=array();
         $model = new GlobalmodelForm();
	 $temp;
	 $sql;
	 $sth1;/////////////////5
	$sql="select DISTINCT IIL_CR_CUST_SEGMENT_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());      
        $temp='';
        array_push($arr_cust_segment,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_cust_segment,$temp['IIL_CR_CUST_SEGMENT_DESC']);
        } ##MID's
        ///////////////6
	$sql="select DISTINCT IIL_CR_COM_FC_STATUS_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());       
        $temp='';
        array_push($arr_fc_status,'All');
         while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_fc_status,$temp['IIL_CR_COM_FC_STATUS_DESC']);} ##MID's
        ///////////7
	$sql="select DISTINCT IIL_CR_COM_CONSUME_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());     
	$temp='';
        array_push($arr_consume,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_consume,$temp['IIL_CR_COM_CONSUME_DESC']);} ##MID's
        ///////////8
	$sql="select DISTINCT IIL_CR_COM_DATE_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());     
        $temp='';
        array_push($arr_date_slab,'All');
         while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_date_slab,$temp['IIL_CR_COM_DATE_SLAB_DESC']);} ##MID's
        ///////////9
	$sql="select DISTINCT IIL_CR_AV_CREDIT_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());       
        $temp='';
        array_push($arr_av_credit,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_av_credit,$temp['IIL_CR_AV_CREDIT_SLAB_DESC']);} ##MID's
	///////////10
	$sql="select DISTINCT IIL_CR_COM_PURPOSE from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());     
        $temp='';
        array_push($arr_purpose,'All');
         while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_purpose,$temp['IIL_CR_COM_PURPOSE']);} 
        $mywindow=$data['SERVER_NAME'];
			
	 $CUST_SEGMENT=$data['IIL_CR_CUST_SEGMENT_DESC'];
	 $FC_STATUS=$data['IIL_CR_COM_FC_STATUS_DESC'];
	 $CONSUME=$data['IIL_CR_COM_CONSUME_DESC'];
	 $DATE_SLAB=$data['IIL_CR_COM_DATE_SLAB_DESC'];
	 $AV_CREDIT=$data['IIL_CR_AV_CREDIT_SLAB_DESC'];
	 $PURPOSE=$data['IIL_CR_COM_PURPOSE'];

$rec1=$rec=array();
//if($data['getdata'] && $data['getdata']==1){
//////////////////////////////////
// if($data['getdata']==1)
// {
	$where='';
	 $cnt=1;
	 $class='';
	 $sql='';
      
	$sql.="select IIL_CR_COM_DECISION_ID, IIL_CR_CUST_SEGMENT_DESC, IIL_CR_COM_FC_STATUS_DESC, IIL_CR_COM_CONSUME_DESC, IIL_CR_COM_DATE_SLAB_DESC, IIL_CR_AV_CREDIT_SLAB_DESC, IIL_CR_COM_PURPOSE, M_ID_FULL_BANNER, M_ID_MINI_BANNER, M_ID_EMAIL, M_ID_SMS, M_ID_MAIL_BANNER,M_ID_APP_NOTIFICATION from IIL_CR_COM_DECISION";

	if($CUST_SEGMENT != '' && $CUST_SEGMENT != 'All'){
		if($where != ''){
			$where.=" AND IIL_CR_CUST_SEGMENT_DESC='".$CUST_SEGMENT."'";
		}
		else{
			$where.=" Where IIL_CR_CUST_SEGMENT_DESC='".$CUST_SEGMENT."'";
		}
	}
	if($FC_STATUS != '' && $FC_STATUS != 'All'){
		if($where != ''){
			$where.=" AND IIL_CR_COM_FC_STATUS_DESC='".$FC_STATUS."'";
		}
		else{
			$where.=" Where IIL_CR_COM_FC_STATUS_DESC='".$FC_STATUS."'";
		}
	}
	if($CONSUME != '' && $CONSUME != 'All'){
		if($where != ''){
			$where.=" AND IIL_CR_COM_CONSUME_DESC='".$CONSUME."'";
		}
		else{
			$where.=" Where IIL_CR_COM_CONSUME_DESC='".$CONSUME."'";
		}
	}
	if($DATE_SLAB != '' && $DATE_SLAB != 'All'){
		if($where != ''){
			$where.=" AND IIL_CR_COM_DATE_SLAB_DESC='".$DATE_SLAB."'";
		}
		else{
			$where.=" Where IIL_CR_COM_DATE_SLAB_DESC='".$DATE_SLAB."'";
		}
	}
	if($AV_CREDIT != '' && $AV_CREDIT != 'All'){
	if($where != ''){
			$where.=" AND IIL_CR_AV_CREDIT_SLAB_DESC='".$AV_CREDIT."'";
		}
		else{
			$where.=" Where IIL_CR_AV_CREDIT_SLAB_DESC='".$AV_CREDIT."'";
		}
	}
	if($PURPOSE != '' && $PURPOSE != 'All'){
		if($where != ''){
			$where.=" AND IIL_CR_COM_PURPOSE='".$PURPOSE."'";
		}
		else{
			$where.=" Where IIL_CR_COM_PURPOSE='".$PURPOSE."'";
		}
	}
	
	$sql.=$where;

	$rec = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
        while($temp = $rec->read()) {
            $temp1=array_change_key_case($temp, CASE_UPPER);
            array_push($rec1,$temp1);            
         } 
$result=array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose,'rec1'=>$rec1);

return $result;

return array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose,'rec1'=>$rec1);

}
////////////////
  public function getHtml($dbh,$MSG_ID)
{
       $model = new GlobalmodelForm();
	$sql="select IIL_CR_COM_HTML from IIL_CR_COM_MESSAGE where IIL_CR_COM_MESSAGE_ID=$1 ";
	$params=array($MSG_ID);
        $rec = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());	
	$x=$rec['iil_cr_com_html'];	
	return $x;
}
////////
public function allData($dbh,$data1)
{       
        $model = new GlobalmodelForm();
        $htmlhash=$rec=array();
	$MSG_ID=$data1['mid1'];
	$emp_id=$data1['emp_id'];////////////
	$sql= "select M_ID_FULL_BANNER, M_ID_MINI_BANNER, M_ID_EMAIL, M_ID_SMS, M_ID_MAIL_BANNER,M_ID_APP_NOTIFICATION from IIL_CR_COM_DECISION where IIL_CR_COM_DECISION_ID=:IIL_CR_COM_DECISION_ID";
        $params=array(':IIL_CR_COM_DECISION_ID'=>$MSG_ID);
        $sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $params); 
         while($temp = $sth1->read()) {
            $rec=array_change_key_case($temp, CASE_UPPER);           
         }
	 $ID_FULL=$rec['M_ID_FULL_BANNER'];
        $ID_MINI=$rec['M_ID_MINI_BANNER'];
        $ID_EMAIL=$rec['M_ID_EMAIL'];
        $ID_SMS=$rec['M_ID_SMS'];
        $ID_MAIL=$rec['M_ID_MAIL_BANNER'];
        $ID_APP=$rec['M_ID_APP_NOTIFICATION'];
	
	$sql1="select IIL_CR_COM_HTML,IIL_CR_COM_MESSAGE_ID from IIL_CR_COM_MESSAGE where IIL_CR_COM_MESSAGE_ID IN (:ID_FULL,:ID_MINI,:ID_EMAIL,:ID_SMS,:ID_MAIL,:ID_APP)";
	$params=array(':ID_FULL'=>$ID_FULL,':ID_MINI'=>$ID_MINI,':ID_EMAIL'=>$ID_EMAIL,':ID_SMS'=>$ID_SMS,':ID_MAIL'=>$ID_MAIL,':ID_APP'=>$ID_APP);
	$sth2 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql1, $params); 
         while($rec = $sth2->read()) {
            $data=''; 
            $rec1=array_change_key_case($rec, CASE_UPPER);
            $data=$rec1['IIL_CR_COM_HTML'];	
            $htmlhash[$rec1['IIL_CR_COM_MESSAGE_ID']]= $data;
         }
        // print_r($htmlhash);
        $sql="select IIL_CR_COM_PURPOSE,IIL_CR_COM_MESSAGE_TYPE,IIL_CR_COM_MESSAGE_ID from IIL_CR_COM_MESSAGE";      
        $sth3 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array()); 
        $arr = array(-2);	
        $typehash=array();
	$purposehash=array();
         while($temp1 = $sth3->read()) {
            $temp=array_change_key_case($temp1, CASE_UPPER);
            array_push($arr,$temp['IIL_CR_COM_MESSAGE_ID']);
            $typehash[$temp['IIL_CR_COM_MESSAGE_ID']] = $temp['IIL_CR_COM_MESSAGE_TYPE'];
            $purposehash[$temp['IIL_CR_COM_MESSAGE_ID']] = $temp['IIL_CR_COM_PURPOSE'];
         } 
       array_push($arr,-1);
       sort($arr);       
    $ldata=array('ID_FULL'=>$ID_FULL,'MSG_ID'=>$MSG_ID,'ID_MINI'=>$ID_MINI,'ID_EMAIL'=>$ID_EMAIL,'ID_MAIL'=>$ID_MAIL,'ID_SMS'=>$ID_SMS,'ID_APP'=>$ID_APP,'arr'=>$arr,'typehash'=>$typehash,'purposehash'=>$purposehash,'htmlhash'=>$htmlhash);
	return $ldata; 
//print_r($ldata);die;
   /////////
    }

///////////////////////////
public function updateData($dbh,$data2)
{
         $MSG_ID=$data2['MSG_ID'];
	 $M_ID_FULL=$data2["M_ID_FULL"];
	 $M_ID_MAIL=$data2["M_ID_MAIL"];
	 $M_ID_MINI=$data2["M_ID_MINI"];
	 $M_ID_EMAIL=$data2["M_ID_EMAIL"];
	 $M_ID_SMS=$data2["M_ID_SMS"];
         $M_ID_APP_NOTIFICATION=$data2["M_ID_APP_NOTIFICATION"];
         $emp_id=$data2['emp_id'];

	$param['token']	='imobile1@15061981';
        $param['modid']	='GLADMIN';
        $param['action']='Update';
        $param['DECISION_ID']=$MSG_ID;
                
	if($M_ID_FULL!=0){
		$param['M_ID_FULL_BANNER']=$M_ID_FULL;
	}
	if($M_ID_MAIL!=0){
		$param['M_ID_MAIL_BANNER']=$M_ID_MAIL;
	}
	if($M_ID_MINI!=0){
		$param['M_ID_MINI_BANNER']=$M_ID_MINI;
	}
	if($M_ID_EMAIL!=0){
		$param['M_ID_EMAIL']=$M_ID_EMAIL;
	}
	if($M_ID_SMS!=0){
		$param['M_ID_SMS']=$M_ID_SMS;
	}
	if($M_ID_APP_NOTIFICATION!=0){
		$param['M_ID_APP_NOTIFICATION']=$M_ID_APP_NOTIFICATION;
	}
	if($M_ID_FULL==0 && $M_ID_MAIL==0 && $M_ID_MINI==0 && $M_ID_EMAIL==0 && $M_ID_SMS==0 && $M_ID_APP_NOTIFICATION==0)
	{	
		$data2['updateStatus']='wrong';
		$data1=array('mid'=>$MSG_ID,'emp_id'=>$emp_id,'updateStatus'=>$data2['updateStatus']);
	}
	else{
                $host_name = $_SERVER['SERVER_NAME'];
                $serv_model =new ServiceGlobalModelForm();
                if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net'){
                        $curl = 'http://dev-leads.imutils.com/wservce/glreport/maildecision/';
                        }else{                        
                        $curl = 'http://leads.imutils.com/wservce/glreport/maildecision/';
                        }
        
                $response=$serv_model->mapiService('BLCOMM',$curl,$param,'No'); 
                 if($response['Response']['Code']==200){
                    $data2['updateStatus']='true';
                }else{               
                   $data2['updateStatus']='false';
                }
               $data1=array('mid'=>$MSG_ID,'emp_id'=>$emp_id,'updateStatus'=>$data2['updateStatus']);
	       }    
        if(Yii::app()->session['empid']==3575){
                  print_r($data2);
                echo ' = URL==== '.$curl.'   Input parameter:';print_r($param);
                echo ' =====Output parameter:';print_r($response['Response']);
        }
	$ldata=array('updateStatus'=>$data2['updateStatus']);
        return $ldata;	
}
 public function dispForm_com1($dbh,$data)
{
	 $arr_cust_segment = array();
	 $arr_fc_status = array();
	 $arr_consume = array();
	 $arr_date_slab = array();
	 $arr_av_credit = array();
	 $arr_purpose=array();
          $model = new GlobalmodelForm();
	 ///////////
	 $temp;
	 $sql;
	 $sth1;/////////////////5
	$sql="select DISTINCT IIL_CR_CUST_SEGMENT_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());         
        $temp='';
        array_push($arr_cust_segment,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_cust_segment,$temp['IIL_CR_CUST_SEGMENT_DESC']);} ##MID's
        ///////////////6
	$sql="select DISTINCT IIL_CR_COM_FC_STATUS_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array()); 
        $temp='';
        array_push($arr_fc_status,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_fc_status,$temp['IIL_CR_COM_FC_STATUS_DESC']);} ##MID's
        ///////////7
	$sql="select DISTINCT IIL_CR_COM_CONSUME_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array()); 
       
	$temp='';
        array_push($arr_consume,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_consume,$temp['IIL_CR_COM_CONSUME_DESC']);} ##MID's
        ///////////8
	$sql="select DISTINCT IIL_CR_COM_DATE_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array()); 
      
        $temp='';
        array_push($arr_date_slab,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_date_slab,$temp['IIL_CR_COM_DATE_SLAB_DESC']);} ##MID's
        ///////////9
	$sql="select DISTINCT IIL_CR_AV_CREDIT_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array()); 
       
        array_push($arr_av_credit,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_av_credit,$temp['IIL_CR_AV_CREDIT_SLAB_DESC']);} ##MID's
	///////////10
	$sql="select DISTINCT IIL_CR_COM_PURPOSE from IIL_CR_COM_DECISION";
	$sth1 = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array()); 
       
        $temp='';
        array_push($arr_purpose,'All');
        while($temp = $sth1->read()) {
            $temp=array_change_key_case($temp, CASE_UPPER);
            array_push($arr_purpose,$temp['IIL_CR_COM_PURPOSE']);} ##MID's

	$mywindow=$data['SERVER_NAME'];
	
$result=array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose);

return $result;

return array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose);
}

    }
?>