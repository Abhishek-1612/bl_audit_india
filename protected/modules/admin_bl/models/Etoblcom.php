<?php
class Etoblcom extends CFormModel
{
     public function dispForm($dbh,$data)
{
	 $arr_cust_segment = array();
	 $arr_fc_status = array();
	 $arr_consume = array();
	 $arr_date_slab = array();
	 $arr_av_credit = array();
	 $arr_purpose=array();

	 $temp;
	 $sql;
	 $sth1;/////////////////5
	$sql="select DISTINCT IIL_CR_CUST_SEGMENT_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_cust_segment,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_cust_segment,$temp['IIL_CR_CUST_SEGMENT_DESC']);} ##MID's
        ///////////////6
	$sql="select DISTINCT IIL_CR_COM_FC_STATUS_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_fc_status,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_fc_status,$temp['IIL_CR_COM_FC_STATUS_DESC']);} ##MID's
        ///////////7
	$sql="select DISTINCT IIL_CR_COM_CONSUME_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
	$temp='';
        array_push($arr_consume,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_consume,$temp['IIL_CR_COM_CONSUME_DESC']);} ##MID's
        ///////////8
	$sql="select DISTINCT IIL_CR_COM_DATE_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_date_slab,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_date_slab,$temp['IIL_CR_COM_DATE_SLAB_DESC']);} ##MID's
        ///////////9
	$sql="select DISTINCT IIL_CR_AV_CREDIT_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_av_credit,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_av_credit,$temp['IIL_CR_AV_CREDIT_SLAB_DESC']);} ##MID's
	///////////10
	$sql="select DISTINCT IIL_CR_COM_PURPOSE from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_purpose,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_purpose,$temp['IIL_CR_COM_PURPOSE']);} 
        $mywindow=$data['SERVER_NAME'];
			
	 $CUST_SEGMENT=$data['IIL_CR_CUST_SEGMENT_DESC'];
	 $FC_STATUS=$data['IIL_CR_COM_FC_STATUS_DESC'];
	 $CONSUME=$data['IIL_CR_COM_CONSUME_DESC'];
	 $DATE_SLAB=$data['IIL_CR_COM_DATE_SLAB_DESC'];
	 $AV_CREDIT=$data['IIL_CR_AV_CREDIT_SLAB_DESC'];
	 $PURPOSE=$data['IIL_CR_COM_PURPOSE'];

$rec1=array();
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
        ///////////11
        //echo $sql;die;
	$sth=oci_parse($dbh,$sql);
	oci_execute($sth);

 oci_fetch_all($sth,$rec1);
$result=array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose,'rec1'=>$rec1);

return $result;

return array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose,'rec1'=>$rec1);

}
////////////////
  public function getHtml($dbh,$MSG_ID)
{
	//$MSG_ID=$_REQUEST['msg_id']||0;
	$sql="select IIL_CR_COM_HTML from IIL_CR_COM_MESSAGE where IIL_CR_COM_MESSAGE_ID=:MID ";
	$sth=oci_parse($dbh,$sql);
         oci_bind_by_name($sth,':MID',$MSG_ID);
	oci_execute($sth);
         $rec=oci_fetch_assoc($sth);
	/*echo "Content-type: text/html\n\n";
	echo "$rec['IIL_CR_COM_HTML']";
	*/
	$x=$rec['IIL_CR_COM_HTML']->read(10000);
	//echo $x;
	return $x;
}
////////
public function allData($dbh,$data1)
{       
	$MSG_ID=$data1['mid1'];
	$emp_id=$data1['emp_id'];////////////
	$sql= "select M_ID_FULL_BANNER, M_ID_MINI_BANNER, M_ID_EMAIL, M_ID_SMS, M_ID_MAIL_BANNER,M_ID_APP_NOTIFICATION from IIL_CR_COM_DECISION where IIL_CR_COM_DECISION_ID=:MID";
       /////////////1
       $sth=oci_parse($dbh,$sql);
        oci_bind_by_name($sth,':MID',$MSG_ID);
	oci_execute($sth);
	$rec=oci_fetch_assoc($sth); 
	//var_dump($rec);
        $ID_FULL=$rec['M_ID_FULL_BANNER'];
        $ID_MINI=$rec['M_ID_MINI_BANNER'];
        $ID_EMAIL=$rec['M_ID_EMAIL'];
        $ID_SMS=$rec['M_ID_SMS'];
        $ID_MAIL=$rec['M_ID_MAIL_BANNER'];
        $ID_APP=$rec['M_ID_APP_NOTIFICATION'];

	//$msg="$ID_FULL,$ID_MINI,$ID_EMAIL,$ID_SMS,$ID_MAIL,$ID_APP";
	//echo $ID_FULL.'  fgfg  '.$ID_MINI.' gdfs   '.$ID_EMAIL.'  sdgds  '.$ID_SMS.' sdgsg   '.$ID_MAIL.'  agag  '.$ID_APP.'adasdfiojhasfio';
	//echo $msg;
	
	if($data1['updateStatus']){
		//echo "Content-type: text/html\n\n";
	}
	
	
	$sql1="select IIL_CR_COM_HTML,IIL_CR_COM_MESSAGE_ID from IIL_CR_COM_MESSAGE where IIL_CR_COM_MESSAGE_ID IN (:ID_FULL,:ID_MINI,:ID_EMAIL,:ID_SMS,:ID_MAIL,:ID_APP)";
	////////////////2
	$sth2=oci_parse($dbh,$sql1);
	oci_bind_by_name($sth2,':ID_FULL',$ID_FULL);
	oci_bind_by_name($sth2,':ID_MINI',$ID_MINI);
	oci_bind_by_name($sth2,':ID_EMAIL',$ID_EMAIL);
	oci_bind_by_name($sth2,':ID_SMS',$ID_SMS);
	oci_bind_by_name($sth2,':ID_MAIL',$ID_MAIL);
	oci_bind_by_name($sth2,':ID_APP',$ID_APP);
         oci_execute($sth2);
        //$rec1 = '';
	$htmlhash=array();
	//$rec1=oci_fetch_assoc($sth2);
	while($rec1=oci_fetch_assoc($sth2))
	{//echo "inside";
	$data=''; 
	//echo $rec1['IIL_CR_COM_MESSAGE_ID'];
	 //echo stream_get_line($rec1['IIL_CR_COM_HTML'],4096);
		//$htmlhash[$rec1['IIL_CR_COM_MESSAGE_ID']]=$rec1['IIL_CR_COM_HTML'];
		    $data=$rec1['IIL_CR_COM_HTML']->read(10000);
	
		$htmlhash[$rec1['IIL_CR_COM_MESSAGE_ID']]= $data;
		//echo $data;
	}
	 
       $sql="select IIL_CR_COM_PURPOSE,IIL_CR_COM_MESSAGE_TYPE,IIL_CR_COM_MESSAGE_ID from IIL_CR_COM_MESSAGE";
       ////////////////3
       $sth1=oci_parse($dbh,$sql);
       oci_execute($sth1);
        $arr = array(-2);
	$temp;
        $typehash=array();
	$purposehash=array();
       
       while($temp=oci_fetch_assoc($sth1))
       {
         array_push($arr,$temp['IIL_CR_COM_MESSAGE_ID']);
         $typehash[$temp['IIL_CR_COM_MESSAGE_ID']] = $temp['IIL_CR_COM_MESSAGE_TYPE'];
         $purposehash[$temp['IIL_CR_COM_MESSAGE_ID']] = $temp['IIL_CR_COM_PURPOSE'];
       }
       array_push($arr,-1);
               sort($arr);
       
 $ldata=array('ID_FULL'=>$ID_FULL,'MSG_ID'=>$MSG_ID,'ID_MINI'=>$ID_MINI,'ID_EMAIL'=>$ID_EMAIL,'ID_MAIL'=>$ID_MAIL,'ID_SMS'=>$ID_SMS,'ID_APP'=>$ID_APP,'arr'=>$arr,'typehash'=>$typehash,'purposehash'=>$purposehash,'htmlhash'=>$htmlhash);
	return $ldata; 

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

	$sql= "update IIL_CR_COM_DECISION set ";
	if($M_ID_FULL!=0){
		if($M_ID_FULL==-999){$sql .="M_ID_FULL_BANNER=NULL ,";}
		else{$sql .="M_ID_FULL_BANNER=$M_ID_FULL ,";}
	}
	if($M_ID_MAIL!=0){
		if($M_ID_MAIL==-999){$sql .="M_ID_MAIL_BANNER=NULL ,";}
		else{$sql .="M_ID_MAIL_BANNER=$M_ID_MAIL ,";}
	}
	if($M_ID_MINI!=0){
		if($M_ID_MINI==-999){$sql .="M_ID_MINI_BANNER=NULL ,";}
		else{$sql .="M_ID_MINI_BANNER=$M_ID_MINI ,";}
	}
	if($M_ID_EMAIL!=0){
		if($M_ID_EMAIL==-999){$sql .="M_ID_EMAIL=NULL ,";}
		else{$sql .="M_ID_EMAIL=$M_ID_EMAIL ,";}
	}
	if($M_ID_SMS!=0){
		if($M_ID_SMS==-999){$sql .="M_ID_SMS=NULL ,";}
		else{$sql .="M_ID_SMS=$M_ID_SMS ,";}
	}
	if($M_ID_APP_NOTIFICATION!=0){
		if($M_ID_APP_NOTIFICATION==-999){$sql .="M_ID_APP_NOTIFICATION=NULL ,";}
		else{$sql .="M_ID_APP_NOTIFICATION=$M_ID_APP_NOTIFICATION ,";}
	}
	//$sql =~ s/,$//;/////////////////////
	
	$sql=preg_replace('/,$/','',$sql);
        $sql .=" where IIL_CR_COM_DECISION_ID=:ID";
	$sql_pg .=" where IIL_CR_COM_DECISION_ID=$1";
        
	if($M_ID_FULL==0 && $M_ID_MAIL==0 && $M_ID_MINI==0 && $M_ID_EMAIL==0 && $M_ID_SMS==0 && $M_ID_APP_NOTIFICATION==0)
	{	
		$data2['updateStatus']='wrong';
		$data1=array('mid'=>$MSG_ID,'emp_id'=>$emp_id,'updateStatus'=>$data2['updateStatus']);		
	}
	else{
               $sth=oci_parse($dbh,$sql);       
               oci_bind_by_name($sth,':ID',$MSG_ID);
                if(oci_execute($sth)){                    
                    $data2['updateStatus']='true';                  
	        }
	       else{
		$data2['updateStatus']='false';
	         }
               $data1=array('mid'=>$MSG_ID,'emp_id'=>$emp_id,'updateStatus'=>$data2['updateStatus']);	
 	        }	
	$ldata=array('updateStatus'=>$data2['updateStatus']);
	return $ldata;

	
}

 public function dispForm_com1($dbh,$data)
{
	
	//echo "Content-type:text/html\n\n";
	 $arr_cust_segment = array();
	 $arr_fc_status = array();
	 $arr_consume = array();
	 $arr_date_slab = array();
	 $arr_av_credit = array();
	 $arr_purpose=array();
	 ///////////
	 $temp;
	 $sql;
	 $sth1;/////////////////5
	$sql="select DISTINCT IIL_CR_CUST_SEGMENT_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_cust_segment,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_cust_segment,$temp['IIL_CR_CUST_SEGMENT_DESC']);} ##MID's
        ///////////////6
	$sql="select DISTINCT IIL_CR_COM_FC_STATUS_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_fc_status,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_fc_status,$temp['IIL_CR_COM_FC_STATUS_DESC']);} ##MID's
        ///////////7
	$sql="select DISTINCT IIL_CR_COM_CONSUME_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
	$temp='';
        array_push($arr_consume,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_consume,$temp['IIL_CR_COM_CONSUME_DESC']);} ##MID's
        ///////////8
	$sql="select DISTINCT IIL_CR_COM_DATE_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_date_slab,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_date_slab,$temp['IIL_CR_COM_DATE_SLAB_DESC']);} ##MID's
        ///////////9
	$sql="select DISTINCT IIL_CR_AV_CREDIT_SLAB_DESC from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_av_credit,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_av_credit,$temp['IIL_CR_AV_CREDIT_SLAB_DESC']);} ##MID's
	///////////10
	$sql="select DISTINCT IIL_CR_COM_PURPOSE from IIL_CR_COM_DECISION";
	$sth1=oci_parse($dbh,$sql);
        oci_execute($sth1);
        $temp='';
        array_push($arr_purpose,'All');
        while(($temp=oci_fetch_assoc($sth1))!=false){array_push($arr_purpose,$temp['IIL_CR_COM_PURPOSE']);} ##MID's


$result=array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose);

return $result;

return array('mywindow'=>$mywindow,'arr_cust_segment'=>$arr_cust_segment,'arr_fc_status'=>$arr_fc_status,'arr_consume'=>$arr_consume,'arr_date_slab'=>$arr_date_slab,'arr_av_credit'=>$arr_av_credit,'arr_purpose'=>$arr_purpose);
}


    }
?>
