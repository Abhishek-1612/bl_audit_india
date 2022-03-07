<style>
.button1 {
cursor: pointer;
-webkit-appearance: button;
background-color: #009DCC;
font-weight: bold;
height: 25px;
width: auto;
border: 1px solid #CCCCCC;
color: #FFFFFF;
} 
</style>
<script>
function Showeditdiv(region_id)
{

var xmlHttp=ajaxFunction();
   
		var obj='edit_div';
		
		
	
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					
					document.getElementById(obj).innerHTML =temp;
					
					
					
				}
				
			}
			var str='/index.php?r=admin_eto/ManageRegion/addregion/region_id/'+region_id+'/edit_popup/yes/actioneditregion/yes';
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}


}
function nextField()
{

if(document.getElementById("region_name1").value.trim() =="")
{
alert("Please Fill Region Name");
return false;
}

if(document.getElementById("state_id").value.trim() =="")
{
alert("Please Select State");
return false;
}
	
}
	
	
function nextField1()
	{
  
  
	
if(document.getElementById("regionname").value.trim() =="")
{
alert("Please Fill Region Name");
return false;
}

if(document.getElementById("region_id").value.trim() =="")
{
alert("Please Select State");
return false;
}

	
	
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
</script>
      


	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="40%" align="left">
	<th style="text-align:center;font-family: arial;font-size: 14px;background-color:#eeffff" colspan="4">Change Region Detail</th>
	<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Sn.</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Region Name</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>State Name</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b></b> </td>
	<tr>
	<?php
	$array_pool_id=array();
	$html='';
	$j=1;
	foreach($region as $key=>$value)
	{
	$GL_STATE_NAME=implode(" || ",$value['GL_STATE_NAME']);
	
	$LEAP_REGION_NAME=isset($value['LEAP_REGION_NAME']) ? $value['LEAP_REGION_NAME'] : '';
	$html .='<tr>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>'.$j.'<b></td>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">'.$LEAP_REGION_NAME.'</td>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">'.$GL_STATE_NAME.'</td>';

	
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><a href="#" onclick="Showeditdiv('.$key.')">Update</a></td>';
	
	$html .='</tr>';
	$j++;
	}
	$html .='</table>';
	echo $html;
	?>
<table align="center">
<tr>
<td>
<form name="addregionForm" id="addregionForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;" ACTION="/index.php?r=admin_eto/ManageRegion/addregion" onsubmit="return nextField1()">
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="" align="center">
	<th style="text-align:center;font-family: arial;font-size: 14px;background-color:#eeffff" colspan="2">Add New Region</th>
	<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">Region Name: </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;<input type="text" name="regionname" id="regionname">
	</td>
	</tr>
	<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">State Name: </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;<select multiple  name="region_id[]" id="region_id" style="width: 500px; height:150px;>
	<option value="">Select</option>
	<?php
	while($rec=pg_fetch_array($sth_region))
	{
	$rec=array_change_key_case($rec, CASE_UPPER);
	echo ' <option value="'.$rec['GL_STATE_ID'].'">'.$rec['GL_STATE_NAME'].'</option>';
	}
	
	?>
	
	
	</select>
	</td>
	</tr>
	<tr>
	<td colspan="2" style="text-align:center;">
	<?php
	echo '<div>'.$status.'</div>';
	?>
	</td>
	</tr>
	<tr>
	<td colspan="2" style="text-align:center;">
	<input class="button1" type="submit" value="ADD" name="submit">
	</td>
	</tr>
	</table>
	</form>
	</td>
	</tr>
	<tr>
        <td colspan="2">
        <div id="edit_div"></div>
        </td>
        </tr>
        </table>
        <br><br>
       <?php
echo '<div style=" margin-left: 1200px; margin-top: 1px;">'.$updated.'</div>';?>
       
	
    
	