<script>

function nextField()
{

if(document.getElementById("region_name1").value.trim() =="")
{
alert("Please Fill Region Name");
return false;
}
	
}
</script>





<?php

	$html='';
	foreach($region as $key=>$value)
	{
	   $GL_STATE_NAME11=$value['GL_STATE_NAME'];
	}
	
	$rec=pg_fetch_array($sth_all);
	$rec=array_change_key_case($rec, CASE_UPPER);
	$LEAP_REGION_NAME=isset($rec['LEAP_REGION_NAME']) ? $rec['LEAP_REGION_NAME'] : '';
	$GL_STATE_NAME=isset($rec['GL_STATE_NAME']) ? $rec['GL_STATE_NAME'] : '';
	$LEAP_REGION_ID=isset($rec['LEAP_REGION_ID']) ? $rec['LEAP_REGION_ID'] : ''; 
	$mid=isset($_REQUEST['mid']) ? $_REQUEST['mid'] : '';
	$html .='<form name="editpopup" method="post" action="/index.php?r=admin_eto/ManageRegion/addregion&actioneditregion=yes&mid='.$mid.'" onsubmit="return nextField();">';
	$html .='<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="" align="center">';
	$html .= '<th style="text-align:center;font-family: arial;font-size: 14px;background-color:#eeffff" colspan="2">Update Region</th>';
	$html .='<tr>';
	$html .='<td class="intd" width="" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Region Name</b> </td>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">
	<input type="text" name="region_name1" id="region_name1" value="'.htmlentities($LEAP_REGION_NAME).'"><div id="regiondiv"></div> </td>';
	$html .='</tr>';
	$html .='<tr>';
	$html .='<td class="intd" width="" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>State Name</b> </td>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><select multiple  name="state_id[]" id="state_id" style="width: 500px; height:150px;>
	<option value="">Select</option>';
	
	while($rec=pg_fetch_array($sth_region))
	{
	$rec=array_change_key_case($rec, CASE_UPPER);
	if(in_array($rec['GL_STATE_NAME'],$GL_STATE_NAME11))
	{
	$html .= '<option value="'.$rec['GL_STATE_ID'].'" selected>'.$rec['GL_STATE_NAME'].'</option>';
	}
	else
	{
	$html .= '<option value="'.$rec['GL_STATE_ID'].'">'.$rec['GL_STATE_NAME'].'</option>';
	}
	}
	$html .='</select></td>';
	
	$html .='</tr>';
	$html .='<tr><td colspan="2" style="text-align:center;"><input type="submit" name="update" value="update"></td></tr>';
	$html .='</table>';
	$html .='<input type="hidden" name="region_id" value="'.$LEAP_REGION_ID.'">';
	$html .="</form>";
	echo $html;
	?>

