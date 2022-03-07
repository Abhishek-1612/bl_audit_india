<?php
$loginPath='http://dev-gladmin.intermesh.net/index.php?r=admin_bl/reports/';
if(empty($_REQUEST['glusrID']))
{
?>
<script language="javascript">

function formSubmit()
{
	var glusrID=document.getElementById('glusrid').value;
	window.open('<?php echo $loginPath?>etoTestGlusr&modid=MY&glusrID='+glusrID);
	return false;
}
</script>

</head>
<body>
	<form name="testForm" method="post" action="" onsubmit="return formSubmit();">
	<table border="0" cell-padding="0" cell-spacing="0" style="padding:10px 0px 0px 10px;">
	<tr>
		<td> Enter Glusr ID: </td>
		<td><input type="text" name="glusrid" id="glusrid"></td>
		<td><input type="submit" value="Go" name="sendbutton"></td>
	</tr>
	</table>
</form>
</body>
</html>
<?php } ?>
<?php 
if(!empty($_REQUEST['glusrID']))
{
	$userID=$_REQUEST['glusrID'];
	$ob = new GlobalEtoNew;
	$ob->MyportalEnqalert($userID);
}
?>