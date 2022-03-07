<link href="/css/report.css" rel="stylesheet" type="text/css">
	<style>

	</style>
	<script type="text/javascript">
	function nextField()
	{
	var xmlHttp=ajaxFunction();
   
		var obj='check_poolname';
		
		var poolname=document.getElementById("poolname").value;
		
	
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
			var str='index.php?r=admin_eto/ManagePool/addpool/poolname/'+poolname+'/check/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}
	
function checkgroup(grp_id)
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
					document.getElementById(obj).innerHTML = '';
					}
					
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/addpool/grp_id/'+grp_id1+'/check_grp/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}	
function checkcat(cat_id)
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
					document.getElementById(obj).innerHTML = '';
					}
					
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/addpool/cat_id/'+cat_id1+'/check_cat/yes/';
			
			
			xmlHttp.open("GET",str,true);
			xmlHttp.send(null);
			return false;
		}
	}	
	
function checkmcat(mcat_id)
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
					document.getElementById(obj).innerHTML = '';
					}
					
					
					
				}
				
			}
			var str='index.php?r=admin_eto/ManagePool/addpool/mcat_id/'+mcat_id1+'/check_mcat/yes/';
			
			
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
			var str='index.php?r=admin_eto/ManagePool/addpool/mcatname/'+mcatname+'/mcat_check/yes/';
			
			
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
			var str='index.php?r=admin_eto/ManagePool/addpool/catname/'+catname+'/cat_check/yes/';
			
			
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
	
	if(document.getElementById("poolname").value.trim() =="")
	{
	alert("Please Fill Pool Name");
	return false;
	}
	
	var cat =  document.getElementById('cat');
	var grp=document.getElementById('grp');
	var mcat=document.getElementById('mcat');
	  if ((typeof(grp) != 'undefined' && grp != null) && (cat == null) && (mcat == null))
    {
	    if(grp.value.length ==0)
	    {
	    alert("Please Select Atleast One Group");
	    return false;
	    }
	  } 
	  else if ((typeof(grp) != 'undefined' && grp != null) && (typeof(cat) != 'undefined' && cat != null) && (mcat == null) )
	  {
	  if(document.getElementById("grp").value.length ==0 && document.getElementById("cat").value.length ==0)
	    {
	  
	  alert("Please Select Atleast One Group or Category");
	  return false;
	  }
	  }
	  else if ((typeof(grp) != 'undefined' && grp != null) && (cat == null) && (typeof(mcat) != 'undefined' && mcat != null))
	  {
	  if(document.getElementById("grp").value.length ==0 && document.getElementById("mcat").value.length ==0)
	    {
	  
	     alert("Please Select Atleast One Group or Mcat");
	     return false;
	    }
	  }
	  else
	  {
	   if(document.getElementById("grp").value.length ==0 && document.getElementById("mcat").value.length ==0 && document.getElementById("cat").value.length ==0)
	    {
	     alert("Please Select Atleast One Group or Mcat or Category");
	     return false;
	    }
	  }
	
	
	
	if(document.getElementById("check_category").innerHTML =='<b style="color:red;">Already Exist</b>' || document.getElementById("check_mcat1").innerHTML =='<b style="color:red;">Already Exist</b>' || document.getElementById("check_group").innerHTML =='<b style="color:red;">Already Exist</b>')
	{
	alert("Mapping Already Exist");
	return false;
	}
	}


	
	</script>
	
	
	
	
	<form name="addpoolForm" METHOD="post" STYLE="margin-top:0;margin-bottom:0;" ACTION="" onsubmit="return nextField1()">
	<table style="border-collapse: collapse;" border="1" bordercolor="#bedaff" cellpadding="4" cellspacing="0" width="" align="center">
	
	<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Pool Name:</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;<input type="text" name="poolname" id="poolname">
	</td>
	</tr>
	<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Group Name:</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">&nbsp;<select multiple name="grp[]" id="grp" style="width: 500px; height:150px;" onclick="checkgroup(this)">
	<?php
	while($rec=pg_fetch_array($sth_grp))
	{
	 $rec=array_change_key_case($rec, CASE_UPPER);
	echo ' <option value="'.$rec['GLCAT_GRP_ID'].'">'.$rec['GLCAT_GRP_SHORTNAME'].'</option>';
	}
	
	?>
	
	
	</select><div style="margin-left: 510px; margin-top: -10px;"><span id="check_group" style="width:500px"></div>
	</td>
	</tr>
	<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Sub Group: </b></td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">
	&nbsp;<input type="text" name="cattext" id="cattext" >
	&nbsp;<input type="button" value="submit"  onclick="catselect()"><br>
	<div id="check_catname"></div><div style="margin-left: 510px; margin-top:-10px;"><span id="check_category" style="width:500px"><div>
	
	</td>
	</tr>
	<tr>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff"><b>Mcat:</b> </td>
	<td class="intd" width="" style="text-align:left;font-family: arial;font-size: 12px;background-color:#eeffff">
	&nbsp;<input type="text" name="mcattext" id="mcattext" >
	&nbsp;<input type="button" value="submit"  onclick="mcatselect()"><br>
	<div id="check_mcatname"></div><div style="margin-left: 510px; margin-top: -10px;"><span id="check_mcat1" style="width:500px"></div>
	
	</td>
	</tr>
	<tr>
	<td colspan="2" style="text-align:center;">
	<input type="submit" value="ADD" name="submit">
	</td>
	</tr>
	
	
	<?php
	if(isset($_REQUEST['submit']))
	{
	
	echo '<div style=" margin-left: 800px; margin-top: 1px;"><b>'.$status.'</b></div>';
	}
	?>
	</table>
	</form>
	
	</body>
	</html>