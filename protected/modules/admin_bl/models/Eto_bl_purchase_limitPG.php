<?php
class Eto_bl_purchase_limitPG extends CFormModel
{
	public function showDailyLimitPurchaseForm($file,$line,$dbh,$err_msg,$dbh_r,$user_view,$user_edit)
	{
	$utilsHost   = isset($_SERVER['UTILS_URL']) && $_SERVER['UTILS_URL'] !='' ? $_SERVER['UTILS_URL'] : '';
	$purchase_details=isset($_REQUEST['action']) ? $_REQUEST['action']: '';
	$email=isset($_REQUEST['email']) ? $_REQUEST['email']: '';
	$mobileno=isset($_REQUEST['mobileno']) ? $_REQUEST['mobileno'] : '';
	$gluserID=isset($_REQUEST['gluserid']) ? $_REQUEST['gluserid'] : '';
	$comp=isset($_REQUEST['comp']) ? $_REQUEST['comp'] : '';
        $obj = new Globalconnection();
        $model = new GlobalmodelForm();
        $servModel = new ServiceGlobalModelForm();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }                                
        echo '<HTML>
		<HEAD>';

echo <<<msg
		<link href="/css/report.css" rel="stylesheet" type="text/css">
		<script language="JavaScript" src="../protected/js/eto-buy-sale-report.js"></script>

		<style>
		.trd{position:fixed;top:0px;width:1300px;}
		.highlighted{background-color: #FFDEDB;}
		.intd{text-align:center;word-wrap:break-word;padding:4px 0px 4px 0px;}
		</style>

		<style TYPE="text/css">.admintext {font-family:arial,ms sans serif,verdana; font-size:11px;font-weight:bold;}
	.admintext1 {font-family:arial,ms sans serif,verdana; font-size:12px;}
	.admintlt {font-family:ms sans serif,verdana; size:12px; color:800000; font-weight:bold;}</STYLE>

		<script LANGUAGE="JavaScript">

		

		function search_comp(MyForm)
		{
			if(MyForm.comp.value == '')
			{
				alert("Please enter Company Name");
				MyForm.comp.focus();
				return false;
			}
			else
			{
				newwindow = window.open('eto-pbl-comp-srch1.mp?selectedtext='+ MyForm.comp.value, 'Lookupselect','toolbar=no,location=no,directories=no,status=no,scrollbars=yes,resizable=yes,copyhistory=no,width=500,height=500');
				newwindow.focus();
			}
			return true;
		}
		function checkform(form)
		{
		if(document.searchForm.limit_new.value  == '-1' || document.searchForm.limit_new.value  == null || document.searchForm.limit_new.value == 'Select Limit')
		{
			alert("Please Select Limit");
			document.searchForm.limit_new.focus();
			return false;
		}	
		if(document.searchForm.limit_new.value  != '' && document.searchForm.limit_reason.value == '')
		{
			alert("Please Enter The Reason");
                        document.searchForm.limit_reason.focus();
                        return false;
		}
		if(document.searchForm.comment.value  == '' || document.searchForm.comment.value == null || !isNaN(document.searchForm.comment.value) || document.searchForm.comment.value == ' ' )
		{
			alert("Please Enter Some Comments");
			document.searchForm.comment.focus();
			return false;
		
		}
		
		
		}

function trimSpace()
{

if(isNaN(document.getElementById('gluserid').value))
		{
			alert("Please enter valid GLUSER ID")
			document.getElementById('gluserid').focus();
			return false;
		}
document.validate_user.gluserid.value = document.validate_user.gluserid.value.trim();
document.validate_user.email.value = document.validate_user.email.value.trim();
}
	function ajaxFunction()
	{
		var xmlHttp;
		try
		{	// Firefox, Opera 8.0+, Safari
			xmlHttp=new XMLHttpRequest();
		}
		catch (e){// Internet Explorer
			try
			{
				xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e)
			{
				try
				{
					xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e)
				{
					alert("Your browser does not support AJAX!");
					return false;
				}
			}
		}
		return xmlHttp;
	}

	//-->
	</SCRIPT>
	<script>
		window.onload = function() {
			document.getElementById("popup").onclick = function(){
				
	        		return !window.open(this.href, "pop", "width=600,height=600,titlebar=0,menubar=0,status=0,toolbar=0,location=no");
	    		}

                       
			document.getElementById("product_popup").onclick = function(){
				
	        		return !window.open(this.href, "pop", "width=600,height=600,titlebar=0,menubar=0,status=0,toolbar=0,location=no");
	    		}

                        document.getElementById("loc_popup").onclick = function(){
				
	        		return !window.open(this.href, "pop", "width=600,height=600,titlebar=0,menubar=0,status=0,toolbar=0,location=no");
	    		}

                        
			 document.getElementById("ts_popup").onclick = function(){

                                return !window.open(this.href, "pop", "width=600,height=600,scrollbars=1,titlebar=0,menubar=0,status=0,toolbar=0,location=no");
                        }

		}
        
       
        
		function clearOther(){

			document.getElementById('mobileno').value='';
		}
	</script>
		</HEAD>
		<body>
		<div id="showform1" style="width:100%; margin:0px auto;">
			<form name="validate_user"  method="post" style="margin-top:0;margin-bottom:0;" onsubmit="return trimSpace(this.Form);">
			<script language="javascript" type="text/javascript" src="'.$utilsHost.'/js/jquery.min.js"></script> 
			<script type="text/javascript" src="../protected/js/eto.js?v=1"></script> 
				<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="100%">
					<tbody>
						<tr><td colspan="4" align="center" bgcolor="#dff8ff"><font color=" #333399"><b>Purchase Limit</b></font></span></span></td></tr>
						<tr>
						<td width="25%">Gluser ID &nbsp;&nbsp;<input type="text" value="$gluserID" name="gluserid" id="gluserid" onFocus="clearOther();"></td><td width="25%">E-mail &nbsp;&nbsp;<input type="text" value="$email" name="email" id="email" autocomplete="off" size="30" onFocus="clearOther();"></td><td width="25%">Mobile No. &nbsp; <INPUT TYPE="RADIO" NAME="ph_country" VALUE="IN" checked>India&nbsp;&nbsp;<INPUT TYPE="RADIO" NAME="ph_country" VALUE="FR">Foreign&nbsp;<input type="text" value="$mobileno" name="mobileno" id="mobileno" autocomplete="off" size="20"></td><td width="25%"><input type="submit" align="middle" value="Go"></td>
						</tr>
					</tbody>
				</table>
				<input type="hidden" name="action" value="detail">
			</form>
		</div>
msg;
	if($purchase_details == 'detail')
	{
		 $scheme = '';
		if(isset($_REQUEST['scheme']))
		{
			$scheme = $_REQUEST['scheme'];
		}
		else
		{
			$scheme = -999;
		}
		 $cust_details_row =$sqlcond= '';
                 $total_no_cnt=0;
		if($email != '' || $gluserID != '' || $mobileno != '' )
		{
			if($gluserID)
			{
			         $gluserID=preg_replace('/^\s+|\s+$/','',$gluserID);				                              
                                $cust_details_row=$this->getGLDetail('',$gluserID,'','');
			}else if($email)
			{
				$email=preg_replace('/^\s+|\s+$/','',$email);
				$cust_details_row=$this->getGLDetail($email,0,'','');
				
				$gluserID= isset($cust_details_row['glusr_usr_id']) ? $cust_details_row['glusr_usr_id'] : '';
				$_REQUEST['gluserid']=$gluserID;
			}else if($mobileno != ''){
                            $ph_country = isset($_REQUEST['ph_country'])? $_REQUEST['ph_country'] :'';
                            $cust_details_row=$this->getGLDetail('',0,$mobileno,$ph_country);
                            $gluserID= isset($cust_details_row['glusr_usr_id']) ? $cust_details_row['glusr_usr_id'] : '';
                        }	
		}
		if($cust_details_row != '' && isset($cust_details_row['glusr_usr_id']) && $cust_details_row['glusr_usr_id'] != '')
		{
			 $sth = '';
                        $lastname= isset($cust_details_row['glusr_usr_lastname'])?$cust_details_row['glusr_usr_lastname']:'';                              
			$name=isset($cust_details_row['glusr_usr_firstname']) ? $cust_details_row['glusr_usr_firstname']:' '.' '. $lastname;
			$company=isset($cust_details_row['glusr_usr_companyname']) ? $cust_details_row['glusr_usr_companyname']:'';
			$eml=isset($cust_details_row['glusr_usr_email']) ? $cust_details_row['glusr_usr_email']:'';
			$country=isset($cust_details_row['fk_gl_country_iso']) ? $cust_details_row['fk_gl_country_iso']:'';
			$state=isset($cust_details_row['glusr_usr_state']) ? $cust_details_row['glusr_usr_state']:'';
			$zip=isset($cust_details_row['glusr_usr_zip']) ? $cust_details_row['glusr_usr_zip']:'';
			$city=isset($cust_details_row['glusr_usr_city']) ? $cust_details_row['glusr_usr_city']:'';
			$phone='';
			
                        if(isset($cust_details_row['glusr_usr_ph_number'])){
			$phone='('.$cust_details_row['glusr_usr_ph_country'].') - '.$cust_details_row['glusr_usr_ph_number'];
                        }                        
			$street=isset($cust_details_row['glusr_usr_add1']) ? $cust_details_row['glusr_usr_add1'] :'';
			
			if(isset($cust_details_row['glusr_usr_add2']))
			{
			$street.=','.$cust_details_row['glusr_usr_add2'];
			}
			
			$emp_id = $_REQUEST['emp_id'];
			
			if($user_edit ==1)
			{
				echo <<<msg
					<div style="float:right;"><font size="-1" face="arial" color="#800000" class="admintlt">
                                       <a target="_blank" href="http://my.indiamart.com/login/adminlogin/emp_login/glusr_id/$gluserID?redirect=http://my.indiamart.com/blproduct/productpref" id="product_popup" target="_blank">Product Preferences </a> &nbsp;  &nbsp;  &nbsp;
&nbsp;  &nbsp;  &nbsp;
                                       
                                       <a href="http://trustseal.indiamart.com/members/$gluserID?hdr=no" id="ts_popup">Registration Info.</a> &nbsp;  &nbsp;  &nbsp;<a href="/verificationLinks.html" id="popup">Verification Links</a> &nbsp;  &nbsp;  &nbsp;<a target="_blank" href="index.php?r=admin_bl/Transaction_report/Index&action=transDetails&glusrid=$gluserID&email=$email&mid=3457">Transaction Report</a></font></div><br/>
					<FORM name="searchForm" action="index.php?r=admin_bl/Eto_bl_pur_limit/Index&mid=3457" method="post"><input type="hidden" name="action" value="purchase">
					<input type="hidden" name="name" value="$name">
					<input type="hidden" name="email" value="$email">
					<input type="hidden" name="gluserid" value="$gluserID">
					<input type="hidden" name="company" value="$company">
					<input type="hidden" name="eml" value="$eml">
					<input type="hidden" name="country" value="$country">
					<input type="hidden" name="state" value="$state">
					<input type="hidden" name="zip" value="$zip">
					<input type="hidden" name="city" value="$city">
					<input type="hidden" name="phone" value="$phone">
					<input type="hidden" name="street" value="$street">				
msg;

				$workorder = isset($_REQUEST['workorder']) ? $_REQUEST['workorder'] : '';
				$purchasedate = isset($_REQUEST['startdate']) ? $_REQUEST['startdate'] : '';
				$rate = isset($_REQUEST['rate']) ? $_REQUEST['rate'] : '';
				$credit_purchase = isset($_REQUEST['credit_purchase']) ? $_REQUEST['credit_purchase']:'';
				$list_price = isset($_REQUEST['list_price']) ? $_REQUEST['list_price'] : '';
				$discount =isset($_REQUEST['discount']) ? $_REQUEST['discount'] : '';
				$total_amount =isset($_REQUEST['total_amount']) ? $_REQUEST['total_amount'] : '';
				$service_tax = isset($_REQUEST['service_tax']) ? $_REQUEST['service_tax']  : '';
				$actual_amount = isset($_REQUEST['actual_amount']) ? $_REQUEST['actual_amount'] : '';
#				my $gluserID=$q->param('gluserid');
				
				$sql_ip= "select * from (select ETO_BL_PUR_CLIENT_IP,ETO_BL_PUR_IP_COUNTRY,ETO_BL_PUR_IP_CITY from eto_bl_pur_limit_pend where FK_GLUSR_USR_ID= :GLUSRID order by ETO_BL_PUR_DATE DESC) A limit 1";
				$rec_ip=array();
                                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql_ip, array(':GLUSRID'=>$gluserID));//echo $sql;        
                                while($rec_ip = $sth->read()) {
                                         $rec_ip=array_change_key_case($rec_ip, CASE_UPPER);                     
                                } 
                                 
				$emp_ip=isset($rec_ip['ETO_BL_PUR_CLIENT_IP'])? $rec_ip['ETO_BL_PUR_CLIENT_IP'] : '-';
			        $emp_ip_country=isset($rec_ip['ETO_BL_PUR_IP_COUNTRY'])? $rec_ip['ETO_BL_PUR_IP_COUNTRY'] : '-';
				$emp_ip_city=isset($rec_ip['ETO_BL_PUR_IP_CITY'])? $rec_ip['ETO_BL_PUR_IP_CITY'] : '-';
				$emp_name=isset(Yii::app()->session['empname']) ? Yii::app()->session['empname'] : '';				
				$usertype='BL Only';
                                $GLUSR_USR_CUSTTYPE_ID=isset($cust_details_row['glusr_usr_custtype_id']) ? $cust_details_row['glusr_usr_custtype_id'] : 0;
                                $IS_CATALOG=isset($cust_details_row['is_catalog']) ? $cust_details_row['is_catalog'] : 0;                                 
                                 
				if($IS_CATALOG == -1){
					$usertype="IMA";
				}
				elseif($GLUSR_USR_CUSTTYPE_ID==7){
					$usertype="Defaulter";	
				}				
				$address=  $street;
				if( $city != '') {$address.=" ".$city;}
				if( $zip != '') {$address.=" ".$zip;}
				if( $state != '') {$address.=" ".$state;}
				if( $country != '') {$address.=" ".$country;}
                                
                                $bl_purchase_count=0;
                                
                                if($gluserID>0){
                                    if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net' || $_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
                                        {
                                          $url="http://stg-mapi.indiamart.com/wservce/users/credit/";
                                        }else
                                        {
                                           $url="http://mapi.indiamart.com/wservce/users/credit/";
                                        }
                                       $content = array(
                                            'token' =>'imobile@15061981',
                                            'modid' =>'GLADMIN',
                                            'glusrid' => $gluserID
                                            );
                                            $data_string = http_build_query($content);                                            
                                            $eto_cust_credits_av_arr = $servModel->mapiService('CREDIT',$url,$data_string,'No');                                  
                                    if(isset($eto_cust_credits_av_arr['RESPONSE'])){
                                        $eto_cust_credits=isset($eto_cust_credits_av_arr['RESPONSE']['DATA1'])?$eto_cust_credits_av_arr['RESPONSE']['DATA1']:'';
                                        $bl_purchase_count=isset($eto_cust_credits['bl_purchase_count'])?$eto_cust_credits['bl_purchase_count']:'';
                                    }
                                }
                                $paidshowroom_url=$glusr_eto_cust_credits_total='';
                                if(isset($cust_details_row['paidshowroom_url'])){
                                    $paidshowroom_url=$cust_details_row['paidshowroom_url'];
                                }
                                if(isset($cust_details_row['glusr_eto_cust_credits_total'])){
                                    $glusr_eto_cust_credits_total=$cust_details_row['glusr_eto_cust_credits_total'];
								}
								
				$cust_details_row['glusr_usr_ph_mobile']=isset($cust_details_row['glusr_usr_ph_mobile'])?$cust_details_row['glusr_usr_ph_mobile']:'';
				echo '<html>
				          <head>				          
					<style type=\'text/css\'>
					table.wrapWord td {
						word-wrap:break-word;
						word-break:break-all;
					}
				</style>
					<span style="font-size:11px;">
					<table width=\'100%\' style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0">
					<tr>
					<td valign="top">
					<table style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0" class="wrapWord" width="60%">
					<tr height="20px">
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left" CLASS="admintext" width="17%">Name / GLID: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width=" ">'.$name.' / '.$cust_details_row['glusr_usr_id'].'<font color="green"> ('.$cust_details_row['glusr_usr_approv'].')</font></td>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Credits Allocated: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%">'.$glusr_eto_cust_credits_total.'</td>
					</tr>
					<tr height="20px">
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Email: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width=" ">'.$eml.'</td>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Available BL: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%">'.$bl_purchase_count.'</td>
					</tr>
					<tr height="20px">
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Company Name: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width=" ">'.$company.'</td>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Member Since: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%">'.$cust_details_row['glusr_usr_membersince'].'</td>
					</tr>
					<tr height="20px">
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">City / Country: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width=" ">'.$city.' / '.$cust_details_row['glusr_usr_countryname'].'</td>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Paid URL: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%"><a href="'.$paidshowroom_url.'" target="_blank">'.$paidshowroom_url.'</td>
					</tr>
					<tr height="20px">
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="18%">Mobile / Telephone: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width=" ">'.$cust_details_row['glusr_usr_ph_mobile'];

				if(isset($cust_details_row['glusr_usr_ph_mobile_alt']) && $cust_details_row['glusr_usr_ph_mobile_alt'] != '')
				{
				echo ', '.$cust_details_row['glusr_usr_ph_mobile_alt'];
				}
				if($phone != '')
				{
				echo '<br>'.$phone;
				}
				
                                $freeshowroom_url='';
                                if(isset($cust_details_row['freeshowroom_url']) && $cust_details_row['freeshowroom_url'] != '')
				{
				$freeshowroom_url=$cust_details_row['freeshowroom_url'];
				}
                                $glusr_usr_url='';
                                if(isset($cust_details_row['glusr_usr_url'])){
                                    $glusr_usr_url=$cust_details_row['glusr_usr_url'];
                                }
				echo ' </td>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Free URL: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%"><a href="'.$freeshowroom_url.'" target="_blank">'.$freeshowroom_url.'</a></td>
					</tr>
					<tr height="20px">
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Cust Type Name: </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width=" ">';
					if(isset($cust_details_row['glusr_usr_custtype_name']))
					{
					 echo $cust_details_row['glusr_usr_custtype_name'];
					 }

					echo '&nbsp; &nbsp; &nbsp;<font color="red">('.$usertype.')</font></td>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Website:</td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%"><a href="'.$glusr_usr_url.'" target="_blank">'.$glusr_usr_url.'</td>
					</tr>
					<tr height="20px">
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">Address : </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%">'.$address.'</td>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left"   CLASS="admintext" width="17%">IP / City / Country : </td>
					<td SIZE="-2" FACE="verdana,arial" BGCOLOR="#F0F9FF" VALIGN="top" align="left"   CLASS="admintext1" width="30%">'.$emp_ip.' / '.$emp_ip_city.' / '.$emp_ip_country.'</td>
					</tr>

					</table>
					</td>
                                       
					<div style="float: right;margin-right:20%;margin-top: 8px;">
                                        <b style="font-size:14px;">&nbsp;Lead Purchased&nbsp; </b>
					<input type="button" name="lead" id="lead" value="Show" onclick="leadpurchased('.$gluserID.');">&nbsp;&nbsp;&nbsp;&nbsp;                                       
                                        </div>
                                        <div id="tddiv">
					<td width="38%" valign="top">
                                        <div id="leadspan"></div>
                                        <div id="frauddiv"></div>
					</td> 
                                        </div>
					</tr></table>
					</span>
';

				if(isset($_REQUEST['email']))
				{
					$gluserID=isset($cust_details_row['glusr_usr_id'])?$cust_details_row['glusr_usr_id']:'';
					if($gluserID==''){
						$emailtmp = $_REQUEST['email'];
						echo"<b>GLuser Id does not exist for email '.$_emailtmp.'.</b>";
						exit();
					} 
					

				}
				else
				{
				        $gluserID=$gluserID;
				}
				$glid=isset($_REQUEST['glid']) ? $_REQUEST['glid'] : '';
				 $limit = '';
				 $limit_reason= '';
				 $last_updated_on = '';
				 $last_comment = '';
				 $limit_new = isset($_REQUEST['limit_new']) ? $_REQUEST['limit_new'] : '';				
                                $comment = isset($_REQUEST['comment']) ? $_REQUEST['comment'] : '';			
				if((isset($_REQUEST['SetLimit'])) && $_REQUEST['SetLimit'] == 'Set Purchase Limit')
				{	
				
					if($glid)
					{       
                                                $limit_reason1=$_REQUEST['limit_reason']; 
						if($limit_reason1 == " ")
						{
						$_REQUEST['limit_reason']="NULL";
						}
						else
						{
						$_REQUEST['limit_reason']=$_REQUEST['limit_reason'];
						}

						$content=array();
						$content['token']='imobile1@15061981';
						$content['modid']='GLADMIN';
						$content['glusrid']=$gluserID;
					//  $content['glusrid']=334904;		
						$content['weekly']=$limit_new;
						$content['last_upd_by']=$emp_id;
						$content['last_comment']=$comment;
						$content['updatescreen']='Purchase Limit';
						$content['reason'] = $_REQUEST['limit_reason'];
						$content['action']='Update';

						$host_name = $_SERVER['SERVER_NAME'];
						if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') 
						{
							$url = 'http://stg-leads.imutils.com/wservce/leads/SetPurchaseLimit/';
						} 
						else 
						{
							$url = 'http://leads.imutils.com/wservce/leads/SetPurchaseLimit/';
						}
						$dataHash = $servModel->mapiService('BLPURCHASELIMIT', $url, $content, 'No');

						if ($dataHash['Response']['Code'] == 200)
						{
							$content1=array();
							$content1['token']='imobile1@15061981';
							$content1['modid']='GLADMIN';
							$content1['glusrid']= $gluserID;
							$content1['action']='Update';
							$host_name = $_SERVER['SERVER_NAME'];
							if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') 
							{
								$url = 'http://stg-leads.imutils.com/wservce/leads/PurchaseLimitReached/';
							} 
							else 
							{
								$url = 'http://leads.imutils.com/wservce/leads/PurchaseLimitReached/';
							}

							$dataHash1 = $servModel->mapiService('BLPURCHASELIMIT', $url, $content1, 'No');	
							if($dataHash1['Response']['Code'] == 200)
							{                                                            
								echo '<div style="padding:6px 8px;color:red;font-weight:bold;font-size:16px;font-family:arial;text-align:center;">Updated Successfully</div>';
							}
							else
							{
								// echo '<div style="padding:6px 8px;color:red;font-weight:bold;font-size:16px;font-family:arial;text-align:center;">Errorr in Updation: '.$dataHash1['Response']['Message'].'</div>';
							}
						}
						else
						{
							echo '<div style="padding:6px 8px;color:red;font-weight:bold;font-size:16px;font-family:arial;text-align:center;">Error in Updation: '.$dataHash['Response']['Message'].'</div>';
						}                  
                                        }else
					{	
						if(isset($_REQUEST['email']))
						{
							$gluserID=isset($cust_details_row['glusr_usr_id'])?$cust_details_row['glusr_usr_id']:''; 
						}
						else
						{
						        $gluserID=$gluserID;
						}

						$content=array();
						$content['token']='imobile1@15061981';
						$content['modid']='GLADMIN';
						$content['glusrid']=$gluserID;		
						$content['weekly']=$limit_new;
						$content['last_upd_by']=$emp_id;
						$content['last_comment']=$comment;
						$content['updatescreen']='Purchase Limit';
						$content['reason']=$_REQUEST['limit_reason'];
						$content['action']='Insert';
						$host_name = $_SERVER['SERVER_NAME'];
						if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') 
						{
							$url = 'http://stg-leads.imutils.com/wservce/leads/SetPurchaseLimit/';
						} 
						else 
						{
							$url = 'http://leads.imutils.com/wservce/leads/SetPurchaseLimit/';
						}

						$dataHash = $servModel->mapiService('BLPURCHASELIMIT', $url, $content, 'No');
						if($dataHash['Response']['Code'] == 200){
							
							$content1=array();
							$content1['token']='imobile1@15061981';
							$content1['modid']='GLADMIN';							
							$content1['glusrid']=$gluserID;	
							$content1['action']='Update';	
							$host_name = $_SERVER['SERVER_NAME'];
							if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') 
							{
								$url = 'http://dev-leads.imutils.com/wservce/leads/PurchaseLimitReached/';
							} 
							else 
							{
								$url = 'http://leads.imutils.com/wservce/leads/PurchaseLimitReached/';
							}

							$dataHash1 = $servModel->mapiService('BLPURCHASELIMIT', $url, $content1, 'No');
							if($dataHash1['Response']['Code'] == 200){                                                        
							echo '<div style="padding:6px 8px;color:red;font-weight:bold;font-size:16px;font-family:arial;text-align:center;">Inserted Successfully</div>';
							}else{
								echo '<div style="padding:6px 8px;color:red;font-weight:bold;font-size:16px;font-family:arial;text-align:center;">Error in Updation: '.$dataHash1['Response']['Message'].'</div>';
							}
						}else{
							echo '<div style="padding:6px 8px;color:red;font-weight:bold;font-size:16px;font-family:arial;text-align:center;">Error in Insertion: '.$dataHash['Response']['Message'].'</div>';
						}
					}
					if($_REQUEST['limit_reason']==3)
					{
                				list($start_Time, $stHour, $cur_date)=$this->get_time();
                                                $cur_date=$this->rc4_encryption($cur_date);
                                                 $cur_date=base64_encode($cur_date);
						$encry_email=$this->rc4_encryption($eml);
						 $encry_email=base64_encode($encry_email);
                                                
                                                $url_bl='http://my.indiamart.com/login/autologin?em='.$encry_email.'&dt='.$cur_date.'&av=true&mt=0&redirect=http://seller.indiamart.com/bltxn/latestbl?modid=MY';
                                                $url_tdr='http://my.indiamart.com/login/autologin?em='.$encry_email.'&dt='.$cur_date.'&av=true&mt=0&redirect=http://seller.indiamart.com/tenders/tender';
					        $to = $eml;
						$from= 'buyleads@indiamart.com';
						$subject ='Buy Lead Purchase Limit Modification';
						$from_name = 'IndiaMART Buy Lead';
						$mime_header = "Content-type: text/html\n\n";
						$bouncemail = '';
						$sendgrid_login_id= '';
						$sendGridPassword='';
						$sendgrid_category = 'BL Purchase Limit Modification';
						$message_txt = '';
						$uniqueArgs = '';

						$msg='
							<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
							<html lang="en-us">
							<head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
							<body>
							<div style="max-width:600px;font-family:arial;color:#000;line-height:18px;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:left"><tr>
							<td valign="top" style="width:100%;border:1px solid #dddddd;">
							<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tbody><tr><td height="60" width="100%" style=" width:100%;border-bottom:3px solid #2e3192;padding:5px 10px 5px 10px;"><img style="vertical-align:middle; display:block"src="https://trade.indiamart.com/gifs/logo-im.png" alt="IndiaMART" height="41" border="0" width="206"></td></tr></tbody></table></td></tr>
							<tr><td width="100%" style="width:100%; font-family:Arial;font-size:13px;line-height:18px;padding:9px 9px 9px 9px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
							<td valign="top" width="100%" style="width:100%; background:#2e3192; font-family:Arial;font-size:16px;color:#fff;font-weight:bold; text-align:center;padding:5px 0 5px 0">Buy Leads Weekly Purchase Limit Modified </td></tr></table></td></tr>
							<tr><td width="100%" style="width:100%; font-family:Arial;font-size:13px;line-height:18px;padding:10px 9px 9px 9px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<td valign="top" style="font-family:arial,helvetica,san-serif; color:#000; font-weight:bold; font-size:16px; line-height:21px; margin:0;color:#000!important; margin-bottom:0px">Dear '.$name.',</td>
							</tr>

							<tr><td valign="top" width="100%" style="font-family:arial,helvetica,san-serif; color:#000; font-weight:bold; font-size:16px; line-height:21px; padding-top:10px;color:#000!important;">Your weekly <span style="color:#2e3192">Purchase Limit</span> has been <span style="color:#2e3192">modified to '.$limit_new.'</span> Buy Leads/ Tenders.</td></tr> 
							<tr><td valign="top" style="font-family:arial;color:#000;font-size:13px;line-height:18px; margin:0;color:#000!important;margin-bottom:0px; padding:0px 0 0 0"><table width="240" cellspacing="0" cellpadding="0" border="0"  style="float:left; margin-right:50px;padding-top:18px;"><tbody><tr><td align="center" style="font-size:17px;font-weight:bold;font-family:arial;background:#5e9122;color:#fff;"><a target="_blank" href="'.$url_bl.'&amp;utm_source=PurLimitMailer&amp;utm_medium=Email&amp;utm_campaign=BL_Cons" style="text-decoration:none;color:#fff;display:inline-block;width:240px;padding:8px 0;line-height:18px">View Latest Buy Leads<br><span style="font-size:13px;">and purchase instantly</span></a></td></tr></tbody></table> 

							<table width="240" cellspacing="0" cellpadding="0" border="0" style="padding-top:18px;"><tbody><tr><td align="center" style="font-size:17px;font-weight:bold;font-family:arial;background:#5e9122;color:#fff;"><a target="_blank" href="'.$url_tdr.'&amp;utm_source=PurLimitMailer&amp;utm_medium=Email&amp;utm_campaign=TDR_Cons" style="text-decoration:none;color:#fff;display:inline-block;padding:8px 0;line-height:18px;width:240px;">View Latest Tenders<br>
							<span style="font-size:13px;">and grow your business</span></a></td></tr></tbody></table></td>
							</tr>
							<tr>
							<td valign="top" width="100%" style="font-family:arial,helvetica,san-serif; color:#000; font-weight:bold; font-size:16px; line-height:21px; padding-top:10px;color:#000!important;">Hurry! Purchase Latest Buy Leads/ Tenders &amp; Grow your Business.</td></tr>
							<tr><td valign="top" style="font-family:arial,helvetica,san-serif; color:#000;font-size:13px;line-height:18px; margin:0; padding:20px 0 0 0"><div style="font-size:13px;line-height:18px;background:#f0f0f0;padding:8px;display:block;border-radius:4px;"><table width="100%" border="0" cellspacing="0" cellpadding="3">
							<tr><td width="10" valign="top" style="font-weight:bold; color:#666;font-size:15px;">&#8226;</td>
							<td valign="top">
							To ensure safety of your account, we limit the numbers of Buy Leads that can be purchased in a week (7 days).</td></tr> 
							<tr><td width="10" valign="top" style="font-weight:bold; color:#666;font-size:15px;">&#8226;</td>
							<td valign="top">Kindly avoid <strong>forwarding IndiaMART Email/SMS Alert</strong> to unauthorized person, doing same can lead to misuse of your account. </td></tr>  
							</table>

							</div></td></tr>


							</table></td></tr>
							<tr><td width="100%" style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:18px; padding:10px 9px 9px 9px; ">
							<table style="font-family:Arial;font-weight:normal;font-size:14px;line-height:19px;color:#000;border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="border-top-width:1px; border-top-style:solid; border-top-color:#dddddd;" height="16" width="65%"></td></tr><tr><td valign="top" width="100%" style="padding-bottom:5px;"><h2 style="margin:0;margin-bottom:15px;color:#000!important;font-size:15px;font-weight:bold">Buy Lead User Guide</h2><a href="https://trade.indiamart.com/pbl-help.pdf?utm_source=PurLimitMailer&amp;utm_medium=Email&amp;utm_campaign=BL_User_Guide" target="_blank"><img src="https://www.indiamart.com/newsletters/mailer/images/download-pdf-icon.png" height="67"  border="0" width="205" alt="Download PDF" align="left" style="max-width:100%;max-height:100%;margin:0 10px 10px 0"></a></td></tr><tr><td valign="top" width="100%" style="font-family:Arial;font-size:13px;color:#000">
							Click on <a href="https://trade.indiamart.com/pbl-help.pdf?utm_source=PurLimitMailer&amp;utm_medium=Email&amp;utm_campaign=BL_User_Guide" style=" color:#2e3192; font-weight:bold;" target="_blank">Buy Lead User Guide</a> to download and know about how to use  Buy Leads.</td></tr></tbody></table>    </td></tr>
							<tr><td valign="top" style="width:100%;padding:9px 9px 9px 9px;font-family:Arial;font-size:13px;color:#000;line-height:18px;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
							<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td style="padding:10px 0 0px 0"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="top" style=" width:100%; padding:0px 0 0px 2px; color:#333;font-size:13px;font-family:arial;border:1px solid #d4d4d4; background:#f0f0f0; text-align:center"><div style="font-weight:bold;padding:5px 2px 5px 2px;line-height:20px">Now Purchase Buy Leads On-the-Go! <br>Mobile site:<a style="color:#2e3192;text-decoration:none;font-size:14px" href="http://my.indiamart.com/login/autologin?em='.$encry_email.'&dt='.$cur_date.'&av=true&mt=0&redirect=http://m.indiamart.com/bl/" target="_blank"> m.indiamart.com/bl/</a> </div></td></tr></table></td></tr></table></td></tr></table></td></tr>
							<tr><td valign="top" style="width:100%;padding:9px 9px 9px 9px;font-family:Arial;font-size:13px;color:#000;line-height:18px;">In case you have similar concern in future, we request you to contact us on <strong><a href="tel:1800-200-4444" style="color:#444">+91-120-6683562</a></strong> or write us at <strong><a href="mailto:buyleads@indiamart.com" style="color:#444">buyleads@indiamart.com</a></strong>.</td></tr>
							<tr><td valign="top" style="width:100%;padding:9px 9px 9px 9px;font-family:Arial;font-size:13px;color:#000;line-height:18px;">Warm Regards,<br>Team IndiaMART </td></tr>
							<tr><td width="100%" style="width:100%;font-family:Arial;font-size:13px;line-height:18px;padding:9px 9px 9px 9px; "><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td valign="top" width="100%" style="font-family:Arial;font-size:16px;color:#fff;border:1px solid #d1d1d1;text-align:center;"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td style="width:100%; font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#2e3192; text-align:left; padding:7px 5px 7px 5px; background:#eee; font-weight:bold;border-bottom:1px solid #d1d1d1; ">Happy to Help</td></tr>
							<tr><td style="width:100%;font-family:Arial;font-size:13px;line-height:18px;color:#000;padding:5px;text-align:left;border-right:1px solid #d1d1d1;"><strong>Email:</strong> <a href="mailto:customercare@indiamart.com" style="color:#444">customercare@indiamart.com</a><br><strong>Toll Free:</strong><span style="color:#444"> <a href="tel:1800-200-4444" style="color:#444">1800-200-4444</a></span></td></tr></table></td></tr>
							</table></td></tr></table></td></tr></table><table border="0" cellspacing="0" cellpadding="0" align="center"><tr><td valign="top" style=" font-family:Arial, Helvetica, sans-serif; font-size:10px; text-align:center; color:#737373; padding:5px 0 0 0 ">IndiaMART InterMESH Ltd. Advant Navis Business Park, 7th &amp; 8th Floor, Sector - 142, Noida, UP</td></tr></table></div>
							<!--main container end here-->
							</body>
							</html>
							';
							$mail_cnt=0;
                            $mail_cnt=$this->SendMail($subject, $sendgrid_category,$msg, $to, $from_name, $from, $sendgrid_login_id, $sendGridPassword,$mail_cnt,$gluserID);						
					}

					$serv_model = new ServiceGlobalModelForm();
					$hist_comment=$comment;

						if(isset($_REQUEST['limit_reason']) && $_REQUEST['limit_reason']==3){
							$hist_comment.="\n\nMail sent to client\n====================\n"."Dear $name,\n\nYour weekly Purchase Limit has been modified to $limit_new Buy Leads/ Tenders.\n\n==================== | General Update";
						}
						else {
							$hist_comment.=" | General Update";
						}
					$empid = Yii::app()->session['empid'];
					$empname = Yii::app()->session['empname'];
					$empemail = Yii::app()->session['empemail'];
					$comment = "TEST";
					$param = array();
					$param['glid'] = $gluserID;
					$param['comment'] = $hist_comment;
					$param['mail_from'] = $empemail;
					$param['mail_from_name'] = $empname;
					$param['updated_by'] = $empname;
					$param['modid'] = 'GLADMIN';
					$param['module_name'] = 'GLADMIN';
					$param['showdata'] = 1;
					$param['source_fns'] = 946;
					$param['subject'] = 'Testing';
					$host_name = $_SERVER['SERVER_NAME'];
					if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') {
						$curl = 'http://stg-merp.intermesh.net/index.php/Queuehistory/Createhistory';
					} else {
						$curl = 'http://merp.intermesh.net/index.php/Queuehistory/Createhistory';
					}
					$response = $serv_model->mapiService('STSHISTORY', $curl, $param, 'No');
					$code = isset($response['status']) ? $response['status'] : '';
					$message = isset($response['message']) ? $response['message'] : '';
					//if ($code != 200) {
					//	mail("gladmin-team@indiamart.com","STS Service fail ","message=$message;histcomments:$hist_comment");						
					//}
				}
				
 				elseif(isset($_REQUEST['Skip']) && $_REQUEST['Skip'] == 'Skip')
                                {
									$content1=array();
									$content1['token']='imobile1@15061981';
									$content1['modid']='GLADMIN';								
									$content1['glusrid']=$gluserID;	
									$content1['action']='Update';	
									$host_name = $_SERVER['SERVER_NAME'];
									if ($host_name == 'dev-gladmin.intermesh.net' || $host_name == 'stg-gladmin.intermesh.net') 
									{
										$url = 'http://dev-leads.imutils.com/wservce/leads/PurchaseLimitReached/';
									} 
									else 
									{
										$url = 'http://leads.imutils.com/wservce/leads/PurchaseLimitReached/';
									}
									$dataHash1 = $servModel->mapiService('BLPURCHASELIMIT', $url, $content1, 'No');								                 
                                	echo '<div style="padding:6px 8px;color:red;font-weight:bold;font-size:16px;font-family:arial;text-align:center;">Skipped Successfully</div>';
                                }
				$sql="SELECT to_char(ETO_BL_PUR_LIMIT_LAST_UPD_ON, 'dd-Mon-yyyy HH24:MI:SS') LAST_UPDATED_ON,FK_GLUSR_USR_ID,ETO_BL_PUR_LIMIT_WEEKLY,ETO_BL_PUR_LIMIT_REASON,ETO_BL_PUR_LIMIT_LAST_COMMENT FROM ETO_BL_PUR_LIMIT WHERE FK_GLUSR_USR_ID=:GLUSRID";
                                $rec=array();
                                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(':GLUSRID'=>$gluserID));        
                                while($rec1 = $sth->read()) {
                                         $rec=array_change_key_case($rec1, CASE_UPPER);                     
                                }                             
				$glid=isset($rec['FK_GLUSR_USR_ID']) ? $rec['FK_GLUSR_USR_ID'] : '';
				$limit = isset($rec['ETO_BL_PUR_LIMIT_WEEKLY']) ? $rec['ETO_BL_PUR_LIMIT_WEEKLY'] : '' ;
				$limit_reason=isset($rec['ETO_BL_PUR_LIMIT_REASON']) ? $rec['ETO_BL_PUR_LIMIT_REASON'] :'';
				$last_updated_on=isset($rec['LAST_UPDATED_ON']) ? $rec['LAST_UPDATED_ON'] : '';
				$last_comment=isset($rec['ETO_BL_PUR_LIMIT_LAST_COMMENT']) ? $rec['ETO_BL_PUR_LIMIT_LAST_COMMENT'] : '';
				$limit_new = isset($_REQUEST['limit_new']) ? $_REQUEST['limit_new'] : '';
				$comment = isset($_REQUEST['comment']) ? $_REQUEST['comment'] : '';

				echo '<br><FONT FACE="arial" SIZE="-1" COLOR="#800000" class = "admintlt">&nbsp;<B>Purchase Limit Details : </B></FONT><BR>';
				echo '<table width="100%" style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0">
					<tr>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left" width="25%" CLASS="admintext">Current Buy Lead Purchase Limit : </td>
					<td VALIGN="top" CLASS="admintext">&nbsp;&nbsp;';	

				if($limit_new && isset($_REQUEST['Skip']) && $_REQUEST['Skip'] != 'Skip')
				{
					echo ''.$limit_new.' &nbsp; &nbsp; &nbsp;( Last Updated : '.$last_updated_on.' &nbsp;)';	
				}
				elseif($glid)
				{
					if($limit_new != '0')
					{
					echo $limit .' &nbsp; &nbsp; &nbsp;( Last Updated : '.$last_updated_on.' &nbsp;) ';
					
					}
					else
					{
					echo '0 &nbsp; &nbsp; &nbsp;( Last Updated : '.$last_updated_on.' &nbsp;) ';
					}
				}
				else
				{
					$sql="SELECT * FROM (SELECT COUNT(1) CNT,MIN(date(ETO_PUR_DATE)) DT FROM ETO_LEAD_PUR_HIST 
							WHERE FK_GLUSR_USR_ID = :GLUSRID AND FK_ETO_OFR_ID > 0) A WHERE date(DT) = date(now())";
					$rec_new=array();
					$sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(':GLUSRID'=>$gluserID));//echo $sql;        
                                        while($rec = $sth->read()) {
                                                 $rec_new=array_change_key_case($rec, CASE_UPPER);                     
                                        }  
					$CNT=isset($rec_new['CNT']) ? $rec_new['CNT'] : 0;
					if($CNT){
						echo '3&nbsp;&nbsp;&nbsp;*First Time';
					}
					else{
						$sql="Select date_part('day', now()-min(eto_Pur_date))  DT from
							eto_lead_pur_hist
							where fK_glusr_usr_id = :GLUSRID
							and fk_eto_ofr_id > 0";
                                                
                                                $rec_new=array();
                                                $sth = $model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(':GLUSRID'=>$gluserID));//echo $sql;        
                                                while($rec = $sth->read()) {
                                                         $rec_new=array_change_key_case($rec, CASE_UPPER);                     
                                                }      
                                                $DT=isset($rec_new['DT']) ? $rec_new['DT'] : 0;
                                                
                                                $GLUSR_USR_CUSTTYPE_ID=isset($cust_details_row['glusr_usr_custtype_id']) ? $cust_details_row['glusr_usr_custtype_id'] : -1;
                                                $IS_CATALOG=isset($cust_details_row['is_catalog']) ? $cust_details_row['is_catalog'] : 0;

						if(($IS_CATALOG == -1 || $GLUSR_USR_CUSTTYPE_ID == 8) && $DT >= 7)
						{
							echo '';
						}
						else{
							echo '10';
						} 
						echo '&nbsp;&nbsp;&nbsp;*Default Limit';
					}
				}
				echo '<input type="hidden" name="usr_id" id="usr_id" value="'.$gluserID.'"></td></tr>
					<tr>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left" width="25%" CLASS="admintext">Set New Buy Lead Purchase Limit : </td>
					<td>
					<select name="limit_new" style="background-color: #FFFFFF;">';
				echo '<option value="-1">Select Limit</option>';
                              
                                echo '<option value=""';
				if(isset($_REQUEST['limit_new']) && $_REQUEST['limit_new']  == '')
				{
					echo  'SELECTED';
				}
				echo '>Default</option>';
                                
                                
				echo '<option value="0"';
				if(isset($_REQUEST['limit_new']) && $_REQUEST['limit_new']  == 0)
				{
					echo  'SELECTED';
				}
				echo '>0</option>';

				$start=50;
				 $cntr=0;
				if($emp_id == 32739 || $emp_id == 30204 || $emp_id == 33715 || $emp_id == 32235){
					$start=20;
				}
				elseif($emp_id == 32734 || $emp_id == 23015){
					$start=30;
				}
				elseif($emp_id == 4974){
				
					$start=40;
				}
				for($cntr=$start;$cntr>=1;$cntr--)
				{
					echo '<option value="'.$cntr.'"';
					if(isset($_REQUEST['limit_new']) && $_REQUEST['limit_new'] == $cntr){
						echo  'SELECTED';
					}
					echo '>'.$cntr.'</option>';
				}

				if($emp_id == 57343 || $emp_id == 26564 || $emp_id == 1055 || $emp_id == 27 || $emp_id == 18301  || $emp_id == 4810 ||  $emp_id == 40630  || $emp_id ==45596 || $emp_id ==45603 || $emp_id ==32236)
				{
					foreach(range(51,100) as $x)
					{
						echo '<option value="'.$x.'"';
						if(isset($_REQUEST['limit_new']) && $_REQUEST['limit_new'] == $x)
						{
							echo  'SELECTED';
						}
						echo '>'.$x.'</option>';
					}
				}
				if($emp_id ==4810)
				{
				        echo '<option value="500"';
						if(isset($_REQUEST['limit_new']) && $_REQUEST['limit_new'] == 500)
						{
							echo  'SELECTED';
						}
						echo '>500</option>';
				}
				if($emp_id ==32739 || $emp_id ==34058)
				{
				        echo '<option value="30"';
						if(isset($_REQUEST['limit_new']) && $_REQUEST['limit_new'] == 30)
						{
							echo  'SELECTED';
						}
						echo '>30</option>';
				}

				echo '</select>
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>Reason :</b> &nbsp; &nbsp;
				<select name="limit_reason" style="background-color: #FFFFFF;">';

				if(isset($_REQUEST['limit_reason']))
				{		
					$limit_reason=$_REQUEST['limit_reason'];
				}
				echo '<option value="">Select Reason</option>
					<option value="3"';
				if($limit_reason==3){
				echo ' SELECTED';
				}
				echo ' >Genuine</option>
					<option value="1"';
				if($limit_reason==1){ echo 'SELECTED';}
				echo '>Fraud</option>
					<option value="2"';
				if($limit_reason==2){echo ' SELECTED';}
				echo ' >Theft</option>
					<option value="4"';
				if($limit_reason==4){echo ' SELECTED';}
				echo '>OVP</option>
					 <option value="5"';
				if($limit_reason==5){echo ' SELECTED';}
                                echo ' >Monitoring</option>
					';
				echo '</select>
					</td>
					</tr>
					<tr>
					<td BGCOLOR="#dff8ff" VALIGN="top" align="left" width="25%" CLASS="admintext">
					Comments : </td> 
					<td>
					<textarea style="width:55%;float:left;display:inline-block" rows="10" cols="71" name="comment" id="comment"></textarea>';
					if($last_comment)
					{
		echo '<div style="color:#989A9C;float:left; padding-left:15px;width:40%;line-height:18px;"><b>Last Comment:</b><br>'.$last_comment.'</div>';
					}
				echo '
					</td>
					</tr>
					<tr>
					<td width="25%" valign="top" bgcolor="#F0F9FF" align="left" class="admintext"></td>
					<td WIDTH="85%" BGCOLOR="#F0F9FF" colspan="3" HEIGHT="30" align="left">				
					<input type="hidden" name="glid" value="'.$glid.'">
					<input type="submit" name="SetLimit" value="Set Purchase Limit" align="middle" align="middle" onclick="return checkform(this.form)" style="font-size:14px;font-weight:bold; padding:3px 5px;color:#333">';
				
echo '
 <input type="submit" name="Skip" value="Skip" align="middle" style="float:right;font-size:14px;font-weight:bold; padding:3px 5px;color:#333;margin-right: 20px;">
					</td>
					</tr>
					</table></form></BODY></HTML>';
			}
			
		}
		else{
			echo '<br><br><font color="RED"><center> No Record Found </center></font></BODY></HTML>';
		}
	}
		
		
	}
	
	public function get_time()
	{
	$date=date("Y-m-d H:i:sa");
	$date1=explode(' ',$date);
	$date_only =$date1[0];
	$time_only =$date1[1];
	$date_only1=explode('-',$date_only);
	$year=$date_only1[0];
	$month=$date_only1[1];
	$day=$date_only1[2];
	$time_only1=explode(':',$time_only);
	$hour=$time_only1[0];
	$min=$time_only1[1];
	$sec=$time_only1[2];
	$sec=preg_replace('/am/','',$sec);
	$sec=preg_replace('/pm/','',$sec);
	$parameter1=$day.'/'.$month.'/'.$year.' '.$hour.':'.$min.':'.$sec;
	$parameter2=$year.'-'.$month.'-'.$day.'-'.$hour.'-'.$min.'-'.$sec;
        return array($parameter1,$hour,$parameter2);
	}

	
	public function SendMail($subject, $sendGridCategory,$body, $to, $fromName, $fromMail, $sendGridUserName, $sendGridPassword,$mail_cnt,$gl_id)
    {
        $sent_date=date('d-m-y', time());
        $title    = $fromName;
        $from     = $fromMail;
        $usrName  = $sendGridUserName;
        $pass     = $sendGridPassword;

        $toarr=explode(",",$to);
      
        $url = 'https://api.sendgrid.com/';
        $user = $usrName;
        $pass = $pass;
      
      
       //for removing Unsubscribe link 
        $json_string = array(

        'to' => $toarr,
        'category' => $sendGridCategory,
        'unique_args' => array('sentdate' => $sent_date, 'iilglusrid' => $gl_id),
        'filters' => array(
        'subscriptiontrack' => array(
        'settings' => array(
        'enable' => 0,
              )
          )
        ),
          ); 
         
        $params = array(
        'x-smtpapi' => json_encode($json_string),
           'to'        => $to,
        'subject'   => $subject,
        'html'      => $body,
        'from'      => $from,
        'fromname'  => $title,

        );
      
        $request =  $url.'api/mail.send.json';

        $session = curl_init($request);
        curl_setopt ($session, CURLOPT_POST, true);
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HTTPHEADER, array("Authorization: Bearer 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"));
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($session);
        $http_status = curl_getinfo($session, CURLINFO_HTTP_CODE);
       
        if($http_status==200)
        {   
           $mail_cnt++;
        }
     
        curl_close($session);
       
     return $mail_cnt;  

    }
    
public function rc4_encryption($str)
{
$key = "1996c39iil";
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

public function show_purchase_count($dbh,$gluserID,$value1)
{
           					
echo '<style>body,h5{padding:0;margin:0;}table th {text-align:center;font-size:16px;font-weight:bold;}table td {font-size:13px;font-weight:normal;}</style>';               
if($value1 == 1)
{

$sql_suspectedGL = "Select distinct IP_Check.Lead_Pur_GL_ID , IP_Check.IP_Based_Fraud_STATUS 
					 from 
					(Select Total.* , 
					      --Case when ETO_BL_PUR_LIMIT_REASON = 1 then 'FRAUD' when Limit_Set_Gl_id IS NOT NUlL then 'Exists' else 'Not Exists' end IP_Based_Fraud_STATUS ,
					      DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') IP_Based_Fraud_STATUS
					from 
					(Select A.FK_GLUSR_USR_ID Limit_Set_Gl_id , A.ETO_BL_PUR_LIMIT_REASON , B.* from eto_bl_pur_limit A,
					(   
					--Other GL_Users Used same IP & or GA Visitor ID--
					Select DISTINCT(A.ETO_LEAD_PUR_IP), A.ETO_LEAD_PUR_IP_COUNTRY , A.FK_GLUSR_USR_ID Lead_Pur_GL_ID, A.ETO_LEAD_PUR_GA_VISITOR_ID GA_VISITOR_ID 
					from eto_lead_pur_hist A ,
					(
					--Used IP & GA Visitor ID by User--
					select DISTINCT(ETO_LEAD_PUR_IP) Ip_Used, ETO_LEAD_PUR_GA_VISITOR_ID 
					from eto_lead_pur_hist where eto_lead_pur_hist.fk_glusr_usr_id in :GL_ID 
					and (ETO_LEAD_PUR_IP is not null or ETO_LEAD_PUR_GA_VISITOR_ID is not null)
					and ETO_LEAD_PUR_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
					and ETO_LEAD_PUR_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
					and ETO_LEAD_PUR_IP not in ('14.98.94.15')
					and ETO_LEAD_PUR_IP not like '1.38%'
					and ETO_LEAD_PUR_IP not like '223.196.113%'
					and ETO_LEAD_PUR_IP not like '84.64.13%'
					and ETO_LEAD_PUR_IP not like '123.63%'
					and ETO_LEAD_PUR_IP not like '93.186%'
					and ETO_LEAD_PUR_IP not like '112.79.3%'
					and ETO_LEAD_PUR_IP not like '116.203%'
					and ETO_LEAD_PUR_IP not like '223.196.64%'
					and ETO_LEAD_PUR_IP not like '42.104%'
					and ETO_LEAD_PUR_IP not like '223.196.80%' --(Idea Celular)
					UNION
					select DISTINCT(ETO_BL_PUR_CLIENT_IP) Ip_Used , NULL ETO_LEAD_PUR_GA_VISITOR_ID
					from eto_bl_pur_limit_pend
					where fk_glusr_usr_id in :GL_ID
					and ETO_BL_PUR_CLIENT_IP is not null
					and ETO_BL_PUR_CLIENT_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
					and ETO_BL_PUR_CLIENT_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
					and ETO_BL_PUR_CLIENT_IP not in ('14.98.94.15' )
					and ETO_BL_PUR_CLIENT_IP not like '1.38%'
					and ETO_BL_PUR_CLIENT_IP not like '112.79.3%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.113%'
					and ETO_BL_PUR_CLIENT_IP not like '84.64.13%'
					and ETO_BL_PUR_CLIENT_IP not like '93.186%'
					and ETO_BL_PUR_CLIENT_IP not like '123.63%'
					and ETO_BL_PUR_CLIENT_IP not like '116.203%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.64%'
					and ETO_BL_PUR_CLIENT_IP not like '42.104%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.80%' --(Idea Celular)
					--Used IP & GA Visitor ID by User End--
					)B  
					where A.ETO_LEAD_PUR_IP = B.Ip_Used
					and A.ETO_LEAD_PUR_MODE NOT IN ('MOB' , 'APP' , 'APPS')
					--Other GL_Users Used same IP & or GA Visitor ID END--
					) B
					where Lead_Pur_GL_ID = A.FK_GLUSR_USR_ID(+)
					--and Lead_Pur_GL_ID <> :GL_ID
					) Total) IP_Check , 
					( 
					Select Visitor_ID_Data.GA_Based_GL_ID , Visitor_ID_Data.ETO_LEAD_PUR_GA_VISITOR_ID ,
					  DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') GA_Based_Fraud_STATUS from (
					Select Distinct eto_lead_pur_hist.fk_glusr_usr_id GA_Based_GL_ID , eto_lead_pur_hist.ETO_LEAD_PUR_GA_VISITOR_ID ETO_LEAD_PUR_GA_VISITOR_ID,  eto_bl_pur_limit.ETO_BL_PUR_LIMIT_REASON  
					    from eto_lead_pur_hist , eto_bl_pur_limit
					    where ETO_LEAD_PUR_GA_VISITOR_ID in 
					        (select Distinct ETO_LEAD_PUR_GA_VISITOR_ID from eto_lead_pur_hist 
					          where fk_glusr_usr_id = :GL_ID and ETO_LEAD_PUR_GA_VISITOR_ID is NOt NULL) 
					    and eto_lead_pur_hist.fk_glusr_usr_id = eto_bl_pur_limit.FK_GLUSR_USR_ID(+))Visitor_ID_Data
					) Visitor_ID_Check
					Where IP_Check.GA_VISITOR_ID =  Visitor_ID_Check.ETO_LEAD_PUR_GA_VISITOR_ID(+)
					and Lead_Pur_GL_ID <> :GL_ID";
					          
					         $sth_suspectedGL=oci_parse($dbh,$sql_suspectedGL);
                                                 oci_bind_by_name($sth_suspectedGL,':GL_ID',$gluserID);
                                                 oci_execute($sth_suspectedGL);

echo '<body>
<div style="height: 100%; overflow-y: scroll; overflow-x: hidden;">
   <table border="1" width="100%" height="" cellpadding="0" cellspacing="0">
   <th align="center" colspan="3" bgcolor="#6699FF">
   
   </th>
    <tr>
   <td><h5>IP WISE</h5></td>
   <td><h5>STATUS</h5></td>
   </tr>';              
 while($suspectedGL_cnt = oci_fetch_array($sth_suspectedGL,OCI_BOTH))
 {
 
 echo '<tr> 
 <td style="width:110px;">&nbsp;'.$suspectedGL_cnt['LEAD_PUR_GL_ID'].'</td>
 <td style="width:110px;">&nbsp;'.$suspectedGL_cnt['IP_BASED_FRAUD_STATUS'].'</td>
 </tr>';

 }

echo '</table></body></html>';


}



 if($value1 == 2)
 {

 
 $sql_suspectedGL = "Select distinct IP_Check.Lead_Pur_GL_ID , IP_Check.IP_Based_Fraud_STATUS 
					 from 
					(Select Total.* , 
					      --Case when ETO_BL_PUR_LIMIT_REASON = 1 then 'FRAUD' when Limit_Set_Gl_id IS NOT NUlL then 'Exists' else 'Not Exists' end IP_Based_Fraud_STATUS ,
					      DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') IP_Based_Fraud_STATUS
					from 
					(Select A.FK_GLUSR_USR_ID Limit_Set_Gl_id , A.ETO_BL_PUR_LIMIT_REASON , B.* from eto_bl_pur_limit A,
					(   
					--Other GL_Users Used same IP & or GA Visitor ID--
					Select DISTINCT(A.ETO_LEAD_PUR_IP), A.ETO_LEAD_PUR_IP_COUNTRY , A.FK_GLUSR_USR_ID Lead_Pur_GL_ID, A.ETO_LEAD_PUR_GA_VISITOR_ID GA_VISITOR_ID 
					from eto_lead_pur_hist A ,
					(
					--Used IP & GA Visitor ID by User--
					select DISTINCT(ETO_LEAD_PUR_IP) Ip_Used, ETO_LEAD_PUR_GA_VISITOR_ID 
					from eto_lead_pur_hist where eto_lead_pur_hist.fk_glusr_usr_id in :GL_ID 
					and (ETO_LEAD_PUR_IP is not null or ETO_LEAD_PUR_GA_VISITOR_ID is not null)
					and ETO_LEAD_PUR_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
					and ETO_LEAD_PUR_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
					and ETO_LEAD_PUR_IP not in ('14.98.94.15')
					and ETO_LEAD_PUR_IP not like '1.38%'
					and ETO_LEAD_PUR_IP not like '223.196.113%'
					and ETO_LEAD_PUR_IP not like '84.64.13%'
					and ETO_LEAD_PUR_IP not like '123.63%'
					and ETO_LEAD_PUR_IP not like '93.186%'
					and ETO_LEAD_PUR_IP not like '112.79.3%'
					and ETO_LEAD_PUR_IP not like '116.203%'
					and ETO_LEAD_PUR_IP not like '223.196.64%'
					and ETO_LEAD_PUR_IP not like '42.104%'
					and ETO_LEAD_PUR_IP not like '223.196.80%' --(Idea Celular)
					UNION
					select DISTINCT(ETO_BL_PUR_CLIENT_IP) Ip_Used , NULL ETO_LEAD_PUR_GA_VISITOR_ID
					from eto_bl_pur_limit_pend
					where fk_glusr_usr_id in :GL_ID
					and ETO_BL_PUR_CLIENT_IP is not null
					and ETO_BL_PUR_CLIENT_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
					and ETO_BL_PUR_CLIENT_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
					and ETO_BL_PUR_CLIENT_IP not in ('14.98.94.15' )
					and ETO_BL_PUR_CLIENT_IP not like '1.38%'
					and ETO_BL_PUR_CLIENT_IP not like '112.79.3%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.113%'
					and ETO_BL_PUR_CLIENT_IP not like '84.64.13%'
					and ETO_BL_PUR_CLIENT_IP not like '93.186%'
					and ETO_BL_PUR_CLIENT_IP not like '123.63%'
					and ETO_BL_PUR_CLIENT_IP not like '116.203%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.64%'
					and ETO_BL_PUR_CLIENT_IP not like '42.104%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.80%' --(Idea Celular)
					--Used IP & GA Visitor ID by User End--
					)B  
					where A.ETO_LEAD_PUR_IP = B.Ip_Used
					and A.ETO_LEAD_PUR_MODE NOT IN ('MOB' , 'APP' , 'APPS')
					--Other GL_Users Used same IP & or GA Visitor ID END--
					) B
					where Lead_Pur_GL_ID = A.FK_GLUSR_USR_ID(+)
					--and Lead_Pur_GL_ID <> :GL_ID
					) Total) IP_Check , 
					( 
					Select Visitor_ID_Data.GA_Based_GL_ID , Visitor_ID_Data.ETO_LEAD_PUR_GA_VISITOR_ID ,
					  DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') GA_Based_Fraud_STATUS from (
					Select Distinct eto_lead_pur_hist.fk_glusr_usr_id GA_Based_GL_ID , eto_lead_pur_hist.ETO_LEAD_PUR_GA_VISITOR_ID ETO_LEAD_PUR_GA_VISITOR_ID,  eto_bl_pur_limit.ETO_BL_PUR_LIMIT_REASON  
					    from eto_lead_pur_hist , eto_bl_pur_limit
					    where ETO_LEAD_PUR_GA_VISITOR_ID in 
					        (select Distinct ETO_LEAD_PUR_GA_VISITOR_ID from eto_lead_pur_hist 
					          where fk_glusr_usr_id = :GL_ID and ETO_LEAD_PUR_GA_VISITOR_ID is NOt NULL) 
					    and eto_lead_pur_hist.fk_glusr_usr_id = eto_bl_pur_limit.FK_GLUSR_USR_ID(+))Visitor_ID_Data
					) Visitor_ID_Check
					Where IP_Check.GA_VISITOR_ID =  Visitor_ID_Check.ETO_LEAD_PUR_GA_VISITOR_ID(+)
					and Lead_Pur_GL_ID <> :GL_ID";					  
                                                 $sth_suspectedGL = oci_parse($dbh,$sql_suspectedGL);
                                                 oci_bind_by_name($sth_suspectedGL,':GL_ID',$gluserID);
                                                 oci_execute($sth_suspectedGL);

echo '<body>
   <div style="height: 250px; overflow-y: scroll; overflow-x: hidden;">
   <table border="1" width="100%" height="" cellpadding="0" cellspacing="0">
   <th align="center" colspan="3" bgcolor="#6699FF">
   
   </th>
    <tr>
   <td><h5>FRAUD IP WISE</h5></td>
   </tr>';             
                
  while($suspectedGL_cnt = oci_fetch_array($sth_suspectedGL,OCI_BOTH))
  {
  	            
  echo '<tr>';
  if($suspectedGL_cnt['IP_BASED_FRAUD_STATUS'] == 'FRAUD')
  {
  echo '<td style="width:110px;">&nbsp;'.$suspectedGL_cnt['LEAD_PUR_GL_ID'].'</td></tr>';
  }
  }
 echo '</table></div></body></html>';
 
 
 }
 
 
               
 if($value1 == 3)
 {
 
 $sql_suspectedGL = "Select DISTINCT GA_Based_GL_ID,GA_Based_FRAUD_STATUS
                     from
                    (Select Total.* ,
                          --Case when ETO_BL_PUR_LIMIT_REASON = 1 then 'FRAUD' when Limit_Set_Gl_id IS NOT NUlL then 'Exists' else 'Not Exists' end IP_Based_Fraud_STATUS ,
                          DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') IP_Based_Fraud_STATUS
                    from
                    (Select A.FK_GLUSR_USR_ID Limit_Set_Gl_id , A.ETO_BL_PUR_LIMIT_REASON , B.* from eto_bl_pur_limit A,
                    (  
                    --Other GL_Users Used same IP & or GA Visitor ID--
                    Select DISTINCT(A.ETO_LEAD_PUR_IP), A.ETO_LEAD_PUR_IP_COUNTRY , A.FK_GLUSR_USR_ID Lead_Pur_GL_ID, A.ETO_LEAD_PUR_GA_VISITOR_ID GA_VISITOR_ID
                    from eto_lead_pur_hist A ,
                    (
                    --Used IP & GA Visitor ID by User--
                    select DISTINCT(ETO_LEAD_PUR_IP) Ip_Used, ETO_LEAD_PUR_GA_VISITOR_ID
                    from eto_lead_pur_hist where eto_lead_pur_hist.fk_glusr_usr_id in :GL_ID
                    and (ETO_LEAD_PUR_IP is not null or ETO_LEAD_PUR_GA_VISITOR_ID is not null)
                    and ETO_LEAD_PUR_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
                    and ETO_LEAD_PUR_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
                    and ETO_LEAD_PUR_IP not in ('14.98.94.15')
                    and ETO_LEAD_PUR_IP not like '1.38%'
                    and ETO_LEAD_PUR_IP not like '223.196.113%'
                    and ETO_LEAD_PUR_IP not like '84.64.13%'
                    and ETO_LEAD_PUR_IP not like '123.63%'
                    and ETO_LEAD_PUR_IP not like '93.186%'
                    and ETO_LEAD_PUR_IP not like '112.79.3%'
                    and ETO_LEAD_PUR_IP not like '116.203%'
                    and ETO_LEAD_PUR_IP not like '223.196.64%'
                    and ETO_LEAD_PUR_IP not like '42.104%'
                    and ETO_LEAD_PUR_IP not like '223.196.80%' --(Idea Celular)
                    UNION
                    select DISTINCT(ETO_BL_PUR_CLIENT_IP) Ip_Used , NULL ETO_LEAD_PUR_GA_VISITOR_ID
                    from eto_bl_pur_limit_pend
                    where fk_glusr_usr_id in :GL_ID
                    and ETO_BL_PUR_CLIENT_IP is not null
                    and ETO_BL_PUR_CLIENT_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
                    and ETO_BL_PUR_CLIENT_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
                    and ETO_BL_PUR_CLIENT_IP not in ('14.98.94.15' )
                    and ETO_BL_PUR_CLIENT_IP not like '1.38%'
                    and ETO_BL_PUR_CLIENT_IP not like '112.79.3%'
                    and ETO_BL_PUR_CLIENT_IP not like '223.196.113%'
                    and ETO_BL_PUR_CLIENT_IP not like '84.64.13%'
                    and ETO_BL_PUR_CLIENT_IP not like '93.186%'
                    and ETO_BL_PUR_CLIENT_IP not like '123.63%'
                    and ETO_BL_PUR_CLIENT_IP not like '116.203%'
                    and ETO_BL_PUR_CLIENT_IP not like '223.196.64%'
                    and ETO_BL_PUR_CLIENT_IP not like '42.104%'
                    and ETO_BL_PUR_CLIENT_IP not like '223.196.80%' --(Idea Celular)
                    --Used IP & GA Visitor ID by User End--
                    )B 
                    where A.ETO_LEAD_PUR_IP = B.Ip_Used
                    and A.ETO_LEAD_PUR_MODE NOT IN ('MOB' , 'APP' , 'APPS')
                    --Other GL_Users Used same IP & or GA Visitor ID END--
                    ) B
                    where Lead_Pur_GL_ID = A.FK_GLUSR_USR_ID(+)
                    --and Lead_Pur_GL_ID <> :GL_ID
                    ) Total) IP_Check ,
                    (
                    Select Visitor_ID_Data.GA_Based_GL_ID , Visitor_ID_Data.ETO_LEAD_PUR_GA_VISITOR_ID ,
                      DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') GA_Based_Fraud_STATUS from (
                    Select Distinct eto_lead_pur_hist.fk_glusr_usr_id GA_Based_GL_ID , eto_lead_pur_hist.ETO_LEAD_PUR_GA_VISITOR_ID ETO_LEAD_PUR_GA_VISITOR_ID,  eto_bl_pur_limit.ETO_BL_PUR_LIMIT_REASON 
                        from eto_lead_pur_hist , eto_bl_pur_limit
                        where ETO_LEAD_PUR_GA_VISITOR_ID in
                            (select Distinct ETO_LEAD_PUR_GA_VISITOR_ID from eto_lead_pur_hist
                              where fk_glusr_usr_id = :GL_ID and ETO_LEAD_PUR_GA_VISITOR_ID is NOt NULL)
                        and eto_lead_pur_hist.fk_glusr_usr_id = eto_bl_pur_limit.FK_GLUSR_USR_ID(+))Visitor_ID_Data
                    ) Visitor_ID_Check
                    Where IP_Check.GA_VISITOR_ID =  Visitor_ID_Check.ETO_LEAD_PUR_GA_VISITOR_ID(+)
                    and Lead_Pur_GL_ID <> :GL_ID
                    and GA_Based_GL_ID is not null and GA_Based_GL_ID <>:GL_ID";	
                    
                    $sth_suspectedGL = oci_parse($dbh,$sql_suspectedGL);
                    oci_bind_by_name($sth_suspectedGL,':GL_ID',$gluserID);
                    oci_execute($sth_suspectedGL);

echo '<body>
<div style="height: 100%; overflow-y: scroll; overflow-x: hidden;">
   <table border="1" width="100%" height="" cellpadding="0" cellspacing="0">
   <th align="center" colspan="3" bgcolor="#6699FF">
   
   </th>
    <tr>
   <td><h5>VISITOR ID WISE</h5></td>
   <td><h5>STATUS</h5></td>
   </tr>';              
 while($suspectedGL_cnt = oci_fetch_array($sth_suspectedGL,OCI_BOTH))
 {
 echo '<tr> 
 <td style="width:110px;">&nbsp;'.$suspectedGL_cnt['GA_BASED_GL_ID'].'</td>
 <td style="width:110px;">&nbsp;'.$suspectedGL_cnt['GA_BASED_FRAUD_STATUS'].'</td>
 </tr>';

 }

echo '</table></body></html>';



 
 }
 
 
 if($value1 == 4)
 {
 
 $sql_suspectedGL = "Select DISTINCT GA_Based_GL_ID,GA_Based_FRAUD_STATUS
                     from
                    (Select Total.* ,
                          --Case when ETO_BL_PUR_LIMIT_REASON = 1 then 'FRAUD' when Limit_Set_Gl_id IS NOT NUlL then 'Exists' else 'Not Exists' end IP_Based_Fraud_STATUS ,
                          DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') IP_Based_Fraud_STATUS
                    from
                    (Select A.FK_GLUSR_USR_ID Limit_Set_Gl_id , A.ETO_BL_PUR_LIMIT_REASON , B.* from eto_bl_pur_limit A,
                    (  
                    --Other GL_Users Used same IP & or GA Visitor ID--
                    Select DISTINCT(A.ETO_LEAD_PUR_IP), A.ETO_LEAD_PUR_IP_COUNTRY , A.FK_GLUSR_USR_ID Lead_Pur_GL_ID, A.ETO_LEAD_PUR_GA_VISITOR_ID GA_VISITOR_ID
                    from eto_lead_pur_hist A ,
                    (
                    --Used IP & GA Visitor ID by User--
                    select DISTINCT(ETO_LEAD_PUR_IP) Ip_Used, ETO_LEAD_PUR_GA_VISITOR_ID
                    from eto_lead_pur_hist where eto_lead_pur_hist.fk_glusr_usr_id in :GL_ID
                    and (ETO_LEAD_PUR_IP is not null or ETO_LEAD_PUR_GA_VISITOR_ID is not null)
                    and ETO_LEAD_PUR_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
                    and ETO_LEAD_PUR_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
                    and ETO_LEAD_PUR_IP not in ('14.98.94.15')
                    and ETO_LEAD_PUR_IP not like '1.38%'
                    and ETO_LEAD_PUR_IP not like '223.196.113%'
                    and ETO_LEAD_PUR_IP not like '84.64.13%'
                    and ETO_LEAD_PUR_IP not like '123.63%'
                    and ETO_LEAD_PUR_IP not like '93.186%'
                    and ETO_LEAD_PUR_IP not like '112.79.3%'
                    and ETO_LEAD_PUR_IP not like '116.203%'
                    and ETO_LEAD_PUR_IP not like '223.196.64%'
                    and ETO_LEAD_PUR_IP not like '42.104%'
                    and ETO_LEAD_PUR_IP not like '223.196.80%' --(Idea Celular)
                    UNION
                    select DISTINCT(ETO_BL_PUR_CLIENT_IP) Ip_Used , NULL ETO_LEAD_PUR_GA_VISITOR_ID
                    from eto_bl_pur_limit_pend
                    where fk_glusr_usr_id in :GL_ID
                    and ETO_BL_PUR_CLIENT_IP is not null
                    and ETO_BL_PUR_CLIENT_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
                    and ETO_BL_PUR_CLIENT_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
                    and ETO_BL_PUR_CLIENT_IP not in ('14.98.94.15' )
                    and ETO_BL_PUR_CLIENT_IP not like '1.38%'
                    and ETO_BL_PUR_CLIENT_IP not like '112.79.3%'
                    and ETO_BL_PUR_CLIENT_IP not like '223.196.113%'
                    and ETO_BL_PUR_CLIENT_IP not like '84.64.13%'
                    and ETO_BL_PUR_CLIENT_IP not like '93.186%'
                    and ETO_BL_PUR_CLIENT_IP not like '123.63%'
                    and ETO_BL_PUR_CLIENT_IP not like '116.203%'
                    and ETO_BL_PUR_CLIENT_IP not like '223.196.64%'
                    and ETO_BL_PUR_CLIENT_IP not like '42.104%'
                    and ETO_BL_PUR_CLIENT_IP not like '223.196.80%' --(Idea Celular)
                    --Used IP & GA Visitor ID by User End--
                    )B 
                    where A.ETO_LEAD_PUR_IP = B.Ip_Used
                    and A.ETO_LEAD_PUR_MODE NOT IN ('MOB' , 'APP' , 'APPS')
                    --Other GL_Users Used same IP & or GA Visitor ID END--
                    ) B
                    where Lead_Pur_GL_ID = A.FK_GLUSR_USR_ID(+)
                    --and Lead_Pur_GL_ID <> :GL_ID
                    ) Total) IP_Check ,
                    (
                    Select Visitor_ID_Data.GA_Based_GL_ID , Visitor_ID_Data.ETO_LEAD_PUR_GA_VISITOR_ID ,
                      DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') GA_Based_Fraud_STATUS from (
                    Select Distinct eto_lead_pur_hist.fk_glusr_usr_id GA_Based_GL_ID , eto_lead_pur_hist.ETO_LEAD_PUR_GA_VISITOR_ID ETO_LEAD_PUR_GA_VISITOR_ID,  eto_bl_pur_limit.ETO_BL_PUR_LIMIT_REASON 
                        from eto_lead_pur_hist , eto_bl_pur_limit
                        where ETO_LEAD_PUR_GA_VISITOR_ID in
                            (select Distinct ETO_LEAD_PUR_GA_VISITOR_ID from eto_lead_pur_hist
                              where fk_glusr_usr_id = :GL_ID and ETO_LEAD_PUR_GA_VISITOR_ID is NOt NULL)
                        and eto_lead_pur_hist.fk_glusr_usr_id = eto_bl_pur_limit.FK_GLUSR_USR_ID(+))Visitor_ID_Data
                    ) Visitor_ID_Check
                    Where IP_Check.GA_VISITOR_ID =  Visitor_ID_Check.ETO_LEAD_PUR_GA_VISITOR_ID(+)
                    and Lead_Pur_GL_ID <> :GL_ID
                    and GA_Based_GL_ID is not null and GA_Based_GL_ID <>:GL_ID";					  
                                                 $sth_suspectedGL = oci_parse($dbh,$sql_suspectedGL);
                                                 oci_bind_by_name($sth_suspectedGL,':GL_ID',$gluserID);
                                                 oci_execute($sth_suspectedGL);
 
 echo '<body>
   <div style="height: 250px; overflow-y: scroll; overflow-x: hidden;">
   <table border="1" width="100%" height="" cellpadding="0" cellspacing="0">
   <th align="center" colspan="3" bgcolor="#6699FF">
   
   </th>
    <tr>
   <td><h5>FRAUD VISITOR ID WISE</h5></td>
   </tr>';             
                
  while($suspectedGL_cnt = oci_fetch_array($sth_suspectedGL,OCI_BOTH))
  {
  	            
  echo '<tr>';
  if($suspectedGL_cnt['GA_BASED_FRAUD_STATUS'] == 'FRAUD')
  {
  echo '<td style="width:110px;">&nbsp;'.$suspectedGL_cnt['GA_BASED_GL_ID'].'</td></tr>';
  }
 }
 
 echo '</table></div></body></html>';
 
 
 }

}
public function getGLDetail($email,$id,$mobileno,$phcode){
	$global_model=new GlobalmodelForm();
        $obj = new Globalconnection();

	$ha=array();
        if(isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] =='dev-gladmin.intermesh.net') || ($_SERVER['SERVER_NAME'] =='stg-gladmin.intermesh.net'))
        {
            $dbh = $obj->connect_db_yii('postgress_web77v');   
        }else{
            $dbh = $obj->connect_db_yii('postgress_web68v'); 
        }                                
      
    if ($id > 0 ) {
               $sql = "Select GLUSR_USR.*,GLUSR_USR_CUSTTYPE_ID,IS_CATALOG from GLUSR_USR,CUSTTYPE WHERE GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID AND GLUSR_USR_ID=:usr";   
                    $sth = $global_model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(
                    ":usr" => $id
                ));
        } elseif($email<>'') {
          $sql = "Select GLUSR_USR.*,GLUSR_USR_CUSTTYPE_ID,IS_CATALOG from GLUSR_USR,CUSTTYPE WHERE GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID AND GLUSR_USR_EMAIL_DUP=UPPER(:usr) ";  
                $sth = $global_model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array(
                ":usr" => $email
            ));
        }else{
             
                            if($phcode=='FR'){
                                $sqlcond=" AND GLUSR_USR.GLUSR_USR_PH_COUNTRY <> '91' ";
                            }else{
                                $sqlcond=" AND GLUSR_USR.GLUSR_USR_PH_COUNTRY='91' ";
                            }
				$mobileno=preg_replace('/^\s+|\s+$/','',$mobileno);
			        $sql="Select GLUSR_USR.*,GLUSR_USR_CUSTTYPE_ID,IS_CATALOG from GLUSR_USR,CUSTTYPE WHERE GLUSR_USR_CUSTTYPE_ID = CUSTTYPE_ID "
                                        . "AND GLUSR_USR_PH_MOBILE='$mobileno' ".$sqlcond;
                                                  
                                $sth = $global_model->runSelect(__FILE__, __LINE__, __CLASS__, $dbh, $sql, array());
        }
        
        if ($sth) {
			$ha  = $sth->read();
			if(!empty($ha)) 
			$ha=array_change_key_case($ha,CASE_LOWER);
        }
        return $ha;
}

public function leadpurchased($gluserid,$dbh)
        {
        $gluserid=isset($_REQUEST['gluserid']) ? $_REQUEST['gluserid'] : '';
        if($dbh)
        {
	$sql_final="SELECT ETO_LEAD_PUR_TYPE,DECODE(FK_GL_COUNTRY_ISO,'IN','INDIAN',NULL,'INDIAN','FOREIGN') COUNTRY,SUM(TYPE_7) DAY7_CNT,SUM(TYPE_30) DAY30_CNT,SUM(TYPE_90) DAY90_CNT FROM
				(
					SELECT NVL(ETO_LEAD_PUR_TYPE,'B') ETO_LEAD_PUR_TYPE,FK_GL_COUNTRY_ISO,
					CASE WHEN trunc(eto_pur_date) > trunc(sysdate -7) THEN 1 ELSE 0 END type_7,
					CASE WHEN trunc(eto_pur_date) > trunc(sysdate -30) THEN 1 ELSE 0 END type_30,
					CASE WHEN trunc(eto_pur_date) > trunc(sysdate -90) THEN 1 ELSE 0 END type_90
					FROM ETO_LEAD_PUR_HIST,GLUSR_USR
					WHERE ETO_OFR_GLUSR_USR_ID = GLUSR_USR_ID(+)
					AND FK_ETO_OFR_ID > 0
					AND FK_GLUSR_USR_ID =:GLID
				)
				GROUP BY ETO_LEAD_PUR_TYPE,DECODE(FK_GL_COUNTRY_ISO,'IN','INDIAN',NULL,'INDIAN','FOREIGN')
				ORDER BY 1";

				$sth_final = oci_parse($dbh,$sql_final);
				oci_bind_by_name($sth_final,':GLID',$gluserid);
				oci_execute($sth_final); 
			         $count_final='';
				$fBcount=array();
				$iBcount=array();
				$Tcount=array();
				while($count_final = oci_fetch_array($sth_final,OCI_BOTH)){
					if(($count_final['COUNTRY'] != 'INDIAN' ) && ($count_final['ETO_LEAD_PUR_TYPE'] == 'B')){
						$fBcount=array(
								'DAY30_CNT' =>$count_final['DAY30_CNT'],
								'DAY90_CNT' =>$count_final['DAY90_CNT'],
								'DAY7_CNT' =>$count_final['DAY7_CNT']

							 );
					}
					elseif(($count_final['COUNTRY'] == 'INDIAN' ) && ($count_final['ETO_LEAD_PUR_TYPE'] == 'B')){
						$iBcount=array(
								'DAY30_CNT' =>$count_final['DAY30_CNT'],
								'DAY90_CNT' =>$count_final['DAY90_CNT'],
								'DAY7_CNT' =>$count_final['DAY7_CNT']
							 );
					}
					elseif($count_final['ETO_LEAD_PUR_TYPE'] == 'T'){
						$Tcount=array(
								'DAY30_CNT' =>$count_final['DAY30_CNT'],
								'DAY90_CNT' =>$count_final['DAY90_CNT'],
								'DAY7_CNT' =>$count_final['DAY7_CNT']
							);
					}
				}
				$iBcount['DAY7_CNT']=isset($iBcount['DAY7_CNT']) ? $iBcount['DAY7_CNT'] :0;
				$fBcount['DAY7_CNT']=isset($fBcount['DAY7_CNT']) ? $fBcount['DAY7_CNT'] :0;
				$iBcount['DAY30_CNT']=isset($iBcount['DAY30_CNT']) ? $iBcount['DAY30_CNT'] :0;
				$fBcount['DAY30_CNT']=isset($fBcount['DAY30_CNT']) ? $fBcount['DAY30_CNT'] :0;
				$iBcount['DAY90_CNT']=isset($iBcount['DAY90_CNT']) ? $iBcount['DAY90_CNT'] :0;
				$fBcount['DAY90_CNT']=isset($fBcount['DAY90_CNT']) ? $fBcount['DAY90_CNT'] :0;
				$Tcount['DAY7_CNT']=isset($Tcount['DAY7_CNT']) ? $Tcount['DAY7_CNT'] :0;
				$Tcount['DAY30_CNT']=isset($Tcount['DAY30_CNT']) ? $Tcount['DAY30_CNT'] :0;
				$Tcount['DAY90_CNT']=isset($Tcount['DAY90_CNT']) ? $Tcount['DAY90_CNT'] :0;
				
			        $blcni7d = $iBcount['DAY7_CNT'] + $fBcount['DAY7_CNT'];
				$blcni30d = $iBcount['DAY30_CNT'] + $fBcount['DAY30_CNT'];
				$blcni90d = $iBcount['DAY90_CNT'] + $fBcount['DAY90_CNT'];

				$tblcni7d = $iBcount['DAY7_CNT'] + $fBcount['DAY7_CNT'] + $Tcount['DAY7_CNT'];
				$tblcni30d = $iBcount['DAY30_CNT'] + $fBcount['DAY30_CNT'] + $Tcount['DAY30_CNT'];
				$tblcni90d = $iBcount['DAY90_CNT'] + $fBcount['DAY90_CNT'] +$Tcount['DAY90_CNT'];
        }
          else
        {
            echo "Not connected to the database IMBLR";
            exit;
        }
        
      $a='
            <table  style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0">
            <tr>
            <td width="10%" BGCOLOR="#dff8ff" CLASS="admintext">    </td>
            <td width="10%" BGCOLOR="#dff8ff" CLASS="admintext">7 days</td>
            <td width="10%" BGCOLOR="#dff8ff" CLASS="admintext">1 Month</td>
            <td width="10%" BGCOLOR="#dff8ff" CLASS="admintext">3 Months</td>
            </tr>

            <tr>
            <td align=\'left\' CLASS="admintext"> Lead Purchased</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$blcni7d.'</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$blcni30d.'</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$blcni90d.'</td>
            </tr>
            <tr>
            <td width="10%" CLASS="admintext" align="left">&nbsp;&nbsp;&nbsp;&nbsp;Indian</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$iBcount['DAY7_CNT'].'</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$iBcount['DAY30_CNT'].'</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$iBcount['DAY90_CNT'].'</td>
            </tr>
            <tr>
            <td width="10%" CLASS="admintext" align="left">&nbsp;&nbsp;&nbsp;&nbsp;Foreign</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$fBcount['DAY7_CNT'].'</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$fBcount['DAY30_CNT'].'</td>
            <td class=\'LP\' align="center" CLASS="admintext1">'.$fBcount['DAY90_CNT'].'</td>
            </tr>
            <tr>
            <td width="10%" align=\'left\' CLASS="admintext">Tender Purchased</td>
            <td align="center" CLASS="admintext1">'.$Tcount['DAY7_CNT'].'</td>
            <td align="center" CLASS="admintext1">'.$Tcount['DAY30_CNT'].'</td>
            <td align="center" CLASS="admintext1">'.$Tcount['DAY90_CNT'].'</td>
            </tr>
            <tr>
            <td width="10%" align=\'left\' CLASS="admintext">Total Purchased</td>
            <td align="center" CLASS="admintext1"><b>'.$tblcni7d.'</b></td>
            <td align="center" CLASS="admintext1"><b>'.$tblcni30d.'</b></td>
            <td align="center" CLASS="admintext1"><b>'.$tblcni90d.'</b></td>
            </tr>
            </table>
    ';
      return $a;
}




public function frauddetails($gluserid,$dbh_r)
        {
         if($dbh_r)
        {
             $visitor_fraud_cnt= $ip_fraud_cnt= $total_visitor=$total_ip='';
              $sql_suspectedGL = "Select IP_Check.ETO_LEAD_PUR_IP , IP_Check.ETO_LEAD_PUR_IP_COUNTRY , IP_Check.Lead_Pur_GL_ID , IP_Check.GA_VISITOR_ID , IP_Check.IP_Based_Fraud_STATUS ,
					Visitor_ID_Check.* from 
					(Select Total.* , 
					      --Case when ETO_BL_PUR_LIMIT_REASON = 1 then 'FRAUD' when Limit_Set_Gl_id IS NOT NUlL then 'Exists' else 'Not Exists' end IP_Based_Fraud_STATUS ,
					      DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') IP_Based_Fraud_STATUS
					from 
					(Select A.FK_GLUSR_USR_ID Limit_Set_Gl_id , A.ETO_BL_PUR_LIMIT_REASON , B.* from eto_bl_pur_limit A,
					(   
					--Other GL_Users Used same IP & or GA Visitor ID--
					Select DISTINCT(A.ETO_LEAD_PUR_IP), A.ETO_LEAD_PUR_IP_COUNTRY , A.FK_GLUSR_USR_ID Lead_Pur_GL_ID, A.ETO_LEAD_PUR_GA_VISITOR_ID GA_VISITOR_ID 
					from eto_lead_pur_hist A ,
					(
					--Used IP & GA Visitor ID by User--
					select DISTINCT(ETO_LEAD_PUR_IP) Ip_Used, ETO_LEAD_PUR_GA_VISITOR_ID 
					from eto_lead_pur_hist where eto_lead_pur_hist.fk_glusr_usr_id in :GL_ID 
					and (ETO_LEAD_PUR_IP is not null or ETO_LEAD_PUR_GA_VISITOR_ID is not null)
					and ETO_LEAD_PUR_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
					and ETO_LEAD_PUR_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
					and ETO_LEAD_PUR_IP not in ('14.98.94.15')
					and ETO_LEAD_PUR_IP not like '1.38%'
					and ETO_LEAD_PUR_IP not like '223.196.113%'
					and ETO_LEAD_PUR_IP not like '84.64.13%'
					and ETO_LEAD_PUR_IP not like '123.63%'
					and ETO_LEAD_PUR_IP not like '93.186%'
					and ETO_LEAD_PUR_IP not like '112.79.3%'
					and ETO_LEAD_PUR_IP not like '116.203%'
					and ETO_LEAD_PUR_IP not like '223.196.64%'
					and ETO_LEAD_PUR_IP not like '42.104%'
					and ETO_LEAD_PUR_IP not like '223.196.80%' --(Idea Celular)
					UNION
					select DISTINCT(ETO_BL_PUR_CLIENT_IP) Ip_Used , NULL ETO_LEAD_PUR_GA_VISITOR_ID
					from eto_bl_pur_limit_pend
					where fk_glusr_usr_id in :GL_ID
					and ETO_BL_PUR_CLIENT_IP is not null
					and ETO_BL_PUR_CLIENT_IP Not in ('54.239.188.90', '54.240.148.94' , '54.239.160.84', '54.240.148.11', '54.239.188.87')
					and ETO_BL_PUR_CLIENT_IP not in ('182.74.87.250' , '117.55.242.66' , '115.111.169.126') --'IM IP Addresses'
					and ETO_BL_PUR_CLIENT_IP not in ('14.98.94.15' )
					and ETO_BL_PUR_CLIENT_IP not like '1.38%'
					and ETO_BL_PUR_CLIENT_IP not like '112.79.3%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.113%'
					and ETO_BL_PUR_CLIENT_IP not like '84.64.13%'
					and ETO_BL_PUR_CLIENT_IP not like '93.186%'
					and ETO_BL_PUR_CLIENT_IP not like '123.63%'
					and ETO_BL_PUR_CLIENT_IP not like '116.203%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.64%'
					and ETO_BL_PUR_CLIENT_IP not like '42.104%'
					and ETO_BL_PUR_CLIENT_IP not like '223.196.80%' --(Idea Celular)
					--Used IP & GA Visitor ID by User End--
					)B  
					where A.ETO_LEAD_PUR_IP = B.Ip_Used
					and A.ETO_LEAD_PUR_MODE NOT IN ('MOB' , 'APP' , 'APPS')
					--Other GL_Users Used same IP & or GA Visitor ID END--
					) B
					where Lead_Pur_GL_ID = A.FK_GLUSR_USR_ID(+)
					--and Lead_Pur_GL_ID <> :GL_ID
					) Total) IP_Check , 
					( 
					Select Visitor_ID_Data.GA_Based_GL_ID , Visitor_ID_Data.ETO_LEAD_PUR_GA_VISITOR_ID ,
					  DECODE(ETO_BL_PUR_LIMIT_REASON, 1, 'FRAUD', 2, 'Theft', 3, 'Genuine', 4, 'OVP', 5, 'Monitoring', NULL, 'Not Exists') GA_Based_Fraud_STATUS from (
					Select Distinct eto_lead_pur_hist.fk_glusr_usr_id GA_Based_GL_ID , eto_lead_pur_hist.ETO_LEAD_PUR_GA_VISITOR_ID ETO_LEAD_PUR_GA_VISITOR_ID,  eto_bl_pur_limit.ETO_BL_PUR_LIMIT_REASON  
					    from eto_lead_pur_hist , eto_bl_pur_limit
					    where ETO_LEAD_PUR_GA_VISITOR_ID in 
					        (select Distinct ETO_LEAD_PUR_GA_VISITOR_ID from eto_lead_pur_hist 
					          where fk_glusr_usr_id = :GL_ID and ETO_LEAD_PUR_GA_VISITOR_ID is NOt NULL) 
					    and eto_lead_pur_hist.fk_glusr_usr_id = eto_bl_pur_limit.FK_GLUSR_USR_ID(+))Visitor_ID_Data
					) Visitor_ID_Check
					Where IP_Check.GA_VISITOR_ID =  Visitor_ID_Check.ETO_LEAD_PUR_GA_VISITOR_ID(+)
					and Lead_Pur_GL_ID <> :GL_ID ";					  
                                                 $sth_suspectedGL = oci_parse($dbh_r,$sql_suspectedGL);
                                                 oci_bind_by_name($sth_suspectedGL,':GL_ID',$gluserid);
                                                 oci_execute($sth_suspectedGL);
		$suspectedGL1=array();
		$suspectedGL2=array();
		$suspectedGL_cnt='';
		$key1='';
		$key_value1='';
		$total_ip=0;
		$ip_fraud_cnt=0;
 		$total_visitor=0;
		$visitor_fraud_cnt=0;
                 while($suspectedGL_cnt = oci_fetch_array($sth_suspectedGL,OCI_BOTH))
                 {
 	                if(isset($suspectedGL_cnt['LEAD_PUR_GL_ID']) &&  !(isset($suspectedGL1[$suspectedGL_cnt['LEAD_PUR_GL_ID']])) && $suspectedGL_cnt['LEAD_PUR_GL_ID'] != $gluserid)
 	                {
 				$suspectedGL1[$suspectedGL_cnt['LEAD_PUR_GL_ID']]=isset($suspectedGL_cnt['IP_BASED_FRAUD_STATUS']) ? $suspectedGL_cnt['IP_BASED_FRAUD_STATUS'] :'Not Exists';
                         }
 	                if(isset($suspectedGL_cnt['GA_BASED_GL_ID']) && !(isset($suspectedGL2[$suspectedGL_cnt['GA_BASED_GL_ID']])) && $suspectedGL_cnt['GA_BASED_GL_ID']!= $gluserid){
 				$suspectedGL2[$suspectedGL_cnt['GA_BASED_GL_ID']]=isset($suspectedGL_cnt['IP_BASED_FRAUD_STATUS']) ? $suspectedGL_cnt['IP_BASED_FRAUD_STATUS'] :'Not Exists';
                                         }
 		}
		$total_ip=array_keys($suspectedGL1);
		$total_ip=sizeof($total_ip);
		$total_visitor=array_keys($suspectedGL2);
		$total_visitor=sizeof($total_visitor);
		foreach (array_keys($suspectedGL1) as $key1) {
 			   $key_value1 = $suspectedGL1[$key1];
			   if($key_value1 == 'FRAUD'){
				$ip_fraud_cnt++;
				}
		}
		foreach(array_keys($suspectedGL2) as $key1) {
 			   $key_value1 = $suspectedGL2[$key1];
			   if($key_value1 == 'FRAUD'){
				$visitor_fraud_cnt++;
				}
		}

        }else
        {
            echo "Not connected to the database IMBLR";
            exit;
        }
        
        $ret1=$ret='';
        if($visitor_fraud_cnt >0){ $ret1= '<div><font color="RED"><strong>&nbsp; &nbsp; &nbsp;FRAUD</strong></font></div>';}
	elseif($ip_fraud_cnt>0){ $ret1= '<div><font color="RED"><strong>&nbsp; &nbsp; &nbsp;Suspected Fraud</strong></font></div>';}
        $ret ='<table id="Others" style="border-collapse: collapse;" border="1" bordercolor="#bedadd" cellpadding="4" cellspacing="0">
                <tr>
                <td BGCOLOR="#dff8ff" CLASS="admintext" width="30%">'.$ret1.'</td><td align="center" BGCOLOR="#dff8ff" CLASS="admintext" width="35%">IP Wise</td><td width="35%" align="center" BGCOLOR="#dff8ff" CLASS="admintext">Visitor ID Wise</td>
                </tr>
                <tr>
                <td align="center" CLASS="admintext1" width="30%">Total</td><td align="center" CLASS="admintext1" width="35%">'.$total_ip.'</td><td align="center" CLASS="admintext1" width="35%">'.$total_visitor.'</td>
                </tr>
                <tr>
                <td width="30%" align="center" CLASS="admintext1">Fraud</td><td align="center" CLASS="admintext1" width="35%">'.$ip_fraud_cnt.'</td><td align="center" CLASS="admintext1" width="35%">'.$visitor_fraud_cnt.'</td>
                </table>';
        return $ret;
        }
}	
