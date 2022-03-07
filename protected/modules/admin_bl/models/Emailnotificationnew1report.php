<?php
class Emailnotificationnew1report extends CFormModel
{
public function new_call2($dbh,$dbh1,$glusremail)
{

// 		$glusremail=$_REQUEST['glusremail'];
// 		$glusremail= preg_replace('"','',$glusremail);
// 		$glusremail=preg_replace('^\s+','',$glusremail);
// 		$glusremail=preg_replace('\s+$','',$glusremail);
// 		
                $str1='';
// 		$sql="SELECT
// 		TRIM(TRIM(GLUSR_USR.GLUSR_USR_FIRSTNAME)||' '||TRIM(GLUSR_USR.GLUSR_USR_LASTNAME)) FULLNAME,
// 		GLUSR_USR_ID,
// 		GLUSR_USR_COMPANYNAME,
// 		GLUSR_USR_CITY,
// 		GLUSR_USR_STATE,
// 		GLUSR_USR_COUNTRYNAME,
// 		GLUSR_USR_PH_COUNTRY,
// 		GLUSR_USR_PH_AREA,
// 		GLUSR_USR_PH_NUMBER,
// 		GLUSR_USR_PH_MOBILE,
// 		GLUSR_USR_ADD1,
// 		GLUSR_USR_FAX_COUNTRY,
// 		GLUSR_USR_FAX_AREA,
// 		GLUSR_USR_FAX_NUMBER
// 		FROM 
// 		GLUSR_USR
// 		WHERE GLUSR_USR_EMAIL=:EMAIL";
// 		
// 		$sth= oci_parse($dbh1, $sql);
// 		 oci_bind_by_name($sth, ':EMAIL', $glusremail);
// 		 oci_execute($sth);
// 		 $arr1=oci_fetch_array($sth);
		$name= '';
                  
	        $glusrid='';
	        $company='';
	        $city='';
	        $state='';
	        $country='';
	        $ph_country='';
	        $ph_area='';
	        $ph_no='';
	        $mobile='';
	        $address='';
	        $fax_country='';
	        $fax_area='';
	        $fax_no='';
	        
	        if($ph_country)
	        {
	        $phone = "($ph_country)";
	        }
	        
	        if($ph_area)
		{
			$phone .="-($ph_area)"; 
		}
	        if($ph_no)
	        {
	        $phone .="-$ph_no"; 
	        }
	        
	        if($fax_country)
	        {
	        $fax = "($fax_country)";
	        }
	        if($fax_area)
		{
			$fax .="-($fax_area)"; 
		}
		if($fax_no){
		$fax .="-$fax_no";
		}
		$str1.='<TABLE BORDER="0" WIDTH="100%"><TR>
		<TD width="98%" align="left" STYLE="font-family:arial;font-size:13px;padding:5px;">
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">
		Complete Contact Details for Gluser:';
		
		if($glusrid)
		{
		$str1.=''.$glusrid.'';
		}
	        $str1.='</DIV>';
	        if($company)
		{
	        $str1.='<div><B>Company:</B> '.$company.'</div>';
	        }
	        if($name)
		{
		$str1.='<div><B>Name:</B> '.$name.'</div>';
		}
		if($address)
		{
			$str1.='<div><B>Address:</B> '.$address.'</div>';
		}
		if($city)
		{
			$str1.='<div><B>City:</B> '.$city.'</div>';
		}
		if($state)
		{
			$str1.='<div><B>State:</B> '.$state.'</div>';
		}
		if($country)
		{
		$str1.='<div><B>Country:</B> '.$country.'</div>';
		}
		if($ph_no)
		{
			$str1.='<div><B>Telephone:</B> '.$phone.'</div>';
		}
		
		if($fax_no)
		{
			$str1.='<div><B>Fax:</B> '.$fax.'</div>';
		}
		if($mobile)
		{
			$mobile ="($ph_country)-$mobile";
			$str1.='<div><B>Mobile / Cell Phone:</B> '.$mobile.'</div>';
		}
	        $str1.='<div><B>Email:</B>'.$glusremail.'</div></td><tr></table><DIV><BR></DIV><DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">All Email Activities Of This Gluser</DIV>';
	        
	        $styletd='style="font-family:arial;font-size:12px;padding:3px 0 3px 5px;"';
	        $sql="SELECT MAIL_RECV_MAILID,MAIL_CATEGORY,FK_MAIL_TYPE_ID,NULL IIL_MAIL_EVENT_URL,
				TO_CHAR(MAIL_REQUEST_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,MAIL_RECV_GLID,MAIL_REQUEST_DATE,
				MAIL_BOUNCE_CODE,MAIL_BOUNCE_REASON,
				MAIL_SENT_DATE,MAIL_FIRST_OPEN_DATE,
                              MAIL_LAST_CLICK_DATE,
                              MAIL_BOUNCE_DATE,
                              MAIL_SPAM_DATE,
                              MAIL_UNSUBSCRIBE_DATE
				FROM IIL_MAIL_LOG_J1 WHERE MAIL_RECV_MAILID='$glusremail'
				ORDER BY IIL_MAIL_EVENT_DATE1 DESC";
				
				
	         $sth= @pg_query($dbhpg, $sql);
		 $str1.='<div><table align="center" class="report_table" border="1" width="1210" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
			<tr bgcolor="#E1EDFA">
			<td width="210" '.$styletd.'><b>Email ID</b></td>
			<td width="75" '.$styletd.'><b>GLUSERID</b></td>
			<td width="130" '.$styletd.'><b>CATEGORY</b></td>
			<td width="200" '.$styletd.'><b>Mail Sent Date</b></td>
			<td width="70" '.$styletd.'><b>Open Date</b></td>
			<td width="80" '.$styletd.'><b>Click Date</b></td>
			<td width="155" '.$styletd.'><b>Bounce Date</b></td>
			<td width="120" '.$styletd.'><b>Spam Date</b></td>
			<td width="90" '.$styletd.'><b>Unsubscribe Date</b></td>
			</tr>';
			
		while($rec = pg_fetch_array($sth))
		{
		 $email=$rec['mail_recv_mailid'];
		 $timestamp=$rec['iil_mail_event_date1'];
		 $category=$rec['mail_category'];
		 $event=$rec['fk_mail_type_id'];
		 $url=$rec['iil_mail_event_url'];
		 $reason=$rec['mail_bounce_reason'];
		 $status=$rec['mail_bounce_code'];
		$opendate=$rec['mail_first_open_date'];
		$clicdate=$rec['mail_last_click_date'];
		$bouncedate=$rec['mail_bounce_date'];
		$spamdate=$rec['mail_spam_date'];
		$unsubscribe=$rec['mail_unsubscribe_date'];
		 $type='';
		 $gluser_id=$rec['mail_recv_glid'];
		 $subcat='';
		 $sent_date=$rec['mail_sent_date'];
		  $str1.='<tr><td '.$styletd.'>'.$email.'</td>';
				$str1.='<td '.$styletd.'>';
				if($gluser_id){
				$str1.=''.$gluser_id.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($category){
				$str1.='<div style="width:100px">'.$category.'</div>';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($sent_date)
				{
				$str1.=''.$sent_date.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($opendate){
				$str1.=''.$opendate.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($clicdate){
				$str1.=''.$clicdate.'';
				}
				$str1.='</td>
				<td '.$styletd.'>';
				if($bouncedate){
				$str1.=''.$bouncedate.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($spamdate){
				$str1.=''.$spamdate.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($unsubscribe){
				$str1.=''.$unsubscribe.'';
				}
				$str1.='</td></tr> ';
			}
			$str1.='</table></div>';
return $str1;
}
}
?>	        