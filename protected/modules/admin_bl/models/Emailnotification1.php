<?php
class Emailnotification1 extends CFormModel
{
public function call2($dbh,$dbh1,$glusremail)
{

// 		$glusremail=$_REQUEST['glusremail'];
// 		$glusremail= preg_replace('"','',$glusremail);
// 		$glusremail=preg_replace('^\s+','',$glusremail);
// 		$glusremail=preg_replace('\s+$','',$glusremail);
// 		
                $str1='';
		$sql="SELECT
		TRIM(TRIM(GLUSR_USR.GLUSR_USR_FIRSTNAME)||' '||TRIM(GLUSR_USR.GLUSR_USR_LASTNAME)) FULLNAME,
		GLUSR_USR_ID,
		GLUSR_USR_COMPANYNAME,
		GLUSR_USR_CITY,
		GLUSR_USR_STATE,
		GLUSR_USR_COUNTRYNAME,
		GLUSR_USR_PH_COUNTRY,
		GLUSR_USR_PH_AREA,
		GLUSR_USR_PH_NUMBER,
		GLUSR_USR_PH_MOBILE,
		GLUSR_USR_ADD1,
		GLUSR_USR_FAX_COUNTRY,
		GLUSR_USR_FAX_AREA,
		GLUSR_USR_FAX_NUMBER
		FROM 
		GLUSR_USR
		WHERE GLUSR_USR_EMAIL=:EMAIL";
		
		$sth= oci_parse($dbh1, $sql);
		 oci_bind_by_name($sth, ':EMAIL', $glusremail);
		 oci_execute($sth);
		 $arr1=oci_fetch_array($sth);
		$name= $arr1[0];
                  
	        $glusrid=$arr1[1];
	        $company=$arr1[2];
	        $city=$arr1[3];
	        $state=$arr1[4];
	        $country=$arr1[5];
	        $ph_country=$arr1[6];
	        $ph_area=$arr1[7];
	        $ph_no=$arr1[8];
	        $mobile=$arr1[9];
	        $address=$arr1[10];
	        $fax_country=$arr1[11];
	        $fax_area=$arr1[12];
	        $fax_no=$arr1[13];
	        
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
	        $sql="SELECT IIL_MAIL_EVENT_MAILID,IIL_MAIL_EVENT_CATEGORY,IIL_MAIL_EVENT_TYPE,IIL_MAIL_EVENT_URL,
				TO_CHAR(IIL_MAIL_EVENT_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,IIL_MAIL_EVENT_GLUSER_ID,IIL_MAIL_EVENT_SENT_DATE,
				IIL_MAIL_EVENT_BOUNCESTATUS,IIL_MAIL_EVENT_BOUNCEREASON,
				IIL_MAIL_EVENT_SENT_DATE 
				FROM IIL_MAIL_EVENTS WHERE IIL_MAIL_EVENT_MAILID=$glusremail
				/*UNION
				SELECT IIL_MAIL_EVENT_MAILID,IIL_MAIL_EVENT_CATEGORY,IIL_MAIL_EVENT_TYPE,IIL_MAIL_EVENT_URL,
				TO_CHAR(IIL_MAIL_EVENT_DATE,'DD-MON-YYYY HH24:MI:SS') IIL_MAIL_EVENT_DATE1,IIL_MAIL_EVENT_GLUSER_ID,IIL_MAIL_EVENT_SENT_DATE,
				IIL_MAIL_EVENT_BOUNCESTATUS,IIL_MAIL_EVENT_BOUNCEREASON,
				IIL_MAIL_EVENT_SENT_DATE 
				FROM IIL_MAIL_EVENTS_INTERIM WHERE IIL_MAIL_EVENT_MAILID=$glusremail*/
				ORDER BY IIL_MAIL_EVENT_DATE1 DESC";
				
				
	         $sth= pg_query($dbh, $sql);
		 $str1.='<div><table align="center" class="report_table" border="1" width="1210" cellpadding="0" cellspacing="0" bordercolor="#E1EDFA" style="border-collapse:collapse">
			<tr bgcolor="#E1EDFA">
			<td width="210" '.$styletd.'><b>Email ID</b></td>
			<td width="75" '.$styletd.'><b>GLUSERID</b></td>
			<td width="130" '.$styletd.'><b>TIMESTAMP</b></td>
			<td width="200" '.$styletd.'><b>CATEGORY</b></td>
			<td width="70" '.$styletd.'><b>SUB CAT</b></td>
			<td width="80" '.$styletd.'><b>EVENT</b></td>
			<td width="155" '.$styletd.'><b>URL</b></td>
			<td width="120" '.$styletd.'><b>MAIL SENT DATE</b></td>
			<td width="90" '.$styletd.'><b>REASON</b></td>
			<td width="60" '.$styletd.'><b>STATUS</b></td>
			<td width="60" '.$styletd.'><b>TYPE</b></td>
			</tr>';
			
		while($rec = pg_fetch_array($sth))
		{
		 $email=$rec['IIL_MAIL_EVENT_MAILID'];
		 $timestamp=$rec['IIL_MAIL_EVENT_DATE1'];
		 $category=$rec['IIL_MAIL_EVENT_CATEGORY'];
		 $event=$rec['IIL_MAIL_EVENT_TYPE'];
		 $url=$rec['IIL_MAIL_EVENT_URL'];
		 $reason=$rec['IIL_MAIL_EVENT_BOUNCEREASON'];
		 $status=$rec['IIL_MAIL_EVENT_BOUNCESTATUS'];
# 				my $type=$rec->{'IIL_MAIL_EVENT_BOUNCETYPE'};
		 $type='';
		 $gluser_id=$rec['IIL_MAIL_EVENT_GLUSER_ID'];
# 				my $subcat=$rec->{'IIL_MAIL_EVENT_SUBCAT'};
		 $subcat='';
		 $sent_date=$rec['IIL_MAIL_EVENT_SENT_DATE'];
		 $str1.='<tr><td '.$styletd.'>'.$email.'</td>';
				$str1.='<td '.$styletd.'>';
				if($gluser_id){
				$str1.=''.$gluser_id.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($timestamp){
				$str1.='<div style="width:100px">'.$timestamp.'</div>';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($category)
				{
				$str1.=''.$category.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($subcat){
				$str1.=''.$subcat.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($event){
				$str1.=''.$event.'';
				}
				$str1.='</td>
				<td '.$styletd.'>';
				if($url){
				$str1.='<input type="text" title="$url" value="$url" style="border:0px;font-family:arial;font-size:11px;width:155px" readonly>';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($sent_date){
				$str1.=''.$sent_date.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($reason){
				$str1.=''.$reason.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($status){
				$str1.=''.$status.'';
				}
				$str1.='</td>';
				$str1.='<td '.$styletd.'>';
				if($type){
				$str1.=''.$type.'';
				}
				$str1.='</td></tr> ';
			}
			$str1.='</table></div>';
return $str1;
}
}
?>	        