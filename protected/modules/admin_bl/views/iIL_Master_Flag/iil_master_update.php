<table width="90%" align="center"  border="0">    
<tr>
    <td width="50%" align="center" bgcolor="#aad2f8"><a href="index.php?r=admin_bl/IIL_Master_Flag/add/" style="font-size:16px;font-weight:bold; color:#333;text-decoration:none;width:100%;">ADD</a></td>
 <td width="50%" align="center" bgcolor="#218aed"><span style="font-size:16px;font-weight:bold; color:#fff;text-decoration:none;line-height:28px;">UPDATE</span>
 </td>
</tr>
</table>
<br>	
      
<?php
	  $errorMsg=$data['errorMsg'];
	  $sthfetch1=$data['sthfetch1'];
	  $recfetch2=$data['recfetch2'];
	  $recfetch=$data['recfetch'];
	  $REC=$data['REC'];
	  $sth1=$data['sth1'];
	  $status_update=$data['status_update'];
          if($status_update!='')
	  {
		echo '<div><center>
		'.$status_update.'</center></div>';
	  }
	  if($errorMsg!='')
	  {
	  echo '<div><center><font color="red" size=3>'.$errorMsg.'</font></center></div>';
	  }	
          echo '<br><form name="iilMaster" method="post" action="">';          
	 echo '<table bgcolor="#eaf7ff" border="1" width="90%" align="center" valign="top">
<tr><td colspan="2">Select Object: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id="iilMasterSelect" name="iilMasterSelect">
	  <option name="" value="">------Select Cron/DB Object/Table(Column)------</option>';	
          while (($rec = oci_fetch_assoc($sth1))!=false)
          {  
		$id = $rec['IIL_MASTER_DATA_TYPE_ID'];
		$tablename = $rec['IIL_MASTER_DATA_TYPE_TABLE'];
		$columnname = $rec['IIL_MASTER_DATA_TYPE_COLUMN'];
		echo '<option name="tableopt" value="'.$id.'"';
		if((isset($_REQUEST['iilMasterdataType']) &&  ($_REQUEST['iilMasterdataType'] == $id)) || (isset($_REQUEST['iilMasterSelect']) && $_REQUEST['iilMasterSelect'] == $id)||(isset($_REQUEST['iilMasterdataFK']) &&  ($_REQUEST['iilMasterdataFK'] == $id))) { echo "selected";}
		echo '>'.$tablename.'('.$columnname.')'.'</option>';
          }
          echo "</select>";
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="FETCH" name="iilMasterFetch" id="iilMasterFetch">';
echo '</tr>';

	echo '<tr>
	<td width="45%">';
	  $y='';
	  if(isset($_REQUEST['iilMasterSelect']) && $_REQUEST['iilMasterSelect'])
	      $y= $_REQUEST['iilMasterSelect'];
	  else  if(isset($_REQUEST['iilMasterdataType']) && $_REQUEST['iilMasterdataType'])
	      $y= $_REQUEST['iilMasterdataType'];
	
	  echo '<input type="hidden" name="iilMasterdataType" id="iilMasterdataType" value="'.$y.'">
	  <table cellspacing="4" bgcolor="#eaf7ff" >
	  <tr>
	  </tr>
	  <tr>
	  <td>Comment<font color="red" >*</font><br><i><font size=2>(Objective of Cron/DB Object/Column)</i></td>
	  <td>:</td>
	  <td> <input type="text" name="iilMasterDataTypeComment" id="iilMasterDataTypeComment" value="';
	  $recfetch['IIL_MASTER_DATA_TYPE_COMMENTS']=isset($recfetch['IIL_MASTER_DATA_TYPE_COMMENTS']) ? $recfetch['IIL_MASTER_DATA_TYPE_COMMENTS'] : '';
	  $recfetch['IIL_MASTER_DATA_TYPE_TAB_DESC']=isset($recfetch['IIL_MASTER_DATA_TYPE_TAB_DESC']) ? $recfetch['IIL_MASTER_DATA_TYPE_TAB_DESC'] : '';
	  $recfetch['IIL_MASTER_DATA_TYPE_TAB_USAGE']=isset($recfetch['IIL_MASTER_DATA_TYPE_TAB_USAGE']) ? $recfetch['IIL_MASTER_DATA_TYPE_TAB_USAGE'] : '';
	  if($errorMsg && isset($_REQUEST['iilMasterDataTypeComment']) && !empty($_REQUEST['iilMasterDataTypeComment'])) {echo $_REQUEST['iilMasterDataTypeComment'];}
	  else	{ echo $recfetch['IIL_MASTER_DATA_TYPE_COMMENTS'];}
	  echo '"></td>
	  </tr>
	  <tr>
	  <td>Type<font color="red" >*</font></td>
	  <td>:</td>
	  <td> <select name="iilMasterDataTypeSelect" id="iilMasterDataTypeSelect">
	  <option value="">---Select Type---</option>
	  <option value="DB Object" ';
	  if(isset($recfetch['IIL_MASTER_DATA_TYPE_TYPE']) && $recfetch['IIL_MASTER_DATA_TYPE_TYPE'] == 'DB Object') { echo "selected";}
	  echo '>DB Object</option>
	  <option value="CRON" ';
	  if(isset($recfetch['IIL_MASTER_DATA_TYPE_TYPE']) && $recfetch['IIL_MASTER_DATA_TYPE_TYPE'] == 'CRON') { echo "selected";}
	  echo '>Cron</option>
	  <option value="Table" '; 
	  if(isset($recfetch['IIL_MASTER_DATA_TYPE_TYPE']) && $recfetch['IIL_MASTER_DATA_TYPE_TYPE'] == 'Table') { echo "selected";}
	  echo '>Table</option>
	  </select</td>
	  </tr>
	  <tr>
	  <td>Description<br><i><font size=2>(For the objective of Cron/DB Object/Table(What?))</i></td>
	  <td>:</td>
	  <td> <textarea rows=4 cols=20 name="iilMasterDataTypeDesc" id="iilMasterDataTypeDesc" >';
	  if($errorMsg && isset($_REQUEST['iilMasterDataTypeDesc']) && $_REQUEST['iilMasterDataTypeDesc']) {echo $_REQUEST['iilMasterDataTypeDesc'];}
	  else {echo $recfetch['IIL_MASTER_DATA_TYPE_TAB_DESC'];}
	  echo '</textarea><br><i><font size=2> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (*max 4000 Characters)</i></td>
	  </tr>
	  <tr>
	  <td>Usage<br><i><font size=2>(For the objective of Cron/DB Object/Table(Why?))</i></td>
	  <td>:</td>
	  <td> <textarea rows=4 cols=20 name="iilMasterDataTypeUsage" id="iilMasterDataTypeUsage" >';
	  if($errorMsg && isset($_REQUEST['iilMasterDataTypeUsage']) && $_REQUEST['iilMasterDataTypeUsage']) {echo $_REQUEST['iilMasterDataTypeUsage'];}
	  else{echo $recfetch['IIL_MASTER_DATA_TYPE_TAB_USAGE'];}
	  echo '</textarea><br><i><font size=2> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (*max 4000 Characters)</i></td>
	  </tr>
	  <tr>
	  <td></td>
	  <td></td>
	  <td> <input type="submit" name="iilMasterDataTypeUpdate" id="iilMasterDataTypeUpdate" value="UPDATE"></td>
	  </tr>
	  </table>
	  </form>
	 </td>
<td width="55%">
	  <form name="iilMasterFlagData" action="" method="post">
	  <table cellspacing="4" bgcolor="#eaf7ff" >
	  <tr>
	  <td>Flag Value<font color="red" >*</font></td>
	  <td>:</td>
	  <td>';
	  $x='';
	  if(isset($_REQUEST['iilMasterSelect']) && $_REQUEST['iilMasterSelect'])
	  $x= $_REQUEST['iilMasterSelect'];
	  else  if(isset($_REQUEST['iilMasterdataFK']) && $_REQUEST['iilMasterdataFK'])
	  $x= $_REQUEST['iilMasterdataFK'];
	  $z='';
	  $z=isset($REC['IIL_MASTER_DATA_ID']) ? $REC['IIL_MASTER_DATA_ID'] : '';
	  echo '<input type="hidden" name="iilMasterdataFK" id="iilMasterdataFK" value="'.$x.'">
	  <input type="hidden" name="iilMasterDataId" id="iilMasterDataId" value="'.$z.'">
	  <select id="iilMasterFlagDataSelectFV" name="iilMasterFlagDataSelectFV">
	  <option name="" value="">------Select Flag Value------</option>';
	  if((isset($_REQUEST['iilMasterSelect']) && isset($_REQUEST['iilMasterSelect']) && $_REQUEST['iilMasterSelect']) or isset($REC['IIL_MASTER_DATA_ID']))
	  {       if(isset($sthfetch1))
	      {
		  while (($rec1 = oci_fetch_assoc($sthfetch1))!=false)
		  {  
			  $fvname = $rec1['IIL_MASTER_DATA_VALUE'];
			  echo '<option name="tableoptcn" value="'.$fvname.'"';
			  if($errorMsg or (isset($_REQUEST['iilMasterFlagDataSelectFV']) && $_REQUEST['iilMasterFlagDataSelectFV'] == $fvname)){echo 'selected';}
			  echo '>'.$fvname.'</option>';
		  }
	      }
		  
	  }
	  echo '</select>';
	  
		  
	  echo '<input type="submit" value="SHOW" name="iilMasterDataShow" id="iilMasterDataShow"><input type="text" name="iilMasterDataValue" id="iilMasterDataValue" value="';
	  if($errorMsg && isset($_REQUEST['iilMasterDataValue']) &&$_REQUEST['iilMasterDataValue']) {echo $_REQUEST['iilMasterDataValue'];}
	  echo '"><br><br></td>
	  </tr>

	  <tr>
	  <td>Flag Value Comment<font color="red" >*</font><br><i><font size=2>(Description of Flag Value)</i></td>
	  <td>:</td>
	  <td> <input type="text" name="iilMasterDataValuetext" id="iilMasterDataValuetext" value="';
	    
	    $recfetch2['IIL_MASTER_DATA_VALUE_TEXT']=isset($recfetch2['IIL_MASTER_DATA_VALUE_TEXT']) ? $recfetch2['IIL_MASTER_DATA_VALUE_TEXT'] : '';
	    $recfetch2['IIL_MASTER_DATA_VALUE_LRG_TEXT']=isset($recfetch2['IIL_MASTER_DATA_VALUE_LRG_TEXT']) ? $recfetch2['IIL_MASTER_DATA_VALUE_LRG_TEXT'] : '';
		  if($errorMsg && isset($_REQUEST['iilMasterDataValuetext']) && $_REQUEST['iilMasterDataValuetext']) {echo $_REQUEST['iilMasterDataValuetext'];}
		  else {echo $recfetch2['IIL_MASTER_DATA_VALUE_TEXT'];}
		  echo '"></td>
	  </tr>';

	  echo '
	  <tr>
	  <td>Description<br><i><font size=2>(Detailed Description of Flag Value)</i></td>
	  <td>:</td>
	  <td> <textarea rows=4 cols=20 name="iilMasterDataDesc" id="iilMasterDataDesc" >';
	  if($errorMsg && isset($_REQUEST['iilMasterDataDesc']) && $_REQUEST['iilMasterDataDesc']) {echo $_REQUEST['iilMasterDataDesc'];}
	  else {echo $recfetch2['IIL_MASTER_DATA_VALUE_LRG_TEXT'];}


	  echo '</textarea><br><i><font size=2> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (*max 200 Characters)</i></td>
	  </tr>
	  <tr>
	  <td>Status</td>
           <td>:</td>
	  <td><select  style="width:100px;" name="isactive"  id="isactive">';
           
               if(isset($recfetch2['IIL_MASTER_DATA_IS_ACTIVE']) && ($recfetch2['IIL_MASTER_DATA_IS_ACTIVE']==0)){
                echo '<option value="-1">Enable</option><option value="0" Selected>Disable</option>';
                }else {
                   echo '<option value="-1" Selected>Enable</option><option value="0" >Disable</option>';
               }
            
          
         echo '</select></td></tr><tr>
         <td></td>
           <td></td>
	  <td> <input type="submit" name="iilMasterDataUpdate" id="iilMasterDataUpdate" value="UPDATE"></td>
	  </tr>
	  </table></td></tr>          
';

	  echo '</form></table>';
?>