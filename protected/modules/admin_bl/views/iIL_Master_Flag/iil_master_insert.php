<table width="90%" align="center"  border="0">
<tr>	
 <td width="50%" align="center" bgcolor="#218aed"><span style="font-size:16px;font-weight:bold; color:#fff;text-decoration:none;">ADD</span></td>
 <td width="50%" align="center" bgcolor="#aad2f8"><a href="index.php?r=admin_bl/IIL_Master_Flag/edit/" style="font-size:16px;font-weight:bold; color:#333;text-decoration:none;line-height:28px;width:100%;">UPDATE</a>
 </td>
</tr>
</table><br>

    <?php
        $errorMsg=$data['errorMsg'];
        $sth_dtype=$data['sth_dtype'];
        $status_update=$data['status_update'];
        if($status_update!='')
	{
		echo '<div><center>'.$status_update.'</center></div>';
	}
        if($errorMsg!='')
	{
		echo '<div><center><font color="red" size=3>'.$errorMsg.'</font></center></div>';
	}
	
	echo '<br><br>
            
<table bgcolor="#eaf7ff" border="1" width="90%" align="center" valign="top">
	<tr>
	<td width="45%">	
	<form name="iitMasterFlagDataType" action="" method="post">
	<table cellspacing="4" bgcolor="#eaf7ff" border=0  valign="top">
	<tr>
	<td>Cron/DB Oject/Table Name<font color="red" >*</font></td>
	<td>:</td>
	<td><input type="text" name="iilMasterDataTypeTableName" id="iilMasterDataTypeTableName"  value="';
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeTableName']) && $_REQUEST['iilMasterDataTypeTableName'])
	echo $_REQUEST['iilMasterDataTypeTableName'];	echo '"></td>
	</tr>
	<tr>
	<td>Column Name<font color="red" >*</font></td>
	<td>:</td>
	<td> <input type="text" name="iilMasterDataTypeColumnName" id="iilMasterDataTypeColumnName"  value="';
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeColumnName']) && $_REQUEST['iilMasterDataTypeColumnName'])
	  echo $_REQUEST['iilMasterDataTypeColumnName'];
	
	echo '"></td>
	</tr>
	<tr>
	<td>Comment<font color="red" >*</font><br><i><font size=2>(Objective of Cron/DB Object/Column)</i></td>
	<td>:</td>
	<td> <input type="text" name="iilMasterDataTypeComment" id="iilMasterDataTypeComment"  value="';
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeComment']) && $_REQUEST['iilMasterDataTypeComment'])
	  echo $_REQUEST['iilMasterDataTypeComment'];
	
	echo '"></td>
	</tr>
	<tr>
	<td>Type<font color="red" >*</font></td>
	<td>:</td>
	<td> <select name="iilMasterDataTypeSelect" id="iilMasterDataTypeSelect">
	<option value="">---Select Type---</option>
	<option value="DB Object" ';
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeSelect']) && $_REQUEST['iilMasterDataTypeSelect']== 'DB Object')
	echo "selected";
	
	echo '>DB Object</option>
	<option value="CRON" '; 
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeSelect']) && $_REQUEST['iilMasterDataTypeSelect'] == 'CRON') 
	echo "selected";
	
	echo '>Cron</option>
	<option value="Table" ';
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeSelect']) && $_REQUEST['iilMasterDataTypeSelect'] == 'Table')
	echo 'selected';
	
	echo '>Table</option>
	</select></td>
	</tr>
	<tr>
	<td>Description<br><i><font size=2>(Objective of Cron/DB Object/Table)</i></td>
	<td>:</td>
	<td align="Left"> <textarea rows=4 cols=25 name="iilMasterDataTypeDesc" id="iilMasterDataTypeDesc" >';
	
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeDesc']) && $_REQUEST['iilMasterDataTypeDesc'])
	  echo $_REQUEST['iilMasterDataTypeDesc'];
	
	echo '</textarea><br><i><font size=2>(*max 4000 Characters)</i></td>
	</tr>
	<tr>
	<td>Usage<br><i><font size=2>(Objective of Cron/DB Object/Table)</i></td>
	<td>:</td>
	<td align="Left"> <textarea rows=4 cols=25 name="iilMasterDataTypeUsage" id="iilMasterDataTypeUsage">';
	
	if($errorMsg && isset($_REQUEST['iilMasterDataTypeUsage']) && $_REQUEST['iilMasterDataTypeUsage']) echo $_REQUEST['iilMasterDataTypeUsage'];
	
	echo '</textarea><br><i><font size=2>(*max 4000 Characters)</i></td>
	</tr>
	<tr>
	<td></td>
	<td></td>
	<td> <input type="submit" name="iilMasterDataTypeSubmit" id="iilMasterDataTypeSubmit" value="SUBMIT"></td>
	</tr>
	</table>
	</form>
</td>
<td width="55%">	
	<form name="iilMasterFlagData" action="" method="post">
	<table cellspacing="4" bgcolor="#eaf7ff" border="0" valign="top">
	<tr>
	<td>Select Column </td>
	<td>:</td>
	<td>';

	echo '<select id="iilMasterFlagDataFK" name="iilMasterFlagDataFK" >
	<option name="" value="">------Select Cron/DB Object/Table(Column)------</option>';
	   
         while ($rec = oci_fetch_assoc($sth_dtype))
         {  
		$id = $rec['IIL_MASTER_DATA_TYPE_ID'];
		$tablename = $rec['IIL_MASTER_DATA_TYPE_TABLE'];
		$columnname = $rec['IIL_MASTER_DATA_TYPE_COLUMN'];
		echo '<option name="tableopt" value="'.$id.'"';
		
		if($errorMsg && isset($_REQUEST['iilMasterFlagDataFK']) && $_REQUEST['iilMasterFlagDataFK'] == $id) echo "selected";
		
		echo '>'.$tablename.'('.$columnname.')'.'</option>';
         }
         echo '</select>';

         
	echo '</td>
	</tr>
	<tr>
	<td>Flag Value<font color="red" >*</font></td>
	<td>:</td>
	<td><input type="text" name="iilMasterDataValue" id="iilMasterDataValue"  value="';
		if($errorMsg && isset($_REQUEST['iilMasterDataValue']) && $_REQUEST['iilMasterDataValue']) echo $_REQUEST['iilMasterDataValue'];
		echo '"></td>
	</tr>
	<tr>
	<td>Flag Value Text<font color="red" >*</font><br><i><font size=2>(Description of Flag Value)</i></td>
	<td>:</td>
	<td> <input type="text" name="iilMasterDataValuetext" id="iilMasterDataValuetext" value="';
		if($errorMsg && isset($_REQUEST['iilMasterDataValuetext']) && $_REQUEST['iilMasterDataValuetext']) echo $_REQUEST['iilMasterDataValuetext'];
		echo '"></td>
	</tr>
	<tr>
	<td>Description<br><i><font size=2>(Detailed Description of Flag Value)</i></td>
	<td>:</td>
	<td> <textarea rows=4 cols=20 name="iilMasterDataDesc" id="iilMasterDataDesc">';
	if($errorMsg && isset($_REQUEST['iilMasterDataDesc']) && $_REQUEST['iilMasterDataDesc']) echo $_REQUEST['iilMasterDataDesc'];

	echo '</textarea><br><i><font size=2>(*max 200 Characters)</i></td>
	</tr><tr>
	  <td>Status</td>
           <td>:</td>
	  <td><select  style="width:100px;" name="isactive"  id="isactive">';
           
               if(isset($recfetch2['IIL_MASTER_DATA_IS_ACTIVE']) && ($recfetch2['IIL_MASTER_DATA_IS_ACTIVE']==0)){
                echo '<option value="-1">Enable</option><option value="0" Selected>Disable</option>';
                }else {
                   echo '<option value="-1" Selected>Enable</option><option value="0" >Disable</option>';
               }
            
          
         echo '</select></td></tr>
	<tr>
	<td></td>
	<td></td>
	<td> <input type="submit" name="iilMasterDataSubmit" id="iilMasterDataSubmit" value="SUBMIT"></td>
	</tr>
	</table>
	</form>
   </td></tr>
   </table>

	
	';
 ?>