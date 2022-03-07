<?php
class  ast_buym_mailer extends CFormModel
{
 public function ast_buym_sendmail($glusrId,$offerId,$message,$glusr_email,$subject,$glusrname,$mod_id)
  {
 
$to= '';
if($_SERVER['SERVER_NAME'] == 'gladmin.intermesh.net'){
$to = $glusr_email;

 }else{

  $to = 'anmol.nigam@indiamart.com,anmol.nigam@yahoo.com,anmol.nigam@outlook.com,anmol.nigam@rediffmail.com,cute.libra93@gmail.com,laxmi@indiamart.com';


 }

$from='fulfilment@indiamart.com';
$from_name = 'Fulfilment Desk';
$reply_to = 'fulfilment@indiamart.com ';


$subject = $glusrname.', Buyer is requesting Quotation for '.$subject;
$cc = '';
$mime_header		= "MIME-Version: 1.0\n";
$mime_header		.= "Content-type: text/html; charset=UTF-8\n";
$mime_header		.= "Content-Transfer-Encoding: 8bit\n\n";
// $reply_to = array('buyleads+instantblalerts@indiamart.com', 'IndiaMART Buy Leads');

$bcc ='';
$formatEmail = $to;
$formatEmail = str_replace("@", "=", $formatEmail);	
$bouncemail  = "tradeadmin-$glusrId-$formatEmail@route.indiamart.com";
$date 	= date("d-m-Y");
$ranNo = rand(10, 99);
$dateTime = date("YmdHis");
$umailid = "ASTM-$glusrId-$dateTime-$ranNo"; 
$sendgrid_login_id = "ASTBUYM";
$sendgrid_pass = "motherindia12";
$sendGridCategory =$mod_id ;
$uniqueArgs = array("sentdate" => $date, "iilglusrid" => $glusrId, "umailid" => $umailid);
$final_msgTxt = '';
$to_name = '';
$full_name = ''; 
$reply_to_name = '';



  $this->Sendmail(__FILE__, $to, $from, $cc, $subject, $message, $from_name, $mime_header, $reply_to, $bcc, $bouncemail,['ucexhelva2.smtp.sendgrid.net', $sendgrid_login_id, $sendgrid_pass, 'web14.intermesh.net'], $sendGridCategory, $uniqueArgs, $final_msgTxt, $to_name, $full_name, $reply_to_name);
  }

public function mailContent($glusrId,$offerId){
$service_url = 'http://mapi.indiamart.com/wservce/buyleads/detail/';

if($_SERVER['SERVER_NAME'] == 'gladmin.intermesh.net'){
$service_url = 'http://mapi.indiamart.com/wservce/buyleads/detail/';
}else{
$service_url = 'http://stg-mapi.indiamart.com/wservce/buyleads/detail/';
}
		
			
			$start=1;
			$end=1;
			$content=array();
                        
			$content = array(
			
			'offerid' => $offerId,
			'modid' => 'GLADMIN',
			'type' => 'Q',
			'offer_type' => 'B',
			'token' => 'imobile@15061981',
			'buyer_response'=>1,
			'additionalinfo_format'=>'JSON'
			);

			$data_string = http_build_query($content);
			$curl = curl_init($service_url);                                                                     
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
			$json_response = curl_exec($curl);
			$status_service = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$status='';
			$res=array();      
			$qresult = array();
			if($status_service == 200)
			{
			$wsresult = json_decode($json_response, true);

			  if(isset($wsresult['RESPONSE']))
			{ //print_r($wsresult);
			$qresult=$wsresult['RESPONSE'];
			$res= isset($qresult['DATA'])?$qresult['DATA']:'';
// 			  if(isset($res['FK_ETO_OFR_TYPE_ID']) && $res['FK_ETO_OFR_TYPE_ID'] != 1){
// 			    $res= '';
// 
// 			  }
			}
			  }else{
			  $res= '';

			}
			$subject = isset($res['ETO_OFR_GLCAT_MCAT_NAME'])?$res['ETO_OFR_GLCAT_MCAT_NAME']:'';
			// echo $subject;
		     // print_r($qresult);
//print_r($res);			
return $res;
//return $subject;
}





public function Sendmail($fileName, $to, $from, $cc, $subject, $message, $from_name, $mime_header, $reply_to, $bcc, $bouncemail,$sendGridArrRef, $sendGridCategory, $uniqueArgs, $final_msgTxt, $to_name, $full_name, $reply_to_name)
	{
		$usrName = $sendGridArrRef[1];
		$pass = $sendGridArrRef[2];
		
		$toarr = explode(',', $to);

		$url = 'https://api.sendgrid.com/';
		$user = $usrName;
		$pass = $pass;
		
		$filePath = dirname(__FILE__);
		
		//for removing Unsubscribe link   
		$json_string = array(
						'to' => $toarr,
						'category' => $sendGridCategory,
						'unique_args' => $uniqueArgs
					);

		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			//'name'=>'footer','text/html'=>'','text/plain'=>'',
			'x-smtpapi' => json_encode($json_string),
			'to'        => $toarr[0],
			'subject'   => $subject,
			'text'      => $final_msgTxt,
			'html'      => $message,
			'from'      => $from,
			'fromname'      => $from_name,
			'replyto'	=> $reply_to
			
		);
		
		$request =  $url.'api/mail.send.json';

		// Generate curl request
		$session = curl_init($request);

		// Tell curl to use HTTP POST
		curl_setopt ($session, CURLOPT_POST, true);

		// Tell curl that this is the body of the POST
		curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

		// Tell curl not to return headers, but do return the response
		curl_setopt($session, CURLOPT_HEADER, false);
		
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

		// obtain response
		$response = curl_exec($session);
		$response = json_decode($response);
		if($response->message == 'success')
		{
			curl_close($session);
			return true;
		}
		else
		{
			curl_close($session);
			return false;
		}
	}



function get_date($rectime)
{
 $dayDiffCeil = !empty($rectime['DAY_DIFF_CEIL'])?$rectime['DAY_DIFF_CEIL']:0;
 $dayDiff = !empty($rectime['DAY_DIFF'])?$rectime['DAY_DIFF']:0;
 $hrDiff = !empty($rectime['HR_DIFF'])?$rectime['HR_DIFF']:0;
 $minDiff = !empty($rectime['MIN_DIFF'])?$rectime['MIN_DIFF']:0;
 $etoOfrDateDisp = !empty($rectime['ETO_OFR_LAST_UPDATED'])?$rectime['ETO_OFR_LAST_UPDATED']:0;

 $dateDisp = '';
if($dayDiffCeil >= 2 )
{
        $dateDisp = $etoOfrDateDisp;
}
elseif($dayDiff >= 1)
{
        $dateDisp = 'Yesterday';
}
elseif($hrDiff >= 1)
{
        if($hrDiff == 1 )
        {
                $dateDisp = $hrDiff." ". 'hr ago';
        }
        elseif($hrDiff>1)
        {
                $dateDisp = $hrDiff. " ". 'hrs ago';
        }

}
elseif($hrDiff == 0)
{
        if($minDiff == 1 || $minDiff ==0)
        {
                $dateDisp = $minDiff. " ". 'min ago';
        }
        elseif($minDiff>1)
        {
                $dateDisp = $minDiff. " ". 'mins ago';
        }
}

return array($dateDisp,$dayDiffCeil);
}


function removeUnwantedInfodesc($result)
{
$str = isset($result['ETO_OFR_DESC'])?$result['ETO_OFR_DESC']:''; 	
$str = preg_replace( "/&lt;/", '<', $str );
$str = preg_replace( "/&gt;/", '>', $str );
$str = preg_replace( "/(<\s*a\b.*?\/\s*a\s*>)|(<\s*\/?\s*a\b.*?\s*>)/", ' ', $str );
$str = preg_replace( "/(<\s*img\b.*?\s*>)/", ' ', $str );
$str = preg_replace( "/(http\:\/\/|www\.)(.*?)[^\s\<]*/", ' ', $str );
$str = preg_replace( "/\b([\w\-\_\.]*?)(\@[\w\-\_\.]*?)(\s+?|$)/", ' ', $str );
return ($str);
}


public function purchaseButton($eto_glusr_email, $eto_ofr_id, $eto_lead_fk_gl_module_id)
	{
		$ofr_price = '20';
		list($start_Time, $stHour, $cur_date) = $this->get_time();
		$encry_ofrid = $this->get_encryptedID($eto_ofr_id);
		$encry_email = $this->get_encryptedID($eto_glusr_email);
		$encry_ofr_price = $this->get_encryptedID($ofr_price); 
		$cur_date = $this->get_encryptedID($cur_date);
		$encry_ofrid = urlencode($encry_ofrid);
		$encry_email = urlencode($encry_email);
		$encry_ofr_price = urlencode($encry_ofr_price);
		$cur_date = urlencode($cur_date); 
		$email_buy_track = "http://seller.indiamart.com/bltxn/MailPurchase1/Index/?offer=$encry_ofrid&email=$encry_email&lead_date=$cur_date&lead_price=$encry_ofr_price&eto_lead_fk_gl_module_id=$eto_lead_fk_gl_module_id";
		return "$email_buy_track&mailaction=SQF&utm_source=quoteonly";
	}

private function get_encryptedID($orig_string)
	{
		$key = '1996c39iil';
		$s = array();
		for ($i = 0; $i < 256; $i++)
			$s[$i] = $i;
		$j = 0;
		for ($i = 0; $i < 256; $i++)
		{
			$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
			$x = $s[$i];
			$s[$i] = $s[$j];
			$s[$j] = $x;
		}
		$i = 0;
		$j = 0;
		$res = '';
		for ($y = 0; $y < strlen($orig_string); $y++) 
		{
			$i = ($i + 1) % 256;
			$j = ($j + $s[$i]) % 256;
			$x = $s[$i];
			$s[$i] = $s[$j];
			$s[$j] = $x;
			$res .= $orig_string[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
		}
		$res = base64_encode($res);
		return $res;
	}
public function getModid(){
$glEtoModel = new AdminEtoModelForm();
$dbh=$glEtoModel->connectMeshrDb();
$sql = "select GL_MODULE_ID from gl_module order by GL_MODULE_ID";
$stid = oci_parse($dbh, $sql);
oci_execute($stid);
$glmodid = oci_fetch_all($stid,$res);
return $res;


}


private function get_time()
	{
		date_default_timezone_set("Asia/Kolkata");
		$time = microtime(true);
		$micro = sprintf("%03d", ($time-floor($time))*1000);
		$date = new DateTime(date('Y-m-d H:i:s.'.$micro, $time));
		return array($date->format("d/m/Y H:i:s"), $date->format("H"), $date->format("Y-m-d-H-i-s"), $date->format("i"), $date->format("s"), $micro);
	}


public function ClearReplyTos() {
    $this->ReplyTo = array();
  }


public function getGlusers($offerid,$dbh){

$sql = "select
  LISTAGG(FK_GLUSR_USR_ID, ',') WITHIN GROUP (ORDER BY ETO_LEAD_SUPPLIER_RANK) GLUSR_ID
from
  eto_lead_supplier_mapping,
  (  SELECT * FROM ETO_REJECTION_MASTER WHERE ETO_REJECTION_MASTER_LEAD_ID = :OFRID ) ETO_REJECTION_MASTER
where
  FK_ETO_OFR_DISPLAY_ID = :OFRID
  AND FK_GLUSR_USR_ID = ETO_REJECTION_MASTER_USER_ID(+)
  and ETO_REJECTION_MASTER_LEAD_ID is null
  and ROWNUM <= 20
  order by ETO_LEAD_SUPPLIER_RANK";
$stid = oci_parse($dbh, $sql);
oci_bind_by_name($stid, ":OFRID", $offerid);
oci_execute($stid);
$res = oci_fetch_assoc($stid);
return $res['GLUSR_ID'];
}

public function getGlusers_pg($offerid,$dbh){

$sql = "select
  STRING_AGG(FK_GLUSR_USR_ID, ',' order by ETO_LEAD_SUPPLIER_RANK) GLUSR_ID 
from
  eto_lead_supplier_mapping,
  (  SELECT * FROM ETO_REJECTION_MASTER WHERE ETO_REJECTION_MASTER_LEAD_ID = $1) ETO_REJECTION_MASTER
where
  FK_ETO_OFR_DISPLAY_ID = $1
  AND FK_GLUSR_USR_ID = ETO_REJECTION_MASTER_USER_ID(+)
  and ETO_REJECTION_MASTER_LEAD_ID is null
  and ROWNUM <= 20";
$params=array($offerid);
$stid= pg_query_params($dbh,$sql,$params);
$res = pg_fetch_array($stid);
$res=array_change_key_case($res, CASE_UPPER);
return $res['GLUSR_ID'];
}


}