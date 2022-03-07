
	<style>

	</style>
	<script type="text/javascript">
	function Showeditdiv(pool_id)
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
			var str='/index.php?r=admin_eto/ManagePool/editpool/pool_id/'+pool_id+'/edit_popup/yes/';
		
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}

	}
	
	
	
	
	
	
function nextField(pool_id)
	{
	var xmlHttp=ajaxFunction();
   
		var obj='check_poolname';
		
		var poolname=document.getElementById("poll_name1").value;
		
	
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					
					document.getElementById(obj).innerHTML = '<B style="color:green;">'+temp;
					document.getElementById(obj).innerHTML = '<B style="color:red;">'+temp;
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/updatecheck/poolname/'+poolname+'/pool_id/'+pool_id+'/check/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
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
	function nextField1()
	{
	
	if(document.getElementById("poll_name1").value.trim() =="")
	{
	alert("Please Fill Pool Name");
	return false;
	}
	
	if(document.getElementById("check_poolname").innerHTML =='<b style="color:red;">&nbsp;&nbsp;&nbsp;&nbsp;Name Already Exist</b>')
	{
	alert("Name Already Exist");
	return false;
	}
	if(document.getElementById("grp1").value.length ==0 && document.getElementById("cat1").value.length ==0 && document.getElementById("mcat1").value.length ==0)
	{
	alert("Please Select Atleast One Group or Category or Mcat from List");
	return false;
	}
	
	if(document.getElementById("check_category").innerHTML =='<b style="color:red;">Already Exist</b>' || document.getElementById("check_mcat1").innerHTML =='<b style="color:red;">Already Exist</b>' || document.getElementById("check_group").innerHTML =='<b style="color:red;">Already Exist</b>')
	{
	alert("Mapping Already Exist");
	return false;
	}

	}
	function checkgroup(grp_id,pool_id)
	{
	
	var xmlHttp=ajaxFunction();
        var grp_id1=grp_id.value;
		var obj='check_group';
		
		
	
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					 
					if(temp == 'Already Exist')
					{
					alert('This mapping already Exist');
					document.getElementById(obj).innerHTML = '<B style="color:red;">'+temp;
					
					} 
					else
					{
					document.getElementById(obj).innerHTML ='';
					}
					
					
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/updatecheck/grp_id/'+grp_id1+'/pool_id/'+pool_id+'/check_grp/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}
	
function checkcat(cat_id,pool_id)
	{
	
	var xmlHttp=ajaxFunction();
        var cat_id1=cat_id.value;
        var obj='check_category';
        
	
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					
					
					if(temp == 'Already Exist')
					{
					alert('This mapping already Exist');
					document.getElementById(obj).innerHTML = '<B style="color:red;">'+temp;
					} 
					else
					{
					document.getElementById(obj).innerHTML ='';
					}
					
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/updatecheck/cat_id/'+cat_id1+'/pool_id/'+pool_id+'/check_cat/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}
	
function addoption(cat_id)
{

var x = document.getElementById("cat1");
var option = document.createElement("option");
option.text = cat_id.options[cat_id.selectedIndex].text;
option.value=cat_id.value;
x.add(option, x[0]);

}

	
function addoptionmcat(mcat_id)
{

var x = document.getElementById("mcat1");
var option = document.createElement("option");
option.text = mcat_id.options[mcat_id.selectedIndex].text;
option.value=mcat_id.value;
x.add(option, x[0]);

}
	
function checkmcat(mcat_id,pool_id)
	{
	
	var xmlHttp=ajaxFunction();
        var mcat_id1=mcat_id.value;
		var obj='check_mcat1';
		

		
	
		if(xmlHttp)
		{
			xmlHttp.onreadystatechange=function()
			{
				if(xmlHttp.readyState==4)
				{
					var temp=xmlHttp.responseText;
					if(temp == 'Already Exist')
					{
					alert('This mapping already Exist');
					document.getElementById(obj).innerHTML = '<B style="color:red;">'+temp;
					
					} 
					else
					{
					document.getElementById(obj).innerHTML ='';
					}
					
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/updatecheck/mcat_id/'+mcat_id1+'/pool_id/'+pool_id+'/check_mcat/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}
	
	
	
function catselect()
	{
	var xmlHttp=ajaxFunction();
   
		var obj='check_catname';
		
		var catname=document.getElementById("cattext").value;
	
	
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
			var str='index.php?r=admin_eto/ManagePool/addpool/catname/'+catname+'/cat_check/yes/popup/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}	
	
	
function mcatselect()
	{
	var xmlHttp=ajaxFunction();
   
		var obj='check_mcatname';
		
		var mcatname=document.getElementById("mcattext").value;
	
	
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
			var str='index.php?r=admin_eto/ManagePool/addpool/mcatname/'+mcatname+'/mcat_check/yes/popup/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}	
		
	</script>
	<?php
	echo $updated;
	?>
	<table width="100%">
	<tr>
	<td width="60%" valign="top">
	<div style=" margin-left: 1px; margin-top: 1px;">
	
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="60%" align="left">
	<tr>
	<td class="intd" width="" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>S.N.</b> </td>
	<td class="intd" width="" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Pool Name</b> </td>
	<td class="intd" width="" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Industry</b> </td>
	<td class="intd" width="" style="text-align:center;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Edit</b> </td>
	<tr>
	<?php
	$array_pool_id=array();
	$html='';
	$j=1;
	foreach($pool as $key=>$value)
	{
	$industryName=implode(" || ",$value['Industry_Name']);
	$html .='<tr>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>'.$j.'<b></td>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">'.$value['Pool_Name'].'</td>';
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">'.$industryName.'</td>';
// 	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><a href="#" onclick="javascript:window.open(\'/index.php?r=admin_eto/ManagePool/editpool/pool_id/'.$key.'/edit_popup/yes/\',\'_blank\',\'width=900, height=800\');">Edit</a></td>';
	
	$html .='<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><a href="#" onclick="Showeditdiv('.$key.')">Update</a></td>';
	$html .='</tr>';
	$j++;
	}
	$html .='</table></div>';
	echo $html;
	echo '<div id ="edit_poup" style=" margin-left: 800px; margin-top: 1px;"></div>';
	?>
	</td>
  <td width="40%" valign="top">
  <div id="edit_div"></div></td></tr></table>
	