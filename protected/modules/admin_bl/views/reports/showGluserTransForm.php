<?php 
if(isset($_COOKIE["adminiil"]))
{
	$emp_id= $_COOKIE["adminiil"];
}
else
{
$emp_id=0;
}
$obj=new GlobalEtoNew ;
$isvalid=$obj->checkEmpStatus($emp_id);
$frm=(empty($_REQUEST['nofrm']) || $_REQUEST['nofrm'] ==0) ? 0 : $_REQUEST['nofrm'];
if($isvalid!=0)
{
if($frm!=1)
{
$this->pageTitle='Transaction Report';?>
	
	<STYLE TYPE="text/css">
	.admintext {font-family:ms sans serif,verdana; font-size:9px;font-weight:bold;line-height:17px;}
	.admintext1 {font-family:ms sans serif,verdana; font-size:12px;line-height:17px;}
	.mtrbg{background: none;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='admin_eto/gifs/bg_popup.png',sizingMethod='scale'); background-image:url('admin_eto/gifs/bg_popup.png'); padding-bottom:150px;}


.alrtTxt {
    background: none repeat scroll 0 0 #FEF9EE;
    border: 3px solid #EDB153;
    height: 280px;
    margin: 0 auto;
    width: 600px;
}
.alrt-headTxt {
    color: #900000;
    font-size: 18px;
    line-height: 35px;
    margin: 0 10px;
    padding: 0 0;
    text-align: left;
	font-family: Trebuchet MS,arial;
}
.alrtBox {
    font-family: Trebuchet MS,arial;
	font-size:16px;
	color:#000000;
	font-weight:bold;
}
.ftext{font-family: arial; text-align:left; font-weight:bold; color:#000000; padding-left:4px; font-size:12px;}
.textar{ width:281px; min-height:100px; margin-top:10px;}
.fwb {
    font-weight: bold;
}
.mc2 {
    color: #CE1111;
}
.mf14 {
    font-size: 14px;
}

</STYLE>
	
	<script LANGUAGE="JavaScript" SRC="js/eto-buy-sale-report.js"></SCRIPT>
	<script LANGUAGE="JavaScript" SRC="js/eto-buy-sale-reportajax.js?v=2"></SCRIPT>
</head>
<?php
$glusrid = isset($glusrid) ? $glusrid:'';
$email = isset($email) ? $email:'';
$offer = isset($offer) ? $offer:'';
$gl_id = isset($gl_id) ? $gl_id:'';
$email1 = isset($email1) ? $email1:'';
$i=0;
$val0='';
$val1='';
$val2='';
$val3='';
$val4='';
$val5='';
if(!empty($checkbox))
{

	$all = '';
	$credit_allocation =  '';
	$weekly_offer =  '';
	$buy_lead_purchased =  '';
	$credit_lapse =  '';
	$ast_buy =  '';
//echo "chekbox****";print_r($checkbox);
foreach ( $checkbox as $val)
{
	if($val=='All')
	{
		$val0='checked';
		$val1='';
		$val2='';
		$val3='';
		$val4='';
		$val5='';
	break;
	}
	elseif($val=='Credit Alloc')
	{
		$val1='checked';
	}
	elseif($val=='BL Purchased')
	{
		$val2='checked';
	}
	elseif($val=='Credit Lapse')
	{
		$val3='checked';
	}
	elseif($val=='AST Buy')
	{
		$val4='checked';
	}

    $i++;
}



// 	foreach($checkbox as $key => $value)
// 	{
// 		echo "$key = $value \n" ;
// 	}
}
?>
<table border="1" cellpadding="0" cellspacing="1" width="100%">
<tbody>
<tr>
	<td width="51%" align="center" valign="top" class="admintext1">

<!--form 1-->		<form name="offerForm" method="post"   
			 action="" style="margin-top:0;margin-bottom:0;">
		<!--action used eto-buy-sale-report.php-->		
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			<tbody><tr>
			<td class="admintext1" width="51%" align="left" style="padding-left:5px;"><b>GLUser Wise- </b>
			<br><br>
			</td>
			</tr>
			<tr>
			<td class="admintext1" width="50%" align="center">
			<b>GLUser Id</b>
			&nbsp;<input name="glusrid" id="glusrid" type="text" value="<?php echo $glusrid?>"></td>
			<td class="admintext1" width="50%" align="center"><b>Email Id</b>
			&nbsp;<input name="email" value="<?php  echo $email?>" id="email" type="text"></td>
			</tr>
			</tbody>
			</table><br><br>
			<table border="0" cellpadding="0" cellspacing="0" height="30" width="100%">
			<tbody>
			<tr>
			<td style="font-family: arial; font-size: 14px;" align="left">
			<input type="hidden" name="action" value="transDetails">
			<input type="checkbox" value="All" name="checkbox[]" <?php echo $val0;?> >All
			<input type="checkbox" value="Credit Alloc" name="checkbox[]" <?php echo $val1;?>>Credit Alloc
			<input type="checkbox" value="BL Purchased" name="checkbox[]" <?php echo $val2;?>> BL Purchased
			<input type="checkbox" value="Credit Lapse" name="checkbox[]" <?php echo $val3;?>> Credit Lapse
			<input type="checkbox" value="AST Buy" name="checkbox[]" <?php echo $val4;?>> AST Buy
			</td>
			</tr>
			<tr>
			<td height="9"></td>
			</tr>
			<tr>
			<td style="font-family: arial; font-size: 14px;" align="CENTER"><br>
			<input name="Submit1" value="Generate Report" onClick="return checkGLUser(this.form);" type="SUBMIT"></td>
			</tr>
			<tr>
			<td style="font-family: arial; font-size: 14px;" align="CENTER">&nbsp;</td>
			</tr>
			<tr>
			<td height="70" bgcolor="#f4f4f4"></td>
			</tr>
			</tbody>
			</table>
       		 </form>
    	</td>
	<td></td>
	<td width="49%" align="center" valign="top" class="admintext1">
<!--form 2-->
		<form name="emailsearchForm" method="post" action="" style="margin-top:0;margin-bottom:0;">
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			<tbody><tr>
			<td class="admintext1" width="50%" align="left" style="padding-left:5px;"><b>Email Id Wise- </b>
			<br><br>
			</td>
			</tr>
			<tr>
			<td class="admintext1" width="50%" align="left" style="padding-left:5px;">
			<b>Email Id</b>
			&nbsp;<input name="email1" type="text" value="<?php echo $email1; ?>">
			<input name="action" value="purchasers_email" type="hidden">
			<input name="frm" value="1" type="hidden">
			&nbsp;<input name="Submit1" value="Generate Report" onClick="return checkemailid(this.form);" type="SUBMIT">
			</td>
			</tr>
			</tbody>
			</table>
		</form>
    	<br>
<!--form 3-->
    		<form name="searchForm" method="post" action="" style="margin-top:0;margin-bottom:0;">
		<!--eto-buy-sale-report.mp-->
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			<tbody>
				<tr>
				<td height="4" bgcolor="#f4f4f4"></td>
				</tr>
			<tr>
			<td class="admintext1" width="50%" align="left" style="padding-left:5px;"><b>Offer Id Wise- </b>
			<br><br>
			</td>
			</tr>
			<tr>
			<td class="admintext1" width="50%" align="left" style="padding-left:5px;">
			<b>Offer Id</b>
			&nbsp;<input name="offer" type="text" value="<?php  echo $offer?>">
			<input name="action" value="purchasers" type="hidden">
			<input name="frm" value="1" type="hidden">
			&nbsp;<input name="Submit1" value="Generate Report" onClick="return checkOffer(this.form);" type="SUBMIT">
			</td>
			</tr>
			</tbody>
			</table>
  		  </form>
   	 <br>
<!--form 4-->
    		<form name="leadPurForm" method="post" action="" style="margin-top:0;margin-bottom:0;">
		<!--eto-buy-sale-report.mp-->
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
			<tbody>
			<tr>
				<td height="4" bgcolor="#f4f4f4"></td>
				</tr>
				<tr>
			<td class="admintext1" width="50%" align="left" style="padding-left:5px;"><br>
			<b>Detailed Purchased Buy Lead Report- </b>
			<br>
			</td>
			</tr>
			<tr>
			<td width="50%" align="left" class="admintext1" style="padding-left:5px;"><br>
			<b>GLUser Id</b>
			&nbsp;<input name="gl_id" id="gl_id" type="text" value="<?php echo $gl_id ?>" size="12">&nbsp;&nbsp;<b>From</b>
			&nbsp;<select name="fromdays" id="fromdays">
			<option selected="selected" value="90">LAST 90 DAYS</option>
			<option value="all">ALL</option>
			</select>
			&nbsp;&nbsp;<input name="action" value="purdetails" type="hidden">
			&nbsp;<input name="Submit2" value="Generate Report" type="SUBMIT"></td>
			</tr>
			<tr>
			<td class="admintext1" width="50%" align="left">
			
			</td>
			</tr>
			
			</tbody>
			</table>
    		</form>

    </td>
    </tr>
    <tr>
    <td class="admintext1" colspan="2" align="center">
    </td>
    </tr>
</tbody>
</table><div><br></div>
<?php
}
//echo "gldata=".$glusr_data;
if(!empty($glusr_data) || isset($glusr_data))
{

if( $glusr_data==0)
{
	echo '<TABLE BORDER="0" WIDTH="100%"><TR>
	<TD BGCOLOR="#EAEAEA"  ALIGN="center"><FONT COLOR="#FF0000" size="2"><B>NO RECORD FOUND<BR><BR></TD></TR></TABLE>';
}
else
{
$usg_type	= !empty($usg_typ['USAGE_TYPE']) ? $usg_typ['USAGE_TYPE'] : '';
$mail_limit	= !empty($usg_typ['ETO_BL_ALERT_EMAIL_LIMIT']) ? $usg_typ['ETO_BL_ALERT_EMAIL_LIMIT'] : '';
//echo "usg_type in view".$usg_type;// =$usg_typ;


$userID		= $glusr_data['id'] ? $glusr_data['id']:'';
$email		= $glusr_data['email'] ? $glusr_data['email']:'';
$company	= $glusr_data['company_name'] ? $glusr_data['company_name'] : '';
$name 		= $glusr_data['first_name'].' '.$glusr_data['last_name'];
$address 	= $glusr_data['add1'] ? $glusr_data['add1'] :'';
$country 	= $glusr_data['country'] ? $glusr_data['country'] :'';
$city 		= $glusr_data['city'] ? $glusr_data['city'] :'';
$state 		= $glusr_data['state'] ? $glusr_data['state'] : '';
$ph_country	= $glusr_data['ph_country'] ? $glusr_data['ph_country'] :'';
$ph_area 	= $glusr_data['ph_area'] ? $glusr_data['ph_area'] :'';
$ph_no 		= $glusr_data['ph_no'] ? $glusr_data['ph_no'] :'';
$fax_country 	= $glusr_data['fax_country'] ? $glusr_data['fax_country'] :'';
$fax_area 	= $glusr_data['fax_area'] ? $glusr_data['fax_area'] :'';
$fax_no 	= $glusr_data['fax_no'] ? $glusr_data['fax_no'] :'';
$mobile 	= $glusr_data['mobile'] ? $glusr_data['mobile'] :'';
$approv 	= $glusr_data['approv'] ? $glusr_data['approv'] :'';
$phone = "(".$ph_country.")";
if($ph_area)
{
	$phone 	.="-".$ph_area; 
}
$phone 		.="-".$ph_no; 

$fax = $fax_country;
if($fax_area)
{
	$fax	.="-".$fax_area; 
}
$usg_typ_html  = ($usg_type!='') ? $usg_typ_html= '<span style="color:#ff0000">('.$usg_type.' - '.$mail_limit.' Hrs)</span>' : '';
		
		
echo '<TABLE ALIGN="center" BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%" >
	<TBODY>
 	<TR>
		<TD WIDTH="100%" VALIGN="TOP" id="id_attribute_value">
		<!--Mark Complaint Start here-->
			<DIV ALIGN="CENTER" STYLE="position:absolute; left:0px; display:none; top:0px;" class="mtrbg" ID="mc-part">
				<DIV ID="divheight13"></DIV>
				<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="CENTER" ID="tableheight13">
					<TR>
						<TD ALIGN="CENTER">
							<DIV ALIGN="LEFT" ID="resolution13">
								<div class="alrtTxt" id="cmplnt_div" style="height:260px;position:relative;"></div>
							</DIV>
						</TD>
					</TR>
				</TABLE>
			</DIV>
			<div>
			<br>
			</div>

			<TABLE BORDER="0" WIDTH="100%">
				<TR>
					<TD width="98%" align="left" STYLE="font-family:arial;font-size:13px;padding:5px;">
						<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">Complete Transaction History for Gluser: '.$userID.' '.$usg_typ_html.'
						</DIV>
						
						<TABLE STYLE="font-family:arial;font-size:13px;padding-bottom:3px;">
							<TR>
								<TD valign="top" width="50%">';
								if($company != '')
								{ 
									echo '<div><B>Company:</B> '.$company.'</div>';
								} 
									echo '<div><B>Name:</B> '. $name.'</div>';
								if($address != '')
								{
									echo '<div><B>Address:</B> '. $address.'</div>';
								
								}
								if($city != '')
								{
									echo '<div><B>City:</B> '. $city.'</div>';
								}
								if($state != '')
								{
									echo '<div><B>State:</B> '. $state.'</div>';
								}
	
									echo '<div><B>Country:</B> '. $country.'</div>
								</TD>
								<TD valign="top">
									<div><B>Telephone:</B> '. $phone.'</div>';
								if($fax_no != '')
								{
									echo '<div><B>Fax:</B> '. $fax.'</div>';
								}
								if($mobile != '')
								{
									$mobile ="(".$ph_country.") -".$mobile;
									echo '<div><B>Mobile / Cell Phone:</B>  '.$mobile.'</div>';
								}
		
								echo '<div><B>User Status:</B> '.$approv .' <a href="javascript:popup(\'/index.php?r=admin_bl/reports/userinfo&id='.$userID.' \');">More Details</a></div>
								<div><B>Email:</B> 
								<a  href="index.php?r=admin_bl/adminEto/adminContact&do=sm&mem='.$userID.'">'.$email."</a>
								</div>
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
			</TABLE>";
}
}
if(!empty($rec))
{
//echo "<br>rec-->";print_r($rec);
		$color="#E0E0E0";
		$leadcount     	= $rec[0]['LEADCOUNT'];
		$dbm_contact   	= $rec[0]['DBM_CONTACT_COUNT'];
		$amtpaid	= $rec[0]['AMOUNTPAID'];
		$crpurchse	= $rec[0]['CREDITPURCHASED'];	
		$cruse		= $rec[0]['CREDITUSED'];
		$cravail	= $rec[0]['ETO_CUST_CREDITS_AV'];
echo '<DIV><BR></DIV>
			<table style="border-collapse: collapse;" align="center" border="1" bordercolor="#ddf0ff" cellpadding="8" cellspacing="0" width="100%">
			<tr>
				
				<td colspan="4" class="admintext" height="24" valign="middle" align="right" bgcolor="#eff8ff" width="40%"><b>Summary</b></td>
				<td colspan="4" class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><UL><LI>Total Lead Purchased: '.$leadcount.'</LI><LI>Total Contact Purchased: '.$dbm_contact.'</LI></UL></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Amount Paid</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Credit Purchased</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Credit Used</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Balance</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Purchase Mode</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Mark Complaint</b></td>
			</tr>
			<tr>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="'.$color.'">Sl.No.</td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="'.$color.'">Purchased Date</td>
				<td  class="admintext" height="24" valign="middle" align="center" bgcolor="'.$color.'">Original Post Date</td>
				<td  class="admintext" height="24" valign="middle" align="center" bgcolor="'.$color.'">Offer Date</td>
				<td class="admintext" height="24" valign="middle" align="left" bgcolor="'.$color.'">Description</td>
				<td class="admintext" height="24" valign="middle" align="left" bgcolor="'.$color.'">MCAT Name (Rank)</td>
				<td class="admintext" height="24" valign="middle" align="left" bgcolor="'.$color.'">IP</td>
				<td class="admintext" height="24" valign="middle" align="left" bgcolor="'.$color.'">IP Country</td>
				<td class="admintext" height="24" valign="middle" align="left" bgcolor="'.$color.'">Rs. '.$amtpaid.'</td>
				<td class="admintext" height="24" valign="middle" align="right" bgcolor="'.$color.'">'.$crpurchse.'</td>
				<td class="admintext" height="24" valign="middle" align="right" bgcolor="'.$color.'">'.$cruse.'</td>
				<td class="admintext" height="24" valign="middle" align="right" bgcolor="'.$color.'">'.$cravail.'</td>
				<td class="admintext" height="24" valign="middle" align="right" bgcolor="'.$color.'"></td>
				<td class="admintext" height="24" valign="middle" align="right" bgcolor="'.$color.'"></td>
			</tr>
			';	
	
}
if(!empty($trans_data))
{
//echo "view trans data";print_r($trans_data);
$totalRec=count($trans_data);
for($i=$totalRec-1;$i>=0;$i--)
{
	$color='';
	$serial=$i+1;
	$flag		= $trans_data[$i]['FLAG'];
	$pur_date	= $trans_data[$i]['TDATE'];
	$post_date	=
			  $trans_data[$i]['POSTDATE_ORIG_IST'] ? $trans_data[$i]['POSTDATE_ORIG_IST'].'&nbsp(IST)' : '-';
	$offer_date	=
			  $trans_data[$i]['FK_ETO_OFR_DATE'] ? $trans_data[$i]['FK_ETO_OFR_DATE'].'&nbsp(IST)':'-';

	$desc		= $trans_data[$i]['TDETAIL'];
	$cr_pur		=
			  $trans_data[$i]['CREDITPURCHASED'] != 0 ? $trans_data[$i]['CREDITPURCHASED'] :'-';
	$color		=($flag == 1 ? "#EEF7FF" :($flag == 3 ? "#FFE0E0" : ''));
	$cr_used	= $trans_data[$i]['CREDITUSED'] == 0 ? '-' : $trans_data[$i]['CREDITUSED'];
	$amtpaid	= $trans_data[$i]['AMOUNTPAID'] != 0 ? 'Rs.'. $trans_data[$i]['AMOUNTPAID'] : '-';
	$ofrID 		= $trans_data[$i]['FK_ETO_OFR_ID'] ? $trans_data[$i]['FK_ETO_OFR_ID'] : '';	
	$mcatID 	= $trans_data[$i]['FK_GLCAT_MCAT_ID'] ? $trans_data[$i]['FK_GLCAT_MCAT_ID']: '';
	$ofrIdCmplnt='';
	$ofrIdCmplnt = $trans_data[$i]['TDETAIL'];
	$ofrIdCmplnt=preg_replace('/[\D]/', '', $ofrIdCmplnt);
	//$ofrIdCmplnt =~ s/\D//g;
	
			
			if($mcatID != -999 && $mcatID!='' && $userID != '')
			{
				$ob = new TransactionReport;
				$res=$ob->rankquery($mcatID,$userID);
				//print_r($res);
				$mcat_rank= (!empty($res))? $res[0]['ETO_TRD_ALERT_RANK'] :'NE';
			}
			elseif($ofrID != -999 && $ofrID !='' && $userID != '')
			{
				$mcat_rank = 'NM';
			}
			else
			{
				$mcat_rank = '-';
			}
			
			
			echo '<tr>
				<td class="admintext1" height="24" valign="middle" align="center" bgcolor="'.$color.'">'.$serial.'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$pur_date.'&nbsp(IST)</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$post_date.'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$offer_date.'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$desc;
				
				if($flag!=6 && $flag!=7)
				{
					if($trans_data[$i]['VERIFIED'] == 3)
					{
						echo '<FONT COLOR="RED"> (UPDATED)</FONT>';
					}
					elseif($trans_data[$i]['VERIFIED'] == 2)
					{
						echo '<FONT COLOR="RED"> (VERIFIED & UPDATED)</FONT>';
					}elseif($trans_data[$i]['VERIFIED'] == 1) 
					{
						echo '<FONT COLOR="RED"> (VERIFIED)</FONT>';
					}
				}
			echo	'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$trans_data[$i]['OFRMCATNAME'];
				if($flag!=9){ echo "(".$mcat_rank.")";}
			echo	'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$trans_data[$i]['ETO_LEAD_PUR_IP'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$trans_data[$i]['ETO_LEAD_PUR_IP_COUNTRY'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$amtpaid.'</td>
				<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'">'.$cr_pur.'</td>
				<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'">'.$cr_used.'</td>
				<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'">'.$trans_data[$i]['BALANCE'].'</td>';
				if($trans_data[$i]['PURCHASEMOD'] == 'MAIL')
				{
				echo '<td valign="middle" height="24" bgcolor="'.$color.'" align="center" class="admintext1" style="font-family:arial;font-size:12px;padding-bottom:3px;color:#000090;">'.$trans_data[$i]['PURCHASEMOD'].'</td>' ;
				}
				elseif($trans_data[$i]['PURCHASEMOD'] == 'NO')
				{
				echo '<td valign="middle" height="24" bgcolor="'.$color.'" align="center" class="admintext1" style="font-family:arial;font-size:12px;padding-bottom:3px;">--</td>' ;
				}
				else
				{
				echo '<td valign="middle" height="24" bgcolor="'.$color.'" align="center" class="admintext1"
				style="font-family:arial;font-size:12px;padding-bottom:3px;">'.$trans_data[$i]['PURCHASEMOD'].'</td>';
				}
				if($flag == 2 || $flag == 5)
				{
				echo '<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'"><a href="javascript:bhw(4);show_alert(\'mc-part\');showCmplntForm('.$userID.','.$ofrIdCmplnt.');">Mark Complaint</a></td>';
				}
				else
				{
				echo '<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'">N/A</td>';
				}
			echo '</tr>';
				
}
echo '</table></td></tr></table>';
}		
if(!empty($purchaseDetails))
{
	echo $purchaseDetails;
}
if(!empty($purchasers))
{	
	echo $purchasers;
}
if(!empty($leaddata))
{
	
	//echo "logindata";print_r($loginUserDet);
	//echo "\nleaddata";print_r($leaddata);
	if( $leaddata==1)
	{
		echo '<TABLE BORDER="0" WIDTH="100%"><TR>
		<TD BGCOLOR="#EAEAEA"  ALIGN="center"><FONT COLOR="#FF0000" size="2"><B>NO RECORD FOUND<BR><BR></TD></TR></TABLE>';
	}
	else
	{	
	//echo "logindata";print_r($loginUserDet);
	//echo "\nleaddata";print_r($leaddata);
	
		$totalRec=count($leaddata);

		$glusrid = !empty($loginUserDet['id']) ? $loginUserDet['id'] : '';
		$email = !empty($loginUserDet['email']) ? $loginUserDet['email'] : '';
		$company = !empty($loginUserDet['company_name']) ? $loginUserDet['company_name'] : '';
		$name = $loginUserDet['first_name'].' '.$loginUserDet['last_name'];
		$address = !empty($loginUserDet['add1']) ? $loginUserDet['add1'] : '';
		$country = !empty($loginUserDet['country']) ? $loginUserDet['country'] : '';
		$city = !empty($loginUserDet['city']) ? $loginUserDet['city'] : '';
		$state = !empty($loginUserDet['state']) ? $loginUserDet['state'] : '';

		$ph_country = !empty($loginUserDet['ph_country']) ? $loginUserDet['ph_country'] : '';
		$ph_area = !empty($loginUserDet['ph_area']) ? $loginUserDet['ph_area'] :'';
		$ph_no = !empty($loginUserDet['ph_no']) ? $loginUserDet['ph_no'] :'';
		$fax_country = !empty($loginUserDet['fax_country']) ? $loginUserDet['fax_country'] : '';
		$fax_area = !empty($loginUserDet['fax_area']) ? $loginUserDet['fax_area'] : '';
		$fax_no = !empty($loginUserDet['fax_no']) ? $loginUserDet['fax_no'] : '';
		$mobile = !empty($loginUserDet['mobile']) ? $loginUserDet['mobile'] : '';
		$approv = !empty($loginUserDet['approv']) ? $loginUserDet['approv'] : '';

		$phone = "(".$ph_country.")";
		if($ph_area)
		{
			$phone .='-('.$ph_area.')'; 
		}
		$phone .='-'.$ph_no; 

		$fax = '('.$fax_country.')';
		if($fax_area)
		{
			$fax .='-('.$fax_area.')'; 
		}
		$fax .='-'.$fax_no;

		echo '<STYLE TYPE="text/css">
			.mtrbg{background:none;
			filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\'admin_eto/gifs/bg_popup.png\',sizingMethod=\'scale\');
			 background-image:url(\'admin_eto/gifs/bg_popup.png\'); 
			padding-bottom:150px;}
		      </STYLE>
<TABLE ALIGN="center" BORDER="0" CELLPADDING="0" CELLSPACING="0" WIDTH="100%" >
<TBODY>
<TR>
<TD WIDTH="100%" VALIGN="TOP" id="id_attribute_value">
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
			</DIV>
		</TD>
		</TR>
		</TABLE>
	</DIV>
		<!-- Mark Complaint end here -->
	<DIV><br></div>
	<TABLE BORDER="0" WIDTH="100%">
	<TR>
	<TD width="98%" align="left" STYLE="font-family:arial;font-size:13px;padding:5px;">
		<DIV STYLE="font-family:arial;font-size:14px;font-weight:bold;padding-bottom:3px;color:006FB6;">
			Complete Transaction History for Gluser: '.$glusrid.
		'</DIV>
		<TABLE STYLE="font-family:arial;font-size:13px;padding-bottom:3px;"><TR><TD valign="top" width="50%">';
		
		if($company)
		{
			echo '<div><B>Company:</B> '.$company.'</div>';
		}
			echo '<div><B>Name:</B> '.$name.'</div>';
		if($address)
		{
			echo '<div><B>Address:</B> '.$address.'</div>';
		}

		if($city)
		{
			echo '<div><B>City:</B> '.$city.'</div>';
		}
		if($state)
		{
			echo '<div><B>State:</B> '.$state.'</div>';
		}
		
		echo '<div><B>Country:</B> '.$country.'</div>';
		echo '</TD><TD valign="top">
		<div><B>Telephone:</B> '.$phone.'</div>';

		if($fax_no)
		{
			echo '<div><B>Fax:</B> $fax</div>';
		}

		if($mobile)
		{
			$mobile ='($ph_country)-$mobile';
			echo '<div><B>Mobile / Cell Phone:</B> $mobile</div>';
		}
		echo '</TD></TR></TABLE></td><tr></table>
		<DIV><BR></DIV>
			<table style="border-collapse: collapse;" align="center" border="1" bordercolor="#ddf0ff" cellpadding="2" cellspacing="0" width="99%" style="font-size:11px">
			<tr>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>S. No.</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Pur Date</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Offer Id</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Verify</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Verification Mode</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Mod Id</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Post Date</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Title</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Description</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>MCAT Name</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Credits Used</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Buyer Id</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Buyer\'s Name</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>City</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Country</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Address</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Phone</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Mobile</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Email</b></td>
				<td class="admintext" height="24" valign="middle" align="center" bgcolor="#eff8ff"><b>Mark Complaint</b></td>
			</tr>';
		$rec='';
		$color='';
		$serial=0;
		$trans_data="";
		for($i=$totalRec-1;$i>=0;$i--)
		{
			$color='';
			$serial=$i+1;
			$rec = $leaddata[$i];
			$ofrIdCmplnt = $rec['OFFERID'];
			$found = '';
			$leadoffer=new TransactionReport;
			$offer=$leadoffer->offerdetails($ofrIdCmplnt);
			//echo "\n".$i."array value";print_r($offer);//exit;
			//echo $offer;
			
			//echo "array of arry";print_r($offer['0']);
		//var_dump($offer);

		if($rec['ETO_LEAD_PUR_MODE'] == 'MAIL')
		{
			$trans_data .= '
			<tr>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="center" bgcolor="'.$color.'">'.$serial.'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['PURCHASEDATE'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFFERID'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">';
			if($rec['ETO_OFR_VERIFIED'] == 3) {
				$trans_data .= 'Updated';
			}
			elseif($rec['ETO_OFR_VERIFIED'] == 2) {
				$trans_data .= 'Verified & Updated';
			}elseif($rec['ETO_OFR_VERIFIED'] == 1){
				$trans_data .= 'Verified';
			}else{
				$trans_data .= '&nbsp;';
			}
			$trans_data .= '</td><td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">';
// 
			if( !empty($offer) && ($offer[0]['ETO_OFR_CALL_VERIFIED'] == 2 && $offer[0]['ETO_OFR_ONLINE_VERIFIED'] == 2))
			{
				$found='[ UPDATED & CALL VERIFIED ] ';
				$trans_data .= $found;
			}
			elseif(!empty($offer) && $offer[0]['ETO_OFR_CALL_VERIFIED'] == 1)
			{
				$found='[ CALL VERIFIED ] ';
				$trans_data .= $found;
			} elseif(!empty($offer) &&  $offer[0]['ETO_OFR_CALL_VERIFIED'] == 2)
			{
				$found='[ CALL VERIFIED & UPDATED ] ';
				$trans_data .= $found;
			} 
		
			if(!empty($offer) &&  $offer[0]['ETO_OFR_EMAIL_VERIFIED'] == 1)
			{
				$found='[ EMAIL VERIFIED ] ';
				$trans_data .= $found;
			} elseif(!empty($offer) && $offer[0]['ETO_OFR_EMAIL_VERIFIED'] == 2)
			{
				$found='[ EMAIL VERIFIED & UPDATED ] ';
				$trans_data .= $found;
			}
		
			if(!empty($offer) && ($offer[0]['ETO_OFR_ONLINE_VERIFIED'] == 2 || $offer[0]['ETO_OFR_CALL_VERIFIED'] == 3))
			{
				$found='[ UPDATED ] ';
				$trans_data .= $found;
			}
			$trans_data .= '</td><td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['MODULEID'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRDATE'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRTITLE'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRDESC'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRMCATNAME'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['CREDITSUSED'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['BUYERID'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['BUYERNAME'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['CITY'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['COUNTRY'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['ADDRESS'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="right" bgcolor="'.$color.'">'.$rec['PHONE'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['MOBILE'].'</td>
				<td class="admintext1" height="24" style="color:#000090;" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['EMAIL'].'</td>
				<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'">';
//  				
 				$datediff=!empty($rec['DATEDIFF']) ? $rec['DATEDIFF'] : '';
				if($datediff>7)
				{
					if($rec['FLAG']!=4)
					{
					$trans_data .= '<a
							href="javascript:bhw(4);show_alert(\'mc-part\');showCmplntForm('.$glusrid.','.$ofrIdCmplnt.');" style="color:red">Mark Complaint</a>';
					}
				}
				else
				{
					if($rec['FLAG']!=4)
					{
						$trans_data .= '<a href="javascript:bhw(4);show_alert(\'mc-part\');showCmplntForm('.$glusrid.','.$ofrIdCmplnt.');">Mark Complaint</a>';
					}
				}
				$trans_data .= '</td>
			</tr>';
 		}
		else
		{
			$trans_data .= '
			<tr>
				<td class="admintext1" height="24" valign="middle" align="center" bgcolor="'.$color.'">'.$serial.'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['PURCHASEDATE'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFFERID'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">';
			if($rec['ETO_OFR_VERIFIED'] == 3) {
				$trans_data .= 'Updated';
			}
			elseif($rec['ETO_OFR_VERIFIED'] == 2) {
				$trans_data .= 'Verified & Updated';
			}elseif($rec['ETO_OFR_VERIFIED'] == 1){
				$trans_data .= 'Verified';
			}else{
				$trans_data .= '&nbsp;';
			}
			$trans_data .= '</td><td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">';
			if(!empty($offer) && ($offer[0]['ETO_OFR_CALL_VERIFIED'] == 2 && $offer[0]['ETO_OFR_ONLINE_VERIFIED'] == 2))
			{
				$found='[ UPDATED & CALL VERIFIED ] ';
				$trans_data .= $found;
			}
			elseif(!empty($offer) && $offer[0]['ETO_OFR_CALL_VERIFIED'] == 1)
			{
				$found='[ CALL VERIFIED ] ';
				$trans_data .= $found;
			} elseif(!empty($offer) && $offer[0]['ETO_OFR_CALL_VERIFIED'] == 2)
			{
				$found='[ CALL VERIFIED & UPDATED ] ';
				$trans_data .= $found;
			} 
		
			if(!empty($offer) && $offer[0]['ETO_OFR_EMAIL_VERIFIED'] == 1)
			{
				$found='[ EMAIL VERIFIED ] ';
				$trans_data .= $found;
			} elseif(!empty($offer) && $offer[0]['ETO_OFR_EMAIL_VERIFIED'] == 2)
			{
				$found='[ EMAIL VERIFIED & UPDATED ] ';
				$trans_data .= $found;
			}
		
			if(!empty($offer) && $offer[0]['ETO_OFR_ONLINE_VERIFIED'] == 2)
			{
				$found='[ UPDATED ] ';
				$trans_data .= $found;
			}
			$trans_data .= '</td><td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['MODULEID'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRDATE'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRTITLE'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRDESC'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['OFRMCATNAME'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['CREDITSUSED'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['BUYERID'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['BUYERNAME'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['CITY'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['COUNTRY'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['ADDRESS'].'</td>
				<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'">'.$rec['PHONE'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['MOBILE'].'</td>
				<td class="admintext1" height="24" valign="middle" align="left" bgcolor="'.$color.'">'.$rec['EMAIL'].'</td>
				<td class="admintext1" height="24" valign="middle" align="right" bgcolor="'.$color.'">';

				$datediff=!empty($rec['DATEDIFF']) ? $rec['DATEDIFF'] : '';
				if($datediff>7)
				{
					if($rec['FLAG']!=4)
					{
						$trans_data .= '<a
						href="javascript:bhw(4);show_alert(\'mc-part\');showCmplntForm('.$glusrid.','.$ofrIdCmplnt.');" style="color:red">Mark Complaint</a>';
					}
				}
				else
				{
					if($rec['FLAG']!=4)
					{
						$trans_data .= '<a href="javascript:bhw(4);show_alert(\'mc-part\');showCmplntForm('.$glusrid.','.$ofrIdCmplnt.');">Mark Complaint</a>';
					}
				}
			
		}
			$trans_data .= '</td>
			</tr>';
 		}

			echo $trans_data.'
			</table>';
		}
	
}
}
else
{
echo "Your are not logged in<BR> Click here to <A HREF=\"index.php?r=site/login\" target=\"_top\">login</A><BR>";
}
?>
