<?php
if(isset($_COOKIE["adminiil"]))
{
$emp_id= $_COOKIE["adminiil"];
}
else
{
$emp_id=0;
}
//echo $emp_id;exit;
$obj=new GlobalEtoNew ;
$isvalid=$obj->checkEmpStatus($emp_id);
$full_name='';
if($isvalid!=0)
{
$formid=$_REQUEST['id'];
$ob = 		new TransactionReport;
$global_ob= 	new BLGlobalmodelForm;
$temp_ob= 	new MyTemplates;
$dbh =$global_ob->connect_db();
$adm_code=$ob->GetAdmLvlCode($emp_id);
$adm_lvl=$ob->GetAdmAllLevels();
$adm_val=array();
//echo "admin level values";print_r($adm_lvl);
if(empty($lvl_code))
{$lvl_code=1000;}
$i=0;
foreach($adm_lvl as $row)
       {
		$adm_val[$row['GL_ADM_LVL_NAME']]=$row['GL_ADM_LVL_CODE'];
	}
if($adm_code<=$adm_val['General'])
{
	$glusr_sql="SELECT  GLUSR_USR_FIRSTNAME, GLUSR_USR_LASTNAME, GLUSR_USR_PASS, GLUSR_USR_LOGINCOUNT, GLUSR_USR_LAST_OK_ATMPT, TO_CHAR(GLUSR_USR_MEMBERSINCE, 'DD-Mon-yyyy HH24:MI:SS') GLUSR_USR_MEMBERSINCE, TO_CHAR(GLUSR_USR_LASTMODIFIED, 'DD-Mon-yyyy HH24:MI:SS') GLUSR_USR_LASTMODIFIED, TO_CHAR(GLUSR_USR_LASTLOGIN, 'DD-Mon-yyyy HH24:MI:SS') GLUSR_USR_LASTLOGIN,GLUSR_USR_IPADDRESS FROM GLUSR_USR WHERE GLUSR_USR_ID=:glusrid"; 
$sql_rslt = $dbh->createCommand($glusr_sql);
				$sql_rslt->bindValue(":glusrid",$formid);
				$dataReader=$sql_rslt->query();
				$rec=$dataReader->readAll();

$user_info = ' <TR>
					<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>Member Since</TD>
					<TD BGCOLOR="f1f1f1" CLASS="admintext1"> '.$rec[0]['GLUSR_USR_MEMBERSINCE'].' </TD>
					<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>User Name/Pass</TD>
					<TD BGCOLOR="f1f1f1" CLASS="admintext1"> / ';

					if ($adm_code <= $adm_val['Super']) 
					{
						$user_info .= $rec[0]['GLUSR_USR_PASS'].'</TD>';
					}
					else 
					{
						$user_info .=  '<TD BGCOLOR="f1f1f1" CLASS="admintext1">****</TD>';
					}

					if(empty($rec[0]['GLUSR_USR_LASTMODIFIED']))$rec[0]['GLUSR_USR_LASTMODIFIED'] = '' ;
					if(empty($rec[0]['GLUSR_USR_LAST_OK_ATMPT']))$rec[0]['GLUSR_USR_LAST_OK_ATMPT'] = '' ;
					if(empty($rec[0]['GLUSR_USR_LASTLOGIN'])) $rec[0]['GLUSR_USR_LASTLOGIN'] = '' ;
					if(empty($rec[0]['GLUSR_USR_LOGINCOUNT']))$rec[0]['GLUSR_USR_LOGINCOUNT'] = '' ;
					if(empty($rec[0]['GLUSR_USR_IPADDRESS']))$rec[0]['GLUSR_USR_IPADDRESS'] = 'NA' ;

					$user_info .= '
					</TD>
				  </TR>
				  <TR>
					<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
					Last Modified</TD>
					<TD BGCOLOR="f1f1f1" CLASS="admintext1">'.$rec[0]['GLUSR_USR_LASTMODIFIED'].'</TD>
					<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
					Unsuccessful Logins</TD>
					<TD BGCOLOR="f1f1f1" CLASS="admintext1">'.$rec[0]['GLUSR_USR_LAST_OK_ATMPT'].'</TD>
				  </TR>
				  <TR>
					<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
					Last Login</TD>
					<TD BGCOLOR="f1f1f1" CLASS="admintext1">'.$rec[0]['GLUSR_USR_LASTLOGIN'].'</TD>
					<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
					Login Count</TD>
					<TD BGCOLOR="f1f1f1" CLASS="admintext1">'.$rec[0]['GLUSR_USR_LOGINCOUNT'].'</TD>
				  </TR>
				  <TR>
					<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
					IP Address</TD>
					<TD COLSPAN=3 BGCOLOR="f1f1f1" CLASS="admintext1">'.$rec[0]['GLUSR_USR_IPADDRESS'].'</TD>

				  </TR>
				<TR><TD COLSPAN=2></TD></TR> ';

					$eto_sql = "SELECT COUNT(*) FROM ETO_OFR WHERE FK_GLUSR_USR_ID=:glusrid";
					$eto_rslt = $dbh->createCommand($eto_sql);
				$eto_rslt->bindValue(":glusrid",$formid);
				$dataReader=$eto_rslt->query();
				$eto_count=$dataReader->read();
//print_r($eto_count);exit;

					$user_info .='<TR>';

					if ($eto_count['COUNT(*)']!=0) {
						$user_info .= '
						<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
						Trade offers posted</TD>
						<TD BGCOLOR="f1f1f1" CLASS="admintext1"> '.$eto_count['COUNT(*)'].'[ <A HREF="index.php?r=admin_bl/adminEto/EtoSearch&mem='.$formid.'&go=Go" TARGET="_TOP">View</A> ]</TD>';
					}
					else {
						$user_info .= '
						<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
						Trade offers posted</TD>
						<TD BGCOLOR="f1f1f1" CLASS="admintext1">0</TD>';

					}
					$eto_res = "SELECT COUNT(*) FROM ETO_RESPONSE WHERE FK_GLUSR_USR_ID=:glusrid";
					$respose_rslt = $dbh->createCommand($eto_res);
				$respose_rslt->bindValue(":glusrid",$formid);
				$dataReader=$respose_rslt->query();
				$response=$dataReader->read();
					if ($response['COUNT(*)']!=0) {
						$user_info .= '
						<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
						Trade responses posted</TD>
						<TD BGCOLOR="f1f1f1" CLASS="admintext1">'.$response['COUNT(*)'].' [ <A HREF="index.php?r=admin_bl/adminEto/EtoUserResp&mem='.$formid.'&go=Go" TARGET="_TOP">View</A> ]</TD>';
					}
					else {
						$user_info .= '
						<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=20%>
						Trade responses posted</TD>
						<TD BGCOLOR="f1f1f1" CLASS="admintext1">0</TD>';
					}


$st = "SELECT FK_GLCAT_CAT_ID, ETO_OFR_TYP, GLCAT_CAT_NAME FROM ETO_TRD_ALERT, GLCAT_CAT WHERE ETO_TRD_ALERT.FK_GLCAT_CAT_ID=GLCAT_CAT.GLCAT_CAT_ID AND ETO_TRD_ALERT.FK_GLUSR_USR_ID=:glusrid ORDER BY GLCAT_CAT_NAME";
$rslt = $dbh->createCommand($st);
$rslt->bindValue(":glusrid",$formid);
$dataReader=$rslt->query();
$offr=$dataReader->readAll();
//					$sth = GUReg->CheckDBError(__FILE__, __LINE__, $dbh, $st);

					$count = 0;

					$trd_message = '';
					$message1 = '';
					$eto_ofr = "";
					$ofr_typ = array(
						'A'	=>	'All',
						'B'	=>	'Buy',
						'S'	=>	'Sell',
						'O'	=>	'Biz'
						);

					$flag = 0;
					foreach($offr as $h) 
					{
						$count++;
						$eto_ofr = $h['ETO_OFR_TYP'];

						if ($flag) 
						{
							$message1 .= '<TD BGCOLOR="e0e0e0" CLASS="admintext1" WIDTH=50%>'.$h['GLCAT_CAT_NAME'].'</TD></TR>';
							$flag = 0;
						}
						else 
						{
							$message1 .='<TR>
							<TD BGCOLOR="e0e0e0" CLASS="admintext1" WIDTH=50%>'.
							$h['GLCAT_CAT_NAME'].'</TD>';
							$flag =1;
						}
					}

					if (!empty($count)) 
					{

					if (!empty($flag)) 
					{
						$message1 .= '<TD BGCOLOR="e0e0e0" CLASS="admintext1" WIDTH=50%>
						&nbsp;</TD></TR>';
					}
						$trd_message .= '<TR><TH BGCOLOR="e0e0e0" CLASS="admintext1" COLSPAN=2 ALIGN=CENTER>Subscribed to the following <FONT COLOR=BLUE>'.$count.'</FONT> categories for <FONT COLOR=BLUE>'.$ofr_typ[$eto_ofr].'</FONT> offers</TH></TR>'.$message1;
					}
					else 
					{
						$trd_message .= '<TR>
						<TD BGCOLOR="e0e0e0" CLASS="admintext1" COLSPAN=2 ALIGN=CENTER>Not Subscribed to Trade Alerts</TD></TR>'.$message1;

					}
// 
	$st = "SELECT GLUSR_STATUSHISTORY_APPROV, GLUSR_STATUSHISTORY_OLDAPPROV,
	TO_CHAR(GLUSR_STATUSHISTORY_DATE, 'Mon DD, yyyy HH24:MI:SS') || ' GMT' GLUSR_STATUSHISTORY_DATE,
	GL_EMP_NAME FROM GLUSR_STATUSHISTORY, GL_EMP
	WHERE GL_EMP.GL_EMP_ID=GLUSR_STATUSHISTORY.FK_GL_EMP_ID AND
	GLUSR_STATUSHISTORY.FK_GLUSR_USR_ID= :glusrid
	ORDER BY GLUSR_STATUSHISTORY.GLUSR_STATUSHISTORY_DATE DESC";
	$rslt = $dbh->createCommand($st);
	$rslt->bindValue(":glusrid",$formid);
	$dataReader=$rslt->query();
	$sth=$dataReader->readAll();
	
	$status_history = "";
	$app =array('A'=>'Approve','W'=>'Waiting','M'=>'Err. Disabled','D'=>'Disabled');
	$count = 0;
	
	foreach($sth as $sh) 
	{
		$count++;
		$status_history .= '
		<TR>
		<TD BGCOLOR="e0e0e0" CLASS="admintext1" width=5%>'.$count.'</TD>
		<TD BGCOLOR="f1f1f1" CLASS="admintext1">
		Status Changed on <B>'.$sh['GLUSR_STATUSHISTORY_DATE'].'</B>, From
		<B>'.$app{$sh{'GLUSR_STATUSHISTORY_OLDAPPROV'}}.' </B> To <B>'.$app{$sh{'GLUSR_STATUSHISTORY_APPROV'}}.'</B>
		By <B>'.$sh['GL_EMP_NAME'].'</B>.
		</TD>
		</TR>
		<TR><TD COLSPAN=2></TD></TR>';
	}
	
	if($count)
	{
		$status_history .= '<TR><TD BGCOLOR="e0e0e0" CLASS="admintext1" COLSPAN=2 ALIGN=CENTER>No Status History Exists</TD></TR>';
	}
	$full_name=$rec[0]['GLUSR_USR_FIRSTNAME'].' '.$rec[0]['GLUSR_USR_LASTNAME'];
	$title= "More Info Of $full_name";
	$heading="More Info Of $full_name";
	$heading1="Trade Alerts Subscribed";
	$heading2="Status History";
	$message=$user_info;
	$trdalerts=$trd_message;
	$stshistory=$status_history;
$temp_ob->userinfo_html($title,$heading,$heading1,$heading2,$message,$trdalerts,$stshistory);	
}

}
// 				else {
// 					print "Content-type: text/html\n\n";
// 					print "Sorry your request could not be processed, as the database could not be processed..<BR>";
// 				}
// 			}
// 			else {
// 				print "Content-type: text/html\n\n";
// 				print "Sorry your request could not be processed<BR>";
// 			}
// 		}
else 
{
	print "Content-type: text/html\n\n";
	print "Not Priviledged. Contact Admin <BR>";
}
				

?>