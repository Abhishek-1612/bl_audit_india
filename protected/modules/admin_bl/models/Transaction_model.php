<?php
error_reporting(1);
class Transaction_model extends CFormModel
{
     public function getUserDetailsEmail($usr)
    {
         $usr=strtoupper($usr);
        $global_model=new GlobalmodelForm();
        $objcon = new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $objcon->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $objcon->connect_db_yii('postgress_web68v'); 
        }                                
        
        $hash      = array();
        
        $sql = "SELECT  GLUSR_USR_ID GLID,           
                GLUSR_USR_FIRSTNAME FIRST_NAME,
                GLUSR_USR_LASTNAME LAST_NAME,
                GLUSR_USR_EMAIL EMAIL1,
                GLUSR_USR_COMPANYNAME COMPANY_NAME,
                GLUSR_USR_ADD1 ADD1,
                GLUSR_USR_ADD2 ADD2,
                GLUSR_USR_CITY CITY,
                GLUSR_USR_STATE STATE,
                GLUSR_USR_COUNTRYNAME COUNTRY,
                GLUSR_USR_PH_COUNTRY ,
                GLUSR_USR_PH_AREA  ,
                GLUSR_USR_PH_NUMBER  ,
                GLUSR_USR_PH_MOBILE MOBILE1 ,
                GLUSR_USR_FAX_COUNTRY  ,
                GLUSR_USR_FAX_AREA  ,
                GLUSR_USR_FAX_NUMBER  ,           
                GLUSR_USR_APPROV  ,  
                COALESCE(PAIDSHOWROOM_URL,FREESHOWROOM_URL) PAIDURL ,
                GLUSR_USR_COUNTRYNAME COUNTRY_NAME,
                GLUSR_USR_CUSTTYPE_NAME                  
            FROM GLUSR_USR WHERE GLUSR_USR_EMAIL_DUP='$usr' limit 1";          
        
        $sth = $global_model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
        if ($sth) {
            $hash        = $sth->read();
            if(!empty($hash)) {
            $hash=array_change_key_case($hash,CASE_UPPER);
            }
        }
        return $hash;
    }
    
    public function transDetails($userID,$email,$year,$ondemand)
    {       
        $str=$phone=$fax=$ph_no=$loginUserDet =$company=$name=$address=$city=$state=$country=$phone=$fax_no=$fax=$mobile=$ph_country=$approv=$url=$custtype='';
        if($ondemand==''){
                if($userID)
                {
                    $glmodel= new GlobalmodelForm();
                    $loginUserDet = $glmodel->get_glusr_detail($userID);         
                }
                elseif(isset($email))
                {
                    $loginUserDet=$this->getUserDetailsEmail($email);           
                    if(isset($loginUserDet['GLID']))
                    {
                        $userID = $loginUserDet['GLID'];
                    }
                    else
                    {
                        $userID=0;
                    }
                }
               //   echo '<pre>';print_r($loginUserDet);  echo '</pre>';     // die;       
                $email = isset($loginUserDet['EMAIL1'])?$loginUserDet['EMAIL1']:'';
                $company = isset($loginUserDet['COMPANY_NAME'])?$loginUserDet['COMPANY_NAME']:'';
                $fname=isset($loginUserDet['FIRST_NAME'])?$loginUserDet['FIRST_NAME']:'';
                $lastname=isset($loginUserDet['LAST_NAME'])?$loginUserDet['LAST_NAME']:'';
                $name = $fname.' '.$lastname;
                $address =isset($loginUserDet['ADD1'])?$loginUserDet['ADD1']:''; 
                $country = isset($loginUserDet['COUNTRY'])?$loginUserDet['COUNTRY']:'';
                $city =isset($loginUserDet['CITY'])?$loginUserDet['CITY']:'';
                $state =isset($loginUserDet['STATE'])?$loginUserDet['STATE']:'';
                $ph_country =isset($loginUserDet['GLUSR_USR_PH_COUNTRY'])?$loginUserDet['GLUSR_USR_PH_COUNTRY']:'';
                $mobile = isset($loginUserDet['MOBILE1'])?$loginUserDet['MOBILE1']:'';
                $fax_country =isset($loginUserDet['GLUSR_USR_FAX_COUNTRY'])?$loginUserDet['GLUSR_USR_FAX_COUNTRY']:'';
                $fax_area =isset($loginUserDet['GLUSR_USR_FAX_AREA'])?$loginUserDet['GLUSR_USR_FAX_AREA']:'';
                $fax_no = isset($loginUserDet['GLUSR_USR_FAX_NUMBER'])?$loginUserDet['GLUSR_USR_FAX_NUMBER']:'';
                $fax = "($fax_country)";
                if($fax_area)
                {
                    $fax .="-($fax_area)";
                }       
                $fax .="-$fax_no";
                
$glid =isset($_REQUEST['glusrid']) ? $_REQUEST['glusrid']:'';                
if($glid){
    $phone=isset($loginUserDet['TELEPHONE1'])?$loginUserDet['TELEPHONE1']:'';   
}else{    
    $ph_area =isset($loginUserDet['GLUSR_USR_PH_AREA'])?$loginUserDet['GLUSR_USR_PH_AREA']:''; 
    $ph_no =isset($loginUserDet['GLUSR_USR_PH_NUMBER'])?$loginUserDet['GLUSR_USR_PH_NUMBER']:'';
    $ph_country =isset($loginUserDet['GLUSR_USR_PH_COUNTRY'])?$loginUserDet['GLUSR_USR_PH_COUNTRY']:''; 
    if($ph_no)
    {
        $phone = "($ph_country)";
        $phone .="-($ph_area)";
        $phone .="-$ph_no";
    } 
   
    $mobile ="($ph_country)-$mobile";
}        
               
        
        $approv =isset($loginUserDet['GLUSR_USR_APPROV'])?$loginUserDet['GLUSR_USR_APPROV']:'';
        $url = isset($loginUserDet['PAIDURL'])?$loginUserDet['PAIDURL']:'';              
        $custtype =isset($loginUserDet['GLUSR_USR_CUSTTYPE_NAME'])?$loginUserDet['GLUSR_USR_CUSTTYPE_NAME']:'';
        }
        $ctype =isset($_REQUEST['ctype']) ? $_REQUEST['ctype']:'';
if($ctype=='F'){
            $content = array(
                'token' =>'imobile@15061981','modid' =>'GLADMIN','glusrid' => $userID,'current_detail'=>1,'foreign'=>1,'year' => $year);       
}else{
            $content = array(
                'token' =>'imobile@15061981',
                'modid' =>'GLADMIN','glusrid' => $userID,'current_detail'=>1,
                'year' => $year 
                );  
}
              
     	$req = ($_SERVER['SERVER_NAME'] == 'gladmin.intermesh.net') ? 'https://leads.imutils.com/wservce/buyleads/transactionhistory/':'http://dev-mapi.indiamart.com/wservce/buyleads/transactionhistory/';
        $data_string = http_build_query($content);
	$ServiceGlobalModelForm = new ServiceGlobalModelForm();
	$response = $ServiceGlobalModelForm->mapiService('ACOUNTLEDGER',$req,$data_string,'No');	
		$arr=array();
		if (is_array($response))
		{
			$arr=isset($response['RESPONSE']['DATA']) ? $response['RESPONSE']['DATA'] : '';  
		} 
        //$serviceUrl = "http://mapi.indiamart.com/wservce/buyleads/transactionhistory/?token=imobile@15061981&current_detail=1&modid=GLADMIN&glusrid=$userID&year=$year&AK=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIzNTc1IiwiZXhwIjoxNTU2MDE2OTc4LCJpYXQiOjE1NTU5MzA1NzgsImlzcyI6IkVNUExPWUVFIn0.i22oam3GtTvKDM_jIGptZW1TMj8zq_gUIihWvMPFFt4";
      return array($arr,$userID,$company,$name,$address,$city,$state,$country,$phone,$fax_no,$fax,$mobile,$ph_country,$approv,'',0,'',$email,0,$url,$custtype);
    }       
  public function purchaseDetailsviaemail($dbh,$email1,$page_no,$start,$end)
  { 
  $email=strtoupper($email1);
  $html='';
  $html2='';
   $c=0;
   $obj = new Globalconnection();   
   $model = new GlobalmodelForm();

  if($email)
  {
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        } 
    $sql = "SELECT GLUSR_USR_ID FROM GLUSR_USR WHERE GLUSR_USR_EMAIL_DUP = :EMAIL";
   $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(":EMAIL"=>$email));
   $c=1;
   $p=2;
    $rec  = $sth->read();
    $glusr_id = $rec['glusr_usr_id'];
    $flag='viaemailid';  
  
   list($html1,$p,$offer_size)=$this->rfq_service($glusr_id,$start,$end);  
   $pageNext=$page_no+1;
   $pagePre=$page_no-1;
   if(!$html1)
{
$html2 .=$html1;
if($page_no)
{
$html2 .='<div style="font-family:arial;font-size:18px;font-weight:bold;padding:3px;text-align:right;"><a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_email&email1='.$email1.'&page='.$pagePre.'&mid=3442">< Previous</a></div>';
}
}
else
{  $html2 .='<div style="font-family:arial;font-size:18px;font-weight:bold;padding:3px;text-align:right;">';
  
   if($page_no)
   {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_email&email1='.$email1.'&page='.$pagePre.'&mid=3442">< Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;';
   }
    if($offer_size==20)
   {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_email&email1='.$email1.'&page='.$pageNext.'&mid=3442">Next > </a>';
   }
   $html2 .='</div>';
    $html2 .=$html1;
    
    
   $html2 .='<div style="font-family:arial;font-size:18px;font-weight:bold;padding:3px;text-align:right;">';
  
   if($page_no)
   {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_email&email1='.$email1.'&page='.$pagePre.'&mid=3442">< Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;';
   }
    if($offer_size==20)
   {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_email&email1='.$email1.'&page='.$pageNext.'&mid=3442">Next > </a>';
   }
   $html2 .='</div>';
   }
    return array($html2,$p)  ;
    }
        
  }
  
  public function phpurchaseDetails($dbh,$phonewise,$phcountry,$page_no,$start,$end)
  { 
  $phonewise=strtoupper($phonewise);
  $html='';
  $html2='';
   $c=0;$html1='';$p=0;$offer_size=0;
  if($phonewise)
  {
        $obj = new Globalconnection();   
        $model = new GlobalmodelForm();

        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        } 
      if(is_numeric($phonewise)){
        if($phcountry=='India')
        $sql = "SELECT GLUSR_USR_ID FROM GLUSR_USR WHERE  GLUSR_USR_PH_MOBILE = '$phonewise' AND GLUSR_USR_PH_COUNTRY='91' ";
        else
        $sql = "SELECT GLUSR_USR_ID FROM GLUSR_USR WHERE  GLUSR_USR_PH_MOBILE = '$phonewise AND GLUSR_USR_PH_COUNTRY<>'91' ";
        $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
        $p=1;
        $rec  = $sth->read();
        $glusr_id = $rec['glusr_usr_id'];
        $flag='viaemailid';

        list($html1,$p,$offer_size)=$this->rfq_service($glusr_id,$start,$end);  
    }else{
         echo  "Invalid Mobile Number";
          die;
    }
    $pageNext=$page_no+1;
   $pagePre=$page_no-1;
   if(!$html1)
{
$html2=$html1;
 if($page_no)
 {
 $html2 .='<div style="font-family:arial;font-size:18px;font-weight:bold;padding:3px;text-align:right;"><a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_ph&phonewise='.$phonewise.'&phcountry='.$phcountry.'&page='.$pagePre.'&mid=3442">< Previous</a></div>';
 }
}
else
{
$html2 .='<div style="font-family:arial;font-size:18px;font-weight:bold;padding:3px;text-align:right;">';
  
   if($page_no)
   {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_ph&phonewise='.$phonewise.'&phcountry='.$phcountry.'&page='.$pagePre.'&mid=3442">< Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;';
   }
  
  if($offer_size ==20)
  {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_ph&phonewise='.$phonewise.'&phcountry='.$phcountry.'&page='.$pageNext.'&mid=3442">Next > </a>';
   }
  
   $html2 .='</div>';
    $html2 .=$html1;
    
 $html2 .='<div style="font-family:arial;font-size:18px;font-weight:bold;padding:3px;text-align:right;">';
  
   if($page_no)
   {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_ph&phonewise='.$phonewise.'&phcountry='.$phcountry.'&page='.$pagePre.'&mid=3442">< Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;';
   }
  
  if($offer_size ==20)
  {
   $html2 .='<a style="text-decoration: none;" href="index.php?r=admin_bl/Transaction_report/Index&action=purchasers_ph&phonewise='.$phonewise.'&phcountry='.$phcountry.'&page='.$pageNext.'&mid=3442">Next > </a>';
   }
  
   $html2 .='</div>';   
    
   }
 
     return array($html2,$p)  ;   
      }
   }


  

public function removeUnwantedInfo($str)
{

	//$str =~ s/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)//ig; # removing Anchor Tags
	$str = preg_replace('/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)/', '',$str);
	//$str =~ s/(<\s*img\b.*?\s*>)//ig; # removing IMG Tags
	$str = preg_replace('/(<\s*img\b.*?\s*>)/', '',$str);
	//$str =~ s/(http|www)(.*?)(\s+?|$)//ig;
	$str = preg_replace('/(http|www)(.*?)(\s+?|$)/', '',$str);
	//$str =~ s/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)//ig;
	$str = preg_replace('/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)/', '',$str);
	return ($str);
} 
public function GetPurchaseDetails_OldData($dbh,$offerid,$flag)
        {
    $completedata=array();
        $obj = new Globalconnection();	
        $model = new GlobalmodelForm();	
      											
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))	
        {	
            $dbh = $obj->connect_db_yii('postgress_web68v');   	
        }else{	
            $dbh = $obj->connect_db_yii('postgress_web68v'); 	
        }

   if($dbh){
$sql .= "SELECT
'B' AS TYPE,2 STATUS,ETO_OFR_DISPLAY_ID ETO_OFR_ID, ETO_OFR_TITLE, TO_CHAR(ETO_OFR_DATE,'dd-mm-yyyy')AS OFFER_DATE,
TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'YYYYMMDDHH24MISS') AS PUR_DATE, ETO_UNSOLD_LEADS_REC_DATE, ETO_OFR_EXPIRED.ETO_OFR_DESC, TRIM(ETO_OFR_EXPIRED.ETO_OFR_QTY) ETO_OFR_QTY, ETO_OFR_EXPIRED.ETO_OFR_QTY_UNIT,
TRIM(ETO_OFR_PAY_TERM) ETO_OFR_PAY_TERM, TRIM(ETO_OFR_SUPPLY_TERM) ETO_OFR_SUPPLY_TERM, ETO_OFR_EXPIRED.ETO_OFR_S_IP, ETO_OFR_EXPIRED.ETO_OFR_S_IP_COUNTRY,
(CASE WHEN ETO_OFR_EXPIRED.FK_GL_MODULE_ID='ETO' then 'http://trade.indiamart.com/' else ETO_OFR_EXPIRED.ETO_OFR_PAGE_REFERRER end) ETO_OFR_PAGE_REFERRER, 0 AS EXPIRED,
(GLUSR_USR_FIRSTNAME || ' ' || GLUSR_USR_LASTNAME) GLUSR_NAME,
 ('+' || glusr_usr_ph_country || '-' || glusr_usr_ph_area || '-' || GLUSR_USR_PH_NUMBER) GLUSR_PHONE, 
 ('+' || GLUSR_USR_FAX_COUNTRY || '-' || GLUSR_USR_FAX_AREA || '-' || GLUSR_USR_FAX_NUMBER) GLUSR_FAX, 
GLUSR_USR_FAX_NUMBER GLUSR_USR_FAX_NUMBER,
 GLUSR_USR_PH_MOBILE GLUSR_MOBILE, GLUSR_USR_URL ETO_OFR_GLUSR_DISP_URL, GLUSR_USR_IM_GSM PNS_NUMBER,
LTRIM(GLUSR_USR_COMPANYNAME) GLUSR_COMPANY, LTRIM(GLUSR_USR_CITY) GLUSR_CITY, LTRIM(GL_COUNTRY_NAME) GLUSR_COUNTRY, LTRIM(GLUSR_USR_ADD1) GLUSR_ADDRESS, GLUSR_USR_EMAIL, GLUSR_USR_PH_COUNTRY,
GLUSR_USR_PH_MOBILE_ALT, LTRIM(GLUSR_USR_ZIP) GLUSR_ZIP, LTRIM(GLUSR_USR_STATE) GLUSR_STATE, LTRIM(GLUSR_USR_DESIGNATION) GLUSR_DESIGNATION, 0 ETO_CREDITS_USED,
ETO_UNSOLD_LEADS_ARCH.ETO_UNSOLD_LEADS_SUP_ID FK_GLUSR_USR_ID, 'Live' ETO_OFR_STATUS, NULL ETO_OFR_PREFERED_FK_GLUSR_ID,
(case when ETO_UNSOLD_DAY>1 then 'Proc-ASTBUY' when ETO_UNSOLD_DAY=1 then 'Regular-ASTBUY' when ETO_UNSOLD_DAY=0 then 'Instant-ASTBUY' when ETO_UNSOLD_DAY=-1 then 'Proc-ASTBUY' when ETO_UNSOLD_DAY=-2 then 'PTT-ASTBUY' when ETO_UNSOLD_DAY=-3 then 'Expired-ASTBUY' when ETO_UNSOLD_DAY=-4 then 'Bl Auto-ASTBUY' end) FK_GL_MODULE_ID,(SELECT (SUM(ETO_CUST_PURCHASE_AMOUNTPAID)/SUM(ETO_CUST_PURCHASE_CREDITS)) FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.FK_GLUSR_USR_ID = ETO_UNSOLD_LEADS_ARCH.ETO_UNSOLD_LEADS_SUP_ID AND P_H.ETO_CUST_ORDER_ID > -1 )
AVG_PER_CREDIT_COST, coalesce( (SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 
AND P_H.FK_GLUSR_USR_ID = ETO_UNSOLD_LEADS_ARCH.ETO_UNSOLD_LEADS_SUP_ID limit 1 ),2)
GLUSR_STATUS, ETO_OFR_EXPIRED.FK_GLUSR_USR_ID BUYER_ID, 0 PREFERRED_STATUS, ETO_OFR_EXPIRED.FK_GL_MODULE_ID ETO_MODULE_ID,NULL PURCHASED_ID,GLUSR_USR.FK_GL_COUNTRY_ISO,GLUSR_USR_CUSTTYPE_WEIGHT,PAIDSHOWROOM_URL,GLUSR_USR_URL,GLUSR_USR_IM_GSM,FREESHOWROOM_URL,
ETO_UNSOLD_RELAX_FLAG
FROM
ETO_OFR_EXPIRED,ETO_UNSOLD_LEADS_ARCH,GLUSR_USR,GL_COUNTRY
WHERE
ETO_OFR_TYP = 'B' AND FK_ETO_OFR_DISPLAY_ID = $offerid
AND ETO_UNSOLD_LEADS_ARCH.FK_ETO_OFR_DISPLAY_ID =ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID
AND ETO_UNSOLD_LEADS_ARCH.ETO_UNSOLD_LEADS_SUP_ID =GLUSR_USR.GLUSR_USR_ID
AND GLUSR_USR.FK_GL_COUNTRY_ISO = GL_COUNTRY.GL_COUNTRY_ISO
AND ETO_UNSOLD_LEADS_ARCH.ETO_UNSOLD_LEADS_SUP_ID IS NOT NULL ORDER BY ETO_OFR_ID DESC 
";	
		$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());	
	        $completedata['SUPPLIER_DETAIL']=array();        
                while($rec1= $sth->read()) {
                        $data = array();
                        $rec=array_change_key_case($rec1, CASE_UPPER);                     
                        $data['FK_GLUSR_USR_ID']=$rec['FK_GLUSR_USR_ID'];
                        $data['GLUSR_NAME']=$rec['GLUSR_NAME'];
                        $data['GLUSR_COMPANY']=$rec['GLUSR_COMPANY'];
                        $data['GLUSR_DESIGNATION']=$rec['GLUSR_DESIGNATION'];
                        $data['GLUSR_ADDRESS']=$rec['GLUSR_ADDRESS'];
                        $data['GLUSR_CITY']=$rec['GLUSR_CITY'];
                        $data['GLUSR_STATE']=$rec['GLUSR_STATE'];
                        $data['GLUSR_COUNTRY']=$rec['GLUSR_COUNTRY'];
                        $data['GLUSR_USR_PH_COUNTRY']=$rec['GLUSR_USR_PH_COUNTRY'];
                        $data['GLUSR_MOBILE']=$rec['GLUSR_MOBILE'];
                        $data['GLUSR_ZIP']=$rec['GLUSR_ZIP'];
                        $data['GLUSR_USR_EMAIL']=$rec['GLUSR_USR_EMAIL'];
                        $data['GLUSR_USR_EMAIL']=$rec['GLUSR_USR_EMAIL'];
                        $data['GLUSR_USR_URL']=$rec['GLUSR_USR_URL'];
                        $data['FK_GL_COUNTRY_ISO']=$rec['FK_GL_COUNTRY_ISO'];
                        $data['ETO_LEAD_FK_GL_MODULE_ID']=$rec['FK_GL_MODULE_ID'];
                        $data['GLUSR_USR_CUSTTYPE_WEIGHT']=$rec['GLUSR_USR_CUSTTYPE_WEIGHT'];
                        $data['GLUSR_PHONE']=$rec['GLUSR_PHONE'];
                        $data['ETO_CREDITS_USED']=$rec['ETO_CREDITS_USED'];
                        $data['PUR_DATE']=$rec['PUR_DATE'];      
                        $data['PAIDSHOWROOM_URL']=$rec['PAIDSHOWROOM_URL'];
                        $data['FREESHOWROOM_URL']=$rec['FREESHOWROOM_URL'];
                        $data['TYPE']=$rec['TYPE'];
                        $data['AVG_PER_CREDIT_COST']=$rec['AVG_PER_CREDIT_COST'];
                        array_push($completedata['SUPPLIER_DETAIL'],$data);
                }
   }
		return $completedata; 
        }
	public function purchaseDetails($dbh,$offer,$flag,$is_oldData)
	{ 
		if(isset($_SERVER['SERVER_NAME']) && (($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net')))
		{
			$req="http://dev-mapi.indiamart.com/wservce/buyleads/detail/token/imobile@15061981/modid/GLADMIN/start/1/end/10/type/Q/supplier_info/YES/offer/$offer/attachment/1/buyer_response/1/quotation/1/";  
		}
		else
		{
			$req="http://mapi.indiamart.com/wservce/buyleads/detail/token/imobile@15061981/modid/GLADMIN/start/1/end/10/type/Q/supplier_info/YES/offer/$offer/attachment/1/buyer_response/1/quotation/1/";  
		}
		$arr=array();
		$msg = '';
		$ServiceGlobalModelForm = new ServiceGlobalModelForm();
		if(isset($_SERVER['SERVER_NAME']) && (($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net')))
		{
			$auth_key = isset(Yii::app()->session['auth_key']) ? Yii::app()->session['auth_key'] : '';
			$data['AK'] = $auth_key;
			$data = json_encode($data);
			$cSession = curl_init();
			curl_setopt($cSession, CURLOPT_URL, $req);
			curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($cSession, CURLOPT_HEADER, false);	
			curl_setopt($cSession, CURLOPT_POSTFIELDS, $data); 
			$response1 = curl_exec($cSession);
			$curl_info = curl_getinfo($cSession);
			$response = json_decode($response1, true);
		}
		else
		{
			$response = $ServiceGlobalModelForm->mapiService('BUYLEADDETAIL',$req,array());
		}
                $emp_id = Yii::app()->session['empid'];
               // if($emp_id==86777){
              //     echo 'url:'.$req.'<pre>';print_r($response);echo '</pre>';
              //  }

		if (!is_array($response)) {
			$msg = "Mapi Server Connectivity Issue\n\n Service URL:-$req";
			mail("gladmin-team@indiamart.com","BUYLEADDETAIL Service Failed",$msg);
			die;
		} 
		else
		{          
			$code =isset($response['RESPONSE']['CODE'])?$response['RESPONSE']['CODE']:'';
			if($code != 200)
			{
				$msg =isset($response['RESPONSE']['MESSAGE'])?$response['RESPONSE']['MESSAGE']:'';
				echo  $msg;
				die;
			}
			else
			{
				if(isset($response['RESPONSE']['DATA']['FK_GLUSR_USR_ID'])){
					$str = $response['RESPONSE']['DATA']['FK_GLUSR_USR_ID'];
					$response['RESPONSE']['DATA']['FK_GLUSR_USR_ID'] = $this->decrypt_suppid($str);
				}
				if(isset($response['RESPONSE']['DATA']['SUPPLIER_DETAIL'])){
					$len = sizeof($response['RESPONSE']['DATA']['SUPPLIER_DETAIL']);
					for($i=0;$i<$len;$i++){
						if(isset($response['RESPONSE']['DATA']['SUPPLIER_DETAIL'][$i]['FK_GLUSR_USR_ID'])){
							$str =$response['RESPONSE']['DATA']['SUPPLIER_DETAIL'][$i]['FK_GLUSR_USR_ID'];
							$response['RESPONSE']['DATA']['SUPPLIER_DETAIL'][$i]['FK_GLUSR_USR_ID'] = $this->decrypt_suppid($str);
						}
						if(isset($response['RESPONSE']['DATA']['SUPPLIER_DETAIL'][$i]['BUYER_ID'])){
							$str =$response['RESPONSE']['DATA']['SUPPLIER_DETAIL'][$i]['BUYER_ID'];
							$response['RESPONSE']['DATA']['SUPPLIER_DETAIL'][$i]['BUYER_ID'] = $this->decrypt_suppid($str);
						}
					}
				}
				$arr= isset($response['RESPONSE']['DATA']) ? $response['RESPONSE']['DATA'] :'';
			}
		}
               	list($p,$html)=$this->disp_html($arr,$offer,$flag,'');                  
                $dta=$this->GetPurchaseDetails_OldData($dbh,$offer,$flag);
                $html_ast='';
                if(isset($dta['SUPPLIER_DETAIL']) && count($dta['SUPPLIER_DETAIL'])){
                   list($p,$html_ast)=$this->disp_html($dta,$offer,$flag,'astbuy');	
                }
		return array($p,$html,$html_ast);  
            
	}


  public function showGluserPurDetails($userID,$email,$dbh)
  {
     $errArr =array();
       $flagError=0;
	
	$months = array('01' => "Jan",
		'02' => "Feb",
		'03' => "Mar",
		'04' => "Apr",
		'05' => "May",
		'06' => "June",
		'07' => "July",
		'08' => "Aug",
		'09' => "Sept",
		'10' => "Oct",
		'11' => "Nov",
		'12' => "Dec");

        $s_date =$_REQUEST['bdate_year']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_day'];

	  $start_date =$_REQUEST['bdate_day']."-".$_REQUEST['bdate_month']."-".$_REQUEST['bdate_year'];
	  
	  $e_date =$_REQUEST['adate_year']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_day'];

	  $end_date =$_REQUEST['adate_day']."-".$_REQUEST['adate_month']."-".$_REQUEST['adate_year'];
       
	        $date  = date($s_date);
	
  	        $date1 = date($e_date);
  	 
  	 

	if (!$_REQUEST['bdate_day'] || !$_REQUEST['bdate_month'] || !$_REQUEST['bdate_year']) 
	{
	       
		array_push($errArr,"Please select the complete \'Start\' date");
		$flagError=1;
	}
	elseif(!(isset($date)))
	{
	        
		array_push($errArr,"Invalid Start Date");
		$flagError=1;
	}
	
	if (!$_REQUEST['adate_day'] || !$_REQUEST['adate_month'] || !$_REQUEST['adate_year']) 
	{
	         
		array_push($errArr,"Please select the complete \'End\' date");
		$flagError=1;
	}
	elseif(!(isset($date1)))
	
	{ 
	  
              array_push($errArr,"Invalid End Date");
		$flagError=1;
	}
        
       if ($flagError==1)
	{
	        $mesg = '';
		$mesg ='<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
		 $errorCounter=0;
		foreach ($errArr as $val)
		{
			$errorCounter++;
			$mesg .=" Error '.$errorCounter.': '.$val.'<BR>";
		}
		$mesg .="<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>";
	
 		
//                 $show=1;
                
	}
        else
        {
//             PBL_Admin->showGluserPurForm($q,$dbh);
                $loginUserDet = '';
                $months = array('01' => "Jan",
		'02' => "Feb",
		'03' => "Mar",
		'04' => "Apr",
		'05' => "May",
		'06' => "June",
		'07' => "July",
		'08' => "Aug",
		'09' => "Sept",
		'10' => "Oct",
		'11' => "Nov",
		'12' => "Dec");
		
                 $bdate_day = $_REQUEST['bdate_day'];
		 $bdate_month = $_REQUEST['bdate_month'];
		 $bdate_year = $_REQUEST['bdate_year'];
		 $adate_day = $_REQUEST['adate_day'];
		 $adate_month = $_REQUEST['adate_month'];
		 $adate_year = $_REQUEST['adate_year'];
 
                $modid= $_REQUEST['modid'];
                $offertype=$_REQUEST['offertype'] or 1; 
                $country_quality =$_REQUEST['country_quality'] or '';
                $sql .= "SELECT A.*, DENSE_RANK() OVER(ORDER BY FK_GLUSR_USR_ID desc) SEQ FROM (";
                $sql .= "
			SELECT
				ETO_OFR_DISPLAY_ID ETO_OFR_ID,
				ETO_OFR_DESC,
				TO_CHAR(ETO_PUR_DATE,'dd-mm-yyyy') AS PUR_DATE,
				ETO_PUR_DATE,
				ETO_CREDITS_USED,
				ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID FK_GLUSR_USR_ID,
				DECODE(ETO_LEAD_FK_GL_MODULE_ID,'HELLOTD','HT','IM') ETO_LEAD_FK_GL_MODULE_ID,
				(SELECT (SUM(ETO_CUST_PURCHASE_AMOUNTPAID)/SUM(ETO_CUST_PURCHASE_CREDITS)) FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND P_H.ETO_CUST_ORDER_ID > -1) AVG_PER_CREDIT_COST,
				NVL((SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),2) GLUSR_STATUS,
				NVL((select 1 from IND_SITES_TO_GLUSR_USR where IND_SITES_TO_GLUSR_USR.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),0) PREFERRED_STATUS,
				LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
				LTRIM(GL_COUNTRY_NAME) GLUSR_COUNTRY,
				NULL ETO_OFR_PREFERED_FK_GLUSR_ID,
				0 AS EXPIRED
			FROM 
				ETO_LEAD_PUR_HIST, GLUSR_USR, ETO_OFR, GL_COUNTRY
			WHERE
				FK_ETO_OFR_ID > -1
				AND ETO_OFR_TYP = 'B'
				AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID
				AND ETO_OFR.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
				AND GLUSR_USR.FK_GL_COUNTRY_ISO = GL_COUNTRY.GL_COUNTRY_ISO";
               if ($start_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) >= TRUNC(TO_DATE(:start_date,'dd-mm-yyyy'))";
		}
		if ($end_date != '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) <= TRUNC(TO_DATE(:end_date,'dd-mm-yyyy'))";
		}
		if($modid)
		{
			$sql .= " and ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID = :modid";
		}

		$sql .= "
		UNION
			SELECT
				ETO_OFR_DISPLAY_ID ETO_OFR_ID,
				ETO_OFR_DESC,
				TO_CHAR(ETO_PUR_DATE,'dd-mm-yyyy') AS PUR_DATE,
				ETO_PUR_DATE,
				ETO_CREDITS_USED,
				ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID FK_GLUSR_USR_ID,
				DECODE(ETO_LEAD_FK_GL_MODULE_ID,'HELLOTD','HT','IM') ETO_LEAD_FK_GL_MODULE_ID,
				(SELECT (SUM(ETO_CUST_PURCHASE_AMOUNTPAID)/SUM(ETO_CUST_PURCHASE_CREDITS)) FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND P_H.ETO_CUST_ORDER_ID > -1) AVG_PER_CREDIT_COST,
				NVL((SELECT 1 FROM ETO_CUST_PURCHASE_HIST P_H WHERE P_H.ETO_CUST_ORDER_ID > -1 AND P_H.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),2) GLUSR_STATUS,
				NVL((select 1 from IND_SITES_TO_GLUSR_USR where IND_SITES_TO_GLUSR_USR.FK_GLUSR_USR_ID = ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID AND ROWNUM < 2),0) PREFERRED_STATUS,
				LTRIM(GLUSR_USR_CITY) GLUSR_CITY,
				LTRIM(GL_COUNTRY_NAME) GLUSR_COUNTRY,
				NULL ETO_OFR_PREFERED_FK_GLUSR_ID,
				1 AS EXPIRED
			FROM 
				ETO_LEAD_PUR_HIST, GLUSR_USR, ETO_OFR_EXPIRED, GL_COUNTRY
			WHERE 
				FK_ETO_OFR_ID > -1
				AND ETO_OFR_TYP = 'B'
				AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID
				AND ETO_OFR_EXPIRED.FK_GLUSR_USR_ID=GLUSR_USR.GLUSR_USR_ID
				AND GLUSR_USR.FK_GL_COUNTRY_ISO = GL_COUNTRY.GL_COUNTRY_ISO";

		if ($start_date!= '')
		{
			$sql .=" AND TRUNC(ETO_PUR_DATE) >= TRUNC(TO_DATE(:start_date,'dd-mm-yyyy'))";
		}
		if ($end_date!= '')
		{
			$sql .= " AND TRUNC(ETO_PUR_DATE) <= TRUNC(TO_DATE(:end_date,'dd-mm-yyyy'))";
		}
		if($modid)
		{
			$sql .=" and ETO_LEAD_PUR_HIST.ETO_LEAD_FK_GL_MODULE_ID = :modid";
		}

                $sth=oci_parse($sql);
                if($modid)
		{
			oci_bind_by_name($sth, ':modid', $modid);
			oci_bind_by_name($sth, ':end_date', $end_date);
			oci_bind_by_name($sth, ':start_date', $start_date);
		}
//                oci_bind_by_name($stid4, ':modid', $modid);
                 oci_execute($sth);
                 $seq=0;
		$i = 0;
		$totalCredit=0;
		$totalAvgPrice=0;
		$avgPrice=0;
		$totalOfferPur =0;

		$summaryOfferCountPaid=0;
		$summaryOfferCountFree=0;
		$summaryOfferCountPref=0;

		$summaryCreditCount=0;
		$summaryCreditCountPaid=0;
		$summaryCreditCountFree=0;
		$summaryCreditCountPref=0;

		$summaryAvgPriceCount=0;
		$summaryAvgPriceCountPaid=0;
		$summaryAvgPriceCountFree=0;
		$summaryAvgPriceCountPref=0;

		$distinctOffers=0;
		$distinctGlusers=0;
		$hash_offers = array();
                $str='';
                while ($rec = oci_fetch_array($sth)) 
		{
			$status = $rec['GLUSR_STATUS'] or 0;
			$i++;
                         if($rec['SEQ'] != $seq && $i != 1)
			{
				$str1.='</TABLE>
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0">
				<TR>
				<TD STYLE="font-family:arial;font-size:12px;color:#0000AA;" WIDTH="25%" ALIGN="LEFT" BGCOLOR="#DFDFFF"><B>Lead Summary</B>&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="25%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalOfferPur.' Purchase</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="25%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalCredit.' Credits</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="25%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalAvgPrice.'</B></TD>
				</TR>
				</TABLE>
				</TD>
				</TR>';
				$totalCredit=0;
				$totalAvgPrice=0;
				$totalOfferPur=0;
			}
                        $totalOfferPur++;
			$totalCredit=$totalCredit+$rec['ETO_CREDITS_USED'];

			$avgPrice=$rec['ETO_CREDITS_USED']*$rec['AVG_PER_CREDIT_COST'];
			$summaryCreditCount=$summaryCreditCount+$rec['ETO_CREDITS_USED'];
			

			$avgPrice=$rec['ETO_CREDITS_USED']*$rec['AVG_PER_CREDIT_COST'];
			$avgPrice = sprintf("%.2f",$avgPrice);
			$totalAvgPrice=sprintf("%.2f",$totalAvgPrice+$avgPrice);
			$summaryAvgPriceCount=sprintf("%.2f",$summaryAvgPriceCount+$avgPrice);
                        if($rec['SEQ'] != $seq)
			{
			       $distinctGlusers++;
                               $loginUserDet=$this->getUserDetails($rec['FK_GLUSR_USR_ID'],0);
                               $email = $loginUserDet['email'] or '';
				 $company = $loginUserDet['company_name'] or '';
				 $name = $loginUserDet['first_name'].' '.$loginUserDet['last_name'];
				 $address = $loginUserDet['add1'] or '';
				 $country = $loginUserDet['country'] or '';
				 $city = $loginUserDet['city'] or '';
				 $state = $loginUserDet['state'] or '';
		
				 $ph_country = '';
				 $ph_area = $loginUserDet['ph_area'] or '';
				 $ph_no = $loginUserDet['ph_no'] or '';
				 $fax_country = $loginUserDet['fax_country'] or '';
				 $fax_area = $loginUserDet['fax_area'] or '';
				 $fax_no = $loginUserDet['fax_no'] or '';
				 $mobile = $loginUserDet['mobile'] or '';
				 $approv = $loginUserDet['approv'] or '';
                               $phone = "($ph_country)";
				if($ph_area)
				{
					$phone .="-($ph_area)"; 
				}
				$phone .="-$ph_no"; 
		
				 $fax = "($fax_country)";
				if($fax_area)
				{
					$fax .="-($fax_area)"; 
				}
				$fax .="-$fax_no";
                                $str1.='<TABLE WIDTH="100%" BORDER="1" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#EAEAEA">
				<TR>
				<TD WIDTH="40%" VALIGN="TOP" STYLE="font-family:arial;font-size:13px;padding:5px;" bgcolor="#f9f9f9">
				<div>';
                                if($status == 1)
				{
					$str.='<IMG SRC="../images/paid-usr.gif" ALT="Paid Credit Used" WIDTH="8" HEIGHT="8" HSPACE="4">';
					if($rec['PREFERRED_STATUS'])
					{
						$str1.='&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="4">';
					}
				}
				else
				{
					$str1.='<IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">';
					if($rec['PREFERRED_STATUS'])
					{
						$str1.='&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="4">';
					}
				}
				
				$str1.='Glusr Id: '.$rec['FK_GLUSR_USR_ID'].'</div>';
				if($company)
				{
					$str1.='<div>Company: '.$company.'</div>';
				}

				$str1.='<div>Name: '.$name.'</div>';
				if($address)
				{
					$str1.='<div>Address: '.$address.'</div>';
				}
		
				if($city)
				{
					$str1.='<div>City: '.$city.'</div>';
				}
				if($state)
				{
					$str1.='<div>State: '.$state.'</div>';
				}
		
				$str1.='<div>Country: '.$country.'</div>
				<div>Telephone: '.$phone.'</div>';
		
				if($fax_no)
				{
					$str1.='<div>Fax: '.$fax.'</div>';
				}
		
				if($mobile)
				{
					$mobile ="($ph_country)-$mobile";
					$str1.='<div>Mobile / Cell Phone: '.$mobile.'</div>';
				}
				$str1.='<div>User Status: '.$approv.' <a href="javascript:popup(\'../index.php?r=admin_glusr/MultipleScreen/moreinfo&id='.$rec['FK_GLUSR_USR_ID'].'&mid=118\');">More Details</a></div>
				<div>Email: <a href="admin-contact.pl?do=sm&mem='.$rec['FK_GLUSR_USR_ID'].'">'.$email.'</a></div>
				</TD>
				<TD WIDTH="70%" VALIGN="TOP">
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="0" HEIGHT="25" BORDERCOLOR="#E1EAE0" STYLE="border-collapse:collapse;">';
			}
			 if($hash_offers[$rec['ETO_OFR_ID']]!= $rec['ETO_OFR_ID'])
			{
				$hash_offers[$rec['ETO_OFR_ID']]=$rec['ETO_OFR_ID'];
				$distinctOffers++;
			}

			$mainDesc = $rec['ETO_OFR_DESC'];
			$mainDesc =$this->removeUnwantedInfo($mainDesc);
// 			$mainDesc =~ s/\n/<BR>\n/g;
// 			$mainDesc =~ s/\t/&nbsp;&nbsp;&nbsp;&nbsp;/g;
			#end

			$title=$mainDesc;
			if (count($title)>35)
			{
				$title = substr($title,0,35);
				$title .= "...";
			}

			$bgcolor2='#f7f7f7';
			if($totalOfferPur % 2 == 0)
			{
				$bgcolor2='#eeeeee';
			}

			$img='';
			$bgcolor='';
			if($rec['ETO_OFR_PREFERED_FK_GLUSR_ID'])
			{
				$img .='<font color="red">*</font>';
				$bgcolor='ffffca';
				$bgcolor2=$bgcolor;
			}
			$str1.='
			<TR bgcolor="'.$bgcolor2.'">
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%"><A HREF="javascript:popup(\'/index.php?r=admin_bl/Transaction_report/Index/action/purchasers&offer='.$rec['ETO_OFR_ID'].'&mid=3442&exp='.$rec['EXPIRED'].'\');>'.$rec['ETO_OFR_ID'].'</A></TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="30%">'.$img.' '.$title.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="22%">';

				if($rec['GLUSR_CITY'])
				{
					$str1.=''.$rec['GLUSR_CITY'].' / ';
				}
				$str1=''.$rec['GLUSR_COUNTRY'].'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">'.$rec['PUR_DATE'].'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="12%">';

				if($status == 1)
				{
					if($rec['ETO_OFR_PREFERED_FK_GLUSR_ID'])
					{
						$summaryOfferCountPref++;
						$summaryCreditCountPref = $summaryCreditCountPref+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPref=sprintf("%.2f",$summaryAvgPriceCountPref+$avgPrice);
					}
					else
					{
						$summaryOfferCountPaid++;
						$summaryCreditCountPaid = $summaryCreditCountPaid+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPaid=sprintf("%.2f",$summaryAvgPriceCountPaid+$avgPrice);
					}
				}
				else
				{
					if($rec['ETO_OFR_PREFERED_FK_GLUSR_ID'])
					{
						$summaryOfferCountPref++;
						$summaryCreditCountPref = $summaryCreditCountPref+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountPref=sprintf("%.2f",$summaryAvgPriceCountPref+$avgPrice);
					}
					else
					{
						$summaryOfferCountFree++;
						$summaryCreditCountFree = $summaryCreditCountFree+$rec['ETO_CREDITS_USED'];
						$summaryAvgPriceCountFree=sprintf("%.2f",$summaryAvgPriceCountFree+$avgPrice);
					}
				}
				$str1.=''.$rec['ETO_CREDITS_USED'].' Credits</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH="5%">'.$avgPrice.'</TD>
				<TD STYLE="font-family:arial;font-size:11px;" WIDTH=10%"><FONT COLOR="red"><B>'.$rec['ETO_LEAD_FK_GL_MODULE_ID'].'</B></FONT></TD>
			</TR>';
			$seq = $rec['SEQ'];
		}
		
		 return array($bdate_day,$bdate_month,$bdate_year,$adate_day,$adate_month,$adate_year,$totalOfferPur,$totalCredit,$totalAvgPrice,$distinctGlusers,$distinctOffersm,$summaryOfferCountPaid,$summaryOfferCountFree,$summaryOfferCountPref,$summaryCreditCountPaid,$summaryCreditCountFree,$summaryCreditCountPref,$summaryCreditCount,$summaryAvgPriceCountPaid,$summaryAvgPriceCountFree,$summaryAvgPriceCountPref,$summaryAvgPriceCount,$str1);

		 }

  }
  
  public function leadpurchaseDetails($dbh,$glusrid,$days,$archive)
{
     if(!isset($glusrid))
     {
       $glusrid=0;
      }
      $glusrid=trim($glusrid);
      $userID =$glusrid;
      if(!isset($days))
      {
      $days=0;
      }
     $flagError=0;
    $errArr=array();
    if (!$glusrid)
	{
		array_push($errArr,"Please Enter GLUser Id");
		$flagError=1;
  	}
  	
  	if($glusrid && !preg_match('/(^\d+$)/',$glusrid))
  	{
  	array_push($errArr,"Invalid GLUser Id");
	$flagError=1;  	
  	} 
  	
  	$str='';
  	
  	if ($flagError==1)
	{
	        $mesg = '';
		$mesg ='<TABLE BORDER="0" WIDTH="100%"><TR>
			<TD BGCOLOR="#EAEAEA" CLASS="admintext" ALIGN="left"><FONT COLOR="#FF0000" size="2"><B>Following Error(s) Occured:<BR><BR>';
		 $errorCounter=0;
		foreach ($errArr as $val)
		{
			$errorCounter++;
			$mesg .=" Error '.$errorCounter.': '.$val.'<BR>";
		}
		$mesg .="<BR>Please make the necessary corrections to proceed. Thanks for your patience.</B></FONT></TD>
			</TR></TABLE>";
	}
	else
	{
	
	    $loginUserDet = $flag='';	   
	     if($glusrid)
		{
                    $glmodel= new GlobalmodelForm();
                    $loginUserDet = $glmodel->get_glusr_detail($glusrid,'ALL');
		}
                $email = isset($loginUserDet['GLUSR_USR_EMAIL'])?$loginUserDet['GLUSR_USR_EMAIL']:'';
                $company =isset($loginUserDet['GLUSR_USR_COMPANYNAME'])?$loginUserDet['GLUSR_USR_COMPANYNAME']:'';
                $FIRST_NAME =isset($loginUserDet['GLUSR_USR_CFIRSTNAME'])?$loginUserDet['GLUSR_USR_CFIRSTNAME']:'';
                $LAST_NAME =isset($loginUserDet['GLUSR_USR_CLASTNAME'])?$loginUserDet['GLUSR_USR_CLASTNAME']:'';
                $name = $FIRST_NAME.' '.$LAST_NAME;
                $address =isset($loginUserDet['ADD1'])?$loginUserDet['ADD1']:'';
                $country =isset($loginUserDet['GLUSR_USR_COUNTRYNAME'])?$loginUserDet['GLUSR_USR_COUNTRYNAME']:''; 
                $city =isset($loginUserDet['GLUSR_USR_CITY'])?$loginUserDet['GLUSR_USR_CITY']:'';
                $state =isset($loginUserDet['GLUSR_USR_STATE'])?$loginUserDet['GLUSR_USR_STATE']:'';
                $ph_country =isset($loginUserDet['GLUSR_USR_PH_COUNTRY'])?$loginUserDet['GLUSR_USR_PH_COUNTRY']:'';
                $mobile =isset($loginUserDet['GLUSR_USR_PH_MOBILE'])?$loginUserDet['GLUSR_USR_PH_MOBILE']:'';
                $fax_country =isset($loginUserDet['GLUSR_USR_FAX_COUNTRY'])?$loginUserDet['GLUSR_USR_FAX_COUNTRY']:'';
                $fax_area =isset($loginUserDet['GLUSR_USR_FAX_AREA'])?$loginUserDet['GLUSR_USR_FAX_AREA']:'';
                $fax_no =isset($loginUserDet['GLUSR_USR_FAX_NUMBER'])?$loginUserDet['GLUSR_USR_FAX_NUMBER']:'';
                $fax = "($fax_country)";
                if($fax_area)
                {
                    $fax .="-($fax_area)";
                }       
                $fax .="-$fax_no";
                $phone=isset($loginUserDet['GLUSR_USR_PH_NUMBER'])?$loginUserDet['GLUSR_USR_PH_NUMBER']:'';
                $approv =isset($loginUserDet['GLUSR_USR_APPROV'])?$loginUserDet['GLUSR_USR_APPROV']:'';
                $url =isset($loginUserDet['PAIDSHOWROOM_URL'])?$loginUserDet['PAIDSHOWROOM_URL']:'';           
                $custtype =isset($loginUserDet['GLUSR_USR_CUSTTYPE_NAME'])?$loginUserDet['GLUSR_USR_CUSTTYPE_NAME']:'';
                $lat= isset($loginUserDet['GLUSR_USR_LATITUDE'])? $loginUserDet['GLUSR_USR_LATITUDE'] :'';
                $long= isset($loginUserDet['GLUSR_USR_LONGITUDE'])? $loginUserDet['GLUSR_USR_LONGITUDE'] :'';
		$str='';
		$str.='<STYLE TYPE="text/css">
.mtrbg{background: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'../images/bg_popup.png\',sizingMethod=\'scale\'); background-image:url(\'../images/bg_popup.png\'); padding-bottom:150px;}
</STYLE>';

               $str.='<TABLE ALIGN="center" BORDER="0" CELLPADDING="0" CELLSPACING="0"
   	 WIDTH="100%" >
     	 <TBODY>
     	 <TR><TD WIDTH="100%" VALIGN="TOP" id="id_attribute_value">
		<!--Mark Complaint Start here-->
		<DIV ALIGN="CENTER" STYLE="position:absolute; left:0px; display:none; top:0px;" class="mtrbg" ID="mc-part">
		<DIV ID="divheight13"></DIV>
		<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="CENTER" ID="tableheight13">
		<TR>
			<TD ALIGN="CENTER">
		
			<DIV ALIGN="LEFT" ID="resolution13">
		<div class="alrtTxt" id="cmplnt_div" style="height:260px;position:relative;" >
		<!-- Code will be inserted here -->
		</div>
		
		</DIV></TD>
		</TR>
		</TABLE>
		</DIV>
		<!-- Mark Complaint end here -->';
		
		$str.='<div><br></div>

		<TABLE BORDER="0" WIDTH="100%"><TR>
		<TD width="98%" align="left" STYLE="font-family:arial;font-size:13px;padding:5px;">
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:#006FB6;">
		Complete Transaction History for Gluser: '.$glusrid.'</DIV>
		<TABLE STYLE="font-family:arial;font-size:13px;padding-bottom:3px;"><TR><TD valign="top" width="50%">';

	        $rec='';
		$color='';
		$serial=0;
		$trans_data='';
		
	$fromdays=isset($_REQUEST['fromdays']) ? $_REQUEST['fromdays'] : '';
	
	if($fromdays ==90)
	{
	$current_date=Date('j-M-Y');
	$time = strtotime("$current_date -90 days");
        $date2 = date("j-M-Y", $time);
	}
	else
	{
	$current_date='';
	$date2='';	
	}
$rtype=isset($_REQUEST['rtype']) ? $_REQUEST['rtype'] : 'both';

  $content = array(
  'token' =>'imobile@15061981',
  'modid' =>'GLADMIN',
  'glusrid' => $glusrid,
  'date1'=>$date2,
  'date2'=>$current_date,
   'type' => $rtype,    
  'current_detail'=>1,
  'archive_data'=>$archive
	);
	
	$req = ($_SERVER['SERVER_NAME'] == 'gladmin.intermesh.net') ? 'https://leads.imutils.com/wservce/buyleads/acountledger/':'http://mapi.indiamart.com/wservce/buyleads/acountledger/';
$data_string = http_build_query($content);
$msg='';
	$arr=array();		
	
	$ServiceGlobalModelForm = new ServiceGlobalModelForm();
	//$response = $ServiceGlobalModelForm->mapiService('ACOUNTLEDGER',$req,$content,'No');
                        if($emp_id==3575){
                        /*    http://mapi.indiamart.com/wservce/buyleads/acountledger/0Array
(
    [token] => imobile@15061981
    [modid] => GLADMIN
    [glusrid] => 441
    [date1] => 20-May-2020
    [date2] => 18-Aug-2020
    [type] => both
    [current_detail] => 1
    [archive_data] => 0
)*/
                   // echo '<pre>';echo $req;print_r($response); print_r($content); echo '</pre>';  
                }

                
	/*print_r($content); print_r($response);
	if (!is_array($response)) {
		$msg = "Mapi Server Connectivity Issue\n\n Service URL:-$req";
		mail("gladmin-team@indiamart.com","ACOUNTLEDGER Service Failed",$msg);
	} 
	else
	{
		$arr=$this->getdata();//isset($response['RESPONSE']['DATA']) ? $response['RESPONSE']['DATA'] : '';  
	}
	*/
        $arr=$this->getdata($glusrid);//isset($response['RESPONSE']['DATA']) ? $response['RESPONSE']['DATA'] : '';  
        return array($arr,$userID,$company,$name,$address,$city,$state,$country,$phone,$fax_no,$fax,$mobile,$ph_country,$approv,$color,$serial,$flag,$email,$url,$custtype,$lat,$long);
}	
}
    
public function disp_html($arr,$offer,$flag,$is_archive)
{
 
   if(isset($arr['SUPPLIER_DETAIL'][0]['FK_GLUSR_USR_ID']))
           {

		$html='';	
		$html.= '<STYLE TYPE="text/css">$offrid
		.admintext {font-family:ms sans serif,verdana; font-size:12px;font-weight:bold;line-height:17px;}
		.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}</STYLE>
		<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>

		<div><br></div>
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding:3px;color:#006FB6;">
		Complete purchase Summary for Offer Id: '.$offer.'
		<DIV STYLE="font-size:11px;color:#000000;font-weight:normal;">
		(<FONT COLOR="#FF0000">*</FONT>) Indicates Preferred Enquiry | <IMG SRC="../images/paid-usr.gif" ALT="Paid Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Paid Clients (Havinig atleast one Paid Credit Transaction) | <IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Free Clients | <IMG SRC="../images/paid-usr1.gif" ALT="Preferred Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Preferred Clients | <IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="4">Introduced through Assisted Buying Service
		</DIV>
		</DIV>

		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
		<TR>
			<TD BGCOLOR="#E5E5E5" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" 
			WIDTH="30%">&nbsp;Buy Lead Details';
          
                
                if($is_archive=='astbuy')
                      $html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="javascript:popup(\'/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$offer.'&go=Go&mid=3424\');">Click Here To View Details</a>'; 
                      $html.='</TD>';
			$html.= '</TR>
			</TABLE></TD>
		</TR>
		</TABLE>
		<input type="hidden" name="offer_details" id="offer_details" value="0">
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#EAEAEA">';
	$totalOfferPur=$totalOfferPurAST=$totalOfferPurBL=0;	 
	if(!empty($arr['SUPPLIER_DETAIL']))
                          {
			 foreach($arr['SUPPLIER_DETAIL'] as $array5)
			 {
			
			 if(isset($array5['FK_GLUSR_USR_ID']) && isset($array5['TYPE']) && $array5['TYPE']=='B')
			 {
			$totalOfferPur= $totalOfferPur+1;
                             if(isset($array5['ETO_LEAD_FK_GL_MODULE_ID']) && $array5['ETO_LEAD_FK_GL_MODULE_ID']=='IM')
                            {
                                $totalOfferPurBL= $totalOfferPurBL+1;
                            }else{
                                $totalOfferPurAST= $totalOfferPurAST+1;
			  }
                            
			  }
			}
			}
		else
		{
		$totalOfferPur=$totalOfferPurAST=$totalOfferPurBL=0;
		}
		$totalCredit=0;
		$totalAvgPrice=0;			
			$bgcolor2='#f7f7f7';
			if($totalOfferPur % 2 == 0)
			{
				$bgcolor2='#eeeeee';
			}
	                  $mainDesc=isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_DESC']) ? $arr['SUPPLIER_DETAIL'][0]['ETO_OFR_DESC'] : '';
			  $mainDesc = $this->removeUnwantedInfo($mainDesc);
			  $mainDesc=preg_replace('/\n/','<BR>',$mainDesc);
			  $mainDesc=preg_replace('/\t/','&nbsp;&nbsp;&nbsp;&nbsp;',$mainDesc);
                         $img='';
			 $bgcolor='';
			 $bgcolor1='#f9f9f9';
			 if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PREFERED_FK_GLUSR_ID']))
				{
					$img .='<font color="red">*</font>';
					$bgcolor='ffffca';
					$bgcolor1=$bgcolor;
				}
				$Detail=isset($arr['ADDITIONALINFO']) ? $arr['ADDITIONALINFO'] :'';
				$Detail=json_decode($Detail);
			$OFFER_DATE=isset($arr['OFR_DATE']) ? $arr['OFR_DATE'] : '';
                       
			$ETO_OFR_TITLE=isset($arr['ETO_OFR_TITLE']) ? $arr['ETO_OFR_TITLE'] : '';
			$GLUSR_COUNTRY_BUY =isset($arr['GLUSR_COUNTRY_BUY']) ? $arr['GLUSR_COUNTRY_BUY'] : '';
			
			$date = date_create($OFFER_DATE);
			$date=  date_format($date, 'd-m-Y H:i:s');			
			$html .=  '<TR>
				<TD bgcolor="'.$bgcolor1.'" WIDTH="30%" VALIGN="TOP">';
                       if($is_archive==''){
				$html .='<DIV STYLE="font-family:arial;font-size:12px;padding:5px;">Offer Posting Date: '.$date.'<BR>
				<B>'.$img.' '.$ETO_OFR_TITLE.'<FONT COLOR="#0000FF"> ['.$GLUSR_COUNTRY_BUY.']</FONT></B><BR>
				'.$mainDesc.'';
                        }
                         if(isset($arr['ETO_OFR_QTY']))
				{
					$html.= '<BR>Preferred Quantity: '.$arr['ETO_OFR_QTY'].'';
				}
			if(isset($arr['ETO_OFR_QTY_UNIT']))
				{
					$html.= '&nbsp;'.$arr['ETO_OFR_QTY_UNIT'];
				}
			
				if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_SUPPLY_TERM']))
				{
					$html.=  '<BR>Delivery Terms: '.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_SUPPLY_TERM'].'';
				}
			
			
				if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAY_TERM']))
				{
					$html.=  '<BR>Payment Terms: '.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAY_TERM'].'';
				}
		
				if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER']))
				{
					
					if(preg_match('/http/',$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER']) )
					  { 
					  $html.= '<BR><p style="width:40em;word-wrap:break-word;">Enquiry Source: <a href="'.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER'].'" style="text-decoration:none" target="_blank" TITLE="'.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER'].'">View</a></p>';
					  }
					  else if(preg_match('/www/',$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER']) or preg_match('/m\.indiamart\.com/',$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER']))
					  {
					    $html.= '<BR><p style="width:40em;word-wrap:break-word;">Enquiry Source: <a href="http://'.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER'].'" style="text-decoration:none" target="_blank" TITLE="'.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER'].'">View</a></p>';
					  }
					  else
					  {
					  $html.= '<BR><p style="width:40em;word-wrap:break-word;">Enquiry Source: <span TITLE="'.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_PAGE_REFERRER'].'">View</span></p>';
					  }
					  
				}
	
				if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP']))
                                {
                                  
                                    if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_MODULE_ID']) && $arr['SUPPLIER_DETAIL'][0]['ETO_MODULE_ID'] =='FENQ')
                                    
                                    {
                                        $html.= '<BR>
                                        This enquiry has been generated through IP:- '.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP'];
                                     
                                        if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP_COUNTRY']) && $arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP_COUNTRY'] != 'NA')
                                        {
                                                $html.= ' ('.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP_COUNTRY'].')';
                                        }
                                    }else{
                                        $html.= '<BR>
                                        This Buy Lead has been generated through IP:- '.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP'];
                                         if(isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP_COUNTRY']) && $arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP_COUNTRY'] != 'NA')
                                        {
                                                $html.= ' ('.$arr['SUPPLIER_DETAIL'][0]['ETO_OFR_S_IP_COUNTRY'].')';
                                        }
                                    } 
                                }
                                $html .='<br><br>';
                                if($Detail)
                                {
                                foreach($Detail as $key=>$value)
				{
				$html .="$key: $value";
				$html .='<br>';
				}
                                }
                                $attach_cnt=1;
                                
                               if(!empty($arr['ATTACHMENT_DETAIL']))
                               {
                               foreach($arr['ATTACHMENT_DETAIL'] as $array2)
				{
			
                                  if(isset($array2['ETO_OFR_ATTACH_IMG_ORIG'])){
                                        $html .="Attachment$attach_cnt: ";
                                        $html .= '<a href='.$array2['ETO_OFR_ATTACH_IMG_ORIG'].' target="_blank">'.$array2['ETO_OFR_ATTACH_IMG_ORIG'].'</a>';
                                        $html .= '<br>';
                                        $attach_cnt++;
                                  }
				}
				
				}
                               
                               if(!empty($arr))
                               {
                               $GLUSR_NAME=isset($arr['GLUSR_NAME']) ? $arr['GLUSR_NAME'] : '';
                               if($is_archive<>'astbuy'){
				$html.=  '<BR><BR>                                 
				<B>Buyer\'s Information-</B><BR>
				<DIV>Name: '.$GLUSR_NAME.'';
                               }
                             
				if(isset($arr['GLUSR_DESIGNATION']))
				{
					$html.=  ' ('.$arr['GLUSR_DESIGNATION'].')';
				}
				$html.=  "</div>";
	
				if(isset($arr['GLUSR_COMPANY']))
				{
					$html.=  '<div>Company: '.$arr['GLUSR_COMPANY'].'</div>';
				}
	
				if(isset($arr['GLUSR_ADDRESS']))
				{
					$html.=  '<DIV>Address: '.$arr['GLUSR_ADDRESS'].'</DIV>';
				}
	
				if(isset($arr['GLUSR_CITY']))
				{
					$html.= '<DIV>City: '.$arr['GLUSR_CITY'].'</DIV>';
				}
		
				if(isset($arr['GLUSR_STATE']))
				{
					$html.=  '<DIV>State: '.$arr['GLUSR_STATE'].'</DIV> ';
				}
	                        if(isset($arr['GLUSR_COUNTRY']))
				{
				$html .= '<DIV>Country: '.$arr['GLUSR_COUNTRY'].'</DIV>';
				}
				if(isset($arr['GLUSR_ZIP']))
				{
					$html.= '<DIV>Postal Code: '.$arr['GLUSR_ZIP'].'</DIV>';
				}
				
				$phone='';
				
				if(isset($arr['GLUSR_USR_PH_COUNTRY']))
				{
				$ph_country=$arr['GLUSR_USR_PH_COUNTRY'];
				 $phone = "+($ph_country)";
				 }
				if(isset($arr['GLUSR_USR_PH_AREA']))
				{
				      $ph_area=$arr['GLUSR_USR_PH_AREA'];				     
                                    $phone .="-($ph_area)"; 
				}
				if(isset($arr['GLUSR_USR_PH_NUMBER']))
				{
				$ph_no=$arr['GLUSR_USR_PH_NUMBER'];
				$phone .="-$ph_no"; 				
				}
				if(isset($arr['GLUSR_USR_PH_NUMBER']))
				{
				$html .=  '<div>Telephone: '.$phone.'</div>';
				}
				if(isset($arr['GLUSR_USR_FAX_NUMBER']))
				{	
					$html.=  '<div>Fax: '.$arr['GLUSR_USR_FAX_NUMBER'].'</div>';
				}
			
				if(isset($arr['GLUSR_MOBILE']))
				{
				        $mobile ='+('.$arr['GLUSR_USR_PH_COUNTRY'].')-'.$arr['GLUSR_MOBILE'].'';
					if(isset($arr['GLUSR_USR_PH_MOBILE_ALT']))
					{
						$mobile .= '/'.$arr['GLUSR_USR_PH_MOBILE_ALT'].'';
					}
					$html.=  '
					<div>Mobile / Cell Phone: '.$mobile.'</div>';
				}
				if(isset($arr['GLUSR_USR_EMAIL']))
				{
				
				$html .= '
				<div>Email: '.$arr['GLUSR_USR_EMAIL'].'</div>';
	                        }
				 $length_url = isset($arr['ETO_OFR_GLUSR_DISP_URL']) ? $arr['ETO_OFR_GLUSR_DISP_URL'] : '';
				if($length_url)
				{
					$html.= '<DIV>Website: <A HREF="'.$length_url.'" target="_new">'.$length_url.'</A></DIV>';
				}
	
				$html.= '</DIV></TD>
				<TD WIDTH="70%" VALIGN="TOP">
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR=\'#E1EAE0\' STYLE=\'border-collapse:collapse;\'>';
				
				}
			
			
			if(!empty($arr['SUPPLIER_DETAIL']))
                          {
                 $count_heading = 0;       
			 foreach($arr['SUPPLIER_DETAIL'] as $array3)
			 {
			
			 if(isset($array3['FK_GLUSR_USR_ID']) && isset($array3['TYPE']) && $array3['TYPE']=='B')
			 {
				 if($count_heading ==0){
					$html .='<TR>
					<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" align="CENTER" WIDTH="10%"><B>GL User </B></TD>
					<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" align="CENTER" WIDTH="25%"><B>Company</B></TD>
					<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" align="CENTER" WIDTH="15%"><B>City / Country</B></TD>
					<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="20%" align="CENTER"><B>Purchased On</B></TD>
					<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" align="CENTER" WIDTH="10%"><B>Credit Used</B></TD>
					<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" align="CENTER" WIDTH="5%"><B>Avg Amt</B></TD>
					<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" align="CENTER" WIDTH="10%"><B>Src</B></TD>
								<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" WIDTH="5%" align="CENTER"><B>Enquiry Sent </B>
					</TD>
					</tr>';

					$count_heading=1;
				 }              
			 $html.='
			<TR bgcolor="'.$bgcolor2.'">
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="10%">';
			 
			if(isset($array3['GLUSR_STATUS']) && $array3['GLUSR_STATUS'] == 1)
			{				
				$html.=  '<IMG SRC="../images/paid-usr.gif" ALT="Paid Credit Used" WIDTH="8" HEIGHT="8" HSPACE="2">';
				if(isset($array3['ETO_LEAD_FK_GL_MODULE_ID']) && $array3['ETO_LEAD_FK_GL_MODULE_ID']=='AST BUY')
				{
					$html.=  '&nbsp;<IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}				
				if(!empty($array3['PREFERRED_STATUS']))
				{
					$html.=  '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}
			}
			else
			{
			 $html .= '<IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="2">';
				if(isset($array3['ETO_LEAD_FK_GL_MODULE_ID']) &&  $array3['ETO_LEAD_FK_GL_MODULE_ID'] == 'AST BUY')
				{
					$html.=  '&nbsp;<IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}	
				if(!empty($array3['PREFERRED_STATUS']))
				{
					$html.=  '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}
				
			}
			 $FK_GLUSR_USR_ID=isset($array3['FK_GLUSR_USR_ID']) ? $array3['FK_GLUSR_USR_ID'] : '';
			 $GLUSR_COMPANY=isset($array3['GLUSR_COMPANY']) ? $array3['GLUSR_COMPANY'] : '';
			 $ETO_CREDITS_USED=isset($array3['ETO_CREDITS_USED']) ? $array3['ETO_CREDITS_USED'] :0;
			 $AVG_PER_CREDIT_COST=isset($array3['AVG_PER_CREDIT_COST']) ? $array3['AVG_PER_CREDIT_COST'] : 0;
 	
			$html .='&nbsp;<A HREF="javascript:popup(\'/index.php?r=admin_bl/Transaction_report/Index/action/transDetails/nofrm/1/mid/3442/glusrid/'.$FK_GLUSR_USR_ID.'\');">'.$FK_GLUSR_USR_ID.'</A>
			&nbsp;</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="25%" ALIGN="CENTER">'.$GLUSR_COMPANY.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="15%" ALIGN="CENTER">';
	
			if(isset($array3['GLUSR_CITY']))
			{
				$html.= ''.$array3['GLUSR_CITY'].' / ';
			}
			
			$avgPrice=$ETO_CREDITS_USED*$AVG_PER_CREDIT_COST;
			
			$GLUSR_COUNTRY=isset($array3['GLUSR_COUNTRY']) ? $array3['GLUSR_COUNTRY'] : '';
			$PUR_DATE=isset($array3['PUR_DATE']) ? $array3['PUR_DATE'] : '';
			$date = date_create($PUR_DATE);
			$PUR_DATE=  date_format($date, 'd-m-Y H:i:s');
			$ETO_LEAD_FK_GL_MODULE_ID=isset($array3['ETO_LEAD_FK_GL_MODULE_ID']) ? $array3['ETO_LEAD_FK_GL_MODULE_ID'] :'';
			if($ETO_LEAD_FK_GL_MODULE_ID=='IM'){
                            $ETO_LEAD_FK_GL_MODULE_ID='Purchase';
                        }
			$html.=  ''.$GLUSR_COUNTRY.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="20%" ALIGN="CENTER">'.$PUR_DATE.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="10%" ALIGN="CENTER">'.$ETO_CREDITS_USED.' Credits</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="5%" ALIGN="CENTER">'.$avgPrice.'</TD>'
                                . '<TD STYLE="font-family:arial;font-size:11px;" WIDTH="10%" ALIGN="CENTER"><FONT COLOR="red"><B>'.$ETO_LEAD_FK_GL_MODULE_ID.'</B></FONT></TD>';
                        $ETO_UNSOLD_RELAX_FLAG=isset($array3['ETO_UNSOLD_RELAX_FLAG']) ? $array3['ETO_UNSOLD_RELAX_FLAG'] :'';
 			if($ETO_UNSOLD_RELAX_FLAG ==7)
 			{
 			 $enquiry_send='No';
			}
			else
 			{
 			 $enquiry_send='Yes';
 			}
 			$html.='<TD STYLE="font-family:arial;font-size:11px;" WIDTH="5%" ALIGN="CENTER">'.$enquiry_send.'</TD>';
			
			$html.='</TR>';
		
		}
	            }
	            }
		
	
		$html.= '</TABLE>';
		
		 $totalOfferPur=$totalOfferPurAST=$totalOfferPurBL=0;
	 
	if(!empty($arr['SUPPLIER_DETAIL']))
                          {
			 foreach($arr['SUPPLIER_DETAIL'] as $array4)
			 {
			
			 if(isset($array4['FK_GLUSR_USR_ID']) && isset($array4['TYPE']) && $array4['TYPE']=='B')
			 {
			    $totalOfferPur= $totalOfferPur+1;
			  
                          if(isset($array4['ETO_LEAD_FK_GL_MODULE_ID']) && $array4['ETO_LEAD_FK_GL_MODULE_ID']=='IM')
                            {
                                $totalOfferPurBL= $totalOfferPurBL+1;
                            }else{
                                $totalOfferPurAST= $totalOfferPurAST+1;
			  }
                         }
			}
			}
		else
		{
		 $totalOfferPur=$totalOfferPurAST=$totalOfferPurBL=0;
		}
		$totalCredit=0;
		$totalAvgPrice=0;
		if(!empty($arr['SUPPLIER_DETAIL']))
		{
		  foreach($arr['SUPPLIER_DETAIL'] as $array)
		  {
		   $ETO_CREDITS_USED1=isset($array['ETO_CREDITS_USED']) ? $array['ETO_CREDITS_USED'] :'';
		   $AVG_PER_CREDIT_COST1=isset($array['AVG_PER_CREDIT_COST']) ? $array['AVG_PER_CREDIT_COST'] :'';
		   
		   $totalCredit =$totalCredit+ $ETO_CREDITS_USED1;
		   $avgPrice=$ETO_CREDITS_USED1*$AVG_PER_CREDIT_COST1;
		   $totalAvgPrice=$totalAvgPrice+$avgPrice;
		  }
		 }
		
				$html .='
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0">
				<TR>
				<TD STYLE="font-family:arial;font-size:12px;color:#0000AA;" WIDTH="25%" ALIGN="LEFT" BGCOLOR="#DFDFFF"><B>Lead Summary</B>&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="25%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalOfferPur.' Purchase</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="25%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalCredit.' Credits</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="25%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalAvgPrice.'</B></TD>
				</TR>
				</TABLE></TABLE>
				';
			
			
		
		$html .='<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="right" width="70%">
		<TR bgcolor="#ffffff">
		<TD STYLE="font-family:arial;font-size:12px;" colspan="3" align="left" width="100%">
		<FONT size="3"><B>Summary-</B></font></TD>
		</TR>
		<TR bgcolor="#e1eae0"">
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser</B></TD>
                <TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total BL Purchaser </B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total ASTBUY Done</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Credit Used</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Avg Price</B></TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPur.'</TD>
                    <TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPurBL.'</TD>
                        <TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPurAST.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalCredit.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalAvgPrice.'</TD>
		</TR>
		</TABLE>';
		
		
		}
		else
		{
                $html= '
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding:3px;color:#006FB6;">
		Complete purchase Summary for Offer Id: '.$offer.'
		<DIV STYLE="font-size:11px;color:#000000;font-weight:normal;">
		(<FONT COLOR="#FF0000">*</FONT>) Indicates Preferred Enquiry | <IMG SRC="../images/paid-usr.gif" ALT="Paid Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Paid Clients (Havinig atleast one Paid Credit Transaction) | <IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Free Clients | <IMG SRC="../images/paid-usr1.gif" ALT="Preferred Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Preferred Clients | <IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="4">Introduced through Assisted Buying Service
		</DIV>
		</DIV>
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
		<TR>
			<TD BGCOLOR="#E5E5E5" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" 
			WIDTH="30%">&nbsp;Buy Lead Details';
                
                  if($is_archive=='astbuy'){
                      $html.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="javascript:popup(\'/index.php?r=admin_eto/OfferDetail/editflaggedleads&offer='.$offer.'&go=Go&mid=3424\');">Click Here To View Details</a>'; 
                  }
                
                       $html.='</TD>
			<TD BGCOLOR="#FFFFFF" WIDTH="70%">
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1" HEIGHT="30">
			<TR>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>GL User</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="25%"><B>Company</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="15%"><B>City / Country</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>Purchased On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>Credit Used</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="5%"><B>Avg Amt</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>Src</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="5%" align="CENTER"><B>Enquiry Sent</B></TD>';			
			$html.= '</TR>
			</TABLE></TD><input type="hidden" name="offer_details" id="offer_details" value="0">
		</TR>
		</TABLE>
		
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#EAEAEA"></TABLE>';
		$totalOfferPur=0;
	
		$totalCredit=0;
		$totalAvgPrice=0;
		
		$html .='<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="right" width="70%">
		<TR bgcolor="#ffffff">
		<TD STYLE="font-family:arial;font-size:12px;" colspan="3" align="left" width="100%">
		<FONT size="3"><B>Summary-</B></font></TD>
		</TR>
		<TR bgcolor="#e1eae0"">
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Credit Used</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Avg Price</B></TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPur.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalCredit.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalAvgPrice.'</TD>
		</TR>
		</TABLE>';	        
		}
  $p=0;
   if(isset($flag) && $flag == 'viaemailid')
   {     
      $p=0;
      return array($p,$html);
   }
   else
   {
     $p=1;
     return array($p,$html);
   }
}
    
    
public function disp_html2($arr,$offer,$flag,$arr1)
{



 
   if(isset($arr['SUPPLIER_DETAIL'][0]['FK_GLUSR_USR_ID']))
           {
 
		$html='';	
		$html.= '<STYLE TYPE="text/css">$offrid
		.admintext {font-family:ms sans serif,verdana; font-size:12px;font-weight:bold;line-height:17px;}
		.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}</STYLE>
		<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>

		<div><br></div>
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding:3px;color:#006FB6;">
		Complete purchase Summary for Offer Id: '.$offer.'
		<DIV STYLE="font-size:11px;color:#000000;font-weight:normal;">
		(<FONT COLOR="#FF0000">*</FONT>) Indicates Preferred Enquiry | <IMG SRC="../images/paid-usr.gif" ALT="Paid Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Paid Clients (Havinig atleast one Paid Credit Transaction) | <IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Free Clients | <IMG SRC="../images/paid-usr1.gif" ALT="Preferred Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Preferred Clients | <IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="4">Introduced through Assisted Buying Service
		</DIV>
		</DIV>

		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
		<TR>
			<TD BGCOLOR="#E5E5E5" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" 
			WIDTH="30%">&nbsp;Buy Lead Details</TD>
			<TD BGCOLOR="#FFFFFF" WIDTH="70%">
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1" HEIGHT="30">
			<TR>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>GL User</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="25%"><B>Company</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="15%"><B>City / Country</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="20%"><B>Purchased On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>Credit Used</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="5%"><B>Avg Amt</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>Src</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="5%" align="CENTER"><B>Enquiry Sent</B></TD>';
                        $html.= '</TR>
			</TABLE></TD>
		</TR>
		</TABLE>
		<input type="hidden" name="offer_details" id="offer_details" value="0">
		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0" STYLE="border-collapse:collapse;" BORDERCOLOR="#EAEAEA">';
	        
	 
	$totalOfferPur=0;
	 
	if(!empty($arr['SUPPLIER_DETAIL']))
                          {
			 foreach($arr['SUPPLIER_DETAIL'] as $array5)
			 {
			
			 if(isset($array5['FK_GLUSR_USR_ID']) && isset($array5['STATUS']))
			 {
			$totalOfferPur= $totalOfferPur+1;
			  }
			  }
			}
		else
		{
		$totalOfferPur=0;
		}
		$totalCredit=0;
		$totalAvgPrice=0;
			
	
			
			$bgcolor2='#f7f7f7';
			if($totalOfferPur % 2 == 0)
			{
				$bgcolor2='#eeeeee';
			}
			
			
	                  $mainDesc=isset($arr['SUPPLIER_DETAIL'][0]['ETO_OFR_DESC']) ? $arr['SUPPLIER_DETAIL'][0]['ETO_OFR_DESC'] : '';
	                   
                          	                  
			  $mainDesc = $this->removeUnwantedInfo($mainDesc);
			  $mainDesc=preg_replace('/\n/','<BR>',$mainDesc);
			  $mainDesc=preg_replace('/\t/','&nbsp;&nbsp;&nbsp;&nbsp;',$mainDesc);
                         $img='';
			 $bgcolor='';
			 $bgcolor1='#f9f9f9';
			 if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PREFERED_FK_GLUSR_ID']))
				{
					$img .='<font color="red">*</font>';
					$bgcolor='ffffca';
					$bgcolor1=$bgcolor;
				}
				$Detail=isset($arr['ADDITIONALINFO']) ? $arr['ADDITIONALINFO'] :'';
				$Detail=json_decode($Detail);
				
				
	
			
			$OFFER_DATE=isset($arr['OFR_DATE']) ? $arr['OFR_DATE'] : '';
			
			$date = date_create($OFFER_DATE);
			$date=  date_format($date, 'd-m-Y H:i:s');
			
			$ETO_OFR_TITLE=isset($arr['ETO_OFR_TITLE']) ? $arr['ETO_OFR_TITLE'] : '';
			$GLUSR_COUNTRY_BUY =isset($arr1['UserDetail']['data']['GLUSR_COUNTRY']) ? $arr1['UserDetail']['data']['GLUSR_COUNTRY'] : '';
			
			
			$html .=  '<TR>
				<TD bgcolor="'.$bgcolor1.'" WIDTH="30%" VALIGN="TOP">
				<DIV STYLE="font-family:arial;font-size:12px;padding:5px;">Offer Posting Date: '.$date.'<BR>
				<B>'.$img.' '.$ETO_OFR_TITLE.'<FONT COLOR="#0000FF"> ['.$GLUSR_COUNTRY_BUY.']</FONT></B><BR>
				'.$mainDesc.'';
                         if(isset($arr['ETO_OFR_QTY']))
				{
					$html.= '<BR>Preferred Quantity: '.$arr['ETO_OFR_QTY'].'';
				}
				
				if(isset($arr['ETO_OFR_QTY_UNIT']))
				{
					$html.= '&nbsp;'.$arr['ETO_OFR_QTY_UNIT'];
				}
			
				if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_OFR_SUPPLY_TERM']))
				{
					$html.=  '<BR>Delivery Terms: '.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_SUPPLY_TERM'].'';
				}
			
			
				if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAY_TERM']))
				{
					$html.=  '<BR>Payment Terms: '.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAY_TERM'].'';
				}
		
				if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER']))
				{
					
					if(preg_match('/http/',$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER']) )
					  { 
					  $html.= '<BR><p style="width:40em;word-wrap:break-word;">Enquiry Source: <a href="'.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER'].'" style="text-decoration:none" target="_blank" TITLE="'.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER'].'">View</a></p>';
					  }
					  else if(preg_match('/www/',$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER']) or preg_match('/m\.indiamart\.com/',$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER']))
					  {
					    $html.= '<BR><p style="width:40em;word-wrap:break-word;">Enquiry Source: <a href="http://'.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER'].'" style="text-decoration:none" target="_blank" TITLE="'.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER'].'">View</a></p>';
					  }
					  else
					  {
					  $html.= '<BR><p style="width:40em;word-wrap:break-word;">Enquiry Source: <span TITLE="'.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_PAGE_REFERRER'].'" >View</span></p>';
					  }
					  
				}
	
				if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP']))
                                {
                                  
                                    if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_MODULE_ID']) && $arr['SUPPLIER_DETAIL'][1]['ETO_MODULE_ID'] =='FENQ')
                                    
                                    {
                                        $html.= '<BR>
                                        This enquiry has been generated through IP:- '.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP'];
                                     
                                        if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP_COUNTRY']) && $arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP_COUNTRY'] != 'NA')
                                        {
                                                $html.= ' ('.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP_COUNTRY'].')';
                                        }
                                    }else{
                                        $html.= '<BR>
                                        This Buy Lead has been generated through IP:- '.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP'];
                                         if(isset($arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP_COUNTRY']) && $arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP_COUNTRY'] != 'NA')
                                        {
                                                $html.= ' ('.$arr['SUPPLIER_DETAIL'][1]['ETO_OFR_S_IP_COUNTRY'].')';
                                        }
                                    } 
                                }
                                $html .='<br><br>';
                                if($Detail)
                                {
                                foreach($Detail as $key=>$value)
				{
				$html .="$key: $value";
				$html .='<br>';
				}
                                }
                                $attach_cnt=1;
                                
                               if(!empty($arr['ATTACHMENT_DETAIL']))
                               {
                               foreach($arr['ATTACHMENT_DETAIL'] as $array2)
				{
			
                                  if(isset($array2['ETO_OFR_ATTACH_IMG_ORIG'])){
                                        $html .="Attachment$attach_cnt: ";
                                        $html .= '<a href='.$array2['ETO_OFR_ATTACH_IMG_ORIG'].' target="_blank">'.$array2['ETO_OFR_ATTACH_IMG_ORIG'].'</a>';
                                        $html .= '<br>';
                                        $attach_cnt++;
                                  }
				}
				
				}
                               
                               if(!empty($arr1))
                               {
                               $GLUSR_NAME=isset($arr1['UserDetail']['data']['FULL_NAME']) ? $arr1['UserDetail']['data']['FULL_NAME'] : '';
				$html.=  '<BR><BR>
				<B>Buyer\'s Information-</B><BR>
				<DIV>Name: '.$GLUSR_NAME.'';
	                         
				if(isset($arr1['UserDetail']['data']['GLUSR_DESIGNATION']))
				{
					$html.=  ' ('.$arr1['UserDetail']['data']['GLUSR_DESIGNATION'].')';
				}
				$html.=  "</div>";
	
				if(isset($arr1['UserDetail']['data']['GLUSR_COMPANY']))
				{
					$html.=  '<div>Company: '.$arr1['UserDetail']['data']['GLUSR_COMPANY'].'</div>';
				}
	
				if(isset($arr1['UserDetail']['data']['GLUSR_ADDRESS']))
				{
					$html.=  '<DIV>Address: '.$arr1['UserDetail']['data']['GLUSR_ADDRESS'].'</DIV>';
				}
	
				if(isset($arr1['UserDetail']['data']['GLUSR_CITY']))
				{
					$html.= '<DIV>City: '.$arr1['UserDetail']['data']['GLUSR_CITY'].'</DIV>';
				}
		
				if(isset($arr1['UserDetail']['data']['GLUSR_STATE']))
				{
					$html.=  '<DIV>State: '.$arr1['UserDetail']['data']['GLUSR_STATE'].'</DIV> ';
				}
	                        if(isset($arr1['UserDetail']['data']['GLUSR_COUNTRY']))
				{
				$html .= '<DIV>Country: '.$arr1['UserDetail']['data']['GLUSR_COUNTRY'].'</DIV>';
				}
				if(isset($arr1['UserDetail']['data']['GLUSR_ZIP']))
				{
					$html.= '<DIV>Postal Code: '.$arr1['UserDetail']['data']['GLUSR_ZIP'].'</DIV>';
				}
				if(isset($arr1['UserDetail']['data']['GLUSR_PHONE']))
				{
				$html .=  '<div>Telephone: '.$arr1['UserDetail']['data']['GLUSR_PHONE'].'</div>';
				}
				if(isset($arr1['UserDetail']['data']['GLUSR_USR_FAX_NUMBER']))
				{	
					$html.=  '<div>Fax: '.$arr1['UserDetail']['data']['GLUSR_USR_FAX_NUMBER'].'</div>';
				}
			
				if(isset($arr1['UserDetail']['data']['GLUSR_USR_PH_MOBILE']))
				{
				        $mobile =$arr1['UserDetail']['data']['GLUSR_USR_PH_MOBILE'];
					if(isset($arr1['UserDetail']['data']['GLUSR_USR_PH_MOBILE_ALT']))
					{
						$mobile .= '/'.$arr1['UserDetail']['data']['GLUSR_USR_PH_MOBILE_ALT'].'';
					}
					$html.=  '
					<div>Mobile / Cell Phone: '.$mobile.'</div>';
				}
				if(isset($arr1['UserDetail']['data']['GLUSR_USR_EMAIL']))
				{
				
				$html .= '
				<div>Email: '.$arr1['UserDetail']['data']['GLUSR_USR_EMAIL'].'</div>';
	                        }
				 $length_url = isset($arr1['UserDetail']['data']['ETO_OFR_GLUSR_DISP_URL']) ? $arr1['UserDetail']['data']['ETO_OFR_GLUSR_DISP_URL'] : '';
				if($length_url)
				{
					$html.= '<DIV>Website: <A HREF="'.$length_url.'" target="_new">'.$length_url.'</A></DIV>';
				}
	
				$html.= '</DIV></TD>
				<TD WIDTH="70%" VALIGN="TOP">
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR=\'#E1EAE0\' STYLE=\'border-collapse:collapse;\'>';
				
				}
			
			
			if(!empty($arr['SUPPLIER_DETAIL']))
                          {
			 foreach($arr['SUPPLIER_DETAIL'] as $array3)
			 {
			
			 if(isset($array3['FK_GLUSR_USR_ID']) && isset($array3['STATUS']))
			 {
			 $html.='
			<TR bgcolor="'.$bgcolor2.'">
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="10%">';
			 
			if(isset($array3['GLUSR_STATUS']) && $array3['GLUSR_STATUS'] == 1)
			{				
				$html.=  '<IMG SRC="../images/paid-usr.gif" ALT="Paid Credit Used" WIDTH="8" HEIGHT="8" HSPACE="2">';
				if(isset($array3['ETO_LEAD_FK_GL_MODULE_ID']) && $array3['ETO_LEAD_FK_GL_MODULE_ID']=='AST BUY')
				{
					$html.=  '&nbsp;<IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}				
				if(isset($array3['PREFERRED_STATUS']))
				{
					$html.=  '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}
	
				
			}
			else
			{
			 $html .= '<IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="2">';
				if(isset($array3['ETO_LEAD_FK_GL_MODULE_ID']) &&  $array3['ETO_LEAD_FK_GL_MODULE_ID'] == 'AST BUY')
				{
					$html.=  '&nbsp;<IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}	
				if(isset($array3['PREFERRED_STATUS']))
				{
					$html.=  '&nbsp;<IMG SRC="../images/paid-usr1.gif" ALT="Pre Client" WIDTH="8" HEIGHT="8" HSPACE="2">';
				}
				
			}
			 $FK_GLUSR_USR_ID=isset($array3['FK_GLUSR_USR_ID']) ? $array3['FK_GLUSR_USR_ID'] : '';
			 $GLUSR_COMPANY=isset($array3['GLUSR_COMPANY']) ? $array3['GLUSR_COMPANY'] : '';
			 $ETO_CREDITS_USED=isset($array3['ETO_CREDITS_USED']) ? $array3['ETO_CREDITS_USED'] :'';
			 $AVG_PER_CREDIT_COST=isset($array3['AVG_PER_CREDIT_COST']) ? $array3['AVG_PER_CREDIT_COST'] : '';
			 
 	
			$html .='&nbsp;<A HREF="javascript:popup(\'/index.php?r=admin_bl/Transaction_report/Index/action/transDetails/nofrm/1/mid/3442/glusrid/'.$FK_GLUSR_USR_ID.'\');">'.$FK_GLUSR_USR_ID.'</A>
			&nbsp;</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="15%" ALIGN="CENTER">'.$GLUSR_COMPANY.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="15%" ALIGN="CENTER">';
	
			if(isset($array3['GLUSR_CITY']))
			{
				$html.= ''.$array3['GLUSR_CITY'].' / ';
			}
			
			$avgPrice=$ETO_CREDITS_USED*$AVG_PER_CREDIT_COST;
			
			$GLUSR_COUNTRY=isset($array3['GLUSR_COUNTRY']) ? $array3['GLUSR_COUNTRY'] : '';
			$PUR_DATE=isset($array3['PUR_DATE']) ? $array3['PUR_DATE'] : '';
			$date = date_create($PUR_DATE);
			$PUR_DATE=  date_format($date, 'd-m-Y H:i:s');
			
			$ETO_LEAD_FK_GL_MODULE_ID=isset($array3['ETO_LEAD_FK_GL_MODULE_ID']) ? $array3['ETO_LEAD_FK_GL_MODULE_ID'] :'';
		        if($ETO_LEAD_FK_GL_MODULE_ID=='IM'){
                            $ETO_LEAD_FK_GL_MODULE_ID='Purchase';
                        }
			
			$html.=  ''.$GLUSR_COUNTRY.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="10%" ALIGN="CENTER">'.$PUR_DATE.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="5%" ALIGN="CENTER">'.$ETO_CREDITS_USED.' Credits</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH="5%" ALIGN="CENTER">'.$avgPrice.'</TD>
			<TD STYLE="font-family:arial;font-size:11px;" WIDTH=10%" ALIGN="CENTER"><FONT COLOR="red"><B>'.$ETO_LEAD_FK_GL_MODULE_ID.'</B></FONT></TD>';
 			$ETO_UNSOLD_RELAX_FLAG=isset($array3['ETO_UNSOLD_RELAX_FLAG']) ? $array3['ETO_UNSOLD_RELAX_FLAG'] :'';
 			if($ETO_UNSOLD_RELAX_FLAG ==7)
 			{
 			 $enquiry_send='No';
			}
			else
 			{
 			 $enquiry_send='Yes';
 			}
 			$html.='<TD STYLE="font-family:arial;font-size:11px;" WIDTH="5%" ALIGN="CENTER">'.$enquiry_send.'</TD>';
 			
			$html.='</TR>';
		
		}
	            }
	            }
		
	
		$html.= '</TABLE>';
		$totalOfferPur=$totalOfferPurBL=$totalOfferPurAST=0;
	 
	if(!empty($arr['SUPPLIER_DETAIL']))
                          {
			 foreach($arr['SUPPLIER_DETAIL'] as $array4)
			 {
			
			 if(isset($array4['FK_GLUSR_USR_ID']) && isset($array4['STATUS']))
			 {
                            $totalOfferPur= $totalOfferPur+1;
                            if(isset($array4['ETO_LEAD_FK_GL_MODULE_ID']) && $array4['ETO_LEAD_FK_GL_MODULE_ID']=='IM')
                            {
                                $totalOfferPurBL= $totalOfferPurBL+1;
                            }else{
                                $totalOfferPurAST= $totalOfferPurAST+1;
                            }
			  }
			  }
			}
		else
		{
		$totalOfferPur=$totalOfferPurBL=$totalOfferPurAST=0;
		}
		$totalCredit=0;
		$totalAvgPrice=0;
		if(!empty($arr['SUPPLIER_DETAIL']))
		{
		  foreach($arr['SUPPLIER_DETAIL'] as $array)
		  {
		   $ETO_CREDITS_USED1=isset($array['ETO_CREDITS_USED']) ? $array['ETO_CREDITS_USED'] :'';
		   $AVG_PER_CREDIT_COST1=isset($array['AVG_PER_CREDIT_COST']) ? $array['AVG_PER_CREDIT_COST'] :'';
		   
		   $totalCredit =$totalCredit+ $ETO_CREDITS_USED1;
		   $avgPrice=$ETO_CREDITS_USED1*$AVG_PER_CREDIT_COST1;
		   $totalAvgPrice=$totalAvgPrice+$avgPrice;
		  }
		 }
		
				$html .='
				<TABLE WIDTH="100%" BORDER="0" CELLPADDING="2" CELLSPACING="1" HEIGHT="25" BORDERCOLOR="#E1EAE0">
				<TR>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="30%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;color:#0000AA;" WIDTH="22%" ALIGN="RIGHT" BGCOLOR="#DFDFFF"><B>Lead Summary</B>&nbsp;</TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalOfferPur.' Purchase</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="12%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalCredit.' Credits</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="8%" BGCOLOR="#DFDFFF"><B CLASS="padding-left:5px;">'.$totalAvgPrice.'</B></TD>
				<TD STYLE="font-family:arial;font-size:12px;" WIDTH="4%" BGCOLOR="#DFDFFF">&nbsp;</TD>
				</TR>
				</TABLE></TABLE>
				';
			
			
		
		$html .='<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="right" width="70%">
		<TR bgcolor="#ffffff">
		<TD STYLE="font-family:arial;font-size:12px;" colspan="3" align="left" width="100%">
		<FONT size="3"><B>Summary-</B></font></TD>
		</TR>
		<TR bgcolor="#e1eae0"">
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser</B></TD>
                <TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser -IM</B></TD>
                <TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser - ASTBUY</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Credit Used</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Avg Price</B></TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPur.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPurBL.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPurAST.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalCredit.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalAvgPrice.'</TD>
		</TR>
		</TABLE>';
		
		
		}
		else
		{
		$html='';	
		$html.= '<STYLE TYPE="text/css">
		.admintext {font-family:ms sans serif,verdana; font-size:12px;font-weight:bold;line-height:17px;}
		.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}</STYLE>
		<script LANGUAGE="JavaScript" SRC="../protected/js/eto-buy-sale-report.js"></SCRIPT>

		<div><br></div>
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding:3px;color:#006FB6;">
		Complete purchase Summary for Offer Id: '.$offer.'
		<DIV STYLE="font-size:11px;color:#000000;font-weight:normal;">
		(<FONT COLOR="#FF0000">*</FONT>) Indicates Preferred Enquiry | <IMG SRC="../images/paid-usr.gif" ALT="Paid Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Paid Clients (Havinig atleast one Paid Credit Transaction) | <IMG SRC="../images/free-user.gif" ALT="Free Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Free Clients | <IMG SRC="../images/paid-usr1.gif" ALT="Preferred Client" WIDTH="8" HEIGHT="8" HSPACE="4">PBL Preferred Clients | <IMG SRC="../images/unsold-usr.gif" ALT="Introduced through Assisted Buying Service" WIDTH="8" HEIGHT="8" HSPACE="4">Introduced through Assisted Buying Service
		</DIV>
		</DIV>

		<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="0">
		<TR>
			<TD BGCOLOR="#E5E5E5" STYLE="font-family:arial;font-size:12px;font-weight:bold;" HEIGHT="30" 
			WIDTH="30%">&nbsp;Buy Lead Details</TD>
			<TD BGCOLOR="#FFFFFF" WIDTH="65%">
			<TABLE WIDTH="100%" BORDER="0" CELLPADDING="0" CELLSPACING="1" HEIGHT="30">
			<TR>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%">&nbsp;<B>GL User</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="25%"><B>&nbsp;Company</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="15%"><B>&nbsp;City / Country</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="20%"><B>&nbsp;Purchased On</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>&nbsp;Credit Used</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="5%"><B>&nbsp;Avg Amt</B></TD>
			<TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="10%"><B>&nbsp;Src</B></TD>
                        <TD BGCOLOR="#CCCCFF" STYLE="font-family:arial;font-size:11px;" ALIGN="CENTER" WIDTH="5%" align="CENTER"><B>&nbsp;Enquiry Sent</B></TD>';			
			$html.= '</TR>
			</TABLE></TD>
		</TR>
		</TABLE>
		<input type="hidden" name="offer_details" id="offer_details" value="0">';
		$totalOfferPur=$totalOfferPurBL=$totalOfferPurAST=$totalCredit=$totalAvgPrice=0;
		$html .='<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" align="right" width="70%">
		<TR bgcolor="#ffffff">
		<TD STYLE="font-family:arial;font-size:12px;" colspan="3" align="left" width="100%">
		<FONT size="3"><B>Summary-</B></font></TD>
		</TR>
		<TR bgcolor="#e1eae0"">
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser</B></TD>
                <TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser -IM</B></TD>
                <TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Purchaser - ASTBUY</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Credit Used</B></TD>
		<TD STYLE="font-family:arial;font-size:14px;" align="left" width="20%"><B>Total Avg Price</B></TD>
		</TR>
		<TR>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPur.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPurBL.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalOfferPurAST.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalCredit.'</TD>
		<TD STYLE="font-family:arial;font-size:12px;" align="left" width="20%">'.$totalAvgPrice.'</TD>
		</TR>
		</TABLE>';
	        
		}
		
	
	
  return $html;


}  



	public function rfq_service($glusr_id,$start,$end)
	{
		 $content=array();
	   $content = array(
	   'token' =>'imobile1@15061981',
	   'modid' =>'GLADMIN',
	   'glusrid' => $glusr_id,
	   'supplier_info' =>'YES',
	   'additionalinfo' =>'YES',
	   'quotation'=>1,
	   'buyer_response'=>1,
	   'type'=>'B',
	   'attachment'=>1,
	   'start'=>$start,
	   'end'=>$end,
	   'is_approved'=>'YES');
	$req = ($_SERVER['SERVER_NAME'] == 'gladmin.intermesh.net') ? 'https://leads.imutils.com/wservce/rfq/display/':'http://stg-mapi.indiamart.com/wservce/rfq/display/';
	 $data_string = http_build_query($content);
	$msg='';
	$flag='';
	$arr=array();

		$ServiceGlobalModelForm = new ServiceGlobalModelForm();
		$response = $ServiceGlobalModelForm->mapiService('RFQDISPLAY',$req,$data_string,'No');
		
		if (!is_array($response)) {
			$msg = "Mapi Server Connectivity Issue\n\n Service URL:-$req";
			mail("gladmin-team@indiamart.com","RFQDISPLAY Service Failed",$msg);
			die;
		} 
		else
		{
			$arr=isset($response['RESPONSE']['DATA']) ? $response['RESPONSE']['DATA'] : '';  
		}

		if(!empty($arr['Listing']))
		{
			$offer_size=sizeof($arr['Listing']);
		}
		else
		{
			$offer_size=0;
		}
		
		$html1='';
		$p=1;
		
		if(!empty($arr['Listing']))
		{
			foreach($arr['Listing'] as $temp)
			{
				$html=$this->disp_html2($temp,$temp['ETO_OFR_DISPLAY_ID'],$flag,$arr);
				$html .= "<BR/><BR/><DIV STYLE = 'BORDER:2PX SOLID GREY;WIDTH:100%;FLOAT:LEFT;';></DIV><BR/><BR/>"; 
				$html1 .=$html;
			}
		}
		else
		{
			$html1='';
		}
		return array($html1,$p,$offer_size)  ;   
	} 

	

   public function prefcitydetail()
  {
    $glid=$_REQUEST['glid'];
    $str_country=$str=$str_dis=$str_city=$str_state='';   
  $sql="select distinct (select gl_city_name from gl_city WHERE ETO_GLUSR_PREF_CITY.city_ID=gl_city.gl_city_id) CITY
        from ETO_GLUSR_PREF_CITY
        where
        Pref_type =0
        and CS_IS_ENABLE is null
        and GLUSR_USR_id=:GLID ";

        $bind[':GLID']=$glid;
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        
         $count_city=0;
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
        try{
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
            while($rec = $sth->read()) {//print_r($rec);
                     $str_city .= '<li class="chip" style="background-color: #dcf9dc;">'.$rec['city']."</li>";
                     $count_city++;
            }
            if($count_city==0){
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Cities</b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Cities</b></td></tr><tr><td><ul>'.$str_city."</ul></td></tr></table><br><br>";
            }           
            } catch (Exception $ex) {
        }
       
try{              
  $sql="select distinct (select gl_city_name from gl_city WHERE ETO_GLUSR_PREF_CITY.FK_GL_DISTRICTS_ID=gl_city.gl_city_id) CITY_DISTRICT
from ETO_GLUSR_PREF_CITY
where
Pref_type =2
and CS_IS_ENABLE is null
and GLUSR_USR_id=:GLID";
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
            $count_dis=0;
         while($rec = $sth->read()) {//print_r($rec);
                     $str_dis .= '<li class="chip" style="background-color: #dcf9dc;">'.$rec['city_district']."</li>";
                     $count_dis++;
            }
            if($count_dis==0){
                $str_dis ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Districts<b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_dis ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Districts<b></td></tr><tr><td><ul>'.$str_dis."</td></tr></table><br><br>";
            }
        } catch (Exception $ex) {
        }
         try{              
  $sql="select distinct (select gl_country_name from gl_country WHERE ETO_GLUSR_PREF_CITY.fk_gl_country_iso=gl_country.gl_country_iso) COUNTRY 
            from ETO_GLUSR_PREF_CITY
            where
            Pref_type =1
            and CS_IS_ENABLE is null 
            and GLUSR_USR_id=:GLID";
            $sthcountry = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
            $count_country=0;
         while($rec = $sthcountry->read()) {//print_r($rec);
                     $str_country .= '<li class="chip" style="background-color: #dcf9dc;">'.$rec['country']."</li>";
                     $count_country++;
            }
            if($count_country==0){
                $str_country ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Countries<b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_country ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Countries<b></td></tr><tr><td><ul>'.$str_country."</td></tr></table><br><br>";
            }
        } catch (Exception $ex) {
        }
        
        try{              
  $sql="select distinct (select gl_state_name from gl_state WHERE ETO_GLUSR_PREF_CITY.fk_gl_state_id=gl_state.gl_state_id) state 
        from ETO_GLUSR_PREF_CITY
        where
        Pref_type =3
        and CS_IS_ENABLE is null and GLUSR_USR_id=:GLID";
            $sthstate = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
            $count_state=0;
         while($rec = $sthstate->read()) {//print_r($rec);
                     $str_state .= '<li class="chip" style="background-color: #dcf9dc;">'.$rec['state']."</li>";
                     $count_state++;
            }
            if($count_state==0){
                $str_state ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred States<b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_state ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred States<b></td></tr><tr><td><ul>'.$str_state."</td></tr></table><br><br>";
            }
        } catch (Exception $ex) {
        }
        $str=$str_country.$str_state.$str_dis.$str_city;  
        return $str;
        }  
        
  public function negativecitydetail()
  {
    $glid=$_REQUEST['glid'];
    $str=$str_dis=$str_city=$str_country='';   
  $sql="select distinct (select gl_city_name from gl_city WHERE ETO_GLUSR_PREF_CITY.city_ID=gl_city.gl_city_id) CITY
from ETO_GLUSR_PREF_CITY
where
Pref_type =0
and CS_IS_ENABLE=-1
and GLUSR_USR_id=:GLID ";

        $bind[':GLID']=$glid;
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        
         $count_city=0;
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }         
        try{
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
         while($rec = $sth->read()) {//print_r($rec);
                 $rarr=array_change_key_case($rec, CASE_UPPER);                 
                     $str_city .= '<li class="chip" style="background-color: #dcf9dc;">'.$rarr['CITY']."</li>";
                     $count_city++;
            }
            if($count_city==0){
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Negative Cities</b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Negative Cities</b></td></tr><tr><td><ul>'.$str_city."</ul></td></tr></table><br><br>";
            }           
            } catch (Exception $ex) {
        }
        try{              
        $sql="select distinct (select gl_country_name from gl_country WHERE ETO_GLUSR_PREF_CITY.fk_gl_country_iso=gl_country.gl_country_iso) COUNTRY 
            from ETO_GLUSR_PREF_CITY
            where
            Pref_type =1
            and CS_IS_ENABLE =-1
            and GLUSR_USR_id=:GLID";
            $sth_countrt = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
            $count_country=0;
         while($rec = $sth_countrt->read()) {//print_r($rec);
                 $rarr=array_change_key_case($rec, CASE_UPPER);                 
                     $str_country .= '<li class="chip" style="background-color: #dcf9dc;">'.$rarr['COUNTRY']."</li>";
                     $count_country++;
            }
            if($count_country==0){
                $str_country ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Negative Countries<b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_country ='<br><table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Negative Countries<b></td></tr><tr><td><ul>'.$str_country."</td></tr></table><br><br>";
            }
        } catch (Exception $ex) {
        }
        $str=$str_country.$str_city;
        return $str;
        } 
        
        
        
 public function getUserDetails($usr, $idname)
    {
        $global_model=new GlobalmodelForm();
        $objcon = new Globalconnection();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $objcon->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $objcon->connect_db_yii('postgress_web68v'); 
        }                                
       
        $idname    = isset($idname) ? $idname : 0;
        $sql       = '';
        $ha        = '';
        $hash      = array();
        $hash_name = array(
            'GLUSR_USR_ID' => 'id',           
            'GLUSR_USR_FIRSTNAME' => 'first_name',
            'GLUSR_USR_LASTNAME' => 'last_name',
            'GLUSR_USR_EMAIL' => 'email',
            'GLUSR_USR_COMPANYNAME' => 'company_name',
            'GLUSR_USR_ADD1' => 'add1',
            'GLUSR_USR_ADD2' => 'add2',
            'GLUSR_USR_CITY' => 'city',
            'GLUSR_USR_STATE' => 'state',
            'GL_COUNTRY_NAME' => 'country',
            'GL_COUNTRY_ISO' => 'country_iso',
            'GLUSR_USR_ZIP' => 'zip',
            'GLUSR_USR_PH_COUNTRY' => 'ph_country',
            'GLUSR_USR_PH_AREA' => 'ph_area',
            'GLUSR_USR_PH_NUMBER' => 'ph_no',
            'GLUSR_USR_PH_MOBILE' => 'mobile',
            'GLUSR_USR_FAX_COUNTRY' => 'fax_country',
            'GLUSR_USR_FAX_AREA' => 'fax_area',
            'GLUSR_USR_FAX_NUMBER' => 'fax_no',           
            'GLUSR_USR_APPROV' => 'approv',              
            'GLUSR_USR_PH2_COUNTRY' => 'ph_country2',
            'GLUSR_USR_PH2_AREA' => 'ph_area2',
            'GLUSR_USR_PH2_NUMBER' => 'ph_no2',
            'GLUSR_USR_EMAIL_ALT' => 'email2',          
            'FREESHOWROOM_URL' => 'fcpurl',
            'FCP_FLAG' => 'fcp_flag',
            'PAIDSHOWROOM_URL' => 'paidurl',           
            'GLUSR_ETO_CUST_LAST_PUR_DATE' => 'eto_cust_last_pur_date',
            'GLUSR_ETO_CUST_CREDITS_AV' => 'eto_cust_credits_av',
            'GLUSR_ETO_CUST_CREDITS_TOTAL' => 'eto_cust_credits_total',           
            'GLUSR_USR_COUNTRYNAME' => 'country_name',
            'GLUSR_USR_PH_MOBILE_ALT' => 'mobile2',           
            'GLUSR_USR_CUSTTYPE_NAME'=>'glusr_usr_custtype_name'
        );
        if ($idname == 0) {
            $sql = "Select * from GLUSR_USR where GLUSR_USR_ID=$usr";           
        } else {
            $usr=strtoupper($usr);
            $sql = "Select * from GLUSR_USR where GLUSR_USR_EMAIL_DUP='$usr' limit 1";          
        }
        $sth = $global_model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
        if ($sth) {
            $ha        = $sth->read();
            if(!empty($ha)) 
            $ha=array_change_key_case($ha,CASE_UPPER);
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
    
 
   public function mcatreportdetail()
  {
    $selday=isset($_REQUEST['selday'])?$_REQUEST['selday']:'';
    $mcat_id=isset($_REQUEST['mcat_id'])?$_REQUEST['mcat_id']:'';
    $glid=isset($_REQUEST['glid'])?$_REQUEST['glid']:'';
$count_city=0;
    $td=$str='';   
  $sql="SELECT
       ETO_OFR_TITLE,ETO_OFR_DISPLAY_ID,to_char(ETO_PUR_DATE,'DD-MON-YYYY') eto_pur_date,GLUSR_USR_CITY LOC FROM 
    ETO_LEAD_PUR_HIST,
     GLUSR_USR,
     (select ETO_OFR_TITLE,ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID from ETO_OFR 
     UNION ALL 
     select ETO_OFR_TITLE,ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID from ETO_OFR_EXPIRED 
     ) ETO_OFR      
WHERE
ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID =GLUSR_USR_ID
AND ETO_OFR.ETO_OFR_DISPLAY_ID=ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID
AND DATE_TRUNC('day',ETO_PUR_DATE) >= CURRENT_DATE - interval '$selday day'
AND ETO_OFR.FK_GLCAT_MCAT_ID = :mcat_id
AND ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID= :glid 
AND FK_ETO_OFR_ID <> -1
order by ETO_OFR_TITLE";
        $bind[':mcat_id']=$mcat_id;
        $bind[':glid']=$glid;

        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        
        try{
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
            while($rec = $sth->read()) {
                $count_city++;
                     $td .= '<tr><td>'.$rec['eto_ofr_title']."</td>".'<td>'.$rec['loc']."</td><td>".$rec['eto_ofr_display_id']."</td>".'<td>'.$rec['eto_pur_date']."</td></tr>";
            }
            if($count_city > 0){
                $str ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr>'
                        . '<td bgcolor="#dff8ff" align="center" colspan="4"><b>Detail Purchase Report for GLusr ID-'.$glid.'</b></td></tr><tr><td><b>BL Title</b></td>'
                        . '<td><b>City</b></td><td><b>Offer ID</b></td><td><b>BL Purchase Date</b></td></tr>'.$td.'</table><br><br>';
            }else{
                $str ='<div style="font-style:bold;color:red;align:center;">No Record found</div><br><br>';
            }           
        } catch (Exception $ex) {
        }
        return $str;
        }  

        
   public function mcatreport()
  {
    $selday=isset($_REQUEST['selday'])?$_REQUEST['selday']:'';
    $mcat_id=isset($_REQUEST['mcat_id'])?$_REQUEST['mcat_id']:'';
   $tot_cnt=0;
    $td=$str='';
    $sql="SELECT A.*,
COUNT(GLID) OVER () TOT_CNT
FROM
(
   SELECT
   GLID,
   GLUSR_USR_COMPANYNAME COMPANYNAME,
   count(1) CNT from
   (
       SELECT
       ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID GLID
       FROM ETO_LEAD_PUR_HIST,
       (
           select ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR
           WHERE FK_GLCAT_MCAT_ID = :MCAT_ID 
           UNION ALL
           SELECT ETO_OFR_DISPLAY_ID,FK_GLCAT_MCAT_ID FROM ETO_OFR_EXPIRED
           WHERE FK_GLCAT_MCAT_ID = :MCAT_ID 
       ) ETO_OFR
       WHERE ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID=ETO_OFR.ETO_OFR_DISPLAY_ID
       AND ETO_PUR_DATE >= date(now()) - interval '$selday days'
       AND FK_ETO_OFR_ID >0
   )A, glusr_usr
   where  GLID =GLUSR_USR_ID
   GROUP BY GLID, GLUSR_USR_COMPANYNAME
   order by cnt desc limit 100
) A
";
        $bind[':MCAT_ID']=$mcat_id;
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        $cnt=0;$tot_cnt=0;
        try{
            $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, $bind);//echo $sql; 
            while($rec = $sth->read()) {
                $tot_cnt=$rec['tot_cnt'];
                $cnt++;
                     $td .= '<tr><td>'.$rec['glid']."</td>".'<td>'.$rec['companyname'].'</td><td>'.$rec['cnt'];
                           $glid=$rec['glid'];
               $td .=  "<a href='javascript:void(0)' onclick=\"showdetail('$glid','$mcat_id','$selday');\" style='text-decoration:none;color:#0000ff' ><b>+</b></a></td></tr>";
            }
            if($tot_cnt > 0){
                if($tot_cnt>100){
                    $str ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr>'
                        . '<td bgcolor="#dff8ff" align="center" colspan="3"><b>MCAT Wise Purchase Summary Total records '.$tot_cnt  .' found. (Top 100 Records are displaying)</b></td></tr><tr><td><b>GlusrID</b></td>'
                        . '<td><b>Company name</b></td><td><b>BL Trxn Count</b></td></tr>'.$td.'</table><br><br>';
                }else{
                    $str ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr>'
                        . '<td bgcolor="#dff8ff" align="center" colspan="3"><b>MCAT Wise Purchase Summary Total records '.$tot_cnt  .' found. </b></td></tr><tr><td><b>GlusrID</b></td>'
                        . '<td><b>Company name</b></td><td><b>BL Trxn Count</b></td></tr>'.$td.'</table><br><br>';
                }
                
            }else{
                $str ='<div style="font-style:bold;color:red;align:center;">No Record found</div><br><br>';
            }           
        } catch (Exception $ex) {
        }
        return $str;
        }  
        
    public function detail_purchase_data()
  {
        $bind[':MCAT_ID']=$mcat_id;
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web68v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }
        $cnt=0;$tot_cnt=0;
        }  
  
    function getdata(){
		$result = array();
		try{
        $glusrid = isset($_REQUEST['gl_id']) ? $_REQUEST['gl_id']:'';  
        $days = isset($_REQUEST['fromdays']) ? $_REQUEST['fromdays']:''; 
        $rtype=isset($_REQUEST['rtype']) ? $_REQUEST['rtype'] : 'both';

        $condate='';
        if($days =='all')
	{
        $NewDate=Date('Y-m-d', strtotime('-180 days'));
	$condate=" where TXN_DATE >= '$NewDate' ";
	}
	else
	{
        $NewDate=Date('Y-m-d', strtotime('-90 days'));
	$condate=" where TXN_DATE >= '$NewDate' ";
	}
        if($rtype=='bl'){
            $condate .=' AND FLAG IN (2,5,8,9,10) and FK_ETO_OFR_ID NOT IN (-1,-2,-3,-4) ';
        }elseif($rtype=='astbuy'){
            $condate .=' AND FLAG IN (6,7)';
        }
        $ctype =isset($_REQUEST['ctype']) ? $_REQUEST['ctype']:'';
        

if($ctype=='F'){
        $ETO_LEAD_PUR_HIST='IIL_LEAD_PUR_HIST';
        $ETO_CUST_PURCHASE_HIST='IIL_CUST_PURCHASE_HIST';
        $IIL_CREDIT_REVERSAL='IIL_USER_CREDIT_REVERSAL';
}else{
        $ETO_LEAD_PUR_HIST='ETO_LEAD_PUR_HIST';
        $ETO_CUST_PURCHASE_HIST='ETO_CUST_PURCHASE_HIST';
        $IIL_CREDIT_REVERSAL='IIL_CREDIT_REVERSAL';
}
if($ctype=='F'){
    $sql="SELECT * FROM
(
	SELECT * FROM
    (
        SELECT FLAG,
        (select TO_CHAR(min(ETO_PUR_DATE),'DD-Mon-YYYY') from IIL_LEAD_PUR_HIST where FK_GLUSR_USR_ID=$glusrid) as MIN_DATE,
        TDATE,OFR_DATE,
        FK_ETO_OFR_DATE,
        TDATE_IST,
        TDETAIL,
        CREDITUSED,
        BL_CREDITUSED,
        CREDITPURCHASED,
        BLCREDITPURCHASED,
        AMOUNTPAID,
        SUM(CREDITPURCHASED-CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BALANCE,
        SUM(BLCREDITPURCHASED-BL_CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BL_BALANCE,
        SUM(BLCREDITPURCHASED-BL_CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BL_BALANCE,
        (
            CASE WHEN FLAG=2 OR FLAG  =5 OR FLAG=6 OR FLAG=7 THEN (GLUSR_USR.GLUSR_USR_FIRSTNAME|| ' '|| GLUSR_USR.GLUSR_USR_LASTNAME) ELSE '-' END
		) BUYER_NAME,
        TXN_DATE,
        FK_ETO_OFR_ID,
        ETO_LEAD_PUR_IP,
        ETO_LEAD_PUR_IP_COUNTRY,
        ETO_LEAD_PUR_MODE,
        POSTDATE_ORIG_IST,
        OFRMCATNAME,
        FK_GLCAT_MCAT_ID,
        VERIFIED,
        POSTDATE_ORIG,
        BUYER_ID,
        ETO_OFR_TITLE,
        FK_GL_MODULE_ID,
        GLUSR_USR_CITY CITY,
        FK_GL_COUNTRY_ISO AS COUNTRY_ISO,
        GLUSR_USR_PH_MOBILE AS MOBILE,
        GLUSR_USR_PH_NUMBER AS PH_NUMBER,
        GLUSR_USR_EMAIL AS EMAIL,
        ETO_OFR_CALL_VERIFIED,
        ETO_OFR_EMAIL_VERIFIED,
        ETO_OFR_ONLINE_VERIFIED,
        CREDIT_REVERSAL_STATUS,
        (select a.gl_city_name from gl_city a,gl_city b where b.GL_CITY_DISTRICT_HQ = a.gl_city_id and fk_gl_city_id = b.gl_city_id) DISTRICT,
        glusr_usr_longitude,glusr_usr_latitude,
        eto_lead_latitude,eto_lead_longitude 
        FROM
        (
			SELECT
			CASE WHEN ETO_LEAD_PUR_TYPE = 'T' AND FK_ETO_OFR_ID <> -1
			THEN 9 WHEN FK_ETO_OFR_ID IN (-1,-2,-3) THEN 3 ELSE coalesce(LEAD_FLAG,10) END FLAG,
			TO_CHAR(ETO_PUR_DATE,'DD-Mon-YYYY')
			TDATE,TO_CHAR(ETO_PUR_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
			TO_CHAR(FK_ETO_OFR_DATE::date,'DD-Mon-YY') FK_ETO_OFR_DATE,
			TO_CHAR(ETO_PUR_DATE, 'DD-Mon-YYYY') TDATE_IST,
			CASE WHEN FK_ETO_OFR_ID IN (-1,-2,-3,-4,-5) THEN
			ETO_LEAD_PUR_LAPSE_MSG ELSE (case when ETO_LEAD_PUR_TYPE='T' then 'Tender No.
			' else 'Lead No. ' end) || FK_ETO_OFR_ID || ' Purchased' END TDETAIL,
			ETO_CREDITS_USED CREDITUSED,
			ETO_CREDITS_USED_LEADCNT BL_CREDITUSED,
			0 CREDITPURCHASED,
			0 BLCREDITPURCHASED,
			0 AMOUNTPAID,
			ETO_PUR_DATE TXN_DATE,
			ETO_OFR_GLUSR_USR_ID,
			FK_ETO_OFR_ID,
			ETO_LEAD_PUR_IP,
			ETO_LEAD_PUR_IP_COUNTRY,
			ETO_LEAD_PUR_MODE,
			TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY')
			POSTDATE_ORIG_IST,
			ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME,
			FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID,
			ETO_OFR_VERIFIED VERIFIED,
			TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG,
			ETO_OFR.FK_GLUSR_USR_ID BUYER_ID,
			ETO_OFR.ETO_OFR_TITLE,
			ETO_OFR.FK_GL_MODULE_ID,
			ETO_OFR_CALL_VERIFIED,
			ETO_OFR_EMAIL_VERIFIED,
			ETO_OFR_ONLINE_VERIFIED,
			(SELECT (case when COUNT(1)=0 then 0 else 1 end) FROM IIL_USER_CREDIT_REVERSAL 
			WHERE FK_GLUSR_USR_ID = $glusrid AND ETO_LEAD_PUR_ID = FK_ETO_LEAD_PUR_ID) CREDIT_REVERSAL_STATUS,
                        eto_lead_latitude,eto_lead_longitude  
			from
			(
				SELECT
				TO_CHAR(ETO_PUR_DATE,'DD-Mon-YYYY')
				TDATE,TO_CHAR(ETO_PUR_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
				TO_CHAR(FK_ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE,
				TO_CHAR(ETO_PUR_DATE, 'DD-Mon-YYYY') TDATE_IST,
				ETO_LEAD_PUR_TYPE,
				ETO_LEAD_PUR_LAPSE_MSG,
				ETO_CREDITS_USED CREDITUSED,
				ETO_CREDITS_USED,
				ETO_CREDITS_USED_LEADCNT BL_CREDITUSED,
				0 CREDITPURCHASED,
				0 BLCREDITPURCHASED,
				ETO_LEAD_PUR_ID,
				ETO_CREDITS_USED_LEADCNT,
				0 AMOUNTPAID,
				ETO_PUR_DATE TXN_DATE,
										ETO_PUR_DATE,
				ETO_OFR_GLUSR_USR_ID,
				FK_ETO_OFR_ID,
				ETO_LEAD_PUR_IP,
				ETO_LEAD_PUR_IP_COUNTRY,
				ETO_LEAD_PUR_MODE,
				(SELECT (case when COUNT(1)=0 then 0 else 1 end) FROM IIL_USER_CREDIT_REVERSAL WHERE FK_GLUSR_USR_ID = $glusrid 
                                    AND ETO_LEAD_PUR_ID = FK_ETO_LEAD_PUR_ID) CREDIT_REVERSAL_STATUS,
                                    eto_lead_latitude,eto_lead_longitude 
				FROM IIL_LEAD_PUR_HIST where IIL_LEAD_PUR_HIST.FK_GLUSR_USR_ID =  $glusrid
			) IIL_LEAD_PUR_HIST  left outer join
			( --shivi
				SELECT 5 LEAD_FLAG,
				ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_GLCAT_MCAT_NAME,FK_GLCAT_MCAT_ID,ETO_OFR_VERIFIED,FK_GLUSR_USR_ID,
				ETO_OFR.ETO_OFR_TITLE,ETO_OFR.FK_GL_MODULE_ID,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED
				FROM ETO_OFR
				UNION ALL
				SELECT 2 FLAG,
				ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_GLCAT_MCAT_NAME,FK_GLCAT_MCAT_ID,ETO_OFR_VERIFIED,FK_GLUSR_USR_ID,
				ETO_OFR.ETO_OFR_TITLE,ETO_OFR.FK_GL_MODULE_ID,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED
				FROM ETO_OFR_EXPIRED ETO_OFR
			)ETO_OFR on ETO_OFR.ETO_OFR_DISPLAY_ID = IIL_LEAD_PUR_HIST.FK_ETO_OFR_ID
			UNION ALL
			SELECT 1 FLAG,
			TO_CHAR(ETO_CUST_PURCHASE_DATE,'DD-Mon-YYYY')
			TDATE,TO_CHAR(ETO_CUST_PURCHASE_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
			NULL  FK_ETO_OFR_DATE,
			TO_CHAR(ETO_CUST_PURCHASE_DATE, 'DD-Mon-YYYY') TDATE_IST,
			(case when ETO_CUST_CREDIT_ISSUE_MSG=NULL then (case when ETO_CUST_ORDER_ID=-1 then 'Credits
			Allocated by Admin' else 'Credits Purchased' end) else ETO_CUST_CREDIT_ISSUE_MSG end) TDETAIL,
			0 CREDITUSED,
			0 BL_CREDITUSED,
			ETO_CUST_PURCHASE_CREDITS CREDITPURCHASED,
			ETO_CUST_LEAD_COUNT BLCREDITPURCHASED,
			ETO_CUST_PURCHASE_AMOUNTPAID AMOUNTPAID,
			ETO_CUST_PURCHASE_DATE TXN_DATE,
			NULL AS ETO_OFR_GLUSR_USR_ID,
			NULL FK_ETO_OFR_ID,
			NULL ETO_LEAD_PUR_IP,
			NULL ETO_LEAD_PUR_IP_COUNTRY,
			NULL ETO_LEAD_PUR_MODE,
			NULL POSTDATE_ORIG_IST,
			NULL OFRMCATNAME,
			NULL FK_GLCAT_MCAT_ID,
			NULL VERIFIED,
			NULL POSTDATE_ORIG,
			NULL BUYER_ID,
			NULL ETO_OFR_TITLE,
			NULL FK_GL_MODULE_ID,
			NULL ETO_OFR_CALL_VERIFIED,
			NULL ETO_OFR_EMAIL_VERIFIED,
			NULL ETO_OFR_ONLINE_VERIFIED,
			NULL CREDIT_REVERSAL_STATUS,
                        null iil_lead_latitude,null iil_lead_longitude 
			FROM IIL_CUST_PURCHASE_HIST
			WHERE FK_GLUSR_USR_ID=$glusrid
			UNION ALL
			SELECT 6 FLAG ,
			TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'DD-Mon-YYYY')
			TDATE,TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
			TO_CHAR(ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE,
			TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE, 'DD-Mon-YYYY')
			TDATE_IST,
			'Offer No. '|| FK_ETO_OFR_DISPLAY_ID|| ' Introduced through Assisted Buying Service' TDETAIL,
			0 CREDITUSED,
			0 BL_CREDITUSED,
			0 CREDITPURCHASED,
			0 BLCREDITPURCHASED,
			0 AMOUNTPAID,
			ETO_UNSOLD_LEADS_REC_DATE TXN_DATE,
			ETO_OFR.FK_GLUSR_USR_ID ETO_OFR_GLUSR_USR_ID,
			ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID FK_ETO_OFR_ID,
			'' ETO_LEAD_PUR_IP ,
			'' ETO_LEAD_PUR_IP_COUNTRY,
			'NO' ETO_LEAD_PUR_MODE,
			TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY')
			POSTDATE_ORIG_IST,
			ETO_OFR.ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME,
			ETO_OFR.FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID,
			ETO_OFR.ETO_OFR_VERIFIED VERIFIED,
			TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG,
			ETO_OFR.FK_GLUSR_USR_ID BUYER_ID,
			ETO_OFR.ETO_OFR_TITLE,
			ETO_OFR.FK_GL_MODULE_ID,
			ETO_OFR_CALL_VERIFIED,
			ETO_OFR_EMAIL_VERIFIED,
			ETO_OFR_ONLINE_VERIFIED,
			NULL CREDIT_REVERSAL_STATUS,null eto_lead_latitude,null eto_lead_longitude 
			FROM ETO_UNSOLD_LEADS,ETO_OFR
			WHERE ETO_UNSOLD_LEADS.ETO_UNSOLD_LEADS_SUP_ID=$glusrid
			AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID
			UNION ALL
			SELECT 7 FLAG ,
			TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'DD-Mon-YYYY') TDATE,
			TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
			TO_CHAR(ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE,
			TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE, 'DD-Mon-YYYY') TDATE_IST,
			'Offer No. '|| FK_ETO_OFR_DISPLAY_ID|| ' Introduced through Assisted Buying Service' TDETAIL,
			0 CREDITUSED,
			0 BL_CREDITUSED,
			0 CREDITPURCHASED,
			0 BLCREDITPURCHASED,
			0 AMOUNTPAID,
			ETO_UNSOLD_LEADS_REC_DATE TXN_DATE,
			ETO_OFR_EXPIRED.FK_GLUSR_USR_ID ETO_OFR_GLUSR_USR_ID,
			ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID FK_ETO_OFR_ID,
			'' ETO_LEAD_PUR_IP ,
			'' ETO_LEAD_PUR_IP_COUNTRY,
			'NO' ETO_LEAD_PUR_MODE,
			TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG_IST,
			ETO_OFR_EXPIRED.ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME,
			ETO_OFR_EXPIRED.FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID,
			ETO_OFR_EXPIRED.ETO_OFR_VERIFIED VERIFIED,
			TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG,
			ETO_OFR_EXPIRED.FK_GLUSR_USR_ID BUYER_ID,
			ETO_OFR_EXPIRED.ETO_OFR_TITLE,
			ETO_OFR_EXPIRED.FK_GL_MODULE_ID,
			ETO_OFR_EXPIRED.ETO_OFR_CALL_VERIFIED,
			ETO_OFR_EXPIRED.ETO_OFR_EMAIL_VERIFIED,
			ETO_OFR_EXPIRED.ETO_OFR_ONLINE_VERIFIED,
			NULL CREDIT_REVERSAL_STATUS,
                        null eto_lead_latitude,null eto_lead_longitude 
			FROM ETO_UNSOLD_LEADS,ETO_OFR_EXPIRED
			WHERE ETO_UNSOLD_LEADS.ETO_UNSOLD_LEADS_SUP_ID=$glusrid
			AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID                     
        ) y left outer join GLUSR_USR on GLUSR_USR_ID= ETO_OFR_GLUSR_USR_ID
    ) temp1   
) temp2 $condate      
ORDER BY TXN_DATE DESC,FLAG";
}else{
    $sql="SELECT temp2.*,(select a.gl_city_name from gl_city a,gl_city b where b.GL_CITY_DISTRICT_HQ = a.gl_city_id
and usrcity = b.gl_city_id) DISTRICT
FROM
(
SELECT * FROM
(
SELECT
FLAG
,(select TO_CHAR(min(ETO_PUR_DATE),'DD-Mon-YYYY')  from ETO_LEAD_PUR_HIST where FK_GLUSR_USR_ID=$glusrid) as MIN_DATE,
    
TDATE,OFR_DATE, FK_ETO_OFR_DATE, TDATE_IST, TDETAIL, CREDITUSED, BL_CREDITUSED, CREDITPURCHASED, BLCREDITPURCHASED, AMOUNTPAID, SUM(CREDITPURCHASED-CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BALANCE, SUM(BLCREDITPURCHASED-BL_CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BL_BALANCE, SUM(BLCREDITPURCHASED-BL_CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BL_BALANCE
,
( CASE WHEN FLAG=2 OR FLAG  =5 OR FLAG=6 OR FLAG=7 THEN
(GLUSR_USR.GLUSR_USR_FIRSTNAME|| ' '|| GLUSR_USR.GLUSR_USR_LASTNAME) ELSE '-' END) BUYER_NAME,
TXN_DATE, FK_ETO_OFR_ID, ETO_LEAD_PUR_IP, ETO_LEAD_PUR_IP_COUNTRY, ETO_LEAD_PUR_MODE, POSTDATE_ORIG_IST,
OFRMCATNAME, FK_GLCAT_MCAT_ID, VERIFIED, POSTDATE_ORIG, BUYER_ID, ETO_OFR_TITLE, FK_GL_MODULE_ID, GLUSR_USR_CITY CITY,
FK_GL_COUNTRY_ISO AS COUNTRY_ISO, GLUSR_USR_PH_MOBILE AS MOBILE, GLUSR_USR_PH_NUMBER AS PH_NUMBER
,fk_gl_city_id usrcity,
GLUSR_USR_EMAIL AS EMAIL, ETO_OFR_CALL_VERIFIED, ETO_OFR_EMAIL_VERIFIED, ETO_OFR_ONLINE_VERIFIED, CREDIT_REVERSAL_STATUS,
glusr_usr_longitude,glusr_usr_latitude,eto_lead_latitude,eto_lead_longitude
FROM
(
SELECT
CASE WHEN ETO_LEAD_PUR_TYPE = 'T' AND FK_ETO_OFR_ID <> -1 THEN 9 WHEN FK_ETO_OFR_ID IN (-1,-2,-3) THEN 3 ELSE coalesce(LEAD_FLAG,10) END FLAG, TO_CHAR(ETO_PUR_DATE,'DD-Mon-YYYY') TDATE,TO_CHAR(ETO_PUR_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE, TO_CHAR(FK_ETO_OFR_DATE::date,'DD-Mon-YY') FK_ETO_OFR_DATE, TO_CHAR(ETO_PUR_DATE, 'DD-Mon-YYYY') TDATE_IST, CASE WHEN FK_ETO_OFR_ID IN (-1,-2,-3,-4,-5) THEN ETO_LEAD_PUR_LAPSE_MSG ELSE (case when ETO_LEAD_PUR_TYPE='T' then 'Tender No. ' else 'Lead No. ' end) || FK_ETO_OFR_ID || ' Purchased' END TDETAIL, ETO_CREDITS_USED CREDITUSED, ETO_CREDITS_USED_LEADCNT BL_CREDITUSED, 0 CREDITPURCHASED, 0 BLCREDITPURCHASED, 0 AMOUNTPAID, ETO_PUR_DATE TXN_DATE, ETO_OFR_GLUSR_USR_ID, FK_ETO_OFR_ID, ETO_LEAD_PUR_IP, ETO_LEAD_PUR_IP_COUNTRY, ETO_LEAD_PUR_MODE, TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG_IST, ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME, FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID, ETO_OFR_VERIFIED VERIFIED, TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG, ETO_OFR.FK_GLUSR_USR_ID BUYER_ID, ETO_OFR.ETO_OFR_TITLE, ETO_OFR.FK_GL_MODULE_ID, ETO_OFR_CALL_VERIFIED, ETO_OFR_EMAIL_VERIFIED, ETO_OFR_ONLINE_VERIFIED, (SELECT (case when COUNT(1)=0 then 0 else 1 end) FROM IIL_CREDIT_REVERSAL WHERE FK_GLUSR_USR_ID = $glusrid AND ETO_LEAD_PUR_ID = FK_ETO_LEAD_PUR_ID) CREDIT_REVERSAL_STATUS, eto_lead_latitude,eto_lead_longitude
from
(
SELECT
TO_CHAR(ETO_PUR_DATE,'DD-Mon-YYYY') TDATE,TO_CHAR(ETO_PUR_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE, TO_CHAR(FK_ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE, TO_CHAR(ETO_PUR_DATE, 'DD-Mon-YYYY') TDATE_IST, ETO_LEAD_PUR_TYPE, ETO_LEAD_PUR_LAPSE_MSG, ETO_CREDITS_USED CREDITUSED, ETO_CREDITS_USED, ETO_CREDITS_USED_LEADCNT BL_CREDITUSED, 0 CREDITPURCHASED, 0 BLCREDITPURCHASED, ETO_LEAD_PUR_ID, ETO_CREDITS_USED_LEADCNT, 0 AMOUNTPAID, ETO_PUR_DATE TXN_DATE, ETO_PUR_DATE, ETO_OFR_GLUSR_USR_ID, FK_ETO_OFR_ID, ETO_LEAD_PUR_IP, ETO_LEAD_PUR_IP_COUNTRY, ETO_LEAD_PUR_MODE, (SELECT (case when COUNT(1)=0 then 0 else 1 end) FROM IIL_CREDIT_REVERSAL WHERE FK_GLUSR_USR_ID = $glusrid AND ETO_LEAD_PUR_ID = FK_ETO_LEAD_PUR_ID) CREDIT_REVERSAL_STATUS, eto_lead_latitude,eto_lead_longitude    
FROM
ETO_LEAD_PUR_HIST
where ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID =  $glusrid 
) ETO_LEAD_PUR_HIST  left outer join
(
SELECT 5 LEAD_FLAG,
ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_GLCAT_MCAT_NAME,FK_GLCAT_MCAT_ID,ETO_OFR_VERIFIED,FK_GLUSR_USR_ID,
ETO_OFR.ETO_OFR_TITLE,ETO_OFR.FK_GL_MODULE_ID,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED
FROM ETO_OFR
UNION ALL
SELECT 2 FLAG,
ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_GLCAT_MCAT_NAME,FK_GLCAT_MCAT_ID,ETO_OFR_VERIFIED,FK_GLUSR_USR_ID,
ETO_OFR.ETO_OFR_TITLE,ETO_OFR.FK_GL_MODULE_ID,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED
FROM ETO_OFR_EXPIRED ETO_OFR
)ETO_OFR                        
on ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID
UNION ALL
SELECT 1 FLAG,
TO_CHAR(ETO_CUST_PURCHASE_DATE,'DD-Mon-YYYY') TDATE,TO_CHAR(ETO_CUST_PURCHASE_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE, NULL  FK_ETO_OFR_DATE, TO_CHAR(ETO_CUST_PURCHASE_DATE, 'DD-Mon-YYYY') TDATE_IST, (case when ETO_CUST_CREDIT_ISSUE_MSG=NULL then (case when ETO_CUST_ORDER_ID=-1 then 'Credits Allocated by Admin' else 'Credits Purchased' end) else ETO_CUST_CREDIT_ISSUE_MSG end) TDETAIL, 0 CREDITUSED, 0 BL_CREDITUSED, ETO_CUST_PURCHASE_CREDITS CREDITPURCHASED, ETO_CUST_LEAD_COUNT BLCREDITPURCHASED, ETO_CUST_PURCHASE_AMOUNTPAID AMOUNTPAID, ETO_CUST_PURCHASE_DATE TXN_DATE, NULL AS ETO_OFR_GLUSR_USR_ID, NULL FK_ETO_OFR_ID, NULL ETO_LEAD_PUR_IP, NULL ETO_LEAD_PUR_IP_COUNTRY, NULL ETO_LEAD_PUR_MODE, NULL POSTDATE_ORIG_IST, NULL OFRMCATNAME, NULL FK_GLCAT_MCAT_ID, NULL VERIFIED, NULL POSTDATE_ORIG, NULL BUYER_ID, NULL ETO_OFR_TITLE, NULL FK_GL_MODULE_ID, NULL ETO_OFR_CALL_VERIFIED, NULL ETO_OFR_EMAIL_VERIFIED, NULL ETO_OFR_ONLINE_VERIFIED, NULL CREDIT_REVERSAL_STATUS, NULL eto_lead_latitude, NULL eto_lead_longitude FROM ETO_CUST_PURCHASE_HIST WHERE FK_GLUSR_USR_ID=$glusrid UNION ALL SELECT 6 FLAG , TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'DD-Mon-YYYY') TDATE,TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE, TO_CHAR(ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE, TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE, 'DD-Mon-YYYY') TDATE_IST, 'Offer No. '|| FK_ETO_OFR_DISPLAY_ID|| ' Introduced through Assisted Buying Service' TDETAIL, 0 CREDITUSED, 0 BL_CREDITUSED, 0 CREDITPURCHASED, 0 BLCREDITPURCHASED, 0 AMOUNTPAID, ETO_UNSOLD_LEADS_REC_DATE TXN_DATE, ETO_OFR.FK_GLUSR_USR_ID ETO_OFR_GLUSR_USR_ID, ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID FK_ETO_OFR_ID, '' ETO_LEAD_PUR_IP , '' ETO_LEAD_PUR_IP_COUNTRY, 'NO' ETO_LEAD_PUR_MODE, TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG_IST, ETO_OFR.ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME, ETO_OFR.FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID, ETO_OFR.ETO_OFR_VERIFIED VERIFIED, TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG, ETO_OFR.FK_GLUSR_USR_ID BUYER_ID, ETO_OFR.ETO_OFR_TITLE, ETO_OFR.FK_GL_MODULE_ID, ETO_OFR_CALL_VERIFIED, ETO_OFR_EMAIL_VERIFIED, ETO_OFR_ONLINE_VERIFIED, NULL CREDIT_REVERSAL_STATUS, NULL eto_lead_latitude, NULL eto_lead_longitude
FROM ETO_UNSOLD_LEADS,ETO_OFR
WHERE ETO_UNSOLD_LEADS.ETO_UNSOLD_LEADS_SUP_ID=$glusrid
AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID
UNION ALL
SELECT 7 FLAG ,
TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'DD-Mon-YYYY') TDATE, TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE, TO_CHAR(ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE, TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE, 'DD-Mon-YYYY') TDATE_IST, 'Offer No. '|| FK_ETO_OFR_DISPLAY_ID|| ' Introduced through Assisted Buying Service' TDETAIL, 0 CREDITUSED, 0 BL_CREDITUSED, 0 CREDITPURCHASED, 0 BLCREDITPURCHASED, 0 AMOUNTPAID, ETO_UNSOLD_LEADS_REC_DATE TXN_DATE, ETO_OFR_EXPIRED.FK_GLUSR_USR_ID ETO_OFR_GLUSR_USR_ID, ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID FK_ETO_OFR_ID, '' ETO_LEAD_PUR_IP , '' ETO_LEAD_PUR_IP_COUNTRY, 'NO' ETO_LEAD_PUR_MODE, TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG_IST, ETO_OFR_EXPIRED.ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME, ETO_OFR_EXPIRED.FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID, ETO_OFR_EXPIRED.ETO_OFR_VERIFIED VERIFIED, TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG, ETO_OFR_EXPIRED.FK_GLUSR_USR_ID BUYER_ID, ETO_OFR_EXPIRED.ETO_OFR_TITLE, ETO_OFR_EXPIRED.FK_GL_MODULE_ID, ETO_OFR_EXPIRED.ETO_OFR_CALL_VERIFIED, ETO_OFR_EXPIRED.ETO_OFR_EMAIL_VERIFIED, ETO_OFR_EXPIRED.ETO_OFR_ONLINE_VERIFIED, NULL CREDIT_REVERSAL_STATUS, NULL eto_lead_latitude, NULL eto_lead_longitude
FROM ETO_UNSOLD_LEADS,ETO_OFR_EXPIRED
WHERE ETO_UNSOLD_LEADS.ETO_UNSOLD_LEADS_SUP_ID=$glusrid
AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID                    
) y  left outer join GLUSR_USR
on GLUSR_USR_ID= ETO_OFR_GLUSR_USR_ID
) temp1  
) temp2  
$condate  ORDER BY TXN_DATE DESC,FLAG";
 $sql_old="SELECT *
                        FROM
                        (SELECT * FROM
                        (
                        SELECT FLAG,
                        (select TO_CHAR(min(ETO_PUR_DATE),'DD-Mon-YYYY')  from
                        $ETO_LEAD_PUR_HIST where FK_GLUSR_USR_ID=$glusrid) as MIN_DATE,
                        TDATE,OFR_DATE,
                        FK_ETO_OFR_DATE,
                        TDATE_IST,
                        TDETAIL,
                        CREDITUSED,
                        BL_CREDITUSED,
                        CREDITPURCHASED,
                        BLCREDITPURCHASED,
                        AMOUNTPAID,
                        SUM(CREDITPURCHASED-CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG
                        DESC) BALANCE,
                        SUM(BLCREDITPURCHASED-BL_CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BL_BALANCE,
                        SUM(BLCREDITPURCHASED-BL_CREDITUSED) OVER(ORDER BY TXN_DATE,FLAG DESC) BL_BALANCE,
                        (
                        CASE
                        WHEN FLAG=2
                        OR FLAG  =5
                        OR FLAG=6 OR FLAG=7
                        THEN (GLUSR_USR.GLUSR_USR_FIRSTNAME|| ' '|| GLUSR_USR.GLUSR_USR_LASTNAME)
                        ELSE '-'
                        END) BUYER_NAME,
                        TXN_DATE,
                        FK_ETO_OFR_ID,
                        ETO_LEAD_PUR_IP,
                        ETO_LEAD_PUR_IP_COUNTRY,
                        ETO_LEAD_PUR_MODE,
                        POSTDATE_ORIG_IST,
                        OFRMCATNAME,
                        FK_GLCAT_MCAT_ID,
                        VERIFIED,
                        POSTDATE_ORIG,
                        BUYER_ID,
                        ETO_OFR_TITLE,
                        FK_GL_MODULE_ID,
                        GLUSR_USR_CITY CITY,
                        FK_GL_COUNTRY_ISO AS COUNTRY_ISO,
                        GLUSR_USR_PH_MOBILE AS MOBILE,
                        GLUSR_USR_PH_NUMBER AS PH_NUMBER,
                        GLUSR_USR_EMAIL AS EMAIL,
                        ETO_OFR_CALL_VERIFIED,
                        ETO_OFR_EMAIL_VERIFIED,
                        ETO_OFR_ONLINE_VERIFIED,
                        CREDIT_REVERSAL_STATUS,
                        (select a.gl_city_name from gl_city a,gl_city b where b.GL_CITY_DISTRICT_HQ = a.gl_city_id and fk_gl_city_id = b.gl_city_id) 
                        DISTRICT,glusr_usr_longitude,glusr_usr_latitude,eto_lead_latitude,eto_lead_longitude 
                        FROM
                        (
                        SELECT
                        CASE WHEN ETO_LEAD_PUR_TYPE = 'T' AND FK_ETO_OFR_ID <> -1
                        THEN 9 WHEN FK_ETO_OFR_ID IN (-1,-2,-3) THEN 3 ELSE coalesce(LEAD_FLAG,10) END
                        FLAG,
                        TO_CHAR(ETO_PUR_DATE,'DD-Mon-YYYY')
                        TDATE,TO_CHAR(ETO_PUR_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
                        TO_CHAR(FK_ETO_OFR_DATE::date,'DD-Mon-YY') FK_ETO_OFR_DATE,
                        TO_CHAR(ETO_PUR_DATE, 'DD-Mon-YYYY') TDATE_IST,
                        CASE WHEN FK_ETO_OFR_ID IN (-1,-2,-3,-4,-5) THEN
                        ETO_LEAD_PUR_LAPSE_MSG ELSE (case when ETO_LEAD_PUR_TYPE='T' then 'Tender No.
                        ' else 'Lead No. ' end) || FK_ETO_OFR_ID || ' Purchased' END TDETAIL,
                        ETO_CREDITS_USED CREDITUSED,
                        ETO_CREDITS_USED_LEADCNT BL_CREDITUSED,
                        0 CREDITPURCHASED,
                        0 BLCREDITPURCHASED,
                        0 AMOUNTPAID,
                        ETO_PUR_DATE TXN_DATE,
                        ETO_OFR_GLUSR_USR_ID,
                        FK_ETO_OFR_ID,
                        ETO_LEAD_PUR_IP,
                        ETO_LEAD_PUR_IP_COUNTRY,
                        ETO_LEAD_PUR_MODE,
                        TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY')
                        POSTDATE_ORIG_IST,
                        ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME,
                        FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID,
                        ETO_OFR_VERIFIED VERIFIED,
                        TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG,
                        ETO_OFR.FK_GLUSR_USR_ID BUYER_ID,
                        ETO_OFR.ETO_OFR_TITLE,
                        ETO_OFR.FK_GL_MODULE_ID,
                        ETO_OFR_CALL_VERIFIED,
                        ETO_OFR_EMAIL_VERIFIED,
                        ETO_OFR_ONLINE_VERIFIED,
                        (SELECT (case when COUNT(1)=0 then 0 else 1 end) FROM $IIL_CREDIT_REVERSAL WHERE FK_GLUSR_USR_ID = $glusrid 
                            AND ETO_LEAD_PUR_ID = FK_ETO_LEAD_PUR_ID) CREDIT_REVERSAL_STATUS,
                            eto_lead_latitude,eto_lead_longitude 
                        from 
                        (
                        SELECT
                        TO_CHAR(ETO_PUR_DATE,'DD-Mon-YYYY')
                        TDATE,TO_CHAR(ETO_PUR_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
                        TO_CHAR(FK_ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE,
                        TO_CHAR(ETO_PUR_DATE, 'DD-Mon-YYYY') TDATE_IST,
                        ETO_LEAD_PUR_TYPE,
			ETO_LEAD_PUR_LAPSE_MSG,
                        ETO_CREDITS_USED CREDITUSED,
			ETO_CREDITS_USED,
                        ETO_CREDITS_USED_LEADCNT BL_CREDITUSED,
                        0 CREDITPURCHASED,
                        0 BLCREDITPURCHASED,
                        ETO_LEAD_PUR_ID,
                        ETO_CREDITS_USED_LEADCNT,
                        0 AMOUNTPAID,
                        ETO_PUR_DATE TXN_DATE,
                        ETO_PUR_DATE,
                        ETO_OFR_GLUSR_USR_ID,
                        FK_ETO_OFR_ID,
                        ETO_LEAD_PUR_IP,
                        ETO_LEAD_PUR_IP_COUNTRY,
                        ETO_LEAD_PUR_MODE,
                        (SELECT (case when COUNT(1)=0 then 0 else 1 end) FROM $IIL_CREDIT_REVERSAL WHERE FK_GLUSR_USR_ID = $glusrid 
                            AND ETO_LEAD_PUR_ID = FK_ETO_LEAD_PUR_ID) CREDIT_REVERSAL_STATUS,
                        eto_lead_latitude,eto_lead_longitude     
                        FROM
                        $ETO_LEAD_PUR_HIST
			where $ETO_LEAD_PUR_HIST.FK_GLUSR_USR_ID =  $glusrid) $ETO_LEAD_PUR_HIST  left outer join 
                        (
                        SELECT 5 LEAD_FLAG,
                        ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_GLCAT_MCAT_NAME,FK_GLCAT_MCAT_ID,ETO_OFR_VERIFIED,FK_GLUSR_USR_ID,
                        ETO_OFR.ETO_OFR_TITLE,ETO_OFR.FK_GL_MODULE_ID,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED
                        FROM ETO_OFR
                        UNION ALL
                        SELECT 2 FLAG,
                        ETO_OFR_DISPLAY_ID,ETO_OFR_POSTDATE_ORIG,ETO_OFR_GLCAT_MCAT_NAME,FK_GLCAT_MCAT_ID,ETO_OFR_VERIFIED,FK_GLUSR_USR_ID,
                        ETO_OFR.ETO_OFR_TITLE,ETO_OFR.FK_GL_MODULE_ID,ETO_OFR_CALL_VERIFIED,ETO_OFR_EMAIL_VERIFIED,ETO_OFR_ONLINE_VERIFIED
                        FROM ETO_OFR_EXPIRED ETO_OFR
                        )ETO_OFR                          
                        on ETO_OFR.ETO_OFR_DISPLAY_ID = $ETO_LEAD_PUR_HIST.FK_ETO_OFR_ID
                        UNION ALL
                        SELECT 1 FLAG,
                        TO_CHAR(ETO_CUST_PURCHASE_DATE,'DD-Mon-YYYY')
                        TDATE,TO_CHAR(ETO_CUST_PURCHASE_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
                        NULL  FK_ETO_OFR_DATE,
                        TO_CHAR(ETO_CUST_PURCHASE_DATE, 'DD-Mon-YYYY') TDATE_IST,
                        (case when ETO_CUST_CREDIT_ISSUE_MSG=NULL then (case when ETO_CUST_ORDER_ID=-1 then 'Credits
                        Allocated by Admin' else 'Credits Purchased' end) else ETO_CUST_CREDIT_ISSUE_MSG end) TDETAIL,
                        0 CREDITUSED,
                        0 BL_CREDITUSED,
                        ETO_CUST_PURCHASE_CREDITS CREDITPURCHASED,
                        ETO_CUST_LEAD_COUNT BLCREDITPURCHASED,
                        ETO_CUST_PURCHASE_AMOUNTPAID AMOUNTPAID,
                        ETO_CUST_PURCHASE_DATE TXN_DATE,
                        NULL AS ETO_OFR_GLUSR_USR_ID,
                        NULL FK_ETO_OFR_ID,
                        NULL ETO_LEAD_PUR_IP,
                        NULL ETO_LEAD_PUR_IP_COUNTRY,
                        NULL ETO_LEAD_PUR_MODE,
                        NULL POSTDATE_ORIG_IST,
                        NULL OFRMCATNAME,
                        NULL FK_GLCAT_MCAT_ID,
                        NULL VERIFIED,
                        NULL POSTDATE_ORIG,
                        NULL BUYER_ID,
                        NULL ETO_OFR_TITLE,
                        NULL FK_GL_MODULE_ID,
                        NULL ETO_OFR_CALL_VERIFIED,
                        NULL ETO_OFR_EMAIL_VERIFIED,
                        NULL ETO_OFR_ONLINE_VERIFIED,
                        NULL CREDIT_REVERSAL_STATUS,
                        NULL eto_lead_latitude,
                        NULL eto_lead_longitude 
                        FROM $ETO_CUST_PURCHASE_HIST
                        WHERE FK_GLUSR_USR_ID=$glusrid 
                        UNION ALL
                        SELECT 6 FLAG ,
                        TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'DD-Mon-YYYY')
                        TDATE,TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
                        TO_CHAR(ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE,
                        TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE, 'DD-Mon-YYYY')
                        TDATE_IST,
                        'Offer No. '|| FK_ETO_OFR_DISPLAY_ID|| ' Introduced through Assisted Buying Service' TDETAIL,
                        0 CREDITUSED,
                        0 BL_CREDITUSED,
                        0 CREDITPURCHASED,
                        0 BLCREDITPURCHASED,
                        0 AMOUNTPAID,
                        ETO_UNSOLD_LEADS_REC_DATE TXN_DATE,
                        ETO_OFR.FK_GLUSR_USR_ID ETO_OFR_GLUSR_USR_ID,
                        ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID FK_ETO_OFR_ID,
                        '' ETO_LEAD_PUR_IP ,
                        '' ETO_LEAD_PUR_IP_COUNTRY,
                        'NO' ETO_LEAD_PUR_MODE,
                        TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY')
                        POSTDATE_ORIG_IST,
                        ETO_OFR.ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME,
                        ETO_OFR.FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID,
                        ETO_OFR.ETO_OFR_VERIFIED VERIFIED,
                        TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG,
                        ETO_OFR.FK_GLUSR_USR_ID BUYER_ID,
                        ETO_OFR.ETO_OFR_TITLE,
                        ETO_OFR.FK_GL_MODULE_ID,
                        ETO_OFR_CALL_VERIFIED,
                        ETO_OFR_EMAIL_VERIFIED,
                        ETO_OFR_ONLINE_VERIFIED,
                        NULL CREDIT_REVERSAL_STATUS,
                        NULL eto_lead_latitude,
                        NULL eto_lead_longitude 
                        FROM ETO_UNSOLD_LEADS,
                        ETO_OFR
                        WHERE ETO_UNSOLD_LEADS.ETO_UNSOLD_LEADS_SUP_ID=$glusrid 
                        AND ETO_OFR.ETO_OFR_DISPLAY_ID = ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID 
                        UNION ALL
                        SELECT 7 FLAG ,
                        TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'DD-Mon-YYYY') TDATE,
                        TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE,'YYYYMMDDHH24MISS') AS OFR_DATE,
                        TO_CHAR(ETO_OFR_DATE,'DD-Mon-YY') FK_ETO_OFR_DATE,
                        TO_CHAR(ETO_UNSOLD_LEADS_REC_DATE, 'DD-Mon-YYYY') TDATE_IST,
                        'Offer No. '|| FK_ETO_OFR_DISPLAY_ID|| ' Introduced through Assisted Buying Service' TDETAIL,
                        0 CREDITUSED,
                        0 BL_CREDITUSED,
                        0 CREDITPURCHASED,
                        0 BLCREDITPURCHASED,
                        0 AMOUNTPAID,
                        ETO_UNSOLD_LEADS_REC_DATE TXN_DATE,
                        ETO_OFR_EXPIRED.FK_GLUSR_USR_ID ETO_OFR_GLUSR_USR_ID,
                        ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID FK_ETO_OFR_ID,
                        '' ETO_LEAD_PUR_IP ,
                        '' ETO_LEAD_PUR_IP_COUNTRY,
                        'NO' ETO_LEAD_PUR_MODE,
                        TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG_IST,
                        ETO_OFR_EXPIRED.ETO_OFR_GLCAT_MCAT_NAME OFRMCATNAME,
                        ETO_OFR_EXPIRED.FK_GLCAT_MCAT_ID FK_GLCAT_MCAT_ID,
                        ETO_OFR_EXPIRED.ETO_OFR_VERIFIED VERIFIED,
                        TO_CHAR(ETO_OFR_POSTDATE_ORIG,'DD-Mon-YYYY') POSTDATE_ORIG,
                        ETO_OFR_EXPIRED.FK_GLUSR_USR_ID BUYER_ID,
                        ETO_OFR_EXPIRED.ETO_OFR_TITLE,
                        ETO_OFR_EXPIRED.FK_GL_MODULE_ID,
                        ETO_OFR_EXPIRED.ETO_OFR_CALL_VERIFIED,
                        ETO_OFR_EXPIRED.ETO_OFR_EMAIL_VERIFIED,
                        ETO_OFR_EXPIRED.ETO_OFR_ONLINE_VERIFIED,
                        NULL CREDIT_REVERSAL_STATUS,
                        NULL eto_lead_latitude,
                        NULL eto_lead_longitude 
                        FROM ETO_UNSOLD_LEADS,
                        ETO_OFR_EXPIRED
                        WHERE ETO_UNSOLD_LEADS.ETO_UNSOLD_LEADS_SUP_ID=$glusrid 
                        AND ETO_OFR_EXPIRED.ETO_OFR_DISPLAY_ID = ETO_UNSOLD_LEADS.FK_ETO_OFR_DISPLAY_ID                      
                        ) y left outer join
                        GLUSR_USR
                        on GLUSR_USR_ID= ETO_OFR_GLUSR_USR_ID
                        ) temp1    
                        ) temp2 $condate    
                        ORDER BY TXN_DATE DESC,FLAG";
}
               // if($empId==3575){echo $sql;               }
      $obj = new Globalconnection();
if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
{
    $dbh = $obj->connect_db_yii('postgress_web68v');   
}else{
    $dbh = $obj->connect_db_yii('postgress_web68v'); 
}                                
      $model = new GlobalmodelForm();
      $sth = $model->runSelect(__FILE__,__LINE__,__CLASS__,$dbh,$sql,array());
      $result = array();
      
	  	if($sth) {
			while ($rec = $sth->read())
				{
						$rec1=array_change_key_case($rec, CASE_UPPER); 
						array_push($result,$rec1);
				}   
		}
	} catch(Exception $e){     
		echo "Error occured !";	
		$errMess = $e->getMessage();
		mail("gupta.aditi1@indiamart.com, vinay.kaul@indiamart.com","Transaction Report Error - Pur Details", 'Error Message: '.$errMess.'\n\n---- Error: '.json_encode($e));
		exit;
	}
     // echo '<pre>';print_r($result);
       return $result;
    }
    
    function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
        $sort_col = array();
        foreach ($arr as $key => $row) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort($sort_col, $dir, $arr);
	}
	function decrypt_suppid($str) {
		$key = '1996c39iil';
		$str = base64_decode($str);
		$s = array();
		for ($i = 0; $i < 256; $i++) {
			$s[$i] = $i;
		}
		$j = 0;
		for ($i = 0; $i < 256; $i++) {
			$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
			$x = $s[$i];
			$s[$i] = $s[$j];
			$s[$j] = $x;
		}
		$i = 0;
		$j = 0;
		$res = '';
		for ($y = 0; $y < strlen($str); $y++) {
			$i = ($i + 1) % 256;
			$j = ($j + $s[$i]) % 256;
			$x = $s[$i];
			$s[$i] = $s[$j];
			$s[$j] = $x;
			$res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
		}
		return $res;
 }
 public function Negativecategory()
  {
    $glid=$_REQUEST['glid'];
    $str=$str_dis=$str_city=$str_country='';   
            $content = array('token' =>'imobile1@15061981',
                'modid' =>'GLADMIN','glusrid' => $glid
                );  

     	$req = ($_SERVER['SERVER_NAME'] == 'gladmin.intermesh.net') ? 'https://leads.imutils.com/wservce/buyleads/negative_mcat_details/':'http://dev-mapi.indiamart.com/wservce/buyleads/negative_mcat_details/';
        $data_string = http_build_query($content);
	$ServiceGlobalModelForm = new ServiceGlobalModelForm();
	$response = $ServiceGlobalModelForm->mapiService('ACOUNTLEDGER',$req,$data_string,'No');
        //print_r($response);//die;
		$arr=array();$count_city=0;
		     $arr=isset($response['DATA']) ? $response['DATA']['negative_mcat'] : '';  
                     for($i=0;$i<count($arr);$i++){
                        $str_city .= '<li class="chip" style="background-color: #dcf9dc;">'.$arr[$i]['mcat_name']."</li>";
                        $count_city++;
                     }
		

            if($count_city==0){
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Negative Categories (all returned by the service)</b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Negative Categories (all returned by the service)</b></td></tr><tr><td><ul>'.$str_city."</ul></td></tr></table><br><br>";
            }           
           return $str_city;
        } 
 public function Preferredcategory()
  {
    $glid=$_REQUEST['glid'];
    $str=$str_city2=$str_city='';   
            $content = array(
                'token' =>'imobile1@15061981',
                'modid' =>'GLADMIN','glusrid' => $glid
                );  

     	$req = ($_SERVER['SERVER_NAME'] == 'gladmin.intermesh.net') ? 'https://leads.imutils.com/wservce/buyleads/user_selling_mcat/':'http://dev-mapi.indiamart.com/wservce/buyleads/user_selling_mcat/';
        $data_string = http_build_query($content);
	$ServiceGlobalModelForm = new ServiceGlobalModelForm();
	$response = $ServiceGlobalModelForm->mapiService('ACOUNTLEDGER',$req,$data_string,'No');
                //print_r($response);die;

		$arr=array();$count_city=$count_city2=0;
		if (is_array($response))
		{
		     $arr=isset($response['DATA']['A_rank']) ? $response['DATA']['A_rank'] : '';  
                     for($i=0;$i<count($arr);$i++){
                        $str_city .= '<li class="chip" style="background-color: #dcf9dc;">'.$arr[$i]['glcat_mcat_name']."</li>";
                        $count_city++;
                     }
                    $arr=isset($response['DATA']['D_rank']) ? $response['DATA']['D_rank'] : '';  
                     for($i=0;$i<count($arr);$i++){
                        $str_city2 .= '<li class="chip" style="background-color: #dcf9dc;">'.$arr[$i]['glcat_mcat_name']."</li>";
                        $count_city2++;
                     }
		} 

            if($count_city==0){
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Categories (A Rank)</b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_city ='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Categories (A Rank)</b></td></tr><tr><td><ul>'.$str_city."</ul></td></tr></table><br><br>";
            }   
            if($count_city2==0){
                $str_city2='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Categories (D Rank)</b></td></tr><tr><td align="center"><span style="font-family: arial;font-size: 13px;">No Record Found</span></td></tr></table><br><br>';
            }else{
                $str_city2='<table style="border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="4" bordercolor="#bedaff" border="1"><tr><td bgcolor="#dff8ff" align="center"><b>Preferred Categories (D Rank)</b></td></tr><tr><td><ul>'.$str_city2."</ul></td></tr></table><br><br>";
            }           
            $str=$str_city.$str_city2;
            return $str;
    }
}
?>