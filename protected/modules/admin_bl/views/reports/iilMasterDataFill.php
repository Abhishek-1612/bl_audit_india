<LINK HREF="/css/report.css" REL="STYLESHEET" TYPE="text/css">
<table width="90%" align="center">
<tr><td>
	<table width="100%" border="0"><tr>
	<td width="50%" align="center" bgcolor="#218aed"><a href="javascript:void(0);" style="font-size:16px;font-weight:bold; color:#fff;text-decoration:none;">ADD</a></td><td width="50%" align="center" bgcolor="#aad2f8"><a href="http://gladmin.intermesh.net/?r=admin_bl/reports/iilMasterDataUpdate" style="font-size:16px;font-weight:bold; color:#333;text-decoration:none;line-height:28px;">UPDATE</a></td>
	</tr></table>
</td></tr>
<?php
if($errorMsg)
{
	print "<tr><td><center>
		<font color='red' size=4><u>Please correct the following <b>ERRORS</b></u></font><br>
		<i><font size=3>$errorMsg</font></i></center></td></tr>";
}
?>
<tr><td><br><br>
<div style="margin:0px auto;width:100%">
<div style="float:left;width:45%;">
<form name="iilMasterFlagDataType" action="" method="post">

<table cellspacing="4" bgcolor="#eaeae">
<tr>
	<td>Cron/DB Oject/Table Name<font color="red" >*</font></td>
	<td>:</td>
	<td><input type="text" name="iilMasterDataTypeTableName" id="iilMasterDataTypeTableName"  value='<?php
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeTableName'])) {print $_REQUEST['iilMasterDataTypeTableName'];}
	?>'> </td>
</tr>
<tr>
	<td>Column Name<font color="red" >*</font></td>
	<td>:</td>
	<td> <input type="text" name="iilMasterDataTypeColumnName" id="iilMasterDataTypeColumnName"  value='<?php if($errorMsg && isset($_REQUEST['iilMasterDataTypeColumnName'])) {print $_REQUEST['iilMasterDataTypeColumnName'];}?>'></td>
</tr>
<tr>
	<td>Comment<font color="red" >*</font><br><i><font size=2>(Objective of Cron/DB Object/Column)</i></td>
	<td>:</td>
	<td> <input type="text" name="iilMasterDataTypeComment" id="iilMasterDataTypeComment"  value='<?php if($errorMsg && isset($_REQUEST['iilMasterDataTypeComment'])) {print $_REQUEST['iilMasterDataTypeComment'];}?>'></td>
</tr>
<tr>
	<td>Type<font color="red" >*</font></td>
	<td>:</td>
	<td> <select name="iilMasterDataTypeSelect" id="iilMasterDataTypeSelect">
	<option value="">---Select Type---</option>
	<option value="DB Object"
	<?php if($errorMsg && (isset($_REQUEST['iilMasterDataTypeSelect']) && $_REQUEST['iilMasterDataTypeSelect'] == 'DB Object')) {print " selected ";}?>
	>DB Object</option>
	<option value="CRON"
	<?php if($errorMsg && (isset($_REQUEST['iilMasterDataTypeSelect']) && $_REQUEST['iilMasterDataTypeSelect'] == 'CRON')) {print " selected ";}?>
	>Cron</option>
	<option value="Table"
	<?php if($errorMsg && (isset($_REQUEST['iilMasterDataTypeSelect']) && $_REQUEST['iilMasterDataTypeSelect'] == 'Table')) {print "selected ";}?>
	>Table</option>
	</select></td>
</tr>
<tr>
	<td>Description<br><i><font size=2>(For the objective of Cron/DB Object/Table(What?))</i></td>
	<td>:</td>
	<td align="left"> <textarea rows=4 cols=20 name="iilMasterDataTypeDesc" id="iilMasterDataTypeDesc"><?php if($errorMsg && isset($_REQUEST['iilMasterDataTypeDesc'])) {print $_REQUEST['iilMasterDataTypeDesc'];}?></textarea><br><i><font size=2>(*max 4000 Characters)</i></td>
</tr>
<tr>
	<td>Usage<br><i><font size=2>(For the objective of Cron/DB Object/Table(Why?))</i></td>
	<td>:</td>
	<td align="left"> <textarea rows=4 cols=20 name="iilMasterDataTypeUsage" id="iilMasterDataTypeUsage"><?php if($errorMsg && isset($_REQUEST['iilMasterDataTypeUsage'])) {print $_REQUEST['iilMasterDataTypeUsage'];}?></textarea><br><i><font size=2>(*max 4000 Characters)</i></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td> <input type="submit" name="iilMasterDataTypeSubmit" id="iilMasterDataTypeSubmit" value="SUBMIT"></td>
</tr>
</table>
</form>
</div>



<div style="float: right;width:54%">
<form name="iilMasterFlagData" action="" method="post">

<table cellspacing="4" bgcolor="#eaeae" >
<tr>
	<td>Select Column </td>
	<td>:</td>
	<td>

	<select id="iilMasterFlagDataFK" name="iilMasterFlagDataFK">
	<option name="" value="">------Select Cron/DB Object/Table(Column)------</option>
	<?php
	if($dataDDL)
	{
		foreach($dataDDL as $rec)
		{
			$id = $rec{'IIL_MASTER_DATA_TYPE_ID'};
			$tablename = $rec{'IIL_MASTER_DATA_TYPE_TABLE'};
			$columnname = $rec{'IIL_MASTER_DATA_TYPE_COLUMN'};
			print "<option name='tableopt' value='$id' ";
			if($errorMsg && (isset($_REQUEST['iilMasterFlagDataFK']) && $_REQUEST['iilMasterFlagDataFK'] == $id)) {print " selected ";}
			print ">$tablename($columnname)</option>";
		}
	}
	?>
	</select>
	</td>
</tr>
<tr>
	<td>Flag Value<font color="red" >*</font></td>
	<td>:</td>
	<td><input type="text" name="iilMasterDataValue" id="iilMasterDataValue"  value="<?php if($errorMsg && isset($_REQUEST['iilMasterDataValue'])) {print $_REQUEST['iilMasterDataValue'];}?>"></td>
</tr>
<tr>
	<td>Flag Value Text<font color="red" >*</font><br><i><font size=2>(Description of Flag Value)</i></td>
	<td>:</td>
	<td> <input type="text" name="iilMasterDataValuetext" id="iilMasterDataValuetext" value="<?php if($errorMsg && isset($_REQUEST['iilMasterDataValuetext'])) {print $_REQUEST['iilMasterDataValuetext'];}?>"></td>
</tr>

<tr>
	<td>Description<br><i><font size=2>(Detailed Description of Flag Value)</i></td>
	<td>:</td>
	<td> <textarea rows=4 cols=20 name="iilMasterDataDesc" id="iilMasterDataDesc"><?php if($errorMsg && isset($_REQUEST['iilMasterDataDesc'])) {print $_REQUEST['iilMasterDataDesc'];}?></textarea><br><i><font size=2> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (*max 200 Characters)</i></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td> <input type="submit" name="iilMasterDataSubmit" id="iilMasterDataSubmit" value="SUBMIT"></td>
</tr>
</table>
</form></div>
</div>
</td></tr></table>