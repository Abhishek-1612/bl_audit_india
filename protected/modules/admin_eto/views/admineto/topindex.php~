

<html>
<head><title>Global Admin</title>
<?php 
//my ($user_view,$user_add,$user_edit,$user_del,$user_download) = Gladmin_Admin->GetAdmPermission(__FILE__, __LINE__, $dbh, $emp_id,$cookie_mid);
//print "Content-type: text/html\n\n" if($cookie_mid eq '');
	$lvl_code = $data['lvl_code'];
	$cookie_mid = $moduleId;
	$emp_id = $empId;
?>
<script type="text/javascript">

function change() {
	parent.frames[2].location.href = "index-right.pl";
}

function change1() {
	parent.frames[1].location.href = "blank.html";
}

function changeRenew(emp_id) {
	window.parent.frames['right'].location="http://ipcadmin.intermesh.net/pcat-admin/admin-new/sp_renew.pl?action=autocookie&id="+emp_id;
	}

function changeIPC(emp_id) {

window.parent.frames['main'].location="/pcat_ipc_admin.html?emp_id="+emp_id;
window.parent.frames['right'].location="/cover_message.html";
}

function changeIMART(emp_id) {

window.parent.frames['main'].location="http://ipcadmin.intermesh.net/glpcat/pcat-admin/imartreport/imartreports_list.pl";
window.parent.frames['right'].location="http://ipcadmin.intermesh.net/glpcat/pcat-admin/imartreport/imartreports-right.pl";

}
</script>
</head>
<body bgcolor="#FFFFCA" marginwidth="0" marginheight = "5" leftmargin="0" topmargin="0" link="#800000" vlink="#800000" alink="#0000FF">
<table border="0" cellspacing="0" cellpadding="0" align="LEFT" vspace="0" hspace="0">
<tr>

        <td bgcolor="#ffffca" align="left"><span style="font-size:10px;font-weight:bold;">
	<?php if ($lvl_code < 1500)
	{ 
	if($cookie_mid == 118) { ?>
		&nbsp; <a href="admin_eto/eto-leftindex.pl" target="main" onclick="change();">ETO</a>&nbsp;
	<?php }	
	if($cookie_mid == 123) {	?>
		&nbsp;<a href="admin_tdr/tdr-leftindex.pl" target="main" onclick="change();">Tenders</a>&nbsp;
		<?php } 
		if($cookie_mid == 132) {	?>
		&nbsp;<a href="#"onclick="changeipc($emp_id);">PCAT IPC Admin</a>&nbsp;
		<?php } 
		if($emp_id == 1216 || $emp_id == 3037 || $emp_id == 58 || $emp_id == 3790 || $emp_id == 436 || $emp_id == 3421 || $emp_id == 3500 || $emp_id == 5262 || $emp_id == 3910 || $emp_id == 7598 || $emp_id == 12027 || $emp_id == 2497 || $emp_id == 10282 || $emp_id == 10023 || $emp_id == 19401 || $emp_id == 10697 || $emp_id == 13671) {	
			if($cookie_mid == 135){ ?>
				&nbsp;<a href="blank.html" target="main" onclick="changerenew($emp_id);">PCAT-Renewal</a>&nbsp;
			<?php 
			}
	} if($cookie_mid == 129) { ?>
			&nbsp;<a href="admin_m4t/media4trade-left.pl" target="main" onclick="change();">Media 4 Trade</a>&nbsp;
	<?php } 
	 if($cookie_mid == 126) { ?>
			
			&nbsp;<a href="#" onclick="changeimart($emp_id);">IMART-Reports</a>&nbsp;
	<?php } 
	}
	else
	{
		if($emp_id == 8201)
		{ 
		if($cookie_mid == 135) {?>
			<a href="blank.html" target="main" onclick="changerenew($emp_id);">PCAT-Renewal</a>&nbsp;
		<?php } 
		if($cookie_mid == 132){ ?>
		<a href="#"onclick="changeipc($emp_id);">PCAT IPC Admin</a>&nbsp;
		<?php }
	} }?>
	&nbsp;<a href="index_admin.pl?action=logoff" target="_top">Log  Out</a>&nbsp;</b></font></td>
      </tr>
    </table>
  </body>
</html>