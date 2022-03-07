<?php   

if($jobtype['jobtype']!= 13){
    if ( !empty($result['rec'])) {
    $rec = $result['rec'];
    }
    $status = $result['status'];
    $ETO_LEAP_VENDOR_NAME='';
    $userStatusDesc = array('W' => 'Waiting', 'A' => 'Approved', 'D' => 'Disabled', 'M' => 'Error Disabled');
    $recMap1 = isset($arr_map_ref['arrmap'])?$arr_map_ref['arrmap']:'';
    $recmcat_mondatory=isset($arr_map_ref['recmcat_mondatory'])?$arr_map_ref['recmcat_mondatory']:'';
    $recmcat_mondatory['gl_profile_old_value']=isset($recmcat_mondatory['gl_profile_old_value'])?$recmcat_mondatory['gl_profile_old_value']:'';
    $recmcat_mondatory['gl_profile_new_value']=isset($recmcat_mondatory['gl_profile_new_value'])?$recmcat_mondatory['gl_profile_new_value']:'';
    if (isset($rec['ETO_LEAP_VENDOR_NAME'])) {
        if (preg_match("/In-Active/", $rec['ETO_LEAP_VENDOR_NAME']) > 0) {
            $associate_status = "In-Active";
            $ETO_LEAP_VENDOR_NAME = rtrim($rec['ETO_LEAP_VENDOR_NAME'], "|In-Active");
        } elseif (preg_match("/Active/", $rec['ETO_LEAP_VENDOR_NAME'])) {
            $ETO_LEAP_VENDOR_NAME = rtrim($rec['ETO_LEAP_VENDOR_NAME'], "|Active");
            $associate_status = "Active";
        } else {
            $ETO_LEAP_VENDOR_NAME = $rec['ETO_LEAP_VENDOR_NAME'];
        }
    }
    $ETO_OFR_DESC = '';
                if (isset($rec['ETO_OFR_DESC'])) {
                    $ETO_OFR_DESC = htmlentities(strip_tags($rec['ETO_OFR_DESC']));
                }
    $postDataOrig = isset($rec['APPROV_DATE']) ? $rec['APPROV_DATE'] : '';
    $deletedon = '';
                if ($status == "T" or $status == "D") {
                    $deletedon = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
                } else {
                    $expiredDate = isset($rec['EXPIRED_ON_DATE']) ? $rec['EXPIRED_ON_DATE'] : '';
                }
                $modid = $result['origModid'];
                $tableType = isset($rec['TABLE_TYP']) ? $rec['TABLE_TYP'] : 3;
                $glid = isset($rec['FK_GLUSR_USR_ID'])?$rec['FK_GLUSR_USR_ID']:'' ;
                if (!empty($rec) && !empty($offerID) && isset($rec['ETO_OFR_ID'])) {
                    $flagRecFound = 1;
                    $rowCounter++;
                }
              }
              else{
               $call_record_id=$offerArr['fk_leap_call_records_id'];
               $ETO_LEAP_VENDOR_NAME =$offerArr['eto_leap_vendor_name'];
               $arr_map_ref=array();
              }
$approveby = isset($rec['GL_EMP_ID']) ? $rec['GL_EMP_ID'] : '';
    $start = $result['start'];
    $mcatmapping = $result['mcatmapping'];
    $postParamArr = $result['postParamArr'];
    $userDetail = $result['userDetail'];
    $userDet = $result['userDet'];
    $err1 = '';
    $err2 = '';
    $err3 = '';
    $err4 = '';
    $err5 = '';
    $err6 = '';
    $err7 = '';
    $err8 = '';
    $err9 = '';
    $err10 = '';
    $err21 = '';
    $err22 = '';
    $err24 = '';
    $err25 = '';

?>

<!DOCTYPE html>
    <head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="protected/css/Poppins.css">
	<link rel="stylesheet" type="text/css" href="protected/css/audit.css?v=2">
    <style>
    .gluser_info{border-collapse:collapse; border:1px solid #ededed;border-left:0px}
	.gluser_info td{border-collapse:collapse; border:1px solid #ededed;height:35px}
	.gluser_info td input{border:1px solid #d9d9d9; height:25px}
	.gluser_info td.lfb{border-left:0px}
    .admintext-h{font-family:arial,ms sans serif,verdana; font-size:12px; height:22px; padding-left:3px;}
    .admintext {font-family:arial,ms sans serif,verdana; font-size:12px;font-weight:bold;}
	.admintext1 {font-family:arial,ms sans serif,verdana; font-size:12px;}
	.admintext2 {font-family:ms sans serif,verdana; font-size:12px;}
</style>
<script language="javascript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js" ></script>
<script src="protected/modules/admin_eto/js/SuperAudit.js?v=26"></script>
<script>

</script>

   <title></title>
  </head>
   <body>
   <table border="1" cellpadding="3" cellspacing="0" bordercolor="#ebebeb" style="border-collapse:collapse;" width="100%">
		<tr><td width="128" align="left" bgcolor="#c6def1"><div class="clint ffl" style="padding-left:2px">
		<?php if (isset($result['show_client1'])) {
                echo $result['show_client1'];
            }
            echo '</div></td>
		<td width="340" bgcolor="#c6def1" style="font-size:15px"><b>Current Gluser Details ';
            echo '<span style="color:#c90000;font-size:11px">';
            echo isset($userDet['GLUSR_USR_APPROV']) ? '<b>' . $userStatusDesc[$userDet['GLUSR_USR_APPROV']] . '</b>' : ''; ?>
		</span>
        </b> </td>
        <td bgcolor="#c6def1"><strong class="hd" style="color:#000; font-size:14px">New Contact Details</strong> &nbsp; <span id="fcpdetail"><input type="button" name="showfcp" id="showfcp" value="Show FCP Applicable" onclick="showfcpdetail(<?php echo $_REQUEST['offerID'] ; ?>);"></span> &nbsp;
                     &nbsp;&nbsp;&nbsp;<a href="/index.php?r=admin_eto/OfferDetail/showproduct&glid=<?php echo $rec['FK_GLUSR_USR_ID']; ?>&mid=3424" TARGET="_blank">View Products I Sell</a>
                </td>
        </tr>
        </table>
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
		<?php $senderName = isset($rec['ETO_OFR_S_SENDERNAME']) ? $rec['ETO_OFR_S_SENDERNAME'] : ''; ?>
		<td width="482"  valign="top"><input type="hidden" name="sender_name" id="sender_name" value="<?php echo $senderName ?>" >
	    <table border="0" class="gluser_info" cellpadding="0" cellspacing="0" style="border-top:0px" width="100%">
 	    <tr>
		<td width="130" CLASS="admintext"><strong>Name&nbsp;<FONT COLOR="red">*</FONT></strong></TD>
		<TD CLASS="admintext1" >
		<?php
            $email = isset($userDet['GLUSR_USR_EMAIL']) ? trim($userDet['GLUSR_USR_EMAIL']) : '';
            $email = preg_replace('/\s/', "", $email);
            $firstname = isset($userDet['GLUSR_USR_FIRSTNAME']) ? $userDet['GLUSR_USR_FIRSTNAME'] : '';
            //$firstname =~ s/"/&#34;/g;
            $lastname = isset($userDet['GLUSR_USR_LASTNAME']) ? $userDet['GLUSR_USR_LASTNAME'] : '';
            //$lastname =~ s/"/&#34;/g;
            $companyname = isset($userDet['GLUSR_USR_COMPANYNAME']) ? $userDet['GLUSR_USR_COMPANYNAME'] : '';
            //$companyname =~ s/"/&#34;/g;
            $altEmail = isset($userDet['GLUSR_USR_EMAIL_ALT']) ? $userDet['GLUSR_USR_EMAIL_ALT'] : '';
            $desin = isset($userDet['GLUSR_USR_DESIGNATION']) ? $userDet['GLUSR_USR_DESIGNATION'] : '';
            $countryIso = isset($userDet['FK_GL_COUNTRY_ISO']) ? $userDet['FK_GL_COUNTRY_ISO'] : '';
            $city = isset($userDet['GLUSR_USR_CITY']) ? $userDet['GLUSR_USR_CITY'] : '';
            $cityID = isset($userDet['FK_GL_CITY_ID']) ? $userDet['FK_GL_CITY_ID'] : '';
            $state = isset($userDet['GLUSR_USR_STATE']) ? $userDet['GLUSR_USR_STATE'] : '';
            $stateID = isset($userDet['FK_GL_STATE_ID']) ? $userDet['FK_GL_STATE_ID'] : '';
            $stateOther = isset($userDet['GLUSR_USR_STATE_OTHERS']) ? $userDet['GLUSR_USR_STATE_OTHERS'] : '';
            $countryName = isset($userDet['GLUSR_USR_COUNTRYNAME']) ? $userDet['GLUSR_USR_COUNTRYNAME'] : ''; ?>
	      	<input type="Hidden" name="chnge_txt" id="chnge_txt" value="">
		
		<input name="txtfname" type="text" id="txtfname" maxlength="100" style="width: 125px;" value="<?php echo $firstname; ?>" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" CLASS="admintext-h" onblur="checkOnBlur(this);">
		<input id="txtlname" name="txtlname" type="text" maxlength="100"  style="width: 116px;" value ="<?php echo $lastname; ?>" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" CLASS="admintext-h" onblur="checkOnBlur(this);"> 
       
		<input id="email_sugg" name="email_sugg" type="hidden"  value ="<?php echo isset($result['correct_domain'])?$result['correct_domain']:''; ?>" >
		<input id="domain_name" name="domain_name" type="hidden"  value ="<?php echo isset($result['domain_val'])?$result['domain_val']:''; ?>" >
		</TD> <td>		
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext" style="height:45px">
		<strong>Email</strong>&nbsp;&nbsp;<span id="emailval1" name="emailval1"></span>
		</TD>
		<TD>
		    <input name="email" id="email"  type="text"  style="width: 300px;" CLASS="admintext-h" readonly value="<?php echo $email; ?>" >
		</TD>
		<td>
		<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'109'} eq 'Y');-->
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext" style="height:45px"><strong>Alt Email</strong>&nbsp;&nbsp;<span id="emailval2" name="emailval2">
		</span>
		</TD>
		<TD>
		<input name="alt_email" id="alt_email"  type="text"  readonly style="width: 300px;" CLASS="admintext-h"  onblur="check_value('altemail','emailval2');"  value="<?php echo $altEmail; ?>" onblur="checkOnBlur(this);">
		</TD>
		<td>
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext"><strong>Designation</strong></TD>
		<TD> 
		<input name="desi" type="text" CLASS="admintext-h" value="<?php echo $desin; ?>"  style="width: 300px;" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOnBlur(this);">
		</TD>
		<td>		
		</td>
	    </TR>
	    <TR>
		<TD CLASS="admintext"><strong>Company Name</strong></TD>
		<TD>
		<input name="company" id="company" CLASS="admintext-h" type="text" value="<?php echo $companyname; ?>" style="width: 300px;" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOwnerShip();checkOnBlur(this);" >
		</TD>
		<td>		
		</td>
	    </TR>
	    <TR><TD CLASS="admintext"><strong>Ownership Type</strong></TD><TD>
	    <SELECT  NAME="legal_status_id" id="legal_status_id" onchange="changetext();checkOnBlur(this);">
	   <OPTION VALUE="">---Choose One---</OPTION>
	   <?php
            $legalStatusRow = CommonVariable::GetOwnerShip_values();
            foreach ($legalStatusRow as $key => $value) {
                if (isset($userDet['FK_GL_LEGAL_STATUS_ID']) && $userDet['FK_GL_LEGAL_STATUS_ID'] == $key) {
                    echo '<OPTION VALUE="' . $key . '" selected>' . $value . '</OPTION>';
                } else {
                    echo '<OPTION VALUE="' . $key . '">' . $value . '</OPTION>';
                }
            } ?>
	    </SELECT>
	    </TD>
	    <td>
	    </td>
	</TR>
	
	<TR>
		<TD CLASS="admintext"><strong>Country&nbsp;<FONT COLOR="red">*</FONT></strong></strong></TD>
		<TD >
			<Input type="Hidden" name="country_iso" value="<?php echo $countryIso; ?>" id="country_iso"> 
			<Input type="Hidden" name="country" value="<?php echo $countryIso; ?>" id="country_id">
			<span id="xyz"><INPUT NAME="country_name" id="country_name" SIZE="33" VALUE="<?php echo $countryName; ?>" TYPE="text" autocomplete="off"  style="width: 300px;" class="country_name" maxlength="40"  onchange="changetext();checkOnBlur(this);">
			</span>
		</TD>
		<td>
		</td>
	</TR>
	<TR>
		<TD CLASS="admintext"><strong>Senders IP (Country)</strong></TD>
		<TD style="font-size:12px;" > NA </TD>
		<td></td>
	</TR>
	<TR>
		<TD CLASS="admintext"><strong>City</strong></TD>
		<TD>
			<input name="city_others"  id="city_others" type="text" value="<?php echo $city; ?>"  onblur="('city_others',this.value);"  onchange="changetext();checkOnBlur(this);"  style="width: 125px;"> 
			<input type="hidden" name="city" id="city" value="<?php echo $cityID; ?>"  CLASS="admintext-h">
		 	<strong style="font-size:12px;">State&nbsp&nbsp</strong>
			<input name="state_others" id="state_others" type="text" value="<?php echo $state; ?>" onkeyup="sendRequest(this.value);"  onchange="changetext();" style="width: 128px;" >
			<input type="hidden" name="state" id="state" value="<?php echo $stateID; ?>" CLASS="admintext-h"> 
		<?php
            $val = "";
            if (!empty($stateID) || !empty($stateOther)) {
                if (!empty($stateID)) {
                    $val = $stateID;
                } else {
                    $val = $stateOther;
                }
            }
            $glusr_add1 = isset($userDet['GLUSR_USR_ADD1']) ? $userDet['GLUSR_USR_ADD1'] : '';
            $glusr_add2 = isset($userDet['GLUSR_USR_ADD2']) ? $userDet['GLUSR_USR_ADD2'] : '';
            $zip = isset($userDet['GLUSR_USR_ZIP']) ? $userDet['GLUSR_USR_ZIP'] : '';
            $ph_country = isset($userDet['GLUSR_USR_PH_COUNTRY']) ? $userDet['GLUSR_USR_PH_COUNTRY'] : '';
            $phArea = isset($userDet['GLUSR_USR_PH_AREA']) ? $userDet['GLUSR_USR_PH_AREA'] : '';
            $phNumber = isset($userDet['GLUSR_USR_PH_NUMBER']) ? $userDet['GLUSR_USR_PH_NUMBER'] : '';
            $ph_country2 = '';
            $phArea2 = isset($userDet['GLUSR_USR_PH2_AREA']) ? $userDet['GLUSR_USR_PH2_AREA'] : '';
            $phNumber2 = isset($userDet['GLUSR_USR_PH2_NUMBER']) ? $userDet['GLUSR_USR_PH2_NUMBER'] : '';
            $fax_country = isset($userDet['GLUSR_USR_FAX_COUNTRY']) ? $userDet['GLUSR_USR_FAX_COUNTRY'] : '';
            $faxArea = isset($userDet['GLUSR_USR_FAX_AREA']) ? $userDet['GLUSR_USR_FAX_AREA'] : '';
            $faxNumber = isset($userDet['GLUSR_USR_FAX_NUMBER']) ? $userDet['GLUSR_USR_FAX_NUMBER'] : '';
            $mobile = isset($userDet['GLUSR_USR_PH_MOBILE']) ? $userDet['GLUSR_USR_PH_MOBILE'] : '';
            $mobileAlt = isset($userDet['GLUSR_USR_PH_MOBILE_ALT']) ? $userDet['GLUSR_USR_PH_MOBILE_ALT'] : '';
            //$glusr_add1 =~ s/"/&#34/g;
            //$glusr_add2 =~ s/"/&#34/g;
            
?>
		
			<input type="Hidden" name="usr_state_id" value="<?php echo $val; ?>"></TD>
			<td>
			<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'114'} eq 'Y' && $verifyInfohash->{'115'} eq 'Y');-->
		</td>
		</TR>
		<TR>
			<TD CLASS="admintext" ><strong>Pin Code</strong></TD>
			<TD><input name="Pin" type="text" id="Pin"  CLASS="admintext-h" value="<?php echo $zip; ?>" onchange="changetext();" style="width: 125px;" onblur="checkOnBlur(this);"></TD>
			<td>
			<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'117'} eq 'Y');-->
		</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Address1</strong></TD>
			<TD><input name="Address1" id="Address1" type="text" CLASS="admintext-h" value="<?php echo $glusr_add1; ?>" style="width: 300px;" ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOnBlur(this);"></TD>
			<td>
			<!--print qq~<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'112'} eq 'Y');-->
			</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Address2</strong></TD>
			<TD><input name="Address2" type="text" CLASS="admintext-h" value="<?php echo $glusr_add2; ?>" style="width: 300px;"  ONKEYDOWN="return capturekey(event,this);" onchange="changetext();" onblur="checkOnBlur(this);"></TD>
			<td>
			</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Phone1&nbsp;<FONT COLOR="red">*</FONT></strong></TD>
			<TD>
				<input name="ph_country" id="ph_country" type="text" size="6" CLASS="admintext-h" style="width: 40px;"  readonly value="<?php echo $ph_country; ?>">
				<input name="ph_area" id="ph_area" type="text" maxlength="6" size="10" CLASS="admintext-h" style="width: 50px;" value="<?php echo $phArea; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
				<input name="Ph_phone" id="Ph_phone" type="text" size="10" CLASS="admintext-h" style="width: 120px;" value="<?php echo $phNumber; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
			</TD>
			<td>
			</td>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Phone2 &nbsp;<FONT COLOR="red">*</FONT></strong></strong></TD>
			<TD>
			<input name="ph_country2" id="ph_country2" type="text" size="6" CLASS="admintext-h" style="width: 40px;" readonly value="<?php echo $ph_country2; ?>">
			<input name="ph_area2"  id= "ph_area2" type="text" maxlength="6" size="10" CLASS="admintext-h" style="width: 50px;" value="<?php echo $phArea2; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
			<input name="Ph_phone1" id="Ph_phone1" type="text" size="10" CLASS="admintext-h" style="width: 120px;" value="<?php echo $phNumber2; ?>"  onchange="changetext();" onblur="checkOnBlur(this);">
			</TD>
			<td>
		<!--<img src="/gifs/tick_green.png">~ if($verifyInfohash->{'118'} eq 'Y' && $verifyInfohash->{'119'} eq 'Y' && $verifyInfohash->{'156'} eq 'Y');-->
			</td>	
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Mobile1&nbsp;<FONT COLOR="red">*</FONT></strong></strong></TD>
			<TD>
				<input name="mob_country" id="mob_country" type="text" size="6"  style="width: 40px;"  value="<?php echo $ph_country; ?>" CLASS="admintext-h" readonly >
				<input readonly name="mobile1" id="mobile1" style="width: 85px;" type="text" value="<?php echo $mobile; ?>" size"20" CLASS="admintext-h"  onchange="changetext();" onblur="checkOnBlur(this);">
		<strong class="admintext">&nbsp;&nbsp;Mobile2&nbsp;&nbsp;&nbsp;</strong>
<?php
            $dispurl = isset($rec['GLUSR_USR_URL']) ? $rec['GLUSR_USR_URL'] : '';
?>
		<input type="text" readonly name="mobile2" id="mobile2"  style="width: 85px;" value="<?php echo $mobileAlt; ?>" size="20" CLASS="admintext-h"  onchange="changetext();" onblur="checkOnBlur(this);"></td><td>
		</TD>
		</TR>
		<TR>
			<TD CLASS="admintext"><strong>Website</strong></TD>
			<TD >
				<input name="url" id="url" size = "60" type="text" onkeyup="q_http_val(this.value);" onkeypress="q_http_val(this.value);" onfocus="showimage(document.postForm,this.name,'hide');q_http_val(this.value);" onblur="showimage(document.postForm,this.name,'show');checkOnBlur(this);" style="width: 300px;" value="<?php echo $dispurl; ?>" size="35" CLASS="admintext-h"  onchange="changetext();" >
			</TD>
			<td>
			</td>
		</TR>
     </table>   
     <td valign="top">
		<table border="0" class="gluser_info" cellpadding="0" cellspacing="0" style="border-top:0px;font-size:12px" width="100%">
		<tr><td width="30%" class="lfb">&nbsp;<?php echo $senderName; ?></td><td>&nbsp;</td>
		</tr>
		<tr>
  		 <td class="lfb" style="height:45px;" >&nbsp;NA </td><td>
<?php
            if ($postParamArr['status'] == 'W') {
                if (!empty($err2)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err2 . '</span>';
                } else if (!empty($err22)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err22 . '</span>';
                } else if (!empty($err21)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err21 . '</span>';
                } else if (!empty($err24)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err24 . '</span>';
                } else if (!empty($err25)) {
                    echo '<span style="line-height:23px; letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span>  ' . $err25 . '</span>';
                }
            }
            $designation = isset($rec['ETO_OFR_S_DESIGNATION']) ? $rec['ETO_OFR_S_DESIGNATION'] : '';
            $organization = isset($rec['ETO_OFR_S_ORGANIZATION']) ? $rec['ETO_OFR_S_ORGANIZATION'] : '';
            echo '</TD></TR>
		<TR><td class="lfb" style="height:45px;" >&nbsp;NA</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $designation . '</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $organization . '</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err9)) {
                    echo '&nbsp;<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;">
			  <span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err9 . '</span>';
                }
            }
            $sCountry = isset($rec['ETO_OFR_S_COUNTRY']) ? $rec['ETO_OFR_S_COUNTRY'] : '';
            $sIp = isset($rec['ETO_OFR_S_IP']) ? $rec['ETO_OFR_S_IP'] : '';
            echo '&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $sCountry . '</TD><TD>&nbsp;</TD></TR>
		<TR><td class="lfb">&nbsp;' . $sIp;
            if (isset($rec['ETO_OFR_S_IP_COUNTRY'])) {
                echo ' ( ' . $rec['ETO_OFR_S_IP_COUNTRY'] . ' ) ';
            }
            echo '

		</TD><TD class="lfb" >';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err1)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err1 . '</span>';
                }
            }
            $sState = isset($rec['ETO_OFR_S_STATE']) ? $rec['ETO_OFR_S_STATE'] : '';
            $sCity = isset($rec['ETO_OFR_S_CITY']) ? $rec['ETO_OFR_S_CITY'] : '';
            echo '</TD></TR>
			<TR><TD class="lfb" >&nbsp;' . $sState . ' &nbsp;&nbsp; ' . $sCity . '</TD>
			<TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err7)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err7 . '</span>';
                } else if (!empty($err4)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err4 . '</span>';
                }
            }
            $sZip = isset($rec['ETO_OFR_S_ZIP']) ? $rec['ETO_OFR_S_ZIP'] : '';
            $sStreetAdd = isset($rec['ETO_OFR_S_STREETADDRESS']) ? $rec['ETO_OFR_S_STREETADDRESS'] : '';
            echo '</TD></TR>
		<TR><TD class="lfb" >&nbsp;' . $sZip . '</TD><TD></TD></TR>
		<TR><TD  class="lfb" >&nbsp;' . $sStreetAdd . '</TD><TD></TD></TR>
		<TR><TD class="lfb">&nbsp;</TD><TD></TD></TR>
		<TR>';
            echo '<TD class="lfb" >';
            if (isset($rec['ETO_OFR_S_PH_NUMBER'])) {
                if (isset($rec['ETO_OFR_S_PH_AREA'])) {
                    echo @$rec['ETO_OFR_S_PH_COUNTRY'] . ' - ' . $rec['ETO_OFR_S_PH_AREA'] . ' - ' . $rec['ETO_OFR_S_PH_NUMBER'];
                } else {
                    echo @$rec['ETO_OFR_S_PH_COUNTRY'] . ' - ' . $rec['ETO_OFR_S_PH_NUMBER'];
                }
            }
            echo '&nbsp;</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err8)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err8 . '</span>';
                } else if (!empty($err6)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err6 . '</span>';
                }
            }
            echo '</TD></TR><TR>';
            echo '<TD class="lfb">&nbsp;NA </TD><TD></TD></TR>';
            $sPhMobile = isset($rec['ETO_OFR_S_PH_MOBILE']) ? $rec['ETO_OFR_S_PH_MOBILE'] : '';
            echo '<TR><TD class="lfb">&nbsp;' . $sPhMobile . '</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err3)) {
                    echo '<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err3 . '</span>';
                }
            }
            $sUrl = isset($rec['ETO_OFR_S_URL']) ? $rec['ETO_OFR_S_URL'] : '';
            echo '</TD></TR>
			<TR><td class="lfb">&nbsp;' . $sUrl . '</TD><TD>';
            if ($postParamArr['status'] == 'W') {
                if (!empty($err9)) {
                    echo '&nbsp;<span style="letter-spacing:-0.02em; color:#c90000; font-weight:bold;font-size:14px;"><span style="color:#999999;font-size:11px;">&#9658;</span> ' . $err9 . '</span>';
                }
            }
            echo '</TD></TR>  <tr>
		<td class="lfb" style="height:43px/height:35px">&nbsp;</td><TD>';
            echo '</td></tr>
		</TABLE>
		</TD>
		</TR>
		</tbody>
		</table><br><br><br><br><br>
		';  ?>      
 </body>
 </html>               