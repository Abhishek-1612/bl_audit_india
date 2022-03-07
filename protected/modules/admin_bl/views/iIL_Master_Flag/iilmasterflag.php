<?php $this->pageTitle=Yii::app()->name . ' - IIL Master Flag Report'; ?>
<!--google analytics async code start-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28761981-2']);
  _gaq.push(['_setDomainName', '.intermesh.net']);
  _gaq.push(['_setSiteSpeedSampleRate', 10]);
  _gaq.push(['_trackPageview','<?php echo $_SERVER['REQUEST_URI'];?>']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!--google analytics async code end-->

<div STYLE="font-family: arial; font-size: 20px; font-weight: bold; color:#8A0829;background-color:#F7F8E0;text-align:center">Master Flag Data Value</div>

<div STYLE="font-family: arial; font-size: 15px; color:#8A0829;background-color:#F7F8E0;text-align:right">
<?php if($user_add){ ?> <a href="/index.php?r=admin_bl/IIL_Master_Flag/add/">Add Record</a><?php }?> &nbsp;&nbsp;&nbsp;&nbsp;
<?php if($user_edit){ ?> <a href="/index.php?r=admin_bl/IIL_Master_Flag/edit/">Update Record</a><?php }?>

</div>
<div STYLE="font-family: arial; font-size: 20px; font-weight: bold; color:#8A0829;background-color:#F7F8E0;">
<form action="" method="POST">
<table width="100%">
<tr>
<td align="center"><select id="tablename" name="tablename"><option name="">--------select--------</option>
<?php

{
	$tablename_type=array(1=>'Table',2=>'Procedure',3=>'Cron',4=>'DB Object');
while(($rec = oci_fetch_array($dataDDL, OCI_ASSOC+OCI_RETURN_NULLS)) != false)
	{
       
		$tablename = $rec['IIL_MASTER_DATA_TYPE_TABLE'];
		$table_type = $rec['TABLE_TYPE'];
		$rownum = $rec['RN'];
		if($rownum==1)
		{
			print "<optgroup label=".$tablename_type{$table_type}.">";
		}
		print "<option name='tableopt' value='$tablename'";
		if(isset($_REQUEST['tablename']) && $tablename == $_REQUEST['tablename']){print " selected";}
		print ">$tablename</option>";
		if($rownum==$rec{'TOTRN'}){print "</optgroup>";}
	}
}
?>

</select>

&nbsp;&nbsp;<input type="submit" name="submit" value="submit">
</td>
</tr>
</table>
</form>
</div>
<?php
if($tabledata)
{
     print "<table  width='100%' align='center'>
			<tr style='font-weight:bold'>
			<th align='center' bgcolor='#ccccff'>Table Name</td>
			<th align='center' bgcolor='#ccccff'>Column Name</td>
			<th align='center' bgcolor='#ccccff'>Comments</td>
			<th align='center' bgcolor='#ccccff'>Flag</td>
			<th align='center' bgcolor='#ccccff'>Flag Value Text</td>
                        <th align='center' bgcolor='#ccccff'>Status</td>
			</tr>";
   
	while(($row = oci_fetch_array($tabledata, OCI_ASSOC+OCI_RETURN_NULLS)) != false)
	{          
          
		print "<tr>
		<td bgcolor='#eaeae'  align='left'>".$row['IIL_MASTER_DATA_TYPE_TABLE']."</td>
		<td bgcolor='#eaeae'  align='left'>".$row['IIL_MASTER_DATA_TYPE_COLUMN']."</td>
		<td bgcolor='#eaeae'  align='left'>".$row['IIL_MASTER_DATA_TYPE_COMMENTS']."</td>
		<td bgcolor='#eaeae'  align='center'>".$row['IIL_MASTER_DATA_VALUE']."</td>
		<td bgcolor='#eaeae'  align='left'>".$row['IIL_MASTER_DATA_VALUE_TEXT']."</td>
                <td bgcolor='#eaeae'  align='left'>".$row['STATUS']."</td>     
		</tr>
		";
	}
	print "</table>";
}
?>

